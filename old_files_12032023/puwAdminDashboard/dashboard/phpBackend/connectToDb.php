<?php 
	/* puwAdminDashboard/dashboard/index.php DB connection */

	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/phpBackend/newEventPhpFunct.php');

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
         //var_dump($_POST);exit;
        
        /* Create Vars */
            $selectedArtists = $_POST['selectedArtists'];
            foreach($_POST['event_pay'] as $ev_pay_index => $ev_pay_val){
                $eventPay[$ev_pay_index] = dollarsToCents($ev_pay_val);
            }
            $_POST['dateTimeCreated'] = $today;
            $table0 = 'puweventsmaster';
            $table1 = 'eventartists';
            $table2= 'eventartistspay';

        /* Remove unwanted elements */
            unset($_POST['addNewEvent']);
            unset($_POST['talent']);
            unset($_POST['popUpWorshipState']);
            unset($_POST['selectedArtists']);
            unset($_POST['todaysDate']);
            unset($_POST['formAction']);
            unset($_POST['event_pay']);
            unset($_POST['remove_artist']);

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
            //var_dump($field);var_dump($value);
            
            $newEv = pdoInsert($db,$field,$value,'puweventsmaster');

             //var_dump($newEv);exit;

           
        if($newEv > 0){
            $insertConf['new_event_inserted'] = true;

            /* Insert into the eventartists and eventartistpay tables and send artist confirmation emails */
                $artistHandler = newArtistHandler($db,$_POST['eventID'],$selectedArtists,$puwMail,$today,$eventPay);
                $insertConf = array_merge($insertConf, $artistHandler);
        }
        else{
            $insertConf['new_event_inserted'] = false;
        }

        /* Return JSON Response */
            echo json_encode($insertConf);
        

    }
    elseif($_POST['updateEvent']){
              //var_dump($_POST);exit;
        /* vars */
            $selectedArtists = $_POST['selectedArtists'];
            $removedArtists = $_POST['remove_artist'];
            $_POST['dateTimeUpdated'] = $today;
            foreach($_POST['event_pay'] as $ev_pay_index => $ev_pay_val){
                $eventPay[$ev_pay_index] = dollarsToCents($ev_pay_val);
            }
            $table0 = 'puweventsmaster';
            $table1 = 'eventartists';
            $table2 = 'eventartistspay';
            $e_id = $_POST['eventID'];

        /* Remove elements */
            unset($_POST['formAction']);
            unset($_POST['updateEvent']);
            unset($_POST['eventArtists']);
            unset($_POST['selectedArtists']);
            unset($_POST['remove_artist']);
            unset($_POST['talent']);
            unset($_POST['popUpWorshipState']);
            unset($_POST['todaysDate']);
            unset($_POST['eventID']);
            unset($_POST['event_pay']);

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
           
            $cond = 'id = ' . $e_id;
            	 
            $updateEvent = updateTable($db, $_POST, $cond, $table0);

	   
        /**** Remove artists no longer booked - Insert newly selected artists for this gig ****/
            if($updateEvent){
                 $insertConf['new_event_inserted'] = true;

                /**** Remove artists no longer booked for this gig ****/
                    $rem_art_count = count($removedArtists);
                    if( $rem_art_count > 0 ){
                        $rem_art_counter = 1; 
                        $cond1 = 'gigId = "' . $e_id . '" AND (';

                        foreach($removedArtists as $removedArtists_index => $removedArtists_value){
                            if($rem_art_counter == $rem_art_count){
                                $cond1 .= 'iLoginid = ' . $removedArtists_value . ')';
                            }
                            else{
                                $cond1 .= 'iLoginid = ' . $removedArtists_value . ' OR ';
                            }
                            $rem_art_counter++;
                        }
                        $delArtists = pdoDelete($db,$cond1, $table1);

                        if($delArtists){
                            $insertConf['all_artist_removed'] = true;
                            
                            $delArtistsPay = pdoDelete($db,$cond1, $table2);
                            if($delArtistsPay){
                                $insertConf['all_artistPay_removed'] = true;
                            }
                            else{
                                $insertConf['all_artistPay_removed'] = false;
                            }
                        }else{
                            $insertConf['all_artist_removed'] = false;
                        }
                    }
		/* END - Remove artists no longer booked for this gig */

                /* Insert into the eventartists and eventartistpay tables and send artist confirmation emails */
                    $artistHandler = newArtistHandler($db,$e_id,$selectedArtists,$puwMail,$today,$eventPay);
                    $insertConf = array_merge($insertConf, $artistHandler);
            }
            else{
                 $insertConf['new_event_inserted'] = false;
            }

            /* Return JSON Response */
                echo json_encode( $insertConf );
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
    elseif($_POST['approve_artist_id']){
        /* update puwartistmaster */
            $field[] = 'approved'; 
            $value[] = 1; 
            $cond = 'iLoginID = ' . $_POST['approve_artist_id'];
            $table = 'puwartistmaster';
            $approveArtist =  $obj->update($field,$value,$cond,$table);

            if($approveArtist){
                $confApproval['approved'] = $approveArtist;
            }
            else{
                $confApproval['approved'] = false;
            }
            echo json_encode($confApproval);
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
                                    else{
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
         
        /* Common Vars */
            $puwSection = 'LA';
            // $paramArray['eventID']['='] = trim( $_POST['eventID'] );
            // $paramArray['canceled']['='] = 0; 
            $recipient_array = $_POST['email_recipient'];
            $recipient_count = count($recipient_array);
            $recipient_count_tracker = 1;
            $e_id = trim( $_POST['eventID'] ); 
        
        if( $recipient_count > 0 ){
            if($_POST['email_type'] == 'Attendee-Selected' || $_POST['email_type'] == 'Attendee-StandBy' || $_POST['email_type'] == 'Event-Location'){
                // var_dump($_POST);
                // exit;
                /***************************************
                *** Send Selected Attendees Emails 
                ***************************************/
                    /* Get All selected attendees matching the event id */
                        // if($_POST['email_type'] == 'Attendee-Selected'){
                        //     $paramArray['selectedToAttend']['='] = 1; 
                        // }
                        // elseif($_POST['email_type'] == 'Attendee-StandBy'){
                        //     $paramArray['standBy']['='] = 1; 
                        // }
                       
                        // $innerJoinArray = array(
                        //     array('puweventsmaster','id','puwattendeemaster','eventID')
                        // );
                        // $columnsArray = array('puwattendeemaster.*','puweventsmaster.date','puweventsmaster.startTime','puweventsmaster.endTime');
                        // $get_attendees = pdoQuery('puwattendeemaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);

                        // $paramArray['location_sent']['='] = 0; 
                        // $innerJoinArray = array(
                        //     array('puweventsmaster','id','puwattendeemaster','eventID'),
                        //     array('puwhostsmaster','host_id','puweventsmaster','hostID'),
                        //     array('states','id','puwhostsmaster','host_state')
                        // );
                        //  $columnsArray = array('puwattendeemaster.*','puweventsmaster.date','puweventsmaster.startTime','puweventsmaster.endTime','puwhostsmaster.host_address','puwhostsmaster.host_sCityName','puwhostsmaster.host_zip','states.statecode');


                    /* Create Query */
                        $get_attendees_query = 'SELECT puwattendeemaster.*,puweventsmaster.date,puweventsmaster.startTime,puweventsmaster.endTime';
                        
                        // For Location email
                        if($_POST['email_type'] == 'Event-Location'){
                           $get_attendees_query .= ',puwhostsmaster.host_address,puwhostsmaster.host_sCityName,puwhostsmaster.host_zip,states.statecode'; 
                        }

                        $get_attendees_query .= ' FROM puwattendeemaster
                                                 INNER JOIN puweventsmaster ON puweventsmaster.id = puwattendeemaster.eventID';
                        
                        // For Location email
                        if($_POST['email_type'] == 'Event-Location'){
                            $get_attendees_query .= ' INNER JOIN puwhostsmaster ON puwhostsmaster.host_id = puweventsmaster.hostID
                                                     INNER JOIN states ON states.id = puwhostsmaster.host_state';
                        }

                        $get_attendees_query .= ' WHERE canceled = 0 AND eventID = :eventID AND';

                        // For Location email
                        if($_POST['email_type'] == 'Event-Location'){
                            $get_attendees_query .= ' location_sent = 0 AND';
                        }

                        foreach($recipient_array as $recipient_array_value){
                            if( $recipient_count_tracker == $recipient_count){
                                $get_attendees_query .= ' puwattendeemaster.id = :' . $recipient_array_value; 
                            }
                            else{
                                $get_attendees_query .= ' puwattendeemaster.id = :' . $recipient_array_value . ' OR'; 
                            }
                            
                            /* Create bind params */
                                $bParam[] = ':' . $recipient_array_value . ',' . $recipient_array_value; //str_replace('.','',)

                            $recipient_count_tracker++;
                        }
                    
                    
                    /* Try/Catch block to fetch data */
                        try{
                            $get_attendees_pdo = $db->prepare($get_attendees_query);
                            $get_attendees_pdo->bindParam(':eventID', $e_id);
                            foreach($bParam as $param){
                                $bParam2 = explode(',', $param);
                                $get_attendees_pdo->bindParam($bParam2[0], $bParam2[1]);
                            }

                            $get_attendees_pdo->execute(); 
                            $get_attendees_results = $get_attendees_pdo->fetchAll(PDO::FETCH_ASSOC);
                        }
                        catch(Exception $e){
                            echo $response['err'] = $e; 
                        }


                    if( count( $get_attendees_results) > 0){
                        /* Loop through array and send selected attendee emails */
                            $sent_email_count = 0; 
                            foreach($get_attendees_results as $get_attendees_index => $get_attendees_value){
                                // var_dump($get_attendees_value);
                                // exit;
                                /* Reformat date and time */
                                    // Date 
                                        $newDate = date_create($get_attendees_value['date']);
                                        $get_attendees_value['date'] = date_format($newDate, 'D M j, Y');
                                    
                                    // Time
                                        $get_attendees_value['startTime'] = changeTimeFormat($get_attendees_value['startTime'],false);
                                        $get_attendees_value['endTime'] = changeTimeFormat($get_attendees_value['endTime'],false);

                                /* Call email function */ 
                                    if($_POST['email_type'] == 'Attendee-Selected'){
                                        $sendEmail = $puwMail->selectedAttendees($get_attendees_value,$puwSection);
                                    }
                                    elseif($_POST['email_type'] == 'Attendee-StandBy'){
                                        $sendEmail = $puwMail->standbyAttendees($get_attendees_value,$puwSection);
                                    }
                                    elseif($_POST['email_type'] == 'Event-Location'){
                                        $sendEmail = $puwMail->sendPuwLocation($get_attendees_value,$puwSection);
                                    }

                                    if( $sendEmail['message'] == 'OK' ){
                                        /* Insert email status in the puwattendeemaster */
                                            $field[] = 'email_sent';
                                            $value[] = $_POST['email_type'];
                                            $cond = 'id = ' . $get_attendees_value['id'];
                                            $email_status_updated = $obj->update($field,$value,$cond,'puwattendeemaster');
                                            $sent_email_count++;
                                    }
                                    $conf['recipients'][ $get_attendees_value['email'] ]['err_code'] = $sendEmail['errorcode'];
                                    $conf['recipients'][ $get_attendees_value['email'] ]['mess_ok'] = $sendEmail['message'];
                            }
                             
                            if( $recipient_count == $sent_email_count ){
                                $conf['all_emails_sent'] = true;
                            }
                            else{
                                $conf['all_emails_sent'] = false;
                            }

                            /* Return JSON Response */
                                echo json_encode($conf);
                    }
                    else{
                        $conf['emails_sent'] = false;
                        $conf['attendees_retrieved'] = false;
                    }
                /***************************************
                *** END - Send Selected Attendees Emails 
                **************************************/
            }
           
        }
        else{
            $conf['emails_sent'] = false;
            $conf['attendees_retrieved'] = false;
            $conf['err_mess'] = 'no_recipients';
        }
    }

    /*****************************
    *** Fetch artist for PUW Event
    *****************************/
    elseif($_POST['getArtists']){

        /* fetch puw event artists */
            $table = 'eventartists';
            $paramArray['eventartists.gigId']['='] = $_POST['event'];
            $columnsArray = array('eventartists.*','usermaster.sFirstName','usermaster.sLastName','usermaster.sProfileName','usermaster.dDOB','usermaster.sCityName','states.statecode','usermaster.iZipcode','usermaster.sContactEmailID','usermaster.sContactNumber','giftmaster.sGiftName');//
            $innerJoinArray = array(
                array('usermaster','iLoginID','eventartists','iLoginid'),
                array('states','id','usermaster','sStateName'),
                array('giftmaster','iGiftID','eventartists','artistType'),
               
            );
            $orderByParam = 'usermaster.sFirstName';
            $get_artists = pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$leftJoinArray);

            if( count($get_artists) > 0 ){
                /* Re-format values */
                    foreach($get_artists as $get_artists_index => $get_artists_value){
                        /* Get artists transactions */

                            $paramArray1['eventartists.gigId']['='] = $_POST['event'];
                            $paramArray1['eventartists.iLoginid']['='] = $get_artists_value['iLoginid'];
                            $columnsArray1 = array('eventartistspay.*');//.depositamount','eventartistspay.depositDateTime','eventartistspay.transactionType');
                            $innerJoinArray1 = array(
                                array('eventartistspay','tal_tracker_id','eventartists','tal_tracker_id')
                            );
                            $orderByParam1 = 'eventartistspay.depositDateTime DESC';
                            $get_artists_transactions = pdoQuery($table,$columnsArray1,$paramArray1,$orderByParam1,$innerJoinArray1,$leftJoinArray1);
                            
                            foreach($get_artists_transactions as $get_artists_transactions_index => $get_artists_transactions_val){
                                
                                /* Deposit Date, Deposit Amount */
                                    $get_artists_transactions[$get_artists_transactions_index]['depositamount'] = CentsToDollars( $get_artists_transactions_val['depositamount'] );

                                    $dateTime0 = date_create($get_artists_transactions_val['depositDateTime']);
                                    $dateTime0 = date_format($dateTime0, 'D M d, Y @ h:ia');
                                    $get_artists_transactions[$get_artists_transactions_index]['depositDateTime'] = $dateTime0;
                            }

                            // var_dump($get_artists_transactions);
                            $get_artists[$get_artists_index]['recent_transactions'] = $get_artists_transactions;


                        /* Get age from DOB */
                           $get_artists[$get_artists_index]['dDOB'] =  getAge($get_artists_value['dDOB']);

                        /* Date/time selected */
                            $dateTime = date_create($get_artists_value['datetimeselected']);
                            $dateTime = date_format($dateTime, 'D M d, Y @ h:ia');
                            $get_artists[$get_artists_index]['datetimeselected'] = $dateTime;

                        /* Event pay,Deposit Date, Deposit Amount */
                            $get_artists[$get_artists_index]['event_pay_display'] = CentsToDollars( $get_artists_value['event_pay'] );
                            // $get_artists[$get_artists_index]['depositamount_display'] = CentsToDollars( $get_artists_value['depositamount'] );

                            // $dateTime1 = date_create($get_artists_value['depositDateTime']);
                            // $dateTime1 = date_format($dateTime1, 'D M d, Y @ h:ia');
                            // $get_artists[$get_artists_index]['depositDateTime'] = $dateTime1;
                        
                        /* Phone number */
                            $get_artists[$get_artists_index]['sContactNumber'] = phoneNumbDisplay($get_artists_value['sContactNumber']);

                    }

                $response['get_artists'] = $get_artists;
            }
            else{
                $response['get_artists'] = false;
            }

        /* Return JSON Response */
            echo json_encode($response);
    }

    /******************************
    *** Transfer Money to Artists
    ******************************/
    elseif($_POST['transactionType']){
        /* Check if artists has a stripe account set up */
            $columnsArray = array('str_connectActID');
            $paramArray['iLoginID']['='] = $_POST['iLoginid'];
            $get_str_acct = pdoQuery('usermaster',$columnsArray,$paramArray)[0];

        if($get_str_acct['str_connectActID'] != ''){
            /* store response val */
                $response['str_acct'] = true; 

            /* Transfer or Reverse Transfer */
                if($_POST['transactionType'] == 'transfer'){

                    /* Initiate transfer to Artist's connect acct */
                        $transfer_obj['charged_amount'] = dollarsToCents($_POST['depositamount']);
                        $transfer_obj['destination_acct'] =  $get_str_acct['str_connectActID']; 
                        $transfer_response = TransferToConnectAcct($transfer_obj);
                        // var_dump($transfer_response);

                        if( $transfer_response['id'] != ''){
                            $response['transfer_made'] = true;
                        }
                        elseif( $transfer_response['status'] !== '' ){
                            $response['transfer_made'] = false;
                            $response['trans_err'] = $transfer_response['status'];
                            $response['trans_exc'] = $transfer_response['exception'];
                        }
                        else{
                            $response['transfer_made'] = false;
                            $response['trans_err'] = 'transfer_failed';
                        }
                }
                elseif($_POST['transactionType'] == 'transfer_reversal'){
                    /* Initiate transfer-reversal from artist's connect acct */ 
                        $transfer_id  = $_POST['transfer_id'];
                        unset($_POST['transfer_id']);
                        $transfer_response = ReverseTransfer($transfer_id);
                        // var_dump($transfer_response);

                        if( $transfer_response['id'] != ''){
                            $response['transfer_made'] = true;
                        }
                        else{
                            $response['transfer_made'] = false;
                            $response['trans_err'] = 'transfer_reversal_failed';
                        }
                }
                elseif($_POST['transactionType'] == 'payout'){

                    /* Retrieve users connected account balance */
                        $get_acct_bal = RetrieveConnectAccountBalance($get_str_acct['str_connectActID']);
                        $acct_balance_available = $get_acct_bal['available'][0]['amount'];
                        // var_dump($acct_balance_available);
                        // exit;

                    /* Retrieve amount associated with transfer id */
                        $transfer_id  = $_POST['transfer_id'];
                        unset($_POST['transfer_id']);
                        $get_transfer = RetrieveTransfer($transfer_id);
                        $transfer_amount = $get_transfer['amount'];
                        // var_dump($transfer_amount);
                        // exit;
                    
                    /* If connect acct bal. >= to transfer-payout amount make payout */
                        if( $acct_balance_available >= $transfer_amount ){
                             /* Initiate connect account payout */

                                /* standard payout */
                                    $payout_obj['amount'] = $transfer_amount;
                                    $payout_obj['acct_id'] = $get_str_acct['str_connectActID'];
                                    $transfer_response = standardPayout($payout_obj);

                                    if( $transfer_response['id'] != ''){
                                        $response['transfer_made'] = true;
                                        $payout_date = unixTimeStampConversion($transfer_response['arrival_date'],true);
                                        $payout_acct_type = $transfer_response['type'];
                                        $payout_method = $transfer_response['method'];
                                    }
                                    else{
                                        $response['transfer_made'] = false;
                                        $response['trans_err'] = 'payout_failed';
                                    }
                        }
                        else{
                            $response['transfer_made'] = false;
                             $response['trans_err'] = 'balance_insufficient';
                        }

                    /* NOTE - PROVIDE USERS WITH A LIST OF BALANCE TRANSACTIONS FROM THEIR PROFILE!!!! USING THE BALANCE TRANSACTION
                              API
                    */
                }

                /* Insert new transaction into usermaster */
                    if($response['transfer_made']){
                        $_POST['transaction_id'] = $transfer_response['id']; 
                        $_POST['transactionType'] = $transfer_response['object']; 
                        $_POST['depositamount'] = $transfer_response['amount']; 
                        $_POST['depositDateTime'] = date("Y-m-d H:i:s", $transfer_response['created']);

                        if( $transfer_response['object'] == 'payout'){
                            // $_POST['transfer_paidout'] = 1; 
                            $_POST['payout_date'] = unixTimeStampConversion($transfer_response['arrival_date'],true);
                            $_POST['payout_acct_type'] = $transfer_response['type'];
                            $_POST['payout_method'] = $transfer_response['method'];
                        }

                        foreach($_POST as $_POST_index => $_POST_value){
                            $field[] = $_POST_index;
                            $value[] = $_POST_value;
                        }
                        /* Insert new transaction */
                            $insert_transaction = pdoInsert($db,$field,$value,'eventartistspay');

                        /* if transfer_reversal - update original transfer table entry */
                            if( ($_POST['transactionType'] == 'transfer_reversal' || $_POST['transactionType'] == 'payout') && $insert_transaction > 0){
                                
                                $cond_trans_rev = 'transaction_id = "' . $transfer_id .'"';
                                if($_POST['transactionType'] == 'transfer_reversal'){
                                    $array_trans_rev = array('transfer_reversed'=>1);
                                }
                                elseif($_POST['transactionType'] == 'payout'){
                                    $array_trans_rev = array('transfer_paidout'=>1);
                                }
                                
                                $upd_orig_trans = updateTable($db, $array_trans_rev, $cond_trans_rev, 'eventartistspay');

                                if($upd_orig_trans){
                                    $respsonse['upd_orig_trans'] = true;
                                }
                                else{
                                    $respsonse['upd_orig_trans'] = false;
                                }
                            }

                        /* Determine if new transaction is inserted in table*/
                            if($insert_transaction > 0 ){
                                $response['trans_table_updated'] = true;
                            }
                            else{
                                $response['trans_table_updated'] = false;
                            }
                    }
        }
        else{
            $response['transfer_made'] = false;
            $response['trans_err'] = 'str_acct_false'; 
        }

        /* Return JSON Response */
            echo json_encode($response);
    }



	if($_GET){

        if($_GET['fetchEvent'] > 0){

            /* Fetch the requested event info */
                $eventID = trim( removeAlphaNumChars($_GET['fetchEvent']) );
                $paramArray['gigId']['='] = $eventID;
                
                $getEvent =  pdoQuery('puweventsmaster','all',$paramArray,$orderByParam1,$innerJoinArray);


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


            /* Fetch selected artist, if any, for requested event*/
                $paramArray1['eventartists.gigId']['='] = $eventID;
                $innerJoinArray1 = array(
                        array('usermaster','iLoginID','eventartists','iLoginid'),
                        array('giftmaster','iGiftID','eventartists','artistType')
                    );
                $leftJoinArray = array(
                    array('eventartistspay','tal_tracker_id','eventartists','tal_tracker_id')
                );
                $columnsArray = array('eventartists.*','giftmaster.sGiftName','usermaster.sFirstName','usermaster.dDOB','eventartistspay.depositamount');
                $getArtists =  pdoQuery('eventartists',$columnsArray,$paramArray1,$orderByParam1,$innerJoinArray1,$leftJoinArray);

//var_dump( $getArtists );
                
                /* Calculate artist's age */
                    foreach($getArtists as $artistIndex => $artist){
                        $getArtists[$artistIndex]['sGiftName'] = str_replace("_","/", $artist['sGiftName']);
                        $getArtists[$artistIndex]['age'] =  getAge( $artist['dDOB'] );
                        $getArtists[$artistIndex]['event_pay'] = CentsToDollars( $artist['event_pay']);
                        $getArtists[$artistIndex]['depositamount'] = CentsToDollars( $artist['depositamount']);
                    }
                    
                if( count($getArtists) > 0 ){
                    $eventConf['artistsInfo'] = $getArtists;
                }
                else{
                    $eventConf['artistsInfo'] = false; 
                }

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
                // $table = 'puwartistmaster';
                // $columnsArray = array('puwartistmaster.*','usermaster.*,talentmaster.talent,talentmaster.TalentID');
                // $paramArray['popUpWorshipCity']['='] =  trim( removeAlphaNumChars($_GET['state']) );
                // $paramArray['talentmaster.TalentID']['='] = trim( removeAlphaNumChars($_GET['talent_id']) );
                // $innerJoinArray = array(
                //         array('usermaster','iLoginID','puwartistmaster','iLoginID'),
                //         array('talentmaster','iLoginID','puwartistmaster','iLoginID')
                //     );


                $table = 'talentmaster';
                $columnsArray = array('usermaster.*,talentmaster.talent,talentmaster.TalentID');//'puwartistmaster.*',
                $paramArray['talentmaster.TalentID']['='] = trim( removeAlphaNumChars($_GET['talent_id']) );
                $paramArray['states.name']['='] =  trim( removeAlphaNumChars($_GET['state']) );
                $innerJoinArray = array(
                    array('usermaster','iLoginID','talentmaster','iLoginID'),
                    array('states','id','usermaster','sStateName')
                );
                
                $getArtists = pdoQuery($table,$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
                // var_dump($getArtists);
                // exit;

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
                $columnsArray = array('puweventsmaster.*','puwhostsmaster.*'); //'puwhostsmaster.environment','puwhostsmaster.buildingType','puwhostsmaster.host_fname','puwhostsmaster.host_lname','puwhostsmaster.host_email','puwhostsmaster.host_phone','puwhostsmaster.host_address','puwhostsmaster.host_state','puwhostsmaster.host_zip','puwhostsmaster.noiseRestrictions','puwhostsmaster.addedInfo','puwhostsmaster.hCapAccessible', 'puwhostsmaster.host_sCityName','puwhostsmaster.capacity', 
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