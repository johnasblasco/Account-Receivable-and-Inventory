<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'inventory';

$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
    echo "Database connection successful!";
}
?>
