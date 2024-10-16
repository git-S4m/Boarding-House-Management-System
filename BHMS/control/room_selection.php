<?php
session_start();
require '../config/db_config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the POST data
    $level = $_POST['level'];
    $roomNumber = $_POST['roomNumber'];
    $bed = $_POST['bed'];
    $username = $_SESSION['username']; // Assuming the username is stored in the session

    // Ensure the connection is working
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to insert the room selection into the database (you may want a separate table for reservations)
    $sql = "INSERT INTO room_reservations (username, level, room_number, bed) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("siss", $username, $level, $roomNumber, $bed);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Room reserved successfully!";
        // Redirect to another page or show a success message
    } else {
        echo "Error: " . $stmt->error; // Display error if execution fails
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
