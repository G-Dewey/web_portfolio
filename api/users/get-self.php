<?php
require_once("pages/_connect.php");

if (!isset($_SESSION["userID"])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

try {
    $userID = $_SESSION["userID"];

    $SQL = "SELECT `userID`, `email`, `firstName`, `lastName`, `username`, `role` FROM users WHERE `userID` = ?";
    
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        http_response_code(404);
        echo json_encode(["error" => "User not found"]);
        exit();
    }
    
    header("Content-Type: application/json");
    echo json_encode($data);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
}

exit();
?>