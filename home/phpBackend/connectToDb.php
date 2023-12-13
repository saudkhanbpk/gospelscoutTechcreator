<?php 
	 require(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');


	 /* Back end form validation */
	 	if( $_POST ){
	 		
	 		/* Create Validation Loop */
	 			foreach($_POST as $index => $value){
	 				if($index == 'fName' || $index == 'lName' || $index == 'email' || $index == 'contact_message'){
	 					if($value !== ""){
	 						/* Check that all values are alpha numeric */
	 						if($index !== 'email' && $index !== 'contact_message'){
	 							$alphaTest = str_replace(" ","",$value);
	 							if( !ctype_alnum($alphaTest) ){
	 								$response['error']['type'] = 'alph_num';
	 								$response['error']['field'] = $index;break;
	 							}
	 						}
	 					}else{
		 					$response['error']['type'] = 'empyt_field';
		 					$response['error']['field'] = $index;break;
		 				}
	 				}elseif($value == ""){
	 					unset($_POST[$index]);
	 				}


	 			}

	 			if( count($response['error']) > 0){
	 				var_dump($response);exit;
	 			}

				// echo "pre";
				// var_dump($_POST);

	 		/* Call email function */
				$userName = $_POST['fName'] .' ' . $_POST['lName'];
				$userEmail = $_POST['email'];
				$userInitialMess = $_POST['contact_message'];
				if($_POST['iLoginID']){
					$userID = $_POST['iLoginID'];
				}else{
					$userID = $_POST['sUsertype'];	
				}
				
				// call email function 
					$sendContactEmail = sendContactPageEmail($userName, $userID, $userEmail, $userInitialMess, $userMessTimestamp, $adminName, $adminID, $adminReply, $messageID);

				// Get email status
					foreach ($sendContactEmail as $key => $value) {
						$email_response[$key] = $value; 
					}

					if( $email_response['errorcode'] == 0 && $email_response['message'] == 'OK'){
						$response['success'] = true;
					}else{
						$response['success'] = false; 
						$response['errorcode'] = $email_response['errorcode'];
						$response['message'] = $email_response['message'];
						$response['data'] =$sendContactEmail;
					}

	 	}else{
	 		$response['success'] = false;
	 	}

	 	echo json_encode( $response);
?>