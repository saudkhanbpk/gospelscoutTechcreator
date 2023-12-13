<?php 
/*
	Create/Manage Gig Design 

	Form Validation 
		1. Gig manager playing status
			- default to no
			- if yes is clicked, default to first talent listed
		2. Gig client info
			- not required
		3. gig info 
			- required
		4. venue info
			- required
		5. artist info
			- not required; in the event gig manager is booking only himself for a client's gig
		6. song list info 
			- not required
		7. special request info 
			- not required

*/
	$backGround = 'bg2';
	$page = 'Pending Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	if($currentUserID == ''){
		echo '<script>window.location = "'. URL .'index.php";</script>';
		exit;
	}

	if($_GET['new']){
		/* Create a New Gig - Gig Manager Perspective */
			$form = 'new';

		/* User is gig manager */
			$user = 'manager';

		/* Get current user/gig manager's info from the usermaster table */
			$userInfo = $obj->fetchRow('usermaster', 'iLoginID = ' . $currentUserID);
			$manFullName = $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];
			$manEmail = $userInfo['sContactEmailID'];
			$manPhone = $userInfo['sContactNumber'];

		/* Create a Unique Gig Id */
			$gigManagerlName = $userInfo['sLastName'];
			$first4 = substr($gigManagerlName, 0, 4);
			$randSuffix = mt_rand(100, 999);
			$str = $first4 . $randSuffix; 
			$gigId = bin2hex($str);
		/* END - Create a Unique Gig Id */

		
	}
	elseif($_GET['gigID']){
		$gigId = trim($_GET['gigID']);

		/* Query database for gig info using gigID */
			$a = 'gigdetails';
			$b = 'gigartists';
			$c = 'gigmusic';
			$d = 'gigrequests';

			function getGigInfo($a,$db,$gigId){
				try{
					$gigDetailsQuery = 'SELECT * FROM ' . $a . ' WHERE ' . $a . '.gigId = ?';				

					$getGigDetails = $db->prepare($gigDetailsQuery);
					$getGigDetails->bindParam(1, $gigId);
					$getGigDetails->execute(); 
				}
				catch(Exception $e){
					echo $e; 
				}
				if($a == 'gigdetails'){
					$gigInfo = $getGigDetails->fetch(PDO::FETCH_ASSOC);
				}
				else{
					$gigInfo = $getGigDetails->fetchAll(PDO::FETCH_ASSOC);
				}
				return $gigInfo; 
			}

			$getGigDetails = getGigInfo($a,$db,$_GET['gigID']);
			$getGigArtists = getGigInfo($b,$db,$_GET['gigID']);
			$getGigMusic = getGigInfo($c,$db,$_GET['gigID']);
			$getGigRequests = getGigInfo($d,$db,$_GET['gigID']);
		/* END - Query database for gig info using gigID */

		/* Create hidden inputs to compare current gig artist's email address - validate find artists search */
			foreach($getGigArtists as $getEmail){
				echo '<input type="hidden" class="currentGigArtists" name=currentGigArtists[] value="' . $getEmail['gigArtists_email'] . '">';
			}
		/* END -  Create hidden inputs to compare current gig artist's emails - validate find artists search */


		if($getGigDetails){
			/* Generate existing-gig form */
				$form = 'existing';

			/* Determine formStatus - Submitted or Saved */
				$formStatus = $getGigDetails['gigDetails_formStatus']; 

			/* Determine if Gig is Expired or Cancelled */
				$hoy = date_create(date());
				$hoy = date_format($hoy, 'Y-m-d H:i:s');

				if($getGigDetails['gigDetails_setupTime'] < $hoy){
					$gigState = 'expired';
				}
				elseif($getGigDetails['gigDetails_gigStatus'] == 'cancelled'){
					$gigState = 'cancelled';
				}
				elseif($getGigDetails['gigDetails_gigStatus'] == 'active'){
					$gigState = 'active';
				}
			/* END - Determine if Gig is Expired or Cancelled */

			/* Determine user perspective */
				if($currentUserID == $getGigDetails['gigDetails_gigManLoginId']){
					/* User is gig manager */
						$user = 'manager';
				}
				else{
					/* User is gig artist */
						$user = 'artist';
				}
			/* END - Determine user perspective */

			/* If the Current user is a gig artist, define an array containing their gigartists table info */
				if($user == 'artist'){
					foreach($getGigArtists as $eachArtist){
						if($eachArtist['gigArtists_userId'] == $currentUserID){
							$getArtist = $eachArtist;
							$artView = $eachArtist['artistViewed']; // Current artist view status
							break; 
						}
					}

					/* Send marker, using XMLHttpRequest to record that artist has viewed the gig */
						if($gigState == 'active'){
							if($artView == '0'){
								echo '<input type="hidden" name="artistViewed" value="1">';
							}
						}
					/* END - Send marker, using XMLHttpRequest to record that artist has viewed the gig */

					echo '<input type="hidden" name="artistUserId" value="' . $currentUserID . '">';
				}
			/* END - If the Current user is a gig artist, define an array containing their gigartists table info */
		}
		else{
			/*  Redirect back to the previous page */
			echo '<script>window.location = "'. URL .'index.php";</script>';
			exit; 
		}
	}

	/* Get gig manager's talents */
		if($user == 'manager'  || $form == 'new'){
			$getTalents = $obj->fetchRowAll('talentmaster', 'iLoginID = ' . $currentUserID);
		}

	/* Get Event Types */ 
		$fetchEvents = $db->query('SELECT eventtypes.sName,eventtypes.iEventID  FROM eventtypes'); 
		$EventList = $fetchEvents->fetchAll(PDO::FETCH_ASSOC);

	/* Reduce $eventList from a 2D to 1D array */
		foreach($EventList as $Ev) {
			$EventList1D[$Ev['iEventID']] = $Ev['sName'];
		}
		asort($EventList1D);

	/* Today's date formatted */
		$todayDate = date_create(date());
		$today = date_format($todayDate, "Y-m-d"); 
		$dateTime = date_format($todayDate, "Y-m-d H:i:s");
		/* Hidden input to pass today's date to javascript */
			echo '<input type="hidden" name="todaysDate" value="' .  $today . '">';

	/* Values to be passed to javascript */
		//$getSess = $objsession->getSessionArray();
		$currentUserEmail = $objsession->get('gs_login_email');
		echo '<input type="hidden" name="currentUserEmail" value="' . $currentUserEmail . '">';

	/* Remove Inputs if gig is expired, cancelled, or user is an artist */
		if($user == 'artist' || $gigState == 'expired' || $gigState == 'cancelled'){
?>
			<style>
				input[type=text],input[type=radio],input[type=email],.no-button,.dropdown,div.date {
					display: none;
				}
				.gigEdit p {
					margin: 0;
					padding-left: 10px;
					font-size:13px;
					font-weight: bold;
					display:inline-block;
				}
			</style>
<?php 
		}
		else{
?>
			<style>
				.gigEdit p, .colon {
					display: none;
				}
			</style>
<?php 
		}
	/* END - Remove Inputs if gig is expired, cancelled, or user is an artist */

	/* Show Steps if user is a manager or form is new */
		if($user == 'artist'){
?>
		<style>
			.hide-steps {
				display: none;
			}
		</style>
<?php
		}

	/* Get the user's subscriptions from the subscriptions table */
		$type = 'artist'; 
		$isActive = '1';
		$cond = 'iLoginID = ' . $currentUserID . ' AND sType = "artist"' . ' AND isActive = 1';
		$subscriptionsList = $obj->fetchRowAll('subscription', $cond);
		
		/* Query the talentmaster table using the iLoginID of the artists from the subscriptions */
			foreach($subscriptionsList as $subscription){
				$cond = 'iLoginID = ' . $subscription['iRollID'];
				$subscripTalent[$subscription['iRollID']] = $obj->fetchRowAll('talentmaster',$cond);
			}
?>

<div class="container bg-white mt-5 mb-3 px-5 py-3" style="max-width:900px;min-height:700px">
	<div class="container text-center pb-0 mb-0">
		<h4 class="text-gs">
			<?php
				if($form == 'new') {
					echo 'Create A New Gig';
				}
				elseif($user == 'manager' && $form == 'existing'){
					echo 'Update Gig - ' . $getGigDetails['gigId'];
				}
				elseif($user == 'artist' && $form == 'existing'){
					echo 'Gig ID - ' . $getGigDetails['gigId'];
				}
			?>
		</h4>
		<!-- <hr class="mt-4"> Page Divider -->
	</div>

	<!-- Gig Details -->
		<form  action="gigform.php" method="post" name="gigdetails" class="needs-validation mt-4 gigEdit pb-4 pt-2" table="gigdetails" novalidate style="border-bottom:2px solid rgba(149,73,173,1);border-top:2px solid rgba(149,73,173,1);">
			<?php if($form == 'existing'){?>
				<div class="container mt-2 hide-steps">
					<div class="row">
						<div class="col-12 col-md-2 pl-0 pt-3 pt-md-0 text-md-left"><h6>Gig Status:</h6></div>
						<div class="col col-md-2 text-truncate pl-0 text-gs"><?php echo ucfirst($gigState);?></div>
					</div>
				</div>
			<?php }?>

			<h4 class="hide-steps">Step 1</h4>
			<!-- Gig Manager Playing Status -->
				<?php if($currentUserType == 'artist' && $user == 'manager'){?>
						<div class="container mt-2"> <!-- common section -->
							<h5 class="text-gs">Are Your Playing?</h5>
							<div class="custom-control custom-radio custom-control-inline">
							  <input type="radio" id="customRadioInline1" <?php if($getGigDetails['gigDetails_gigManPlay'] == '1'){echo 'checked';} ?> required name="gigDetails_gigManPlay" class="custom-control-input" onclick="showManTal()" value="1">
							  <label class="custom-control-label" for="customRadioInline1">Yes, I'm Playing</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
							  <input type="radio" id="customRadioInline2" <?php if($getGigDetails['gigDetails_gigManPlay'] == '0'){echo 'checked';} ?> required name="gigDetails_gigManPlay" class="custom-control-input" onclick="hideManTal()" value="0">
							  <label class="custom-control-label" for="customRadioInline2">No, I'm Not Playing</label>
							</div>

							<!-- Collapse Section to show gig manager's talent -->
							<div class="collapse" id="collapseExample">
								<div class="card card-body">
									<?php 
										$i = 0;
										foreach($getTalents as $tal){ 
									?>
											<div class="custom-control custom-radio">
											  <input type="radio" id="customRadio<?php echo $i;?>" <?php if($getGigDetails['gigDetails_gigManTal'] == $tal['TalentID']){echo 'checked';} ?> name="gigDetails_gigManTal" class="custom-control-input" value="<?php echo $tal['TalentID'];?>">
											  <label class="custom-control-label" for="customRadio<?php echo $i;?>"><?php echo str_replace("_","/",$tal['talent']);?></label>
											</div>

									<?php 
											$i++;
										}
									?>
							  	</div>
							</div>

							<hr class="mt-4"> <!-- Page Divider -->
						</div>	
				<?php }
					  else{
				?>
						<div class="container mt-2">
							<div class="row">
								<div class="col-12 col-md-4 pl-0  text-md-right"><h6>Gig Manager:</h6></div>
								<div class="col col-md-2 text-truncate pl-0"><a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $getGigDetails['gigDetails_gigManLoginId'];?>" class="text-gs"><?php echo $getGigDetails['gigDetails_gigManName'];?></a></div>
								<div class="col-2 col-md-1 pl-0">
									<a href="" class="getEmailInfo" data-toggle="modal" data-target="#emailArtistModal" name="<?php echo $getGigDetails['gigDetails_gigManName'];?>" email="<?php echo $getGigDetails['gigDetails_gigManEmail'];?>" artistid="<?php echo $getGigDetails['gigDetails_gigManLoginId'];?>">
										<img id="emailIcon" src="../img/envelope.png">
									</a>
								</div>
								<div class="col col-md-1 pl-0"><a href=""><img class="emailIcon2" style="width:20px; height:20px;" src="../img/phoneIcon2.png"></a></div>
							</div>
							<div class="row">
								<div class="col-12 col-md-4 pl-0 pt-3 pt-md-0 text-md-right"><h6>Your Confirmation Status:</h6></div>
								<div class="col col-md-2 text-truncate pl-0 text-gs"><?php echo ucfirst($getArtist['gigArtists_artistStatus']);?></div>
							</div>
							<div class="row">
								<div class="col-12 col-md-4 pl-0 pt-3 pt-md-0 text-md-right"><h6>Gig Status:</h6></div>
								<div class="col col-md-2 text-truncate pl-0 text-gs"><?php echo ucfirst($gigState);?></div>
							</div>
						</div>
				<?php		
					  }
				?>
			<!-- /Gig Manager Playing Status -->

			<!-- Gig Client Info -->
				<?php if($user == 'manager'){?>
					<div class="container mt-2"> <!-- common section -->
						<h5 class="text-gs">Client Info</h5>
						<div class="row pl-2">
							<div class="col-10 col-md-7">
								<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Name</label>
								<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_clientName" placeholder="Client Name" value="<?php echo $getGigDetails['gigDetails_clientName'];?>">
								<p><?php echo $getGigDetails['gigDetails_clientName'];?></p>
						    </div>

						    <div class="col-10 col-md-7">
								<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email</label>
								<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_clientEmail" placeholder="Client's Email Address" value="<?php echo $getGigDetails['gigDetails_clientEmail'];?>">
								<p><?php echo $getGigDetails['gigDetails_clientEmail'];?></p>
						    </div>
						    <div class="col-10 col-md-7">
								<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Phone #</label>
								<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_clientPhone" placeholder="Client's Phone #" value="<?php echo $getGigDetails['gigDetails_clientPhone'];?>">
								<p><?php echo $getGigDetails['gigDetails_clientPhone'];?></p>
						    </div>
						    <div class="col-10 col-md-7">
								<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Total Price</label>
								<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_clientTotalCost" placeholder="Client's Total Cost" value="<?php echo $getGigDetails['gigDetails_clientTotalCost'];?>">
								<p><?php echo $getGigDetails['gigDetails_clientTotalCost'];?></p>
						    </div>
						    <div class="col-10 col-md-7">
								<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Deposit</label>
								<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_clientDeposit" placeholder="Required Deposit" value="<?php echo $getGigDetails['gigDetails_clientDeposit'];?>">
								<p><?php echo $getGigDetails['gigDetails_clientDeposit'];?></p>
						    </div>
						    <div class="col-10 col-md-7">
								<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Deposit Date</label>
								<div class="input-group date dateTime-input mb-2 mt-0" id="datetimepicker1">
									<?php 
					                	
					                ?>
				               		<input type="text" class="form-control form-control-sm clearDefault mt-0" name="gigDetails_clientDepositDate" placeholder="Deposit Deadline" value="<?php echo $getGigDetails['gigDetails_clientDepositDate'];?>"/> 
					                <!-- <input type="hidden" name="todaysDate" value="<?php echo $today; ?>"> -->
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					            <p><?php echo $getGigDetails['gigDetails_clientDepositDate'];?></p>
						    </div>
						     <?php if($user == 'manager' && $form == 'existing' && $gigState == 'active'){?>
							     <div class="col-10 col-md-7">
							     	<input class="mt-2"  type="checkbox" name="emailClient" value="true">
							     	<label style="font-size:12px">Email client invoice when gig is created or updated</label>
							     </div>
						     <?php }?>
						</div>
						<hr class="mt-4"> <!-- Page Divider -->
					</div>
				<?php }?>
			<!-- /Gig Client Info -->

			<!-- Event Info -->
				<div class="container mt-2"> <!-- common section -->
					<h5 class="text-gs">Gig Info</h5>
					<div class="row pl-2">
						<div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Name<span class="colon">:</span></label>
							<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_gigName" placeholder="Event Name" value="<?php echo $getGigDetails['gigDetails_gigName'];?>" required>
							<p><?php echo $getGigDetails['gigDetails_gigName'];?></p>
					    </div>
					    <div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Type<span class="colon">:</span></label>
							<select class="custom-select dropdown" id="eventType" name="gigDetails_gigType" required>
						       	<option value="">What Kind of Event?</option>
						       	<?php 
							    	foreach($EventList1D as $evID => $singleEv) {
							    		if(str_replace("_", "/", $singleEv) == $getGigDetails['gigDetails_gigType']){
							    			echo '<option selected value="' . str_replace("_", "/", $singleEv) . '" >' . str_replace("_", "/", $singleEv) . '</option>'; 
							    		}
							    		else{
							    			echo '<option value="' . str_replace("_", "/", $singleEv) . '" >' . str_replace("_", "/", $singleEv) . '</option>'; 
							    		}
							    	}
							    ?>
						    </select>
						    <p><?php echo $getGigDetails['gigDetails_gigType'];?></p>
						</div>
					    <div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Date<span class="colon">:</span></label>
							<div class="input-group date dateTime-input mb-2" id="datetimepicker2">
								<?php 
				                	$eventDate = date_create($getGigDetails['gigDetails_gigDate']);
								    $eventDate = date_format($eventDate, 'D, d M Y'); 
				                ?>
			               		<input type="text" class="form-control form-control-sm clearDefault" name="gigDetails_gigDate" placeholder="Gig Date" value="<?php echo $getGigDetails['gigDetails_gigDate'];?>" required/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				                <div class="invalid-feedback">
						          Please enter the event date.
						        </div>
				            </div>
				            <p><?php echo $eventDate;?></p>
					    </div>
					    <div class="col-10 col-md-7">
					    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Setup Time<span class="colon">:</span></label>
					    	<div class="input-group date dateTime-input" id="datetimepicker3">
					    		<?php 
					    			$setup = date_create($getGigDetails['gigDetails_setupTime']);
								    $setup = date_format($setup, "g:ia"); 
					    		?>
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigDetails_setupTime" placeholder="Setup Time" value="<?php if(!empty($getGigDetails['gigDetails_setupTime'])){ echo $setup;}?>" required/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-time"></span>
				                </span>
				                <div class="invalid-feedback">
						          Please enter the event setup time.
						        </div>
				            </div>
				            <p><?php echo $setup;?></p>
				        </div>
				        <div class="col-10 col-md-7">
				        	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Start Time<span class="colon">:</span></label>
					    	<div class="input-group date dateTime-input" id="datetimepicker4">
					    		<?php 
					    			$start = date_create($getGigDetails['gigDetails_startTime']);
								    $start = date_format($start, "g:ia"); 
					    		?>
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigDetails_startTime" placeholder="Start Time" value="<?php if(!empty($getGigDetails['gigDetails_startTime'])){ echo $start;}?>" required/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-time"></span>
				                </span>
				                 <div class="invalid-feedback">
						          Please enter the event start time.
						        </div>
				            </div>
				            <p><?php echo $start;?></p>
				        </div>
				        <div class="col-10 col-md-7">
				        	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">End Time<span class="colon">:</span></label>
					    	<div class="input-group date dateTime-input" id="datetimepicker5">
					    		<?php 
					    			$end = date_create($getGigDetails['gigDetails_endTime']);
								    $end = date_format($end, "g:ia"); 
					    		?>
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigDetails_endTime" placeholder="End Time" value="<?php if(!empty($getGigDetails['gigDetails_endTime'])){ echo $end;}?>" required/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-time"></span>
				                </span>
				                 <div class="invalid-feedback">
						          Please enter the event end time.
						        </div>
				            </div>
				            <p><?php echo $end;?></p>
				        </div>
				        <div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Privacy<span class="colon">:</span></label>
							<select class="custom-select dropdown" id="privacy" name="gigDetails_gigPrivacy" required>
						       	<option value="">Privacy</option>
						       	<option <?php if($getGigDetails['gigDetails_gigPrivacy'] == 'pub'){echo 'selected';} ?> value="pub">Public</option>
						       	<option <?php if($getGigDetails['gigDetails_gigPrivacy'] == 'priv'){echo 'selected';} ?> value="priv">Private</option>
						    </select>
						    <div class="invalid-feedback">
					          Please select a privacy setting.
					        </div>
						    <p><?php if($getGigDetails['gigDetails_gigPrivacy'] == 'priv'){echo 'Private Event';}else{echo 'Public Event';}?></p>
						</div>
						<?php if($user == 'manager' && $form == 'existing' && $gigState == 'active'){?>
							 <div class="col-10 col-md-7">
						     	<input class="mt-2"  type="checkbox" name="emailEventChange" value="true">
						     	<label style="font-size:12px">Email artist(s) event info update notification</label>
						     </div>
					     	<?php }?>
					</div>
					<hr class="mt-4"> <!-- Page Divider -->
				</div>
			<!-- /Event Info -->

			<!-- Venue Info -->
				<div class="container mt-2"> <!-- common section -->
					<h5 class="text-gs">Venue Info</h5>
					<div class="row pl-2">
						<div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue Name<span class="colon">:</span></label>
							<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_venueName" placeholder="Venue Name" value="<?php echo $getGigDetails['gigDetails_venueName'];?>" required>
							<div class="invalid-feedback">
					          Please enter the venue name.
					        </div>
							<p><?php echo $getGigDetails['gigDetails_venueName'];?></p>
					    </div>
					    <div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue Address<span class="colon">:</span></label>
							<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_venueAddress" placeholder="Venue Address" value="<?php echo $getGigDetails['gigDetails_venueAddress'];?>" required>
							<div class="invalid-feedback">
					          Please enter the venue address.
					        </div>
							<p><?php echo $getGigDetails['gigDetails_venueAddress'];?></p>
					    </div>
					    <div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zip Code<span class="colon">:</span></label>
							<input type="text" class="form-control form-control-sm mb-2" name="gigDetails_venueZip" placeholder="Zipcode" value="<?php echo $getGigDetails['gigDetails_venueZip'];?>" required>
							<div class="invalid-feedback">
					          Please enter the zip code.
					        </div>
							<p><?php echo $getGigDetails['gigDetails_venueZip'];?></p>
					    </div>
					    <div class="col-10 col-md-7">
							<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Environment<span class="colon">:</span></label>
							<select class="custom-select dropdown" id="environment" name="gigDetails_venueEnvironment" required>
						       	<option value="">Environment</option>
						       	<option <?php if($getGigDetails['gigDetails_venueEnvironment'] == 'indoor'){echo 'selected';} ?> value="indoor">Indoor</option>
						       	<option <?php if($getGigDetails['gigDetails_venueEnvironment'] == 'outdoor'){echo 'selected';} ?> value="outdoor">Outdoor</option>
						    </select>
						    <div class="invalid-feedback">
					          Please select the venue environment.
					        </div>
						    <p><?php echo ucfirst($getGigDetails['gigDetails_venueEnvironment']);//if($getGigDetails['gigDetails_gigPrivacy'] == 'priv'){echo 'Private Event';}else{echo 'Public Event';}?></p>
						</div>
						<?php if($user == 'manager' && $form == 'existing' && $gigState == 'active'){?>
							<div class="col-10 col-md-7">
						     	<input class="mt-2"  type="checkbox" name="emailVenueChange" value="true">
						     	<label style="font-size:12px">Email artist(s) venue info update notification</label>
						    </div>
					    	<?php }?>
					</div>
					<hr class="mt-4"> <!-- Page Divider -->
				</div>
			<!-- /Venue Info -->

			 
			<!-- gigid -->
				<input type="hidden" name="gigId" value="<?php echo $gigId;?>">
			
				<?php if($form == 'new'){?>
						<!-- gig manager loginid - gigDetails_gigManLoginId -->
							<input type="hidden" name="gigDetails_gigManLoginId" value="<?php echo $currentUserID;?>">
						<!-- gig manager name - gigDetails_gigManName -->
							<input type="hidden" name="gigDetails_gigManName" value="<?php echo $manFullName;?>">
						<!-- gig manager email - gigDetails_gigManEmail -->
							<input type="hidden" name="gigDetails_gigManEmail" value="<?php echo $manEmail; ?>">
						<!-- gig manager phone - gigDetails_gigManPhone -->
							<input type="hidden" name="gigDetails_gigManPhone" value="<?php echo $manPhone;?>">
				<?php }?>
				
				

				<!-- determine if gig is being updated or created
					a. user $form var - new or existing
					b. if existing pass modification date - gigDetails_modifiedDateTime
					c. if new pass creating date - gigDetails_creationDate -->
				<?php 
					/* Define creation date or modification date contingent upon a new or existing form */
						if($form == 'existing'){
							echo '<input type="hidden" name="gigDetails_modifiedDateTime" value="' . $dateTime . '">';
						}
						elseif($form == 'new'){
							echo '<input type="hidden" name="gigDetails_creationDate" value="' . $dateTime . '">';
						}
				?>
				<!-- gig status - gigDetails_gigStatus
					a. default = active - for new gigs
					b. subject to change for existing gigs - contingent upon of the cancel button is clicked
						1. active 
						2. cancelled -->
				<input type="hidden" name="gigDetails_gigStatus" value="active">

				<!-- gig form status - gigDetails_formStatus
					a. indicates if the gig was sumbitted or saved
						1. contingent upon which submit button is clicked -->
				<input type="hidden" name="gigDetails_formStatus" value="">

			<?php 
				if($form == 'new' || ($form == 'existing' && $user == 'manager' && $formStatus == 'saved' && $gigState == 'active')){
					echo '<button class="btn btn-small btn-gs text-white getStatus" type="submit" id="createGig">Create Gig</button> ';
					echo '<button class="btn btn-small btn-gs text-white mr-1 getStatus" type="submit" id="saveGig">Save Gig</button>';
					if($formStatus == 'saved'){
						echo '<button class="btn btn-small btn-gs text-white getStatus getStatus" type="submit" id="deleteSavedGig">Delete Saved Gig</button>';
					}
				}
				elseif($form == 'existing' && $formStatus == 'submitted' && $gigState == 'active'){
					if($user == 'manager'){
						echo '<button class="btn btn-small btn-gs text-white mr-1 submit-class getStatus" type="submit" id="updateGig">Update Gig</button>'; 
					  	echo '<button data-toggle="modal" data-target="#gigCancellation" data-dismiss="modal" aria-label="Close" class="btn btn-small btn-gs text-white getStatus" type="button" id="gigManCancelGig">Cancel Gig</button>';
					}
				}
			?>
		</form>
	<!-- /Gig Details -->

	<!-- Music Info -->
		<!-- MP3 Player JS and Styling -->
	    <script src="<?php echo URL;?>audioplayerengine/jquery.js"></script>
	    <script src="<?php echo URL;?>audioplayerengine/amazingaudioplayer.js"></script>
	    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>audioplayerengine/initaudioplayer-1.css">
	    <script src="<?php echo URL;?>audioplayerengine/initaudioplayer-1.js"></script>
	    <!-- End MP3 Player JS and Styling -->

		<div class="container mt-2" style="border-bottom:2px solid rgba(149,73,173,1);"> <!-- common section -->
			<h4 class="hide-steps">Step 2</h4>
			<div class="container mb-2">
				<h5 class="text-gs">Music Info</h5>
				<div class="container">
					<?php if($form == 'existing'){?>
						<!-- List/Remove Songs from current Set list -->
							<h6>Set List</h6>
							<div class="container mt-0 mb-3">
								<?php 
									if(count($getGigMusic) > 0 ){ 
										
								?>
										<form action="" method="POST" name="removeSong" class="mt-0 gigEdit needs-validation" novalidate table="gigmusic">
											<?php foreach($getGigMusic as $gigMusic){?>
												<table class="mb-2" style="font-size:13px;">
													<tr>
														<tr>
															<td class="pr-3 <?php if($currentUserID != $getGigDetails['gigDetails_gigManLoginId']){echo 'd-none';}?>"><input type="checkbox" name="id[]" value="<?php echo $gigMusic['id'];?>"></td>
															<td>Song Name: </td>
															<td class="pl-1"><?php echo $gigMusic['gigMusic_songName'];?></td>
														</tr>
														<tr>
															<td class="<?php if($currentUserID != $getGigDetails['gigDetails_gigManLoginId']){echo 'd-none';}?>"></td>
															<td>Youtube Link: </td>
															<td class="pl-1 text-truncate">
																<?php 
																	if($gigMusic['gigMusic_songYoutubeUrl']){?>
																		<a href="<?php echo $gigMusic['gigMusic_songYoutubeUrl'];?>" class="text-gs"><?php echo substr_replace($gigMusic['gigMusic_songYoutubeUrl'], '...', 23);?></a>
																<?php 
																	}	
																	else{
																		echo 'N/A';
																	}
																	?>
															</td>
														</tr>
														<tr>
															<td class="<?php if($currentUserID != $getGigDetails['gigDetails_gigManLoginId']){echo 'd-none';}?>"></td>
															<td>MP3 Upload: </td>
															<td class="pl-1">
																<?php 
																	if($gigMusic['gigMusic_songMp3Path']){ 
																		echo '<button type="button" onlcick="" data-toggle="modal" data-target="#playMP3">Play MP3</button>';
																	}
																	else{
																		echo 'N/A';
																	}
																?>
															</td>
														</tr>
													</tr>
												</table>
											<?php }?>
											<?php if($currentUserID == $getGigDetails['gigDetails_gigManLoginId']){?>
												<button type="submit" class="btn-gs btn-gs-border-radius mt-1">Remove Song(s)</button>
											<?php }?>
										</form>
								<?php 
									}
									else{
										echo '<h5 style="color: rgba(204,204,204,1)">Set List is Empty</h5>';
									}
								?>
							</div>
						<!-- / List/Remove Songs from current Set list -->
					<?php }?>

					<!-- Add Songs to current Set list -->
						<?php if(($form == 'existing' && $gigState == 'active' && $user == 'manager') || $form == 'new'){?>
							<h6 class="mt-2">Add New Song</h6>
							<div class="container">
								<form action="" method="POST" name="addSong" class="needs-validation mt-0 gigEdit" novalidate table="gigmusic">
									<div class="row">
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Song Name<span class="colon">:</span></label>
											<input type="text" class="form-control form-control-sm mb-2" name="gigMusic_songName" placeholder="Song Name" value="" required>
											<div class="invalid-feedback">
									          Please enter the song name.
									        </div>
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">YouTube Link<span class="colon">:</span></label>
											<input type="text" class="form-control form-control-sm mb-2" name="gigMusic_songYoutubeUrl" placeholder="YouTube Link" value="">
										</div>
										<div class="col-10 col-md-7">
											<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">MP3 Upload<span class="colon">:</span></label>
											<div class="custom-file mb-2">
											  	<input type="file" class="custom-file-input" id="musicFile" name="musicFile">
											  	<label class="custom-file-label" for="videoFile">Upload MP3</label>
											</div>
											<!-- Show Upload Video File Name-->
					    							<div id="show-musFile-name" class="text-success"></div>
					    						<!-- /Show Upload Video File Name-->
										</div>
									</div>
									<button type="submit" id="sendMusic" onclick="" <?php if($getGigDetails['gigDetails_formStatus'] != 'submitted'){echo 'disabled';}else{echo 'class="btn-gs btn-gs-border-radius"';}?>>Add Song +</button>
								</form>
						<!-- Progress Bar for uploading Files -->
							<div class="container">
			    					<h6>Upload Status</h6>
			    					<div class="progress mt-2">
									<div class="progress-bar progress-bar-striped progress-bar-animated serverUpload" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
								</div>
							</div>
						<!-- /Progress Bar for uploading Files -->
							</div>
						<?php } ?>
					<!-- /Add Songs to current Set list -->
				</div>
			</div>
		</div>
	<!-- /Music info -->

		<!-- Artists Info -->
			<!-- 
				Search for artist by subscriber list Using xmlHTTPRequests
				4. append the inputs to the form for newly selected artists
			-->

			<div class="container mt-2" style="border-bottom:2px solid rgba(149,73,173,1);"> <!-- common section -->
				<h4 class="hide-steps">Step 3</h4>
				<div class="container table-responsive">
					<h5 class="text-gs">Artist Info</h5>
					<?php 
						if($form == 'existing'){
							/* Query Database for Current Gig Artists */
								$getArtistQuery = 'SELECT * FROM gigartists WHERE gigId = ?';

								try{
									$getArtists = $db->prepare($getArtistQuery);
									$getArtists->bindParam(1,$_GET['gigID']);
									$getArtists->execute(); 
								}
								catch(Exception $e){
									echo $e; 
								}
								$artistList = $getArtists->fetchAll(PDO::FETCH_ASSOC);

							/* END - Query Database for Current Gig Artists */

							/* List Current Artist Booked, Pending, or Cancelled for the current gig */
								if(count($artistList) > 0 ){
									$tableHeaders = array('Name','Talent','Status','Email','Phone','Remove');
					?>
									<table class="table table-striped table-font-size">
										<thead>
											<tr>
												<?php foreach($tableHeaders as $header){
														if($header == 'Email' || $header == 'Phone'){
															echo '<th class="d-none d-md-table-cell">' . $header . '</th>';
														}
														elseif($header == 'Remove'){
															if($user == 'manager'){
																echo '<th>' . $header . '</th>';
															}
														}
														else{
															echo '<th>' . $header . '</th>';
														}
													  }
												?>
											</tr>
										</thead>
										<tbody>
											<?php 
											//echo '<pre>';
											//var_dump($artistList);
											foreach($artistList as $artist){?>
													<tr class="text-gs">
														<td><a class="text-gs" href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artist['gigArtists_userId'];?>"><?php echo $artist['gigArtists_name'];?></a></td>
														<td><?php echo str_replace("_", "/",$artist['gigArtists_tal']);?></td>
														<td id="statusChange<?php echo $artist['gigArtists_userId'];?>">
															<?php 
																if($artist['gigArtists_gigManCancelStatus'] == 'cancelled'){
																	echo $artist['gigArtists_gigManCancelStatus'];
																}
																else{
																	echo $artist['gigArtists_artistStatus'];
																}
															?>
														</td>
														<td class="d-none d-md-table-cell">
															<a href="#" class="getEmailInfo" data-toggle="modal" data-target="#emailArtistModal" name="<?php echo $artist['gigArtists_name'];?>" email="<?php echo $artist['gigArtists_email'];?>" artistid="<?php echo $artist['gigArtists_userId'];?>" artistTal="<?php echo str_replace("_", "/",$artist['gigArtists_tal']);?>">
																<img id="emailIcon" src="../img/envelope.png">
															</a>
														</td>
														<td class="d-none d-md-table-cell"><?php if($artist['gigArtists_phone'] > 0){echo '<a href=""><img id="emailIcon" src="../img/phoneIcon2.png" width="25px" height="25px"></a>';}else{echo 'N/A';}?></td>
														<?php if($user == 'manager'){
																if($artist['status'] == 'cancelled' || $artist['status'] == 'inactive' || $artist['gigArtists_gigManCancelStatus'] == 'cancelled'){
																	echo '<td>cancel</td>';
															 	}
																else{
														?>
																	<td><a class="text-gs cancelArt" data-toggle="modal" data-target="#removeArtist" href="" gigID="<?php echo $_GET['gigID'];?>" artistID="<?php echo $artist['gigArtists_userId'];?>" class="<?php if($artist['status'] == 'cancelled' || $artist['status'] == 'inactive'){echo 'cancelFade';} ?>">Cancel</a></td>	
														<?php
															  	}
															  }
														?>
													</tr>
											<?php }?>
										</tbody>
									</table>
					<?php
								}
						}
					?>

					<div class="row pl-2">
						<?php if($user == 'manager' && $gigState == 'active'){?>
						<!-- Search for new artists via artist's email -->
							<div class="col-10 col-md-7">
								<label class="text-gs mb-1 dropdown" style="font-size:12px;font-weight:bold" for="">Search for Artist by email</label>
								<input type="email" class="form-control form-control-sm mb-2" name="artistEmailSearch" value="" placeholder="artist123@example.com">
								<button type="button" onclick="findArtistFunction()" <?php if($getGigDetails['gigDetails_formStatus'] != 'submitted'){echo 'disabled';}else{echo 'class="btn-gs btn-gs-border-radius"';}?>>Find Artist</button>
								<h6 id="noResults" class="mt-2" style="font-weight:bold"></h6>
							</div>
						<!-- /Search for new artists via artist's email -->

						<!-- List newly added artist -->
							<div class="col-10 col-md-7 artist-add d-none">
								<form  action="gigform.php" method="post" name="gigartists" id="addArtistsform"  class="needs-validation mt-0 gigEdit pt-3" table="gigartists" novalidate>
									<div class="container  pt-3 mb-2">
										<input type="hidden" name="gigArtists_userId" value="">
										<input type="hidden" name="gigArtists_name" value="">
										<input type="hidden" name="gigArtists_email" value="">
										<input type="hidden" name="gigArtists_phone" value="">
										<input type="hidden" name="gigId" value="<?php echo $gigId;?>">
										<table class="mb-3" style="font-size:12px;">
											<tr><td>Name:</td><td id="searchedArttist-name"></td></tr>
											<tr><td>Email:</td><td id="searchedArttist-email"></td></tr>
											<tr><td>Phone#:</td><td id="searchedArttist-phone"></td></tr>
											<tr><td>Talent:</td><td></td></tr>
											<tr><td></td>
												<td id="appendTalent">
												</td>
											</tr>
										</table>
										<button type="button" class="btn btn-gs btn-sm" onclick="artistReset()">Remove Artist</button>
									</div>
									<button type="submit" class="btn btn-gs btn-sm">Add Artist</button>
								</form>
							</div>
						<!-- /List newly added artist -->

						<!-- Search for new artist via user's subscriptions -->
							<div class="col-10 col-md-7">
								<label class="text-gs mb-1 dropdown" style="font-size:12px;font-weight:bold" for="">Select artist from your subscriptions</label>
							</div>
							<div class="col-10 col-md-7">
								<button type="submit" data-toggle="modal" data-target="#artistSubscriptions" class="btn btn-gs btn-sm" <?php if($getGigDetails['gigDetails_formStatus'] != 'submitted'){echo 'disabled';}else{echo 'class="btn-gs btn-gs-border-radius"';}?>>Subscriptions</button>
							</div>
						<!-- /Search for new artist via user's subscriptions -->
						<?php }?>
					</div>
					<hr class="mt-4"> <!-- Page Divider -->
				</div>
			</div>
		<!-- /Artists Info -->

		<!-- Artist Request Info -->
			<div class="container mt-2 pb-3" style="border-bottom:2px solid rgba(149,73,173,1);"> <!-- common section -->
				<h4 class="hide-steps">Step 4</h4>
				<div class="container">
					<h5 class="text-gs">Artist Requests</h5>
					<div class="container">
						<h6>Current Gig Requests</h6>
						<div class="container table-responsive">
							<ol>
								<?php 
									foreach($getGigRequests as $gigRequests){
										$messageID[] = $gigRequests['gigRequests_messageID'];
									}
									$messageID = array_unique($messageID);

									foreach($messageID as $ID){ //cycle through the message id's
										foreach($getGigRequests as $gigRequest){ //cycle through the rows returned from the gigrequests table
											/* Catch the message id's that match the outer loop to group the artists that have the same message */
												if($ID == $gigRequest['gigRequests_messageID']){
													if($gigRequest['gigRequests_everyone'] == 1){
														$messagesArray[$ID]['allArtists'] = true; 
													}
													else{
														$messagesArray[$ID]['artists'][] = $gigRequest['gigrequests_artistName'];
													}
													$messagesArray[$ID]['message'] = $gigRequest['gigRequests_message'];
												}
										}
									}

										if($user == 'artist'){
											if($getGigRequests){
												foreach($getGigRequests as $index => $request){
													if($request['gigRequests_artistUserId'] == $currentUserID || $request['gigRequests_everyone'] == 1){
								?>

														<li class="mt-2">
															<table class="table ml-2 " style="font-size: 12px; width: 90%;">
																<tr style="background-color:rgba(0,0,0,.06);">
																	<th valign="top" style="width:40px;">Artist: </th>
																	<td class="pl-2"><?php if($request['gigRequests_everyone'] == '1'){echo 'All Artists';}else{echo $request['gigrequests_artistName'];}?></td>
																</tr>
																<tr>
																	<th valign="top" style="width:40px;">Request: </th>
																	<td class="pl-2"><?php echo $request['gigRequests_message'];?></td>
																</tr>
															</table>
														</li>
								<?php 
													}
												}
											}
											else{
												echo '<h5 style="color: rgba(204,204,204,1)">There are no requests</h5>';
											}
										}
										elseif($user == 'manager'){
											if($messagesArray){
												foreach($messagesArray as $index => $request){
												/*  list the messages based on the messagesID's listed on the server */
								?>
												<li class="mt-2">
													<table class="table ml-2 " style="font-size: 12px; width: 90%;">
															<tr style="background-color:rgba(0,0,0,.06);">
																<th valign="top" style="width:40px;">Artist: </th>
																<td class="pl-2">
																	<?php 
																		if($request['allArtists'] == true){
																			echo 'All Artists';
																		}
																		else{
																			echo '<a class="text-truncate" href="">';
																			$j = 1; 
																			foreach($request['artists'] as $artist){
																				if($j == count($request['artists'])){
																					echo $artist;
																				}
																				else{
																					echo $artist . ', ';
																				}
																				$j++;
																			}
																			echo '</a>';
																		}
																	?>
																</td>
															</tr>
															<tr>
																<th valign="top" style="width:40px;">Request: </th>
																<td class="pl-2"><?php echo $request['message'];?></td>
															</tr>
														</table>
													</li>
								<?php
												}
											}
											else{
												echo '<h5 style="color: rgba(204,204,204,1)">There are no requests</h5>';
											}
										}
								?>
							</ol>
						</div>

						<?php if($user == 'manager' && $gigState == 'active'){?>
							<h6>Send New Gig Request</h6>
							<form action="#" method="post" id="gigrequests" name="gigrequests" class="needs-validation" novalidate>
								<div class="container">
									<div class="row">
										<div class="col">
											<div class="btn-group">
												<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												    Select Artist(s)
												</button>
												<div class="dropdown-menu px-1" style="font-size:13px">
													<div>
														<input type="checkbox" name="gigRequests_everyone" value="1">
														<label>All Artists</label> 
													</div>
													<?php 
														foreach($artistList as $artist){
													?>
														<div class="text-truncate">
															<input type="checkbox" name="gigrequests_artistName[<?php echo $artist['gigArtists_userId']; ?>]" artistId ="<?php echo $artist['gigArtists_userId']; ?>" value="<?php echo $artist['gigArtists_name'];?>"> 
															<label><?php echo $artist['gigArtists_name'];?></label> 
														</div>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;">Gig Request</label>
											<textarea class="form-control mb-2" name="gigRequests_message" placeholder="Write a request..." wrap="" rows="5" aria-label="With textarea" required></textarea>
											<div class="invalid-feedback">
									          Please select an artist and enter your request.
									        </div>
											<button type="submit" class="btn btn-gs btn-sm" <?php if($getGigDetails['gigDetails_formStatus'] != 'submitted'){echo 'disabled';}else{echo 'class="btn-gs btn-gs-border-radius"';}?>>Submit Request</button>
										</div>
									</div>
								</div>
							</form>
						<?php }?>
					</div>
				</div>
			</div>
		<!-- /Artist Request info -->

		<!-- Artists Actions -->
			<div class="container text-center my-2 p-2">
				<!-- <form action="" method="" name="artistActions" id="artistActions"> -->
					<?php 
						if($form == 'existing' && $formStatus == 'submitted' && $gigState == 'active' && $user == 'artist'){
							if($getArtist['gigArtists_gigManCancelStatus'] != 'cancelled'){
								if($getArtist['gigArtists_artistStatus'] == 'pending'){
									echo '<button class="btn btn-small btn-gs text-white mr-1 artistAction" type="button" id="confirmed">Confirm Gig</button>';
									echo '<button class="btn btn-small btn-gs text-white artistAction" type="button" id="declined">Decline Gig</button>';
								}
								elseif($getArtist['gigArtists_artistStatus'] == 'confirmed'){
									echo '<button class="btn btn-small btn-gs text-white artistAction" type="button" id="cancelled">Cancel Gig</button>';
								}
							}
							else{
								echo '<h5 class="">This gig has been cancelled.  Click for <a href="" class="text-gs">details</a></h5>';
							}
							
						}
					?>
				<!-- </form> -->
			</div>
		<!-- /Artists Actions -->
</div><!-- /artist,song,request info container -->		

	
<!-- Modal to email gig artists -->
	<div class="modal fade" id="emailArtistModal" tabindex="-1" role="dialog" aria-labelledby="emailArtistModal" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	    	<!-- Error Message Display -->
			    <div class="container p-3 text-center mb-0 d-none" id="error-message-emailArtist">
			      	<p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-emailArtist" style="border-radius:7px"></p>
			    </div>
			<!-- /Error Message Display --> 

			<!-- Modal Title -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Email Artist</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="emailReset()">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Modal Title -->

		    <form action="" method="POST" name="emailArtists" enctype="multipart/form-data" id="emailArtistForm">
			    <!-- Modal Body -->
			      	<div class="modal-body">
				    	<div class="form-group">
				    		<input type="hidden" name="artistEmail" value="">
				    		<input type="hidden" name="artistName" value="">
				    		<input type="hidden" name="artistID" value="">
				    		<input type="hidden" name="gigManID" value="<?php echo $getGigDetails['gigDetails_gigManLoginId'];?>">

				    		<table>
				    			<tr>
				    				<td class="text-gs mb-1 " style="font-size:12px;font-weight:bold;">Name:</td>
				    				<td class="m-0 pl-2" style="font-size:12px;" id="artistName-emailModal"></td>
				    			</tr>
				    			<tr>
				    				<td class="text-gs mb-1" style="font-size:12px;font-weight:bold;">Artist's Email:</td>
				    				<td class="m-0 pl-2"  id="artistEmail-emailModal" style="font-size:12px;"></td>
				    			</tr>
				    			<!--
				    			<tr>
				    				<td class="text-gs mb-1" style="font-size:12px;font-weight:bold;">Subject:</td>
				    				<td class="m-0 pl-2"><input type="text" class="p-0"  id="emailSubject-emailModal" style="font-size:12px;width:250px;height:20px" placeholder="Subject Line..." name="emailSubject" value=""></td>
				    			</tr>
				    			-->
				    		</table>
				    		<label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;">Email Message</label>
							<textarea class="form-control mb-2" name="gigArtists_gigManCancelReason" placeholder="Write a message..." wrap="" rows="5" aria-label="With textarea"></textarea>
							<input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
						</div>
			      	</div>
			     <!-- /Modal Body -->

			     <!-- Hidden Sender Info -->
			     	<input type="hidden" name="trueSenderEmail" value="<?php echo $currentUserEmail; ?>">
			     	<input type="hidden" name="trueSenderName" value="<?php echo  $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];?>">
			     	<input type="hidden" name="trueSenderPhone" value="<?php echo $userInfo['sContactNumber'];?>">
			     	<!-- If current user is gig manager or fellow artist and define email vars accordingly -->
				     	<?php 
				     		if($user == 'manager'){
				     			$trueSenderTalent = 'N/A';
				     			$trueSenderGigStatus = 'Gig Manager';
				     		}elseif($user == 'artist') {
				     			$trueSenderTalent = str_replace("_", "/",$getArtist['gigArtists_tal']);
				     			$trueSenderGigStatus = $getArtist['gigArtists_artistStatus'];
				     		}
				     	?>
			     	<!-- /If current user is gig manager or fellow artist and define email vars accordingly -->
			     	<input type="hidden" name="trueSenderTalent" value="<?php echo $trueSenderTalent; ?>">
			     	<input type="hidden" name="trueSenderGigStatus" value="<?php echo $trueSenderGigStatus; ?>">
			     	<input type="hidden" name="gigName" value="<?php echo $getGigDetails['gigDetails_gigName'];?>">
			     	<input type="hidden" name="receiverTalent" value="">
			     <!-- /Hidden Sender Info -->
			     
			    <!-- Modal Footer -->
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-gs" id="emailArtistButton" data-dismiss="modal" aria-label="Close" onclick="sendEmail()">Send Email</button>
			        	<button type="button" class="btn btn-gs" id="cancelEmail" data-dismiss="modal" aria-label="Close" onclick="emailReset()">Cancel</button>
			      	</div>
			    <!-- /Modal Footer -->
		    </form>
	    </div>
	  </div>
	</div>
<!-- /Modal to email gig artists -->

<!-- Remove Artist - Confirm artist removal - Explanation -->
	<form action="fileUpload.php" method="POST" name="artistRemoval" enctype="multipart/form-data" id="artistRemovalForm">
		<!-- Modal Remove Artist from gig -->
			<div class="modal fade" id="removeArtist" tabindex="-1" role="dialog" aria-labelledby="addPhotoTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	<!-- Error Message Display -->
					    <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
					      	<p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
					    </div>
					<!-- /Error Message Display --> 

					<!-- Modal Title -->
					    <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLongTitle">Remove Artist</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
					        	<span aria-hidden="true">&times;</span>
					        </button>
					    </div>
				    <!-- /Modal Title -->

				    <!-- Modal Body -->
				      	<div class="modal-body">
					    	<div class="form-group">
					    		<label for="vidTalent">Reason For Cancelling Artist</label>
								<textarea class="form-control mb-2" name="gigArtists_gigManCancelReason" placeholder="Write a message..." wrap="" rows="4" aria-label="With textarea"></textarea>
								<input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
								<!-- <input type="hidden" name="gigArtists_userId" value=""> -->
								<input type="hidden" name="gigArtists_gigManCancelStatus" value="cancelled">

							</div>
				      	</div>
				     <!-- /Modal Body -->

				    <!-- Modal Footer -->
				      	<div class="modal-footer">
				        	<button type="button" data-toggle="modal" data-target="#confirmRemoval" class="btn btn-gs" id="remArtistButton" data-dismiss="modal" aria-label="Close">Submit</button>
				        	<button type="button" class="btn btn-gs" id="cancRemoval" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
				      	</div>
				    <!-- /Modal Footer -->
			    </div>
			  </div>
			</div>
		<!-- / Modal Remove Artist from gig -->

		<!-- Modal CONFIRM - Remove Artist from gig -->
			<div class="modal fade" id="confirmRemoval" tabindex="-1" role="dialog" aria-labelledby="addPhotoTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
					<!-- Modal Title -->
					    <div class="modal-header">
					        <h6 class="modal-title" id="exampleModalLongTitle">Confirm Removal</h6>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
					        	<span aria-hidden="true">&times;</span>
					        </button>
					    </div>
				    <!-- /Modal Title -->

			      	<!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
				      	<div class="modal-body">
					    	<div class="form-group">
					    		<p>Please confirm the removal of this artist from the current gig.</p>
					    	</div>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="submit" class="btn btn-gs" id="confRemoval" data-dismiss="modal" aria-label="Close">Confirm</button>
				        	<button type="button" class="btn btn-gs" id="cancConf" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
				      	</div>
			      	
			    </div>
			  </div>
			</div>
		<!-- / Modal CONFIRM - Remove Artist from gig -->
	</form>
<!-- /Remove Artist - Confirm artist removal -->

<!-- Cancel Gig - Confirm gig cancellation - Explanation -->
	<form action="" method="POST" name="gigCancellation" enctype="multipart/form-data" id="gigCancellationForm">
		<!-- Modal Remove Artist from gig -->
			<div class="modal fade" id="gigCancellation" tabindex="-1" role="dialog" aria-labelledby="gigCancellation" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	<!-- Error Message Display -->
					    <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
					      	<p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
					    </div>
					<!-- /Error Message Display --> 

					<!-- Modal Title -->
					    <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Gig</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="gigCancelReset()">
					        	<span aria-hidden="true">&times;</span>
					        </button>
					    </div>
				    <!-- /Modal Title -->

				    <!-- Modal Body -->
				      	<div class="modal-body">
					    	<div class="form-group">
					    		<label for="vidTalent">Reason For Cancelling Gig</label>
								<textarea class="form-control mb-2" name="gigDetails_cancelReason" placeholder="Write a message..." wrap="" rows="4" aria-label="With textarea"></textarea>
								<input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
								<input type="hidden" name="gigDetails_gigStatus" value="cancelled">
								<input type="hidden" name="gigDetails_cancelDateTime" value="1">
								<input type="hidden" name="table" value="gigdetails">
							</div>
				      	</div>
				     <!-- /Modal Body -->

				    <!-- Modal Footer -->
				      	<div class="modal-footer">
				        	<button type="button" data-toggle="modal" data-target="#confirmGigCancel" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Submit</button>
				        	<button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="gigCancelReset()">Cancel</button>
				      	</div>
				    <!-- /Modal Footer -->
			    </div>
			  </div>
			</div>
		<!-- / Modal Remove Artist from gig -->

		<!-- Modal CONFIRM - Cancel Gig -->
			<div class="modal fade" id="confirmGigCancel" tabindex="-1" role="dialog" aria-labelledby="confirmGigCancel" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
					<!-- Modal Title -->
					    <div class="modal-header">
					        <h6 class="modal-title" id="exampleModalLongTitle">Confirm Gig Cancellation</h6>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="gigCancelReset()">
					        	<span aria-hidden="true">&times;</span>
					        </button>
					    </div>
				    <!-- /Modal Title -->

			      	<!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
				      	<div class="modal-body">
					    	<div class="form-group">
					    		<p>Are you sure you want to cancel the gig.  This action can't be undone.</p>
					    	</div>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="submit" class="btn btn-gs" id="confGigCanc" data-dismiss="modal" aria-label="Close">Confirm</button>
				        	<button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="gigCancelReset()">Cancel</button>
				      	</div>
			      	
			    </div>
			  </div>
			</div>
		<!-- / Modal CONFIRM - Cancel Gig -->
	</form>
<!-- /Cancel Gig - Confirm gig cancellation - Explanation -->

<!-- Play MP3 Uploads -->
	<div class="modal fade" id="playMP3" tabindex="-1" role="dialog" aria-labelledby="playMP3" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Modal Title -->
			    <div class="modal-header">
			        <h6 class="modal-title" id="exampleModalLongTitle">MP3 Upload</h6>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Modal Title -->

	      	<div class="modal-body">
		    	<div class="form-group">
		    		<!-- Insert to your webpage where you want to display the audio player -->
					   <div id="amazingaudioplayer-1" style="display:block;position:relative;width:100%;max-width:300px;height:auto;margin:0px auto 15px;">
					        <ul class="amazingaudioplayer-audios" style="display:none;">
					        	<?php 	
					        		
									if(!empty($getGigMusic)) {

										foreach($getGigMusic as $currentMusic) {
											if($currentMusic['gigMusic_songName'] != '' && $currentMusic['gigMusic_songMp3Path'] != '') {
												var_dump($currentMusic['gigMusic_songMp3Path']);
												echo '<li class="songTitle" firstaudioid="1" data-artist="" data-title="' . $currentMusic['gigMusic_songName'] . '" data-album="" data-info="" data-image="../audios/circular GS Sticker NoLink.png" data-duration="">';
												echo '<div class="amazingaudioplayer-source" data-src="' . $currentMusic['gigMusic_songMp3Path'] . '" data-type="audio/mpeg" />';
												echo ' </li>';
					        				} 
					        			}	
					        		}
					        	?>
					       
					        </ul>
					    </div>
					<!-- End of body section HTML codes -->

	 				<button class="keepRequest stopAudio" data-dismiss="modal" aria-label="Close">Close</button>
		    	</div>
	      	</div>
	    </div>
	  </div>
	</div>
<!-- /Play MP3 Uploads -->

<!-- Modal for artist selection from a user's subscription list -->
	<div class="modal fade" id="artistSubscriptions" tabindex="-1" role="dialog" aria-labelledby="artistSubscriptions" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Modal Title -->
			    <div class="modal-header">
			        <h6 class="modal-title" id="exampleModalLongTitle">Select an Artist</h6>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Modal Title -->

	      	<div class="modal-body">
		    	<div class="form-group">
		    		<form action="" method="post" name="addSubArt" id="addSubArt" class="">
		    			<?php foreach($subscriptionsList as $sub){?>
		    			<div class="container" style="font-size:14px">
		    				<ul style="list-style:none">
		    					<li>
		    						<?php 
		    							$j = 0;
	    								foreach($getGigArtists as $artistMatch){
		    								if($artistMatch['gigArtists_userId'] == $sub['iRollID']){
		    									$j++;
		    								}
		    							}
		    						?>
		    						<input class="subArtists"<?php if($j > 0){echo 'disabled';}?> type="radio" name="gigArtists_userId" value="<?php echo $sub['iRollID'];?>">
		    						<label>
		    							<?php 
			    							if($j > 0){
		    									echo '<del>' . $sub['sName'] . '</del>';
		    								}
		    								else{
		    									echo $sub['sName'];
		    								}
		    							?>
		    						</label>
									<input type="hidden" name="<?php echo $sub['iRollID'];?>[gigArtists_name]" value="<?php echo $sub['sName'];?>">
									<input type="hidden" name="<?php echo $sub['iRollID'];?>[gigArtists_email]" value="<?php echo $sub['sEmailID'];?>">
									<input type="hidden" name="<?php echo $sub['iRollID'];?>[gigArtists_phone]" value="">

		    						<ul class="d-none subTalList" id="talList-<?php echo $sub['iRollID'];?>" style="list-style:none">
		    							<?php
		    								foreach($subscripTalent as $index => $indivSub){
		    									if($index == $sub['iRollID']){
		    										foreach($indivSub as $talents){
														echo '<li style="font-size: 12px">';
							    						echo '	<input class="subTals" type="radio" name="' . $sub['iRollID'] . '[gigArtists_tal]" value="' . $talents['talent'] . '">'; //
							    						echo '	<lable>' . $talents['talent'] . '</label>';
							    						echo '</li>';
													}
		    									}
											}
		    							?>
			    					</ul>
		    					</li>
		    				</ul>
		    			</div>
		    			<?php }?>

						<input type="hidden" name="gigId" value="<?php echo $gigId;?>">
		    			<button type="submit" class="stopAudio" onclick="sendSubArt()" data-dismiss="modal" aria-label="Close">Add Artist</button>
	 					<button class="keepRequest stopAudio" data-dismiss="modal" aria-label="Close">Close</button>
		    		</form>
		    		
		    	</div>
	      	</div>
	    </div>
	  </div>
	</div>
<!-- /Modal for artist selection from a user's subscription list -->
<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
	/**************************************** Add artist from subscription List *********************/
		$('.subArtists').click(function(){
			console.log($(this).val());
			var artistId = $(this).val();
			
			$('.subTalList').addClass('d-none');
			$('.subTals').prop('checked', false);
			$('#talList-'+artistId).removeClass('d-none');
		});
		function sendSubArt(){
			var subArtForm = document.forms.namedItem('addSubArt');
			var gigid = $('input[name=gigId]').val(); 
			var subArtDataForm = new FormData(subArtForm);
			// console.log(subArtDataForm);
			subArtDataForm.append('table','gigartists');
			subArtDataForm.append('form', 'addSubArt');
			var addSubArt = new XMLHttpRequest(); 
			addSubArt.onreadystatechange = function(){
				if(addSubArt.readyState == 4 && addSubArt.status == 200){
					console.log(addSubArt.responseText);
					$('.subTalList').addClass('d-none');
					document.getElementById('addSubArt').reset(); 
					window.location = "gigform.php?gigID="+gigid;
				}
			}
			addSubArt.open('POST','gigformsubmit');
			addSubArt.send(subArtDataForm);
		}

	/**************************************** Add artist from subscription List *********************/


	/********************************** Artist has viewed new gig ***********************************/
		var artView = $('input[name=artistViewed]').val(); 
		if(artView == '1'){
			var gigid = $('input[name=gigId]').val(); 
			var artistID = $('input[name=artistUserId]').val();
			var viewStatus = '1';
			// console.log(artView+' '+gigid);

			var viewStatusForm = new FormData(); 
			viewStatusForm.append('gigId',gigid);
			viewStatusForm.append('gigArtists_userId', artistID);
			viewStatusForm.append('artistViewed','1');
			viewStatusForm.append('table','gigartists');

			var artistViewed = new XMLHttpRequest();
			artistViewed.onreadystatechange = function(){
				if(artistViewed.readyState == 4 && artistViewed.status == 200){
					console.log(artistViewed.responseText);
				}
			}
			artistViewed.open('POST', 'gigformsubmit');
			artistViewed.send(viewStatusForm); 
		}
		
		
		
	/********************************** END - Artist has viewed new gig ***********************************/

	function showManTal(){
		$('#collapseExample').collapse('show');
	}
	function hideManTal(){
		$('#collapseExample').collapse('hide');
		$('#test').reset();
		// document.getElementsByName('gigDetails_gigManTal')[0].reset();
	}

	/**************************************** Date and Time Picker plugin JS ***************************/
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
			 	format: "YYYY-MM-DD",
			 	defaultDate: false,
			 	minDate: dat,
			 	//minDate: moment(),
			 	maxDate: moment().add(1,'year'),
			 	//useCurrent: true, 
			 	allowInputToggle: true
			 });
			$("#datetimepicker3").datetimepicker({
		        format: "LT",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });	
		    $("#datetimepicker4").datetimepicker({
		        format: "LT",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });	
		    $("#datetimepicker5").datetimepicker({
		        format: "LT",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });	
		});
	/************************************** END - Date and Time Picker plugin JS ************************/

	/*************************************** Cancel entire gig ******************************************/ 
		/* Reset the canel form when cancel button is clicked */
			function gigCancelReset() {
				document.getElementById('gigCancellationForm').reset();
			}

		/* Send gig cancellation to gigform submit page */
			$('#confGigCanc').click(function(event){
				event.preventDefault();

				var cancelForm = document.forms.namedItem('gigCancellation');
				var cancGigFormData = new FormData(cancelForm); 
				var gigCancellation = new XMLHttpRequest();
				gigCancellation.onreadystatechange = function(){
					if(gigCancellation.readyState == 4 && gigCancellation.status == 200){
						console.log(gigCancellation.responseText);
						if(gigCancellation.responseText == 'updated'){
							//reload gigform.php page
							var gigid = $('input[name=gigId]').val(); 
							window.location = "gigform.php?gigID="+gigid;
						}
					}
				}
				gigCancellation.open('POST', 'gigformsubmit');
				gigCancellation.send(cancGigFormData);

			});
		/* END - Send gig cancellation to gigform submit page */
	/**************************************** End -  Cancel entire gig *************************************/ 

	/***************************** Front End Form Validation - form submission *****************************/
		(function() {
		  'use strict';
		  window.addEventListener('load', function() {
		    // Fetch all the forms we want to apply custom Bootstrap validation styles to
		    var forms = document.getElementsByClassName('needs-validation');

		    $('.getStatus').click(function(event){
		    	$('.getStatus').removeClass('submit-action');
		    	$(this).addClass('submit-action');
		    	// console.log($('.submit-action').attr('id'));
		    });

		    // Loop over them and prevent submission
		    var validation = Array.prototype.filter.call(forms, function(form) {
			    form.addEventListener('submit', function(event) {
			    	
			        if (form.checkValidity() === false) {
			          event.preventDefault();
			          event.stopPropagation();
			          console.log('testing');
			        }
			        else{
			        	event.preventDefault();
			        	
			        	var table = form.name;
			        	console.log(table);
			        	if(table == 'addSubArt'){
			        		table = 'gigartists';
			        	}
			        	var form1 = document.forms.namedItem(table);
			        	var formData1 = new FormData(form1);
			        	formData1.append('table',table);

			        	if(table == 'gigdetails'){
			        		var gigStatus = $('.submit-action').attr('id');
			        		if(gigStatus == 'createGig'){
			        			var gigDetails_formStatus = 'submitted';
			        			formData1.append('gigDetails_formStatus',gigDetails_formStatus);
			        		}
			        		if(gigStatus == 'saveGig'){
			        			var gigDetails_formStatus = 'saved';
			        			formData1.append('gigDetails_formStatus',gigDetails_formStatus);
			        		}
			        		// if(gigStatus == 'deleteSavedGig'){
			        		// 	var gigDetails_formStatus = 'deleted';
			        		// }
			        		
			        		//Create XMLHttpRequest to submit form 
				        		var formRequest1 = new XMLHttpRequest(); 
				        		formRequest1.onreadystatechange = function(){
				        			if(formRequest1.status == 200 && formRequest1.readyState == 4){
				        				console.log(formRequest1.responseText);
				        				if(formRequest1.responseText == 'inserted'){
				        					var gigid = $('input[name=gigId]').val(); 
				        					window.location = "gigform.php?gigID="+gigid;	
				        				}
				        			}
				        		}
				        		formRequest1.open('POST','gigformsubmit');
				        		formRequest1.send(formData1);
			        	}
			        	else{
			        		if(table == 'gigartists' || table == 'addSong' || table == 'removeSong' || table == 'gigrequests'){
			        			//console.log('Tehst beh');
			        			//Check for gigcreated marker - if true allow submission of these forms
			        			var gigid = $('input[name=gigId]').val(); 
			        			formData1.append('gigId',gigid);

			        			var formRequest1 = new XMLHttpRequest(); 
				        		formRequest1.onreadystatechange = function(){
				        			if(formRequest1.status == 200 && formRequest1.readyState == 4){
				        				console.log(formRequest1.responseText);
				        				if(formRequest1.responseText == 'inserted' || formRequest1.responseText == 'deleted'){
				        					// document.getElementById('gigrequests').reset();
				        					window.location = "gigform.php?gigID="+gigid;	
				        				}
				        			}
				        		}
				        		var serverUploadProgress = document.querySelector('.serverUpload');
							formRequest1.upload.addEventListener('progress', function(e){
					    			// _progress.style.width = Math.ceil((e.loaded/e.total) * 100) + '%';
					    			console.log('loaded: '+e.loaded+' and Total: '+e.total+'loade/total: '+(Math.ceil((e.loaded/e.total) * 100) + '%'));
					    			var percentLoaded = Math.ceil((e.loaded/e.total) * 100); 
					    			if (percentLoaded <= 100) {
					        			serverUploadProgress.style.width = percentLoaded + '%';
					        			serverUploadProgress.textContent = percentLoaded + '%';
					    			}
					    			//else if(percentLoaded == 100){
								//	console.log('file Uploaded');
					    			//}
							}, false);
							
				        		formRequest1.open('POST','gigformsubmit');
				        		formRequest1.send(formData1);
			        		}
			        	}
			        }
					form.classList.add('was-validated');
			    }, false);
		    });
		  }, false);
		})();
	/*********************************** END - Front End Form Validation ***********************************/

	/******************************* Requested-Artist Response Handler *************************************/
		/* Send Gig Artist's Response to the gigartists table in the database */
			$('.artistAction').click(function(event){
				event.preventDefault();
				var artistAction = $(this).attr('id');
				var gigID = $('input[name=gigId]').val();
				var artistID = $('input[name=artistUserId]').val();
				
				var artResponseForm = new FormData(); 
				artResponseForm.append('gigId',gigID);
				artResponseForm.append('gigArtists_userId',artistID);
				artResponseForm.append('gigArtists_artistStatus',artistAction);
				artResponseForm.append('table', 'gigartists');


				var artistResponse = new XMLHttpRequest();
				artistResponse.onreadystatechange = function(){
					if(artistResponse.status == 200 && artistResponse.readyState == 4){
						console.log(artistResponse.responseText);
						if(artistResponse.responseText == 'updated'){
							location.reload(); 
						}
					}
				}
				//artistResponse.open('GET', 'gigformsubmit.php?gigId='+gigID+'&gigArtists_userId='+artistID+'&gigArtists_artistStatus='+artistAction);
				artistResponse.open('POST', 'gigformsubmit');
				artistResponse.send(artResponseForm);

			});
		/* END - Send Gig Artist's Response to the gigartists table in the database */
	/******************************* END - Requested-Artist Response Handler *******************************/
	
	/***************************************** Music Info Section ******************************************/
		$('.sendMusic').click(function(event){
			event.preventDefault(); 
			var musicForm = document.forms.namedItem('');

		});

		/* MP3 Player Functionality */

		/* MP3 Player Functionality */
	/************************************** END - Music Info Section ***************************************/
	/************************************************ Music Mp3 Upload Progress Bar ************************************************/

		var reader;
		//var progress = document.querySelector('.percent');

		/**** Define Functions ****/

			// Abort the file read 
				function abortRead() {
					reader.abort();
				}

								// Handle a file read error 
									 function errorHandler(evt) {
									    switch(evt.target.error.code) {
									      case evt.target.error.NOT_FOUND_ERR:
									        alert('File Not Found!');
									        break;
									      case evt.target.error.NOT_READABLE_ERR:
									        alert('File is not readable');
									        break;
									      case evt.target.error.ABORT_ERR:
									        break; // noop
									      default:
									        alert('An error occurred reading this file.');
									    };
									  }	

								// Update progress bar when file read has made progress
									function updateProgress(evt) {
									    // evt is an ProgressEvent.
									    if (evt.lengthComputable) {
									      var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
									      // Increase the progress bar length.
									      if (percentLoaded < 100) {
									      //  progress.style.width = percentLoaded + '%';
									        //progress.textContent = percentLoaded + '%';
									      }
									    }
									  }

								// Handle the selected file 
									function handleFileSelect1(evt) {
										var file = evt.target.files[0];
									    // Reset progress indicator on new file selection.
									    //progress.style.width = '0%';
									    //progress.textContent = '0%';

									    reader = new FileReader();
									    reader.onerror = errorHandler;
									    console.log(reader.onprogress);
									    console.log(reader);
									    reader.onprogress = updateProgress;
									    // reader.onabort = function(e) {
									    //   alert('File read cancelled');
									    // };
									    reader.onloadstart = function(e){
									      // document.getElementById('progress_bar').className = 'loading';
									    };
									   //  reader.onload = function(e) {
									   //    // Ensure that the progress bar displays 100% at the end.
									   //    progress.style.width = '100%';
									   //    progress.textContent = '100%';
									   //    // setTimeout("document.getElementById('progress_bar').className='';", 2000);
									   //    if(e.type.match('video.*')){
									   //    	console.log('test mime type');
								 			// 	/* Render Video Name */
									 		// 		document.getElementById('show-vid-name').innerHTML = escape(e.name);
								 			// }	
								 			// else{
								 			// 	console.log(e);
								 			// }
									   //  }
									    reader.onload = (function(currentFile) {
									    	return function(e){
									    		// Ensure that the progress bar displays 100% at the end.
										     	 //progress.style.width = '100%';
										     	 //progress.textContent = '100%';
										     	 // setTimeout("document.getElementById('progress_bar').className='';", 2000);
										      	if(currentFile.type.match('audio.*')){
									 				/* Render Video Name */
										 				document.getElementById('show-musFile-name').innerHTML = escape(currentFile.name);
									 			}	
									 			else{
									 				console.log('Please upload a audio file.');
									 			}
									    	}
									    })(file);

									    // Read in the video file as a binary string.
									    reader.readAsBinaryString(evt.target.files[0]);
									}	  	
							/* END - Define Functions */

							/* Access Video FIle data */
							if($('#musicFile').length){
								document.getElementById('musicFile').addEventListener('change', handleFileSelect1, false);
								console.log('id length: '+$('#musicFile').length); 
							}

						/********************************************* END - Video Upload Progress Bar *********************************************/


	/**************************************** Artist Info Section ******************************************/
		/* Send Artists Emails */
			$('.getEmailInfo').click(function(event){
				/* Get Artist email info */
					var artistName = $(this).attr('name');
					var artistEmail = $(this).attr('email');
					var artistID = $(this).attr('artistid');
					var artistTalent = $(this).attr('artistTal');
					
				/* Insert artist email info into modal */
					$('input[name=artistName]').val(artistName);
					$('input[name=artistEmail]').val(artistEmail);
					$('input[name=artistID]').val(artistID);
					$('#artistName-emailModal').text(artistName);
					$('#artistEmail-emailModal').text(artistEmail);
					$('input[name=receiverTalent]').val(artistTalent);
			});

			/* Send Email Content via XMLHttpRequest */
				function sendEmail(){
					var emailForm = document.forms.namedItem('emailArtists');
					var emailFormData = new FormData(emailForm);
					var sendEmailRequest = new XMLHttpRequest(); 
					sendEmailRequest.onreadystatechange = function(){
						if(sendEmailRequest.status == 200 && sendEmailRequest.readyState == 4){
							console.log(sendEmailRequest.responseText);
							document.getElementById('emailArtistForm').reset();
						}
					}
					sendEmailRequest.open('POST','sendEmail');
					sendEmailRequest.send(emailFormData);
				}
			/* END - Send Email Content via XMLHttpRequest */

			/* Reset the email forma */
				function emailReset(){
					document.getElementById('emailArtistForm').reset();
				}
			/* END - Reset the email forma */
		/* END - Send Artists Emails */

		/* Cancel Artist */
			/* Add class to Cancel Anchor when clicked - this helps identify artist Id */
				$('.cancelArt').click(function(event){
					$('.cancelArt').removeClass('active');
					$(this).addClass('active')
				});

			/* Reset Form when artist removal is cancelled */
				function formReset(){
					document.getElementById('artistRemovalForm').reset();
				}

			$('#confRemoval').click(function(event){
				event.preventDefault(); 

				/* Define Variables - create new FormData object */
					var artistID = $('.active').attr('artistID');
					var form2 = document.forms.namedItem("artistRemoval");
					var formData = new FormData(form2);
					formData.append('gigArtists_userId',artistID);

				/* Create New XMLHttpRequest */	
					var removeArtist = new XMLHttpRequest();
					removeArtist.onreadystatechange = function(){
						if(removeArtist.readyState == 4 && removeArtist.status == 200){
							var text = removeArtist.responseText;
							var trimText = removeArtist.responseText.trim(); 
							console.log(trimText);
							if(trimText == 'cancelled'){
								/* reset the form */
									document.getElementById('artistRemovalForm').reset();
									
								/* Disable the cancel button for that artist - Change artist status */
									$('.active').parent().text('Cancel');	

								/* Change the artist status to cancel */
									$('#statusChange'+artistID).text(trimText);
							}
						}
					}
					removeArtist.open('POST', 'xmlhttprequest/findArtist');
					removeArtist.send(formData);
			});
		/* END - Cancel Artist */

		/* Find Artist using email address */
			function findArtistFunction(){ 

				var artistEmail = $('input[name=artistEmailSearch]').val();
				var currentUserEmail = $('input[name=currentUserEmail]').val(); 

				/* Hide error message when find artist button is clicked */
					document.getElementById('noResults').innerHTML = '';

				/* Check if searched email belongs to a current gig artist */
					var artistExists = 0; 
					$( ".currentGigArtists" ).each(function( index ) {
					  if(artistEmail == $( this ).val()){
					  	artistExists = 1;
					  }
					});
				/* END - Check if searched email belongs to a current gig artist */

				if(artistEmail != ''){
					if(artistEmail == currentUserEmail){
						/* Hide the artist's info and add form if found in the database after search is initiated */
							$('div.artist-add').addClass('d-none');
						/* END - Hide the artist's info and add form if found in the database after search is initiated */

						$('#noResults').text('OOPS!!!  You tried to book youself ;-)');
					}
					else{
						if(artistExists){
							/* Hide the artist's info and add form if found in the database after search is initiated */
								$('div.artist-add').addClass('d-none');
							/* END - Hide the artist's info and add form if found in the database after search is initiated */

							$('#noResults').text('This artist is already booked, pending, or cancelled for this current gig.');
						}
						else{
							var findArtist = new XMLHttpRequest();
							findArtist.onreadystatechange = function(){
								if(findArtist.status == 200 && findArtist.readyState == 4){
									var text = findArtist.responseText;
									var trimText = text.trim(); 
									console.log(text);
									
									if(trimText == 'noResult'){
										$('#noResults').html('There are no Artists with this Email Address');
									}
									else{

										$('input[name=artistEmailSearch]').val('');

										/* Define Variables from returned xml values */	
											var parser = new DOMParser();
											var xmlDoc = parser.parseFromString(text,"text/xml");
											var loginid = xmlDoc.getElementsByTagName('id')[0].childNodes[0].nodeValue; 
											var firstname = xmlDoc.getElementsByTagName('fname')[0].childNodes[0].nodeValue; 
											var lastname = xmlDoc.getElementsByTagName('lname')[0].childNodes[0].nodeValue; 
											var fullName = firstname+' '+lastname;
											var userType = xmlDoc.getElementsByTagName('usertype')[0].childNodes[0].nodeValue; 
											var phone = xmlDoc.getElementsByTagName('phone')[0].childNodes[0].nodeValue
											var talent = xmlDoc.getElementsByTagName('talent')[0].childNodes[0].nodeValue; 
											var talNumb = xmlDoc.getElementsByTagName('talnumb')[0].childNodes[0].nodeValue;
											var tableRow = document.getElementById('talRemove');
										/* END - Define Variables from returned xml values */
										console.log(loginid);
										/* Dynamically assign the searched artist info to the hidden form inputs */
											$('input[name=gigArtists_name]').val(fullName);
											$('input[name=gigArtists_userId]').val(loginid);
											$('input[name=gigArtists_email]').val(artistEmail);
											$('input[name=gigArtists_phone]').val(phone);
											$('#searchedArttist-name').text(fullName);
											$('#searchedArttist-email').text(artistEmail);
											$('#searchedArttist-phone').text(phone);
										/* END - Dynamically assign the searched artist info to the hidden form inputs */
										console.log(xmlDoc);
										/* Dynamically create the talent radio section based on artist */
											var talentSect = '';
											if(talNumb > 1){
												for(var i = 0;i<talNumb;i++){
													talentSect += '<div class="form-check">';
													talentSect +=   '<input class="form-check-input" type="radio" name="gigArtists_tal" value="'+xmlDoc.getElementsByTagName('talent')[i].childNodes[0].nodeValue+'" required>';
													talentSect +=   '<label class="form-check-label" for="exampleRadios1">'+xmlDoc.getElementsByTagName('talent')[i].childNodes[0].nodeValue+'</label>';
													talentSect += '</div>';
												}
											}
											else{
												talentSect += '<div class="form-check">';
												talentSect +=   '<input class="form-check-input" type="radio" name="gigArtists_tal" value="'+xmlDoc.getElementsByTagName('talent')[0].childNodes[0].nodeValue+'" required>';
												talentSect +=   '<label class="form-check-label" for="exampleRadios1">'+xmlDoc.getElementsByTagName('talent')[0].childNodes[0].nodeValue+'</label>';
												talentSect += '</div>';
											}
											$('#appendTalent').html(talentSect);
										/* END - Dynamically create the talent radio section based on artist */

										/* Show the artist's info if found in the database after search is initiated */
											$('div.artist-add').removeClass('d-none');
										/* END - Show the artist's info if found in the database after search is initiated */
									}
								}
							}
							findArtist.open('GET', 'xmlhttprequest/findArtist.php?email='+artistEmail);
							findArtist.send();
						}
					}
				}
				else{
					/* Hide the artist's info and add form if found in the database after search is initiated */
						$('div.artist-add').addClass('d-none');
					/* END - Hide the artist's info and add form if found in the database after search is initiated */

					$('#noResults').text('Please enter an email address!!!');
				}
			}
		/* END - Find Artist using email address */

		/* Reset artist form after query is returned */
			function artistReset(){
				/* Hide the artist's info and add form if found in the database after search is initiated */
					$('div.artist-add').addClass('d-none');
				/* END - Hide the artist's info and add form if found in the database after search is initiated */

				$('input[name=gigArtists_name]').val('');
				$('input[name=gigArtists_userId]').val('');
				$('input[name=gigArtists_email]').val('');
				$('input[name=gigArtists_phone]').val('');
				$('#searchedArttist-name').text('');
				$('#searchedArttist-email').text('');
				$('#searchedArttist-phone').text('');
			}
		/* END - Reset artist form after query is returned */
	/***************************** END - Artist Info Section ******************************************/
		
</script>
