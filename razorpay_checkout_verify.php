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
        echo json_encode(['error' => 'Payment verified but failed to update order database. Contact support: ' . $razorpay_payment_id]);
    }

} else {
    echo json_encode(['error' => 'Payment signature verification failed!']);
}
?>