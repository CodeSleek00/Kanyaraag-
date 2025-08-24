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
  <title><?php echo $product['product_name']; ?> - Product Detail | Myntra Style</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #ff3f6c;
      --secondary-color: #ff3f6c;
      --dark-text: #282c3f;
      --light-text: #535766;
      --border-color: #d4d5d9;
      --light-bg: #f5f5f6;
      --white: #ffffff;
      --success: #03a685;
      --rating-color: #ffc200;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Assistant', 'Helvetica Neue', Arial, sans-serif;
      color: var(--dark-text);
      background-color: var(--white);
      line-height: 1.5;
    }
    
    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 16px;
    }
    
    /* Header */
    .header {
      background-color: var(--white);
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 0;
    }
    
    .logo {
      font-size: 24px;
      font-weight: 700;
      color: var(--primary-color);
      text-decoration: none;
    }
    
    .search-bar {
      flex: 1;
      max-width: 500px;
      margin: 0 20px;
      position: relative;
    }
    
    .search-bar input {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      font-size: 14px;
    }
    
    .search-bar i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--light-text);
    }
    
    .nav-icons {
      display: flex;
      gap: 20px;
    }
    
    .nav-icons a {
      color: var(--dark-text);
      text-decoration: none;
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 12px;
    }
    
    .nav-icons i {
      font-size: 18px;
      margin-bottom: 4px;
    }
    
    /* Breadcrumb */
    .breadcrumb {
      padding: 16px 0;
      font-size: 14px;
      color: var(--light-text);
    }
    
    .breadcrumb a {
      color: var(--light-text);
      text-decoration: none;
    }
    
    /* Product Section */
    .product-section {
      display: flex;
      gap: 40px;
      margin: 20px 0 40px;
    }
    
    .product-gallery {
      flex: 1;
      max-width: 50%;
    }
    
    .main-image {
      width: 100%;
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 16px;
    }
    
    .main-image img {
      width: 100%;
      object-fit: cover;
    }
    
    .thumbnails {
      display: flex;
      gap: 10px;
    }
    
    .thumbnails img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      cursor: pointer;
    }
    
    .thumbnails img.active {
      border-color: var(--primary-color);
    }
    
    .product-details {
      flex: 1;
    }
    
    .product-brand {
      font-size: 18px;
      font-weight: 600;
      color: var(--light-text);
      margin-bottom: 8px;
    }
    
    .product-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 12px;
    }
    
    .product-rating {
      display: flex;
      align-items: center;
      margin-bottom: 16px;
    }
    
    .rating-box {
      background-color: var(--success);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 600;
      margin-right: 10px;
      display: flex;
      align-items: center;
    }
    
    .rating-box i {
      font-size: 12px;
      margin-right: 4px;
    }
    
    .rating-count {
      color: var(--light-text);
      font-size: 14px;
    }
    
    .pricing {
      margin-bottom: 20px;
    }
    
    .current-price {
      font-size: 24px;
      font-weight: 600;
    }
    
    .original-price {
      font-size: 18px;
      color: var(--light-text);
      text-decoration: line-through;
      margin-left: 10px;
    }
    
    .discount-percent {
      color: var(--success);
      font-size: 18px;
      font-weight: 600;
      margin-left: 10px;
    }
    
    .tax-info {
      color: var(--success);
      font-size: 14px;
      margin-top: 8px;
    }
    
    .size-section {
      margin: 24px 0;
    }
    
    .section-title {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 12px;
      display: flex;
      justify-content: space-between;
    }
    
    .size-chart-link {
      color: var(--primary-color);
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
    }
    
    .size-options {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    
    .size-option {
      border: 1px solid var(--border-color);
      border-radius: 4px;
      padding: 12px 16px;
      min-width: 70px;
      text-align: center;
      cursor: pointer;
      font-weight: 500;
    }
    
    .size-option:hover {
      border-color: var(--primary-color);
    }
    
    .size-option.selected {
      border-color: var(--primary-color);
      background-color: rgba(255, 63, 108, 0.1);
    }
    
    .action-buttons {
      display: flex;
      gap: 15px;
      margin: 30px 0;
    }
    
    .wishlist-btn {
      border: 1px solid var(--border-color);
      border-radius: 4px;
      padding: 12px 16px;
      background: var(--white);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
    }
    
    .wishlist-btn:hover {
      border-color: var(--primary-color);
      color: var(--primary-color);
    }
    
    .add-to-bag {
      flex: 1;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 4px;
      padding: 12px 16px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }
    
    .delivery-options {
      border: 1px solid var(--border-color);
      border-radius: 4px;
      padding: 16px;
      margin-bottom: 24px;
    }
    
    .delivery-option {
      display: flex;
      margin-bottom: 12px;
    }
    
    .delivery-option:last-child {
      margin-bottom: 0;
    }
    
    .delivery-icon {
      margin-right: 12px;
      color: var(--light-text);
    }
    
    .delivery-text {
      flex: 1;
    }
    
    .delivery-title {
      font-weight: 600;
      margin-bottom: 4px;
    }
    
    .delivery-desc {
      color: var(--light-text);
      font-size: 14px;
    }
    
    .delivery-pincode {
      display: flex;
      margin-top: 8px;
    }
    
    .delivery-pincode input {
      flex: 1;
      padding: 8px 12px;
      border: 1px solid var(--border-color);
      border-radius: 4px 0 0 4px;
    }
    
    .delivery-pincode button {
      background: var(--white);
      border: 1px solid var(--border-color);
      border-left: none;
      border-radius: 0 4px 4px 0;
      padding: 0 12px;
      cursor: pointer;
    }
    
    /* Product Details Tabs */
    .product-tabs {
      margin: 40px 0;
    }
    
    .tab-headers {
      display: flex;
      border-bottom: 1px solid var(--border-color);
    }
    
    .tab-header {
      padding: 12px 24px;
      font-weight: 600;
      cursor: pointer;
      border-bottom: 2px solid transparent;
    }
    
    .tab-header.active {
      border-bottom-color: var(--primary-color);
      color: var(--primary-color);
    }
    
    .tab-content {
      padding: 24px 0;
    }
    
    .tab-pane {
      display: none;
    }
    
    .tab-pane.active {
      display: block;
    }
    
    .product-details-list {
      list-style: none;
    }
    
    .product-details-list li {
      display: flex;
      margin-bottom: 12px;
    }
    
    .detail-name {
      min-width: 150px;
      color: var(--light-text);
    }
    
    /* Reviews Section */
    .review-item {
      border-bottom: 1px solid var(--border-color);
      padding: 20px 0;
    }
    
    .review-header {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
    }
    
    .reviewer-name {
      font-weight: 600;
      margin-right: 12px;
    }
    
    .review-rating {
      color: var(--rating-color);
    }
    
    .review-date {
      margin-left: auto;
      color: var(--light-text);
      font-size: 14px;
    }
    
    .review-text {
      margin-bottom: 12px;
    }
    
    .review-image {
      max-width: 150px;
      border-radius: 4px;
      margin-top: 8px;
    }
    
    .review-form {
      background: var(--light-bg);
      padding: 24px;
      border-radius: 4px;
      margin-top: 24px;
    }
    
    .form-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 16px;
    }
    
    .form-group {
      margin-bottom: 16px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      font-family: inherit;
    }
    
    textarea.form-control {
      min-height: 100px;
      resize: vertical;
    }
    
    .star-rating {
      display: flex;
      gap: 8px;
    }
    
    .star-rating input {
      display: none;
    }
    
    .star-rating label {
      font-size: 24px;
      color: var(--border-color);
      cursor: pointer;
    }
    
    .star-rating input:checked ~ label {
      color: var(--border-color);
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
      color: var(--rating-color);
    }
    
    .submit-btn {
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 4px;
      padding: 12px 24px;
      font-weight: 600;
      cursor: pointer;
    }
    
    /* Recommendations Section */
    .recommendations {
      margin: 60px 0;
    }
    
    .section-heading {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 24px;
      text-align: center;
    }
    
    .product-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }
    
    .product-card {
      background: var(--white);
      border-radius: 4px;
      overflow: hidden;
      transition: transform 0.3s ease;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .product-image {
      width: 100%;
      height: 260px;
      object-fit: cover;
    }
    
    .product-info {
      padding: 12px;
    }
    
    .product-brand {
      font-size: 14px;
      color: var(--light-text);
      margin-bottom: 4px;
    }
    
    .product-name {
      font-weight: 600;
      margin-bottom: 8px;
      height: 40px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }
    
    .product-pricing {
      display: flex;
      align-items: center;
    }
    
    .product-price {
      font-weight: 600;
    }
    
    .product-original-price {
      color: var(--light-text);
      text-decoration: line-through;
      margin-left: 8px;
      font-size: 14px;
    }
    
    .product-discount {
      color: var(--success);
      margin-left: 8px;
      font-size: 14px;
      font-weight: 600;
    }
    
    /* Footer */
    .footer {
      background: var(--light-bg);
      padding: 40px 0;
      margin-top: 60px;
    }
    
    .footer-content {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
    }
    
    .footer-column h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 16px;
      color: var(--dark-text);
    }
    
    .footer-links {
      list-style: none;
    }
    
    .footer-links li {
      margin-bottom: 8px;
    }
    
    .footer-links a {
      color: var(--light-text);
      text-decoration: none;
      font-size: 14px;
    }
    
    .footer-links a:hover {
      color: var(--primary-color);
    }
    
    .copyright {
      text-align: center;
      padding-top: 30px;
      margin-top: 30px;
      border-top: 1px solid var(--border-color);
      color: var(--light-text);
      font-size: 14px;
    }
    
    /* Responsive Styles */
    @media (max-width: 1024px) {
      .product-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    @media (max-width: 768px) {
      .product-section {
        flex-direction: column;
      }
      
      .product-gallery {
        max-width: 100%;
      }
      
      .product-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .footer-content {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .header-content {
        flex-wrap: wrap;
      }
      
      .search-bar {
        order: 3;
        max-width: 100%;
        margin: 15px 0 0;
      }
    }
    
    @media (max-width: 480px) {
      .product-grid {
        grid-template-columns: 1fr;
      }
      
      .footer-content {
        grid-template-columns: 1fr;
      }
      
      .action-buttons {
        flex-direction: column;
      }
      
      .wishlist-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="header-content">
        <a href="#" class="logo">MYNTRA</a>
        <div class="search-bar">
          <input type="text" placeholder="Search for products, brands and more">
          <i class="fas fa-search"></i>
        </div>
        <div class="nav-icons">
          <a href="#">
            <i class="far fa-user"></i>
            <span>Profile</span>
          </a>
          <a href="#">
            <i class="far fa-heart"></i>
            <span>Wishlist</span>
          </a>
          <a href="#">
            <i class="fas fa-shopping-bag"></i>
            <span>Bag</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <main class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
      <a href="#">Home</a> / <a href="#">Clothing</a> / <a href="#">Men</a> / <a href="#">T-Shirts</a> / <?php echo $product['product_name']; ?>
    </div>

    <!-- Product Section -->
    <section class="product-section">
      <div class="product-gallery">
        <div class="main-image">
          <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" id="main-product-image">
        </div>
        <div class="thumbnails">
          <img src="<?php echo $product['product_image']; ?>" class="active" onclick="changeImage(this)">
          <!-- Additional thumbnail images would go here -->
          <img src="<?php echo $product['product_image']; ?>" onclick="changeImage(this)">
          <img src="<?php echo $product['product_image']; ?>" onclick="changeImage(this)">
          <img src="<?php echo $product['product_image']; ?>" onclick="changeImage(this)">
        </div>
      </div>

      <div class="product-details">
        <div class="product-brand">Brand: <?php echo explode(' ', $product['product_name'])[0]; ?></div>
        <h1 class="product-title"><?php echo $product['product_name']; ?></h1>
        
        <div class="product-rating">
          <div class="rating-box">
            <i class="fas fa-star"></i> 4.5
          </div>
          <div class="rating-count">12,345 Ratings & 1,234 Reviews</div>
        </div>
        
        <div class="pricing">
          <span class="current-price">₹<?php echo $product['discount_price']; ?></span>
          <span class="original-price">₹<?php echo $product['original_price']; ?></span>
          <span class="discount-percent">(<?php echo round(100 - ($product['discount_price'] / $product['original_price'] * 100)); ?>% OFF)</span>
          <div class="tax-info">Inclusive of all taxes</div>
        </div>
        
        <div class="size-section">
          <div class="section-title">
            <span>SELECT SIZE</span>
            <a href="#" class="size-chart-link">Size Chart</a>
          </div>
          <div class="size-options">
            <div class="size-option">XS</div>
            <div class="size-option">S</div>
            <div class="size-option selected">M</div>
            <div class="size-option">L</div>
            <div class="size-option">XL</div>
            <div class="size-option">XXL</div>
          </div>
        </div>
        
        <div class="action-buttons">
          <button class="wishlist-btn"><i class="far fa-heart"></i></button>
          <button class="add-to-bag">ADD TO BAG</button>
        </div>
        
        <div class="delivery-options">
          <div class="delivery-option">
            <div class="delivery-icon"><i class="fas fa-truck"></i></div>
            <div class="delivery-text">
              <div class="delivery-title">Delivery Options</div>
              <div class="delivery-desc">Enter your pincode to check delivery time</div>
              <div class="delivery-pincode">
                <input type="text" placeholder="Enter pincode">
                <button>Check</button>
              </div>
            </div>
          </div>
          <div class="delivery-option">
            <div class="delivery-icon"><i class="fas fa-undo"></i></div>
            <div class="delivery-text">
              <div class="delivery-title">Easy Returns</div>
              <div class="delivery-desc">30 days returns and exchange policy</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Product Details Tabs -->
    <section class="product-tabs">
      <div class="tab-headers">
        <div class="tab-header active" data-tab="description">PRODUCT DETAILS</div>
        <div class="tab-header" data-tab="specifications">SPECIFICATIONS</div>
        <div class="tab-header" data-tab="reviews">REVIEWS</div>
      </div>
      
      <div class="tab-content">
        <div class="tab-pane active" id="description">
          <h3>Product Description</h3>
          <p><?php echo $product['description']; ?></p>
        </div>
        
        <div class="tab-pane" id="specifications">
          <h3>Product Specifications</h3>
          <ul class="product-details-list">
            <li>
              <span class="detail-name">Fabric</span>
              <span class="detail-value">100% Cotton</span>
            </li>
            <li>
              <span class="detail-name">Fit</span>
              <span class="detail-value">Regular</span>
            </li>
            <li>
              <span class="detail-name">Length</span>
              <span class="detail-value">Regular</span>
            </li>
            <li>
              <span class="detail-name">Pattern</span>
              <span class="detail-value">Printed</span>
            </li>
            <li>
              <span class="detail-name">Sleeve Length</span>
              <span class="detail-value">Full Sleeve</span>
            </li>
            <li>
              <span class="detail-name">Neck Type</span>
              <span class="detail-value">Round Neck</span>
            </li>
            <li>
              <span class="detail-name">Wash Care</span>
              <span class="detail-value">Machine Wash</span>
            </li>
          </ul>
        </div>
        
        <div class="tab-pane" id="reviews">
          <h3>Customer Reviews</h3>
          <?php if ($reviews_result->num_rows > 0): ?>
            <?php while($rev = $reviews_result->fetch_assoc()): ?>
              <div class="review-item">
                <div class="review-header">
                  <div class="reviewer-name"><?php echo $rev['user_name']; ?></div>
                  <div class="review-rating"><?php echo str_repeat("★", $rev['rating']); ?></div>
                  <div class="review-date"><?php echo date('F j, Y', strtotime($rev['created_at'])); ?></div>
                </div>
                <div class="review-text"><?php echo $rev['review_text']; ?></div>
                <?php if($rev['review_image']): ?>
                  <img src="<?php echo $rev['review_image']; ?>" alt="Review Image" class="review-image">
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
          <?php endif; ?>
          
          <div class="review-form">
            <h3 class="form-title">Write a Review</h3>
            <form method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="user_name">Your Name</label>
                <input type="text" id="user_name" name="user_name" class="form-control" required>
              </div>
              
              <div class="form-group">
                <label>Rating</label>
                <div class="star-rating">
                  <input type="radio" id="star5" name="rating" value="5">
                  <label for="star5">★</label>
                  <input type="radio" id="star4" name="rating" value="4">
                  <label for="star4">★</label>
                  <input type="radio" id="star3" name="rating" value="3">
                  <label for="star3">★</label>
                  <input type="radio" id="star2" name="rating" value="2">
                  <label for="star2">★</label>
                  <input type="radio" id="star1" name="rating" value="1">
                  <label for="star1">★</label>
                </div>
              </div>
              
              <div class="form-group">
                <label for="review_text">Your Review</label>
                <textarea id="review_text" name="review_text" class="form-control" required></textarea>
              </div>
              
              <div class="form-group">
                <label for="review_image">Upload Image (Optional)</label>
                <input type="file" id="review_image" name="review_image" accept="image/*">
              </div>
              
              <button type="submit" name="submit_review" class="submit-btn">Submit Review</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Recommendations Section -->
    <section class="recommendations">
      <h2 class="section-heading">Complete Your Look</h2>
      <div class="product-grid">
        <?php while($row = $suggest_result->fetch_assoc()): ?>
          <div class="product-card">
            <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-image">
            <div class="product-info">
              <div class="product-brand"><?php echo explode(' ', $row['product_name'])[0]; ?></div>
              <div class="product-name"><?php echo $row['product_name']; ?></div>
              <div class="product-pricing">
                <span class="product-price">₹<?php echo $row['discount_price']; ?></span>
                <span class="product-original-price">₹<?php echo $row['original_price']; ?></span>
                <span class="product-discount">(<?php echo round(100 - ($row['discount_price'] / $row['original_price'] * 100)); ?>% OFF)</span>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-column">
          <h3>ONLINE SHOPPING</h3>
          <ul class="footer-links">
            <li><a href="#">Men</a></li>
            <li><a href="#">Women</a></li>
            <li><a href="#">Kids</a></li>
            <li><a href="#">Home & Living</a></li>
            <li><a href="#">Beauty</a></li>
          </ul>
        </div>
        
        <div class="footer-column">
          <h3>CUSTOMER POLICIES</h3>
          <ul class="footer-links">
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">T&C</a></li>
            <li><a href="#">Track Orders</a></li>
            <li><a href="#">Shipping</a></li>
          </ul>
        </div>
        
        <div class="footer-column">
          <h3>EXPERIENCE APP</h3>
          <ul class="footer-links">
            <li><a href="#">Android App</a></li>
            <li><a href="#">iOS App</a></li>
          </ul>
        </div>
        
        <div class="footer-column">
          <h3>ABOUT US</h3>
          <ul class="footer-links">
            <li><a href="#">About Company</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Press</a></li>
          </ul>
        </div>
      </div>
      
      <div class="copyright">
        © 2023 Myntra Style. All rights reserved.
      </div>
    </div>
  </footer>

  <script>
    // Change main product image when thumbnail is clicked
    function changeImage(element) {
      document.getElementById('main-product-image').src = element.src;
      document.querySelectorAll('.thumbnails img').forEach(img => {
        img.classList.remove('active');
      });
      element.classList.add('active');
    }
    
    // Tab switching functionality
    document.querySelectorAll('.tab-header').forEach(tab => {
      tab.addEventListener('click', () => {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-header').forEach(t => {
          t.classList.remove('active');
        });
        
        // Add active class to clicked tab
        tab.classList.add('active');
        
        // Hide all tab panes
        document.querySelectorAll('.tab-pane').forEach(pane => {
          pane.style.display = 'none';
        });
        
        // Show the selected tab pane
        const tabId = tab.getAttribute('data-tab');
        document.getElementById(tabId).style.display = 'block';
      });
    });
    
    // Size selection functionality
    document.querySelectorAll('.size-option').forEach(option => {
      option.addEventListener('click', () => {
        document.querySelectorAll('.size-option').forEach(opt => {
          opt.classList.remove('selected');
        });
        option.classList.add('selected');
      });
    });
  </script>
</body>
</html>