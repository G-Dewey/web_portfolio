<?php
// Checks if a course is a capacity or if the day has passed
function validateCourse($connect, $courseID){
    require_once("api/courses/get-one-function.php");

    $course = getCourseData($connect, $courseID);

    // Capacity
    if ($course["capacity"] <= $course["enrolled"]){
        http_response_code(409);
        echo "Course at capacity";
        die();
    }

    // Date
    $today = date("Y-m-d");
    if (strtotime($course["date"]) < strtotime($today)) {
        http_response_code(409);
        echo "The date has passed.";
        die();
    } 

    if(checkEnrolled($connect, $courseID, $_SESSION["userID"])){
        http_response_code(409);
        echo "Already Enrolled";
        die();
    } 

    return true;
}

// Updates the enrollment count in the courses table 
function updateEnrollmentCount($connect, $courseID){

    //gets the number of enrollemnts from the table 
    $countSQL = "SELECT COUNT(*) as total 
            FROM enrollments 
            WHERE courseID = ?;";

    $countSTMT = mysqli_prepare($connect, $countSQL);
    mysqli_stmt_bind_param($countSTMT, "i", $courseID);
    mysqli_stmt_execute($countSTMT);
    
    $result = mysqli_stmt_get_result($countSTMT);
    $row = mysqli_fetch_assoc($result);
    $totalEnrolled = $row['total'] ?? 0;
    
    //updates the enrolled field in courses
    $updateSQL = "UPDATE `courses` 
                SET `enrolled` = ?
                WHERE `courseID` = ?";

    $updateSTMT = mysqli_prepare($connect, $updateSQL);
    mysqli_stmt_bind_param($updateSTMT, "ii", $totalEnrolled, $courseID);
    mysqli_stmt_execute($updateSTMT);
}

// Checks if a user already is enrolled on a course
function checkEnrolled($connect, $courseID, $userID) {
    // 1. Prepare the SQL to check for an existing record
    $SQL = "SELECT 1 FROM enrollments WHERE courseID = ? AND userID = ? LIMIT 1";
    
    $stmt = mysqli_prepare($connect, $SQL);
    
    try{
        mysqli_stmt_bind_param($stmt, "ii", $courseID, $userID);
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
            
        $count = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        
        return $count > 0;
    } catch(e){
        http_response_code(409);
        echo "error with checking";
        die();
    }

    return false;
}

// Sends an email to confirm enrollment/unenrollment
function emailConfirmation($email, $enrolled, $courseTitle, $firstName) {
    $subject = "$enrolled Confirmation";
    $subject = ucfirst($subject);
    $message = "Hello $firstName!\nYour $enrolled in $courseTitle was successful.";
    $headers = "From: webmaster@ws410678-wad.remote.ac" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    return mail($email, $subject, $message, $headers);
}
?>