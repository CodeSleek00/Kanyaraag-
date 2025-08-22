<?php include '../db/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>All Products</title>
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
    .discount { color: green; font-size: 14px; }
  </style>
</head>
<body>

<h2>🛍️ All Products</h2>
<div class="products">
<?php
$sql = "SELECT * FROM products ORDER BY RAND()";
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

        <!-- 🛒 Add to Cart button -->
        <button class='add-to-cart'
          data-id='".$row['id']."'
          data-name='".$row['product_name']."'
          data-price='".$row['discount_price']."'
          data-image='".$row['product_image']."'>
          Add to Cart
        </button>
      </div>";

    }
} else {
    echo "<p style='text-align:center;'>😢 No products available yet!</p>";
}
?>
</div>
<script>
    // Add to Cart
  document.querySelectorAll(".add-to-cart").forEach(btn => {
    btn.addEventListener("click", () => {
      let product = {
        id: btn.getAttribute("data-id"),
        name: btn.getAttribute("data-name"),
        price: btn.getAttribute("data-price"),
        image: btn.getAttribute("data-image"),
        qty: 1
      };

      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      // Check if product already exists
      let existing = cart.find(p => p.id === product.id);
      if (existing) {
        existing.qty++;
      } else {
        cart.push(product);
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      alert(product.name + " added to cart!");
    });
  });
</script>
</body>
</html>
