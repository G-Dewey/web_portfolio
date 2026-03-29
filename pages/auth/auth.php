<?php
   require 'pages/security-headers.php';
?>

<?php
// Check if form data is present
if (!isset($_POST['txtUsername']) || !isset($_POST['txtPassword']))
{
    die("Missing form data");
}
 
// Include database connection
require_once("pages/_connect.php");
 
// Get the form data from POST request
$user = $_POST['txtUsername'];
$pass = $_POST['txtPassword'];
 
// Prepare SQL command to fetch user by username
// Using prepared statement to prevent SQL injection
$SQL = "SELECT * FROM `users` WHERE `username` = ? LIMIT 1;";
 
// Send the command to the database
$stmt = mysqli_prepare($connect, $SQL);
 
// Bind parameters to prevent SQL injection ("s" means string type)
mysqli_stmt_bind_param($stmt, "s", $user);
 
// Execute the prepared statement
mysqli_stmt_execute($stmt);
 
// Get the result set from the query
$result = mysqli_stmt_get_result($stmt);

// Start or resume the session
session_set_cookie_params([
    'secure'   => true,      // HTTPS only
    'httponly' => true,      // Blocks JavaScript access (XSS protection)
    'samesite' => 'Strict'   // Prevents CSRF attacks
]);
@session_start();

// Check if user exists in database
if (mysqli_num_rows($result) === 1)
{
    // Include lock handler for account lockout functionality
    require_once("pages/auth/lock-handler.php");

    // Fetch user data as associative array
    $USER = mysqli_fetch_assoc($result);

    // Check if the user account is locked due to failed login attempts
    if (checkLocked($connect, $USER["userID"])){
        // Redirect to login page with locked account error
        header('location: login?error=locked');
        die();
    }
    
    // Verify the submitted password against the hashed password in database
    if (password_verify($pass, $USER['password']))
    {
        // Password is correct - create session variables for authenticated user
        $_SESSION['userID'] = $USER['userID'];
        $_SESSION['email'] = $USER['email'];
        $_SESSION['username'] = $USER['username'];
        $_SESSION['firstName'] = $USER['firstName'];
        $_SESSION['lastName'] = $USER['lastName'];
        $_SESSION['role'] = $USER['role'];

        // Reset failed login attempt counter
        resetAttempts($connect,$_SESSION['userID']);

        // Redirect based on user role
        if ($_SESSION['role'] === 'admin') {
            header('location: admin-dashboard');
        }
        elseif ($_SESSION['role'] === 'trainee') {
            header('location: dashboard');
        }
        else {
            // Unknown role - return server error
            header('500');
        }
        die();
    }
    else{
        // Password incorrect - increment failed login attempt counter
        addLockCount($connect, $USER["userID"]);
    }
}
 
// Login failed - redirect to login page with error flag
// This happens if username doesn't exist or password was incorrect
header('location: login?error=1');
?>