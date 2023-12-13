<?php include('../include/header.php'); ?>
<script type="text/javascript" src="<?php echo URL;?>js/rhinoslider-1.05.min.js"></script>
<script src="<?php echo URL;?>js/areamanage.js"></script>

<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
    <h4 class="h4">USER REGISTRATION</h4>
<?php if($objsession->get('gs_msg') != ""){?>
<div class="suc-message">
<?php echo $objsession->get('gs_msg');?>
</div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}
?> 
  </div>
</div>
<div class="container"> 
<style type="text/css">
		#personal_information,
		#company_information{
			display:none;
		}
	</style>
<script>
$(document).ready(function() {
	$('#dateRangePicker').datetimepicker({
		//locale: "en-GB",
		format: 'DD-MM-YYYY',
		//minDate: moment().subtract(1,'d'),
		//ignoreReadonly: true,
		//disabledDates:[moment().subtract(1,'d')],
		
	});		
});
</script>
<script type="text/javascript">
            $(document).ready(function() {
                $('#slider').rhinoslider({
                    controlsPlayPause: false,
                    showControls: 'always',
                    showBullets: 'always',
                    controlsMousewheel: false,
                    prevText: 'Back',
                    nextText:'Proceed',
		    		slidePrevDirection: 'toRight',
					slideNextDirection: 'toLeft',
					controlsKeyboard: false
					
                });

                $(".rhino-prev").hide();
				$('.rhino-next').after('<a class="form-submit" href="javascript:void(0);" >Proceed</a>');
				$(".rhino-next").hide();

            });

			$(document).on('click', '.form-submit', function(){
                $('.form-error').html("");
                var current_tab = $('#slider').find('.rhino-active').attr("id");
                switch(current_tab){
                    case 'rhino-item0':
                        step1_validation();
                        break;
                    case 'rhino-item1':
                        step2_validation();
                        break;
                }	
            });

function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match.
        //Set the color to the good color and inform
        //the user that they have entered the correct password
        //pass2.style.backgroundColor = goodColor;
        message.style.color = "#66cc66";
		var d = document.getElementById("confirmMessage");
		d.className = " pass_suc";
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
//        pass2.style.backgroundColor = badColor;
        message.style.color = "#ff6666";
        message.innerHTML = "Passwords Do Not Match!"
    }
}  
            var step1_validation = function(){

                var err = 0;

                if($('#fname').val() == ''){
                    $('#fname').parent().parent().find('.form-error').html("First Name is Required");
                    err++;
                }
                if($('#lname').val() == ''){
                    $('#lname').parent().parent().find('.form-error').html("Last Name is Required");
                    err++;
                }
				
				if($('#pass1').val() == ''){
                    $('#pass1').parent().parent().find('.form-error').html("Password is Required");
                    err++;
                }else if($('#pass1').val().length < 6){
					$('#pass1').parent().parent().find('.form-error').html("Password minimum lenght is 6");
                    err++;
				}else if($('#pass1').val().length > 32){
					$('#pass1').parent().parent().find('.form-error').html("Password maximum lenght is 32");
                    err++;
				}
                if($('#pass2').val() == ''){
                    $('#pass2').parent().parent().find('.form-error').html("confirm Password is Required");
                    err++;
                }
                if($('#gender').val() == '0'){
                    $('#gender').parent().parent().find('.form-error').html("Please Select Gender");
                    err++;
                }
								

			var email = document.getElementById('txtEmail');
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;			
					if (!filter.test(email.value)) {									
						$('#txtEmail').parent().parent().find('.form-error').html("Enter Valid Email Address ");
						//err++;                						
					email.focus;
					return false;
				 }
				 
                if(err == 0){
                    $(".rhino-active-bullet").removeClass("step-error").addClass("step-success");
                    $(".rhino-next").show();
                    $('.form-submit').hide();
                    $('.rhino-next').trigger('click');
                }else{
                    $(".rhino-active-bullet").removeClass("step-success").addClass("step-error");
                }


            };
			
			var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }

            var step2_validation = function(){
                var err = 0;

                if($('#username').val() == ''){
                    $('#username').parent().parent().find('.form-error').html("Username is Required");
                    err++;
                }
				
				if($('#dateRangePicker').val() == ''){
                    $('#dateRangePicker').parent().parent().find('.form-error').html("BirthDate is Required");
                    err++;
                }
				
				if($('#zipcode').val() == ''){
                    $('#zipcode').parent().parent().find('.form-error').html("zipcode is Required");
                    err++;
                }
                if($('#pass').val() == ''){
                    $('#pass').parent().parent().find('.form-error').html("Password is Required");
                    err++;
                }
                if($('#cpass').val() == ''){
                    $('#cpass').parent().parent().find('.form-error').html("confirm Password is Required");
                    err++;
                }
                if(err == 0){
                    $(".rhino-active-bullet").removeClass("step-error").addClass("step-success");
                    $(".rhino-next").show();
                    $('.form-submit').hide();
                    $('.rhino-next').trigger('click');
					
					$("#regForm").submit();

                }else{
                    $(".rhino-active-bullet").removeClass("step-success").addClass("step-error");
                }
            };

          
        </script>
  
  <form method="post" enctype="multipart/form-data" id="regForm" >
    <div id="slider" class="">
      <div class="col-lg-12 col-md-12 col-sm-12 p70 mt20">
        <label>Step 1</label>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="username">First Name<span>*</span></label>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
              <input type="text" id="fname" name="fname" class="form-control"  />              
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="lastname">Last Name<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input type="text" id="lname" name="lname" class="form-control" />
          </div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="lastname">Email<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input type="text" id="txtEmail" name="email" class="form-control" />
          </div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="pass">Password<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input name="pass" id="pass1" type="password" pattern=".{0}|.{6,32}" placeholder="6 to 32 char" class="form-control" >
          </div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="pass">Confirm Password<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input name="pass" id="pass2" onKeyUp="checkPass(); return false;" type="password" class="form-control">
            <span id="confirmMessage" class="confirmMessage"></span></div>
          <div class="form-error"></div>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label" for="pass">Upload Your Profile</label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
        <input type='file' class="form-control file" name="filesone" />
        </div>
        <!-- four  end --> 
        
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 p70 mt20">
      <label>Step 2</label>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="pass">Username<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input type="text" id="username" onKeyPress="return handleEnter(this, event)" name="username" class="form-control"  onfocus="showDiv('div1');" onBlur="hideDiv('div1');" title="Your Username Will be Displayed When you Leave Comment on Videos"/>
          </div>
          <div id="div1" style="display:none; background: #333 none repeat scroll 0 0;border: 1px solid #000;color: #fff;    display: none;float: right;margin: 15px !important;width: 58%;">Your Username Will be Displayed When you Leave Comment on Videos</div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label" for="pass">BirthDate</label></div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
          <div class='input-date' id='edToDate'>
            <input  type="text" id="dateRangePicker" name="birthdate" class="form-control" placeholder="dd-mm-yyyy" />
           </div>
          </div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label" for="pass">Country</label> </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
          <select name="country" class="form-control countries" id="countryId">
            <option value="">Select Country</option>
          </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label" for="pass">State</label> </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
          <select name="state" class="form-control states" id="stateId">
            <option value="">Select State</option>
          </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label" for="pass">City </label></div>
          <div class="form-right">
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <select name="city" class="form-control cities" id="cityId">
              <option value="">Select City</option>
            </select>
            </div>
          </div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label user" for="pass">Zipcode<span>*</span></label></div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input type="text" name="zipcode" class="form-control"  id="zipcode"/>
            </div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="form-right" style="float:right;">

          </div>
          <div class="form-error"></div>
        </div>
      </div>
    </div>
  </form> 
  
<script type="text/javascript">
		$(document).ready(function(){

			// Custom method to validate username
			$.validator.addMethod("usernameRegex", function(value, element) {
				return this.optional(element) || /^[a-zA-Z0-9]*$/i.test(value);
			}, "Username must contain only letters, numbers");

			$(".next").click(function(){
				var form = $("#myform");
				form.validate({
					errorElement: 'span',
					errorClass: 'help-block',
					highlight: function(element, errorClass, validClass) {
						$(element).closest('.form-group').addClass("has-error");
					},
					unhighlight: function(element, errorClass, validClass) {
						$(element).closest('.form-group').removeClass("has-error");
					},
					rules: {
						username: {
							required: true,
							usernameRegex: true,
							minlength: 6,
						},
						password : {
							required: true,
						},
						conf_password : {
							required: true,
							equalTo: '#password',
						},
						company:{
							required: true,
						},
						url:{
							required: true,
						},
						name: {
							required: true,
							minlength: 3,
						},
						email: {
							required: true,
							minlength: 3,
						},
						
					},
					messages: {
						username: {
							required: "Username required",
						},
						password : {
							required: "Password required",
						},
						conf_password : {
							required: "Password required",
							equalTo: "Password don't match",
						},
						name: {
							required: "Name required",
						},
						email: {
							required: "Email required",
						},
					}
				});
				if (form.valid() === true){
					if ($('#account_information').is(":visible")){
						current_fs = $('#account_information');
						next_fs = $('#company_information');
					}else if($('#company_information').is(":visible")){
						current_fs = $('#company_information');
						next_fs = $('#personal_information');
					}
					
					next_fs.show(); 
					current_fs.hide();
				}
			});

			$('.previous').click(function(){
				if($('#company_information').is(":visible")){
					current_fs = $('#company_information');
					next_fs = $('#account_information');
				}else if ($('#personal_information').is(":visible")){
					current_fs = $('#personal_information');
					next_fs = $('#company_information');
				}
				next_fs.show(); 
				current_fs.hide();
			});
			
		});
	</script> 
<form class="form-horizontal" action="" method="POST" id="myform">

				<fieldset id="account_information" class="">
					<legend>Account information</legend>
					<div class="form-group">
						<label for="username" class="col-lg-4 control-label">Username</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="username" name="username" placeholder="username">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-lg-4 control-label">Password</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_password" class="col-lg-4 control-label">Confirm password</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="Password">
						</div>
					</div>
					<p><a class="btn btn-primary next">next</a></p>
				</fieldset>

				<fieldset id="company_information" class="">
					<legend>Account information</legend>
					<div class="form-group">
						<label for="company" class="col-lg-4 control-label">Company</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="company" name="company" placeholder="Company">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-lg-4 control-label">Website url</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="url" name="url" placeholder="Website url">
						</div>
					</div>
                    <p><a class="btn btn-primary previous" id="previous" >Previous</a></p>
					<p><a class="btn btn-primary next">next</a></p>
				</fieldset>

				<fieldset id="personal_information" class="">
					<legend>Personal information</legend>
					<div class="form-group">
						<label for="name" class="col-lg-4 control-label">Name</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="name" name="name" placeholder="Name">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-lg-4 control-label">Email</label>
						<div class="col-lg-8">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email">
						</div>
					</div>
					<p><a class="btn btn-primary previous" id="previous" >Previous</a></p>
					<p><input class="btn btn-success" type="submit" value="submit"></p>
				</fieldset>

			</form>
</div>


<?php
if(isset($_POST['fname'])){
	extract($_POST)	;
	
	$cond="(sEmailID = '".$email."' AND sUserType = 'user') AND isActive = 1";
    $loginrow = $obj->fetchRow('loginmaster',$cond);
		
	if(count($loginrow) > 0){			
		$objsession->set('gs_error_msg','This email already existing.');			
		redirect(URL.'views/user.php');
	}	
	else{
		
		$field = array("sEmailID","sPassword","sUserType","isActive");
		$value = array($email,md5($pass),'user',0);		
		$iLoginID = $obj->insert($field,$value,"loginmaster");
		
		$userImage = '';
		 					
		if($_FILES["filesone"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["filesone"]["name"];
			$userImage = $randno.$img;
			
			move_uploaded_file($_FILES['filesone']['tmp_name'],"../upload/user/".$userImage);			
		}
			
		$field = array("iLoginID","sFirstName","sLastName","sProfileName","sUserName","dDOB","iCountryID","iStateID","iCityID","iZipcode","dCreatedDate","isActive");
		$value = array($iLoginID,$fname,$lname,$userImage,$username,date('Y-m-d',strtotime($birthdate)),$country,$state,$city,$zipcode,date("Y-m-d"),0);		
		$obj->insert($field,$value,"usermaster");
		
		$objsession->set('gs_login_id',$iLoginID);	
		$objsession->set('gs_msg','<p>Hello,</p><p>Thanks for the Registration. Your details will be verified with admin and you will be notified once it approve.</p><br><p>Thanks,</p><strong>Gospel Team</strong>');			
		redirect(URL.'views/myaccount.php');			
	}
}
?>
