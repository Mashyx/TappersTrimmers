<?php
session_start();

// Alle sessievariabelen leegmaken
$_SESSION = array();

// Sessie vernietigen
session_destroy();

// Redirect naar homepage
header("Location: ../web/homepage.php");
exit;
?>