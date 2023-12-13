<?php
//db details
$dbHost = 'localhost';
$dbUsername = 'u7fnwik4zjott';
$dbPassword = 'nehs4jr9gfcn';
$dbName = 'dboxwh7hjvgxel';

//Connect and select the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

require_once "session.php";
$objsession = new Session();

?>