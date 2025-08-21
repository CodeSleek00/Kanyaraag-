<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Suggested Products</title>
  <style>
    body { font-family: Arial, sans-serif; background: #fafafa; padding: 20px; }
    h2 { text-align: center; margin-bottom: 20px; }
    .products { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
      gap: 20px; 
    }
    .card { 
      background: #fff; 
      padding: 15px; 
      border-radius: 10px; 
      box-shadow: 0 2px 6px rgba(0,0,0,0.1); 
      text-align: center; 
      transition: transform 0.2s ease-in-out; 
    }
    .card:hover { transform: scale(1.05); }
    .card img { 
      max-width: 100%; 
      height: 200px; 
      object-fit: cover; 
      border-radius: 8px; 
    }
    .price { font-weight: bold; margin: 10px 0; font-size: 16px; }
    .old { text-decoration: line-through; color: red; margin-right: 5px; }
    .discount { color: #555; font-size: 14px; }
  </style>
</head>
<body>

<h2>💡 Suggested Products (High Price, Low Discount)</h2>
<div class="products">
<?php

$sql = "SELECT * FROM products 
        WHERE original_price > 2000 
        AND discount_percent < 20 
        ORDER BY RAND() 
        LIMIT 20";
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
                    <span class='discount'>(Only ".round($row['discount_percent'])."% OFF)</span>
                </p>
              </div>";
    }
} else {
    echo "<p style='text-align:center;'>🤔 No suggested products found right now!</p>";
}
?>
</div>

</body>
</html>
