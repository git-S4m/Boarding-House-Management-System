<?php
// Include your database configuration file
include 'db_config.php';

// Start session
session_start();

// Get the password from the AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];

    // Prepare and bind the statement
    $stmt = $conn->prepare("SELECT * FROM tenant WHERE password = ?");
    $stmt->bind_param("s", $password);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Password is correct
        echo json_encode(["status" => "success"]);
    } else {
        // Incorrect password
        echo json_encode(["status" => "error"]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
