<?php
	/* Update My Account Info */

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	$table = $_POST['table'];

	if($table == 'usermaster'){

		/* Update Usermaster table information */

		$cond = 'iLoginID = '. $_POST['iLoginID'];
		$user_type = $_POST['u_type'];
		$loginID = $_POST['iLoginID'];
		unset($_POST['u_type']);
		unset($_POST['table']);
		unset($_POST['iLoginID']);
		

		// if($_POST['sCityName']){
			/* CHANGE THE CODE TO ONLY ALLOW USERS TO INPUT A ZIPCODE AND STATE AND STREET ADDRESS(CHURCHES), NOT A CITY NAME */

			// $name = trim($_POST['sCityName']);
			// $queryCity = 'SELECT * FROM cities WHERE name = ?';
			// try{
			// 	$getCity = $db->prepare($queryCity);
			// 	$getCity->bindParam(1, $name);
			// 	$getCity->execute(); 
			// }
			// catch(Exception $e){
			// 	echo $e; 
			// }
			// $results = $getCity->fetch(PDO::FETCH_ASSOC); 
			
			// if($results){
			// 	if($_POST['sStateName'] && $_POST['sStateName'] != $results['state_id']){
			// 			$error = 'There is a City/State Mismatch!!!';
			// 	}
			// 	else{
			// 		$_POST['sCityName'] = $results['id'];
			// 	}
			// }
			// else{
			// 	$error = 'Your City Name Is Not In Our Database.  Please Contact Our Support Team!!!';

			// }
		// }
		
		/* Process New Profile Img */
			if($_FILES['sProfileName']['size'] > 0 && $_FILES['sProfileName']['error'] == 0){

				/**** Create correct directory corresponding to church vs artist ****/
					if($user_type == 'artist' || $user_type == 'group'){
						$profPicDir = '/upload/artist/' . $loginID . '/';
					}
					elseif($user_type == 'church'){ 
						$profPicDir = '/upload/church/' . $loginID . '/';
					}
				/* END - Create correct directory corresponding to church vs artist */

				/* Move File from temporary location to permanent directory*/
					function moveFiles($FILES, $targetFile) {
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

				/* Create real path of the directory */
					$target_dir_profPic =  realpath($_SERVER['DOCUMENT_ROOT']) .  $profPicDir;

				/* Create random numeric prefix for img file */
					$randNumb = rand(1,50000);

				/* Define vars for img type, size, and permanent location */
					$target_file = $target_dir_profPic . basename($_FILES['sProfileName']['name']); 
					$imgFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$imgFileSize = $_FILES['sProfileName']['size'];
					$m_type = mime_content_type($_FILES['sProfileName']['tmp_name']);
					$pos = strpos($m_type, 'image');

				/* Conditional to test that file meets approved site criteria */
					if(!empty($_FILES['sProfileName']['error']) && $_FILES['sProfileName']['error'] != 4){
						echo 'There was an upload error: ' . $_FILES['sProfileName']['error'];
						exit;
					}
					elseif($pos === false || $pos != 0) {
						echo 'Please Upload Image files Only!!!' . $vidioFileType;
						exit;
					}
					elseif($imgFileSize != '' && $imgFileSize > 5000000) {
						echo 'Your Image File Size Must Be Less Than 1.2MB';
						exit;
					}
					else {
						$target_file_profPic = $target_dir_profPic . $randNumb. str_replace(" ","",$_FILES['sProfileName']['name']); 
						$uploadProfPicStatus = 'upload';
						$_POST['sProfileName'] = $profPicDir . basename($target_file_profPic);
					}

					/* Move profile image form temp to permanent location */
						if($uploadProfPicStatus == 'upload'){
							if(file_exists($target_dir_profPic)) {
								moveFiles($_FILES['sProfileName'], $target_file_profPic);
							}
							else {
								mkdir($target_dir_profPic,0777,true);	
								$uploadStatusThumb = moveFiles($_FILES['sProfileName'], $target_file_profPic);
							}
						}
			}

		/* Trim fields - Remove any empty fields - Create Arrays for table Update function */
			foreach($_POST as $index => $fields){
				if(trim($fields) == ''){
					unset($_POST[$index]);
				}
				else{
					$field[] = $index; 
					$value[] = trim($fields);
					$updateArray[$index] = trim($fields);
				}
			}

		/* Echo Error if it exists */
			if($error){
				echo $error; 
			}
			else{
				$updateSussess = updateTable($db, $updateArray, $cond, $table);
				echo 'Your Account Has Been Updated!!!';
			}
	}
	elseif($table == 'loginmaster'){
		/*
			2. Login Info
				a. loginmaster	
				In order to change the login email and password.  An email confirmation has to be sent to the user and a conf code has to be retrieved from the email	
		*/

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
					if($minID == 'Preaching_Teachings'){
						echo 'Church Profiles Must Have At Least A Preaching/Teaching Ministry!!!';
						exit;
					}
					else{
						$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND sGiftName = "' .  trim($minID) .'"';
						$succesTrigger = $obj->delete($table, $cond);

						/* Define arrays to Update churchministrymaster table */
							$field1[] = $minID;
							$value1[] = 0; 
					}
				}

				/* Update churchministrymaster table */
					$cond1 = 'iLoginID=' . $_POST['iLoginID'];
					$table1 = 'churchministrymaster';
					$obj->update($field1,$value1,$cond1,$table1);
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

						/* Update the churchministrymaster table */
							$field1[] = $_POST['sGiftName'];
							$value1[] = 1; 
							$cond1 = 'iLoginID=' . $_POST['iLoginID'];
							$table1 = 'churchministrymaster';
							$obj->update($field1,$value1,$cond1,$table1);
					}
			}
	}
	elseif($table == 'churchamenitymaster2'){
		 
		if($_POST['removeAmenity']){
			foreach($_POST['removeAmenity'] as $amenID){
				$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND amenityID = ' .  $amenID;
				$succesTrigger = $obj->delete($table, $cond);

				/* Define array to Update churchamenitymaster table */
					$field1[$amenID] = 0;
			}

			/* Update the churchamenitymaster table */
				$cond1 = 'iLoginID= "' . $_POST['iLoginID'] . '"';
				$table1 = 'churchamenitymaster';
				$updSucc = updateTable($db, $field1, $cond1, $table1);
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

					/* Update the churchamenitymaster table */
						$field1[$_POST['amenityID']] = 1;
						$cond1 = 'iLoginID= "' . $_POST['iLoginID'] . '"';
						$table1 = 'churchamenitymaster';
						
						$updSucc = updateTable($db, $field1, $cond1, $table1);
						// $obj->update($field1,$value1,$cond1,$table1);
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
				$lastTalent = $obj->fetchRowAll($table, 'iLoginID = ' . $_POST['iLoginID'],$db);

				$talentsRemain = count($lastTalent);
				if($talentsRemain > 1){
					$cond = 'iLoginID = ' . $_POST['iLoginID'] . ' AND TalentID = ' .  $talID;
					$cond2 = 'iLoginID = ' . $_POST['iLoginID'] . ' AND VideoTalentID = ' .  $talID;

					/* Query the artistvideomaster table for the current video's data */
						$currentVideos = $obj->fetchRowAll($table2, $cond2,$db);

					/* Remove Video entries from the artistvideomaster and talentmaster tables */
						$obj->delete($table, $cond,$db);
						$obj->delete($table2, $cond2,$db);

					/* Remove video files, thumbnails, comments and comment replies for the current video */	
						foreach($currentVideos as $vid){
							/* Delete video's current thumbnail photo from the server */
								$fileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $vid['videoThumbnailPath'];
								if(file_exists($fileRemoved)){
									$fileDeleted = unlink($fileRemoved);
								}

							/* Delete current video from the server */
								$vidFileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $vid['videoPath'];
								if(file_exists($vidFileRemoved)){
									$vidFileDeleted = unlink($vidFileRemoved);
								}
						
							/* Remove video comments and comment replies for the current video */
								// $cond3 = 'videoID = ' . $vid['id'];
								//  $obj->delete($table3, $cond3);
								//  $obj->delete($table4, $cond3);
						}
				}
				else{
					echo 'Artists Profiles Must Have At Least One Talent!!!';
				}
				
			}
		}
		elseif($_POST['addArtistTal']){
			/* Verify that the artist does not already have this talent - if not then add it to their list of talents */
				$hasTal = $obj->fetchRow($table, 'iLoginID = ' . $_POST['iLoginID'] . ' AND TalentID = ' . $_POST['addArtistTal'], $db);
				
				if($hasTal){
					echo 'You Have Already Added This Talent!!!';
				}
				else{
					/* Fetch Talent name to be inserted into the talentmaster table with id */
						$talName = $obj->fetchRow('giftmaster', 'iGiftID = ' . $_POST['addArtistTal'], $db);

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
						// $test = $obj->insert($field,$value,$table);
						$insertSucc = pdoInsert($db,$field,$value,$table);
						// var_dump($insertSucc);
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