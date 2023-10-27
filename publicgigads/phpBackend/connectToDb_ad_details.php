<?php 

/* Create DB connection to Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
  	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

  	$today = date_create('',timezone_open("America/Los_Angeles"));
	$today = date_format($today, 'Y-m-d H:i:s');
	$emptyArray = array();

	if($_GET['u_id']){
		/* query for the artist info */
			$u_id = trim(intval($_GET['u_id']));
			$g_id = trim($_GET['g_id']);
			$tal_tracker = trim($_GET['tal_tracker_id']);

			/* Query the gigsinquirymaster table */
                try{
                	/* Query the db for gig inquiries */
		                $columnsArray1 = array('usermaster.*','postedgiginquirymaster.*','states.statecode','postedgigsmaster.gigDate');
		                $paramArray1['postedgiginquirymaster.iLoginID']['='] = $u_id;
		                $paramArray1['postedgiginquirymaster.gigId']['='] = $g_id;
		                $innerJoinArray1 = array(
		                		array('usermaster','iLoginID','postedgiginquirymaster','iLoginID'),
		                		array('states','id','usermaster','sStateName'),
		                		array('postedgigsmaster','gigId','postedgiginquirymaster','gigId')
		                );
                		$getInquiriesResults = pdoQuery('postedgiginquirymaster',$columnsArray1,$paramArray1,$orderByParam1,$innerJoinArray1,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
                    	if($getInquiriesResults['gigDate'] >= $today){
                    		$getInquiriesResults['upcoming'] = true;
                    	}
                    	else{
                    		$getInquiriesResults['upcoming'] = false;
                    	}
                    	
                    /* Query db for selected artist */
		               	$columnsArray4 = array('postedgigneededtalentmaster.artist_selected','postedgigneededtalentmaster.tal_tracker_id', 'usermaster.sFirstName', 'usermaster.sLastName');
		               	$paramArray4['postedgigneededtalentmaster.gigId']['='] = $g_id;
		               	$paramArray4['postedgigneededtalentmaster.artistType']['='] = $getInquiriesResults['artistType'];
		               	$paramArray4['postedgigneededtalentmaster.tal_tracker_id']['='] = $tal_tracker;
		               	$innerJoinArray4 = array(
		               			array('usermaster','iLoginID','postedgigneededtalentmaster','artist_selected')
		               	);
                    	$getSelectedArtistResults = pdoQuery('postedgigneededtalentmaster',$columnsArray4,$paramArray4,$orderByParam4,$innerJoinArray4,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
                    	
						// var_dump($g_id);
						// var_dump($getInquiriesResults['artistType']);
						// var_dump($tal_tracker);
						// var_dump($getSelectedArtistResults);
                    /* Query the db for all selected artists */
                    	$columnsArray5 = array('postedgigneededtalentmaster.artist_selected','postedgigneededtalentmaster.tal_tracker_id', 'usermaster.sFirstName', 'usermaster.sLastName');
		               	$paramArray5['postedgigneededtalentmaster.gigId']['='] = $g_id;
		               	$innerJoinArray5 = array(
		               			array('usermaster','iLoginID','postedgigneededtalentmaster','artist_selected')
		               	);
                    	$getAllSelectedArtistResults = pdoQuery('postedgigneededtalentmaster',$columnsArray5,$paramArray5,$orderByParam5,$innerJoinArray5,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
                    	

                    /* Calculate age from birth date */
                        $from = new DateTime($getInquiriesResults['dDOB']);
                        $to   = new DateTime('today');
                        $artistAge = $from->diff($to)->y;
                        $getInquiriesResults['dDOB'] = $artistAge;

                    /* The substr_replace() method is used to insert '-' into the phone numbers to make them more readable */
                        $artistContact = $getInquiriesResults['sContactNumber'];
                        $artistContact1 = substr_replace($artistContact, '-', 3, 0);
                        $artistContact2 = substr_replace($artistContact1, '-', 7, 0);
                        $getInquiriesResults['sContactNumber'] = $artistContact2;

			        /* Re-format the datetime */
			        	$submissionTime = date_create($getInquiriesResults['dateTime']);
			        	$submissionTime = date_format($submissionTime, 'M d, Y @ h:ia');
			        	$getInquiriesResults['dateTime'] = $submissionTime;
                        
                        $inquWithdrawnTime = date_create($getInquiriesResults['withdraw_dateTime']);
                        $inquWithdrawnTime = date_format($inquWithdrawnTime, 'M d, Y @ h:ia');
                        $getInquiriesResults['withdraw_dateTime'] = $inquWithdrawnTime;

			        /* Truncate certain fields */
			        	$getInquiriesResults['sContactEmailID'] = truncateStr($getInquiriesResults['sContactEmailID'], 15);

                    /* Handle Groups vs artist  usertypes */
                    if($getInquiriesResults['sUserType'] == 'group'){
                    	$innerJoinArray3 = array(
                			array('giftmaster','iGiftID','groupmembersmaster','talentID')
                		);
                		$paramArray3['iLoginID']['='] = $u_id;
                		$getTalentsResults = pdoQuery('groupmembersmaster','all',$paramArray3,$orderByParam3,$innerJoinArray3)[0];

	                    if(count($getTalentsResults) > 0 && count($getInquiriesResults) > 0 ){

	                    }
                    }
                    elseif($getInquiriesResults['sUserType'] == 'artist'){
	                    $columnsArray2 = array('talent');
                		$paramArray2['iLoginID']['='] = $u_id;
                		$getTalentsResults = pdoQuery('talentmaster',$columnsArray2,$paramArray2,$orderByParam2,$innerJoinArray2,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
                		
                		foreach($getTalentsResults as $talResultIndex => $talResult){
                			
                			$sendTalResults[] = str_replace("_","/",$talResult['talent']); 
                		}

                		$response['inquiries'] = $getInquiriesResults;
                		$response['selected_artist'] = $getSelectedArtistResults;
                		$response['all_selected_artists'] = $getAllSelectedArtistResults;
                		$response['curr_artist_talents'] = $sendTalResults;
                	}

                	/* Return JSON Response */
                		echo json_encode($response);
                }
                catch(Exception $e){
                    echo $e; 
                }
	}
	elseif($_GET['get_all_inqu']){

		if($_GET['artists_playing']){
			$table = 'postedgigneededtalentmaster';

			/* Relational query the postgiginquirymaster and the usermaster tables */
			$columnsArray3 = array('postedgiginquirymaster.*','postedgigsmaster.gigDate', 'usermaster.sFirstName', 'usermaster.sLastName', 'usermaster.dDOB', 'usermaster.sCityName', 'states.statecode');//'postedgiginquirymaster.iLoginID', 'postedgiginquirymaster.artistType','postedgiginquirymaster.dateTime','postedgiginquirymaster.comments'
			$paramArray3['postedgiginquirymaster.gigId']['='] = trim($_GET['get_all_inqu']);
			// $paramArray3['postedgiginquirymaster.artistType']['='] = trim($_GET['tal_type']);
			$paramArray3['postedgiginquirymaster.tal_tracker_id']['='] = trim($_GET['tal_track']);
			$paramArray3['postedgiginquirymaster.gmRequested']['='] = trim($_GET['gmRequested']);
			// $paramArray3['postedgiginquirymaster.inquiry_withdrawn']['='] = 0;
			$innerJoinArray3 = array(
				array('usermaster','iLoginID','postedgiginquirymaster','iLoginID'),
				array('states','id','usermaster','sStateName'),
				array('postedgigsmaster','gigId','postedgiginquirymaster','gigId')
			);
			$getInquiriesResults = pdoQuery('postedgiginquirymaster',$columnsArray3,$paramArray3,$orderByParam3,$innerJoinArray3,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
			
			
		}else{
			if($_GET['gmRequested'] == "2"){
				// var_dump($_GET);
				/* Query the postedgigneededtalentmaster for artists that are playing */
					$columnsArray3 = array('postedgigneededtalentmaster.tal_pay', 'postedgigneededtalentmaster.dateTimeSelected','postedgigneededtalentmaster.gigid', 'postedgigneededtalentmaster.tal_tracker_id', 'postedgigneededtalentmaster.artist_selected','postedgigsmaster.gigDate','giftmaster.sGiftName', 'usermaster.sFirstName', 'usermaster.sLastName', 'usermaster.dDOB', 'usermaster.sCityName', 'usermaster.sProfileName', 'states.statecode');//'postedgiginquirymaster.iLoginID', 'postedgiginquirymaster.artistType','postedgiginquirymaster.dateTime','postedgiginquirymaster.comments'
					$paramArray3['postedgigneededtalentmaster.gigId']['='] = trim($_GET['get_all_inqu']);
					$innerJoinArray3 = array(
						array('usermaster','iLoginID','postedgigneededtalentmaster','artist_selected'),
						array('states','id','usermaster','sStateName'),
						array('postedgigsmaster','gigId','postedgigneededtalentmaster','gigId'),
						array(' giftmaster','iGiftID','postedgigneededtalentmaster','artistType')
					);
					$getPlayingArtists = pdoQuery('postedgigneededtalentmaster',$columnsArray3,$paramArray3,$orderByParam3,$innerJoinArray3,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
					
					foreach($getPlayingArtists as $getPlayingArtistsResult_index => $getPlayingArtistsResult){
						/* Get artist age */
							$getPlayingArtists[$getPlayingArtistsResult_index]['dDOB'] = getAge($getPlayingArtistsResult['dDOB']);

						/* reformat pay */
							$getPlayingArtists[$getPlayingArtistsResult_index]['tal_pay'] = CentsToDollars($getPlayingArtistsResult['tal_pay']);

						/* Re-format the datetime */
							$selectionTime = date_create($getPlayingArtistsResult['dateTimeSelected']);
							$selectionTime = date_format($selectionTime, 'M d, Y @ h:ia');
							$getPlayingArtists[$getPlayingArtistsResult_index]['dateTimeSelected'] = $selectionTime;

							$gigDateTime = date_create($getPlayingArtistsResult['gigDate']);
							$gigDateTime = date_format($gigDateTime, 'M d, Y');
							$getPlayingArtists[$getPlayingArtistsResult_index]['gigDate'] = $gigDateTime;


							$getPlayingArtists[$getPlayingArtistsResult_index]['sGiftName'] =  str_replace("_","/", $getPlayingArtistsResult['sGiftName']);

						/* compare todays date to gig date */
							// if( $getPlayingArtistsResult['gigDate'] >= $today){
							// 	$getPlayingArtistsResult[$getPlayingArtistsResult_index]['upcoming'] = true; 
							// }
							// else{
							// 	$getPlayingArtistsResult[$getPlayingArtistsResult_index]['upcoming'] = false; 
							// }
					}

					/* Return JSON Response */
						if( count($getPlayingArtists) > 0 ){
							$response['playingArtists'] = $getPlayingArtists; 
						}
						else{
							$response['playingArtists'] = false; 
						}
					//var_dump($getPlayingArtists);
			}else{
				/* Relational query the postgiginquirymaster and the usermaster tables */
					$columnsArray3 = array('postedgiginquirymaster.*','postedgigsmaster.gigDate', 'usermaster.sFirstName', 'usermaster.sLastName', 'usermaster.dDOB', 'usermaster.sCityName', 'states.statecode');//'postedgiginquirymaster.iLoginID', 'postedgiginquirymaster.artistType','postedgiginquirymaster.dateTime','postedgiginquirymaster.comments'
					$paramArray3['postedgiginquirymaster.gigId']['='] = trim($_GET['get_all_inqu']);
					$paramArray3['postedgiginquirymaster.tal_tracker_id']['='] = trim($_GET['tal_track']);
					$paramArray3['postedgiginquirymaster.gmRequested']['='] = trim($_GET['gmRequested']);
					$innerJoinArray3 = array(
						array('usermaster','iLoginID','postedgiginquirymaster','iLoginID'),
						array('states','id','usermaster','sStateName'),
						array('postedgigsmaster','gigId','postedgiginquirymaster','gigId')
					);
					$getInquiriesResults = pdoQuery('postedgiginquirymaster',$columnsArray3,$paramArray3,$orderByParam3,$innerJoinArray3,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
					
					foreach($getInquiriesResults as $getInquiriesResult_index => $getInquiriesResult){
						/* Get artist age */
							$getInquiriesResults[$getInquiriesResult_index]['dDOB'] = getAge($getInquiriesResult['dDOB']);

						/* compare todays date to gig date */
							if( $getInquiriesResult['gigDate'] >= $today){
								$getInquiriesResults[$getInquiriesResult_index]['upcoming'] = true; 
							}
							else{
								$getInquiriesResults[$getInquiriesResult_index]['upcoming'] = false; 
							}
					}

					/* compare todays date to gig date */


				/* Return JSON Response */
					if( count($getInquiriesResults) > 0 ){
						$response['all_inquiries'] = $getInquiriesResults; 
					}
					else{
						$response['all_inquiries'] = false; 
					}
			}
		}

		// /* Relational query the postgiginquirymaster and the usermaster tables */
		// 	$columnsArray3 = array('postedgiginquirymaster.*','postedgigsmaster.gigDate', 'usermaster.sFirstName', 'usermaster.sLastName', 'usermaster.dDOB', 'usermaster.sCityName', 'states.statecode');//'postedgiginquirymaster.iLoginID', 'postedgiginquirymaster.artistType','postedgiginquirymaster.dateTime','postedgiginquirymaster.comments'
        //     $paramArray3['postedgiginquirymaster.gigId']['='] = trim($_GET['get_all_inqu']);
        //     $paramArray3['postedgiginquirymaster.artistType']['='] = trim($_GET['tal_type']);
		// 	// $paramArray3['postedgiginquirymaster.inquiry_withdrawn']['='] = 0;
        //     $innerJoinArray3 = array(
        //     	array('usermaster','iLoginID','postedgiginquirymaster','iLoginID'),
        //     	array('states','id','usermaster','sStateName'),
        //     	array('postedgigsmaster','gigId','postedgiginquirymaster','gigId')
        //     );
        //     $getInquiriesResults = pdoQuery('postedgiginquirymaster',$columnsArray3,$paramArray3,$orderByParam3,$innerJoinArray3,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
            
            
        //     foreach($getInquiriesResults as $getInquiriesResult_index => $getInquiriesResult){
        //     	/* Get artist age */
        //     		$getInquiriesResults[$getInquiriesResult_index]['dDOB'] = getAge($getInquiriesResult['dDOB']);

        //     	/* compare todays date to gig date */
        //     		if( $getInquiriesResult['gigDate'] >= $today){
        //     			$getInquiriesResults[$getInquiriesResult_index]['upcoming'] = true; 
        //     		}
        //     		else{
        //     			$getInquiriesResults[$getInquiriesResult_index]['upcoming'] = false; 
        //     		}
        //     }

	    //     /* compare todays date to gig date */


        /* Return JSON Response */
        	// if( count($getInquiriesResults) > 0 ){
        	// 	$response['all_inquiries'] = $getInquiriesResults; 
        	// }
        	// else{
        	// 	$response['all_inquiries'] = false; 
        	// }

        	echo json_encode($response);
	}
	elseif($_POST){
	// var_dump($_POST);
	// exit;

		$table='postedgiginquirymaster';

		if($_POST['post_status'] != ''){
			/* Update postgigmaster table */
				$cond = 'gigId = "' . $_POST['g_id'] . '"';
				if($_POST['post_status'] == 'show'){
					$array['isPostedStatus'] = 1; 
				}
				else{
					$array['isPostedStatus'] = 0; 
				}
				$chng_post_status = updateTable($db, $array, $cond, 'postedgigsmaster');
				
				if($chng_post_status){
					$response['response'] = true; 
				}
				else{
					$response['response'] = false; 
					$response['err_mess'] = 'update_failure'; 
				}

			/* Return JSON Response */
				echo json_encode($response);

		}
		elseif($_POST['action'] == 'submitInquiry'  || $_POST['action'] == 're-submitInquiry'){

			if($_POST['artistType'] != '' ){
				/* Trim comment if present */
					if( $_POST['comments'] != ''){
						$_POST['comments'] = trim($_POST['comments']);
					}
					else{
						unset( $_POST['comments'] );
					}
					$_POST['artist_response'] = 'confirmed';

				/* Remove elements */
					$art_action = $_POST['action'];
					unset($_POST['action']);

				/* Create time stamp */
					$_POST['dateTime'] = $today;


                // var_dump($_POST);exit;
				if( $art_action == 'submitInquiry'){
					/* Insert the inquiry into the giginquirymaster */
						foreach ($_POST as $key => $val) {
							$field[] = $key;
							$value[] = $val;
						}
					/* Call the insert function */
						// $insertSuccess = $obj->insert($field,$value,$table);
						$insertSuccess = pdoInsert($db,$field,$value,$table);
				}
				elseif($art_action == 're-submitInquiry'){
					/* Remove elements */
						$iLoginid = $_POST['iLoginID'];
						$gigId = $_POST['gigId'];
						unset($_POST['gigManID']);
						unset($_POST['gigId']); 
						unset($_POST['iLoginID']); 

					/* Update array */
						$_POST['inquiry_withdrawn'] = 0;
						$_POST['withdraw_reason'] = NULL;
						$_POST['withdraw_dateTime'] = NULL; 

						$cond = 'gigid = "' .$gigId.'"' . ' AND iLoginid = ' . $iLoginid;
						$updateSucc = updateTable($db, $_POST, $cond, $table);
						// var_dump($updateSucc);
						// exit;
				}
					
					if( ($insertSuccess && $insertSuccess > 0) ||  $updateSucc){
						
						$response['inquiry_submitted'] = true;

						if($insertSuccess && $insertSuccess > 0){
							/* Remove this artist from the suggested gigs table */
								$query = 'DELETE FROM postedgigssuggestionmaster WHERE iLoginID = ? AND gigID = ?';

								try{
									$rem_row = $db->prepare($query);
									$rem_row->bindParam(1, $_POST['iLoginID']);
									$rem_row->bindParam(2, $_POST['gigId']);
									$rem_succ = $rem_row->execute(); 
									// var_dump($rem_succ);
								}
								catch(Exception $e){

									$response['catch_blk_err'] = $e; 
								}
						}

						/* Notify the gig manager that they have a inquiry */
							$action = 'gigInquiry';
							$notifier = $_POST['iLoginID'];
							$notified = $_POST['gigManID'];
							$link = $_POST['gigId'];
							$gigInqNotSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);

							if( $gigInqNotSucc !== 0){
								$response['inquiry_notif_sent'] = true;
							}
							else{
								$response['inquiry_notif_sent'] = false;
							}
					}
					else{
						$response['inquiry_submitted'] = false;
					}
			}
			else{
				$response['inquiry_submitted'] = false;
				$response['err'] = 'no_artist_type';
			}

			/* Return JSON Response */
				echo json_encode($response);
		}
		elseif($_POST['action'] == 'removeInquiry'){
			
			/* Update the artist's inquiry in the postedgiginquirymaster */
				
				/* create array of elements to be updated */	
					$post['inquiry_withdrawn'] = $_POST['inquiry_withdrawn'];
					$post['withdraw_reason'] = $_POST['withdraw_reason'];
					$post['withdraw_dateTime'] = $today;
					$post['artist_response'] = 'canceled';
			
					$cond =  'iLoginID = ' . $_POST['iLoginID'] . ' AND gigId = "' . $_POST['gigId'] . '"';
					$withdrawSuccess = updateTable($db, $post, $cond, $table);
					
				if($withdrawSuccess){
					/******************************************************************************************* 
					***** If the artist was already selected to play the gig, notify gig manager of withdrawal **
					***** and update the selectedArtist column in postedgigneededtalentmaster ******************************
					********************************************************************************************/
					 
                     /* query db for a selected artist */
                        $paramArray_query['gigid']['='] = trim($_POST['gigId']);
				        $paramArray_query['tal_tracker_id']['='] = trim($_POST['tal_tracker_id']);
				        $check_for_selected_artist = pdoQuery('postedgigneededtalentmaster','all',$paramArray_query,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
				
						if($check_for_selected_artist['artist_selected'] == $_POST['iLoginID']){
							/* Update the selectedArtist column in postedgigneededtalentmaster table */
								$array = array('dateTimeSelected' => NULL, "artist_selected" => 0);
								$cond = 'gigid = "' .$_POST['gigId'].'"' . ' AND tal_tracker_id = "' . $_POST['tal_tracker_id'].'"';
								$table = 'postedgigneededtalentmaster';
								$updSucc = updateTable($db, $array, $cond, $table);
								
							/* Send Notification to gig manager */
								$notifier = $_POST['iLoginID'];
								$notified = $_POST['gigManID'];
								$link = $_POST['gigId'];
								$action = 'artistWithdrawal';
								$notSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);
								
							if($updSucc){
								$response['selected_artist_removed'] = true; 
							}
							else{
								$response['selected_artist_removed'] = false;
							}

							if($notSucc){
								$response['inquiry_notif_sent'] = true; 
							}
							else{
								$response['inquiry_notif_sent'] = false;
							}
						}

					$response['inquiry_submitted'] = true; 
				}
				else{
					$response['inquiry_submitted'] = false;
				}
			
			/* Return JSON Response */
				echo json_encode($response);

		}
		elseif($_POST['action'] == 'confirmGigRequest' || $_POST['action'] == 'declineGigRequest'){
			if($_POST['action'] == 'confirmGigRequest'){
				$artist_response = 'confirmed';
			}else{
				$artist_response = 'declined';
			}

			/* query the postedgiginquirymaster table to see if artist has an entry for this gig */
				$cond = 'gigid = "' .$_POST['gigId'].'" AND tal_tracker_id = "' . $_POST['tal_tracker_id'].'" AND iLoginID = "'.$_POST['iLoginID'].'"';
				$array['artist_response'] = $artist_response;
				$array['artist_decl_reason'] = $_POST['reasonForGigDecline'];
				$array['artist_response_dateTime'] = $today;
				$table = 'postedgiginquirymaster'; 
				$updSucc = updateTable($db, $array, $cond, $table);

				if($updSucc){
					$response['updated'] = true;
				}else{
					$response['response'] = $updSucc;
					$response['updated'] = false;
				}
				
				echo json_encode($response);
		}
		elseif($_POST['action'] == 'selectArtist'){
			/* Define vars */
				$notifier = $_POST['gm_id'];
				$link = trim( $_POST['gigId'] );
				$iLoginID = $_POST['iLoginID'];
				$gigID = $_POST['gigId'];
				$man_action = $_POST['transaction'];
				$curr_selected_artist = $_POST['curr_selected_artist'];
				$tal_tracker = $_POST['tal_tracker_id'];

			/* query the postedgiginquirymaster table to see if artist has an entry for this gig */
				$paramArray_query['gigId']['='] = $gigID;
				$paramArray_query['iLoginid']['='] = $iLoginID;
				$check_for_artist = pdoQuery('postedgiginquirymaster','all',$paramArray_query,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
				// if( count($check_for_artist) > 0 ){
				// 	$newly_selected_artist_present = false; 
				// }
				// else{
				// 	$newly_selected_artist_present = true; 
				// }
				if( $check_for_artist['cancelby'] !== ''){
					$artist_previously_canceled = true;
				}else{
					$artist_previously_canceled = false;
				}

			/* Unset unnessary array elements */
				unset($_POST['transaction']);
				unset($_POST['action']);
				unset($_POST['iLoginID']);
				unset($_POST['gm_id']);
				unset($_POST['iLoginID']);
				unset($_POST['curr_selected_artist']);
				unset($_POST['tal_tracker_id']);

			/* Set Post vars based on action to be performed */
				if($man_action == 'selectArtist' || $man_action == 'replaceArtist'){

					/* postedgigneededtalentmaster vars */
						$post0 = array('artist_selected'=>$iLoginID, 'dateTimeSelected'=>$today);
					
					/* notificationmaster vars */
						$action1 = 'artistSelected';
				}
				
				if($man_action == 'deSelectArtist' || $man_action == 'replaceArtist'){

					if( $man_action == 'deSelectArtist' ){
						/* postedgigneededtalentmaster vars */
							$post0 = array('artist_selected'=>0, 'dateTimeSelected'=> NULL);
							$cond0 = 'artist_selected = ' . $iLoginID . ' AND ';
					}

					/* postedgiginquirymaster vars */	
						$post2['cancelby'] = 'gigmanager';		
						$post2['canceldate'] = $today;
						
					/* notificationmaster vars */
						$action2 = 'artistDeselection';
				}
		
			/* Update postedgigneededtalentmaster table */
				$cond0 .= 'gigId = "' . $gigID . '" AND artistType = ' . $_POST['artistType'] ;
				$upd_talNeeded_table = updateTable($db, $post0, $cond0, 'postedgigneededtalentmaster');
			/* END - Update postedgigneededtalentmaster table */

			/* Insert into postedgiginquirymaster table */
				if($upd_talNeeded_table == true){
					/* Check if artist is selected, de-selected, or replaced */
						if( $man_action == 'selectArtist' ){
							/******************************************* 
							** Insert OR update postedgiginquirymaster table depending on the newly selected artist already 
							** having a table entry for this gig 
							********************************************/
								if( $artist_previously_canceled ){
									/* Update the postedgiginquirymaster table */
										$cond1 = 'gigId = "' . $gigID . '" AND iLoginid = ' . $iLoginID;
										$post1['cancelby'] = NULL;		
										$post1['canceldate'] = NULL;
										$post1['cancelreason'] = NULL;
										$upd_postedgiginquirymaster_table = updateTable($db, $post1, $cond1, 'postedgiginquirymaster');
								}

							/* Send Notification to artist */
								if( $ins_postedgiginquirymaster_table > 0 || $upd_postedgiginquirymaster_table){
									$response['artist_selected_deSelected'] = true; 

									$notified = $iLoginID;
									$action = 'artistSelected';
									$notSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);

									if( $notSucc > 0){
										$response['notification_sent'] = true; 
										$response['err_message'] = false; 
									}
									else{
										$response['notification_sent'] = false; 
										$response['err_message'] = 'notif_failure'; 
									}
								}
								else{
									$response['artist_selected_deSelected'] = false; 
									$response['err_message'] = 'table_insert_failure'; 
								}
						}	
						elseif( $man_action == 'deSelectArtist' ){
							/* Update the eventartists table */
								$cond1 = 'gigId = "' . $gigID . '" AND iLoginid = ' . $iLoginID;
								$upd_postedgiginquirymaster_table = updateTable($db, $post2, $cond1, 'postedgiginquirymaster');

							/* Send Notification to artist */
								if($upd_postedgiginquirymaster_table){
									$response['artist_selected_deSelected'] = true; 

									$notified = $iLoginID;
									$action = 'artistDeselection';
									$notSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);

									if( $notSucc > 0){
										$response['notification_sent'] = true; 
										$response['err_message'] = false; 
									}
									else{
										$response['notification_sent'] = false; 
										$response['err_message'] = 'notif_failure'; 
									}
								}
								else{
									$response['artist_selected_deSelected'] = false; 
									$response['err_message'] = 'table_insert_failure'; 
								}
						}
						elseif( $man_action == 'replaceArtist' ){
							$response['replaceartist'] = true;
							/************************************************************************************
							 *** Update the postedgiginquirymaster table - then insert new artist into eventartists table
							 ************************************************************************************/

								/***************** Cancel the currenetly selected artist in the postedgiginquirymaster table *****************/
									$cond1 = 'gigId = "' . $gigID . '" AND iLoginid = ' . $curr_selected_artist;
									$upd_postedgiginquirymaster_table = updateTable($db, $post2, $cond1, 'postedgiginquirymaster');

								/*********** If table update is successful - Notify canceled artists - Insert new artist ***********/
									if( $upd_postedgiginquirymaster_table ){
										/* Send cancellation notification to artist */
											$action0 = 'artistDeselection';
											$notified0 = $curr_selected_artist;
											$notSucc0 = createNotification($db, $obj, $action0, $notifier, $notified0, $link);

										
										/******************************************* 
										** Insert OR update postedgiginquirymaster table depending on the newly  
										** selected artist already having a table entry for this gig.
										********************************************/
											if( $artist_previously_canceled ){
												/* Update newly selected artist to replace the current selected artist */
													$cond1 = 'gigId = "' . $gigID . '" AND iLoginid = ' . $iLoginID;
													$post1['cancelby'] = NULL;		
													$post1['canceldate'] = NULL;
													$post1['cancelreason'] = NULL;
													$upd_postedgiginquirymaster1_table = updateTable($db, $post1, $cond1, 'postedgiginquirymaster');
											}
											else{
												$upd_postedgiginquirymaster_table = true; 
											// 	/* Insert newly selected artist to replace the current selected artist */
											// 		foreach($post1 as $insert_index => $insert_value){
											// 			$field1[] = $insert_index;
											// 			$value1[] = $insert_value;
											// 		} 
											// 		$ins_eventArtist_table = pdoInsert($db,$field1,$value1,'postedgiginquirymaster');
											}


										/* If new artist added/updated successfully - notify new artist - or define error */
											if($upd_postedgiginquirymaster_table || $upd_postedgiginquirymaster1_table){
												/* response var */
													$response['artist_selected_deSelected'] = true;
													
												/* Send deselection notification to artist */
													$action1 = 'artistSelected';
													$notified1 = $iLoginID;
													$notSucc1 = createNotification($db, $obj, $action1, $notifier, $notified1, $link);	
											}
											else{
												/* response var */
													$response['artist_selected_deSelected'] = false;	
													$response['err_message'] = 'artist_replacement_failure'; 
													exit;
											}

										/* Define response vars for notifications being sent successfully */
											if($notSucc1 > 0 && $notSucc0 > 0){
												$response['notification_sent'] = true; 
												$response['err_message'] = false; 
											}
											else{
												$response['notification_sent'] = false; 
												$response['err_message'] = 'notif_failure'; 
											}
									}
									else{
										/* response var */
											$response['artist_selected_deSelected'] = false;	
											$response['err_message'] = 'artist_replacement_failure'; 
											exit; 
									}
								/******** END - If table update is successful - Notify canceled artists - Insert new artist ********/
							/****************************************************************************************
							 *** END - Update the postedgiginquirymaster table - then insert new artist into postedgiginquirymaster table
							 ****************************************************************************************/
						}					
				}
				else{
					$response['artist_selected_deSelected'] = false; 
					$response['err_message'] = 'table_update_failure'; 
				}
			/* END - Update postedgigsmaster table */

			/* Return JSON Response */
				echo json_encode($response);
		}elseif($_POST['canc_artist_req']){
			$cond = 'gigId ="'.$_POST['gigId'].'" AND iLoginID = '.$_POST['iLoginID'];
			$del_success = pdoDelete($db,$cond, 'postedgiginquirymaster');

			if($del_success){
				$response['artist_canc'] = true; 
				/* Notify artist of cancellation */
					$action1 = 'cancelRequest';
					$notified1 = $_POST['iLoginID'];
					$notifier = $_POST['gigManId'];
					$link = $_POST['gigId'];
					$notSucc1 = createNotification($db, $obj, $action1, $notifier, $notified1, $link);		
				/* Check notification sent */
					if($notSucc1 > 0){
						$response['notif_sent'] = true; 
					}else{
						$response['notif_sent'] = false; 
					}
			}else{
				$response['artist_canc'] = false; 
			}
			/* Return JSON Response */
				echo json_encode($response);
		}
	}


?>