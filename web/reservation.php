<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reservation.css">

    <title>Document</title>
      <?php
    include("header.php");
    ?>
</head>
<body class="body">
    <h1 class="txt" class='h1'>reservering</h1>
  
  <div id="reservering_div_kapper">
  <table class=txt id="reservering_table_kapper">
    <tr>
      <th>maandag</th>
      <th>dinsdag</th>
      <th>woensdag</th>
      <th>donderdag</th>
      <th>vrijdag</th>
      <th>zaterdag</th>
      <th>zondag</th>
    </tr>
    <br>
    <tr>
      <td>gesloten</td>
      <td>09:00-18:00</td>
      <td>09:00-18:00</td>
      <td>09:00-20:00</td>
      <td>09:00-18:00</td>
      <td>10:00-18:00</td>
      <td>gesloten</td>
    </tr>
  </table>
  </div>

  <div id="reservering_div_bar">
    <table id="reservering_table_bar" class="txt">
      <tr>
        <th>maandag</th>
        <th>dinsdag</th>
        <th>woensdag</th>
        <th>donderdag</th>
        <th>vrijdag</th>
        <th>zaterdag</th>
        <th>zondag</th>
      </tr>
      <br>
      <tr>
        <td>gesloten</td>
        <td>12:00-20:00</td>
        <td>12:00-20:00</td>
        <td>12:00-20:00</td>
        <td>12:00-20:00</td>
        <td>12:00-20:00</td>
        <td>gesloten</td>
      </tr>
    </table>
    </div>
<?php
    include("footer.php");
    ?>
</body>
</html>