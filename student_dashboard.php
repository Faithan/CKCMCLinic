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
    <?php include 'nav.php'; ?>
    <!-- Main Content -->
    <main>
        <!-- Overview Section -->
        <section class="profile-overview" id="profile">
            <div class="profile-container">

                <div class="profile-pic">
                    <img id="profilePicture" src="student_pic/<?php echo $_SESSION['student']['profile_picture']; ?>" alt="Profile Picture">
                    <label for=""><?php echo $_SESSION['student']['first_name'] . ' ' . $_SESSION['student']['middle_name'] . ' ' . $_SESSION['student']['last_name'] . ' ' . $_SESSION['student']['extension']; ?></label>
                    <p>Student ID: <?php echo $_SESSION['student']['student_id']; ?></p>
                </div>

                <!-- Fullscreen Image Modal -->
                <div id="fullscreenModal" class="fullscreen-modal">
                    <span class="close-button" id="closeModal">&times;</span>
                    <img class="fullscreen-image" id="fullscreenImage" src="">
                </div>

                <script>
                    const profilePicture = document.getElementById('profilePicture');
                    const fullscreenModal = document.getElementById('fullscreenModal');
                    const fullscreenImage = document.getElementById('fullscreenImage');
                    const closeModal = document.getElementById('closeModal');

                    // Open modal with fullscreen image
                    profilePicture.addEventListener('click', () => {
                        fullscreenImage.src = profilePicture.src;
                        fullscreenModal.style.display = 'flex';
                    });

                    // Close modal
                    closeModal.addEventListener('click', () => {
                        fullscreenModal.style.display = 'none';
                    });

                    // Close modal when clicking outside the image
                    fullscreenModal.addEventListener('click', (event) => {
                        if (event.target === fullscreenModal) {
                            fullscreenModal.style.display = 'none';
                        }
                    });
                </script>
                <style>
                    /* Fullscreen Modal Styles */
                    .fullscreen-modal {
                        display: none;
                        position: fixed;
                        z-index: 1000;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.8);
                        justify-content: center;
                        align-items: center;
                    }

                    .fullscreen-image {
                        max-width: 90%;
                        max-height: 90%;
                        border: 5px solid white;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
                    }

                    .close-button {
                        position: absolute;
                        top: 10px;
                        right: 20px;
                        font-size: 30px;
                        color: white;
                        cursor: pointer;
                        font-weight: bold;
                    }

                    .close-button:hover {
                        color: red;
                    }
                </style>

                <div class="vital-signs-container">
                    <div class="vital-signs">
                        <label for="">Blood Pressure</label>
                        <i class="fas fa-heartbeat"></i>
                        <p><?php echo $_SESSION['student']['blood_pressure']; ?> mmHg</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Temperature</label>
                        <i class="fas fa-thermometer-half"></i>
                        <p><?php echo $_SESSION['student']['temperature']; ?> °C</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Pulse Rate</label>
                        <i class="fas fa-heart"></i>
                        <p><?php echo $_SESSION['student']['pulse_rate']; ?> beat/min</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Respiratory Rate</label>
                        <i class="fas fa-wind"></i>
                        <p><?php echo $_SESSION['student']['respiratory_rate']; ?> breath/min</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Height</label>
                        <i class="fas fa-ruler-vertical"></i>
                        <p><?php echo $_SESSION['student']['height']; ?> meters</p>
                    </div>
                    <div class="vital-signs">
                        <label for="">Weight</label>
                        <i class="fas fa-weight"></i>
                        <p><?php echo $_SESSION['student']['weight']; ?> kg</p>
                    </div>
                </div>

                <div class="student-info">
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-envelope"></i> Email</label>
                        <p><?php echo $_SESSION['student']['email']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-venus-mars"></i> Gender</label>
                        <p><?php echo $_SESSION['student']['gender']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-cake-candles"></i> Birthdate</label>
                        <p><?php echo $_SESSION['student']['birthdate']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-heart"></i> Age</label>
                        <p><?php echo $_SESSION['student']['age']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-map-location-dot"></i> Birth Place</label>
                        <p><?php echo $_SESSION['student']['birth_place']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-heart"></i> Marital Status</label>
                        <p><?php echo $_SESSION['student']['marital_status']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-map-location-dot"></i> Address</label>
                        <p><?php echo $_SESSION['student']['address']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-hands-praying"></i> Religion</label>
                        <p><?php echo $_SESSION['student']['religion']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-building"></i> Department</label>
                        <p><?php echo $_SESSION['student']['department']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-building-user"></i> Year Level</label>
                        <p><?php echo $_SESSION['student']['year_level']; ?></p>
                    </div>
                    <div class="info-container">
                        <label for=""><i class="fa-solid fa-info"></i> Additional Info</label>
                        <p><?php echo !empty($_SESSION['student']['additional_info']) ? $_SESSION['student']['additional_info'] : 'N/A'; ?></p>
                    </div>
                    <div class="info-container">
                        <label for="">Other Health Related information</label>
                        <p><?php echo !empty($_SESSION['student']['health_record']) ? $_SESSION['student']['additional_info'] : 'N/A'; ?></p>
                    </div>
                </div>
            </div>

            <div class="record-overview" id="records">
                <!-- Add records content here -->
                <div class="record-header">
                    <h2>Records</h2>
                    <!-- <a href=""><i class="fa-solid fa-bell-concierge"></i> Request Appointment</a> -->
                </div>
                <div class="record-container">

                </div>
            </div>

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









    main {
        background-color: #E7E9EB;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='250' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.03'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/svg%3E");
    }

    .profile-overview {
        padding: 20px;


    }

    .profile-pic {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        background-color: var(--color4);
        padding: 20px;
        border-radius: 5px;
        background-color: #F8FAFC;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 900'%3E%3Cdefs%3E%3ClinearGradient id='a' x1='0' x2='0' y1='1' y2='0' gradientTransform='rotate(0,0.5,0.5)'%3E%3Cstop offset='0' stop-color='%230F172A'/%3E%3Cstop offset='1' stop-color='%23EBB009'/%3E%3C/linearGradient%3E%3ClinearGradient id='b' x1='0' x2='0' y1='0' y2='1' gradientTransform='rotate(0,0.5,0.5)'%3E%3Cstop offset='0' stop-color='%23EB5704'/%3E%3Cstop offset='1' stop-color='%23EBB009'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg fill='%23FFF' fill-opacity='0' stroke-miterlimit='10'%3E%3Cg stroke='url(%23a)' stroke-width='3.3'%3E%3Cpath transform='translate(-57.4 -2) rotate(-5.300000000000001 1409 581) scale(0.9392180000000001)' d='M1409 581 1450.35 511 1490 581z'/%3E%3Ccircle stroke-width='1.1' transform='translate(-89.5 49) rotate(1.1999999999999993 800 450) scale(0.9978569999999999)' cx='500' cy='100' r='40'/%3E%3Cpath transform='translate(0.9000000000000021 -25.5) rotate(-1.5 401 736) scale(0.9978569999999999)' d='M400.86 735.5h-83.73c0-23.12 18.74-41.87 41.87-41.87S400.86 712.38 400.86 735.5z'/%3E%3C/g%3E%3Cg stroke='url(%23b)' stroke-width='1'%3E%3Cpath transform='translate(294 7.399999999999999) rotate(-1.8499999999999996 150 345) scale(1.004406)' d='M149.8 345.2 118.4 389.8 149.8 434.4 181.2 389.8z'/%3E%3Crect stroke-width='2.2' transform='translate(-47.5 -136) rotate(-18 1089 759)' x='1039' y='709' width='100' height='100'/%3E%3Cpath transform='translate(-142.8 33.2) rotate(-3 1400 132) scale(0.865)' d='M1426.8 132.4 1405.7 168.8 1363.7 168.8 1342.7 132.4 1363.7 96 1405.7 96z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        background-size: cover;
        border: 1px solid var(--border-color);
        animation: fadeIn 0.6s ease-in-out;
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
        color: var(--color1);
    }

    .profile-pic p {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--text-color2);
    }


    .student-info {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 10px 40px;
        background-color: var(--color4);
        padding: 20px;
        border-radius: 5px;
        border: 1px solid var(--border-color);
    }

    .info-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        width: 200px;
        animation: fadeIn 0.6s ease-in-out;
    }

    .info-container label {
        font-weight: bold;
        font-size: 1.3rem;
        color: var(--text-color);
    }

    .info-container p {
        font-size: 1.2rem;
        color: var(--text-color)
    }



    .record-overview {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        gap: 10px 40px;
        background-color: var(--color4);
        padding: 20px;
        border-radius: 5px;
        border: 1px solid var(--border-color);
        animation: fadeIn 0.6s ease-in-out;
    }


    .record-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .record-header a {
        text-decoration: none;
        font-size: 1.2rem;
        color: var(--text-color);
    }

    .record-header a:hover {
        transform: translateY(-2px);
        transition: ease-in-out;
        color: var(--color1);
    }

    .record-container {
        height: 200px;
        overflow-y: scroll;
        background-color: var(--background-color);
    }








    .dashboard-footer {
        background-color: var(--color3);
        color: var(--color4);
        text-align: center;
        padding: 10px 20px;
        position: relative;
        bottom: 0;
        width: 100%;

    }














    @media (max-width: 768px) {

        .profile-overview {
            padding: 0;
        }

        .profile-pic {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: flex-end;
            background-image: url(student_pic/<?php echo $_SESSION['student']['profile_picture'] ?>);
            background-position: center 1%;
            background-repeat: no-repeat;
            background-size: cover;
            height: 300px;
            box-shadow: rgba(0, 0, 0, 0.55) 0px -50px 40px -28px inset;
            padding: 10px;
        }

        .profile-pic img {
            display: none;
        }

        .profile-pic label {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--color1);

            width: 100%;
            text-align: center;
        }

        .profile-pic p {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--color4);

            width: 100%;
            text-align: center;
        }

        .student-info {
            justify-content: center;
        }

        .info-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 120px;

        }

    }
</style>


















<style>
    .vital-signs-container {
        padding: 20px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
        animation: fadeIn 0.6s ease-in-out;
    }

    .vital-signs {
        background-color: var(--color4);
        border-radius: 10px;
        padding: 20px;
        width: 150px;
        text-align: center;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        transition: transform 0.3s, box-shadow 0.3s;
        animation: fadeIn 0.6s ease-in-out;
    }

    .vital-signs:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }

    .vital-signs label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
        font-size: 1.1rem;
        color: var(--color1);
    }

    .vital-signs i {
        font-size: 2rem;
        margin: 10px 0;
        color: var(--color3);
    }

    /* Add unique animations to each icon */
    .vital-signs:nth-child(1) i {
        animation: heartbeat 1.5s infinite ease-in-out;
        color: red;
    }

    .vital-signs:nth-child(2) i {
        animation: swing 2s infinite linear;
    }

    .vital-signs:nth-child(3) i {
        animation: heartbeat 1.2s infinite ease-in-out;
        color: red;
    }

    .vital-signs:nth-child(4) i {
        animation: float 3s infinite ease-in-out;
        color: gray;
    }

    .vital-signs:nth-child(5) i {
        animation: scale-up 2s infinite alternate;
        color: #d8874d;
    }

    .vital-signs:nth-child(6) i {
        animation: swing 1.5s infinite ease-in-out;
        color: gray;
    }

    /* Keyframes for animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes heartbeat {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes scale-up {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.2);
        }
    }

    @keyframes swing {

        0%,
        100% {
            transform: rotate(0deg);
        }

        50% {
            transform: rotate(10deg);
        }
    }
</style>