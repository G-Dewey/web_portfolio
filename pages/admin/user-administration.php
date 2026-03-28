<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/navbar.css">
</head>
<body>
<div role="navigation" aria-label="Main Navigation">
        <?PHP include 'assets/admin-navbar.php';?>
    </div>
    <div class="main-container d-flex justify-content-center" role="main">
        <div class="main-content primary-tile rounded shadow d-flex flex-column p-4">


        <div class="modal fade" tabindex="-1" id="modal-create-user" aria-labelledby="create-user-modal-title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create-user-modal-title">Create New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="form-create-user">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="create-first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="create-first-name" name="first-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="create-last-name" name="last-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="create-username" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="create-email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="create-password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-access-level" class="form-label">Access Level</label>
                                <select class="form-select" id="create-access-level" name="access-level" aria-label="Select access level">
                                    <option value="trainee" selected>Trainee</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modal-edit-user" aria-labelledby="edit-user-title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-user-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="form-edit-user">
                        <div class="modal-body">
                            <input type="hidden" id="edit-user-id" name="user-id">

                            <div class="mb-3">
                                <label for="edit-first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="edit-first-name" name="first-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="edit-last-name" name="last-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="edit-username" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="edit-email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-access-level" class="form-label">Access Level</label>
                                <select class="form-select" id="edit-access-level" name="access-level" aria-label="Edit access level">
                                    <option value="trainee" selected>Trainee</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="toggle-password" name="toggle-password">
                                <label class="form-check-label" for="toggle-password">Update Password?</label>
                            </div>

                            <div id="password-container" style="display: none;">
                                <div class="mb-3">
                                    <label for="edit-password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="edit-password" name="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Model End -->

        <div class="p-2 container">
                <div class="row mb-4">
                    <h1 class="text-center">User Administration</h1>
                </div>
                <hr>
                <!-- Fixed version with proper Bootstrap grid structure -->

<div class="row p-2">
    <div class="col-12 col-lg-10 p-2">
        <div class="row">
            <div class="col-4 d-flex">
                <label class="secondary-tile rounded shadow mx-1 p-3 flex-fill h-100 d-flex flex-column position-relative secondary-tile-border">
                    <input type="radio" name="role-filter" class="filter-radio" id="filter-all" checked aria-label="Show all users">
                    <img src="imgs/general-icon.png" class="icon rounded" alt="">
                    <p class="fs-2 fw-bold mb-0 mt-2" id="total-count" aria-live="polite">0</p>
                    <p class="fs-5 fw-light mb-0" aria-hidden="true">Users</p>
                </label>
            </div>
            
            <div class="col-4">
                <label class="secondary-tile rounded shadow mx-1 p-3 flex-fill h-100 d-flex flex-column position-relative secondary-tile-border">
                    <input type="radio" name="role-filter" class="filter-radio" id="filter-user" aria-label="Filter by Standard Users">
                    <img src="imgs/user-icon.png" class="icon rounded" alt="">
                    <p class="fs-2 fw-bold mb-0 mt-2" id="user-count" aria-live="polite">0</p>
                    <p class="fs-5 fw-light mb-0" aria-hidden="true">Trainees</p>
                </label>
            </div>
            
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
    
    <div class="col-12 col-lg-2 p-2">
        <button id="create-user-btn" class="btn w-100 h-100 rounded shadow p-3 col-surface-5 border-0 d-flex flex-column align-items-start justify-content-between" style="min-height: 120px;" aria-label="Add a new user">
            <div class="icon col-surface-2 rounded" aria-hidden="true">
                <i class="bi bi-plus-square"></i>
            </div>
            <p class="fs-5 fw-light mb-0" aria-hidden="true">Add User</p>
        </button>
    </div>
</div>

            <div class="flex-grow-1 p-2" style="min-height: 0;">
                <div class="table-responsive">
                    <table class="table table-bordered sticky-header" id="table-users" aria-describedby="user-admin-table-info">
                        <caption id="user-admin-table-info" class="visually-hidden">List of registered users with options to edit or delete.</caption>
                        <thead>
                            <tr class="col-primary-1">
                                <th scope="col" >Username</th>
                                <th scope="col">Email</th>
                                <th scope="col" class="hide-on-mobile">First Name</th>
                                <th scope="col" class="hide-on-mobile">Last Name</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="button-col">Edit</th>
                                <th scope="col" class="button-col">Delete</th>
                            </tr>
                        </thead>
            
                        <tbody aria-live="polite">
                            <tr id="loading-row"><td colspan="8">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="scripts/user-api.js"></script>
    <script src="scripts/theme.js"></script>
    <script src="scripts/manage-users.js"></script>
    <script src="scripts/navbar.js"></script>
    
    <script>
        $(document).ready(function() {
        FetchUserTable(); // This calls your function from user-api.js
    });
    </script>
</body>