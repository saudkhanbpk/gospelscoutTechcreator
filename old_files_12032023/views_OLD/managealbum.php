<?php include('../include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">

<script>

$().ready(function() {
	
	$(function(){
		$.validator.addMethod('minStrict', function (value, el, param) {
		return value > param;
	});});	
	
		$("#frmVideo").validate({
			debug: false,
			errorClass: "error err_span",
			errorElement: "span",
//            ignore: ":hidden:not(.hiddenRecaptcha)",
			rules: {				
				"sGalleryImages[]": {
					  required: true,
					  extension: "png|jpg|jpeg",
					},
				iAlbumID: "required",				
			},

			messages: {
				"sGalleryImages[]": {
					  required: "Please select image",
					  extension: "Select only png | jpg | jpeg file.",
					},
				iAlbumID: "Please select album",				
			},	
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},	
			
			errorPlacement: function(error, element) 
			{	 
				if (element.attr("name") == "hiddenRecaptcha") 
				{
					error.insertAfter("span#capcha_err");
				}
				else {
					error.insertAfter(element);
				}			
			},		
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},
					
			submitHandler: function(form) {
					form.submit();
			}

		});
	});
	
</script>

<style>
.newmsm{
    color: green;
    font-size: 15px;
    line-height: 10px;
    margin-bottom: 15px;
    margin-top: 8px;
    padding: 0;
    text-align: center !important;
}
</style>
<script>
$(document).ready(function(){
	$('#menu11').show();
	
    $("#menu1").click(function(){
        $('#menu11').show();
		$('#menu22').hide();
		$('#menu33').hide();
    });
	
	    $("#menu2").click(function(){
        $('#menu22').show();
		$('#menu11').hide();
		$('#menu33').hide();
    });
	
	    $("#menu3").click(function(){
        $('#menu33').show();
		$('#menu22').hide();
		$('#menu11').hide();
    });
});
</script>
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
<?php

if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){
	
	$cond = "";
	$cond = "iLoginID = ".$objsession->get('gs_login_id');
	$userRow = $obj->fetchRow("usermaster",$cond);
	$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
	$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
}

if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'church'){
	$cond = "";
	$cond = "iLoginID = ".$objsession->get('gs_login_id');
	$userRow = $obj->fetchRow("usermaster",$cond);
	$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
	$usermaster = $obj->fetchRow("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
	$churchtimeing = $obj->fetchRowAll("churchtimeing","iLoginID = ".$objsession->get('gs_login_id'));

	/*$services = '';
	if(count($churchtimeing) > 0){
		for($ser=0;$ser<count($churchtimeing);$ser++){
			$hour = substr($churchtimeing[$ser]['iHour'],0,2);
			$am = substr($churchtimeing[$ser]['iHour'],5);
			$services .= $churchtimeing[$ser]['sTitle'].' - '.$hour.":".$churchtimeing[$ser]['iMinute'].' '.$am.',';
		}
	}*/

}

$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));

$citymaster = $obj->fetchRow("cities","id = ".$userRow['sCityName']);
$sortname = $obj->fetchRow("countries","id = ".$userRow['sCountryName']);

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
  	<div class="profile">
    <?php if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){?>
    	<img style="height:250px;border: 2px solid rgb(142,68,173);" src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];}else{?>img/profile.jpg<?php }?>" class="img-responsive center-block">
        <?php } ?>
        
          <?php if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'church'){?>
    	<img style="height:250px;border: 2px solid rgb(142,68,173);" src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/church/<?php echo $userRow['sProfileName'];}else{?>img/profile.jpg<?php }?>" class="img-responsive center-block">
        <?php } ?>
        
  	</div>
  </div>
  <ul class="nav nav-tabs" role="tablist">
    <?php if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){?>
  <a href="<?php echo URL;?>views/artistprofile.php" class="back">Back</a>
  <?php } ?>
  <?php if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'church'){?>
  <a href="<?php echo URL;?>views/churchprofile.php" class="back">Back</a>
  <?php } ?>
</ul>
<div class="clear" style="clear:both;"></div>



<!-- Tab panes --> 
<?php if($objsession->get('gs_login_type') == 'church'){?>

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
                    	<p><?php if($userRow['sPastorName'] != '')echo ucfirst($userRow['sPastorName']);?></p>
                     </div>
                <!--<p><b>Denomination : </b> <?php if($userRow['sDenomination'] != '')echo ucwords(str_replace('_'," ",$userRow['sDenomination']));?></p>-->
                <div class="clear"></div>
                	<div class="col-md-5 p0 col-xs-6">
                    	<p><b>Location : </b></p>
                     </div>
                     <div class="col-md-7 p0 col-xs-6">
                    	<p><?php if($userRow['sAddress'] != '')echo ucwords($userRow['sAddress']);?>
                    	,
                        <?php if($citymaster['name'] != '') echo ucwords($citymaster['name']);?>
                        ,
                        <?php if($sortname['sortname'] != '') echo ucwords($sortname['sortname']);?>
                    	<?php if($userRow['iZipcode'] != '') echo $userRow['iZipcode'];?>
                		</p>
                     </div>
                     <div class="clear"></div>
                   <div class="col-md-5 p0 col-xs-6">   
                		<p><b>Services : </b></p>
                   </div>     
                   <div class="col-md-7 p0 col-xs-6">
                    	<p><?php if($services != '')echo ucwords(nl2br($services));?>
                		</p>
                   </div>
                   <div class="clear"></div>
                   <div class="col-md-5 p0 col-xs-6">     
                		<p><b>Website : </b></p>
                   </div>
                   <div class="col-md-7 p0 col-xs-6">     
                    	<p><?php if($userRow['sChurchUrl'] != '')echo $userRow['sChurchUrl'];?>
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
            </div>
            <div class="clear"></div>
            <?php   
				
				if( $objsession->get('gs_login_id') > 0){
					$iChurchID = $objsession->get('gs_login_id');	
				}else{ 
					$iChurchID = $_GET['church'];	
				}
				
				$cond="doe >= NOW() AND (iLoginID = ".$iChurchID." OR FIND_IN_SET('".$objsession->get('gs_login_id')."',iIDs)) ORDER BY doe ASC LIMIT 1";	
				$rolemaster = $obj->fetchRow("eventmaster",$cond);
				$siddhant=(explode(",",$rolemaster['sMultiImage'])); 
				
				if ( !empty($rolemaster) ) {
			?>
			
            <div class="white">
                <h3 class="text-center">Upcoming Events</h3>
                <div class="events">                    
                    <div class="width25">
                    
                        <img src="<?php echo URL;?>upload/event/multiple/<?php echo $siddhant[0];?>" width="50px" height="50px"> </div>
                    <div class="width83">
                        <h5><b><?php echo $rolemaster['event_name'];?></b></h5>
                        <h5><?php echo date('M d, Y',strtotime($rolemaster['doe']));?></h5>
                        <h5><?php echo date('H:i',strtotime($rolemaster['toe']));?></h5>
                        <a href="<?php echo URL;?>views/eventdetail.php?event=<?php echo $rolemaster['e_id'];?>"/>
                        <input type="button" class="btn btn-primary info width37" value="Get Info">
                        </a> </div>
                </div>
                <h4><a href="<?php echo URL;?>views/eventdisplay.php">View Full Event Calendar <i class="fa fa-calendar"></i></a></h4>
            </div>
            
            <?php } ?>
        </div>
<?php }else{?>
<div class="col-lg-4 col-md-4 col-sm-4 p0">
	<div class="white">
    	<div class="">
    		<h3 class="text-left" style="font-size: 28px;font-weight: bold;text-transform: capitalize;">Artist info</h3>
        	<div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Current City:</b></p>
            </div>
            <div class="col-md-7 col-xs-6">
            	<p>
				<?php 
                
                if($userRow['sCityName'] != '')
                $city = $obj->fetchRow('cities',"id = ".$userRow['sCityName']);
                echo ucfirst($city['name']);
                
                ?>, 
				<?php 
                if($userRow['sStateName'] != '')
                $city = $obj->fetchRow('states',"id = ".$userRow['sStateName']);
                echo ucfirst($city['name']);
                echo "&nbsp;&nbsp;";
                
                if($userRow['iZipcode'] != '')echo $userRow['iZipcode'];?>
 				</p>
 			</div>
         </div>   
         
         <div class="clear"></div>
         
         <div class="col-md-5 col-xs-6" style="padding:0px;">
                    <p><b>Age:</b></p>
                </div>
				<?php
					if ( $usermaster['sGroupType'] == 'group' ) { 
						$clNo = 8;
					}else {
						$clNo = 7;
					}
					
				?>
                <div class="col-md-<?php echo $clNo;?> col-xs-6">
                    <p>
                        <?php 
                
				if ( $usermaster['sGroupType'] == 'group' ) { 
					
					if ( $usermaster['sMemberName'] != "" && $usermaster['memberAge'] != "" ) {
						
						$member = explode(',',$usermaster['sMemberName']);
						$age	 = explode(',',$usermaster['memberAge']);
						
						$arr = array_combine($member,$age);						
						
						foreach ( $arr as $key => $val ) {
							
							$from = new DateTime($val);
							$to   = new DateTime('today');
							echo $key ." : ". $from->diff($to)->y ."<br>";
						}
					
					} else  {
						echo "--- : ---";
					}
					
				}else{
					$from = new DateTime($userRow['dDOB']);
					$to   = new DateTime('today');
					echo $from->diff($to)->y;
				}
                
                ?>
                    </p>
                </div>
                <div class="clear"></div>
                <div class="">
                    <div class="col-md-5 col-xs-6" style="padding:0px;">
                        <p><b>Availabillity:</b></p>
                    </div>
                    <div class="col-md-7 col-xs-6">
                        <p>
                            <?php if($userRow['sAvailability'] != '')echo ucwords(str_replace('_',' ',$userRow['sAvailability']));?>
                        </p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="">
                    <div class="col-md-5 col-xs-6" style="padding:0px;">
                        <p><b>My Talent(s):</b></p>
                    </div>					
                    <div class="col-md-<?php echo $clNo;?> col-xs-6">
                        <p>
                            <?php 
					
					if ( $usermaster['sGroupType'] == 'group' ) { 
						
						if ( $usermaster['sMemberName'] != "" && $usermaster['sGiftName'] != "" ) {
							
						$member = explode(',',$usermaster['sMemberName']);
						$talent = explode(',',$usermaster['sGiftName']);
						$arr = array_combine($member,$talent);
						foreach ( $arr as $key => $val ) {
							echo $key ." : ". ucwords(str_replace("_"," ",$val))."<br>";
						}
						} else {
							echo "--- : ---";
						}
					?>
					
					<?php } else {
					
						if($userRow['iGiftID'] != ""){
							$str = '';
							/*for($m=0;$m<count($gistmaster);$m++){
								$str .= $gistmaster[$m]['sGiftName'].', ';
							}*/
							$talent = explode(',',$userRow['iGiftID']);
							$n = 0;
							$txt_mg = '';
							foreach ( $talent as $a) {
								$n ++;
								if ( $n == 3 ){
									$txt_mg .= "<br>";
									$n = 0;
								}
								
								$txt_mg .= ucwords(str_replace("_"," ",$a)).',';
								
							}
							echo rtrim($txt_mg,',');
							
							//echo ucwords(rtrim($str,','));
						}else{
							echo '---';	
						}
					}
                ?>
                        </p>
                    </div>
                </div>
         <div class="clear"></div>
       
    </div>    
    
    <div class="clear"></div> 
    
    <?php   
				
				if( $objsession->get('gs_login_id') > 0){
					$iActistID = $objsession->get('gs_login_id');	
				}else{ 
					$iActistID = $_GET['artist'];	
				}
				
				$cond="doe >= NOW() AND (iLoginID = ".$iActistID." OR FIND_IN_SET('".$objsession->get('gs_login_id')."',iIDs)) ORDER BY doe ASC LIMIT 1";	
				$rolemaster = $obj->fetchRow("eventmaster",$cond);
				$siddhant=(explode(",",$rolemaster['sMultiImage'])); 
				
				if ( !empty($rolemaster) ) {
			?>
			
            <div class="white">
                <h3 class="text-center">Upcoming Events</h3>
                <div class="events">                    
                    <div class="width25">
                    
                        <img src="<?php echo URL;?>upload/event/multiple/<?php echo $siddhant[0];?>" width="50px" height="50px"> </div>
                    <div class="width83">
                        <h5><b><?php echo $rolemaster['event_name'];?></b></h5>
                        <h5><?php echo date('M d, Y',strtotime($rolemaster['doe']));?></h5>
                        <h5><?php echo date('H:i',strtotime($rolemaster['toe']));?></h5>
                        <a href="<?php echo URL;?>views/eventdetail.php?event=<?php echo $rolemaster['e_id'];?>"/>
                        <input type="button" class="btn btn-primary info width37" value="Get Info">
                        </a> </div>
                </div>
                <h4><a href="<?php echo URL;?>views/eventdisplay.php">View Full Event Calendar <i class="fa fa-calendar"></i></a></h4>
            </div>
            
            <?php } ?>
</div>
<?php } ?>

<div class="col-lg-8 col-md-8 col-sm-8"> 
<div class="tab-content">

  <div role="tabpanel" class="tab-pane fade in active" id="profile">
  
  <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
  	

    <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
    <?php if($objsession->get('gs_msg') != ""){?>
<div class="newmsm">
<?php echo $objsession->get('gs_msg');?>
</div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}?>
   <form name="frmAlbum" id="frmAlbum" method="post">
      <div class="">
      <div class="form-group">
        <label for="Availability" class="col-lg-4 control-label">Album Name</label>
        <div class="col-lg-8">
          <input type="text" required="" name="albumName" id="albumName" class="form-control mt10" />
        </div>
      </div>
      </div>
      <div class="">
      <div class="form-group">
        <label for="Availability" class="col-lg-4 control-label"></label>
        <div class="col-lg-8">
          <input type="submit" name="btn_album" class="form-control mt10" value="SUBMIT" />
        </div>
      </div>
      </div>
   </form>
   
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
    
   <form name="frmVideo" id="frmVideo" enctype="multipart/form-data" method="post">
  	  <div class="">
    	<div class="form-group">
        <label for="Availability" class="col-lg-4 control-label">Select Type</label>
        <div class="col-lg-8 mt10">
          <select name="iAlbumID" id="iAlbumID" class="form-control" >
                <option value="">Select Album</option>
                <?php 
			  	if(!empty($albummaster)){
				  for($a=0;$a<count($albummaster);$a++){
			  	?>
                <option value="<?php echo $albummaster[$a]['iAlbumID'];?>"><?php echo $albummaster[$a]['sAlbumName'];?></option>
                <?php 
				  }
			  } 
			  ?>
              </select>
        </div>
      </div>
      </div>
      <div class="">
      <div class="form-group">
        <label for="Availability" class="col-lg-4 control-label">Upload Image</label>
        <div class="col-lg-8 mt10">
          <input type="file" name="sGalleryImages[]" multiple="multiple" id="sGalleryImages" class="form-control file" />
        </div>
      </div>
      </div>
      <div class="">
      <div class="form-group">
        <label for="Availability" class="col-lg-4 control-label"></label>
        <div class="col-lg-8 mt10">
          <input type="submit" name="btn_sub" class="form-control" value="SUBMIT" />
        </div>
      </div>
      </div>
   </form>
    </div>
   
  </div>
  </div>
</div>
</div>
  </div>
      </div>
<?php
if(isset($_POST['btn_album'])){
	
	extract($_POST);
	
	$field = array("iLoginID","sAlbumName","isActive");
	$value = array($objsession->get('gs_login_id'),$albumName,1);		
	$obj->insert($field,$value,"albummaster");
$objsession->set('gs_msg','Albume Added sucessfully !');
	redirect(URL.'views/managealbum.php');
}

if(isset($_POST['btn_sub'])){
	
	extract($_POST);
	
	$type = $obj->fetchRow("albummaster","iAlbumID = ".$iAlbumID);
	
	$sMultiImage = '';
	if($_FILES["sGalleryImages"] != ''){
		
			for($i=0;$i<count($_FILES["sGalleryImages"]['name']);$i++) {
				if($_FILES["sGalleryImages"]['name'][$i] != ''){
				$randno = rand(0,5000);
				$img = $_FILES["sGalleryImages"]['name'][$i];
				
				$folderPath =  "../upload/gallery/".$type['sAlbumName'];
				$exist = is_dir($folderPath);
				
				if(!$exist) {
					mkdir("$folderPath");
					chmod("$folderPath", 0755);
				}
				
					
	
				move_uploaded_file($_FILES["sGalleryImages"]['tmp_name'][$i],$folderPath.'/'.$randno.$img);
				
				$field = array("iLoginID","iAlbumID","sGalleryImages","isActive");
				$value = array($objsession->get('gs_login_id'),$iAlbumID,$randno.$img,1);		
				$obj->insert($field,$value,"gallerymaster");
			
				}
			}
		}	
	
	if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'church'){
  		redirect(URL.'views/churchprofile.php');
	}else{
		redirect(URL.'views/artistprofile.php');	
	}
}
?>
<?php include('../include/footer.php');?>