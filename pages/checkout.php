<?php
session_start();
include '../db/db_connect.php';

// Check if we have a product to checkout
if (!isset($_SESSION['buy_now_product'])) {
    header('Location: index.php');
    exit();
}

$product = $_SESSION['buy_now_product'];

// Process the checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $customer_name = $_POST['customer_name'] ?? '';
    $customer_email = $_POST['customer_email'] ?? '';
    $customer_phone = $_POST['customer_phone'] ?? '';
    $customer_address = $_POST['customer_address'] ?? '';
    $customer_city = $_POST['customer_city'] ?? '';
    $customer_state = $_POST['customer_state'] ?? '';
    $customer_zip = $_POST['customer_zip'] ?? '';
    $payment_method = $_POST['payment_method'] ?? 'cod';
    
    // Validate required fields
    if (empty($customer_name) || empty($customer_phone) || empty($customer_address)) {
        $error = "Please fill in all required fields.";
    } else {
        // Insert order into database
        $sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, 
                customer_city, customer_state, customer_zip, payment_method, total_amount, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssd", $customer_name, $customer_email, $customer_phone, 
                         $customer_address, $customer_city, $customer_state, $customer_zip, 
                         $payment_method, $product['price']);
        
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;
            
            // Insert order item
            $sql_item = "INSERT INTO order_items (order_id, product_id, product_name, 
                        product_price, quantity, size, color)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param("iisdiss", $order_id, $product['id'], $product['name'], 
                                  $product['price'], $product['quantity'], $product['size'], 
                                  $product['color']);
            
            if ($stmt_item->execute()) {
                // Clear the session and redirect to success page
                unset($_SESSION['buy_now_product']);
                header('Location: order_success.php?order_id=' . $order_id);
                exit();
            } else {
                $error = "Error saving order details: " . $conn->error;
            }
        } else {
            $error = "Error creating order: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - कन्याRaag</title>
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
            --error: #dc3545;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 12px;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
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
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .raag {
            color: var(--accent);
        }
        
        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 992px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }
        
        .checkout-form, .order-summary {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .error {
            color: var(--error);
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        .order-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .order-item-image {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-right: 15px;
            background: var(--light);
            border-radius: 8px;
            padding: 10px;
        }
        
        .order-item-details {
            flex-grow: 1;
        }
        
        .order-item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .order-item-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .order-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid var(--light-gray);
            text-align: right;
        }
        
        .total-label {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .total-amount {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .btn {
            padding: 15px;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: block;
            width: 100%;
            text-align: center;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #602e17ff;
        }
        
        .payment-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        
        .payment-option {
            border: 2px solid var(--light-gray);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .payment-option.selected {
            border-color: var(--primary);
            background: rgba(219, 113, 64, 0.1);
        }
        
        .payment-option i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--gray);
        }
        
        .payment-option.selected i {
            color: var(--primary);
        }
        
        .hidden-radio {
            position: absolute;
            opacity: 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">कन्या<span class="raag">Raag</span></div>
    </header>

    <div class="container">
        <h1 class="section-title">Checkout</h1>
        
        <?php if (isset($error)): ?>
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="checkout-container">
            <div class="checkout-form">
                <h2 class="section-title">Customer Information</h2>
                
                <form method="POST" action="checkout.php">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="customer_name" class="form-input" required 
                               value="<?php echo $_POST['customer_name'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="customer_email" class="form-input"
                               value="<?php echo $_POST['customer_email'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input type="tel" name="customer_phone" class="form-input" required
                               value="<?php echo $_POST['customer_phone'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Delivery Address *</label>
                        <textarea name="customer_address" class="form-input" rows="3" required><?php echo $_POST['customer_address'] ?? ''; ?></textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label class="form-label">City *</label>
                            <input type="text" name="customer_city" class="form-input" required
                                   value="<?php echo $_POST['customer_city'] ?? ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">State *</label>
                            <input type="text" name="customer_state" class="form-input" required
                                   value="<?php echo $_POST['customer_state'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="customer_zip" class="form-input"
                               value="<?php echo $_POST['customer_zip'] ?? ''; ?>">
                    </div>
                    
                    <h2 class="section-title">Payment Method</h2>
                    
                    <div class="payment-options">
                        <label class="payment-option <?php echo ($_POST['payment_method'] ?? 'cod') === 'cod' ? 'selected' : ''; ?>">
                            <i class="fas fa-money-bill-wave"></i>
                            <div>Cash on Delivery</div>
                            <input type="radio" name="payment_method" value="cod" class="hidden-radio" 
                                   <?php echo ($_POST['payment_method'] ?? 'cod') === 'cod' ? 'checked' : ''; ?>>
                        </label>
                        
                        <label class="payment-option <?php echo ($_POST['payment_method'] ?? '') === 'card' ? 'selected' : ''; ?>">
                            <i class="fas fa-credit-card"></i>
                            <div>Card Payment</div>
                            <input type="radio" name="payment_method" value="card" class="hidden-radio"
                                   <?php echo ($_POST['payment_method'] ?? '') === 'card' ? 'checked' : ''; ?>>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </form>
            </div>
            
            <div class="order-summary">
                <h2 class="section-title">Order Summary</h2>
                
                <div class="order-item">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="order-item-image">
                    <div class="order-item-details">
                        <div class="order-item-name"><?php echo $product['name']; ?></div>
                        <div>Size: <?php echo $product['size']; ?></div>
                        <?php if (!empty($product['color'])): ?>
                            <div>Color: <?php echo $product['color']; ?></div>
                        <?php endif; ?>
                        <div>Quantity: <?php echo $product['quantity']; ?></div>
                        <div class="order-item-price">₹<?php echo $product['price']; ?></div>
                    </div>
                </div>
                
                <div class="order-total">
                    <div class="total-label">Total:</div>
                    <div class="total-amount">₹<?php echo $product['price']; ?></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment option selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
</body>
</html>