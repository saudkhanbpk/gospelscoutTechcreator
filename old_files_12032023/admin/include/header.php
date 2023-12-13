<?php 
ob_start();
include('../common/config.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo PROJECT_ADMIN_TITLE;?></title>
    <!-- Bootstrap Core CSS -->
	<link rel="shortcut icon" type="image/png" href="<?php echo URL;?>img/favicon.png"/>
    <link href="<?php echo PATH;?>css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo PATH;?>css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo PATH;?>css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo PATH;?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
     <script src="<?php echo PATH;?>js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo PATH;?>js/bootstrap.min.js"></script>
    <link href="<?php echo PATH;?>css/style.css" rel="stylesheet">
    
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
<script src="<?php echo PATH;?>js/additional-methods.js"></script>
<script src="<?php echo PATH;?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript"> 
$(function () {
    var url = window.location.href;

        var result = /[^/]*$/.exec(url)[0];
		if(result > 0){
			url = url.substring(1, url.length-2);
		}
		
		urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
		 		
    $('#top a').each(function () {
		$(this).removeClass('active');

        if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
            $(this).addClass('active');
           // $(this).parent().previoussibling().find('a').removeClass('active');
        }
    });
	  
});

function showLoader(){
 $("#loaddiv").show();
 $("#loadicon").show();
}

function hideLoader(){
	document.getElementById("loaddiv").style.display = "none";
	$("#loadicon").hide();
}
</script>
</head>
<style>
#loaddiv { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; /*change to YOUR page height*/ background-color: #000; filter: alpha(opacity=50); -moz-opacity: 0.5; -khtml-opacity: 0.5; opacity: 0.5; z-index: 998; }
#loadicon { display: none; position: fixed; left: 50%; top: 40%; z-index: 999; }
#blah { display: none; }
</style>
<?php
$ohd_email = $objsession->get("log_email");
if($ohd_email == ""){ 
	redirect(HTTP_SERVER."login");
}

?>
<body>
<div id="loaddiv"> </div>
<img src="<?php echo HTTP_SERVER; ?>images/loading.gif" id='loadicon' >
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: white;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo HTTP_SERVER;?>"><img src="../../img/logo.png" alt="" style="width: 150px;height: 36px;"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                     <?php
					 $ohd_email = $objsession->get("log_email");
					 if($ohd_email != ""){ echo "Admin";}
					 ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo HTTP_SERVER;?>views/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo HTTP_SERVER;?>views/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include ('../include/sidebar.php');?>
            <!-- /.navbar-collapse -->
        </nav>