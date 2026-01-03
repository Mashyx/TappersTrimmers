<?php
include("../PHP/db.php"); // database verbinding
session_start();

// Standaard waarden
$email = $firstname = $lastname = "";
$user_id = null;
$orderPlaced = false;
$coupon_error = "";
$coupon = null;
$coupon_id = null;
$discount = 0;

// Haal ingelogde gebruiker op
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT email, first_name, last_name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $email = $user['email'];
        $firstname = $user['first_name'];
        $lastname = $user['last_name'];
    }
    $stmt->close();
}

// Bereken totaalprijs
$total_price = 0;
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $key => $item) {
        if($key === 'total_items') continue;
        $total_price += $item['price'] * $item['quantity'];
    }
}

$discounted_total = $total_price;

// Verwerk formulier
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $housenumber = $_POST['housenumber'];
    $zipcode = $_POST['zipcode'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];
    $coupon_code = isset($_POST['coupon_code']) ? trim($_POST['coupon_code']) : "";

    // Couponcode toepassen
    if(isset($_POST['apply_coupon']) && !empty($coupon_code)) {
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ? AND is_active = 1 LIMIT 1");
        $stmt->bind_param("s", $coupon_code);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $coupon = $result->fetch_assoc();
            $coupon_id = $coupon['coupon_id'];
            $discount = ($total_price * $coupon['discount_percentage']) / 100;
            $discounted_total = max(0, $total_price - $discount);
        } else {
            $coupon_error = "Ongeldige of niet-actieve couponcode.";
            $discounted_total = $total_price;
        }
        $stmt->close();
    }

    // Bestelling plaatsen
    if(isset($_POST['submit_order'])) {

        $stmt = $conn->prepare("INSERT INTO orders (user_id, email, firstname, lastname, address, housenumber, zipcode, city, phone, payment_method, total_price, discount_amount, coupon_id, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'In behandeling', NOW())");
        if(!$stmt) { die("Prepare mislukt: " . $conn->error); }
        $stmt->bind_param("isssssssssdii", $user_id, $email, $firstname, $lastname, $address, $housenumber, $zipcode, $city, $phone, $payment_method, $discounted_total, $discount, $coupon_id);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Voeg orderlines toe
        foreach($_SESSION['cart'] as $key => $item) {
            if($key === 'total_items') continue;
            $stmt = $conn->prepare("INSERT INTO orderlines (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            if(!$stmt) { die("Prepare mislukt: " . $conn->error); }
            $stmt->bind_param("iiid", $order_id, $key, $item['quantity'], $item['price']);
            $stmt->execute();
            $stmt->close();
        }

        // Leeg winkelwagen
        unset($_SESSION['cart']);
        $orderPlaced = true;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/checkout.css">
<?php include("header.php"); ?>
</head>
<body>

<div class="container my-5 checkout-container">
<h1 class="mb-4">Checkout</h1>

<?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>

<!-- Winkelwagen overzicht -->
<div class="mb-4">
    <h4>Je bestelling</h4>
    <table class="table table-bordered align-middle checkout-table">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Prijs</th>
                <th>Aantal</th>
                <th>Subtotaal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        foreach($_SESSION['cart'] as $key => $item) {
            if($key === 'total_items') continue;
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>€<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>€<?php echo number_format($subtotal, 2); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" class="text-end fw-bold">Totaal:</td>
            <td class="fw-bold">€<?php echo number_format($total, 2); ?></td>
        </tr>
        <?php if($discount > 0): ?>
        <tr>
            <td colspan="3" class="text-end fw-bold">Korting (<?php echo $coupon['code']; ?>):</td>
            <td class="fw-bold">-€<?php echo number_format($discount, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="text-end fw-bold">Totaal na korting:</td>
            <td class="fw-bold">€<?php echo number_format($discounted_total, 2); ?></td>
        </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Checkout formulier -->
<form method="post">

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="firstname" class="form-label">Voornaam</label>
            <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="lastname" class="form-label">Achternaam</label>
            <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>

    <div class="row mb-3">
        <div class="col-md-8">
            <label for="address" class="form-label">Adres</label>
            <input type="text" name="address" class="form-control" id="address" required>
        </div>
        <div class="col-md-4">
            <label for="housenumber" class="form-label">Huisnummer</label>
            <input type="text" name="housenumber" class="form-control" id="housenumber" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="zipcode" class="form-label">Postcode</label>
            <input type="text" name="zipcode" class="form-control" id="zipcode" required>
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label">Plaatsnaam</label>
            <input type="text" name="city" class="form-control" id="city" required>
        </div>
        <div class="col-md-4">
            <label for="phone" class="form-label">Telefoonnummer</label>
            <input type="text" name="phone" class="form-control" id="phone" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label">Betaalmethode</label>
        <select name="payment_method" class="form-select" id="payment_method" required>
            <option value="" disabled selected>-- Kies een optie --</option>
            <option value="creditcard">Creditcard</option>
            <option value="paypal">PayPal</option>
            <option value="ideal">iDEAL</option>
        </select>
    </div>

    <!-- Coupon -->
    <div class="mb-3 coupon-group">
        <input type="text" name="coupon_code" class="form-control" placeholder="Couponcode" value="<?php echo isset($_POST['coupon_code']) ? htmlspecialchars($_POST['coupon_code']) : ''; ?>">
        <button type="submit" name="apply_coupon" class="btn btn-warning">Gebruik coupon</button>
    </div>

    <?php if(!empty($coupon_error)): ?>
    <div class="alert alert-danger"><?php echo $coupon_error; ?></div>
    <?php endif; ?>

    <button type="submit" name="submit_order" class="btn btn-gold mt-3">Bestelling plaatsen</button>
</form>

<?php else: ?>
<p class="empty-cart">Je winkelwagen is leeg.</p>
<a href="shop.php" class="btn btn-primary">Ga terug naar shoppen</a>
<?php endif; ?>

</div>

<!-- Bestelling Bevestiging Modal -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderSuccessModalLabel">Bestelling geplaatst!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten"></button>
      </div>
      <div class="modal-body">
        Bedankt voor je bestelling! Je ontvangt een e-mail ter bevestiging.
      </div>
      <div class="modal-footer">
        <a href="shop.php" class="btn btn-primary">Terug naar shoppen</a>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php if($orderPlaced): ?>
<script>
  var orderModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
  orderModal.show();
</script>
<?php endif; ?>

</body>
</html>