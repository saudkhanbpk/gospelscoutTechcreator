<?php
	/* Insert New Subscribee Settings into the Subscribee Table */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/common/config.php'); 

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
	
	
	if(!empty($_POST)){
		$table = $_POST['table'];
		$iLoginID = $_POST['iLoginID'];
		if($_POST['option'] == 'muteNot' || $_POST['option'] == 'unMuteNot'){

			$field = array('muteNotification');
			if($_POST['option'] == 'muteNot'){
				$value1 = array('1');
				$action = 'muted';
			}
			else{
				$value1 = array('0');
				$action = 'unmuted';
			}
			
			
			foreach($_POST['userSubscriptions'] as $index => $value){
				$cond = 'iRollID=' . $index . ' AND iLoginID=' . $iLoginID; 
				$obj->update($field,$value1,$cond,$table);
			}

			echo $action;
		}
		elseif($_POST['option'] == 'unsubscribe'){

			foreach($_POST['userSubscriptions'] as $index => $value){
				$cond = 'iRollID=' . $index . ' AND iLoginID=' . $iLoginID; 
				$obj->delete($table,$cond);
			}
			echo 'unsubscribed';
		}
	}
	elseif(!empty($_GET)){
		if($_GET['del'] == '1'){
			/* Remove a subscription via the subscribee's profile page */
				$table = 'subscription';
				$cond = 'iRollID=' . $_GET['iRollID'] . ' AND iLoginID=' . $_GET['iLoginID']; 
				$obj->delete($table,$cond);
				echo 'unsubscribed';
			/* END - Remove a subscription via the subscribee's profile page */
		}
		elseif($_GET['add'] == '1'){
			/* Add a subscription via the subscribee's profile page */
				$query = 'SELECT usermaster.sUserType, usermaster.sFirstName, usermaster.sLastName, usermaster.sChurchName, usermaster.sGroupName, loginmaster.sEmailID
						  FROM usermaster
						  INNER JOIN loginmaster on usermaster.iLoginID = loginmaster.iLoginID
						  WHERE usermaster.iLoginID = ?
						  ';

				foreach($_GET as $newInd => $newVal){
					if($newInd != 'add'){
						try{
							$getUserInfo = $db->prepare($query);
							$getUserInfo->bindParam(1, $newVal);
							$getUserInfo->execute();
						}
						catch(Exception $e){
							echo $e;
						}
						$results = $getUserInfo->fetchAll(PDO::FETCH_ASSOC);
						$newArray[$newInd] = $results;
					}
				}
				if($newArray['iRollID'][0]['sChurchName']){
					$subscribeeName = $newArray['iRollID'][0]['sChurchName'];
				}
				elseif($newArray['iRollID'][0]['sGroupName']){
					$subscribeeName = $newArray['iRollID'][0]['sGroupName'];
				}
				else{
					$subscribeeName = $newArray['iRollID'][0]['sFirstName'] . ' ' . $newArray['iRollID'][0]['sLastName'];
				}
				//$subscriberName = $newArray['iLoginID'][0]['sFirstName'] . ' ' . $newArray['iLoginID'][0]['sLastName'];
				$field = array('iRollID', 'iLoginID', 'sEmailID', 'sName', 'sType', 'subscriberName', 'subscriberEmail');
				$value = array($_GET['iRollID'], $_GET['iLoginID'], $newArray['iRollID'][0]['sEmailID'], $subscribeeName, $newArray['iRollID'][0]['sUserType'], $subscriberName, $newArray['iLoginID'][0]['sEmailID']);
				$table = 'subscription';
				$obj->insert($field,$value,$table);
				
				echo 'added';
			/* END - Add a subscription via the subscribee's profile page */
		}
		else{
			var_dump($GET);
		//Determine if user id Column for the subscribeeSettings table or the subscriberSettings table is being used
			if($_GET['iRollID']) {
				$cond = 'iRollID=';
			}
			else{
				$cond = 'iLoginID=';
			}

		//Remove the first two elements of the array and return the values, defining the table to be updated for the correct user
			$table = array_shift($_GET); 
			$ID = array_shift($_GET);
			$cond .= $ID; 		
		
		//Define column and value arrays to be used in the table update function
			foreach($_GET as $index => $value0){
				$field[] = $index; 
				$value[] = intval($value0); 
			}
		
		//Update table to reflect settings changes
			$obj->update($field,$value,$cond,$table);
			echo 'unsubscribed';
		}
	}	
?>