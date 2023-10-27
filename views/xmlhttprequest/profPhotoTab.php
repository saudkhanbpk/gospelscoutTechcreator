<?php 
	
	/************************************* Profile Photo Tab Content *****************************/

	/*
	
		1. query albummaster for all albums of current artist or church
		2. query gallerymaster for the pics that belong to each album
	
	
	*/

	/* Query Database for Artist's albums */
		$query = 'SELECT albummaster. iAlbumID, albummaster. sAlbumName
				  FROM albummaster
				  WHERE iLoginID = ?
				  ';
	 	try{
	 		$albums = $db->prepare($query);
	 		if($artistUserID){
		 		$albums->bindParam(1, $artistUserID);
		 	}
		 	elseif($churchUserID){
		 		$albums->bindParam(1, $churchUserID);
		 	}
	 		$albums->execute(); 
	 	}
	 	catch(Exception $e){
	 		echo $e; 
	 	}
	 	$albumResults = $albums->fetchAll(PDO::FETCH_ASSOC);
 	/* END - Query Database for Artist's albums */
 		//echo '<pre>';
 		//var_dump($albumResults);
 		
 		
 	/* Query Database for Artist's photos based on albumid*/
 		foreach($albumResults as $singleAlbum){
 			$query = 'SELECT *
			  	  FROM gallerymaster
		 	 	  WHERE iAlbumID = ?
				 ';
	 		try{
	 			$photos = $db->prepare($query);
	 			if($artistUserID){
		 			$photos->bindParam(1, $singleAlbum['iAlbumID']);
		 		}
		 		elseif($churchUserID){
		 			$photos->bindParam(1, $singleAlbum['iAlbumID']);
		 		}
	 			$photos->execute(); 
	 		}
	 		catch(Exception $e){
	 			echo $e; 
	 		}
	 		$results[$singleAlbum['sAlbumName']] = $photos->fetchAll(PDO::FETCH_ASSOC);
 		}
 		//$albumSectArray = results;
 		//echo '<pre>';
		//var_dump($results);	
 	/* END - Query Database for Artist's photos based on albumid*/
 	
	/* Query Database for Artist's photos */
		$query = 'SELECT *
				  FROM gallerymaster
				  WHERE iLoginID = ?
				  ';
	 	try{
	 		$photos = $db->prepare($query);
	 		if($artistUserID){
		 		$photos->bindParam(1, $artistUserID);
		 	}
		 	elseif($churchUserID){
		 		$photos->bindParam(1, $churchUserID);
		 	}
	 		$photos->execute(); 
	 	}
	 	catch(Exception $e){
	 		echo $e; 
	 	}
	 	//$results = $photos->fetchAll(PDO::FETCH_ASSOC);
 	/* END - Query Database for Artist's photos */
 	
 	/* Organize videos according to the talent they display */
		foreach($results as $eachPhoto){
			//$results[$eachPhoto['iAlbumID']] = $eachPhoto['albumName'];
		}
		//$albumArray = $results;
		//var_dump($albumArray);
		
		foreach($albumArray as $IDindex => $eachAlbum){
			foreach($results as $eachPhoto1){
				if($eachPhoto1['iAlbumID'] == $IDindex){
					//$albumSectArray[$IDindex][] = $eachPhoto1; 
				}
			}
		}
		//var_dump($albumSectArray); 
		
	/* END - Organize videos according to the talent they display */
?>

<!-- Photo Container Header -->
	<div class="container my-2 pl-0" id="photoHeader">
		<div class="row my-2">
			<div class="col-5 col-sm-4 text-truncate">
				<h6 class="text-gs">Photos</h6>
			</div>
			<div class="col-7 col-sm-8 text-right">
				<!-- <a class="mr-2" href="#" style="font-size:12px;">View Albums</a> -->
				<?php 
					if($artistUserID && $currentUserID > 0){
						if($currentUserID == $artistUserID || !isset($_GET['artist']) ){?>
							<a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#addPhoto" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">+ Photo</a>
				<?php 
						}
					}
					elseif($churchUserID && $currentUserID > 0){
						if($currentUserID == $churchUserID || !isset($_GET['church'])){?>
							<a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#addPhoto" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">+ Photo</a>
				<?php	}
					} ?>
			</div>
		</div>
	</div>


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
				    		<select class="custom-select form-control mb-2" id="photoAlbums" name="iAlbumID">
								<option value=''>Add To Existing Album</option>
							  	<?php
							  		foreach($albumResults as $album => $albumArray){
										echo '<option value="' . $albumArray['iAlbumID'] . '">'; 
												echo str_replace("_","/",$albumArray['sAlbumName']); 
										echo '</option>';
									}
								?>
							</select>
							<input type="text" name="newAlbumName" class="form-control mb-2" id="newAlbumName" aria-describedby="newAlbumName" placeholder="Create New Album Name">
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

					</div>
			      	</div>
			      	<!-- Progress Bar for uploading Files -->
			    	<div class="container">
			    		<h6>Upload Status</h6>
			    		<div class="progress mt-2">
						<div class="progress-bar progress-bar-striped progress-bar-animated serverImgUpload" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
					</div>
				</div>
				<!-- /Progress Bar for uploading Files -->

			      	<!-- Javascript to Display thumbnail when profile img is selected by user -->
				      	<script>
				      		/************* Display thumbnail when profile img is selected by user *******************/
								function handleFileSelect1(evt) {
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
									document.getElementById('photoFile').addEventListener('change', handleFileSelect1, false);
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
<!-- /Photo Container Header -->


<div class="album py-1 bg-light">
    <div class="container">
		<div class=" mt-0">
			<!-- Display proper message when an artist or church does not have any photos -->
				<?php 
					if(count($results) == 0) {
						if($currentUserID > 0){
							if($artistUserID && $currentUserID == $artistUserID || ($churchUserID && $currentUserID == $churchUserID) ){
				?>
								<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You Have Not Added Any Photos Yet!!!</h1></div>
				<?php
							}
							else{?>
								<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">No Photos Have Been Added Yet!!!</h1></div>
				<?php		}
						}
						else{
							if($_GET['artist']){
								echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">This Artist Has Not Added Any Photos Yet!!!</h1></div>';
							}
							elseif($_GET['church']){
								echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">This Church Has Not Added Any Photos Yet!!!</h1></div>';
							}
						}
					}
				?>
			<!-- END - Display proper message when an artist or church does not have any photos -->

			<!-- Display Photos sectioned by photo Album -->
				<?php 
					if(count($results) > 0) {
						foreach($results as $index => $indivAlbum){
						if(count($indivAlbum) > 0){
				?>
						<div class="container pl-0">
							<div class="row my-2">
								<div class="col-9 col-sm-8 pl-0">
									<a href="viewAllPhoto.php?albumID=<?php echo $indivAlbum[0]['iAlbumID'];?>&artistID=<?php echo $indivAlbum[0]['iLoginID']?>" style="color:rgba(90,90,90,1);"><h6 class="text-truncate"><?php echo $index;?></h6></a>
								</div>
							</div>
						</div>
						
						<?php
						
						?>
						 <div class="row mb-3">
					          	<?php 
					          	$photoMax = 1;
					          	foreach($indivAlbum as $indivPhoto){
					          		if($photoMax < 5){
						          		// if($currentUserID > 0 && $currentUserID == $artistUserID){
						          	?>
								           <!--  <div class="col-7 col-md-3  px-1 mx-auto mx-md-0">
								              <div class="card mb-2 p-0 box-shadow">
								                <img class="card-img-top" style="object-fit:cover; object-position:0,0;" src="<?php echo $indivPhoto['sGalleryImages'];?>" data-src=""  height="100px" alt="Card image cap"> 
								                <div class="card-body p-2">
								                  <p class="card-text m-0 card-text-size-gs" style="font-size:10px">Photo caption</p>
								                  <div class="d-flex justify-content-between align-items-center">
								                    <div class="btn-group">
								                      <button type="button" class="btn btn-sm btn-outline-secondary " style="font-size: 10px;padding:4px;">View</button>
								                      <button type="button" class="btn btn-sm btn-outline-secondary" style="font-size: 10px;padding:4px;">Edit</button>
								                    </div>
								                  </div>
								                  <div style="display:block">
								                    <small class="text-muted"> -->
								                    	<?php
								                    		/* Display Elapsed Time from date of upload */
												    			$from = date_create($indivPhoto['uploadDate']);
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
																// if($diff->y > 0){
																// 	echo $diff->y . ' Year' . ($diff->y > 1 ? 's' : '') . ' Ago'; 
																// }
																// elseif($diff->m > 0){
																// 	echo $diff->m . ' Month' . ($diff->m > 1 ? 's' : '') . ' Ago'; 
																// }
																// elseif($diff->d > 0){
																// 	echo $diff->d . ' Day' . ($diff->d > 1 ? 's' : '') . ' Ago'; 
																// }
																// elseif($diff->h > 0){
																// 	echo $diff->h . ' Hour' . ($diff->h > 1 ? 's' : '') . ' Ago'; 
																// }
																// elseif($diff->i > 0){
																// 	echo $diff->i . ' Min' . ($diff->i > 1 ? 's' : '') . ' Ago'; 
																// }
																// elseif($diff->s > 0){
																// 	echo $diff->s . ' Sec' . ($diff->s > 1 ? 's' : '') . ' Ago'; 
																// }
															/* END - Display Elapsed Time from date of upload */
														?>
								                  <!--   </small>
								                </div>
								                </div>
								              </div>
								            </div> -->
						            <?php 
						        		  // }
						            // 	  else{
						            ?>
						            		<div class="col-4 p-0 m-md-0 col-md-3 bg-info "style="border:1px solid rgba(216,216,216,1);">
						            			<!--<a href=""> -->
							            			<img class="card-img-top" style="object-fit:cover; object-position:0,0;" src="<?php echo $indivPhoto['sGalleryImages'];?>" data-src=""  height="100px" alt="Card image cap"> 
							            		<!--</a>-->
						            		</div>
						            <?php
						            	  // }
						            	  $photoMax += 1; 
						            	}
					            	}
					            ?>
					        </div>

				<?php 		//$counter++;
							}
						}
	  				}
	  			?>
  			<!-- END - Display Photos sectioned by photo Album -->
	    </div>
	</div>
</div>

