<?php 
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

	/* Empty array */
		$emptyArray = array(); 

	function getClient($iLoginID){
		$client = new Google_Client();
		$cred = realpath($_SERVER['DOCUMENT_ROOT']) . '/composer/credentials.json';
	    $client->setApplicationName('gs artist calendar client');
	    $client->setScopes(Google_Service_Calendar::CALENDAR); //CALENDAR_READONLY
	    $client->setAuthConfig($cred);
	    $client->setRedirectUri('https://www.gospelscout.com/calendar/phpBackend/myFeed.php'); 
	    
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
	    	$accessToken = pdoQuery('googlecalendarmaster','all',$paramArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];

	    	if( count($accessToken) > 0 ){
		    	/*Remove unnecessary elements */
		    		unset($accessToken['id']);
		    		unset($accessToken['iLoginID']);
		    		unset($accessToken['lastUpdate']);
		    		unset($accessToken['calendar_id']);
		    		unset($accessToken['show_events']);
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

		return $authUrl; 
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

	function get_events($service, $calendarId, $start, $end){

		/* list calendar events */
			$optParams = array(
			  // 'maxResults' => 5,
			  'orderBy' => 'startTime',
			  'singleEvents' => true,
			  'timeMin' => $start, //date('c'),
			  'timeMax' => $end
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

	function getUserCalendars($service){
		echo '<pre>';
		// var_dump($service);
		$optParams = array(
			'minAccessRole' => 'owner'
		);
		try{
			$calendarList = $service->calendarList->listCalendarList($optParams);
			$cal_list = $calendarList->getItems(); 
		}catch(Google_Service_Exception $e){
			var_dump ($e->getMessage() );
		}
		
		
		// var_dump($cal_list);exit;
		return $cal_list;
	}

	function updateClientA_token($client,$current_acc_tok,$iLoginID,$today){
		


		// return $client; 
	}
?>