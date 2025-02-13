<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch admin details from the database
$admin_id = $_SESSION['admin_id']; // Assuming the session stores the admin ID
$query = $conn->prepare("SELECT `admin_id`, `admin_username`, `admin_password`, `first_name`, `middle_name`, `last_name`, `admin_position`, `admin_pic` FROM `admin_tbl` WHERE `admin_id` = ?");
$query->bind_param("i", $admin_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../system_images/ckcm_logo.png" type="image/x-icon">
    <title>Clinic Admin | Settings CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>
        <div class="content">
            <form action="update_admin.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($admin['admin_id']); ?>">

                <div class="form-group" style="display:flex; flex-direction:column; align-items:center; gap: 5px;">
                    <label for="admin_pic">Profile Picture:</label>
                    <img src="../admin_pic/<?php echo htmlspecialchars($admin['admin_pic']); ?>" alt="Admin Picture" class="admin-pic-preview">
                    <input type="file" id="admin_pic" name="admin_pic" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($admin['first_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($admin['middle_name']); ?>">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($admin['last_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="admin_position">Position:</label>
                    <input type="text" id="admin_position" name="admin_position" value="<?php echo htmlspecialchars($admin['admin_position']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="admin_username">Username:</label>
                    <input type="text" id="admin_username" name="admin_username" value="<?php echo htmlspecialchars($admin['admin_username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="admin_password">Password:</label>
                    <input type="password" id="admin_password" name="admin_password" value="<?php echo htmlspecialchars($admin['admin_password']); ?>" required>
                </div>

                <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
            </form>
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

    .content {
        overflow-y: scroll;
        width: 100%;
        height: calc(100% - 50px);
        background: var(--color4);
    }
</style>


<style>
    .admin-form {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin: auto;
        padding: 20px;
        gap: 5px;
        border-top: 0;

    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 1.2rem;
        color: var(--text-color);
    }

    .form-group input {
        width: 100%;
        padding: 8px;
     
    }


    .admin-pic-preview {
        display: block;
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 10px;
        border-radius: 50%;
    }

    .btn-save {
        display: inline-block;
        padding: 10px 20px;
        background: var(--color3);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.2rem;
    }

    .btn-save:hover {
        background: var(--color3b);
    }
</style>




<?php if (isset($_SESSION['message'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['message_type']; ?>',
            title: '<?php echo $_SESSION['message_type'] === "success" ? "Success" : "Error"; ?>',
            text: '<?php echo $_SESSION['message']; ?>'
        });
    </script>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
<?php endif; ?>