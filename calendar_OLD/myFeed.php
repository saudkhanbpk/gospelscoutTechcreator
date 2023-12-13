<?php
	include(realpath($_SERVER['DOCUMENT_ROOT']) .'/common/config.php');
/**************************** Query Databases for Gig and Event Info *************************/
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/pdo/dbConnect.php');
		
	/* Handle Get Variable*/
		if(isset($_GET['u_Id']) > 0 && isset($_GET['status'])){
			$userLogin = intval($_GET['u_Id']);
			$privSetting = $_GET['status'];
		}
		else{
			exit('No Id or status submitted');
		}


	require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/event_gigQuery.php');
	

		//echo '<pre>';
		/*var_dump($output1);
		var_dump($output2);*/
		//var_dump($finalList); 
	

	/************************* Create JSON Feed *************************/
			
		/* JSON Encode the final events-list array and echo to the page to create JSON feed for calendarDisplay.php */
			$finalList = json_encode($finalList);
			echo $finalList;
	/************************* Create JSON Feed *************************/
?>	