<?php
session_start();

// Include the database configuration
require '../config/db_config.php'; // Adjust the path as necessary

// Fetch tenants' data along with their room assignment
$query = "
    SELECT tenants.first_name, tenants.last_name, room_assignments.level, room_assignments.room_number, room_assignments.bed_number 
    FROM tenants
    LEFT JOIN room_assignments ON tenants.id = room_assignments.tenant_id"; // Joins tenant with room assignments

// Execute the query and check for errors
$result = $conn->query($query);

if (!$result) {
    echo "<p>Error fetching tenant data: " . htmlspecialchars($conn->error) . "</p>";
    exit(); // Stop execution if there's an error
}

// Start the HTML document
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tenants</title>

</head>
<body>
    <h1>Registered Tenants</h1>

    <?php
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        echo "<ul>"; // Start an unordered list

        // Fetch each row and display tenant information with room assignment
        while ($row = $result->fetch_assoc()) {
            // Check for missing data
            $first_name = htmlspecialchars($row['first_name']) ?: "(No First Name)";
            $last_name = htmlspecialchars($row['last_name']) ?: "(No Last Name)";
            $level = htmlspecialchars($row['level']) ?: "(No Level)";
            $room_number = htmlspecialchars($row['room_number']) ?: "(No Room)";
            $bed_number = htmlspecialchars($row['bed_number']) ?: "(No Bed)";
                
            // Concatenate first name, last name, and room assignment details
            $full_name = "$first_name $last_name";
                
            // Display tenant info with room, level, and bed details
            echo "<li>Name: $full_name, Level: $level, Room: $room_number, Bed: $bed_number</li>";
        }
            
        echo "</ul>"; } // End the unordered list
    else {
        echo "<p>No tenants registered.</p>"; // Message when no tenants are found
    }
    ?>

    <p><a href="../view/admin/admin_dashboard.php">Back to Dashboard</a></p>

</body>
</html>

<?php
// Close the database connection
$conn->close(); // Close the database connection
?>
