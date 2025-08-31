<?php include '../db/db_connect.php'; ?>

<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
if(!$product){
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($product['product_name']) ?> - Product Details</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
  
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
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
      --transition: all 0.3s ease;
    }

    * { margin:0; padding:0; box-sizing:border-box; font-family:'Outfit',sans-serif; }
    body { background:#f9fafb; color:var(--dark); line-height:1.6; }
    .container { max-width:1200px; margin:0 auto; padding:20px; }

    /* Header */
    .header { display:flex; justify-content:space-between; align-items:center; padding:15px 20px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.05); border-radius:12px; margin-bottom:20px; }
    .header .logo { font-weight:700; font-size:22px; color:var(--primary); }
    .header button { background:transparent; border:none; cursor:pointer; }

    /* Breadcrumb */
    .breadcrumb { display:flex; align-items:center; font-size:14px; color:var(--gray); margin-bottom:20px; }
    .breadcrumb a { color:var(--gray); text-decoration:none; transition:var(--transition); }
    .breadcrumb a:hover { color:var(--primary); }
    .breadcrumb i { margin:0 8px; font-size:12px; }

    /* Product Layout */
    .product-detail { display:grid; grid-template-columns:1fr 1fr; gap:40px; background:#fff; border-radius:12px; padding:30px; box-shadow:var(--shadow); }
    @media(max-width:992px){ .product-detail { grid-template-columns:1fr; gap:30px; } }

    /* Gallery */
    .gallery-main { border-radius:12px; overflow:hidden; background:var(--light); aspect-ratio:1/1; margin-bottom:16px; }
    .gallery-main img { width:100%; height:100%; object-fit:contain; transition:var(--transition); }
    .gallery-thumbs { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; }
    .gallery-thumb { border-radius:8px; overflow:hidden; cursor:pointer; border:2px solid transparent; aspect-ratio:1/1; transition:var(--transition); background:var(--light); }
    .gallery-thumb.active { border-color:var(--primary); }
    .gallery-thumb img { width:100%; height:100%; object-fit:cover; }

    /* Product Info */
    .product-info h1 { font-size:28px; font-weight:600; margin-bottom:16px; color:var(--dark); }
    .stock { font-size:14px; font-weight:500; padding:4px 10px; border-radius:20px; background:var(--light); display:inline-block; }
    .stock.in-stock { color:var(--success); background:rgba(40,167,69,0.1); }

    .pricing { margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid var(--border); }
    .price-container { display:flex; align-items:center; gap:12px; margin-bottom:8px; flex-wrap:wrap; }
    .current-price { font-size:28px; font-weight:700; color:var(--dark); }
    .original-price { font-size:18px; color:var(--gray); text-decoration:line-through; }
    .discount { font-size:16px; font-weight:600; color:var(--success); background:rgba(40,167,69,0.1); padding:4px 10px; border-radius:20px; }
    .tax { font-size:14px; color:var(--gray); }

    /* Details & Description */
    .details { margin-bottom:24px; }
    .detail-item { display:flex; margin-bottom:12px; }
    .detail-label { min-width:80px; font-weight:600; color:var(--dark); }
    .detail-value { color:var(--gray); }
    .description { margin-bottom:24px; line-height:1.7; }

    /* Size Options */
    .sizes { margin-bottom:24px; }
    .sizes h3 { font-size:16px; font-weight:600; margin-bottom:12px; }
    .size-options { display:flex; gap:10px; flex-wrap:wrap; }
    .size-circle { width:40px; height:40px; border-radius:50%; background:var(--light-gray); color:var(--dark); display:flex; align-items:center; justify-content:center; cursor:pointer; font-weight:600; transition:0.3s; border:2px solid transparent; }
    .size-circle:hover { border-color:var(--primary); transform:scale(1.1); }
    .size-circle.selected { background:var(--primary); color:#fff; border-color:var(--primary); }
    .size-circle.disabled { background:#ddd; color:#888; cursor:not-allowed; pointer-events:none; }

    /* Buttons */
    .action-buttons { display:flex; gap:16px; margin-top:30px; }
    .btn { display:inline-flex; align-items:center; justify-content:center; padding:14px 28px; border-radius:8px; font-weight:600; cursor:pointer; transition:var(--transition); border:none; font-size:16px; }
    .btn i { margin-right:8px; }
    .btn-primary { background:var(--primary); color:white; flex:2; }
    .btn-primary:hover { background:#2a75ff; transform:translateY(-2px); }
    .btn-secondary { background:var(--secondary); color:white; flex:1; }
    .btn-secondary:hover { background:#e00064; transform:translateY(-2px); }

    .shipping-info { background:var(--light); padding:16px; border-radius:8px; margin-top:24px; display:flex; align-items:center; gap:12px; }
    .shipping-info i { color:var(--success); font-size:20px; }

    /* Toast */
    .toast { position:fixed; bottom:20px; right:20px; background:var(--success); color:white; padding:12px 20px; border-radius:8px; box-shadow:var(--shadow); display:flex; align-items:center; opacity:0; transform:translateY(20px); transition:var(--transition); z-index:1000; }
    .toast.show { opacity:1; transform:translateY(0); }
    .toast i { margin-right:8px; }

    /* Tabs */
    .tabs-container { margin-top:50px; }
    .tab-headers { display:flex; gap:20px; margin-bottom:20px; }
    .tab-link { cursor:pointer; padding:10px 15px; border-radius:8px; background:#f1f3f5; font-weight:600; transition:var(--transition); }
    .tab-link.active { background:var(--primary); color:white; }
    .tab-content { display:none; background:#fff; padding:20px; border-radius:12px; box-shadow:var(--shadow); }
    .tab-content.active { display:block; }

    /* Review & Ratings */
    .review-item img { max-width:150px; max-height:150px; object-fit:cover; border-radius:8px; margin-top:8px; }

    @media(max-width:576px){
      .action-buttons{flex-direction:column;}
      .gallery-thumbs{grid-template-columns:repeat(3,1fr);}
      .product-info h1{font-size:24px;}
      .current-price{font-size:24px;}
    }
  </style>
</head>
<body>

<header class="header">
  <button onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
  <div class="logo">कन्या<span style="color:var(--secondary);">Raag</span></div>
  <a href="cart.php"><button><i class="fas fa-shopping-cart"></i></button></a>
</header>

<div class="container">
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="index.php">Home</a> <i class="fas fa-chevron-right"></i>
    <a href="category.php?cat=all">Products</a> <i class="fas fa-chevron-right"></i>
    <span><?= htmlspecialchars($product['product_name']) ?></span>
  </div>

  <div class="product-detail">
    <!-- Gallery -->
    <div class="gallery">
      <div class="gallery-main">
        <img id="mainImg" src="<?= $product['product_image'] ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
      </div>
      <div class="gallery-thumbs">
        <div class="gallery-thumb active"><img src="<?= $product['product_image'] ?>" onclick="showImage(this)" alt="Thumbnail"></div>
        <?php
        if(!empty($product['images'])){
          $extraImages = json_decode($product['images'], true);
          foreach($extraImages as $img){ ?>
            <div class="gallery-thumb"><img src="<?= $img ?>" onclick="showImage(this)" alt="Thumbnail"></div>
          <?php }
        }
        ?>
      </div>
    </div>

    <!-- Product Info -->
    <div class="product-info">
      <h1><?= htmlspecialchars($product['product_name']) ?></h1>
      <div class="stock <?= $product['stock']>0?'in-stock':'out-of-stock' ?>"><?= $product['stock']>0?'In Stock':'Out of Stock' ?></div>
      
      <div class="pricing">
        <div class="price-container">
          <div class="current-price">₹<?= $product['discount_price'] ?></div>
          <div class="original-price">₹<?= $product['original_price'] ?></div>
          <div class="discount"><?= round($product['discount_percent']) ?>% OFF</div>
        </div>
        <div class="tax">Inclusive of all taxes</div>
      </div>

      <div class="description"><p><?= htmlspecialchars($product['description']) ?></p></div>

      <div class="details">
        <div class="detail-item"><div class="detail-label">Color:</div><div class="detail-value"><?= $product['color'] ?></div></div>
        <div class="detail-item"><div class="detail-label">Fabric:</div><div class="detail-value"><?= $product['fabric'] ?></div></div>
        <div class="detail-item"><div class="detail-label">Stock:</div><div class="detail-value"><?= $product['stock'] ?> units</div></div>
      </div>

      <!-- Sizes -->
      <div class="sizes">
        <h3>Select Size:</h3>
        <div class="size-options">
          <?php
          $all_sizes = ['XS','S','M','L','XL','XXL','XXXL'];
          $available_sizes = explode(',', $product['sizes']);
          foreach($all_sizes as $size){
            $disabled = in_array($size, $available_sizes) ? '' : 'disabled';
            echo "<div class='size-circle $disabled' data-size='$size'>$size</div>";
          }
          ?>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <button class="btn btn-primary add-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
        <button class="btn btn-secondary buy-now"><i class="fas fa-bolt"></i> Buy Now</button>
      </div>

      <div class="shipping-info"><i class="fas fa-truck"></i><div>Free delivery on orders above ₹499. Order within 5 hrs 32 mins for same day dispatch.</div></div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="tabs-container">
    <div class="tab-headers">
      <div class="tab-link active" data-tab="details">Product Details</div>
      <div class="tab-link" data-tab="shipping">Shipping Details</div>
      <div class="tab-link" data-tab="style">Style & Fit Tips</div>
    </div>
    <div id="details" class="tab-content active"><p>Premium cotton, multiple sizes/colors, durable stitching for all-day comfort.</p></div>
    <div id="shipping" class="tab-content"><ul><li>Free shipping above ₹499</li><li>Delivery: 3-7 days</li><li>COD available</li><li>Easy returns within 15 days</li></ul></div>
    <div id="style" class="tab-content"><p>Pair with jeans/chinos. Slim-fit; size up for relaxed fit. Layer under jackets for trendy look.</p></div>
  </div>

  <!-- Reviews -->
  <div class="container" style="margin-top:50px;">
    <h2>Reviews</h2>
    <?php
      $reviewQuery = $conn->query("SELECT * FROM reviews WHERE product_id = $id ORDER BY created_at DESC");
      $reviewCount = $reviewQuery->num_rows;
    ?>
    <p><?= $reviewCount ?> review<?= $reviewCount != 1?'s':'' ?> for this product</p>

    <div class="reviews-list" style="display:flex; flex-direction:column; gap:20px;">
      <?php while($r=$reviewQuery->fetch_assoc()){ ?>
        <div class="review-item">
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <strong style="color:var(--primary);"><?= htmlspecialchars($r['user_name']) ?></strong>
            <button class="share-review" data-url="<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>#review<?= $r['review_id'] ?>"><i class="fas fa-share-alt"></i></button>
          </div>
          <div style="margin:5px 0; color:#ffc107;">
            <?php for($i=1;$i<=5;$i++){ echo $i<=$r['rating']?'<i class="fas fa-star"></i>':'<i class="far fa-star"></i>'; } ?>
          </div>
          <p><?= htmlspecialchars($r['review_text']) ?></p>
          <?php if(!empty($r['review_image'])){ ?><img src="<?= $r['review_image'] ?>" alt="Review Image"><?php } ?>
        </div>
      <?php } 
      if($reviewCount==0){ echo '<p style="color:var(--gray);">No reviews yet.</p>'; }
      ?>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="addedToCart"><i class="fas fa-check-circle"></i><span>Product added to cart!</span></div>

<script>
  // Gallery
  function showImage(img){ document.getElementById('mainImg').src=img.src; document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('active')); img.parentElement.classList.add('active'); }

  // Tabs
  const tabs = document.querySelectorAll(".tab-link");
  const contents = document.querySelectorAll(".tab-content");
  tabs.forEach(tab=>tab.addEventListener("click",()=>{ tabs.forEach(t=>t.classList.remove("active")); contents.forEach(c=>c.classList.remove("active")); tab.classList.add("active"); document.getElementById(tab.dataset.tab).classList.add("active"); }));

  // Size selection
  let selectedSize = null;
  document.querySelectorAll('.size-circle').forEach(c=>c.addEventListener('click',()=>{
    document.querySelectorAll('.size-circle').forEach(s=>s.classList.remove('selected'));
    c.classList.add('selected');
    selectedSize=c.dataset.size;
  }));

  // Add to cart
  document.querySelector('.add-cart').addEventListener('click',()=>{
    if(!selectedSize){ alert("Select size!"); return; }
    const product={ id:"<?= $product['id'] ?>", name:"<?= addslashes($product['product_name']) ?>", price:"<?= $product['discount_price'] ?>", image:"<?= $product['product_image'] ?>", qty:1, size:selectedSize };
    let cart=JSON.parse(localStorage.getItem("cart"))||[];
    let existing=cart.find(p=>p.id==product.id&&p.size==selectedSize);
    if(existing){ existing.qty++; }else{ cart.push(product); }
    localStorage.setItem("cart",JSON.stringify(cart));
    const toast=document.getElementById('addedToCart'); toast.querySelector('span').innerText=product.name+" ("+product.size+") added!"; toast.classList.add('show'); setTimeout(()=>{toast.classList.remove('show');},3000);
  });

  // Buy now
  document.querySelector('.buy-now').addEventListener('click',()=>{ alert('Proceeding to checkout...'); });

  // Share review
  document.querySelectorAll('.share-review').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const url=btn.dataset.url;
      if(navigator.share){ navigator.share({title:"Check this review", url:"https://"+url}); } 
      else { navigator.clipboard.writeText("https://"+url).then(()=>alert("Link copied to clipboard!")); }
    });
  });
</script>

</body>
</html>
