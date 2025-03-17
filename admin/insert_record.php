<?php
require '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_department = $_POST['student_department'];
    $chief_complaint = $_POST['chief_complaint'];
    $treatment = $_POST['treatment'];
    $medicine_taken = isset($_POST['medicine_taken']) ? $_POST['medicine_taken'] : [];

    // ✅ Convert the array into a comma-separated string for record-keeping
    $medicine_taken_str = implode(", ", $medicine_taken);

    // Insert the record into the database
    $stmt = $conn->prepare("INSERT INTO `record_tbl`(`student_id`, `record_date`, `record_time`, `student_name`, `student_department`, `chief_complaint`, `treatment`, `medicine_taken`) VALUES (?, NOW(), NOW(), ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $student_id, $student_name, $student_department, $chief_complaint, $treatment, $medicine_taken_str);

    if ($stmt->execute()) {
        // ✅ Reduce the stock of each selected medicine
        if (!empty($medicine_taken)) {
            foreach ($medicine_taken as $medicine_name) {
                $updateStockQuery = "UPDATE medicines_tbl SET stocks = stocks - 1 WHERE medicine_name = ? AND stocks > 0";
                $stockStmt = $conn->prepare($updateStockQuery);
                $stockStmt->bind_param("s", $medicine_name);
                $stockStmt->execute();
                $stockStmt->close();
            }
        }

        // Redirect after successful update
        header("Location: records.php?status=update_success");
        exit();
    } else {
        echo "Failed to save the record.";
    }

    $stmt->close();
    $conn->close();
}
?>
