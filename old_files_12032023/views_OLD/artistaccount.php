<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php';?>
<script type="text/javascript" src="<?php echo URL;?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>js/ckeditor/adapters/jquery.js"></script>
<style>
#destroy:hover
{
	pointer-events:none;
}
</style>
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
	
	$(function(){
		$.validator.addMethod('minStrict', function (value, el, param) {
		return value > param;
	});});	
	
	$.validator.addMethod('filesize', function (value, element, param) {
    	return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than 60 mb');
	
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
				//filesize: 314572800,
				filesize: 62914560,
				messages: {
					accept: "Only upload mp4 video"
				}
			});
		});
		
		$(".dd").each(function() {
			$(this).rules("add", {
				required: true,
				messages: {
					required: "Required....!"
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
$rolemaster = $obj->fetchRow("rollmaster",$cond);

$countrymaster = $obj->fetchRowAll("countries",'1=1');

$states = $obj->fetchRowAll("states",'country_id = '.$userRow['sCountryName']);
$cities = $obj->fetchRowAll("cities",'state_id = '.$userRow['sStateName']);

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

<div class="container">
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
<div class="clear"></div>
<h4 class="h4">EDIT PROFILE</h4>
<div class="col-md-12">
  <form id="frmProfile" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend>Personal Information</legend>
      <div class='row' style="display:none;">
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
          <label class="col-sm-3" for="user_firstname">Birth Date</label>
          <div class='col-sm-4'>
            <input class="form-control" id="dDob01" readonly name="dDOB" required="true" value="<?php if(!empty($userRow)){echo date("d-m-Y",strtotime($userRow['dDOB']));}?>" type="text" />
          </div>
        </div>
      </div>
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_firstname">Gender</label>
          <div class='col-sm-4'>
            <select class="form-control" id="sGender" name="sGender">
              <option value="">Select gender</option>
              <option <?php if($userRow['sGender'] == 'male'){?> selected="selected" <?php }?> value="male">Male</option>
              <option <?php if($userRow['sGender'] == 'female'){?> selected="selected" <?php }?> value="female">Female</option>
            </select>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_firstname">Profile Image</label>
          <div class='col-sm-4'>
            <input class="form-control file" id="sProfileName" name="sProfileName" value="<?php if(!empty($userRow)){echo $userRow['sProfileName'];}?>" type="file" />
          </div>
          <div class="col-sm-4" id="img"> <img id="blah" class="profileimage" src="<?php echo URL;?>upload/artist/<?php echo $userRow['sProfileName'];?>" alt="X" /> </div>
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
			//Read the image
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
        <img src="<?php echo URL;?>upload/artist/multiple/<?php echo $img;?>" style="margin-left:2px;" class="thumbnail" />
        <?php
			}
		}?>
        </div>
      </div><?php */?>
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
            <input class="form-control" id="sPassword1" name="sPassword1" type="password" />
          </div>
        </div>
      </div>
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_password_confirmation">Confirm Password</label>
          <div class='col-sm-4'>
            <input class="form-control" id="cPassword1" name="cPassword1" type="password" />
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
      <legend>Talent Section</legend>
      <div class='row'>
        <div class='form-group'>
          <label class="col-sm-3" for="user_firstname">Role</label>
          <div class='col-sm-4'>
            <?php
				if($rolemaster['sGroupType'] != ''){
					$soloType = '';
					$groupType = '';
					
					if($rolemaster['sGroupType'] == 'solo'){
						$soloType = 'selected';
						echo 'Solo';
					}
					if($rolemaster['sGroupType'] == 'group'){
						$groupType = 'selected';
						echo 'Group';
					}
			?>
            <input type="hidden" id="roll" name="roll" value="<?php echo $rolemaster['sGroupType'];?>" />
            <?php
				}else{
					
					?>
                                       
                <select id="selectField" name="roll" class="form-control" >
                    <option value="selectroll" selected>Select Roll</option>
                    <option value="solo" >Solo</option>
                    <option value="group" >Group</option>
                </select>	
              <?php } ?>
                    
            <?php /*?><select id="selectField" name="roll" class="form-control" >
              <option id="selectroll" value="selectroll" selected>Select Roll</option>
              <option <?php echo $soloType;?> value="solo" >Solo</option>
              <option <?php echo $groupType;?> value="group" >Group</option>
            </select><?php */?>
          </div>
        </div>
      </div>

<div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label"></label>
           <?php if($end == count($rolemasterAll)){?>
                <div class="col-lg-4"> <a id="AddSolo" class="addmore" style="font-size:20px">Add More Videos</a> </div>
                <?php } ?>
                </div>
       </div>

      <div id="solo" <?php if($rolemaster['sGroupType'] != 'solo'){?>style="display:none;"<?php } ?>>
        <div id="solo-New" <?php if(!empty($rolemaster) && $rolemaster['sGroupType'] != 'solo'){?>style="display:none;"<?php } ?>>
          <?php
			
			$rolemasterAll = array();
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'solo'";
			$rolemasterAll = $obj->fetchRowAll("rollmaster",$cond);
			$end = 1;
			if(!empty($rolemasterAll)){
				
			?>
                      <input type="hidden" name="grpSolo02" id="grpSolo02" value="0" />
            <?php
				$iRollID = '';
				
				for($i=0;$i<count($rolemasterAll);$i++){
					$iRollID .= $rolemasterAll[$i]['iRollID'].',';
					$divNo = rand(10,9999);
			?>
            <input type="hidden" name="sVideo<?php echo $rolemasterAll[$i]['iRollID'];?>" id="sVideo<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sVideo'];?>" />
            <input type="hidden" name="sVideoName<?php echo $rolemasterAll[$i]['iRollID'];?>" id="sVideoName<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sVideoName'];?>" />
            <input type="hidden" name="sVideoImages<?php echo $rolemasterAll[$i]['iRollID'];?>" id="sVideoImages<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sVideoImages'];?>" />
			<input type="hidden" name="youtubeUrl01<?php echo $rolemasterAll[$i]['iRollID'];?>" id="youtubeUrl01<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sYoutubeUrl'];?>" />
            
          <input type="hidden" name="iRollID" id="iRollID" value="<?php echo rtrim($iRollID,',');?>" />
          <input type="hidden" name="grpSolo" id="grpSolo" value="0" />

          <input type="hidden" name="extrImage<?php echo $rolemasterAll[$i]['iRollID'];?>" id="extrImage<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sImage'];?>">
          
          <input type="hidden" name="extrVideo<?php echo $rolemasterAll[$i]['iRollID'];?>" id="extrVideo<?php echo $rolemasterAll[$i]['iRollID'];?>" value="<?php echo $rolemasterAll[$i]['sVideo'];?>">
          
          
          <div id="divsolo<?php echo $divNo;?>">
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">My Talent</label>
                <div class="col-lg-4" style="border-bottom:2px solid black;padding:7px;">

					
                  <select class="form-control" id="sGift<?php echo $rolemasterAll[$i]['iRollID'];?>" name="sGift<?php echo $rolemasterAll[$i]['iRollID'];?>" onclick="pop()" >
						<?php
				$drop = $obj->fetchRowAll("giftmaster","isActive = 1");
				if(count($drop) > 0){
				for($c=0;$c<count($drop);$c++){
						$abc=$drop[$c]['sGiftName'];?>
						<option value="<?php echo $abc;?>"><?php echo $abc;?></option>
					<?php }
							}
			
					?>				
                  <!--<option value="Accordionist">Accordionist</option>
                  <option value="Actor">Actor</option>
                  <option value="Actress">Actress</option>
                  <option value="Banjo_Player">Banjo Player</option>
                  <option value="Bassist">Bassist</option>
                  <option value="Bassoonist">Bassoonist</option>
                  <option value="Cellist">Cellist</option>
                  <option value="Clarinetist">Clarinetist</option>
                  <option value="Composer">Composer</option>
                  <option value="Dancers">Dancers</option>
                  <option value="Drummers">Drummers</option>
                  <option value="Flautist">Flautist</option>
                  <option value="Guitarist">Guitarist</option>
                  <option value="Harmonica_Player">Harmonica Player</option>
                  <option value="Harpist">Harpist</option>
                  <option value="Mime_Artist">Mime Artist</option>
                  <option value="Organist">Organist</option>
                  <option value="Percussionist">Percussionist</option>
                  <option value="Pianist_keyboardist">Pianist/keyboardist</option>
                  <option value="Piccolo_Player">Piccolo Player</option>
                  <option value="Poet_Spoken_Word">Poet/Spoken Word</option>
                  <option value="Rapper">Rapper</option>
                  <option value="Saxophonist">Saxophonist</option>
                  <option value="Singer_Vocalist">Singer/Vocalist</option>
                  <option value="Song_Writer">Song Writer</option>
                  <option value="Saxophonist">Saxophonist</option>
                  <option value="Trombonist">Trombonist</option>
                  <option value="Trumpeter">Trumpeter</option>
                  <option value="Tubist">Tubist</option>
                  <option value="Violinist">Violinist</option>
                  <option value="Violist">Violist</option>-->
                  </select>
                </div>
                <div class="col-lg-4"> <a class="Solo-Remove remove" onclick="soloremove(this)" id="<?php echo $divNo;?>">Remove Talent</a> </div>
              </div>
            </div>
            <script>
$(document).ready(function(){
	
	//$('#sGift<?php echo $rolemasterAll[$i]['iRollID'];?> option[value="<?php echo $rolemasterAll[$i]['sGiftName'];?>"]');
	
	setTimeout(function() { 
	$('#sGift<?php echo $rolemasterAll[$i]['iRollID'];?>').val('<?php echo $rolemasterAll[$i]['sGiftName'];?>');
},100);

});		  

</script>
            <div class='row' style="display:none;">
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Talent Video Image</label>
                <div class="col-lg-4">
                  <input type="file" accept="image/*" name="giftVideoImage<?php echo $rolemasterAll[$i]['iRollID'];?>[]" multiple="" class="form-control file uploadsvideoimage" style="pointer-events:none;"/>
                </div>
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
              </div>
            </div>
            <div class='row' style="display:none;">
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Talent Video</label>
                <div class="col-lg-4">
                  <input type="file" id="destroy1" accept="video/*" multiple="" name="giftVid<?php echo $rolemasterAll[$i]['iRollID'];?>[]" class="form-control file uploadsvideo" style="pointer-events:none;"/>
                </div>
                
                <div class="col-lg-4" id="img">
                <?php if($rolemasterAll[$i]['sVideo'] != ""){?>
                
            
                <?php /*?><video src="<?php echo URL;?>upload/church/<?php echo $rolemasterAll[$i]['sGiftName'];?>/<?php echo $rolemasterAll[$i]['sVideo'];?>"></video><?php */?>
                
                                
                <?php } ?>
                </div>
              </div>
            </div>
            <div class='row' style="display:none;">
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label"></label>
                <div class="col-lg-4" style="border-bottom: 2px solid;padding: 10px;">
                  <input type="text" name="yt<?php echo $rolemasterAll[$i]['iRollID'];?>" class="form-control" placeholder="Enter only youtube url" onclick="pop()"/>
                </div>
               
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
            <input type="hidden" name="grpSolo" id="grpSolo" value="1" />
            <input type="hidden" name="grpSolo02" id="grpSolo02" value="1" />
            <!--<div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">My Talent</label>
                <div class="col-lg-4">
                  <select class="form-control" id="sGiftName" name="sGiftName[]" onclick="pop()">
					<?php
				$drop = $obj->fetchRowAll("giftmaster","isActive = 1");
				if(count($drop) > 0){
				for($c=0;$c<count($drop);$c++){
						$abc=$drop[$c]['sGiftName'];?>
						<option value="<?php echo $abc;?>"><?php echo $abc;?></option>
					<?php }
							}
			
					?>		
                  <option value="Accordionist">Accordionist</option>
                  <option value="Actor">Actor</option>
                  <option value="Actress">Actress</option>
                  <option value="Banjo_Player">Banjo Player</option>
                  <option value="Bassist">Bassist</option>
                  <option value="Bassoonist">Bassoonist</option>
                  <option value="Cellist">Cellist</option>
                  <option value="Clarinetist">Clarinetist</option>
                  <option value="Composer">Composer</option>
                  <option value="Dancers">Dancers</option>
                  <option value="Drummers">Drummers</option>
                  <option value="Flautist">Flautist</option>
                  <option value="Guitarist">Guitarist</option>
                  <option value="Harmonica_Player">Harmonica Player</option>
                  <option value="Harpist">Harpist</option>
                  <option value="Mime_Artist">Mime Artist</option>
                  <option value="Organist">Organist</option>
                  <option value="Percussionist">Percussionist</option>
                  <option value="Pianist_keyboardist">Pianist/keyboardist</option>
                  <option value="Piccolo_Player">Piccolo Player</option>
                  <option value="Poet_Spoken_Word">Poet/Spoken Word</option>
                  <option value="Rapper">Rapper</option>
                  <option value="Saxophonist">Saxophonist</option>
                  <option value="Singer_Vocalist">Singer/Vocalist</option>
                  <option value="Song_Writer">Song Writer</option>
                  <option value="Saxophonist">Saxophonist</option>
                  <option value="Trombonist">Trombonist</option>
                  <option value="Trumpeter">Trumpeter</option>
                  <option value="Tubist">Tubist</option>
                  <option value="Violinist">Violinist</option>
                  <option value="Violist">Violist</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Talent Video Image</label>
                <div class="col-lg-4">
                  <input type="file" accept="image/*" name="giftVideoImage0[]" multiple="" class="form-control file uploadsvideoimage"/>
                </div>
                
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Talent Video</label>
                <div class="col-lg-4">
                  <input type="file" accept="video/*" name="giftVideo0[]" multiple="" class="form-control file uploadsvideo" onclick="pop()"/>
                </div>
                
              </div>
            </div>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label"></label>
                <div class="col-lg-4">
                  <input type="text" name="youtube[]" class="form-control" value="" placeholder="Enter only youtube url" onclick="pop()"/>
                </div>                
                <div class="col-lg-4"> <a id="AddSolo" class="addmore">Add More Videos</a> </div>
              </div>
            </div>-->
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
        <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Talent Video Image</label>
                <div class="col-lg-4">
                  <input type="file" accept="image/*" multiple="" name="giftVidGrpImage[]" class="form-control file uploadsvideoimage" placeholder="Choose File...."/>
                </div>
                
                <div class="col-lg-4" id="img">
                </div>
              </div>
            </div>
        <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Upload Talent Video</label>
                <div class="col-lg-4" style="border-bottom: 2px solid;padding: 10px;">
                  <input type="file" accept="video/*" multiple="" name="giftVidGrp[]" class="form-control file uploadsvideo" placeholder="Choose File...."/>
                </div>
                
                <div class="col-lg-4" id="img">
                </div>
              </div>
            </div>
            <?php
			
			$rolemasterAll = array();
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'group'";
			$rolemasterAll04 = $obj->fetchRow("rollmaster",$cond);
			
			$iRollID02 = $rolemasterAll04['iRollID'];
			?>
                      <input type="hidden" name="iRollIDGrp" id="iRollIDGrp" value="<?php echo $iRollID02;?>" />
        <div class="input_fields_wrap01" >   
        
        
         <?php
			
			$rolemasterAll = array();
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'group'";
			$rolemasterAll = $obj->fetchRow("rollmaster",$cond);
			$mName = explode(',',$rolemasterAll['sMemberName']);
			$mYoutube = explode(',',$rolemasterAll['sYoutubeUrl']);
			if($mYoutube[0] == ''){
				$mYoutube = array();	
			}
			$mGift = explode(',',$rolemasterAll['sGiftName']);
			
			$mVid = explode(',',$rolemasterAll['sVideo']);
			if($mVid[0] == ''){
				$mVid = array();	
			}
			
			$mVidName = explode(',',$rolemasterAll['sVideoName']);

			if($mVidName[0] == ''){
				$mVidName = array();	
			}
			
			$end = 1;
			if(!empty($mName)){
				$iRollID = '';
				$new = 0;
				
				if ( $rolemasterAll['memberAge'] != "" ) {
					$memberage = explode(',',$rolemasterAll['memberAge']);
				} else {
					$memberage = array();
				}
								 
				foreach($mName as $name){
					$iRollID = $rolemasterAll['iRollID'];
			?>
            <input type="hidden" name="sVideoName" id="sVideoName" value="<?php if($rolemasterAll['sVideoName'] != ""){echo $rolemasterAll['sVideoName'];}?>" />
            <input type="hidden" name="videoCoverImage" id="videoCoverImage" value="<?php if($rolemasterAll['sVideoImages'] != ""){echo $rolemasterAll['sVideoImages'];}?>" />
            
          <input type="hidden" name="sVideo" id="sVideo" value="<?php if($rolemasterAll['sVideo'] != ""){echo $rolemasterAll['sVideo'];}?>" />
		  <input type="hidden" name="sUTV" id="sUTV" value="<?php if($rolemasterAll['sYoutubeUrl'] != ""){echo $rolemasterAll['sYoutubeUrl'];}?>" />
          <input type="hidden" name="iRollIDGrp" id="iRollIDGrp" value="<?php echo $iRollID;?>" />
          <input type="hidden" name="numofmember" id="numofmember" value="<?php echo count(explode(',',$iRollID));?>" />
          <input type="hidden" name="extrImageGrp<?php echo $rolemasterAll['iRollID'];?>" id="extrImageGrp<?php echo $rolemasterAll['iRollID'];?>" value="<?php echo $rolemasterAll['sImage'];?>">
          
          <input type="hidden" name="extrVideoGrp<?php echo $rolemasterAll['iRollID'];?>" id="extrVideoGrp<?php echo $rolemasterAll['iRollID'];?>" value="<?php echo $rolemasterAll['sVideo'];?>">
          
          <div class="row">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="mname">Member Name</label>
              <div class="col-lg-4">
                <input type="text" id="" name="membername[]" value="<?php echo $name;?>" class="form-control">
              </div>
            </div>
          </div>
		  
		  <div class="row">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="mname">Birth Date</label>
              <div class="col-lg-4">
                <input type="text" id="dob<?php echo $new;?>" name="dob[]" value="<?php if ( !empty($memberage) ) { echo $memberage[$new]; }?>" class="form-control">
              </div>
            </div>
          </div>
          
		  <script type="text/javascript">
			$(function () {     
							   
				$('#dob<?php echo $new;?>').datetimepicker({
					format: 'DD-MM-YYYY',
					ignoreReadonly: true,
					disabledDates:[moment().subtract(1,'d')],
				});
			});
        </script>
		
          <script>
setTimeout(function() { 
	$('#mygift<?php echo $new;?>').val('<?php echo $mGift[$new];?>');
},200);
</script>
<script>
function pop()
{
	alert("To Add Videos please Click on Add More Videos and Select Your Talents");
	window.location.href="<?php echo URL;?>views/artistaccount.php";
}

window.load = function() {
   document.getElementById('destroy').dialog = falce;
	document.getElementById('destroy1').disabled = true;
};
</script>
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">My Talent</label>
                <div class="col-lg-4">
                  <select class="form-control" id="mygift<?php echo $new;?>" name="mygift[]" onclick="pop()">
						<?php
				$drop = $obj->fetchRowAll("giftmaster","isActive = 1");
				if(count($drop) > 0){
				for($c=0;$c<count($drop);$c++){
						$abc=$drop[$c]['sGiftName'];?>
						<option value="<?php echo $abc;?>"><?php echo $abc;?></option>
					<?php }
							}
			
					?>		
                    <!--<option value="Accordionist">Accordionist</option>
                  <option value="Actor">Actor</option>
                  <option value="Actress">Actress</option>
                  <option value="Banjo_Player">Banjo Player</option>
                  <option value="Bassist">Bassist</option>
                  <option value="Bassoonist">Bassoonist</option>
                  <option value="Cellist">Cellist</option>
                  <option value="Clarinetist">Clarinetist</option>
                  <option value="Composer">Composer</option>
                  <option value="Dancers">Dancers</option>
                  <option value="Drummers">Drummers</option>
                  <option value="Flautist">Flautist</option>
                  <option value="Guitarist">Guitarist</option>
                  <option value="Harmonica_Player">Harmonica Player</option>
                  <option value="Harpist">Harpist</option>
                  <option value="Mime_Artist">Mime Artist</option>
                  <option value="Organist">Organist</option>
                  <option value="Percussionist">Percussionist</option>
                  <option value="Pianist_keyboardist">Pianist/keyboardist</option>
                  <option value="Piccolo_Player">Piccolo Player</option>
                  <option value="Poet_Spoken_Word">Poet/Spoken Word</option>
                  <option value="Rapper">Rapper</option>
                  <option value="Saxophonist">Saxophonist</option>
                  <option value="Singer_Vocalist">Singer/Vocalist</option>
                  <option value="Song_Writer">Song Writer</option>
                  <option value="Saxophonist">Saxophonist</option>
                  <option value="Trombonist">Trombonist</option>
                  <option value="Trumpeter">Trumpeter</option>
                  <option value="Tubist">Tubist</option>
                  <option value="Violinist">Violinist</option>
                  <option value="Violist">Violist</option>-->
                  </select>
                </div>
              </div>
            </div>
            
            <div class='row'>
              <div class="form-group">
                <label for="role" class="col-lg-3 control-label">Youtube Url</label>
                <div class="col-lg-4">
                  <input type="text" name="youtube[]" class="form-control" placeholder="Enter only youtube url" onclick="pop()"/>
                </div>
              </div>
            </div>
          <?php
		   			$end ++;
					$new++;
		   		}
			}
			else{
			?>
            <input type="hidden" name="iRollIDGrp" id="iRollIDGrp" value="0" />
            <input type="hidden" name="numofmember" id="numofmember" value="0" />
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
	$('#availability').val('<?php echo $userRow['sAvailability'];?>');
},100);
</script>
            <select name="availability" id="availability" class="form-control" >
              
              <option value="currently gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
              <option value="Looking for gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
              <option value="will play for food(Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
              <option value="will play for free">Will Play for Free </option>
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
      <!--<div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">How long they have playing</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" value="<?php if(!empty($userRow) && $userRow['dHowLongPlay'] != ""){echo date("d-m-Y",strtotime($userRow['dHowLongPlay']));}?>" id="dPayed" name="dPayed" >
          </div>
        </div>
      </div>-->
      <div class='row'>
        <div class="form-group">
          <label for="mi" class="col-lg-3 control-label">Musical Influences</label>
          <div class="col-lg-4">          
		  		  <!--<input type="text" class="form-control" id="musicalinfluences" value="<?php if(!empty($userRow)){echo $userRow['sMusicalInstrument'];}?>" name="musicalinfluences" >-->
		  <textarea name="musicalinfluences" class="form-control" id="musicalinfluences"><?php if(!empty($userRow)){echo $userRow['sMusicalInstrument'];}?></textarea>
						<script type="text/javascript">
			CKEDITOR.replace( 'musicalinfluences', {
				fullPage: false,
				allowedContent: true,
		 });
			
</script>
            <!--<select name="musicalinfluences[]" class="form-control" multiple="multiple">
              <option <?php if(in_array('bass_player',$sMusicalInstrument)){ echo 'selected';}?> value="bass_player">Bass Player</option>
              <option <?php if(in_array('Dancer',$sMusicalInstrument)){ echo 'selected';}?> value="Dancer">Dancer</option>
              <option <?php if(in_array('Drummer',$sMusicalInstrument)){ echo 'selected';}?> value="Drummer">Drummer</option>
              <option <?php if(in_array('Flute',$sMusicalInstrument)){ echo 'selected';}?> value="Flute">Flute</option>
              <option <?php if(in_array('Guitarist',$sMusicalInstrument)){ echo 'selected';}?> value="Guitarist">Guitarist</option>
              <option <?php if(in_array('Keys',$sMusicalInstrument)){ echo 'selected';}?> value="Keys">Keys</option>
              <option <?php if(in_array('Mime',$sMusicalInstrument)){ echo 'selected';}?> value="Mime">Mime</option>
            </select> -->
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">What Kind of Music I Play</label>
          <div class="col-lg-4">         
		  <textarea class="form-control" id="whatkindofmusic" name="whatkindofmusic" ><?php if(!empty($userRow)){echo $userRow['sKindPlay'];}?></textarea>
			
		 <script type="text/javascript">
			CKEDITOR.replace( 'whatkindofmusic', {
				fullPage: false,
				allowedContent: true,
		 });
			
</script>
            <!--<select name="whatkindofmusic[]" multiple="multiple" class="form-control">             
              <option <?php if(in_array('Rock',$sKindPlay)){ echo 'selected';}?> value="Rock">Rock</option>
              <option <?php if(in_array('Jazz',$sKindPlay)){ echo 'selected';}?> value="Jazz">Jazz</option>
              <option <?php if(in_array('Flute',$sKindPlay)){ echo 'selected';}?> value="Flute">Flute</option>
              <option <?php if(in_array('pop',$sKindPlay)){ echo 'selected';}?> value="pop">pop</option>
            </select>-->
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="ye" class="col-lg-3 control-label">Who I Have Played With</label>
          <div class="col-lg-4">
<!--            <input type="text" class="form-control" id="sPlayedFor" value="<?php if(!empty($userRow)){echo $userRow['sPlayedFor'];}?>" name="sPlayedFor" >-->
            <textarea name="sPlayedFor" class="form-control" id="sPlayedFor"><?php if(!empty($userRow)){echo $userRow['sPlayedFor'];}?></textarea>
				<script type="text/javascript">
			CKEDITOR.replace( 'sPlayedFor', {
				fullPage: false,
				allowedContent: true,
		 });
			
</script>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="form-group">
          <label for="pf" class="col-lg-3 control-label">Where I Have Played</label>
          <div class="col-lg-4">
            <!--<input type="text" class="form-control" value="<?php if(!empty($userRow)){echo $userRow['sHavePlayed'];}?>" id="sWherePlayed" name="sWherePlayed" >-->
             <textarea name="sWherePlayed" class="form-control" id="sWherePlayed"><?php if(!empty($userRow)){echo $userRow['sHavePlayed'];}?></textarea>
				<script type="text/javascript">
			CKEDITOR.replace( 'sWherePlayed', {
				fullPage: false,
				allowedContent: true,
		 });
			
</script>
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
</div>

<?php
if(isset($_POST['btn_update'])){
	extract($_POST)	;
	
		if($sPassword1 != ""){		
			$field = array("sPassword1");
			$value = array(md5($sPassword1));		
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
		
		//$sMultiImage = '';

		/*if($moreImage == ''){
			
			if($_FILES["sProfileMore"] != ''){
				
				for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
					
					if($_FILES["sProfileMore"]['name'][$i] != ""){
					$randno = rand(0,5000);
					$img = $_FILES["sProfileMore"]['name'][$i];
					$sMultiImage .= $randno.$img.",";
					
					if($moreImage01 != ""){
						$moreImage01 = explode(',',$moreImage01);
						
						foreach($moreImage01 as $key){
							deleteImage($key,'upload/artist/multiple');
						}
					}
					move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/artist/multiple/".$randno.$img);			
					}
				}
				
				$sMultiImage = rtrim($sMultiImage,',');
			}
		}else{
			$sMultiImage = $moreImage;
		}*/
	
						
		/*if(!empty($musicalinfluences)){
			$musicalinfluences = implode(',',$musicalinfluences);
		}else{
			$musicalinfluences = '';	
		}*/
		
		/*if(!empty($whatkindofmusic)){
			$whatkindofmusic = implode(',',$whatkindofmusic);
		}else{
			$whatkindofmusic = '';	
		}*/
		
		$field = array("sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sAvailability","sMusicalInstrument","sKindPlay","sPlayedFor","sHavePlayed","iYearOfExp","sGender","sContactNumber","sContactEmailID");
		$value = array($sFirstName,$sLastName,$userImage,$sUserName,date("Y-m-d",strtotime($dDOB)),$country,$state,$city,$iZipcode,$availability,$musicalinfluences,$whatkindofmusic,$sPlayedFor,$sWherePlayed,$iYear,$sGender,$sContactNumber,$sContactEmailID);	
		
		$obj->update($field,$value,"iLoginID = ".$objsession->get('gs_login_id'),"usermaster");

if($roll != "" && $roll == 'solo'){
			
	$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'group'";		
	$obj->delete('rollmaster',$cond);
	
	$giftImage = '';			
	$giftImage2 = '';
	$sVideoName = '';
	$gift = '';
	
	if($iRollID != ''){
		$iRollID = explode(',',$iRollID);
	}else{
		$iRollID = array();
	}
	
	
	//echo count($iRollID);
	$ids = '';
	if(count($iRollID) > 0){
				
		$n = 1;
				
		foreach($iRollID as $key){

		
			if($_FILES["giftVid".$key]['name'] != ''){
				
				for($img = 0;$img <count($_FILES["giftVid".$key]['name']); $img++){
					
						if($_FILES["giftVid".$key]['name'][$img] != ''){
						
							$randno = rand(0,5000);
							$img_new = $_FILES["giftVid".$key]['name'][$img];
							$giftImage2 .= $randno.$img_new.",";		
							$sVideoName .= $_FILES["giftVid".$key]['name'][$img].',';
							
							if ( $_FILES["giftVideoImage".$key]['name'][$img] != "" ) {
								//Upload video images
								$tempVid = explode(".", $_FILES["giftVid".$key]['name'][$img]);
								$tempImge = explode(".", $_FILES["giftVideoImage".$key]['name'][$img]);
								//Image name
								$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
							}else {
								$videoCoverImage = ",".$videoCoverImage;
							}
							
							$folderPath01 = "../upload/artist/video/".$_POST['sGift'.$key];
							$exist = is_dir($folderPath01);
							
							if($_POST['sVideo'.$key] != ""){
							
								$imgDelete = explode(',',$_POST['sVideo'.$key]);
							
								foreach($imgDelete as $key1){
									//deleteImage($key1,'upload/artist/video/'.$_POST['sGift'.$key]);
								}
							}
				
						if(!$exist) {
							
							mkdir("$folderPath01");
							chmod("$folderPath01", 0755);
							
						}
				
						move_uploaded_file($_FILES["giftVid".$key]['tmp_name'][$img],$folderPath01."/".$randno.$img_new);
						
						if ( $_FILES["giftVideoImage".$key]['name'][$img] != "" ) {
							move_uploaded_file($_FILES["giftVideoImage".$key]['tmp_name'][$img],$folderPath01."/".$randno.$tempVid[0].'.'.end($tempImge));
						}
						
						if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
								
							$fld = array('sVideoName','dCreatedDate');
							$val = array($randno.$img,date('Y-m-d'));
							
							$obj->insert($fld,$val,"videouploaddate");
							
						}	
				
					}else{
						//$sVideoName = $_POST['sVideoName'.$key];
						//$giftImage2 = $_POST['sVideo'.$key];								
					}
				}
							
				$rowOldVideo = $obj->fetchRow('rollmaster','iLoginID = '.$objsession->get('gs_login_id')." AND sGiftName = '".$_POST['sGift'.$key]."'");
						
				
				$giftImage2   = rtrim($giftImage2,',');
				$sVideoName	  = rtrim($sVideoName,',');
				$videoCoverImage = rtrim($videoCoverImage,',');
				
				if ( $_POST['yt'.$key] != "") {
						
					
					
					if ( $rowOldVideo['sVideoName'] != "" ) {  
						$youtubeUrl .= ','.$rowOldVideo['sYoutubeUrl'];
					}
					
				} else {
					$youtubeUrl = $rowOldVideo['sYoutubeUrl'];
				}				
				
				if(!empty($rowOldVideo) && $rowOldVideo['sVideo'] != ""){
					
					$giftImage2 .= ','.$rowOldVideo['sVideo'];
					$sVideoName .= ','.$rowOldVideo['sVideoName'];
					//$videoCoverImage .= ','.$rowOldVideo['sVideoImages'];
					
							if($rowOldVideo['sVideoImages'] == "")
							{
								$videoCoverImage = $rowOldVideo['sVideoImages'];
							}
						else
							{
								$videoCoverImage .= ','.$rowOldVideo['sVideoImages'];
							}
				
					
					
					$giftImage2 = ltrim($giftImage2,',');
					$sVideoName = ltrim($sVideoName,',');					
					$videoCoverImage = ltrim($videoCoverImage,',');					
					
				}
				
				//deleteImage($_POST['extrImageGrp'.$key],'upload/artist/video/'.$_POST['sGiftGrp'.$key]);
			
			}
			else{

				$videoImages1 = $_POST['sVideoImages'.$key];
				$sVideoName = $_POST['sVideoName'.$key];
				$giftImage2 = $_POST['sVideo'.$key];
				
				if ( $_POST['yt'.$key] != "" ) {
					
					$youtubeUrl .= $_POST['yt'.$key].','.$_POST['youtubeUrl01'.$key];
					
				} else {
					
					$youtubeUrl = $_POST['youtubeUrl01'.$key];
					
				}								
			}
			
			if ( $_POST['sGift'.$key] != "") {
				$ids .= $key.',';
			}
			
			
			if ( $_POST['sGift'.$key] != "" ){
						 

				$field = array("sGiftName","sYoutubeUrl","sVideo","sVideoName","sVideoImages");
				$value = array($_POST['sGift'.$key],$youtubeUrl,$giftImage2,$sVideoName,$videoCoverImage);		
				$obj->update($field,$value,"iRollID = ".$key,"rollmaster");
			}
			
			$youtubeUrl = '';
			$sVideoName = '';
			$giftImage2 = '';
			$videoCoverImage = '';
			$n ++;
			

			if ( $_POST['sGift'.$key] != "" ) {
				$gift .= $_POST['sGift'.$key].',';
				
			}
		}

		if ($ids != "" ) {

			$ids = rtrim($ids,',');			
			$arr1 = explode(',',$ids);
	

			$result = array_diff($iRollID,$arr1);

			foreach ( $result as $rid) {
				
				$rowOldVideo55 = $obj->fetchRow('rollmaster','iRollID = '.$rid);
				
				if ($rowOldVideo55['sVideo'] != "" ){ 
					
					$imgDelete02 = explode(',',$rowOldVideo55['sVideo']);
					$sVideoImages5 = explode(',',$rowOldVideo55['sVideoImages']);
					
					foreach($imgDelete02 as $key1){
						deleteImage($key1,'upload/artist/video/'.$rowOldVideo55['sGiftName']);
					}
					
					foreach($sVideoImages5 as $imdnew){
						deleteImage($imdnew,'upload/artist/video/'.$rowOldVideo55['sGiftName']);
					}		
				}
			}
			$obj->delete("rollmaster","iLoginID = ".$objsession->get('gs_login_id')." AND iRollID NOT IN(".$ids.")");	
		}
	
		else
		{
			$obj->delete("rollmaster","iLoginID = ".$objsession->get('gs_login_id')." AND iRollID = '".$key."'");
			
		}
		
		$gift = rtrim($gift,',');

		$fieldNew = array('iGiftID');
		$valueNew = array($gift);
		$obj->update($fieldNew,$valueNew,'iLoginID = '.$objsession->get('gs_login_id'),"usermaster");
	
	}

	if(!empty($sGiftName)){
			
	
		/*$giftImage01 = '';
		
		if($grpSolo > 0){
			
		
		$n = 0;
		
		if ( $gift != '' ) {
			$gift .= ',';
			$gift .= implode(',',$sGiftName);
			
				
		}else{
			
			$gift = implode(',',$sGiftName);
		}
		
		$fieldNew = array('iGiftID');
		$valueNew = array($gift);
		$obj->update($fieldNew,$valueNew,'iLoginID = '.$objsession->get('gs_login_id'),"usermaster");
				
			for($i=0;$i<$grpSolo;$i++) {
				
			
				if($_FILES["giftVideo".$i]['name'] != ''){
					
				
					for($j=0;$j<count($_FILES["giftVideo".$i]['name']);$j++) {
						
					
						if($_FILES["giftVideo".$i]['name'][$j] != ""){
							
							$randno = rand(0,5000);
							$img = $_FILES["giftVideo".$i]['name'][$j];
							$sVideoName .= $_FILES["giftVideo".$i]['name'][$j].',';
							$giftImage01 .= $randno.$img.",";
							
							if ( $_FILES["giftVideoImageAdd".$i]['name'][$j] != "" ) {
								
								//Upload video images
								$tempVid = explode(".", $_FILES["giftVideo".$i]['name'][$j]);
								$tempImge = explode(".", $_FILES["giftVideoImageAdd".$i]['name'][$j]);
								//Image name
								$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
							
							} else {
								$videoCoverImage = ",".$videoCoverImage;
							}
														
							$folderPath =  "../upload/artist/video/".$_POST['sGiftName'][$n];
							$exist = is_dir($folderPath);
						
							if(!$exist) {
								mkdir("$folderPath");
								chmod("$folderPath", 0755);
							}
						
							move_uploaded_file($_FILES["giftVideo".$i]['tmp_name'][$j],$folderPath."/".$randno.$img);	
							
							if ( $_FILES["giftVideoImageAdd".$i]['name'][$j] != "" ) {
								move_uploaded_file($_FILES["giftVideoImageAdd".$i]['tmp_name'][$j],$folderPath."/".$randno.$tempVid[0].'.'.end($tempImge));	
							}
							
							if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
								$fld = array('sVideoName','dCreatedDate');
								$val = array($randno.$img,date('Y-m-d'));
								
								$obj->insert($fld,$val,"videouploaddate");
								
							}
						
						}
					
					}
				
				$giftImage01 = rtrim($giftImage01,',');
				$sVideoName = rtrim($sVideoName,',');
				//$videoCoverImage = rtrim($videoCoverImage,',');
					
				}
			
			$field = array("iLoginID","sGroupType","sGiftName","sVideo","sYoutubeUrl","sVideoName","sVideoImages","dCreatedDate");
			$value = array($objsession->get('gs_login_id'),$roll,$sGiftName[$i],$giftImage01,$youtube[$i],$sVideoName,$videoCoverImage,date('Y-m-d'));		
			$obj->insert($field,$value,"rollmaster");
								
			$sVideoName = '';
			$giftImage01 = '';
			$videoCoverImage = '';
			$n ++;
			
			}			
		
		
		}else{*/
			
			if($grpSolo >= 0){
				
			$n = 0;
				
				

					if ( $gift != '' ) {
					
					$gift .=',';
					$abc=array();
					$abc=explode(',',$gift);
					
					if (in_array($sGiftName[0] , $abc)) {
						
					}
					else
					{
					
						$gift .= implode(',',$sGiftName);
					}
				
				}
				
				$fieldNew = array('iGiftID');
				$valueNew = array($gift);
				$obj->update($fieldNew,$valueNew,'iLoginID = '.$objsession->get('gs_login_id'),"usermaster");
								
				for($i=0;$i<$grpSolo02;$i++) {
					
					if($_FILES["giftVideo".$i]['name'] != ''){
						
						for($j=0;$j<count($_FILES["giftVideo".$i]['name']);$j++) {
							
							if($_FILES["giftVideo".$i]['name'][$j] != ""){
								
								$randno = rand(0,5000);
								$img = $_FILES["giftVideo".$i]['name'][$j];
								$sVideoName .= $_FILES["giftVideo".$i]['name'][$j].',';
								$giftImage01 .= $randno.$img.",";

								if ( $_FILES["giftVideoImageAdd".$i]['name'][$j] != "" ) {
								
								//Upload video images
								$tempVid = explode(".", $_FILES["giftVideo".$i]['name'][$j]);
								$tempImge = explode(".", $_FILES["giftVideoImageAdd".$i]['name'][$j]);
								//Image name
								$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
							
								}


								 else {
								$videoCoverImage = ",".$videoCoverImage;
								}
								
								$folderPath =  "../upload/artist/video/".$_POST['sGiftName'][$i];
								$exist = is_dir($folderPath);
							
								if(!$exist) {
									mkdir("$folderPath");
									chmod("$folderPath", 0755);
								}	
							
								move_uploaded_file($_FILES["giftVideo".$i]['tmp_name'][$j],$folderPath."/".$randno.$img);

								if ( $_FILES["giftVideoImageAdd".$i]['name'][$j] != "" ) {
								move_uploaded_file($_FILES["giftVideoImageAdd".$i]['tmp_name'][$j],$folderPath."/".$randno.$tempVid[0].'.'.end($tempImge));	
								}	
								
								if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
									$fld = array('sVideoName','dCreatedDate');
									$val = array($randno.$img,date('Y-m-d'));
									
									$obj->insert($fld,$val,"videouploaddate");
									
								}
							
							}				
						
						}
									

					
						$giftImage01 = rtrim($giftImage01,',');
							
						$sVideoName = rtrim($sVideoName,',');
						
						$videoCoverImage = rtrim($videoCoverImage,',');
	
			
						if($giftImage01 == "" && $sVideoName == "" && $videoCoverImage == "" && $youtube[$n] == "")
							{
							}
						else
							{
						$rowOldVideo1 = $obj->fetchRow('rollmaster','iLoginID = '.$objsession->get('gs_login_id')." AND sGiftName = '$sGiftName[$n]'");	

						
						$youtubeUrl=$rowOldVideo1['sYoutubeUrl'];
						$youtubeUrl1=$youtubeUrl;
						if($youtubeUrl1 == "")
							{
						$furl=$youtube[$n];
							}
						else
							{
					     $furl=$youtube[$n].','.$youtubeUrl1;
							}
						$roll1=$rowOldVideo1['iRollID'];

						$sVideo=$rowOldVideo1['sVideo'];
						$sVideoName2=$rowOldVideo1['sVideoName'];
						$sVideoImage=$rowOldVideo1['sVideoImages'];
						

						if($sVideo == "")
							{
								$giftImage01 = $giftImage01;
							}
						else
							{
								$giftImage01=$giftImage01.','.$sVideo;
							}
						
						if($sVideoName2 == "")
							{
								$sVideoName = $sVideoName;
							}
						else
							{
								$sVideoName=$sVideoName.','.$sVideoName2; 	
							}

						if($sVideoImage == "")
							{
								$videoCoverImage = $videoCoverImage;
							}
						else
							{
								$videoCoverImage=$videoCoverImage.','.$sVideoImage; 	
							}


								if($youtube[$n] != "" && count($rowOldVideo1) > 0)
								{
									
								$field = array("sYoutubeUrl");
								$value = array($furl);		
								
								$obj->update($field,$value,"iRollID = ".$roll1,"rollmaster");
								}
								
								else if($giftImage01 != "" && $roll1 > 0)
								{
									
									
								$field = array("sVideo","sVideoName","sVideoImages");
								$value = array($giftImage01,$sVideoName,$videoCoverImage);		
								
								$obj->update($field,$value,"iRollID = ".$roll1,"rollmaster");
						
								$sVideoName = '';
								$giftImage01 = '';
								$videoCoverImage = '';
				
								$n ++;
								}

								else
								{

								$field = array("iLoginID","sGroupType","sGiftName","sVideo","sYoutubeUrl","sVideoName","sVideoImages","dCreatedDate");
								$value = array($objsession->get('gs_login_id'),$roll,$sGiftName[$n],$giftImage01,$youtube[$n],$sVideoName,$videoCoverImage,date('Y-m-d'));		
								$obj->insert($field,$value,"rollmaster");
									
								$sVideoName = '';
								$giftImage01 = '';
								$videoCoverImage = '';
				
								$n ++;
								}	
							}
					}
				
				}	

			}
		
		}
	}	
			
		
		if($roll != "" && $roll == 'group'){
			
			$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sGroupType = 'solo'";			
			$obj->delete('rollmaster',$cond);
			
			$giftImage = '';
			$giftImage2 = '';
			
			/*if($iRollIDGrp != ""){
				$iRollIDGrp = explode(',',$iRollIDGrp);
			}else{
				$iRollIDGrp = array();	
			}*/
			if($iRollIDGrp > 0){
			
				$mygift = implode(',',$mygift);
				
								
				$fieldNew = array('iGiftID');
				$valueNew = array($mygift);
				$obj->update($fieldNew,$valueNew,'iLoginID = '.$objsession->get('gs_login_id'),"usermaster");
		
				$n = 1;
				$sMultiImage = '';
				$test = '';
				$sVideoName = '';
				$membername = implode(',',$membername);
				
				if(!empty($dob)){
					$memberAge = implode(',',$dob);
				}else{
					$memberAge = '';	
				}

				$youtube = implode(',',$youtube);
				
										
						for($img = 0;$img <count($_FILES["giftVidGrp"]['name']); $img++){
							if($_FILES["giftVidGrp"]['name'][$img] != ''){

								$randno = rand(0,5000);
								$test = 'yes';
								$img_new = $_FILES["giftVidGrp"]['name'][$img];
								$giftImage2 .= $randno.$img_new.",";		
								$sVideoName .= $_FILES["giftVidGrp"]['name'][$img].',';
								
								if ( $_FILES["giftVidGrpImage"]['name'][$img] != "" ) {
								
									//Upload video images
									$tempVid = explode(".", $_FILES["giftVidGrp"]['name'][$img]);
									$tempImge = explode(".", $_FILES["giftVidGrpImage"]['name'][$img]);
									//Image name
									$videoCoverImage .= $randno.$tempVid[0].'.'.end($tempImge).",";
							
								} else {
									$videoCoverImage = ",".$videoCoverImage;
								}
							
								$folderPath01 = "../upload/artist/video/group";
								$exist = is_dir($folderPath01);
							
							/*if($_POST['sVideo'] != ""){
								$imgDelete = explode(',',$_POST['sVideo']);
								foreach($imgDelete as $key1){
									//deleteImage($key1,'upload/artist/video/group');
								}
							}*/
					
							if(!$exist) {
								mkdir("$folderPath01");
								chmod("$folderPath01", 0755);
							}
						
							move_uploaded_file($_FILES["giftVidGrp"]['tmp_name'][$img],$folderPath01."/".$randno.$img_new);	
							
							if ( $_FILES["giftVidGrpImage"]['name'][$img] != "" ) {
								move_uploaded_file($_FILES["giftVidGrpImage"]['tmp_name'][$img],$folderPath01."/".$randno.$tempVid[0].'.'.end($tempImge));	
							}
							
							if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
								$fld = array('sVideoName','dCreatedDate');
								$val = array($randno.$img,date('Y-m-d'));
								
								$obj->insert($fld,$val,"videouploaddate");
								
							}	
							
							}else{
								//$giftImage2 = $_POST['sVideo'];	
								//$sVideoName = $_POST['sVideoName'];							
							}
						}
						
						/*if($test == ''){
							

						}else{*/
							
							$rowOldVideo = $obj->fetchRow('rollmaster','iLoginID = '.$objsession->get('gs_login_id')." AND sGroupType = 'group'");
							
							$giftImage2 = rtrim($giftImage2,',');
							$sVideoName = rtrim($sVideoName,',');
							$videoCoverImage = rtrim($videoCoverImage,',');
							
							if(!empty($rowOldVideo)){
							
								if($rowOldVideo['sVideo'] != ''){
									
									$giftImage2 .= ','.$rowOldVideo['sVideo'];
									$sVideoName .= ','.$rowOldVideo['sVideoName'];
									//$videoCoverImage .= ','.$rowOldVideo['sVideoImages'];
								}
							
							} else {
								
								$giftImage2 = $_POST['sVideo'];	
								$sVideoName = $_POST['sVideoName'];	
								$videoCoverImage = $_POST['videoCoverImage'];	
									
							}
				
						
						//}
						
						//deleteImage($_POST['extrImageGrp'.$key],'upload/artist/video/'.$_POST['sGiftGrp'.$key]);
					
					if ( $youtube != "" ) {

						$youtubeUrl = $youtube.','.$_POST['sUTV'];

					} else {

						$youtubeUrl = $youtube;

					}
					
					$youtubeUrl = ltrim($youtubeUrl,',');
					$youtubeUrl = rtrim($youtubeUrl,',');
					
					$giftImage2 = ltrim($giftImage2,',');
					$giftImage2 = rtrim($giftImage2,',');
					
					$sVideoName = ltrim($sVideoName,',');
					$sVideoName = rtrim($sVideoName,',');
					
					
			$field = array("sGroupType","iNumberMembers","sGropName","sMemberName","sGiftName","sVideo","sVideoName","sVideoImages","dCreatedDate","sYoutubeUrl","memberAge");
				$value = array($roll,$iNumberMembers,$sGroupName,$membername,$mygift,$giftImage2,$sVideoName,$videoCoverImage,date('Y-m-d'),$youtubeUrl,$memberAge);	
				
			$obj->update($field,$value,"iRollID = ".$iRollIDGrp,"rollmaster");
			//$sMultiImage = '';
			$sVideoName = '';
			$giftImage2 = '';
			$youtubeUrl = '';
			$sVideoImages = '';
			$n ++;
				
				}else{
				
					if(!empty($mygift) != ""){

				
				$gift = rtrim($mygift,',');
				$fieldNew = array('iGiftID');
				$valueNew = array($gift);
				$obj->update($fieldNew,$valueNew,'iLoginID = '.$objsession->get('gs_login_id'),"usermaster");
		
				$n = 1;
				$sMultiImage = '';
				$test = '';
					
				$membername = implode(',',$membername);
				$mygift = implode(',',$mygift);
				$youtube = implode(',',$youtubeGrp);
										
						/*for($img = 0;$img <count($_FILES["giftVidGrp"]['name']); $img++){
							if($_FILES["giftVidGrp"]['name'][$img] != ''){

								$randno = rand(0,5000);
								$test = 'yes';
								$img_new = $_FILES["giftVidGrp"]['name'][$img];
								$giftImage2 .= $randno.$img_new.",";
								$sVideoName .= $_FILES["giftVidGrp"]['name'][$img].',';
								
								$folderPath01 = "../upload/artist/video/group";
								$exist = is_dir($folderPath01);
							
							if($_POST['sVideo'] != ""){
								$imgDelete = explode(',',$_POST['sVideo']);
								foreach($imgDelete as $key1){
									deleteImage($key1,'upload/artist/video/group');
								}
							}
					
							if(!$exist) {
								mkdir("$folderPath01");
								chmod("$folderPath01", 0755);
							}
						
							move_uploaded_file($_FILES["giftVidGrp"]['tmp_name'][$img],$folderPath01."/".$randno.$img_new);	
							
							if ( $obj->fetchRow('videouploaddate',"sVideoName = '".$randno.$img."'") == NULL ) {
						
								$fld = array('sVideoName','dCreatedDate');
								$val = array($randno.$img,date('Y-m-d'));
								
								$obj->insert($fld,$val,"videouploaddate");
								
							}	
							
							}else{
								$giftImage2 = $_POST['sVideo'];	
								$sVideoName = $_POST['sVideoName'];							
							}
						}*/
						if($test == ''){
							$giftImage2 = $_POST['sVideo'];	
								$sVideoName = $_POST['sVideoName'];	
						}else{
						//$giftImage2 = rtrim($giftImage2,',')				;
						//$sVideoName = rtrim($sVideoName,',');
						}
			
			$youtube = ltrim($youtube,',');
			$youtube = rtrim($youtube,',');
			
			$giftImage2 = rtrim($giftImage2,',');
			$sVideoName = rtrim($sVideoName,',');
			
			$field = array("iLoginID","sGroupType","iNumberMembers","sGropName","sMemberName","sGiftName","sVideo","sVideoName","dCreatedDate","sYoutubeUrl","memberAge");
				$value = array($objsession->get('gs_login_id'),$roll,$iNumberMembers,$sGroupName,$membername,$mygift,$giftImage2,$sVideoName,date('Y-m-d'),$youtube,$memberAge);		
				$obj->insert($field,$value,"rollmaster");
				
				
						
						
			$sVideoName = '';
			$giftImage2 = '';
			$n ++;
			
				$giftImage01 = '';
				$giftImage2 = '';
				$sMultiImage = '';
				
		}	
					
				}
			
			
						
		}

		$objsession->set('gs_msg','<p>Profile Updates Successfully</p>');
		redirect(URL.'views/artistaccount.php');			
	
}
?>
<?php /*?><script>
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

</script><?php */?> 
<script>
$(document).ready(function () {
			
			
	$('#selectField').change(function () {
		
		$('#solo').hide();
			$('#group').hide();
			$('#solo-New').show();
		
		if($(this).val() == 'solo'){
			$('#solo').show();
			$('#group').hide();
			$('#AddSolo').show();
		}
		
		if($(this).val() == 'group'){
			$('#solo').hide();
			$('#group').show();
			$('#AddSolo').hide();
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


            $(wrapper).append('<div class="row"><div class="form-group"><label for="mname" class="col-lg-3 control-label">Member Name</label><div class="col-lg-4"><input class="form-control dd" type="text" required="true" name="membername[]" id="mem'+i+'" /></div></div></div><div class="row"><div class="form-group"><label for="role" class="col-lg-3 control-label">Member Talent</label><div class="col-lg-4"><select name="mygift[]" class="form-control mt10"><option value="Accordionist">Accordionist</option><option value="Actor">Actor</option><option value="Actress">Actress</option><option value="Banjo_Player">Banjo Player</option><option value="Bassist">Bassist</option><option value="Bassoonist">Bassoonist</option><option value="Cellist">Cellist</option><option value="Clarinetist">Clarinetist</option><option value="Composer">Composer</option><option value="Dancers">Dancers</option><option value="Drummers">Drummers</option><option value="Flautist">Flautist</option><option value="Guitarist">Guitarist</option><option value="Harmonica_Player">Harmonica Player</option><option value="Harpist">Harpist</option><option value="Mime_Artist">Mime Artist</option><option value="Organist">Organist</option><option value="Percussionist">Percussionist</option><option value="Pianist_keyboardist">Pianist/keyboardist</option><option value="Piccolo_Player">Piccolo Player</option><option value="Poet_Spoken_Word">Poet/Spoken Word</option><option value="Rapper">Rapper</option><option value="Saxophonist">Saxophonist</option><option value="Singer_Vocalist">Singer/Vocalist</option><option value="Song_Writer">Song Writer</option><option value="Saxophonist">Saxophonist</option><option value="Trombonist">Trombonist</option><option value="Trumpeter">Trumpeter</option><option value="Tubist">Tubist</option><option value="Violinist">Violinist</option><option value="Violist">Violist</option></select></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Upload Videos form youtube</label><div class="col-lg-4"><input class="form-control" placeholder="Enter Youtube Link" type="text" class="" name="youtubeGrp[]" id="" /></div></div></div><div class="row"><div class="form-group"><label for="url" class="col-lg-3 control-label">Birth Date</label><div class="col-lg-4"><input class="form-control" type="text" required="true" class="" name="dob[]" id="dob'+i+'" /></div></div></div>'); //add input box

		//document.getElementById("xval").value = x;
		
		$('#dob'+i).datetimepicker({
			format: 'DD-MM-YYYY',
			ignoreReadonly: true,
			disabledDates:[moment().subtract(1,'d')],
		});
		
}
		
		

}
</script> 

					
							

<script>
$(document).ready(function() {

var dynamicid = 0;

$('#AddSolo').click(function() {

if(document.getElementById('grpSolo').value > 0){	
	//dynamicid = document.getElementById('grpSolo').value;	
}
var data = '<div style="border: 1px solid black;float:left">';
data += '<div id="divsolo'+dynamicid+'" class="adddiv">';
data +=           '<div class="row"><div class="form-group">';
data +=           '             <label for="role" class="col-lg-3 control-label">My Talent</label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <select id="sGiftName" class="form-control" name="sGiftName[]">';
								
								<?php
									$drop = $obj->fetchRowAll("giftmaster","isActive = 1");
								if(count($drop) > 0){
								for($c=0;$c<count($drop);$c++){
								$abc=$drop[$c]['sGiftName'];?>

data +=           '				  <option value="<?php echo $abc;?>"><?php echo $abc;?></option>';
										<?php }
							}
			
					?>
data +=           '              </select>			 ';
data +=           '            </div>';
data +=           '        </div></div>';
data +=           '<div class="row">';
data +=           '     <div class="form-group">';
data +=           '            <label for="role" class="col-lg-3 control-label">Upload Talent Video Image</label>';
data +=           '                <div class="col-lg-4">';
data +=           '                  <input type="file" accept="image/*" name="giftVideoImageAdd'+dynamicid+'[]" multiple="" class="form-control file uploadsvideoimage" id="abc"/>';
data +=           '				<span id="msg"></span>';
data +=           '</div>';
data +=           '</div>';
data +=           '</div>';
data +=           '<div class="row">';
data +=           '<div class="form-group">';
data +=           '<label for="role" class="col-lg-3 control-label">Upload Talent Video</label>';
data +=           '<div class="col-lg-4">';
data +=           '<input type="file" name="giftVideo'+dynamicid+'[]" multiple="" class="form-control uploadsvideo file" id="abc1"/>';
data +=           '				<span id="msg1"></span>';
data +=           '</div>';
data +=           '</div>';
data +=           '</div>';
data +=           '        <div class="row"><div class="form-group">';
data +=           '            <label for="role" class="col-lg-3 control-label"></label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="text" name="youtube[]" class="form-control" placeholder="Enter YouTube URL Only" id="abc2" />';
data +=           '				<span id="msg2"></span>';
data +=           '            </div>';
data +=           '            <div class="col-lg-4">';
data +=           '               <a class="Solo-Remove remove" onclick="soloremove(this)" id="'+dynamicid+'">Remove Talent</a>';
data +=           '            </div>';
data +=           '          </div>';
data +=           '        </div></div></div>';
	
	$('#solo-New').append(data);
	$('#solo-New').show();	
	//dynamicid ++;
	
var v = 0;
	
$(".adddiv").each(function() {
	v =	$(this).attr('id');
});

	dynamicid = (v.match(/\d+/));
	dynamicid ++;
//alert(dynamicid);
	
	document.getElementById('grpSolo').value = dynamicid;
	document.getElementById('grpSolo02').value = dynamicid;
	

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

if(document.getElementById('grpSolo').value > 0){
var dynamicid = document.getElementById('grpSolo').value;
document.getElementById('grpSolo').value = (dynamicid - 1);
document.getElementById('grpSolo02').value = (dynamicid - 1);
}
var objId= obj.id.toString();
$("#divsolo"+objId).remove();
	}
}
</script>




<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>