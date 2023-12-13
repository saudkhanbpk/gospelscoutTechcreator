<?php include('../include/header.php'); ?>
<?php
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypal_id='gospel_scout@yahoo.com';
?>

<style>
.col-sm-12.col-md-12.col-lg-12.borderbuttom.boxshado.mt50.mt30.pt20 h3 {
  font-size: 15px;
  line-height: 23px;
}
.SimilarEventsDiv
{
	width:23% !important;
}
.h3edit {
  clear: both;
}
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
  margin-bottom: 35px;
  margin-left: 100px;
}
.btn-success {
  background-color: #9c69d0;
  border-color: #9c69d0;
  color: #fff;
  float: right;
  padding-bottom: 10px;
  padding-top: 10px;
  width: 45%;
}
</style>

<div class="container">
  <section id="" class="clearfix">

<?php   $sid_eid=$_GET['event'];
 $rolemaster = array();
	$cond="e_id='".$sid_eid."'";	
$rolemaster = $obj->fetchRow("eventmaster",$cond);
$usermaster = $obj->fetchRow("usermaster","iLoginID = ".$rolemaster['iLoginID']);

$state = $obj->fetchRow("states","id = ".$rolemaster['state']);
$cities = $obj->fetchRow("cities","id = ".$rolemaster['city']);

$eventtypes = $obj->fetchRow("eventtypes","iEventID = ".$rolemaster['sType']);

 ?>

<?php 
if($rolemaster['event_name'])
{
?>

  <div class="col-sm-12 col-md-12 col-lg-12">
  <script>
   $('#carousel-example-generic').carousel({
  interval: 3000,
  cycle: true
}); 
  </script>
  <div class="col-sm-12 col-md-12 col-lg-12 mb20">
  	<h3 class="fl" style="color:#8e44ad !important;margin-top:14px;">Event</h3>
    <a class="back fr" href="<?php echo URL;?>views/search4event.php">Back</a>
  </div>  
  <div class="col-sm-12 col-md-12 col-lg-12 boxshado">
  <ul role="tablist" class="nav nav-tabs">
  
</ul>
    <div class="cslide-slides-container clearfix">
      <div class="cslide-slide siddhant">
      
    
  <div class="col-lg-2">  <?php   $siddhant=(explode(",",$rolemaster['sMultiImage']));?>
   	 <?php    $sid1=count($siddhant);?>
    </div>
   
    <div class="col-md-8">
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> 
    <!-- Indicators -->
    <ol class="carousel-indicators">
<?php     for($i=0;$i<$sid1;$i++){?>
      <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i;?>" class="active"></li><?php }?>
    </ol>
    <!-- Wrapper for slides -->
     
    <div class="carousel-inner mt20" role="listbox">
      <?php
	  	if($sid1 > 0){
			for($i=0;$i<$sid1;$i++){ ?>
      <div class="item <?php if($i == 0){echo 'active';}?>"><img src="<?php echo URL;?>upload/event/multiple/<?php echo $siddhant[$i];?>" style="margin: 0px auto;">
      </div>
      <?php 
			}
		}
	  ?>
    </div>
    
    <!-- Controls --> 
    <a class="left carousel-control parmar" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control parmar" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
</div> 
<div class="col-lg-2">
</div>
</div>
</div>

</div>
<style>
.mycls
{
	border-right:1px solid #ccc;
}

.siddhant .parmar
{
	display:none !important;
}
.txttitle
{
color: #8e44ad;
    font-size: 20px;
    font-weight: bold;
    padding-top: 20px !important;
}
</style>

<div id="myModal01" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content" style=" width: 110%;  border: 1px solid #9c69d0;border-radius: 0;background:#ececec;">
      <form name="pay" id="pay" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
		 <div class="loginh2">
            <h2 class="txttitle">Thank You For Booking!!! </h2>
			<p>Thank You for sending an event booking through GospelScout.com. Please click continue to move on to the payment portion of the booking submission.</p>
          </div>
         <div class="loginh3">
			<span class="txtlable">By Clicking Continue I agree that:</span>
			<p>I have read and accepted the <a target="_blank" href="<?php echo URL;?>views/termsandcondition.php">Terms of Use</a></p>
		 </div>
		 
		 <div class="loginh3">
		 <input type="submit" class="btn btn-success col-lg-12" name="btn_sub" value="Continue">
		 </div>
          </div>
		  
          </form>
        </div>
        
      </div>
    </div>
	
<?php 
  if(isset($_POST['btn_sub'])){
	extract($_POST);
	
	/*if( $rolemaster['iIDs'] != ''){
		$ids = $rolemaster['iIDs'].','.$objsession->get('gs_login_id');
	}else{
		$ids = $objsession->get('gs_login_id');
	}
	
	$field1 = array("iIDs");
	$value2 = array($ids);
	$obj->update($field1,$value2,'e_id = '.$rolemaster['e_id'],"eventmaster");*/
	
	
	$field = array("iRollID","iLoginID","event_name","address_event","state","city","zipcode","doe","toe","amount_deposite","sType","dCreatedDate","sStatus","isActive","e_id");
	$value = array($rolemaster['iLoginID'],$objsession->get('gs_login_id'),$rolemaster['event_name'],$rolemaster['address_event'],$rolemaster['state'],$rolemaster['city'],$rolemaster['zipcode'],$rolemaster['doe'],$rolemaster['toe'],$rolemaster['amount_deposite'],$rolemaster['sType'],date("Y-m-d"),"Pending",1,$rolemaster['e_id']);	
			
	if($obj->insert($field,$value,"eventbooking")){
	
	/*echo "<script>alert('Event booking successfully.');</script>";*/
	$objsession->set('gs_total_amount',$rolemaster['amount_deposite']);
	$tax = ($rolemaster['amount_deposite'] * 7 ) / 100;
		//if ( $rolemaster['amount_deposite'] > 0 ) {
		
			
	?>
    <script>
			$(document).ready(function(){
					$( "#frmPayPal1" ).submit();
			});
			
			</script>       


		
  <form action='<?php echo URL."views/eventbooking?event_id=".$_GET['event'] ?>' method='post' id="frmPayPal1" name='frmPayPal1'>
    <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
    <input type='hidden' name='cmd' value='_xclick'>
    <input type='hidden' name='item_name' value='Event'>
    <input type='hidden' name='item_number' value='1'>
    <input type='hidden' name='amount' id="amount" value="<?php if($rolemaster['amount_deposite'] > 0){echo $rolemaster['amount_deposite'];}?>" >
    <input type='hidden' name='no_shipping' value='1'>
	<input type="hidden" name="tax" value="<?php echo $tax;?>">
    <input type='hidden' name='currency_code' value='USD'>
    <input type='hidden' name='handling' value='0'>
    <input type='hidden' name='cancel_return' value='<?php echo URL."views/eventbooking?type=cancel"; ?>'>
    <input type='hidden' name='return' value='<?php echo URL."views/eventbooking"; ?>'>
    </form>
    <?php
		//} else {
			
		//	redirect(URL.'eventbooking');
		//}
	}
	
	
	}
  ?> 
<?php 
if($rolemaster['event_name'])
{
?>
  
<form method='post' id="new" name='new'>
   
<div class="col-sm-12 col-md-12 col-lg-12 borderbuttom boxshado mt50 mt30 pt20">
<span id="err"></span>
<div class="clear"></div>
<div class="col-sm-7 col-md-7 col-lg-7 mycls">
<h3 class="h3edit"><strong class="coloredit col-md-5">Name Of Event : </strong><div class="col-md-7"><?php echo $rolemaster['event_name'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Type Of Event :</strong><div class="col-md-7"><?php if(!empty($eventtypes)){echo $eventtypes['sName'];}else{echo '---';}?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Who's Sponsoring :</strong><div class="col-md-7">  <?php echo $usermaster['sFirstName'].' '.$usermaster['sLastName'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Date Of Event :</strong><div class="col-md-7"> <?php echo $rolemaster['doe'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Time :</strong> <div class="col-md-7"><?php echo date('h:i A',strtotime($rolemaster['toe']));?></div></h3>
</div>
<div class="col-sm-5 col-md-5 col-lg-5">
<div class="col-sm-5 col-md-5 col-lg-5">
<h3 class="h3edit"><strong class="coloredit">Location :</strong></h3>
</div>
<div class="col-sm-6 col-md-6 col-lg-6">
 <h3 class="h3edit"><?php echo $rolemaster['address_event'].' '.$cities['name'];?>,<?php echo $state['statecode'].' '.$rolemaster['zipcode'];?></h3>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"> 
<h3 class="h3edit"><strong class="coloredit">Price : </strong></h3>
</div>
<div class="col-sm-5 col-md-5 col-lg-5">
<h3 class="h3edit"><?php echo '$'.$rolemaster['amount_deposite'];?></h3>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 text-center">
<?php }
if ( $objsession->get('gs_login_id') > 0) {
?>
<a href="#" class="btn btn-success col-lg-12" data-toggle="modal" data-target="#myModal01">Send Booking</a>
<?php } else {?>
<a style="cursor:pointer;" id="sucfile" class="btn btn-success col-lg-12">Send Booking</a>
<?php }?>
</div>
</div>

</div>
<div class="col-sm-2 col-md-2 col-lg-2">

</div>
</form>
<script>
			$(document).ready(function(){
					$( "#sucfile" ).click(function(){
$('#err').text('Login required for booking event.');
                                        
});
			});
			
			</script> 

</div>
<?php
}
else
{
?>

<?php   $sid_eid1=$_GET['event'];
 $rolemaster1 = array();
	$cond1="iBookingID='".$sid_eid1."'";	
$rolemaster1 = $obj->fetchRow("bookingmaster",$cond1);

$type=$rolemaster1['sType'];

$cond2="iEventID='".$type."'";

$rolemaster2 = $obj->fetchRow("eventtypes",$cond2);

?>

<div class="col-sm-12 col-md-12 col-lg-12">
  <script>
   $('#carousel-example-generic').carousel({
  interval: 3000,
  cycle: true
}); 
  </script>
  <div class="col-sm-12 col-md-12 col-lg-12 mb20">
  	<h3 class="fl" style="color:#8e44ad !important;margin-top:14px;">Bookings</h3>
  </div>  
<style>
.mycls
{
	margin-left: 215px;
}

.siddhant .parmar
{
	display:none !important;
}
.txttitle
{
color: #8e44ad;
    font-size: 20px;
    font-weight: bold;
    padding-top: 20px !important;
}
.btn.btn-success.col-lg-12 {
    background-color: #9c69d0;
    border-color: #9c69d0;
    color: #fff;
    float: right;
    padding-bottom: 10px;
    padding-top: 10px;
    width: 45%;
    margin-right: 285px;
    margin-top: 20px;
}
</style>
	
<?php 
if($rolemaster1['event_name'])
{
?>
  
<form method='post' id="new" name='new'>
   
<div class="col-sm-12 col-md-12 col-lg-12 borderbuttom boxshado mt50 mt30 pt20">
<span id="err"></span>
<div class="clear"></div>
<div class="col-sm-7 col-md-7 col-lg-7 mycls">
<h3 class="h3edit"><strong class="coloredit col-md-5">Name Of Event : </strong><div class="col-md-7"><?php echo $rolemaster1['event_name'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Address Of Event :</strong><div class="col-md-7"><?php echo $rolemaster1['address_event'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Zip Code :</strong> <div class="col-md-7"><?php echo $rolemaster1['zipcode'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Time Of Event :</strong> <div class="col-md-7"><?php echo $rolemaster1['toe'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Event Date :</strong> <div class="col-md-7"><?php echo $rolemaster1['doe'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Event Type :</strong> <div class="col-md-7"><?php echo $rolemaster2['sName'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Booking Artist AS :</strong> <div class="col-md-7"><?php echo $rolemaster1['bookingMe'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Price :</strong> <div class="col-md-7"><?php echo $rolemaster1['amount_deposite'];?></div></h3>
<h3 class="h3edit"><strong class="coloredit col-md-5">Deposit Date :</strong> <div class="col-md-7"><?php echo $rolemaster1['dDepositeDate'];?></div></h3>

</div>
<?php
}
?>

<div class="col-lg-12 col-md-12 col-sm-12 text-center">
<?php 
if ( $objsession->get('gs_login_id') > 0) {
?>
<a href="<?php echo URL;?>views/artistbooking.php" class="btn btn-success col-lg-12">Click Here to Confirm/Decline</a>
<?php } else {?>
<a style="cursor:pointer;" id="sucfile" class="btn btn-success col-lg-12">Click Here to Confirm/Decline</a>
<?php }?>
</div>

</div>
<div class="col-sm-2 col-md-2 col-lg-2">

</div>
</form>
<script>
			$(document).ready(function(){
					$( "#sucfile" ).click(function(){
$('#err').text('Login required for booking event.');
                                        
});
			});
			
			</script> 

</div>
<?php
}
?>
</div>
<div class="clear"></div>
<?php include('../include/footer.php');?>