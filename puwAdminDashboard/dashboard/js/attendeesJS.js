/*************************
*** other callbacks
*************************/
	$('#attendeeCancellationModal').on('hidden.bs.modal', function (e) {
	 	document.getElementById('cancelAttendee').reset(); 
	});
/*************************
*** END - other callbacks
*************************/


/*************************
*** Get/cancel Attendees 
*************************/

/* Form Getting Attendees */
	const form1 = $('#getAttendees');

	form1.validate({

		//Error display and placement 
			errorPlacement: function(error, element) {
				console.log(error[0]['id']);
               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
	            // element.parent('div').parent('div').after(error); 
	            if(error[0]['id'] == 'attendeeStatus[]-error'){
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

			/* Get Attendees */

				/* New form object NOTE: capture FormData before hiding event modal */
					var getAttendeesFormObj = new FormData(form);
					getAttendeesFormObj.append('getAttendees', true);

				/* Show Loading spinwheel */
					displayLoadingElement('showAttendees');
				
				/* New XMLHttp Obj */
					var getAttendees_xhr = new XMLHttpRequest();
					getAttendees_xhr.onload = function(){
						if(getAttendees_xhr.status == 200){
							//console.log(getAttendees_xhr.responseText.trim() );
							var parsedResponse = JSON.parse( getAttendees_xhr.responseText.trim() );
							if( parsedResponse.attendees == false ){
								$('#showAttendees').html('<h3 class=" my-5" style="color: rgba(204,204,204,1);">There are no attendees matching this criteria</h3>');
							}
							else{
								$('#showAttendees').html( buildAttendeeTable(parsedResponse.attendees) );
							}
						}
					}	
					getAttendees_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
					getAttendees_xhr.send(getAttendeesFormObj); 
			},
		// Input rules
			rules: {
				'event': {
					required: true
				},
				'attendeeStatus[]': {
					required: true
				}
			},
			messages:{
				'event': {
					required: 'Select an Event'
				},
				'attendeeStatus[]': {
					required: 'Select @ least one'
				}
			}
	});
/* END - Form Getting Attendees */	

/* Form Cancelling Attendees */
	const form2 = $('#cancelAttendee');

	form2.validate({

		//Error display and placement 
			errorPlacement: function(error, element) {
				console.log(error[0]['id']);
               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
	            // element.parent('div').parent('div').after(error); 
	            element.after(error);
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

			/* Get Attendees */

				/* New form object NOTE: capture FormData before hiding event modal */
					var cancelAttendeesFormObj = new FormData(form);
					cancelAttendeesFormObj.append('adminAction', true);
					cancelAttendeesFormObj.append('action', 'cancelAttendee');

				/* Show Loading spinwheel */
					displayLoadingElement('showAttendees');
				
				/* New XMLHttp Obj */
					var cancelAttendees_xhr = new XMLHttpRequest();
					cancelAttendees_xhr.onload = function(){
						if(cancelAttendees_xhr.status == 200){
							document.getElementById('cancelAttendee').reset(); 
							$('#attendeeCancellationModal').modal('hide');
							var parsedResponse = JSON.parse( cancelAttendees_xhr.responseText.trim() );
							if( parsedResponse.attendees == false ){
								$('#showAttendees').html('<h3 class=" my-5" style="color: rgba(204,204,204,1);">There are no attendees matching this criteria</h3>');
							}
							else{
								$('#showAttendees').html( buildAttendeeTable(parsedResponse.attendees) );
							}
						}
					}	
					cancelAttendees_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
					cancelAttendees_xhr.send(cancelAttendeesFormObj); 
			},
		// Input rules
			rules: {
				'attendeeCancellationReason': {
					required: true
				},
			},
			messages:{
				'attendeeCancellationReason': {
					required: 'Cancellation Reason Required!!!'
				},
			}
	});
/* END - Form Cancelling Attendees */	


/* Form Selecting Attendees */
const form3 = $('#selectAttendee');

	form3.validate({

		//Error display and placement 
			errorPlacement: function(error, element) {
				console.log(error[0]['id']);
               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
	            element.after(error);
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

			/* Get Attendees */

				/* New form object NOTE: capture FormData before hiding event modal */
					var selectAttendeesFormObj = new FormData(form);
					selectAttendeesFormObj.append('adminAction', true);
					selectAttendeesFormObj.append('action', 'selectAttendee');

				/* Show Loading spinwheel */
					displayLoadingElement('showAttendees');
				
				/* New XMLHttp Obj */
					var selectAttendees_xhr = new XMLHttpRequest();
					selectAttendees_xhr.onload = function(){
						if(selectAttendees_xhr.status == 200){
							document.getElementById('cancelAttendee').reset(); 
							$('#attendeeSelectionModal').modal('hide');
							var parsedResponse = JSON.parse( selectAttendees_xhr.responseText.trim() );
							if( parsedResponse.attendees == false ){
								$('#showAttendees').html('<h3 class=" my-5" style="color: rgba(204,204,204,1);">There are no attendees matching this criteria</h3>');
							}
							else{
								$('#showAttendees').html( buildAttendeeTable(parsedResponse.attendees) );
							}
						}
					}	
					selectAttendees_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
					selectAttendees_xhr.send(selectAttendeesFormObj); 
			}
	});
/* END - Form Selecting Attendees */	

/*************************
*** END - Get/cancel  Attendees 
*************************/

/*************************
*** Admin Actions
*************************/
	
	/* Cancel or Select attendees */
		$('#showAttendees').on('click', '.adminAction', function(event){
			/* define vars */
				var attendeeID = $(this).attr('attendeeID');
				var attendeeStatus = $(this).attr('attendeeStatus');
				var adminAction = $(this).attr('action');
				var eventID = $(this).attr('eventID');

			/* Trigger Cancellation Reason - else select attendee for event */
				if(adminAction == 'cancel'){
					$('#cancelAttendee input[name=event]').val(eventID);
					$('#cancelAttendee input[name=id]').val(attendeeID);
					$('#cancelAttendee input[name=status]').val(attendeeStatus);
					$('#attendeeCancellationModal').modal('show');
				}
				else if('Select to Attend'){
					$('#selectAttendee input[name=event]').val(eventID);
					$('#selectAttendee input[name=id]').val(attendeeID);
					$('#selectAttendee input[name=status]').val(attendeeStatus);
					$('#attendeeSelectionModal').modal('show');
				}
		});
/*************************
*** END - Admin Actions
*************************/

/*******************************
*** Send Attendee Emails
*******************************/

	/* Select all signed up users */
		$('#showAttendees').on('click','#sel_attendee_all',function(event){
			var is_checked =  $(this).is(':checked');
			$('#group_type').val('');
			$('#show-err').html('');

			if(is_checked){
				/* Check all boxes */
					$('.sel_attendee').each(function(event){
						$(this).prop('checked',true);
					});
			}
			else{
				/* Un-Check all boxes */
					$('.sel_attendee').each(function(event){
						$(this).prop('checked',false);
					});
			}
		});

	/* Select users based on the selected Email group */
		$('#showAttendees').on('change','#group_type',function(event){
			var email_type = $(this).val();

			$('#sel_attendee_all').prop('checked',false);
			$('.sel_attendee').prop('checked',false);

			/* Insert proper values into send email modal */
				if(email_type == 'email-selected'){
				console.log('test:'+email_type);
					/* Check all boxes for users selected to attend */
						$('.sel_attendee').each(function(event){
							var attendee_status = $(this).attr('status');
							if(attendee_status == 'selectedToAttend'){
								$(this).prop('checked',true);
							}
						});
				}
				else if(email_type == 'email-confirmed'){
				console.log('test:'+email_type);
					/* Check all boxes for users on stand by */
						$('.sel_attendee').each(function(event){
							var attendee_staus = $(this).attr('status');
							if(attendee_staus == 'confirmedAttendance'){
								$(this).prop('checked',true);
							}
						});
				}
				else if(email_type == 'email-standby'){
				console.log('test:'+email_type);
					/* Check all boxes for users on stand by */
						$('.sel_attendee').each(function(event){
							var attendee_staus = $(this).attr('status');
							if(attendee_staus == 'standBy'){
								$(this).prop('checked',true);
							}
						});
				}
		});

	
	/* Clear the error message when a user is selected */
		$('#showAttendees').on('click','.sel_attendee',function(){
			$('#show-err').html('');
		});

	/* Insert email type into conf modal and event id into the form */
		$('#showAttendees').on('change','#sel_email_type',function(event){
			var email_type =  $(this).val();
			// var eventID = $(this).attr('eventID');
			$('#email_type').html(email_type); 
			$('input[name=email_type]').val( email_type ); 
			$('input[name=eventID]').val( $(this).attr('eventID') );
		});
	
	/* Trigger Email Confirmation Modal */
		$('#showAttendees').on('click','#trigger-email-conf',function(){
			/* Check if @ least 1 attendee and email type is selected */
				var recipient_counter = 0; 
				$('.sel_attendee').each(function(event){
					var is_checked =  $(this).is(':checked');
					if(is_checked){
						recipient_counter += 1; 
					}
				});

				var e_type = $('select[name=sel_email_type]').val(); 

			/* Trigger conf modal if recipient_counter > 0 - else show error message */
				if(recipient_counter > 0 && e_type != ''){
					/* Show email modal */
						$('#emailSelectedModal').modal('show');
				}
				else{
					console.log(recipient_counter);
					/* Show error message */
						$('#show-err').html('<p style="font-size:.8em" class="text-danger">Please Select Email Recipient(s) & Email Type</p>');
				}
		});

	/* Send Attendee emails */
		$('#send_attendee_emails_button').click(function(event){
			
			var form = document.forms.namedItem('send_attendee_emails1');
			var email_formObj = new FormData(form);

			var send_email_xhr = new XMLHttpRequest(); 
			send_email_xhr.onload = function(){
				if(send_email_xhr.status == 200){
					var response = send_email_xhr.responseText.trim(); 
					 console.log(response);
					var parsedResponse = JSON.parse(response);
					// console.log(parsedResponse);

					/* display appropriate message if all emails sent */
						if( parsedResponse.all_emails_sent){
							form.reset(); 
							$('#group_type').val('');
							$('#show-err').html('');

							$('#email_sent_mess').html('<p class="text-success" style="font-size: 1.5em;">All Emails Sent Successfully!</p>');
						}
						else{
							$('#email_sent_mess').html('<p class="text-warning" style="font-size: 1.5em;">Problem Sending All Emails</p>');
						}
						form1.submit(); 
						$('#emailSelectedModal').modal('hide');
						$('#emails_sent').modal('show');
					
				}
			}
			send_email_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
			send_email_xhr.send(email_formObj);

		});
/*******************************
*** END - Send Attendee Emails
*******************************/

