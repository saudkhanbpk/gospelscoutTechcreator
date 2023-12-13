<?php 
	/* Sign Up Page - artist */

	/*
		Still to do

		step 1 
			1. Create custom method to invoke at least 1 upper, 1 lower, 1 number, and 1 special character - minimum of 8 characters

		step 2 
			1. position error label better for the DOB input
			
			3. find a zipcode api to retrieve city using zipcode when from is submitted
				a. zipcode check will be validated on backend 

		step 3
			1. create validation for select input 
				a. talent selection
			2. make the radio inputs a requirement 

		step 4 
			
			2. position error label better for the 'send confirmation email' checkbox input
	*/

	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Check if user is signed in - if so, redirect user to their profile page */
		if($currentUserID != ''){
			if($currentUserType == 'artist' || $currentUserType == 'group'){
				echo '<script>window.location = "'. URL .'views/artistprofile.php";</script>';
				exit;
			}
			elseif($currentUserType == 'church'){
				echo '<script>window.location = "'. URL .'views/churchprofile.php";</script>';
				exit;
			}
		}
		else{
			/* Query the DB for the security questions */
				$secQuestionsQuery = 'SELECT * FROM pwordrecoveryquestionsmaster';

				try{
					$secQuestions = $db->query($secQuestionsQuery);
					$secQuestions->execute();
					$secQuestionsResults = $secQuestions->fetchAll(PDO::FETCH_ASSOC);

				}catch(Exception $e){
					echo 'Problem connecting to database: ' . $e; 
				}
				// echo '<pre>';
				// var_dump($secQuestionsResults);
		}

	/* Create date and time for form submission */
		$today = date_create();
		$today = date_format($today, 'Y-m-d H:i:s');
	/* END - Create date and time for form submission */

	if($_POST){
		$errorCount = 0;
		/****************************** Check if the user's email address already exists in the DB *************************/
			$sEmailID1 = $_POST['loginmaster']['sEmailID'];
			$cond="(sEmailID = '".$sEmailID1."' AND sUserType = 'artist') AND isActive = 1";
		    	$loginrow = $obj->fetchRow('loginmaster',$cond);  
				
			if(count($loginrow) > 0){			
				// $objsession->set('gs_error_msg','This email already existing.');	
				$errorMessage = 'This email address has already been used';
				$errorCount++;
				//redirect(URL.'views/artist.php');
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
						elseif($_FILES['sProfileName']['error'] == 0){
							/* Continue Processing File */

							/* Move File from temporary location to permanent directory*/
								function moveFile($FILES, $targetFile) {
									if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
										$uploadStatus = 'File Upload Successful';
									}	
									else {
										$uploadStatus = 'File Upload unSuccessful';
										$errorMessage = $uploadStatus;
										$errorCount++;
									}
								}
							/* END - Move File from temporary location to permanent directory*/

							/* PROCESS UPLOADED MUSIC CONTENT */
								$musicDir = '/upload/artist/'; 
								$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $musicDir;

								$randNumb = rand(1,50000);
								
								$newIndivFile = $_FILES['sProfileName'];
								$target_file = $target_dir . basename($newIndivFile['name']); 
								$musicFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								$musicFileSize = $newIndivFile['size'];

								if(count($newIndivFile) > 0){
									if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
										$errorMessage = 'There was an upload error: ' . $newIndivFile['error'];
										$errorCount++;
									}
									elseif($musicFileSize != '' && $musicFileSize > 5000000) {
										$errorMessage = 'Your File Size Must Be Less Than 5MB';
										$errorCount++;
									}
									else {
										$target_file_mus = $target_dir . $randNumb . str_replace(' ', '', $newIndivFile['name']); 
										$newIndivFileMus = $newIndivFile; 
										$uploadMusStatus = 'upload';

										/* Add profile img File Path to the post array */
											$_POST['usermaster']['sProfileName'] = basename($target_file_mus);
									}
								} 
							/* END - PROCESS UPLOADED VIDEO CONTENT */	
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

						if($state != $apiState){
							$errorMessage = 'State/Zip code Mismatch';
							$errorCount++;
						}
						elseif($state == $apiState){
							$cond = 'name = ' . $state;
							//$StateId = $obj->fetchRow('states',$cond);
							//var_dump($db);
							try{
								$StateIdFetch = $db->prepare('SELECT states.id FROM states WHERE states.name = ?');
								$StateIdFetch->bindParam(1, $state); 
								$StateIdFetch->execute(); 
								
								$StateId = $StateIdFetch->fetch(PDO::FETCH_ASSOC); 
								
							}
							catch(Exception $e){
								echo $e; 
							}
							
							$_POST['usermaster']['sStateName'] = $StateId['id'];
						}
						
					/* END - Implement zipcode api to return city based on zip code */
			/****************************** END - Handle $_POST Array ***********************************************/
		}
					
		/***************************** Handle $_POST array after validation **********************************/
			if($errorCount == 0){
				/********************* Insert login info into the loginmaster table **********************/	
					$joinDate = date_format($to, 'Y-m-d H:i:s');
					$field = array("sEmailID","sPassword","sUserType","lastlogin","joinDate", "isActive");
					$value = array($sEmailID1,md5($_POST['loginmaster']['sPassword']),$_POST['loginmaster']['sUserType'], $joinDate, $joinDate, 1);
					$iLoginID = $obj->insert($field,$value,"loginmaster");
				/************** END - Insert login info into the loginmaster table ***********************/

				/************************* Insert usermaster info into the usermaster table *************************/
					$_POST['usermaster']['iLoginID'] = $iLoginID;
					unset($_POST['usermaster']['apiStateName']);
					foreach($_POST['usermaster'] as $umIndex => $umValue){
						$field1[] = $umIndex;
						$value1[] = $umValue; 
					}
					
					$iUserID = $obj->insert($field1,$value1,'usermaster');
					
				/********************** END - Insert usermaster info into the usermaster table **********************/

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
						$id = $obj->insert($field2,$value2,'talentmaster');
						echo $id;
					}
				/********************** END - Insert talentmaster info into the talentmaster table **********************/
				
				/************************* Insert pwordrecoverymaster info into the pwordrecoverymaster table *************************/
					if($userType == 'artist'){
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
								
								var_dump($eachEntry);
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
					}
				/********************** END - Insert pwordrecoverymaster info into the pwordrecoverymaster table **********************/

				/******************** Code to create Subscribe table entries for new users *********************/
					$field = array("iRollID"); 
					$value = array($iLoginID); 
					$obj->insert($field,$value,"subscribeesetting");

					$field = array("iLoginID"); 
					$value = array($iLoginID); 
					$obj->insert($field,$value,"subscribersetting");
				/***************** END - Code to create Subscribe table entries for new users ******************/

				/******************** Move Profile img to permanent location on the server *********************/
					if($uploadMusStatus = 'upload'){
						if(file_exists($target_dir)) {
							moveFile($newIndivFileMus, $target_file_mus);
						}
						else {
							mkdir($target_dir,0777,true);	
							$uploadStatusMus = moveFile($newIndivFileMus, $target_file_mus);			
						}
					}
				/**************** END - Move Profile img to permanent location on the server ********************/

				/******************* Setting Session Variables ********************/
					$objsession->set('gs_login_id',$iLoginID);	
					$objsession->set('gs_login_email',$sEmailID1);	
					$objsession->set('gs_login_type',$userType); //"artist"
					$objsession->set('gs_user_name',$sFirstName);
					$objsession->set('gs_msg','<p>Welcome To GospelScout!!!</p>');
				/******************* END - Setting Session Variables ********************/

				/*********** Upon successful profile submission, relocate user to their profile page ************/
					$cond10 = strval($iLoginID);
					$userExist = $obj->fetchRow('loginmaster', 'iLoginID = ' . $cond10);
					
					if($userExist['sEmailID'] == $sEmailID1){ ?>
				       	<script>
				       		window.location='<?php echo URL; ?>views/artistprofile.php';
				        </script>
				   	<?php } 
				   		else{ ?>
				            <script>
				           		alert("OOPS!!! Looks like there was an error creating your profile!!!");
				            </script>
				   	 <?php } 
				/********* END - Upon successful profile submission, relocate user to their profile page **********/  
			}
		/************************************ END - Handle $_POST array after validation **************************/
	}

	/* Create a randomly generated confirmation # and email the new user prompting them to enter the confirmation on this page to finish creating their profile */
		echo '<input type="hidden" name="confirmationCode" value="">';
	/* END - Create a randomly generated confirmation # and email the new user prompting them to enter the confirmation on this page to finish creating their profile */
	
?>

<div id="carouselExampleIndicators" class="carousel mb-2 pt-0 pb-0 mt-5 text-center valid-form-check bg-bg2" style="background-image: url(../img/BusinessCardCollage2.png);" data-wrap="false" data-interval="false" data-ride="false"> <!-- carousel-->
	 <div  class="pt-5" style="width:100%; height:100%;background-color: rgba(149,73,173,.3);">
	 	<div class="error p-3 text-danger" style="font-weight: bold"><?php if($_POST && $errorMessage != ''){echo $errorMessage;}?></div>
		<h4 class="mt-4 text-white">Artist Sign Up</h4>
					
		<div class="carousel-inner ">
			<div class="container px-md-5" >
				<form action="artist" method="post" name="artist-signup" id="artist-signup" enctype="multipart/form-data" autocomplete="off">
					<!-- Slide 1 -->
					    <div class="carousel-item active bg-transparent" id="step1" style="min-height:400px">
					    	<div class="container pt-2" >
					    		<div class="row pt-3 justify-content-center">
					    			<div class="col col-md-5 pt-3 pb-5 bg-white signup-steps" style="">
					    				<h5 class="mb-4 text-gs">Step 1</h5>
								      	<input type="text" class="form-control form-control-sm mt-4 rule1" data-msg-required="Please enter a valid name" data-msg-minlength="Name must be at least 2 characters"  name="usermaster[sFirstName]" id="sFirstName" placeholder="First Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sFirstName'];} ?>">

								      	<input type="text" class="form-control form-control-sm mt-4 rule1" data-msg-required="Please enter a valid name" data-msg-minlength="Name must be at least 2 characters" name="usermaster[sLastName]" id="sLastName" placeholder="Last Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sLastName'];} ?>">
								      
								      	<input type="email" class="form-control form-control-sm mt-4" data-msg-required="Please enter a valid email address" data-msg-email="Email is not valid" name="loginmaster[sEmailID]" id="sEmailID2" placeholder="Email Address" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['loginmaster']['sEmailID'];} ?>">
								      	
								      	<!-- may have to add an email element in the FormData object for email to the usermaster table -->
								      	<input type="password" class="form-control form-control-sm mt-4" data-msg-required="Please enter a valid password" data-msg-minlength="Password must be at least 8 characters" name="loginmaster[sPassword]" id="loginmaster-sPassword" placeholder="Enter Password" value="">
								      	
								      	<input type="password" class="form-control form-control-sm mt-4"data-msg-required="Please confirm password" data-msg-equalTo="Password does not match" name="loginmaster[ConfsPassword]" placeholder="Confirm Password" value="">
								      	
								      	<!-- <input type="hidden" name="loginmaster[sUserType]" value=""> -->
								      	<!-- <input type="hidden" name="usermaster[sUserType]" value=""> -->
								     </div>
						      	</div>
						    </div>
					    </div>
					<!-- /Slide 1 -->

					<!-- Slide 2 -->
					    <div class="carousel-item bg-transparent" id="step2" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 text-center bg-white pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 2</h5>
					    				
					    				<!-- Security Questions -->
					    					<div class="mb-0 text-left text-gs" style="font-size:12px;font-weight:bold;"><label>Security Question 1</label></div>
					    					<select class="custom-select dropdown py-0 mt-0"  name="pwordrecoverymaster[Q1]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
					    						<?php 
					    							foreach($secQuestionsResults as $eachQuest){
					    								if($_POST && $errorCount > 0 ){
					    									if($eachQuest['question'] == $_POST["pwordrecoverymaster"]["Q1"]){
					    										$selected = 'selected';
										       					echo '<option' . $selected . ' value="' . $eachQuest['id'] . '">' . $eachQuest['question'] . '</option>';
										       				}
										       				else{
										       					echo '<option value="' . $eachQuest['id'] . '">' . $eachQuest['question'] . '</option>';
										       				}
										       			}
										       			else{
										       				echo '<option value="' . $eachQuest['id'] . '">' . $eachQuest['question'] . '</option>';
										       			}
										       		}
										       	?>
										    </select>
										    <div class="container m-0 mb-2 pl-2">
											    <input type="text" style="font-size:12px; height: 20px;" autocomplete="off" class="mt-1 form-control form-control-sm clearDefault mt-0" name="pwordrecoverymaster[A1]" placeholder="Answer 1" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['pwordrecoverymaster']['A1'];} ?>"/> 
											</div>
										    <div class="mb-0 text-left text-gs" style="font-size:12px;font-weight:bold;"><label>Security Question 2</label></div>
					    					<select class="custom-select dropdown py-0 mt-0"  name="pwordrecoverymaster[Q2]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
					    						<?php 
					    							foreach($secQuestionsResults as $eachQuest){
										       			if($_POST && $errorCount > 0 ){
					    									if($eachQuest['question'] == $_POST["pwordrecoverymaster"]["Q2"]){
					    										$selected = 'selected';
										       					echo '<option' . $selected . ' value="' . $eachQuest['id'] . '">' . $eachQuest['question'] . '</option>';
										       				}
										       				else{
										       					echo '<option value="' . $eachQuest['id'] . '">' . $eachQuest['question'] . '</option>';
										       				}
										       			}
										       			else{
										       				echo '<option value="' . $eachQuest['id'] . '">' . $eachQuest['question'] . '</option>';
										       			}
										       		}
										       	?>
										    </select>
										    <div class="container m-0 pl-2">
											    <input type="text" style="font-size:12px; height: 20px;" autocomplete="off" class="mt-1 form-control form-control-sm clearDefault mt-0" name="pwordrecoverymaster[A2]" placeholder="Answer 2" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['pwordrecoverymaster']['A2'];} ?>"/> 
											</div>
					    				<!-- /Security Questions -->

					    				<!-- Birth Date -->
										<div class="input-group date dateTime-input mt-4 mt-0" id="datetimepicker1">
								               		<input type="text" autocomplete="off" class="form-control form-control-sm clearDefault mt-0" name="usermaster[dDOB]" placeholder="Brith Date" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['dDOB'];} ?>"/> 
									                <input type="hidden" name="todaysDate" value="<?php echo $today; ?>">
									                <span class="input-group-addon">
									                    <span class="glyphicon glyphicon-calendar"></span>
									                </span>
									        </div>

							            <!-- Country -->
							            <select class="custom-select dropdown py-0 mt-4"  name="usermaster[sCountryName]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
									       	<option value="231">United States</option>
									    </select>

									    <!-- State -->
									     <?php 
									    	$cond = 'country_id = 231'; 
									       	$stateArray = $obj->fetchRowAll('states', $cond);
									    ?>
							            <select class="custom-select dropdown py-0 mt-4"  name="usermaster[sStateName]" id="sStateName" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
									       	<option value="">State</option>
									       	<?php 
									       		// $state['id']
										    	foreach($stateArray as $evID => $state) {
										    		if($_POST && $errorCount > 0 ){
										    			if($state['name'] == $_POST["usermaster"]["sStateName"]){
										    				$selected = 'selected';
										    				echo '<option ' . $selected . ' value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
										    			}
										    			else{
											    			echo '<option value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
											    		}
										    		} 
										    		else{
										    			echo '<option value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
										    		}
										    	}
										    ?>
									    </select>
									    <!-- City -->
									    <input type="hidden" name="usermaster[sCityName]" id="sCityName" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sCityName'];} ?>">
									    <!-- State returned from the google api - to be tested on backend -->
									    <input type="hidden" name="usermaster[apiStateName]" id="apiStateName" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['apiStateName'];} ?>">
									    <input type="hidden" name="zip-state-mismatch" id="#zip-state-mismatch" value="">

									    <!-- Zip Code -->
									    <input type="text" class="form-control form-control-sm clearDefault mt-0 mt-4" name="usermaster[iZipcode]" id="iZipcode" placeholder="Zip Code" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iZipcode'];} ?>"/> 
									    <div class="container text-danger mt-2 d-none" id="zipStateErrorDiv"></div>
					      			</div>
						      	</div>
						    </div>
					    </div>
				    <!-- /Slide 2 -->

				    <!-- Slide 3 -->
					    <div class="carousel-item bg-transparent" id="step3" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 3</h5>
										<div id="accordion"> <!-- Accordion div -->
											<!-- solo -->
												<div class="card bg-gs pb-0">
												    <div class="card-header" id="headingOne">
												     	<!-- <a href="" class="text-white"  > -->
															<div class="container py-3 text-center">
																<div class="row justify-content-center">
																	<div class="col-1">
																		<input type="radio" <?php if($_POST && $errorCount > 0 ){if($_POST['loginmaster']['sUserType'] == 'artist'){echo 'checked';}} ?> id="soloSelction" name="loginmaster[sUserType]" value="artist" data-toggle="collapse" data-target="#solo-info" aria-expanded="true" aria-controls="solo-info">
																	</div>
																	<div class="col-5 pl-0">
																		<h5 class="text-white">Solo Artists</h5>
																	</div>
																</div>
															</div>	
														<!-- </a> -->
												    </div>

												    <div id="solo-info" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
												      <div class="card-body">
												        <!-- Select A talent -->
															<?php 
																/* Query DB for talent options */
														    		$cond = 'isActive = 1'; 
														       		$talentArray = $obj->fetchRowAll('giftmaster', $cond);
														    ?>
												            <select class="custom-select dropdown py-0 mb-4"  name="talentmaster[TalentID]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
														       	<option value="">Talent</option>
														       	<?php 

															    	foreach($talentArray as $evID => $talent) {
															    		if($_POST && $errorCount > 0 ){
															    			if($talent['iGiftID'] == $_POST["talentmaster"]["TalentID"]){
															    				echo '<option selected value="' .$talent['iGiftID'] . '" >' . $talent['sGiftName'] . '</option>'; 
															    			}
															    			else{
																    			echo '<option value="' .$talent['iGiftID'] . '" >' . $talent['sGiftName'] . '</option>'; 
																    		}
															    		} 
															    		else{
															    			echo '<option value="' .$talent['iGiftID'] . '" >' . $talent['sGiftName'] . '</option>'; 
															    		}
															    	}
															    ?>
														    </select>
														    <!-- Add the talent name to to the $_POST Array in javascript some how -->
														    <!-- Add sUserType = artist value to both usertype inputs in step 1 if this TalentID select input is not empty when form is submitted otherwise sUserType = group -->
												       </div>
												    </div>
												</div>
											<!-- /solo -->

											<!-- Group -->
												<div class="card">
												    <div class="card-header" id="headingTwo">
												     	<!-- <a href="" > -->
															<div class="container bg-white text-gs p-2">
																<div class="row justify-content-center">
																	<div class="col-1">
																		<input type="radio" <?php if($_POST && $errorCount > 0 ){if($_POST['loginmaster']['sUserType'] == 'group'){echo 'checked';}} ?> id="groupSelection" name="loginmaster[sUserType]" value="group" data-toggle="collapse" data-target="#group-info" aria-expanded="false" aria-controls="group-info">
																	</div>
																	<div class="col-5 pl-0">
																		<h5 class="mb-0">Artists Groups</h5>
																		<span class="m-0" style="font-size:12px">(Bands, Dance groups, Singing groups, etc)</span>
																	</div>
																</div>
															</div>
														<!-- </a> -->
												    </div>
												    <div id="group-info" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
												      <div class="card-body">
												      	<input type="text" class="form-control form-control-sm clearDefault mt-0 mb-4" name="usermaster[sGroupName]" placeholder="Group's Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sGroupName'];} ?>"/> 
												      	<!-- Add sUserType = group value to both usertype inputs in step 1 if this sGroupName input is not empty when form is submitted otherwise sUserType = artist -->
												      </div>
												    </div>
												</div>
	  										<!-- /Group -->
										</div> <!-- /Accordion div -->
					      			</div>
						      	</div>
						    </div>
					    </div>
				    <!-- /Slide 3 -->

				    <!-- Slide 4 -->
				    	<style>
							.thumb {
								width: 100px;
								height: 100px;
								object-fit:cover; 
								object-position:0,0;
							}
							#thumb {
								box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);
								background-image: url("../img/dummy.jpg");
								background-size: 100px 100px;
								background-repeat:  no-repeat;
								background-position:  center;
								object-fit:cover; 
								object-position:0,0;
							}
						</style>
					    <div class="carousel-item bg-transparent" id="step4" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 4</h5>
					    				<!-- Upload Profile Pic -->
					    				<div class="container">
					    					<div class="row">
					    						<div class="col-12 col-md-3">
					    							<div class="" id="thumb" style="height:100px;width:100px;"></div>
					    						</div>
					    						<div class="col pl-md-5">
					    							<div class="custom-file mt-4">
													  	<input type="file" class="custom-file-input" name="sProfileName" id="sProfileName">
													  	<label class="custom-file-label" style=" text-align:left" for="sProfileName">Upload Profile Img</label>
													</div>
					    						</div>
					    					</div>
						    				
										</div>

										 <!-- Availability -->
							            <select class="custom-select dropdown py-0 mt-4"  name="usermaster[sAvailability]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
									       	<option value="">Availability</option>
									       	<?php 
									       		$availArray = array('Currently Gigging(Not excepting new gigs)','Looking For Gigs(Currently excepting new gigs)','Will Play For Food (Just Cover my cost to get there and back)','Will Play For Free');
									       		foreach($availArray as $availStatus){
									       			if($_POST && $errorCount > 0 ){
										       			if($_POST['usermaster']['sAvailability'] == $availStatus){
											       			echo '<option selected value="' . $availStatus . '">' . $availStatus . '</option>';
											       		}
											       		else{
											       			echo '<option value="' . $availStatus . '">' . $availStatus . '</option>';
											       		}
											       	}
										       		else{
										       			echo '<option value="' . $availStatus . '">' . $availStatus . '</option>';
										       		}
									       		}
									       	?>
									    </select>

									    <!-- Years of Experience -->
									    <input type="text" class="form-control form-control-sm clearDefault mt-4" name="usermaster[iYearOfExp]" placeholder="Years of Experience" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iYearOfExp'];} ?>"/> 

									    <!-- Send Emaill Confirmation -->
									    <div class="container text-left mt-4">
									    	<label for="emailConf">
											    <input type="checkbox" <?php if($_POST && $errorCount > 0 ){echo 'checked';}?> name="emailConf" id="emailConf" value="sendEmail" data-title="NOTICE" data-container="body" data-toggle="popover" data-trigger="focus" data-animation="true" data-placement="bottom" data-content="Once you click send email, you will have 10 minutes to enter your confirmation id and submit your profile before this page expires!!! ">
											    Send Email confirmation
											</label>
										</div>
					      			</div>
						      	</div>
						    </div>
					    </div>
					    <!-- Javascript for step 4 -->
							<script>
								/************* Display thumbnail when profile img is selected by user *******************/
									function handleFileSelect(evt) {
										/* FileList object */
											var files = evt.target.files; 

										/* Loop through the FileList and render image files as thumbnails. */
											for (var i = 0, f; f = files[i]; i++) {
												
												/* Only process image files. */
												    if (!f.type.match('image.*')) {
												    	console.log('this is not an image');
												    	break;
												    }
												    // else{
												    // 	continue; -- LOOK UP WHAT CONTINUE DOES TO THE JS
												    // }

												 /* Instantiate New FileReader object to read file contents into memory */
												 	var reader = new FileReader();

												 /* When file loads into memory, reader's onload event is fired - Capture file info */	
												 	reader.onload = (function(theFile) {

												 		return function(e) {
												 			/* Render Thumbnail */
												 				var span = document.createElement('span'); //Create a <span></span> element

												 				span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); //LOOK UP .JOIN() METHOD

												 				/* Clear the div that displays the thumbnail b4 new thumbnail is shown */
												 					document.getElementById('thumb').innerHTML = '';

												 				/* Insert new thumbnail */
												 				document.getElementById('thumb').insertBefore(span, null);
												 		}
												 	})(f);

												 	/* Read in the image file as a data URL. */
								      					reader.readAsDataURL(f);
											}
									}
									document.getElementById('sProfileName').addEventListener('change', handleFileSelect, false);
								/*********** END - Display thumbnail when profile img is selected by user ************/

								/* Have to initailize the popover functionality for it to work */
									$(document).ready(function(){
										$('[data-toggle="popover"]').popover();
									});
								/* END - Have to initailize the popover functionality for it to work */
							</script>
						<!-- /Javascript for step 4 -->
				    <!-- /Slide 4 -->

				    <!-- Slide 5 -->
					    <div class="carousel-item bg-transparent" id="step5" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 5</h5>
					    				 <!-- Confirmation Id -->
					    				 <div class="container text-left">
						    				<h6>Check your email for your confirmation id</h6>
						    				<div class="container">
						    					<input type="text" class="form-control form-control-sm clearDefault mt-2" id="confCode" name="confirmationID" placeholder="Enter Confirmation Id" value=""/> 
						    				</div>
						    			</div>
									    
									    <div class="container text-left">
										    <h6 class="mt-4 mb-0">By clicking submit I agree that: </h6>
										    <div class="container">
											    <ul class="mt-0" style="font-size: 12px">
											    	<li>I have read and accepted the <a href="<?php echo URL;?>views/terms.php" target="_blank" class="text-gs">Terms of Use</a> and <a href="#" class="text-gs">Privacy Policy</a></li>
											    </ul>
											</div>
										</div>

										<div class="container">
											<input type="button" id="btn_checkCode" class="btn btn-sm btn-gs" value="Confirm Code" disabled>
											<input type="submit" id="btn_submit" class="btn btn-sm btn-primary d-none" value="Create Profile" disabled>
										</div>
										<div id="confCodeError" class="container d-none"></div>
					      			</div>
						      	</div>
						    </div>
					    </div>
				    <!-- /Slide 5 -->

				</form>
			</div>
		</div>

		<!-- Signup carousel nav buttons -->
			<div class="container mt-0">
			  	<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				    <li class="page-item disabled" id="tab0"><a class="page-link change-tabs move-tab-backward text-gs" href="" role="button" data-slide="prev">Previous</a></li>
				    <li class="page-item" tabindex="-1" id="tab1" style="min-width:100px"><a class="page-link pl-4 move-tab-forward text-gs" role="button" data-slide="next" tabindex="-1" >Next</a></li>
				  </ul>
				</nav>
			</div>
		<!-- /Signup carousel nav buttons -->
	</div>
</div>



<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="<?php echo URL;?>js/additional-methods.js"></script>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>

<script>
	/**************************************** Date and Time Picker plugin JS ***************************/
		$(function () {
			var dat = $("input[name=todaysDate]").val();
 			$("#datetimepicker1").datetimepicker({
			 	format: "YYYY-MM-DD",
			 	defaultDate: false,
			 	maxDate: dat,
			 	//minDate: moment(),
			 	// maxDate: moment().subtract(10,'year'),
			 	//useCurrent: true, 
			 	allowInputToggle: true
			 });
		});
	/************************************** END - Date and Time Picker plugin JS ************************/
	/********************** Add validation classes ************************/
		jQuery.validator.addClassRules("rule1", {
			required: true,
			minlength: 2
		});
	/******************* End - Add validation classes *********************/

	/************************* Create Custom validation methods ***************************/
		// jQuery.validator.addMethod('passwordStrenght', function(value, element){
		// 	return this.optional(element) || 
		// }, 'Password does not meet the minimum requirements');

		jQuery.validator.addMethod('math', function(value, element, param){
			return value == param;
		}, 'value not correct');

		//Customize the built-in email validation rule
			$.validator.methods.email = function(value, element){
				return this.optional(element) || /[a-zA-Z0-9]+@[a-z0-9]+\.[a-z]/.test(value);
			}
	/********************** END - Create Custom validation methods ************************/

	/******************* Grab form to validate - set validation rules *********************/
		var signUpForm = $("#artist-signup");

		signUpForm.validate({
			// Handle form when submission is In-Valid
				invalidHandler: function(event, validator){
					var numbErrors = validator.numberOfInvalids();
					if(numbErrors){
						var message = numbErrors == 1 ? 'You missed 1 field. Please Check Previous Steps.'
												  : 'You missed ' + numbErrors + ' fields. Please Check Previous Steps.';
						$('div.error').html(message);
						$('div.error').show(); 
					}
					else{
						$('div.error').hide();
					}
				},

			// Elements to be ignored are set with .ignore class 
				ignore: ".ignore",

			// Set validation rules for the form
				rules:{
					'loginmaster[sEmailID]': {
						required: true,
						email: true
					},
					'loginmaster[sPassword]': {
						required: true,
						minlength: 8 
					},
					'loginmaster[ConfsPassword]': {
						required: true,
						equalTo: "#loginmaster-sPassword"
					},
					'usermaster[iZipcode]': {
						required: true,
						minlength: 5,
						maxlength: 5,
						digits: true
					},
					'usermaster[dDOB]': {
						required: true
					},
					'usermaster[sCountryName]': {
						required: true
					},
					'usermaster[sStateName]': {
						required: true
					},
					'talentmaster[TalentID]': {
						required: {
							depends: function(element){
								return $('#soloSelection').is(':checked');
							}
						}
					},
					'usermaster[sGroupName]': {
						required: {
							depends: function(element){
								return $('#groupSelection').is(':checked');
							}
						}
					},
					sProfileName: {
						required: true,
						accept: "image/*"
					},
					'usermaster[sAvailability]': {
						required: true
					},	
					'usermaster[iYearOfExp]': {
						required: true,
						digits: true,
						maxlength: 2
					},
					'loginmaster[sUserType]': {
						required: true
					},
					emailConf: {
						required: true,
					}
				},
				messages: {
					sProfileName: {
						required: 'Please upload a profile img',
						accept: 'Please upload img files only'
					},
					'usermaster[sAvailability]': {
						required: 'Please select your availability'
					},
					'usermaster[iYearOfExp]': {
						required: 'How long have you been performing',
						maxlength: 'Sorry, two-digit max',
						digits: 'Please enter a valid numeric value'
					},
					emailConf: {
						required: 'Please select to receive an email confirmation id'
					},
					'usermaster[sStateName]': {
						required: 'Please select your state'
					},
					'usermaster[iZipcode]': {
						required: 'Please enter your zip code'
					}
				}
		});
	/******************* END - Grab form to validate - set validation rules *********************/
	
	/********************************* Carousel Navigation **************************************/
		
		var car = $('.carousel');
		var emailCount = 0; //var to track how many confirmation emails have been sent

		/* when the change-tabs class is clicked validate the current slides inputs */
			$('.move-tab-forward').click(function(){
				var currentInputs = $('div.active input, div.active select');
				var j=0; 

				/************* Validate each input on the current slide ***************/
					currentInputs.each(function(){
						if($(this).valid() == false){
							j+=1; 
						}
					});
					console.log(); 
				/********** END - Validate each input on the current slide ************/

				/****************** validate Zip code *************************/
					if($('div.active').attr('id') == 'step2'){
						/****** execute Javascript to contact google geocoding api ******/
							$.support.cors = true;
						    $.ajaxSetup({ cache: false });
						    var city = '';
						    var hascity = 0;
						    var hassub = 0;
						    var state = '';
						    var nbhd = '';
						    var subloc = '';
						    //var userState = $('#sStateName').val();
						    var userZip = $('#iZipcode').val();

						    if(userZip.length == 5){
								 	var date = new Date();
									$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
								        //find the city and state
											var address_components = response.results[0].address_components;
											$.each(address_components, function(index, component){
												 var types = component.types;
												 $.each(types, function(index, type){
													/*				 
													if(type == 'locality') {
													  city = component.long_name;
													  hascity = 1;
													}
													if(type == 'administrative_area_level_1') {
													  state = component.long_name;
													}
													if(type == 'neighborhood') {
													  nbhd = component.long_name;
													}
													if(type == 'sublocality') {
													  subloc = component.long_name;
													  hassub = 1;
													}
													*/
													/*
											console.log(state+' & '+userState);
											if(state == userState){
												$('#sCityName').val(city);
												$('#apiStateName').val(state);
											}
											else{
												$('#sCityName').val('');
											}
											
											*/
											/* Loop throught the select options to grab the statename for comparison to api results */

													if(type == 'locality') {
														city = component.long_name;
														hascity = 1;
													}
													if(type == 'administrative_area_level_1') {
														state = component.long_name;
													}
													if(type == 'neighborhood') {
														nbhd = component.long_name;
														hasnbhd = 1;
													}
													if(type == 'sublocality') {
														subloc = component.long_name;
														hassub = 1;
													}
												 });
											});
											
											$('#sStateName > option:selected').each(function() {
											    var userState = $(this).text();	
											    
												if(state == userState){
														$('#zipStateErrorDiv').addClass('d-none'); 
														
														if(hascity == 1){
															$('#sCityName').val(city);
														}
														else if(hasnbhd == 1){
															$('#sCityName').val(nbhd);
														}
						
														/* Assign api-retrieved State  */
															$('#apiStateName').val(state);
															//console.log('city: '+$('#sCityName').val() +' & state: '+$('#apiStateName').val());
															car.carousel('next');
															car.carousel('pause');
												}
												else{
													$('#zipStateErrorDiv').removeClass('d-none'); 
													$('#zipStateErrorDiv').text('State/Zip code Mismatch');
													//console.log('State/Zip code Mismatch');
												}											    
											});
								    });
					      	}
					  	/****** END - execute Javascript to contact google geocoding api ******/
				  	}
				  	else{
				  		$('#zipStateErrorDiv').addClass('d-none'); 
				  		/************* Move to next slide if there are no validation errors ********************/
				  			if(j == 0){
								car.carousel('next');
								car.carousel('pause');
							}
						/************* END - Move to next slide if there are no validation errors ********************/	
					}
				/*************** END - validate Zip code **********************/


				if($('div.active').attr('id') == 'step4'){
					$(this).text('Send Email');
				}
				else{
					$(this).removeClass('sendConfEmail');
				}

				if($('div.active').attr('id') == 'step5'){
					$(this).text('Next');

					/********************* Send Confirmation email ********************/
						var sendEmaiChecked = document.getElementById('emailConf').checked; 
						if(sendEmaiChecked){
							emailCount +=1; 
							
							var param2 = $('#sEmailID2').val(); 
							var param3 = $('#sFirstName').val(); 
							var param4 = emailCount; 
							var param5 = 'Artist';

							var formData = new FormData(); 
							formData.append('confirmCode', 1); 
							formData.append('newUserEmail', param2);
							formData.append('newUserName', param3);
							formData.append('emailCount', param4);
							formData.append('profileType', param5);

							var sendMail = new XMLHttpRequest(); 
							sendMail.onreadystatechange = function(){
								if(sendMail.status == 200 && sendMail.readyState == 4){
									var uniqueID = sendMail.responseText.trim(); 

									if(uniqueID.length == 8){
										$('input[name=confirmationCode]').attr('value',uniqueID);
									}
									else{
										console.log(uniqueID);
									}
								}
							}
							sendMail.open("POST", "<?php echo URL;?>views/emailConf");
							sendMail.send(formData); 

							/* Set the time out function within a function triggered by the submit button. */
			 					setTimeout(function(){ window.location.href = 'https://www.gospelscout.com';},600000);
		 				}
	 				/******************* END - Send Confirmation email *******************/
				}

				// Disable previous button when 1st slide is active - disable next button when 5th slide is active
					if($('div.active').attr('id') != 'step1'){
						$('#tab0').removeClass('disabled');
					}
					if($('div.active').attr('id') == 'step5'){
						$('#tab1').addClass('disabled');
					}
			});
			$('.move-tab-backward').click(function(event){
				event.preventDefault(); 
				car.carousel('prev');
				car.carousel('pause');

				if($('div.active').attr('id') == 'step4'){
					$('.move-tab-forward').text('Send Email');
					$('#confCode').val(''); 
					$('#confCodeError').html('');
					$('#confCodeError').addClass('d-none');
				}
				else{
					$('.move-tab-forward').text('Next');
				}

				if($('div.active').attr('id') == 'step1'){
					$('#tab0').addClass('disabled');
				}
				if($('div.active').attr('id') != 'step5'){
					$('#tab1').removeClass('disabled');
				}
			});

			/* Create keyup function for confirmation id input box 
				1. when confirmation id is confirmed remove disabled prop from create profile button and add disabled property to the previous button
					a. this will prevent users from invalidating data and being able to submit the profile. 
			*/
				var y = 0; 
				$('#confCode').keyup(function(){
			 		y = y + 1; 
			 		if(y == 1){
			 			$('#btn_checkCode').removeProp("disabled");
			 		}
			 	});

			/* Verify confirmation code */
				$('#btn_checkCode').click(function(event){
					var uniqueID = $('input[name=confirmationCode]').val();
					var enteredConf = $('#confCode').val(); 

					var confirmCode = new FormData(); 
					confirmCode.append('checkConfCode',enteredConf);
					confirmCode.append('uniqueID',uniqueID);

					var checkConfCode = new XMLHttpRequest();
					checkConfCode.onreadystatechange = function(){
						if(checkConfCode.readyState == 4 && checkConfCode.status == 200){
							var codeStatus = checkConfCode.responseText.trim();
							if(codeStatus == 'codeValid'){
								$('#confCodeError').html('');
								$('#confCodeError').addClass('d-none');

								$('#btn_checkCode').addClass("d-none");
								$('#btn_submit').removeProp("disabled");
								$('#btn_submit').removeClass("d-none");

								$('#confCodeError').html('<h6 class="text-success mt-3">Code Confirmed!!!</h6>');
								$('#confCodeError').removeClass('d-none');
							}
							else{
								$('#confCodeError').html('<h6 class="text-danger mt-3">Code Invalid!!!</h6>');
								$('#confCodeError').removeClass('d-none');
							}
						}
					}
					checkConfCode.open('POST', "<?php echo URL;?>views/emailConf");
					checkConfCode.send(confirmCode);

				});
			/* END - Verify confirmation code */
	/****************************** END - Carousel Navigation ***********************************/
</script>

