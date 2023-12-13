<?php

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	
	if($_POST['confirmCode']){
		/* Create a randomly generated confirmation # */
			$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
			$confCode = substr($random_hash, 6, 6);
		/* END - Create a randomly generated confirmation # */

		/* Create a randomly generated uniqueID */
			$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
			$uniqueID = substr($random_hash, 6, 8);
		/* END - Create a randomly generated uniqueID */

		/* Insert the confcode and uniqueID into the signupcodeconfirmationmaster table */
			$codeArray = array(
						'confCode' => $confCode,
						'uniqueID' => $uniqueID
					);
			foreach($codeArray as $index => $value0){
				$field[] = $index;
				$value[] = $value0;
			}
			
			$table = 'signupcodeconfirmationmaster';
			$newInsert = $obj->insert($field,$value,$table);
		/* END - Insert the confcode and uniqueID into the signupcodeconfirmationmaster table */

		/* Return send confcode email & uniqueID to the artist.php page upon successful insertion into the signupcodeconfirmationmaster table */
			if($newInsert){
				extract($_POST);
				if($_POST['emailCount'] < 4){
					//require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Email/emailFunctions.php'); 
					$email_sent = newUserConf($newUserEmail, $newUserName, $confCode);
					
					$response['api_resp'] = $email_sent; 
					$response['unique_id'] = $uniqueID;
					$response['email_err'] = false;
				}
				else{
					$response['api_resp'] = false; 
					$response['unique_id'] = false;
					$response['email_err'] = 'too_many_attempts';
				}
			}
			else{
				$response['api_resp'] = false; 
				$response['unique_id'] = false;
				$response['email_err'] = 'unique_id_insert_fail';
			}
			
			/* Return JSON Response */
				echo json_encode($response);
				
		/* END - Return send confcode email & uniqueID to the artist.php page upon successful insertion into the signupcodeconfirmationmaster table */
	}
	elseif($_POST['checkConfCode']){
		/* Define the user-entered Confirmation code and uniqueID vars */
			$userEnteredConf = trim($_POST['checkConfCode']);
			$uniqueID = trim($_POST['uniqueID']);
		/* END - Define the user-entered Confirmation code and uniqueID vars */

		/* If a uniqueID exists query the signupcodeconfirmationmaster table for the confcode matching the unique Id */
			if($uniqueID != ''){
				$getConfCodeQuery = 'SELECT signupcodeconfirmationmaster.confCode FROM signupcodeconfirmationmaster WHERE uniqueID = ?';

				try{
					$getConfCode = $db->prepare($getConfCodeQuery);
					$getConfCode->bindParam(1, $uniqueID);
					$getConfCode->execute(); 
					$Results = $getConfCode->fetch(PDO::FETCH_ASSOC);
				}
				catch(Exception $e){
					echo 'Failed to contact the database: ' . $e; 
				}

				/* If user-entered ConfCode and stored confcode match, send codeValid message to artist.php */
					if($Results['confCode'] == $userEnteredConf){
						echo 'codeValid';
					}
					else{
						echo 'codeInvalid';
					}
				/* END - If user-entered ConfCode and stored confcode match, send codeValid message to artist.php */
			}
			else{
				echo 'Error Message: No Unique ID';
			}
		/* END - If a uniqueID exists query the signupcodeconfirmationmaster table for the confcode matching the unique Id */
	}	
	
?>