<?php 
	/* Video Display Page */

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
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}
	else{
		if($_GET['artistID']){
			/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
				$artistUserID = $_GET['artistID'];
				$talent = $_GET['tal'];
				$query1 = 'SELECT artistvideomaster.*, giftmaster.sGiftName, usermaster.sFirstName, usermaster.sLastName
						  FROM artistvideomaster
						  INNER JOIN giftmaster on artistvideomaster.videoTalentID = giftmaster.iGiftID
						  INNER JOIN usermaster on artistvideomaster.iLoginID = usermaster.iLoginID
						  WHERE artistvideomaster.iLoginID = ?  AND giftmaster.sGiftName = ?
						';
				try{
					$vidArray = $db->prepare($query1);
					$vidArray->bindParam(1, $artistUserID);
					$vidArray->bindParam(2, $talent); 
					$vidArray->execute();
				}
				catch(Exception $e){
					echo $e; 
				}
				$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
			/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
		}
		elseif($_GET['churchID']){
			/*echo '<pre>';
			var_dump($_GET);*/
			/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
				$churchUserID = $_GET['churchID'];
				$ministry = $_GET['tal'];
				$query1 = 'SELECT churchvideomaster.*, giftmaster1.sGiftName, usermaster.sChurchName
						  FROM churchvideomaster
						  INNER JOIN giftmaster1 on churchvideomaster.VideoMinistryID = giftmaster1.iGiftID
						  INNER JOIN usermaster on churchvideomaster.iLoginID = usermaster.iLoginID
						  WHERE churchvideomaster.iLoginID = ?  AND giftmaster1.sGiftName = ?
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
	}

	/*echo '<pre>';
	var_dump($result);*/


	/* Loop through the result array and find the video matching the vid_id GET var */
		$vidId = $_GET['vid_id'];
		for($i=0;$i<count($result); $i++){
			if($result[$i]['id'] == $vidId){
				$vidIndex = $i; 
			}
		}
	/* END - Loop through the result array and find the video matching the vid_id GET var */

	$uploadDate = date_create($result[$vidIndex]["uploadDate"]);
	$uploadDate = date_format($uploadDate, "M d Y");  //Y-m-d
	$views = $result[$vidIndex]['videoViews'];
	$likes = $result[$vidIndex]['videoLikes'];
	$videoDescription = $result[$vidIndex]['videoDescription'];
	$videoLink = $result[$vidIndex]['videoPath'];
	$videoType = $result[$vidIndex]['videoType'];
	$youtubeLink = $result[$vidIndex]['youtubeLink'];
?>

<!-- Video.js javascript and css files -->
	<head>
	    <title>Video.js | HTML5 Video Player</title>
	    <link href="<?php echo URL;?>node_modules/video.js/dist/video-js.css" rel="stylesheet"> 
	    <script src="<?php echo URL;?>node_modules/video.js/dist/ie8/videojs-ie8.min.js"></script>
	    <script src="<?php echo URL;?>node_modules/video.js/dist/video.js"></script>
	    
	</head>
<!-- /Video.js javascript and css files -->

<div class="container mt-4 px-5 viewAll-vid">
	<a href="<?php if($_GET['artistID']){ echo URL . 'views/artistprofile.php?artist=' . $_GET['artistID'];}elseif($_GET['churchID']){echo URL . 'views/churchprofile.php?church=' . $_GET['churchID']; } ?>"class="text-gs"><h4 class="text-capitalize text-gs text-center text-lg-left"><?php if($_GET['tal'] == 'group'){echo $result[0]['sGroupName'];}elseif($_GET['artistID']){ echo $result[0]['sFirstName'] . ' ' . $result[0]['sLastName'];}elseif($_GET['churchID']){echo $result[0]['sChurchName'];} ?></h4></a>
	<div class="container pb-4 bg-white pt-3  viewAll-vid a-prof-shadow">
		<div class="container col-8 mt-0" style="max-width: 900px">
			<div class="row">
				<div class="col-sm-7 col-lg-8 mb-3 mb-lg-0 m-prof-sect" style="min-height:100px; ">

					<!-- Display the video being watched -->
						<div class="row" id="videoDisplay">
							<div class="col a-prof-shadow p-2 embed-responsive embed-responsive-16by9" style="min-height:100px;"> 
								<?php if($videoType == 'upload'){?>
									<video id="example_video_1"  class="video-js vjs-default-skin embed-responsive-item" poster="" data-setup='{"controls":true,"autoplay":true}'>
										<source src="<?php echo $videoLink;?>" type="video/mp4">
									    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="" target="_blank">supports HTML5 video</a></p>
									</video>
								<?php }
									  elseif($videoType == 'youtube'){
								?>
									  	<iframe  class="embed-responsive-item" src="<?php echo $youtubeLink; ?>" allow="autoplay; encrypted-media" frameborder="0" allowfullscreen></iframe>
								<?php
									  }
								?>
							</div>
						</div>
					<!-- END - Display the video being watched -->

					<!-- Display the video information - Video name, Video description, # of likes, # of views -->
						<div class="row mt-3" id="videoInfo">
							<div class="col a-prof-shadow pt-2" style="min-height:100px; max-height:300px">
								<h5><?php echo $result[$vidIndex]['videoName'];?></h5>
								<div class="row">
									<div class="col"><h6 style="font-size:12px;">Uploaded: <?php echo $uploadDate; ?></h6></div>
								</div>
								<div class="row">
									<div class="col"><h6><span id="updateViews"><?php echo $views; ?></span> view(s)</h6></div>
									<div class="col text-right"><a href="#" id="addLike"><h6><span id="updateLikes"><?php echo $likes;?></span> like(s)</h6></a></div>
								</div>

								<!-- Link to report innappropriate content uploaded to the page -->
									<div class="row">
										<div class="col text-right">
											<a data-toggle="modal" data-target="#addVideo" href="#"><h6 style="font-size:12px;">Report Video</h6></a>
										</div>
									</div>
								<!-- END - Link to report innappropriate content uploaded to the page -->

								<hr class="my-1"> <!-- Page Divider -->

								<!-- Hide/Show video description -->
									<div class="row">
										<div class="col">
											<a class="text-gs" data-toggle="collapse" href="#collapseExample"aria-expanded="false" aria-controls="collapseExample">
												<h6 style="font-size:14px;">Video Description:</h6>
											</a>
											<div class="collapse" id="collapseExample">
												<div class="px-2">
											    	<p style="font-size:12px;">
											    		<?php 
											    			if($videoDescription != ''){
											    				echo $videoDescription;
											    			}
											    			else{
											    				echo 'No Description';
											    			}
											    		?>
											    	</p> 
												</div>
											</div>
										</div>
									</div>
								<!-- END - Hide/Show video description -->
							</div>
						</div>
					<!-- END - Display the video information -->

					<!-- Display video comments -->
						<?php
							/* Query database for # of video Comments */
								$table = 'videocomments';
								$cond = 'videoID = ' . $vidId; 
								$commentCount = $obj->fetchNumOfRow($table,$cond)
							/* END - Query database for video Comments */
						?>
						<div class="row mt-3" id="videoComments">
							<div class="col  a-prof-shadow pt-2" style="min-height:100px;">
								<h6><?php echo $commentCount; ?> comments<?php if(empty($currentUserID)){echo ' - Login, leave a comment!';}?> </h6>
								<!--Edit table - videocomments
									COLUMNS: 
									1. id - primary index
									2. user id of commenter - iLoginID
									3. video id to which comment applies - videoID
									4. datetime - dCreatedDate; change to datetime type
									5. comment - sComment
								-->
								<?php if($currentUserID){?>
									<input type="hidden" name="loginTest" value="1" id="loginTest">
									<form method="post" enctype="multipart" action="" name="addComment" id="addCommentForm">
										<textarea class="form-control mb-2" name="sComment" placeholder="add comment..." wrap="" rows="2"></textarea>
										<input type="hidden" name="videoID" value="<?php echo $vidId;?>">
										<input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
										<input type="hidden" name="sProfileName" value="<?php echo $userInfo['sProfileName'];?>">
										<input type="hidden" name="sFirstName" value="<?php echo $userName;?>">
										<input type="hidden" name="comment" value="1">
										<div class="text-right">
											<button type="submit" class="btn btn-gs btn-sm" id="addComment">Comment</button>
										</div>
									</form>
								<?php }?>
								<hr class="my-3"><!-- Section Divider -->
								
								
									<!-- the User comments will go here -->
										<?php 
											/* Query database for video Comments */
												$commentQuery = 'SELECT videocomments.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName, usermaster.sUserType
																 FROM videocomments
																 INNER JOIN usermaster on videocomments.iLoginID = usermaster.iLoginID
																 WHERE videocomments.videoID = ?
																 ORDER BY videocomments.dateTime'; 
												try{
													$getComments = $db->prepare($commentQuery);
													$getComments->bindParam(1, $vidId);
													$getComments->execute(); 
												}
												catch(Exception $e){
													echo $e; 
												}
												$allComments = $getComments->fetchAll(PDO::FETCH_ASSOC);
											/* END - Query database for video Comments */
										?>
										<div id="showComments">
											<?php foreach($allComments as $commentThread){ ?>
												<div class="row px-3" id="userComm_<?php echo $commentThread['iCommentID'];?>">
													<div class="media mb-3" style="min-width:98%; max-width:98%;">
													  	<img class="mr-3" src="<?php if($commentThread['sUserType'] == 'artist' || $commentThread['sUserType'] == 'group'){ echo URL . 'upload/artist/' . $commentThread['sProfileName'];}elseif($commentThread['sUserType'] == 'church'){echo URL . 'upload/church/' . $commentThread['sProfileName'];}?> " width="40px" height="40px" alt="image">
													  	<div class="media-body " >
													  		<div class="container m-0">
													  			<div class="row">
													  				<div class="col-6 p-0">
																    	<h6 class="mt-0"><?php echo $commentThread['sFirstName']?>  
																    		<span style="font-size:10px; color:rgba(170,170,170,1)">
																    			<?php
																	    			$from = date_create($commentThread['dateTime']);
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
																    		</span>
																    	</h6>
																    </div>
																    <div class="col-6 text-right" style="font-size:10px;font-weight:bold">
																    	<?php if($commentThread['iLoginID'] ==  $currentUserID){?>
																    		<a href="#" class="text-gs removeComment" removeComm="<?php echo $commentThread['iCommentID']; ?>">Remove</a>
																    	<?php } ?>
																    </div>
															    </div>
													    	</div>
													    	<p style="font-size:12px;" class="mb-0">
													   		  <!-- User Comments Go here -->
													   		  <?php echo $commentThread['sComment'];?>
													   		</p>
													   		<?php
																/* Query database for # of Comment replies */
																	$table1 = 'videocommentreplies';
																	$cond1 = 'videoID = ' . $vidId . ' AND iReplyTo = ' . $commentThread['iCommentID']; 
																	$replyCount = $obj->fetchNumOfRow($table1,$cond1);
																/* END - Query database for video Comments */
															?>

															<div class="container" style="width:90%;">
																<div class="row">
																	<?php if($currentUserID){?>
																	<div class="col-3 col-lg-2 pl-0">
																		<!--  Reply to user Comment  -->
																			<a href="#" iReplyTo="<?php echo $commentThread['iCommentID'];?>" class="text-gs showReplyForm" style="font-size:10px;">reply</a>
																		<!-- END - Reply to user Comment --> 
																	</div>
																	<?php } ?>
																	<div class="col-9 pl-0">
																		<?php
																			/* If Comment Replies exist, Display in nested media ogbject */
																		 		if($replyCount > 0){
																		 			echo '<a href="#" id="' . $vidId . '" commentId="' . $commentThread['iCommentID'] . '" class="text-gs mt-0 getReplies" style="font-size:10px;">Show Replies(' . $replyCount . ')</a>';
																		 		} 
																		 	/* END - If Comment Replies exist, Display in nested media ogbject */
																		?>
																	</div>
																</div>

																<div class="row d-none" id="<?php echo $commentThread['iCommentID'];?>">
																	<form method="post" class="" style="width:100%" enctype="multipart" action="" name="<?php echo $commentThread['iCommentID'];?>" id="addReplyForm<?php echo $commentThread['iCommentID'];?>">
																		<textarea class="form-control mb-2" name="sComment" placeholder="add comment..." wrap="" rows="1" style="font-size: 12px;"></textarea>
																		<input type="hidden" name="videoID" value="<?php echo $vidId;?>">
																		<input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
																		<input type="hidden" name="iReplyTo" value="<?php echo $commentThread['iCommentID'];?>">
																		<input type="hidden" name="sProfileName" value="<?php echo $userInfo['sProfileName'];?>">
																		<input type="hidden" name="sFirstName" value="<?php echo $userName;?>">
																		<input type="hidden" name="replyType" value="artist">
																		<div class="text-right">
																			<button type="button" class="btn btn-sm btn-cancel cancelReply" value="<?php echo $commentThread['iCommentID'];?>" id="cancel<?php echo $commentThread['iCommentID'];?>" style="">Cancel</button>
																			<button type="submit" class="btn btn-gs btn-sm addReply" value="<?php echo $commentThread['iCommentID'];?>">Reply</button>
																		</div>
																	</form>
																</div>

															</div>															
															<div id="commentReplies<?php echo $commentThread['iCommentID'];?>"><!-- User Replies Go Here --></div>
													 	</div>
													</div>
												</div>	
											<?php }?>
										</div>
									<!-- /the User comments will go here -->
								
							</div>
						</div>
					<!-- END - Display video comments -->

				</div>

				<!-- Display Artists other videos of the same talent -->
					<div class="col-sm-7 col-lg-4 m-prof-sect" id="content-display" style="min-height: 100px;">
						<div class="bg-white p-2 a-prof-shadow" style="min-height:600px">
							<h6>more videos: </h6>
							<div class="container mt-4 px-5 viewAll-vid">
								<div class="row">
									<?php 
										$yu = 0;
										foreach($result as $eachVidArray){
									 ?>	
										<!-- Card Content -->
											<div class="card col-12 p-md-2 border-light mx-auto mx-md-0">
												<a class="m-0 bg-info" href="videoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&<?php if($_GET['artistID']){echo 'artistID=' . $artistUserID;}elseif($_GET['churchID']){echo 'churchID=' . $churchUserID;}?>&tal=<?php echo $eachVidArray['sGiftName'];?>">
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
											  <div class="card-body pb-1 px-2 m-0 pt-0"  style="border-bottom:1px solid rgba(0,0,0,.2);">
											    <ul class="list-unstyled card-text-size-gs mb-0 ">
											    	<li class="text-truncate"><span class="d-inline-block"><?php if($eachVidArray['videoType'] == 'youtube'){echo 'Youtube Video';}else{echo $eachVidArray['videoName'];}?></span></li>
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
									?>
								</div><!-- /Talent Rows -->
							</div>
						</div>
						<hr class="my-1"><!-- Section Divider -->
					</div>
				<!-- END - Display Artists other videos of the same talent -->
			</div>
		</div>

		</div>
	</div>
</div>

<!-- Report Video - Modal Window -->
	<div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="addVideoTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	    	<div class="container p-3 text-center mb-0 d-none" id="error-message"><p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text" style="border-radius:7px"></p></div>
	      	<div class="modal-header">
	        	<h5 class="modal-title text-gs" id="exampleModalLongTitle">Report This Video</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         	 	<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div id="reportStatus">
		      	<form action="" method="POST" name="reportVideo" id="reportVideo" enctype="multipart/form-data">
			      	<div class="modal-body pl-5">
			      		<?php 
			      			/* Reasons for Reporting a Video */
			      				$reportReasons = array(
			      										'Video Content is Innaproppriate',
			      										'Video Content is Offensive',
			      										'Video Content Does Not Belong To Artist',
			      										'Other:'
			      									);
			      				$n = 0;
			      				foreach($reportReasons as $reasons){
			      		?>
			      					<div class="custom-control custom-checkbox my-1">
										<input type="radio" class="custom-control-input hideTextBox" id="customCheck<?php echo $n;?>" name="reportReason" value="<?php echo $reasons; ?>">
									  	<label class="custom-control-label" for="customCheck<?php echo $n;?>"><?php echo $reasons; ?></label>
									  	<?php if($reasons == 'Other:'){?>
									  		<textarea id="otherReasons" class="form-control mb-2 d-none" placeholder="Please Explain..." wrap="" rows="2" name="otherReasons"></textarea>
									  	<?php }?>
									</div>
			      		<?php 
			      					$n++;
			      				}
			      		?>
			      	</div>
			     	<input type="hidden" name="artistId" value="<?php echo $_GET['artistID'];?>">
			     	<input type="hidden" name="vidId" value="<?php echo $_GET['vid_id'];?>">
			      	<input type="hidden" name="reporterId" value="<?php echo $currentUserID;?>">
			      	<div class="modal-footer">
			        	<button type="submit" class="btn btn-gs" id="reportVid">Report Video</button>
			      	</div>
		      	</form>
	      	</div>
	    </div>
	  </div>
	</div>
<!-- /Report Video - Modal Window -->

<!-- Make video ID accessible to the javascript -->
	<input type="hidden" name="vidID" value="<?php echo $vidId;?>">
	
<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo URL;?>views/testJS.js"></script>
<script>
	/* Update Number of Views when page loads */
		var vidID = $('input[name=vidID]').val(); 
		var viewsUpdate = new XMLHttpRequest(); 
		viewsUpdate.onreadystatechange = function(){
			if(viewsUpdate.status == 200 && viewsUpdate.readyState == 4){
				document.getElementById('updateViews').innerHTML = viewsUpdate.responseText; 
			}
		}
		viewsUpdate.open('GET', 'vidDispDBupdate.php?vidID='+vidID+'&views=1');
		viewsUpdate.send(); 
	/* END - Update Numbe of Views when page loads */

	/* Like-button functionaility */
		$('#addLike').click(function(event){
			event.preventDefault(); 

			var vidID = $('input[name=vidID]').val(); 
			var addLike = new XMLHttpRequest(); 
			addLike.onreadystatechange = function(){
				if(addLike.status == 200 && addLike.readyState == 4){
					document.getElementById('updateLikes').innerHTML = addLike.responseText;
				}
			}
			addLike.open('GET', 'vidDispDBupdate.php?vidID='+vidID+'&likes=1');
			addLike.send(); 
		});
	/* END - Like-button functionaility */

	/* Report Video For Innappropriate Content */
		$('.hideTextBox').click(function(event){
			/* Initially hide and reset the text box when the radio buttons are clicked */
				$('#otherReasons').addClass('d-none');
				$('#otherReasons').val(function() {
			        return this.defaultValue;
			    });
			/* END - Initially hide and reset the text box when the radio buttons are clicked */

			/* If the "Other:" radio buttion is clicked, show the text box */
				if($(this).val() == 'Other:'){
					// console.log('other was clicked');
					$('#otherReasons').removeClass('d-none');
				}
			/* END - If the "Other:" radio buttion is clicked, show the text box */
		});

		var reportForm = document.forms.namedItem("reportVideo");
		reportForm.addEventListener('submit', function(event){
			var reportVidForm = new FormData(reportForm); 
			reportVidForm.append('report', 1);

			var badVid = new XMLHttpRequest(); 
			badVid.onreadystatechange = function(){
				if(badVid.status == 200 && badVid.readyState == 4){
					// console.log(badVid.responseText);
					if(badVid.responseText == ''){
						// console.log('Video Report was Submitted!!!');
						document.getElementById('reportVideo').reset(); 
						$('#reportStatus').addClass('afterVidReport');
						document.getElementById('reportStatus').innerHTML = '<h5>Video Report was Submitted!!!</h5><br><p>Thank You for your help.</p>';
					}
					else{
						// console.log('Video Report was not submitted!!!');
						document.getElementById('reportVideo').reset();
						document.getElementById('reportStatus').innerHTML = 'Video Report was not submitted!!!'; 
					}
				}
			}
			badVid.open('POST', 'vidDispDBupdate.php');
			badVid.send(reportVidForm);

			event.preventDefault(); 
		});
	/* END - Report Video For Innappropriate Content */

	/* Add Video Comments */
		if($('input[name=loginTest]').val() == 1){/*if user is logged in execute this section */
			var commentForm = document.forms.namedItem("addComment");
			commentForm.addEventListener('submit', function(event){
				var commentFormData = new FormData(commentForm); 
				// commentFormData.append('comment', 1);
				// console.log(commentFormData);
				var data = {}
				
				/* For older browsers that don't support all the FormData Methods */
					var x = document.getElementById("addCommentForm").elements.length - 1;
					// console.log(x);
					 for(var f=0; f<x; f++){
					 	comKey = document.getElementById("addCommentForm").elements[f].name;
					 	comVal = document.getElementById("addCommentForm").elements[f].value;
					 	// console.log(f+': '+comKey+' = '+comVal);
					 	data[comKey] = comVal;
					 }
					 // console.log(data);
				/* END - For older browsers that don't support all the FormData Methods */

				/* Using FormData and its methods is a great solution for browsers that are compatible such as chrome */
					// for (var key of commentFormData.keys()) {
					//    console.log('key: '+key+' = '+commentFormData.get(key));
					//    data[key] = commentFormData.get(key);
					// }
					// var key; 
					// for( key in commentFormData.keys()){
					// 	console.log('key: '+key+' = '+commentFormData.get(key));
					// }
				/* END - Using FormData and its methods is a great solution for browsers that are compatible such as chrome */
				
				function dataObj(response){
					data['iCommentID'] = response; 
					data['replyType'] = '<?php echo $currentUserType;?>'; 
					return data; 
				}

				var sendComment = new XMLHttpRequest();
				sendComment.onreadystatechange = function(){
					if(sendComment.status == 200 && sendComment.readyState == 4){
						dObject = dataObj(sendComment.responseText);
						AppendFunct(dObject);
						// console.log(sendComment.responseText);
					}
				}
				sendComment.open('POST', 'vidDispDBupdate.php');
				sendComment.send(commentFormData);

				document.getElementById('addCommentForm').reset(); 
				event.preventDefault(); 
			});
		}
	/* End - Add Video Comments */

	/* Get Video Comment replies */
		$('.getReplies').click(function(event){
			event.preventDefault(); 

			var commId = $(this).attr('commentId');
			var vidId = $(this).attr('id');

			var getReplies = new XMLHttpRequest(); 
			getReplies.onreadystatechange = function(){
				if(getReplies.status ==200 && getReplies.readyState == 4){
					// document.getElementById('commentReplies'+commId).innerHTML = getReplies.responseText;
					// console.log(getReplies.responseText);
					var text = getReplies.responseText;
					/* Define Variables from returned xml values */	
						var parser = new DOMParser();
						var xmlDoc = parser.parseFromString(text,"text/xml");
						// var loginid = xmlDoc.getElementsByTagName('reply'); 
						
					/* Create a data object to hold the comment reply data to be passed to the jS function */
						var i = 0;
						var replyData = {}
						var currentUser = $('input[name=reporterId]').val();
						// console.log('this is current user id: '+currentUser);
						while(xmlDoc.getElementsByTagName('reply')[i]){
							replyData[i] = { 
								'icommentId' : xmlDoc.getElementsByTagName('iCommentID')[i].childNodes[0].nodeValue,
								'sComment' : xmlDoc.getElementsByTagName('sComment')[i].childNodes[0].nodeValue,
								'iReplyTo': xmlDoc.getElementsByTagName('iReplyTo')[i].childNodes[0].nodeValue,
								'iLoginID' : xmlDoc.getElementsByTagName('iLoginID')[i].childNodes[0].nodeValue,
								'dateTime' : xmlDoc.getElementsByTagName('dateTime')[i].childNodes[0].nodeValue ,
								'sProfileName' : xmlDoc.getElementsByTagName('sProfileName')[i].childNodes[0].nodeValue,
								'sFirstName' : xmlDoc.getElementsByTagName('sFirstName')[i].childNodes[0].nodeValue,
								'currentUser' : currentUser,
								'usertype' : 'artist'
							}
							i++; 
						}
						// console.log(replyData);
						AppendReply(replyData);
					/* END - Create a data object to hold the comment reply data to be passed to the jS function */
				}
			}
			getReplies.open('GET', 'vidDispDBupdate.php?getComments=1&repliesTo='+commId+'&vidId='+vidId);
			getReplies.send();
		});
	/* GEt Video Comments */

	/* Show/hide Comment Reply form */
		$('.showReplyForm').click(function(event){
			event.preventDefault(); 

			var commId = $(this).attr('iReplyTo');
			$('#'+commId).removeClass('d-none');
		});

		$('.cancelReply').click(function(event){
			event.preventDefault(); 
			var commId = $(this).val();
			document.getElementById('addReplyForm'+commId).reset(); 
			$('#'+commId).addClass('d-none');
		});
	/* END - Show/hide Comment Reply form */

	/* Send Comment Replies to the Database */
		$('.addReply').click(function(event){
		 	event.preventDefault();
			var commID = $(this).val();
			
			var formId = $(this).val();
			var replyForm = document.forms.namedItem(formId);
			var replyData = new FormData(replyForm); 

			var data = {}
			/* For older browsers that don't support all the FormData Methods */
				var x = document.forms.namedItem(formId).length - 2;
				for(var f=0; f<x; f++){
				 	comKey = replyForm.elements[f].name;
				 	comVal = replyForm.elements[f].value;
				 	// console.log(f+': '+comKey+' = '+comVal);
				 	data[comKey] = comVal;
				}
				 // console.log(data);
			/* END - For older browsers that don't support all the FormData Methods */

			// for (var key of replyData.keys()) {
			// 	   console.log('key: '+key+' = '+replyData.get(key));
			// 	   data[key] = replyData.get(key);
			// }
			function dataObj(response){
				data['iCommentID'] = response; 
				data['usertype'] = 'artist';
				return data; 
			}
			
			var sendReply = new XMLHttpRequest();
			sendReply.onreadystatechange = function(){
				if(sendReply.status == 200 && sendReply.readyState == 4){
					// $("#commentReplies"+commID).append(sendReply.responseText);
					
					if(sendReply.responseText){
						// console.log(sendReply.responseText);
						newData = dataObj(sendReply.responseText);
						// console.log(data);
						AppendNewReply(newData);
					}
				}
			}
			sendReply.open('POST', 'vidDispDBupdate.php');
			sendReply.send(replyData);
			document.getElementById('addReplyForm'+formId).reset(); 
		});
	/* END -  Send Comment Replies to the Database */

	/* Remove Comment */
		$('.removeComment').click(function(event){
		 	event.preventDefault();

		 	var comID = $(this).attr('removeComm');
		 
		 	var removeComment = new XMLHttpRequest();
		 	removeComment.onreadystatechange = function(){
		 		if(removeComment.readyState == 4 && removeComment.status == 200){
		 			if(removeComment.responseText == 'deleted'){
		 				$('#userComm_'+comID).hide();
		 			}
		 		}
		 	}
		 	removeComment.open('GET', 'vidDispDBupdate.php?deleteComment=artist&iCommentID='+comID);
		 	removeComment.send(); 
		 });
	/* END - Remove Comment */
</script>