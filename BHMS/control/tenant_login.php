<?php
session_start();
require '../config/db_config.php'; // Ensure this path is correct

// Function to log activities
function logActivity($conn, $eventType, $eventDetails) {
    $eventDateTime = date('Y-m-d H:i:s'); // Get the current date and time
    $stmt = $conn->prepare("INSERT INTO activity (event_type, event_details, event_datetime) VALUES (?, ?, ?)");
    if ($stmt) { // Check if the statement preparation was successful
        $stmt->bind_param("sss", $eventType, $eventDetails, $eventDateTime);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for logging activity: " . $conn->error);
    }
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Check what is being posted
    error_log(print_r($_POST, true)); // Log the POST data to the error log

    // Sanitize input to prevent SQL injection and XSS
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

    if (!empty($username) && !empty($password)) {
        // Prepare the SQL query to select the tenant user
        $sql = "SELECT id, username, password FROM tenants WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            // Check if any rows were returned
            if ($stmt->num_rows > 0) {
                // Bind the result to variables
                $stmt->bind_result($id, $username_db, $hashed_password);
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Set session variables
                    $_SESSION['username'] = $username_db;
                    $_SESSION['tenant_id'] = $id; // Store tenant ID in session

                    // Log successful login
                    logActivity($conn, 'Tenant Login', "Tenant ID $id logged in successfully.");

                    // Return success response
                    echo json_encode(["status" => "success", "message" => "Login successful."]);
                    exit(); // Stop further code execution
                } else {
                    // Log unsuccessful login attempt
                    logActivity($conn, 'Failed Tenant Login', "Tenant with username '$username' failed to log in.");

                    // Password is incorrect
                    echo json_encode(["status" => "error", "message" => "Incorrect password. Please try again."]);
                    exit();
                }
            } else {
                // Log unsuccessful login attempt
                logActivity($conn, 'Failed Tenant Login', "No user found with username '$username'.");

                // No user found with that username
                echo json_encode(["status" => "error", "message" => "No user found with that username."]);
                exit();
            }
        } else {
            // SQL query preparation failed
            echo json_encode(["status" => "error", "message" => "Error preparing statement: " . $conn->error]);
            exit();
        }
    } else {
        // Username or password is empty
        echo json_encode(["status" => "error", "message" => "Please fill in both the username and password."]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit();
}
?>
