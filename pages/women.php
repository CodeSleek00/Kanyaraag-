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
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
      --shadow-light: 0 2px 6px rgba(0,0,0,0.05);
    }
    * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
    body { font-family: 'outfit', sans-serif; background-color: #fafafa; color: var(--text-dark); padding-top: 70px; padding-bottom: 20px; }
    .header { position: fixed; top: 0; left: 0; width: 100%; background: var(--white); box-shadow: var(--shadow-light); z-index: 1000; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; height: 70px; }
    .back-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--dark-brown); padding: 8px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .back-btn:active { background-color: rgba(93, 64, 55, 0.1); }
    .logo { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--dark-brown); text-decoration: none; max-width: 150px; text-align: center; line-height: 1.2; }
    .cart-icon { position: relative; font-size: 20px; color: var(--dark-brown); text-decoration: none; padding: 8px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .cart-count { position: absolute; top: 2px; right: 2px; background: var(--dark-brown); color: white; font-size: 10px; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; }
    .page-title { text-align: center; margin: 20px 16px; font-family: 'Playfair Display', serif; font-size: 24px; color: var(--dark-brown); position: relative; line-height: 1.3; }
    .page-title:after { content: ''; display: block; width: 50px; height: 2px; background: var(--light-brown); margin: 8px auto; }
    .products { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; padding: 0 16px; max-width: 1200px; margin: 0 auto; }
    .card { background: var(--white); border-radius: 10px; overflow: hidden; box-shadow: var(--shadow-light); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card:active { transform: scale(0.98); }
    .card-image { position: relative; width: 100%; aspect-ratio: 3/4; overflow: hidden; }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .card-badge { position: absolute; top: 8px; left: 8px; background: var(--dark-brown); color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px; font-weight: 500; }
    .card-content { padding: 12px; }
    .card-title { font-size: 14px; font-weight: 500; margin-bottom: 6px; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .price-container { display: flex; align-items: center; margin-bottom: 10px; flex-wrap: wrap; }
    .current-price { font-weight: 600; font-size: 16px; color: var(--dark-brown); margin-right: 6px; }
    .original-price { font-size: 12px; text-decoration: line-through; color: var(--text-light); margin-right: 6px; }
    .discount { font-size: 12px; color: #388e3c; font-weight: 500; }
    .card-actions { display: flex; flex-direction: column; gap: 8px; margin-top: 8px; }
    .add-to-cart, .buy-now { width: 100%; padding: 10px; border: none; border-radius: 5px; font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; }
    .add-to-cart { background: var(--light-brown); color: var(--dark-brown); }
    .buy-now { background: var(--dark-brown); color: white; text-decoration: none; }
    .add-to-cart:disabled, .buy-now:disabled { background: #e0e0e0; color: #9e9e9e; cursor: not-allowed; }
    .stock-info { font-size: 11px; color: var(--text-light); margin-top: 6px; }
    .size-selector { margin: 10px 0; }
    .size-title { font-size: 13px; margin-bottom: 5px; color: var(--text-dark); }
    .size-options { display: flex; gap: 6px; flex-wrap: wrap; }
    .size-option { border: 1px solid var(--light-brown); padding: 5px 10px; font-size: 12px; border-radius: 4px; cursor: pointer; user-select: none; transition: all 0.2s; }
    .size-option.selected { background: var(--dark-brown); color: white; border-color: var(--dark-brown); }
    .size-option.disabled { background: #eee; color: #aaa; cursor: not-allowed; border-style: dashed; }
    .toast { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: var(--dark-brown); color: white; padding: 12px 20px; border-radius: 8px; box-shadow: var(--shadow); z-index: 1001; opacity: 0; transition: opacity 0.3s ease; max-width: 80%; text-align: center; }
    .toast.show { opacity: 1; }
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
        echo "<div class='card'>
          <div class='card-image'>
            <a href='product_detail.php?id=".$row['id']."'><img src='".$row['product_image']."' alt='".$row['product_name']."'></a>";
            if ($discount_percent > 0) {
              echo "<div class='card-badge'>".$discount_percent."% OFF</div>";
            }
        echo "</div>
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
      echo "<div class='empty-state'><i class='fas fa-heart'></i><p>No products available in this category yet!</p></div>";
    }
    if ($conn) { $conn->close(); }
    ?>
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
      setTimeout(() => { toast.classList.remove('show'); }, 2000);
    }
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
