<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>



<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <img src="../system_images/ckcm_logo.png" alt="CKCM Logo" class="logo">
        <h2 class="gradient-text">Clinic | CKCM, Inc. <em style="color:#d0d0d0; font-size:1rem;">v.1</em></h2>
    </div>


    <div class="sidebar-menu">

        <div>
            <div class="mini-menu">
                <label for="">Home</label>
                <a href="dashboard.php" title="dashboard" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa-solid fa-chart-simple"></i> <span>Dashboard</span></a>


                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" title="Documents">
                        <i class="fa-solid fa-folder-open" ></i><span>Documents</span> <i class="fa-solid fa-chevron-down dropdown-icon" style="margin-left:20px;"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="student_reports.php" title="Student Documents" class="<?php echo ($current_page == 'student_reports.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-file"></i> <span>Student Documents</span>
                        </a>
                        <a href="record_reports.php" title="Record Documents" class="<?php echo ($current_page == 'record_reports.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-paste"></i> <span>Record Document</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mini-menu">
                <label for="">Operation</label>
                <a href="students.php" title="Students" class="<?php echo ($current_page == 'students.php') ? 'active' : ''; ?>"><i class="fa-solid fa-user-graduate"></i> <span>Students</span></a>
                <a href="records.php" title="Records" class="<?php echo ($current_page == 'records.php') ? 'active' : ''; ?>"><i class="fa-solid fa-clipboard"></i> <span>Records</span></a>
                <a href="course_settings.php" title="Courses" class="<?php echo ($current_page == 'course_settings.php') ? 'active' : ''; ?>"><i class="fa-solid fa-building"></i> <span>Courses</span></a>
                <a href="medicines.php" title="Medicines" class="<?php echo ($current_page == 'medicines.php') ? 'active' : ''; ?>"><i class="fa-solid fa-pills"></i> <span>Medicines</span></a>
            </div>

            <div class="mini-menu">
                <label for="">Settings</label>

                <a href="admin_settings.php" title="Admin" class="<?php echo ($current_page == 'admin_settings.php') ? 'active' : ''; ?>"><i class="fa-solid fa-gears"></i> <span>Admin</span></a>
          
            </div>
        </div>


        <a class="logout-btn" id="logout-btn" href="#"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i> <span>Logout</span></a>
    </div>
</div>




<script>
    document.getElementById('logout-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your session.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the logout page
                window.location.href = 'logout.php';
            }
        });
    });
</script>




<style>
    .sidebar.collapsed .sidebar-header h2,
    .sidebar.collapsed .mini-menu label,
    .sidebar.collapsed .logout-btn span,
    .sidebar.collapsed .mini-menu a span {
        display: none;
    }

    .sidebar.collapsed .mini-menu .dropdown-menu {
        margin: 0;
        padding: 0;
    }

    .sidebar.collapsed .sidebar-header img{
        width: 25px;
        height: 25px;
    }

    /* Tooltip Styles */
    .sidebar.collapsed [title] {
        position: relative;
    }

    .sidebar.collapsed [title]:hover::after {
        content: attr(title);
        position: absolute;
        top: 120%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        white-space: nowrap;
        z-index: 10;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }
</style>












<style>
    /* Dropdown styling */
    .dropdown {
        display: flex;
        flex-direction: column;
        position: relative;


    }

    .dropdown-toggle {
        text-decoration: none;
        font-size: 1.4rem;
        color: #d0d0d0;
        padding: 10px;
        display: flex;
        align-items: center;

        cursor: pointer;
    }

    .dropdown-toggle:hover {
        background-color: var(--text-hover);
        color: #F8FAFC;
        transition: ease-in-out 0.3s;
        border-radius: 5px;
    }

    /* Dropdown Icon */
    .dropdown-icon {
        transition: transform 0.3s ease-in-out;
    }

    /* Hidden by default */
    .dropdown-menu {
        display: none;
        flex-direction: column;
        padding-left: 20px;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.3s ease-in-out;
    }

    .dropdown-menu a {
        text-decoration: none;
        font-size: 1.2rem;
        color: #d0d0d0;
        padding: 8px;
    }

    .dropdown-menu a:hover {
        background-color: var(--text-hover);
        color: #F8FAFC;
        transition: ease-in-out 0.3s;
        border-radius: 5px;
    }

    /* Show dropdown when active */
    .dropdown.active .dropdown-menu {
        display: flex;
        max-height: 200px;
    }

    /* Rotate dropdown icon */
    .dropdown.active .dropdown-icon {
        transform: rotate(180deg);
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownToggle = document.querySelector(".dropdown-toggle");
        const dropdown = document.querySelector(".dropdown");

        dropdownToggle.addEventListener("click", function(e) {
            e.preventDefault();
            dropdown.classList.toggle("active");
        });
    });
</script>











<style>
    .mini-menu a.active {
        background-color: #0F172A;
        color: #f5f5f5;
        border-radius: 5px;
    }


    /* Sidebar Styling */
    .sidebar {
        width: 280px;
        background-color: #1E293B;
        top: 0;
        left: 0;
        padding: 10px;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--backgroud-color2);
        transition: ease-in-out 0.3s;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        margin: 10px 0 40px 0;
        gap: 10px;
    }

    .sidebar-header .logo {
        width: 30px;
        height: 30px;
    }

    .sidebar-header h2 {
        font-size: 1.5rem;
        font-weight: bold;

    }


    .gradient-text {
        background-image: linear-gradient(to right, #EB5704, #f7971e, #EB5704);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .sidebar-menu {
        display: flex;
        flex-direction: column;
        list-style-type: none;
        justify-content: space-between;
        gap: 20px;
        height: 100%;
    }

    .mini-menu {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
        padding-bottom: 20px;
        gap: 2px;
    }

    .mini-menu label {
        font-size: 1.1rem;
        color: #ddd;

        text-transform: uppercase;
        margin-bottom: 10px;
    }


    .mini-menu a {
        text-decoration: none;
        font-size: 1.4rem;
        color: #d0d0d0;
        padding: 10px;
    }

    .mini-menu a:hover {
        background-color: var(--text-hover);
        color: #F8FAFC;
        transition: ease-in-out 0.3s;
        border-radius: 5px;
    }


    .mini-menu a i {
        margin-right: 5px;
    }


    .logout-btn {
        text-decoration: none;
        font-size: 1.4rem;

        color: #d0d0d0;
        padding: 10px;
    }

    .logout-btn:hover {
        background-color: var(--text-hover);
        color: #F8FAFC;
        transition: ease-in-out 0.3s;
        border-radius: 5px;
    }

    .logout-btn i {
        margin-right: 5px;
    }
















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
</style>