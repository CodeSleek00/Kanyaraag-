<?php
session_start();
include '../db/db_connect.php';

// Get product ID
$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    die("Invalid product");
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $size = $_POST['size'] ?? '';
    $color = $_POST['color'] ?? '';
    $qty = (int)($_POST['qty'] ?? 1);

    if ($name && $phone && $address && $size) {
        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (product_id, customer_name, email, phone, address, size, color, qty, total_amount, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        $totalAmount = $product['discount_price'] * $qty;
        $stmt->bind_param("isssssidi", $id, $name, $email, $phone, $address, $size, $color, $qty, $totalAmount);
        $stmt->execute();

        $orderId = $stmt->insert_id;
        header("Location: thank_you.php?order_id=".$orderId);
        exit;
    } else {
        $error = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Buy Now - <?php echo $product['product_name']; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
    .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
    .product { display: flex; gap: 20px; margin-bottom: 20px; }
    .product img { max-width: 200px; border-radius: 8px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; font-weight: bold; margin-bottom: 5px; }
    input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px; }
    button { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; }
    button:hover { background: #0056b3; }
    .error { color: red; margin-bottom: 10px; }
  </style>
</head>
<body>
<div class="container">
  <h2>Buy Now</h2>
  <div class="product">
    <img src="<?php echo $product['product_image']; ?>" alt="">
    <div>
      <h3><?php echo $product['product_name']; ?></h3>
      <p><strong>Price: </strong>₹<?php echo $product['discount_price']; ?> <del>₹<?php echo $product['original_price']; ?></del></p>
      <p><strong>Available Sizes:</strong> <?php echo implode(', ', explode(',', $product['sizes'])); ?></p>
      <p><strong>Available Colors:</strong> <?php echo $product['colors'] ?: 'Default'; ?></p>
    </div>
  </div>

  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="POST">
    <div class="form-group">
      <label>Full Name*</label>
      <input type="text" name="name" required>
    </div>
    <div class="form-group">
      <label>Email (optional)</label>
      <input type="email" name="email">
    </div>
    <div class="form-group">
      <label>Phone*</label>
      <input type="text" name="phone" required>
    </div>
    <div class="form-group">
      <label>Address*</label>
      <textarea name="address" required></textarea>
    </div>
    <div class="form-group">
      <label>Size*</label>
      <select name="size" required>
        <option value="">Select Size</option>
        <?php
          $available_sizes = explode(',', $product['sizes']);
          foreach($available_sizes as $size) {
              echo "<option value='$size'>$size</option>";
          }
        ?>
      </select>
    </div>
    <?php if (!empty($product['colors'])): ?>
    <div class="form-group">
      <label>Color</label>
      <select name="color">
        <?php
          $colors = explode(',', $product['colors']);
          foreach($colors as $color) {
              echo "<option value='$color'>$color</option>";
          }
        ?>
      </select>
    </div>
    <?php endif; ?>
    <div class="form-group">
      <label>Quantity</label>
      <input type="number" name="qty" min="1" value="1">
    </div>
    <button type="submit"><i class="fas fa-bolt"></i> Place Order</button>
  </form>
</div>
</body>
</html>
