<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: developer_dashboard.php");
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
    // Payment verified successfully
    // Get the amount. In a real app, verify amount from DB or Razorpay API
    // Here we'll trust the user to send the amount (NOT SECURE if client injects it, but for demo we can get it from session or passed)
    // Actually, we should call Razorpay API to fetch payment details and verify amount.

    $user_id = $_SESSION['user_id'];

    // Fetch payment details to confirm amount
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
        $amount_paise = $details['amount'];
        $amount_inr = $amount_paise / 100;

        if (add_funds($pdo, $user_id, $amount_inr)) {
            // Success
            // Also log specific Razorpay details if needed (we already log 'Wallet Top-up' in transaction table via add_funds logic)
            // But we can update the description maybe?
            // For now, standard add_funds is enough.
            echo json_encode(['success' => true, 'message' => 'Funds added successfully!']);
        } else {
            echo json_encode(['error' => 'Failed to add funds to database. Contact support with Payment ID: ' . $razorpay_payment_id]);
        }
    } else {
        echo json_encode(['error' => 'Failed to verify payment amount with Razorpay.']);
    }

} else {
    echo json_encode(['error' => 'Payment signature verification failed!']);
}
?>