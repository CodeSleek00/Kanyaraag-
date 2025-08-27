  function showImage(img) {
    document.getElementById("mainImg").src = img.src;
    
    // Update active thumbnail
    const thumbs = document.querySelectorAll('.gallery-thumb');
    thumbs.forEach(thumb => thumb.classList.remove('active'));
    img.parentElement.classList.add('active');
  }
  // product-detail.js

// Add to Cart - using localStorage
document.addEventListener("DOMContentLoaded", function() {
  const addCartBtn = document.querySelector('.add-cart');
  const buyNowBtn = document.querySelector('.buy-now');
  
  addCartBtn.addEventListener('click', function() {
    // Get product details from data attributes
    let product = {
      id: addCartBtn.getAttribute("data-id"),
      name: addCartBtn.getAttribute("data-name"),
      price: addCartBtn.getAttribute("data-price"),
      image: addCartBtn.getAttribute("data-image"),
      qty: 1
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let existing = cart.find(p => p.id == product.id);
    if (existing) {
      existing.qty++;
    } else {
      cart.push(product);
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    // Show toast notification
    const toast = document.getElementById('addedToCart');
    toast.querySelector('span').innerText = product.name + " added to cart!";
    toast.classList.add('show');

    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  });

  // Buy Now - add to cart and redirect
  buyNowBtn.addEventListener('click', function() {
    addCartBtn.click(); // Add product to cart
    window.location.href = "cart.php"; // Redirect to cart
  });
});
