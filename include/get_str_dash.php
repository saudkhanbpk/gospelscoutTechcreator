<?php 
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	$emptyArray = array();
	if($_POST['dash_iLoginID'] > 0){
		//$columnsArray[] = 'usermaster.str_connectActID';
		$paramArray['iLoginID']['='] = $_POST['dash_iLoginID'];
		$innerJoinArray = array(
			array('states','id','usermaster','sStateName')
			);
		$newUser = pdoQuery('usermaster','all',$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
		
		if($newUser[0]['str_connectActID'] !== '' && $newUser[0]['str_connectActID'] !== NULL){ 
			try{
				$createLoginLink = \Stripe\Account::createLoginLink($newUser[0]['str_connectActID']);
				$responseObj['url'] = $createLoginLink->url;
				$responseObj['error'] = false;
			}
			catch(Exception $e){
				$responseObj['url'] = false;
				$responseObj['error'] = $e;
			}
		}
		else{
			$responseObj['url'] = false;
			$responseObj['error'] = 'no_str_id';
			
			/* if str_connectActID does not exist - Create A Stripe Connect Express Acct for current user */
			
				/* Link for express account onboarding */
					$bdate = date_create( $newUser[0]['dDOB'] ); 
					$bday = date_format($bdate, 'j');
					$bmonth = date_format($bdate, 'n');
					$byear = date_format($bdate, 'Y');
					$url = 'https://www.stage.gospelscout.com/views/artistprofile.php?artist=' . $newUser[0]['iLoginID']; 
			
					$additional_parameters = array(
							"redirect_uri" => 'https://www.stage.gospelscout.com/views/artistprofile.php',
							"client_id" => $str_client_id,
							"state" => $apiState,
							// "suggested_capabilities" => ['card_payments', 'transfers'],
							"stripe_user[email]" => $newUser[0]['sContactEmailID'],
							"stripe_user[url]" => $url,
							"stripe_user[country]" => 'US',
							"stripe_user[phone_number]" => $newUser[0]['sContactNumber'],
							"stripe_user[business_type]" => 'individual',
							"stripe_user[first_name]" => $newUser[0]['sFirstName'],
							"stripe_user[last_name]" => $newUser[0]['sLastName'],
							"stripe_user[dob_day]" => $bday,
							"stripe_user[dob_month]" => $bmonth,
							"stripe_user[dob_year]" => $byear
						);
			
					$express_acct_onboard_link = 'https://connect.stripe.com/express/oauth/authorize?';
			
					$counter = count($additional_parameters);
					$i = 0; 
					foreach($additional_parameters as $param_index => $param_value){
						
						if( $i == 0 ){
							$express_acct_onboard_link .= $param_index . '=' . $param_value;
						}
						else{
							$express_acct_onboard_link .= '&' . $param_index . '=' . $param_value;
						}
			
						$i++; 
					}
					
					$responseObj['onboard_link'] = $express_acct_onboard_link;
		}
		
		echo json_encode($responseObj);
	}




?>