<?php 
	/* View All Photo Page */

	$page = 'aProfile';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
		
	if($_GET['albumID'] == ''){	
		echo '<script>window.location = "'. URL .'views/artistprofile.php";</script>';
	}
	else{
		$albumID = $_GET['albumID'];

		if($_GET['artistID']){
			$artistUserID = $_GET['artistID'];
		}
		elseif($_GET['churchID']){
			$churchUserID = $_GET['churchID'];
		}
		else{
			echo '<script>window.location = "'. URL .'views/artistprofile.php";</script>'; 
		}
	}
	
	/* Query Database for Album naem */
		$query = 'SELECT albummaster. sAlbumName
				  FROM albummaster
				  WHERE albummaster. iAlbumID = ?
				  ';
	 	try{
	 		$albums = $db->prepare($query);
			$albums->bindParam(1, $albumID);
	 		$albums->execute(); 
	 	}
	 	catch(Exception $e){
	 		echo $e; 
	 	}
	 	$albumName = $albums->fetch(PDO::FETCH_ASSOC);	
	/* END - Query Database for Album naem */
	
	/* Query Database for Artist's photos */
		$query = 'SELECT gallerymaster.*, usermaster.sFirstName, usermaster.sLastName
				  FROM gallerymaster
				  INNER JOIN usermaster on usermaster.iLoginID = gallerymaster.iLoginID
				  WHERE gallerymaster.iLoginID = ? AND iAlbumID = ?';
	 	try{
	 		$photos = $db->prepare($query);
	 		if($artistUserID){
		 		$photos->bindParam(1, $artistUserID);
		 	}
		 	elseif($churchUserID){
		 		$photos->bindParam(1, $churchUserID);
		 	}
		 	$photos->bindParam(2, $albumID);
	 		$photos->execute(); 
	 	}
	 	catch(Exception $e){
	 		echo $e; 
	 	}
	 	$results = $photos->fetchAll(PDO::FETCH_ASSOC);
	 	$albumSectArray = $results;
 	/* END - Query Database for Artist's photos */

 	/* Organize photos according to the album they display */
		/*foreach($results as $eachPhoto1){
			if($eachPhoto1['albumName'] == $eachAlbum){
				$albumSectArray[$eachAlbum][] = $eachPhoto1;
			}
		}
		echo '<pre>';
		var_dump($results);
		var_dump($albumSectArray);*/
	/* END - Organize photos according to the album they display */
?>

<div class="container mt-4 px-5 viewAll-vid">
	<a href="<?php echo URL . 'views/artistprofile.php?artist=' . $_GET['artistID']; ?>"class="text-gs"><h4 class="text-capitalize text-gs text-center text-lg-left"><?php echo $results[0]['sFirstName'] . ' ' . $results[0]['sLastName']; ?></h4></a>
	<div class="container bg-white pt-3 px-5 viewAll-vid a-prof-shadow">
		<div class="row">
			<ul style="list-style:none;">
				<li style="display:inline-block"><h5 id="albName" style="font-weight:bold;"><?php echo $albumName['sAlbumName'];?></h5></li>
				<?php 
					if($currentUserID && ($currentUserID == $artistUserID || $currentUserID == $churchUserID)){
				?>
						<li class="pl-1" style="display:inline-block;font-size:12px"><a href="" data-toggle="modal" data-target="#editTitle" id="editTitleTrigger">edit</a></li>
				<?php	
					}
				?>
			</ul>
		</div>
		
		<div class="row">
			<?php 
				if(count($results) > 0) {
					//foreach($albumSectArray as $index => $photos){
				          //	$photoMax = 1;
				          	foreach($albumSectArray as $indivPhoto){
				?>
					            <!-- Card Content -->
								<div class="card col-7 p-4 col-md-2 p-md-2 border-light mx-auto mx-md-0">
										<div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
											<a href="" class="viewPhoto" data-toggle="modal" data-target="#editVideo" photoCaption="<?php echo $indivPhoto['caption']; ?>" photoFile="<?php echo $indivPhoto['sGalleryImages'];?>" photoId="<?php echo $indivPhoto['iGalleryID'];?>">
						            			<img class="card-img-top" style="object-fit:cover; object-position:0,0;" src="<?php echo $indivPhoto['sGalleryImages'];?>" data-src=""  height="100px" alt="Card image cap"> 
						            		</a>
										</div>
								</div>
				<?php
					            	  $photoMax += 1; 
				            	}
	            			//}
	            	
				}
				else{
		            		/**** Relocate to artist profile page if there are no photos in the selected album ****/
	 					echo '<script>window.location = "'. URL .'views/artistprofile.php";</script>';
	 				/* END - Relocate to artist profile page if there are no photos in the selected album */
		            	}
		         ?>
		</div><!-- /Talent Rows -->
	</div>
</div>

<!-- Modal Display - Edit Photo -->
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
	    <div class="modal-content" style="background-color:rgba(0,0,0,.8)"> <!--style="background-color:rgba(0,0,0,.8)" -->
			<!-- Close Modal Window -->
			    <div class="modal-header" style="border:none">
			        <!-- <h5 class="modal-title" id="exampleModalLongTitle">Edit This Photo</h5> -->
			        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Close Modal Window object-fit:cover;-->
		    <!-- height="100px" card-img-top object-position:0,0;-->
		    <div class="container p-5" style="background-color:rgba(0,0,0,.8)">
		    	<div class="row ">
		    		<img class="img-fluid mx-auto" id="largeView" style=" max-height:400px;width:auto;object-fit:cover;object-position:0,0;" src="" data-src=""  alt="Card image cap"> 
		    	</div> 
		    	<hr class="mt-4"> <!-- Page Divider -->
		    	<div class="row">
		    		<?php 
		    			if($artistUserID == $currentUserID){
		    		?>	
		    				<div class="col">
		    				<form name="editPhoto" method="get" action="">
		    					<div class="container">
		    						<label class="mb-1" style="font-size:12px;font-weight:bold;color:rgba(139,139,139,1);" for="">Edit Photo Caption</label>
		    					</div>
		    					<!--<input type="text" class="form-control form-control-sm mb-2" name="sFirstName" placeholder="First Name" value="<?php echo $ablumName; ?>">-->	
		    					<input type="hidden" id="addPhotoId" name="iGalleryID" value="" photoID="">
							<div class="container">
								<textarea name="caption" class="form-control" style="font-size:12px" id="largeViewCaption" rows="5"></textarea>
								<button type="submit" class="btn btn-sm btn-gs mt-2" id="saveCaptionEdit">Save Edit</button>
							</div>	
							
		    				</form>
		    				<div class="container">
		    					<hr class="mt-4" style="background-color:rgba(139,139,139,1);"> <!-- Page Divider -->
		    					<a href="" class="text-danger" data-toggle="modal" data-target="#removePhotoWarning" id="deletePhoto">Delete Photo</a>
		    				</div>
		    				</div>
		    		<?php
		    			}
		    			else{	
		    		?>
		    				<div class="col">
		    					<div class="container">
		    						<label class="mb-1" style="font-size:12px;font-weight:bold;color:rgba(139,139,139,1);" for="">Photo Caption:</label>
		    						<p id="largeViewCaption" style="font-size:12px; font-weight:bold"></p>
		    					</div>
		    				</div>
		    		<?php
		    			}
		    		?>
		    	</div>        		
		    </div>	
	    </div>
	  </div>
	</div>
<!-- /Modal Display to Edit Photos -->

<!-- Modal Display - Photo Removal Warning -->
	<div class="modal fade" id="removePhotoWarning" tabindex="-1" role="dialog" aria-labelledby="removePhotoWarning" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Exit Modal -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Remove Photo</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Exit Modal -->

		      	<div class="modal-body">
			    	<div class="form-group">
			    		<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>
			    		<p>This will permenantly remove this photo!!!</p>
					</div>
		      	</div>
		      	
		      	<div class="modal-footer">
		        	<button type="submit" id="removePhoto"class="btn btn-gs btn-sm sectionEdit" table="talentmaster" formId="photoRemove">Remove Photo</button>
		      	</div>
	    </div>
	  </div>
	</div>
<!-- /Modal Display - Video Removal Warning -->

<!-- Modal Display - Album Title Edit -->
	<div class="modal fade" id="editTitle" tabindex="-1" role="dialog" aria-labelledby="editTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Exit Modal -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Edit Album Title</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    	<!-- /Exit Modal -->
		    	
			<form name="albumTitleEdit" method="post" id="albumTitleEdit" action="viewAllPhoto.php">
		      	<div class="modal-body">
			    	<div class="form-group">
			    		<input type="hidden" name="iAlbumID" value="<?php echo $albumID;?>">
			    		<input type="text" class="form-control" name="sAlbumName" value="<?php echo $albumName['sAlbumName'];?>">
			    		<button type="submit" id="saveAlbumTitle"class="btn btn-gs btn-sm sectionEdit mt-2" table="albummaster">Save Changes</button>
				</div>
		      	</div>
		      	
		      	<div class="modal-footer">
		        	<h6> Click to remove this album</h6>
			        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#removeVidWarning">Remove Album</button>
		      	</div>
		      	</form>
	    </div>
	  </div>
	</div>
<!-- /Modal Display - Album Title Edit -->

<!-- Modal Display - Video Removal Warning -->
	<div class="modal fade" id="removeVidWarning" tabindex="-1" role="dialog" aria-labelledby="removeVidWarning" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
			<!-- Exit Modal -->
			    <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLongTitle">Remove Album</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
		    <!-- /Exit Modal -->

		      	<div class="modal-body">
			    	<div class="form-group">
			    		<h6 class="text-danger" style="font-weight:bold" for="vidTalent">Warning!!!</h6>
			    		<p>Are you sure you want to permenantly remove this Album?!?!</p>
				</div>
		      	</div>
		      	
		      	<div class="modal-footer">
		        	<button type="submit" id="removeAlbum"class="btn btn-gs btn-sm sectionEdit" table="Albummaster" formId="talentRemove">Remove Album</button>
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

		/********************************************** Submit editing changes **********************************************/
			$('button[type=submit]').click(function(event){
				event.preventDefault();

				/* Define Variables */
					var formAction = $(this).attr('id');

					if(formAction == 'saveAlbumTitle'  || formAction == 'removeAlbum'){
						var formCurrent  = document.forms.namedItem('albumTitleEdit');
						var formNew  = new FormData(formCurrent);
						formNew.append('action', formAction);
					}
					else{
						/* Define Variables */
							var formCurrent  = document.forms.namedItem('editPhoto');
							var formNew  = new FormData(formCurrent);
							var currentPhotoPath = $('#largeView').attr('src');
						
						/* Append necessary elements to form array */
							formNew.append('action', formAction);
							formNew.append('contentMarker', 'photo');
							formNew.append('sGalleryImages', currentPhotoPath);
							formNew.append('','');
							if(formAction == 'removeVideo'){
								formNew.append('currentVideoPath', currentVideoPath);
							}
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
					edVidFormSubmit.open('post', 'fileUpload');//vidEdit
					edVidFormSubmit.send(formNew);
			})
		/******************************************* END - Submit editing changes ******************************************/
	/************************************************ END - Edit Video Info *****************************************************/

	/******************************************************** View Photo ********************************************************/
		$('.viewPhoto').click(function(event){
			var photoPath = $(this).attr('photoFile');
			var photoCaption = $(this).attr('photoCaption');
			var photoId = $(this).attr('photoId'); 
			console.log(photoId);
			$('#largeView').attr('src',photoPath);
			$('#largeViewCaption').html(photoCaption);
			$("#addPhotoId").val(photoId);
		});
	/***************************************************** END - View Photo *****************************************************/
	
	/**************************************************** Edit Album Title *****************************************************/
		/*$('#saveAlbumTitle').click(function(event){
			event.preventDefault(); 
			$albumTitleForm = document.forms.namedItem('albumTitleEdit');

			document.getElementById('albumTitleEdit').submit();
		
		});*/
	/************************************************* END - Edit Album Title **************************************************/
</script>
