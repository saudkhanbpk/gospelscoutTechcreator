function sendConfCode(){
    var email_is_present = $('input[ name="loginmaster[sEmailID]" ]').val(); 
    if(email_is_present != ''){

        var param2 = email_is_present;//$('#sEmailID2').val(); 
        var param3 = $('input[ name="usermaster[sFirstName]" ]').val(); 
        var param5 = 'Artist';

        var formData = new FormData(); 
        formData.append('confirmCode', 1); 
        formData.append('newUserEmail', param2);
        formData.append('newUserName', param3);
        formData.append('profileType', param5);

        var sendMail = new XMLHttpRequest(); 
        sendMail.onload = function(){
            if(sendMail.status == 200){
                var uniqueID = sendMail.responseText.trim(); console.log(uniqueID);
                var parsedResponse = JSON.parse(uniqueID); 

                if( !parsedResponse.success ){
                        /* show error message */
                        var err_msg = '<div class="row"><div class="col-12"><p class="text-danger mt-0" style="font-size:.8em;margin-top:0;margin-bottom:0">There was a problem sending the verification code</p>';
                        err_msg += '<p class="mt-0" style="font-size:.8em; margin-top:0;margin-bottom:0">Please <a href="https://www.stage.gospelscout.com/#Contact-Us" target="_blank" class="text-primary">contact us</a>.</p></div></div>';
                        $('#error-display').html(err_msg);
                }else{
                    return true; 
                }
            }
        }
        // sendMail.open("POST", "https://www.stage.gospelscout.com/signup/gen_user/phpBackend/emailConf.php");
        sendMail.open('POST', 'https://www.stage.gospelscout.com/views/checklogin.php');
        sendMail.send(formData); 

        /* Set the time out function within a function triggered by the submit button. */
            // setTimeout(function(){ window.location.href = 'https://www.stage.gospelscout.com';},600000);
    }
    else{
        console.log('err: email_not_present');
    }
}

$(function(){ 
    var signupForm = $('#signup-form');

    signupForm.validate({
        /* Error-message placement & styling */
             errorPlacement: function(error, element) {
                error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                // element.after(error);
                if(element[0].name == 'usermaster[dDOB][month]' || element[0].name == 'usermaster[dDOB][day]' || element[0].name == 'usermaster[dDOB][year]'){
                  console.log(element[0].name);
                  error.appendTo( element.parent("div"));
                }else{
                  element.after(error);
                } 
             },

        /* Handle form when submission is invalid */
            invalidHandler: function(event, validator){
                var numbErrors = validator.numberOfInvalids();

                if(numbErrors){
                    var message = numbErrors == 1 ? 'You missed 1 field. Please Check Previous Steps.'
                                              : 'You missed ' + numbErrors + ' fields. Please Check Previous Steps.';
                    // $('div.error').html(message);
                    // $('div.error').show(); 
                }
                else{
                    // $('div.error').hide();
                }
            },

        /* Handle form submission */
            submitHandler: function(form){


                /* submit form using AJAX Request */
            },

        /* Elements to be ignored are set with .ignore class */
            ignore: ".ignore",

        /* Set validation rules & corresponding error-messages */
             rules:{
                'usermaster[sFirstName]': {
                    required: true,
                    minlength: 2
                },
                'usermaster[sLastName]': {
                    required: true,
                    minlength: 2
                },
                'loginmaster[sEmailID]': {
                     required: true,
                     email: true,
                     remote:({
                         url: 'https://www.stage.gospelscout.com/signup/gen_user/phpBackend/connectToDb.php' ,
                        //  success: (resp) => {
                        //     console.log(resp)
                        //  }
                     })
                 },
                 'loginmaster[sPassword]': {
                     required: true,
                     minlength: 8 
                 },
                 'loginmaster[ConfsPassword]': {
                     required: true,
                     equalTo: "#pwd"
                 },
                 'usermaster[iZipcode]': {
                     required: true,
                     minlength: 5,
                     maxlength: 5,
                     digits: true
                 },
                 'usermaster[sCountryName]': {
                     required: true
                 },
                 'usermaster[sStateName]': {
                     required: true
                 },
                 'loginmaster[sUserType]': {
                     required: true
                 },
                 'talentmaster[TalentID]': {
                     required: {
                         depends: function(element){
                             return $('#solo-type').is(':checked');
                         }
                     }
                 },
                 'usermaster[sGroupName]': {
                     required: {
                         depends: function(element){
                             return $('#group-type').is(':checked');
                         }
                     }
                 },
                 'usermaster[dDOB][month]': {
                    required: true
                  },
                    'usermaster[dDOB][day]': {
                    required: true
                  },
                    'usermaster[dDOB][year]': {
                    required: true
                  }
             },
             messages:{
                'usermaster[sStateName]': {
                    required: 'Please select your state'
                },
                'usermaster[iZipcode]': {
                    required: 'Please enter your zip code'
                },
                'usermaster[sFirstName]':{
                    required: 'Please enter a valid name',
                    minlength: 'Name must be at least 2 characters'
                },
                'usermaster[sLastName]':{
                    required: 'Please enter a valid name',
                    minlength: 'Name must be at least 2 characters'
                },
                'user-type': {
                     required: 'Please select a user type'
                 },
                 'usermaster[dDOB][month]': {
                  required: 'Please select a month'
                },
                  'usermaster[dDOB][day]': {
                  required: 'Please select a day'
                },
                  'usermaster[dDOB][year]': {
                  required: 'Please select a year'
                }
             }
    });

function validateZip(uState,zipCode) {
    /****** execute Javascript to contact google geocoding api ******/
        $.support.cors = true;
        $.ajaxSetup({ cache: false });
        var city = '';
        var hascity = 0;
        var hassub = 0;
        var state = '';
        var nbhd = '';
        var subloc = '';
        var userState = uState;
        var userZip = zipCode; 

        if(userZip.length == 5){
            var date = new Date();
            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
                //find the city and state
                    var address_components = response.results[0].address_components;
                    $.each(address_components, function(index, component){
                         var types = component.types;
                         $.each(types, function(index, type){
                            if(type == 'locality') {
                              city = component.long_name;
                              hascity = 1;

                            }
                            if(type == 'administrative_area_level_1') {
                              state = component.long_name;
                            }
                            if(type == 'neighborhood') {
                              nbhd = component.long_name;
                            }
                            if(type == 'sublocality') {
                              subloc = component.long_name;
                              hassub = 1;
                            }
                         });
                    });

                    if(state == userState){
                        $('#sCityName').val(city);
                        $('#apiStateName').val(state);
                    }
                    else{
                        $('#sCityName').val('');
                    }
            });
        }
    /****** END - execute Javascript to contact google geocoding api ******/
}

// const address = fetch("https://jsonplaceholder.typicode.com/users/1")
//   .then((response) => response.json())
//   .then((user) => {
//     return user.address;
//   });
// console.log(address);
// const printAddress = async () => {
//   const a = await address;
//   return a;
// };


   var test =  $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        // enableAllSteps: true,
        stepsOrientation: "vertical",
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate : '<div class="title">#title#</div>',
        labels: {
            previous : 'Back Step',
            next : '<i class="zmdi zmdi-arrow-right"></i>',
            finish : '<i class="zmdi zmdi-check"></i>',
            current : ''
        },
        onStepChanging: function(Eevent, currentIndex, newIndex){
            /** 
             * handle form validation at each step 
             **/
                /* define current inputs depending on current step */
                    if( currentIndex == 0 ){
                        var currentInputs = $('section.sect-0 input,section.sect-0 select');
                        var uState = $('#sStateName').val();
                        var zipCode = $('#iZipcode').val();
                        console.log(`${uState} &  ${zipCode}`);
                        if(uState != '' && zipCode!= ''){
                            validateZip(uState,zipCode);    
                        }
                        
                    }else if( currentIndex == 1 ){
                        var currentInputs = $('section.sect-1 input,section.sect-1 select');
                    }else{
                        var currentInputs = $('section.sect-2 input,section.sect-2 select');
                    }

                /* if all inputs are valid, move to next step */
                    var i = 0; 
                    currentInputs.each(function(){
                        if($(this).valid() == false){
                            i = i + 1; 
                        }
                    });

                /* if error var is greater than one */
                    if( i == 0){
                        if(currentIndex == 0){
                            /********************* if step 2 send verification code ********************/
                                sendConfCode();
                                return true; 
                            /******************* END - if step 2 send verification code *******************/
                        }else{
                          return true; 
                        }
                    }else {return false; } 

        },
        onFinishing: function (event, currentIndex) { 

            /* handle form submission - AJAX Request */
                var form = document.forms.namedItem('form-register');
                var formOBJ = new FormData(form);
                
                var xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    if(xhr.status == 200){
                        var response = xhr.responseText.trim();
                        console.log(response);
                        var parsedResponse = JSON.parse(response);
                        // console.log(parsedResponse);

                        if(parsedResponse.errorCount > 0){
                            if(parsedResponse.errorMessage === 'conf_code_invalid'){
                                var err_msg = '<div class="row"><div class="col-12"><p class="text-danger mt-0" style="font-size:.8em;margin-top:0;margin-bottom:0"><b>The confirmation code does not match</b></p>';
                                err_msg += '<p class="mt-0" style="font-size:.8em; margin-top:0;margin-bottom:0">Please <a onclick="sendConfCode()" class="text-primary">Re-send Code</a>.</p></div></div>';
                                $('#error-display').html(err_msg);
                            }
                          
                        }else {
                          /* if all inputs are valid - redirect to profile page */
                              window.location = parsedResponse.target_url;
                        }
                    }
                }
                xhr.open('post','https://www.stage.gospelscout.com/signup/gen_user/phpBackend/connectToDb.php');
                xhr.send(formOBJ);
        },
    })


   /* Step 2 - show/hide the proper form element based on radial input */
        $('.u-type').click(function(e){
            console.log('test');
            var isSolo = document.getElementById("solo-type").checked;
            var isGroup = document.getElementById("group-type").checked;

            $('#group-row').addClass('d-none');
            $('#solo-row').addClass('d-none');

            if( isSolo ){
                /* show the talent list */
                    $('#solo-row').removeClass('d-none');

                /* Clear group-talent selection */
                    $('#sGroupName').val('');

            }else if( isGroup ){
                /* show the group name input box */
                $('#group-row').removeClass('d-none');

                /* Clear solo-talent selection */
                    $('#TalentID').val('');
            }
        });
});



