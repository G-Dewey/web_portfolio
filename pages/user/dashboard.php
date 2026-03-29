<?php
   require 'pages/security-headers.php';
?>

<!-- Karting Pro - Dashboard -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
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
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/course-cards.css">
</head>

<body>
    <!-- Navigation -->
    <div role="navigation" aria-label="Main Navigation">
        <?PHP include 'assets/navbar.php';?>
    </div>

    <!-- Main content -->
    <div class="main-container d-flex justify-content-center">
        <main class="main-content primary-tile rounded shadow d-flex flex-column p-4 w-100" style="max-width: 1200px;">  
            <div class="p-2 container-fluid">
                <header class="row mb-4">
                    <h1 class="text-center fs-1">Welcome To Karting Pro</h1>
                </header>
                <hr aria-hidden="true">
                
                <div class="row p-2 justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="row g-4">
                            <!-- Your Next Course -->
                            <div class="col-12">
                                <a href="/view-enrollments" 
                                   class="dashboard-card secondary-tile rounded shadow border p-0 h-100 d-flex flex-column"
                                   aria-label="View details for your next scheduled course">
                                    <h4 class="py-3 text-center col-dark rounded-top mb-0 fs-3" aria-hidden="true">Your Next Course</h4>
                                    <div class="flex-grow-1 px-4 py-3 d-flex justify-content-center" id="next-course" aria-live="polite"></div>
                                </a>
                            </div>

                            <!-- Browse Courses -->
                            <div class="col-12">
                                <a href="/explore-courses" 
                                   class="dashboard-card secondary-tile rounded shadow border p-4 h-100 d-flex flex-column"
                                   aria-labelledby="browse-heading"
                                   aria-describedby="browse-description">
                                    <h4 class="pb-2 mb-2" id="browse-heading">
                                        <i class="bi bi-search me-2" aria-hidden="true"></i>Browse Courses
                                    </h4>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" id="browse-description">Ready to shave seconds off your lap times and dominate the track? Browse our upcoming schedule and find the perfect course to take your racing career to the next level!</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </main>
    </div>

    <!-- External libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom scripts -->
    <script src="scripts/user-api.js"></script>
    <script src="scripts/theme.js"></script>
    <script src="scripts/dashboard-shared.js"></script>
    <script src="scripts/dashboard.js"></script>
    <script src="scripts/course-shared.js"></script>
    <script src="scripts/navbar.js"></script>
    
    <!-- Initialize on page load -->
    <script>
        $(document).ready(function() {
            populateContent();
        });
    </script>
</body>