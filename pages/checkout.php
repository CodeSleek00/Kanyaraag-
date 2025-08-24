<?php
include '../db/db_connect.php';

// Get product_id and quantity from GET (or set defaults)
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$quantity = isset($_GET['qty']) ? intval($_GET['qty']) : 1;
$size = isset($_GET['size']) ? $_GET['size'] : '';

// Fetch product details
$product = null;
if ($product_id) {
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

// Calculate subtotal and total
$subtotal = $product ? $product['discount_price'] * $quantity : 0;
$cod_fee = 0;
$total = $subtotal;

// Handle form submit
$order_confirmed = false;
$order_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $pincode = $conn->real_escape_string($_POST['pincode']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $payment_method = $_POST['payment_method'];
    $size = $conn->real_escape_string($_POST['size']);
    $cod_fee = ($payment_method === 'cod') ? 49 : 0;
    $total = $subtotal + $cod_fee;
    $payment_status = ($payment_method === 'cod') ? 'pending' : 'pending'; // Razorpay will update to 'paid' after verification

    // Insert order (for now, only COD is confirmed directly)
    $sql = "INSERT INTO orders (product_id, user_name, address, city, state, pincode, phone, quantity, size, payment_method, payment_status, subtotal, cod_fee, total) VALUES ('$product_id', '$user_name', '$address', '$city', '$state', '$pincode', '$phone', '$quantity', '$size', '$payment_method', '$payment_status', '$subtotal', '$cod_fee', '$total')";
    if ($conn->query($sql)) {
        if ($payment_method === 'cod') {
            $order_confirmed = true;
        } else {
            // Razorpay: redirect to payment (to be implemented)
            header('Location: razorpay_order.php?order_id=' . $conn->insert_id);
            exit;
        }
    } else {
        $order_error = 'Order could not be placed. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin:0; }
    .header { background: #222; color: #fff; padding: 20px; text-align: center; }
    .checkout-container { max-width: 1100px; margin: 30px auto; display: flex; gap: 30px; }
    .left, .right { background: #fff; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .left { flex: 2; }
    .right { flex: 1; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; }
    input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
    .payment-section { margin: 20px 0; }
    .policies { margin-top: 30px; }
    .policies a { display: block; color: #555; margin-bottom: 5px; text-decoration: underline; }
    .order-summary img { max-width: 100px; border-radius: 8px; }
    .order-summary { text-align: center; }
    .order-summary h3 { margin: 10px 0 5px; }
    .order-summary .row { display: flex; justify-content: space-between; margin: 8px 0; }
    .total { font-weight: bold; font-size: 18px; color: #e53935; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
  </style>
</head>
<body>
  <div class="header">
    <h1>Checkout</h1>
  </div>
  <div class="checkout-container">
    <!-- LEFT SIDE: FORM & PAYMENT -->
    <div class="left">
      <?php if ($order_confirmed): ?>
        <div class="success">Your COD order has been placed! Thank you.</div>
      <?php else: ?>
        <?php if ($order_error): ?><div class="error"><?php echo $order_error; ?></div><?php endif; ?>
        <form method="POST">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="user_name" required>
          </div>
          <div class="form-group">
            <label>Address</label>
            <textarea name="address" required></textarea>
          </div>
          <div class="form-group">
            <label>City</label>
            <input type="text" name="city" required>
          </div>
          <div class="form-group">
            <label>State</label>
            <input type="text" name="state" required>
          </div>
          <div class="form-group">
            <label>Pincode</label>
            <input type="text" name="pincode" required>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" required>
          </div>
          <div class="form-group">
            <label>Size</label>
            <select name="size" required>
              <option value="">Select Size</option>
              <option>XS</option><option>S</option><option>M</option>
              <option>L</option><option>XL</option><option>XXL</option><option>XXXL</option>
            </select>
          </div>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" max="<?php echo $product ? $product['stock'] : 1; ?>" required>
          </div>
          <div class="payment-section">
            <label>Payment Method</label>
            <input type="radio" name="payment_method" value="razorpay" required> Razorpay
            <input type="radio" name="payment_method" value="cod" required> Cash on Delivery (COD)
          </div>
          <button type="submit" name="place_order">Buy Now</button>
        </form>
        <div class="policies">
          <a href="#">Refund Policy</a>
          <a href="#">Shipping Policy</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
        </div>
      <?php endif; ?>
    </div>
    <!-- RIGHT SIDE: ORDER SUMMARY -->
    <div class="right order-summary">
      <?php if ($product): ?>
        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
        <h3><?php echo $product['product_name']; ?></h3>
        <div class="row"><span>Subtotal</span><span>₹<?php echo $subtotal; ?></span></div>
        <?php if (isset($_POST['payment_method']) && $_POST['payment_method'] === 'cod'): ?>
          <div class="row"><span>COD Fee</span><span>₹49</span></div>
        <?php endif; ?>
        <div class="row total"><span>Total</span><span>₹<?php echo $total; ?></span></div>
      <?php else: ?>
        <div class="error">Product not found.</div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
