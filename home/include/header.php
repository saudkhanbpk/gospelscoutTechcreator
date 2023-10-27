<?php 
	require(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GospelScout</title>

   <!-- Jquery Links -->

  <!-- Bootstrap core CSS -->
  <link href="<?php echo URL;?>home/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo URL; ?>composer/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" >

  <!-- Custom fonts for this template -->
  <link href="<?php echo URL;?>home/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo URL;?>home/vendor/simple-line-icons/css/simple-line-icons.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

  <!-- tab icon -->
  <link rel="icon" href="https://www.gospelscout.com/img/gospelscout_logo.png">

  <!-- Plugin CSS -->
  <link rel="stylesheet" href="<?php echo URL;?>home/device-mockups/device-mockups.min.css">

  <!-- Custom styles for GospelScout -->
  <link href="<?php echo URL; ?>css/custom.css?33" rel="stylesheet">

  <!-- cookie consent  -->
  <link href="<?php echo URL; ?>css/cookieConsent.css?3" rel="stylesheet">


  <!-- Custom styles for this template -->
  <link href="<?php echo URL;?>home/css/new-age.css?6" rel="stylesheet">

  <!-- Login -->
  <link href="https://www.gospelscout.com/include/login2.css?1" rel="stylesheet">

  <!-- Boostrap Time Picker css -->
    <link href="<?php echo URL; ?>home/css/glyphicon.css" rel="stylesheet">
    <link href="<?php echo URL;?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"> 

</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0F348T2FTN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0F348T2FTN');
</script>

<script src="<?php echo URL;?>js/jquery-1.11.1.min.js"></script>




<body id="page-top" ><!-- style="background-color: rgb(233,234,237);" -->

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg  fixed-top" id="mainNav" ><!-- navbar-light style="background-color:blue;"-->
    <div class="container">
      <a class="navbar-brand js-scroll-trigger font-weight-bold" href="<?php echo URL;?>">
        <img id="company-logo" src="https://www.gospelscout.com/img/logo_bright_2.png" style="height:50px;width:50px" class="img-fluid" alt="">
        <span id="company-name" class='company-name'> GospelScout</span>
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link  <?php if($page == 's4a'){echo 'active';} ?>" href="https://www.gospelscout.com/artist/">Artists</a><!-- js-scroll-trigger -->
          </li>
         <!-- <li class="nav-item">
            <a class="nav-link <?php if($page == 's4c'){echo 'active';} ?>" href="https://www.gospelscout.com/church/">Churches</a>
          </li>
           <li class="nav-item">
            <a class="nav-link <?php if($page == 's4e'){echo 'active';} ?>" href="https://www.gospelscout.com/event/">Events</a>
          </li>-->
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://www.gospelscout.com/findgigs">Find a Gig</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://www.gospelscout.com/ourevents/">Our Events</a>
          </li>
          

            <?php 
              if($currentUserID > 0 ){
                
                echo '<li class="nav-item">';
                if($currentUserType == 'admin'){
                  $userInfo = $obj->fetchRow('adminmaster', 'iLoginID='.$currentUserID,$db);
                }
                else{
                  /* Query usermaster for current user's info */
                    $userInfo = $obj->fetchRow('usermaster', 'iLoginID='.$currentUserID,$db);
                        
                  /* Query the notificationmaster table for new notifications count */
                    $notificationInfo = $obj->fetchRowAll('notificationmaster', 'notifiedID='.$currentUserID.' AND viewed = 0', $db);
                    $numbOfNot = count($notificationInfo); 
                }
                $userName = $userInfo['sFirstName'];
                
                if($currentUserType == 'artist' || $currentUserType == 'group'){
                  echo '<a class="nav-link"  href="' . URL . 'views/artistprofile.php" class="text-gs mr-5">Hi, ' . $userName . '</a>';
                }
                elseif($currentUserType == 'church'){
                  echo '<a id="uNameDisplay" href="' . URL . 'views/churchprofile.php" class="text-dark mr-5">Hi, ' . $userName . '</a>';
                }
                elseif($currentUserType == 'gen_user'){
                  echo '<a class="nav-link" >Hi, ' . $userName . '</a>';//'<span class="text-white">Hi, ' . $userName . '</span>';style="font-size:.85em"
                }
                elseif($currentUserType == 'admin'){
                     echo '<a class="nav-link" id="uNameDisplay" href="' . URL . 'adminDashboard/concept-master/index.php" class="text-dark mr-5">Hi, Admin ' . $userName . '</a>';
                }
              echo '</li>';
            ?>
              <style>
                  .dis{
                    color: rgba(0,0,0,.4);
                  }
                  .notBell {
                    background-image: url('<?php echo URL;?>img/notification.svg');/*notificationBell.png*/
                  }
                  .notBell2 {
                    background-image: url('<?php echo URL;?>img/notification2.svg');/*notificationBell.png*/
                  }
                  #notBell{
                    background-size: 25px 20px;
                    background-repeat:  no-repeat;
                    background-position:  center;
                    object-fit:cover; 
                    object-position:0,0;
                    text-decoration: none;
                  }
                  .not-numb {
                    background-color: white; 
                    color: rgba(149,73,173,1);
                  }
                  .not-numb2 {
                    background-color: rgba(149,73,173,1);
                    color: white;
                  }
                 /* .menu-icon {
                    background-image: url('<?php echo URL;?>newHomePage/img/menu.svg');
                  }
                  .menu-icon-common{
                    background-size: 35px 25px;
                    background-repeat:  no-repeat;
                    background-position:  center;
                    object-fit:cover; 
                    object-position:0,0;
                    text-decoration: none;
                  }*/
                </style>
                <li class="nav-item pt-1">
                  <div class="btn-group dropdown py-0 d-inline align-middle" >
                    <a class="nav-link mt-0 align-middle notBell text-white text-right p-0" href="<?php echo URL;?>notification" id="notBell" style="display:inline-block;height:22px; width:22px"><!-- ml-2 -->
                      
                      <div class="container m-0 p-0" style="width:100%">
                        <div class="row m-0 p-0" style="width:100%">
                          <div class="col-12 col-md-12 m-0 p-0" style="relative">
                          <?php if($numbOfNot > 0 ){?>
                                  <div class="text-center not-numb font-weight-bold" id="not-numb" style="font-size:10px;position: absolute; left:0; bottom: -11px;height:15px;width:15px;border-radius:100px;padding:1px;"><?php echo $numbOfNot;?></div>
                          <?php }?>
                          </div>
                        </div>
                      </div>
                    </a>
                    <script>$('#not_svg').attr('style','fill:#000');</script>
                     <a href="" class="ml-0 pt-0 text-white align-bottom menu-icon menu-icon-common" style="display:inline" id="AccountDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><!--  mr-5 -->
                      <img class="ml-1" id="menu-icon" src="<?php echo URL;?>img/menu.svg" height="20px" width="20px" class="img-fluid" alt="Responsive image">
                    </a>

                    <div class="dropdown-menu dropdown-menu-right mr-0" aria-labelledby="accountDropdownMenu" style="max-width:175px"> 
                      <a class="dropdown-item" href="<?php echo URL; ?>myAccount">Acct Info</a>
                      <!--<a class="dropdown-item dis" href="<?php echo URL; ?>views/manageEvents.php">Manage Events</a>-->
                      <?php if($currentUserType == 'artist' || $currentUserType == 'group' || $currentUserType == 'gen_user'){ ?>
                               <a class="dropdown-item" href="<?php echo URL; ?>gigmanager/">Manage Gigs</a>
                      <?php 
                            }
                            elseif($currentUserType == 'church'){
                      ?>
                              <a class="dropdown-item" href="<?php echo URL; ?>views/manageGigs1.php">Manage Gigs</a>
                      <?php
                            }
                      ?>
                      <!--<a class="dropdown-item" id="goTo_str_dashboard" uID="<?php echo $currentUserID;?>" href="<?php echo URL; ?>views/manageMoney.php">Manage Money</a>-->
                      <?php if($currentUserType != 'church' || $currentUserType == 'gen_user'){?>
                        <a class="dropdown-item" href="<?php echo URL; ?>findgigs/">Find Gigs</a>
                      <?php }?>
                      <a class="dropdown-item" href="<?php echo URL; ?>ourevents/">Our Events</a>
                      <a class="dropdown-item text-gs" onclick="logOut()" href="#">Log Out</a> 
                    </div>

                  </div>
                </li>
            <?php
                echo '</li>';
              }
              else{
                  echo '<li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#login-signup" href="#">Login/SignUp</a></li>';
              }
            ?>
            
          </li>
         
        </ul>
      </div>
    </div>
    <?php //echo '<pre>';var_dump($notificationInfo);?>
  </nav>