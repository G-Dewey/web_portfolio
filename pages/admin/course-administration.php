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
    <link rel="stylesheet" href="styles/course-cards.css">
</head>

<body>
    <!-- Navigation bar section -->
    <div role="navigation" aria-label="Admin Navigation">
        <?PHP include 'assets/admin-navbar.php';?>
    </div>

    <!-- Hidden input to identify page type for JavaScript -->
    <input type="hidden" id="page-type" value="course-view">

    <!-- Main container wrapper -->
    <div class="main-container d-flex justify-content-center">
        <div class="main-content primary-tile rounded shadow d-flex flex-column p-4">

            <!-- Modal: Course Enrollments Viewer -->
            <div class="modal fade" tabindex="-1" id="modal-course-enrollments" aria-labelledby="enrollmentModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal header with course name and close button -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="enrollmentModalTitle"><span id="course-name"></span> Enrollments</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <!-- Modal body containing enrollments table -->
                        <div class="modal-body">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Username</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col" class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="enrollment-list-body">
                                    <!-- Loading state row (replaced by JavaScript when data loads) -->
                                    <tr id="loading-row">
                                        <td colspan="4" class="text-center py-4">
                                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Loading"></div>
                                            Loading enrollments...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Modal: Create New Course -->
            <div class="modal fade" tabindex="-1" id="modal-create-course" aria-labelledby="createCourseModalTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCourseModalTitle">Create New Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
        
                        <!-- Create course form -->
                        <form id="form-create-course">
                            <div class="modal-body">
                                <!-- Course title input with character counter -->
                                <div class="mb-2">
                                    <label for="course-title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="course-title" name="course-title" maxlength="50" required>
                                    <div id="charCountTitle" class="form-text text-end" aria-live="polite">0 / 50</div>
                                </div>

                                <!-- Course description textarea with character counter -->
                                <div class="mb-2">
                                    <label for="course-description" class="form-label">Course Description</label>
                                    <textarea 
                                        class="form-control" 
                                        id="course-description" 
                                        name="course-description"
                                        rows="5" 
                                        maxlength="200" 
                                        placeholder="Enter a brief description..."
                                        required></textarea>
                                    <div id="charCountDesc" class="form-text text-end" aria-live="polite">0 / 200</div>
                                </div>

                                <!-- Difficulty level dropdown -->
                                <div class="mb-3 w-100">
                                    <label for="course-difficuly" class="form-label">Level</label>
                                    <select name="course-difficulty" class="form-select" aria-label="Select course difficulty level">
                                        <option value="1">Rookie</option>
                                        <option value="2">Amateur</option>
                                        <option value="3">Challenger</option>
                                        <option value="4">Pro</option>
                                    </select>
                                </div>

                                <!-- Course date picker -->
                                <div class="mb-3 w-100">
                                    <label for="course-date" class="form-label">Date</label>
                                    <div class="w-100">
                                        <input type="date" class="form-control" id="course-date" name="course-date" required>
                                    </div>
                                </div>

                                <!-- Duration inputs (hours and minutes) -->
                                <div class="mb-3">
                                    <label class="form-label">Duration</label>
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" id="course-duration-hrs" name="course-duration-hrs" min="0" max="24" value="1" required aria-label="Duration Hours">
                                        <span class="input-group-text time-lable justify-content-center">Hours</span>
                                    </div>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="course-duration-mins" name="course-duration-mins" min="0" max="59" value="0" required aria-label="Duration Minutes">
                                        <span class="input-group-text time-lable justify-content-center">Minutes</span>
                                    </div>
                                </div>

                                <!-- Maximum capacity input -->
                                <div class="mb-3">
                                    <label for="course-capacity" class="form-label">Maximum Capacity</label>
                                    <input type="number" class="form-control" id="course-capacity" name="course-capacity" min="1" value="100" required>
                                </div>
                            </div>

                            <!-- Modal footer with action buttons -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal: Edit Existing Course -->
            <div class="modal fade" tabindex="-1" id="modal-edit-course" aria-labelledby="editCourseModalTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCourseModalTitle">Edit New Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
        
                        <!-- Edit course form -->
                        <form id="form-edit-course">
                            <div class="modal-body">

                                <!-- Hidden field to store course ID -->
                                <input type="hidden" id="course-id" name="course-ID">

                                <!-- Course title input with character counter -->
                                <div class="mb-2">
                                    <label for="course-title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="course-title" name="course-title" maxlength="50" required>
                                    <div id="charCountTitle" class="form-text text-end" aria-live="polite">0 / 50</div>
                                </div>

                                <!-- Course description textarea with character counter -->
                                <div class="mb-2">
                                    <label for="course-description" class="form-label">Course Description</label>
                                    <textarea 
                                        class="form-control" 
                                        id="course-description" 
                                        name="course-description"
                                        rows="5" 
                                        maxlength="200" 
                                        placeholder="Enter a brief description..."
                                        required></textarea>
                                    <div id="charCountDesc" class="form-text text-end" aria-live="polite">0 / 200</div>
                                </div>

                                <!-- Difficulty level dropdown -->
                                <div class="mb-3 w-100">
                                    <label for="course-difficuly" class="form-label">Level</label>
                                    <select name="course-difficulty" id="course-difficulty" class="form-select" aria-label="Edit course difficulty level">
                                        <option value="1">Rookie</option>
                                        <option value="2">Amateur</option>
                                        <option value="3">Challenger</option>
                                        <option value="4">Pro</option>
                                    </select>
                                </div>

                                <!-- Course date picker -->
                                <div class="mb-3 w-100">
                                    <label for="course-date" class="form-label">Date</label>
                                    <div class="w-100">
                                        <input type="date" class="form-control" id="course-date" name="course-date" required>
                                    </div>
                                </div>

                                <!-- Duration inputs (hours and minutes) -->
                                <div class="mb-3">
                                    <label class="form-label">Duration</label>
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" id="course-duration-hrs" name="course-duration-hrs" min="0" max="24" value="1" required aria-label="Edit Duration Hours">
                                        <span class="input-group-text time-lable justify-content-center">Hours</span>
                                    </div>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="course-duration-mins" name="course-duration-mins" min="0" max="59" value="0" required aria-label="Edit Duration Minutes">
                                        <span class="input-group-text time-lable justify-content-center">Minutes</span>
                                    </div>
                                </div>

                                <!-- Maximum capacity input with current enrollment display -->
                                <div class="mb-2">
                                    <label for="course-capacity" class="form-label">Maximum Capacity</label>
                                    <input type="number" class="form-control" id="course-capacity" name="course-capacity" min="1" value="100" required>
                                    <div class="form-text text-end">Currently Enrolled: <span id="enrolled"></span></div>
                                </div>
                            </div>

                            <!-- Modal footer with action buttons -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <!-- Main content area -->
            <div class="container p-2 align-items-strech">
                <!-- Page title -->
                <div class="row mb-4">
                    <h1 class="text-center">Course Administration</h1>
                </div>
                <hr>
                
                <!-- Filter and search controls -->
                <div class="row secondary-tile rounded mb-4 p-2 d-flex align-items-center my-1" role="search" aria-label="Course filters">
                    <!-- Create course button -->
                    <div class="col-lg-1 col-12 d-flex flex-fill my-1">
                        <button class="btn btn-square btn-add-user flex-fill" id="create-course-btn" aria-label="Create new course">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    
                    <!-- Timespan filter dropdown -->
                    <div class="dropdown col-lg-2 col-12 h-100 my-1">
                        <button class="btn btn-secondary dropdown-toggle w-100 h-100 py-2" type="button" id="filterTimespan" data-bs-toggle="dropdown" data-current-value="All" aria-expanded="false">
                            Timespan: All
                        </button>
                        <ul class="dropdown-menu dropdown-menu" aria-labelledby="filterTimespan">
                            <li><a class="dropdown-item timespan-opt" data-value="all">All</a></li>
                            <li><a class="dropdown-item timespan-opt" data-value="Upcoming">Upcoming</a></li>
                            <li><a class="dropdown-item timespan-opt" data-value="Past">Past</a></li>
                        </ul>
                    </div>

                    <!-- Level/difficulty filter dropdown -->
                    <div class="dropdown col-lg-2 col-12 h-100 my-1 d-flex">
                        <button class="btn btn-secondary dropdown-toggle flex-fill h-100 py-2" type="button" id="filterLevel" data-bs-toggle="dropdown" data-current-value="Any" aria-expanded="false">
                            Level: Any
                        </button>
                        <ul class="dropdown-menu dropdown-menu" aria-labelledby="filterLevel">
                            <li><a class="dropdown-item level-opt" data-value="all">Any</a></li>
                            <li><a class="dropdown-item level-opt" data-value="Upcoming">Rookie</a></li>
                            <li><a class="dropdown-item level-opt" data-value="Past">Amateur</a></li>
                            <li><a class="dropdown-item level-opt" data-value="Past">Challenger</a></li>
                            <li><a class="dropdown-item level-opt" data-value="Past">Pro</a></li>
                        </ul>
                    </div>
                    
                    <!-- Search input field -->
                    <div class="col-12 col-lg-7 h-100 my-1">
                        <input class="col-7 rounded h-100 w-100 fs-4 p-1" id="searchFilter" placeholder="Search for course" aria-label="Search courses by name">
                    </div>
                </div>
                
                <!-- Course cards container (populated by JavaScript) -->
                <div class="row">
                    <div class="card-grid" id="courses-container" aria-live="polite">
                    </div>   
                </div>
            </div>
        </div>
    </div>

    <!-- External JavaScript libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom JavaScript files -->
    <script src="scripts/theme.js"></script>
    <script src="scripts/admin-course-api.js"></script>
    <script src="scripts/course-shared.js"></script>
    <script src="scripts/navbar.js"></script>
    
    <!-- Initialize page on document ready -->
    <script>
        // Load course cards when page is ready
        $(document).ready(function() {
            LoadCards("courses-container");
        });
    </script>
</body>