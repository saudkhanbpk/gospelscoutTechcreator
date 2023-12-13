<?php

/*-------------------------------------------------------+
| Content Management System 
| http://www.phphelptutorials.com/
+--------------------------------------------------------+
| Author: David Carr  Email: dave@daveismyname.co.uk
+--------------------------------------------------------+*/

ob_start();

define('DBHOST','localhost');
define('DBUSER','gospelsc_user');
define('DBPASS','Gg@123456');
define('DBNAME','gospelsc_db651933262');

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}
?>
<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>

<?php

if(isset($_POST['submit']))
{

$email=$_POST['email']; 

$query=mysql_query("select * from loginmaster where sEmailID='$email'");
$row=mysql_fetch_array($query);

$pass=$row['sPassword'];
 
$id=$row['iLoginID'];

$query1=mysql_query("select * from usermaster where iLoginID='$id'");
$row1=mysql_fetch_array($query1);

$name= $row1['sFirstName']." ".$row1['sLastName'];

$url="http://www.gospelscout.com/views/password?id=$email";

$to = $email; // this is your Email address

    $from = "maulik@omshantiinfotech.com"; // this is the sender's Email address
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
                                                <a href='http://www.gospelscout.com/' target='_blank'>
                                                <img src='http://www.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='Gospel Scout' ></a></td>
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
Hello , $name        </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>Thank you for signing up with Gospel Scout.</p><br/>
                                                    <p style='color:#000;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Please Click on this link.</b>  $url    </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>



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
 
    
    if(!$mail){ ?>
           <script>
            alert('Can't' Send Register Mail');
            </script>
   <?php } else{ ?>
             <script>
            alert('Please Check Your Mail....');
			window.location='http://www.gospelscout.com/';
            </script>
   <?php  }

}
  ?>


        <form method="POST" action="">
    <table border="0" width="30%" height="100px" align="center" class="forgot-password-class">
      <tr>
        <td class="col-lg-5 control-label">Enter Your Email Id <span>*</span></td>
        <td class="col-lg-7">
          <input type="text" class="form-control" name="email">
        </td>
      </tr>
	<tr>
        <td class="col-lg-4" colspan="2">
          <input type="submit" class="form-control" name="submit" value="submit">
        </td>
	</tr>
    </table>
	</form>




<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php'); ?>