<?php 

	/* Get posted gig artist's inquiry info */

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
      	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');


	if($_GET['u_id']){

		/* query for the artist info */
			$u_id = trim(intval($_GET['u_id']));
			$g_id = trim($_GET['g_id']);

			/* Query the gigsinquirymaster table */
                $query1 = 'SELECT giginquirymaster.iLoginID,giginquirymaster.dateTime,giginquirymaster.comments, usermaster.sFirstName, usermaster.sLastName, usermaster.sGroupName, usermaster.dDOB, usermaster.sCityName, states.statecode, usermaster.sProfileName, usermaster.iZipcode, usermaster.sContactEmailID, usermaster.sContactNumber, usermaster.sUserType
                           FROM giginquirymaster 
                           INNER JOIN usermaster on usermaster.iLoginID = giginquirymaster.iLoginID
                           INNER JOIN states on usermaster.sStateName = states.id
                           WHERE giginquirymaster.iLoginID = ?';

                $query2 = 'SELECT talent FROM talentmaster WHERE iLoginID = ?';

                $query3 = 'SELECT * 
                		   FROM groupmembersmaster 
                		   INNER JOIN giftmaster on giftmaster.iGiftID = groupmembersmaster.talentID
                		   WHERE iLoginID = ?';

               	$query4 = 'SELECT postedgigsmaster.selectedArtist, usermaster.sFirstName, usermaster.sLastName 
               			   FROM postedgigsmaster 
               			   INNER JOIN usermaster on usermaster.iLoginID = postedgigsmaster.selectedArtist 
               			   WHERE postedgigsmaster.gigId = ?';


                try{
                    $getInquiries = $db->prepare($query1);
                    $getInquiries->bindParam(1, $u_id);
                    $getInquiries->execute();
                    $getInquiriesResults = $getInquiries->fetch(PDO::FETCH_ASSOC);
                    // var_dump($getInquiriesResults); giginquirymaster.selected,
                    
                    /* Query db for selected artist */
                    	$getSelectedArtist = $db->prepare($query4);
	                    $getSelectedArtist->bindParam(1, $g_id);
	                    $getSelectedArtist->execute();
	                    $getSelectedArtistResults = $getSelectedArtist->fetch(PDO::FETCH_ASSOC);
	                    // var_dump($getSelectedArtistResults);
                    /* Calculate age from birth date */
                        $from = new DateTime($getInquiriesResults['dDOB']);
                        $to   = new DateTime('today');
                        $artistAge = $from->diff($to)->y;
                        $getInquiriesResults['dDOB'] = $artistAge;

                    /* The substr_replace() method is used to insert '-' into the phone numbers to make them more */
                        $artistContact = $getInquiriesResults['sContactNumber'];
                        $artistContact1 = substr_replace($artistContact, '-', 3, 0);
                        $artistContact2 = substr_replace($artistContact1, '-', 7, 0);
                        $getInquiriesResults['sContactNumber'] = $artistContact2;

			        /* Re-format the datetime */
			        	$submissionTime = date_create($getInquiriesResults['dateTime']);
			        	$submissionTime = date_format($submissionTime, 'M d, Y @ h:ia');
			        	$getInquiriesResults['dateTime'] = $submissionTime;

                     /* Handle Groups vs artist  usertypes */
                    if($getInquiriesResults['sUserType'] == 'group'){
                    	$getTalents = $db->prepare($query3);
	                    $getTalents->bindParam(1, $u_id);
	                    $getTalents->execute();
	                    $getTalentsResults = $getTalents->fetchAll(PDO::FETCH_ASSOC);

	                    if(count($getTalentsResults) > 0 && count($getInquiriesResults) > 0 ){

	                    }
                    }
                    elseif($getInquiriesResults['sUserType'] == 'artist'){
                    	$getTalents = $db->prepare($query2);
	                    $getTalents->bindParam(1, $u_id);
	                    $getTalents->execute();
	                    $getTalentsResults = $getTalents->fetchAll(PDO::FETCH_ASSOC);

	                    if(count($getTalentsResults) > 0 && count($getInquiriesResults) > 0 ){
	                    	foreach($getTalentsResults as $Talents){
	                    		$talentArray[] = str_replace("_", "/", $Talents['talent']);
	                    	}

				         	/* Loop Through the info array and create xml tags */
				         		echo '<artistInfo>';
				         			if($getSelectedArtistResults){
						         		echo '<selectedArtist>' . $getSelectedArtistResults['selectedArtist'] . '</selectedArtist>';
						         		echo '<selectedArtistFirst>' . $getSelectedArtistResults['sFirstName'] . '</selectedArtistFirst>';
						         		echo '<selectedArtistLast>' . $getSelectedArtistResults['sLastName'] . '</selectedArtistLast>';
						         	}
						         	else{
						         		echo '<selectedArtist>0</selectedArtist>';
						         		echo '<selectedArtistFirst>0</selectedArtistFirst>';
						         		echo '<selectedArtistLast>0</selectedArtistLast>';
						         	}

			                    	foreach ($getInquiriesResults as $key => $value) {
			                    		if($value == ''){
			                    			echo '<' . $key . '>N/A</' . $key . '>';
			                    		}
			                    		else{
								         	echo '<' . $key . '>' . trim($value) . '</' . $key . '>';
								         }
							        }

							       	/* handle talent */
								       	echo '<talNum>'. count($talentArray) . '</talNum>';
								       	foreach ($talentArray as $key1 => $value1) {
								       		if($value1 == ''){
								       			echo '<talent>N/A</talent>';
								       		}
								       		else{
								       			echo '<talent>' . $value1 . '</talent>';
								       		}
								       	}
				         		echo '</artistInfo>';
	                    }
                    }
                    
                    if(count($getTalentsResults) > 0 && count($getInquiriesResults) >0 ){
                    	foreach($getTalentsResults as $Talents){
                    		$talentArray[] = $Talents['talent'];
                    	}

			         	/* Loop Through the info array and create xml tags */
			         		echo '<artistInfo>';
		                    	foreach ($getInquiriesResults as $key => $value) {
						         	echo '<' . $key . '>' . trim($value) . '</' . $key . '>';
						        }
			         		echo '</artistInfo>';
                    }
                }
                catch(Exception $e){
                    echo $e; 
                }
	}
	elseif($_GET['isPostedStatus']){
		/* Determine if post is being hidden or un-hidden */
			if($_GET['isPostedStatus'] == 'hideGigPost'){
				$_GET['isPostedStatus'] = 0;
			}
			else{
				$_GET['isPostedStatus'] = 1;
			}
		/* Set and unset appropriate vars for the update function */
			$table = 'postedgigsmaster';
			$cond = 'gigId = "' . $_GET['gigId'] . '" AND gigManLoginId = ' . $_GET['gigManLoginId'];
			unset($_GET['gigId']);
			unset($_GET['gigManLoginId']);
			$array = $_GET;

		/* call pdo method update function from gsFunctPage */
			$updateSucc = updateTable($db, $array, $cond, $table);
			echo $updateSucc;
	}
	elseif($_POST){
		// var_dump($_POST);
		$table='giginquirymaster';

		if($_POST['action'] == 'submitInquiry'){
			unset($_POST['action']);
			$_POST['comments'] = trim($_POST['comments']);

			/* Create time stamp */
				$today = date_create();
				$today = date_format($today, 'Y-m-d H:i:s');
				$_POST['dateTime'] = $today;

			/* Insert the inquiry into the giginquirymaster */
				foreach ($_POST as $key => $val) {
					$field[] = $key;
					$value[] = $val;
				}
			
			/* Call the insert function */
				$insertSuccess = $obj->insert($field,$value,$table);

				if($insertSuccess && $insertSuccess > 0){
					echo 'success';
					/* Remove this artist from the suggested gigs table */
						$table1 = 'suggestedgigs';
						$cond = 'iLoginID = ' . $_POST['iLoginID'];
						$delSuccess = $obj->delete($table1,$cond);

					/* Notify the gig manager that they have a inquiry */
						$action = 'gigInquiry';
						$notifier = $_POST['iLoginID'];
						$notified = $_POST['gigManID'];
						$link = $_POST['gigId'];
						createNotification($db, $obj, $action, $notifier, $notified, $link);
				}
				else{
					echo 'failed';
				}
		}
		elseif($_POST['action'] == 'removeInquiry'){
			/* Remove the artist's inquiry from the giginquirymaster */
				// var_dump($_POST);
				// exit;
				$cond = 'iLoginID = ' . $_POST['iLoginID'];
				$delSuccess = $obj->delete($table,$cond);

				if($delSuccess){
					/******************************************************************************************* 
					***** If the artist was already selected to play the gig, notify gig manager of withdrawal **
					***** and update the selectedArtist column in postedgigmaster ******************************
					********************************************************************************************/
						if($_POST['selectedArtist']){
							/* Update the selectedArtist column in postedgigmaster table */
								$array = array('selectedArtist' => 0, "status" => 'Pending');
								$cond = 'gigid = "' .$_POST['gigId'].'"';
								$table = 'postedgigsmaster'; 
								$updSucc = updateTable($db, $array, $cond, $table);

							/* Send Notification to gig manager */
								$notifier = $_POST['iLoginID'];
								$notified = $_POST['gigManID'];
								$link = $_POST['gigId'];
								$action = 'artistWithdrawal';
								$notSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);
						}

					echo 'success';
				}
		}
		elseif($_POST['action'] == 'selectArtist'){
			// var_dump($_POST);
			// exit;
			/* Define vars */
				if($_POST['transaction'] == 'selectArtist'){
					$_POST['selectedArtist'] = $_POST['iLoginID'];
					$_POST['status'] = 'booked';
					$action = 'artistSelected';
				}
				elseif($_POST['transaction'] == 'deSelectArtist'){
					$_POST['selectedArtist'] = 'NULL';		
					$_POST['status'] = 'Pending';
					$action = 'artistDeselection';
				}
				$table = 'postedgigsmaster'; 
				$cond = 'gigId = "' . $_POST['gigId'] .'"';
				$gm_id = $_POST['gm_id'];
				$iLoginID = $_POST['iLoginID'];
				$gigID = $_POST['gigId'];

			/* Unset unnessary array elements */
				unset($_POST['transaction']);
				unset($_POST['action']);
				unset($_POST['iLoginID']);
				unset($_POST['gigId']);
				unset($_POST['gm_id']);


			/* Update postedgigsmaster table */
				$selectArtist = updateTable($db, $_POST, $cond, $table);

				if($selectArtist){
					/* Send Notification to gig manager */
						$notifier = $gm_id;
						$notified = $iLoginID;
						$link = $gigID;
						$notSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);
						// echo $notSucc;
						if( $notSucc > 0){
							echo $selectArtist;
						}
				}
				else{
					echo $selectArtist;
				}
			/* END - Update postedgigsmaster table */
		}
	}
?>




