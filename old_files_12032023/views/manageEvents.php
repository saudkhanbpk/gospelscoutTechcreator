<?php 
	/* Manage Events Landing Page */
	$backGround = 'bg2';
	$page = 'Event Manager';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	/* Define Menu Items for the page */
		$menuItems = array(
							'Create an Event' => 'https://www.google.com',
							'View Upcoming Events' => 'https://www.google.com',
							'View Past Events' => 'https://www.google.com');

	/* Require the Menu Landing Page Template */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/newHomepage/views/menuLandingTemplate.php");

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>