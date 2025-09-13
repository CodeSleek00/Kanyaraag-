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
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --white: #ffffff;
      --cream: #f8f5f0;
      --light-brown: #d7ccc8;
      --medium-brown: #a1887f;
      --dark-brown: #5d4037;
      --accent: #8d6e63;
      --terracotta: #C75D2c;
      --text-dark: #333333;
      --text-light: #777777;
      --shadow: 0 4px 20px rgba(0,0,0,0.08);
      --shadow-light: 0 2px 10px rgba(0,0,0,0.04);
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
      background-color: var(--cream); 
      color: var(--text-dark); 
      padding-top: 80px; 
      padding-bottom: 40px; 
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
      padding: 15px 20px; 
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
      color: var(--terracotta); 
      padding: 8px; 
      border-radius: 50%; 
      width: 45px; 
      height: 45px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      transition: var(--transition);
    }
    
    .back-btn:hover { 
      background-color: rgba(199, 93, 44, 0.1); 
    }
    
    .logo { 
      font-family: 'Playfair Display', serif; 
      font-size: 26px; 
      font-weight: 700; 
      color: var(--terracotta); 
      text-decoration: none; 
      text-align: center; 
      line-height: 1.2; 
      letter-spacing: 0.5px;
    }
    
    .cart-icon { 
      position: relative; 
      font-size: 20px; 
      color: var(--terracotta); 
      text-decoration: none; 
      padding: 8px; 
      border-radius: 50%; 
      width: 45px; 
      height: 45px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      transition: var(--transition);
    }
    
    .cart-icon:hover {
      background-color: rgba(199, 93, 44, 0.1);
    }
    
    .cart-count { 
      position: absolute; 
      top: 2px; 
      right: 2px; 
      background: var(--terracotta); 
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
    .page-title { 
      text-align: center; 
      margin: 30px 20px; 
      font-family: 'Playfair Display', serif; 
      font-size: 32px; 
      color: var(--dark-brown); 
      position: relative; 
      line-height: 1.3; 
      font-weight: 600;
    }
    
    .page-title:after { 
      content: ''; 
      display: block; 
      width: 60px; 
      height: 3px; 
      background: var(--terracotta); 
      margin: 12px auto; 
      border-radius: 2px;
    }
    
    /* Products Grid */
    .products { 
      display: grid; 
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
      gap: 25px; 
      padding: 0 20px; 
      max-width: 1200px; 
      margin: 0 auto; 
    }
    
    /* Product Card */
    .card { 
      background: var(--white); 
      border-radius: 12px; 
      overflow: hidden; 
      box-shadow: var(--shadow-light); 
      transition: var(--transition);
      position: relative;
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
      background: var(--terracotta); 
      color: white; 
      padding: 4px 8px; 
      border-radius: 4px; 
      font-size: 12px; 
      font-weight: 500; 
      z-index: 2;
    }
    
    .quick-view {
      position: absolute;
      top: 12px;
      right: 12px;
      background: rgba(255, 255, 255, 0.9);
      color: var(--terracotta);
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      opacity: 0;
      transition: var(--transition);
      z-index: 2;
    }
    
    .card:hover .quick-view {
      opacity: 1;
    }
    
    .card-content { 
      padding: 16px; 
    }
    
    .card-title { 
      font-size: 16px; 
      font-weight: 500; 
      margin-bottom: 8px; 
      color: var(--text-dark); 
      line-height: 1.4;
      height: 44px;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }
    
    .price-container { 
      display: flex; 
      align-items: center; 
      margin-bottom: 12px; 
      flex-wrap: wrap; 
    }
    
    .current-price { 
      font-weight: 600; 
      font-size: 18px; 
      color: var(--terracotta); 
      margin-right: 8px; 
    }
    
    .original-price { 
      font-size: 14px; 
      text-decoration: line-through; 
      color: var(--text-light); 
      margin-right: 8px; 
    }
    
    .discount { 
      font-size: 13px; 
      color: #388e3c; 
      font-weight: 500; 
    }
    
    .stock-info { 
      font-size: 13px; 
      color: var(--text-light); 
      margin-top: 6px; 
    }
    
    .in-stock {
      color: #388e3c;
    }
    
    .low-stock {
      color: #f57c00;
    }
    
    .out-of-stock {
      color: #d32f2f;
    }
    
    /* Size Selector */
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
      border: 1px solid var(--light-brown); 
      padding: 6px 10px; 
      font-size: 12px; 
      border-radius: 4px; 
      cursor: pointer; 
      user-select: none; 
      transition: var(--transition);
      min-width: 36px;
      text-align: center;
    }
    
    .size-option:hover {
      border-color: var(--terracotta);
    }
    
    .size-option.selected { 
      background: var(--terracotta); 
      color: white; 
      border-color: var(--terracotta); 
    }
    
    .size-option.disabled { 
      background: #f5f5f5; 
      color: #bdbdbd; 
      cursor: not-allowed; 
      border-style: dashed; 
    }
    
    /* Card Actions */
    .card-actions { 
      display: flex; 
      flex-direction: column; 
      gap: 10px; 
      margin-top: 12px; 
    }
    
    .add-to-cart, .buy-now { 
      width: 100%; 
      padding: 12px; 
      border: none; 
      border-radius: 6px; 
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
      background: var(--cream); 
      color: var(--terracotta); 
      border: 1px solid var(--light-brown);
    }
    
    .add-to-cart:hover:not(:disabled) {
      background: var(--terracotta);
      color: white;
    }
    
    .buy-now { 
      background: var(--terracotta); 
      color: white; 
      text-decoration: none; 
    }
    
    .buy-now:hover:not(:disabled) {
      background: var(--dark-brown);
    }
    
    .add-to-cart:disabled, .buy-now:disabled { 
      background: #eeeeee; 
      color: #9e9e9e; 
      cursor: not-allowed; 
      border: 1px solid #e0e0e0;
    }
    
    /* Toast Notification */
    .toast { 
      position: fixed; 
      bottom: 25px; 
      left: 50%; 
      transform: translateX(-50%); 
      background: var(--terracotta); 
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
      color: var(--light-brown);
    }
    
    .empty-state p {
      font-size: 18px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .products {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        padding: 0 15px;
      }
      
      .header {
        padding: 12px 15px;
        height: 70px;
      }
      
      .logo {
        font-size: 22px;
      }
      
      .page-title {
        font-size: 28px;
        margin: 25px 15px;
      }
    }
    
    @media (max-width: 480px) {
      .products {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      
      .page-title {
        font-size: 24px;
      }
      
      .card-actions {
        flex-direction: row;
      }
      
      .add-to-cart, .buy-now {
        padding: 10px;
        font-size: 13px;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <button class="back-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
    <a href="index.php" class="logo"><span style="color:#C75D2c;">कन्या</span>Raag</a>
    <a href="cart.php" class="cart-icon"><i class="fas fa-shopping-bag"></i><span class="cart-count" id="cart-count">0</span></a>
  </header>

  <h1 class="page-title">Women's Collection</h1>
  <div class="toast" id="toast"></div>

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
        
        // Determine stock status class
        $stock_class = 'in-stock';
        if ($row['stock'] <= 0) {
          $stock_class = 'out-of-stock';
        } else if ($row['stock'] <= 5) {
          $stock_class = 'low-stock';
        }
        
        echo "<div class='card'>
          <div class='card-image'>
            <a href='product_detail.php?id=".$row['id']."'><img src='".$row['product_image']."' alt='".$row['product_name']."'></a>";
            if ($discount_percent > 0) {
              echo "<div class='card-badge'>".$discount_percent."% OFF</div>";
            }
            echo "<div class='quick-view' data-id='".$row['id']."'><i class='fas fa-eye'></i></div>
        </div>
        <div class='card-content'>
          <h3 class='card-title'>".$row['product_name']."</h3>
          <div class='price-container'>
            <span class='current-price'>₹".number_format($row['discount_price'])."</span>";
            if ($row['original_price'] > $row['discount_price']) {
              echo "<span class='original-price'>₹".number_format($row['original_price'])."</span>
              <span class='discount'>(".$discount_percent."% OFF)</span>";
            }
        echo "</div>
          <p class='stock-info $stock_class'>".($row['stock'] > 0 ? "In Stock (".$row['stock'].")" : "Out of Stock")."</p>";
            
        // Size Selector
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
                disabled>
                <i class='fas fa-shopping-cart'></i> Add to Cart
              </button>
              <button class='buy-now'
                data-id='".$row['id']."'
                data-name='".$row['product_name']."'
                data-price='".$row['discount_price']."'
                data-image='".$row['product_image']."'
                data-stock='".$row['stock']."'
                disabled>
                <i class='fas fa-bolt'></i> Buy Now
              </button>
            </div>
          </div>
        </div>";
      }
    } else {
      echo "<div class='empty-state'>
              <i class='fas fa-box-open'></i>
              <p>No products available in this collection.</p>
            </div>";
    }
    ?>
  </div>

  <!-- JavaScript -->
  <script>
    // Size selection
    document.querySelectorAll('.size-option').forEach(option => {
      option.addEventListener('click', () => {
        if(option.classList.contains('disabled')) return;

        const parent = option.closest('.card');
        const allOptions = parent.querySelectorAll('.size-option');
        allOptions.forEach(o => o.classList.remove('selected'));
        option.classList.add('selected');

        // Enable buttons only if size selected and stock available
        const stock = parseInt(parent.querySelector('.add-to-cart').getAttribute('data-stock'));
        if(stock > 0) {
          parent.querySelector('.add-to-cart').disabled = false;
          parent.querySelector('.buy-now').disabled = false;
        }
      });
    });

    // Toast function
    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.textContent = message;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2500);
    }

    // Cart count
    let cartCount = 0;
    const cartCountEl = document.getElementById('cart-count');

    // Add to cart
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', () => {
        if(btn.disabled) return;
        const size = btn.closest('.card').querySelector('.size-option.selected');
        if(!size) {
          showToast("Please select a size first!");
          return;
        }
        cartCount++;
        cartCountEl.textContent = cartCount;
        showToast("Added to cart!");
      });
    });

    // Buy now
    document.querySelectorAll('.buy-now').forEach(btn => {
      btn.addEventListener('click', () => {
        if(btn.disabled) return;
        const size = btn.closest('.card').querySelector('.size-option.selected');
        if(!size) {
          showToast("Please select a size first!");
          return;
        }
        // Redirect to checkout with product id + size
        const productId = btn.getAttribute('data-id');
        const selectedSize = size.getAttribute('data-size');
        window.location.href = "checkout.php?product_id=" + productId + "&size=" + selectedSize;
      });
    });
  </script>
</body>
</html>
