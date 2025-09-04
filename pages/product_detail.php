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
      --primary: #db7140ff;
      --secondary: #ebc19bff;
      --accent: #d37f26ff;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #28a745;
      --warning: #ffc107;
      --gray: #6c757d;
      --light-gray: #e9ecef;
      --border-radius: 12px;
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Outfit', sans-serif;
      background-color: #f9fafb;
      color: var(--dark);
      line-height: 1.6;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    /* Header */
    .header {
      position: sticky;
      top: 0;
      z-index: 100;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark);
    }
    
    .raag {
      color: var(--accent);
    }
    
    /* Product Layout */
    .product-detail-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      margin: 40px 0;
    }
    
    @media (max-width: 992px) {
      .product-detail-container {
        grid-template-columns: 1fr;
        gap: 20px;
      }
    }
    
    /* Image Gallery */
    .gallery-container {
      position: relative;
    }
    
    @media (min-width: 993px) {
      .gallery-container {
        position: sticky;
        top: 80px;
      }
    }
    
    .main-image-container {
      position: relative;
    }
    
    .main-image {
      width: 100%;
      height: 500px;
      object-fit: contain;
      background: white;
      border-radius: var(--border-radius);
      padding: 20px;
      box-shadow: var(--shadow);
      margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
      .main-image {
        height: 350px;
      }
    }
    
    .share-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow);
      cursor: pointer;
      z-index: 10;
      transition: var(--transition);
    }
    
    .share-btn:hover {
      background: var(--primary);
      color: white;
    }
    
    .thumbnail-container {
      display: flex;
      gap: 10px;
      overflow-x: auto;
      padding: 5px 0;
    }
    
    .thumbnail {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      opacity: 0.7;
      transition: var(--transition);
      border: 2px solid transparent;
    }
    
    .thumbnail:hover, .thumbnail.active {
      opacity: 1;
      border-color: var(--primary);
    }
    
    /* Product Info */
    .product-info {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      box-shadow: var(--shadow);
    }
    
    .product-title {
      font-size: 1.8rem;
      margin-bottom: 10px;
      color: var(--dark);
    }
    
    @media (max-width: 768px) {
      .product-title {
        font-size: 1.5rem;
      }
    }
    
    .stock-badge {
      display: inline-block;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
      margin-bottom: 15px;
    }
    
    .in-stock {
      background: rgba(40, 167, 69, 0.15);
      color: var(--success);
    }
    
    .out-of-stock {
      background: rgba(220, 53, 69, 0.15);
      color: #dc3545;
    }
    
    /* Pricing */
    .pricing-container {
      margin: 20px 0;
      padding: 15px;
      background: var(--light);
      border-radius: var(--border-radius);
    }
    
    .current-price {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark);
    }
    
    .original-price {
      font-size: 1.2rem;
      text-decoration: line-through;
      color: var(--gray);
      margin: 0 10px;
    }
    
    .discount-badge {
      background: var(--secondary);
      color: white;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
    }
    
    .tax-text {
      font-size: 0.9rem;
      color: var(--gray);
      margin-top: 5px;
    }
    
    /* Description */
    .description {
      margin: 20px 0;
      line-height: 1.8;
    }
    
    /* Details */
    .details-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin: 20px 0;
    }
    
    @media (max-width: 480px) {
      .details-grid {
        grid-template-columns: 1fr;
      }
    }
    
    .detail-item {
      display: flex;
      flex-direction: column;
    }
    
    .detail-label {
      font-weight: 600;
      color: var(--gray);
      font-size: 0.9rem;
    }
    
    .detail-value {
      font-weight: 500;
    }
    
    /* Size Selector */
    .size-selector {
      margin: 25px 0;
    }
    
    .size-title {
      font-weight: 600;
      margin-bottom: 12px;
    }
    
    .size-options {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    
    .size-option {
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid var(--light-gray);
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition);
    }
    
    .size-option:hover {
      border-color: var(--primary);
    }
    
    .size-option.selected {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }
    
    .size-option.disabled {
      opacity: 0.4;
      cursor: not-allowed;
      text-decoration: line-through;
    }
    
    /* Action Buttons */
    .action-buttons {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin: 25px 0;
    }
    
    @media (max-width: 480px) {
      .action-buttons {
        grid-template-columns: 1fr;
      }
    }
    
    .btn {
      padding: 15px;
      border-radius: var(--border-radius);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    
    .btn-primary {
      background: var(--primary);
      color: white;
    }
    
    .btn-primary:hover {
      background: #602e17ff;
      transform: translateY(-2px);
    }
    
    .btn-secondary {
      background: var(--secondary);
      color: white;
    }
    
    .btn-secondary:hover {
      background: #C75D2c;
      transform: translateY(-2px);
    }
    
    /* Shipping Info */
    .shipping-info {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 15px;
      background: rgba(56, 134, 255, 0.1);
      border-radius: var(--border-radius);
      color: var(--primary);
      font-weight: 500;
    }
    
    /* Tabs */
    .tabs-container {
      background: white;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      margin: 40px 0;
    }
    
    .tab-headers {
      display: flex;
      border-bottom: 1px solid var(--light-gray);
      overflow-x: auto;
      scrollbar-width: none;
    }
    
    .tab-headers::-webkit-scrollbar {
      display: none;
    }
    
    .tab-header {
      padding: 15px 25px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      border-bottom: 3px solid transparent;
      white-space: nowrap;
    }
    
    .tab-header.active {
      color: var(--primary);
      border-bottom-color: var(--primary);
    }
    
    .tab-content {
      padding: 25px;
      display: none;
    }
    
    .tab-content.active {
      display: block;
    }
    
    .tab-content table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .tab-content table tr {
      border-bottom: 1px solid var(--light-gray);
    }
    
    .tab-content table th,
    .tab-content table td {
      padding: 12px 15px;
      text-align: left;
    }
    
    .tab-content table th {
      width: 30%;
      color: var(--gray);
      font-weight: 500;
    }
    
    .tab-content ul {
      padding-left: 20px;
    }
    
    .tab-content li {
      margin-bottom: 10px;
      position: relative;
      padding-left: 15px;
    }
    
    .tab-content li:before {
      content: "•";
      color: var(--primary);
      font-weight: bold;
      position: absolute;
      left: 0;
    }
    
    /* Toast Notification */
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: var(--success);
      color: white;
      padding: 15px 20px;
      border-radius: var(--border-radius);
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: var(--shadow);
      transform: translateY(100px);
      opacity: 0;
      transition: var(--transition);
      z-index: 1000;
    }
    
    .toast.show {
      transform: translateY(0);
      opacity: 1;
    }
    
    /* Section Headers */
    .section-header {
      font-size: 1.5rem;
      margin: 40px 0 20px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .section-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background: var(--primary);
      border-radius: 3px;
    }
    
    /* FBT Section - IMPROVED */
    .fbt-container {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      box-shadow: var(--shadow);
      margin: 40px 0;
    }
    
    .fbt-products {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      gap: 20px;
      margin: 25px 0;
    }
    
    @media (max-width: 768px) {
      .fbt-products {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto auto;
        gap: 15px;
      }
      
      .fbt-plus {
        grid-column: 1 / span 2;
        grid-row: 2;
        margin: 10px 0;
      }
    }
    
    .fbt-plus {
      font-size: 2rem;
      font-weight: 700;
      color: var(--gray);
      text-align: center;
    }
    
    .fbt-item {
      text-align: center;
      padding: 15px;
      border: 1px solid var(--light-gray);
      border-radius: var(--border-radius);
      transition: var(--transition);
    }
    
    .fbt-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow);
    }
    
    .fbt-item-image-container {
      position: relative;
      width: 100%;
      height: 180px;
      margin-bottom: 15px;
      overflow: hidden;
      border-radius: 8px;
    }
    
    .fbt-item-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--transition);
    }
    
    .fbt-item:hover .fbt-item-image {
      transform: scale(1.05);
    }
    
    .fbt-item-title {
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 8px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      height: 48px;
    }
    
    .fbt-item-price {
      color: var(--primary);
      font-weight: 700;
      font-size: 1.1rem;
    }
    
    .fbt-total {
      background: var(--light);
      padding: 20px;
      border-radius: var(--border-radius);
      text-align: center;
      margin-top: 20px;
    }
    
    /* Product Cards - IMPROVED */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
      margin: 30px 0;
    }
    
    @media (max-width: 640px) {
      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
      }
    }
    
    .product-card {
      background: white;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
      display: flex;
      flex-direction: column;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .product-image-container {
      position: relative;
      overflow: hidden;
      height: 280px;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .product-image {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      padding: 15px;
      transition: var(--transition);
    }
    
    .product-card:hover .product-image {
      transform: scale(1.05);
    }
    
    .product-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: var(--transition);
    }
    
    .product-card:hover .product-overlay {
      opacity: 1;
    }
    
    .quick-view-btn {
      background: white;
      border: none;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow);
      transition: var(--transition);
    }
    
    .quick-view-btn:hover {
      background: var(--primary);
      color: white;
      transform: scale(1.1);
    }
    
    .product-card-content {
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    
    .product-card-title {
      font-size: 1rem;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--dark);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      height: 48px;
    }
    
    .price-container {
      margin-bottom: 15px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 5px 10px;
    }
    
    .product-card-price {
      color: var(--primary);
      font-weight: 700;
      font-size: 1.1rem;
    }
    
    .product-card-original-price {
      color: var(--gray);
      text-decoration: line-through;
      font-size: 0.9rem;
    }
    
    .discount-percent {
      color: var(--secondary);
      font-size: 0.8rem;
      font-weight: 600;
      background: rgba(255, 0, 110, 0.1);
      padding: 2px 6px;
      border-radius: 10px;
    }
    
    .buy-now-btn {
      background: var(--secondary);
      color: white;
      border: none;
      padding: 10px;
      border-radius: var(--border-radius);
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      margin-top: auto;
    }
    
    .buy-now-btn:hover {
      background: #e0005f;
      transform: translateY(-2px);
    }
    
    @media (max-width: 480px) {
      .product-image-container {
        height: 200px;
      }
      
      .buy-now-btn {
        font-size: 0.9rem;
        padding: 8px;
      }
    }
    
    /* Review Form */
    .review-form {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      box-shadow: var(--shadow);
      margin: 40px 0;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      display: block;
      margin-bottom: 8px;
      font-weight: 6 00;
    }
    
    .form-input, .form-textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--light-gray);
      border-radius: 8px;
      font-family: inherit;
      font-size: 1rem;
    }
    
    .form-textarea {
      min-height: 120px;
      resize: vertical;
    }
    
    .star-rating {
      display: flex;
      gap: 5px;
    }
    
    .star {
      font-size: 1.8rem;
      color: var(--warning);
      cursor: pointer;
    }
    
    /* Reviews List */
    .reviews-container {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      box-shadow: var(--shadow);
      margin: 40px 0;
    }
    
    .review-item {
      padding: 20px 0;
      border-bottom: 1px solid var(--light-gray);
    }
    
    .review-item:last-child {
      border-bottom: none;
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
    
    .share-review-btn {
      background: none;
      border: none;
      color: var(--gray);
      cursor: pointer;
      font-size: 1.1rem;
    }
    
    .review-stars {
      color: var(--warning);
      margin-bottom: 10px;
    }
    
    .review-image {
      max-width: 150px;
      max-height: 150px;
      object-fit: cover;
      border-radius: 8px;
      margin-top: 10px;
    }
    
    /* Share Modal */
    .share-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 2000;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
    }
    
    .share-modal.show {
      opacity: 1;
      visibility: visible;
    }
    
    .share-modal-content {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      width: 90%;
      max-width: 400px;
      box-shadow: var(--shadow);
    }
    
    .share-options {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px 0;
    }
    
    .share-option {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: var(--transition);
      padding: 10px;
      border-radius: 8px;
    }
    
    .share-option:hover {
      background: var(--light);
    }
    
    .share-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: white;
    }
    
    .share-whatsapp .share-icon {
      background: #25D366;
    }
    
    .share-facebook .share-icon {
      background: #3b5998;
    }
    
    .share-twitter .share-icon {
      background: #1DA1F2;
    }
    
    .share-link .share-icon {
      background: var(--primary);
    }
    
    .share-modal-close {
      background: var(--light-gray);
      border: none;
      padding: 10px 20px;
      border-radius: var(--border-radius);
      cursor: pointer;
      font-weight: 600;
      margin-top: 15px;
      width: 100%;
      transition: var(--transition);
    }
    
    .share-modal-close:hover {
      background: var(--gray);
      color: white;
    }
    
    /* New: Product Badges */
    .product-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: var(--secondary);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 0.7rem;
      font-weight: 600;
      z-index: 5;
    }
    
    /* New: Color Options */
    .color-options {
      display: flex;
      gap: 8px;
      margin: 10px 0;
    }
    
    .color-option {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      cursor: pointer;
      border: 2px solid transparent;
      transition: var(--transition);
    }
    
    .color-option.selected {
      border-color: var(--dark);
      transform: scale(1.1);
    }
    
    /* New: Wishlist Button */
    .wishlist-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: white;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow);
      z-index: 5;
      transition: var(--transition);
    }
    
    .wishlist-btn:hover, .wishlist-btn.active {
      background: var(--secondary);
      color: white;
    }
  </style>
</head>
<body>
<header class="header">
  <button onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
  <div class="logo">कन्या<span class="raag">Raag</span></div>
  <a href="cart.php"><button><i class="fas fa-shopping-cart"></i></button></a>
</header>

<div class="container">
  <div class="product-detail-container">
    <!-- Image Gallery -->
    <div class="gallery-container">
      <div class="main-image-container">
        <img id="mainImage" src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="main-image">
        <div class="share-btn" id="shareProductBtn">
          <i class="fas fa-share-alt"></i>
        </div>
        <!-- Wishlist Button -->
        <div class="wishlist-btn" id="wishlistBtn">
          <i class="far fa-heart"></i>
        </div>
        <!-- Product Badge -->
        <?php if($product['discount_percent'] > 20): ?>
          <div class="product-badge"><?php echo round($product['discount_percent']); ?>% OFF</div>
        <?php endif; ?>
      </div>
      
      <div class="thumbnail-container">
        <img src="<?php echo $product['product_image']; ?>" onclick="changeImage(this)" class="thumbnail active" alt="Thumbnail 1">
        <?php
          if (!empty($product['images'])) {
            $extra = json_decode($product['images'], true);
            foreach ($extra as $index => $img) {
              echo '<img src="'.$img.'" onclick="changeImage(this)" class="thumbnail" alt="Thumbnail '.($index+2).'">';
            }
          }
        ?>
      </div>
    </div>
    
    <!-- Product Info -->
    <div class="product-info">
      <h1 class="product-title"><?php echo $product['product_name']; ?></h1>
      <div class="stock-badge <?php echo $product['stock'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
        <?php echo $product['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?>
      </div>
      
      <div class="pricing-container">
        <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
          <div class="current-price">₹<?php echo $product['discount_price']; ?></div>
          <div class="original-price">₹<?php echo $product['original_price']; ?></div>
          <div class="discount-badge"><?php echo round($product['discount_percent']); ?>% OFF</div>
        </div>
        <div class="tax-text">Inclusive of all taxes</div>
      </div>
      
      <div class="description">
        <p><?php echo $product['description']; ?></p>
      </div>
      
      <!-- Color Options (if available) -->
      <?php if(!empty($product['colors'])): ?>
      <div class="color-selector">
        <h3 class="size-title">Select Color:</h3>
        <div class="color-options">
          <?php
            $colors = explode(',', $product['colors']);
            foreach($colors as $color) {
              echo '<div class="color-option" style="background-color: '.$color.';" data-color="'.$color.'"></div>';
            }
          ?>
        </div>
      </div>
      <?php endif; ?>
      
      <!-- Size Selector -->
      <div class="size-selector">
        <h3 class="size-title">Select Size:</h3>
        <div class="size-options">
          <?php
            $all_sizes = ['XS','S','M','L','XL','XXL','XXXL'];
            $available_sizes = explode(',', $product['sizes']);
            foreach($all_sizes as $size) {
              $isAvailable = in_array($size, $available_sizes);
              echo '<div class="size-option '.($isAvailable ? '' : 'disabled').'" data-size="'.$size.'">'.$size.'</div>';
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
        <span>Order Dispatch the same day</span>
      </div>
    </div>
  </div>
  
  <!-- Product Tabs -->
  <div class="tabs-container">
    <div class="tab-headers">
      <div class="tab-header active" data-tab="details">Product Details</div>
      <div class="tab-header" data-tab="shipping">Shipping & Returns</div>
      <div class="tab-header" data-tab="style">Style Tips</div>
    </div>
    
    <div id="details" class="tab-content active">
      <table>
        <tr>
          <th>Name</th>
          <td><?php echo $product['product_name']; ?></td>
        </tr>
        <tr>
          <th>Color</th>
          <td><?php echo $product['color']; ?></td>
        </tr>
        <tr>
          <th>Fabric</th>
          <td><?php echo $product['fabric']; ?></td>
        </tr>
        <tr>
          <th>Stock</th>
          <td><?php echo $product['stock']; ?> units available</td>
        </tr>
        <tr>
          <th>Sizes</th>
          <td><?php echo implode(', ', explode(',', $product['sizes'])); ?></td>
        </tr>
        <tr>
          <th>Description</th>
          <td><?php echo $product['description']; ?></td>
        </tr>
      </table>
    </div>
    
    <div id="shipping" class="tab-content">
      <table>
        <tr>
          <th>Shipping</th>
          <td>
            <ul>
              <li>Free shipping on orders above ₹499</li>
              <li>Estimated delivery: 3-7 business days</li>
              <li>Cash on Delivery available</li>
            </ul>
          </td>
        </tr>
        <tr>
          <th>Returns</th>
          <td>
            <ul>
              <li>Easy returns within 15 days</li>
              <li>No questions asked return policy</li>
              <li>Free return shipping for defective items</li>
            </ul>
          </td>
        </tr>
      </table>
    </div>
    
    <div id="style" class="tab-content">
      <table>
        <tr>
          <th>Occasion</th>
          <td>Perfect for casual outings, parties, and festive occasions</td>
        </tr>
        <tr>
          <th>Styling</th>
          <td>Pair with jeans, chinos, or traditional bottoms. Accessorize with statement jewelry for a complete look.</td>
        </tr>
        <tr>
          <th>Fit</th>
          <td>Slim-fit design; consider sizing up for a relaxed fit. Layer under jackets for a trendy look.</td>
        </tr>
        <tr>
          <th>Care</th>
          <td>Hand wash recommended. Dry in shade. Iron at low temperature.</td>
        </tr>
      </table>
    </div>
  </div>
  
  <!-- Frequently Bought Together - IMPROVED -->
  <h2 class="section-header">Frequently Bought Together</h2>
  <div class="fbt-container">
    <div class="fbt-products">
      <?php
        $fbtQuery = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 2");
        $fbtProducts = [];
        $totalPrice = 0;
        
        while($p = $fbtQuery->fetch_assoc()) {
          $fbtProducts[] = $p;
          $totalPrice += $p['discount_price'];
          echo '<div class="fbt-item">
                  <div class="fbt-item-image-container">
                    <img src="'.$p['product_image'].'" alt="'.$p['product_name'].'" class="fbt-item-image">
                  </div>
                  <h4 class="fbt-item-title">'.$p['product_name'].'</h4>
                  <p class="fbt-item-price">₹'.$p['discount_price'].'</p>
                  
                </div>';
          
          if (count($fbtProducts) < 2) {
            echo '<div class="fbt-plus">+</div>';
          }
        }
        
        $discountedTotal = $totalPrice - ($totalPrice * 0.10);
      ?>
    </div>
    
    <button id="addAllFBT" class="btn btn-primary" style="display: block; width: 100%; margin: 20px 0;">
      <i class="fas fa-shopping-cart"></i> Add Both to Cart (Save ₹<?php echo number_format($totalPrice - $discountedTotal, 2); ?>)
    </button>
    
    <div class="fbt-total">
      <h3>Total: ₹<?php echo number_format($discountedTotal, 2); ?> <span style="text-decoration: line-through; color: var(--gray); font-size: 1rem;">₹<?php echo number_format($totalPrice, 2); ?></span></h3>
      <p>You save ₹<?php echo number_format($totalPrice - $discountedTotal, 2); ?> with this bundle</p>
    </div>
  </div>
  
  <!-- Similar Products -->
  <h2 class="section-header">You Might Also Like</h2>
  <div class="products-grid">
    <?php
      $similarQuery = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 4");
      while($sp = $similarQuery->fetch_assoc()) {
        echo '<div class="product-card">
                <div class="product-image-container">
                  <img src="'.$sp['product_image'].'" alt="'.$sp['product_name'].'" class="product-image">
                  <div class="product-overlay">
                    <button class="quick-view-btn" data-id="'.$sp['id'].'">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>';
        if($sp['discount_percent'] > 15) {
          echo '<div class="product-badge">'.round($sp['discount_percent']).'% OFF</div>';
        }
        echo '<div class="wishlist-btn">
                    <i class="far fa-heart"></i>
                  </div>
                </div>
                <div class="product-card-content">
                  <h3 class="product-card-title">'.$sp['product_name'].'</h3>
                  <div class="price-container">
                    <span class="product-card-price">₹'.$sp['discount_price'].'</span>
                    <span class="product-card-original-price">₹'.$sp['original_price'].'</span>
                    <span class="discount-percent">'.round(($sp['original_price'] - $sp['discount_price']) / $sp['original_price'] * 100).'% off</span>
                  </div>
                  <button class="buy-now-btn" data-id="'.$sp['id'].'">
                    <i class="fas fa-bolt"></i> Buy Now
                  </button>
                </div>
              </div>';
      }
    ?>
  </div>
  
  <!-- Reviews -->
  <h2 class="section-header">Customer Reviews</h2>
  <div class="review-form">
    <h3>Write a Review</h3>
    <form id="reviewForm" action="submit_review.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="product_id" value="<?php echo $id; ?>">
      
      <div class="form-group">
        <label class="form-label">Your Name</label>
        <input type="text" name="user_name" class="form-input" required>
      </div>
      
      <div class="form-group">
        <label class="form-label">Rating</label>
        <div class="star-rating">
          <?php for($i=1;$i<=5;$i++){ ?>
            <i class="far fa-star star" data-value="<?php echo $i; ?>"></i>
          <?php } ?>
        </div>
        <input type="hidden" name="rating" id="ratingValue" required>
      </div>
      
      <div class="form-group">
        <label class="form-label">Review</label>
        <textarea name="review_text" class="form-textarea" required></textarea>
      </div>
      
      <div class="form-group">
        <label class="form-label">Upload Image (optional)</label>
        <input type="file" name="review_image" accept="image/*">
      </div>
      
      <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
  </div>
  
  <div class="reviews-container">
    <?php
      $reviewQuery = $conn->query("SELECT * FROM reviews WHERE product_id = $id ORDER BY created_at DESC");
      $reviewCount = $reviewQuery->num_rows;
    ?>
    <h3><?php echo $reviewCount; ?> Review<?php echo $reviewCount != 1 ? 's' : ''; ?></h3>
    
    <div class="reviews-list">
      <?php
        if ($reviewCount > 0) {
          while($review = $reviewQuery->fetch_assoc()) {
            echo '<div class="review-item">
                    <div class="review-header">
                      <div class="reviewer-name">'.$review['user_name'].'</div>
                      <button class="share-review-btn" data-url="'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'#review'.$review['review_id'].'">
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
              echo '<img src="'.$review['review_image'].'" class="review-image">';
            }
            
            echo '</div>';
          }
        } else {
          echo '<p>No reviews yet for this product.</p>';
        }
      ?>
    </div>
  </div>
</div>

<div class="toast" id="addedToCart">
  <i class="fas fa-check-circle"></i>
  <span>Product added to cart successfully!</span>
</div>

<!-- Share Modal -->
<div class="share-modal" id="shareModal">
  <div class="share-modal-content">
    <h3>Share this product</h3>
    <div class="share-options">
      <div class="share-option share-whatsapp" data-platform="whatsapp">
        <div class="share-icon">
          <i class="fab fa-whatsapp"></i>
        </div>
        <span>WhatsApp</span>
      </div>
      <div class="share-option share-facebook" data-platform="facebook">
        <div class="share-icon">
          <i class="fab fa-facebook-f"></i>
        </div>
        <span>Facebook</span>
      </div>
      <div class="share-option share-twitter" data-platform="twitter">
        <div class="share-icon">
          <i class="fab fa-twitter"></i>
        </div>
        <span>Twitter</span>
      </div>
      <div class="share-option share-link" data-platform="link">
        <div class="share-icon">
          <i class="fas fa-link"></i>
        </div>
        <span>Copy Link</span>
      </div>
    </div>
    <button class="share-modal-close">Close</button>
  </div>
</div>

<script>
  // Image Gallery
  function changeImage(img) {
    document.getElementById("mainImage").src = img.src;
    
    // Update active thumbnail
    const thumbs = document.querySelectorAll('.thumbnail');
    thumbs.forEach(thumb => thumb.classList.remove('active'));
    img.classList.add('active');
  }
  
  // Size Selection
  const sizeOptions = document.querySelectorAll('.size-option:not(.disabled)');
  sizeOptions.forEach(option => {
    option.addEventListener('click', () => {
      sizeOptions.forEach(opt => opt.classList.remove('selected'));
      option.classList.add('selected');
    });
  });
  
  // Color Selection
  const colorOptions = document.querySelectorAll('.color-option');
  colorOptions.forEach(option => {
    option.addEventListener('click', () => {
      colorOptions.forEach(opt => opt.classList.remove('selected'));
      option.classList.add('selected');
    });
  });
  
  // Tabs
  const tabHeaders = document.querySelectorAll('.tab-header');
  const tabContents = document.querySelectorAll('.tab-content');
  
  tabHeaders.forEach(header => {
    header.addEventListener('click', () => {
      const tabId = header.getAttribute('data-tab');
      
      // Update active tab header
      tabHeaders.forEach(h => h.classList.remove('active'));
      header.classList.add('active');
      
      // Show corresponding content
      tabContents.forEach(content => {
        content.classList.remove('active');
        if (content.id === tabId) {
          content.classList.add('active');
        }
      });
    });
  });
  
  // Star Rating
  const stars = document.querySelectorAll('.star');
  const ratingInput = document.getElementById('ratingValue');
  
  stars.forEach(star => {
    star.addEventListener('click', () => {
      const value = star.getAttribute('data-value');
      ratingInput.value = value;
      
      // Update star display
      stars.forEach(s => {
        if (s.getAttribute('data-value') <= value) {
          s.classList.remove('far');
          s.classList.add('fas');
        } else {
          s.classList.remove('fas');
          s.classList.add('far');
        }
      });
    });
  });
  
  // Add to Cart
  document.querySelector('.add-cart').addEventListener('click', function() {
    const selectedSize = document.querySelector('.size-option.selected');
    const selectedColor = document.querySelector('.color-option.selected');
    
    if (!selectedSize) {
      alert('Please select a size before adding to cart.');
      return;
    }
    
    const product = {
      id: "<?php echo $product['id']; ?>",
      name: "<?php echo addslashes($product['product_name']); ?>",
      price: "<?php echo $product['discount_price']; ?>",
      image: "<?php echo $product['product_image']; ?>",
      size: selectedSize.getAttribute('data-size'),
      color: selectedColor ? selectedColor.getAttribute('data-color') : '',
      qty: 1
    };
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingIndex = cart.findIndex(item => item.id === product.id && item.size === product.size && item.color === product.color);
    
    if (existingIndex > -1) {
      cart[existingIndex].qty += 1;
    } else {
      cart.push(product);
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Show toast
    const toast = document.getElementById('addedToCart');
    toast.querySelector('span').textContent = `${product.name} (Size: ${product.size}) added to cart!`;
    toast.classList.add('show');
    
    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  });
  
  // Buy Now
  document.querySelector('.buy-now').addEventListener('click', function() {
    const selectedSize = document.querySelector('.size-option.selected');
    const selectedColor = document.querySelector('.color-option.selected');
    
    if (!selectedSize) {
      alert('Please select a size before proceeding.');
      return;
    }
    
    // Add to cart then redirect to checkout
    const product = {
      id: "<?php echo $product['id']; ?>",
      name: "<?php echo addslashes($product['product_name']); ?>",
      price: "<?php echo $product['discount_price']; ?>",
      image: "<?php echo $product['product_image']; ?>",
      size: selectedSize.getAttribute('data-size'),
      color: selectedColor ? selectedColor.getAttribute('data-color') : '',
      qty: 1
    };
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingIndex = cart.findIndex(item => item.id === product.id && item.size === product.size && item.color === product.color);
    
    if (existingIndex > -1) {
      cart[existingIndex].qty += 1;
    } else {
      cart.push(product);
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Redirect to checkout
    window.location.href = 'checkout.php';
  });
  
  // Frequently Bought Together
  document.getElementById('addAllFBT').addEventListener('click', function() {
    const fbtProducts = <?php echo json_encode($fbtProducts); ?>;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    fbtProducts.forEach(product => {
      const existingIndex = cart.findIndex(item => item.id == product.id);
      
      if (existingIndex > -1) {
        cart[existingIndex].qty += 1;
      } else {
        cart.push({
          id: product.id,
          name: product.product_name,
          price: product.discount_price,
          image: product.product_image,
          qty: 1
        });
      }
    });
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Show toast
    const toast = document.getElementById('addedToCart');
    toast.querySelector('span').textContent = 'Both products added to cart!';
    toast.classList.add('show');
    
    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  });
  
  // Add individual FBT items
  document.querySelectorAll('.add-fbt-item').forEach(btn => {
    btn.addEventListener('click', function() {
      const productId = this.getAttribute('data-id');
      const fbtProducts = <?php echo json_encode($fbtProducts); ?>;
      const product = fbtProducts.find(p => p.id == productId);
      
      if (product) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingIndex = cart.findIndex(item => item.id == product.id);
        
        if (existingIndex > -1) {
          cart[existingIndex].qty += 1;
        } else {
          cart.push({
            id: product.id,
            name: product.product_name,
            price: product.discount_price,
            image: product.product_image,
            qty: 1
          });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Show toast
        const toast = document.getElementById('addedToCart');
        toast.querySelector('span').textContent = `${product.product_name} added to cart!`;
        toast.classList.add('show');
        
        setTimeout(() => {
          toast.classList.remove('show');
        }, 3000);
      }
    });
  });
  
  // Share Review
  document.querySelectorAll('.share-review-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const url = this.getAttribute('data-url');
      
      if (navigator.share) {
        navigator.share({
          title: 'Check out this review!',
          url: 'https://' + url
        });
      } else {
        navigator.clipboard.writeText('https://' + url)
          .then(() => alert('Review link copied to clipboard!'));
      }
    });
  });
  
  // Share Product Modal
  const shareModal = document.getElementById('shareModal');
  const shareProductBtn = document.getElementById('shareProductBtn');
  const shareModalClose = document.querySelector('.share-modal-close');
  
  shareProductBtn.addEventListener('click', () => {
    shareModal.classList.add('show');
  });
  
  shareModalClose.addEventListener('click', () => {
    shareModal.classList.remove('show');
  });
  
  // Close modal when clicking outside
  shareModal.addEventListener('click', (e) => {
    if (e.target === shareModal) {
      shareModal.classList.remove('show');
    }
  });
  
  // Share options functionality
  const shareOptions = document.querySelectorAll('.share-option');
  const productUrl = window.location.href;
  const productTitle = "<?php echo addslashes($product['product_name']); ?>";
  
  shareOptions.forEach(option => {
    option.addEventListener('click', function() {
      const platform = this.getAttribute('data-platform');
      let shareUrl = '';
      
      switch(platform) {
        case 'whatsapp':
          shareUrl = `https://wa.me/?text=${encodeURIComponent(productTitle + ' ' + productUrl)}`;
          window.open(shareUrl, '_blank');
          break;
        case 'facebook':
          shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(productUrl)}`;
          window.open(shareUrl, '_blank', 'width=600,height=400');
          break;
        case 'twitter':
          shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(productTitle)}&url=${encodeURIComponent(productUrl)}`;
          window.open(shareUrl, '_blank', 'width=600,height=400');
          break;
        case 'link':
          navigator.clipboard.writeText(productUrl)
            .then(() => {
              alert('Product link copied to clipboard!');
            });
          break;
      }
      
      shareModal.classList.remove('show');
    });
  });
  
  // Buy Now button functionality for product cards
  document.querySelectorAll('.buy-now-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const productId = this.getAttribute('data-id');
      
      // In a real implementation, you would add to cart and redirect
      // For now, we'll redirect to the product detail page
      window.location.href = 'product_detail.php?id=' + productId;
    });
  });
  
  // Quick view button functionality
  document.querySelectorAll('.quick-view-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const productId = this.getAttribute('data-id');
      alert('Quick view feature would show product ' + productId);
      // Implement a modal with quick product details
    });
  });
  
  // Wishlist functionality
  const wishlistBtn = document.getElementById('wishlistBtn');
  const wishlistButtons = document.querySelectorAll('.wishlist-btn');
  
  wishlistBtn.addEventListener('click', function() {
    this.classList.toggle('active');
    const icon = this.querySelector('i');
    
    if (this.classList.contains('active')) {
      icon.classList.remove('far');
      icon.classList.add('fas');
      // Add to wishlist logic
    } else {
      icon.classList.remove('fas');
      icon.classList.add('far');
      // Remove from wishlist logic
    }
  });
  
  // Initialize product cards wishlist buttons
  wishlistButtons.forEach(btn => {
    if (btn !== wishlistBtn) {
      btn.addEventListener('click', function() {
        this.classList.toggle('active');
        const icon = this.querySelector('i');
        
        if (this.classList.contains('active')) {
          icon.classList.remove('far');
          icon.classList.add('fas');
        } else {
          icon.classList.remove('fas');
          icon.classList.add('far');
        }
      });
    }
  });
</script>
</body>
</html>