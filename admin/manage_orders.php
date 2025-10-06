<?php
session_start();
include '../db/db_connect.php';

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $delivery_status = $_POST['delivery_status'] ?? null;
    $payment_status  = $_POST['payment_status'] ?? null;

    if ($delivery_status) {
        $conn->query("UPDATE orders SET delivery_status='$delivery_status' WHERE id=$order_id");
    }
    if ($payment_status) {
        $conn->query("UPDATE orders SET payment_status='$payment_status' WHERE id=$order_id");
    }

    header("Location: manage_orders.php?updated=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders - Kanyaraag Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f8f9fa; }
    .card { box-shadow:0 2px 10px rgba(0,0,0,0.1); border-radius:10px; }
    select { min-width:150px; }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Manage Orders</h2>

    <?php if(isset($_GET['updated'])) { ?>
      <div class="alert alert-success">Order updated successfully!</div>
    <?php } ?>

    <div class="card p-3">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Payment Status</th>
            <th>Delivery Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $orders->fetch_assoc()) { ?>
          <tr>
            <form method="post">
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['customer_name'] ?? 'N/A'; ?></td>
              <td>₹<?php echo $row['amount']; ?></td>
              <td><?php echo $row['created_at']; ?></td>
              
              <!-- Payment Status -->
              <td>
                <select name="payment_status" class="form-select">
                  <option value="Pending"   <?php if($row['payment_status']=='Pending') echo 'selected'; ?>>Pending</option>
                  <option value="Confirmed" <?php if($row['payment_status']=='Confirmed') echo 'selected'; ?>>Confirmed</option>
                  <option value="Failed"    <?php if($row['payment_status']=='Failed') echo 'selected'; ?>>Failed</option>
                </select>
              </td>

              <!-- Delivery Status -->
              <td>
                <select name="delivery_status" class="form-select">
                  <option value="Order Confirmed" <?php if($row['delivery_status']=='Order Confirmed') echo 'selected'; ?>>Order Confirmed</option>
                  <option value="Dispatched"     <?php if($row['delivery_status']=='Dispatched') echo 'selected'; ?>>Dispatched</option>
                  <option value="Shipped"        <?php if($row['delivery_status']=='Shipped') echo 'selected'; ?>>Shipped</option>
                  <option value="Delivered"      <?php if($row['delivery_status']=='Delivered') echo 'selected'; ?>>Delivered</option>
                </select>
              </td>

              <td>
                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-sm btn-primary">Update</button>
              </td>
            </form>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
