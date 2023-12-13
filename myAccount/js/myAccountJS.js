	/* Fetch the payment methods */ 
        // Current pay method
            fetchDisplayCurrMethod();
        // All pay methods
            fetchDisplaymethods();

/*************************************************
*** Highlight selected payment method
*************************************************/
$('#displayAddtlPaymentMethods').on('click','.change_pay_method', function(e){
    
    displayLoadingElement('displayCurrentPaymentMethods');
    var payment_meth = $(this).val();
    
    /* Create new form */
      var pay_meth_form = new FormData();
      pay_meth_form.append('stripeToken', payment_meth); 
      pay_meth_form.append('action', 'update_def_payment_method');
  
    /* Create new AJAX request */
      var pay_meth_xhr = new XMLHttpRequest(); 
      pay_meth_xhr.onload = function(){
        if(pay_meth_xhr.status == 200){
          var response = pay_meth_xhr.responseText.trim();
          var parsedResponse = JSON.parse(response);
  
          if(parsedResponse.src_updated){
            /* call js function to fetch and display current payment method */
              fetchDisplayCurrMethod();
          }
        }
      }
      pay_meth_xhr.open('post', "https://www.stage.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php");
      pay_meth_xhr.send(pay_meth_form);
  
    $('.change_pay_method').closest('tr').removeClass('table-active');
    $(this).closest('tr').addClass('table-active');
  })
/*************************************************
  *** END - Highlight selected payment method
  *************************************************/

/********************************
 *** Add new payment src
 ********************************/
 $('#displayAddtlPaymentMethods').on('click','.new_src', function(e){
    e.preventDefault();
  
    /* open new payment modal */
    $('#bidToGig').modal('show');
  });
/********************************
 *** END - Add new payment src
********************************/
  
/*************************************************
 *** Display current pay method when modal closes
************************************************/
   $('#bidToGig').on('hidden.bs.modal', function (event) {
    $('#submitInquiry').removeClass('d-none');
    displayLoadingElement('displayCurrentPaymentMethods');
    displayLoadingElement('displayAddtlPaymentMethods');
    /* call display current payment method */
      fetchDisplayCurrMethod();
      fetchDisplaymethods();
  });
/*************************************************
 *** END - Display current pay method when modal closes
************************************************/

$('#displayAddtlPaymentMethods').on('click','#remove_payment_method',function(e){
    e.preventDefault();
    displayLoadingElement('displayCurrentPaymentMethods');
    displayLoadingElement('displayAddtlPaymentMethods');
    var pm = $(this).attr('pm');
    removePayMethod(pm);

    /* call confirmation modal */
});
/************************************************
 *** Create stripe form to collect customer info
************************************************/
   "use strict";
   /* Set your publishable key */
     var stripe = Stripe('pk_live_OGrw56hK2CpvoGTZgIrzQPHk');
  
  /* Style the card & payment elements */
     const appearance = {
         theme: 'stripe',
         variables: {
             colorText: '#32325d',
             fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
             fontSizeBase: '10px',
         },
     };
     
    getClientSecret().then( (r) => {
       let clientSecret = r['pay_intent']['client_secret']; 
       
       const elements = stripe.elements({ clientSecret, appearance });
       const paymentElement = elements.create('payment');
  
       /* Mount payment elements */
         paymentElement.mount("#payment-element");
       
       /* Detect errors */
           paymentElement.on('change', function(event) {
               if( !(event.complete) ) {
                 if( !(document.getElementById('submit')) === false ){
                   document.getElementById('submit').disabled = true;
                 }
               } else if( event.complete ) {
                   document.getElementById('submit').disabled = false;
               }
           });
  
       /* Create a token or display an error when the stripe form is submitted. */
         var form = document.getElementById('payment-form');
         form.addEventListener('submit', function(event) {
             event.preventDefault();
             displayLoadingElement('submitContainer');
             const collectPaymentInfo = async () => {
                return await stripe.confirmSetup({ 
                   elements,
                   confirmParams: {
                       return_url: 'https://my-site.com/order/123/complete',
                   },
                   redirect: 'if_required',
               });
             }
           
             collectPaymentInfo().then( (result) => {
               if(result.error){
                   /* Handlle Error */
                       var chargeCode = result.error.code;
                       var chargeMessage = result.error.message;
                       var displayMessage = `${chargeCode} - ${chargeMessage}`; 
                   
                    /* display error message */
                    if(chargeCode != 'incomplete'){
                        $('#error-div').html(displayMessage);
                    }

                (async () => {
                    $('#submitContainer').html('<button class="btn btn-sm btn-gs mt-3" id="submit">Submit</button>');
                })().then( () => {document.getElementById('submit').disabled = true;});
       
               }else{
                   /* reset form */
                     paymentElement.clear();
  
                   /* Handle Successful Payment */
                       $('#error-div').html('');
                       var paymentStatus = result.setupIntent.status;
                       if(paymentStatus === 'succeeded'){
                         var defaultMethod = result.setupIntent.payment_method;
                         stripeTokenHandler(defaultMethod);
                       }
               }  
             });
          });
      });
/*****************************************************
 *** END - Create stripe form to collect customer info
*****************************************************/

$('#bidToGig').on('hidden.bs.modal',function(e){
    (async () => {
        $('#submitContainer').html('<button class="btn btn-sm btn-gs mt-3" id="submit">Submit</button>');
    })().then( () => {document.getElementById('submit').disabled = true;});

    /* Clear error messages */
        $('#error-div').html('');       
})
    
    /* Date and Time Picker plugin JS */
    $(function () {
        var dat = $("input[name=todaysDate]").val();
         $("#datetimepicker1").datetimepicker({
             format: "YYYY-MM-DD",
             defaultDate: false,
             minDate: dat,
             //minDate: moment(),
             maxDate: moment().add(1,'year'),
             //useCurrent: true, 
             allowInputToggle: true
         });
         $("#datetimepicker2").datetimepicker({
              format: "LT",
            stepping: "5",
            useCurrent: false,
            allowInputToggle: true
        });
        $("#datetimepicker3").datetimepicker({
             format: "YYYY-MM-DD",
             defaultDate: false,
             // minDate: dat,
             //minDate: moment(),
             maxDate: moment().add(1,'year'),
             //useCurrent: true, 
             allowInputToggle: true
         });
    });
/* END - Date and Time Picker plugin JS */

/* Validate user's current password as part of a password update */
    function checkPword(){
        var currentPword = $('input[name=sCurrentPassword]').val();
        var userID = $('input[name=userID]').val(); 
        var checkPwrdForm = new FormData();
        checkPwrdForm.append('sPassword', currentPword);
        checkPwrdForm.append('table', 'loginmaster'); 
        checkPwrdForm.append('checkPword', 1); 
        checkPwrdForm.append('iLoginID', userID); 

        if(currentPword != ''){
            $('#noPass').addClass('d-none');

            var checkPwrd = new XMLHttpRequest();
            checkPwrd.onreadystatechange = function(){
                if(checkPwrd.readyState == 4 && checkPwrd.status == 200){
                    console.log(checkPwrd.responseText);
                    if(checkPwrd.responseText == 'pwrdValid'){
                        $('#hideCurrentPword').addClass('d-none');
                        $('.newPwrds').removeClass('d-none');
                    }
                    else{
                        $('#noPass').html('<span class="text-danger">Password Incorrect</span>');
                        $('#noPass').removeClass('d-none');
                    }
                }
            }
            checkPwrd.open('POST','updateMyAccount.php');
            checkPwrd.send(checkPwrdForm);
        }
        else{
            $('#noPass').html('Please enter your current password.');
            $('#noPass').removeClass('d-none');
        }
    }
/* END - Validate user's current password as part of a password update */

/* Submit Form Changes for ministries and talents */	
    $('.sectionEdit').click(function(event){
        event.preventDefault(); 

        var userID = $('input[name=userID]').val(); 
        var formName = $(this).attr('formId');
        var table = $(this).attr('table');
        var getForm = document.forms.namedItem(formName);
        var newFormD = new FormData(getForm);
        newFormD.append('table', table);
        newFormD.append('iLoginID', userID); 
        
        // console.log('testing this');
        /* Create New XMLHttpRequest */
            var updateSection = new XMLHttpRequest(); 
            updateSection.onreadystatechange = function() {
                if(updateSection.status == 200 && updateSection.readyState == 4){
                    console.log(updateSection.responseText); 
                    /* Refresh Page When a new ministry, amenity, or talent is added or removed */
                        if(table == 'churchministrymaster2' || table == 'talentmaster' || table == 'churchamenitymaster2' || table == 'groupmembersmaster'){
                            if(updateSection.responseText == ''){
                                console.log('no response');
                                location.reload(); 
                            }
                        }
                    /* Remove previous update message and Show new update message */
                        $('#acct-update-message').remove();
                        if(updateSection.responseText != ''){
                            /* Error Message Display */
                                var UpdateMessage = '<div class="container p-2 text-center mb-0" id="acct-update-message"><div class="row"><div class="col col-md-5">';	
                                UpdateMessage += '<p class="m-0 p-2 text-gs" id="update-message">'+updateSection.responseText+'</p></div></div></div>';	    
                             /* Append the update result message to the perspective form */
                                    $('form[name='+formName+']').append(UpdateMessage);
                            /* Only fade out the successful update messages */	
                                if(updateSection.responseText === 'Your Account Has Been Updated!!!'){
                                    console.log('test');
                                    $("#acct-update-message").fadeOut(3000);
                                }
                        }
                }
            }
            updateSection.open('POST', 'updateMyAccount.php');
            updateSection.send(newFormD);
    });

    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            else{
                event.preventDefault();
                var userID = $('input[name=userID]').val(); 
                var formName = form.name;
                var table = $(this)[0][0].value; 

                var getForm = document.forms.namedItem(formName);
                var newFormD = new FormData(getForm);
                newFormD.append('iLoginID', userID); 
                /* Create New XMLHttpRequest */
                    var updateSection = new XMLHttpRequest(); 
                    updateSection.onreadystatechange = function() {
                        if(updateSection.status == 200 && updateSection.readyState == 4){
                            console.log('testing this');
                            console.log(updateSection.responseText.trim());
                            /* Refresh Page When a new ministry, amenity, or talent is added or removed */
                                if(table == 'churchministrymaster2' || table == 'talentmaster' || table == 'churchamenitymaster2' || table == 'churchtimeing' || table == 'groupmembersmaster'){
                                    if(updateSection.responseText.trim() == ''){
                                        location.reload(); 
                                    }
                                }
                            /* Remove previous update message and Show new update message */
                                $('#acct-update-message').remove();
                                if(updateSection.responseText != ''){
                                    var response = updateSection.responseText.trim();

                                    /* When password updated */
                                        if(response == '1'){
                                            response = 'Your Password Has Been Updated!!!';
                                        }

                                    /* Error Message */
                                        var UpdateMessage = '<div class="container p-2 text-center mb-0" id="acct-update-message"><div class="row"><div class="col col-md-5">';	
                                        UpdateMessage += '<p class="m-0 p-2 text-gs" id="update-message">'+response+'</p></div></div></div>';	    
                                        
                                    /* Append the update result message to the perspective form */
                                        $('form[name='+formName+']').append(UpdateMessage);

                                    /* Only fade out the successful update messages */	
                                        if(response === 'Your Account Has Been Updated!!!' || response === 'Your Password Has Been Updated!!!'){
                                            $("#acct-update-message").fadeOut(3000);
                                             setTimeout(function(){ window.location.href = 'https://www.stage.gospelscout.com/myAccount';},3100);
                                        }
                                }
                        }
                    }
                    updateSection.open('POST', 'updateMyAccount.php?po');
                    /* check if location parameters are valid for sending request */
                        //1. check for the form name
                        if(formName == 'locationInfo'){
                            /* Insert the zip code validation and google query here */
                                //2. grab the zip code from the form for testing and city retrieval 
                                var newZip = $('input[name=iZipcode]').val();
                                
                                //3. Send the zip code to the the google api for city retrieval and comparison using zip validation funct
                                validateZip0(newZip,updateSection,newFormD);
                        }
                        else{
                            updateSection.send(newFormD);
                        }
            }
            form.classList.add('was-validated');
          }, false);
        });

      }, false);
    })();
/* END - Submit Form Changes */	

/****************** validate Zip code *************************/
function validateZip0(userZip,updateSection,newFormD){
    /****** execute Javascript to contact google geocoding api ******/
        $.support.cors = true;
        $.ajaxSetup({ cache: false });
        var city = '';
        var hascity = 0;
        var hassub = 0;
        var state = '';
        var nbhd = '';
        var subloc = '';
        
        if(userZip.length == 5){
            var date = new Date();
            var testJSON = $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
                                 
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
                                hasnbhd = 1;
                            }
                            if(type == 'sublocality') {
                                subloc = component.long_name;
                                hassub = 1;
                            }
                        });
                    });

                    /* Loop throught the select options to grab the statename for comparison to api results */

                    $('#sStateName > option:selected').each(function() {
                        var userState = $(this).text();	
                        
                        if(state == userState){
                            $('#zipStateErrorDiv').hide(); 
                            
                            if(hascity == 1){
                                $('#sCityName').val(city);
                                newFormD.append('sCityName',city);
                            }
                            else if(hasnbhd == 1){
                                $('#sCityName').val(nbhd);
                                newFormD.append('sCityName',nbhd);
                            }

                            /* Send XMLHttpRequest if state and zip code match */
                                updateSection.send(newFormD);
                        }
                        else{
                            $('#zipStateErrorDiv').show(); 
                            $('#zipStateError').text('State/Zip code Mismatch');
                        }
                        
                        
                    });

            }); 
              }
          /****** END - execute Javascript to contact google geocoding api ******/
}
/*************** END - validate Zip code **********************/

/********************* List and Update Payment info *********************/


/****************** END - Deactivate User account ******************/

/********************* Deactivate User account *********************/
$('#deactMyAcct').click(function(event){
    var deactExplan = document.getElementById('u_DeactReason').value; 
    if(deactExplan){
        $('#deactErr').html('');
        $('#confirmDeactivation').modal('show');
    }
    else{
        $('#deactErr').html('Reason for deactivation required!!!');
    }
});
$('.deact_user').click(function(event){
    event.preventDefault();

    var deactForm = document.forms.namedItem('deactAcct');
    var deactForm1 = new FormData(deactForm);

    var sendDeactForm = new XMLHttpRequest()
    sendDeactForm.onreadystatechange = function(){
        if(sendDeactForm.readyState == 4 && sendDeactForm.status == 200){
            $('#confirmDeactivation').modal('hide');
            if(sendDeactForm.responseText.trim() > 0){
                window.location = "<?php echo URL;?>index.php?deact=1";
            }
        }
    }
    sendDeactForm.open('post','<?php echo URL;?>adminDashboard/concept-master/adminDeact-acct.php');
    sendDeactForm.send(deactForm1);
});
/****************** END - Deactivate User account ******************/