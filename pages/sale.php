<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Sale - Big Discounts</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background: #f8f8f8;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #d32f2f;
    }
    .products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .price {
      margin: 10px 0;
      font-size: 16px;
    }
    .price .old {
      text-decoration: line-through;
      color: #777;
      margin-right: 5px;
    }
    .discount {
      color: green;
      font-weight: bold;
      font-size: 14px;
    }
  </style>
</head>
<body>

<h2>🔥 Big Sale - Products with 30%+ OFF 🔥</h2>
<div class="products">
<?php
// Select products above 30% OFF and shuffle them randomly
$sql = "SELECT * FROM products WHERE discount_percent > 30 ORDER BY RAND()";
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
    echo "<p style='text-align:center;'>😢 No products on Sale above 30% yet!</p>";
}
?>
</div>

</body>
</html>
