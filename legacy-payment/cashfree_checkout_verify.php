<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout");
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['order_id'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$order_id = $input['order_id'];

// Verify order status with Cashfree
$app_id = CASHFREE_APP_ID;
$secret_key = CASHFREE_SECRET_KEY;

try {
    $url = "https://api.cashfree.com/pg/orders/" . $order_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-api-version: 2023-08-01",
        "x-client-id: $app_id",
        "x-client-secret: $secret_key"
    ]);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_status != 200) {
        throw new Exception("Cashfree Error fetching order status.");
    }

    $order_data = json_decode($response, true);
    
    // Check if payment is successful
    if (isset($order_data['order_status']) && $order_data['order_status'] === 'PAID') {
        $user_id = $_SESSION['user_id'];
        
        // Fetch payment details associated with the order to get the payment ID
        // Or we just use Cashfree's order_id as the payment reference
        // Our process_direct_purchase uses payment_id
        $payment_id = $order_id; // Let's use order_id as payment reference
        
        if (process_direct_purchase($pdo, $user_id, $payment_id)) {
            echo json_encode(['success' => true, 'message' => 'Purchase successful!']);
        } else {
            // Purchase failed (lead sold out), add refund to wallet
            $amount_inr = floatval($order_data['order_amount']);
            if (add_funds($pdo, $user_id, $amount_inr)) {
                 echo json_encode(['error' => 'One or more leads were no longer available. However, a refund of ₹' . number_format($amount_inr, 2) . ' was automatically added to your wallet!']);
            } else {
                 echo json_encode(['error' => 'Payment verified but purchase failed. Contact support with Order ID: ' . $order_id]);
            }
        }
    } else {
         echo json_encode(['error' => 'Payment not successful or pending.']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Payment verification failed: ' . $e->getMessage()]);
}
?>
