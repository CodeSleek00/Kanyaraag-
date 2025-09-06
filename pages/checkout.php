<?php
include '../db/db_connect.php';
session_start();

$id = $_GET['id'] ?? 0;
$size = $_GET['size'] ?? '';
$color = $_GET['color'] ?? '';

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - <?php echo $product['product_name']; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {font-family: Arial, sans-serif; margin:0; padding:0; background:#f4f4f4;}
    .container {max-width: 1000px; margin:30px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);}
    h2 {margin-bottom:20px;}
    .checkout-wrapper {display:flex; gap:20px; flex-wrap:wrap;}
    .product-summary, .checkout-form {flex:1; min-width:300px;}
    .product-summary img {width:100%; max-width:200px; border-radius:10px;}
    .summary-box {border:1px solid #ddd; padding:15px; border-radius:10px;}
    .summary-box h3 {margin:0 0 10px;}
    .form-group {margin-bottom:15px;}
    label {display:block; margin-bottom:5px; font-weight:600;}
    input, textarea {width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;}
    button {background:#28a745; color:#fff; padding:12px 20px; border:none; border-radius:8px; cursor:pointer; font-size:16px;}
    button:hover {background:#218838;}
  </style>
</head>
<body>
<div class="container">
  <h2>Checkout</h2>
  <div class="checkout-wrapper">

    <!-- Product Summary -->
    <div class="product-summary">
      <div class="summary-box">
        <h3>Order Summary</h3>
        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
        <p><strong><?php echo $product['product_name']; ?></strong></p>
        <p>Price: ₹<?php echo $product['discount_price']; ?></p>
        <?php if ($size): ?><p>Size: <?php echo htmlspecialchars($size); ?></p><?php endif; ?>
        <?php if ($color): ?><p>Color: <?php echo htmlspecialchars($color); ?></p><?php endif; ?>
        <p>Quantity: 1</p>
        <hr>
        <p><strong>Total: ₹<?php echo $product['discount_price']; ?></strong></p>
      </div>
    </div>

    <!-- Checkout Form -->
    <div class="checkout-form">
      <form action="place_order.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="size" value="<?php echo htmlspecialchars($size); ?>">
        <input type="hidden" name="color" value="<?php echo htmlspecialchars($color); ?>">
        <input type="hidden" name="price" value="<?php echo $product['discount_price']; ?>">

        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="customer_name" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="customer_email" required>
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" name="customer_phone" required>
        </div>
        <div class="form-group">
          <label>Address</label>
          <textarea name="customer_address" required></textarea>
        </div>

        <button type="submit">Place Order</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
