<?php 
	require(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	echo '<pre>';
	// var_dump($currentUserID, $currentUserType, $currentUserEmail);
	var_dump('homeIncludeTest: ', $_SESSION); 
?>