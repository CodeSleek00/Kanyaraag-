<?php
session_start();
include '../db/db_connect.php';

// Check if user is logged in, if not redirect to login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: login.php');
    exit();
}

// Process the buy now request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? 0;
    $size = $_POST['size'] ?? '';
    $color = $_POST['color'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;
    
    // Validate product
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        // Create a temporary cart for the buy now process
        $temp_cart = [
            'items' => [
                [
                    'id' => $product['id'],
                    'name' => $product['product_name'],
                    'price' => $product['discount_price'],
                    'image' => $product['product_image'],
                    'size' => $size,
                    'color' => $color,
                    'quantity' => $quantity
                ]
            ],
            'total' => $product['discount_price'] * $quantity,
            'is_buy_now' => true
        ];
        
        // Store in session
        $_SESSION['temp_cart'] = $temp_cart;
        
        // Redirect to checkout
        header('Location: checkout.php');
        exit();
    } else {
        // Product not found
        $_SESSION['error'] = "Product not found.";
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit();
    }
} else {
    // Invalid request method
    $_SESSION['error'] = "Invalid request.";
    header('Location: index.php');
    exit();
}
?>