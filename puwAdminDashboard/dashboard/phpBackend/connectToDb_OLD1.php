<?php 
	/* puwAdminDashboard/dashboard/index.php DB connection */

	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Get Date/Time */
		$today = date_create();
		$today = date_format($today, 'Y-m-d H:i:s');
		$todayDate = date_format($today, 'Y-m-d');


    if($_POST['delete_host'] ){

        if($_POST['hostID_del'] > 0){
             
            /* Remove Host */
                $host_id = intval( trim( $_POST['hostID_del'] ) );

                $query = 'DELETE puwhostsmaster, puwhostimages, puwavailhostdays FROM puwhostsmaster 
                          INNER JOIN puwhostimages ON puwhostimages.host_id = puwhostsmaster.host_id
                          INNER JOIN puwavailhostdays ON puwavailhostdays.hostID = puwhostsmaster.host_id
                          WHERE puwhostsmaster.host_id = ?';

                try{
                    $del_host = $db->prepare($query);
                    $del_host->bindParam(1, $host_id);
                    $del_host_result = $del_host->execute(); 
                }
                catch(Exception $e){
                    echo $e; 
                }

                if($del_host_result == true){

                    $deleted_file_err = 0; 
                    $deleted_file_count = 0; 

                    /* Delete the specified applicants img folder */

                        $del_target = realpath($_SERVER['DOCUMENT_ROOT']) . '/upload/puwHostImgs/hostApplicant/hostApplicant_' . $host_id;
                        // $delFile = delFile($del_target); DONT USE 'realpath($_SERVER['DOCUMENT_ROOT'])' WITH THIS FUNCTION

                        // we actually want to delete the applicants img directory instead of individual files
                            if( file_exists($del_target) ){
                                $delDirectory = rmdir($del_target); // THIS IS NOT WORKING FOR SOME REASON
                            }
                            else{
                                $delDirectory = 'host directory does not exist';
                            }


                        var_dump($delFile);

                    // foreach($_POST['filePaths'] as $filePath){
                    //     if($delFile == true){
                    //         $deleted_file_count++; 
                    //     }
                    //     else{
                    //         $deleted_file_err++; 
                    //     }
                    // }

                    // if( $delFile == true ){
                        
                    // }
                    // else{
                    //     $confirmDel['deleted'] = true;  
                    //     // $confirmDel['filesDeleted'] = false;  
                    //     $confirmDel['filesDeleted'] = $deleted_file_count;
                    // }



                    $confirmDel['rows_deleted'] = true; 
                    $confirmDel['filesDeleted'] = $delDirectory; //$delFile;
                    
                }
                else{
                    $confirmDel['deleted'] = false;
                    $confirmDel['filesDeleted'] = 0;
                }

                echo json_encode($confirmDel);
        }
        else{
            $confirmDel['deleted'] = 'Host Id is missing';
        }
    }
    elseif($_POST['addNewEvent']){
    
        
        /* Create Vars */
            $selectedArtists = $_POST['eventArtists'];
            $_POST['dateTimeCreated'] = $today;
            $table0 = 'puweventsmaster';
            $table1 = 'puwBookedArtists';

        /* Remove unwanted elements */
            unset($_POST['addNewEvent']);
            unset($_POST['talent']);
            unset($_POST['popUpWorshipState']);
            unset($_POST['eventArtists']);
            unset($_POST['todaysDate']);
            unset($_POST['formAction']);

        /* Re-format times */
            $toDB = true;   
            $_POST['setupTime'] = changeTimeFormat($_POST['setupTime'],$toDB);
            $_POST['startTime'] = changeTimeFormat($_POST['startTime'],$toDB);
            $_POST['endTime'] = changeTimeFormat($_POST['endTime'],$toDB);
            $_POST['exitByTime'] = changeTimeFormat($_POST['exitByTime'],$toDB);

        /* Insert new events into puweventsmaster*/
            foreach($_POST as $newEventIndex => $newEvent){
                $field[] = $newEventIndex;
                $value[] = $newEvent;
            }
		/*var_dump($field);
		var_dump($value);
		exit;*/
            $newEv = $obj->insert($field,$value,$table0);
            // var_dump($newEv);
            
        if($newEv > 0){
            $insertConf['new_event_inserted'] = true;

            if( count($selectedArtists) > 0){
	            /* Insert into the puwBookedArtists table */
	                $artInsertCount = 0; 
	                foreach($selectedArtists as $selArtistID => $selArtist){
	                    $field1 = '';
	                    $value1 = '';
	                    $field1 = array('puwArtistID', 'puwEventID', 'bookedAs','dateTimeSelected');
	                    $value1 = array($selArtistID,$newEv,$selArtist,$today);
	
	                    $newArtInserted = $obj->insert($field1,$value1,$table1);
	                    // var_dump($newArtInserted);
	                    if($newArtInserted > 0 ){
	                        $artInsertCount++; 
	                    }
	                    else{
	                        $insertConf['artists_not_inserted'][] = $selArtistID;
	                    }
	                }
	
	                if( count($selectedArtists) == $artInsertCount ){
	                    $insertConf['all_artist_inserted'] = true;
	                }
	                else{
	                    $insertConf['all_artist_inserted'] = false;
	                }
	    }
	    else{
	    	$insertConf['all_artist_inserted'] = true;
	    }
        }
        else{
            $insertConf['new_event_inserted'] = false;
            $insertConf['all_artist_inserted'] = false;
        }

        echo json_encode($insertConf);
        

    }
     elseif($_POST['cancelEvent']){
        $field[] = 'cancelStatus';
        $value[] = 1; 
        $cond = 'id = ' . trim( intval($_POST['eventID']) );
        $cancelEvent =  $obj->update($field,$value,$cond,'puweventsmaster');
        
        if($cancelEvent){
            $conf['eventCanceled'] = true; 
        }
        else{
            $conf['eventCanceled'] = false; 
        }

        echo json_encode($conf);
    }
    elseif($_POST['updateEvent']){
	
        /* vars */
            $selectedArtists = $_POST['eventArtists'];
            $_POST['dateTimeUpdated'] = $today;
            $table0 = 'puweventsmaster';
            $table1 = 'puwBookedArtists';
            $e_id = $_POST['eventID'];

        /* Remove elements */
            unset($_POST['formAction']);
            unset($_POST['updateEvent']);
            unset($_POST['eventArtists']);
            unset($_POST['talent']);
            unset($_POST['popUpWorshipState']);
            unset($_POST['todaysDate']);
            unset($_POST['eventID']);

         /* Re-format times */
            $toDB = true;   
            $_POST['setupTime'] = changeTimeFormat($_POST['setupTime'],$toDB);
            $_POST['startTime'] = changeTimeFormat($_POST['startTime'],$toDB);
            $_POST['endTime'] = changeTimeFormat($_POST['endTime'],$toDB);
            $_POST['exitByTime'] = changeTimeFormat($_POST['exitByTime'],$toDB);

        /* Update the events info in puweventsmaster table */
            foreach($_POST as $newEventIndex => $newEvent){
                $field[] = $newEventIndex;
                $value[] = $newEvent;
            }
            //var_dump($field); 
            //var_dump($value);

            
            $cond = 'id = ' . $e_id;
            $updateEvent = $obj->update($field,$value,$cond,$table0);
	    //var_dump($updateEvent);
	    
        /* Remove and re-insert artists booked for this gig */
            if($updateEvent){
                 $insertConf['new_event_updated'] = true;

                /* Remove all artists associated with current event */
                    $cond1 = 'puwEventID = ' . $e_id;
                    $delArtists = $obj->delete($table1,$cond1);

                /* Insert into the puwBookedArtists table */
                    $artInsertCount = 0; 
                    foreach($selectedArtists as $selArtistID => $selArtist){
                        $field1 = '';
                        $value1 = '';
                        $field1 = array('puwArtistID', 'puwEventID', 'bookedAs','dateTimeSelected');
                        $value1 = array($selArtistID,$e_id,$selArtist,$today);

                        $newArtInserted = $obj->insert($field1,$value1,$table1);
                        
                        if($newArtInserted > 0 ){
                            $artInsertCount++; 
                        }
                        else{
                            $insertConf['artists_not_inserted'][] = $selArtistID;
                        }
                    }

                    if( count($selectedArtists) == $artInsertCount ){
                        $insertConf['all_artist_updated'] = true;
                    }
                    else{
                        $insertConf['all_artist_updated'] = false;
                    }
            }
            else{
                 $insertConf['new_event_updated'] = false;
            }

            /* Return JSON Response */
                echo json_encode( $insertConf );
    }
    elseif($_POST['getAttendees'] || $_POST['adminAction']){

        if($_POST['adminAction']){

            /* Define Vars */
                $status = explode(',',$_POST['status']);
                $eventID = $_POST['event'];
                $table = 'puwattendeemaster';
                $cond = 'id = ' . $_POST['id'];
                $action = $_POST['action'];
                
                if($action == 'cancelAttendee'){
                    $_POST['canceled'] = 1; 
                    $_POST['cancelDate'] = $today; 
                }
                else{
                    $_POST['selectedToAttend'] = 1; 
                    $_POST['standBy'] = 0; 
                    $_POST['dateSelected'] = $today; 
                }

            /* Remove elements */
                unset($_POST['adminAction']);
                unset($_POST['action']);
                unset($_POST['event']);
                unset($_POST['id']);
                unset($_POST['status']);

            /* Update table */
                foreach($_POST as $index => $postVal){
                    $field[] = $index; 
                    $value[] = trim($postVal);
                }
                $updateAttendee = $obj->update($field,$value,$cond,$table);

            /* JSON Response*/
                if($updateAttendee){
                    $responseObj['adminAction'] = true; 
                }
                else{
                    $responseObj['adminAction'] = false;    
                }

            /* Post Vars to pass to the next section */
                $_POST['attendeeStatus'] = $status;
                $_POST['event'] = $eventID;
        }

         /* Get Event Attendees */
            $table = 'puwattendeemaster';

            $query = 'SELECT puwattendeemaster.*, puweventsmaster.date
                      FROM puwattendeemaster
                      INNER JOIN puweventsmaster ON puweventsmaster.id = puwattendeemaster.eventID
                      WHERE puwattendeemaster.eventID = :eventID';

            if($_POST['attendeeStatus'][0] !== 'allAttendees'){
                $query .= ' AND (';

                $statusCount = count($_POST['attendeeStatus']);
                for($i=0; $i<$statusCount; $i++){
                    if($i == $statusCount - 1){
                        $query .= 'puwattendeemaster.'.$_POST['attendeeStatus'][$i] .' = 1)';   
                    }
                    else{
                        $query .= 'puwattendeemaster.'.$_POST['attendeeStatus'][$i] . ' = 1 OR ';   
                    }
                }
            }
            
            try{
                $getAtt = $db->prepare($query);
                $getAtt->bindParam(':eventID',$_POST['event']);
                $getAtt->execute(); 

                $getAttResults = $getAtt->fetchAll(PDO::FETCH_ASSOC);

                
                /* format elements */
                    foreach($getAttResults as $resultIndex => $result){
                        $formatDate = date_create($result['date']);
                        $formatDate = date_format($formatDate, 'm/d/Y');
                        $getAttResults[$resultIndex]['date'] = $formatDate;


                        /* Determine Attendee Status */
                            if( $result['standBy'] ){
                                $getAttResults[$resultIndex]['status'] = 'Stand By';
                                $getAttResults[$resultIndex]['status_hidden'] = 'standBy';
                            }
                            else{
                                if($result['canceled']){
                                    $getAttResults[$resultIndex]['status'] = 'Canceled';
                                    $getAttResults[$resultIndex]['status_hidden'] = 'canceled';
                                }
                                else{
                                    if($result['confirmedAttendance']){
                                        $getAttResults[$resultIndex]['status'] = 'Confirmed';
                                        $getAttResults[$resultIndex]['status_hidden'] = 'confirmedAttendance';
                                    }
                                    elseif($result['selectedToAttend']){
                                        $getAttResults[$resultIndex]['status'] = 'Selected to Attend';
                                        $getAttResults[$resultIndex]['status_hidden'] = 'selectedToAttend';
                                    }
                                }
                            }

                        /* Recycle the originally queried attendee status */
                            $getAttResults[$resultIndex]['orig_status_query'] = $_POST['attendeeStatus'];
                    }

                /* Send JSON Response */
                    if( count($getAttResults) > 0){
                        $responseObj['attendees'] = $getAttResults;
                    }
                    else{
                        $responseObj['attendees'] = false; 
                    }
                    echo json_encode($responseObj);
            }
            catch(Exception $e){
                echo $e; 
            }
    }
    elseif($_POST['email_type']){
       
        $puwSection = 'LA';

        if($_POST['email_type'] == 'email-selected'){

            /***************************************
            *** Send Selected Attendees Emails 
            ***************************************/

                /* Get All selected attendees matching the event id */
                    $paramArray['eventID']['='] = trim( $_POST['eventID'] );
                    $paramArray['selectedToAttend']['='] = 1; 
                    $paramArray['canceled']['='] = 0; 
                    $innerJoinArray = array(
                        array('puweventsmaster','id','puwattendeemaster','eventID')
                    );
                    $columnsArray = array('puwattendeemaster.*','puweventsmaster.date','puweventsmaster.startTime','puweventsmaster.endTime');
                    $get_selected_attendees = pdoQuery('puwattendeemaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
		//var_dump($get_selected_attendees);
     exit;
                if( count( $get_selected_attendees) > 0){
                    /* Loop through array and send selected attendee emails */
                        foreach($get_selected_attendees as $selected_attendees_index => $selected_attendees_value){
                            
                            /* Reformat date and time */
                                // Date 
                                    $newDate = date_create($selected_attendees_value['date']);
                                    $selected_attendees_value['date'] = date_format($newDate, 'D M j, Y');
                                
                                // Time
                                    $selected_attendees_value['startTime'] = changeTimeFormat($selected_attendees_value['startTime'],false);
                                    $selected_attendees_value['endTime'] = changeTimeFormat($selected_attendees_value['endTime'],false);

                            /* Call email function */   
                                $sendEmail = $puwMail->selectedAttendees($selected_attendees_value,$puwSection);

                                //var_dump($sendEmail);
                        }
                }
                else{
                    $conf['emails_sent'] = false;
                    $conf['attendees_retrieved'] = false;
                }
            /***************************************
            *** END - Send Selected Attendees Emails 
            **************************************/
        }
        elseif($_POST['email_type'] == 'email-standby'){
            /***************************************
            *** Send Stand-by Attendees Emails 
            ***************************************/
                /* Send Stand-By Attendees Emails */
                    $paramArray['eventID']['='] = trim( $_POST['eventID'] );
                    $paramArray['standBy']['='] = 1; 
                    $paramArray['canceled']['='] = 0; 
                    $innerJoinArray = array(
                        array('puweventsmaster','id','puwattendeemaster','eventID')
                    );
                    $columnsArray = array('puwattendeemaster.*','puweventsmaster.date','puweventsmaster.startTime','puweventsmaster.endTime');
                    $get_standby_attendees = pdoQuery('puwattendeemaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
		//var_dump($get_standby_attendees);
//       exit;
                if( count( $get_standby_attendees) > 0){

                    /* Loop through array and send selected attendee emails */
                        foreach($get_standby_attendees as $selected_attendees_index => $selected_attendees_value){
                            
                            /* Reformat date and time */
                                // Date 
                                    $newDate = date_create($selected_attendees_value['date']);
                                    $selected_attendees_value['date'] = date_format($newDate, 'D M j, Y');
                                
                                // Time
                                    $selected_attendees_value['startTime'] = changeTimeFormat($selected_attendees_value['startTime'],false);
                                    $selected_attendees_value['endTime'] = changeTimeFormat($selected_attendees_value['endTime'],false);

                            /* Call email function */   
                                $sendEmail = $puwMail->standbyAttendees($selected_attendees_value,$puwSection);

                                var_dump($sendEmail);
                        }
                }
                else{
                    $conf['emails_sent'] = false;
                    $conf['attendees_retrieved'] = false;
                }
            /***************************************
            *** END - Send Stand-by Attendees Emails 
            ***************************************/
        }
        elseif($_POST['email_type'] == 'email-puwLocation'){
            /***************************************
            *** Send popupworship location Emails 
            ***************************************/
 
                /* Retrieve All selected attendees matching the event id - Send puw location */
                    $paramArray['eventID']['='] = trim( $_POST['eventID'] );
                    $paramArray['canceled']['='] = 0; 
                     $paramArray['location_sent']['='] = 0; 
                    $innerJoinArray = array(
                        array('puweventsmaster','id','puwattendeemaster','eventID'),
                        array('puwhostsmaster','host_id','puweventsmaster','hostID'),
                        array('states','id','puwhostsmaster','host_state')
                    );
                    $columnsArray = array('puwattendeemaster.*','puweventsmaster.date','puweventsmaster.startTime','puweventsmaster.endTime','puwhostsmaster.host_address','puwhostsmaster.host_sCityName','puwhostsmaster.host_zip','states.statecode');
                    $get_all_attendees = pdoQuery('puwattendeemaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
                    //var_dump($get_all_attendees);
                    
                    if( count( $get_all_attendees) > 0){
                        /* Loop through array and send selected attendee emails */
                            foreach($get_all_attendees as $selected_attendees_index => $selected_attendees_value){
                                /* Reformat date and time */
                                    // Date 
                                        $newDate = date_create($selected_attendees_value['date']);
                                        $selected_attendees_value['date'] = date_format($newDate, 'D M j, Y');
                                    
                                    // Time
                                        $selected_attendees_value['startTime'] = changeTimeFormat($selected_attendees_value['startTime'],false);
                                        $selected_attendees_value['endTime'] = changeTimeFormat($selected_attendees_value['endTime'],false);

                                    // Capitalize Attendee Names
					$selected_attendees_value['fName'] = ucfirst( $selected_attendees_value['fName'] );
					$selected_attendees_value['lName'] = ucfirst( $selected_attendees_value['lName'] );

                                /* Call email function */   
                                    $sendEmail = $puwMail->sendPuwLocation($selected_attendees_value,$puwSection);
                                    //var_dump($sendEmail);
                                    if($sendEmail['postmarkApiErrorCode'] > 0){
                                    	$conf['invalid_email'][] = $selected_attendees_value['email'];
                                    }
                                    else{
                                    	$conf['email_sent'][] = $selected_attendees_value['email'];
                                    }
                            }
                            
                            if( count($conf['invalid_email']) > 0 ){
                            	$conf['email_err']['present'] = true;
                            }
                            else{
                            	$conf['email_err']['present'] = false;
                            }
                            
                            if( count($conf['email_sent']) == count( $get_all_attendees ) ){
                            	$conf['all_emails_sent'] = true;
                            }
                            else{
	                        $conf['all_emails_sent'] = false;
                            }
                    }
                    else{
                        $conf['emails_sent'] = false;
                        $conf['attendees_retrieved'] = false;
                    }
            /***************************************
            *** END - Send popupworship location Emails 
            ***************************************/
        }
        
        /* Send JSON Response */
        	echo json_encode($conf); 
    }



	if($_GET){

        if($_GET['fetchEvent'] > 0){

            /* Fetch the requested event info */
                $eventID = trim( removeAlphaNumChars($_GET['fetchEvent']) );
                $paramArray['id']['='] = $eventID;
                // $innerJoinArray = array(
                //         array('puwhostsmaster','host_id','puweventsmaster','hostID')
                //     );
                $getEvent =  pdoQuery('puweventsmaster','all',$paramArray,$orderByParam1,$innerJoinArray);
                // var_dump($getEvent);
                if( count($getEvent) > 0 ){
                    $eventConf['eventInfo'] = $getEvent;
                }
                else{
                    $eventConf['info'] = false;
                }

            /* Fetch Host Info */
                $table0 = 'puwhostsmaster';
                $host_id = $getEvent[0]['hostID'];
                $paramArray0['puwhostsmaster.host_id']['='] = $host_id;
                 $innerJoinArray0 = array(
                    array("puwhostimages","host_id","puwhostsmaster","host_id"),
                    array('states','id','puwhostsmaster','host_state'),
                    array("puwavailhostdays","hostID","puwhostsmaster","host_id"),
                );

                $orderByParam0 = 'puwhostsmaster.host_sCityName';
                $columnsArray0 = array('states.*,puwhostsmaster.*,puwhostimages.file_path,puwavailhostdays.day');
                $getHost = pdoQuery($table0,$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0);
                
                if( count($getHost) > 0){
                    /* Organize the hosts by id and remove redundant values */
                        foreach($getHost as $index => $host){
                            $hostID = $host['host_id'];
                            $organizeHosts[$host['host_id']]['file_paths'][] = $host['file_path'];
                            $organizeHosts[$host['host_id']]['days'][] = $host['day'];
                            unset($host['file_path']);
                            unset($host['day']);
                            $organizeHosts[$host['host_id']]['info'] = $host;

                        }
                        foreach($organizeHosts as $indexHost => $host1){
                            foreach($host1 as $indexHostDeets => $host2){
                                $reOrganizeHosts[$indexHost][$indexHostDeets] = array_unique($host2);
                            }
                        }

                    /* Re-format values */
                        foreach($reOrganizeHosts as $indexReOrg => $reOrganizeHost){
                            $reOrganizeHosts[$indexReOrg]['info']['startTime'] = changeTimeFormat($reOrganizeHost['info']['startTime']);
                            $reOrganizeHosts[$indexReOrg]['info']['endTime'] = changeTimeFormat($reOrganizeHost['info']['endTime']);
                            $reOrganizeHosts[$indexReOrg]['info']['host_phone'] = phoneNumbDisplay( $reOrganizeHost['info']['host_phone'] ); 
                            if( $reOrganizeHost['info']['hCapAccessible'] ){
                                $reOrganizeHosts[$indexReOrg]['info']['hCapAccessible'] = 'Yes';
                            }
                            else{
                                $reOrganizeHosts[$indexReOrg]['info']['hCapAccessible'] = 'No';
                            }
                        }

                        foreach($reOrganizeHosts as $reOrgedHost){
                            $reReOrganizeHosts[] = $reOrgedHost;
                        }
                }
                else{
                    $reReOrganizeHosts[0]['info']['host_id'] = 0; 
                }
                $eventConf['hostInfo'] = $reReOrganizeHosts;
                // var_dump($reReOrganizeHosts);


            /* Fetch selected artist, if any, for requested event*/
                $paramArray1['puwEventID']['='] = $eventID;
                $innerJoinArray1 = array(
                        array('usermaster','iLoginID','puwBookedArtists','puwArtistID')
                    );
                $columnsArray = array('puwBookedArtists.*','usermaster.sFirstName','usermaster.dDOB');
                $getArtists =  pdoQuery('puwBookedArtists',$columnsArray,$paramArray1,$orderByParam1,$innerJoinArray1);
                // var_dump($getArtists);
                /* Calculate artist's age */
                    foreach($getArtists as $artistIndex => $artist){
                        $getArtists[$artistIndex]['talent'] = str_replace("_","/", $artist['talent']);
                        $getArtists[$artistIndex]['age'] =  getAge( $artist['dDOB'] );
                    }
                    
                if( count($getArtists) > 0 ){
                    $eventConf['artistsInfo'] = $getArtists;
                }
                else{
                    $eventConf['artistsInfo'] = false; 
                }
                // var_dump($eventConf);
            /* Return JSON response */
                echo json_encode($eventConf);

        }
        elseif($_GET['host_info'] > 0 ){

            /* Get the host information */
                $innerJoinArray1 = array(
                    array("states","id","puwhostsmaster","host_state"),
                    array("puwhostimages","host_id","puwhostsmaster","host_id"),
                    array('puwavailhostdays','hostID',"puwhostsmaster","host_id")
                );
                $paramArray['puwhostsmaster.host_id']['='] = trim( $_GET['host_info'] );
                $allHosts =  pdoQuery('puwhostsmaster','all',$paramArray,$orderByParam1,$innerJoinArray1);
                $hostCount = count($allHosts);

            /* Return JSON Response */
                if($hostCount > 0){
                    /* Reformat the returned array */
                        foreach($allHosts as $host){
                            $filePaths[] = $host['file_path'];
                            $availDays[] = $host['day'];
                        }

                        $allHosts = $allHosts[0];
                        unset($allHosts['file_path']);
                        unset($allHosts['day']);
                        $allHosts['days'] = array_unique( $availDays );
                        $allHosts['file_paths'] = array_unique( $filePaths );
                        
                    /* Reformat data */
                        $allHosts['host_phone'] = phoneNumbDisplay($allHosts['host_phone']);
                        $allHosts['startTime'] =  changeTimeFormat( $allHosts['startTime'] );
                        $allHosts['endTime'] = changeTimeFormat( $allHosts['endTime'] );

                    $allHosts['host_available'] = true; 
                }
                else{
                    $allHosts['host_available'] = false; 
                }
                echo json_encode($allHosts);
        }
        elseif( $_GET['get_hosts_in_state'] || $_GET['get_host_by_id'] ){
            
            /* Get Hosts in this city */
                if($_GET['get_hosts_in_state']){
                    $table = 'states';
                    $state = trim( removeAlphaNumChars($_GET['state']) );
                    $paramArray['states.name']['='] = $state;
                    $innerJoinArray = array(
                        array('puwhostsmaster','host_state','states','id'),
                        array("puwhostimages","host_id","puwhostsmaster","host_id"),
                        array("puwavailhostdays","hostID","puwhostsmaster","host_id"),
                    );
                }
                elseif($_GET['get_host_by_id']){
                    $table = 'puwhostsmaster';
                    $host_id = trim( removeAlphaNumChars($_GET['host_id']) );
                    $paramArray['puwhostsmaster.host_id']['='] = $host_id;
                     $innerJoinArray = array(
                        array("puwhostimages","host_id","puwhostsmaster","host_id"),
                        array('states','id','puwhostsmaster','host_state'),
                        array("puwavailhostdays","hostID","puwhostsmaster","host_id"),
                    );
                }
                
                $orderByParam = 'puwhostsmaster.host_sCityName';
                $columnsArray = array('states.*,puwhostsmaster.*,puwhostimages.file_path,puwavailhostdays.day');
                $getHost = pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
                
                if( count($getHost) > 0){
                    /* Organize the hosts by id and remove redundant values */
                        foreach($getHost as $index => $host){
                            $hostID = $host['host_id'];
                            $organizeHosts[$host['host_id']]['file_paths'][] = $host['file_path'];
                            $organizeHosts[$host['host_id']]['days'][] = $host['day'];
                            unset($host['file_path']);
                            unset($host['day']);
                            $organizeHosts[$host['host_id']]['info'] = $host;

                        }
                        foreach($organizeHosts as $indexHost => $host1){
                            foreach($host1 as $indexHostDeets => $host2){
                                $reOrganizeHosts[$indexHost][$indexHostDeets] = array_unique($host2);
                            }
                        }

                    /* Re-format values */
                        foreach($reOrganizeHosts as $indexReOrg => $reOrganizeHost){
                            $reOrganizeHosts[$indexReOrg]['info']['startTime'] = changeTimeFormat($reOrganizeHost['info']['startTime']);
                            $reOrganizeHosts[$indexReOrg]['info']['endTime'] = changeTimeFormat($reOrganizeHost['info']['endTime']);
                            $reOrganizeHosts[$indexReOrg]['info']['host_phone'] = phoneNumbDisplay( $reOrganizeHost['info']['host_phone'] ); 
                            if( $reOrganizeHost['info']['hCapAccessible'] ){
                                $reOrganizeHosts[$indexReOrg]['info']['hCapAccessible'] = 'Yes';
                            }
                            else{
                                $reOrganizeHosts[$indexReOrg]['info']['hCapAccessible'] = 'No';
                            }
                        }

                        foreach($reOrganizeHosts as $reOrgedHost){
                            $reReOrganizeHosts[] = $reOrgedHost;
                        }
                }
                else{
                    $reReOrganizeHosts[0]['info']['host_id'] = 0; 
                }

                /* Return JSON respsonse */
                    echo json_encode($reReOrganizeHosts);
        }
        elseif($_GET['get_artists_by_state']){
		
            /* Get artists in the specified state */
                $table = 'puwartistmaster';
                $columnsArray = array('puwartistmaster.*','usermaster.*,talentmaster.talent');
                $paramArray['popUpWorshipCity']['='] =  trim( removeAlphaNumChars($_GET['state']) );
                $paramArray['talentmaster.TalentID']['='] = trim( removeAlphaNumChars($_GET['talent_id']) );
                $innerJoinArray = array(
                        array('usermaster','iLoginID','puwartistmaster','iLoginID'),
                        array('talentmaster','iLoginID','puwartistmaster','iLoginID')
                    );
                $getArtists = pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
		
                foreach($getArtists as $artistIndex => $artist){
                    $getArtists[$artistIndex]['talent'] = str_replace("_","/", $artist['talent']);
                    $getArtists[$artistIndex]['age'] =  getAge( $artist['dDOB'] );
                }

                if( count($getArtists) > 0){
                    echo json_encode($getArtists);
                }
                else{
                    $getArtists[0]['id'] = 0; 
                    echo json_encode($getArtists);
                }
        }
        else{

            $eventID = intval( trim( $_GET['eventID'] ) );

            /* Get Events */
                $columnsArray = array('puweventsmaster.*','puwhostsmaster.*','states.*'); //'puwhostsmaster.environment','puwhostsmaster.buildingType','puwhostsmaster.host_fname','puwhostsmaster.host_lname','puwhostsmaster.host_email','puwhostsmaster.host_phone','puwhostsmaster.host_address','puwhostsmaster.host_state','puwhostsmaster.host_zip','puwhostsmaster.noiseRestrictions','puwhostsmaster.addedInfo','puwhostsmaster.hCapAccessible', 'puwhostsmaster.host_sCityName','puwhostsmaster.capacity', 
                $innerJoinArray = array(
                    array("puwhostsmaster","host_id","puweventsmaster","hostID"),
                    array("states","id","puwhostsmaster","host_state")
                );
                $paramArray['date']['>'] = $today;
                $paramArray['puweventsmaster.id']['='] = $eventID;
                $orderByParam = 'date';
                $allEvents =  pdoQuery(' puweventsmaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
                $eventCount = count($allEvents);

            /* Get Artists for current event */
                $columnsArray0 = array('puwBookedArtists.*','usermaster.sFirstName','usermaster.sContactEmailID','usermaster.sContactNumber');
                $innerJoinArray0 = array(
                    array("puwartistmaster","id","puwBookedArtists","puwArtistID"),
                    array("usermaster","iLoginID","puwartistmaster","iLoginID"),
                );
                $paramArray0['puwBookedArtists.puwEventID']['='] = $eventID;
                $eventArtists =  pdoQuery(' puwBookedArtists',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0);
                if( count($eventArtists) == 0 ){
                    $eventArtists = false; 
                }

            /* Get Attendees for current event */
                $columnsArray1 = array('puwattendeemaster.*');
                $paramArray1['confirmedAttendance']['='] = true;
                $paramArray1['eventID']['='] = $eventID;
                $orderByParam1 = 'dateConfirmed';
                $eventAttendees =  pdoQuery('puwattendeemaster',$columnsArray1,$paramArray1,$orderByParam1);
                if( count($allEvents) == 0 ){
                    $eventAttendees = false; 
                }

            /* Hyphenate host phone # */
                foreach( $allEvents as $i => $event ){
                    $allEvents[$i]['host_phone'] = phoneNumbDisplay( $event['host_phone'] );
                }

                foreach( $eventArtists as $i1 => $artist ){
                     $eventArtists[$i1]['sContactNumber'] = phoneNumbDisplay( $artist['sContactNumber'] );
                }

            /* Change time formats */
                $setUpTime = date_create($allEvents[0]['setupTime']);
                $allEvents[0]['setupTime'] = date_format($setUpTime, 'h:i A');

                $startTime = date_create($allEvents[0]['startTime']);
                $allEvents[0]['startTime'] = date_format($startTime, 'h:i A');

                $endTime = date_create($allEvents[0]['endTime']);
                $allEvents[0]['endTime'] = date_format($endTime, 'h:i A');

                $exitByTime = date_create($allEvents[0]['exitByTime']);
                $allEvents[0]['exitByTime'] = date_format($exitByTime, 'h:i A');
                    

            /* Add attendee array to the all events array */
                array_push($allEvents, $eventAttendees, $eventArtists);
                echo json_encode($allEvents);
        }

	}

?>