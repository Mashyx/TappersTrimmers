<?php
// Start the session
session_start();

// Database connection
$host = 'localhost';
$db   = 't&t';
$user = 'root';
$pass = ''; 
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

