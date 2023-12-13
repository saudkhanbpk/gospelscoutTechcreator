<?php
session_start();
@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);
?>
<?php


if(isset($_POST['submit']))
{
	$center=$_POST['center'];
	$user=$_POST['user'];
	$password=$_POST['password'];
	
	$query=mysql_query("SELECT * FROM login WHERE user='".$user."' AND password = '".$password."' AND center='".$center."'");
	$row=mysql_fetch_array($query);
	$count=mysql_num_rows($query);
	
	if($count == 1)
	{
		$_SESSION['user']=$user;
		$_SESSION['center']=$center;
		echo "<script>window.location.href='index.php'</script>";
	}
	else
	{
		echo "<script>alert('Please Enter Correct Detail');</script>";
		echo "<script>window.location.href='login.php'</script>";
	}
	
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>work clinic station</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<div class="ch-container">

        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>WELCOME TO WORK CLINIC STATION</h2>
			<div style="float: right;margin-right: 50px;">
			<b>Your Ip Is :
	<?php
	echo $_SERVER['SERVER_ADDR'];
	?></b>
	</div>
        
        <!--/span-->
    </div><!--/row-->
	

    <div class-="row">
        <div class="well col-md-5 center login-box login-width">
            <div class="alert alert-info">
                Please login
            </div>
            <form class="form-horizontal" action="" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"></span>
                        <input type="text" class="form-control" name="center" placeholder="CENTER">
                    </div>
                    <div class="clearfix"></div><br>
						
					<div class="input-group input-group-lg">
                        <span class="input-group-addon"></span>
                        <input type="text" class="form-control" name="user" placeholder="USER">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"></span>
                        <input type="password" class="form-control" name="password" placeholder="KEY">
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <label class="remember" for="remember"><a href="#"> I forgot My Password</a></label>
                    </div>
                    <div class="clearfix"></div>
						<label class="remember" for="remember"><a href="#">Confidentiality</a></label>
                    <p class="center col-md-5">
                        <button type="submit" name="submit" class="btn btn-primary">GET IN</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
 </div><!--/row-->
</div><!--/fluid-row-->

<div class="copyright-medical">@ MEDICALCLOUD SL 2013-2016. VIC 08500 </div>

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>


</body>
</html>
