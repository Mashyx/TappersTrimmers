<?php
session_start();
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    $_SESSION['cart']["total_items"] = 0;
}

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_picture = $_POST['product_picture']; // nieuwe regel
$quantity = (int)$_POST['quantity'];

// Voeg toe of verhoog het aantal
if(isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = array(
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => $quantity,
        'picture' => $product_picture
    );
}

$_SESSION['cart']["total_items"] += $quantity;   

header("Location: ../web/shop.php");
exit;
?>

