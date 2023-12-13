<?php include('../include/header.php'); ?>
<?php
$row = array();
$iGiftID = 0;
if(isset($_GET['iGiftID'])){
	$cond = '';
	$iGiftID = $_GET['iGiftID'];
	$cond = "iGiftID = ".$iGiftID;
	$row = $obj->fetchRow('bannermaster',$cond);	
}
?>
<script>
$().ready(function() {
		$("#frmCat").validate({
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {
				sCategoryName:"required",
			},
			messages: {
				sCategoryName:"Please enter your category name",
		
			},
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},			
			submitHandler: function(form) {
				 form.submit();
			}
		});
	});
</script>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Add Artist Banner</h2>
               
<?php if($objsession->get('gs_message') != ""){?>
<div class="error-message">
<?php echo $objsession->get('gs_message');?>
</div>
<?php $objsession->remove('gs_message');}
else if($objsession->get('gs_errmessage') != ""){
?>
<span class="err_span"><?php echo $objsession->get('gs_errmessage');?></span>
<?php
$objsession->remove('gs_errmessage');
}
?> 

          <form name="frmCat" method="post" id="frmCat" enctype="multipart/form-data">
          <div class="row">
          	<div class="col-lg-2">
                <label>Multiple Images</label>
            </div>
            <div class="col-lg-6 mb10">
                 <input type="file" class="form-control file" id="sProfileMore" name="sProfileMore[]" multiple="multiple" >
            </div>
           </div>         
           
           <div class="row">
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
<?php

if(isset($_POST['btn_add'])){
	extract($_POST)	;
		$sMultiImage = '';
		if($_FILES["sProfileMore"] != ''){
		
			for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
				
				$randno = rand(0,5000);
				$img = $_FILES["sProfileMore"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/artist/multiple/".$randno.$img);			
				
			}
			
			$sMultiImage = rtrim($sMultiImage,',');
		}

		$field = array("banner_name","banner_type","isActive");
		$value = array($sMultiImage,"artist",1);		
		$obj->insert($field,$value,"bannermaster");  
		
		
				
		//$objsession->set('gs_msg','<p>Hello,</p><p>Thanks for the Event Registration.</p><br><p>Thanks,</p><strong>Gospel Team</strong>');			
		redirect(URL.'admin/views/addartistbanner.php');			

}


?>
<?php include('../include/footer.php'); ?>