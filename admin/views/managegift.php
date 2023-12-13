<?php include('../include/header.php'); ?>
<?php
$row = array();
$iGiftID = 0;
if(isset($_GET['iGiftID'])){
	$cond = '';
	$iGiftID = $_GET['iGiftID'];
	$cond = "iGiftID = ".$iGiftID;
	$row = $obj->fetchRow('giftmaster',$cond);	
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
        <h2>Add Talent</h2>
               
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
                <label>Talent Name</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="text" class="form-control" name="sCategoryName" id="sCategoryName" value="<?php if(!empty($row)){ echo $row['sGiftName'];} ?>" >
            </div>
           </div>         
           <div class="row">
            <div class="col-lg-2">
                <label>Enable</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="radio" name="isActive" id="isActive" <?php if(!empty($row) && $row['isActive'] == 1){ echo "checked='checked'";}else{ if(!isset($_GET['iGiftID'])){ ?>checked="checked"<?php } }?> value="1" >Yes
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
	
	$field = array('sGiftName','isActive');
	$value = array($sCategoryName,$isActive);
	
	if($iGiftID > 0){
		
		$obj->update($field,$value,'iGiftID = '.$iGiftID,'giftmaster');	
		$objsession->set('gs_message','Gift updated successfully.');	
		redirect(HTTP_SERVER."views/viewgifts");
		
	}else{

			$id = $obj->insert($field,$value,'giftmaster');	
			if($id > 0){
				$objsession->set('gs_message','Gift added successfully.');	
				redirect(HTTP_SERVER."views/viewgifts");
			}
	}
}
?>
<?php include('../include/footer.php'); ?>