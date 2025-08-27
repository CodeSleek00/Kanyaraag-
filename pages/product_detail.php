<?php include '../db/db_connect.php'; ?>

<?php
$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $product['product_name']; ?> - Details</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
    .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
    .gallery { display: flex; gap: 15px; }
    .gallery-main { flex: 2; }
    .gallery-main img { width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; }
    .gallery-thumbs { flex: 1; display: flex; flex-direction: column; gap: 10px; }
    .gallery-thumbs img { width: 100%; height: 100px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid #ddd; }
    h2 { margin: 15px 0; }
    .price { font-size: 20px; margin: 10px 0; }
    .old { text-decoration: line-through; color: red; margin-right: 10px; }
    .discount { color: green; }
    .details p { margin: 8px 0; }
    .btns { margin-top: 15px; }
    .btns button { padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
    .add-cart { background: #007bff; color: #fff; }
    .buy-now { background: #ff3f6c; color: #fff; }
  </style>
</head>
<body>

<div class="container">
  <div class="gallery">
    <div class="gallery-main">
      <img id="mainImg" src="<?php echo $product['product_image']; ?>" alt="">
    </div>
    <div class="gallery-thumbs">
      <img src="<?php echo $product['product_image']; ?>" onclick="showImage(this)">
      <?php
        if (!empty($product['images'])) {
            $extra = json_decode($product['images'], true);
            foreach ($extra as $img) {
                echo "<img src='".$img."' onclick='showImage(this)'>";
            }
        }
      ?>
    </div>
  </div>

  <h2><?php echo $product['product_name']; ?></h2>
  <div class="price">
    <span class="old">₹<?php echo $product['original_price']; ?></span>
    ₹<?php echo $product['discount_price']; ?>
    <span class="discount">(<?php echo round($product['discount_percent']); ?>% OFF)</span>
  </div>
  <div class="details">
    <p><b>Description:</b> <?php echo $product['description']; ?></p>
    <p><b>Color:</b> <?php echo $product['color']; ?></p>
    <p><b>Fabric:</b> <?php echo $product['fabric']; ?></p>
    <p><b>Stock:</b> <?php echo $product['stock']; ?></p>
  </div>

  <div class="btns">
    <button class="add-cart">Add to Cart</button>
    <button class="buy-now">Buy Now</button>
  </div>
</div>

<script>
function showImage(img) {
  document.getElementById("mainImg").src = img.src;
}
</script>
</body>
</html>
