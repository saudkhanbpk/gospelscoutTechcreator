<?php

/*-------------------------------------------------------+
| Content Management System 
| http://www.phphelptutorials.com/
+--------------------------------------------------------+
| Author: David Carr  Email: dave@daveismyname.co.uk
+--------------------------------------------------------+*/

ob_start();

define('DBHOST','db651933262.db.1and1.com');
define('DBUSER','dbo651933262');
define('DBPASS','Gg@123456');
define('DBNAME','db651933262');

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}
?>
<?php include('../include/header.php'); ?>
<?php

if(isset($_POST['btn_add']))
{

$sBannerName=$_POST['sBannerName'];
/*$sMultiImage = '';
		if($_FILES["sBanner"] != ''){
		
			for($i=0;$i<count($_FILES["sBanner"]['name']);$i++) {
				
				$randno = rand(0,5000);
				$img = $_FILES["sBanner"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sBannere"]['tmp_name'][$i],"../admin/images/".$randno.$img);			
				
			}
			
			$sMultiImage = rtrim($sMultiImage,',');
		}

		$field = array("bannername","bannerimage","isActive");
		$value = array($sBannerName,$sMultiImage,1);		
		$obj->insert($field,$value,"mainbanner"); */ 

$allowed=("jpg|jpeg|png|bmp|gif|doc|pdf");
	$filename=$_FILES['sBanner']['name'];

	$path="../admin/images/".$filename;
	move_uploaded_file($_FILES['sBanner']['tmp_name'],$path);


	$query="INSERT INTO mainbanner VALUES('','$sBannerName','$path',1)";
	$row=mysql_query($query);

	if($row==1)
	{
		echo "<script>alert('Added Successfully');</script>";
	}
	else
	{
		echo "<script>alert(' Could't Added);</script>";
	}
}
?>


<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Add Banner</h2>
               

          <form name="frmCms" method="post" action="">
          <div class="row">
          	<div class="col-lg-2">
                <label>Banner Name</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="text" class="form-control" name="sBannerName" >
            </div>
           </div>
           <div class="row">
             <div class="col-lg-2">
                <label>Browse Banner</label>
             </div>
             <div class="col-lg-6 mb10">
                <input type="file" style="padding: 0px 12px;" class="form-control" name="sBanner" >
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