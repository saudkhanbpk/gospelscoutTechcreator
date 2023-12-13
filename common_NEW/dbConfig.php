<?php
//db details
$dbHost = 'localhost';
$dbUsername = 'gospelsc_user';
$dbPassword = 'Gg@123456';
$dbName = 'gospelsc_db651933262';

//Connect and select the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

require_once "session.php";
$objsession = new Session();
?>