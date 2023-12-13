<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/adminDashboard/concept-master/include/adminNav.php');

    /* Retreive the contact us message from the db */
        if($_GET['id'] && $_GET['id']>0){
            $messId = intval($_GET['id']);
            $table = 'contact_us';

            /* Get the current message using message id */
                $messDetailCond = 'id = ' . $messId;
                $getMess = $obj->fetchRow($table, $messDetailCond);   
                if($getMess['viewed'] == 1){
                    $replied = true; 
                }
                else{
                    $replied = false; 
                }
            /* END - Get the current message using message id */


            /* Get the current admins replies  and reply count */
                $getAdminReplies = 'adminID = ' . $currentUserID;
                $totalreplies = $obj->fetchRowAll($table,$getAdminReplies);
                $totalReplyCount = count($totalreplies);
            /* END - Get the current admins replies  and reply count */

        }
        else{
            echo '<script>window.location = "'. URL .'newHomePage/views/ContactUsMessage-chat.php";</script>';
        }

    /* END - Retreive the contact us message from the db */


    /*
        contact us and admin comms

        1. list all unanswered contact us messages 
        2. track the admin that answers the message
            record iLoginID
            record the reply 
            record date and time of reply
        3. Admin's reply will be emailed back to the provided user email
        4. create a contact us template in postmark for responding to 
    */

    /* Query the DB for all entries where the adminID matches the $currentUserID */
        //take the count 
    /* END - Query the DB for all entries where the adminID matches the $currentUserID */
?>
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid">
                
                    <aside class="page-aside">
                        <div class="aside-content">
                            <div class="aside-header">
                                <button class="navbar-toggle" data-target=".aside-nav" data-toggle="collapse" type="button"><span class="icon"><i class="fas fa-caret-down"></i></span></button><span class="title">Contact Us</span>
                                <p class="description">Admin Reply</p>
                                <?php 
                                    // echo '<pre>';
                                    // var_dump($getMess);
                                ?>
                            </div>
                            <div class="aside-nav collapse">
                                <ul class="nav">
                                    <li class="active"><a href="#"><span class="icon"><i class="fas fa-fw fa-file"></i></span>Current Message</a></li>
                                    <li><a href="<?php echo URL;?>newHomePage/adminDashboard/concept-master/ContactUsMessage-chat.php"><span class="icon"><i class="fas fa-fw fa-inbox"></i></span>New Messages<span class="badge badge-primary float-right"><?php echo $numbOfMess;?></span></a></li>
                                    <li><a href="<?php echo URL;?>newHomePage/adminDashboard/concept-master/ContactUsMessage-chat.php?a_ID=<?php echo $currentUserID;?>"><span class="icon"><i class="fas fa-fw  fa-envelope"></i></span>Your Replies<span class="badge badge-primary float-right" id="replyUpdate"><?php echo $totalReplyCount;?></span></a></li>
                                    <!-- <li><a href="#"><span class="icon"><i class="fas fa-fw fa-briefcase"></i></span>Important<span class="badge badge-secondary float-right">4</span></a></li>
                                    
                                    <li><a href="#"><span class="icon"><i class="fas fa-fw fa-star"></i></span>Tags</a></li>
                                    <li><a href="#"><span class="icon"><i class="fas fa-fw fa-trash"></i></span>Trash</a></li> -->
                                </ul>
                                <!-- <span class="title">Labels</span>
                                 <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#"><i class="m-r-10 mdi mdi-label text-secondary"></i>
                                    Important </a></li>
                                    <li><a href="#">
                                   <i class="m-r-10 mdi mdi-label text-primary"></i> Business   </a></li>
                                    <li><a href="#"> <i class="m-r-10 mdi mdi-label text-brand"></i>
                                   Inspiration </a></li>
                                </ul>
                                <div class="aside-compose"><a class="btn btn-lg btn-primary btn-block" href="#">Compose Email</a></div> -->
                            </div>
                        </div>
                    </aside>
                    <div class="main-content container-fluid p-0">
                        <div class="email-head">
                            <div class="email-head-subject">
                                <div class="title"><a class="active" href="#"><span class="icon"><i class="fas fa-star"></i></span></a> <span>Development Files</span>
                                    <div class="icons"><a href="#" class="icon"><i class="fas fa-reply"></i></a><a href="#" class="icon"><i class="fas fa-print"></i></a><a href="#" class="icon"><i class="fas fa-trash"></i></a></div>
                                </div>
                            </div>
                            <div class="email-head-sender">
                                <?php 
                                    /* Format submission date */
                                        $formatDate = date_create($getMess['submitDate']);
                                        $formatDate = date_format($formatDate,'M d, Y @ h:ia');
                                        // $formatDate = date_format($formatDate,'m-d-Y, H:i:s');
                                ?>
                                <div class="date"><?php echo $formatDate;?></div>
                                <div class="avatar">
                                    <?php 
                                        if($getMess['iLoginID'] == 'Visitor'){
                                            echo '<img alt="Avatar" src="' . URL . 'newHomePage/img/gsStickerBig1.png" class="rounded-circle user-avatar-md aProfPic">';
                                        }
                                        else{
                                            echo '<img alt="Avatar" src="' . URL . 'newHomePage/upload/' . $getMess['sUsertype'] . '/' . $getMess['pic']. '" class="rounded-circle user-avatar-md aProfPic">';
                                        }
                                    ?>
                                </div>
                                <div class="sender"><a href="<?php if($getMess['iLoginID'] == 'Visitor'){echo '#';}else{echo URL . 'newHomePage/views/artistprofile.php?artist=' . $getMess['iLoginID'];}?>"><?php echo $getMess['sFullName'];?></a>
                                    <div class="actions"><a class="icon toggle-dropdown" href="#" data-toggle="dropdown"><i class="fas fa-caret-down"></i></a>
                                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Mark as read</a><a class="dropdown-item" href="#">Mark as unread</a><a class="dropdown-item" href="#">Spam</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="email-body">
                            <h5>Message:</h5>
                            <p><?php echo $getMess['ConactUs_message'];?></p>
                        </div>
                        <?php
                            if($replied){
                                /* Format admin view date */
                                    $formatDate1 = date_create($getMess['viewDate']);
                                    $formatDate1 = date_format($formatDate1,'M d, Y @ h:ia');
                        ?>
                                <div class="email-body" style="background-color:rgba(149,73,173,.1);">
                                     <h5>Reply (<?php echo $formatDate1;?>):</h5>
                                    <p><?php echo $getMess['adminReply'];?></p>
                                </div>
                        <?php
                            }
                        ?>
                        <input type="hidden" name="messageID" id="messageID" value="<?php echo $getMess['id'];?>">
                        <input type="hidden" name="initialMess" id="initialMess" value="<?php echo $getMess['ConactUs_message'];?>">
                        <input type="hidden" name="userMessTimestamp" id="userMessTimestamp" value="<?php echo $getMess['submitDate'];?>">
                        <input type="hidden" name="adminID" id="adminID" value="<?php echo $currentUserID;?>">
                        <input type="hidden" name="adminName" id="adminName" value="<?php echo $adminInfo['sFirstName'];?>">
                        <input type="hidden" name="userID" id="userID" value="<?php if($getMess['iLoginID'] == 'Visitor'){echo 'Visitor';}else{echo $getMess['iLoginID'];}?>">
                        <input type="hidden" name="userEmail" id="userEmail" value="<?php echo $getMess['sEmail'];?>">
                        <input type="hidden" name="userName" id="userName" value="<?php echo $getMess['sFullName'];?>">
                        <textarea class="form-control mb-2 mt-2" name="adminReply" id="adminReply" placeholder="Reply to <?php echo $getMess['sFullName'];?>..." wrap="" rows="5" aria-label="With textarea" required><?php if($_POST && $err > 0 ){echo $_POST['adminReply'];}?></textarea>
                        <button type="button" id="replyToContact" class="btn btn-gs">Reply</button>
                    </div>
            </div>
        </div>
         <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript: void(0);">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end footer -->
        <!-- ============================================================== -->
    </div>
   <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
     <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/vendor/custom-js/jquery.multi-select.html"></script>
    <script src="assets/libs/js/main-js.js"></script>

    <script>
        /* Send the admin reply to the user */
            $('#replyToContact').click(function(event){

                /* Create vars */
                    var adminReply = $('#adminReply').val();
                    var adminID = $('#adminID').val();
                    var adminName = $('#adminName').val();; 
                    var userID = $('#userID').val();
                    var userEmail = $('#userEmail').val();
                    var userName = $('#userName').val(); 
                    var messageID = $('#messageID').val(); 
                    var initialMess = $('#initialMess').val(); 
                    var userMessTimestamp = $('#userMessTimestamp').val();
                /* END - Create vars */
                // console.log(adminName+' '+userEmail+' '+userName+' '+messageID)
                /* Create new FormData() object */
                    var replyObj = new FormData(); 
                    replyObj.append('adminID',adminID);
                    replyObj.append('userID',userID);
                    replyObj.append('adminReply',adminReply);
                    replyObj.append('adminName',adminName);
                    replyObj.append('userEmail',userEmail);
                    replyObj.append('userName',userName);
                    replyObj.append('messageID',messageID);
                    replyObj.append('initialMess',initialMess);
                    replyObj.append('userMessTimestamp',userMessTimestamp);
                /* END - Create new FormData() object */  

                /* Create new XMLHttpRequest */
                    var sendReply = new XMLHttpRequest();
                    sendReply.onreadystatechange = function(){
                        if(sendReply.status == 200 && sendReply.readyState == 4){
                            console.log(sendReply.responseText);
                            $('#replyUpdate').html(sendReply.responseText);
                        }
                    }
                    sendReply.open('POST','<?php echo URL;?>Email/contactPageEmail.php');
                    sendReply.send(replyObj);
                /* END - Create new XMLHttpRequest */

            });
        /* END - Send the admin reply to the user */
    </script>
</body>
 
</html>