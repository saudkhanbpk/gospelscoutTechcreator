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
<?php
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

?>
<div class="container1">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
  
  <h3 style="margin:15px 0; color:#8e44ad; font-size:20px; font-weight:bold;">
        <?php 
		echo ucfirst($userRow['sChurchName']);
		?>
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


if(isset($_GET['church']) > 0){
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['church']);
$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['church']." AND sMinistrieName = '".$_GET['cat']."'");
}else{
$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id')." AND sMinistrieName = '".$_GET['cat']."'");
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));
}
?> 
    
  </div>
</div>
<div class="carousel-holder">
<div class="container1">
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
    <div class="container1">
   <div class="col-lg-3 col-md-3 col-sm-3 p0">  
  	<div class="profile">
    	<img src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/church/<?php echo $userRow['sProfileName'];}else{?>img/profile.jpg<?php }?>" class="img-responsive center-block hight">
  	</div>
  </div>
  
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
<ul class="nav nav-tabs" role="tablist">
<?php 
		if(isset($_GET['back'])){
			
			if(isset($_GET['church'])){
				$url = 'viewallchurchvideo?categoryname='.$_GET['cat']."&church=".$_GET['church'];
			}else{
				$url = 'viewallchurchvideo?categoryname='.$_GET['cat'];
			}
			
		}else{
			if(isset($_GET['church'])){
				$url = 'churchprofile?church='.$_GET['church'];
			}else{
				$url = 'churchprofile';
			}
		}
?>

  <a href="<?php echo URL.$url;?>" class="back">Back</a>
</ul>

<!-- Tab panes --> 
<div class="col-lg-8 col-md-8 col-sm-8"> 
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="profile">
  
  <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
<?php /*?>  <h3 style="float:left;">Church-<?php echo ucfirst($objsession->get('gs_user_name'));?>-<?php echo ucwords(str_replace('_',' ',$_GET['cat']));?></h3><?php */?>
  	
    <?php
		if(count($gistmaster) > 0){
			$vid = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
	?>
    <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
   <form name="frmVideo" id="frmVideo" method="post">
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
  <source src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.$vd;?>" type="video/mp4">
</video>

 			<?php
			if(isset($_GET['church'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['church']." AND sVideoName = '".$vdiName[$v]."'");
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
                <img width="50" height="50" src="<?php echo URL;?>upload/church/<?php echo $userRow['sProfileName'];?>" />                
                </div>
                <div class="col-lg-4 col-mg-4 col-sm-4">
                <?php echo $userRow['sUserName'];?>
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
            	<a class="back" style="margin:8px -9px;cursor:pointer;" onclick="check();" id="subVideo"><?php if(count($vs) > 0){?>Un Subscribe<?php }else{?>Subscribe<?php } ?></a>
                </div>
                <?php } ?>
                </div>
                
                <div class="col-lg-6 col-mg-6 col-sm-6 text-right">  
               <?php 
			   $review = 0;
			   $videocountReview = $obj->fetchRowAll("videocomments","sVideoName = '".$_GET['video']."'");
			   for($r=0;$r<count($videocountReview);$r++){
							$review += $videocountReview[$r]['iReview'];
			   }
			   echo $review;
			   ?> Views
               </div>
               
                <?php } ?>
            </div>
            <div class="clear"></div>
            
            <hr />
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
        <label for="firstname" class="control-label">Rate this video</label>
          <input type="number" class="form-control" name="rate" id="rate" min="1" max="5">
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 mb10">
    	<div class="form-group">
        <div class="col-lg-8">
          <input type="submit" class="form-control" name="btn_sub" value="POST">
        </div>
      </div>
    </div>
    
        <?php
					}
		$v ++;
		$vid ++;
				}
			}
		?>
         <?php
	if(count($videocountReview)){
		for($vi=0;$vi<count($videocountReview);$vi++){
			$cond = "iLoginID = ".$videocountReview[$vi]['iLoginID'];
			$comentuser = $obj->fetchRow("usermaster",$cond);
	?>    
    <div class="row">
    	<div class="form-group">
    		<div class="col-lg-2 col-mg-2 col-sm-2">                
                <img width="50" height="50" src="<?php echo URL;?>upload/church/<?php echo $comentuser['sProfileName'];?>" />            </div>
        	<div class="col-lg-4 col-mg-4 col-sm-4">
                <?php echo $comentuser['sUserName'];?>
                
            <p><?php echo $videocountReview[$vi]['sComment'];?></p>
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
    </div>
    </div>
    <?php 	
		}
	}
	?>
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
<div class="col-lg-4 col-md-4 col-sm-4 p0">
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
     <div class="col-lg-5 col-md-5 col-sm-5 p0 overflow col-xs-6">
<a href="<?php echo URL;?>views/churchvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
        <video width="120" controls class="img-responsive">
  <source src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.$vd;?>" type="video/mp4">
</video>
</a>
</div>
<div class="col-lg-7 col-md-7 col-sm-7 p0 col-xs-6">
			<?php
			if(isset($_GET['church'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['church']." AND sVideoName = '".$vdiName[$v]."'");
			$videocountAll = $obj->fetchRowAll("videomaster","sVideoName = '".$_GET['video']."'");
			}else{
			$videocountAll = $obj->fetchRowAll("videomaster","sVideoName = '".$_GET['video']."'");
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");
			}
			?>
            
 			<?php
			
			?>
        	<span id="loadlogin"></span>
            <p style="margin-left:10px; margin-bottom: 4px;"><?php echo $vdiName[$v];?></p>
            <p style="margin-left:10px; margin-bottom: 4px;"><?php echo $objsession->get('gs_user_name');?></p>
            <p style="margin-left:10px; margin-bottom: 4px; "><?php echo $vcnt;?> View</p>
     </div>
     <div class="clear"></div>
     </div>
        <?php }
					
				}
			}
			$vcnt = 0;
			}
		}
		?>
</div>
  </div>
      </div>
<?php
if(isset($_POST['btn_sub'])){

//	$views = $obj->fetchRow("videomaster","sVideoName = '".$_GET['video']."' AND iLoginID = ".$objsession->get('gs_login_id'));
		//$view = 1;	
	
		$objsession->set('gs_msg',"Comment addes successfully");	
		if(isset($_GET['church']))	{
			$ids = 0;
			if($objsession->get('gs_login_id') == 0 || $objsession->get('gs_login_id') == '')	{
				$ids = $_GET['artist'];
			}else{
				$ids = $objsession->get('gs_login_id');
			}
			$field = array("iLoginID","sVideoName","sComment","iReview","dCreatedDate");
			$value = array($ids,$_GET['video'],$_POST['comment'],$_POST['rate'],date("Y-m-d"));		
			$obj->insert($field,$value,"videocomments");
		
			redirect(URL.'views/churchvideodetails.php?church='.$_GET['church'].'&video='.$_GET['video']."&cat=".$_GET['cat']);
		}else{
			
			$field = array("iLoginID","sVideoName","sComment","iReview","dCreatedDate");
			$value = array($objsession->get('gs_login_id'),$_GET['video'],$_POST['comment'],$_POST['rate'],date("Y-m-d"));	
				
			$obj->insert($field,$value,"videocomments");
		
			redirect(URL.'views/churchvideodetails.php?video='.$_GET['video']."&cat=".$_GET['cat']);	
		}
}	
?>
<?php include('../include/footer.php');?>