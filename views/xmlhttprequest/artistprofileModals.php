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
		</style>
		<div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="addVideoTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		    	<!-- <div class="container p-3 text-center mb-0 d-none" id="error-message"><p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text" style="border-radius:7px"></p></div> -->
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Add New Video</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form action="fileUpload.php" method="POST" name="videoAdd" id="videoAddID" enctype="multipart/form-data">
		      	<input type="hidden" name="u_type" value="<?php echo $userRow[0]['sUserType'];?>">
			      <div class="modal-body">
			      	<?php 
					  if($userRow[0]['sUserType'] == 'artist' || $userRow[0]['sUserType'] == 'church'){?>
			      		
			      		<h6 class="text-gs">Step 1</h6>
			      		<div class="container">
				      		<div class="form-group">
				      			<?php if($userRow[0]['sUserType'] == 'artist'){?>
					      			<select class="custom-select form-control mb-2" id="vidTalent" name="VideoTalentID">
										<option value=''>Choose Talent</option>
									  	<?php foreach($getTalents as $talent){
											echo '<option value="' . $talent['TalentID'] . '">'; 
													echo str_replace("_","/",$talent['talent']); 
											echo '</option>';
										}?>
									</select>
								<?php }
									  elseif($userRow[0]['sUserType'] == 'church'){?>
										<select class="custom-select form-control mb-2" id="vidTalent" name="VideoMinistryID">
											<option value=''>Choose Ministry</option>
										  	<?php foreach($currentMinistries as $ministry){
												echo '<option value="' . $ministry['iGiftID'] . '">'; 
														echo str_replace("_","/",$ministry['sGiftName']); 
												echo '</option>';
											}?>
										</select>
								<?php }?>
				      		</div>
				      		<div class="text-center" id="step1-err"></div>
				      	</div>
			      		<hr class="my-2"> <!-- Page Divider -->
			      	<?php }
		      			  else{
		      			  		echo '<input type="hidden" name="VideoTalentID" value="00">';
		      			  }
		      		?>

			      		<h6 class="text-gs">
			      			<?php if($userRow[0]['sUserType'] == 'group'){
			      						echo 'Step 1';
			      					}
			      					else{
			      						echo 'Step 2';
			      					}
			      			?>
			      		</h6>
			      		<div class="container" id="vid_src_container">
				    		<div class="form-group">
				    			<label for="youtubeInput">Youtube Link</label><!-- data-trigger="focus"-->
							    <input type="text" name="youtubeLink" class="form-control vid_source" id="youtubeInput" aria-describedby="emailHelp" placeholder="Enter Youtube Link">
							    <small id="emailHelp" class="form-text text-muted">Save Time and Embed a Youtube Video Instead of Uploading.  
							    	<a href="#" data-toggle="popover" data-html="true"  title="Embed a YouTube Video" data-content="<ol><li>Go to the Youtube page of the video to be embedded.</li>  
	                    				<li>Under the video click share.</li>
	                    				<li>Click embed.</li>
	                    				<li>From the box that appears, copy the 'src' value.</li>
	                    				<li>Paste the code in the input box provided here.</li></ol>">
	                    				How?
	                    			</a>
                    			</small>
				    		</div>
				    		
				    		<h6 class="" style="font-weight:bold">OR</h6>
					    	<div class="form-group">
					    		<label for="vidTalent">Upload Video</label>
					    		<div class="row mb-2">
					    			<div class="col-6">
					    				<!-- Show Upload Thumbnail Photo -->
					    					<div class="" id="thumb" style="height:100px;width:100px;"></div>
										<!-- Show Upload Thumbnail Photo -->
					    			</div>
					    			<div class="col-6">
					    				<!-- Show Upload Video File Name-->
					    					<div id="show-vid-name" class="border rounded text-center p-1" style="height:100px;width:100px;font-size:.8em"><p class="mt-4 text-muted">No Video File Uploaded</p></div>
					    				<!-- /Show Upload Video File Name-->
					    			</div>
					    		</div>
					    		<div class="row">
					    			<div class="col">
										<!-- Upload Thumbnail Photo -->
											<div class="custom-file mb-0">
											  	<input type="file" class="custom-file-input" id="thumbnailFile" name="thumbnailFile">
											  	<label class="custom-file-label" for="thumbnailFile">Thumbnail</label>
											</div>
											<div id="thumb_err" class="my-0 text-danger font-weight-bold" style="font-size:.8em"></div>
										<!-- Upload Thumbnail Photo -->
									</div>
					    			<div class="col">
							    		<!-- Upload Video File -->
								    		<div class="custom-file mb-2">
											  	<input type="file" class="custom-file-input vid_source" id="videoFile" name="videoFile">
											  	<label class="custom-file-label" for="videoFile"> Video</label>
												<div id="vid_err" class="my-0 text-danger font-weight-bold" style="font-size:.8em"></div>
											</div>
										<!-- /Upload Video File -->
									</div>
								</div>
							</div>
							<div class="text-center" id="step2-err"></div>
						</div>
						<hr class="my-2"> <!-- Page Divider -->
						<h6 class="text-gs">
							<?php if($userRow[0]['sUserType'] == 'group'){
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
					<!-- /Progress Bar for uploading Files -->

					<div class="text-center text-danger font-weight-bold" id="error-text" style="font-size:.8em"></div>
			      </div>
			    		
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

<!-- Youtube Embed Instruction Modal  style="max-height:200px;"-->
    <div class="modal fade mt-3" id="embedInstr" tabindex="-1" role="dialog" aria-labelledby="embedInstr" aria-hidden="true">
      <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <!-- Modal Title -->
                <div class="modal-header">
                    <h6 class="modal-title text-gs">Embed A Youtube Video</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

                <div class="modal-body">
                    <div class="form-group" style="font-size: 12px;">
                    	<ol>
                    		<li>Go to the Youtube page of the video to be embedded.</li>
                    		<li>Under the video click share.</li>
                    		<li>Click embed.</li>
                    		<li>From the box that appears, copy the HTML code.</li>
                    		<li>Paste the code in the input box provided here.</li>
                    	</ol>
                    </div>
                </div>
        </div>
      </div>
    </div>
<!-- /Youtube Embed Instruction Modal -->



<!-- Modal Display to add new Photos -->
	<div class="modal fade" id="addPhoto" tabindex="-1" role="dialog" aria-labelledby="addPhotoTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	    	<!-- Error Message Display -->
			    <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
			      	<p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
			    </div>
			<!-- /Error Message Display --> 

			<!-- Add New Photo Button -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Add New Photo</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Add New Photo Button -->

	      	<form action="fileUpload.php" method="POST" name="photoAdd" enctype="multipart/form-data" id="photoForm">
		      	<div class="modal-body">
			    	<div class="form-group">
			    		<label for="vidTalent">Upload Photo</label>
			    		<select class="custom-select form-control mb-2 targetedAlbum" id="photoAlbums" name="iAlbumID">
							<option value=''>Add To Existing Album</option>
						  	<?php
						  		foreach($albumList as $album => $alb_Name){
										echo '<option value="' . $album . '">'; 
												echo str_replace("_","/",$alb_Name); 
										echo '</option>';
								}
							?>
						</select>
						<input type="text" name="newAlbumName" class="form-control mb-2 targetedAlbum" id="newAlbumName" aria-describedby="newAlbumName" placeholder="Create New Album Name">
			    		<textarea class="form-control mb-2" id="photoCaption" name="caption" placeholder="Photo Caption" wrap="" rows="4" aria-label="With textarea"></textarea>

			    		<div class="row mb-2">
							<div class="col">
			    				<!-- Show Upload Thumbnail Photo -->
			    					<div id="photoThumb" style="height:100px;width:100px;"></div>
								<!-- Show Upload Thumbnail Photo -->
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col">
					    		<!-- Upload Video File -->
						    		<div class="custom-file mb-2">
									  	<input type="file" class="custom-file-input" id="photoFile" name="photoFile">
									  	<label class="custom-file-label" for="photoFile"> Photo</label>
									</div>
								<!-- /Upload Video File -->
							</div>
						</div>

						<!-- Error Message Display -->
						    <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
						      	<p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
						    </div>
						<!-- /Error Message Display --> 
						
					</div>


		      	</div>

		      	<!-- Javascript to Display thumbnail when profile img is selected by user -->
			      	<script>
			      		/************* Display thumbnail when profile img is selected by user *******************/
							function handleFileSelect2(evt) {
								var uploadType = $(this)[0]['name'];
								console.log(uploadType);
								/* FileList object */
									var files = evt.target.files; 

								/* Loop through the FileList and render image files as thumbnails. */
									for (var i = 0, f; f = files[i]; i++) {

										if(uploadType == 'photoFile'){
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
											 					document.getElementById('photoThumb').innerHTML = '';

											 				/* Insert new thumbnail */
											 					document.getElementById('photoThumb').insertBefore(span, null);
										 			}	
										 		}
										 	})(f);

										 	/* Read in the image file as a data URL. */
						      					reader.readAsDataURL(f);
									}
							}	
							/* Access Thumbnail FIle data */
								document.getElementById('photoFile').addEventListener('change', handleFileSelect2, false);
						/*********** END - Display thumbnail when profile img is selected by user ************/
			      	</script>
		        <!-- /Javascript to Display thumbnail when profile img is selected by user -->

		      	 <input type="hidden" name="contentMarker" value="photo">
		      	 <!-- Marker used to pick the correct upload page -->
		      	 	<?php //if($churchUserID){echo '<input type="hidden" name="churchPhotoMarker" value="1">';}?>
		      	 <!-- END - Marker used to pick the correct upload page -->
		      	<div class="modal-footer">
		        	<button type="submit" class="btn btn-gs" id="addPhotoButton">Add Photo</button>
		      	</div>
	      	</form>
	    </div>
	  </div>
	</div>
<!-- /Modal Display to add new Photos -->