<?php
include '../db/db_connect.php';

// Razorpay SDK
require 'vendor/autoload.php';
use Razorpay\Api\Api; // MUST be after require, at top

$total = $_POST['total'];
$payment_method = $_POST['payment_method'];

// Generate unique order id
$order_id = "ORDER_".time();

// For simplicity, using single product example
$product_id = 1; 
$product_name = "Test Product";
$product_price = $total;
$qty = 1;

// Insert order in DB
$stmt = $conn->prepare("INSERT INTO orders(order_id, product_id, product_name, product_price, qty, total_price, payment_method) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("siidids", $order_id, $product_id, $product_name, $product_price, $qty, $total, $payment_method);
$stmt->execute();

if($payment_method=="COD"){
    $stmt->close();
    echo "✅ Order placed successfully! Order ID: $order_id. Payment: Cash on Delivery.";
} else {
    // Razorpay Payment Integration
    $keyId = "rzp_ive_pA6jgjncp78sq7";
    $keySecret = "YOUR_KEY_SECRET";

    $api = new Api($keyId, $keySecret);

    $orderData = [
        'receipt'         => $order_id,
        'amount'          => $total*100, // in paise
        'currency'        => 'INR',
        'payment_capture' => 1
    ];

    $razorpayOrder = $api->order->create($orderData);

    $razorpayOrderId = $razorpayOrder['id'];

    // Redirect to payment page
    header("Location: razorpay_payment.php?order_id=$order_id&razorpay_order_id=$razorpayOrderId&amount=$total");
}
?>
