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
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --white: #ffffff;
      --primary: #C75D2c;
      --primary-light: #f9eae5;
      --dark: #333333;
      --light-gray: #f5f5f5;
      --medium-gray: #e0e0e0;
      --text-dark: #333333;
      --text-light: #777777;
      --success: #4caf50;
      --shadow: 0 4px 20px rgba(0,0,0,0.08);
      --shadow-light: 0 2px 10px rgba(0,0,0,0.05);
      --transition: all 0.3s ease;
    }
    
    * { 
      margin: 0; 
      padding: 0; 
      box-sizing: border-box; 
      -webkit-tap-highlight-color: transparent; 
    }
    
    body { 
      font-family: 'Outfit', sans-serif; 
      background-color: var(--white); 
      color: var(--text-dark); 
      padding-top: 80px; 
      padding-bottom: 40px;
      line-height: 1.6;
    }
    
    /* Header Styles */
    .header { 
      position: fixed; 
      top: 0; 
      left: 0; 
      width: 100%; 
      background: var(--white); 
      box-shadow: var(--shadow-light); 
      z-index: 1000; 
      padding: 16px 5%; 
      display: flex; 
      align-items: center; 
      justify-content: space-between; 
      height: 80px; 
    }
    
    .back-btn { 
      background: none; 
      border: none; 
      font-size: 20px; 
      cursor: pointer; 
      color: var(--primary); 
      padding: 8px; 
      border-radius: 50%; 
      width: 44px; 
      height: 44px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      transition: var(--transition);
    }
    
    .back-btn:hover { 
      background-color: var(--primary-light); 
    }
    
    .logo { 
      font-family: 'Outfit', sans-serif;
      font-size: 24px; 
      font-weight: 700; 
      color: var(--primary); 
      text-decoration: none; 
      text-align: center; 
      line-height: 1.2;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    
    .logo-icon {
      font-size: 22px;
      transform: translateY(-1px);
    }
    
    .cart-icon { 
      position: relative; 
      font-size: 20px; 
      color: var(--primary); 
      text-decoration: none; 
      padding: 8px; 
      border-radius: 50%; 
      width: 44px; 
      height: 44px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      transition: var(--transition);
    }
    
    .cart-icon:hover {
      background-color: var(--primary-light);
    }
    
    .cart-count { 
      position: absolute; 
      top: 2px; 
      right: 2px; 
      background: var(--primary); 
      color: white; 
      font-size: 11px; 
      width: 18px; 
      height: 18px; 
      border-radius: 50%; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      font-weight: 600; 
    }
    
    /* Page Title */
    .page-title-container {
      text-align: center;
      margin: 30px 0;
      position: relative;
    }
    
    .page-title { 
      font-family: 'Outfit', sans-serif;
      font-size: 32px; 
      font-weight: 600;
      color: var(--dark); 
      position: relative;
      display: inline-block;
      padding-bottom: 12px;
    }
    
    .page-title:after { 
      content: ''; 
      display: block; 
      width: 60px; 
      height: 3px; 
      background: var(--primary); 
      margin: 8px auto 0;
      border-radius: 2px;
    }
    
    .page-subtitle {
      font-size: 16px;
      color: var(--text-light);
      margin-top: 8px;
      font-weight: 400;
      max-width: 600px;
      margin: 8px auto 0;
    }
    
    /* Products Grid */
    .products-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .products { 
      display: grid; 
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
      gap: 24px; 
    }
    
    .card { 
      background: var(--white); 
      border-radius: 12px; 
      overflow: hidden; 
      box-shadow: var(--shadow-light); 
      transition: var(--transition);
      position: relative;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow);
    }
    
    .card-image { 
      position: relative; 
      width: 100%; 
      aspect-ratio: 3/4; 
      overflow: hidden; 
    }
    
    .card-image img { 
      width: 100%; 
      height: 100%; 
      object-fit: cover; 
      transition: transform 0.5s ease; 
    }
    
    .card:hover .card-image img {
      transform: scale(1.05);
    }
    
    .card-badge { 
      position: absolute; 
      top: 12px; 
      left: 12px; 
      background: var(--primary); 
      color: white; 
      padding: 4px 8px; 
      border-radius: 4px; 
      font-size: 11px; 
      font-weight: 600; 
      letter-spacing: 0.5px;
    }
    
    .wishlist-btn {
      position: absolute;
      top: 12px;
      right: 12px;
      background: rgba(255, 255, 255, 0.9);
      border: none;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      color: var(--text-light);
    }
    
    .wishlist-btn:hover {
      background: var(--white);
      color: var(--primary);
    }
    
    .wishlist-btn.active {
      color: var(--primary);
    }
    
    .card-content { 
      padding: 16px; 
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    
    .card-title { 
      font-size: 16px; 
      font-weight: 500; 
      margin-bottom: 8px; 
      color: var(--text-dark);
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      height: 44px;
    }
    
    .price-container { 
      display: flex; 
      align-items: center; 
      margin-bottom: 12px; 
      flex-wrap: wrap; 
      gap: 6px;
    }
    
    .current-price { 
      font-weight: 600; 
      font-size: 18px; 
      color: var(--primary); 
    }
    
    .original-price { 
      font-size: 14px; 
      text-decoration: line-through; 
      color: var(--text-light); 
    }
    
    .discount { 
      font-size: 13px; 
      color: var(--success); 
      font-weight: 500; 
      background: rgba(76, 175, 80, 0.1);
      padding: 2px 6px;
      border-radius: 4px;
    }
    
    .card-actions { 
      display: flex; 
      flex-direction: column; 
      gap: 10px; 
      margin-top: auto;
    }
    
    .add-to-cart, .buy-now { 
      width: 100%; 
      padding: 12px; 
      border: none; 
      border-radius: 8px; 
      font-family: 'Outfit', sans-serif;
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
      background: var(--primary-light); 
      color: var(--primary); 
      border: 1px solid var(--primary-light);
    }
    
    .add-to-cart:hover:not(:disabled) {
      background: var(--primary);
      color: var(--white);
    }
    
    .buy-now { 
      background: var(--primary); 
      color: white; 
      text-decoration: none; 
    }
    
    .buy-now:hover:not(:disabled) {
      background: #b35226;
      box-shadow: 0 4px 12px rgba(199, 93, 44, 0.2);
    }
    
    .add-to-cart:disabled, .buy-now:disabled { 
      background: var(--light-gray); 
      color: var(--text-light); 
      cursor: not-allowed; 
      border: 1px solid var(--medium-gray);
    }
    
    .stock-info { 
      font-size: 13px; 
      color: var(--text-light); 
      margin-top: 6px; 
      display: flex;
      align-items: center;
      gap: 4px;
    }
    
    .stock-info i {
      font-size: 12px;
    }
    
    .in-stock {
      color: var(--success);
    }
    
    .low-stock {
      color: #ff9800;
    }
    
    .out-of-stock {
      color: #f44336;
    }
    
    .size-selector { 
      margin: 12px 0; 
    }
    
    .size-title { 
      font-size: 14px; 
      margin-bottom: 8px; 
      color: var(--text-dark); 
      font-weight: 500;
    }
    
    .size-options { 
      display: flex; 
      gap: 8px; 
      flex-wrap: wrap; 
    }
    
    .size-option { 
      border: 1px solid var(--medium-gray); 
      padding: 6px 10px; 
      font-size: 12px; 
      border-radius: 4px; 
      cursor: pointer; 
      user-select: none; 
      transition: var(--transition);
      min-width: 36px;
      text-align: center;
    }
    
    .size-option.selected { 
      background: var(--primary); 
      color: white; 
      border-color: var(--primary); 
    }
    
    .size-option.disabled { 
      background: var(--light-gray); 
      color: #aaa; 
      cursor: not-allowed; 
      border-style: dashed; 
    }
    
    /* Toast Notification */
    .toast { 
      position: fixed; 
      bottom: 24px; 
      left: 50%; 
      transform: translateX(-50%); 
      background: var(--primary); 
      color: white; 
      padding: 14px 24px; 
      border-radius: 8px; 
      box-shadow: var(--shadow); 
      z-index: 1001; 
      opacity: 0; 
      transition: opacity 0.3s ease; 
      max-width: 90%; 
      text-align: center;
      font-weight: 500;
    }
    
    .toast.show { 
      opacity: 1; 
    }
    
    /* Empty State */
    .empty-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 60px 20px;
      color: var(--text-light);
    }
    
    .empty-state i {
      font-size: 48px;
      margin-bottom: 16px;
      color: var(--medium-gray);
    }
    
    .empty-state p {
      font-size: 18px;
      margin-bottom: 24px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .header {
        padding: 12px 16px;
        height: 70px;
      }
      
      .page-title {
        font-size: 28px;
      }
      
      .products {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
      }
      
      .products-container {
        padding: 0 16px;
      }
    }
    
    @media (max-width: 480px) {
      .products {
        grid-template-columns: 2fr;
        gap: 20px;
      }
      
      .page-title {
        font-size: 24px;
      }
      
      .page-subtitle {
        font-size: 14px;
        padding: 0 16px;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <button class="back-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
    <a href="index.php" class="logo">
      <i class="fas fa-vest logo-icon"></i>
      <span>कन्याRaag</span>
    </a>
    <a href="cart.php" class="cart-icon"><i class="fas fa-shopping-bag"></i><span class="cart-count" id="cart-count">0</span></a>
  </header>

  <div class="page-title-container">
    <h1 class="page-title">Women's Collection</h1>
    <p class="page-subtitle">Discover our exquisite range of traditional and contemporary fashion</p>
  </div>
  
  <div class="toast" id="toast"></div>

  <div class="products-container">
    <div class="products">
      <?php
      $sql = "SELECT * FROM products ORDER BY RAND()";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $discount_percent = 0;
          if ($row['original_price'] > 0 && $row['original_price'] > $row['discount_price']) {
            $discount_percent = round(($row['original_price'] - $row['discount_price']) / $row['original_price'] * 100);
          }
          
          // Determine stock status
          $stock_class = 'in-stock';
          $stock_icon = 'fas fa-check-circle';
          $stock_text = 'In stock';
          
          if ($row['stock'] <= 0) {
            $stock_class = 'out-of-stock';
            $stock_icon = 'fas fa-times-circle';
            $stock_text = 'Out of stock';
          } else if ($row['stock'] < 10) {
            $stock_class = 'low-stock';
            $stock_icon = 'fas fa-exclamation-circle';
            $stock_text = 'Low stock';
          }
          
          echo "<div class='card'>
            <div class='card-image'>
              <a href='product_detail.php?id=".$row['id']."'><img src='".$row['product_image']."' alt='".$row['product_name']."'></a>";
              if ($discount_percent > 0) {
                echo "<div class='card-badge'>".$discount_percent."% OFF</div>";
              }
          echo "<button class='wishlist-btn' data-id='".$row['id']."' aria-label='Add to wishlist'>
                  <i class='far fa-heart'></i>
                </button>
            </div>
            <div class='card-content'>
              <h3 class='card-title'>".$row['product_name']."</h3>
              <div class='price-container'>
                <span class='current-price'>₹".$row['discount_price']."</span>";
                if ($row['original_price'] > $row['discount_price']) {
                  echo "<span class='original-price'>₹".$row['original_price']."</span>
                  <span class='discount'>".$discount_percent."% off</span>";
                }
          echo "</div>
              <p class='stock-info'><i class='".$stock_icon." ".$stock_class."'></i> <span class='".$stock_class."'>".$stock_text."</span></p>";
              
          // === Size Selector ===
          if (!empty($row['sizes'])) {
            $all_sizes = ['XS','S','M','L','XL','XXL','XXXL'];
            $available_sizes = explode(',', $row['sizes']);
            echo "<div class='size-selector'>
                    <h4 class='size-title'>Select Size:</h4>
                    <div class='size-options'>";
            foreach ($all_sizes as $size) {
              $isAvailable = in_array($size, $available_sizes);
              echo '<div class="size-option '.($isAvailable ? '' : 'disabled').'" data-size="'.$size.'">'.$size.'</div>';
            }
            echo "</div></div>";
          }

          echo "<div class='card-actions'>
                <button class='add-to-cart' 
                  data-id='".$row['id']."'
                  data-name='".$row['product_name']."'
                  data-price='".$row['discount_price']."'
                  data-image='".$row['product_image']."'
                  data-stock='".$row['stock']."'
                  ".($row['stock'] <= 0 ? "disabled" : "").">
                  ".($row['stock'] > 0 ? "<i class='fas fa-shopping-cart'></i> Add to Cart" : "Out of Stock")."
                </button>
                <button class='buy-now' data-id='".$row['id']."' ".($row['stock'] <= 0 ? "disabled" : "").">
                  <i class='fas fa-bolt'></i> Buy Now
                </button>
              </div>
            </div>
          </div>";
        }
      } else {
        echo "<div class='empty-state'><i class='fas fa-tshirt'></i><p>No products available in this category yet!</p></div>";
      }
      if ($conn) { $conn->close(); }
      ?>
    </div>
  </div>

  <script>
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const totalItems = cart.reduce((total, item) => total + (item.qty || 1), 0);
      document.getElementById('cart-count').textContent = totalItems;
    }
    
    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.textContent = message;
      toast.classList.add('show');
      setTimeout(() => { toast.classList.remove('show'); }, 3000);
    }
    
    // Wishlist functionality
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        this.classList.toggle('active');
        const icon = this.querySelector('i');
        if (this.classList.contains('active')) {
          icon.classList.remove('far');
          icon.classList.add('fas');
          showToast('Added to wishlist');
        } else {
          icon.classList.remove('fas');
          icon.classList.add('far');
          showToast('Removed from wishlist');
        }
      });
    });
    
    // Size Selection
    document.querySelectorAll('.size-options').forEach(container => {
      container.addEventListener('click', e => {
        if (e.target.classList.contains('size-option') && !e.target.classList.contains('disabled')) {
          container.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('selected'));
          e.target.classList.add('selected');
        }
      });
    });
    
    // Add to Cart
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', function() {
        if (this.disabled) return;
        const card = this.closest('.card');
        const selectedSize = card.querySelector('.size-option.selected');
        if (!selectedSize) { showToast('Please select a size first!'); return; }
        const product = {
          id: this.getAttribute('data-id'),
          name: this.getAttribute('data-name'),
          price: this.getAttribute('data-price'),
          image: this.getAttribute('data-image'),
          size: selectedSize.getAttribute('data-size'),
          qty: 1
        };
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingItemIndex = cart.findIndex(item => item.id === product.id && item.size === product.size);
        if (existingItemIndex > -1) { cart[existingItemIndex].qty += 1; }
        else { cart.push(product); }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        showToast('Added: ' + product.name + ' (' + product.size + ')');
      });
    });
    
    // Buy Now
    document.querySelectorAll('.buy-now').forEach(btn => {
      btn.addEventListener('click', function() {
        if (this.disabled) return;
        const card = this.closest('.card');
        const selectedSize = card.querySelector('.size-option.selected');
        if (!selectedSize) { showToast('Please select a size first!'); return; }
        const id = this.getAttribute('data-id');
        window.location.href = 'product_detail.php?id=' + id + '&size=' + selectedSize.getAttribute('data-size');
      });
    });
    
    document.addEventListener('DOMContentLoaded', updateCartCount);
  </script>
</body>
</html>