<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart - Kanyaraag</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0; padding: 0;
      background: #fafafa;
    }
    header {
      background: #6a4028;
      color: #fff;
      padding: 15px;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
    }
    .cart-container {
      max-width: 900px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .cart-item {
      display: grid;
      grid-template-columns: 80px 1fr 100px 120px 40px;
      align-items: center;
      gap: 15px;
      padding: 15px 0;
      border-bottom: 1px solid #ddd;
    }
    .cart-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 6px;
    }
    .cart-details h4 {
      margin: 0;
      font-size: 15px;
    }
    .cart-details p {
      margin: 4px 0;
      font-size: 13px;
      color: #555;
    }
    .qty-controls {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .qty-controls button {
      padding: 4px 8px;
      border: 1px solid #ccc;
      background: #eee;
      cursor: pointer;
      border-radius: 4px;
    }
    .qty-controls span {
      min-width: 20px;
      text-align: center;
      display: inline-block;
    }
    .remove-btn {
      color: red;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
    }
    .cart-total {
      text-align: right;
      font-size: 18px;
      margin-top: 20px;
      font-weight: bold;
    }
    .checkout-btn {
      display: block;
      margin: 20px auto 0;
      background: #6a4028;
      color: #fff;
      padding: 12px 25px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .checkout-btn:hover {
      background: #4a2c1b;
    }
    .empty-msg {
      text-align: center;
      font-size: 18px;
      padding: 40px;
      color: #666;
    }
  </style>
</head>
<body>
  <header>🛒 My Cart</header>

  <div class="cart-container" id="cart-container">
    <p class="empty-msg">Loading cart...</p>
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
              <p>Size: ${item.size}</p>
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

    loadCart();
  </script>
</body>
</html>
