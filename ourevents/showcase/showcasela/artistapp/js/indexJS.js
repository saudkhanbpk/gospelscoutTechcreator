        
 /* Form for users donating */
     const form5 = $('#artist-form');

    form5.validate({
        
         //Error display and placement 
            errorPlacement: function(error, element) {
                console.log(error[0]['id']);
                error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                element.after(error); 
            },

         // Handle form when submission is In-Valid
            invalidHandler: function(event, validator){
                 var numbErrors = validator.numberOfInvalids();
                 if(numbErrors){
                     var message = numbErrors == 1 ? 'You missed 1 field. Please Check Previous Steps.'
                     : 'You missed ' + numbErrors + ' fields. Please complete the marked fields.';
                     $('div.error').html(message);
                     $('div.error').show(); 
                 }
                 else{
                     $('div.error').hide();
                 }
            },

         // Handle form when submission is valid 
            submitHandler: function(form){
                 
                 /* Display the loading modal */
                     let action = 'show';
                     displayLoadingPage(action);

                 /* Create a token or display an error when the form is submitted. */
                            
                    /* Create a charge here */
                        var tokenD = new FormData(form); 
                        var newCharge = new XMLHttpRequest();
                        newCharge.onload = function(){
                            
                            if( newCharge.status == 200 ){
                                // console.log( newCharge.responseText.trim() );
                                var parsedResponse = JSON.parse( newCharge.responseText.trim() );
                                // console.log(parsedResponse);

                                /* Hide the loading modal */
                                    let action = 'hide';
                                    displayLoadingPage(action);

                                if(parsedResponse.submitted == true){
                                    /* Show a successful donation modal and clear payment form */
                                        $('.art_name').text( $('input[name=name]').val() );

                                    /* Clear artist form */
                                    document.getElementById("artist-form").reset();

                                    /* Show successful donation message */
                                        $('#donation_success').modal('show');
                                }
                                else{
                                    /* Show a failed donation modal */
                                        $('.don_name').text( $('input[name=donor_fname]').val() );
                                        $('#don_chargeStatus').text( parsedResponse.exception.jsonBody.error.code );
                                        $('#don_reason').text( parsedResponse.exception.jsonBody.error.message );

                                    /* Show a un-successful donation modal and don't clear payment form */
                                        $('#donation_failure').modal('show');
                                }
                            }
                        }
                        newCharge.open('post', 'https://www.stage.gospelscout.com/ourevents/showcase/showcasela/artistapp/phpBackend/connectToDb.php');
                        newCharge.send(tokenD);
            },

         // Set Validation rules 
             rules: {
                 'name': {
                     required: true
                 },
                 'city': {
                     required: true
                 },
                 'state': {
                     required: true
                 },
                 'zipcode': {
                     required: true
                 },
                 'talent': {
                     required: true
                 },
                 'email': {
                     required: true,
                     email: true
                 },
                 'phone': {
                     required: true,
                     digits: true,
                     maxlength: 10,
                     minlength:10
                 },
                 'authorization': {
                    required: true
                },
             },
             messages:{
                 'name': {
                     required: 'Please enter your name'
                 },
                 'city': {
                     required: 'Please enter your city'
                 },
                 'state': {
                     required: 'Please select the state your business resides in'
                 },
                 'zipcode': {
                    required: 'Please enter your zip code'
                },
                 'talent': {
                     required: 'Please give a brief description of your product or service'
                 },
               
                 'email': {
                     required: 'Please enter your email address',
                     email: 'Please enter a valid email address'
                 },
                 'phone': {
                     required: 'Please enter your phone number',
                     digit: 'Please enter numeric values only',
                     maxlength: 'Please enter a valid phone number',
                     minlength: 'Please enter a valid phone number',
                 },
                 'authorization': {
                    required: 'Please confirm that you agree to the vendor terms of #shedLA'
                },
             }
        });
