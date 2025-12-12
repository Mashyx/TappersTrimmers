<?php
require 'header.php'; // starts session and renders nav

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$displayName = isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : (isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#111; color:#eee; font-family: Poppins, sans-serif; }
        .container-card { max-width:900px; margin:6vh auto; padding:28px; background:#1a1a1a; border:1px solid #333; border-radius:10px; }
        .btn-logout { background:#bfa046; color:#111; border:none; padding:8px 14px; border-radius:6px; }
    </style>
</head>
<body>
<div class="container container-card">
    <h2>Welkom<?php if ($displayName) echo ', ' . $displayName; ?>!</h2>
    <p>Dit is je dashboard.</p>

    <form action="homepage.php" method="get" style="margin-top:18px;">
        <button type="submit" class="btn-logout">Uitloggen</button>
    </form>

</div>

</body>
</html>
