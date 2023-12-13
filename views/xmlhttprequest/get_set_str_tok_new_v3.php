<?php 

	/* Get/Set customer payment info */
		
		/* Create DB connection to Query Database for Artist info */
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		/* Include the config.php file */	
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		/* Include composer's autoload file to automatically retrieve the needed package */	
			//include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
		/* Set Stripe's API key */	
	        /*\Stripe8 \Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");
	        \Stripe\Stripe::setApiVersion("2019-02-19");*/


	    if($_POST){
			$emptyArray = array();
	    	/* Fetch Current users info */
				$columnsArray0 = array('sFirstName','sLastName','sContactEmailID','sUserType','iLoginID','str_customerID'); 
				$paramArray0['usermaster.iLoginID']['='] = $currentUserID; 
				$current_user = pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
				$customerID = $current_user['str_customerID'];

			if($_POST['check_str_cust']){
				/*********************** If customer ID is not present in usermaster table, Create new customer ***********************/
					if( $current_user['str_customerID'] == ''){	
						try{
							$inv_pref = ucfirst(substr($current_user['sFirstName'],0,1)).ucfirst(substr($current_user['sLastName'],0,1)).$current_user['iLoginID']; //(users first initial+last initial+user_ID) // "invoice_prefix" => $inv_pref,
							$customerObj = \Stripe\Customer::create([
								"description" => $current_user['userType'] . " on GospelScout.com",
								"email"	=> $current_user['sContactEmailID'],
								"metadata" => [
									"first_name" => ucfirst($current_user['sFirstName']),
									"Last_name" => ucfirst($current_user['sLastName']),
									"user_ID" => $current_user['iLoginID']
								],
							]);
						}catch(Exception $e){
							$response['cust_created'] = false;
							$response['src_present'] = false; 
							$response['error'] = $e; 
						}
						
						/* Update the usermaster table with the customer id */
							if($customerObj['id']){
								$response['cust_created'] = true;
								$table100 = 'usermaster';
                                $array100 = array('str_customerID' => $customerID = $customerObj['id']);
								$cond100 = 'iLoginID = ' . $current_user['iLoginID'];
								$upD_cust = updateTable($db, $array100, $cond100, $table100);

								/* Check if usermaster updated with new customer id */
									if($upD_cust){
										$response['table_updated'] = true;
									}
									else{
										$response['table_updated'] = false;
										$response['src_present'] = false; 
										$response['error'] = $upD_cust;
									}
							}
							else{
								$response['cust_created'] = false;
								$response['src_present'] = false;
								$response['error'] = 'create_cust_unkn_failure'; 
							}
					}
				/******************** END - If customer ID is not present in usermaster table, Create new customer ********************/
					
				
				/****** If new customer successfully created and table updated or customer already exists check for payment src ******/
					if( ($response['cust_created'] && $response['table_updated']) || $current_user['str_customerID'] != '' ){
						
						/* Check for payment src */
							try{
								$retrieveCustomer = \Stripe\Customer::retrieve($customerID);
							}catch(Exception $e){
								$response['error'] = $e; 
								$response['src_present'] = false; 
							}

							/* Check for default source */ 
				                if($retrieveCustomer['default_source']){
				                	/* Send response indicating default src */ 
				                		$response['src_present'] = true;
										$response['cust_obj'] = $retrieveCustomer;
				                }
				                else{
				                	/* Send response indicating no default src */ 
				                		$response['src_present'] = false;  
				                		$response['error'] = 'no_payment_src';  
				                }
		
					   	/* Return JSON Response */
                			echo json_encode($response);
					}
				/** END - If new customre successfully created and table updated or customer already exists check for payment src *****/
			}
			elseif( $_POST['action'] == 'add_src_tok' ){
				/* Update Customer Object with payment src'default_source' => $tok, */ 
					$tok = $_POST['stripeToken'];
					$cust_id = $current_user['str_customerID']; 
					try{
						$update_cust = \Stripe\Customer::update(
							$cust_id,
							[
								'source'=> $tok,
							]
						);
						$response['src_count'] =  $update_cust['sources']['total_count']; 
						
						if( $response['src_count'] > 0){
							$response['src_updated'] = true; 
						}
						else{
							$response['src_updated'] = false; 
							$response['src_upd_err'] = $update_cust; 
						}
					}catch(Exception $e){
						$response['src_updated'] = false; 
						$response['src_upd_err'] = $e; 
					}
					
					/* Return JSON Response */
						echo json_encode($response);

			}
	    }




?>