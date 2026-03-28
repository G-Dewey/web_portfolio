<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap CSS for responsive layout and components -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons for UI elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap JavaScript bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom stylesheets -->
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/course-cards.css">
</head>

<body>
    <!-- Navigation bar section -->
    <div role="navigation" aria-label="Main Navigation">
        <?PHP include 'assets/admin-navbar.php';?>
    </div>
    
    <!-- Main container wrapper -->
    <div class="main-container d-flex justify-content-center">
        <div class="main-content primary-tile rounded shadow d-flex flex-column p-4 w-100" style="max-width: 1200px;" role="main">  
            <div class="p-2 container-fluid">
                <!-- Page title -->
                <div class="row mb-4">
                    <h1 class="text-center fs-1">Welcome To The Admin Portal</h1>
                </div>
                <hr>
                
                <!-- Dashboard cards section -->
                <div class="row p-2 justify-content-center">
                    <div class="col-12 col-lg-10">
                        
                        <div class="row g-4">

                            <!-- Next Course Card - Full width card showing upcoming course details -->
                            <div class="col-12">
                                <a href="/view-enrollments" class="dashboard-card secondary-tile rounded shadow border p-0 h-100 d-flex flex-column" aria-label="View enrollments for your next course">
                                    <h4 class="py-3 text-center col-dark rounded-top mb-0 fs-3" aria-hidden="true">Your Next Course</h4>
                                    <!-- Content populated by JavaScript -->
                                    <div class="flex-grow-1 px-4 py-3 d-flex justify-content-center" id="next-course" aria-live="polite">
                                    
                                    </div>
                                </a>
                            </div>

                            <!-- Manage Users Card - User management overview and link -->
                            <div class="col-md-4">
                                <a href="/user-administration" class="dashboard-card secondary-tile rounded shadow border p-4 h-100 d-flex flex-column" aria-label="Manage Users">
                                    <h4 class="pb-2 mb-2" aria-hidden="true"><i class="bi bi-person-gear"></i> Manage Users</h4>
                                    <!-- User statistics (populated by JavaScript) -->
                                    <div class="flex-grow-1" aria-hidden="true">
                                        <p class="mb-1"><i class="bi bi-people"></i> Users: <span id="user-count">0</span></p>
                                        <p class="mb-1"><i class="bi bi-person-workspace"></i> Trainees: <span id="trainee-count">0</span></p>
                                        <p class="mb-1"><i class="bi bi-tools"></i> Admins: <span id="admin-count">0</span></p>
                                    </div>
                                </a>
                            </div>

                            <!-- Manage Courses Card - Course management overview and link -->
                            <div class="col-md-4">
                                <a href="/course-administration" class="dashboard-card secondary-tile rounded shadow border p-4 h-100 d-flex flex-column" aria-label="Manage Courses">
                                    <h4 class="pb-2 mb-2" aria-hidden="true"><i class="bi bi-gear me-2"></i>Manage Courses</h4>
                                    <!-- Course statistics (populated by JavaScript) -->
                                    <div class="flex-grow-1" aria-hidden="true">
                                        <p class="mb-1"><i class="bi bi-calendar-event"></i> Upcoming: <span id="upcoming-count">0</span></p>
                                        <p class="mb-1"><i class="bi-folder-check"></i> Past: <span id="past-count">0</span></p>
                                        <p class="mb-1"><i class="bi bi-mortarboard"></i> Total Enrollments: <span id="enrollment-count">0</span></p>
                                    </div>
                                </a>
                            </div>

                            <!-- Browse Courses Card - Link to explore available courses -->
                            <div class="col-md-4">
                                <a href="/explore-courses" class="dashboard-card secondary-tile rounded shadow border p-4 h-100 d-flex flex-column" aria-label="Browse all available courses">
                                    <h4 class="pb-2 mb-2" aria-hidden="true"><i class="bi bi-search me-2"></i>Browse Courses</h4>
                                    <div class="flex-grow-1" aria-hidden="true">
                                        <p class="mb-1">Want to improve you karting skills? Find you next course to enroll on!</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </div>

    <!-- External JavaScript libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom JavaScript files -->
    <script src="scripts/user-api.js"></script>
    <script src="scripts/theme.js"></script>
    <script src="scripts/dashboard-shared.js"></script>
    <script src="scripts/dashboard-admin.js"></script>
    <script src="scripts/course-shared.js"></script>
    <script src="scripts/navbar.js"></script>
    
    <!-- Initialize dashboard on document ready -->
    <script>
        // Populate dashboard content with statistics and next course info
        $(document).ready(function() {
            populateContent();
        });
    </script>
</body>