<?php
	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Get Date/Time */
		$today = date_create();
		$today = date_format($today, 'Y-m-d H:i:s');
		$todayDate = date_format($today, 'Y-m-d');

	/* check for GLOBAL vars */
		if( count($_FILES) > 0 && $_POST['hostApp'] ) {

				/* vars */
					$table = 'puwhostsmaster';
					$columnsArray[] = 'id';
					$paramArray['host_address']['='] = trim( $_POST['host_address'] );
					$paramArray['host_email']['='] = trim( $_POST['host_email'] );
				
				/* Check that user hasn't already applied to host */
					$query = pdoQuery($table,$columnsArray,$paramArray);

				if( count($query) > 0 ){
					$conf['alreadyApplied'] = true; 
					$conf['hostAdded'] = false;
					$conf['daysAdded'] = false; 
					$conf['imgsAdded'] = false; 
				}
				else{
					$conf['alreadyApplied'] = false; 
					$days = $_POST['days'];
					$_POST['dateTime'] = $today; 

					/* remove unnecessary elements */
						unset($_POST['hostApp']);
						unset($_POST['days']);

					/* Remove empty elements */
						foreach ($_POST as $key0 => $value0) {
							if($value0 !== ''){
								$post[$key0] = $value0; 
							}
						}

					/* Convert start and end time to proper format*/
						$startTime = date_create($post['startTime']);
						$post['startTime'] = date_format($startTime, 'H:i');

						$endTime = date_create($post['endTime']);
						$post['endTime'] = date_format($endTime, 'H:i');

					/* Insert Host info into puwhostsmaster table */
						foreach ($post as $key1 => $value1) {
							$field[] = $key1;
							$value[] = $value1;
						}

						$table = 'puwhostsmaster';
						$table1 = 'puwavailhostdays';
						$hostAdded = $obj->insert($field,$value,$table);

					/* Check for host_id to verify host was added to the table - add host days */
						if($hostAdded > 0){
							$conf['hostAdded'] = true; 

							/* Insert days host is available */
								foreach($days as $day){
									$field2 = array(); 
									$value2 = array(); 

									$field2[] = 'hostID';
									$field2[] = 'day';

									$value2[] = $hostAdded;
									$value2[] = $day;

									/* Insert days host is available */
										$hostDaysAdded = $obj->insert($field2,$value2,$table1);

									if( $hostDaysAdded > 0 ){
										$conf['daysAdded'] = true; 
									}
									else{
										$conf['daysAdded'] = false; 
										break;
									}
								}
						}
						else{
							$conf['hostAdded'] = false; 
						}

					/* If host and host availability added successfully - process img files */
						if( $conf['hostAdded'] && $conf['daysAdded'] ){
							$userType = 'hostApplicant';
							$fileType = 'venueImgs';
							$hostApplicantID = $hostAdded; 
							
							/* Call file upload function from gsFunctPage.php */
								$fileUploaded = handleMultipleFileUpload($userType, $fileType, $hostApplicantID,$_FILES['hostImgs']);


							/* Add host images to the puwhostimages table */
								$table3 =  'puwhostimages';

								foreach($fileUploaded['file_path'] as $imagePath){

									$field3 = array(); 
									$value3 = array(); 

									$field3[] = 'file_path';
									$field3[] = 'host_id'; 

									$value3[] = $imagePath;
									$value3[] = $fileUploaded['iLoginID'];

									/* Insert URL Paths */
										$hostImgsAdded = $obj->insert($field3,$value3,$table3);


									if( $hostImgsAdded > 0 ){
										$conf['imgsAdded'] = true; 
									}
									else{
										$conf['imgsAdded'] = false; 
										break;
									}
								}
						}
				}

				/* return confirmation var to the index page */
					echo json_encode($conf);
		}
		elseif(count($_GET) > 0 ){
			if($_GET['puwEvents']){
				$table = 'puweventsmaster';
				$columnsArray = 'all';
				$innerJoinArray = array(
								array("puwhostsmaster","id","puweventsmaster","hostID")
							);
				$paramArray['cancelStatus']['='] = 0; 
				$paramArray['date']['>'] = $today; 
				$query = pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray);

				/* structure array by state */
					foreach ($query as $events) {
						$state = $events['state'];
						
						/* Re-format the dates*/
							$eventDate = date_create($events['date']);
							$events['date'] = date_format($eventDate, 'D, M. d');
						
						$eventByState[$state][] = $events;
					}

				if(count($query) > 0 ){

					/* Replicate the div to display the upcoming puw events */
					foreach($eventByState as $stateEventsIndex => $stateEvents){
?>					
						<!-- State Row -->
		                  <div class="row mt-3 pl-md-4 pt-2 pb-3 card-shadow">
		                    <div class="col-9 text-center mx-auto stateHeader">
		                      <h4 class="text-gs"><?php echo $stateEventsIndex;?></h4>
		                    </div>

		                    <!-- Loop through the Events  -->
			                    <?php foreach($stateEvents as $eventIndex => $eventDetails){?> 
				                    <!-- event tile -->
				                      <div class="col-md-5 ml-md-4 my-2 p-0 text-center" style="background-image:url('<?php echo URL;?>img/music1.jpeg');background-position: center;background-size:cover; ">
				                        <div class="container text-white pt-3 pb-0 m-0" style="background-color: rgba(0,0,0,.5)">
				                          
				                          <div class="row px-2">
				                            <div class="col">
				                              <p class="mb-0 text-truncate" style="font-size:1.5em"><?php echo $eventDetails['city'];?></p>
				                            </div>
				                          </div>

				                           <div class="row px-2">
				                            <div class="col">
				                              <p style="font-size:1.2em"><?php echo $eventDetails['date'];?></p>
				                            </div>
				                          </div>

				                          <div class="row mb-1">
				                            <div class="col-7 text-left align-middle" style="border-right: solid 1px white">
				                              <span class="m-0 font-weight-bold " style="font-size: .7em"><?php if($eventDetails['buildingType'] == 'residential'){ echo 'Home';}else{ echo 'non-residential';}?></span>
				                              
				                              <?php if($eventDetails['hCapAccessible'] == '1'){?>
				                              	<img class=" ml-1 img-fluid" src="<?php echo URL;?>img/accessible-icon-white.png" width="15" height="15" data-src="" alt="Generic placeholder image">
				                              <?php }?>
				                            </div>
				                            <div class="col-5 m-0"> 
				                              <button class="btn-sm btn-block bg-gs text-white mr-2" eventID="<?php echo $eventDetails['id'];?>" id="attendPUW" style="max-width:100px">Attend</button>
				                            </div>

				                          </div>
				                        </div> 
				                      </div>
				                    <!-- /event tile -->
			                    <?php }?>
			                <!-- /Loop through the Events  -->

		                  </div>
		                <!-- /State Row -->
<?php
					}
				}
				else{
					echo '<p class="lead">Sorry, there are no scheduled dates <span class="text-gs">@</span> this time...</p>';
					// echo json_encode($query['puwEvents'] = false);
				}
			}
			elseif($_GET['memberAttend']){;

				/* Remove unnecessary element */
					unset($_GET['memberAttend']);

				/* Check if user already applied to attend this event */
					$cond = 'iLoginID = '.$_GET['iLoginID'].' AND eventID = '.$_GET['eventID'];
					$memberApplied = $obj->fetchRow('puwattendeemaster', $cond);

					if(count($memberApplied) > 0){
						$conf['membApplied'] = true; 
					}
					else{
						/* Query usermaster for user info */
							$columnsArray = array('sFirstName','sLastName','sContactEmailID','sContactNumber');
							$paramArray['iLoginID']['='] = $_GET['iLoginID'];
							$table = 'usermaster';
							$getUserInfo = pdoQuery($table,$columnsArray,$paramArray);

						/* Add user to the puwattendeemaster table */
							$_GET['fName'] = $getUserInfo[0]['sFirstName'];
							$_GET['lName'] = $getUserInfo[0]['sLastName'];
							$_GET['email'] = $getUserInfo[0]['sContactEmailID'];
							$_GET['phone'] = $getUserInfo[0]['sContactNumber'];
							$_GET['applyDate'] = $today;


							foreach($_GET as $u_info_index => $u_info){
								$field[] = $u_info_index;
								$value[] = $u_info;
							}

							$addAttendee = $obj->insert($field,$value,'puwattendeemaster');
							if($addAttendee > 0){
								$conf['memberAdded'] = true; 
							}
							else{
								$conf['memberAdded'] = false; 
							}
					}
					echo json_encode($conf);
			}
			elseif($_GET['user_id'] > 0 && $_GET['reqCheck'] == 'true'){

				$cond1 = 'iLoginID = ' . $_GET['user_id'] . ' AND removedStatus = 0';
				$cond2 = 'iLoginID = ' . $_GET['user_id'];
				$table1 = 'artistvideomaster';
				$table2 = 'usercontentlinksmaster';

				$query['video'] = $obj->fetchRowAll($table1,$cond1);
				$query['musicLinks'] = $obj->fetchRowAll($table2,$cond2);
				if(count($query['video']) > 0 || count($query['musicLinks']) > 0){
					$conf['reqsMet'] = true;
				}
				else{
					$conf['reqsMet'] = false;
				}
				echo json_encode($conf);
			}
		}
		elseif($_POST){

			if($_POST['attendEvent']){
				/* vars */
					$table = 'puwattendeemaster';
					$columnsArray[] = 'id';
					$paramArray['eventID']['='] = $_POST['eventID'];
					$paramArray['email']['='] = $_POST['email'];

				/* Check that user hasn't already applied to this event */
					$query = pdoQuery($table,$columnsArray,$paramArray);

				if(count($query) > 0){
					$conf['attendeeAdded'] = false;
					$conf['alreadyApplied'] = true;
				}	
				else{
					/* remove elements */
						unset($_POST['attendEvent']);
					
					/* Add current date/time */
						$_POST['applyDate'] = $today;

					/* Insert into puwattendeemaster */
						foreach ($_POST as $key => $val) {
							$field[] = $key; 
							$value[] = $val;
						}

						// $conf = $value;

						$attendeeAdded = $obj->insert($field,$value,$table);
						if($attendeeAdded > 0){
							$conf['attendeeAdded'] = true; 
						}
						else{
							$conf['attendeeAdded'] = false; 
						}
				}
				
				/* Confirmation object */
					echo json_encode( $conf );
			}
			else{

				/* remove empty elements from $_POST array */
					foreach($_POST as $entryIndex => $entry){

						if($entryIndex == 'usercontentlinksmaster'){
							foreach ($entry as $linkKey => $linkValue) {
								if($linkValue !== ''){
									$linkMaster[$entryIndex][$linkKey] = $linkValue;
								}
							}
						}
						else{
							if($entry !== ''){
								$post[$entryIndex] = $entry; 
							}
						}
					}

				if(count($post) > 0){
					/* Insert new PUW Applicants and applicant links, if applicable */
						$table1 = 'puwartistmaster';
					
						/* insert into puwartistmaster */
							$post['dateTime'] = $today;
							foreach($post as $fieldArtist => $valArtist){
								$field1[] = $fieldArtist; 
								$value1[] = $valArtist;
							}
							$artistInserted = $obj->insert($field1,$value1,$table1);
							if($artistInserted > 0){
								$conf['artist'] = true;
							}
							else{
								$conf['artist'] = false;
							}

					/* Create link array for table insertion */
						if($linkMaster){
							$i = 0;
							foreach($linkMaster['usercontentlinksmaster'] as $linkINdex => $eachLink){
								$linkMasterUpdated[$i]['platform'] = $linkINdex;
								$linkMasterUpdated[$i]['url'] = $eachLink;
								$linkMasterUpdated[$i]['iLoginID'] = $post['iLoginID'];

								$i++;
							}

							$table2 = 'usercontentlinksmaster';

							/* insert into usercontentlinksmaster */
								foreach($linkMasterUpdated as $linkData){
									$field2 = array();
									$value2 = array();
									foreach($linkData as $fieldLinks => $valLinks){
										$field2[] = $fieldLinks; 
										$value2[] = $valLinks;
									}

									$linksInserted = $obj->insert($field2,$value2,$table2);
									if($linksInserted > 0){
										$conf['urls'] = true;
									}
									else{
										$conf['urls'] = false;
									}
								}
						}
		
						/* Confirmation object */
							echo json_encode($conf);
				}
			}
		}


?>