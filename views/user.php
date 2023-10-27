<?php 
	/* Sign up Page for general users */

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
			elseif($currentUserType == 'gen_user'){
				echo '<script>window.location = "'. URL .'index.php";</script>';
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
		}

	/* Define date var */
		$today0 = date_create();
		$today = date_format($today0, 'Y-m-d H:i:s');


	/* Store Unique ID */
		echo '<input type="hidden" name="confirmationCode" value="">';
?>


<div id="carouselExampleIndicators" class="carousel mb-2 pt-0 pb-0 mt-5 text-center valid-form-check bg-bg2" style="background-image: url(https://www.gospelscout.com/img/carouselFinal.png); background-size: cover" data-wrap="false" data-interval="false" data-ride="false"> <!-- carousel-->
	 <div  class="pt-5" style="width:100%; height:100%;background-color: rgba(149,73,173,.3);">
	 	<div class="error p-3 text-danger" style="font-weight: bold"><?php if($_POST && $errorMessage != ''){echo $errorMessage;}?></div>
		<h4 class="mt-4 text-white">General User Sign Up</h4>
					
		<div class="carousel-inner">
			<div class="container px-md-5" >
				<form  method="post" name="artist-signup" id="artist-signup" enctype="multipart/form-data" autocomplete="off">
					<!-- Slide 1 -->
					    <div class="carousel-item active bg-transparent mb-2" id="step1" style="min-height:400px;height:auto">
					    	<div class="container pt-2" >
					    		<div class="row pt-3 justify-content-center">
					    			<div class="col col-md-5 pt-3 pb-5 bg-white signup-steps" style="">
					    				<h5 class="mb-4 text-gs">Step 1 of 3</h5>
								      	<input type="text" class="form-control form-control-sm mt-4 rule1" data-msg-required="Please enter a valid name" data-msg-minlength="Name must be at least 2 characters"  name="usermaster[sFirstName]" id="sFirstName" placeholder="First Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sFirstName'];} ?>">

								      	<input type="text" class="form-control form-control-sm mt-4 rule1" data-msg-required="Please enter a valid name" data-msg-minlength="Name must be at least 2 characters" name="usermaster[sLastName]" id="sLastName" placeholder="Last Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sLastName'];} ?>">
								      
								      	<input type="email" class="form-control form-control-sm mt-4" data-msg-required="Please enter a valid email address" data-msg-email="Email is not valid" name="loginmaster[sEmailID]" id="sEmailID2" placeholder="Email Address" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['loginmaster']['sEmailID'];} ?>">
								      	
								      	<!-- may have to add an email element in the FormData object for email to the usermaster table -->
								      	<input type="password" class="form-control form-control-sm mt-4" data-msg-required="Please enter a valid password" data-msg-minlength="Password must be at least 8 characters" name="loginmaster[sPassword]" id="loginmaster-sPassword" placeholder="Enter Password" value="">
								      	
								      	<input type="password" class="form-control form-control-sm mt-4"data-msg-required="Please confirm password" data-msg-equalTo="Password does not match" name="loginmaster[ConfsPassword]" placeholder="Confirm Password" value="">
								      	
								      	<input type="hidden" name="loginmaster[sUserType]" value="gen_user">
								     </div>
						      	</div>
						    </div>
					    </div>
					<!-- /Slide 1 -->

					<!-- Slide 2 -->
					    <div class="carousel-item bg-transparent" id="step2" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 text-center bg-white pt-3 pb-5 signup-steps mb-2" style="max-height: 475px;overflow:scroll;">
					    				<h5 class="mb-4 text-gs">Step 2 of 3</h5>

					    				<!-- Security Questions -->
					    					<!-- <div class="mb-0 text-left text-gs" style="font-size:12px;font-weight:bold;"><label>Security Question 1</label></div>
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
											</div> -->
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
									</style>
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


					    				<!-- Birth Date -->
										<div class="input-group date dateTime-input mt-4 mt-0" id="datetimepicker1">
						               		<input type="text" autocomplete="off" class="form-control form-control-sm clearDefault mt-0" id="DOB" name="usermaster[dDOB]" placeholder="Brith Date" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['dDOB'];} ?>"/> 
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
									    	/* Fetch States */
												$cond = 'country_id = 231'; 
												$stateArray = $obj->fetchRowAll('states', $cond);
											/* END - Fetch States */
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
									    

									    <!-- Zip Code -->
									    <input type="text" class="form-control form-control-sm clearDefault mt-0 mt-4" name="usermaster[iZipcode]" id="iZipcode" placeholder="Zip Code" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iZipcode'];} ?>"/> 
					      			</div>
						      	</div>
						    </div>
					    </div>
				    <!-- /Slide 2 -->



				    <!-- Slide unknown -->
					    <!-- <div class="carousel-item bg-transparent" id="step3" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 3 of 4</h5>-->
					    				
									    <!-- Send Emaill Confirmation -->
									    <!--<div class="container text-left mt-4">
									    	<label for="emailConf">
									    		<div>--> <!-- Div helps w/ validation error message placement -->
												    <!--<input type="checkbox" <?php if($_POST && $errorCount > 0 ){echo 'checked';}?> name="emailConf" id="emailConf" value="sendEmail" data-title="NOTICE" data-container="body" data-toggle="popover" data-trigger="focus" data-animation="true" data-placement="bottom" data-content="Once you click send email, you will have 10 minutes to enter your confirmation id and submit your profile before this page expires!!! ">
												    Send Email confirmation-->
												<!--</div>
											</label>
										</div>
					      			</div>
						      	</div>
						    </div>
					    </div> -->
					    
				    <!-- /Slide unknown -->

				    <!-- Slide 3 -->
					    <div class="carousel-item bg-transparent" id="step3" style="min-height:400px">
					    	<div class="container pt-2">
					    		<div class="row pt-3 justify-content-center">
					    			<div class=" col col-md-5 bg-white text-center pt-3 pb-5 signup-steps">
					    				<h5 class="mb-4 text-gs">Step 3 of 3</h5>
					    				 <!-- Confirmation Id -->
					    				 <div class="container text-center">
						    				<p class="font-weight-bold" style="font-size: .8em;">We've sent a confirmation code to the email provided.  Verify your code below</p>
						    				<div class="container">
						    					<input type="text" class="form-control form-control-sm clearDefault mt-2" id="confCode" name="confirmationID" placeholder="Enter Confirmation Code" value=""/> 
						    				</div>
						    			</div>
									    
									    <div class="container text-left d-none" id="accept_terms">
										    <h6 class="mt-4 mb-0">By clicking 'Create Profile' I agree that: </h6>
										    <div class="container">
											    <ul class="mt-0" style="font-size: 12px">
											    	<li>I have read and accepted the <a href="<?php echo URL;?>views/terms.php" target="_blank" class="text-gs">Terms of Use</a> and <a href="#" class="text-gs">Privacy Policy</a>, and <a href="https://stripe.com/connect-account/legal" target="_blank" class="text-gs"> Stripe Connected Account Agreement</a>.</li>
											    </ul>
											</div>
										</div>

										<div class="container mt-3">
											<div class="row text-center mt-3">
                                				<div class="col-5 mx-auto">
													<button type="button" class="btn btn-block btn-gs p-2" id="btn_checkCode" tabindex="3" style="font-size:13px" disabled>
														Confirm Code
					                                </button>

					                                <input type="submit" id="btn_submit" class="btn btn-sm btn-primary d-none" value="Create Profile" disabled>
					                            </div>
					                        </div>
										</div>
										<div id="confCodeError" class="container d-none"></div>
					      			</div>
						      	</div>
						    </div>
					    </div>
				    <!-- /Slide 3 -->
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
<script src="<?php echo URL;?>js/userJS.js?16"></script>
