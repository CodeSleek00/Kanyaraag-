<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Women Collection</title>
   
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
