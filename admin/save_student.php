


<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data collection
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


    // Emergency contact details
    $eperson1_name = $_POST['eperson1_name'];
    $eperson1_phone = $_POST['eperson1_phone'];
    $eperson1_relationship = $_POST['eperson1_relationship'];
    $eperson2_name = $_POST['eperson2_name'];
    $eperson2_phone = $_POST['eperson2_phone'];
    $eperson2_relationship = $_POST['eperson2_relationship'];
    $datetime_recorded = date('Y-m-d H:i:s'); // Current timestamp

    // Check if student_id already exists
    $check_query = "SELECT * FROM student_tbl WHERE student_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'Student ID already exists!';
    } else {
        // Handle file upload
        $profile_picture = $_FILES['profile_picture'];
        if ($profile_picture['error'] === UPLOAD_ERR_OK) {  // Check if file upload is successful
            $upload_dir = '../student_pic/';
            $file_name = uniqid() . '_' . basename($profile_picture['name']);
            $upload_file = $upload_dir . $file_name;

            if (move_uploaded_file($profile_picture['tmp_name'], $upload_file)) {
                // Insert student data into the database
                $stmt = $conn->prepare("INSERT INTO student_tbl 
                    (student_id, password, first_name, middle_name, last_name, extension, email, gender, birthdate, age, birth_place, marital_status, address, religion, additional_info, department, year_level, profile_picture, eperson1_name, eperson1_phone, eperson1_relationship, eperson2_name, eperson2_phone, eperson2_relationship, datetime_recorded) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Bind parameters
                $stmt->bind_param(
                    'sssssssssssssssssssssssss',  // 24 placeholders for 24 values
                    $student_id,
                    $password,
                    $first_name,
                    $middle_name,
                    $last_name,
                    $extension,
                    $email,
                    $gender,
                    $birthdate,
                    $age,
                    $birth_place,
                    $marital_status,
                    $address,
                    $religion,
                    $additional_info,
                    $department,
                    $year_level,
                    $file_name,  // Bind profile_picture here
                    $eperson1_name,
                    $eperson1_phone,
                    $eperson1_relationship,
                    $eperson2_name,
                    $eperson2_phone,
                    $eperson2_relationship,
                    $datetime_recorded
                );

                if ($stmt->execute()) {
                    // Success
                    echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Student Saved!",
                            text: "The student record has been successfully saved."
                        }).then(() => {
                            window.location.href = "students.php"; // Redirect to student list page
                        });
                    </script>';
                } else {
                    // Error
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "There was an error saving the student data."
                        });
                    </script>';
                }

                $stmt->close();
            } else {
                echo 'Failed to upload profile picture.';
            }
        } else {
            echo 'Profile picture upload error: ' . $profile_picture['error'];
        }
    }
}
