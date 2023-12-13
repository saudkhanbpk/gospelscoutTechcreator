<?php 
	/* Manage Gigs Landing Page */
	$backGround = 'bg2';
	$page = 'Gig Manager';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		
	/* Redirect page */
		if($currentUserID != ''){
			if($currentUserType == 'gen_user' || $currentUserType == 'church'){
				echo '<script>window.location = "'. URL .'views/manageGigs1.php";</script>';
				exit;
			}
		}
		else{
			echo '<script>window.location = "'. URL .'views/search4artistNew";</script>';
			exit;
		}
		
	/* Define Menu Items for the page */
		$menuItems = array(
							'Manage Gigs' => URL . "views/manageGigs1.php",
							'View Booked Gigs' => URL . "views/listBookedGigs.php",
							'View Pending Gigs' => URL . "views/listPendingGigs.php");

	/* Require the Menu Landing Page Template */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/views/menuLandingTemplate.php");

	
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>