<?php
require_once("pages/_connect.php");

try {
    $SQL = "SELECT 
                SUM(CASE WHEN `date` >= CURDATE() THEN 1 ELSE 0 END) AS upcomingCount,
                SUM(CASE WHEN `date` < CURDATE() THEN 1 ELSE 0 END) AS pastCount
            FROM `courses`";
            
    $result = mysqli_query($connect, $SQL);
    $data = mysqli_fetch_assoc($result);
    
    $response = [
        "upcomingCount" => (int)($data['upcomingCount'] ?? 0),
        "pastCount" => (int)($data['pastCount'] ?? 0)
    ];
    
    header("Content-Type: application/json");
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
}
die();