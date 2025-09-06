<?php
include '../db/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data collect
    $product_id = (int) $_POST['product_id'];
    $price = (float) $_POST['price'];
    $name = $conn->real_escape_string($_POST['customer_name']);
    $mobile = $conn->real_escape_string($_POST['customer_mobile']);
    $address = $conn->real_escape_string($_POST['customer_address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    // Order ID generate (unique string)
    $order_id = "ORDER_" . time() . "_" . rand(1000, 9999);
    $size = $conn->real_escape_string($_POST['size']);
$quantity = (int) $_POST['quantity'];

// total price calculate
$total = $price * $quantity;

$sql = "INSERT INTO orders 
(order_id, product_id, customer_name, customer_mobile, customer_address, size, quantity, total_amount, payment_method, status, created_at) 
VALUES 
('$order_id', '$product_id', '$name', '$mobile', '$address', '$size', '$quantity', '$total', '$payment_method', 'Pending', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Redirect to thank you page with order id
        header("Location: thank_you.php?order_id=" . urlencode($order_id));
        exit;
    } else {
        echo "Error while placing order: " . $conn->error;
    }
} else {
    echo "Invalid Request!";
}
?>
