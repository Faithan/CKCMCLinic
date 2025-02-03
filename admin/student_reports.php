<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Default to empty search term
$searchTerm = '%';

// Fetch students and their medical records based on the search term
$studentQuery = "SELECT `student_id`, `first_name`, `middle_name`, `last_name`, `extension`, `department`, `year_level`, `profile_picture`, `datetime_recorded` 
                 FROM `student_tbl` 
                 WHERE CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`, ' ', `extension`) LIKE ?";

$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$studentsResult = $stmt->get_result();

$recordsQuery = "SELECT `record_id`, `student_id`, `record_date`, `chief_complaint`, `treatment` FROM `record_tbl`";
$recordsResult = $conn->query($recordsQuery);

// Organize records by student ID
$recordsByStudent = [];
while ($record = $recordsResult->fetch_assoc()) {
    $recordsByStudent[$record['student_id']][] = $record;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title>Clinic Admin | Reports CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>
        <div class="content">


            <!-- Search Bar -->
            <input type="text" id="search-bar" placeholder="Search by student name..." />

            <div class="report-container" id="report-container">
                <?php if ($studentsResult->num_rows > 0): ?>
                    <?php while ($student = $studentsResult->fetch_assoc()): ?>
                        <div class="student-card" data-student-name="<?php echo strtolower($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'] . ' ' . $student['extension']); ?>">
                            <div class="student-header" onclick="toggleRecords('<?php echo $student['student_id']; ?>')">
                                <img src="../student_pic/<?php echo $student['profile_picture']; ?>" alt="Profile Picture" />
                                <div>
                                    <h3><?php echo $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'] . ' ' . $student['extension']; ?></h3>
                                    <p>Department: <?php echo $student['department']; ?> | Year: <?php echo $student['year_level']; ?></p>
                                    <p>Recorded On: <?php echo date('F d, Y', strtotime($student['datetime_recorded'])); ?></p>
                                </div>
                                <form action="generate_pdf.php" method="post" target="_blank" style="margin-left: auto;">
                                    <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                    <button type="submit" class="pdf-btn"><i class="fa-solid fa-file-pdf"></i> View PDF</button>
                                </form>
                                <span class="arrow">&#9660;</span>
                            </div>

                            <div id="records-<?php echo $student['student_id']; ?>" class="records-container">
                                <hr>
                                <br>
                                <?php if (!empty($recordsByStudent[$student['student_id']])): ?>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Record Date</th>
                                                <th>Chief Complaint</th>
                                                <th>Treatment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recordsByStudent[$student['student_id']] as $record): ?>
                                                <tr>
                                                    <td><?php echo date('F d, Y', strtotime($record['record_date'])); ?></td>
                                                    <td><?php echo $record['chief_complaint']; ?></td>
                                                    <td><?php echo $record['treatment']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No records available for this student.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No student data available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Real-time search functionality
        document.getElementById('search-bar').addEventListener('input', function() {
            var searchTerm = this.value.toLowerCase();
            var studentCards = document.querySelectorAll('.student-card');
            studentCards.forEach(function(card) {
                var studentName = card.getAttribute('data-student-name');
                if (studentName.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function toggleRecords(studentId) {
            const recordsContainer = document.getElementById('records-' + studentId);
            recordsContainer.classList.toggle('show');
        }
    </script>
</body>

</html>











<style>
    .main-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .content {
        padding: 20px;
    }

    .report-container {
        display: flex;
        flex-direction: column;
        gap: 5px;

    }

    .student-card {
        background: var(--color4);
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .student-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        cursor: pointer;
        background: var(--color4);
        color: var(--text-color);
    }

    .student-card:hover {
        outline: 2px solid var(--color5);
    }

    .student-header img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-header h3 {
        margin: 0;
    }

    .student-header p{
        color: var(--text-color2);
    }

    .student-header .arrow {
        margin-left: auto;
        font-size: 1.5rem;
        transform: rotate(90deg);
        transition: transform 0.3s ease;
    }

    .records-container {
        display: block;
        /* Default to block to allow transition */
        max-height: 0;
        /* Initially hide the container */
        padding: 0 15px;
        /* Optional: to keep padding when it's collapsed */
        overflow: hidden;
        transition: ease 0.3s ;
        /* Transition for smooth animation */
    }

    /* Active state when the container is shown */
    .records-container.show {
        max-height: 1000px;
        /* A large value to allow the content to expand */
        padding: 15px;
        overflow-y: scroll;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border: 1px solid var(--border-color);
    }

    th {
        background: var(--color3b);
        color: #fff;
    }

    td {
        background: var(--background-color);
        color: var(--text-color);
    }

    hr{
        border: 1px solid var(--border-color);
    }

    .pdf-btn {
        padding: 5px 10px;
        background: var(--color3b);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .pdf-btn:hover {
        background: var(--color5);
    }

    /* Search bar styling */
    input[type="text"] {
        padding: 8px;
        font-size: 14px;
        width: 200px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }
</style>