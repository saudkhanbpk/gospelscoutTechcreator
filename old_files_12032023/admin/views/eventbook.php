<?php include('../include/header.php'); ?>
<?php
$cond="isActive IN(1) order by iBookingID DESC";
$eventmaster = $obj->fetchRowAll('eventbooking',$cond);
$totaleventmaster = $obj->fetchNumOfRow('eventbooking',$cond);
?>
<script type="text/javascript">
	$(function () {
	$("#example1").DataTable({
		"lengthMenu": [5],
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
        <h2>Event Booking</h2>
        <hr class="hrforrow"/>
        
        <div class="">

<?php if($objsession->get('gs_message') != ""){?>
<span id="success-message"><?php echo $objsession->get('gs_message'); ?></span>
<?php $objsession->remove('gs_message');}?>
<?php
	if($totaleventmaster > 0){
		
		
?>
          <table border="1" class="table table-hover" id="example1">
            <thead>
              <tr>
                <th>Created By</th>
                <th>Event Name</th>
                <th>Price</th>
                <th>Date Of Event</th>
                <th>Time</th>
		<th>Event Type</th>
                <th>Book By</th>
                <th>Status</th>
               	<th>Action</th> 
              </tr>
            </thead>
            <tbody>
			<?php	
				for($i=0;$i<count($eventmaster);$i++)
				{
					
					$cond1="iLoginID = '".$eventmaster[$i]['iLoginID']."'";
		$eventmaster1 = $obj->fetchRow('usermaster',$cond1);
				$cond2="iLoginID = '".$eventmaster[$i]['iRollID']."'";
		$eventmaster2 = $obj->fetchRow('usermaster',$cond2);
			$cond3="iEventID = '".$eventmaster[$i]['sType']."'";
		$eventmaster3 = $obj->fetchRow('eventtypes',$cond3);  
		

	
					//$img = explode(',',$eventmaster[$i]['sMultiImage']);
					
            ?>
              <tr>
                <td><?php if($eventmaster1 != ''){echo $eventmaster1['sFirstName']." ".$eventmaster1['sLastName'];}else{echo '---';}?></td>
              <td><?php echo $eventmaster[$i]['event_name'];?></td>   
               <td><?php echo "$".$eventmaster[$i]['amount_deposite'];?></td>   
                 <td><?php echo date('d-m-Y',strtotime($eventmaster[$i]['doe']));?></td>   
                   <td><?php echo $eventmaster[$i]['toe'];?></td>   
                    <td><?php if($eventmaster3['sName'] != ""){echo $eventmaster3['sName'];}else{echo '---';}?></td>   
              <td><?php if($eventmaster2 != ''){echo $eventmaster2['sFirstName']." ".$eventmaster2['sLastName'];}else{echo '---';}?></td>
                <td><a href="<?php echo HTTP_SERVER;?>views/eventbook.php?bookIDS=<?php echo $eventmaster[$i]['iBookingID'];?>&satus=<?php  echo $eventmaster[$i]['sStatus']; ?>"><?php echo $eventmaster[$i]['sStatus'];?></a></td>              
                <td>
                    <a href="<?php echo HTTP_SERVER;?>views/eventbook.php?bookID=<?php echo $eventmaster[$i]['iBookingID'];?>" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i class="fa fa-fw fa-remove"></i></a></td>
              </tr>  
            <?php } ?>            
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
if(isset($_GET['bookIDS'])){

if($_GET['satus']=="Pending"){
		$field = array('sStatus');
		$value = array('Completed');
		
		if($obj->update($field, $value, "iBookingID = ".$_GET['bookIDS'],'eventbooking') == true){
			$objsession->set('gs_message','Booking Status Update Sucessfully.');	
			redirect(HTTP_SERVER."eventbook");    
		}
}
else {
		$field = array('sStatus');
		$value = array('Pending');	
			if($obj->update($field, $value, "iBookingID = ".$_GET['bookIDS'],'eventbooking') == true){
			$objsession->set('gs_message','Booking Status Update Sucessfully.');	
			redirect(HTTP_SERVER."eventbook");  
		}}
}

if(isset($_GET['bookID'])){

		$field = array('isActive');
		$value = array(0);
		
		if($obj->update($field, $value, "iBookingID = ".$_GET['bookID'],'bookingmaster') == true){
			$objsession->set('gs_message','Booking successfully deleted.');	
			redirect(HTTP_SERVER."artistbook");    
		}
}
?>
<?php include('../include/footer.php'); ?>
