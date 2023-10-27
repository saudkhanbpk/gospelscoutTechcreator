<?php 
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	/****************** NEED TO DO *****************
		
		CHANGE THE FUNCTIONALITY FROM DELETING ALL OF THE GIG DATA AND THEN RE-INSERTING UPDATED INFO TO JUST UPDATING THE COLUMNS THAT 
		HAVE CHANGES.  

	***********************************************/

	/* Test Receive Page for the Create A Gig Form */
	if(!empty($_POST) && $_POST['gigId'] > 0) {

		/*********************** MP3 upload testing ************************/
			foreach($_FILES as $song => $songTitle) {
				if($songTitle['name'] != '') {
					$_NewFiles[$song] = $songTitle; 
				}
			}
			
			if(count($_NewFiles) > 0){  

					$target_dir =  '/Applications/MAMP/htdocs/upload/music/gigs/' . $_POST['gigId'] . '/'; 

					function moveMP3($FILES, $targetFile) {
						if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
							$uploadStatus = 'file Upload Successful';
						}	
						else {
							$uploadStatus = 'file Upload unSuccessful';
						}
					}

					//$songCount = 0; 
					foreach($_NewFiles as $songIndex => $eachSong) {
						$target_file = $target_dir. basename($eachSong['name']); 
						$audioFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$audioFileSize = $eachSong['size'];

						if(count($eachSong) > 0){
							if(!empty($eachSong['error']) && $eachSong['error'] != 4){
								echo 'There was an upload error: ' . $eachSong['error'];
							}
							elseif($audioFileType != '' && $audioFileType != "mp3"){
								echo 'Please Upload MP3 files Only!!!';
							}
							elseif($audioFileSize != '' && $audioFileSize > 12000000) {
								echo 'Your File Size Must Be Less Than 12MB';
							}
							else {
								$target_file = $target_dir. $songIndex . '.mp3';
								$_POST[$songIndex] = substr($target_file, 25); 

								if(file_exists($target_dir)) {
									moveMP3($eachSong, $target_file);
								}
								else {
									mkdir($target_dir);
									moveMP3($eachSong, $target_file);
								}
							}
						}
						//$songCount++; 
					}
			}

			/* Create permanent file location if it doesn't exist 
				1. Check if $_FILE is not empty
					a.Create a music directory for the gig if it doesn't already exist 
						1. assign appropriate permissions - default is all access to everyone
				
				3. Allow gig managers to remove songs 
					a.  MP3 will automatically be deleted after gig date
					b. Gig managers can remove songs from set and this will remove access to the MP3 automatically
				4. After Gig Date automatically remove gig music folder	
				5. Figure out solution to Audios Player not playing MP3 in Safari browser
			*/
				
		/***************** END - MP3 upload testing ********************/

		/**************** Format the date and times ********************/
			if(!empty($_POST["gigdetails_gigDate"]) && !empty($_POST["gigdetails_setupTime"]) && !empty($_POST["gigdetails_startTime"]) && !empty($_POST["gigdetails_endTime"])){
				$date = date_create($_POST["gigdetails_gigDate"]); 
				$setUpTime = date_create($_POST["gigdetails_setupTime"]);
				$startTime = date_create($_POST["gigdetails_startTime"]);
				$endTime = date_create($_POST["gigdetails_endTime"]);

				$_POST["gigdetails_gigDate"] = date_format($date, "Y-m-d");
				$_POST["gigdetails_setupTime"] = $_POST["gigdetails_gigDate"] . ' ' . date_format($setUpTime, "H-i-s");
				$_POST["gigdetails_startTime"] = $_POST["gigdetails_gigDate"] . ' ' . date_format($startTime, "H-i-s");
				$_POST["gigdetails_endTime"] = $_POST["gigdetails_gigDate"] . ' ' . date_format($endTime, "H-i-s");
			}
		/**************** END - Format the date and times ********************/
		
		/* Connect to the Database */
			require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/newHomePage/include/dbConnect.php'); 
		/* END - Connect to the Database */

		/******** Create Two-dimensional Array to Seperate data Entry by Table ************/
			$tableCat = array('gigmaster', 'gigclients', 'gigdetails', 'gigartists', 'gigmusic', 'gigrequests','gigstatus');
			foreach($_POST as $index => $formData) {
				foreach($tableCat as $category) {
					if(strpos($index, $category) !== false && strpos($slimIndex, $category) == 0) {
						if ($formData !== ""){
							if($_POST['srcPage'] == 'artistProfile'){
								$section[$category][$index] = trim($formData);
							}
							else{
								if($category == 'gigmusic' || $category == 'gigartists' || $category == 'gigrequests'){
									$Number = substr($index, '-1');
									$newIndex = rtrim($index, $Number);
									$section[$category][$Number][$newIndex] = trim($formData);
								}
								else {
									$section[$category][$index] = trim($formData);
								}
							}
						}
						if($_POST['srcPage'] == 'artistProfile'){
							$section[$category]['gigId'] = trim($_POST['gigId']);
						}
						else{
							if($category == 'gigmusic' || $category == 'gigartists' || $category == 'gigrequests'){
								$section[$category][$Number]['gigId'] = trim($_POST['gigId']);
							}
							else {
								$section[$category]['gigId'] = trim($_POST['gigId']);
							}
						}
							
					}
				}
			}
		/******** END - Create Two-dimensional Array to Seperate data Entry by Table ************/


		/*************************** Generate Query Strings ******************************/

			/* Query string - Bind Param variable Building-Function **********************/
				function bindVarArray($queryTable,$valArray, $option) {
					$query = 'INSERT INTO ' . $queryTable; 
					$string1 = ' ('; 
					$string2 = ' VALUES (';
					$bindVar;
					$counter = 1; 
					$countMax = count($valArray);
					foreach($valArray as $index => $value) {
						
						//the index !== 'gigartists_phone' is only meant to be a temporaray fix..DONT LEAVE IT LIKE THAT!!!!
						/* Problem: 11-2-2017

							For Client table query string having any of the input values match the last input field throws an error. 
						*/
						//if(end($valArray) == $value && $index !== 'gigmaster_modifiedDate' && $index !== 'gigartists_phone') {
						if($counter == $countMax){
							$string1 = $string1 . $index . ')'; 
							$string2 = $string2 . ':' . $index .  ')';
							$bindVar[] = ':' . $index . ',' . $value;
						}
						else {
							$string1 = $string1 . $index . ', '; 
							$string2 = $string2 . ':' . $index . ', '; 
							$bindVar[] = ':' . $index . ',' . $value; 
						}
						$counter += 1;		
					}
					$query = $query . $string1 . $string2; 

					if($option == 'bindParam') {
						return $bindVar; 
					}
					else {
						return $query; 
					}
				}
			/*********End - Query string-Bind Param varialble Building-Function **********/


			/* Creating Query strings for the correct tables ***********************/
				foreach($section as $tableName => $tableInput) {
					$option1 = 'query';
					$option2 = 'bindParam';
					/* if the tablename is gigMusic, gigArtist, or gigRequests then we need to access the 
					   3rd dimension of the array instead of the 2nd
					*/
					if($_POST['srcPage'] == 'artistProfile'){
						$qStrings[] = bindVarArray($tableName, $tableInput, $option1);
						$bindVar[] = bindVarArray($tableName, $tableInput, $option2); 
					}
					else{
						if($tableName == 'gigmusic' || $tableName == 'gigartists' || $tableName == 'gigrequests') {
							foreach($tableInput as $tableDataInner) {
								$qStrings[] = bindVarArray($tableName, $tableDataInner, $option1);
								$bindVar[] = bindVarArray($tableName, $tableDataInner, $option2); 							
							}
					   }
					   else{
							$qStrings[] = bindVarArray($tableName, $tableInput, $option1);
							$bindVar[] = bindVarArray($tableName, $tableInput, $option2); 
					   }	
					}	 	
				}
			/***********END - Creating Query strings for the correct tables*****/

			/* Creating Query strings for DELETING CURRENT DATA from the tables ***********************/
				if(!empty($_POST['classification']) && $_POST['classification'] == 'update') {
					/* DELETE ALL ITEMS WITH THE CURRENT GIG ID AND RE-RUN CODE BELOW TO SUBMIT UPDATED DATA TO THE DATABASE */
					$qStringDel = 'DELETE gigmaster, gigdetails, gigartists, gigrequests, gigmusic, gigclients, gigstatus FROM gigmaster
								   INNER JOIN gigdetails ON gigmaster.gigId = gigdetails.gigId
								   INNER JOIN gigartists ON gigmaster.gigId = gigartists.gigId
								   INNER JOIN gigrequests ON gigmaster.gigId = gigrequests.gigId
								   INNER JOIN gigmusic ON gigmaster.gigId = gigmusic.gigId
								   INNER JOIN gigclients ON gigmaster.gigId = gigclients.gigId
								   INNER join gigstatus ON gigmaster.gigId = gigstatus.gigId
								   WHERE gigmaster.gigId=?';
								   
					/* Update Function - Update gig info in database */
						function updateGig($field,$value,$cond,$tableName, $db){
							$columns = implode(',',$field);
							$bParam = "";
							$i=1; 
							$j= count($value);
							foreach($value as $index =>$val){
								$bindParam[] = ':'.$index.','.$val;
								if($i == $j){
									$bParam .= ':'.$index;
								}
								else{
									$bParam .= ':'.$index.",";
								}
								$i++; 
							}
							$query = "INSERT INTO " . $tableName . "(". $columns . ") VALUES (" . $bParam . ")";
							
							try{
								$update = $db->prepare($query);
								echo $query;
								foreach($bindParam as $param){
									$param1 = explode(',', $param);
									var_dump($param1);
									$update->bindParam($param1[0],$param1[1]);
								}
								$update->execute();
							}
							catch(Exception $e){
								echo 'We were unable to update your gig, please contact our customer support!!!';
								echo $e; 
							}
						}
					/* END - Update Function - Update gig info in database */

					foreach($section as $tableName => $tableContents){

						if($_POST['srcPage'] == 'artistProfile'){
							$cond = 'gigId=' . $_POST['gigId'];
							$fieldArray = '';
					 		$valueArray = '';
							foreach($tableContents as $field => $value){ 
								$fieldArray[] = $field; 
								$valueArray[] = $value; 
							}

							/* Call Update Function - Insert New table rows of data into the database */
								// updateGig($fieldArray,$valueArray,$cond,$tableName, $db);
							/* END - Call Update Function - Insert New table rows of data into the database */
							
						}
						else{
							if($tableName == 'gigmusic' || $tableName == 'gigartists' || $tableName == 'gigrequests') {
								foreach($tableContents as $tableDataInner) {
									$fieldArray = '';
						 			$valueArray = '';
						 			$cond = 'gigId=' . $_POST['gigId'] . ' AND ';  //WE MAY NEED TO USE PRIIMARY INDEX FOR THIS INSTEAD OF GIGID
									foreach($tableDataInner as $field => $value){ 
										$fieldArray[] = $field; 
										$valueArray[] = $value; 
									}
									/* Call Update Function - Insert New table rows of data into the database */
										updateGig($fieldArray,$valueArray,$cond,$tableName, $db);
									/* END - Call Update Function - Insert New table rows of data into the database */
								}
							}
							else{
								$cond = 'gigId=' . $_POST['gigId'];
								$fieldArray = '';
						 		$valueArray = '';
								foreach($tableContents as $field => $value){ 
									$fieldArray[] = $field; 
									$valueArray[] = $value; 
								}
								/* Call Update Function - Insert New table rows of data into the database */
									updateGig($fieldArray,$valueArray,$cond,$tableName, $db);
								/* END - Call Update Function - Insert New table rows of data into the database */
							}
						}
					}
					 exit;
				}
			/***********END - Creating Query strings for DELETING CURRENT DATA from the tables*****/

		/***********************END - Generate Query Strings ******************************/

 exit;
				
		/********************** Send query to the database - try/catch block ***************/

			/* If the Gig is being updated, send the DELETE query to database first then INSERT the modified data */

			$GIDtrim = trim($_POST['gigId']);

			if(!empty($_POST['classification']) && $_POST['classification'] == 'update' && !empty($qStringDel)) {
				
				try{
					$delData = $db->prepare($qStringDel);
					$delData->bindParam(1, $GIDtrim);
					$delData->execute();
				} catch(Exception $e) {
					echo 'There was a problem removing old gig data from the database!!!';
					echo $e; 
				}
				
				
				for($p=0; $p<count($qStrings);$p++) {
					try {	
						$results = $db->prepare($qStrings[$p]);
						foreach($bindVar[$p] as $paramVar) {
							$convert = explode( ',', $paramVar);
							$results->bindParam($convert[0], $convert[1]);
						}
						$results->execute(); 
					}
					catch(Exception $e){
						echo '<br>OH NO!!! There was a problem creating your gig!!! ';
						echo $e;
					}
				}	
			}
			else {
				for($p=0; $p<count($qStrings);$p++) {
					try {	
						$results = $db->prepare($qStrings[$p]);
						foreach($bindVar[$p] as $paramVar) {
							$convert = explode( ',', $paramVar);
							$results->bindParam($convert[0], $convert[1]);
						}
						$results->execute(); 
					}
					catch(Exception $e){
						echo '<br>OH NO!!! There was a problem creating your gig!!! ';
						echo $e;
					}
				}
			}
	
			header('Location: https://dev.gospelscout.com/manageBooking/innerGigPage.php?g_Id=' . $GIDtrim);
		/******************END - Send query to the database - try/catch block ***************/		
	}
	else {
		echo 'post data not sent';
	}
?>