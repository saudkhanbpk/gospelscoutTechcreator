<?php 
	/* List Public Gigs */

	$backGround = 'bg2';
	$page = 'Public Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Define Menu Items for the page */
		$menuItems = array(
							'Upcoming' => URL . "views/pub_g_up.php",
							'Expired' => URL . "views/pub_g_ex.php",
							'Cancelled' => URL . "views/pub_g_can.php");

	/* Require the Menu Landing Page Template */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/views/menuLandingTemplate.php");

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');

?>