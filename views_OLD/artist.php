<?php include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php'); ?>

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
<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
    <h4 class="h4">ARTIST REGISTRATION</h4>
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
	
	$('#dPayed0').datetimepicker({
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
				/*hidename: {
					required: true,
				},	*/
				availability: {
					required: true,
				},	
				selectField : "required",				
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
				//hidename: "Please select valid username",
				availability: {
					required: "Availability required",
				},
				selectField : "Please select artist roll",
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
			}/*else if ($('#account_information4').is(":visible")){
				current_fs = $('#account_information4');
				next_fs = $('#account_information5');
			}*/
								
			next_fs.show(); 
			current_fs.hide();
			flag = true;
		}else{
			flag = false;	
		}
	return flag;
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
		
		//document.getElementById('blah').style.display = "block";
		//document.getElementById('img').style.display = "block";
		var img = document.getElementById("blah");
		//img.className = "profileimage";
		
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
</script>
<?php */?>
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
		
});


function loadText(nolist){
	
	var max_fields      = 500; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap01"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
   var x = nolist;
   $(wrapper).html('');
for(var i=1;i<=x;i++)
{


            $(wrapper).append('<div class="form-group"><label for="mname" class="col-lg-4 control-label">Member Name</label><div class="col-lg-4"><input class="form-control" type="text" class="" name="membername[]" id="" /></div></div><div class="form-group"><label for="role" class="col-lg-4 control-label">Member Talent</label><div class="col-lg-4"><select name="mygift[]" class="form-control mt10"><option selected="selected">Select Talent</option><option value="bassplayers">bass players</option><option value="Dancers">Dancers</option><option value="Drummers">Drummers</option><option value="Flute">Flute</option><option value="Guitarists">Guitarists</option><option value="Horn players">Horn players</option><option value="Saxophone">Saxophone</option><option value="Trombone">Trombone</option><option value="Trumpet">Trumpet</option><option value="Keys">Keys</option><option value="Mime">Mime</option><option value="Percussions">Percussions</option><option value="Singers">Singers</option><option value="Violin">Violin</option></select></div></div><div class="form-group"><label for="url" class="col-lg-4 control-label">Upload Videos form youtube</label><div class="col-lg-4"><input class="form-control" type="text" class="" name="youtube[]" id="" /></div></div>'); //add input box

		//document.getElementById("xval").value = x;
}
}
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
	
            // handle the next clicking functionality
            $(slidesContainerId+" .cslide-next").click(function(){
			
			
			var falg = true;
			
			if ($('#account_information1').is(":visible")){
//				alert($('#zipValid').val());

				if($('#zipValid').val() == '')
				{
					alert('Please enter valid zipcode');
					falg = false;
				}
			}
							
			if(falg)
			{
			
						
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

}
			else
			{
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
		}/*else if($('#account_information5').is(":visible")){
			current_fs = $('#account_information5');
			next_fs = $('#account_information4');
		}*/
		
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
?>
<link href="css/style-1.css" rel="stylesheet">
<script type="text/javascript" src="http://www.stage.gospelscout.com/js/rhinoslider-1.05.min.js"></script>
  <section id="cslide-slides" class="cslide-slides-master clearfix">
  <form class="form-horizontal" action="" method="POST" id="myform" enctype="multipart/form-data">
  
  <input type="hidden" name="latitude" id="latitude" value="" />
  <input type="hidden" name="longitude" id="longitude" value="" />
  
    <div class="cslide-slides-container clearfix">
      <div class="cslide-slide" id="account_information">
        
    <fieldset>
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
      <div class="form-group">
        <label for="email" class="col-lg-4 control-label">Email <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sEmailID" name="sEmailID">
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
        <label for="conf_password" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next fl">Proceed</a></p>
        </div>
      </div>
    </fieldset>
    
      </div>

      <div id="account_information1">

    
    <fieldset  class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 2</strong></label>
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
          <select name="city" class="form-control cities" id="cityId" >
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
         <label for="zip" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 text-right">
          <p>
          	<a class="btn btn-primary cslide-prev fl" id="previous" >Back</a>
            <a class="btn btn-primary cslide-next fr">Proceed</a></p>
        </div>
        
      </div>
    </fieldset>

      </div>
      <div id="account_information2">
      <fieldset  class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 3</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="image" class="col-lg-4 control-label">Profile Image <span>*</span></label>
        <div class="col-lg-4">
          <input type="file" class="form-control file" id="sProfile" name="sProfile" onChange="readURL(this);" >
        </div>
      </div>
      <?php /*?><div class="form-group">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4" id="img">
        <img id="blah" class="" src="#" alt="X" />
        <a class="remove" onclick="removeProfile()"><i class="fa fa-fw fa-remove"></i></a>
        </div>
      </div>
      <div class="form-group">
        <label for="extraimage" class="col-lg-4 control-label">Upload Multiple Images</label>
        <div class="col-lg-4">
          <input type="file" class="form-control file" id="sProfileMore" name="sProfileMore[]" multiple="multiple" >
        </div>        
      </div><?php */?>
      
      <div class="form-group">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
        <output id="result" />
        </div>
      </div>      
      <div class="form-group">
<label for="image" class="col-lg-4 control-label"></label>        
        <div class="col-lg-4 text-right">

          <p><a class="btn btn-primary cslide-prev fl" id="previous" >Back</a> <a class="btn btn-primary cslide-next fr">Proceed</a></p>
        </div>
      </div>
    </fieldset>
      </div>
      
      <div id="account_information3">
      <fieldset  class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 4</strong></label>
        </div>
      </div>
      <div class="form-group">
        <label for="role" class="col-lg-4 control-label">Role</label>
        <div class="col-lg-4">
			<select id="selectField" name="selectField" class="form-control" >
                <option id="selectroll" value="" selected>Select Roll</option>
                <option value="solo" >Solo</option>
                <option value="group" >Group</option>
              </select>
        </div>
      </div>
      <div id="solo" style="display:none;">
            <div id="solo-New" style="display:none;"> </div>
            <div class="form-group">
              <label for="role" class="col-lg-4 control-label">My Talent</label>
              <div class="col-lg-4">

<select class="form-control" id="sGiftName" name="sGiftName[]" >
<option value="">Select</option>    
<?php
				$drop = $obj->fetchRowAll("giftmaster","isActive = 1");
				if(count($drop) > 0){
				for($c=0;$c<count($drop);$c++){
						$abc=$drop[$c]['sGiftName'];?>
						<option value="<?php echo $abc;?>"><?php echo $abc;?></option>
					<?php }
							}
			
					?>		


                <!--<select class="form-control" id="sGiftName" name="sGiftName[]" >
                 <option value="">Select</option>                 
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
                  <option value="Poet_Spoken Word">Poet/Spoken Word</option>
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
            <div class="form-group">
              <label for="role" class="col-lg-4 control-label"></label>
              <div class="col-lg-4">
                <input type="text" name="youtube[]" class="form-control" placeholder="Enter only youtube url" />
              </div>
              <div class="col-lg-4">
              <a id="AddSolo" class="addmore">Add More Talent</a> 
             </div>
            </div>
        </div>      
      <div id="group" style="display:none;">
            <div class="form-group">
              <label for="person" class="col-lg-4 control-label">Select Number of Person</label>
              <div class="col-lg-4">
                  <select id="id_of_select1" name="iNumberMembers" class="form-control" onChange="loadText(this.value);" >
                    <option selected="selected" value="0">Select number of person</option>
                    <?php 
					for($i=1;$i<=100;$i++){
					?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php } ?>
                  </select>                  
              </div>
            </div>
            <div class="form-group">
            	<label for="extraimage" class="col-lg-4 control-label">Group Name</label>
            <div class="col-lg-4">
            	<input type="text" class="form-control" id="sGroupName" name="sGroupName"  >
            </div>        
            </div>
            <div class="input_fields_wrap01"></div>
        </div>      
      <div class="form-group">
        <label for="extraimage" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev fl" id="previous" >Back</a><a class="btn btn-primary cslide-next fr">Proceed</a></p>
        </div>
        
      </div>      
    </fieldset>
      </div>
       <div id="account_information4">
       <fieldset  class="height">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 5</strong></label>
        </div>
      </div>  
      
      <div class="form-group">
        <label for="Availability" class="col-lg-4 control-label">Availability <span>*</span></label>
        <div class="col-lg-4">
          <select name="availability" id="availability" class="form-control" >
                <option value="">Select Availability</option>
                <option value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
              <option value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
              <option value="Will Play For Food (Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
              <option value="Will Play For Free">Will Play for Free </option>
              </select>
        </div>
      </div>
      <div class="form-group">
        <label for="ye" class="col-lg-4 control-label">Years Of Experience</label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="iYear" name="iYear" >
        </div>
      </div>
      <div class="form-group" style="display:none;">
        <label for="ye" class="col-lg-4 control-label">How long they have playing</label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="dPayed" name="dPayed" >
        </div>
      </div> 
      
	  <div class="form-group">
	  
	   <label for="zip" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 aggreement_txt">
		
        <p class="aggreement">By Clicking "Submit" I agree that:</p>
			<ul><li>I have read and accepted the 
				<a target="_blank" href="<?php echo URL;?>views/termsandcondition">Terms of Use</a> and 
				<a target="_blank" href="<?php echo URL;?>views/privacy">Privacy Policy</a></li></ul>
		</div>
      </div>
	  
      <div class="form-group">
        <label for="ye" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 text-right">
         <p><a class="btn btn-primary cslide-prev fl" id="previous" >Back</a>
          <input class="btn btn-success fr" onclick="ValidationForm();" type="submit" name="btn_submit" value="Submit" /></p>
        </div>
      </div>
    </fieldset>
 </div>

        <?php /*?><div class="cslide-slide">
        <fieldset id="account_information5" class="">
      <div class="form-group">
        <div class="col-lg-4 text-right">
          <label><strong>Step 6</strong></label>
        </div>
      </div>  
      <div class="form-group">
        <label for="mi" class="col-lg-4 control-label">Musical Influences</label>
        <div class="col-lg-4">
            <select name="musicalinfluences[]" class="form-control" multiple="multiple">
            <option  value="Bass Player">Bass Player</option>
            <option  value="Dancer">Dancer</option>
            <option  value="Drummer">Drummer</option>
            <option  value="Flute">Flute</option>
            <option value="Guitarist">Guitarist</option>
            <option value="Keys">Keys</option>
            <option value="Mime">Mime</option>
            </select>
        </div>
      </div>
      <div class="form-group">
        <label for="ye" class="col-lg-4 control-label">What Kind of Music They Play</label>
        <div class="col-lg-4">
            <select name="whatkindofmusic[]" multiple="multiple" class="form-control">
            <option value="Rock">Rock</option>
            <option value="Jazz">Jazz</option>
            <option value="Flute">Flute</option>
            <option value="pop">pop</option>
            </select>
        </div>
      </div>
      <div class="form-group">
        <label for="ye" class="col-lg-4 control-label">Who they have Played for</label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sPlayedFor" name="sPlayedFor" >
        </div>
      </div>
      <div class="form-group">
        <label for="pf" class="col-lg-4 control-label">Where they Have Played</label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sWherePlayed" name="sWherePlayed" >
        </div>
      </div> 
      <div class="form-group">
      <label for="pf" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-prev fl" id="previous" >Back</a>
          <input class="btn btn-success fr" type="submit" name="btn_submit" value="Submit"></p>
        </div>
        
      </div>
    </fieldset>
        </div><?php */?>
     </div>
  </form>
  </section>
  
  
</div>
<?php
if(isset($_POST['btn_submit'])){

	extract($_POST)	;
	
	$cond="(sEmailID = '".$sEmailID."' AND sUserType = 'artist') AND isActive = 1";
    $loginrow = $obj->fetchRow('loginmaster',$cond);
		
	if(count($loginrow) > 0){			
		$objsession->set('gs_error_msg','This email already existing.');			
		redirect(URL.'views/artist.php');
	}	
	else{
		
		$field = array("sEmailID","sPassword","sUserType","isActive");
		$value = array($sEmailID,md5($sPassword),'artist',1);		
		$iLoginID = $obj->insert($field,$value,"loginmaster");
		
		$userImage = '';
		 					
		if($_FILES["sProfile"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["sProfile"]["name"];
			$userImage = $randno.$img;
			
			move_uploaded_file($_FILES['sProfile']['tmp_name'],"../upload/artist/".$userImage);			
		}
		
		$sMultiImage = '';
		/*if($_FILES["sProfileMore"] != ''){
		
			for($i=0;$i<count($_FILES["sProfileMore"]['name']);$i++) {
				if($_FILES["sProfileMore"]['name'][$i] != ''){
				$randno = rand(0,5000);
				$img = $_FILES["sProfileMore"]['name'][$i];
				$sMultiImage .= $randno.$img.",";
				
				move_uploaded_file($_FILES["sProfileMore"]['tmp_name'][$i],"../upload/artist/multiple/".$_FILES["sProfileMore"]['name'][$i]);			
				}
			}
			
			$sMultiImage = rtrim($sMultiImage,',');
		}*/
		
		/*if(!empty($musicalinfluences)){
			$musicalinfluences = implode(',',$musicalinfluences);
		}else{
			$musicalinfluences = '';	
		}
		
		if(!empty($whatkindofmusic)){
			$whatkindofmusic = implode(',',$whatkindofmusic);
		}else{
			$whatkindofmusic = '';	
		}*/
		
		if(!empty($sGiftName)){
			$sGiftName02 = implode(',',$sGiftName);	
		}else{
			$sGiftName02 = '';
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
		
		$field = array("iLoginID","sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","sAvailability","iYearOfExp","dHowLongPlay","dCreatedDate","isActive","sUserType","iGiftID","sLatitude","sLongitude");
		$value = array($iLoginID,$sFirstName,$sLastName,$userImage,$sUserName,date("Y-m-d",strtotime($dDob)),$country,$state,$city,$iZipcode,$availability,$iYear,date("Y-m-d",strtotime($dPayed)),date("Y-m-d"),1,"artist",$sGiftName02,$latitude,$longitude);	
		$userID = $obj->insert($field,$value,"usermaster");
		
		if($selectField != "" && $selectField == 'solo'){
			
			//$sGiftName = implode(',',$sGiftName);
			//$youtube = implode(',',$youtube);
			$no = 0;
			foreach($sGiftName as $value){

							
				$field = array("iLoginID","sGroupType","sGiftName","sYoutubeUrl");
				$value = array($iLoginID,$selectField,$value,$youtube[$no]);		
				$obj->insert($field,$value,"rollmaster");
				$no ++;
			}
		}
		
		if($selectField != "" && $selectField == 'group'){

			$membername = implode(',',$membername);
			$mygift = implode(',',$mygift);
			$youtube = implode(',',$youtube);
			
			if ( $youtube != ''){
				$youtube = $youtube;
			} else {
				$youtube = '';
			}
				if($iNumberMembers > 0)	{ 
				$n = 0;
					for($i=1;$i<=$iNumberMembers;$i++) {
							
		//$field = array("iLoginID","sGroupType","iNumberMembers","sGropName","sGiftName","sYoutubeUrl");
		//$value = array($iLoginID,$roll,$iNumberMembers,$sGroupName,$membername[$n],$mygift[$n],$youtube[$n]);	
					}
				}else{
					
		//$field = array("iLoginID","sGroupType","iNumberMembers","sGropName","sGiftName","sYoutubeUrl");
		//$value = array($iLoginID,$roll,$iNumberMembers,$sGroupName,$membername,$mygift,$youtube);	
		
				}
				
			$field = array("iLoginID","sGroupType","iNumberMembers","sGropName","sMemberName","sGiftName","sYoutubeUrl");
			$value = array($iLoginID,$selectField,$iNumberMembers,$sGroupName,$membername,$mygift,$youtube);	
		
			$obj->insert($field,$value,"rollmaster");

			
		}
		
		$objsession->set('gs_login_id',$iLoginID);	
		$objsession->set('gs_login_email',$sEmailID);	
		$objsession->set('gs_login_type',"artist");
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
           	window.location='http://www.stage.gospelscout.com/views/artistprofile.php';
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
data +=           '             <label for="role" class="col-lg-4 control-label">My Talent</label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <select id="sGiftName" class="form-control" name="sGiftName[]">';
data +=           '		<option value="">Select Talent</option>';			
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
data +=           '        </div>';
data +=           '          <div class="form-group">';
data +=           '            <label for="role" class="col-lg-4 control-label"></label>';
data +=           '            <div class="col-lg-4">';
data +=           '               <input type="text" name="youtube[]" class="form-control" placeholder="Enter only youtube url" />';
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