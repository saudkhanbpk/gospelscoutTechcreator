<?php
	
/* Define ownership */
	if( $userLogin == $currentUserID){
		$owner = true; 
	}
	else{
		$owner = false; 
	}

/* Check for proper get vars - query proper tables */
	if( $u_type == 'artist' || $u_type == 'group'){

		/******************************************* Get artist's gigs *******************************************/
			/* Get gigs from postedgigneededtalentmaster */
				$paramArray['artist_selected']['='] = $userLogin;
				$innerJoinArray = array(
					array('postedgigsmaster','gigId','postedgigneededtalentmaster','gigid'),
					// array('giftmaster','iGiftID','postedgigneededtalentmaster','artistType'),
				);
				/* Check privacy status of this calendar */
					if($owner){
						/* fetch private and public gigs */
							$paramOrArray['postedgigsmaster.gigPrivacy']['='][] = 'priv';
							$paramOrArray['postedgigsmaster.gigPrivacy']['='][] = 'pub';
					}
					else{
						/* fetch public gigs ONLY */
						$paramArray['postedgigsmaster.gigPrivacy']['='] = 'pub';
					}
				$columnArray = array('postedgigsmaster.gigId', 'postedgigsmaster.gigDate','postedgigsmaster.setupTime', 'postedgigsmaster.startTime','postedgigsmaster.endTime','postedgigsmaster.gigName');//,'giftmaster.sGiftName'

				// /* NOTE: may add param in eventartists table that allows artists to decide if they want a gig viewable in their public calendar */

				$get_artitst_postedGigs = pdoQuery('postedgigneededtalentmaster',$columnArray,$paramArray,$emptyArray,$innerJoinArray,$emptyArray,$paramOrArray,$emptyArray,$emptyArray);
				foreach($get_artitst_postedGigs as $get_artitst_postedGigs_index => $get_artitst_postedGigs_val){
					if($_GET['formatTime'] == 'true'){
						$date = date_format(date_create($get_artitst_postedGigs_val['gigDate']), 'D, d M y');
						$setUp = date_format(date_create($get_artitst_postedGigs_val['setupTime']), 'g:ia');
						$start = date_format(date_create($get_artitst_postedGigs_val['startTime']), 'g:ia');
						$end = date_format(date_create($get_artitst_postedGigs_val['endTime']), 'g:ia');

						$get_artitst_postedGigs[$get_artitst_postedGigs_index]['setupTime_formal'] = $date.' @ '.$setUp;
						$get_artitst_postedGigs[$get_artitst_postedGigs_index]['startTime_formal'] = $date.' @ '.$start;
						$get_artitst_postedGigs[$get_artitst_postedGigs_index]['endTime_formal'] = $date.' @ '.$end;
					}
					$get_artitst_postedGigs[$get_artitst_postedGigs_index]['setupTime'] = $get_artitst_postedGigs_val['gigDate'] . 'T' . $get_artitst_postedGigs_val['setupTime'];
					$get_artitst_postedGigs[$get_artitst_postedGigs_index]['startTime'] = $get_artitst_postedGigs_val['gigDate'] . 'T' . $get_artitst_postedGigs_val['startTime'];
					$get_artitst_postedGigs[$get_artitst_postedGigs_index]['endTime'] = $get_artitst_postedGigs_val['gigDate'] . 'T' . $get_artitst_postedGigs_val['endTime'];
					
					unset($get_artitst_postedGigs[$get_artitst_postedGigs_index]['gigDate']);
				}

			/* Get gigs from puweventmaster */
				// $paramArray0['iLoginid']['='] = $userLogin;
				// $paramArray0['artist_is_playing']['='] = '1';
				// $innerJoinArray0 = array(
				// 	array('puweventsmaster','id','eventartists','gigId')
				// );
				// $columnArray0 = array(' puweventsmaster.id',' puweventsmaster.date',' puweventsmaster.setupTime', ' puweventsmaster.startTime',' puweventsmaster.endTime');//
				// $get_artitst_puwGigs = pdoQuery('eventartists',$columnArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$leftJoinArray0,$paramOrArray0);
				// foreach($get_artitst_puwGigs as $get_artitst_puwEvents_index => $get_artitst_puwEvents_val){
				// 	$get_artitst_puwGigs[$get_artitst_puwEvents_index]['setupTime'] = $get_artitst_puwEvents_val['date'] . ' ' . $get_artitst_puwEvents_val['setupTime'];
				// 	$get_artitst_puwGigs[$get_artitst_puwEvents_index]['startTime'] = $get_artitst_puwEvents_val['date'] . ' ' . $get_artitst_puwEvents_val['startTime'];
				// 	$get_artitst_puwGigs[$get_artitst_puwEvents_index]['endTime'] = $get_artitst_puwEvents_val['date'] . ' ' . $get_artitst_puwEvents_val['endTime'];
				// 	unset($get_artitst_puwGigs[$get_artitst_puwEvents_index]['date']);
				// 	$get_artitst_puwGigs[$get_artitst_puwEvents_index]['name'] = '#popUpWorship';
				// }
		/**************************************** END - Get artist's gigs ****************************************/

		/******************************************* Get Gig Managers's gigs *******************************************/
			
			if($owner){
				/* Query the postedgigmaster table */
					$paramArray1['gigManLoginId']['='] = $userLogin;
					$columnArray1 = array('postedgigsmaster.gigId', 'postedgigsmaster.gigDate','postedgigsmaster.setupTime', 'postedgigsmaster.startTime','postedgigsmaster.endTime','postedgigsmaster.gigName');//
					$get_artist_managedGigs = pdoQuery('postedgigsmaster',$columnArray1,$paramArray1,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
					
					foreach($get_artist_managedGigs as $get_artist_managedGigs_index => $get_artist_managedGigs_val){
						if($_GET['formatTime'] == 'true'){
							$date = date_format(date_create($get_artist_managedGigs_val['gigDate']), 'D, d M y');
							$setUp = date_format(date_create($get_artist_managedGigs_val['setupTime']), 'g:ia');
							$start = date_format(date_create($get_artist_managedGigs_val['startTime']), 'g:ia');
							$end = date_format(date_create($get_artist_managedGigs_val['endTime']), 'g:ia');

							$get_artist_managedGigs[$get_artist_managedGigs_index]['setupTime_formal'] = $date.' @ '.$setUp;
							$get_artist_managedGigs[$get_artist_managedGigs_index]['startTime_formal'] = $date.' @ '.$start;
							$get_artist_managedGigs[$get_artist_managedGigs_index]['endTime_formal'] = $date.' @ '.$end;
						}
						$get_artist_managedGigs[$get_artist_managedGigs_index]['setupTime'] = $get_artist_managedGigs_val['gigDate'] . 'T' . $get_artist_managedGigs_val['setupTime'];
						$get_artist_managedGigs[$get_artist_managedGigs_index]['startTime'] = $get_artist_managedGigs_val['gigDate'] . 'T' . $get_artist_managedGigs_val['startTime'];
						$get_artist_managedGigs[$get_artist_managedGigs_index]['endTime'] = $get_artist_managedGigs_val['gigDate'] . 'T' . $get_artist_managedGigs_val['endTime'];

						
						unset($get_artist_managedGigs[$get_artist_managedGigs_index]['gigDate']);
					}
			}
		/**************************************** END - Get Gig Manager's gigs ****************************************/
	}
	elseif( $u_type == 'church' ){

	}

/* Function to update the index of the events arrays and add additional FullCalendar event's options */
	function arrayUpdate($arrayInput, $type, $urlIn, $owner) {
		$eventCount = count($arrayInput);
		$fullCalOptions = array('id','start','end','title');//,'talent'

		for($i=0;$i<$eventCount;$i++) {
			if($_GET['formatTime'] == 'true'){
				$preList[$i]['setup_formal'] =  $arrayInput[$i]['setupTime_formal']; 
				$preList[$i]['start_formal'] = $arrayInput[$i]['startTime_formal']; 
				$preList[$i]['end_formal'] = $arrayInput[$i]['endTime_formal']; 

				unset( $arrayInput[$i]['setupTime_formal']);
				unset( $arrayInput[$i]['startTime_formal']);
				unset( $arrayInput[$i]['endTime_formal']);
			}
			if($owner){
				unset( $arrayInput[$i]['startTime']);
			}
			else{
				unset( $arrayInput[$i]['setupTime']);
			}

			/* First, Create New Array to be used as the JSON object that is fed to calandarDisplay.php 
				- Combine Index and pertinent array values returned from the database 
			*/
				$finalList[$i] = array_combine($fullCalOptions, $arrayInput[$i]);	

			/* Second, i need to remove elements from the the Output1 array and then add elements URL and ClassName
				- Remove Unwanted array elements 
			*/
					$url = $urlIn; 
					if($type == 'postedGigs'){
						$BC = 'green';
							$url .= $finalList[$i]['id'];
					}
					elseif($type == 'gigMan') {
						$BC = 'yellow';
							$url .= $finalList[$i]['id'];
					}
					else{
						$BC = 'rgba(149,73,173,1)';
						$url .= $finalList[$i]['id'];
					}
					if($_GET['formatTime'] == 'true'){
						$finalList[$i]['setup_formal'] =  $preList[$i]['setup_formal'];
						$finalList[$i]['start_formal'] = $preList[$i]['start_formal'];
						$finalList[$i]['end_formal'] = $preList[$i]['end_formal'];
					}
					$textColor = 'rgba(0,0,0,.7)';
				/* Add Url and ClassName elements */
					$finalList[$i]['url'] = $url; 
					$finalList[$i]['backgroundColor'] = $BC; 
					$finalList[$i]['textColor'] = $textColor; 		
		}
		return $finalList;
	}
/********** END - Function *****************/

if($u_type == 'artist' || $u_type == 'group'){
	$urlIn = 'https://www.gospelscout.com/publicgigads/ad_details.php?g_id=';
	$postedGigs = ( count($get_artitst_postedGigs) == 0 ) ? array() : arrayUpdate($get_artitst_postedGigs, 'postedGigs', $urlIn, $owner); 
	$puwGigs = ( count($get_artitst_puwGigs) == 0 ) ? array() : arrayUpdate($get_artitst_puwGigs, 'puwGigs', $urlIn, $owner); 
	$managedGigs = ( count($get_artist_managedGigs) == 0 ) ? array() : arrayUpdate($get_artist_managedGigs, 'gigMan', $urlIn, $owner); 

	$finalList = array_merge($postedGigs,$puwGigs,$managedGigs);
}
?>