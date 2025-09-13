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
      background: linear-gradient(135deg, #f9f5f0 0%, #f0e6dc 100%);
      color: #333;
      min-height: 100vh;
      padding-bottom: 40px;
    }
    
    /* Premium Header Styles */
    header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
      padding: 18px 6%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid rgba(199, 93, 44, 0.1);
    }
    
    .back-btn {
      background: rgba(199, 93, 44, 0.1);
      border: none;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #C75D2c;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(199, 93, 44, 0.15);
    }
    
    .back-btn:hover {
      background: rgba(199, 93, 44, 0.2);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(199, 93, 44, 0.2);
    }
    
    .logo {
      font-size: 28px;
      font-weight: 700;
      color: #C75D2c;
      text-decoration: none;
      letter-spacing: 1px;
      position: relative;
      padding: 0 10px;
    }
    
    .logo::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 10%;
      width: 80%;
      height: 2px;
      background: linear-gradient(90deg, transparent, #C75D2c, transparent);
    }
    
    .header-icons {
      display: flex;
      gap: 15px;
    }
    
    .header-icon {
      background: rgba(199, 93, 44, 0.1);
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #C75D2c;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(199, 93, 44, 0.15);
    }
    
    .header-icon:hover {
      background: rgba(199, 93, 44, 0.2);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(199, 93, 44, 0.2);
    }
    
    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px 20px;
    }
    
    .page-title {
      text-align: center;
      margin: 30px 0 40px;
      color: #333;
      font-weight: 600;
      position: relative;
      font-size: 32px;
      letter-spacing: 1px;
    }
    
    .page-title::after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: linear-gradient(90deg, transparent, #C75D2c, transparent);
    }
    
    /* Premium Cart Styles */
    .cart-container {
      background: rgba(255, 255, 255, 0.8);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      padding: 25px;
      margin-bottom: 30px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .empty-msg {
      text-align: center;
      padding: 60px 0;
      color: #777;
      font-size: 18px;
    }
    
    .cart-item {
      display: flex;
      align-items: center;
      padding: 20px 0;
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
    }
    
    .cart-item:hover {
      background: rgba(199, 93, 44, 0.03);
      border-radius: 12px;
      padding-left: 15px;
      padding-right: 15px;
    }
    
    .cart-item:last-child {
      border-bottom: none;
    }
    
    .cart-item img {
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 12px;
      margin-right: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }
    
    .cart-item:hover img {
      transform: scale(1.03);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    
    .cart-details {
      flex-grow: 1;
    }
    
    .cart-details h4 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #333;
      font-weight: 500;
      letter-spacing: 0.3px;
    }
    
    .cart-details p {
      margin-bottom: 8px;
      color: #555;
    }
    
    .qty-controls {
      display: flex;
      align-items: center;
      margin: 15px 0;
    }
    
    .qty-controls button {
      background: rgba(199, 93, 44, 0.1);
      border: none;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      transition: all 0.3s ease;
      color: #C75D2c;
    }
    
    .qty-controls button:hover {
      background: rgba(199, 93, 44, 0.2);
      transform: scale(1.1);
    }
    
    .qty-controls span {
      margin: 0 15px;
      font-weight: 500;
      min-width: 20px;
      text-align: center;
      font-size: 16px;
    }
    
    .remove-btn {
      background: rgba(255, 0, 0, 0.1);
      border: none;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 20px;
      transition: all 0.3s ease;
      color: #ff3b30;
      margin-left: 15px;
    }
    
    .remove-btn:hover {
      background: rgba(255, 0, 0, 0.15);
      transform: scale(1.1);
    }
    
    .cart-total {
      text-align: right;
      font-size: 22px;
      font-weight: 700;
      margin: 25px 0;
      color: #C75D2c;
      padding-top: 20px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .checkout-btn {
      display: block;
      width: 100%;
      background: linear-gradient(135deg, #C75D2c 0%, #d87d59 100%);
      color: white;
      border: none;
      padding: 18px;
      border-radius: 12px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
      box-shadow: 0 5px 15px rgba(199, 93, 44, 0.3);
    }
    
    .checkout-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(199, 93, 44, 0.4);
    }
    
    /* Premium Features */
    .premium-features {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      flex-wrap: wrap;
      gap: 20px;
    }
    
    .feature {
      flex: 1;
      min-width: 250px;
      background: rgba(255, 255, 255, 0.8);
      border-radius: 12px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .feature i {
      font-size: 40px;
      color: #C75D2c;
      margin-bottom: 15px;
    }
    
    .feature h3 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #333;
    }
    
    .feature p {
      color: #666;
      line-height: 1.5;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      header {
        padding: 15px 4%;
      }
      
      .logo {
        font-size: 22px;
      }
      
      .cart-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: center;
      }
      
      .cart-item img {
        margin: 0 auto 20px;
      }
      
      .qty-controls {
        justify-content: center;
        margin: 15px auto;
      }
      
      .remove-btn {
        align-self: center;
        margin: 10px auto 0;
      }
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 15px;
      }
      
      .cart-container {
        padding: 20px;
      }
      
      .page-title {
        font-size: 26px;
        margin: 20px 0 30px;
      }
      
      .header-icon, .back-btn {
        width: 40px;
        height: 40px;
      }
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .cart-item {
      animation: fadeIn 0.5s ease forwards;
    }
  </style>
</head>
<body>
  <!-- Premium Header -->
  <header>
    <button class="back-btn" onclick="window.history.back()">
      <i class="fas fa-arrow-left"></i>
    </button>
    <a href="#" class="logo">KANYARAAG</a>
    <div class="header-icons">
      <div class="header-icon">
        <i class="fas fa-search"></i>
      </div>
      <div class="header-icon">
        <i class="fas fa-user"></i>
      </div>
      <div class="header-icon">
        <i class="fas fa-heart"></i>
      </div>
    </div>
  </header>

  <div class="container">
    <h1 class="page-title">Your Shopping Cart</h1>
    
    <div class="cart-container" id="cart-container">
      <p class="empty-msg">Loading cart...</p>
    </div>
    
    <div class="premium-features">
      <div class="feature">
        <i class="fas fa-truck"></i>
        <h3>Free Shipping</h3>
        <p>On all orders over ₹5000</p>
      </div>
      
      <div class="feature">
        <i class="fas fa-shield-alt"></i>
        <h3>Secure Payment</h3>
        <p>100% secure payment processing</p>
      </div>
      
      <div class="feature">
        <i class="fas fa-undo"></i>
        <h3>Easy Returns</h3>
        <p>30-day money back guarantee</p>
      </div>
    </div>
  </div>

  <script>
    function loadCart() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      const container = document.getElementById('cart-container');
      container.innerHTML = "";

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
              <p>₹${item.price}</p>
            </div>
            <div class="qty-controls">
              <button onclick="updateQty(${index}, -1)">-</button>
              <span>${item.qty}</span>
              <button onclick="updateQty(${index}, 1)">+</button>
            </div>
            <div>₹${price.toFixed(2)}</div>
            <div class="remove-btn" onclick="removeItem(${index})">&times;</div>
          </div>
        `;
      });

      container.innerHTML += `
        <div class="cart-total">Total: ₹${total.toFixed(2)}</div>
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