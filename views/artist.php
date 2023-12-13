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

	

	/* Create a randomly generated confirmation # and email the new user prompting them to enter the confirmation on this page to finish creating their profile */
		echo '<input type="hidden" name="confirmationCode" value="">';
	/* END - Create a randomly generated confirmation # and email the new user prompting them to enter the confirmation on this page to finish creating their profile */
	
?>
 <!-- Dropzone.js file upload plugin -->
    <link href="<?php echo URL; ?>node_modules/dropzone/dist/dropzone.css" rel="stylesheet">
    <script src="<?php echo URL;?>node_modules/dropzone/dist/dropzone.js"></script>
    
<div id="carouselExampleIndicators" class="carousel mb-2 pt-0 pb-0 mt-5 text-center valid-form-check bg-bg2" style="background-image: url(https://www.stage.gospelscout.com/img/carouselFinal.png); background-size: cover" data-wrap="false" data-interval="false" data-ride="false"> <!-- carousel-->
	 <div  class="pt-5" style="width:100%; height:100%;background-color: rgba(149,73,173,.3);">
	 	<div class="error p-3 text-danger" id="form-error-div" style="font-weight: bold"></div>
		<h4 class="mt-4 text-white">Artist Sign Up</h4>
					
		<div class="carousel-inner ">
			<div class="container px-md-5" >
				<form action="artist" method="post" name="artist-signup" id="artist-signup" enctype="multipart/form-data" autocomplete="off">
					<!-- Slide 1 -->
					    <div class="carousel-item active bg-transparent mb-2" id="step1" style="min-height:400px; height:auto;">
					    	<div class="container pt-2" >
					    		<div class="row pt-3 justify-content-center">
					    			<div class="col col-md-5 pt-3 pb-5 bg-white signup-steps" style="max-height: 475px;overflow:scroll;">
					    				<h5 class="mb-4 text-gs">Step 1 of 5</h5>
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
					    <div class="carousel-item bg-transparent mb-2" id="step2" style="min-height:400px; height:auto;">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 text-center bg-white pt-3 pb-5 signup-steps" style="max-height: 475px;overflow:scroll;">
					    				<h5 class="mb-4 text-gs">Step 2 of 5</h5>
					    				
					    				<!-- Security Questions -->
					    					<!--<div class="mb-0 text-left text-gs" style="font-size:12px;font-weight:bold;"><label>Security Question 1</label></div>
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
											</div>-->
					    				<!-- /Security Questions -->
					    				
					    				<!-- Upload Profile Pic -->
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
											h1 { text-align: center; }
	
							                            .dropzone1 {
							                                background: white;
							                                border-radius: 5px;
							                                /*border: 2px dashed rgba(149,73,173,1);*/
							                                border: none;
							                                border-image: none;
							                                max-width: 800px;
							                                margin-left: auto;
							                                margin-right: auto;
							                            }
										</style>
						    				<div class="container mt-0">
					    					<div class="row ">
					    						<div class="col-12 col-md-4 py-3 pl-0 justify-content-center">
					    							<div class="mb-2 mx-auto mx-md-0" id="thumb" style="height:120px;width:120px;"></div>
					    						</div>
					    						<div class="col-12 col-md-6 pl-0 text-center text-md-left align-self-end" style="max-height:50px">
					    							 <!-- <DIV class="py-3"> -->
								                          <div class="dropzone-previews pb-3" style="height:50px" id="demo-upload" ><!-- dropzone1   -->
								                            <DIV class="dz-message needsclick">    
								                             <button  class="btn btn-sm btn-gs " type="button">Upload Profile Image</button>
								                            </DIV>
								                          </div>

								                          <DIV id="preview-template" style="display: none;">
								                          <DIV class="dz-preview dz-file-preview">

								                            <DIV class="dz-image">
								                              <IMG data-dz-thumbnail="">
								                            </DIV>
								                            <!-- Error Message display -->  
								                              <DIV class="dz-error-message">
								                                <SPAN data-dz-errormessage=""></SPAN>
								                              </DIV> 
								                            <a  data-dz-remove class="mt-1 text-gs">remove</a> <!-- type="button"  btn-gs btn-sm-->
								                           </DIV>
								                        </DIV>
								                        <!-- </DIV> -->
					    							<!-- <div class="custom-file mt-4">
													  	<input type="file" class="custom-file-input" name="sProfileName" id="sProfileName">
													  	<label class="custom-file-label" style=" text-align:left" for="sProfileName">Upload Profile Img</label>
													</div> -->
					    						</div> 
					    					</div>
						    				<div class="row">
						    					<div class="col-12 mt-0 text-center text-md-left" id="profImg_err"></div>
						    				</div>
										</div> 

										

					    				<!-- Birth Date -->
										<div class="input-group date dateTime-input mt-4 mt-0" id="datetimepicker1">
								               		<input type="text" autocomplete="off" class="form-control form-control-sm clearDefault mt-0" name="usermaster[dDOB]" placeholder="Brith Date (yyyy-mm-dd)" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['dDOB'];} ?>"/> 
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
					    <div class="carousel-item bg-transparent mb-2" id="step3" style="min-height:400px;height:auto;">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps" style="max-height: 475px;overflow:scroll;">
					    				<h5 class="mb-4 text-gs">Step 3 of 5</h5>
										<div id="accordion"> <!-- Accordion div -->
											<!-- solo -->
												<div class="card bg-gs pb-0">
												    <div class="card-header" id="headingOne">
												     	<!-- <a href="" class="text-white"  > -->
															<div class="container py-3 text-center">
																<div class="row justify-content-center">
																	<div class="col-1">
																		<input type="radio" <?php if($_POST && $errorCount > 0 ){if($_POST['loginmaster']['sUserType'] == 'artist'){echo 'checked';}} ?> id="soloSelection" name="loginmaster[sUserType]" value="artist" data-toggle="collapse" data-target="#solo-info" aria-expanded="true" aria-controls="solo-info">
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

				    <!-- Slide unknown -->
					    <!--<div class="carousel-item bg-transparent" id="step4" style="min-height:400px;">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 4 of 6</h5> -->
					    				

										 <!-- Availability -->
							            <!--<select class="custom-select dropdown py-0 mt-4"  name="usermaster[sAvailability]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
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
									    </select> -->

									    <!-- Years of Experience -->
									    <!-- <input type="text" class="form-control form-control-sm clearDefault mt-4" name="usermaster[iYearOfExp]" placeholder="Years of Experience" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iYearOfExp'];} ?>"/>  -->

									    <!-- Send Emaill Confirmation -->
									    <!-- <div class="container text-left mt-4">
									    	<input type="checkbox" <?php if($_POST && $errorCount > 0 ){echo 'checked';}?> name="emailConf" id="emailConf" value="sendEmail" data-title="NOTICE" data-container="body" data-toggle="popover" data-trigger="focus" data-animation="true" data-placement="bottom" data-content="Once you click send email, you will have 10 minutes to enter your confirmation id and submit your profile before this page expires!!! ">
									    	<label for="emailConf">
											Send Email confirmation
										</label>
									    </div>
					      			</div>
						      	</div>
						    </div>
					    </div> -->
					    
				    <!-- /Slide unknown -->

				    <!-- Slide 4 -->
					    <div class="carousel-item bg-transparent mb-2" id="step4" style="min-height:400px;height:auto;">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps" style="max-height: 475px;overflow:scroll;">
					    				<h5 class="mb-4 text-gs">Step 4 of 5</h5>
					    				 <!-- Confirmation Id -->
					    				 <div class="container text-center font-weight-bold" style="font-size: .8em;">
						    				<p class="mb-0" >We've sent a confirmation code to your email.</p>  
						    				<p class="mt-0">Verify your code below</p>
						    				<div class="container">
						    					<input type="text" class="form-control form-control-sm clearDefault mt-2" id="confCode" name="confirmationID" placeholder="Enter Confirmation Id" value=""/> 
						    				</div>
						    			</div>
									    
										<div class="container mt-3">
											<div class="row text-center mt-3">
												<div class="col-5 mx-auto">
													<button type="button" class="btn btn-block btn-gs text-white p-2" id="btn_checkCode" tabindex="3" style="font-size:13px" disabled>
														Confirm Code
													</button>
												</div>
											</div>
										</div>
										<div id="confCodeError" class="container d-none"></div>
					      			</div>
						      	</div>
						    </div>
					    </div>
				    <!-- /Slide 4 -->
				    
				    <!-- Slide 5 -->
					    <div class="carousel-item bg-transparent mb-2" id="step5" style="min-height:400px;height:auto;">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps" style="max-height: 475px;overflow:scroll;">
					    				<h5 class="mb-2 text-gs">Step 5 of 5</h5>
					    				 <!-- Confirmation Id -->
					    				 <div class="container text-left mt-0 pt-0">
						    				<h6>Last Step, Get Paid!!!</h6>
						    				<p style="font-size:.7em">We use Stripe to make sure you get paid on time and to keep your personal bank and details secure. Fill in the acct info below and click <span class="font-weight-bold">Submit & Create Profile</span> to set up your profile to receive payments on Stripe..</p> 
						    				<p style="font-size:.7em"><span class="font-weight-bold">Note:</span> Your account info is securely collected and stored using stripe's api.  We do not store any of this information on GospelScout Servers.</p>
						    			</div>

						    			<!-- <div class="container">
						    				<div class="row">
						    					<div class="col">
						    						<input type="text" class="form-control form-control-sm clearDefault mt-2 str_accnts" id="rout_num" name="stripe[rout_num]" placeholder="Routing Number" value=""/> 
						    						<input type="text" class="form-control form-control-sm clearDefault mt-2 str_accnts" id="acct_num" name="stripe[acct_num]" placeholder="Account Number" value=""/> 
						    					</div>
						    				</div>
						    			</div> -->
									    
									    <div class="container text-left mb-0">
										    <h6 class="mt-4 mb-0">By clicking submit you agree that: </h6>
										    <div class="container">
											    <ul class="my-0" style="font-size: 12px">
											    	<li>You have read and accepted the <a href="<?php echo URL;?>newHomePage/views/terms.php" target="_blank" class="text-gs">Terms of Use</a>, <a href="#" class="text-gs">Privacy Policy</a>, and <a href="https://stripe.com/connect-account/legal" target="_blank" class="text-gs"> Stripe Connected Account Agreement</a></li>.
											    </ul>
											</div>
										</div>

										<div class="container mt-0">
											<!-- <input type="button" id="btn_checkCode" class="btn btn-sm btn-gs" value="Confirm Code" disabled> -->
											<input type="submit" id="btn_submit" class="btn btn-sm btn-primary mt-0" value="Submit & Create Profile"> <!-- d-none disabled -->
											<div>
												<!-- <a href="#" class="text-gs text-left mt-0" style="font-size:.7em">Skip this step for now</a> -->
												<input type="checkbox" name="skipStripeSetup" onclick="hideStrInputs()" value="true" class="form-check-input" id="skipStripeSetup">
                                    								<label class="form-check-label text-gs" for="skipStripeSetup" style="font-size:.7em">Skip this step for now</label><br>
											</div>
										</div>
										<div class="container">
						    				 <img class="featurette-image img-fluid mx-auto" src="<?php echo URL;?>img/powered_by_stripe.png" width="100" height="50" data-src="" alt="Generic placeholder image">
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
<!--<script src="<?php echo URL;?>js/jsFunctions.js"></script>-->
<script src="<?php echo URL;?>js/artistJS.js?47"></script>



