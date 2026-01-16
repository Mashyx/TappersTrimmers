<?php
include("../PHP/db.php");
include("header.php");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Webshop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/shop.css">
</head>
<body>

<div class="container my-5">
    <h1>Onze Producten:</h1>
<br>
    <?php
    // Haal alle producten op, gesorteerd op categorie
    $sql = "SELECT * FROM products ORDER BY category ASC, name ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $productsByCategory = [];

        // Groepeer producten per categorie
        while ($row = $result->fetch_assoc()) {
            $productsByCategory[$row['category']][] = $row;
        }

        // Loop door elke categorie
        foreach ($productsByCategory as $category => $products) {
            echo "<h2>" . ucwords(strtolower($category)) . "</h2>"; // eerste letter hoofdletter

            // Loop door producten in blokken van 3 per rij
            for ($i = 0; $i < count($products); $i += 3) {
                echo "<div class='row g-4 mb-4'>"; // nieuwe rij

                for ($j = $i; $j < $i + 3 && $j < count($products); $j++) {
                    $row = $products[$j];
                    ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="card h-100">
                            <img src="../assets/<?php echo $row['picture']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="card-text fw-bold">€<?php echo number_format($row['price'], 2); ?></p>

                                <form method="post" action="../PHP/add_to_cart.php" class="mt-auto">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                    <input type="hidden" name="product_picture" value="<?php echo $row['picture']; ?>">
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

                echo "</div>"; // sluit row
            }
        }

    } else {
        echo "<p class='text-center mt-4'>Geen producten gevonden.</p>";
    }
    ?>
</div>

<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
