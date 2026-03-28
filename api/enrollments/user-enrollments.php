<?php

if (!isset($_POST["userID"]))
    {
        http_response_code(400);
        echo "Required Fields are missing";
        die();  
    }

require_once("api/enrollments/enrollment-functions.php");
require_once("pages/_connect.php");

$userID = $_POST["userID"];

// gets the userID from session
if ($userID == -1){
    $userID = $_SESSION["userID"];
}

// Fetches all enrollements 
try{
    $SQL = "SELECT `courses`.* 
            FROM `courses` 
            INNER JOIN `enrollments` ON `courses`.`courseID` = `enrollments`.`courseID` 
            WHERE `enrollments`.`userID` = ?;";

    $stmt = mysqli_prepare($connect, $SQL);
    
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
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