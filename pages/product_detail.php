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
  <link rel="stylesheet" href="product-stle.css?v=3.1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  

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
      <!-- Sizes Selection -->
<div class="sizes">
  <h3>Select Size:</h3>
  <div class="size-options">
    <?php
      $all_sizes = ['XS','S','M','L','XL','XXL','XXXL'];
      $available_sizes = explode(',', $product['sizes']); // from DB

      foreach($all_sizes as $size) {
        $isAvailable = in_array($size, $available_sizes);
        echo '<div class="size-circle '.($isAvailable ? '' : 'disabled').'" 
                  data-size="'.$size.'">'.$size.'</div>';
      }
    ?>
  </div>
</div>

<style>
  .sizes { margin-bottom: 24px; }
  .sizes h3 { font-size: 16px; font-weight: 600; margin-bottom: 12px; }
  .size-options { display: flex; gap: 10px; flex-wrap: wrap; }
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
  .size-circle:hover { border-color: var(--primary); transform: scale(1.1); }
  .size-circle.selected { background: var(--primary); color: #fff; border-color: var(--primary); }
  .size-circle.disabled {
    background: #ddd;
    color: #888;
    cursor: not-allowed;
    pointer-events: none;
  }
</style>

<script>
  const sizeCircles = document.querySelectorAll('.size-circle');
  let selectedSize = null;

  sizeCircles.forEach(circle => {
    circle.addEventListener('click', () => {
      // remove previous selection
      sizeCircles.forEach(c => c.classList.remove('selected'));
      // add selection to clicked
      circle.classList.add('selected');
      selectedSize = circle.getAttribute('data-size');
      console.log("Selected Size:", selectedSize);
    });
  });

  // Optional: integrate with Add to Cart
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
    toast.querySelector('span').innerText = product.name + " ("+product.size+") added to cart!";
    toast.classList.add('show');
    setTimeout(() => { toast.classList.remove('show'); }, 3000);
  });
</script>

      
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
</div>

<div class="toast" id="addedToCart">
  <i class="fas fa-check-circle"></i>
  <span>Product added to cart successfully!</span>
</div>
<div class="tabs-container">

    <!-- Tab Headers -->
    <div class="tab-headers">
      <div class="tab-link active" data-tab="details">Product Details</div>
      <div class="tab-link" data-tab="shipping">Shipping Details</div>
      <div class="tab-link" data-tab="style">Style & Fit Tips</div>
    </div>

    <!-- Tab Contents -->
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
<!-- Frequently Bought Together -->
<div class="container" style="margin-top:50px;">
  <h2 style="margin-bottom:20px;">Frequently Bought Together</h2>
  <div class="fbt-products" style="display:flex; gap:20px; flex-wrap:wrap;">
    <?php
      $fbtQuery = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 2");
      $fbtProducts = [];
      $totalPrice = 0;

      while($p = $fbtQuery->fetch_assoc()) {
        $fbtProducts[] = $p;
        $totalPrice += $p['discount_price'];
        echo '<div class="fbt-item" style="flex:1; min-width:200px; background:#fff; border:1px solid #eee; border-radius:10px; padding:15px; text-align:center;">
                <img src="'.$p['product_image'].'" alt="'.$p['product_name'].'" style="max-width:150px; height:150px; object-fit:contain;">
                <h4 style="margin:10px 0;">'.$p['product_name'].'</h4>
                <p style="font-weight:600; color:#3a86ff;">₹'.$p['discount_price'].'</p>
              </div>';
      }

      $discountedTotal = $totalPrice - ($totalPrice * 0.10);
    ?>
  </div>

  <!-- Add All to Cart Button -->
  <div style="margin-top:20px; text-align:center;">
    <button id="addAllFBT" 
            style="padding:12px 25px; background:#28a745; color:white; font-size:16px; border:none; border-radius:8px; cursor:pointer;">
      <i class="fas fa-shopping-cart"></i> Add Both to Cart (10% OFF Applied)
    </button>
  </div>

  <div class="fbt-total" style="margin-top:20px; padding:15px; background:#f8f9fa; border-radius:8px; text-align:center;">
    <h3>Total Price for 2 Products:  
      <span style="color:#28a745;">₹<?php echo $discountedTotal; ?> (10% OFF Applied)</span>
    </h3>
  </div>
</div>

<script>
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



<!-- Similar Products -->
<!-- Similar Products -->
<div class="container" style="margin-top:50px;">
  <h2 style="margin-bottom:20px;">Similar Products</h2>
  <div class="similar-products" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
    <?php
      // Shuffle products every page load
      $similarQuery = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 8");

      while($sp = $similarQuery->fetch_assoc()) {
        echo '<div class="product-card" style="background:#fff; border:1px solid #eee; border-radius:10px; padding:15px; text-align:center; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
                <a href="product_detail.php?id='.$sp['id'].'" style="text-decoration:none; color:inherit;">
                  <img src="'.$sp['product_image'].'" alt="'.$sp['product_name'].'" style="max-width:180px; height:180px; object-fit:contain;">
                  <h4 style="margin:10px 0;">'.$sp['product_name'].'</h4>
                  <p style="color:#3a86ff; font-weight:700;">₹'.$sp['discount_price'].'</p>
                  <p style="color:#6c757d; text-decoration:line-through;">₹'.$sp['original_price'].'</p>
                </a>
              </div>';
      }
    ?>
  </div>
</div>
<!-- Review Submission Form -->
<div class="container" style="margin-top:50px;">
  <h2>Write a Review</h2>
  <form id="reviewForm" action="submit_review.php" method="POST" enctype="multipart/form-data" style="background:#fff; padding:20px; border-radius:10px; border:1px solid #eee; max-width:600px;">
    <input type="hidden" name="product_id" value="<?php echo $id; ?>">

    <div style="margin-bottom:15px;">
      <label for="user_name" style="font-weight:600;">Your Name:</label>
      <input type="text" name="user_name" id="user_name" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
      <label style="font-weight:600;">Rating:</label>
      <div id="ratingStars" style="display:flex; gap:5px; cursor:pointer;">
        <?php for($i=1;$i<=5;$i++){ ?>
          <i class="far fa-star" data-value="<?php echo $i; ?>" style="font-size:20px; color:#ffc107;"></i>
        <?php } ?>
      </div>
      <input type="hidden" name="rating" id="ratingValue" required>
    </div>

    <div style="margin-bottom:15px;">
      <label for="review_text" style="font-weight:600;">Review:</label>
      <textarea name="review_text" id="review_text" rows="4" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;"></textarea>
    </div>

    <div style="margin-bottom:15px;">
      <label for="review_image" style="font-weight:600;">Upload Image (optional):</label>
      <input type="file" name="review_image" id="review_image" accept="image/*">
    </div>

    <button type="submit" style="padding:10px 20px; border:none; background:#3a86ff; color:white; border-radius:6px; cursor:pointer;">
      Submit Review
    </button>
  </form>
</div>

<script>
  // Rating stars selection
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
</script>

<!-- Reviews Section -->
<div class="container" style="margin-top:50px;">
  <h2>Reviews</h2>
  <?php
    // Fetch reviews for current product
    $reviewQuery = $conn->query("SELECT * FROM reviews WHERE product_id = $id ORDER BY created_at DESC");
    $reviewCount = $reviewQuery->num_rows;
  ?>
  <p style="margin-bottom:20px; color:#6c757d;"><?php echo $reviewCount; ?> review<?php echo $reviewCount != 1 ? 's' : ''; ?> for this product</p>

  <div class="reviews-list" style="display:flex; flex-direction:column; gap:20px;">
    <?php
      while($review = $reviewQuery->fetch_assoc()) {
        echo '<div class="review-item" style="background:#fff; padding:15px; border-radius:10px; border:1px solid #eee; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <div style="font-weight:600; color:#3a86ff;">'.$review['user_name'].'</div>
                  <button class="share-review" 
                          data-url="'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'#review'.$review['review_id'].'" 
                          style="border:none; background:transparent; cursor:pointer; color:#555;">
                    <i class="fas fa-share-alt"></i>
                  </button>
                </div>
                <div style="margin:5px 0; color:#ffc107;">';
                  for($i=1;$i<=5;$i++){
                    echo $i <= $review['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                  }
        echo '</div>
                <p style="color:#212529;">'.htmlspecialchars($review['review_text']).'</p>';
                
                if(!empty($review['review_image'])) {
                  echo '<img src="'.$review['review_image'].'" alt="Review Image" style="max-width:150px; max-height:150px; object-fit:cover; border-radius:8px; margin-top:8px;">';
                }

        echo '</div>';
      }

      if($reviewCount == 0){
        echo '<p style="color:#6c757d;">No reviews yet for this product.</p>';
      }
    ?>
  </div>
</div>

<script>
  // Share button functionality
  document.querySelectorAll('.share-review').forEach(btn => {
    btn.addEventListener('click', function() {
      let url = this.getAttribute('data-url');
      if (navigator.share) {
        // Native share on mobile devices
        navigator.share({
          title: "Check out this review!",
          url: "https://" + url
        }).then(() => {
          console.log('Shared successfully');
        }).catch(console.error);
      } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText("https://" + url).then(() => {
          alert("Review link copied to clipboard!");
        });
      }
    });
  });
</script>



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
  const tabs = document.querySelectorAll(".tab-link");
    const contents = document.querySelectorAll(".tab-content");

    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        // Remove active class from all tabs and contents
        tabs.forEach(t => t.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));

        // Add active to clicked tab and corresponding content
        tab.classList.add("active");
        document.getElementById(tab.dataset.tab).classList.add("active");
      });
    });
</script>
</body>
</html>