<?php
function checkLocked($connect, $userID){
    try {

        // Query to get login attempt data for the user
        $SQL = "SELECT * FROM `loginAttempts` WHERE `userID` = ?";

        // Prepare and execute statement
        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);

        // Fetch the result
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        // Check if login attempt record exists
        if ($data) {
            $lockoutDate = $data['lockout']; 

            // Convert lockout date to timestamp for comparison
            $lockoutTimestamp = strtotime($lockoutDate);
            $currentTimestamp = time();

            // If the current time hasn't passed the lockout time, account is still locked
            if ($currentTimestamp < $lockoutTimestamp) {
                return true; // Account is locked
            }
        }

        // No lockout record or lockout period has expired
        return false; // Account is not locked

    } catch (Exception $e) {
        // On error, assume locked for security (fail-safe approach)
        return true;
    }
}

function addLockCount($connect, $userID) {
    try {
        // Insert new record or update existing attempt count
        // If attempts reach 5 (attempts >= 4 after increment), set lockout time to 15 minutes from now
        $SQL = "INSERT INTO `loginAttempts` (`userID`, `attempts`, `lockout`) 
                VALUES (?, 1, '0000-00-00 00:00:00') 
                ON DUPLICATE KEY UPDATE 
                    `attempts` = `attempts` + 1, 
                    `lockout` = IF(`attempts` >= 4, DATE_ADD(NOW(), INTERVAL 15 MINUTE), `lockout`);";

        // Prepare and execute the statement
        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);

        // Check current lockout status (query prepared but not used)
        $checkSQL = "SELECT lockout FROM loginAttempts WHERE userID = ?";
        $checkStmt = mysqli_prepare($connect, $checkSQL);
        mysqli_stmt_bind_param($checkStmt, "i", $userID);
        mysqli_stmt_execute($checkStmt);

        return;
    } catch (Exception $e) {
        // Silently fail on error
        return;
    }
}

/**
 * Reset failed login attempts to zero after successful login
 * 
 * @param mysqli $connect - Database connection object
 * @param int $userID - The ID of the user
 * @return void
 */
function resetAttempts($connect,$userID) {
    try {
        // Reset attempts to 0 and clear lockout timestamp
        $SQL = "UPDATE `loginAttempts` 
                SET `attempts` = 0, 
                    `lockout` = '0000-00-00 00:00:00' 
                WHERE `userID` = ?";

        // Prepare and execute the statement
        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        // Silently fail on error
        return;
    }
}
?>