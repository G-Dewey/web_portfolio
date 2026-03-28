<?php
if (!(isset($_POST["courseID"]) &&
    isset($_SESSION["userID"])))
    {
        http_response_code(400);
        echo "Required Fields are missing";
        die();
    }

    require_once("api/enrollments/enrollment-functions.php");
    require_once("pages/_connect.php");

    $courseID = $_POST["courseID"];
    $userID = $_SESSION["userID"];

    $enrolled = checkEnrolled($connect, $courseID, $userID);

    header('Content-Type: application/json');
    echo json_encode(["isEnrolled" => $enrolled]);
?>