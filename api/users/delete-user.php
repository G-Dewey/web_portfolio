<?php

if (!isset($_POST['userID'])){
    http_response_code(400);
    echo "Required Fields are missing";
    die();
}

require_once("pages/_connect.php");
require_once("api/enrollments/enrollment-functions.php");

$userID = $_POST['userID'];

if ($userID == $_SESSION['userID']){
    http_response_code(403);
    echo 'Cannot delete currently logged in admin';
    die();
}

$SQL = "DELETE FROM users WHERE `users`.`userID` = ?;";
$stmt = mysqli_prepare($connect, $SQL);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);

// Removes all enrollments tied to that user 
try{

    // Gets the courseID before deleting enrollments 
    $enrollSQL = "SELECT DISTINCT courseID FROM enrollments WHERE userID = ?;";
    $enrollStmt = mysqli_prepare($connect, $enrollSQL);
    mysqli_stmt_bind_param($enrollStmt, "i", $userID);
    mysqli_stmt_execute($enrollStmt);
    $enrollResult = mysqli_stmt_get_result($enrollStmt);

    // Store the courseIDs in an array
    $courseIDs = [];
    while ($row = mysqli_fetch_assoc($enrollResult)) {
        $courseIDs[] = $row['courseID'];
    }

    // Delete all enrollments for this user
    $deleteEnrollSQL = "DELETE FROM enrollments WHERE userID = ?;";
    $deleteEnrollStmt = mysqli_prepare($connect, $deleteEnrollSQL);
    mysqli_stmt_bind_param($deleteEnrollStmt, "i", $userID);
    mysqli_stmt_execute($deleteEnrollStmt);

    // Update enrolled count for each affected course
    foreach ($courseIDs as $courseID) {
        updateEnrollmentCount($connect, $courseID);
    }
} catch (Exception $e) {
    // No error code as it has still be deleted
    die();
}

die();
?>