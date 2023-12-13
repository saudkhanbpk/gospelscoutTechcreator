<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>

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

if(isset($_POST['btn_submit']))
{

$fullname=$_POST['sFullName'];
$emailid=$_POST['sEmailID'];
$state=$_POST['iStateID'];
$city=$_POST['city'];
$mobile=$_POST['mobile'];
$messages=$_POST['message'];


$query1="insert into contact_us values('','$fullname','$emailid','$state','$city','$mobile','$message')";
$row1=mysql_query($query1);

$admin="Admin";
	$to = "Administrator@gospelscout.com"; // this is your Email address

    $from = $emailid; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Registration - GospelScout";
  
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
Hello , $admin      </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>Thank you for signing up with GospelScout.</p><br/>
 <p style='color:#000;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Full Name:</b>  $fullname    </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Email:</b>  $emailid    </p>  <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Mobile:</b>  $mobile    </p>  <br/>
<p style='color:#404040;font-size:16px;line-height:22px;padding:0;margin:0;text-align:left;'>
<b> Message:</b>  $messages    </p>  <br/>


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
 
    
    if(!$mail){ ?>
           <script>
            alert('Can't' Send Register Mail');
            </script>
   <?php } else{ ?>
             <script>
            alert('Successfully Submited');
			window.location='http://www.gospelscout.com/';
            </script>
   <?php  }

}
  ?>
<?php
$states     = $obj->fetchRowAll("states",'country_id = 231');
?>
<div class="container">
<?php
$countrymaster = $obj->fetchRowAll("countries",'1=1');
?>
<h4 class="h4" style="margin-bottom: 20px;">Contact Us</h4>

  
  <form class="form-horizontal" action="" method="POST" id="myform">
  
 
<div class="cslide-slides-container clearfix">
      <div class="cslide-slide">
        
    <fieldset id="account_information" class="">
      <div class="form-group">
        <label for="firstname" class="col-lg-4 control-label">Full Name <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sFirstName" name="sFullName" placeholder="Enter Your FullName" required>
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-lg-4 control-label">Email <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sEmailID" name="sEmailID" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Ex.example@gmail.com" required>
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-lg-4 control-label">State <span>*</span></label>
		<div class="col-lg-4">
        <select name="iStateID" class="form-control states" id="stateId" required>
          <option value="">Select State</option>
          <?php
					if(count($states) > 0){
						for($s=0;$s<count($states);$s++){
				?>
          <option value="<?php echo $states[$s]['id'];?>"><?php echo $states[$s]['name'];?></option>
          <?php
						}
					}
				?>
        </select>
			</div>
      </div>
    </div>
      <div class="form-group">
        <label for="email" class="col-lg-4 control-label">City <span>*</span></label>
		<div class="col-lg-4">
        <select name="city" class="form-control cities" id="cityId" required>
          <option value="">Select City</option>
        </select>
			</div>
      </div>
    </div>
		<div class="form-group">
        <label for="country" class="col-lg-4 control-label">Mobile Number<span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" name="mobile" pattern="[0-9]{10}" placeholder="Enter Only 10 Digits" required>
        </div>
      </div>
		<div class="form-group">
        <label for="country" class="col-lg-4 control-label">Your Message<span>*</span></label>
        <div class="col-lg-4">
          <textarea class="form-control" rows="10" cols="10" name="message" placeholder="Enter Your Message." required></textarea>
        </div>
      </div>
      <div class="form-group">
      <label class="col-lg-4 control-label" for="image"></label>
        <div class="col-lg-4 text-right">
          <input class="btn btn-success cslide-next" type="submit" name="btn_submit" value="Submit">
        </div>
      </div>
    </fieldset>
    </div>
     </div>
  </form>
</div>
<script type="text/javascript">
$('#stateId').on('change', function (e) {
	
			  $('#cityId').html('');
			  var stateId = $('#stateId').val();
			  e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea.php?type=city&iStateID='+stateId,
				//data: formData,
				success: function (data) {
				
				  if(data == 'Please select state'){
					 $('#cityId').html("<option value=''>Select City</option>");
				  }else{
					 $('#cityId').html(data);
				  }
				}
			  });
		});
</script>
<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php'); ?>