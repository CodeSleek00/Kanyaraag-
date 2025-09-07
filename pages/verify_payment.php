<?php
// verify_payment.php
header('Content-Type: application/json');
include '../db/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success'=>false, 'message'=>'Invalid request']);
  exit;
}

$razorpay_payment_id = $_POST['razorpay_payment_id'] ?? '';
$razorpay_order_id = $_POST['razorpay_order_id'] ?? '';
$razorpay_signature = $_POST['razorpay_signature'] ?? '';
$our_order_id = $_POST['our_order_id'] ?? '';

if (!$razorpay_payment_id || !$razorpay_order_id || !$razorpay_signature || !$our_order_id) {
  echo json_encode(['success'=>false, 'message'=>'Missing params']);
  exit;
}

define('RAZORPAY_KEY', 'rzp_live_pA6jgjncp78sq7'); // same key
define('RAZORPAY_SECRET', 'YOUR_RAZORPAY_SECRET_HERE');

// verify signature: HMAC_SHA256(order_id + '|' + payment_id, secret) should equal signature
$check = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, RAZORPAY_SECRET);

if ($check !== $razorpay_signature) {
  // mark the order as FAILED
  $conn->query("UPDATE orders SET payment_status = 'FAILED', razorpay_payment_id = '".$conn->real_escape_string($razorpay_payment_id)."', razorpay_signature = '".$conn->real_escape_string($razorpay_signature)."' WHERE order_id = '".$conn->real_escape_string($our_order_id)."'");
  echo json_encode(['success'=>false, 'message'=>'Signature mismatch']);
  exit;
}

// signature valid -> update order as PAID and save payment id
$conn->query("UPDATE orders SET payment_status = 'PAID', razorpay_payment_id = '".$conn->real_escape_string($razorpay_payment_id)."', razorpay_signature = '".$conn->real_escape_string($razorpay_signature)."' WHERE order_id = '".$conn->real_escape_string($our_order_id)."'");

// Optionally, insert order_items from cart payload (if not inserted earlier). But in our flow we created an order row earlier and left items insertion to be done here or earlier. For completeness, if you saved cart earlier in session or DB, add items. For now, we assume items were added later by admin or you can extend this endpoint to also insert items into order_items table.

echo json_encode(['success'=>true, 'order_id' => $our_order_id]);
exit;
