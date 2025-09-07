<?php
// checkout.php
include '../db/db_connect.php';
session_start();

// You can optionally get logged-in user info from session and prefill the form.

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Checkout - कन्याRaag</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --accent: #ff4081;
      --muted: #6b7280;
      --card-bg: #fff;
      --radius: 10px;
      --max-width: 1100px;
    }
    * {box-sizing: border-box;}
    body {font-family: 'Outfit', system-ui, Arial; margin:0; background:#f3f4f6; color:#111827;}
    .wrap {max-width: var(--max-width); margin:36px auto; padding:20px;}
    .grid {display:grid; grid-template-columns: 1fr 420px; gap:18px;}
    @media (max-width:900px) {
      .grid {grid-template-columns: 1fr;}
    }

    /* left form */
    .card {background:var(--card-bg); border-radius:var(--radius); padding:20px; box-shadow:0 6px 18px rgba(15,23,42,0.06);}
    h1 {margin:0 0 14px; font-size:1.6rem;}
    .section-title {font-weight:600; color:var(--muted); margin-bottom:8px;}
    .form-grid {display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;}
    .form-row {margin-bottom:12px;}
    label {display:block; font-size:0.9rem; margin-bottom:6px; color:#374151;}
    input[type="text"], input[type="tel"], input[type="number"], select {
      width:100%; padding:10px 12px; border-radius:8px; border:1px solid #e5e7eb; font-size:0.95rem;
    }

    /* payment */
    .payment-options {display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;}
    .payment-card {flex:1; min-width:140px; border:1px solid #e6e7eb; padding:12px; border-radius:8px; cursor:pointer; display:flex; align-items:center; gap:8px;}
    .payment-card.selected {border-color:var(--accent); box-shadow:0 6px 16px rgba(255,64,129,0.08);}
    .pay-logo {font-size:22px; width:44px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; background:#f9fafb;}

    /* right order summary */
    .summary {position:sticky; top:20px;}
    .items-list {max-height:420px; overflow:auto; margin-bottom:12px;}
    .item {display:flex; gap:10px; align-items:center; padding:10px; border-bottom:1px dashed #eee;}
    .item img {width:64px; height:64px; object-fit:cover; border-radius:8px;}
    .item .meta {flex:1;}
    .totals {padding:12px 0; border-top:1px solid #eee; display:flex; flex-direction:column; gap:8px; font-weight:600;}
    .btn {display:inline-flex; align-items:center; gap:8px; padding:12px 16px; border-radius:10px; border:none; cursor:pointer; font-weight:600;}
    .btn-primary {background:var(--accent); color:#fff; box-shadow:0 8px 28px rgba(255,64,129,0.12);}
    .btn-secondary {background:#111827; color:#fff;}
    .muted {color:var(--muted); font-size:0.95rem;}
    .empty {text-align:center; padding:36px; color:var(--muted);}
    .small {font-size:0.9rem;}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="grid">
      <!-- LEFT: form -->
      <div class="card">
        <h1>Shipping details</h1>
        <p class="muted small">Fill shipping address and choose payment method.</p>

        <form id="checkoutForm">
          <div class="form-grid">
            <div class="form-row">
              <label for="first">First name</label>
              <input id="first" name="first" type="text" required />
            </div>
            <div class="form-row">
              <label for="last">Last name</label>
              <input id="last" name="last" type="text" required />
            </div>
          </div>

          <div class="form-grid">
            <div class="form-row">
              <label for="contact">Contact number</label>
              <input id="contact" name="contact" type="tel" required />
            </div>
            <div class="form-row">
              <label for="apartment">Apartment / House no.</label>
              <input id="apartment" name="apartment" type="text" />
            </div>
          </div>

          <div class="form-grid">
            <div class="form-row">
              <label for="city">City</label>
              <input id="city" name="city" type="text" required />
            </div>
            <div class="form-row">
              <label for="state">State</label>
              <select id="state" name="state" required>
                <option value="">Select state</option>
                <option>Andhra Pradesh</option>
                <option>Arunachal Pradesh</option>
                <option>Assam</option>
                <option>Bihar</option>
                <option>Chhattisgarh</option>
                <option>Goa</option>
                <option>Gujarat</option>
                <option>Haryana</option>
                <option>Himachal Pradesh</option>
                <option>Jharkhand</option>
                <option>Karnataka</option>
                <option>Kerala</option>
                <option>Madhya Pradesh</option>
                <option>Maharashtra</option>
                <option>Manipur</option>
                <option>Meghalaya</option>
                <option>Mizoram</option>
                <option>Nagaland</option>
                <option>Odisha</option>
                <option>Punjab</option>
                <option>Rajasthan</option>
                <option>Sikkim</option>
                <option>Tamil Nadu</option>
                <option>Telangana</option>
                <option>Tripura</option>
                <option>Uttar Pradesh</option>
                <option>Uttarakhand</option>
                <option>West Bengal</option>
                <option>Other</option>
              </select>
            </div>
          </div>

          <div class="form-grid">
            <div class="form-row">
              <label for="pincode">Pincode</label>
              <input id="pincode" name="pincode" type="text" required />
            </div>
            <div class="form-row">
              <label>&nbsp;</label>
              <div class="muted small">Save address for faster checkout next time.</div>
            </div>
          </div>

          <hr style="margin:14px 0; border:none; border-top:1px solid #eee;" />

          <div>
            <div class="section-title">Payment method</div>
            <div class="payment-options" id="paymentOptions">
              <div class="payment-card selected" data-method="RAZORPAY" id="pay-razor">
                <div class="pay-logo"><i class="fas fa-bolt"></i></div>
                <div>
                  <div style="font-weight:700">Razorpay</div>
                  <div class="muted small">Pay using card, UPI & wallets</div>
                </div>
              </div>

              <div class="payment-card" data-method="COD" id="pay-cod">
                <div class="pay-logo"><i class="fas fa-truck"></i></div>
                <div>
                  <div style="font-weight:700">Cash on Delivery</div>
                  <div class="muted small">Pay when delivered</div>
                </div>
              </div>
            </div>
          </div>

          <input type="hidden" id="payment_method" name="payment_method" value="RAZORPAY" />
          <input type="hidden" id="cart_payload" name="cart_payload" value="" />

          <div style="margin-top:16px; display:flex; gap:8px;">
            <button type="button" id="placeOrderBtn" class="btn btn-primary">Buy Now</button>
            <a href="index.php" class="btn btn-secondary" style="text-decoration:none; color:#fff;">Continue shopping</a>
          </div>
        </form>
      </div>

      <!-- RIGHT: order summary -->
      <div class="card summary">
        <div style="margin:12px 0;">
  <label for="coupon">Coupon Code</label>
  <div style="display:flex; gap:8px; margin-top:6px;">
    <input type="text" id="couponCode" placeholder="Enter coupon" style="flex:1; padding:10px; border-radius:8px; border:1px solid #ddd;">
    <button type="button" class="btn btn-secondary" id="applyCouponBtn">Apply</button>
  </div>
  <div id="couponMessage" class="muted small" style="margin-top:6px;"></div>
</div>

        <h2 style="margin-top:0">Order summary</h2>

        <div class="items-list" id="itemsList">
          <!-- items inserted by JS -->
        </div>

        <div class="totals" id="totals">
          <div style="display:flex; justify-content:space-between;"><span class="muted">Subtotal</span><span id="subtotalAmt">₹0</span></div>
          <div style="display:flex; justify-content:space-between;"><span class="muted">Shipping</span><span id="shippingAmt">₹0</span></div>
          <div style="display:flex; justify-content:space-between; font-size:1.1rem;"><span>Total</span><span id="totalAmt">₹0</span></div>
        </div>

        <div style="margin-top:12px;">
          <div class="muted small">Payment methods: Razorpay, UPI, Cards, COD.</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Razorpay script will be loaded only when needed -->
  <script>
    // load cart from localStorage (same structure you use)
    function getCart() {
      try {
        return JSON.parse(localStorage.getItem('cart')) || [];
      } catch(e) {
        return [];
      }
    }

    function renderOrderSummary() {
      const cart = getCart();
      const list = document.getElementById('itemsList');
      const subtotalEl = document.getElementById('subtotalAmt');
      const totalEl = document.getElementById('totalAmt');
      const shippingEl = document.getElementById('shippingAmt');

      if(!cart.length) {
        list.innerHTML = '<div class="empty">Your cart is empty. <a href="index.php">Shop now</a></div>';
        subtotalEl.textContent = '₹0';
        shippingEl.textContent = '₹0';
        totalEl.textContent = '₹0';
        document.getElementById('cart_payload').value = '';
        return;
      }

      let html = '';
      let subtotal = 0;
      cart.forEach(item => {
        const price = parseFloat(item.price) || 0;
        const qty = parseInt(item.qty) || 1;
        const itemSubtotal = price * qty;
        subtotal += itemSubtotal;
        html += `<div class="item">
                  <img src="${item.image}" alt="${item.name}" />
                  <div class="meta">
                    <div style="font-weight:700">${item.name}</div>
                    <div class="muted small">${item.size || ''} ${item.color ? ' • ' + item.color : ''}</div>
                  </div>
                  <div style="text-align:right;">
                    <div>₹${price.toFixed(2)}</div>
                    <div class="muted small">x ${qty}</div>
                  </div>
                </div>`;
      });

      list.innerHTML = html;
      // example shipping rules (you can change)
      const shipping = subtotal > 999 ? 0 : 49; // free above 999
      const total = subtotal + shipping;

      subtotalEl.textContent = '₹' + subtotal.toFixed(2);
      shippingEl.textContent = shipping === 0 ? 'Free' : '₹' + shipping.toFixed(2);
      totalEl.textContent = '₹' + total.toFixed(2);

      document.getElementById('cart_payload').value = JSON.stringify({
        cart, subtotal: subtotal.toFixed(2), shipping: shipping.toFixed(2), total: total.toFixed(2)
      });
    }

    renderOrderSummary();

    // Payment selection
    document.querySelectorAll('.payment-card').forEach(card => {
      card.addEventListener('click', function(){
        document.querySelectorAll('.payment-card').forEach(c=>c.classList.remove('selected'));
        this.classList.add('selected');
        const method = this.getAttribute('data-method');
        document.getElementById('payment_method').value = method;
      });
    });

    // Place order click handler
    document.getElementById('placeOrderBtn').addEventListener('click', function(){
      const cartPayload = document.getElementById('cart_payload').value;
      if(!cartPayload) {
        alert('Your cart is empty.');
        return;
      }

      const form = document.getElementById('checkoutForm');
      const formData = new FormData(form);

      // basic validation
      if(!formData.get('first') || !formData.get('contact') || !formData.get('city') || !formData.get('state') || !formData.get('pincode')) {
        alert('Please fill required fields.');
        return;
      }

      const paymentMethod = formData.get('payment_method');

      if(paymentMethod === 'COD') {
        // send to create_order.php for COD
        fetch('create_order.php', {
          method:'POST',
          body: formData
        }).then(r=>r.json()).then(resp=>{
          if(resp.success) {
            // clear cart and show confirmation
            localStorage.removeItem('cart');
            window.location.href = 'order_success.php?order_id=' + encodeURIComponent(resp.order_id);
          } else {
            alert('Error: ' + (resp.message || 'Could not place order.'));
          }
        }).catch(err=>{
          console.error(err);
          alert('Network error. Try again.');
        });
        return;
      }

      if(paymentMethod === 'RAZORPAY') {
        // create a razorpay order server-side
        fetch('create_razorpay_order.php', {
          method:'POST',
          body: formData
        }).then(r=>r.json()).then(data=>{
          if(data && data.success) {
            // load Razorpay script and open checkout
            loadRazorpayAndOpen(data);
          } else {
            alert('Could not initiate payment: ' + (data.message || 'server error'));
          }
        }).catch(err=>{
          console.error(err);
          alert('Network error. Try again.');
        });
      }
    });

    // Load Razorpay script dynamically
    function loadRazorpayAndOpen(orderData) {
      if(typeof Razorpay === 'undefined') {
        const s = document.createElement('script');
        s.src = 'https://checkout.razorpay.com/v1/checkout.js';
        s.onload = function() { openRazorpay(orderData); };
        s.onerror = function(){ alert('Failed to load Razorpay.'); };
        document.head.appendChild(s);
      } else {
        openRazorpay(orderData);
      }
    }

    function openRazorpay(orderData) {
      // orderData must contain: razorpay_order_id, amount (in paise), currency, key
      const cartPayload = JSON.parse(document.getElementById('cart_payload').value);
      const options = {
        key: orderData.key, // RAZORPAY KEY
        amount: orderData.amount,
        currency: orderData.currency || 'INR',
        name: 'कन्याRaag',
        description: 'Order #' + orderData.our_order_id,
        order_id: orderData.razorpay_order_id,
        handler: function (response) {
          // Send response to server to verify and save
          const payload = new FormData();
          payload.append('razorpay_payment_id', response.razorpay_payment_id);
          payload.append('razorpay_order_id', response.razorpay_order_id);
          payload.append('razorpay_signature', response.razorpay_signature);
          payload.append('our_order_id', orderData.our_order_id);
          // also send form fields so server can map
          const form = document.getElementById('checkoutForm');
          const formData = new FormData(form);
          for (const pair of formData.entries()) {
            payload.append(pair[0], pair[1]);
          }

          fetch('verify_payment.php', { method:'POST', body: payload })
            .then(r=>r.json()).then(res=>{
              if(res.success) {
                localStorage.removeItem('cart');
                window.location.href = 'order_success.php?order_id=' + encodeURIComponent(res.order_id);
              } else {
                alert('Payment verification failed: ' + (res.message || 'Unable to verify'));
              }
            }).catch(err=>{
              console.error(err);
              alert('Network error while verifying payment.');
            });
        },
        prefill: {
          name: document.getElementById('first').value + ' ' + document.getElementById('last').value,
          contact: document.getElementById('contact').value
        },
        theme: {color: getComputedStyle(document.documentElement).getPropertyValue('--accent') || '#ff4081'}
      };
      const rzp = new Razorpay(options);
      rzp.open();
    }
    let appliedCoupon = null;
let discountValue = 0;

function renderOrderSummary() {
  const cart = getCart();
  const list = document.getElementById('itemsList');
  const subtotalEl = document.getElementById('subtotalAmt');
  const totalEl = document.getElementById('totalAmt');
  const shippingEl = document.getElementById('shippingAmt');

  if(!cart.length) {
    list.innerHTML = '<div class="empty">Your cart is empty. <a href="index.php">Shop now</a></div>';
    subtotalEl.textContent = '₹0';
    shippingEl.textContent = '₹0';
    totalEl.textContent = '₹0';
    document.getElementById('cart_payload').value = '';
    return;
  }

  let html = '';
  let subtotal = 0;
  cart.forEach(item => {
    const price = parseFloat(item.price) || 0;
    const qty = parseInt(item.qty) || 1;
    const itemSubtotal = price * qty;
    subtotal += itemSubtotal;
    html += `<div class="item">
              <img src="${item.image}" alt="${item.name}" />
              <div class="meta">
                <div style="font-weight:700">${item.name}</div>
                <div class="muted small">${item.size || ''} ${item.color ? ' • ' + item.color : ''}</div>
              </div>
              <div style="text-align:right;">
                <div>₹${price.toFixed(2)}</div>
                <div class="muted small">x ${qty}</div>
              </div>
            </div>`;
  });

  list.innerHTML = html;

  // delivery charge based on payment method
  const paymentMethod = document.getElementById('payment_method').value;
  let shipping = (paymentMethod === "COD") ? 49 : 0;

  // discount if coupon applied
  discountValue = appliedCoupon ? (subtotal * appliedCoupon.discount_percent / 100) : 0;

  const total = subtotal + shipping - discountValue;

  subtotalEl.textContent = '₹' + subtotal.toFixed(2);
  shippingEl.textContent = shipping === 0 ? 'Free' : '₹' + shipping.toFixed(2);
  if(discountValue > 0) {
    document.getElementById('couponMessage').innerHTML = 
      `Coupon <b>${appliedCoupon.code}</b> applied! -₹${discountValue.toFixed(2)}`;
  }
  totalEl.textContent = '₹' + total.toFixed(2);

  document.getElementById('cart_payload').value = JSON.stringify({
    cart, subtotal: subtotal.toFixed(2), shipping: shipping.toFixed(2),
    discount: discountValue.toFixed(2), total: total.toFixed(2),
    coupon: appliedCoupon ? appliedCoupon.code : null
  });
}

// re-render when payment method changes
document.querySelectorAll('.payment-card').forEach(card=>{
  card.addEventListener('click', ()=>renderOrderSummary());
});

// coupon apply
document.getElementById('applyCouponBtn').addEventListener('click', ()=>{
  const code = document.getElementById('couponCode').value.trim();
  if(!code) return;

  fetch('apply_coupon.php', {
    method:'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: 'code='+encodeURIComponent(code)
  }).then(r=>r.json()).then(res=>{
    if(res.success) {
      appliedCoupon = res.coupon;
      confettiEffect(); // 🎉
      renderOrderSummary();
    } else {
      document.getElementById('couponMessage').textContent = res.message;
      appliedCoupon = null;
      renderOrderSummary();
    }
  });
});

// confetti 🎉
function confettiEffect() {
  var duration = 2 * 1000;
  var end = Date.now() + duration;

  (function frame() {
    confetti({
      particleCount: 5,
      angle: 60,
      spread: 55,
      origin: { x: 0 }
    });
    confetti({
      particleCount: 5,
      angle: 120,
      spread: 55,
      origin: { x: 1 }
    });

    if (Date.now() < end) {
      requestAnimationFrame(frame);
    }
  }());
}

// load confetti library
(function(){
  const s=document.createElement('script');
  s.src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js";
  document.head.appendChild(s);
})();

  </script>
</body>
</html>
