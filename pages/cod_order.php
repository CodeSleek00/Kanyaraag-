<?php
include("db.php");

$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$pincode = $_POST['pincode'];
$phone = $_POST['phone'];
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_image = $_POST['product_image'];
$subtotal = $_POST['subtotal'];

$shipping = 49;
$total = $subtotal + $shipping;

$sql = "INSERT INTO orders (name, address, city, state, pincode, phone, product_id, product_name, product_image, subtotal, shipping, total, payment_method, payment_status)
        VALUES ('$name','$address','$city','$state','$pincode','$phone','$product_id','$product_name','$product_image','$subtotal','$shipping','$total','cod','cod_confirmed')";
if(mysqli_query($conn,$sql)){
  echo "Order placed successfully with Cash on Delivery!";
} else {
  echo "Error: ".mysqli_error($conn);
}
