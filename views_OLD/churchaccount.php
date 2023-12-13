<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php';?>

<script type="text/javascript" src="<?php echo URL;?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>js/ckeditor/adapters/jquery.js"></script>
<script>
function InvalidMsg(textbox) {
    
     if(textbox.validity.patternMismatch){
        textbox.setCustomValidity('Please Enter Valid Email Format.');
    }    
    else {
        textbox.setCustomValidity('');
    }
    return true;
}
</script>
<script>
$(document).ready(function() {
	$('#dDob01').datetimepicker({
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		disabledDates:[moment().subtract(1,'d')],
	});	
	
	$('#sFounderName').datetimepicker({
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		disabledDates:[moment().subtract(1,'d')],
	});	
	
	$('#dPayed').datetimepicker({
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		disabledDates:[moment().subtract(1,'d')],
		
	});	
	
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
		
	$('#stateId').on('change', function (e) {
		
			  $('#cityId').html('');
			  var stateId = $('#stateId').val();
			  e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea.php?type=city&iStateID='+stateId,
				//data: formData,
				success: function (data) {
				  if(data == 'Please select state'){
					 $('#cityId').html("<option value=''>Select City</option>");
				  }else{
					 $('#cityId').html(data);
				  }
				}
			  });
		});
});
</script>
<script>

$().ready(function() {
	
	$.validator.addMethod('filesize', function (value, element, param) {
    	return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than 60 mb');

	$(function(){
		$.validator.addMethod('minStrict', function (value, el, param) {
		return value > param;
	});});	
	
		$("#frmProfile").validate({
			ignore: [],  
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {				
				sEmailID: {
					  required:true,
					  email:true,
					},
				sProfileName: {
					extension: "png|jpg|jpeg"
				},
				sFirstName: "required",
				sLastName: "required",				
				sMinistrieName:"required",
				
			},

			messages: {
				sEmailID: {
					  required:"Please enter your email",
					  email:"Polease enter valid email",
					},
				sProfileName: {
					extension: "Upload only png | jpg | jpeg image"
				},
				sFirstName: "Please enter your first name",
				sLastName: "Please enter your last name",				
				sMinistrieName:"Please select ministrie",
			},	
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},			
			submitHandler: function(form) {
			if(form_submit() == true){
					form.submit();
				}
			}

		});
		
		$(".uploadsvideo").each(function() {
			$(this).rules("add", {
				accept: "mp4",
				filesize: 62914560,
				messages: {
					accept: "Only upload mp4 video",
				}
			});
		});
		
		$(".uploadsvideoimage").each(function() {
			$(this).rules("add", {
				extension: "png|jpg|jpeg"	,				
				messages: {
					extension : "Upload only PNG | JPG | JPEG image only"
				}
			});
		});
	
	});
	
function validemail(str){
	var xmlhttp;    
	if (str=="") {
	  	return null;
	}
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    	document.getElementById("error_email").innerHTML=xmlhttp.responseText;
      }
  }
  xmlhttp.open("GET","<?php echo URL; ?>validmail?table=loginmaster&str="+str+"&loginID=<?php echo $objsession->get('log_loginid');?>",true);
  xmlhttp.send();
}

function form_submit(){
	var e = 0;		
	if(document.getElementById('valid_id').value != '')	{
		document.getElementById('valid_info').innerHTML = "";
	}else{
		$("#valid_info").removeClass("suc-msg-forgot");
		if(isEmpty01("valid_id", "You've already registered.", "valid_info")){
			e++;
		}	
	}

	if(e > 0){
		return false;
	}else{
		return true;
	}
}

function isEmpty01(e, t, n){

	var r = document.getElementById(e);
	var n = document.getElementById(n);
	if(r.value.replace(/\s+$/, "") == ""){
		n.innerHTML = t;
		r.value = "";
		r.focus();
		return true
	}else{
		n.innerHTML = "";
		return false
	}
}
</script>
<?php
if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}

$cond = "";
$cond = "iLoginID = ".$objsession->get('gs_login_id');
$userRow = $obj->fetchRow("usermaster",$cond);
$loginRow = $obj->fetchRow("loginmaster","iLoginID = ".$objsession->get('gs_login_id'));

$rolemaster = array();
$rolemaster = $obj->fetchRow("churchministrie",$cond);

$countrymaster = $obj->fetchRowAll("countries",'1=1');

$states = $obj->fetchRowAll("states",'country_id = '.$userRow['sCountryName']);
$cities = $obj->fetchRowAll("cities",'state_id = '.$userRow['sStateName']);

$amenitimaster = $obj->fetchRowAll("amenitimaster","1=1");

$churchtimeing = $obj->fetchRowAll("churchtimeing","iLoginID = ".$objsession->get('gs_login_id'));

?>
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
<?php if($objsession->get('gs_msg') != ""){?>

<div class="newmsm"> <?php echo $objsession->get('gs_msg');?> </div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}
?>
<h4 class="h4">EDIT PROFILE</h4>
<div class="col-md-2"> </div>
<div class="col-md-10">
<form id="frmProfile" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Personal Information</legend>
        <div class='row'>
            <div class='form-group' style="display:none;">
                <label class="col-sm-3" for="user_lastname">User Name</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sUserName" name="sUserName" value="<?php if(!empty($userRow)){echo $userRow['sUserName'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_title">First Name</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sFirstName" name="sFirstName" value="<?php if(!empty($userRow)){echo $userRow['sFirstName'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Last name</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sLastName" name="sLastName" value="<?php if(!empty($userRow)){echo $userRow['sLastName'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Birth Date</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="dDob01" readonly name="dDOB" value="<?php if(!empty($userRow)){echo date("d-m-Y",strtotime($userRow['dDOB']));}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Gender</label>
                <div class='col-sm-4'>
                    <select class="form-control" id="sGender" name="sGender">
                        <option selected value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
        </div>
        <?php /*?><script type="text/javascript">
window.onload = function () {

	if (window.File && window.FileList && window.FileReader)
	{
		
		var filesInput = document.getElementById("sProfileMore");
		filesInput.addEventListener("change", function (event) {
		
		document.getElementById('result').style.display = 'block';	
		document.getElementById("result").innerHTML = '';
		document.getElementById("moreImage").value = '';;
		
		var files = event.target.files; //FileList object
		var output = document.getElementById("result");
		for (var i = 0; i < files.length; i++)
		{
			var file = files[i];
			//Only pics
			if (!file.type.match('image'))
			continue;
			var picReader = new FileReader();
			picReader.addEventListener("load", function (event) {
			
			var picFile = event.target;
			var div = document.createElement("div");
			
			div.innerHTML = "<img  class='thumbnail' src='" + picFile.result + "'" +
			"title='" + picFile.name + "'/>";
			output.insertBefore(div, null);
			
			});
			
			picReader.readAsDataURL(file);
			}
			
			});
	}
	else{
		console.log("Your browser does not support File API");
	}
}
</script><?php */?>
        <?php /*?><div class='row'>
      <div class="form-group">
        <label for="extraimage" class="col-lg-3 control-label">Upload Multiple Images</label>
        <div class="col-lg-4">
          <input type="hidden" id="moreImage" name="moreImage" value="<?php if($userRow['sMultiImage']){ echo $userRow['sMultiImage'];}?>" />
          <input type="hidden" id="moreImage01" name="moreImage01" value="<?php if($userRow['sMultiImage']){ echo $userRow['sMultiImage'];}?>" />
		  <input type="file" class="form-control file" id="sProfileMore" name="sProfileMore[]" multiple="multiple" >
        </div>        
      </div>
      </div><?php */?>
        <?php /*?><div class="form-group">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-4">
        <output id="result" />
        <?php 
		if($userRow['sMultiImage'] != ""){ 
			$multi = explode(",",$userRow['sMultiImage']);
			foreach($multi as $img){
		?>
        <img src="<?php echo URL;?>upload/church/multiple/<?php echo $img;?>" style="margin-left:2px;" class="thumbnail" />
        <?php
			}
		}?>
        </div>
      </div><?php */?>
    </fieldset>
    <fieldset>
        <legend>Church Information</legend>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Name of Church</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sChurchName" name="sChurchName" value="<?php if(!empty($userRow)){echo $userRow['sChurchName'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Name of Pastor</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sPastorName" name="sPastorName" value="<?php if(!empty($userRow)){echo $userRow['sPastorName'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Church Address</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sAddress" name="sAddress" value="<?php if(!empty($userRow)){echo $userRow['sAddress'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Denomination</label>
                <div class='col-sm-4'>
                    <?php
					$soloType = '';
					$soloType1 = '';
					$soloType2 = '';
					$soloType3 = '';
					$groupType = '';
					
					if($userRow['sDenomination'] == 'Church_of_God_and_Christ'){
						$soloType = 'selected';
					}else if($userRow['sDenomination'] == 'Non_denominational'){
						$soloType1 = 'selected';
						
					}else if($userRow['sDenomination'] == 'Baptist'){
						$soloType2 = 'selected';
						
					}else if($userRow['sDenomination'] == 'Pentocostal'){
						$soloType3 = 'selected';
						
					}else if($userRow['sDenomination'] == 'Catholic'){
						$groupType = 'selected';
						
					}else{
						$soloType = '';
						$soloType1 = '';
						$soloType2 = '';
						$soloType3 = '';
						$groupType = '';
					}
					
					?>
                    <select name="denomination" id="selectField" class="form-control">
                    	<option value="">Select Denomination</option>
                        
                        <option <?php if('Anglican' == $userRow['sDenomination']){ echo 'selected';}?> value="Anglican" name="denomination">Anglican</option>
                        <option <?php if('Apostolic' == $userRow['sDenomination']){ echo 'selected';}?> value="Apostolic" name="denomination">Apostolic</option>
                        <option <?php if('Baptist' == $userRow['sDenomination']){ echo 'selected';}?> value="Baptist" name="denomination">Baptist</option>
                        <option <?php if('Catholic' == $userRow['sDenomination']){ echo 'selected';}?> value="Catholic" name="denomination">Catholic</option>
                        <option <?php if('Episcopal' == $userRow['sDenomination']){ echo 'selected';}?> value="Episcopal" name="denomination">Episcopal</option>                
                        <option <?php if('Evangelistic' == $userRow['sDenomination']){ echo 'selected';}?> value="Evangelistic" name="denomination">Evangelistic</option>
                        <option <?php if('Lutheran' == $userRow['sDenomination']){ echo 'selected';}?> value="Lutheran" name="denomination">Lutheran</option>
                        <option <?php if('Methodist' == $userRow['sDenomination']){ echo 'selected';}?> value="Methodist" name="denomination">Methodist</option>
                        <option <?php if('Non_Denominational' == $userRow['sDenomination']){ echo 'selected';}?> value="Non_Denominational" name="denomination">Non-Denominational</option>
                        <option <?php if('Pentecostal' == $userRow['sDenomination']){ echo 'selected';}?> value="Pentecostal" name="denomination">Pentecostal</option>
                        <option <?php if('Presbyterian' == $userRow['sDenomination']){ echo 'selected';}?> value="Presbyterian" name="denomination">Presbyterian</option>
                        <option <?php if('Seventh_Day_Adventist' == $userRow['sDenomination']){ echo 'selected';}?> value="Seventh_Day_Adventist" name="denomination">Seventh Day Adventist</option>
                        <option <?php if('Other' == $userRow['sDenomination']){ echo 'selected';}?> value="Other" name="denomination">Other</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Approx. #No of Members</label>
                <div class='col-sm-4'>
                    <?php
					$member = '';
					$member1 = '';
					$member2 = '';
					$member3 = '';
					$member4 = '';
					$member5 = '';
					
					
					if($userRow['iNumberMembers'] == '100'){
						$member = 'selected';
					}else if($userRow['iNumberMembers'] == '200'){
						$member1 = 'selected';
						
					}else if($userRow['iNumberMembers'] == '300'){
						$member2 = 'selected';
						
					}else if($userRow['iNumberMembers'] == '400'){
						$member3 = 'selected';
						
					}
					else if($userRow['iNumberMembers'] == '500'){
						$member4 = 'selected';
						
					}
					
					else{
						$member5 = 'selected';
					}
					
					?>
                    <select name="ApproxofMembers" class="span2 form-control" id="selectField" aria-invalid="false">
                        <option <?php echo $member5;?> name="ApproxofMembers" value="Less than 50">Less than 50</option>
                        <option <?php echo $member;?> name="ApproxofMembers" value="100">100</option>
                        <option <?php echo $member1;?> name="ApproxofMembers" value="200">200</option>
                        <option <?php echo $member2;?> name="ApproxofMembers" value="300">300</option>
                        <option <?php echo $member3;?> name="ApproxofMembers" value="400">400</option>
                        <option <?php echo $member4;?> name="ApproxofMembers" value="500">500</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Church Website Link</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sChurchUrl" name="sChurchUrl" value="<?php if(!empty($userRow)){echo $userRow['sChurchUrl'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Mission Statement</label>
                <div class='col-sm-4'>
                    <textarea name="sMission" id="sMission" value="<?php if(!empty($userRow)){echo $userRow['sMission'];}?>" class="form-control"><?php if(!empty($userRow)){echo $userRow['sMission'];}?>
					</textarea>
					<script type="text/javascript">
			CKEDITOR.replace( 'sMission', {
				fullPage: false,
				allowedContent: true,
		 });
			
</script>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Church Founder Date</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sFounderName" name="sFounderName" value="<?php if(!empty($userRow)){echo $userRow['sFounderName'];}?>" type="text" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Profile Image</label>
                <div class='col-sm-4'>
                    <input class="form-control file" id="sProfileName" name="sProfileName" value="<?php if(!empty($userRow)){echo $userRow['sProfileName'];}?>" type="file" />
                </div>
                <div class="col-lg-4" id="img"> <img id="blah" class="profileimage" src="<?php echo URL;?>upload/church/<?php echo $userRow['sProfileName'];?>" alt="X" /> </div>
            </div>
        </div>
        
        <div class='row'>
            <div class='form-group'>
                <label for="image" class="col-lg-3 control-label" style="padding-top:0px;">Day</label>
                <div class='col-sm-4'>
                    <a href="javascript:void(0)" name="add_item" class="add_item" id="add_item" style="color:#0033FF;">Add More</a>
                </div>
            </div>
        </div>
        
        <div class='row'>
            <div class='form-group'>
                <label for="image" class="col-lg-3 control-label">Hours of Services</label>
                <div class='col-sm-4'>
                <div id="element_0" >
                <?php
			
			if ( count($churchtimeing) > 0 ) {
				$stNo = 1;
				for ( $st = 0; $st < count($churchtimeing); $st ++ ) {
				
		?>
		<script type="text/javascript">
			$(function () {     
			
				$("#time<?php echo $stNo;?>").val("<?php echo $churchtimeing[$st]['sTitle'];?>");
				   
				$('#sTimeOfEventUpdate<?php echo $stNo;?>').datetimepicker({
					format: 'LT'
				});
			});
        </script>	
        			
								
                                <div id="item_details">
                                <div class="actions mymaindiv">
                                <a class="remove_field"><span class="" style="cursor: pointer;">X</span></a>
          <select id="time<?php echo $stNo;?>" name="sTitle[]" class="span2" style="width:80px;float:left;margin-left: 4px;margin-bottom:10px !important;">
									<option>All days</option>
									<option>Weekend</option>
									<option>Monday</option>
									<option>Tuesday</option>
									<option>Wednesday</option>
									<option>Thursday</option>
									<option>Friday</option>
									<option>Saturday</option>
                                    <option>Sunday</option>
                                </select>
          <input type="text" class="form-control"  id='sTimeOfEventUpdate<?php echo $stNo;?>' name="sTimeOfEvent[]" value="<?php echo $churchtimeing[$st]['iHour'].':'.$churchtimeing[$st]['iMinute']." ".strtoupper($churchtimeing[$st]['ampm']);?>">

    <div style="clear:both"></div>
    </div>
    </div>
    				<?php
					$stNo ++;
				}
					?>
    <div id="new_item_details" class="new_item_details"></div>
   <input type="hidden" value="<?php echo count($churchtimeing);?>" name="totalServises" id="totalServises" />
                <?php
								
			}
		?>
         </div>
                </div>
                
            </div>
        </div>
        
        
    </fieldset>
	<fieldset>
      <legend>Contact Information</legend>
      <div class='row'>
        <div class='form-group'> <span id="error_email">
          <input type="hidden" name="valid_id" id="valid_id" value="valid" />
          </span>
          <label class="col-sm-3" for="user_login">Contact Email</label>
          <div class='col-sm-4'>
            <input class="form-control" id="sContactEmailID" name="sContactEmailID" value="<?php if(!empty($userRow)){echo $userRow['sContactEmailID'];}?>" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter Your Email. Ex.example@gmail.com"/>
            <span class="error_class" id="valid_info"></span> </div>
        </div>
      </div>
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_password">Contact Number</label>
          <div class='col-sm-4'>
            <input class="form-control" id="sContactNumber" name="sContactNumber" type="text" value="<?php if(!empty($userRow)){echo $userRow['sContactNumber'];}?>" pattern="[0-9]{10}" placeholder="Enter Only 10 Digits."/>
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset>
    <fieldset>
        <legend>Login Information</legend>
        <div class='row'>
            <div class='form-group'> <span id="error_email">
                <input type="hidden" name="valid_id" id="valid_id" value="valid" />
                </span>
                <label class="col-sm-3" for="user_login">Email</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sEmailID" readonly="readonly" onkeypress="return validemail(this.value);" onchange="return validemail(this.value);" name="sEmailID" value="<?php if(!empty($loginRow)){echo $loginRow['sEmailID'];}?>" type="text" />
                    <span class="error_class" id="valid_info"></span> </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_password">Password</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="sPassword" name="sPassword" type="password" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_password_confirmation">Confirm Password</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="cPassword01" name="cPassword" type="password" />
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Location</legend>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Country</label>
                <div class='col-sm-4'>
                    <select name="country" class="form-control countries" id="countryId">
                        <option value="">Select Country</option>
                        <?php
			if(count($countrymaster) > 0){
				$selectCnt = '';
				for($c=0;$c<count($countrymaster);$c++){
					if($userRow['sCountryName'] == $countrymaster[$c]['id']){
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
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">State</label>
                <div class='col-sm-4'>
                    <select name="state" class="form-control states" id="stateId">
                        <option value="">Select State</option>
                        <?php
			if(count($states) > 0){
				$select = "";
				for($s=0;$s<count($states);$s++){
					if($userRow['sStateName'] == $states[$s]['id'])
						$select = 'selected="selected"';
			?>
                        <option <?php echo $select;?> value="<?php echo $states[$s]['id'];?>"><?php echo $states[$s]['name'];?></option>
                        <?php
				$select = '';
				}
			}
			?>
                    </select>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">City</label>
                <div class='col-sm-4'>
                    <select name="city" class="form-control cities" id="cityId">
                        <option value="">Select City</option>
                        <?php
			if(count($cities) > 0){
				$select = "";
				for($c=0;$c<count($cities);$c++){
					if($userRow['sCityName'] == $cities[$c]['id'])
						$select = 'selected="selected"';
			?>
                        <option <?php echo $select;?> value="<?php echo $cities[$c]['id'];?>"><?php echo $cities[$c]['name'];?></option>
                        <?php
				$select = '';
				}
			}
			?>
                    </select>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label class="col-sm-3" for="user_firstname">Zipcode</label>
                <div class='col-sm-4'>
                    <input class="form-control" id="iZipcode" name="iZipcode" value="<?php if(!empty($userRow)){echo $userRow['iZipcode'];}?>" type="text" />
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Amenities</legend>

		<div class="form-group">
            <label for="role" class="col-lg-3 control-label"></label>
            <div class="col-lg-4"> <a class="add_field_button" style="cursor:pointer;">Add More Amenities</a> </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label for="mi" class="col-lg-3 control-label">Church Amenities</label>
                <div class="col-lg-4">
          <div class="ChurchScroll ChurchScroll1" style="width: 180px ! important;">
                    <?php
		  $sAmenitis = array(); 
		  if($userRow['sAmenitis'] != ""){
			  $sAmenitis = explode(',',$userRow['sAmenitis']);
		  }
		  ?>
                    <?php
			if(count($amenitimaster) > 0){
				$select = '';
				for($c=0;$c<count($amenitimaster);$c++){
					if(in_array($amenitimaster[$c]['iAmityID'],$sAmenitis)){
						$select = 'checked="checked"';
					}
			?>
                    <label>
                        <input type="checkbox" id="ChurchAminity" <?php echo $select; ?> name="ChurchAminity[]" class="span2" value="<?php echo $amenitimaster[$c]['iAmityID'];?>"/>
                        <?php echo $amenitimaster[$c]['sAmityName'];?></label>
                    <br />
                    <?php
			$select = '';
				}
			}
			?>
                </div>
            </div>
        </div>
        </div>
        <div class="input_fields_wrap">
            <?php
		  $sOtherAmenitis = array(); 
		  if($userRow['sOtherAmenitis'] != ""){
			  $sOtherAmenitis = explode(',',$userRow['sOtherAmenitis']);
			  $n = 1;
		  		foreach($sOtherAmenitis as $oa){
		  ?>
            <div class='row' id="new<?php echo $n;?>">
                <div class="form-group">
                    <label for="role" class="col-lg-3 control-label"></label>
                    <div class="col-lg-4">
                        <input type="text" id="" name="sOtherAmenitis[]" value="<?php echo $oa;?>" class="form-control">
                        <a class="remove_field"  onclick="soloremove01(this)" id="<?php echo $n;?>"><i style="cursor: pointer;" class="fa fa-fw fa-remove"></i></a> </div>
                </div>
            </div>
            <input type="hidden" value="<?php echo count($sOtherAmenitis);?>" id="xval" name="xval" />
            <?php $n ++;}}else{ ?>
            <input type="hidden" value="0" id="xval" name="xval" />
            <?php } ?>
        </div>
        

		<div class='row'>
            <div class="form-group">
                <label for="ye" class="col-lg-3 control-label"></label>     
                <?php if($ch == (count($churchministrie))){?>
                    <a id="AddSolo" class="addmore" style="font-size: 20px;margin-left: 45px;">Add More Videos</a>
                <?php } ?>  
        </div>
        </div>
        <div>
        <?php
	  
	  		$rolemasterAll = array();
			$cond = "iLoginID = ".$objsession->get('gs_login_id');
			$churchministrie = $obj->fetchRowAll("churchministrie",$cond);
			if(!empty($churchministrie)){
				$cnt = 0;
				
		?>
        <input type="hidden" name="churnumber" id="churnumber" value="<?php echo count($churchministrie);?>" />
        <input type="hidden" name="test" id="test" value="" />
        <?php
			
			for($ch=0;$ch<count($churchministrie);$ch++){
		?>
        <input type="hidden" id="iChurchID" name="iChurchID[]" value="<?php echo $churchministrie[$ch]['iChurchID'];?>" />
        <input type="hidden" id="sVideoName" name="sVideoName<?php echo $churchministrie[$ch]['iChurchID'];?>" value="<?php echo $churchministrie[$ch]['sVideoName'];?>" />
        <input type="hidden" id="sVideoNameImage" name="sVideoNameImage<?php echo $churchministrie[$ch]['iChurchID'];?>" value="<?php echo $churchministrie[$ch]['sVideoNameImage'];?>" />
        
        <input type="hidden" id="sVideo" name="sVideo<?php echo $churchministrie[$ch]['iChurchID'];?>" value="<?php echo $churchministrie[$ch]['sVideo'];?>" />
		<input type="hidden" id="youtubeUrl01" name="youtubeUrl01<?php echo $churchministrie[$ch]['iChurchID'];?>" value="<?php echo $churchministrie[$ch]['sUrl'];?>" />
		
        <div id="divsolo1<?php echo $ch;?>">
        <div id="divsolo<?php echo $ch;?>" class="adddiv">
        <input type="hidden" id="hidevideo<?php echo $ch;?>" name="hidevideo<?php echo $ch;?>" value="" />

		<script>
				function pop()
				{
			alert("To Add Videos please Click on Add More Videos and Select Your Ministry");
			window.location.href="<?php echo URL;?>views/churchaccount.php";
				}
		</script>
        <div class='row'>
            <div class="form-group" >
                <label for="mi" class="col-lg-3 control-label">Church Ministries</label>
                <div class="col-lg-4" style="border-bottom:2px solid black;padding:7px;">
                    <select class="form-control" id="sMinistrieName<?php echo $ch;?>" name="sMinistrieName[]" aria-invalid="false" onclick="pop()">
							<?php
				$drop = $obj->fetchRowAll("giftmaster1","isActive = 1");
				if(count($drop) > 0){
				for($c=0;$c<count($drop);$c++){
						$abc=$drop[$c]['sGiftName'];?>
							
								<option <?php if($abc == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';} ?> value="<?php echo $abc;?>"><?php echo $abc;?></option>
							
					
					<?php }
							}
			
					?>		

                    <!--<option value="">Select ministry</option>

                        <option <?php if('Childrens_Ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Childrens_Ministry">Children's Ministry</option> 
                        <option <?php if('Dance_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Dance_ministry">Dance Ministry</option> 
                        <option <?php if('Drama_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Drama_ministry">Drama Ministry</option>
                        <option <?php if('Media_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Media_ministry">Media Ministry</option>
                        <option <?php if('Mime_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Mime_ministry">Mime Ministry</option>
                        <option <?php if('Music_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Music_ministry">Music Ministry</option>
                        <option <?php if('Preaching_Teachings' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Preaching_Teachings">Preaching/Teachings</option>
                        <option <?php if('Sound_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Sound_ministry">Sound Ministry</option>
                        <option <?php if('Youth_ministry' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Youth_ministry">Youth Ministry</option>
                        <option <?php if('Others' == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';}?> value="Others">Others</option>-->
                        
                    </select>
                </div>
                <div class="col-lg-4">
                    <a id="<?php echo $ch;?>" onclick="soloremove1(this)" class="Solo-Remove remove">Remove Ministry</a>
                </div>
            </div>
        </div>
        <div class='row' style="display:none;">
            <div class="form-group">
                <label for="ye" class="col-lg-3 control-label">Upload Ministry Video Image</label>
                <div class="col-lg-4">
                    <input type="file" class="form-control file uploadsvideoimage" accept="image/*" id="sVideoImage" multiple='multiple' name="sVideoImage<?php echo $ch;?>[]" style="pointer-events:none;">
                </div>
            </div>
        </div>
        <div class='row' style="display:none;">
            <div class="form-group">
                <label for="ye" class="col-lg-3 control-label">Upload Ministry Video</label>
                <div class="col-lg-4">
                    <input type="file" class="form-control file uploadsvideo" id="sImage" multiple='multiple' name="sImage<?php echo $ch;?>[]" style="pointer-events:none;">
                </div>
            </div>
        </div>
        <div class='row' style="display:none;">
            <div class="form-group">
                <label for="ye" class="col-lg-3 control-label"></label>
                <div class="col-lg-4" style="border-bottom: 2px solid;padding: 10px;">
                    <input type="text" placeholder="Enter YouTube Link" class="form-control" value="" id="youtube" name="youtube[]" onClick="pop()">
                </div>
				
                <div class="col-lg-4" >
                    
                </div>
            </div>
			
			 
        </div>      
		</div>
        </div>
        
        <?php 
	  $cnt ++ ;
			}
			}else{
		?>
        <input type="hidden" id="iChurchID" name="iChurchID" value="" />
        <input type="hidden" name="test" id="test" value="0" />
        <input type="hidden" name="churnumber" id="churnumber" value="1" />
        <div class='row'>
            <div class="form-group">
                <label for="mi" class="col-lg-3 control-label">Church Ministries</label>
                <div class="col-lg-4">
                    <select class="form-control" id="sMinistrieName" name="sMinistrieName[]" aria-invalid="false" onclick="pop()">
					<option value="select Ministry">Select Ministry</option>
						<?php
				$drop = $obj->fetchRowAll("giftmaster1","isActive = 1");
				if(count($drop) > 0){
				for($c=0;$c<count($drop);$c++){
						$abc=$drop[$c]['sGiftName'];?>
							
								<option <?php if($abc == $churchministrie[$ch]['sMinistrieName']){ echo 'selected';} ?> value="<?php echo $abc;?>"><?php echo $abc;?></option>
							
					
					<?php }
							}
			
					?>		
                    	<!--<option value="">Select ministry</option>
                        <option value="Childrens_Ministry">Children's Ministry</option> 
              <option value="Dance_ministry">Dance Ministry</option> 
              <option value="Drama_ministry">Drama Ministry</option>
              <option value="Media_ministry">Media Ministry</option>
              <option value="Mime_ministry">Mime Ministry</option>
              <option value="Music_ministry">Music Ministry</option>
              <option value="Sound_ministry">Sound Ministry</option>
              <option value="Youth_ministry">Youth Ministry</option>
              <option value="Others">Others</option>-->
                    </select>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label for="ye" class="col-lg-3 control-label">Upload Ministry Video Image</label>
                <div class="col-lg-4">
                    <input type="file" accept="image/*" class="form-control file uploadsvideoimage" id="sVideoImage" multiple="" name="sVideoImage0[]" style="pointer-events:none;">
                </div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group" >
                <label for="ye" class="col-lg-3 control-label">Upload Ministry Video</label>
                <div class="col-lg-4">
                    <input type="file" class="form-control file uploadsvideo" id="sImage" multiple="" name="sImage0[]" style="pointer-events:none;">
                </div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label for="ye" class="col-lg-3 control-label"></label>
                <div class="col-lg-4" style="border-bottom: 2px solid;padding: 10px;">
                    <input type="text" placeholder="Enter YouTube Link" class="form-control" value="" id="youtube" name="youtube[]" onclick="pop()">
				
                </div>
              
            </div>
        </div>
		 
        <?php 	
			}
	  ?>
      
      <div id="solo-New" style="display:none;"> </div>
      </div>
	
        <div class='row'>
			<div class='col-sm-3 mb20'>
			</div>
            <div class='col-sm-4 mb20'>
                <input type="submit" class="form-control" style="background:#9968cf;color:#fff;" name="btn_update" id="btn_update" value="UPDATE" />
            </div>
        </div>
    </fieldset>
</form>
</div>
</div>
<?php
if(isset($_POST['btn_update'])){
	extract($_POST)	;
	
		if($sPassword != ""){		
			$field = array("sPassword");
			$value = array(md5($sPassword));		
			$obj->update($field,$value,"iLoginID = ".$objsession->get('gs_login_id'),"loginmaster");
		}
		
		$userImage = '';
		 					
		if($_FILES["sProfileName"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["sProfileName"]["name"];
			$userImage = $randno.$img;
			deleteImage($userRow['sProfileName'],'upload/church');
			move_uploaded_file($_FILES['sProfileName']['tmp_name'],"../upload/church/".$userImage);			
		}else{
			$userImage = $userRow['sProfileName'];
		}
		
		/*$sMultiImage = '';
		if($moreImage == ''){
			if($_FILES["sProfileMore"] != ''){
			
				for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
					
					$randno = rand(0,5000);
					$img = $_FILES["sProfileMore"]['name'][$i];
					$sMultiImage .= $randno.$img.",";
					
					if($moreImage01 != ""){
						$moreImage01 = explode(',',$moreImage01);
						foreach($moreImage01 as $key){
							deleteImage($key,'upload/church/multiple');
						}
					}
					move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/church/multiple/".$randno.$img);			
					
				}
				
				$sMultiImage = rtrim($sMultiImage,',');
			}
		}else{
			$sMultiImage = $moreImage;
		}*/
						
		if(count($ChurchAminity) > 0){
			$ChurchAminity = implode(',',$ChurchAminity);
		}else{
			$ChurchAminity = '';	
		}

		if(!empty($sOtherAmenitis)){
			$sOtherAmenitis = implode(',',$sOtherAmenitis);
		}else{
			$sOtherAmenitis = '';	
		}
		
		$field = array("sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sChurchName","sPastorName","sAddress","sDenomination","iNumberMembers","sChurchUrl","sMission","sFounderName","sAmenitis","sOtherAmenitis","sGender","sContactNumber","sContactEmailID");
		$value = array($sFirstName,$sLastName,$userImage,$sUserName,date("Y-m-d",strtotime($dDOB)),$country,$state,$city,$iZipcode,$sChurchName,$sPastorName,$sAddress,$denomination,$ApproxofMembers,$sChurchUrl,$sMission,$sFounderName,$ChurchAminity,$sOtherAmenitis,$sGender,$sContactNumber,$sContactEmailID);	
		
		$obj->update($field,$value,"iLoginID = ".$objsession->get('gs_login_id'),"usermaster");
		
		//$sMinistrieName = implode(',',$sMinistrieName);
		//$youtube = implode(',',$youtube);
		$sImage = '';
		$name = '';
		$append = '';
		if($test == 0){
			$churchGift = $sMinistrieName;
		}else{
			//$churchGift = (array_reverse($sMinistrieName));
			$churchGift = $sMinistrieName;
		}


		$cntCount = $churnumber;
			$vNo = 0;
			
			if(count($iChurchID) > 0 && $iChurchID != ""){
				$cntCount1 = $churnumber - count($iChurchID);
			} else {
				$cntCount1 = 0;
			}
			
			if(count($iChurchID) > 0 && $iChurchID != ""){
			
				for($cnt = 0;$cnt<count($iChurchID);$cnt++){
				
//				$cntCount--;
				
				if($churchGift[$cnt] == $_POST['hidevideo'.$cnt]){
					
					$rowOldVideo22 = $obj->fetchRow('churchministrie','iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$_POST['hidevideo'.$cnt]."'");
					
					$vL = explode(',',$rowOldVideo22['sVideo']);
					
					if(!empty($vL)){
						foreach($vL as $k){
							deleteImage($k,'upload/church/video/'.$_POST['hidevideo'.$cnt]);
						}
					}

					$obj->delete("churchministrie",'iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$_POST['hidevideo'.$cnt]."'");	
					
				}else{

				if($_FILES["sImage".$cnt]['name'] != ''){
					
					for($i=0;$i<count($_FILES["sImage".$cnt]['name']);$i++) {
						
						if($_FILES["sImage".$cnt]['name'][$i] != ""){
							
	
						$randno = rand(0,5000);
						$img = $_FILES["sImage".$cnt]['name'][$i];
						$sImage .= $randno.$img.",";
						$name .= $_FILES["sImage".$cnt]['name'][$i].',';
						
						if ( $_FILES["sVideoImage".$cnt]['name'][$i] != "" ) {
							//Upload video images
							$tempVid = explode(".", $_FILES["sImage".$cnt]['name'][$i]);
							$tempImge = explode(".", $_FILES["sVideoImage".$cnt]['name'][$i]);
							//Image name
							$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
						}else {
							$videoCoverImage = ",".$videoCoverImage;
						}
						
						$folderPath =  "../upload/church/video/".$churchGift[$cnt];
						$exist = is_dir($folderPath);
						
						if(!$exist) {
						mkdir("$folderPath");
						chmod("$folderPath", 0755);
						}
						
						move_uploaded_file($_FILES["sImage".$cnt]['tmp_name'][$i],$folderPath."/".$randno.$img);			
						
						if ( $_FILES["sVideoImage".$cnt]['name'][$i] != "" ) {
							move_uploaded_file($_FILES["sVideoImage".$cnt]['tmp_name'][$i],$folderPath."/".$randno.$tempVid[0].'.'.end($tempImge));
						}
						
						if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
							$fld = array('sVideoName','dCreatedDate');
							$val = array($randno.$img,date('Y-m-d'));
							
							$obj->insert($fld,$val,"videouploaddate");
						
						}
					
						}else{
							
							/*$rowOldVideo01 = $obj->fetchRow('churchministrie','iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$churchGift[$cnt]."'");
							
							$sImage = $rowOldVideo01['sVideo'];
							$name = $rowOldVideo01['sVideoName'];
							$videoCoverImage = $rowOldVideo01['sVideoNameImage'];*/
						}
					}
					
					$rowOldVideo = $obj->fetchRow('churchministrie','iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$churchGift[$cnt]."'");
					
					$sImage = rtrim($sImage,',');
					$name = rtrim($name,',');
					$videoCoverImage = rtrim($videoCoverImage,',');
					
					if(!empty($rowOldVideo)){
						
						$sImage .= ','.$rowOldVideo['sVideo'];
						$name .= ','.$rowOldVideo['sVideoName'];
						$videoCoverImage .= ','.$rowOldVideo['sVideoNameImage'];
						
						$sImage = ltrim($sImage,',');
						$name = ltrim($name,',');
						$videoCoverImage = ltrim($videoCoverImage,',');
					
					}
					
					$rowOldVideo = $obj->fetchRow('churchministrie','iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$churchGift[$cnt]."'");
				
					
					if ( $youtube[$cnt] != "") {
							
						$youtubeUrl .= $youtube[$cnt];
						
						if ( $rowOldVideo['sUrl'] != "" ) {  
							$youtubeUrl .= ','.$rowOldVideo['sUrl'];
						
						}
						
					} else {
						$youtubeUrl = $rowOldVideo['sUrl'];
					}
				
						
				}else{

					$sImage = $_POST['sVideo'.$iChurchID[$cnt]];
					$name = $_POST['sVideoName'.$iChurchID[$cnt]];
					$videoCoverImage = $_POST['sVideoNameImage'.$iChurchID[$cnt]];

					
					if ( $youtube[$cnt] != "" ) {
					
						$youtubeUrl .= $youtube[$cnt].','.$_POST['youtubeUrl01'.$iChurchID[$cnt]];
						
					} else {
						
						$youtubeUrl = $_POST['youtubeUrl01'.$iChurchID[$cnt]];
						
					}
				
				}
				
				$sImage = rtrim($sImage,',');
				$name = rtrim($name,',');
					
				$field = array("sMinistrieName","sVideoName","sVideo","sVideoNameImage","sUrl");
				$value = array($churchGift[$cnt],$name,$sImage,$videoCoverImage,$youtubeUrl);		
				$obj->update($field,$value,"iChurchID = ".$iChurchID[$cnt],"churchministrie");
					
				
				}
				
				$sImage = '';
				$name = '';
				$videoCoverImage = '';	
					
				$vNo ++;			
				}
				
				
			}
			
			if($cntCount1 > 0){
			
							
				for($cnt1 = 0;$cnt1 < $cntCount1;$cnt1++){
				
					for($i=0;$i<count($_FILES["sImage".$vNo]['name']);$i++) {
					
					if($_FILES["sImage".$vNo]['name'][$i] != ""){
					
					 $append = 'app';
					 
					$randno = rand(0,5000);
					$img = $_FILES["sImage".$vNo]['name'][$i];
					$sImage .= $randno.$img.",";
					$name .= $_FILES["sImage".$vNo]['name'][$i].',';
					
					if ( $_FILES["sVideoImage".$vNo]['name'][$i] != "" ) {
								
						//Upload video images
						$tempVid = explode(".", $_FILES["sImage".$vNo]['name'][$i]);
						$tempImge = explode(".", $_FILES["sVideoImage".$vNo]['name'][$i]);
						//Image name
						$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
					
					} else {
						$videoCoverImage = ",".$videoCoverImage;
					}
					
					$folderPath =  "../upload/church/video/".$churchGift[$vNo];
					$exist = is_dir($folderPath);
					
					if(!$exist) {
					mkdir("$folderPath");
					chmod("$folderPath", 0755);
					}
					
					move_uploaded_file($_FILES["sImage".$vNo]['tmp_name'][$i],$folderPath."/".$randno.$img);
					
					if ( $_FILES["sVideoImage".$vNo]['name'][$i] != "" ) {
						move_uploaded_file($_FILES["sVideoImage".$vNo]['tmp_name'][$i],$folderPath."/".$randno.$tempVid[0].'.'.end($tempImge));	
					}	

							if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
								$fld = array('sVideoName','dCreatedDate');
								$val = array($randno.$img,date('Y-m-d'));
								
								$obj->insert($fld,$val,"videouploaddate");
								
							}
					
					}
						
					
				}
				
				$sImage = rtrim($sImage,',');
				$name = rtrim($name,',');
				$videoCoverImage = rtrim($videoCoverImage,',');
					
						if($sImage == "" && $name == "" && $videoCoverImage == "" && $youtube[$vNo] == "")
							{
							}
						else
							{
				
					$rowExist = $obj->fetchRow('churchministrie','iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$churchGift[$vNo]."'");		
		
					if (!empty($rowExist)) {
						
						/*if ( $append != "" ) {
							$sImage .= ','.$rowExist['sVideo'];
							$name .= ','.$rowExist['sVideoName'];
							$videoCoverImage .= ','.$rowExist['sVideoNameImage'];	
						} else {
							$sImage = $rowExist['sVideo'];
							$name = $rowExist['sVideoName'];
							$videoCoverImage = $rowExist['sVideoNameImage'];
						}
						*/
						
						
						
						$youtube[$vNo] .= ','.$rowExist['sUrl'];


						if($videoCoverImage != "")
							{
								if($rowExist['sVideoNameImage'] == "")
									{
								$videoCoverImage  = $videoCoverImage;
									}
									else
									{
								$videoCoverImage .= ','.$rowExist['sVideoNameImage'];
									}

						if($rowExist['sVideoName'] == "")
							{
								$name  = $name;
							}
						else
							{
						$name .= ','.$rowExist['sVideoName'];
							}

							if($rowExist['sVideo'] == "")
							{
								$sImage  = $sImage;
							}
						else
							{
						$sImage .= ','.$rowExist['sVideo'];
							}
					}
					else
						{
						$videoCoverImage = $rowExist['sVideoNameImage'];
						$name = $rowExist['sVideoName'];
						$sImage = $rowExist['sVideo'];
						}

						$sImage = ltrim($sImage,',');
						$name = ltrim($name,',');
						$sUrl = ltrim($youtube[$vNo],',');
						
						//$videoCoverImage = ltrim($videoCoverImage,',');
							
					
					
					$field = array("iLoginID","sMinistrieName","sVideoName","sVideo","sVideoNameImage","sUrl","dCreatedDate");
					$value = array($objsession->get('gs_login_id'),$churchGift[$vNo],$name,$sImage,$videoCoverImage,$sUrl,date('Y-m-d'));		
						
						$obj->update($field,$value,'iLoginID = '.$objsession->get('gs_login_id')." AND sMinistrieName = '".$churchGift[$vNo]."'","churchministrie");
						
					} else {
							
					
					$field = array("iLoginID","sMinistrieName","sVideoName","sVideo","sVideoNameImage","sUrl","dCreatedDate");
					$value = array($objsession->get('gs_login_id'),$churchGift[$vNo],$name,$sImage,$videoCoverImage,$youtube[$vNo],date('Y-m-d'));		
						
						$obj->insert($field,$value,"churchministrie");	
						
					}
					
					$append = '';				
					$sImage = '';
					$name = '';	
					$videoCoverImage = '';			
					$vNo ++ ;
				}
			}
			}
				
			//$recent = $obj->fetchRowAll('churchministrie','iLoginID = '.$objsession->get('gs_login_id'));
			

		if($churnumber > 0 && $iChurchID == 0){
			
			
			for($cnt = 0;$cnt<$churnumber;$cnt++){
				
				for($i=0;$i<count($_FILES["sImage".$cnt]['name']);$i++) {
					
					if($_FILES["sImage".$cnt]['name'][$i] != ""){
						
					$randno = rand(0,5000);
					$img = $_FILES["sImage".$cnt]['name'][$i];
					$sImage .= $randno.$img.",";
					$name .= $_FILES["sImage".$cnt]['name'][$i].',';
					
					if ( $_FILES["sVideoImage".$cnt]['name'][$i] != "" ) {
								
						//Upload video images
						$tempVid = explode(".", $_FILES["sImage".$cnt]['name'][$i]);
						$tempImge = explode(".", $_FILES["sVideoImage".$cnt]['name'][$i]);
						//Image name
						$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
					
					} else {
						$videoCoverImage = ",".$videoCoverImage;
					}
					
					$folderPath =  "../upload/church/video/".$_POST['sMinistrieName'][$cnt];
					$exist = is_dir($folderPath);
					
					if(!$exist) {
					mkdir("$folderPath");
					chmod("$folderPath", 0755);
					}
					
					move_uploaded_file($_FILES["sImage".$cnt]['tmp_name'][$i],$folderPath."/".$randno.$img);	
					
					if ( $_FILES["sVideoImage".$cnt]['name'][$i] != "" ) {
						move_uploaded_file($_FILES["sVideoImage".$cnt]['tmp_name'][$i],$folderPath."/".$randno.$tempVid[0].'.'.end($tempImge));	
					}
							
					}
					
					if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
						$fld = array('sVideoName','dCreatedDate');
						$val = array($randno.$img,date('Y-m-d'));
						
						$obj->insert($fld,$val,"videouploaddate");
						
					}
				}
				
				$sImage = rtrim($sImage,',');
				$name = rtrim($name,',');
				$videoCoverImage = rtrim($videoCoverImage,',');
				
				$field = array("iLoginID","sMinistrieName","sVideoName","sVideo","sVideoNameImage","sUrl","dCreatedDate");
				$value = array($objsession->get('gs_login_id'),$sMinistrieName[$cnt],$name,$sImage,$videoCoverImage,$youtube[$cnt],date('Y-m-d'));		
				$obj->insert($field,$value,"churchministrie");	
				
				
				$sImage = '';
				$name = '';
				$videoCoverImage = '';
			
		}
		
		}
		
		$cnt02 = count($_POST['sTimeOfEvent']);
		
		if($cnt02 > 0){
			
			$obj->delete('churchtimeing',"iLoginID = ".$objsession->get('gs_login_id'));
			
			$n = 0;
			for($no=1;$no<=$cnt02;$no++){
					
				$serviceHourList = explode(':',$_POST['sTimeOfEvent'][$n]);
				$iHour = $serviceHourList[0];
				$serviceHourList2 = explode(' ',$serviceHourList[1]);
				$iMinute = $serviceHourList2[0];	
				$ampm = $serviceHourList2[1];
		
				$field = array("iLoginID","sTitle","iHour","iMinute","ampm","isActive");
				$value = array($objsession->get('gs_login_id'),$sTitle[$n],$iHour,$iMinute,$ampm,1);		
				$obj->insert($field,$value,"churchtimeing");
				$n ++;
			}
		}

		$objsession->set('gs_msg','<p>Profile Updates Successfully</p>');
		redirect(URL.'views/churchaccount.php');			
	
}
?>
<script>
$(document).ready(function () {

	$('#selectField').change(function () {
		
		$('#solo').hide();
			$('#group').hide();
		
		if($(this).val() == 'solo'){
			$('#solo').show();
			$('#group').hide();
		}
		
		if($(this).val() == 'group'){
			$('#solo').hide();
			$('#group').show();
		}
	});
	
});


function loadText(nolist){
	
	var max_fields      = 500; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap01"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
   var x = nolist;
   $(wrapper).html('');
for(var i=1;i<=x;i++)
{


            $(wrapper).append('<div class="row"><div class="form-group"><label for="mname" class="col-lg-3 control-label">Member Name</label><div class="col-lg-4"><input class="form-control" type="text" class="" name="membername[]" id="" /></div></div></div><div class="row"><div class="form-group"><label for="role" class="col-lg-3 control-label">Member Gift</label><div class="col-lg-4"><select name="mygift[]" class="form-control mt10"><option selected="selected">Select Gift</option><option value="bassplayers">bass players</option><option value="Dancers">Dancers</option><option value="Drummers">Drummers</option><option value="Flute">Flute</option><option value="Guitarists">Guitarists</option><option value="Horn players">Horn players</option><option value="Saxophone">Saxophone</option><option value="Trombone">Trombone</option><option value="Trumpet">Trumpet</option><option value="Keys">Keys</option><option value="Mime">Mime</option><option value="Percussions">Percussions</option><option value="Singers">Singers</option><option value="Violin">Violin</option></select></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Upload Videos form youtube</label><div class="col-lg-4"><input class="form-control" type="text" class="" name="youtube[]" id="" /></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Upload image for gift</label><div class="col-lg-4"><input class="form-control file" type="file" name="giftImage[]" id="" /></div></div></div>'); //add input box

		//document.getElementById("xval").value = x;
}

	$("input[type=file]").each(function() {
		$(this).rules("add", {
			accept: "png|jpg|jpeg",
			messages: {
				accept: "Only jpeg, jpg or png images"
			}
		});
	});
		
}
</script> 
<script>

function soloremove01(obj)
{

var objId= obj.id.toString();
$("#new"+objId).remove();
	}
	
$(document).ready(function() {
	
var max_fields      = 50; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = document.getElementById("xval").value; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row" id="new'+x+'"><div class="form-group" ><label for="mname" class="col-lg-3 control-label"></label><div class="col-lg-4"><input class="form-control" type="text" class="" name="sOtherAmenitis[]" id="" /><a id="'+x+'" onclick="soloremove01(this)" class="remove_field"><i style="cursor: pointer;" class="fa fa-fw fa-remove"></i></a></div></div></div>'); //add input box
        }
		
		document.getElementById("xval").value = x;
			
    });
	
//var dynamicid = document.getElementById('ext').value;

});
</script> 
<script>

$(document).ready(function() {
	
	$('.serviceRemove01').click(function(e){
		$(this).closest(".mymaindiv").remove();
	});

var max_fields01      = 9; //maximum input boxes allowed

    var wrapper01         = $(".new_item_details"); //Fields wrapper
    var add_button01      = $(".add_item"); //Add button ID
   
    var x1 = $('#totalServises').val() //initlal text box count
    $(add_button01).click(function(e){ //on add input button click
        e.preventDefault();
        if(x1 < max_fields01){ //max input box allowed
            x1++; //text box increment
			
			var txt = '<div class="actions mymaindiv"><a id="'+x1+'"  class="remove_field"><span class="serviceRemove">X</span></a><select id="time" name="sTitle[]" class="span2" style="width:80px;float:left;margin-left: 4px;margin-bottom:10px !important"><option>All days</option><option>Weekend</option><option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option><option>Saturday</option><option>Sunday</option></select><input type="text" class="form-control"  id="sTimeOfEvent'+x1+'" name="sTimeOfEvent[]"></div>';

            $(wrapper01).append(txt); //add input box
        }
		
//		document.getElementById("xval").value = x;

$('.serviceRemove').click(function(e){
	$(this).closest(".mymaindiv").remove();
	x1 --;
});

$('#sTimeOfEvent2').datetimepicker({
                    format: 'LT'
                });
				$('#sTimeOfEvent3').datetimepicker({
                    format: 'LT'
                });
				
				$('#sTimeOfEvent4').datetimepicker({
                    format: 'LT'
                });
				
				$('#sTimeOfEvent5').datetimepicker({
                    format: 'LT'
                });
				
				$('#sTimeOfEvent6').datetimepicker({
                    format: 'LT'
                });
				$('#sTimeOfEvent7').datetimepicker({
                    format: 'LT'
                });
				
				$('#sTimeOfEvent8').datetimepicker({
                    format: 'LT'
                });
				
				$('#sTimeOfEvent9').datetimepicker({
                    format: 'LT'
                });
			
    });

	
var dynamicid=1;

$('#AddSolo').click(function() {


var v = 0;
	
$(".adddiv").each(function() {
	v =	$(this).attr('id');
});

	dynamicid = (v.match(/\d+/));
	dynamicid ++;
	
document.getElementById('test').value = dynamicid;

if(document.getElementById('churnumber').value > 0){
	//dynamicid = document.getElementById('churnumber').value;
}
//document.getElementById('churnumber').value = (dynamicid + 1)

var data = '<div style="border: 1px solid black;float:left">';
data += '<div id="divsolo'+dynamicid+'" class="adddiv">';
data +=           '<div class="row"><div class="form-group">';
data +=           '             <label for="role" class="col-lg-3 control-label">Church Ministries</label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <select id="sMinistrieName" class="form-control" name="sMinistrieName[]"  >';

						<?php
									$drop = $obj->fetchRowAll("giftmaster1","isActive = 1");
								if(count($drop) > 0){
								for($c=0;$c<count($drop);$c++){
								$abc=$drop[$c]['sGiftName'];?>
data +=           '				  <option value="<?php echo $abc;?>"><?php echo $abc;?></option>';
										<?php }
							}
			
					?>
data +=           '              </select>';
data +=           '            </div>';
data +=           '        </div></div>';
data +=           '  <div class="row">';
data +=           '<div class="form-group">';
data +=           '<label for="ye" class="col-lg-3 control-label">Upload Ministry Video Image</label>';
data +=           '<div class="col-lg-4">';
data +=           '<input type="file" class="form-control file uploadsvideoimage" id="sVideoImage" accept="image/*" multiple="" name="sVideoImage'+dynamicid+'[]" >';
data +=           '</div>';
data +=           '</div>';
data +=           '</div>';
data +=           '        <div class="row"><div class="form-group">';
data +=           '            <label for="role" class="col-lg-3 control-label">Upload Ministry Video</label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="file" name="sImage'+dynamicid+'[]" multiple="" class="form-control uploadsvideo file" />';
data +=           '            </div>';
data +=           '          </div></div>';
data +=           '          <div class="row"><div class="form-group">';
data +=           '            <label for="role" class="col-lg-3 control-label"></label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="text" name="youtube[]"  placeholder="Enter YouTube Link" class="form-control" />';
data +=           '            </div>';
data +=           '            <div class="col-lg-4">';
data +=           '               <a class="Solo-Remove remove" onclick="soloremove(this)" id="'+dynamicid+'">Remove Ministry</a>';
data +=           '            </div>';
data +=           '          </div>';
data +=           '        </div></div></div>';
	
	$('#solo-New').append(data);
	$('#solo-New').show();
//	dynamicid ++;
	
	
	
	
	document.getElementById('churnumber').value = dynamicid + 1 ;
	
	$.validator.addMethod('filesize', function (value, element, param) {
    	return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than 60 mb');
	
	$(".uploadsvideo").each(function() {
		$(this).rules("add", {
			accept: "mp4",
			filesize: 62914560,
			messages: {
				accept: "Only upload mp4 video"
			}
		});
	});
	
	$(".uploadsvideoimage").each(function() {
			$(this).rules("add", {
				extension: "png|jpg|jpeg"	,				
				messages: {
					extension : "Upload only PNG | JPG | JPEG image only"
				}
			});
		});
		
});

});
function soloremove(obj)
{
if(confirm('Are you sure want to delete ?'))
{

var x = document.getElementById('churnumber').value;
var t = document.getElementById('test').value;
document.getElementById('churnumber').value = (x - 1);

document.getElementById('test').value = (t - 1);

var objId= obj.id.toString();
$("#divsolo"+objId).remove();
	}
}
	
function soloremove1(obj)
{
	/*var no = $("#churnumber").val();

	if(no != 0){
		
		$("#churnumber").val(no - 1);	
	}*/
	if(confirm('Are you sure want to delete ?'))
{
	var objId= obj.id.toString();
//	$("#divsolo1"+objId).remove();
	$("#divsolo1"+objId).css('display','none');
	$("#hidevideo"+objId).val($('#sMinistrieName'+objId).val());
}
}
</script>


<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>
