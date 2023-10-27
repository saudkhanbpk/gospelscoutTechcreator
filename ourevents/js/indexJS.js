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
				if(user_type !== 'church' && user_type !== 'gen_user'){

					/* A valid user is logged in */
						// identify if user has the required portfolio links or content accessible for review and selection
							// Create XHR to query artistvideomaster and moremusicmaster for entries associated with current user's id
								var xhr = new XMLHttpRequest(); 
								xhr.onload = function() {
									if(xhr.status == 200){
										// Handle status of non-satisfied or satisfied requirements - call appropriate modal
											console.log(xhr.responseText.trim());
											var artistContent = JSON.parse( xhr.responseText.trim() );
											requirementsMet(artistContent['reqsMet'], true, true);
									}
								}
								xhr.open('get', 'https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php?user_id='+user_id+'&reqCheck=true');
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
		 /* display loading spinwheel */
		 	//displayLoadingPage('show');
		 	
		var eventID = $(this).attr('eventID');
		

		if(user_id > 0 && user_type !== 'church'){
			/* Automatically retrieve signed-in user's info */
				fetch('phpBackend/connectToDb.php?iLoginID='+user_id+'&eventID='+eventID+'&memberAttend=true')
					.then( resp => resp.json() )
					.then( resp1 => {
						/* hide loading spinwheel */
							//displayLoadingPage('hide');
							
						if(resp1['membApplied']){
							/* Show the "you already applied" modal */
								$('#alreadyApplied').modal('show');
								console.log('You already applied');
						}
						else if(resp1['memberAdded']){
							//requestSubmitted()
							$('#wannaAttend').modal('hide');
							$('#requestSubmittedToAttend').modal('show');
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
			xhr.open('get', 'https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php?puwEvents=true');
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

		/* Form for logged-in users that meet the reqs to apply to perform */	
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
						$('#applyButton').modal('hide');
						displayLoadingPage('show');
						
						//submit form via ajax once form and zip code is validated 
							const nfo = new FormData(form); 
							nfo.append('iLoginID', user_id);

							const xhr = new XMLHttpRequest(); 
							xhr.onload = () => {
								if(xhr.status == 200){

									displayLoadingPage('hide');
									
									console.log(xhr.responseText.trim() );
									let parsedResponse = JSON.parse( xhr.responseText.trim() );
									
									if(parsedResponse.artist  || parsedResponse.artist_already_applied){
										console.log(parsedResponse);
										//requestSubmitted();
										$('#requestSubmitted').modal('show');
									}
									else{
										console.log('there was an error submitting request');
									}
								}
							}
							xhr.open('post','https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php');
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
							xhr.open('post','https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php');
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
						/* Display loading spinwheel */
							$('#wannaAttend').modal('hide');
							displayLoadingPage('show');
							
						//submit form via ajax once form and zip code is validated 
							const nfo = new FormData(form); 
							nfo.append('attendEvent', true);

							const xhr = new XMLHttpRequest(); 
							xhr.onload = () => {
								if(xhr.status == 200){
									displayLoadingPage('hide');
									console.log(xhr.responseText.trim());
									let parsedResponse = JSON.parse( xhr.responseText.trim() );
								
									if(parsedResponse.attendeeAdded){
										resetModalForms();
										$('#requestSubmittedToAttend').modal('show');
									}
									else{
										$('#wannaAttend').modal('show');
										if(parsedResponse.alreadyApplied){
											$('.error-message').html("OOPS, you've already applied to this event...");
										}
										else{
											$('.error-message').html('there was an error submitting request, please try again');
										}
									}
								}
							}
							xhr.open('post','https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php');
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
						/*'phone': {
							required: true

						}*/
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
						/*'phone': {
							required: 'All contact fields are required'

						}*/
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
			url: 'https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php',
			paramName: 'hostImgs',
			uploadMultiple: true,
			// chunking: true,
			// parallelChunkUploads: true,
			autoProcessQueue: false,
			// previewTemplate: document.querySelector('#preview-template').innerHTML,
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
/*************************
*** Volunteer form
*************************/
	/* Form for users applying to be hosts */
		const form6 = $('#volunteer-form');
 	
 	form6.validate({

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
					/* Show Loading Spinwheel */
						displayLoadingPage('show');
						
					// Variables 
						let userZip = $('#vol_zip').val(); 
						let userStateId = $('#vol_state').val();
						let userState = $('#vol_state option[value='+userStateId+']').text().trim();
						let userCity = new validateZip(userZip, userState);

						userCity.getCityStateOBj
						.then(userCity.returnCity)
						.then(cityFound => {

								if(cityFound.state == userState){
						
									var volForm = new FormData(form);
									volForm.append('volForm', true);
									volForm.append('vol_state', userStateId);
									volForm.append('vol_zip', userZip);
									volForm.append('vol_city', cityFound.city);
				
									var vol_xhr = new XMLHttpRequest(); 
									vol_xhr.onload = function(){
										if(vol_xhr.status == 200){
											/* Hide Loading Spinwheel */
												displayLoadingPage('hide');
											
											/* Handle Response */	
												//console.log( vol_xhr.responseText.trim() ); 
												var parsedResponse = JSON.parse( vol_xhr.responseText.trim() );
					
												if(parsedResponse.volunteerAdded == true || (parsedResponse.volunteerAdded == false && parsedResponse.volunteerExists == true) ){
					
													/* Clear volunteer form */
														$('.vol_mess').text( $('input[name=vol_fname]').val()+', Thank you for your interest. We will be in touch!!!.' );
									                    			document.getElementById("volunteer-form").reset();
									                    	
									                		/* Show successful donation message */
									                	    		$('#volunteer_success').modal('show');
												}
												else{
													$('.vol_mess').text('There was an error submitting your request.  Please try again.'); 
													$('#volunteer_success').modal('show');
												}
										}
									}
									vol_xhr.open('post','https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php');
									vol_xhr.send(volForm); 
								}
						});
				},

			// Set Validation rules 
				rules: {
					'vol_fname': {
						required: true
					},
					'vol_lname': {
						required: true
					},
					'vol_email': {
						required: true,
						email: true
					},
					'vol_phone': {
						required: true,
						digits: true,
						maxlength: 10,
						minlength:10
					},
					'vol_state1': {
						required: true
					},
					'vol_zip': {
						required: true
					}
				},
				messages:{
					'vol_fname': {
						required: 'Please enter your first name'
					},
					'vol_lname': {
						required: 'Please enter your last name'
					},
					'vol_email': {
						required: 'Please enter your email address',
						email: 'Please enter a valid email address'
					},
					'vol_phone': {
						required: 'Please enter your phone number',
						digit: 'Please enter numeric values only',
						maxlength: 'Please enter a valid phone number',
						minlength: 'Please enter a valid phone number',
					},
					'vol_state': {
						required: 'Please select your state'
					},
					'vol_zip': {
						required: 'Please enter your 5-digit zip code'
					}
				}

	});

/*************************
*** END - Volunteer form
*************************/

/*************************
 *** Stripe card tokenization
 *************************/
	"use strict";
	var stripe = Stripe('pk_live_OGrw56hK2CpvoGTZgIrzQPHk');
	var elements = stripe.elements();

	/* Custom styling can be passed to options when creating an Element. */
	    var style = {
	        base: {
	            color: '#32325d',
	            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
	            fontSmoothing: 'antialiased',
	            fontSize: '16px',
	            '::placeholder': {
	                color: '#aab7c4'
	            }
	        },
	            invalid: {
	            color: '#fa755a',
	            iconColor: '#fa755a'
	        }
	    };

	/* Create an instance of the card Element. */
	    var card = elements.create('card', {style: style});

	/* Add an instance of the card Element into the `card-element` <div>. */
	    card.mount('#card-element');
	    card.on('ready',function(){
	    	$('#donate_btn').html('Donate');
	    	$('#donate_btn').removeAttr('disabled');
	    });
	    
	/* Add an event listener to the card element to catch errors */
	    card.addEventListener('change', function(event) {

	        var displayError = document.getElementById('card-errors');

	        if (event.error) {
	            displayError.textContent = event.error.message;
	        } else {
	            displayError.textContent = '';
	        }   
	    });
	   
	/* Form for users donating */
		const form5 = $('#payment-form');

		form5.validate({

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
					/* Display the loading modal */
						let action = 'show';
						displayLoadingPage(action);

					/* Create a token or display an error when the form is submitted. */
						stripe.createToken(card).then(function(result) {


				            if (result.error) {
				            	/* Hide the loading modal */
			            			let action = 'hide';
							displayLoadingPage(action);

				                /* Inform the customer that there was an error. */
				                    var errorElement = document.getElementById('card-errors');
				                    errorElement.textContent = result.error.message;
				            } else {
				                /* Create a charge here */
				                    var tokenD = new FormData(form); 
				                    tokenD.append('token', result.token.id);
				                    tokenD.append('newCharge', true);
				                    tokenD.append('description', 'GospelScout - Event - Donation');

				                    var newCharge = new XMLHttpRequest();
				                    newCharge.onload = function(){
				                    	
				                    	if( newCharge.status == 200 ){
											// console.log('test', newCharge.responseText.trim());
				                    		var parsedResponse = JSON.parse( newCharge.responseText.trim() );
											console.log(parsedResponse);

				                    		/* Hide the loading modal */
						            			let action = 'hide';
												displayLoadingPage(action);

				                    		if(parsedResponse.status == 'succeeded' && parsedResponse.paid == true){
				                    			/* Show a successful donation modal and clear payment form */
					                    			$('.don_name').text( $('input[name=donor_fname]').val() );
					                    			$('#don_amount').text( parsedResponse.amount );
					                    			$('#don_receipt').attr('href', parsedResponse.receipt_url );
					                    			$('#don_email').text( parsedResponse.receipt_email );
					                    			$('#don_date').text( parsedResponse.created );

				                    			/* Clear payment form */
				                    				document.getElementById("payment-form").reset();
				                    			
				                    			/* Clear card element */
				                    				card.clear('#card-element');

				                    			/* Show successful donation message */
				                    				$('#donation_success').modal('show');
				                    		}
				                    		else{
				                    			/* Show a failed donation modal */
				                    				$('.don_name').text( $('input[name=donor_fname]').val() );
					                    			$('#don_chargeStatus').text( parsedResponse.exception.jsonBody.error.code );
					                    			$('#don_reason').text( parsedResponse.exception.jsonBody.error.message );

				                    			/* Show a un-successful donation modal and don't clear payment form */
				                    				$('#donation_failure').modal('show');
				                    		}
				                    	}
				                    }
				                    newCharge.open('post', 'https://www.gospelscout.com/ourevents/phpBackend/connectToDb.php');
				                    newCharge.send(tokenD);
				            }
				        });
				},

			// Set Validation rules 
				rules: {
					'donor_fname': {
						required: true
					},
					'donor_lname': {
						required: true
					},
					'donor_email': {
						required: true,
						email: true
					},
					'donor_phone': {
						digits: true,
						maxlength: 10,
						minlength:10
					},
					'donor_amount': {
						required: true
					}
				},
				messages:{
					'donor_fname': {
						required: 'Please enter your first name'
					},
					'donor_lname': {
						required: 'Please enter your last name'
					},
					'donor_email': {
						required: 'Please enter your email address',
						email: 'Please enter a valid email address'
					},
					'donor_phone': {
						required: 'Please enter your phone number',
						digit: 'Please enter numeric values only',
						maxlength: 'Please enter a valid phone number',
						minlength: 'Please enter a valid phone number',
					},
					'donor_amount': {
						required: 'Please enter a dollar amount'
					}

				}

		});
//$('#attend).click(function(event){
//	event.preventDefault();
	//$('#requestSubmitted').modal('show');	
//}