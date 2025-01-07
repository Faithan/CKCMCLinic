<?php
require 'config/db_connect.php'; // Database connection
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = trim($_POST['student_id']);
    $student_password = trim($_POST['password']);

    // Prepare and execute query
    $stmt = $conn->prepare("
        SELECT `user_id`, `student_id`, `password`, `first_name`, `middle_name`, `last_name`, `extension`, 
               `email`, `gender`, `birthdate`, `age`, `birth_place`, `marital_status`, `address`, 
               `religion`, `additional_info`, `department`, `year_level`, `profile_picture`, 
               `blood_pressure`, `temperature`, `pulse_rate`, `respiratory_rate`, `height`, `weight`, 
               `eperson1_name`, `eperson1_phone`, `eperson1_relationship`, 
               `eperson2_name`, `eperson2_phone`, `eperson2_relationship`, `datetime_recorded` 
        FROM `student_tbl` 
        WHERE `student_id` = ?
    ");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Check if the password matches
        if ($student_password === $student['password']) {
            // Password matches, set all session variables
            $_SESSION['student_logged_in'] = true;
            foreach ($student as $key => $value) {
                $_SESSION[$key] = $value;
            }

            // Redirect to student dashboard
            header("Location: student_dashboard.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['error_message'] = "Invalid password.";
        }
    } else {
        // Student ID not found
        $_SESSION['error_message'] = "Student ID not found.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to login page with error
    header("Location: student_login.php");
    exit();
}
?>
