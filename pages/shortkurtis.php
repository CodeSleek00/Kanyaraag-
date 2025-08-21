<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Short Kurtis Collection</title>
  <style>
    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px;
      width: 220px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .card img {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
    }
    .price {
      margin-top: 8px;
      font-size: 14px;
    }
    .old {
      text-decoration: line-through;
      color: #888;
      margin-right: 5px;
    }
    .discount {
      color: red;
      font-weight: bold;
      margin-left: 5px;
    }
  </style>
</head>
<body>

<h2>Short Kurtis Collection</h2>
<div class="products">
<?php
// Random shuffle ke liye ORDER BY RAND()
$sql = "SELECT * FROM products WHERE page_name='shortkurtis' ORDER BY RAND()";
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
