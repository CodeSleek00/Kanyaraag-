<?php
include '../db/db_connect.php';
session_start();

// If product bought directly via "Buy Now"
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);
    if($result->num_rows == 0){ die("Product not found"); }
    $product = $result->fetch_assoc();
    $cart = [ [
        "id"=>$product['id'],
        "name"=>$product['product_name'],
        "price"=>$product['discount_price'],
        "qty"=>1
    ]];
} 
// Else, we can populate cart from session/localStorage
else {
    // We'll handle cart from localStorage using JS
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<style>
body { font-family:Arial; padding:20px; background:#fafafa; }
table { width:100%; border-collapse: collapse; margin-bottom:20px; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
button { padding:10px 20px; background:#ff3f6c; color:#fff; border:none; cursor:pointer; border-radius:5px; margin-right:10px; }
button:hover { background:#e91e63; }
</style>
</head>
<body>

<h2>Checkout</h2>

<table id="cart-table">
<tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
<?php foreach($cart as $item){ ?>
<tr>
    <td><?= $item['name'] ?></td>
    <td>₹<?= $item['price'] ?></td>
    <td><?= $item['qty'] ?></td>
    <td>₹<?= $item['price']*$item['qty'] ?></td>
</tr>
<?php $total += $item['price']*$item['qty']; } ?>
<tr><td colspan="3"><strong>Total</strong></td><td>₹<?= $total ?></td></tr>
</table>

<h3>Select Payment Method</h3>
<form method="POST" action="place_order.php">
    <input type="hidden" name="total" value="<?= $total ?>">
    <input type="radio" name="payment_method" value="COD" checked> Cash on Delivery
    <input type="radio" name="payment_method" value="RAZORPAY"> Razorpay
    <br><br>
    <button type="submit">Place Order</button>
</form>

</body>
</html>
