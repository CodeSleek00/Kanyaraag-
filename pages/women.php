<?php
// Your database connection file remains the same.
include '../db/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanyaraag - Women's Collection</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Modern CSS Reset */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* 70% White, 20% #C75D2c, 10% Neutrals */
            --white: #ffffff;
            --primary: #C75D2c; /* Main Accent Color */
            --primary-dark: #a54a22; /* Darker shade for hover states */
            --background: #f8f8f8; /* Light gray for body background */
            --text-dark: #2c2c2c; /* For headings and important text */
            --text-light: #757575; /* For secondary text */
            --border-color: #e0e0e0; /* For subtle borders */
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
            --shadow-light: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            padding-top: 70px; /* Space for fixed header */
            line-height: 1.5;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            z-index: 1000;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .header-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-dark);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s ease;
        }
        .header-btn:hover {
            background-color: var(--background);
        }

        .logo {
            font-weight: 700;
            font-size: 22px;
            color: var(--text-dark);
            text-decoration: none;
        }
        .logo span {
            color: var(--primary);
        }

        .cart-icon {
            position: relative;
            text-decoration: none;
        }
        .cart-count {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--primary);
            color: var(--white);
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 2px solid var(--white);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 16px;
        }

        .page-title {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
        }

        /* Products Grid - Responsive */
        .products {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        /* Tablet and larger */
        @media (min-width: 640px) {
            .products {
                grid-template-columns: repeat(3, 1fr);
                gap: 18px;
            }
        }
        
        /* Larger tablets */
        @media (min-width: 768px) {
            .products {
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
            }
            .page-title {
                font-size: 28px;
                margin-bottom: 24px;
            }
        }
        
        /* Desktop */
        @media (min-width: 1024px) {
            .products {
                grid-template-columns: repeat(4, 1fr);
                gap: 24px;
            }
        }
        
        /* Large Desktop */
        @media (min-width: 1280px) {
            .products {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        /* Product Card */
        .card {
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .card-image {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            overflow: hidden;
        }
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .card:hover .card-image img {
            transform: scale(1.05);
        }
        
        .card-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--primary);
            color: white;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .card-content {
            padding: 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Makes content fill available space */
        }

        .card-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px;
            line-height: 1.3;
        }

        .price-container {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }
        .current-price {
            font-weight: 700;
            font-size: 16px;
            color: var(--primary);
        }
        .original-price {
            font-size: 12px;
            text-decoration: line-through;
            color: var(--text-light);
        }
        .discount-percent {
            font-size: 12px;
            color: var(--primary);
            font-weight: 600;
        }

        /* Size Selector */
        .size-selector {
            margin-top: auto; /* Pushes selector to the bottom */
            padding-top: 8px;
        }
        .size-title {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text-dark);
        }
        .size-options {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .size-option {
            border: 1px solid var(--border-color);
            min-width: 32px;
            height: 32px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
            display: grid;
            place-items: center;
        }
        .size-option:not(.disabled):hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        .size-option.selected {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .size-option.disabled {
            background: #f5f5f5;
            color: #b0b0b0;
            cursor: not-allowed;
            border-color: #e0e0e0;
        }
        
        /* Action Buttons */
        .card-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .action-btn {
            flex: 1;
            padding: 10px;
            border: 1px solid;
            border-radius: 6px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }
        
        .add-to-cart {
            background: var(--white);
            color: var(--primary);
            border-color: var(--primary);
        }
        .add-to-cart:hover:not(:disabled) {
            background: var(--primary);
            color: var(--white);
        }

        .buy-now {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }
        .buy-now:hover:not(:disabled) {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .action-btn:disabled {
            background: #e0e0e0;
            color: #9e9e9e;
            cursor: not-allowed;
            border-color: #e0e0e0;
        }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--text-dark);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            z-index: 1001;
            opacity: 0;
            transition: transform 0.4s ease, opacity 0.4s ease;
            font-size: 14px;
            max-width: 90%;
            text-align: center;
        }
        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        
        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        .empty-state p {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <header class="header">
        <button class="header-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
        <a href="index.php" class="logo"><span>कन्या</span>Raag</a>
        <a href="cart.php" class="cart-icon header-btn">
            <i class="fas fa-shopping-bag"></i>
            <span class="cart-count" id="cart-count">0</span>
        </a>
    </header>

    <main class="container">
        <h1 class="page-title">Women's Collection</h1>

        <div class="products">
            <?php
            // Assume $conn is your database connection from db_connect.php
            $sql = "SELECT * FROM products ORDER BY RAND()";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $has_sizes = !empty($row['sizes']);
                    $in_stock = $row['stock'] > 0;
                    
                    // Calculate discount percentage
                    $discount_percent = 0;
                    if ($row['original_price'] > 0 && $row['original_price'] > $row['discount_price']) {
                        $discount_percent = round((($row['original_price'] - $row['discount_price']) / $row['original_price']) * 100);
                    }
                    ?>
                    <div class='card'>
                        <a href='product_detail.php?id=<?= $row['id'] ?>' class='card-image-link'>
                            <div class='card-image'>
                                <img src='<?= htmlspecialchars($row['product_image']) ?>' alt='<?= htmlspecialchars($row['product_name']) ?>' loading="lazy">
                                <?php if ($discount_percent > 0): ?>
                                    <div class='card-badge'><?= $discount_percent ?>% OFF</div>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class='card-content'>
                            <h3 class='card-title'><?= htmlspecialchars($row['product_name']) ?></h3>
                            <div class='price-container'>
                                <span class='current-price'>₹<?= number_format($row['discount_price']) ?></span>
                                <?php if ($discount_percent > 0): ?>
                                    <span class='original-price'>₹<?= number_format($row['original_price']) ?></span>
                                    <span class='discount-percent'>(<?= $discount_percent ?>% off)</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($has_sizes):
                                $all_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                                $available_sizes = explode(',', $row['sizes']);
                            ?>
                            <div class='size-selector'>
                                <h4 class='size-title'>Select Size</h4>
                                <div class='size-options'>
                                    <?php foreach ($all_sizes as $size):
                                        $isAvailable = in_array($size, $available_sizes);
                                    ?>
                                        <div class="size-option <?= $isAvailable ? '' : 'disabled' ?>" data-size="<?= $size ?>"><?= $size ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class='card-actions'>
                                <button class='action-btn add-to-cart'
                                    data-id='<?= $row['id'] ?>'
                                    data-name='<?= htmlspecialchars($row['product_name']) ?>'
                                    data-price='<?= $row['discount_price'] ?>'
                                    data-image='<?= htmlspecialchars($row['product_image']) ?>'
                                    data-has-sizes='<?= $has_sizes ? "true" : "false" ?>'
                                    <?= !$in_stock ? 'disabled' : '' ?>>
                                    <i class='fas fa-shopping-cart'></i>
                                    <?= $in_stock ? 'Add to Cart' : 'Out of Stock' ?>
                                </button>
                                <button class='action-btn buy-now' 
                                    data-id='<?= $row['id'] ?>' 
                                    data-has-sizes='<?= $has_sizes ? "true" : "false" ?>'
                                    <?= !$in_stock ? 'disabled' : '' ?>>
                                    <i class='fas fa-bolt'></i>
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                echo "<div class='empty-state'>
                    <i class='fas fa-tshirt'></i>
                    <p>No products available yet.</p>
                </div>";
            }
            if ($conn) { $conn->close(); }
            ?>
        </div>
    </main>

    <div class="toast" id="toast"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            function updateCartCount() {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const totalItems = cart.reduce((total, item) => total + item.qty, 0);
                document.getElementById('cart-count').textContent = totalItems;
            }

            function showToast(message) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.classList.add('show');
                setTimeout(() => { toast.classList.remove('show'); }, 2500);
            }

            // Size Selection Logic
            document.querySelectorAll('.size-options').forEach(container => {
                container.addEventListener('click', e => {
                    const target = e.target;
                    if (target.classList.contains('size-option') && !target.classList.contains('disabled')) {
                        // Deselect sibling options
                        container.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('selected'));
                        // Select the clicked option
                        target.classList.add('selected');
                    }
                });
            });

            // Add to Cart Logic
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.disabled) return;

                    const card = this.closest('.card');
                    const hasSizes = this.getAttribute('data-has-sizes') === 'true';
                    let selectedSize = null;

                    if (hasSizes) {
                        const selectedSizeEl = card.querySelector('.size-option.selected');
                        if (!selectedSizeEl) {
                            showToast('Please select a size first!');
                            return;
                        }
                        selectedSize = selectedSizeEl.getAttribute('data-size');
                    }

                    const product = {
                        id: this.getAttribute('data-id'),
                        name: this.getAttribute('data-name'),
                        price: this.getAttribute('data-price'),
                        image: this.getAttribute('data-image'),
                        size: selectedSize,
                        qty: 1
                    };

                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    const existingItemIndex = cart.findIndex(item => item.id === product.id && item.size === product.size);

                    if (existingItemIndex > -1) {
                        cart[existingItemIndex].qty += 1;
                    } else {
                        cart.push(product);
                    }

                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                    showToast(`Added: ${product.name} ${product.size ? '(' + product.size + ')' : ''}`);
                });
            });
            
            // Buy Now Logic
            document.querySelectorAll('.buy-now').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.disabled) return;

                    const card = this.closest('.card');
                    const hasSizes = this.getAttribute('data-has-sizes') === 'true';
                    
                    if (hasSizes) {
                        const selectedSizeEl = card.querySelector('.size-option.selected');
                        if (!selectedSizeEl) {
                            showToast('Please select a size first!');
                            return;
                        }
                        const id = this.getAttribute('data-id');
                        const size = selectedSizeEl.getAttribute('data-size');
                        // For Buy Now, you might add to cart and redirect, or just redirect
                        // Here, we redirect to product detail with size pre-selected
                        window.location.href = `product_detail.php?id=${id}&size=${size}`;
                    } else {
                        const id = this.getAttribute('data-id');
                        window.location.href = `product_detail.php?id=${id}`;
                    }
                });
            });

            // Initial cart count update on page load
            updateCartCount();
        });
    </script>
</body>
</html>