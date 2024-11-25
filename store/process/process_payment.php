<?php

use PayPal\Api\Payment;

require_once "../Classes/Checkout.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'];
$amount = floatval($_POST['amount']);
$address = trim($_POST['address']);

// Validate inputs
if (empty($payment_method) || empty($amount) || empty($address)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit();
}

// Initialize Checkout class
$orders = new Checkout();

if ($payment_method === 'cash') {
    // Save COD order
    $order_id = $orders->save_order($user_id, $amount, $payment_method, "pending", "pending", $address);

    foreach ($_SESSION['cart'] as $item) {
        $orders->save_order_list($order_id, $item['id'], $item['qty'], $item['price']);
    }

    unset($_SESSION['cart_quantity']);
    unset($_SESSION['cart']);
    echo json_encode(['success' => true, 'message' => 'Order placed successfully.']);
} elseif ($payment_method === 'paypal') {
    $transaction_id = $_POST['transaction_id'] ?? '';
    $payer_email = $_POST['payer_email'] ?? '';

    // Save PayPal order
    $order_id = $orders->save_order($user_id, $amount, $payment_method, "processing", "completed", $address);

    foreach ($_SESSION['cart'] as $item) {
        $orders->save_order_list($order_id, $item['id'], $item['qty'], $item['price']);
    }

    unset($_SESSION['cart_quantity']);
    unset($_SESSION['cart']);
    echo json_encode(['success' => true, 'message' => 'Payment successful.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Unsupported payment method.']);
}
