<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.html"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Admin Dashboard</h2>
        <p><a href="../../control/view_tenant.php"><button type="button"><span></span></button>View Tenants</a></p>
        <p><a href="../../control/view_logs.php"><button type="button"><span></span></button>View Activity Logs</a></p>
        <p><a href="../../control/admin_logout.php"><button type="button"><span></span></button>Logout</a></p>
</body>
</html>
