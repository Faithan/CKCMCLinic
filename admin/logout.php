<?php
session_start();

// Check if the admin is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Unset session variables specific to the logged-in admin
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_username']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['admin_position']);
    unset($_SESSION['admin_pic']);
    
    // Optionally, you can destroy the session completely
    // session_destroy();
}

// Redirect to the login page
header("Location: login.php");
exit();
?>
