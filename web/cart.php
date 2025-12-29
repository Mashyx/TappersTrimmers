<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <?php include("header.php"); ?>
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Je Winkelwagen</h1>

    <?php if(!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                    <th>Subtotaal</th>
                    <th>Actie</th>
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
                        <td>€<?php echo number_format($item['price'],2); ?></td>
                        <td>
                            <form method="post" action="../php/update_cart.php" class="d-flex">
                                <input type="hidden" name="product_id" value="<?php echo $key; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control me-2" style="width:80px;">
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </td>
                        <td>€<?php echo number_format($subtotal,2); ?></td>
                        <td>
                            <form method="post" action="../php/remove_from_cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $key; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="3" class="text-end fw-bold">Totaal:</td>
                    <td colspan="2" class="fw-bold">€<?php echo number_format($total,2); ?></td>
                </tr>
            </tbody>
        </table>

        <a href="checkout.php" class="btn btn-success">Afrekenen</a>

    <?php else: ?>
        <p>Je winkelwagen is leeg.</p>
        <a href="../web/shop.php" class="btn btn-primary">Ga terug naar shoppen</a>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
