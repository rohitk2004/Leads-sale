<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = get_cart_items($pdo);

if (empty($cart_items)) {
    echo json_encode(['error' => 'Cart is empty']);
    exit;
}

$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['lead_price'];
}

if ($total_amount <= 0) {
    echo json_encode(['error' => 'Invalid cart total']);
    exit;
}

$api_key = RAZORPAY_KEY_ID;
$api_secret = RAZORPAY_KEY_SECRET;

// Convert to paise
$amount_paise = $total_amount * 100;

try {
    $url = "https://api.razorpay.com/v1/orders";
    $data = [
        'amount' => $amount_paise,
        'currency' => 'INR',
        'receipt' => 'checkout_' . time(),
        'payment_capture' => 1
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_secret);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if ($curl_error) {
        throw new Exception("cURL Error: " . $curl_error);
    }

    if ($http_status != 200) {
        throw new Exception("Razorpay API Error: " . $response);
    }

    // Return the full JSON response from Razorpay
    echo $response;

} catch (Exception $e) {
    echo json_encode(['error' => 'Order creation failed: ' . $e->getMessage()]);
}
?>