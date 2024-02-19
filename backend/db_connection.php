<?php
// Database connection parameters
$host = 'localhost'; // Change this if your database is hosted elsewhere
$username = 'USER'; // Replace with your MariaDB username
$password = 'PW'; // Replace with your MariaDB password
$database = 'DBNAME'; // Replace with your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo 'Connected!';
?>
