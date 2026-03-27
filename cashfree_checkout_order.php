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

$app_id = CASHFREE_APP_ID;
$secret_key = CASHFREE_SECRET_KEY;
$order_id = 'order_' . time() . '_' . rand(1000, 9999);

$customer_id = 'cust_' . $user_id;
$customer_name = $_SESSION['username'] ?? 'Customer';
$customer_phone = $_SESSION['phone'] ?? '9999999999';

$data = [
    'order_amount' => $total_amount,
    'order_currency' => 'INR',
    'order_id' => $order_id,
    'customer_details' => [
        'customer_id' => $customer_id,
        'customer_name' => $customer_name,
        'customer_phone' => $customer_phone
    ]
];

try {
    $url = "https://sandbox.cashfree.com/pg/orders";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "x-api-version: 2023-08-01",
        "x-client-id: $app_id",
        "x-client-secret: $secret_key"
    ]);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        throw new Exception("cURL Error: " . $curl_error);
    }

    if ($http_status != 200) {
        // Log error if needed
        throw new Exception("Cashfree API Error: " . $response);
    }

    $response_data = json_decode($response, true);
    if(isset($response_data['payment_session_id'])) {
        echo json_encode(['payment_session_id' => $response_data['payment_session_id'], 'order_id' => $order_id, 'amount' => $total_amount]);
    } else {
        throw new Exception("Cashfree Payment Session missing: " . $response);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Order creation failed: ' . $e->getMessage()]);
}
?>
