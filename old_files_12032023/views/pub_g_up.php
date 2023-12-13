<?php 
	/* Upcoming Public Gigs list - pub_g_Up.php */


	$backGround = 'bg2';
	$page = 'Upcoming Public Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Define Menu Items for the page */
		$menuItems = array(
							'Posted' => URL . "views/pub_g_up_Plist.php?is_P=1",
							'Non-Posted' => URL . "views/pub_g_up_Plist.php?is_P=0");

	/* Require the Menu Landing Page Template */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/views/menuLandingTemplate.php");

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>