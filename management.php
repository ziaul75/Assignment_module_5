<?php
session_start();
function checkManager()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'manager') {
        return true;
    } else {
        return false;
    }
}

if (checkManager()) {
    echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Manager Page</title>
        </head>
        <body>
            <h1>Welcome, Manager</h1>
            <h2>Manager Page</h2>
            <p>Perform manager-specific operations here.</p>
        </body>
        </html>";
} else {
    header("location: login.html");
    exit;
}
?>
