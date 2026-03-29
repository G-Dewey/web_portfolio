<?php

if (!isset($_POST['courseID'])){
    http_response_code(400);
    echo "Required Fields are missing";
    die();
}

require_once("pages/_connect.php");
$courseID = $_POST['courseID'];

// Ensure that enrollments are deleted with that course id

$SQL = "DELETE FROM courses WHERE `courses`.`courseID` = ?;";
$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "i", $courseID);
mysqli_stmt_execute($stmt);

// Deletes all enrollments of the deleted course

try{
    $SQL = "DELETE from `enrollments`
            WHERE `enrollments`.`courseID` = ?";

    $stmt = mysqli_prepare($connect, $SQL);
    
    mysqli_stmt_bind_param($stmt, "i", $courseID);
    mysqli_stmt_execute($stmt);

} catch (Exception $e) {
    // No error code as it has still be deleted
    die();
}

echo"Course has been deleted";
die();
?>