<?php
if (!(isset($_POST['first-name']) &&
    isset($_POST['last-name']) &&
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['access-level']) &&
    isset($_POST['user-id'])))
{
    http_response_code(400);
    echo "Required Fields are missing";
    die();
}

$passwordChange = false;

if (isset($_POST['toggle-password'])){
    if (!(isset($_POST['new-password']))){
        http_response_code(400);
        echo "Required Fields are missing";
        die();
    }
    $passwordChange = true;
}

try {
    require_once("pages/_connect.php");

    $userID      = $_POST["user-id"];
    $firstName   = $_POST['first-name'];
    $lastName    = $_POST['last-name'];
    $username    = $_POST['username'];
    $email       = $_POST['email'];
    $accessLevel = $_POST['access-level'];

    $SQL = "UPDATE `users` 
            SET 
                `firstName` = ?, 
                `lastName` = ?, 
                `username` = ?, 
                `email` = ?,
                `role` = ? 
            WHERE `userID` = ?";

    $stmt = mysqli_prepare($connect, $SQL);

    mysqli_stmt_bind_param($stmt, "sssssi", $firstName, $lastName, $username, $email, $accessLevel, $userID);
    mysqli_stmt_execute($stmt);

    if ($passwordChange){
        $hashedPassword = password_hash($_POST['new-password'], PASSWORD_BCRYPT);

        $SQL = "UPDATE `users` 
                SET 
                    `password` = ?
                WHERE `userID` = ?";

        $stmt = mysqli_prepare($connect, $SQL);

        mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $userID);
        mysqli_stmt_execute($stmt);
    }

    echo "User Updated";
    die();

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    die();
}
?>