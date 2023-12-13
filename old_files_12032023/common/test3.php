<?php 
	require(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	$objsession->remove("gs_login_id");
	$objsession->remove("gs_login_type");
	$objsession->remove("gs_login_email");
	$objsession->remove("gs_user_name");
	$objsession->remove("google_cal_accessToken");

	var_dump('removed: ',$_SESSION); 
?>