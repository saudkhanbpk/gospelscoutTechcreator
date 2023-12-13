<?php 
	
	/************************************* Profile Video Tab Content *****************************/
	if($userRow['sUserType'] == 'artist'){
		/* Query the database for the videos of the current artist */
			$query1 = 'SELECT artistvideomaster.*, giftmaster.sGiftName
					  FROM artistvideomaster
					  INNER JOIN giftmaster on artistvideomaster.videoTalentID = giftmaster.iGiftID
					  WHERE artistvideomaster.iLoginID = ?
					';
			try{
				$vidArray = $db->prepare($query1);
				$vidArray->bindParam(1, $artistUserID);
				$vidArray->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
		/* END - Query the database for the videos of the current artist */
	
		/* Organize videos according to the talent they display */
			foreach($result as $eachVid){
				$talentArray[] = $eachVid['sGiftName'];
			}
			$talentArray = array_unique($talentArray);
			
			foreach($talentArray as $eachTalent){
				foreach($result as $eachVid1){
					if($eachVid1['sGiftName'] == $eachTalent){
						$talSectArray[$eachTalent][] = $eachVid1; 
					}
				}
			}
		/* END - Organize videos according to the talent they display */
	}
	elseif($userRow['sUserType'] == 'group'){
		/* Query the database for the videos of the current artist */
			$query1 = 'SELECT artistvideomaster.*
					  FROM artistvideomaster
					  WHERE artistvideomaster.iLoginID = ?
					';
			try{
				$vidArray = $db->prepare($query1);
				$vidArray->bindParam(1, $artistUserID);
				$vidArray->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
		/* END - Query the database for the videos of the current artist */

		/* Organize videos according to the talent they display */
			foreach($result as $eachVid){
				$talentArray[] = $eachVid['sGiftName'];
			}
			$talentArray = array_unique($talentArray);
			
			foreach($talentArray as $eachTalent){
				foreach($result as $eachVid1){
					if($eachVid1['sGiftName'] == $eachTalent){
						$talSectArray[$eachTalent][] = $eachVid1; 
					}
				}
			}
		/* END - Organize videos according to the talent they display */
	}
?>
<!-- ************************** Video Container Header ****************************** -->
	<div class="container my-2 pl-0" id="vidHeader">
		<div class="row">
			<div class="col">
				<h5 class="text-gs">Videos</h5>
			</div>
			<?php if($currentUserID > 0 && ($currentUserID == $_GET['artist'] || !isset($_GET['artist']) ) ){?>
				<div class="col text-right">
					<a class="p-1 bg-gs text-white" data-toggle="modal" data-target="#addVideo" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Add New Videos</a>
				</div>
			<?php }?>
		</div>
	</div>

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
		    	<div class="container p-3 text-center mb-0 d-none" id="error-message"><p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text" style="border-radius:7px"></p></div>
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Add New Video</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form action="fileUpload.php" method="POST" name="videoAdd" id="videoAddID" enctype="multipart/form-data">
			      <div class="modal-body">
			      	<?php if($userRow['sUserType'] == 'artist'){?>
			      		<h6 class="text-gs">Step 1</h6>
			      		<div class="container">
				      		<div class="form-group">
				      			<select class="custom-select form-control mb-2" id="vidTalent" name="VideoTalentID">
									<option value=''>Choose Talent</option>
								  	<?php foreach($getTalents as $talent){
										echo '<option value="' . $talent['TalentID'] . '">'; 
												echo str_replace("_","/",$talent['talent']); 
										echo '</option>';
									}?>
								</select>
				      		</div>
				      	</div>
			      		<hr class="my-2"> <!-- Page Divider -->
			      	 <?php } ?>

			      		<h6 class="text-gs">
			      			<?php if($userRow['sUserType'] == 'group'){
		      						echo 'Step 1';
		      					}
		      					else{
		      						echo 'Step 2';
		      					}
			      			?> 
			      		</h6>
			      		<div class="container">
				    		<div class="form-group">
				    			<label for="youtubeInput">Embed Youtube Link</label>
							    <input type="text" name="youtubeLink" class="form-control" id="youtubeInput" aria-describedby="emailHelp" placeholder="Embed Youtube Link">
							    <!-- <small id="emailHelp" class="form-text text-muted">Save Time and Embed a Youtube Video Instead of Uploading.  <a href="#" data-toggle="modal" data-target="#embedInstr">How?</a></small> -->
							    <small id="emailHelp" class="form-text text-muted">Save Time and Embed a Youtube Video Instead of Uploading.  
							    	<a href="#" data-toggle="popover" data-html="true" data-trigger="focus" title="Embed a YouTube Video" data-content="<ol><li>Go to the Youtube page of the video to be embedded.</li>
			                    				<li>Under the video click share.</li>
			                    				<li>Click embed.</li>
			                    				<li>From the box that appears, copy the HTML code.</li>
			                    				<li>Paste the code in the input box provided here.</li></ol>">
			                    				How?
			                    			</a>
		                    			    </small>
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
							<?php if($userRow['sUserType'] == 'group'){
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
						<div class="progress-bar progress-bar-striped progress-bar-animated serverUpload" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
						</div>
					</div>

						 <!-- style="width: 75%" -->
					<!-- /Progress Bar for uploading Files -->
			      </div>
			      <!-- Javascript to Display thumbnail when profile img is selected by user -->
			      	<script>
			      		
			      		/******************************** Display thumbnail when video img is selected by user **************************************/
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
										      	if(currentFile.type.match('video.*')){
									 				/* Render Video Name */
										 				document.getElementById('show-vid-name').innerHTML = escape(currentFile.name);
									 			}	
									 			else{
									 				console.log('Please upload a video file.');
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

<!-- Youtube Embed Instruction Modal  style="max-height:200px;"-->
    <div class="modal fade mt-3" id="embedInstr" tabindex="-1" role="dialog" aria-labelledby="embedInstr" aria-hidden="true">
      <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <!-- Modal Title -->
                <div class="modal-header">
                    <h6 class="modal-title text-gs">Embed A Youtube Video</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
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

<?php
	if(count($result) == 0){
		if($currentUserID > 0 && $currentUserID == $artistUserID){
			echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You Have Not Added Any Videos Yet!!!</h1></div>';
			//exit;
		}
		else{
			 echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">This Artist Has Not Added Any Videos Yet!!!</h1></div>';
			// exit;
		}
	}
if($userRow['sUserType'] == 'artist'){
	foreach($talSectArray as $TalentName => $vidArrays) { ?>
	<!-- Talent Containers -->
	<div class="">
		<div class="row">
			<div class="col-6">
				<h5><?php echo str_replace('_','/',$TalentName);?></h5>
			</div>
			<div class="col-6 text-right">
				<a class="anchor-styled" href="viewAllVid.php?tal=<?php echo $TalentName;?>&artistID=<?php echo $artistUserID; ?>">View All</a>
			</div>
		</div>
		<!-- Card Rows -->
		<div class="row">
			
			<?php 
			$videoMax = 1;
			$yu = 0; 
			foreach($vidArrays as $eachVidArray){
					if($videoMax < 5){
						// echo '<pre>';
						// var_dump($eachVidArray['youtubeLink']);
			 ?>	
						<!-- Card Content -->
							<div class="card col-7 p-4 col-md-3 p-md-2 border-light mx-auto mx-md-0">
								<a href="videoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&artistID=<?php echo $artistUserID;?>&tal=<?php echo $TalentName; ?>">
									<div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
										<?php 		
												if($eachVidArray['videoType'] == 'youtube'){ 
													$yLink = $eachVidArray['youtubeLink'];
										?>
													<!-- <div class="embed-responsive embed-responsive-1by1 m-0" id="msg_url<?php echo $yu;?>">
														<iframe  class="embed-responsive-item" src="<?php echo $eachVidArray['youtubeLink']; ?>" frameborder="0" allowfullscreen></iframe> 
													</div> -->
													<img class="card-img-top artist-vid-img" id="msg_url<?php echo $yu;?>" src="" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
										
													<script language="javascript" type="text/javascript">
														$(function() {
															var ytl = '<?php echo $yLink;?>';
													        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
													        yti[1] = yti[1].replace('embed/', '');
													        // $("#msg_url<?php echo $yu;?>").html("<p><img src=\"https://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg\" class=\"img-responsive center-block\" /></p>");
															$("#msg_url<?php echo $yu;?>").attr('src',"https://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg");
														});
													</script> 
										<?php
													$yu++; 
												}
												else{
										?>
													<img class="card-img-top artist-vid-img" src="<?php if($eachVidArray['videoThumbnailPath'] ==''){echo '../img/gsStickerBig1.png';}else{echo $eachVidArray['videoThumbnailPath'];}?>" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
										<?php } ?>
									  
									</div>
								</a>
							  <div class="card-body pb-0 px-2">
							    <ul class="list-unstyled card-text-size-gs mb-0 ">
							    	<li class="text-truncate"><span class="d-inline-block"><?php if($eachVidArray['videoType'] == 'youtube'){echo 'Youtube Video';}else{echo $eachVidArray['videoName'];}?></span></li>
							    	<li class="profCards-text-color"><?php echo $eachVidArray['videoViews'];?> Views</li>
							    	<li class="profCards-text-color"><?php echo $eachVidArray['videoLikes'];?> Likes</li>
							    	<li class="profCards-text-color">
							    		<?php
							    			$from = date_create($eachVidArray['uploadDate']);
											$to = date_create();
											/*
												y - year
												m - month
												d - day 
												h - hour
												i - minute
												s - second
											*/
											$diff = date_diff($from, $to);

											/* Display the age of video from years down to seconds */
											if($diff->y > 0){
												echo $diff->y . ' Year' . ($diff->y > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->m > 0){
												echo $diff->m . ' Month' . ($diff->m > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->d > 0){
												echo $diff->d . ' Day' . ($diff->d > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->h > 0){
												echo $diff->h . ' Hour' . ($diff->h > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->i > 0){
												echo $diff->i . ' Min' . ($diff->i > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->s > 0){
												echo $diff->s . ' Sec' . ($diff->s > 1 ? 's' : '') . ' Ago'; 
											}
										?>
							    	</li>
							    </ul>
							  </div>
							</div>
						<!-- /Card Content -->
			<?php 	
						$videoMax += 1;	
					}
				}
			?>
		</div><!-- /Talent Rows -->
		<hr class="my-1"> <!-- Page Divider -->
	</div><!-- /Talent Containers -->
<?php }
}
elseif($userRow['sUserType'] == 'group'){
	if(count($result) > 0){
?>
	<!-- Talent Containers -->
	<div class="">
		<div class="row">
			<div class="col-6"></div>
			<div class="col-6 text-right">
				<a class="anchor-styled" href="viewAllVid.php?tal=group&artistID=<?php echo $artistUserID; ?>">View All</a>
			</div>
		</div>
		<!-- Card Rows -->
		<div class="row">
<?php
	$videoMax = 1;
	$yu = 0;
	foreach($result as $eachVidArray){
		if($videoMax < 15){
			// echo '<pre>';
			// var_dump($eachVidArray);
		?>
			<!-- Card Content -->
							<div class="card col-7 p-4 col-md-3 p-md-2 border-light mx-auto mx-md-0">
								<a href="videoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&artistID=<?php echo $artistUserID;?>&tal=group">
									<div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
										<?php 		
												if($eachVidArray['videoType'] == 'youtube'){ 
													$yLink = $eachVidArray['youtubeLink'];
										?>
													<!-- <div class="embed-responsive embed-responsive-1by1 m-0" id="msg_url<?php echo $yu;?>">
														<iframe  class="embed-responsive-item" src="<?php echo $eachVidArray['youtubeLink']; ?>" frameborder="0" allowfullscreen></iframe> 
													</div> -->
													<img class="card-img-top artist-vid-img" id="msg_url<?php echo $yu;?>" src="" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
										
													<script language="javascript" type="text/javascript">
														$(function() {
															var ytl = '<?php echo $yLink;?>';
													        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
													        yti[1] = yti[1].replace('embed/', '');
													        // $("#msg_url<?php echo $yu;?>").html("<p><img src=\"https://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg\" class=\"img-responsive center-block\" /></p>");
															$("#msg_url<?php echo $yu;?>").attr('src',"https://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg");
														});
													</script> 
										<?php
													$yu++; 
												}
												else{
										?>
													<img class="card-img-top artist-vid-img" src="<?php if($eachVidArray['videoThumbnailPath'] ==''){echo '../img/gsStickerBig1.png';}else{echo $eachVidArray['videoThumbnailPath'];}?>" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
										<?php } ?>
									  
									</div>
								</a>
							  <div class="card-body pb-0 px-2">
							    <ul class="list-unstyled card-text-size-gs mb-0 ">
							    	<li class="text-truncate"><span class="d-inline-block"><?php if($eachVidArray['videoType'] == 'youtube'){echo 'Youtube Video';}else{echo $eachVidArray['videoName'];}?></span></li>
							    	<li class="profCards-text-color"><?php echo $eachVidArray['videoViews'];?> Views</li>
							    	<li class="profCards-text-color"><?php echo $eachVidArray['videoLikes'];?> Likes</li>
							    	<li class="profCards-text-color">
							    		<?php
							    			$from = date_create($eachVidArray['uploadDate']);
											$to = date_create();
											/*
												y - year
												m - month
												d - day 
												h - hour
												i - minute
												s - second
											*/
											$diff = date_diff($from, $to);

											/* Display the age of video from years down to seconds */
											if($diff->y > 0){
												echo $diff->y . ' Year' . ($diff->y > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->m > 0){
												echo $diff->m . ' Month' . ($diff->m > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->d > 0){
												echo $diff->d . ' Day' . ($diff->d > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->h > 0){
												echo $diff->h . ' Hour' . ($diff->h > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->i > 0){
												echo $diff->i . ' Min' . ($diff->i > 1 ? 's' : '') . ' Ago'; 
											}
											elseif($diff->s > 0){
												echo $diff->s . ' Sec' . ($diff->s > 1 ? 's' : '') . ' Ago'; 
											}
										?>
							    	</li>
							    </ul>
							  </div>
							</div>
						<!-- /Card Content -->
		<?php
		}
		$videoMax += 1;
	}
?>
	</div>
</div>
<?php
	}
}
?>
