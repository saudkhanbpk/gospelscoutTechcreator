<?php 
	/* Artist signup backend page */

	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Include Composer's Autoloader file to automatically detect which PHP package's library is required */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
		\Stripe\Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");
		\Stripe\Stripe::setApiVersion("2019-11-05");


	/* Check that the email is not used - FOR FRONT JQUERY VALIDATOR FORM */
		if($_GET['loginmaster']['sEmailID'] !== '' && $_GET['loginmaster']['sEmailID'] !== NULL){
			$sEmailID0 = trim( $_GET['loginmaster']['sEmailID'] );
			$cond0="(sEmailID = '".$sEmailID0."' AND sUserType = 'artist') AND isActive = 1";
		    $loginrow0 = $obj->fetchRow('loginmaster',$cond0);  

		    if( count($loginrow0) > 0 ) {
		    	echo json_encode($sEmailID0.' has already been used');
		    }
		    elseif(count($loginrow0) == 0){
		    	echo json_encode(true);
		    }
		}
	

	/* Execute code if $_POST &  Var is present Only */
		if(count($_POST) > 0){
			// var_dump($_POST);

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
				$userType = $_POST['loginmaster']['sUserType'];
				$errorCount = 0;

			/* Check if the user's email address already exists in the DB */
				$sEmailID1 = $_POST['loginmaster']['sEmailID'];
				$cond="(sEmailID = '".$sEmailID1."' AND sUserType = 'artist') AND isActive = 1";
			    $loginrow = $obj->fetchRow('loginmaster',$cond);  
						

			/* If user email already exists, create an error flag */  
				if(count($loginrow) < 0){				
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
						
						/* Insert elements into post array */
							$_POST['usermaster']['sUserType'] = $_POST['loginmaster']['sUserType'];
							$_POST['usermaster']['sContactEmailID'] = $_POST['loginmaster']['sEmailID'];
							$_POST['usermaster']['dCreatedDate'] = $today;
						/* END - Insert elements into post array */

						/* Create Stripe accnt vars */
							// $str_rout_num = $_POST['stripe']['rout_num']; 
							// $str_acct_num = $_POST['stripe']['acct_num']; 

						/* Remove Unnecessary post array elements - trim array element values */
							foreach($_POST as $index0 => $unwantedElements){
								if($index0 != 'usermaster' && $index0 != 'loginmaster' && $index0 != 'pwordrecoverymaster'){
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
										// $StateIdFetch = $db->prepare('SELECT states.id, states.statecode FROM states WHERE states.name = ?');
										// $StateIdFetch->bindParam(1, $state); 
										// $StateIdFetch->execute(); 
										
										// $StateId = $StateIdFetch->fetch(PDO::FETCH_ASSOC); 

										$table = 'states';
										$columnsArray = array('states.id', 'states.statecode');
										$paramArray['name']['='] = $state; 
										$StateId = pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
										$StateId = $StateId[0];
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
			
			//var_dump($_POST);
			//var_dump($_GET);
			// exit;

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
						
						/*************** UPLOAD FILES AND STORE PATH IN USERMASTER TABLE ***************/
							$_POST['usermaster']['sProfileName'] = handlefileUpload($userType, $fileType, $iLoginID);
						/************ END - UPLOAD FILES AND STORE PATH IN USERMASTER TABLE ************/

						$_POST['usermaster']['iLoginID'] = $iLoginID;
						unset($_POST['usermaster']['apiStateName']);
						foreach($_POST['usermaster'] as $umIndex => $umValue){
							$field1[] = $umIndex;
							$value1[] = $umValue; 
						}
						
						$iUserID = $obj->insert($field1,$value1,'usermaster');
					/********************** END - Insert usermaster info into the usermaster table **********************/

					if($iUserID > 0){ // usermaster conditional

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
							} */
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
												/******************* Setting Session Variables ********************/
													$objsession->set('gs_login_id',$iLoginID);	
													$objsession->set('gs_login_email',$sEmailID1);	
													$objsession->set('gs_login_type',$userType); //"artist"
													$objsession->set('gs_user_name',$sFirstName);
													$objsession->set('gs_msg','<p>Welcome To GospelScout!!!</p>');
													$responseObj['target_url'] = 'https://www.stage.gospelscout.com/index.php';
												/******************* END - Setting Session Variables ********************/
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
			
			// var_dump($responseObj);
			// var_dump($_POST);

		}
?>