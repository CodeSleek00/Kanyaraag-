<?php
$order_id = $_GET['order_id'];
$razorpay_order_id = $_GET['razorpay_order_id'];
$amount = $_GET['amount'];
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<button id="rzp-button">Pay with Razorpay</button>
<script>
var options = {
    "key": "rzp_live_pA6jgjncp78sq7",
    "amount": "<?= $amount*100 ?>",
    "currency": "INR",
    "name": "Your Store",
    "description": "Order #<?= $order_id ?>",
    "order_id": "<?= $razorpay_order_id ?>",
    "handler": function (response){
        alert("Payment successful! Razorpay Payment ID: "+response.razorpay_payment_id);
        window.location.href = "payment_success.php?order_id=<?= $order_id ?>";
    },
    "theme": { "color": "#ff3f6c" }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
