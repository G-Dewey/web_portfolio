<?php
require_once("pages/_connect.php");

try {
    $userID = $_SESSION["userID"];

    $SQL = "SELECT COUNT(`enrollmentID`) AS `past_enrollments` 
            FROM `enrollments`
            JOIN `courses` ON `enrollments`.`courseID` = `courses`.`courseID`
            WHERE `enrollments`.`userID` = ? AND `courses`.`date` < CURDATE();)";
            
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    $response = [
        "completedCount" => (int)($data['past_enrollments'] ?? 0)
    ];
    
    header("Content-Type: application/json");
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
}

exit();