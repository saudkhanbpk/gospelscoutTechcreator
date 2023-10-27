/**************************************** Date and Time Picker plugin JS ***************************/
	$(function () {
		var dat = $("input[name=todaysDate]").val();
			$("#datetimepicker1").datetimepicker({
		 	format: "YYYY-MM-DD",
		 	defaultDate: false,
		 	maxDate: dat,
		 	//minDate: moment(),
		 	// maxDate: moment().subtract(10,'year'),
		 	//useCurrent: true, 
		 	allowInputToggle: true
		 });
	});
/************************************** END - Date and Time Picker plugin JS ************************/

/********************** Add validation classes ************************/
	jQuery.validator.addClassRules("rule1", {
		required: true,
		minlength: 2
	});
/******************* End - Add validation classes *********************/

/************************* Create Custom validation methods ***************************/
	// jQuery.validator.addMethod('passwordStrenght', function(value, element){
	// 	return this.optional(element) || 
	// }, 'Password does not meet the minimum requirements');

	jQuery.validator.addMethod('math', function(value, element, param){
		return value == param;
	}, 'value not correct');

	//Customize the built-in email validation rule
		$.validator.methods.email = function(value, element){
			return this.optional(element) || /[a-zA-Z0-9]+@[a-z0-9]+\.[a-z]/.test(value);
		}
/********************** END - Create Custom validation methods ************************/

/******************* Grab form to validate - set validation rules *********************/
	var signUpForm = $("#artist-signup");

	signUpForm.validate({
		// Error message placement and styling 
            errorPlacement: function(error, element) {
               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
               
               	//console.log(error[0]['id']);
                if(error[0]['id'] == 'usermaster[dDOB]-error' || error[0]['id'] == 'emailConf-error'){//DOB-error
	            	element.parent("div").after(error);
	            }
	            else if(error[0]['id'] == 'loginmaster[sUserType]-error'){
	            	$('#accordion').after(error);
	            }
	            else{
	            	element.after(error);
	            }
               // element.parent("div").after(error);
            },

		// Handle form when submission is In-Valid
			invalidHandler: function(event, validator){
				var numbErrors = validator.numberOfInvalids();
				if(numbErrors){
					var message = numbErrors == 1 ? 'You missed 1 field. Please Check Previous Steps.'
											  : 'You missed ' + numbErrors + ' fields. Please Check Previous Steps.';
					$('div.error').html(message);
					$('div.error').show(); 
				}
				else{
					$('div.error').hide();
				}
			},

		// Handle form submission 
			submitHandler: function(form){
				/* Hide the loading modal */
					displayLoadingPage('show');
					
				/********************** Append form to Dropzone form **********************/
					let  invalidImgs = dropzone.getRejectedFiles().length;
					if( invalidImgs == 0 && dropzone.getQueuedFiles().length > 0){

						/* Append form to dropzone before sending */
							let i = 0;
							dropzone.on('sending', function(file, xhr, formData){

								/* Get form data and serialize */
									var formDserialize = $('form[name=artist-signup]').serializeArray();

								/* prevent appending data with each image iteration */
									if(i == 0 ){
										for(let j=0; j<formDserialize.length; j++){
											formData.append(formDserialize[j].name, formDserialize[j].value );
										}
									}
									i++; 

								/* Handle JSON Response */
									xhr.onload = function(){
										if(xhr.status == 200){
											
											var response = file.xhr.responseText.trim();
											console.log( response );

											var parsedResponse = JSON.parse(response);
											console.log(parsedResponse);

											if(parsedResponse.target_url){
												/* Redirect Artist to the connect acct onboarding page */
													window.location = parsedResponse.target_url;
											}
											else{
												/* Hide the loading modal */
													displayLoadingPage('hide');
											
												/* Display form error message */
													$('#form-error-div').html(parsedResponse.errorMessage);
													console.log('there was an error submitting request: '+parsedResponse.errorMessage);
											}
										}
									}
							});

						/* Send dropzone data */
							var sendQueue = dropzone.processQueue(); 
					}
					else{
						/* Hide the loading modal */
							displayLoadingPage('hide');

						/* display Error message */
							$('#form-error-div').html('Please upload valid profile image');
					}
				/******************* END - Append form to Dropzone form *******************/

					
			},

		// Elements to be ignored are set with .ignore class 
			ignore: ".ignore",

		// Set validation rules for the form
			rules:{
				'loginmaster[sEmailID]': {
					required: true,
					email: true,
					remote:'https://www.gospelscout.com/views/xmlhttprequest/artistBackend.php' 
				},
				'loginmaster[sPassword]': {
					required: true,
					minlength: 8 
				},
				'loginmaster[ConfsPassword]': {
					required: true,
					equalTo: "#loginmaster-sPassword"
				},
				'usermaster[iZipcode]': {
					required: true,
					minlength: 5,
					maxlength: 5,
					digits: true
				},
				'pwordrecoverymaster[Q1]': {
					required: true
				},
				'pwordrecoverymaster[Q2]': {
					required: true
				},
				'pwordrecoverymaster[A1]': {
					required: true
				},
				'pwordrecoverymaster[A2]': {
					required: true
				},
				'usermaster[dDOB]': {
					required: true
				},
				'usermaster[sCountryName]': {
					required: true
				},
				'usermaster[sStateName]': {
					required: true
				},
				'talentmaster[TalentID]': {
					required: {
						depends: function(element){
							return $('#soloSelection').is(':checked');
							console.log('test');
						}
					}
				},
				'usermaster[sGroupName]': {
					required: {
						depends: function(element){
							return $('#groupSelection').is(':checked');
						}
					}
				},
				sProfileName: {
					required: true,
					accept: "image/*"
				},
				'usermaster[sAvailability]': {
					required: true
				},	
				'usermaster[iYearOfExp]': {
					required: true,
					digits: true,
					maxlength: 2
				},
				'loginmaster[sUserType]': {
					required: true
				},
				emailConf: {
					required: true,
				}
			},
			messages: {
				sProfileName: {
					required: 'Please upload a profile img',
					accept: 'Please upload img files only'
				},
				'loginmaster[sUserType]': {
					required: 'Please select a usertype'
				},
				'usermaster[sAvailability]': {
					required: 'Please select your availability'
				},
				'usermaster[iYearOfExp]': {
					required: 'How long have you been performing',
					maxlength: 'Sorry, two-digit max',
					digits: 'Please enter a valid numeric value'
				},
				emailConf: {
					required: 'Please select to receive an email confirmation id'
				},
				'usermaster[sStateName]': {
					required: 'Please select your state'
				},
				'usermaster[iZipcode]': {
					required: 'Please enter your zip code'
				}
			}
	});
/******************* END - Grab form to validate - set validation rules *********************/


/********************************* Carousel Navigation **************************************/
	
	var car = $('.carousel');
	var emailCount = 0; //var to track how many confirmation emails have been sent

	/* when the change-tabs class is clicked validate the current slides inputs */
		$('.move-tab-forward').click(function(){
			var currentInputs = $('div.active input, div.active select');
			var j=0; 
			
			if($('div.active').attr('id') == 'step3'){
				console.log( $('#soloSelection').is(':checked') ); 
				console.log( $('#groupSelection').is(':checked') );
			}

			/****************** validate Zip code *************************/
				if($('div.active').attr('id') == 'step2'){
					/****** execute Javascript to contact google geocoding api ******/
						$.support.cors = true;
					    $.ajaxSetup({ cache: false });
					    var city = '';
					    var hascity = 0;
					    var hassub = 0;
					    var state = '';
					    var nbhd = '';
					    var subloc = '';
					    var userState = $('#sStateName').val();
					    var userZip = $('#iZipcode').val();

					    if(userZip.length == 5){
						 	var date = new Date();
							$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
						        //find the city and state
									var address_components = response.results[0].address_components;
									$.each(address_components, function(index, component){
										 var types = component.types;
										 $.each(types, function(index, type){
											if(type == 'locality') {
											  city = component.long_name;
											  hascity = 1;

											}
											if(type == 'administrative_area_level_1') {
											  state = component.long_name;
											}
											if(type == 'neighborhood') {
											  nbhd = component.long_name;
											}
											if(type == 'sublocality') {
											  subloc = component.long_name;
											  hassub = 1;
											}
										 });
									});

									if(state == userState){
										$('#sCityName').val(city);
										$('#apiStateName').val(state);
									}
									else{
										$('#sCityName').val('');
									}
						    });
				      	}
				  	/****** END - execute Javascript to contact google geocoding api ******/
			  	}
			/*************** END - validate Zip code **********************/

			/************* Validate each input on the current slide ***************/
				currentInputs.each(function(){
					if($(this).valid() == false){
						j+=1; 
					}
				});
			/********** END - Validate each input on the current slide ************/
			
			/********************* Check for valid image upload *********************/
				if($('div.active').attr('id') == 'step2'){
					let  invalidImgs = dropzone.getRejectedFiles().length;
					if( invalidImgs > 0 || dropzone.getQueuedFiles().length == 0){
						console.log('invalid img');
						$('#profImg_err').html('<p class="my-0 text-danger font-weight-bold" style="font-size:.75em;">Please select a profile image.</p>')
						j+=1;
					}
					else{
						$('#profImg_err').html('');
					}
					
				}
			/****************** END - Check for valid image upload ******************/

			/************* Move to next slide if there are no validation errors ********************/
				if(j == 0){
					car.carousel('next');
					car.carousel('pause');	
				}
			/************* END - Move to next slide if there are no validation errors ********************/

			if($('div.active').attr('id') == 'step3'){
				$(this).text('Send Email');
			}
			else{
				$(this).removeClass('sendConfEmail');
			}

			if($('div.active').attr('id') == 'step4'){
				$(this).text('Next');

				/********************* Send Confirmation email ********************/
					var email_is_present = $('input[ name="loginmaster[sEmailID]" ]').val(); 

					if(email_is_present != ''){
						emailCount +=1; 

						var param2 = $('#sEmailID2').val(); 
						var param3 = $('#sFirstName').val(); 
						var param4 = emailCount; 
						var param5 = 'Artist';

						var formData = new FormData(); 
						formData.append('confirmCode', 1); 
						formData.append('newUserEmail', param2);
						formData.append('newUserName', param3);
						formData.append('emailCount', param4);
						formData.append('profileType', param5);

						var sendMail = new XMLHttpRequest(); 
						sendMail.onreadystatechange = function(){
							if(sendMail.status == 200 && sendMail.readyState == 4){
								var uniqueID = sendMail.responseText.trim(); 
								var parsedResponse = JSON.parse(uniqueID); 

								if(parsedResponse.api_resp.postmarkApiErrorCode > 0){
									var err_message = '<span class="font-weight-bold text-danger" style="font-size:.8em">There was a problem with your email address.</span>';
									$('#confCodeError').html(err_message);
									$('#confCodeError').removeClass('d-none');
								}
								else if(parsedResponse.unique_id){
									$('input[name=confirmationCode]').val(parsedResponse.unique_id);
								}
								else{
									$('#confCodeError').html('<span class="font-weight-bold text-danger" style="font-size:.8em">Too many email attempts...please contact us.</span>');
								}
							}
						}
						sendMail.open("POST", "https://www.gospelscout.com/views/emailConf.php");
						sendMail.send(formData); 

						/* Set the time out function within a function triggered by the submit button. */
		 					setTimeout(function(){ window.location.href = 'https://www.gospelscout.com';},600000);
	 				}
	 				else{
	 					console.log('err: email_not_present');
	 				}
 				/******************* END - Send Confirmation email *******************/
			}

			// Disable previous button when 1st slide is active - disable next button when 6th slide is active
				if($('div.active').attr('id') != 'step1'){
					$('#tab0').removeClass('disabled');
				}
				if($('div.active').attr('id') == 'step4'){
					$('#tab1').addClass('disabled');
				}
				if($('div.active').attr('id') == 'step5'){
					$('#tab1').addClass('disabled');
				}
				
		});
		$('.move-tab-backward').click(function(event){
			event.preventDefault(); 
			car.carousel('prev');
			car.carousel('pause');

			if($('div.active').attr('id') == 'step3'){
				$('.move-tab-forward').text('Send Email');
				$('#confCode').val(''); 
				$('#confCodeError').html('');
				$('#confCodeError').addClass('d-none');
				$('#btn_checkCode').html('Confirm Code');
			}
			else{
				$('.move-tab-forward').text('Next');
			}

			if($('div.active').attr('id') == 'step1'){
				$('#tab0').addClass('disabled');
			}
			if($('div.active').attr('id') != 'step4'){
				$('#tab1').removeClass('disabled');
			}
		});

		/* Create keyup function for confirmation id input box 
			1. when confirmation id is confirmed remove disabled prop from create profile button and add disabled property to the previous button
				a. this will prevent users from invalidating data and being able to submit the profile. 
		*/
			$('#confCode').keyup(function(){
		 			var string = $(this).val().trim();
		 			var stringLength = string.length; 
		 			if(stringLength == 6 && string != ''){
		 				$('#btn_checkCode').removeProp("disabled");
		 			}
		 	});
		 	

		/* Verify confirmation code */
			$('#btn_checkCode').click(function(event){
				var chk_code_butt = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
				$(this).html(chk_code_butt);
				
				var uniqueID = $('input[name=confirmationCode]').val().trim();
				var enteredConf = $('#confCode').val().trim().toLowerCase(); 

				var confirmCode = new FormData(); 
				confirmCode.append('checkConfCode',enteredConf);
				confirmCode.append('uniqueID',uniqueID);

				var checkConfCode = new XMLHttpRequest();
				checkConfCode.onreadystatechange = function(){
					if(checkConfCode.readyState == 4 && checkConfCode.status == 200){
						var codeStatus = checkConfCode.responseText.trim();
						if(codeStatus == 'codeValid'){
							$('#btn_checkCode').html('confirmed');
							$('#btn_checkCode').prop("disabled", true);
							$('#confCodeError').html('');
							$('#confCodeError').addClass('d-none');

							$('#confCodeError').html('<h6 class="text-success mt-3">Code Confirmed!!!</h6>');
							$('#confCodeError').removeClass('d-none');
							$('#tab1').removeClass('disabled');
						}
						else{
							$('#btn_checkCode').html('Confirm Code');
							$('#confCodeError').html('<h6 class="text-danger mt-3">Code Invalid!!!</h6>');
							$('#confCodeError').removeClass('d-none');
						}
					}
				}
				checkConfCode.open('POST', "https://www.gospelscout.com/views/emailConf.php");
				checkConfCode.send(confirmCode);

			});
		/* END - Verify confirmation code */
/****************************** END - Carousel Navigation ***********************************/


/* Hide Bank acct info if user opps */
	function hideStrInputs(){
		var skipStripeSetup = document.getElementById('skipStripeSetup').checked; 
		if(skipStripeSetup){
			$('.str_accnts').addClass('d-none');
		}
		else{
			$('.str_accnts').removeClass('d-none');
		}
	}
/* END - Hide Bank acct info if user opps */

/*************************
 *** Dropzone file uploader 
 *************************/
 	
	var dropzone = new Dropzone(
		'#demo-upload', 
		{	
			url: 'https://www.gospelscout.com/views/xmlhttprequest/artistBackend.php',
			paramName: 'sProfileName',
			uploadMultiple: false,
			// chunking: true,
			// parallelChunkUploads: true,
			autoProcessQueue: false,
			previewTemplate: document.querySelector('#preview-template').innerHTML,
			previewsContainer: document.querySelector('#thumb'),
			parallelUploads: 8,
			thumbnailHeight: 120,
			thumbnailWidth: 120,
			thumbnailMethod: 'crop',
			maxFilesize: 5,
			maxFiles: 2,
			filesizeBase: 1000,
			acceptedFiles: 'image/*',
			// createImageThumbnails: true,
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

		dropzone.on('addedfile', function(event){
			$('#profImg_err').html('');
		});

		dropzone.on('maxfilesreached', function(file){
			dropzone.removeFile(file[0]); 
		});
	
		// dropzone.on("success", function(file,response) {
		// 	/* Hide the loading modal */
		// 		displayLoadingPage('hide');

		// 	// var response = file.xhr.responseText.trim();
		// 	// console.log( response );

		// 	// var parsedResponse = JSON.parse(response);
		// 	// console.log(parsedResponse);
			
		// });

 /*************************
 *** END - Dropzone file uploader 
 *************************/
