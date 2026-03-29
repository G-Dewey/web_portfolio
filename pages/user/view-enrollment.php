<?php
   require 'pages/security-headers.php';
?>

<!-- Karting Pro - Your Enrollments -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Enrollments</title>
    
    <!-- Bootstrap and Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons for UI elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    
    <!-- Bootstrap JavaScript bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    
    <!-- Custom styles -->
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/course-cards.css">
</head>

<body>
    <!-- Navigation - show admin navbar for admins, regular navbar for users -->
    <nav role="navigation" aria-label="Main Navigation">
        <?PHP 
        if ($_SESSION["role"] == "admin"){
            include 'assets/admin-navbar.php';
        }
        else{
            include 'assets/navbar.php';
        }
        ?>
    </nav>

    <!-- Identifier for page type (used by scripts) -->
    <input type="hidden" id="page-type" value="enrollment-view">

    <!-- Main content -->
    <div class="main-container d-flex justify-content-center">
        <main class="main-content primary-tile rounded shadow d-flex flex-column p-4 w-100">
            <div class="container p-2 align-items-stretch">
                <header class="row mb-4">
                    <h1 class="text-center">Your Enrollments</h1>
                </header>
                <hr aria-hidden="true">

                <!-- Filters section -->
                <section class="row secondary-tile rounded mb-4 p-2 d-flex align-items-center" role="search" aria-label="Enrollment filters">
                    <!-- Archive toggle button -->
                    <div class="col-12 col-lg-2 h-100 my-1">
                         <button class="btn btn-danger w-100 h-100 py-2" id="archive-switch" value="upcoming" aria-live="polite">
                            View Archive
                         </button>
                    </div>

                    <!-- Level filter dropdown -->
                    <div class="dropdown col-12 col-lg-2 h-100 my-1">
                        <button class="btn btn-secondary dropdown-toggle w-100 h-100 py-2" type="button" id="filterLevel" data-bs-toggle="dropdown" aria-expanded="false" data-current-value="Any">
                            Level: Any
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterLevel">
                            <li><a class="dropdown-item level-opt" href="#" data-value="all">Any</a></li>
                            <li><a class="dropdown-item level-opt" href="#" data-value="Upcoming">Rookie</a></li>
                            <li><a class="dropdown-item level-opt" href="#" data-value="Past">Amateur</a></li>
                            <li><a class="dropdown-item level-opt" href="#" data-value="Past">Challenger</a></li>
                            <li><a class="dropdown-item level-opt" href="#" data-value="Past">Pro</a></li>
                        </ul>
                    </div>

                    <!-- Search input -->
                    <div class="col-12 col-lg-8 h-100 my-1">
                        <label for="searchFilter" class="visually-hidden">Search your enrollments</label>
                        <input type="search" class="rounded h-100 w-100 fs-4 p-1" id="searchFilter" placeholder="Search for course">
                    </div>
                </section>

                <!-- Enrollments grid - dynamically populated -->
                <div class="row">
                    <div class="card-grid" id="courses-container" aria-live="polite" role="region" aria-label="Course list"></div>   
                </div>
            </div>
        </main>
    </div>

    <!-- External libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom scripts -->
    <script src="scripts/theme.js"></script>
    <script src="scripts/course-api.js"></script>
    <script src="scripts/course-shared.js"></script>
    <script src="scripts/navbar.js"></script>
    
    <!-- Load enrollments on page ready -->
    <script>
        $(document).ready(function() {
            LoadCards("courses-container");
        });
    </script>
</body>