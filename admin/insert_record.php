<?php
require '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_department = $_POST['student_department'];
    $chief_complaint = $_POST['chief_complaint'];
    $treatment = $_POST['treatment'];

    $stmt = $conn->prepare("INSERT INTO `record_tbl`(`student_id`, `record_date`, `student_name`, `student_department`, `chief_complaint`, `treatment`) VALUES (?, NOW(), ?, ?, ?, ?)");
    $stmt->bind_param("issss", $student_id, $student_name, $student_department, $chief_complaint, $treatment);

    if ($stmt->execute()) {
        header("Location: records.php?status=update_success");
    } else {
        echo "Failed to save the record.";
    }

    $stmt->close();
    $conn->close();
}
?>
