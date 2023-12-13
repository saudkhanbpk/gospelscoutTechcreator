<?php 
	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	if($_GET){
    // var_dump($_GET);exit;
		/* global vars */ 
      $emptyArray = array();

		if($_GET['content_type'] != ''){
			/* If userType is present query database for user's content */
				if( $_GET['u_type'] != '' && $_GET['content_type'] == 'Vid' ){
				
					/* Query the database for the videos of the current artist */
						$table0 = 'artistvideomaster';
						$columnsArray0 = array('artistvideomaster.*','giftmaster.sGiftName');
						$paramArray0['artistvideomaster.iLoginID']['='] = $_GET['u_id'];
						$paramArray0['artistvideomaster.removedStatus']['='] = 0;
						$innerJoinArray0 = array(
							array('giftmaster','iGiftID','artistvideomaster','videoTalentID')
						);
						$get_content = pdoQuery($table0,$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
					/* END - Query the database for the videos of the current artist */

					/* Catergorize videos according to talent */
						if( count($get_content) > 0){
							foreach($get_content as $eachVid0){
								$eachVid0['uploadDate'] = ageFuntion($eachVid0['uploadDate']);
								$tal = str_replace('_','/',$eachVid0['sGiftName']);
								$talSectArray[$tal][] = $eachVid0;
							}

							$response['response'] = $talSectArray;
						}
						else{
							$response['response'] = false; 
							$response['err_message'] = 'no_content'; 
						}
						
						if($currentUserID == trim($_GET['u_id']) ){
							$response['o_stat'] = true;
						}
						else{
							$response['o_stat'] = false;
						}
					/* END - Organize videos according to the talent they display */

					/* Return JSON Response */
						echo json_encode($response);	
				}
				elseif( $_GET['u_type'] != '' && $_GET['content_type'] == 'Photo' ){
					/* Query Database for Artist's photos */
					 	$table0 = 'gallerymaster';
					 	$paramArray0['iLoginID']['='] = $_GET['u_id'];
					 	$columnsArray0 = array('gallerymaster.*');
					 	$get_content = pdoQuery($table0,$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

					 	if( count($get_content) > 0 ){
					 		 /* Organize videos according to the talent they display */
								foreach($get_content as $eachPhoto){
									$albumArray[$eachPhoto['iAlbumID']] = $eachPhoto['albumName'];
								}
								
								foreach($albumArray as $IDindex => $eachAlbum){
									foreach($get_content as $eachPhoto1){
										if($eachPhoto1['iAlbumID'] == $IDindex){
											$albumSectArray[$IDindex][] = $eachPhoto1; 
										}
									}
								}

							/* Define response object */
								$response['response'] = $albumSectArray;
					 	}
					 	else{
							$response['response'] = false; 
							$response['err_message'] = 'no_content'; 
						}
						
					/* Return owner's status */
						if($currentUserID == trim($_GET['u_id']) ){
							$response['o_stat'] = true;
						}
						else{
							$response['o_stat'] = false;
						}
						
					/* Return JSON Response */
						echo json_encode($response);
				}
				elseif( $_GET['u_type'] != '' && $_GET['content_type'] == 'Bio' ){
					/* Query Database for Artist's Bio */
					 	$table0 = 'usermaster';
					 	$paramArray0['iLoginID']['='] = $_GET['u_id'];
					 	$columnsArray0 = array('usermaster.*');
					 	$get_content = pdoQuery($table0,$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

					/* Return JSON Response */
						if( count($get_content) > 0 ){
							$response['response'] = $get_content;
						}
					 	else{
							$response['response'] = false; 
							$response['err_message'] = 'no_content'; 
						}

					/* Return JSON Response */
						echo json_encode($response);
				}
				elseif( $_GET['u_type'] != '' && $_GET['content_type'] == 'Subscribe' ){

					if( $currentUserID > 0 ){
						$table0 = 'subscription';
						if($_GET['u_id'] == $currentUserID){
							/* Returns the number of subscribers */
						        // $subscrib = $obj->fetchNumOfRow("subscription","iRollID = ".$currentUserID." AND isActive = 1"); 
								$paramArray0['iRollID']['='] = $currentUserID;
								$paramArray0['isActive']['='] = 1;
								$columnsArray0 = array('subscription.*');
								$get_content = pdoQuery($table0,$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
								$subscrib = count($get_content);

								// exit;
						        /* Returns Your Subscribers */
						            // $subscribersArray = $obj->fetchRowAll("subscription","iRollID = ".$currentUserID." AND isActive = 1");
									$subscribersArray  = $get_content;
	
						        /* Returns Your Subscriptions */
									$paramArray1['iLoginID']['='] = $currentUserID;
						            //  $subscriptionArray = $obj->fetchRowAll("subscription","iLoginID = ".$currentUserID." AND isActive = 1");
									$subscriptionArray = pdoQuery($table0,$columnsArray0,$paramArray1,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

						        /* Returns the current user's subscibe settings */
						        	// $subscribeeSettings = $obj->fetchRow('subscribeesetting', 'iRollID='.$currentUserID);
						        	// $subscriberSettings = $obj->fetchRow('subscribersetting', 'iLoginID='.$currentUserID);	
										
									$paramArray2['iRollID']['='] = $currentUserID;
									$columnsArray1 = array('subscribeesetting.*');
									$subscribeeSettings = pdoQuery('subscribeesetting',$columnsArray1,$paramArray2,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
									
									$paramArray3['iLoginID']['='] = $currentUserID;
									$columnsArray2 = array('subscribersetting.*');
									$subscriberSettings = pdoQuery('subscribersetting',$columnsArray2,$paramArray3,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
									
						        /* Store in JSON obj */
						        	if( count($subscribeeSettings) > 0 && count($subscriberSettings) > 0){ //count($subscribersArray) > 0 && count($subscriptionArray) > 0 && 
							        	$response['response'] = true; 
							        	$response['o_stat'] = true; 
							        	$response['numb_subscribers'] = $subscrib;
							        	$response['subscribers'] = $subscribersArray;
							        	$response['subscriptions'] = $subscriptionArray;
							        	$response['subscribee_settings'] = $subscribeeSettings;
							        	$response['subscriber_settings'] = $subscriberSettings;
							        }
							        else{
							        	$response['response'] = false; 
							        	$response['err'] = 'err_retrieving_all_data'; 
							        }
					    }
					    else{
					    	$response['response'] = true; 
					    	$response['o_stat'] = 'prof_visitor'; 

					    	/* Determine if profile visitor is subscribed to current artist */
					    		$paramArray0['iLoginID']['='] = $currentUserID;
								$paramArray0['iRollID']['='] = $_GET['u_id'];
								$columnsArray0 = array('subscription.*');
								$subscribed = pdoQuery($table0,$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

					    		if( count($subscribed) > 0 ){
					    			$response['subscr_stat'] = true;
					    			$response['iLoginID'] = $currentUserID; 
					    			$response['iRollID'] = $_GET['u_id']; 
					    		}
					    		else{
					    			$response['subscr_stat'] = false; 
					    			$response['iLoginID'] = $currentUserID;
					    			$response['iRollID'] = $_GET['u_id'];  
					    		}
					    }
					}
					else{
						$response['response'] = true; 
					   	$response['o_stat'] = 'site_visitor'; 
					}
			        /* Return JSON Obj */
			        	echo json_encode($response);
				}
				else{
					/* Return JSON Response Error */
						$response['response'] = false; 
						$response['err_message'] = 'u_content_type_err'; 
						echo json_encode($response);
				}
		}
		else{
			/* Return JSON Response Error */
				$response['response'] = false; 
				$response['err_message'] = 'content_type_err'; 
				echo json_encode($response);
		}
	}
	elseif($_POST){
		// var_dump($_POST);
		// var_dump($_FILES);

		/* Filter out empty $_POST array values */
			foreach($_POST as $index => $value){
				if(!empty($value)){
					$postArray[$index] = trim($value); 
				}
			}

		/* Remove all non alpha-numeric characters */
			$postArray['videoName'] = removeAlphaNumChars($postArray['videoName']);
		/* END - Filter out empty $_POST array values */

		/* Create A Time Stamp - Add to the $postArray */
			$today = date_create();
			$today = date_format($today, "Y-m-d H:i:s"); 
			$postArray['uploadDate'] =  $today; 
		/* END - Create A Time Stamp */
			
		/* Process Uploaded Files */
			foreach($_FILES as $fileType => $indivFile){
				if($indivFile['name'] != ''){
					$_newFiles[$fileType] = $indivFile; 
				}
			}
		}


		// handlefileUpload($userType, $fileType, $iLoginID);

?>  			