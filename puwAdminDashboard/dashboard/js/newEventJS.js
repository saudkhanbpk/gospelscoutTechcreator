/********************
 *** Date/Time Picker
 ********************/
	 $(function () {
		var dat = $("input[name=todaysDate]").val();
		$("#datetimepicker0").datetimepicker({
		 	format: "YYYY-MM-DD",
		 	defaultDate: false,
		 	minDate: dat,
		 	//minDate: moment(),
		 	maxDate: moment().add(1,'year'),
		 	//useCurrent: true, 
		 	allowInputToggle: true
		});
		$("#datetimepicker1").datetimepicker({
	 		format: "LT",
	        stepping: "5",
	        useCurrent: false,
	        allowInputToggle: true
		 });
		$("#datetimepicker2").datetimepicker({
	 		format: "LT",
	        stepping: "5",
	        useCurrent: false,
	        allowInputToggle: true
		 });
		$("#datetimepicker3").datetimepicker({
	 		format: "LT",
	        stepping: "5",
	        useCurrent: false,
	        allowInputToggle: true
		 });
		$("#datetimepicker4").datetimepicker({
	 		format: "LT",
	        stepping: "5",
	        useCurrent: false,
	        allowInputToggle: true
		 });
	});
/*************************
*** END - Date/Time Picker
*************************/


/* Modal Event callbacks */
	$('#show-state-based-hosts').on('hidden.bs.modal', function (e) {
 		$('#addEventModal').modal('show');
	});

	$('#show-state-based-artists').on('hidden.bs.modal', function (e) {
 		$('#addEventModal').modal('show');
	});	
	$('#event_created_success').on('hidden.bs.modal', function (e) {
 		location.reload(); 
	});
	$('#addEventModal').on('hidden.bs.modal', function (e) {
 		$('#port_link_error').html(''); 
 		$('#no_state_error').html('');

 		/* Reseet the Event Form */
			// document.getElementById("addEvent").reset();
	});
	
	$('#insertButton').on('click', '#btn_cancelEvent', function(event){
		$('#addEventModal').modal('hide');
		$('#cancEventConf').modal('show');
	});
/* END - Modal Event callbacks */

/*************************
*** Add New Event
*************************/

	/* Show 'add new host' modal */
		$('#addNewEvent').click(function(event){
			
			/* Remove Previously selected */
				$('#show_host').empty(); 

			/* show artist table */
				$('#no_current_artists').removeClass('d-none');
				$('#show_artist_table').addClass('d-none');

			/* Clear table first */
				$('#append_artist_info').empty();

			/* Insert the Create event button */
				$('#insertButton').html('<button type="submit" id="btn_addEvent" class="btn btn-block btn-sm bg-gs text-white p-2 px-0" tabindex="3" style="font-size:13px">Create Event</button>');


			/* Modal title */
				$('#newEvAtction').html('Enter Event Info Below.');

			/* Reset form and Show form modal */
				document.getElementById("addEvent").reset();
				$('#addEventModal').modal('show');

		});


	/* Form for users applying to be hosts */

	const form3 = $('#addEvent');

	form3.validate({

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
			/* vars */
				var hostID = $('input[name=hostID]').val(); 
				var formAction = $('input[name=formAction]').val();

			/* Submit new event */
				if(hostID > 0){
					
					/* New form object NOTE: capture FormData before hiding event modal */
						var newEventFormObj = new FormData(form);
						if(formAction == 'updateEvent'){
							newEventFormObj.append('updateEvent', true);
							newEventFormObj.append('eventID', $('#btn_addEvent').attr('eventID') );
						}
						else{
							/* generate gigid */
								var gen_gigId = String( uuidv1() ); 
								gigId = gen_gigId.replace(/-/g,'');
								
							newEventFormObj.append('addNewEvent', true);
							newEventFormObj.append('gigId', gigId);
						}

					/* Hide event modal and Show Loading spinwheel */
						$('#addEventModal').modal('hide');
						displayLoadingPage('show');
					
					/* New XMLHttp Obj */
						var newEvent_xhr = new XMLHttpRequest();
						newEvent_xhr.onload = function(){
							if(newEvent_xhr.status == 200){

								displayLoadingPage('hide');
							        var response = newEvent_xhr.responseText.trim();
								console.log( response );
								var parsedResponse = JSON.parse( newEvent_xhr.responseText.trim() );

								if(parsedResponse.new_event_inserted){
									if( parsedResponse.all_artist_inserted && parsedResponse.all_artistPay_inserted ){
										if( parsedResponse.all_emails_sent === true ){
											$('#succ_message').text('Event Has Been Successfully Created/Updated!!!');
										}else if( parsedResponse.all_emails_sent === 'send_error' ){
											var err_mess = 'There was trouble sending the following emails: ';
											err_mess += '<ol style="font-size:.75em;color:rgba(0,0,0,.5);">';
											for( x in parsedResponse.failed_emails){
												err_mess += '<li>'+parsedResponse.failed_emails[x]+'</li>';
											}
											err_mess += '</ol>';
											$('#succ_message').html(err_mess);
										}
										else{
											$('#succ_message').html('Emails failed to send due to the following error: <span style="font-size:.75em;color:rgba(0,0,0,.5);">'+parsedResponse.failed_emails+'</span>');
										}
									}else{
										$('#succ_message').text('There was trouble updating artist info!');
									}

								}else{
									$('#succ_message').text('There was trouble updating the event info!');
								}
								$('#event_created_success').modal('show');
							}
						}	
						newEvent_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
						newEvent_xhr.send(newEventFormObj); 
				}
				else{
					$('#port_link_error').html('Please Select a Host');
				}
			
			},
		// Input rules
			// groups:{
			// 	contactInfo: 'host_fname host_lname host_email host_phone',
			// 	location: 'host_address host_state host_zip',
			// 	addtlDeets: 'buildingType environment capacity hCapAccessible startTime endTime'
			// },
			rules: {
				'popUpWorshipState': {
					required: true
				},
				'musicStyle': {
					required: true
				},
				'date': {
					required: true,
					dateISO: true
				},
				'setupTime': {
					required: true
				},
				'startTime': {
					required: true,
				},
				'endTime': {
					required: true
				},
				'exitByTime': {
					required: true,
				},
				'hostID': {
					required: true
				},
			// 	'eventArtists': {
			// 		required: true
			//	}
			// 	'addedInfo': {
			// 		required: {
			// 			depends: function(element){
			// 				return $('#buildingType').val() == 'other';
			// 			}
			// 		}
			// 	}
			},
			messages:{
				'popUpWorshipState': {
					required: 'Please Select a State'
				},
				'musicStyle': {
					required: 'Music Style is Required'

				},
				'date': {
					required: 'Please Select a Valid Date'
				},
				'setupTime': {
					required: 'Please Select a Time'

				},
				'startTime': {
					required: 'Please Select a Time'
				},
				'endTime': {
					required: 'Please Select a Time'

				},
				'exitByTime': {
					required: 'Please Select a Time'

				},
				'hostID': {
					required: 'Please Select an Event Host'
				}
			}
	});
/* END - Form for users applying to be hosts */	

/*************************
*** END - Add New Event
*************************/
	
/*************************
*** view/Edit Event
*************************/
	/* Show 'add new host' modal */
		$('.getEvent').click(function(event){
			/* Reseet the Event Form */
				document.getElementById("addEvent").reset();

			/* vars */
				var eventID = $(this).attr('id');
				console.log(eventID);

			/* Fetch Event info */
				var fetchEvent_xhr = new XMLHttpRequest();
				fetchEvent_xhr.onload = function(){
					if(fetchEvent_xhr.status == 200){
						var response = fetchEvent_xhr.responseText.trim(); 
						//console.log( response );
						var parsedResponse = JSON.parse( response );
						console.log( parsedResponse );

						/* Insert Host Info */
							$('input[name=hostID]').val(parsedResponse['hostInfo'][0].info.host_id); 
							$('input[name=address]').val(parsedResponse['hostInfo'][0].info.host_address); 
							$('input[name=city]').val(parsedResponse['hostInfo'][0].info.host_sCityName); 
							$('input[name=state]').val(parsedResponse['hostInfo'][0].info.name); 
							$('input[name=zip]').val(parsedResponse['hostInfo'][0].info.host_zip); 
							$('#show_host').html( insertHosts(parsedResponse['hostInfo']) );

						/* Insert Event Info */
							$('select[name=popUpWorshipState]').val(parsedResponse['eventInfo'][0].state);
							$('input[name=musicStyle]').val( parsedResponse['eventInfo'][0].musicStyle );
							$('input[name=date]').val( parsedResponse['eventInfo'][0].date );
							$('input[name=setupTime]').val( parsedResponse['eventInfo'][0].setupTime );
							$('input[name=startTime]').val( parsedResponse['eventInfo'][0].startTime );
							$('input[name=endTime]').val( parsedResponse['eventInfo'][0].endTime );
							$('input[name=exitByTime]').val( parsedResponse['eventInfo'][0].exitByTime );
							$('input[name=formAction]').val( 'updateEvent' );
							
							if( parsedResponse['eventInfo'][0].cancelStatus == 0 ){
								/* Insert the Create event button */
									$('#newEvAtction').html('Enter Event Info Below.');
									var buttons = '<button type="submit" id="btn_addEvent" eventID="'+eventID+'" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Update Event</button>';
									buttons += '<button type="button" id="btn_cancelEvent" eventID="'+eventID+'" class="btn btn-block bg-danger text-white p-2" tabindex="3" style="font-size:13px">Cancel Event</button>';
									$('#insertButton').html(buttons);
							}
							else{
								/* Remove action buttons for canceled events  */
									$('#newEvAtction').html('Event Canceled');
									$('#insertButton').html('');
							}

							// console.log(parsedResponse['artistsInfo']);

						/* Insert Artists */
							/* Clear table first */
								$('#append_artist_info').empty(); 
							
							console.log( parsedResponse['artistsInfo'] );
							
							if(parsedResponse['artistsInfo']){
								for( artist in parsedResponse['artistsInfo'] ){
									
									/* Get artist's info */
										var thisArtist = parsedResponse['artistsInfo'][artist]; 
										var artist_id = thisArtist.iLoginid;
										var artist_name = thisArtist.sFirstName;
										var artist_age = thisArtist.age;
										var artist_talent = thisArtist.sGiftName;
										var artist_talent_id = thisArtist.artistType;
										var artist_pay = thisArtist.depositamount;
										var artist_tal_tracker = thisArtist.tal_tracker_id;

									/* Append artist's info to the event form's artist table */
										//var artistInfoAppend = '<tr id="artistRow_'+artist_id+'"><input class="eventArtistsList" type="hidden" name="eventArtists['+artist_id+']" artistID="'+artist_id+'" value="'+artist_talent_id+'"><td class="d-none d-md-table-cell">'+artist_id+'</td><td>'+artist_name+'</td><td>'+artist_age+'</td><td>'+artist_talent+'</td><td><button class="btn btn-sm btn-danger removeArtist" style="font-size:.8em;" artist_id="'+artist_id+'">Remove</button></td></tr>';
										var artistInfoAppend = '<tr id="artistRow_'+artist_id+'"><input class="eventArtistsList" type="hidden" name="eventArtists['+artist_id+']" artistID="'+artist_id+'" value="'+artist_talent_id+'"><td class="d-none d-md-table-cell">'+artist_id+'</td><td>'+artist_name+'</td><td>'+artist_age+'</td><td>'+artist_talent+'</td><td class="d-none d-md-table-cell">'+artist_pay+'</td><td><button class="btn btn-sm btn-danger removeArtist" style="font-size:.8em;" tal_tracker="'+artist_tal_tracker+'" artist_id="'+artist_id+'">Remove</button></td></tr>';
										
										$('#append_artist_info').append(artistInfoAppend);
								}

								/* show artist table */
									$('#no_current_artists').addClass('d-none');
									$('#show_artist_table').removeClass('d-none');
							}

							/* Show Event Form */
								$('#addEventModal').modal('show');
					}
				}
				fetchEvent_xhr.open('get','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php?fetchEvent='+eventID);
				fetchEvent_xhr.send();
		});
/*************************
*** END - view/Edit Event
*************************/

/*************************
*** Cancel Event
*************************/
	$('#cancelEventButton').click(function(event){
 		
 		/* show loading spinwheel */
 			$('#cancEventConf').modal('hide');
 			displayLoadingPage('show');

 		/* Instantiate new form data object */
			var eventID = $('#btn_cancelEvent').attr('eventID'); 
			var cancEventObj = new FormData();
			cancEventObj.append('cancelEvent', true);
			cancEventObj.append('eventID', eventID);

		/* Instantiate new xhr */
			var cancEvent_xhr = new XMLHttpRequest(); 
			cancEvent_xhr.onload = function(){
				if(cancEvent_xhr.status == 200){
					/* hide loading spinwheel */
						displayLoadingPage('hide');

					console.log( cancEvent_xhr.responseText.trim() );
					var response = cancEvent_xhr.responseText.trim();
					var parsedResponse = JSON.parse(response);
					
					if( parsedResponse.eventCanceled ){
						$('#succ_message').html('Event Has Been Canceled!!!');
						$('#event_created_success').modal('show');
					}
					else{

					}

				}
			}
			cancEvent_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
			cancEvent_xhr.send(cancEventObj);
	});

/*************************
*** END - Cancel Event
*************************/


/*************************
*** Select a New Host
*************************/
	$('#selectHostButton').click(function(event){
		event.preventDefault(); 

		/* Check for a value in the location input */
			var state = $('select[name=popUpWorshipState]').val(); 

		/* Get Hosts for the selected state */
			if(state !== ''){
				/* Show Loading spinwheel */
					$('#addEventModal').modal('hide');
					displayLoadingPage('show');

				/* Clear error div */
					$('#port_link_error').html('');

				/* Fetch Hosts for the selected city */
					var getHost_xhr = new XMLHttpRequest(); 
					getHost_xhr.onload = function(){
						if(getHost_xhr.status == 200){
							/* hide loading spinwheel */
							displayLoadingPage('hide');	

							var parsedResponse = JSON.parse( getHost_xhr.responseText.trim() );
							console.log(parsedResponse[0].info.host_id);
							if( parsedResponse[0].info.host_id !== 0 ){
								/* Insert hosts data into modal */
									$('#accordionExample').html( insertHosts(parsedResponse) );

								/* Hide Create event modal & Show Lists of hosts in that state */
									$('#host_state').text(state);
									$('#show-state-based-hosts').modal('show');
							}
							else{
								$('#addEventModal').modal('show');
								$('#port_link_error').html('No Hosts Available');

							}
						}
					}
					getHost_xhr.open('get','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php?get_hosts_in_state=true&state='+state);
					getHost_xhr.send(); 
			}
			else{
				/* Hide Create event modal & Show Lists of hosts in that state */
					let action = 'hide';
					displayLoadingPage(action);	
					$('#port_link_error').html('Please select a state for the event');
			}
	});
	
	/* Place selected host in event form */
		$("#accordionExample").on("click", '#sel-host-button', function(event){
			
			var host_id = $(this).attr('hostID'); 
			var hostById_xhr = new XMLHttpRequest(); 
			hostById_xhr.onload = function(e){
				if(hostById_xhr.status == 200){
					
					var parsedResponse = JSON.parse(hostById_xhr.responseText);
					console.log(parsedResponse);

					/* Insert hosts data into modal */
						$('#show-state-based-hosts').modal('hide');
						$('input[name=hostID]').val(host_id); 
						$('input[name=address]').val(parsedResponse[0].info.host_address); 
						$('input[name=city]').val(parsedResponse[0].info.host_sCityName); 
						$('input[name=state]').val(parsedResponse[0].info.name); 
						$('input[name=zip]').val(parsedResponse[0].info.host_zip); 
						$('#show_host').html( insertHosts(parsedResponse) );
						$('#sel-host-button').addClass('d-none');
				}
			}
			hostById_xhr.open('get','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php?get_host_by_id=true&host_id='+host_id);
			hostById_xhr.send();
		}); 

/*************************
*** END - Select a New Host
*************************/


/*************************
*** Select a New Artist
*************************/

	$('#selectArtistButton').click(function(event){
		/* Check for a value in the location input */
			var state = $('select[name=popUpWorshipState]').val();
			var talent_id = $('select[name=talent]').val();

		/* Fetch all artitsts apply to perform at a popUpWorhsip event in the specified city */
			if(state !== '' && talent_id !== ''){
				/* Clear error div */
					$('#no_state_error').html('');

				var getArtists_xhr = new XMLHttpRequest(); 
				getArtists_xhr.onload = function(e){
					if(getArtists_xhr.status == 200){
						console.log(getArtists_xhr.responseText.trim() );
						var parsedResponse = JSON.parse( getArtists_xhr.responseText.trim() );
						console.log(parsedResponse);

						if(parsedResponse[0].iUserID){
							$('#addEventModal').modal('hide');
							$('#show-state-based-artists').modal('show');


							$('#show_puw_artists').html( insertArtists(parsedResponse) );
						}
						else{
							$('#no_state_error').html('No Artists Available');
						}
					}
				}
				getArtists_xhr.open('get','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php?get_artists_by_state=true&state='+state+'&talent_id='+talent_id);
				getArtists_xhr.send(); 
			}else if(state == ''){
				$('#no_state_error').html('Please select a state for the event');
			}
			else{
				$('#no_state_error').html('Please select the type of artist you want');
			}
	});

	/* Place selected artist in event form */
		$("#show_puw_artists").on("click", '.selectArtist', function(event){

			/* Get artist's info */
				var artist_id = $(this).attr('artist_id');
				var artist_name = $(this).attr('artist_name');
				var artist_age = $(this).attr('artist_age');
				var artist_tal_id = $(this).attr('artist_tal_id');
				var artist_talent = $(this).attr('artist_talent');
				console.log(artist_talent);

			/* Generate a unique id to correspond to the talent */
            	function rand_ID() {
	                var d = new Date();
	                var n = d.getTime();
	                return n+'_' + Math.random().toString(36).substr(2, 9);
	            };
	            var tal_tracker_id = rand_ID();

			/* Append artist's info to the event form's artist table */
				/* var artistInfoAppend = '<tr id="artistRow_'+artist_id+'"><input class="eventArtistsList" type="hidden" name="selectedArtists['+artist_id+']['+tal_tracker_id+']" artistID="'+artist_id+'" value="'+artist_tal_id+'"><td class="d-none d-md-table-cell">'+artist_id+'</td><td>'+artist_name+'</td><td>'+artist_age+'</td><td>'+artist_talent+'</td><td><button class="btn btn-sm btn-danger removeArtist" style="font-size:.8em;" artist_id="'+artist_id+'">Remove</button></td></tr>';*/
				var artistInfoAppend = '<tr id="artistRow_'+artist_id+'"><input class="eventArtistsList" type="hidden" name="selectedArtists['+artist_id+']['+tal_tracker_id+']" artistID="'+artist_id+'" value="'+artist_tal_id+'"><td class="d-none d-md-table-cell">'+artist_id+'</td><td>'+artist_name+'</td><td>'+artist_age+'</td><td>'+artist_talent+'</td><td><input type="text" name="event_pay['+tal_tracker_id+']" placeholder="$0.00"></td><td><button class="btn btn-sm btn-danger removeArtist" style="font-size:.8em;" tal_tracker="'+tal_tracker_id+'" artist_id="'+artist_id+'">Remove</button></td></tr>';
				$('#append_artist_info').append(artistInfoAppend);
				$(this).removeClass('selectArtist');
				$(this).addClass('de_selectArtist');
				$(this).html('De-Select');

				/* show artist table */
					$('#no_current_artists').addClass('d-none');
					$('#show_artist_table').removeClass('d-none');
		}); 

	/* Remove selected artists from the event form via modal */
		$("#show_puw_artists").on("click", '.de_selectArtist', function(event){
			var artistID = $(this).attr('artist_id');
			$('#artistRow_'+artistID).remove();

			$(this).removeClass('de_selectArtist');
			$(this).addClass('selectArtist');
			$(this).html('Select');

			/* If there are no artist left - hide table */
				var eventArtistList = document.querySelectorAll('input.eventArtistsList');
				if( eventArtistList.length == 0 ){
					/* hide artist table */
						$('#no_current_artists').removeClass('d-none');
						$('#show_artist_table').addClass('d-none');
				}
		});

	/* Remove selected artist from the event form via the event form's artist table*/
		$("#append_artist_info").on("click", '.removeArtist', function(event){
			var artistID = $(this).attr('artist_id');
			
			/* Create & append artist removal hidden input */
				var input_remove = '<input type="hidden" name="remove_artist[]" value="'+artistID+'">';
				$('#append_artist_info').append(input_remove);
				console.log(input_remove)

			/* Visibly remove artist row */	
				$('#artistRow_'+artistID).remove();

			/* If there are no artist left - hide table */
				var eventArtistList = document.querySelectorAll('input.eventArtistsList');
				if( eventArtistList.length == 0 ){
					/* hide artist table */
						$('#no_current_artists').removeClass('d-none');
						$('#show_artist_table').addClass('d-none');
				}
		});

		
/*************************
*** END - Select a New Artist
*************************/


