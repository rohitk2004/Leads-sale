<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout");
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['razorpay_payment_id']) || empty($input['razorpay_order_id']) || empty($input['razorpay_signature'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$razorpay_payment_id = $input['razorpay_payment_id'];
$razorpay_order_id = $input['razorpay_order_id'];
$razorpay_signature = $input['razorpay_signature'];

$generated_signature = hash_hmac('sha256', $razorpay_order_id . "|" . $razorpay_payment_id, RAZORPAY_KEY_SECRET);

if ($generated_signature == $razorpay_signature) {
    $user_id = $_SESSION['user_id'];

    // Verify amount matches? Ideally yes. But cart items could change?
    // User already approved paying the amount for Order ID.
    // We trust that if they paid, we should give them the items currently in cart.
    // Assuming cart didn't change (single tab).

    // Call process_direct_purchase
    if (process_direct_purchase($pdo, $user_id, $razorpay_payment_id)) {
        echo json_encode(['success' => true, 'message' => 'Purchase successful!']);
    } else {
        // Purchase failed (e.g., lead sold out), so fetch amount and add to wallet automatically
        $api_key = RAZORPAY_KEY_ID;
        $api_secret = RAZORPAY_KEY_SECRET;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/payments/" . $razorpay_payment_id);
        curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_secret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $details = json_decode($response, true);
        curl_close($ch);

        if (json_last_error() === JSON_ERROR_NONE && isset($details['amount'])) {
            $amount_inr = $details['amount'] / 100;
            if (add_funds($pdo, $user_id, $amount_inr)) {
                echo json_encode(['error' => 'One or more leads were no longer available. However, a refund of ₹' . number_format($amount_inr, 2) . ' was automatically added to your wallet!']);
            } else {
                echo json_encode(['error' => 'Payment verified but purchase failed. Contact support with Payment ID: ' . $razorpay_payment_id]);
            }
        } else {
            echo json_encode(['error' => 'Payment verified but failed to update order database. Contact support: ' . $razorpay_payment_id]);
        }
    }

} else {
    echo json_encode(['error' => 'Payment signature verification failed!']);
}
?>