<?php
include '../db/db_connect.php';

// Product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// Fetch random products for "Complete Your Look"
$suggest_sql = "SELECT * FROM products WHERE id != $product_id ORDER BY RAND() LIMIT 4";
$suggest_result = $conn->query($suggest_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['name']; ?> - Product Detail</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {font-family: Arial, sans-serif; margin:0; padding:0; background:#f9f9f9;}
    .container {max-width:1200px; margin:auto; padding:20px; display:flex; gap:30px; flex-wrap:wrap;}
    .product-img {flex:1; text-align:center;}
    .product-img img {max-width:100%; border-radius:10px;}
    .product-info {flex:1; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
    .product-info h1 {margin:0; font-size:28px;}
    .price {margin:10px 0; font-size:20px;}
    .price del {color:#888; margin-right:10px;}
    .quantity, .size {margin:15px 0;}
    select, input[type="number"] {padding:8px; width:100px;}
    .btn {background:#ff3f6c; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;}
    .tabs {margin-top:20px;}
    .tab-btns {display:flex; gap:15px;}
    .tab-btns button {padding:10px 15px; border:none; cursor:pointer; background:#eee; border-radius:5px;}
    .tab-content {background:#fafafa; margin-top:10px; padding:15px; border-radius:5px;}
    .suggestions {margin-top:30px;}
    .suggestions h2 {margin-bottom:15px;}
    .suggestions-grid {display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px;}
    .suggestions-grid div {background:#fff; border-radius:10px; padding:10px; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
    .suggestions-grid img {max-width:100%; border-radius:8px;}
    .reviews {margin-top:30px; background:#fff; padding:20px; border-radius:10px;}
    .review-form {margin-top:20px;}
    .review-form input, .review-form textarea {width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;}
    .review-form button {background:#28a745; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;}
    .share {text-align:right; margin-bottom:10px;}
    .share i {margin:0 5px; cursor:pointer; color:#555;}
    @media(max-width:768px){.container{flex-direction:column;}}
  </style>
  <script>
    function showTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(el => el.style.display='none');
      document.getElementById(tabId).style.display='block';
    }
  </script>
</head>
<body>

<div class="container">
  <!-- Product Image -->
  <div class="product-img">
    <div class="share">
      <i class="fab fa-facebook"></i>
      <i class="fab fa-twitter"></i>
      <i class="fab fa-whatsapp"></i>
    </div>
    <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
  </div>

  <!-- Product Info -->
  <div class="product-info">
    <h1><?php echo $product['product_name']; ?></h1>
    <div class="price">
      <del>₹<?php echo $product['original_price']; ?></del>
      <span style="color:#e53935;">₹<?php echo $product['discount_price']; ?></span>
    </div>
    <p><?php echo $product['description']; ?></p>

    <div class="quantity">
      <label>Quantity: </label>
      <input type="number" value="1" min="1" max="<?php echo $product['stock']; ?>">
    </div>

    <div class="size">
      <label>Size: </label>
      <select>
        <option>XS</option><option>S</option><option>M</option>
        <option>L</option><option>XL</option><option>XXL</option><option>XXXL</option>
      </select>
    </div>

    <button class="btn">Add to Cart</button>

    <!-- Tabs -->
    <div class="tabs">
      <div class="tab-btns">
        <button onclick="showTab('desc')">Description</button>
        <button onclick="showTab('details')">Details</button>
        <button onclick="showTab('shipping')">Shipping</button>
        <button onclick="showTab('reviews')">Reviews</button>
      </div>
      <div id="desc" class="tab-content"><?php echo $product['description']; ?></div>
      <div id="details" class="tab-content" style="display:none;">High quality fabric, 100% cotton.</div>
      <div id="shipping" class="tab-content" style="display:none;">Delivered within 5-7 working days.</div>
      <div id="reviews" class="tab-content" style="display:none;">No reviews yet.</div>
    </div>
  </div>
</div>

<!-- Complete Your Look -->
<div class="container suggestions">
  <h2>Complete Your Look</h2>
  <div class="suggestions-grid">
    <?php while($row = $suggest_result->fetch_assoc()): ?>
      <div>
        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
        <h4><?php echo $row['name']; ?></h4>
        <p>₹<?php echo $row['discount_price']; ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Customer Reviews -->
<div class="container reviews">
  <h2>Customer Reviews</h2>
  
  <!-- Review Form -->
  <div class="review-form">
    <input type="text" placeholder="Your Name">
    <input type="number" placeholder="Star Rating (1-5)" min="1" max="5">
    <textarea placeholder="Write your review"></textarea>
    <input type="file" accept="image/*">
    <button>Submit Review</button>
  </div>
</div>

</body>
</html>
