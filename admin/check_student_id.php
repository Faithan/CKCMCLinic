<?php
// Include the database connection
require '../config/db_connect.php';  // Adjust the path as necessary

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if student_id is provided via GET
if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    echo 'error';  // If no student_id is provided, return an error
    exit;
}

// Get the student_id from the GET request
$student_id = $_GET['student_id'];

// Debugging: log the incoming student_id
error_log("Received student_id: " . $student_id);

try {
    // Prepare the query to check if the student ID already exists in the database
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM student_tbl WHERE student_id = :student_id');
    $stmt->execute(['student_id' => $student_id]);
    $rowCount = $stmt->fetchColumn();

    // Debugging: log the row count result
    error_log("Database query result: " . $rowCount);

    // Return response based on the query result
    if ($rowCount > 0) {
        echo 'taken';  // Student ID is already taken
    } else {
        echo 'available';  // Student ID is available
    }
} catch (Exception $e) {
    // Output any errors for debugging
    error_log('Database error: ' . $e->getMessage());
    echo 'error';  // Return a generic error message
}
?>
