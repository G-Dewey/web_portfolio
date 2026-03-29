<!-- Karting Pro - Your Details -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Details</title>
    
    <!-- Bootstrap and Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom styles -->
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/navbar.css">
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

    <!-- Main content -->
    <div class="main-container d-flex justify-content-center">
        <main class="main-content primary-tile rounded shadow d-flex flex-column p-4 w-100" style="max-width: 1200px;">  
            <div class="p-2 container-fluid">
                <header class="row mb-4">
                    <h1 class="text-center fs-1">Your Account Details</h1>
                </header>
                <hr aria-hidden="true">
                
                <!-- Profile information - dynamically populated -->
                <section aria-labelledby="profile-info-heading" aria-live="polite">
                    <h2 id="profile-info-heading" class="visually-hidden">Profile Information</h2>
                    
                    <p class="mb-2"><strong>Username:</strong> <span class="capitalise" id="username">Loading...</span></p>
                    <p class="mb-2"><strong>Email:</strong> <span class="capitalise" id="email">Loading...</span></p>
                    <p class="mb-2"><strong>First Name:</strong> <span class="capitalise" id="firstName">Loading...</span></p>
                    <p class="mb-2"><strong>Last Name:</strong> <span class="capitalise" id="lastName">Loading...</span></p>
                    <p class="mb-2"><strong>Role:</strong> <span class="capitalise" id="role">Loading...</span></p>
                    <p class="mb-2"><strong>Courses Completed:</strong> <span class="capitalise" id="completed">Loading...</span></p>
                </section>
            </div>
        </main>
    </div>

    <!-- External libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom scripts -->
    <script src="scripts/theme.js"></script>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/user-details.js"></script>
    
    <!-- Load user details on page ready -->
    <script>
        $(document).ready(function() {
            populateDetails();
        });
    </script>
</body>