<!--<!DOCTYPE html>-->
<?php 
	// require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php"); 
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php");
  exit;

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
											<input type="text" name="loginmaster[sEmailID]" id="your_email" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com" required>
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
											<input type="password" class="form-control" id="pwd" name="loginmaster[sPassword]" placeholder="Password" required>
										</fieldset>
									</div>
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Confirm Password</legend>
											<input type="password" class="form-control" id="conf-pwd" name="loginmaster[ConfsPassword]" placeholder="Confirm Password" required>
										</fieldset>
									</div>
								</div>
							</div>
			            </section>
						
						<!-- SECTION 1 -->
			            <h2>
						<?php var_dump($currentUserID); ?>
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

									<!-- <div class="form-row">
				                		<div class="form-holder form-holder-2 form-holder-3 bg-success">
				                			<input type="radio" class="radio bg-secondary" name="bank-1" id="bank-1" value="bank-1" checked>
				                			<label class="bank-images label-above bank-1-label bg-warning" for="bank-1">
				                				<img src="images/form-v1-1.png" alt="bank-1">
				                				Solo Artist
				                			</label>
											
				                		</div>
				                	</div>
				                	<div class="form-row">
				                		<div class="form-holder form-holder-2 form-holder-3 bg-danger">
				                			<input type="radio" class="radio" name="bank-4" id="bank-4" value="bank-4">
				                			<label class="bank-images bank-4-label" for="bank-4">
				                				<img src="images/form-v1-4.png" alt="bank-4">
				                				Group (Band, Dance Group, Singing Group, etc...)
				                			</label>
											
				                		</div>
				                	</div> -->
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
												</div>
											</div>
										</div>



				                	</div>
				                	<div class="form-row pl-md-5 pt-2">

					                	<!-- <div class="accordion accordion-flush" id="accordionFlushExample">

										  <div class="accordion-item">
										    <h3 class="accordion-header" id="flush-headingOne">
										      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
										        Accordion Item #1
										      </button>
										    </h3>
										    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
										      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
										    </div>
										  </div>
										  <div class="accordion-item">
										    <h3 class="accordion-header" id="flush-headingTwo">
										      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
										        Accordion Item #2
										      </button>
										    </h3>
										    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
										      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
										    </div>
										  </div>
										</div>
 										-->
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
			            	<span class="step-text">Verify Email Address</span>
			            </h2>
			            <section class="sect-2">
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Verify Email Address</h3>
									<p>Please check your email for verification code.</p>
								</div>
								<div class="form-row">
									<input type="text" class="form-control form-control-sm clearDefault mt-0 mb-4" name="verificationCode" placeholder="Verification Code" value=""/> 
								</div>
								<div class="text-danger text-center container" id="error-display"></div>
			                		<!-- <div class="form-holder form-holder-2">
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
			                		</div>-->
			                	<!-- </div> -->
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
	<script src="js/main.js?18"></script>

	<script src="<?php echo URL;?>js/jquery.validate.js"></script>
	<script src="<?php echo URL;?>js/additional-methods.js"></script>
	<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
	<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>