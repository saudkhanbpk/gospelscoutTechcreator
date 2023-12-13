<?php

$con = mysql_connect("79.98.31.124:3308","root","lalamusa!2");
if(!$con){
	echo 'connection fail';
	die();
}
$db = mysql_select_db("dialogos2",$con);

$id = 147719;



?>