<?php include('../include/header.php'); ?>
<?php

if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}


$ownpendinglist = $obj->fetchRowAll('bookingmaster',"iRollID = ".$objsession->get('gs_login_id')." AND (sStatus = 'Pending' OR sStatus = 'Cancelled' OR sStatus = 'Decline') ORDER BY iBookingID DESC");
$ownconfirmlist = $obj->fetchRowAll('bookingmaster',"iRollID = ".$objsession->get('gs_login_id')." AND sStatus = 'Confirm' ORDER BY iBookingID DESC");

$artistpendinglist = $obj->fetchRowAll('bookingmaster',"iLoginID = ".$objsession->get('gs_login_id')." AND sStatus = 'Pending' ORDER BY iBookingID DESC");
$artistconfirmlist = $obj->fetchRowAll('bookingmaster',"iLoginID = ".$objsession->get('gs_login_id')." AND sStatus = 'Confirm' ORDER BY iBookingID DESC");

?>
<style>
.loginh2 > p {
  color: #8e44ad;
  margin-bottom: 35px;
  margin-left: 40px;
  margin-top: 27px;
  width: 345px;
}
.txtlable {
  color: #000 !important;
  font-weight: bold;
  margin-left: 70px;
}
.loginh3 > p {
  font-size: 12px;
  margin-left: 100px;
}
.btn-success_new {
  background-color: #9c69d0;
  border-color: #9c69d0;
  color: #fff;
  float: right;
  padding-bottom: 10px;
  padding-top: 10px;
  width: 45%;
}
.txttitle {
  color: #8e44ad;
  font-size: 20px;
  font-weight: bold;
  padding-top: 20px !important;
}
</style>
<style>
.newmsm{
	
	 color: green;
    font-size: 15px;
    line-height: 10px;
    margin-bottom: 0;
    margin-top: 33px;
    padding: 0;
    text-align: center !important;
}
</style>
<div class="container">
<?php if($objsession->get('gs_msg') != ""){?>

<div class="newmsm">  <?php echo $objsession->get('gs_msg');?> </div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}
?>
  <h4 class="h4 mb20">Manage Your Booking Details</h4>
  <section id="" class="clearfix">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-12 m0">
        <h3 class="h3edit">Scheduled Performance</h3>
        <hr />
        <label><strong>Pending</strong></label>        
        </div>
      </div>
  </div>
  <div style="clear:both;"></div>
  <?php
  if(count($ownpendinglist) > 0){
	  for($sc=0;$sc<count($ownpendinglist);$sc++){
		  //echo "iLoginID = ".$ownpendinglist[$sc]['iLoginID'];
		  //$booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$ownpendinglist[$sc]['sType']);
		  $booktype = $obj->fetchRow("eventtypes","iEventID = ".$ownpendinglist[$sc]['sType']);
		  $artist = $obj->fetchRow("usermaster","iLoginID = ".$ownpendinglist[$sc]['iLoginID']);
  ?>
     
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event : </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($ownpendinglist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($ownpendinglist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $ownpendinglist[$sc]['address_event'].' '.$ownpendinglist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $ownpendinglist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ( $ownpendinglist[$sc]['amount_deposite'] > 0 ){ echo '$'.$ownpendinglist[$sc]['amount_deposite'];} else { echo "FREE";}?></label>
</div>
</div>
</div>

<?php 
	if ( $ownpendinglist[$sc]['dDepositeDate'] != "" && $ownpendinglist[$sc]['dDepositeDate'] != "0000-00-00" && $ownpendinglist[$sc]['dDepositeDate'] != "1970-01-01" ) {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($ownpendinglist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>

  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-6 control-label">
            <?php 
			
			if ( date("Y-m-d") >= $ownpendinglist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			
			if($ownpendinglist[$sc]['sStatus'] == 'Cancelled') {
			?>
            <span>CANCELLED</span>
            <?php
			}else if($ownpendinglist[$sc]['sStatus'] == 'Decline') {
				echo "<span>DECLINE</span>";
			}else{
			?>
            
            <div id="myModal01" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content" style=" width: 79%;  border: 1px solid #9c69d0;border-radius: 0;background:#ececec;">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
		 <div class="loginh2">
            <h2 class="txttitle">Thank You For Confirming!!! </h2>
			<p>Thank You for confirming your booking through GospelScout.com.</p>
          </div>
         <div class="loginh3">
			<span class="txtlable">By Clicking Continue I acknowledge that:</span>
			<p>I have read and accepted the <a target="_blank" href="<?php echo URL;?>views/termsandcondition.php">Terms of Use</a></p>
            <p>I agree to and am personally responsible for complying with and honoring the terms specified in the booking itself.</p>
		 </div>
		 
		 <div class="loginh3">
		 <a href="<?php echo URL;?>views/managebooking.php?type=confirm&ID=<?php echo $ownpendinglist[$sc]['iBookingID'];?>&e_id=<?php echo $ownpendinglist[$sc]['e_id'];?>&log_id=<?php echo $ownpendinglist[$sc]['iLoginID'];?>" class="btn btn-success_new col-lg-12">Continue</a>
		 </div>
          </div>
        </div>
        
      </div>
    </div>
    
            <a href="#" data-toggle="modal" id="callform" data-target="#myModal01" class="confm">Confirm</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a onClick="return confirm('Are you sure want to decline this booking?');" href="<?php echo URL;?>views/managebooking.php?type=decline&ID=<?php echo $ownpendinglist[$sc]['iBookingID'];?>" class="confm">Decline</a>
            <?php } } ?>
            
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no pending perfomances</p></div>";} ?>
   
 <div class="row">
       <div class="form-group">
      	<div class="col-lg-8 m0">
        <label><strong>Confirm</strong></label>        
        </div>
      </div>
  </div>
 <div style="clear:both;"></div>
  <?php
  if(count($ownconfirmlist) > 0){
	  for($sc=0;$sc<count($ownconfirmlist);$sc++){
		  
		 // $booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$ownconfirmlist[$sc]['sType']);
		  $booktype = $obj->fetchRow("eventtypes","iEventID = ".$ownconfirmlist[$sc]['sType']);
		   $artist = $obj->fetchRow("usermaster","iLoginID = ".$ownconfirmlist[$sc]['iLoginID']);
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event</label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($ownconfirmlist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($ownconfirmlist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $ownconfirmlist[$sc]['address_event'].' '.$ownconfirmlist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $ownconfirmlist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ( $ownconfirmlist[$sc]['amount_deposite'] > 0 ){ echo '$'.$ownconfirmlist[$sc]['amount_deposite'];}else { echo "FREE";}?></label>
</div>
</div>
</div>
	<?php 
	if ( $ownconfirmlist[$sc]['dDepositeDate'] != "" && $ownconfirmlist[$sc]['dDepositeDate'] != "0000-00-00" && $ownconfirmlist[$sc]['dDepositeDate'] != "1970-01-01" ) {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($ownconfirmlist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label">
            
            <?php 
			
			if ( date("Y-m-d") >= $ownconfirmlist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			?>
            <a onClick="return confirm('Are you sure want to cancel this booking?');" href="<?php echo URL;?>managebooking?type=cancel&ID=<?php echo $ownconfirmlist[$sc]['iBookingID'];?>" class="confm">Cancel</a>
            <?php } ?>            
            
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no confirmed perfomances</p></div>";} ?>
   
   
   <div class="row">
       <div class="form-group">
      	<div class="col-lg-12 m0">
        <h3 class="h3edit">Scheduled Bookings(Artist you've Booked)</h3>
        <hr />
        <label><strong>Pending</strong></label>        
        </div>
      </div>
  </div>
  <div style="clear:both;"></div>
  <?php
  if(count($artistpendinglist) > 0){
	  for($sc=0;$sc<count($artistpendinglist);$sc++){
		  
		 // $booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$artistpendinglist[$sc]['sType']);
		 $booktype = $obj->fetchRow("eventtypes","iEventID = ".$artistpendinglist[$sc]['sType']);
		  $artist = $obj->fetchRow("usermaster","iLoginID = ".$artistpendinglist[$sc]['iRollID']);
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artistpendinglist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($artistpendinglist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['address_event'].' '.$artistpendinglist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $artistpendinglist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ($artistpendinglist[$sc]['amount_deposite'] > 0 ){ echo '$'.$artistpendinglist[$sc]['amount_deposite'];}else { echo "FREE";}?></label>
</div>
</div>
</div>

<?php 
	if ( $artistpendinglist[$sc]['dDepositeDate'] != "" && $artistpendinglist[$sc]['dDepositeDate'] != "0000-00-00" && $artistpendinglist[$sc]['dDepositeDate'] != "1970-01-01" ) {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($artistpendinglist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>

  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label">
             <?php 
			
			if ( date("Y-m-d") >= $artistpendinglist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			?>
            <span class="confm" style="color:#fff !important;"><?php echo $artistpendinglist[$sc]['sStatus'];?></span>
            <?php } ?>               
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no pending artist perfomances</p></div>";} ?>
   
 <div class="row">
       <div class="form-group">
      	<div class="col-lg-8 m0">
        <label><strong>Confirm</strong></label>        
        </div>
      </div>
  </div>
 <div style="clear:both;"></div>
  <?php
  if(count($artistconfirmlist) > 0){
	  for($sc=0;$sc<count($artistconfirmlist);$sc++){
		  
		  //$booktype = $obj->fetchRow('giftmaster',"iGiftID = ".$artistconfirmlist[$sc]['sType']);
		  $booktype = $obj->fetchRow("eventtypes","iEventID = ".$artistconfirmlist[$sc]['sType']);
		   $artist = $obj->fetchRow("usermaster","iLoginID = ".$artistconfirmlist[$sc]['iRollID']);
  ?>
  <div class="pending_book">
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Artist Name: </label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artist['sFirstName']." ".$artist['sLastName']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Name of Event</label>
            <label class="col-lg-4 control-label"><?php echo ucfirst($artistconfirmlist[$sc]['event_name']);?></label>
    </div>
    </div>
    </div>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Date of Event</label>
            <label class="col-lg-4 control-label"><?php echo date("M d, Y",strtotime($artistconfirmlist[$sc]['doe']));?></label>
    </div>
    </div>
    </div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Location</label>
        <label class="col-lg-4 control-label"><?php echo $artistconfirmlist[$sc]['address_event'].' '.$artistconfirmlist[$sc]['zipcode'];?></label>
</div>
</div>
</div>
  <div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Event Type</label>
        <label class="col-lg-4 control-label"><?php echo $booktype['sName'];?></label>
</div>
</div>
</div>
<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Booked As</label>
        <label class="col-lg-4 control-label"><?php echo $artistconfirmlist[$sc]['bookingMe'];?></label>
</div>
</div>
</div>
  <div class="row">

   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Amount Deposited</label>
        <label class="col-lg-4 control-label"><?php if ($artistconfirmlist[$sc]['amount_deposite'] ){ echo '$'.$artistconfirmlist[$sc]['amount_deposite'];}else { echo "FREE";}?></label>
</div>
</div>
</div>
<?php 
	if ( $artistconfirmlist[$sc]['dDepositeDate'] != "" && $artistconfirmlist[$sc]['dDepositeDate'] != "0000-00-00" && $artistconfirmlist[$sc]['dDepositeDate'] != "1970-01-01") {
?>
	<div class="row">
   <div class="form-group">
    <div class="col-lg-8">
        <label class="col-lg-4 control-label">Deposite Date</label>
        <label class="col-lg-4 control-label"><?php echo date("d-m-Y",strtotime($artistconfirmlist[$sc]['dDepositeDate']));?></label>
</div>
</div>
</div>
<?php } ?>
  <div class="row">
       <div class="form-group">
      	<div class="col-lg-8">
        	<label class="col-lg-4 control-label">Status of Booking</label>
            <label class="col-lg-4 control-label">
            <?php 
			
			if ( date("Y-m-d") >= $artistconfirmlist[$sc]['doe'] ) {
				echo "<span>EXPIRED</span>";
			} else {
			?>
            <a onClick="return confirm('Are you sure want to cancel this booking?');" href="<?php echo URL;?>views/managebooking.php?type=cancel&ID=<?php echo $artistconfirmlist[$sc]['iBookingID'];?>" class="confm">Cancel</a>
            <?php } ?>              
            </label>
    </div>
    </div>
    </div>
   </div>
   <div style="clear:both;"></div>
   <?php }}else{echo "<div class='noconfirm'><p>You have no confirmed artist perfomances</p></div>";} ?>
   
  </section>
</div>
<?php

if(isset($_GET['type'])){
	
		if($_GET['type'] == 'cancel'){
			$field = array("sStatus");
			$value = array("Cancelled");		
			$obj->update($field,$value,"iBookingID = ".$_GET['ID'],"bookingmaster");
			$objsession->set('gs_msg','<p>Booking cancelled Successfully</p>');	
			redirect(URL.'views/managebooking.php');
		}
		
		if($_GET['type'] == 'confirm'){
			
			$cond = "e_id = ".$_GET['e_id'];	
			$rolemaster = $obj->fetchRow("eventmaster",$cond);

			if( $rolemaster['iIDs'] != ''){
			$ids = $rolemaster['iIDs'].','.$_GET['log_id'];
			}else{
			$ids = $_GET['log_id'];
			}
			
			$field1 = array("iIDs");
			$value2 = array($ids);
			$obj->update($field1,$value2,'e_id = '.$rolemaster['e_id'],"eventmaster");
			
			$field = array("sStatus");
			$value = array("Confirm");		
			$obj->update($field,$value,"iBookingID = ".$_GET['ID'],"bookingmaster");
			$objsession->set('gs_msg','<p>Booking confirm Successfully</p>');	
			redirect(URL.'views/managebooking.php');
		}
		
		if($_GET['type'] == 'decline'){
			$field = array("sStatus");
			$value = array("Decline");		
			$obj->update($field,$value,"iBookingID = ".$_GET['ID'],"bookingmaster");
			$objsession->set('gs_msg','<p>Booking Decline Successfully</p>');	
			redirect(URL.'views/managebooking.php');
		}
}

?>
<?php include('../include/footer.php');?>