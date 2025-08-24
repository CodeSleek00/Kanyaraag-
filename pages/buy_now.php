<?php
session_start();
include("db.php"); // database connection

// Example product details (fetch dynamically in real case)
$product = [
    "id" => 1,
    "name" => "Premium T-shirt",
    "price" => 499,
    "image" => "uploads/tshirt.jpg"
];

$shipping = 0;
$total = $product["price"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buy Now - <?php echo $product["name"]; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <header class="bg-white shadow p-4">
    <h1 class="text-2xl font-bold text-center">Buy Now</h1>
  </header>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 px-4">
    <!-- Left Section -->
    <div class="bg-white p-6 shadow rounded-lg">
      <h2 class="text-xl font-bold mb-4">Shipping Details</h2>
      <form id="buyForm" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
        <input type="hidden" name="subtotal" value="<?php echo $product['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">

        <div class="mb-3">
          <label class="block">Name</label>
          <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
          <label class="block">Address</label>
          <textarea name="address" class="w-full border p-2 rounded" required></textarea>
        </div>
        <div class="mb-3 grid grid-cols-2 gap-2">
          <div>
            <label class="block">City</label>
            <input type="text" name="city" class="w-full border p-2 rounded" required>
          </div>
          <div>
            <label class="block">State</label>
            <input type="text" name="state" class="w-full border p-2 rounded" required>
          </div>
        </div>
        <div class="mb-3 grid grid-cols-2 gap-2">
          <div>
            <label class="block">Pincode</label>
            <input type="text" name="pincode" class="w-full border p-2 rounded" required>
          </div>
          <div>
            <label class="block">Phone</label>
            <input type="text" name="phone" class="w-full border p-2 rounded" required>
          </div>
        </div>

        <!-- Payment Method -->
        <div class="mb-3">
          <label class="block font-semibold">Payment Method</label>
          <label class="inline-flex items-center">
            <input type="radio" name="payment_method" value="razorpay" required> <span class="ml-2">Razorpay</span>
          </label><br>
          <label class="inline-flex items-center">
            <input type="radio" name="payment_method" value="cod"> <span class="ml-2">Cash on Delivery (₹49 extra)</span>
          </label>
        </div>

        <button type="submit" class="bg-black text-white px-4 py-2 rounded w-full">Buy Now</button>
      </form>

      <!-- Policies -->
      <div class="mt-6 text-sm text-gray-600 space-y-2">
        <a href="#">Refund Policy</a><br>
        <a href="#">Shipping Policy</a><br>
        <a href="#">Privacy Policy</a><br>
        <a href="#">Terms of Services</a>
      </div>
    </div>

    <!-- Right Section -->
    <div class="bg-white p-6 shadow rounded-lg">
      <h2 class="text-xl font-bold mb-4">Order Details</h2>
      <div class="flex items-center mb-4">
        <img src="<?php echo $product['image']; ?>" alt="product" class="w-20 h-20 rounded mr-4">
        <div>
          <h3 class="font-semibold"><?php echo $product['name']; ?></h3>
          <p>Subtotal: ₹<?php echo $product['price']; ?></p>
        </div>
      </div>
      <div id="orderSummary" class="text-lg font-semibold">
        Total: ₹<?php echo $product['price']; ?>
      </div>
    </div>
  </div>

  <script>
  document.querySelectorAll("input[name='payment_method']").forEach(radio => {
    radio.addEventListener("change", function(){
      let subtotal = <?php echo $product['price']; ?>;
      let shipping = this.value === "cod" ? 49 : 0;
      let total = subtotal + shipping;
      document.getElementById("orderSummary").innerHTML = "Total: ₹" + total;
    });
  });

  document.getElementById("buyForm").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    let paymentMethod = formData.get("payment_method");

    if(paymentMethod === "razorpay"){
      fetch("razorpay_order.php", { method: "POST", body: formData })
      .then(res => res.json())
      .then(data => {
        var options = {
          "key": "rzp_live_pA6jgjncp78sq7",
          "amount": data.amount,
          "currency": "INR",
          "name": "Pyaara Store",
          "description": data.product_name,
          "order_id": data.razorpay_order_id,
          "handler": function (response){
            fetch("razorpay_verify.php", {
              method: "POST",
              headers: {"Content-Type": "application/json"},
              body: JSON.stringify(response)
            }).then(res => res.text()).then(msg => alert(msg));
          }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
      });
    } else {
      fetch("cod_order.php", { method: "POST", body: formData })
      .then(res => res.text())
      .then(msg => alert(msg));
    }
  });
  </script>
</body>
</html>
