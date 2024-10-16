<?php
session_start();
if (!isset($_SESSION['tenant_id'])) {
    header("Location: tenant_login.html"); // Redirect to login if not logged in
    exit();
}

// Database connection
require '../../config/db_config.php'; // Adjust path as necessary

// Check if the tenant has already selected a room
$tenant_id = $_SESSION['tenant_id'];
$query_check = "SELECT level, room_number, bed_number FROM room_assignments WHERE tenant_id = ?";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("i", $tenant_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Fetch the selected room details
    $row = $result_check->fetch_assoc();
    $room_number = $row['room_number'];
    $level = $row['level'];
    $bed_number = $row['bed_number'];

    // Room already selected, display the details
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "    <meta charset='UTF-8'>";
    echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "    <title>Room Already Selected</title>";
    echo "</head>";
    echo "<body>";
    echo "    <h2>Room Already Selected</h2>";
    echo "    <p>You have successfully selected Room <strong>$room_number</strong> on Level <strong>$level</strong>, Bed <strong>$bed_number</strong>.</p>";
    echo "    <p>Please go back to the dashboard.</p>";
    echo "    <p><a href='tenant_dashboard.php'>Back to Dashboard</a></p>";
    echo "</body>";
    echo "</html>";
    exit(); // Stop execution here if room is already selected
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Room</title>

</head>
<body>
    <h2>Select Room</h2>
    <form action="../../control/confirm_room.php" method="POST" id="roomForm">
        <label for="level">Level/Floor:</label>
        <select id="level" name="level" required>
            <option value="">Select Level</option>
            <option value="1">1st Floor</option>
            <option value="2">2nd Floor</option>
            <option value="3">3rd Floor</option>
        </select><br><br>

        <label for="roomNumber">Room Number:</label>
        <select id="roomNumber" name="room_number" required>
            <option value="">Select Room</option>
            <option value="101">101 (1st Floor)</option>
            <option value="102">102 (1st Floor)</option>
            <option value="201">201 (2nd Floor)</option>
            <option value="202">202 (2nd Floor)</option>
            <option value="301">301 (3rd Floor)</option>
            <option value="302">302 (3rd Floor)</option>
        </select><br><br>

        <label for="bed">Bed Number:</label>
        <select id="bed" name="bed_number" required>
            <option value="">Select Bed</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select><br><br>

        <button type="submit">Confirm Selection</button>
    </form>

    <p><a href="tenant_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
