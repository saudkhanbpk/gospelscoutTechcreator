<?php 
	$backGround = 'bg2';

	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	/* Test For User Login */
		if($currentUserID == '' || $currentUserType != 'admin'){
			echo '<script>window.location = "'. URL .'newHomePage/sindex.php";</script>';
		}
		else{
			/*echo '<pre>';
			var_dump($_GET);*/

			$user_id = trim(intval($_GET['id']));
			$user_type = trim($_GET['u_type']);
			// echo $user_id;

			/* Get Usermaster data */
				$userData = $obj->fetchRow('usermaster', 'iLoginID = ' . $user_id);

			/* Get Log In Email */
				$loginData = $obj->fetchRow('loginmaster', 'iLoginID = ' . $user_id);

			if($user_type == 'church'){
				
				/* Get Ministry List */
					$getAllMinistries = $obj->fetchRowAll('giftmaster1', 'isActive=1');
					$getMinQuery = 'SELECT * 
									FROM churchministrymaster2
									INNER JOIN giftmaster1 on churchministrymaster2.iGiftID = giftmaster1.iGiftID
									WHERE iLoginID = ?';
					try{
						$getMinistries = $db->prepare($getMinQuery);
						$getMinistries->bindParam(1, $user_id);
						$getMinistries->execute(); 
					}
					catch(Exeption $e){	
						echo $e; 
					}
					$getMin = $getMinistries->fetchAll(PDO::FETCH_ASSOC);

				/* Get the 2nd ministry table */
					$getAllMinistries2 = $obj->fetchRowAll('churchministrymaster', 'iLoginID=' . $user_id);
					/*echo '<pre>';
					var_dump($getMin);
					var_dump($getAllMinistries2);*/

				/* Get Amenity List */
					$getAllAmenities = $obj->fetchRowAll('amenitimaster', 'isActive=1');
					$getAmenities = $obj->fetchRowAll('churchamenitymaster2', 'iLoginID=' . $user_id);
					
				/* Get Denominations */
					$getDenominations = $obj->fetchRowAll('denominationmaster', 'isActive=1');

				/* Get Service Times */
					$getServTimes = $obj->fetchRowAll('churchtimeing', 'iLoginID = ' . $user_id);
			}
			elseif($user_type == 'artist'){

				/* Get the Talent List */  
					if($user_type == 'artist'){
						$getTalents = $obj->fetchRowAll('talentmaster', 'iLoginID = ' . $user_id);
						$getAllTalents = $obj->fetchRowAll('giftmaster', 'isActive = 1');
					}
			}
			elseif($user_type == 'group'){
				$getMembers = $obj->fetchRowAll('groupmembersmaster', 'groupiLoginID = ' . $user_id);
				$getAllTalents = $obj->fetchRowAll('giftmaster', 'isActive = 1');
				$getGroupTypes = $obj->fetchRowAll('grouptypemaster', 'isActive = 1');
			}

			/* Get Location Info */
				$getAllStates = $obj->fetchRowAll('states', 'country_id = 231');
				$getCity = $obj->fetchRow('cities', 'id = ' . $userData['sCityName']);

?>
			<input type="hidden" name="userID" value="<?php echo $user_id;?>">
			<div class="container bg-white mt-5 p-4" style="max-width: 900px;min-height:400px">
				<div class="container text-center">
					<h4 class="text-gs">Edit Profile</h4>
				</div>

				<div class="container mt-3">
					<h6><a class="text-gs font-weight-bold" href="<?php echo URL;?>newHomePage/adminDashboard/concept-master/manageusers-<?php if($user_type == 'artist' || $user_type == 'group'){echo 'artists';}else{echo $user_type;}?>-details.php?u_ID=<?php echo $user_id;?>"><- Admin Page</a></h6>
				</div>				
				<!-- Personal Info Form -->
					<div class="container mt-4"> <!-- common section -->
						<form name="personalInfo" class="needs-validation" table="usermaster" novalidate>
							<input type="hidden" name="table" value="usermaster">
							<input type="hidden" name="u_type" value="<?php echo $user_type;?>">
							<input type="hidden" name="iLoginID" value="<?php echo $user_id;?>">
							
							<h5 class="text-gs"><?php if($user_type == 'church'){echo 'Admin';}elseif($user_type == 'artist'){ echo 'Personal';}elseif($user_type == 'group'){ echo 'Group Admin';} ?> Information</h5>
							<div class="row pl-2">
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">First Name</label>
									<input type="text" class="form-control form-control-sm mb-2" name="sFirstName" placeholder="First Name" value="<?php echo $userData['sFirstName'];?>" required>
									<div class="invalid-feedback">
							          Please enter your Firstname.
							        </div>
							    </div>

							    <div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Last Name</label>
									<input type="text" class="form-control form-control-sm mb-2" name="sLastName" placeholder="Last Name" value="<?php echo $userData['sLastName'];?>" required>
									<div class="invalid-feedback">
							          Please enter your lastname.
							        </div>
							    </div>

							    <div class="col-10 col-md-7">
									<?php if($user_type == 'artist'){ ?>
										<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Birth Date</label>
										<div class="input-group date dateTime-input mb-2" id="datetimepicker1">
											<?php 
							                	$today = date_create($userData['dDOB']);
											    $today = date_format($today, "Y-m-d"); 
							                ?>
						               		<input type="text" class="form-control form-control-sm clearDefault" name="dDOB" placeholder="Birth Date" value="<?php echo $userData['dDOB'];?>" required/> 
							                <!-- <input type="hidden" name="todaysDate" value="<?php echo $today; ?>"> -->
							                <span class="input-group-addon">
							                    <span class="glyphicon glyphicon-calendar"></span>
							                </span>
							            </div>
							            <div class="invalid-feedback">
								          Please enter your Birth Date.
								        </div>
						            <?php } ?>
						        </div>

							    <?php if($user_type == 'artist'){ ?>
							        <div class="col-10 col-md-7">
							            <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Gender</label>
							            <select class="custom-select form-control-sm mb-2" name="sGender" required>
											<option value="">Gender</option>
											<option value="male" <?php if($userData['sGender'] == 'male'){echo 'selected';}?> >Male</option>
											<option value="female"  <?php if($userData['sGender'] == 'female'){echo 'selected';}?>  >Female</option>
										</select>
										<div class="invalid-feedback">
								          Please select your gender.
								        </div>
									</div>
								<!-- </div> -->

								
									<!-- <div class="row pl-2"> -->
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Profile Image</label>
											<input type="file" class="form-control form-control-sm mb-2" name="sProfileName" placeholder="Pastor Profile Image" value="<?php echo $userData['sProfileName'];?>">
										</div>
										<div class="col-7 col-md-3">
											<img class="artist-vid-img" src="<?php if( $userData['sProfileName'] ==''){echo URL. 'newHomePage/img/gsStickerBig1.png';}else{echo $userData['sProfileName'];}?>" height="80px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
										</div>
									<!-- </div> -->
								<?php }?>
							</div>

							<div class="row">
								<div class="col pl-4 mt-2">
									 <button type="submit" class="btn btn-gs btn-sm" table="usermaster" formId="personalInfo">Save Changes</button>
								</div>
							</div>
						</form>
						<hr class="mt-4"> <!-- Page Divider -->
					</div>
					
				<!-- /Personal Info Form -->

				<!-- Login Info Form -->	
					<div class="container mt-3"> <!-- Common Section -->
						<form name="loginInfo" class="needs-validation" autocomplete="off" novalidate>	
							<input type="hidden" name="table" value="loginmaster">
							<h5 class="text-gs">Login Information</h5>
							<div class="row pl-2">
								
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Login Email</label>
									<input type="email" class="form-control form-control-sm mb-2" name="sEmailID" placeholder="Email Address" value="<?php echo $loginData['sEmailID'];?>" required>
									<div class="invalid-feedback">
							          Your email address is required.
							        </div>
								</div>

								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Update Your Password</label>
									<!-- <div id="hideCurrentPword">
										<input type="password" class="form-control form-control-sm mb-1" name="sCurrentPassword" placeholder="Enter Current Password" value="" required>
										<div id="noPass" class="d-none mb-2" style="font-size:13px"></div>
								        <button type="button" onclick="checkPword()" class="btn-sm btn-gs">Change</button>
								    </div> -->
								</div>
							
								<!-- <div class="d-none" id="newPwrds"> -->
									<div class="col-10 col-md-7 newPwrds">
										<input type="password" class="form-control form-control-sm my-2" name="sPassword" placeholder="New Password" value="" required><!-- Remember MD5 Hash-->
										<div class="invalid-feedback">
								          Please enter a new password.
								        </div>
									</div>
									<div class="col-10 col-md-7 newPwrds">
										<input type="password" class="form-control form-control-sm my-2" name="sConfPassword" placeholder="Confirm Password" value="" required><!-- Remember MD5 Hash-->
										<div class="invalid-feedback">
								          Please confirm your new password.
								        </div>
									</div>
								<!-- </div> -->
								<input type="hidden" name="sUserType" value="<?php echo $user_type; ?>">
							</div>
							<div class="row">
								<div class="col pl-4 mt-2">
									 <button type="submit" table="loginmaster" class="btn btn-gs btn-sm" formId="loginInfo">Save Changes</button>
									 <!-- 
									 	1. WHEN BUTTON IS CLICKED, AN EMAIL W/ CONF NUMBER WILL BE SENT TO USER 
									 	2. USER WILL NEED TO INPUT CONF NUMBER IN LIGHT BOX MODAL
									 	3. IF CONF NUMBER MATCHES USER'S NEW PASSWORD WILL BE PASSED TO THE UPDATE PAGE
									 	4. LOGINMASTER TABLE WILL BE UPDATED
									 -->

								</div>
							</div>
						</form>
						<hr class="mt-4"> <!-- Page Divider -->
					</div>
				<!-- /Login Info Form -->

					<?php 
						if($user_type == 'church') {
					?>
							<div class="container mt-3"> <!-- Common Section -->	<input type="hidden" name="table" value="">
								<form name="churchInfo" class="needs-validation" novalidate>
									<input type="hidden" name="table" value="usermaster">
									<h5 class="text-gs">Church Information</h5>
									<div class="row pl-2">
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Church Name</label>
											<input type="text" class="form-control form-control-sm mb-2" name="sChurchName" placeholder="Name of Church" value="<?php echo $userData['sChurchName'];?>"required>
											<div class="invalid-feedback">
									          Please enter your church name.
									        </div>
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Pastor First Name</label>
											<input type="text" class="form-control form-control-sm mb-2" name="sPastorFirstName" placeholder="Pastor's First Name" value="<?php echo $userData['sPastorFirstName'];?>"required>
											<div class="invalid-feedback">
									          Please enter the pastor's first name.
									        </div>
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Pastor Last Name</label>
											<input type="text" class="form-control form-control-sm mb-2" name="sPastorLastName" placeholder="Pastor's Last Name" value="<?php echo $userData['sPastorLastName'];?>"required>
											<div class="invalid-feedback">
									          Please enter the pastor's last name.
									        </div>
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Pastor's Birth Date</label>
											<div class="input-group date dateTime-input mb-2" id="datetimepicker1">
												<?php 
								                	$today = date_create($userData['dDOB']);
												    $today = date_format($today, "Y-m-d"); 
								                ?>
							               		<input type="text" class="form-control form-control-sm clearDefault" name="dDOB" placeholder="Pastor's Birth Date" value="<?php echo $userData['dDOB'];?>"required/> 
							               		<div class="invalid-feedback">
										          Please enter the pastor's birth date.
										        </div>
								                <!-- <input type="hidden" name="todaysDate" value="<?php echo $today; ?>"> -->
								                <span class="input-group-addon">
								                    <span class="glyphicon glyphicon-calendar"></span>
								                </span>
								            </div>
								        </div>
								        <div class="col-10 col-md-7">
								            <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Pastor's Gender</label>
								            <select class="custom-select form-control-sm mb-2" name="sGender" required>
												<option value="">Gender</option>
												<option value="male" <?php if($userData['sGender'] == 'male'){echo 'selected';}?> >Male</option>
												<option value="female"  <?php if($userData['sGender'] == 'female'){echo 'selected';}?>  >Female</option>
											</select>
											<div class="invalid-feedback">
									          Please select your gender.
									        </div>
										</div>
								        <div class="col-10 col-md-7">
								            <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Founding Pastor</label>
											<input type="text" class="form-control form-control-sm mb-2" name="sFounderName" placeholder="Founding Pastor" value="<?php echo $userData['sFounderName'];?>">
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Year Founded</label>
											<input type="text" class="form-control form-control-sm mb-2" name="sYearFounded" placeholder="Year Founded" value="<?php echo $userData['sYearFounded'];?>">
										</div>
									</div>
									<div class="row pl-2">
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Pastor Profile Image</label>
											<input type="file" class="form-control form-control-sm mb-2" name="sProfileName" placeholder="Pastor Profile Image" value="<?php echo $userData['sProfileName'];?>">
											<input type="hidden" name="u_type" value="<?php echo $user_type;?>">
										</div>
										<div class="col-7 col-md-3">
											<img class="artist-vid-img" src="<?php if( $userData['sProfileName'] ==''){echo URL. 'newHomePage/img/gsStickerBig1.png';}else{echo $userData['sProfileName'];}?>" height="80px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
										</div>
									</div>
									<div class="row pl-2">
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Denomination</label>
											<!-- <input type="text" class="form-control form-control-sm mb-2" name="sDenomination" placeholder="Denomination" value="<?php echo $userData['sDenomination'];?>"> -->
											<select class="custom-select form-control-sm mb-2" name="sDenomination">
												<option value="">Denomination</option>
												<?php 
													foreach($getDenominations as $denomination){
														if($denomination['name'] == strtolower($userData['sDenomination'])){

															echo '<option selected value="' . $denomination['name'] . '">' . $denomination['name'] . '</option>';
														}
														else{
															echo '<option value="' . $denomination['name'] . '">' . $denomination['name'] . '</option>';
														}
													}
												?>
											</select>
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Approx. # of Members</label>
											<input type="text" class="form-control form-control-sm mb-2" name="iNumberMembers" placeholder="Number of Members" value="<?php echo $userData['iNumberMembers'];?>">
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Church Website</label>
											<input type="text" class="form-control form-control-sm mb-2" name="sChurchUrl" placeholder="Website" value="<?php echo $userData['sChurchUrl'];?>">
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Mission Statement</label>
											<textarea class="form-control mb-2" name="sMission" placeholder="Mission Statement" wrap="" rows="5" aria-label="With textarea" value="<?php echo $userData['sMission'];?>"><?php echo $userData['sMission'];?></textarea>
										</div>

											<!-- Service Hours -->
									</div>
									<div class="row">
										<div class="col pl-4 mt-2">
											 <button type="submit" class="btn btn-gs btn-sm" table="usermaster" formId="churchInfo">Save Changes</button>
										</div>
									</div>
								</form>
								<hr class="mt-4"> <!-- Page Divider -->
							</div>

							<!-- Service Time Info Form -->	
								<div class="container mt-3"> <!-- Common Section -->	
									<h5 class="text-gs">Service Times</h5>
									<!-- Remove a current service time -->
										<div class="container">
											<form name="delServTime" class="needs-validation" novalidate>
												<input type="hidden" name="table" value="churchtimeing">
												<h6>Remove Service Times</h6>
												<div class="row pl-2 ml-1">
							                        <div class="form-check border py-2 col col-md-4" style="max-height: 150px;overflow:scroll; font-size: 15px" >
											    		<?php 
											    			$i = 0; 
											    			foreach($getServTimes as $servTime){ 
											                	$time = date_create($servTime['serviceTime']);
															    $newtime = date_format($time, 'g:ia');
											    		?>
												    		<div class="ml-3"> <!--  -->
														    	 <input class="form-check-input ministries" name="removeServTime[]" type="checkbox"  value="<?php echo $servTime['iTimeID'];?>" id="servTimeCheck<?php echo $i;?>">
																 <label class="form-check-label" for="ministryCheck<?php echo $i;?>">
																   <?php echo str_replace("_","/",$servTime['sTitle']) . ' ' .  $newtime;?>
																 </label>
															</div>
														<?php 
																$i += 1; 
															} 
														?>
											  		</div>
												</div>
												<div class="row">
													<div class="col pl-4 mt-2">
														 <button type="submit" class="btn btn-gs btn-sm" formId="delServTime">Remove Service Time</button>
														 <!-- <a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#removeMinistry" href="#" style="font-size:13px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 3px">Remove Service Time</a> -->
													</div>
												</div>
											</form>
										</div>
									<!-- /Remove a current service time -->

									<!-- Add a new service time -->
										<div class="container mt-3">
											<form name="addServTime" class="needs-validation" novalidate>
												<input type="hidden" name="table" value="churchtimeing">
												<h6>Add A Service Time</h6>
												<div class="row">
													<div class="col col-md-5">
														<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Select day of the week</label>
														<select class="custom-select form-control-sm my-2 py-1" name="sTitle" required>
															<option value="">Week Day</option>
															<option value="Sunday">Sunday</option>
															<option value="Monday">Monday</option>
															<option value="Tuesday">Tuesday</option>
															<option value="Wednesday">Wednesday</option>
															<option value="Thursday">Thursday</option>
															<option value="Friday">Friday</option>
															<option value="Saturday">Saturday</option>
														</select>
														<div class="invalid-feedback">
												          Please select a new day.
												        </div>
													</div>
												</div>
												<div class="row">
													<div class="col col-md-5">
														<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Select a time</label>
														<div class="input-group date dateTime-input mb-2" id="datetimepicker2">
										               		<input type="text" class="form-control form-control-sm clearDefault" name="serviceTime" placeholder="Service Time" value=""required/> 
										               		<div class="invalid-feedback">
													          Please enter a service time.
													        </div>
											                <!-- <input type="hidden" name="todaysDate" value="<?php echo $today; ?>"> -->
											                <span class="input-group-addon">
											                    <span class="glyphicon glyphicon-time"></span>
											                </span>
											            </div>
											        </div>
												</div>
												<div class="row">
													<div class='col co-md-5'>
														 <button type="submit" table="churchministrymaster2" class="btn btn-gs btn-sm mt-2" formId="addMin">Add New Time</button>
													</div>
												</div>
											</form>
										</div>
									<!-- /Add a new service time -->	
									<hr class="mt-4"> <!-- Page Divider -->
								</div>
							<!-- /Service Time Info Form -->
					<?php
						}
					?>

				<!-- Contact Info Form -->
					<div class="container mt-3"> <!-- Common Section -->	
						<form name="contactInfo"  class="needs-validation" novalidate>
							<input type="hidden" name="table" value="usermaster">
							<h5 class="text-gs">Contact Information</h5>
							<div class="row pl-2">
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email Address</label>
									<input type="text" class="form-control form-control-sm mb-2" name="sContactEmailID" placeholder="Email Address" value="<?php echo $userData['sContactEmailID'];?>">
								</div>
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Phone Number</label>
									<input type="text" class="form-control form-control-sm mb-2" name="sContactNumber" placeholder="Phone Number" value="<?php echo $userData['sContactNumber'];?>">
								</div>
							</div>
							<div class="row">
								<div class="col pl-4 mt-2">
									 <button type="submit" class="btn btn-gs btn-sm" table="usermaster" formId="contactInfo">Save Changes</button>
								</div>
							</div>
						</form>
						<hr class="mt-4"> <!-- Page Divider -->
					</div>
				<!-- /Contact Info Form -->
	
				<!-- Location Form -->
					<div class="container mt-3"> <!-- Common Section -->	
						<form name="locationInfo" class="needs-validation" novalidate>
							<input type="hidden" name="table" value="usermaster">
							<h5 class="text-gs">Location</h5>
							<div class="row pl-2">
								<div class="col-10 col-md-6">
									<?php 
										if($user_type == 'church') {
											echo '<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Street Address</label>';
											echo '<input type="text" class="form-control form-control-sm mb-2" name="sAddress" placeholder="Street Address" value="' . $userData["sAddress"] . '" required>';
											echo '<div class="invalid-feedback">Please enter church address.</div>';
										}
									?>
								</div>
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">State</label>
									 <select class="custom-select form-control-sm mb-2" id="sStateName" name="sStateName" required>
									 	<option value="">State</option>
									 	<?php 
									 		foreach($getAllStates as $state){
									 			if($userData['sStateName'] == $state['id']){
									 				echo '<option selected value="' . $state['id'] . '" >' . $state['name'] . '</option>';
									 			}
									 			else{
													echo '<option value="' . $state['id'] . '" >' . $state['name'] . '</option>';
									 			}
									 		}
									 	?>
									</select>
									<div class="invalid-feedback">
							          Please select a state.
							        </div>
								</div>
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">City</label>
									<input type="text" class="form-control form-control-sm mb-2" id="sCityName" name="sCityName" placeholder="City" value="<?php echo $userData['sCityName'];?>" required>
									<div class="invalid-feedback">
							          Please enter a city.
							        </div>
								</div>
								<div class="col-10 col-md-7">
									<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zipcode</label>
									<input type="text" class="form-control form-control-sm mb-2" name="iZipcode" placeholder="Zipcode" value="<?php echo $userData['iZipcode'];?>" required>
									<div class="invalid-feedback">
							          Please enter a zipcode.
							        </div>
								</div>
							</div>
							<div class="row">
								<div class="col pl-4 mt-2">
									 <button type="submit" class="btn btn-gs btn-sm" table="usermaster" formId="locationInfo">Save Changes</button>
								</div>
							</div>
						</form>
						<hr class="mt-4"> <!-- Page Divider -->
					</div>
				<!-- /Location Form -->

				<!-- For Artists Only - Talent and bio Section -->
					<?php
						if($user_type == 'artist' || $user_type == 'group'){
							/* Add the Talent and Artist Bio Section */	
					?>
							<!-- Talent Form -->
									<div class="container mt-3"> <!-- Common Section -->	
										<h5 class="text-gs">
											<?php
												if($user_type == 'artist'){
													echo 'Talent';
												}
												elseif($user_type == 'group'){
													echo 'Member';
												}
											?>
											 Information
										</h5>

										<!-- Remove a Talent or Group Member -->
											<div class="container">
												<form name="talentRemove">
													<h6>
														<?php
															if($user_type == 'artist'){
																echo 'Remove a Talent';
															}
															elseif($user_type == 'group'){
																echo 'Remove a Member';
															}
														?>
													</h6>
													<div class="row pl-2">
								                        <div class="form-check py-2 col <?php if($user_type == 'artist'){echo 'col-md-4';}else{echo 'col-md-6';}?>" style="<?php if($user_type == 'artist'){echo 'max-height: 150px;overflow:scroll; font-size: 15px;border:1px solid rgba(0,0,0,.1)';}else{echo 'max-height: 250px;overflow:scroll';}?>" >
												    		<?php 
												    			if(count($getTalents) > 0){
													    			$i = 0; 
													    			foreach($getTalents as $talent){
												    		?>
														    		<div class="ml-3"> <!--  -->
																    	 <input class="form-check-input ministries" name="removeArtistTal[]" type="checkbox"  value="<?php echo $talent['TalentID'];?>" id="talentCheck<?php echo $i;?>">
																		 <label class="form-check-label" for="talentCheck<?php echo $i;?>">
																		   <?php echo str_replace("_","/",$talent['talent']);?>
																		 </label>
																	</div>
															<?php 
																		$i += 1; 
																	} 
																}
																elseif(count($getMembers) > 0){
															?>
																	<table class="table" style="font-size:12px;">
																		<thead>
																			<th>Remove</th>
																			<th>Name</th>
																			<th>Talent</th>
																			<th>Age</th>
																		</thead>

															<?php 
																		/* Loop through Band Members */
																		foreach($getMembers as $member){
																			/* Determine each member's age */
																				$from = new DateTime($member['dDOB']);
																				$to   = new DateTime('today');
																				$memberAge = $from->diff($to)->y;
																			/* END - Determine each member's age */

																			/* Get name of group member's talent */
																				foreach($getAllTalents as $talIndex => $Tal){
																					if($Tal['iGiftID'] == $member['talentID']){
																						$talentName = $Tal['sGiftName'];
																					}
																				}
																			/* END - Get name of group member's talent */

																			/* Truncate member's name if it's too long */
																				$nameLength = strlen(trim($member['sFirstName']));
																		  		if($nameLength>10) {
																		  			$artistName = $member['sFirstName']; 
																		  			$artistNameShort = substr_replace($artistName,'...',10); 
																		  			$artistName = $artistNameShort; 
																		  		}
																		  		else{
																		  			$artistName = $member['sFirstName'];
																		  		}
																		  	/* END - Truncate member's name if it's too long */
															?>
																			<tr>
																				<td class='pl-3'>
																					<input class=" " name="removeMember[]" type="checkbox"  value="<?php echo $member['id'];?>">
																				</td>
																				<td><?php echo $artistName;?></td>
																				<td><?php echo str_replace("_","/",$talentName);?></td>
																				<td><?php echo $memberAge;?></td>
																			</tr>
															<?php
																		}
																		/*id="talentCheck<?php echo $i;?>"*/
															?>
																	</table>
															<?php
																}
															?>
											  			</div>
											  			<div class="d-none">
											  				<?php 
											  					if($user_type == 'artist'){
											  						echo 'Please select at least one talent.';
											  					}
											  					elseif($user_type == 'group'){
											  						echo 'Please select at least one group member.';
											  					}
											  				?>
												        </div>
													</div>
													<div class="row">
														<div class="col pl-4 mt-2">
															 <!-- <button type="submit" class="btn btn-gs btn-sm sectionEdit" table="talentmaster" formId="talentRemove">Delete Talent(s)</button> -->
															 <?php
																if($user_type == 'artist'){
																	echo ' <a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#removeTalentWarning" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Remove Talent(s)</a>';
																}
																elseif($user_type == 'group'){
																	echo ' <a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#removeMemberWarning" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Remove Member(s)</a>';
																}
															?>
														</div>
													</div>
												</form>
											</div>
										<!-- /Remove a Talent or Group Member -->

										<!-- Add a Talent or Group Member -->
											<div class="container mt-3">
												<form name="<?php if($user_type == 'group'){echo 'MemberAdd';}elseif($user_type == 'artist'){echo 'talentAdd';}?>" class="needs-validation" novalidate>
													<input type="hidden" name="table" value="<?php if($user_type == 'group'){echo 'groupmembersmaster';}elseif($user_type == 'artist'){echo 'talentmaster';}?>">
													<h6>
														<?php
															if($user_type == 'artist'){
																echo 'Add A Talent';
															}
															elseif($user_type == 'group'){
																echo 'Add New Member';
															}
														?>
													</h6>
													<div class="row">
														<?php if($user_type == 'artist'){?>
															<div class="col col-md-5">
																<select class="custom-select form-control-sm my-2 py-1" name="addArtistTal" required>
																	<option value="">New Talent</option>
																	<?php 
																		foreach($getAllTalents as $tal){
																			echo '<option value="' . $tal['iGiftID'] . '">' . $tal['sGiftName'] . '</option>';
																		}
																	?>
																</select>
																<div class="invalid-feedback">
														          Please select a new talent.
														        </div>
															</div>
															<div class='col co-md-5'>
																 <button type="submit" class="btn btn-gs btn-sm mt-2" table="talentmaster" formId="talentAdd">Add Talent</button>
															</div>	
														<?php }
															  elseif($user_type == 'group'){
														?>
															<!-- Add New Group Members -->
																<div class="container">
																	<div class="row">
																		<div class="col col-md-5">
																			<select class="custom-select form-control-sm my-2 py-1" name="talentID" required>
																				<option value="">New Talent</option>
																				<?php 
																					foreach($getAllTalents as $tal){
																						echo '<option value="' . $tal['iGiftID'] . '">' .  str_replace("_","/",$tal['sGiftName']) . '</option>';
																					}
																				?>
																			</select>
																			<div class="invalid-feedback">
																	          Please select a new talent.
																	        </div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col col-md-5">
																			<input type="text" class="form-control form-control-sm mb-2" name="sFirstName" placeholder="First Name" value="" required>
																			<div class="invalid-feedback">
																	          Please enter your Firstname.
																	        </div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col col-md-5">
																			<input type="text" class="form-control form-control-sm mb-2" name="sLastName" placeholder="Last Name" value="" required>
																			<div class="invalid-feedback">
																	          Please enter your Lastname.
																	        </div>
																		</div>
																	</div>

																	<div class="row">
																		<div class="col col-md-5">
																			<div class="input-group date dateTime-input" id="datetimepicker3">
																                <input type="text" class="form-control form-control-sm" name="dDOB" placeholder="Birth Date" value=""/> 
																                <?php 
																                	$today = date_create(date());
																				    $today = date_format($today, "Y-m-d"); 
																                ?>
																                <input type="hidden" name="todaysDate" value="<?php echo $today; ?>">
																                <span class="input-group-addon">
																                    <span class="glyphicon glyphicon-calendar"></span>
																                </span>
																            </div>
																        </div>
																    </div>
																</div>
																<div class='col co-md-5'>
																	 <button type="submit" class="btn btn-gs btn-sm mt-2" table="groupmembersmaster" formId="memberAdd">Add Member</button>
																</div>	
															<!-- /Add New Group Members -->
														<?php
															  }
														 ?>
													</div>
												</form>
											</div>
											<hr class="mt-4"> <!-- Page Divider -->
										</div>
									<!-- /Add a Talent or Group Member -->
							<!-- /Talent Form -->

							<!-- Modal Display - Talent Removal Warning -->
								<div class="modal fade" id="removeTalentWarning" tabindex="-1" role="dialog" aria-labelledby="removeTalentWarning" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered" role="document">
								    <div class="modal-content">
										<!-- Add New Photo Button -->
										    <div class="modal-header">
										        <h5 class="modal-title" id="exampleModalLongTitle">Remove Talents</h5>
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										        	<span aria-hidden="true">&times;</span>
										        </button>
										    </div>
									    <!-- /Add New Photo Button -->

									      	<div class="modal-body">
										    	<div class="form-group">
										    		<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>
										    		<p>Removing a talent from your profile will automatically remove any videos associated with that talent. </p>
												</div>
									      	</div>
									      	
									      	<div class="modal-footer">
									        	<button type="submit" class="btn btn-gs btn-sm sectionEdit" table="talentmaster" formId="talentRemove">Delete Talent(s)</button>
									      	</div>
								    </div>
								  </div>
								</div>
							<!-- /Modal Display - Talent Removal Warning -->

							<!-- Modal Display - Member Removal Warning -->
								<div class="modal fade" id="removeMemberWarning" tabindex="-1" role="dialog" aria-labelledby="removeMemberWarning" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered" role="document">
								    <div class="modal-content">
										<!-- Close Modal Button -->
										    <div class="modal-header">
										        <h5 class="modal-title" id="exampleModalLongTitle">Remove Group Member</h5>
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										        	<span aria-hidden="true">&times;</span>
										        </button>
										    </div>
									    <!-- /Close Modal Button -->

									      	<div class="modal-body">
										    	<div class="form-group">
										    		<!-- <h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6> -->
										    		<p>Confirm Group Member Removal?</p>
												</div>
									      	</div>
									      	
									      	<div class="modal-footer">
									        	<button type="submit" class="btn btn-gs btn-sm sectionEdit" table="groupmembersmaster" formId="talentRemove">Remove Member(s)</button>
									      	</div>
								    </div>
								  </div>
								</div>
							<!-- /Modal Display - Member Removal Warning -->

							<!-- Bio Form -->
								<div class="container mt-3"> <!-- Common Section -->	
									<form name="bioInfo" class="needs-validation" novalidate>
										<input type="hidden" name="table" value="usermaster">
										<h5 class="text-gs">Bio Information</h5>
										
										<!-- Hourly Rate -->
											<div class="row pl-2">
												<div class="col col-md-5">
													<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Hourly Rate</label>
													<input type="text" class="form-control form-control-sm my-2" name="playRate" placeholder="$0.00" value="<?php if($userData['playRate'] != '0.0'){echo $userData['playRate'];}?>" style="display:inline;max-width:70px;"><span> /hr.</span>
												</div>
											</div>
										<!-- /Hourly Rate -->

										<!-- Minimum Pay -->
											<div class="row pl-2">
												<div class="col col-md-5">
													<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Minimum Pay</label>
													<input type="text" class="form-control form-control-sm my-2" name="minPay" placeholder="$0.00" value="<?php if($userData['minPay'] != '0.0'){echo $userData['minPay'];}?>" style="display:inline;max-width:70px;">
												</div>
											</div>
										<!-- /Minimum Pay -->

										<!-- Maximum Travel Distance -->
											<div class="row pl-2">
												<div class="col col-md-5">
													<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Maximum Travel Distance</label>
													<input type="text" class="form-control form-control-sm my-2" name="maxTravDistance" placeholder="# of Miles" value="<?php if($userData['maxTravDistance'] != '0.0'){echo $userData['maxTravDistance'];}?>" style="display:inline;max-width:150px;"><span> miles</span>
												</div>
											</div>
										<!-- /Maximum Travel Distance -->

										<?php if($user_type == 'group'){?>
											<div class="row pl-2">
												<div class="col col-md-5">
													<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Group Type</label>
													<select class="custom-select form-control-sm my-2 py-1" name="sGroupType">
														<option value="">Group Type</option>
														<option value='0'>N/A</option>
															<?php foreach($getGroupTypes as $groupTypeIndex => $groupType){
																if($userData['sGroupType'] == $groupType['id']){
																	echo '<option selected value="' . $groupType['id'] . '">' . str_replace("_","/",$groupType['sTypeName']) . '</option>';
																}
																else{
																	echo '<option value="' . $groupType['id'] . '">' . str_replace("_","/",$groupType['sTypeName']) . '</option>';
																}
															}?>
													</select>
													<div class="invalid-feedback">
											          Please select an availability option.
											        </div>
												</div>
											</div>
										<?php }?>
										<div class="row pl-2">
											<div class="col col-md-5">
												<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Availability</label>
												<select class="custom-select form-control-sm my-2 py-1" name="sAvailability" required>
													<option value="">Availability</option>
														<option <?php if($userData['sAvailability'] == 'Currently Gigging(Not excepting new gigs)'){echo 'selected';} ?> value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
												        <option  <?php if($userData['sAvailability'] == 'Looking For Gigs(Currently excepting new gigs)'){echo 'selected';} ?> value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
												        <option  <?php if($userData['sAvailability'] == 'Will Play For Food (Just Cover my cost to get there and back)'){echo 'selected';} ?> value="Will Play For Food (Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
												        <option  <?php if($userData['sAvailability'] == 'Will Play For Free'){echo 'selected';} ?> value="Will Play For Free">Will Play for Free </option>
												</select>
												<div class="invalid-feedback">
										          Please select an availability option.
										        </div>
											</div>
										</div>
										<div class="row pl-2">
											<div class="col col-md-5">
												<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Years of Experience</label>
												<input type="text" class="form-control form-control-sm my-2" name="iYearOfExp" placeholder="Years Of Experience" value="<?php echo $userData['iYearOfExp'];?>"required>
												<div class="invalid-feedback">
										          Please enter your years of experience.
										        </div>
											</div>
										</div>
										<div class="row pl-2">
											<div class="col col-md-7">
												<label class="text-gs" style="font-size:12px;font-weight:bold" for="musicalInfluences">Musical Influences</label>
												<textarea class="form-control mb-2" id="musicalInfluences" name="sMusicalInstrument" placeholder="Musical Influences ..." wrap="" rows="5" aria-label="With textarea"><?php echo $userData['sMusicalInstrument'];?></textarea>
											</div>
										</div>
										<div class="row pl-2">
											<div class="col col-md-7">
												<label class="text-gs" style="font-size:12px;font-weight:bold" for="musicGenre">Music Genre</label>
												<textarea class="form-control mb-2" id="musicGenre" name="sKindPlay" placeholder="Genre(s) of Music You Play ..." wrap="" rows="5" aria-label="With textarea"><?php echo $userData['sKindPlay'];?></textarea>
											</div>
										</div>
										<div class="row pl-2">
											<div class="col col-md-7">
												<label class="text-gs" style="font-size:12px;font-weight:bold" for="musicExperience">Relevant Playing/Music Experience</label>
												<textarea class="form-control mb-2" id="musicExperience" name="sHavePlayed" placeholder="Relevant Music or Playing Experience ..." wrap="" rows="5" aria-label="With textarea"><?php echo $userData['sHavePlayed'];?></textarea>
											</div>
										</div>
										<div class='col co-md-5'>
											<button type="submit" class="btn btn-gs btn-sm mt-2" table="usermaster" formId="bioInfo">Save Changes</button>
										</div>
									</form>
									<hr class="mt-4"> <!-- Page Divider -->
								</div>
							<!-- /Bio Form -->
					<?php
						}
						elseif($user_type == 'church'){	
					?>
							<!-- Ministry Form -->
								<!-- Remove a new ministry -->
									<div class="container mt-3"> <!-- Common Section -->	
										<h5 class="text-gs">Ministries</h5>
										<div class="container">
											<?php 
											// var_dump($getAmenities);
												if(count($getMin) > 0){
											?>
											<form name="delMin">
												<h6>Delete A Ministry</h6>
												<div class="row pl-2">
							                        <div class="form-check border py-2 col col-md-4" style="max-height: 150px;overflow:scroll; font-size: 15px" >
											    		<?php 
											    			$i = 0; 
											    			foreach($getMin as $min){ 
											    		?>
												    		<div class="ml-3"> <!--  -->
														    	 <input class="form-check-input ministries" name="removeChurchMin[]" type="checkbox"  value="<?php echo $min['sGiftName'];?>" id="ministryCheck<?php echo $i;?>">
																 <label class="form-check-label" for="ministryCheck<?php echo $i;?>">
																   <?php echo str_replace("_","/",$min['sGiftName']);?>
																 </label>
															</div>
														<?php 
																$i += 1; 
															} 
														?>
											  		</div>
												</div>
												<div class="row">
													<div class="col pl-4 mt-2">
														 <!-- <button type="button" table="churchministrymaster2" class="btn btn-gs btn-sm sectionEdit" formId="delMin">Delete Ministry</button> -->
														 <a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#removeMinistry" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Remove Ministry</a>
													</div>
												</div>
											</form>
											<?php 
								  			}
								  			else{
								  				echo '<div class="container mt-1 text-left" id="bookme-choice"><h5 class="" style="color: rgba(204,204,204,1)">You Have No Ministries Listed.</h5></div>';            
								  			}
								  		?>
										</div>
									<!-- /Remove a new ministry -->

									<!-- Add a new ministry -->
										<div class="container mt-3">
											<form name="addMin" class="needs-validation" novalidate>
												<input type="hidden" name="table" value="churchministrymaster2">
												<!-- <input type="hidden" name="tableOne_min" value="churchministrymaster"> -->
												<h6>Add A Ministry</h6>
												<div class="row">
													<div class="col col-md-5">
														<select class="custom-select form-control-sm my-2 py-1" name="addChurchMin" required>
															<option value="">Ministry</option>
															<?php 
																foreach($getAllMinistries as $ministry){
																	echo '<option value="' . $ministry['iGiftID'] . '">' . str_replace("_","/",$ministry['sGiftName']) . '</option>';
																}
															?>
														</select>
														<div class="invalid-feedback">
												          Please select a new ministry.
												        </div>
													</div>
													<div class='col co-md-5'>
														 <button type="submit" table="churchministrymaster2" tableOne="churchministrymaster" class="btn btn-gs btn-sm mt-2" formId="addMin">Add Ministry</button>
													</div>
												</div>
											</form>
										</div>
										<hr class="mt-4"> <!-- Page Divider -->
									</div>
								<!-- /Add a new ministry -->

								<!-- Modal Display - Ministry Removal Warning -->
									<div class="modal fade" id="removeMinistry" tabindex="-1" role="dialog" aria-labelledby="addPhotoTitle" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-centered" role="document">
									    <div class="modal-content">
											<!-- Add New Photo Button -->
											    <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLongTitle">Remove Ministry</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											        	<span aria-hidden="true">&times;</span>
											        </button>
											    </div>
										    <!-- /Add New Photo Button -->

										      	<div class="modal-body">
											    	<div class="form-group">
											    		<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>
											    		<p>Removing a ministry from your profile will automatically remove any videos associated with that ministry. </p>
													</div>
										      	</div>
										      	
										      	<div class="modal-footer">
										        	<button type="submit" class="btn btn-gs btn-sm sectionEdit" data-dismiss="modal" table="churchministrymaster2" tableOne="churchministrymaster"  formId="delMin">Delete Ministry</button>
										      	</div>
									    </div>
									  </div>
									</div>
								<!-- /Modal Display to add new Photos -->
							<!-- /Ministry Form -->

							<!-- Amenity Form -->
								<div class="container mt-3"> <!-- Common Section -->	
									<h5 class="text-gs">Amenities</h5>
									<div class="container">
										<?php 
										// var_dump($getAmenities);
											if(count($getAmenities) > 0){
										?>
											<form id="delAmen">
												<h6>Delete An Amenity</h6>
												<div class="row pl-2">
							                        <div class="form-check border py-2 col col-md-4" style="max-height: 150px;overflow:scroll; font-size: 15px" >
											    		<?php 
											    			$i = 0; 
											    			foreach($getAmenities as $amenity){ 
											    		?>
												    		<div class="ml-3"> <!--  -->
														    	 <input class="form-check-input ministries" name="removeAmenity[]" type="checkbox"  value="<?php echo $amenity['amenityID'];?>" id="amenityCheck<?php echo $i;?>">
																 <label class="form-check-label" for="ministryCheck<?php echo $i;?>">
																   <?php echo $amenity['amenityName'];?>
																 </label>
															</div>
														<?php 
																$i += 1; 
															} 
														?>
											  		</div>
												</div>
												<div class="row">
													<div class="col pl-4 mt-2">
														 <button type="submit" table="churchamenitymaster2" class="btn btn-gs btn-sm sectionEdit" formId="delAmen">Delete Amenity</button>
													</div>
												</div>
											</form>
								  		<?php 
								  			}
								  			else{
								  				echo '<div class="container mt-1 text-left" id="bookme-choice"><h5 class="" style="color: rgba(204,204,204,1)">You Have No Amenities Listed.</h5></div>';            
								  			}
								  		?>
											
									</div>
									<div class="container mt-3">
										<form name="addAmen" class="needs-validation" novalidate>
											<input type="hidden" name="table" value="churchamenitymaster2">
											<h6>Add An Amenity</h6>
											<div class="row">
												<div class="col col-md-5">
													<select class="custom-select form-control-sm my-2 py-1" name="addAmenity" required>
														<option value="">Amenity</option>
														<?php 
															foreach($getAllAmenities as $amenity){
																echo '<option value="' . $amenity['iAmityID'] . '">' . str_replace("_","/",$amenity['sAmityName']) . '</option>';
															}
														?>
													</select>
													<div class="invalid-feedback">
											          Please select a new amenity.
											        </div>
												</div>
												<div class='col co-md-5'>
													 <button type="submit" table="churchamenitymaster2" class="btn btn-gs btn-sm mt-2" formId="addAmen">Add Amenity</button>
												</div>
											</div>
										</form>
									</div>
									<hr class="mt-4"> <!-- Page Divider -->
								</div>
							<!-- /Amenity Form -->
					<?php
						}
					?>
				<!-- /For Artists Only - Talent and bio Section -->
			</div>
<?php
		}
?>

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
	/* Date and Time Picker plugin JS */
		$(function () {
			var dat = $("input[name=todaysDate]").val();
 			$("#datetimepicker1").datetimepicker({
			 	format: "YYYY-MM-DD",
			 	defaultDate: false,
			 	minDate: dat,
			 	//minDate: moment(),
			 	maxDate: moment().add(1,'year'),
			 	//useCurrent: true, 
			 	allowInputToggle: true
			 });
 			$("#datetimepicker2").datetimepicker({
			 	 format: "LT",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
			});
			$("#datetimepicker3").datetimepicker({
			 	format: "YYYY-MM-DD",
			 	defaultDate: false,
			 	// minDate: dat,
			 	//minDate: moment(),
			 	maxDate: moment().add(1,'year'),
			 	//useCurrent: true, 
			 	allowInputToggle: true
			 });
		});
	/* END - Date and Time Picker plugin JS */

	/* Validate user's current password as part of a password update */
		function checkPword(){
			var currentPword = $('input[name=sCurrentPassword]').val();
			var userID = $('input[name=userID]').val(); 
			var checkPwrdForm = new FormData();
			checkPwrdForm.append('sPassword', currentPword);
			checkPwrdForm.append('table', 'loginmaster'); 
			checkPwrdForm.append('checkPword', 1); 
			checkPwrdForm.append('iLoginID', userID); 


			console.log(currentPword);

			if(currentPword != ''){
				$('#noPass').addClass('d-none');

				var checkPwrd = new XMLHttpRequest();
				checkPwrd.onreadystatechange = function(){
					if(checkPwrd.readyState == 4 && checkPwrd.status == 200){
						console.log(checkPwrd.responseText);
						if(checkPwrd.responseText == 'pwrdValid'){
							$('#hideCurrentPword').addClass('d-none');
							$('.newPwrds').removeClass('d-none');
						}
						else{
							$('#noPass').html('<span class="text-danger">Password Incorrect</span>');
							$('#noPass').removeClass('d-none');
						}
					}
				}
				checkPwrd.open('POST','<?php echo URL;?>newHomePage/views/updateMyAccount.php');
				checkPwrd.send(checkPwrdForm);
			}
			else{
				$('#noPass').html('Please enter your current password.');
				$('#noPass').removeClass('d-none');
			}
		}
	/* END - Validate user's current password as part of a password update */

	/* Submit Form Changes for ministries and talents */	
		$('.sectionEdit').click(function(event){
			event.preventDefault(); 

			var userID = $('input[name=userID]').val(); 
			var formName = $(this).attr('formId');
			var table = $(this).attr('table');
			var getForm = document.forms.namedItem(formName);
			var newFormD = new FormData(getForm);
			newFormD.append('table', table);
			newFormD.append('iLoginID', userID); 
			
			// console.log('testing this');
			/* Create New XMLHttpRequest */
				var updateSection = new XMLHttpRequest(); 
				updateSection.onreadystatechange = function() {
					if(updateSection.status == 200 && updateSection.readyState == 4){
						console.log(updateSection.responseText); 
						/* Refresh Page When a new ministry, amenity, or talent is added or removed */
							if(table == 'churchministrymaster2' || table == 'talentmaster' || table == 'churchamenitymaster2' || table == 'groupmembersmaster'){
								if(updateSection.responseText == ''){
									console.log('no response');
									location.reload(); 
								}
							}
						/* Remove previous update message and Show new update message */
							$('#acct-update-message').remove();
							if(updateSection.responseText != ''){
								/* Error Message Display */
									var UpdateMessage = '<div class="container p-2 text-center mb-0" id="acct-update-message"><div class="row"><div class="col col-md-5">';	
							    	UpdateMessage += '<p class="m-0 p-2 text-gs" id="update-message">'+updateSection.responseText+'</p></div></div></div>';	    
						    	 /* Append the update result message to the perspective form */
								    	$('form[name='+formName+']').append(UpdateMessage);
							    /* Only fade out the successful update messages */	
							    	if(updateSection.responseText === 'Your Account Has Been Updated!!!'){
							    		console.log('test');
								    	$("#acct-update-message").fadeOut(3000);
								    }
							}
					}
				}
				updateSection.open('POST', '<?php echo URL;?>newHomePage/views/updateMyAccount.php');
				updateSection.send(newFormD);
		});

		(function() {
		  'use strict';
		  window.addEventListener('load', function() {
		    // Fetch all the forms we want to apply custom Bootstrap validation styles to
		    var forms = document.getElementsByClassName('needs-validation');
		    // Loop over them and prevent submission
		    var validation = Array.prototype.filter.call(forms, function(form) {
		      form.addEventListener('submit', function(event) {
		        if (form.checkValidity() === false) {
		          event.preventDefault();
		          event.stopPropagation();
		        }
		        else{
		        	event.preventDefault();
		        	var userID = $('input[name=userID]').val(); 
					var formName = form.name;
					var table = $(this)[0][0].value; 

		        	var getForm = document.forms.namedItem(formName);
					var newFormD = new FormData(getForm);
					newFormD.append('iLoginID', userID); 
		        	/* Create New XMLHttpRequest */
						var updateSection = new XMLHttpRequest(); 
						updateSection.onreadystatechange = function() {
							if(updateSection.status == 200 && updateSection.readyState == 4){

								/* Refresh Page When a new ministry, amenity, or talent is added or removed */
									if(table == 'churchministrymaster2' || table == 'talentmaster' || table == 'churchamenitymaster2' || table == 'churchtimeing' || table == 'groupmembersmaster'){
										if(updateSection.responseText == ''){
											location.reload(); 
										}
									}
								/* Remove previous update message and Show new update message */
									$('#acct-update-message').remove();
									if(updateSection.responseText != ''){
										var response = updateSection.responseText;

										/* When password updated */
											if(response == '1'){
												response = 'Your Password Has Been Updated!!!';
											}

										/* Error Message */
											var UpdateMessage = '<div class="container p-2 text-center mb-0" id="acct-update-message"><div class="row"><div class="col col-md-5">';	
									    	UpdateMessage += '<p class="m-0 p-2 text-gs" id="update-message">'+response+'</p></div></div></div>';	    
									    	
									    /* Append the update result message to the perspective form */
									    	$('form[name='+formName+']').append(UpdateMessage);

									    /* Only fade out the successful update messages */	
									    	if(response === 'Your Account Has Been Updated!!!' || response === 'Your Password Has Been Updated!!!'){
										    	$("#acct-update-message").fadeOut(3000);
										    	 setTimeout(function(){ window.location.href = 'https://dev.gospelscout.com/newHomePage/adminDashboard/concept-master/adminedit-user-profile.php?u_type=<?php echo $user_type;?>&id=<?php echo $user_id;?>';},3100);
										    }
									}
							}
						}
						updateSection.open('POST', '<?php echo URL;?>newHomePage/views/updateMyAccount.php');
						/* check if location parameters are valid for sending request */
							//1. check for the form name
							if(formName == 'locationInfo'){
								/* Insert the zip code validation and google query here */
									//2. grab the zip code from the form for testing and city retrieval 
									var newZip = $('input[name=iZipcode]').val();
									
									//3. Send the zip code to the the google api for city retrieval and comparison using zip validation funct
									validateZip(newZip,updateSection,newFormD);
							}
							else{
								updateSection.send(newFormD);
							}
		        }
		        form.classList.add('was-validated');
		      }, false);
		    });

		  }, false);
		})();
	/* END - Submit Form Changes */	
/****************** validate Zip code *************************/
	function validateZip(userZip,updateSection,newFormD){
		/****** execute Javascript to contact google geocoding api ******/
			$.support.cors = true;
			$.ajaxSetup({ cache: false });
			var city = '';
			var hascity = 0;
			var hassub = 0;
			var state = '';
			var nbhd = '';
			var subloc = '';
			
			if(userZip.length == 5){
				var date = new Date();
				var testJSON = $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
								     
					//find the city and state 
						var address_components = response.results[0].address_components;
						$.each(address_components, function(index, component){
							var types = component.types;
							$.each(types, function(index, type){
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

						/* Loop throught the select options to grab the statename for comparison to api results */

						$('#sStateName > option:selected').each(function() {
						    var userState = $(this).text();	
						    
						    if(state == userState){
								$('#zipStateErrorDiv').hide(); 
								
								if(hascity == 1){
									$('#sCityName').val(city);
									newFormD.append('sCityName',city);
								}
								else if(hasnbhd == 1){
									$('#sCityName').val(nbhd);
									newFormD.append('sCityName',nbhd);
								}

								/* Send XMLHttpRequest if state and zip code match */
									updateSection.send(newFormD);
							}
							else{
								$('#zipStateErrorDiv').show(); 
								$('#zipStateError').text('State/Zip code Mismatch');
							}
						    
						    
						});

				}); 
		      	}
		  	/****** END - execute Javascript to contact google geocoding api ******/
	}
/*************** END - validate Zip code **********************/
</script>