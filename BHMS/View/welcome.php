<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="banner">
        <div class="navbar">
            <img src="../resources/lnulogo.png" class="logo">
        </div>

        <div class="content">
            <h1> WELCOME TO BOARDING <br> HOUSE MANAGEMENT SYSTEM </h1><br>
            <h2>Where Every Stay Feels Like Home.</h2>
            <p> Please select your role: </p>
            <div>
                <a href="admin/admin_login.html"><button type="button"><span></span>I am an Admin</button></a>
                <a href="tenant/tenant_login.html"><button type="button"><span></span>I am a Tenant</button></a>
            </div>
        </div>

    </div>
        
</body> 
</html>
