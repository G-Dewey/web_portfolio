<?php

if (!(isset($_POST["courseID"]) &&
    isset($_SESSION["userID"])))
    {
        echo "Missing user inputs";
        die();
    }


require_once("api/enrollments/enrollment-functions.php");
require_once("pages/_connect.php");

$courseID = $_POST["courseID"];
$userID = $_SESSION["userID"];

if (!validateCourse($connect, $courseID)){
    http_response_code(400);
    echo json_encode(["error" => "Bad Course0"]);
    die();
}

// Adds the enrollment to the enrollment table 
try{
    $SQL = "INSERT INTO `enrollments`(
                `enrollmentID`,
                `userID`,
                `courseID`
            )
            VALUES(
                NULL,
                ?,
                ?
            )";

    $stmt = mysqli_prepare($connect, $SQL);
    
    mysqli_stmt_bind_param($stmt, "ii", $userID, $courseID);
    mysqli_stmt_execute($stmt);

    $courseDetails = getCourseData($connect, $courseID);

    emailConfirmation($_SESSION["email"], "enrollment", $courseDetails["title"], $_SESSION["firstName"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    die();
}

updateEnrollmentCount($connect, $courseID);

die();
?>