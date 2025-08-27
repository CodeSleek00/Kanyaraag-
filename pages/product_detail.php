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
        <button class="btn btn-outline">
          <i class="far fa-heart"></i> Wishlist
        </button>
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
  
// Add to Cart - using localStorage
document.querySelector('.add-cart').addEventListener('click', function() {
  // Get product details from PHP
  let product = {
    id: "<?php echo $product['id']; ?>",
    name: "<?php echo addslashes($product['product_name']); ?>",
    price: "<?php echo $product['discount_price']; ?>",
    image: "<?php echo $product['product_image']; ?>",
    qty: 1
  };

  // Get cart from localStorage or create new
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Check if product already in cart
  let existing = cart.find(p => p.id == product.id);
  if (existing) {
    existing.qty++;
  } else {
    cart.push(product);
  }

  // Save updated cart
  localStorage.setItem("cart", JSON.stringify(cart));

  // Show toast notification
  const toast = document.getElementById('addedToCart');
  toast.querySelector('span').innerText = product.name + " added to cart!";
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
</script>
</body>
</html>