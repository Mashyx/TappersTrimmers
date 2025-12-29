<?php
include("../PHP/db.php"); // Database verbinding
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php include("header.php"); ?>
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Checkout</h1>

    <?php
    // Verwerk formulier
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $user_id = 1; // hier kun je later echte user id uit session halen
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        // 1. Voeg order toe
        $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, email, address, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $user_id, $fullname, $email, $address);
        $stmt->execute();
        $order_id = $stmt->insert_id; // id van de net gemaakte order
        $stmt->close();

        // 2. Voeg orderlines toe
        foreach($_SESSION['cart'] as $key => $item) {
            if($key === 'total_items') continue;

            $stmt = $conn->prepare("INSERT INTO orderlines (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $key, $item['quantity'], $item['price']);
            $stmt->execute();
            $stmt->close();
        }

        // 3. Leeg de winkelwagen
        unset($_SESSION['cart']);

        echo '<div class="alert alert-success">Bedankt! Je bestelling is geplaatst.</div>';
        echo '<a href="shop.php" class="btn btn-primary">Ga terug naar shoppen</a>';
        exit;
    }
    ?>

    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
    <form method="post">
        <div class="mb-3">
            <label for="fullname" class="form-label">Volledige naam</label>
            <input type="text" name="fullname" class="form-control" id="fullname" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Adres</label>
            <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Bestelling plaatsen</button>
    </form>
    <?php else: ?>
        <p>Je winkelwagen is leeg.</p>
        <a href="shop.php" class="btn btn-primary">Ga terug naar shoppen</a>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
