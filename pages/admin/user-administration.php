

<head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Admin Dashboard</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU

pasted

add basic comments to:

17:28
I'll add basic comments to this HTML document to explain the structure and functionality of the admin dashboard.


Created a file, read a file
Created a file, read a file
I've added basic comments throughout the HTML document to explain:

External dependencies (Bootstrap, icons, libraries)
Major sections (navigation, modals, main content)
Modal purposes (enrollments viewer, create course, edit course)
Form fields and their functions
Filter controls (timespan, level, search)
JavaScript initialization
The comments provide clear context for each section while maintaining readability of the code structure.

Admin dashboard commented
Code · HTML 

<head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Admin Dashboard</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU

pasted

17:32
I'll add basic comments to this admin dashboard HTML file.


Created a file, read a file
Created a file, read a file
I've added basic comments to the admin dashboard home page HTML. The comments explain:

External dependencies (Bootstrap CSS/JS, icons, libraries)
Custom stylesheets purpose
Main sections (navigation, container, dashboard cards)
Individual dashboard cards:
Next Course (full-width, shows upcoming course)
Manage Users (user statistics)
Manage Courses (course statistics)
Browse Courses (exploration link)
JavaScript files and their purposes
Initialization code that populates the dashboard content
The comments provide clear context for each section while keeping the code clean and readable.

Admin dashboard home commented
Code · HTML 

<head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Admin Dashboard</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU

pasted

17:33
I'll add basic comments to this user administration HTML file.


Created a file, read a file
Created a file, read a file
I've added basic comments to the user administration HTML file. The comments explain:

External dependencies (Bootstrap CSS/JS, icons, libraries)
Modal sections:
Create New User modal with all form fields
Edit User modal with password toggle functionality
Main content structure:
Page title
Filter cards (All Users, Trainees, Admins) with radio button filters
Add User button
Users data table with edit/delete actions
JavaScript files and initialization code
Key features like hidden user ID field, password container toggle, and loading states
The comments provide clear context for the user management interface while keeping the code organized and readable.

User administration commented
Code · HTML 





Claude is AI and can make mistakes. Please double-check responses.
User administration commented · HTML
Copy

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
</head>
 
<body>
    <!-- Navigation bar section -->
    <div role="navigation" aria-label="Main Navigation">
        <?PHP include 'assets/admin-navbar.php';?>
    </div>
    
    <!-- Main container wrapper -->
    <div class="main-container d-flex justify-content-center" role="main">
        <div class="main-content primary-tile rounded shadow d-flex flex-column p-4">
 
            <!-- Modal: Create New User -->
            <div class="modal fade" tabindex="-1" id="modal-create-user" aria-labelledby="create-user-modal-title" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="create-user-modal-title">Create New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
 
                        <!-- Create user form -->
                        <form id="form-create-user">
                            <div class="modal-body">
                                <!-- First name input -->
                                <div class="mb-3">
                                    <label for="create-first-name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="create-first-name" name="first-name" required>
                                </div>
 
                                <!-- Last name input -->
                                <div class="mb-3">
                                    <label for="create-last-name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="create-last-name" name="last-name" required>
                                </div>
 
                                <!-- Username input -->
                                <div class="mb-3">
                                    <label for="create-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="create-username" name="username" required>
                                </div>
 
                                <!-- Email input -->
                                <div class="mb-3">
                                    <label for="create-email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="create-email" name="email" required>
                                </div>
 
                                <!-- Password input -->
                                <div class="mb-3">
                                    <label for="create-password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="create-password" name="password" required>
                                </div>
 
                                <!-- Access level dropdown -->
                                <div class="mb-3">
                                    <label for="create-access-level" class="form-label">Access Level</label>
                                    <select class="form-select" id="create-access-level" name="access-level" aria-label="Select access level">
                                        <option value="trainee" selected>Trainee</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
 
                            <!-- Modal footer with action buttons -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
 
            <!-- Modal: Edit Existing User -->
            <div class="modal fade" tabindex="-1" id="modal-edit-user" aria-labelledby="edit-user-title" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-user-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
 
                        <!-- Edit user form -->
                        <form id="form-edit-user">
                            <div class="modal-body">
                                <!-- Hidden field to store user ID -->
                                <input type="hidden" id="edit-user-id" name="user-id">
 
                                <!-- First name input -->
                                <div class="mb-3">
                                    <label for="edit-first-name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit-first-name" name="first-name" required>
                                </div>
 
                                <!-- Last name input -->
                                <div class="mb-3">
                                    <label for="edit-last-name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit-last-name" name="last-name" required>
                                </div>
 
                                <!-- Username input -->
                                <div class="mb-3">
                                    <label for="edit-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="edit-username" name="username" required>
                                </div>
 
                                <!-- Email input -->
                                <div class="mb-3">
                                    <label for="edit-email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="edit-email" name="email" required>
                                </div>
 
                                <!-- Access level dropdown -->
                                <div class="mb-3">
                                    <label for="edit-access-level" class="form-label">Access Level</label>
                                    <select class="form-select" id="edit-access-level" name="access-level" aria-label="Edit access level">
                                        <option value="trainee" selected>Trainee</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
 
                                <!-- Toggle switch to enable password update -->
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="toggle-password" name="toggle-password">
                                    <label class="form-check-label" for="toggle-password">Update Password?</label>
                                </div>
 
                                <!-- Password container (hidden by default, shown when toggle is checked) -->
                                <div id="password-container" style="display: none;">
                                    <div class="mb-3">
                                        <label for="edit-password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="edit-password" name="new-password">
                                    </div>
                                </div>
                            </div>
 
                            <!-- Modal footer with action buttons -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
 
            <!-- Main content area -->
            <div class="p-2 container">
                <!-- Page title -->
                <div class="row mb-4">
                    <h1 class="text-center">User Administration</h1>
                </div>
                <hr>
                
                <!-- Filter cards and add user button section -->
                <div class="row p-2">
                    <!-- User statistics filter cards (3 columns) -->
                    <div class="col-12 col-lg-10 p-2">
                        <div class="row">
                            <!-- All Users filter card -->
                            <div class="col-4 d-flex">
                                <label class="secondary-tile rounded shadow mx-1 p-3 flex-fill h-100 d-flex flex-column position-relative secondary-tile-border">
                                    <input type="radio" name="role-filter" class="filter-radio" id="filter-all" checked aria-label="Show all users">
                                    <img src="imgs/general-icon.png" class="icon rounded" alt="">
                                    <p class="fs-2 fw-bold mb-0 mt-2" id="total-count" aria-live="polite">0</p>
                                    <p class="fs-5 fw-light mb-0" aria-hidden="true">Users</p>
                                </label>
                            </div>
                            
                            <!-- Trainees filter card -->
                            <div class="col-4">
                                <label class="secondary-tile rounded shadow mx-1 p-3 flex-fill h-100 d-flex flex-column position-relative secondary-tile-border">
                                    <input type="radio" name="role-filter" class="filter-radio" id="filter-user" aria-label="Filter by Standard Users">
                                    <img src="imgs/user-icon.png" class="icon rounded" alt="">
                                    <p class="fs-2 fw-bold mb-0 mt-2" id="user-count" aria-live="polite">0</p>
                                    <p class="fs-5 fw-light mb-0" aria-hidden="true">Trainees</p>
                                </label>
                            </div>
                            
                            <!-- Admins filter card -->
                            <div class="col-4">
                                <label class="secondary-tile rounded shadow mx-1 p-3 flex-fill h-100 d-flex flex-column position-relative secondary-tile-border">
                                    <input type="radio" name="role-filter" class="filter-radio" id="filter-admin" aria-label="Filter by Admin Users">
                                    <img src="imgs/admin-icon.png" class="icon rounded" alt="">
                                    <p class="fs-2 fw-bold mb-0 mt-2" id="admin-count" aria-live="polite">0</p>
                                    <p class="fs-5 fw-light mb-0" aria-hidden="true">Admins</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Add User button -->
                    <div class="col-12 col-lg-2 p-2">
                        <button id="create-user-btn" class="btn w-100 h-100 rounded shadow p-3 col-surface-5 border-0 d-flex flex-column align-items-start justify-content-between" style="min-height: 120px;" aria-label="Add a new user">
                            <div class="icon col-surface-2 rounded" aria-hidden="true">
                                <i class="bi bi-plus-square"></i>
                            </div>
                            <p class="fs-5 fw-light mb-0" aria-hidden="true">Add User</p>
                        </button>
                    </div>
                </div>
 
                <!-- User table section -->
                <div class="flex-grow-1 p-2" style="min-height: 0;">
                    <div class="table-responsive">
                        <!-- Users data table (populated by JavaScript) -->
                        <table class="table table-bordered sticky-header" id="table-users" aria-describedby="user-admin-table-info">
                            <caption id="user-admin-table-info" class="visually-hidden">List of registered users with options to edit or delete.</caption>
                            <thead>
                                <tr class="col-primary-1">
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" class="hide-on-mobile">First Name</th>
                                    <th scope="col" class="hide-on-mobile">Last Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="button-col">Edit</th>
                                    <th scope="col" class="button-col">Delete</th>
                                </tr>
                            </thead>
                
                            <tbody aria-live="polite">
                                <!-- Loading state row (replaced by JavaScript when data loads) -->
                                <tr id="loading-row"><td colspan="8">Loading...</td></tr>
                            </tbody>
                        </table>
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
    <script src="scripts/manage-users.js"></script>
    <script src="scripts/navbar.js"></script>
    
    <!-- Initialize page on document ready -->
    <script>
        // Fetch and populate the user table when page loads
        $(document).ready(function() {
            FetchUserTable(); // This calls your function from user-api.js
        });
    </script>
</body>
 
