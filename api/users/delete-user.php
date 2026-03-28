<?php

if (!isset($_POST['userID'])){
    http_response_code(400);
    echo "Required Fields are missing";
    die();
}

require_once("pages/_connect.php");
$userID = $_POST['userID'];

if ($userID == $_SESSION['userID']){
    http_response_code(403);
    echo 'Cannot delete currently logged in admin';
    die();
}

$SQL = "DELETE FROM users WHERE `users`.`userID` = ?;";
$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
die();
?>