  function showImage(img) {
    document.getElementById("mainImg").src = img.src;
    
    // Update active thumbnail
    const thumbs = document.querySelectorAll('.gallery-thumb');
    thumbs.forEach(thumb => thumb.classList.remove('active'));
    img.parentElement.classList.add('active');
  }
  
// Add to Cart - using localStorage
document.querySelector('.add-cart').addEventListener('click', function() {
  // Get product details from PHP
  let product = {
    id: "<?php echo $product['id']; ?>",
    name: "<?php echo addslashes($product['product_name']); ?>",
    price: "<?php echo $product['discount_price']; ?>",
    image: "<?php echo $product['product_image']; ?>",
    qty: 1
  };

  // Get cart from localStorage or create new
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Check if product already in cart
  let existing = cart.find(p => p.id == product.id);
  if (existing) {
    existing.qty++;
  } else {
    cart.push(product);
  }

  // Save updated cart
  localStorage.setItem("cart", JSON.stringify(cart));

  // Show toast notification
  const toast = document.getElementById('addedToCart');
  toast.querySelector('span').innerText = product.name + " added to cart!";
  toast.classList.add('show');

  setTimeout(() => {
    toast.classList.remove('show');
  }, 3000);
});

  // Buy now functionality
  document.querySelector('.buy-now').addEventListener('click', function() {
    alert('Proceeding to checkout...');
    // In a real application, this would redirect to checkout page
  });