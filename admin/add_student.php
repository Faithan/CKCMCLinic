<?php
// Check for error in the URL
$error = isset($_GET['error']) ? $_GET['error'] : '';

?>



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
    <title> Clinic Admin | Add Students CKCM, Inc.</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php include 'side_nav.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>

        <main>
            <form id="add-student-form" action="save_student.php" method="POST" enctype="multipart/form-data" class="add-container">


                <h2><i class="fa-solid fa-user-plus"></i> Add Student</h2>

                <div class="input-base-container">
                    <strong for="">Student Information:</strong>
                    <div class="input-mini-container">

                        <div class="input-container">
                            <label for="student_id">Student ID:</label>
                            <input type="number" id="student_id" name="student_id" required>
                        </div>




                        <div class="input-container">
                            <label for="">First Name:</label>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="input-container">
                            <label for="">Middle Name:</label>
                            <input type="text" name="middle_name" required>
                        </div>
                        <div class="input-container">
                            <label for="">Last Name:</label>
                            <input type="text" name="last_name" required>
                        </div>
                        <div class="input-container">
                            <label for="">Extension e.g. Jr./Sr. <em>(if applicable)</em>:</label>
                            <input type="text" name="extension">
                        </div>
                        <div class="input-container">
                            <label for="">Email:</label>
                            <input type="text" name="email" required>
                        </div>
                        <div class="input-container">
                            <label for="">Gender:</label>
                            <select name="gender" id="" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="male">male</option>
                                <option value="female">female</option>
                            </select>
                        </div>

                        <div class="input-container">
                            <label for="birthdate">Date of Birth:</label>
                            <input type="date" name="birthdate" required max="<?= date('Y-m-d'); ?>">
                        </div>

                        <div class="input-container">
                            <label for="">Age:</label>
                            <input type="number" readonly name="age">
                        </div>

                        <div class="input-container">
                            <label for="">Birth Place:</label>
                            <input type="text" name="birth_place" required>
                        </div>

                        <div class="input-container">
                            <label for="">Marital Status:</label>
                            <input type="text" name="marital_status" required>
                        </div>


                        <div class="input-container">
                            <label for="">Address:</label>
                            <input type="text" name="address" required>
                        </div>

                        <div class="input-container">
                            <label for="">Religion:</label>
                            <input type="text" name="religion" required>
                        </div>


                        <div class="input-container">
                            <label for="">College Department:</label>
                            <select name="department" id="" required>
                                <option value="" selected disabled>Select Department</option>
                                <?php
                                require '../config/db_connect.php';

                                try {
                                    // Ensure the database connection is active
                                    if (!$conn) {
                                        throw new Exception('Database connection failed.');
                                    }

                                    // Fetch and display department options
                                    $dept_query = "SELECT `course_id`, `course_name` FROM `course_tbl`";
                                    $dept_result = $conn->query($dept_query);

                                    if ($dept_result && $dept_result->num_rows > 0) {
                                        while ($row = $dept_result->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($row['course_name']) . '">' . htmlspecialchars($row['course_name']) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Departments Available</option>';
                                    }
                                } catch (Exception $e) {
                                    echo '<option value="">Error loading Departments</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input-container">
                            <label for="">Year Level:</label>
                            <select name="year_level" id="" required>
                                <option value="" selected disabled>Select Year Level</option>
                                <?php
                                try {
                                    // Ensure the database connection is active
                                    if (!$conn) {
                                        throw new Exception('Database connection failed.');
                                    }

                                    // Fetch and display year level options
                                    $year_lvl_query = "SELECT `year_lvl_id`, `year_lvl_name` FROM `year_lvl_tbl`";
                                    $year_lvl_result = $conn->query($year_lvl_query);

                                    if ($year_lvl_result && $year_lvl_result->num_rows > 0) {
                                        while ($row = $year_lvl_result->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($row['year_lvl_name']) . '">' . htmlspecialchars($row['year_lvl_name']) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Year Levels Available</option>';
                                    }
                                } catch (Exception $e) {
                                    echo '<option value="">Error loading Year Levels</option>';
                                }
                                ?>
                            </select>
                        </div>


                        <div class="input-container">
                            <label for="">Additional Info:</label>
                            <input type="text" name="additional_info">
                        </div>

                        <div class="input-container">
                            <label for="">Password:</label>
                            <input type="text" name="password" id="password" required>
                            <button class="btn" type="button" id="generate-password" onclick="generateRandomPassword()">Generate Password</button>
                        </div>

                        <script>
                            function generateRandomPassword() {
                                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                                let password = '';
                                for (let i = 0; i < 10; i++) {
                                    password += characters.charAt(Math.floor(Math.random() * characters.length));
                                }
                                document.getElementById('password').value = password;
                            }
                        </script>

                    </div>

                    <strong>Vital Signs:</strong>
                    <div class="input-mini-container">
                        <div class="input-container">
                            <label for="">Blood Pressure (#/# mmHg):</label>
                            <input type="text" name="blood_pressure">
                        </div>
                        <div class="input-container">
                            <label for="">Temperature (# °C):</label>
                            <input type="number" name="temperature">
                        </div>
                        <div class="input-container">
                            <label for="">Pulse Rate (# beat/min):</label>
                            <input type="text" name="pulse_rate">
                        </div>
                        <div class="input-container">
                            <label for="">Respiratory Rate (# breath/min):</label>
                            <input type="text" name="respiratory_rate">
                        </div>
                        <div class="input-container">
                            <label for="">Height (# meters):</label>
                            <input type="text" name="height">
                        </div>
                        <div class="input-container">
                            <label for="">Weight (# kg):</label>
                            <input type="text" name="weight">
                        </div>
                    </div>



                    <strong>Emergency Contact Information (atleast 1 is required):</strong>
                    <div class="input-mini-container">
                        <div class="input-container">
                            <label for="">Name (Person1):</label>
                            <input type="text" name="eperson1_name" required>
                        </div>
                        <div class="input-container">
                            <label for="">Phone:</label>
                            <input type="number" name="eperson1_phone" required>
                        </div>
                        <div class="input-container">
                            <label for="">Relationship:</label>
                            <input type="text" name="eperson1_relationship" required>
                        </div>
                    </div>
                    <div class="input-mini-container">
                        <div class="input-container">
                            <label for="">Name (Person2):</label>
                            <input type="text" name="eperson2_name">
                        </div>
                        <div class="input-container">
                            <label for="">Phone:</label>
                            <input type="number" name="eperson2_phone">
                        </div>
                        <div class="input-container">
                            <label for="">Relationship:</label>
                            <input type="text" name="eperson2_relationship">
                        </div>
                    </div>



                    <div class="input-mini-container">
                        <div class="input-container">
                            <label for="">Other health-related Information not listed above:</label>
                            <textarea name="health_record" id=""></textarea>
                        </div>


                    </div>

                </div>

                <div class="image-container">
                    <strong>Upload Image:</strong>
                    <div class="image-preview">

                    </div>
                    <input type="file" name="profile_picture" id="profile_picture" required>
                </div>

                <div class="button-container">
                    <a href="students.php"><i class="fa-solid fa-person-walking-arrow-loop-left"></i> Return</a>
                    <button type="submit" id="save-student"><i class="fa-solid fa-download"></i> Save</button>
                </div>
            </form>
        </main>

    </div>
</body>

</html>


<script>
    // Check for error and display SweetAlert
    const error = "<?php echo $error; ?>";
    if (error === "student_id_exists") {
        Swal.fire({
            icon: 'error',
            title: 'Duplicate Student ID',
            text: 'The Student ID is already taken. Please use a different one.',
            confirmButtonText: 'OK'
        });
    }
</script>




















<!-- for age and birthdate -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const birthdateInput = document.querySelector("input[name='birthdate']");
        const ageInput = document.querySelector("input[name='age']");

        birthdateInput.addEventListener("change", () => {
            const birthdate = new Date(birthdateInput.value);
            const today = new Date();
            let age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }
            ageInput.value = age;
        });
    });
</script>




<!-- for image preview and full screen -->
<script>
    // Select elements
    const fileInput = document.querySelector('.image-container input[type="file"]');
    const imagePreview = document.querySelector('.image-preview');

    // Function to handle image preview
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = () => {
                imagePreview.style.backgroundImage = `url(${reader.result})`;
                imagePreview.style.backgroundSize = 'cover';
                imagePreview.style.backgroundPosition = 'center';
                imagePreview.style.cursor = 'pointer';
            };
            reader.readAsDataURL(file);
        }
    });

    // Function to view image in fullscreen
    imagePreview.addEventListener('click', () => {
        if (imagePreview.style.backgroundImage) {
            const fullscreenContainer = document.createElement('div');
            fullscreenContainer.style.position = 'fixed';
            fullscreenContainer.style.top = '0';
            fullscreenContainer.style.left = '0';
            fullscreenContainer.style.width = '100%';
            fullscreenContainer.style.height = '100%';
            fullscreenContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            fullscreenContainer.style.display = 'flex';
            fullscreenContainer.style.alignItems = 'center';
            fullscreenContainer.style.justifyContent = 'center';
            fullscreenContainer.style.zIndex = '9999';

            const fullscreenImage = document.createElement('img');
            fullscreenImage.src = imagePreview.style.backgroundImage.slice(5, -2);
            fullscreenImage.style.maxWidth = '90%';
            fullscreenImage.style.maxHeight = '90%';
            fullscreenImage.style.borderRadius = '10px';

            fullscreenContainer.appendChild(fullscreenImage);
            document.body.appendChild(fullscreenContainer);

            fullscreenContainer.addEventListener('click', () => {
                document.body.removeChild(fullscreenContainer);
            });
        }
    });
</script>



<!-- end -->







<!-- style -->


<style>
    input,
    select {
        min-width: 250px;
    }
    textarea{
        min-width: 700px;
    }
</style>
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
    }

    .add-container {
        flex-grow: 1;
        background-color: var(--color4);
        border: 1px solid var(--border-color);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-y: scroll;
    }

    .add-container h2 {
        text-align: center;
        margin-bottom: 10px;
        color: var(--text-color);
    }



    .input-base-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-y: scroll;
        height: 200px;
    }

    .input-base-container strong {
        font-size: 1.3rem;
        margin-top: 10px;
        color: var(--text-color);
    }


    .input-mini-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
   
    }



    .input-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-top: 5px;
        flex-grow: 1;
    }

    .input-container label {
        color: var(--text-color);
    }




    .image-container {
        align-self: center;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .image-container strong {
        font: 1.2rem;
        color: var(--text-color);
    }

    .image-container .image-preview {
        padding: 10px;
        background-color: var(--background-color);
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 180px;
        max-width: 180px;
        height: 180px;
        max-height: 180px;
    }

    #profile_picture {
        background-color: transparent;
        border: 0;
    }

    .button-container {
        display: flex;
        align-items: center;
        justify-content: space-between;

    }

    .button-container a {
        text-decoration: none;
        font-size: 1.3rem;
        color: var(--text-color);
    }

    .button-container a:hover {
        color: var(--color1);
        transform: translateY(-2px);

    }

    .button-container button {
        padding: 5px 15px;
        font-size: 1.5rem;
        color: var(--text-color);
        background-color:transparent;
        border-radius: 5px;
        border: none;
        font-weight: bold;
    }

    .button-container button:hover {
        color: var(--color1);
        transform: translateY(-2px);
        transition: ease-in-out 0.3s;
       
    }

    /* @media (max-width: 1200px) {

 

    } */
</style>