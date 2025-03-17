<?php
require '../config/db_connect.php';
session_start();

// Check if admin is logged in, else redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}


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
                            <option value="<?php echo $row['year_lvl_name']; ?>"><?php echo $row['year_lvl_name']; ?>
                            </option>
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
                                <div class='button-container'>
                                 <button class='update-btn' onclick='showUpdateModal(\"{$row['student_id']}\", \"{$full_name}\", \"{$row['department']}\")'><i class='fa-solid fa-notes-medical'></i> Update Record</button>
                                 <a href='view_student.php?student_id={$row['student_id']}' class='action-btn'><i class='fa-solid fa-eye'></i> View Details</a>
                                </div>
                                 </div>
                        </div>";
                    }
                } else {
                    echo "<p>No students found.</p>";
                }
                ?>
            </div>

            <div class="footer-container">
                <label for="">Total Students: <span
                        id="total-students-label"><?php echo $total_students; ?></span></label>
                <a href="add_student.php"><i class="fa-solid fa-user-plus"></i> Add Student</a>
            </div>

        </main>
    </div>





</body>

</html>



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








<!-- Update Modal -->
<div id="update-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Update Record</h3>
        <form id="update-form" method="POST">
            <input type="hidden" id="student_id" name="student_id">

            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" readonly>

            <label for="student_department">Department:</label>
            <input type="text" id="student_department" name="student_department" readonly>

            <label for="chief_complaint">Chief Complaint:</label>
            <textarea id="chief_complaint" name="chief_complaint" required oninput="debouncedSuggestion();"></textarea>

            <small id="ai-suggestion" style="display: block; font-size: 12px; color: gray; margin-bottom:10px;"></small>
            <small id="complaint-suggestion"
                style="display: block; font-size: 12px; color: #EB5704; margin-bottom:5px;"></small>

            <!-- Info, Symptoms, Prevention, Recommended Medicine Sections -->
            <div id="ai-info-container" style="display:none; margin-bottom: 15px; color: var(--text-color2);">
                <h4>Details:</h4>
                <p><strong>Info:</strong> <span id="ai-info"></span></p>
                <p><strong>Symptoms:</strong> <span id="ai-symptoms"></span></p>
                <p><strong>Prevention:</strong> <span id="ai-prevention"></span></p>
                <p><strong>Recommended Medicine:</strong> <span id="ai-medicine"></span></p> <!-- Added this line -->
            </div>


            <label for="treatment">Treatment (AI Assisted Suggestion):</label>
            <textarea id="treatment" name="treatment" required></textarea>

            <!-- Loading Indicator -->
            <div id="loading-indicator" style="display: none; font-size: 12px; color: blue;">
                🔄 Fetching AI suggestion...
            </div>

            <button type="submit"><i class="fa-solid fa-file-arrow-up"></i> Save Record</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let debounceTimer;

    function debouncedSuggestion() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(getTreatmentSuggestion, 1000); // Delay API call by 1 second
    }

    function getTreatmentSuggestion() {
        const chiefComplaintField = document.getElementById('chief_complaint');
        const chiefComplaint = chiefComplaintField.value.trim();
        const treatmentField = document.getElementById('treatment');
        const suggestionBox = document.getElementById('ai-suggestion');
        const loadingIndicator = document.getElementById('loading-indicator');

        // AI Info Fields
        const aiInfoContainer = document.getElementById('ai-info-container');
        const aiInfo = document.getElementById('ai-info');
        const aiSymptoms = document.getElementById('ai-symptoms');
        const aiPrevention = document.getElementById('ai-prevention');
        const aiMedicine = document.getElementById('ai-medicine'); // Added for recommended medicine

        if (chiefComplaint.length < 3) {
            suggestionBox.innerHTML = "";
            treatmentField.value = "";
            loadingIndicator.style.display = "none";
            aiInfoContainer.style.display = "none";
            return;
        }

        suggestionBox.innerHTML = "";
        treatmentField.value = "";
        loadingIndicator.style.display = "block";

        fetch('ai_suggest.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ complaint: chiefComplaint })
        })
            .then(response => response.json())
            .then(data => {
                console.log("AI Response:", data);  // 🔍 Debugging: Check API Response

                loadingIndicator.style.display = "none";

                if (data.suggestions && data.suggestions.length > 0) {
                    suggestionBox.innerHTML = "Did you mean: ";
                    data.suggestions.forEach(suggestion => {
                        let suggestionElement = document.createElement("span");
                        suggestionElement.innerText = suggestion;
                        suggestionElement.style.cursor = "pointer";
                        suggestionElement.style.color = "blue";
                        suggestionElement.style.marginRight = "10px";
                        suggestionElement.style.textDecoration = "underline";
                        suggestionElement.onclick = function () {
                            chiefComplaintField.value = suggestion;
                            getTreatmentSuggestion();
                        };
                        suggestionBox.appendChild(suggestionElement);
                    });
                } else {
                    suggestionBox.innerText = "No similar complaints found.";
                }

                treatmentField.value = data.treatment || "No AI suggestion available.";

                // ✅ Ensure AI Info, Symptoms, and Prevention are displayed
                if (data.information || data.symptoms || data.prevention) {
                    console.log("Info:", data.information);
                    console.log("Symptoms:", data.symptoms);
                    console.log("Prevention:", data.prevention);
                    console.log("Medicine:", data.medicine); // Debugging for medicine

                    aiInfo.innerText = data.information || "No information available.";
                    aiSymptoms.innerText = data.symptoms || "No symptoms listed.";
                    aiPrevention.innerText = data.prevention || "No prevention steps available.";
                    aiMedicine.innerText = data.medicine || "No recommended medicine."; // Display recommended medicine
                    aiInfoContainer.style.display = "block";  // ✅ Ensure section is visible
                } else {
                    aiInfoContainer.style.display = "none";   // ✅ Hide if no data is available
                }
            })
            .catch(error => {
                console.error('AI Error:', error);
                suggestionBox.innerText = "AI service unavailable.";
                loadingIndicator.style.display = "none";
            });
    }


    function showUpdateModal(studentId, fullName, department) {
        document.getElementById('student_id').value = studentId;
        document.getElementById('student_name').value = fullName;
        document.getElementById('student_department').value = department;
        document.getElementById('update-modal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('update-modal').style.display = 'none';
    }

    document.getElementById('update-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        fetch('insert_record.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text();
                }
            })
            .then(data => {
                if (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data || 'An unexpected error occurred. Please try again.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please check your connection.'
                });
            });
    });
</script>





<style>
    /* Modal Background */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        overflow: auto;
    }

    /* Modal Content Box */
    .modal-content {
        top: 10%;
        left: 40%;
        background-color: var(--background-color);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 500px;
        padding: 20px;
        animation: fadeIn 0.3s ease-out;
        position: relative;
        overflow: auto;
    }

    /* Close Button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        font-weight: bold;
        color: #555;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-btn:hover {
        color: #000;
    }

    /* Form Elements */
    .modal-content h3 {
        margin-top: 0;
        font-size: 2rem;
        text-align: center;
        color: var(--text-color);
        margin-bottom: 20px;
    }

    .modal-content label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: var(--text-color);
        font-size: 1.2rem;
    }

    .modal-content input,
    .modal-content textarea,
    .modal-content button {
        width: 100%;
        padding: 8px;
        color: var(--text-color);
        background-color: var(--background-color2);
        border: 0;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 10px;

    }

    .modal-content input:focus,
    .modal-content textarea:focus {
        background-color: var(--background-color2);
        color: var(--color1);
        border: 0;
        border-bottom: 1px solid var(--color1);
        outline: none;
    }

    .modal-content textarea {
        resize: vertical;
        min-height: 50px;
    }

    /* Submit Button */
    .modal-content button {
        background-color: var(--color3b);
        color: white;
        border: none;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .modal-content button:hover {
        background-color: var(--color3);
    }

    /* Fade-in Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Mobile Responsiveness */
    @media (max-width: 600px) {}
</style>





<style>
    .search-container {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        background-color: var(--color4);
        padding: 10px;

        border-bottom: 0;
        border-top: 0;

    }





    .footer-container {
        padding: 10px;
        background-color: var(--color4);
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;

        border-top: 0;

    }

    .footer-container label {
        font-size: 1.2rem;
        color: var(--text-color);
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
        width: 250px;
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
        text-align: start;
    }

    .card-content h3 {
        margin: 10px 0;
        font-size: 1.2rem;
        color: var(--text-color);
    }

    .card-content p {
        margin: 5px 0;
        font-size: .9rem;
        color: var(--text-color2);

    }

    .button-container {
        display: flex;
        gap: 5px;
    }

    .button-container a {
        display: inline-block;
        margin-top: 10px;
        padding: 10px;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }



    .update-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 5px;
        font-size: 1rem;
        color: white;
        border-radius: 5px;
        text-decoration: none;

        transition: background-color 0.3s ease, transform 0.2s ease;
        background-color: var(--color3b);
        border: transparent;
    }

    .update-btn:hover {
        background-color: var(--color3);
        transform: translateY(-2px);
    }

    .action-btn {
        background-color: var(--color1);

    }

    .action-btn:hover {
        background-color: var(--color1b);
        transform: translateY(-2px);
    }
</style>









<!-- for sweet alert messages -->
<?php
// Check for success in the URL
$success = isset($_GET['success']) ? $_GET['success'] : '';

?>
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


<script>
    // Check for the status parameter in the URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'update_success') {
        Swal.fire({
            icon: 'success',
            title: 'Update Successful',
            text: 'Student details have been updated successfully!',
            confirmButtonText: 'OK'
        }).then(() => {
            // Optionally redirect or clear the query parameter
            history.replaceState(null, '', window.location.pathname);
        });
    }
</script>

<script>
    // Check for the status parameter in the URL
    const urlParams2 = new URLSearchParams(window.location.search);
    if (urlParams2.get('status') === 'delete_success') {
        Swal.fire({
            icon: 'success',
            title: 'Delete Successful',
            text: 'Student have been deleted successfully!',
            confirmButtonText: 'OK'
        }).then(() => {
            // Optionally redirect or clear the query parameter
            history.replaceState(null, '', window.location.pathname);
        });
    }
</script>