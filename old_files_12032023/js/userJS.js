/**************************************** Date and Time Picker plugin JS ***************************/
	$(function () {
		var dat = $("input[name=todaysDate]").val();
			$("#datetimepicker1").datetimepicker({
		 	format: "YYYY-MM-DD",
		 	defaultDate: false,
		 	maxDate: dat,
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
               
                if(error[0]['id'] == 'DOB-error' || error[0]['id'] == 'emailConf-error'){
	            	element.parent("div").after(error);
	            }
	            else if(error[0]['id'] == 'loginmaster[sUserType]-error'){
	            	$('#accordion').after(error);
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
        				let action = 'show';
					displayLoadingPage(action);

				//submit form via ajax once form and zip code is validated 
					const nfo = new FormData(form); 
					
					const xhr = new XMLHttpRequest(); 
					xhr.onload = () => {
						if(xhr.status == 200){
						let action = 'hide';
						displayLoadingPage(action);
							console.log(xhr.responseText.trim());
							let parsedResponse = JSON.parse( xhr.responseText.trim() );

							 if(parsedResponse.target_url){
							 	/* Redirect Artist to the connect acct onboarding page */
							 		window.location = parsedResponse.target_url;
							 }
							 else{
							 	/* Hide the loading modal */
			             					let action = 'hide';
							 		displayLoadingPage(action);
							
							 	console.log('there was an error submitting request: '+parsedResponse.errorMessage);
							 } 
						}
					}
					xhr.open('post','https://www.stage.gospelscout.com/views/xmlhttprequest/userBackend.php');
					xhr.send(nfo);		
			},

		// Elements to be ignored are set with .ignore class 
			ignore: ".ignore",

		// Set validation rules for the form
			rules:{
				/*'loginmaster[sEmailID]': {
					required: true,
					email: true,
					remote:'https://www.stage.gospelscout.com/views/xmlhttprequest/artistBackend.php' 
				}, */
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
				/*'pwordrecoverymaster[Q1]': {
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
				},*/
				'usermaster[dDOB]': {
					required: true
				},
				'usermaster[sCountryName]': {
					required: true
				},
				'usermaster[sStateName]': {
					required: true
				},
				sProfileName: {
					required: true,
					accept: "image/*"
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

			/************* Move to next slide if there are no validation errors ********************/
				 if(j == 0){
					car.carousel('next');
					car.carousel('pause');	
				 }
			/************* END - Move to next slide if there are no validation errors ********************/

			if($('div.active').attr('id') == 'step2'){
				$(this).text('Send Email');
			}
			else{
				$(this).removeClass('sendConfEmail');
			}

			if($('div.active').attr('id') == 'step3'){
				$(this).text('Next');

				/********************* Send Confirmation email ********************/
					// var sendEmaiChecked = document.getElementById('emailConf').checked; 
					
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

								if(parsedResponse.unique_id){
									$('input[name=confirmationCode]').attr('value',uniqueID);
									$('input[name=confirmationCode]').val(parsedResponse.unique_id);
								}
								else{
									console.log(parsedResponse.unique_id);
								}
							}
						}
						sendMail.open("POST", "https://www.stage.gospelscout.com/views/emailConf.php");
						sendMail.send(formData); 

						/* Set the time out function within a function triggered by the submit button. */
		 					setTimeout(function(){ window.location.href = 'https://www.stage.gospelscout.com';},600000);
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
				if($('div.active').attr('id') == 'step3'){
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
			}
			else{
				$('.move-tab-forward').text('Next');
			}

			if($('div.active').attr('id') == 'step1'){
				$('#tab0').addClass('disabled');
			}
			if($('div.active').attr('id') != 'step3'){
				$('#tab1').removeClass('disabled');
			}
		});

		/* Create keyup function for confirmation id input box 
			1. when confirmation id is confirmed remove disabled prop from create profile button and add disabled property to the previous button
				a. this will prevent users from invalidating data and being able to submit the profile. 
		*/

			$('#confCode').keyup(function(){
		 		var strLength = $(this).val().length; 
		 		
		 		if( strLength >= 6 ){
		 			$('#btn_checkCode').removeProp("disabled");
		 		}
		 	});

		/* Verify confirmation code */
			$('#btn_checkCode').click(function(event){
				/* Show loading spinwheel */
					$(this).html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...');

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
							$('#confCodeError').html('');
							$('#confCodeError').addClass('d-none');

							$('#btn_checkCode').addClass("d-none");
							$('#accept_terms').removeClass("d-none");
							$('#btn_submit').removeProp("disabled");
							$('#btn_submit').removeClass("d-none");
							// $('#tab0').addClass('disabled');
						}
						else{
							$('#confCodeError').html('<h6 class="text-danger mt-3">Code Invalid!!!</h6>');
							$('#confCodeError').removeClass('d-none');
						}
					}
				}
				checkConfCode.open('POST', "https://www.stage.gospelscout.com/views/emailConf.php");
				checkConfCode.send(confirmCode);

			});
		/* END - Verify confirmation code */
/****************************** END - Carousel Navigation ***********************************/

/* Javascript for step 3 */
	/************* Display thumbnail when profile img is selected by user *******************/
		function handleFileSelect(evt) {
			/* FileList object */
				var files = evt.target.files; 

			/* Loop through the FileList and render image files as thumbnails. */
				for (var i = 0, f; f = files[i]; i++) {
					
					/* Only process image files. */
					    if (!f.type.match('image.*')) {
					    	console.log('this is not an image');
					    	break;
					    }
					   
					 /* Instantiate New FileReader object to read file contents into memory */
					 	var reader = new FileReader();

					 /* When file loads into memory, reader's onload event is fired - Capture file info */	
					 	reader.onload = (function(theFile) {

					 		return function(e) {
					 			/* Render Thumbnail */
					 				var span = document.createElement('span'); //Create a <span></span> element

					 				span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); //LOOK UP .JOIN() METHOD

					 				/* Clear the div that displays the thumbnail b4 new thumbnail is shown */
					 					document.getElementById('thumb').innerHTML = '';

					 				/* Insert new thumbnail */
					 				document.getElementById('thumb').insertBefore(span, null);
					 		}
					 	})(f);

					 	/* Read in the image file as a data URL. */
	      					reader.readAsDataURL(f);
				}
		}
		document.getElementById('sProfileName').addEventListener('change', handleFileSelect, false);
	/*********** END - Display thumbnail when profile img is selected by user ************/

	/* Have to initailize the popover functionality for it to work */
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();
		});
	/* END - Have to initailize the popover functionality for it to work */

/* /Javascript for step 4 */


