<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title>CKCM Clinic Admin Dashboard</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="../system_images/ckcm_logo.png" alt="CKCM Logo" class="logo">
            <h2>CKCM Clinic</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="employee_report.php">Employee Reports</a></li>
            <li><a href="product_report.php">Product Reports</a></li>
            <li><a href="user_report.php">User Reports</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome, <?php echo $_SESSION['admin_name']; ?></h1>
            <p>Manage your clinic effectively with the available tools.</p>
        </header>

        <section class="dashboard-stats">
            <div class="stat-box">
                <h3>Total Employees</h3>
                <p>50</p> <!-- Dynamically load this from the database -->
            </div>
            <div class="stat-box">
                <h3>Total Products</h3>
                <p>100</p> <!-- Dynamically load this from the database -->
            </div>
            <div class="stat-box">
                <h3>Total Users</h3>
                <p>200</p> <!-- Dynamically load this from the database -->
            </div>
        </section>

        <section class="recent-activity">
            <h2>Recent Activity</h2>
            <table>
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- This section should show recent activities like new employee registrations or requests -->
                    <tr>
                        <td>New Employee Registered</td>
                        <td>2024-12-29 12:00</td>
                    </tr>
                    <tr>
                        <td>Product Order Completed</td>
                        <td>2024-12-29 14:00</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</body>

</html>




<style>
    /* Reset and base styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
}

/* Sidebar Styling */
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #3c8dbc;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin-bottom: 40px;
}

.sidebar-header .logo {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
}

.sidebar-header h2 {
    font-size: 24px;
    font-weight: bold;
}

.sidebar-menu {
    list-style-type: none;
    padding: 0;
}

.sidebar-menu li {
    margin: 15px 0;
}

.sidebar-menu li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.sidebar-menu li a:hover {
    background-color: #1a6b96;
}

/* Main Content */
.main-content {
    margin-left: 260px;
    padding: 30px;
}

header h1 {
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 10px;
}

header p {
    font-size: 18px;
    color: #555;
}

.dashboard-stats {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.stat-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 30%;
    text-align: center;
    transition: transform 0.3s ease;
}

.stat-box:hover {
    transform: scale(1.05);
}

.stat-box h3 {
    font-size: 20px;
    margin-bottom: 10px;
}

.stat-box p {
    font-size: 24px;
    font-weight: bold;
    color: #4CAF50;
}

/* Recent Activity Table */
.recent-activity {
    margin-top: 50px;
}

.recent-activity h2 {
    font-size: 24px;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #3c8dbc;
    color: white;
}

table tr:hover {
    background-color: #f9f9f9;
}

</style>
