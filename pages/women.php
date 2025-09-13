<?php
include '../db/db_connect.php';
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanyaraag - Women's Collection</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root{
            --white:#fff; --primary:#C75D2c; --primary-light:#fdf0eb;
            --primary-dark:#a54a22; --background:#f8f8f8; --text-dark:#2c2c2c;
            --text-light:#757575; --border-color:#e0e0e0;
            --shadow:0 5px 20px rgba(0,0,0,0.07);
            --shadow-light:0 2px 8px rgba(0,0,0,0.05);
            --radius-sm:6px; --radius-md:10px; --radius-lg:14px;
        }
        html{scroll-behavior:smooth;}
        body{
            font-family:'Outfit', sans-serif;
            background-color:var(--background);
            color:var(--text-dark);
            padding-top:80px;
            line-height:1.6;
        }
        .buy-now-btn {
    margin-top: 10px;
    width: 100%;
    padding: 10px;
    background: #C75D2c;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition:  .2s;
}
.buy-now-btn:hover {
    background: #a54a22;
}
.buy-now-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

        .header{
            position:fixed; top:0; left:0; width:100%;
            background:var(--white); border-bottom:1px solid var(--border-color);
            z-index:1000; padding:0 20px; display:flex; align-items:center;
            justify-content:space-between; height:80px; box-shadow:var(--shadow-light);
        }
        .header-btn{ background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-dark);
            width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:all .2s;}
        .header-btn:hover{ background-color:var(--primary-light); color:var(--primary); }
        .logo{ font-weight:800; font-size:24px; color:var(--text-dark); text-decoration:none; letter-spacing:-0.5px; }
        .logo span{ color:var(--primary); position:relative; }
        .logo span::after{ content:''; position:absolute; bottom:-2px; left:0; width:100%; height:2px; background:var(--primary); border-radius:2px; }
        .cart-icon{ position:relative; text-decoration:none; }
        .cart-count{ position:absolute; top:3px; right:3px; background:var(--primary); color:var(--white);
            font-size:10px; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-weight:700; border:2px solid var(--white); }
        .container{ max-width:1280px; margin:0 auto; padding:30px 20px; }
        .page-title{ text-align:center; font-size:32px; font-weight:700; margin-bottom:30px; position:relative; padding-bottom:15px; }
        .page-title::after{ content:''; position:absolute; bottom:0; left:50%; transform:translateX(-50%); width:60px; height:3px; background:var(--primary); border-radius:3px; }

        .filter-bar{ display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; flex-wrap:wrap; gap:15px;
            background:var(--white); padding:15px 20px; border-radius:var(--radius-md); box-shadow:var(--shadow-light); }
        .filter-group{ display:flex; align-items:center; gap:15px; }
        .filter-label{ font-weight:600; font-size:14px; color:var(--text-dark); }
        .filter-select{ padding:8px 12px; border:1px solid var(--border-color); border-radius:var(--radius-sm); background:var(--white);
            font-size:14px; cursor:pointer; }
        .filter-select:focus{ outline:none; border-color:var(--primary); }
        .view-toggle{ display:flex; gap:8px; }
        .view-btn{ background:var(--background); border:1px solid var(--border-color); width:36px; height:36px; border-radius:var(--radius-sm);
            display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .2s; }
        .view-btn.active{ background:var(--primary-light); color:var(--primary); border-color:var(--primary); }

        .products{ display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:25px; }
        .products.list-view{ grid-template-columns:1fr; }
        .card{ background:var(--white); border-radius:var(--radius-md); overflow:hidden; box-shadow:var(--shadow-light);
            transition:all .3s; display:flex; flex-direction:column; height:100%; position:relative; cursor: pointer; }
        .card:hover{ transform:translateY(-5px); box-shadow:var(--shadow); }
        .card-image{ position:relative; width:100%; aspect-ratio:3/4; overflow:hidden; background:#fff; display:flex; align-items:center; justify-content:center; }
        .card-image img{ width:100%; height:100%; object-fit:cover; transition:transform .5s ease; display:block; }
        .card:hover .card-image img{ transform:scale(1.08); }
        .card-badge{ position:absolute; top:12px; left:12px; background:var(--primary); color:white; padding:5px 10px; border-radius:var(--radius-sm); font-size:12px; font-weight:700; z-index:2; }
        .wishlist-btn{ position:absolute; top:12px; right:12px; width:36px; height:36px; border-radius:50%; background:var(--white); display:flex; align-items:center; justify-content:center; border:none; cursor:pointer; color:var(--text-light); transition:all .2s; z-index:2; }
        .wishlist-btn:hover{ color:var(--primary); background:var(--primary-light); }
        .wishlist-btn.active{ color:var(--primary); }
        
        /* New cart button on image */
        .cart-btn{ position:absolute; top:56px; right:12px; width:36px; height:36px; border-radius:50%; background:var(--white); display:flex; align-items:center; justify-content:center; border:none; cursor:pointer; color:var(--text-light); transition:all .2s; z-index:2; box-shadow: var(--shadow-light); }
        .cart-btn:hover{ color:var(--primary); background:var(--primary-light); }

        .card-content{ padding:18px; display:flex; flex-direction:column; flex-grow:1; }
        .card-title{ font-size:16px; font-weight:600; margin-bottom:8px; color:var(--text-dark); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; height:44px; line-height:1.4; }
        .price-container{ display:flex; align-items:center; gap:8px; margin-bottom:12px; flex-wrap:wrap; }
        .current-price{ font-weight:700; font-size:18px; color:var(--primary); }
        .original-price{ font-size:14px; text-decoration:line-through; color:var(--text-light); }
        .discount-percent{ font-size:13px; color:var(--primary); font-weight:600; background:var(--primary-light); padding:2px 6px; border-radius:4px; }

        .size-selector{ margin-top:auto; padding-top:10px; margin-bottom:15px; }
        .size-title{ font-size:13px; font-weight:600; margin-bottom:8px; color:var(--text-dark); }
        .size-options{ display:flex; gap:6px; flex-wrap:nowrap; overflow-x:auto; padding-bottom:5px; scrollbar-width:none; }
        .size-options::-webkit-scrollbar{ display:none; }
        .size-option{ border:1px solid var(--border-color); min-width:32px; height:32px; font-size:12px; font-weight:600; border-radius:var(--radius-sm); cursor:pointer; user-select:none; transition:all .2s; display:grid; place-items:center; flex-shrink:0; background:transparent; }
        .size-option:not(.disabled):hover{ border-color:var(--primary); color:var(--primary); }
        .size-option.selected{ background:var(--primary); color:white; border-color:var(--primary); }
        .size-option.disabled{ background:#f5f5f5; color:#b0b0b0; cursor:not-allowed; border-color:#e0e0e0; }

        .card-actions{ display:flex; flex-direction:column; gap:10px; margin-top:5px; }
        .action-btn{ width:100%; padding:12px; border:1px solid; border-radius:var(--radius-sm); font-size:14px; font-weight:600; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:8px; text-decoration:none; background:var(--white); }
        .add-to-cart{ color:var(--primary); border-color:var(--primary); }
        .add-to-cart:hover:not(:disabled){ background:var(--primary); color:var(--white); }
        .buy-now{ background:var(--primary); color:var(--white); border-color:var(--primary); }
        .buy-now:hover:not(:disabled){ background:var(--primary-dark); border-color:var(--primary-dark); }
        .action-btn:disabled{ background:#e0e0e0; color:#9e9e9e; cursor:not-allowed; border-color:#e0e0e0; }

        .toast{ position:fixed; bottom:25px; left:50%; transform:translateX(-50%) translateY(100px); background:var(--text-dark); color:white; padding:14px 24px; border-radius:var(--radius-md); box-shadow:var(--shadow); z-index:1001; opacity:0; transition:all .4s; font-size:15px; max-width:90%; text-align:center; display:flex; align-items:center; gap:10px; }
        .toast.show{ opacity:1; transform:translateX(-50%) translateY(0); }
        .toast.success{ background:var(--primary); color:#fff; }

        .empty-state{ grid-column:1 / -1; text-align:center; padding:60px 20px; color:var(--text-light); }
        .empty-state i{ font-size:64px; margin-bottom:20px; opacity:.3; }
        .empty-state p{ font-size:18px; margin-bottom:25px; }

        .loading{ display:inline-block; width:20px; height:20px; border:3px solid rgba(255,255,255,.3); border-radius:50%; border-top-color:#fff; animation:spin 1s ease-in-out infinite; }
        @keyframes spin{ to{ transform:rotate(360deg); } }

        @media (max-width:768px){ .filter-bar{ flex-direction:column; align-items:flex-start; } .filter-group{ width:100%; justify-content:space-between; } .products.list-view .card{ flex-direction:column; } .products.list-view .card-image{ width:100%; } .products.list-view .card-actions{ flex-direction:column; } }
        @media (max-width:480px){ .header{ padding:0 15px; height:70px; } .logo{ font-size:20px; } .page-title{ font-size:26px; } .products{ grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:15px; } }
    </style>
</head>
<body>

    <header class="header" role="banner">
        <button class="header-btn" onclick="history.back()" aria-label="Back"><i class="fas fa-arrow-left" aria-hidden="true"></i></button>
        <a href="index.php" class="logo" aria-label="Home"><span>कन्या</span>Raag</a>
        <a href="cart.php" class="cart-icon header-btn" aria-label="Cart">
            <i class="fas fa-shopping-bag" aria-hidden="true"></i>
            <span class="cart-count" id="cart-count">0</span>
        </a>
    </header>

    <main class="container" role="main">
        <h1 class="page-title">Women's Collection</h1>

        <!-- Filter and Sort Bar -->
        <div class="filter-bar" role="region" aria-label="Filter and sort products">
            <div class="filter-group" aria-hidden="false">
                <label class="filter-label" for="category-filter">Filter by:</label>
               

                <select class="filter-select" id="price-filter" aria-label="Price filter">
                    <option value="all">Price Range</option>
                    <option value="0-1000">Under ₹1000</option>
                    <option value="1000-2500">₹1000 - ₹2500</option>
                    <option value="2500-5000">₹2500 - ₹5000</option>
                    <option value="5000+">Over ₹5000</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label" for="sort-by">Sort by:</label>
                <select class="filter-select" id="sort-by" aria-label="Sort products">
                    <option value="default">Recommended</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="newest">Newest First</option>
                    <option value="popular">Most Popular</option>
                </select>

                <div class="view-toggle" role="toolbar" aria-label="Change view">
                    <button class="view-btn active" id="grid-view" title="Grid view" aria-pressed="true"><i class="fas fa-th" aria-hidden="true"></i></button>
                    <button class="view-btn" id="list-view" title="List view" aria-pressed="false"><i class="fas fa-list" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>

        <div class="products" id="products-container" aria-live="polite">
            <?php
            $sql = "SELECT * FROM products ORDER BY RAND()";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Safe outputs
                    $id = (int) $row['id'];
                    $name = htmlspecialchars($row['product_name']);
                    $image = htmlspecialchars($row['product_image']);
                    $category = htmlspecialchars(strtolower($row['category'] ?? 'uncategorized'));
                    $discount_price = (float) $row['discount_price'];
                    $original_price = (float) $row['original_price'];
                    $stock = isset($row['stock']) ? (int)$row['stock'] : 0;
                    $sizes_string = trim($row['sizes'] ?? '');
                    $has_sizes = !empty($sizes_string);
                    $available_sizes = $has_sizes ? array_map('trim', explode(',', $sizes_string)) : [];
                    // Calculate discount percent
                    $discount_percent = 0;
                    if ($original_price > 0 && $original_price > $discount_price) {
                        $discount_percent = round((($original_price - $discount_price) / $original_price) * 100);
                    }
                    // created_at fallback if exists
                    $created_at = $row['created_at'] ?? null;
                    // print the card
                    ?>
                    <div class="card"
                         data-category="<?= $category ?>"
                         data-price="<?= htmlspecialchars($discount_price) ?>"
                         data-original-price="<?= htmlspecialchars($original_price) ?>"
                         data-created="<?= htmlspecialchars($created_at) ?>"
                         data-stock="<?= $stock ?>"
                         data-id="<?= $id ?>"
                         onclick="window.location.href='product_detail.php?id=<?= $id ?>'">
                        <div class="card-image" aria-hidden="false">
                            <img src="<?= $image ?>" alt="<?= $name ?>" loading="lazy">
                            <?php if ($discount_percent > 0): ?>
                                <div class="card-badge"><?= $discount_percent ?>% OFF</div>
                            <?php endif; ?>
                            
                            
                            <!-- New cart button on image -->
                            <button class="cart-btn" data-id="<?= $id ?>" 
                                data-name="<?= $name ?>"
                                data-price="<?= htmlspecialchars($discount_price) ?>"
                                data-image="<?= $image ?>"
                                data-has-sizes="<?= $has_sizes ? 'true' : 'false' ?>"
                                <?= $stock <= 0 ? 'disabled' : '' ?>
                                aria-label="Add to cart">
                                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="card-content">
                            <h3 class="card-title"><?= $name ?></h3>

                            <div class="price-container">
                                <span class="current-price">₹<?= number_format($discount_price) ?></span>
                                <?php if ($discount_percent > 0): ?>
                                    <span class="original-price">₹<?= number_format($original_price) ?></span>
                                    <span class="discount-percent"><?= $discount_percent ?>% off</span>
                                <?php endif; ?>
                            </div>

                            <?php
                            // Size selector (render only if product has sizes)
                            $all_sizes = ['XS','S','M','L','XL','XXL'];
                            if ($has_sizes): ?>
                                <div class="size-selector" data-has-sizes="true" aria-label="Size selector">
                                    <h4 class="size-title">Select Size</h4>
                                    <div class="size-options" role="list">
                                        <?php foreach ($all_sizes as $s):
                                            $isAvailable = in_array($s, $available_sizes);
                                            $disabledClass = $isAvailable ? '' : 'disabled';
                                        ?>
                                            <div role="listitem" class="size-option <?= $disabledClass ?>" data-size="<?= $s ?>" aria-pressed="false"><?= $s ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- if no sizes, keep a data marker so JS knows -->
                                <div class="size-selector" data-has-sizes="false" style="display:none;"></div>
                            <?php endif; ?>
                            <!-- ✅ Buy Now Button -->
<button class="buy-now-btn" 
    data-id="<?= $id ?>" 
    data-name="<?= $name ?>"
    data-price="<?= $discount_price ?>"
    data-image="<?= $image ?>"
    data-has-sizes="<?= $has_sizes ? 'true' : 'false' ?>"
    <?= $stock <= 0 ? 'disabled' : '' ?>>
    Buy Now
</button>

                        </div>
                    </div>
                <?php
                } // end while
            } else {
                echo "<div class='empty-state'>
                    <i class='fas fa-tshirt' aria-hidden='true'></i>
                    <p>No products available yet.</p>
                    <button class='btn' onclick='history.back()'>Continue Shopping</button>
                </div>";
            }

            if ($conn) { $conn->close(); }
            ?>
        </div>
    </main>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script>
    (function(){
        'use strict';

        // small helpers
        const $ = sel => document.querySelector(sel);
        const $$ = sel => Array.from(document.querySelectorAll(sel));
        const toastEl = $('#toast');

        function showToast(message, type = '') {
            toastEl.textContent = message;
            toastEl.className = 'toast' + (type ? ' ' + type : '');
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 2500);
        }

        // Cart count init
        function getCart() {
            try {
                return JSON.parse(localStorage.getItem('cart')) || [];
            } catch (e) {
                return [];
            }
        }
        function setCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
        }
        function updateCartCount() {
            const cart = getCart();
            const total = cart.reduce((sum, it) => sum + (Number(it.qty) || 0), 0);
            $('#cart-count').textContent = total;
        }
        updateCartCount();

        // View toggle
        const gridViewBtn = $('#grid-view');
        const listViewBtn = $('#list-view');
        const productsContainer = $('#products-container');

        gridViewBtn.addEventListener('click', () => {
            productsContainer.classList.remove('list-view');
            gridViewBtn.classList.add('active'); gridViewBtn.setAttribute('aria-pressed','true');
            listViewBtn.classList.remove('active'); listViewBtn.setAttribute('aria-pressed','false');
        });
        listViewBtn.addEventListener('click', () => {
            productsContainer.classList.add('list-view');
            listViewBtn.classList.add('active'); listViewBtn.setAttribute('aria-pressed','true');
            gridViewBtn.classList.remove('active'); gridViewBtn.setAttribute('aria-pressed','false');
        });

        // Filtering and sorting
        const categoryFilter = $('#category-filter');
        const priceFilter = $('#price-filter');
        const sortBy = $('#sort-by');

        [categoryFilter, priceFilter, sortBy].forEach(el => el.addEventListener('change', applyFilters));

        function applyFilters() {
            const categoryValue = categoryFilter.value;
            const priceValue = priceFilter.value;
            const sortValue = sortBy.value;

            const cards = $$('.card').filter(c => c.style.display !== 'none'); // all cards
            // First, show all then apply filters
            $$('.card').forEach(card => card.style.display = '');

            // Category filter
            if (categoryValue !== 'all') {
                $$('.card').forEach(card => {
                    const productCategory = (card.dataset.category || '').toLowerCase();
                    card.style.display = productCategory.includes(categoryValue) ? '' : 'none';
                });
            }

            // Price filter
            if (priceValue !== 'all') {
                $$('.card').forEach(card => {
                    const price = parseFloat(card.dataset.price || '0');
                    let visible = true;
                    if (priceValue === '0-1000') visible = price <= 1000;
                    else if (priceValue === '1000-2500') visible = price >= 1000 && price <= 2500;
                    else if (priceValue === '2500-5000') visible = price >= 2500 && price <= 5000;
                    else if (priceValue === '5000+') visible = price > 5000;
                    card.style.display = visible ? '' : 'none';
                });
            }

            // Sorting (do only on visible items)
            if (sortValue !== 'default') {
                const parent = $('#products-container');
                const visibleCards = Array.from(parent.querySelectorAll('.card')).filter(c => c.style.display !== 'none');

                let sorted;
                if (sortValue === 'price-asc') {
                    sorted = visibleCards.sort((a,b)=> parseFloat(a.dataset.price||0) - parseFloat(b.dataset.price||0));
                } else if (sortValue === 'price-desc') {
                    sorted = visibleCards.sort((a,b)=> parseFloat(b.dataset.price||0) - parseFloat(a.dataset.price||0));
                } else if (sortValue === 'newest') {
                    sorted = visibleCards.sort((a,b)=>{
                        const da = a.dataset.created ? Date.parse(a.dataset.created) : 0;
                        const db = b.dataset.created ? Date.parse(b.dataset.created) : 0;
                        return db - da;
                    });
                } else {
                    sorted = visibleCards; // fallback
                }

                // re-append in order
                sorted.forEach(c => parent.appendChild(c));
            }
        }

        // Wishlist functionality (localStorage)
        function getWishlist() {
            try { return JSON.parse(localStorage.getItem('wishlist')) || []; } catch(e) { return []; }
        }
        function setWishlist(w) { localStorage.setItem('wishlist', JSON.stringify(w)); }

        $$('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const icon = this.querySelector('i');
                const productId = String(this.dataset.id);
                let wishlist = getWishlist();

                if (icon.classList.contains('far')) {
                    icon.classList.remove('far'); icon.classList.add('fas'); this.classList.add('active');
                    if (!wishlist.includes(productId)) wishlist.push(productId);
                    setWishlist(wishlist);
                    showToast('Added to wishlist!', 'success');
                } else {
                    icon.classList.remove('fas'); icon.classList.add('far'); this.classList.remove('active');
                    wishlist = wishlist.filter(id => id !== productId);
                    setWishlist(wishlist);
                    showToast('Removed from wishlist');
                }
            });
        });

        // initialize wishlist UI
        (function initWishlistUI(){
            const wishlist = getWishlist();
            $$('.wishlist-btn').forEach(btn => {
                if (wishlist.includes(String(btn.dataset.id))) {
                    btn.classList.add('active');
                    const icon = btn.querySelector('i');
                    icon.classList.remove('far'); icon.classList.add('fas');
                }
            });
        })();

        // Size selection (auto-disable logic already handled on server)
        $$('.size-options').forEach(container => {
            container.addEventListener('click', e => {
                e.stopPropagation();
                const target = e.target;
                if (!target.classList.contains('size-option') || target.classList.contains('disabled')) return;
                // de-select siblings
                container.querySelectorAll('.size-option').forEach(opt => {
                    opt.classList.remove('selected');
                    opt.setAttribute('aria-pressed','false');
                });
                target.classList.add('selected');
                target.setAttribute('aria-pressed','true');
            });
        });

        // Add to Cart from the cart button on image
        $$('.cart-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.disabled) return;
                const card = this.closest('.card');
                const hasSizes = this.dataset.hasSizes === 'true';
                let selectedSize = null;
                if (hasSizes) {
                    const sel = card.querySelector('.size-option.selected');
                    if (!sel) { showToast('Please select a size before adding to cart'); return; }
                    selectedSize = sel.dataset.size;
                }
                const id = String(this.dataset.id);
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price) || 0;
                const image = this.dataset.image || '';
                let cart = getCart();
                const existing = cart.find(item => item.id === id && (item.size || null) === selectedSize);

                if (existing) existing.qty = Number(existing.qty || 0) + 1;
                else cart.push({ id, name, price, image, size: selectedSize, qty: 1 });

                setCart(cart);
                updateCartCount();
                showToast('Added to cart!', 'success');
            });
        });

        // Initialize wishlist and cart UI states already done
        // Defensive: ensure cart-count is numeric
        (function normalizeCartCount(){
            const el = $('#cart-count');
            const n = parseInt(el.textContent, 10);
            if (isNaN(n)) el.textContent = 0;
        })();

    })();
    
    </script>
</body>
</html>