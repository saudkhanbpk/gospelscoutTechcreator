<?php 

/* Require necessary docs */
	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

/* Get Date/Time */
	$today = date_create();
	$today = date_format($today, 'Y-m-d H:i:s');
	$todayDate = date_format($today, 'Y-m-d');

/* Back-end validation for the gig ad posted */
	if($_POST){
		$err = 0; 
		
        foreach($_POST as $columns => $vals){
            
	        if($columns != 'message' && $columns != 'venueName' && $columns != 'gigManPhone' && $columns !=  'talent' && $columns !=  'remove_talent' && $columns != 'selectNeededTal'){
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
			    		$cond = 'gigId = "' . $g_ID . '"'; 

	                /* Unset elements */
	                	unset($post['update']);
	                	unset($post['artist']);
	                	// unset($post['userType']);

	                /* Re-format Gig Times */
	                	$post['setupTime'] = changeTimeFormat($post['setupTime'],true);
	                	$post['startTime'] = changeTimeFormat($post['startTime'],true);
						$post['endTime'] = changeTimeFormat($post['endTime'],true);

					/**** Create tal insert function ****/
						function tal_insert($post_artist_needed,$obj,$table1){
							foreach($post_artist_needed as $artistTypeArray_index => $artistTypeArray){
		    					$field_art = array(); 
								$value_art = array(); 
		    					$field_art[] = 'tal_tracker_id';
		    					$value_art[] = $artistTypeArray_index;
		    					foreach($artistTypeArray as $posted_gig_art_ind => $posted_gig_art){
			    					$field_art[] = $posted_gig_art_ind;
			    					$value_art[] = $posted_gig_art;
			    				}
			    				$post_ad_artistType_succ = $obj->insert($field_art,$value_art,$table1);

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

			    	/* Update or Insert-into the postedgigmaster table */
			    		foreach($post as $posted_gig_index => $posted_gig){
			    			$field0[] = $posted_gig_index;
			    			$value0[] = $posted_gig;
			    		}

			    		if( $updateStatus ){
			    			$updateSucc = updateTable($db, $post, $cond, $table0);

			    			/* Add or remove talents from the postedgigneededtalentmaster table */
			    				if($updateSucc){
				    				/* Add Talents */
				    					if( count($post_artist_needed) > 0 ){
				    						$post_art_needm = tal_insert($post_artist_needed,$obj,$table1); 
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
				    				$post_art_needm = tal_insert($post_artist_needed,$obj,$table1); 
				    			}
			    		}
		    	/*****************************************************************
				 *** END - post new or updated gig to the postedgigsmaster
				 *****************************************************************/

				/*****************************************************************
				 *** If ad successfully posted or updated, search for qualified artists
				 *****************************************************************/
					if( ($post_ad_succ > 0 && $post_art_needm) || $updateSucc ){  
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

		                        $distReqCount = count($getDistDur);
		                        for($m=0;$m<$distReqCount;$m++){				
		                            if(!$getDistDur[$m]['distReqMet']){
		                                unset($getDistDur[$m]);
		                            }
		                        }
		                        return $getDistDur;
							}

							function suggestGig($newSuggArtist,$post,$obj){
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
		                                $insertSuccess = $obj->insert($field,$value,$suggGigTable);

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
								}

							/* IF GIG IS BEING UPDATED FIND ARTISTS THAT GIG WAS SUGGESTED FOR OR THAT HAVE INQUIRED ABOUT THE GIG ALREADY - QUERY THE SUGGESTEDGIGMASTER AND THE GIGINQUIRYMASTER */
								if( $updateStatus ){

									/* Query sugestedgigsmaster & giginquirymaster */
										$tables = array('postedgigssuggestionmaster','postedgiginquirymaster');

										foreach($tables as $table_assoc_artist){
											$columnsArray = array('iLoginID');
											$paramArray['gigID']['='] = $post['gigId'];
											$get_assoc_artists[] = pdoQuery($table_assoc_artist,$columnsArray,$paramArray);
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
			                                        	$suggAdded = suggestGig($newSuggArtist,$post,$obj);
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
		                                    	$suggAdded = suggestGig($newSuggArtist,$post,$obj);
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
/* END - Back-end validation for the gig ad posted */
















?>
