<?php 
	
    /* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	

	$emptyArray = array();
	if($_GET['viewed']){
		/* Update the 'Viewed' status of notifications in the notificationmaster table */
	    		$notificationID = $_GET['notificationID'] == 'all' ? $_GET['notificationID'] : intval(trim($_GET['notificationID'])) ;
	    		unset($_GET['notificationID']);
	    		
	    		foreach($_GET as $index => $val){
					$array[$index] = $val;
	    		}

	    		if( $notificationID == 'all'){
	    			$cond = 'notifiedID = ' . $currentUserID;
	    			$resp_type = 'all_notific_viewed';
	    		}else{
	    			$cond = 'id = ' . $notificationID;
	    			$resp_type = 'notific_viewed';
	    		}
	    		$table = 'notificationmaster';
				  $updateViewed = updateTable($db, $array, $cond, $table);

	    		if($updateViewed){
	    			$response['notfic_present'] = true;
	    			$response['notifications']['type'] = $resp_type;
	    		}else{
	    			$response['notfic_present'] = false;
	    		}
		
	    		/* Return JSON Response */
	    			echo json_encode($response);
	}elseif($_GET['recNot']){
	    $columnsArray_not = array('usermaster.sFirstName','usermaster.sLastName', 'usermaster.sUserType', 'usermaster.sGroupName', 'usermaster.sChurchName', 'usermaster.sProfileName', 'notificationmaster.*','notificationtypemaster.notificationDescription');
	    $paramArray_not['notificationmaster.notifiedID']['='] = $currentUserID; 
	    $paramArray_not['notificationmaster.viewed']['='] = 0; 
	    $innerJoinArray_not = array(
	      array('notificationtypemaster','notificationName','notificationmaster','action'),
	      array('usermaster','iLoginID','notificationmaster','notifierID')
	    );
	    $getNewNotificationsResults = pdoQuery('notificationmaster',$columnsArray_not,$paramArray_not,$orderByParam_not,$innerJoinArray_not,$leftJoinArray_not,$paramOrArray_not,$emptyArray,$emptyArray);

	    if( count($getNewNotificationsResults) > 0 ){
	    	/* Reformat the age of the post */
	    		foreach($getNewNotificationsResults as $getNewNotificationsResults_ind => $getNewNotificationsResults_val){
	    			$getNewNotificationsResults[$getNewNotificationsResults_ind]['postedDate'] = ageFuntion($getNewNotificationsResults_val['dateTime']);

	    			$notific_results[ $getNewNotificationsResults_val['action'] ][] = $getNewNotificationsResults[$getNewNotificationsResults_ind];
	    		}
	    	$response['notfic_present'] = true;
	    	$response['notifications']['data'] = $notific_results;
	    	$response['notifications']['type'] = 'Recent Notifications';
	    }else{
	    	$response['notfic_present'] = false;
	    }

	    echo json_encode($response);
	}elseif($_GET['gigSugg']){
		/**** Query the suggestedGigs table for the gigID using the iLoginID param ****/	
		    $columnsArray_not = array('postedgigssuggestionmaster.gigID','postedgigsmaster.gigName', 'postedgigsmaster.gigManLoginId', 'postedgigsmaster.gigManName', 'postedgigsmaster.postedDate', 'usermaster.sUserType');
		    $paramArray_not['postedgigssuggestionmaster.iLoginID']['='] = $currentUserID; 
		    $innerJoinArray_not = array(
		      array('postedgigsmaster','gigId','postedgigssuggestionmaster','gigID'),
		      array('usermaster','iLoginID','postedgigsmaster','gigManLoginId')
		    );
		    $getSuggGigsResults = pdoQuery('postedgigssuggestionmaster',$columnsArray_not,$paramArray_not,$orderByParam_not,$innerJoinArray_not,$leftJoinArray_not,$emptyArray,$emptyArray,$emptyArray);
		    
		    if( count($getSuggGigsResults) > 0 ){
		    	/* Reformat the age of the post */
	    		foreach($getSuggGigsResults as $getNewNotificationsResults_ind => $getNewNotificationsResults_val){
	    			$getSuggGigsResults[$getNewNotificationsResults_ind]['postedDate'] = ageFuntion($getNewNotificationsResults_val['postedDate']);
	    		}

		    	$response['notfic_present'] = true;
		    	$response['notifications']['data'] = $getSuggGigsResults;
	    		$response['notifications']['type'] = 'Gig Suggestions';
		    }else{
		    	$response['notfic_present'] = false;
		    }
		/* END - Query the suggestedGigs table for the gigID using the iLoginID param */	

		/* Return JSON Response */
			echo json_encode($response);
	}elseif($_GET['gigSubm']){
		/* Query the gig inquiry table */	
		$columnsArray_not = array('postedgiginquirymaster.gigId', 'postedgiginquirymaster.dateTime', 'postedgigsmaster.gigName', 'postedgigsmaster.status', 'postedgigsmaster.selectedArtist','postedgigsmaster.gigDate','postedgigsmaster.setupTime');
		$paramArray_not['postedgiginquirymaster.iLoginID']['='] = $currentUserID;
		$innerJoinArray_not = array(
			array('postedgigsmaster','gigId','postedgiginquirymaster','gigId')
		);
		$getSubmittedGigResults = pdoQuery('postedgiginquirymaster',$columnsArray_not,$paramArray_not,$orderByParam_not,$innerJoinArray_not,$leftJoinArray_not,$emptyArray,$emptyArray,$emptyArray);
		
		if( count($getSubmittedGigResults) > 0 ){
	    	/* Reformat the age of the post */
    		foreach($getSubmittedGigResults as $getNewNotificationsResults_ind => $getNewNotificationsResults_val){
    			$getSubmittedGigResults[$getNewNotificationsResults_ind]['postedDate'] = ageFuntion($getNewNotificationsResults_val['dateTime']);
    		}

	    	$response['notfic_present'] = true;
	    	$response['notifications']['data'] = $getSubmittedGigResults;
    		$response['notifications']['type'] = 'Gig Submissions';
	    }else{
	    	$response['notfic_present'] = false;
	    }
		// var_dump($getSubmittedGigResults);var_dump($response);exit;

		/* Return JSON Response */
			echo json_encode($response);

	}elseif($_GET['gigInqu']){

		$columnsArray_not = array('postedgiginquirymaster.gigId', 'postedgiginquirymaster.dateTime', 'postedgiginquirymaster.iLoginID', 'usermaster.sFirstName', 'usermaster.sLastName', 'postedgigsmaster.gigName');
		$paramArray_not['postedgiginquirymaster.gigManID']['='] = $currentUserID;
		$innerJoinArray_not = array(
			array('postedgigsmaster','gigId','postedgiginquirymaster','gigId'),
			array('usermaster','iLoginID','postedgiginquirymaster','iLoginID')
		);

		$getGigInquiryResults = pdoQuery('postedgiginquirymaster',$columnsArray_not,$paramArray_not,$orderByParam_not,$innerJoinArray_not,$leftJoinArray_not,$emptyArray,$emptyArray,$emptyArray);

		if( count($getGigInquiryResults) > 0 ){
	    	/* Reformat the age of the post */
    		foreach($getGigInquiryResults as $getNewNotificationsResults_ind => $getNewNotificationsResults_val){
    			$getGigInquiryResults[$getNewNotificationsResults_ind]['postedDate'] = ageFuntion($getNewNotificationsResults_val['dateTime']);
    		}

	    	$response['notfic_present'] = true;
	    	$response['notifications']['data'] = $getGigInquiryResults;
    		$response['notifications']['type'] = 'Gig Inquiries';
	    }else{
	    	$response['notfic_present'] = false;
	    }
		// var_dump($response);exit;

		/* Return JSON Response */
			echo json_encode($response);
	}
?>







