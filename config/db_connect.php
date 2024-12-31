<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ckcmclinic_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// echo "Connected successfully";

// // Close connection
// $conn->close();


date_default_timezone_set('Asia/Manila');
?>





<!-- fontawesome -->
<link href="../fontawesome/css/fontawesome.css" rel="stylesheet" />
<link href="../fontawesome/css/brands.css" rel="stylesheet" />
<link href="../fontawesome/css/solid.css" rel="stylesheet" />


<!-- sweetalert -->
<script src="../js/sweetalert.js"></script>