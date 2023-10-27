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
											<input type="text" name="loginmaster[sEmailID]" id="your_email" value="<?php if($_POST['sEmailID2'] != ''){echo $_POST['sEmailID2'];}?>" class="form-control"  pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com" required>
										</fieldset>
									</div>
								</div>

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
											/* END - Fetch States */
									    ?>
							            <select class="mt-3" name="usermaster[sStateName]" id="sStateName"  required>
									       	<option value="">State</option>
									       	<?php 
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
										    <input type="text" class="form-control input-border" name="usermaster[iZipcode]" id="iZipcode" placeholder="Zip Code" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iZipcode'];}else{echo '';} ?>"/>
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
									<input type="hidden"  name="loginmaster[sUserType]"  value="gen_user"><!--id="solo-type" class="solo-type u-type"-->
									<input type="text" class="form-control form-control-sm clearDefault mt-0 mb-4" name="verificationCode" placeholder="Verification Code" value=""/> 
								</div>
								<div class="text-danger text-center container" id="error-display"></div>
							</div>
			            </section>

		        	</div>
		        </form>
			</div>
		</div>
	</div>
	<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/footerNew.php");?>
	
	<script src="js/jquery.steps.js?1"></script>
	<script src="js/main.js?9"></script>

	<script src="<?php echo URL;?>js/jquery.validate.js"></script>
	<script src="<?php echo URL;?>js/additional-methods.js"></script>
	<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
	<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>