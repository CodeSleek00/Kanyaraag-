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
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --white: #ffffff;
      --light-brown: #d7ccc8;
      --medium-brown: #a1887f;
      --dark-brown: #5d4037;
      --accent: #8d6e63;
      --text-dark: #333333;
      --text-light: #777777;
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #fafafa;
      color: var(--text-dark);
      padding-top: 80px;
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
    }
    
    .back-btn {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: var(--dark-brown);
    }
    
    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--dark-brown);
      text-decoration: none;
    }
    
    .cart-icon {
      position: relative;
      font-size: 22px;
      color: var(--dark-brown);
      text-decoration: none;
    }
    
    .cart-count {
      position: absolute;
      top: -8px;
      right: -8px;
      background: var(--dark-brown);
      color: white;
      font-size: 12px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    /* Page Title */
    .page-title {
      text-align: center;
      margin: 30px 0;
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      color: var(--dark-brown);
      position: relative;
    }
    
    .page-title:after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: var(--light-brown);
      margin: 10px auto;
    }
    
    /* Products Grid */
    .products {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      padding: 0 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .card {
      background: var(--white);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }
    
    .card-image {
      position: relative;
      width: 100%;
      height: auto;
      overflow: hidden;
    }
    
    .card-image img {
      width: 100%;
      height: 100%;
     
      transition: transform 0.5s ease;
    }
    
    .card:hover .card-image img {
      transform: scale(1.05);
    }
    
    .card-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: var(--dark-brown);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
    }
    
    .card-content {
      padding: 15px;
    }
    
    .card-title {
      font-size: 16px;
      font-weight: 500;
      margin-bottom: 8px;
      color: var(--text-dark);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .card-desc {
      font-size: 14px;
      color: var(--text-light);
      margin-bottom: 12px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      height: 40px;
    }
    
    .price-container {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
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
      margin-left: 8px;
      font-weight: 500;
    }
    
    .card-actions {
      display: flex;
      gap: 8px;
    }
    
    .add-to-cart, .buy-now {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-family: 'Montserrat', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .add-to-cart {
      background: var(--light-brown);
      color: var(--dark-brown);
    }
    
    .add-to-cart:hover:not(:disabled) {
      background: var(--medium-brown);
      color: white;
    }
    
    .buy-now {
      background: var(--dark-brown);
      color: white;
    }
    
    .buy-now:hover {
      background: var(--accent);
    }
    
    .add-to-cart:disabled {
      background: #e0e0e0;
      color: #9e9e9e;
      cursor: not-allowed;
    }
    
    .stock-info {
      font-size: 13px;
      color: var(--text-light);
      margin-top: 8px;
    }
    
    /* Thumbnails */
    .thumbnails {
      display: flex;
      gap: 5px;
      margin-top: 10px;
      flex-wrap: wrap;
    }
    
    .thumb {
      width: 40px;
      height: 40px;
      border-radius: 5px;
      overflow: hidden;
      border: 1px solid #eeeeee;
    }
    
    .thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    /* Responsive Design */
    @media (min-width: 768px) {
      .products {
        grid-template-columns: repeat(3, 1fr);
        padding: 0 40px;
      }
      
      .header {
        padding: 15px 8%;
      }
    }
    
    @media (min-width: 1024px) {
      .products {
        grid-template-columns: repeat(4, 1fr);
      }
      
      .header {
        padding: 15px 10%;
      }
    }
    
    /* Empty state */
    .empty-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 40px 20px;
    }
    
    .empty-state i {
      font-size: 60px;
      color: var(--light-brown);
      margin-bottom: 20px;
    }
    
    .empty-state p {
      font-size: 18px;
      color: var(--text-light);
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
  <h1 class="page-title">Women's Collection</h1>

  <!-- Products Grid -->
  <div class="products">
    <?php
    // Fixed SQL query - removed the WHERE clause with non-existent 'category' column
    $sql = "SELECT * FROM products ORDER BY RAND()";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $discount_percent = 0;
        if ($row['original_price'] > 0 && $row['original_price'] > $row['discount_price']) {
          $discount_percent = round(($row['original_price'] - $row['discount_price']) / $row['original_price'] * 100);
        }
        
        echo "<div class='card'>
          <a href='product_detail.php?id=".$row['id']."'>
            <div class='card-image'>
              <img src='".$row['product_image']."' alt='".$row['product_name']."'>";
              
              if ($discount_percent > 0) {
                echo "<div class='card-badge'>".$discount_percent."% OFF</div>";
              }
              
        echo "</div>
          </a>
          <div class='card-content'>
            <h3 class='card-title'>".$row['product_name']."</h3>
           
            
            <div class='price-container'>
              <span class='current-price'>₹".$row['discount_price']."</span>";
              
              if ($row['original_price'] > $row['discount_price']) {
                echo "<span class='original-price'>₹".$row['original_price']."</span>
                <span class='discount'>(".$discount_percent."% OFF)</span>";
              }
              
        echo "</div>
            
            <p class='stock-info'>Stock: ".$row['stock']."</p>";
            
            // Show extra images if available
            if (!empty($row['images'])) {
              $images = json_decode($row['images'], true);
              if (!empty($images) && is_array($images)) {
                echo "<div class='thumbnails'>";
                foreach ($images as $img) {
                  echo "<div class='thumb'><img src='".$img."' alt='Thumbnail'></div>";
                }
                echo "</div>";
              }
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
              
              <a href='product_detail.php?id=".$row['id']."' style='text-decoration: none;'>
                <button class='buy-now' ".($row['stock'] <= 0 ? "disabled" : "").">
                  <i class='fas fa-bolt'></i> Buy Now
                </button>
              </a>
            </div>
          </div>
        </div>";
      }
    } else {
      echo "<div class='empty-state'>
        <i class='fas fa-heart'></i>
        <p>No products available in this category yet!</p>
      </div>";
    }
    
    // Close connection
    if ($conn) {
      $conn->close();
    }
    ?>
  </div>

  <script>
    // Initialize cart count
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const totalItems = cart.reduce((total, item) => total + (item.qty || 1), 0);
      document.getElementById('cart-count').textContent = totalItems;
    }
    
    // Add to Cart functionality
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
    
    // Initialize cart count on page load
    document.addEventListener('DOMContentLoaded', updateCartCount);
  </script>
</body>
</html>