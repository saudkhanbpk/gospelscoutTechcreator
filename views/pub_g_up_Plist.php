<?php 
	
	$backGround = 'bg2';
	$page1 = 'Posted Public Gigs';
	$page2 = 'Non-Posted Public Gigs';

	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	
	if($currentUserID > 0 && ($_GET['is_P'] == 1 || $_GET['is_P'] == 0)){
		/* Query database for the Posted Upcoming Public gigs */	

			/* Define query function vars */
				$is_P = intval($_GET['is_P']);
				$today = date_create();
				$today = date_format($today,'Y-m-d');
				$table = 'postedgigsmaster';

			/* Choose columns for function to return or assign string value 'all' for all columns*/
				$columnsArray = array('gigName', 'gigDate', 'setupTime', 'isPostedStatus', 'status','gigId', 'selectedArtist');
			
			/* Define conditions and associated operators */
				$paramArray['gigManLoginId']['='] = $currentUserID;
				$paramArray['gigDate']['>='] = $today; 
				$paramArray['status']['!='] = "canceled"; 
				$paramArray['isPostedStatus']['='] =  $is_P; 
				
			/* Call the query function */
				$upcomingPublicPosts = pdoQuery($table,$columnsArray,$paramArray);
				
			/* choose page title */
				if($is_P == 1){
					$page = $page1;
				}
				else{
					$page = $page2;
				}
	}
	else{
		/* Re-direct user */
			echo '<script>window.location = "'. URL .'index.php";</script>';
	}

	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/pubPostTemp.php');
?>

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>