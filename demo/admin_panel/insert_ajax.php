<?php

if( isset( $_POST['user_name'] ) )
{

$name = $_POST['user_name'];
$age = $_POST['user_age'];
$course = $_POST['user_course'];

$host = 'localhost';
$user = 'gospelsc_user1';
$pass = 'Cc@123456';

mysql_connect($host, $user, $pass);

mysql_select_db('gospelsc_db663107335');

$insertdata=" INSERT INTO user_info VALUES( '$name','$age','$course' ) ";
mysql_query($insertdata);

}
?>