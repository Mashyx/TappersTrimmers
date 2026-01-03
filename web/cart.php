<?php
include("../PHP/db.php");
include("header.php");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <link rel="stylesheet" href="../css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1>Je Winkelwagen</h1>

    <?php if(!empty($_SESSION['cart'])): ?>
        <div class="row g-4">
        <?php
        $total = 0;

        foreach($_SESSION['cart'] as $key => $item) {
            if($key === 'total_items') continue;

            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
            <div class="col-12">
                <div class="cart-card">
                    <div class="d-flex align-items-center gap-3">
                        <img src="../assets/<?php echo $item['picture'] ?? 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p>Prijs: €<?php echo number_format($item['price'], 2); ?></p>
                            <p>Subtotaal: €<?php echo number_format($subtotal, 2); ?></p>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-2">
                        <form method="post" action="../php/update_cart.php" class="d-flex mb-2">
                            <input type="hidden" name="product_id" value="<?php echo $key; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control me-2" style="width:80px;">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>

                        <form method="post" action="../php/remove_from_cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $key; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>

        <div class="cart-total">
            <h4>Totaal: €<?php echo number_format($total, 2); ?></h4>
            <a href="checkout.php" class="btn btn-success mt-3 w-100">Afrekenen</a>
        </div>

    <?php else: ?>
        <p class="text-center">Je winkelwagen is leeg.</p>
        <a href="../web/shop.php" class="btn btn-primary d-block mx-auto mt-3" style="width:200px;">Ga terug naar shoppen</a>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
