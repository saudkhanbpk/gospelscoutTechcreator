
 function sendConfCode(){
    /* Send Verifcation Code Email */
    var emailConfForm = new FormData();
    emailConfForm.append('sendConfEmail', true);

    var emailConfXhr = new XMLHttpRequest();
    emailConfXhr.onload = function(){
        var response = emailConfXhr.responseText.trim();
        parsedResponse = JSON.parse(response);
        console.log(response);

        if(parsedResponse['error']){
            /* show error message */
                var err_msg = '<div class="row"><div class="col-12"><p class="text-danger mt-0" style="font-size:.8em;margin-top:0;margin-bottom:0">There was an error sending the confirmation code</p>';
                err_msg += '<p class="mt-0" style="font-size:.8em; margin-top:0;margin-bottom:0">Please <a href="https://www.gospelscout.com/#Contact-Us" target="_blank" class="text-primary">contact us</a>.</p></div></div>';
                $('#validation-error').html(err_msg);
        }
    }
    emailConfXhr.open('post','https://wwww.gospelscout.com/signup/phpBackend/connectToDb.php');
    emailConfXhr.send(emailConfForm); 
}
function submitForm(){
    /* handle form submission - AJAX Request */
    var form = document.forms.namedItem('form-register');
    var formOBJ = new FormData(form);
    formOBJ.append('formSubmit', true);

    var xhr = new XMLHttpRequest();
    xhr.onload = function(){
        if(xhr.status == 200){
            var response = xhr.responseText.trim();
            console.log(response);
            /* if all inputs are valid - redirect to profile page */ 
        }
    }
    xhr.open('post','https://www.gospelscout.com/signup/phpBackend/connectToDb.php');
    xhr.send(formOBJ);
}

$(function(){ 

    var signupForm = $('#signup-form');

    signupForm.validate({
        /* Error-message placement & styling */
             errorPlacement: function(error, element) {
                error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                element.after(error);
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
                     remote:'https://www.gospelscout.com/views/xmlhttprequest/artistBackend.php' 
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
                //  'loginmaster[sUserType]': {
                //      required: true
                //  },
                //  emailConf: {
                //      required: true,
                //  }

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
                }
             }
    });

   
    // $('#validation-error').on('click','#resend-conf',function(e){
    //     e.preventDefault();

    //     console.log('this is a test from resend function');
    //     /* resend confirmation code */
    //         sendConfCode();
    // });

    // $('.resend-conf').click(function(e){
    //     e.preventDefault();

    //     console.log('test this');
    // });

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
                console.log(currentIndex);
                    if( currentIndex == 0 ){
                        var currentInputs = $('section.sect-0 input,section.sect-0 select');
                        var uState = $('#sStateName').val();
                        var zipCode = $('#iZipcode').val();
                        if(uState != '' && zipCode!= ''){
                            validateZip(uState,zipCode);    
                        }
                        
                    }else if( currentIndex == 1 ){
                        var currentInputs = $('section.sect-1 input,section.sect-1 select');
                        /* send conf code */
                            sendConfCode();
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
                    if( i > 0){
                        return false; 
                    }else {
                        return true; 
                    } 
        },
        onFinishing: function (event, currentIndex) { 
            
            console.log('user is trying to submit form');

            /* check confirmation code */
                var confCode = $('input[name=verificationCode]').val();
                // console.log(`the conf code is: ${confCode}`);
                var checkConfxhr = new XMLHttpRequest();
                checkConfxhr.onload = function(){
                    if(checkConfxhr.status == 200){
                        var response = checkConfxhr.responseText.trim();
                        console.log(response);
                        var parsedResponse = JSON.parse(response);

                        if(parsedResponse.conf_true){
                            /* submit new user registration, sign-in user, re-direct to profile page */ 
                                submitForm();

                        }else{
                            /* display error message */
                                var err_msg = '<div class="row"><div class="col-12"><p class="text-danger mt-0" style="font-size:.8em;margin-top:0;margin-bottom:0"><b>The confirmation code was does not match</b></p>';
                                err_msg += '<p class="mt-0" style="font-size:.8em; margin-top:0;margin-bottom:0">Please <a onclick="sendConfCode()" class="text-primary">Re-send Code</a>.</p></div></div>';
                                $('#validation-error').html(err_msg);
                        }
                    }
                }
                checkConfxhr.open('get',`https://www.gospelscout.com/signup/phpBackend/connectToDb.php?conf_code=${confCode}`);
                checkConfxhr.send();

            // return true; 
        },
    })

   // console.log(test.onStepChanging() );


   /* Step 2 - show/hide the proper form element based on radial input */
        $('.u-type').on('click',function(e){
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



