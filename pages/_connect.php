<?php
$domain = "plesk.remote.ac";
$username = "WS410678_WEBBY";
$password = "bg1BC^jbR6l~vwc7";
$dbName = "WS410678_WEBDEV";

$connect = mysqli_connect($domain, $username, $password, $dbName);
// Change and set proper error
if (!$connect)
{
    echo "Database Connection Failed";
}
?>