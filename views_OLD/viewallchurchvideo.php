<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">
<style>
.col-lg-3.col-mg-3.col-sm-3 {
  height: 150px;
  margin-bottom: 110px;
}
.center-block {
  height: 153px;
}
.back {
	margin:0px !important;
}
</style>
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
<div class="container1">
    <div class="col-lg-12 col-md-12 col-sm-12 p70">
        <?php if($objsession->get('gs_msg') != ""){?>
        <div class="suc-message"> <?php echo $objsession->get('gs_msg');?> </div>
        <?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
        <span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
        <?php
$objsession->remove('gs_error_msg');
}

if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'church'){
	
	if(isset($_GET['church']) > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['church'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['church']);
		$usermaster = $obj->fetchRow("churchministrie","iLoginID = ".$_GET['church']);
		$churchtimeing = $obj->fetchRowAll("churchtimeing","iLoginID = ".$_GET['church']);
		$churchministrie = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['church']);
		
	}else{
		$cond = "";
		$cond = "iLoginID = ".$objsession->get('gs_login_id');
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
		$usermaster = $obj->fetchRow("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
		$churchtimeing = $obj->fetchRowAll("churchtimeing","iLoginID = ".$objsession->get('gs_login_id'));
		$churchministrie = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
	}
}else{
	if($_GET['church'] > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['church'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['church']);
		$usermaster = $obj->fetchRow("churchministrie","iLoginID = ".$_GET['church']);
		$churchtimeing = $obj->fetchRowAll("churchtimeing","iLoginID = ".$_GET['church']);
		$churchministrie = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['church']);
	}	
	
}

if(isset($_GET['church']) > 0){
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['church']);
$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['church']." AND sMinistrieName = '".$_GET['categoryname']."'");
}else{
$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id')." AND sMinistrieName = '".$_GET['categoryname']."'");
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));
}
?>
    </div>
</div>
<div class="carousel-holder">
    <div class="container1">
    
    <h3 style="margin:15px 0; color:#8e44ad; font-size:20px; font-weight:bold;">
        <?php 
		echo ucfirst(strtolower($userRow['sChurchName']));
		?>
         <?php 
		if(isset($_GET['back'])){
			$url = 'views/viewallchurchvideo.php?categoryname='.$_GET['cat'];
		}else{
			if(isset($_GET['church'])){
				$url = 'views/churchprofile.php?church='.$_GET['church'];
			}else{
				$url = 'views/churchprofile.php';
			}
		}
?>
            <a href="<?php echo URL.$url;?>" class="back">Back</a>
        </h3>
    </div>
</div>
<div class="bg">
    <div class="container1">
        <?php
$services = '';
if(count($churchtimeing) > 0){
	for($ser=0;$ser<count($churchtimeing);$ser++){
		$hour = substr($churchtimeing[$ser]['iHour'],0,2);
		$am = substr($churchtimeing[$ser]['iHour'],5);
		$services .= $churchtimeing[$ser]['sTitle'].' - '.$hour.":".$churchtimeing[$ser]['iMinute'].' '.$am.',';
	}
}
?>           
        <!-- Tab panes -->
        
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="profile">
                    <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
                        <?php
		if(count($gistmaster) > 0){
			$vid = 0;
			$vUR = 0;
			$vR = 1;
			$vdCheck = '';
			$yu = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				if($gistmaster[$gi]['sVideo'] == "" && $vdCheck == ""){
					$vdCheck = '';
				}else{
					$vdCheck = 'test';
				}

				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				$vdiImage = explode(',',$gistmaster[$gi]['sVideoNameImage']);
	?>
                        <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
                            <form name="frmVideo" id="frmVideo">
                                <div class="video_sec">
                                    <h3 style="float:left;"><?php echo ucwords(str_replace('_',' ',$gistmaster[$gi]['sMinistrieName']));?></h3>
                                </div>
                                <div class="" style="clear:both;"></div>
                                <?php 
			if($gistmaster[$gi]['sVideo'] != ""){
				
				$v=0;
				
				foreach($vdiList as $vd){
						if($vid < 4){

		?>
                                
                                <div class="col-lg-3 col-mg-3 col-sm-3">
                                
								 <?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
								?>
                                <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/churchprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sMinistrieName'];?>&type=video&videName=<?php echo $vdiName[$v];?>&name=<?php echo $vd;?>&main=church">X</a></div>
                                
                                <?php } ?>
                                <div style="margin-top:20px;">
                                  <?php if(isset($_GET['church'])){?>
                                <a href="<?php echo URL;?>views/churchvideodetails.php?church=<?php echo $_GET['church'];?>&video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                                <?php }else{?>
                                <a href="<?php echo URL;?>views/churchvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                                <?php } ?>
								
                                   <?php /*?><video width="400" class="img-responsive">
                                        <source src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.$vd;?>" type="video/mp4">
                                    </video><?php */?>
                                    
				<?php if ( isset($vdiImage[$v]) != "" ) {?>         
                                <img src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.$vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                                <?php } else {?>
                                <div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                                <?php } ?>
                                
                                    <script>
$(document).ready(function () {
	
 $('#view_btn<?php echo $gistmaster[$gi]['iChurchID'];?>').on('click', function (e) {

		  e.preventDefault();	  
			var formData = $('#frmVideo').serialize();			
			var val = $('#sVideoName<?php echo $gistmaster[$gi]['iChurchID'];?>').val();
			var cat = $('#cat<?php echo $gistmaster[$gi]['iChurchID'];?>').val();
			
		  $.ajax({
			type: 'post',
			url: '<?php echo URL;?>views/countvalue.php?sVideoName='+val,
			data: formData,
			success: function (data) {
			  if(data == 'Please check your video'){
				  $('#loadlogin').html(data);
			  }else{
				window.location = "<?php echo URL;?>views/churchvideodetails.php?video="+val+"&cat="+cat+"&back=all";  
			  }
			}
		  });			  
		  
		  
        });
	
});
 
 </script>
                                    <?php
			if(isset($_GET['church'])){
			$videocount = $obj->fetchRow("videomaster","sVideoName = '".$vdiName[$v]."'");
			}else{
			$videocount = $obj->fetchRow("videomaster","sVideoName = '".$vdiList[$v]."'");
			}
			?>
                                    <span id="loadlogin"></span>
                                    
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
       // inputAttr: 'postID'
    });
});

</script>


                                    <h2 style="color: black; font-weight: bold;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></h2>
                                    <p class="tital1">Views : 
                                        <?php if(!empty($videocount)){echo $videocount['iViews'];}else{echo '0';}?>
                                        </p>
                                        
                                    <input type="hidden" name="sVideoName" id="sVideoName<?php echo $gistmaster[$gi]['iChurchID'];?>" value="<?php echo $vdiList[$v];?>" />
                                    <input type="hidden" name="cat" id="cat<?php echo $gistmaster[$gi]['iChurchID'];?>" value="<?php echo $gistmaster[$gi]['sMinistrieName'];?>" />
                                    <?php /*?><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star grey" aria-hidden="true"></i><?php */?>
                                    <p class="tital1">Days Ago : 
                                        <?php	
			$vdate = $obj->fetchRow('videouploaddate',"sVideoName = '".$vdiList[$v]."'");
																			
			if( $vdate['dCreatedDate'] != '') {
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($vdate['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				echo $numberDays = intval($numberDays);
			}else{
				echo '0';	
			}

			?>
                                        </p>
						<input name="rating" value="0" id="rating_star<?php echo $vR;?>" type="hidden" postID="1" />
										</a>
                                        </div>
                                </div>
                                
                                <?php
					$v ++;	
				}
		
		$vid ++;
		$vUR ++;
		$vR  ++;

			}
		
}
		?>
                                 <?php if($gistmaster[$gi]['sUrl'] != ""){
										
									if($vUR < 4){
					$vdCheck = 'test';
					$vUR = 0;
				$youtube = explode(',',$gistmaster[$gi]['sUrl']);
				
				foreach ( $youtube as $key ) {
					
					
					$filename = substr(strrchr($key, "="), 1);	
					if($filename != ""){
						$yu ++; 		
		?>
                                <div class="col-lg-3 col-mg-3 col-sm-3">
                                 <?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
								?>
                                <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/churchprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sMinistrieName'];?>&type=youtubevideo&videName=<?php echo $key;?>&main=church&iyoutubeid=<?php echo $gistmaster[$gi]['iChurchID']; ?>">X</a></div>
                                <?php }?>
                                   <div style="margin-top:20px;">
                                   <?php if(isset($_GET['church'])){?>
                                <a href="<?php echo URL;?>views/churchvideodetails.php?video=&church=<?php echo $_GET['church'];?>&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                                <?php }else{?>
                                <a href="<?php echo URL;?>views/churchvideodetails.php?video=&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                                <?php } ?>
                                <div width="400" class="img-responsive center-block" id="msg_url<?php echo $yu;?>"></div>
                                    <?php /*?><iframe width="176" height="150" src="https://www.youtube.com/embed/<?php echo $filename; ?>?controls=0&showinfo=0" ></iframe><?php */?>
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
        callbackFunctionName: 'processRating',
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

		var videoid = "<?php echo $filename;?>";
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
			$("#uname<?php echo $yu;?>").text(uname.substr(0,18));
			$("#Uviews<?php echo $yu;?>").text("Views :"+data.items[0].statistics.viewCount);

			var pdate = data.items[0].snippet.publishedAt.substr(0,10);
			
			var dateAr = pdate.split('-');
			var newDate = dateAr[1] + '-' + dateAr[2] + '-' + dateAr[0];

			var days = daydiff(parseDate(newDate), parseDate(strDate));
			
			if ( days > 31) {
				days = days / 30;
				days = "Month Ago :"+(Math.round(days));
			} else if ( days > 365 ) {
				days = days / 365;
				days = "Year Ago :"+(Math.round(days));
			}else {
				days = "Days Ago :"+(Math.round(days));
			}
				
			$("#uDate<?php echo $yu;?>").text( days );
			
			//$("<li></li>").text("Published at: " + data.items[0].snippet.publishedAt).appendTo("#video-data-2");
			//$("<li></li>").text("View count: " + data.items[0].statistics.viewCount).appendTo("#video-data-2");
			//$("<li></li>").text("Like count: " + data.items[0].statistics.likeCount).appendTo("#video-data-2");
			//$("<li></li>").text("Dislike count: " + data.items[0].statistics.dislikeCount).appendTo("#video-data-2");
		});
	
});

</script>                               
                                
				<?php 
						}
					}	
				} 
			 } ?>
                            </form>
                        </div>
                        <?php 
			/*if($vdCheck == ''){
			
				echo '<h3 style="color: #ccc; font-family: v;" class="h3new">This Chruch Has No Videos Uploaded </h3>';	
			}
}else{
		
		echo "<h3>This Artist Has No Videos Uploaded </h3>";		}*/?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_GET['type'])){
	
	if($_GET['type'] == 'video'){
		
		if($_GET['main'] == 'church'){
			
			$cond = '';
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sMinistrieName = '".$_GET['videoType']."'";
			$gift = $obj->fetchRow("churchministrie",$cond);
			
			$str1 = str_replace($_GET['name'],' ',$gift['sVideo']);
			$str2 = str_replace($_GET['videName'],' ',$gift['sVideoName']);
			
			$str1 = str_replace(' ,','',$str1);
			$str2 = str_replace(' ,','',$str2);
			
			$str1 = rtrim($str1,', ');
			$str2 = rtrim($str2,', ');
			
			$field = array("sVideo","sVideoName");
			$value = array($str1,$str2);
			
			$obj->update($field,$value,$cond,"churchministrie");
			
			deleteImage($_GET['name'],'upload/church/video/'.$_GET['videoType']);
			
			$objsession->set('gs_msg','Video deleted successfully');
			redirect(URL.'views/viewallchurchvideo.php?categoryname='.$_GET['videoType']);
			
		}
	}
	
	if($_GET['type'] == 'youtubevideo'){
		
		$cond = '';
		$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sMinistrieName = '".$_GET['videoType']."'";
		$gift = $obj->fetchRow("churchministrie",$cond);
		
		$str1 = str_replace($_GET['videName'],' ',$gift['sUrl']);
		
		$str1 = str_replace(' ,','',$str1);
		$str1 = rtrim($str1,', ');
				
		$field = array("sUrl");
		$value = array($str1);
		
		$obj->update($field,$value,$cond,"churchministrie");
			
		$objsession->set('gs_msg','Youtube video successfully deleted.');	
		redirect(URL.'views/viewallchurchvideo.php?categoryname='.$_GET['videoType']);
		
	}
}


}
}

?>
<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>