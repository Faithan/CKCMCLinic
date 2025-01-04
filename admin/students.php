<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Check for success in the URL
$success = isset($_GET['success']) ? $_GET['success'] : '';

// Fetch department options
$departments = $conn->query("SELECT `course_name` FROM `course_tbl`");

// Fetch year level options
$year_levels = $conn->query("SELECT `year_lvl_name` FROM `year_lvl_tbl`");



// Build query with filters
$sql = "SELECT `user_id`, `student_id`, `first_name`, `middle_name`, `last_name`, `extension`, `email`, `gender`, 
        `department`, `year_level`, `profile_picture` FROM `student_tbl` WHERE 1";

// Fetch initial total students count
$total_students_query = "SELECT COUNT(*) AS total_students FROM `student_tbl`";
$total_students_result = $conn->query($total_students_query);
$total_students = $total_students_result->fetch_assoc()['total_students'];

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title> Clinic Admin | Students CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>

        <main>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search . . ." oninput="filterStudents()">
                <div class="select-container">
                    <select id="department" onchange="filterStudents()">
                        <option value="">Filter by: Department (default)</option>
                        <?php while ($row = $departments->fetch_assoc()) { ?>
                            <option value="<?php echo $row['course_name']; ?>"><?php echo $row['course_name']; ?></option>
                        <?php } ?>
                    </select>
                    <select id="year_level" onchange="filterStudents()">
                        <option value="">Filter by: Year Level (default)</option>
                        <?php while ($row = $year_levels->fetch_assoc()) { ?>
                            <option value="<?php echo $row['year_lvl_name']; ?>"><?php echo $row['year_lvl_name']; ?></option>
                        <?php } ?>
                    </select>
                    <select id="gender" onchange="filterStudents()">
                        <option value="">Filter by: Gender (default)</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <!-- Students Cards -->
            <div id="students-card-container" class="students-card-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['extension'];
                        $profile_picture = $row['profile_picture'] ?: 'default_profile.png'; // Fallback to default picture
                        echo "
                        <div class='student-card'>
                            <div class='card-image'>
                                <img src='../student_pic/{$profile_picture}' alt='{$full_name}'>
                            </div>
                            <div class='card-content'>
                                <h3>{$full_name}</h3>
                                <p><strong>Student ID:</strong> {$row['student_id']}</p>
                                <p><strong>Gender:</strong> {$row['gender']}</p>
                                <p><strong>Department:</strong> {$row['department']}</p>
                                <p><strong>Year Level:</strong> {$row['year_level']}</p>
                                <p><strong>Email:</strong> {$row['email']}</p>
                                <a href='view_student.php?student_id={$row['student_id']}' class='action-btn'>View Details</a>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p>No students found.</p>";
                }
                ?>
            </div>

            <div class="footer-container">
                <label for="">Total Students: <span id="total-students-label"><?php echo $total_students; ?></span></label>
                <a href="add_student.php"><i class="fa-solid fa-user-plus"></i> Add Student</a>
            </div>

        </main>



    </div>
    <script>
        function filterStudents() {
            const search = document.getElementById('search').value;
            const department = document.getElementById('department').value;
            const yearLevel = document.getElementById('year_level').value;
            const gender = document.getElementById('gender').value;

            const queryString = `?search=${search}&department=${department}&year_level=${yearLevel}&gender=${gender}`;
            fetch(`fetch_students.php${queryString}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('students-card-container').innerHTML = data;

                    // Update total students
                    const totalStudents = document.getElementById('total-students').textContent;
                    document.getElementById('total-students-label').textContent = totalStudents;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>




<!-- do not touch message for add student success -->
<script>
    // Check for success and display SweetAlert
    const success = "<?php echo $success; ?>";
    if (success === "student_added") {
        Swal.fire({
            icon: 'success',
            title: 'Student Added',
            text: 'The student has been successfully added to the database.',
            confirmButtonText: 'OK'
        });
    }
</script>



<style>
    /* Main Content */
    .main-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    main {
        width: 100%;
        height: 100%;
        background-color: var(--backgroud-color);
        overflow-y: scroll;
        display: flex;
        flex-direction: column;

    }

    .search-container {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        background-color: var(--color4);
        padding: 10px;
        border: 1px solid var(--border-color);
        border-bottom: 0;
        border-top: 0;

    }

    .search-container input,
    .search-container select {
        padding: 5px;
        background-color: #E7E9EB;
        border: 1px solid ;
        color: var(--text-color2);
    }



    .footer-container {
        padding: 10px;
        background-color: var(--color4);
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid var(--border-color);
        border-top: 0;

    }

    .footer-container label {
        font-size: 1.2rem;
    }

    .footer-container a {
        text-decoration: none;
        font-size: 1.2rem;
        padding: 10px;

        border-radius: 5px;
        color: var(--text-color);
    }

    .footer-container a:hover {
        color: var(--color1);
        transform: translateY(-2px);
        transition: ease-in-out 0.3s;

    }

    .footer-container a i {
        margin-right: 5px;
    }
</style>



<style>
    /* Students Card Container */
    .students-card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        overflow-y: scroll;
        padding: 10px;
    }

    /* Individual Student Card */
    .student-card {
        background-color: var(--color4);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        width: 300px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    /* Card Image Section */
    .card-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Card Content Section */
    .card-content {
        padding: 15px;
        text-align: center;
    }

    .card-content h3 {
        margin: 10px 0;
        font-size: 1.2rem;
        color: var(--text-color);
    }

    .card-content p {
        margin: 5px 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .card-content .action-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 15px;
        background-color: var(--color1);
        color: var(--text-light);
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .card-content .action-btn:hover {
        background-color: var(--hover-color);
        transform: translateY(-2px);
    }
</style>