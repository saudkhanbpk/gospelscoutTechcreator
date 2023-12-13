<?php include('../include/header.php'); ?>
<script>
window.onload = function() {
  getLocation()
};

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
	
	var lat = document.getElementById("latitude");
	var long = document.getElementById("longitude");

    lat.value = position.coords.latitude.toFixed(4);
	long.value = position.coords.longitude.toFixed(4);;
	
}
</script>
  <script>
$(document).ready(function() {
	
	$('#dDoe').datetimepicker({
		//locale: "en-GB",
		format: 'MM-DD-YYYY',		
		//minDate: moment().subtract(1,'d'),
		//ignoreReadonly: true,
		//disabledDates:[moment().subtract(1,'d')],
		
	});	
	$( "#hello" ).click(function() {
		$( "#dDoe" ).focus();
	});
});
</script> 
<?php

$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypal_id='Mona@onshantiinfotech.com';

$giftmaster = $obj->fetchRowAll("eventtypes","isActive = 1 ");

if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}

$countrymaster = $obj->fetchRowAll("countries",'1=1'); 

if ( isset($_GET['eventID'])) {
		$states = $obj->fetchRowAll("states",'1=1'); 
		$cities = $obj->fetchRowAll("cities",'1=1'); 
} else {

	$states = array(); 
	$cities = array(); 
	
}
 
 $event = array();
 $iEventID = 0;
 
 if ( isset($_GET['eventID']) ) {
	 
	 $iEventID = $_GET['eventID'];
	 $event = $obj->fetchRow('eventmaster','e_id = '.$_GET['eventID']);
 }
 
?>

<script>
 $(document).ready(function() { 
$('#countryId').on('change', function (e) {
		
			  $('#stateId').html('');
			  var cntID = $('#countryId').val();
			  e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea.php?type=state&iCountriID='+cntID,
				//data: formData,
				success: function (data) {
				  if(data == 'Please select country'){
					  
					  $('#stateId').html("<option value=''>Select State</option>");
					  $('#cityId').html("<option value=''>Select City</option>");
					  
				  }else{
					 $('#stateId').html(data);
				  }
				}
			  });
		});
		
	
				}); 
	function getCity() {
		
			 // $('#cityId').html('');
			  var stateId = $('#stateId').val();
			  //alert(stateId);
			  //e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea01.php?type=city&iStateID='+stateId,
				//data: formData,
				success: function (data) {
				  if(data == 'Please select state'){
					 $('#cityId').html("<option value=''>Select City</option>");
				  }else{
					 $('#cityId').html(data);
				  }
				}
			  });
		}
</script>
<div class="container">

<h4 class="h4 mb20">Event Details</h4>

  <section id="" class="clearfix">
  <form class="form-horizontal" action="" method="POST" id="myform" enctype="multipart/form-data">
  
    <input type="hidden" name="latitude" id="latitude" value="" />
  <input type="hidden" name="longitude" id="longitude" value="" />
  
    <div class="cslide-slides-container clearfix">
      <div class="cslide-slide">
        
    <fieldset id="account_information" class="">
      <div class="form-group">
        <label for="firstname" class="col-lg-4 control-label">Name of Event<span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sEventName" name="sEventName" value="<?php if(!empty($event)) { echo $event['event_name'];}?>">
        </div>
      </div>
      <div class="form-group">
        <label for="lastname" class="col-lg-4 control-label">Address Of Event<span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sAddress" name="sAddress" value="<?php if(!empty($event)) { echo $event['address_event'];}?>" >
        </div>
      </div>
      <div class="form-group">
        <label for="country" class="col-lg-4 control-label">Event Type </label>
        <div class="col-lg-4">
          <select class="form-control" name="sType" id="sType">
                <option value="">Select event type</option>
                <?php
			if(count($giftmaster) > 0){
				$select = '';
				for($s=0;$s<count($giftmaster);$s++){
					
					if ( !empty($event) && ($giftmaster[$s]['iEventID'] == $event['sType']) ) {
						
						$select = 'selected="selected"';
					} 
			?>
            <option <?php echo $select;?> value="<?php echo $giftmaster[$s]['iEventID'];?>"><?php echo $giftmaster[$s]['sName'];?></option>
            <?php
					$select = '';
				}
			}
			?>
                </select>
        </div>
      </div>
      <div class="form-group">
        <label for="country" class="col-lg-4 control-label">Country</label>
        <div class="col-lg-4">
        	<input type="hidden" id="iCountryID" name="iCountryID" />
          <select name="country" class="form-control countries" id="countryId">
              <option value="">Select Country</option>
              <?php
			if(count($countrymaster) > 0){
				$selectCnt = '';
				for($c=0;$c<count($countrymaster);$c++){
					
					if( !empty($event) && ( $event['country'] == $countrymaster[$c]['id'] )){
						$selectCnt = 'selected="selected"';
					}
			?>
            <option <?php echo $selectCnt;?> value="<?php echo $countrymaster[$c]['id'];?>"><?php echo $countrymaster[$c]['name'];?></option>
            <?php
			$selectCnt = '';
				}
			}
			?>
            </select> 

        </div>
      </div>
      <div class="form-group">
        <label for="state" class="col-lg-4 control-label">State</label>
        <div class="col-lg-4">
        <input type="hidden" id="iStateID" name="iStateID" />
          <select name="state" class="form-control states" id="stateId" onchange="getCity();">
            <option value="">Select State</option>
             <?php
			if(count($states) > 0){
				$selectCnt = '';
				for($c=0;$c<count($states);$c++){
					
					if(!empty($event) && ($event['state'] == $states[$c]['id']) ){
						$selectCnt = 'selected="selected"';
					}
			?>
            <option <?php echo $selectCnt;?> value="<?php echo $states[$c]['id'];?>"><?php echo $states[$c]['name'];?></option>
            <?php
			$selectCnt = '';
				}
			}
			?>
          </select>
        </div>
      </div>
      <div class="form-group">
      <input type="hidden" id="iCityID" name="iCityID" />
        <label for="country" class="col-lg-4 control-label">City</label>
        <div class="col-lg-4" id="cityId">
          <select name="city" class="form-control cities" >
            <option value="">Select City</option>
             <?php
			if(count($cities) > 0){
				$selectCnt = '';
				for($c=0;$c<count($cities);$c++){
					
					if( !empty($event) && ($event['city'] == $cities[$c]['id']) ){
						$selectCnt = 'selected="selected"';
					}
			?>
            <option <?php echo $selectCnt;?> value="<?php echo $cities[$c]['id'];?>"><?php echo $cities[$c]['name'];?></option>
            <?php
			$selectCnt = '';
				}
			}
			?>
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label for="zip" class="col-lg-4 control-label">Zipcode <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="iZipcode" name="iZipcode" value="<?php if(!empty($event)) { echo $event['zipcode'];}?>" >
        </div>
      </div>
      
      <div class="form-group">
        <label for="email" class="col-lg-4 control-label">Date Of Event <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="dDoe" name="dDoe" value="<?php if(!empty($event)) { echo date("m-d-Y",strtotime($event['doe']));}?>">
          <span id="hello"><i class="fa fa-calendar"  aria-hidden="true"></i></span>
        </div>
      </div>
      <div class="form-group">
      
        <label for="email" class="col-lg-4 control-label ">Time Of Event <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control"  id='sTimeOfEvent' name="sTimeOfEvent" value="<?php if(!empty($event)) { echo $event['toe'];}?>">
          <span id="hello01"><i class="fa fa-clock-o"  aria-hidden="true"></i></span>
        </div>
     
      
            
        
        <script type="text/javascript">
            $(function () {
                $('#sTimeOfEvent').datetimepicker({
                    format: 'LT'
                });
				
				$( "#hello01" ).click(function() {
					$( "#sTimeOfEvent" ).focus();
				});
            });
        </script>
 
      </div>
      <div class="form-group">
        <label for="password" class="col-lg-4 control-label">Price<span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sAmountDeposited" name="sAmountDeposited" value="<?php if(!empty($event)) { echo $event['amount_deposite'];}?>">
        </div>
      </div>
    <div class="form-group">
        <label for="lastname" class="col-lg-4 control-label">Description Of Event<span>*</span></label>
        <div class="col-lg-4">
          <textarea class="form-control" id="sDesc" name="sDesc" ><?php if(!empty($event)) { echo $event['sDesc'];}?></textarea>
        </div>
      </div>
          <div class='form-group'>
            <label for="user_image" class="col-lg-4 control-label">Upload Multiple Image<span>*</span></label>
              <div class="col-lg-4">            
            <?php
			if(!empty($event)) {
				$img01 = explode(',',$event['sMultiImage']);
			?>
            <input type="file" accept="image/*" class="form-control file uploadsvideoimage" id="sProfileMore01[]" name="sProfileMore01[]" multiple="multiple" >
            <img src="<?php echo URL;?>upload/event/multiple/<?php echo $img01[0];?>" width="100" height="80" />
            <?php
			}else{
			?>
            <input type="file" accept="image/*" class="form-control file uploadsvideoimage" id="sProfileMore[]" name="sProfileMore[]" multiple="multiple" >
            <?php	
			}
			?>
          </div> </div>
			<script>
				$(document).ready(function(){
					
					$(".uploadsvideoimage").each(function() {
						$(this).rules("add", {
							extension: "png|jpg|jpeg"	,				
							messages: {
								extension : "Upload only PNG | JPG | JPEG image only"
							}
						});
					});
					
				});
				</script>
    
      <div class="form-group">
<div class="col-lg-4 text-right">
  </div>
  <div class="col-lg-4 text-center">
          <p>
            <input type="submit" value="SUBMIT" name="btn_submit" class="btn btn-success">
          </p>
        </div>
  </div>
      
    </fieldset>
    
      </div>
      
     </div>
  </form>
  </section>

  <script type="text/javascript">
	
	
	
$(document).ready(function() {	
			
		$("#myform").validate({

				errorClass: "error",
			errorElement: "span",
				rules: {
					sEventName: {
						required: true,
					},
					sDesc: {
						required: true,
					},
					sAddress: {
						required: true,
					},
					sType: {
						required: true,
						
					},
					country: {
						required: true,
						
					},						
					state: {
						required: true,
						
					},
					city : {
						required: true,
						
					},
					iZipcode: {
						required: true,
					},
					
					dDoe: {
						required: true,
					},
					sTimeOfEvent : {
						required: true,
						
					},
					sAmountDeposited: {
						required: true,
					},
					'sProfileMore[]':	{
						required: true,
					},					
				},
				messages: {
					sEventName: {
						required: "Event Name required",
					},
					sDesc: {
						required: "Description required",
					},
					sAddress: {
						required: "Address required",
					},
					sType: {
						required: "Event Type required",
					},
					country: {
						required: "Country required",
						
					},					
					state : {
						required: "State required",
					},
					city : {
						required: "City required",
					},
					iZipcode: {
						required: "Zipcode required",
						number: 'Only number required',
						minlength: "Minimum 5 degit required",
					},
					dDoe: {
						required: 'Please select Date Of Event',
					},
					sTimeOfEvent : {
						required: "Time Of Event required",
						
					},
					'sProfileMore[]':{
						required: "Image required",
						},
					sAmountDeposited: "Please select valid Amount Deposited",
				},
					submitHandler: function(form) {
					form.submit();}
				
			});
	
		
});
</script>
  
</div>
<?php
if(isset($_POST['btn_submit'])){
	extract($_POST)	;
		$sMultiImage = '';
		
	if( $iEventID > 0) {
		
		if($_FILES["sProfileMore01"]['name'][0] != ''){
		
			for($i=0;$i<count($_FILES["sProfileMore01"]['name']);$i++) {
				
				$randno = rand(0,5000);
				$img = $_FILES["sProfileMore01"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sProfileMore01"]['tmp_name'][$i],"../upload/event/multiple/".$randno.$img);			
				
			}
			
			$img01 = explode(',',$event['sMultiImage']);
			
			foreach ( $img01 as $im){
				deleteImage($im,'upload/event/multiple');
			}
			
			$sMultiImage = rtrim($sMultiImage,',');
		}else{
			$sMultiImage = $event['sMultiImage'];
		}

		$dateList = explode('-',$dDoe);
		$eFullDate = $dateList[2].'-'.$dateList[0].'-'.$dateList[1];
		
		$sponsor = $obj->fetchRow("usermaster",'iLoginID = '.$objsession->get('gs_login_id'));
	
		$field = array("iLoginID","eSponsor","event_name","address_event","sDesc","country","state","city","zipcode","doe","toe","amount_deposite","sMultiImage","sType","dCreatedDate");
		$value = array($objsession->get('gs_login_id'),$sponsor['sFirstName'].' '.$sponsor['sLastName'],$sEventName,$sAddress,$sDesc,$country,$state,$city,$iZipcode,$eFullDate,$sTimeOfEvent,$sAmountDeposited,$sMultiImage,$sType,date("Y-m-d"));		
		$obj->update($field,$value,'e_id = '.$iEventID,"eventmaster");
		
		echo "<script>alert('Event updated successfully.');</script>";
		
	}else{
		
		if($_FILES["sProfileMore"] != ''){
		
			for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
				
				$randno = rand(0,5000);
				$img = $_FILES["sProfileMore"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/event/multiple/".$randno.$img);			
				
			}
			
			$sMultiImage = rtrim($sMultiImage,',');
		}
		
		$dateList = explode('-',$dDoe);
		$eFullDate = $dateList[2].'-'.$dateList[0].'-'.$dateList[1];
		
		$sponsor = $obj->fetchRow("usermaster",'iLoginID = '.$objsession->get('gs_login_id'));
		
		if ( $latitude == "" && $longitude == "" ) {
	
			if (!empty($_SERVER["HTTP_CLIENT_IP"])) {				
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else {
				$ip = $_SERVER["REMOTE_ADDR"];
			}

			$key="9dcde915a1a065fbaf14165f00fcc0461b8d0a6b43889614e8acdb8343e2cf15";
			$url = "http://api.ipinfodb.com/v3/ip-city/?key=$key&ip=$ip&format=xml";
			
			$xml = simplexml_load_file($url);
			
			$latitude  = $xml->children()->latitude;
			$longitude = $xml->children()->longitude;
		}
		
		$field = array("iLoginID","eSponsor","event_name","address_event","sDesc","country","state","city","zipcode","doe","toe","amount_deposite","sMultiImage","sType","dCreatedDate","isActive","sLatitude","sLongitude");
		$value = array($objsession->get('gs_login_id'),$sponsor['sChurchName'],$sEventName,$sAddress,$sDesc,$country,$state,$city,$iZipcode,$eFullDate,$sTimeOfEvent,$sAmountDeposited,$sMultiImage,$sType,date("Y-m-d"),1,$latitude,$longitude);		
		$obj->insert($field,$value,"eventmaster");
		echo "<script>alert('Event added successfully.');</script>";
	}
		
		$objsession->set('gs_total_amount',$sAmountDeposited);
?>
	<?php /*?><script>
			$(document).ready(function(){
					$( "#frmPayPal1" ).submit();
			});
			
			</script>        
    <form action='<?php echo $paypal_url; ?>' method='post' id="frmPayPal1" name='frmPayPal1'>
    <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
    <input type='hidden' name='cmd' value='_xclick'>
    <input type='hidden' name='item_name' value='Event'>
    <input type='hidden' name='item_number' value='1'>
    <input type='hidden' name='amount' id="amount" value="<?php if($objsession->get('gs_total_amount') > 0){echo $objsession->get('gs_total_amount');}?>" >
    <input type='hidden' name='no_shipping' value='1'>
    <input type='hidden' name='currency_code' value='USD'>
    <input type='hidden' name='handling' value='0'>
    <input type='hidden' name='cancel_return' value='<?php echo URL."managebooking?type=cancel"; ?>'>
    <input type='hidden' name='return' value='<?php echo URL."managebooking"; ?>'>
    </form><?php */?>
<?php	
		//$objsession->set('gs_msg','<p>Hello,</p><p>Thanks for the Event Registration.</p><br><p>Thanks,</p><strong>Gospel Team</strong>');			
		redirect(URL.'views/myevents.php');			

}
?>
<?php /*?><script>

$(document).ready(function () {

	$('#countryId').change(function () {
		$("#iCountryID").val($('option:selected', this).attr('countryid'));
	});
	
	$('#stateId').change(function () {
		$("#iStateID").val($('option:selected', this).attr('stateId'));
	});
	
	$('#cityId').change(function () {
		$("#iCityID").val($('option:selected', this).attr('cityId'));
	});
	
});


</script><?php */?> 
