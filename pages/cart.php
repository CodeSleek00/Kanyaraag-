<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart - Kanyaraag</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Outfit', sans-serif;
    }
    
    body {
      background-color: #f8f8f8;
      color: #333;
    }
    
    /* Header Styles */
    header {
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 15px 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .back-btn {
      background: none;
      border: none;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      color: #C75D2c;
      font-weight: 500;
    }
    
    .back-btn svg {
      margin-right: 5px;
    }
    
    .logo {
      font-size: 24px;
      font-weight: 700;
      color: #C75D2c;
      text-decoration: none;
    }
    
    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .page-title {
      text-align: center;
      margin: 20px 0 30px;
      color: #333;
      font-weight: 600;
    }
    
    /* Cart Styles */
    .cart-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 20px;
      margin-bottom: 30px;
    }
    
    .empty-cart {
      text-align: center;
      padding: 40px 0;
      color: #777;
    }
    
    .empty-cart p {
      margin-bottom: 20px;
      font-size: 18px;
    }
    
    .continue-shopping {
      display: inline-block;
      background-color: #C75D2c;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.3s;
    }
    
    .continue-shopping:hover {
      background-color: #b35226;
    }
    
    .cart-item {
      display: flex;
      align-items: center;
      padding: 15px 0;
      border-bottom: 1px solid #eee;
    }
    
    .cart-item:last-child {
      border-bottom: none;
    }
    
    .cart-item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 20px;
    }
    
    .item-details {
      flex-grow: 1;
    }
    
    .item-details h3 {
      font-size: 18px;
      margin-bottom: 8px;
      color: #333;
      font-weight: 500;
    }
    
    .item-price {
      font-weight: 600;
      color: #C75D2c;
      margin-bottom: 10px;
      font-size: 16px;
    }
    
    .quantity-controls {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
    
    .quantity-controls button {
      background: #f0f0f0;
      border: none;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      transition: background 0.3s;
    }
    
    .quantity-controls button:hover {
      background: #e0e0e0;
    }
    
    .qty {
      margin: 0 12px;
      font-weight: 500;
      min-width: 20px;
      text-align: center;
    }
    
    .item-total {
      font-weight: 600;
      color: #333;
    }
    
    .remove-btn {
      background: none;
      border: none;
      color: #ff3b30;
      cursor: pointer;
      font-size: 14px;
      display: flex;
      align-items: center;
      margin-top: 5px;
    }
    
    .remove-btn svg {
      margin-right: 5px;
    }
    
    /* Cart Summary */
    .cart-summary {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 20px;
      margin-top: 20px;
    }
    
    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }
    
    .summary-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    
    .total-label {
      font-weight: 500;
    }
    
    .total-amount {
      font-weight: 700;
      font-size: 20px;
      color: #C75D2c;
    }
    
    .checkout-btn {
      display: block;
      width: 100%;
      background-color: #C75D2c;
      color: white;
      border: none;
      padding: 15px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 20px;
    }
    
    .checkout-btn:hover {
      background-color: #b35226;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .cart-item {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .cart-item img {
        margin-bottom: 15px;
      }
      
      .quantity-controls {
        margin-top: 10px;
      }
      
      header {
        padding: 15px 4%;
      }
      
      .logo {
        font-size: 20px;
      }
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 15px;
      }
      
      .cart-container, .cart-summary {
        padding: 15px;
      }
      
      .page-title {
        font-size: 22px;
        margin: 15px 0 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Header with back button and logo -->
  <header>
    <button class="back-btn" onclick="window.history.back()">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 12L6 8L10 4" stroke="#C75D2c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Back
    </button>
    <a href="#" class="logo">Kanyaraag</a>
    <div style="width: 60px;"></div> <!-- Spacer for balance -->
  </header>

  <div class="container">
    <h1 class="page-title">Your Shopping Cart</h1>
    
    <div class="cart-container" id="cart-container"></div>
    
    <div class="cart-summary">
      <div class="summary-row">
        <span class="total-label">Subtotal</span>
        <span id="subtotal">₹0</span>
      </div>
      <div class="summary-row">
        <span class="total-label">Shipping</span>
        <span>₹50</span>
      </div>
      <div class="summary-row">
        <span class="total-label">Total</span>
        <span class="total-amount" id="total">₹0</span>
      </div>
      
      <button class="checkout-btn">Proceed to Checkout</button>
    </div>
  </div>

  <script>
    function loadCart() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let container = document.getElementById("cart-container");
      container.innerHTML = "";

      let subtotal = 0;

      if (cart.length === 0) {
        container.innerHTML = `
          <div class="empty-cart">
            <p>Your cart is empty!</p>
            <a href="#" class="continue-shopping">Continue Shopping</a>
          </div>
        `;
        document.getElementById("subtotal").innerText = "₹0";
        document.getElementById("total").innerText = "₹0";
        return;
      }

      cart.forEach((item, index) => {
        const itemTotal = item.price * item.qty;
        subtotal += itemTotal;

        const cartItemElement = document.createElement("div");
        cartItemElement.className = "cart-item";
        cartItemElement.innerHTML = `
          <img src="${item.image}" alt="${item.name}">
          <div class="item-details">
            <h3>${item.name}</h3>
            <p class="item-price">₹${item.price}</p>
            <div class="quantity-controls">
              <button onclick="updateQty(${index}, -1)">-</button>
              <span class="qty">${item.qty}</span>
              <button onclick="updateQty(${index}, 1)">+</button>
            </div>
            <p class="item-total">Total: ₹${itemTotal}</p>
            <button class="remove-btn" onclick="removeItem(${index})">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 4H14M5 4V2H11V4M13 4V14C13 14.5304 12.7893 15.0391 12.4142 15.4142C12.0391 15.7893 11.5304 16 11 16H5C4.46957 16 3.96086 15.7893 3.58579 15.4142C3.21071 15.0391 3 14.5304 3 14V4H13Z" stroke="#ff3b30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Remove
            </button>
          </div>
        `;
        container.appendChild(cartItemElement);
      });

      const shipping = 50;
      const total = subtotal + shipping;
      
      document.getElementById("subtotal").innerText = "₹" + subtotal;
      document.getElementById("total").innerText = "₹" + total;
    }

    function updateQty(index, change) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      cart[index].qty += change;
      if (cart[index].qty <= 0) cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      loadCart();
    }

    function removeItem(index) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      loadCart();
    }

    // Initialize cart on page load
    loadCart();
  </script>
</body>
</html>