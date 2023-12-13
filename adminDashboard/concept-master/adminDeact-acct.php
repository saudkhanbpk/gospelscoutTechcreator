<?php 
	/* Admin Deactivate account */

		/* Create DB connection to Query Database for Artist info */
        	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

    	/* Include config page */
        	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

		/* Define login id  & table1 var */
			$u_ID = $_POST['iLoginID'];
			$table1 = 'deactivationmaster';

		/* Create Time Stamp*/
			$today = date_create();
			$today = date_format($today, 'Y-m-d H:i:s');
			if($_POST['activ'] == 1){
				$_POST['reactivationDate'] = $today;
				$_POST['reactAdminId'] = $_POST['AdminId'];
				unset($_POST['AdminId']);
			}
			elseif($_POST['del_user']){
				$_POST['deletionDate'] = $today;
			}
			else{
				$_POST['deactivationDate'] = $today;
				if($_POST['art_init'] != 1){
					$_POST['deactAdminId'] = $_POST['AdminId'];
					unset($_POST['AdminId']);
				}
				else{
					unset($_POST['art_init']);
				}
				
			} 

		/* Insert into loginmaster function */
			function loginmasterInsert($u_ID,$obj,$val,$db){
				/* Update loginmaster 'isActive' column */
					$table0 = 'loginmaster';
					$table1 = 'usermaster';
					// $field0 = array('isActive');
					// $value0 = array($val);
					$cond = 'iLoginID = ' . $u_ID;
					$array0['isActive'] = $val;
					// $loginUpdated = $obj->update($field0,$value0,$cond,$table0);
					$loginUpdated = updateTable($db, $array0, $cond, $table0);
					// $usermasterUpdated = $obj->update($field0,$value0,$cond,$table1);
					$usermasterUpdated = updateTable($db, $array0, $cond, $table1);
					return $loginUpdated;
			}
		/* END - Insert into loginmaster function */

		/* Insert Deactivation or Reactivation into the deactivation table & update loginmaster */
			if($_POST['activ'] == 1){
				/* Get all the user's deactivations from the Database */
					$getDeactivationsQuery = 'SELECT * 
											  FROM deactivationmaster 
											  WHERE iLoginID = ?
											  ORDER BY deactivationDate DESC';

					try{
						$getDeactivations = $db->prepare($getDeactivationsQuery);
						$getDeactivations->bindParam(1, $u_ID);
						$getDeactivations->execute();
						$getDeactivationsResults = $getDeactivations->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(Exception $e){
						echo 'There was a problem: ' . $e; 
					}

				/* GET latest Deactivation's Id */
					$deactID = $getDeactivationsResults[0]['id'];

				/* Remove unnecessary $_POST array elements */
					unset($_POST['iLoginID']);
					unset($_POST['activ']);
					
				/* Insert into loginmaster */
					$val = 1; 
					$loginUpdated = loginmasterInsert($u_ID,$obj,$val,$db);

				/* Update deactivation table */
					$cond = 'iLoginID = ' . $u_ID . ' AND id = ' . $deactID; 
					foreach($_POST as $index => $post){
						$array1[$index] = $post;
					}
					$deactUpdated = updateTable($db, $array1, $cond, $table1);
					echo $deactUpdated;
			}
			elseif($_POST['del_user']){
				var_dump($_POST);

        /*
          tables effected by user deletion 

          General user tables
          loginmaster
          usermaster 
          talentmaster
          subscribeesettings
          subscribersettings

          Notification tables
          notificationmaster

          Posted gig tables
          postedgigmaster - postedgigneededtalentmaster
          postedgigssuggestionmaster
          postedgiginquirymaster

          Calendar table
          googlecalendarmaster

          Video Tables
          artistvideomaster
          videocommentreplies
          videocomments

          User's uploaded files - need to be deleted
          public_hmtl/upload/[user type]/[user id]/[user files]
        */
			}
			else{
				if($_POST['deactivationReason'] != '' || $_POST['artistReason'] != ''){
					/* Insert into loginmaster */
						$val = 0; 
						loginmasterInsert($u_ID,$obj,$val,$db);

					/* Insert into deactivation table */
						foreach($_POST as $index => $post){
							$field1[] = $index;
							$value1[] = $post;
						}

						
						// $deactInserted = $obj->insert($field1,$value1,$table1);
						$deactInserted = pdoInsert($db,$field1,$value1,$table1);
						echo $deactInserted;
				}
				else{
					echo 'Reason for deactivation needed!!!';
				}
			}
		/* END - Insert Deactivation or Reactivation into the deactivation table & update loginmaster */
?>