<?php
session_start(); // Start the session
require '../config/db_config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the POST data
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Ensure the connection is working
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO admin_users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../view/admin/admin_login.html"); // Redirect to admin login page upon successful signup
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error: " . $stmt->error; // Display error if execution fails
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
