/*************************************************
 *** Check if current user has strip cust. obj id
 *************************************************/
 $(document).on('ready',function(){
    fetchDisplayCurrMethod(true);
  });
/*************************************************
 *** END - Check if current user has strip cust. obj id
 *************************************************/

 /*************************************************
 *** Hide/Reveal customers addt'l payment methods
 *************************************************/
  /* show */ 
  $('#curr_pay_display').on('click','#reveal-payment-methods',function(e){
    e.preventDefault();
    $('#post_gig_btn_cnt').addClass('d-none');
    displayLoadingElement('curr_pay_display');
    
    /* call js function to fetch and display all payment methods */
      fetchDisplaymethods();
  });

/* hide */
$('#curr_pay_display').on('click','#cancel-newPayment-method', function(e){
  e.preventDefault();
  $('#post_gig_btn_cnt').removeClass('d-none');
  displayLoadingElement('curr_pay_display');

  /* call js function to fetch and display current payment method */
    fetchDisplayCurrMethod();
});
/*************************************************
*** END - Reveial customers addt'l payment methods
*************************************************/

/*************************************************
*** Highlight selected payment method
*************************************************/
$('#curr_pay_display').on('click','.change_pay_method', function(e){
    
  displayLoadingElement('curr_pay_display');
  var payment_meth = $(this).val();
  
  /* Create new form */
    var pay_meth_form = new FormData();
    pay_meth_form.append('stripeToken', payment_meth); 
    pay_meth_form.append('action', 'update_def_payment_method');

  /* Create new AJAX request */
    var pay_meth_xhr = new XMLHttpRequest(); 
    pay_meth_xhr.onload = function(){
      if(pay_meth_xhr.status == 200){
        $('#post_gig_btn_cnt').removeClass('d-none');
        var response = pay_meth_xhr.responseText.trim();
        var parsedResponse = JSON.parse(response);

        if(parsedResponse.src_updated){
          /* call js function to fetch and display current payment method */
            fetchDisplayCurrMethod();
        }
      }
    }
    pay_meth_xhr.open('post', "https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php");
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
 $('#curr_pay_display').on('click','.new_src', function(e){
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
  $('#post_gig_btn_cnt').removeClass('d-none');
  displayLoadingElement('curr_pay_display');
  /* call display current payment method */
    fetchDisplayCurrMethod();
});
/*************************************************
*** END - Display current pay method when modal closes
************************************************/


/************************************************
 *** Create stripe form to collect customer info
 ************************************************/
 "use strict";
 /* Set your publishable key */
   var stripe = Stripe('pk_live_OGrw56hK2CpvoGTZgIrzQPHk');
   var gigID = $('input[name=gigid]').val();

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
             if ( !(event.complete) ) {
               if( !(document.getElementById('submit')) === false ){
                 document.getElementById('submit').disabled = true;
               }
             } else if( event.complete ) {
                 document.getElementById('submit').disabled = false;
             }
         });
        /* Collect user payment from existing payment src */
      $('#submitInquiry').on('click',function(e){
        e.preventDefault(); 
        displayLoadingElement('curr_pay_display');

        /* Ajax request to submit user payment */
          var take_payment = new XMLHttpRequest(); 
          take_payment.onload = function(){
            if(take_payment.status == 200){
              var response = take_payment.responseText.trim();
              var parsedResponse = JSON.parse(response);
              if(parsedResponse.pay_intent.status == 'succeeded'){
                if(parsedResponse.payment_status_updated){
                  window.location = `https://www.gospelscout.com/publicgigads/ad_details.php?g_id=${gigID}`;
                }else{
                  $('#main-error-div').html("There was an error updating your Gig Ad's payment status");
                }
              }else{
                $('#main-error-div').html('There was an error processing your payment');
              }
            }
          }
          take_payment.open('get',`https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php?take_payment=true&gigid=${gigID}`);
          take_payment.send();
      });

        /* Create a token or display an error when the stripe form is submitted. */
        var form = document.getElementById('payment-form');
        console.log(form);
        console.log('test123');
        // $("#submit").on('click', (e) => {
        //     e.preventDefault(); 
        //     document.getElementById('payment-form').submit();
        // });
        // form.addEventListener('submit', function(event) {
        $('#submit').on('click', function(event){
          console.log('test');
           event.preventDefault();
           console.log('test');
           displayLoadingElement('submitContainer');

           const collectPaymentInfo = async () => {
                return await stripe.confirmPayment({ 
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
                     var paymentStatus = result.paymentIntent.status;
                     if(paymentStatus === 'succeeded'){
                         /* Retrieve Payment intent and verify payment status */
                            // Pass paymentIntent id to function
                            var pi_id = result.paymentIntent.id;
                            stripeTokenHandler(gigID,pi_id);

                    //    var defaultMethod = result.paymentIntent.id;
                    //    stripeTokenHandler(defaultMethod);
                     }else {
                         console.log(paymentStatus);
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