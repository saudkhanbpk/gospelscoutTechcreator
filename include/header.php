<?php 
error_reporting(0);
ob_start();
include ('../common/config.php');?>
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
  <link rel="shortcut icon" type="../image/png" href="<?php echo URL;?>img/favicon.png"/>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/custom.css" rel="stylesheet">
  <link href="../css/slider.css" rel="stylesheet">
  <link href="<?php echo URL;?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
   <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  
  <link href="../css/full-slider.css" rel="stylesheet">

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
  <script src="<?php echo URL;?>js/jquery-1.11.1.js"></script>
  <script src="<?php echo URL;?>js/bootstrap.min.js"></script>
  <!--<script src="js/jquery.js"></script>-->
  <script src="<?php echo URL;?>js/jquery.validate.js"></script>
  <script src="<?php echo URL;?>js/additional-methods.js"></script>
  <script src="<?php echo URL;?>js/moment-with-locales.js"></script>
  <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
  <?php /*?><script src="http://iamrohit.in/lab/js/location.js"></script><?php */?>
  </head>
  <body>
<div class="maindiv" style="background:#fff;">
    <div class="container">
    <div class="col-lg-2 col-md-2 col-sm-2 mt30"> <a href="<?php echo URL;?>"> <img src="../img/logo.png" class="img-responsive" > </a> </div>
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
						$name = 'artistprofile.php';
						$name1 = 'artistaccount.php';
					}else if($objsession->get('gs_login_type') == 'user'){
						$name = 'useraccount.php';	
						$name1 = 'useraccount.php';
					}else{
						$name = 'churchprofile.php';
						$name1 = 'churchaccount.php';	
					}
					
				$booklist = $obj->fetchRow('bookingmaster',"iRollID = ".$objsession->get('gs_login_id')." OR iLoginID = ".$objsession->get('gs_login_id'));
				$evelist  = $obj->fetchRow('eventbooking',"iRollID = ".$objsession->get('gs_login_id')." OR iLoginID = ".$objsession->get('gs_login_id'));
					
				?>
                <li><a href="<?php echo URL;?>views/<?php echo $name;?>">Welcome, <?php if($objsession->get('gs_user_name') != ""){echo ucwords($objsession->get('gs_user_name'));}?></a></li>
        <li class="dropdown" ><a style="border-right:none !important;text-transform:uppercase;" data-toggle="dropdown" href="">My Account</a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo URL;?>views/<?php echo $name1;?>">My Account</a></li>
            <li><a href="<?php echo URL;?>views/myevents.php">Manage Event</a></li>
            <?php /*?><li><a href="<?php echo URL;?>">Manage Subscribe</a></li><?php */?>
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
            <li><a href="<?php echo URL;?>views/viewbanner.php">Banner</a></li>
            <li><a href="<?php echo URL;?>views/deactiveaccount.php" onClick="return confirm('Are you sure want to deactive your account?');">Deactive Account</a></li>			
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
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <!-- <a class="navbar-brand" href="#">Project name</a>--> 
      </div>
    <div id="navbar" class="navbar-collapse collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
        <li><a href="<?php echo URL;?>views/search4artists.php">Search 4 Artists</a></li>
              <li><a href="<?php echo URL;?>views/search4church.php">Search 4 Churches</a></li>
              <li><a href="<?php echo URL;?>views/search4event.php">Search 4 Events</a></li>
      </ul>
      </div>
    <!--/.nav-collapse --> 
  </div>
    <!--/.container-fluid --> 
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
            <span id="loadlogin"></span> </div>
            <div class="form-group">
            <label for="password" class="control-label">Email</label>
            <input type="text" class="form-control" id="sEmailID" name="sEmailID" tabindex="1" >
            <span class="help-block"></span> </div>
            <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input type="password" class="form-control" id="sPassword" name="sPassword" tabindex="2" >
            <span class="help-block"></span> </div>
            <a id="btn_login" class="btn btn-success btn-block" tabindex="3">Sign Into Your Account</a>
            <div id="loginErrorMsg" class="alert alert-error hide">Wrong username or password</div>
            <div class="checkbox"> <a href="forgetpassword.php" style="float:right;" tabindex="5">Forgot Password ?</a>
            <p class="help-block"></p>
            <p class="center"><a href="<?php echo URL;?>views/signup.php" tabindex="4">Create Account</a></p>
          </div>
          </div>
      </form>
      </div>
    
    <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>--> 
  </div>
  </div>
<!-- end nave --> 
<script>

function clk(){
	
	document.getElementById('btn_filter').click();	
}

function reloadPage(){

	var url = document.getElementById('userType').value;
	var id = document.getElementById('hideSearchValue').value;

	if(url != ''){

		if (url == 'artist') {

			document.location.href = "http://www.stage.gospelscout.com/views/artistprofile.php?artist="+id,true;
			
		} else if (url == 'church'){
			
			window.location.href = "http://www.stage.gospelscout.com/views/churchprofile.php?church="+id;	
						
		} else{
			
			window.location.href = "http://www.stage.gospelscout.com/views/userprofile.php?artist="+user;		
			
		}
	}
	return false;
	
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
function handleEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
	var i;
	for (i = 0; i < field.form.elements.length; i++)
		if (field == field.form.elements[i])
			break;
	i = (i + 1) % field.form.elements.length;
	field.form.elements[i].focus();
	return false;
} 
else
return true;
}      
</script> 
<script>
function showDiv(idOfDiv) {

   document.getElementById(idOfDiv).style.display = 'block';
}
function hideDiv(idOfDiv) {
   document.getElementById(idOfDiv).style.display = 'none';
}
</script> 
<script language="JavaScript">

function zipcode_validate(zipcode){
	var regZipcode = /^([0-9]){5}(([ ]|[-])?([0-9]){4})?$/;
	if(regZipcode.test(zipcode) == false){
		document.getElementById("zip_error").innerHTML = "Zip Code is not yet valid.";
	}else{
		document.getElementById("zip_error").innerHTML = "You have entered a valid US Zip Code!";
	}
}
</script> 
<script>
$(document).ready(function() {
		
     var getUName = function() {
		 
		var sUserName = $("#sUserName").val();

        $.ajax({
			type: "POST",
			url: "<?php echo URL; ?>views/validname.php",
			data: "table=usermaster&loginID=0&sUserName="+sUserName,
			success: function(data){
				if(data != ""){
					$("#hidename").val(data);
				}else{
					$("#hidename").val('');
				}
			}
		});
    
	 }
	
	
	$('#sUserName')
    .keyup(getUName)
    .keypress(getUName)
		   
});
</script> 
<script type="text/javascript">
  $(document).ready(function () {
	
i = 0;

    $("#sFirstName").keypress(function(){
        $("#fName").text($("#sFirstName").val());
    });
	
	$("#sFirstName").keyup(function(){
        $("#fName").text($("#sFirstName").val());
    });
	
	$("#sFirstName").click(function(){
        $("#fName").text($("#sFirstName").val());
    });
	
	$("#sFirstName").blur(function(){
        $("#fName").text($("#sFirstName").val());
    });

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
						$('#loadlogin').html("Your account is deactivated. Please request account re-activation via the Contact Page.");
					  }
					}
				  });			  
		  }
        });
		 
  var navListItems = $('div.setup-panel div a'),
		  allWells = $('.setup-content'),
		  allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
	  e.preventDefault();
	  var $target = $($(this).attr('href')),
			  $item = $(this);

	  if (!$item.hasClass('disabled')) {
		  navListItems.removeClass('btn-primary').addClass('btn-default');
		  $item.addClass('btn-primary');
		  allWells.hide();
		  $target.show();
		  $target.find('input:eq(0)').focus();
	  }
  });

  allNextBtn.click(function(){
	  	   
	  var curStep = $(this).closest(".setup-content"),
		  curStepBtn = curStep.attr("id"),
		  nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
		  curInputs = curStep.find("input[type='text'],input[type='email'],input[type='checkbox'],input[type='password'],input[type='file'],textarea[textarea]"),
		  isValid = true;
var pass = '';
var cpass = '';

	  $(".form-group").removeClass("has-error");
	  for(var i=0; i<curInputs.length; i++){
		  if (!curInputs[i].validity.valid){			  
			  isValid = false;
			  $(curInputs[i]).closest(".form-group").addClass("has-error");
		  }else{
		  
		  		if(curInputs[i].name == 'sPassword'){
					pass = curInputs[i].value;
				}
				
				if(curInputs[i].name == 'cPassword'){
					cpass = curInputs[i].value;
				}			
		  }
	  }
	  
	  if(pass != cpass){
		alert('Please enter confirm password same as password')
	  }
				
	  if (isValid)
	  {
		  navListItems.click(function (e) {
		  e.preventDefault();
		  var $target = $($(this).attr('href')),
	
			  $item = $(this).attr('href');
			  
			  if($item == '#step-1')
			  {
				  $("#btn1").removeClass("btn-is-disabled");
			  }
			  else if($item == '#step-2')
			  {
				  $("#btn2").removeClass("btn-is-disabled");
			  }
			  else if($item == '#step-3')
			  {
				  $("#btn3").removeClass("btn-is-disabled");
			  }	  
  });
		  nextStepWizard.removeAttr('disabled').trigger('click');
	  }
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
  

	

});

function validemail(str){
		var xmlhttp;    
		if (str==""){
			return;
		}
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("error_email").innerHTML=xmlhttp.responseText;
			}
		}
		
		xmlhttp.open("GET","<?php echo URL; ?>views/validmail.php?table=loginmaster&str="+str,true);
		xmlhttp.send();
	}

	function form_submit(){
		var e = 0;		
		
		if(document.getElementById('valid_id').value != '')	{
			document.getElementById('valid_info').innerHTML = "";
		}else{
			$("#valid_info").removeClass("suc-msg-forgot");
			
			if(isEmpty01("valid_id", "You've already registered.", "valid_info")){
				e++;
			}	
		}
		
		if(e > 0){
			return false;
		}else{
			return true;
		}
	}
	
	function isEmpty01(e, t, n){
		
		var r = document.getElementById(e);
		var n = document.getElementById(n);
		
		if(r.value.replace(/\s+$/, "") == ""){
			n.innerHTML = t;
			r.value = "";
			r.focus();
			return true
		}else{
			n.innerHTML = "";
			return false
		}
	}
$(document).ready(function(){
	$(document).keypress(function(e) {
		if(e.which == 13) {
			return false;
		}
	});
});
  </script>