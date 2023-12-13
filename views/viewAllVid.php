<?php 
	/* View All Video Page */

	$page = 'aProfile';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	$emptyArray = array();
	/* Usertype associated with the u_id */
		$columnsArray = array('sUserType');
		$paramArray['iLoginID']['='] = trim( $_GET['u_id'] );
		$get_U_type = pdoQuery('loginmaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
	/* Include the Modals */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/fetchVids.php'); 
		
	/* if the results array is empty, redirect to the artist or church's page */
		if(count($result) == 0){
			if($get_U_type['sUserType'] == 'artist'){
				/* Re-direct to the intended artist's page */
					echo '<script>window.location = "'. URL . 'views/artistprofile.php?artist=' . $_GET['u_id'] . '";</script>';
			}
			elseif($get_U_type['sUserType'] == 'church'){
				/* Re-direct to the intended church's page */
					echo '<script>window.location = "'. URL . 'views/churchprofile.php?church='. $_GET['u_id'] . '";</script>';
			}
			else{
				/* Re-direct to the site's index page */
					echo '<script>window.location = "'. URL . 'index.php";</script>';
			}
		}
?>

<div class="container px-0 px-md-5 viewAll-vid" style="margin-top:100px;>
	<a href="<?php if($get_U_type['sUserType'] == 'artist'){ echo URL . 'views/artistprofile.php?artist=' . $_GET['u_id'];}elseif($get_U_type['sUserType'] == 'church'){echo URL . 'views/churchprofile.php?church=' . $_GET['u_id']; } ?>"class="text-gs bg-danger"><h4 class="text-capitalize text-gs text-center text-lg-left"><?php if($get_U_type['sUserType'] == 'group'){echo $result[0]['sGroupName'];}elseif($get_U_type['sUserType'] == 'artist'){ echo $result[0]['sFirstName'] . ' ' . $result[0]['sLastName'];}elseif($get_U_type['sUserType'] == 'church'){echo $result[0]['sChurchName'];} ?></h4></a>
	<div class="container bg-white pt-3 px-0 px-md-5 viewAll-vid a-prof-shadow">
		<h5 class="ml-2" style="font-weight:bold;"><?php if($_GET['tal'] != 'group'){echo str_replace('_','/',$result[0]['sGiftName']);}?></h5>
		<div class="row px-2 px-md-0 mx-0">
			
			<?php 
				$yu = 0;
				foreach($result as $eachVidArray){
			 ?>	
					
					<div class="col-12 col-md-3 px-0 px-md-1 my-1 my-md-0">
						<div class="container">
							<div class="row">
								<div class="col-6 col-md-12 p-0">
									<a href="videoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&u_id=<?php echo trim( $_GET['u_id'] );?>&tal=<?php echo trim($_GET['tal']); ?>">
										<div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
											<?php 	if($eachVidArray['videoType'] == 'youtube'){ 
														$yLink = $eachVidArray['youtubeLink'];
											?>
														<img class="card-img-top artist-vid-img" id="msg_url<?php echo $yu;?>" src="" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
											
														<script language="javascript" type="text/javascript">
															$(function() {
																var ytl = '<?php echo $yLink;?>';
														        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
														        yti[1] = yti[1].replace('embed/', '');
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
								</div>
								<div class="col-6 col-md-12 pl-2 pl-md-0">
									<p class="m-0" style="font-size:.8em;">
										<span class="d-inline-block"><?php if($eachVidArray['videoType'] == 'youtube'){echo 'Youtube Video';}else{echo $eachVidArray['videoName'];}?></span>
									</p>
									<p class="m-0 text-muted" style="font-size:.7em;">
										<?php echo $eachVidArray['videoViews'];?> Views ~ <?php echo ageFuntion($eachVidArray['uploadDate']);?>
									</p>
									<?php if($currentUserID != '' && ($currentUserID == $_GET['u_id'] || $currentUserID == $_GET['u_id'] || $currentUserType == 'admin')){?>
										<a href="" style="font-size:.7em;" class="editVidSubmit my-0" vidPath="<?php echo $eachVidArray['videoPath'];?>" vidThumbnail="<?php echo $eachVidArray['videoThumbnailPath'];?>" vidType="<?php echo $eachVidArray['videoType'];?>" vidID="<?php echo $eachVidArray['id'];?>" vidTitle="<?php echo $eachVidArray['videoName'];?>" vidDescr="<?php echo $eachVidArray['videoDescription'];?>" data-toggle="modal" data-target="#editVideo">Edit</a>
									<?php }?>
								</div>
							</div>
						</div>
					</div>	
			<?php 	
				}
			?>
		</div><!-- /Talent Rows -->
	</div>
</div>

<?php 
	/* Include the footer */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); 

	/* Include the Modals */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/views/xmlhttprequest/viewAllVidModals.php'); 
?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo URL;?>js/viewAllVidJS.js?1"></script>
