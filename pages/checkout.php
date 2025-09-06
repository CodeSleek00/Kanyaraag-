<?php
session_start();
include '../db/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if we have a temporary cart from buy now
if (isset($_SESSION['temp_cart']) && $_SESSION['temp_cart']['is_buy_now']) {
    $cart_items = $_SESSION['temp_cart']['items'];
    $total = $_SESSION['temp_cart']['total'];
    
    // Clear the temporary cart after use
    unset($_SESSION['temp_cart']);
} else {
    // Regular cart from localStorage (you'll need to implement this)
    // This would typically involve converting the JavaScript cart to PHP
    $cart_items = []; // Your regular cart implementation
    $total = 0;
}

// Process the checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the checkout process
    // Insert order into database, process payment, etc.
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <!-- Your checkout page styling and content -->
</head>
<body>
    <!-- Checkout form -->
    <h1>Checkout</h1>
    
    <?php if (!empty($cart_items)): ?>
        <div class="order-summary">
            <h2>Order Summary</h2>
            <?php foreach ($cart_items as $item): ?>
                <div class="checkout-item">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="80">
                    <h3><?php echo $item['name']; ?></h3>
                    <p>Size: <?php echo $item['size']; ?></p>
                    <p>Color: <?php echo $item['color']; ?></p>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                    <p>Price: ₹<?php echo $item['price']; ?></p>
                </div>
            <?php endforeach; ?>
            
            <div class="total">
                <h3>Total: ₹<?php echo $total; ?></h3>
            </div>
        </div>
        
        <form method="POST" action="checkout.php">
            <!-- Shipping and payment details form -->
            <h2>Shipping Information</h2>
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="zip" placeholder="ZIP Code" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            
            <h2>Payment Method</h2>
            <select name="payment_method" required>
                <option value="cod">Cash on Delivery</option>
                <option value="card">Credit/Debit Card</option>
                <option value="upi">UPI</option>
            </div>
            
            <button type="submit">Place Order</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty. <a href="products.php">Continue shopping</a></p>
    <?php endif; ?>
</body>
</html>