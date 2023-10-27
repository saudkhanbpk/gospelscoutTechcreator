<?
	/* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/adminDashboard/concept-master/include/adminNav.php');

    /* What profile type is being created */
    	$profType = trim($_GET['type']);

    /* todays date */
        $today = date_create();
        $today = date_format($today, "Y-m-d"); 

/*
Develop functionality to build user profiles from the administrator dashboard

// add 'managedBy' column in loginmaster table - indicates if profile is managed by user or admin - two value options
	//self
	//admin

// add 'create profile' dropdown in side menu that displays two options:
	//church
	//artist

//Create form page that will accept the user information to be stored in the database 
	//church: 
		Church Admin Info
			//name,email, password, conf password, security questions
			//All default to admin

		Church Info 
			//name, email, address, state, country, zip, denomination

		Pastor's Info
			//img, first & last name, birth date

	//artist:
		artist info:
			//first & last name, email, password, conf password, security questions, b-date
		
		artist location
			//state, zip, country

		artist's talent info
			//solo
				talent type
			//group
				group name

		additional info
			//profile pic
			//availability
			//years of experience

//Develop JS page to handle form submission via XMLHttpRequest

//Create PHP page to handle submission to correct tables 

//“managedBy” status will be display in “Profile Admin Info” Section on the “manageusers-church-details.php” page
//along with the “managedBy” status, a “Transition profile to user” button with be displayed

*/
// echo '<pre>';
// var_dump($_GET);
?>
	<style>
		.thumb {
			width: 100px;
			height: 100px;
			object-fit:cover; 
			object-position:0,0;
		}
		#thumb {
			box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);
			background-image: url("<?php echo URL; ?>img/dummy.jpg");
			background-size: 100px 100px;
			background-repeat:  no-repeat;
			background-position:  center;
			object-fit:cover; 
			object-position:0,0;
		}
	</style>
	<!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <?php $pageObjective = ($profType == 'church') ? 'Create Church Profile' : 'Create Artist Profile'; ?>
                            <h2 class="pageheader-title"><?php echo $pageObjective; ?></h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo URL; ?>adminDashboard/concept-master/index.php" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?php echo $pageObjective;?></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
               
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->

                <!-- Start profile form -->
                <form name="admnProfCreate" id="admnProfCreate" method="post" action="" enctype="multipart/form-data" autocomplete="off">

	                <?php if($profType == 'church') {?>
	                		<!-- ============================================================== -->
			                <!-- Church's General Info -->
			                <!-- ============================================================== -->
			                	<!-- hiddend inputs -->
			                		 <input type="hidden" name="loginmaster[sUserType]" value="church">

			                    <div class="row">
			                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
			                            <div class="card ">
			                                <h5 class="card-header">Church Info</h5>
							    				
			                                <div class="card-body">
			                                	<div class="error p-3 text-danger" style="font-weight: bold"><?php if($_POST && $errorMessage != ''){echo $errorMessage;}?></div>
			                                    <div class="container">
			                                        <!-- <h5>Church Info</h5> -->
			                                        <div class="row">
			                                        	<div class="col col-md-6">
			                                                <table class="table">
			                                                    <tbody>
			                                                    	<tr>
			                                                            <th scope="row">Church Name:</th>
			                                                            <td> <input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[sChurchName]" id="sChurchName" placeholder="Church Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sChurchName'];} ?>"/> </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Church Denomination: </th>
			                                                            <td>
			                                                                <select class="custom-select clearDefault my-0" name="usermaster[sDenomination]" id="denomination" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
																		       	<option value="">Denomination</option>
																			    <?php 
																			    /* Query the denominationmaster table */
																					$fetchDenoms = $db->query('SELECT denominationmaster.name FROM denominationmaster'); 
																					$denomList = $fetchDenoms->fetchAll(PDO::FETCH_ASSOC);

																					/* Reduce $denomList from a 2D to 1D array */
																					foreach($denomList as $denom) {
																						$denomList1D[] = ucfirst(str_replace("_","-",$denom['name']));
																					}
																					sort($denomList1D);
																			    	foreach($denomList1D as $singleDenom) {
																			    		//echo '<option value="' . $singleDeom . '">' . $singleDenom . '</option>';  
																			    ?>
																			    		<option value="<?php echo $singleDenom;?>" ><?php echo $singleDenom;?></option> 
																			    <?php
																			    	}
																			    ?>
																		    </select>
			                                                            </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Church Email: </th>
			                                                            <td><input type="email" class="form-control form-control-sm my-0" name="loginmaster[sEmailID]" id="sContactEmailID" placeholder="Church Email Address" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sContactEmailID'];} ?>"></td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Phone #: </th>
			                                                            <td>
			                                                                <input type="text" class="form-control form-control-sm my-0" name="usermaster[sContactNumber]" placeholder="Phone Number" value="<?php echo $userData['sContactNumber'];?>">
			                                                            </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Street Address: </th>
			                                                            <td><input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[sAddress]" id="sAddress" placeholder="Church's Street Address" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sAddress'];} ?>"/> </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Country: </th>
			                                                            <td>
			                                                            	 <select class="custom-select dropdown py-0 my-0"  name="usermaster[sCountryName]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
																		       	<option value="231">United States</option>
																		    </select>
																		</td>
			                                                        </tr>
			                                                         <tr>
			                                                         	<?php 
																	    	/* Fetch States */
																				$cond = 'country_id = 231'; 
																				$stateArray = $obj->fetchRowAll('states', $cond);
																			/* END - Fetch States */
																	    ?>
																	    <th scope="row">State: </th>
																	    <td>
																            <select class="custom-select dropdown py-0 my-0"  name="usermaster[sStateName]" id="sStateName" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
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
																	    </td>
			                                                        </tr>
			                                                         <tr>
			                                                            <th scope="row">Zip Code: </th>
			                                                            <td><input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[iZipcode]" id="iZipcode" placeholder="Zip Code" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iZipcode'];} ?>"/> </td>
			                                                        </tr>
			                                                    </tbody>
			                                                </table>
			                                            </div>
			                                            <div class="col col-md-6">
			                                                <table class="table">
			                                                    <tbody>
			                                                        <tr>
			                                                            <th scope="row">Pastor First Name:</th>
			                                                            <td> <input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[sPastorFirstName]" id="sPastorFirstName" placeholder="Pastor's First Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sPastorFirstName'];} ?>"/>  </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Pastor Last Name: </th>
			                                                            <td> <input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[sPastorLastName]" id="sPastorLastName" placeholder="Pastor's Last Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sPastorLastName'];} ?>"/> </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Pastor DOB: </th>
			                                                            <td>
			                                                            	<div class="input-group date dateTime-input my-0" id="datetimepicker1">
															               		<input type="text" autocomplete="off" class="form-control form-control-sm clearDefault mt-0" id="DOB" name="usermaster[dDOB]" placeholder="YYYY-MM-DD" value="<?php //if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['dDOB'];} ?>"/> 
																                <input type="hidden" name="todaysDate" value="<?php echo $today; ?>">
																                <span class="input-group-addon">
																                    <span class="glyphicon glyphicon-calendar"></span>
																                </span>
																            </div>
			                                                            </td>
			                                                        </tr>
			                                                        <tr>
			                                                            <?php 
			                                                                $from = new DateTime($userFound['dDOB']);
			                                                                $to   = new DateTime('today');
			                                                            ?>
			                                                            <th scope="row">Upload Pastor's Img: </th>
			                                                            <td>
				                                                            <div class="container">
										                                        <div class="row">
														    						<div class="col-12 col-md-3">
														    							<div class="" id="thumb" style="height:100px;width:100px;"></div>
														    						</div>
														    						<div class="col pl-md-5">
														    							<div class="custom-file mt-4">
																						  	<input type="file" class="custom-file-input" name="sProfileName" id="sProfileName">
																						  	<label class="custom-file-label bg-gray" style=" text-align:center" for="sProfileName">Browse</label>
																						</div>
														    						</div>
														    					</div>
														    				</div>
														    			</td>
			                                                        </tr>
			                                                        <tr>
			                                                            <th scope="row">Pastor Gender: </th>
			                                                            <td>
			                                                            	<select class="custom-select form-control-sm my-0" name="usermaster[sGender]">
																				<option value="">Gender</option>
																				<option value="male" <?php if($userData['sGender'] == 'male'){echo 'selected';}?> >Male</option>
																				<option value="female"  <?php if($userData['sGender'] == 'female'){echo 'selected';}?>  >Female</option>
																			</select>
			                                                            </td>
			                                                        </tr>
			                                                    </tbody>
			                                                </table>
			                                            </div>
			                                            
			                                        </div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                <!-- ============================================================== -->
			                <!-- END Church's General Info -->
			                <!-- ============================================================== -->
	                <?php }elseif($profType == 'artist'){?>

		                <!-- ============================================================== -->
		                <!-- Artist's General Info -->
		                <!-- ============================================================== -->
		               	<!-- hiddend inputs -->
			             <!-- <input type="hidden" name="sUserType" value="church"> -->

		                    <div class="row">
		                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
		                            <div class="card ">
		                            
		                                <h5 class="card-header">Artist Info</h5>
		                                <div class="error p-3 text-danger" style="font-weight: bold"><?php if($_POST && $errorMessage != ''){echo $errorMessage;}?></div>
		                                <div class="card-body">
		                                
		                                    <div class="container">
		                                        <div class="row">
		                                        
		                                            <div class="col col-md-6">
		                                                <table class="table">
									<tbody>
										<tr>
											<th scope="row">First Name:</th>
											<td><input type="text" class="form-control form-control-sm my-0 rule1" data-msg-required="Please enter a valid name" data-msg-minlength="Name must be at least 2 characters"  name="usermaster[sFirstName]" id="sFirstName" placeholder="First Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sFirstName'];} ?>"></td>
										</tr>
										<tr>
											<th scope="row">Last Name: </th>
											<td><input type="text" class="form-control form-control-sm my-0 rule1" data-msg-required="Please enter a valid name" data-msg-minlength="Name must be at least 2 characters" name="usermaster[sLastName]" id="sLastName" placeholder="Last Name" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['sLastName'];} ?>"></td>
										</tr>
										<tr>
											<?php 
												$dob = date_create($artistFound['dDOB']);
												$dob = date_format($dob, "m-d-Y"); 
											?>
											<th scope="row">DOB: </th>
											<td>
												<div class="input-group date dateTime-input my-0" id="datetimepicker1">
													<input type="text" autocomplete="off" class="form-control form-control-sm clearDefault mt-0" id="DOB" name="usermaster[dDOB]" placeholder="Brith Date" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['dDOB'];} ?>"/> 
													<input type="hidden" name="todaysDate" value="<?php echo $today; ?>">
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Gender: </th>
											<td>
												<select class="custom-select form-control-sm my-0" name="usermaster[sGender]" >
													<option value="">Gender</option>
													<option value="male" <?php if($userData['sGender'] == 'male'){echo 'selected';}?> >Male</option>
													<option value="female"  <?php if($userData['sGender'] == 'female'){echo 'selected';}?>  >Female</option>
												</select>
											</td>
										</tr>
										<tr>
											<th scope="row">Contact Email: </th>
											<td><input type="email" class="form-control form-control-sm my-0" data-msg-required="Please enter a valid email address" data-msg-email="Email is not valid" name="loginmaster[sEmailID]" id="sEmailID2" placeholder="Email Address" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['loginmaster']['sEmailID'];} ?>"></td>
										</tr>
										<tr>
											<th scope="row">Phone #: </th>
											<td>
												<input type="text" class="form-control form-control-sm my-0" name="usermaster[sContactNumber]" placeholder="Phone Number" value="<?php echo $userData['sContactNumber'];?>">
											</td>
										</tr>
									</tbody>
								</table>	
		                                            </div>
		                                            
								<div class="col col-md-6">
									<table class="table">
										<tbody>
											<tr>
												<th scope="row">Country: </th>
												<td>
													<select class="custom-select dropdown py-0 my-0"  name="usermaster[sCountryName]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
													<option value="231">United States</option>
													</select>
												</td>
											</tr>
											<tr>
												<?php 
												/* Fetch States */
												$cond = 'country_id = 231'; 
												$stateArray = $obj->fetchRowAll('states', $cond);
												/* END - Fetch States */
												?>
												
												<th scope="row">State: </th>
												<td>
													<select class="custom-select dropdown py-0 my-0"  name="usermaster[sStateName]" id="sStateName" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
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
												</td>
											</tr>
											<tr>
												<th scope="row">Zip Code: </th>
												<td><input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[iZipcode]" id="iZipcode" placeholder="Zip Code" value="<?php if($_POST && $errorCount > 0 ){echo $_POST['usermaster']['iZipcode'];} ?>"/> </td>
											</tr>
											<tr>
												<th scope="row">Availability: </th>
												<td>
													<select class="custom-select dropdown py-0 my-0"  name="usermaster[sAvailability]" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
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
												</td>
											</tr>
											
											<tr>
												<th scope="row">Experience: </th>
												<td>
													<input type="text" class="form-control form-control-sm clearDefault my-0" name="usermaster[iYearOfExp]" placeholder="Years of Experience" value=""/> 
												</td>
											</tr>
									
											<!-- ---------- -->
											
											<!-- ------------ -->
											
										</tbody>
									</table>
								</div>
		                                            
		                                            
		                                        </div>
		                                    </div>
		                                    
		                                </div>
		                                
		                            </div>
		                        </div>
		                    </div>
		                <!-- ============================================================== -->
		                <!-- END Artist's General Info -->
		                <!-- ============================================================== -->
	            	<?php } ?>
	            	<button type="submit">Create Profile</button>
	            </form>




		<!--<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
	    <script src="assets/vendor/custom-js/jquery.multi-select.html"></script>
	    <script src="assets/libs/js/main-js.js"></script>-->

	    <script>window.jQuery || document.write('<script src="https://dev.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    	<script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    	<script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>	

	    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
		<script src="<?php echo URL;?>js/additional-methods.js"></script>
		<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
		<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
	    <script src="<?php echo URL;?>js/jsFunctions.js"></script>
	    <script src="<?php echo URL;?>js/adminCreateProfile.js"></script>
	    <script>
	  //   	$(function () {
			// 	// var dat = $("input[name=todaysDate]").val();
	 	// 		$("#datetimepicker1").datetimepicker({
			// 	 	format: "YYYY-MM-DD",
			// 	 	defaultDate: false,
			// 	 	// maxDate: dat,
			// 	 	allowInputToggle: true
			// 	 });
			// });

	    </script>
	</body>
</html>