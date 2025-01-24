<?php
require '../config/db_connect.php'; // Database connection
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = trim($_POST['admin_username']);
    $admin_password = trim($_POST['admin_password']);

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT `admin_id`, `admin_username`, `admin_password`, `first_name`, `middle_name`, `last_name`, `admin_position`, `admin_pic` 
                            FROM `admin_tbl` WHERE `admin_username` = ?");
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Compare plain-text password
        if ($admin_password === $admin['admin_password']) {
            // Password matches, set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_username'] = $admin['admin_username'];
            $_SESSION['admin_password'] = $admin['admin_password'];
            $_SESSION['admin_name'] = $admin['first_name'] . ' ' . $admin['last_name'];
            $_SESSION['admin_position'] = $admin['admin_position'];
            $_SESSION['admin_pic'] = $admin['admin_pic'];

            // Redirect to admin dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['error_message'] = "Invalid username or password.";
        }
    } else {
        // Admin not found
        $_SESSION['error_message'] = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to login page with error
    header("Location: login.php");
    exit();
}
?>
