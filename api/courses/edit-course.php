<?php
if (isset($_POST['course-ID']) &&
    isset($_POST['course-title']) &&
    isset($_POST['course-description']) &&
    isset($_POST['course-date']) &&
    isset($_POST['course-duration-hrs']) &&
    isset($_POST['course-duration-mins']) &&
    isset($_POST['course-capacity']) &&
    isset($_POST['course-difficulty'])
    )
{
    require_once("pages/_connect.php");
 
    $courseID = $_POST['course-ID'];
    $title = $_POST['course-title'];
    $description = $_POST['course-description'];
    $date = $_POST['course-date'];
    $hours = $_POST['course-duration-hrs'];
    $minutes = $_POST['course-duration-mins'];
    $capacity = $_POST['course-capacity'];
    $difficulty= $_POST['course-difficulty'];

    $duration = ($hours * 60) + $minutes;

    $SQL = "UPDATE `courses` SET 
                `title` = ?, 
                `description` = ?, 
                `level` = ?, 
                `duration` = ?, 
                `capacity` = ?, 
                `date` = ? 
            WHERE `courseID` = ?";

    $stmt = mysqli_prepare($connect, $SQL);
 
    mysqli_stmt_bind_param($stmt, "ssiiisi", $title, $description, $difficulty, $duration, $capacity, $date, $courseID);
 
    if (mysqli_stmt_execute($stmt)) {
        echo "Course successfully updated!";
    } else {
        http_response_code(500);
        echo "Error updating course: " . mysqli_error($connect);
    }
}
else
{
    http_response_code(400);
    echo "Required Fields are missing";
}

die();
?>