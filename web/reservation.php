<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <?php
    include("header.php");
    include("../PHP/db.php");
    ?>
</head>
<body>
    <form method="post">
    <label for="res_date">Kies een datum:</label>
    <input type="date" id="res_date" name="res_date">
    <label for="res_time">Kies een tijd:</label>
    <input type="time" id="res_time" name="res_time" min="09:00" max="18:00" step="900">
    <input type="text" id="res_naam" name="res_naam" placeholder="Uw naam">
    <input type="email" id="res_mail" name="res_mail" placeholder="Uw e-mail">
    <select name="kapper" id="kapper"> 
        <option value="Kapper 1" id="kapper">Divar Harms</option> 
        <option value="Kapper 2" id="kapper">Claudia Bakker</option> 
        <option value="Kapper 3" id="kapper">Nieck Groot</option>
    </select>

    <button type="submit" value="reserveren">Reserveer</button>
</form>
  
    <?php
    ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    {
        $datum = $_POST['res_date'];
        $time = $_POST['res_time'];
        $naam = $_POST['res_naam'];
        $mail = $_POST['res_mail'];
        $kapper = $_POST['kapper'];
        {
            $stmt = $conn -> prepare("
                INSERT INTO appointments (date, time, naam, mail, kapper) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            if ($stmt->execute([$datum, $time, $naam, $mail, $kapper])) {
                echo 'reservering succesvol ingediend!';
            } else {
                echo 'Fout bij indienen reservering.';
            }
        }
    }
    exit();
}
?>

<?php
    include("footer.php");
    ?>
</body>
</html>