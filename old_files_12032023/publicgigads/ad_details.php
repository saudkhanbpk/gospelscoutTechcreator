<?php 

	$backGround = 'bg2';
	// $page = 'Pending Gigs';
	
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	if($currentUserID != ''){
		
		if( $_GET['g_id'] != ''){
			/* query the postedgigsmaster table for the gig associated with the id passed in the $_GET var */
                $g_ID = trim($_GET['g_id']);
                $tal_tracker_id = trim($_GET['tal_tracker']);

                if(ctype_alnum($g_ID)){
                    /* Get the posted gig */
                        $emptyArray = array();
                        $paramArray0['gigId']['='] = $g_ID;
                        $getPostedGig = pdoQuery('postedgigsmaster','all',$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
                    
                    /* Get the talents needed for the posted gig */
                        $paramArray1['gigId']['='] = $g_ID;
                        $innerJoinArray1 = array(
                        	array('giftmaster','iGiftID', 'postedgigneededtalentmaster','artistType')
                       	);
                        $getPostedGigTalentsNeeded = pdoQuery('postedgigneededtalentmaster','all',$paramArray1,$orderByParam1,$innerJoinArray1,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
				// echo '<pre>';
				// var_dump($getPostedGigTalentsNeeded);
                        $tot_pay = 0; 
						$selectedArtist_count = 0;
                        foreach($getPostedGigTalentsNeeded as $talentsNeeded){
                        	$gigTalentsNeeded[$talentsNeeded['artistType']][$talentsNeeded['tal_tracker_id']]['talent'] =  str_replace("_","/",$talentsNeeded['sGiftName']);	
                            $gigTalentsNeeded[$talentsNeeded['artistType']][$talentsNeeded['tal_tracker_id']]['tal_pay'] =  CentsToDollars($talentsNeeded['tal_pay']);
                            $tals_List[$talentsNeeded['artistType']] = str_replace("_","/",$talentsNeeded['sGiftName']);  

                            $tot_pay += $talentsNeeded['tal_pay']; 

							if($talentsNeeded['artist_selected'] !== "0"){
								$selectedArtist_count++;
							}
                        }
						// var_dump($selectedArtist_count);
                        $first_tal = $getPostedGigTalentsNeeded[0]['artistType'];
                        $first_tal_tracker = $getPostedGigTalentsNeeded[0]['tal_tracker_id'];
                        $tot_pay = CentsToDollars($tot_pay);
                    
                        if(count($getPostedGig) == 0){
                        echo '<script> window.location = "'. URL .'publicgigads/";</script>';
                        }
                        else{
                            $columnsArray3 = array('postedgiginquirymaster.*', 'usermaster.sFirstName', 'usermaster.sLastName', 'usermaster.dDOB', 'usermaster.sCityName', 'states.statecode');//'postedgiginquirymaster.iLoginID', 'postedgiginquirymaster.artistType','postedgiginquirymaster.dateTime','postedgiginquirymaster.comments'
                            $paramArray3['postedgiginquirymaster.gigId']['='] = $g_ID;
                            $innerJoinArray3 = array(
                            	array('usermaster','iLoginID','postedgiginquirymaster','iLoginID'),
                            	array('states','id','usermaster','sStateName')
                            );
                            $getInquiriesResults = pdoQuery('postedgiginquirymaster',$columnsArray3,$paramArray3,$orderByParam3,$innerJoinArray3,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
		// echo '<pre>';
		// var_dump($getInquiriesResults);
                            $inqu_count = 0; 
                            foreach($getInquiriesResults as $gigInqResult){
                                if($currentUserID == $gigInqResult['iLoginID']){
                                    $tal_applied_for = $gigInqResult['artistType'];
									$tal_tracker_id_applied_for = $gigInqResult['tal_tracker_id'];
                                }

                                foreach($gigTalentsNeeded as $gigTalentsNeeded_indie => $gigTalentsNeeded_valie){
                                    if( $gigInqResult['artistType'] == $gigTalentsNeeded_indie && $gigInqResult['inquiry_withdrawn'] == 0){
											$inqu_count++;
                                    }
                                }
                            }
                            $current_user_applied_tal = $tals_List[$tal_applied_for];

							$columnsArray20 = array('postedgigneededtalentmaster.tal_pay');
                            $paramArray20['postedgigneededtalentmaster.tal_tracker_id']['='] = $tal_tracker_id_applied_for;
                            $getPay = pdoQuery('postedgigneededtalentmaster',$columnsArray20,$paramArray20,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
							$current_user_applied_tal_pay = CentsToDollars($getPay['tal_pay']);
							
							/* Get the count for artist bids and requests */
							// echo '<pre>';
							foreach($getInquiriesResults as $inqVals){
								// var_dump($inqVals);
                                if($inqVals['gmRequested'] === '1'){
                                    $gmReq['true'][] = $inqVals;
                                }else{
                                    $gmReq['false'][] = $inqVals;
                                }
                            } 
                    }

                    /* Is user logged in - if so, from what perspective */
                        if($currentUserID){
                            /* Is user the gig manager or an artist */
                                if($currentUserID == $getPostedGig['gigManLoginId']){
                                    $user = 'manager';
                                }
                                elseif($currentUserType == 'church' || $currentUserType == 'user'){
                                    /* Redirect user to search 4 artist page */
                                        echo '<script> window.location.href = "https://www.gospelscout.com/artist/"</script>';
                                }
                                else{
									/* Determine if artist is selected for this gig */
                                        foreach($getPostedGigTalentsNeeded as $tals_needed){
                                            if($tals_needed['artist_selected'] == $currentUserID){
                                                $curr_artist_selected = $tals_needed; 
                                                break;
                                            }
                                        }

                                    /* Determine if the artist or group submitted an inquiry */
									if(count($getInquiriesResults) > 0){
										foreach ($getInquiriesResults as $key01 => $value01) {
											if($currentUserID == $value01['iLoginID']){
												$user_resp = $value01['artist_response'];
												
												if($value01['cancelby'] !== NULL){
													$user = 'canceled';
													$cancel_reason = $value01['cancelreason'];
													$canceller = $value01['cancelby'];
												}
												elseif($value01['inquiry_withdrawn'] == 1){
													$user = 'artistWithdrawn';
                                                    $withdraw_reason = $value01['withdraw_reason'];
												}
												elseif( count($curr_artist_selected) > 0 ){
													$user = 'artistSelected';
												}
												elseif($value01['gmRequested'] == 1){
                                                    $user = 'artistRequested';
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
                            /* User is not logged in - Re-direct user */
                                echo '<script> window.location.href = "https://www.gospelscout.com/artist/"</script>';
                        }
                }
                else{
                	/* Invalid Gig Id entered - redirect user */
                    	echo '<script> window.location = "'. URL .'publicgigads/";</script>';
                }
		}
		else{
			/* Re-direct page */
				echo '<script> window.location = "'. URL .'publicgigads/";</script>';
		}
	}
	else{
		/* Re-direct page */
			echo '<input type="hidden" name="loggedIn" value="false">';
	}

	/* make gig id accessible to the javascript */
        echo '<input type="hidden" name="first_tal" value="' . $first_tal . '">';
        echo '<input type="hidden" name="gigID" value="' . $g_ID . '">';
        echo '<input type="hidden" name="curr_tal_tracker" value="'. $first_tal_tracker .'">';
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
        .active,.nav-link:hover {
            background-color: rgba(149,0,173,1);
      }     
	</style>
	<link href="https://www.gospelscout.com/publicgigads/css/ad_detailsCss.css?1" rel="stylesheet">
</head>
<?php 
    /* Determine if Post is publiclly viewable or not */
        /* today's date */
            $gDate = $getPostedGig['gigDate'];
            $today = date_create(date());
            $today = date_format($today, 'Y-m-d H:i:s');
            
        if($gDate < $today){
            $showPStatus = 'Post Expired';
        }
        elseif($getPostedGig['paid'] == '0'){
            $hideStatButt = 'Pay & Post Gig';
            $showPStatus = 'Post Hidden';
        }
        elseif($getPostedGig['isPostedStatus'] == '1'){
            $hideStatID = 'hide';
            $hideStatButt = 'Hide Gig Post';
            $showPStatus = 'Post Viewable'; 
        }
        else{
            $hideStatID = 'show';
            $hideStatButt = 'Un-Hide Gig Post';
            $showPStatus = 'Post Hidden';
        }
?>
<div class="container mt-5 mt-lg-5 mx-auto px-0 px-lg-5">
	<div class="row mx-0 mx-md-3 mt-5 pt-5">
        <div class="px-0 px-md-2 mx-0 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mx-0">
			 
                <h5 class="card-header">Gig Info <span class="showPStatus"><?php echo ' - '.$showPStatus;?></sapn></h5>
                <!-- Artist's profile pic -->
                    <div class="container text-center text-md-left pl-md-4 mt-2">
                    	<div class="row pl-4 pt-2">
                    		<div class="col text-left">
                        		<h5 class="text-gs">
                                    <?php 
                                        if($user == 'manager'){
                                            echo 'Total Cost: '. $tot_pay;  
                                        }
                                    ?>
                                </h5>                    			
                    		</div>  
                    	</div>
                        <div class="row pl-4 pt-2">
                            <div class="col text-left">
                                <h6 style="font-size: 14px;">Post Id: <?php echo $getPostedGig['gigId'];?></h6>                             
                            </div>
                        </div>
                         <div class="row pl-4 pt-2">
                            <div class="col text-left">
                                <h6 style="font-size: 14px;">Posted: <?php echo  ageFuntion( $getPostedGig['postedDate'] );?></h6>                             
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
                                            <td><ol class="p-0 m-0">
                                            <?php 
                                            	foreach($gigTalentsNeeded as $tal_needed0){
                                                    if( count($tal_needed0) > 1){
                                                        $tal_count0 = 1;
                                                    }
                                                    else{
                                                        $tal_count0 = '';
                                                    }

                                                    foreach($tal_needed0 as $tal_displayed){
                                                        $tal_displ = '';
                                                        $tal_displ =  '<li>'. $tal_displayed['talent'] .' '.$tal_count0;
                                                      
                                                        if($user == 'manager'){
                                                            $tal_displ .=  ' - '.$tal_displayed['tal_pay'];
                                                        }
                                                        $tal_displ .= '</li>'; 

                                                        echo $tal_displ;
                                                        $tal_count0++;
                                                    }
                                            	}
                                            ?>
                                        </ol></td>
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
                                        <?php if($user == 'manager' || $user == 'artistSubmitted'  || $user == 'artistSelected'){?>
                                            <tr>
                                                <th scope="row">Venue Name: </th>
                                                <td><?php echo $getPostedGig['venueName'];?></td>
                                            </tr>
                                        <?php }?>
                                         <tr>
                                            <th scope="row">Venue Address:</th>
                                            <?php 
                                                if($user == 'manager' || $user == 'artistSubmitted' || $user == 'artistSelected'){
                                                    $venue = $getPostedGig['venueAddress'] . '<br>' . $getPostedGig['venueCity'] . ', ' . $getPostedGig['venueStateShort'] .' ' . $getPostedGig['venueZip'];
                                                }else{
                                                    $venue = $getPostedGig['venueCity'] . ', ' . $getPostedGig['venueStateShort'] .' ' . $getPostedGig['venueZip'];
                                                }
                                            ?>
                                            <td><?php echo $venue;?></td>
                                        </tr>
                                         <tr>
                                            <th scope="row">Environment: </th>
                                            <td><?php echo $getPostedGig['venueEnvironment'];?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($user == 'manager' || $user == 'artistSubmitted' || $user == 'artistSelected'){?>
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
                            $gDate = $getPostedGig['gigDate'];
                            $today = date_create(date());
                            $today = date_format($today, 'Y-m-d H:i:s');
                            
                            if($user == 'manager' && $gDate > $today){
                        ?>
                            <!-- Edit, hide, delete Post (show if gig date has not passed.) -->
				                <a class="btn btn-small btn-gs text-white" href="<?php echo URL;?>publicgigads/index.php?gigID=<?php echo $g_ID;?>" id="postGig">Edit Post</a> 
                            
                            <?php if(is_null($getPostedGig['selectedArtist']) || $getPostedGig['selectedArtist'] == 0){
                                 // Display the show or hide post button depedning on if the post is currently showing on the posted gigs page 
                                 if($getPostedGig['paid'] == 0){
                                        echo '<a class="btn btn-small btn-gs text-white" href="https://www.gospelscout.com/checkout/?g_id='.$g_ID.'">Pay & Post Now</a>';
                                    }else{
                                        echo '<a class="btn btn-small btn-gs text-white getStatus" href="#" gigManID="'.$currentUserID.'" postID="'.$g_ID.'" id="'.$hideStatID.'">'.$hideStatButt.'</a>';
                                    }
                            ?>
                                    <div class="container text-left">
                                        <div class="row">
                                            <div class="col p-3 text-danger" id="upd_err"></div>
                                        </div>
                                    </div>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-lg-3 px-0 px-lg-5">
    <div class="row mx-0 mx-md-3">
        <div class=" px-0 px-md-2 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mx-0" id="pageReference">
               
                 <?php if($user == 'manager'){?>
                <!-- For Gig manager only -->
                    <!-- Card header -->
                    <div class="card-header pb-0">
                        <ul class="nav nav-tabs card-header-tabs pb-2">
                            <input type="hidden" name="gmRequested" value="">
                            <li class="nav-item">
                                <a class="nav-link nav-link-1 active" type="button" id="showBids"  onClick="getAllArtistInquiries(0)">Artist Bids <span class="badge badge-pill badge-primary" id="bidCount"><?php echo count($gmReq['false']);?></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-1" id="showRequested" onClick="getAllArtistInquiries(1)">Artists Requested <span class="badge badge-pill badge-primary" id="requestCount"><?php echo count($gmReq['true']); ?></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-1" id="showPlaying" onClick="getAllArtistInquiries(2)">Artists Playing <span class="badge badge-pill badge-primary" id="requestCount"><?php echo  $selectedArtist_count; ?></span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /Card header -->
					<!-- Card body -->
                    <div class="card-body p-0 pb-2">
                        <div class="container px-0" style="width:100%">
                            <?php 
                            // echo '<pre>';
                            // var_dump($getInquiriesResults);
							// var_dump($inqu_count);
                                if(count($getInquiriesResults) > 0){ //&& $inqu_count > 0
                            ?>
                                <div class="nav-scroller box-shadow mt-0 bg-gs" id="talent-navbar" style="width:100%">
                                  <nav class="nav nav-underline" id="getUid" u-id="<?php echo $currentUserID;?>">  
                                    <?php 
                                        $tal_counter = 0;
                                        foreach($gigTalentsNeeded as $tal_index => $talNeeded){
                                            if( count($talNeeded) > 1){
                                                $tal_count2 = 1;
                                            }
                                            else{
                                                $tal_count2 = '';
                                            }
                                            foreach($talNeeded as $tal_tab_index => $tal_tab){
                                    ?>
                                                <a class="nav-link nav-link-2 <?php if($tal_counter == 0){ echo 'active';} ?> text-white getGigTalInqu" talTrackerId="<?php echo $tal_tab_index;?>" gigId="<?php echo $g_ID;?>" talGroup="<?php echo $tal_index;?>" href=""><?php echo $tal_tab['talent'].' '.$tal_count2;?></a>
                                    <?php 
                                                $tal_count2++;
                                            }
                                        $tal_counter++;
                                    }?>
                                  </nav>
                                </div>
                                
                                <!-- Info Div  -->
                                <div class="container pt-2" style="min-height:400px;"><div class="row mb-3 infoDisplay" id="infoDisplay"></div></div>
                            <?php 
                                }
                                else{
                                    echo '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-5"><div class="col p-lg-5"><h2 class="" style="color: rgba(204,204,204,1)">No Artists Have Submitted Inquiries for this Gig!!!</h2></div></div></div>';
                                }
                            ?>
                        </div>
                    </div>
					<!-- /Card body -->
                <!-- /For Gig manager only -->

                <?php }else{?>
                    <h5 class="card-header"><?php if($user == 'artistRequested'){echo 'Gig Request';}else{ echo 'Submit an Inquiry';}?></h5>
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
											<?php 
												// echo '<pre>'; var_dump($getPay);
												if( $current_user_applied_tal != null && $user != 'artistWithdrawn'){?>
												<tr>
													<th>Gig Pay:</th>
													<td class="text-gs">
														<?php echo $current_user_applied_tal_pay;?>
													</td>
												</tr>
											<?php } ?>
                                            <tr>
                                                <th>Playing Status:</th>
                                                <td class="text-gs">
                                                    <?php 
                                                        if($user == 'artistWithdrawn'){
                                                            echo 'Bid Withdrawn';
                                                        }elseif($user == 'canceled'){
                                                            echo 'Canceled by Gig manager';
                                                        }elseif($user == 'artistSelected'){
                                                            echo 'Playing';
                                                        }elseif( $user == 'artistRequested' && $user_resp == 'declined'){
                                                            echo '<span class="text-danger"> Declined</span>';
                                                        }elseif($user == 'artistSubmitted' || $user == 'artistRequested'){
                                                            echo 'Pending';
                                                        }elseif($user == 'artistNotSubmited'){
                                                            echo 'N/A';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php if($user == 'artistWithdrawn' || $user == 'canceled'){?>
                                                <tr>
                                                    <th>Cancel Reason:</th>
                                                    <td class="text-gs">
                                                        <?php 
															if($user == 'artistWithdrawn'){ 
																if( $withdraw_reason !== '' && $withdraw_reason !== NULL){echo $withdraw_reason;}else{echo 'N/A';}
															}else{
																if( $cancel_reason !== '' && $cancel_reason !== NULL){echo $cancel_reason;}else{echo 'N/A';}
															} 
														?>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                            <tr>
                                                <th><?php if($user == 'artistRequested'){echo 'Request Submitted';}else{ echo 'Inquiry Submitted';}?>:</th>
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
                                                        $state = $obj->fetchRow('states',"id = ".$userInfo['sStateName'], $db);
                                                        echo ucfirst($userInfo['sCityName']) . ', ' . $state['statecode'] . ' ' . $userInfo['iZipcode'];
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Talent(s): </th>
                                                <td>
                                                    <ol class="m-0 p-0">
                                                        <?php 
                                                            $talents = $obj->fetchRowAll('talentmaster',"iLoginID = ".$userInfo['iLoginID'], $db);
                                                            foreach($talents as $indNumb => $tal){?>
                                                                <li>
                                                                    <?php 
                                                                        $talent_truncated = truncateStr($tal['talent'], 15);
                                                                        echo str_replace('_', '/', $talent_truncated);
                                                                    ?>
                                                                </li>
                                                        <?php } ?>
                                                    </ol>
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
                                            <form name="inquiryForm" id="inquiryForm" type="post">
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
                                                    <th ><?php if($user == 'artistRequested'){echo 'Requested As';}else{ echo 'Bidding As';}?> <span class="text-danger"> *</sapn> :</th>
                                                    <td>
                                                        <?php 
														// echo '<pre>';var_dump($gigTalentsNeeded);
                                                            if( $current_user_applied_tal != null && $user != 'artistWithdrawn'){
                                                                echo $current_user_applied_tal;
                                                                echo '<input type="hidden" name="tal_tracker_id" value="'.$tal_tracker_id_applied_for.'">';
                                                            }
                                                            else{
                                                                foreach($gigTalentsNeeded as $tal_needed_index => $tal_needed1){
                                                                    if( count($tal_needed1) > 1){
                                                                        $tal_count = 1;
                                                                    }
                                                                    else{
                                                                        $tal_count = '';
                                                                    }
                                                                    foreach($tal_needed1 as $tal_displayed1_index => $tal_displayed1){
                                                                        echo '<input type="radio" name="artistType" tal_id="'.$tal_displayed1_index.'" value="'. $tal_needed_index . '" required> ' . $tal_displayed1['talent'] .' '.$tal_count. '<span style="color:#888888"> (' . $tal_displayed1['tal_pay'] . ')</span> <br>';
                                                                        $tal_count++; 
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <th scope="row">Comments: test </th>
                                                    <td>
                                                            <input type="hidden" name="gigId" value="<?php echo $g_ID;?>">
                                                            <input type="hidden" name="gigManID" value="<?php echo $getPostedGig['gigManLoginId'];?>"><!-- will remove this at some point; its redundant-->
                                                            <input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
                                                            <?php if( ($user == 'artistNotSubmited' || $user == 'artistWithdrawn') && $gDate > $today){?>
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
																		echo '<input type="hidden" name="tal_tracker_id" value="'.$curr_artist_selected['tal_tracker_id'].'"';
                                                                    }
                                                                }
                                                            ?>
                                                    </td>
                                                </tr>
                                            </form>
                                        </tbody>
                                    </table>
                                    
                                    <div id="actionButtonContainer">
                                        <?php 
                                        
                                            if($gDate > $today && $user !== 'canceled') {
                                                if($user == 'artistNotSubmited' || $user == 'artistWithdrawn'){?>
                                                    <!-- artistAction -->
                                                    <button type="button" id="want_to_play" isTestGig="<?php echo $getPostedGig['testGig'];?>" class="btn btn-sm btn-gs">I Want To Play!</button>
                                        <?php   }elseif($user == 'artistRequested' && $user_resp == 'declined'){?>         
                                                    <p class='text-danger mb-0'>You have delcined this gig</p>
                                                    <p class="mt-0" href="" style="font-size:.7em">Have you reconsidered? <a id="conf_play_req" class="text-success">Confirm</a></p>
                                        <?php   }elseif($user == 'artistRequested' && $user_resp !== 'confirmed'){?>
                                                        <button type="button" id="conf_play_req"  class="btn btn-sm btn-success">Confirm</button>
                                                        <button type="button" id="dec_play_req"  class="btn btn-sm btn-danger">Decline</button>
                                        <?php   }else{?>
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#withdrawalWarning" >cancel</button>
                                                    <?php if($user_resp === 'confirmed' && $user !== 'artistSelected'){
                                                        echo '<p style="font-size:.7em;color:#888888">waiting for gig manager confirmation</p>';
                                                    }?>
                                        <?php   }
                                            }
                                        ?>
                                    </div>
									 <div class="container">
                                        <div class="row">
                                            <div class="col text-danger font-weigt-bold text-center" style="font-size:.8em" id="form-err"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/publicgigads/phpBackend/ad_detailsModal_smScreen.php');
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Users current usage -->
    <input type="hidden" value="" name="current-u" id="current-u" current-u="this-user-info">

<?php 
 	/*Include the Modals page */
		 include(realpath($_SERVER['DOCUMENT_ROOT']) . '/publicgigads/phpBackend/ad_detailsModals.php');
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>

<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="<?php echo URL;?>js/additional-methods.js"></script>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo URL;?>publicgigads/js/ad_detailsJSFunctions.js?40"></script>
<script src="<?php echo URL;?>publicgigads/js/ad_detailsJS.js?59"></script>