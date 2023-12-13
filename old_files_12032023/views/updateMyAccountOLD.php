<?php
	/* Update My Account Info */

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

//var_dump($_POST);
//exit;
	$table = $_POST['table'];

	if($table == 'usermaster'){

		/* Update Usermaster table information */

		$cond = 'iLoginID = '. $_POST['iLoginID'];
		unset($_POST['table']);
		unset($_POST['iLoginID']);

		/* Trim fields - Remove any empty fields - Create Arrays for table Update function */
			foreach($_POST as $index => $fields){
				if(trim($fields) == ''){
					unset($_POST[$index]);
				}
				else{
					$field[] = $index; 
					$value[] = trim($fields); 
				}
			}

		/* Echo Error if it exists */
			if($error){
				echo $error; 
			}
			else{
				$obj->update($field,$value,$cond,$table);
				echo 'Your Account Has Been Updated!!!';
			}
	}
	elseif($table == 'loginmaster'){
		/*
			2. Login Info
				a. loginmaster	
				In order to change the login email and password.  An email confirmation has to be sent to the user and a conf code has to be retrieved from the email	
		*/
		//echo 'this is login';
		// var_dump($_POST);
		// echo 'you dig';

		$password = trim($_POST['sPassword']);
		$confPassword = trim($_POST['sConfPassword']);
		// echo $_POST['sPassword'];

		/* Hash and Update password */
			$hashPass = md5($password);
			$_POST['sPassword'] = $hashPass;
		
		if($_POST['checkPword'] == 1){
			$currentPass = $obj->fetchRow($table, 'iLoginID = ' . $_POST['iLoginID']);
			// var_dump($currentPass);

			if($currentPass['sPassword'] == $hashPass){
				echo 'pwrdValid';
			}
			else{
				echo 'pwrdInvalid';
			}
		}
		else{
			if($password !== $confPassword){
				echo 'Password Mismatch!!!';
			}
			// elseif($_POST['sPassword'] /* Length is Too short */){
			// 	echo 'Password Does Not Meet the Length Requirements!!!';
			// }
			// elseif(/* Password not complex enough */){
			// 	echo 'Password Does Not Meet the Complexity Requirements!!!'; . ' AND sEmailID = ' . $_POST['sEmailID'] . ' AND sUserType = ' . $_POST['sUserType'] . 
			// }
			else{
				 /*Set Update Conditions */
				 	$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND isActive = 1';

				/* Remove Unnecessary $_POST elements */
					unset($_POST['sConfPassword']);
					unset($_POST['sCurrentPassword']);
					unset($_POST['table']);
					unset($_POST['sEmailID']);
					unset($_POST['sUserType']);
					unset($_POST['iLoginID']);


				

				/* Trim fields - Remove any empty fields - Create Arrays for table Update function */
					foreach($_POST as $index => $fields){
						if(trim($fields) == ''){
							unset($_POST[$index]);
						}
						else{
							$field[] = $index; 
							$value[] = trim($fields); 
						}
					}
					
					$pwrdStatus = $obj->update($field,$value,$cond,$table);
					echo $pwrdStatus;
			}
		}
	}
	elseif($table == 'churchtimeing'){
		
		
		if($_POST['removeServTime']){
			foreach($_POST['removeServTime'] as $servTimeID){
				$lastServTime = $obj->fetchRowAll($table, 'iLoginID = ' . $_POST['iLoginID']);
				
				$servTimeRemain = count($lastServTime);
				if($servTimeRemain > 1){
					$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND iTimeID = ' .  $servTimeID;
					$obj->delete($table, $cond);
					// echo 'This Service Time Has Been Removed';
				}
				else{
					echo 'Church Profiles Must Have At Least One Service Time!!!';
				}
			}
		}
		else{
			
			$formatChange = date_create($_POST['serviceTime']);
			$formatChange = date_format($formatChange, 'H:i:s');
			$_POST['serviceTime'] = $formatChange; 

			/* Verify that the church does not already have this service time - if not then add it to their list of service times */
				$hasServTimeQuery = 'SELECT * 
									 FROM churchtimeing
									 WHERE iLoginID = ? AND serviceTime = ? AND sTitle = ?';
				try{
					$hasServTime = $db->prepare($hasServTimeQuery);
					$hasServTime->bindParam(1, $_POST['iLoginID']);
					$hasServTime->bindParam(2, $_POST['serviceTime']);
					$hasServTime->bindParam(3, $_POST['sTitle']);
					$hasServTime->execute(); 
				}
				catch(Exception $e){
					echo $e; 
				}
				$timeResults = $hasServTime->fetchAll(PDO::FETCH_ASSOC);

				if($timeResults){
					echo 'You Have Already Added This Service Time!!!';
				}
				else{
					/* Remove Unnecessary elements from the $_POST array */
						unset($_POST['table']);

					/* Create $field and $value Arrays to be used in the Insert function */
						foreach($_POST as $index => $fields){
							if(trim($fields) == ''){
								unset($_POST[$index]);
							}
							else{
								$field[] = $index; 
								$value[] = trim($fields); 
							}
						}

					/* Insert church's newly added talent into the churchministrymaster2 table */
						$obj->insert($field,$value,$table);
				}
		}
	}
	elseif($table == 'churchministrymaster2'){

		/* Update Church Ministries */
			if($_POST['removeChurchMin']){
				foreach($_POST['removeChurchMin'] as $minID){
					if($minID == '15'){
						echo 'Church Profiles Must Have At Least A Preaching/Teaching Ministry!!!';
					}
					else{
						$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND iGiftID = ' .  $minID;
						$succesTrigger = $obj->delete($table, $cond);
					}
				}
			}
			elseif($_POST['addChurchMin']){
				/* Verify that the artist does not already have this talent - if not then add it to their list of talents */
					$hasMin = $obj->fetchRow($table, 'iLoginID = ' . $_POST['iLoginID'] . ' AND iGiftID = ' . $_POST['addChurchMin']);
					
					if($hasMin){
						echo 'You Have Already Added This Ministry!!!';
					}
					else{

						/* Fetch ministry name to be inserted into the churchministrymaster2 table with id */
							$minName = $obj->fetchRow('giftmaster1', 'iGiftID = ' . $_POST['addChurchMin']);
							
						/* Add ministry name and ministry id to the POST array - Unset Un-needed elements*/
							$_POST['sGiftName'] = $minName['sGiftName'];
							$_POST['iGiftID'] = $minName['iGiftID'];
							unset($_POST['table']);
							unset($_POST['addChurchMin']);

						/* Create $field and $value Arrays to be used in the Insert function */
							foreach($_POST as $index => $fields){
								if(trim($fields) == ''){
									unset($_POST[$index]);
								}
								else{
									$field[] = $index; 
									$value[] = trim($fields); 
								}
							}
						
						/* Insert church's newly added talent into the churchministrymaster2 table */
							$obj->insert($field,$value,$table);
					}
			}
	}
	elseif($table == 'churchamenitymaster2'){
		 
		if($_POST['removeAmenity']){
			foreach($_POST['removeAmenity'] as $amenID){
				$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND amenityID = ' .  $amenID;
				$succesTrigger = $obj->delete($table, $cond);
			}
		}
		elseif($_POST['addAmenity']){
			/* Verify that the church does not already have this amenity - if not then add it to their list of amenities*/
				$hasAmen = $obj->fetchRow($table, 'iLoginID = ' . $_POST['iLoginID'] . ' AND amenityID = ' . $_POST['addAmenity']);

				if($hasAmen){
					echo 'You Have Already Added This Amenity!!!';
				}
				else{

					/* Fetch ministry name to be inserted into the churchministrymaster2 table with id */
						$AmenName = $obj->fetchRow('amenitimaster', 'iAmityID = ' . $_POST['addAmenity']);
						
					/* Add ministry name and ministry id to the POST array - Unset Un-needed elements*/
						$_POST['amenityName'] = $AmenName['sAmityName'];
						$_POST['amenityID'] = $AmenName['iAmityID'];
						unset($_POST['table']);
						unset($_POST['addAmenity']);

					/* Create $field and $value Arrays to be used in the Insert function */
						foreach($_POST as $index => $fields){
							if(trim($fields) == ''){
								unset($_POST[$index]);
							}
							else{
								$field[] = $index; 
								$value[] = trim($fields); 
							}
						}
					
					/* Insert church's newly added talent into the churchministrymaster2 table */
						$obj->insert($field,$value,$table);
				}
		}
	}
	elseif($table == 'talentmaster'){

		/* Update Artist's Talent */
		
		if($_POST['removeArtistTal']){
			
			$table2 = 'artistvideomaster';
			$table3 = 'videocomments';
			$table4 = 'videocommentreplies';
			foreach($_POST['removeArtistTal'] as $talID){
				$lastTalent = $obj->fetchRowAll($table, 'iLoginID = ' . $_POST['iLoginID']);
				
				$talentsRemain = count($lastTalent);
				if($talentsRemain > 1){
					$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND TalentID = ' .  $talID;
					$cond2 = 'iLoginID = ' . $_POST['iLoginID'] . ' AND VideoTalentID = ' .  $talID;

					/* Query the artistvideomaster table for the current video's data */
						$currentVideos = $obj->fetchRowAll($table2, $cond2);

					/* Remove Video entries from the artistvideomaster and talentmaster tables */
						$obj->delete($table, $cond);
						$obj->delete($table2, $cond2);

					/* Remove video files, thumbnails, comments and comment replies for the current video */	
						foreach($currentVideos as $vid){
							/* Delete video's current thumbnail photo from the server */
								$fileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $vid['videoThumbnailPath'];
								if(file_exists($fileRemoved)){
									$fileDeleted = unlink($fileRemoved);
									// var_dump($fileDeleted);
								}

							/* Delete current video from the server */
								$vidFileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $vid['videoPath'];
								if(file_exists($vidFileRemoved)){
									$vidFileDeleted = unlink($vidFileRemoved);
									// var_dump($vidFileDeleted);
								}
						
							/* Remove video comments and comment replies for the current video */
								$cond3 = 'videoID = ' . $vid['id'];
								 $obj->delete($table3, $cond3);
								 $obj->delete($table4, $cond3);
						}
				}
				else{
					echo 'Artists Profiles Must Have At Least One Talent!!!';
				}
				
			}
		}
		elseif($_POST['addArtistTal']){
			/* Verify that the artist does not already have this talent - if not then add it to their list of talents */
				$hasTal = $obj->fetchRow($table, 'iLoginID = ' . $_POST['iLoginID'] . ' AND TalentID = ' . $_POST['addArtistTal']);
				
				if($hasTal){
					echo 'You Have Already Added This Talent!!!';
				}
				else{
					/* Fetch Talent name to be inserted into the talentmaster table with id */
						$talName = $obj->fetchRow('giftmaster', 'iGiftID = ' . $_POST['addArtistTal']);

					/* Add talent name and talent id to the POST array - Unset Un-needed elements*/
						$_POST['talent'] = $talName['sGiftName'];
						$_POST['TalentID'] = $_POST['addArtistTal'];
						unset($_POST['table']);
						unset($_POST['addArtistTal']);

					/* Create $field and $value Arrays to be used in the Insert function */
						foreach($_POST as $index => $fields){
							if(trim($fields) == ''){
								unset($_POST[$index]);
							}
							else{
								$field[] = $index; 
								$value[] = trim($fields); 
							}
						}
					
					/* Insert artist's newly added talent into the talentmaster table */
						$obj->insert($field,$value,$table);
				}
		}
	}
	elseif($_POST['table'] == 'groupmembersmaster'){
		$table = $_POST['table'];

		if($_POST['removeMember']){
			/* Remove the member one at a time using foreach loop from the groupmembersmaster table based on id */
			if(count($_POST["removeMember"]) > 0){
				foreach($_POST["removeMember"] as $memberID){
					$cond = 'id = ' . $memberID;
					$obj->delete($table, $cond);
				}
			}
		}
		elseif($_POST['talentID']){
			/* Define Correct $_POST array element */
				$_POST['groupiLoginID'] = $_POST['iLoginID'];

			/* Remove unneccessary $_POST array elements */
				unset($_POST['todaysDate']);
				unset($_POST['iLoginID']);
				unset($_POST['table']);
				
				//var_dump($_POST); 
				//exit;

			/* Create $field and $value Arrays to be used in the Insert function */
				foreach($_POST as $index => $fields){
					if(trim($fields) == ''){
						unset($_POST[$index]);
					}
					else{
						$field[] = $index; 
						$value[] = trim($fields); 
					}
				}
					
			/* Insert artist's newly added talent into the talentmaster table */
				$obj->insert($field,$value,$table);

			
		}
	}

?>