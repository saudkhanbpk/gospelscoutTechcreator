<?php ob_start(); ?>
<?php include('../common/config.php');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo PROJECT_ADMIN_TITLE;?>| Forgot Password</title>
<link rel="shortcut icon" href="<?php echo HTTP_SERVER;?>../images/favicon.ico">
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

		$("#frmForgot").validate({

			debug: false,

			errorClass: "error",

			errorElement: "span",

			rules: {

				sEmailID:{

					required: true,

					email: true,

				},
			},

			messages: {

				sEmailID:{

					required: "Please enter your email",

					number: "Please enter valid email",

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

<script type="application/javascript">
$().ready(function() {
  var heights = $(".personal-acccount").map(function () {
            return $(this).height();
        }).get(),

        maxHeight = Math.max.apply(null, heights);
        $('.personal-acccount').height(maxHeight); 
});
 </script> 

<body id="login">
<div class="login-page">
  <div class="container">
    <div class="loginbox">
    <div class="header">
      <div class="logo"><a href="<?php echo HTTP_SERVER;?>"><img src="<?php HTTP_SERVER;?>../images/logo.jpg"  /></a></div>
    </div>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="login-box-body">
          <h2 class="logintext">Forgot Password</h2>
          <form name="frmForgot" id="frmForgot" method="post">
			
			<?php
            if($objsession->get('ohd_message') != ""){            
            ?>
            <div class="loginsuccess"><?php echo $objsession->get('ohd_message');?></div>
            <?php $objsession->remove('ohd_message');} ?>
            
            <?php
            if($objsession->get('ohd_fronterror') != ""){            
            ?>
            <div class="loginerror"><?php echo $objsession->get('ohd_fronterror');?></div>
            <?php $objsession->remove('ohd_fronterror');} ?>
            
            <div class="emailsection">
              <label class="email">E-Mail : </label>
              <input type="text" name="sEmailID" id="sEmailID" class="form-control" />
            </div>
            
            <div class="submitsection">
              <input type="submit" name="btn_login" value="REQUEST NEW PASSWORD" class="loginbtn" />
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
    </div>
  </div>
</div>
<?php 
if(isset($_POST['btn_login']))
{
	extract($_POST);
	
	function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
	
		$password = randomPassword();
	$cond = "sEmailID = '".$email."'";
	$row = $obj->fetchRow("loginmaster",$cond);
	if(count($row) > 0){
		
		$field=array("sPassword");
		$value=array(md5($password));
		$obj->update($field,$value,'sEmailID = "'.$sEmailID.'"','loginmaster');	
		
	 $txt1 = '<html>
    <body style="background:#14477e; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div style="background:#14477e;  font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
  <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td valign="top" align="center" style="padding:20px 0 20px 0;"><!-- [ header starts here] -->
          <table width="100%" cellspacing="0" cellpadding="10" border="0" >
            <tbody>
              
              <tr>
                <td style="font-size: 14px;"><table width="100%" cellspacing="3" cellpadding="0" border="0">
                    <tbody>
					<tr>
					<td  width="170" style="font-size: 14px;color:#fff;">
					<p>A very special welcome to you, thanks for joining</p>
					<p>your new password is <strong>'.$password.'</strong></p>
					<p>Please Keep it secret, Keep it safe</p>
					</td>
					</tr>
					
                  </tbody></table></td>
              </tr>
              <tr>
                  <td align="center"  bgcolor="#14477e" valign="top"><a href="'.HTTP_SERVER.'"><img src="'.HTTP_SERVER.'images/logo.png" alt="STS" style="margin-bottom:5px;"  border="0" /></a>
              </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div> 
</body>
</html>';
				
				$to = $sEmailID;
				$subject = "Reset Password";				
				$message = $txt1;				
				$from = "mayur.stepon@gmail.com";								
				$headers  = "From: OHD <mayur.stepon@gmail.com>\r\n"; 				
				$headers  .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";				
				
				mail($to,$subject,$message,$headers);

				
		$objsession->set('ohd_message',"We've sent a new password to $to");
		redirect(HTTP_SERVER.'forgotpassword');
	}else{
		$objsession->set('ohd_fronterror',$sEmailID." is not a registered email address.");
		redirect(HTTP_SERVER.'forgotpassword');
		
	}
}
?>
</html>
<?php ob_end_flush(); ?>