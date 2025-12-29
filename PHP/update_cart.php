<?php
session_start();

$product_id = $_POST['product_id'];
$quantity = (int)$_POST['quantity'];

if(isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart']['total_items'] -= $_SESSION['cart'][$product_id]['quantity'];
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    $_SESSION['cart']['total_items'] += $quantity;
}

header("Location: ../web/cart.php");
exit;
?>
