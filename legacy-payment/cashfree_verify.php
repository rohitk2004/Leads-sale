<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: developer_dashboard.php");
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['order_id'])) {
    echo json_encode(['error' => 'Missing order ID']);
    exit;
}

$order_id = $input['order_id'];

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
        throw new Exception("Cashfree Error fetching order");
    }

    $order_data = json_decode($response, true);
    
    if (isset($order_data['order_status']) && $order_data['order_status'] === 'PAID') {
        $amount_inr = floatval($order_data['order_amount']);
        $user_id = $_SESSION['user_id'];

        if (add_funds($pdo, $user_id, $amount_inr)) {
            echo json_encode(['success' => true, 'message' => 'Funds added successfully!']);
        } else {
            echo json_encode(['error' => 'Failed to add funds to database. Order ID: ' . $order_id]);
        }
    } else {
        echo json_encode(['error' => 'Payment not successful. Status: ' . ($order_data['order_status'] ?? 'Unknown')]);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Payment verification failed: ' . $e->getMessage()]);
}
?>
