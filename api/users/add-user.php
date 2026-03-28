<?php
if (isset($_POST['first-name']) &&
    isset($_POST['last-name']) &&
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['access-level']))
{
    require_once("pages/_connect.php");

    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $accessLevel = $_POST['access-level'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    $SQL = "INSERT INTO `users` (
                `userID`,
                `email`,
                `firstName`,
                `lastName`, 
                `username`,
                `password`,
                `timestamp`,
                `role`
            )
            VALUES (
                NULL,
                ?,
                ?,
                ?,
                ?,
                ?,
                CURRENT_TIMESTAMP(),
                ?
            )";

    $stmt = mysqli_prepare($connect, $SQL);
    
    // Binding the new variables
    mysqli_stmt_bind_param($stmt, "ssssss", 
        $email,
        $firstName, 
        $lastName, 
        $username, 
        $hashedPassword, 
        $accessLevel
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Created new user!";
    } else {
        echo "Error: Could not create user.";
    }

    mysqli_stmt_close($stmt);
}
else
{
    http_response_code(400);
    echo "Required Fields are missing";
    die();  
}

die();
?>