<?php include('../include/header.php');?>
 <?php

if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}



$ownpendinglist = $obj->fetchRowAll('bookingmaster',"iRollID = ".$objsession->get('gs_login_id')." AND sStatus = 'Pending' ORDER BY iBookingID DESC ");
$ownconfirmlist = $obj->fetchRowAll('bookingmaster',"iRollID = ".$objsession->get('gs_login_id')." AND sStatus = 'Confirm' ORDER BY iBookingID DESC");

$artistpendinglist = $obj->fetchRowAll('bookingmaster',"iLoginID = ".$objsession->get('gs_login_id')." AND sStatus = 'Pending' ORDER BY iBookingID DESC");
$artistconfirmlist = $obj->fetchRowAll('bookingmaster',"iLoginID = ".$objsession->get('gs_login_id')." AND sStatus = 'Confirm' ORDER BY iBookingID DESC");

$booking_id = $obj->fetchRow('loginmaster',"iLoginID = ".$objsession->get('gs_login_id'));

$booking_name = $obj->fetchRow('usermaster',"iLoginID = ".$objsession->get('gs_login_id'));

$booked_id = $obj->fetchRow('loginmaster',"iLoginID = ".$_GET['booked_id']);

$booked_name = $obj->fetchRow('usermaster',"iLoginID = ".$_GET['booked_id']);

$All_data = $obj->fetchRow('bookingmaster',"iRollID = ".$_GET['booked_id']." ORDER BY iBookingID DESC");

$event_no=$All_data['sType'];

$event_type=$obj->fetchRow('eventtypes',"iEventID = ".$event_no);

?>
<style>
.loginh2 > p {
  color: #8e44ad;
  margin-bottom: 35px;
  margin-left: 40px;
  margin-top: 27px;
  width: 345px;
}
.txtlable {
  color: #000 !important;
  font-weight: bold;
  margin-left: 70px;
}
.loginh3 > p {
  font-size: 12px;
  margin-left: 100px;
}
.btn-success_new {
  background-color: #9c69d0;
  border-color: #9c69d0;
  color: #fff;
  float: right;
  padding-bottom: 10px;
  padding-top: 10px;
  width: 45%;
}
.txttitle {
  color: #8e44ad;
  font-size: 20px;
  font-weight: bold;
  padding-top: 20px !important;
}
</style>
<style>
.newmsm{
	
	 color: green;
    font-size: 15px;
    line-height: 10px;
    margin-bottom: 0;
    margin-top: 33px;
    padding: 0;
    text-align: center !important;
}
</style>

<?php
if($_GET['paypal'])
{

//$booked_name= $booked_name['sFirstName'];
//$booked_name1= $booked_name['sLastName'];
$name= ucfirst($booked_name['sFirstName']." ".$booked_name['sLastName']);


 

$event= $All_data['event_name'];
$event_date= $All_data['doe'];
$event_location= $All_data['address_event']." ".$All_data['zipcode'];
$event_type=$event_type['sName'];
$booked_as= $All_data['bookingMe'];
$amount= $All_data['amount_deposite'];
$depositedate= $All_data['dDepositeDate'];



	$to = $booked_id['sEmailID']; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello , $name    </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>You Are Booked For This Details...</p><br/>
                                                    <p style='color:#000;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Artist Name:</b>  $name  </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Name of Event :</b> $event        </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Date of Event:</b> $event_date(YY-MM-DD)          </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Location:</b> $event_location           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Type:</b> $event_type           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Booked As:</b> $booked_as           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited:</b> $amount           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Deposite Date:</b> $depositedate (YY-MM-DD)        </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello , $name1    </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>Your Booking Details...</p><br/>
                                                    <p style='color:#000;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Artist Name:</b>  $name  </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Name of Event :</b> $event        </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Date of Event:</b> $event_date (YY-MM-DD)          </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Location:</b> $event_location           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Type:</b> $event_type           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Booked As:</b> $booked_as           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited:</b> $amount           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Deposite Date:</b> $depositedate (YY-MM-DD)          </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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

$from1 = "Administrator@gospelscout.com";

     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from1;
    $mail=mail($booking_id['sEmailID'],$subject,$message,$headers); 

$admin="Admin";
$booker="Administrator@gospelscout.com";
$adminid="maulik@omshantiinfotech.com";

	$to = $adminid; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
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

<b> Booked Artist Name:</b>  $name  </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Name of Event :</b> $event        </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Date of Event:</b> $event_date (YY-MM-DD)          </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Location:</b> $event_location           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Type:</b> $event_type           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Booked As:</b> $booked_as           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited:</b> $amount           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Deposite Date:</b> $depositedate (YY-MM-DD)          </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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
     $headers .= "From:" .$booker;
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

<?php 

if($_GET['type'] == "confirm")

	{

	$to = $adminid; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
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

<b> Booked Artist Name:</b>  $name  </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Name of Event :</b> $event        </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Date of Event:</b> $event_date (YY-MM-DD)          </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Location:</b> $event_location           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Event Type:</b> $event_type           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Booked As:</b> $booked_as           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Amount Deposited:</b> $amount           </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b>Deposite Date:</b> $depositedate (YY-MM-DD)          </p> <br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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

     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$to;

}
?>
<div class="container">
<?php if($objsession->get('gs_msg') != ""){?>

<div class="newmsm">  <?php echo $objsession->get('gs_msg');?> </div>
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
      	<div class="col-lg-12 m0">
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
		  //echo "iLoginID = ".$ownpendinglist[$sc]['iLoginID'];
		  //$booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$ownpendinglist[$sc]['sType']);
		  $booktype = $obj->fetchRow("eventtypes","iEventID = ".$ownpendinglist[$sc]['sType']);
		  $artist = $obj->fetchRow("usermaster","iLoginID = ".$ownpendinglist[$sc]['iLoginID']);
  ?>
     
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
			
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
			<!--<div class="loginh3"><a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistbooking.php?rollid=<?php echo $ownpendinglist[$sc]['iBookingID'];?>&status=Pending" style="color: red;float: right;">X</a></div>-->
    </div>
    </div>
	
    </div>
	
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event : </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($ownpendinglist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($ownpendinglist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $ownpendinglist[$sc]['address_event'].' '.$ownpendinglist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $ownpendinglist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ( $ownpendinglist[$sc]['amount_deposite'] > 0 ){ echo '$'.$ownpendinglist[$sc]['amount_deposite'];} else { echo "FREE";}?></label>
</div>
</div>
</div>

<?php 
	if ( $ownpendinglist[$sc]['dDepositeDate'] != "" && $ownpendinglist[$sc]['dDepositeDate'] != "0000-00-00" && $ownpendinglist[$sc]['dDepositeDate'] != "1970-01-01" ) {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($ownpendinglist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>

  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-6 control-label">
            <?php 
			
			if ( date("Y-m-d") >= $ownpendinglist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			
			if($ownpendinglist[$sc]['sStatus'] == 'Cancelled') {
			?>
            <span>CANCELLED</span>
            <?php
			}else if($ownpendinglist[$sc]['sStatus'] == 'Decline') {
				echo "<span>DECLINE</span>";
			}else{
			?>
            
            <div id="myModal01" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content" style=" width: 110%;  border: 1px solid #9c69d0;border-radius: 0;background:#ececec;">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
		 <div class="loginh2">
            <h2 class="txttitle">Thank You For Confirming!!! </h2>
			<p>Thank You for confirming your booking through GospelScout.com.</p>
          </div>
         <div class="loginh3">
			<span class="txtlable">By Clicking Continue I acknowledge that:</span>
			<p>I have read and accepted the <a target="_blank" href="<?php echo URL;?>views/termsandcondition.php">Terms of Use</a></p>
            <p>I agree to and am personally responsible for complying with and honoring the terms specified in the booking itself.</p>
		 </div>
		 
		 <div class="loginh3">
		 <a class="btn btn-success_new col-lg-12" href="<?php echo URL;?>views/artistbooking.php?type=confirm&ID=<?php echo $ownpendinglist[$sc]['iBookingID'];?>&e_id=<?php echo $ownpendinglist[$sc]['e_id'];?>&log_id=<?php echo $ownpendinglist[$sc]['iLoginID'];?>">Continue</a>
		 </div>
          </div>
        </div>
        
      </div>
    </div>
    
            <a href="#" data-toggle="modal" id="callform" data-target="#myModal01" class="confm">Confirm</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a onClick="return confirm('Are you sure want to decline this booking?');" href="<?php echo URL;?>views/artistbooking.php?type=decline&ID=<?php echo $ownpendinglist[$sc]['iBookingID'];?>&log_id=<?php echo $ownpendinglist[$sc]['iLoginID'];?>" class="confm">Decline</a>
            <?php } } ?>
            
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>




<?php }}else{echo "<div class='noconfirm'><p>You have no pending perfomances</p></div>";} ?>
   
 <div class="row">
       <div class="form-group">
      	<div class="col-lg-8 m0">
        <label><strong>Confirm</strong></label>        
        </div>
      </div>
  </div>
 <div style="clear:both;"></div>
  <?php
  if(count($ownconfirmlist) > 0){
	  for($sc=0;$sc<count($ownconfirmlist);$sc++){
		  
		 // $booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$ownconfirmlist[$sc]['sType']);
		  $booktype = $obj->fetchRow("eventtypes","iEventID = ".$ownconfirmlist[$sc]['sType']);
		   $artist = $obj->fetchRow("usermaster","iLoginID = ".$ownconfirmlist[$sc]['iLoginID']);
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
			<!--<div class="loginh3"><a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistbooking.php?rollid=<?php echo $ownconfirmlist[$sc]['iBookingID'];?>&status=Confirm" style="color: red;float: right;">X</a></div>-->
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event</label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($ownconfirmlist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($ownconfirmlist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $ownconfirmlist[$sc]['address_event'].' '.$ownconfirmlist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $ownconfirmlist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ( $ownconfirmlist[$sc]['amount_deposite'] > 0 ){ echo '$'.$ownconfirmlist[$sc]['amount_deposite'];}else { echo "FREE";}?></label>
</div>
</div>
</div>
	<?php 
	if ( $ownconfirmlist[$sc]['dDepositeDate'] != "" && $ownconfirmlist[$sc]['dDepositeDate'] != "0000-00-00" && $ownconfirmlist[$sc]['dDepositeDate'] != "1970-01-01" ) {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($ownconfirmlist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label">
            
            <?php 
			
			if ( date("Y-m-d") >= $ownconfirmlist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			?>
            <a onClick="return confirm('Are you sure want to cancel this booking?');" href="<?php echo URL;?>views/artistbooking?type=cancel&ID=<?php echo $ownconfirmlist[$sc]['iBookingID'];?>&e_id=<?php echo $ownconfirmlist[$sc]['e_id'];?>&log_id=<?php echo $ownconfirmlist[$sc]['iLoginID'];?>" class="confm">Cancel</a>
            <?php } ?>            
            
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no confirmed perfomances</p></div>";} ?>
   
   
   <div class="row">
       <div class="form-group">
      	<div class="col-lg-12 m0">
        <h3 class="h3edit">Scheduled Bookings(Artist you've Booked)</h3>
        <hr />
        <label><strong>Pending</strong></label>        
        </div>
      </div>
  </div>
  <div style="clear:both;"></div>
  <?php
  if(count($artistpendinglist) > 0){
	  for($sc=0;$sc<count($artistpendinglist);$sc++){
		  
		 // $booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$artistpendinglist[$sc]['sType']);
		 $booktype = $obj->fetchRow("eventtypes","iEventID = ".$artistpendinglist[$sc]['sType']);
		  $artist = $obj->fetchRow("usermaster","iLoginID = ".$artistpendinglist[$sc]['iRollID']);
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
			<!--<div class="loginh3"><a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistbooking.php?rollid=<?php echo $artistpendinglist[$sc]['iBookingID'];?>&status=Pending" style="color: red;float: right;">X</a></div>-->
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artistpendinglist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($artistpendinglist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['address_event'].' '.$artistpendinglist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ($artistpendinglist[$sc]['amount_deposite'] > 0 ){ echo '$'.$artistpendinglist[$sc]['amount_deposite'];}else { echo "FREE";}?></label>
</div>
</div>
</div>

<?php 
	if ( $artistpendinglist[$sc]['dDepositeDate'] != "" && $artistpendinglist[$sc]['dDepositeDate'] != "0000-00-00" && $artistpendinglist[$sc]['dDepositeDate'] != "1970-01-01" ) {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($artistpendinglist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>

  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label">
             <?php 
			
			if ( date("Y-m-d") >= $artistpendinglist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			?>
            <span class="confm" style="color:#fff !important;"><?php echo $artistpendinglist[$sc]['sStatus'];?></span>
            <?php } ?>               
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no pending artist perfomances</p></div>";} ?>
   
 <div class="row">
       <div class="form-group">
      	<div class="col-lg-8 m0">
        <label><strong>Confirm</strong></label>        
        </div>
      </div>
  </div>
 <div style="clear:both;"></div>
  <?php
  if(count($artistconfirmlist) > 0){
	  for($sc=0;$sc<count($artistconfirmlist);$sc++){
		  
		  //$booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$artistconfirmlist[$sc]['sType']);
		  $booktype = $obj->fetchRow("eventtypes","iEventID = ".$artistconfirmlist[$sc]['sType']);
		   $artist = $obj->fetchRow("usermaster","iLoginID = ".$artistconfirmlist[$sc]['iRollID']);
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
			<!--<div class="loginh3"><a onclick="return confirm('Are you sure want to delete ?');" href="<?php echo URL;?>views/artistbooking.php?rollid=<?php echo $artistconfirmlist[$sc]['iBookingID'];?>&status=Confirm" style="color: red;float: right;">X</a></div>-->
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event</label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artistconfirmlist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($artistconfirmlist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $artistconfirmlist[$sc]['address_event'].' '.$artistconfirmlist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $artistconfirmlist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">

   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ($artistconfirmlist[$sc]['amount_deposite'] ){ echo '$'.$artistconfirmlist[$sc]['amount_deposite'];}else { echo "FREE";}?></label>
</div>
</div>
</div>
<?php 
	if ( $artistconfirmlist[$sc]['dDepositeDate'] != "" && $artistconfirmlist[$sc]['dDepositeDate'] != "0000-00-00" && $artistconfirmlist[$sc]['dDepositeDate'] != "1970-01-01") {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($artistconfirmlist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label">
            <?php 
			
			if ( date("Y-m-d") >= $artistconfirmlist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			?>
            <a onClick="return confirm('Are you sure want to cancel this booking?');" href="<?php echo URL;?>views/artistbooking.php?type=cancel&ID=<?php echo $artistconfirmlist[$sc]['iBookingID'];?>&e_id=<?php echo $artistconfirmlist[$sc]['e_id'];?>&log_id=<?php echo $artistconfirmlist[$sc]['iLoginID'];?>" class="confm">Cancel</a>
            <?php } ?>              
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no confirmed artist perfomances</p></div>";} ?>
   
  </section>
</div>
<?php
if(isset($_GET['rollid']))
{
$obj->delete("bookingmaster","iBookingID = ".$_GET['rollid']." AND sStatus = '".$_GET['status']."'");
}

if(isset($_GET['type'])){
	
		if($_GET['type'] == 'cancel'){
			$field = array("sStatus");
			$value = array("Cancelled");		
			$obj->update($field,$value,"iBookingID = ".$_GET['ID'],"bookingmaster");
			$cond = "e_id = ".$_GET['e_id'];
	
			$rolemaster = $obj->fetchRow("eventmaster",$cond);
			
			$booked_id1 = $obj->fetchRow('loginmaster',"iLoginID = ".$_GET['log_id']);
			
			$confirm_name = $obj->fetchRow('usermaster',"iLoginID = ".$_GET['log_id']);

			$c_name= ucfirst($confirm_name['sFirstName']." ".$confirm_name['sLastName']);

			$b_name= ucfirst($booking_name['sFirstName']." ".$booking_name['sLastName']);

    $to = $booked_id1['sEmailID']; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello ,  $b_name </p> <br/>   <br/>                                                  

  <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>You have <b>CANCELLED</b> The Booking of <b>$c_name</b> </p><br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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

$message2 .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello ,  $c_name </p> <br/>   <br/>                                                  

  <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>Your Booking of <b>$b_name</b> is <b>CANCELLED</b> by <b>$b_name</b>.</p><br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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
    $mail=mail($to,$subject,$message2,$headers);

$from1=$booking_id['sEmailID'];

     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from;
    $mail=mail($from1,$subject2,$message,$headers);

		echo "<script>
alert('Booking Cancelled Successfully');
window.location.href='artistbooking.php';
</script>";
		}
		
		if($_GET['type'] == 'confirm'){
			
			$cond = "e_id = ".$_GET['e_id'];	
			$rolemaster = $obj->fetchRow("eventmaster",$cond);

			if( $rolemaster['iIDs'] != ''){
			$ids = $rolemaster['iIDs'].','.$_GET['log_id'];
			}else{
			$ids = $_GET['log_id'];
			}
			
			$field1 = array("iIDs");
			$value2 = array($ids);
			$obj->update($field1,$value2,'e_id = '.$rolemaster['e_id'],"eventmaster");
			
			$field = array("sStatus");
			$value = array("Confirm");		
			$obj->update($field,$value,"iBookingID = ".$_GET['ID'],"bookingmaster");

			$cond = "e_id = ".$_GET['e_id'];
	
			$rolemaster = $obj->fetchRow("eventmaster",$cond);
			
			$booked_id1 = $obj->fetchRow('loginmaster',"iLoginID = ".$_GET['log_id']);
			
			$confirm_name = $obj->fetchRow('usermaster',"iLoginID = ".$_GET['log_id']);

			$c_name= ucfirst($confirm_name['sFirstName']." ".$confirm_name['sLastName']);

			$b_name= ucfirst($booking_name['sFirstName']." ".$booking_name['sLastName']);

			$to = $booked_id1['sEmailID']; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello ,  $b_name </p> <br/>   <br/>                                                  

  <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>You have confirm The Booking of <b>$c_name</b> </p><br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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

$message2 .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello ,  $c_name </p> <br/>   <br/>                                                  

  <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>Your Booking of <b>$b_name</b> is <b>CONFIRMED</b> by <b>$b_name</b>.</p><br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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
    $mail=mail($to,$subject,$message2,$headers);

$from1=$booking_id['sEmailID'];

     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from;
	$mail=mail($from1,$subject2,$message,$headers);

		echo "<script>
alert('Booking Confirm Successfully');
window.location.href='artistbooking.php';
</script>";
	}
		
			if($_GET['type'] == 'decline'){
			$field = array("sStatus");
			$value = array("Decline");		
			$obj->update($field,$value,"iBookingID = ".$_GET['ID'],"bookingmaster");
			

			$booked_id1 = $obj->fetchRow('loginmaster',"iLoginID = ".$_GET['log_id']);
			
			$confirm_name = $obj->fetchRow('usermaster',"iLoginID = ".$_GET['log_id']);

			$c_name= ucfirst($confirm_name['sFirstName']." ".$confirm_name['sLastName']);

			$b_name= ucfirst($booking_name['sFirstName']." ".$booking_name['sLastName']);

	$to = $booked_id1['sEmailID']; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Booking - GospelScout";
  
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
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
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello ,  $b_name </p> <br/>   <br/>                                                  

  <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>You have DECLINE The Booking of <b>$c_name</b> </p><br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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

$message2 .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello ,  $c_name </p> <br/>   <br/>                                                  

  <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>Your Booking of <b>$b_name</b> is <b>DECLINED</b> by <b>$b_name</b>.</p><br/>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
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
    $mail=mail($to,$subject,$message2,$headers);

$from1=$booking_id['sEmailID'];

     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from;
	$mail=mail($from1,$subject2,$message,$headers); 
	
			$objsession->set('gs_msg','<p>Booking Decline Successfully</p>');
			redirect(URL.'views/artistbooking.php');
		}
}

?>
<?php include('../include/footer.php');?>