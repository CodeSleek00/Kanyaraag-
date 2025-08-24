<?php
include '../db/db_connect.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$order = null;
if ($order_id) {
    $sql = "SELECT o.*, p.product_name, p.product_image FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = $order_id";
    $result = $conn->query($sql);
    $order = $result->fetch_assoc();
}
if (!$order) {
    echo '<div style="color:red">Order not found.</div>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Razorpay Payment</title>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
  <h2>Pay with Razorpay</h2>
  <div>
    <img src="<?php echo $order['product_image']; ?>" alt="<?php echo $order['product_name']; ?>" style="max-width:120px;">
    <div><?php echo $order['product_name']; ?></div>
    <div>Total: ₹<?php echo $order['total']; ?></div>
  </div>
  <button id="rzp-button">Pay Now</button>
  <form id="rzp-form" action="razorpay_verify.php" method="POST" style="display:none;">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
  </form>
  <script>
    document.getElementById('rzp-button').onclick = function(e){
      var options = {
        "key": "rzp_test_YourKeyHere", // Replace with your Razorpay Test Key
        "amount": <?php echo $order['total'] * 100; ?>,
        "currency": "INR",
        "name": "Kanyaraag",
        "description": "Order #<?php echo $order_id; ?>",
        "handler": function (response){
          document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
          document.getElementById('razorpay_signature').value = response.razorpay_signature;
          document.getElementById('rzp-form').submit();
        },
        "prefill": {
          "name": "<?php echo $order['user_name']; ?>",
          "email": "",
          "contact": "<?php echo $order['phone']; ?>"
        },
        "theme": {"color": "#ff3f6c"}
      };
      var rzp1 = new Razorpay(options);
      rzp1.open();
      e.preventDefault();
    }
  </script>
</body>
</html>
