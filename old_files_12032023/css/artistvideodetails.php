<?php include('../include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">


<!--Video ratting section start-->
<link href="<?php echo URL;?>css/rating.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating.js"></script>

<?php
	
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
		
}
?>

<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '0',
        callbackFunctionName: '',
        imageDirectory: 'img/',
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
		$rollmaster = $obj->fetchRow("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
		$rollmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
	}
}else{
	if(isset($_GET['artist']) > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['artist'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
		$rollmaster = $obj->fetchRow("churchministrie","iLoginID = ".$_GET['artist']);
		$rollmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['artist']);
	}	
	
}

?>
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
  
  <h3 style="margin:15px 0; color:#8e44ad; font-size:20px; font-weight:bold;"><?php 
		echo $userRow['sFirstName'].' '.$userRow['sLastName'];	
		?></h3> 
        
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
<div class="carousel-holder">
<div class="container">
                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" ></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="../img/slider01.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="../img/slider2.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="../img/slider3.jpg" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
</div>
  </div>
  
  <div class="bg">
    <div class="container">
   <div class="col-lg-3 col-md-3 col-sm-3 p0">  
  	<div class="profile">
    	<img src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];}else{?>../img/profile.jpg<?php }?>" class="img-responsive center-block hight">
  	</div>
  </div>
 
<ul class="nav nav-tabs" role="tablist">
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

  <a href="<?php echo URL.$url;?>" class="back">Back</a>
</ul>

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
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
	?>
    <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
<!--   <form name="frmVideo" id="frmVideo" method="post">-->
    	<div class="video_sec">
        <?php /*?><h3 style="float:left;">Church-<?php echo ucfirst($objsession->get('gs_user_name'));?>-<?php echo ucwords(str_replace('_',' ',$gistmaster[$gi]['sMinistrieName']));?></h3><?php */?>
    	</div>        
        <div class="" style="clear:both;"></div>
    	<?php 
			if($gistmaster[$gi]['sVideo'] != ""){
				
				$v = 0;
				foreach($vdiList as $vd){
					if($vd == $_GET['video']){
		?>
        <div class="col-lg-12 col-mg-12 col-sm-12">        
        <video width="800" controls class="img-responsive center-block hight">
  <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
</video>

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
                <?php echo ucwords($userRow['sFirstName'].' '.$userRow['sLastName']);?>
                <p class="tital1">
			<?php	
			if($gistmaster[$gi]['dCreatedDate'] != "")		{
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($gistmaster[$gi]['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				echo $numberDays = intval($numberDays);
			}else{
				echo '0';	
			}

			?> days Ago</p>
            	
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
            	<a class="back" style="margin:18px  -9px;cursor:pointer;" id="subVideo"><?php if(count($vs) > 0){?>Un Subscribe<?php }else{?>Subscribe<?php } ?></a>
                </div>
                <?php } ?>
                </div>
                
                <div class="col-lg-6 col-mg-6 col-sm-6">  
               <?php 
			   $review = 0;
			   $videocountReview = $obj->fetchRow("videomaster","sVideoName = '".$_GET['video']."'");
			   
			   echo $videocountReview['iViews'];
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
			
			if(isset($_GET['artist']))	{
			
			$ids = 0;
			
			if($objsession->get('gs_login_id') == 0 || $objsession->get('gs_login_id') == '')	{
				$ids = $_GET['artist'];
			}else{
				$ids = $objsession->get('gs_login_id');
			}
			
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
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">
        <div class="col-lg-8">
          <input type="text" class="form-control" id="comment" name="comment" placeholder="Comments">
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">        
        <div class="col-lg-8">
        <label for="firstname" class="control-label">Rate this video</label><br />
         <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">
        <div class="col-lg-8">
        <button class="form-control" onclick="postdata()" name="btn_sub">POST</button>
          <?php /*?><input type="submit" class="form-control" name="btn_sub" value="POST"><?php */?>
        </div>
      </div>
    </div>
    </div>
    <script>
				function postdata(){

		//  e.preventDefault();	  
		
		var comment = $('#comment').val();
		var rating_star = $('#rating_star').val();
		
		if(comment == ""){
			alert('Please enter comment name');
			return false;	
		}else{
		  $.ajax({
			type: 'post',
			url: '<?php echo URL;?>views/insertpostartist.php?comment='+comment+'&loginid=<?php echo $ids;?>&videoname=<?php echo $_GET['video'];?>&cat=<?php echo $_GET['cat'];?>&rating='+rating_star,
			data: '',
			success: function (data) {	
			$('#comment').val('');	  
				$('#cm').html(data);			  
			}
		  }); 
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
			$comentuser = $obj->fetchRow("usermaster",$cond);
	?> 
    
    <script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star1<?php echo $vi;?>").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $videocountReview[$vi]['iReview'];?>',
        callbackFunctionName: "",
        imageDirectory: "img/",
      //  inputAttr: 'postID'
    });
});

</script>
   
    <div class="col-lg-12 col-md-12 col-sm-12 p0 mb10">
    	<div class="form-group">
    		<div class="col-lg-2 col-mg-2 col-sm-2">                
                <img width="50" height="50" src="<?php echo URL;?>upload/artist/<?php echo $comentuser['sProfileName'];?>" />            </div>
        	
            <div class="col-lg-4 col-mg-4 col-sm-4">
                <?php echo $comentuser['sUserName'];?>
                
            <p><?php echo $videocountReview[$vi]['sComment'];?></p>
            <p><input name="rating_star1" value="0" id="rating_star1<?php echo $vi;?>" type="hidden" postID="0" /></p>
            
                </div>   
                <div class="col-lg-4 col-mg-4 col-sm-4">
                
                <p class="tital1">
			<?php	
			if($videocountReview[$vi]['dCreatedDate'] != "")		{
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($videocountReview[$vi]['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				echo $numberDays = intval($numberDays);
			}else{
				echo '0';	
			}

			?> days Ago</p>
            
            
            </div> 
              <?php
		if($videocountReview[$vi]['iLoginID'] == $objsession->get('gs_login_id')){
		?>
        <div class="col-lg-2 col-mg-2 col-sm-2">
                <a href="<?php echo URL;?>views/artistvideodetails.php?video=<?php echo $_GET['video'];?>&cat=<?php echo $_GET['cat'];?>&iCommentID=<?php echo $videocountReview[$vi]['iCommentID'];?>" onclick="return confirm('Are you sure want to delete?');">Delete</a>
        </div>
        <?php } ?>
               
        </div>
    </div>
    <?php 	
		}
	}
	?>
    
<!--    </form>-->

    <?php 
			}
	}else{
		
		echo "<h3>This Artist Has No Videos Uploaded </h3>";		}?>
   </div>
  </div>
  </div>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4">
	<?php
		if(count($gistmaster) > 0){
			$vid = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				
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
				
				$v = 0;
				foreach($vdiList as $vd){
					if($vid < 8){
		?>
<div class="col-lg-12 col-md-12 col-sm-12 white">
	<div class="col-lg-5 col-md-5 col-sm-5 p0 overflow">
        <a href="<?php echo URL;?>views/artistvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
        <video width="120" height="50" controls class="img-responsive center-block hight">
        	<source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
        </video>
        </a>
	</div>
    <div class="col-lg-7 col-md-7 col-sm-7 p0">
 			<?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['artist']." AND sVideoName = '".$vdiName[$v]."'");			
			}else{
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");		
			}
			?>
        	<span id="loadlogin"></span>
            <p style="margin-left:10px; margin-bottom: 4px;"><?php echo $vdiName[$v];?></p>
            <p style="margin-left:10px; margin-bottom: 4px;"><?php echo $objsession->get('gs_user_name');?></p>
            <p style="margin-left:10px; margin-bottom: 4px; "><?php echo $vcnt;?> View</p>
     </div>
     </div>
        <?php }
					
				}
			}
			$v ++;
		$vid ++;
			}
		}
		?>
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
		
			redirect(URL.'views/artistvideodetails.php?video='.$_GET['video']."&cat=".$_GET['cat']);	
		}
}	
if(isset($_GET['iCommentID'])){
		
	if($obj->delete('videocomments',"iCommentID = ".$_GET['iCommentID']) == true){
		$objsession->set('gs_msg','Comment successfully deleted.');	
		redirect(URL.'views/artistvideodetails.php?video='.$_GET['video']."&cat=".$_GET['cat']);	
	}
		
}
?>
<?php include('../include/footer.php');?>