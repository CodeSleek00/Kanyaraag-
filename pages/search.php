<?php
include '../db/db_connect.php';

// Search query
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$products = [];

if ($search !== '') {
    // Search in multiple fields
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE product_name LIKE ? 
        OR description LIKE ? 
        OR fabric LIKE ? 
        OR sizes LIKE ?
        OR discount_price LIKE ?
        ORDER BY created_at DESC
    ");
    $like = "%" . $search . "%";
    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kanyaraag - Search Results</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- अपना common CSS link -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    body { font-family: 'Poppins', sans-serif; background:#fafafa; margin:0; padding:0; }
    .container { max-width:1200px; margin:auto; padding:20px; }
    .search-box { text-align:center; margin-bottom:30px; }
    .search-box input { width:60%; padding:10px 15px; border:1px solid #ccc; border-radius:25px; }
    .search-box button { padding:10px 20px; border:none; background:#222; color:#fff; border-radius:25px; margin-left:10px; cursor:pointer; }
    .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:20px; }
    .card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.1); transition:transform 0.3s; }
    .card:hover { transform:translateY(-5px); }
    .card img { width:100%; height:280px; object-fit:cover; }
    .card-content { padding:15px; }
    .card-title { font-size:18px; font-weight:600; margin-bottom:10px; }
    .price-container { margin-bottom:10px; }
    .current-price { font-weight:600; color:#e53935; font-size:16px; }
    .original-price { text-decoration:line-through; color:#777; margin-left:8px; font-size:14px; }
    .discount-percent { color:green; font-size:14px; margin-left:5px; }
    .btns { display:flex; gap:10px; }
    .btns button { flex:1; padding:8px; border:none; border-radius:20px; cursor:pointer; font-size:14px; }
    .add-cart { background:#222; color:#fff; }
    .buy-now { background:#e53935; color:#fff; }
    .no-result { text-align:center; font-size:18px; padding:50px 20px; color:#555; }
  </style>
</head>
<body>
  <div class="container">
    <!-- Search Box -->
    <div class="search-box">
      <form method="GET" action="search.php">
        <input type="text" name="q" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>" required>
        <button type="submit"><i class="fas fa-search"></i> Search</button>
      </form>
    </div>

    <?php if ($search === ''): ?>
      <div class="no-result">Type something in search box to find products</div>
    <?php elseif (empty($products)): ?>
      <div class="no-result">No products found for "<b><?= htmlspecialchars($search) ?></b>"</div>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($products as $row): 
          $id = $row['id'];
          $name = $row['product_name'];
          $image = $row['product_image'];
          $original_price = $row['original_price'];
          $discount_price = $row['discount_price'];
          $discount_percent = round((($original_price - $discount_price) / $original_price) * 100);
        ?>
        <div class="card">
          <img src="<?= $image ?>" alt="<?= $name ?>">
          <div class="card-content">
            <h3 class="card-title"><?= $name ?></h3>
            <div class="price-container">
              <span class="current-price">₹<?= number_format($discount_price) ?></span>
              <?php if ($discount_percent > 0): ?>
                <span class="original-price">₹<?= number_format($original_price) ?></span>
                <span class="discount-percent"><?= $discount_percent ?>% off</span>
              <?php endif; ?>
            </div>
            <div class="btns">
              <button class="buy-now" onclick="window.location.href='product_detail.php?id=<?= $id ?>'">Buy Now</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <script>
    // Example: Add to cart JS
    document.querySelectorAll('.add-cart').forEach(btn => {
      btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let name = this.dataset.name;
        let price = this.dataset.price;
        let image = this.dataset.image;
        alert(name + " added to cart (demo).");
        // TODO: Replace with your cart logic
      });
    });
  </script>
</body>
</html>
