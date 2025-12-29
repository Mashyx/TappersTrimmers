<?php
session_start();

$product_id = $_POST['product_id'];

if(isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart']['total_items'] -= $_SESSION['cart'][$product_id]['quantity'];
    unset($_SESSION['cart'][$product_id]);
}

header("Location: ../web/cart.php");
exit;
?>
