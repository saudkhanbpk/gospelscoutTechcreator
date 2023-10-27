<?php 

/* Require necessary docs */
	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

/* Get Date/Time */
	$today = date_create();
	$today = date_format($today, 'Y-m-d H:i:s');
	$todayDate = date_format($today, 'Y-m-d');
/* Dummy Array */
	$emptyArray = array();

/* Back-end validation for the gig ad posted */
	if($_POST){
		$err = 0; 
		
		/************************************************ Charge User for Posted Gig Ad ************************************************/
			// if(!$_POST['update']){
    				
			// 	/* Query Db for user's Customer ID - Query stripe for customer obj */
			// 		$columnsArray_tok = array('str_customerID');
			// 		$paramArray_tok['iLoginID']['='] = $currentUserID;
			// 		$get_cust_id = pdoQuery('usermaster',$columnsArray_tok,$paramArray_tok,$orderByParam,$innerJoinArray,$leftJoinArray,$paramOrArray,$emptyArray,$emptyArray)[0];
			// 		if( count($get_cust_id) > 0 ){
			// 			$get_cust_obj = retrieveCustomer($get_cust_id['str_customerID']);

			// 			if($get_cust_obj['default_source']){
			// 				/* Charge payment src associated with customer obj */
			// 					$user = array(
			// 						"charged_amount" => 100,
			// 						"customer" => $get_cust_id['str_customerID'],
			// 						"tok_visa" => $get_cust_obj['default_source'],
			// 						"email" => $currentUserEmail,
			// 						"description" => 'GospelScout - Posted Gig Ad'
			// 					);

			// 					$user_charge = ChargeCustmerPaymentSrc($user);

			// 					if($user_charge['paid'] === true || $user_charge['status'] == 'succeeded'){
			// 						/* Payment Success - Return payment details */
			// 							$response['str_charge']['id'] = $user_charge['id'];
			// 							$response['str_charge']['amount'] = $user_charge['amount'];
			// 							$response['str_charge']['created'] = $user_charge['created'];
			// 							$response['str_charge']['customer'] = $user_charge['customer'];
			// 							$response['str_charge']['paid'] = $user_charge['paid'];
			// 							$response['str_charge']['receipt_email'] = $user_charge['receipt_email'];
			// 							$response['str_charge']['receipt_url'] = $user_charge['receipt_url'];
			// 							$response['str_charge']['source'] = $user_charge['source'];
			// 							$response['str_charge']['status'] = $user_charge['status'];
			// 					}else{
			// 						/* Payment Failed */
			// 							$response['str_charge']['status'] = $user_charge['status'];
			// 							$response['str_charge']['exception'] = $user_charge['exception'];
			// 							$response['err_present'] = true;
			//     						$response['err_mess'] = $user_charge['status'];
			//     						echo json_encode($response);
	        //             				exit;
			// 					}
			// 			}else{$response['str_charge']['status'] = 'no_default_payment_src';$response['err_present'] = true;$response['err_mess'] = $user_charge['status'];echo json_encode($response);exit;}
						
			// 		}else{$response['str_charge']['status'] = 'no_str_cust_id';$response['err_present'] = true;$response['err_mess'] = $user_charge['status'];echo json_encode($response);exit;}
			// }

		/********************************************* END - Charge User for Posted Gig Ad *********************************************/

	        foreach($_POST as $columns => $vals){
	            
		        if($columns != 'message' && $columns != 'venueName' && $columns != 'gigManPhone' && $columns != 'talent' && $columns !=  'remove_talent' && $columns != 'selectNeededTal'){
		        	$vals = trim($vals);
		            if($vals != ''){
		                if($columns == "venueAddress"){ 
		                    /* Remove spaces from name for alpha numeric test */
		                        $alphaTest = str_replace(" ","",$vals);
	
		                    if(!ctype_alnum($alphaTest)){
		                        $errorMess = 'invalid_char_type'; 
		                        $err += 1;
		                        break; 
		                    }
		                }
		                elseif($columns == "dDOB1"){
		                    $vals = intval($vals);
		                    if($vals > 0){
		                    }
		                    else{
		                        $errorMess = 'invalid_age'; 
		                        $err += 1;
		                        break; 
		                    }
		                }
		                elseif($columns == "gigPay"){
	
		                    /* Validate user-entered values */
		                        if($vals != ''){
	
		                        	/* Convert payment value to cents */
		                    			$newVal = dollarsToCents( trim($vals) );
		                    			
	
		                            if($newVal >= 0 ){ 
		                                if( $newVal > 999999){
		                                    $errorMess = 'invalid_pay_amount'; 
		                                    $err += 1;
		                                    break; 
		                                }
		                                elseif($newVal != 0){
		                                   	$vals = $newVal;
		                                }
		                            }
		                            else{
		                                $errorMess = 'invalid_pay_amount'; 
		                                $err += 1;
		                                break; 
		                            }
		                        }
		                }
		                elseif($columns == "venueZip"){
		                    if(strlen(intval($vals)) !== 5) {
		                        $errorMess = 'invalid_zip';
		                        $err += 1;
		                        break;
		                    } 
		                }
	
		                $post[$columns] = $vals;
		            }
		            else{
		                $errorMess = 'all_fields_not_complete_1_'.$columns;
		                $err += 1;
		                break;
		            }
		        }
		        elseif( $columns == 'gigManPhone'){
		        	if( $vals != ''){
		        		$post[$columns] = removeNonNumChars($vals);
		        	}
		        }
		        elseif( $columns == 'talent'){ 
		        	if( count($vals) > 0 ){
		        		/* Create array for newly added talent requirements to be added to the database */
			            	foreach($vals['artist'] as $artist_val_index => $artist_val){
			            		if($artist_val != ''){
			            			$post_artist_needed[$artist_val_index]['artistType'] = $artist_val;
			            			$post_artist_needed[$artist_val_index]['gigId'] = $_POST['gigId'];
			            			$post_artist_needed[$artist_val_index]['tal_pay'] = dollarsToCents( trim($vals['pay_new'][$artist_val_index]) );
			            			$post_artist_needed[$artist_val_index]['userType'] = $_POST['userType'];
			            		}
			            	}
	
			            /* Create array for updates to pay associated with current talents */
			            	foreach($vals['pay_current'] as $pay_curr_index => $pay_curr){
			            		/* convert from dollars to cents */
			            			$pay_curr_cents = dollarsToCents($pay_curr);
			            			$update_artist_pay[$pay_curr_index] = $pay_curr_cents;
			            	}
			            	// var_dump($update_artist_pay);
		            
						/* Create array for artists that are directly requested */
							foreach($vals['artist_requested'] as $artist_requested_ind => $artist_requested){
								$post_artist_requested[$artist_requested_ind]['gigId'] =  $_POST['gigId'];
								$post_artist_requested[$artist_requested_ind]['gigManID'] = $_POST['gigManLoginId'];
								$post_artist_requested[$artist_requested_ind]['gmRequested'] = 1;
								$post_artist_requested[$artist_requested_ind]['artistType'] = $artist_requested['artistType'];
								$post_artist_requested[$artist_requested_ind]['iLoginID'] = $artist_requested['iLoginID'];
								$post_artist_requested[$artist_requested_ind]['dateTime'] = $today;
							}
					}
		            else{
	        			$errorMess = 'all_fields_not_complete_2';
	                    $err += 1;
	                    break;
	        		}
		        }
		        elseif( $columns == 'remove_talent'){
		        	if( count($vals) > 0 ){
		            	foreach($vals as $artist_val_index => $artist_val){
		            		
		            		if($artist_val != ''){
		            			$post_artist_remove[$artist_val_index]['artistType'] = $artist_val;
		            			$post_artist_remove[$artist_val_index]['gigId'] = $_POST['gigId'];
		            			$post_artist_remove[$artist_val_index]['userType'] = $_POST['userType'];
		            		}
		            	}
		            }
		            else{
	        			$errorMess = 'all_fields_not_complete_3';
	                    $err += 1;
	                    break;
	        		}
		        }
		        else{
		        	if($vals !== ''){
		        	 	$post[$columns] = $vals;
		        	 }
		        }
	        }

        /* Check for errors - submit to DB*/
	        if($err > 0){
		    	/* Return JSON Response */
		    		$response['err_present'] = true;
		    		$response['err_mess'] = $errorMess;
		    		echo json_encode( $response );
		    }
		    else{ 
				
		    	/*****************************************************************
				 *** Post new or updated gig to the postedgigsmaster
				 *****************************************************************/
			    	/* Define vars */
			    		$response['err_present'] = false;
			    		$response['err_mess'] = false;
			    		$post['postedDate'] = $today; 
			    		$g_ID = trim($post['gigId']);
	            		$updateStatus = $post['update'];
	            		$table0 = 'postedgigsmaster';
			    		$table1 = 'postedgigneededtalentmaster';
			    		$table2 = 'eventArtists';
						$table3 = 'postedgiginquirymaster';
			    		$cond = 'gigId = "' . $g_ID . '"'; 

	                /* Unset elements */
	                	unset($post['update']);
	                	unset($post['artist']);


	                /* Re-format Gig Times */
	                	$post['setupTime'] = changeTimeFormat($post['setupTime'],true);
	                	$post['startTime'] = changeTimeFormat($post['startTime'],true);
						$post['endTime'] = changeTimeFormat($post['endTime'],true);

					/**** Create tal insert function ****/
						function tal_insert($db,$post_artist_needed,$obj,$table1){

							foreach($post_artist_needed as $artistTypeArray_index => $artistTypeArray){
		    					$field_art = array(); 
								$value_art = array(); 
		    					$field_art[] = 'tal_tracker_id';
		    					$value_art[] = $artistTypeArray_index;
		    					foreach($artistTypeArray as $posted_gig_art_ind => $posted_gig_art){
			    					$field_art[] = $posted_gig_art_ind;
			    					$value_art[] = $posted_gig_art;
			    				}
								$post_ad_artistType_succ = pdoInsert($db,$field_art,$value_art,$table1);
			    				// var_dump($post_ad_artistType_succ);

			    				if($post_ad_artistType_succ > 0){
			    					$art_type_post[] = $post_ad_artistType_succ;
			    				}
		    				}

		    				if( count($post_artist_needed) == count($art_type_post) ){
		    					$post_art_needm = true; 
		    				}
		    				else {
		    					$post_art_needm = false; 
		    				}
							return $post_art_needm;
						}
					/* END - Create tal insert function */

					/**** Create artist requested insert function ****/
						function artists_requested_insert($post_artist_requested,$obj,$table3, $db){
							/* Check if artists is already in the inquirymaster table */
							foreach($post_artist_requested as $post_artist_requested_ind => $artist_requested){
								$field_art = array(); 
								$value_art = array(); 
								$field_art[] = 'tal_tracker_id';
								$value_art[] = $post_artist_requested_ind;
								foreach($artist_requested as $artist_req_ind => $artist_requested_val){
									$field_art[] = $artist_req_ind;
									$value_art[] = $artist_requested_val;
								}

								try{	
									$post_artist_requested_succ = pdoInsert($db,$field_art,$value_art,$table3);
								}catch(Exception $e){
									echo $e;
								}
							}

							if($post_artist_requested_succ > 0){
								$post_art_req = true; 
							}else {
								$post_art_req = false; 
							}
							return $post_art_req;
						}
					/* END - Create artist requested insert function */


			    	/* Update or Insert-into the postedgigmaster table */
			    		foreach($post as $posted_gig_index => $posted_gig){
			    			$field0[] = $posted_gig_index;
			    			$value0[] = $posted_gig;
			    		}
			    		
			    		if( $updateStatus ){
			    			unset($post['postedDate']);
			    			$updateSucc = updateTable($db, $post, $cond, $table0);
							// var_dump($updateSucc,$post);exit;

			    			/* Add or remove talents from the postedgigneededtalentmaster table */
			    				if($updateSucc){
				    				/* Add Talents */
				    					if( count($post_artist_needed) > 0 ){
				    						$post_art_needm = tal_insert($db,$post_artist_needed,$obj,$table1); 
				    					}

				    				/* Update pay associated with talent */
				    					if( count($update_artist_pay) > 0 ){
				    						foreach($update_artist_pay as $update_artist_pay_ind => $update_artist_pay_val){
				    							$cond1 = 'tal_tracker_id = "' . $update_artist_pay_ind . '"';
				    							$update_artist_pay_array = array();
				    							$update_artist_pay_array['tal_pay'] = $update_artist_pay_val;
				    							$update_artist_pay_result = updateTable($db, $update_artist_pay_array, $cond1, $table1);
				    						}
				    					}

				    				/* Add Requested Artists */
										if( count($post_artist_requested) > 0 ){
											$post_art_req = artists_requested_insert($post_artist_requested,$obj,$table3, $db);
										}

				    				/* Remove Talents */
				    					if( count($post_artist_remove) > 0 ){

				    						$del_query = 'DELETE FROM '. $table1 .' WHERE gigid = "' . $g_ID . '" AND (';
				    						$del_count = 1;
				    						foreach($post_artist_remove as $post_artist_remove_index => $post_artist_remove_val){
				    							if( $del_count == count($post_artist_remove) ){
				    								$del_query .= 'tal_tracker_id = "' . $post_artist_remove_index . '")';
												}
												else{
													$del_query .= 'tal_tracker_id = "' . $post_artist_remove_index . '" OR ';
												}
												$del_count++;
				    						}

				    						try{
				    							$del_tals_needed = $db->prepare($del_query);
				    							$del_executed = $del_tals_needed->execute();

				    							if($del_executed){
				    								$post_art_needm = true; 
				    							}
				    							else{
				    								$post_art_needm = false; 
				    							}
				    						}
				    						catch(Exception $e){
				    							echo $e; 
				    						}
				    					}
				    			}
			    		}
			    		else{
			    			/* Add gig post ad to the postedgigsmaster table */
			    				$post_ad_succ = pdoInsert($db,$field0,$value0,$table0);
			    				
			    			/* Add gig post ad to the postedgigneededtalentmaster table */
			    				if($post_ad_succ > 0){
				    				$post_art_needm = tal_insert($db,$post_artist_needed,$obj,$table1); 
									/* Add Requested Artists */
										if( count($post_artist_requested) > 0 ){
											$post_art_req = artists_requested_insert($post_artist_requested,$obj,$table3,$db);
										}
				    			}
			    		}
		    	/*****************************************************************
				 *** END - post new or updated gig to the postedgigsmaster
				 *****************************************************************/

				/*****************************************************************
				 *** If ad successfully posted or updated, search for qualified artists
				 *****************************************************************/
					if( ($post_ad_succ > 0 && $post_art_needm) || $updateSucc ){   //
						/* Set var */
							$response['ad_posted'] = true;
							$response['artist_type_reqs_posted'] = true;
							$response['ad_posted_gigID'] = $post['gigId'];
							$notifier = $post['gigManLoginId'];
							
						/* Create functions */
							function checkDistance($matchingArtists,$post){
								$originArray = $matchingArtists;
		                        $destinationArray = array($post['venueAddress'] . ', ' . $post['venueCity'] . ', ' . $post['venueState'] . ', ' . $post['venueZip']); //venueStateShort
		                        $getDistDur = findDist($originArray, $destinationArray);
		                        // var_dump($getDistDur);

		                        $distReqCount = count($getDistDur);
		                        for($m=0;$m<$distReqCount;$m++){				
		                            if(!$getDistDur[$m]['distReqMet']){
		                                unset($getDistDur[$m]);
		                            }
		                        }
		                        return $getDistDur;
							}

							function suggestGig($newSuggArtist,$post,$db){
								$action = 'suggestGig';   
		                        $link = $post['gigId'];

		                        foreach($newSuggArtist as $artSuggNew){

		                        	/* Get Date/Time */
										$today = date_create();
										$today = date_format($today, 'Y-m-d H:i:s');

		                            /* Unset Un-needed elements */
		                                unset($artSuggNew['iZipcode']);
		                                unset($artSuggNew['maxTravDistance']);
		                                unset($artSuggNew['distReqMet']);
		                                unset($artSuggNew['dist']);
		                                unset($artSuggNew['dur']);
		                                
		                            /* Add the gig id to each artist's array */
		                                $artSuggNew['gigID'] = $post['gigId'];
		                                $artSuggNew['gigDate'] = $post['gigDate']; 
		                                $artSuggNew['dateCreated'] = $today;
		                            
		                            /* Reset the field and value array after each loop */
		                                $field = array();
		                                $value = array(); 
		                                
		                            /* Insert values into the field and value array for table insertion */
		                                foreach($artSuggNew as $key1 => $val1) {
		                                    $field[] = $key1;
		                                    $value[] = $val1;
		                                }

		                               
		                            /* Insert into the suggestgigs table */
		                                $suggGigTable = 'postedgigssuggestionmaster';
		                                // $insertSuccess = $obj->insert($field,$value,$suggGigTable);
										$insertSuccess = pdoInsert($db,$field,$value,$suggGigTable);

		                            /* If suggestedgigs table is updated successfully, Insert into the notification table */
		                                if($insertSuccess > 0){
		                                    $notified = $artSuggNew['iLoginID'];
		                                    $notifier = $post['gigManLoginId'];
		                                    $suggGigNotSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);

		                                    if( $suggGigNotSucc !== 0){
		                                    	$notCount[] = $notified; 
		                                    }
		                                  
		                                    $suggAddedCount[] = $notified;
		                                }
		                        }

		                        /* Return response */
		                        	if( count($newSuggArtist) == count($suggAddedCount) ){
		                        		$response['all_sugg_added'] = true; 
		                        	}
		                        	else{
		                        		$response['all_sugg_added'] = false; 	
		                        	}

		                        	if( count($newSuggArtist) == count($notCount) ){
		                        		$response['all_sugg_notif_sent'] = true; 
		                        	}
		                        	else{
		                        		$response['all_sugg_notif_sent'] = false; 	
		                        	}

		                            return $response;
							}

						
							/* CALL THE FIND ALL MATCHING ARTIST FUNCTION */
								if( count($post_artist_needed) > 0 ){
									$post['art_needed'] = $post_artist_needed;
									$matchingArtists = findArtistMatch($db, $obj, $post);
                  					$response['findMatchingArtists'] = $matchingArtists;
								}

							/* Send Notifications to newly requested artists */
								if( $post_art_req ){
									$action = 'gigRequest';  
									$link = $post['gigId']; 
									$actionUrl = 'https://www.gospelscout.com/publicgigads/ad_details.php?g_id='.$link;
									$requestorUrl = 'https://www.gospelscout.com/views/artistprofile.php?artist='.$post['gigManLoginId'];

									if( count($post_artist_requested) > 0 ){
										foreach($post_artist_requested as $req_artist_ind => $req_artist){
											$notified = $req_artist['iLoginID'];
											$talent = $req_artist['artistType'];
											$artist_req_name = $_POST['talent']['artist_requested'][$req_artist_ind]['fname'];
											$artist_req_email = $_POST['talent']['artist_requested'][$req_artist_ind]['email'];
											$talentRequested = str_replace("_", "/", $_POST['talent']['artist_requested'][$req_artist_ind]['talent']);
											if( $update_artist_pay[$req_artist_ind] > 0){
												$artist_pay = CentsToDollars($update_artist_pay[$req_artist_ind]);
											}else{
												$artist_pay = CentsToDollars($post_artist_needed[$req_artist_ind]['tal_pay']);
											}

											/* Send artist request notification */
												$artistReqNotSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);	

											// Call artist request email function
												$bookingMail->request($post['gigManEmail'],  $post['gigManName'], $requestorUrl, $artist_req_email, $artist_req_name, $talentRequested, $actionUrl, $_POST['gigName'], $link, $artist_pay);		
										}
									}
								}

							/* IF GIG IS BEING UPDATED FIND ARTISTS THAT GIG WAS SUGGESTED FOR OR THAT HAVE INQUIRED ABOUT THE GIG ALREADY - QUERY THE SUGGESTEDGIGMASTER AND THE GIGINQUIRYMASTER */
								if( $updateStatus ){
									/* Query sugestedgigsmaster & giginquirymaster */
										$tables = array('postedgigssuggestionmaster','postedgiginquirymaster');
										foreach($tables as $table_assoc_artist){
											$columnsArray = array('iLoginID');
											$paramArray['gigID']['='] = $post['gigId'];
											$get_assoc_artists[] = pdoQuery($table_assoc_artist,$columnsArray,$paramArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
										}

									/* Merge tables */
										$get_assoc_artists = array_merge( $get_assoc_artists[0], $get_assoc_artists[1] ); 

									/* If artists associated with this gig exist - send update notifications */
										if( count($get_assoc_artists) > 0 ){
											$action = 'updatedGig';  
											$link = $g_ID;
											foreach ($get_assoc_artists as $key => $value) {
												$notified = $value['iLoginID'];  
												$updateNotSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);

												if($updateNotSucc > 0){
													$updateCount[] = $value['iLoginID'];
												}
											}

											if( count($get_assoc_artists) == count($updateCount) ){
												$response['all_gig_updates_sent'] = true;
											}
											else{
												$response['all_gig_updates_sent'] = false;
											}
										}


									/* Send suggested gig notifications to matching artists not already associated w/ the current gig */
										if( $matchingArtists !== 0 && count($matchingArtists) > 0){

											/* If there already are associated artist -  remove them from suggested gig notification list */
												if( count($get_assoc_artists) > 0 ){
													
													foreach($matchingArtists as $artist_match_index => $artist_match){

														foreach($get_assoc_artists as $assoc_artist){

															if($artist_match['iLoginID'] == $assoc_artist['iLoginID']){

																unset( $matchingArtists[$artist_match_index] );
															}
														}
													}
												}

											/* Send Suggested gig notification */
												if( count($matchingArtists) > 0 ){

													/* Check distance requirement */
                              							$newSuggArtist = checkDistance($matchingArtists,$post);

													/* If suggested artists still exist after distance check - add to suggest gigs table and send artist notification */
														$suggAdded = suggestGig($newSuggArtist,$post,$db);
														$response['sugg_added'] = $suggAdded;
												}
										}
								}
								else{

									/* Check if matching artists exists */
										if($matchingArtists !== 0 && count($matchingArtists) > 0){

											/* Check if artists meet distance requirements */
												$newSuggArtist = checkDistance($matchingArtists,$post);

			                                /* If suggested artists still exist after distance check - add to suggest gigs table and send artist notification */
		                                    	$suggAdded = suggestGig($newSuggArtist,$post,$db);
		                                    	$response['sugg_added'] = $suggAdded;
										}
								}
					}
					else{
						$response['ad_posted'] = false;
					}

					/* Return JSON Response */
						echo json_encode($response);

				/*****************************************************************
				 *** END - If ad successfully posted or updated, search for qualified artists
				 *****************************************************************/
		}
		

    }// END - post conditional
   elseif($_GET){

		if($_GET['check_artist_status']){

			if( $currentUserID == trim($_GET['check_artist_status']) ){
				$response['inq_error'] = true;
				$response['gm_error'] = true;
			}else{
				$emptyArray = array();
				$columnsArray = array('postedgiginquirymaster.*', 'usermaster.sFirstName', 'giftmaster.sGiftName');
				$paramArray['gigId']['='] = trim($_GET['gigid']);
				$paramArray['postedgiginquirymaster.iLoginID']['='] = trim($_GET['check_artist_status']);
				$innerJoinArray = array(
					array('usermaster','iLoginID','postedgiginquirymaster','iLoginID'),
					array('giftmaster','iGiftID','postedgiginquirymaster','artistType')
				);
				$get_art_status = pdoQuery(' postedgiginquirymaster',$columnsArray,$paramArray,$emptyArray,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
				
				
				if( count($get_art_status) > 0 ){
					$get_art_status[0]['sGiftName'] = str_replace("_", "/",$get_art_status[0]['sGiftName']);
					$response['inq_error'] = true;
					$response['gm_error'] = false;
					$response['inq_info'] = $get_art_status[0];
				}else{
					$response['inq_error'] = false;
					$response['gm_error'] = false;
				}
			}			

			// var_dump($response);
			echo json_encode($response);
		}else{
			$emptyArray = array();
			$columnsArray = array('postedgiginquirymaster.*', 'usermaster.sFirstName');
			$paramArray['gigId']['='] = trim($_GET['gigid']);
			$paramArray['gmRequested']['='] = 1;
			$innerJoinArray = array(
				array('usermaster','iLoginID','postedgiginquirymaster','iLoginID')
			);
			$get_req_art = pdoQuery(' postedgiginquirymaster',$columnsArray,$paramArray,$emptyArray,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

			echo json_encode($get_req_art);
		}
		
	}
/* END - Back-end validation for the gig ad posted */
















?>