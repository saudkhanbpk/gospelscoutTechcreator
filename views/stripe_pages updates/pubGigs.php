<?php 
	/* Public Gigs */

	$backGround = 'bg2';
	$page = 'Pending Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	if($currentUserID == ''){
		echo '<script>window.location = "'. URL .'newHomePage/index.php";</script>';
		exit;
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
<form  action="<?php echo URL;?>newHomePage/views/xmlhttprequest/pubGigBackbone.php" method="post" name="gigdetails" id="gigdetails" class="needs-validation mt-4 gigEdit pb-4 pt-2" table="gigdetails" novalidate>
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
				echo '<button class="btn btn-small btn-gs text-white getStatus" type="submit" get-modal="" id="updateGig">Update Gig</button>'; //id="postGig"
			}
			else{
				echo '<button class="btn btn-small btn-gs text-white getStatus" type="button" get-modal="" id="postGig">Post Gig</button>'; //data-toggle="modal" data-target=""
			}
		?>


		<div class="row d-none text-center mt-3" id="zipErrContainer">
			<div class="col text-danger">
				<p id="zipError"></p>
			</div>
		</div>
	</div>
</form>

<!-- Modal introduce the payment modal and collect payment information -->
    <div class="modal fade" id="bidToGig" tabindex="-1" role="dialog" aria-labelledby="bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Bid To Gig</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- style the stripe form -->
                <style>
                    /**
                    * The CSS shown here will not be introduced in the Quickstart guide, but shows
                    * how you can use CSS to style your Element's container
                    */
                    .StripeElement {
                        box-sizing: border-box;

                        height: 40px;
                        color: blue;
                        padding: 10px 12px;
                        display: block;
                        border: 1px solid transparent;
                        border-radius: 4px;
                        background-color: white;

                        box-shadow: 2px 1px 3px 2px #d2d7dd;// e6ebf1
                        -webkit-transition: box-shadow 150ms ease;
                        transition: box-shadow 150ms ease;
                    }

                    .StripeElement--focus {
                        box-shadow: 0 1px 3px 0 #cfd7df;
                    }

                    .StripeElement--invalid {
                        border-color: #fa755a;
                    }

                    .StripeElement--webkit-autofill {
                        background-color: #fefde5 !important;
                    }
                    ul {
                        list-style: none;
                    }
                    li {
                        font-size: 12px;
                    }
                </style>

            <!-- Modal Body -->
                <div class="modal-body mt-0">   
                    <!-- Carousel this div with 2 slides: 1. to introduce the pricing model, 2.  to collect card info for tokenization -->
                    <div id="carouselExampleIndicators" class="carousel mb-0"  data-interval="false" style="max-height:350px" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item bg-white active" style="max-height:325px;overflow:hidden;overflow:scroll">
                                <div class="container">
                                     <div class="row mb-1">
                                        <div class="col text-center">
                                            <h5>How it Works!!!</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <h6>Your first gig post is on us!!!</h6>
                                            <p class="pl-2" style="font-size:12px"> Your first gig post is on us.  After that, only pay for what you use. See details below!!!</p>
                                            <h6>Only pay for what you use!!!</h6>
                                            <p class="pl-2" style="font-size:12px"> You are never charged for having an account with us.  You only pay for what you use.  We track your usage through out the month and add up your total usage at the end of your billing cycle. Keep in mind, the more your bid, the cheaper it is.  Check out our pricing below.</p>
                                            <h6>The more you bid the cheaper it is!!!</h6>
                                            <ul class="pl-2">
                                                <li>1-4 posts/month: $4.00/bid</li>
                                                <li>5+ posts/month: $2.00/bid</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item mt-0 pt-1 bg-white" style="max-height:325px">
                                <div class="container mt-0">
                                    <div class="row mb-1">
                                        <div class="col text-center">
                                             <h5>Payment Info</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size:12px">Enter card info here.  Your card info is securely transmitted and stored using our stripe api interface.  <span class="font-weight-bold">Once you enter your card info the first time you don't have to enter it again.</span></p>
                                        </div>
                                    </div>
                                    <form class="" action="<?php echo URL;?>newHomePage/views/xmlhttprequest/stripeApiTest.php" method="post" id="payment-form">
                                        <div class="form-row">
                                            <div class="container pb-1">
                                                <p class="mb-0">Credit or debit card</p>
                                            </div>
                                            <div class="col d-block" id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display Element errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-gs mt-3">Submit</button>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div> 
                    <div class="container">
                        <div class="row">
                            <div class="col text-center mt-2">
                                <a href="#" class="slide1 text-gs font-weight-bold">Enter Card Info -></a>
                                <a href="#" class="slide2 text-gs font-weight-bold  d-none"><- How it Works</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <script>
                    var car = $('.carousel');

                    $('.slide1').click(function(event){
                        event.preventDefault();
                        $('.slide1').addClass('d-none');
                        $('.slide2').removeClass('d-none');
                        car.carousel('next');
                        car.carousel('pause');  

                    });

                    $('.slide2').click(function(event){
                        event.preventDefault();
                        $('.slide2').addClass('d-none');
                        $('.slide1').removeClass('d-none');
                        car.carousel('prev');
                        car.carousel('pause');  
                    });
                </script>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px">
                    <div class="checkbox container p-0" id="postDisplay-sm"> 
                        <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
                        <img class="" src="<?php echo URL;?>newHomePage/img/stripeLogo.png" height="30px" width="50px">
                    </div>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal introduce the payment modal and collect payment information -->

<!-- Modal to confirm a bid on a gig -->
    <div class="modal fade" id="conf_bidToGig" tabindex="-1" role="dialog" aria-labelledby="conf_bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Submit Gig Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                            	<ul style="list-style:disc">
                            		<li>
		                                <p class="my-1">You currently have <span class="text-gs font-weight-bold" id="bid_num"></span> Post(s) this month!!! This will be post # <span class="text-gs font-weight-bold" id="new_bid_num"></span>, Priced @ $<span id="bid_price"></span>/post</p>
		                            </li>
		                            <li class="reduce_price d-none my-1">
		                                <p>Post @ least 5 gigs and drop the price of all of your posts to $<span id="bid_pric_new"></span>/post</p>
		                            </li>
		                        </ul>
		                        <p class="text-gs font-weight-bold mt-3">Click below to post gig!!!</p>
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs sendPost" id="submitInquiry" data-dismiss="modal" aria-label="Close">Post Gig</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm a bid on a gig -->

<!-- Users current usage -->
    <input type="hidden" value="" name="current-u" id="current-u" current-u="this-user-info">

<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo URL;?>newHomePage/js/jquery.validate.js"></script>
<script src="<?php echo URL;?>newHomePage/js/additional-methods.js"></script> 
<script src="https://js.stripe.com/v3/"></script>
<script>
/*************************************************** stripe functionality ***************************************************/
    (function() {
        /* Show current usage function */
            function showCurrentUsage(currentUsage){
                if(currentUsage < 5){
                    var bids_left = 5 - currentUsage;
                    $('#bid_price').html('4.00');
                    $('#bid_pric_new').html('2.00');
                    $('#bids_left').html(bids_left);
                    $('.reduce_price').removeClass('d-none');
                }
                else{
                    $('#bid_price').html('2.00');
                }
                var newBid_numb = currentUsage;
                $('#bid_num').html(newBid_numb);
                $('#new_bid_num').html(newBid_numb + 1);
            }
        /* END - Show current usage function */

        /************************** Check if user has payment info on file **************************/
            function get_str_cust_info(conf_tru){
                var newForm = new FormData();
                newForm.append('action', 'check_pay_src');
                newForm.append('u_action', 'post');
                newForm.append('retrieve_cust', "<?php echo $userInfo['str_customerID'];?>");
                newForm.append('iLoginID', "<?php echo $userInfo['iLoginID'];?>");

                var sendCust_info = new XMLHttpRequest();
                sendCust_info.onreadystatechange = function(){
                    if(sendCust_info.readyState == 4 && sendCust_info.status == 200){
                        var respTxt = sendCust_info.responseText.trim();
                        var parse_respTxt = JSON.parse(respTxt);

                        if(parse_respTxt['src_present']){
                            /* Set the data-target */
                                $('#postGig').attr('get-modal','#conf_bidToGig'); 

                            /* Fill in current usage values for customer */
                                showCurrentUsage(parse_respTxt['current_usage']);
                        }
                        else{
                            /* Set the data-target */
                                $('#postGig').attr('get-modal','#bidToGig');
                        }

                        /* Temporarily store usage value access later */
                            $('#current-u').attr('current-u',parse_respTxt['current_usage']);
                    }
                }
                sendCust_info.open('POST',"<?php echo URL; ?>newHomePage/views/xmlhttprequest/get_set_str_tok.php");
                sendCust_info.send(newForm);
            }
            /* Call the get_str_cust_info function to determine if str_customer has default src */
                get_str_cust_info();
        /*********************** END - Check if user has payment info on file ***********************/


	      "use strict";
	        var stripe = Stripe('pk_test_mvwPTPJ6rSe6P4lmWIr5pbwr');
	        var elements = stripe.elements();

	        /* Custom styling can be passed to options when creating an Element. */
	            var style = {
	                base: {
	                    color: '#32325d',
	                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
	                    fontSmoothing: 'antialiased',
	                    fontSize: '16px',
	                    '::placeholder': {
	                        color: '#aab7c4'
	                    }
	                },
	                    invalid: {
	                    color: '#fa755a',
	                    iconColor: '#fa755a'
	                }
	            };

	        /* Create an instance of the card Element. */
	            var card = elements.create('card', {style: style});

	        /* Add an instance of the card Element into the `card-element` <div>. */
	            card.mount('#card-element');

	        /* Add an event listener to the card element to catch errors */
	            card.addEventListener('change', function(event) {
	                var displayError = document.getElementById('card-errors');

	                if (event.error) {
	                    displayError.textContent = event.error.message;
	                } else {
	                    displayError.textContent = '';
	                }   
	            });

	        /* Define a function to add the card token to the payment info form and then submit the form to the server */
	            function stripeTokenHandler(token) {
	                
	                /* Insert the token ID into the form so it gets submitted to the server */
	                    var form = document.getElementById('payment-form');
	                    var hiddenInput = document.createElement('input');
	                    hiddenInput.setAttribute('type', 'hidden');
	                    hiddenInput.setAttribute('name', 'stripeToken');
	                    hiddenInput.setAttribute('value', token.id);
	                    form.appendChild(hiddenInput);

	                /* Submit the form to the get_set_str_tok.php - update current user's customer object with payment src */
	                    var newForm = new FormData(form);
	                    newForm.append('action','add_src_tok');
	                    newForm.append('cust_id',"<?php echo $userInfo['str_customerID'];?>");

	                    var sendTok = new XMLHttpRequest();
	                    sendTok.onreadystatechange = function(){
	                        if(sendTok.status == 200 && sendTok.readyState == 4){

	                            /* Display the confirmation modal for the current bid */
	                                var respTxt = sendTok.responseText.trim();
	                                var parse_respTxt = JSON.parse(respTxt);

	                                if(parse_respTxt['src_count'] > 0){
	                                    /* Dismiss the "how it works" modal and show the confirmation modal */
	                                        $('#bidToGig').modal('hide');

	                                    /* Set the data-target by calling the get_str_cust_info function - retrieve user stripe info */
	                                        var curr_u = parseInt($('#current-u').attr('current-u'));
	                                        showCurrentUsage(curr_u);
	                                        $('#conf_bidToGig').modal('show');

	                                        /* Set the data-target */
	                                            $('#postGig').attr('get-modal','#conf_bidToGig');
	                                }
	                        }
	                    }
	                    sendTok.open('POST','<?php echo URL; ?>newHomePage/views/xmlhttprequest/get_set_str_tok.php');
	                    sendTok.send(newForm);
	            }

            /* Create a token or display an error when the form is submitted. */
	            var form = document.getElementById('payment-form');
	            form.addEventListener('submit', function(event) {
	                event.preventDefault();

	                stripe.createToken(card).then(function(result) {
	                    
	                    if (result.error) {
	                        /* Inform the customer that there was an error. */
	                            var errorElement = document.getElementById('card-errors');
	                            errorElement.textContent = result.error.message;
	                    } else {
	                        /* Send the token to your server. */
	                            stripeTokenHandler(result.token);

	                    }
	                });
	            });
	})();
/************************************************ END - stripe functionality ************************************************/

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
	                        /**** Convert the time into format useable by date() function ****/
		                        function convertTo24Hour(time) {
								    var hours = parseInt(time.substr(0, 2));
								    if(time.indexOf(' AM') != -1 && hours == 12) {
								        time = time.replace('12', '0');
								    }
								    if(time.indexOf(' PM')  != -1 && hours < 12) {
								        time = time.replace(hours, (hours + 12));
								    }
								    return time.replace(/( AM| PM)/, ':00');
								}
							/* END - Convert the time into format useable by date() function */	

                        /* Change format of the times */
	                        var sTime  = convertTo24Hour($('input[name=setupTime]').val());
	                        var stTime = convertTo24Hour($('input[name=startTime]').val());
	                        var	eTime = convertTo24Hour($('input[name=endTime]').val());

                        	var todayD = new Date();
                        	var enteredD = new Date($('input[name=gigDate]').val()+'T'+sTime); //$('input[name=setupTime]').val());
                        	var sTime = new Date($('input[name=gigDate]').val()+'T'+sTime);
                        	var stTime = new Date($('input[name=gigDate]').val()+'T'+stTime); 
                        	var eTime = new Date($('input[name=gigDate]').val()+'T'+eTime); 
                        	
                        	if(todayD < enteredD){
                        		if(sTime <= stTime && stTime < eTime){
	                        		/* Submit Contact Us Form */
	                      				if($('.getStatus').attr('id') == 'updateGig'){
	                      					form.submit();
	                      				}
	                      				else{
	                      					/*********** Call another XMLHttpRequest to update stripe usage object ***********/
					                            var usage_obj = new FormData();
					                            usage_obj.append('action','create_usage_record');
					                            usage_obj.append('iLoginID','<?php echo $currentUserID;?>');
					                            usage_obj.append('u_action','post');

					                            var update_usage = new XMLHttpRequest();
					                            update_usage.onreadystatechange = function(){
					                                if(update_usage.status == 200 && update_usage.readyState == 4){
					                                    var parsed_u_update = JSON.parse(update_usage.responseText.trim());
					                                    if(parsed_u_update['u_rec_inserted'] > 0){
					                                        console.log(parsed_u_update['u_rec_inserted']);
					                                        /* Submit Form */
					                                        	console.log('form validated');
					                                            form.submit();
					                                    }  
					                                }
					                            }
					                            update_usage.open('post','<?php echo URL; ?>newHomePage/views/xmlhttprequest/get_set_str_tok.php');
					                            update_usage.send(usage_obj);
					                        /******** END - Call another XMLHttpRequest to update stripe usage object ********/
	                      				}
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
            digits: true
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
		        format: "hh:mm A",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });	
		    $("#datetimepicker4").datetimepicker({
		        format: "hh:mm A",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });	
		    $("#datetimepicker5").datetimepicker({
		        format: "hh:mm A",
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

		    	groupMaker = 1; 
		    }
		    else{
		    	/* Hide the group type select menu when group is not selected */
			    	$('#groupTypeContainer').addClass('d-none');
			    	$('#groupType').val('');
		    }
		});
	/***************** END - Show and Hide grouptype and upper and lower age boundaries *****************/

	/**** Trigger the confirm post modal ****/
		$('#postGig').click(function(event){
			event.preventDefault();
			
			var get_modal = $(this).attr('get-modal');
			$(get_modal).modal('show');
		});
	/* END - Trigger the confirm post modal */

	/**** Submit the form for validation ****/
		$('.sendPost').click(function(event){
			event.preventDefault();
			signUpForm.submit();
		});
	/* END - Submit the form for validation */
</script>

