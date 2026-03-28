<?php
require_once("pages/_connect.php");
require_once("get-one-function.php"); // Contains the getCourseData function

if (!isset($_POST["courseID"])) {
    http_response_code(400);
    echo "Required Fields are missing";
}

$courseID = $_POST["courseID"];


$course = getCourseData($connect, $courseID);

if ($course) {
    header("Content-Type: application/json");
    echo json_encode($course);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not found"]);
}
?>