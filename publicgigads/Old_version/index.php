<?php 
	/* Public Gigs */

	$backGround = 'bg2';
	$page = 'Pending Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	if($currentUserID == ''){
		echo '<input type="hidden" name="loggedIn" value="false">';
		// echo '<script>window.location = "'. URL .'index.php";</script>';
		// exit;
	}
	else{
		/* Get current user/gig manager's info from the usermaster table */
			$userInfo = $obj->fetchRow('usermaster', 'iLoginID = ' . $currentUserID, $db);
			$manFullName = $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];
			$manEmail = $userInfo['sContactEmailID'];
			$manPhone = $userInfo['sContactNumber'];
      // echo '<pre>';
      // var_dump($userInfo);exit;
	}

	if($_GET['gigID']){
		$gigId = trim($_GET['gigID']);
		$updating = true;
    $emptyArray = array();

		/* Query for the current gigs info */
			try{
				$tablea = 'postedgigsmaster';
				$columnsArraya = array('postedgigsmaster.*');
				$paramArraya['postedgigsmaster.gigId']['='] = $gigId;
				$getGigDetailsResults = pdoQuery($tablea,$columnsArraya,$paramArraya,$orderByParama,$innerJoinArraya,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
				$getGigDetails = $getGigDetailsResults[0];
		
				$tal_need_query = 'SELECT postedgigneededtalentmaster.artistType,postedgigneededtalentmaster.tal_tracker_id, postedgigneededtalentmaster.tal_pay, giftmaster.sGiftName, usermaster.sFirstName,usermaster.iLoginID
								   FROM postedgigneededtalentmaster
								   INNER JOIN giftmaster ON giftmaster.iGiftID = postedgigneededtalentmaster.artistType
								   LEFT JOIN usermaster ON usermaster.iLoginID = postedgigneededtalentmaster.artist_selected
								   WHERE postedgigneededtalentmaster.gigId = ?
								   ORDER BY giftmaster.sGiftName
								   ';

				try{
					$get_talents  = $db->prepare($tal_need_query);
					$get_talents->bindParam(1,$gigId);
					$get_talents->execute();
					$tals_needed = $get_talents->fetchAll(PDO::FETCH_ASSOC);
				}	
				catch(Exception $e){
					echo $e; 
				}
			}
			catch(Exception $e){
				echo $e; 
			}
		/* Check if the gigID is valid and if current user is the creator of post*/
			if( count($getGigDetails) > 0){
					if($currentUserID != $getGigDetails['gigManLoginId']){
						$getGigDetails = '';
						echo '<script>window.location = "'. URL .'views/pubGigs.php?new=1&public=1";</script>';
						exit;
					}
			}
			else{
				$getGigDetails = '';
				echo '<script>window.location = "'. URL .'views/pubGigs.php?new=1&public=1";</script>';
				exit;
			}
	}
	else{
		/* Create a Unique Gig Id */
			/*$gigManagerlName = $userInfo['sLastName'];
			$first4 = substr($gigManagerlName, 0, 4);
			$randSuffix = mt_rand(100, 100000);
			$randPrefix = mt_rand(100, 100000);
			$str = $randPrefix . $first4 . $randSuffix; 
			$gigId = bin2hex($str);*/
		/* END - Create a Unique Gig Id */
	}

	/* Get Event Types, Group types and Artist types */ 
		$fetchEvents = $db->query('SELECT eventtypes.sName,eventtypes.iEventID  FROM eventtypes'); 
		$EventList = $fetchEvents->fetchAll(PDO::FETCH_ASSOC);

		$fetchTalents = $db->query('SELECT giftmaster.sGiftName,giftmaster.iGiftID FROM giftmaster'); 
		$talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);

		$fetchGroupTypes = $db->query('SELECT grouptypemaster.id, grouptypemaster.sTypeName FROM grouptypemaster'); 
		$groupTypeList = $fetchGroupTypes->fetchAll(PDO::FETCH_ASSOC);
		
	/* Reduce $eventList & $talentList from a 2D to 1D array */
		foreach($EventList as $Ev) {
			$EventList1D[$Ev['iEventID']] = $Ev['sName'];
		}
		foreach($talentList as $tal) {
			$talentList1D[$tal['iGiftID']] = $tal['sGiftName'];
		}
		foreach($groupTypeList as $gType) {
			$groupTypeList1D[$gType['id']] = $gType['sTypeName'];
		}

		asort($talentList1D);
		asort($EventList1D);
		asort($groupTypeList1D);

?>
<style>.colon {color:red;}</style>
<form  action="<?php echo URL;?>publicgigads/ad_details.php" method="post" name="gigdetails" id="gigdetails" class="needs-validation mt-4 gigEdit pb-4 pt-2" table="gigdetails" novalidate>
	<div class="container bg-white mt-5 mb-3 px-md-5 py-3" style="max-width:900px;min-height:700px">
		
		<div class="container  text-center pb-3 mb-4 mb-0" style="border-bottom: 2px solid rgba(149,73,173,1)">
			<h4 class="text-gs">
				<?php 

					if($updating){
						echo 'Edit Posted Gig';
					}
					else{
						echo 'Post New Gig';
					}
				?>
			</h4>
		</div>

		<!-- Event Info -->
		<div class="container mt-2"> <!-- common section -->
			<h5 class="text-gs text-center text-md-left">Gig Info</h5>
			<div class="row p-0 pl-md-2">
				<div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Name<span class="colon">*</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="gigName" placeholder="Event Name" value="<?php echo $getGigDetails['gigName'];?>">
			    </div>
			    <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Type<span class="colon">*</span></label>
					<select class="custom-select dropdown form-control-sm" id="eventType" name="gigType" >
				       	<option value="">What Kind of Event?</option>
				       	<?php 
					    	foreach($EventList1D as $evID => $singleEv) {
					    		if(str_replace("_", "/", $singleEv) == $getGigDetails['gigType']){
					    			echo '<option selected value="' . str_replace("_", "/", $singleEv) . '" >' . str_replace("_", "/", $singleEv) . '</option>'; 
					    		}
					    		else{
					    			echo '<option value="' . str_replace("_", "/", $singleEv) . '" >' . str_replace("_", "/", $singleEv) . '</option>'; 
					    		}
					    	}
					    ?>
				    </select>
				</div>
			    <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Date<span class="colon">*</span></label>
					<div class="input-group date dateTime-input mb-2" id="datetimepicker2">
						<?php 
		                	$eventDate = date_create($getGigDetails['gigDate']);
						    $eventDate = date_format($eventDate, 'D, d M Y'); 
		                ?>
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
	               		<input type="text" class="mr-2 form-control form-control-sm clearDefault" name="gigDate" placeholder="Gig Date" value="<?php echo $getGigDetails['gigDate'];?>"/> 
		            </div>
			    </div>
			    <div class="col-12 col-md-7">
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Setup Time<span class="colon">*</span></label>
			    	<div class="input-group date dateTime-input" id="datetimepicker3">
			    		<?php 
			    			$setup = date_create($getGigDetails['setupTime']);
						    $setup = date_format($setup, "g:ia"); 
			    		?>
			    		<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-time"></span>
		                </span>
		                <input type="text" class="mr-2 form-control form-control-sm clearDefault" name="setupTime" placeholder="Setup Time" value="<?php if(!empty($getGigDetails['setupTime'])){ echo $setup;}?>"/> 
		            </div>
		        </div>
		        <div class="col-12 col-md-7">
		        	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Start Time<span class="colon">*</span></label>
			    	<div class="input-group date dateTime-input" id="datetimepicker4">
			    		<?php 
			    			$start = date_create($getGigDetails['startTime']);
						    $start = date_format($start, "g:ia"); 
			    		?>
			    		<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-time"></span>
		                </span>
		                <input type="text" class="mr-2 form-control form-control-sm clearDefault" name="startTime" placeholder="Start Time" value="<?php if(!empty($getGigDetails['startTime'])){ echo $start;}?>"/> 
		            </div>
		        </div>
		        <div class="col-12 col-md-7">
		        	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">End Time<span class="colon">*</span></label>
			    	<div class="input-group date dateTime-input" id="datetimepicker5">
			    		<?php 
			    			$end = date_create($getGigDetails['endTime']);
						    $end = date_format($end, "g:ia"); 
			    		?>
			    		 <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-time"></span>
		                </span>
		                <input type="text" class="mr-2 form-control form-control-sm clearDefault" name="endTime" placeholder="End Time" value="<?php if(!empty($getGigDetails['endTime'])){ echo $end;}?>"/> 
		            </div>
		        </div>
		        <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Public or Private Event<span class="colon">*</span> (<a href="#" data-toggle="popover" title="Popover title" data-content="Is your event open to the public?" style="font-size:.8em">what does this mean?</a>)</label>
					<select class="custom-select dropdown form-control-sm" id="privacy" name="gigPrivacy">
				       	<option value="">Privacy</option>
				       	<option <?php if($getGigDetails['gigPrivacy'] == 'pub'){echo 'selected';} ?> value="pub">Public</option>
				       	<option <?php if($getGigDetails['gigPrivacy'] == 'priv'){echo 'selected';} ?> value="priv">Private</option>
				    </select>
				</div>
				<!--<div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Make Post Public or Private<span class="colon">*</span> (<a href="#" style="font-size:.8em">what does this mean?</a>)</label>
					<select class="custom-select dropdown form-control-sm" id="post_privacy" name="isPostedStatus">
				       	<option value="">Privacy</option>
				       	<option <?php if($getGigDetails['isPostedStatus'] == '1'){echo 'selected';} ?> value="1">Public</option>
				       	<option <?php if($getGigDetails['isPostedStatus'] == '0'){echo 'selected';} ?> value="0">Private</option>
				    </select>
			    </div>
			</div> -->
			<div class="col-12 col-md-7">
				<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Contact Phone</label>
		    		<input type="text" class="form-control form-control-sm mb-2" placeholder="(xxx)-xxx-xxxx" name="gigManPhone" id="gigManPhone" value="<?php if($getGigDetails['gigManPhone']){echo phoneNumbDisplay($getGigDetails['gigManPhone']);}else{echo phoneNumbDisplay($manPhone);}?>">
			</div>
			<hr class="mt-4"> <!-- Page Divider -->
            </div>
		</div>
	<!-- /Event Info -->

	<!-- Artist Info -->
		<div class="container mt-2"> <!-- common section -->
			<h5 class="text-gs text-center text-md-left">Artist Info</h5>
			<div class="row pl-2">
				<!-- usertype -->
				<input type="hidden" name="userType" id="send_userType" value="">
				<div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Type of Artist Needed<span class="colon">*</span></label>
					<select class="custom-select dropdown form-control-sm" id="artistType" name="selectNeededTal" >
				       	<option value="">What Kind of Artist?</option>
				       	<?php
				       		if($getGigDetails['userType'] == 'group'){
				       			echo '<option selected value="groups">Groups</option>';
				       		}
				       		else{
				       			// echo '<option value="groups">Groups</option>';
						    	foreach($talentList1D as $talID => $singleTal) {
						    		if($talID == $getGigDetails['artistType']){
						    			echo '<option selected value="' . $talID . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
						    		}
						    		else{
						    			echo '<option value="' . $talID . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
						    		}
						    	}
						    }
					    ?>
				    </select>
				</div>

					<div class="col-12 col-md-7 mt-3 mt-lg-2 text-center" id="show_talents">
						<div class="row p-lg-2">
							<div class="col p-lg-2">
								<!-- <h5 class="" style="color: rgba(204,204,204,1)">No Artists Have Submitted Inquiries for this Gig!!!</h5> -->
								<table class="table" style="font-size:.8em">
									<thead>
										<th class="p-0">Talent(s)</th>
										<th class="p-0">Artist Selected</th>
										<th class="p-0">Artist Pay</th>
										<th class="p-0">Remove talent</th>
									</thead>
									<tbody id="talent_rows">
										<?php if(count($tals_needed) > 0){ foreach($tals_needed as $tals){//;var_dump($tals_needed);?>
											<tr>
												<td><?php echo str_replace("_", "/",$tals['sGiftName']);?></td>
												<td>
													<?php 
														if($tals['iLoginID'] !== NULL || $tals['iLoginID'] != ''){
															echo '<a class="text-gs" target="_blank" href="'. URL . 'views/artistprofile.php?artist=' . $tals['iLoginID'] . '">'.truncateStr($tals['sFirstName'], 15).'</a>';
														}
														else{
															echo 'N/A';
														}
													?>
												</td>
												<td class="text-center">
													<input class="mx-auto form-control form-control-sm p-0" style="height:20px; width:80px" type="text" placeholder="$0.00" name="talent[pay_current][<?php echo $tals['tal_tracker_id'];?>]" value="<?php if($tals['tal_pay'] > 0){echo CentsToDollars($tals['tal_pay']);}?>">
													<!-- <p class="m-0 p-0"><?php echo CentsToDollars($tals['tal_pay']);?></p> -->
												</td>
												<td>
													<a href="#" class="text-gs remove_needed_tal" selArtist="<?php echo $tals['iLoginID'];?>" talID="<?php echo $tals['artistType'];?>" talTracker="<?php echo $tals['tal_tracker_id'];?>">Remove</a>
												</td>
											</tr>
										<? }}?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

				<div class="col-12 col-md-7 <?php if($getGigDetails['userType'] != 'group'){echo 'd-none';}?>" id="groupTypeContainer">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Type of Group Needed<span class="colon">*</span></label>
					<select class="custom-select form-control-sm" name="groupType" id="groupType">
				       	<option value="0">What Type of Group?</option>
				       	<!-- <option value="all">All Groups</option> -->
				       	<?php 
					    	foreach($groupTypeList as $sType) {
					    		if($getGigDetails['groupType'] == $sType['id']){
						    		echo '<option selected value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
						    	}
						    	else{
						    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
						    	}
					    	}
					    ?>
				    </select>
				</div>
				<div class="col-12 col-md-7">
					<div id="ageDiv">
				  		<!-- Age: -->
						<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Minimum Age<span class="colon">*</span></label> 
					    <div class="row form-group">
						    <div class="col-12 col-sm-6 col-lg-4 mt-2">
						    	<?php 
						    		if(!empty($getGigDetails['dDOB1'])){ 
						    			$minAge = $getGigDetails['dDOB1']; //getAge($getGigDetails['dDOB1']);
						    		}
						    	?>
						      	<input type="text" class="form-control form-control-sm" name="dDOB1" placeholder="Min Age" value="<?php echo $minAge;?>">
						    </div>
						    <!-- <div class="col-12 col-sm-6 col-lg-4 mt-2">
						      <input type="text" class="form-control" name="dDOB2" placeholder="Max Age">
						    </div> -->
						</div>
						<div class="d-none" id="ageErr"></div>
					</div>
				</div>
				<div class="col-12 col-md-7">
		            <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Gender<span class="colon">*</span></label>
		            <select class="custom-select form-control-sm mb-2" name="sGender">
						<option value="">Gender</option>
						<option value="both" <?php if($getGigDetails['sGender'] == 'both'){echo 'selected';}?>>Both</option>
						<option value="male" <?php if($getGigDetails['sGender'] == 'male'){echo 'selected';}?> >Male</option>
						<option value="female"  <?php if($getGigDetails['sGender'] == 'female'){echo 'selected';}?>  >Female</option>
					</select>
				</div>
			</div>
			<hr class="mt-4"> <!-- Page Divider -->
		</div>
	<!-- /Artist Info -->

	<!-- Venue Info -->
		<div class="container mt-2"> <!-- common section -->
			<h5 class="text-gs text-center text-md-left">Venue Info</h5>
			<div class="row pl-2">
				<div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue Name</label>
					<input type="text" class="form-control form-control-sm mb-2" name="venueName" placeholder="Venue Name" value="<?php echo $getGigDetails['venueName'];?>">
			    </div>
			    <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue Address<span class="colon">*</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="venueAddress" placeholder="Venue Address" value="<?php echo $getGigDetails['venueAddress'];?>">
			    </div>
			    <!-- State -->
			     <?php 
			    	/* Fetch States */
						$cond = 'country_id = 231'; 
						$stateArray = $obj->fetchRowAll('states', $cond, $db);
					/* END - Fetch States */
			    ?>
			    <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue State<span class="colon">*</span></label>
		            <select class="custom-select dropdown"  name="venueState" id="venueState" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
				       	<option value="">State</option>
				       	<?php 
					    	foreach($stateArray as $evID => $state) {
					    		if(!empty($_GET['gigID'])){
					    			if($state['name'] == $getGigDetails['venueState']){
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
				</div>
			    <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zip Code<span class="colon">*</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="venueZip" id="venueZip" placeholder="Zipcode" value="<?php echo $getGigDetails['venueZip'];?>">
					<input type="hidden" name="venueStateShort" id="venueStateShort" value="">
					<input type="hidden" name="venueCity" id="venueCity" value="">
			    </div>
			    <div class="col-12 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Environment<span class="colon">*</span></label>
					<select class="custom-select dropdown form-control-sm" id="environment" name="venueEnvironment" >
				       	<option value="">Environment</option>
				       	<option <?php if($getGigDetails['venueEnvironment'] == 'indoor'){echo 'selected';} ?> value="indoor">Indoor</option>
				       	<option <?php if($getGigDetails['venueEnvironment'] == 'outdoor'){echo 'selected';} ?> value="outdoor">Outdoor</option>
				    </select>
				</div>
			</div>
			<hr class="mt-4"> <!-- Page Divider -->
		</div>
	<!-- /Venue Info -->


		<!-- General Gig Request for gigs poseted for public inquiry -->
			<div class="container mt-2"> <!-- common section -->
				<h5 class="text-gs">Additional Requests/Requirements</h5>
				<div class="row">
					<div class="col">
						<label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;">Gig Request</label>
						<textarea class="form-control mb-2" name="message" placeholder="Write a request, additional instructions, a set list, etc..." wrap="" rows="5" aria-label="With textarea"><?php echo $getGigDetails['message'];?></textarea>
					</div>
				</div>
			</div>
		<!-- /General Gig Request for gigs poseted for public inquiry -->
			
		<!-- gig manager loginid - gigDetails_gigManLoginId -->
			<input type="hidden" name="gigManLoginId" value="<?php echo $currentUserID;?>">
		<!-- gig manager name - gigDetails_gigManName -->
			<input type="hidden" name="gigManName" value="<?php echo $manFullName;?>">
		<!-- gig manager email - gigDetails_gigManEmail -->
			<input type="hidden" name="gigManEmail" value="<?php echo $manEmail; ?>">
		<!-- gig manager phone - gigDetails_gigManPhone -->
			<!-- <input type="hidden" name="gigManPhone" value="<?php echo $manPhone;?>"> -->

		<!-- if gig is being updated -->
		<?php 
			if($updating){
				echo '<input type="hidden" name="gigId" value="' . $gigId . '">';
				echo '<input type="hidden" name="update" value="true">';
				echo '<button class="btn btn-small btn-gs text-white getStatus" type="submit" get-modal="" id="updateGig">Update Gig</button>'; //id="postGig"
			}
			else{
				echo '<button class="btn btn-small btn-gs text-white getStatus" type="submit" id="postGig">Post Gig Ad</button>';
				// /<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
			}
		?>

		<div class="row text-center mt-3" id="zipErrContainer">
			<div class="col text-danger">
				<p class="error-message" id="zipError"></p>
			</div>
		</div>
	</div>
</form>

<!-- str cust id -->	
	<!--<input type="hidden" name="str_cust_id" value="<?php echo $userInfo['str_customerID'];?>">-->

<?php 
	/* Include the Modals page */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/publicgigads/phpBackend/indexModals.php');

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>

<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="<?php echo URL;?>js/additional-methods.js"></script> 
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>

<script src="https://js.stripe.com/v3/"></script>
<!-- <script src="<?php echo URL;?>node_modules/uniqid/index.js"></script> -->
<script src="<?php echo URL;?>publicgigads/js/indexJSFunctions.js?3"></script> 
<script src="<?php echo URL;?>node_modules/uuid/dist/umd/uuidv1.min.js"></script>
<script src="<?php echo URL;?>publicgigads/js/indexJS.js?33"></script> 




