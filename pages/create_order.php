<?php
// create_order.php
header('Content-Type: application/json');
include '../db/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success'=>false, 'message'=>'Invalid request']);
  exit;
}

// read fields
$first = $_POST['first'] ?? '';
$last = $_POST['last'] ?? '';
$contact = $_POST['contact'] ?? '';
$apartment = $_POST['apartment'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$pincode = $_POST['pincode'] ?? '';
$cart_json = $_POST['cart_payload'] ?? '';

if (!$cart_json) {
  echo json_encode(['success'=>false, 'message'=>'Cart missing']);
  exit;
}

$cartData = json_decode($cart_json, true);
if (!$cartData || !isset($cartData['cart'])) {
  echo json_encode(['success'=>false, 'message'=>'Invalid cart data']);
  exit;
}

$subtotal = floatval($cartData['subtotal'] ?? 0);
$shipping = floatval($cartData['shipping'] ?? 0);
$total = floatval($cartData['total'] ?? ($subtotal + $shipping));

// generate order id
$our_order_id = 'ORD_' . time() . '_' . strtoupper(bin2hex(random_bytes(3)));

$payment_method = 'COD';
$payment_status = 'PENDING';

// insert into orders
$stmt = $conn->prepare("INSERT INTO orders (order_id, user_first, user_last, contact, apartment, city, state, pincode, payment_method, payment_status, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
  echo json_encode(['success'=>false, 'message'=>'DB prepare failed: '.$conn->error]);
  exit;
}
$stmt->bind_param('ssssssssssd', $our_order_id, $first, $last, $contact, $apartment, $city, $state, $pincode, $payment_method, $payment_status, $total);
$ok = $stmt->execute();
if (!$ok) {
  echo json_encode(['success'=>false, 'message'=>'DB insert failed: '.$stmt->error]);
  exit;
}
$order_db_id = $stmt->insert_id;
$stmt->close();

// insert items
$ins = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, qty, size, color, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
if(!$ins) {
  // rollback
  $conn->query("DELETE FROM orders WHERE id = $order_db_id");
  echo json_encode(['success'=>false, 'message'=>'DB prepare failed: '.$conn->error]);
  exit;
}

foreach ($cartData['cart'] as $it) {
  $name = $conn->real_escape_string($it['name'] ?? '');
  $price = floatval($it['price'] ?? 0);
  $qty = intval($it['qty'] ?? 1);
  $size = $it['size'] ?? null;
  $color = $it['color'] ?? null;
  $image = $it['image'] ?? null;
  $ins->bind_param('isdisds', $order_db_id, $name, $price, $qty, $size, $color, $image);
  $ins->execute();
}
$ins->close();

// respond
echo json_encode(['success'=>true, 'order_id'=>$our_order_id, 'db_id'=>$order_db_id]);
exit;
