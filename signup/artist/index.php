<?php 
  	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php");

  	if($currentUserID != ''){
		if($currentUserType == 'artist' || $currentUserType == 'group'){
			echo '<script>window.location = "'. URL .'views/artistprofile.php";</script>';
			exit;
		}
		elseif($currentUserType == 'church'){
			echo '<script>window.location = "'. URL .'views/churchprofile.php";</script>';
			exit;
		}else{
			echo '<script>window.location = "'. URL .'artist";</script>';
			exit;
		}
	}
	// echo '<pre>';
	// var_dump($_POST);
?>
<html>
<head>
	<meta charset="utf-8">
	<title>GospelScout Sign Up</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css?7"/>
    <link rel="stylesheet" href="css/custom.css?1"/>
</head>
<body>
	<div class="page-content">
		<div class="form-v1-content">
			<div class="wizard-form ">
		        <form name="form-register" class="form-register" id="signup-form" action="#" method="post">
		        	<div id="form-total">
		        		
		        		<!-- SECTION 0 -->
			            <h2>
			            	<p class="step-icon"><span>1</span></p>
			            	<span class="step-text">Peronal Infomation</span>
			            </h2>
			            <section class="sect-0">
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Peronal Infomation</h3>
									<!-- <p>Please enter your infomation and proceed to the next step so we can build your accounts.  </p> -->
								</div>
								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>First Name</legend>
											<input type="text" class="form-control rule1" id="first-name" name="usermaster[sFirstName]" placeholder="First Name" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Last Name</legend>
											<input type="text" class="form-control rule1" id="last-name" name="usermaster[sLastName]" placeholder="Last Name" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Your Email</legend>
											<input type="text" name="loginmaster[sEmailID]" id="your_email" value="<?php if($_POST['sEmailID2'] != ''){echo $_POST['sEmailID2'];}?>" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com" required>
										</fieldset>
									</div>
								</div>
								<!-- <div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Phone Number</legend>
											<input type="text" class="form-control" id="phone" name="phone" placeholder="+1 888-999-7777" required>
										</fieldset>
									</div>
								</div> -->

								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										<label class="special-label">Birth Date:</label>
										<select name="usermaster[dDOB][month]" id="month">
											<option value="MM" disabled selected>MM</option>
											<?php for($i=1;$i<=12;$i++){
												echo '<option value="'.$i.'">'.$i.'</option>';
											} ?>
										</select>
										<select name="usermaster[dDOB][day]" id="date">
											<option value="DD" disabled selected>DD</option>
											<?php for($i=1;$i<=31;$i++){
												echo '<option value="'.$i.'">'.$i.'</option>';
											} ?>
										</select>
										<select name="usermaster[dDOB][year]" id="year">
											<option value="YYYY" disabled selected>YYYY</option>
											<?php for($i=1920;$i<=date("Y");$i++){
												echo '<option value="'.$i.'">'.$i.'</option>';
											} ?>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder ">
										<label class="special-label">Location:</label>
									 	<!-- Country -->
							            <select name="usermaster[sCountryName]" required><!-- style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" -->
									       	<option value="231">United States</option>
									    </select>
									     <!-- State -->
									     <?php 
									    	/* Fetch States */
												$cond = 'country_id = 231'; 
												$stateArray = $obj->fetchRowAll('states', $cond,$db);
												// echo '<pre>';
												// var_dump($stateArray);
											/* END - Fetch States */
									    ?>
							            <select class="mt-3" name="usermaster[sStateName]" id="sStateName"  required><!-- style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" -->
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
									    
									    <!-- <fieldset>
											<legend>Zip Code</legend> -->
										    <!-- Zip Code -->
										    <input type="text" class="form-control input-border" name="usermaster[iZipcode]" id="iZipcode" placeholder="Zip Code" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iZipcode'];} ?>"/>
										<!-- </fieldset> -->
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Password</legend>
											<input type="password" class="form-control" id="pwd" name="loginmaster[sPassword]" placeholder="Password" value="<?php if($_POST['sPassword2'] != ''){echo $_POST['sPassword2'];}?>" required>
										</fieldset>
									</div>
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Confirm Password</legend>
											<input type="password" class="form-control" id="conf-pwd" name="loginmaster[ConfsPassword]" placeholder="Confirm Password" value="<?php if($_POST['sConfPassword2'] != ''){echo $_POST['sConfPassword2'];}?>" required>
										</fieldset>
									</div>
								</div>
							</div>
			            </section>
						
						<!-- SECTION 1 -->
			            <h2>
			            	<p class="step-icon"><span>2</span></p>
			            	<span class="step-text">Select A Talent</span>
			            </h2>
			            <section class="sect-1">
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Select A Talent</h3>
									<p>Please specify whether you're a solo artist or group.</p>
								</div>
								
								<div class="form-row-total mt-0 pb-2" style="box-shadow: 0px 2px 5px #999;">
				                	<div class="form-row pl-md-5 pt-2">
				                		
				                		<div class="container p-0 my-0 mx-auto">
 											<div class="row m-0 p-0">
						                		<div class="col-1 pl-0">
		 											<input type="radio"  name="loginmaster[sUserType]" id="solo-type" class="solo-type u-type" value="artist">
		 										</div>
		 										<div class="col-8 pl-0">
													<h5 class="mb-0">Solo Artist</h5>
												</div>
											</div>

											<div class="row m-0 p-0 d-none" id="solo-row">
												<div class="col-10 pt-2">
													<!-- Select A talent -->
														<?php 
															/* Query DB for talent options */
													    		$cond = 'isActive = 1'; 
													       		$talentArray = $obj->fetchRowAll('giftmaster', $cond,$db);
													    ?>
											            <select class="custom-select dropdown py-0 mb-4" id="TalentID"  name="talentmaster[TalentID]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
													       	<option value="">Talent</option>
													       	<?php 

														    	foreach($talentArray as $evID => $talent) {
																	
														    		if($_POST && $errorCount > 0 ){
														    			if($talent['iGiftID'] == $_POST["talentmaster"]["TalentID"]){
														    				echo '<option selected value="' .$talent['iGiftID'] . '" >' . str_replace("_","/",$talent['sGiftName']) . '</option>'; 
														    			}
														    			else{
															    			echo '<option value="' .$talent['iGiftID'] . '" >' . str_replace("_","/",$talent['sGiftName']) . '</option>'; 
															    		}
														    		} 
														    		else{
														    			echo '<option value="' .$talent['iGiftID'] . '" >' . str_replace("_","/",$talent['sGiftName']) . '</option>'; 
														    		}
														    	}
														    ?>
													    </select> 
												</div>
											</div>
										</div>

                  </div>
                  <div class="form-row pl-md-5 pt-2 d-none">
 										<div class="container p-0 my-0 mx-auto">
 											<div class="row m-0 p-0">
		 										<div class="col-1 pl-0">
		 											<input type="radio" name="loginmaster[sUserType]" id="group-type" class="band-type u-type" value="group">
		 										</div>
		 										<div class="col-5 pl-0">
													<h5 class="mb-0">Group</h5>
												</div> 
											</div>
											<div class="row m-0 p-0">
												<div class="col-10 p-0 m-0">
													<span class="m-0" style="font-size:12px">(Bands, Dance groups, Singing groups, etc)</span>
												</div>
											</div>
											<div class="row m-0 p-0 d-none" id="group-row">
												<div class="col-10 pl-0 pt-2">
													<input type="text" id="sGroupName" class="form-control form-control-sm clearDefault mt-0 mb-4" name="usermaster[sGroupName]" placeholder="Group's Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sGroupName'];} ?>"/> 
												</div>
											</div>
										</div>
 										

									</div>
								</div>

							</div>
			            </section>

			            <!-- SECTION 2 -->
			            <h2>
			            	<p class="step-icon"><span>3</span></p>
			            	<span class="step-text">Profile Image</span>
			            </h2>
			            <section class="sect-2">
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Upload a Profile Image</h3>
                                    <p>.jpg, .png only <span class="text-danger">*</span></p>
								</div>
								<div class="form-row">
									<div class="container">
										<div class="row">
											<div class="col-12 col-md-3">
                        <!-- thumbnail container -->
                          <div class="container">
                            <div class="row">
                              <div class="col">
                                <div class="" id="thumb" style="height:100px;width:100px;"></div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col pt-3">
                                <div class="text-danger" id="thumb-error" style="height:100px;width:100px;font-size:.7em;font-weight:bold"></div>
                              </div>
                            </div>
                          </div>
                        <!-- /thumbnail container -->
											</div>
											<div class="col pl-md-5">
												<div class="custom-file mt-4">
													<input type="file" class="custom-file-input" onchange="thumbnailChange(event)" name="sProfileName" id="sProfileName">
													<label class="custom-file-label bg-gray" style=" text-align:left" for="sProfileName">image</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
			            </section>

						<!-- SECTION 3 -->
			            <h2>
			            	<p class="step-icon"><span>4</span></p>
			            	<span class="step-text">Verify Email Address</span>
			            </h2>
			            <section class="sect-3">
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Verify Email Address</h3>
									<p>Please check your email for verification code.</p>
								</div>
								<div class="form-row">
									<input type="text" class="form-control form-control-sm clearDefault mt-0 mb-4" name="verificationCode" placeholder="Verification Code" value=""/> 
								</div>
								<div class="text-danger text-center container" id="error-display"></div>
							</div>
			            </section>

			             <!-- SECTION 4 -->
			          <!--   <h2>
			            	<p class="step-icon"><span>04</span></p>
			            	<span class="step-text">Confirm Email</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Set Financial Goals</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your accounts.</p>
								</div>
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<input type="radio" class="radio" name="radio1" id="plan-1" value="plan-1">
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="images/form-v1-icon-2.png" alt="pay-1">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title">Specific Plan</span>
		                					<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat mauris nunc congue nisi.</p>
		                				</div>
			                			<input type="radio" class="radio" name="radio1" id="plan-2" value="plan-2">
			                			<label class="plan-icon plan-2-label" for="plan-2">
			                					<img src="images/form-v1-icon-2.png" alt="pay-1">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title">Medium Plan</span>
		                					<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat mauris nunc congue nisi.</p>
		                				</div>
										<input type="radio" class="radio" name="radio1" id="plan-3" value="plan-3" checked>
										<label class="plan-icon plan-3-label" for="plan-3">
		                					<img src="images/form-v1-icon-3.png" alt="pay-2">
										</label>
										<div class="plan-total">
		                					<span class="plan-title">Special Plan</span>
		                					<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat mauris nunc congue nisi.</p>
		                				</div>
			                		</div>
			                	</div>
							</div>
			            </section> -->

			             <!-- SECTION 5 -->
			      <!--       <h2>
			            	<p class="step-icon"><span>05</span></p>
			            	<span class="step-text">Set Financial Goals</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Set Financial Goals</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your accounts.</p>
								</div>
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<input type="radio" class="radio" name="radio1" id="plan-1" value="plan-1">
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="images/form-v1-icon-2.png" alt="pay-1">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title">Specific Plan</span>
		                					<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat mauris nunc congue nisi.</p>
		                				</div>
			                			<input type="radio" class="radio" name="radio1" id="plan-2" value="plan-2">
			                			<label class="plan-icon plan-2-label" for="plan-2">
			                					<img src="images/form-v1-icon-2.png" alt="pay-1">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title">Medium Plan</span>
		                					<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat mauris nunc congue nisi.</p>
		                				</div>
										<input type="radio" class="radio" name="radio1" id="plan-3" value="plan-3" checked>
										<label class="plan-icon plan-3-label" for="plan-3">
		                					<img src="images/form-v1-icon-3.png" alt="pay-2">
										</label>
										<div class="plan-total">
		                					<span class="plan-title">Special Plan</span>
		                					<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat mauris nunc congue nisi.</p>
		                				</div>
			                		</div>
			                	</div>
							</div>
			            </section> -->
		        	</div>
		        </form>
			</div>
		</div>
	</div>
	<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/footerNew.php");?>
	
	<script src="js/jquery.steps.js?1"></script>
	<script src="js/main.js?60"></script>

	<script src="<?php echo URL;?>js/jquery.validate.js"></script>
	<script src="<?php echo URL;?>js/additional-methods.js"></script>
	<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
	<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>