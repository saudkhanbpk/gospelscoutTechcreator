<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL;?>views/skin/functional.css">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>

<!--Video ratting section start-->
<link href="<?php echo URL;?>css/rating.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating.js"></script>

<script src="<?php echo URL;?>views/flowplayer.min.js"></script>
<style>
.white {
  margin-top: 13px !important;
}
#error_msg {
  display: block;
  font-size: 15px;
  margin-bottom: 12px;
  margin-left: 33px !important;
}
</style>
<?php
$videocountReview = array();
	
$cond = "sVideoName = '".$_GET['video']."'";
$retting = $obj->fetchRow('videoratting',$cond);
$ratingNum = $obj->fetchNumOfRow('videoratting',$cond);
$total = 0;

if($ratingNum > 0){
	$total = $retting['iTotalPoint'];
}

$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 

if($pageRefreshed == 1){
	//echo "Yes page Refereshed";
}else{
    
	
	$viewsTotal = $obj->fetchRow("videomaster","sVideoName = '".$_GET['video']."'");
		
	if ( !empty($viewsTotal) ) {
		
		$tv = $viewsTotal['iViews'] + 1;
		
		$field = array("iViews","sVideoName");
		$value = array($tv,$_GET['video']);		
	
		$obj->update($field,$value,"sVideoName = '".$_GET['video']."'","videomaster");
			
	} else {
		
		$field = array("iViews","sVideoName");
		$value = array(1,$_GET['video']);		
	
		$obj->insert($field,$value,"videomaster");
		
	}
	
	$videoTotalRate = $obj->fetchRow("rollmaster","FIND_IN_SET('".$_GET['video']."',sVideo)");
	
	if ( !empty($videoTotalRate) ) {
		
		$iTotalVideoRate = $obj->fetchRow("usermaster","iLoginID = ".$videoTotalRate['iLoginID']);
		
		if ( $iTotalVideoRate['iTotalVideoRate'] > 0 ) {
			
			$rateTotal = $iTotalVideoRate['iTotalVideoRate'] + 1;
			
		} else {
			
			$rateTotal = 1;
			
		}
		
		$fld = array("iTotalVideoRate");
		$val = array($rateTotal);
		
		$obj->update($fld,$val,"iLoginID = ".$videoTotalRate['iLoginID'],"usermaster");
	}
}
?>
<?php 
if($_GET['youtube'])
{
	$videotitle=$_GET['youtube'];
}
else
{
	$videotitle=$_GET['video'];
}
$rated = $obj->fetchRow("videoratting","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$videotitle."'");
?>
<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star2").codexworld_rating_widget({
        starLength: '5',
        initialValue: <?php echo $rated['iTotalPoint'];?>,
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});
</script>
<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '0',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});

function processRating(val, attrVal){
    $.ajax({
        type: 'POST',
        url: '<?php echo URL;?>views/rating.php',
        data: 'postID='+attrVal+'&ratingPoints='+val+'&videoName=<?php echo $_GET['video'];?>',
        dataType: 'json',
        success : function(data) {
/*            if (data.status == 'ok') {
                //alert('You have rated '+val+' to CodexWorld');
               // $('#avgrat').text(data.average_rating);
               // $('#totalrat').text(data.rating_number);
            }else{
                alert('Some problem occured, please try again.');
            }
*/        }
    });
}
</script>

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

<?php



if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){

	if(isset($_GET['artist']) > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['artist'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$_GET['artist']);
		$churchministrie = $obj->fetchRowAll("rollmaster","iLoginID = ".$_GET['artist']);
		
	}else{
		$cond = "";
		$cond = "iLoginID = ".$objsession->get('gs_login_id');
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
		$rollmaster = $obj->fetchRow("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
		$rollmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
	}
}else{
	if(isset($_GET['artist']) > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['artist'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
		$usermaster = $obj->fetchRow("rollmaster",$cond);
		$rollmaster = $obj->fetchRow("churchministrie","iLoginID = ".$_GET['artist']);
		$rollmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['artist']);
	}	
	
}

?>
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12">
  <?php 
		if(isset($_GET['back'])){
			
			if(isset($_GET['artist'])){
				$url = 'views/viewallvideo.php?categoryname='.$_GET['cat']."&artist=".$_GET['artist'];
			}else{
				$url = 'views/viewallvideo.php?categoryname='.$_GET['cat'];
			}
			
			
		}else{
			if(isset($_GET['artist'])){
				$url = 'views/artistprofile.php?artist='.$_GET['artist'];
			}else{
				$url = 'views/artistprofile.php';
			}
		}
?>
  <h3 style="margin:15px 0; color:#8e44ad; font-size:20px; font-weight:bold;">
  <?php 
		if ( $usermaster['sGroupType'] == 'group' ) { 
			echo ucwords(strtolower($usermaster['sGropName']));	
		} else {
			echo ucwords(strtolower($userRow['sFirstName'].' '.$userRow['sLastName']));		
		}		
		?>
		<a href="<?php echo URL.$url;?>" class="backdetails">Back</a>
		</h3> 
        
<?php if($objsession->get('gs_msg') != ""){?>
<div class="suc-message">
<?php echo $objsession->get('gs_msg');?>
</div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}

if(isset($_GET['artist']) > 0){
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['artist']);
$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$_GET['artist']." AND sGiftName = '".$_GET['cat']."'");
}else{
$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$objsession->get('gs_login_id')." AND sGiftName = '".$_GET['cat']."'");
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));
}
?> 
    
  </div>
</div>  
  <div class="bg">
    <div class="container">


<!-- Tab panes --> 
<div class="col-lg-12 col-md-12 col-sm-12"> 
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="profile"> 
  <div class="col-lg-8 col-md-8 col-sm-8 white chang mg0">
  	<?php /*?><h3 style="float:left;">Artist-<?php echo ucfirst($objsession->get('gs_user_name'));?>-<?php echo ucwords($_GET['cat']);?></h3><?php */?>
    <?php
		if(count($gistmaster) > 0){
			$vid = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				$v = 0;
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				
	?>
    <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
  <!-- <form name="frmVideo" id="frmVideo" method="post"> -->
    	<div class="video_sec">
        <?php /*?><h3 style="float:left;">Church-<?php echo ucfirst($objsession->get('gs_user_name'));?>-<?php echo ucwords(str_replace('_',' ',$gistmaster[$gi]['sMinistrieName']));?></h3><?php */?>
    	</div>        
        <div class="" style="clear:both;"></div>
    	<?php 
		
			if ( $_GET['video'] != '' ){
				if($gistmaster[$gi]['sVideo'] != ""){
				
				
				foreach($vdiList as $vd){
					if($vd == $_GET['video']){
		?>
        <div class="col-lg-12 col-mg-12 col-sm-12">        
        
        <?php if($gistmaster[$gi]['sGroupType'] == 'solo'){?>
				
					<div class="flowplayer" data-swf="<?php echo URL;?>views/flowplayerhls.swf">
                    <video width="800" controls class="img-responsive center-block hight" preload="metadata">
                      <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                    </video></div>
                    <?php }else{ ?>
					<div class="flowplayer" data-swf="<?php echo URL;?>views/flowplayerhls.swf">
                    <video width="800" controls class="img-responsive center-block hight" >
                      <source src="<?php echo URL;?>upload/artist/video/group/<?php echo $vd;?>" type="video/mp4">
                    </video></div>
                    <?php } ?>
                    <?php /*?>
        <video width="800" controls class="img-responsive center-block hight">
  <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/webm">
</video><?php */?>

 			<?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['artist']." AND sVideoName = '".$vdiName[$v]."'");
			$videocountAll = $obj->fetchRowAll("videomaster","sVideoName = '".$_GET['video']."'");
			}else{
			$videocountAll = $obj->fetchRowAll("videomaster","sVideoName = '".$_GET['video']."'");
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");
			}
			?>
        	<span id="loadlogin"></span>
            <div class="clear"></div>
            <h2 style="margin-top: 15px; padding: 13px; font-size: 25px ! important;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></h2>
            
            <div class="artistprofile">
            	<?php if(!empty($userRow)){?>
                <div class="col-lg-2 col-mg-2 col-sm-2">                
                <img width="50" height="50" src="<?php echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];?>" />                
                </div>
                <div class="col-lg-4 col-mg-4 col-sm-4">
                <?php 
				if ( $usermaster['sGroupType'] == 'group' ) { 
					echo ucwords($usermaster['sGropName']);	
				} else { 
					echo ucwords($userRow['sFirstName'].' '.$userRow['sLastName']);
				}
				
				?>
                <p class="tital1" style="margin-left: 10px;">Days Ago :
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

			?> </p>
            	
                <?php
				if($objsession->get('gs_login_id') > 0){
				?>
                
                <script>
				function check(){

		//  e.preventDefault();	  
				
		  $.ajax({
			type: 'post',
			url: '<?php echo URL;?>views/subvideo.php?videoName=<?php echo $_GET['video'];?>',
			data: '',
			success: function (data) {
			  if(data == 'Please check your video'){
				  $('#subVideo02').html('');
			  }else{
				$('#subVideo02').html(data);
			  }
			}
		  });  
		  
 }
 
 </script>
 
                <div class="subVideo" id="subVideo02">
                <?php
				 $vs = $obj->fetchRow("videosubcribe","sVideoName = '".$_GET['video']."' AND iLoginID = ".$objsession->get('gs_login_id').' AND status = 1');
				?>
            	<a class="back" style="margin:-30px  -240px;cursor:pointer;" id="subVideo"><?php if(count($vs) > 0){?>Un Subscribe<?php }else{?>Subscribe<?php } ?></a>
                </div>
                <?php } ?>
                </div>
                
                <div class="col-lg-6 col-mg-6 col-sm-6">  
               <?php 
			   $review = 0;
		

			   $videocountReview = $obj->fetchRowAll("videocomments","sVideoName = '".$_GET['video']."' ORDER BY iCommentID DESC");
				
			   $videoReview = $obj->fetchRow("videomaster","sVideoName = '".$_GET['video']."'");
			   if ( $videoReview['iViews'] != ''){ echo $videoReview['iViews'];} else { echo '0';}
			   ?> Views
               </div>
               
                <?php } ?>
            </div>
            <div class="clear"></div>
            
            <hr />
          
        <?php
					}
		$v ++;
		$vid ++;
				}
			}
			} else {
				
	   ?>
		   <?php 
			   $videocountReview = $obj->fetchRowAll("videocomments","sVideoName = '".$_GET['youtube']."' ORDER BY iCommentID DESC");
			?>
		   <iframe width="580" height="350" src="https://www.youtube.com/embed/<?php echo $_GET['youtube']; ?>" frameborder="0" allowfullscreen></iframe>
                                    
               <p style="color: black; font-weight: bold;" class="Uname" id="uname"></p>
                <p class="tital1" id="Uviews"></p>
                <p class="tital1" id="uDate" style="margin-left: 10px;"></p>
                
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

		var videoid = "<?php echo $_GET['youtube']; ?>";
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
			$("#uname").text(uname);
			$("#Uviews").text("Views : "+data.items[0].statistics.viewCount);

			var pdate = data.items[0].snippet.publishedAt.substr(0,10);
			
			var dateAr = pdate.split('-');
			var newDate = dateAr[1] + '-' + dateAr[2] + '-' + dateAr[0];

			var days = daydiff(parseDate(newDate), parseDate(strDate));
			
			if ( days > 31) {
				days = days / 30;
				days = "Month Ago : "+(Math.round(days));
			} else if ( days > 365 ) {
				days = days / 365;
				days = "Year Ago : "+(Math.round(days));
			}else {
				days = "Days Ago : "+(Math.round(days));
			}
				
			$("#uDate").text( days );
			
			//$("<li></li>").text("Published at: " + data.items[0].snippet.publishedAt).appendTo("#video-data-2");
			//$("<li></li>").text("View count: " + data.items[0].statistics.viewCount).appendTo("#video-data-2");
			//$("<li></li>").text("Like count: " + data.items[0].statistics.likeCount).appendTo("#video-data-2");
			//$("<li></li>").text("Dislike count: " + data.items[0].statistics.dislikeCount).appendTo("#video-data-2");
		});
	
});

</script>
                <?php 
				
			}
			
			
			if(isset($_GET['artist']))	{
			
			$ids = 0;
			$ids = $_GET['artist'];
			
		}else{
			
				$ids = $objsession->get('gs_login_id');
		}
		
		?>     
         
    </div>
	<script type="text/javascript">
$(document).ready(function() {	
			
		$("#frmVideo").validate({

				errorClass: "error",
			errorElement: "span",
				rules: {
					comment: {
						required: true,
					},
					rate: {
						required: true,
					},				
				},
				messages: {
					comment: {
						required: 'Please enter comment',
					},
					rate: {
						required: "Select rating",
					},
				},
					submitHandler: function(form) {
					form.submit();}
				
			});
	
		
});
</script>
    

    <div class="brd">
	<input type="hidden" id="log_id" value="<?php echo $objsession->get('gs_login_id');?>" />
	<span id="error_msg"></span>
	<?php
			
		 
					if(count($rated))
						{ ?>
						<div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">        
        <div class="col-lg-8">
        <label for="firstname" class="control-label">You have Rated</label><br />
         <input name="rating" value="0" id="rating_star2" type="hidden" postID="1"/>
        </div>
      </div>
    </div>
				<?php
				}
				else
				{
				?>
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">        
        <div class="col-lg-8">
        <label for="firstname" class="control-label">Rate this video</label><br />
         <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
        </div>
      </div>
    </div>
		<?php }
    ?>
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">
        <div class="col-lg-12">
          <textarea class="form-control" id="comment" name="comment" rows="10" cols="10" style="height: 120px" placeholder="Comments"></textarea>
        </div>
      </div>
    </div>
			
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">
        <div class="col-lg-12">
        <button class="form-control" onclick="postdata()" name="btn_sub" style="box-shadow: 0px 2px 4px #999; height: 45px !important;">POST</button>
          <?php /*?><input type="submit" class="form-control" name="btn_sub" value="POST" ><?php */?>
        </div>
      </div>
    </div>
    </div>
   
    
    <script>
				function postdata(){

		//  e.preventDefault();	  
		
		var comment = $('#comment').val();
		var rating_star = $('#rating_star').val();
				
		if ( $("#log_id").val() != "") {
			
			if(comment == ""){
				alert('Please enter comment');
				return false;	
			}else{
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/insertpostartist.php?comment='+comment+'&loginid=<?php echo $objsession->get('gs_login_id');?>&artist=<?php echo $_GET['artist'];?>&videoname=<?php echo $_GET['video'];?>&cat=<?php echo $_GET['cat'];?>&rating='+rating_star+'&userid=<?php echo $ids;?>&youtube=<?php echo $_GET['youtube'];?>',
				data: '',
				success: function (data) {	
				$('#comment').val('');	  
					$('#cm').html(data);			  
				}
			  }); 
			}
		} else {
			$("#comment").val('');
			$("#error_msg").text('Login must Required');
			$(".codexworld_rating_widget li").css('background-position','0 0');
		}
 }
 
 </script>
 
 <link href="<?php echo URL;?>css/rating-1.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>

  <div id="cm">
    <?php

	if(count($videocountReview)){
		for($vi=0;$vi<count($videocountReview);$vi++){
			$cond = "iLoginID = ".$videocountReview[$vi]['iLoginID'];
			$louser = $obj->fetchRow("loginmaster",$cond);
			$comentuser = $obj->fetchRow("usermaster",$cond);
	?> 
    
    <script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star1<?php echo $vi;?>").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $videocountReview[$vi]['iReview'];?>',
        callbackFunctionName: "",
        imageDirectory: "../img/",
      //  inputAttr: 'postID'
    });
});

</script>
   
    <div class="col-lg-12 col-md-12 col-sm-12 p0 mb10">
    	<div class="form-group">
    		<div class="col-lg-2 col-mg-2 col-sm-2">     
				
				<?php
					if ( $louser['sUserType'] == "artist" ) {
				?>
				<img width="50" height="50" src="<?php echo URL;?>upload/artist/<?php echo $comentuser['sProfileName'];?>" />
				<?php
					} else {
				?>
				<img width="50" height="50" src="<?php echo URL;?>upload/church/<?php echo $comentuser['sProfileName'];?>" />
				<?php
					}
				?>
				
                </div>
        	
            <div class="col-lg-4 col-mg-4 col-sm-4" style="margin-left: -20px;">
               <?php
						if($comentuser['sUserType'] == artist)
							{?>
                <a href="artistprofile.php?artist=<?php echo $comentuser['iLoginID'];?>" ><?php echo ucwords($comentuser['sFirstName'].''.$comentuser['sLastName']);?></a>
						<?php }else
							{?>
				<a href="churchprofile.php?church=<?php echo $comentuser['iLoginID'];?>" ><?php echo ucwords($comentuser['sFirstName'].''.$comentuser['sLastName']);?></a>
							<?php }?>
                
            <p style="color: rgb(0, 0, 0) ! important; font-weight: normal; word-wrap: break-word; width: 230%;"><?php echo $videocountReview[$vi]['sComment'];?></p>
            <!--<p><input name="rating_star1" value="0" id="rating_star1<?php echo $vi;?>" type="hidden" postID="0" /></p>-->
            
                </div>   
              <?php
		if($videocountReview[$vi]['iLoginID'] == $objsession->get('gs_login_id')){
		?>
        <div class="col-lg-4 col-mg-4 col-sm-4" style="float: right;">
				<p class="tital1" style="float: right; margin-right: 33px;font-size: 9px;">
			<?php	
			$vdate = $obj->fetchRow('videouploaddate',"sVideoName = '".$vdiList[$v]."'");
																			
			if( $videocountReview[$vi]['dCreatedDate'] != ''){
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($videocountReview[$vi]['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				echo $numberDays = intval($numberDays);
			}else{
				echo '0';	
			}

			?> days Ago</p>

                <a style="float: right; margin-right: -100px; color: red;" href="<?php echo URL;?>views/artistvideodetails.php?artist=<?php echo $_GET['artist'];?>&video=<?php echo $_GET['video'];?>&youtube=<?php echo $_GET['youtube'];?>&cat=<?php echo $_GET['cat'];?>&iCommentID=<?php echo $videocountReview[$vi]['iCommentID'];?>" onclick="return confirm('Are you sure want to delete?');">X</a>
        </div>
        <?php } ?>
               
        </div>
    </div>
    <?php 	
		}
	}
	?>
    
    <!-- </form> -->

    <?php 
			}
	}else{
		
		echo "<h3>This Artist Has No Videos Uploaded </h3>";		}?>
   </div>
  </div>
  </div>

<div class="col-lg-4 col-md-4 col-sm-4">
	<?php
		if(count($gistmaster) > 0){
			$vid = 0;
			
			for($gi=0;$gi<count($gistmaster);$gi++){
				$v = 0;
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				$vdiImage = explode(',',$gistmaster[$gi]['sVideoImages']);

				$videoCnt = $obj->fetchRowAll("videocomments","sVideoName = '".$_GET['video']."'");
			$vcnt = 0;
			if(count($videoCnt) > 0){
					for($vc = 0;$vc<count($videoCnt);$vc++){
						$vcnt += $videoCnt[$vc]['iReview'];	
					}
			}
	?>
    
    <?php 
			if($gistmaster[$gi]['sVideo'] != ""){
				
				
				
				foreach($vdiImage as $vd){

					if($vid < 8){
		?>
<!--<div class="col-lg-12 col-md-12 col-sm-12 white">
	<div class="col-lg-5 col-md-5 col-sm-5 p0 overflow">
	
	<?php
	 if(isset($_GET['artist'])){
			
	?>
        <a href="<?php echo URL;?>views/artistvideodetails.php?video=&artist=<?php echo $_GET['artist'];?>&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
	<?php } else { ?>
	
		<a href="<?php echo URL;?>views/artistvideodetails.php?video=&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
		
	<?php } ?>
	 
     <?php if($gistmaster[$gi]['sGroupType'] == 'solo'){?>
                    <?php /*?><video width="400" class="img-responsive center-block videoHeght">
                      <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                    </video><?php */
					if ( $vd != "" ) {
					?>
                    <img src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
                    <div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                    <?php } }else{ ?>
                    <?php /*?><video width="400" class="img-responsive center-block">
                      <source src="<?php echo URL;?>upload/artist/video/group/<?php echo $vd;?>" type="video/mp4">
                    </video><?php */
						if ( $vd != "" ) {
					 ?>
                    <img src="<?php echo URL;?>upload/artist/video/group/<?php echo $vd;?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
                    <div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                    <?php }} ?>
                    
        
        </a>
	</div>-->
		
    <!--<div class="col-lg-7 col-md-7 col-sm-7 p0">
 			<?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['artist']." AND sVideoName = '".$vdiName[$v]."'");			
			}else{
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");		
			}
			
			$videoReview = $obj->fetchRow("videomaster","sVideoName = '".$vd."'");
			
			?>
        	<span id="loadlogin"></span>
            <p style="margin-left:10px; margin-bottom: 4px;word-break: break-all;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></p>
            <p style="margin-left:10px; margin-bottom: 4px;word-break: break-all;">
			<?php 
			if ( $usermaster['sGroupType'] == 'group' ) { 
					echo ucwords($usermaster['sGropName']);	
				} else { 
					echo ucwords($userRow['sFirstName'].' '.$userRow['sLastName']);
				}
			?></p>
            <p style="margin-left:10px; margin-bottom: 4px; "><?php if( $videoReview['iViews'] != ''){echo $videoReview['iViews'];}else{ echo '0';}?> View</p>
     </div>
     </div>-->
        <?php }
				$v ++;	
				}
			}
			
		$vid ++;
			}
		}
		?>
			
			
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
                                <?php 
			if($gistmaster[$gi]['sVideo'] != ""){
					
				
				$v = 0;
				foreach($vdiList as $vd){
		?>
								<div class="col-lg-12 col-md-12 col-sm-12 white">
                                <?php if(isset($_GET['artist'])){?>
                                <a href="<?php echo URL;?>views/artistvideodetails.php?artist=<?php echo $_GET['artist'];?>&video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>&back=all">
                                <?php }else{?>
                                <a href="<?php echo URL;?>views/artistvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>&back=all">
                                <?php } ?>
                                <div class="col-lg-5 col-md-5 col-sm-5 p0 overflow">
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
                    
                    <img src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
					<div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                    
                    <?php } }else{ ?>
                    <?php /*?><video width="400" class="img-responsive center-block">
                      <source src="<?php echo URL;?>upload/artist/video/group/<?php echo $vd;?>" type="video/mp4">
                    </video><?php */
						if ( $vdiImage[$v] != "" ) {
					 ?>
                    
                    <img src="<?php echo URL;?>upload/artist/video/group/<?php echo $vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
					<div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
					<?php }} ?>
									 <?php /*?><video width="400" height="150" class="img-responsive" style="height:150px;">
                                        <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                                    </video><?php */?>
</div>

<div class="col-lg-7 col-md-7 col-sm-7 p0">
 			<?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['artist']." AND sVideoName = '".$vdiName[$v]."'");			
			}else{
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");		
			}
			
			$videoReview = $obj->fetchRow("videomaster","sVideoName = '".$vd."'");
			
			?>
        	<span id="loadlogin"></span>
            <p style="margin-left:10px; margin-bottom: 4px;word-break: break-all;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></p>
            <!--<p style="margin-left:10px; margin-bottom: 4px;">
			<?php 
			if ( $usermaster['sGroupType'] == 'group' ) { 
					echo ucwords($usermaster['sGropName']);	
				} else { 
					echo ucwords($userRow['sFirstName'].' '.$userRow['sLastName']);
				}
			?></p>-->
            <p style="margin-left:10px; margin-bottom: 4px; ">View : <?php if( $videoReview['iViews'] != ''){echo $videoReview['iViews'];}else{ echo '0';}?> </p>
			<p class="tital1" style="margin-left: 10px;">Days Ago : 
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
                      </p>
     </div>                           
</div>                                                  <?php
		
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
					<div class="col-lg-12 col-md-12 col-sm-12 white">
					<div class="col-lg-5 col-md-5 col-sm-5 p0 overflow">
					<?php if(isset($_GET['artist'])){ ?>
                    <a href="<?php echo URL;?>views/artistvideodetails.php?video=&artist=<?php echo $_GET['artist'];?>&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                    <?php }else{?>
                    <a href="<?php echo URL;?>views/artistvideodetails.php?video=&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                    <?php } ?>
                    <div width="400" class="img-responsive center-block" id="msg_url<?php echo $yu;?>"></div>
                    <?php /*?><iframe width="116" height="100" src="https://www.youtube.com/embed/<?php echo $filename; ?>" controls="0" autoplay="0" ></iframe><?php*/?>
                   
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
                    <script language="javascript" type="text/javascript">
$(function() {
	
	var ytl = '<?php echo $key;?>';
        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        $("#msg_url<?php echo $yu;?>").html("<p><img src=\"http://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg\" class=\"img-responsive center-block\" /></p>");

 	
	
});

</script> 
</div>
<div class="col-lg-7 col-md-7 col-sm-7 p0">
 			<?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['artist']." AND sVideoName = '".$vdiName[$v]."'");			
			}else{
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");		
			}
			
			$videoReview = $obj->fetchRow("videomaster","sVideoName = '".$vd."'");
			
			?>
        	<span id="loadlogin"></span>
            <p style="margin-left:10px; margin-bottom: 4px;word-break: break-all;" id="uname<?php echo $yu;?>"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></p>
            <!--<p style="margin-left:10px; margin-bottom: 4px;"><?php 
			if ( $usermaster['sGroupType'] == 'group' ) { 
					echo ucwords($usermaster['sGropName']);	
				} else { 
					echo ucwords($userRow['sFirstName'].' '.$userRow['sLastName']);
				}
			?>
			</p>-->
            <p style="margin-left:10px; margin-bottom: 4px; " id="Uviews<?php echo $yu;?>"><?php if( $videoReview['iViews'] != ''){echo $videoReview['iViews'];}else{ echo '0';}?> View</p>
			<p class="tital1" id="uDate<?php echo $yu;?>" style="margin-left: 10px;"></p>
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
			$("#uname<?php echo $yu;?>").text(uname.substr(0,12));
			$("#Uviews<?php echo $yu;?>").text("Views : "+data.items[0].statistics.viewCount);

			var pdate = data.items[0].snippet.publishedAt.substr(0,10);
			
			var dateAr = pdate.split('-');
			var newDate = dateAr[1] + '-' + dateAr[2] + '-' + dateAr[0];
			var days = daydiff(parseDate(newDate), parseDate(strDate));
			
			if ( days > 31) {
				days = days / 30;
				days = "Month Ago : "+(Math.round(days));
			} else if ( days > 365 ) {
				days = days / 365;
				days = "Year Ago : "+(Math.round(days));
			}else {
				days = "Days Ago : "+(Math.round(days));
			}
				
			$("#uDate<?php echo $yu;?>").text( days );
			
			//$("<li></li>").text("Published at: " + data.items[0].snippet.publishedAt).appendTo("#video-data-2");
			//$("<li></li>").text("View count: " + data.items[0].statistics.viewCount).appendTo("#video-data-2");
			//$("<li></li>").text("Like count: " + data.items[0].statistics.likeCount).appendTo("#video-data-2");
			//$("<li></li>").text("Dislike count: " + data.items[0].statistics.dislikeCount).appendTo("#video-data-2");
		});
	
});

</script>
                
                <?php $yu ++;
				 	}
				}
			
		} ?>
                            
                        <?php 
			}
	}?>
                   
                

  </div>
      </div>
      </div>
</div>
</div>
<?php
if(isset($_POST['btn_sub'])){

	
	/*$views = $obj->fetchRow("videomaster","sVideoName = '".$_GET['video']."' AND iLoginID = ".$objsession->get('gs_login_id'));
	if(!empty($views)){
		$view = $views['iViews'] + 1;
	}else{
		$view = 1;	
	}*/
	
		$objsession->set('gs_msg',"Comment addes successfully");	
		if(isset($_GET['artist']))	{
			$ids = 0;
			if($objsession->get('gs_login_id') == 0 || $objsession->get('gs_login_id') == '')	{
				$ids = $_GET['artist'];
			}else{
				$ids = $objsession->get('gs_login_id');
			}
			$field = array("iLoginID","sVideoName","sComment","iReview","dCreatedDate");
			$value = array($ids,$_GET['video'],$_POST['comment'],$_POST['rate'],date("Y-m-d"));		
			$obj->insert($field,$value,"videocomments");
		
			redirect(URL.'views/artistvideodetails.php?artist='.$_GET['artist'].'&video='.$_GET['video']."&cat=".$_GET['cat']);
		}else{
			
			$field = array("iLoginID","sVideoName","sComment","iReview","dCreatedDate");
			$value = array($objsession->get('gs_login_id'),$_GET['video'],$_POST['comment'],$_POST['rate'],date("Y-m-d"));	
				
			$obj->insert($field,$value,"videocomments");
		
			redirect(URL.'views/artistvideodetails.php?video='.$_GET['video']."&youtube=".$_GET['youtube']."&cat=".$_GET['cat']);	
		}
}	
if(isset($_GET['iCommentID'])){
		
	if($obj->delete('videocomments',"iCommentID = ".$_GET['iCommentID']) == true){
		$objsession->set('gs_msg','Comment successfully deleted.');	
		redirect(URL.'views/artistvideodetails.php?video='.$_GET['video']."&artist=".$_GET['artist']."&youtube=".$_GET['youtube']."&cat=".$_GET['cat']);	
	}
		
}
?>

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
<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>