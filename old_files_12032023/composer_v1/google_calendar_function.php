<?php 
 	require realpath($_SERVER["DOCUMENT_ROOT"]).'/include/headerNew.php'; 
 	require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/newHomePage/include/dbConnect.php');


	echo '<pre>';
	$currentUser_access_token = $objsession->get('google_cal_accessToken');
	// var_dump($currentUser_access_token);
	// exit;
/* 

	App functionality has to adapt to the api scopes granted in the response object 
	
	For Example: 
		if app requested a scope that allows for inserting and deleting events from calendar but user only granted a scope 
		that allows for the app only to read events from calendar, app must function responsively - maybe app disables buttons 
		that would allow the user to add or remove events on their  gospelscout calendar correspondoing to their google calendar
*/

	/* Date Time */
		$today1 = date_create();
		$today = date_format($today1, 'Y-m-d H:i:s');
	
	$iLoginID = '258';//trim( $_GET['u_id'] );//'348';

	function getClient($iLoginID){
		$client = new Google_Client();
	    $client->setApplicationName('gs artist calendar client');
	    $client->setScopes(Google_Service_Calendar::CALENDAR); //CALENDAR_READONLY https://www.googleapis.com/auth/calendar CALENDAR
	    $client->setAuthConfig('credentials.json');
	    $client->setRedirectUri('https://dev.gospelscout.com/newHomePage/composer/google_calendar_function.php'); 
	   
	    /* offline access will give you both an access and refresh token so that
		** your app can refresh the access token without user interaction.
		*/
	    	$client->setAccessType('offline');
	   	/* Using "consent" ensures that your application always receives a refresh token.
		** If you are not using offline access, you can omit this.
		*/
			$client->setPrompt('select_account consent');

	    /* incremental auth */
	    	$client->setIncludeGrantedScopes(true);  

	    /* If your application knows which user is trying to authenticate, it can use this parameter 
	    ** to provide a hint to the Google Authentication Server. The server uses the hint to simplify 
	    ** the login flow either by prefilling the email field in the sign-in form or by selecting the 
	    ** appropriate multi-login session.
	    */
	    	// $client->setLoginHint('kirkydboi@gmail.com');

	    /* Get user's google calendar access token from DB */
	    	$paramArray['iLoginID']['='] = $iLoginID; 
	    	$accessToken = pdoQuery('googlecalendarmaster','all',$paramArray)[0];
	    	
	    	if( count($accessToken) > 0 ){
		    	/*Remove unnecessary elements */
		    		unset($accessToken['id']);
		    		unset($accessToken['iLoginID']);
		    		unset($accessToken['lastUpdate']);
		    		unset($accessToken['calendar_id']);
		    	/* Set Access token */
		    		$client->setAccessToken($accessToken);
		    		$client_obj['access_token'] = $accessToken;
		    }
		    else{
		    	$client_obj['access_token'] = array();
		    }

		/* Return array containing client object and access token array */
			$client_obj['client'] = $client; 
			
	    return $client_obj;
	}

	function generateAuthURL($client){
		/* Request authorization from the user. */
		    $authUrl = $client->createAuthUrl();

		return $authURL; 
	}

	function refresheAccessToken($client){
		/* If there is no previous token or it's expired. 
	    ** Refresh the token if possible, else fetch a new one.
	    */
	        if ( $client->getRefreshToken() ){
	            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
	        } else {
	            /* Redirect user to authorization URL  */
					echo '<script>window.location = "'. generateAuthURL($client) .'";</script>';
					exit;
	        }
		return $client; 
	}

	function getNewAccessToken($client,$authCode){

		/* Exchange authorization code for an access token. */
			$authenticate_auth = $client->authenticate($authCode);

        /* Check to see if there was an error. */
            if (array_key_exists('error', $accessToken)) {
            	var_dump('error present');
            }
        return $client;
	}	

// if( $iLoginID > 0 ){
	/* 1. Call new client object */
		$client_obj = getClient( $iLoginID );
		$current_acc_tok = $client_obj['access_token'];
		$client = $client_obj['client'];
		var_dump($client_obj);
		exit;
// }

	/* 2. Check for Expired Token  - else access user's google calendar */
		if( $client->isAccessTokenExpired() ) {

 			if( $_GET['code'] != ''){
		    	/* Get New Access Token with AUTh code */
			    	$authCode = trim( $_GET['code'] ); 
					$client = getNewAccessToken($client,$authCode);
		    }
		    else{
		    	/* Call function to refresh or reset user access token */
					$client = refresheAccessToken($client);
		    }
		   
		    /* Get & Set New Access token */
		    	$new_access_token = $client->getAccessToken();
		    	$client->setAccessToken($new_access_token);

		    /* Update googlecalendarmaster table with user's new access token */
				$cond = 'iLoginID = "'. $iLoginID . '"';
				$new_access_token['lastUpdate'] = $today;
				// $new_access_token['calendar_id'] = $cal_id;

				if( count($current_acc_tok) > 0 ){
					$update_user_token = updateTable($db, $new_access_token, $cond, 'googlecalendarmaster');
				}
				else{
					$new_access_token['iLoginID'] = $iLoginID;
					foreach($new_access_token as $new_access_token_index => $new_access_token_val){
						$field_ins[] = $new_access_token_index;
						$value_ins[] = $new_access_token_val;
					}
					$update_user_token = pdoInsert($db,$field_ins,$value_ins,'googlecalendarmaster');
				}

			/* Set the SESSIONS var */
				if( $update_user_token || $update_user_token > 0 ){
					/* Update succeeded */
						$objsession->set('google_cal_accessToken',$new_access_token); 
						var_dump('updating database with new access token succeeded');
				}
				else{
					/* Update failed */
					var_dump('updating database with new access token failed');
				}
		}

	/* 3. Instantiate new google service calendar object */
		$service = new Google_Service_Calendar($client);
		$calendarId = 'primary';

	/* 4. Call the required google calendar-based function */
		
		/* Ensure authenticated user has write access to the specified calendar */
			$calendarList = $service->calendarList->get($calendarId);
			$access_role = $calendarList->accessRole; 
			if( $access_role =='owner' ){
				$owner = true; 
			}
			else{
				$owner = false; 
			}

			echo '<pre>';
			var_dump($access_role);

		/* Get Events Function */
			function get_events($service, $calendarId){
				/* list calendar events */
					$optParams = array(
					  'maxResults' => 5,
					  'orderBy' => 'startTime',
					  'singleEvents' => true,
					  'timeMin' => date('c'),
					);
					$listEvents_obj = $service->events->listEvents($calendarId, $optParams);
					$listedEvents = $listEvents_obj->getItems();
					foreach ($listedEvents as $listedEvents_index => $event) {
						// var_dump($event->getSummary().", ".$event->start->dateTime);
						// var_dump($event);

						$user_events[$listedEvents_index]['id'] = $event->id; 
						$user_events[$listedEvents_index]['start'] = date_format(date_create($event->start->dateTime), 'Y-m-d H:i:s');
						$user_events[$listedEvents_index]['end'] = date_format(date_create($event->end->dateTime), 'Y-m-d H:i:s');
						$user_events[$listedEvents_index]['creator_name'] = $event->organizer->displayName; 
						$user_events[$listedEvents_index]['creator_email'] = $event->organizer->email;
						$user_events[$listedEvents_index]['event_summary'] = $event->summary; 
						$user_events[$listedEvents_index]['event_status'] = $event->status; 
						$user_events[$listedEvents_index]['url'] = $event->htmlLink; 
						$user_events[$listedEvents_index]['date_created'] = date_format(date_create($event->created), 'Y-m-d H:i:s');
						$user_events[$listedEvents_index]['last_updated'] = date_format(date_create($event->updated), 'Y-m-d H:i:s');
					}
					return $user_events;
			}

			var_dump( get_events($service, $calendarId) );

			// $google_cal_time = date_format($today1, 'c');
			// var_dump($google_cal_time);

		/* Insert a calendar event */


			$start_T = date_format(date_create('2020-04-28 17:00:00'), 'c');
			$end_T = date_format(date_create('2020-04-28 19:00:00'), 'c');
			$summary = '';
			$location = '';
			$description = '';
			$attendees = array( array('email' => $attendee_email) );

			var_dump($start_T);
			// '2020-04-28T09:00:00-07:00' '2020-04-28T17:00:00-07:00'
			$event_insert = new Google_Service_Calendar_Event(array(
			  'summary' => 'Google I/O 2020 kirk d test',
			  'location' => '800 Howard St., San Francisco, CA 94103',
			  'description' => 'A chance to hear more about Google\'s developer products.',
			  'start' => array(
			    'dateTime' => $start_T,
			    'timeZone' => 'America/Los_Angeles',
			  ),
			  'end' => array(
			    'dateTime' => $end_T,
			    'timeZone' => 'America/Los_Angeles',
			  ),
			  'recurrence' => array(
			    'RRULE:FREQ=DAILY;COUNT=2'
			  ),
			  'attendees' => array(
			    array('email' => 'kirkddrummond@yahoo.com'),
			    // array('email' => 'sbrin@example.com'),
			  ),
			  'reminders' => array(
			    'useDefault' => FALSE,
			    'overrides' => array(
			      array('method' => 'email', 'minutes' => 24 * 60),
			      array('method' => 'popup', 'minutes' => 10),
			    ),
			  ),
			));

			


			$event_insert = $service->events->insert($calendarId, $event_insert);
			var_dump($event_insert);

		// Update a calendar event 
		// Remove a calenar event 



exit; 


// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 5,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();
 foreach ($events as $event) {
	var_dump($event->getSummary().", ".$event->start->dateTime);
}
// exit;

// var_dump($service->events);
// exit;

$event_insert = new Google_Service_Calendar_Event(array(
  'summary' => 'Google I/O 2015',
  'location' => '800 Howard St., San Francisco, CA 94103',
  'description' => 'A chance to hear more about Google\'s developer products.',
  'start' => array(
    'dateTime' => '2020-04-28T09:00:00-07:00',
    'timeZone' => 'America/Los_Angeles',
  ),
  'end' => array(
    'dateTime' => '2020-04-28T17:00:00-07:00',
    'timeZone' => 'America/Los_Angeles',
  ),
  'recurrence' => array(
    'RRULE:FREQ=DAILY;COUNT=2'
  ),
  'attendees' => array(
    array('email' => 'kirkddrummond@yahoo.com'),
    // array('email' => 'sbrin@example.com'),
  ),
  'reminders' => array(
    'useDefault' => FALSE,
    'overrides' => array(
      array('method' => 'email', 'minutes' => 24 * 60),
      array('method' => 'popup', 'minutes' => 10),
    ),
  ),
));

			// $calendarId = 'primary';
			var_dump($event_insert);
			$event_insert = $service->events->insert($calendarId, $event_insert);
			var_dump('test1');
			var_dump($event_insert);
			var_dump('test2');
			var_dump($event_insert->htmlLink );
			var_dump('test3');

			// var_dump($events);



	// echo '<pre>';
	// var_dump($client);
	// if (isset($_GET['code'])) {
	//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	// }
	
/*
https://accounts.google.com/o/oauth2/auth?response_type=code&access_type=offline&client_id=198851728925-jlvhmr2248bbed4pe38tdvmnk1lg87sq.apps.googleusercontent.com&redirect_uri=https%3A%2F%2Fwww.gospelscout.com%2Fcalendar%2FcalendarDisplay.php&state&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar&approval_prompt=consent&include_granted_scopes=true&login_hint=kirkydboi%40gmail.com
*/

/*
https://accounts.google.com/o/oauth2/auth?response_type=code&access_type=offline&client_id=198851728925-jlvhmr2248bbed4pe38tdvmnk1lg87sq.apps.googleusercontent.com&redirect_uri=https%3A%2F%2Fwww.gospelscout.com%2Fcalendar%2FcalendarDisplay.php&state&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar&approval_prompt=consent&include_granted_scopes=true&login_hint=kirkydboi%40gmail.com
*/
	/* 
		List events returns the an array of objects containing the following 

		1. attendeesOmitted
		2. colorId
		3. created
		4. description
		5. endTimeUnspecified
		6. etag
		7. guestsCanInviteOthers
		8. guestsCanModify
		9. guestsCanSeeOtherGuests
		10. hangoutLink
		11. htmlLink
		12. iCalUID
		13. id
		14. kind
		15. location
		16. locked
		17. privateCopy
		18. recurrence
		19. recurringEventId
		20. sequence
		21. status
		22. summary
		23. transparency
		24. updated
		25. visibility
		26. creator - object 
		27. organizer - object
		28. start - object 
		29. end - object 
		30. reminders - object
			 -> useDefault
			 -> overrides - array of objects 








	*/
	// echo '<pre>';
	// var_dump($events);

	// if (empty($events)) {
	//     print "No upcoming events found.\n";
	// } else {
	//     print "Upcoming events:\n";
	//     foreach ($events as $event) {
	//         $start = $event->start->dateTime;
	//         if (empty($start)) {
	//             $start = $event->start->date;
	//         }
	//         printf("%s (%s)\n", $event->getSummary(), $start);
	//     }
	// }



// $tokenPath = 'token.json';  fetchAccessTokenWithAuthCode
	    // if (file_exists($tokenPath)) {
	    //     $accessToken = json_decode(file_get_contents($tokenPath), true);
	        
	    //     $client->setAccessToken($accessToken);
	    // }

	    // // If there is no previous token or it's expired.
	    // if ($client->isAccessTokenExpired()) {
	    //     // Refresh the token if possible, else fetch a new one.
	    //     if ($client->getRefreshToken()) {
	    //         $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
	    //     } else {
	    //         // Request authorization from the user.
	    //         $authUrl = $client->createAuthUrl();
	    //         printf("Open the following link in your browser:\n%s\n", $authUrl);
	    //         print 'Enter verification code: ';
	    //         $authCode = trim(fgets(STDIN));

	    //         // Exchange authorization code for an access token.
	    //         $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
	    //         $client->setAccessToken($accessToken);

	    //         // Check to see if there was an error.
	    //         if (array_key_exists('error', $accessToken)) {
	    //             throw new Exception(join(', ', $accessToken));
	    //         }
	    //     }
	    //     // Save the token to a file.
	    //     if (!file_exists(dirname($tokenPath))) {
	    //         mkdir(dirname($tokenPath), 0700, true);
	    //     }
	    //     file_put_contents($tokenPath, json_encode($client->getAccessToken()));
	    // }

?>








