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
                <input type="text" placeholder="Search . . .">
                <div class="select-container">
                    <select name="" id=""></select>
                    <select name="" id=""></select>
                    <select name="" id=""></select>
                </div>
            </div>

      
            <table>

            </table>
            <div class="footer-container">
                <label for="">Total Students: # </label>
                <a href="add_student.php"><i class="fa-solid fa-user-plus"></i> Add Student</a>
            </div>
        </main>



    </div>
</body>

</html>





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
        padding: 20px;
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

    }


    main table {
        padding: 10px;
        background-color: var(--color4);
        flex-grow: 1;
        border: 1px solid var(--border-color);
        border-top: 0;
        border-bottom: 0;
        overflow-y: scroll;
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
        transition: ease-in-out 0.3s;
        background-color: var(--text-hover2);

    }

    .footer-container a i {
        margin-right: 5px;
    }
</style>