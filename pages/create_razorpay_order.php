<?php
// create_razorpay_order.php
header('Content-Type: application/json');
include '../db/db_connect.php';
session_start();

// set these securely (do not hardcode in production)
define('RAZORPAY_KEY', 'rzp_live_pA6jgjncp78sq7'); // replace with your key
define('RAZORPAY_SECRET', 'YOUR_RAZORPAY_SECRET_HERE');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success'=>false, 'message'=>'Invalid request']);
  exit;
}

// read form fields
$first = $_POST['first'] ?? '';
$last = $_POST['last'] ?? '';
$contact = $_POST['contact'] ?? '';
$cart_json = $_POST['cart_payload'] ?? '';

if (!$cart_json) {
  echo json_encode(['success'=>false, 'message'=>'Cart missing']);
  exit;
}
$cartData = json_decode($cart_json, true);
if (!$cartData) {
  echo json_encode(['success'=>false, 'message'=>'Invalid cart payload']);
  exit;
}

$total = floatval($cartData['total'] ?? 0); // rupees
if ($total <= 0) {
  echo json_encode(['success'=>false, 'message'=>'Invalid amount']);
  exit;
}

// Create our own DB order first with payment_method = RAZORPAY and status PENDING
$our_order_id = 'ORD_' . time() . '_' . strtoupper(bin2hex(random_bytes(3)));

$payment_method = 'RAZORPAY';
$payment_status = 'PENDING';

$stmt = $conn->prepare("INSERT INTO orders (order_id, user_first, user_last, contact, apartment, city, state, pincode, payment_method, payment_status, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
  echo json_encode(['success'=>false, 'message'=>'DB prepare failed: '.$conn->error]);
  exit;
}
$apartment = $_POST['apartment'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$pincode = $_POST['pincode'] ?? '';
$stmt->bind_param('ssssssssssd', $our_order_id, $first, $last, $contact, $apartment, $city, $state, $pincode, $payment_method, $payment_status, $total);
$stmt->execute();
$order_db_id = $stmt->insert_id;
$stmt->close();

// Prepare Razorpay order creation
$amount_paise = intval(round($total * 100)); // amount in paise
$payload = [
  'amount' => $amount_paise,
  'currency' => 'INR',
  'receipt' => $our_order_id,
  'payment_capture' => 1
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders");
curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY . ":" . RAZORPAY_SECRET);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if(curl_errno($ch)) {
  // cleanup: remove DB order
  $conn->query("DELETE FROM orders WHERE id = $order_db_id");
  echo json_encode(['success'=>false, 'message'=>'Curl error: '.curl_error($ch)]);
  curl_close($ch);
  exit;
}
curl_close($ch);

$resp = json_decode($response, true);
if ($httpcode !== 200 && $httpcode !== 201) {
  // cleanup
  $conn->query("DELETE FROM orders WHERE id = $order_db_id");
  echo json_encode(['success'=>false, 'message'=>'Razorpay API error', 'raw'=>$resp]);
  exit;
}

// save razorpay_order_id in our DB record
$razorpay_order_id = $resp['id'] ?? null;
if ($razorpay_order_id) {
  $conn->query("UPDATE orders SET razorpay_order_id = '".$conn->real_escape_string($razorpay_order_id)."' WHERE id = $order_db_id");
}

echo json_encode([
  'success' => true,
  'key' => RAZORPAY_KEY,
  'razorpay_order_id' => $razorpay_order_id,
  'amount' => $amount_paise,
  'currency' => 'INR',
  'our_order_id' => $our_order_id
]);
exit;
