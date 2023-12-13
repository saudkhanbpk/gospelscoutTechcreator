<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>
<style>
.serviceRemove
{
	float:right;
}
</style>

<script type="text/javascript" src="<?php echo URL;?>js/rhinoslider-1.05.min.js"></script>
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
	long.value = position.coords.longitude;
	
}
</script>
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
    <h4 class="h4">CHURCH REGISTRATION</h4>
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
  </div>
</div>
<div class="container"> 
<script>
$(document).ready(function() {
	$('#dDob').datetimepicker({
		//locale: "en-GB",
		format: 'DD-MM-YYYY',
		//minDate: moment().subtract(1,'d'),
		//ignoreReadonly: true,
		//disabledDates:[moment().subtract(1,'d')],
		
	});		
	
	$('#sFounderName').datetimepicker({
		//locale: "en-GB",
		format: 'DD-MM-YYYY',
		//minDate: moment().subtract(1,'d'),
		//ignoreReadonly: true,
		//disabledDates:[moment().subtract(1,'d')],
		
	});
});
</script> 
<script type="text/javascript">
$(document).ready(function(){
		 $("#cslide-slides").cslide();	
	$("#img").hide();
	// Custom method to validate username
	$.validator.addMethod("usernameRegex", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9]*$/i.test(value);
	}, "Username must contain only letters, numbers");

});

function ValidationForm()
	{
		var flag = true;
	//$(".next").click(function(){
		
		var form = $("#myform");
		form.validate({
			
			errorElement: "span",
			errorClass: 'help-block',
			highlight: function(element, errorClass, validClass) {
				$(element).closest('.form-group').addClass("has-error");
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).closest('.form-group').removeClass("has-error");
			},
			rules: {
				sFirstName: {
					required: true,
				},
				sLastName: {
					required: true,
				},
				sEmailID: {
					required: true,
					email: true,
					remote:{
						url : 'validmail'	,
						type: 'post',
					}
				},					
				sPassword01 : {
					required: true,
					minlength: 6,
					maxlength: 32,
				},
				conf_password : {
					required: true,
					equalTo: '#sPassword01',
				},
				sProfile: {
					required: true,
					extension: "png|jpg|jpeg",
				},
				company:{ 
					required: true,
				},
				/*sUserName: {
					required: true,
					usernameRegex: true,							
				},*/
				dDob: {
					required: true,
				},
				iZipcode : {
					required: true,
					//number: true,
					//minlength: 5,
				},
				sChurchName: {
					required: true,
				},
				sPastorName: {
					required: true,
				},
				sAddress: {
					required: true,
				},
				/*'ChurchAminity[]': {
					required: true,
				},*/
				
				/*hidename: {
					required: true,
				},	*/
				availability: {
					required: true,
				},					
			},
			messages: {
				sFirstName: {
					required: "Firstname required",
				},
				sLastName: {
					required: "Lastname required",
				},
				sEmailID: {
					required: "Email required",
					email: "Enter valid email",
					remote: "Enter valid email",
				},						
				sPassword01 : {
					required: "Password required",
				},
				conf_password : {
					required: "Password required",
					equalTo: "Password don't match",
				},
				sProfile: {
					required: "Profile image required",
					extension: "Upload only PNG | JPG | JPEG image only",
				},
				/*sUserName: {
					required: "Username required",
				},*/
				dDob: {
					required: 'Please select Bithdate',
				},
				iZipcode : {
					required: "Zipcode required",
					//number: 'Only number required',
					//minlength: "Minimum 5 degit required",
				},
				sChurchName: {
					required: 'Please enter church name',
				},
				sPastorName: {
					required: 'Please enter pastor name',
				},
				sAddress: {
					required: 'Please enter church address',
				},
				/*'ChurchAminity[]': {
					required: 'Please select church amenitis ',
				},*/
				//hidename: "Please select valid username",
				availability: {
					required: "Availability required",
				},
			},
			
			errorPlacement: function(error, element) 
			{	 
			if (element.attr("name") == "hidename") 
			{
			error.insertAfter("span#validusername");
			}
			else {
			error.insertAfter(element);
			}			
			},
		});
		if (form.valid() === true){
			if ($('#account_information').is(":visible")){
				current_fs = $('#account_information');
				next_fs = $('#account_information1');
			}else if ($('#account_information1').is(":visible")){
				current_fs = $('#account_information1');
				next_fs = $('#account_information2');
			}else if ($('#account_information2').is(":visible")){
				current_fs = $('#account_information2');
				next_fs = $('#account_information3');
			}else if ($('#account_information3').is(":visible")){
				current_fs = $('#account_information3');
				next_fs = $('#account_information4');
			}else if ($('#account_information4').is(":visible")){
				current_fs = $('#account_information4');
				next_fs = $('#account_information5');
			}
								
			next_fs.show(); 
			current_fs.hide();
			flag = true;
		}else{
			flag = false;	
		}
	return flag;
	//});
	
	}

	/*$('.previous').click(function(){
		if($('#account_information1').is(":visible")){
			current_fs = $('#account_information1');
			next_fs = $('#account_information');
		}else if($('#account_information2').is(":visible")){
			current_fs = $('#account_information2');
			next_fs = $('#account_information1');
		}else if($('#account_information3').is(":visible")){
			current_fs = $('#account_information3');
			next_fs = $('#account_information2');
		}else if($('#account_information4').is(":visible")){
			current_fs = $('#account_information4');
			next_fs = $('#account_information3');
		}else if($('#account_information5').is(":visible")){
			current_fs = $('#account_information5');
			next_fs = $('#account_information4');
		}
				
		next_fs.show(); 
		current_fs.hide();
	});*/
	
function readURL(input) {
	if ( window.FileReader && window.File && window.FileList && window.Blob ){
		
		document.getElementById('blah').style.display = "block";
		document.getElementById('img').style.display = "block";
		var img = document.getElementById("blah");
		img.className = "profileimage";
		
		if (input.files && input.files[0]){
		var reader = new FileReader();
	
		reader.onload = function (e) {
		$('#blah')
		.attr('src', e.target.result)
		};	
		reader.readAsDataURL(input.files[0]);
		}
	}
}
function removeProfile(){
	document.getElementById('img').style.display = "none";
	document.getElementById('sProfile').value = '';
}
</script>
<?php /*?><script type="text/javascript">
window.onload = function () {

	if (window.File && window.FileList && window.FileReader)
	{
		
		var filesInput = document.getElementById("sProfileMore");
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
			
			div.innerHTML = "<img  class='thumbnail' src='" + picFile.result + "'" +
			"title='" + picFile.name + "'/> <a href='javascript:void(0)' class='remove_pict'><i class='fa fa-fw fa-remove'></i></a>";
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
</script><?php */?>
<script>
function soloremove01(obj)
{

var objId= obj.id.toString();
$("#new"+objId).remove();
	}
$(document).ready(function () {
	
	$('#country').on('change', function (e) {
		
			  $('#stateId').html('');
			  var cntID = $('#country').val();
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
	
	var max_fields      = 50; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = document.getElementById("xval").value; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group" id="new'+x+'"><label for="mname" class="col-lg-4 control-label"></label><div class="col-lg-4"><input class="form-control" type="text" class="" name="sOtherAmenitis[]" id="" /><a id="'+x+'" onclick="soloremove01(this)" class="remove_field"><i class="fa fa-fw fa-remove"></i></a></div></div>'); //add input box
        }
		
		document.getElementById("xval").value = x;
			
    });
	
	
	var max_fields01      = 9; //maximum input boxes allowed
    var wrapper01         = $(".new_item_details"); //Fields wrapper
    var add_button01      = $(".add_item"); //Add button ID
   
    var x1 = 1 //initlal text box count
    $(add_button01).click(function(e){ //on add input button click
        e.preventDefault();
        if(x1 < max_fields01){ //max input box allowed
            x1++; //text box increment
			
			var txt = '<div class="actions mymaindiv"><span class="serviceRemove">X</span></a><select id="time" name="sTitle[]" class="span2" style="width:80px;float:left;margin-left: 4px;margin-bottom:10px !important"><option>All days</option><option>Weekend</option><option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option><option>Saturday</option><option>Sunday</option></select><input type="text" class="form-control" placeholder="Enter Service Times"  id="sTimeOfEvent'+x1+'" name="sTimeOfEvent[]"><a id="'+x+'"  class="remove_field"></div>';

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
	
	
   
});

</script>
<script>

(function($) {

    $.fn.cslide = function() {

        this.each(function() {

            var slidesContainerId = "#"+($(this).attr("id"));
            
            var len = $(slidesContainerId+" .cslide-slide").size();     // get number of slides
            var slidesContainerWidth = len*100+"%";                     // get width of the slide container
            var slideWidth = (100/len)+"%";                             // get width of the slides
            
            // set slide container width
            $(slidesContainerId+" .cslide-slides-container").css({
                width : slidesContainerWidth,
                visibility : "visible"
            });

            // set slide width
            $(".cslide-slide").css({
                width : slideWidth
            });

            // add correct classes to first and last slide
            $(slidesContainerId+" .cslide-slides-container .cslide-slide").last().addClass("cslide-last");
            $(slidesContainerId+" .cslide-slides-container .cslide-slide").first().addClass("cslide-first cslide-active");

            // initially disable the previous arrow cuz we start on the first slide
            $(slidesContainerId+" .cslide-prev").addClass("cslide-disabled");

            // if first slide is last slide, hide the prev-next navigation
            if (!$(slidesContainerId+" .cslide-slide.cslide-active.cslide-first").hasClass("cslide-last")) {           
                $(slidesContainerId+" .cslide-prev-next").css({
                    display : "block"
                });
            }

$('input[type="text"], input[type="password"]').keypress(function (e) {
 var key = e.which;
 if(key == 13){
    e.preventDefault();  
  }
});

            // handle the next clicking functionality
			
			
	$('#iZipcode').on("keyup", function() {
		
       var selected = $('#country').find('option:selected');
       var extra = selected.data('name'); 
	   
	   var iZipcode = $(this).val();
	   	   
		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/"+extra+"/"+iZipcode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				var zip = client.responseText;
				if(zip.length > 2){
					
					var cityname = $("#cityId").find('option:selected').attr( "dataValue" );
									
					$.each($.parseJSON(client.responseText), function(key,obj) { //$.parseJSON() method is needed unless chrome is throwing error.
						if(key == 'places')
						{
							if ( obj['0']['place name'] == cityname) {
								document.getElementById('zipValid').value = 'valid';								
							} else { 
								document.getElementById('zipValid').value = '';
							}
						}
                    }); 
										
				}else{
					document.getElementById('zipValid').value = '';
				}
			};
		};
		
		client.send();
		
	
    });
	
	$('#iZipcode').blur(function(){
		
       var selected = $('#country').find('option:selected');
       var extra = selected.data('name'); 
	   
	   var iZipcode = $('#iZipcode').val();
	   	   
		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/"+extra+"/"+iZipcode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				var zip = client.responseText;
				if(zip.length > 2){
					
					var cityname = $("#cityId").find('option:selected').attr( "dataValue" );
									
					$.each($.parseJSON(client.responseText), function(key,obj) { //$.parseJSON() method is needed unless chrome is throwing error.
						if(key == 'places')
						{
							if ( obj['0']['place name'] == cityname ) {
								document.getElementById('zipValid').value = 'valid';								
							} else { 
								document.getElementById('zipValid').value = '';
							}
						}
                    }); 
										
				}else{
					document.getElementById('zipValid').value = '';
				}
			};
		};
		
		client.send();
		
	
    });
	
	$('#country').change(function(){
		
       var selected = $('#country').find('option:selected');
       var extra = selected.data('name'); 
	   
	   var iZipcode = $('#iZipcode').val();
	   	   
		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/"+extra+"/"+iZipcode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				var zip = client.responseText;
				if(zip.length > 2){
					
					var cityname = $("#cityId").find('option:selected').attr( "dataValue" );
									
					$.each($.parseJSON(client.responseText), function(key,obj) { //$.parseJSON() method is needed unless chrome is throwing error.
						if(key == 'places')
						{
							if ( obj['0']['place name'] == cityname ) {
								document.getElementById('zipValid').value = 'valid';								
							} else { 
								document.getElementById('zipValid').value = '';
							}
						}
                    }); 
										
				}else{
					document.getElementById('zipValid').value = '';
				}
			};
		};
		
		client.send();
		
	
    });
	
            $(slidesContainerId+" .cslide-next").click(function(){
				
				
				var falg = true;

				if ($('#account_information1').is(":visible")){
					
					if($('#zipValid').val() == '')
					{
						alert('Please enter valid zipcode');
						falg = false;

					}
			 	}
					
				if(falg){		
					var retval = ValidationForm();

					if(retval)
					{
		        var i = $(slidesContainerId+" .cslide-slide.cslide-active").index();
                var n = i+1;
                var slideLeft = "-"+n*100+"%";
                if (!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-last")) {
                    $(slidesContainerId+" .cslide-slide.cslide-active").removeClass("cslide-active").next(".cslide-slide").addClass("cslide-active");
                    $(slidesContainerId+" .cslide-slides-container").animate({
                        marginLeft : slideLeft
                    },250);
                    if ($(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-last")) {
                        $(slidesContainerId+" .cslide-next").addClass("cslide-disabled");
                    }
                }
                if ((!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) && $(".cslide-prev").hasClass("cslide-disabled")) {
                    $(slidesContainerId+" .cslide-prev").removeClass("cslide-disabled");
                }
			}
				
				}else{
					
					return false;
				}

            });

            // handle the prev clicking functionality
            $(slidesContainerId+" .cslide-prev").click(function(){
				
				if($('#account_information1').is(":visible")){
			current_fs = $('#account_information1');
			next_fs = $('#account_information');
		}else if($('#account_information2').is(":visible")){
			current_fs = $('#account_information2');
			next_fs = $('#account_information1');
		}else if($('#account_information3').is(":visible")){
			current_fs = $('#account_information3');
			next_fs = $('#account_information2');
		}else if($('#account_information4').is(":visible")){
			current_fs = $('#account_information4');
			next_fs = $('#account_information3');
		}else if($('#account_information5').is(":visible")){
			current_fs = $('#account_information5');
			next_fs = $('#account_information4');
		}
			
			
			next_fs.show(); 
			current_fs.hide();
			
                var i = $(slidesContainerId+" .cslide-slide.cslide-active").index();
                var n = i-1;
                var slideRight = "-"+n*100+"%";
                if (!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) {
                    $(slidesContainerId+" .cslide-slide.cslide-active").removeClass("cslide-active").prev(".cslide-slide").addClass("cslide-active");
                    $(slidesContainerId+" .cslide-slides-container").animate({
                        marginLeft : slideRight
                    },250);
                    if ($(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) {
                        $(slidesContainerId+" .cslide-prev").addClass("cslide-disabled");
                    }
                }
                if ((!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-last")) && $(".cslide-next").hasClass("cslide-disabled")) {
                    $(slidesContainerId+" .cslide-next").removeClass("cslide-disabled");
                }
            });



        });

        // return this for chainability
        return this;

    }

}(jQuery));
</script>
<?php
$countrymaster = $obj->fetchRowAll("countries",'1=1');
$amenitimaster = $obj->fetchRowAll("amenitimaster",'1=1');
?>
<link href="css/style-1.css" rel="stylesheet">
  <section id="cslide-slides" class="cslide-slides-master clearfix">
  <form class="form-horizontal" action="" method="POST" id="myform" enctype="multipart/form-data">
  
  <input type="hidden" name="latitude" id="latitude" value="" />
  <input type="hidden" name="longitude" id="longitude" value="" />
  
    <div class="cslide-slides-container clearfix">
      <div class="cslide-slide">
        
    <fieldset id="account_information" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 1</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="firstname" class="col-lg-4 control-label">First Name <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sFirstName" name="sFirstName">
        </div>
      </div>
      <div class="form-group">
        <label for="lastname" class="col-lg-4 control-label">Last Name <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sLastName" name="sLastName" >
        </div>
      </div>
      <div class="form-group" style="display:none;">
        <label for="username" class="col-lg-4 control-label">Username <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sUserName" name="sUserName" >
          <input type="hidden" class="hiddenRecaptcha required" name="hidename" id="hidename" value="valid">
          <span id="validusername"></span> </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-lg-4 control-label">Email <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sEmailID" name="sEmailID">
        </div>
      </div>      
      <div class="form-group">
        <label for="password" class="col-lg-4 control-label">Password <span>*</span></label>
        <div class="col-lg-4">
          <input type="password" class="form-control" id="sPassword01" name="sPassword">
        </div>
      </div>
      <div class="form-group">
        <label for="conf_password" class="col-lg-4 control-label">Confirm password</label>
        <div class="col-lg-4">
          <input type="password" class="form-control" id="conf_password" name="conf_password" >
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next">Proceed</a></p>
        </div>
      </div>
    </fieldset>
    
      </div>
      <div>

    
    <fieldset id="account_information1" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 2</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="zip" class="col-lg-4 control-label">Name Of Church <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sChurchName" name="sChurchName" >
        </div>
      </div>
      <div class="form-group">
        <label for="zip" class="col-lg-4 control-label">Name Of Pastor <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sPastorName" name="sPastorName" >
        </div>
      </div>
      
      <div class="form-group">
        <label for="zip" class="col-lg-4 control-label">Church Address <span>*</span></label>
        <div class="col-lg-4">
          <textarea class="form-control" id="sAddress" name="sAddress" ></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="dob" class="col-lg-4 control-label">Birth Date <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="dDob" name="dDob">
        </div>
      </div>
      <div class="form-group">
        <label for="country" class="col-lg-4 control-label">Country</label>
        <div class="col-lg-4">
          <select name="country" class="form-control countries" id="country">
            <option value="">Select Country</option>
            <?php
			if(count($countrymaster) > 0){
				for($c=0;$c<count($countrymaster);$c++){
			?>
            <option value="<?php echo $countrymaster[$c]['id'];?>" data-name="<?php echo $countrymaster[$c]['sortname'];?>"><?php echo $countrymaster[$c]['name'];?></option>
            <?php
				}
			}
			?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="state" class="col-lg-4 control-label">State</label>
        <div class="col-lg-4">
          <select name="state" class="form-control states" id="stateId">
            <option value="">Select State</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="country" class="col-lg-4 control-label">City</label>
        <div class="col-lg-4">
          <select name="city" class="form-control cities" id="cityId">
            <option value="">Select City</option>
          </select>
        </div>
      </div>
     <div class="form-group">
        <label for="zip" class="col-lg-4 control-label">Zipcode <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="iZipcode" name="iZipcode" >
          <input type="hidden" value="" id="zipValid" name="zipValid" >          
        </div>
      </div> 
      <div class="form-group">
        
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev" id="previous" >Back</a></p>
        </div>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next">Proceed</a></p>
        </div>
      </div>
    </fieldset>

      </div>
      <div>
      <fieldset id="account_information2" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 3</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="image" class="col-lg-4 control-label">Denomination</label>
        <div class="col-lg-4">
                <select id="denomination" name="denomination">
                <option value="Anglican" name="denomination">Anglican</option>
                <option value="Apostolic" name="denomination">Apostolic</option>
                <option value="Baptist" name="denomination">Baptist</option>
                <option value="Catholic" name="denomination">Catholic</option>
                <option value="Episcopal" name="denomination">Episcopal</option>                
                <option value="Evangelistic" name="denomination">Evangelistic</option>
                <option value="Lutheran" name="denomination">Lutheran</option>
                <option value="Methodist" name="denomination">Methodist</option>
                <option value="Non_Denominational" name="denomination">Non-Denominational</option>
                <option value="Pentecostal" name="denomination">Pentecostal</option>
                <option value="Presbyterian" name="denomination">Presbyterian</option>
                <option value="Seventh_Day_Adventist" name="denomination">Seventh Day Adventist</option>
                <option value="Other" name="denomination">Other</option>
                </select>
        </div>
      </div>
      <div class="form-group">
        <label for="image" class="col-lg-4 control-label">Approx. #No of Members</label>
        <div class="col-lg-4">
                <select id="ApproxofMembers" class="span2" name="ApproxofMembers">
                <option>Less than 50</option>
                <option>100</option>
                <option>200</option>
                <option>300</option>
                <option>400</option>
                <option>500</option>
                </select>
        </div>
      </div>
      <div class="form-group">
        <label for="extraimage" class="col-lg-4 control-label">Church Website Link</label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sChurchUrl" name="sChurchUrl"  >
        </div>        
      </div>
      <div class="form-group">
        <label for="extraimage" class="col-lg-4 control-label">Mission Statement</label>
        <div class="col-lg-4">
          <textarea class="form-control" id="sMission" name="sMission" ></textarea>
        </div>        
      </div>
      <div class="form-group">
        <label for="extraimage" class="col-lg-4 control-label">Founder Date</label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sFounderName" name="sFounderName"  >
        </div>        
      </div>
            
      <div class="form-group">        
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev" id="previous" >Back</a></p>
        </div>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next">Proceed</a></p>
        </div>
        <div class="clear"></div>
        <div style="height:150px;"></div>
      </div>
    </fieldset>
      </div>
      <div>
      <fieldset id="account_information3" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 4</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="image" class="col-lg-4 control-label">Profile Image <span>*</span></label>
        <div class="col-lg-4">
          <input type="file" class="form-control file" id="sProfile" name="sProfile" onChange="readURL(this);" >
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4" id="img">
        <img id="blah" class="" src="#" alt="X" />
        <a class="remove" onclick="removeProfile()"><i class="fa fa-fw fa-remove"></i></a>
        </div>
      </div>
     <?php /*?> <div class="form-group">
        <label for="extraimage" class="col-lg-4 control-label">Upload Multiple Images</label>
        <div class="col-lg-4">
          <input type="file" class="form-control file" id="sProfileMore" name="sProfileMore[]" multiple="multiple" >
        </div>        
      </div>      
      <div class="form-group">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
        <output id="result" />
        </div>
      </div>  <?php */?>
       
       <?php /*?><script>
var id = 1;
jQuery(document).ready(function () {
    var max = 9;
    jQuery('#add_item').click(function () {
        var button = $('#item_details').clone(true);
		
		id++;
		if(id <= 9){
			$('#remove_item').css('visibility','visible');
			
			button.find('input').val('');
			button.removeAttr('id');
			button.insertBefore('.new_item_details');
			button.attr('id', 'new_' + id);
			
			$("#iServiseNumber").val(id);
		}
			 
    });
    jQuery('.remove_item').click(function (e) {
        jQuery("#new_"+id).remove();
        id--;
		if(id >= 1){
			$("#iServiseNumber").val(id);
			if(id == 1){
				id = 1;
				$('#remove_item').css('visibility','hidden');
			}
		}
        e.preventDefault();
    });
});
</script><?php */?>

 <div class="form-group">
        <label for="image" class="col-lg-4 control-label" style="padding-top:0px;">Day</label>
        <div class="col-lg-4">
		 <a href="javascript:void(0)" name="add_item" class="add_item" id="add_item" style="color:#0033FF;">Add More</a>        
	<!--<a href="javascript:void(0)" name="remove_item" class="remove_item" id="remove_item" style="color:#FF0000;">Remove</a>-->      
            <input type="hidden" value="1" name="iServiseNumber" id="iServiseNumber" />
        </div>
</div>
 
 <script type="text/javascript">
            $(function () {
                
				$('#sTimeOfEvent1').datetimepicker({
                    format: 'LT'
                });
				
				
				
				
            });
        </script>
        
       <div class="form-group">
        <label for="image" class="col-lg-4 control-label">Hours OF Services</label>
        <div class="col-lg-4">
        <div id="element_0" >
								
                                <div id="item_details">
                                <div class="actions">
          <select id="time" name="sTitle[]" class="span2" style="width:80px;float:left;margin-left: 4px;margin-bottom:10px !important;">
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
          <input type="text" class="form-control" placeholder="Enter Service Times"  id='sTimeOfEvent1' name="sTimeOfEvent[]">

    <div style="clear:both"></div>
    </div>
    </div>
    <div id="new_item_details" class="new_item_details"></div>
    </div>
        </div>
      </div>
      
      <div class="form-group">
        
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev" id="previous" >Back</a></p>
        </div>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next">Proceed</a></p>
        </div>
        <div class="clear"></div>
        <div style="height:150px;"></div>
      </div>
    </fieldset>
      </div>
      
      <div>
      <fieldset id="account_information4" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 5</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="role" class="col-lg-4 control-label">Church Amenitis <span>*</span></label>
        <div class="col-lg-4" style="border:solid 1px #ccc; height:110px; overflow:hidden; overflow-y:scroll; background:#ffffff;">
        <?php
			if(count($amenitimaster) > 0){
				for($c=0;$c<count($amenitimaster);$c++){
			?>
        <input type="checkbox" id="ChurchAminity" name="ChurchAminity[]" class="span2" value="<?php echo $amenitimaster[$c]['iAmityID'];?>"/>
		<span style="color:black !important; margin-left:5px;"><?php echo $amenitimaster[$c]['sAmityName'];?></span><br />

        <?php
				}
			}
			?> 
			<?php /*?><select id="ChurchAminity" class="span2" name="ChurchAminity[]" multiple >
            <option value="">Select Country</option>
            <?php
			if(count($amenitimaster) > 0){
				for($c=0;$c<count($amenitimaster);$c++){
			?>
            <option value="<?php echo $amenitimaster[$c]['iAmityID'];?>"><?php echo $amenitimaster[$c]['sAmityName'];?></option>
            <?php
				}
			}
			?>                   
            </select><?php */?>
        </div>
      </div>
      <div class="input_fields_wrap"></div>
      <div class="form-group">
              <label for="role" class="col-lg-4 control-label"></label>
              <div class="col-lg-4">
              <a class="add_field_button">Add More Amenitis</a>
              <input type="hidden" value="0" id="xval" name="xval" /> 
              </div>
            </div>   
                    
      <div class="form-group">
        
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev" id="previous" >Back</a></p>
        </div>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next">Proceed</a></p>
        </div>
      </div>      
    </fieldset>
      </div>
       <div>
       <fieldset id="account_information5" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 6</strong></label>
        </div>
      </div>  
      <div id="solo-New" style="display:none;"> </div>
      <div class="form-group">
        <label for="Availability" class="col-lg-4 control-label">Church Ministries</label>
        <div class="col-lg-4">
          <select name="sMinistrieName[]" id="sMinistrieName" class="form-control" > 
<option value="">Select Ministry</option>
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
      <?php /*?><div class="form-group">
        <label for="ye" class="col-lg-4 control-label"></label>
        <div class="col-lg-4">
          <input type="file" class="form-control file" id="sImage" name="sImage[]" >
        </div>
      </div><?php */?>
      <div class="form-group">
        <label for="ye" class="col-lg-4 control-label"></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="youtube" placeholder="Ministry Youtube Url" name="youtube[]" >
        </div>
        <div class="col-lg-4">
              <a id="AddSolo" class="addmore">Add More ministry</a> 
             </div>
      </div> 
	  
	  <div class="form-group">
	  
	   <label for="zip" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 aggreement_txt">
		
        <p class="aggreement">By Clicking "Submit" I agree that:</p>
			<ul><li>I have read and accepted the 
				<a target="_blank" href="<?php echo URL;?>termsandcondition">Terms of Use</a> and 
				<a target="_blank" href="<?php echo URL;?>privacy">Privacy Policy</a></li></ul>
		</div>
      </div>
	  
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev" id="previous" >Back</a></p>
        </div>
        <div class="col-lg-4 text-right">
        <p>
            <input class="btn btn-success" type="submit" name="btn_submit" value="Submit">
          </p>
          
        </div>
      </div>
    </fieldset>
       </div>
     </div>
  </form>
  </section>
  
  
</div>
<?php
if(isset($_POST['btn_submit'])){
	extract($_POST)	;

	$cond="(sEmailID = '".$sEmailID."' AND sUserType = 'church') AND isActive = 1";
    $loginrow = $obj->fetchRow('loginmaster',$cond);
		
	if(count($loginrow) > 0){			
		$objsession->set('gs_error_msg','This email already existing.');			
		redirect(URL.'views/church.php');
	}	
	else{
		
		$field = array("sEmailID","sPassword","sUserType","isActive");
		$value = array($sEmailID,md5($sPassword),'church',1);		
		$iLoginID = $obj->insert($field,$value,"loginmaster");
		
		$userImage = '';
		 					
		if($_FILES["sProfile"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["sProfile"]["name"];
			$userImage = $randno.$img;
			
			move_uploaded_file($_FILES['sProfile']['tmp_name'],"../upload/church/".$userImage);			
		}
		
		/*$sMultiImage = '';
		if($_FILES["sProfileMore"] != ''){
		
			for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
				if($_FILES["sProfileMore"]['name'][$i] != ''){
				$randno = rand(0,5000);
				$img = $_FILES["sProfileMore"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/church/multiple/".$randno.$img);			
				}
			}
			
			$sMultiImage = rtrim($sMultiImage,',');
		}*/
					
		if(!empty($ChurchAminity)){
			$ChurchAminity = implode(',',$ChurchAminity);
		}else{
			$ChurchAminity = '';	
		}
		
		if(!empty($sOtherAmenitis)){
			$sOtherAmenitis = implode(',',$sOtherAmenitis);
		}else{
			$sOtherAmenitis = '';	
		}
		
		/*if ( $latitude == "" && $longitude == "" ) {
	
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
		}*/

		$field = array("iLoginID","sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sChurchName","sPastorName","sAddress","sDenomination","iNumberMembers","sChurchUrl","sMission","sFounderName","sAmenitis","sOtherAmenitis","dCreatedDate","isActive","sUserType","sLatitude","sLongitude");
		$value = array($iLoginID,$sFirstName,$sLastName,$userImage,$sUserName,date("Y-m-d",strtotime($dDob)),$country,$state,$city,$iZipcode,$sChurchName,$sPastorName,$sAddress,$denomination,$ApproxofMembers,$sChurchUrl,$sMission,$sFounderName,$ChurchAminity,$sOtherAmenitis,date("Y-m-d"),1,"church",$latitude,$longitude);		

		$userID = $obj->insert($field,$value,"usermaster");

						
		$cnt = count($_POST['sTimeOfEvent']);
		
		if($cnt > 0){
			$n = 0;
			for($no=1;$no<=$cnt;$no++){
					
				$serviceHourList = explode(':',$_POST['sTimeOfEvent'][$n]);
				$iHour = $serviceHourList[0];
				$serviceHourList2 = explode(' ',$serviceHourList[1]);
				$iMinute = $serviceHourList2[0];	
				$ampm = $serviceHourList2[1];
		
				$field = array("iLoginID","sTitle","iHour","iMinute","ampm","isActive");
				$value = array($iLoginID,$sTitle[$n],$iHour,$iMinute,$ampm,1);		
				$obj->insert($field,$value,"churchtimeing");
				$n ++;
			}
		}
				
		if(!empty($sMinistrieName)){
			
		//$sMinistrieName = implode(',',$sMinistrieName);
		//$youtube = implode(',',$youtube);
			
		//$sImage = '';
		/*if($_FILES["sImage"] != ''){
		
			for($i=0;$i<count($_FILES["sImage"]['name']);$i++) {
				
				$randno = rand(0,5000);
				$img = $_FILES["sImage"]['name'][$i];
				$sImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sImage"]['tmp_name'][$i],"../upload/church/ministry/".$randno.$img);			
				
			}
			
			$sImage = rtrim($sImage,',');
		}*/
			
			$n = 0;
			foreach($sMinistrieName as $val){
				$field = array("iLoginID","sMinistrieName","sUrl");
				$value = array($iLoginID,$sMinistrieName[$n],$youtube[$n]);
				$obj->insert($field,$value,"churchministrie");
				$n ++;
			}
			
			
		}
				
		$objsession->set('gs_login_id',$iLoginID);	
		$objsession->set('gs_login_email',$sEmailID);	
		$objsession->set('gs_login_type','church');	
		$objsession->set('gs_user_name',$sFirstName);
			
		//$objsession->set('gs_msg','<p>Hello,</p><p>Thanks for the Registration.</p><br><p>Thanks,</p><strong>Gospel Team</strong>');

$to = $sEmailID; // this is your Email address

    $from = "Administrator@gospelscout.com"; // this is the sender's Email address
    $subject = "GospelScout";
    $subject2 = "Registration - GospelScout";
  
    $message = "<div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#fff'>
        <table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
            <tbody>   
<tr>            <td>
            <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff' style='width:750px!important'>
                <tbody>
                    <tr>
                        <td>
                            <table width='690' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#fff'>
                            <tbody>
                            
                                <tr>
                                    <td colspan='3' height='80' align='center' border='0' cellspacing='0' cellpadding='0' style='padding:0;margin:0;font-size:0;line-height:0'>
                                        <table width='690' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td width='30'></td>
                                                <td align='left' valign='middle' style='padding:0;margin:0;font-size:0;line-height:0'>
                                                <a href='http://www.stage.gospelscout.com/' target='_blank'>
                                                <img src='http://www.stage.gospelscout.com/img/logo.png' width='200px' height='100px' style='margin-left: 230px;' alt='GospelScout' ></a></td>
                                                <td width='30'></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='3' align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                            <tr>
                                                <td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                <td align='center'>
                                                    <h1 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:40px;color:#404040;line-height:40px;font-weight:bold;margin:0;padding:0'>Welcome to GospelScout</h1>
                                                </td>
                                                <td width='25'></td>
                                            </tr>";
$message .= "<tr>
                                                <td colspan='3' height='40'></td></tr><tr><td colspan='5' align='center'>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
Hello , $sFirstName $sLastName         </p> <br/>   <br/>                                                  


  <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>Thank you for signing up with GospelScout.</p><br/>
                                                    <p style='color:#000;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Account Details:</b>      </p>  <br/>
 <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> User Name :</b> $sEmailID        </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b>Password :</b> $sPassword           </p> <br/>
<p style='color:#000;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>


    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
We wish you all the best   </p> <br/>
<p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align:left;'>
<b> Kind regards, </b> <br/>
GospelScout Team.
            </p>                                 </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                        <tr>
                                                            <td align='center' style='margin:0;text-align:center'>
                            <a href='http://www.stage.gospelscout.com/' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Visit website!</a></td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan='3' height='30'></td></tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>                           
                           
                            </tbody>
                            </table>
                            
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>
    </tbody>
    </table>
</div>";

    /*$message = "First Name :- " .$firstname . "\n\n Last Name:-  " . $lastname . "\n\n Your Affiliate Links:- " . $ref_link ."\n\n Your Address:-  " . $address. "\n\n Your DOB:-  " . $dob;
   $message .= "\n\n Email :- ".$email ."\n\n Password :- ".$password;

    $message2 = "Member First Name :- " .$firstname . "\n\n Member Last Name:-  " . $lastname . "\n\n Member Affiliate Links:- " .$ref_link ."\n\n Member Address:-  " . $address. "\n\n Member DOB:-  " . $dob;
$message2 .= "\n\n  Member Email :- ".$email ."\n\n Member Password :- ".$password;
*/
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$from;
    $mail=mail($to,$subject,$message,$headers);

     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= "From:" .$to;


    
    $mail=mail($from,$subject2,$message,$headers); 
    
    if(!$mail){ ?>
           <script>
            alert('Can't' Send Register Mail');
            </script>
   <?php } else{ ?>
             <script>
			alert('Your Registration Successful..Please Check Your Mail....');
			window.location='http://www.stage.gospelscout.com/views/churchprofile.php';
            </script>
   <?php  }
}    
} 


  ?>

<script>

$(document).ready(function() {
	

	
var dynamicid=1;
$('#AddSolo').click(function() {

	var data = '<div id="divsolo'+dynamicid+'">';
data +=           '<div class="form-group">';
data +=           '             <label for="role" class="col-lg-4 control-label">Church Ministries</label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <select id="sMinistrieName" class="form-control" name="sMinistrieName[]"  >';
data +=           '		<option value="">Select Ministry</option>';	
<?php
									$drop = $obj->fetchRowAll("giftmaster1","isActive = 1");
								if(count($drop) > 0){
								for($c=0;$c<count($drop);$c++){
								$abc=$drop[$c]['sGiftName'];?>
data +=           '				  <option value="<?php echo $abc;?>"><?php echo $abc;?></option>';
										<?php }
							}
			
					?>
data +=           '              </select>			 ';
data +=           '            </div>';
data +=           '        </div>';
/*data +=           '          <div class="form-group">';
data +=           '            <label for="role" class="col-lg-4 control-label"></label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="file" name="sImage[]" class="form-control" />';
data +=           '            </div>';
data +=           '          </div>';
*/
data +=           '          <div class="form-group">';
data +=           '            <label for="role" class="col-lg-4 control-label"></label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="text" name="youtube[]" placeholder="Ministry Youtube Url" class="form-control" />';
data +=           '            </div>';
data +=           '            <div class="col-lg-4">';
data +=           '               <a class="Solo-Remove remove" onclick="soloremove(this)" id="'+dynamicid+'">Remove</a>';
data +=           '            </div>';
data +=           '          </div>';
data +=           '        </div>';
	
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
<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>