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
    <title> Clinic Admin | Medicines CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>



        <?php ob_start(); ?>
        <div class="content">
            <?php
            require '../config/db_connect.php';

            // Add medicine
            if (isset($_POST['add_medicine'])) {
                $name = $_POST['medicine_name'];
                $desc = $_POST['medicine_description'];
                $stocks = $_POST['stocks'];

                $image_name = $_FILES['medicine_pic']['name'];
                $image_tmp = $_FILES['medicine_pic']['tmp_name'];
                $upload_path = '../medicines_pic/' . $image_name;

                if (move_uploaded_file($image_tmp, $upload_path)) {
                    $stmt = $conn->prepare("INSERT INTO medicines_tbl (medicine_name, medicine_description, medicine_pic, stocks, created_at) VALUES (?, ?, ?, ?, NOW())");
                    $stmt->bind_param("sssi", $name, $desc, $image_name, $stocks);
                    $stmt->execute();
                    $stmt->close();

                    echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Medicine added successfully!',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location = '" . $_SERVER['PHP_SELF'] . "';
                    });
                });
            </script>";
                }
            }

            // Delete medicine
            if (isset($_POST['delete_medicine'])) {
                $id = $_POST['medicine_id'];

                // First, get the image filename from the database
                $stmt = $conn->prepare("SELECT medicine_pic FROM medicines_tbl WHERE medicine_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($image_name);
                $stmt->fetch();
                $stmt->close();

                // Delete the image file if it exists
                $image_path = '../medicines_pic/' . $image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                // Then delete the record from the database
                $stmt = $conn->prepare("DELETE FROM medicines_tbl WHERE medicine_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();

                echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Medicine deleted successfully!',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.location = '" . $_SERVER['PHP_SELF'] . "';
            });
        });
    </script>";
            }

            // Update stocks
            if (isset($_POST['update_stocks'])) {
                $id = $_POST['medicine_id'];
                $new_stocks = $_POST['new_stocks'];
                $stmt = $conn->prepare("UPDATE medicines_tbl SET stocks = stocks + ? WHERE medicine_id = ?");
                $stmt->bind_param("ii", $new_stocks, $id);
                $stmt->execute();
                $stmt->close();

                echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Stocks updated successfully!',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location = '" . $_SERVER['PHP_SELF'] . "';
                });
            });
        </script>";
            }
            ?>



            <!-- Add Medicine Form -->
            <form method="POST" enctype="multipart/form-data" class="medicine-form">
                <h2>Medicine Management</h2>
                <h3>Add New Medicine</h3>
                <input type="text" name="medicine_name" placeholder="Medicine Name" required>
                <textarea name="medicine_description" placeholder="Description" required></textarea>
                <input type="number" name="stocks" placeholder="Initial Stocks" min="0" required>
                <input type="file" name="medicine_pic" accept="image/*" required>
                <button type="submit" name="add_medicine"><i class="fa-solid fa-plus"></i> Add Medicine</button>
            </form>



            <!-- List Medicines -->
            <div class="medicine-list">
                <?php
                $result = $conn->query("SELECT * FROM medicines_tbl");
                while ($row = $result->fetch_assoc()):
                ?>
                    <div class="medicine-card">
                        <img src="../medicines_pic/<?php echo $row['medicine_pic']; ?>" alt="Medicine Image">
                        <h4><?php echo htmlspecialchars($row['medicine_name']); ?></h4>
                        <p><?php echo htmlspecialchars($row['medicine_description']); ?></p>
                        <p><strong>Stocks:</strong> <?php echo $row['stocks']; ?></p>

                        <form method="POST" class="stock-form">
                            <input type="hidden" name="medicine_id" value="<?php echo $row['medicine_id']; ?>">
                            <input type="number" name="new_stocks" placeholder="Add Stocks" min="1" required>
                            <button type="submit" name="update_stocks"><i class="fa-solid fa-up-long"></i> Update Stocks</button>
                        </form>

                        <form method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this medicine?');">
                            <input type="hidden" name="medicine_id" value="<?php echo $row['medicine_id']; ?>">
                            <button type="submit" name="delete_medicine"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>

            <style>
                .content {
                    padding: 10px;
                }

                .medicine-form {
                    background: var(--background-color);
                    padding: 20px;

                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    margin-bottom: 10px;

                }

                .medicine-form h2,
                .medicine-form h3 {
                    color: var(--text-color);
                }


                .medicine-form textarea {
                    height: 100px;
                }


                .medicine-form button {
                    padding: 5px;
                    background-color: var(--color3b);
                }

                .medicine-form button {

                    color: white;
                    border: none;
                    cursor: pointer;
                }

                .medicine-form button:hover {
                    background: #606060;
                }

                .medicine-list {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 280px));
                    gap: 20px;
                    padding: 5px;
                    background-color: var(--background-color2);
                }

                .medicine-card {
                    border: 1px solid var(--border-color);
                    background: var(--background-color);
                    padding: 20px;
                    border-radius: 12px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }

                .medicine-card img {
                    width: 100%;
                    height: 150px;
                    object-fit: cover;
                    border-radius: 5px;
                  
                    margin-bottom: 10px;
                }
                .medicine-card h4{
                    font-size: 1.2rem;
                    color: var(--text-color);
                    text-align: justify;
                }

                .medicine-card p{
                    color: var(--text-color2);
                    text-align: justify;
                    margin-top: 5px;
                }

                .medicine-card p strong{
                    color: var(--text-color);
                 
                }
                .stock-form,
                .delete-form {
                    margin-top: 10px;
                }

                .stock-form input {
                    width: 100px;
                    margin-right: 5px;
                }

                .stock-form button,
                .delete-form button {
                    background: #007bff;
                    color: white;
                    border: none;
                    padding: 6px 12px;
              
                    cursor: pointer;
                }

                .delete-form button {
                    background: #dc3545;
                }

                .stock-form button:hover {
                    background: #0056b3;
                }

                .delete-form button:hover {
                    background: #c82333;
                }
            </style>

            <!-- SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </div>
        <?php ob_end_flush(); ?>




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
        height: 100%;
    }
</style>