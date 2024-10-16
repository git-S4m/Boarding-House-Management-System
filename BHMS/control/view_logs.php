<?php
// Database connection
require '../config/db_config.php'; // Ensure this connects to the correct database

// Fetch logs from the database
$query_logs = "SELECT * FROM activity ORDER BY event_date_time DESC"; // Query the activity table
$result_logs = $conn->query($query_logs);

if (!$result_logs) {
    die("Query failed: " . $conn->error); // Handle any query errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>

</head>
<body>
    <h2>Activity Logs</h2>

    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Event Type</th>
                <th>Event Details</th>
                <th>Event Date & Time</th>
                <th>Event Datetime</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_logs->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['log_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['event_details']); ?></td>
                    <td><?php echo $row['event_date_time']; ?></td>
                    <td><?php echo $row['event_datetime']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <p><a href="/BHMS/view/admin/admin_dashboard.php">Back to Dashboard</a></p> <!-- Corrected link to admin dashboard -->
    
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
