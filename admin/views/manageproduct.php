<?php include('../include/header.php'); ?>
<?php
$row = array();
$iProductID = 0;

if(isset($_GET['iProductID'])){
	$cond = '';
	$iProductID = $_GET['iProductID'];
	$cond = "iProductID = ".$iProductID;
	$row = $obj->fetchRow('productmaster',$cond);	
}
$cat = $obj->fetchRowAll('categorymaster',"isActive = 1");

?>
<script>
$().ready(function() {
			
		$("#frmPro").validate({
			debug: false,
			errorClass: "error",
			errorElement: "span",
		
			rules: {
				sProductName:"required",
				sProductImage:{
					required:true,
					extension: "png|jpg",
				},
				sProductImage01:{
					extension: "png|jpg",
				},
				iCategoryID:"required",
				sDescription:"required",
				
			},
			messages: {
				sProductName:"Please enter your product name",
				sProductImage:{
					required:"Please select product image",
					extension: "Please upload only image only",
				},
				sProductImage01:{
					extension: "Please upload only PNG|JPG image only",
				},
				iCategoryID:"Please select category",
				iSubCategoryID:"Please select sub category",
				sDescription:"Plese enter description",
		
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
        <h2>Add Product</h2>
               
<?php if($objsession->get('ct_message') != ""){?>
<div class="error-message">
<?php echo $objsession->get('ct_message');?>
</div>
<?php $objsession->remove('ct_message');}
else if($objsession->get('ct_errmessage') != ""){
?>
<span class="err_span"><?php echo $objsession->get('ct_errmessage');?></span>
<?php
$objsession->remove('ct_errmessage');
}
?> 

          <form name="frmPro" method="post" id="frmPro" enctype="multipart/form-data">
          <div class="row">
          	<div class="col-lg-2">
                <label>Product Name</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="text" class="form-control" name="sProductName" id="sProductName" value="<?php if(!empty($row)){ echo $row['sProductName'];} ?>" >
            </div>
           </div>
          <div class="row">
          	<div class="col-lg-2">
                <label>Category</label>
            </div>
            <div class="col-lg-6 mb10">
            	<input type="hidden" id="frmType" value="" />
                <select name="iCategoryID" id="iCategoryID" onchange="subCategory(this.value)" class="form-control">
                <option value="">Select category</option>
                <?php
				if(count($cat) > 0){
					$select = '';
					for($i=0;$i<count($cat);$i++){
						if($row['iCategoryID'] == $cat[$i]['iCategoryID']){
							$select = 'selected="selected"';
							$iSubCatID = $row['iCategoryID'];
						}
				?>
                <option <?php echo $select;?> value="<?php echo $cat[$i]['iCategoryID'];?>"><?php echo $cat[$i]['sCategoryName'];?></option>
                <?php	
					}
					$select = '';
				}
				?>
                </select>
            </div>
           </div>
          
          <div class="row">
          	<div class="col-lg-2">
                <label>Product Image</label>
            </div>
            <div class="col-lg-6 mb10">                
                <?php if(!empty($row) && $row['sProductImage'] != ''){?>
                <input type="file" class="form-control" name="sProductImage01" id="sProductImage01" value="<?php if(!empty($row)){ echo $row['sProductImage'];} ?>" >
                <img src="<?php echo HTTP_SERVER;?>upload/<?php echo $row['sProductImage'];?>" width="100" height="80" />
                <?php }else{?>
					<input type="file" class="form-control" name="sProductImage" id="sProductImage" value="<?php if(!empty($row)){ echo $row['sProductImage'];} ?>" >
			<?php } ?>		
                </div>
           </div>
              
           <!--<div class="row">
          	<div class="col-lg-2">
                <label>Price</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="text" class="form-control" name="iPrice" id="iPrice" value="<?php if(!empty($row)){ echo $row['iPrice'];} ?>" >
            </div>
           </div>-->
           <div class="row">
          	<div class="col-lg-2">
                <label>Description</label>
            </div>
            <div class="col-lg-6 mb10">
                <textarea class="form-control" name="sDescription" id="sDescription"><?php if(!empty($row)){ echo $row['sDescription'];} ?></textarea>
            </div>
           </div>       
           <div class="row">
            <div class="col-lg-2">
                <label>Enable</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="radio" name="isActive" id="isActive" <?php if(!empty($row) && $row['isActive'] == 1){ echo "checked='checked'";}else{ if(!isset($_GET['iProductID'])){ ?>checked="checked"<?php } }?> value="1" >Yes
                <input type="radio" name="isActive" <?php if(!empty($row) && $row['isActive'] == 0){ echo "checked='checked'";}?> id="isActive" value="0" >No
            </div>
           </div>
           <div class="row">
            <div class="col-lg-6">
            <input type="hidden" name="xval" value="0" id="xval" />
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
	
	if($iProductID > 0){
		$dCreatedDate = $row['dCreatedDate'];
	}else{
		$dCreatedDate = $currentDate;
	}
	
	if(isset($_FILES["sProductImage"]["name"]) != '' || (isset($_FILES["sProductImage01"]["name"]) && $iProductID > 0)){
		$randno = rand(0,5000);
		
		if(isset($_FILES["sProductImage"]["name"])){
			$img = $_FILES["sProductImage"]["name"];
			$sProductImage = $randno.$img;		
			move_uploaded_file($_FILES['sProductImage']['tmp_name'],"../upload/". $sProductImage);
		}else{
			if($_FILES["sProductImage01"]["name"] != ""){
				deleteImage($row['sProductImage'],'upload');
				$img = $_FILES["sProductImage01"]["name"];
				$sProductImage = $randno.$img;
				move_uploaded_file($_FILES['sProductImage01']['tmp_name'],"../upload/". $sProductImage);
			}else{
				$sProductImage = $row['sProductImage'];		
			}
		}
		
					
	}else{
		$sProductImage = $row['sProductImage'];	
	}
		
	$field = array('sProductName','sProductImage','iCategoryID','sDescription',"dCreatedDate","isActive");
	$value = array($sProductName,$sProductImage,$iCategoryID,$sDescription,$dCreatedDate,$isActive);
		
	if($iProductID > 0){
		$obj->update($field,$value,"iProductID = ".$iProductID,'productmaster');	
		$objsession->set('ct_message',ucfirst($sProductName).' product updated successfully.');	
		redirect(HTTP_SERVER."productview");
	}else{
			$id = $obj->insert($field,$value,'productmaster');	
			if($id > 0){
				$objsession->set('ct_message',ucfirst($sProductName).' product added successfully.');	
				redirect(HTTP_SERVER."productview");

		}
	}
}
?>
<?php include_once('http://localhost/gospelscout//depsonshealthcare/manage/include/footer.php'); ?>