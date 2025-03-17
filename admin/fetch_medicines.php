<?php
require '../config/db_connect.php'; // Ensure this connects to your database

$sql = "SELECT medicine_id, medicine_name FROM medicines_tbl WHERE stocks > 0";
$result = $conn->query($sql);

$medicines = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
}

echo json_encode($medicines);
?>