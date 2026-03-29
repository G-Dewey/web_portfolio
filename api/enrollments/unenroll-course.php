<?php

if (!(isset($_POST["courseID"]) &&
    isset($_POST["userID"])))
    {
        http_response_code(400);
        echo "Required Fields are missing"; 
        die();    
    }


require_once("api/enrollments/enrollment-functions.php");
require_once("pages/_connect.php");

$courseID = $_POST["courseID"];
$userID = $_POST["userID"];

if ($userID == -1) {
    $userID = $_SESSION["userID"];
}

try{
    $SQL = "DELETE from `enrollments`
            WHERE `enrollments`.`userID` = ? AND `enrollments`.`courseID` = ?";

    $stmt = mysqli_prepare($connect, $SQL);
    
    mysqli_stmt_bind_param($stmt, "ii", $userID, $courseID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) === 0) {
        http_response_code(400); 
        echo "No enrollment found to delete.";
        die();
    }

    $courseDetails = getCourseData($connect, $courseID);

    emailConfirmation($_SESSION["email"], "unenrollment", $courseDetails["title"], $_SESSION["firstName"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    die();
}

updateEnrollmentCount($connect, $courseID);
die();

?>