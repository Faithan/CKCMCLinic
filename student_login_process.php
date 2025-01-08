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
            // Password matches, set student-specific session variables
            $_SESSION['student'] = [
                'logged_in' => true,
                'user_id' => $student['user_id'],
                'student_id' => $student['student_id'],
                'password' => $student['password'], // Optional: consider not storing raw passwords in session
                'first_name' => $student['first_name'],
                'middle_name' => $student['middle_name'],
                'last_name' => $student['last_name'],
                'extension' => $student['extension'],
                'email' => $student['email'],
                'gender' => $student['gender'],
                'birthdate' => $student['birthdate'],
                'age' => $student['age'],
                'birth_place' => $student['birth_place'],
                'marital_status' => $student['marital_status'],
                'address' => $student['address'],
                'religion' => $student['religion'],
                'additional_info' => $student['additional_info'],
                'department' => $student['department'],
                'year_level' => $student['year_level'],
                'profile_picture' => $student['profile_picture'],
                'blood_pressure' => $student['blood_pressure'],
                'temperature' => $student['temperature'],
                'pulse_rate' => $student['pulse_rate'],
                'respiratory_rate' => $student['respiratory_rate'],
                'height' => $student['height'],
                'weight' => $student['weight'],
                'eperson1_name' => $student['eperson1_name'],
                'eperson1_phone' => $student['eperson1_phone'],
                'eperson1_relationship' => $student['eperson1_relationship'],
                'eperson2_name' => $student['eperson2_name'],
                'eperson2_phone' => $student['eperson2_phone'],
                'eperson2_relationship' => $student['eperson2_relationship'],
                'datetime_recorded' => $student['datetime_recorded'],
            ];

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


