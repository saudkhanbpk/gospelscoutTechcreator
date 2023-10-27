<?php 
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	
	/* Create date and time for form submission */
		$today = date_create();
		$today = date_format($today, 'Y-m-d H:i:s');
	/* END - Create date and time for form submission */
	//var_dump($_POST);
	//var_dump($_FILES);
	//exit;
	if($_POST && $_FILES){
		if($_FILES['musicFile']['error'] == 4){
			echo 'No File Was Uploaded';
		}
		elseif($_FILES['musicFile']['error'] == 0){
			/* Continue Processing File */

			/* Move File from temporary location to permanent directory*/
				function moveFile($FILES, $targetFile) {
					if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
						$uploadStatus = 'File Upload Successful';
					}	
					else {
						$uploadStatus = 'File Upload unSuccessful';
						echo $uploadStatus;
						exit;
					}
				}
			/* END - Move File from temporary location to permanent directory*/

			/* PROCESS UPLOADED MUSIC CONTENT */
				$musicDir = '/upload/music/gigs/' . $_POST['gigId'] . '/'; 
				$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $musicDir;

				$randNumb = rand(1,50000);
				foreach($_FILES as $newFileType => $newIndivFile) {
					if($newFileType == "musicFile"){
						$target_file = $target_dir . basename($newIndivFile['name']); 
						$musicFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$musicFileSize = $newIndivFile['size'];

						if(count($newIndivFile) > 0){
							if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
								echo 'There was an upload error: ' . $newIndivFile['error'];
								exit;
							}
							elseif($musicFileType != '' && $musicFileType != "mp3"){
								echo 'Please Upload MP3 files Only!!!' . $musicFileType;
								exit;
							}
							elseif($musicFileSize != '' && $musicFileSize > 40000000) {
								echo 'Your File Size Must Be Less Than 40MB';
								exit;
							}
							else {
								$target_file_mus = $target_dir . $randNumb . str_replace(' ', '', $_POST['gigMusic_songName']) . '.' . $musicFileType;
								$newIndivFileMus = $newIndivFile; 
								$uploadMusStatus = 'upload';

								/* Add Video File Path to the post array */
									$_POST['gigMusic_songMp3Path'] = $musicDir . basename($target_file_mus);
							}
						} 
					}
					else{
						$target_file = $target_dir_thumb . basename($newIndivFile['name']); 
						$vidioFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$viddioFileSize = $newIndivFile['size'];
						
						if(count($newIndivFile) > 0){
							if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
								echo 'There was an upload error: ' . $newIndivFile['error'];
								exit;
							}
							elseif($vidioFileType != '' && $vidioFileType != "jpg") {
								echo 'Please Upload Image files Only!!!' . $vidioFileType;
								exit;
							}
							elseif($viddioFileSize != '' && $viddioFileSize > 1200000) {
								echo 'Your Image File Size Must Be Less Than 1.2MB';
								exit;
							}
							else {
								$target_file_thumb = $target_dir_thumb . $randNumb. str_replace(" ","",$postArray['videoName']) . '.' . $vidioFileType; 
								$uploadThumbStatus = 'upload';
								$newIndivFileThumb = $newIndivFile;
								$postArray['videoThumbnailPath'] = $thumbDir . basename($target_file_thumb);
							}
						}
					}
				}
				
				if($uploadMusStatus = 'upload'){
					if(file_exists($target_dir)) {
						moveFile($newIndivFileMus, $target_file_mus);
					}
					else {
						mkdir($target_dir,0777,true);	
						$uploadStatusMus = moveFile($newIndivFileMus, $target_file_mus);				
					}
				}
			/* END - PROCESS UPLOADED VIDEO CONTENT */	
		}
	}

	if($_POST){
		/* Handle artist submission from user's subscription list*/
			if($_POST['form'] == 'addSubArt'){
				//var_dump($_POST);
				foreach($_POST as $index => $postElement){
					if($index == $_POST['gigArtists_userId']){
						foreach($postElement as $index2 => $postElement2){
							if($postElement2 != ''){
								$POST[$index2] = $postElement2;
							}
						}
						$POST['gigArtists_userId'] = $_POST['gigArtists_userId'];
						$POST['gigId'] = $_POST['gigId'];
						$POST['table'] = $_POST['table'];

						break; // Stop loop 
					}
				}
				
				/* Assign the value 'group' to talent element if a group is being booked */
					if($POST['gigArtists_userType'] == 'group'){
						$POST['gigArtists_tal'] = 'group';
						unset($POST['gigArtists_userType']);
					}
					elseif($POST['gigArtists_userType'] == 'artist'){
						unset($POST['gigArtists_userType']);
					}
				/* END - Assign the value 'group' to talent element if a group is being booked */
			}
		/* END - Handle artist submission from user's subscription list*/

		/* Default Action is to insert into the perspective table */
			$action = 'insert';

		/* Determine if data is being updated or inserted */
			if($_POST['gigDetails_creationDate']){
				$action = 'insert';
				$_POST['gigDetails_creationDate'] = $today;
			}
			elseif($_POST['gigDetails_modifiedDateTime']){
				$action = 'update';
				$_POST['gigDetails_modifiedDateTime'] = $today;
			}	
			elseif($_POST['gigDetails_cancelDateTime']){
				$action = 'update';
				$_POST['gigDetails_cancelDateTime'] = $today;
				$_POST['gigDetails_modifiedDateTime'] = $today;
			}	
			elseif($_POST['table'] == 'removeSong' || $_POST['gigDetails_formStatus'] == 'deleted'){
				$action = 'delete';
			}
			elseif($_POST['artistViewed']){
				$action = 'update';
			}
			elseif($_POST['gigArtists_artistStatus']){
				$action = 'update';
			}
		/* END - Determine if data is being updated or inserted */

		/* Remove Empty elements from every $_POST array, excep the gigrequests $_POST */
			if($_POST['table'] != 'gigrequests' && $_POST['form'] != 'addSubArt'){
				foreach($_POST as $index0 => $value0){
					if($index0 == 'id'){
						foreach($value0 as $id){
							if($id != ''){
								$POST[$index0][] = $id; 
							}
						}
					}
					else{
						if($value0 != ''){
							$POST[$index0] = trim($value0); 
						}
					}
				}
			}
		/* END - Remove Empty elements from the $_POST array */

		/* Change the time formats for setup, start, and end times */
			function changeFormat($time,$date){
				$changeFormat = date_create($time);
				$changeFormat = date_format($changeFormat, 'H:i:s'); 
				$changeFormat = $date . ' ' . $changeFormat;
				return $changeFormat; 
			}
			if($POST['gigDetails_setupTime']){
				$POST['gigDetails_setupTime'] = changeFormat($POST['gigDetails_setupTime'], $POST['gigDetails_gigDate']);
				$POST['gigDetails_startTime'] = changeFormat($POST['gigDetails_startTime'], $POST['gigDetails_gigDate']);
				$POST['gigDetails_endTime'] = changeFormat($POST['gigDetails_endTime'], $POST['gigDetails_gigDate']);
			}
		/* END - Change the time formats for setup, start, and end times */
		
		/* Define vars and remove elements from $POST array */
			if($POST['table'] == 'removeSong' || $POST['table'] == 'addSong'){
				$table = 'gigmusic';
			}
			else{
				$table = $POST['table'];
			}
			unset($POST['table']);
			
			if($POST['emailClient']){
				// $emailClient = "Client Info"; 
				// $email_editInfoParam[] = "Client Info";
				unset($POST['emailClient']);
			}
			else{
				$emailClient = "";
			}
			if($POST['emailEventChange']){
				// $emailEventChange = "Gig Details"; 
				$email_editInfoParam[] ="Gig Details";
				unset($POST['emailEventChange']);
			}
			else{
				$emailEventChange = "";
			}
			if($POST['emailVenueChange']){
				// $emailVenueChange = "Venue Details"; 
				$email_editInfoParam[] = "Venue Details";
				unset($POST['emailVenueChange']);
			}
			else{
				$emailVenueChange = "";
			}
		/* END - Define vars and remove elements from $POST array */
		
		/************************************************** Define email Variables **************************************************/
			/* Query database for the gigDetails_gigManLoginId, gigDetails_gigManName, gigDetails_gigName */
				$emailParamQuery = 'SELECT gigdetails.gigDetails_gigManLoginId, gigdetails.gigDetails_gigManName, gigdetails.gigDetails_gigName, gigdetails.gigDetails_gigManEmail, gigdetails.gigDetails_gigName 
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
				
			$requestor = $emailParamResults['gigDetails_gigManEmail']; //$array['gigDetails_gigManLoginId']; 
			$requestorName = $emailParamResults['gigDetails_gigManName']; //$array['gigDetails_gigManName']; 
			$requestorUrl = 'http://www.gospelscout.com/views/artistprofile.php?artist=' . $emailParamResults['gigDetails_gigManLoginId']; 

			/* Query the database for all artists associated with the current gig id and define email vars for targeted artists */
				if($action == 'insert' && $table == 'gigartists'){
					$receiver = $POST['gigArtists_email'];
					$receiverName = $POST['gigArtists_name'] ;
					$talentRequested = str_replace("_", "/",$POST['gigArtists_tal']);
				}
				else{
					$gmCancStatus = 'active';
					$gaStatus1 = 'pending';
					$gaStatus2 = 'confirmed';

					/* Query the gigartists table for current artist's gigArtists_userId, gigArtists_name, gigArtists_tal */
						$getGigArtistsQuery = 'SELECT gigartists.gigArtists_email, gigartists.gigArtists_name, gigartists.gigArtists_tal, gigartists.gigArtists_userId
											   FROM gigartists 
											   WHERE gigartists.gigId = ? AND gigartists.gigArtists_gigManCancelStatus = ? AND (gigartists.gigArtists_artistStatus = ? OR gigartists.gigArtists_artistStatus = ?)';

						try{
							$getGigArtists = $db->prepare($getGigArtistsQuery);
							$getGigArtists->bindParam(1, $_POST['gigId']);
							$getGigArtists->bindParam(2, $gmCancStatus);
							$getGigArtists->bindParam(3, $gaStatus1);
							$getGigArtists->bindParam(4, $gaStatus2);
							$getGigArtists->execute(); 
						}
						catch(Exception $e){
							echo $e; 
						}
						$getGigArtistsResults = $getGigArtists->fetchAll(PDO::FETCH_ASSOC); 
	
					//Create a loop to call the appropriate email functions using the array above
				}
			/* END - Query the database for all artists associated with the current gig id and define email vars for targeted artists */
						
			$actionUrl = 'http://www.gospelscout.com/views/gigform.php?gigID=' .  $_POST['gigId']; 
			$gigName = $emailParamResults['gigDetails_gigName']; 
			$gigId = $_POST['gigId']; 
		/*********************************************** END - Define email Variables ***********************************************/
			
			
		if($_POST['srcPage'] == 'artistProfile' && $action == 'insert'){
			$gigId = $_POST['gigId'];
			$_POST['gigrequests']['gigrequests_artistName'] = $_POST['gigartists']['gigArtists_name'];

			foreach($_POST as $index => $value){
				if($index == 'gigdetails'){
					/* Change date and time format */
						if($value['gigDetails_setupTime']){
							$value['gigDetails_setupTime'] = changeFormat($value['gigDetails_setupTime'], $value['gigDetails_gigDate']);
							$value['gigDetails_startTime'] = changeFormat($value['gigDetails_startTime'], $value['gigDetails_gigDate']);
							$value['gigDetails_endTime'] = changeFormat($value['gigDetails_endTime'], $value['gigDetails_gigDate']);
						}
					/* END - Change date and time format */

					$value['gigId'] = $gigId;
					$gigDeets = true;  
					$value['gigDetails_creationDate'] = $today;
					
					foreach($value as $index4 => $element){
						if($element != ''){
							$detailsField[] = trim($index4);
							$detailsValue[] = trim($element);
						}
					}
				}
				elseif($index == 'gigartists'){
					$value['gigId'] = $gigId;
					foreach($value as $index2 => $element){
						if($element != ''){
							$artistsField[] = trim($index2);
							$artistsValue[] = trim($element);
						}
					}
				}
				elseif($index == 'gigrequests'){
					if($value["gigRequests_message"] != ''){
						/* Create a Unique Message ID */
							$gigManagerlName = $_POST['table'];
							$first4 = substr($gigManagerlName, 0, 2);
							$randSuffix = mt_rand(100, 999);
							$str = $first4 . $randSuffix; 
							$messageId = bin2hex($str);
							$value['gigRequests_messageID'] = $messageId;
							
						$value['gigId'] = $gigId;
						$request = true; 
						foreach($value as $index3 => $element){
							if($element != ''){
								$requestsField[] = trim($index3);
								$requestsValue[] = trim($element);
							}
						}
					}
				}
			}
				
			/* Insert artists info and request info into their repsective tables */
				$detailsTable = 'gigdetails';
				$artistTable = 'gigartists';
				$requestTable = 'gigrequests';	
 
				/* Test for existence of gig data b4 attempting to insert */
					if($gigDeets){
						$deetsInsert = $obj->insert($detailsField,$detailsValue,$detailsTable); // Gig Details
					}
					if($deetsInsert != $failMess){
						$artistInsert = $obj->insert($artistsField,$artistsValue,$artistTable);  // Artists Info
					}
					if($artistInsert != $failMess){
						if($request){
							$requestInsert = $obj->insert($requestsField,$requestsValue,$requestTable);  // Artist Requests 
						}
					}
				/* END - Test for existence of gig data b4 attempting to insert */

				$failMess = 'Enable to insert data in MySql Server.';
				if($deetsInsert != $failMess || $artistInsert != $failMess || $requestInsert != $failMess ){
					//Define Email Variables
					$requestor = $_POST["gigdetails"]['gigDetails_gigManEmail'];
					$requestorName = $_POST["gigdetails"]['gigDetails_gigManName'];
					$requestorUrl = 'https://dev.gospelscout.com/newHomePage/views/artistprofile.php?artist=' . $_POST["gigdetails"]['gigDetails_gigManLoginId']; 
					$receiver = $_POST["gigartists"]['gigArtists_email'];
					$receiverName = $_POST["gigartists"]['gigArtists_name'];
					$talentRequested = str_replace("_", "/",$_POST["gigartists"]['gigartists_tal']);
					$actionUrl = 'https://dev.gospelscout.com/newHomepage/views/gigform.php?gigID=' .  $_POST['gigId']; ;
					$gigName = $_POST["gigdetails"]['gigDetails_gigName'];
					$gigId = $_POST['gigId'];
					
					// Call artist request email function
					$receiver = 'kirkddrummond@yahoo.com';
					$bookingMail->request($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId);
					
					echo 'inserted';
				}
				else{
					echo 'At Least One Table Failed To Save Gig Data!!!';
				}
		}
		elseif($action == 'update'){
			/* Define gigId var and remove from post array */
				$gigId = $POST['gigId'];
				unset($POST['gigId']);
				$cond = ' gigId = "' . $gigId . '"';
				
				if($POST['emailClient']){
					$emaiClient = true; 
					unset($POST['emailClient']);
				}
			
			/* Define artist user ID var when artist is updating their gig status */
				if($POST['gigArtists_artistStatus']){
					$artistID = $POST['gigArtists_userId'];
					$cond .= ' AND gigArtists_userId = ' . $artistID; 
					unset($POST['gigArtists_userId']);
					// var_dump($POST);
					// exit;
				}

			/* When determining if an artist has viewed a gig */
				if($_POST['artistViewed']){
					$artistId = $POST['gigArtists_userId'];
					unset($POST['gigArtists_userId']);
					$cond .= ' AND gigArtists_userId = ' . $artistId; 
				}

			/* Create field and value arrays for the update and insert functions */
				foreach($POST as $index1 => $value1){
					$field[] = $index1; 
					$value[] = $value1; 
				}
			/* END - Create field and value arrays for the update and insert functions */

			/* PDO Update Statement */
				$columuns = '';
				$count = count($POST);
				$j = 1; 
				foreach($POST as $index1 => $value1){
					if($j == $count){
						$columuns .= $index1 . ' = "' . $value1 . '"';
					}
					else{
						$columuns .= $index1 . ' = "' . $value1 . '", '; 
					}
					$j++;
				}
				$query = 'UPDATE ' . $table . ' SET ' . $columuns . ' WHERE ' . $cond;

				try{
					$updateGig = $db->prepare($query);
					$updateSucc = $updateGig->execute(); 
					
					/*Check for successful update to the database */
						if($updateSucc && !($POST['artistViewed'])){

							/* Trigger email to artists */
								if($POST['gigDetails_cancelReason']){ // Gig Manager Cancels Entire gig
									foreach($getGigArtistsResults as $indivEmail){
										//Define artist variables
										// $receiver = $indivEmail['gigArtists_email'];
										$receiverName = $indivEmail['gigArtists_name'];
										$talentRequested = $indivEmail['gigArtists_tal'];
										$reason = $POST['gigDetails_cancelReason'];

										//Trigger gig cancellation email function
										$receiver = 'kirkddrummond@yahoo.com';
										$bookingMail->cancellation($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $reason);
									}
								}
								elseif($artistID){ //Artist Changes their gig Status
									foreach($getGigArtistsResults as $indivEmail){
										if($artistID == $indivEmail['gigArtists_userId']){
											// $receiver = $indivEmail['gigArtists_email'];
											$receiverName = $indivEmail['gigArtists_name'];
											$talentRequested = $indivEmail['gigArtists_tal'];
										}
									}

									$requestor = 'kirkddrummond@yahoo.com';
									$receiver = 'kirkddrummond@yahoo.com';
									$receiverResponse = $POST['gigArtists_artistStatus'];
									// Send Email only to the gig manager
									$bookingMail->status($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $receiverResponse, $actionUrl, $gigName, $gigId, $status);
								}
								else{ // All other gig updates
									/* Create a loop to send an email to all artists active on this gig */
										foreach($getGigArtistsResults as $indivEmail){
											//Define artist variables
											// $receiver = $indivEmail['gigArtists_email'];
											$receiverName = $indivEmail['gigArtists_name'];
											$talentRequested = $indivEmail['gigArtists_tal'];

											$receiver = 'kirkddrummond@yahoo.com';
											//Trigger the gig update email function for gig, venue, client updates
											if($email_editInfoParam){
											$bookingMail->update($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $email_editInfoParam);
											}
										}
									/* END - Create a loop to send an email to all artists active on this gig */
								}

								//Trigger email to clients
								if($emaiClient == true){
									//email client
								}
							/* END - Trigger email to artists */

							echo 'updated';
						}
				}
				catch(Exception $e){
					echo $e; 
				}
		}
		elseif($action == 'insert'){
			
			if($_POST['table'] == 'gigrequests'){

				/* functionality to allow the server to insert multiple gig requests rows simultaneously - One request for multiple artists */
					/* Create a Unique Message ID */
						$gigManagerlName = $_POST['table'];
						$first4 = substr($gigManagerlName, 0, 2);
						$randSuffix = mt_rand(100, 999);
						$str = $first4 . $randSuffix; 
						$messageId = bin2hex($str);
						$_POST['gigRequests_messageID'] = $messageId;


					/* Define table var and remove table from $_POST array */
						$table = $_POST['table'];
						unset($_POST['table']);
					

					/* Determine if the request is for all artists vs a specified subset */
						if($_POST['gigRequests_everyone']){
							/* If request for all artists, remove the individually listed artists from the array */
								unset($_POST['gigrequests_artistName']);
								foreach($_POST as $index2 => $element2){
									$field[] = $index2; 
									$value[] = $element2; 
								}
								$requestSucc = $obj->insert($field,$value,$table);
								
								/* Send email to all gig artist upon successful submission to the database */
									if($requestSucc > 0){
										//Create a loop to using an array containing artist's emails
										// call update() with artist-request param
										foreach($getGigArtistsResults as $indivEmail){
											//Define artist variables
											// $receiver = $indivEmail['gigArtists_email'];
											$receiverName = $indivEmail['gigArtists_name'];
											$talentRequested = $indivEmail['gigArtists_tal'];

											$receiver = 'kirkddrummond@yahoo.com';
											$email_editInfoParam = "";
											$email_editInfoParam[] = 'Gig Requests';
											$bookingMail->update($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $email_editInfoParam);
										}
									}
						}
						else{
							/* User loop to create the $field and $value arrays to be used in the insert function */
								foreach($_POST as $index => $element){
									if($index == 'gigrequests_artistName'){
										foreach($element as $index1 => $element1){
											$_POST['gigRequests_artistUserId'] = $index1;
											$_POST['gigrequests_artistName'] = $element1;
											
											/* Reset the $field and $value arrays each cylce of the loop */
												$field = '';
												$value = '';

											foreach($_POST as $index2 => $element2){
												$field[] = $index2; 
												$value[] = $element2; 
											}
											$requestSucc = $obj->insert($field,$value,$table);
											
											/* Send email to all gig artist upon successful submission to the database */
												if($requestSucc > 0){
													// call update() with artist-request param
													foreach($getGigArtistsResults as $allArtist){
														if($index1 == $allArtist['gigArtists_userId']){

															// $receiver = $allArtist['gigArtists_email'];
															$receiverName = $allArtist['gigArtists_name'];;
															$talentRequested = $allArtist['gigArtists_tal'];

															$receiver = 'kirkddrummond@yahoo.com';
															$email_editInfoParam = "";
															$email_editInfoParam[] = 'Gig Requests';
															$bookingMail->update($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $email_editInfoParam);
														}
													}
												}
										}
									}
								}
						}
						echo 'inserted';
				/* functionality to allow the server to insert multiple gig requests rows simultaneously - One request for multiple artists */
			}
			else{
				/* Create field and value arrays for the update and insert functions */
					foreach($POST as $index1 => $value1){
						$field[] = $index1; 
						$value[] = $value1; 
					}
				/* END - Create field and value arrays for the update and insert functions */
				
				$rowId = $obj->insert($field,$value,$table);
				
				if($rowId > 0){
					if($table == 'gigartists' ){
						// Call artist request email function
						$receiver = 'kirkddrummond@yahoo.com';
						$bookingMail->request($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId);
					}
					elseif($table == 'gigmusic'){
						// call update() email function w/ music added param
						foreach($getGigArtistsResults as $indivEmail){
							//Define artist variables
							// $receiver = $indivEmail['gigArtists_email'];
							$receiverName = $indivEmail['gigArtists_name'];
							$talentRequested = str_replace("_", "/",$indivEmail['gigArtists_tal']);

							$receiver = 'kirkddrummond@yahoo.com';
							$email_editInfoParam = "";
							$email_editInfoParam[] = 'Gig Music';
							$bookingMail->update($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $email_editInfoParam);
						}
					}
					echo 'inserted';
				}
			}
		}
		elseif($action == 'delete'){

			if($table == 'gigmusic' && $action == 'delete'){
				foreach($POST['id'] as $songID){ 
					$cond = 'id = ' . $songID; 
					$deleteSucc = $obj->delete($table,$cond);
					
					if($deleteSucc == 1){
						//call the update() email function with music removed param
						foreach($getGigArtistsResults as $indivEmail){
							//Define artist variables
							// $receiver = $indivEmail['gigArtists_email'];
							$receiverName = $indivEmail['gigArtists_name'];
							$talentRequested = $indivEmail['gigArtists_tal'];

							$receiver = 'kirkddrummond@yahoo.com';
							$email_editInfoParam = "";
							$email_editInfoParam[] = 'Gig Music';
							$bookingMail->update($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $email_editInfoParam);
						}
					} 
				}
			}
			elseif($table == 'gigdetails' && $action == 'delete'){
				
			}
			echo 'deleted';
		}
		
	}
	elseif($_GET){
		/* Update the gigartist table gigArtists_artistStatus column with artist's repsonse */
			$cond = 'gigId = "' . $_GET['gigId'] . '" AND gigArtists_userId = "' . $_GET['gigArtists_userId'] . '"'; 
			$query = 'UPDATE gigartists SET gigArtists_artistStatus = "' . $_GET['gigArtists_artistStatus'] . '" WHERE ' . $cond; 

			try{
				$artistAction = $db->prepare($query);
				$artistAction->execute(); 
			}
			catch(Exception $e){
				echo $e; 
			}
	}
