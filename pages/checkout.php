<?php
// checkout.php
include '../db/db_connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - कन्याRaag</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {font-family: 'Outfit', sans-serif; margin:0; padding:0; background:#fafafa;}
    .container {max-width: 1000px; margin: 40px auto; padding: 20px;}
    h1 {margin-bottom: 20px;}
    table {width:100%; border-collapse: collapse; background:#fff; box-shadow: 0 2px 6px rgba(0,0,0,0.1);}
    th, td {padding:12px; text-align: left; border-bottom:1px solid #eee;}
    th {background:#f5f5f5;}
    .product-img {width:70px; border-radius:8px;}
    .qty-control {display:flex; align-items:center; gap:10px;}
    .qty-btn {padding:6px 10px; border:none; cursor:pointer; border-radius:6px; background:#eee;}
    .total-section {margin-top:20px; text-align:right; font-size:1.2rem;}
    .checkout-actions {margin-top:30px; text-align:right;}
    .btn {padding:12px 20px; border:none; border-radius:8px; cursor:pointer; font-size:1rem;}
    .btn-primary {background:#ff4081; color:#fff;}
    .btn-secondary {background:#333; color:#fff; margin-right:10px;}
    .empty {text-align:center; padding:50px; background:#fff; box-shadow: 0 2px 6px rgba(0,0,0,0.1);}
  </style>
</head>
<body>
<div class="container">
  <h1>Checkout</h1>
  
  <div id="checkoutTable"></div>

  <div class="checkout-actions">
    <a href="index.php"><button class="btn btn-secondary"><i class="fas fa-plus"></i> Add More Items</button></a>
    <button class="btn btn-primary" id="proceedBtn"><i class="fas fa-credit-card"></i> Proceed to Payment</button>
  </div>
</div>

<script>
  function renderCheckout() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let container = document.getElementById("checkoutTable");

    if(cart.length === 0) {
      container.innerHTML = `<div class="empty"><h2>No items in checkout</h2>
      <a href="index.php"><button class="btn btn-primary">Shop Now</button></a></div>`;
      return;
    }

    let html = `<table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Size</th>
          <th>Color</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>`;

    let total = 0;

    cart.forEach((item, index) => {
      let subtotal = item.price * item.qty;
      total += subtotal;

      html += `<tr>
        <td><img src="${item.image}" class="product-img"> ${item.name}</td>
        <td>${item.size || '-'}</td>
        <td>${item.color || '-'}</td>
        <td>₹${item.price}</td>
        <td>
          <div class="qty-control">
            <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
            <span>${item.qty}</span>
            <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
          </div>
        </td>
        <td>₹${subtotal}</td>
        <td><button class="qty-btn" onclick="removeItem(${index})"><i class="fas fa-trash"></i></button></td>
      </tr>`;
    });

    html += `</tbody></table>
      <div class="total-section"><strong>Total: ₹${total}</strong></div>`;
    
    container.innerHTML = html;
  }

  function updateQty(index, change) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if(cart[index]) {
      cart[index].qty += change;
      if(cart[index].qty < 1) cart[index].qty = 1;
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCheckout();
    }
  }

  function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCheckout();
  }

  document.getElementById("proceedBtn").addEventListener("click", function(){
    alert("Payment integration will be added here (Razorpay/Stripe/COD).");
    // Example: window.location.href = "payment.php";
  });

  renderCheckout();
</script>
</body>
</html>
