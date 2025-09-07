<?php
// order_success.php
$order_id = $_GET['order_id'] ?? '';
?>
<!doctype html>
<html>
<head><title>Order Confirmed</title></head>
<body>
  <div style="max-width:700px;margin:40px auto;padding:20px;background:#fff;border-radius:10px;">
    <h1>Thank you!</h1>
    <p>Your order <strong><?php echo htmlspecialchars($order_id); ?></strong> has been received.</p>
    <p>We'll send updates to your contact number and email (if available).</p>
    <a href="index.php">Continue shopping</a>
  </div>
</body>
</html>
