
/*************************
*** Fetch Event Artists
*************************/
	/* Check for search criteria - all, paid, unpaid */
	/* Form Getting Artists */
		const form1 = $('#getArtists');

		form1.validate({
			//Error display and placement 
				errorPlacement: function(error, element) {
	               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
		            if(error[0]['id'] == 'artistStatus[]-error'){
		            	$('#checkStatus').after(error);
		            }
		            else{
		            	element.after(error);
		            }
	            },

			// Handle form when submission is In-Valid
				invalidHandler: function(event, validator){
					var numbErrors = validator.numberOfInvalids();
					if(numbErrors){
						var message = numbErrors == 1 ? 'You missed 1 field. Please Check Previous Steps.'
												  : 'You missed ' + numbErrors + ' fields. Please complete the marked fields.';
						$('div.error').html(message);
						$('div.error').show(); 
					}
					else{
						$('div.error').hide();
					}
				},

			// Handle form when submission is valid 
				submitHandler: function(form){
				/* Get Artists */

					/* New form object NOTE: capture FormData before hiding event modal */
						var getArtistsFormObj = new FormData(form);
						getArtistsFormObj.append('getArtists', true);

					/* Show Loading spinwheel */
						displayLoadingElement('showArtists');

					/* New XMLHttp Obj */
						var getArtists_xhr = new XMLHttpRequest();
						getArtists_xhr.onload = function(){
							if(getArtists_xhr.status == 200){
								var response = getArtists_xhr.responseText.trim(); 
								console.log(response)
								var parsedResponse = JSON.parse( response );
								// console.log(parsedResponse);

								if( parsedResponse.get_artists == false ){
									$('#showArtists').html('<h3 class=" my-5" style="color: rgba(204,204,204,1);">There are no artists matching this criteria</h3>');
								}
								else{
									$('#showArtists').html( buildArtistList(parsedResponse.get_artists) );
								}
							}
						}	
						getArtists_xhr.open('post','https://www.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
						getArtists_xhr.send(getArtistsFormObj); 
				},
			// Input rules
				rules: {
					'event': {
						required: true
					}
				},
				messages:{
					'event': {
						required: 'Select an Event'
					}
				}
		});
	/* END - Form Getting Attendees */	

/*************************
*** END - Fetch Event Artists
*************************/


/**************************************************************************************
*** Cancel Event Artists - subsequently, reverse-transfer (only if transfer initiated)
**************************************************************************************/
	/* check artist's playing status */
		// Artist must be confirmed or pending to cancel an artist
	
	/* Check if transfer was made to artist */	
		// if transfer was made - reverse transfer 


/**************************************************************************************
*** Cancel Event Artists - subsequently, reverse-transfer (only if transfer initiated)
**************************************************************************************/

/**********************************************************
*** Transfer/reverse-transfer & Payout money to Event Artists (All or Individally)
**********************************************************/
	/* Transfer money to all artists at once */


	/* Initiate transfer_reversal confirmation modal */
		$('#showArtists').on('click','.trans_reversal',function(){
			var transfer_action = $(this).attr('action');
			var tal_tracker_id = $(this).attr('tal_tracker_id');
			var iLoginID = $(this).attr('iLoginID');
			var transfer_id = $(this).attr('transfer_id');
			var artist_name = $(this).attr('artist_name');
			var artist_talent = $(this).attr('artist_talent');
			var amount = $(this).attr('amount');
			var gigid = $(this).attr('gigid');

			/* Artists details in modal */
				$('#rev_iLoginid').html(iLoginID);
				$('#rev_name').html(artist_name);
				$('#rev_talent').html(artist_talent);
				$('#rev_amount').html(amount);

			/* Add confirmation button attributes */
				$('#trans_reversal_button').attr('action',transfer_action);
				$('#trans_reversal_button').attr('iLoginID',iLoginID);
				$('#trans_reversal_button').attr('tal_tracker_id',tal_tracker_id);
				$('#trans_reversal_button').attr('transfer_id',transfer_id);
				$('#trans_reversal_button').attr('gigid',gigid);

			/* Change title and styling according to action */
				if(transfer_action == 'payout'){
					var title = '<span class="text-success">Confirm Payout of Transferred Payment</span>';
					var button = '<button id="trans_reversal_button" type="button" class="btn btn-sm btn-success px-5 transfer_action">Confirm</button>';
				}
				else if(transfer_action == 'transfer_reversal'){
					var title = '<span class="text-danger">Confirm Reversal of Transferred Payment</span>';
					var button = '<button id="trans_reversal_button" type="button" class="btn btn-sm btn-danger px-5 transfer_action">Confirm</button>';
				}
				$('#post_trans_conf_title').html(title);
				// $('#post_trans_conf_button').html(button);

			/* Show transfer_reversal confirmation modal */
				$('#conf_transfer_reversal').modal('show');
		});

	/* Transfer money to individual artist */	
		$('#showArtists').on('click','.transfer_action',function(){
			makeTransfer( $(this) );
		});
		$('.transfer_action').click(function(){
			makeTransfer( $(this) );
		});

		/* Clear error message with accordian section is displayed or closed */
			$('#showArtists').on('click','.clear-err-mess',function(){
				$('.err_mess').html('');
			});

	/* Refresh page when transfer action is successful */
		$('#transfer_success').on('hidden.bs.modal', function (e) {
			location.reload(); 
		})


	/* check artist's playing status */
		// Artist must be confirmed to play at the event to issue transfer 
		// Requestor status must be requestmade 


/**********************************************************
*** END - Transfer/reverse-transfer money to Event Artists
**********************************************************/