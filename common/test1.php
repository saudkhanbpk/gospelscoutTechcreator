<?php 
	require(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	$objsession->set('gs_user_name','Kirk');
	$objsession->set('gs_login_id',258);	
	$objsession->set('gs_login_email','kirkddrummond@yahoo.com');	
	$objsession->set('gs_login_type','artist');

	echo '<pre>';
	// var_dump($currentUserID, $currentUserType, $currentUserEmail);
	var_dump($_SESSION); 
?>