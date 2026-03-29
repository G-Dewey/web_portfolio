<?php

function getCourseData($connect, $courseID) {
    try {
        $SQL = "SELECT `courseID`, `title`, `description`, `level`, `duration`, `capacity`, `date`, `enrolled` 
                FROM `courses`
                WHERE `courseID` = ?";
        
        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $courseID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result); // Returns the array OR null if not found
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Internal Server Error"]);
    }
}
?>