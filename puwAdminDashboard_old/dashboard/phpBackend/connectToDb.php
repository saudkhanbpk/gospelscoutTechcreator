<?php 
	/* puwAdminDashboard/dashboard/index.php DB connection */

	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/newHomepage/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Get Date/Time */
		$today = date_create();
		$today = date_format($today, 'Y-m-d H:i:s');
		$todayDate = date_format($today, 'Y-m-d');



	if($_GET){
		$eventID = intval( trim( $_GET['eventID'] ) );


		/* Get Events */
            $innerJoinArray = array(
                array("puwhostsmaster","id","puweventsmaster","hostID"),
                array("states","id","puwhostsmaster","host_state")
            );
            $columnsArray = array('puweventsmaster.*','puwhostsmaster.environment','puwhostsmaster.buildingType','puwhostsmaster.host_fname','puwhostsmaster.host_lname','puwhostsmaster.host_email','puwhostsmaster.host_phone','puwhostsmaster.host_address','puwhostsmaster.host_state','puwhostsmaster.host_zip','puwhostsmaster.noiseRestrictions','puwhostsmaster.addedInfo','puwhostsmaster.hCapAccessible', 'puwhostsmaster.host_sCityName','puwhostsmaster.capacity', 'states.statecode');
            $paramArray['date']['>'] = $today;
            $paramArray['puweventsmaster.id']['='] = $eventID;
            $orderByParam = 'date';
            $allEvents =  pdoQuery(' puweventsmaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
            $eventCount = count($allEvents);


        /* Change time formats */
        	$setUpTime = date_create($allEvents[0]['setupTime']);
        	$allEvents[0]['setupTime'] = date_format($setUpTime, 'h:i A');

        	$startTime = date_create($allEvents[0]['startTime']);
        	$allEvents[0]['startTime'] = date_format($startTime, 'h:i A');

        	$endTime = date_create($allEvents[0]['endTime']);
        	$allEvents[0]['endTime'] = date_format($endTime, 'h:i A');

        	$exitByTime = date_create($allEvents[0]['exitByTime']);
        	$allEvents[0]['exitByTime'] = date_format($exitByTime, 'h:i A');
            	

        /* Get Attendees for current event */
        	$columnsArray1 = array('puwattendeemaster.*');
            $paramArray1['confirmedAttendance']['='] = true;
            $paramArray1['eventID']['='] = $eventID;
            $orderByParam1 = 'dateConfirmed';
            $eventAttendees =  pdoQuery('puwattendeemaster',$columnsArray1,$paramArray1,$orderByParam1);
            $eventCount1 = count($allEvents);

        /* Add attendee array to the all events array */
        	array_push($allEvents, $eventAttendees);

            echo json_encode($allEvents);
	}

?>