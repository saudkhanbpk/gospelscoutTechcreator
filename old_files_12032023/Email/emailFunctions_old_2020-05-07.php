<?php 
	//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/Composer1/vendor/autoload.php');
	use Postmark\PostmarkClient; 
	use Postmark\PostmarkAdminClient; 
	use Postmark\Models\PostmarkException;

	function sendClientInvoiceEmail($getGigInfoResults){
		$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");

		$sender = "contact_pagesend@gospelscout.com";
	  	$receiver = "kirkddrummond@yahoo.com";
	  	$emailID = 9923047;
	  	$receiverName = "Contact Page - Admin";

	  	// Make a request
	  	$sendResult = $client->sendEmailWithTemplate(
		    	$sender,
		    	$receiver, 
		    	$emailID,
		    	[
				"client_name" => $getGigInfoResults['gigDetails_clientName'],
				"client_total_cost" => $getGigInfoResults['gigDetails_clientTotalCost'],
				"client_total_cost_date" => $getGigInfoResults['gigDetails_gigDate'],
				"client_deposit" => $getGigInfoResults['gigDetails_clientDeposit'],
				"client_deposit_date" => $getGigInfoResults['gigDetails_clientDepositDate'],
				"gig_id" => $getGigInfoResults['gigId'],
				"gig_name" => $getGigInfoResults['gigDetails_gigName'],
				"gig_type" => $getGigInfoResults['gigDetails_gigType'],
				"gig_date" => $getGigInfoResults['gigDetails_gigDate'],
				"setup_time" => $getGigInfoResults['gigDetails_setupTime'],
				"start_time" => $getGigInfoResults['gigDetails_startTime'],
				"end_time" => $getGigInfoResults['gigDetails_endTime'],
				"gig_privacy" => $getGigInfoResults['gigDetails_gigPrivacy'],
				"venue_name" => $getGigInfoResults['gigDetails_venueName'],
				"venue_address" => $getGigInfoResults['gigDetails_venueAddress'],
				"venue_state" => $getGigInfoResults['gigDetails_venueState'],
				"venue_city" => $getGigInfoResults['gigDetails_venueCity'],
				"venue_zip" => $getGigInfoResults['gigDetaigigDetails_venueEnvironmentls_venueZip'],
				"venue_environment" => $getGigInfoResults['gigDetails_venueEnvironment'],
				"gigMan_name" => $getGigInfoResults['gigDetails_gigManName'],
				"gigMan_email" => $getGigInfoResults['gigDetails_gigManEmail'],
				"gigMan_phone" => $getGigInfoResults['gigDetails_gigManPhone'],
				"gigMan_id" => $getGigInfoResults['gigDetails_gigManLoginId'],
				"additional_comments" => $getGigInfoResults['clientEmail_comment']
			]
		);
	}

	function sendWelcomeEmail($receiver,$receiverName) {  
	      
	    // Create Client
	    $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");

	    //Constants
	    $sender = "administrator@gospelscout.com";
	    $emailID = 1889501; 

	    // Make a request
	    $sendResult = $client->sendEmailWithTemplate(
	      $sender,
	      $receiver, 
	      $emailID,
	      [
	        "name" => $receiverName,
	        "action_url" => "https://www.stage.gospelscout.com",
	        "login_email" => $receiver,
	        "contact_page" => "http://www.stage.gospelscout.com/views/contact_us",
	        "help_url" => "http://www.stage.gospelscout.com/views/help",
	      ]);
	  }


	function sendContactPageEmail($userName, $userEmail, $userMessage, $city, $state, $mobile) {
	  // Create Client
	  $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");

	  $sender = "contact_pagesend@gospelscout.com";
	  $receiver = "contact_pagereceive@gospelscout.com";
	  $emailID = 1943961;
	  $receiverName = "Contact Page - Admin";

	  // Make a request
	  $sendResult = $client->sendEmailWithTemplate(
	    $sender,
	    $receiver, 
	    $emailID,
	    [
	      "commenter_name" => $userName,
	      "commenter_email" => $userEmail,
	      "commenter_mobile" => $mobile, 
	      "city" => $city,
	      "state" => $state, 
	      "body" => $userMessage,
	    ]);
	}

	function sendPasswordReset($receiver, $receiverName, $actionUrl, $os, $recovCode) {
		// Create Client
		$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");

		$sender = "administrator@gospelscout.com"; 
		$emailID = 3577401;

		// Make a request
		$sendResult = $client->sendEmailWithTemplate(
	      $sender,
	      $receiver, 
	      $emailID,
	      [
	      	"name" => $receiverName,
	      	"recovery_code" => $recovCode,
	      	"action_url" => $actionUrl,
	      	"operating_system" => $os, 
	      	"support_url" => "http://www.stage.gospelscout.com/views/contact_us", 
	      ]);
	}

	function deactivateAccount($receiver, $receiverName, $actionUrl, $os, $browserName){
		//Create Client
		$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");

		$sender = "administrator@gospelscout.com"; 
		$emailID = "3579062";

		//Make a Request
		$sendResult = $client->sendEmailWithTemplate(
	      $sender,
	      $receiver, 
	      $emailID,
	      [
	      	"name" => $receiverName,
	      	"action_url" => $actionUrl,
	      	"operating_system" => $os, 
	      	"browser_name" => $browserName,
	      	"support_url" => "http://www.stage.gospelscout.com/views/contact_us", 
	      ]);
	}

	function subscrNotif($subscriber, $subscriberName, $actionUrl, $notif_type, $subscribeeName){

		//Create Client
		$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		$sender = "administrator@gospelscout.com"; 
		$emailID = "4655101";  

		//Make a Request
		$sendResult = $client->sendEmailWithTemplate(
	      $sender,
	      $subscriber, 
	      $emailID,
	      [
	      	"name" => $subscriberName,
	      	"subscribee" => $subscribeeName,
	      	"action_url" => $actionUrl,
	      	"notif_type" => $notif_type,
	      	"support_url" => "http://www.stage.gospelscout.com/views/contact_us", 
	      ]);	
	}

	function newUserConf($newUserEmail, $newUserName, $randKey){
		
		try{
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
			$sender = "administrator@gospelscout.com"; 
			$emailID = "4715362";  
	
			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $newUserEmail, 
		      $emailID,
		      [
		      	"newUserName" => $newUserName,
		      	"newUserEmail" => $newUserEmail,
		      	"random_key" => $randKey, 
		      	"support_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]);
		      
		      return $sendResult;	
		}catch(Exception $e){
			return $e;
		}
	}
	
	function generalComms($trueSender, $trueSenderName, $trueSenderTalent, $trueSenderGigStatus, $receiver, $receiverName, $emailSubject, $emailContent, $gigId, $gigName, $talentRequested){
		//Create Client
		    $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		    $sender = "administrator@gospelscout.com"; 
			$emailID = "8673754";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, 
		      $emailID,
		      [
		      	"requestor" => $trueSender,
		      	"requestor_name" => $trueSenderName,
		      	"requestor_gigStatus" => $trueSenderGigStatus,
		      	"requestor_talent" => $trueSenderTalent,
		      	"requestor_url" => $requestorUrl,
		      	"receiver" => $receiver,
		      	"receiver_name" => $receiverName,
		      	"email_subject" => $emailSubject,
		      	"email_content" => $emailContent,
		      	"talent_requested" => $talentRequested,	
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId,
		      	"date" => $date,
		      	"action_url" => $actionUrl,
		      	"help_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      	"support_email" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]
		    );
	}
	
	class popupworship {

		/* Sent when admin notifies popupworship applicants they've been selected to attend */
		function selectedAttendees($recipient_array,$puwSection){
			 //var_dump($recipient_array['email']);
				 //exit;
			//Create Client
		        $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		        $sender = "administrator@gospelscout.com"; 
		        $receiver = $recipient_array['email'];
			$emailID = "15922282";
			$date = date("F j, Y, g:i a");

			// Make a Request 
			$sendResult = $client->sendEmailWithTemplate(
				$sender,
		      	$receiver, 
		      	$emailID,
		      	[
		      		"name" =>$recipient_array['fName'].' '.$recipient_array['lName'],
				"product_name"=>$puwSection,
				"event_date"=>$recipient_array['date'],
				"event_start_time"=>$recipient_array['startTime'],
				"event_end_time"=>$recipient_array['endTime'],
				"action_url"=>'https://www.stage.gospelscout.com/popupworship/attend_conf?id='.$recipient_array['id'],
				"support_email"=>$recipient_array['fName'],
				"help_url"=>$sender,
				"product_url"=>'httsp://www.stage.gospelscout.com/popupworship/',
				"company_name"=>'GospelScout',
				"company_address"=>'',
		      	]
			);

			//return $sendResult; 
		}

		function standbyAttendees($recipient_array,$puwSection){

			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
			$sender = "administrator@gospelscout.com"; 
			$receiver = $recipient_array['email'];
			$emailID = "15935092";
			$date = date("F j, Y, g:i a");

			// Make a Request 
			$sendResult = $client->sendEmailWithTemplate(
				$sender,
		      	$receiver, 
		      	$emailID,
		      	[
		      		"name" =>$recipient_array['fName'].' '.$recipient_array['lName'],
				"product_name"=>$puwSection,
				"event_date"=>$recipient_array['date'],
				"event_start_time"=>$recipient_array['startTime'],
				"event_end_time"=>$recipient_array['endTime'],
				"action_url"=>'https://www.stage.gospelscout.com/popupworship/#upcomingDates',
				"support_email"=>$recipient_array['fName'],
				"help_url"=>$sender,
				"product_url"=>'httsp://www.stage.gospelscout.com/popupworship/',
				"company_name"=>'GospelScout',
				"company_address"=>'',
		      	]
			);

			return $sendResult; 
		}

		/* Sent when admin notifies popupworship applicants of the event location */
		function sendPuwLocation($recipient_array,$puwSection){
				
			//Create Client
		        $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		        $sender = "administrator@gospelscout.com"; 
		        $receiver = $recipient_array['email'];
			$emailID = "15931228";
			$date = date("F j, Y, g:i a");

			// Make a Request 
			$sendResult = $client->sendEmailWithTemplate(
			$sender,
		      	$receiver, 
		      	$emailID,
		      	[
		      		"name" =>$recipient_array['fName'].' '.$recipient_array['lName'],
				"product_name"=>$puwSection,
				"event_date"=>$recipient_array['date'],
				"event_start_time"=>$recipient_array['startTime'],
				"event_end_time"=>$recipient_array['endTime'],
				"event_address"=> $recipient_array['host_address'],
				"event_city_state_zip"=> $recipient_array['host_sCityName'].', '.$recipient_array['statecode'].' '.$recipient_array['host_zip'],
				// "action_url"=>'https://www.stage.gospelscout.com/popupworship/attend_conf?id='.$recipient_array['id'],
				"support_email"=>$recipient_array['fName'],
				"help_url"=>$sender,
				"product_url"=>'httsp://www.stage.gospelscout.com/popupworship/',
				"company_name"=>'GospelScout',
				"company_address"=>'',
		      	]
			);

			return $sendResult; 
		}
	}
	
	class booking {

		/* Called when a gig manager requests to use an artist for a gig */ 
		function request($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId){
			//Create Client
		    $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		    $sender = "administrator@gospelscout.com"; 
			$emailID = "3581901";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, 
		      $emailID,
		      [
		      	"requestor" => $requestor,
		      	"requestor_name" => $requestorName,
		      	"requestor_url" => $requestorUrl,
		      	"receiver" => $receiver,
		      	"receiver_name" => $receiverName,
		      	"talent_requested" => $talentRequested,	
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId,
		      	"date" => $date,
		      	"action_url" => $actionUrl,
		      	"help_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      	"support_email" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]
		    );
		}

		/* Called when a gig manager cancels an artist for a gig */
		function cancelArtist($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $cancelReason){
			
			//Create Client
		    $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		    $sender = "administrator@gospelscout.com"; 
			$emailID = "8599960";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, 
		      $emailID,
		      [
		      	"requestor" => $requestor,
		      	"requestor_name" => $requestorName,
		      	"requestor_url" => $requestorUrl,
		      	"receiver" => $receiver,
		      	"receiver_name" => $receiverName,
		      	"talent_requested" => $talentRequested,	
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId,
		      	"date" => $date,
		      	"action_url" => $actionUrl,
		      	"cancel_reason" => $cancelReason,
		      	"help_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      	"support_email" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]
		    );
		}
		
		/* Called when a gig manager cancels the gig */
		function cancellation($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $reason) {
		    //Create Client
		    $client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		    $sender = "administrator@gospelscout.com"; 
			$emailID = "3582301";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, 
		      $emailID,
		      [	
		      	"requestor" => $requestor,
		      	"requestor_name" => $requestorName,
		      	"requestor_url" => $requestorUrl,
		      	"receiver" => $receiver,
		      	"receiver_name" => $receiverName,
		      	"talent_requested" => $talentRequested,
		      	"action_url" => $actionUrl,
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId,
		      	"cancel_reason" => $reason,
		      	"date" => $date,
		      	"help_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      	"support_email" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]
		    );
		}
		
		/* Called when a gig manager makes a change to the gig details */
		function update($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId, $email_editInfoParam) {
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		    	$sender = "administrator@gospelscout.com"; 
			$emailID = "3593443";
			$date = date("F j, Y, g:i a");

			$indivParam = "";
			for($i=0; $i<count($email_editInfoParam); $i++){
		      		if($email_editInfoParam[$i] != ""){
		      			if($i == count($email_editInfoParam) - 1){
		      				$indivParam .= $email_editInfoParam[$i];
		      			}
		      			else{
		      				$indivParam .= $email_editInfoParam[$i] . ', ';
		      			}
		      		}
		      	}

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, 
		      $emailID,
		      [
		      	"requestor" => $requestor,
		      	"requestor_name" => $requestorName,
		      	"requestor_url" => $requestorUrl,
		      	"receiver" => $receiver,
		      	"receiver_name" => $receiverName,
		      	"talent_requested" => $talentRequested,
		      	"action_url" => $actionUrl,
		      	"gig_name" => $gigName,
		      	"email_editInfoParam" => $indivParam,
		      	"gig_id" => $gigId,
		      	"date" => $date,
		      	"help_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      	"support_email" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]
		    );
		}

		/* Called when an artists makes a change to their playing status (accept/decline/cancel) */
		function status($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $receiverResponse, $actionUrl, $gigName, $gigId, $status) {
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
		    $sender = "administrator@gospelscout.com"; 
			$emailID = "3593642";
			$date = date("F j, Y, g:i a");
									
			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $requestor, 
		      $emailID,
		      [
		      	"requestor" => $requestor,
		      	"requestor_name" => $requestorName,
		      	"requestor_url" => $requestorUrl,
		      	"receiver" => $receiver,
		      	"receiver_name" => $receiverName,
		      	"talent_requested" => $talentRequested,
		      	"response_value" => $receiverResponse,
		      	"playing_status" => $status,
		      	"action_url" => $actionUrl,
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId,
		      	"date" => $date,
		      	"help_url" => "http://www.stage.gospelscout.com/views/contact_us", 
		      	"support_email" => "http://www.stage.gospelscout.com/views/contact_us", 
		      ]
		    );
		}
	}

	class payment {

		/* The deposits themselves should probably also have Id #'s - I currently have not included this variable in any of the functions */

		function Deposits($depositor, $depositorName, $receiver, $depositAmount, $gigName, $gigId, $gigDate, $refundExpiration, $type) {
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
			$sender = "administrator@gospelscout.com"; 
			$emailID = "";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, //The depositee
		      $emailID,
		      [ 
		      	"depositor_email" => $depositor,
		      	"depositor_name" => $depositorName,
		      	"deposit_amount" => $depositAmount,
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId, 
		      	"gig_date" => $gigDate,
		      	"date" => $Date,
		      	"refundExpiration_date" => $refundExpiration  //If there is a refund expiration date established by the artist
		      ]
		    );
		}

		function Withdrawals($depositee, $depositeeName, $receiver, $depositAmount, $gigName, $gigId, $gigDate, $refundExpiration, $type) {
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
			$sender = "administrator@gospelscout.com"; 
			$emailID = "";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, //The depositor
		      $emailID,
		      [ 
		      	"depositee_email" => $depositee,
		      	"depositee_name" => $depositeeName,
		      	"deposit_amount" => $depositAmount,
		      	"gig_name" => $gigName,
		      	"gig_id" => $gigId, 
		      	"gig_date" => $gigDate,
		      	"date" => $Date,
		      	"refundExpiration_date" => $refundExpiration  //If there is a refund expiration date established by the artist
		      ]
		    );
		}

		function refunds($depositor, $depositorName, $receiver, $receiverName, $depositAmount, $gigName, $gigId, $gigDate, $refundExpiration, $origDeposDate, $refundDescription) {
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
			$sender = "administrator@gospelscout.com"; 
			$emailID = "3594862";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, //The depositor $receiverName
		      $emailID,
		      [ 
		      	"receiver_name" => $receiverName,
		      	"depositor_email" => $depositor,
		      	"depositor_name" => $depositorName,
		      	"deposit_amount" => $depositAmount,
		      	"orig_depos_date" => $origDeposDate,
		      	"refund_description" => $refundDescription,
	      		"gig_name" => $gigName,
		      	"gig_id" => $gigId, 
		      	"gig_date" => $gigDate,
		      	"refundExpiration_date" => $refundExpiration,  //If there is a refund expiration date established by the artist
		      	"date" => $date
		      ]
		    );
		}

		function insufficientFunds($receiver, $receiverName, $depositAmount, $gigName, $gigId, $gigDate, $origDeposDate, $deficitAmount) {
			//Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");
			$sender = "administrator@gospelscout.com"; 
			$emailID = " 3637422";
			$date = date("F j, Y, g:i a");

			//Make a Request
			$sendResult = $client->sendEmailWithTemplate(
		      $sender,
		      $receiver, //The depositor $receiverName
		      $emailID,
		      [ 
		     	"receiver_name" => $receiverName,
		      	"deposit_amount" => $depositAmount,
		      	"orig_depos_date" => $origDeposDate,
		      	"deficit_amount" =>$deficitAmount,
	      		"gig_name" => $gigName,
		      	"gig_id" => $gigId, 
		      	"gig_date" => $gigDate,
		      	"date" => $date
		      ]
		    );
		}
	}
?>