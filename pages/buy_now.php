<?php
include '../db/db_connect.php';
session_start();

$id = $_GET['id'] ?? 0;
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
  <title>Buy Now - <?php echo $product['product_name']; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
    .container { max-width: 900px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
    h2 { margin-bottom: 20px; }
    .product-summary { display: flex; align-items: center; margin-bottom: 20px; }
    .product-summary img { width: 120px; border-radius: 8px; margin-right: 20px; }
    .product-details { flex: 1; }
    .price { font-size: 20px; font-weight: bold; color: #e63946; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-weight: bold; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; }
    button { background: #e63946; color: #fff; padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
    button:hover { background: #d62828; }
    .order-summary { background: #f8f8f8; padding: 15px; border-radius: 8px; margin-top: 20px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Finalize Your Purchase</h2>

    <!-- Product Summary -->
    <div class="product-summary">
      <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
      <div class="product-details">
        <h3><?php echo $product['product_name']; ?></h3>
        <p class="price">₹<?php echo $product['discount_price']; ?></p>
        <p><del>₹<?php echo $product['original_price']; ?></del> 
           <strong><?php echo $product['discount_percent']; ?>% OFF</strong>
        </p>
      </div>
    </div>

    <!-- Purchase Form -->
    <form action="place_order.php" method="POST">
      <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
      <input type="hidden" name="price" value="<?php echo $product['discount_price']; ?>">

      <!-- Size Selection -->
      <div class="form-group">
        <label>Size</label>
        <select name="size" required>
          <option value="">Select Size</option>
          <option value="S">Small (S)</option>
          <option value="M">Medium (M)</option>
          <option value="L">Large (L)</option>
          <option value="XL">Extra Large (XL)</option>
        </select>
      </div>

      <!-- Quantity Selection -->
      <div class="form-group">
        <label>Quantity</label>
        <input type="number" name="quantity" value="1" min="1" required>
      </div>

      <!-- Customer Details -->
      <div class="form-group">
        <label>Your Name</label>
        <input type="text" name="customer_name" required>
      </div>

      <div class="form-group">
        <label>Mobile Number</label>
        <input type="text" name="customer_mobile" required>
      </div>

      <div class="form-group">
        <label>Delivery Address</label>
        <textarea name="customer_address" rows="3" required></textarea>
      </div>

      <!-- Payment Method -->
      <div class="form-group">
        <label>Payment Method</label>
        <select name="payment_method" required>
          <option value="cod">Cash on Delivery</option>
          <option value="razorpay">Pay Online (Razorpay)</option>
        </select>
      </div>

      <!-- Order Summary -->
      <div class="order-summary">
        <h4>Order Summary</h4>
        <p>Product: <?php echo $product['product_name']; ?></p>
        <p>Price (per item): ₹<?php echo $product['discount_price']; ?></p>
        <p>Delivery: Free</p>
        <p><strong>Total: ₹<?php echo $product['discount_price']; ?> x Qty</strong></p>
      </div>

      <button type="submit"><i class="fas fa-check-circle"></i> Confirm Purchase</button>
    </form>
  </div>
</body>
</html>
