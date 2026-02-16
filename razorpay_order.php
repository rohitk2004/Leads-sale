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
if (empty($input['amount'])) {
    echo json_encode(['error' => 'Amount required']);
    exit;
}

$amount = floatval($input['amount']);
if ($amount <= 0) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

$api_key = RAZORPAY_KEY_ID;
$api_secret = RAZORPAY_KEY_SECRET;

// Convert to paise (Razorpay uses currency subunits)
$amount_paise = $amount * 100;

try {
    $url = "https://api.razorpay.com/v1/orders";
    $data = [
        'amount' => $amount_paise,
        'currency' => 'INR',
        'receipt' => 'rcpt_' . time(),
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