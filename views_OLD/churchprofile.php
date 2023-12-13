<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>
<script type="text/javascript" src="<?php echo URL;?>js/rating.js"></script>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" media="all" href="<?php echo URL;?>css/magnific-popup.css">
  <script type="text/javascript" src="<?php echo URL;?>js/jquery.magnific-popup.min.js"></script>
<script>
$(document).ready(function(){
	
	$('#stateId').on('change', function (e) {
		
			  $('#cityId').html('');
			  var stateId = $('#stateId').val();
			  e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea.php?type=city&iStateID='+stateId,
				//data: formData,
				success: function (data) {
				  if(data == 'Please select state'){
					 $('#cityId').html("<option value=''>Select City</option>");
				  }else{
					 $('#cityId').html(data);
				  }
				}
			  });
		});
		
	        $('#menu11').show();
	
    $("#photo").change(function(){
		//alert('ff');
		var id = $(this).children(":selected").attr("id");
		
		if(id == 'menu1'){
			$('#menu11').show();
			$('#menu22').hide();
			$('#menu33').hide();
			$('#menu44').hide();
		}
		
		if(id == 'menu2'){
			 $('#menu22').show();
			$('#menu11').hide();
			$('#menu33').hide();
			$('#menu44').hide();
		}
		
		if(id == 'menu3'){
			$('#menu33').show();
			$('#menu22').hide();
			$('#menu11').hide();
			$('#menu44').hide();
		}
		
		if(id == 'menu4'){
			$('#menu44').show();
			$('#menu33').hide();
			$('#menu22').hide();
			$('#menu11').hide();
		}
		
		
    });
	
	   
});
</script>
<style>
iframe {
	width:100%;	
}
</style>
<?php 
$states = $obj->fetchRowAll("states",'country_id = 231');
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypal_id='maulik@omshantiinfotech.com';
	

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
	
$citymaster = $obj->fetchRow("cities","id = ".$userRow['sCityName']);
$sortname = $obj->fetchRow("states","id = ".$userRow['sStateName']);
	
?>
<link href="<?php echo URL;?>css/rating-1.css" rel="stylesheet" type="text/css">
                    <script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <h3 style="margin:15px 0; color:#8e44ad; font-size:20px; font-weight:bold;">
      <?php 
		echo ucwords(strtolower($userRow['sChurchName']));
		?>
    </h3>
  </div>
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


if(isset($_GET['church']) > 0){
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['church']);
$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['church']);
}else{
$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));
}

$amenitimaster = $obj->fetchRowAll("amenitimaster","1=1");


?>
  </div>
</div>
<div class="carousel-holder">
  <div class="container">
    <div class="col-md-12">
                <?php include_once "bannerlist.php";?>
    </div>
  </div>
</div>
<div class="bg">
  <div class="container">
    <div class="col-lg-3 col-md-3 col-sm-3 p0">
      <div class="profile"> <img style="height:235px;border: 2px solid rgb(142,68,173);" src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/church/<?php echo $userRow['sProfileName'];}else{?>img/profile.jpg<?php }?>" class="img-responsive center-block"> </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item collaps active"> <a class="nav-link" href="#profile" role="tab" data-toggle="tab">Video<!--<img style="margin-top:3px; float:right; width:25%;" src="../img/menu-video-play.png">--></a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Photos<!--<img style="margin-top:3px; float:right; width:20%;" src="../img/menu-photos.png">--></a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#references" role="tab" data-toggle="tab">About<!--<img style="margin-top:3px; float:right; width:20%;" src="../img/menu-about.png">--></a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#pdf" role="tab" data-toggle="tab">Give<!--<img style="margin-top:3px; float:right; width:30%;" src="../img/menu-give.png">--></a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#subscribe" role="tab" data-toggle="tab">Subscribe<!--<img style="margin-top:3px; float:right; width:18%;" src="../img/menu-subscribe.png">--></a> </li>
    </ul>
    
    <!-- Tab panes -->
    
    <?php
$services = '';

if(count($churchtimeing) > 0){
	for($ser=0;$ser<count($churchtimeing);$ser++){	
		
		if( $churchtimeing[$ser]['iHour'] > 0){
			$hour = $churchtimeing[$ser]['iHour'];
		}else{
			$hour = '01';
		}
				
		$services .= $churchtimeing[$ser]['sTitle'].' '.$hour.":".str_pad($churchtimeing[$ser]['iMinute'],2,'0',STR_PAD_LEFT)."<span style='text-transform:lowercase;color:#8e44ad !important;'>".strtolower($churchtimeing[$ser]['ampm'])."</span>\r\n";
	}
}
?>
    <div class="col-lg-4 col-md-4 col-sm-4 p0">
      <div class="white">
        <h3 class="text-left">Church info</h3>
        <div class="col-md-5 p0 col-xs-6">
          <p><b>Pastor : </b></p>
        </div>
        <div class="col-md-7 p0 col-xs-6">
          <p>
            <?php if($userRow['sPastorName'] != '')echo ucfirst($userRow['sPastorName']);?>
          </p>
        </div>
        <!--<p><b>Denomination : </b> <?php if($userRow['sDenomination'] != '')echo ucwords(str_replace('_'," ",$userRow['sDenomination']));?></p>-->
        <div class="clear"></div>
        <div class="col-md-5 p0 col-xs-6">
          <p><b>Location : </b></p>
        </div>
        <div class="col-md-7 p0 col-xs-6">
          <p style="word-break: break-all;">
            <?php if($userRow['sAddress'] != '')echo ucwords($userRow['sAddress']);?>
            ,
            <?php if($citymaster['name'] != '') echo ucwords($citymaster['name']);?>
            ,
            <?php if($sortname['statecode'] != '') echo ucwords($sortname['statecode']);?>
            <?php if($userRow['iZipcode'] != '') echo $userRow['iZipcode'];?>
          </p>
        </div>
        <div class="clear"></div>
        <div class="col-md-5 p0 col-xs-6">
          <p><b>Services : </b></p>
        </div>
        <div class="col-md-7 p0 col-xs-6">
          <p>
            <?php if($services != '')echo ucwords(nl2br($services));?>
          </p>
        </div>
        <div class="clear"></div>
        <div class="col-md-5 p0 col-xs-6">
          <p ><b>Website : </b></p>
        </div>
        <div class="col-md-7 p0 col-xs-6">
          <p style="word-break: break-all;">
            <?php if($userRow['sChurchUrl'] != '')echo $userRow['sChurchUrl'];?>
          </p>
        </div>
        <div class="clear"></div>
        <div class="col-md-5 p0 col-xs-6">
          <p><b>Denomination:</b></p>
        </div>
        <div class="col-md-7 p0 col-xs-6">
          <p>
            <?php
                                    if($userRow['sDenomination'] != ''){
                                    	echo ucwords(str_replace('_',' ',$userRow['sDenomination']));
                                    }else{
										echo '---';	
									}
                                    ?>
          <p> 
        </div>
        <div class="clear"></div>
        <div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Contact Number:</b></p>
          </div>
          <div class="col-md-6 col-xs-6">
            <p style="word-break: break-all;">
              <?php if($userRow['sContactNumber'] != ''){echo $userRow['sContactNumber'];}else{echo '---';}?>
            </p>
          </div>
        </div>
        <div class="clear"></div>
        <div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Contact Email:</b></p>
          </div>
          <div class="col-md-6 col-xs-6">
            <p style="word-break: break-all;">
              <?php if($userRow['sContactEmailID'] != ''){echo $userRow['sContactEmailID'];}else{echo '---';}?>
            </p>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
      <?php   
				
				if( isset($_GET['church']) == ''){
					$iChurchID = $objsession->get('gs_login_id');	
				}else{ 
					$iChurchID = $_GET['church'];	
				}
				$cond="doe >= '".date('Y-m-d')."' AND (iLoginID = ".$iChurchID." OR FIND_IN_SET('".$iChurchID."',iIDs)) ORDER BY doe ASC LIMIT 1";	
				$rolemaster = $obj->fetchRow("eventmaster",$cond);
				$siddhant=(explode(",",$rolemaster['sMultiImage'])); 
								
			?>
      <div class="white">
        <h3 class="text-center">Upcoming Events</h3>
        <?php if ( !empty($rolemaster) ) { ?>
        <div class="events">
          <div class="width25"> <img src="<?php echo URL;?>upload/event/multiple/<?php echo $siddhant[0];?>" width="50px" height="50px"> </div>
          <div class="width83">
            <h5><b><?php echo $rolemaster['event_name'];?></b></h5>
            <h5><?php echo date('M d, Y',strtotime($rolemaster['doe']));?></h5>
            <h5><?php echo date('H:i',strtotime($rolemaster['toe']));?></h5>
            <a href="<?php echo URL;?>views/eventdetail.php?event=<?php echo $rolemaster['e_id'];?>"/>
            <input type="button" class="btn btn-primary info width37" value="Get Info">
            </a> </div>
        </div>
        <h4><a href="<?php echo URL;?>views/eventdisplay.php">View Full Event Calendar <i class="fa fa-calendar"></i></a></h4>
        <?php } else { ?>
        <p class="noevent">Church has no upcomming events.</p>
		<h4><a href="<?php echo URL;?>views/eventdisplay.php">View Full Event Calendar <i class="fa fa-calendar"></i></a></h4>
        <?php } ?>
      </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="profile">
          <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
            <h3>Videos</h3>
            <?php
		if(count($gistmaster) > 0){
			$vid = 0;
			$vUR = 0;
			$vR = 1;
			$vdCheck = '';
			$yu = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				$vdiImage = explode(',',$gistmaster[$gi]['sVideoNameImage']);
				
				//$vdiList = array_reverse($vdiList);
				
				if( ( $gistmaster[$gi]['sVideo'] == "" && $vdCheck == "" ) ){
					if ( $gistmaster[$gi]['sUrl'] != "" ) {
						$vdCheck = 'test';
					} else {
						$vdCheck = '';
					}
				}else{
					$vdCheck = 'test';
				}
				
	?>
            <div class="row <?php if($gistmaster[$gi]['sVideo'] != "" || $gistmaster[$gi]['sUrl'] != ""){?>borderbuttom<?php } ?>">
              <form name="frmVideo" id="frmVideo">
                <?php if($vdCheck != ""){ ?>
                <div class="video_sec">
                  <?php if ( $gistmaster[$gi]['sVideo'] != "" || $gistmaster[$gi]['sUrl'] != "") {?>
                  <h3 style="float:left;"><?php echo ucwords(str_replace('_',' ',$gistmaster[$gi]['sMinistrieName']));?></h3>
                  <?php
								}
								
		if(isset($_GET['church'])){
			$url = "?categoryname=".$gistmaster[$gi]['sMinistrieName']."&church=".$_GET['church'];
		}else{
			$url = "?categoryname=".$gistmaster[$gi]['sMinistrieName'];
		}
		
		if ( $gistmaster[$gi]['sVideo'] != "" || $gistmaster[$gi]['sUrl'] != "") {
		?>
                  <a href="<?php echo URL;?>views/viewallchurchvideo.php<?php echo $url;?>" style="float:right;">View All</a>
                  <?php } ?>
                </div>
                <div class="" style="clear:both;"></div>
                <?php 
			if($gistmaster[$gi]['sVideo'] != ""){
				
				$v = 0;
				//echo "<pre>";
				//print_r($vdiList);

				$count1 = 0;
				foreach($vdiList as $vd){
					$count1 ++;
					if($vid < 4){
					
						
		?>
                <div class="col-lg-3 col-mg-3 col-sm-3">
                  <?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
								?>
                  <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/churchprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sMinistrieName'];?>&type=video&videName=<?php echo $vdiName[$v];?>&image=<?php echo $vdiImage[$v];?>&name=<?php echo $vd;?>&main=church">X</a></div>
                  <?php } ?>
                  <div style="margin-top: 20px;">
                    <?php if(isset($_GET['church'])){?>
                    <a href="<?php echo URL;?>views/churchvideodetails.php?church=<?php echo $_GET['church'];?>&video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                    <?php }else{?>
                    <a href="<?php echo URL;?>views/churchvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                    <?php } ?>
                    <?php /*?><video width="400" class="img-responsive center-block">
                                        <source src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.$vd;?>" type="video/mp4">                                    </video>	<?php */?>
                    <?php 

					if ( $vdiImage[$v] != "" ) {?>
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
			url: '<?php echo URL;?>views/countvalue01.php?sVideoName='+val,
			data: formData,
			success: function (data) {
			  if(data == 'Please check your video'){
				  $('#loadlogin').html(data);
			  }else{
				window.location = "<?php echo URL;?>views/churchvideodetails.php?video="+val+"&cat="+cat;  
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
	$total = round($retting['average_rating'] / $ratingNum);
}
?>
                    
                    <!--Video ratting section start-->
                     
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
                    <h2 style="color: black; font-weight: bold;">
                      <?php 
				
				$mynqme = pathinfo($vdiName[$v],PATHINFO_FILENAME);
				//echo wordwrap($mynqme,10,"\n",true);
				echo substr($mynqme, 0, 12);
				
			?>
                    </h2>
                    <p class="tital1">Views : 
                      <?php if(!empty($videocount)){echo $videocount['iViews'];}else{echo '0';}?>
                      </p>
                    
                    <input type="hidden" name="sVideoName" id="sVideoName<?php echo $gistmaster[$gi]['iChurchID'];?>" value="<?php echo $vdiList[$v];?>" />
                    <input type="hidden" name="cat" id="cat<?php echo $gistmaster[$gi]['iChurchID'];?>" value="<?php echo $gistmaster[$gi]['sMinistrieName'];?>" />
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
                    </a> </div>
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
				
				$count=0;
					
				$youtube = explode(',',$gistmaster[$gi]['sUrl']);
				
				foreach ( $youtube as $key ) {

							

					$count++;
					if($gistmaster[$gi]['sVideo'] != "")
					{
					$new=$count1 + $count; 	
					}
					else
					{
					$new= $count;
					} 
					
					if($new <= 4){
					
					$vdCheck = 'test'; 
					
					$filename = substr(strrchr($key, "="), 1);	
					
					if($filename != "")			{		
					$yu ++;
		?>
                <div class="col-lg-3 col-mg-3 col-sm-3">
                  <?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
								?>
                  <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/churchprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sMinistrieName'];?>&type=youtubevideo&videName=<?php echo $key;?>&main=church&iyoutubeid=<?php echo $gistmaster[$gi]['iChurchID']; ?>">X</a></div>
                  <?php }?>
                  <div style="margin-top:20px"> <?php if(isset($_GET['church'])){?>
                    <a href="<?php echo URL;?>views/churchvideodetails.php?video=&church=<?php echo $_GET['church'];?>&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                    <?php }else{?>
                    <a href="<?php echo URL;?>views/churchvideodetails.php?video=&youtube=<?php echo $filename;?>&cat=<?php echo $gistmaster[$gi]['sMinistrieName'];?>">
                    <?php } ?>
                    <div width="400" class="img-responsive center-block" id="msg_url<?php echo $yu;?>"></div>
                    <?php /*?><iframe width="116" height="100" src="https://www.youtube.com/embed/<?php echo $filename; ?>" ></iframe><?php */?>
                  
<?php
	
$cond = "sVideoName = '".$filename."' AND status = 1";
$retting = $obj->fetchAverageTotal('videoratting','iTotalPoint',$cond);
$ratingNum = $obj->fetchNumOfRow('videoratting',$cond);
$total = 0;

if($ratingNum > 0){
	$total = round($retting['average_rating'] / $ratingNum);
}

?>
                    
                    <!--Video ratting section start--> 
                    <script type="text/javascript">
$(function() {
	
	var ytl = '<?php echo $key;?>';
        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        $("#msg_url<?php echo $yu;?>").html("<p><img src=\"http://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg\" class=\"img-responsive center-block\" /></p>");
		
    $("#rating_star01<?php echo $yu;?>").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $total;?>',
        callbackFunctionName: 'processRating',
        imageDirectory: '<?php echo URL;?>img/',
        inputAttr: 'postID'
    });
});

function processRating(val, attrVal){
    $.ajax({
        type: 'POST',
        url: '<?php echo URL;?>views/rating.php',
        data: 'postID='+attrVal+'&ratingPoints='+val,
        dataType: 'json',
        success : function(data) {
            if (data.status == 'ok') {
                alert('You have rated '+val+' to CodexWorld');
                $('#avgrat').text(data.average_rating);
                $('#totalrat').text(data.rating_number);
            }else{
                alert('Some problem occured, please try again.');
            }
        }
    });
}

</script>                  
                    <p style="color: black; font-weight: bold;" class="Uname" id="uname<?php echo $yu;?>"></p>
                    <p class="tital1" id="Uviews<?php echo $yu;?>"></p>
                   
                    <p class="tital1" id="uDate<?php echo $yu;?>"></p>
					 <input name="rating" value="0" id="rating_star01<?php echo $yu;?>" type="hidden" />
                    </a> </div>
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
				days ="Days Ago : "+days;
			}
		$("#uDate<?php echo $yu;?>").text( days );
			
		});
	
});

</script>
                <?php }
				
				}
				
				}
			
		} ?>
                <?php } ?>
              </form>
            </div>
            <?php 
			}
		
			if($vdCheck == ''){
				echo '<h3 style="color: #ccc; font-family: v;" class="h3new">This Chruch Has No Videos Uploaded </h3>';	
			}
	}else{
		
		echo '<h3 style="color: #ccc; font-family: v;" class="h3new">This Chruch Has No Videos Uploaded </h3>';		}?>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="buzz">
          <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
            <?php 
  if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
  ?>
            <div class="addnewphoto"> <a style=" background: #9968cf none repeat scroll 0 0;color: #fff;float: right; cursor:pointer; margin-bottom: 10px; padding: 10px;" href="<?php URL;?>managealbum.php">Add New Album</a> </div>
            <?php } ?>
            <div id='cssmenu' class="" style="float: left; width: 185px;">
              <?php
						 if(!empty($albummaster)){
						?>
              <select id="photo">
                <?php 
			 
				  for($a=0;$a<count($albummaster);$a++){
			  ?>
                <option id="menu<?php echo ($a + 1);?>" <?php if($a == 0){?>class="active"<?php } ?>> <?php echo $albummaster[$a]['sAlbumName'];?> </option>
                <?php 
				  }
			  ?>
              </select>
              <?php } ?>
            </div>
            <div style="clear:both;"></div>
            <?php
			
			if(!empty($albummaster)){
				$n = 11;
				$popimg = 1;
				
				  for($a=0;$a<count($albummaster);$a++){
					  $gallerymaster = $obj->fetchRowAll("gallerymaster","iAlbumID = ".$albummaster[$a]['iAlbumID']." ORDER BY iGalleryID DESC");
					?>
            <div id="menu<?php echo $n;?>" <?php if($a != 0){?> style="display:none;"<?php } ?>>
              <?php
					  for($ga=0;$ga<count($gallerymaster);$ga++){
					?>
              <div class="col-lg-4 col-mg-4 col-sm-4">
                <?php 
							if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
							?>
                <a style="float: right; color: red;" onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/churchprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&photo=<?php echo $gallerymaster[$a]['sGalleryImages'];?>&type=album&name=<?php echo $albummaster[$a]['sAlbumName'];?>&galleryID=<?php echo $gallerymaster[$a]['iGalleryID'];?>">X</a>
                <?php }?>
                <style>
#light<?php echo $popimg;?> img {
	width:100%;
}
#fade<?php echo $popimg;?> {
    display: none;
    position: fixed;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index:1001;
    -moz-opacity: 0.7;
    opacity:.70;
    filter: alpha(opacity=70);
}
#light<?php echo $popimg;?> {
  background: #ccc none repeat scroll 0 0;
  border: 2px solid #fff;
  display: none;
/*  height: 200px;8*/
  left: 50%;
  margin-left: -280px;
  margin-top: -398px;
  overflow: visible;
  padding: 10px;
  position: absolute;
  top: 50%;
  width: auto;
  z-index: 1002;
}
</style>
                <script>

function lightbox_open(id){
    window.scrollTo(0,0);
    document.getElementById('light'+id).style.display='block';
    document.getElementById('fade'+id).style.display='block';  
}

function lightbox_close(id){
    document.getElementById('light'+id).style.display='none';
    document.getElementById('fade'+id).style.display='none';
}

</script>
<script type="text/javascript">
$(function(){
  $('#portfolio<?php echo $popimg;?>').magnificPopup({
    delegate: 'a',
    type: 'image',
    image: {
      cursor: null,
      titleSrc: 'title'
    },
    gallery: {
      enabled: true,
      preload: [0,1], // Will preload 0 - before current, and 1 after the current image
      navigateByImgClick: true
		}
  });
});
</script>
                <div id="light<?php echo $popimg;?>"> <img src="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>" /> </div>
                <div id="fade<?php echo $popimg;?>" onClick="lightbox_close(<?php echo $popimg;?>);"></div>
					
				<li id="portfolio<?php echo $popimg;?>" style="display:block;">
                <a href="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>"><img src="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>" class="img-responsive center-block artistphotos"> </a> </li></div>
              <?php 
							 $popimg ++;
					  }
					  
					  
						  
					?>
            </div>
            <?php
					  $n = $n + 11;
				  }
			}else{
				echo '<h3 style="color: #ccc; font-family: v;" class="h3new">This Church Has No Photos Uploaded</h3>';	
			}
			?>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="references">
          <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Church Amenities:</p>
              <h2>
                <ul class="year">
                  <li>
                    <?php
			  $sAmenitis = array(); 
			  if($userRow['sAmenitis'] != ""){
				  $sAmenitis = explode(',',$userRow['sAmenitis']);
			  }
			  ?>
                    <?php
										$noA = 1;
			if(count($amenitimaster) > 0){
				$str = '';
				
				for($c=0;$c<count($amenitimaster);$c++){
					if(in_array($amenitimaster[$c]['iAmityID'],$sAmenitis)){
						
			?>
                  <li style="list-style:none;margin-left: -40px;word-break: break-all;"><strong style="font-weight: 400;"><?php echo $noA.'.'.ucwords(trim($amenitimaster[$c]['sAmityName']));?></strong></li>
                  <?php
			$noA ++;
					}
					
				}
				//echo ucwords(trim($str,','));
			}else{
				echo '---'	;
			}
			?>
                  <?php 
		if($userRow['sOtherAmenitis'] != ''){
			$sOtherAmenitis = explode(',',$userRow['sOtherAmenitis']);

			foreach($sOtherAmenitis as $mic){
		?>
                  <li style="list-style:none;word-break: break-all;"><strong style="margin-left: -40px; font-weight: 400;"><?php echo $noA.'.'.ucwords(trim($mic));?></strong></li>
                  <?php 
	   	$noA ++;
	   } }?>
                  </li>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Church Ministries:</p>
              <h2>
                <ul class="year">
                  <li >
                    <?php
			if(count($churchministrie) > 0){
				$str = '';
				$n = 1;
				for($c=0;$c<count($churchministrie);$c++){
					$str .= str_replace("_"," ",ucwords($churchministrie[$c]['sMinistrieName'])).',';
				?>
                  <li><strong style="margin-left: -40px;word-break: break-all; font-weight: 400;"><?php echo $n.'.'.ucwords(str_replace("_"," ",$churchministrie[$c]['sMinistrieName']));?></strong></li>
                  <?php
				$n ++;
				}
				//echo ucwords(trim($str,','));
			}else{
				echo '---';	
			}
			?>
                  </li>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Denomination:</p>
              <h2>
                <ul class="year">
                  <li ><strong style="margin-left: -40px;word-break: break-all; font-weight: 400;"> 
                    <?php
                                    if($userRow['sDenomination'] != ''){
                                    	echo str_replace("_"," ",ucwords($userRow['sDenomination']));
                                    }else{
										echo '---';	
									}
                                    ?>
                    </strong> </li>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Mission Statement:</p>
              <h2>
                <ul style="margin-left:-40px;word-break: break-all;" class="year">
                  <li><strong style="font-weight: 400;">
                    <?php if($userRow['sMission'] != ''){echo $userRow['sMission'];}else{echo '---';}?>
                    </strong> </li>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">When church was founded:</p>
              <h2>
                <ul class="year">
                  <li> <strong style="margin-left:-40px;word-break: break-all; font-weight: 400;">
                    <?php if($userRow['sFounderName'] != ''){echo date('M d, Y',strtotime($userRow['sFounderName']));}else{echo '---';}?>
                    </strong> </li>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text">
              <p style="margin-left:-15px; font-size: 14px;">Founding Pastor:</p>
              <h2>
                <ul class="year">
                  <li> <strong style="margin-left:-55px;word-break: break-all; font-weight: 400;">
                    <?php if($userRow['sPastorName'] != ''){echo $userRow['sPastorName'];}else{echo '---';}?>
                    </strong> </li>
                </ul>
              </h2>
            </div>
          </div>
        </div>
        <style>
.loginh2 > p {
  color: #8e44ad;
  margin-bottom: 35px;
  margin-left: 40px;
  margin-top: 27px;
  width: 345px;
}
.txtlable {
  color: #000 !important;
  font-weight: bold;
  margin-left: 70px;
}
.loginh3 > p {
  font-size: 12px;
  margin-bottom: 35px;
  margin-left: 100px;
}
.btn-success_new {
  background-color: #9c69d0;
  border-color: #9c69d0;
  color: #fff;
  float: right;
  padding-bottom: 10px;
  padding-top: 10px;
  width: 45%;
}
.txttitle {
  color: #8e44ad;
  font-size: 20px;
  font-weight: bold;
  padding-top: 20px !important;
}
</style>
        <script>
$().ready(function() {
	
	$(function(){
		$.validator.addMethod('minStrict', function (value, el, param) {
		return value > param;
	});});	
		
});
    
    function ValidationForm()
	{
		var flag = true;
	//$(".next").click(function(){
		
		var form = $("#frmevent");
		
		form.validate({
			ignore: [],  
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {				
				sFirstName: {
					  required:true,
					},
				
				sLastName: "required",				
				eEmailID: {
					  required:true,
					  email:true,
					},
				sAddress: {
					  required:true,
					},
				zipcode: "required",
				iAmountID: {
					  required:true,
					  number:true
					},
				
				
			},

			messages: {
				sFirstName: {
					  required:"Please enter first name",
					},
				
				sLastName: "Please enter last name",				
				eEmailID: {
					  required:"Please enter email",
					  email:"Enter valid email"
					},
				sAddress: {
					  required:"Please enter address",
					},
				zipcode: "Please enter zipcode",
				iAmountID: {
					  required:"Please enter amount",
					  number:"Enter only number"
					},

			},	
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},			
					
		});
		
		if (form.valid() === true){
			$("#callform").click();	
		}
	}
	
    </script>
        <?php 
  if(isset($_POST['btn_submit'])){
	extract($_POST);
	$field = array("iRollID","iLoginID","sFirstName","sLastName","eEmailID","sAddress","iStateID","city","iZipcode","iAmount","sMember","donation","dCreatedDate","sStatus");
		$value = array($_GET['church'],$objsession->get('gs_login_id'),$sFirstName,$sLastName,$eEmailID,$sAddress,$iStateID,$city,$zipcode,$iAmountID,$sMember,$donation,date("Y-m-d"),"Pending");		
	if($obj->insert($field,$value,"churchbooking")){
	
	$objsession->set('gs_total_amount',$iAmountID);
	
	$tax = ($objsession->get('gs_total_amount') * 7 ) / 100;
	if ( $iAmountID > 0 ) {
	
	?>
        <script>
			$(document).ready(function(){
					$( "#frmPayPal1" ).submit();
			});
			
			</script>
        <form action='<?php echo URL."views/churchbooking?paypal=$paypal_id&booked_id=".$_GET['church']?>' method='post' id="frmPayPal1" name='frmPayPal1'>
          <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
          <input type='hidden' name='cmd' value='_xclick'>
          <input type='hidden' name='item_name' value='Event'>
          <input type='hidden' name='item_number' value='1'>
          <input type='hidden' name='amount' id="amount" value="<?php if($objsession->get('gs_total_amount') > 0){echo $objsession->get('gs_total_amount');}?>" >
          <input type='hidden' name='no_shipping' value='1'>
          <input type='hidden' name='currency_code' value='USD'>
          <input type='hidden' name='handling' value='0'>
          <input type="hidden" name="tax" value="<?php echo $tax;?>">
          <input type='hidden' name='cancel_return' value='<?php echo URL."views/churchprofile?type=cancel"; ?>'>
          <input type='hidden' name='return' value='<?php echo URL."views/churchbooking?paypal=$paypal_id&booked_id=".$_GET['church']?>'>
        </form>
        <?php
		//Mona@onshantiinfotech.com
		}else{
			redirect(URL.'views/churchprofile.php');
		}
	}
	
	
	}
  ?>
        <div role="tabpanel" class="tab-pane fade" id="pdf">
          <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
            <?php if($objsession->get('gs_login_id') == 0){?>
            <p style="float:left;">Login required....!! </p>
            <a data-target="#myModal" class="login" data-toggle="modal" href="#">Login</a>
            <?php 	}else { ?>
            <form id="frmevent" role="form" name="frmevent"method="post" enctype="multipart/form-data">
              <div id="myModal01" class="modal fade" role="dialog">
                <div class="modal-dialog"> 
                  
                  <!-- Modal content-->
                  <div class="modal-content" style=" width: 110%;  border: 1px solid #9c69d0;border-radius: 0;background:#ececec;">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="loginh2">
                        <h2 class="txttitle">Thank You For Giving!!! </h2>
                        <p>Thank You for giving through GospelScout.com. Please click continue to move on to the payment portion of the gift submission.</p>
                      </div>
                      <div class="loginh3"> <span class="txtlable">By Clicking Continue I agree that:</span>
                        <p>I have read and accepted the <a target="_blank" href="<?php echo URL;?>views/termsandcondition.php">Terms of Use</a></p>
                      </div>
                      <div class="loginh3">
                        <input type="submit" class="btn btn-success_new col-lg-12" name="btn_submit" value="Continue">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="email">First Name:</label>
                    <input type="text" class="form-control" id="sFirstName" name="sFirstName" >
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="pwd">Last Name:</label>
                    <input type="text" class="form-control" id="sLastName" name="sLastName" >
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="pwd">Email:</label>
                    <input type="text" class="form-control" id="eEmailID" name="eEmailID" >
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="pwd">Address:</label>
                    <input type="text" class="form-control" id="sAddress" name="sAddress" >
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <select name="iStateID" class="form-control states" id="stateId">
                      <option value="">Select State</option>
                      <?php
			if(count($states) > 0){
				for($s=0;$s<count($states);$s++){
			?>
                      <option value="<?php echo $states[$s]['id'];?>"><?php echo $states[$s]['name'];?></option>
                      <?php
				}
			}
			?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <select name="city" class="form-control cities" id="cityId">
                      <option>Select City</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Zip Code">
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="pwd">Donation For:</label>
                    <select class="form-control" id="donation" name="donation" >
                      <option value="">Select donation</option>
                      <option value="Offering">Offering</option>
                      <option value="Tithes">Tithes</option>
                      <option value="Pastor Love Gift">Pastor Love Gift</option>
                      <option value="Donation">Donation</option>
                      <option value="Pledge">Pledge</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <label>Amount Deposited</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <p class="dot">$</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <input type="text" name="iAmountID" id="iAmountID" class="form-control" placeholder="0.00"/>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <input type="radio" checked="checked" name="sMember" value="member"  />
                    Member of Church </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <div class="form-group">
                    <input type="radio" name="sMember" value="visitor"  />
                    Visitor </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-8 col-md-8 col-sm-8"> </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <?php if(isset($_GET['church'])){?>
                  <input class="btn btn-primary " type="button" name="btn_submit_01" id="btn_submit_01" onclick="ValidationForm();" value="Submit">
                  <a href="#" class="btn btn-primary" data-toggle="modal" id="callform" data-target="#myModal01" style="display:none;">Submit</a>
                  <?php }else{ ?>
                  <input class="btn btn-primary " type="submit" name="btn_submit" disabled="disabled" value="Submit">
                  <?php } ?>
                </div>
              </div>
            </form>
            <?php }?>
            <script>
	   $(document).ready(function(){
		   
		   $("#iAmountID").keydown(function(){
			var price = $("#iAmountID").val();
			 $('#amount').val(price);
}); 

		 
		   });
	   </script> 
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subscribe">
          <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
            <?php if(isset($_GET['church'])){
		  
	?>
            <script>$().ready(function() {
	
	function ValidateEmail(email) {
var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
return expr.test(email);
};

$('#subscribe005').on('click', function (e) {

		  if($('#subscriberemail').val() == ''){
			  $('#subscriberemail-error').html("Please enter email");
		  }else if($('#subscriberemail').val() != '' && !ValidateEmail($('#subscriberemail').val())){
				  $('#subscriberemail-error').html("Please enter valid email");
		  }else{
			  	  
				  $('#subscriberemail-error').html('');
				  e.preventDefault();
				  
					var formData = $('#subscriberdetail').serialize();
					
				  $.ajax({
					type: 'post',
					url: '<?php echo URL;?>views/checksubscrib.php?type=sub&logID=<?php echo $objsession->get('gs_login_id');?>&artist=<?php echo $_GET['church'];?>',
					data: formData,
					success: function (data) {
					  if(data == 'You have already subscribed to this artist.'){
						  $('#subsc').html(data);
					  }else
						 $('#subsc').html(data);  
					  }
				  });			  
		  }
        });
		
		
		$("#subscriberdetail").validate({
			ignore: [],  
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {				
				subscriberemail: {
					  required:true,
					  email:true,
					},
						
			},

			messages: {
				subscriberemail: {
					  required:"Please enter your email",
					  email:"Please enter valid email",
					},
				
			},	
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},			
			submitHandler: function(form) {
				form.submit();
			}

		});
	});</script>
            <form role="form" name="subscriberdetail" id="subscriberdetail" method="post" enctype="multipart/form-data">
              <div class="col-lg-12 col-md-12 col-sm-12 chang" id="subsc">
                <h3>My Subscribers</h3>
                <?php if($objsession->get('gs_login_id') == 0){?>
                <p style="float:left;">Please login for subscription : </p>
                <a data-target="#myModal" class="login" data-toggle="modal" href="#">Login</a>
                <?php }else{
					
					$cond = "";
					if($objsession->get('gs_login_id') > 0 && $objsession->get('gs_login_id') != ""){
		  				$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND (iRollID = ".$_GET['church']." AND isActive = 1)";
					}else{
						$cond = "(iRollID = ".$_GET['church']." AND isActive = 1)";		
					}
		  
		  $subscrib = $obj->fetchRow("subscription",$cond);		  
		  if(count($subscrib) == 0){ 
				 
				 
				 ?>
                <div class="">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                      <input type="text" name="subscriberemail" id="subscriberemail" class="form-control" value="<?php echo $loginRow['sEmailID']; ?>" readonly="readonly" placeholder="Enter your emiail" />
                      <span id="subscriberemail-error" class="error"></span> </div>
                  </div>
                </div>
                <div class="">
                  <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                      <input name="btn_subscribe" type="button" class="form-control" id="subscribe005" value="Subscribe" />
                    </div>
                  </div>
                </div>
                <?php
            }else{
	?>
                <p>You have already subscribed to this artist.</p>
                <?php
		  }
			 } ?>
              </div>
              <?php 
  if(isset($_POST['btn_subscribe'])){
		extract($_POST);

		$row = $obj->fetchRow("usermaster","iLoginID = ".$objsession->get('gs_login_id'));
		
		$field = array("iLoginID","iRollID","sEmailID","sName","isActive");
		$value = array($objsession->get('gs_login_id'),$_GET['church'],$subscriberemail,$row['sUserName'],1);	
			
		$obj->insert($field,$value,"subscription");
	}
  ?>
            </form>
            <?php 
		  
	} ?>
            <?php if($objsession->get('gs_login_id') > 0 && !isset($_GET['church'])){
	
	 	 $subscrib = $obj->fetchNumOfRow("subscription","iRollID = ".$objsession->get('gs_login_id')." AND isActive = 1");
 	?>
            <script>$().ready(function() {
	
	$('#unsubscribe').on('click', function (e) {
		  	  
			var selected = [];
			$('.subscribe input:checked').each(function() {
				selected.push($(this).attr('value'));
			});
			
			if(selected.length == 0){
				$('#iSubID-error').html("Please select subscribers");
			}else{
				  $('#iSubID-error').html('');
				  e.preventDefault();				  
					var formData = $('#unSub').serialize();					
				  $.ajax({
					type: 'post',
					url: '<?php echo URL;?>views/checksubscrib.php?type=unsub&logID=<?php echo $objsession->get('gs_login_id');?>&selected='+selected,
					data: formData,
					success: function (data) {
					  if(data == 'You have already subscribed to this artist.'){
						  $('#unsub').html(data);
					  }else
						 $('#unsub').html(data);  
					  }
				  });			  
			}
        });
		
	});</script>
            <div class="col-lg-12 col-md-12 col-sm-12 chang">
              <h3>My Subscribers</h3>
              <div id="eventdesc"></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 chang borderbuttom">
              <?php
							if ($objsession->get('gs_login_id') > 0) {
							?>
              <script>$().ready(function() {
	var cnt = 0;
	$('#uploadevent').on('click', function (e) {
			
			if ( cnt == 0 ) {
				$('#ue').show();
				cnt = 1;
			} else {
				$('#ue').hide();
				cnt = 0;
			}
    });
		
	});
	
	function subscribEvent() {
				 
			var selected02 = [];
			$('.subscribe0002 input:checked').each(function() {
				selected02.push($(this).attr('value'));
			});
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/subscribevent.php?logID=<?php echo $objsession->get('gs_login_id');?>&selected='+selected02,
				data: '',
				success: function (data) {
					 $('#eventdesc').html(data);
				}
			  });
	}
	
	</script>
              <div class="col-lg-12 col-md-12 col-sm-12 mb20">
                <h2 style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">You Have <span>
                  <?php if($subscrib > 0){ echo $subscrib;}else{echo '0';}						
									?>
                  </span> Subscriber(s)</h2>
                <p class="mt20">Subscribe Settings</p>
                <p class="mt20">Notify My Subscribers When:</p>
                <h2>
                  <ul>
                    <li>
                      <input type="checkbox" name="uploadVideo" value="uploadvideo" >
                      Upload new Videos</li>
                    <li>
                      <input type="checkbox" name="uploadphoto" value="uploadphoto" >
                      Upload new Photos</li>
                    <li>
                      <input type="checkbox" name="uploadevent" id="uploadevent" value="uploadevent" >
                      New Events are Added to my Calendar</li>
                  </ul>
                </h2>
                <div class="listevent" id="ue" style="display:none;">
                  <?php
										
										$eventsubscribe = $obj->fetchRow('eventsubscribe',"iLoginID = ".$objsession->get('gs_login_id'));
										$eventmaster	= $obj->fetchRowAll('eventmaster',"doe >= NOW() AND iLoginID = ".$objsession->get('gs_login_id'));
										
										if(!empty($eventmaster)){
											$checked = "";
											for ( $e=0;$e<count($eventmaster);$e++) {
												
												if ( !empty($eventsubscribe) ) {
													
													$eIds = explode(',',$eventsubscribe['iEventID']);
													
													if ( in_array($eventmaster[$e]['e_id'],$eIds) ) {
														$checked = 'checked="true"';
													}
												}
												
									?>
                  <div class="eventlist01">
                    <ul class="subscribe0002">
                      <li>
                        <input type="checkbox" <?php echo $checked;?> onclick="subscribEvent();" name="eventid[]" value="<?php echo $eventmaster[$e]['e_id'];?>" >
                        <?php echo ucwords($eventmaster[$e]['event_name']);?></li>
                    </ul>
                  </div>
                  <?php
											$checked = "";
											}
										}
									?>
                  <?php 
									
									?>
                </div>
              </div>
              <?php } ?>
            </div>
            <form name="unSub" id="unSub">
              <div class="col-lg-12 col-md-12 col-sm-12 chang">
                <h3>My Subscriptions</h3>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 subscribe"> <span id="iSubID-error" class="error"></span>
                <div class="clear"></div>
                <div id="unsub">
                  <?php
    	$subscriblist = $obj->fetchRowAll("subscription","iLoginID = ".$objsession->get('gs_login_id')." AND isActive = 1");
    ?>
                  <?php
		if(count($subscriblist) > 0){
			for($sub=0;$sub<count($subscriblist);$sub++){
		?>
                  <div class="col-lg-6 col-md-6 ocl-sm-6">
                    <input type="checkbox" name="iSubID" id="iSubID" value="<?php echo $subscriblist[$sub]['iSubID'];?>">
                    &nbsp;&nbsp; <i class="fa fa-user"></i>&nbsp;&nbsp;
                    <?php
											if ( $subscriblist[$sub]['sType'] == 'church') {
												$pageurl = "views/churchprofile?church=";
											} else {
												$pageurl = "views/artistprofile?artist=";
											}
										?>
                    <a href="<?php echo URL.$pageurl.$subscriblist[$sub]['iRollID']; ?>"><?php echo $subscriblist[$sub]['sName'];?></a> </div>
                  <?php }} ?>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-8 col-md-8 col-sm-8"> </div>
                <div class="col-lg-4 col-md-4 col-sm-4 mt20">
                  <button type="button" id="unsubscribe" class="btn btn-primary">Unsubscribe</button>
                </div>
              </div>
            </form>
            <?php } ?>
          </div>
          <?php 
  
    if(isset($_GET['church'])){
    	$countView = 1;
		
		$views = $obj->fetchRow("usermaster","iLoginID = ".$_GET['church']);
		
		if($views['iCount'] > 0){
			$countView = $views['iCount'] + 1;
		}
		
		$field = array("iCount");
		$value = array($countView);
		
		$obj->update($field,$value,"iLoginID = ".$_GET['church'],"usermaster");
    }

   ?>
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
			$str3 = str_replace($_GET['image'],' ',$gift['sVideoNameImage']);
			
			$str1 = str_replace(' ,','',$str1);
			$str2 = str_replace(' ,','',$str2);
			$str3 = str_replace(' ,','',$str3);
			
			$str1 = rtrim($str1,', ');
			$str2 = rtrim($str2,', ');
			$str3 = rtrim($str3,', ');
			
			$field = array("sVideo","sVideoName","sVideoNameImage");
			$value = array($str1,$str2,$str3);
			
			$obj->update($field,$value,$cond,"churchministrie");
			
			deleteImage($_GET['name'],'upload/church/video/'.$_GET['videoType']);
			
			$objsession->set('gs_msg','Video deleted successfully');
			redirect(URL.'views/churchprofile.php');
			
		}
	}
	
	if($_GET['type'] == 'album'){
		
		deleteImage($_GET['photo'],'upload/gallery/'.$_GET['name'].'/');
		
		if($obj->delete('gallerymaster',"iGalleryID = ".$_GET['galleryID']) == true){
			$objsession->set('gs_msg','Image successfully deleted.');	
			redirect(URL.'views/churchprofile.php');
		}
		
	}
	
	if($_GET['type'] == 'youtubevideo'){
		
		$cond = '';
			$cond = "iLoginID = ".$_GET['iLoginID']." AND sMinistrieName = '".$_GET['videoType']."'";
			$gift = $obj->fetchRow("churchministrie",$cond);
			
			$str1 = str_replace($_GET['videName'],' ',$gift['sUrl']);
			
			$str1 = str_replace(' ,','',$str1);
			$str1 = rtrim($str1,', ');
					
			$field = array("sUrl");
			$value = array($str1);
			
			$cond = "iChurchID = ".$_GET['iyoutubeid'];
			
			$obj->update($field,$value,$cond,"churchministrie");
		
		$objsession->set('gs_msg','Youtube video successfully deleted.');	
		redirect(URL.'views/churchprofile.php');
		
	}
}
?>
<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>
