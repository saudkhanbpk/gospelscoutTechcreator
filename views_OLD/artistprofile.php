<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">

  
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL;?>css/magnific-popup.css">
  
  <script type="text/javascript" src="<?php echo URL;?>js/jquery.magnific-popup.min.js"></script>



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
	
	
$("#album01").change(function(){
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
<style>
iframe{
	width:100%;
}
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
.txttitle {
	color: #8e44ad;
	font-size: 20px;
	font-weight: bold;
	padding-top: 20px !important;
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
</style>
<script>
window.document.onkeydown = function (e)
{
    if (!e){
        e = event;
    }
    if (e.keyCode == 27){
        lightbox_close();
    }
}

</script>
<link href="<?php echo URL;?>css/rating-1.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>
<?php 
if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){
	
	if(isset($_GET['artist']) > 0){
		if($_GET['artist'] == $objsession->get('gs_login_id')) {
			header('Location:'. URL .'views/artistprofile.php');			//https://dev.gospelscout.com/
		}
		else {
			$cond = "";
			$cond = "iLoginID = ".$_GET['artist'];
			$userRow = $obj->fetchRow("usermaster",$cond);
			$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
			$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$_GET['artist']);
		}
	}else{
		$cond = "";
		$cond = "iLoginID = ".$objsession->get('gs_login_id');
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
	}
}
elseif($objsession->get('gs_login_type') == "" && $_GET['artist'] == "") {
	header('Location: '. URL .'views/search4artists.php');
}
else{
	
	if($_GET['artist'] > 0){
		
		$cond = "";
		$cond = "iLoginID = ".$_GET['artist'];
		$userRow = $obj->fetchRow("usermaster",$cond);
		$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$_GET['artist']);
		$usermaster = $obj->fetchRow("rollmaster","iLoginID = ".$_GET['artist']);
		
	}	
}
$states = $obj->fetchRowAll("states",'country_id = 231');
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypal_id='maulik@omshantiinfotech.com';
		
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




if(isset($_GET['artist']) > 0){
$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$_GET['artist']);
$gistmaster_1 = $obj->fetchRowAll("rollmaster","iLoginID = ".$_GET['artist']);
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$_GET['artist']);
}else{
$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
$gistmaster_1 = $obj->fetchRowAll("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));
$albummaster = $obj->fetchRowAll("albummaster","isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id'));
}

$giftmaster = $obj->fetchRowAll("giftmaster","isActive = 1 ");
$giftmaster01 = $obj->fetchRowAll("eventtypes","isActive = 1 ");

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
      <div class="profile"> <img style="object-fit: cover; object-position: 0,0;height:235px;border: 2px solid rgb(142,68,173);" src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];}else{?>img/profile.jpg<?php }?>" class="img-responsive center-block"> </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item collaps active"> <a class="nav-link" href="#profile" role="tab" data-toggle="tab">Video</a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Photos</a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#references" role="tab" data-toggle="tab">Bio</a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#pdf" role="tab" data-toggle="tab">Book Me</a> </li>
      <li class="nav-item collaps"> <a class="nav-link" href="#subscribe" role="tab" data-toggle="tab">Subscribe</a> </li>
    </ul>
    <link href="<?php echo URL;?>css/rating.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo URL;?>js/rating.js"></script> 
    
    <!-- Tab panes -->
    <div class="col-lg-4 col-md-4 col-sm-4 p0">
      <div class="white">
        <div class="">
          <?php if ( $usermaster['sGroupType'] == 'group' ) { ?>
          <h3 class="text-left" style="font-size: 28px;font-weight: bold;text-transform: capitalize;">Group Info</h3>
          <?php } else {?>
          <h3 class="text-left" style="font-size: 28px;font-weight: bold;text-transform: capitalize;">Artist Info</h3>
          <?php } ?>
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Current City:</b></p>
          </div>
          <div class="col-md-7 col-xs-6">
            <p>
              <?php 
                
                if($userRow['sCityName'] != '')
                $city = $obj->fetchRow('cities',"id = ".$userRow['sCityName']);
                echo ucfirst($city['name']).',';                
                ?>
              <?php 
                if($userRow['sStateName'] != '')
                $city = $obj->fetchRow('states',"id = ".$userRow['sStateName']);
                echo ucfirst($city['statecode']);
                echo "&nbsp;&nbsp;";
                
                if($userRow['iZipcode'] != '')echo $userRow['iZipcode'];?>
            </p>
          </div>
        </div>
        <div class="clear"></div>
        <div class="col-md-5 col-xs-6" style="padding:0px;">
          <p><b>Age: </b></p>
        </div>
        <?php
					if ( $usermaster['sGroupType'] == 'group' ) { 
						$clNo = 12;
					}else {
						$clNo = 7;
					}
					
				?>
        <div class="col-md-<?php echo $clNo;?> col-xs-<?php echo $clNo;?>" style="margin-top: -30px; margin-left: 120px;">
          <p >
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
          Years Old</p>
        </div>
        <div class="clear"></div>
        <div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Availability:</b></p>
          </div>
          <div class="col-md-7 col-xs-6">
            <p id="Avail" style="word-break: break-all;">
              <?php if($userRow['sAvailability'] != '') {
              		if(ucwords(strstr(str_replace('_',' ',$userRow['sAvailability']), '(', true)) != ''){
              			echo ucwords(strstr(str_replace('_',' ',$userRow['sAvailability']),"(",true));
              		}
              		else{
              			echo $userRow['sAvailability'];
              		}
              	     }
             ?>
              
             
              <div id="availDeet" style="position: absolute; top: 0px; width: auto; padding:0 5% 0 5%; box-shadow: -1px 1px 10px #888888; background: white; z-index:10; font-size: 12px; color: #9043A7">
              <?php 
              		$availibilityDescip = ucwords(strstr(str_replace('_',' ',$userRow['sAvailability']), '(', false));
              		echo trim($availibilityDescip, '()');
              	?>
              </div>
              
              
            </p>
          </div>
        </div>
        <div class="clear"></div>
        <div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>My Talent(s):</b></p>
          </div>
          <div class="col-md-<?php echo $clNo;?> col-xs-<?php echo $clNo;?>" style="float:left;">
            <p style="word-break: break-all;margin-right: 60px;width:100%;">
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
							/*
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
							*/
							
							$commaRemove = rtrim($userRow['iGiftID'], ',');
							$talent = explode(',',$commaRemove); 
							if(count($talent)>1) {

								echo '<ol style="margin:0 0 0 10%; padding:0; color:#9043A7">';
										foreach($talent as $a) {
											if($a != "") {
												echo '<li>';
													echo ucwords(str_replace("_","/",$a));
												echo '</li>';
											}
										}
								echo '</ol>';
							}
							else {									
								$talentEdit = str_replace("_","/",$commaRemove);
								echo $talentEdit;									
							}
								
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
        <div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Contact Number:</b></p>
          </div>
          <div class="col-md-6 col-xs-6">
            <p style="word-break: break-all;">
              <?php if($userRow['sContactNumber'] != ''){
              	//echo $userRow['sContactNumber'];
              	/*The substr_replace() method is used to insert '-' 
              	 into the phone numbers to make them more 
              	*/
	              	$artistContact = $userRow['sContactNumber'];
	              	$artistContact1 = substr_replace($artistContact, '-', 3, 0);
	              	$artistContact2 = substr_replace($artistContact1, '-', 7, 0);
	              	echo $artistContact2;
              	}
              	else{
              		echo 'N/A';
              	}
              ?>
            </p>
          </div>
        </div>
        <div class="clear"></div>
        <div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;">
            <p><b>Contact Email:</b></p>
          </div>
          <div class="col-md-6 col-xs-6">
            <p id="ArtistEmail" style="word-break: break-all;">
              <?php 
			  		if($userRow['sContactEmailID'] != ''){
			  		
			  			//The following conditional allows the site to truncate email addresses longer than 14 characters
				  		$emailLength = strlen($userRow['sContactEmailID']);
				  		if($emailLength>14) {
				  			$artistEmail = $userRow['sContactEmailID']; 
				  			$artistEmailShort = substr_replace($artistEmail, '...', 13); 
				  			echo $artistEmailShort; 
			
							echo '<div id="FullEmail" style="position: absolute; top: 0px; width: auto; text-align:center; padding:0 5% 0 5%; box-shadow: -1px 1px 10px #888888; background: white; z-index:10; font-size: 12px; color: #9043A7">';
									echo $userRow['sContactEmailID'];
							echo '</div>';
				  		}
				  		else { 
				  			echo wordwrap($userRow['sContactEmailID'],18,"\n",true);
				  		}
				  	} else {
						echo '---';
					}?>
					
					<script>
					//This function allows the user to hover over the availability and email address to view the description and address respectively
					function showDescrip(itemShort, itemLong) {
	              				$(itemLong).hide(); 
		              			$(itemShort).hover(function() {
		              				$(itemLong).show(); 
		              			});
		              			$(itemShort).mouseout(function() {
	              					$(itemLong).hide(); 
	              				});
	              			};
	              			showDescrip('#Avail', '#availDeet');
					showDescrip('#ArtistEmail', '#FullEmail');
					</script> 
            </p>
          </div>
        </div>
        <div class="clear"></div>
        <?php
        
			if(isset($_GET['artist']) && $objsession->get('gs_login_id') > 0){
			
				$cond1 = "iLoginID = ".$objsession->get('gs_login_id')." AND iUserID = ".$_GET['artist'];
				$retting1 = $obj->fetchRow('userratting',$cond1);

//				$ratingNum1 = $obj->fetchNumOfRow('userratting',$cond);
				$total1 = $retting1['iTotalPoint'];
				$total_n = 0;
				$totap_p = 0;

for($j=0;$j<count($gistmaster_1);$j++){
	
			if( $gistmaster_1[$j]['sVideo'] != "" ) {
				$vdiList_new = explode(',',$gistmaster_1[$j]['sVideo']);

				foreach($vdiList_new as $vd_n){
					
					$cond = "sVideoName = '".$vd_n."' AND status = 1";
					
					$retting_n = $obj->fetchAverageTotal('videoratting','iTotalPoint',$cond);
					$ratingNum_n = $obj->fetchNumOfRow('videoratting',$cond);
					
					$total_n = $total_n + $retting_n['average_rating'];
					$totap_p = $totap_p + $ratingNum_n;
				}
			}
			
}
		
		?>
        <script language="javascript" type="text/javascript">
$(function() {
    $("#userrateTotal2").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $userRow['iRateAvg'];?>',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});
</script>
<script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>
        <script language="javascript" type="text/javascript">

$(function() {
    $("#userrateTotal1").codexworld_rating_widget({
        starLength: '5',
        initialValue: '<?php echo $total1;?>',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});

$(function() {
    $("#userrateTotal").codexworld_rating_widget({
        starLength: '5',
        initialValue: '<?php echo $total1;?>',
        callbackFunctionName: 'processRating',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});

function processRating(val, attrVal){
		
    $.ajax({
        type: 'GET',
        url: '<?php echo URL;?>views/userrating.php',
        data: 'postID='+attrVal+'&ratingPoints='+val+'&iUserID=<?php echo $_GET['artist'];?>',
        dataType: 'json',
        success : function(data) {
            if (data.status == 'ok') {
                alert('You have rated '+val+'');
				window.location.reload();
               $('#avgrat').text(data.average_rating);
                $('#totalrat').text(data.rating_number);
            }else{
                alert('Some problem occured, please try again.');
            }
        }
    });
}

</script>
		<?php
		$rated = $obj->fetchRow("userratting","iLoginID = ".$objsession->get('gs_login_id')." AND iUserID = '".$_GET['artist']."'");
		
		if(count($rated) > 1)
		{
				}
				else
				{
			?>
			<div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;"><p><b>Rate This Artist</b></p></div>
          <div class="col-md-7 col-xs-6">
            <p>
              <input name="rating" value="0" id="userrateTotal" type="hidden" postID="<?php echo $objsession->get('gs_login_id');?>" />
            </p>
          </div>
        </div>
        <div class="clear"></div>
		<?php 
			}
			?>
			<div class="">
          <div class="col-md-5 col-xs-6" style="padding:0px;"><p><b>Artist's Overall Rating With <?php echo $userRow['rating_number'];?> Users</b></p></div>
          <div class="col-md-7 col-xs-6">
            <p>
              <input name="rating" value="0" id="userrateTotal2" type="hidden" postID="<?php echo $objsession->get('gs_login_id');?>" />
            </p>
          </div>
        </div>
        <div class="clear"></div>
<?php
			
			}
        ?>
      </div>
      <div class="clear"></div>
      <?php   
				
				if( isset($_GET['artist']) == '' ){
					$iActistID = $objsession->get('gs_login_id');	
				}else{ 
					$iActistID = $_GET['artist'];
				}
				//$cond="doe >= '".date('Y-m-d')."' AND (iLoginID = ".$iActistID." OR FIND_IN_SET('".$iActistID."',iIDs)) ORDER BY doe ASC LIMIT 1";	

				$cond="doe >= '".date('Y-m-d')."' AND (iLoginID = ".$iActistID.") ORDER BY doe ASC LIMIT 1";	
				$rolemaster = $obj->fetchRow("eventmaster",$cond);
				$siddhant=(explode(",",$rolemaster['sMultiImage'])); 
				
				
			?>
      <div class="white">
        <h3 class="text-center">Upcoming Events</h3>
        <?php /*if ( empty($rolemaster) ) { ?>
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
	       	 	<!-- href="<?php echo URL;?>views/eventdisplay.php" -->
        		<h4><a href="<?php echo URL;?>calendar/calendarDisplay.php?u_Id=<?php if(isset($_GET['artist'])){echo intval($_GET['artist']);}else{echo intval($objsession->get('gs_login_id'));}?>">View Full Event Calendar <i class="fa fa-calendar"></i></a></h4>
        <?php 
    		} 
    		else { */
    	?>
				<!--
			        <p class="noevent">Artist has no upcomming events.</p>
			    -->
			    <style>
			    	.upcominGigs {
			    		position: relative;
			    		width: 90%; 
			    		margin: 20px auto 0px;
			    		min-height: 60px;
			    		//background-color: blue;
			    		padding: 5px;
			    		box-sizing: border-box;
			    		box-shadow: -2px 2px 10px 2px rgba(0,0,0,.4);
			    	}
			    </style>

			    <?php 
			    	require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/pdo/dbConnect.php');
			    	

			    	if(isset($_GET['artist']) && intval($_GET['artist']) > 0 && intval($_GET['artist']) != $objsession->get('gs_login_id')) {
			    		$userLogin = intval($_GET['artist']);
			    		$privSetting = 'pub';
			    		
			    	}
			    	elseif(isset($_GET['church'])) {
			    		header('Location:'. URL .'views/search4artists.php');
			    		//$userLogin = intval($_GET['church']);
			    		//$privSetting = 'pub';
			    	}
			    	elseif($objsession->get('gs_login_id') != "") {
			    		$userLogin = $objsession->get('gs_login_id');
					$privSetting = 'all';
						 
			    	}
			    	else{
					header('Location:'. URL .'views/search4artists.php');
				}
				
				require_once(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/event_gigQuery.php');
				
					if(count($finalList) > 0) {
				    	 $hoy = date_create(date());
				    	 $hoy = date_format($hoy, 'Y-m-d H:i:s');

				    	 /* Test current gig date for expiration then assign array index to event according to date */
					    	for($i=0;$i<count($finalList);$i++){
					    			$j = 0;
					    			if($finalList[$i]['start'] >= $hoy) {
						    			foreach($finalList as $test){
						    				if($finalList[$i]['start'] > $test['start']) {
						    					$j += 1; 
						    				}
						    			}
						    			$newArray[$j] = $finalList[$i]; 
						    		}
					    	}
				    	ksort($newArray);	//Sort the array elements in the correct order according to index   rgba(0,0,0,.4);
				    }
				    else {
			    		if(isset($_GET['artist']) && intval($_GET['artist']) > 0 && intval($_GET['artist']) != $objsession->get('gs_login_id')) {
				    		echo '<p class="noevent">This artist has no upcomming gigs or events.</p>';
				    	}
				    	elseif(isset($_GET['church']) && intval($_GET['church']) > 0 && intval($_GET['church']) != $objsession->get('gs_login_id')) {
				    		echo '<p class="noevent">This church has no upcomming gigs or events.</p>';
				    	}
				    	elseif($objsession->get('gs_login_id') != "") {
				    		echo '<p class="noevent">You have no upcomming gigs or events.</p>';
				    	}	
			    	} 
			    ?>
			    <?php 
			    	$r=0; 
			    	foreach($newArray as $event) {
			    		if($r<4) {
			    ?>
						    <a href="<?php echo $event['url']; ?>">
							    <div class="upcominGigs" style="border: 1px solid <?php echo $event['backgroundColor'];?>">
							    	<h3><?php echo $event['title']; ?></h3>
							    	<table>
							    		<!--
								    		<tr>
								    			<td>Type: </td>
								    			<td><?php echo $event; ?></td>
								    		</tr>
								    	-->
							    		<tr>
							    			<td>Date: </td>
							    			<td style="padding-left: 3px;">
							    				<?php 
							    					$newForm = date_create($event['start']);
							    					$newForm = date_format($newForm, 'D, d M y g:ia');
							    					echo  $newForm;
							    				?>
							    			</td>
							    		</tr>
							    	</table>
							    </div>
							</a>
				<?php 
							$r++; 
						}
						else {
							break; 
						}
					} 
				?>
				<h4><a href="<?php echo URL;?>calendar/calendarDisplay.php?u_Id=<?php if(isset($_GET['artist'])){echo intval($_GET['artist']);}else{echo intval($objsession->get('gs_login_id'));}?>">View Full Event Calendar <i class="fa fa-calendar"></i></a></h4>
				<!-- "<?php echo URL;?>views/eventdisplay.php" -->
        <?php //} ?>
      </div>
    </div>
    <style type="text/css">
    .overall-rating{font-size: 14px;margin-top: 5px;color: #8e8d8d;}
</style>
    
    <!--Video ratting section end-->
    
    <div class="col-lg-8 col-md-8 col-sm-8">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="profile">
          <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
            <h3>Videos</h3>
            <?php
		if(count($gistmaster) > 0){

			$vid = 0;
			$vR = 1;
			$vUR = 0;
			$vdCheck = '';
			$yu = 0;
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
				$vdiImage = explode(',',$gistmaster[$gi]['sVideoImages']);

				//$vdiList = array_reverse($vdiList);
				
				if(($gistmaster[$gi]['sVideo'] || $gistmaster[$gi]['sYoutubeUrl']) == "" && $vdCheck == ""){
					
					if ( $gistmaster[$gi]['sYoutubeUrl'] != "" ) {
						$vdCheck = 'test';
					} else {
						$vdCheck = '';
					}
				}else{
					$vdCheck = 'test';
				}
				
	?>
            <div class="row <?php if($gistmaster[$gi]['sVideo'] || $gistmaster[$gi]['sYoutubeUrl'] != ""){?> borderbuttom<?php } ?>">
				
              <form name="frmVideo" id="frmVideo">
                <?php if($vdCheck != ""){ ?>
                <div class="video_sec">
                  <?php if($gistmaster[$gi]['sGroupType'] == 'solo' && ($gistmaster[$gi]['sVideo'] || $gistmaster[$gi]['sYoutubeUrl']) != ""){
			//$mini_name=ucfirst($gistmaster[$gi]['sGiftName']);
			$mini_name=ucwords(str_replace('_',' ',$gistmaster[$gi]['sGiftName']));?>

                  <h3 style="float:left;"><?php echo $mini_name;?></h3>
                  <?php } ?>
                  <?php
		if(isset($_GET['artist'])){
			$url = "?categoryname=".$gistmaster[$gi]['sGiftName']."&artist=".$_GET['artist'];
		}else{
			$url = "?categoryname=".$gistmaster[$gi]['sGiftName'];
		}
		?>
                  <?php if($gistmaster[$gi]['sGroupType'] == 'solo' && ($gistmaster[$gi]['sVideo'] || $gistmaster[$gi]['sYoutubeUrl']) != "" ){?>
                  <a href="<?php echo URL;?>views/viewallvideo.php<?php echo $url;?>" style="float:right;">View All</a>
                  <?php } ?>
                </div>
                <div class="" style="clear:both;"></div>
                <?php 
			if($gistmaster[$gi]['sVideo'] != ""){ 
				
				$v = 0;
				
				$count1 = 0;
				foreach($vdiList as $vd){
					$count1 ++;
				
					if($vid < 4){
				 
		?>
                <div class="col-lg-3 col-mg-3 col-sm-3" >
                  <?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
								?>
                  <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&image=<?php echo $vdiImage[$v];?>&videoType=<?php echo $gistmaster[$gi]['sGiftName'];?>&type=video&videName=<?php echo $vdiName[$v];?>&name=<?php echo $vd;?>&main=artist">X</a></div>
                  <?php } ?>
					
                  <div style="margin-top: 20px;">
                    <?php if(isset($_GET['artist'])){ ?>
                    <a href="<?php echo URL;?>views/artistvideodetails.php?artist=<?php echo $_GET['artist'];?>&video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                    <?php }else{?>
                    <a href="<?php echo URL;?>views/artistvideodetails.php?video=<?php echo $vdiList[$v];?>&cat=<?php echo $gistmaster[$gi]['sGiftName'];?>">
                    <?php } ?>
                    <?php if($gistmaster[$gi]['sGroupType'] == 'solo'){?>
                    <?php /*?><video width="400" class="img-responsive center-block videoHeght">
                      <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
                    </video><?php */
					if ( $vdiImage[$v] != "") {
					?>
                    <img style="object-fit:cover; object-position: 0,0;" src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
                    <div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                    <?php } }else{ ?>
                    <?php /*?><video width="400" class="img-responsive center-block">
                      <source src="<?php echo URL;?>upload/artist/video/group/<?php echo $vd;?>" type="video/mp4">
                    </video><?php */
						if ( $vdiImage[$v] != "" ) {
					 ?>
                    <img style="object-fit:cover; object-position: 0,0;" src="<?php echo URL;?>upload/artist/video/group/<?php echo $vdiImage[$v];?>" width="400" class="img-responsive center-block" />
                    <?php } else {?>
                    <div class="noimage"><img src="<?php echo URL;?>upload/default_video_m.jpg" width="400" class="img-responsive center-block" /></div>
                    <?php }} ?>
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
				window.location = "<?php echo URL;?>views/artistvideodetails.php?video="+val+"&cat="+cat;  
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
        imageDirectory: '<?php echo URL;?>img/',
        inputAttr: 'postID'
    });
});

</script>
                    <h2 style="color: black; font-weight: bold;">
                      <?php 
									
									$mynqme = pathinfo($vdiName[$v],PATHINFO_FILENAME);
									//echo wordwrap($mynqme,10,"\n",true);
									echo substr($mynqme, 0, 12)
									?>
                    </h2>
                    <p class="tital1">Views : 
                      <?php if(!empty($videocount)){echo $videocount['iViews'];}else{echo '0';}?>
                     </p>
                    <input type="hidden" name="sVideoName" id="sVideoName<?php echo $gistmaster[$gi]['iRollID'];?>" value="<?php echo $vdiList[$v];?>" />
                    <input type="hidden" name="cat" id="cat<?php echo $gistmaster[$gi]['iRollID'];?>" value="<?php echo $gistmaster[$gi]['sGiftName'];?>" />
                    <p class="tital1">Days Ago : 
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
				<input name="rating" value="0" id="rating_star<?php echo $vR;?>" type="hidden" postID="1" />
                    </a> </div>
                </div>
                <?php			
									
					}
		
		$vR ++;
		$v ++;

		if( $gistmaster[$gi]['sGroupType'] != 'group') {
			$vid ++;
			$vUR ++;
			
					}

				}
				
				$vid = 0;
			}

		?>
                
				<?php if($gistmaster[$gi]['sYoutubeUrl'] != ""){

						
				$count = 0;
					
				$youtube = explode(',',$gistmaster[$gi]['sYoutubeUrl']);
			
					
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
					
					if( $gistmaster[$gi]['sGroupType'] != 'group') {
						
					}

					$filename = substr(strrchr($key, "="), 1);	
					
					if($filename != "")			{
					$yu ++;
		?>
                <div class="col-lg-3 col-mg-3 col-sm-3">
                  <?php
								if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
								?>
                  <div class="de"> <a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&videoType=<?php echo $gistmaster[$gi]['sGiftName'];?>&type=youtubevideo&videName=<?php echo $key;?>&main=artist&iyoutubeid=<?php echo $gistmaster[$gi]['iRollID']; ?>">X</a></div>
                  <?php
								}?>
                  <div style="margin-top: 20px;"><?php if(isset($_GET['artist'])){?>
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
	$total = round($retting['average_rating'] / $ratingNum);
}

?>
                    
                    <!--Video ratting section start--> 
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
      //  inputAttr: 'postID'
    });
});

</script> 
                   <p style="color: black; font-weight: bold;" class="Uname" id="uname<?php echo $yu;?>"></p>
                    <p class="tital1" id="Uviews<?php echo $yu;?>"></p>
                    <p class="tital1" id="uDate<?php echo $yu;?>"></p>
					<input name="rating" value="0" id="rating_star01<?php echo $yu;?>" type="hidden" postID="1" />
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
				days = "Month Ago : "+(Math.round(days)) ;
			} else if ( days > 365 ) {
				days = days / 365;
				days = "year Ago : "+(Math.round(days));
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
                <?php 
						$yu ++;
				 	}
				}
			}
		} ?>
                <?php } ?>
              </form>
            </div>
            <?php 
			}
		
			if($vdCheck == ''){
				if ( $usermaster['sGroupType'] == 'group') { 
					echo "<h3 style='color: #ccc; font-family: v;' class='h3new'>This Band Has No Videos Uploaded </h3>";	
				} else  {
					echo "<h3 style='color: #ccc; font-family: v;' class='h3new'>This Artist Has No Videos Uploaded </h3>";	
				}
			}
	}else{
				if ( $usermaster['sGroupType'] == 'group') { 
					echo "<h3 style='color: #ccc; font-family: v;' class='h3new'>This Band Has No Videos Uploaded </h3>";	
				} else  {
					echo "<h3 style='color: #ccc; font-family: v;' class='h3new'>This Artist Has No Videos Uploaded </h3>";	
				}
		
		}?>
          </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="buzz">
          <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
            <?php 
  if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
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
							if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
							?>
                <a style="float: right; color: red;" onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistprofile.php?iLoginID=<?php echo $objsession->get('gs_login_id');?>&photo=<?php echo $gallerymaster[$a]['sGalleryImages'];?>&type=album&name=<?php echo $albummaster[$a]['sAlbumName'];?>&galleryID=<?php echo $gallerymaster[$a]['iGalleryID'];?>">X</a>
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
                <a href="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>"><img style="object-fit:cover; object-position: 0,0;" src="<?php echo URL;?>upload/gallery/<?php echo $albummaster[$a]['sAlbumName'];?>/<?php echo $gallerymaster[$ga]['sGalleryImages'];?>" class="img-responsive center-block artistphotos"> </a> </li></div>
              <?php 
							 $popimg ++;
					  }
					  
					  
						  
					?>
            </div>
            <?php
					  $n = $n + 11;
				  }
			}else{
				echo '<h3 style="color: #ccc; font-family: v;" class="h3new">This artist Has No Photos Uploaded</h3>';	
			}
			?>
          </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="references">
          <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Years of Experience</p>
              <h2>
                <ul class="year">
                  <li><strong style="margin-left: -40px; font-weight: 400; font-weight: 400;">
                    <?php if($userRow['iYearOfExp'] != ''){echo $userRow['iYearOfExp'];}else{echo '0';}?>
                    years</strong></li>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Musical Influences</p>
              <h2>
                <ul class="year">
                  <?php 
		if($userRow['sMusicalInstrument'] != ''){
			
		?>
                  <li style="list-style:none;margin-left: -40px;word-break: break-all; "><?php echo $userRow['sMusicalInstrument'];?></li>
                  <?php  }?>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">What kind of Music do you play</p>
              <h2>
                <ul class="year">
                  <?php 
		if($userRow['sKindPlay'] != ''){
			
		?>
                  <li style="margin-left: -40px;word-break: break-all;"><strong style="font-weight: 400;"><?php echo $userRow['sKindPlay'];?></strong></li>
                  <?php 
	   	
	    }?>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
              <p style="font-size: 14px;">Who have You Played for</p>
              <h2>
                <ul class="year">
                  <?php 
		if($userRow['sPlayedFor'] != ''){
			
		?>
                  <li style="margin-left: -40px;word-break: break-all;"><strong style="font-weight: 400;"><?php echo $userRow['sPlayedFor'];?></strong></li>
                  <?php  }?>
                </ul>
              </h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text p0">
              <p style="font-size: 14px;">Where have you played</p>
              <h2>
                <ul class="year">
                  <?php 
		if($userRow['sHavePlayed'] != ''){
			
		?>
                  <li style="margin-left: -40px;word-break: break-all;"><strong style="font-weight: 400;"><?php echo $userRow['sHavePlayed'];?></strong></li>
                  <?php }?>
                </ul>
              </h2>
            </div>
          </div>
        </div>
        <script>$().ready(function() {
	
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
				sEventName: {
					  required:true,
					},
				
				sAddress: "required",				
				stateId: {
					  required:true,
					},
				cityId: {
					  required:true,
					},
				zipcode: "required",
				sTimeOfEvent: "required",
				booking: {
					  required:true,
					},
				iAmountID: {
					  required:true,
					  number:true
					},
				
				
			},

			messages: {
				sEventName: {
					  required:"Please enter event name",
					},
				
				sAddress: "Please enter address",				
				stateId: {
					  required:"Please select state",
					},
				cityId: {
					  required:"Please select city",
					},
				zipcode: "Please enter zipcode",
				sTimeOfEvent: "Please enter event time",
				booking: {
					  required:"Please select event type",
					},
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

	$dateList = explode('-',$edate);
	$eFullDate = $dateList[2].'-'.$dateList[0].'-'.$dateList[1];

	$field = array("iRollID","iLoginID","event_name","address_event","state","city","zipcode","doe","toe","amount_deposite","sType","dCreatedDate","sStatus","isActive","bookingMe","dDepositeDate");
		$value = array($_GET['artist'],$objsession->get('gs_login_id'),$sEventName,$sAddress,$state,$city,$zipcode,$eFullDate,$sTimeOfEvent,$iAmountID,$booking,date("Y-m-d"),"Pending",1,$bookingMe,date("Y-m-d",strtotime($dDepositeDate)));		
	$iLastBookID = $obj->insert($field,$value,"bookingmaster");
	if($iLastBookID){
	
	/*echo "<script>alert('Event added successfully.');</script>";*/
	$objsession->set('gs_total_amount',$iAmountID);
	$objsession->set('gs_book_id',$iLastBookID);
	
	$tax = ($objsession->get('gs_total_amount') * 7 ) / 100;
	
	if ( $iAmountID >= 0 ) {
	
	?>
        <script>
			$(document).ready(function(){
					$( "#frmPayPal1" ).submit();
			});
			
			</script>
        <form action='<?php echo URL."views/artistbooking.php?paypal=$paypal_id&booked_id=".$_GET['artist'] ?>' method='post' id="frmPayPal1" name='frmPayPal1'>
          <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
          <input type='hidden' name='cmd' value='_xclick'>
          <input type='hidden' name='item_name' value='Event'>
          <input type='hidden' name='item_number' value='1'>
          <input type='hidden' name='amount' id="amount" value="<?php if($objsession->get('gs_total_amount') > 0){echo $objsession->get('gs_total_amount');}?>" >
          <input type="hidden" name="tax" value="<?php echo $tax;?>">
          <input type='hidden' name='no_shipping' value='1'>
          <input type='hidden' name='currency_code' value='USD'>
          <input type='hidden' name='handling' value='0'>
          <input type='hidden' name='cancel_return' value='<?php echo URL."views/cancelbooking?type=cancel"; ?>'>
          <input type='hidden' name='return' value='<?php echo URL."views/artistbooking.php?paypal=$paypal_id&booked_id=".$_GET['artist'] ?>'>
        </form>
        <?php
		//Mona@onshantiinfotech.com
		} else {
			
			redirect(URL.'views/artistbooking.php');
		}
	}
	
	
	}
  ?>
        <div role="tabpanel" class="tab-pane fade" id="pdf">
          <div class="col-lg-12 col-md-12 col-sm-12 white mg0 p15">
            <?php if($objsession->get('gs_login_id') == 0){?>
            <h3>Book Me</h3>
            <p>Please login for subscription : </p>
            <div class="text-right"> <a data-target="#myModal" class="login" data-toggle="modal" href="#">Login</a> </div>
            <?php 	}else { ?>
            <form id="frmevent" role="form" name="frmevent" method="post" enctype="multipart/form-data">
              <div id="myModal01" class="modal fade" role="dialog">
                <div class="modal-dialog"> 
                  
                  <!-- Modal content-->
                  <div class="modal-content" style=" width: 110%;  border: 1px solid #9c69d0;border-radius: 0;background:#ececec;">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="loginh2">
                        <h2 class="txttitle">Thank You For Booking!!! </h2>
                        <p>Thank You for sending an event booking through GospelScout.com. Please click continue to move on to the payment portion of the booking submission.</p>
                      </div>
                      <div class="loginh3"> <span class="txtlable">By Clicking Continue I agree that:</span>
                        <p>I have read and accepted the <a target="_blank" href="<?php echo URL;?>views/termsandcondition.php" style="color:#337ab7;">Terms of Use</a></p>
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
                    <label for="email">Name of Event:</label>
                    <input type="text" class="form-control" id="sEventName" name="sEventName" placeholder="Name Of Event">
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="pwd">Address of Event:</label>
                    <input type="text" class="form-control" id="sAddress" name="sAddress" placeholder="Street Address">
                  </div>
                </div>
              </div>
				
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <select name="state" class="form-control states" id="stateId">
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
                  <label>Time of Event</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <input type="text" class="form-control"  id='sTimeOfEvent' name="sTimeOfEvent" >
                    <span id="hello01"><i class="fa fa-clock-o"  aria-hidden="true"></i></span> </div>
                </div>
              </div>
              <script type="text/javascript">
            $(function () {
                $('#sTimeOfEvent').datetimepicker({
                    format: 'LT'
                });
				
				$( "#hello01" ).click(function() {
					$( "#sTimeOfEvent" ).focus();
				});
				
            });
        </script>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <label>Event Date</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <input type="text" class="form-control"  id='edate' name="edate">
                    <span id="hello"><i class="fa fa-calendar"  aria-hidden="true"></i></span> </div>
                </div>
              </div>
              <script type="text/javascript">
            $(function () {
               $('#edate').datetimepicker({
					format: 'MM-DD-YYYY',
					//ignoreReadonly: true,
					//disabledDates:[moment().subtract(1,'d')],
				});	
				
				$( "#hello" ).click(function() {
					$( "#edate" ).focus();
				});
            });
        </script>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <label>Event Type</label>
                  <div class="form-group">
                    <select class="form-control" name="booking" id="booking">
                      <option value="">Select event type</option>
                      <?php
			if(count($giftmaster01) > 0){
				for($s=0;$s<count($giftmaster01);$s++){
			?>
                      <option value="<?php echo $giftmaster01[$s]['iEventID'];?>"><?php echo $giftmaster01[$s]['sName'];?></option>
                      <?php
				}
			}
			?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <label>Booking Artist As</label>
                  <div class="form-group">
                    <select class="form-control" name="bookingMe" id="bookingMe">
                      <option value="">Select</option>
                      <?php 
                    if(count($gistmaster) > 0){
						$str = '';
						for($m=0;$m<count($gistmaster);$m++){
							?>
                      <option value="<?php echo $gistmaster[$m]['sGiftName'];?>"><?php echo $gistmaster[$m]['sGiftName'];?></option>
                      <?php
						}
					}
                ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <label>Price</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <label>Deposit Date</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <div class="col-lg-1 col-md-1 col-sm-1">
                      <p class="dot">$</p>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10">
                      <input type="text" name="iAmountID" id="iAmountID" class="form-control" placeholder="0.00" />
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <input type="text" class="form-control"  id='dDepositeDate' name="dDepositeDate" required>
                    <span id="hello_1"><i class="fa fa-calendar"  aria-hidden="true"></i></span> </div>
                </div>
              </div>
              <script type="text/javascript">
            $(function () {
               $('#dDepositeDate').datetimepicker({
					format: 'DD-MM-YYYY',
				});	
				
				$( "#hello_1" ).click(function() {
					$( "#dDepositeDate" ).focus();
				});
            });
        </script>
              <?php /*?><div class="col-lg-12 col-md-12 col-sm-12"> 
       	<div class="col-lg-12 col-md-12 col-sm-12">
        	<label>Deposit Release Date</label><br>
        
        <input type="checkbox" name="vehicle" class="" value="Bike"> &nbsp;&nbsp; Release Funds Immediately<br>  
        <input type="checkbox" name="vehicle" class="" value="Bike"> &nbsp;&nbsp;  Release Funds on Event Date<br> 
        <input type="checkbox" name="vehicle" class="" value="Bike"> &nbsp;&nbsp; Release Funds on Specified Date 
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
        <input type="text" class="form-control" id="" placeholder="MM/DD/YYYY">
        </div> 
      </div><?php */?>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-8 col-md-8 col-sm-8"> </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <?php if(isset($_GET['artist'])){?>
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
            <?php if(isset($_GET['artist'])){
		  $cond = "";
		  if($objsession->get('gs_login_id') > 0 && $objsession->get('gs_login_id') != ""){
		  	$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND (iRollID = ".$_GET['artist']." AND isActive = 1)";
		  }else{
			  $cond = "(iLoginID = ".$_GET['artist']." AND isActive = 1)";
		  }
		  
		  $subscrib = $obj->fetchRow("subscription",$cond);		  
		  if(count($subscrib) == 0){
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
					url: '<?php echo URL;?>views/checksubscrib.php?type=sub&logID=<?php echo $objsession->get('gs_login_id');?>&artist=<?php echo $_GET['artist'];?>',
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
                <div class="text-right"> <a data-target="#myModal" class="login" data-toggle="modal" href="#">Login</a> </div>
                <?php }else{?>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                      <input type="text" name="subscriberemail" id="subscriberemail" value="<?php echo $loginRow['sEmailID']; ?>" readonly="readonly" class="form-control" placeholder="Enter your emiail" />
                      <span id="subscriberemail-error" class="error"></span> </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                      <input name="btn_subscribe" type="button" class="form-control" id="subscribe005" value="Subscribe" />
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <?php 
  if(isset($_POST['btn_subscribe'])){
		extract($_POST);

		$row = $obj->fetchRow("usermaster","iLoginID = ".$objsession->get('gs_login_id'));
		
		$field = array("iLoginID","iRollID","sEmailID","sName","isActive");
		$value = array($objsession->get('gs_login_id'),$_GET['artist'],$subscriberemail,$row['sUserName'],1);	
			
		$obj->insert($field,$value,"subscription");
	}
  ?>
            </form>
            <?php 
		  }else{
	?>
            <p>You have already subscribed to this artist.</p>
            <?php
		  }
	} ?>
            <?php if($objsession->get('gs_login_id') > 0 && !isset($_GET['artist'])){
	
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
										} else {
											echo "Event Not Found";
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
                    <a href="<?php echo URL.$pageurl.$subscriblist[$sub]['iRollID']; ?>"><?php echo $subscriblist[$sub]['sName'];?> </a></div>
                  <?php }} ?>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-8 col-md-8 col-sm-8"> </div>
                <div class="col-lg-4 col-md-4 col-sm-4 mt20 p0 text-right">
                  <?php if(count($subscriblist) > 0){?>
                  <button type="button" id="unsubscribe" class="btn btn-primary">Unsubscribe</button>
                  <?php } ?>
                </div>
              </div>
            </form>
            <?php } ?>
          </div>
          <?php 
  
    if(isset($_GET['artist'])){
    	$countView = 1;
		
		$views = $obj->fetchRow("usermaster","iLoginID = ".$_GET['artist']);
		
		if($views['iCount'] > 0){
			$countView = $views['iCount'] + 1;
		}
		
		$field = array("iCount");
		$value = array($countView);
		
		$obj->update($field,$value,"iLoginID = ".$_GET['artist'],"usermaster");
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
		
		if($_GET['main'] == 'artist'){
			
			$cond = '';
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGiftName = '".$_GET['videoType']."'";
			$gift = $obj->fetchRow("rollmaster",$cond);
			
			$str1 = str_replace($_GET['name'],' ',$gift['sVideo']);
			$str2 = str_replace($_GET['videName'],' ',$gift['sVideoName']);
			$str3 = str_replace($_GET['image'],' ',$gift['sVideoImages']);
			
			
			$str1 = str_replace(' ,','',$str1);
			$str2 = str_replace(' ,','',$str2);
			$str3 = str_replace(' ,','',$str3);
			
			$str1 = rtrim($str1,', ');
			$str2 = rtrim($str2,', ');
			$str3 = rtrim($str3,', ');
			
			$field = array("sVideo","sVideoName","sVideoImages");
			$value = array($str1,$str2,$str3);
			
			$obj->update($field,$value,$cond,"rollmaster");
			
			deleteImage($_GET['name'],'upload/artist/video/'.$_GET['videoType']);
			
			$objsession->set('gs_msg','Video deleted successfully');
			redirect(URL.'views/artistprofile.php');
			
		}
	}
	
	if($_GET['type'] == 'album'){
		
		deleteImage($_GET['photo'],'upload/gallery/'.$_GET['name'].'/');
		
		if($obj->delete('gallerymaster',"iGalleryID = ".$_GET['galleryID']) == true){
			$objsession->set('gs_msg','Image successfully deleted.');	
			redirect(URL.'views/artistprofile.php');
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
		redirect(URL.'views/artistprofile.php');
		
	}
}
?>
<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>
