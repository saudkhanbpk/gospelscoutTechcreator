<?php
/*********************************************
One Hour Delivery  - Config file
Date - 14-March-2016 04:59 
**********************************************/

//define('URL',"http://www.gospelscout.com/");
//define('URL',$_SERVER["DOCUMENT_ROOT"] . '/public_html/');  
define('URL','/');
define('HTTP_SERVER',"http://www.gospelscout.com/");

/**********************Include Loader files***********************/
require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/newHomePage/common/functions.php";
require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/newHomePage/common/database.php";

 $obj = new Database();

require_once "session.php";
$objsession = new Session();

define('PROJECT_NAME','Gospel Scout');
define('PROJECT_ADMIN_TITLE','Gospel Scout Administrator');

echo 'Kirk is the man';
