<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $extension = $_POST['extension'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $birth_place = $_POST['birth_place'];
    $marital_status = $_POST['marital_status'];
    $address = $_POST['address'];
    $religion = $_POST['religion'];
    $additional_info = $_POST['additional_info'];
    $department = $_POST['department'];
    $year_level = $_POST['year_level'];
    $datetime_recorded = date('Y-m-d H:i:s');

    $blood_pressure = $_POST['blood_pressure'];
    $temperature = $_POST['temperature'];
    $pulse_rate = $_POST['pulse_rate'];
    $respiratory_rate = $_POST['respiratory_rate'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    $eperson1_name = $_POST['eperson1_name'];
    $eperson1_phone = $_POST['eperson1_phone'];
    $eperson1_relationship = $_POST['eperson1_relationship'];
    $eperson2_name = $_POST['eperson2_name'];
    $eperson2_phone = $_POST['eperson2_phone'];
    $eperson2_relationship = $_POST['eperson2_relationship'];

    // Image upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = $_FILES['profile_picture'];
        $profile_picture_name = time() . "_" . $profile_picture['name'];
        $profile_picture_tmp_name = $profile_picture['tmp_name'];
        $profile_picture_path = '../student_pic/' . $profile_picture_name;
        move_uploaded_file($profile_picture_tmp_name, $profile_picture_path);
    } else {
        $profile_picture_name = null;
    }

    // Check if student_id already exists
    $check_query = $conn->prepare("SELECT COUNT(*) FROM `student_tbl` WHERE `student_id` = ?");
    $check_query->bind_param("s", $student_id);
    $check_query->execute();
    $check_query->bind_result($count);
    $check_query->fetch();
    $check_query->close();

    if ($count > 0) {
        // Redirect back to the form with an error message
        header("Location: add_student.php?error=student_id_exists");
        exit();
    }


    // Insert the data into the database
    try {
        $stmt = $conn->prepare("INSERT INTO `student_tbl`(`student_id`, `password`, `first_name`, `middle_name`, `last_name`, `extension`, `email`, `gender`, `birthdate`, `age`, `birth_place`, `marital_status`, `address`, `religion`, `additional_info`, `department`, `year_level`, `profile_picture`, `blood_pressure`, `temperature`, `pulse_rate`, `respiratory_rate`, `height`, `weight`, `eperson1_name`, `eperson1_phone`, `eperson1_relationship`, `eperson2_name`, `eperson2_phone`, `eperson2_relationship`, `datetime_recorded`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind the parameters
        $stmt->bind_param("sssssssssssssssssssssssssssssss", $student_id, $password, $first_name, $middle_name, $last_name, $extension, $email, $gender, $birthdate, $age, $birth_place, $marital_status, $address, $religion, $additional_info, $department, $year_level, $profile_picture_name, $blood_pressure, $temperature, $pulse_rate, $respiratory_rate, $height, $weight, $eperson1_name, $eperson1_phone, $eperson1_relationship, $eperson2_name, $eperson2_phone, $eperson2_relationship, $datetime_recorded);

        if ($stmt->execute()) {
            header("Location: students.php?success=student_added");
            exit();
        } else {
            throw new Exception("Error saving student record.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
