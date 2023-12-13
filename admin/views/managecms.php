<?php include('../include/header.php'); ?>
<?php
$row = array();
$iPageID = 0;
if(isset($_GET['iPageID'])){
	$cond = '';
	$iPageID = $_GET['iPageID'];
	$cond = "iPageID = ".$iPageID;
	$row = $obj->fetchRow('cmsmaster',$cond);	
}
?>
<script>
$().ready(function() {
		$("#frmCms").validate({
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {
				sPageName:"required",
			//	sDiscription:"required",
			},
			messages: {
				sPageName:"Please enter your page name",
				//sDiscription:"Plesse enter your page description",
			
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
        <h2>Add CMS Page</h2>
               
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

          <form name="frmCms" method="post" id="frmCms">
          <div class="row">
          	<div class="col-lg-2">
                <label>Page Name</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="text" class="form-control" name="sPageName" id="sPageName" value="<?php if(!empty($row)){ echo htmlentities($row['sPageName']);} ?>" >
            </div>
           </div>
           <div class="row">
             <div class="col-lg-2">
                <label>Description</label>
             </div>
             <div class="col-lg-10 mb10">
                <textarea class="form-control" name="sDiscription" id="sDiscription"><?php if(!empty($row)){ echo $row['sDiscription'];} ?></textarea>
                <script type="text/javascript">
		CKEDITOR.replace( 'sDiscription', {
				fullPage: false,
				allowedContent: true,
				width :'100%',	
				startupMode : 'source',
		 });
		 
</script>
            </div>
           </div>           
           <div class="row">
            <div class="col-lg-2">
                <label>Enable</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="radio" name="isActive" id="isActive" <?php if(!empty($row) && $row['isActive'] == 1){ echo "checked='checked'";}else{ if(!isset($_GET['iPageID'])){ ?>checked="checked"<?php } }?> value="1" >Yes
                <input type="radio" name="isActive" <?php if(!empty($row) && $row['isActive'] == 0){ echo "checked='checked'";}?> id="isActive" value="0" >No
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
	extract($_POST);
	$currentDate = date('Y-m-d');
	
	if($iPageID > 0){
		$dCreatedDate = $row['dCreatedDate'];
	}else{
		$dCreatedDate = $currentDate;
	}
	
	$field = array('sPageName','sDiscription',"dCreatedDate","isActive");
	$value = array($sPageName,$sDiscription,$dCreatedDate,$isActive);
	
	if($iPageID > 0){
		
		$cond = "sPageName = '".$sPageName."' AND iPageID !=".$iPageID;
		$cmsRow = $obj->fetchRow('cmsmaster',$cond);	
		 
		 
		 
		if(count($cmsRow) >= 1){
			$objsession->set('gs_errmessage','This page already existing.');	
			redirect(HTTP_SERVER."views/managecsm/".$iPageID);
		}
		else{
		$obj->update($field,$value,'iPageID = '.$iPageID,'cmsmaster');	
		$objsession->set('gs_message',ucfirst($sPageName).' page updated successfully.');	
		redirect(HTTP_SERVER."views/viewcmspages");
		}
	}else{

		$cond = '';
		$cond = "sPageName = '".$sPageName."'";
		$cmsRow = $obj->fetchRow('cmsmaster',$cond);	
		
		if(count($cmsRow) > 0){
			$objsession->set('gs_errmessage','This page already existing.');	
			redirect(HTTP_SERVER."views/managecsm");
		}else{
			$id = $obj->insert($field,$value,'cmsmaster');	
			if($id > 0){
				$objsession->set('gs_message',ucfirst($sPageName).' page added successfully.');	
				redirect(HTTP_SERVER."views/viewcmspages");
			}
		}
	}
}
?>
<?php include('../include/footer.php'); ?>