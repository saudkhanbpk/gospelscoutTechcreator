

<!-- <!doctype html> -->

<?php 
	/* Top and Side Navigation - Admin Page */

    /* Create DB connection to Query Database for Artist info */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

    /* Include config page */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

    /* Get Admin Info */
        $currentUserID = $objsession->get('gs_login_id');
        $currentUserType = $objsession->get('gs_login_type');
        $currentUserEmail = $objsession->get('gs_login_email');

    /* Redirect if user is not an admin  else retrieve admin info */
        
        if($currentUserID && ( $currentUserType == 'admin' || $currentUserType == 'puwAdmin') ){ //
            /* Query the adminmaster table for admin info */
                $cond = 'iLoginID = ' . $currentUserID; 
                $adminInfo = $obj->fetchRow('adminmaster', $cond);
        }
        else{
            echo '<script>window.location = "'. URL .'newHomePage/puwAdminDashboard/index.php";</script>';
            exit;
        }
    /* Today's date */
        $today = date_create();
        $today = date_format($today, 'Y-m-d');
   /* Get puw info */

        /* Get Events */
            $innerJoinArray = array(
                array("puwhostsmaster","id","puweventsmaster","hostID"),
                array("states","id","puwhostsmaster","host_state")
            );
            $columnsArray = array('puweventsmaster.*', 'puwhostsmaster.host_sCityName','puwhostsmaster.capacity', 'states.statecode');
            $paramArray['date']['>'] = $today;
            $orderByParam = 'date';
            $allEvents =  pdoQuery(' puweventsmaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray);
            $eventCount = count($allEvents);
        
        /* Get Hosts */
            // $condHostDays['hostID']['='] = 
            $innerJoinArray1 = array(
                array("states","id","puwhostsmaster","host_state")
            );
            $allHosts =  pdoQuery('puwhostsmaster','all',$paramArray1,$orderByParam1,$innerJoinArray1);
            $hostCount = count($allHosts);
            // $availHostDays = pdoQuery('puwavailhostdays','all',$condHostDays);
       
        /* Get artists */
            $innerJoinArray2 = array(
                                array("usermaster","iLoginID","puwartistmaster","iLoginID"),
                                array("states","id","usermaster","sStateName")
                            );
            $allArtists = pdoQuery('puwartistmaster','all',$paramArray2,$orderByParam2,$innerJoinArray2);
            $artistCount = count($allArtists);
        
        /* Get Applicants */
            $allApplicants = pdoQuery('puwattendeemaster','all');
            $applicantCount = count($allApplicants);


?>

<!-- <html lang="en">  -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">

    <!-- Boostrap Time Picker css -->
    <link href="<?php echo URL; ?>newHomePage/glyphicon.css" rel="stylesheet">
    <link href="<?php echo URL;?>newHomePage/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"> 

    <!-- Custom styles for GospelScout -->
    <!-- <link rel="icon" href="<?php echo URL;?>img/favicon.png"> -->
    <link rel="icon" href="<?php echo URL;?>newHomePage/img/gospelscout_logo.png">
    <link href="<?php echo URL; ?>newHomePage/custom.css" rel="stylesheet">
    <title>GS Admin</title>

    <script src="../../../js/jquery-1.11.1.min.js"></script>
    <style>
        #cuListing:hover {
            color: rgba(149,73,173,1);
        }
    </style>
</head>


<!-- <body> -->
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.php" style="font-size:20px;color:black"><span class="text-gs">#</span>popUpWorship Administrator</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">John Abraham</span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo URL;?>newHomePage/upload/artist/<?php echo $adminInfo['sProfileName'];?>" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?php echo $adminInfo['sFirstName'] . ' ' . $adminInfo['sLastName'];?></h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="#" id="logout"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-users"></i>Manage Users<span class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-1" aria-controls="submenu-1-1">Active Users ( <span class="text-white"><?php echo $activeCount; ?></span> )</a>
                                            <div id="submenu-1-1" class="collapse submenu" style="">
                                                <ul class="nav flex-column">
                                                    <!--  <li class="nav-item">
                                                        <a class="nav-link" href="#">All Users  ( <span class="text-white"><?php echo $totalCount; ?></span> )</a>
                                                    </li> -->
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="manageusers-artist.php?act=1">Artists  ( <span class="text-white"><?php echo count($counts['active']['artist']); ?></span> )</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="manageusers-groups.php?act=1">Groups  ( <span class="text-white"><?php echo count($counts['active']['group']); ?></span> )</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="manageusers-church.php?act=1">Churches  ( <span class="text-white"><?php echo count($counts['active']['church']); ?></span> )</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="manageusers-users.php?act=1">Users  ( <span class="text-white"><?php echo count($counts['active']['user']); ?></span> )</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Manage Events</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-c3.html">View Events</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-chartist.html">Edit Event Types</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-chart-pie"></i>Manage Applicants</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-c3.html">View Events</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-chartist.html">Edit Event Types</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                           
                           
                            <li class="nav-divider">
                                Features
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-inbox"></i>Communication (<span class="text-white"><?php echo $numbOfMess;?></span> )<span class="badge badge-secondary">New</span></a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/inbox.html">Inbox</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/email-details.html">Email Detail</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/email-compose.html">Email Compose</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo URL;?>newHomePage/adminDashboard/concept-master/ContactUsMessage-chat.php">Contact Us Messages <span>(<?php echo $numbOfMess;?>)</span></a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="<?php echo URL;?>newHomePage/adminDashboard/concept-master/ContactUsMessage-chat.php?a_ID=<?php echo $currentUserID;?>">Your Replies <span>(<?php echo $numbOfReplies;?>)</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fab fa-fw fa-wpforms"></i>Calendar</a>
                                <div id="submenu-8" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-fontawesome.html">FontAwesome Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-material.html">Material Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-simple-lineicon.html">Simpleline Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-themify.html">Themify Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-flag.html">Flag Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-weather.html">Weather Icon</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->

        <script>
            /* Log Out */
              $('#logout').click(function(event){
                event.preventDefault(); 
                var logout = new XMLHttpRequest(); 
                  logout.onreadystatechange = function(){
                    if(logout.status == 200 && logout.readyState == 4)
                    // location.reload(); 
                    window.location = "<?php echo URL;?>newHomepage/adminDashboard/index.php";
                  }
                  logout.open("GET", "../../../views/logout.php");
                  logout.send(); 
              });   
            /* END - Log Out */
        </script>
