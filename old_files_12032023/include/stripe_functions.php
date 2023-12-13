<?php 
/******************************************** Stripe Functions Page ********************************************/
	/* Constants */
		$platform_application_fee = 150;

	/* Create Customer Object */
		function CreateCustomer($user){
			try{
				$customerObj = \Stripe\Customer::create([
					"description" => $userType . " on GospelScout.com",
					"email"	=> $user['sContactEmailID'],
					"invoice_prefix" => $inv_pref,
					"metadata" => [
						"first_name" => ucfirst($user['sFirstName']),
						"Last_name" => ucfirst($user['sLastName']),
						"user_ID" => $user['iLoginID']
					],
				]);

				return $customerObj; 
			}
			catch(Exception $e){
				return $e; 
			}
		}


	/* Create Connect Account */
		function CreateConnectAccount($user) {

			// Create unix time stamp 
				$currentDateTime = date_create();
				$currentDateTime = date_format($currentDateTime, 'U');
				
				$bdate = date_create( $user['dDOB'] ); 
				$bday = date_format($bdate, 'j');
				$bmonth = date_format($bdate, 'n');
				$byear = date_format($bdate, 'Y');

			// Create Connected Account 
			try{
				$acct = \Stripe\Account::create([
			        'type' => 'custom',
			        'country' => 'US',
			        'business_type' => 'individual',
						'business_profile' => [
							'product_description' => 'Performing Arts Services',
						],
			        'requested_capabilities' => [
			        	'card_payments',
			        	'transfers',
			        ],

			        'email' => $user['sEmailID'],

			        'individual' => [
			          'dob' => [
			            'day' => $bday,
			            'month' => $bmonth,
			            'year' => $byear,
			          ],
					  // 'ssn_last_4' => $user['ssn'],
			          'email' => $user['sEmailID'],
			          'first_name' => $user['sFirstName'],
			          'last_name' => $user['sLastName'],
			          'phone' => $user['phone'],
			          // 'city' => $user['city'],
			          // 'state' => $user['state'],
			          // 'address.line1' => $user['address'],
			        ],

			        'metadata' => [
			          'iLoginID' => $user['iLoginID'],
			        ],

			        'settings' => [
			          'card_payments' => [
			            // 'decline_on' => [
			            //   'avs.failure',
			            //   'cvc_failure'
			            // ],
			            'statement_descriptor_prefix' => 'User_'.$user['iLoginID'],
			          ],
			          'payouts' => [
			            'debit_negative_balances' => true,
			            'schedule' => [
			              'interval' => 'manual',
			            ],
			          ]
			        ],

				   'external_account' => [
				   	'object' => 'bank_account',
				   	'country' => 'US',
				   	'currency' => 'usd',
				   	'account_holder_name' => $user['acct_holder_name'],
				   	'account_holder_type' => 'individual',
				   	'routing_number' => $user['acct_routing_number'],
				   	'account_number' =>$user['acct_number'],
				   ],

			        'tos_acceptance' => [
			          'date' => $user['today_UnixTimestamp'],
			          'ip' => $user['user_ip'],
			        ]
			    ]);

				return $acct; 
			}
			catch(Exception $e){
				return $e; 
			}
		}

	/* Create A Stripe Subscription */
		function CreateSubscription($customerObj) {
			try{
				$createSubscription = \Stripe\Subscription::create([
				  "customer" => $customerObj['id'],
				  "items" => [
				    [
				      "plan" => "plan_EeV4xKiSBOKnZt",
				    ],
				    [
				      "plan" => "plan_EeV9Y70nK2FFGp",
				    ]
				  ],
				  "trial_period_days" => 30
				]);

				return $createSubscription;
			}catch(Exception $e){
				echo $e;
			}

		}

	/* Create a Onboarding Link */
		function createOnboardingLink($newAcct){
			$acct_link = \Stripe\AccountLink::create([
				'account' => $newAcct['id'],
				'failure_url' => 'https://dev.gospelscout.com/views/artistprofile.php?str_failure=true',
				'success_url' => 'https://dev.gospelscout.com/views/artistprofile.php?str_success=true',
				'type' => 'custom_account_verification',
				'collect' => 'eventually_due'
			]);

			return $acct_link;
		}



	/* Retrieve Account Obj */
		function RetrieveConnectAccount($user_acct) {
			try{
				$acct = \Stripe\Account::retrieve( $user_acct );
			}catch(\Stripe\Exception\CardException $e) {
			  // Since it's a decline, \Stripe\Exception\CardException will be caught
			  $acct['status'] = 'Status is:' . $e->getHttpStatus() . '\n';
			  $acct['type'] = 'Type is:' . $e->getError()->type . '\n';
			  $acct['code'] = 'Code is:' . $e->getError()->code . '\n';
			  // param is '' in this case
			  $acct['param'] = 'Param is:' . $e->getError()->param . '\n';
			  $acct['message'] = 'Message is:' . $e->getError()->message . '\n';
			  $acct['exception'] = $e;
			} catch (\Stripe\Exception\RateLimitException $e) {
			  $acct['status'] =  "Too many requests made to the API too quickly";
			  $acct['exception'] = $e;
			} catch (\Stripe\Exception\InvalidRequestException $e) {
			  $acct['status'] =  "Invalid parameters were supplied to Stripe's API";
			  $acct['exception'] = $e;
			} catch (\Stripe\Exception\AuthenticationException $e) {
			  $acct['status'] =  "Authentication with Stripe's API failed";
			  $acct['exception'] = $e;
			  // (maybe you changed API keys recently)
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $acct['status'] =  "Network communication with Stripe failed";
			  $acct['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $acct['status'] =  "API Error - Contact Us!!!";
			  $acct['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $acct['status'] =  "Something else happened, completely unrelated to Stripe";
			  $acct['exception'] = $e;
			}
			
			return $acct;
		}
		
	/* Retrieve Account Balance */
	 	function RetrieveConnectAccountBalance($user_acct) {
	 		try{
	 			$balance = \Stripe\Balance::retrieve( ["stripe_account" => $user_acct] ); 
			}catch(\Stripe\Exception\CardException $e) {
			  // Since it's a decline, \Stripe\Exception\CardException will be caught
			  $balance['status'] = 'Status is:' . $e->getHttpStatus() . '\n';
			  $balance['type'] = 'Type is:' . $e->getError()->type . '\n';
			  $balance['code'] = 'Code is:' . $e->getError()->code . '\n';
			  // param is '' in this case
			  $balance['param'] = 'Param is:' . $e->getError()->param . '\n';
			  $balance['message'] = 'Message is:' . $e->getError()->message . '\n';
			  $balance['exception'] = $e;
			} catch (\Stripe\Exception\RateLimitException $e) {
			  $balance['status'] =  "Too many requests made to the API too quickly";
			  $balance['exception'] = $e;
			} catch (\Stripe\Exception\InvalidRequestException $e) {
			  $balance['status'] =  "Invalid parameters were supplied to Stripe's API";
			  $balance['exception'] = $e;
			} catch (\Stripe\Exception\AuthenticationException $e) {
			  $balance['status'] =  "Authentication with Stripe's API failed";
			  $balance['exception'] = $e;
			  // (maybe you changed API keys recently)
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $balance['status'] =  "Network communication with Stripe failed";
			  $balance['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $balance['status'] =  "API Error - Contact Us!!!";
			  $balance['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $balance['status'] =  "Something else happened, completely unrelated to Stripe";
			  $balance['exception'] = $e;
			}
			
			return $balance; 
		}
		
	/* Retrieve customer object */
		function retrieveCustomer($customerID){
			try{
				$retrieveCustomer = \Stripe\Customer::retrieve($customerID);
			}catch(\Stripe\Error\ApiConnection $e){
				$retrieveCustomer['status'] =  "Network communication with Stripe failed";
			  	$retrieveCustomer['exception'] = $e;	
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $retrieveCustomer['status'] =  "Network communication with Stripe failed";
			  $retrieveCustomer['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $retrieveCustomer['status'] =  "API Error - Contact Us!!!";
			  $retrieveCustomer['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $retrieveCustomer['status'] =  "Something else happened, completely unrelated to Stripe";
			  $retrieveCustomer['exception'] = $e;
			}

			return $retrieveCustomer;
		}
		
	/* Create a Charge on a Customer's Payment Source Token */
		function ChargeCustmerPaymentSrc($user) {
			try{
				$charge = \Stripe\Charge::create([
				    'amount' => $user['charged_amount'],
				    'currency' => 'usd',
				    "customer" => $user['customer'],
				    'source' => $user['tok_visa'],
				    'receipt_email' => $user['email'],
				    'description' => $user['description']
				]);

			} catch(\Stripe\Exception\CardException $e) {
			  // Since it's a decline, \Stripe\Exception\CardException will be caught
			  $charge['status'] = 'Status is:' . $e->getHttpStatus() . '\n';
			  $charge['type'] = 'Type is:' . $e->getError()->type . '\n';
			  $charge['code'] = 'Code is:' . $e->getError()->code . '\n';
			  // param is '' in this case
			  $charge['param'] = 'Param is:' . $e->getError()->param . '\n';
			  $charge['message'] = 'Message is:' . $e->getError()->message . '\n';
			  $charge['exception'] = $e;
			} catch (\Stripe\Exception\RateLimitException $e) {
			  $charge['status'] =  "Too many requests made to the API too quickly";
			  $charge['exception'] = $e;
			} catch (\Stripe\Exception\InvalidRequestException $e) {
			  $charge['status'] =  "Invalid parameters were supplied to Stripe's API";
			  $charge['exception'] = $e;
			} catch (\Stripe\Exception\AuthenticationException $e) {
			  $charge['status'] =  "Authentication with Stripe's API failed";
			  $charge['exception'] = $e;
			  // (maybe you changed API keys recently)
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $charge['status'] =  "Network communication with Stripe failed";
			  $charge['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $charge['status'] =  "API Error - Contact Us!!!";
			  $charge['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $charge['status'] =   "Payment Error - Contact Us";
			  $charge['exception'] = $e;
			}

			return $charge;
		}

	/* Create a charge on behalf of a Connected Account */

		/* Create a Destination Charge */
			function createDestinationCharge($charge) {
				$charge = \Stripe\Charge::create([
				  "amount" => $charge['charged_amount'],
				  "currency" => "usd",
				  "source" => $charge['tok_visa'],
				  "transfer_data" => [
				    "destination" => $charge['connect_account_id'],
				  ],
				]);
			}
		/* Create a Direct Charge  - Recommneded for standard accounts */
			// function createDirectCharge($charge) {
			// 	$charge = \Stripe\Charge::create( [
			// 	  "amount" => $charge['charged_amount'],
			// 	  "currency" => "usd",
			// 	  "source" => $charge['tok_visa'],
			// 	  "application_fee_amount" => $platform_application_fee,
			// 	], ["stripe_account" => $charge['connect_account_id'] );
			// }

		/* Create a Separate Charge & Transfer */
			function createSeparateChargeTransfer($charge) {
				// Create a Charge:
					$charge = \Stripe\Charge::create([
					  "amount" => $charge['charged_amount'],
					  "currency" => "usd",
					  "source" => $charge['tok_visa'],
					  "transfer_group" => $charge['gig_id'],
					]);

				// Create a Transfer to a connected account (later):
					$transfer = \Stripe\Transfer::create([
					  "amount" => $charge['transfer_amount'],
					  "currency" => "usd",
					  "destination" => $charge['connect_account_id'],
					  "transfer_group" => $charge['gig_id'],
					]);
			}	

	/* Create a Charge on a Connected Account - By creating a charge or Initiating a transfer - for pay to the Platform's account */
		// Create Charge
			function ChargeConnectAcct($user) {
				try{
					$charge = \Stripe\Charge::create([
					  "amount"   => $user['charged_amount'],
					  "currency" => "usd",
					  "source" => $user['connect_account_id'],
					]);

					return $charge; 
				}
				catch(Exception $e){
					return $e; 
				}

			}

		//  Initiate Transfers 
			// function TransferFromConnectAcct($transfer_obj) {

			// 	$transfer = \Stripe\Transfer::create([
			// 	  [
			// 	    "amount" => $transfer_obj['charged_amount'],
			// 	    "currency" => "usd",
			// 	    "destination" => $transfer_obj['platform_account_id'],
			// 	  ] ,
			// 	   ["stripe_account" => $transfer_obj['connect_count_id']
			// 	]);

			// 	return $transfer; 
			// }

	/* Send money to connect account via transfer */
		function TransferToConnectAcct($transfer_obj) {
			try{
				$transfer = \Stripe\Transfer::create([
				    "amount" => $transfer_obj['charged_amount'],
				    "currency" => "usd",
				    "destination" => $transfer_obj['destination_acct'],
				]);
			} catch(\Stripe\Error\ApiConnection $e){
				$transfer['status'] =  "Network communication with Stripe failed";
			  	$transfer['exception'] = $e;	
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $transfer['status'] =  "Network communication with Stripe failed";
			  $transfer['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $transfer['status'] =  "API Error - Contact Us!!!";
			  $transfer['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $transfer['status'] =  "Something else happened, completely unrelated to Stripe";
			  $transfer['exception'] = $e;
			}
			 return $transfer;
		}

	/* Create a transfer reversal */
		function ReverseTransfer($transfer_id){
			try{
				$transfer = \Stripe\Transfer::createReversal($transfer_id);

			} catch(\Stripe\Error\ApiConnection $e){
				$transfer['status'] =  "Network communication with Stripe failed";
			  	$transfer['exception'] = $e;	
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $transfer['status'] =  "Network communication with Stripe failed";
			  $transfer['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $transfer['status'] =  "API Error - Contact Us!!!";
			  $transfer['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $transfer['status'] =  "Something else happened, completely unrelated to Stripe";
			  $transfer['exception'] = $e;
			}
			return $transfer;
		}
		
	/* Retrieve a transfer */
		function RetrieveTransfer($transfer_id){
			try{

				$transfer = \Stripe\Transfer::retrieve($transfer_id);

			} catch(\Stripe\Error\ApiConnection $e){
				$transfer['status'] =  "Network communication with Stripe failed";
			  	$transfer['exception'] = $e;	
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $transfer['status'] =  "Network communication with Stripe failed";
			  $transfer['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $transfer['status'] =  "API Error - Contact Us!!!";
			  $transfer['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $transfer['status'] =  "Something else happened, completely unrelated to Stripe";
			  $transfer['exception'] = $e;
			}

			return $transfer;
		}

	/* Standard Payout out */
		function standardPayout($payout_obj){
			try{
				$payout = \Stripe\Payout::create([
					'amount' => $payout_obj['amount'],
					'currency' => 'usd',
				], ['stripe_account' => $payout_obj['acct_id'] ]);

			} catch(\Stripe\Error\ApiConnection $e){
				$payout['status'] =  "Network communication with Stripe failed";
			  	$payout['exception'] = $e;	
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $payout['status'] =  "Network communication with Stripe failed";
			  $payout['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $payout['status'] =  "API Error - Contact Us!!!";
			  $payout['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $payout['status'] =  "Something else happened, completely unrelated to Stripe";
			  $payout['exception'] = $e;
			}
			return $payout;
		}

	/* Specified Source Payout out */
		function specifiedSourcePayout(){
			try{
				$payout = \Stripe\Payout::create([
					"amount" => $payout_obj['amount'],
					"currency" => "usd",
					"source_type" => $payout_obj['source_type']
                		]);

			} catch(\Stripe\Error\ApiConnection $e){
				$payout['status'] =  "Network communication with Stripe failed";
			  	$payout['exception'] = $e;	
			} catch (\Stripe\Exception\ApiConnectionException $e) {
			  $payout['status'] =  "Network communication with Stripe failed";
			  $payout['exception'] = $e;
			} catch (\Stripe\Exception\ApiErrorException $e) {
			  $payout['status'] =  "API Error - Contact Us!!!";
			  $payout['exception'] = $e;
			  // yourself an email
			} catch (Exception $e) {
			  $payout['status'] =  "Something else happened, completely unrelated to Stripe";
			  $payout['exception'] = $e;
			}
		}










?>