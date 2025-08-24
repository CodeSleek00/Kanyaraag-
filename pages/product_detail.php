<?php
include '../db/db_connect.php';

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id=$id";
$result = $conn->query($sql);
if($result->num_rows == 0){
    echo "Product not found!";
    exit;
}
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $product['product_name'] ?></title>
<style>
body { font-family: Arial; background:#fafafa; padding:20px; }
.container { display:flex; gap:20px; }
.container img { max-width:400px; border-radius:10px; }
.details { max-width:500px; }
.price { font-weight:bold; margin:10px 0; font-size:20px; }
.old { text-decoration:line-through; color:red; margin-right:5px; }
.discount { color:green; }
button { padding:10px 15px; background:#ff3f6c; color:#fff; border:none; cursor:pointer; border-radius:5px; }
button:hover { background:#e91e63; }
</style>
</head>
<body>

<div class="container">
    <img src="<?= $product['product_image'] ?>" alt="<?= $product['product_name'] ?>">
    <div class="details">
        <h2><?= $product['product_name'] ?></h2>
        <p><?= $product['description'] ?></p>
        <p class="price">
            <span class="old">₹<?= $product['original_price'] ?></span> 
            ₹<?= $product['discount_price'] ?> 
            <span class="discount">(<?= round($product['discount_percent']) ?>% OFF)</span>
        </p>
        <p>Stock: <?= $product['stock'] ?></p>
        <button id="add-to-cart" <?= ($product['stock']<=0?"disabled":"") ?>>
            <?= ($product['stock']>0?"Add to Cart":"Out of Stock") ?>
        </button>
        <a href="checkout.php?id=<?= $product['id'] ?>"><button>Buy Now</button></a>
    </div>
</div>

<script>
let btn = document.getElementById("add-to-cart");
btn?.addEventListener("click", () => {
    let product = {
        id: "<?= $product['id'] ?>",
        name: "<?= $product['product_name'] ?>",
        price: "<?= $product['discount_price'] ?>",
        image: "<?= $product['product_image'] ?>",
        qty: 1
    };
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let exist = cart.find(p=>p.id==product.id);
    if(exist){ exist.qty++; } else { cart.push(product); }
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(product.name+" added to cart!");
});
</script>
</body>
</html>
