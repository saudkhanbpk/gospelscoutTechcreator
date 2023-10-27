<?php
/* Require Config page */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
    
/*
  if(!empty($_GET)) {
    $siteSenderEmail = "contact_pagesend@gospelscout.com";
    $siteReceiverEmail = "contact_pagereceive@gospelscout.com";
    $siteReceiverName = "Contact Page - Admin";
    $emailTempID = 1943961; 
    $userName = "Kirk Deezy";
    $userEmail = "kirkddrummond@yahoo.com"; 
    $userMessage = "This is a Test with the new contact page email format.  I would also like to see how the email displays when i write an extra long message.  So consider yourself lucky that i would even show up to this fake sh(*.  Go head go nuts go ape sh*&!!!";

    sendContactPageEmail($siteSenderEmail, $siteReceiverEmail, $siteReceiverName, $emailTempID, $userName,$userEmail, $userMessage); 
  }
  echo '<a href="contactPageEmail.php?y=1">Test Email</a>';
*/

  if(!empty($_POST)) {

    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail']; 
    $adminName = $_POST['adminName'];
    $adminID = $_POST['adminID'];
    $adminReply = $_POST['adminReply'];
    $messageID = $_POST['messageID'];
    $userInitialMess = $_POST['initialMess'];

    /* Change time stamp format */
      $userMessTimestamp = date_create($_POST['userMessTimestamp']);
      $userMessTimestamp = date_format($userMessTimestamp,'M d, Y @ h:ia');

    // $siteSenderEmail = "contact_pagesend@gospelscout.com";
    // $siteReceiverEmail = "contact_pagereceive@gospelscout.com";
    // $siteReceiverName = "Contact Page - Admin";
    // $emailTempID = 1943961; 

    // $emailSent = sendContactPageEmail($userName, $userID, $userEmail, $userInitialMess, $userMessTimestamp, $adminName, $adminID, $adminReply, $messageID);

    /* Admin Reply Time stamp */
      $viewDate = date_create();
      $viewDate = date_format($viewDate, 'Y-m-d H:i:s');

    $table = 'contact_us';
    $cond = 'id = ' . $messageID;
    $insertArray['adminReply'] = $adminReply;
    $insertArray['adminID'] = $adminID;
    $insertArray['viewDate'] = $viewDate;
    $insertArray['viewed'] = '1';

    foreach($insertArray as $index => $val){
      $field[] = $index; 
      $value[] = $val;
    }
   
    /* Insert the admin reply into the contact_us table */
      $insertReply = $obj->update($field,$value,$cond,$table);

    /* Retrieve all of the current admin's replies from the contact_us table to get a count */
      if($insertReply){
        $cond1 = 'adminID = ' . $adminID;
        $totalreplies = $obj->fetchRowAll($table,$cond1);
        $totalReplyCount = count($totalreplies);

        /* Echo the count to update the "your replies" display */
          echo $totalReplyCount;
      }
  }

?>