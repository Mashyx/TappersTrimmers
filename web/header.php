<?php
if (!isset($_SESSION)) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$loginHref = $isLoggedIn ? 'dashboard.php' : 'register.php';
$total_cart_items = 0;
if (isset($_SESSION['cart']) && isset($_SESSION['cart']["total_items"])) {
    $total_cart_items = $_SESSION['cart']["total_items"];
}
?>

<header>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/header.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="homepage.php">
      <img src="../assets/logodesign.png" alt="logo" class="logo me-2"/>
    <p class="title">Tappers & Trimmers</p> 
    </a>
     <ul class="nav-links navbar-nav ms-auto" id="navLinks">
            <li class="nav-item"><a class="nav-link" href="homepage.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">Over ons</a></li>
            <li class="nav-item"><a class="nav-link" href="bar.php">Bar</a></li>
            <li class="nav-item"><a class="nav-link" href="Shop.php">Shop</a></li>
            <li class="nav-item d-flex align-items-center">
                <a href="cart.php" class="nav-link p-0 me-2">
                    <button class="cart-btn" id="cartBtn">
                        <i class="bi bi-cart"></i>
                        <span id="cartCount"><?php echo $total_cart_items; ?></span>
                    </button>
                </a>
                <a href="<?php echo $loginHref; ?>" class="nav-link p-0 me-2">
                  <button class="login-btn" id="loginBtn" <?php if ($isLoggedIn) echo 'style="background:#bfa046;color:#111;border-color:#bfa046;"'; ?> >
                    <i class="bi bi-person-circle"></i>
                  </button>
                </a>
                <button class="reservation ms-2" onclick="location.href='reservation.php'">Reserveren</button>
            </li>
        </ul>
    </div>
  </div>
</nav>
</header>

