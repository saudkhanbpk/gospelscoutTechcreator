<!doctype html>
<html lang="en">
  <head>
    <?php 
      include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="<?php echo URL;?>img/favicon.png"> -->
    <link rel="icon" href="<?php echo URL;?>img/gospelscout_logo.png">
    <!-- href="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/favicon.ico"> -->
	
    <title>GospelScout</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="<?php echo URL; ?>Composer1/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" >
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">  -->
    	<!-- integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" -->
    
    <!-- Custom styles for this template -->
    <link href="<?php echo URL; ?>css/carousel.css" rel="stylesheet">

    <!-- Custom styles for GospelScout -->
    <link href="<?php echo URL; ?>css/custom.css" rel="stylesheet">

    <!-- Boostrap Time Picker css -->

    <!-- <link href="../css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo URL; ?>css/glyphicon.css" rel="stylesheet">
    <link href="<?php echo URL;?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"> 

    <script src="<?php echo URL;?>js/jquery-1.11.1.min.js"></script>
  </head>
  <body style="<?php if($backGround == 'bg2'){echo 'background-color: rgb(233,234,237)';}?>">

   <!--  <header> -->
      <nav class="navbar navbar-expand-md navbar-dark  fixed-top bg-gs">
        <!-- <a class=" navbar-brand text-hide" style="background-image: url('gsSticker.png');background-size:cover; width: 50px; height: 50px;">Bootstrap</a> -->
        <a class="navbar-brand" href="<?php echo URL;?>">GospelScout</a> <!--index.php-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link <?php if($page == 's4a'){echo 'active';} ?>" href="https://www.stage.gospelscout.com/search4artist">Search 4 Artist<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($page == 's4c'){echo 'active';} ?>" href="<?php echo URL;?>views/search4churchNew">Search 4 Church</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($page == 's4e'){echo 'active';} ?>" href="<?php echo URL;?>views/search4eventNew">Search 4 Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($page == 's4e'){echo 'active';} ?>" href="<?php echo URL;?>popupworship/">#popUpWorship</a>
            </li>
          </ul>
          <?php
            /* 
            $currentUserID = $objsession->get('gs_login_id');
            $currentUserType = $objsession->get('gs_login_type');
            $currentUserEmail = $objsession->get('gs_login_email');
            */
            
            /* Check if user was deactivated - query loginmaster for isActive value */
              $table = 'loginmaster';
              $cond = 'iLoginID = ' . $currentUserID;
              $isActive = $obj->fetchRow($table,$cond);
              $isActive = $isActive['isActive'];
              
            if($currentUserID > 0 ){
                //$userInfo = $obj->fetchRow('usermaster', 'iLoginID='.$currentUserID);
                if($currentUserType == 'admin'){
                  $userInfo = $obj->fetchRow('adminmaster', 'iLoginID='.$currentUserID);
                }
                else{
			/* Query usermaster for current user's info */
				$userInfo = $obj->fetchRow('usermaster', 'iLoginID='.$currentUserID);
	                  
			/* Query the notificationmaster table for new notifications count */
				$notificationInfo = $obj->fetchRowAll('notificationmaster', 'notifiedID='.$currentUserID.' AND viewed = 0');
                    		$numbOfNot = count($notificationInfo); 
                }
                $userName = $userInfo['sFirstName'];
                if($currentUserType == 'artist' || $currentUserType == 'group'){
                  echo '<a class="text-white" href="' . URL . 'views/artistprofile.php" class="text-white mr-5">Hi, ' . ucwords($userName) . '</a>';
                }
                elseif($currentUserType == 'church'){
                  echo '<a class="text-white" href="' . URL . 'views/churchprofile.php" class="text-white mr-5">Hi, ' .ucwords($userName) . '</a>';
                }
                elseif($currentUserType == 'gen_user'){
                  echo '<span class="text-white">Hi, ' . $userName . '</span>';
                }
                elseif($currentUserType == 'admin'){
                     echo '<a class="text-white" href="' . URL . 'adminDashboard/concept-master/index.php" class="text-white mr-5">Hi, Admin ' . $userName . '</a>';
                }
          ?>
                <style>
                  .dis{
                    color: rgba(0,0,0,.4);
                  }
                  #notBell{
                    background-image: url("<?php echo URL;?>img/notificationBell.png");
                    background-size: 22px 22px;
                    background-repeat:  no-repeat;
                    background-position:  center;
                    object-fit:cover; 
                    object-position:0,0;
                    text-decoration: none;
                  }
                </style>
                <div class="btn-group dropdown mr-5" style="display:inline-block">
                	<a href="<?php echo URL;?>notification" id="notBell" class=" ml-2 text-white text-right pr-0 pb-1" style="display:inline-block;height:22px; width:22px">
	                    <div>
	                      <?php if($numbOfNot > 0 ){?>
	                       <span class="text-gs bg-white font-weight-bold" style="font-size: 10px;position: relative; left:1; bottom: 6px;height:10px;width:10px;border-radius:100px;padding:2px;"><?php echo $numbOfNot;?></span>
	                      <?php }?>
	                    </div>
			</a>
			
                  <!-- <a href=""class="ml-4 mr-5 text-white dropdown-toggle" id="AccountDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a> -->
			<a href="" class="ml-0 mr-5 pt-0 text-white" style="display:inline-block" id="AccountDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img class="ml-1" src="<?php echo URL;?>img/notification-symbol.png" height="13px" width="20px" class="img-fluid" alt="My Account">
			</a>
                  
                  <div class="dropdown-menu mr-3 dropdown-menu-right" aria-labelledby="accountDropdownMenu" style="max-width:175px">
                    <a class="dropdown-item" href="<?php echo URL; ?>views/myAccount.php">Acct Info</a>
                    <!-- <a class="dropdown-item dis" href="<?php echo URL; ?>views/manageEvents.php">Manage Events</a> -->
                    <?php if($currentUserType == 'artist'|| $currentUserType == 'group'){ ?>
                             <a class="dropdown-item" href="<?php echo URL; ?>gigmanager/">Manage Gigs</a>
                    <?php 
                          }
                          elseif($currentUserType == 'church' || $currentUserType == 'gen_user'){
                    ?>
                            <a class="dropdown-item" href="#">Manage Gigs</a> <?php //echo URL; ?>views/manageGigs1.php
                    <?php
                          }
                    ?>
                    <a class="dropdown-item" id="goTo_str_dashboard" uID="<?php echo $currentUserID;?>" href="<?php echo URL; ?>newHomePage/views/manageMoney.php">Manage Money</a><!--dis-->
                    <?php if($currentUserType == 'artist'|| $currentUserType == 'group'){?>
		      <a class="dropdown-item" href="<?php echo URL; ?>views/postedGigs.php">Find Gigs</a>
                    <?php }?>
                    <a class="dropdown-item" href="<?php echo URL; ?>popupworship">#popUpWorship</a>
                    <a class="dropdown-item text-gs" id="logout" href="">Log Out</a> 
                  </div>
                </div>
          <?php

            }
            else{
          ?>
              <a href="" id="login-signup-trigger" data-toggle="modal" data-target="#login-signup" class="text-white mr-5">Login/Signup</a> <!-- <?php echo URL;?>views/signup.php-->
          <?php } ?>
          
        </div>
      </nav>  
   <!-- </header> -->


	<?php 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/headerNewModals.php');
	?>
	<script src="<?php echo URL;?>js/jsFunctions.js?2"></script>
	<script src="<?php echo URL;?>js/headerNewJS.js?1"></script>

	<main role="main">