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
           <li><a href="student_dashboard.php#profile"><i class="fa-solid fa-user"></i> Profile</a></li>
           <li><a href="student_dashboard.php#records"><i class="fa-solid fa-clipboard"></i> Records</a></li>
           <li><a href="#" id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
       </ul>
   </header>

   <script>
       const logoutButton = document.getElementById('logoutButton');

       logoutButton.addEventListener('click', (e) => {
           e.preventDefault(); // Prevent the default anchor action
           Swal.fire({
               title: 'Are you sure?',
               text: "You will be logged out of your session.",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, logout',
               cancelButtonText: 'Cancel'
           }).then((result) => {
               if (result.isConfirmed) {
                   window.location.href = 'student_logout.php'; // Redirect to logout page
               }
           });
       });
   </script>


   <style>
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
           box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
           border-bottom: 1px solid var(--text-hover);
       }

       header ul i {
           margin-right: 5px;
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

           .vital-signs-container {
               display: flex;
               gap: 10px;
               flex-wrap: wrap;
               justify-content: center;
               flex-direction: row;
           }



       }

       @media (max-width: 768px) {

           header ul {
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           }

           .nav-links li a {
               border: 1px solid var(--color3b);
               background-color: var(--color3);
           }


       }
   </style>