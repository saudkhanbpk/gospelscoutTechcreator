<?php 
	/* Connect to the Database */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/include/dbConnect.php'); 
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	/* END - Connect to the Database */

	header('Content-Type: application/xml');

	if(!empty($_GET)) {
		$email = strtolower(trim($_GET['email'])); 
		
		/* Determine User Type first (Artist or Group) */
			$query0 = 'SELECT loginmaster.sUserType FROM loginmaster WHERE loginmaster.sEmailID = ?';
			try{
				$getType = $db->prepare($query0);
				$getType->bindParam(1, $email);
				$getType->execute(); 
			}
			catch(Exception $e){
				echo $e; 
			}
			$typeResult = $getType->fetch(PDO::FETCH_ASSOC);
		/* END - Determine User Type first (Artist or Group) */
//var_dump($typeResult);
		/* Choose a query based on the user type */
			if($typeResult['sUserType'] == 'group'){
	//echo 'test';
				/* Using Joins to query multiple databases at the same time */
					$query = 'SELECT loginmaster.iLoginID, loginmaster.sUserType, usermaster.sFirstName, usermaster.sLastName, usermaster.sContactNumber, usermaster.sGroupName
					FROM loginmaster 
					INNER JOIN usermaster ON loginmaster.iLoginID=usermaster.iLoginID  	
					WHERE loginmaster.sEmailID = ?'; 
				
				try {
					$getLogin = $db->prepare($query); 
					$getLogin->bindParam(1, $email);
					$getLogin->execute(); 
					
				}catch(Exception $e) {
					echo 'Could not retrieve data from the database<pre>'; 
					echo $e;
				}
				$results = $getLogin->fetchAll(PDO::FETCH_ASSOC);
				$results[0]['talent'] = 'group';
				$artistID = $results[0]['iLoginID']; 
				//var_dump($results);
			}
			elseif($typeResult['sUserType'] == 'artist'){
				/* Using Joins to query multiple databases at the same time */
					$query = 'SELECT loginmaster.iLoginID, loginmaster.sUserType, usermaster.sFirstName, usermaster.sLastName, usermaster.sContactNumber, talentmaster.talent
					FROM loginmaster 
					INNER JOIN usermaster ON loginmaster.iLoginID=usermaster.iLoginID  
					INNER JOIN talentmaster ON loginmaster.iLoginID=talentmaster.iLoginID	
					WHERE loginmaster.sEmailID = ?'; 
				
				try {
					$getLogin = $db->prepare($query); 
					$getLogin->bindParam(1, $email);
					$getLogin->execute(); 
					
				}catch(Exception $e) {
					echo 'Could not retrieve data from the database<pre>'; 
					echo $e;
				}
				$results = $getLogin->fetchAll(PDO::FETCH_ASSOC);
				$artistID = $results[0]['iLoginID']; 
			}
		/* END - Choose a query based on the user type */

		if(empty($results)){
			echo 'noResult';
		}
		else {
			if(count($results) > 1) {

				for($i=0;$i<count($results); $i++) {
					if($artistID == $results[$i]['iLoginID']) {
						$talArray[] = $results[$i]['talent'];
					}
					else{
						echo 'OH NOOOO!!!!  There is an Artist Email Address Conflict! Please Contact Us So We Can Fix It!!!';
						exit; 
					}
				} 
				?>

				<artistFound>
					<id><?php echo $results[0]['iLoginID']; ?></id>
					<fname><?php echo $results[0]['sFirstName']; ?></fname>
					<lname><?php echo $results[0]['sLastName']; ?></lname>
					<usertype><?php echo $results[0]['sUserType']; ?></usertype>
					<?php if($results[0]['sContactNumber'] == '') { ?>
							<phone>N/A</phone>
					<?php } 
						  else {
					?>
							<phone><?php echo $results[0]['sContactNumber']; ?></phone>
					<?php } ?>
					<?php 
						echo '<talnumb>' . count($results) . '</talnumb>';
						foreach($talArray as $tal) {
							echo '<talent>' . $tal . '</talent>';
						}
					?>
				</artistFound>	

				<?php
			}
			else { ?>	
				<artistFound>
					<id><?php echo $results[0]['iLoginID']; ?></id>
					<?php 
						if($results[0]['talent'] == 'group'){
					?>
							<gname><?php echo ucwords($results[0]['sGroupName']); ?></gname>
					<?php 
						}
						else{
					?>
							<fname><?php echo ucwords($results[0]['sFirstName']); ?></fname>
							<lname><?php echo ucwords($results[0]['sLastName']); ?></lname>
					<?php
						}
					?>
					<usertype><?php echo $results[0]['sUserType']; ?></usertype>
					<?php if($results[0]['sContactNumber'] == '') { ?>
							<phone>N/A</phone>
					<?php } 
						  else {
					?>
							<phone><?php echo $results[0]['sContactNumber']; ?></phone>
					<?php } ?>
					<talent><?php echo $results[0]['talent']; ?></talent>	
					<talnumb><?php echo count($results); ?></talnumb>
				</artistFound>
	<?php	}
		 }		
	}
	elseif(!empty($_POST)){
	
		/* Date and Time of Artist Removal */
			$today = date_create(date());
			$today = date_format($today, "Y-m-d H:i:s"); 
			$_POST['gigArtists_gigManCancelDate'] = $today;

		/* Trim Cancel Reason */
			$_POST['gigArtists_gigManCancelReason'] = trim($_POST['gigArtists_gigManCancelReason']);

		/* Update Table */
			try{
				$query = "UPDATE gigartists SET gigArtists_gigManCancelStatus = ?, gigArtists_gigManCancelReason = ?, gigArtists_gigManCancelDate = ? WHERE gigId = ? AND gigArtists_userId = ?";
				
				$cancelArtist = $db->prepare($query);
				$cancelArtist->bindParam(1, $_POST['gigArtists_gigManCancelStatus']);
				$cancelArtist->bindParam(2, $_POST['gigArtists_gigManCancelReason']);
				$cancelArtist->bindParam(3, $_POST['gigArtists_gigManCancelDate']);
				$cancelArtist->bindParam(4, $_POST['gigId']);
				$cancelArtist->bindParam(5, $_POST['gigArtists_userId']);
				$cancelArtist->execute(); 
			}
			catch(Exception $e){
				echo $e; 
			}
			

		/* Check for successful cancellation */
			try{
				$query1 = "SELECT gigartists.gigArtists_gigManCancelStatus,gigartists.gigArtists_email, gigartists.gigArtists_name,gigartists.gigArtists_tal 
					   FROM gigartists WHERE gigId = ? AND gigArtists_userId = ?";
				$cancellation  = $db->prepare($query1);
				$cancellation->bindParam(1, $_POST['gigId']);
				$cancellation->bindParam(2, $_POST['gigArtists_userId']);
				$cancellation->execute(); 
			}
			catch(Exception $e){
				echo $e; 
			}
			$cancellation1 = $cancellation->fetch(PDO::FETCH_ASSOC);
			
			if($cancellation1['gigArtists_gigManCancelStatus'] == 'cancelled'){
				/**** Define email Variables ****/
					/* Query database for the gigDetails_gigManLoginId, gigDetails_gigManName, gigDetails_gigName */
						$emailParamQuery = 'SELECT gigdetails.gigDetails_gigManLoginId, gigdetails.gigDetails_gigManName, gigdetails.gigDetails_gigName, gigdetails.gigDetails_gigManEmail
											FROM gigdetails
											WHERE gigdetails.gigId = ?';
						try{
							$emailParam = $db->prepare($emailParamQuery);
							$emailParam->bindParam(1, $_POST['gigId']);
							$emailParam->execute(); 
							$emailParamResults = $emailParam->fetch(PDO::FETCH_ASSOC);
						}
						catch(Exception $e){
							echo $e; 
						}
					/* END - Query database for the gigDetails_gigManLoginId, gigDetails_gigManName, gigDetails_gigName */
					
					$requestor = $emailParamResults['gigDetails_gigManEmail']; 
					$requestorName = $emailParamResults['gigDetails_gigManName']; 
					$requestorUrl = 'https://dev.gospelscout.com/views/artistprofile.php?artist=' . $emailParamResults['gigDetails_gigManLoginId']; 
					$receiver = $cancellation1['gigArtists_email']; 
					$receiverName = $cancellation1['gigArtists_name']; 
					$talentRequested = $cancellation1['gigArtists_tal']; 
					$actionUrl = 'https://dev.gospelscout.com/newHomePage/views/artistprofile.php?artist=' . $_POST['gigArtists_userId']; 
					$gigName =$emailParamResults['gigDetails_gigName']; 
					$gigId = $_POST['gigId']; 
					$cancelReason = $_POST['gigArtists_gigManCancelReason'];
				/* END - Define email Variables */

				$receiver = 'kirkddrummond@yahoo.com';
				//Call cancelArtist email function
				$bookingMail->cancelArtist($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $cancelReason);
				
				echo 'cancelled';
			}
	}
?>