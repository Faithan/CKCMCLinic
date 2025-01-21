<?php
require '../config/db_connect.php';

// Fetch search term from the request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query to fetch filtered records
$sql = "SELECT `record_id`, `student_id`, `record_date`, `student_name`, `student_department`, `chief_complaint`, `treatment` 
        FROM `record_tbl` 
        WHERE `student_name` LIKE ? 
           OR `student_department` LIKE ? 
           OR `chief_complaint` LIKE ? 
           OR `treatment` LIKE ? 
           OR `record_date` LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%" . $searchTerm . "%";
$stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// Generate HTML for the table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['record_id']) . "</td>
                <td>" . htmlspecialchars($row['student_name']) . "</td>
                <td>" . htmlspecialchars($row['student_department']) . "</td>
                <td>" . htmlspecialchars($row['record_date']) . "</td>
                <td>" . htmlspecialchars($row['chief_complaint']) . "</td>
                <td>" . htmlspecialchars($row['treatment']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found.</td></tr>";
}
?>
