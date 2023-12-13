<?php 
	/* Manage Gigs Landing Page */
	$backGround = 'bg2';
	$page = 'Gig Manager';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Define Menu Items for the page */
		$menuItems = array(
							//'Create A Gig' => 'gigform.php?new=1',
							//'List Managed Gigs' => URL . "views/listManagedGigs.php",
							'Post A Public Gig' => URL . "views/pubGigs.php?new=1&public=1",
							'List Public Gig Posts' => URL. "views/listPubGigs.php");

	/* Require the Menu Landing Page Template */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/views/menuLandingTemplate.php");

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>