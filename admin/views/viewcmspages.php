<?php include('../include/header.php'); ?>
<?php
$cond=" isActive IN(1,0) order by iPageID DESC";
$cmslist = $obj->fetchRowAll('cmsmaster',$cond);
$totalcms = $obj->fetchNumOfRow('cmsmaster',$cond);
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
        <h2>CMS Pages</h2>
        <a href="<?php echo HTTP_SERVER;?>views/managecms.php" class="btn btn-xs btn-info">Add New</a>
        <div class="table-responsive">

<?php if($objsession->get('gs_message') != ""){?>
<span id="success-message"><?php echo $objsession->get('gs_message'); ?></span>
<?php $objsession->remove('gs_message');}?>
<?php
	if($totalcms > 0){
?>
          <table border="1" class="table table-hover" id="example1">
            <thead>
              <tr>
                <th>Page Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
			<?php	
				for($sev=0;$sev<count($cmslist);$sev++)
				{
            ?>
              <tr>
                <td><?php echo $cmslist[$sev]['sPageName'];?></td>
                <td><a href="<?php echo HTTP_SERVER;?>views/managecms.php?iPageID=<?php echo $cmslist[$sev]['iPageID'];?>" title="Edit"><i class="fa fa-fw fa-edit"></i></a> | 
                    <a href="<?php echo HTTP_SERVER;?>views/viewcmspages.php?iPageID=<?php echo $cmslist[$sev]['iPageID'];?>" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i class="fa fa-fw fa-remove"></i></a></td>
              </tr>  
            <?php } ?>            
            </tbody>
          </table>
<?php }else{ ?>
<span>CMS page not found.</span>
<?php } ?>
        </div>
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php
if(isset($_GET['iPageID'])){

		if($obj->delete('cmsmaster',"iPageID = ".$_GET['iPageID']) == true){
			$objsession->set('gs_message','CMS page successfully deleted.');	
			redirect(HTTP_SERVER."viewcmspages");
		}
}
?>
<?php include('../include/footer.php'); ?>
