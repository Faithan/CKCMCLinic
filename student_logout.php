<?php
session_start();

// Check if the student is logged in
if (isset($_SESSION['student']['logged_in']) && $_SESSION['student']['logged_in'] === true) {
    // Clear student-specific session variables
    unset($_SESSION['student']);
}

// Redirect to the student login page
header("Location: index.php");
exit();
?>
