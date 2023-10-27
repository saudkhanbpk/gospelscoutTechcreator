<?php 
	/* Require necessary docs */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Todays Date and time */
		$today = date_create(); 
		$today = date_format($today, 'Y-m-d H:i:s');
//var_dump($_POST);
//exit;
	/* Validate and submit date if $_POST var is present */
		if($_POST && $_FILES['sProfileName']['name'] != ''){

			/* Get state id */
				$state = $_POST['usermaster']['sStateName'];
				$cond = 'name = ' . $state;
				try{
					$StateIdFetch = $db->prepare('SELECT states.id FROM states WHERE states.name = ?');
					$StateIdFetch->bindParam(1, $state); 
					$StateIdFetch->execute(); 
					
					$StateId = $StateIdFetch->fetch(PDO::FETCH_ASSOC); 
				}
				catch(Exception $e){
					echo $e; 
				}
				
				$_POST['usermaster']['sStateName'] = $StateId['id'];

			$missedInputs = 0; 

			foreach ($_POST as $key0 => $value0) {
				foreach($value0 as $key1 => $value1){
					if($value1 != ''){
						$post[$key0][$key1] = $value1; 
					}
					else{
						if($key1 != 'sContactNumber' && $key1 != 'sGroupName' && $key1 != 'TalentID'){
							$missedInputs++;  
						}
					}
				}
			}
		}
		else{
			// Increase missed input count by one
				$missedInputs++;  
		}

		if($missedInputs == 0){

			/* Common Variables */
				$userType = $post['loginmaster']['sUserType']; 
				$userEmail = $post['loginmaster']['sEmailID'];
				$fileType = 'profileImg';
				$profileCreated['userType'] = $userType; 

			/* Define insert err var */
				$insertErr = array(); 

			/********************* Insert login info into the loginmaster table **********************/
				$joinDate = date_format($to, 'Y-m-d H:i:s');
				$field = array("sEmailID","sUserType","joinDate", "isActive", "managedBy");
				$value = array($userEmail,$userType, $today, 1, 'admin');		
				// $iLoginID = $obj->insert($field,$value,"loginmaster");
				$iLoginID = pdoInsert($db,$field,$value,"loginmaster");
			/************** END - Insert login info into the loginmaster table ***********************/

			if($iLoginID > 0){ // loginmaster conditional
				/************************* Insert usermaster info into the usermaster table *************************/
					$post['usermaster']['sProfileName'] = handlefileUpload($userType, $fileType, $iLoginID);
					$post['usermaster']['iLoginID'] = $iLoginID;
					$post['usermaster']['dCreatedDate'] = $today;
					$post['usermaster']['sUserType'] = $userType;
					$post['usermaster']['sContactEmailID'] = $userEmail;

					$field1 = array();
					$value1 = array(); 

					foreach($post['usermaster'] as $umIndex => $umValue){
						$field1[] = $umIndex;
						$value1[] = $umValue; 
					}

					// $iUserID = $obj->insert($field1,$value1,'usermaster');
					$iUserID = pdoInsert($db,$field1,$value1,"usermaster");
				/********************** END - Insert usermaster info into the usermaster table **********************/

				if($iUserID > 0){ // usermaster conditional
					/************************* Insert talentmaster info into the talentmaster table *************************/
						if($userType == 'artist'){
							$cond = 'isActive = 1';
							$talents = $obj->fetchRowAll('giftmaster',$cond,$db);

							foreach($talents as $talent){
								if($talent['iGiftID'] == $post['talentmaster']['TalentID']){
									$post['talentmaster']['talent'] = $talent['sGiftName'];
									break;
								}
							}

							$post['talentmaster']['iLoginID'] = $iLoginID;

							foreach($post['talentmaster'] as $tmIndex => $tmValue){
								$field2[] = $tmIndex;
								$value2[] = $tmValue; 
							}
							// $talID = $obj->insert($field2,$value2,'talentmaster');
							$talID = pdoInsert($db,$field2,$value2,"talentmaster");
						}
					/********************** END - Insert talentmaster info into the talentmaster table **********************/

					/******************** Code to create Subscribe table entries for new users *********************/
						$field = array("iRollID"); 
						$value = array($iLoginID); 
						// $subSett1 = $obj->insert($field,$value,"subscribeesetting");
						$subSett1 = pdoInsert($db,$field,$value,"subscribeesetting");

						$field = array("iLoginID"); 
						$value = array($iLoginID); 
						// $subSett2 = $obj->insert($field,$value,"subscribersetting");
						$subSett2 = pdoInsert($db,$field,$value,"subscribersetting");

						// var_dump($subSett1)		;
						// var_dump($subSett2)		;
						// exit;
						if($subSett1 > 0 && $subSett2 > 0){
							$profileCreated['profileCreate'] = true;
						}
						else{
							$profileCreated['profileCreate'] = false;	
						}

						echo json_encode($profileCreated);
					/***************** END - Code to create Subscribe table entries for new users ******************/

				}
			}
		}
		else{
			// Return the number of missed inputs via jason var
				$numbMissed['missInputs'] = $missedInputs; 
				var_dump($numbMissed);
		}



?>