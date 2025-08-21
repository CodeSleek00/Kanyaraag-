<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Co-ord Set Collection</title>
  <style>
    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      width: 220px;
      text-align: center;
      background: #fff;
      transition: 0.3s;
    }
    .card:hover {
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
      transform: scale(1.03);
    }
    .card img {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
    }
    .price {
      font-weight: bold;
      margin-top: 8px;
    }
    .price .old {
      text-decoration: line-through;
      color: gray;
      margin-right: 6px;
    }
    .discount {
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body>

<h2>Co-ord Set Collection</h2>
<div class="products">
<?php
// products ko random shuffle order me laane ke liye
$sql = "SELECT * FROM products WHERE page_name='co-ord' ORDER BY RAND()";
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
