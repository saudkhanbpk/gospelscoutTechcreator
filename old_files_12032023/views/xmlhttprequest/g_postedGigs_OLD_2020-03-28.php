<?php 
	/* Get Posted Gigs' Data */

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* get current date and time */
		$today = date_create();
		$today = date_format($today, 'Y-m-d H:i:s');

	/* Common query params */
		$paramArray['gigDate']['>'] = $today;
		$paramArray['status']['!='] = 'cancelled';
		$paramArray['isPostedStatus']['='] = '1';

	/* Set the ORDER BY param */ 
		$orderByParam = 'gigDate';

	/* Define INNER JOIN param to get artist type*/
		$innerJoinArray = array(
								array("giftmaster","iGiftID","postedgigsmaster","artistType")
							);

	if($_GET['getPosts']){

		/* Define query function params & call the pdoQuery function */	
			$table = 'postedgigsmaster';
			$columnsArray = 'all';

			/* If the 'states' $_GET variable is present */
				if($_GET['state'] && $_GET['state'] != ''){
					$paramArray['venueState']['='] = $_GET['state'];
				}

			/* If the 'cities' $_GET variable is present */
				if($_GET['city'] && $_GET['city'] != ''){
					$paramArray['venueState']['='] = $_GET['state'];
					$paramArray['venueCity']['='] = $_GET['city'];
				}

			/* If the 'month' $_GET variable is present */
				if($_GET['month'] && $_GET['month'] != ''){
					/* Convert Month to number */
						$getMonth = date_create($_GET['month']);
						$getMonth = date_format($getMonth,'m');

					$paramArray['MONTH(gigDate)']['='] = $getMonth;
				}

			/* Call the pdoQuery function */	
				$getPosts = pdoQuery($table,$columnsArray,$paramArray, $orderByParam, $innerJoinArray);

				/* Get the artist type */
					$table1 = 'giftmaster';
					$columnsArray1 = array('name');
					$paramArray1['id']['='] = $getPosts;

		/* Create State->City->gig hierarchy array */
			foreach($getPosts as $findStates){
				/* Get Month */
					$getMonth = date_create($findStates['gigDate']);
					$getDate = date_format($getMonth,'m/d/Y');
					$getMonth = date_format($getMonth,'F');
				$findStates['gigDate'] = $getDate;
				$findStates['sGiftName'] = str_replace('_', '/', $findStates['sGiftName']);
				$postsByState[$findStates['venueState']][$findStates['venueCity']][$getMonth][] = $findStates;
			}
			/* alphabetize states */
				ksort($postsByState);

		/* Convert the postsByState array */
			if(count($postsByState) > 0) {
				echo json_encode($postsByState);
			}

	}
	elseif($_POST){
		/* for months */ 
			// $paramArray['MONTH(gigDate)']['='] = $_POST['month'];

		/* Form Validation */
			foreach ($_POST as $key => $value) {
				/* Remove additional white space from the values */
					$value = trim($value);

				if($value != ''){
					if($key == 'venueCity'){

					}
					elseif($key == 'venueZip'){
						$value = intval($value);
						if(strlen($value) !== 5) {
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid Zip Code!!!</h5></div>';
							exit; 
						} 
					}
					elseif($key == 'dDOB1'){
						if(strlen(intval($value)) > 3){
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter an Age Between 4 and 120!!!</h5></div>';
							exit;
						}
					}
					elseif($key == 'month'){
						$key = 'MONTH(gigDate)';
					}
					elseif($key =='setupTime'){
						/* Re-format the time */
							$newTime = date_create($value);
							$newTime = date_format($newTime, 'H:i:s');
							$value = $newTime;
					}
					elseif($key =='gigPay'){
						/* Convert to a float */
							$value = floatval(trim($value));

						if($value > 9999.99){
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please enter a valid number between 1.00 - 9999.99</h5></div>'; 
							exit;
						}
					}

					$post[$key] = $value;
					if($key == 'dDOB1'){
						$paramArray[$key]['<='] = $value; 
					}
					elseif($key == 'gigPay'){
						$paramArray[$key]['>='] = $value; 
					}
					else{
						$paramArray[$key]['='] = $value; 
					}
				}
			}

			/* Get the query posts */
				$table = 'postedgigsmaster';
				$columnsArray = 'all';
				$getPosts = pdoQuery($table,$columnsArray,$paramArray, $orderByParam, $innerJoinArray);

			/*Organize array by date */
				foreach($getPosts as $posts){
					/* Get Month */
						$getMonth = date_create($posts['gigDate']);
						$getDate = date_format($getMonth,'m/d/Y');
						$getMonth = date_format($getMonth,'F');
						$posts['gigDate'] = $getDate;
						$posts['sGiftName'] = str_replace('_', '/', $posts['sGiftName']);

					$orderByMonth[$getMonth][] = $posts; 
				}

			/* Convert the postsByState array */
				if(count($orderByMonth) > 0) {
					echo json_encode($orderByMonth);
				}
				else{
					$message = array("result"=>'0');
					echo json_encode($message);
				}
	}

?>


