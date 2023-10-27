<?php
	
	//require('Composer1/vendor/autoload.php');
	require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/Composer1/vendor/autoload.php');
	use Postmark\PostmarkClient; 
	use Postmark\PostmarkAdminClient; 
	use Postmark\Models\PostmarkException;

	//echo $_SERVER['DOCUMENT_ROOT'] . '/Composer1/vendor/autoload.php';


/*
	$signature = "Administrator";
	$senderAddress = "administrator@gospelscout.com";
	$receiverAddress = "kirkddrummond@yahoo.com";
	$subject = "Welcome to GospelScout!!!";
	$emailBody = "This is a test email changed";
	try {
	$client = new PostmarkClient('5e5025bd-5c9b-4c2b-899c-772d825f85f3'); 
	$sendResult = $client->sendEmail(
					
					$senderAddress,
					$receiverAddress,
					$subject,
					$emailBody
				);
		echo 'Testing123!!!';
	}catch(PostmarkException $ex){

		echo $ex->httpStatusCode; 
		echo $ex->message;
		echo $ex->postmarkApiErrorCode; 
	}catch(Exception $generalException){

	}
*/

	$id = 42; 
	//$result = $client->getBounce($id);
	//var_dump($result);
	echo 'Testing123!!!<br><br>';
	/*
	foreach($result as $key => $value) {

		echo $key . ':' . $value; 
	}
	*/
	 
	/*        API Snippet         */
	if(!empty($_GET)) {
		function sendApiEmail($sender, $receiver,$receiverName, $emailID, $message) {	
			// Import the Postmark Client Class.
			//use Postmark\PostmarkClient;

			// Create Client
			$client = new PostmarkClient("5e5025bd-5c9b-4c2b-899c-772d825f85f3");

			// Make a request
			$sendResult = $client->sendEmailWithTemplate(
			  $sender,
			  $receiver, 
			  $emailID,
			  [
			  "name" => $receiverName,
			  "message" => $message,
			  "action_url" => "https://www.gospelscout.com",
			  "login_email" => $receiver,
			  "username" => "username_Value",
			  "trial_length" => "trial_length_Value",
			  "trial_start_date" => "trial_start_date_Value",
			  "trial_end_date" => "trial_end_date_Value",
			  "live_chat_url" => "live_chat_url_Value",
			  "contact_page" => "http://www.gospelscout.com/views/contact_us",
			  "help_url" => "http://www.gospelscout.com/views/help",
			]);
		}
	
		$message = "This is a Kirk Deezy Message Ya Bish";
		$sender = "contact_pagesend@gospelscout.com";
		$receiverEmail = "kirkddrummond@yahoo.com";
		//"contact_pagereceive@gospelscout.com";
		$receiverName = "Kirk";
		$emailTemplateId = "1889501";
		sendApiEmail($sender, $receiverEmail, $receiverName, $emailTemplateId, $message);
	}
	echo "<a href='EmailTest.php?t=1'>Send Email</a><br>";
	echo "<a href='views/EmailTest.php'>Send Email page 2</a>";

?>

