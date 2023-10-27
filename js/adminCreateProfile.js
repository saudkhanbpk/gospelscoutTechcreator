 /* Java Script for the Profile creation page on the administrator dashboard */

/* Display thumbanail photo when new img is selected */
	document.getElementById('sProfileName').addEventListener('change', handleFileSelect, false);

/**************************************************** Handle form submission ****************************************************/
	
	//validate form 
		//grab form
			const profileForm = $('#admnProfCreate');

			profileForm.validate({

				//Error display and placement 
					errorPlacement: function(error, element) {
						console.log(error[0]['id']);
		               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
		               
		                if(error[0]['id'] == 'DOB-error' || error[0]['id'] == 'emailConf-error'){
			            	element.parent("div").after(error);
			            }
			            else if(error[0]['id'] == 'loginmaster[sUserType]-error'){
			            	console.log('error message');
			            	$('#userTypeSect').after(error);
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
							let userState = $('#sStateName').val();
							let userCity = new validateZip(userZip, userState);
                            
							userCity.getCityStateOBj
								.then(userCity.returnCity)
								.then(cityFound => {
									console.log(cityFound);
									//submit form via ajax once form and zip code is validated 
										if(cityFound.state == userState){
											const nfo = new FormData(form); 
											nfo.append('usermaster[sCityName]', cityFound.city);

											const xhr = new XMLHttpRequest(); 
											xhr.onload = () => {
												if(xhr.status == 200){
													var response = xhr.responseText.trim();console.log(response);
													let parsedResponse = JSON.parse( response );
													
													if(parsedResponse.profileCreate){
														// Redirect to manage users page
															// window.location = '/adminDashboard/concept-master/manageusers-'+parsedResponse.userType+'.php?act=1';
													}
												}
											}
											xhr.open('post','adminCreateProfileSubmit.php');
											xhr.send(nfo);
										}
										else{
											const err_mess = $('#error-message').text('Sorry, there was a State/Zip Code mismatch!!!')
											console.log('there was an error validating you zip code');
										}
								})
								
					},

				// Set validation rules for the form
				rules:{
					'loginmaster[sEmailID]': {
						required: true,
						email: true
					},
					'loginmaster[sUserType]': {
						required: true
					},
					'loginmaster[sPassword]': {
						required: true,
						minlength: 8 
					},
					'loginmaster[ConfsPassword]': {
						required: true,
						equalTo: "#loginmaster-sPassword"
					},
					'usermaster[sChurchName]': {
						required: true
					},
					'usermaster[sPastorFirstName]': {
						required: true
					},
					'usermaster[sPastorLastName]': {
						required: true
					},
					 'usermaster[sFirstName]': {
						required: true
					},
					'usermaster[sLastName]': {
						required: true
					},
					'usermaster[iZipcode]': {
						required: true,
						minlength: 5,
						maxlength: 5,
						digits: true
					},
					'usermaster[sGender]': {
						required: true
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
					'usermaster[sDenomination]': {
						required: true
					},
					'usermaster[sAddress]': {
						required: true
					},
					'usermaster[sCountryName]': {
						required: true
					},
					'usermaster[sStateName]': {
						required: true
					},
					'usermaster[sContactEmailID]': {
						required: true
					},
					'sProfileName': {
						required: true,
						accept: "image/*"
					},	
					'usermaster[iYearOfExp]': {
						required: true,
						digits: true,
						maxlength: 2
					},
					'talentmaster[TalentID]': {
						required: {
							depends: function(element){
								return $('#soloSelection').is(':checked');
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
					'usermaster[sAvailability]': {
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
					'usermaster[sChurchName]': {
						required: 'Please enter the name of the church'
					},
					'usermaster[sPastorFirstName]': {
						required: 'Please enter a valid name'
					},
					'usermaster[sPastorLastName]': {
						required: 'Please enter a valid name'
					},
					'usermaster[sGender]': {
						required: 'Please select a gender'
					},
					'usermaster[dDOB]': {
						required: "Please enter the pastor's birthdate"
					},
					'usermaster[sDenomination]': {
						required: 'Please select a denomination'
					},
					'usermaster[sAddress]': {
						required: 'Please enter a valid street address'
					},
					'usermaster[sStateName]': {
						required: 'Please select your state'
					},
					'usermaster[iZipcode]': {
						required: 'Please enter your zip code'
					},
					'usermaster[sContactEmailID]': {
						required: 'Please enter a church email address'
					},
				}
			});
/************************************************ END - Handle form submission ************************************************/

/*************************************** Show inputs dependent on the usertype selected  ***************************************/
	/*const userTypes = document.querySelectorAll('.showDepInput'); 
	for(let i=0; i<userTypes.length; i++){
		userTypes[i].addEventListener('click', (event) => {
			let type = event.target.value; 
			
			if(type == 'artist'){
				//Clear group name text input and show artist type select menu 
				$('#u_typeSelectMen').removeClass('d-none');
			}
			else if(type == 'group'){
				//Clear artist type selector and show group name text input 

			}
		});
	}*/

	const userTypes = $('.showDepInput');
	userTypes.click(function(e){
		let type = $(this).val();
		
		if(type == 'artist'){
			//Clear group name text input and show artist type select menu 
				$('#groupName').val('').addClass('d-none');
				$('#u_typeSelectMen').removeClass('d-none');
		}
		else if(type == 'group'){
			//Clear artist type selector and show group name text input 
				$('#u_typeSelectMen').val('').addClass('d-none');
				$('#groupName').removeClass('d-none');

		}

	});

/************************************ END - Show inputs dependent on the usertype selected  ************************************/

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
/************************************** END - Date and Time Picker plugin JS ***********************/