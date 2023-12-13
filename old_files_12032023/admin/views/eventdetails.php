<?php include('../include/header.php'); ?>
<?php

$cond = "e_id = ".$_GET['eventID'];
$eventmaster = $obj->fetchRow('eventmaster',$cond);

$country = array();
$states = array();
$cities = array();

if($eventmaster['country'] != ""){
$country = $obj->fetchRow('countries','id = '.$eventmaster['country']);
$states = $obj->fetchRow('states','id = '.$eventmaster['state']);
$cities = $obj->fetchRow('cities','id = '.$eventmaster['city']);
}

$img = explode(',',$eventmaster['sMultiImage']);

?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Event Details</h2>
        <div class="table-responsive">

<?php
	if(count($eventmaster) > 0){
?>
          <table border="2" class="table table-hover">
              <tr>
                <th class="col-lg-2">Event Name</th>
                <td>
                <?php 
					echo $eventmaster['event_name'];				
				?>
                </td>
                <th>Country</th>
                <td><?php if(!empty($country)){ echo $country['name'];}else{echo '---';}?></td>
                </tr>
                <tr>
				
                <th class="col-lg-2">Address</th>
                <td>
                <?php 
					echo $eventmaster['address_event'];				
				?>
                </td>
                <th>State</th>
                <td><?php if(!empty($states)){echo $states['name'];}else{ echo '---';}?></td>
                </tr>
                <tr>
                <th>Description</th>
                <td><?php 
					echo $eventmaster['sDesc'];	
				?></td>
                <th>City</th>
                <td><?php if(!empty($cities)){echo $cities['name'];}else{echo '---';}?></td>
                </tr>
                <tr>
                <th>Date</th>
                <td><?php echo date('d-m-Y',strtotime($eventmaster['doe'])).' '.date('H:i',strtotime($eventmaster['toe']));?></td>
				
                <th>Zipcode</th>
                <td><?php 
					echo $eventmaster['zipcode'];				
				?></td>
				
                </tr>
				<th class="col-lg-2">Who's Sponsoring</th>
                <td>
                <?php 
					echo $eventmaster['eSponsor'];				
				?>
                </td>
                <tr>
                
                <?php
				if(!empty($img)){
					$n=0;
					foreach($img as $val)	{
						if($n == 4){
							echo "</tr><tr>";	
							$n = 0;
						}
				?>
                <td><img src="<?php echo URL;?>upload/event/multiple/<?php echo $val;?>" width="100" height="80" /></td>
                <?php	
				$n++;
					}
				}
				?>
                </tr>
          </table>
<?php }else{ ?>
<span>Event detail not found.</span>
<?php } ?>
        </div>  
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php include('../include/footer.php'); ?>
