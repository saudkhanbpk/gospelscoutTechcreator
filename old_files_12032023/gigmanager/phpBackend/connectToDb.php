<?php

/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Get Date/Time */
		$today0 = date_create();
		$today = date_format($today0, 'Y-m-d H:i:s');
		$todayDate = date_format($today0, 'Y-m-d');
	
	/* Var */
		$emptyArray = array();

	if($_GET['gig_status'] != ''){
		
		/* Fetch artist's gigs from postedgiginquirymaster table */
			$gigStatus = trim( $_GET['gig_status'] );
			if( $gigStatus == 'bid'){
				$columnsArray = array('postedgiginquirymaster.*','giftmaster.sGiftName','postedgigsmaster.gigDate','postedgigsmaster.gigType');
				$category = $_GET['gig_status'];
				$paramArray['iLoginid']['='] = $currentUserID; 
				$innerJoinArray = array(
					array('giftmaster','iGiftID','postedgiginquirymaster','artistType'),
					array('postedgigsmaster','gigId','postedgiginquirymaster','gigId')
				);
				$getArtistsGigs = pdoQuery('postedgiginquirymaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
				// var_dump($getArtistsGigs);exit;
			} elseif( $gigStatus == 'requested'){
				$getArtistsGigs = array();
			}
			// else{
			// 	$columnsArray = array('eventartists.*','giftmaster.sGiftName');
			// 	// $paramArray['artiststatus']['='] 
			// 	$category = trim( $_GET['gig_status'] ); 
			// 	$paramArray['iLoginid']['='] = $currentUserID; //intval( trim( $_GET['iLoginID'] ) ); 
			// 	$innerJoinArray = array(
			// 		array('giftmaster','iGiftID','eventartists','artistType')
			// 	);
			// 	$getArtistsGigs = pdoQuery('eventartists',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

			// }	
			
			if( count($getArtistsGigs) > 0){
				/* Add vars */
					foreach($getArtistsGigs as $artistGigIndex => $artistGig){
						/* Add age of post and event date reformat  */
							$age_of_post = ageFuntion($artistGig['dateTime']); 
							$getArtistsGigs[$artistGigIndex]['age_of_post'] = $age_of_post;

							$new_date_format = date_create($getArtistsGigs[$artistGigIndex]['gigDate']);
							$new_date_format = date_format($new_date_format, 'm/d/Y');
							$getArtistsGigs[$artistGigIndex]['eventdate'] = $new_date_format;

						/* Reformat Talent */
							$getArtistsGigs[$artistGigIndex]['sGiftName'] = str_replace('_','/',$artistGig['sGiftName']);

						/* is artist selected */
							if($artistGig['selected']){
								$getArtistsGigs[$artistGigIndex]['artistSelected'] = true; 
							}else{
								$getArtistsGigs[$artistGigIndex]['artistSelected'] = false; 
							}
							
						/* Add event type */
							// if($artistGig['eventtable'] == 'puweventsmaster'){
							// 	$getArtistsGigs[$artistGigIndex]['eventType'] = '<span class="text-gs">#</span><span class="text-black" style="color:rgba(0,0,0,.6)">popUpWorship</span><span class="text-gs">LA</span>';
							// }
							// elseif($artistGig['eventtable'] == 'postedgigsmaster'){
							// 	$getArtistsGigs[$artistGigIndex]['eventType'] = 'Posted Gig Ad';
							// }

						// if( $artistGig['selected']){
						// 	$gigs_by_category['artistSelected'][] = $getArtistsGigs[$artistGigIndex];
						// }else {
						// 	$gigs_by_category['artistNotSelected'][] = $getArtistsGigs[$artistGigIndex];
						// }
						// $gigs_by_category[$artistGig['artiststatus']][] = $getArtistsGigs[$artistGigIndex];
					}
					// var_dump($getArtistsGigs);
					$response['status'] =  ucfirst( trim( $_GET['gig_status'] ) ); 
					$response['status_counts'] = array(
						'pending' => count($gigs_by_category['pending']),
						// 'confirmed' => count($gigs_by_category['confirmed']),
						'confirmed' => count($gigs_by_category['artistSelected']),
						'declined' => count($gigs_by_category['declined']),
						'canceled' => count($gigs_by_category['canceled']),
						// 'bid' => count($gigs_by_category['requestmade'])
						'bid' => count($getArtistsGigs)
					);		
					if( count($getArtistsGigs) > 0){//[$category]
						$response['gigsResult'] = true; 
						$response['gigs'] = $getArtistsGigs;//[$category]
					}
					else{
						$response['gigsResult'] = false; 
					}
			}
			else{
				$response['gigsResult'] = false; 
				$response['status'] =  ucfirst( trim( $_GET['gig_status'] ) ); 
			}

			/* Return JSON response */
			// var_dump($response);
				echo json_encode($response);
	}
	elseif($_GET['gigAds'] == 'true'){
		/* fetch current user's gig ads */	
			$paramArray['gigManLoginId']['='] = $currentUserID;
			$orderByParam = 'gigDate';
			$columnsArray = array('postedgigsmaster.*');
			$fetch_GigAds = pdoQuery('postedgigsmaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

			if( count($fetch_GigAds) > 0 ){
				foreach($fetch_GigAds as $fetch_GigAd_index => $fetch_GigAd){
					/* Add event date reformat */
						$new_date_format = date_create($fetch_GigAd['gigDate']);
						$new_date_format = date_format($new_date_format, 'm/d/Y');
						$fetch_GigAds[$fetch_GigAd_index]['gigDate'] = $new_date_format;

					/* Truncate the Gig Id */
						$fetch_GigAds[$fetch_GigAd_index]['gigId_display'] = truncateStr($fetch_GigAd['gigId'], 10);

					/* Determine gig ad has expired */
						if($fetch_GigAd['gigDate'] > $todayDate){
							$gigAds_exp_upcom['Upcoming'][] = $fetch_GigAds[$fetch_GigAd_index];
						}
						else{
							$gigAds_exp_upcom['Expired'][] = $fetch_GigAds[$fetch_GigAd_index];
						}
				}


				$upcCount = count($gigAds_exp_upcom['Upcoming']); 
				$expiredCount = count($gigAds_exp_upcom['Expired']); 
				if( $upcCount == 0 ){ $gigAds_exp_upcom['Upcoming'] = false; }
				if( $expiredCount == 0 ){ $gigAds_exp_upcom['Expired'] = false; }
				$response['gigs'] = $gigAds_exp_upcom;
			}
			else{
				$response['gigs'] = false;
				$response['err'] = 'no_gig_ads';
			}

		/* Return JSON Response */
			echo json_encode($response);
	}
	elseif( $_GET['rowEntryID'] != ''){//$_GET['eventTable'] != '' &&

		/* Query the event table passed */
			$table = 'eventartists';
			// $paramArray['eventID']['=']	= trim($_GET['eventID']);
			// $paramArray['eventartists.id']['='] = trim($_GET['rowEntryID']);
			// $innerJoinArray = array( 
			// 	array(trim($_GET['eventTable']), 'gigId', $table, 'gigId'),
			// 	array('eventartistspay','tal_tracker_id',$table,'tal_tracker_id'),
			// 	array('giftmaster','iGiftID', 'eventartists','artistType')
			// );
			// $getSelectGig = pdoQuery($table,'all',$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

			$columnsArray = array('postedgiginquirymaster.*','giftmaster.sGiftName','postedgigsmaster.gigDate','postedgigsmaster.setupTime','postedgigsmaster.startTime','postedgigsmaster.endTime','postedgigsmaster.gigType','postedgigneededtalentmaster.*');
				$category = $_GET['gig_status'];
				$paramArray['iLoginid']['='] = $currentUserID; 
				$paramArray['postedgiginquirymaster.id']['='] = trim($_GET['rowEntryID']);
				$innerJoinArray = array(
					array('giftmaster','iGiftID','postedgiginquirymaster','artistType'),
					array('postedgigsmaster','gigId','postedgiginquirymaster','gigId'),
					array('postedgigneededtalentmaster','tal_tracker_id','postedgiginquirymaster','tal_tracker_id')
				);
				$getSelectGig = pdoQuery('postedgiginquirymaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
				
			if( count($getSelectGig) > 0 ){

				foreach($getSelectGig as $getSelectGig_index => $getSelectGig_value){
					/* Reformat Date and Times */
						$new_date_format = date_create($getSelectGig_value['gigDate']);
						$new_date_format = date_format($new_date_format, 'm/d/Y');
						$getSelectGig[$getSelectGig_index]['eventdate'] = $new_date_format;

						$new_time1_format = date_create($getSelectGig_value['setupTime']);
						$new_time2_format = date_create($getSelectGig_value['startTime']);
						$new_time3_format = date_create($getSelectGig_value['endTime']);
						$new_time1_format = date_format($new_time1_format, 'h:ia');
						$new_time2_format = date_format($new_time2_format, 'h:ia');
						$new_time3_format = date_format($new_time3_format, 'h:ia');

						$getSelectGig[$getSelectGig_index]['setupTime'] = $new_time1_format;
						$getSelectGig[$getSelectGig_index]['startTime'] = $new_time2_format;
						$getSelectGig[$getSelectGig_index]['endTime'] = $new_time3_format;
					/* Reformat money */
						$getSelectGig[$getSelectGig_index]['depositamount'] = CentsToDollars($getSelectGig_value['tal_pay']);
							
					/* Check if event date has expired */
						if($today > $getSelectGig_value['gigDate'] ){
							$getSelectGig[$getSelectGig_index]['event_expired'] = true;
						}
						else{
							$getSelectGig[$getSelectGig_index]['event_expired'] = false;
						}

					/* Add age of post and event date reformat  */
						$age_of_post = ageFuntion($getSelectGig_value['dateTime']); 
						$getSelectGig[$getSelectGig_index]['age_of_post'] = $age_of_post;

					/* Reformat Talent */
						$getSelectGig[$getSelectGig_index]['sGiftName'] = str_replace('_','/',$getSelectGig_value['sGiftName']);
				}
				// var_dump($getSelectGig);
				$response['gig_found'] = true; 
				$response['gig_info'] = $getSelectGig;
			}
			else{
				$response['gig_found'] = false;
			}

		/* Return JSON response */	
			echo json_encode($response);
	}	

	if($_POST['artiststatus'] != ''){
		/* Update the eventartist table with artist response */
			$g_id = $_POST['gig_id']; 
			$u_id = $_POST['u_id']; 
			unset($_POST['gig_id']);
			unset($_POST['u_id']);

			$array = $_POST;
			$cond = 'iLoginid ="' . $u_id . '" AND gigId = "' . $g_id.'"';
			$send_art_response = updateTable($db, $array, $cond,'eventartists');

			if($send_art_response == true){
				$response['response_sent'] = true; 
			}
			else{
				$response['response_sent'] = false; 
			}

		/* Return JSON Response */
			echo json_encode($response);
	}
?>