<?php

if (!isset($_POST["courseID"]))
    {
        http_response_code(400);
        echo "Required Fields are missing";
        die();
    }

require_once("api/enrollments/enrollment-functions.php");
require_once("api/courses/get-one-function.php");
require_once("pages/_connect.php");

$courseID = $_POST["courseID"];

// Fetches all enrollements 
try{
    $SQL = "SELECT `users`.`userID`, `users`.`username`, `users`.`firstName`, `users`.`lastName`
            FROM `users` 
            INNER JOIN `enrollments` ON `users`.`userID` = `enrollments`.`userID` 
            WHERE `enrollments`.`courseID` = ?;";

    $stmt = mysqli_prepare($connect, $SQL);
    
    mysqli_stmt_bind_param($stmt, "i", $courseID);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!$data) {
        $data = [];
    }
    
    header("Content-Type: application/json");
    echo json_encode($data);
    die();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    die();
}

die();
?>