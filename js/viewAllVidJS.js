

/**************************************************************************************************
 ****************************** Edit Video Info ***************************************************
 **************************************************************************************************/

	/*********************************************** Edit anchor actions ***********************************************/
		$('.editVidSubmit').click(function(event){
			/* Determine video type - Upload or YouTube */
				var videoType = $(this).attr('vidType');

			/* Prepend the option to edit thumbnail if video type == upload - if type == youtube hide upload option*/
				if(videoType == 'upload'){
					$('div.prepend-element').removeClass('d-none');

					/* Insert the selected video's thumbnail file path into a hidden input in the modal form */
						var currentThumbnail = $(this).attr('vidThumbnail');
						var currentVid = $(this).attr('vidPath');
						var defaultThumbnail = '../img/gsStickerBig1.png';
						$('input[name=videoThumbnailPath]').attr('id', currentThumbnail);
						$('input[name=videoPath]').attr('id', currentVid);

					/* Add the selected video's thumbnail and insert it as the background image of the thumbnail preview in the modal */
						if(currentThumbnail == ''){
							$('#thumb').css('background-image','url('+defaultThumbnail+')');
						}
						else{
							$('#thumb').css('background-image','url('+currentThumbnail+')'); 
						}
				}
				else if(videoType == 'youtube'){
					$('div.prepend-element').addClass('d-none');
				}

			/* Grab the selected videos information */
				var videoID = $(this).attr('vidID');
				var videoTitle = $(this).attr('vidTitle');
				var videoDescription = $(this).attr('vidDescr');

			/* Insert the video's current info into input fields for editing */
				$('input[name=id]').val(videoID);
				$('input[name=videoName]').val(videoTitle);
				$('textarea[name=videoDescription]').val(videoDescription);
		});
	/******************************************** END - Edit anchor actions *********************************************/

	/*********************************************** Show Video thumbnail ***********************************************/
		function handleFileSelect1(evt) {
			var uploadType = $(this)[0]['name'];
			/* FileList object */
				var files = evt.target.files; 

			/* Loop through the FileList and render image files as thumbnails. */
				for (var i = 0, f; f = files[i]; i++) {

					if(uploadType == 'videoThumbnailPath'){
						/* Only process video and image files. */
						    if (!f.type.match('image.*')) {
						    	console.log('this is not an image');
						    	break;
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
			document.getElementById('videoThumbnailPath').addEventListener('change', handleFileSelect1, false);
	/******************************************** END - Show Video thumbnail ********************************************/

	/********************************************** Submit editing changes **********************************************/
		$('button[type=submit]').click(function(event){
			event.preventDefault();

			/* Define Variables */
				var formAction = $(this).attr('id');
				var u_type = '<?php echo $currentUserType;?>'; 
				var formCurrent  = document.forms.namedItem('editVid');
				var formNew  = new FormData(formCurrent);
				var currentThumbnailPath = $('input[name=videoThumbnailPath]').attr('id');
				var currentVideoPath = $('input[name=videoPath]').attr('id');
// console.log(formAction);
			/* Append needed elements to form array */
				formNew.append('action', formAction);
				formNew.append('contentMarker', 'video');
				formNew.append('currentThumbnailPath', currentThumbnailPath);

				if(formAction == 'removeVideo'){
					formNew.append('currentVideoPath', currentVideoPath);
				}

			/* Create new XMLHttpRequest to submit form to fileUpload.php */
				var edVidFormSubmit = new XMLHttpRequest();
				edVidFormSubmit.onreadystatechange = function(){
					if(edVidFormSubmit.status == 200 && edVidFormSubmit.readyState == 4){
						var response = edVidFormSubmit.responseText.trim(); 
						console.log(response);
						var parsedResponse = JSON.parse(response);

						if(parsedResponse.response){
							location.reload(); 
							console.log('Changes Saved');
						}
						else{
							console.log(parsedResponse.err);
						}
					}
				}
				edVidFormSubmit.open('post', 'https://www.stage.gospelscout.com/views/fileUpload.php');//vidEdit
				if(u_type == 'admin'){
					var vidDelReason = $('textarea[name=vidDelReason]').val();

					if(vidDelReason != ''){
						formNew.append('vidDelReason', vidDelReason);
						edVidFormSubmit.send(formNew);
					}
					else{
						$('#err_mess').removeClass('d-none');
						$('textarea[name=vidDelReason]').css('box-shadow', '0px 0px 5px 0px red')
						$('#err_mess p').html('Please Provide A Reason For Deleting This Video!');
					}
				}
				else{
					edVidFormSubmit.send(formNew);
				}
		})
	/******************************************* END - Submit editing changes ******************************************/

/********************************************************************************************************
 ****************************** END - Edit Video Info ***************************************************
 ********************************************************************************************************/
 