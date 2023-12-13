
<?php 

	function newArtistHandler($db,$e_id,$selectedArtists,$puwMail,$today,$eventPay){
		
		/******************************* Insert new artist and artist's pay *******************************/
		if( count($selectedArtists) > 0 ){
                /* Add new artist to eventartists table */
                    $artInsertCount = 0; 
                    foreach($selectedArtists as $selectedArtists_index => $selectedArtists_value){
                        foreach($selectedArtists_value as $selectedArtists_value_index => $selectedArtists_value_val){
                            $value1[] = array($selectedArtists_index,$e_id,$selectedArtists_value_val,$today,'puweventsmaster',$_POST['date'],'pending','requestmade',$selectedArtists_value_index); 
                        }
                    }
                    $field1 = array('iLoginid', 'gigId', 'artistType','datetimeselected','eventtable','eventdate','artiststatus','requestorstatus','tal_tracker_id');
                    
                    $newArtistsInserted = pdoMultiRowInsert($db,$field1,$value1,'eventartists');

                /* Add new artist pay to eventartistspay table */
                    if( $newArtistsInserted === true ){
                        $insertConf['all_artist_inserted'] = true;
                            foreach($selectedArtists as $selectedArtists_index1 => $selectedArtists_value1){
                                foreach($selectedArtists_value1 as $selectedArtists_value_index1 => $selectedArtists_value_val1){
                                    $value2[] = array($selectedArtists_index1,$e_id,$selectedArtists_value_index1,$eventPay[$selectedArtists_value_index1]);
                                }
                            }
                            $field2 = array('iLoginid', 'gigId','tal_tracker_id','depositamount');
                            $newArtistsPayInserted = pdoMultiRowInsert($db,$field2,$value2,'eventartistspay');

                            if( $newArtistsPayInserted === true ){
                                $insertConf['all_artistPay_inserted'] = true;

                                /************************************** Send artists emails **************************************/
									$columnsArray_email = array('usermaster.sFirstName','usermaster.sLastName','usermaster.sContactEmailID','eventartists.tal_tracker_id','giftmaster.sGiftName');
								    $paramArray_email['gigId']['='] = $e_id;
								    foreach($selectedArtists as $selectedArtists_ind => $selectedArtists_val){
								        $paramOrArray_email['eventartists.iLoginid']['='][] = $selectedArtists_ind;
								    }

								    $innerJoinArray_email = array(
								        array('usermaster','iLoginID','eventartists','iLoginid'),
								        array('giftmaster','iGiftID','eventartists','artistType')
								    );
								   $get_art_email_info = pdoQuery('eventartists',$columnsArray_email,$paramArray_email,$orderByParam_email,$innerJoinArray_email,$leftJoinArray_email,$paramOrArray_email);

								   
								   /* Insert confirmation link and edit giftnames */
								        foreach($get_art_email_info as $get_art_email_info_ind => $get_art_email_info_val){
								            $get_art_email_info[$get_art_email_info_ind]['action_url'] = 'https://dev.gospelscout.com/puwartistsconfirmation/?tal_tracker='.$get_art_email_info_val['tal_tracker_id'];
								            $get_art_email_info[$get_art_email_info_ind]['sGiftName'] = str_replace("_", "/", $get_art_email_info_val['sGiftName']);
								        }

								        $_POST['date'] = date_format( date_create($_POST['date']), 'm/d/Y');
								        $_POST['setupTime'] = changeTimeFormat($_POST['setupTime'],false);
								        $_POST['startTime'] = changeTimeFormat($_POST['startTime'],false);
								        $_POST['endTime'] = changeTimeFormat($_POST['endTime'],false);
								        $_POST['exitByTime'] = changeTimeFormat($_POST['exitByTime'],false);
								        $_POST['puwSection'] = 'LA';

								    /* Call Email Function */
								        $send_requests = $puwMail->sendBatchPuwArtistRequest($get_art_email_info,$_POST);
								        // var_dump($send_requests);

								        if( $send_requests['send_error']['present'] ){
								            /* @ least one or more emails failed to send */
								                $insertConf['all_emails_sent'] = 'send_error';
								                $insertConf['failed_emails'] = $send_requests['send_error']['message'];
								        }
								        elseif( $send_requests['error']['present'] ){
								            /* There was an input or connection error */
								                $insertConf['all_emails_sent'] = 'error';
								                $insertConf['failed_emails'] = $send_requests['error']['message'];
								        }
								        else{
								            /* All emails sent successfully */
								                $insertConf['all_emails_sent'] = true;
								        }
							        /*********************************** END - Send artists emails ***********************************/
                                
                            }       
                            else{
                                $insertConf['all_artistPay_inserted'] = false;
                            }
                    }
                    else{
                        $insertConf['all_artist_inserted'] = false;
                    }
            }
            else{
                $insertConf['all_artist_inserted'] = true;
                $insertConf['all_artistPay_inserted'] = true;
                $insertConf['all_emails_sent'] = true;
            }
        /**************************** END - Insert new artist and artist's pay ****************************/

        
	    return $insertConf;

    }





    

    




?>