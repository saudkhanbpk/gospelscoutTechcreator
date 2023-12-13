<?php 
/************************************************************** Update table Function - PDO Method **************************************************************/
	
	function updateTable($db, $array, $cond, $table){
        /* PDO Update Statement */
	        $columuns = '';
	        $count = count($array);
	        $j = 1; 
	        foreach($array as $index1 => $value1){

	        	if($value1 === NULL){
	        		$curr_val = 'NULL'; 
	        	}
	        	else{
	        		$curr_val = '"' . $value1 . '"';
	        	}
	        	
	            if($j == $count){
	                $columuns .= $table . '.' . $index1 . ' = '. $curr_val;
	            }
	            else{
	                $columuns .= $table . '.' . $index1 . ' = ' . $curr_val . ', '; 
	            }
	            $j++;
	        }
	        $query = 'UPDATE ' . $table . ' SET ' . $columuns . ' WHERE ' . $cond;

	         //var_dump($query);
	         //exit;

	        try{
	            $updateTable = $db->prepare($query);
	            $updateSucc = $updateTable->execute(); 

	            if($updateSucc){
	            	return true;
	            }
	            else{
	            	return false;
	            }
	        }
	        catch(Exception $e){
	            return $e; 
	        }
	}
/*********************************************************** END - Update table Function - PDO Method ***********************************************************/


/************************************************************** Delete from table Function - PDO Method **************************************************************/
	function pdoDelete($db,$cond, $table){
		/* PDO Delete Statement */
			$query  = 'DELETE FROM ' . $table . ' WHERE ' . $cond;

			try{
				$pdoDelete = $db->prepare($query);
		        $deleteSucc = $pdoDelete->execute(); 
		        return $deleteSucc;
			}
			catch(Exception $e){
				return $e; 
			}

	}
/************************************************************** END - Delete from table Function - PDO Method **************************************************************/

/************************************************************** Insert into table Function - PDO Method **************************************************************/
	function pdoInsert($db,$field,$value,$table){
		/* PDO Insert Statement */
			$query =  'INSERT INTO ' . $table . ' (`'. implode("`,`",$field) . '`) VALUES ("' . implode('","',$value) . '")';
			
			try{
				$pdoInsert = $db->prepare($query);
		        	$pdoInsert->execute(); 
		        	$insertSucc = $db->lastInsertId(); 

		        	return $insertSucc;
			}
			catch(Exception $e){
				return $e; 
			}
	}

	function pdoMultiRowInsert($db,$field,$value,$table){
		/* $field - 1 dimensional array
		   $value - 2 dimensional array
		*/

		/* PDO Insert Statement */
			$query =  'INSERT INTO ' . $table . ' (`'. implode("`,`",$field) . '`) VALUES ';
			$val_counter = 1; 
			$numb_of_artist = count($value);
			foreach($value as $value_val){
				if( $val_counter == $numb_of_artist){
					$query .= '("' . implode('","',$value_val) . '")';
				}
				else{
					$query .= '("' . implode('","',$value_val) . '"),';
				}
				$val_counter++; 
			}
			// var_dump($query);
			
			try{
				$pdoMultiInsert = $db->prepare($query);
		        $insertSucc = $pdoMultiInsert->execute(); 
		        $insertRow = $db->lastInsertId(); 

		        return $insertSucc;
			}
			catch(Exception $e){
				return $e; 
			}
	}
/************************************************************** END - Insert into table Function - PDO Method **************************************************************/


/************************************************************** Notification function **************************************************************/
	function createNotification($db, $obj, $action, $notifier, $notified, $link){
		/* Create date and time for form submission */
			$today = date_create();
			$today = date_format($today, 'Y-m-d H:i:s');
		/* END - Create date and time for form submission */

		/* Define table var and the array to be inserted in the notificationmaster table */
			$table = 'notificationmaster';
			$insertArray = array(
							"notifierID" => $notifier,
							"notifiedID" => $notified,
							"action" => $action,
							"dateTime" => $today
						);
		/* END - Define the array to be inserted in the notificationmaster table */

		/********************* Define a switch statement to determine the link path *********************/
			switch ($action) {
              case 'gigRequest':
                $insertArray['link'] = URL . 'views/gigform.php?gigID=' . $link;
                break;

              case 'gigInquiry':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'suggestGig':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'updatedGig':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'artistSelected':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'canceledGig':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'artistWithdrawal':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'artistDeselection':
                $insertArray['link'] = URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $link;
                break;

              case 'vidNotification':
                $insertArray['link'] = URL . 'views/';
                break;

              case 'eventNotification':
               	$insertArray['link'] = URL . 'views/';
                break;

              case 'gigNotification':
                $insertArray['link'] = URL . 'views/';
                break;
              
              default:
                echo 'You have no new notifications';
                break;
            }
		/****************** END - Define a switch statement to determine the link path ******************/

		/* if action is "vidNotification || eventNotification || gigNotification" query subscribee table for user who triggered a notification */
			if($action == "vidNotification" || $action == "eventNotification" || $action == "gigNotification"){
				$getSettingQuery1 = 'SELECT subscribeesetting.' . $action . ' FROM subscribeesetting WHERE subscribeesetting.iRollID = :notifierID';
				try{
					$getSetting1 = $db->prepare($getSettingQuery1);
					$getSetting1->bindParam(':notifierID', $notifier); 
					$getSetting1->execute();					
					$getSetting1Results = $getSetting1->fetch(PDO::FETCH_NUM);
				}
				catch(Exception $e){
					echo $e; 
				}

				/* if the returned result is equal to 1 (true), relational query the subscription and subscriber table where the subscription.muteNotification = 0, subscribersetting.allNotification = 0,  subscribersetting.$action = 1 */
					if($getSetting1Results[0] == '1'){
						$getSubscribersQuery = 'SELECT subscription.iLoginID, subscription.sName, subscription.sType
												FROM subscription 
												INNER JOIN subscribersetting on subscribersetting.iLoginID = subscription.iLoginID
												WHERE subscription.iRollID = :iRollID AND subscription.muteNotification = 0 AND subscribersetting.' . $action . ' = 1 AND subscribersetting.allNotifications = 0';
						try{
							$getSubscribers = $db->prepare($getSubscribersQuery);
							$getSubscribers->bindParam(':iRollID', $notifier);
							$getSubscribers->execute(); 
							$getSubscribersResults = $getSubscribers->fetchAll(PDO::FETCH_ASSOC);
						}
						catch(Exception $e){
							echo $e; 
						}

						/* if the count of the resulting array is > 0, insert into the notificationmaster table */
							if(count($getSubscribersResults) > 0){
								/* Loop through the subscriber results and insert into the notificationmaster table */
									foreach($getSubscribersResults as $subscriber){
										$insertArray["notifiedID"] = $subscriber['iLoginID'];

										$field = array();
										$value = array();
										foreach($insertArray as $index => $indivInsert){
										 	$field[] = $index; 
										 	$value[] = $indivInsert;
										}

										$notificationInsert = $obj->insert($field,$value,$table);
										if($notificationInsert > 0){
											//Successful insertion
											return $notificationInsert;
										}
										else{
											//Problem updating notification table 
											return 0;
										}
									}	
							}
					}
			}
			elseif($action == "gigRequest" || $action == "gigInquiry" || $action == "suggestGig" || $action == "updatedGig" || $action == "artistSelected" || $action == "canceledGig" || $action == "artistWithdrawal" || $action == "artistDeselection"){
				/* action is "gigRequest || gigInquiry" directly insert into the notificationmaster table */
					foreach($insertArray as $index => $indivInsert){
					 	$field[] = $index; 
					 	$value[] = $indivInsert;
					}
					
					$notificationInsert = $obj->insert($field,$value,$table);
					if($notificationInsert > 0){
						//Successful insertion
						return $notificationInsert;
					}
					else{
						//Problem updating notification table 
						return 0;
					}
			}
			else{
				echo 'Problem updating!!!';
			}

	}
/*********************************************************** END - Notification function ***********************************************************/

/************************************* Display the age of an entity such as a post in secs, minutes, days, etc *************************************/
	function ageFuntion($date){
        $from = date_create($date);
        $to = date_create();
        /*
            y - year
            m - month
            d - day 
            h - hour
            i - minute
            s - second
        */
        $diff = date_diff($from, $to);

        /* Display the age of video from years down to seconds */
        /*if($diff->y > 0){
            echo $diff->y . ' Year' . ($diff->y > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->m > 0){
            echo $diff->m . ' Month' . ($diff->m > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->d > 0){
            echo $diff->d . ' Day' . ($diff->d > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->h > 0){
            echo $diff->h . ' Hour' . ($diff->h > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->i > 0){
            echo $diff->i . ' Min' . ($diff->i > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->s > 0){
            echo $diff->s . ' Sec' . ($diff->s > 1 ? 's' : '') . ' Ago'; 
        }
        else{
        	echo '<span class="font-weight-bold">Just Now!!!</span>';
        }*/
        
         if($diff->y > 0){
            $age = $diff->y . ' Year' . ($diff->y > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->m > 0){
            $age = $diff->m . ' Month' . ($diff->m > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->d > 0){
            $age = $diff->d . ' Day' . ($diff->d > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->h > 0){
            $age = $diff->h . ' Hour' . ($diff->h > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->i > 0){
            $age = $diff->i . ' Min' . ($diff->i > 1 ? 's' : '') . ' Ago'; 
        }
        elseif($diff->s > 0){
            $age = $diff->s . ' Sec' . ($diff->s > 1 ? 's' : '') . ' Ago'; 
        }
        else{
        	$age = '<span class="font-weight-bold">Just Now!!!</span>';
        }

        return $age;
    }
/********************************** END - Display the age of an entity such as a post in secs, minutes, days, etc **********************************/

/********************************************************** Calculate age from birth date **********************************************************/
	function getAge($bdate){
	    $from = new DateTime($bdate);
	    $to   = new DateTime('today');
	    $Age = $from->diff($to)->y;
	    return $Age; 
	}
/******************************************************* END - Calculate age from birth date *******************************************************/

/******************************************* Find matching artist when a new gig is posted for public response *************************************/
	function findArtistMatch($db, $obj, $gigInfo){
	    /* Create array for suggestedGig table */
	        $suggGigArray = array("gigID" => $gigInfo['gigId']);

	    /* Add static availability param to array */
	        $gigInfo['availability'] = 'Currently Gigging(Not excepting new gigs)';

	    /* Calculate the date of birth for the minimum age requirement */
	    	$nAge = $gigInfo['dDOB1']; 
            $dateToday = date_create();
            date_sub($dateToday,date_interval_create_from_date_string($nAge . " years"));
            $dateToday = date_format($dateToday, 'Y-m-d');
            $minDOB = $dateToday;

	    /* Create query statement and query database */ 
	        $findMatchQuery = 'SELECT usermaster.iLoginID, usermaster.iZipcode, usermaster.maxTravDistance FROM usermaster INNER JOIN states on states.id = usermaster.sStateName ';

	        /* Inner Join the talentmaster table if the usertype is  an artist */
	            if($gigInfo['userType'] == 'artist'){
	                $findMatchQuery .= 'INNER JOIN talentmaster on talentmaster.iLoginID = usermaster.iLoginID ';
	            }
	        /* continue query statement concatenation */
	            $findMatchQuery .= 'WHERE usermaster.sUserType = :sUserType AND usermaster.iLoginID != :gigManLoginId AND usermaster.sAvailability != :sAvailability AND states.name = :sStateName AND usermaster.dDOB <= :dDOB AND usermaster.minPay <= :minPay AND ';

	        /* Select appropriate column corresponding to the gender */
	        	if($gigInfo['sGender'] == 'both'){
	        		$findMatchQuery .= '(usermaster.sGender = :sGender1 OR usermaster.sGender = :sGender2) AND ';
	        	}
	        	else{
	        		$findMatchQuery .= 'usermaster.sGender = :sGender AND ';
	        	}

	        /* Select appropriate column corresponding to the userType */
	            if($gigInfo['userType'] == 'artist'){
	                $findMatchQuery .= 'talentmaster.TalentID = :TalentID';
	            }
	            elseif($gigInfo['userType'] == 'group'){
	                $findMatchQuery .= 'usermaster.sGroupType = :sGroupType';
	            }

	        /* NOT GOING TO USE CITY AND STATENAME AS A REQUIREMENT - WILL ALLOW USERS TO SPECIFY IN THEIR PROFILE THE MAX DISTANCE THEY 
	           WILL TRAVEL FOR A GIG AND THEN WE WILL UTILIZE THE ZIP CODE TO CALCULATE THE DISTANCE OF THE GIG FROM THE ZIPCODE OF THE ARTIST'S PROFILE
	            
	            AND usermaster.sCityName = :sCityName AND usermaster.iZipcode = :iZipcode 
	             AND usermaster.sAvailability = :sAvailability
	            $findMatch->bindParam(':sCityName',$gigInfo['venueCity']);
	            $findMatch->bindParam(':iZipcode',$gigInfo['venueZip']);
	            $findMatch->bindParam(':sAvailability',$gigInfo['availability']); 
	        */
	        
	        try{
	            $findMatch = $db->prepare($findMatchQuery);
	            $findMatch->bindParam(':sUserType',$gigInfo['userType']);
	            $findMatch->bindParam(':gigManLoginId',$gigInfo['gigManLoginId']);
	            $findMatch->bindParam(':sStateName',$gigInfo['venueState']);
	            $findMatch->bindParam(':sAvailability',$gigInfo['availability']);
	            $findMatch->bindParam(':dDOB',$minDOB);
	            $findMatch->bindParam(':minPay',$gigInfo['gigPay']);
	            
	            /* Select appropriate bindParam corresponding to the gender */
		        	if($gigInfo['sGender'] == 'both'){
		        		$sGender1 = 'male';
		        		$sGender2 = 'female';
		        		$findMatch->bindParam(':sGender1',$sGender1);
		        		$findMatch->bindParam(':sGender2',$sGender2);
		        	}
		        	else{
		        		$findMatch->bindParam(':sGender',$gigInfo['sGender']);
		        	}
	            
	            /* Select appropriate bindParam corresponding to the userType */
		            if($gigInfo['userType'] == 'artist'){
		                $findMatch->bindParam(':TalentID',$gigInfo['artistType']);
		            }
		            elseif($gigInfo['userType'] == 'group'){
		                $findMatch->bindParam(':sGroupType',$gigInfo['groupType']);                     
		            }
	            $findMatch->execute(); 
	            $findMatchResults = $findMatch->fetchAll(PDO::FETCH_ASSOC);

	              
	            if(count($findMatchResults) > 0){
	                /* Insert the matching artists into the suggested gigs table */
	                    foreach($findMatchResults as $val) {
	                        /* Calculate max travel distance - Calculate distance between two zip codes   , usermaster.maxTravDistance*/
	                            $zip1 = $gigInfo['dDOB1'];

	                        /* Add the gig id to each artist's array */
	                            $val['gigID'] = $gigInfo['gigId']; 
	                            $val['gigDate'] = $gigInfo['gigDate']; 
	                        
	                        /* Reset the field and value array after each loop */
	                            $field = array();
	                            $value = array(); 

	                        /* Insert values into the field and value array for table insertion */
	                            foreach($val as $key1 => $val1) {
	                                $field[] = $key1;
	                                $value[] = $val1;
	                            }
	                        /* Insert into the suggestgigs table */
	                            $table = 'suggestedgigs';
	                            // $insertSuccess = $obj->insert($field,$value,$table);

	                        /* If suggestedgigs table is updated successfully insert into notificationmaster table */    
	                            if($insertSuccess > 0){
	                                $action = 'suggestGig';
	                                $notifier = $gigInfo['gigManLoginId'];
	                                $notified = $val['iLoginID'];
	                                $link = $val['gigID'];
	                                // $succNotInsert = createNotification($db, $obj, $action, $notifier, $notified, $link);
	                            }
	                    }
	                return $findMatchResults;
	        	}
	        	else{
	        		return 0; 
	        	}

	        }
	        catch(Exception $e){
	            echo $e; 
	        }
	     /* END - Create query statement and query database */   
	}
/**************************************** END - Find matching artist when a new gig is posted for public response **********************************/

/******************************************* Query Database with PDO Method *************************************/

	/*
		*** Param Array Examples ***
		Param:
			$paramArray['status']['!='] = "cancelled"; 

		*** Inner Join Array Example *** 
		$innerJoinArray = array(
								array("giftmaster","iGiftID","postedgigsmaster","artistType")
							);

			** Here we are inner joing giftmaster.iGiftID = postedgigsmaster.artistType           **
			** Note: make sure the table listed first in the array is not the table being queried **
	*/
	
	function pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray){
		/* Create DB connection to Query Database & include config page */
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

		/* Define the columns that are being selected */
			if($columnsArray == 'all'){
				$col = '*';
			}
			else{
				$loopMax0 = count($columnsArray);
				$i = 1; 
				$col = '';
				foreach($columnsArray as $value0){
					if($i == $loopMax0){
						$col .= $value0;
					}
					else{
						$col.= $value0 . ', ';
					}
					$i++;
				}
			}

		/* INNER JOIN */
			if(count($innerJoinArray[0]) > 1){
				$innerJoin = '';
				for($p=0;$p<count($innerJoinArray);$p++){
					$innerJoin .= ' INNER JOIN ';
					$innerJoin .= $innerJoinArray[$p][0] . ' on ' . $innerJoinArray[$p][0] . '.' . $innerJoinArray[$p][1] . ' = ' . $innerJoinArray[$p][2] . '.' . $innerJoinArray[$p][3];
				}
				// echo $innerJoin; 
			}

		/* Define the Bind Params */
			$cond = '';
			$loopMax1 = count($paramArray);
			$j = 1; 

			/* Nested foreach loops allow user of function to specify the condition and more specifically the operator being used (>,<,=,etc) */
				foreach($paramArray as $index1 => $value1){
					foreach($value1 as $index1_5 => $value1_5){
						if($j == $loopMax1){
							if($index1 == 'MONTH(gigDate)'){
								$cond .= $index1 .' '. $index1_5 . ' :getMonth';
							}
							else{
								$cond .= $index1 .' '. $index1_5 . ' :' . str_replace('.','',$index1);
							}
						}
						else{
							if($index1 == 'MONTH(gigDate)'){
								$cond .= $index1 .' '. $index1_5 . ' :getMonth AND ';
							}
							else{
								$cond .= $index1 .' '. $index1_5 . ' :' . str_replace('.','',$index1) . ' AND ';
							}
						}
					}
					$j++;

					if($index1 == 'MONTH(gigDate)'){
						$bParam[] = ':getMonth,' . $value1_5;
					}
					else{
						$bParam[] = ':' . str_replace('.','',$index1) . ',' . $value1_5;
					}
				}

		/* Define Query Statement */
			$queryStatement = 'SELECT ' . $col . ' FROM ' . $table;
			if($innerJoin != ''){
				$queryStatement .= $innerJoin;
			}
			if($cond !== ''){
				$queryStatement .= ' WHERE ' . $cond;
			}

			if($orderByParam){
				$queryStatement .= ' ORDER BY ' . $orderByParam;
			}
			
			//  echo $queryStatement;

		/* Query the database in a try catch block */
			try{
				$queryDB = $db->prepare($queryStatement);
				foreach($bParam as $param){
					$bParam2 = explode(',', $param);
					$queryDB->bindParam($bParam2[0], $bParam2[1]);
				}

				$queryDB->execute();
				$queryDBResults = $queryDB->fetchAll(PDO::FETCH_ASSOC);
				return $queryDBResults;
			}
			catch(Exception $e){
				echo 'Error: ' . $e; 
			}
	}
/**************************************** END - Query Database with PDO Method **********************************/

/************************************************* Truncate function ********************************************/
	function truncateStr($string, $maxLength){
		if(strlen($string) > $maxLength){
			$gigItem1 = substr_replace($string, '...', $maxLength);
		}
		else{
			$gigItem1 = $string;
		}
		return $gigItem1;
	}
/********************************************** END - Truncate function ****************************************/

/*********************** Find Distance between two adresses, stats, cities, or zip codes ***********************/
	function findDist($originArray, $destinationArray){

  	/* Loop through the origin and destination address arrays to properly formatt them for the request URL */
  		$origin = '';
  		$destination = '';

	    $i=1;
	    $count0 = count($originArray);
	    foreach ($originArray as $key0 => $value0) {
	    	if($i == $count0){
	    		$origin .= $value0['iZipcode'];
	    	}
	    	else{
	    		$origin .= $value0['iZipcode'] . '|';
	    	}
	    	$i++;
	    }

	    for($i=0;$i<count($destinationArray);$i++){
	    	if($i == count($destinationArray) - 1){
	    		$destination .= $destinationArray[$i];
	    	}
	    	else{
	    		$destination .= $destinationArray[$i] . '|';
	    	}
	    } 

  	/* Send distance matrix request to the google distance matrix api */
		$distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.urlencode($origin).'&destinations='.urlencode($destination).'&key=AIzaSyDxXsiASwOpAFLlQbZ7nhzYJH_nx5pp_wE');
		
	/* pars the JSON response from the google api */
		$distance_arr = json_decode($distance_data);

	/* Check that request status does not return an error */
		if ($distance_arr->status=='OK') {
		    $destination_addresses = $distance_arr->destination_addresses;
		    $origin_addresses = $distance_arr->origin_addresses;

		    /* Get distance and duration data corresponiding the correct user */
		    	$Rows = $distance_arr->rows; 
		    	$rowCount = count($Rows);

		    	for($t=0;$t<$rowCount;$t++){
		    		/* Convert meters into miles & seconds into days, mins, hrs, secs */
		    			if($Rows[$t]->elements[0]->status == 'OK'){

			    			$disMeters = $Rows[$t]->elements[0]->distance->value;
			    			$distMiles = $disMeters/1609.34; 
			    			$distMiles = round($distMiles,1);

			    			$durSecs = $Rows[$t]->elements[0]->duration->value;
			    			if(intval($durSecs) < 60){
				    			$travTime = intval($durSecs) . 'sec(s).'; 

			    			}
			    			else{
				    			$durMin = intval($durSecs/60); 
				    			if($durMin <= 59){
				    				$travTime = $durMin . ' min(s).'; 
				    			}
				    			elseif($durMin >= 60){
				    				$durHr = $durMin/60; 
				    				$durHr = round($durHr,1);

				    				if(intval($durHr) < 24){
				    					$travTime = $durHr . ' hr(s).';
				    				}
				    				else{
				    					$durDay = $durHr/24; 
				    					$durDay = round($durDay,1);
				    					$travTime = $durDay . ' day(s)';
				    				}
				    				
				    			}
				    		}
				    	}
				    	else{
				    		$distMiles = 'not found';
							$travTime = 'not found';
				    	}
			    	/* Assign distance and duration elements to the corresponding artist */
			    		$originArray[$t]['dist'] = $distMiles;
			    		$originArray[$t]['dur'] = $travTime;
			    		if($distMiles <= $originArray[$t]['maxTravDistance'] || $originArray[$t]['maxTravDistance'] == '0.0'){
			    			$originArray[$t]['distReqMet'] = true; 
			    		}
			    		else{
			    			$originArray[$t]['distReqMet'] = false; 
			    		}
		    	}

		    /* Return the updated origin array */
		    	return $originArray; 

		} else {
			echo "<p>The request was Invalid</p>";
			exit();
		}
  }
/******************** END - Find Distance between two adresses, stats, cities, or zip codes ********************/

/************************** Move File from temporary location to permanent directory **************************/
	function moveFile($FILES, $targetFile) {
		if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
			$uploadStatus = 'File Upload Successful';
		}	
		else {
			$uploadStatus = 'File Upload unSuccessful';
			$errorMessage = $uploadStatus;
			$errorCount++;
		}

		return $uploadStatus;
	}
/*********************** END - Move File from temporary location to permanent directory ***********************/

/************************************************ Upload Images ************************************************/
	function handlefileUpload($userType, $fileType, $iLoginID) {

		/* PROCESS UPLOADED Profile IMG */
			switch ($fileType){

				case "profileImg":
					$Dir = '/upload/'. $userType . '/'.$iLoginID.'/'; 
					break; 

				case "galleryImg":
					$Dir = '';
					break;

				case "video":
					$Dir = '/upload/video/'. $userType . '/'. $userType . '_'.$iLoginID.'/'; 
					break; 

				case "music":
					$Dir = ''; 
					break; 
			}

			
				$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $Dir;
				$randNumb = rand(1,50000);
				$newIndivFile = $_FILES['sProfileName'];
				$target_file = $target_dir . basename($newIndivFile['name']); 
				$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$fileSize = $newIndivFile['size'];


				if(count($newIndivFile) > 0){
					if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
						$errorMessage = 'There was an upload error: ' . $newIndivFile['error'];
					}
					elseif($fileSize != '' && $fileSize > 5000000) {
						$errorMessage = 'Your File Size Must Be Less Than 5MB';
					}
					else {
						$target_file_final = $target_dir . $randNumb . str_replace(' ', '', $newIndivFile['name']); 
						$uploadStatus = 'upload';

						/* Add profile img File Path to the post array */
							$profPic_dir = $Dir . basename($target_file_final);
					}
				} 
		/* END - PROCESS UPLOADED Profile IMG */	

		if($uploadStatus == 'upload'){
			if(file_exists($target_dir)) {
				$uploadStatusFinal = moveFile($newIndivFile, $target_file_final);
			}
			else {
				mkdir($target_dir,0777,true);	
				$uploadStatusFinal = moveFile($newIndivFile, $target_file_final);			
			}

			/* If upload successful, return the new file path */
				if($uploadStatusFinal == 'File Upload Successful'){
					return $profPic_dir; 
				}
				else{
					return $uploadStatusFinal; 
				}
		}
		else{
			return $errorMessage; 
		}
	}
/********************************************* END - Upload Images *********************************************/

/************************************************ Multiple File Upload ************************************************/
	function handleMultipleFileUpload($userType, $fileType, $iLoginID, $fileArray) {

		$Dir = '/upload/puwHostImgs/'. $userType . '/'.$userType.'_' . $iLoginID . '/';
		$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $Dir;
		$hostImgs['iLoginID'] = $iLoginID; 

			if( $fileType == 'venueImgs'){
				$counter = count( $fileArray['name'] ); 

				if($counter > 0){
					for ( $i=0; $i< $counter; $i++) {
						// var_dump( $fileArray['name'][$i].' '.$fileArray['type'][$i].' '.$fileArray['tmp_name'][$i].' '.$fileArray['error'][$i].' '.$fileArray['size'][$i]);
						
						$randNumb = rand(1,50000);
						$file_name = $fileArray['name'][$i];
						$file_type = $fileArray['type'][$i];
						$file_tmp_name['tmp_name'] = $fileArray['tmp_name'][$i];
						$file_error = $fileArray['error'][$i];
						$file_size = $fileArray['size'][$i];
						$error_count = 0;
						$final_file_name = $randNumb . str_replace(' ', '', $file_name);

						/* Validate files (imgs) */
							if(!empty($file_error) && $file_error != 4){
								$errorMessage['error'] = 'There was an upload error: ' . $file_error;
								$error_count++; 
							}
							elseif($file_size != '' && $file_size > 5000000) {
								$errorMessage['error'] = 'Your File Size Must Be Less Than 5MB';
								$error_count++; 
							}
							else {
								$target_file_final = $target_dir . $final_file_name; 
								$uploadStatus = 'upload';

								/* Add profile img File Path to the post array */
									$hostImgCurrent = $Dir . basename($target_file_final);
							}

						/* If no errors - move files to permanent location */
							if($error_count > 0){
								return json_encode($errorMessage);
								break; 
							}
							else{

								if( file_exists($target_dir) ) {
									$uploadStatusFinal = moveFile($file_tmp_name, $target_file_final);
								}
								else {
									mkdir($target_dir,0777,true);	
									$uploadStatusFinal = moveFile($file_tmp_name, $target_file_final);			
								}

								/* If upload successful, return the new file path */
									if($uploadStatusFinal == 'File Upload Successful'){
										$hostImgs['file_path'][] = $hostImgCurrent; //$final_file_name
									}
									else{
										$hostImgs['file_path'][] = $uploadStatusFinal; //$final_file_name
									}
							}
					}

					return $hostImgs;
				}
			}
			else{
				//handle other files
			}
	}
/********************************************* END - Multiple File Upload *********************************************/

/********************************************* Hyphenate phone #'s *********************************************/
	function phoneNumbDisplay($Contact){
		/*The substr_replace() method is used to insert '-' into the phone numbers to make them more */
			$Contact1 = substr_replace($Contact, '-', 3, 0);
			$Contact2 = substr_replace($Contact1, '-', 7, 0);
			return $Contact2;
	}

/********************************************* END - Hyphenate phone #'s *********************************************/

/************************************************ Change time format ************************************************/
	function changeTimeFormat($time,$toDB){
		$newTime =  date_create( $time );
		
		if($toDB){
			$newTime = date_format($newTime, 'H:i:s');
		}
		else{
		 	
			$newTime = date_format($newTime, 'g:i a');
		}
		return $newTime;
	}
	
	function unixTimeStampConversion($timeStamp,$toDB){
		if($toDB){
			$newTime = date('Y-m-d H:i:s',$timeStamp);
		}
		else{
			$newTime = date('D M d, Y @ h:ia',$timeStamp);
		}
		return $newTime;
	}
/********************************************* END - Change time format *********************************************/

/*************************************************** Remove non-Alpha-numeric chars ***************************************************/
	function removeAlphaNumChars($string){
		$removeChars  = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
		return $removeChars;
	}
	
	function removeNonNumChars($string){
		$removeChars  = preg_replace("/[^0-9 ]/", '', $string);
		return $removeChars;
	}
/************************************************ END - Remove non-Alpha-numeric chars ************************************************/

/*************************************************** Remove File From Server ***************************************************/
	function delFile($filePath){
		/* Delete video's current thumbnail photo from the server */
			$fileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $filePath;
			
			if(file_exists($fileRemoved)){
				try{
					$fileDeleted = unlink($fileRemoved);
					return $fileDeleted;
				}
				catch(Exception $e){
					return $e; 
				}
				

				// if($fileDeleted){
				// 	return $fileDeleted;
				// }
				// else{
				// 	return 'There was a problem deleting this file';
				// }
			}
			else{
				return 'Invalid File Path';
			}
	}
/************************************************ END - Remove File From Server ************************************************/

/**************************************** Dollars-Cents conversions ****************************************/
	function dollarsToCents($amount){
		/* Remove any commas or dollar signs */
			$amount = str_replace( ',','',$amount );
			$amount = str_replace( '$','',$amount );
		
		/* Get Dollar amount and convert to cents */
			$dollars = intval( $amount );
			$dollarsInCents = $dollars * 100; 

		/* Get the cents and convert to integer to be added to the dollar amount that was just converted to cents */
			$cents = strstr($amount,".", false);
			$cents = str_replace( '.','',$cents );
			$cents = intval($cents);
			$cents = substr($cents,0,2);
		
			$amount = $dollarsInCents + $cents; 

		/* return amount in cents */
			return $amount; 
	}

	function CentsToDollars($amount){

		if( $amount > 0 ){
			/* Reformat the charged amount */
				$amount = substr_replace($amount, '.', -2, 0);
				$amount = substr_replace($amount, '$', 0, 0);	
		}
		else{
			$amount = '$0.00';
		}


		/* return amount in dollars*/
			return $amount;
	}

/************************************* END - Dollars-Cents conversions *************************************/
?>

















