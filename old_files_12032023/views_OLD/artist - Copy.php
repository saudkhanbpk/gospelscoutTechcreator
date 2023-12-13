<?php include('../include/header.php'); ?>
<script type="text/javascript" src="<?php echo URL;?>js/rhinoslider-1.05.min.js"></script>

<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
    <h4 class="h4">ARTIST REGISTRATION</h4>
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
					case 'rhino-item2':
                        step3_validation();
                        break;
				    case 'rhino-item3':
                        step4_validation();
                        break;
					case 'rhino-item4':
                        step5_validation();
                        break;
					case 'rhino-item5':
                        step6_validation();
                        break;
				   	case 'rhino-item6':
                        step7_validation();
                        break;
				   case 'rhino-item7':
                        step8_validation();
                        break;
                }	
            });

function checkPass()
{
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    var message = document.getElementById('confirmMessage');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";

    if(pass1.value == pass2.value){
		 message.style.color = "#66cc66";
        message.innerHTML = "Passwords Match!"
    }else{
		 message.style.color = badColor;
        message.innerHTML = "Passwords and confirm password not match"
    }
}  
            var step1_validation = function(){

                var err = 0;
                if($('#fname').val() == ''){
                    $('#fname').parent().parent().find('.form-error').html("Firstname is Required");
                    err++;
                }
                if($('#lname').val() == ''){
                    $('#lname').parent().parent().find('.form-error').html("Lastname is Required");
                    err++;
                }
				if($('#username').val() == ''){
                    $('#username').parent().parent().find('.form-error').html("Username is Required");
                    err++;
                }				
				if($('#pass1').val() == ''){
                    $('#pass1').parent().parent().find('.form-error').html("Password is Required");
                    err++;
                }
                if($('#pass2').val() == ''){
                    $('#pass2').parent().parent().find('.form-error').html("Confirm Password is Required");
                    err++;
                }
				
			var pass11 = document.getElementById('pass1');
			var pass22 = document.getElementById('pass2');
			if (pass11.value != pass22.value) { 
				pass2.focus();
				return false; 
			}
	
					var email = document.getElementById('txtEmail');
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;			
					if (!filter.test(email.value)) {									
						$('#txtEmail').parent().parent().find('.form-error').html("Enter valid email address");
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

				if($('#dateRangePicker').val() == ''){
                    $('#dateRangePicker').parent().parent().find('.form-error').html("Birthdate is required");
                    err++;
                }
				
				var zipcode = document.getElementById('zipcode');
					var filter = /^\d{5}$/;			
					if (!filter.test(zipcode.value)) {									
						$('#zipcode').parent().parent().find('.form-error').html("Zipcode must contain 5 digits.");
					zipcode.focus;
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

            var step3_validation = function(){

                var err = 0;
				
				if($('#my_file').val() == ''){
					$('#my_file').parent().parent().find('.form-error').html("Upload profile image");
					err++;
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
			
			
			var step4_validation = function(){
                var err = 0;

                /*if($('#email').val() == ''){
                    $('#email').parent().parent().find('.form-error').html("Email is Required");
                    err++;
                }*/
                if(err == 0){
                    $(".rhino-active-bullet").removeClass("step-error").addClass("step-success");
                    $(".rhino-next").show();
                    $('.form-submit').hide();
                    $('.rhino-next').trigger('click');
                }else{
                    $(".rhino-active-bullet").removeClass("step-success").addClass("step-error");
                }

            };
			var step5_validation = function(){
                var err = 0;

                
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
	
	var max_fields      = 500; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = document.getElementById("xval").value; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="mt10"><input class="form-control mt10" type="text" class="" name="youtube['+x+']" id="" placeholder="Enter only youtube url" /><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }		
		document.getElementById("xval").value = x;
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
		document.getElementById("xval").value = x;
    })
	
});


function loadText(nolist){
	
	var max_fields      = 500; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap01"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
   var x = nolist;
   $(wrapper).html('');
for(var i=1;i<=x;i++)
{


            $(wrapper).append('<div class="mt10"><input class="form-control" type="text" class="" name="youtube['+x+']" id="" placeholder="Enter Group member name" /><select name="mygift[]" class="form-control mt10"><option selected="selected">Select Gift</option><option value="bassplayers">bass players</option><option value="Dancers">Dancers</option><option value="Drummers">Drummers</option><option value="Flute">Flute</option><option value="Guitarists">Guitarists</option><option value="Horn players">Horn players</option><option value="Saxophone">Saxophone</option><option value="Trombone">Trombone</option><option value="Trumpet">Trumpet</option><option value="Keys">Keys</option><option value="Mime">Mime</option><option value="Percussions">Percussions</option><option value="Singers">Singers</option><option value="Violin">Violin</option></select></div>'); //add input box

		//document.getElementById("xval").value = x;
}
}
</script>

  <form method="post" enctype="multipart/form-data" id="regForm" >
    <div id="slider">
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
              <label class="control-label user" for="pass">Username<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input type="text" id="username" onKeyPress="return handleEnter(this, event)" name="username" class="form-control"  onfocus="showDiv('div1');" onBlur="hideDiv('div1');" title="Your Username Will be Displayed When you Leave Comment on Videos"/>
          </div>
          <div id="div1" style="display:none; background: #333 none repeat scroll 0 0;border: 1px solid #000;color: #fff;    display: none;float: right;margin: 15px !important;width: 58%;">Your Username Will be Displayed When you Leave Comment on Videos</div>
          <div class="form-error"></div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label user" for="pass">Password<span>*</span></label>
            </div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input name="pass" id="pass1" type="password" placeholder="6 to 32 char" class="form-control" >
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
        
        
        
        <!-- four  end --> 
        
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 p70 mt20 user">
        <label>Step 2</label>
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label" for="pass">BirthDate</label><span>*</span></div>
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
          <div class="col-sm-2 col-md-2 col-lg-2 form-left"><label class="control-label" for="pass">Zipcode</label><span>*</span></div>
          <div class="col-sm-10 col-md-10 col-lg-10 form-right">
            <input type="text" name="zipcode" class="form-control"  id="zipcode"/>
            </div>
          <div class="form-error" id="zip_error"></div>
        </div>        
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 p70 mt20 user">
      <label>Step 3</label>
        <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2 form-left">
        	<label class="control-label" for="pass">Upload Your Profile</label><span>*</span>
        </div>
<script>
function readURL(input) {
	if ( window.FileReader && window.File && window.FileList && window.Blob )
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();
	
		reader.onload = function (e) {
		$('#blah')
		.attr('src', e.target.result)
		};
	
		reader.readAsDataURL(input.files[0]);
		}
	}
}
</script>
<style>
.sadsd{display:block;}

</style>
<script>
function display_selectrollprofile(){
	document.getElementById('blah').style.display = "none";
	document.getElementById('my_file').value = '';
		document.getElementById('remove_itemprofile').style.display = 'none';
}
</script>	
<script>
$(document).ready(function() {
	document.getElementById('result').style.display = 'none';
	document.getElementById('remove_itemprofile').style.display = 'none';
document.getElementById('image_upload').onclick = function() {
    document.getElementById('my_file').click();
};
});
</script>
<script>
function display_selectrollprofileaaa() {
	document.getElementById('remove_itemprofile').style.display = 'block';
	document.getElementById('blah').style.display = "block";
}
</script>
<style>
#my_file {
	display: none;
}
#get_file {
	background: #f9f9f9;
	border: 5px solid #88c;
	padding: 15px;
	border-radius: 5px;
	margin: 10px;
	cursor: pointer;
}
#result {
  height: 250px !important;
  overflow: scroll;
}
#result > div img {
  width: 37% !important;
}
</style> 
<script type="text/javascript">

window.onload = function () {

//Check File API support
	if (window.File && window.FileList && window.FileReader)
	{
		
		var filesInput = document.getElementById("multi_upload");
		filesInput.addEventListener("change", function (event) {
		
		document.getElementById('result').style.display = 'block';	
		document.getElementById("result").innerHTML = '';
		
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
			/*div.style.width = "14%";
			div.style.display = "block";
			div.style.cssFloat = "left";
			div.style.margin = "0 0 0 10px";*/
			div.innerHTML = "<img  class='thumbnail' src='" + picFile.result + "'" +
			"title='" + picFile.name + "'/> <a href='javascript:void(0)' class='remove_pict'>Remove</a>";
			output.insertBefore(div, null);
			div.children[1].addEventListener("click", function (event) {
			div.parentNode.removeChild(div);
			
			});
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
</script>
        <div class="col-sm-10 col-md-10 col-lg-10 form-right">
        	<input type="file" name="image_upload" id="my_file" onClick="display_selectrollprofileaaa();" multiple="false" onChange="readURL(this);" accept="image/x-png, image/gif, image/jpeg" />
	<input type="button" id="image_upload" value="Browse file">
          
		  <div id="blah2"></div>
		   <a href="javascript:void(0)" onClick="display_selectrollprofile();" class='removeprofile' id="remove_itemprofile" style="color:#FF0000;">Remove</a>
		  <div><img id="blah" class="sadsd" src="#" alt="&nbsp" style="display: block;height: 80px !important;margin: 8px 0 3px !important;width: 100px !important;"/>
		  
		  </div>
        </div>   
        <div class="form-error"></div>     
        </div>
        <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label" for="pass">Upload Multiple Images</label>
            </div>
        <div class="col-sm-10 col-md-10 col-lg-10 form-right">
        	<input type="file" name="multi_upload[]" id="multi_upload"  multiple="false" />
		  <output id="result" />
        
        </div>        
        </div>        
      </div>     
      <div class="col-lg-12 col-md-12 col-sm-12 p70 mt20">
        <label>Step 4</label>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label" for="username">Role</label>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
              <select id="selectField" name="roll" class="form-control" >
                <option id="selectroll" value="selectroll" selected>Select Roll</option>
                <option value="solo" >Solo</option>
                <option value="group" >Group</option>
              </select>              
            </div>
            <div class="form-error"></div>
          </div>
        </div>        
        
        <div id="solo" style="display:none;">
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label" for="username">My Gift</label>             
            </div>
            <div class="col-sm-8 col-md-8 col-lg-8 form-right">
               <select onkeypress="return handleEnter(this, event)" class="form-control" name="mygift[]"  >
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
            <div class="col-sm-2 col-md-2 col-lg-2">
               <a id="AddSolo" >Add More Gift</a>
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
               <input type="text" name="youtube" class="form-control" placeholder="Enter only youtube url" />
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
              <div id="solo" class="box">
               <input type="file" class="form-control file" name="videolink" />			 
            </div>              
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        </div>
        
        <div id="solo-New" style="display:none;">
        
        </div>
        
        
        <div id="group" style="display:none;">        
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
             
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
              <div id="Group" class="box">
                    <select id="id_of_select1" class="form-control" onChange="loadText(this.value);" >  
                    <option selected="selected" value="0">Select Number Of Person</option>
                    <?php 
					for($i=1;$i<=1;$i++){
					?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>                    
                    <?php } ?>
                    </select>
                    <div class="input_fields_wrap01"></div>
             </div>              
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
            <label class="control-label" for="username">Upload video from youtube</label>
            <input type="hidden" name="xval" value="1" id="xval" />
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
               <input type="text" class="form-control" name="youtube[]" placeholder="Enter only youtube url" />
               <div class="input_fields_wrap"></div>
               <br />
               <a href="" class="add_field_button">Add</a>
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
            <label class="control-label" for="username">Upload video from computer</label>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
              <div id="solo" class="box">
               <input type="file" class="form-control file" name="videolink[]" />			 
            </div>              
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        </div>
        
        
        <!-- four  end --> 
        
      </div>      
      <div class="col-lg-12 col-md-12 col-sm-12 p70 mt20 user">
        <label>Step 5</label>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2 form-left">
              <label class="control-label" for="username">Availability<span>*</span></label>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 form-right">
              <select name="availability[]" class="form-control" >
			   <option selected="selected">Select Availability</option>
                <option value="Currently gigging">Currently Gigging(Not excepting new gigs)</option>
                <option value="Looking for gigs">Looking For Gigs(Currently excepting new gigs)</option>
                <option value="Will play for food">Will Play for Food (Just Cover my cost to get there and back)</option>
                <option value="Will play for free">Will Play for Free </option>
              </select>              
            </div>
            <div class="form-error"></div>
          </div>
        </div>
        <div class="row">
          <div class="form-right" style="float:right;">
           <!--<input type="submit" name="btn_reg" id="btn_reg" value="Reg" style="display:none;" />-->
          </div>
<!--          <div class="form-error"></div>-->
        </div>
        <!-- four  end --> 
        
      </div>
      
    </div>
  </form> 
</div>
<?php
if(isset($_POST['fname'])){
	extract($_POST)	;
	
	$cond="(sEmailID = '".$email."' AND sUserType = 'user') AND isActive = 1";
    $loginrow = $obj->fetchRow('loginmaster',$cond);
		
	if(count($loginrow) > 0){			
		$objsession->set('gs_error_msg','This email already existing.');			
		redirect(URL.'views/artist.php');
	}	
	else{
		
		$field = array("sEmailID","sPassword","sUserType","isActive");
		$value = array($email,md5($pass),'user',0);		
		$iLoginID = $obj->insert($field,$value,"loginmaster");
		/*
		$userImage = '';
		 					
		if($_FILES["filesone"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["filesone"]["name"];
			$userImage = $randno.$img;
			
			move_uploaded_file($_FILES['filesone']['tmp_name'],"../upload/user/".$userImage);			
		}
			
		$field = array("iLoginID","sFirstName","sLastName","sProfileName","sUserName","dDOB","iCountryID","iStateID","iCityID","iZipcode","dCreatedDate","isActive");
		$value = array($iLoginID,$fname,$lname,$userImage,$username,$birthdate,$country,$state,$city,$zipcode,date("Y-m-d"),0);		
		$obj->insert($field,$value,"usermaster");*/
		
		$objsession->set('gs_login_id',$iLoginID);	
		$objsession->set('gs_msg','<p>Hello,</p><p>Thanks for the Registration.</p><br><p>Thanks,</p><strong>Gospel Team</strong>');			
		redirect(URL.'views/myaccount.php');			
	}
}
?>
<script>

$(document).ready(function() {
	

	
var dynamicid=1;
$('#AddSolo').click(function() {

	var data = '<div id="divsolo'+dynamicid+'"><div class="row">';
data +=           '<div class="form-group">';
data +=           '            <div class="col-sm-2 col-md-2 col-lg-2 form-left">';
data +=           '              <label class="control-label" for="username">My Gift</label>             ';
data +=           '            </div>';
data +=           '            <div class="col-sm-8 col-md-8 col-lg-8 form-right">';
data +=           '               <select onkeypress="return handleEnter(this, event)" class="form-control" name="mygift[]"  >';
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
data +=           '            <div class="col-sm-2 col-md-2 col-lg-2">';
data +=           '               <a class="Solo-Remove" onclick="soloremove(this)" id="'+dynamicid+'">Remove</a>';
data +=           '            </div>';
data +=           '            <div class="form-error"></div>';
data +=           '          </div>';
data +=           '        </div>';
data +=           '        <div class="row">';
data +=           '          <div class="form-group">';
data +=           '            <div class="col-sm-2 col-md-2 col-lg-2 form-left">';
data +=           '            </div>';
data +=           '            <div class="col-sm-10 col-md-10 col-lg-10 form-right">';
data +=           '               <input type="text" name="youtube" class="form-control" placeholder="Enter only youtube url" />';
data +=           '            </div>';
data +=           '            <div class="form-error"></div>';
data +=           '          </div>';
data +=           '        </div>';
data +=           '        <div class="row">';
data +=           '          <div class="form-group">';
data +=           '            <div class="col-sm-2 col-md-2 col-lg-2 form-left">';
data +=           '            </div>';
data +=           '            <div class="col-sm-10 col-md-10 col-lg-10 form-right">';
data +=           '              <div id="solo" class="box">';
data +=           '               <input type="file" class="form-control file" name="videolink" />			 ';
data +=           '            </div>              ';
data +=           '            </div>';
data +=           '            <div class="form-error"></div>';
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
