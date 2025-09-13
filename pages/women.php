<?php
// Your database connection file remains the same.
include '../db/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanyaraag - A Premium Collection</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* Premium Desi Aesthetic Palette */
            --primary: #C75D2c;       /* Earthy Terracotta */
            --secondary: #5d4037;     /* Deep Brown for Text */
            --background: #fdfaf7;   /* Warm, creamy off-white */
            --white: #ffffff;
            --border-color: #e8e2dd; /* Soft, light brown border */
            --text-light: #8a7970;    /* Muted text color */
            --font-serif: 'Playfair Display', serif;
            --font-sans: 'Outfit', sans-serif;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--secondary);
            padding-top: 80px; /* Increased space for header */
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(253, 250, 247, 0.85); /* Semi-transparent background */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            z-index: 1000;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }
        
        .logo {
            font-family: var(--font-serif);
            font-weight: 700;
            font-size: 26px;
            color: var(--secondary);
            text-decoration: none;
        }
        .logo span {
            color: var(--primary);
        }

        .header-btn {
            background: none; border: none; font-size: 20px; cursor: pointer; color: var(--secondary);
            width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            transition: background-color 0.2s ease;
        }
        .header-btn:hover { background-color: var(--border-color); }
        .cart-icon { position: relative; text-decoration: none; }
        .cart-count {
            position: absolute; top: 5px; right: 5px; background: var(--primary); color: var(--white); font-size: 10px;
            width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 600; border: 2px solid var(--background);
        }
        
        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .page-title {
            text-align: center;
            font-family: var(--font-serif);
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 40px;
            position: relative;
        }
        .page-title::after {
            content: ''; display: block; width: 60px; height: 2px;
            background: var(--primary); margin: 10px auto 0;
        }

        /* Products Grid - 2 per row */
        .products {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        /* Stack to 1 column on small mobile phones */
        @media (max-width: 500px) {
            .products {
                grid-template-columns: 1fr;
            }
        }

        /* Product Card */
        .card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow);
        }

        .card-image {
            width: 100%;
            aspect-ratio: 3/4;
            overflow: hidden;
        }
        .card-image img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .card:hover .card-image img {
            transform: scale(1.05);
        }
        
        .card-content {
            padding: 20px;
            text-align: center;
        }

        .card-title {
            font-family: var(--font-serif);
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--secondary);
        }
        
        .price-container {
            display: flex; justify-content: center; align-items: baseline; gap: 10px;
        }
        .current-price {
            font-weight: 600; font-size: 20px; color: var(--primary);
        }
        .original-price {
            font-size: 14px; text-decoration: line-through; color: var(--text-light);
        }

        /* Hover Overlay for Actions */
        .card-hover-content {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, rgba(255, 255, 255, 1) 70%, rgba(255, 255, 255, 0));
            padding: 60px 20px 20px 20px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .card:hover .card-hover-content {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Hide original content on hover */
        .card:hover .card-content {
            visibility: hidden;
        }

        .size-options { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; margin-bottom: 16px; }
        .size-option {
            border: 1px solid var(--border-color); min-width: 40px; height: 40px; font-size: 14px; font-weight: 500;
            border-radius: 50%; cursor: pointer; user-select: none; transition: all 0.2s ease; display: grid; place-items: center;
        }
        .size-option:not(.disabled):hover { border-color: var(--primary); color: var(--primary); }
        .size-option.selected { background: var(--secondary); color: white; border-color: var(--secondary); }
        .size-option.disabled { background: #f5f5f5; color: #b0b0b0; cursor: not-allowed; }
        
        .card-actions { display: flex; gap: 10px; }
        .action-btn {
            flex: 1; padding: 12px; border: 1px solid; border-radius: 6px; font-family: var(--font-sans);
            font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;
        }
        .add-to-cart { background: var(--white); color: var(--secondary); border-color: var(--secondary); }
        .add-to-cart:hover:not(:disabled) { background: var(--secondary); color: var(--white); }
        .buy-now { background: var(--primary); color: var(--white); border-color: var(--primary); }
        .buy-now:hover:not(:disabled) { background: #af4d22; border-color: #af4d22; }
        .action-btn:disabled { background: #e0e0e0; color: #9e9e9e; cursor: not-allowed; border-color: #e0e0e0; }
        
        .toast { /* Toast styles unchanged, they work well */
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%) translateY(100px);
            background: var(--secondary); color: white; padding: 14px 22px; border-radius: 8px;
            box-shadow: var(--shadow); z-index: 1001; opacity: 0; transition: transform 0.4s ease, opacity 0.4s ease;
            font-size: 14px;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

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
            $sql = "SELECT * FROM products ORDER BY RAND()";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $has_sizes = !empty($row['sizes']);
                    $in_stock = $row['stock'] > 0;
                    $discount_percent = 0;
                    if ($row['original_price'] > 0 && $row['original_price'] > $row['discount_price']) {
                        $discount_percent = round((($row['original_price'] - $row['discount_price']) / $row['original_price']) * 100);
                    }
            ?>
            <div class='card' data-product-id='<?= $row['id'] ?>'>
                <a href='product_detail.php?id=<?= $row['id'] ?>' class='card-image-link'>
                    <div class='card-image'>
                        <img src='<?= htmlspecialchars($row['product_image']) ?>' alt='<?= htmlspecialchars($row['product_name']) ?>' loading="lazy">
                    </div>
                </a>
                
                <div class='card-content'>
                    <h3 class='card-title'><?= htmlspecialchars($row['product_name']) ?></h3>
                    <div class='price-container'>
                        <span class='current-price'>₹<?= $row['discount_price'] ?></span>
                        <?php if ($discount_percent > 0): ?>
                            <span class='original-price'>₹<?= $row['original_price'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-hover-content">
                    <?php if ($has_sizes):
                        $all_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                        $available_sizes = explode(',', $row['sizes']);
                    ?>
                    <div class='size-options'>
                        <?php foreach ($all_sizes as $size):
                            $isAvailable = in_array($size, $available_sizes);
                        ?>
                            <div class="size-option <?= $isAvailable ? '' : 'disabled' ?>" data-size="<?= $size ?>"><?= $size ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class='card-actions'>
                        <button class='action-btn add-to-cart'
                            data-id='<?= $row['id'] ?>' data-name='<?= htmlspecialchars($row['product_name']) ?>'
                            data-price='<?= $row['discount_price'] ?>' data-image='<?= htmlspecialchars($row['product_image']) ?>'
                            data-has-sizes='<?= $has_sizes ? "true" : "false" ?>'
                            <?= !$in_stock ? 'disabled' : '' ?>>
                            <?= $in_stock ? 'Add to Cart' : 'Out of Stock' ?>
                        </button>
                        <button class='action-btn buy-now' 
                            data-id='<?= $row['id'] ?>' data-has-sizes='<?= $has_sizes ? "true" : "false" ?>'
                            <?= !$in_stock ? 'disabled' : '' ?>>
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No products available yet.</p>";
            }
            if ($conn) { $conn->close(); }
            ?>
        </div>
    </main>

    <div class="toast" id="toast"></div>

    <script>
    // The JavaScript logic remains the same as it correctly targets the classes.
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

        document.querySelectorAll('.size-options').forEach(container => {
            container.addEventListener('click', e => {
                const target = e.target;
                if (target.classList.contains('size-option') && !target.classList.contains('disabled')) {
                    container.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('selected'));
                    target.classList.add('selected');
                }
            });
        });

        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent card link navigation
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
                    id: this.getAttribute('data-id'), name: this.getAttribute('data-name'),
                    price: this.getAttribute('data-price'), image: this.getAttribute('data-image'),
                    size: selectedSize, qty: 1
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

        document.querySelectorAll('.buy-now').forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent card link navigation
                if (this.disabled) return;

                const card = this.closest('.card');
                const hasSizes = this.getAttribute('data-has-sizes') === 'true';
                const id = this.getAttribute('data-id');

                if (hasSizes) {
                    const selectedSizeEl = card.querySelector('.size-option.selected');
                    if (!selectedSizeEl) {
                        showToast('Please select a size first!');
                        return;
                    }
                    const size = selectedSizeEl.getAttribute('data-size');
                    window.location.href = `product_detail.php?id=${id}&size=${size}`;
                } else {
                    window.location.href = `product_detail.php?id=${id}`;
                }
            });
        });

        updateCartCount();
    });
    </script>
</body>
</html>