<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['amount']) || !is_numeric($input['amount']) || $input['amount'] <= 0) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

$amount = floatval($input['amount']);
$user_id = $_SESSION['user_id'];

$app_id = CASHFREE_APP_ID;
$secret_key = CASHFREE_SECRET_KEY;
$order_id = 'wallet_' . time() . '_' . rand(1000, 9999);

$customer_id = 'cust_' . $user_id;
$customer_name = $_SESSION['username'] ?? 'Customer';
$customer_phone = $_SESSION['phone'] ?? '9999999999';

$data = [
    'order_amount' => $amount,
    'order_currency' => 'INR',
    'order_id' => $order_id,
    'customer_details' => [
        'customer_id' => $customer_id,
        'customer_name' => $customer_name,
        'customer_phone' => $customer_phone
    ]
];

try {
    $url = "https://api.cashfree.com/pg/orders";

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
        throw new Exception("Cashfree API Error: " . $response);
    }

    $response_data = json_decode($response, true);
    if(isset($response_data['payment_session_id'])) {
        echo json_encode(['payment_session_id' => $response_data['payment_session_id'], 'order_id' => $order_id, 'amount' => $amount]);
    } else {
        throw new Exception("Cashfree Payment Session missing: " . $response);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Order creation failed: ' . $e->getMessage()]);
}
?>
