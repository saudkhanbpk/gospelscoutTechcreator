<?php include('../include/header.php'); ?>
<link href="<?php echo URL;?>css/shop-homepage.css" rel="stylesheet">
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
	$usermaster = $obj->fetchRowAll("churchministrie","iLoginID = ".$objsession->get('gs_login_id'));
}

$gistmaster = $obj->fetchRowAll("rollmaster","iLoginID = ".$objsession->get('gs_login_id'));

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
    	<img src="<?php if($userRow['sProfileName'] != ""){echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];}else{?>img/profile.jpg<?php }?>" class="img-responsive center-block">
  	</div>
  </div>
  

<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item collaps active">
    <a class="nav-link" href="#profile" role="tab" data-toggle="tab">Video</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Photos</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#references" role="tab" data-toggle="tab">Bio</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#pdf" role="tab" data-toggle="tab">Book Me</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#subscribe" role="tab" data-toggle="tab">Subscribe</a>
  </li>
</ul>

<!-- Tab panes --> 
<div class="col-lg-4 col-md-4 col-sm-4 p0">
	<div class="white">
    	<h3>Aritist Info</h3>
        <p><b>Current City:</b> <?php if($userRow['sCityName'] != '')echo ucfirst($userRow['sCityName']);?>, <?php if($userRow['iZipcode'] != '')echo $userRow['iZipcode'];?></p>
        <p><b>Availabillity:</b> <?php if($userRow['sAvailability'] != '')echo ucwords(str_replace('_',' ',$userRow['sAvailability']));?></p>
        <p><b>My Talent(s):</b> <?php if($usermaster['sGiftName'] != ""){echo $usermaster['sGiftName'];}?></p>
    </div>
</div>

<div class="col-lg-8 col-md-8 col-sm-8"> 
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="profile">
  
  <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
  	
    <?php
		if(count($gistmaster) > 0){
			for($gi=0;$gi<count($gistmaster);$gi++){
				
				//$videolist = $obj->fetchRow("rollmaster","sGiftName = '".$gistmaster[$gi]['sGiftName']."'");
				$vdiList = explode(',',$gistmaster[$gi]['sVideo']);
				$vdiName = explode(',',$gistmaster[$gi]['sVideoName']);
	?>
    <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom">
   <form name="frmVideo" id="frmVideo">
    	<div class="video_sec">
        <h3><?php echo ucfirst($gistmaster[$gi]['sGiftName']);?></h3>
        <a href="">View All</a>
    	</div>        
    	<?php 
			if(!empty($vdiList)){
				
				$v = 0;
				foreach($vdiList as $vd){
		?>
        <div class="col-lg-4 col-mg-4 col-sm-4">        
        <video width="400" controls class="img-responsive center-block">
  <source src="<?php echo URL;?>upload/artist/video/<?php echo $gistmaster[$gi]['sGiftName'].'/'.$vd;?>" type="video/mp4">
</video>
<script>
$(document).ready(function () {
	
 $('#view_btn<?php echo $v;?>').on('click', function (e) {

		  e.preventDefault();	  
			var formData = $('#frmVideo').serialize();			
			var val = $('#sVideoName<?php echo $v;?>').val();
		  $.ajax({
			type: 'post',
			url: '<?php echo URL;?>views/countvalue.php?sVideoName='+val,
			data: formData,
			success: function (data) {
			  if(data == 'Please check your video'){
				  $('#loadlogin').html(data);
			  }else{
				window.location = "<?php echo URL;?>views/videodetails.php?video="+val;  
			  }
			}
		  });			  
		  
		  
        });
	
});
 
 </script>
 			<?php
			$videocount = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$vdiName[$v]."'");
			?>
        	<span id="loadlogin"></span>
            <h2><?php echo $vdiName[$v];?></h2>
            <p class="tital1"><a href="" id="view_btn<?php echo $v;?>"><?php if(!empty($videocount)){echo $videocount['iViews'];}else{echo '0';}?> Views</a></p>
            <input type="hidden" name="sVideoName" id="sVideoName<?php echo $v;?>" value="<?php echo $vdiName[$v];?>" />
            <?php /*?><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star yellow" aria-hidden="true"></i><i class="fa fa-star grey" aria-hidden="true"></i><?php */?>
            <p class="tital1">
			<?php			
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($gistmaster[$gi]['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				echo $numberDays = intval($numberDays);

			?> days Ago</p>
        </div>
        <?php
		$v ++;
				}
			}
		?>
         </form>
    </div>
    <?php 
			}
	} ?>
   
  </div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="buzz">
  
  <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  
  <div id='cssmenu' class="mt30">
              <ul>
                <li><a id="menu1" class="active">Headshots</a></li>
                <li><a id="menu2">Road Trip 2015</a></li>
                <li><a id="menu3">Random</a></li>
              </ul>
            </div>
            
            
            <div id="menu11">
            <div class="col-lg-12 col-md-12 col-sm-12 mt20">
    
    	<div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
   
    </div>
			</div> 
   
  			<div id="menu22" style="display:none">
            <div class="col-lg-12 col-md-12 col-sm-12 mt20">
    
    	<div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
   
    </div>
    
    		<div class="col-lg-12 col-md-12 col-sm-12 mt20">
    
    	<div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
   
    </div>
  			</div>
  
  			<div id="menu33" style="display:none">
            <div class="col-lg-12 col-md-12 col-sm-12 mt20">
    
    	<div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
   
    </div>
    
    		<div class="col-lg-12 col-md-12 col-sm-12 mt20">
    
    	<div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
   
    </div>
    
    		<div class="col-lg-12 col-md-12 col-sm-12 mt20">
    
    	<div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
        
        <div class="col-lg-4 col-mg-4 col-sm-4">
        	<img src="img/dummy.jpg" class="img-responsive center-block">
        </div>
   
    </div>
  			</div>
  </div>
  
</div>
<div role="tabpanel" class="tab-pane fade" id="references">
  <div class="col-lg-12 col-md-12 col-sm-12 white chang mg0">
  
  <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
  	<p>Year of Experience</p>
    <h2>
    	<ul class="year">
        	<li>3 years</li>
         </ul>
    </h2>
   </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
  	<p>Musical Influences</p>
    <h2>
    	<ul>
        	<li>1. Aretha franklin</li>
            <li>2. Stevie Wonder</li>
            <li>3. Strvie Ray Vaughn</li>
            <li>4. Lianne La Havas</li>
        </ul>
    </h2>
    </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
  	<p>Music Genre</p>
    <h2>
    	<ul class="year">
        	<li>Jazz</li>
            <li>Funk</li>
            <li>Gospel</li>
        </ul>
    </h2>
    </div>
    
  <div class="col-lg-12 col-md-12 col-sm-12 borderbuttom text">
  	<p>Who have You Played With?</p>
    <h2>
    	<ul class="year">
        	<li>1. Shirtley Ceasar</li>
            <li>2. Red Hot Chilli Peppers</li>
            <li>3. David Matthews Band</li>
            <li>4. Good Jesus National Choir</li>
            <li>5. Fred Hammond</li>
            <li>6. United Mass Choir</li>
            <li>7. Living Word Ministries</li>
            <li>8. Christina Aguilera</li>
        </ul>
    </h2>
    </div>
    
  <div class="col-lg-12 col-md-12 col-sm-12 text">
  	<p>Where have You Played?</p>
    <h2>
    	<ul class="year">
        	<li>1. Madison Square Garden</li>
            <li>2. Carnegie Hall</li>
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
	
		$("#frmProfile").validate({
			ignore: [],  
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {				
				sEmailID: {
					  required:true,
					  email:true,
					},
				
				sAddress: "required",				
				sContactNumber01: {
					  required:true,
					  number:true,
					},
				sContactNumber: {
					  required:true,
					  number:true,
					},
				sCompanyName: "required",
				sAddress01: "required",
				sCompanyEmailID: {
					  required:true,
					  email:true,
					},
				sBankName: "required",
				sBranchName: "required",
				sNumber: "required",
				cPassword:{
					equalTo: "#sPassword",
				},
				sImage:{
					extension: "png|jpeg|jpg",
				},
				
			},

			messages: {
				sEmailID: {
					  required:"Please enter your email",
					  email:"Polease enter valid email",
					},
				sFirstName: "Please enter your first name",
				sLastName: "Please enter your last name",
				sAddress: "Please enter your address",	
				sContactNumber01: {
					  required:"Please enter your company contact number",
					  number:"Please enter only number",
					},
				sContactNumber: {
					  required:"Please enter your contact number",
					  number:"Please enter only number",
					},
				sCompanyName: "Please enter your company name",
				sAddress01: "Please enter your company details",
				sCompanyEmailID: {
					  required:"Please enter your company email",
					  email:"Please enter valid email",
					},
				sBankName: "Please enter your bank name",
				sBranchName: "Please enter your branch name",
				sNumber: "Please enter cheque or dd number",
				cPassword:{
					equalTo: "Please enter confirm password same as password",
				},
				sImage:{
					extension: "Please upload valid image",
				},
			},	
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},			
			submitHandler: function(form) {
			if(form_submit() == true){
					form.submit();
				}
			}

		});
	});</script>
  <div role="tabpanel" class="tab-pane fade" id="pdf">
  <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  <form id="frmProfile" role="form" name="frmevent"method="post" enctype="multipart/form-data">
	
     <div class="col-lg-12 col-md-12 col-sm-12">
     	<div class="col-lg-12 col-md-12 col-sm-12">
  		<div class="form-group">
    		<label for="email">Name of Event:</label>
    		<input type="email" class="form-control" id="sEmailID" name="sEmailID" placeholder="Name Of Event">
  		</div>
        </div>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-12">
     	<div class="col-lg-12 col-md-12 col-sm-12">
  		<div class="form-group">
    		<label for="pwd">Address of Event:</label>
    		<input type="password" class="form-control" id="sAddress" name="sAddress" placeholder="Stree Address">
        </div>
        </div>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-12">
       <div class="col-lg-4 col-md-4 col-sm-4">
             <div class="form-group">
            	<select id="" name="state" class="form-control">
                	<option>State</option>
                    <option>State Name</option>
                    <option>State Name</option>
                    <option>State Name</option>
                    <option>State Name</option>
                </select>
                </div>
            </div>
       <div class="col-lg-4 col-md-4 col-sm-4">
             <div class="form-group">
            	<select id="" name="city"class="form-control">
                	<option>City</option>
                    <option>City Name</option>
                    <option>City Name</option>
                    <option>City Name</option>
                    <option>City Name</option>
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
        <div class="col-lg-4 col-md-4 col-sm-4">
        	<div class="form-group">
            	<input type="number" class="form-control" id="" placeholder="">
                </div>
            </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="form-group">
            	<input type="number" class="form-control" id="" placeholder="">
                </div>
            </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            
            </div>   
      </div>   
      
      <div class="col-lg-12 col-md-12 col-sm-12"> 
       	<div class="col-lg-12 col-md-12 col-sm-12">
        	<label>Booking you as</label>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
        	<div class="form-group">
            	<select class="form-control">
                	<option>Bass Player</option>
                    <option>Bass Playe</option>
                    <option>Bass Playe</option>
                    <option>Bass Playe</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            
            </div>   
      </div>    
      
      <div class="col-lg-12 col-md-12 col-sm-12"> 
       	<div class="col-lg-12 col-md-12 col-sm-12">
        	<label>Amount Deposited</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1">
        <p class="dot">$</p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2">
        	<div class="form-group">
            	<input type="text" class="form-control" palceholder:"0"/>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1">
        <p class="dot">.</p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2">
        	<div class="form-group">
            	<input type="text" class="form-control" palceholder:"0"/>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            
            </div>   
      </div>
      
      <div class="col-lg-12 col-md-12 col-sm-12"> 
       	<div class="col-lg-12 col-md-12 col-sm-12">
        	<label>Deposit Release Date</label><br>
        
        <input type="checkbox" name="vehicle" class="" value="Bike"> &nbsp;&nbsp; Release Funds Immediately<br>  
        <input type="checkbox" name="vehicle" class="" value="Bike"> &nbsp;&nbsp;  Release Funds on Event Date<br> 
        <input type="checkbox" name="vehicle" class="" value="Bike"> &nbsp;&nbsp; Release Funds on Specified Date 
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
        <input type="text" class="form-control" id="" placeholder="MM/DD/YYYY">
        </div> 
      </div>
      
            
      <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="col-lg-8 col-md-8 col-sm-8">
      </div>
      	<div class="col-lg-4 col-md-4 col-sm-4">
         <input class="btn btn-primary " type="submit" name="btn_submit" value="Submit">
           
            </div>  
      </div>      
    </form>
  </div>
  <?php 
  if(isset($_POST['btn_submit'])){
	extract($_POST);
	$field = array("iLoginID","sAddress","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sMultiImage","sChurchName","sPastorName","sAddress","sDenomination","iNumberMembers","sChurchUrl","sMission","sFounderName","sAmenitis","sOtherAmenitis","dCreatedDate","isActive");
		$value = array($sEmailID,$sFirstName,$state,$city,$zipcode,date("Y-m-d",strtotime($dDob)),$country,$state,$city,$iZipcode,$sMultiImage,$sChurchName,$sPastorName,$sAddress,$denomination,$ApproxofMembers,$sChurchUrl,$sMission,$sFounderName,$ChurchAminity,$sOtherAmenitis,date("Y-m-d"),1);		
		$userID = $obj->insert($field,$value,"usermaster");
	}
  ?> 
  </div>
  
  <div role="tabpanel" class="tab-pane fade" id="subscribe">
  <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
	 <form role="form">
     <div class="col-lg-12 col-md-12 col-sm-12 chang">
  		<h3>My Subscribers</h3>
 	 </div>
     <div class="col-lg-12 col-md-12 col-sm-12 chang borderbuttom">
     	<div class="col-lg-12 col-md-12 col-sm-12">
  		<h2>You Have <span>3000</span> Subscribers</h2>
        <p class="mt20">Subscribe Settings</p>
        <p class="mt20">Notify My Subscribers Wher:</p>
        <h2><ul>
        <li>Upload new Videos</li>
        <li>Upload new Photos</li>
        <li>New Events are Added to my Calender</li>
        </ul>
        </h2>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 mb20">  
        <p>Select Events</p>
  
     <div class="button-group">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="color">Select Events</span> <span class="caret color"></span></button>
<ul class="dropdown-menu">
  <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input type="checkbox"/>&nbsp;Select All</a></li>
  <li><a href="#" class="small" data-value="option2" tabIndex="-1"><input type="checkbox"/>&nbsp;Youth Conferance</a></li>
  <li><a href="#" class="small" data-value="option3" tabIndex="-1"><input type="checkbox"/>&nbsp;Album Releuse</a></li>
  <li><a href="#" class="small" data-value="option4" tabIndex="-1"><input type="checkbox"/>&nbsp;Gxoel Explos</a></li>
</ul>
  </div>
</div>
  

        
        </div>
        
         <div class="col-lg-12 col-md-12 col-sm-12 chang">
  		<h3>My Subscribers</h3>
 	 </div>
     <div class="col-lg-12 col-md-12 col-sm-12">
     	<div class="col-lg-6 col-md-6 ocl-sm-6">
     	<input type="checkbox">&nbsp;&nbsp;
 		<i class="fa fa-user"></i>&nbsp;&nbsp;Melissa Tbomas   
        </div>
        
        <div class="col-lg-6 col-md-6 ocl-sm-6">
     	<input type="checkbox">&nbsp;&nbsp;
 		<i class="fa fa-user"></i>&nbsp;&nbsp;Tony Mcisaide   
        </div>
        
        <div class="col-lg-6 col-md-6 ocl-sm-6">
     	<input type="checkbox">&nbsp;&nbsp;
 		<i class="fa fa-user"></i>&nbsp;&nbsp;Jema Loeise   
        </div>
        
        <div class="col-lg-6 col-md-6 ocl-sm-6">
     	<input type="checkbox">&nbsp;&nbsp;
 		<i class="fa fa-user"></i>&nbsp;&nbsp;Vintage Love   
        </div>
        
       
     </div>
       
      
         
      
          
      
      
      
      
      
            
      <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="col-lg-8 col-md-8 col-sm-8">
      </div>
      	<div class="col-lg-4 col-md-4 col-sm-4 mt20">
            <button type="submit" class="btn btn-primary">Unsubscribe</button>
            </div>  
      </div>      
            
            
       
	</form>
  </div>
  
  </div>
</div>
</div>
  </div>
      </div>
<?php include('../include/footer.php');?>