<?php
require_once("pages/_connect.php");

try {
    // Simple count of every row in the enrollments table
    $SQL = "SELECT COUNT(*) AS totalEnrollments FROM `enrollments`";
            
    $result = mysqli_query($connect, $SQL);
    $data = mysqli_fetch_assoc($result);
    
    $response = [
        "enrollmentCount" => (int)($data['totalEnrollments'] ?? 0)
    ];
    
    header("Content-Type: application/json");
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
}

exit();