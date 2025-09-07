<?php
// apply_coupon.php
include '../db/db_connect.php';
session_start();

$message = '';
$discount = 0;
$totalAmount = 1500; // Example total, later replace with cart total from session/cart table

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_code = strtoupper(trim($_POST['coupon_code'] ?? ''));

    if ($coupon_code != '') {
        $today = date('Y-m-d');
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code=? AND status='active' AND expiry_date >= ?");
        $stmt->bind_param("ss", $coupon_code, $today);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $coupon = $result->fetch_assoc();

            if ($coupon['type'] === 'flat') {
                $discount = $coupon['value'];
            } elseif ($coupon['type'] === 'percent') {
                $discount = ($totalAmount * $coupon['value']) / 100;
            }

            $finalAmount = max($totalAmount - $discount, 0);
            $message = "<p style='color:green;'>✅ Coupon Applied! You saved ₹{$discount}. Final Payable: ₹{$finalAmount}</p>";
        } else {
            $message = "<p style='color:red;'>❌ Invalid or Expired Coupon!</p>";
            $finalAmount = $totalAmount;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apply Coupon</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0;}
    .container {max-width:600px; margin:40px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    h2 {margin-bottom:15px;}
    form {display:flex; gap:10px; margin-bottom:20px;}
    input[type=text] {flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:1rem;}
    button {padding:10px 20px; border:none; border-radius:6px; background:#ff4081; color:#fff; cursor:pointer; font-size:1rem;}
    .summary {margin-top:20px; padding:15px; background:#fafafa; border:1px solid #ddd; border-radius:6px;}
  </style>
</head>
<body>
  <div class="container">
    <h2>Apply Coupon</h2>
    <form method="POST">
      <input type="text" name="coupon_code" placeholder="Enter Coupon Code" required>
      <button type="submit">Apply</button>
    </form>
    <?php if ($message) echo $message; ?>
    
    <div class="summary">
      <p><strong>Cart Total:</strong> ₹<?php echo $totalAmount; ?></p>
      <p><strong>Discount:</strong> ₹<?php echo $discount; ?></p>
      <p><strong>Final Amount:</strong> ₹<?php echo isset($finalAmount) ? $finalAmount : $totalAmount; ?></p>
    </div>
  </div>
</body>
</html>
