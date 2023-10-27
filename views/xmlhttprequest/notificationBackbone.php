<?php 
	/* Notification Page Server Side */

    /* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	// 1. Update the 'Viewed' status of notifications in the notificationmaster table
	// 2. Query postedgigsmaster table for suggested gigs with current user-specific criteria 
	// 3. When Gig Inquiries is click query giginquirymaster for all inquiries to gigs current artist has posted
 //    4. When Gig Submissions is clicked query gigsubmissionsmaster to retrieve all gigs that current artist has submitted for 

    if($_GET){
    	if($_GET['viewed']){
	    	/* 1. Update the 'Viewed' status of notifications in the notificationmaster table */
	    		$notificationID = intval(trim($_GET['notificationID']));
	    		unset($_GET['notificationID']);
	    		
	    		foreach($_GET as $index => $val){
	    			$field[] = $index;
	    			$value[] = $val;
	    		}
	    		
	    		$cond = 'id = ' . $notificationID;
	    		$table = 'notificationmaster';
	    		
	    		$updateViewed = $obj->update($field,$value,$cond,$table);
	    		var_dump($updateViewed);
    	}
    	elseif($_GET['gigSugg']){
    		/**** Query the suggestedGigs table for the gigID using the iLoginID param ****/	
			   	$_GET['iLoginID'] = trim(intval($_GET['iLoginID']));

				$getSuggGigsQuery = 'SELECT postedgigssuggestionmaster.gigID, postedgigsmaster.gigManLoginId, postedgigsmaster.gigManName, postedgigsmaster.postedDate, usermaster.sUserType
									 FROM postedgigssuggestionmaster
									 INNER JOIN postedgigsmaster on postedgigsmaster.gigId = postedgigssuggestionmaster.gigID
									 INNER JOIN usermaster on usermaster.iLoginID = postedgigsmaster.gigManLoginId
									 WHERE postedgigssuggestionmaster.iLoginID = ?';

				try{
					$getSuggGigs = $db->prepare($getSuggGigsQuery);
					$getSuggGigs->bindParam(1, $_GET['iLoginID']);
					$getSuggGigs->execute();
					$getSuggGigsResults = $getSuggGigs->fetchAll(PDO::FETCH_ASSOC);
				}
				catch(Exception $e){

				}
    		/* END - Query the suggestedGigs table for the gigID using the iLoginID param */	
				
			/**** Display results to be pass back to the notification page ****/
		        if(count($getSuggGigsResults) > 0){
		        	?>
						<h6 class="border-bottom border-gray pb-2 mb-0">Gig Suggestions</h6>
					<?php
		            foreach($getSuggGigsResults as $newNotification){
		          ?>
		                <div class="media text-muted pt-3">
		                  <img src="<?php echo URL; ?>img/gsStickerBig1.png" alt="test" height="40px" width="40px" class="mr-2 rounded">
		                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
		                    <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $newNotification['gigManLoginId'];?>" target="_blank" class="d-block">
		                      <strong class="text-gs text-gray-dark">
		                        <?php 
		                          if($newNotification['sUserType'] == 'group'){
		                             echo $newNotification['sGroupName'];
		                          }
		                          elseif($newNotification['sUserType'] == 'church'){
		                             echo $newNotification['sChurchName'];
		                          }
		                          else{
		                            echo $newNotification['gigManName'];
		                          }
		                        ?>
		                      </strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)"><?php ageFuntion($newNotification['postedDate']);?></span>
		                    </a>
		                    
		                    <?php 
		                      echo 'Has posted a new gig that matches your profile!!! ' . '<a href="'. URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $newNotification['gigID'] . '" class="useBackBone viewSuggestion" notID="' . $newNotification['id'] . '" link="' . $newNotification['link'] . '" class="text-gs"> View</a>';
		                    ?>
		                  </p>
		                </div>
		          <?php 
		              }
		            }
		            else{
		              echo '<div class="container my-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1);padding: 100px 0 100px 0">No New Gig Suggestions!!!</h1></div>';
		            }
			/* END - Display results to be pass back to the notification page */

    	}
    	elseif($_GET['gigInqu']){
    		$_GET['iLoginID'] = trim(intval($_GET['iLoginID']));
    		/**** Query the giginquirymaster table and Inner Join usermaster table on the iLoginID for the iLoginID & gigId using the gigManID param ****/
    			$getGigInqQuery = 'SELECT giginquirymaster.gigId, giginquirymaster.dateTime, giginquirymaster.iLoginID, usermaster.sFirstName, usermaster.sLastName, postedgigsmaster.gigName
								   FROM giginquirymaster
								   INNER JOIN postedgigsmaster on postedgigsmaster.gigId = giginquirymaster.gigId
								   INNER JOIN usermaster on usermaster.iLoginID = giginquirymaster.iLoginID
								   WHERE giginquirymaster.gigManID = ?';

				try{
					$getGigInq = $db->prepare($getGigInqQuery);
					$getGigInq->bindParam(1, $_GET['iLoginID']);
					$getGigInq->execute();
					$getGigInqResults = $getGigInq->fetchAll(PDO::FETCH_ASSOC);
				}
				catch(Exception $e){
					echo $e;
				}
    		/* END - Query the giginquirymaster table and Inner Join usermaster table on the iLoginID for the iLoginID & gigId using the gigManID param */

			/**** Display results to be pass back to the notification page ****/
		        if(count($getGigInqResults) > 0){
		        ?>
					<h6 class="border-bottom border-gray pb-2 mb-0">Gig Inqiries</h6>
				<?php
	            	foreach($getGigInqResults as $newNotification){
	          	?>
		                <div class="media text-muted pt-3">
		                  <img src="<?php echo URL; ?>img/gsStickerBig1.png" alt="test" height="40px" width="40px" class="mr-2 rounded">
		                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
		                    <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $newNotification['iLoginID'];?>" target="_blank" class="d-block">
		                      <strong class="text-gs text-gray-dark">
		                        <?php 
		                          if($newNotification['sUserType'] == 'group'){
		                             echo $newNotification['sGroupName'];
		                          }
		                          elseif($newNotification['sUserType'] == 'church'){
		                             echo $newNotification['sChurchName'];
		                          }
		                          else{
		                            echo $newNotification['sFirstName'] . ' ' . $newNotification['sLastName'];
		                          }
		                        ?>
		                      </strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)"><?php ageFuntion($newNotification['dateTime']);?></span>
		                    </a>
		                    
		                    <?php 
		                      echo 'Has inquired about the gig "' . $newNotification['gigName'] . '".  ' . '<a href="'. URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $newNotification['gigId'] . '" class="useBackBone viewSuggestion" notID="' . $newNotification['id'] . '" link="' . $newNotification['link'] . '" class="text-gs"> View</a>';
		                    ?>
		                  </p>
		                </div>
		          <?php 
		              }
		            }
		            else{
		              echo '<div class="container my-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1);padding: 100px 0 100px 0">No New Gig Inquiries!!!</h1></div>';
		            }
			/* END - Display results to be pass back to the notification page */
    	}
    	elseif($_GET['gigSubm']){
    		
    		$_GET['iLoginID'] = trim(intval($_GET['iLoginID']));

    		/**** Query the giginquirymaster table for the gigId using the iLoginID param ****/
    			$getGigSubmQuery = 'SELECT giginquirymaster.gigId, giginquirymaster.dateTime, postedgigsmaster.gigName, postedgigsmaster.status, postedgigsmaster.selectedArtist,postedgigsmaster.gigDate,postedgigsmaster.setupTime
								   FROM giginquirymaster
								   INNER JOIN postedgigsmaster on postedgigsmaster.gigId = giginquirymaster.gigId
								   WHERE giginquirymaster.iLoginID = ?';

				try{
					$getGigSubm = $db->prepare($getGigSubmQuery);
					$getGigSubm->bindParam(1, $_GET['iLoginID']);
					$getGigSubm->execute();
					$getGigSubmResults = $getGigSubm->fetchAll(PDO::FETCH_ASSOC);
				}
				catch(Exception $e){
					echo $e;
				}
    		/* END - Query the giginquirymaster table for the gigId using the iLoginID param */

    		/**** Display results to be pass back to the notification page ****/
		        if(count($getGigSubmResults) > 0){
		        ?>
					<h6 class="border-bottom border-gray pb-2 mb-0">Gig Inqiries</h6>
				<?php
					$today = date_create(date());
	                $today = date_format($today, 'Y-m-d H:i:s');
	            	foreach($getGigSubmResults as $newNotification){
	          	?>
		                <div class="media text-muted pt-3">
		                  <img src="<?php echo URL; ?>img/gsStickerBig1.png" alt="test" height="40px" width="40px" class="mr-2 rounded">
		                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
		                    <a href="<?php echo URL;?>views/xmlhttprequest/pubGigBackbone.php?id=<?php echo $newNotification['gigId'];?>" target="_blank" class="d-block">
		                      <strong class="text-gs text-gray-dark">
		                        <?php 
		                        	echo $newNotification['gigName'];
		                        ?>
		                      </strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)"><?php ageFuntion($newNotification['dateTime']);?></span>
		                    </a>
		                    
		                    <?php 
			                    $gDate = $newNotification['gigDate'] . ' ' .  $newNotification['setupTime'];
	                            if($gDate < $today){
	                            	$newNotification['status'] = 'Expired';
	                            }
		                      echo 'You have submitted an inquiry about the gig "' . $newNotification['gigName'] . '".  ' . '<a href="'. URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $newNotification['gigId'] . '" class="useBackBone viewSuggestion" notID="' . $newNotification['id'] . '" link="' . $newNotification['link'] . '" class="text-gs"> View</a>';
		                      echo '<br><span class="font-weight-bold">Current Status:</span> ' . $newNotification['status'];
		                      if($newNotification['status'] != 'Expired'){
			                      $selectionStat = '<br><span class="font-weight-bold">Selection Status:</span> ';
			                      if($newNotification['status'] == 'booked'){
				                      if($_GET['iLoginID'] == $newNotification['selectedArtist']){
				                      	$selectionStat .= '<span class="text-gs">Congrats, You have been selected!!!</span>';
				                      }
				                      else{
				                      	$selectionStat .= 'Sorry, You were not selected';
				                      }
				                  }
				                  elseif($newNotification['status'] == 'Pending'){
				                      	$selectionStat .= $newNotification['status'];
				                  }
			                      echo $selectionStat;
			                  }
		                    ?>
		                  </p>
		                </div>
		          <?php 
		              }
		            }
		            else{
		              echo '<div class="container my-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1);padding: 100px 0 100px 0">No New Gig Submissions!!!</h1></div>';
		            }
			/* END - Display results to be pass back to the notification page */
    	}
    }

?>