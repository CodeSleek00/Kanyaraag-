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

    // Sizes from checkboxes
    $sizes = !empty($_POST['sizes']) ? implode(',', $_POST['sizes']) : '';

    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);

    // main product image (single)
    $main_image = "";
    if (!empty($_FILES["product_image"]["name"])) {
        $file_name = time() . "_main_" . basename($_FILES["product_image"]["name"]);
        $main_image = $target_dir . $file_name;
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $main_image);
    }

    // extra images (multiple)
    $uploaded_images = [];
    if (!empty($_FILES['extra_images']['name'][0])) {
        foreach ($_FILES['extra_images']['name'] as $key => $val) {
            if ($_FILES['extra_images']['error'][$key] === 0) {
                $file_name = time() . "_" . basename($_FILES['extra_images']['name'][$key]);
                $target_file = $target_dir . $file_name;
                if (move_uploaded_file($_FILES['extra_images']['tmp_name'][$key], $target_file)) {
                    $uploaded_images[] = $target_file;
                }
            }
        }
    }
    $images_json = json_encode($uploaded_images);

    // insert query
    $sql = "INSERT INTO products 
            (product_name, product_image, original_price, discount_price, description, page_name, stock, color, fabric, sizes, images)
            VALUES 
            ('$name', '$main_image', '$price', '$discount', '$desc', '$page', '$stock', '$color', '$fabric', '$sizes', '$images_json')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>✅ Product Added Successfully!</p>";
    } else {
        echo "<p style='color:red'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 10px; }
    form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
    input, textarea, select, button { width: 100%; padding: 10px; margin: 8px 0; }
    button { background: #007bff; color: #fff; border: none; cursor: pointer; border-radius: 5px; }
    button:hover { background: #0056b3; }
    .preview img { width: 70px; margin: 5px; border-radius: 5px; border: 1px solid #ccc; }
    .label { font-weight: bold; margin-top: 10px; display: block; }
    .sizes-container { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px; }
    .sizes-container label { display: flex; align-items: center; gap: 5px; cursor: pointer; }
    input[type="file"] { padding: 3px; }
  </style>
</head>
<body>
  <h2>Add Product</h2>
  <form method="POST" enctype="multipart/form-data">
    <label class="label">Product Name</label>
    <input type="text" name="product_name" placeholder="Product Name" required>

    <label class="label">Main Image (Thumbnail)</label>
    <input type="file" name="product_image" accept="image/*" required>

    <label class="label">Extra Images (Multiple)</label>
    <input type="file" name="extra_images[]" accept="image/*" multiple onchange="previewImages(event)">
    <div class="preview" id="preview"></div>

    <label class="label">Original Price</label>
    <input type="number" step="0.01" name="original_price" placeholder="Original Price" required>

    <label class="label">Discount Price</label>
    <input type="number" step="0.01" name="discount_price" placeholder="Discount Price" required>

    <label class="label">Description</label>
    <textarea name="description" placeholder="Description"></textarea>

    <label class="label">Category Page</label>
    <select name="page_name">
      <option value="co-ord">Co-Ord Set</option>
      <option value="crop-top">Crop-Top</option>
      <option value="shortkurtis">Short-Kurtis</option>
    </select>

    <label class="label">Stock Quantity</label>
    <input type="number" name="stock" placeholder="Enter Stock Quantity" required>

    <label class="label">Color</label>
    <input type="text" name="color" placeholder="Enter Color" required>

    <label class="label">Fabric</label>
    <input type="text" name="fabric" placeholder="Enter Fabric" required>

    <label class="label">Sizes</label>
    <div class="sizes-container">
        <label><input type="checkbox" name="sizes[]" value="XS"> XS</label>
        <label><input type="checkbox" name="sizes[]" value="S"> S</label>
        <label><input type="checkbox" name="sizes[]" value="M"> M</label>
        <label><input type="checkbox" name="sizes[]" value="L"> L</label>
        <label><input type="checkbox" name="sizes[]" value="XL"> XL</label>
        <label><input type="checkbox" name="sizes[]" value="XXL"> XXL</label>
    </div>

    <button type="submit">Add Product</button>
  </form>

  <script>
    function previewImages(event) {
      let preview = document.getElementById("preview");
      preview.innerHTML = "";
      for (let i = 0; i < event.target.files.length; i++) {
        let file = event.target.files[i];
        let reader = new FileReader();
        reader.onload = function(e) {
          let img = document.createElement("img");
          img.src = e.target.result;
          preview.appendChild(img);
        }
        reader.readAsDataURL(file);
      }
    }
  </script>
</body>
</html>
