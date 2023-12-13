<?php
	include(realpath($_SERVER['DOCUMENT_ROOT']) .'/common/config.php');
/**************************** Query Databases for Gig and Event Info *************************/
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/include/dbConnect.php');
	include(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/phpBackend/goog_cal_funct.php');

	/* Handle Get Variable*/
	$emptyArray = array();
		if($_GET){
			
			if( $_GET['show_goog_events'] != '' ){
				/* Update the google calendar table show events status */
					$status = intval($_GET['show_goog_events']);
					$array = array('show_events' => $status);
					$cond = 'iLoginID = "'. $currentUserID . '"';
					$update_show_events = updateTable($db, $array, $cond, 'googlecalendarmaster');

					if( $update_show_events == true ){
						/* update the session var */
							$response['show_events_status_updated'] = true; 	
							$_SESSION['google_cal_accessToken']['show_events'] = $status;
					}else{
						$response['show_events_status_updated'] = false; 
					}

				/* Return JSON response to page */
					echo json_encode($response);
			}
			elseif( (isset($_GET['u_Id']) > 0 || $_GET['code']) && isset($currentUserID) ){  //&& isset($_GET['status'])
				$userLogin = intval($_GET['u_Id']);
				$start = $_GET['start']; 
				$end = $_GET['end']; 

				/* Get usertype of calendar owner */
					$userRow = $obj->fetchRow('loginmaster', 'iLoginID = ' . $userLogin,$db);
					$u_type = $userRow['sUserType'];
			
				/* New Calendar backend */
		
					/* Query the GospelScout database for user's gigs */
						require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/phpBackend/gsDB_gigQuery.php');

					if( ($currentUserID == $_GET['u_Id']) || $_GET['code'] ){

						/* Query the Google calendar api for user's current events */
							require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/phpBackend/gcDB_gigQuery.php');
					}

				/************************* Create JSON Feed *************************/
					/* JSON Encode the final events-list array and echo to the page to create JSON feed for calendarDisplay.php */
						if( empty($finalList2) ){
							$finalList2 = array();
						}
						if( empty($finalList) ){
							$finalList = array();
						}

						$eventList_final = array_merge($finalList,$finalList2);
						$finalList = json_encode($eventList_final);
						echo $finalList;
				/************************* Create JSON Feed *************************/
			}
			else{
				exit('No Id or user needs to login');
			}
		}

		if( $_POST['goog_action'] == 'unlink'){
			/* Un-link user's google calendar */
				$cond = 'iLoginID = "'. $currentUserID . '"';
				$unlink_google_cal = pdoDelete($db,$cond, 'googlecalendarmaster'); 

				if( $unlink_google_cal ){
					$response['cal_removed'] = true; 

					/* Unset the $_SESSION['google_cal_accessToken'] var */
						unset( $_SESSION['google_cal_accessToken'] );
				}
				else{
					$response['cal_removed'] = false; 
				}
			
			/* Return JSON Response */
			echo json_encode($response);
		}
?>	