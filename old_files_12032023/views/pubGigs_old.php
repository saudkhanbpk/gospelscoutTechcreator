<?php 
	/* Public Gigs */

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

	if($_POST){
		echo '<pre>';
		var_dump($_POST);
	}

	if($_GET['new']){
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
		$updating = true;
		/* Query for the current gigs info */
			try{
				$a = 'postedgigsmaster';
				$gigDetailsQuery = 'SELECT * FROM ' . $a . ' WHERE ' . $a . '.gigId = ?';				

				$getGigDetails = $db->prepare($gigDetailsQuery);
				$getGigDetails->bindParam(1, $gigId);
				$getGigDetails->execute(); 
				$getGigDetailsResults = $getGigDetails->fetch(PDO::FETCH_ASSOC);
			}
			catch(Exception $e){
				echo $e; 
			}
			$getGigDetails = $getGigDetailsResults;
		// echo '<pre>';
		// var_dump($getGigDetails);
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


		// echo '<pre>';
		// var_dump($talentList1D);
		// exit;

/* Remove Inputs if gig is expired, cancelled, or user is an artist */
		if($user == 'artist' || $gigState == 'expired' || $gigState == 'cancelled'){
?>
			<style>
				/*input[type=text],input[type=radio],input[type=email],.no-button,.dropdown,div.date {
					display: none;
				}
				.gigEdit p {
					margin: 0;
					padding-left: 10px;
					font-size:13px;
					font-weight: bold;
					display:inline-block;
				}*/
			</style>
<?php 
		}
		else{
?>
			<style>
				/*.gigEdit p,p,  .colon {
					display: none;
				}*/
			</style>
<?php 
		}
	/* END - Remove Inputs if gig is expired, cancelled, or user is an artist */

?>
<form  action="<?php echo URL;?>views/xmlhttprequest/pubGigBackbone.php" method="post" name="gigdetails" id="gigdetails" class="needs-validation mt-4 gigEdit pb-4 pt-2" table="gigdetails" novalidate>
	<div class="container bg-white mt-5 mb-3 px-5 py-3" style="max-width:900px;min-height:700px">
		
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
			<!-- <hr class="mt-4"> Page Divider -->
		</div>

		<!-- Event Info -->
		<div class="container mt-2"> <!-- common section -->
			<h5 class="text-gs">Gig Info</h5>
			<div class="row pl-2">
				<div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Name<span class="colon">:</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="gigName" placeholder="Event Name" value="<?php echo $getGigDetails['gigName'];?>">
			    </div>
			    <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Type<span class="colon">:</span></label>
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
			    <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Date<span class="colon">:</span></label>
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
			    <div class="col-10 col-md-7">
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Setup Time<span class="colon">:</span></label>
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
		        <div class="col-10 col-md-7">
		        	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Start Time<span class="colon">:</span></label>
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
		        <div class="col-10 col-md-7">
		        	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">End Time<span class="colon">:</span></label>
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
		        <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Privacy<span class="colon">:</span></label>
					<select class="custom-select dropdown form-control-sm" id="privacy" name="gigPrivacy">
				       	<option value="">Privacy</option>
				       	<option <?php if($getGigDetails['gigPrivacy'] == 'pub'){echo 'selected';} ?> value="pub">Public</option>
				       	<option <?php if($getGigDetails['gigPrivacy'] == 'priv'){echo 'selected';} ?> value="priv">Private</option>
				    </select>
				</div>
				<div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Event Pay<span class="colon">:</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="gigPay" placeholder="0.00" value="<?php echo $getGigDetails['gigPay'];?>" >
			    </div>
			</div>
			<hr class="mt-4"> <!-- Page Divider -->
		</div>
	<!-- /Event Info -->

	<!-- Artist Info -->
		<div class="container mt-2"> <!-- common section -->
			<h5 class="text-gs">Artist Info</h5>
			<div class="row pl-2">
				<!-- usertype -->
				<input type="hidden" name="userType" value="">
				<div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Type of Artist Needed<span class="colon">:</span></label>
					<select class="custom-select dropdown form-control-sm" id="artistType" name="artistType" >
				       	<option value="">What Kind of Artist?</option>
				       	<?php
				       		if($getGigDetails['userType'] == 'group'){
				       			echo '<option selected value="groups">Groups</option>';
				       		}
				       		else{
				       			echo '<option value="groups">Groups</option>';
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
				<div class="col-10 col-md-7 <?php if($getGigDetails['userType'] != 'group'){echo 'd-none';}?>" id="groupTypeContainer">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Type of Group Needed<span class="colon">:</span></label>
					<select class="custom-select form-control-sm" name="groupType" id="groupType">
				       	<option value="">What Type of Group?</option>
				       	<!-- <option value="all">All Groups</option> -->
				       	<?php 
					    	foreach($groupTypeList as $sType) {
					    		if($getGigDetails['groupType'] = $sType['id']){
						    		echo '<option selected value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
						    	}
						    	else{
						    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
						    	}
					    	}
					    ?>
				    </select>
				</div>
				<div class="col-10 col-md-7">
					<div id="ageDiv">
				  		<!-- Age: -->
						<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Minimum Age<span class="colon">:</span></label> 
						<div class="row form-group">
						    <div class="col-12 col-sm-6 col-lg-4 mt-2">
						    	<?php 
						    		if(!empty($getGigDetails['dDOB1'])){ 
						    			$minAge = $getGigDetails['dDOB1'];
						    			//$minAge = getAge($getGigDetails['dDOB1']);
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
				<div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Gender</label>
		            		<select class="custom-select form-control-sm mb-2" name="sGender" required>
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
			<h5 class="text-gs">Venue Info</h5>
			<div class="row pl-2">
				<div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue Name<span class="colon">:</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="venueName" placeholder="Venue Name" value="<?php echo $getGigDetails['venueName'];?>">
			    </div>
			    <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue Address<span class="colon">:</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="venueAddress" placeholder="Venue Address" value="<?php echo $getGigDetails['venueAddress'];?>">
			    </div>
			    <!-- State -->
			     <?php 
			    	/* Fetch States */
						$cond = 'country_id = 231'; 
						$stateArray = $obj->fetchRowAll('states', $cond);
					/* END - Fetch States */
			    ?>
			    <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Venue State<span class="colon">:</span></label>
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
			    <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zip Code<span class="colon">:</span></label>
					<input type="text" class="form-control form-control-sm mb-2" name="venueZip" id="venueZip" placeholder="Zipcode" value="<?php echo $getGigDetails['venueZip'];?>">
					<input type="hidden" name="venueStateShort" id="venueStateShort" value="">
					<input type="hidden" name="venueCity" id="venueCity" value="">
			    </div>
			    <div class="col-10 col-md-7">
					<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Environment<span class="colon">:</span></label>
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

		<!-- gigid -->
			<input type="hidden" name="gigId" value="<?php echo $gigId;?>">

		
		<!-- gig manager loginid - gigDetails_gigManLoginId -->
			<input type="hidden" name="gigManLoginId" value="<?php echo $currentUserID;?>">
		<!-- gig manager name - gigDetails_gigManName -->
			<input type="hidden" name="gigManName" value="<?php echo $manFullName;?>">
		<!-- gig manager email - gigDetails_gigManEmail -->
			<input type="hidden" name="gigManEmail" value="<?php echo $manEmail; ?>">
		<!-- gig manager phone - gigDetails_gigManPhone -->
			<input type="hidden" name="gigManPhone" value="<?php echo $manPhone;?>">

		<!-- if gig is being updated -->
		<?php 
			if($updating){
				echo '<input type="hidden" name="update" value="true">';
				echo '<button class="btn btn-small btn-gs text-white getStatus" type="submit" id="postGig">Update Gig</button>';
			}
			else{
				echo '<button class="btn btn-small btn-gs text-white getStatus" type="submit" id="postGig">Post Gig</button>';
			}
		?>


		<div class="row d-none text-center mt-3" id="zipErrContainer">
			<div class="col text-danger">
				<p id="zipError"></p>
			</div>
		</div>
	</div>
</form>

<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="<?php echo URL;?>js/additional-methods.js"></script> 
<script>
  /* Front End Form Validation */
    var signUpForm = $("#gigdetails");

    signUpForm.validate({
      /* Submit the form */
          submitHandler: function(form) {
            /****** execute Javascript to contact google geocoding api ******/
              $.support.cors = true;
                $.ajaxSetup({ cache: false });
                var city = '';
                var hascity = 0;
                var hassub = 0;
                var state = '';
                var stateShort = '';
                var nbhd = '';
                var subloc = '';
                var userState = $('#venueState').val();
                var userZip = $('#venueZip').val();
                var talType = $("#artistType").val();
                if(talType == 'groups'){
                	$('input[name=userType]').val('group');
                }
                else{
                	$('input[name=userType]').val('artist');
                }

                if(userZip.length == 5){
                  var date = new Date();
                  $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
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
                          stateShort = component.short_name;
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

                    if(state == userState){
                      	$('#zipErrContainer').removeClass('d-none');

                      	if(hascity == 1){
                        	$('#venueCity').val(city);
                      	}
                      	else if(hasnbhd == 1){
                        	$('#venueCity').val(nbhd);
                      	}
                    	$('#venueStateShort').val(stateShort);
                        
                        /* Ensure dates have not passed and times are in sequential order */
                        	var todayD = new Date();
                        	var enteredD = new Date($('input[name=gigDate]').val()+' '+$('input[name=setupTime]').val());
                        	var sTime = new Date($('input[name=gigDate]').val()+' '+$('input[name=setupTime]').val());
                        	var stTime = new Date($('input[name=gigDate]').val()+' '+$('input[name=startTime]').val()); 
                        	var eTime = new Date($('input[name=gigDate]').val()+' '+$('input[name=endTime]').val()); 

                        	if(todayD < enteredD){
                        		if(sTime <= stTime && stTime < eTime){
	                        		/* Submit Contact Us Form */
	                      				form.submit();
                      			}
                      			else{
                      				var zipErr = 'Your Times Are Invalid.';
	                        		$('#zipError').text(zipErr);
	                      			$('#zipErrContainer').removeClass('d-none');
                      			}
                        	}
                        	else{
                        		var zipErr = 'Please Enter Future Gig Date and Times Only.';
                        		$('#zipError').text(zipErr);
                      			$('#zipErrContainer').removeClass('d-none');
                        	}
                    }
                    else{
                      $('#venueCity').val('');
                      var zipErr = 'State/Zip Code Mismatch!!!';
                      $('#zipError').text(zipErr);
                      $('#zipErrContainer').removeClass('d-none');
                    }

                    
                  });
                }
              /****** END - execute Javascript to contact google geocoding api ******/
        },
      /* END - Submit the form */

      /* Set validation rules for the form */
        rules:{
          gigName: {
            required: true,
          },
          gigType: {
            required: true,
          },
          gigDate: {
            required: true,
          },
          artistType: {
          	required: true,
          },
          groupType: {
			required: {
				depends: function(element){
					return $('#artistType').val('groups');
				}
			}
		  },
          dDOB1: {
            required: true,
          },
           sGender: {
            required: true,
          },
          setupTime: {
            required: true,
          },
          startTime: {
            required: true,
          },
          endTime: {
            required: true,
          },
          gigPrivacy: {
            required: true,
          },
          gigPay: {
            required: true,
          },
          venueName: {
            required: true,
          },
          venueAddress: {
            required: true,
          },
          venueEnvironment: {
            required: true,
          },
          venueState: {
            required: true,
          },
          venueZip: {
            required: true,
            minlength: 5,
            maxlength: 5,
            digits: true
          }
        },
        messages: {
          gigName: {
            required: 'Please Enter a Gig Name',
          },
          gigType: {
            required: 'Please Select a Gig Type',
          },
          artistType: {
          	required: 'Please Select Type of Artist',
          },
          groupType: {
			required: 'Please Select Type of Group',
		  },
	  dDOB1: {
            required: 'Please Enter a Minimum Age',
          },
          sGender: {
            required: 'Please Specify a Gender',
          },
          gigDate: {
            required: 'Please Select a Gig Date',
          },
          setupTime: {
            required: 'Please Specify a Set up Time',
          },
          startTime: {
            required: 'Please Specify a Start Time',
          },
          endTime: {
            required: 'Please Specify a End Time',
          },
          gigPrivacy: {
            required: 'Please Select a Privacy Type',
          },
          gigPay: {
            required: 'Please Enter Payment Amount.  If None, Enter 0.00',
          },
          venueName: {
            required: 'Please Enter a Venue Name',
          },
          venueAddress: {
            required: 'Please Enter a Venue Address',
          },
          venueEnvironment: {
            required: 'Please Select the Venue Environment',
          },
          venueState: {
            required: 'Please Select the Venue State',
          },
          venueZip: {
            required: 'Please enter your 5 digit zip code',
             minlength: 'Please enter your 5-digit zip code',
             maxlength: 'Please enter your 5-digit zip code',
             digits: 'Please enter numeric values only'
          }
        }
    });
  /* END - Front End Form Validation */  

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

	/******************** Show and Hide grouptype and upper and lower age boundaries ********************/
		var groupMaker = 0;
		$("#artistType").change(function(){
		    var selection = $(this).val();

		    if(selection == 'groups'){
		    	/* Show group types when group is selected */
		    		$('#groupTypeContainer').removeClass('d-none');

		    	/* Hide age inputs when group is selected */	
		    		// $('#ageDiv').addClass('d-none');

		    	groupMaker = 1; 
		    }
		    else{
		    	/* Hide the group type select menu when group is not selected */
			    	$('#groupTypeContainer').addClass('d-none');
			    	$('#groupType').val('');
			    		
		    	/* Show the age inputs when an artist talent is selected as opposed to group */
			    	// $('#ageDiv').removeClass('d-none');
			    	// if(groupMaker == 1){
				    // 	$('input[name=dDOB1]').val('');
				    // 	groupMaker = 0;
			    	// }

		    }
		});
	/***************** END - Show and Hide grouptype and upper and lower age boundaries *****************/
</script>
