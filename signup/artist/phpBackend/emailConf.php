 <?php

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		
	if($_POST['confirmCode']){
		/* Create a randomly generated confirmation # */
			$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
			$confCode = substr($random_hash, 6, 6);

		/* Set the confirmation code in the session variable */
			extract($_POST);
 			$objsession->set('verification_code',$confCode); 
			
		/* send email */
			$email_sent = newUserConf($newUserEmail, $newUserName, $confCode);
			foreach ($email_sent as $key => $value) {
				$email_response[$key] = $value; 
			}

			if( $email_response['errorcode'] == 0 && $email_response['message'] == 'OK'){
				$response['success'] = true;
			}else{
				$response['success'] = false;
				$response['errorcode'] = $email_response['errorcode'];
				$response['message'] = $email_response['message'];
			}

		/* Return JSON Response */
				echo json_encode($response);

		/* END - Return send confcode email & uniqueID to the artist.php page upon successful insertion into the signupcodeconfirmationmaster table */
	}
	// elseif($_POST['verificationCode']){
	// 	/* compare conf ids */
	// 		$userEnteredConf = trim($_POST['verificationCode']);
	// 		$getVerification = $objsession->get('verification_code');

	// 	/* If a uniqueID exists query the signupcodeconfirmationmaster table for the confcode matching the unique Id */
	// 		if($userEnteredConf != '' && $getVerification != '' ){
	// 			/* If user-entered ConfCode and stored confcode match, send codeValid message to artist.php */
	// 				if($getVerification == $userEnteredConf){
	// 					$response['code_valid'] = true;
	// 				}
	// 				else{
	// 					$response['code_valid'] = false;
	// 					$response['error'] = 'Verification code invalid';
	// 				}
	// 			/* END - If user-entered ConfCode and stored confcode match, send codeValid message to artist.php */
	// 		}
	// 		else{
	// 			$response['code_valid'] = false;
	// 			$response['error'] = 'No Verification ID';
	// 		}
	// 	/* END - If a uniqueID exists query the signupcodeconfirmationmaster table for the confcode matching the unique Id */

	// 	echo json_encode($response);
	// }	
	
?>