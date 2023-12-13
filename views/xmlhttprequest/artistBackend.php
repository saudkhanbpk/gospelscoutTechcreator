<?php 
	/* Artist signup backend page */

	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Include Composer's Autoloader file to automatically detect which PHP package's library is required */
		/*include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
		\Stripe\Stripe::setApiKey("sk_live_aUotamlUSXwgSP4o75KmRK6E");
		\Stripe\Stripe::setApiVersion("2019-11-05");*/

	

	/* Check for that email is not used */
		if($_GET['loginmaster']['sEmailID'] !== '' && $_GET['loginmaster']['sEmailID'] !== NULL){
			$sEmailID0 = trim( $_GET['loginmaster']['sEmailID'] );
			$cond0="(sEmailID = '".$sEmailID0."' AND sUserType = 'artist') AND isActive = 1";
		    	$loginrow0 = $obj->fetchRow('loginmaster',$cond0);  

		    if( count($loginrow0) > 0 ) {
		    	echo json_encode($sEmailID0.' has already been used');
		    }
		    else{
		    	echo json_encode(true);
		    }
		}
	

	/* Execute code if $_POST &  Var is present Only */
		if(count($_POST) > 0){
		
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
				$bdate = date_create( $_POST['usermaster']['dDOB'] ); 
				$bday = date_format($bdate, 'j');
				$bmonth = date_format($bdate, 'n');
				$byear = date_format($bdate, 'Y');
				$errorCount = 0;


			/* Check if the user's email address already exists in the DB */
				$sEmailID1 = $_POST['loginmaster']['sEmailID'];
				$cond="(sEmailID = '".$sEmailID1."' AND sUserType = 'artist') AND isActive = 1";
			    $loginrow = $obj->fetchRow('loginmaster',$cond);  
						

			/* If user email already exists, create an error flag */  

				if(count($loginrow) > 0){				
					$errorMessage = 'This email address has already been used';
					$errorCount++;
				}	
				else{ 

					/********************** Handle the File upload - Profile Picture **********************/
						
						if($_FILES){
							/* Ensure the file type is an image */
								$checkType = strpos($_FILES['sProfileName']['type'], 'image/');

							if($_FILES['sProfileName']['error'] == 4){
								$errorMessage = 'No File Was Uploaded';
								$errorCount++;
							}
							elseif($checkType === false){
								$errorMessage = 'Please Upload Image Files Only';
								$errorCount++;
							}
						}
						else{
							$errorCount++;
							echo 'Please upload a profile img';
						}
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
						
						/* Create Stripe accnt vars */
							/*$str_rout_num = $_POST['stripe']['rout_num']; 
							$str_acct_num = $_POST['stripe']['acct_num']; */
							$skipStripeSetup = $_POST['skipStripeSetup'];

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
							$to = date_create();
							$diff = date_diff($from, $to);

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
								else{ // $apiState
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

			}

/*var_dump($_POST);
var_dump($skipStripeSetup);
		exit;*/
			if($errorCount > 0 ){  
				$responseObj = array(
					"errorCount" => $errorCount,
					"errorMessage" => $errorMessage
				);

				echo json_encode($responseObj);
				exit;
			}
			else{ // Execute Code to insert new user data into tables & create Stripe Objects 
			
				/* Define vars */
					$userType = $_POST['loginmaster']['sUserType'];
					$fileType = 'profileImg';
					$insertErr = array(); 
				
				/********************* Insert login info into the loginmaster table **********************/
					$joinDate = date_format($to, 'Y-m-d H:i:s');
					$field = array("sEmailID","sPassword","sUserType","lastlogin","joinDate", "isActive");
					$value = array($sEmailID1,md5($_POST['loginmaster']['sPassword']), $userType, $joinDate, $joinDate, 1);		
					$iLoginID = $obj->insert($field,$value,"loginmaster");
				/************** END - Insert login info into the loginmaster table ***********************/

				if($iLoginID > 0 ){ // loginmaster conditonal 

					/************************* Insert usermaster info into the usermaster table *************************/
						$_POST['usermaster']['sProfileName'] = handlefileUpload($userType, $fileType, $iLoginID);
						$_POST['usermaster']['iLoginID'] = $iLoginID;
						unset($_POST['usermaster']['apiStateName']);
						foreach($_POST['usermaster'] as $umIndex => $umValue){
							$field1[] = $umIndex;
							$value1[] = $umValue; 
						}
						
						$iUserID = $obj->insert($field1,$value1,'usermaster');
					/********************** END - Insert usermaster info into the usermaster table **********************/

					if($iUserID > 0){ // usermaster conditional

						/************************* Insert talentmaster info into the talentmaster table *************************/
							if($userType == 'artist'){
								$cond = 'isActive = 1';
								$talents = $obj->fetchRowAll('giftmaster',$cond);

								foreach($talents as $talent){
									if($talent['iGiftID'] == $_POST['talentmaster']['TalentID']){
										$_POST['talentmaster']['talent'] = $talent['sGiftName'];
										break;
									}
								}

								$_POST['talentmaster']['iLoginID'] = $iLoginID;

								foreach($_POST['talentmaster'] as $tmIndex => $tmValue){
									$field2[] = $tmIndex;
									$value2[] = $tmValue; 
								}
								$talID = $obj->insert($field2,$value2,'talentmaster');
							}
						/********************** END - Insert talentmaster info into the talentmaster table **********************/

						if($talID > 0){ // talentmaster conditional
							/************************* Insert pwordrecoverymaster info into the pwordrecoverymaster table *************************/
								/*if($userType == 'artist'){
									$_POST['pwordrecoverymaster'][1]['loginID'] = $iLoginID;
									$_POST['pwordrecoverymaster'][1]['questionID'] = $_POST['pwordrecoverymaster']['Q1'];
									$_POST['pwordrecoverymaster'][1]['answer'] = $_POST['pwordrecoverymaster']['A1'];
									$_POST['pwordrecoverymaster'][2]['loginID'] = $iLoginID;
									$_POST['pwordrecoverymaster'][2]['questionID'] = $_POST['pwordrecoverymaster']['Q2'];
									$_POST['pwordrecoverymaster'][2]['answer'] = $_POST['pwordrecoverymaster']['A2'];
									unset($_POST['pwordrecoverymaster']['Q1']);
									unset($_POST['pwordrecoverymaster']['Q2']);
									unset($_POST['pwordrecoverymaster']['A1']);
									unset($_POST['pwordrecoverymaster']['A2']);


									$updRecMasterQuery = 'INSERT INTO pwordrecoverymaster (loginID, questionID, answer) VALUE (?,?,?)';
									try{
										foreach($_POST['pwordrecoverymaster'] as $eachEntry){
											$updRecMaster = $db->prepare($updRecMasterQuery);
											$updRecMaster->bindParam(1,$eachEntry['loginID']);
											$updRecMaster->bindParam(2,$eachEntry['questionID']);
											$updRecMaster->bindParam(3,$eachEntry['answer']);
											$updRecMaster->execute();
										}
									}
									catch(Exception $e){
										echo 'Trouble inserting: ' . $e; 
									}
								}*/
							/********************** END - Insert pwordrecoverymaster info into the pwordrecoverymaster table **********************/

							/******************** Insert into Subscribe tables *********************/
								$field_subscriber = array("iRollID"); 
								$value_subscriber = array($iLoginID); 
								$subSett1 = $obj->insert($field_subscriber,$value_subscriber,"subscribeesetting");

								$field_subscribee = array("iLoginID"); 
								$value_subscribee = array($iLoginID); 
								$subSett2 = $obj->insert($field_subscribee,$value_subscribee,"subscribersetting");
							/***************** END - Code to create Subscribe table entries for new users ******************/


							if($subSett1 > 0 && $subSett2 > 0){ // subscribee & subscriber table conditional
								
								/*********************** Create a Stripe Customer & Connect Account object for the new user ***********************/
									
									$cond10 = strval($iLoginID);
									$newUser = $obj->fetchRow('usermaster', 'iLoginID = ' . $cond10);
									//  $userStateCode - this var holds the new user's statecode - e.g. CA

									if(count($newUser) > 0){

										/*** create a stripe customer & connect account ***/
											try{
												// var_dump($_POST);
												// exit;

												/* 1. We Create connect account first */
													// Get user Ip
														if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
														    $ip = $_SERVER['HTTP_CLIENT_IP'];
														} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
														    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
														} else {
														    $ip = $_SERVER['REMOTE_ADDR'];
														}
													/************************ Create CUSTOM CONNECT ACCTS ************************/
														// Define new user array to create connect acct 
															// $currentDateTime = date_create();
															// $currentDateTime = date_format($currentDateTime, 'U');
															// $user = array(
															// 	"dDOB" => $newUser['dDOB'],
															// 	"sEmailID" => $newUser['sContactEmailID'],
															// 	"sFirstName" => $newUser['sFirstName'],
															// 	"sLastName" => $newUser['sLastName'],
															// 	"phone" => $newUser['sContactNumber'],
															// 	"iLoginID" => $newUser['iLoginID'],
															// 	"acct_holder_name" =>$newUser['sFirstName'] . ' ' . $newUser['sLastName'],
															// 	"acct_routing_number" => $str_rout_num,
															// 	"acct_number" => $str_acct_num,
															// 	"today_UnixTimestamp" => $currentDateTime,
															// 	"city" => $newUser['sCityName'],
															// 	"state" => $userStateCode,
															// 	// "address" => '184 w Mission Avenue',
															// 	"postal_code" => $newUser['iZipcode'],
															// 	"user_ip" => $ip
															// );

														// Create Connect Acct
															// $createAccount = CreateConnectAccount($user);
															// var_dump($createAccount);
													/************************ END - Create CUSTOM CONNECT ACCTS ************************/

													/*************************** Create EXPRESS CONNECT ACCTS ***************************/
														/* Link for express account onboarding */
															$bdate = date_create( $newUser['dDOB'] ); 
															$bday = date_format($bdate, 'j');
															$bmonth = date_format($bdate, 'n');
															$byear = date_format($bdate, 'Y');
															$url = 'https://www.stage.gospelscout.com/views/artistprofile.php?artist=' . $newUser['iLoginID']; 
															//$client_id = 'ca_Ak0oSidrVUIsoOBLwIWUUqxRM8aLJgqN';

															$additional_parameters = array(
																	"redirect_uri" => 'https://www.stage.gospelscout.com/views/artistprofile.php',
																	"client_id" => $str_client_id,
																	"state" => $apiState,
																	// "suggested_capabilities" => ['card_payments', 'transfers'],
																	"stripe_user[email]" => $newUser['sContactEmailID'],
																	"stripe_user[url]" => $url,
																	"stripe_user[country]" => 'US',
																	"stripe_user[phone_number]" => $newUser['sContactNumber'],
																	"stripe_user[business_type]" => 'individual',
																	"stripe_user[first_name]" => $newUser['sFirstName'],
																	"stripe_user[last_name]" => $newUser['sLastName'],
																	"stripe_user[dob_day]" => $bday,
																	"stripe_user[dob_month]" => $bmonth,
																	"stripe_user[dob_year]" => $byear
																);

															$express_acct_onboard_link = 'https://connect.stripe.com/express/oauth/authorize?';

															$counter = count($additional_parameters);
															$i = 0; 
															foreach($additional_parameters as $param_index => $param_value){
																
																if( $i == 0 ){
																	$express_acct_onboard_link .= $param_index . '=' . $param_value;
																}
																else{
																	$express_acct_onboard_link .= '&' . $param_index . '=' . $param_value;
																}

																$i++; 
															}

															// echo '<br><a target="_blank" href="' . $express_acct_onboard_link . '">Onboarding Link</a><br>';


													/************************ END - Create EXPRESS CONNECT ACCTS ************************/
												/* 2. Then create customer obj using connected account ID */ 
													// if($createAccount['id']){
													// 	$customerObj = \Stripe\Customer::create(
													// 	  ["email" => $newUser['sContactEmailID'] ],
													// 	  [ "stripe_account" => $createAccount['id'] ] 
													// 	);

													// 	/* Update the usermaster table with the customer & connect account id */
													// 		if($customerObj['id']){
													// 			$table100 = 'usermaster';
													// 			$field100 = array('str_customerID', 'str_connectActID');
													// 			$value100 = array( $customerObj['id'], $createAccount['id'] );
													// 			$cond100 = 'iLoginID = ' . $newUser['iLoginID'];
													// 			$upD_cust = $obj->update($field100,$value100,$cond100,$table100);
													// 		}
													// 		else{
													// 			$errorMessage = 'Trouble Creating Str_Customer';
													// 		}
													// }
													// else{
													// 	$errorMessage = 'Trouble Creating Str_connect_acct';
													// }

												/* 3. If user does not elect to skip the stripe setup - create account_link obj and redirect user to onboarding page */
													// if($upD_cust){

														// if($customerObj['id']){
														// 	/* Create Subscription and insert into subscriptionmaster table */
														// 		$createSubscription = CreateSubscription($customerObj);

														// 	/* Get and store the subscription_item IDs */
														// 		if($createSubscription['items']['data'][0]['id']){
														// 			// $today = date_create();
														// 			$today = date_format($to,'Y-m-d H:i:s');
														// 			$subscriptionID = $createSubscription['id'];
														// 			$trial_end = $createSubscription['trial_end'];
														// 			$postGig_itemID = $createSubscription['items']['data'][0]['id'];
														// 			$bidGig_itemID = $createSubscription['items']['data'][1]['id'];
														// 			$field1 = array('iLoginID','email','subscripID','postGig_itemID','bidGig_itemID', 'trialEnd','dateTime');
														// 			$value1 = array($newUser['iLoginID'],$newUser['sContactEmailID'],$subscriptionID,$postGig_itemID,$bidGig_itemID,$trial_end,$today);
														// 			$table1 = 'str_subscriptionmaster';
														// 			$insertSub = $obj->insert($field1,$value1,$table1);
														// 		}
														// 		else{
														// 			$errorMessage = 'Trouble Creating Str_Customer Subscription';
														// 		}
														// }
														// else{
														// 	$errorMessage = 'Trouble Creating Str_Customer';
														// }


														/******************* Setting Session Variables ********************/
															$objsession->set('gs_login_id',$iLoginID);	
															$objsession->set('gs_login_email',$sEmailID1);	
															$objsession->set('gs_login_type',$userType); //"artist"
															$objsession->set('gs_user_name',$sFirstName);
															$objsession->set('gs_msg','<p>Welcome To GospelScout!!!</p>');
														/******************* END - Setting Session Variables ********************/


														if($skipStripeSetup){
															/*********** Upon successful profile submission, relocate user to their profile page ************/
															       	//echo "<script> window.location= </script>"; 

															    $responseObj['target_url'] = 'https://www.stage.gospelscout.com/views/artistprofile.php';

															/********* END - Upon successful profile submission, relocate user to their profile page **********/
														}		
														else{
															
															/* Create account link */
																// $acct_link = createOnboardingLink($createAccount); 
																// $acct_link->url

																$acct_link = $express_acct_onboard_link; 
																if($acct_link){
																	/* Redirect user to the onboarding URL */
																		//echo '<script>window.location = "'. $acct_link->url .'";</script>';

																	$responseObj['target_url'] = $acct_link;
																}
																else{
																	$errorMessage = 'Trouble Creating str_onbaording link';
																}
														}
													// }
													// else{

													// 	$errorMessage = 'Trouble Creating updating user table with str_info';
													// }
											}
											catch(Exception $e){
												echo 'Connect Account Obj Error - '. $e; 
											}
										/*** END - create a stripe customer & connect account ***/
									}
									else{
										$errorMessage = 'Trouble Retrieving New User';
									}

								/******************** END - Create a Stripe Customer object for the new user ********************/  


							} // END - subscribee & subscriber table conditional
							else{
								$errorMessage = 'Trouble Inserting Into Subscription Tables';
							}

						} // END - talentmaster conditional
						else{
							$errorMessage = 'Trouble Inserting Into Talent Table';
						}

					} // END - usermaster conditional
					else{
						$errorMessage = 'Trouble Inserting Into User Table';
					}

				} // END - loginmaster conditional
				else{
					$errorMessage = 'Trouble Inserting Into Login Table';
				}

				/* Return Response Object to artist.php */
					if($errorMessage !== ''){
						$responseObj['errorMessage'] = $errorMessage;
					}
					else{
						$responseObj['errorCount'] = 0;
						$responseObj['errorMessage'] = 0;
					}


				/* Send json_encoded responseObj back to artist.php page */
					echo json_encode($responseObj);
			} // END - Execute Code to insert new user data into tables & create Stripe Objects 
			
		}
?>