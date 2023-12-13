<?php 
ob_start();
include ('common/config.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gospel Scout</title>
    <!-- Bootstrap core CSS -->
	<link rel="shortcut icon" type="image/png" href="<?php echo URL;?>img/favicon.png"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">
    <link href="full-slider.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script> 
    
 </head>
 
  <body>
	<div class="maindiv" style="background:#fff;">
    	<div class="container">
        	<div class="col-lg-2 col-md-2 col-sm-2 mt30">
            <a href="<?php echo URL;?>">
            	<img src="img/logo.png" class="img-responsive" alt="">
             </a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mt20">
            	<form id="search" name="search" method="post" class="navbar-form" >
                            
                            <input type="text" name="searchValue" id="searchValue" placeholder="Search here...." >
                            <input type="hidden" id="hideSearchValue" name="hideSearchValue" value="">
                            <input type="hidden" id="userType" name="userType" value="">
                            <input type="submit" name="btn_filter" id="btn_filter" style="display:none">
                            
                            <a href="#" onClick="reloadPage();" id="search"></a>
                            <div id="display" style="display:none;"></div>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 mt20">
            	<ul class="ul" style="padding: 0px;">
        <?php 
				if($objsession->get('gs_login_id') > 0){
					if($objsession->get('gs_login_type') == 'artist'){
						$name = 'artistprofile';
						$name1 = 'artistaccount';
					}else if($objsession->get('gs_login_type') == 'user'){
						$name = 'useraccount';	
						$name1 = 'useraccount';
					}else{
						$name = 'churchprofile';
						$name1 = 'churchaccount';	
					}
					
				$booklist = $obj->fetchRow('bookingmaster',"iRollID = ".$objsession->get('gs_login_id')." OR iLoginID = ".$objsession->get('gs_login_id'));
				$evelist  = $obj->fetchRow('eventbooking',"iRollID = ".$objsession->get('gs_login_id')." OR iLoginID = ".$objsession->get('gs_login_id'));
				
				?>
                <li><a href="<?php echo URL;?>views/<?php echo $name;?>">Welcome, <?php if($objsession->get('gs_user_name') != ""){echo ucwords($objsession->get('gs_user_name'));}?></a></li>
        <li class="dropdown" data-toggle=""><a style="border-right:none !important;text-transform:uppercase;" data-toggle="dropdown" href="#">My Account</a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo URL;?>views/<?php echo $name1;?>">My Account</a></li>
            <li><a href="<?php echo URL;?>views/myevents.php">Manage Event</a></li>
            <?php /*?><li><a href="<?php echo URL;?>">views/Manage Subscribe.php</a></li><?php */?>
            <?php if($objsession->get('gs_login_type') == 'church'){?>
            <?php if ( count($evelist) > 0 ) {?>
            <li><a href="<?php echo URL;?>views/eventbooking.php">Event Booking</a></li>
			<?php } ?>
            <?php /*?><li><a href="<?php echo URL;?>views/churchbooking.php">Manage Booking</a></li><?php */?>
            <?php }else{ ?>
            <?php if ( count($evelist) > 0 ) {?>
            <li><a href="<?php echo URL;?>views/eventbooking.php">Event Booking</a></li>
			<?php } ?>
			<?php if ( count($booklist) > 0 ) {?>
            <li><a href="<?php echo URL;?>views/artistbooking.php">Artist Booking</a></li>
			<?php } ?>   
            <?php } ?>
			<li><a href="<?php echo URL;?>views/viewbanner/php">Banner</a></li>
            <li><a href="<?php echo URL;?>/views/deactiveaccount.php" onClick="return confirm('Are you sure want to deactive your account?');">Deactive Account</a></li>            
            <li><a href="<?php echo URL;?>views/logout.php">Logout</a></li>
          </ul>
          </li>
        
        <?php
				}else{
				?>
        <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
        <li><a href="<?php echo URL;?>views/signup.php">Sign up</a></li>
        <?php } ?>
      </ul>
            </div>
        </div>
    </div>
          <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
           <!-- <a class="navbar-brand" href="#">Project name</a>-->
          </div>
          <div id="navbar" class="navbar-collapse collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
             <li><a href="<?php echo URL;?>views/search4artists.php">Search 4 Artists</a></li>
              <li><a href="<?php echo URL;?>views/search4church.php">Search 4 Churches</a></li>
              <li><a href="<?php echo URL;?>views/search4event.php">Search 4 Events</a></li>
              
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content">
      <form name="frmLogin" id="frmLogin" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="loginh2">
            <h2>Sign Into Your Account </h2>
            <span id="loadlogin"></span>
          </div>
          
          <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="text" class="form-control" id="sEmailID" name="sEmailID" tabindex="1" >
            <span class="help-block"></span> </div>
          <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input type="password" class="form-control" id="sPassword" name="sPassword" tabindex="2" >
            <span class="help-block"></span> </div>
          <a id="btn_login" class="btn btn-success btn-block" tabindex="3" >Sign Into Your Account</a>
          <div id="loginErrorMsg" class="alert alert-error hide">Wrong username og password</div>
          <div class="checkbox">
            <a href="views/forgetpassword.php" style="float:right;" tabindex="5">Forgot Password ?</a>
            <p class="help-block"></p>
            <p class="center"><a href="<?php echo URL;?>views/signup.php" tabindex="4" >Create Account</a></p>
          </div>
          </div>
          </form>
        </div>
        
        <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>--> 
      </div>
    </div>
  </div>
      <!-- end nave -->
<!-- slider--->

 <section class="mbr-slider mbr-section mbr-section--no-padding carousel slide" data-ride="carousel" data-wrap="true" data-interval="5000" id="slider-0" style="background-color: rgb(0, 0, 0); border-bottom: solid 3px #8E44AD;">
    <div class="mbr-section__container">
        <div>
            
            <div class="carousel-inner" role="listbox">
                <div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height active" style="background-image:url(img/slider1.jpg);">
                    
                </div><div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(img/slider1.jpg);">
                    
                </div><div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(img/slider1.jpg);">
                    
                </div>
            </div>
            
            <a data-app-prevent-settings="" class="left carousel-control" role="button" data-slide="prev" href="#slider-0">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a data-app-prevent-settings="" class="right carousel-control" role="button" data-slide="next" href="#slider-0">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>
<!-- end slider-->

<div class="">
	<div class="container">
    	<div class="col-lg-12 col-md-12 col-sm-12 text-center">
        	<ul class="ul1">
            <li><a href="<?php echo URL;?>views/termsandcondition.php">Terms</a></li>
            <li><a href="<?php echo URL;?>views/contact_us.php">Contact</a></li>
            <li><a href="<?php echo URL;?>views/help.php">Help</a></li>
            <li><a href="<?php echo URL;?>views/copyright.php">Copyrights</a></li>
            <li><a href="<?php echo URL;?>views/aboutus.php">About</a></li>
            <li><a href="<?php echo URL;?>views/privacy.php" style="border:none;">Privacy</a></li>
            </ul>
        </div>
<div style="width: 300px;margin-left: 39%;">Design & Developed By <a href="http://omshantiinfotech.com/">OM Shanti Infotech</a></div>
    </div>
</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
    
    <script>
function clk(){
	
	document.getElementById('btn_filter').click();	
}

function fill(Value,Idd,type){

	$('#searchValue').val(Value);
	$('#hideSearchValue').val(Idd);
	$('#userType').val(type);
	$('#display').hide();
}

	$(document).ready(function(){
	
	
	$('body').click(function(){
		$('#display').hide();
		$('#display1').hide();
	});
	
	$('#display').hide();
	$('#display1').hide();
	
	$("#searchValue").keyup(function() {

	var name = $('#searchValue').val();

	if(name==""){
		
		$('#display').hide();
	}
	else{

		$.ajax({
			type: "POST",
			url: "loaddata",
			data: "name="+ name,
			
			success: function(html){
				if(html == ''){
					$('#display').hide();
				}else{

					$("#display").html(html);
					$('#display').slideDown();
				}
			}
		});
	}
	
	});
	
});

	</script> 
    <script>
 $(document).ready(function () {
	 
	 function ValidateEmail(email) {
var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
return expr.test(email);
};

$('#btn_login').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('#btn_login').click();
    return false;  
  }
});   

 $('#btn_login').on('click', function (e) {
		  if($('#sEmailID').val() == ''){
			  $('#loadlogin').html("Please enter email");
		  }else if($('#sEmailID').val() != '' && !ValidateEmail($('#sEmailID').val())){
				  $('#loadlogin').html("Please enter valid email");
		  }else if($('#sPassword').val() == ''){
			  $('#loadlogin').html("Please enter password");
		  }else{
			  	  
				  $('#loadlogin').html('');
				  e.preventDefault();
				  
					var formData = $('#frmLogin').serialize();
					
				  $.ajax({
					type: 'GET',
					url: '<?php echo URL;?>views/checklogin.php?fblogin=login',
					data: formData,
					async:false,
					success: function (data) {
					  if(data == 'Please check your email or password'){
						  $('#loadlogin').html(data);
					  }else if(data == 'artist'){
						window.location = "<?php echo URL;?>views/artistprofile.php";  
					  }else if(data == 'church'){
						window.location = "<?php echo URL;?>views/churchprofile.php";  
					  }else if(data == 'user'){
						window.location = "<?php echo URL;?>views/useraccount.php";  
					  }else if(data == 'deactive'){
                                                
						$('#loadlogin').html("Your account is deactivated. Please contact to administrator for active your account.");
		  }
					}
				  });			  
		  }
        });
	 });
 
 function reloadPage(){

	var url = document.getElementById('userType').value;
	var id = document.getElementById('hideSearchValue').value;

	if(url != ''){

		if (url == 'artist') {

			document.location.href = "http://www.stage.gospelscout.com/views/artistprofile.php?artist="+id,true;
			
		} else if (url == 'church'){
			
			window.location.href = "http://www.stage.gospelscout.com/views/churchprofile?church="+id;	
						
		} else{
			
			window.location.href = "http://www.stage.gospelscout.com/views/userprofile?artist="+user;		
			
		}
	}
	return false;
	
}
 </script> 
  </body>
</html>
