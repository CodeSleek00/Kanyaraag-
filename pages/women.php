<?php
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
            --white: #ffffff;
            --primary: #C75D2c;
            --primary-light: #fdf0eb;
            --primary-dark: #a54a22;
            --background: #f8f8f8;
            --text-dark: #2c2c2c;
            --text-light: #757575;
            --border-color: #e0e0e0;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
            --shadow-light: 0 2px 8px rgba(0, 0, 0, 0.05);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            padding-top: 80px;
            line-height: 1.6;
        }

        /* Header - Enhanced */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            z-index: 1000;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
            box-shadow: var(--shadow-light);
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
            transition: all 0.2s ease;
        }
        .header-btn:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .logo {
            font-weight: 800;
            font-size: 24px;
            color: var(--text-dark);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo span {
            color: var(--primary);
            position: relative;
        }
        .logo span::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .cart-icon {
            position: relative;
            text-decoration: none;
        }
        .cart-count {
            position: absolute;
            top: 3px;
            right: 3px;
            background: var(--primary);
            color: var(--white);
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid var(--white);
        }

        /* Main Content */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .page-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        /* Filter and Sort Bar */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
            background: var(--white);
            padding: 15px 20px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-light);
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .filter-label {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
        }
        
        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            background: var(--white);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }
        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .view-toggle {
            display: flex;
            gap: 8px;
        }
        
        .view-btn {
            background: var(--background);
            border: 1px solid var(--border-color);
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .view-btn.active {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Products Grid - Enhanced */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
        }
        
        .products.list-view {
            grid-template-columns: 1fr;
        }
        
        .products.list-view .card {
            flex-direction: row;
            height: auto;
        }
        
        .products.list-view .card-image {
            width: 280px;
            height: 320px;
            flex-shrink: 0;
        }
        
        .products.list-view .card-content {
            padding: 25px;
            flex-grow: 1;
        }
        
        .products.list-view .card-title {
            font-size: 18px;
            height: auto;
            -webkit-line-clamp: 2;
        }
        
        .products.list-view .card-actions {
            flex-direction: row;
            margin-top: 20px;
        }
        
        .products.list-view .action-btn {
            flex: 1;
        }

        /* Product Card - Enhanced */
        .card {
            background: var(--white);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }
        .card:hover {
            transform: translateY(-5px);
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
            transition: transform 0.5s ease;
        }
        .card:hover .card-image img {
            transform: scale(1.08);
        }
        
        .card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 700;
            z-index: 2;
        }
        
        .wishlist-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            color: var(--text-light);
            transition: all 0.2s ease;
            z-index: 2;
        }
        .wishlist-btn:hover {
            color: var(--primary);
            background: var(--primary-light);
        }
        .wishlist-btn.active {
            color: var(--primary);
        }

        .card-content {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 44px;
            line-height: 1.4;
        }

        .price-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }
        .current-price {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }
        .original-price {
            font-size: 14px;
            text-decoration: line-through;
            color: var(--text-light);
        }
        .discount-percent {
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
            background: var(--primary-light);
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* Size Selector - Enhanced */
        .size-selector {
            margin-top: auto;
            padding-top: 10px;
            margin-bottom: 15px;
        }
        .size-title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
        }
        .size-options {
            display: flex;
            gap: 6px;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: none;
        }
        .size-options::-webkit-scrollbar {
            display: none;
        }
        .size-option {
            border: 1px solid var(--border-color);
            min-width: 32px;
            height: 32px;
            font-size: 12px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
            display: grid;
            place-items: center;
            flex-shrink: 0;
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
        
        /* Action Buttons - Enhanced */
        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 5px;
        }

        .action-btn {
            width: 100%;
            padding: 12px;
            border: 1px solid;
            border-radius: var(--radius-sm);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
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
        
        /* Quick View Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modal.show {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background: var(--white);
            width: 90%;
            max-width: 900px;
            border-radius: var(--radius-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 90vh;
            transform: translateY(30px);
            transition: transform 0.3s ease;
        }
        
        .modal.show .modal-content {
            transform: translateY(0);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 600;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-light);
            transition: color 0.2s ease;
        }
        .modal-close:hover {
            color: var(--primary);
        }
        
        .modal-body {
            padding: 20px;
            overflow-y: auto;
        }
        
        /* Toast Notification - Enhanced */
        .toast {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--text-dark);
            color: white;
            padding: 14px 24px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow);
            z-index: 1001;
            opacity: 0;
            transition: all 0.4s ease;
            font-size: 15px;
            max-width: 90%;
            text-align: center;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .toast.success {
            background: var(--primary);
        }
        
        /* Empty State - Enhanced */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        .empty-state p {
            font-size: 18px;
            margin-bottom: 25px;
        }
        .empty-state .btn {
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .empty-state .btn:hover {
            background: var(--primary-dark);
        }
        
        /* Quick View Button */
        .quick-view-btn {
            position: absolute;
            bottom: -40px;
            left: 0;
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: bottom 0.3s ease;
            z-index: 2;
        }
        .card-image:hover .quick-view-btn {
            bottom: 0;
        }
        
        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-group {
                width: 100%;
                justify-content: space-between;
            }
            
            .products.list-view .card {
                flex-direction: column;
            }
            
            .products.list-view .card-image {
                width: 100%;
            }
            
            .products.list-view .card-actions {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            .header {
                padding: 0 15px;
                height: 70px;
            }
            
            .logo {
                font-size: 20px;
            }
            
            .page-title {
                font-size: 26px;
            }
            
            .products {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }
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
        
        <!-- Filter and Sort Bar -->
        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-label">Filter by:</span>
                <select class="filter-select" id="category-filter">
                    <option value="all">All Categories</option>
                    <option value="dresses">Dresses</option>
                    <option value="tops">Tops</option>
                    <option value="bottoms">Bottoms</option>
                    <option value="outerwear">Outerwear</option>
                </select>
                <select class="filter-select" id="price-filter">
                    <option value="all">Price Range</option>
                    <option value="0-1000">Under ₹1000</option>
                    <option value="1000-2500">₹1000 - ₹2500</option>
                    <option value="2500-5000">₹2500 - ₹5000</option>
                    <option value="5000+">Over ₹5000</option>
                </select>
            </div>
            
            <div class="filter-group">
                <span class="filter-label">Sort by:</span>
                <select class="filter-select" id="sort-by">
                    <option value="default">Recommended</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="newest">Newest First</option>
                    <option value="popular">Most Popular</option>
                </select>
                
                <div class="view-toggle">
                    <button class="view-btn active" id="grid-view"><i class="fas fa-th"></i></button>
                    <button class="view-btn" id="list-view"><i class="fas fa-list"></i></button>
                </div>
            </div>
        </div>

        <div class="products" id="products-container">
            <?php
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
                    <div class='card' data-category="<?= strtolower($row['category'] ?? 'uncategorized') ?>" data-price="<?= $row['discount_price'] ?>">
                        <div class='card-image'>
                            <img src='<?= htmlspecialchars($row['product_image']) ?>' alt='<?= htmlspecialchars($row['product_name']) ?>' loading="lazy">
                            <?php if ($discount_percent > 0): ?>
                                <div class='card-badge'><?= $discount_percent ?>% OFF</div>
                            <?php endif; ?>
                            <button class='wishlist-btn' data-id='<?= $row['id'] ?>'>
                                <i class='far fa-heart'></i>
                            </button>
                            <button class='quick-view-btn' data-id='<?= $row['id'] ?>'>Quick View</button>
                        </div>
                        <div class='card-content'>
                            <h3 class='card-title'><?= htmlspecialchars($row['product_name']) ?></h3>
                            <div class='price-container'>
                                <span class='current-price'>₹<?= number_format($row['discount_price']) ?></span>
                                <?php if ($discount_percent > 0): ?>
                                    <span class='original-price'>₹<?= number_format($row['original_price']) ?></span>
                                    <span class='discount-percent'><?= $discount_percent ?>% off</span>
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
                    <button class='btn' onclick='history.back()'>Continue Shopping</button>
                </div>";
            }
            if ($conn) { $conn->close(); }
            ?>
        </div>
    </main>

    <!-- Quick View Modal -->
    <div class="modal" id="quick-view-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Product Quick View</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body" id="modal-product-content">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize cart count
        updateCartCount();
        
        // View toggle functionality
        const gridViewBtn = document.getElementById('grid-view');
        const listViewBtn = document.getElementById('list-view');
        const productsContainer = document.getElementById('products-container');
        
        gridViewBtn.addEventListener('click', () => {
            productsContainer.classList.remove('list-view');
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
        });
        
        listViewBtn.addEventListener('click', () => {
            productsContainer.classList.add('list-view');
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
        });
        
        // Filter functionality
        const categoryFilter = document.getElementById('category-filter');
        const priceFilter = document.getElementById('price-filter');
        const sortBy = document.getElementById('sort-by');
        
        [categoryFilter, priceFilter, sortBy].forEach(filter => {
            filter.addEventListener('change', applyFilters);
        });
        
        function applyFilters() {
            const categoryValue = categoryFilter.value;
            const priceValue = priceFilter.value;
            const sortValue = sortBy.value;
            
            const products = Array.from(document.querySelectorAll('.card'));
            
            // Filter by category
            if (categoryValue !== 'all') {
                products.forEach(product => {
                    const productCategory = product.dataset.category;
                    product.style.display = productCategory.includes(categoryValue) ? '' : 'none';
                });
            } else {
                products.forEach(product => product.style.display = '');
            }
            
            // Filter by price (would need more complex implementation with actual API)
            // This is just a basic example
            if (priceValue !== 'all') {
                // Implementation would depend on your data structure
            }
            
            // Sort products (would need more complex implementation with actual API)
            if (sortValue !== 'default') {
                // Implementation would depend on your data structure
            }
        }
        
        // Wishlist functionality
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const productId = this.dataset.id;
                
                if (icon.classList.contains('far')) {
                    // Add to wishlist
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.classList.add('active');
                    
                    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    if (!wishlist.includes(productId)) {
                        wishlist.push(productId);
                        localStorage.setItem('wishlist', JSON.stringify(wishlist));
                        showToast('Added to wishlist!', 'success');
                    }
                } else {
                    // Remove from wishlist
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.classList.remove('active');
                    
                    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                    wishlist = wishlist.filter(id => id !== productId);
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    showToast('Removed from wishlist');
                }
            });
        });
        
        // Quick view functionality
        document.querySelectorAll('.quick-view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                openQuickView(productId);
            });
        });
        
        // Close modal
        document.querySelector('.modal-close').addEventListener('click', () => {
            document.getElementById('quick-view-modal').classList.remove('show');
        });
        
        // Close modal when clicking outside
        document.getElementById('quick-view-modal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('quick-view-modal')) {
                document.getElementById('quick-view-modal').classList.remove('show');
            }
        });
        
        function openQuickView(productId) {
            // In a real implementation, you would fetch product details via AJAX
            // For this example, we'll just show a placeholder
            document.getElementById('modal-product-content').innerHTML = `
                <div style="text-align: center; padding: 40px 20px;">
                    <div class="loading"></div>
                    <p style="margin-top: 20px;">Loading product details...</p>
                </div>
            `;
            
            document.getElementById('quick-view-modal').classList.add('show');
            
            // Simulate AJAX loading
            setTimeout(() => {
                document.getElementById('modal-product-content').innerHTML = `
                    <p>Detailed product view would appear here for product ID: ${productId}</p>
                    <p>In a real implementation, this would show:</p>
                    <ul>
                        <li>Product images gallery</li>
                        <li>Full description</li>
                        <li>Available colors</li>
                        <li>Size chart</li>
                        <li>Customer reviews</li>
                        <li>Shipping information</li>
                    </ul>
                `;
            }, 1000);
        }
        
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalItems = cart.reduce((total, item) => total + item.qty, 0);
            document.getElementById('cart-count').textContent = totalItems;
        }

        function showToast(message, type = '') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast' + (type ? ' ' + type : '');
            toast.classList.add('show');
            
            setTimeout(() => { 
                toast.classList.remove('show'); 
            }, 2500);
        }

        // Size Selection Logic
        document.querySelectorAll('.size-options').forEach(container => {
            container.addEventListener('click', e => {
                const target = e.target;
                if (target.classList.contains('size-option') && !target.classList.contains('disabled')) {
                    container.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('selected'));
                    target.classList.add('selected');
                }
            });
        });

        // Add to Cart Logic
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.disabled) return;

                const card = this.closest('.card');
                const hasSizes = this.dataset.hasSizes === "true";
                let selectedSize = null;

                if (hasSizes) {
                    const selected = card.querySelector('.size-option.selected');
                    if (!selected) {
                        showToast("Please select a size before adding to cart");
                        return;
                    }
                    selectedSize = selected.dataset.size;
                }

                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);
                const image = this.dataset.image;

                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const existing = cart.find(item => item.id === id && item.size === selectedSize);

                if (existing) {
                    existing.qty += 1;
                } else {
                    cart.push({ id, name, price, image, size: selectedSize, qty: 1 });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                showToast("Added to cart!", "success");
            });
        });

        // Buy Now Logic
        document.querySelectorAll('.buy-now').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.disabled) return;

                const id = this.dataset.id;
                window.location.href = "product_detail.php?id=" + id;
            });
        });
        
        // Initialize wishlist buttons
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            const productId = btn.dataset.id;
            if (wishlist.includes(productId)) {
                const icon = btn.querySelector('i');
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.classList.add('active');
            }
        });
    });
    </script>
</body>
</html>