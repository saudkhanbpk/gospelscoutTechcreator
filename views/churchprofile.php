<?php 
	$page = 'cProfile';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
			
	/* Check for the user classification - define corresponding indicator */
		if(isset($_GET['church'])) {
			$churchID = intval($_GET['church']);
			echo '<input type="hidden" class="userID" value="' . $churchID . '" id="1">';
			if($churchID > 0){
				if($currentUserID > 0 && $currentUserType == 'church' && $currentUserID == $churchID ){
					/* User is signed in - This is the user's profile*/
					$profOwner = 1; 
					echo '<input type="hidden" class="userSubStat" value="profOwner" id="1">'; //used to determine which subscribe section to display

					/* Query the Database for church's info */ 
						$cond = "iLoginID = ".$currentUserID;
						$userRow = $obj->fetchRow("usermaster",$cond);
					/* END - Query the Database for artist's info */ 
				}
				elseif($currentUserID > 0){		
					/*  User is signed in - This is not the user's profile*/
					$profGuest = 1;
					echo '<input type="hidden" class="userSubStat" value="profGuest" id="1">'; //used to determine which subscribe section to display

					/* Query the Database for artist's info */ 
						$cond = "iLoginID = ".$churchID;
						$userRow = $obj->fetchRow("usermaster",$cond);
						if(!isset($userRow)){
							echo '<script>window.location = "'. URL .'views/search4churchNew.php";</script>';
							exit;
						}
					/* END - Query the Database for church's info */ 
				}
				else{
					/* User is not signed in */
					$siteGuest = 1;
					echo '<input type="hidden" class="userSubStat" value="siteGuest" id="1">'; //used to determine which subscribe section to display

					/* Query the Database for church's info */  
						$cond = "iLoginID = ".$churchID;
						$userRow = $obj->fetchRow("usermaster",$cond);
						if(!isset($userRow)){
							echo '<script>window.location = "'. URL .'views/search4churchNew.php";</script>';
							exit;
						}
					/* END - Query the Database for church's info */ 
				}
			}
			else{
				/* Redirect to the search4churchNew.php page */
				echo '<script>window.location = "'. URL .'views/search4churchNew.php";</script>';
				exit;
			}
		}
		else{
			if($currentUserID > 0 && $currentUserType == 'church'){
				echo '<input type="hidden" class="userID" value="' . $currentUserID . '" id="1">';
				/* return user info with session id - allow user to view and edite profile */
				$profOwner = 1;
				echo '<input type="hidden" class="userSubStat" value="profOwner" id="1">'; //used to determine which subscribe section to display
				
				/* Query the Database for artist's info */ 
					$cond = "iLoginID = ".$currentUserID;
					$userRow = $obj->fetchRow("usermaster",$cond);
				/* END - Query the Database for artist's info */ 
			}
			else{
				/* Redirect to the search4artistNew.php page */
				echo '<script>window.location = "'. URL .'views/search4churchNew.php";</script>';
				exit;
			}
		}
	/* END - Check for the user classification - define corresponding indicator */
	
	/* Assign current church's profile Id to one var */
		if($profOwner == '1'){
			$churchUserID = $currentUserID;
		}
		elseif($profGuest == '1'){
			$churchUserID = $_GET['church'];
		}
		else{
			$churchUserID = $_GET['church'];
		}
	/* END - Assign current church's profile Id to one var */
		
	/* Query the Database for church's Ministry info */ 
		$currentMinistries = $obj->fetchRowAll('churchministrymaster2', 'iLoginID = ' . $churchUserID);
		$query = "SELECT * FROM giftmaster1 WHERE iGiftID = ?"; 
		try{
			foreach($currentMinistries as $iGiftID){
				$getMinId = $db->prepare($query);
				$getMinId->bindParam(1,$iGiftID['iGiftID']);
				$getMinId->execute();
				$ministryRow[] = $getMinId->Fetch(PDO::FETCH_ASSOC);
			}
		}
		catch(Exception $e){
			echo $e; 
		}
	/* END - Query the Database for church's Ministry info */ 

	/* Query the Database for church's Amenity info */ 
		// Search the church amenity table
	/* END - Query the Database for church's Amenity info */ 

	/* Query the Database for church's Service Time info */ 
		// Search the churchtimeing table
		$serviceTime = $obj->fetchRowAll('churchtimeing',"iLoginID = ".$churchUserID);
		// echo '<pre>';
		// var_dump($serviceTime);
	/* END - Query the Database for church's Service Time info */ 

	/* Query database for Church's city and state */
		// $city = $obj->fetchRow('cities',"id = ".$userRow['sCityName']);
		$city = $userRow['sCityName'];
		$state = $obj->fetchRow('states',"id = ".$userRow['sStateName']);
		$location = ucfirst($city).','.$state['statecode'].' '.$userRow['iZipcode'];
		// echo $location; 
	/* END - Query database for Artist's city and state */


	
	// echo '<pre>';
	// var_dump($userRow);
?>

	<!-- Styling for thumbnail previews for the video and Photo upload modals -->
	<style>
		.thumb {
			width: 100px;
			height: 100px;
			object-fit:cover; 
			object-position:0,0;
		}
		#photoThumb, #thumb {
			box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);
			background-image: url("../img/dummy.jpg");
			background-size: 100px 100px;
			background-repeat:  no-repeat;
			background-position:  center;
			object-fit:cover; 
			object-position:0,0;
		}
	</style>
	<!-- Styling for thumbnail previews for the video and Photo upload modals -->

	<!-- Main Page Carousel -->
	<div class="container profPic-bg col-md-5 col-lg-8 mt-3 py-0" style="min-height: 300px;max-width: 900px;">
		<div class="smokeScreen m-0" style="height: 100%; width:100%">
			<div class="col-sm-7 col-lg p-0" style="margin:auto;">
				<h5 class="text-capitalize text-gs text-center text-lg-left"><?php echo $userRow['sChurchName']; ?></h5>
				<div id="myCarousel mb-0 pb-0 col-md-5" class="carousel slide d-none d-lg-block" data-ride="carousel" style="height: 300px; margin-bottom:20px">
				    <div class="carousel-inner" >
				      <div class="carousel-item active mb-0" style="height:300px">
				        <img class="first-slide " style="height:" src="../img/BusinessCardCollage2.png" alt="First slide">
				      </div>
				      <div class="carousel-item" style="height:300px">
				        <img class="second-slide " style="height:" src="../img/BusinessCardCollage2.png" alt="Second slide">
				      </div>
				      <div class="carousel-item" style="height:300px">
				        <img class="third-slide " style="height:" src="../img/1148troyBanner4.png" alt="Third slide">
				      </div>
				    </div>
				</div>
			</div>
			<!--<div class="aProfPic-background">-->
				<div class="aProfPic-container">
					<img class="aProfPic" src="<?php echo $userRow['sProfileName'];?>" height="250px" width="250px">
				</div>
			<!--</div>-->
		</div>
	</div><!-- /Main Page Carousel -->
	
	<div class="container col-8 mt-0" style="max-width: 900px">
		<div class="row">
			<div class="col-sm-7 col-lg-5 mb-3 mb-lg-0 m-prof-sect" style="">

				<!-- Display Church's General Info -->
					<div class="bg-white p-3 a-prof-shadow" id="artistInfo">
						<h3 class="text-gs">Church Info</h3>
						<div id="infoTable">
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold" >Pastor: </div>
									<div class="col text-truncate" title="<?php echo $userRow['sPastorFirstName'] . ' ' . $userRow['sPastorLastName'];?>">
										<?php echo $userRow['sPastorFirstName'] . ' ' . $userRow['sPastorLastName'];?>

									</div>
								</div>
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold">Age: </div>
									<div class="col text-truncate" title="<?php echo $value;?>">
										<?php
											$from = new DateTime($userRow['dDOB']);
											$to   = new DateTime('today');
											echo $from->diff($to)->y . ' Years Old';
										?>

									</div>
								</div>
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold" >location: </div>
									<div class="col text-truncate" title="<?php echo $userRow['churchAddress'] . ' ' . $location;?>">
										<a class="text-gs" href="#" data-toggl="popover" data-placement="top" title="Address:" data-content="<?php echo $userRow['sAddress'].' '.$location;?>">
											<ul style="margin:0;padding:0;list-style:none">
												<li><?php echo $userRow['sAddress'];?></li>
												<li><?php echo $location;?></li>
											</ul>
										</a>
									</div>
								</div>
								
								<!-- Talent Display -->
									<div class="row my-2 text-gs" style="font-size: 13px">
										<div class="col pl-4 font-weight-bold" >Services: </div>
										<?php 
													if(count($serviceTime) > 1){
										?>
														<div class="col text-truncate" title="<?php echo $value;?>">
															<ul style="margin:0;padding:0;list-style:none">
																<?php foreach($serviceTime as $time){
																	$timeUpdate = date_create($time['serviceTime']);
																	$timeUpdate = date_format($timeUpdate, 'g:i a');
																	$serviceDay = $time['sTitle'];
																	echo '<li>'; 
																			echo $serviceDay . ' ' . str_replace("_","/",$timeUpdate); 
																	echo '</li>';
																}?>
															</ul>
														</div>
										<?php 		}
													else{
														foreach($serviceTime as $time){
															$timeUpdate = date_create($time['serviceTime']);
															$timeUpdate = date_format($timeUpdate, 'g:i a');
															$serviceDay = $time['sTitle'];
															echo '<div class="col text-truncate" title="' . $time . '">';
															 	echo $serviceDay . ' ' . str_replace("_","/",$timeUpdate); 
															echo '</div>';
														}
													}  
										?>
									</div>
								<!-- /Talent Display -->
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold" >website: </div>
									<div class="col text-truncate" title="<?php echo $userRow['sChurchUrl'];?>">
										<a class="text-gs" href="#" data-toggl="popover" data-placement="top" title="Website:" data-content="<?php echo $userRow['sChurchUrl'];?>"><?php if($userRow['sChurchUrl'] != ''){echo $userRow['sChurchUrl'];}else{echo 'N/A';}?></a>
									</div>
								</div>
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold" >Denomination: </div>
									<div class="col text-truncate" title="<?php echo $userRow['sDenomination'];?>">
										<a class="text-gs" href="#" data-toggl="popover" data-placement="top" title="Denomination:" data-content="<?php echo $userRow['sDenomination'];?>"><?php if($userRow['sDenomination'] != ''){echo $userRow['sDenomination'];}else{echo 'N/A';}?></a>
									</div>
								</div>
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold" >Contact: </div>
									<div class="col text-truncate" title="<?php echo $sContactNumber;?>">
										<?php 
						              		if($userRow['sContactNumber'] != '') {
						              			/*The substr_replace() method is used to insert '-' into the phone numbers to make them more */
							              			$artistContact = $userRow['sContactNumber'];
							              			$artistContact1 = substr_replace($artistContact, '-', 3, 0);
							              			$artistContact2 = substr_replace($artistContact1, '-', 7, 0);
							              			echo $artistContact2;
						              		}
							              	else{
							              		echo 'N/A';
							              	}
							            ?>
									</div>
								</div>
								<div class="row my-2 text-gs" style="font-size: 13px">
									<div class="col pl-4 font-weight-bold" >Email: </div>
									<div class="col text-truncate" title="<?php echo $userRow['sContactEmailID'];?>">
										<a class="text-gs" href="#" data-toggl="popover" data-placement="top" title="Church's Email:" data-content="<?php echo $userRow['sContactEmailID'];?>"><?php echo $userRow['sContactEmailID']; ?></a>
									</div>
								</div>		
						</div>
					</div>
				<!-- /Display Artist's General Info -->


				<!--<a href="#" data-toggl="popover" title="Popover Header" data-content="<?php echo $sContactEmailID;?>">Toggle popover</a>-->
					<script>
						$('[data-toggl="popover"]').click(function(event){
							event.preventDefault(); 
						});
						$(document).ready(function(){
						    $('[data-toggl="popover"]').popover(); 
						});
					</script>

				<!-- Display Upcoming Events -->
					<style>
					    .upcominGigs {
				    		position: relative;
				    		width: 90%; 
				    		margin: 20px auto 0px;
				    		min-height: 60px;
				    		//background-color: blue;
				    		padding: 5px;
				    		box-sizing: border-box;
				    		box-shadow: -2px 2px 10px 2px rgba(0,0,0,.4);
				    	}
				    </style>

					<div class="bg-white mt-3 p-2 a-prof-shadow" id="Events" style="min-height:250px">
						<h5 class="text-gs">Upcoming Events</h5> 

						<!-- Loop needs to be created to output the latest 4 events and/or gigs -->
						 <div class="row" style="background-color: ">
							<div class="col-11" style="min-height: 90px; margin:auto">

								<?php 
							    	if(isset($_GET['church']) && intval($_GET['church']) > 0 && intval($_GET['church']) != $currentUserID) {
							    		$userLogin = intval($_GET['church']);
							    		$privSetting = 'pub';
							    	}
							    	elseif(isset($_GET['artist'])) {
							    		header('Location:'. URL .'views/search4churchNew.php');
							    	}
							    	elseif($currentUserID != "") {
							    		$userLogin = $currentUserID;
										$privSetting = 'all';
							    	}
							    	else{
										header('Location:'. URL .'views/search4churchNew.php');
									}

				    				require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/event_gigQuery.php');
				    				
							    	if(count($finalList) > 0) {
								    	 $hoy = date_create(date());
								    	 $hoy = date_format($hoy, 'Y-m-d H:i:s');

								    	 /* Test current gig date for expiration then assign array index to event according to date */
									    	for($i=0;$i<count($finalList);$i++){
									    			$j = 0;
									    			if($finalList[$i]['start'] >= $hoy) {
										    			foreach($finalList as $test){
										    				if($finalList[$i]['start'] > $test['start']) {
										    					$j += 1; 
										    				}
										    			}
										    			$newArray[$j] = $finalList[$i]; 
										    		}
									    	}
								    	ksort($newArray);	//Sort the array elements in the correct order according to index   rgba(0,0,0,.4);
								    }
							    	else {
							    		if(isset($_GET['church']) && intval($_GET['church']) > 0 && intval($_GET['church']) != $currentUserID) {
								    		echo '<h5 class="container mt-5 text-center" style="color: rgba(204,204,204,1)">This church has no upcomming events.</h5>';
								    	}
								    	elseif($currentUserID != "") {
								    		echo '<h5 class="container mt-5 text-center" style="color: rgba(204,204,204,1)">You have no upcomming gigs or events.</h5>';
								    	}
							    	} 

							    	$r=0; 
							    	foreach($newArray as $event) {
							    		if($r<4) {
							    ?>
										<div class="card my-3" style="box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);border: 1px solid <?php echo $event['backgroundColor'];?>">
										    <div class="card-body py-2">
										      	<div class="row">
											      	<div class="col-4">
											      		<img class="card-img img-fluid" src="../img/gsStickerBig1.png" alt="Card image" width="80px" height="80px"> 
											      	</div>
											      	<div class="col-8">
											      		<h6 class="mb-1 text-truncate"><?php echo $event['title']; ?></h6>
												        <ul class="list-unstyled my-1 card-text-size-gs">
												        	<?php 
										    					$newForm = date_create($event['start']);
										    					$newForm1 = date_format($newForm, 'D, d M y');
										    					$newForm2 = date_format($newForm, 'g:ia');
										    				?>
												        	<li><?php echo $newForm1;?></li>
												        	<li><?php echo $newForm2;?></li>
												        </ul>
												        <a href="<?php echo $event['url'];?>" class="btn btn-primary">Get Info</a>
											      	</div>
											    </div>
										    </div>
									    </div>
							    <?php 
							    		}
							    	}
							    ?>
							</div>
						</div>
						<div class="mt-5 p-0 pt-1 text-center">
					    	<a href="<?php echo URL;?>calendar/calendarDisplay.php?u_Id=<?php echo $churchUserID;?>" class="btn mb-0 btn-primary btn-sm btn-gs">View Full Event Calendar</a>
					  	</div>
					</div> 
				<!-- /Display Upcoming Events -->
			</div>

			<!-- Content Container -->
				<div class="col-sm-7 m-prof-sect" id="content-display" style="min-height: 300px;">
					<div class="bg-white p-2 a-prof-shadow" style="min-height:500px">
						<!-- Menu Bar this Section -->
							<div class="nav-scroller box-shadow navynav">
								<!-- new nav -->
									<ul class="nav justify-content-center nav-pills a-Prof">
									  <li class="nav-item">
									    <a class="nav-link prof-nav active" id="Vid" href="#">VIDEOS</a>
									  </li>
									  <li class="nav-item">
									    <a class="nav-link prof-nav" id="Photo" href="#">PHOTOS</a>
									  </li>
									  <li class="nav-item">
									    <a class="nav-link prof-nav" id="Bio" href="#">BIO</a>
									  </li>
									  <!--
									  <li class="nav-item">
									    <a class="nav-link prof-nav" id="Bookme" href="#">GIVE/DONATE</a>
									  </li>
									  -->
									   <li class="nav-item">
									    <a class="nav-link prof-nav" id="Subscribe" href="#">SUBCRIBE</a>
									  </li>
									</ul>
								<!--/new nav -->
							</div>
							<!-- /Menu Bar this Section -->
							<hr class="my-1"> <!-- Page Divider -->

							<!-- DISPLAY CONTENT RETURNED FROM THE XMLHTTPREQUESTS -->
								<div class="container" id="contentContainer">
									<div class="tab-content Vid" id="">
										<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/profVidTab.php'); ?>
									</div>
									<div class="tab-content d-none Photo" id="">
										<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/profPhotoTab.php'); ?>
									</div>
									<div class="tab-content d-none Bio" id="">
										<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/profBioTab.php'); ?>
									</div>
									<div class="tab-content d-none Bookme" id="">
										<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/churchProfBookmeTab.php'); ?>
									</div>
									<div class="tab-content d-none Subscribe" id="">
										<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/profSubscribeTab.php'); ?>
									</div>
								</div>
							<!-- /DISPLAY CONTENT RETURNED FROM THE XMLHTTPREQUESTS -->
						</div>
					</div>
				<!-- /Content Container -->
			</div>
		</div>
	</div>


<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
	/* Content Nav Menu functionaity */
		$('.prof-nav').click(function(event){
			event.preventDefault(); 
			$('.prof-nav').removeClass('active');
			$(this).addClass('active');
			$('.tab-content').addClass('d-none');
			
			var tab = $(this).attr('id');
			$('.'+tab).removeClass('d-none');


			if(tab == 'Vid'){
				var userID = $('.userID').val(); 
			}
			if(tab == 'Photo'){
				var userID = $('.userID').val();
			}
			if(tab == 'Bookme'){
				$('.choiceBook').removeClass('d-none');
				$('.current-gig-options').addClass('d-none');
				document.getElementById('bookme-form').reset(); 
				document.getElementById('book4existing').reset();
			}
		});
	/* END - Content Nav Menu functionaity */

	/* Date and Time Picker plugin JS */
		$(function () {
			var dat = $("input[name=todaysDate]").val();
			
		    $("#datetimepicker1").datetimepicker({
			 	format: "MM/DD/YYYY",
			 	//defaultDate: "12/13/2017",
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
		        format: "LT",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });		
		});
	/* END - Date and Time Picker plugin JS */

	/* Select Bookme Type */
		$('.bk-type').click(function(event){
			event.preventDefault();
			var type = $(this).attr('id'); 
			$('.choiceBook').addClass('d-none');
			$('.'+type).removeClass('d-none');
		});
	/* END - Select Bookme Type */


	/* Add a New Video */
		var form1 = document.forms.namedItem("videoAdd");
		form1.addEventListener('submit', function(event){
			$('#error-message').addClass('d-none');

			/* Prevent Users from embedding youtube links and uploading video simaltaneously */
				// $('#vidName').val() != '' || $('#vidDescr').val() != '' || 
				var vidMethod = '';
				if($('#youtubeInput').val() != '' && ($('#videoFile').val() != '' || $('#thumbnailFile').val() != '')) {
					/* print an error to the Modal */ 
						$('#error-message').removeClass('d-none');
						$('#error-text').html('Choose Only One Option to Add Video');
				}
				else{
					if($('#youtubeInput').val() != '' && $('#vidTalent').val() != ''){
						/* Define method type for GET Var*/
							vidMethod = 'youtube';
					}
					else{
						if($('#vidTalent').val() != ''&& $('#vidName').val() != '' && $('#vidDescr').val() != '' && $('#videoFile').val() != ''){
							/* Define method type for GET Var*/
								vidMethod = 'upload';	
						}
						else{
							$('#error-text').html('Please Complete All Upload Fields');
							$('#error-message').removeClass('d-none');
						}
					}
				}
			/* END - Prevent Users from embedding youtube links and uploading video simaltaneously */

			/* If video method is assigned, send form info to fileUpload.php */
				if(vidMethod != ''){
					var userID = $('.userID').val();
					var formData1 = new FormData(form1);
					// console.log(formData1);
					var addNewVid = new XMLHttpRequest();
					/*
					addNewVid.addEventListener("progress",testFunction);
					addNewVid.addEventListener("load",loaded);
					addNewVid.addEventListener("error",failed);
					addNewVid.addEventListener("abort",abort);
					*/
					formData1.append('videoType',vidMethod);
					formData1.append('iLoginID', userID);

					addNewVid.onreadystatechange = function(){

						if(addNewVid.readyState == 4){
							/************************* Create File Upload Status bar *************************/
							// console.log(addNewVid.response);
								try {
						            var resp = JSON.parse(addNewVid.response);
						        } catch (e){
						            var resp = {
						                status: 'error',
						                // data: 'Unknown error occurred: [' + addNewVid.responseText + ']'
						            };
						        }
						        // console.log(resp.status + ': ' + resp.data);

							/********************** END - Create File Upload Status bar **********************/
						}

						if(addNewVid.readyState == 4 && addNewVid.status == 200){
							console.log(addNewVid.responseText);
							if(addNewVid.responseText != '' && addNewVid.responseText =='File Upload Successful'){
								$('#error-text').html(addNewVid.responseText);
								$('#error-message').removeClass('d-none');
								document.getElementById("videoAddID").reset();
								location.reload(); 
							}
							else{
								$('#error-text').html(addNewVid.responseText);
								$('#error-message').removeClass('d-none');
							}
						}
						//console.log('error: '+ev.); 
					}

					var serverUploadProgress = document.querySelector('.serverUpload');
					addNewVid.upload.addEventListener('progress', function(e){
					    // _progress.style.width = Math.ceil((e.loaded/e.total) * 100) + '%';
					    console.log('loaded: '+e.loaded+' and Total: '+e.total+'loade/total: '+(Math.ceil((e.loaded/e.total) * 100) + '%'));
					    var percentLoaded = Math.ceil((e.loaded/e.total) * 100); 
					    if (percentLoaded <= 100) {
					        serverUploadProgress.style.width = percentLoaded + '%';
					        serverUploadProgress.textContent = percentLoaded + '%';
					    }
					    // else if(percentLoaded == 100){

					    // }
					}, false);
					addNewVid.open("POST", "fileUpload.php"); 
					/*
					function testFunction(ev){
						console.log("loaded: "+ev.loaded);
						console.log("total: "+ev);
						console.log("total: "+ev.lengthComputable);
					}
					function loaded(ev){
						console.log("load: "+ev.loaded);
					}
					function failed(ev){
						console.log("error: "+ev);
					}
					function abort(ev){
						console.log("abort: "+ev);
					}
					*/
					addNewVid.send(formData1);  
				}
			/* END - If video method is assigned, send form info to fileUpload.php */

			event.preventDefault();
		}, false);
	/* END - Add a New Video */	

	/* Add New Photo */
		var form2 = document.forms.namedItem("photoAdd");
		form2.addEventListener('submit', function(event){

			var photoFile = $('#photoFile').val();
			var newAlbumName = $('#newAlbumName').val();
			var photoAlbums = $('#photoAlbums').val(); 

			if(photoAlbums == '' && newAlbumName == '' || (photoAlbums != '' && newAlbumName != '')){
				$('#error-message-photo').removeClass('d-none');
				document.getElementById('error-text-photo').innerHTML = 'Please Choose a Current Album OR Create a New Album!!!';
			}
			else{
				console.log('testing2');
				if(photoFile == ''){
					$('#error-message-photo').removeClass('d-none');
					document.getElementById('error-text-photo').innerHTML = 'Please Choose a Photo to Upload!!!';
				}
				else{
					var photo = 'valid';
				}
			}
			var photo = 'valid';
			// console.log('photo = '+photo);
			if(photo == 'valid'){
				var userID = $('.userID').val();
				var formData2 = new FormData(form2);
				var addNewPhoto = new XMLHttpRequest();
				formData2.append('iLoginID', userID);
				
				addNewPhoto.onreadystatechange = function(){
					if(addNewPhoto.readyState == 4 && addNewPhoto.status == 200){
						console.log(addNewPhoto.responseText);
					}
				}
				addNewPhoto.open("POST", "churchFileUpload.php");
				addNewPhoto.send(formData2); 
			}
			event.preventDefault();
		}, false);
		
	/* END - Add New Photo */
</script>
