<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Initialize messages
$success_message = $error_message = '';

// Handle course addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $course_info = $_POST['course_info'];

    if (!empty($course_name) && !empty($course_info)) {
        $stmt = $conn->prepare("INSERT INTO `course_tbl` (`course_name`, `course_info`) VALUES (?, ?)");
        $stmt->bind_param("ss", $course_name, $course_info);

        if ($stmt->execute()) {
            $success_message = "Course added successfully!";
        } else {
            $error_message = "Failed to add course.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}

// Handle course deletion
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM `course_tbl` WHERE `course_id` = ?");
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        $success_message = "Course deleted successfully!";
    } else {
        $error_message = "Failed to delete course.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title>Clinic Admin | Course CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>
        <div class="content">
            <!-- Add Course Form -->

            <form method="POST" action="">
                <h2 style="margin-bottom: 10px;">Manage Courses</h2>
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name" placeholder="Ex: Bachelor of Science in Computer Science" required>
                <br>
                <label for="course_info">Course Info:</label>
                <textarea id="course_info" name="course_info" placeholder="It's a four-year undergraduate degree program that focuses on the principles and practices of computer science, including areas like software development, computer architecture, and algorithms. The program equips students with the skills to design, develop, and implement computer systems and software solutions. " required></textarea>
                <br>
                <button type="submit" name="add_course"><i class="fa-solid fa-plus"></i> Add Course</button>
            </form>

            <!-- Course List -->
            <!-- <h2 style="margin-top:20px;text-align:left; color:var(--color1)">Existing Courses</h2> -->
            <table >
                <thead>
                    <tr>
                        <!-- <th>Course ID</th> -->
                        <th>Course Name</th>
                        <th>Course Info</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT `course_id`, `course_name`, `course_info` FROM `course_tbl` WHERE 1");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        // echo "<td>{$row['course_id']}</td>";
                        echo "<td>{$row['course_name']}</td>";
                        echo "<td>{$row['course_info']}</td>";
                        echo "<td style='text-align:center;'>
                                <button class='delete-btn' data-id='{$row['course_id']}'><i class='fa-solid fa-trash-can'></i> Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Show success or error message
        <?php if (!empty($success_message)) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo $success_message; ?>'
            });
        <?php endif; ?>

        <?php if (!empty($error_message)) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error_message; ?>'
            });
        <?php endif; ?>

        // Confirmation before deletion
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const courseId = this.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `?delete=${courseId}`;
                    }
                });
            });
        });
    </script>
</body>

</html>

<style>
    /* Main Content */
    .main-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .content {
        overflow-y: scroll;
        width: 100%;
        height: 100%;
        padding: 10px;
    }

    form {
        margin-bottom: 10px;
        background-color: var(--color4);
        padding: 20px;
        display: flex;
        flex-direction: column;

    }

    form h2{
        color: var(--text-color);
    }
    form label{
        font-size: 1.2rem;
        margin-bottom: 5px;
        color: var(--text-color);
    }


    form input,
    form textarea {
        width: 100%;
        padding: 8px;
     
    }

    form textarea {
        height: 100px;
    }
 

    form button{
        padding: 5px;
        background-color: var(--color3b);
        color: white;
        border: 1px solid var(--color3b);
       
    }

    form button:hover{
        background-color: var(--color3);
        transition: ease .2s;
    }







    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
     
    }




    .delete-btn {
        color: red;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.2rem;
      
    }

    .delete-btn:hover {
        text-decoration:underline;
    }
</style>