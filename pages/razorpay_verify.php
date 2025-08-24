<?php
require 'vendor/autoload.php';
use Razorpay\Api\Api;

$api = new Api("rzp_live_pA6jgjncp78sq7", "YOUR_SECRET_KEY");

$data = json_decode(file_get_contents("php://input"), true);

try {
  $attributes = array(
    'razorpay_order_id' => $data['razorpay_order_id'],
    'razorpay_payment_id' => $data['razorpay_payment_id'],
    'razorpay_signature' => $data['razorpay_signature']
  );
  $api->utility->verifyPaymentSignature($attributes);
  echo "Payment successful and order confirmed!";
} catch(Exception $e) {
  echo "Payment verification failed!";
}
