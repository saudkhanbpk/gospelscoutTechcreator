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
<link href="../css/style-1.css" rel="stylesheet">
<div class="container">
<?php
$countrymaster = $obj->fetchRowAll("countries",'1=1');
?>
<h4 class="h4">USER REGISTRATION</h4>

  <section id="cslide-slides" class="cslide-slides-master clearfix">
  <form class="form-horizontal" action="" method="POST" id="myform" enctype="multipart/form-data">
  
  <input type="hidden" name="latitude" id="latitude" value="" />
  <input type="hidden" name="longitude" id="longitude" value="" />

    <div class="cslide-slides-container clearfix">
      <div class="cslide-slide">
        
    <fieldset id="account_information" class="">
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
        <label for="image" class="col-lg-4 control-label">Profile Image</label>
        <div class="col-lg-4">
          <input type="file" class="form-control file" id="sProfile" name="sProfile" >
        </div>
      </div>
      <div class="form-group">
      <label class="col-lg-4 control-label" for="image"></label>
        <div class="col-lg-4 text-right">
          <p><a class="btn btn-primary cslide-next" style="float:left;">Proceed</a></p>
        </div>
      </div>
    </fieldset>
    
      </div>
      <div class="cslide-slide">

    
    <fieldset id="account_information1" class="">
      <div class="form-group" style="display:none;">
        <label for="username" class="col-lg-4 control-label">Username <span>*</span></label>
        <div class="col-lg-4">
          <input type="text" class="form-control" id="sUserName" name="sUserName" >
          <input type="hidden" class="hiddenRecaptcha required" name="hidename" id="hidename" value="valid">
          <span id="validusername"></span> </div>
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
	  
	   <label for="zip" class="col-lg-4 control-label"></label>
        <div class="col-lg-4 aggreement_txt">
		
        <p class="aggreement">By Clicking "Submit" I agree that:</p>
			<ul><li>I have read and accepted the 
				<a target="_blank" href="<?php echo URL;?>views/termsandcondition">Terms of Use</a> and 
				<a target="_blank" href="<?php echo URL;?>views/privacy">Privacy Policy</a></li></ul>
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
  <script>
$(document).ready(function() {
	$('#dDob').datetimepicker({
		//locale: "en-GB",
		format: 'DD-MM-YYYY',		
		//minDate: moment().subtract(1,'d'),
		//ignoreReadonly: true,
		//disabledDates:[moment().subtract(1,'d')],
		
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
	
	 $("#cslide-slides").cslide();	
});
</script> 
  <script type="text/javascript">
	$(document).ready(function(){

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
					hidename: {
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
						extension: "Upload only PNG | JPG image only",
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
					hidename: "Please select valid username",
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
				}
									
				next_fs.show(); 
				current_fs.hide();
				flag = true;
			}
			else
			{
				flag = false;
			}
			

			return flag;
		
	}
</script>
  
</div>
<?php
if(isset($_POST['btn_submit'])){
	extract($_POST)	;
	
	$cond="(sEmailID = '".$sEmailID."' AND sUserType = 'user') AND isActive = 1";
    $loginrow = $obj->fetchRow('loginmaster',$cond);
		
	if(count($loginrow) > 0){			
		$objsession->set('gs_error_msg','This email already existing.');			
		redirect(URL.'views/user.php');
	}	
	else{
		
		$field = array("sEmailID","sPassword","sUserType","isActive");
		$value = array($sEmailID,md5($sPassword),'user',0);		
		$iLoginID = $obj->insert($field,$value,"loginmaster");
		
		$userImage = '';
		 					
		if($_FILES["sProfile"]["name"] != ''){
			$randno = rand(0,5000);
			$img = $_FILES["sProfile"]["name"];
			$userImage = $randno.$img;
			
			move_uploaded_file($_FILES['sProfile']['tmp_name'],"../upload/user/".$userImage);			
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
		
		$field = array("iLoginID","sFirstName","sLastName","sProfileName","sUserName","dDOB","sCountryName","sStateName","sCityName","iZipcode","dCreatedDate","isActive","sUserType","sLatitude","sLongitude");
		$value = array($iLoginID,$sFirstName,$sLastName,$userImage,$sUserName,date('Y-m-d',strtotime($dDob)),$country,$state,$city,$iZipcode,date("Y-m-d"),0,"user",$latitude,$longitude);		
		$obj->insert($field,$value,"usermaster");
		
		$objsession->set('gs_login_id',$iLoginID);
		$objsession->set('gs_user_email',$sEmailID);
		$objsession->set('gs_login_type','user');	
		$objsession->set('gs_user_name',$sFirstName);
				
		//$objsession->set('gs_msg','<p>Hello,</p><p>Thanks for the Registration. Your details will be verified with admin and you will be notified once it approve.</p><br><p>Thanks,</p><strong>Gospel Team</strong>');			
		redirect(URL.'views/useraccount.php');			
	}
}
?>
<script>
/*setTimeout(function() { 
	$('#countryId').find('option[countryid=2]').attr('selected','selected');
}, 2000);*/
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
	
	$('#iZipcode').change(function(){
		
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
                       // $(slidesContainerId+" .cslide-next").addClass("cslide-disabled");
                    }
                }
                if ((!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) && $(".cslide-prev").hasClass("cslide-disabled")) {
                    $(slidesContainerId+" .cslide-prev").removeClass("cslide-disabled");
                }
			}
			
			}else
			{
						return false;
			}

            });

            // handle the prev clicking functionality
            $(slidesContainerId+" .cslide-prev").click(function(){
				
				if($('#account_information1').is(":visible")){
				current_fs = $('#account_information1');
				next_fs = $('#account_information');
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
<?php include('../include/footer.php');?>