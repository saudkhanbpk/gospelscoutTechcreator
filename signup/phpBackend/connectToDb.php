<?php 
	 /* Include config page */
	 	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* form validation */

		if( !empty($_POST) ){
			
			if($_POST['sendConfEmail'] === 'true'){

				/* Send conf email */
					$randKey = 'joualjte092ujlasna';
					$newUserName = 'Tome';
					$newUserEmail = 'kirkddrummond@yahoo.com';
					$emailSucc = newUserConf($newUserEmail, $newUserName, $randKey);
					
				if( $emailSucc['errorcode'] === 0){
					/* Set Session var */
						$objsession->set('email_conf_code',$randKey);
						$getEmailConf = $objsession->get('email_conf_code');
				}else{
					$response['error'] = 'email_delivery_err';
				}

				/* Return Response */
					if( $getEmailConf != '' || $getEmailConf != null){
						$response['conf_sent'] = true;
					}
			}elseif( $_POST['formSubmit']){
				var_dump($_POST);
			}

			echo json_encode($response);
		}elseif( !empty($_GET) ){
			if($_GET['conf_code'] != ''){
				/* verify confirmation code */
					$getEmailConf = $objsession->get('email_conf_code');
					if($getEmailConf === $_GET['conf_code']){
						$response['conf_true'] = true;
					}else {
						$response['conf_true'] = false;
					}
			}

			echo json_encode($response);
		}
		else{
			$response['error'] = 'empty_post';
			echo json_encode($response);
		}

?>