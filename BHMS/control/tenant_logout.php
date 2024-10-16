<?php
session_start();
require '../config/db_config.php'; // Make sure this path is correct

// Function to log activities
function logActivity($conn, $eventType, $eventDetails) {
    $eventDateTime = date('Y-m-d H:i:s'); // Get the current date and time
    $stmt = $conn->prepare("INSERT INTO activity (event_type, event_details, event_datetime) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $eventType, $eventDetails, $eventDateTime);
    $stmt->execute();
    $stmt->close();
}

// Check if tenant is logged in before logging out
if (isset($_SESSION['tenant_id'])) {
    $tenant_id = $_SESSION['tenant_id'];

    // Log the sign-out activity
    logActivity($conn, 'Tenant Logout', "Tenant ID $tenant_id has logged out.");

    // Clear the session and destroy it
    session_unset();
    session_destroy();
}

// Redirect to the welcome page
header("Location: ../view/welcome.php");
exit();
?>
