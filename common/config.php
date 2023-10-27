<?php
session_start();

/*********************************************
One Hour Delivery  - Config file
Date - 14-March-2016 04:59 
**********************************************/

define('URL',"https://www.gospelscout.com/");
define('HTTP_SERVER',"https://www.gospelscout.com/");

/**********************Include Loader files***********************/
require_once "functions.php";
require_once "database.php";
$obj = new Database();

require_once "session.php";
$objsession = new Session();

/* Include Composer's Autoloader file to automatically detect which PHP package's library is required */
       //include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
	include realpath($_SERVER['DOCUMENT_ROOT']) . '/composer/vendor/autoload.php'; 
        \Stripe\Stripe::setApiKey("sk_live_aUotamlUSXwgSP4o75KmRK6E"); //pk_live_OGrw56hK2CpvoGTZgIrzQPHk
        \Stripe\Stripe::setApiVersion("2020-08-27");     //   \Stripe\Stripe::setApiVersion("2019-11-05");
        
        $str_client_id = 'ca_Ak0oSidrVUIsoOBLwIWUUqxRM8aLJgqN';

include realpath($_SERVER['DOCUMENT_ROOT']) . "/Email/emailFunctions.php";
$bookingMail = new booking();
$puwMail = new popupworship(); 

include realpath($_SERVER['DOCUMENT_ROOT']) . "/include/gsFunctPage.php";

include realpath($_SERVER['DOCUMENT_ROOT']) . "/include/stripe_functions.php";

define('PROJECT_NAME','Gospel Scout');
define('PROJECT_ADMIN_TITLE','Gospel Scout Administrator');

/* Define Current users Session Vars */
	$currentUserID = $objsession->get('gs_login_id');
	$currentUserType = $objsession->get('gs_login_type');
	$currentUserEmail = $objsession->get('gs_login_email');

/* Get current time */
    $_global_time = unixTimeStampConversion($_SERVER['REQUEST_TIME'],true);