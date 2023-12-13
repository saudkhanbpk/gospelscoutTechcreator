<?php 
	/* List Managed Gigs */

	$backGround = 'bg2';
	$page = 'Booked Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Retrieve all upcoming managed gigs */	
		$artistStatus = 'confirmed';
		$bookedGigsQuery = 'SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_creationDate, gigdetails.gigDetails_gigStatus
							 FROM gigartists
							 INNER JOIN gigdetails on gigartists.gigId = gigdetails.gigId
							 WHERE gigartists.gigArtists_userId = ? AND  gigartists.gigArtists_artistStatus = ?';
		try{
			$bookedGigs = $db->prepare($bookedGigsQuery);
			$bookedGigs->bindParam(1,$currentUserID);
			$bookedGigs->bindParam(2,$artistStatus);
			$bookedGigs->execute(); 
		}
		catch(Exception $e){
			echo $e; 
		}
		$bookedGigsResults = $bookedGigs->fetchAll(PDO::FETCH_ASSOC); 
		
		$pageArray = $bookedGigsResults;
?>

<div class="container bg-white mt-5 mb-3 px-2 py-3" style="max-width:900px;min-height:700px">
	<?php 
		require(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/gigListTemplate.php'); 
	?>
</div>

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script>
	
</script>