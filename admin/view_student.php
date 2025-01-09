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
    <title>Student Details | CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <div class="main-content">
        <?php include 'header.php'; ?>

        <div class="details-container">
            <img src="../student_pic/<?php echo $profile_picture; ?>" alt="<?php echo $full_name; ?>">
            <h2><?php echo $full_name; ?></h2>


            <div class="info-container">
                <?php
                // Define the keys you want to exclude
                $exclude_keys = ['user_id', 'datetime_recorded', 'profile_picture'];

                // Define custom labels for keys
                $custom_labels = [
                    'student_id' => 'Student ID',
                    'first_name' => 'First Name',
                    'middle_name' => 'Middle Name',
                    'last_name' => 'Last Name',
                    'email' => 'Email Address',
                    'gender' => 'Gender',
                    'department' => 'Department',
                    'year_level' => 'Year Level',
                    'blood_pressure' => 'Blood Pressure',
                    'temperature' => 'Temperature',
                    'pulse_rate' => 'Pulse Rate',
                    'respiratory_rate' => 'Respiratory Rate',
                    'eperson1_name' => 'Emergency Person1 Name',
                    'eperson2_name' => 'Emergency Person2 Name',
                    'eperson1_phone' => 'Emergency Person1 Phone',
                    'eperson2_phone' => 'Emergency Person2 Phone',
                    'eperson1_relationship' => 'Emergency Person1 Relationship',
                    'eperson2_relationship' => 'Emergency Person2 Relationship',
                    // Add more custom labels as needed
                ];

                // Loop through the student details, excluding the specified keys
                foreach ($student as $key => $value):
                    if (in_array($key, $exclude_keys)) {
                        continue; // Skip excluded keys
                    }

                    // Determine the label to display
                    $label = $custom_labels[$key] ?? ucfirst(str_replace("_", " ", $key));

                    // Handle empty values
                    $display_value = !empty($value) ? htmlspecialchars($value) : 'N/A';
                ?>
                    <div class="info">
                        <strong><?php echo htmlspecialchars($label); ?>:</strong>
                        <p><?php echo $display_value; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="record-base-container">
                <h2>Records</h2>
                <div class="record-container">

                </div>
            </div>

            <div class="button-container">
                <a href="students.php" class="back-btn"><i class="fa-solid fa-person-walking-arrow-loop-left"></i> Return</a>
                <a href="edit_student.php?student_id=<?php echo $student['student_id']; ?>" class="edit-btn"><i class="fa-solid fa-user-pen"></i> Edit</a>
            </div>


        </div>
    </div>
</body>

</html>








<style>
    .details-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: var(--color4);
        overflow-y: scroll;
    }

    .details-container img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--color3);
    }

    .info-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 20px;
        margin-top: 40px;
    }

    .info {
        width: 220px;
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
    }


    .info strong {
        font-size: 1.2rem;
    }

    .info p {
        font-size: 1.2rem;
        margin: 5px 0;
        color: var(--text-color2);

    }

    .details-container h2 {
        margin-top: 15px;
        color: var(--text-color);
    }

    .record-base-container {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .record-container {
        height: 100px;
        overflow-y: scroll;
        background-color: var(--background-color);
        border: 1px solid var(--border-color);
    }

    .button-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .button-container a {
        margin-top: 20px;
        padding: 10px 15px;
        color: var(--color4);
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .back-btn {
        background-color: var(--color1);
    }

    .edit-btn {
        background-color: var(--color2);
    }

    .back-btn:hover {
        background-color: var(--color1b);
        transform: translateY(-2px);
    }

    .edit-btn:hover {
        background-color: var(--color2b);
        transform: translateY(-2px);
    }
</style>