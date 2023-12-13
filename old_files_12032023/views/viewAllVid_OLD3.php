<?php 
	/* View All Video Page */

	$page = 'aProfile';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');



	if($_GET['tal'] == 'group'){
			/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$artistUserID = $_GET['artistID'];
			$query1 = 'SELECT artistvideomaster.*, usermaster.sGroupName
					  FROM artistvideomaster
					  INNER JOIN usermaster on artistvideomaster.iLoginID = usermaster.iLoginID
					  WHERE artistvideomaster.iLoginID = ? AND artistvideomaster.removedStatus = 0
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
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}
	elseif($_GET['artistID']){
		/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$artistUserID = $_GET['artistID'];
			$talent = trim($_GET['tal']);
			$query1 = 'SELECT artistvideomaster.*, giftmaster.sGiftName, usermaster.sFirstName, usermaster.sLastName
					  FROM artistvideomaster
					  INNER JOIN giftmaster on artistvideomaster.videoTalentID = giftmaster.iGiftID
					  INNER JOIN usermaster on artistvideomaster.iLoginID = usermaster.iLoginID
					  WHERE artistvideomaster.iLoginID = ? AND giftmaster.sGiftName = ? AND artistvideomaster.removedStatus = 0
					';
			try{
				$vidArray = $db->prepare($query1);
				$vidArray->bindParam(1, $artistUserID);
				$vidArray->bindParam(2, $talent);
				$vidArray->execute();//http://tsdr.uspto.gov/#caseNumber=87261032&caseSearchType=US_APPLICATION&caseType=DEFAULT&searchType=statusSearch
			}
			catch(Exception $e){
				echo $e; 
			}
			$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}
	elseif($_GET['churchID']){
		/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$churchUserID = $_GET['churchID'];
			$ministry = trim($_GET['tal']);
			$query1 = 'SELECT churchvideomaster.*, giftmaster1.sGiftName, usermaster.sChurchName
					  FROM churchvideomaster
					  INNER JOIN giftmaster1 on churchvideomaster.VideoMinistryID = giftmaster1.iGiftID
					  INNER JOIN usermaster on churchvideomaster.iLoginID = usermaster.iLoginID
					  WHERE churchvideomaster.iLoginID = ?  AND giftmaster1.sGiftName = ? AND churchvideomaster.removedStatus = 0
					';
			try{
				$vidArray = $db->prepare($query1);
				$vidArray->bindParam(1, $churchUserID);
				$vidArray->bindParam(2, $ministry); 
				$vidArray->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
			
			/*var_dump($result);
			exit;*/
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}

	/* if the results array is empty, redirect to the artist or church's page */
		if(count($result) == 0){
			if($_GET['artistID']){
				/* Re-direct to the intended artist's page */
					echo '<script>window.location = "'. URL . 'views/artistprofile.php?artist=' . $_GET['artistID'] . '";</script>';
			}
			elseif($_GET['churchID']){
				/* Re-direct to the intended church's page */
					echo '<script>window.location = "'. URL . 'views/churchprofile.php?church='. $_GET['churchID'] . '";</script>';
			}
			else{
				/* Re-direct to the site's index page */
					echo '<script>window.location = "'. URL . 'index.php";</script>';
			}
		}

?>

<div class="container mt-4 px-5 viewAll-vid">
	<a href="<?php if($_GET['artistID']){ echo URL . 'views/artistprofile.php?artist=' . $_GET['artistID'];}elseif($_GET['churchID']){echo URL . 'views/churchprofile.php?church=' . $_GET['churchID']; } ?>"class="text-gs"><h4 class="text-capitalize text-gs text-center text-lg-left"><?php if($_GET['tal'] == 'group'){echo $result[0]['sGroupName'];}elseif($_GET['artistID']){ echo $result[0]['sFirstName'] . ' ' . $result[0]['sLastName'];}elseif($_GET['churchID']){echo $result[0]['sChurchName'];} ?></h4></a>
	<div class="container bg-white pt-3 px-5 viewAll-vid a-prof-shadow">
		<h5 class="" style="font-weight:bold;"><?php if($_GET['tal'] != 'group'){echo str_replace('_','/',$result[0]['sGiftName']);}?></h5>
		<div class="row">
			
			<?php 
				$yu = 0;
				foreach($result as $eachVidArray){
			 ?>	
						<!-- Card Content -->
							<div class="card col-7 p-4 col-md-2 p-md-2 border-light mx-auto mx-md-0">
								<a href="videoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&<?php if($_GET['artistID']){echo 'artistID=' . $artistUserID;}elseif($_GET['churchID']){echo 'churchID=' . $churchUserID;}?>&tal=<?php echo trim($_GET['tal']); ?>">
									<div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
										<?php 	if($eachVidArray['videoType'] == 'youtube'){ 
													$yLink = $eachVidArray['youtubeLink'];
										?>
													<!-- <div class="embed-responsive embed-responsive-1by1 m-0">
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
							    	<?php 
							    		if($currentUserID != '' && ($currentUserID == $_GET['artistID'] || $currentUserID == $_GET['churchID'] || $currentUserType == 'admin')){
							    	?>
							    			<li><a href="" class="editVidSubmit" vidPath="<?php echo $eachVidArray['videoPath'];?>" vidThumbnail="<?php echo $eachVidArray['videoThumbnailPath'];?>" vidType="<?php echo $eachVidArray['videoType'];?>" vidID="<?php echo $eachVidArray['id'];?>" vidTitle="<?php echo $eachVidArray['videoName'];?>" vidDescr="<?php echo $eachVidArray['videoDescription'];?>" data-toggle="modal" data-target="#editVideo">Edit</a></li>
							    	<?php 
							    		}
							    	?>
							    	
							    	<!-- Have to initailize the popover functionality for it to work -->
										<script>
											// $(document).ready(function(){
											// 	console.log('test java');
											// 	$('[data-toggle="popover"]').popover();
											// });
										</script>
									<!-- /Have to initailize the popover functionality for it to work -->
							    </ul>
							  </div>
							</div>
						<!-- /Card Content -->
			<?php 	
				}
			?>
		</div><!-- /Talent Rows -->
	</div>
</div>

<!-- Modal Display - Edit video -->
	<!-- Styling for thumbnail previews for the video and Photo upload modals -->
		<style>
			.thumb {
				width: 100px;
				height: 100px;
				object-fit:cover; 
				object-position:0,0;
			}
			#photoThumb, #thumb {
				box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);
				background-size: 100px 100px;
				background-repeat:  no-repeat;
				background-position:  center;
				object-fit:cover; 
				object-position:0,0;
			}
		</style>
	<!-- Styling for thumbnail previews for the video and Photo upload modals -->

	<div class="modal fade" id="editVideo" tabindex="-1" role="dialog" aria-labelledby="editVideoTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Close Modal Window -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Edit This Video</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Close Modal Window -->
		    	<form method="post" action="viewAllVid.php" name="editVid" enctype="multipart/form-data">
			      	<div class="modal-body">
				    	<div class="form-group">
				    		<!-- <h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6> -->
				    		<!-- <p>Removing a talent from your profile will automatically remove any videos associated with that talent. </p> -->
				    			
				    			<input type="hidden" name="id" value="">
				    			<input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
				    			<input type="hidden" name="videoThumbnailPath">
				    			<input type="hidden" name="videoPath">
				    			<?php 
					      			if($currentUserType == 'admin'){
					      				if($_GET['churchID'] != ''){
					      					$curr_u_type = 'church';
					      				}
					      				elseif($_GET['artistID'] != ''){
					      					$curr_u_type = 'artist';
					      				}
					      				else{
					      					$curr_u_type = 'group';
					      				}

					      				/* pass the administrator's id */
					      					echo '<input type="hidden" name="adminID" value="'.$currentUserID.'">';
					      			}
					      			else{
					      				$curr_u_type = $currentUserType;
					      			}
					      		?>
					      		<input type="hidden" name="u_type" value="<?php echo $curr_u_type;?>">

				    			<div class="prepend-element d-none">
				    				<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="videoName">Replace current thumbnail photo</label> 
				    				<!-- Show Upload Thumbnail Photo -->
				    					<div class="mb-2" id="thumb" style="height:100px;width:100px;"></div>
									<!-- Show Upload Thumbnail Photo -->
				    				<div class="container px-0"><input type="file" id="videoThumbnailPath" name="videoThumbnailPath" value=""></div>
				    			</div>
				    			<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="videoName">Edit Video Title</label>
				    			<!-- <div class="container"> -->
					    			<input  class="form-control form-control-sm my-2" type="text" id="videoName" name="videoName" placeholder="Enter Video Title">
					    		<!-- </div> -->
				    			<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="videoDescription">Edit Video Description</label>
				    			<!-- <div class="container"> -->
					    			<textarea class="form-control form-control-sm my-2" type="text" id="videoDescription" name="videoDescription" rows="5" placeholder="Enter Video Description"></textarea>
					    		<!-- </div> -->
				    			<button type="submit" id="saveChanges" class="btn btn-gs btn-sm sectionEdit">Save Changes</button>
				    		
						</div>
			      	</div>
			      	
			      	<div class="modal-footer">
			      		<h6> To remove this video click the button below</h6>
			        	<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#removeVidWarning">Remove Video</button>
			      	</div>
		      	</form>
	    </div>
	  </div>
	</div>
<!-- /Modal Display to Edit vidoes -->

<!-- Modal Display - Video Removal Warning -->
	<div class="modal fade" id="removeVidWarning" tabindex="-1" role="dialog" aria-labelledby="removeVidWarning" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Exit Modal -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Remove Video</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Exit Modal -->

		      	<div class="modal-body">
			    	<div class="form-group">
			    		<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>
			    		<p>This will permenantly remove this video!!!</p>
			    		<?php if($currentUserType == 'admin'){?>
				    		<label for="vidTalent">Reason For Deletion</label>
							<textarea class="form-control mb-2" name="vidDelReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
							
							<!-- Display error message if admin fails to provide reason for deletion -->
							<div class="container d-none" id="err_mess">
								<div class="row">
									<div class="col">
										<p class="text-danger mb-0" style="font-size:14px;"></p>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
		      	</div>
		      	
		      	<div class="modal-footer">
		        	<button type="submit" id="removeVideo" u-type="<?php echo $curr_u_type;?>" class="btn btn-gs btn-sm sectionEdit" table="talentmaster" formId="talentRemove">Remove Video</button>
		      	</div>
	    </div>
	  </div>
	</div>
<!-- /Modal Display - Video Removal Warning -->

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
 // 	if (window.File && window.FileReader && window.FileList && window.Blob) {
	//   console.log('Great success! All the File APIs are supported.');
	// } else {
	//   alert('The File APIs are not fully supported in this browser.');
	// }

	/*************************************************** Edit Video Info ********************************************************/
		/*********************************************** Edit anchor actions ***********************************************/
			$('.editVidSubmit').click(function(event){
				/* Determine video type - Upload or YouTube */
					var videoType = $(this).attr('vidType');
					console.log('test');
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
					if(videoType == 'youtube'){
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
					var u_type = '<?php echo $currentUserType;?>'; //$(this).attr()
					var formCurrent  = document.forms.namedItem('editVid');
					var formNew  = new FormData(formCurrent);
					var currentThumbnailPath = $('input[name=videoThumbnailPath]').attr('id');
					var currentVideoPath = $('input[name=videoPath]').attr('id');

				/* Append need elements to form array */
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
							console.log(edVidFormSubmit.responseText);
							if(edVidFormSubmit.responseText == 1){
								location.reload(); 
								console.log('Changes Saved');
							}
						}
					}
					edVidFormSubmit.open('post', 'fileUpload.php');//vidEdit
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
	/************************************************ END - Edit Video Info *****************************************************/

</script>
