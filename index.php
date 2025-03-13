<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="system_images/ckcm_logo.png" type="image/x-icon">
    <title>Student Login | CKCM Clinic</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap"
        rel="stylesheet">

</head>

<body>

    <div class="login-container">
        <img src="system_images/ckcm_logo.png" alt="CKCM Clinic Logo">
        <h1>Clinic | CKCM, Inc.</h1>
        <p>Please login to access your student account.</p>
        <form action="student_login_process.php" method="POST" onsubmit="showLoadingScreen()">
            <input type="number" name="student_id" placeholder="Student School ID" required>
            <input type="password" name="password" placeholder="Password" required>

            <div style="color:red;">
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="error-message">
                        <?php
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']); // Clear the error message after displaying it
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Loading Screen -->
    <div class="loading-overlay" id="loadingOverlay">
        <div style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
            <div class="lds-heart">
                <div></div>
            </div>
            <div class="loading-message">Loading, please wait...</div>
        </div>
    </div>

    <script>
        function showLoadingScreen() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
    </script>

    <style>
        /* Loading screen styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Heart-shaped loader styles */
        .lds-heart,
        .lds-heart div,
        .lds-heart div:after,
        .lds-heart div:before {
            box-sizing: border-box;
        }

        .lds-heart {
            display: inline-block;
            position: relative;
            width: 120px;
            height: 120px;
            transform: rotate(45deg);
            transform-origin: 60px 60px;
        }

        .lds-heart div {
            top: 40px;
            left: 40px;
            position: absolute;
            width: 48px;
            height: 48px;
            background: red;
            animation: lds-heart 1.2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        .lds-heart div:after,
        .lds-heart div:before {
            content: " ";
            position: absolute;
            display: block;
            width: 48px;
            height: 48px;
            background: red;
        }

        .lds-heart div:before {
            left: -36px;
            border-radius: 50% 0 0 50%;
        }

        .lds-heart div:after {
            top: -36px;
            border-radius: 50% 50% 0 0;
        }

        @keyframes lds-heart {
            0% {
                transform: scale(0.95);
            }

            5% {
                transform: scale(1.1);
            }

            39% {
                transform: scale(0.85);
            }

            45% {
                transform: scale(1);
            }

            60% {
                transform: scale(0.95);
            }

            100% {
                transform: scale(0.9);
            }
        }

        /* Text message below the heart */
        .loading-message {
            margin-top: 20px;
            color: white;
            font-size: 1.4rem;
            font-weight: 500;
        }
    </style>

</body>

</html>




<style>
    body {
        font-family: Arial, sans-serif;
        /* background: linear-gradient(to bottom,  #F8FAFC, #EB5704); */
        background-color: #ffffff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='0' x2='0' y1='0' y2='100%25' gradientTransform='rotate(0,800,368)'%3E%3Cstop offset='0' stop-color='%23ffffff'/%3E%3Cstop offset='1' stop-color='%230F172A'/%3E%3C/linearGradient%3E%3Cpattern patternUnits='userSpaceOnUse' id='b' width='300' height='250' x='0' y='0' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.06'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/pattern%3E%3C/defs%3E%3Crect x='0' y='0' fill='url(%23a)' width='100%25' height='100%25'/%3E%3Crect x='0' y='0' fill='url(%23b)' width='100%25' height='100%25'/%3E%3C/svg%3E");
        background-attachment: fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        padding: 20px;
        text-align: center;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .login-container img {
        width: 100px;
        margin-bottom: 20px;
    }

    .login-container h1 {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--button-bg);
    }

    .login-container p {
        font-size: 14px;
        margin-bottom: 20px;
        color: var(--text-color2);

    }
    .login-container input[type="number"],
    .login-container input[type="password"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #DEE2E6;
        color:#0F172A ;
    }

    .login-container input[type="number"]:focus,
    .login-container input[type="password"]:focus{
        outline: var(--color1) 1px solid;
    }


    .login-container button {
        background-color: var(--button-bg);
        color: #ffffff;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
    }

    .login-container button:hover {
        background-color: var(--color3b);
    }

    .login-container a {
        display: block;
        margin-top: 15px;
        font-size: 14px;
        text-decoration: none;
        color: #007B83;
    }

    .login-container a:hover {
        text-decoration: underline;
    }

    @media screen and (max-width: 480px) {
        body {
            padding: 10px;
        }

        .login-container {
            padding: 15px;
            max-width: 100%;
        }

        .login-container h1 {
            font-size: 20px;
        }

        .login-container p {
            font-size: 12px;
        }

        .login-container button {
            padding: 8px;

        }
    }
</style>