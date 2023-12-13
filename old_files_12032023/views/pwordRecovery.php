<?php 
	/* Password Recovery Page */

		/* Require Config file */
      			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
    		/* Create DB connection to Query Database for Artist info */
			include(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');

		/* Trim the array */
			foreach($_POST as $index => $postItems){
				if($postItems != ''){
					if($index == 'sPassword'){
						$post[$index] = md5(trim($postItems));
					}
					else{
						$post[$index] = trim($postItems);
					}
				}
			}

		if($post['sEmailID']){

			/* Query the loginmaster for user login info */
				$query0 = 'SELECT loginmaster.iLoginID';
				if($post['sPassword']){
					$query0 .= 	', loginmaster.sPassword FROM loginmaster WHERE loginmaster.sEmailID = ?';
				}
				else{
					$query0 .= 	' FROM loginmaster WHERE loginmaster.sEmailID = ?';
				}
				try{
					$fetchUser = $db->prepare($query0); 
					$fetchUser->bindParam(1,$post['sEmailID']);
					$fetchUser->execute();
					$userID = $fetchUser->fetch(PDO::FETCH_ASSOC);
					$iLoginID = $userID['iLoginID'];
				}
				catch(Exception $e){
					echo 'Sorry Unable to retrieve your login Id from the database. Error: ' . $e; 
				}

			/* END - Query the loginmaster for user login info */

			/* Test for valiid result and get user's questions */
				if($userID){
					if(!($post['recovCode']) && !($post['sPassword'])){
						/* relational query pwordrecoverymaster & pwordrecoveryquestionmaster using loginID */
							$query1 = 'SELECT pwordrecoverymaster.*, pwordrecoveryquestionsmaster.question, usermaster.sFirstName
									   FROM pwordrecoverymaster
									   INNER JOIN pwordrecoveryquestionsmaster on pwordrecoverymaster.questionID = pwordrecoveryquestionsmaster.id
									   INNER JOIN usermaster on pwordrecoverymaster.loginID = usermaster.iLoginID
									   WHERE pwordrecoverymaster.loginID = ?';
							try{
								$getUserQuestions = $db->prepare($query1);
								$getUserQuestions->bindParam(1, $userID['iLoginID']);
								$getUserQuestions->execute(); 
								$getQuestions = $getUserQuestions->fetchAll(PDO::FETCH_ASSOC);	
							}
							catch(Exception $e){
								echo 'Sorry Unable to retrieve your security questions from the database. Error: ' . $e; 
							}
					}				
				}
				else{
					echo 'No Results';
					exit;
				}
			/* END - Test for valiid result and get user's questions */

			if($post['sQuest0']){
				/******* SUBMIT ANSWERS - need user's loginID, questionID, question Answers ********/ 
					
					/* Loop through $getQuestions array to compare user's security question answers */
						$wrongAnswer = 0; 
						foreach($getQuestions as $question){
							if($question['questionID'] == $post['questID0']){
								if(strtolower($question['answer']) != strtolower($post['sQuest0'])){
									$wrongAnswer += 1; 
								}
							}
							elseif($question['questionID'] == $post['questID1']){
								if(strtolower($question['answer']) != strtolower($post['sQuest1'])){
									$wrongAnswer += 1; 
								}
							}	
						}
					/* END - Loop through $getQuestions array to compare user's security question answers */

					/* If the wrong-answers marker, $wrongAnswer, equals zero send recovery code email */
						if($wrongAnswer > 0){
							echo 'asnwerMismatch';
						}
						else{
							/* Create hexadecimal recovery code */
								$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
								$randKey = substr($random_hash, 6, 6);

							/* Date and Time of Artist Removal */
								$today = date_create(date());
								$today = date_format($today, "Y-m-d H:i:s"); 

							/* Query the recovcodemaster table */
								$codeQuery = 'SELECT * FROM recovcodemaster WHERE loginID = ?';
								try{
									$codeExists = $db->prepare($codeQuery);
									$codeExists->bindParam(1,$iLoginID);
									$codeExists->execute();
									$codeExistsResult = $codeExists->fetchAll(PDO::FETCH_ASSOC);
								}
								catch(Exception $e){
									echo 'Sorry unable to check current recovery code status. Error: ' . $e;
									exit; 
								}
							/* END - Query the recovcodemaster table */

							/* If entry exists update, otherwise Insert */
								if($codeExistsResult){
									$newCodeQuery = 'UPDATE recovcodemaster SET recovCode = ?, timeStmp = ? WHERE loginID  = ?';
								}
								else{
									$newCodeQuery = 'INSERT INTO recovcodemaster (recovCode, timeStmp, loginID) VALUES (?, ?, ?)';
								}

								try{
									$newCodeSubmit = $db->prepare($newCodeQuery);
									$newCodeSubmit->bindParam(1,$randKey);
									$newCodeSubmit->bindParam(2,$today);
									$newCodeSubmit->bindParam(3,$iLoginID);
									$newCodeSubmit->execute();
								}
								catch(Exception $e){
									echo 'Sorry unable to update the recovery code in the database. Error: ' . $e; 
									exit;
								}
							/* END - If entry exists update, otherwise Insert */
								
							/* Email the hexadecimal recovery code to the user's email */
								if(!($e)){
									/* Define email Vars */
										$receiver = $post['sEmailID'];
										$receiverName = $getQuestions[0]['sFirstName'];
										$recovCode = $randKey;
										$actionUrl = 'https://wwww.gospelscout.com';
										$os = php_uname('n');

									/* Call the password reset function */
									 	sendPasswordReset($receiver, $receiverName, $actionUrl, $os, $recovCode);
										echo 'asnwerMatch';
								}
							/* END - Email the hexadecimal recovery code to the user's email */
						}
					/* END - If the wrong answers marker, $wrongAnswer, equals zero send recovery code email */

			}
			elseif($post['recovCode']){
				/****************** SUBMIT & VALIDATE Recovery Code - need user email address ************************/ 

					/* Query db for user's new recovery code */
						$valCodeQuery = 'SELECT recovcodemaster.recovCode FROM recovcodemaster WHERE loginID = ?';
						try{
							$valCode = $db->prepare($valCodeQuery);
							$valCode->bindParam(1,$iLoginID);
							$valCode->execute();
							$valCodeResult = $valCode->fetch(PDO::FETCH_ASSOC);
						}
						catch(Exception $e){
							echo 'Sorry unable to retrieve new recovery code from the database. Error: ' . $e; 
							exit;
						}
					/* END - Query db for user's new recovery code */

					/* Compare code submitted by user and code store in the db */
						$userSubmission = trim($post['recovCode']);
						$storedCode = trim($valCodeResult['recovCode']);

						if($userSubmission === $storedCode){
							echo 'codeValid';
						}
						else{
							echo 'codeInvalid';
						}
					/* END - Compare code submitted by user and code store in the db */

			}
			elseif($post['sPassword']){
				/* Create query statement based on whether or not we are inserting a new password */
					if($userID['sPassword'] != $post['sPassword']){
						$query1 = 'UPDATE loginmaster SET sPassword = ? WHERE loginmaster.sEmailID = ?';
						try{
							$savePword = $db->prepare($query1); 
							$savePword->bindParam(1,$post['sPassword']);
							$savePword->bindParam(2,$post['sEmailID']);
							$savePword->execute();
						}
						catch(Exception $e){
							echo $e; 
							exit;
						}
						if(!($e)){
							echo 'passwordUpdated';
						}
					}
					else{
						echo 'samePass';
					}
				/* END - Create query statement based on whether or not we are inserting a new password */
			}
			else{
				/****************** SUBMIT EMAIL - need user email address ************************/ 

				/* Create XML code to pass questions to headerNew.php page if $getQuestions isn't empty */
					if(count($getQuestions) > 0 ){
						echo '<questionFound>'; 
						for($i=0;$i<count($getQuestions);$i++){
							
							echo '<questID'.$i.'>' . $getQuestions[$i]['questionID'] . '</questID'.$i.'>';
							echo '<question'.$i.'>' . $getQuestions[$i]['question'] . '</question'.$i.'>';
							
						}
						echo '</questionFound>';
					}
					else{
						echo 'noQuestions';
					}
				/* END - Create XML code to pass questions to headerNew.php page if $getQuestions isn't empty */
			}
		}
?>