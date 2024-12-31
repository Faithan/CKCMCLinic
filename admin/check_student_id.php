<?php
require '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Query to check if the student ID already exists
    $query = "SELECT 1 FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If student ID exists, return 'exists'
        echo 'exists';
    } else {
        // If student ID does not exist, return nothing
        echo 'available';
    }
    
    $stmt->close();
    $conn->close();
}
?>
