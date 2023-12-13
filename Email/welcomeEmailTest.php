<?php

  /* 
    If there is $_GET variable containing Data, the user's info is passed to the Contact page Email Function
    and an email is sent to the site Admin
  */
  require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/EmailTester/emailFunctions.php');
/*
  if(!empty($_GET)) {
    $receiver = "kirkddrummond@yahoo.com"; //This value will be a variable
    $receiverName = "Kirk"; //This value will be a variable
    
    sendWelcomeEmail($receiver,$receiverName); 
  }
*/
/*
  if(!empty($_GET)) {
    //$sender = "administrator@gospelscout.com";
    $receiver = "kirkddrummond@yahoo.com"; //This value will be a variable
    $receiverName = "Kirk";
    $actionUrl = "https://www.google.com";
    $os = "Windows 10 V4";
    $browserName = "Google Chrome";
   // $receiverName = "Kirk"; //This value will be a variable
   // $emailID = 1889501; 
    
    sendPasswordReset($receiver, $receiverName, $actionUrl, $os, $browserName); 
  }
  */
/*
  if(!empty($_GET)) {
    //$sender = "administrator@gospelscout.com";
    $receiver = "kirkddrummond@yahoo.com"; //This value will be a variable
    $receiverName = "Kirk";
    $actionUrl = "https://www.google.com";
    $os = "Windows 10 V4";
    $browserName = "Google Chrome";
   // $receiverName = "Kirk"; //This value will be a variable
   // $emailID = 1889501; 
    
    deactivateAccount($receiver, $receiverName, $actionUrl, $os, $browserName); 
  }
*/
/*
  if(!empty($_GET)) {
    $requester = "kirkydboi@gmail.com";
    $requesterName = "Donte Drummond";
    $requestorUrl = "http://www.stage.gospelscout.com/views/artistprofile?artist=258";
    $receiver = "kirkddrummond@yahoo.com"; //This value will be a variable
    $receiverName = "Kirk";
    $talentRequested = "Drummer";
    $actionUrl = "https://www.google.com";
    $gigName = "Corporate Fundraiser";
    $gigId = "1928839AFG7887BC";
    
    
    $test = new booking; 
    $test->request($requester, $requesterName, $requestorUrl, $receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId); 
  }


   if(!empty($_GET)) {
    $requestor = "kirkydboi@gmail.com";
    $requestorName = "Donte Drummond";
    $requestorUrl = "http://www.stage.gospelscout.com/views/artistprofile?artist=258";
    $receiver = "kirkddrummond@yahoo.com"; //This value will be a variable
    $receiverName = "Kirk";
    $talentRequested = "Drummer";
    $actionUrl = "https://www.google.com";
    $gigName = "Corporate Fundraiser";
    $gigId = "1928839AFG7887BC";
    
    $test = new booking; 
    $test->cancellation($requestor, $requestorName, $requestorUrl,$receiver, $receiverName, $talentRequested, $actionUrl, $gigName, $gigId); 
  }
  */
/*
  if(!empty($_GET)) {
      $requestor = "kirkydboi@gmail.com";
      $requestorName = "Donte Drummond";
      $requestorUrl = "http://www.stage.gospelscout.com/views/artistprofile?artist=258";
      $receiver = "kirkddrummond@yahoo.com"; //This value will be a variable
      $receiverName = "Kirk";
      $talentRequested = "Drummer";
      $receiverResponse = "accepted";
      $actionUrl = "https://www.google.com";
      $gigName = "Corporate Fundraiser";
      $gigId = "1928839AFG7887BC";
      
      $test = new booking; 
      $test->status($requestor, $requestorName, $requestorUrl, $receiver, $receiverName, $talentRequested, $receiverResponse, $actionUrl, $gigName, $gigId); 
  }


  if(!empty($_GET)) {  
    $depositor = "kirkydboi@gmail.com";
    $depositorName = "Donte Drummond"; 
    $receiver = "kirkddrummond@yahoo.com";
    $receiverName = "Kirk Drummond";
    $depositAmount = "500.00";
    $gigName = "Corporate Fundraiser";
    $gigId = "1928839AFG7887BC";
    $gigDate = "10/24/2017";
    $origDeposDate = "10/24/2017";
    $refundExpiration = "10/10/2017";
    $refundDescription ="Artist's Gig Deposit";
    //$churchName = "N/A";
    //$type = "gig";

    $test = new payment; 
    $test->refunds($depositor, $depositorName, $receiver, $receiverName, $depositAmount, $gigName, $gigId, $gigDate, $refundExpiration, $origDeposDate, $refundDescription); 
  }
*/

  if(!empty($_GET)) {  
    //$depositor = "kirkydboi@gmail.com";
    //$depositorName = "Donte Drummond"; 
    $receiver = "kirkddrummond@yahoo.com";
    $receiverName = "Kirk Drummond";
    $depositAmount = "500.00";
    $deficitAmount = "40.00";
    $gigName = "Corporate Fundraiser";
    $gigId = "1928839AFG7887BC";
    $gigDate = "10/24/2017";
    $origDeposDate = "10/24/2017";
    //$refundExpiration = "10/10/2017";
    //$refundDescription ="Artist's Gig Deposit";

    $test = new payment; 
    $test->insufficientFunds($receiver, $receiverName, $depositAmount, $gigName, $gigId, $gigDate, $origDeposDate, $deficitAmount);
  }



  echo '<a href="welcomeEmailTest.php?y=1">Test Welcome Email</a><br>';
  $testDate = strtotime('10/21/17'); 
  $year = date('Y');
  $month = date('m'); 
  $date = $year . '-' . $month . '-01';
  echo '--- ' . date("Y",strtotime($date.' - 1 Month')) . '---<br><br>';

  echo  $testDate . '<br>';
  echo strtotime('22 july 1987').'<br>';

  echo 'year: ' . date('Y').'<br>';
  echo 'month: ' . date('m').'<br>';
  echo 'day: ' . date('N', $testDate);

?>