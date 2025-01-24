<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $admin_position = $_POST['admin_position'];
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Retrieve current photo from the database
    $current_photo_query = $conn->prepare("SELECT `admin_pic` FROM `admin_tbl` WHERE `admin_id` = ?");
    $current_photo_query->bind_param("i", $admin_id);
    $current_photo_query->execute();
    $result = $current_photo_query->get_result();
    $current_photo = $result->fetch_assoc()['admin_pic'];

    // Handle profile picture upload
    $admin_pic = $_FILES['admin_pic']['name'];
    $upload_dir = '../admin_pic/';
    $upload_file = $upload_dir . basename($admin_pic);
    $upload_success = true;

    if (!empty($admin_pic)) {
        // Validate and move uploaded file
        $file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
        if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            if (!move_uploaded_file($_FILES['admin_pic']['tmp_name'], $upload_file)) {
                $upload_success = false;
            }
        } else {
            $upload_success = false;
        }
    } else {
        // If no new photo is uploaded, keep the current photo
        $admin_pic = $current_photo;
    }

    // Update the admin details in the database
    $query = $conn->prepare(
        "UPDATE `admin_tbl` SET 
            `first_name` = ?, 
            `middle_name` = ?, 
            `last_name` = ?, 
            `admin_position` = ?, 
            `admin_username` = ?, 
            `admin_password` = ?, 
            `admin_pic` = ? 
        WHERE `admin_id` = ?"
    );
    $query->bind_param(
        "sssssssi",
        $first_name,
        $middle_name,
        $last_name,
        $admin_position,
        $admin_username,
        $admin_password,
        $admin_pic,
        $admin_id
    );

    if ($query->execute()) {
        // Success
        $_SESSION['message'] = "Admin details updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        // Error
        $_SESSION['message'] = "Failed to update admin details!";
        $_SESSION['message_type'] = "error";
    }

    header("Location: settings.php");
    exit();
}
?>
