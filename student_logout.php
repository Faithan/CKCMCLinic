<?php
session_start();

// Check if the student is logged in
if (isset($_SESSION['student_logged_in']) && $_SESSION['student_logged_in'] === true) {
    // Clear all session variables
    session_unset();

    // Destroy the session completely
    // session_destroy();
}

// Redirect to the student login page
header("Location: index.php");
exit();
?>
