<?php
include '../db/db_connect.php';

$order_id = $_GET['order_id'] ?? 0;

// Get order details
$sql = "SELECT * FROM orders WHERE id = $order_id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

// Get order items
$sql_items = "SELECT * FROM order_items WHERE order_id = $order_id";
$result_items = $conn->query($sql_items);
$items = $result_items->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - कन्याRaag</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #db7140ff;
            --secondary: #9f4a00d1;
            --accent: #d37f26ff;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --gray: #6c757d;
            --border-radius: 12px;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }
        
        body {
            background-color: #f9fafb;
            color: var(--dark);
            line-height: 1.6;
            text-align: center;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--shadow);
        }
        
        .success-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 20px;
        }
        
        h1 {
            color: var(--success);
            margin-bottom: 15px;
        }
        
        .order-details {
            text-align: left;
            margin: 25px 0;
            padding: 20px;
            background: var(--light);
            border-radius: var(--border-radius);
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            margin-top: 20px;
        }
        
        .btn:hover {
            background: #602e17ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h1>Order Confirmed!</h1>
        <p>Thank you for your purchase. Your order has been received and is being processed.</p>
        
        <div class="order-details">
            <h2>Order Details</h2>
            <div class="detail-row">
                <span>Order Number:</span>
                <span>#<?php echo $order_id; ?></span>
            </div>
            <div class="detail-row">
                <span>Order Date:</span>
                <span><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
            </div>
            <div class="detail-row">
                <span>Total Amount:</span>
                <span>₹<?php echo $order['total_amount']; ?></span>
            </div>
            <div class="detail-row">
                <span>Payment Method:</span>
                <span>
                    <?php 
                    if ($order['payment_method'] == 'cod') echo 'Cash on Delivery';
                    elseif ($order['payment_method'] == 'card') echo 'Credit/Debit Card';
                    else echo ucfirst($order['payment_method']);
                    ?>
                </span>
            </div>
            <div class="detail-row">
                <span>Delivery Address:</span>
                <span><?php echo $order['customer_address']; ?>, <?php echo $order['customer_city']; ?>, <?php echo $order['customer_state']; ?></span>
            </div>
        </div>
        
        <p>You will receive an order confirmation email shortly.</p>
        
        <a href="index.php" class="btn">Continue Shopping</a>
    </div>
</body>
</html>