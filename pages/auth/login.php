<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <!-- Meta tags and page title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karting Pro - Login</title>
    
    <!-- Bootstrap CSS and custom stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<!-- Body with centered flexbox layout -->
<body class="bg-img d-flex justify-content-center align-items-center vh-100">
    
    <!-- Login form container -->
    <div class="primary-tile p-4 rounded shadow" style="width: 300px;" role="main">
        <!-- Logo section -->
        <div style="width: 80%; margin: 0% 10% 10% 10%;">
            <img style="width: 100%" src="imgs/logo-full.png" alt="Karting Pro Logo">
        </div>

        <!-- Login form -->
        <form action="auth" method="POST">
            <h2 class="mb-4 text-center">Login</h2>
    
            <!-- Username input -->
            <div class="mb-3">
                <label for="txtUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="txtUsername" name="txtUsername" required aria-required="true">
            </div>
    
            <!-- Password input -->
            <div class="mb-3">
                <label for="txtPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="txtPassword" name="txtPassword" required aria-required="true">
            </div>    
            
            <!-- Error message handling -->
            <?php 
                if (isset($_GET['error'])) {
                    $errorType = $_GET['error'];
                    $message = "Invalid username or password."; 
                    
                    // Check for locked account error
                    if ($errorType == 'locked') {
                        $message = "Account locked due to too many failed attempts. Please try again later.";
                    }
                    
                    echo '<div class="alert alert-danger py-2 text-center" role="alert" aria-live="assertive">' . htmlspecialchars($message) . '</div>';
                }
            ?>

            <!-- Login button -->
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    
    <!-- Theme toggle button (fixed position) -->
    <div class="position-fixed bottom-0 start-0 m-3" role="region" aria-label="Theme Customization">
        <?PHP include 'assets/theme_button.html';?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="scripts/theme.js"></script>
</body>
</html>