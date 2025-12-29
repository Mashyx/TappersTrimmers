<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <?php include("header.php"); ?>
</head>
<body>

<?php
// Database verbinding includen
include("../PHP/db.php");
?>

<div class="container my-5">
    <div class="row">
        <?php
        // Haal alle producten op
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="../assets/<?php echo $row['picture']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text fw-bold">€<?php echo number_format($row['price'], 2); ?></p>

                            <!-- Winkelwagen formulier -->
                            <form method="post" action="../PHP/add_to_cart.php" class="mt-auto">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                <div class="input-group mb-2">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success w-100">Toevoegen aan winkelmandje</button>
                            </form>

                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Geen producten gevonden.</p>";
        }
        ?>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>
