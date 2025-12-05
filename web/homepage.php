<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/footer.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home pagina</title>
</head>
<body class="body">
    <?php
    include("header.php");
    ?>
    <!-- fotos voor de homepage -->
    <div class="afbeeldingHome">
        <img src="../assets/pngtree-barbershop-with-chairs-in-traditional-styles-and-mirrors-in-front-picture-image_3372710.jpg" width="900" height="400">
        <img src="../assets/SFD_Minimalism_1_Jaguar_Sun_CR_Adam_DelGiudice_2520x1420.jpg" width="900" height="400">
    </div>

    <div class="tekstMidden">
        <p>Welkom bij onze kapperszaak! Wij bieden professionele knip- en trimdiensten voor mannen en kinderen vanaf 12 jaar!. Onze ervaren kappers zorgen ervoor dat je er altijd op je best uitziet. Kom langs voor een stijlvolle knipbeurt of een verzorgende trimbeurt. We kijken ernaar uit je te verwelkomen!</p>
    </div>

    <!-- Prijslijst kapper -->
    <div class="prijslijst">
        <h2>Prijslijst</h2>
        <ul>
            <li>
                <span class="service">Standaard Knipbeurt</span>
                <span class="price">€ 15,00</span>
            </li>
            <li>
                <span class="service">Knipbeurt + Baard Trim</span>
                <span class="price">€ 20,00</span>
            </li>
            <li>
                <span class="service">Kinderknipbeurt (tot 12 jaar)</span>
                <span class="price">€ 12,00</span>
            </li>
            <li>
                <span class="service">Baard Trim</span>
                <span class="price">€ 8,00</span>
            </li>
            <li>
                <span class="service">Wash & Style</span>
                <span class="price">€ 10,00</span>
            </li>
        </ul>
    </div>

    <?php
    include("footer.php");
    ?>

</body>
</html>