<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['product_name']; ?> - Product Details</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #3a86ff;
      --secondary: #ff006e;
      --accent: #8338ec;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --border: #dee2e6;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }

    body { font-family: 'Segoe UI', sans-serif; background: #f9fafb; color: var(--dark); margin:0; }

    .container { max-width: 1200px; margin: 0 auto; padding: 20px; }

    /* --- Breadcrumb --- */
    .breadcrumb { font-size:14px; margin-bottom:20px; color:var(--gray); }
    .breadcrumb a { color:var(--gray); text-decoration:none; }
    .breadcrumb a:hover { color:var(--primary); }

    /* --- Product Detail Layout --- */
    .product-detail {
      display:grid; grid-template-columns:1fr 1fr; gap:40px;
      background:#fff; padding:30px; border-radius:12px; box-shadow:var(--shadow);
    }
    @media(max-width:992px){ .product-detail { grid-template-columns:1fr; } }

    /* Gallery */
    .gallery-main img{ width:100%; height:100%; object-fit:contain; border-radius:12px; }
    .gallery-thumbs{ display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:10px; }
    .gallery-thumb{ border:2px solid transparent; cursor:pointer; border-radius:8px; overflow:hidden; }
    .gallery-thumb.active{ border-color:var(--primary); }

    /* Product Info */
    .product-info h1 { font-size:28px; margin-bottom:12px; }
    .pricing { margin:20px 0; }
    .current-price { font-size:28px; font-weight:700; }
    .original-price { text-decoration:line-through; color:var(--gray); margin-left:10px; }
    .discount { color:green; margin-left:10px; }

    .action-buttons { display:flex; gap:15px; margin-top:20px; flex-wrap:wrap; }
    .btn { padding:12px 24px; border-radius:8px; cursor:pointer; font-weight:600; border:none; }
    .btn-primary { background:var(--primary); color:#fff; flex:2; }
    .btn-secondary { background:var(--secondary); color:#fff; flex:1; }
    .btn-outline { border:1px solid var(--border); background:#fff; color:var(--dark); }

    /* --- Reviews Section --- */
    .reviews-section { margin-top:40px; background:#fff; padding:20px; border-radius:12px; box-shadow:var(--shadow); }
    .reviews-section h2 { font-size:22px; margin-bottom:20px; }
    .review { border-bottom:1px solid var(--border); padding:15px 0; }
    .review:last-child{ border-bottom:none; }
    .review-user { font-weight:600; }
    .review-stars { color:#ffc107; margin-bottom:5px; }
    .review-text { color:var(--gray); }

    /* --- Related Products --- */
    .related-section { margin-top:40px; }
    .related-section h2 { font-size:22px; margin-bottom:20px; }
    .related-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:20px; }
    .related-card {
      background:#fff; border-radius:12px; overflow:hidden; box-shadow:var(--shadow); transition:var(--transition);
    }
    .related-card:hover{ transform:translateY(-5px); }
    .related-card img{ width:100%; height:200px; object-fit:cover; }
    .related-card-body { padding:15px; }
    .related-card-body h3{ font-size:16px; margin-bottom:10px; }
    .related-card-body .price{ font-weight:700; color:var(--primary); }
  </style>
</head>
<body>
<div class="container">

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="index.php">Home</a> › <a href="products.php">Products</a> › <span><?php echo $product['product_name']; ?></span>
  </div>

  <!-- Product Detail -->
  <div class="product-detail">
    <div class="gallery">
      <div class="gallery-main">
        <img id="mainImg" src="<?php echo $product['product_image']; ?>" alt="">
      </div>
      <div class="gallery-thumbs">
        <div class="gallery-thumb active"><img src="<?php echo $product['product_image']; ?>" onclick="showImage(this)"></div>
        <?php
        if (!empty($product['images'])) {
          $extra = json_decode($product['images'], true);
          foreach ($extra as $img) {
            echo '<div class="gallery-thumb"><img src="'.$img.'" onclick="showImage(this)"></div>';
          }
        }
        ?>
      </div>
    </div>

    <div class="product-info">
      <h1><?php echo $product['product_name']; ?></h1>
      <div class="pricing">
        <span class="current-price">₹<?php echo $product['discount_price']; ?></span>
        <span class="original-price">₹<?php echo $product['original_price']; ?></span>
        <span class="discount"><?php echo round($product['discount_percent']); ?>% OFF</span>
      </div>
      <p><?php echo $product['description']; ?></p>

      <div class="action-buttons">
        <button class="btn btn-outline"><i class="far fa-heart"></i> Wishlist</button>
        <button class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
        <button class="btn btn-secondary"><i class="fas fa-bolt"></i> Buy Now</button>
      </div>
    </div>
  </div>

  <!-- Reviews Section -->
  <div class="reviews-section">
    <h2>Customer Reviews</h2>
    <?php if($review_result->num_rows > 0): ?>
      <?php while($review = $review_result->fetch_assoc()): ?>
        <div class="review">
          <div class="review-user"><?php echo htmlspecialchars($review['user_name']); ?></div>
          <div class="review-stars">
            <?php for($i=1;$i<=5;$i++): ?>
              <i class="fa<?php echo $i <= $review['rating'] ? 's' : 'r'; ?> fa-star"></i>
            <?php endfor; ?>
          </div>
          <div class="review-text"><?php echo htmlspecialchars($review['comment']); ?></div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No reviews yet. Be the first to review!</p>
    <?php endif; ?>
  </div>

  <!-- Related Products -->
  <div class="related-section">
    <h2>Related Products</h2>
    <div class="related-grid">
      <?php while($related = $related_result->fetch_assoc()): ?>
        <div class="related-card">
          <a href="product_detail.php?id=<?php echo $related['id']; ?>">
            <img src="<?php echo $related['product_image']; ?>" alt="">
          </a>
          <div class="related-card-body">
            <h3><?php echo $related['product_name']; ?></h3>
            <div class="price">₹<?php echo $related['discount_price']; ?></div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

</div>

<script>
function showImage(img){
  document.getElementById("mainImg").src = img.src;
  document.querySelectorAll('.gallery-thumb').forEach(el=>el.classList.remove('active'));
  img.parentElement.classList.add('active');
}
</script>
</body>
</html>
