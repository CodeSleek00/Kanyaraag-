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
  <link rel="stylesheet" href="product-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  
  <style>
    :root {
      --primary: #3a86ff;
      --secondary: #ff006e;
      --accent: #8338ec;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --light-gray: #e9ecef;
      --success: #28a745;
      --border: #dee2e6;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9fafb;
      color: var(--dark);
      line-height: 1.6;
    }
    
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
    .product-detail {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: var(--shadow);
    }
    
    @media (max-width: 992px) {
      .product-detail {
        grid-template-columns: 1fr;
        gap: 30px;
      }
    }
    
    /* Image Gallery */
    .gallery {
      position: relative;
    }
    
    .gallery-main {
      position: relative;
      border-radius: 12px;
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
      border-radius: 8px;
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
      border-radius: 8px;
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
      background-color: #2a75ff;
      transform: translateY(-2px);
    }
    
    .btn-secondary {
      background-color: var(--secondary);
      color: white;
      flex: 1;
    }
    
    .btn-secondary:hover {
      background-color: #e00064;
      transform: translateY(-2px);
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
      border-radius: 8px;
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
      border-radius: 8px;
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
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
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
    }
  </style>
</head>
<body>
<header class="header">
    <!-- Back button -->
    <button onclick="history.back()"><img width="25" height="25" src="https://img.icons8.com/puffy-filled/50/left.png" alt="left"/>
</button>

    <!-- Text logo -->
    <div class="logo">कन्या<span class="raag">Raag</span></div>

    <!-- Cart button -->
    <a href="cart.php"><button><img width="28" height="28" src="https://img.icons8.com/parakeet-line/50/shopping-cart-loaded.png" alt="shopping-cart-loaded"/></button></a>
  </header>
<div class="container">
  <!-- Breadcrumb Navigation -->
  
  
  <div class="product-detail">
    <!-- Product Gallery -->
    <div class="gallery">
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
    
    <!-- Product Information -->
    <div class="product-info">
      <h1><?php echo $product['product_name']; ?></h1>
      
      <div class="product-meta">
        <div class="rating">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span>4.5</span>
        </div>
        <div class="reviews">(128 reviews)</div>
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
      
      <div class="action-buttons">
      <button class="btn btn-primary add-cart"
              data-id="<?php echo $product['id']; ?>"
              data-name="<?php echo $product['product_name']; ?>"
              data-price="<?php echo $product['discount_price']; ?>"
              data-image="<?php echo $product['product_image']; ?>"
              data-stock="<?php echo $product['stock']; ?>"
              <?php echo ($product['stock'] <= 0 ? "disabled" : ""); ?>>
          <i class="fas fa-shopping-cart"></i> <?php echo $product['stock'] > 0 ? "Add to Cart" : "Out of Stock"; ?>
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
</div>

<div class="toast" id="addedToCart">
  <i class="fas fa-check-circle"></i>
  <span>Product added to cart successfully!</span>
</div>

<script>
  function showImage(img) {
    document.getElementById("mainImg").src = img.src;
    
    // Update active thumbnail
    const thumbs = document.querySelectorAll('.gallery-thumb');
    thumbs.forEach(thumb => thumb.classList.remove('active'));
    img.parentElement.classList.add('active');
  }
  
  // Add to cart functionality with toast notification
  document.querySelector('.add-cart').addEventListener('click', function() {
    const toast = document.getElementById('addedToCart');
    toast.classList.add('show');
    
    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  });
  
  // Buy now functionality
  document.querySelector('.buy-now').addEventListener('click', function() {
    alert('Proceeding to checkout...');
    // In a real application, this would redirect to checkout page
  });
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