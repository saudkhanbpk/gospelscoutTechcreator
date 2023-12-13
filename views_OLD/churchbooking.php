<?php include('../include/header.php'); ?>
<?php

if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}


$ownpendinglist = $obj->fetchRowAll('churchbooking',"iRollID = ".$objsession->get('gs_login_id')." AND sStatus = 'Pending'");
$ownconfirmlist = $obj->fetchRowAll('churchbooking',"iRollID = ".$objsession->get('gs_login_id')." AND sStatus = 'Confirm'");

$artistpendinglist = $obj->fetchRowAll('churchbooking',"iLoginID = ".$objsession->get('gs_login_id')." AND sStatus = 'Pending'");
$artistconfirmlist = $obj->fetchRowAll('churchbooking',"iLoginID = ".$objsession->get('gs_login_id')." AND sStatus = 'Confirm'");

$booking_id = $obj->fetchRow('loginmaster',"iLoginID = ".$objsession->get('gs_login_id'));

$booking_name = $obj->fetchRow('usermaster',"iLoginID = ".$objsession->get('gs_login_id'));

$booked_id = $obj->fetchRow('loginmaster',"iLoginID = ".$_GET['booked_id']);

$booked_name = $obj->fetchRow('usermaster',"iLoginID = ".$_GET['booked_id']);

$All_data = $obj->fetchRow('churchbooking',"iRollID = ".$_GET['booked_id']." ORDER BY iBookID DESC");

?>

<?php
if($_GET['paypal'])
{

$name= ucfirst($booked_name['sFirstName']." ".$booked_name['sLastName']);

 
$fullname= ucfirst($All_data['sFirstName']." ".$All_data['sLastName']);

$date= $All_data['dCreatedDate'];
$amount= $All_data['iAmount'];
$address= $All_data['sAddress']." ".$All_data['iZipcode'];
$emailid= $All_data['eEmailID'];
	


	$to = $booked_id['sEmailID']; // this is your Email address

    $from = $booking_id['sEmailID']; // this is the sender's Email address
    $subject = "Gospel Scout";
    $subject2 = "Registration - Gospel Scout";
  
    $message = "<div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#fff'>
        <table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
            <tbody>   
<tr>            <td>
            <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff' style='width:750px!important'>
                <tbody>
                    <tr>
                        <td>
                            <table width='690' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
                            <tbody>
                            
                                <tr>
                                    <td colspan='3' height='80' align='center' border='0' cellspacing='0' cellpadding='0' style='padding:0;margin:0;font-size:0;line-height:0'>
                                        <table width='690' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td width='30'></td>
                                                <td align='left' valign='middle' style='padding:0;margin:0;font-size:0;line-height:0'>
                                                <a href='http://www.stage.gospelscout.com/' target='_blank'>
                                                <img src='http://www.stage.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='Gospel Scout' ></a></td>
                                                <td width='30'></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='3' align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                <td align='center'>
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to Gospel Scout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello , $name    </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>You Are Booked For This Details...</p><br/>
                                                    <p style='color:#000;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Name :</b>  $fullname  </p>  <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Email Id :</b> $emailid        </p> <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Date :</b> $date (YY-MM-DD)       </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Address :</b> $address            </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited :</b> $amount          </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
Gospel Scout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.stage.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan='3' height='30'></td></tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>                           
                           
                            </tbody>
                            </table>
                            
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>
    </tbody>
    </table>
</div>";

    /*$message = "First Name :- " .$firstname . "\n\n Last Name:-  " . $lastname . "\n\n Your Affiliate Links:- " . $ref_link ."\n\n Your Address:-  " . $address. "\n\n Your DOB:-  " . $dob;
   $message .= "\n\n Email :- ".$email ."\n\n Password :- ".$password;

    $message2 = "Member First Name :- " .$firstname . "\n\n Member Last Name:-  " . $lastname . "\n\n Member Affiliate Links:- " .$ref_link ."\n\n Member Address:-  " . $address. "\n\n Member DOB:-  " . $dob;
$message2 .= "\n\n  Member Email :- ".$email ."\n\n Member Password :- ".$password;
*/
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from;
    $mail=mail($to,$subject,$message,$headers);

$name1= ucfirst($booking_name['sFirstName']." ".$booking_name['sLastName']);

	$to = $booked_id['sEmailID']; // this is your Email address

    $from = $booking_id['sEmailID']; // this is the sender's Email address
    $subject = "Gospel Scout";
    $subject2 = "Registration - Gospel Scout";
  
    $message = "<div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#fff'>
        <table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
            <tbody>   
<tr>            <td>
            <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff' style='width:750px!important'>
                <tbody>
                    <tr>
                        <td>
                            <table width='690' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
                            <tbody>
                            
                                <tr>
                                    <td colspan='3' height='80' align='center' border='0' cellspacing='0' cellpadding='0' style='padding:0;margin:0;font-size:0;line-height:0'>
                                        <table width='690' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td width='30'></td>
                                                <td align='left' valign='middle' style='padding:0;margin:0;font-size:0;line-height:0'>
                                                <a href='http://www.stage.gospelscout.com/' target='_blank'>
                                                <img src='http://www.stage.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='Gospel Scout' ></a></td>
                                                <td width='30'></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='3' align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                <td align='center'>
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to Gospel Scout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello , $name1    </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>Your Booking Details...</p><br/>
                                                    <p style='color:#000;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Name :</b>  $fullname  </p>  <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Email Id :</b> $emailid        </p> <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Date :</b> $date (YY-MM-DD)       </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Address :</b>  $address           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited :</b> $amount         </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
Gospel Scout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.stage.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan='3' height='30'></td></tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>                           
                           
                            </tbody>
                            </table>
                            
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>
    </tbody>
    </table>
</div>";


     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$to;
    $mail=mail($from,$subject,$message,$headers); 

$admin="Admin";
$adminid="maulik@omshantiinfotech.com";

	$to =$adminid; // this is your Email address

    $from = $booking_id['sEmailID']; // this is the sender's Email address
    $subject = "Gospel Scout";
    $subject2 = "Registration - Gospel Scout";
  
    $message = "<div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#fff'>
        <table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
            <tbody>   
<tr>            <td>
            <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff' style='width:750px!important'>
                <tbody>
                    <tr>
                        <td>
                            <table width='690' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
                            <tbody>
                            
                                <tr>
                                    <td colspan='3' height='80' align='center' border='0' cellspacing='0' cellpadding='0' style='padding:0;margin:0;font-size:0;line-height:0'>
                                        <table width='690' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td width='30'></td>
                                                <td align='left' valign='middle' style='padding:0;margin:0;font-size:0;line-height:0'>
                                                <a href='http://www.stage.gospelscout.com/' target='_blank'>
                                                <img src='http://www.stage.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='Gospel Scout' ></a></td>
                                                <td width='30'></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='3' align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                <td align='center'>
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to Gospel Scout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello , $admin    </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>The Booking Details..</p><br/>

 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Booked From :</b> $name1        </p> <br/>
  <p style='color:#000;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>

<b> Booked church Name:</b>  $name  </p>  <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Email Id :</b> $emailid        </p> <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Date :</b> $date (YY-MM-DD)       </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Address :</b>  $address           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited :</b> $amount         </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
Gospel Scout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.stage.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan='3' height='30'></td></tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>                           
                           
                            </tbody>
                            </table>
                            
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>
    </tbody>
    </table>
</div>";


     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from;
    	$mail=mail($to,$subject,$message,$headers);

    if(!$mail){ ?>
           <script>
            alert('Can't' Send Register Mail');
            </script>
   <?php } else{ ?>
             <script>
      
            </script>
   <?php  }
}

  ?>

<div class="container">
<?php if($objsession->get('gs_msg') != ""){?>

<div class="suc-message"> <?php echo $objsession->get('gs_msg');?> </div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}
?>
  <h4 class="h4 mb20">Manage Your Booking Details</h4>
  <section id="" class="clearfix">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        <h3 class="h3edit">Scheduled Performance</h3>
        <hr />
        <label><strong>Pending</strong></label>        
        </div>
      </div>
  </div>
  <div style="clear:both;"></div>
  <?php
  if(count($ownpendinglist) > 0){
	  for($sc=0;$sc<count($ownpendinglist);$sc++){
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">First Name : </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($ownpendinglist[$sc]['sFirstName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($ownpendinglist[$sc]['dCreatedDate']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Address</label>
        <label class="col-lg-4 control-label"><?php echo $ownpendinglist[$sc]['sAddress'].' '.$ownpendinglist[$sc]['iZipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php echo $ownpendinglist[$sc]['iAmount'];?></label>
</div>
</div>
</div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label"><a href="<?php echo URL;?>views/churchbooking.php?type=confirm&ID=<?php echo $ownpendinglist[$sc]['iBookID'];?>" class="confm">Confirm</a></label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no pending perfomances</p></div>";} ?>
   
 <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        <label><strong>Confirm</strong></label>        
        </div>
      </div>
  </div>
 <div style="clear:both;"></div>
  <?php
  if(count($ownconfirmlist) > 0){
	  for($sc=0;$sc<count($ownconfirmlist);$sc++){
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">First Name</label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($ownconfirmlist[$sc]['sFirstName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($ownconfirmlist[$sc]['dCreatedDate']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Address</label>
        <label class="col-lg-4 control-label"><?php echo $ownconfirmlist[$sc]['sAddress'].' '.$ownconfirmlist[$sc]['iZipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount</label>
        <label class="col-lg-4 control-label"><?php echo $ownconfirmlist[$sc]['iAmount'];?></label>
</div>
</div>
</div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label"><a href="<?php echo URL;?>views/churchbooking.php?type=cancel&ID=<?php echo $ownconfirmlist[$sc]['iBookID'];?>" class="confm">Cancel</a></label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no confirm perfomances</p></div>";} ?>
   
   
   <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        <h3 class="h3edit">Scheduled Bookings(Church you've Booked)</h3>
        <hr />
        <label><strong>Pending</strong></label>        
        </div>
      </div>
  </div>
  <div style="clear:both;"></div>
  <?php
  if(count($artistpendinglist) > 0){
	  for($sc=0;$sc<count($artistpendinglist);$sc++){
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">First Name : </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artistpendinglist[$sc]['sFirstName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($artistpendinglist[$sc]['dCreatedDate']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Address</label>
        <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['sAddress'].' '.$artistpendinglist[$sc]['iZipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount</label>
        <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['iAmount'];?></label>
</div>
</div>
</div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['sStatus'];?></label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no pending Church perfomances</p></div>";} ?>
   
 <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        <label><strong>Confirm</strong></label>        
        </div>
      </div>
  </div>
 <div style="clear:both;"></div>
  <?php
  if(count($artistconfirmlist) > 0){
	  for($sc=0;$sc<count($artistconfirmlist);$sc++){

  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">First Name</label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artistconfirmlist[$sc]['sFirstName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($artistconfirmlist[$sc]['dCreatedDate']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Address</label>
        <label class="col-lg-4 control-label"><?php echo $artistconfirmlist[$sc]['sAddress'].' '.$ownconfirmlist[$sc]['iZipcode'];?></label>
</div>
</div>
</div>
    <div class="row">

   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount</label>
        <label class="col-lg-4 control-label"><?php echo $artistconfirmlist[$sc]['iAmount'];?></label>
</div>
</div>
</div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <?php if($artistconfirmlist[$sc]['sStatus'] == 'Confirm'){?>
            <label class="col-lg-4 control-label"><a href="<?php echo URL;?>views/churchbooking.php?type=cancel&ID=<?php echo $artistconfirmlist[$sc]['iBookID'];?>" class="confm">Cancel</a></label>
            <?php }else{ 
			echo $artistconfirmlist[$sc]['sStatus'];
			}?>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no confirm Church perfomances</p></div>";} ?>
   
  </section>
</div>
<?php
if(isset($_GET['type']) == 'cancel'){
		$field = array("sStatus");
		$value = array("Pending");		
		$obj->update($field,$value,"iBookID = ".$_GET['ID'],"churchbooking");
		$objsession->set('gs_msg','<p>Booking cancelled Successfully</p>');	
		redirect(URL.'views/churchbooikng.php');	
}
if(isset($_GET['type']) == 'confirm'){
	$field = array("sStatus");
	$value = array("Confirm");		
	$obj->update($field,$value,"iBookID = ".$_GET['ID'],"churchbooking");
	$objsession->set('gs_msg','<p>Booking confirm Successfully</p>');	
	redirect(URL.'views/churchbooikng.php');
}
?>