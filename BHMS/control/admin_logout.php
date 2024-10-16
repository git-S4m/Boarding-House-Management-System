<?php
session_start();
require '../config/db_config.php';

// Function to log activities
function logActivity($conn, $eventType, $eventDetails) {
    $eventDateTime = date('Y-m-d H:i:s'); // Get the current date and time
    $stmt = $conn->prepare("INSERT INTO activity (event_type, event_details, event_datetime) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $eventType, $eventDetails, $eventDateTime);
    $stmt->execute();
    $stmt->close();
}

// Log admin logout
if (isset($_SESSION['admin_id'])) { // Check if admin is logged in
    $admin_id = $_SESSION['admin_id']; // Assuming you saved the admin ID during login
    logActivity($conn, 'Admin Logout', "Admin ID $admin_id logged out.");
}

// Clear the session and redirect to welcome page
session_unset();
session_destroy();
header("Location: ../view/welcome.php");
exit();
?>
