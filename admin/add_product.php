<?php include '../db/db_connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['original_price'];
    $discount = $_POST['discount_price'];
    $desc = $_POST['description'];
    $page = $_POST['page_name'];
    $stock = $_POST['stock']; // 🆕 Stock input liya

    // image upload
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $image = $target_dir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $image);

    // insert query with stock
    $sql = "INSERT INTO products (product_name, product_image, original_price, discount_price, description, page_name, stock)
            VALUES ('$name', '$image', '$price', '$discount', '$desc', '$page', '$stock')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>✅ Product Added Successfully with Stock!</p>";
    } else {
        echo "<p style='color:red'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
    form { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
    input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; }
    button { background: #007bff; color: #fff; border: none; padding: 10px; cursor: pointer; }
    button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <h2>Add Product</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="product_name" placeholder="Product Name" required>
    <input type="file" name="product_image" required>
    <input type="number" step="0.01" name="original_price" placeholder="Original Price" required>
    <input type="number" step="0.01" name="discount_price" placeholder="Discount Price" required>
    <textarea name="description" placeholder="Description"></textarea>
    <select name="page_name">
      <option value="co-ord">Co-Ord Set</option>
      <option value="crop-top">Crop-Top</option>
      <option value="shortkurtis">Short-Kurtis</option>
    </select>
    
    <!-- 🆕 Stock input -->
    <input type="number" name="stock" placeholder="Enter Stock Quantity" required>

    <button type="submit">Add Product</button>
  </form>
</body>
</html>
