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
    body { font-family: 'Outfit', sans-serif; background-color: #fafafa; color: var(--text-dark); padding-top: 70px; padding-bottom: 20px; }
    
    /* Header */
    .header { position: fixed; top: 0; left: 0; width: 100%; background: var(--white); box-shadow: var(--shadow-light); z-index: 1000; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; height: 70px; }
    .back-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--dark-brown); padding: 8px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .back-btn:active { background-color: rgba(93, 64, 55, 0.1); }
    .logo { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--dark-brown); text-decoration: none; max-width: 150px; text-align: center; line-height: 1.2; }
    .cart-icon { position: relative; font-size: 20px; color: var(--dark-brown); text-decoration: none; padding: 8px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .cart-count { position: absolute; top: 2px; right: 2px; background: var(--dark-brown); color: white; font-size: 10px; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; }
    
    .page-title { text-align: center; margin: 20px 16px; font-family: 'Playfair Display', serif; font-size: 24px; color: var(--dark-brown); }
    .products { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; padding: 0 16px; max-width: 1200px; margin: 0 auto; }
    .card { background: var(--white); border-radius: 10px; overflow: hidden; box-shadow: var(--shadow-light); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-image { position: relative; width: 100%; aspect-ratio: 3/4; overflow: hidden; }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .card-badge { position: absolute; top: 8px; left: 8px; background: var(--dark-brown); color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px; font-weight: 500; }
    .card-content { padding: 12px; }
    .card-title { font-size: 14px; font-weight: 500; margin-bottom: 6px; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .price-container { display: flex; align-items: center; margin-bottom: 10px; flex-wrap: wrap; }
    .current-price { font-weight: 600; font-size: 16px; color: var(--dark-brown); margin-right: 6px; }
    .original-price { font-size: 12px; text-decoration: line-through; color: var(--text-light); margin-right: 6px; }
    .discount { font-size: 12px; color: #388e3c; font-weight: 500; }
    .card-actions { margin-top: 8px; }
    .add-to-cart { width: 100%; padding: 10px; border: none; border-radius: 5px; font-size: 13px; font-weight: 500; cursor: pointer; background: var(--light-brown); color: var(--dark-brown); }
    .add-to-cart:disabled { background: #e0e0e0; color: #9e9e9e; cursor: not-allowed; }
    
    .toast { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: var(--dark-brown); color: white; padding: 12px 20px; border-radius: 8px; box-shadow: var(--shadow); z-index: 1001; opacity: 0; transition: opacity 0.3s ease; }
    .toast.show { opacity: 1; }

    /* Quick View Modal */
    .quick-view-modal { display: none; position: fixed; z-index: 2000; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); justify-content: center; align-items: center; }
    .quick-view-content { background: white; padding: 20px; border-radius: 12px; max-width: 400px; width: 90%; box-shadow: var(--shadow); text-align: center; position: relative; }
    .quick-view-body img { width: 100%; max-height: 250px; object-fit: contain; border-radius: 10px; margin-bottom: 15px; }
    .close-btn { position: absolute; top: 10px; right: 15px; font-size: 24px; cursor: pointer; }
    .sizes { margin: 10px 0 20px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
    .sizes button { padding: 8px 14px; border: 1px solid var(--dark-brown); background: white; border-radius: 6px; cursor: pointer; transition: all 0.2s; }
    .sizes button.active { background: var(--dark-brown); color: white; }
    .sizes button:disabled { background: #eee; color: #aaa; border-color: #ddd; cursor: not-allowed; }
    .add-to-cart-btn { background: var(--dark-brown); color: white; padding: 12px; border: none; border-radius: 6px; width: 100%; cursor: pointer; }
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

  <!-- Products -->
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
            <img src='".$row['product_image']."' alt='".$row['product_name']."'>";
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
            <button class='add-to-cart'
              data-id='".$row['id']."'
              data-name='".$row['product_name']."'
              data-price='".$row['discount_price']."'
              data-image='".$row['product_image']."'
              data-sizes='".htmlspecialchars($row['sizes'], ENT_QUOTES)."'
              ".($row['stock'] <= 0 ? "disabled" : "").">
              ".($row['stock'] > 0 ? "<i class='fas fa-shopping-cart'></i> Add to Cart" : "Out of Stock")."
            </button>
          </div>
        </div>";
      }
    } else {
      echo "<div class='empty-state'><i class='fas fa-heart'></i><p>No products available!</p></div>";
    }
    $conn->close();
    ?>
  </div>

  <!-- Quick View Modal -->
  <div id="quickViewModal" class="quick-view-modal">
    <div class="quick-view-content">
      <span class="close-btn" id="closeQuickView">&times;</span>
      <div class="quick-view-body">
        <img id="qvImage" src="" alt="Product Image" />
        <h2 id="qvName"></h2>
        <div id="qvSizes" class="sizes"></div>
        <button id="qvAddToCart" class="add-to-cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
      </div>
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
      setTimeout(() => toast.classList.remove('show'), 2000);
    }

    // Quick View open
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', function() {
        if (this.disabled) return;
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const image = this.getAttribute('data-image');
        const price = this.getAttribute('data-price');
        const sizesData = this.getAttribute('data-sizes');

        document.getElementById('qvImage').src = image;
        document.getElementById('qvName').textContent = name;

        const sizeContainer = document.getElementById('qvSizes');
        sizeContainer.innerHTML = "";
        if (sizesData) {
          try {
            const sizes = JSON.parse(sizesData);
            for (let size in sizes) {
              let btn = document.createElement("button");
              btn.textContent = size;
              if (sizes[size] <= 0) {
                btn.disabled = true;
              } else {
                btn.onclick = () => {
                  document.querySelectorAll("#qvSizes button").forEach(b => b.classList.remove("active"));
                  btn.classList.add("active");
                  document.getElementById('qvAddToCart').setAttribute('data-size', size);
                };
              }
              sizeContainer.appendChild(btn);
            }
          } catch(e) {
            console.error("Invalid sizes JSON", e);
          }
        }

        const qvBtn = document.getElementById('qvAddToCart');
        qvBtn.setAttribute('data-id', id);
        qvBtn.setAttribute('data-name', name);
        qvBtn.setAttribute('data-price', price);
        qvBtn.setAttribute('data-image', image);

        document.getElementById('quickViewModal').style.display = 'flex';
      });
    });

    document.getElementById('closeQuickView').onclick = () => {
      document.getElementById('quickViewModal').style.display = 'none';
    };

    // Add to Cart from Quick View
    document.getElementById('qvAddToCart').addEventListener('click', function() {
      const size = this.getAttribute('data-size');
      if (!size) {
        showToast("Please select a size first!");
        return;
      }
      const product = {
        id: this.getAttribute('data-id'),
        name: this.getAttribute('data-name'),
        price: this.getAttribute('data-price'),
        image: this.getAttribute('data-image'),
        size: size,
        qty: 1
      };
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.push(product);
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
      showToast("Added to cart: " + product.name + " (" + size + ")");
      document.getElementById('quickViewModal').style.display = 'none';
    });

    document.addEventListener('DOMContentLoaded', updateCartCount);
  </script>
</body>
</html>
