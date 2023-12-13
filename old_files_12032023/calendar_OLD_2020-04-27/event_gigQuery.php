<?php
		
		/* Query database for gigs accepted by artists */
			$stat1 = 'confirmed';
			$stat2 = 'active';
			$stat3 = 'active';
			$gigAccepted='SELECT gigartists.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_endTime
					 	 FROM gigartists 
					  	 INNER JOIN gigdetails on gigartists.gigId = gigdetails.gigId
					     WHERE gigartists.gigArtists_userId = ? AND gigartists.gigArtists_artistStatus = ? AND gigartists.gigArtists_gigManCancelStatus = ? AND gigdetails.gigDetails_gigStatus = ? AND';
			if($privSetting == 'pub') {
				$gigAccepted .= ' gigdetails.gigDetails_gigPrivacy = ?';
				$priv1 = 'pub';
			}
			elseif($privSetting == 'all') {
				$gigAccepted .= ' (gigdetails.gigDetails_gigPrivacy = ? OR gigdetails.gigDetails_gigPrivacy = ?)';
				$priv1 = 'pub';
				$priv2 = 'priv';
			}
			else{
				exit('No Id or status submitted');
			}

			try {
				$calInfo1 = $db->prepare($gigAccepted);
				$calInfo1->bindParam(1, $userLogin);
				$calInfo1->bindParam(2, $stat1);
				$calInfo1->bindParam(3, $stat2);	
				$calInfo1->bindParam(4, $stat3);
				if($privSetting == 'pub') {
					$calInfo1->bindParam(5, $priv1);
				}
				elseif($privSetting == 'all') {
					$calInfo1->bindParam(5, $priv1);
					$calInfo1->bindParam(6, $priv2);
				}
			
				$calInfo1->execute();
			} catch(Exception $e) {
				echo 'There was an error Retrieving Gig Managers Info<pre>'; 
				echo $e; 
			}
			$output1 = $calInfo1->fetchAll(PDO::FETCH_ASSOC);


		/* Query database for gigs created by users */
			$gigManStat1 = 'active';
			$gigCreated='SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_endTime 
					 	 FROM gigdetails 
					     WHERE gigdetails.gigDetails_gigManLoginId = ? AND gigdetails.gigDetails_gigStatus = ? AND ';  
			if($privSetting == 'pub') {
				$gigCreated .= ' gigdetails.gigDetails_gigPrivacy = ?';
				$priv1 = 'pub';
			}
			elseif($privSetting == 'all') {
				$gigCreated .= ' (gigdetails.gigDetails_gigPrivacy = ? OR gigdetails.gigDetails_gigPrivacy = ?)';
				$priv1 = 'pub';
				$priv2 = 'priv';
			}
			else{
				exit('No Id or status submitted');
			}
			try {
				$calInfo2 = $db->prepare($gigCreated);
				$calInfo2->bindParam(1, $userLogin);
				$calInfo2->bindParam(2, $gigManStat1);
				if($privSetting == 'pub') {
					$calInfo2->bindParam(3, $priv1);
				}
				elseif($privSetting == 'all') {
					$calInfo2->bindParam(3, $priv1);
					$calInfo2->bindParam(4, $priv2);
				}
				$calInfo2->execute();
			} catch(Exception $e) {
				echo 'There was an error Retrieving Gig Managers Info<pre>'; 
				echo $e; 
			}
			$output2 = $calInfo2->fetchAll(PDO::FETCH_ASSOC);


		/* Query database for Events RSVP'd to by users */
			$eventStat = 1; 
			$eventRsvp = 'SELECT eventbooking.e_id, eventbooking.event_name, eventbooking.toevent, eventbooking.tee
						  FROM eventbooking
						  INNER JOIN eventmaster on eventbooking.e_id = eventmaster.e_id
						  WHERE eventbooking.iLoginId = ? AND eventmaster.isActive = ?';

			try{
				$calInfo3 = $db->prepare($eventRsvp);
				$calInfo3->bindParam(1, $userLogin);
				$calInfo3->bindParam(2, $eventStat);
				$calInfo3->execute();
			}
			catch(Exception $e) {
				echo 'There was an error Retrieving the list of events you are attending<pre>'; 
				echo $e; 
			}
			$output3 =$calInfo3->fetchAll(PDO::FETCH_ASSOC);
	
	/**************************** END - Query Databases for Gig and Event Info *************************/

	
	/* Function to update the index of the events arrays and add additional FullCalendar event's options */

		function arrayUpdate($arrayInput, $type, $urlIn, $privSetting) {
			$eventCount = count($arrayInput);
			$fullCalOptions = array('id','title','start','end','url','backgroundColor','textColor'); 
			$url1 = 'http://google.com';
			
			for($i=0;$i<$eventCount;$i++) {
				/* First, i need to remove elements from the the Output1 array and then add elements URL and ClassName
					- Remove Unwanted array elements 
				*/
						$url = $urlIn; 
						if($type == 'gig'){
							$BC = 'rgba(150,98,215,1)';
							//if($privSetting == 'all') {
								$url .= $arrayInput[$i]['gigId'];
							//}
						}
						elseif($type == 'gigMan') {
							$BC = 'yellow';
							//if($privSetting == 'all') {
								$url .= $arrayInput[$i]['gigId'];
							//}
						}
						else{
							$BC = 'green';
							$url .= $arrayInput[$i]['e_id'];
						}
						$textColor = 'rgba(0,0,0,.7)';
					/* Add Url and ClassName elements */
						array_push($arrayInput[$i], $url, $BC, $textColor);

				/* Second, Create New Array to be used as the JSON object that is fed to calandarDisplay.php 
					- Combine Index and pertinent array values returned from the database 
				*/
						$finalList[] = array_combine($fullCalOptions, $arrayInput[$i]);		
			}
			return $finalList;
		}
	/********** END - Function *****************/

	/* Update arrays for all gig, gig manager, and recreational events for user in preperation for JSON Feed 
			- Inline Conditionals using ternary operators to test if arrays are empty
		*/	if($privSetting == 'all') {
				$urlArt = URL . 'views/gigform.php?gigID=';
				$urlMan = URL . 'views/gigform.php?gigID=';
				$urlEvents = URL . 'views/eventdetail.php?event=';
			}
			elseif ($privSetting == 'pub') {
				$urlArt = URL . 'managebooking/pubGigView.php?u_Id=' . $userLogin . '&g_Id=';
				$urlMan = URL . 'manageBooking/pubGigView.php?u_Id=' . $userLogin . '&g_Id=';
				$urlEvents = URL . 'manageBooking/pubGigView.php?u_Id=' . $userLogin . '&event=';
			}
			
			$finalList1= (count($output1) == 0)?array():arrayUpdate($output1, 'gig', $urlArt, $privSetting); 
			$finalList2 = (count($output2) == 0)?array():arrayUpdate($output2, 'gigMan', $urlMan, $privSetting);
			$finalList3 = (count($output3) == 0)?array():arrayUpdate($output3, 'recEvent', $urlEvents, $privSetting);

		/* Combine all updated event arrays */	
			$finalList = array_merge($finalList1,$finalList2,$finalList3);
?>