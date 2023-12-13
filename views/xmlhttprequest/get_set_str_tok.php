<?php 
	/* Get/Set customer payment info */
		
		/* Create DB connection to Query Database for Artist info */
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		/* Include the config.php file */	
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		/* Include composer's autoload file to automatically retrieve the needed package */	
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
		/* Set Stripe's API key */	
	        \Stripe\Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");
	        \Stripe\Stripe::setApiVersion("2019-02-19");

		/* Pages functions */
		// var_dump($_POST);
		//var_dump($currentUserID);
		
		if($_POST){
			$emptyArray = array();
			/* Fetch Current users info */
				$columnsArray0 = array('sFirstName','sLastName','sContactEmailID','sUserType','iLoginID','str_customerID'); 
				$paramArray0['usermaster.iLoginID']['='] = $currentUserID; 
				$current_user = pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
				//var_dump( $current_user );
				//exit;
			if($_POST['create_str_cust']){
				/**************************************************** create a stripe customer ****************************************************/
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
						$response['error'] = $e; 
					}
					
					/* Update the usermaster table with the customer id */
						if($customerObj['id']){
							$response['cust_created'] = true;
							$table100 = 'usermaster';
							$field100[] = 'str_customerID';
							$value100[] = $customerObj['id'];
							$cond100 = 'iLoginID = ' . $current_user['iLoginID'];
							$upD_cust = $obj->update($field100,$value100,$cond100,$table100);
						}
						else{
							$response['cust_created'] = false;
							$response['error'] = 'create_cust_unkn_failure'; 
						}
						
					/* Check if usermaster updated with new customer id */
						if($upD_cust){
							$response['table_updated'] = true;
						}
						else{
							$response['table_updated'] = false;
							$response['table_upd_err'] = $upD_cust;
						}
				}
				else{
					$response['cust_created'] = false;
					$response['error'] = 'cust_id_exists_in_db'; 
				}
					/* Return JSON Response */
						echo json.encode($response); 
						
				/************************************************* END - create a stripe customer *************************************************/		

			}
			else{
				/* Time Stamp */
					$today = date_create();
					$today_str = date_format($today, 'U');


				/* Retrieve customer obj from stripe using the customer id sent to this page in a post */
					if($_POST['action'] == 'check_pay_src'){

						$str_custID = $_POST['retrieve_cust']; 
						try{
							$retrieveCustomer = \Stripe\Customer::retrieve($str_custID);
						}catch(Exception $e){
							echo $e; 
						}

						/* Check for default source */ 
					                if($retrieveCustomer['default_source']){
					                	/* Send response indicating default src */ 
					                		$response['src_present'] = true; 
					                }
					                else{
					                	/* Send response indicating no default src */ 
					                		$response['src_present'] = false;  
					                }
	
				                /* Retrieve the customers usage record */
								$item = \Stripe\SubscriptionItem::retrieve($subScript_item);
								$itemUsage = $item->usageRecordSummaries(["limit" => 12]);
		                				$response['current_usage'] = $itemUsage['data'][0]['total_usage'];
		                				echo json_encode($response);

					}
					elseif($_POST['action'] == 'add_src_tok'){
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
					elseif($_POST['action'] == 'create_usage_record'){
						/* Create a new usage record */
							$createUsage_record = \Stripe\UsageRecord::create([
							  "quantity" => 1,
							  "timestamp" => $today_str,
							  "subscription_item" => $subScript_item
							]);

						/* Insert new record in the db */
							$today_db = date_format($today, 'Y-m-d H:i:s');
							$usageRecord['iLoginID'] = $_POST['iLoginID'];
							$usageRecord['usageRecordID'] = $createUsage_record['id'];
							$usageRecord['sub_itemID'] = $createUsage_record['subscription_item'];
							$usageRecord['dateTime'] = $today_db;

							$u_rec_table = 'str_usagerecordmaster';

							foreach($usageRecord as $ind => $rec){
								$field[] = $ind;
								$value[] = $rec; 
							}

							$response['u_rec_inserted'] = $obj->insert($field,$value,$u_rec_table); 
							echo json_encode($response);
					}
			}
		}
?>