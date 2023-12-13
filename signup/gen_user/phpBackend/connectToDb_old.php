<?php 
/* Require necessary docs */
	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/newHomepage/include/dbConnect.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

/* Get Date/Time */
	$today = date_create();
	$today = date_format($today, 'Y-m-d H:i:s');
	$todayDate = date_format($today, 'Y-m-d');

/* Check for that email is not used */
	if($_GET['loginmaster']['sEmailID'] !== '' && $_GET['loginmaster']['sEmailID'] !== NULL){
		$sEmailID0 = trim( $_GET['loginmaster']['sEmailID'] );
		$cond0="(sEmailID = '".$sEmailID0."' AND sUserType = 'artist') AND isActive = 1";
	    $loginrow0 = $obj->fetchRow('loginmaster',$cond0);  

	    if( count($loginrow0) > 0 ) {
	    	echo json_encode($sEmailID0.' has already been used');
	    }
	    else{
	    	echo json_encode(true);
	    }
		
	}

	/* form validation */

		if( !empty($_POST) ){
var_dump($_POST);exit;
			foreach($_POST as $col => $val){
				if( $col == 'usermaster' || 'talentmaster' || 'loginmaster'){

					if( $col == 'usermaster'){
						var_dump($val);
						foreach( $val as $usermaster_col => $usermaster_val){

							// validate first & last name 
							if( $usermaster_col == 'sFirstName' || $usermaster_col == 'sLastName'){


								$post['usermaster'][$usermaster_col] =  trim($usermaster_val);
							}

							// validate DOB
							elseif( $usermaster_col == 'dDOB'){
								$usermaster_val['month'] = intval(trim($usermaster_val['month']));
								$usermaster_val['day'] = intval(trim($usermaster_val['day']));
								$usermaster_val['year'] = intval(trim($usermaster_val['year']));

								$post['usermaster'][$usermaster_col] = $usermaster_val['year'].'-'.$usermaster_val['month'].'-'.$usermaster_val['day'];
							}

							// validate group name
							elseif( $usermaster_col == 'sGroupName' ){


								$post['usermaster'][$usermaster_col] =  trim($usermaster_val);
							}

							// Remove unneccessary & empty elemnents 
							else{
								if( $usermaster_val !== ''){
									$post['usermaster'][$usermaster_col] =  trim($usermaster_val);
								}
							}
						}
						
					}
				}else{
					// handle miscellanious elements
				}
			}

			var_dump($post);
		}else{
			$response['error'] = 'empty_post';
			echo json_encode($response);
		}

?>