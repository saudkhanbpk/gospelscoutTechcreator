<?php include('../include/header.php'); ?>

<link rel="stylesheet" href="<?php echo URL;?>admin/views/skin/functional.css">
<script src="<?php echo URL;?>admin/views/flowplayer.min.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<script>
$(document).ready(function(){
	
	$("#iAmountID").keypress(function(){
		$("#amount").val($("#iAmountID").val());
    });
	
	$("#iAmountID").keyup(function(){
        $("#amount").val($("#iAmountID").val());
    });
	
	$("#iAmountID").click(function(){
        $("#amount").val($("#iAmountID").val());
    });
	
	$("#iAmountID").blur(function(){
        $("#amount").val($("#iAmountID").val());
    });
	
	        $('#menu11').show();
	
    $("#menu1").click(function(){
        $('#menu11').show();
		$('#menu22').hide();
		$('#menu33').hide();
		$('#menu44').hide();
		$('#menu55').hide();
		
		$("#menu5").removeClass("active");
		$("#menu4").removeClass("active");
		$("#menu3").removeClass("active");
		$("#menu2").removeClass("active");
		
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).addClass("active");   
	
    });
	
	    $("#menu2").click(function(){
        $('#menu22').show();
		$('#menu11').hide();
		$('#menu33').hide();
		$('#menu44').hide();
		$('#menu55').hide();
		
		$("#menu1").removeClass("active");
		$("#menu3").removeClass("active");
		$("#menu5").removeClass("active");
		$("#menu4").removeClass("active");
    	$(this).addClass("active");   
	
    });
	
	    $("#menu3").click(function(){
			
        $('#menu33').show();
		$('#menu44').hide();
		$('#menu55').hide();
		$('#menu22').hide();
		$('#menu11').hide();
		
		$("#menu1").removeClass("active");
		$("#menu2").removeClass("active");
		$("#menu5").removeClass("active");
		$("#menu4").removeClass("active");
    	$(this).addClass("active");   
		
    });
	
	 $("#menu4").click(function(){
			
        $('#menu44').show();
		$('#menu33').hide();
		$('#menu55').hide();
		$('#menu22').hide();
		$('#menu11').hide();
		
		$("#menu1").removeClass("active");
		$("#menu2").removeClass("active");
		$("#menu5").removeClass("active");
		$("#menu3").removeClass("active");
    	$(this).addClass("active");   
		
    });
	
	 $("#menu5").click(function(){
			
        $('#menu55').show();
		$('#menu33').hide();
		$('#menu44').hide();
		$('#menu22').hide();
		$('#menu11').hide();
		
		$("#menu1").removeClass("active");
		$("#menu2").removeClass("active");
		$("#menu4").removeClass("active");
		$("#menu3").removeClass("active");
    	$(this).addClass("active");   
		
    });
	
	$('#countryId').on('change', function (e) {
		
			  $('#stateId').html('');
			  var cntID = $('#countryId').val();
			  e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea.php?type=state&iCountriID='+cntID,
				//data: formData,
				success: function (data) {
				  if(data == 'Please select country'){
					  
					  $('#stateId').html("<option value=''>Select State</option>");
					  $('#cityId').html("<option value=''>Select City</option>");
					  
				  }else{
					 $('#stateId').html(data);
				  }
				}
			  });
		});
		
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
		
});
</script>
<?php
$cond = "iLoginID = ".$_GET['iLoginID'];
$userRow = $obj->fetchRow('usermaster',$cond);
$loginDetail = $obj->fetchRow('loginmaster',$cond);

$country = $obj->fetchRow('countries','id = '.$userRow['sCountryName']);
$states = $obj->fetchRow('states','id = '.$userRow['sStateName']);
$cities = $obj->fetchRow('cities','id = '.$userRow['sCityName']);
	
if($userRow['sUserType'] == 'user'){
	
} else if($userRow['sUserType'] == 'church'){

	$sAmityName = $obj->getConcateValue('amenitimaster','sAmityName','iAmityID IN('.$userRow['sAmenitis'].')');
	$sMinistrieName = $obj->getConcateValue('churchministrie','sMinistrieName','iLoginID = '.$userRow['iLoginID']);
	
	$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['iLoginID']);
	
	$churchtimeing = $obj->fetchRowAll("churchtimeing","iLoginID = ".$_GET['iLoginID']);
	//$churchministrie = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['iLoginID']);
	$gistmaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$_GET['iLoginID']);
		
} else if($userRow['sUserType'] == 'artist'){

	$rollmaster = $obj->getConcateValue('rollmaster','sGiftName','iLoginID = '.$userRow['iLoginID']);
	$rollType = $obj->fetchRow('rollmaster','iLoginID = '.$userRow['iLoginID']);
	
	$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$_GET['iLoginID']);
	$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['iLoginID']);
}


?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Personal Information</h2>
        <?php if($objsession->get('gs_msg') != ""){?>
<div class="suc-message" style="color: red; padding: 10px;">
<?php echo $objsession->get('gs_msg');?>
</div>
<?php
$objsession->remove('gs_msg');
 } ?>
        <div class="table-responsive">

<?php
	if(count($userRow) > 0){
?>
          <table border="1" class="table table-hover">
              
              <tr>
                <th class="col-lg-2">First Name</th>
                <td>
                <?php 
					echo $userRow['sFirstName'];				
				?>
                </td>
                <th>Country</th>
                <td><?php echo $country['name'];?></td>
                </tr>
                <tr>
                <th class="col-lg-2">Last Name</th>
                <td>
                <?php 
					echo $userRow['sLastName'];				
				?>
                </td>
                <th>State</th>
                <td><?php echo $states['name'];?></td>
                </tr>
                <tr>
                <th>Creation Date</th>
                <td><?php 
					echo date('d-m-Y',strtotime($userRow['dCreatedDate']));
				?></td>
                <th>City</th>
                <td><?php echo $cities['name'];?></td>
                </tr>
                <tr>
				<th>Email</th>
                <td><?php echo $loginDetail['sEmailID'];?></td>				
                <th>Zipcode</th>
                <td><?php 
					echo $userRow['iZipcode'];				
				?></td>
                </tr>
				<tr>
				<th>Profile</th>
                <td><img src="<?php echo URL;?>upload/<?php echo $userRow['sUserType'];?>/<?php echo $userRow['sProfileName'];?>" width="100" height="80" /></td>
				</tr>
          </table>
<?php }else{ ?>
<span>Users detail not found.</span>
<?php } ?>
        </div>
        
        <?php
		if(!empty($userRow) && $userRow['sUserType'] == 'artist'){
		?>
        <h2>About Artist</h2>
        <div class="table-responsive">
          <table border="1" class="table table-hover">
              <tr>
                <th class="col-lg-2">Roll</th>
                <td >
                <?php 
					if(!empty($rollType)){ echo ucwords($rollType['sGroupType']);}else{ echo '---';}	
				?>
                </td>
                </tr>
                <tr>
                <th class="col-lg-2">My Gift</th>
                <td >
                <?php 
					if(!empty($rollmaster)){ echo ucwords($rollmaster['ROLL']);}else{ echo '---';}	
				?>
                </td>
                </tr>
                <th class="col-lg-2">Availability</th>
                <td >
                <?php 
					if($userRow['sAvailability'] != ''){ echo ucwords(substr_replace('_',' ',$userRow['sAvailability']));}else{ echo '---';}	
				?>
                </td>
                </tr>                
                <tr>
                <th>Years Of Experience</th>
                <td>
                <?php
					if($userRow['iYearOfExp'] > 0){echo $userRow['iYearOfExp'].' Years';}else{ echo '---';}	
				?>
                </td>
                </tr>
                <tr>
                <th>Musical Influences</th>
                <td><?php 
					if ($userRow['sMusicalInstrument'] != ''){ echo $userRow['sMusicalInstrument'];	}else{ echo '---';}	
				?></tdhoe 
                </tr>
               <tr>
                <th>What Kind of Music They Play</th>
                <td><?php if($userRow['sKindPlay'] != ''){ echo ucfirst($userRow['sKindPlay']);}else{ echo '---';}?></td>
              </tr>
              <tr>
                <th>Where they Have Played</th>
                <td><?php if($userRow['sHavePlayed'] != ''){ echo ucfirst($userRow['sHavePlayed']);}else{ echo '---';}?></td>
              </tr>
          </table>
        </div>        
        <?php
		}
		?>
        
        <?php
		if(!empty($userRow) && $userRow['sUserType'] == 'artist'){
		?>
        <h2>Video</h2>
        <div class="videolist">
                    
          <?php
		if(count($gistmaster) > 0){
			$vid = 0;
			
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);

				
				if($gistmaster[$gi]['sVideo'] == "" && $gistmaster[$gi]['sYoutubeUrl'] == ""){
					$vdCheck = '';
				}else{
					$vdCheck = 'test';
				}
				
	?>
    <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
   <form name="frmVideo" id="frmVideo">
   <?php if($vdCheck != ""){ ?>
    	<div class="video_sec">
        <h3 style="float:left;"><?php echo ucfirst($gistmaster[$gi]['sGiftName']);?></h3>
        
    	</div>        
        <div class="" style="clear:both;"></div>
    	<?php 

			if($gistmaster[$gi]['sVideo'] != ""){
				
				$v = 0;
				
				foreach($vdiList as $vd){
		?>
     
        <div class="col-lg-3 col-mg-3 col-sm-3">
 
<div class="flowplayer" data-swf="<?php echo URL;?>views/flowplayerhls.swf" style="height: 157px;">
                    <video width="800" controls class="img-responsive center-block hight" preload="metadata">
                      <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                    </video></div>
 			<?php
			if(isset($_GET['artist'])){
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$_GET['artist']." AND sVideoName = '".$vdiList[$v]."'");
			}else{
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiList[$v]."'");
			}
			?>
            <!--<h2 style="font-size:14px;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></h2>-->
            <a onclick="return confirm('Are you sure want to delete?');" href="<?php echo HTTP_SERVER;?>views/userdetails.php?iLoginID=<?php echo $_GET['iLoginID'];?>&videoType=<?php echo $gistmaster[$gi]['sGiftName'];?>&type=video&videName=<?php echo $vdiName[$v];?>&name=<?php echo $vd;?>&main=artist">X</a>
        </div>

        <?php
		$v ++;
		$vid ++;
				}
			}
		?>
        <?php if($gistmaster[$gi]['sYoutubeUrl'] != ""){
				$youtube = explode(',',$gistmaster[$gi]['sYoutubeUrl']);
				
				foreach ( $youtube as $key ) {
					
					$filename = substr(strrchr($key, "="), 1);	
					
					if($filename != "")			{
		?>
                                <div class="col-lg-3 col-mg-3 col-sm-3">
                                
                                    <iframe width="220" height="160" src="https://www.youtube.com/embed/<?php echo $filename; ?>" ></iframe>
									<div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo HTTP_SERVER;?>views/userdetails.php?iLoginID=<?php echo $_GET['iLoginID'];?>&videoType=<?php echo $gistmaster[$gi]['sGiftName'];?>&type=youtubevideo&videName=<?php echo $key;?>&main=artist&iyoutubeid=<?php echo $gistmaster[$gi]['iRollID']; ?>">X</a></div>
                                </div>
                                
                                <?php }
				}
		} 
		?>
        <?php } ?>
         </form>
    </div>
    <?php 
			}
		
			if($vdCheck == ''){
				echo "<h3 style='font-size:14px;'>This Artist Has No Videos Uploaded </h3>";	
			}
	}else{		
			echo "<h3 style='font-size:14px;'>This Artist Has No Videos Uploaded </h3>";		
		}?>
        
        <h2>Album</h2>
        <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  <div id='cssmenu' class="mt30">
              
              <div class="col-lg-3 col-md-3 col-sm-3" style="margin-bottom:12px;">
			  <?php 
			  if(!empty($albummaster)){
				  for($a=0;$a<count($albummaster);$a++){
			  ?>
              <select class="form-control">
              
                <option id="menu<?php echo ($a + 1);?>" <?php if($a == 0){?>class="active"<?php } ?>>
                <?php echo $albummaster[$a]['sAlbumName'];?>
                </option>
              <?php 
				  }
			  
			  ?>
              </select>
			  <?php
			  } else{
				echo "<h3 style='font-size:14px;'> There Are No Photos Uploaded </h3>";
			}?>
              </div>
            </div>
            <div style="clear:both;"></div>
            <?php
			
			if(!empty($albummaster)){
				$n = 11;
				$galleryImg = '';
				  for($a=0;$a<count($albummaster);$a++){
					  $gallerymaster = $obj->fetchRowAll("gallerymaster","iAlbumID = ".$albummaster[$a]['iAlbumID']);
					  
					  if ( !empty( $gallerymaster ) ) {
						  $galleryImg = 'gallery';
					  }
					  
					  if ( $galleryImg != '' ) {
						  
					?>
                    <div id="menu<?php echo $n;?>" <?php if($a != 0){?> style="display:none;"<?php } ?>>
                    <?php
					  for($ga=0;$ga<count($gallerymaster);$ga++){
					?>
            
    	<div class="col-lg-3 col-mg-3 col-sm-3">
        	<img src="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>" class="img-responsive center-block artistphotos">
            <a href="<?php echo HTTP_SERVER;?>views/userdetails.php?iLoginID=<?php echo $_GET['iLoginID'];?>&photo=<?php echo $gallerymaster[$ga]['sGalleryImages'];?>&type=album&name=<?php echo $albummaster[$a]['sAlbumName'];?>&galleryID=<?php echo $gallerymaster[$ga]['iGalleryID'];?>">X</a>
        </div>
   
            <?php 
					  }
					  } else {
						 echo "<h3 style='font-size:14px;'> There Are No Photos Uploaded </h3>";
					  }
					?>
                    </div>
                    <?php
					  $n = $n + 11;
				  }
			}///
			?>
  </div>
  
  
        <?php } ?>
        
        <?php
		if(!empty($userRow) && $userRow['sUserType'] == 'church'){
		?>
        <h2>Church Details</h2>
        <div class="table-responsive">
          <table border="1" class="table table-hover">
              <tr>
                <th class="col-lg-2">Church Name</th>
                <td >
                <?php 
					echo ucwords($userRow['sChurchName']);
				?>
                </td>
                </tr>
                <tr>
                <th>Pastor Name</th>
                <td>
                <?php
					echo ucwords($userRow['sPastorName']);
				?>
                </td>
                </tr>
                <tr>
                <th>Church Address</th>
                <td><?php 
					echo ucwords($userRow['sAddress']);
				?></td>
                </tr>
          </table>
        </div>        
        <?php
		}
		?>
        
        <?php
		if(!empty($userRow) && $userRow['sUserType'] == 'church'){
		?>
        <h2>About Church</h2>
        <div class="table-responsive">
          <table border="1" class="table table-hover">
              <tr>
                <th class="col-lg-2">Denomination </th>
                <td >
                <?php 
					if($userRow['sDenomination'] != ''){ echo ucwords($userRow['sDenomination']);}else{echo '---';}
				?>
                </td>
                <th>Church Amenitis</th>
                <td><?php if($sAmityName['ROLL']!= ''){echo ucwords($sAmityName['ROLL']);}else{echo '---';}?></td>
                </tr>
                <tr>
                <th>Approx. #No of Members</th>
                <td>
                <?php
					if($userRow['iNumberMembers'] > 0){echo $userRow['iNumberMembers'];}else{echo '0';}
				?>
                </td>
                <th>Other Amenitis</th>
                <td>
                <?php
					if($userRow['sOtherAmenitis'] != ""){echo $userRow['sOtherAmenitis'];}else{ echo '---';}
				?>
                </td>
                </tr>
                <tr>
                <th>Church Website Link</th>
                <td>
                	<a href="http://<?php echo $userRow['sChurchUrl'];?>" target="_blank"><?php echo $userRow['sChurchUrl'];?></a>
                </td>
                <th>Church Ministries</th>
                <td><?php if($sMinistrieName['ROLL'] != ''){echo ucwords($sMinistrieName['ROLL']);}else{echo '---';}?></td>
                </tr>
                <tr>
                <th>Mission Statement</th>
                <td><?php 
					if($userRow['sMission'] != ''){echo ucwords($userRow['sMission']);}else{echo '---';}
				?></td>
                </tr>
                <tr>
                <th>Founders</th>
                <td><?php 
					if($userRow['sFounderName'] != ''){echo ucwords($userRow['sFounderName']);}else{echo '---';}
				?></td>
                </tr>
          </table>
        </div>        
        <?php
		}
		?>
        
        <?php
		if(!empty($userRow) && $userRow['sUserType'] == 'church'){
			
		?>
        <?php if(count($churchtimeing) > 0){?>
        <h2>Church Services</h2>
        <div class="table-responsive">          
          <table border="1" class="table table-hover">  
          <?php 
		  	for($s=0;$s<count($churchtimeing);$s++){
		  ?>        
              <tr>
                <th class="col-lg-2">Service </th>
                <td >
                <?php 
					echo ucwords($churchtimeing[$s]['sTitle']);
				?>
                </td>
                <th>Hour</th>
                <td><?php echo $churchtimeing[$s]['iHour'];?></td>
                <th>Minute</th>
                <td><?php echo $churchtimeing[$s]['iMinute']." ".ucwords($churchtimeing[$s]['ampm']);?></td>
                </tr>
			<?php } ?>
          </table>
        </div>        
        <?php
		}
		}
		?>
        
        <?php
		if(!empty($userRow) && $userRow['sUserType'] == 'church'){
		?>
        <h2>Video</h2>
        <div class="videolist">
                    
          <?php
		if(count($gistmaster) > 0){
			
			$vid = 0;
			$vdCheck = 'test';
			for($gi=0;$gi<count($gistmaster);$gi++){
			
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				
				if($gistmaster[$gi]['sVideo'] == ""){
					$vdCheck = '';
				}else{
					$vdCheck = 'test';
				}
				
				if($gistmaster[$gi]['sUrl'] != ""){
					$vdCheck = 'test';
				}
	?>
    <div class="col-lg-12 col-md-12 col-sm-12 <?php if($gistmaster[$gi]['sVideo'] != ""){?>borderbuttom<?php } ?>">
   <form name="frmVideo" id="frmVideo">
    	<?php if($vdCheck != ""){ ?>
        <div class="video_sec">
        <h3 style="float:left;"><?php echo ucwords(str_replace('_',' ',$gistmaster[$gi]['sMinistrieName']));?></h3>
        
    	</div>        
        <div class="" style="clear:both;"></div>
    	<?php 
			if($gistmaster[$gi]['sVideo'] != "" || $gistmaster[$gi]['sUrl'] != ""){
				
				$v = 0;
				foreach($vdiList as $vd){					
		?>
        <?php if(strlen($vd) > 1){?>
        <div class="col-lg-3 col-mg-3 col-sm-3">        
        
        <!--<video width="800" controls class="img-responsive center-block hight" preload="metadata">
  <source src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.rtrim($vd,',');?>" type="video/mp4">
</video>-->

<div class="flowplayer" data-swf="<?php echo URL;?>views/flowplayerhls.swf" style="height: 157px;">
                    <video width="800" controls class="img-responsive center-block hight" preload="metadata">
                      <source src="<?php echo URL;?>upload/church/video/<?php echo $gistmaster[$gi]['sMinistrieName'].'/'.rtrim($vd,',');?>" type="video/mp4">
                    </video></div>

        	<span id="loadlogin"></span>
            <!--<h2 style="font-size:14px;"><?php echo pathinfo($vdiName[$v],PATHINFO_FILENAME);?></h2>-->
            <a href="<?php echo HTTP_SERVER;?>views/userdetails.php?iLoginID=<?php echo $_GET['iLoginID'];?>&videoType=<?php echo $gistmaster[$gi]['sMinistrieName'];?>&type=video&videName=<?php echo $vdiName[$v];?>&name=<?php echo $vd;?>&main=church">X</a>
            
        </div>
        <?php }?>
        <?php
				$v ++;	}
		
		$vid ++;
			}
		?>
        <?php if($gistmaster[$gi]['sUrl'] != ""){
				$vid ++;

				$youtube = explode(',',$gistmaster[$gi]['sUrl']);
				
				foreach ( $youtube as $key ) {
					
					$filename = substr(strrchr($key, "="), 1);	
					
					if($filename != "")			{			
		?>
            
        <div class="col-lg-3 col-mg-3 col-sm-3">  
             <iframe width="220" height="160" src="https://www.youtube.com/embed/<?php echo $filename; ?>" frameborder="0" allowfullscreen></iframe>
			<div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo HTTP_SERVER;?>views/userdetails.php?iLoginID=<?php echo $_GET['iLoginID'];?>&videoType=<?php echo $gistmaster[$gi]['sMinistrieName'];?>&type=youtubevideo&videName=<?php echo $key;?>&main=church&iyoutubeid=<?php echo $gistmaster[$gi]['iChurchID']; ?>">X</a></div>
        </div>
        <?php 
		}
				}
				}
		?>
		<?php }?>        
         </form>
    </div>
    
    <?php 
			}
		
			if($vdCheck == ''){
				echo "<h3 style='font-size:14px;'>This Chruch Has No Videos Uploaded </h3>";	
			}
	}
		
		else{		
			echo "<h3>This Chruch Has No Videos Uploaded </h3>";		
		}?>
        
        <h2>Album</h2>
        <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  <div id='cssmenu' class="mt30">
              
              <div class="col-lg-3 col-md-3 col-sm-3" style="margin-bottom:12px;">
			  <?php if(!empty($albummaster)){ ?>
              <select class="form-control">
              <?php 
			  
				  for($a=0;$a<count($albummaster);$a++){
			  ?>
                <option id="menu<?php echo ($a + 1);?>" <?php if($a == 0){?>class="active"<?php } ?>>
                <?php echo $albummaster[$a]['sAlbumName'];?>
                </option>
              <?php 
				  }
			  ?>
              </select>
			  <?php
			  } else{
				echo "<h3 style='font-size:14px;'> There Are No Photos Uploaded </h3>";
			}?>
              </div>
            </div>
            <div style="clear:both;"></div>
            <?php
			
			if(!empty($albummaster)){
				$n = 11;
				  for($a=0;$a<count($albummaster);$a++){
					  $gallerymaster = $obj->fetchRowAll("gallerymaster","iAlbumID = ".$albummaster[$a]['iAlbumID']);
					?>
                    <div id="menu<?php echo $n;?>" <?php if($a != 0){?> style="display:none;"<?php } ?>>
                    <?php
					  for($ga=0;$ga<count($gallerymaster);$ga++){
					?>
            
    	<div class="col-lg-3 col-mg-3 col-sm-3">
        	<img src="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>" class="img-responsive center-block artistphotos">
            <a href="<?php echo HTTP_SERVER;?>views/userdetails.php?iLoginID=<?php echo $_GET['iLoginID'];?>&photo=<?php echo $gallerymaster[$ga]['sGalleryImages'];?>&type=album&name=<?php echo $albummaster[$a]['sAlbumName'];?>&galleryID=<?php echo $gallerymaster[$ga]['iGalleryID'];?>">X</a>
        </div>
   
            <?php 
					  }
					?>
                    </div>
                    <?php
					  $n = $n + 11;
				  }
			}///
			?>
  </div>
  
  
        <?php } ?>
        
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php
if(isset($_GET['type'])){
	
	if($_GET['type'] == 'video'){
		
		if($_GET['main'] == 'church'){
			
			$cond = '';
			$cond = "iLoginID = ".$_GET['iLoginID']." AND sMinistrieName = '".$_GET['videoType']."'";
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
			redirect(HTTP_SERVER.'views/userdetails?iLoginID='.$_GET['iLoginID']);
			
		}else{
						
			$cond = '';
			$cond = "iLoginID = ".$_GET['iLoginID']." AND sGiftName = '".$_GET['videoType']."'";
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
			
			deleteImage($_GET['name'],'upload/artist/video/'.$_GET['videoType']);
			
			$objsession->set('gs_msg','Video deleted successfully');
			redirect(HTTP_SERVER.'views/userdetails?iLoginID='.$_GET['iLoginID']);
		}
	}
	
	if ( $_GET['main'] == "artist" ) {
		
		if($_GET['type'] == 'youtubevideo'){
		
			$cond = '';
			$cond = "iLoginID = ".$_GET['iLoginID']." AND sGiftName = '".$_GET['videoType']."'";
			$gift = $obj->fetchRow("rollmaster",$cond);
			
			$str1 = str_replace($_GET['videName'],' ',$gift['sYoutubeUrl']);
			
			$str1 = str_replace(' ,','',$str1);
			$str1 = rtrim($str1,', ');
					
			$field = array("sYoutubeUrl");
			$value = array($str1);
			
			$obj->update($field,$value,$cond,"rollmaster");
				
			$objsession->set('gs_msg','Youtube video successfully deleted.');	
			redirect(HTTP_SERVER.'views/userdetails?iLoginID='.$_GET['iLoginID']);
		
		}
	}
	
	if ( $_GET['main'] == "church" ) {
		
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
			redirect(HTTP_SERVER.'views/userdetails?iLoginID='.$_GET['iLoginID']);
			
		}
	}
	
	if($_GET['type'] == 'album'){
		
		deleteImage($_GET['photo'],'upload/gallery/'.$_GET['name'].'/');
		
		if($obj->delete('gallerymaster',"iGalleryID = ".$_GET['galleryID']) == true){
			$objsession->set('gs_msg','Image successfully deleted.');	
			redirect(HTTP_SERVER.'views/userdetails?iLoginID='.$_GET['iLoginID']);
		}
		
	}
}
?>
<?php include('../include/footer.php'); ?>
