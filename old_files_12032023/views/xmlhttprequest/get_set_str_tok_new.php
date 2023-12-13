<?php 

	/* Get/Set customer payment info */
		
		/* Create DB connection to Query Database for Artist info */
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		/* Include the config.php file */	
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

		/* Set Stripe's API key */	
	        // \Stripe\Stripe::setApiKey("sk_live_aUotamlUSXwgSP4o75KmRK6E"); //\Stripe\Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");
	        // \Stripe\Stripe::setApiVersion("2020-08-27");;	// \Stripe\Stripe::setApiVersion("2019-02-19");
		
			
		/* Fetch Current users info */
            $emptyArray = array();
			$columnsArray0 = array('sFirstName','sLastName','sContactEmailID','sUserType','iLoginID','str_customerID'); 
			$paramArray0['usermaster.iLoginID']['='] = $currentUserID; 
			$current_user = pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
			$customerID = $current_user['str_customerID'];
            // var_dump($current_user);exit;
			
			

            function createNewCust($current_user,$db){
                try{
                        /* Stripe Variables */
                                $stripe = new \Stripe\StripeClient(
                                        'sk_live_aUotamlUSXwgSP4o75KmRK6E'
                                );
                        $inv_pref = ucfirst(substr($current_user['sFirstName'],0,1)).ucfirst(substr($current_user['sLastName'],0,1)).$current_user['iLoginID']; 
                        $customerObj = $stripe->customers->create([
                                'description' => $current_user['sUserType'] . " on GospelScout.com",
                                "email"	=> $current_user['sContactEmailID'],
                                "name" => ucfirst($current_user['sFirstName']).' '.ucfirst($current_user['sLastName']),
                                "metadata" => [
                                        "first_name" => ucfirst($current_user['sFirstName']),
                                        "Last_name" => ucfirst($current_user['sLastName']),
                                        "user_ID" => $current_user['iLoginID']
                                ],
                        ]);
                }catch(Exception $e){
                    $response['cust_created'] = false;
                    $response['src_present'] = false; 
                    $response['stripe_error'] = $e;  
                }
                    // var_dump($customerObj['id']);
                /* Update the usermaster table with the customer id */
                    if($customerObj['id']){
                        $response['cust_created'] = true;
                        $table100 = 'usermaster';
                        $cond100 = 'iLoginID = ' . $current_user['iLoginID'];
                        $array00['str_customerID'] = $customerID = $customerObj['id']; 
                        $upD_cust = updateTable($db, $array00, $cond100, $table100);
                        // var_dump($upD_cust);
                        /* Check if usermaster updated with new customer id */
                            if($upD_cust){
                                $response['id'] = $customerObj['id'];
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
                return $response;
            }
            function checkPaymentSrc($customer){
                /****** If new customer successfully created and table updated or customer already exists check for payment src ******/
					if($customer['id'] != '' ){ // ($customer['cust_created'] && $customer['table_updated']) || 
						
						/* Check for payment src */
							try{
								$retrieveCustomer = \Stripe\Customer::retrieve($customer['id']);//$customerID
							}catch(Exception $e){
								$response['error'] = $e; 
								$response['src_present'] = false; 
							}
							$response['cust_info'] = $retrieveCustomer;
						/* Check for default source */ 
							if($retrieveCustomer['invoice_settings']['default_payment_method']){
								/* Send response indicating default src */ 
									$response['src_present'] = true; 
							}
							else{
								/* Send response indicating no default src */ 
									$response['src_present'] = false;  
									$response['error'] = 'no_payment_src';  
							}
							
						/* Check for list of payment methods */
							try{
								$stripe = new \Stripe\StripeClient(
									'sk_live_aUotamlUSXwgSP4o75KmRK6E'
								);
								$list_payment_methods =  $stripe->customers->allPaymentMethods(
									$retrieveCustomer["id"],
									['type' => 'card']
								);

								if( count($list_payment_methods['data']) > 0 ){
									foreach($list_payment_methods['data'] as $list_payment_index => $list_payment_value){
										$payment_methods[$list_payment_value['id']]['card_type'] = $list_payment_value['card']['brand'];
										$payment_methods[$list_payment_value['id']]['exp_month'] = $list_payment_value['card']['exp_month'];
										$payment_methods[$list_payment_value['id']]['exp_year'] = $list_payment_value['card']['exp_year'];
										$payment_methods[$list_payment_value['id']]['last4'] = $list_payment_value['card']['last4'];
										$payment_methods[$list_payment_value['id']]['postal_code'] = $list_payment_value['billing_details']['address']['postal_code'];
										$payment_methods[$list_payment_value['id']]['name'] = $list_payment_value['billing_details']['name'];
									}
									$response['method_count'] = count($payment_methods);
									$response['payment_methods'] = $payment_methods;
								}else{
									$response['payment_methods'] = 'none';
								}
							}catch(Exception $e){
								$response['error'] = $e;
							}
					}else{
                        $response['no_custumer_id'];
                        $response['error'] = 'no_customer_id_present';
                    }
                return $response;
            }

        if($customerID){
            /* Get customer info */
            try{
				
                $retrieveCustomer = \Stripe\Customer::retrieve($customerID); //$response = 
				
            }catch(exception $e){
                $response['src_updated'] = false;
                $response['error'] = $e;
            }
        }else{
            $retrieveCustomer = createNewCust($current_user,$db);
			// var_dump($retrieveCustomer);
        }
		

       
	    if($_POST){
			if($_POST['check_str_cust']){
				/*********************** If customer ID is not present in usermaster table, Create new customer ***********************/
					// if( $current_user['str_customerID'] == ''){	
                        // $response = createNewCust($current_user,$db);
                    // }	
				/******************** END - If customer ID is not present in usermaster table, Create new customer ********************/
					$response = checkPaymentSrc($retrieveCustomer);
					/* Return JSON Response */
                		echo json_encode($response);
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
			elseif( $_POST['action'] == 'remove_payment_method' ){
				var_dump($_POST);
				try{
					$stripe = new \Stripe\StripeClient(
						'sk_live_aUotamlUSXwgSP4o75KmRK6E'
					);
					/* Detach payment method */
						$detach_status = $stripe->paymentMethods->detach(
							$_POST['pm'],
							[]
						);
						if($detach_status['id'] != ''){
							$response['detach_status'] = true;
						}else{
							$response['detach_status'] = false;
						}
				}catch(Exception $e){
					$response['detach_status'] = false;
					$response['error'] = $e;
				}
				echo json_encode($response);
			}
			elseif( $_POST['action'] == 'update_def_payment_method' ){
				/* Get customer info */
					try{
						$retrieveCustomer = \Stripe\Customer::retrieve($customerID);
					}catch(exception $e){
						$response['src_updated'] = false;
						$response['error'] = $e;
					}
				
				/* list payment methods */ 
					try{
						$stripe = new \Stripe\StripeClient(
							'sk_live_aUotamlUSXwgSP4o75KmRK6E'
						);
						$list_payment_methods =  $stripe->customers->allPaymentMethods(
							$retrieveCustomer["id"],
							['type' => 'card']
						);

						if( count($list_payment_methods['data']) > 0 ){
							foreach($list_payment_methods['data'] as $list_payment_index => $list_payment_value){
								$payment_methods[$list_payment_value['id']]['card_type'] = $list_payment_value['card']['brand'];
								$payment_methods[$list_payment_value['id']]['exp_month'] = $list_payment_value['card']['exp_month'];
								$payment_methods[$list_payment_value['id']]['exp_year'] = $list_payment_value['card']['exp_year'];
								$payment_methods[$list_payment_value['id']]['last4'] = $list_payment_value['card']['last4'];
								$payment_methods[$list_payment_value['id']]['postal_code'] = $list_payment_value['billing_details']['address']['postal_code'];
								$payment_methods[$list_payment_value['id']]['name'] = $list_payment_value['billing_details']['name'];
								
								/* verify method exists */
									if( $_POST['stripeToken'] === $list_payment_value['id'] ){$method_exists = true;}
							}
						}
					}catch(Exception $e){
						$response['error'] = $e;
					}
					
				/* update customer default payment src */
					if( ($retrieveCustomer["id"] !== '' || $retrieveCustomer["id"] != null) && $method_exists ){
						
						try{
							$updateResponse = $stripe->customers->update(
								$retrieveCustomer["id"],
								[
									"invoice_settings" => [
										'default_payment_method' => trim($_POST['stripeToken'])
									]
								]
							);
							$newChargeMethod = $updateResponse["invoice_settings"]["default_payment_method"];
	
							if( $newChargeMethod == $_POST['stripeToken'] ){
								$response['src_updated'] = true;
								$response['cust_info'] = $newChargeMethod;
								$response['data'] = $payment_methods;
							}else{
								$response['src_updated'] = false;
								$response['error'] = 'payment_method_update_failed';
							}
						}catch(Exception $e){
							$response['src_updated'] = false;
							$response['error'] = $e;
						}
					}else{
						$response['src_updated'] = false;
						$response['error'] = 'retrieving_customer_failed';
					}
					
				/* Return JSON Response */
					echo json_encode($response);
			}
	    }elseif($_GET){
			$response['get_array'] = $_GET;
			$purchaseType = 'gig_ad';
			if($purchaseType == 'gig_ad'){
				$amount = '100';
			}
			/************** Create payment Intent ***************/
				if($_GET['setup_intent'] == 'true'){
					try{
						$stripe = new \Stripe\StripeClient(
							'sk_live_aUotamlUSXwgSP4o75KmRK6E'
						);
						$intent = $stripe->setupIntents->create(
							[
							  'customer' => $retrieveCustomer["id"],
							  'payment_method_types' => ['card'],
							]
						);
					}catch(Exception $e){
						$response['error'] = $e;
					}
				}
                elseif($_GET['create_intent'] == 'true'){
                    try{
                        $intent = \Stripe\PaymentIntent::create([
                            'amount' => $amount,
                            'currency' => 'usd',
                            'customer' => $retrieveCustomer["id"],
                            'automatic_payment_methods' => ['enabled' => true]
                        ]);
                    }catch(Exception $e){
                        $response['error'] = $e;
                    }
                }
				elseif($_GET['verify_payment_status'] == 'true')	{
					/* Retrieve and verify the status on the paymentIntent */
						$intent_id = trim($_GET['pi_id']); 
						try{
							$stripe = new \Stripe\StripeClient(
								'sk_live_aUotamlUSXwgSP4o75KmRK6E'
							);
							$payIntent = $stripe->paymentIntents->retrieve(
								$intent_id,
								[]
							);
						}catch(Exception $e){
							$response['error'] = $e;
						}
						
					/* if payment succeeded, update the paid status in the postedgigsmaster */
						if($payIntent['charges']['data'][0]['status'] == 'succeeded' && $payIntent['charges']['data'][0]['paid'] == true){
							$response['payment_verified'] = true;
							$array['paid'] = 1;
							$cond = 'gigId = "' . $_GET['gigid'] . '"';
							$paymentStatus = updateTable($db, $array, $cond, 'postedgigsmaster');
							if($paymentStatus){
								$response['payment_status_updated'] = true;
							}else{
								$response['payment_status_updated'] = false;
								$response['error'] = 'Payment status failed to updated.  Contact us.';
							}
						}else{
							$response['payment_verified'] = false;
							$response['payment_status_updated'] = false;
							$response['error'] = 'payment_intent_failure';
						}
				}	
                elseif($_GET['take_payment'] == 'true'){
                    try{
                        $intent = \Stripe\PaymentIntent::create([
                            'amount' => $amount,
                            'currency' => 'usd',
                            'customer' => $retrieveCustomer["id"],
                            'payment_method' => $retrieveCustomer['invoice_settings']['default_payment_method'],
                            'off_session' => true,
                            'confirm' => true,
                        ]);
                    }catch(Exception $e){
                        $response['error'] = $e;
                    }

                    /* if payment succeeds, update paid status in postedgigmaster */ 
                        if($intent['status'] == 'succeeded'){
                            $array['paid'] = 1;
                            $cond = 'gigId = "' . $_GET['gigid'] . '"';
                            $paymentStatus = updateTable($db, $array, $cond, 'postedgigsmaster');
                            if($paymentStatus){
                                $response['payment_status_updated'] = true;
                            }else{
                                $response['payment_status_updated'] = false;
                                $response['error'] = 'Payment status failed to updated.  Contact us.';
                            }
                        }else{
                            $response['payment_status_updated'] = false;
                            $response['error'] = 'payment_intent_failure';
                        }
                }
				$response['customer'] = $retrieveCustomer;
				$response['pay_intent'] = $intent;
				echo json_encode($response);
			/************** Create payment Intent ***************/
		}




?>