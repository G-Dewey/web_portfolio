<?php
function checkLocked($connect, $userID){
    try {

        $SQL = "SELECT * FROM `loginAttempts` WHERE `userID` = ?";

        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        if ($data) {
            $lockoutDate = $data['lockout']; 

            $lockoutTimestamp = strtotime($lockoutDate);
            $currentTimestamp = time();

            // If the current time has passed the lockout time, they are free to log in
            if ($currentTimestamp < $lockoutTimestamp) {
                return true;
            }
        }

        return false;

    } catch (Exception $e) {
        return true;
    }
}

function addLockCount($connect, $userID) {
    try {
        $SQL = "INSERT INTO `loginAttempts` (`userID`, `attempts`, `lockout`) 
                VALUES (?, 1, '0000-00-00 00:00:00') 
                ON DUPLICATE KEY UPDATE 
                    `attempts` = `attempts` + 1, 
                    `lockout` = IF(`attempts` >= 4, DATE_ADD(NOW(), INTERVAL 15 MINUTE), `lockout`);";

        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);

        // 2. Check if the account IS currently locked to return the status
        $checkSQL = "SELECT lockout FROM loginAttempts WHERE userID = ?";
        $checkStmt = mysqli_prepare($connect, $checkSQL);
        mysqli_stmt_bind_param($checkStmt, "i", $userID);
        mysqli_stmt_execute($checkStmt);

        return;
    } catch (Exception $e) {
        return;
    }
}

function resetAttempts($connect,$userID) {
    try {
        // Reset attempts to 0 and lockout to the default "zero" date
        $SQL = "UPDATE `loginAttempts` 
                SET `attempts` = 0, 
                    `lockout` = '0000-00-00 00:00:00' 
                WHERE `userID` = ?";

        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        return;
    }
}
?>