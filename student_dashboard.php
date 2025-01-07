<?php
require 'config/db_connect.php';
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="system_images/ckcm_logo.png" type="image/x-icon">
    <title>Student Dashboard | CKCM Clinic</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">

</head>

<body>
    <!-- fontawesome -->
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="fontawesome/css/brands.css" rel="stylesheet" />
    <link href="fontawesome/css/solid.css" rel="stylesheet" />


    <!-- sweetalert -->
    <script src="js/sweetalert.js"></script>
    <!-- Header Section -->
    <header>

        <div class="header-container">
            <img src="system_images/ckcm_logo.png" alt="CKCM Clinic Logo" class="logo">
            <h1 class="gradient-text" style="font-size:1.5rem">Clinic | CKCM, Inc. <em style="color:#d0d0d0; font-size:1rem">v.1</em></h1>
        </div>
        <div class="burger-menu" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <ul class="nav-links">
            <li><a href="student_dashboard.php#profile">Profile</a></li>
            <li><a href="student_dashboard.php#records">Records</a></li>
            <li><a href="student_logout.php">Logout</a></li>
        </ul>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Overview Section -->
        <section class="profile-overview" id="profile">

            <div class="profile-container">
                <div class="profile-pic">
                    <img src="student_pic/<?php echo $_SESSION['profile_picture'] ?>" alt="">
                    <label for=""><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name'] . ' ' . $_SESSION['extension'] ?></label>
                    <p>Student ID: <?php echo $_SESSION['student_id']; ?></p>
                </div>
                <div class="vital-signs-container">
                    <div class="vital-signs">
                        <label for="">Blood Pressure</label>
                        <i></i>
                        <p><?php echo $_SESSION['blood_pressure'] ?> mmHg</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Temperature</label>
                        <i></i>
                        <p><?php echo $_SESSION['temperature'] ?> °C</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Pulse Rate</label>
                        <i></i>
                        <p><?php echo $_SESSION['pulse_rate'] ?> beat/min</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Respiratory Rate</label>
                        <i></i>
                        <p><?php echo $_SESSION['respiratory_rate'] ?> breath/min</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Height</label>
                        <i></i>
                        <p><?php echo $_SESSION['height'] ?> meters</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Weight</label>
                        <i></i>
                        <p><?php echo $_SESSION['weight'] ?> kg</p>
                    </div>
                </div>
                <style>
                    .vital-signs-container {
                        padding: 20px;
                        background-color: var(--color4);
                        display: flex;
                        gap: 20px;
                    }
                </style>

                <div class="student-info">

                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-envelope"></i> Email</label>
                        <p><?php echo $_SESSION['email'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-venus-mars"></i> Gender</label>
                        <p><?php echo $_SESSION['gender'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-cake-candles"></i> Birthdate</label>
                        <p><?php echo $_SESSION['birthdate'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-heart"></i> Age</label>
                        <p><?php echo $_SESSION['age'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-map-location-dot"></i> Birth Place</label>
                        <p><?php echo $_SESSION['birth_place'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-heart"></i> Marital Status</label>
                        <p><?php echo $_SESSION['marital_status'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-map-location-dot"></i> Address</label>
                        <p><?php echo $_SESSION['address'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-hands-praying"></i> Religion</label>
                        <p><?php echo $_SESSION['religion'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-building"></i> Department</label>
                        <p><?php echo $_SESSION['department'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-building-user"></i> Year Level</label>
                        <p><?php echo $_SESSION['year_level'] ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-info"></i> Additional Info</label>
                        <p><?php echo !empty($_SESSION['additional_info']) ? $_SESSION['additional_info'] : 'N/A'; ?></p>
                    </div>
                </div>
            </div>




            <div class="vitalSigns-container">

            </div>

        </section>
        <section class="record-overview" id="records">

        </section>
    </main>

    <!-- Footer Section -->
    <footer class="dashboard-footer">
        <p>&copy; <?php echo date("Y"); ?> CKCM Clinic. All rights reserved.</p>
    </footer>

    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            const burgerMenu = document.querySelector('.burger-menu');

            navLinks.classList.toggle('active');
            burgerMenu.classList.toggle('open');
        }
    </script>
</body>

</html>



<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: #333;
        display: flex;
        flex-direction: column;
    }

    header {
        background-color: var(--color3b);
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-container {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    img.logo {
        height: 30px;
    }

    .burger-menu {
        display: block;
        cursor: pointer;
    }

    .burger-menu div {
        width: 25px;
        height: 3px;
        background-color: white;
        margin: 5px 0;
        transition: 0.3s;
    }

    .burger-menu.open div:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .burger-menu.open div:nth-child(2) {
        opacity: 0;
    }

    .burger-menu.open div:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    .nav-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: none;
        flex-direction: column;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: var(--color3b);
        width: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .nav-links.active {
        display: flex;
    }

    .nav-links li {
        text-align: center;
    }

    .nav-links li a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        padding: 15px;
        display: block;
        transition: background-color 0.3s;
    }

    .nav-links li a:hover {
        background-color: var(--color3);
    }






    .profile-overview {
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        background-color: var(--background-color);
    }

    .profile-pic {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        background-color: var(--color4);
        padding: 20px;
    }

    .profile-pic img {
        margin-bottom: 10px;
        height: 100px;
        width: 100px;
        border-radius: 50%;
        padding: 12px;
        background-image: linear-gradient(to bottom right, #EB5704, #0F172A, #EB5704);
        -webkit-clip-path: polygon(50% 0%, 80% 10%, 100% 35%, 100% 65%, 80% 90%, 50% 100%, 20% 90%, 0 65%, 0 35%, 20% 10%);
        clip-path: polygon(50% 0%, 80% 10%, 100% 35%, 100% 65%, 80% 90%, 50% 100%, 20% 90%, 0 65%, 0 35%, 20% 10%);
    }

    .profile-pic label {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--color1)
    }

    .profile-pic p {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--text-color2)
    }


    .student-info {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 30px;

        background-color: var(--color4);
        padding: 20px;
    }

    .info-container {
        display: flex;
        flex-direction: column;
        gap: 5px;


    }

    .info-container label {
        font-weight: bold;
        font-size: 1.3rem;
    }

    .info-container p {
        font-size: 1.2rem;
    }











    .dashboard-footer {
        background-color: black;
        color: white;
        text-align: center;
        padding: 10px 20px;
        position: relative;
        bottom: 0;
        width: 100%;

    }












    @media (min-width: 768px) {
        .burger-menu {
            display: none;
        }

        .nav-links {
            display: flex;
            flex-direction: row;
            position: static;
            box-shadow: none;
            width: auto;
        }

        .nav-links li {
            text-align: left;
        }

        .nav-links li a {
            padding: 8px 16px;
        }



    }
</style>