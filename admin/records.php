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
                <input type="text" placeholder="Search . . . ">
                <a href="students.php"><i class="fa-solid fa-file-medical"></i> Add Record</a>
            </div>

            <div class="record-container">

            </div>
        </div>



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

    .search-container input{
        padding: 5px;   
        border: 1px solid var(--border-color);
        background-color: var(--background-color);
    }

    .search-container a i {
        margin-right: 5px;
    }   
    .search-container a{
        color: var(--text-color);
        text-decoration: none;
        font-size: 1.2rem
    }

    .search-container a:hover{
        transform: translateY(-2px);
        color: var(--color1);

    }

    .record-container {
        width: 100%;
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