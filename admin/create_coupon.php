<?php
// create_coupon.php
include '../db/db_connect.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = strtoupper(trim($_POST['code']));
    $type = $_POST['type'];
    $value = $_POST['value'];
    $expiry_date = $_POST['expiry_date'];
    $status = $_POST['status'];

    if ($code && $type && $value && $expiry_date && $status) {
        $stmt = $conn->prepare("INSERT INTO coupons (code, type, value, expiry_date, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $code, $type, $value, $expiry_date, $status);

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>✅ Coupon created successfully!</p>";
        } else {
            $message = "<p style='color:red;'>❌ Error: Coupon code already exists or invalid data.</p>";
        }
    } else {
        $message = "<p style='color:red;'>❌ Please fill all fields.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Coupon</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0;}
    .container {max-width:600px; margin:40px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    h2 {margin-bottom:15px;}
    form .form-group {margin-bottom:15px;}
    label {display:block; margin-bottom:6px; font-weight:500;}
    input, select {
      width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:1rem;
    }
    button {
      padding:12px 20px; border:none; border-radius:6px; background:#ff4081; color:#fff;
      font-size:1rem; cursor:pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Create Coupon</h2>
    <?php if ($message) echo $message; ?>

    <form method="POST">
      <div class="form-group">
        <label>Coupon Code</label>
        <input type="text" name="code" placeholder="e.g. SAVE10" required>
      </div>

      <div class="form-group">
        <label>Type</label>
        <select name="type" required>
          <option value="flat">Flat Discount</option>
          <option value="percent">Percentage Discount</option>
        </select>
      </div>

      <div class="form-group">
        <label>Value</label>
        <input type="number" step="0.01" name="value" placeholder="e.g. 100 or 10" required>
      </div>

      <div class="form-group">
        <label>Expiry Date</label>
        <input type="date" name="expiry_date" required>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" required>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>

      <button type="submit">Create Coupon</button>
    </form>
  </div>
</body>
</html>
