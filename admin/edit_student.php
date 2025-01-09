<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if a student ID is provided
if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    header("Location: students.php");
    exit();
}




$student_id = $_GET['student_id'];

// Fetch student details
$sql = "SELECT * FROM `student_tbl` WHERE `student_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Student not found.";
    exit();
}

$student = $result->fetch_assoc();

// Fetch course options
$course_sql = "SELECT `course_id`, `course_name` FROM `course_tbl`";
$course_result = $conn->query($course_sql);

// Fetch year level options
$year_lvl_sql = "SELECT `year_lvl_id`, `year_lvl_name` FROM `year_lvl_tbl`";
$year_lvl_result = $conn->query($year_lvl_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $email = $_POST['email'];
    $marital_status = $_POST['marital_status'];
    $address = $_POST['address'];
    $religion = $_POST['religion'];
    $department = $_POST['department'];
    $year_level = $_POST['year_level'];
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

    $update_sql = "UPDATE `student_tbl` SET 
        `password` = ?, `email` = ?, `marital_status` = ?, `address` = ?, 
        `religion` = ?, `department` = ?, `year_level` = ?, `blood_pressure` = ?, 
        `temperature` = ?, `pulse_rate` = ?, `respiratory_rate` = ?, `height` = ?, 
        `weight` = ?, `eperson1_name` = ?, `eperson1_phone` = ?, `eperson1_relationship` = ?, 
        `eperson2_name` = ?, `eperson2_phone` = ?, `eperson2_relationship` = ? 
        WHERE `student_id` = ?";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param(
        "ssssssssssssssssssss",
        $password,
        $email,
        $marital_status,
        $address,
        $religion,
        $department,
        $year_level,
        $blood_pressure,
        $temperature,
        $pulse_rate,
        $respiratory_rate,
        $height,
        $weight,
        $eperson1_name,
        $eperson1_phone,
        $eperson1_relationship,
        $eperson2_name,
        $eperson2_phone,
        $eperson2_relationship,
        $student_id
    );

    if ($stmt->execute()) {
        header("Location: students.php?status=update_success");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>




<?php

// Fetch all student details
$sql = "SELECT `user_id`, `student_id`, `password`, `first_name`, `middle_name`, `last_name`, `extension`, 
               `email`, `gender`, `birthdate`, `age`, `birth_place`, `marital_status`, `address`, 
               `religion`, `additional_info`, `department`, `year_level`, `profile_picture`, 
               `blood_pressure`, `temperature`, `pulse_rate`, `respiratory_rate`, `height`, 
               `weight`, `eperson1_name`, `eperson1_phone`, `eperson1_relationship`, 
               `eperson2_name`, `eperson2_phone`, `eperson2_relationship`, `datetime_recorded` 
        FROM `student_tbl` 
        WHERE `student_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Student not found.";
    exit();
}

$student = $result->fetch_assoc();

$full_name = $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'] . ' ' . $student['extension'];
$profile_picture = $student['profile_picture'] ?: 'default_profile.png'; // Default profile picture

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title>Edit Student | CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php include 'side_nav.php'; ?>


    <div class="main-content">
        <?php include 'header.php'; ?>
        <div class="image-container">
            <img src="../student_pic/<?php echo $profile_picture; ?>" alt="<?php echo $full_name; ?>">
            <h2><?php echo $full_name; ?></h2>
        </div>

        <form method="POST" class="edit-student-form">
            <h2>Edit Student Details</h2>

            <div class="input-container">
                <!-- Editable fields -->
                <div class="input-fields">
                    <label>Password:</label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars($student['password']); ?>" required>
                </div>
                <div class="input-fields">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>
                <div class="input-fields">
                    <label>Marital Status:</label>
                    <input type="text" name="marital_status" value="<?php echo htmlspecialchars($student['marital_status']); ?>">
                </div>
                <div class="input-fields">
                    <label>Address:</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($student['address']); ?>">
                </div>
                <div class="input-fields">
                    <label>Religion:</label>
                    <input type="text" name="religion" value="<?php echo htmlspecialchars($student['religion']); ?>">
                </div>
                <div class="input-fields">
                    <label>Department:</label>
                    <select name="department" required>
                        <?php while ($course = $course_result->fetch_assoc()): ?>
                            <option value="<?php echo $course['course_name']; ?>"
                                <?php echo ($student['department'] === $course['course_name']) ? 'selected' : ''; ?>>
                                <?php echo $course['course_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input-fields">
                    <label>Year Level:</label>
                    <select name="year_level" required>
                        <?php while ($year_lvl = $year_lvl_result->fetch_assoc()): ?>
                            <option value="<?php echo $year_lvl['year_lvl_name']; ?>"
                                <?php echo ($student['year_level'] === $year_lvl['year_lvl_name']) ? 'selected' : ''; ?>>
                                <?php echo $year_lvl['year_lvl_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input-fields">
                    <!-- Vital signs -->
                    <label>Blood Pressure:</label>
                    <input type="text" name="blood_pressure" value="<?php echo htmlspecialchars($student['blood_pressure']); ?>">
                </div>
                <div class="input-fields">
                    <label>Temperature:</label>
                    <input type="text" name="temperature" value="<?php echo htmlspecialchars($student['temperature']); ?>">
                </div>
                <div class="input-fields">
                    <label>Pulse Rate:</label>
                    <input type="text" name="pulse_rate" value="<?php echo htmlspecialchars($student['pulse_rate']); ?>">
                </div>
                <div class="input-fields">
                    <label>Respiratory Rate:</label>
                    <input type="text" name="respiratory_rate" value="<?php echo htmlspecialchars($student['respiratory_rate']); ?>">
                </div>
                <div class="input-fields">
                    <label>Height:</label>
                    <input type="text" name="height" value="<?php echo htmlspecialchars($student['height']); ?>">
                </div>
                <div class="input-fields">
                    <label>Weight:</label>
                    <input type="text" name="weight" value="<?php echo htmlspecialchars($student['weight']); ?>">
                </div>
                <div class="input-fields">
                    <!-- Emergency contact -->
                    <label>Emergency Person 1 Name:</label>
                    <input type="text" name="eperson1_name" value="<?php echo htmlspecialchars($student['eperson1_name']); ?>">
                </div>
                <div class="input-fields">
                    <label>Emergency Person 1 Phone:</label>
                    <input type="text" name="eperson1_phone" value="<?php echo htmlspecialchars($student['eperson1_phone']); ?>">
                </div>
                <div class="input-fields">
                    <label>Emergency Person 1 Relationship:</label>
                    <input type="text" name="eperson1_relationship" value="<?php echo htmlspecialchars($student['eperson1_relationship']); ?>">
                </div>
                <div class="input-fields">
                    <label>Emergency Person 2 Name:</label>
                    <input type="text" name="eperson2_name" value="<?php echo htmlspecialchars($student['eperson2_name']); ?>">
                </div>
                <div class="input-fields">
                    <label>Emergency Person 2 Phone:</label>
                    <input type="text" name="eperson2_phone" value="<?php echo htmlspecialchars($student['eperson2_phone']); ?>">
                </div>
                <div class="input-fields">
                    <label>Emergency Person 2 Relationship:</label>
                    <input type="text" name="eperson2_relationship" value="<?php echo htmlspecialchars($student['eperson2_relationship']); ?>">
                </div>
                <!-- Submit button -->
            </div>

            <div class="button-container">
                <a href="javascript:history.back();"><i class="fa-solid fa-person-walking-arrow-loop-left"></i> Return</a>

                <button type="submit"><i class="fa-solid fa-floppy-disk"></i> Save Update</button>
            </div>

        </form>
    </div>
</body>

</html>







<style>
    body {
        background-color: var(--color4);
    }

    .image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 20px;
        background-color: var(--color4);
    }

    .image-container img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--color3);
        margin-bottom: 10px;
    }


    form {
        padding: 20px;
    }

    .input-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 40px;
        margin: 20px 0;

    }

    .input-fields {
        min-width: 250px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        gap: 5px;

    }


    .input-fields input,
    .input-fields select {
        padding: 5px;
        color: var(--color1);

    }

    .button-container {
        display: flex;
        justify-content: space-between;
    }


    .button-container a {

        padding: 10px;
        color: var(--color4);
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
        background-color: var(--color1);

    }


    .button-container button {
        font-size: 1rem;
        padding: 5px 10px;
        color: var(--color4);
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
        background-color: var(--color3);
    }


    .button-container a:hover {
        background-color: var(--color1b);
        transform: translateY(-2px);
    }

    .button-container button:hover {
        background-color: var(--color3b);
        transform: translateY(-2px);
    }
</style>