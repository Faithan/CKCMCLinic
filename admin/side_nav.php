<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>



<!-- Sidebar -->
<div class="sidebar">

    <div class="sidebar-header">
        <img src="../system_images/ckcm_logo.png" alt="CKCM Logo" class="logo">
        <h2 class="gradient-text">Clinic | CKCM, Inc. <em style="color:#d0d0d0; font-size:1rem;">v.1</em></h2>
    </div>


    <div class="sidebar-menu">

        <div>
            <div class="mini-menu">
                <label for="">Home</label>
                <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa-solid fa-chart-simple"></i> Dashboard</a>
                <a href="reports.php" class="<?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>"><i class="fa-solid fa-chart-pie"></i> Reports</a>
            </div>

            <div class="mini-menu">
                <label for="">Operation</label>
                <a href="appointments.php" class="<?php echo ($current_page == 'appointments.php') ? 'active' : ''; ?>"><i class="fa-solid fa-calendar-day"></i> Appointments</a>
                <a href="students.php" class="<?php echo ($current_page == 'students.php') ? 'active' : ''; ?>"><i class="fa-solid fa-user-graduate"></i> Students</a>
            </div>

            <div class="mini-menu">
                <label for="">Extra</label>
                <a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"><i class="fa-solid fa-gears"></i> Settings</a>

            </div>
        </div>



        <a class="logout-btn" id="logout-btn" href="#"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i> Logout</a>





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

    </div>




</div>















<style>

    .mini-menu a.active {
        background-color: #0F172A;
        color: var(--color4);
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
        border-right: 1px solid var(--border-color);

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
</style>