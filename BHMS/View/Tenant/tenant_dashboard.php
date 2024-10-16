<?php
session_start();
if (!isset($_SESSION['tenant_id'])) {
    header("Location: tenant_login.html"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Tenant Dashboard</h2>

    <p><a href="select_room.php"><button type="button"><span></span></button>Select Room</a></p>
    <p><a href="../../control/tenant_logout.php"><button type="button"><span></span></button>Logout</a></p>

</body>
</html>
