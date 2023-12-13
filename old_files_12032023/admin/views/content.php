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
<?php include('../include/header.php'); ?>
<?php
$id=$_GET['ID'];

$query1=mysql_query("select * from contentmaster where id='$id'");
$row1=mysql_fetch_array($query1);
?>
<?php

if(isset($_POST['btn_add']))
{

$user=$_POST['user'];
$content=$_POST['content'];


	$query=mysql_query("update contentmaster set content='$content' where type='$user'");

}
?>

<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Add Content</h2>
               

          <form name="frmCms" method="post" action="">
			<div class="row">
          	<div class="col-lg-2">
                <label>Type</label>
            </div>
            <div class="col-lg-6 mb10">
                <select name="user" class="form-control" id="users" value="<?php if($_GET['ID']){ echo $row1['type'];}?>" disabled>
						<option <?php if($_GET['ID'] == 3){ echo 'selected';}?>>User</option>
						<option <?php if($_GET['ID'] == 4){ echo 'selected';}?>>Artist</option>
						<option <?php if($_GET['ID'] == 5){ echo 'selected';}?>>Church</option>
				</select>
            </div>
           </div>
				
          <div class="row">
          	<div class="col-lg-2">
                <label>Content</label>
            </div>
            <div class="col-lg-10 mb10">
                <textarea class="form-control" name="content" id="content"><?php if($_GET['ID']){ echo $row1['content'];}?></textarea>
				<script type="text/javascript">
			CKEDITOR.replace( 'content', {
				fullPage: false,
				allowedContent: true,
				width :'100%',	
		 });
		 
</script>
            </div>
           </div>     
            <div class="col-lg-6">
             	<input type="submit" name="btn_add" class="btn btn-default" value="Submit">
            </div>
            </div>
          </form>
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php include('../include/footer.php'); ?>