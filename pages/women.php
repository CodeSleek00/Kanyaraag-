<?php
include '../db/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kanyaraag - Women's Collection</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Swiper JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <style>
    :root {
      --white: #ffffff;
      --cream: #f8f5f2;
      --light-brown: #d7ccc8;
      --medium-brown: #a1887f;
      --dark-brown: #5d4037;
      --dark-brown-rgb: 93, 64, 55;
      --accent: #8d6e63;
      --text-dark: #333333;
      --text-light: #777777;
      --gold: #c6a17a;
      --shadow: 0 4px 24px rgba(0,0,0,0.05);
      --shadow-hover: 0 8px 32px rgba(0,0,0,0.12);
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--cream);
      color: var(--text-dark);
      padding-top: 80px;
      line-height: 1.6;
    }
    
    /* Sticky Header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: var(--white);
      box-shadow: var(--shadow);
      z-index: 1000;
      padding: 15px 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: var(--transition);
    }
    
    .header.scrolled {
      padding: 10px 5%;
    }
    
    .back-btn {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: var(--dark-brown);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }
    
    .back-btn:hover {
      background: rgba(var(--dark-brown-rgb), 0.1);
    }
    
    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--dark-brown);
      text-decoration: none;
      letter-spacing: 0.5px;
    }
    
    .cart-icon {
      position: relative;
      font-size: 22px;
      color: var(--dark-brown);
      text-decoration: none;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }
    
    .cart-icon:hover {
      background: rgba(var(--dark-brown-rgb), 0.1);
    }
    
    .cart-count {
      position: absolute;
      top: -5px;
      right: -5px;
      background: var(--gold);
      color: white;
      font-size: 11px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }
    
    /* Page Title */
    .page-title-container {
      text-align: center;
      margin: 40px 0 30px;
      position: relative;
    }
    
    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 38px;
      font-weight: 700;
      color: var(--dark-brown);
      position: relative;
      display: inline-block;
      margin-bottom: 15px;
    }
    
    .page-title:after {
      content: '';
      display: block;
      width: 80px;
      height: 3px;
      background: var(--gold);
      margin: 15px auto 0;
    }
    
    .page-subtitle {
      font-size: 16px;
      color: var(--text-light);
      max-width: 600px;
      margin: 0 auto;
    }
    
    /* Filter Section */
    .filter-section {
      max-width: 1200px;
      margin: 0 auto 30px;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
    }
    
    .filter-options {
      display: flex;
      gap: 15px;
    }
    
    .filter-btn, .sort-btn {
      background: var(--white);
      border: 1px solid var(--light-brown);
      padding: 8px 16px;
      border-radius: 30px;
      font-family: 'Montserrat', sans-serif;
      font-size: 14px;
      color: var(--text-dark);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: var(--transition);
    }
    
    .filter-btn:hover, .sort-btn:hover {
      border-color: var(--medium-brown);
    }
    
    .view-options {
      display: flex;
      gap: 10px;
    }
    
    .view-btn {
      background: var(--white);
      border: 1px solid var(--light-brown);
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
    }
    
    .view-btn.active {
      background: var(--dark-brown);
      color: white;
      border-color: var(--dark-brown);
    }
    
    /* Products Grid */
    .products-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .products {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 30px;
    }
    
    .products.list-view {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    
    .card {
      background: var(--white);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    
    .products.list-view .card {
      flex-direction: row;
      height: auto;
    }
    
    .card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-hover);
    }
    
    .card-image-container {
      position: relative;
      width: 100%;
      overflow: hidden;
    }
    
    .products.list-view .card-image-container {
      width: 300px;
      flex-shrink: 0;
    }
    
    .card-image {
      width: 100%;
      padding-top: 120%; /* 4:3 Aspect Ratio */
      position: relative;
    }
    
    .products.list-view .card-image {
      padding-top: 100%;
    }
    
    .card-image img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.7s ease;
    }
    
    .card:hover .card-image img {
      transform: scale(1.08);
    }
    
    .image-swiper {
      width: 100%;
      height: 100%;
    }
    
    .swiper-pagination-bullet {
      background: var(--white);
      opacity: 0.6;
      width: 6px;
      height: 6px;
    }
    
    .swiper-pagination-bullet-active {
      background: var(--gold);
      opacity: 1;
      width: 10px;
      border-radius: 10px;
    }
    
    .card-badge {
      position: absolute;
      top: 15px;
      left: 15px;
      background: var(--gold);
      color: white;
      padding: 6px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 600;
      z-index: 10;
    }
    
    .wishlist-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: var(--white);
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-dark);
      z-index: 10;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .wishlist-btn:hover {
      color: #e53935;
      transform: scale(1.1);
    }
    
    .wishlist-btn.active {
      color: #e53935;
    }
    
    .card-content {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    
    .products.list-view .card-content {
      padding: 25px;
      justify-content: center;
    }
    
    .card-title {
      font-size: 16px;
      font-weight: 500;
      margin-bottom: 8px;
      color: var(--text-dark);
    }
    
    .card-desc {
      font-size: 14px;
      color: var(--text-light);
      margin-bottom: 15px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .products.list-view .card-desc {
      -webkit-line-clamp: 3;
    }
    
    .price-container {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      flex-wrap: wrap;
      gap: 5px;
    }
    
    .current-price {
      font-weight: 600;
      font-size: 18px;
      color: var(--dark-brown);
    }
    
    .original-price {
      font-size: 14px;
      text-decoration: line-through;
      color: var(--text-light);
      margin-left: 8px;
    }
    
    .discount {
      font-size: 14px;
      color: #388e3c;
      font-weight: 500;
      margin-left: 8px;
    }
    
    .card-footer {
      margin-top: auto;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .stock-info {
      font-size: 13px;
      color: var(--text-light);
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .stock-bar {
      height: 4px;
      background: #f0f0f0;
      border-radius: 2px;
      overflow: hidden;
      margin-top: 3px;
    }
    
    .stock-level {
      height: 100%;
      background: var(--gold);
      border-radius: 2px;
    }
    
    .card-actions {
      display: flex;
      gap: 10px;
    }
    
    .add-to-cart, .buy-now {
      flex: 1;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-family: 'Montserrat', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    .add-to-cart {
      background: var(--cream);
      color: var(--dark-brown);
      border: 1px solid var(--light-brown);
    }
    
    .add-to-cart:hover:not(:disabled) {
      background: var(--dark-brown);
      color: white;
      border-color: var(--dark-brown);
    }
    
    .buy-now {
      background: var(--dark-brown);
      color: white;
    }
    
    .buy-now:hover:not(:disabled) {
      background: var(--accent);
      transform: translateY(-2px);
    }
    
    .add-to-cart:disabled, .buy-now:disabled {
      background: #f5f5f5;
      color: #bdbdbd;
      cursor: not-allowed;
    }
    
    /* Thumbnails */
    .thumbnails {
      display: flex;
      gap: 8px;
      margin-top: 12px;
      flex-wrap: wrap;
    }
    
    .thumb {
      width: 40px;
      height: 40px;
      border-radius: 6px;
      overflow: hidden;
      border: 1px solid #eeeeee;
      cursor: pointer;
      transition: var(--transition);
    }
    
    .thumb:hover {
      border-color: var(--medium-brown);
      transform: scale(1.05);
    }
    
    .thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    /* Quick View Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.8);
      z-index: 2000;
      overflow-y: auto;
      padding: 40px 20px;
    }
    
    .modal-content {
      background: var(--white);
      max-width: 1000px;
      margin: 0 auto;
      border-radius: 16px;
      overflow: hidden;
      position: relative;
      animation: modalFadeIn 0.4s ease;
    }
    
    @keyframes modalFadeIn {
      from { opacity: 0; transform: translateY(50px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .close-modal {
      position: absolute;
      top: 20px;
      right: 20px;
      background: var(--white);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      cursor: pointer;
      z-index: 10;
      transition: var(--transition);
    }
    
    .close-modal:hover {
      transform: rotate(90deg);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .header {
        padding: 12px 5%;
      }
      
      .page-title {
        font-size: 30px;
      }
      
      .filter-section {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .products.list-view .card {
        flex-direction: column;
      }
      
      .products.list-view .card-image-container {
        width: 100%;
      }
      
      .card-actions {
        flex-direction: column;
      }
    }
    
    @media (max-width: 576px) {
      .products {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
      }
      
      .filter-options {
        flex-wrap: wrap;
      }
    }
    
    /* Loading animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
      animation: fadeIn 0.5s ease forwards;
      opacity: 0;
    }
    
    /* Empty state */
    .empty-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 60px 20px;
    }
    
    .empty-state i {
      font-size: 70px;
      color: var(--light-brown);
      margin-bottom: 20px;
    }
    
    .empty-state p {
      font-size: 18px;
      color: var(--text-light);
      margin-bottom: 30px;
    }
    
    .empty-state .btn {
      background: var(--dark-brown);
      color: white;
      padding: 12px 24px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 500;
      display: inline-block;
      transition: var(--transition);
    }
    
    .empty-state .btn:hover {
      background: var(--accent);
      transform: translateY(-3px);
    }
    
    /* Quick view button */
    .quick-view-btn {
      position: absolute;
      bottom: -40px;
      left: 0;
      width: 100%;
      background: var(--dark-brown);
      color: white;
      padding: 10px;
      text-align: center;
      font-size: 14px;
      cursor: pointer;
      transition: var(--transition);
      opacity: 0;
    }
    
    .card-image-container:hover .quick-view-btn {
      bottom: 0;
      opacity: 1;
    }
  </style>
</head>
<body>
  <!-- Sticky Header -->
  <header class="header">
    <button class="back-btn" onclick="history.back()">
      <i class="fas fa-arrow-left"></i>
    </button>
    <a href="index.php" class="logo">Kanyaraag</a>
    <a href="cart.php" class="cart-icon">
      <i class="fas fa-shopping-bag"></i>
      <span class="cart-count" id="cart-count">0</span>
    </a>
  </header>

  <!-- Page Title -->
  <div class="page-title-container">
    <h1 class="page-title">Women's Collection</h1>
    <p class="page-subtitle">Discover our exquisite range of premium fashion crafted with attention to detail and timeless elegance.</p>
  </div>

  <!-- Filter Section -->
  <div class="filter-section">
    <div class="filter-options">
      <button class="filter-btn">
        <i class="fas fa-filter"></i> Filter
      </button>
      <button class="sort-btn">
        <i class="fas fa-sort"></i> Sort By
      </button>
      <span id="product-count">12 products</span>
    </div>
    <div class="view-options">
      <button class="view-btn grid-view active" data-view="grid">
        <i class="fas fa-th"></i>
      </button>
      <button class="view-btn list-view" data-view="list">
        <i class="fas fa-list"></i>
      </button>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="products-container">
    <div class="products" id="products-grid">
      <?php
      $sql = "SELECT * FROM products ORDER BY RAND()";
      $result = $conn->query($sql);
      
      if ($result && $result->num_rows > 0) {
        $product_count = 0;
        while ($row = $result->fetch_assoc()) {
          $product_count++;
          $discount_percent = 0;
          if ($row['original_price'] > 0 && $row['original_price'] > $row['discount_price']) {
            $discount_percent = round(($row['original_price'] - $row['discount_price']) / $row['original_price'] * 100);
          }
          
          // Calculate stock percentage for visual indicator
          $stock_percentage = min(100, ($row['stock'] / 50) * 100); // Assuming 50 is "full" stock
          
          echo "<div class='card' data-id='".$row['id']."' data-category='".($row['category'] ?? '')."' data-price='".$row['discount_price']."'>
            <div class='card-image-container'>
              <div class='card-image'>
                <div class='swiper image-swiper'>
                  <div class='swiper-wrapper'>";
                  
                  // Main image
                  echo "<div class='swiper-slide'>
                    <img src='".$row['product_image']."' alt='".$row['product_name']."'>
                  </div>";
                  
                  // Additional images
                  if (!empty($row['images'])) {
                    $images = json_decode($row['images'], true);
                    if (!empty($images) && is_array($images)) {
                      foreach ($images as $img) {
                        echo "<div class='swiper-slide'>
                          <img src='".$img."' alt='".$row['product_name']."'>
                        </div>";
                      }
                    }
                  }
                  
                  echo "</div>
                  <div class='swiper-pagination'></div>
                </div>
              </div>";
              
              if ($discount_percent > 0) {
                echo "<div class='card-badge'>".$discount_percent."% OFF</div>";
              }
              
              echo "<button class='wishlist-btn'>
                <i class='far fa-heart'></i>
              </button>
              
              <div class='quick-view-btn'>Quick View</div>
            </div>
            
            <div class='card-content'>
              <h3 class='card-title'>".$row['product_name']."</h3>
              <p class='card-desc'>".$row['description']."</p>
              
              <div class='price-container'>
                <span class='current-price'>₹".number_format($row['discount_price'])."</span>";
                
                if ($row['original_price'] > $row['discount_price']) {
                  echo "<span class='original-price'>₹".number_format($row['original_price'])."</span>
                  <span class='discount'>(".$discount_percent."% OFF)</span>";
                }
                
          echo "</div>
              
              <div class='card-footer'>
                <div class='stock-info'>
                  <span>Stock: ".$row['stock']."</span>
                  <div class='stock-bar'><div class='stock-level' style='width: ".$stock_percentage."%'></div></div>
                </div>
                
                <div class='card-actions'>
                  <button class='add-to-cart' 
                    data-id='".$row['id']."'
                    data-name='".$row['product_name']."'
                    data-price='".$row['discount_price']."'
                    data-image='".$row['product_image']."'
                    data-stock='".$row['stock']."'
                    ".($row['stock'] <= 0 ? "disabled" : "").">
                    ".($row['stock'] > 0 ? "<i class='fas fa-shopping-cart'></i> Add to Cart" : "Out of Stock")."
                  </button>
                  
                  <a href='product_detail.php?id=".$row['id']."' style='text-decoration: none;'>
                    <button class='buy-now' ".($row['stock'] <= 0 ? "disabled" : "").">
                      <i class='fas fa-bolt'></i> Buy Now
                    </button>
                  </a>
                </div>
              </div>
            </div>
          </div>";
        }
        
        echo "<script>document.getElementById('product-count').textContent = '".$product_count." products';</script>";
      } else {
        echo "<div class='empty-state'>
          <i class='fas fa-heart'></i>
          <p>No products available in this category yet!</p>
          <a href='index.php' class='btn'>Continue Shopping</a>
        </div>";
      }
      
      // Close connection
      if ($conn) {
        $conn->close();
      }
      ?>
    </div>
  </div>

  <!-- Quick View Modal -->
  <div class="modal" id="quickViewModal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <div id="modal-content"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    // Initialize cart count
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const totalItems = cart.reduce((total, item) => total + (item.qty || 1), 0);
      document.getElementById('cart-count').textContent = totalItems;
    }
    
    // Initialize image swipers
    function initSwipers() {
      const swipers = document.querySelectorAll('.image-swiper');
      swipers.forEach(swiperEl => {
        new Swiper(swiperEl, {
          direction: 'horizontal',
          loop: true,
          pagination: {
            el: swiperEl.querySelector('.swiper-pagination'),
            clickable: true,
          },
          autoplay: {
            delay: 3000,
          },
        });
      });
    }
    
    // Add to Cart functionality
    function setupAddToCart() {
      document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
          if (this.disabled) return;
          
          const product = {
            id: this.getAttribute('data-id'),
            name: this.getAttribute('data-name'),
            price: this.getAttribute('data-price'),
            image: this.getAttribute('data-image'),
            qty: 1
          };
          
          let cart = JSON.parse(localStorage.getItem('cart')) || [];
          const existingItemIndex = cart.findIndex(item => item.id === product.id);
          
          if (existingItemIndex > -1) {
            cart[existingItemIndex].qty += 1;
          } else {
            cart.push(product);
          }
          
          localStorage.setItem('cart', JSON.stringify(cart));
          updateCartCount();
          
          // Show feedback
          const originalText = this.innerHTML;
          this.innerHTML = '<i class="fas fa-check"></i> Added!';
          this.style.background = '#4caf50';
          this.style.color = 'white';
          
          setTimeout(() => {
            this.innerHTML = originalText;
            this.style.background = '';
            this.style.color = '';
          }, 1500);
        });
      });
    }
    
    // Toggle wishlist
    function setupWishlist() {
      document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const icon = this.querySelector('i');
          if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            this.classList.add('active');
          } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            this.classList.remove('active');
          }
        });
      });
    }
    
    // View toggle
    function setupViewToggle() {
      const viewButtons = document.querySelectorAll('.view-btn');
      const productsGrid = document.getElementById('products-grid');
      
      viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          const viewType = this.getAttribute('data-view');
          
          viewButtons.forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          
          if (viewType === 'list') {
            productsGrid.classList.add('list-view');
          } else {
            productsGrid.classList.remove('list-view');
          }
        });
      });
    }
    
    // Quick view modal
    function setupQuickView() {
      const modal = document.getElementById('quickViewModal');
      const closeBtn = document.querySelector('.close-modal');
      const quickViewBtns = document.querySelectorAll('.quick-view-btn');
      
      quickViewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          const card = this.closest('.card');
          const productId = card.getAttribute('data-id');
          
          // In a real implementation, you would fetch product details via AJAX
          // For this example, we'll just show a placeholder
          document.getElementById('modal-content').innerHTML = `
            <div style="padding: 40px; text-align: center;">
              <h2>Quick View</h2>
              <p>Product details would load here for ID: ${productId}</p>
            </div>
          `;
          
          modal.style.display = 'block';
          document.body.style.overflow = 'hidden';
        });
      });
      
      closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
      });
      
      window.addEventListener('click', function(event) {
        if (event.target === modal) {
          modal.style.display = 'none';
          document.body.style.overflow = 'auto';
        }
      });
    }
    
    // Header scroll effect
    function setupHeaderScroll() {
      const header = document.querySelector('.header');
      window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }
      });
    }
    
    // Stagger card animations
    function animateCards() {
      const cards = document.querySelectorAll('.card');
      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
      });
    }
    
    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      updateCartCount();
      initSwipers();
      setupAddToCart();
      setupWishlist();
      setupViewToggle();
      setupQuickView();
      setupHeaderScroll();
      animateCards();
    });
  </script>
</body>
</html>