<?php include('../include/header.php'); ?>
<?php

if(isset($_GET['type'])){
			
	if($_GET['type'] == 'church'){

		$cond = "isActive IN(1,0) AND sUserType = 'church'";
		$churchids = $obj->getConcateValue('usermaster','iLoginID',$cond);
		
		$totaleventmaster = $obj->fetchNumOfRow('eventmaster','iLoginID IN('.$churchids['ROLL'].')');
		$eventmaster = $obj->fetchRowAll('eventmaster','iLoginID IN('.$churchids['ROLL'].')');	
	}
	
	if($_GET['type'] == 'artist'){
		
		$cond = "isActive IN(1,0) AND sUserType = 'artist'";
		$artistids = $obj->getConcateValue('usermaster','iLoginID',$cond);

		$totaleventmaster = $obj->fetchNumOfRow('eventmaster','iLoginID IN('.$artistids['ROLL'].')');
		$eventmaster = $obj->fetchRowAll('eventmaster','iLoginID IN('.$artistids['ROLL'].')');
	}
	
}else{
	
	$cond=" isActive IN(1) order by e_id DESC";
	$eventmaster = $obj->fetchRowAll('eventmaster',$cond);
	$totaleventmaster = $obj->fetchNumOfRow('eventmaster',$cond);
}
?>
<script type="text/javascript">
	$(function () {

	$("#example1").DataTable({
		"lengthMenu": [20],
		"lengthChange": false,
		"searching": false,
		"pagingType": "numbers",
		"bJQueryUI": true,
		"sDom": '<"H"lfrp>t<"F"ip>',
		"info": false,
		"ordering": false,
		paging : $("#example1").find('tbody tr').length > 5
	});
	

});
	
</script>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Events</h2>
        <hr class="hrforrow" />
        
        <div class="">

<?php if($objsession->get('gs_message') != ""){?>
<span id="success-message"><?php echo $objsession->get('gs_message'); ?></span>
<?php $objsession->remove('gs_message');}?>
<?php
	if($totaleventmaster > 0){
?>
          <table border="2" class="table table-hover" id="example1" style="margin-top:10px;">
            <thead>
              <tr>
                <th>SR.No</th>
                <th>Name</th>
                <th>Image</th>
                <th>Address</th>
                <th>Price</th>
                <th>Description</th>
				<th>Created Date</th>
				<th>Event Date</th>
                <th>Created By</th>
                <th>Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
			<?php	
				$sr = 1;
				for($i=0;$i<count($eventmaster);$i++)
				{
					$row = $obj->fetchRow('usermaster','iLoginID = '.$eventmaster[$i]['iLoginID']);
					$img = explode(',',$eventmaster[$i]['sMultiImage']);
					
            ?>
              <tr>
              	<td><?php echo str_pad($sr,2,'0',STR_PAD_LEFT);?></td>
                <td><?php echo $eventmaster[$i]['event_name'];?></td>
                <td><img src="<?php echo URL;?>upload/event/multiple/<?php echo $img[0];?>" width="100" height="80" /></td>
                <td><?php echo $eventmaster[$i]['address_event'];?></td>
                <td><?php echo '$'.$eventmaster[$i]['amount_deposite'];?></td>                
                <td><?php echo $eventmaster[$i]['sDesc'];?></td>
				<td><?php echo $eventmaster[$i]['dCreatedDate'];?></td>
				<td><?php echo $eventmaster[$i]['doe'];?></td>
                <td><?php if($row['sUserName'] != ''){ echo ucfirst($row['sUserName']);}else{echo '---';}?></td>
                <td><?php if($row['sUserType'] != ""){echo ucfirst($row['sUserType']);}else{echo '---';}?></td>                
                <td style="padding:5px;"><a href="<?php echo HTTP_SERVER;?>views/eventdetails.php?eventID=<?php echo $eventmaster[$i]['e_id'];?>" title="View Detail"><i class="fa fa-fw fa-eye"></i></a> | 
                    <a href="<?php echo HTTP_SERVER;?>views/viewevents.php?eventID=<?php echo $eventmaster[$i]['e_id'];?>" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i class="fa fa-fw fa-remove"></i></a></td>
              </tr>  
            <?php $sr ++; } ?>            
            </tbody>
          </table>
<?php }else{ ?>
<span class="recordnotfound">Event not found.</span>
<?php } ?>
        </div>
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php
if(isset($_GET['eventID'])){

		$field = array('isActive');
		$value = array(0);
		
		if($obj->update($field, $value, "e_id = ".$_GET['eventID'],'eventmaster') == true){
			$objsession->set('gs_message','Event successfully deleted.');	
			redirect(HTTP_SERVER."views/viewevents.php");
		}
}
?>
<?php include('../include/footer.php'); ?>
