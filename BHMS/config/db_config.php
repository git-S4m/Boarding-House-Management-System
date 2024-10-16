<?php
$servername = "localhost"; // Assuming you're using localhost
$username = "root";        // Default username for XAMPP is root
$password = "";            // No password for root by default in XAMPP
$dbname = "user_db";       // Your database name

// Create the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
