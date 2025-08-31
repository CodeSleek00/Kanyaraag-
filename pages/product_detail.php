<?php include '../db/db_connect.php'; ?>

<?php
$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['product_name']; ?> - Product Details</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #3a86ff;
      --primary-dark: #2a75ff;
      --secondary: #ff006e;
      --secondary-dark: #e00064;
      --accent: #8338ec;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --light-gray: #e9ecef;
      --success: #28a745;
      --border: #dee2e6;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --shadow-hover: 0 6px 16px rgba(0, 0, 0, 0.12);
      --transition: all 0.3s ease;
      --radius: 12px;
      --radius-sm: 8px;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9fafb;
      color: var(--dark);
      line-height: 1.6;
    }
    
    /* Header Styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      background: white;
      box-shadow: var(--shadow);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .header button {
      background: none;
      border: none;
      cursor: pointer;
      padding: 8px;
      border-radius: 50%;
      transition: var(--transition);
    }
    
    .header button:hover {
      background: var(--light-gray);
    }
    
    .logo {
      font-size: 24px;
      font-weight: 700;
      color: var(--dark);
    }
    
    .raag {
      color: var(--primary);
    }
    
    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    /* Breadcrumb */
    .breadcrumb {
      display: flex;
      align-items: center;
      margin-bottom: 24px;
      font-size: 14px;
      color: var(--gray);
    }
    
    .breadcrumb a {
      color: var(--gray);
      text-decoration: none;
      transition: var(--transition);
    }
    
    .breadcrumb a:hover {
      color: var(--primary);
    }
    
    .breadcrumb i {
      margin: 0 8px;
      font-size: 12px;
    }
    
    /* Product Layout */
    .product-detail-wrapper {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      background: white;
      border-radius: var(--radius);
      padding: 30px;
      box-shadow: var(--shadow);
      margin-bottom: 40px;
    }
    
    @media (max-width: 992px) {
      .product-detail-wrapper {
        grid-template-columns: 1fr;
        gap: 30px;
      }
    }
    
    /* Image Gallery */
    .product-gallery {
      position: relative;
    }
    
    .gallery-main {
      position: relative;
      border-radius: var(--radius);
      overflow: hidden;
      margin-bottom: 16px;
      background: var(--light);
      aspect-ratio: 1/1;
    }
    
    .gallery-main img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      transition: var(--transition);
    }
    
    .gallery-thumbs {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
    }
    
    .gallery-thumb {
      border-radius: var(--radius-sm);
      overflow: hidden;
      cursor: pointer;
      border: 2px solid transparent;
      transition: var(--transition);
      aspect-ratio: 1/1;
      background: var(--light);
    }
    
    .gallery-thumb.active {
      border-color: var(--primary);
    }
    
    .gallery-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    /* Product Info */
    .product-info h1 {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 16px;
      color: var(--dark);
    }
    
    .product-meta {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      gap: 16px;
      flex-wrap: wrap;
    }
    
    .rating {
      display: flex;
      align-items: center;
      color: #ffc107;
      font-weight: 500;
    }
    
    .rating i {
      margin-right: 4px;
    }
    
    .reviews {
      color: var(--gray);
      font-size: 14px;
    }
    
    .stock {
      font-size: 14px;
      font-weight: 500;
      padding: 4px 10px;
      border-radius: 20px;
      background-color: var(--light);
    }
    
    .stock.in-stock {
      color: var(--success);
      background-color: rgba(40, 167, 69, 0.1);
    }
    
    /* Pricing */
    .pricing {
      margin-bottom: 24px;
      padding-bottom: 20px;
      border-bottom: 1px solid var(--border);
    }
    
    .price-container {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 8px;
    }
    
    .current-price {
      font-size: 28px;
      font-weight: 700;
      color: var(--dark);
    }
    
    .original-price {
      font-size: 18px;
      color: var(--gray);
      text-decoration: line-through;
    }
    
    .discount {
      font-size: 16px;
      font-weight: 600;
      color: var(--success);
      background: rgba(40, 167, 69, 0.1);
      padding: 4px 10px;
      border-radius: 20px;
    }
    
    .tax {
      font-size: 14px;
      color: var(--gray);
    }
    
    /* Product Details */
    .details {
      margin-bottom: 24px;
    }
    
    .detail-item {
      display: flex;
      margin-bottom: 12px;
    }
    
    .detail-label {
      min-width: 80px;
      font-weight: 600;
      color: var(--dark);
    }
    
    .detail-value {
      color: var(--gray);
    }
    
    .description {
      margin-bottom: 24px;
      line-height: 1.7;
    }
    
    /* Sizes */
    .sizes {
      margin-bottom: 24px;
    }
    
    .sizes h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 12px;
    }
    
    .size-options {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    
    .size-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--light-gray);
      color: var(--dark);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
      border: 2px solid transparent;
    }
    
    .size-circle:hover {
      border-color: var(--primary);
      transform: scale(1.1);
    }
    
    .size-circle.selected {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }
    
    .size-circle.disabled {
      background: #ddd;
      color: #888;
      cursor: not-allowed;
      pointer-events: none;
    }
    
    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 16px;
      margin-top: 30px;
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 14px 28px;
      border-radius: var(--radius-sm);
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      font-size: 16px;
    }
    
    .btn i {
      margin-right: 8px;
    }
    
    .btn-primary {
      background-color: var(--primary);
      color: white;
      flex: 2;
    }
    
    .btn-primary:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-hover);
    }
    
    .btn-secondary {
      background-color: var(--secondary);
      color: white;
      flex: 1;
    }
    
    .btn-secondary:hover {
      background-color: var(--secondary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-hover);
    }
    
    .btn-outline {
      background: transparent;
      border: 1px solid var(--border);
      color: var(--gray);
    }
    
    .btn-outline:hover {
      background: var(--light);
      color: var(--dark);
    }
    
    /* Additional Features */
    .shipping-info {
      background: var(--light);
      padding: 16px;
      border-radius: var(--radius-sm);
      margin-top: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .shipping-info i {
      color: var(--success);
      font-size: 20px;
    }
    
    .shipping-text {
      font-size: 14px;
    }
    
    /* Toast Notification */
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: var(--success);
      color: white;
      padding: 12px 20px;
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow);
      display: flex;
      align-items: center;
      opacity: 0;
      transform: translateY(20px);
      transition: var(--transition);
      z-index: 1000;
    }
    
    .toast.show {
      opacity: 1;
      transform: translateY(0);
    }
    
    .toast i {
      margin-right: 8px;
    }
    
    /* Tabs */
    .tabs-container {
      background: white;
      border-radius: var(--radius);
      padding: 0;
      margin-bottom: 40px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }
    
    .tab-headers {
      display: flex;
      border-bottom: 1px solid var(--border);
    }
    
    .tab-link {
      padding: 16px 24px;
      cursor: pointer;
      font-weight: 600;
      color: var(--gray);
      transition: var(--transition);
      border-bottom: 3px solid transparent;
    }
    
    .tab-link.active {
      color: var(--primary);
      border-bottom: 3px solid var(--primary);
    }
    
    .tab-link:hover:not(.active) {
      color: var(--dark);
    }
    
    .tab-content {
      padding: 24px;
      display: none;
    }
    
    .tab-content.active {
      display: block;
    }
    
    /* Frequently Bought Together */
    .fbt-section {
      margin-top: 50px;
    }
    
    .section-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
      color: var(--dark);
    }
    
    .fbt-products {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }
    
    .fbt-item {
      flex: 1;
      min-width: 200px;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 15px;
      text-align: center;
      transition: var(--transition);
    }
    
    .fbt-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }
    
    .fbt-item img {
      max-width: 150px;
      height: 150px;
      object-fit: contain;
    }
    
    .fbt-item h4 {
      margin: 10px 0;
      font-size: 16px;
    }
    
    .fbt-price {
      font-weight: 600;
      color: var(--primary);
    }
    
    .fbt-total {
      margin-top: 20px;
      padding: 15px;
      background: var(--light);
      border-radius: var(--radius);
      text-align: center;
    }
    
    .fbt-total h3 {
      color: var(--dark);
    }
    
    .discounted-price {
      color: var(--success);
    }
    
    /* Similar Products */
    .similar-section {
      margin-top: 50px;
    }
    
    .similar-products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }
    
    .product-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 15px;
      text-align: center;
      box-shadow: var(--shadow);
      transition: var(--transition);
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }
    
    .product-card a {
      text-decoration: none;
      color: inherit;
    }
    
    .product-card img {
      max-width: 180px;
      height: 180px;
      object-fit: contain;
    }
    
    .product-card h4 {
      margin: 10px 0;
      font-size: 16px;
    }
    
    .product-card .current-price {
      color: var(--primary);
      font-weight: 700;
      font-size: 18px;
    }
    
    .product-card .original-price {
      color: var(--gray);
      text-decoration: line-through;
      font-size: 14px;
    }
    
    /* Review Section */
    .review-section {
      margin-top: 50px;
    }
    
    .review-form {
      background: #fff;
      padding: 20px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      max-width: 600px;
      margin-bottom: 30px;
      box-shadow: var(--shadow);
    }
    
    .form-group {
      margin-bottom: 15px;
    }
    
    .form-group label {
      font-weight: 600;
      display: block;
      margin-bottom: 5px;
    }
    
    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--border);
      font-family: inherit;
    }
    
    .star-rating {
      display: flex;
      gap: 5px;
      cursor: pointer;
    }
    
    .star-rating i {
      font-size: 20px;
      color: #ffc107;
    }
    
    .review-list {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    .review-item {
      background: #fff;
      padding: 20px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      position: relative;
      box-shadow: var(--shadow);
    }
    
    .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    
    .reviewer-name {
      font-weight: 600;
      color: var(--primary);
    }
    
    .share-review {
      border: none;
      background: transparent;
      cursor: pointer;
      color: var(--gray);
      transition: var(--transition);
    }
    
    .share-review:hover {
      color: var(--primary);
    }
    
    .review-stars {
      margin: 5px 0;
      color: #ffc107;
    }
    
    .review-image {
      max-width: 150px;
      max-height: 150px;
      object-fit: cover;
      border-radius: var(--radius-sm);
      margin-top: 10px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .action-buttons {
        flex-direction: column;
      }
      
      .gallery-thumbs {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .product-info h1 {
        font-size: 24px;
      }
      
      .current-price {
        font-size: 24px;
      }
      
      .tab-headers {
        flex-direction: column;
      }
      
      .tab-link {
        border-bottom: 1px solid var(--border);
        border-left: 3px solid transparent;
      }
      
      .tab-link.active {
        border-bottom: 1px solid var(--border);
        border-left: 3px solid var(--primary);
      }
    }
    
    @media (max-width: 576px) {
      .header {
        padding: 12px 16px;
      }
      
      .product-detail-wrapper {
        padding: 20px;
      }
      
      .fbt-item {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>
  <header class="header">
    <button onclick="history.back()">
      <img width="25" height="25" src="https://img.icons8.com/puffy-filled/50/left.png" alt="left"/>
    </button>

    <div class="logo">कन्या<span class="raag">Raag</span></div>

    <a href="cart.php">
      <button>
        <img width="28" height="28" src="https://img.icons8.com/parakeet-line/50/shopping-cart-loaded.png" alt="shopping-cart-loaded"/>
      </button>
    </a>
  </header>

  <div class="container">
    <div class="breadcrumb">
      <a href="#">Home</a>
      <i class="fas fa-chevron-right"></i>
      <a href="#">Products</a>
      <i class="fas fa-chevron-right"></i>
      <span><?php echo $product['product_name']; ?></span>
    </div>
    
    <div class="product-detail-wrapper">
      <div class="product-gallery">
        <div class="gallery-main">
          <img id="mainImg" src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
        </div>
        <div class="gallery-thumbs">
          <div class="gallery-thumb active">
            <img src="<?php echo $product['product_image']; ?>" onclick="showImage(this)" alt="Thumbnail 1">
          </div>
          <?php
            if (!empty($product['images'])) {
                $extra = json_decode($product['images'], true);
                foreach ($extra as $index => $img) {
                    echo '<div class="gallery-thumb">
                            <img src="'.$img.'" onclick="showImage(this)" alt="Thumbnail '.($index+2).'">
                          </div>';
                }
            }
          ?>
        </div>
      </div>
      
      <div class="product-info">
        <h1><?php echo $product['product_name']; ?></h1>
        
        <div class="product-meta">
          <div class="stock in-stock"><?php echo $product['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?></div>
        </div>
        
        <div class="pricing">
          <div class="price-container">
            <div class="current-price">₹<?php echo $product['discount_price']; ?></div>
            <div class="original-price">₹<?php echo $product['original_price']; ?></div>
            <div class="discount"><?php echo round($product['discount_percent']); ?>% OFF</div>
          </div>
          <div class="tax">Inclusive of all taxes</div>
        </div>
        
        <div class="description">
          <p><?php echo $product['description']; ?></p>
        </div>
        
        <div class="details">
          <div class="detail-item">
            <div class="detail-label">Color:</div>
            <div class="detail-value"><?php echo $product['color']; ?></div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Fabric:</div>
            <div class="detail-value"><?php echo $product['fabric']; ?></div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Stock:</div>
            <div class="detail-value"><?php echo $product['stock']; ?> units available</div>
          </div>
        </div>
        
        <div class="sizes">
          <h3>Select Size:</h3>
          <div class="size-options">
            <?php
              $all_sizes = ['XS','S','M','L','XL','XXL','XXXL'];
              $available_sizes = explode(',', $product['sizes']);

              foreach($all_sizes as $size) {
                $isAvailable = in_array($size, $available_sizes);
                echo '<div class="size-circle '.($isAvailable ? '' : 'disabled').'" 
                          data-size="'.$size.'">'.$size.'</div>';
              }
            ?>
          </div>
        </div>
        
        <div class="action-buttons">
          <button class="btn btn-primary add-cart">
            <i class="fas fa-shopping-cart"></i> Add to Cart
          </button>
          <button class="btn btn-secondary buy-now">
            <i class="fas fa-bolt"></i> Buy Now
          </button>
        </div>
        
        <div class="shipping-info">
          <i class="fas fa-truck"></i>
          <div class="shipping-text">Free delivery on orders above ₹499. Order within 5 hrs 32 mins for same day dispatch.</div>
        </div>
      </div>
    </div>

    <div class="tabs-container">
      <div class="tab-headers">
        <div class="tab-link active" data-tab="details">Product Details</div>
        <div class="tab-link" data-tab="shipping">Shipping Details</div>
        <div class="tab-link" data-tab="style">Style & Fit Tips</div>
      </div>

      <div id="details" class="tab-content active">
        <p>
          Crafted from 100% premium cotton for ultimate comfort and breathability. Available in multiple sizes and colors. Soft texture ensures all-day wearability, with durable stitching for long-lasting use.
        </p>
      </div>

      <div id="shipping" class="tab-content">
        <ul>
          <li>Free shipping on orders above ₹499</li>
          <li>Estimated delivery: 3-7 business days</li>
          <li>Cash on Delivery available</li>
          <li>Easy returns within 15 days</li>
        </ul>
      </div>

      <div id="style" class="tab-content">
        <p>
          Perfect for casual outings, pair with jeans, chinos, or shorts. Slim-fit design; consider sizing up for a relaxed fit. Layer under jackets for a trendy look.
        </p>
      </div>
    </div>

    <!-- Frequently Bought Together -->
    <div class="fbt-section">
      <h2 class="section-title">Frequently Bought Together</h2>
      <div class="fbt-products">
        <?php
          $fbtQuery = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 2");
          $fbtProducts = [];
          $totalPrice = 0;

          while($p = $fbtQuery->fetch_assoc()) {
            $fbtProducts[] = $p;
            $totalPrice += $p['discount_price'];
            echo '<div class="fbt-item">
                    <img src="'.$p['product_image'].'" alt="'.$p['product_name'].'">
                    <h4>'.$p['product_name'].'</h4>
                    <p class="fbt-price">₹'.$p['discount_price'].'</p>
                  </div>';
          }

          $discountedTotal = $totalPrice - ($totalPrice * 0.10);
        ?>
      </div>

      <div style="text-align:center; margin-top:20px;">
        <button id="addAllFBT" class="btn btn-primary">
          <i class="fas fa-shopping-cart"></i> Add Both to Cart (10% OFF Applied)
        </button>
      </div>

      <div class="fbt-total">
        <h3>Total Price for 2 Products:  
          <span class="discounted-price">₹<?php echo $discountedTotal; ?> (10% OFF Applied)</span>
        </h3>
      </div>
    </div>

    <!-- Similar Products -->
    <div class="similar-section">
      <h2 class="section-title">Similar Products</h2>
      <div class="similar-products">
        <?php
          $similarQuery = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 8");

          while($sp = $similarQuery->fetch_assoc()) {
            echo '<div class="product-card">
                    <a href="product_detail.php?id='.$sp['id'].'">
                      <img src="'.$sp['product_image'].'" alt="'.$sp['product_name'].'">
                      <h4>'.$sp['product_name'].'</h4>
                      <p class="current-price">₹'.$sp['discount_price'].'</p>
                      <p class="original-price">₹'.$sp['original_price'].'</p>
                    </a>
                  </div>';
          }
        ?>
      </div>
    </div>

    <!-- Review Submission Form -->
    <div class="review-section">
      <h2 class="section-title">Write a Review</h2>
      <form id="reviewForm" action="submit_review.php" method="POST" enctype="multipart/form-data" class="review-form">
        <input type="hidden" name="product_id" value="<?php echo $id; ?>">

        <div class="form-group">
          <label for="user_name">Your Name:</label>
          <input type="text" name="user_name" id="user_name" required>
        </div>

        <div class="form-group">
          <label>Rating:</label>
          <div class="star-rating" id="ratingStars">
            <?php for($i=1;$i<=5;$i++){ ?>
              <i class="far fa-star" data-value="<?php echo $i; ?>"></i>
            <?php } ?>
          </div>
          <input type="hidden" name="rating" id="ratingValue" required>
        </div>

        <div class="form-group">
          <label for="review_text">Review:</label>
          <textarea name="review_text" id="review_text" rows="4" required></textarea>
        </div>

        <div class="form-group">
          <label for="review_image">Upload Image (optional):</label>
          <input type="file" name="review_image" id="review_image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Submit Review</button>
      </form>

      <!-- Reviews Section -->
      <h2 class="section-title">Reviews</h2>
      <?php
        $reviewQuery = $conn->query("SELECT * FROM reviews WHERE product_id = $id ORDER BY created_at DESC");
        $reviewCount = $reviewQuery->num_rows;
      ?>
      <p style="margin-bottom:20px; color:var(--gray);"><?php echo $reviewCount; ?> review<?php echo $reviewCount != 1 ? 's' : ''; ?> for this product</p>

      <div class="review-list">
        <?php
          while($review = $reviewQuery->fetch_assoc()) {
            echo '<div class="review-item">
                    <div class="review-header">
                      <div class="reviewer-name">'.$review['user_name'].'</div>
                      <button class="share-review" 
                              data-url="'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'#review'.$review['review_id'].'">
                        <i class="fas fa-share-alt"></i>
                      </button>
                    </div>
                    <div class="review-stars">';
                    for($i=1;$i<=5;$i++){
                      echo $i <= $review['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }
            echo '</div>
                    <p>'.htmlspecialchars($review['review_text']).'</p>';
                    
                    if(!empty($review['review_image'])) {
                      echo '<img src="'.$review['review_image'].'" alt="Review Image" class="review-image">';
                    }

            echo '</div>';
          }

          if($reviewCount == 0){
            echo '<p style="color:var(--gray);">No reviews yet for this product.</p>';
          }
        ?>
      </div>
    </div>
  </div>

  <div class="toast" id="addedToCart">
    <i class="fas fa-check-circle"></i>
    <span>Product added to cart successfully!</span>
  </div>

  <script>
    // Image Gallery
    function showImage(img) {
      document.getElementById("mainImg").src = img.src;
      
      const thumbs = document.querySelectorAll('.gallery-thumb');
      thumbs.forEach(thumb => thumb.classList.remove('active'));
      img.parentElement.classList.add('active');
    }
    
    // Size Selection
    const sizeCircles = document.querySelectorAll('.size-circle');
    let selectedSize = null;

    sizeCircles.forEach(circle => {
      circle.addEventListener('click', () => {
        if (circle.classList.contains('disabled')) return;
        
        sizeCircles.forEach(c => c.classList.remove('selected'));
        circle.classList.add('selected');
        selectedSize = circle.getAttribute('data-size');
      });
    });

    // Add to Cart
    document.querySelector('.add-cart').addEventListener('click', function() {
      if(!selectedSize) {
        alert("Please select a size before adding to cart!");
        return;
      }

      let product = {
        id: "<?php echo $product['id']; ?>",
        name: "<?php echo addslashes($product['product_name']); ?>",
        price: "<?php echo $product['discount_price']; ?>",
        image: "<?php echo $product['product_image']; ?>",
        qty: 1,
        size: selectedSize
      };

      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let existing = cart.find(p => p.id == product.id && p.size == selectedSize);
      if (existing) {
        existing.qty++;
      } else {
        cart.push(product);
      }
      localStorage.setItem("cart", JSON.stringify(cart));

      const toast = document.getElementById('addedToCart');
      toast.querySelector('span').innerText = product.name + " (" + product.size + ") added to cart!";
      toast.classList.add('show');
      setTimeout(() => { toast.classList.remove('show'); }, 3000);
    });

    // Buy Now
    document.querySelector('.buy-now').addEventListener('click', function() {
      if(!selectedSize) {
        alert("Please select a size before purchasing!");
        return;
      }
      alert('Proceeding to checkout...');
    });

    // Tabs
    const tabs = document.querySelectorAll(".tab-link");
    const contents = document.querySelectorAll(".tab-content");

    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));

        tab.classList.add("active");
        document.getElementById(tab.dataset.tab).classList.add("active");
      });
    });

    // Rating stars
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('ratingValue');

    stars.forEach(star => {
      star.addEventListener('click', () => {
        const value = star.getAttribute('data-value');
        ratingInput.value = value;
        stars.forEach(s => s.classList.replace('fas','far'));
        for(let i=0; i<value; i++){
          stars[i].classList.replace('far','fas');
        }
      });
    });

    // Share review
    document.querySelectorAll('.share-review').forEach(btn => {
      btn.addEventListener('click', function() {
        let url = this.getAttribute('data-url');
        if (navigator.share) {
          navigator.share({
            title: "Check out this review!",
            url: "https://" + url
          }).then(() => {
            console.log('Shared successfully');
          }).catch(console.error);
        } else {
          navigator.clipboard.writeText("https://" + url).then(() => {
            alert("Review link copied to clipboard!");
          });
        }
      });
    });

    // Frequently Bought Together
    const fbtProducts = <?php echo json_encode($fbtProducts); ?>;

    document.getElementById('addAllFBT').addEventListener('click', function() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      fbtProducts.forEach(p => {
        let product = {
          id: p.id,
          name: p.product_name,
          price: p.discount_price,
          image: p.product_image,
          qty: 1
        };

        let existing = cart.find(item => item.id == product.id);
        if(existing) {
          existing.qty++;
        } else {
          cart.push(product);
        }
      });

      localStorage.setItem("cart", JSON.stringify(cart));

      const toast = document.getElementById('addedToCart');
      toast.querySelector('span').innerText = "Both products added to cart!";
      toast.classList.add('show');
      setTimeout(() => { toast.classList.remove('show'); }, 3000);
    });
  </script>
</body>
</html>