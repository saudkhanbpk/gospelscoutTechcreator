$(document).ready(function(){
	/* Display loading spinwheel */
		displayLoadingElement('contentContainer');
	/* Display loading spinwheel */
		displayLoadingElement('upcEvents');
	/* Call the video tab data when page loads */
		getTabData('Vid',u_type,u_id);


	/* Content Nav Menu functionaity */
		$('.prof-nav').click(function(event){
			event.preventDefault(); 

			/* Display loading spinwheel */
				displayLoadingElement('contentContainer');

			$('.prof-nav').removeClass('active');
			$(this).addClass('active');
			var tab = $(this).attr('id');

			getTabData(tab,u_type,u_id);
		});
	/* END - Content Nav Menu functionaity */


	/********************************
	 *** Video Tab JS
	 ********************************/
	 	/* Call modal to add new video */
			$('#contentContainer').on('click','#addVideo_button',function(event){
				event.preventDefault();
		 		$('#addVideo').modal('show');
		 	});

		/* When New video modal hidden, reset the form */
			$('#addVideo').on('hidden.bs.modal', function (e) {
				/* Call function to reset video form*/
					resetVidForm();
			})

		/* Validate the New video */
		 	var new_vid_form = $('#videoAddID');

		 	new_vid_form.validate({

	    	/* Error message placement and styling  */
	            errorPlacement: function(error, element) {
	               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
	               console.log(error[0]['id']);
	                if(error[0]['id'] == 'videoSource-error'){
		            	$('#step2-err').append(error)
		            }
		            else if(error[0]['id'] == 'vidTalent-error'){
		            	$('#step1-err').append(error);
		            }
		            else{
		            	element.after(error);
		            }
	            },

	      	/* Submit the form */
	          	submitHandler: function(form) {
	            /* Display loading spinwheel */
					displayLoadingElement('contentContainer');	


				/* Prevent Users from embedding youtube links and uploading video simaltaneously */
					// $('#vidName').val() != '' || $('#vidDescr').val() != '' || 
					var vidMethod = '';
					if($('#youtubeInput').val() != '' && ($('#videoFile').val() != '' || $('#thumbnailFile').val() != '')) {
						/* print an error to the Modal */ 
							$('#error-text').html('@ Step 2 - Choose Only One Option to Add Video');
					}
					else{
						if($('#youtubeInput').val() != '' ){ //&& $('#vidTalent').val() != ''
							
							/* Check for valid embed url */
								var valid_url = validateYouTubeUrl( $('#youtubeInput').val() );
								if(valid_url){
									/* Define method type for GET Var*/
										vidMethod = 'youtube';
								}
								else{
									$('#error-text').html('Youtube link is invalid - refer to the "How?" link for instructions');
								}
						}
						else{
							if($('#vidTalent').val() != ''&& $('#vidName').val() != '' && $('#videoFile').val() != ''){ // && $('#vidDescr').val() != ''
								/* Define method type for GET Var*/
									vidMethod = 'upload';	
							}
							else{
								$('#error-text').html('Please Complete All Upload Fields');
							}
						}
					}
				/* END - Prevent Users from embedding youtube links and uploading video simaltaneously */
	              
	            /* Upload new video to the database */
		            if(vidMethod != '') {

			            /* Instantiate new form data obj */
			              var new_vid_formD = new FormData(form); 
			              new_vid_formD.append('videoType',vidMethod);
			              if(vidMethod == 'youtube'){
			              	new_vid_formD.append('youtubeLink',valid_url);
			              }
			                  
			            /* Instiate new form xhr */
			              	var new_vid_xhr = new XMLHttpRequest();
			             	new_vid_xhr.onreadystatechange = function(){
				                if( new_vid_xhr.status == 200 && new_vid_xhr.readyState == 4 ){

				                  var response = new_vid_xhr.responseText.trim();
								  console.log(response);
				                  var parsedResponse = JSON.parse(response);
				                  console.log('test');
				                  

					                // if(response != '' && response =='File Upload Successful'){
					                if(parsedResponse.response){
										/* Call function to fecth the video tab data */
											getTabData('Vid',u_type,u_id);
										
										/* Hide video form modal and Call function to reset video form*/
											$('#addVideo').modal('hide');
											resetVidForm();
									}
									else{
										$('#error-text').html(parsedResponse.err);
									}
				                }
				            }

				            /* Calculate and display the file upload progress */
				            	var serverUploadProgress = document.querySelector('.serverUpload');
								new_vid_xhr.upload.addEventListener('progress', function(e){
								    // console.log('loaded: '+e.loaded+' and Total: '+e.total+'loaded/total: '+(Math.ceil((e.loaded/e.total) * 100) + '%'));
								    var percentLoaded = Math.ceil((e.loaded/e.total) * 100); 
								    if (percentLoaded <= 100) {
								        serverUploadProgress.style.width = percentLoaded + '%';
								        serverUploadProgress.textContent = percentLoaded + '%';
								    }
								}, false);

			              	// new_vid_xhr.open('post', 'https://www.stage.gospelscout.com/views/xmlhttprequest/connectToDb_artistprofile.php')
			              	new_vid_xhr.open('post', 'https://www.stage.gospelscout.com/views/fileUpload.php')
			              	new_vid_xhr.send(new_vid_formD);
			        }
			        else{
			        	console.log('vidMethod is empty');
			        }
			    /* END - Upload new video to the database */
				},
	      	/* END - Submit the form */

	      		groups: {
	      			videoSource: 'youtubeLink videoFile'
	      		},

	      	/* Set validation rules for the form */
		        rules:{
		          VideoTalentID: {
		            required: true,
		          },
		          youtubeLink: {
		          	require_from_group: [1, '.vid_source']
		          },
		          videoFile: {
		          	require_from_group: [1, '.vid_source'],
		          	accept: "video/*"
		          },
		           thumbnailFile: {
		      			required: {
		      				depends: function(element){
		      					return $('#videoFile').val();
		      				}
		      			},
		      			accept: "image/*"
		      		},
		          videoName: {
		      			required: {
		      				depends: function(element){
		      					return $('#videoFile').val();
		      				}
		      			}
		      		},
		        },
		        messages: {
		          VideoTalentID: {
		            required: 'Select a talent',
		          },
		          videoName: {
		            required: 'Give your video a title',
		          },
		          videoFile:{
		          	accept: 'Please upload video files only'
		          },
		          thumbnailFile:{
		          	required: 'Select Thumbnail Img',
		          	accept: 'Image files only for thumbnails'
		          }
		        }
		    });
		/* END - Validate the New video */
	 /********************************
	 *** END - Video Tab JS
	 ********************************/

	/********************************
	 *** Photo Tab JS
	 ********************************/
	 /**** Clear and hide the new album input if a current ablum is selected ****/

	 	$('#photoAlbums').change(function(){
	 		var selection = $(this).val();
	 		if( selection > 0 ){
	 			$('#newAlbumName').addClass('d-none');
	 			$('#newAlbumName').val('');
	 		}
	 		else{
	 			$('#newAlbumName').removeClass('d-none');
	 		}
	 	});

	 /* END - Clear and hide the new album input if a current ablum is selected */
	/* Add New Photo */
			// var form2 = document.forms.namedItem("photoAdd");
			// form2.addEventListener('submit', function(event){

			// 	var photoFile = $('#photoFile').val();
			// 	var newAlbumName = $('#newAlbumName').val();
			// 	var photoAlbums = $('#photoAlbums').val(); 

			// 	if(photoAlbums == '' && newAlbumName == '' || (photoAlbums != '' && newAlbumName != '')){
			// 		$('#error-message-photo').removeClass('d-none');
			// 		document.getElementById('error-text-photo').innerHTML = 'Please Choose a Current Album OR Create a New Album!!!';
			// 	}
			// 	else{
			// 		if(photoFile == ''){
			// 			$('#error-message-photo').removeClass('d-none');
			// 			document.getElementById('error-text-photo').innerHTML = 'Please Choose a Photo to Upload!!!';
			// 		}
			// 		else{
			// 			var photo = 'valid';
			// 		}
			// 	}
				
			// 	if(photo == 'valid'){
			// 		var userID = $('.userID').val();
			// 		var formData2 = new FormData(form2);
			// 		var addNewPhoto = new XMLHttpRequest();
			// 		formData2.append('iLoginID', userID);
					
			// 		addNewPhoto.onreadystatechange = function(){
			// 			if(addNewPhoto.readyState == 4 && addNewPhoto.status == 200){
			// 				console.log(addNewPhoto.responseText);
			// 				if(addNewPhoto.responseText == 'File Upload Successful'){
			// 					form2.reset();
			// 					$('#photoThumb').html('');
			// 					location.reload(); 
			// 				}
			// 			}
			// 		}
			// 		addNewPhoto.open("POST", "fileUpload.php");
			// 		addNewPhoto.send(formData2); 
			// 	}
			// 	event.preventDefault();
			// }, false);
			
		/* END - Add New Photo */


		/* Validate the New Photo Form */
		 	var new_photo_form = $('#photoForm');

		 	new_photo_form.validate({

	    	/* Error message placement and styling  */
	            errorPlacement: function(error, element) {
	               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
	               console.log(error[0]['id']);
	                if(error[0]['id'] == 'videoSource-error'){
		            	$('#step2-err').append(error)
		            }
		            else if(error[0]['id'] == 'vidTalent-error'){
		            	$('#step1-err').append(error);
		            }
		            else{
		            	element.after(error);
		            }
	            },

	      	/* Submit the form */
	          	submitHandler: function(form) {
		            /* Display loading spinwheel */
						displayLoadingElement('contentContainer');	


					/* Prevent Users from embedding youtube links and uploading video simaltaneously */

						var curr_album = $('#photoAlbums').val(); 
						var new_album = $('#newAlbumName').val(); 

						console.log(curr_album); 
						console.log(new_album)
						/* If both values are not empty display error message */
							if( curr_album != '' && new_album != ''){
								$('#error-text-photo').text('Select a current album or create a new album');
							}
							else{
								/* Instiate new form data obj */
					              var new_photo_formD = new FormData(form); 
					                  
					            /* Instiate new form xhr */
					              	var new_photo_xhr = new XMLHttpRequest();
					             	new_photo_xhr.onreadystatechange = function(){
						                if( new_photo_xhr.status == 200 && new_photo_xhr.readyState == 4 ){

						                  var response = new_photo_xhr.responseText.trim();
						                  console.log(response);
						                  var parsedResponse = JSON.parse(response);
						                  console.log(parsedResponse);

									if(parsedResponse.response){
										var album_id = parsedResponse.new_photo.album_id;
										var artist_id = parsedResponse.new_photo.iLoginID;
										/* Re-direct to the view all photo page */
											window.location = 'https://www.stage.gospelscout.com/views/viewAllPhoto.php?albumID='+album_id+'&artistID='+artist_id;
									}
									else{
										$('#error-text').html('There was an error uploading your photo: '+parsedResponse.err);
									}
				                		}
						            }
					              	new_photo_xhr.open('post', 'https://www.stage.gospelscout.com/views/fileUpload.php')
					              	new_photo_xhr.send(new_photo_formD);
							}
					/* END - Prevent Users from embedding youtube links and uploading video simaltaneously */
	              
				},
	      	/* END - Submit the form */

	      		groups: {
	      			targetedAlbum: 'youtubeLink videoFile'
	      		},

	      	/* Set validation rules for the form */
		        rules:{
		          iAlbumID: {
		          	require_from_group: [1, '.targetedAlbum']
		          },
		          newAlbumName: {
		          	require_from_group: [1, '.targetedAlbum'],
		          	accept: "video/*"
		          },
		           photoFile: {
		      			required: true,
		      			accept: "image/*"
		      		},
		        },
		        messages: {
		          photoFile:{
		          	required: 'Please select an image',
		          	accept: 'Image files only for thumbnails'
		          }
		        }
		    });
		/* END - Validate the New Photo Form */

	/********************************
	 *** END - Photo Tab JS
	 ********************************/

	/* Date and Time Picker plugin JS */
		$(function () {
			var dat = $("input[name=todaysDate]").val();
			
		    $("#datetimepicker1").datetimepicker({
			 	format: "MM/DD/YYYY",
			 	//defaultDate: "12/13/2017",
			 	minDate: dat,
			 	//minDate: moment(),
			 	maxDate: moment().add(1,'year'),
			 	//useCurrent: true, 
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
		    $("#datetimepicker5").datetimepicker({
		        format: "LT",
		        stepping: "5",
		        useCurrent: false,
		        allowInputToggle: true
		    });		
		});
	/* END - Date and Time Picker plugin JS */


	/* Select Bookme Type */
		$('.bk-type').click(function(event){
			event.preventDefault();
			var type = $(this).attr('id'); 
			$('.choiceBook').addClass('d-none');
			$('.'+type).removeClass('d-none');
		});
	/* END - Select Bookme Type */

	/********************************
	 *** Handle thumbnail Dispaly
	 ********************************/

	 /********************************
	 *** Handle thumbnail Dispaly
	 ********************************/
	/********************************
	 *** END - Handle thumbnail Dispaly
	 ********************************/


	 function handleFileSelect(evt) {
		var uploadType = $(this)[0]['name'];

		/* FileList object */
			var files = evt.target.files; 

		/* Loop through the FileList and render image files as thumbnails. */
			for (var i = 0, f; f = files[i]; i++) {

				if(uploadType !== 'thumbnailFile'){
					break; 
				}
				else{
					// if(uploadType == 'videoFile'){
					// /* Only process video and image files. */
					//     if (!f.type.match('video.*')) {
					//     	console.log('this is not an image');
					//     	break;
					//     }
					// }
					if(uploadType == 'thumbnailFile'){
						/* Only process video and image files. */
						    if (!f.type.match('image.*')) {
						    	console.log('this is not an image');
						    	// $('#thumb_err').html('Images Only!');
						    	break;
						    }
					}
				}

				 /* Instantiate New FileReader object to read file contents into memory */
				 	var reader = new FileReader();

				 /* When file loads into memory, reader's onload event is fired - Capture file info */	
				 	reader.onload = (function(theFile) {
				 		return function(e) {
				 			if(theFile.type.match('image.*')){
					 			/* Render Thumbnail */
					 				var span = document.createElement('span'); //Create a <span></span> element
					 				
					 				span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); //LOOK UP .JOIN() METHOD
					 				
					 				/* Clear the div that displays the thumbnail b4 new thumbnail is shown */
					 					document.getElementById('thumb').innerHTML = '';

					 				/* Insert new thumbnail */
					 					document.getElementById('thumb').insertBefore(span, null);
				 			}
				 		}
				 	})(f);

				 	/* Read in the image file as a data URL. */
	  					reader.readAsDataURL(f);
			}
	}	

	/* Access Thumbnail FIle data */
		document.getElementById('thumbnailFile').addEventListener('change', handleFileSelect, false);

	/********************************
	 *** END - Handle thumbnail Dispaly
	 ********************************/


	/********************************
	 *** Handle Video Dispaly
	 ********************************/
	 var reader;
		/**** Define Functions ****/
			// Handle a file read error 
				 function errorHandler(evt) {
				    switch(evt.target.error.code) {
				      case evt.target.error.NOT_FOUND_ERR:
				        alert('File Not Found!');
				        break;
				      case evt.target.error.NOT_READABLE_ERR:
				        alert('File is not readable');
				        break;
				      case evt.target.error.ABORT_ERR:
				        break; // noop
				      default:
				        alert('An error occurred reading this file.');
				    };
				  }	

			// Handle the selected file 
				function handleFileSelect1(evt) {

					var file = evt.target.files[0];

				    reader = new FileReader();
				    reader.onerror = errorHandler;
				    
				    reader.onload = (function(currentFile) {
				    	return function(e){

					      	if(currentFile.type.match('video.*')){
					      		$('#vid_err').html('');

				 				/* Render Video Name */
				 					var curr_file_name = '<p class="text-success">'+currentFile.name+'</p>';
					 				document.getElementById('show-vid-name').innerHTML = curr_file_name;
				 			}	
				 			else{
				 				/* Render Video Name */
				 					var curr_file_name = '<p class="text-danger mt-4">Video Files Only</p>';
					 				document.getElementById('show-vid-name').innerHTML = curr_file_name;
				 			}
				    	}
				    })(file);

				    // Read in the video file as a binary string.
				    	reader.readAsBinaryString(evt.target.files[0]);
				}	  	
		/* END - Define Functions */

		/* Access Video FIle data */
			document.getElementById('videoFile').addEventListener('change', handleFileSelect1, false);


	/********************************
	 *** END - Handle Video Dispaly
	 ********************************/


	/* Have to initailize the popover functionality for it to work */
		$('[data-toggle="popover"]').click(function(event){
            console.log('popover test');
			event.preventDefault(); 
		});
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();
		});
	/* END - Have to initailize the popover functionality for it to work */

	/********************************
	 *** subscription Tab JS
	 ********************************/

		/* Update the Subsribee Seetings */
	        $('#contentContainer').on('click', '#subscribeeButton', function(event){
	        	event.preventDefault(); 
				
	        	if($('input[name=vidNotification].subscribeeSettings').prop('checked')){
	        		var vid = '1'; 
	        	}
	        	else{
	        		var vid = '0';
	        	}
	        	if($('input[name=picNotification].subscribeeSettings').prop('checked')){
	        		var pic = '1'; 
	        	}
	        	else{
	        		var pic = '0';
	        	}
	        	if($('input[name=eventNotification].subscribeeSettings').prop('checked')){
	        		var events = '1'; 
	        	}
	        	else{
	        		var events = '0';
	        	}
	        	if($('input[name=gigNotification].subscribeeSettings').prop('checked')){
	        		var gigs = '1'; 
	        	}
	        	else{
	        		var gigs = '0';
	        	}

	            var iRollID = $('input[name=userID]').val(); 
				console.log(`iRollID: ${iRollID}`);
	        	var subscribeeSettingsDisplay = new XMLHttpRequest(); 
	        	subscribeeSettingsDisplay.onreadystatechange = function(){
	        		if(subscribeeSettingsDisplay.status == 200 && subscribeeSettingsDisplay.readyState == 4){
						console.log(subscribeeSettingsDisplay.responseText.trim() );
						var response = subscribeeSettingsDisplay.responseText.trim();
						if(response){
							document.getElementById('chngSaved').innerHTML = 'Saved!'; 
						} else {
							document.getElementById('chngSaved').innerHTML = 'There was a problem updating your settings!'; 
						}
	        		}
	        	}
	        	subscribeeSettingsDisplay.open('GET','https://www.stage.gospelscout.com/views/subscribeSettingsUpdate.php?table=subscribeesetting&iRollID='+iRollID+'&vidNotification='+vid+'&picNotification='+pic+'&eventNotification='+events+'&gigNotification='+gigs); 
	        	subscribeeSettingsDisplay.send(); 
	        });
	    /* END - Update the Subsribee Seetings */

	    /* Update the SubsriberSettings */
    	 // $('#subscriberButton').click(function(event){
	    	$('#contentContainer').on('click', '#subscriberButton', function(event){
	    		event.preventDefault(); 

	        	if($('input[name=vidNotification].subscriberSettings').prop('checked')){
	        		var vid = '1'; 
	        	}
	        	else{
	        		var vid = '0';
	        	}
	        	if($('input[name=picNotification].subscriberSettings').prop('checked')){
	        		var pic = '1'; 
	        	}
	        	else{
	        		var pic = '0';
	        	}
	        	if($('input[name=eventNotification].subscriberSettings').prop('checked')){
	        		var events = '1'; 
	        	}
	        	else{
	        		var events = '0';
	        	}
	        	if($('input[name=gigNotification].subscriberSettings').prop('checked')){
	        		var gigs = '1'; 
	        	}
	        	else{
	        		var gigs = '0';
	        	}
	        	console.log(vid+','+pic+','+events+','+gigs);

	            var iLoginID = $('input[name=userID]').val(); 
	        	var subscriberSettingsDisplay = new XMLHttpRequest(); 
	        	subscriberSettingsDisplay.onreadystatechange = function(){
	        		if(subscriberSettingsDisplay.status == 200 && subscriberSettingsDisplay.readyState == 4){
	        			document.getElementById('chngSaved1').innerHTML = 'Saved!'; 
	        		}
	        	}
	        	subscriberSettingsDisplay.open('GET','https://www.stage.gospelscout.com/views/subscribeSettingsUpdate.php?table=subscribersetting&iLoginID='+iLoginID+'&vidNotification='+vid+'&picNotification='+pic+'&eventNotification='+events+'&gigNotification='+gigs); 
	        	subscriberSettingsDisplay.send(); 
	        });
	    /* Update the Subsriber Settings */

	    /* Mute or Remove a Subscription */
	        $('#contentContainer').on('click', '.muteRemove-choice', function(event){
	            event.preventDefault(); 
				
	            /* Create New formData Object to send form Data via POST method - Append additional element to $_POST array  */
	                var form3 = document.forms.namedItem("muteRemoveForm");
	                var formData = new FormData(form3); 
	                var param1 = $(this).attr('id');
					console.log(param1);
	                formData.append('option', param1);
	            /* END - Create New formData Object to send form Data via POST method - Append additional element to $_POST array  */

	            /* Create New XMLHttpRequest */
	                var muteRemove = new XMLHttpRequest(); 
	                muteRemove.onreadystatechange = function(){
	                    if(muteRemove.status == 200 && muteRemove.readyState == 4){
	                        console.log(muteRemove.responseText.trim());
	                        /* Call the video tab data when page loads */
								getTabData('Subscribe',u_type,u_id);
	                    }
	                }
	                muteRemove.open('POST', 'subscribeSettingsUpdate.php');
	                muteRemove.send(formData);
	            /* END - Create New XMLHttpRequest */
	        });

	    /* Add/Remove Subscription via the subscribee's page */
            $('#contentContainer').on('click', '.checkexist',function(event){
                event.preventDefault(); 
                if($(this).attr('id') == 'subFalse'){
                    var param9 = '?del=1';
                }
                else{
                    var param9 = '?add=1';
                }

                var param10 = '&iRollID='+ $(this).attr('iRollID');
                var param11 = '&iLoginID='+ $(this).attr('iLoginID');
                var del = new XMLHttpRequest(); 
                del.onreadystatechange = function(){
                    if(del.status == 200 && del.readyState == 4){
                        var response = del.responseText.trim();
						console.log(response);
                        var parsedResponse = JSON.parse(response);
                        
                        if(parsedResponse.response == 'sub_added' || parsedResponse.response == 'sub_deleted'){
                        	/* Call the video tab data when page loads */
					getTabData('Subscribe',u_type,u_id);
                        }
                    }
                }
                del.open('GET', 'https://www.stage.gospelscout.com/views/subscribeSettingsUpdate.php'+param9+param10+param11);
                del.send();
            });
        /* END - Add/Remove Subscription via the subscribee's page */        

    /********************************
	 *** END - subscription Tab JS
	 ********************************/

	 /********************************
	 *** Upcoming Event Query
	 ********************************/
	 	/* Display loading spinwheel */
		var ueqXhr = new XMLHttpRequest();
		ueqXhr.onload = () => {
			if(ueqXhr.status == 200){
				today = new Date().getTime();
				var response = ueqXhr.responseText.trim();
				var parsedResponse = JSON.parse(response);
				
				console.log(parsedResponse.length);
				if(parsedResponse.length == 0){
					var eventHtml= '<h5 class="container mt-5 text-center" style="color: rgba(204,204,204,1)">No upcomming gigs or events.</h5>'
					$('#upcEvents').html(eventHtml);
				}else{
					/* Upcoming gigs only */
						parsedResponse = parsedResponse.filter( (gig) => new Date(gig.start).getTime() >= today );
					/* Order gigs in ascending order */
						parsedResponse.sort( (a, b) =>  new Date(a.start).getTime() - new Date(b.start).getTime() );
					/* grab next 3 upcoming gigs */
						parsedResponse = parsedResponse.slice(0,3);
					/*
						Create function to display the upcoming gig section
					*/
						var eventHtml= displayUpcEvents(parsedResponse);
						$('#upcEvents').html(eventHtml);
				}
				
				
			}
		}
		ueqXhr.open('get',`https://www.stage.gospelscout.com/calendar/phpBackend/myFeed.php?u_Id=${u_id}&formatTime=true`);
		ueqXhr.send();
	 /********************************
	 *** END - Upcoming Event Query
	 ********************************/

	/********************************
 	*** Validate User before accessing user calendar
	********************************/
		$('#viewCal').on('click', (e) => {
			e.preventDefault(); 
			// Check if user is logged in
			var userStatus = $('input.userSubStat').val();
			var userId = $('input.userID').val();
			if(userStatus === 'siteGuest'){
				// toggle login Modal
				$('#login-signup').modal('toggle');
				$('#btn_login').attr('viewCal', true); 
				$('#btn_login').attr('viewCalId',userId);
				
			}else{
				window.location = `https://www.stage.gospelscout.com/calendar/?u_Id=${userId}`;
			}
		});
	/********************************
	 *** END - Validate User before accessing user calendar
	 ********************************/


});/* END - Document Ready */