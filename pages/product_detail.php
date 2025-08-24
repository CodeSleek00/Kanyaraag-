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

// Handle Review Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $rating = intval($_POST['rating']);
    $review_text = $conn->real_escape_string($_POST['review_text']);
    $review_image = "";

    // Upload review image
    if (!empty($_FILES['review_image']['name'])) {
        $target_dir = "../uploads/reviews/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $review_image = $target_dir . basename($_FILES["review_image"]["name"]);
        move_uploaded_file($_FILES["review_image"]["tmp_name"], $review_image);
    }

    $sql = "INSERT INTO reviews (product_id, user_name, rating, review_text, review_image) 
            VALUES ('$product_id', '$user_name', '$rating', '$review_text', '$review_image')";
    $conn->query($sql);
}

// Fetch Reviews
$reviews_sql = "SELECT * FROM reviews WHERE product_id = $product_id ORDER BY created_at DESC";
$reviews_result = $conn->query($reviews_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['product_name']; ?> - Product Detail</title>
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
    .review-box {border-bottom:1px solid #ddd; padding:10px 0;}
    .review-box img {max-width:100px; margin-top:5px; border-radius:5px;}
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

    <!-- Buy Now Button -->
    <form action="buy_now.php" method="GET" style="margin-top:10px;">
      <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
      <button type="submit" class="btn" style="background:#28a745;">Buy Now</button>
    </form>


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
      <div id="reviews" class="tab-content" style="display:none;">
        <?php if ($reviews_result->num_rows > 0): ?>
          <?php while($rev = $reviews_result->fetch_assoc()): ?>
            <div class="review-box">
              <strong><?php echo $rev['user_name']; ?></strong> - 
              <?php echo str_repeat("⭐", $rev['rating']); ?>
              <p><?php echo $rev['review_text']; ?></p>
              <?php if($rev['review_image']): ?>
                <img src="<?php echo $rev['review_image']; ?>" alt="Review Image">
              <?php endif; ?>
              <small><?php echo $rev['created_at']; ?></small>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Complete Your Look -->
<div class="container suggestions">
  <h2>Complete Your Look</h2>
  <div class="suggestions-grid">
    <?php while($row = $suggest_result->fetch_assoc()): ?>
      <div>
        <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
        <h4><?php echo $row['product_name']; ?></h4>
        <p>₹<?php echo $row['discount_price']; ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Customer Reviews Form -->
<div class="container reviews">
  <h2>Leave a Review</h2>
  <form class="review-form" method="POST" enctype="multipart/form-data">
    <input type="text" name="user_name" placeholder="Your Name" required>
    <input type="number" name="rating" placeholder="Star Rating (1-5)" min="1" max="5" required>
    <textarea name="review_text" placeholder="Write your review"></textarea>
    <input type="file" name="review_image" accept="image/*">
    <button type="submit" name="submit_review">Submit Review</button>
  </form>
</div>

</body>
</html>
