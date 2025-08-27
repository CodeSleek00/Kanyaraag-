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
    .card:hover { transform: scale(1.03); }
    .card img { 
      max-width: 100%; 
      height: 200px; 
      object-fit: cover; 
      border-radius: 8px; 
    }
    .thumbs { margin-top: 8px; display: flex; gap: 5px; justify-content: center; flex-wrap: wrap; }
    .thumbs img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; }
    .price { font-weight: bold; margin: 10px 0; font-size: 16px; }
    .old { text-decoration: line-through; color: red; margin-right: 5px; }
    .discount { color: green; font-size: 14px; }
    .buy-now {
      background: #ff3f6c;
      color: #fff;
      border: none;
      padding: 10px 15px;
      margin-top: 8px;
      cursor: pointer;
      border-radius: 5px;
      transition: 0.3s;
    }
    .buy-now:hover { background: #e91e63; }
    .add-to-cart {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 10px 15px;
      margin-top: 8px;
      cursor: pointer;
      border-radius: 5px;
      transition: 0.3s;
    }
    .add-to-cart:disabled { background: #999; cursor: not-allowed; }
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
        <a href='product_detail.php?id=".$row['id']."'>
          <img src='".$row['product_image']."' alt='".$row['product_name']."'>
        </a>
        <h3>".$row['product_name']."</h3>
        <p>".$row['description']."</p>
        <p class='price'>
            <span class='old'>₹".$row['original_price']."</span> 
            ₹".$row['discount_price']." 
            <span class='discount'>(".round($row['discount_percent'])."% OFF)</span>
        </p>
        <p class='stock'>Stock: ".$row['stock']."</p>";

        // show extra images
        if (!empty($row['images'])) {
            $images = json_decode($row['images'], true);
            if (!empty($images)) {
                echo "<div class='thumbs'>";
                foreach ($images as $img) {
                    echo "<img src='".$img."' alt='extra'>";
                }
                echo "</div>";
            }
        }

        echo "
        <button class='add-to-cart'
          data-id='".$row['id']."'
          data-name='".$row['product_name']."'
          data-price='".$row['discount_price']."'
          data-image='".$row['product_image']."'
          data-stock='".$row['stock']."'
          ".($row['stock'] <= 0 ? "disabled" : "").">
          ".($row['stock'] > 0 ? "Add to Cart" : "Out of Stock")."
        </button>

        <a href='product_detail.php?id=".$row['id']."' style='text-decoration:none;'>
          <button class='buy-now'>Buy Now</button>
        </a>
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
