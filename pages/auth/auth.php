<?php
// Check if form data is present
if (!isset($_POST['txtUsername']) || !isset($_POST['txtPassword']))
{
    die("Missing form data");
}
 
// Include database connection
require_once("pages/_connect.php");
 
// Get the form data
$user = $_POST['txtUsername'];
$pass = $_POST['txtPassword'];
 
// SQL command to fetch user
$SQL = "SELECT * FROM `users` WHERE `username` = ? LIMIT 1;";
 
// Send the command to the database
$stmt = mysqli_prepare($connect, $SQL);
 
// Bind parameters to prevent SQL injection ("s" means string)
mysqli_stmt_bind_param($stmt, "s", $user);
 
// Execute the command
mysqli_stmt_execute($stmt);
 
// Get the result
$result = mysqli_stmt_get_result($stmt);

@session_start();

// Check if user exists
if (mysqli_num_rows($result) === 1)
{
    require_once("pages/auth/lock-handler.php");

    // Get user data
    $USER = mysqli_fetch_assoc($result);

    // Checked if the user is locked out
    if (checkLocked($connect, $USER["userID"])){
        header('location: login?error=locked');
        die();
    }
    
    // Verify password
    if (password_verify($pass, $USER['password']))
    {
        $_SESSION['userID'] = $USER['userID'];
        $_SESSION['email'] = $USER['email'];
        $_SESSION['username'] = $USER['username'];
        $_SESSION['firstName'] = $USER['firstName'];
        $_SESSION['lastName'] = $USER['lastName'];
        $_SESSION['role'] = $USER['role'];

        resetAttempts($connect,$_SESSION['userID']);

        if ($_SESSION['role'] === 'admin') {header('location: admin-dashboard');}
        elseif ($_SESSION['role'] === 'trainee') {header('location: dashboard');}
        else {header('500');}
        die();
    }
    else{
        addLockCount($connect, $USER["userID"]);
    }
}
 
// Login failed due to incorrect password or username
header('location: login?error=1');
?>