<?php 
	
	/************************************* Profile Book Me Tab Content *****************************/

	/* Define Today's date for comparison */
	 	$hoy = date_create(date());
		$hoy = date_format($hoy, 'Y-m-d H:i:s');
?>

<!-- Book Me Container Header -->
	<?php 
		if($profGuest == 1){
			/* Get Event Types */ 
				$fetchEvents = $db->query('SELECT eventtypes.sName,eventtypes.iEventID  FROM eventtypes'); 
				$EventList = $fetchEvents->fetchAll(PDO::FETCH_ASSOC);

			/* Reduce $eventList from a 2D to 1D array */
				foreach($EventList as $Ev) {
					$EventList1D[$Ev['iEventID']] = $Ev['sName'];
				}
				asort($EventList1D);
	?>
			<!-- Book Me Determiner - Book for an existing gig or create a new gig -->
			<div class="container mt-3 choiceBook" id="bookme-choice" style="text-align:">
				<h6 class="text-gs">Book this Artist For: </h6>
				<div class="row my-3">
					<div class="col-12 col-sm-10 col-md-7 col-lg-6 text-center" style="margin: auto;">
						<button type="button" class="btn text-gs btn-lg bk-type p-5" style="display:block;margin:auto;border:1px solid rgba(149,73,173,.5);background-color:rgba(231,232,235,1);" id="exists">Existing Gig</button>
						<h6 class="mt-2" style="display:block">OR</h6>
						<button type="button" class="btn text-gs btn-lg bk-type p-5" style="display:block;margin:auto;border:1px solid rgba(149,73,173,.5);background-color:rgba(231,232,235,1);" id="new">New Gig</button>
					</div>
				</div>
				<hr class="my-1">
			</div>

	<?php
		}
		elseif($profOwner == 1){
			$query = 'SELECT gigartists.artistViewed, gigdetails.gigDetails_setupTime 
					  FROM gigartists 
					  INNER JOIN gigdetails on gigartists.gigId = gigdetails.gigId
					  WHERE gigartists.gigArtists_gigManCancelStatus = "active" AND gigartists.artistViewed = 0 AND gigartists.gigArtists_userId = ? AND gigdetails.gigDetails_gigStatus = "active" ';
			try{
				$newGigs = $db->prepare($query);
				$newGigs->bindParam(1, $artistUserID);
				$newGigs->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$newGig = $newGigs->fetchAll(PDO::FETCH_ASSOC);
			// echo '<pre>';
			// var_dump($newGig);
			foreach($newGig as $gig){
				if($gig['gigDetails_setupTime'] > $hoy){
					$currentGig[] = $gig;
				}
			}	
			$newGigCount = count($currentGig);

			echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You have <span class="text-gs">'. $newGigCount .'</span> new booking Requests.</h1></div>';

			/* Create Button to view new gig requests if $newGigCount > 0 */
				if($newGigCount > 0){
					echo '<div class="container text-center"><a href="'. URL .'views/listPendingGigs.php" class="btn btn-gs">View Requests</a></div>';
				}
			/* END - Create Button to view new gig requests if $newGigCount > 0 */
		}
		elseif($siteGuest == 1){
			echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Please Login To Book This Artist!!!</h1></div>';
		}
		else{
			echo '<div class="container mt-5 d-none text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Sorry we are have technical difficulties!!!  :-(</h1></div>';
		}
	?>
<!-- /Book Me Container Header -->

<div class="current-gig-options d-none exists">
<?php 

	//if($currentUserID > 0){
		// if($_GET['type'] == 'exists'){ 
			/* Check if the user has existing gigs in the database */
				$query = 'SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime,gigdetails.gigDetails_gigStatus
						  FROM gigdetails
						  WHERE gigdetails.gigDetails_gigManLoginId = ?';
				try{
					$gigsExist = $db->prepare($query);
					$gigsExist->bindParam(1,$currentUserID);
					$gigsExist->execute(); 
				}
				catch(Exception $e){
					echo $e; 
				}
				$gigResults = $gigsExist->fetchAll(PDO::FETCH_ASSOC);

			/* Ensure gigs have a status of active and are not expired */
				foreach($gigResults as $gigResult){
					if($gigResult['gigDetails_gigStatus'] == 'active' && $gigResult['gigDetails_setupTime'] > $hoy){
						$currentGigs[] = $gigResult;
					}
				}

			/***************** Check if this artist has already been requested for any of this user's current gigs ***************/
				for($i=0;$i<count($currentGigs);$i++){
					/* Return artists each of current user's gigs */
						$gigID = $currentGigs[$i]['gigId'];
						$query = 'SELECT gigartists.gigArtists_userId FROM gigartists WHERE gigId = ?';
						try{
							$getArtistList = $db->prepare($query);
							$getArtistList->bindParam(1,$gigID);
							$getArtistList->execute(); 
						}
						catch(Exception $e){
							echo $e; 
						}
						$artistList = $getArtistList->fetchAll(PDO::FETCH_ASSOC);
					/* END - Return artists each of current user's gigs */
					
					/* Flag gig if the artist being requested exists in the gigartists table for this gigId */
						foreach($artistList as $artist){
							if($artist['gigArtists_userId'] == $userRow['iLoginID']){
								$removeElement[] = $i; // FLAG
							}
						}
					/* END - Flag gig if the artist being requested exists in the gigartists table for this gigId */
				}	

				/* Remove the Gig that was flagged */
					foreach($removeElement as $j){
						unset($currentGigs[$j]);
					}
					/* Allow Numeric Indices to start at 0 and increase by 1 */
						$currentGigs = array_values($currentGigs);
			/*************** END - Check if this artist has already been requested for any of this user's current gigs ***************/

			/* Query database for eventypes and states */
				//$EventList1D = $obj->fetchRowAll('eventtypes','isActive=1');
				$states = $obj->fetchRowAll("states",'country_id = 231');  
			/* END - Query database for eventypes and states */

				if(empty($currentGigs)){
					echo '<h5 class="m-3" style="color: rgba(0,0,0,.3)">You Currently have No Gigs</h5>';
				}
				else{
?>
					<!-- Books Artist for existing gig -->
					<div class="container mt-3 mb-3 pb-3" style="border-bottom: 1px solid rgba(149,73,173,1);">
						<form action="gigReceive.php" method="POST" enctype="multipart" id="book4existing" name="book4existing">
							<h5 class="text-gs bookMe-subtitle">Book for an Existing Gig</h5>
							<?php for($n=0; $n<count($currentGigs); $n++){?>
								<div class="custom-control custom-checkbox">
								  <input type="radio" class="custom-control-input" id="customCheck<?php echo $n;?>" name="gigId" value="<?php echo $currentGigs[$n]['gigId']; ?>">
								  <label class="custom-control-label" for="customCheck<?php echo $n;?>"><?php echo $currentGigs[$n]['gigDetails_gigName']; ?></label>
								</div>
							<?php }?>
							<div class="row my-2">
								<div class="col-12 col-md-6 my-md-0 my-2">
						         	<select class="custom-select m-0 form-control-sm" name="gigartists[gigArtists_tal]">
										<option value="">Book this Artist As</option>
											<?php 
										    	//foreach($userRow['iGiftID']as $singleTal) {
										    	foreach($getTalents as $singleTal) {
										    		echo '<option value="' . $singleTal['talent'] . '" >' . str_replace("_", "/", $singleTal['talent']) . '</option>'; 
										    	}
										    ?>
									</select>
						        </div>
			   				</div>

							<!-- Depost Amount and Date -->
							<!--<h6 class="text-gs  mt-3">Deposit Amount and Date</h6>
							<div class="row mt-2 mb-4">
								<div class="col-12 col-md my-md-0 my-2">
									<label for="depAmount">Deposit Amount</label>
									<input class="form-control form-control-sm" type="text" name="gigartists[gigArtists_deposit]" placeholder="$ 0.00">
								</div>
								<div class="col-12 col-md my-md-0 my-2">
									<label for="datetimepicker5">Deposit Date</label>
									<div class="input-group date dateTime-input" id="datetimepicker6">
						                <input type="text" class="form-control form-control-sm" name="gigartists[gigArtists_depositDate]" placeholder="Deposit Date" value=""/> 
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
							</div>--><!-- /Depost Amount and Date -->

							<!-- Special Requests for the artist -->
								<h6 class="text-gs  mt-3">Special Requests</h6>
								<textarea class="form-control mb-2" name="gigrequests[gigRequests_message]" placeholder="Special Request For This Artist..." wrap="" rows="5" aria-label="With textarea"></textarea>
								<input type="hidden" name="gigrequests[gigRequests_artistUserId]" value="<?php echo $userRow['iLoginID'];?>"  table="gigrequests">
							<!-- /Special Requests for the artist -->

							<!-- Identify Source page - Remedy code programmed to handle gigartists inputs from the createGig.php page -->
								<input type="hidden" name="srcPage" value="artistProfile">
							<!-- /Identify Source page - Remedy code programmed to handle gigartists inputs from the createGig.php page -->

							<!-- Artist's Information -->
								<input type="hidden" name="gigartists[gigArtists_userId]" value="<?php echo $userRow['iLoginID'];?>">
								<input type="hidden" name="gigartists[gigArtists_name]" value="<?php echo $userRow['sFirstName'] . ' ' . $userRow['sLastName'];?>">
								<input type="hidden" name="gigartists[gigArtists_email]" value="<?php echo $userRow['sContactEmailID'];?>">
								<input type="hidden" name="gigartists[gigArtists_phone]" value="<?php echo $userRow['sContactNumber'];?>">
								<input type="hidden" name="gigartists[gigArtists_gigManCancelStatus]" value="active">
								<input type="hidden" name="gigartists[gigArtists_artistStatus]" value="pending">
							<!-- /Artist's Information -->

							<!-- Send Classification -->
								<!-- <input type="hidden" name="classification" value="update"> -->

							<button type="submit" class="btn btn-gs my-3" id="existGigNewArt">Send Request</button>
						</form>

						<!-- INsert into the following tables
								1. gigartists
								2. gigrequests
						-->
					</div><!-- /Books Artist for existing gig -->
<?php 		}
		/*} 
	  else {*/  

?>
</div>

<div class="current-gig-options d-none new" id="">
			<!-- Creates a New Gig -->
			<div class="container">
				<form action="" method="post" enctype="multipart/form-data" id="bookme-form" name="book4new">
					
					<!-- Gig Details-->
					<h6 class="text-gs mt-3">Gig Details</h6>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="gigdetails[gigDetails_gigName]" placeholder="Name of Event">
						</div>
					</div>
					<div class="row my-2">
				        <div class="col-12 col-md my-md-0 my-2">
					    	<div class="input-group date dateTime-input" id="datetimepicker2">
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigdetails[gigDetails_setupTime]" placeholder="Setup Time" value=""/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-time"></span>
				                </span>
				            </div>
				        </div>
				        <div class="col-12 col-md my-md-0 my-2">
					    	<div class="input-group date dateTime-input" id="datetimepicker3">
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigdetails[gigDetails_startTime]" placeholder="Start Time" value=""/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-time"></span>
				                </span>
				            </div>
				        </div>
				        <div class="col-12 col-md my-md-0 my-2">
					    	<div class="input-group date dateTime-input" id="datetimepicker4">
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigdetails[gigDetails_endTime]" placeholder="End Time" value=""/> 
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-time"></span>
				                </span>
				            </div>
				        </div>
				    </div>
				    <div class="row my-2">
				        <div class="col-12 col-md my-md-0 my-2">
							<div class="input-group date dateTime-input" id="datetimepicker1">
				                <input type="text" class="form-control form-control-sm clearDefault" name="gigdetails[gigDetails_gigDate]" placeholder="Event Date" value=""/> 
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
				         <div class="col-12 col-md my-md-0 my-2">
				         	<select class="custom-select m-0 form-control-sm" id="gigdetails_gigType" name="gigdetails[gigDetails_gigType]">
							<option>Event Type</option>
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
				        </div>
					</div>
					<div class="row my-2">
						<div class="col-12 col-md-6 my-md-0 my-2">
				         	<select class="custom-select m-0 form-control-sm" id="gigartists_tal" name="gigartists[gigartists_tal]">
								<option value="">Book this Artist As</option>
									<?php 
								    	foreach($userRow['iGiftID']as $singleTal) {
								    		echo '<option value="' . $singleTal . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
								    	}
								    ?>
							</select>
				        </div>
				    </div><!-- /Gig Details-->

					<!-- <hr class="my-1 bg-gs"> Page Divider -->

					<!-- Gig Location -->
					<h6 class="text-gs mt-3">Gig Location</h6>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="gigdetails[gigDetails_venueName]" placeholder="Name of Venue">
						</div>
					</div>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="gigdetails[gigDetails_venueAddress]" placeholder="Street Address">
						</div>
					</div>
					<div class="row my-2 p-0">
						<div class="col-12 col-md my-md-0 my-2">
							<select class="custom-select m-0 form-control-sm" name="gigdetails[gigDetails_venueState]" id="state">
								<option>State</option>
								<?php
									foreach($states as $state){
								?>
						      			<option value="<?php echo $state['id'];?>"><?php echo $state['name']; ?></option>
						      	<?php
						      		}
					      		?>
							</select>
						</div>
						<div class="col-12 col-md my-md-0 my-2">
							<input type="text" class="form-control form-control-sm" name="gigdetails[gigDetails_venueCity]" placeholder="city">
						</div>
						<div class="col-12 col-md my-md-0 my-2">
							<input class="form-control form-control-sm" type="text" name="gigdetails[gigDetails_venueZip]" placeholder="Zipcode">
						</div>
					</div>
					<div class="row my-2 p-0">
						<div class="col-12 col-md-6 my-md-0 my-2">
				         	<select class="custom-select m-0 form-control-sm" id="gigdetails_venueEnvironment" name="gigdetails[gigDetails_venueEnvironment]">
								<option>Indoor/Outdoor</option>
								<option value="indoor">Indoor</option>
								<option value="outdoor">Outdoor</option>
							</select>
				        </div>
					</div><!-- /Gig Location -->

					<!-- <hr class="my-1 bg-gs">  Page Divider -->

					<!-- Depost Amount and Date -->
					<!--<h6 class="text-gs  mt-3">Deposit Amount and Date</h6>
					<div class="row mt-2 mb-4">
						<div class="col-12 col-md my-md-0 my-2">
							<label for="depAmount">Deposit Amount</label>
							<input class="form-control form-control-sm" id="depAmount" type="text" name="gigartists[gigArtists_deposit]" placeholder="$ 0.00">
						</div>
						<div class="col-12 col-md my-md-0 my-2">
							<label for="datetimepicker5">Deposit Date</label>
							<div class="input-group date dateTime-input" id="datetimepicker5">
				                <input type="text" class="form-control form-control-sm" name="gigartists[gigArtists_depositDate]" placeholder="Deposit Date" value=""/> 
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
					</div>--><!-- /Depost Amount and Date -->

					<!-- Gig Privacy Status -->
					<h6 class="text-gs  mt-3">Gig Privacy Setting</h6>
					<div class="row my-2 p-0">
						<div class="col-12 col-md-6 my-md-0 my-2">
							<select class="custom-select m-0 form-control-sm" name="gigdetails[gigDetails_gigPrivacy]">
								<option>Privacy Setting</option>
								<option value="pub">Public Gig</option>
								<option value="priv">Private Gig</option>
							</select>
						</div>
					</div>

					<!-- /Gig Privacy Status -->

					<!-- Special Requests for the artist -->
						<h6 class="text-gs  mt-3">Special Requests</h6>
						<textarea class="form-control mb-2" name="gigrequests[gigRequests_message]" placeholder="Special Request For This Artist..." wrap="" rows="5" aria-label="With textarea"></textarea>
						<input type="hidden" name="gigrequests[gigRequests_artistUserId]" value="<?php echo $userRow['iLoginID'];?>">
					<!-- /Special Requests for the artist -->

					<!-- Create a Random HexaDecimal Gig Id - Using first 4 char of last name and --> 
						<?php
							$gigManagerName = $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];
							$first4 = substr($gigManagerName, 0, 4);
							$gigManLast = $first4;
							$randSuffix = mt_rand(100, 999);
							$str = $gigManLast . $randSuffix; 
							$gigId = bin2hex($str);
						?>
						<input type="hidden" name="gigId" value="<?php echo $gigId; ?>">
					<!-- /Random Gig Id Generator -->

					<!-- Gig Managers Information -->
						<input type="hidden" name="gigdetails[gigDetails_gigManLoginId]" value="<?php echo $currentUserID; ?>">
						<input type="hidden" name="gigdetails[gigDetails_gigManName]" value="<?php echo $gigManagerName; ?>">
						<input type="hidden" name="gigdetails[gigDetails_gigManEmail]" value="<?php echo $userInfo['sContactEmailID'];?>">
						<input type="hidden" name="gigdetails[gigDetails_gigManPhone]" value="<?php echo $userInfo['sContactNumber'];?>">
						<input type="hidden" name="gigdetails[gigDetails_gigManPlay]" value="0">
						<input type="hidden" name="gigdetails[gigDetails_creationDate]" value="<?php echo $currentDate; ?>">
					<!-- /Gig Managers Information -->

					<!-- Artists Information -->
						<input type="hidden" name="gigartists[gigArtists_userId]" value="<?php echo $userRow['iLoginID'];?>">
						<input type="hidden" name="gigartists[gigArtists_name]" value="<?php echo $userRow['sFirstName'] . ' ' . $userRow['sLastName'];?>">
						<input type="hidden" name="gigartists[gigArtists_email]" value="<?php echo $userRow['sContactEmailID'];?>">
						<input type="hidden" name="gigartists[gigArtists_phone]" value="<?php echo $userRow['sContactNumber'];?>">
						<input type="hidden" name="gigartists[gigArtists_gigManCancelStatus]" value="active">
						<input type="hidden" name="gigartists[gigArtists_artistStatus]" value="pending">
					<!-- /Artists Information -->
					
					<!-- Submission Status -->
						<input type="hidden" name="gigdetails[gigDetails_formStatus]" value="submitted">
					<!-- /Submission Status -->
					
					<!-- Identify Source page - Remedy code programmed to handle gigartists inputs from the createGig.php page -->
						<input type="hidden" name="srcPage" value="artistProfile">
					<!-- /Identify Source page - Remedy code programmed to handle gigartists inputs from the createGig.php page -->

					<!-- Create a Random Hexadecimal Gig Confirmation Id -->
						<!--<input type="hidden" name="gigstatus_status" value="active">-->

					<button type="submit" class="btn btn-gs my-3 form-control-sm" id="sendRequest">Send Request</button>
				</form>
				<div class="container text-success" id="submissionStatMessage"></div>
				<div class="container">
				
				</div>
			</div>
</div>

<!-- Modal Display - Video Removal Warning -->
	<div class="modal" data-backdrop="static" id="artistAdded" tabindex="-1" role="dialog" aria-labelledby="artistAdded" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Exit Modal -->
			   <!-- <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>-->
		    <!-- /Exit Modal -->

		      	<div class="modal-body">
			    	<div class="form-group text-success">
			    		<!--<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>-->
			    		<p>This Artist Has Been Added To Your Gig!</p>
					</div>
		      	</div>

		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-gs btn-sm text-gs" onclick="refreshPage()" data-dismiss="modal" >Close</button>
		      	</div>
	    </div>
	  </div>
	</div>
<!-- /Modal Display - Video Removal Warning -->


<script src="<?php echo URL;?>js/jquery-1.11.1.min.js"></script>
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
		        format: "YYYY-MM-DD",
			 	minDate: dat,
			 	//minDate: moment(),
			 	maxDate: moment().add(1,'year'),
			 	//useCurrent: true, 
			 	allowInputToggle: true
		    });		
		    $("#datetimepicker6").datetimepicker({
		        format: "YYYY-MM-DD",
			 	minDate: dat,
			 	//minDate: moment(),
			 	maxDate: moment().add(1,'year'),
			 	//useCurrent: true, 
			 	allowInputToggle: true
		    });		
		});
	/* END - Date and Time Picker plugin JS */

	/* Send the New Gig form to database from Artist Profile page */
		var formExistingGig1 = document.forms.namedItem("book4new");
		formExistingGig1.addEventListener('submit', function(event){
			var userID1 = $('.userID').val();
			var existGigData1 = new FormData(formExistingGig1);
			var existingGig1 = new XMLHttpRequest();
			existGigData1.append('iLoginID', userID1);
			
			existingGig1.onreadystatechange = function(){
				if(existingGig1.readyState == 4 && existingGig1.status == 200){
					//console.log(existingGig1.responseText);
					if(existingGig1.responseText == 'inserted'){
						document.getElementById("bookme-form").reset();
						document.getElementById("submissionStatMessage").innerHTML = "<p>Request Sumbitted!</p>";
					}
					else{
						document.getElementById("submissionStatMessage").innerHTML = "<p>"+existingGig1.responseText+"</p>";
					}
				}
			}
			existingGig1.open("POST", "gigformsubmit");
			existingGig1.send(existGigData1); 

			event.preventDefault();
		}, false);
	/* END - Send the New Gig form to database from Artist Profile page */

	/* Send the 'Add new artist to an existing gig' form to database from Artist Profile page */
		var formExistingGig = document.forms.namedItem("book4existing");
		formExistingGig.addEventListener('submit', function(event){
			var userID = $('.userID').val();
			var existGigData = new FormData(formExistingGig);
			// existGigData.append('iLoginID', userID);

			var existingGig = new XMLHttpRequest();
			existingGig.onreadystatechange = function(){
				if(existingGig.readyState == 4 && existingGig.status == 200){
					console.log(existingGig.responseText);
					if(existingGig.responseText == 'inserted'){
						//location.reload();
						$('#artistAdded').modal('toggle');
						/*$('#artistAdded').modal({
							backdrop: 'static'
						});*/
					}
				}
			}
			existingGig.open("POST", "gigformsubmit");
			existingGig.send(existGigData); 

			document.getElementById("book4existing").reset();
			event.preventDefault();
		}, false);
	/* END - Send the 'Add new artist to an existing gig' form to database from Artist Profile page */
	
	/* Refresh page function */
		function refreshPage(){
			location.reload();
		}
	/* END - Refresh page function */
	
	/* Refresh page when modal is closed */
		$('#artistAdded').on('hidden.bs.modal', function(e){
			console.log('refresh this page');
			//location.reload();
		});
	/* END - Refresh page when modal is closed */
</script>