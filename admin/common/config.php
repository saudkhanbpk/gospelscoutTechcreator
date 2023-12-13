<?php
/*********************************************
Corr Trade  - Config file
Date - 04-March-2016 05:12 
**********************************************/

define('HTTP_SERVER',"http://www.gospelscout.com/admin/");
define('PATH',"http://www.gospelscout.com/admin/views/");
define('URL',"http://www.gospelscout.com/");

/**********************Include Loader files***********************/
require_once ("functions.php");
require_once "database.php";
$obj = new Database();

require_once "session.php";
$objsession = new Session();

define('PROJECT_NAME','Gospel Scout');
define('PROJECT_ADMIN_TITLE','Gospel Scout Administrator');