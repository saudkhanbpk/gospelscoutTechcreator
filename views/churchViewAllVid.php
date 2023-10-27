<?php 
	/* View All Video Page */

	$page = 'aProfile';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');
	
	if($_GET['artistID']){
		/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$artistUserID = $_GET['artistID'];
			$talent = $_GET['tal'];
			$query1 = 'SELECT artistvideomaster.*, giftmaster.sGiftName, usermaster.sFirstName, usermaster.sLastName
					  FROM artistvideomaster
					  INNER JOIN giftmaster on artistvideomaster.videoTalentID = giftmaster.iGiftID
					  INNER JOIN usermaster on artistvideomaster.iLoginID = usermaster.iLoginID
					  WHERE artistvideomaster.iLoginID = ? AND giftmaster.sGiftName = ?
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

		// echo '<pre>';
		// var_dump($result);
	}
	elseif($_GET['churchID']){
		/* Query Database for church Video info based on the talent passed in $_GET['vid'] */
			$churchUserID = $_GET['churchID'];
			$ministry = $_GET['min'];
			$query1 = 'SELECT churchvideomaster.*, giftmaster1.sGiftName, usermaster.sChurchName
					  FROM churchvideomaster
					  INNER JOIN giftmaster1 on churchvideomaster.VideoMinistryID = giftmaster1.iGiftID
					  INNER JOIN usermaster on churchvideomaster.iLoginID = usermaster.iLoginID
					  WHERE churchvideomaster.iLoginID = ? AND giftmaster1.sGiftName = ?
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
		/* END - Query Database for church Video info based on the talent passed in $_GET['vid'] */

		// echo '<pre>';
		// var_dump($result);
	}
?>

<div class="container mt-4 px-5 viewAll-vid">
	<h4 class="text-capitalize text-gs text-center text-lg-left"><?php echo $result[0]['sChurchName']; ?></h4>
	<div class="container bg-white pt-3 px-5 viewAll-vid a-prof-shadow">
		<h5 class="" style="font-weight:bold;"><?php echo str_replace('_','/',$result[0]['sGiftName']); if($result[0]['sGiftName'] != 'Preaching_Teachings'){ echo ' Ministry';}?></h5>
		<div class="row">
			
			<?php 
				foreach($result as $eachVidArray){
			 ?>	
						<!-- Card Content -->
							<div class="card col-7 p-4 col-md-2 p-md-2 border-light mx-auto mx-md-0">
								<a href="churchVideoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&churchID=<?php echo $churchUserID;?>&min=<?php echo $eachVidArray['sGiftName'];?>">
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
				}
			?>
		</div><!-- /Talent Rows -->
	</div>
</div>



<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>