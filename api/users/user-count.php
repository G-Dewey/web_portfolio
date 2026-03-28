<?php
require_once("pages/_connect.php");

try {
    $SQL = "SELECT 
                COUNT(*) AS totalUsers,
                SUM(CASE WHEN `role` = 'admin' THEN 1 ELSE 0 END) AS adminCount,
                SUM(CASE WHEN `role` != 'admin' OR `role` IS NULL THEN 1 ELSE 0 END) AS nonAdminCount
            FROM `users`";
            
    $result = mysqli_query($connect, $SQL);
    $data = mysqli_fetch_assoc($result);
    
    $response = [
        "totalUsers" => (int)($data['totalUsers'] ?? 0),
        "adminCount" => (int)($data['adminCount'] ?? 0),
        "nonAdminCount" => (int)($data['nonAdminCount'] ?? 0)
    ];

    header("Content-Type: application/json");
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
}
die();
?>