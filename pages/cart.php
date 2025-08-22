<!DOCTYPE html>
<html>
<head>
  <title>Your Cart</title>
  <style>
    .cart-container { max-width: 800px; margin: auto; }
    .cart-item { display: flex; align-items: center; margin-bottom: 15px; border:1px solid #ddd; padding:10px; }
    .cart-item img { width: 80px; height: 80px; margin-right: 15px; }
    .cart-item h3 { margin: 0; font-size: 16px; }
    .qty { margin: 0 10px; }
  </style>
</head>
<body>
  <h2>Your Cart</h2>
  <div class="cart-container" id="cart-container"></div>
  <h3 id="total"></h3>

  <script>
    function loadCart() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let container = document.getElementById("cart-container");
      container.innerHTML = "";

      let total = 0;

      if (cart.length === 0) {
        container.innerHTML = "<p>Your cart is empty!</p>";
        document.getElementById("total").innerText = "";
        return;
      }

      cart.forEach((item, index) => {
        total += item.price * item.qty;

        container.innerHTML += `
          <div class="cart-item">
            <img src="${item.image}" alt="${item.name}">
            <div>
              <h3>${item.name}</h3>
              <p>₹${item.price} x 
                <button onclick="updateQty(${index}, -1)">-</button>
                <span class="qty">${item.qty}</span>
                <button onclick="updateQty(${index}, 1)">+</button>
              = ₹${item.price * item.qty}</p>
              <button onclick="removeItem(${index})">Remove</button>
            </div>
          </div>
        `;
      });

      document.getElementById("total").innerText = "Total: ₹" + total;
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

    loadCart();
  </script>
</body>
</html>
