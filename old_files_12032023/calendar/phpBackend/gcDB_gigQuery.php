<?php
/* We need to return a multi-dimensional array of the following: 
	array('id','start','end','title','url','backgroundColor','textColor'); 
*/
	if($_GET['linked_cal'] ==='true' || $_GET['code'] != ''){
		/* Instantiate new client obj */
			$client_obj = getClient($currentUserID);
			$current_acc_tok = $client_obj['access_token'];
			$client = $client_obj['client'];
			$emptyArray = array();
			
		/* Preliminary action - if access token expired or non-existent*/
			if( $client->isAccessTokenExpired() ) { 
				


				if( $_GET['code'] != ''){
			    	/* Get New Access Token with AUTh code */
				    	$authCode = trim( $_GET['code'] ); 
						$client = getNewAccessToken($client,$authCode);
			    }
			    else{
					
			    	/* Call function to refresh or reset user access token */
						$client = refresheAccessToken($client);
			    }
			  
			   /********************* Set client access token and update database *********************/

				   	/* Get & Set New Access token */
				    	$new_access_token = $client->getAccessToken();
				    	$client->setAccessToken($new_access_token);
						// echo '<pre>';
						// 	var_dump($new_access_token);exit;

				    /* Get user's current primary calendar ID */
				    	/* Instantiate new service obj */
							$service = new Google_Service_Calendar($client);

						/* Get calendar list */
							$calendars = getUserCalendars($service);
							

						/* Filter for calendar id's and calendar names */
							foreach($calendars as $calendars_index => $calendars_value){
								$curr_goog_cal[$calendars_index]['cal_id'] = $calendars_value['id'];
								$curr_goog_cal[$calendars_index]['cal_name'] = $calendars_value['summary'];
								$is_primary = $calendars_value->primary;
								
								if( $is_primary ){ $primary_cal_id = $curr_goog_cal[$calendars_index]['cal_id']; }
							}

				    /* Update googlecalendarmaster table with user's new access token */
						$cond = 'iLoginID = "'. $currentUserID . '"';
						$new_access_token['lastUpdate'] = $today;
						$new_access_token['calendar_id'] = $primary_cal_id;

						if( count($current_acc_tok) > 0 ){
							$update_user_token = updateTable($db, $new_access_token, $cond, 'googlecalendarmaster');
						}
						else{
							$new_access_token['iLoginID'] = $currentUserID;
							foreach($new_access_token as $new_access_token_index => $new_access_token_val){
								$field_ins[] = $new_access_token_index;
								$value_ins[] = $new_access_token_val;
							}
							$update_user_token = pdoInsert($db,$field_ins,$value_ins,'googlecalendarmaster');
						}

					/* Set the SESSIONS var */
						if( $update_user_token || $update_user_token > 0 ){

							/* Update succeeded */
								$paramArray_get_a_token['iLoginID']['='] = $currentUserID;
								$accessToken = pdoQuery('googlecalendarmaster','all',$paramArray_get_a_token,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];

								/* Remove unnecessary elements */
						    		unset($accessToken['id']);
						    		unset($accessToken['iLoginID']);
						    		unset($accessToken['lastUpdate']);

								$objsession->set('google_cal_accessToken',$accessToken); 
						}
						else{
							/* Update failed */
							$response['error'] = 'db_update_fail_sessVar_not_set';
						}

					if($_GET['code'] != '' ){
						/* After $_SESSION Var is set - redirect back to user's calendar*/
							echo '<script>window.location = "https://www.gospelscout.com/calendar/?u_Id=' . $iLoginID . '";</script>';
					}

			   /****************** END - Set client access token and update database ******************/
			}

		/* Query current user's google calendar */

			//1. Instantiate new google service calendar object 
				$service = new Google_Service_Calendar($client);
				$calendarId = 'primary';

			//2. Ensure authenticated user has write access to the specified calendar 
				$calendarList = $service->calendarList->get($calendarId);
				$access_role = $calendarList->accessRole; 

			//3. Fetch google calendar events 
				if( $access_role =='owner' ){
					$events = get_events($service, $calendarId, $start, $end);
					
					if( count($events) > 0 ){
						$newkeys = array('id','start','end','title','url','backgroundColor','textColor'); 
						for($t=0;$t<count($events);$t++){
							/* Remove unnecessary elements */
								unset($events[$t]['creator_name']);
								unset($events[$t]['creator_email']);
								unset($events[$t]['event_status']);
								unset($events[$t]['date_created']);
								unset($events[$t]['last_updated']);

							/* Add necessary elements */
								$events[$t]['backgroundColor'] = 'red';
								$events[$t]['textColor'] = 'rgba(0,0,0,.7)';

							/* Change array keys */
								$finalList2[$t] = array_combine($newkeys, $events[$t]);		
						}
					}
				}
				
	}

?>