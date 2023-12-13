<?php ob_start(); ?>
<?php include('../common/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo PROJECT_ADMIN_TITLE;?>| Login</title>
<link rel="shortcut icon" type="image/png" href="<?php echo URL;?>img/favicon.png"/>
<link rel="stylesheet" type="text/css" href="<?php echo PATH;?>css/style.css" />
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
<script src="<?php echo PATH;?>js/additional-methods.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,800italic,800,700italic' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Open+Sans:400,300,300italic,400italic,600,600italic,700,800italic,800,700italic:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
</head>
<script>

$().ready(function() {
		$("#frmLogin").validate({
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {
				sEmailID:{
					required: true,
					email: true,
				},
				sPassword:{
					required: true,
					minlength: 6,
					maxlength: 15,
				},
			},
			messages: {
				sEmailID:{
					required: "Please enter your email",
					number: "Please enter valid email",
				},
				sPassword:{
					required: 'Please enter your password',
					minlength: 'Password minimum length is 8',
					maxlength: 'Password maximum length is 15',
				},		
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

<body id="login">
<?php
if(isset($_POST['btn_login'])){
	extract($_POST);
	if($sPassword != ""){
		$sPassword = encrypt_md5string($sPassword);
	}
	$cond = "sEmailID = '".$sEmailID."' AND sPassword = '".$sPassword."'";
	$row = $obj->checkValidLogin("loginmaster",$cond);

	if(!empty($row)){
		if($row['sUserType'] == 'admin'){
			$objsession->set('log_email',$row['sEmailID']);
			$objsession->set('log_loginid',$row['iLoginID']);
			$objsession->set('log_admintype',$row['sUserType']);
			
			$set_url = $objsession->get("set_url");
			if($set_url != ""){
				redirect($set_url);
			}else{

				redirect(HTTP_SERVER.'views/dashboard.php');	
			}
			$objsession->remove('set_url');
		}else{
			$objsession->set('log_error',"Please check your email or password.");
			redirect(HTTP_SERVER.'views/login.php');	
		}
	}else{
		$objsession->set('log_error',"Please check your email or password.");
		redirect(HTTP_SERVER.'views/login.php');
		break;
	}
}
?>
<div class="login-page">
  <div class="container">
    <div class="loginbox">
    <div class="header">
      <div class="logo"><img src="<?php HTTP_SERVER;?>/admin/images/logo.png"  /></div>
    </div>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="login-box-body">
          <h2 class="logintext">Login</h2>
          <form name="frmLogin" id="frmLogin" method="post">
            <?php

	if($objsession->get('log_error') != ""){

	?>
            <div class="loginerror"><?php echo $objsession->get('log_error');?></div>
            <?php $objsession->remove('log_error');

	  

	   } ?>
            <div class="emailsection">
              <label class="email">E-Mail : </label>
              <input type="text" name="sEmailID" id="sEmailID" class="form-control" />
            </div>
            <div class="passwordsection">
              <label class="password">Password : </label>
              <input type="password" name="sPassword" id="sPassword" class="form-control" />
            </div>
            <?php /*?><div class="forget-pwd"> <a class="forgotpassword" href="<?php echo HTTP_SERVER; ?>forgotpassword">Forgot Password?</a> </div><?php */?>
            <div class="submitsection">
              <input type="submit" name="btn_login" value="Log In" class="loginbtn" />
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
    </div>
  </div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>