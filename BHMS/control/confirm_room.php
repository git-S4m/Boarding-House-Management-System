<?php
session_start();
if (!isset($_SESSION['tenant_id'])) {
    header("Location: tenant_login.html"); // Redirect to login if not logged in
    exit();
}

// Database connection
require '../config/db_config.php'; // Adjust path as necessary

$tenant_id = $_SESSION['tenant_id'];

// Get selected room data
$level = $_POST['level'];
$room_number = $_POST['room_number'];
$bed_number = $_POST['bed_number'];
$room_cost = 1000; // Set the cost to 1000 pesos

// Insert into room_assignments table
$query_insert = "INSERT INTO room_assignments (level, room_number, bed_number, tenant_id, price) VALUES (?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($query_insert);
$stmt_insert->bind_param("ssiii", $level, $room_number, $bed_number, $tenant_id, $room_cost);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Room Selection</title>

</head>
<body>
    <h2>Room Selection Confirmation</h2>
    
    <?php
    if ($stmt_insert->execute()) {
        echo "<p>You have successfully selected Room $room_number on Level $level, Bed $bed_number.</p>";
        echo "<p>The total cost is ₱1000 monthly.</p>";}
    else {
        echo "<h2>Error</h2>";
        echo "<p>There was an error selecting the room. Please try again.</p>";
    }

    $stmt_insert->close();
    $conn->close();
    ?>
        
    <p><a href="../view/tenant/tenant_dashboard.php">Back to Dashboard</a></p>

</body>
</html>
