<?php include('../include/header.php'); ?>
 
<?php
if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}

 $bannermaster = array();
 $iBannerID = 0;
 
 if ( isset($_GET['iBannerID']) ) {
	 
	 $iBannerID = $_GET['iBannerID'];
	 $bannermaster = $obj->fetchRow('bannermaster','iBannerID = '.$_GET['iBannerID']);
 }
 
?>

<div class="container">

<h4 class="h4 mb20">Manage Banner</h4>

  <section id="" class="clearfix">
  <form class="form-horizontal" action="" method="POST" id="myform" enctype="multipart/form-data">
  
    <div class="cslide-slides-container clearfix">
      <div class="cslide-slide">
        
    <fieldset id="account_information" class="">
           <div class='form-group'>
            <label for="user_image" class="col-lg-4 control-label">Upload Multiple Image</label>
              <div class="col-lg-4">            
            <?php
			if(!empty($bannermaster)) {
			?>
            <input type="file" class="form-control file" id="sProfileMore01" name="sProfileMore01" >
            <img src="<?php echo URL;?>upload/banners/<?php echo $bannermaster['banner_name'];?>" width="100" height="80" />
            <?php
			}else{
			?>
            <input type="file" class="form-control file" id="sProfileMore[]" name="sProfileMore[]" multiple="multiple" >
            <?php	
			}
			?>
          </div> </div>
    
      <div class="form-group">
<div class="col-lg-4 text-right">
  </div>
  <div class="col-lg-4 text-center">
          <p>
            <input type="submit" value="SUBMIT" name="btn_submit" class="btn btn-success">
          </p>
        </div>
  </div>
      
    </fieldset>
    
      </div>
      
     </div>
  </form>
  </section>

  <script type="text/javascript">
	
	
	
$(document).ready(function() {	
			
		$("#myform").validate({

				errorClass: "error",
			errorElement: "span",
				rules: {
					
				<?php if( $iBannerID > 0) { ?>
					sProfileMore01:	{
						extension : true,
					},					
				<?php } else{?>
					'sProfileMore[]':	{
						required: true,
						extension : true,
					},
				<?php } ?>
				},
				messages: {
					
					<?php if( $iBannerID > 0) { ?>
					sProfileMore01:{
						extention : "Upload only JPG | JPEG and PNG image only",
					},					
				<?php } else{?>
					'sProfileMore[]':{
						required: "Image required",
						extention : "Upload only JPG | JPEG and PNG image only",
					},
				<?php } ?>
				
					
				},
					submitHandler: function(form) {
					form.submit();}
				
			});
	
		
});
</script>
  
</div>
<?php
if(isset($_POST['btn_submit'])){
	extract($_POST)	;
		$sMultiImage = '';
		
	if( $iBannerID > 0) {
		
		if($_FILES["sProfileMore01"]['name'] != ''){
		
			$img = $_FILES["sProfileMore01"]['name'];
			move_uploaded_file($_FILES["sProfileMore01"]['tmp_name'],"../upload/banners/".$randno.$img);			
			deleteImage($bannermaster['banner_name'],'upload/banners');
			$sMultiImage = $randno.$img;

		}else{
			$sMultiImage = $bannermaster['banner_name'];
		}

		$field = array("iLoginID","banner_name");
		$value = array($objsession->get('gs_login_id'),$sMultiImage);	
					
		$obj->update($field,$value,'iBannerID = '.$iBannerID,"bannermaster");
		
		echo "<script>alert('Banner updated successfully.');</script>";
		
	}else{
		
		if($_FILES["sProfileMore"] != ''){
		
			for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
				
				$randno = rand(0,5000);
				$img = $_FILES["sProfileMore"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/banners/".$randno.$img);
				
				$field = array("iLoginID","banner_name");
				$value = array($objsession->get('gs_login_id'),$randno.$img);		
				$obj->insert($field,$value,"bannermaster");			
				
			}
			
		}
		
	}
		redirect(URL.'views/viewbanner.php');			

}
?>
