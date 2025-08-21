<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Crop-Top Collection</title>
  <style>
    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      width: 220px;
      text-align: center;
      transition: 0.3s;
    }
    .card:hover {
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    .card img {
      max-width: 100%;
      border-radius: 8px;
    }
    .price {
      margin-top: 10px;
      font-size: 16px;
    }
    .price .old {
      text-decoration: line-through;
      color: gray;
      margin-right: 5px;
    }
    .price .discount {
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>

<h2>Crop-Top Collection</h2>
<div class="products">
<?php
$sql = "SELECT * FROM products WHERE page_name='crop-top' ORDER BY RAND()"; // shuffle karega
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
