<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Women Collection</title>
  <style>
    body { font-family: Arial; background: #fafafa; padding: 20px; }
    .products { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .card { background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-align: center; }
    .card img { max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
    .price { font-weight: bold; margin: 10px 0; }
    .old { text-decoration: line-through; color: red; }
    .discount { color: green; }
  </style>
</head>
<body>

<h2>Women Collection</h2>
<div class="products">
<?php
$sql = "SELECT * FROM products WHERE page_name='women' ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>
                <img src='".$row['product_image']."' alt='".$row['product_name']."'>
                <h3>".$row['product_name']."</h3>
                <p>".$row['description']."</p>
                <p class='price'>
                    <span class='old'>₹".$row['original_price']."</span> 
                    ₹".$row['discount_price']." 
                    <span class='discount'>(".round($row['discount_percent'])."% OFF)</span>
                </p>
              </div>";
    }
} else {
    echo "<p>No products found</p>";
}
?>
</div>

</body>
</html>
