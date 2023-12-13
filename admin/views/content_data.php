<?php include('../include/header.php'); ?>
<?php

$catlist = $obj->fetchRowAll('contentmaster',"1=1");
$totalcat = $obj->fetchNumOfRow('contentmaster',$cond);
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
        <h2>List of Gift</h2>
        <hr class="hrforrow" />
        <div class="">

<?php if($objsession->get('gs_message') != ""){?>
<span id="success-message"><?php echo $objsession->get('gs_message'); ?></span>
<?php $objsession->remove('gs_message');}?>
<?php
	if($totalcat > 0){
?>
          <table border="1" class="table table-hover" id="example1">
            <thead>
              <tr>
                <th>Type</th>
				<th>Content</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
			<?php	
				for($cat=0;$cat<count($catlist);$cat++)
				{
            ?>
              <tr>
                <td><?php echo $catlist[$cat]['type'];?></td>
				<td><?php echo $catlist[$cat]['content'];?></td>				
                <td>
                <a href="<?php echo HTTP_SERVER;?>views/content.php?ID=<?php echo $catlist[$cat]['id'];?>" title="Edit"><i class="fa fa-fw fa-edit"></i></a>
                </td>
              </tr>  
            <?php } ?>            
            </tbody>
          </table>
<?php }else{ ?>
<span class="recordnotfound"> not found.</span>
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

			if($obj->delete('giftmaster1',"iGiftID = ".$_GET['iGiftID']) == true){
	
				$objsession->set('gs_message','Gift successfully deleted.');	
				redirect(HTTP_SERVER."views/viewgifts1");
			}
		}
		
		if($_GET['type'] == '1'){
			
			$field = array('isActive');
			$value = array(0);
			
			if($obj->update($field,$value,"iGiftID = ".$_GET['iGiftID'],'giftmaster1') == true){			
				$objsession->set('gs_message','Gift successfully deactived.');	
				redirect(HTTP_SERVER."views/viewgifts1");
			}	
			
		}
		
		if($_GET['type'] == '0'){
			
			$field = array('isActive');
			$value = array(1);
			
			if($obj->update($field,$value,"iGiftID = ".$_GET['iGiftID'],'giftmaster1') == true){			
				$objsession->set('gs_message','Gift  successfully actived.');	
				redirect(HTTP_SERVER."views/viewgifts1");
			}	
			
		}

}

?>
<?php include('../include/footer.php'); ?>
