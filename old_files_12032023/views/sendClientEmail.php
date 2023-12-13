<?php
	/* Send gig Clients Invoice Email */

var_dump($_POST);

	/*
		required data: 
			1. gig manager name & user ID
			2. gig manager email
			3. gig id
			4. which tables should be queried 
			5. gig manager additional comments

	
		1. query the gigdetails, gigartists, and gigmusic based on the $_POST array elements 
		2. Verify info exists in each array returned for the perspective tables
		3. pick out the important info from the gigdetails array 
		4. pick out the important info from the gigartists array 
		5. pick out the important info from the gigmusic array 

		data needed from gigdetails table
			client name, email, phone, total price, depposit and despoist date
			event name, type, date, setup start & end times, privacy type, 
			venue name, address, city, state, zip, environment

		data needed from gigmusic 
			song names 

		data needed from gigartists - only aritst witha gigArtists_gigManCancelStatus = active and gigArtists_artistStatus = active
			name and instrument


	*/

	/* Inclued the the dbconnect page */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* INclude the config.php page */
     		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Test for the presence of a $_POST array */
		if($_POST){
			/*********** Create query statement and do relational query on the db for gigdetails and optionally, gigmusic & gigartists ***********/
				/* Create query statement base */
					$getGigInfoQuery = 'SELECT gigdetails.gigId, gigdetails.gigDetails_clientName, gigdetails.gigDetails_clientEmail, gigdetails.gigDetails_clientPhone, gigdetails.gigDetails_clientTotalCost, gigdetails.gigDetails_clientDeposit, gigdetails.gigDetails_clientDepositDate,
								   gigdetails.gigDetails_gigName, gigdetails.gigDetails_gigType, gigdetails.gigDetails_gigDate, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_startTime, gigdetails.gigDetails_endTime, gigdetails.gigDetails_gigPrivacy,
								   gigdetails.gigDetails_venueName, gigdetails.gigDetails_venueAddress, gigdetails.gigDetails_venueCity, gigdetails.gigDetails_venueState, gigdetails.gigDetails_venueZip, gigdetails.gigDetails_venueEnvironment,
							           gigdetails.gigDetails_gigManName, gigdetails.gigDetails_gigManEmail, gigdetails.gigDetails_gigManPhone, gigdetails.gigDetails_gigManPlay, gigdetails.gigDetails_gigManTal, gigdetails.gigDetails_gigManLoginId
							    FROM gigdetails
							    WHERE gigdetails.gigId = :gigId';
							    
					echo $getGigInfoQuery;
			/*********** END - Create query statement and do relational query on the db for gigdetails and optionally, gigmusic & gigartists ***********/

			/*************************************** Execute database query ***************************************/
				try{
					$getGigInfo = $db->prepare($getGigInfoQuery);
					$getGigInfo->bindParam(':gigId', $_POST['gigId']);
					$getGigInfo->execute(); 
					$getGigInfoResults = $getGigInfo->fetch(PDO::FETCH_ASSOC);
				}catch(Exception $e){
					echo $e; 
				}						
			/************************************ END - Execute database query ************************************/

			/* Call the clientEmail function and pass the gig info array as a function parameter */
				if($getGigInfoResults){
					/* Add additonal elements to the array parameter */
						if($_POST['clientEmail_comment'] != ''){
							$getGigInfoResults['clientEmail_comment'] = trim($_POST['clientEmail_comment']);
						}
						else{
							$getGigInfoResults['clientEmail_comment'] = 'N/A';
						}
					
					/**** Change time formats ****/
						function changeTimeFormat($today){
							$today = date_create($today);
							$today = date_format($today, 'h:ia');
							return $today; 
						}
						function changeDateFormat($today){
							$today = date_create($today);
							$today = date_format($today, 'M d, Y');
							return $today; 
						}
						// Time
							$getGigInfoResults['gigDetails_setupTime'] = changeTimeFormat($getGigInfoResults['gigDetails_setupTime']);
							$getGigInfoResults['gigDetails_startTime'] = changeTimeFormat($getGigInfoResults['gigDetails_startTime']);
							$getGigInfoResults['gigDetails_endTime'] = changeTimeFormat($getGigInfoResults['gigDetails_endTime']);
	
						// Date
							$getGigInfoResults['gigDetails_clientDepositDate'] = changeDateFormat($getGigInfoResults['gigDetails_clientDepositDate']);
							$getGigInfoResults['gigDetails_gigDate'] = changeDateFormat($getGigInfoResults['gigDetails_gigDate']);
					/* END - Change time formats */
	
					/* Call Email Function - Send email to Client */
						sendClientInvoiceEmail($getGigInfoResults);
	
					/* Create some kind of return to indicate a successful email transmission */
				}	

		}
		else{
			// Do nothing and Exit
				exit;
		}

	


	/* Code to be added to the emailFunctions page for the clientEmail function
		1. function name "clientEmail"
		2. parameter: an array 
		3. within function, foreach loop will 

	*/
?>