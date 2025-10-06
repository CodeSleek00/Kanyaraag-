<?php
session_start();
include '../db/db_connect.php'; // db connection

// Total Products
$total_products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// Product List
$product_list = $conn->query("SELECT id, product_name, price, discount, stock FROM products ORDER BY id DESC LIMIT 10");

// Total Orders
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];

// Total Sales
$total_sales = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status='Completed'")->fetch_assoc()['total'];
$total_sales = $total_sales ? $total_sales : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kanyaraag Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .card { border-radius: 12px; box-shadow: 0px 2px 10px rgba(0,0,0,0.08); }
    .sidebar { height: 100vh; background:#222; color:white; padding:20px; position:fixed; width:220px; }
    .sidebar h2 { font-size: 20px; margin-bottom:20px; }
    .sidebar a { display:block; padding:10px; margin:5px 0; color:#ddd; text-decoration:none; border-radius:6px; }
    .sidebar a:hover { background:#444; color:white; }
    .main { margin-left:240px; padding:20px; }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Kanyaraag Admin</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="products.php">Manage Products</a>
    <a href="orders.php">Manage Orders</a>
    <a href="add_product.php">Add New Product</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main">
    <h1 class="mb-4">Dashboard Overview</h1>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5>Total Products</h5>
          <h2><?php echo $total_products; ?></h2>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5>Total Orders</h5>
          <h2><?php echo $total_orders; ?></h2>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5>Total Sales</h5>
          <h2>₹<?php echo number_format($total_sales, 2); ?></h2>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5>New Product</h5>
          <a href="add_product.php" class="btn btn-primary">+ Add</a>
        </div>
      </div>
    </div>

    <h3 class="mt-5">Latest Products</h3>
    <div class="card p-3">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Discount</th><th>Stock</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $product_list->fetch_assoc()) { ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td>₹<?php echo $row['price']; ?></td>
              <td><?php echo $row['discount']; ?>%</td>
              <td><?php echo $row['stock']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
