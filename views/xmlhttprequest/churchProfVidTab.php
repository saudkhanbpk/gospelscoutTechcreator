<?php 
	
	/************************************* Profile Video Tab Content *****************************/

	/* Query the database for the videos of the current artist */
		$query1 = 'SELECT churchvideomaster.*, giftmaster1.sGiftName
				  FROM churchvideomaster
				  INNER JOIN giftmaster1 on churchvideomaster.videoMinistryID = giftmaster1.iGiftID
				  WHERE churchvideomaster.iLoginID = ?
				';
		try{
			$vidArray = $db->prepare($query1);
			$vidArray->bindParam(1, $churchUserID);
			$vidArray->execute();
		}
		catch(Exception $e){
			echo $e; 
		}
		$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
		
	/* END - Query the database for the videos of the current artist */
	// echo '<pre>';
	// var_dump($result);
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
		// echo '<pre>';
		// var_dump($talSectArray);
	/* END - Organize videos according to the talent they display */
?>
<!-- ************************** Video Container Header ****************************** -->
	<div class="container my-2 pl-0" id="vidHeader">
		<div class="row">
			<div class="col">
				<h5 class="text-gs">Videos</h5>
			</div>
			<?php if($currentUserID > 0 && ($currentUserID == $_GET['church'] || !isset($_GET['artist']) ) ){?>
				<div class="col text-right">
					<a class="p-1 bg-gs text-white" data-toggle="modal" data-target="#addVideo" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Add New Videos</a>
				</div>
			<?php }?>
		</div>
	</div>

	<!-- /Modal Window -->
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
			      		<div class="form-group">
			      			<select class="custom-select form-control mb-2" id="vidTalent" name="VideoMinistryID">
								<option value=''>Choose Ministry</option>
							  	<?php foreach($ministryRow as $ministry){
									echo '<option value="' . $ministry['iGiftID'] . '">'; 
											echo str_replace("_","/",$ministry['sGiftName']); 
									echo '</option>';
								}?>
							</select>
			      		</div>
			      		<hr class="my-2"> <!-- Page Divider -->
			    		<div class="form-group">
			    			<label for="youtubeInput">Youtube Link</label>
						    <input type="text" name="youtubeLink" class="form-control" id="youtubeInput" aria-describedby="emailHelp" placeholder="Enter Youtube Link">
						    <small id="emailHelp" class="form-text text-muted">Save Time and Embed a Youtube Video Instead of Uploading.</small>
			    		</div>
			    		<h5 class="text-gs">OR</h5>
				    	<div class="form-group">
				    		<label for="vidTalent">Upload Video</label>
				    		<input class="form-control mb-2" type="text" id="vidName" name="videoName" placeholder="Video Title" style="width:">
				    		<textarea class="form-control mb-2" id="vidDescr" name="videoDescription" placeholder="Video Description" wrap="" rows="7" aria-label="With textarea"></textarea>

				    		<div class="row">
				    			<div class="col">
						    		<!-- Upload Video File -->
							    		<div class="custom-file mb-2">
										  	<input type="file" class="custom-file-input" id="videoFile" name="videoFile">
										  	<label class="custom-file-label" for="videoFile"> Video</label>
										</div>
									<!-- /Upload Video File -->
								</div>

								<div class="col">
									<!-- Upload Thumbnail Photo -->
										<div class="custom-file mb-2">
										  	<input type="file" class="custom-file-input" id="thumbnailFile" name="thumbnailFile">
										  	<label class="custom-file-label" for="thumbnailFile">Thumbnail</label>
										</div>
									<!-- Upload Thumbnail Photo -->
								</div>
							</div>
						</div>
			    	<!-- Progress Bar for uploading Files -->
			    		<!--<div class="progress">
							  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
							</div>
						-->
					<!-- /Progress Bar for uploading Files -->
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

<?php
	if(count($result) == 0){
		if($currentUserID > 0 && $currentUserID == $churchUserID){
			echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You Have Not Added Any Videos Yet!!!</h1></div>';
			//exit;
		}
		else{
			 echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">This Church Has Not Added Any Videos Yet!!!</h1></div>';
			// exit;
		}
	}
	else{
		foreach($talSectArray as $TalentName => $vidArrays) { ?>
		<!-- Talent Containers -->
		<div class="">
			<div class="row">
				<div class="col-6">
					<h5><?php echo str_replace('_','/',$TalentName); if($TalentName != 'Preaching_Teachings'){ echo ' Ministry';}?></h5>
				</div>
				<div class="col-6 text-right">
					<a class="anchor-styled" href="churchViewAllVid.php?min=<?php echo $TalentName;?>&churchID=<?php echo $churchUserID; ?>">View All</a>
				</div>
			</div>
			<!-- Card Rows -->
			<div class="row">
				
				<?php 
				$videoMax = 1;
				foreach($vidArrays as $eachVidArray){
						if($videoMax < 5){
				 ?>	
							<!-- Card Content -->
								<div class="card col-7 p-4 col-md-3 p-md-2 border-light mx-auto mx-md-0">
									<a href="churchVideoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&churchID=<?php echo $churchUserID;?>&min=<?php echo $TalentName; ?>">
										<div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
											<?php 	if($eachVidArray['videoType'] == 'youtube'){ ?>
														<div class="embed-responsive embed-responsive-1by1 m-0">
															<iframe  class="embed-responsive-item" src="<?php echo $eachVidArray['youtubeLink']; ?>" frameborder="0" allowfullscreen></iframe>
														</div>
											<?php
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
	}?>
