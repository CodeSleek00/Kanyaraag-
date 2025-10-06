<?php
include '../database_connection/db_connect.php';

// Payment confirm action
if (isset($_GET['confirm_payment'])) {
    $order_id = intval($_GET['confirm_payment']);

    // Update payment_status
    $conn->query("UPDATE orders SET payment_status = 'Confirmed' WHERE id = $order_id");

    header("Location: manage_orders.php");
    exit;
}

// Fetch all orders
$orders = $conn->query("SELECT id, customer_name, total_amount, delivery_status, payment_status FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <style>
        body {font-family: Arial, sans-serif; margin: 20px;}
        table {width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td {padding: 10px; border: 1px solid #ddd; text-align: center;}
        th {background: #333; color: #fff;}
        a {padding: 5px 10px; border-radius: 5px; text-decoration: none;}
        .btn-confirm {background: green; color: white;}
        .btn-status {background: blue; color: white;}
    </style>
</head>
<body>
    <h1>Manage Orders</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Delivery Status</th>
            <th>Payment Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $orders->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['customer_name'] ?></td>
            <td>₹<?= $row['total_amount'] ?></td>
            <td><?= $row['delivery_status'] ?></td>
            <td><?= $row['payment_status'] ?></td>
            <td>
                <?php if ($row['payment_status'] !== 'Confirmed') { ?>
                    <a class="btn-confirm" href="?confirm_payment=<?= $row['id'] ?>">Confirm Payment</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
