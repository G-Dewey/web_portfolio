<?php
if (isset($_POST['course-title']) &&
    isset($_POST['course-description']) &&
    isset($_POST['course-date']) &&
    isset($_POST['course-duration-hrs']) &&
    isset($_POST['course-duration-mins']) &&
    isset($_POST['course-capacity']) &&
    isset($_POST['course-difficulty'])
    )
{
    require_once("pages/_connect.php");
 
    $title       = $_POST['course-title'];
    $description = $_POST['course-description'];
    $date        = $_POST['course-date'];
    $hours       = $_POST['course-duration-hrs'];
    $minutes     = $_POST['course-duration-mins'];
    $capacity    = $_POST['course-capacity'];
    $difficulty  = $_POST['course-difficulty'];

    $duration = ($hours*60) + $minutes;

    $SQL = "INSERT INTO `courses` (
                `title`, 
                `description`, 
                `level`, 
                `duration`, 
                `capacity`, 
                `date`, 
                `enrolled`
            ) 
            VALUES (?, ?, ?, ?, ?, ?, 0)";

    $stmt = mysqli_prepare($connect, $SQL);
 
    mysqli_stmt_bind_param($stmt, "ssiiis", 
            $title, 
            $description, 
            $difficulty, 
            $duration, 
            $capacity, 
            $date
        );
 
    mysqli_stmt_execute($stmt);
    
    echo "Created new course!";
}
else
{
    http_response_code(400);
    echo "Required Fields are missing";
}
die();
?>