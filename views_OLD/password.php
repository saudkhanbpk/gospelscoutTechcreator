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
$id=$_GET['id'];

$email=$_POST['email'];
$new=$_POST['new']; 
$renew=$_POST['renew'];
$renew1=md5($_POST['renew']);

if ($new!= $renew)
 {
     echo "<script>alert('Please Enter Same Password.');</script>";
 }
else
{
$query=mysql_query("update loginmaster set sPassword='$renew1' where sEmailID='$id'");
header('Location: http://www.stage.gospelscout.com/');

}
}
?>

<form method="POST" action="">
    <table border="0" width="400px" height="200px" align="center">
      <tr>
        <td class="col-lg-4 control-label">Enter New Password : <span>*</span></td>
        <td class="col-lg-4">
          <input type="password" class="form-control" name="new" required>
        </td>
      </tr>

	<tr>
        <td class="col-lg-4 control-label">Re-Enter New Password : <span>*</span></td>
        <td class="col-lg-4">
          <input type="password" class="form-control" name="renew" required>
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