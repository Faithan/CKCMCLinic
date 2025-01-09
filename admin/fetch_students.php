<?php
require '../config/db_connect.php';
session_start();

// Filter parameters
$search = $_GET['search'] ?? '';
$department = $_GET['department'] ?? '';
$year_level = $_GET['year_level'] ?? '';
$gender = $_GET['gender'] ?? '';

// Build query with filters
$sql = "SELECT `user_id`, `student_id`, `first_name`, `middle_name`, `last_name`, `extension`, `email`, `gender`, 
        `department`, `year_level`, `profile_picture` FROM `student_tbl` WHERE 1";

if ($search) {
    $sql .= " AND (`first_name` LIKE '%$search%' OR `last_name` LIKE '%$search%' OR `student_id` LIKE '%$search%')";
}
if ($department) {
    $sql .= " AND `department` = '$department'";
}
if ($year_level) {
    $sql .= " AND `year_level` = '$year_level'";
}
if ($gender) {
    $sql .= " AND `gender` = '$gender'";
}

$result = $conn->query($sql);
$total_students = $result->num_rows;

if ($total_students > 0) {
    while ($row = $result->fetch_assoc()) {
        $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['extension'];
        $profile_picture = $row['profile_picture'] ?: 'default_profile.png'; // Fallback to default picture
        echo "
        <div class='student-card'>
            <div class='card-image'>
                <img src='../student_pic/{$profile_picture}' alt='{$full_name}'>
            </div>
            <div class='card-content'>
                <h3>{$full_name}</h3>
                <p><strong>Student ID:</strong> {$row['student_id']}</p>
                <p><strong>Gender:</strong> {$row['gender']}</p>
                <p><strong>Department:</strong> {$row['department']}</p>
                <p><strong>Year Level:</strong> {$row['year_level']}</p>
                <p><strong>Email:</strong> {$row['email']}</p>
               <div class='button-container'>
                    <a href='update_records.php?student_id={$row['student_id']}' class='update-btn'><i class='fa-solid fa-notes-medical'></i> Update Record</a>
                   <a href='view_student.php?student_id={$row['student_id']}' class='action-btn'><i class='fa-solid fa-eye'></i> View Details</a>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<p>No students found.</p>";
}

// Add total students as a hidden div for JavaScript
echo "<div id='total-students' style='display:none;'>{$total_students}</div>";
