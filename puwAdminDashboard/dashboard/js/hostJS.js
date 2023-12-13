/******************** puwAdminDashboard HOSTs.PHP JS ********************/


/* Functions */
	function resetModalForms(){
		// document.getElementById("loggedInApply").reset();
		// document.getElementById("addMusicLinks").reset();
		document.getElementById("addHost").reset();
		// document.getElementById("attendEvent").reset();

		/* Clear possible error messages from form */
			$('.error-message').text('');
	}

	function requestSubmitted(){
		/* close modals and reset the forms*/
			$('#addHostModal').modal('hide');
			// $('#reqsNotMet').modal('hide');
			// $('#wannaHost').modal('hide');
			// $('#wannaAttend').modal('hide');

			resetModalForms();

		/* Show the thank you modal */
			$('#requestSubmitted').modal('show');
	}
/* End - Functions */

/* Modal Event callbacks */
	$('#hostDeleted').on('hidden.bs.modal', function (e) {
	 	location.reload(); 
	});

	$('#requestSubmitted').on('hidden.bs.modal', function (e) {
	 	location.reload(); 
	})


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
 *** Add New Host
 *************************/

/* Show 'add new host' modal */
	$('#addNewHost').click(function(event){
		
		// event.preventDefault(); 

		$('#addHostModal').modal('show');
	});


/* Form for users applying to be hosts */

	const form3 = $('#addHost');

	form3.validate({

		// console.log('test val');

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

			// Show Loading spinwheel
				$('#addHostModal').modal('hide');
				let action = 'show';
				displayLoadingPage(action);

			// Variables 
				let userZip = $('#iZipcode').val(); 
				let userStateId = $('#sStateName').val();
				let userState = $('#sStateName option[value='+userStateId+']').text().trim();
				let userCity = new validateZip(userZip, userState);

			// Number of invalid imgs being uploaded
				let  invalidImgs = dropzone.getRejectedFiles().length;
				var cityFound = 'Ventura';
			
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
												formData.append('approved', 1);
												i++; 
										});

									/* Send dropzone data */
										var sendQueue = dropzone.processQueue(); 

							}
							else{
								let action = 'hide';
								displayLoadingPage(action);
								$('#addHostModal').modal('show');
								$('.error-message').text('Sorry, there was an error with @ least 1 of your images');
								console.log('there was an error uploading your images');
							}
						}
						else{
							let action = 'hide';
							displayLoadingPage(action);	
							$('#addHostModal').modal('show');

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

/*************************
 *** END - Add New Host
 *************************/



/*************************
*** Dropzone file uploader 
*************************/
 	
	var dropzone = new Dropzone(
		'#demo-upload', 
		{	
			url: 'https://www.stage.gospelscout.com/popupworship/phpBackend/connectToDb.php',
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
			  		let parsedFileResponse = jQuery.parseJSON(file[0].xhr.responseText);

			  		/* Hide loading spinwheel */
						let action = 'hide';
						displayLoadingPage(action);

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
*** Show Host Info
*************************/
	$('.getHost').click(function(event){

		event.preventDefault(); 

		let action = 'show';
		displayLoadingPage(action);

		/* Get Host info */
			let host_id = $(this).attr('hostID');

			var host_xhr = new XMLHttpRequest(); 
			host_xhr.onload = function(){
				if(host_xhr.status == 200){
					// console.log( host_xhr.responseText.trim() );
					var parsedResponse = JSON.parse( host_xhr.responseText.trim() );
					// console.log( parsedResponse ); 

					if(parsedResponse.host_available){
						/* Hide loading spinwheel */
							let action = 'hide';
							displayLoadingPage(action);

						/* Fetch all td elements in the .loo_container div */
							var hostCharateristics = document.querySelectorAll('div.loop_container td');

						/*
						** Loop through the JSON response and td elements to find a match
						** when match is found insert JSON data in associated td elemnt
						*/
							for(x in parsedResponse){
								for(var i=0; i<hostCharateristics.length; i++){

									if(x == hostCharateristics[i].id){
										if(parsedResponse[x] == ''){
											hostCharateristics[i].innerHTML = 'N/A';
										}
										else {

											if(x == 'hCapAccessible' ){
												if(parsedResponse[x] == '1'){
													hostCharateristics[i].innerHTML = 'Yes';
												}
												else{
													hostCharateristics[i].innerHTML = 'No';
												}
											}
											else{
												hostCharateristics[i].innerHTML = parsedResponse[x];
											}
										}
									}
								}
							}

						/* Loop through the days and insert into list */
							let daysList = '<ul class="p-0" style="list-style:none">'; 
							for(y in parsedResponse.days){
								daysList += '<li class="m-0">'+ parsedResponse.days[y] +'</li>';
							}
							daysList += '</ul>';

						/* Display Host's images */
							let imgsList = '<div class="container"><div class="row">';
							for(z in parsedResponse.file_paths){
								imgsList += '<div class="col col-md-3"><a class="imgPath" target="_blank" href="'+ parsedResponse.file_paths[z] +'"><img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="'+ parsedResponse.file_paths[z] +'" width="300" height="300" data-src="" alt="Generic placeholder image"></a></div>';
							}
							imgsList += '</div></div>';

						/* Insert the following values directly */
							$('#hostID_modal').html(parsedResponse.host_id);
							$('#startTime').html(parsedResponse.startTime);
							$('#endTime').html(parsedResponse.endTime);
							$('#daysAvail_table').html( daysList );
							$('#imgs_table').html( imgsList );
							$('#confirmDeleteHost').attr('hostID', parsedResponse.host_id );




						$('#viewHostModal').modal('show');
					}
					else{
						var errMessage = 'There was a problem retrieving the selected host'
					}
					
				}
			}
			host_xhr.open('get', 'https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php?host_info='+host_id);
			host_xhr.send(); 

	});
/*************************
*** END - Show Host Info
*************************/

/*************************
*** Delete Host 
*************************/
	$('#deleteHost').click(function(event){
		event.preventDefault(); 
		$('#viewHostModal').modal('hide');
		$('#confirmHostDeletion').modal('show');
	});

	$('#confirmDeleteHost').click(function(event){
		event.preventDefault(); 

		var hostID_del = $(this).attr('hostID');
		var imgPaths = document.querySelectorAll('.imgPath');

		/* Create new form data object */
			var hostData = new FormData(); 
			hostData.append('delete_host',true);
			hostData.append('hostID_del',hostID_del);
			
			for(var i=0; i<imgPaths.length; i++){
				console.log(imgPaths[i].href);
				hostData.append('filePaths[]',imgPaths[i].href);
			}

		/* Create new XMLHttpRequest() */
			var delHost_xhr = new XMLHttpRequest(); 
			delHost_xhr.onload = function(){
				if(delHost_xhr.status == 200){
					console.log(delHost_xhr.responseText);
					// var parsedResponse = JSON.parse(delHost_xhr.responseText);
					// console.log(parsedResponse);

					// if(parsedResponse.deleted == true){
					// 	$('#confirmHostDeletion').modal('hide');
					// 	$('#hostDeleted').modal('show');
					// }
					// else{
					// 	$('#hostDeletedMessage').html('There was a problem deleting this host!!');
					// }
				}
			}
			delHost_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php'); //?delete_host=true&hostID_del='+hostID_del
			delHost_xhr.send(hostData); 
	});

	// $('#hostDeleted').on('hidden.bs.modal', function (e) {
	//  	location.reload(); 
	// });
/*************************
*** END - Delete Host 
*************************/