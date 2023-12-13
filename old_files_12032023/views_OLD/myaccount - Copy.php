
<?php include('../include/header.php');?>
<script>
$(document).ready(function() {
	$('#dDob01').datetimepicker({
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		disabledDates:[moment().subtract(1,'d')],
	});	
	
	$('#dPayed').datetimepicker({
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		disabledDates:[moment().subtract(1,'d')],
		
	});	
});
</script>
<script>

$().ready(function() {
	
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
				sFirstName: "required",
				sLastName: "required",
				sAddress: "required",				
				sContactNumber01: {
					  required:true,
					  number:true,
					},
				sContactNumber: {
					  required:true,
					  number:true,
					},
				sCompanyName: "required",
				sAddress01: "required",
				sCompanyEmailID: {
					  required:true,
					  email:true,
					},
				sBankName: "required",
				sBranchName: "required",
				sNumber: "required",
				cPassword:{
					equalTo: "#sPassword",
				},
				sImage:{
					extension: "png|jpeg|jpg",
				},
				
			},

			messages: {
				sEmailID: {
					  required:"Please enter your email",
					  email:"Polease enter valid email",
					},
				sFirstName: "Please enter your first name",
				sLastName: "Please enter your last name",
				sAddress: "Please enter your address",	
				sContactNumber01: {
					  required:"Please enter your company contact number",
					  number:"Please enter only number",
					},
				sContactNumber: {
					  required:"Please enter your contact number",
					  number:"Please enter only number",
					},
				sCompanyName: "Please enter your company name",
				sAddress01: "Please enter your company details",
				sCompanyEmailID: {
					  required:"Please enter your company email",
					  email:"Please enter valid email",
					},
				sBankName: "Please enter your bank name",
				sBranchName: "Please enter your branch name",
				sNumber: "Please enter cheque or dd number",
				cPassword:{
					equalTo: "Please enter confirm password same as password",
				},
				sImage:{
					extension: "Please upload valid image",
				},
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
$rolemaster = $obj->fetchRow("rollmaster",$cond);

?>
<?php if($objsession->get('gs_msg') != ""){?>

<div class="suc-message"> <?php echo $objsession->get('gs_msg');?> </div>
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
        <div class='form-group'>
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
          <label class="col-sm-3" for="user_firstname">Profile Image</label>
          <div class='col-sm-4'>
            <input class="form-control file" id="sProfileName" name="sProfileName" value="<?php if(!empty($userRow)){echo $userRow['sProfileName'];}?>" type="file" />
          </div>
          <div class="col-lg-4" id="img"> <img id="blah" class="profileimage" src="<?php echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];?>" alt="X" /> </div>
        </div>
      </div>
    </fieldset>
    <fieldset>
      <legend>Login Information</legend>
      <div class='row'>
        <div class='form-group'> <span id="error_email">
          <input type="hidden" name="valid_id" id="valid_id" value="valid" />
          </span>
          <label class="col-sm-3" for="user_login">Email</label>
          <div class='col-sm-4'>
            <input class="form-control" id="sEmailID" onkeypress="return validemail(this.value);" onchange="return validemail(this.value);" name="sEmailID" value="<?php if(!empty($loginRow)){echo $loginRow['sEmailID'];}?>" type="text" />
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
            <input class="form-control" id="cPassword" name="cPassword" type="password" />
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset>
      <legend>Location</legend>
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
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_firstname">Country</label>
          <div class='col-sm-4'>
            <select name="country" class="form-control countries" id="countryId">
              <option value="">Select Country</option>
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
      <legend>Talent Section</legend>
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_firstname">Role</label>
          <div class='col-sm-4'>
            <?php
					$soloType = '';
					$groupType = '';
					
					if($rolemaster['sGroupType'] == 'solo'){
						$soloType = 'selected';
					}
					if($rolemaster['sGroupType'] == 'group'){
						$groupType = 'selected';
					}
					
					?>
            <select id="selectField" name="roll" class="form-control" >
              <option id="selectroll" value="selectroll" selected>Select Roll</option>
              <option <?php echo $soloType;?> value="solo" >Solo</option>
              <option <?php echo $groupType;?> value="group" >Group</option>
            </select>
          </div>
        </div>
      </div>
      <div id="solo" <?php if($rolemaster['sGroupType'] != 'solo'){?>style="display:none;"<?php } ?>>
        <div id="solo-New" <?php if(!empty($rolemaster) && $rolemaster['sGroupType'] != 'solo'){?>style="display:none;"<?php } ?>>
          <?php
			
			$rolemasterAll = array();
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'solo'";
			$rolemasterAll = $obj->fetchRowALl("rollmaster",$cond);
			$end = 1;
			if(!empty($rolemasterAll)){
				$iRollID = '';
				for($i=0;$i<count($rolemasterAll);$i++){
					$iRollID .= $rolemasterAll[$i]['iRollID'].',';
			?>
          <input type="hidden" name="iRollID" id="iRollID" value="<?php echo rtrim($iRollID,',');?>" />
          <input type="hidden" name="extrImage<?php echo $rolemasterAll[$i]['iRollID'];?>" id="extrImage<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sImage'];?>">
          
          <input type="hidden" name="extrVideo<?php echo $rolemasterAll[$i]['iRollID'];?>" id="extrVideo<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sVideo'];?>">
          
          <script>
setTimeout(function() { 
	$('#sGift<?php echo $rolemasterAll[$i]['iRollID'];?>').find('option[value=<?php echo $rolemasterAll[$i]['sGiftName'];?>]').attr('selected','selected');
},200);
</script>
          <div id="divsolo<?php echo $i;?>">
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">My Gift</label>
                <div class="col-lg-4">
                  <select class="form-control" id="sGift<?php echo $rolemasterAll[$i]['iRollID'];?>" name="sGift<?php echo $rolemasterAll[$i]['iRollID'];?>" >
                    <option value="bassplayers">bass players</option>
                    <option value="Dancers">Dancers</option>
                    <option value="Drummers">Drummers</option>
                    <option value="Flute">Flute</option>
                    <option value="Guitarists">Guitarists</option>
                    <option value="Horn players">Horn players</option>
                    <option value="Saxophone">Saxophone</option>
                    <option value="Trombone">Trombone</option>
                    <option value="Trumpet">Trumpet</option>
                    <option value="Keys">Keys</option>
                    <option value="Mime">Mime</option>
                    <option value="Percussions">Percussions</option>
                    <option value="Singers">Singers</option>
                    <option value="Violin">Violin</option>
                  </select>
                </div>
                <div class="col-lg-4"> <a class="Solo-Remove remove" onclick="soloremove(this)" id="<?php echo $i;?>">Remove</a> </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Gift Image</label>
                <div class="col-lg-4">
                  <input type="file" name="giftImg<?php echo $rolemasterAll[$i]['iRollID'];?>" class="form-control file"/>
                </div>
                <div class="col-lg-4" id="img">
                <?php if($rolemasterAll[$i]['sImage'] != ""){?><img id="blah" class="profileimage" src="<?php echo URL;?>upload/artist/<?php echo $rolemasterAll[$i]['sGiftName'];?>/<?php echo $rolemasterAll[$i]['sImage'];?>" alt="X" /> 
                <?php } ?>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Gift Video</label>
                <div class="col-lg-4">
                  <input type="file" accept="video/*" name="giftVid<?php echo $rolemasterAll[$i]['iRollID'];?>" class="form-control file"/>
                </div>
                
                <div class="col-lg-4" id="img">
                <?php if($rolemasterAll[$i]['sVideo'] != ""){?>
                
            
                <?php /*?><video src="<?php echo URL;?>upload/church/<?php echo $rolemasterAll[$i]['sGiftName'];?>/<?php echo $rolemasterAll[$i]['sVideo'];?>"></video><?php */?>
                
                                
                <?php } ?>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label"></label>
                <div class="col-lg-4">
                  <input type="text" name="yt<?php echo $rolemasterAll[$i]['iRollID'];?>" class="form-control" value="<?php if(!empty($rolemaster)){echo $rolemaster['sYoutubeUrl'];}?>" placeholder="Enter only youtube url" />
                </div>
                <?php if($end == count($rolemasterAll)){?>
                <div class="col-lg-4"> <a id="AddSolo" class="addmore">Add More Gift</a> </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php
		   			$end ++;
		   		}
			}
			else{
			?>
            <input type="hidden" name="iRollID" id="iRollID" value="" />
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">My Gift</label>
                <div class="col-lg-4">
                  <select class="form-control" id="sGiftName" name="sGiftName[]" >
                    <option value="bassplayers">bass players</option>
                    <option value="Dancers">Dancers</option>
                    <option value="Drummers">Drummers</option>
                    <option value="Flute">Flute</option>
                    <option value="Guitarists">Guitarists</option>
                    <option value="Horn players">Horn players</option>
                    <option value="Saxophone">Saxophone</option>
                    <option value="Trombone">Trombone</option>
                    <option value="Trumpet">Trumpet</option>
                    <option value="Keys">Keys</option>
                    <option value="Mime">Mime</option>
                    <option value="Percussions">Percussions</option>
                    <option value="Singers">Singers</option>
                    <option value="Violin">Violin</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Gift Image</label>
                <div class="col-lg-4">
                  <input type="file" accept="image/*" name="giftImage[]" class="form-control file"/>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Gift Video</label>
                <div class="col-lg-4">
                  <input type="file" accept="video/*" name="giftVideo[]" class="form-control file"/>
                </div>
                
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label"></label>
                <div class="col-lg-4">
                  <input type="text" name="youtube[]" class="form-control" value="" placeholder="Enter only youtube url" />
                </div>                
                <div class="col-lg-4"> <a id="AddSolo" class="addmore">Add More Gift</a> </div>
              </div>
            </div>
            <?php	
			}
			?>
          <input type="hidden" name="ext" id="ext" value="<?php echo $end;?>">
        </div>
      </div>
      <div id="group" <?php if($rolemaster['sGroupType'] != 'group'){?>style="display:none;"<?php } ?>>
        <div class='row'>
          <div class="form-group">
            <label for="person" class="col-lg-3 control-label">Select Number of Person</label>
            <div class="col-lg-4">
              <select id="id_of_select1" name="iNumberMembers" class="form-control" onChange="loadText(this.value);" >
                <option value="">Select number of person</option>
                <?php 
					$selectNum = '';
					for($i=1;$i<=100;$i++){
						if($i == $rolemaster['iNumberMembers']){
							$selectNum = 'selected';
						}
						
					?>
                <option <?php echo $selectNum;?> value="<?php echo $i;?>"><?php echo $i;?></option>
                <?php $selectNum = '';} ?>
              </select>
            </div>
          </div>
        </div>
        <div class='row'>
          <div class="form-group">
            <label for="extraimage" class="col-lg-3 control-label">Group Name</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" value="<?php echo $rolemaster['sGropName'];?>" id="sGroupName" name="sGroupName"  >
            </div>
          </div>
        </div>
        
        <div class="input_fields_wrap01" >       
         <?php
			
			$rolemasterAll = array();
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'group'";
			$rolemasterAll = $obj->fetchRowALl("rollmaster",$cond);
			$end = 1;
			if(!empty($rolemasterAll)){
				$iRollID = '';
				for($i=0;$i<count($rolemasterAll);$i++){
					$iRollID .= $rolemasterAll[$i]['iRollID'].',';
			?>
          <input type="hidden" name="iRollIDGrp" id="iRollIDGrp" value="<?php echo rtrim($iRollID,',');?>" />
          <input type="hidden" name="extrImageGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" id="extrImageGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sImage'];?>">
          
          <input type="hidden" name="extrVideoGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" id="extrVideoGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sVideo'];?>">
          
          <div class="row">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="mname">Member Name</label>
              <div class="col-lg-4">
                <input type="text" id="" name="membe<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sMemberName'];?>" class="form-control">
              </div>
            </div>
          </div>
          
          <script>
setTimeout(function() { 
	$('#sGiftGrp<?php echo $rolemasterAll[$i]['iRollID'];?>').find('option[value=<?php echo $rolemasterAll[$i]['sGiftName'];?>]').attr('selected','selected');
},200);
</script>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">My Gift</label>
                <div class="col-lg-4">
                  <select class="form-control" id="sGiftGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" name="sGiftGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" >
                    <option value="bassplayers">bass players</option>
                    <option value="Dancers">Dancers</option>
                    <option value="Drummers">Drummers</option>
                    <option value="Flute">Flute</option>
                    <option value="Guitarists">Guitarists</option>
                    <option value="Horn players">Horn players</option>
                    <option value="Saxophone">Saxophone</option>
                    <option value="Trombone">Trombone</option>
                    <option value="Trumpet">Trumpet</option>
                    <option value="Keys">Keys</option>
                    <option value="Mime">Mime</option>
                    <option value="Percussions">Percussions</option>
                    <option value="Singers">Singers</option>
                    <option value="Violin">Violin</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Gift Image</label>
                <div class="col-lg-4">
                  <input type="file" name="giftImgGrp<?php echo $rolemasterAll[$i]['iRollID'];?>[]" multiple="multiple" class="form-control file"/>
                </div>
                <div class="col-lg-4" id="img">
                <?php if($rolemasterAll[$i]['sImage'] != ""){
					$img = explode(',',$rolemasterAll[$i]['sImage'])	;
				?><img id="blah" class="profileimage" src="<?php echo URL;?>upload/artist/<?php echo $rolemasterAll[$i]['sGiftName'];?>/<?php echo $img[0];?>" alt="X" /> 
                <?php } ?>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Gift Video</label>
                <div class="col-lg-4">
                  <input type="file" accept="video/*" name="giftVidGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" class="form-control file"/>
                </div>
                
                <div class="col-lg-4" id="img">
                <?php if($rolemasterAll[$i]['sVideo'] != ""){?>
                
            
                <?php /*?><video src="<?php echo URL;?>upload/church/<?php echo $rolemasterAll[$i]['sGiftName'];?>/<?php echo $rolemasterAll[$i]['sVideo'];?>"></video><?php */?>
                
                                
                <?php } ?>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label"></label>
                <div class="col-lg-4">
                  <input type="text" name="ytGrp<?php echo $rolemasterAll[$i]['iRollID'];?>" class="form-control" value="<?php if(!empty($rolemasterAll)){echo $rolemasterAll[$i]['sYoutubeUrl'];}?>" placeholder="Enter only youtube url" />
                </div>
              </div>
            </div>
          <?php
		   			$end ++;
		   		}
			}
			else{
			?>
            <input type="hidden" name="iRollIDGrp" id="iRollIDGrp" value="" />
            
            <?php	
			}
			?>
          <input type="hidden" name="ext" id="ext" value="<?php echo $end;?>">
        </div>
      </div>
    </fieldset>
    <fieldset>
      <legend>About</legend>
      <div class='row'>
        <div class="form-group">
          <label for="Availability" class="col-lg-3 control-label">Availability </label>
          <div class="col-lg-4"> 
            <script>
setTimeout(function() { 
	$('#availability').find('option[value=<?php echo $userRow['sAvailability'];?>]').attr('selected','selected');
},100);
</script>
            <select name="availability" id="availability" class="form-control" >
              <option value="">Select Availability</option>
              <option value="currently_gigging">Currently Gigging(Not excepting new gigs)</option>
              <option value="looking_for_gigs">Looking For Gigs(Currently excepting new gigs)</option>
              <option value="will_play_for_food">Will Play for Food (Just Cover my cost to get there and back)</option>
              <option value="will_play_for_free">Will Play for Free </option>
            </select>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">Years Of Experience</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" id="iYear" value="<?php if(!empty($userRow)){echo $userRow['iYearOfExp'];}?>" name="iYear" >
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">How long they have playing</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" value="<?php if(!empty($userRow) && $userRow['dHowLongPlay'] != ""){echo date("d-m-Y",strtotime($userRow['dHowLongPlay']));}?>" id="dPayed" name="dPayed" >
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="mi" class="col-lg-3 control-label">Musical Influences</label>
          <div class="col-lg-4">
          <?php
		  $sMusicalInstrument = array(); 
		  if($userRow['sMusicalInstrument'] != ""){
			  $sMusicalInstrument = explode(',',$userRow['sMusicalInstrument']);
		  }
		  ?>
            <select name="musicalinfluences[]" class="form-control" multiple="multiple">
              <option <?php if(in_array('bass_player',$sMusicalInstrument)){ echo 'selected';}?> value="bass_player">Bass Player</option>
              <option <?php if(in_array('Dancer',$sMusicalInstrument)){ echo 'selected';}?> value="Dancer">Dancer</option>
              <option <?php if(in_array('Drummer',$sMusicalInstrument)){ echo 'selected';}?> value="Drummer">Drummer</option>
              <option <?php if(in_array('Flute',$sMusicalInstrument)){ echo 'selected';}?> value="Flute">Flute</option>
              <option <?php if(in_array('Guitarist',$sMusicalInstrument)){ echo 'selected';}?> value="Guitarist">Guitarist</option>
              <option <?php if(in_array('Keys',$sMusicalInstrument)){ echo 'selected';}?> value="Keys">Keys</option>
              <option <?php if(in_array('Mime',$sMusicalInstrument)){ echo 'selected';}?> value="Mime">Mime</option>
            </select>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">What Kind of Music They Play</label>
          <div class="col-lg-4">
          <?php
		  $sKindPlay = array(); 
		  if($userRow['sKindPlay'] != ""){
			  $sKindPlay = explode(',',$userRow['sKindPlay']);
		  }
		  ?>
            <select name="whatkindofmusic[]" multiple="multiple" class="form-control">             
              <option <?php if(in_array('Rock',$sKindPlay)){ echo 'selected';}?> value="Rock">Rock</option>
              <option <?php if(in_array('Jazz',$sKindPlay)){ echo 'selected';}?> value="Jazz">Jazz</option>
              <option <?php if(in_array('Flute',$sKindPlay)){ echo 'selected';}?> value="Flute">Flute</option>
              <option <?php if(in_array('pop',$sKindPlay)){ echo 'selected';}?> value="pop">pop</option>
            </select>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">Who they have Played for</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" id="sPlayedFor" value="<?php if(!empty($userRow)){echo $userRow['sPlayedFor'];}?>" name="sPlayedFor" >
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="pf" class="col-lg-3 control-label">Where they Have Played</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" value="<?php if(!empty($userRow)){echo $userRow['sHavePlayed'];}?>" id="sWherePlayed" name="sWherePlayed" >
          </div>
        </div>
      </div>
      <div class='row'>
        <div class='col-sm-12 mb20'>
          <input type="submit" class="form-control" name="btn_update" id="btn_update" value="UPDATE" />
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
			$obj->update($field,$values,"iLoginID = ".$objsession->get('gs_login_id'),"loginmaster");
		}
		
		$userImage = '';
		 					
		if($_FILES["sProfileName"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["sProfileName"]["name"];
			$userImage = $randno.$img;
			deleteImage($userRow['sProfileName'],'upload/artist');
			move_uploaded_file($_FILES['sProfileName']['tmp_name'],"../upload/artist/".$userImage);			
		}else{
			$userImage = $userRow['sProfileName'];
		}
						
		if(!empty($musicalinfluences)){
			$musicalinfluences = implode(',',$musicalinfluences);
		}else{
			$musicalinfluences = '';	
		}
		
		if(!empty($whatkindofmusic)){
			$whatkindofmusic = implode(',',$whatkindofmusic);
		}else{
			$whatkindofmusic = '';	
		}
		
		$field = array("sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sAvailability","sMusicalInstrument","sKindPlay","sPlayedFor","sHavePlayed","iYearOfExp","dHowLongPlay");
		$value = array($sFirstName,$sLastName,$userImage,$sUserName,date("Y-m-d",strtotime($dDOB)),$country,$state,$city,$iZipcode,$availability,$musicalinfluences,$whatkindofmusic,$sPlayedFor,$sWherePlayed,$iYear,date("Y-m-d",strtotime($dPayed)));	
		
		$obj->update($field,$value,"iLoginID = ".$objsession->get('gs_login_id'),"usermaster");

		if($roll != "" && $roll == 'solo'){
			
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'group'";			
			$obj->delete('rollmaster',$cond);
			
			$giftImage = '';
			$giftImage2 = '';
			
			$iRollID = explode(',',$iRollID);
			
			if($iRollID != ""){
				$n = 1;
				foreach($iRollID as $key){
				
				if($_FILES["giftImg".$key]['name'] != ''){
		
				$randno = rand(0,5000);
				$img = $_FILES["giftImg".$key]['name'];
				$giftImage = $randno.$img;
				
				$folderPath = "../upload/artist/".$_POST['sGift'.$key];
				$exist = is_dir($folderPath);
				
				if(!$exist) {
				mkdir("$folderPath");
				chmod("$folderPath", 0755);
				}

				move_uploaded_file($_FILES["giftImg".$key]['tmp_name'],$folderPath."/".$giftImage);			
			
			}else{
				$giftImage = $_POST['extrImage'.$key]	;
			}
			
			if($_FILES["giftVid".$key]['name'] != ''){
		
				$randno = rand(0,5000);
				$img = $_FILES["giftVid".$key]['name'];
				$giftImage2 = $randno.$img;
				
				$folderPath01 = "../upload/artist/video/".$_POST['sGift'.$key];
				$exist = is_dir($folderPath01);
				
				if(!$exist) {
				mkdir("$folderPath01");
				chmod("$folderPath01", 0755);
				}

				move_uploaded_file($_FILES["giftVid".$key]['tmp_name'],$folderPath01."/".$giftImage2);			
			
			}else{
				$giftImage = $_POST['extrImage'.$key]	;
				$giftImage2 = $_POST['sVideo'.$key]	;
			}
			
			
			$field = array("sGiftName","sImage","sYoutubeUrl","sVideo");
			$value = array($_POST['sGift'.$key],$giftImage,$_POST['yt'.$key],$giftImage2);		
			$obj->update($field,$value,"iRollID = ".$key,"rollmaster");
			$n ++;
				}
			
			}
			
			if(!empty($sGiftName) != ""){

				$giftImage01 = '';
				
					
				for($i=0;$i<count($_FILES["giftImage"]['name']);$i++) {
				
				if($_FILES["giftImage"] != ''){
					
				$randno = rand(0,5000);
				$img = $_FILES["giftImage"]['name'][$i];
				$giftImage01 = $randno.$img;
				
											
				$folderPath = "../upload/artist/".$sGiftName[$i];
				$exist = is_dir($folderPath);
				
				if(!$exist) {
				mkdir("$folderPath");
				chmod("$folderPath", 0755);
				}

				move_uploaded_file($_FILES["giftImage"]['tmp_name'][$i],$folderPath."/".$giftImage01);			
				}
				
				$field = array("iLoginID","sGroupType","sGiftName","sImage","sYoutubeUrl");
				$value = array($objsession->get('gs_login_id'),$roll,$sGiftName[$i],$giftImage01,$youtube[$i]);		
				$obj->insert($field,$value,"rollmaster");
			
			}
			
		}
		
			//$sGiftName = implode(',',$sGiftName);
			//$youtube = implode(',',$youtube);	
	
			}
		
		if($roll != "" && $roll == 'group'){
			
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'solo'";			
			$obj->delete('rollmaster',$cond);
			
			$giftImage = '';
			$giftImage2 = '';
			
			if($iRollIDGrp != ""){
				$iRollIDGrp = explode(',',$iRollIDGrp);
			}else{
				$iRollIDGrp = array();	
			}
			
			if(count($iRollIDGrp) > 0){
				
				$n = 1;
				$sMultiImage = '';
				
				foreach($iRollIDGrp as $key){

					if(count($_FILES["giftImgGrp".$n]['name']) > 1){
						
						for($j=0;$j<count($_FILES["giftImgGrp".$n]['name']);$j++) {
						
							if($_FILES["giftImgGrp".$n]['name'][$j] != ""){
								$randno = rand(0,5000);
								$img = $_FILES["giftImgGrp".$n]['name'][$j];
								$giftImage01 = $randno.$img;
								$sMultiImage .= $randno.$img.",";
								
								$folderPath = "../upload/artist/".$_POST['sGiftGrp'.$key];
								$exist = is_dir($folderPath);
								
								if(!$exist) {
									mkdir("$folderPath");
									chmod("$folderPath", 0755);
								}
								
								move_uploaded_file($_FILES["giftImgGrp".$n]['tmp_name'][$j],$folderPath."/".$giftImage01);
							}
						}
					
					$sMultiImage = rtrim($sMultiImage,',');
					
					}else{
						$sMultiImage = $_POST['extrImageGrp'.$key];
					}
			
					if($_FILES["giftVidGrp".$key]['name'] != ''){
						
					
						$randno = rand(0,5000);
						$img = $_FILES["giftVidGrp".$key]['name'];
						$giftImage2 = $randno.$img;
						
						//deleteImage($_POST['extrImageGrp'.$key],'upload/artist/video/'.$_POST['sGiftGrp'.$key]);
						
						$folderPath01 = "../upload/artist/video/".$_POST['sGiftGrp'.$key];
						$exist = is_dir($folderPath01);
						
						if(!$exist) {
							mkdir("$folderPath01");
							chmod("$folderPath01", 0755);
						}
						
						move_uploaded_file($_FILES["giftVidGrp".$key]['tmp_name'],$folderPath01."/".$giftImage2);			
						
					
					}else{
						//$sMultiImage = $_POST['extrImageGrp'.$key]	;
						$giftImage2 = $_POST['extrVideoGrp'.$key]	;
					}
			$field = array("sGroupType","iNumberMembers","sGropName","sMemberName","sGiftName","sImage","sVideo","sYoutubeUrl");
				$value = array($roll,$iNumberMembers,$sGroupName,$_POST['membe'.$key],$_POST['sGiftGrp'.$key],$sMultiImage,$giftImage2,$_POST['ytGrp'.$key]);	
				
			$obj->update($field,$value,"iRollID = ".$key,"rollmaster");
			$sMultiImage = '';
			$n ++;
				
				}
			
			}
			
			if(!empty($mygift) != ""){

				$giftImage01 = '';
				$giftImage2 = '';
				$sMultiImage = '';
							
				if($iNumberMembers > 0)	{
					for($i=0;$i<$iNumberMembers;$i++) {
				$n = $i+1;
			

				if($_FILES["giftImageGrp".$n]['name'][$i] != ''){

					for($j=0;$j<count($_FILES["giftImageGrp".$n]['name']);$j++) {

					$randno = rand(0,5000);
				$img = $_FILES["giftImageGrp".$n]['name'][$i];
				$giftImage01 = $randno.$img;
				$sMultiImage .= $randno.$img.",";
											
				$folderPath = "../upload/artist/".$_POST['mygift'][$i];
				$exist = is_dir($folderPath);
				
				if(!$exist) {
				mkdir("$folderPath");
				chmod("$folderPath", 0755);
				}

				move_uploaded_file($_FILES["giftImageGrp".$n]['tmp_name'][$i],$folderPath."/".$giftImage01);
				
					}
					
					$sMultiImage = rtrim($sMultiImage,',');
					
				
				if(count($_FILES["giftVideo"]) > 0){
					$randno = rand(0,5000);
					$img = $_FILES["giftVideoGrp"]['name'][$i];
					$giftImage2 = $randno.$img;
					
					$folderPath01 = "../upload/artist/video/".$_POST['mygift'][$i];
					$exist = is_dir($folderPath01);
					
					if(!$exist) {
					mkdir("$folderPath01");
					chmod("$folderPath01", 0755);
					}
	
					move_uploaded_file($_FILES["giftVideoGrp"]['tmp_name'][$i],$folderPath01."/".$giftImage2);		
				}
				}
				
				
				$field = array("iLoginID","sGroupType","iNumberMembers","sGropName","sMemberName","sGiftName","sImage","sVideo","sYoutubeUrl");
				$value = array($objsession->get('gs_login_id'),$roll,$iNumberMembers,$sGroupName,$membername[$i],$mygift[$i],$sMultiImage,$giftImage2,$youtubeGrp[$i]);		
				$obj->insert($field,$value,"rollmaster");
				$sMultiImage = '';
			}			
				}
			
		}
						
		}

		$objsession->set('gs_msg','<p>Profile Updates Successfully</p>');
		redirect(URL.'views/artistprofile.php');			
	
}
?>
<script>
setTimeout(function() { 
	$('#countryId').find('option[value=<?php echo $userRow['sCountryName'];?>]').attr('selected','selected');
}, 1000);

setTimeout(function() { 
	$('.countries').trigger('change');
	$('#stateId').find('option[value=<?php echo $userRow['sStateName'];?>]').attr('selected','selected');
}, 2000);

setTimeout(function() { 
	$('#stateId').find('option[value=<?php echo $userRow['sStateName'];?>]').attr('selected','selected');
}, 3000);

setTimeout(function() { 
	$('.states').trigger('change');
	$('#cityId').find('option[value=<?php echo $userRow['sCityName'];?>]').attr('selected','selected');
}, 4000);

setTimeout(function() { 
	$('#cityId').find('option[value=<?php echo $userRow['sCityName'];?>]').attr('selected','selected');
}, 5000);

</script> 
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


            $(wrapper).append('<div class="row"><div class="form-group"><label for="mname" class="col-lg-3 control-label">Member Name</label><div class="col-lg-4"><input class="form-control" type="text" class="" name="membername[]" id="" /></div></div></div><div class="row"><div class="form-group"><label for="role" class="col-lg-3 control-label">Member Gift</label><div class="col-lg-4"><select name="mygift[]" class="form-control mt10"><option selected="selected" value="bassplayers">bass players</option><option value="Dancers">Dancers</option><option value="Drummers">Drummers</option><option value="Flute">Flute</option><option value="Guitarists">Guitarists</option><option value="Horn players">Horn players</option><option value="Saxophone">Saxophone</option><option value="Trombone">Trombone</option><option value="Trumpet">Trumpet</option><option value="Keys">Keys</option><option value="Mime">Mime</option><option value="Percussions">Percussions</option><option value="Singers">Singers</option><option value="Violin">Violin</option></select></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Upload Videos form youtube</label><div class="col-lg-4"><input class="form-control" type="text" class="" name="youtubeGrp[]" id="" /></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Upload image for gift</label><div class="col-lg-4"><input class="form-control file" type="file" name="giftImageGrp'+i+'[]" multiple="multiple" id="" /></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Upload video for gift</label><div class="col-lg-4"><input class="form-control file" type="file" name="giftVideoGrp[]" id="" /></div></div></div>'); //add input box

		//document.getElementById("xval").value = x;
}
}
</script> 
<script>

$(document).ready(function() {
	

	
var dynamicid = document.getElementById('ext').value;

$('#AddSolo').click(function() {

	var data = '<div id="divsolo'+dynamicid+'">';
data +=           '<div class="row"><div class="form-group">';
data +=           '             <label for="role" class="col-lg-3 control-label">My Gift</label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <select id="sGiftName" class="form-control" name="sGiftName[]"  >';
data +=           '                <option value="bassplayers">bass players</option>';
data +=           '                <option value="Dancers">Dancers</option>';
data +=           '                <option value="Drummers">Drummers</option>';
data +=           '                <option value="Flute">Flute</option>';
data +=           '                <option value="Guitarists">Guitarists</option>';
data +=           '                <option value="Horn players">Horn players</option>';
data +=           '                <option value="Saxophone">Saxophone</option>';
data +=           '                <option value="Trombone">Trombone</option>';
data +=           '                <option value="Trumpet">Trumpet</option>';
data +=           '                <option value="Keys">Keys</option>';
data +=           '                <option value="Mime">Mime</option>';
data +=           '                <option value="Percussions">Percussions</option>';
data +=           '                <option value="Singers">Singers</option>';
data +=           '                <option value="Violin">Violin</option>';
data +=           '              </select>			 ';
data +=           '            </div>';
data +=           '        </div></div>';
data +=           '<div class="row">';
data +=           '<div class="form-group">';
data +=           '<label for="role" class="col-lg-3 control-label">Upload Gift Image</label>';
data +=           '<div class="col-lg-4">';
data +=           '<input type="file" name="giftImage[]" class="form-control file"/>';
data +=           '</div>';
data +=           '</div>';
data +=           '</div>';
data +=           '<div class="row">';
data +=           '<div class="form-group">';
data +=           '<label for="role" class="col-lg-3 control-label">Upload Gift Video</label>';
data +=           '<div class="col-lg-4">';
data +=           '<input type="file" name="giftVideo[]" class="form-control file"/>';
data +=           '</div>';
data +=           '</div>';
data +=           '</div>';
data +=           '        <div class="row"><div class="form-group">';
data +=           '            <label for="role" class="col-lg-3 control-label"></label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="text" name="youtube[]" class="form-control" placeholder="Enter only youtube url" />';
data +=           '            </div>';
data +=           '            <div class="col-lg-4">';
data +=           '               <a class="Solo-Remove remove" onclick="soloremove(this)" id="'+dynamicid+'">Remove</a>';
data +=           '            </div>';
data +=           '          </div>';
data +=           '        </div></div>';
	
	$('#solo-New').append(data);
	$('#solo-New').show();
	dynamicid ++;
});

});
function soloremove(obj)
{

var objId= obj.id.toString();
$("#divsolo"+objId).remove();
	}
</script>