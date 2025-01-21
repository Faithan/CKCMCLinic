<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch records from the database
$sql = "SELECT `record_id`, `student_id`, `record_date`, `student_name`, `student_department`, `chief_complaint`, `treatment` FROM `record_tbl`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title> Clinic Admin | Records CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>

        <div class="content-container">
            <div class="search-container">
                <!-- Search Input -->
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search . . ."
                    oninput="searchRecords()" />
                <a href="students.php"><i class="fa-solid fa-file-medical"></i> Add Record</a>
            </div>

            <div class="record-container">
                <!-- Table -->
                <table class="record-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Department</th>
                            <th>Record Date</th>
                            <th>Chief Complaint</th>
                            <th>Treatment</th>
                        </tr>
                    </thead>
                    <tbody id="recordTableBody">
                        <!-- Table rows will be dynamically populated -->
                        <?php
                        // Initial fetch to show all records on page load
                        $sql = "SELECT `record_id`, `student_id`, `record_date`, `student_name`, `student_department`, `chief_complaint`, `treatment` FROM `record_tbl`";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['record_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_department']); ?></td>
                                    <td><?php echo htmlspecialchars($row['record_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['chief_complaint']); ?></td>
                                    <td><?php echo htmlspecialchars($row['treatment']); ?></td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="6">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


        </div>



    </div>
</body>

</html>

<script>
    // Function to fetch filtered data as the user types
    function searchRecords() {
        const searchInput = document.getElementById('searchInput').value; // Get search input value
        const xhr = new XMLHttpRequest();

        xhr.open('GET', 'record_search.php?search=' + encodeURIComponent(searchInput), true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('recordTableBody').innerHTML = this.responseText; // Update table body
            }
        };
        xhr.send();
    }
</script>



<style>
    /* Main Content */
    .main-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .content-container {
        width: 100%;
        overflow-y: scroll;
        height: 100%;
        background-color: var(--background-color);
    }

    .search-container {
        width: 100%;
        background-color: var(--color4);
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 0;

    }

    .search-container input {
        padding: 5px;
        border: 1px solid var(--border-color);
        background-color: var(--background-color);
    }

    .search-container a i {
        margin-right: 5px;
    }

    .search-container a {
        color: var(--text-color);
        text-decoration: none;
        font-size: 1.2rem
    }

    .search-container a:hover {
        transform: translateY(-2px);
        color: var(--color1);

    }

    .record-container {
        width: 100%;
    }

    .record-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Add shadow for depth */

        /* Rounded corners */
        overflow: hidden;
        /* Prevent content overflow */
    }

    .record-table th,
    .record-table td {
        border: 1px solid var(--border-color);
        padding: 12px 15px;
        /* Add more padding for better spacing */
        text-align: left;
        font-size: 0.95rem;
        /* Adjust font size for readability */
        vertical-align: middle;
        /* Align content vertically */
    }

    .record-table th {
        background-color: var(--color3b);
        color: var(--color4);
        font-weight: bold;
        text-transform: uppercase;
        /* Uppercase headers */
        letter-spacing: 0.05em;
        /* Add slight spacing for headers */
        position: sticky;
        /* Keep headers visible during scroll */
        top: 0;
        z-index: 1;
    }

    .record-table tbody tr:nth-child(even) {
        background-color: var(--background-color);
        /* Alternate row color */
    }

    .record-table tbody tr:nth-child(odd) {
        background-color: #fff;
        /* Default row color */
    }

    .record-table td {
        color: var(--text-color);
        word-wrap: break-word;
        /* Wrap long text */
        max-width: 200px;
        /* Limit cell width */
        overflow: hidden;
        text-overflow: ellipsis;
        /* Add ellipsis for overflow text */
    }

    .record-table caption {
        caption-side: top;
        /* Position caption at the top */
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: var(--color4);
        text-align: left;
    }

    /* Scrollable Table */
    .record-container {
        overflow-x: auto;
        /* Enable horizontal scrolling for small screens */
        padding: 10px;
        /* Add padding around the container */
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Subtle inset shadow */
    }
</style>








<script>
    // Check for the status parameter in the URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'update_success') {
        Swal.fire({
            icon: 'success',
            title: 'Update Successful',
            text: 'Student Record have been updated successfully!',
            confirmButtonText: 'OK'
        }).then(() => {
            // Optionally redirect or clear the query parameter
            history.replaceState(null, '', window.location.pathname);
        });
    }
</script>