<?php 
	/* List Managed Gigs */

	$backGround = 'bg2';
	$page = 'Managed Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Retrieve all upcoming managed gigs */	
		$gigStatus = 'active';
		$managedGigsQuery = 'SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_creationDate, gigdetails.gigDetails_gigStatus
							 FROM gigdetails
							 WHERE gigdetails.gigDetails_gigManLoginId = ?';
		try{
			$managedGigs = $db->prepare($managedGigsQuery);
			$managedGigs->bindParam(1,$currentUserID);
			$managedGigs->execute(); 
		}
		catch(Exception $e){
			echo $e; 
		}
		$managedGigsResults = $managedGigs->fetchAll(PDO::FETCH_ASSOC); 

		$pageArray = $managedGigsResults;
?>

<div class="container bg-white mt-5 mb-3 px-2 py-3" style="max-width:900px;min-height:700px">
	<?php 
		require(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/gigListTemplate.php'); 
	?>
</div>

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>