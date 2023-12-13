<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php';?>
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
          <div class="col-lg-4" id="img"> <img id="blah" class="profileimage" src="<?php echo URL;?>upload/user/<?php echo $userRow['sProfileName'];?>" alt="X" /> </div>
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
	print_r($_POST);
	
		if($sPassword != ""){		
			$field = array("sPassword");
			$value = array(md5($sPassword));		
			$obj->update($field,$values,"iLoginID = ".$objsession->get('gs_login_id'),"loginmaster");
		}
		
		$userImage = '';
		 					
		if($_FILES["sProfile"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["sProfile"]["name"];
			$userImage = $randno.$img;
			deleteImage($userRow['sProfileName'],'upload/user');
			move_uploaded_file($_FILES['sProfile']['tmp_name'],"../upload/user/".$userImage);			
		}else{
			$userImage = $userRow['sProfileName'];
		}
		
		$field = array("sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sGender");
		$value = array($sFirstName,$sLastName,$userImage,$sUserName,date("Y-m-d",strtotime($dDob)),$country,$state,$city,$iZipcode,$sGender);	
		
		$obj->update($field,$value,"iLoginID = ".$objsession->get('gs_login_id'),"usermaster");
		
		$objsession->set('gs_msg','<p>Profile Updates Successfully</p>');
		redirect(URL.'views/useraccount.php');			
	
}
?>
<script>
setTimeout(function() { 
	$('#countryId').find('option[value=India]').attr('selected','selected');
}, 1000);

setTimeout(function() { 
	$('.countries').trigger('change');
	$('#stateId').find('option[value=Gujarat]').attr('selected','selected');
}, 2000);

setTimeout(function() { 
	$('#stateId').find('option[value=Gujarat]').attr('selected','selected');
}, 3000);

setTimeout(function() { 
	$('.states').trigger('change');
	$('#cityId').find('option[value=Ahmedabad]').attr('selected','selected');
}, 4000);

setTimeout(function() { 
	$('#cityId').find('option[value=Ahmedabad]').attr('selected','selected');
}, 5000);

</script> 