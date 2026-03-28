<?php

require_once("pages/_connect.php");
try {
    $SQL = "SELECT `courseID`, `title`, `description`, `level`, `duration`, `capacity`, `date`, `enrolled` FROM `courses` ORDER BY `date` ASC";
    $result = mysqli_query($connect, $SQL);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    header("Content-Type: application/json");
    echo json_encode($data);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
}

die();
?>