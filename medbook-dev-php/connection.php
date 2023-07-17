<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'medbook-dev-php';
$port = '3307';

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
} else {
    // echo 'Database connection successful!';
}

// $conn->close();
?>

