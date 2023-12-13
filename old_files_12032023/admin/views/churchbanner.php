<?php include('../include/header.php'); ?>
<?php
$cond=" isActive IN(1,0) order by iGiftID DESC";
$catlist = $obj->fetchRowAll('giftmaster',$cond);
$totalcat = $obj->fetchNumOfRow('giftmaster',$cond);
?>
<script type="text/javascript">
	$(function () {

	$("#example1").DataTable({
		"lengthMenu": [10],
		"lengthChange": false,
		"searching": false,
		"pagingType": "numbers",
		"bJQueryUI": true,
		"sDom": '<"H"lfrp>t<"F"ip>',
		"info": false,
		"ordering": false,
		paging : $("#example1").find('tbody tr').length > 10
	});
	

});
	
</script>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>List of Artist Banner</h2>
        <hr class="hrforrow" />
        
        <a href="<?php echo HTTP_SERVER;?>views/addartistbanner.php" class="btn btn-xs btn-info">Add Banner</a>
        <div class="">

<?php if($objsession->get('gs_message') != ""){?>
<span id="success-message"><?php echo $objsession->get('gs_message'); ?></span>
<?php $objsession->remove('gs_message');}?>
<?php
	if($totalcat > 0){
?>
          <table class="table table-hover" id="example1">
            <thead>
              <tr>
                <th>Artist Banner Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
			<?php	
				for($cat=0;$cat<count($catlist);$cat++)
				{
            ?>
              <tr>
                <td><?php echo $catlist[$cat]['sGiftName'];?></td>
                <td>
                <a href="<?php echo HTTP_SERVER;?>views/managegift.php?iGiftID=<?php echo $catlist[$cat]['iGiftID'];?>" title="Edit"><i class="fa fa-fw fa-edit"></i></a> | 
                <a href="<?php echo HTTP_SERVER;?>views/viewgifts.php?iGiftID=<?php echo $catlist[$cat]['iGiftID'];?>&type=delete" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i class="fa fa-fw fa-remove"></i></a> | 
                <?php if($catlist[$cat]['isActive'] == 1){?>
                <a onClick="return confirm('Are you sure want to deactive this gift?');" href="<?php echo HTTP_SERVER;?>views/viewgifts.php?iGiftID=<?php echo $catlist[$cat]['iGiftID'];?>&type=1" title="Deactive" >Deactive</a>
                <?php
				}else{
				?>
                <a href="<?php echo HTTP_SERVER;?>views/viewgifts.php?iGiftID=<?php echo $catlist[$cat]['iGiftID'];?>&type=0" title="Active" onClick="return confirm('Are you sure want to active this user?');" >Active</a>
                <?php
				}?>
                </td>
              </tr>  
            <?php } ?>            
            </tbody>
          </table>
<?php }else{ ?>
<span class="recordnotfound">Artist Banner not found.</span>
<?php } ?>
        </div>
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>

<?php

if(isset($_GET['iGiftID']) && isset($_GET['type'])){

		if($_GET['type'] == 'delete'){

			if($obj->delete('giftmaster',"iGiftID = ".$_GET['iGiftID']) == true){
	
				$objsession->set('gs_message','Gift successfully deleted.');	
				redirect(HTTP_SERVER."viewgifts");
			}
		}
		
		if($_GET['type'] == '1'){
			
			$field = array('isActive');
			$value = array(0);
			
			if($obj->update($field,$value,"iGiftID = ".$_GET['iGiftID'],'giftmaster') == true){			
				$objsession->set('gs_message','Gift successfully deactived.');	
				redirect(HTTP_SERVER."viewgifts");
			}	
			
		}
		
		if($_GET['type'] == '0'){
			
			$field = array('isActive');
			$value = array(1);
			
			if($obj->update($field,$value,"iGiftID = ".$_GET['iGiftID'],'giftmaster') == true){			
				$objsession->set('gs_message','Gift  successfully actived.');	
				redirect(HTTP_SERVER."viewgifts");
			}	
			
		}

}

?>
<?php include('../include/footer.php'); ?>
