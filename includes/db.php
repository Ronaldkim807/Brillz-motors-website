<?php
$host = 'localhost'; // Database host
$dbname = 'brillz_motors'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (leave blank if no password is set)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>