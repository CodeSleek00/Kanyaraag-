<?php
include '../db/db_connect.php';

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$razorpay_payment_id = isset($_POST['razorpay_payment_id']) ? $_POST['razorpay_payment_id'] : '';
$razorpay_signature = isset($_POST['razorpay_signature']) ? $_POST['razorpay_signature'] : '';

// TODO: Add real signature verification here using Razorpay secret
$verified = !empty($razorpay_payment_id); // For now, just check payment_id exists

if ($order_id && $verified) {
    $sql = "UPDATE orders SET payment_status='paid', razorpay_payment_id='$razorpay_payment_id' WHERE id=$order_id";
    $conn->query($sql);
    $msg = 'Payment successful! Your order is confirmed.';
} else {
    $msg = 'Payment verification failed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Payment Status</title></head>
<body>
  <h2><?php echo $msg; ?></h2>
  <a href="../index.php">Go to Home</a>
</body>
</html>
