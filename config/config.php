<?php
// Database configuration (MySQL with custom port)
$host = '127.0.0.1';
$port = '3307'; // Specify your custom port here
$dbName = 'vanilla-php';
$username = 'root';
$password = ''; // password here if your database has a password

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print_r($e);
    die("Connection failed: " . $e->getMessage());
}
?>
