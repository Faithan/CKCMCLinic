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
    header("Location: students.php?error=invalid_student_id");
    exit();
}

$student_id = $_GET['student_id'];

// Delete student from the database
$sql = "DELETE FROM `student_tbl` WHERE `student_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);

if ($stmt->execute()) {
    header("Location: students.php?status=delete_success");
} else {
    header("Location: students.php?status=error");
}
$stmt->close();
$conn->close();
?>
