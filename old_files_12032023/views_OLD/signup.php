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

$query1=mysql_query("select * from contentmaster where type='User' order by id DESC");
$row1=mysql_fetch_array($query1);

$user=$row1['content'];

$query2=mysql_query("select * from contentmaster where type='Artist' order by id DESC");
$row2=mysql_fetch_array($query2);

$artist=$row2['content'];

$query3=mysql_query("select * from contentmaster where type='Church' order by id DESC");
$row3=mysql_fetch_array($query3);

$church=$row3['content'];


?>

<div class="container mt50">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
    <h4 class="h4 mb20">Choose Your Profile Type</h4>
  </div>
</div>
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
    <div class="col-lg-4 col-md-4 col-sm-4 "> <a href="<?php echo URL;?>views/user.php">
      <div class="border text-center">
        <h1 class="h1">User</h1>
        <p class="p"><?php echo $user;?></p>
      </div>
      </a> </div>
    <div class="col-lg-4 col-md-4 col-sm-4 "> <a href="<?php echo URL;?>views/artist.php">
      <div class="border text-center">
        <h1 class="h1">Artist</h1>
        <p class="p"><?php echo $artist;?></p>
      </div>
      </a> </div>
    <div class="col-lg-4 col-md-4 col-sm-4 "> <a href="<?php echo URL;?>views/church.php">
      <div class="border text-center">
        <h1 class="h1">Church</h1>
        <p class="p"><?php echo $church;?></p>
      </div>
      </a> </div>
  </div>
</div>
