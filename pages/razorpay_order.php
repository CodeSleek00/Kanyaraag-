<?php
require 'vendor/autoload.php';
use Razorpay\Api\Api;

$api = new Api("rzp_live_pA6jgjncp78sq7", "YOUR_SECRET_KEY");

$product_name = $_POST['product_name'];
$subtotal = $_POST['subtotal'];

$orderData = [
    'receipt'         => 'rcptid_'.time(),
    'amount'          => $subtotal * 100, // in paise
    'currency'        => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);

echo json_encode([
  "razorpay_order_id" => $razorpayOrder['id'],
  "amount" => $orderData['amount'],
  "product_name" => $product_name
]);
