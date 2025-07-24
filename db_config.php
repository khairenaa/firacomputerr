<?php
// Database connection configuration

$db_host = 'localhost'; // Your database host (e.g., localhost)
$db_user = 'root';      // Your database username (e.g., 'root' for local development)
$db_pass = '';          // Your database password (e.g., '' for local development)
$db_name = 'firacomputer'; // The name of your database

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
