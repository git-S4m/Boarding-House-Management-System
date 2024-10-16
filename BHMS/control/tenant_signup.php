<?php
require '../config/db_config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the POST data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = (int)$_POST['age']; // Cast age to integer
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Ensure the connection is working
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO tenants (first_name, last_name, age, address, gender, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters: s = string, i = integer
    $stmt->bind_param("ssissss", $first_name, $last_name, $age, $address, $gender, $username, $password);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../view/tenant/tenant_login.html"); // Redirect to tenant login page upon successful signup
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error: " . $stmt->error; // Display error if execution fails
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
