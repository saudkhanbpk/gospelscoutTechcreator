<?php include('../include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">
<script>
$(document).ready(function(){
	
	        $('#menu11').show();
	
    $("#menu1").click(function(){
        $('#menu11').show();
		$('#menu22').hide();
		$('#menu33').hide();
		
		$("#menu3").removeClass("active");
		$("#menu2").removeClass("active");
		
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).addClass("active");   
	
    });
	
	    $("#menu2").click(function(){
        $('#menu22').show();
		$('#menu11').hide();
		$('#menu33').hide();
		
		$("#menu1").removeClass("active");
		$("#menu3").removeClass("active");
    	$(this).addClass("active");   
	
    });
	
	    $("#menu3").click(function(){
        $('#menu33').show();
		$('#menu22').hide();
		$('#menu11').hide();
		
		$("#menu1").removeClass("active");
		$("#menu2").removeClass("active");
    	$(this).addClass("active");   
		
    });
});
</script>

<style>
.center-block {
  height: 153px;
}
.back {
	margin:0px !important;
}
</style>
<?php
if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){
	
	if(isset($_GET['artist']) > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['artist'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$_GET['artist']);
		
	}else{
		$cond = "";
		$cond = "iLoginID = ".$objsession->get('gs_login_id');
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
	}
}else{
	
	if($_GET['artist'] > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['artist'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$_GET['artist']);
		
	}	
}

if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){
	$cond = "";
	$cond = "iLoginID = ".$objsession->get('gs_login_id');
	$userRow = $obj->fetchRow("usermaster",$cond);
	$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
	$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
}
?>

<div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12">
    
    <h3 style="margin:15px 0; color:#8e44ad; font-size:20px; font-weight:bold;">
	<?php 
		if ( $usermaster['sGroupType'] == 'group' ) { 
			echo ucwords(strtolower($usermaster['sGropName']));	
		} else {
			echo ucwords(strtolower($userRow['sFirstName'].' '.$userRow['sLastName']));		
		}		
		?><?php 
		if(isset($_GET['back'])){
			$url = 'viewallvideo.php?categoryname='.$_GET['cat'];
		}else{
			if(isset($_GET['artist'])){
				$url = 'views/artistprofile.php?artist='.$_GET['artist'];
			}else{
				$url = 'views/artistprofile.php';
			}
		}
?>
            <a href="<?php echo URL.$url;?>" class="back">Back</a></h3> 
        
        <?php if($objsession->get('gs_msg') != ""){?>
        <div class="suc-message"> <?php echo $objsession->get('gs_msg');?> </div>
        <?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
        <span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
        <?php
$objsession->remove('gs_error_msg');
}



if(isset($_GET['artist']) > 0){
$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$_GET['artist']." AND sGiftName = '".$_GET['categoryname']."'");
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['artist']);
}else{
$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$objsession->get('gs_login_id')." AND sGiftName = '".$_GET['categoryname']."'");
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));
}

$giftmaster = $obj->fetchRowAll("giftmaster","isActive = 1 ");
?>
    </div>
</div>

<div class="bg">
    <div class="container">
        
        
        <!-- Tab panes -->
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="profile">
                    <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
                        <?php
		if(count($gistmaster) > 0){
			$vid = 0;
			$vR = 1;
			$yu = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				$vdiImage = explode(',',$gistmaster[$gi]['sVideoImages']);
	?>
                        <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
                            <form name="frmVideo" id="frmVideo">
                                <div class="video_sec">
                                    <h3 style="float:left; margin-bottom: 12px;margin-left: 14px;"><?php echo ucfirst($gistmaster[$gi]['sGiftName']);?></h3>
                                </div>
                                <div class="" style="clear:both;"></div>
                                <?php 
			if($gistmaster[$gi]['sVideo'] != ""){
				
				$v = 0;
				foreach($vdiList as $vd){
		?>
                                
                                <div class="col-lg-3 col-mg-3 col-sm-3">
                                    
									<?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
								?>
                                <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sGiftName'];?>&type=video&videName=<?php echo $vdiName[$v];?>&name=<?php echo $vd;?>&main=artist">X</a></div>
                                <?php } ?>
                                
                                
                                <?php if(isset($_GET['artist'])){?>
                                <a href="<?php echo URL;?>views/artistvideodetails.php?artist=<?php echo $_GET['artist'];?>&video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                                <?php }else{?>
                                <a href="<?php echo URL;?>views/artistvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>"> 
                                <?php } ?>
								<?php if($gistmaster[$gi]['sGroupType'] == 'solo'){?>
                    <?php /*?><video width="400" class="img-responsive center-block videoHeght">
                      <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                    </video><?php */
					if ( $vdiImage[$v] != "" ) {
					?>
                    
                    <img style="object-fit: cover; object-position: 0,0;" src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
					<div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                    
                    <?php } }else{ ?>
                    <?php /*?><video width="400" class="img-responsive center-block">
                      <source src="<?php echo URL;?>upload/artist/video/group/<?php echo $vd;?>" type="video/mp4">
                    </video><?php */
						if ( $vdiImage[$v] != "" ) {
					 ?>
                    
                    <img style="object-fit: cover; object-position: 0,0;" src="<?php echo URL;?>upload/artist/video/group/<?php echo $vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
					<div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
					<?php }} ?>
									 <?php /*?><video width="400" height="150" class="img-responsive" style="height:150px;">
                                        <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                                    </video><?php */?>
                                    <script>
$(document).ready(function () {
	
	
	
 $('#view_btn<?php echo $gistmaster[$gi]['iRollID'];?>').on('click', function (e) {

		  e.preventDefault();	  
			var formData = $('#frmVideo').serialize();			
			var val = $('#sVideoName<?php echo $gistmaster[$gi]['iRollID'];?>').val();
			var cat = $('#cat<?php echo $gistmaster[$gi]['iRollID'];?>').val();
		  $.ajax({
			type: 'post',
			url: '<?php echo URL;?>views/countvalue.php?sVideoName='+val,
			data: formData,
			success: function (data) {
			  if(data == 'Please check your video'){
				  $('#loadlogin').html(data);
			  }else{
				window.location = "<?php echo URL;?>views/artistvideodetails.php?video="+val+"&cat="+cat+"&back=all";  
			  }
			}
		  });  
		  
        });
	
});
 
 </script>
                                    <?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","sVideoName = '".$vdiList[$v]."'");
			}else{
			$videocount = $obj->fetchRow("videomaster","sVideoName = '".$vdiList[$v]."'");
			}
			?>
                                    <div style="text-align:left"> <span id="loadlogin"></span>
 
 <?php
	
$cond = "sVideoName = '".$vdiList[$v]."' AND status = 1";
$retting = $obj->fetchAverageTotal('videoratting','iTotalPoint',$cond);
$ratingNum = $obj->fetchNumOfRow('videoratting',$cond);
$total = 0;

if($ratingNum > 0){
	$total = $retting['average_rating'] / $ratingNum;
}
?>

<!--Video ratting section start-->
<link href="<?php echo URL;?>css/rating-1.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>
<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star<?php echo $vR;?>").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $total;?>',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});

</script>

                                        <h2 style="color: black; font-weight: bold;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></h2>
                                        <p class="tital1">
                                            <?php if(!empty($videocount)){echo $videocount['iViews'];}else{echo '0';}?>
                                            Views</p>
                                        <input type="hidden" name="sVideoName" id="sVideoName<?php echo $gistmaster[$gi]['iRollID'];?>" value="<?php echo $vdiList[$v];?>" />
                                        <input type="hidden" name="cat" id="cat<?php echo $gistmaster[$gi]['iRollID'];?>" value="<?php echo $gistmaster[$gi]['sGiftName'];?>" />
                                        
                                        
                                        <?php /*?><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star grey" aria-hidden="true"></i><?php */?>
                                        <p class="tital1">
                                            <?php	
			$vdate = $obj->fetchRow('videouploaddate',"sVideoName = '".$vdiList[$v]."'");
																			
			if( $vdate['dCreatedDate'] != '')	 {
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($vdate['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				echo $numberDays = intval($numberDays);
			}else{
				echo '0';	
			}
			?>
                                            days Ago</p>
<input name="rating" value="0" id="rating_star<?php echo $vR;?>" type="hidden" postID="1" />
											</a>
                                        </div>
                                </div>
                                
                                <?php
		$v ++;
		$vid ++;
		
		$vR ++;
		
				}
			}
		?>
                                <?php if($gistmaster[$gi]['sYoutubeUrl'] != ""){
				
				
				$youtube = explode(',',$gistmaster[$gi]['sYoutubeUrl']);
				
				foreach ( $youtube as $key ) {
				
					$filename = substr(strrchr($key, "="), 1);	
					if($filename != ''){
						$yu ++;
		?>
                                <div class="col-lg-3 col-mg-3 col-sm-3">
								
								<?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
								?>
                                <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/viewallvideo.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sGiftName'];?>&type=youtubevideo&videName=<?php echo $key;?>&main=artist&iyoutubeid=<?php echo $gistmaster[$gi]['iRollID']; ?>">X</a></div>
                                <?php
								}?>
								
                                <?php if(isset($_GET['artist'])){?>
                    <a href="<?php echo URL;?>views/artistvideodetails.php?video=&artist=<?php echo $_GET['artist'];?>&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                    <?php }else{?>
                    <a href="<?php echo URL;?>views/artistvideodetails.php?video=&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                    <?php } ?>
                    <div width="400" class="img-responsive center-block" id="msg_url<?php echo $yu;?>"></div>
                                   <?php /*?> <iframe width="192" height="150" src="https://www.youtube.com/embed/<?php echo $filename; ?>" frameborder="0" allowfullscreen></iframe><?php */?>
                                 
                                 <?php
	
$cond = "sVideoName = '".$filename."' AND status = 1";
$retting = $obj->fetchAverageTotal('videoratting','iTotalPoint',$cond);
$ratingNum = $obj->fetchNumOfRow('videoratting',$cond);
$total = 0;

if($ratingNum > 0){
	$total = $retting['average_rating'] / $ratingNum;
}

?>
                    
                    <!--Video ratting section start--> 
	<link href="<?php echo URL;?>css/rating-1.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>
<script language="javascript" type="text/javascript">
$(function() {
	
	var ytl = '<?php echo $key;?>';
        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        $("#msg_url<?php echo $yu;?>").html("<p><img src=\"http://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg\" class=\"img-responsive center-block\" /></p>");
		
    $("#rating_star01<?php echo $yu;?>").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $total;?>',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});

</script>   
                <p style="color: black; font-weight: bold;" class="Uname" id="uname<?php echo $yu;?>"></p>
                <p class="tital1" id="Uviews<?php echo $yu;?>"></p>
                
                <p class="tital1" id="uDate<?php echo $yu;?>"></p>
				<input name="rating" value="0" id="rating_star01<?php echo $yu;?>" type="hidden" postID="1" />
                </a>
                                    

                                </div>
<script>

//Youtube star rating............................
$(function() {
		
function parseDate(str) {
    var mdy = str.split('-');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function daydiff(first, second) {
    return Math.round((second-first)/(1000*60*60*24));
}

		var videoid = "<?php echo $filename; ?>";
		var matches = videoid.match(/^http:\/\/www\.youtube\.com\/.*[?&]v=([^&]+)/i) || videoid.match(/^http:\/\/youtu\.be\/([^?]+)/i);
		
		if (matches) {
			videoid = matches[1];
		}
		
		if (videoid.match(/^[a-z0-9_-]{11}$/i) === null) {
			$("<p style='color: #F00;'>Unable to parse Video ID/URL.</p>").appendTo("#video-data-1");
			return;
		}
		
		var d = new Date();
		var strDate =  (d.getMonth()+1) + "-" + d.getDate() + "-" + d.getFullYear();
		
		$.getJSON("https://www.googleapis.com/youtube/v3/videos", {
			key: "AIzaSyDpY9FHgp7EvnDr5mGrxWwKgUBtfM8l5PE",
			part: "snippet,statistics",
			id: videoid
		}, function(data) {
			
			var uname = data.items[0].snippet.title;			
			$("#uname<?php echo $yu;?>").text(uname.substr(0,12));
			$("#Uviews<?php echo $yu;?>").text(data.items[0].statistics.viewCount+" Views");

			var pdate = data.items[0].snippet.publishedAt.substr(0,10);
			
			var dateAr = pdate.split('-');
			var newDate = dateAr[1] + '-' + dateAr[2] + '-' + dateAr[0];

			var days = daydiff(parseDate(newDate), parseDate(strDate));
			
			if ( days > 31) {
				days = days / 30;
				days = (Math.round(days)) + " month Ago";
			} else if ( days > 365 ) {
				days = days / 365;
				days = (Math.round(days)) + " year Ago";
			}else {
				days = (Math.round(days)) + " days Ago";
			}
				
			$("#uDate<?php echo $yu;?>").text( days );
			
			//$("<li></li>").text("Published at: " + data.items[0].snippet.publishedAt).appendTo("#video-data-2");
			//$("<li></li>").text("View count: " + data.items[0].statistics.viewCount).appendTo("#video-data-2");
			//$("<li></li>").text("Like count: " + data.items[0].statistics.likeCount).appendTo("#video-data-2");
			//$("<li></li>").text("Dislike count: " + data.items[0].statistics.dislikeCount).appendTo("#video-data-2");
		});
	
});

</script>                                
                                <?php }
				}
		} ?>
                            </form>
                        </div>
                        <?php 
			}
	}else{
		
		echo "<h3>This Artist Has No Videos Uploaded </h3>";		}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_GET['type'])){
	
	if($_GET['type'] == 'video'){
		
		if($_GET['main'] == 'artist'){
			
			$cond = '';
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGiftName = '".$_GET['videoType']."'";
			$gift = $obj->fetchRow("rollmaster",$cond);
			
			$str1 = str_replace($_GET['name'],' ',$gift['sVideo']);
			$str2 = str_replace($_GET['videName'],' ',$gift['sVideoName']);
			
			$str1 = str_replace(' ,','',$str1);
			$str2 = str_replace(' ,','',$str2);
			
			$str1 = rtrim($str1,', ');
			$str2 = rtrim($str2,', ');
			
			$field = array("sVideo","sVideoName");
			$value = array($str1,$str2);
			
			$obj->update($field,$value,$cond,"rollmaster");
			
			$obj->delete('videouploaddate',"sVideoName = '".$_GET['name']."'");
			
			deleteImage($_GET['name'],'upload/artist/video/'.$_GET['videoType']);
			
			$objsession->set('gs_msg','Video deleted successfully');
			redirect(URL.'views/viewallvideo.php?categoryname='.$_GET['videoType']);
			
		}
	}
	
	if($_GET['type'] == 'youtubevideo'){
		
		$cond = '';
		$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGiftName = '".$_GET['videoType']."'";
		$gift = $obj->fetchRow("rollmaster",$cond);
		
		$str1 = str_replace($_GET['videName'],' ',$gift['sYoutubeUrl']);
		
		$str1 = str_replace(' ,','',$str1);
		$str1 = rtrim($str1,', ');
				
		$field = array("sYoutubeUrl");
		$value = array($str1);
		
		$obj->update($field,$value,$cond,"rollmaster");
			
		$objsession->set('gs_msg','Youtube video successfully deleted.');	
		redirect(URL.'views/viewallvideo.php?categoryname='.$_GET['videoType']);
		
	}
	
}
?>
<?php include('../include/footer.php');?>