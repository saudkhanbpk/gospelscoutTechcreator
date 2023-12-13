<?php 
require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/common/config.php';
require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');

extract($_POST);
$emptyArray = array(); 
if($_POST){
	if($_POST['confirmCode']){
		/* Create a randomly generated confirmation # */
			$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
			$confCode = substr($random_hash, 6, 6);

		/* Set the confirmation code in the session variable */
			$objsession->set('verification_code',$confCode); 
			// $response['session'] = $_SESSION;
			
		/* send email */
			$email_sent = newUserConf($newUserEmail, $newUserName, $confCode);
			foreach ($email_sent as $key => $value) {
				$email_response[$key] = $value; 
			}

			if( $email_response['errorcode'] == 0 && $email_response['message'] == 'OK'){
				$response['success'] = true;
			}else{
				$response['success'] = false;
				$response['errorcode'] = $email_response['errorcode'];
				$response['message'] = $email_response['message'];
			}

		/* Return JSON Response */
				echo json_encode($response);

		/* END - Return send confcode email & uniqueID to the artist.php page upon successful insertion into the signupcodeconfirmationmaster table */
	}
	elseif($_POST['sEmailID'] != '' && $_POST['sPassword'] != ''){

		$cond='sEmailID = "'.$sEmailID.'" AND sPassword = "'.md5($sPassword).'"';
		$loginrow = $obj->fetchRow('loginmaster',$cond,$db);
		
		if(count($loginrow) > 0){
		
			/**** Create Date time ****/
				$today = date_create();
				$today = date_format($today, "Y-m-d H:i:s"); 
			/* END - Create Date time */
			
			$cond='iLoginID = '.$loginrow['iLoginID'];
			$userRow = $obj->fetchRow('usermaster',$cond,$db);
			
			$paramArray2['iLoginID']['='] = $loginrow['iLoginID'];
			$accessToken = pdoQuery('googlecalendarmaster','all',$paramArray2,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
			
			if ($loginrow['isActive'] == 1 ) {
					$objsession->set('gs_user_name',$userRow['sFirstName']);
					$objsession->set('gs_login_id',$loginrow['iLoginID']);	
					$objsession->set('gs_login_email',$loginrow['sEmailID']);	
					$objsession->set('gs_login_type',$loginrow['sUserType']);
					
					if( count($accessToken) > 0){
						/* Remove unnecessary elements */
							unset($accessToken['id']);
							unset($accessToken['iLoginID']);
							unset($accessToken['lastUpdate']);

						$objsession->set('google_cal_accessToken',$accessToken); 
					}
					else{
						$objsession->set('google_cal_accessToken',''); 
					}
					
					/* Update lastlogin date/time in loginmaster table */
						$table = 'loginmaster';
						$cond = 'iLoginID = ' . $loginrow['iLoginID'];
						$field = array('lastlogin');
						$value = array($today);
						$updateArray = array("lastlogin" => $today);
						// $testInsert = $obj->update($field,$value,$cond,$table);
						$testInsert = updateTable($db, $updateArray, $cond, $table);
					/* END - Update lastlogin date/time in loginmaster table */

					if($loginrow['sUserType'] == 'church')	{
						//$responseObj['loginResponse'] =
						echo  'church';	
					}
					elseif($loginrow['sUserType'] == 'artist' || $loginrow['sUserType'] == 'group'){
						//$responseObj['loginResponse'] =
						echo  'artist';
					}
					elseif($loginrow['sUserType'] == 'gen_user'){
						//$responseObj['loginResponse'] =
						echo  'user';
					}
					elseif($loginrow['sUserType'] == 'admin'){
						//$responseObj['loginResponse'] =
						echo  'admin';
					}
			} else {
				//$responseObj['loginResponse'] =
				echo  "deactive";
			}
			
		}	
		else{
			//$responseObj['loginResponse'] =
			echo  'Please check your email or password';
		}
	}
	else{
		//$responseObj['loginResponse'] =
		echo 'Please enter your email and password';
	}
}elseif($_GET){
	if($_GET['cookieCheck']){
		/* Check if visitor accepted cookie policy */
			$cook_pol_acc = $objsession->get('cookieseAccepted');
			if($cook_pol_acc){
				// echo '<pre>';
				// var_dump($cookiesAccepted); 
				$response['cookiesAccepted'] = true; 
			}else{
				$response['cookiesAccepted'] = false; 
			}

		echo json_encode($response);
	}elseif($_GET['acceptCookie']){
		// set session var
		$objsession->set('cookieseAccepted',true);
		$cook_pol_acc = $objsession->get('cookieseAccepted');
		if($cook_pol_acc){
			// echo '<pre>';
			// var_dump($cookiesAccepted); 
			$response['cookiesAccepted'] = true; 
		}else{
			$response['cookiesAccepted'] = false; 
		}

		echo json_encode($response);
	}
}

//echo json_encode($responseObj);
?>