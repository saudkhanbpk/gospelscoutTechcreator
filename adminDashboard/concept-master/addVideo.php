	<!-- Admin Add video  -->

		<!-- Modal Window -->
			<style>
				#progress_bar {
					margin: 10px 0;
					padding: 3px;
					border: 1px solid #000;
					font-size: 14px;
					clear: both;
					opacity: 0;
					-moz-transition: opacity 1s linear;
					-o-transition: opacity 1s linear;
					-webkit-transition: opacity 1s linear;
				}
				#progress_bar.loading {
					opacity: 1.0;
				}
				#progress_bar .percent {
					background-color: #99ccff;
					height: auto;
					width: 0;
				}
				.thumb {
					width: 100px;
					height: 100px;
					object-fit:cover; 
					object-position:0,0;
				}
				#photoThumb, #thumb {
					box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);
					background-image: url("<?php echo URL;?>img/dummy.jpg");
					background-size: 100px 100px;
					background-repeat:  no-repeat;
					background-position:  center;
					object-fit:cover; 
					object-position:0,0;
				}
			</style>
			<div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="addVideoTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	<div class="container p-3 text-center mb-0 d-none" id="error-message"><p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text" style="border-radius:7px"></p></div>
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Add New Video</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form action="fileUpload.php" method="POST" name="videoAdd" id="videoAddID" enctype="multipart/form-data">
			      	<input type="hidden" name="u_type" value="<?php echo $u_type;?>">
				      <div class="modal-body">
				      	<?php if($u_type == 'artist' || $u_type == 'church'){?>
				      		
				      		<h6 class="text-gs">Step 1</h6>
				      		<div class="container">
					      		<div class="form-group">
					      			<?php if($u_type == 'artist'){?>
						      			<select class="custom-select form-control mb-2" id="vidTalent" name="VideoTalentID">
											<option value=''>Choose Talent</option>
										  	<?php foreach($getTalentResults as $talent){
												echo '<option value="' . $talent['TalentID'] . '">'; 
														echo str_replace("_","/",$talent['talent']); 
												echo '</option>';
											}?>
										</select>
									<?php }
										  elseif($u_type == 'church'){?>
											<select class="custom-select form-control mb-2" id="vidTalent" name="VideoMinistryID">
												<option value=''>Choose Ministry</option>
											  	<?php foreach($getMinistryResults as $ministry){
													echo '<option value="' . $ministry['iGiftID'] . '">'; 
															echo str_replace("_","/",$ministry['sGiftName']); 
													echo '</option>';
												}?>
											</select>
									<?php }?>
					      		</div>
					      	</div>
				      		<hr class="my-2"> <!-- Page Divider -->
				      	<?php }
			      			  else{
			      			  		echo '<input type="hidden" name="VideoTalentID" value="00">';
			      			  }
			      		?>

				      		<h6 class="text-gs">
				      			<?php if($u_type == 'group'){
				      						echo 'Step 1';
				      					}
				      					else{
				      						echo 'Step 2';
				      					}
				      			?>
				      		</h6>
				      		<div class="container">
					    		<div class="form-group">
					    			<label for="youtubeInput">Youtube Link</label>
								    <input type="text" name="youtubeLink" class="form-control" id="youtubeInput" aria-describedby="emailHelp" placeholder="Enter Youtube Link">
								    <small id="emailHelp" class="form-text text-muted">Save Time and Embed a Youtube Video Instead of Uploading.  
								    	<a href="#" data-toggle="popover" data-html="true" data-trigger="focus" title="Embed a YouTube Video" data-content="<ol><li>Go to the Youtube page of the video to be embedded.</li>
		                    				<li>Under the video click share.</li>
		                    				<li>Click embed.</li>
		                    				<li>From the box that appears, copy the HTML code.</li>
		                    				<li>Paste the code in the input box provided here.</li></ol>">
		                    				How?
		                    			</a>
	                    			</small>
								    	<!-- <a href="#" data-toggle="modal" data-target="#embedInstr">How?</a></small> -->
								    <!-- <a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-html="true" data-trigger="focus" title="Dismissible popover" data-content="<ol><li>test1</li><li>test2</li><li>test3</li><li></li><li></li></ol>">
								    	Dismissible popover
								    </a> -->
					    		</div>
					    		
					    		<h6 class="" style="font-weight:bold">OR</h6>
						    	<div class="form-group">
						    		<label for="vidTalent">Upload Video</label>
						    		<div class="row mb-2">
						    			<div class="col">
						    				<!-- Show Upload Thumbnail Photo -->
						    					<div class="" id="thumb" style="height:100px;width:100px;"></div>
											<!-- Show Upload Thumbnail Photo -->
						    			</div>
						    			<div class="col">
						    				<!-- Show Upload Video File Name-->
						    					<div id="show-vid-name" class="text-success"></div>
						    				<!-- /Show Upload Video File Name-->
						    			</div>
						    		</div>
						    		<div class="row">
						    			<div class="col">
											<!-- Upload Thumbnail Photo -->
												<div class="custom-file mb-2">
												  	<input type="file" class="custom-file-input" id="thumbnailFile" name="thumbnailFile">
												  	<label class="custom-file-label" for="thumbnailFile">Thumbnail</label>
												</div>
											<!-- Upload Thumbnail Photo -->
										</div>
						    			<div class="col">
								    		<!-- Upload Video File -->
									    		<div class="custom-file mb-2">
												  	<input type="file" class="custom-file-input" id="videoFile" name="videoFile">
												  	<label class="custom-file-label" for="videoFile"> Video</label>
												  	<!-- <div id="progress_bar"><div class="percent">0%</div></div> -->
												  	<div class="progress mt-2">
								 	 					<div class="progress-bar progress-bar-striped progress-bar-animated percent" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
													</div>
												</div>
											<!-- /Upload Video File -->
										</div>
									</div>
								</div>
							</div>
							<hr class="my-2"> <!-- Page Divider -->
							<h6 class="text-gs">
								<?php if($u_type == 'group'){
				      						echo 'Step 2';
				      					}
				      					else{
				      						echo 'Step 3';
				      					}
				      			?>
							</h6>
							<div class="container">
								<div class="form-group">
									<label for="vidTalent">Add Video Title & Description</label>
									<input class="form-control mb-2" type="text" id="vidName" name="videoName" placeholder="Video Title" style="width:">
							    	<textarea class="form-control mb-2" id="vidDescr" name="videoDescription" placeholder="Video Description" wrap="" rows="7" aria-label="With textarea"></textarea>
							    </div>
							</div>
				    	<!-- Progress Bar for uploading Files -->
				    		<div class="container">
				    			<h6>Upload Status</h6>
						    	<div class="progress mt-2">
			 	 					<div class="progress-bar progress-bar-striped progress-bar-animated serverUpload " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
								</div>
							</div>
				    		<!-- <div class="progress">  percent
								  <div class="progress-bar progress-bar-striped progress-bar-animated percent" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
								</div>
							 -->
							 <!-- style="width: 75%" -->
						<!-- /Progress Bar for uploading Files -->
				      </div>
				    		
				      <!-- Javascript to Display thumbnail when profile img is selected by user -->
				      	<script>
				      		/******************************** Display thumbnail when profile img is selected by user **************************************/
								function handleFileSelect(evt) {
									var uploadType = $(this)[0]['name'];
									console.log(uploadType);
									/* FileList object */
										var files = evt.target.files; 

									/* Loop through the FileList and render image files as thumbnails. */
										for (var i = 0, f; f = files[i]; i++) {

											if(uploadType !== 'videoFile' && uploadType !== 'thumbnailFile'){
												break; 
											}
											else{
												if(uploadType == 'videoFile'){
												/* Only process video and image files. */
												    if (!f.type.match('video.*')) {
												    	console.log('this is not an image');
												    	break;
												    }
												}
												if(uploadType == 'thumbnailFile'){
													/* Only process video and image files. */
													    if (!f.type.match('image.*')) {
													    	console.log('this is not an image');
													    	break;
													    }
												}
											}
										
											    // else{
											    // 	continue; -- LOOK UP WHAT CONTINUE DOES TO THE JS
											    // }

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
											 			if(theFile.type.match('video.*')){
											 				/* Render Video Name */
												 				document.getElementById('show-vid-name').innerHTML = escape(theFile.name);
											 			}	
											 		}
											 	})(f);

											 	/* Read in the image file as a data URL. */
							      					reader.readAsDataURL(f);
										}
								}	

								/* Access Thumbnail FIle data */
									document.getElementById('thumbnailFile').addEventListener('change', handleFileSelect, false);
							/****************************** END - Display thumbnail when profile img is selected by user *******************************/

							/************************************************ Video Upload Progress Bar ************************************************/

								var reader;
								var progress = document.querySelector('.percent');

								/**** Define Functions ****/

									// Abort the file read 
										function abortRead() {
											reader.abort();
										}

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

									// Update progress bar when file read has made progress
										function updateProgress(evt) {
											console.log('progress function called beh');
										    // evt is an ProgressEvent.
										    if (evt.lengthComputable) {
										      var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
										      // Increase the progress bar length.
										      if (percentLoaded < 100) {
										        progress.style.width = percentLoaded + '%';
										        progress.textContent = percentLoaded + '%';
										      }
										    }
										  }

									// Handle the selected file 
										function handleFileSelect1(evt) {
											console.log('file handler called ');
											var file = evt.target.files[0];
										    // Reset progress indicator on new file selection.
										    progress.style.width = '0%';
										    progress.textContent = '0%';

										    reader = new FileReader();
										    reader.onerror = errorHandler;
										    console.log(reader.onprogress);
										    console.log(reader);
										    reader.onprogress = updateProgress;
										    // reader.onabort = function(e) {
										    //   alert('File read cancelled');
										    // };
										    reader.onloadstart = function(e) {
										      // document.getElementById('progress_bar').className = 'loading';
										    };
										   //  reader.onload = function(e) {
										   //    // Ensure that the progress bar displays 100% at the end.
										   //    progress.style.width = '100%';
										   //    progress.textContent = '100%';
										   //    // setTimeout("document.getElementById('progress_bar').className='';", 2000);
										   //    if(e.type.match('video.*')){
										   //    	console.log('test mime type');
									 			// 	/* Render Video Name */
										 		// 		document.getElementById('show-vid-name').innerHTML = escape(e.name);
									 			// }	
									 			// else{
									 			// 	console.log(e);
									 			// }
										   //  }
										    reader.onload = (function(currentFile) {
										    	return function(e){
										    		// Ensure that the progress bar displays 100% at the end.
											     	 progress.style.width = '100%';
											     	 progress.textContent = '100%';
											     	 // setTimeout("document.getElementById('progress_bar').className='';", 2000);
											     	 console.log(currentFile);
											      	if(currentFile.type.match('video.*')){
											      		console.log('test mime type');
										 				/* Render Video Name */
											 				document.getElementById('show-vid-name').innerHTML = escape(currentFile.name);
										 			}	
										 			else{
										 				console.log(currentFile);
										 			}
										    	}
										    })(file);

										    // Read in the video file as a binary string.
										    reader.readAsBinaryString(evt.target.files[0]);
										}	  	
								/* END - Define Functions */

								/* Access Video FIle data */
									document.getElementById('videoFile').addEventListener('change', handleFileSelect1, false);


							/********************************************* END - Video Upload Progress Bar *********************************************/

							/* Have to initailize the popover functionality for it to work */
								$(document).ready(function(){
									$('[data-toggle="popover"]').popover();
								});
							/* END - Have to initailize the popover functionality for it to work */
				      	</script>
				       <!-- /Javascript to Display thumbnail when profile img is selected by user -->
				      <input type="hidden" name="contentMarker" value="video">
				      <div class="modal-footer">
				        <button type="submit" class="btn btn-gs" id="addVid">Add Video</button>
				      </div>
			      </form>
			    </div>
			  </div>
			</div>
		<!-- /Modal Window -->
	<!-- /Video Container Header -->

<script>
	/* Add a New Video */
		var form1 = document.forms.namedItem("videoAdd");
		form1.addEventListener('submit', function(event){
			$('#error-message').addClass('d-none');

			/* Prevent Users from embedding youtube links and uploading video simaltaneously */
				// $('#vidName').val() != '' || $('#vidDescr').val() != '' || 
				var vidMethod = '';
				if($('#youtubeInput').val() != '' && ($('#videoFile').val() != '' || $('#thumbnailFile').val() != '')) {
					/* print an error to the Modal */ 
						$('#error-message').removeClass('d-none');
						$('#error-text').html('Choose Only One Option to Add Video');
				}
				else{
					if($('#youtubeInput').val() != '' && $('#vidTalent').val() != ''){
						/* Define method type for GET Var*/
							vidMethod = 'youtube';
					}
					else{
						if($('#vidTalent').val() != ''&& $('#vidName').val() != '' && $('#vidDescr').val() != '' && $('#videoFile').val() != ''){
							/* Define method type for GET Var*/
								vidMethod = 'upload';	
						}
						else{
							$('#error-text').html('Please Complete All Upload Fields');
							$('#error-message').removeClass('d-none');
						}
					}
				}
			/* END - Prevent Users from embedding youtube links and uploading video simaltaneously */

			/* If video method is assigned, send form info to fileUpload.php */
				if(vidMethod != ''){
					var userID = '<?php echo $u_ID;?>';
					var formData1 = new FormData(form1);
					// console.log(formData1);
					var addNewVid = new XMLHttpRequest();
					/*
					addNewVid.addEventListener("progress",testFunction);
					addNewVid.addEventListener("load",loaded);
					addNewVid.addEventListener("error",failed);
					addNewVid.addEventListener("abort",abort);
					*/
					formData1.append('videoType',vidMethod);
					formData1.append('iLoginID', userID);

					addNewVid.onreadystatechange = function(){

						if(addNewVid.readyState == 4){
							/************************* Create File Upload Status bar *************************/
							// console.log(addNewVid.response);
								try {
						            var resp = JSON.parse(addNewVid.response);
						        } catch (e){
						            var resp = {
						                status: 'error',
						                // data: 'Unknown error occurred: [' + addNewVid.responseText + ']'
						            };
						        }
						        // console.log(resp.status + ': ' + resp.data);

							/********************** END - Create File Upload Status bar **********************/
						}

						if(addNewVid.readyState == 4 && addNewVid.status == 200){
							console.log(addNewVid.responseText);
							if(addNewVid.responseText != '' && addNewVid.responseText =='File Upload Successful'){
								$('#error-text').html(addNewVid.responseText);
								$('#error-message').removeClass('d-none');
								document.getElementById("videoAddID").reset();
								location.reload(); 
							}
							else{
								$('#error-text').html(addNewVid.responseText);
								$('#error-message').removeClass('d-none');
							}
						}
						//console.log('error: '+ev.); 
					}

					var serverUploadProgress = document.querySelector('.serverUpload');
					addNewVid.upload.addEventListener('progress', function(e){
					    // _progress.style.width = Math.ceil((e.loaded/e.total) * 100) + '%';
					    console.log('loaded: '+e.loaded+' and Total: '+e.total+'loade/total: '+(Math.ceil((e.loaded/e.total) * 100) + '%'));
					    var percentLoaded = Math.ceil((e.loaded/e.total) * 100); 
					    if (percentLoaded <= 100) {
					        serverUploadProgress.style.width = percentLoaded + '%';
					        serverUploadProgress.textContent = percentLoaded + '%';
					    }
					    // else if(percentLoaded == 100){

					    // }
					}, false);
					addNewVid.open("POST", "<?php echo URL;?>views/fileUpload.php"); 
					/*
					function testFunction(ev){
						console.log("loaded: "+ev.loaded);
						console.log("total: "+ev);
						console.log("total: "+ev.lengthComputable);
					}
					function loaded(ev){
						console.log("load: "+ev.loaded);
					}
					function failed(ev){
						console.log("error: "+ev);
					}
					function abort(ev){
						console.log("abort: "+ev);
					}
					*/
					addNewVid.send(formData1);  
				}
			/* END - If video method is assigned, send form info to fileUpload.php */

			event.preventDefault();
		}, false);
	/* END - Add a New Video */	
	</script>