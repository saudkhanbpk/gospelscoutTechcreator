<?php 
	/* Artist signup backend page */

	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Include Composer's Autoloader file to automatically detect which PHP package's library is required */
		// include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
		// \Stripe\Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");
		// \Stripe\Stripe::setApiVersion("2019-11-05");


	/* Check that email is not used */
		if($_GET['loginmaster']['sEmailID'] !== '' && $_GET['loginmaster']['sEmailID'] !== NULL){
			$sEmailID0 = trim( $_GET['loginmaster']['sEmailID'] );
			$cond0="(sEmailID = '".$sEmailID0."') AND isActive = 1";//AND sUserType = 'artist' OR sUserType =
		    $loginrow0 = $obj->fetchRow('loginmaster',$cond0,$db);
		    if( count($loginrow0) < 0 ) {echo json_encode($sEmailID0.' has already been used');}
		    else{echo json_encode(true);}
		}
	
	/* Execute code if $_POST &  Var is present Only */
		if(count($_POST) > 0){
			// var_dump($_POST);exit;

			/* Define global session vars */
				$currentUserID = $objsession->get('gs_login_id');
			    $currentUserType = $objsession->get('gs_login_type');
			    $currentUserEmail = $objsession->get('gs_login_email');

			/* Create date and time for form submission */
				$today0 = date_create();
				$today = date_format($today0, 'Y-m-d H:i:s');
				$today_UnixTimestamp = date_format($today0, 'U');
			/* END - Create date and time for form submission */

			/* Define needed vars */
				$bday = intval(trim($_POST['usermaster']['dDOB']['day']));
				$bmonth = intval(trim($_POST['usermaster']['dDOB']['month']));
				$byear = intval(trim($_POST['usermaster']['dDOB']['year']));
				$_POST['usermaster']['dDOB'] = $byear.'-'.$bmonth.'-'.$bday;
				$errorCount = 0;
				$verCode = $objsession->get('verification_code');


			/* Check if the user's email address already exists in the DB */
				$sEmailID1 = $_POST['loginmaster']['sEmailID'];
				$cond="(sEmailID = '".$sEmailID1."' AND sUserType = 'artist') AND isActive = 1";
			    $loginrow = $obj->fetchRow('loginmaster',$cond,$db);  
						

			/* If user email already exists, create an error flag */  
				if(count($loginrow) < 0){				
					$errorMessage = 'This email address has already been used';
					$errorCount++;
				}elseif( $_POST['verificationCode'] == $verCode ){

					/********************** Handle the File upload - Profile Picture **********************/
						
						// if($_FILES){
						// 	/* Ensure the file type is an image */
						// 		$checkType = strpos($_FILES['sProfileName']['type'], 'image/');

						// 	if($_FILES['sProfileName']['error'] == 4){
						// 		$errorMessage = 'No File Was Uploaded';
						// 		$errorCount++;
						// 	}
						// 	elseif($checkType === false){
						// 		$errorMessage = 'Please Upload Image Files Only';
						// 		$errorCount++;
						// 	}
						// }
						// else{
						// 	$errorCount++;
						// 	$errorMessage = 'Please upload a profile img';
						// }
					/********************** END - Handle the File upload - Profile Picture **********************/

					/****************************** Handle $_POST Array Validation ***********************************************/
						/* Make sure group name and talentmaster['talentid'] have the right values depending on the loginmaster['sUserType']*/
							if($_POST['loginmaster']['sUserType'] == 'artist'){
								unset($_POST['usermaster']['sGroupName']);

								if($_POST['talentmaster']['TalentID'] == ''){
									$errorMessage = 'Please Select A Talent';
									$errorCount++; 
								}
							}
							elseif($_POST['loginmaster']['sUserType'] == 'group'){
								unset($_POST['talentmaster']);

								if($_POST['usermaster']['sGroupName'] == ''){
									$errorMessage = 'Please Enter a Group Name';
									$errorCount++; 
								}
							}
							$userType = $_POST['loginmaster']['sUserType'];
						/* END - Make sure group name and talentmaster['talentid'] have the right values depending on the loginmaster['sUserType']*/

						/* Insert elements into post array */
							$_POST['usermaster']['sUserType'] = $_POST['loginmaster']['sUserType'];
							$_POST['usermaster']['sContactEmailID'] = $_POST['loginmaster']['sEmailID'];
							$_POST['usermaster']['dCreatedDate'] = $today;
						/* END - Insert elements into post array */

						/* Remove Unnecessary post array elements - trim array element values */
							foreach($_POST as $index0 => $unwantedElements){
								if($index0 != 'usermaster' && $index0 != 'loginmaster' && $index0 != 'talentmaster' && $index0 != 'pwordrecoverymaster'){
									unset($_POST[$index0]);
								}
							}

							foreach($_POST as $index => $value){
								foreach ($value as $key => $tableData) {
									$_POST[$index][$key] = trim($tableData);
								}
							}
							
						/* END - Remove Unnecessary post array elements */

						/* Birth Date Validation */
							$birthDate = $_POST['usermaster']['dDOB'];
							$from = date_create($birthDate);
							$diff = date_diff($from, $today0);
							if($diff->y < 5){
								$errorMessage = 'Must be at least 5yrs. of age to create a profile';
								$errorCount++;
							}
						/* END - Birth Date Validation */

						/* Implement zipcode api to return city based on zip code */
							$state = $_POST['usermaster']['sStateName'];
							$apiState = $_POST['usermaster']['apiStateName'];

							if($errorCount == 0){
								if($state !== $apiState){
									$errorMessage = 'State/Zip code Mismatch';
									$errorCount++;
								}
								else{ 
									$cond = 'name = ' . $state;
									try{
										$StateIdFetch = $db->prepare('SELECT states.id, states.statecode FROM states WHERE states.name = ?');
										$StateIdFetch->bindParam(1, $state); 
										$StateIdFetch->execute(); 
										
										$StateId = $StateIdFetch->fetch(PDO::FETCH_ASSOC); 
										
									}
									catch(Exception $e){
										echo $e; 
									}
									
									$_POST['usermaster']['sStateName'] = $StateId['id'];
									$userStateCode = $StateId['statecode'];
								}
							}
							
						/* END - Implement zipcode api to return city based on zip code */
					/****************************** END - Handle $_POST Array ***********************************************/

				}else{ 
					$errorMessage = 'conf_code_invalid';
					$errorCount++;
				}

			if($errorCount > 0 ){  
				$responseObj = array(
					"errorCount" => $errorCount,
					"errorMessage" => $errorMessage
				);

				echo json_encode($responseObj);
				exit;
			}
			else{    // Execute Code to insert new user data into tables & create Stripe Objects 
				// echo json_encode($responseObj);
				// exit;
				/* Define vars */
					$userType = $_POST['loginmaster']['sUserType'];
					$fileType = 'profileImg';
					$insertErr = array(); 
				
				/********************* Insert login info into the loginmaster table **********************/
					$joinDate = date_format($today0, 'Y-m-d H:i:s');
					$field = array("sEmailID","sPassword","sUserType","lastlogin","joinDate", "isActive");
					$value = array($sEmailID1,md5($_POST['loginmaster']['sPassword']), $userType, $joinDate, $joinDate, 1);		
					// $iLoginID = $obj->insert($field,$value,"loginmaster");
					$iLoginID = pdoInsert($db,$field,$value,'loginmaster');
				/************** END - Insert login info into the loginmaster table ***********************/


				if($iLoginID > 1 ){ // loginmaster conditonal 

					/************************* Insert usermaster info into the usermaster table *************************/
						/*************** UPLOAD FILES AND STORE PATH IN USERMASTER TABLE ***************/
							$_POST['usermaster']['sProfileName'] = handlefileUpload($userType, $fileType, $iLoginID);
						/************ END - UPLOAD FILES AND STORE PATH IN USERMASTER TABLE ************/
						
						$_POST['usermaster']['iLoginID'] = $iLoginID;
						unset($_POST['usermaster']['apiStateName']);

						foreach($_POST['usermaster'] as $umIndex => $umValue){
							$field1[] = $umIndex;
							$value1[] = $umValue; 
						}
						
						// $iUserID = $obj->insert($field1,$value1,'usermaster');
						$iUserID = pdoInsert($db,$field1,$value1,'usermaster');
						
					/********************** END - Insert usermaster info into the usermaster table **********************/

					if($iUserID > 1){ // usermaster conditional
						/******************** Insert into Subscribe tables *********************/
							$field_subscriber = array("iRollID"); 
							$value_subscriber = array($iLoginID); 
							// $subSett1 = $obj->insert($field_subscriber,$value_subscriber,"subscribeesetting");
							$subSett1 = pdoInsert($db,$field_subscriber,$value_subscriber,'subscribeesetting');

							$field_subscribee = array("iLoginID"); 
							$value_subscribee = array($iLoginID); 
							// $subSett2 = $obj->insert($field_subscribee,$value_subscribee,"subscribersetting");
							$subSett2 = pdoInsert($db,$field_subscribee,$value_subscribee,'subscribersetting');
						/***************** END - Code to create Subscribe table entries for new users ******************/


							if($subSett1 > 1 && $subSett2 > 1){ // subscribee & subscriber table conditional
								
								/*********************** Create a Stripe Customer & Connect Account object for the new user ***********************/
									
									$cond10 = strval($iLoginID);
									$newUser = $obj->fetchRow('usermaster', 'iLoginID = ' . $cond10,$db);
									//  $userStateCode - this var holds the new user's statecode - e.g. CA

									if(count($newUser) > 1){

										/*** create a stripe customer & connect account ***/
											try{
												/* 1. We Create connect account first */
													// Get user Ip
														// if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
														//     $ip = $_SERVER['HTTP_CLIENT_IP'];
														// } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
														//     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
														// } else {
														//     $ip = $_SERVER['REMOTE_ADDR'];
														// }

													/*************************** Create EXPRESS CONNECT ACCTS ***************************/
														/* Link for express account onboarding */
															// $bdate = date_create( $newUser['dDOB'] ); 
															// $bday = date_format($bdate, 'j');
															// $bmonth = date_format($bdate, 'n');
															// $byear = date_format($bdate, 'Y');
															// $url = 'https://www.gospelscout.com/views/artistprofile.php?artist=' . $newUser['iLoginID']; 
															// $client_id = 'ca_Ak0oINUTgAn12kLMbPdMh2PuNJuXU11L';

															// $additional_parameters = array(
															// 		"redirect_uri" => 'https://www.gospelscout.com/views/artistprofile.php',
															// 		"client_id" => $client_id,
															// 		"state" => $apiState,
															// 		// "suggested_capabilities" => ['card_payments', 'transfers'],
															// 		"stripe_user[email]" => $newUser['sContactEmailID'],
															// 		"stripe_user[url]" => $url,
															// 		"stripe_user[country]" => 'US',
															// 		"stripe_user[phone_number]" => $newUser['sContactNumber'],
															// 		"stripe_user[business_type]" => 'individual',
															// 		"stripe_user[first_name]" => $newUser['sFirstName'],
															// 		"stripe_user[last_name]" => $newUser['sLastName'],
															// 		"stripe_user[dob_day]" => $bday,
															// 		"stripe_user[dob_month]" => $bmonth,
															// 		"stripe_user[dob_year]" => $byear
															// 	);

															// $express_acct_onboard_link = 'https://connect.stripe.com/express/oauth/authorize?';

															// $counter = count($additional_parameters);
															// $i = 0; 
															// foreach($additional_parameters as $param_index => $param_value){
																
															// 	if( $i == 0 ){
															// 		$express_acct_onboard_link .= $param_index . '=' . $param_value;
															// 	}
															// 	else{
															// 		$express_acct_onboard_link .= '&' . $param_index . '=' . $param_value;
															// 	}

															// 	$i++; 
															// }

														/******************* Setting Session Variables ********************/
															$objsession->set('gs_login_id',$iLoginID);	
															$objsession->set('gs_login_email',$sEmailID1);	
															$objsession->set('gs_login_type',$userType); //"artist"
															$objsession->set('gs_user_name',$sFirstName);
															$objsession->set('gs_msg','<p>Welcome To GospelScout!!!</p>');
														/******************* END - Setting Session Variables ********************/


														// if($_POST['skipStripeSetup']){
															/*********** Upon successful profile submission, relocate user to their profile page ************/
															    $responseObj['target_url'] = 'https://www.gospelscout.com/artist/';
															/********* END - Upon successful profile submission, relocate user to their profile page **********/
														// }		
														// else{
														// 	$acct_link = $express_acct_onboard_link; 
														// 	if($acct_link){
														// 		$responseObj['target_url'] = $acct_link;
														// 	}
														// 	else{
														// 		$errorMessage = 'Trouble Creating str_onbaording link';
														// 	}
														// }
													
											}
											catch(Exception $e){
												echo 'Connect Account Obj Error - '. $e; 
											}
										/*** END - create a stripe customer & connect account ***/
									}
									else{
										$errorMessage = 'Trouble Retrieving New User';
										$errorCount++;
									}

								/******************** END - Create a Stripe Customer object for the new user ********************/  


							} // END - subscribee & subscriber table conditional
							else{
								$errorMessage = 'Trouble Inserting Into Subscription Tables';
								$errorCount++;
							}

						// } // END - talentmaster conditional
						// else{
						// 	$errorMessage = 'Trouble Inserting Into Talent Table';
						// 	$errorCount++;
						// }

					} // END - usermaster conditional
					else{
						$errorMessage = 'Trouble Inserting Into User Table';
						$errorCount++;
					}

				} // END - loginmaster conditional
				else{
					$errorMessage = 'Trouble Inserting Into Login Table';
					$errorCount++;
				}

				/* Return Response Object to artist.php */
					if($errorMessage !== ''){
						$responseObj['errorMessage'] = $errorMessage;
						$responseObj['errorCount'] = $errorCount;
					}
					else{
						$responseObj['errorCount'] = 0;
						$responseObj['errorMessage'] = 0;
					}


				/* Send json_encoded responseObj back to artist.php page */
					echo json_encode($responseObj);
			} // END - Execute Code to insert new user data into tables & create Stripe Objects 
			
			// var_dump($responseObj);
			// var_dump($_POST);

		}
?>