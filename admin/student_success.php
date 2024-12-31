<?php
// student_success.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title>Student Added Successfully</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">

</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>

        <main>
            <div class="message-container">
                <?php
                if (isset($_GET['message'])) {
                    echo '<h2>' . htmlspecialchars($_GET['message']) . '</h2>';
                }
                ?>
                <a href="students.php">Back to Students</a>
            </div>
        </main>
    </div>
</body>

</html>
