<?php include '../db/db_connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['original_price'];
    $discount = $_POST['discount_price'];
    $desc = $_POST['description'];
    $page = $_POST['page_name'];
    $stock = $_POST['stock'];
    $color = $_POST['color'];
    $fabric = $_POST['fabric'];

    // image upload (multiple)
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);

    $uploaded_images = [];
    foreach ($_FILES['product_images']['name'] as $key => $val) {
        if ($_FILES['product_images']['error'][$key] === 0) {
            $file_name = time() . "_" . basename($_FILES['product_images']['name'][$key]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES['product_images']['tmp_name'][$key], $target_file)) {
                $uploaded_images[] = $target_file;
            }
        }
    }

    // convert images array to JSON
    $images_json = json_encode($uploaded_images);

    // insert query with stock, color, fabric, images
    $sql = "INSERT INTO products 
            (product_name, original_price, discount_price, description, page_name, stock, color, fabric, images)
            VALUES 
            ('$name', '$price', '$discount', '$desc', '$page', '$stock', '$color', '$fabric', '$images_json')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>✅ Product Added Successfully with Multiple Images!</p>";
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

    <!-- multiple images input -->
    <input type="file" name="product_images[]" multiple required>

    <input type="number" step="0.01" name="original_price" placeholder="Original Price" required>
    <input type="number" step="0.01" name="discount_price" placeholder="Discount Price" required>
    <textarea name="description" placeholder="Description"></textarea>

    <select name="page_name">
      <option value="co-ord">Co-Ord Set</option>
      <option value="crop-top">Crop-Top</option>
      <option value="shortkurtis">Short-Kurtis</option>
    </select>

    <input type="number" name="stock" placeholder="Enter Stock Quantity" required>
    <input type="text" name="color" placeholder="Enter Color" required>
    <input type="text" name="fabric" placeholder="Enter Fabric" required>

    <button type="submit">Add Product</button>
  </form>
</body>
</html>
