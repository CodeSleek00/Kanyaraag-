<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart - Kanyaraag</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Outfit', sans-serif;
    }
    
    body {
      background-color: #faf7f2;
      color: #4a4a4a;
      min-height: 100vh;
      padding-bottom: 40px;
      background-image: radial-gradient(#e2d6c9 1px, transparent 1px);
      background-size: 20px 20px;
    }
    
    /* Minimal Desi Header */
    header {
      background-color: #fff;
      padding: 15px 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid #e2d6c9;
    }
    
    .back-btn {
      background: none;
      border: none;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      color: #c25728;
      font-weight: 500;
    }
    
    .back-btn i {
      margin-right: 5px;
    }
    
    .logo {
      font-size: 24px;
      font-weight: 700;
      color: #c25728;
      text-decoration: none;
      position: relative;
    }
    
    .logo::after {
      content: "";
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, transparent, #c25728, transparent);
    }
    
    .cart-icon {
      position: relative;
    }
    
    .cart-count {
      position: absolute;
      top: -8px;
      right: -8px;
      background: #c25728;
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
    }
    
    /* Main Content */
    .container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .page-title {
      text-align: center;
      margin: 30px 0;
      color: #4a4a4a;
      font-weight: 400;
      position: relative;
      font-size: 28px;
    }
    
    .page-title::before, .page-title::after {
      content: "•";
      color: #c25728;
      margin: 0 15px;
    }
    
    /* Minimal Cart Design */
    .cart-container {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
      border: 1px solid #e2d6c9;
    }
    
    .empty-msg {
      text-align: center;
      padding: 40px 0;
      color: #9e9e9e;
      font-size: 18px;
    }
    
    .cart-item {
      display: grid;
      grid-template-columns: 100px 1fr auto auto;
      align-items: center;
      padding: 20px 0;
      border-bottom: 1px solid #f0e8df;
      gap: 15px;
    }
    
    .cart-item:last-child {
      border-bottom: none;
    }
    
    .cart-item img {
      width: 100%;
      border-radius: 8px;
      aspect-ratio: 1/1;
      object-fit: cover;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    .cart-details h4 {
      font-size: 16px;
      margin-bottom: 8px;
      color: #4a4a4a;
      font-weight: 500;
    }
    
    .cart-details p {
      margin-bottom: 5px;
      color: #777;
      font-size: 14px;
    }
    
    .qty-controls {
      display: flex;
      align-items: center;
      border: 1px solid #e2d6c9;
      border-radius: 20px;
      padding: 5px;
    }
    
    .qty-controls button {
      background: none;
      border: none;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 16px;
      color: #c25728;
      transition: all 0.2s;
    }
    
    .qty-controls button:hover {
      background: #f9f5f0;
    }
    
    .qty-controls span {
      margin: 0 10px;
      font-weight: 500;
      min-width: 20px;
      text-align: center;
    }
    
    .item-price {
      font-weight: 600;
      color: #c25728;
      text-align: right;
    }
    
    .remove-btn {
      background: none;
      border: none;
      color: #999;
      cursor: pointer;
      font-size: 20px;
      transition: all 0.2s;
      padding: 5px;
    }
    
    .remove-btn:hover {
      color: #c25728;
    }
    
    .cart-total {
      text-align: right;
      font-size: 20px;
      font-weight: 500;
      margin: 25px 0;
      color: #4a4a4a;
      padding-top: 20px;
      border-top: 1px solid #e2d6c9;
    }
    
    .cart-total span {
      color: #c25728;
      font-weight: 600;
    }
    
    .checkout-btn {
      display: block;
      width: 100%;
      background: #c25728;
      color: white;
      border: none;
      padding: 16px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 10px rgba(194, 87, 40, 0.2);
    }
    
    .checkout-btn:hover {
      background: #a94a21;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(194, 87, 40, 0.25);
    }
    
    /* Desi Pattern Divider */
    .divider {
      height: 20px;
      background-image: 
        repeating-linear-gradient(
          45deg,
          transparent,
          transparent 10px,
          #e2d6c9 10px,
          #e2d6c9 12px
        );
      margin: 30px 0;
      border-radius: 2px;
    }
    
    /* Features with Desi Touch */
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 40px;
    }
    
    .feature {
      background: #fff;
      border-radius: 8px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
      border: 1px solid #e2d6c9;
      position: relative;
      overflow: hidden;
    }
    
    .feature::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #c25728, #e2a16d);
    }
    
    .feature i {
      font-size: 32px;
      color: #c25728;
      margin-bottom: 15px;
    }
    
    .feature h3 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #4a4a4a;
      font-weight: 500;
    }
    
    .feature p {
      color: #777;
      line-height: 1.5;
      font-size: 14px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .cart-item {
        grid-template-columns: 80px 1fr;
        grid-template-areas: 
          "image details"
          "image price"
          "qty remove";
        gap: 10px;
      }
      
      .cart-item img {
        grid-area: image;
      }
      
      .cart-details {
        grid-area: details;
      }
      
      .qty-controls {
        grid-area: qty;
        justify-self: start;
        margin-top: 10px;
      }
      
      .item-price {
        grid-area: price;
        text-align: left;
        align-self: start;
      }
      
      .remove-btn {
        grid-area: remove;
        justify-self: end;
        align-self: start;
      }
      
      .features {
        grid-template-columns: 1fr;
      }
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 15px;
      }
      
      .cart-container {
        padding: 15px;
      }
      
      .page-title {
        font-size: 24px;
      }
      
      header {
        padding: 12px 4%;
      }
    }
    
    /* Subtle animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .cart-item {
      animation: fadeIn 0.4s ease forwards;
    }
  </style>
</head>
<body>
  <!-- Minimal Desi Header -->
  <header>
    <button class="back-btn" onclick="window.history.back()">
      <i class="fas fa-arrow-left"></i> Back
    </button>
    <a href="#" class="logo">KANYARAAG</a>
    <div class="cart-icon">
      <i class="fas fa-shopping-bag" style="color: #c25728;"></i>
      <span class="cart-count" id="cart-count">0</span>
    </div>
  </header>

  <div class="container">
    <h1 class="page-title">Your Shopping Cart</h1>
    
    <div class="cart-container" id="cart-container">
      <p class="empty-msg">Loading cart...</p>
    </div>
    
    <div class="divider"></div>
    
    <div class="features">
      <div class="feature">
        <i class="fas fa-truck"></i>
        <h3>Free Shipping</h3>
        <p>On orders above ₹2999</p>
      </div>
      
      <div class="feature">
        <i class="fas fa-shield-alt"></i>
        <h3>Secure Payment</h3>
        <p>100% secure payment processing</p>
      </div>
      
      <div class="feature">
        <i class="fas fa-undo"></i>
        <h3>Easy Returns</h3>
        <p>15-day hassle-free returns</p>
      </div>
    </div>
  </div>

  <script>
    function loadCart() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      const container = document.getElementById('cart-container');
      const cartCount = document.getElementById('cart-count');
      container.innerHTML = "";
      
      // Update cart count
      cartCount.textContent = cart.reduce((total, item) => total + item.qty, 0);

      if (cart.length === 0) {
        container.innerHTML = "<p class='empty-msg'>Your cart is empty.</p>";
        return;
      }

      let total = 0;
      cart.forEach((item, index) => {
        let price = parseFloat(item.price) * item.qty;
        total += price;

        container.innerHTML += `
          <div class="cart-item" data-index="${index}">
            <img src="${item.image}" alt="${item.name}">
            <div class="cart-details">
              <h4>${item.name}</h4>
              <p>Size: ${item.size || 'One Size'}</p>
            </div>
            <div class="qty-controls">
              <button onclick="updateQty(${index}, -1)">-</button>
              <span>${item.qty}</span>
              <button onclick="updateQty(${index}, 1)">+</button>
            </div>
            <div class="item-price">₹${price.toFixed(2)}</div>
            <button class="remove-btn" onclick="removeItem(${index})">&times;</button>
          </div>
        `;
      });

      container.innerHTML += `
        <div class="cart-total">Total: <span>₹${total.toFixed(2)}</span></div>
        <button class="checkout-btn" onclick="proceedCheckout()">Proceed to Checkout</button>
      `;
    }

    function updateQty(index, change) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      if (!cart[index]) return;

      cart[index].qty += change;
      if (cart[index].qty <= 0) cart.splice(index, 1);

      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }

    function removeItem(index) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }

    function proceedCheckout() {
      window.location.href = "checkout.php";
    }

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', loadCart);
  </script>
</body>
</html>