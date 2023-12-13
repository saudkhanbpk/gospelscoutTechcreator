<?php 
	/* Get/Set customer payment info */
		
		/* Create DB connection to Query Database for Artist info */
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');
		/* Include the config.php file */	
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		/* Include composer's autoload file to automatically retrieve the needed package */	
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');
		/* Set Stripe's API key */	
	        \Stripe\Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");
	        \Stripe\Stripe::setApiVersion("2019-02-19");

       /* var_dump($_POST);
			exit;*/

		/*
			1. user loads the pubGigBackbone.php page 
			2. page sends the cust id to the get_set_str_tok.php page
			3. this page retrieves customer object from stripe
			4. this page checks for payment srce
				a. If paymemt src present this page sends response indicating src true
					1. this page retrieves customers usage record, extracts usage & current pricing for display to the customer on pubGigBackbone.php
					2. on pubGigBackbone.php insert corresponding value in the "i want to play" button attr to display the correct modal
					3. Modal will display customers current usage and pricing and confirmation button to place bid.
					4. message will vary based on usage: if bids <6 or <11 display message encouraging user to bid more to decrease their bill
					5. once user confirms bid, send indication to this page to create a usage record for the apppriate subcription item
				b. if payment src not present send response indicating no default payment src is present
					1. on pubGigBackbone.php insert corresponding value in the "i want to play" button attr to display the correct modal
						a. modal with elements card form will dislay to collect the user's card info for tokenization 
						b. stripe api will tokenize card, then pubGigBackbone.php will send post to get_set_str_tok.php to update the customer object's default_src with the token
						c. Once the update returns, this page sends a response to pubGigBackbone.php to display the modal for the user to confirm their bid 
		*/

		/* Pages functions */
		if($_POST){
			/* Time Stamp */
				$today = date_create();
				$today_str = date_format($today, 'U');

			/* Get the subscription item id for the current user from the DB */
        		$table = 'str_subscriptionmaster';
        		$cond = 'iLoginID = ' . $_POST['iLoginID'];
        		$subscripInfo = $obj->fetchRow($table,$cond);
        		if($_POST['u_action'] == 'bid'){
        			$subScript_item = $subscripInfo['bidGig_itemID'];
        		}
        		elseif($_POST['u_action'] == 'post'){
        			$subScript_item = $subscripInfo['postGig_itemID'];
        		}

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
		                		$currentUsage['src_present'] = true; 
		                }
		                else{
		                	/* Send response indicating no default src */ 
		                		$currentUsage['src_present'] = false; 
		                		echo json_encode($currentUsage); 
		                }

		                /* Retrieve the customers usage record */
							$item = \Stripe\SubscriptionItem::retrieve($subScript_item);
							$itemUsage = $item->usageRecordSummaries(["limit" => 12]);
	                		$currentUsage['current_usage'] = $itemUsage['data'][0]['total_usage'];
	                		echo json_encode($currentUsage);
				}
				elseif($_POST['action'] == 'add_src_tok'){

					/* Update Customer Object with payment src'default_source' => $tok, */ 
						$tok = $_POST['stripeToken'];
						$cust_id = $_POST['cust_id'];
						try{
							$update_cust = \Stripe\Customer::update(
								$cust_id,
								[
									'source'	=> $tok,
								]
							);
							$srcCount['src_count'] =  $update_cust['sources']['total_count']; 
							echo json_encode($srcCount);
						}catch(Exception $e){
							echo $e; 
						}
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

						$u_rec_inserted['u_rec_inserted'] = $obj->insert($field,$value,$u_rec_table); 
						echo json_encode($u_rec_inserted);
				}
		}


/* Get get the subscription item for the current user from the DB */
	/*$table = 'str_subscriptionmaster';
	$cond = 'iLoginID = ' . $_POST['iLoginID'];
	$subscripInfo = $obj->fetchRow($table,$cond);
	$subScript_item = $subscripInfo['bidGig_itemID'];

	$currentUsage['src_present'] = false; 
	$item = \Stripe\SubscriptionItem::retrieve($subScript_item);  //'si_EeW74hWy8ISKU8'
	$itemUsage = $item->usageRecordSummaries(["limit" => 12]);
	$currentUsage['current_usage'] = $itemUsage['data'][0]['total_usage'];
	echo json_encode($currentUsage);
	exit;*/







?>