/******************** POPUPWORHSIP INDEX.PHP JS ********************/


/*********** define functions ***********/
	function requirementsMet(data, loggedInUser, isArtist){
		if(loggedInUser){
			if(isArtist){
				if(data){
					/* req is met - display modal with an "Apply" button */
						$('#applyButton').modal('show');
				}
				else{
					/* req not met - display modal directing user's next steps */
						$('#reqsNotMet').modal('show');
				}
			}
			else{
				/* Logged in user doesn't have an artist profile */
					$('#nonArtistMessage').modal('show');
			}
		}
		else{
			/* User not logged in - display modal prompting user log in or sign up */
				$('#userNotLoggedIn').modal('show');
		}
	}

	function resetModalForms(){
		document.getElementById("loggedInApply").reset();
		document.getElementById("addMusicLinks").reset();
		document.getElementById("addHost").reset();
		document.getElementById("attendEvent").reset();

		/* Clear possible error messages from form */
			$('.error-message').text('');
	}

	$('.resetOnClose').on('hide.bs.modal',function(){
		resetModalForms();
	} );

	function requestSubmitted(){
		/* close modals and reset the forms*/
			$('#applyButton').modal('hide');
			$('#reqsNotMet').modal('hide');
			$('#wannaHost').modal('hide');
			$('#wannaAttend').modal('hide');

			resetModalForms();

		/* Show the thank you modal */
			$('#requestSubmitted').modal('show');
	}
/*********** END - define functions ***********/

/********************************
 *** Handle Perform Button Action 
 ********************************/
	$('#perform').click(function(event){

		event.preventDefault(); 

		/********* Check if user is logged in *********/
			if( user_id > 0){
				if(user_type !== 'church' && user_type !== 'user'){

					/* A valid user is logged in */
						// identify if user has the required portfolio links or content accessible for review and selection
							// Create XHR to query artistvideomaster and moremusicmaster for entries associated with current user's id
								var xhr = new XMLHttpRequest(); 
								xhr.onload = function() {
									if(xhr.status == 200){
										// Handle status of non-satisfied or satisfied requirements - call appropriate modal
											var artistContent = JSON.parse( xhr.responseText.trim() );
											requirementsMet(artistContent['reqsMet'], true, true);
									}
								}
								xhr.open('get', 'phpBackend/connectToDb.php?user_id='+user_id+'&reqCheck=true');
								xhr.send()

								/*** ATTENTION ***
									FETCH IS NOT SUPPORTED IN MY CURRENT SAFARI BROWSER
									AND MAY NOT BE SUPPORTED IN MANY OTHER END USERS BROWSERS 

									MAY NEED TO STICK TO THE FOLLOWING TRADITIONAL XHR 

									fetch('phpBackend/connectToDb.php?user_id='+user_id)
									.then( function(response){ 
										
										return response.json() ;
									})
									.then( verifyContent )
									.then( requirementsMet )
								*****************/
				}
				else{
					/* Current user's account type is not eligible to apply to perform */
						// Dipslay Modal With Message - Must have an artist profile to apply
							requirementsMet(false, true, false);
				}
			}
			else{
				/* A valid user is not logged in */
					// Prompt modal that displays a "Log in" and "Sign up" button
						requirementsMet(false, false); 
			}
	});
/*************************************
 *** END - Handle Perform Button Action 
 *************************************/

/********************************
 *** Handle Attend Button Action 
 ********************************/
	$('#eventsTrue').on('click','#attendPUW',function(e){
		e.preventDefault(); 

		var eventID = $(this).attr('eventID');
		

		if(user_id > 0 && user_type !== 'church'){
			/* Automatically retrieve signed-in user's info */
				fetch('phpBackend/connectToDb.php?iLoginID='+user_id+'&eventID='+eventID+'&memberAttend=true')
					.then( resp => resp.json() )
					.then( resp1 => {
						if(resp1['membApplied']){
							/* Show the "you already applied" modal */
								$('#alreadyApplied').modal('show');
								console.log('You already applied');
						}
						else if(resp1['memberAdded']){
							requestSubmitted()
							console.log('successfully Added');
						}
						else{
							console.log('There was an error submitting your request...contact us');
						}
					})
			// var xhrMember = new XMLHttpRequest();
			// 	xhrMember.onload = function(){
			// 		if(xhrMember.status == 200 && xhrMember.readyState == 4){
			// 			console.log(xhrMember.responseText);
			// 		}
			// 	}
			// 	xhrMember.open('get','phpBackend/connectToDb.php?iLoginID='+user_id+'&eventID='+eventID+'&memberAttend=true');
			// 	xhrMember.send(); 
		}
		else{
			/* Insert eventID into the attendee form */
				$('input[name=eventID]').val(eventID); 

			/* Show Sign up modal to attend a puw event */
				$('#wannaAttend').modal('show');
		}


	});
/*************************************
 *** END - Handle Attend Button Action 
 *************************************/

/********************************
 *** Handle Host Button Action 
 ********************************/
	 $('#host').click(function(e){

	 	e.preventDefault(); 

	 	/* Show the Host modal */
	 		$('#wannaHost').modal('show');

	 });
 /*************************************
 *** END - Handle Host Button Action 
 *************************************/

 /******************************************
 *** Get upcoming puw events when page loads 
 ******************************************/
 	$(document).ready(function(){

 		/* check puweventsmaster table for any future popUpWorship events */
 			var xhr = new XMLHttpRequest(); 
			xhr.onload = function() {
				if(xhr.status == 200){
					// Handle status of non-satisfied or satisfied requirements - call appropriate modal
						// var puwEvents = JSON.parse( xhr.responseText.trim() );
						// console.log(xhr.responseText.trim());

						$('#eventsTrue').removeClass('d-none');
						$('#eventsTrue').html( xhr.responseText.trim() );
				}
			}
			xhr.open('get', 'phpBackend/connectToDb.php?puwEvents=true');
			xhr.send()

 	});


 /*************************************************
 *** END - Get upcoming puw events when page loads 
 *************************************************/

/*********************************************************
 *** Keep user on popUpWorship page after successful login 
 *********************************************************/
	$('#btn_loginPopupworship').click(function(e){
		$('#btn_login').attr('popUpWorship', true);
	});
/***************************************************************
 ***  END - Keep user on popUpWorship page after successful login 
 ***************************************************************/


/********************
 *** forms validator
 ********************/

 	/* validate and submit form */

		/* Form for logged-in users that meet the reqs */	
			const form1 = $('#loggedInApply');
			form1.validate({

				//Error display and placement 
					errorPlacement: function(error, element) {
						console.log(error[0]['id']);
		               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
			            element.after(error);
		               // element.parent("div").after(error);
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
			
						//submit form via ajax once form and zip code is validated 
							const nfo = new FormData(form); 
							nfo.append('iLoginID', user_id);

							const xhr = new XMLHttpRequest(); 
							xhr.onload = () => {
								if(xhr.status == 200){

									let parsedResponse = JSON.parse( xhr.responseText.trim() );
									
									if(parsedResponse.artist){
										console.log(parsedResponse);
										requestSubmitted();
									}
									else{
										console.log('there was an error submitting request');
									}
								}
							}
							xhr.open('post','phpBackend/connectToDb.php');
							xhr.send(nfo);		
					},

				// Input rules
					rules: {
						'popUpWorshipCity' : {
							required: true
						}

					},
					messages:{
						'popUpWorshipCity': {
							required: 'Please Select a City'
						}
					}

			});
		/* END - Form for logged-in users that meet the reqs */	

		/* Form for logged-in users that DON'T meet the reqs */	
			const form2 = $('#addMusicLinks');
			form2.validate({

				//Error display and placement 
					errorPlacement: function(error, element) {
						console.log(error[0]['id']);
		               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
			            
			            if(error[0]['id'] == 'portfolioLinks-error'){
			            	// element.parent("div").after(error);
			            	$('#port_link_error').append(error);
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
			
						//submit form via ajax once form and zip code is validated 
							const nfo = new FormData(form); 
							nfo.append('iLoginID', user_id);

							const xhr = new XMLHttpRequest(); 
							xhr.onload = () => {
								if(xhr.status == 200){

									let parsedResponse = JSON.parse( xhr.responseText.trim() );
									
									if(parsedResponse.artist && parsedResponse.urls){
										console.log(parsedResponse);
										requestSubmitted();
									}
									else{
										console.log('there was an error submitting request and/or content links');
									}
								}
							}
							xhr.open('post','phpBackend/connectToDb.php');
							xhr.send(nfo);		
					},

				// Input rules
					groups:{
						portfolioLinks: 'usercontentlinksmaster[portfolioUrl1] usercontentlinksmaster[portfolioUrl2] usercontentlinksmaster[portfolioUrl3]'
					},
					rules: {
						'usercontentlinksmaster[portfolioUrl1]': {
							require_from_group: [1, '.port_links']
						},
						'usercontentlinksmaster[portfolioUrl2]': {
							require_from_group: [1, '.port_links']
						},
						'usercontentlinksmaster[portfolioUrl3]': {
							require_from_group: [1, '.port_links']
						},
						'popUpWorshipCity' : {
							required: true
						}
					},
					messages:{
						'popUpWorshipCity': {
							required: 'Please Select a City'
						}
					}
			});
		/* END - Form for logged-in users that DON'T meet the reqs */	

		/* Form for users applying to be hosts */
			const form3 = $('#addHost');

			form3.validate({

				//Error display and placement 
					errorPlacement: function(error, element) {
						console.log(error[0]['id']);
		               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
			            element.parent('div').parent('div').after(error); 
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
					// Variables 
						let userZip = $('#iZipcode').val(); 
						let userStateId = $('#sStateName').val();
						let userState = $('#sStateName option[value='+userStateId+']').text().trim();
						let userCity = new validateZip(userZip, userState);

					// Number of invalid imgs being uploaded
						let  invalidImgs = dropzone.getRejectedFiles().length;
					
					userCity.getCityStateOBj
						.then(userCity.returnCity)
						.then(cityFound => {

							//submit form via ajax once form and zip code is validated 
								if(cityFound.state == userState){
									
									if(invalidImgs == 0){
										//submit form via ajax once form and zip code is validated 

											/* Append form to dropzone before sending */
												let i = 0;
												dropzone.on('sending', function(file, xhr, formData){
													/* Get form data and serialize */
														var formDserialize = $('form[name=addHost]').serializeArray();

													/* prevent appending data with each image iteration */
														if(i == 0 ){
															for(let j=0; j<formDserialize.length; j++){
																formData.append(formDserialize[j].name, formDserialize[j].value );
															}
														}
														formData.append('hostApp', true);
														formData.append('host_sCityName', cityFound.city);
														i++; 
												});

											/* Send dropzone data */
												var sendQueue = dropzone.processQueue(); 

										}
										else{
											$('.error-message').text('Sorry, there was an error with @ least 1 of your images');
											console.log('there was an error uploading your images');
										}
								}
								else{
									// const err_mess = 
									$('.error-message').text('Sorry, there was a State/Zip Code mismatch!!!');
									console.log('there was an error validating your zip code');
								}
						})	
					},
				// Input rules
					groups:{
						contactInfo: 'host_fname host_lname host_email host_phone',
						location: 'host_address host_state host_zip',
						addtlDeets: 'buildingType environment capacity hCapAccessible startTime endTime'
					},
					rules: {
						'host_fname': {
							required: true

						},
						'host_lname': {
							required: true

						},
						'host_email': {
							required: true,
							email: true
						},
						'host_phone': {
							required: true

						},
						'host_address': {
							required: true

						},
						'host_state': {
							required: true

						},
						'host_zip': {
							required: true,
							minlength: 5,
							maxlength: 5,
							digits: true

						},
						'buildingType': {
							required: true

						},
						'environment': {
							required: true

						},
						'capacity': {
							required: true,
							digits: true
						},
						'hCapAccessible': {
							required: true

						},
						'startTime': {
							required: true

						},
						'endTime': {
							required: true

						},
						'addedInfo': {
							required: {
								depends: function(element){
									return $('#buildingType').val() == 'other';
								}
							}
						}
					},
					messages:{
						'host_fname': {
							required: 'All contact fields are required'
						},
						'host_lname': {
							required: 'All contact fields are required'

						},
						'host_email': {
							required: 'All contact fields are required',
							email: 'Please enter a valid email address'

						},
						'host_phone': {
							required: 'All contact fields are required'

						},
						'host_address': {
							required: 'All location fields are required'
						},
						'host_state': {
							required: 'All location fields are required'

						},
						'host_zip': {
							required: 'All location fields are required'

						},
						'buildingType': {
							required: 'All additonal detail fields above are required'
						},
						'environment': {
							required: 'All additonal detail fields above are required'

						},
						'capacity': {
							required: 'All additonal detail fields above are required'

						},
						'hCapAccessible': {
							required: 'All additonal detail fields above are required'

						},
						'startTime': {
							required: 'All additonal detail fields above are required'

						},
						'endTime': {
							required: 'All additonal detail fields above are required'

						},
						'addedInfo': {
							required: 'Please explain the building type'
						}
					}
			});
		/* END - Form for users applying to be hosts */	

		/* Form for users applying to attend PUW */
			const form4 = $('#attendEvent');

			form4.validate({

				//Error display and placement 
					errorPlacement: function(error, element) {
						console.log(error[0]['id']);
		               	error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
			            element.parent('div').parent('div').after(error); 
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

						//submit form via ajax once form and zip code is validated 
							const nfo = new FormData(form); 
							nfo.append('attendEvent', true);

							const xhr = new XMLHttpRequest(); 
							xhr.onload = () => {
								if(xhr.status == 200){
									let parsedResponse = JSON.parse( xhr.responseText.trim() );

									if(parsedResponse.attendeeAdded){
										requestSubmitted();
									}
									else{
										if(parsedResponse.alreadyApplied){
											$('.error-message').html("OOPS, you've already applied to this event...");
										}
										else{
											$('.error-message').html('there was an error submitting request');
										}
									}
								}
							}
							xhr.open('post','phpBackend/connectToDb.php');
							xhr.send(nfo);			
					},
				// Input rules
					groups:{
						contactInfo: 'fname lname email phone',
					},
					rules: {
						'fname': {
							required: true

						},
						'lname': {
							required: true

						},
						'email': {
							required: true,
							email: true
						},
						'phone': {
							required: true

						}
					},
					messages:{
						'fname': {
							required: 'All contact fields are required'
						},
						'lname': {
							required: 'All contact fields are required'

						},
						'email': {
							required: 'All contact fields are required',
							email: 'Please enter a valid email address'

						},
						'phone': {
							required: 'All contact fields are required'

						}
					}
			});
		/* END - Form for users applying to attend PUW */
/**************************
 ***  END - forms validator
 **************************/

/********************
 *** Date/Time Picker
 ********************/
 $(function () {
	var dat = $("input[name=todaysDate]").val();
		$("#datetimepicker1").datetimepicker({
	 		format: "LT",
	        stepping: "5",
	        useCurrent: false,
	        allowInputToggle: true
	 });
		var dat = $("input[name=todaysDate]").val();
		$("#datetimepicker2").datetimepicker({
	 		format: "LT",
	        stepping: "5",
	        useCurrent: false,
	        allowInputToggle: true
	 });
});

 /*************************
 *** END - Date/Time Picker
 *************************/

 /*************************
 *** Dropzone file uploader 
 *************************/
 	
	var dropzone = new Dropzone(
		'#demo-upload', 
		{	
			url: 'phpBackend/connectToDb.php',
			paramName: 'hostImgs',
			uploadMultiple: true,
			// chunking: true,
			// parallelChunkUploads: true,
			autoProcessQueue: false,
			previewTemplate: document.querySelector('#preview-template').innerHTML,
			parallelUploads: 8,
			thumbnailHeight: 120,
			thumbnailWidth: 120,
			maxFilesize: 5,
			maxFiles: 8,
			filesizeBase: 1000,
			acceptedFiles: 'image/*',
			// addRemoveLinks: true,
			//forceFallback: true, //for testing fallback functionality
			// capture: 'camera', for uploading photos on mobile devices
			// maxThumbnailFilesize: 1,
		  
		  	thumbnail: function(file, dataUrl) {
		  		// console.log(file);
			    if (file.previewElement) {
		      		file.previewElement.classList.remove("dz-file-preview");
		      		var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
			    	
			    	for (var i = 0; i < images.length; i++) {
			        	var thumbnailElement = images[i];
			        	thumbnailElement.alt = file.name;
			        	thumbnailElement.src = dataUrl;
			      	}

			      	setTimeout( function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
			    }
		 	},
		 	uploadprogress: function(file, progress, bytesSent) {
			    // Display the progress

			},
			error: function(error, errorMessage, xhrObj){
				console.log('error: '+error+' - '+errorMessage);
			}

		});
	
		dropzone.on("successmultiple", function(file) {

			/* Check that all files were sent to server succesfully */
				let fileSuccess = 0; 
				for( var i=0; i<file.length; i++){
					console.log(file[i].status);
					if(file[i].status == 'success'){
					fileSuccess++; 
					}
				}

			/* if all files sent to server successfully - send file paths to server */
		  		if(file.length == fileSuccess){
		  			//console.log(file[0].xhr.responseText);
			  		
			  		let parsedFileResponse = jQuery.parseJSON(file[0].xhr.responseText);

	  				if(parsedFileResponse.hostAdded && parsedFileResponse.daysAdded && parsedFileResponse.imgsAdded){

						// Display confirmation modal
							dropzone.removeAllFiles(true);
							requestSubmitted();
					}
					else if(parsedFileResponse.alreadyApplied){
						// $('.error-message').text('We already have your application, Thanks for applying!!!');
						// Display confirmation modal
							dropzone.removeAllFiles(true);
							requestSubmitted();
					}
					else{
						console.log('there was an error submitting request');
						$('.error-message').text('there was an error submitting request');
					}

		  		}





		});

 /*************************
 *** END - Dropzone file uploader 
 *************************/