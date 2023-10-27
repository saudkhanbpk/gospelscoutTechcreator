<?php 

	/* Post public gig backbone */
	
	$backGround = 'bg2';
	$page = 'Posted Gig';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		

		if($_POST){
            foreach($_POST as $columns =>$vals){
                $vals = trim($vals);
                $err = 0; 
                if($vals != ''){
                    if($columns == "gigName" || $columns == "venueName" || $columns == "venueAddress"){
                        /* Remove spaces from name for alpha numeric test */
                        /*    $alphaTest = str_replace(" ","",$vals);

                        if(!ctype_alnum($alphaTest)){
                            $errorMess = '<div class="container text-danger text-center pt-2"><h5>Please Enter Alpha-numeric Characters Only!!!</h5></div>'; 
                            $err += 1;
                        }*/

                    }
                    elseif($columns == "dDOB1"){
                        $vals = intval($vals);
                        if($vals > 0){
                            /* Calculate the min date of birth from the min age given */
                                // $nAge = $dDOB1; 
                                // $dateToday = date_create();
                                // date_sub($dateToday,date_interval_create_from_date_string($nAge . " years"));
                                // $dateToday = date_format($dateToday, 'Y-m-d');
                                // $vals = $dateToday;
                        }
                        else{
                            $errorMess = '<div class="container text-danger text-center pt-2"><h5>Please Enter A Valid Age!!!</h5></div>'; 
                            $err += 1;
                            //exit; 
                        }

                    }
                    elseif($columns == "gigPay"){
                        /* Convert to a float */
                            $vals = floatval(trim($vals));

                        /* Validate user-entered values */
                            if($vals != ''){
                                if(is_float($vals)){ 
                                    if(trim($vals) > 9999.99){
                                        $errorMess = '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please enter a valid number between 1.00 - 9999.99</h5></div>'; 
                                        $err += 1;
                                        //exit; 
                                    }
                                    elseif($vals != 0){
                                        $newCriteriaArray[$index] = $vals;
                                    }
                                }
                                else{
                                    $errorMess = '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please enter a valid number between 1.00 - 9999.99</h5></div>'; 
                                    $err += 1;
                                    //exit; 
                                }
                            }
                    }
                    elseif($columns == "venueZip"){
                        if(strlen(intval($vals)) !== 5) {
                            $errorMess = '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid 5 Digit Zip Code!!!</h5></div>';
                            $err += 1;
                            //exit;
                        } 
                     }
                     elseif($columns == 'gigDate'){

                     }
                     elseif($columns != 'message' && $vals == ''){
                        $errorMess = '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Complete all Fields!!!</h5></div>';
                        $err += 1;
                        //exit;
                     }

                    $post[$columns] = $vals;
                }
            }
        /* END - Validation */



        if($err > 0){
            echo $errorMess; 
            //echo "<script>setTimeout(function(){ window.location.href = 'https://www.gospelscout.com/views/pubGigs.php';},5100);</script>";
            exit; 
        }
        else{
       
            /* Define Gig Id */
                $g_ID = trim($post['gigId']);
                $updateStatus = $post['update'];
                unset($post['update']);

            /**** Change time format of setup, start, and end times ****/
                function changeFormat($time){
                    $newtime = date_create($time);
                    $newtime = date_format($newtime, 'H:i:s');
                    return $newtime; 
                }
                
                $post['setupTime'] = changeFormat($post['setupTime']);
                $post['startTime'] = changeFormat($post['startTime']);
                $post['endTime'] = changeFormat($post['endTime']);
                $post['gigDate'] .= ' ' . $post['setupTime']; 
            /* END - Change time format of setup, start, and end times */

            /**** Add Date/Time stamp ****/
                $hoy = date_create();
                $hoy = date_format($hoy, 'Y-m-d H:i:s');

                $post['postedDate'] = $hoy;
            /* END - Add Date/Time stamp */


            /**** Create field and value variables for the the insert function ****/
                foreach ($post as $index => $val) {
                    $field[] = $index;
                    $value[] = $val;
                }
            /* END -  Create field and value variables for the the insert function */

            $table = 'postedgigsmaster';
		
            if($updateStatus){
                $post['lastEdited'] = $post['postedDate']; 
                unset($post['postedDate']);

                $cond = 'gigId = ' . '"' . $g_ID . '"';
                /* PDO Update Statement */
                $columuns = '';
                $count = count($post);
                $j = 1; 
                foreach($post as $index1 => $value1){
                    if($j == $count){
                        $columuns .= $index1 . ' = "' . $value1 . '"';
                    }
                    else{
                        $columuns .= $index1 . ' = "' . $value1 . '", '; 
                    }
                    $j++;
                }
                $query = 'UPDATE ' . $table . ' SET ' . $columuns . ' WHERE ' . $cond;

                try{
                    $updatePostedGig = $db->prepare($query);
                    $updateSucc = $updatePostedGig->execute(); 
                }
                catch(Exception $e){
                    echo $e; 
                }
            }
            else{
                $postGig = $obj->insert($field,$value,$table); 
            }

            /* After successful insertion fetch post gig data */
                if(($postGig && $postGig > 0) || $updateSucc){
                    if($updateSucc){
                        /*************** Find Matching Artists for gig suggestions ***************/
                            $matchingArtists = findArtistMatch($db, $obj, $post);
                        /************ END - Find Matching Artists for gig suggestions ************/

                        $tableArray = array('suggestedgigs', 'giginquirymaster');
                        foreach($tableArray as $indivTable){
                            /* Query the suggested gigs table for artists already sent suggestions for this gig */
                                try{
                                    $querySuggArtistsQuery = 'SELECT iLoginID FROM ' . $indivTable . ' WHERE gigID = ?';
                                    $querySuggArtists = $db->prepare($querySuggArtistsQuery);
                                    $querySuggArtists->bindParam(1, $g_ID);
                                    $querySuggArtists->execute(); 
                                    $querySuggArtistsResults = $querySuggArtists->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    if(count($querySuggArtistsResults) > 0){
                                        $querySuggArtistsResults2[] = $querySuggArtistsResults;
                                    }
                                }
                                catch(Exception $e){
                                    echo $e; 
                                }
                        }

                        /**** Merge the two arrays 1. suggestedgigs table and 2. giginquirymaster table results ****/
                            if(count($querySuggArtistsResults2) > 1){
                                $querySuggArtistsResults = array_merge($querySuggArtistsResults2[0],$querySuggArtistsResults2[1]);
                            }
                            else{
                                 $querySuggArtistsResults = $querySuggArtistsResults2[0];
                            }
                        /* END - Merge the two arrays 1. suggestedgigs table and 2. giginquirymaster table results */


                        /* Send gig update notifications to artists who are in the suggested gigs table for this gig */
                            $action = 'updatedGig';  
                            $notifier = $currentUserID;  
                            $link = $g_ID;
                            foreach ($querySuggArtistsResults as $key => $value) {
                                $notified = $value['iLoginID'];  
                                $updateNotSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);
                            }

                        /* Send suggested gig notifications to artists who aren't in the suggested gigs table for this gig */
                            if(($matchingArtists && count($matchingArtists) > 0) && count($querySuggArtistsResults) > 0){
                                $newSuggArtist = $matchingArtists;
                                foreach($matchingArtists as $matchIndex => $artistMatch){
                                    foreach($querySuggArtistsResults as $artistSugg){
                                        if($artistMatch['iLoginID'] == $artistSugg['iLoginID']){
                                            /* If iLoginID matches, then remove the iLoginID from the $artistMatch array */
                                                unset($newSuggArtist[$matchIndex]);
                                        }
                                    }   
                                }
                            
                                if(count($newSuggArtist) > 0){
                                    /**** Call Function to check if the Gig meets the suggested artist's distance requirement ****/
                                        $originArray = $newSuggArtist;
                                        $destinationArray = array($post['venueAddress'] . ', ' . $post['venueCity'] . ', ' . $post['venueStateShort'] . ', ' . $post['venueZip']);
                                        $getDistDur = findDist($originArray, $destinationArray);
                                        
                                        $distReqCount = count($getDistDur);
                                        for($m=0;$m<$distReqCount;$m++){
                                            if(!$getDistDur[$m]['distReqMet']){
                                                unset($getDistDur[$m]);
                                            }
                                        }
                                        $newSuggArtist = $getDistDur;
                                    /* END - Call Function to check if the Gig meets the suggested artist's distance requirement */

                                    $action = 'suggestGig';  
                                    $notifier = $currentUserID;  
                                    $link = $g_ID;
                                    foreach($newSuggArtist as $artSuggNew){
                                        /* Unset Un-needed elements */
                                            unset($artSuggNew['iZipcode']);
                                            unset($artSuggNew['maxTravDistance']);
                                            unset($artSuggNew['distReqMet']);
                                            unset($artSuggNew['dist']);
                                            unset($artSuggNew['dur']);
                                            
                                        /* Add the gig id to each artist's array */
                                            $artSuggNew['gigID'] = $g_ID; 
                                            $artSuggNew['gigDate'] = $post['gigDate']; 
                                        
                                        /* Reset the field and value array after each loop */
                                            $field = array();
                                            $value = array(); 

                                        /* Insert values into the field and value array for table insertion */
                                            foreach($artSuggNew as $key1 => $val1) {
                                                $field[] = $key1;
                                                $value[] = $val1;
                                            }
                                        /* Insert into the suggestgigs table */
                                            $suggGigTable = 'suggestedgigs';
                                            $insertSuccess = $obj->insert($field,$value,$suggGigTable);

                                        /* If suggestedgigs table is updated successfully, Insert into the notification table */
                                            if($insertSuccess > 0){
                                                $notified = $artSuggNew['iLoginID'];
                                                $suggGigNotSucc = createNotification($db, $obj, $action, $notifier, $notified, $link);
                                            }
                                    }
                                }
                            }   

                    }
                    else{
                        /*************** Find Matching Artists for gig suggestions ***************/
                            $matchingArtists = findArtistMatch($db, $obj, $post);
                        /************ END - Find Matching Artists for gig suggestions ************/
				
                        if(count($matchingArtists) > 0){
	                        /**** Call Function to check if the Gig meets the suggested artist's distance requirement ****/
	                            $originArray = $matchingArtists;
	                            $destinationArray = array($post['venueAddress'] . ', ' . $post['venueCity'] . ', ' . $post['venueStateShort'] . ', ' . $post['venueZip']);
	                            $getDistDur = findDist($originArray, $destinationArray);
	                            
	                            $distReqCount = count($getDistDur);
	                            for($m=0;$m<$distReqCount;$m++){
	                                if(!$getDistDur[$m]['distReqMet']){
	                                    unset($getDistDur[$m]);
	                                }
	                            }
	                            $matchingArtists = $getDistDur;
	                        /* END - Call Function to check if the Gig meets the suggested artist's distance requirement */


				/* Insert the matching artists into the suggested gigs table */
					if(count($matchingArtists) > 0){
						foreach($matchingArtists as $val) {
							/* Unset Un-needed elements */
								unset($val['iZipcode']);
								unset($val['maxTravDistance']);
								unset($val['distReqMet']);
								unset($val['dist']);
								unset($val['dur']);
							
							/* Calculate max travel distance - Calculate distance between two zip codes   , usermaster.maxTravDistance*/
								$zip1 = $gigInfo['dDOB1'];
							
							/* Add the gig id to each artist's array */
								$val['gigID'] = $post['gigId']; 
								$val['gigDate'] = $post['gigDate']; 
							
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
								$insertSuccess = $obj->insert($field,$value,$table);
							
							/* If suggestedgigs table is updated successfully insert into notificationmaster table */    
								if($insertSuccess > 0){
								    $action = 'suggestGig';
								    $notifier = $post['gigManLoginId'];
								    $notified = $val['iLoginID'];
								    $link = $val['gigID'];
								    $succNotInsert = createNotification($db, $obj, $action, $notifier, $notified, $link);
								}
						}
				}
                        }
                    }
                    
?>  
                    <script> 
                        window.location.href = 'https://www.gospelscout.com/views/xmlhttprequest/pubGigBackbone.php?id=<?php echo $g_ID;?>';
                    </script>
<?php
                }
        }
	}
	elseif($_GET['id']){
		/* query the postedgigsmaster table for the gig associated with the id passed in the $_GET var , usermaster. sUserType INNER JOIN usermaster.iLoginID = postedgigsmaster.gigManLoginId*/
                $g_ID = trim($_GET['id']);

                if(ctype_alnum($g_ID)){

                    $query = 'SELECT postedgigsmaster.*
                              FROM postedgigsmaster 
                              WHERE gigId = ?';
                    try{
                        $getPost = $db->prepare($query);
                        $getPost->bindParam(1, $g_ID);
                        $getPost->execute();
                        $getPostedGig = $getPost->fetch(PDO::FETCH_ASSOC);
                    }
                    catch(Exception $e){
                        echo $e; 
                    }

                    if(count($getPostedGig) == 0){
                        echo '<script> window.location.href = "https://www.gospelscout.com/views/manageGigs1.php"</script>';
                    }
                    else{
                        /* Determine if Gig requires a solo artist or group */
                            if($getPostedGig['userType'] == 'group'){
                                /* Query the the grouptypemaster table */
                                    try{
                                        $fetchGroupTypes = $db->query('SELECT grouptypemaster.sTypeName FROM grouptypemaster'); 
                                        $groupTypeList = $fetchGroupTypes->fetch(PDO::FETCH_ASSOC);
                                    }
                                    catch(Exception $e){
                                        echo $e;
                                    }
                                    $getPostedGig['talentType'] = $groupTypeList['sTypeName'];
                            }
                            elseif($getPostedGig['userType'] == 'artist'){
                                /* Query the the giftmaster table */
                                    try{
                                        $fetchTalents = $db->prepare('SELECT giftmaster.sGiftName FROM giftmaster WHERE giftmaster.iGiftID = ?'); 
                                        $fetchTalents->bindParam(1,$getPostedGig['artistType']);
                                        $fetchTalents->execute();
                                        $talentList = $fetchTalents->fetch(PDO::FETCH_ASSOC);
                                    }
                                    catch(Exception $e){
                                        echo $e;
                                    }
                                    $getPostedGig['talentType'] = $talentList['sGiftName'];
                            }
                        /* END - Determine if Gig requires a solo artist or group */

                        /* Query the gigsinquirymaster table */
                            $query1 = 'SELECT giginquirymaster.iLoginID,giginquirymaster.dateTime,giginquirymaster.comments, usermaster.sFirstName, usermaster.sLastName, usermaster.dDOB, usermaster.sCityName, states.statecode
                                       FROM giginquirymaster 
                                       INNER JOIN usermaster on usermaster.iLoginID = giginquirymaster.iLoginID
                                       INNER JOIN states on usermaster.sStateName = states.id
                                       WHERE giginquirymaster.gigId = ?';
                            try{
                                $getInquiries = $db->prepare($query1);
                                $getInquiries->bindParam(1, $g_ID);
                                $getInquiries->execute();
                                $getInquiriesResults = $getInquiries->fetchAll(PDO::FETCH_ASSOC);
                            }
                            catch(Exception $e){
                                echo $e; 
                            }
                    }

                    /* Is user logged in - if so, from what perspective */
                        if($currentUserID){
                            /* Is user the gig manager or artist */
                                if($currentUserID == $getPostedGig['gigManLoginId']){
                                    $user = 'manager';
                                }
                                elseif($currentUserType == 'church' || $currentUserType == 'user'){
                                    /* Redirect user to search 4 artist page */
                                        echo '<script> window.location.href = "https://www.gospelscout.com/views/search4artistNew.php"</script>';
                                }
                                else{
                                    /* Determine if the artist or group submitted an inquiry */
                                        if(count($getInquiriesResults) > 0){
                                            foreach ($getInquiriesResults as $key01 => $value01) {
                                                if($currentUserID == $value01['iLoginID']){
                                                    if($getPostedGig['selectedArtist'] == $currentUserID){
                                                        $user = 'artistSelected';
                                                    }
                                                    else{
                                                        $user = 'artistSubmitted';
                                                    }
                                                    $myInfo = $value01;
                                                    break;
                                                }
                                                else{
                                                    $user = 'artistNotSubmited';
                                                }
                                            }
                                        }
                                        else{
                                            $user = 'artistNotSubmited';
                                        }
                                }

                        }
                        else{
                            /* Re-direct user */
                                echo '<script> window.location.href = "https://www.gospelscout.com/views/search4artistNew.php"</script>';

                        }
                }
                else{
                    echo "<script> window.location.href = 'https://www.gospelscout.com/views/manageGigs1.php'</script>";
                }
	}

    /* make gig id accessible to the javascript */
        echo '<input type="hidden" name="gigID" value="' . $g_ID . '">';
        echo '<input type="hidden" name="selA" value="' . $getPostedGig['selectedArtist'] . '">';

?>
<head>
	<style>
		#showArtDeet th{
			width: 150px;
		}
		.showTals  {
			width: 10px;
		}
        tr.showing {
            background-color: rgba(149,73,173,.5);
        }
	</style>
</head>
<?php 
    /* Determine if Post is publiclly viewable or not */
        /* today's date */
            $g_Date = $getPostedGig['gigDate'];
            $today = date_create(date());
            $today = date_format($today, 'Y-m-d H:i:s');
            
        if($g_Date < $today){
            $showPStatus = 'Post Expired';
        }
        elseif($getPostedGig['isPostedStatus'] == '1'){
            $hideStatID = 'hideGigPost';
            $hideStatButt = 'Hide Gig Post';
            $showPStatus = 'Post Viewable';
        }
        else{
            $hideStatID = 'unhideGigPost';
            $hideStatButt = 'Un-Hide Gig Post';
            $showPStatus = 'Post Hidden';
        }
?>
<div class="container mt-3 mt-lg-5 mx-auto px-lg-5">
	<div class="row mx-1 mx-md-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <div class="card ">
                <h5 class="card-header">Gig Info - <span class="showPStatus"><?php echo $showPStatus;?></sapn></h5>
                <!-- Artist's profile pic -->
                    <div class="container text-center text-md-left pl-md-4 mt-2">
                    	<div class="row pl-4 pt-2">
                    		<div class="col text-left">
                        		<h5 class="text-gs">Total Pay: $<?php echo $getPostedGig['gigPay'];?></h5>                    			
                    		</div>  
                    	</div>
                        <div class="row pl-4 pt-2">
                            <div class="col text-left">
                                <h6 style="font-size: 14px;">Post Id: <?php echo $getPostedGig['gigId'];?></h6>                             
                            </div>
                        </div>
                         <div class="row pl-4 pt-2">
                            <div class="col text-left">
                                <h6 style="font-size: 14px;">Posted: <?php ageFuntion($getPostedGig['postedDate']);?></h6>                             
                            </div>
                        </div>
                    </div>
                <!-- /Artist's profile pic -->
                <div class="card-body">
                    <div class="container" style="font-size: 14px;">
                        <div class="row" style="font-size: 14px;">
                            <div class="col-12 col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Gig Name:</th>
                                            <td><?php echo $getPostedGig['gigName'];?></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                                $gDate = date_create($getPostedGig['gigDate']);
                                                $gDate = date_format($gDate, "D M d, Y"); 
                                            ?>
                                            <th scope="row">Gig Date: </th>
                                            <td><?php echo $gDate;?></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                                $sUpTime = date_create($getPostedGig['setupTime']);
                                                $sUpTime = date_format($sUpTime, "h:ia"); 
                                            ?>
                                            <th scope="row">Set Up Time: </th>
                                            <td><?php echo $sUpTime; ?></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                                $strtTime = date_create($getPostedGig['startTime']);
                                                $strtTime = date_format($strtTime, "h:ia"); 
                                            ?>
                                            <th scope="row">Start Time: </th>
                                            <td><?php echo $strtTime;?></td>
                                        </tr>
                                         <tr>
                                            <?php 
                                                $eTime = date_create($getPostedGig['endTime']);
                                                $eTime = date_format($eTime, "h:ia"); 
                                            ?>
                                            <th scope="row">End Time: </th>
                                            <td><?php echo $eTime;?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Talent Needed:</th>
                                            <td><?php echo str_replace("_", "/",$getPostedGig['talentType']);?></td>
                                        </tr>
                                         <tr>
                                            <th scope="row">Gender:</th>
                                            <td>
                                                <?php 
                                                    if($getPostedGig['sGender'] == 'both'){
                                                        echo 'Male or Female';
                                                    }
                                                    else{
                                                         echo $getPostedGig['sGender'];
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Min Age: </th>
                                            <td>
                                                <?php 
                                                    echo $getPostedGig['dDOB1']; 
                                                ?>
                                            </td>
                                        </tr>
                                    	<tr>
                                            <th scope="row">Gig Type: </th>
                                            <td><?php echo $getPostedGig['gigType'];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Privacy: </th>
                                            <td>
                                                <?php 
                                                    if($getPostedGig['gigPrivacy'] == 'pub'){
                                                        echo 'Public';
                                                    }
                                                    else{
                                                        echo 'Private';
                                                    }

                                                ?>
                                            </td>
                                        </tr>
                                        <?php if($user == 'manager' || $user == 'artistSubmitted'){?>
                                            <tr>
                                                <th scope="row">Venue Name: </th>
                                                <td><?php echo $getPostedGig['venueName'];?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Venue Address: </th>
                                                <td><?php echo $getPostedGig['venueAddress'] . '<br>' . $getPostedGig['venueCity'] . ', ' . $getPostedGig['venueStateShort'] .' ' . $getPostedGig['venueZip'];?></td>
                                            </tr>
                                        <?php }?>
                                         <tr>
                                            <th scope="row">Environment: </th>
                                            <td><?php echo $getPostedGig['venueEnvironment'];?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($user == 'manager' || $user == 'artistSubmitted'){?>
                        	<?php// echo URL . 'views/artistprofile.php?artist=' . $getPostedGig['gigManLoginId'];?>
                            <div class="row my-3">
                                <div class="col col-md-7">
                                    <h5>Point of Contact: </h5>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th>Name:</th>
                                                <td><?php echo $getPostedGig['gigManName'];?></td> 
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>
                                                    <a href="#" class="text-gs" data-toggl="popover" data-placement="top" title="Email:" data-content="<?php echo $getPostedGig['gigManEmail'];?>">
                                                        <?php 
                                                            $email_truncated = truncateStr($getPostedGig['gigManEmail'], 15);
                                                            echo $email_truncated;
                                                        ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Phone:</th>
                                                <td>
                                                    <?php 
                                                        if($getPostedGig['gigManPhone'] != '') {
                                                            /* The substr_replace() method is used to insert '-' into the phone numbers to make them more */
                                                                $artistContact = $getPostedGig['gigManPhone'];
                                                                $artistContact1 = substr_replace($artistContact, '-', 3, 0);
                                                                $artistContact2 = substr_replace($artistContact1, '-', 7, 0);
                                                                echo $artistContact2;
                                                        }
                                                        else{
                                                            echo 'N/A';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                            <div class="row my-3">
                            	<div class="col col-md-7">
                            		<h5>Additional Requests: </h5>
                            		<div class="container">
                            			<p><?php echo $getPostedGig['message'];?></p>
                            		</div>
                            	</div>
                            </div>
                        <?php 
                        }
                            
                            if($user == 'manager' && $g_Date > $today){
                        ?>
                            <!-- Edit, hide, delete Post (show if gig date has not passed.) -->
				                <a class="btn btn-small btn-gs text-white" href="<?php echo URL;?>views/pubGigs.php?gigID=<?php echo $g_ID;?>" id="postGig">Edit Post</a> 
                            
                            <?php if(is_null($getPostedGig['selectedArtist']) || $getPostedGig['selectedArtist'] == 0){?>
                                <!-- Display the show or hide post button depedning on if the post is currently showing on the posted gigs page -->
                                    <a class="btn btn-small btn-gs text-white getStatus" href="#" gigManID="<?php echo $currentUserID;?>" postID="<?php echo $g_ID;?>" id="<?php echo $hideStatID;?>"><?php echo $hideStatButt;?></a> 
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-lg-3 px-lg-5">
    <div class="row mx-1 mx-md-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <div class="card ">
               
                 <?php if($user == 'manager'){?>
                <!-- For Gig manager only -->
                    <h5 class="card-header">Gig Inquiries (<span class="text-gs font-weight-normal" style="font-size:16px"><?php echo count($getInquiriesResults);?></span>)</h5>
                    <div class="card-body">
                        <div class="container">
                            <?php 
                                if(count($getInquiriesResults) > 0){
                            ?>
                                <div class="row mb-3">
                                    <div class="col col-md-6" style="font-size: 13px;">
                                        <table class="table">
                                            <tbody>
                                            	<thead>
                                            		<tr>
                                            			<th>Name</th>
                                            			<th>City</th>
                                            			<th>Age</th>
                                            			<th></th>
                                            		</tr>
                                            	</thead>
                                                <?php 
                                                    if(count($getInquiriesResults) > 0){
                                                        foreach($getInquiriesResults as $ind => $artistInq){
                                                ?>
                                                            <tr class= "artistRow <?php if($ind == 0){echo 'showing';}?>">
                                                                <td><?php echo $artistInq['sFirstName'] . ' ' . $artistInq['sLastName'];?></td>
                                                                <td><?php echo $artistInq['sCityName'] . ', ' . $artistInq['statecode'];?></td>
                                                                <td>
                                                                    <?php
                                                                        /* Calculate member age from their DOB */
                                                                            $from = new DateTime($artistInq['dDOB']);
                                                                            $to   = new DateTime('today');
                                                                            $artistAge = $from->diff($to)->y;
                                                                            echo $artistAge;
                                                                        /* END - Calculate member age from their DOB */
                                                                    ?>
                                                                </td>
                                                                <td><a class="text-gs getArtistDeets" href="#" id="<?php echo $ind;?>" iLoginID="<?php echo $artistInq['iLoginID'];?>">view more</a></td>
                                                            </tr>
                                                <?php 
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col col-md-6 p-2 p-lg-3 d-none d-md-block" style="border: 1px solid rgba(149,73,173,1);box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);">
                                    	<div class="mb-2">
                                            <a class="artistProfile" href="#" target="_blank" style="text-decoration: none; ">
            	                        		<img class="aProfPic profPic" src="" height="50px" width="50px">
            	                            	<h3 class="d-inline-block text-gs fullName" id=" fullName"></h3>
                                            </a>
        	                            </div>
                                        <table class="table table-borderless" id="showArtDeet" style="font-size:12px">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Submitted: </th>
                                                    <td class="submissionDateTime"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Location: </th>
                                                    <td class="location"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Age: </th>
                                                    <td class="age"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Talent(s): </th>
                                                    <td>
                                                    	<table class="table table-borderless showTals">
                                                    		<tbody class="tals"></tbody>
                                                    	</table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email: </th>
                                                    <td class="email"></td>
                                                </tr>
                                                 <tr>
                                                    <th scope="row">Phone #: </th>
                                                    <td class="phone"></td>
                                                </tr>
                                                 <tr>
                                                    <th scope="row">Comments: </th>
                                                    <td class="comments"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <?php if($g_Date >= $today){?>
                                            <div class="d-none manAction">
                                                <!-- selectArtist -->
                                                <button type="button" class="btn btn-sm btn-gs sendID" artistID=""  id="selectArtist" data-toggle="modal" data-target="#chooseArtist">Select This Artist</button>
                                            </div>
                                            <div class="d-none manAction2">
                                                <h4 class="font-weight-bold text-gs">Artist Selected</h4>
                                                <button type="button" class="btn btn-sm btn-gs sendID" artistID="" id="deSelectArtist" data-toggle="modal" data-target="#loseArtist">De-Select This Artist</button>
                                            </div>
                                        <?php }?>

                                        <!--
                                            1. gig manager selects artist for gig
                                            2. status & selectedArtists values change
                                                a. status: Artist Selected 
                                                b. selectedArtists: [selected artist iLoginID]
                                            3. notification message is sent to the selected artist
                                            4. in the gig submission section return the status and selectedArtist column 
                                                a. create conditional statement 
                                                    i. pending
                                                    ii.  An Artist has been selected 
                                                    iii. You have been selected!!!
                                            5. Remove from posted gigs page
                                            6. Replace the "edit post" button with a "repost" button
                                            7. Repost button will take you back to the posted gig form
                                                a. if gig date has passed, require and update(MAKE GIG DATE HAS TO BE A FUTURE DATE IN GENEREAL!!!!)
                                            8. Replace the "UPDATE post" button with a "repost" button on the posted gigs page
                                        -->
                                    </div>
                                </div>

                                <!-- Modal to display artists on small screen -->
                                    <div class="d-md-none modal" id="show-artist-sm" tabindex="-1" role="dialog" aria-labelledby="show-artist-sm" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                               <a class="artistProfile" href="#" target="_blank" style="text-decoration: none; ">
                                                    <img class="aProfPic profPic" src="" height="50px" width="50px">
                                                    <h4 class="d-inline-block text-gs fullName ml-1"></h4>
                                                </a>
                                              <span id="loadlogin"></span> 
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>

                                            <div class="modal-body px-4" id="showArtist-sm">
                                                <table class="table table-borderless" id="showArtDeet" style="font-size:12px">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Submitted: </th>
                                                            <td class="submissionDateTime"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Location: </th>
                                                            <td class="location"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Age: </th>
                                                            <td class="age"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Talent(s): </th>
                                                            <td>
                                                                <table class="table table-borderless showTals">
                                                                    <tbody class="tals"></tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email: </th>
                                                            <td class="email"></td>
                                                        </tr>
                                                         <tr>
                                                            <th scope="row">Phone #: </th>
                                                            <td class="phone"></td>
                                                        </tr>
                                                         <tr>
                                                            <th scope="row">Comments: </th>
                                                            <td class="comments"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <?php if($g_Date >= $today){?>
                                                    <div class="d-none manAction">
                                                        <!-- selectArtist -->
                                                        <button type="button" class="btn btn-sm btn-gs sendID" artistID=""  id="selectArtist" data-toggle="modal" data-target="#chooseArtist">Select This Artist</button>
                                                    </div>
                                                    <div class="d-none manAction2">
                                                        <h4 class="font-weight-bold text-gs">Artist Selected</h4>
                                                        <button type="button" class="btn btn-sm btn-gs sendID" artistID="" id="deSelectArtist" data-toggle="modal" data-target="#loseArtist">De-Select This Artist</button>
                                                    </div>
                                                <?php }?>
                                            </div>

                                              <!-- Modal Footer -->
                                                <div class="modal-footer px-4" style="font-size:13px">
                                                  <div class="checkbox container p-0" id="postDisplay-sm"> 
                                                   
                                                  </div>
                                                </div>
                                                <!-- /Modal Footer -->
                                           </div>
                                        </div>
                                    </div>
                                <!-- /Modal to display artists on small screen -->
                            <?php 
                                }
                                else{
                                    echo '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-5"><div class="col p-lg-5"><h2 class="" style="color: rgba(204,204,204,1)">No Artists Have Submitted Inquiries for this Gig!!!</h2></div></div></div>';
                                }
                            ?>
                        </div>
                    </div>
                <!-- /For Gig manager only -->

                <?php }else{
                        /*
                            check for the following 
                            1. $retrieveCustomer['total_count'] <= 0
                            2. $retrieveCustomer['default_source'] == null
                            3. $retrieveCustomer['delinquent'] == false
                            4. $retrieveCustomer['metadata']['user_ID'] == $currentUserID
                            5. $retrieveCustomer['sources']['total_count'] == 0; 
                            6. $userinfo['str_customerID'] = $retrieveCustomer['id']
                        */

                ?>
                    <h5 class="card-header">Submit an Inquiry</h5>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Posted Gig's Status:</th>
                                                <td class="text-gs">
                                                    <?php 
                                                        if($getPostedGig['selectedArtist']){

                                                        }
                                                        echo $getPostedGig['status'];
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Inquiry Submitted:</th>
                                                <td class="text-gs">
                                                    <?php if($user == 'artistNotSubmited'){
                                                                echo 'NO';
                                                           }else{
                                                                $submitTIme = date_create($myInfo['dateTime']);
                                                                $submitTIme = date_format($submitTIme, 'M d, Y @ h:ia');
                                                                echo $submitTIme;
                                                          }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-md-6 p-3" style="border: 1px solid rgba(149,73,173,1);box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);">
                                    <div class="mb-2">
                                        <a id="artistProfile" href="#" target="_blank" style="text-decoration: none; ">
                                            <img class="aProfPic" src="<?php echo $userInfo['sProfileName'];?>" id="profPic" height="50px" width="50px">
                                            <h3 class="d-inline-block text-gs"><?php echo $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];?></h3>
                                        </a>
                                    </div>
                                    <table class="table table-borderless" id="showArtDeet" style="font-size:12px">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Age: </th>
                                                <td><?php echo getAge($userInfo['dDOB']);?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Location: </th>
                                                <td><?php
                                                        $state = $obj->fetchRow('states',"id = ".$userInfo['sStateName']);
                                                        echo ucfirst($userInfo['sCityName']) . ', ' . $state['statecode'] . ' ' . $userInfo['iZipcode'];
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Talent(s): </th>
                                                <td>
                                                    <table class="showTals">
                                                        <tbody class="tals">
                                                            <?php 
                                                                $talents = $obj->fetchRowAll('talentmaster',"iLoginID = ".$userInfo['iLoginID']);
                                                                foreach($talents as $indNumb => $tal){?>
                                                                    <tr>
                                                                        <th><?php echo $indNumb + 1;?></th>
                                                                        <td>
                                                                            <?php 
                                                                                $talent_truncated = truncateStr($tal['talent'], 15);
                                                                                echo str_replace('_', '/', $talent_truncated);
                                                                            ?>
                                                                        </td>
                                                                    </tr>

                                                            <?php }?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email: </th>
                                                <td>
                                                    <a href="#" class="text-gs" data-toggl="popover" data-placement="top" title="Email:" data-content="<?php echo $userInfo['sContactEmailID'];?>">
                                                        <?php 
                                                            $email_truncated = truncateStr($userInfo['sContactEmailID'], 15);
                                                            echo $email_truncated;
                                                        ?>
                                                    </a>
                                                </td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Phone #: </th>
                                                <td>
                                                    <?php 
                                                        /* The substr_replace() method is used to insert '-' into the phone numbers to make them more */
                                                            $currentArtistContact = $userInfo['sContactNumber'];
                                                            $currentArtistContact1 = substr_replace($currentArtistContact, '-', 3, 0);
                                                            $currentArtistContact2 = substr_replace($currentArtistContact1, '-', 7, 0);
                                                            echo $currentArtistContact2;
                                                    ?>
                                                </td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Comments: </th>
                                                <td>
                                                    <form name="inquiryForm" type="post">

                                                        <input type="hidden" name="gigId" value="<?php echo $g_ID;?>">
                                                        <input type="hidden" name="gigManID" value="<?php echo $getPostedGig['gigManLoginId'];?>"><!-- will remove this at some point; its redundant-->
                                                        <input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
                                                        <?php if($user == 'artistNotSubmited' && $g_Date > $today){?>
                                                            <textarea class="form-control mb-2" style="font-size:12px;" name="comments" placeholder="Alt forms of contact, additional skills, etc..." wrap="" rows="5" aria-label="With textarea"></textarea>
                                                        <?php }else{
                                                                if($myInfo['comments'] == ''){
                                                                    echo 'N/A';
                                                                }
                                                                else{
                                                                    echo $myInfo['comments'];  
                                                                }

                                                                if($user == 'artistSelected'){
                                                                    echo '<input type="hidden" name="selectedArtist" value="true">';
                                                                }
                                                            }
                                                        ?>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                        if($g_Date > $today) {
                                            if($user == 'artistNotSubmited'){?>
                                                <!-- artistAction -->
                                                    <button type="button" data-toggle="modal" data-target="" class="btn btn-sm btn-gs artistAction" id="submitInquiry">I Want To Play!</button><!-- artistAction submitInquiry-->
                                    <?php   }else{
                                    ?>
                                                <button type="button" class="btn btn-sm btn-gs" data-toggle="modal" data-target="#withdrawalWarning" >Withdraw My Submission</button>
                                    <?php   }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<!-- Modal to confirm the selection of an artist -->
    <div class="modal fade" id="chooseArtist" tabindex="-1" role="dialog" aria-labelledby="chooseArtist" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Artist</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <p id="modalMessage"></p>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs selectArtist" id="selectThisArtist" sel-u-id="" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm the selection of an artist -->

<!-- Modal to confirm the DE-selection of an artist -->
    <div class="modal fade" id="loseArtist" tabindex="-1" role="dialog" aria-labelledby="loseArtist" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">De-Select Artist</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vidTalent">Reason For De-selecting artist</label>
                        <textarea class="form-control mb-2" name="de-selectReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                        <input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
                        <input type="hidden" name="gigDetails_gigStatus" value="cancelled">
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs selectArtist" id="deselectThisArtist" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm the DE-selection of an artist -->

<!-- Modal introduce the payment modal and collect payment information -->
    <div class="modal fade" id="bidToGig" tabindex="-1" role="dialog" aria-labelledby="bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Bid To Gig</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- style the stripe form -->
                <style>
                    /**
                    * The CSS shown here will not be introduced in the Quickstart guide, but shows
                    * how you can use CSS to style your Element's container
                    */
                    .StripeElement {
                        box-sizing: border-box;

                        height: 40px;
                        color: blue;
                        padding: 10px 12px;
                        display: block;
                        border: 1px solid transparent;
                        border-radius: 4px;
                        background-color: white;

                        box-shadow: 2px 1px 3px 2px #d2d7dd;// e6ebf1
                        -webkit-transition: box-shadow 150ms ease;
                        transition: box-shadow 150ms ease;
                    }

                    .StripeElement--focus {
                        box-shadow: 0 1px 3px 0 #cfd7df;
                    }

                    .StripeElement--invalid {
                        border-color: #fa755a;
                    }

                    .StripeElement--webkit-autofill {
                        background-color: #fefde5 !important;
                    }
                    ul {
                        list-style: none;
                    }
                    li {
                        font-size: 12px;
                    }
                </style>

            <!-- Modal Body -->
                <div class="modal-body mt-0">   
                    <!-- Carousel this div with 2 slides: 1. to introduce the pricing model, 2.  to collect card info for tokenization -->
                    <div id="carouselExampleIndicators" class="carousel mb-0"  data-interval="false" style="max-height:350px" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item bg-white active" style="max-height:325px;overflow:hidden;overflow:scroll">
                                <div class="container">
                                     <div class="row mb-1">
                                        <div class="col text-center">
                                            <h5>How it Works!!!</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <h6>Your first <span class="font-weight-bold text-gs">MONTH</span> of bidding is on us!!!</h6>
                                            <p class="pl-2" style="font-size:12px"> From the date and time that you create your profile, you will have 30 days of free bidding so go nuts!!!  After that, we'll be watching.</p>
                                            <h6>Only pay for what you use!!!</h6>
                                            <p class="pl-2" style="font-size:12px"> You are never charged for having an account with us.  You only pay for what you use.  We track your usage through out the month and add up your total usage at the end of your billing cycle. Keep in mind, the more you bid, the cheaper it is.  Check out our pricing below.</p>
                                            <h6>The more you bid the cheaper it is!!!</h6>
                                            <ul class="pl-2">
                                                <li>1-5 Bids/month: $3.50/bid</li>
                                                <li>6-10 Bids/month: $2.50/bid</li>
                                                <li>11+ Bids/month: $1.00/bid</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item mt-0 pt-1 bg-white" style="max-height:325px">
                                <div class="container mt-0">
                                    <div class="row mb-1">
                                        <div class="col text-center">
                                             <h5>Payment Info</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size:12px">Enter card info here.  Your card info is securely transmitted and stored using our stripe api interface.  <span class="font-weight-bold">Once you enter your card info the first time you don't have to enter it again.</span></p>
                                        </div>
                                    </div>
                                    <form class="" action="<?php echo URL;?>views/xmlhttprequest/stripeApiTest.php" method="post" id="payment-form">
                                        <div class="form-row">
                                            <div class="container pb-1">
                                                <p class="mb-0">Credit or debit card</p>
                                            </div>
                                            <div class="col d-block" id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display Element errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-gs mt-3">Submit</button>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div> 
                    <div class="container">
                        <div class="row">
                            <div class="col text-center mt-2">
                                <a href="#" class="slide1 text-gs font-weight-bold">Enter Card Info -></a>
                                <a href="#" class="slide2 text-gs font-weight-bold  d-none"><- How it Works</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <script>
                    var car = $('.carousel');

                    $('.slide1').click(function(event){
                        event.preventDefault();
                        $('.slide1').addClass('d-none');
                        $('.slide2').removeClass('d-none');
                        car.carousel('next');
                        car.carousel('pause');  

                    });

                    $('.slide2').click(function(event){
                        event.preventDefault();
                        $('.slide2').addClass('d-none');
                        $('.slide1').removeClass('d-none');
                        car.carousel('prev');
                        car.carousel('pause');  
                    });
                </script>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
               <!--  <div class="modal-footer">
                    <button type="button" class="btn btn-gs artistAction" id="removeInquiry" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                </div> -->
                <div class="modal-footer px-4" style="font-size:13px">
                    <div class="checkbox container p-0" id="postDisplay-sm"> 
                        <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
                        <img class="" src="<?php echo URL;?>img/stripeLogo.png" height="30px" width="50px">
                    </div>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal introduce the payment modal and collect payment information -->

<!-- Modal to confirm a bid on a gig -->
    <div class="modal fade" id="conf_bidToGig" tabindex="-1" role="dialog" aria-labelledby="conf_bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Confirm Your Bid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                            	<div class="m-0 p-0" id="replace_usage">
	                            	 <ul style="list-style:disc">
	                                    <li>
	                                        <p class="my-1">You currently have <span class="text-gs font-weight-bold" id="bid_num"></span> bid(s) this month!!! This will be bid # <span class="text-gs font-weight-bold" id="new_bid_num"></span>, Priced @ $<span id="bid_price"></span>/bid</p>
	                                    </li>
	                                    <li class="reduce_price d-none my-1">
	                                        <p >Make <span id="bids_left"></span> more bids and drop the price of all of your bids to $<span id="bid_pric_new"></span>/bid</p>
	                                    </li>
	                                </ul>
                                </div>
                                <p class="text-gs font-weight-bold mt-3">Click below to confirm!!!</p>
                               <!-- <p class="my-1">You have made <span id="bid_num"></span> bid(s) this month!!!</p>
                                <p class="my-1">Priced @ $<span id="bid_price"></span>/bid</p>
                                <p class="reduce_price d-none my-1">Make <span id="bids_left"></span> more bids and drop the price of all of your bids to $<span id="bid_pric_new"></span>/bid</p>
                                <p class="text-gs font-weight-bold mt-3">Click below to confirm!!!</p>-->
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs artistAction" id="submitInquiry" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm a bid on a gig -->

<!-- Modal to warn an artist before a withdrawal is carried out -->
    <div class="modal fade" id="withdrawalWarning" tabindex="-1" role="dialog" aria-labelledby="withdrawalWarning" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-danger font-weight-bold" id="exampleModalLongTitle">Warning!!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <p class="mt-2 p-0 font-weight-bold text-danger" style="font-size:12px">You are about to withdraw your inquiry submission to this gig!!! Are you sure you want to continue?</p>
                        </div>
                    </div>
                </div>

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vidTalent">Reason For Submission Withdrawal</label>
                        <textarea class="form-control mb-2" name="withdrawalReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                        <input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
                        <input type="hidden" name="gigDetails_gigStatus" value="cancelled">
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs artistAction" id="removeInquiry" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to warn an artist before a withdrawal is carried out -->

<!-- Users current usage -->
    <input type="hidden" value="" name="current-u" id="current-u" current-u="this-user-info">

<?php 

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script>

     /**** Hide/Unhide active gig posts ****/
        $('.getStatus').click(function(event){
            event.preventDefault();

            var action = $(this).attr('id');
            var postID = $(this).attr('postID');
            var gigManID = $(this).attr('gigManID');
            /**** update the isPostedStatus column in the  postedgigsmaster table ****/
                $.ajax({
                    url: "<?php echo URL; ?>views/xmlhttprequest/inquiryBackbone.php?isPostedStatus="+action+"&gigId="+postID+"&gigManLoginId="+gigManID,
                    type: "GET",
                    statusCode: {
                        404: function() {
                          alert( "page not found" );
                        }
                    },
                    success: function(result){
                        /* WHen isPostedStatus is updated, change the the wording on the hide/unhide buttons accordingly */
                            if(result == 1){
                                if(action == 'hideGigPost'){
                                    $('.getStatus').attr('id','unhideGigPost');
                                    $('.getStatus').text('Un-Hide Gig Post');
                                    $('.showPStatus').text('Post Hidden');
                                }
                                else{
                                    $('.getStatus').attr('id','hideGigPost');
                                    $('.getStatus').text('Hide Gig Post');
                                    $('.showPStatus').text('Post Viewable');
                                }
                            }
                            else{
                                console.log('Error hiding post - Please contact us to resolve issue');
                            }
                    }
                });
            /* END - update the isPostedStatus column in the  postedgigsmaster table*/
        });
    /* END - Hide/Unhide active gig posts */
    /************ Have to initailize the popover functionality for it to work *************/
        $('[data-toggl="popover"]').click(function(event){
            event.preventDefault(); 
        });
        $(document).ready(function(){
            $('[data-toggl="popover"]').popover(); 
        });
    /********* END - /Have to initailize the popover functionality for it to work **********/

    /***************** Create funciton to retrieve and display artist info *****************/
        function getArtistInfo(iLoginID,gigId,pageLoad){
            /**** Use XMLHttpRequest to fetch artist info ****/
                if(iLoginID > 0 ){
                    var getArtistDeets = new XMLHttpRequest();
                    getArtistDeets.onreadystatechange = function(){
                        if(getArtistDeets.readyState == 4 && getArtistDeets.status == 200){

                            /**** Parse the ResponseText as an xml string ****/
                                var text = getArtistDeets.responseText;
                                var trimText = text.trim(); 
                                /* Define Variables from returned xml values */ 
                                    var parser = new DOMParser();
                                    var xmlDoc = parser.parseFromString(text,"text/xml");

                                    var iLoginID = xmlDoc.getElementsByTagName('iLoginID')[0].childNodes[0].nodeValue;
                                    var dateTime = xmlDoc.getElementsByTagName('dateTime')[0].childNodes[0].nodeValue;
                                    var comments = xmlDoc.getElementsByTagName('comments')[0].childNodes[0].nodeValue;
                                    var fName = xmlDoc.getElementsByTagName('sFirstName')[0].childNodes[0].nodeValue;
                                    var lName = xmlDoc.getElementsByTagName('sLastName')[0].childNodes[0].nodeValue;
                                    var fullName = fName + ' ' + lName;
                                    
                                    var sGroupName = xmlDoc.getElementsByTagName('sGroupName')[0].childNodes[0].nodeValue;
                                    var dDOB = xmlDoc.getElementsByTagName('dDOB')[0].childNodes[0].nodeValue;
                                    var sCityName = xmlDoc.getElementsByTagName('sCityName')[0].childNodes[0].nodeValue;
                                    var statecode = xmlDoc.getElementsByTagName('statecode')[0].childNodes[0].nodeValue;
                                    var iZipcode = xmlDoc.getElementsByTagName('iZipcode')[0].childNodes[0].nodeValue;
                                    var sProfileName = xmlDoc.getElementsByTagName('sProfileName')[0].childNodes[0].nodeValue;
                                    var sContactEmailID = xmlDoc.getElementsByTagName('sContactEmailID')[0].childNodes[0].nodeValue;
                                    var sContactNumber = xmlDoc.getElementsByTagName('sContactNumber')[0].childNodes[0].nodeValue;
                                    var sUserType = xmlDoc.getElementsByTagName('sUserType')[0].childNodes[0].nodeValue;
                                    var talNumb = xmlDoc.getElementsByTagName('talNum')[0].childNodes[0].nodeValue;
                                    var selectedArtist = xmlDoc.getElementsByTagName('selectedArtist')[0].childNodes[0].nodeValue;
                                    var selectedArtistFirst = xmlDoc.getElementsByTagName('selectedArtistFirst')[0].childNodes[0].nodeValue;
                                    var selectedArtistLast = xmlDoc.getElementsByTagName('selectedArtistLast')[0].childNodes[0].nodeValue;

                                /* Insert proper modal text based on a currently selected artist */
                                    if(selectedArtist == 0){
                                        var modalText = 'Once an artist is selected, this gig post will be automatically removed from the posted gigs page and will no longer be publicly viewable.  Please confirm artist selction below.';
                                        $('#modalMessage').text(modalText);
                                    }
                                    else{
                                        var modalText = '<a href="<?php echo URL;?>views/artistprofile.php?artist='+selectedArtist+'" class="font-weight-bold text-gs" target="_blank">'+selectedArtistFirst+' '+selectedArtistLast+'</a> is currently selected for this gig. By clicking confirm, you will replace him with the newly selected artist.';
                                        $('#modalMessage').html(modalText);
                                    }

                                /* Update the artist info detail view */
                                    $('.fullName').text(fullName);
                                    $('.age').text(dDOB);
                                    $('.email').text(sContactEmailID);
                                    $('.phone').text(sContactNumber);
                                    $('.location').text(sCityName+', '+statecode+' '+iZipcode);
                                    $('.comments').html(comments);
                                    $('.profPic').attr('src', sProfileName);
                                    $('.artistProfile').attr('href','<?php echo URL;?>views/artistprofile.php?artist='+iLoginID);
                                    $('.submissionDateTime').text(dateTime);
                                    $('.sendID').attr('artistID',iLoginID);

                                    /* check if this artist has been selected for the gig */
                                        if(iLoginID === selectedArtist){
                                            $('.manAction').addClass('d-none');
                                            $('.manAction2').removeClass('d-none');
                                        }
                                        else{
                                            $('.manAction2').addClass('d-none');
                                            $('.manAction').removeClass('d-none');
                                        }

                                /* Build Talent table */
                                    var table = '';
                                    if(talNumb >=1){
                                        for(var i = 0;i<talNumb;i++){
                                            table += '<tr><th class="showTals">'+(i+1)+'</th><td>'+xmlDoc.getElementsByTagName('talent')[i].childNodes[0].nodeValue+'</td></tr>';
                                        }
                                        $('.tals').html(table);
                                    }
                            /* END - Parse the ResponseText as an xml string */

                            /* Display modal if screen is less than 768px */
                                var w = window.innerWidth; 
                                if(!pageLoad && w <= 768){
                                    $('#show-artist-sm').modal(); 
                                }
                        }
                    }
                    getArtistDeets.open('get','<?php echo URL;?>views/xmlhttprequest/inquiryBackbone.php?u_id='+iLoginID+'&g_id='+gigId);
                    getArtistDeets.send()
                }

            /* END - Use XMLHttpRequest to fetch artist info */
        }
    /************** END - Create funciton to retrieve and display artist info **************/

    /************** Dismiss the gig-list-sm modal when the window is resized **************/
        $(window).resize(function(){
            $('#show-artist-sm').modal('hide');
        });
    /*********** END - Dismiss the gig-list-sm modal when the window is resized ***********/

    /********************* Retrieve first artist's info automatically *********************/
        var iLoginID0 = $('#0').attr('iLoginID');
        var gigId = $('input[name=gigID]').val();
        var pageLoad = true; 
        getArtistInfo(iLoginID0,gigId,pageLoad);
    /****************** END - Retrieve first artist's info automatically ******************/

    /*********** When View More is clicked, retrieve the selected artist's info ***********/
        $('.getArtistDeets').click(function(event){
            event.preventDefault();
            /* highlight the selected artist's row */
                $('.artistRow').removeClass('showing');
                $(this).parents('tr.artistRow').addClass('showing');
            /* Define iLoginID var and call function to fetch and display artist info*/
                var iLoginID = $(this).attr('iLoginID');
                var pageLoad = false; 
                getArtistInfo(iLoginID,gigId);
        });
    /******** END - When View More is clicked, retrieve the selected artist's info ********/

    /****************************** Submit or Remove Inquiry ******************************/
        $('.artistAction').click(function(event){
            var action = $(this).attr('id');
            var inquiryForm = document.forms.namedItem('inquiryForm');
            var formObj = new FormData(inquiryForm);
            formObj.append('action',action);

            var inquirySubmit = new XMLHttpRequest();
            inquirySubmit.onreadystatechange = function(){
                if(inquirySubmit.readyState == 4 && inquirySubmit.status == 200){
                    var text = inquirySubmit.responseText.trim();
                    console.log(text);
                    if(text == 'success'){

                        /*********** Call another XMLHttpRequest to update stripe usage object ***********/
                            var usage_obj = new FormData();
                            usage_obj.append('action','create_usage_record');
                            usage_obj.append('iLoginID','<?php echo $currentUserID;?>');
                            usage_obj.append('u_action','bid');

                            var update_usage = new XMLHttpRequest();
                            update_usage.onreadystatechange = function(){
                                if(update_usage.status == 200 && update_usage.readyState == 4){
                                    var parsed_u_update = JSON.parse(update_usage.responseText.trim());
                                    if(parsed_u_update['u_rec_inserted'] > 0){
                                        console.log(parsed_u_update['u_rec_inserted']);
                                        /* reload page */
                                            location.reload();
                                    }  
                                }
                            }
                            update_usage.open('post','<?php echo URL; ?>views/xmlhttprequest/get_set_str_tok.php');
                            update_usage.send(usage_obj);
                        /******** END - Call another XMLHttpRequest to update stripe usage object ********/
                    }
                    else if(text == 'remove_success'){
                        /* reload page */
                            location.reload();
                    }
                    else{
                        var errMessage = 'There was a problem submitting or withdrawing for this gig!!!';
                    }
                }
            }
            inquirySubmit.open('post','<?php echo URL;?>views/xmlhttprequest/inquiryBackbone.php');
            inquirySubmit.send(formObj);
        });
    /*************************** END - Submit or Remove Inquiry ***************************/

    /****************************** Select Artist ******************************/
        $('.selectArtist').click(function(event){
            event.preventDefault(); 
            var gm_id = '<?php echo $currentUserID;?>';
            // console.log(gm_id);
            var artistID = $('.sendID').attr('artistID');

            if($(this).attr('id') == 'selectThisArtist'){
                var transaction = 'selectArtist';
            }
            else if($(this).attr('id') == 'deselectThisArtist'){
                var transaction = 'deSelectArtist';
            }

            /* Create form */
                var selectArtistForm = new FormData();
                if(transaction == 'selectArtist'){
                    selectArtistForm.append('transaction','selectArtist');
                }
                else if(transaction == 'deSelectArtist'){
                    selectArtistForm.append('transaction','deSelectArtist');
                }
                selectArtistForm.append('action','selectArtist');
                selectArtistForm.append('iLoginID',artistID);
                selectArtistForm.append('gigId',gigId);
                selectArtistForm.append('gm_id',gm_id);

            /* Create XMLHttpRequest to send artist selection to the postedgigsmaster */
                var selectArtist = new XMLHttpRequest();
                selectArtist.onreadystatechange = function(){
                    if(selectArtist.status == 200 && selectArtist.readyState == 4){
                        console.log(selectArtist.responseText);
                        if(selectArtist.responseText == 1){
                            if(transaction == 'selectArtist'){
                                $('.manAction').addClass('d-none');
                                $('.manAction2').removeClass('d-none');
                            }
                            else if(transaction == 'deSelectArtist'){
                                $('.manAction2').addClass('d-none');
                                $('.manAction').removeClass('d-none');
                            }
                        }
                    }
                }
                selectArtist.open('post','<?php echo URL;?>views/xmlhttprequest/inquiryBackbone.php');
                selectArtist.send(selectArtistForm);
        });
    /*************************** END - Select Artist ***************************/

    /******************** Reset De-selection textarea input ********************/
       /* function formReset(){
            $('textarea[name=de-selectReason').val('');
        }
        function formReset2(){
            console.log('test form reset');
            document.getElementById("payment-form").reset();
        }*/
    /***************** END - Reset De-selection textarea input *****************/
</script>
<script src="https://js.stripe.com/v3/"></script>
<script>

/*************************************************** stripe functionality ***************************************************/
    (function() {
        /* Show current usage function */
            function showCurrentUsage(currentUsage){
                if(currentUsage < 6){
                    var bids_left = 6 - currentUsage;
                    $('#bid_price').html('3.50');
                    $('#bid_pric_new').html('2.50');
                    $('#bids_left').html(bids_left);
                    $('.reduce_price').removeClass('d-none');
                }
                else if(currentUsage >= 6 && currentUsage < 11){
                    var bids_left = 11 - currentUsage;
                    $('#bid_price').html('2.50');
                    $('#bid_pric_new').html('1.00');
                    $('#bids_left').html(bids_left);
                    $('.reduce_price').removeClass('d-none');
                }
                else{
                    $('#bid_price').html('1.00');
                }
                var newBid_numb = currentUsage;
                $('#bid_num').html(newBid_numb);
                $('#new_bid_num').html(newBid_numb + 1);
            }
        /* END - Show current usage function */

        /************************** Check if user has payment info on file **************************/
            function get_str_cust_info(str_cust_id){
               
                var newForm = new FormData();
                newForm.append('action', 'check_pay_src');
                newForm.append('u_action', 'bid');
                newForm.append('retrieve_cust', str_cust_id);
                newForm.append('iLoginID', "<?php echo $userInfo['iLoginID'];?>");

                var sendCust_info = new XMLHttpRequest();
                sendCust_info.onreadystatechange = function(){
                    if(sendCust_info.readyState == 4 && sendCust_info.status == 200){
                        var respTxt = sendCust_info.responseText.trim();
                        var parse_respTxt = JSON.parse(respTxt);
                        console.log(parse_respTxt);

                        if(parse_respTxt['trial_end'] == false){
                            var trialEnd = '<p class="font-weight-bold">Your bids are on us until '+parse_respTxt['exp_date_time']+'.  Happy Gigging!!!</p>';
                            $('#replace_usage').html(trialEnd);
                        }

                        if(parse_respTxt['src_present']){
                            /* Set the data-target */
                                $('.submitInquiry').attr('data-target','#conf_bidToGig'); 

                            /* Fill in current usage values for customer */
                                showCurrentUsage(parse_respTxt['current_usage']);
                        }
                        else{
                            /* Set the data-target */
                                $('.submitInquiry').attr('data-target','#bidToGig');
                        }

                        /* Temporarily store usage value access later */
                            $('#current-u').attr('current-u',parse_respTxt['current_usage']);
                    }
                }
                sendCust_info.open('POST',"<?php echo URL;?>views/xmlhttprequest/get_set_str_tok.php");
                sendCust_info.send(newForm);
            }

            /**** Check if user has a stripe customer id - if so, call get_str_cust_info else create new customer object ****/
                var str_cust_id = "<?php echo $userInfo['str_customerID'];?>";
                if(str_cust_id){
                    /* Call the get_str_cust_info function to determine if str_customer has default src */
                        //get_str_cust_info(str_cust_id);
                }
                else{
                    /* First create customer obj */
                        var str_cust_form = new FormData();
                        str_cust_form.append('create_str_cust',true);
                        str_cust_form.append('sFirstName','<?php echo $userInfo["sFirstName"];?>');
                        str_cust_form.append('sLastName','<?php echo $userInfo["sLastName"];?>');
                        str_cust_form.append('iLoginID','<?php echo $userInfo["iLoginID"];?>');
                        str_cust_form.append('sContactEmailID','<?php echo $currentUserEmail;?>');
                        str_cust_form.append('userType','<?php echo $currentUserType;?>');
	
                        var send_custForm = new XMLHttpRequest();
                        send_custForm.onreadystatechange = function(){
                            if(send_custForm.status == 200 && send_custForm.readyState == 4){
                                var respTxt = send_custForm.responseText.trim();
                                var parse_respTxt = JSON.parse(respTxt);
				//console.log(respTxt);
                                if(parse_respTxt['cust_id']){
                                    //get_str_cust_info(parse_respTxt['cust_id']);
                                }
                            }
                        }
                        send_custForm.open('post',"<?php echo URL;?>views/xmlhttprequest/get_set_str_tok.php");
                        send_custForm.send(str_cust_form);
                }
            /* END - Check if user has a stripe customer id - if so, call get_str_cust_info else create new customer object */
        /*********************** END - Check if user has payment info on file ***********************/


      "use strict";
        var stripe = Stripe('pk_test_mvwPTPJ6rSe6P4lmWIr5pbwr');
        var elements = stripe.elements();

        /* Custom styling can be passed to options when creating an Element. */
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                    invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

        /* Create an instance of the card Element. */
            var card = elements.create('card', {style: style});

        /* Add an instance of the card Element into the `card-element` <div>. */
            card.mount('#card-element');

        /* Add an event listener to the card element to catch errors */
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');

                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }   
            });

        /* Define a function to add the card token to the payment info form and then submit the form to the server */
            function stripeTokenHandler(token) {
                
                /* Insert the token ID into the form so it gets submitted to the server */
                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);

                /* Submit the form to the get_set_str_tok.php - update current user's customer object with payment src */
                    var newForm = new FormData(form);
                    newForm.append('action','add_src_tok');
                    newForm.append('cust_id',"<?php echo $userInfo['str_customerID'];?>");
                    newForm.append('iLoginID',"<?php echo $userInfo['iLoginID'];?>");

                    var sendTok = new XMLHttpRequest();
                    sendTok.onreadystatechange = function(){
                        if(sendTok.status == 200 && sendTok.readyState == 4){

                            /* Display the confirmation modal for the current bid */
                                var respTxt = sendTok.responseText.trim();
                                var parse_respTxt = JSON.parse(respTxt);
                                // console.log(respTxt);

                                if(parse_respTxt['src_count'] > 0){
                                    /* Dismiss the "how it works" modal and show the confirmation modal */
                                        $('#bidToGig').modal('hide');

                                    if(parse_respTxt['trial_end']){
                                        /* Set the data-target by calling the get_str_cust_info function - retrieve user stripe info */
                                        var curr_u = parseInt($('#current-u').attr('current-u'));
                                        showCurrentUsage(curr_u);
                                    }
                                    else{
                                        var trialEnd = '<p class="font-weight-bold">Your bids are on us until '+parse_respTxt['exp_date_time']+'.  Happy Gigging!!!</p>';
                                        $('#replace_usage').html(trialEnd);
                                    }
                                     
                                    $('#conf_bidToGig').modal('show');

                                    /* Set the data-target */
                                        $('.submitInquiry').attr('data-target','#conf_bidToGig');
                                }
                        }
                    }
                    sendTok.open('POST','<?php echo URL; ?>views/xmlhttprequest/get_set_str_tok.php');
                    sendTok.send(newForm);
            }

        /* Create a token or display an error when the form is submitted. */
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    
                    if (result.error) {
                        /* Inform the customer that there was an error. */
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                    } else {
                        /* Send the token to your server. */
                            stripeTokenHandler(result.token);

                    }
                });
            });
    })();

/************************************************ END - stripe functionality ************************************************/
</script>