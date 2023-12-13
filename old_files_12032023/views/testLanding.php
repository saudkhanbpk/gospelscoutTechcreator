<?php /* file test landing page */
	
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	$testSess = $objsession->getSessionArray(); 
	echo '<pre>';
    var_dump($testSess);
?>