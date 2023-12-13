/******************************************************
*** get client secret 
******************************************************/
async function getClientSecret () {
    const response = await fetch("https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php?create_intent=true");
    const client_sec = await response.json();
    return client_sec; 
};
/******************************************************
*** END - get client secret 
******************************************************/

/******************************************************
*** Get user's payment methods
******************************************************/
function fetchDisplayCurrMethod(firstLoad){
    /* Check for existing str. customer */ 
    var str_cust_form = new FormData();
    str_cust_form.append('check_str_cust',true);

  /* Send customer check xhr */
    var cust_check_xhr = new XMLHttpRequest(); 
    cust_check_xhr.onload = function(){
      if(cust_check_xhr.status == 200){
        var response = cust_check_xhr.responseText.trim(); 
        var parsedResponse = JSON.parse( response );

        /* Check & handle if src is present */
          if( parsedResponse.src_present ){
            $('#post_gig_btn_cnt').removeClass('d-none');
            /* Get user's other payment methods */
              if( parsedResponse.payment_methods !== 'none'){
                var payment_methods = parsedResponse.payment_methods;
                var default_payment_method_id = parsedResponse.cust_info.invoice_settings.default_payment_method;	
                /* Create the html to display payment methods - call function */
                  dispCurrPaymentMethods(default_payment_method_id, payment_methods);
              }
          }
          else{
			       if(firstLoad){
               /* Show Paymnent modal */
				        $('#bidToGig').modal('show');
             } 

            /* Display the "no payment method found" message and the "add payment src" button */
                var message = `<div class="container text-center">`
                message += `<div class="row"><div class="col"><p class="text-muted" style="font-weight:bold;font-size:2em">No Payment Method Found</p></div></div>`;
                message += `<a href="#" class="new_src"><div class="row"><div class="col-12"><p style="font-size:1em">Add New Payment Method</p></div></div></a>`;
                message += `</div>`;
                $('#curr_pay_display').html(message);
          }

        /* Enable the Post Gig button */
          $('#postGig').removeProp('disabled');
          $('#postGig').html('Post Gig');
      }
    }
    cust_check_xhr.open('post',"https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php");
    cust_check_xhr.send(str_cust_form);
}	
 function fetchDisplaymethods(){
    /* Call to the DB for payment methods */
        var newForm = new FormData(); 
        newForm.append('check_str_cust', true);

        get_methods_xhr = new XMLHttpRequest();
        get_methods_xhr.onload = function(){
        if(get_methods_xhr.status == 200){
            var response = get_methods_xhr.responseText.trim(); 
            var parsedResponse = JSON.parse(response);
            if(parsedResponse.src_present){
                var payment_methods = parsedResponse.payment_methods;
                var default_payment_method_id = parsedResponse.cust_info.invoice_settings.default_payment_method;
                dispPaymentMethods(default_payment_method_id, payment_methods);
            }else{
            /* error */
                var error_message = 'Trouble finding your payment methods';
            } 
        }
        }
        get_methods_xhr.open('post',"https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php");
        get_methods_xhr.send(newForm);
}
/******************************************************
*** END - Get user's payment methods
******************************************************/

/******************************************************
*** Display current payment method
******************************************************/
function dispCurrPaymentMethods(default_payment_method_id, methods){
    var default_payment_method_info = methods[default_payment_method_id];
    /* Default payment src display */
        var defaultPaymentDisplay = `<table class="table table-sm align-middle"><tbody>`;
        defaultPaymentDisplay += `<tr>`;
        defaultPaymentDisplay += `<th>Product:</th>`;
        defaultPaymentDisplay += `<td class="text-left"><div class="container"><div class="row"><div class="col">Gig Ad</div></div></div></td>`;
        defaultPaymentDisplay += `</tr>`;
        defaultPaymentDisplay += `<tr>`;
        defaultPaymentDisplay += `<th><a href="#" id="reveal-payment-methods" style="text-decoration:underline;">Pay with</a></th>`;
        defaultPaymentDisplay += `<td class="text-left"><div class="container"><div class="row"><div class="col"><span style="font-weight:bold">${default_payment_method_info['card_type']}</span> ****${default_payment_method_info['last4']}</div></div><div class="row"><div class="col">Exp ${default_payment_method_info['exp_month']}/${default_payment_method_info['exp_year']}</div></div></div></td>`;
        defaultPaymentDisplay += `</tr>`;
        defaultPaymentDisplay += `<tr>`;
        defaultPaymentDisplay += `<th>Total</th>`;
        defaultPaymentDisplay += `<td class="text-left"><div class="container"><div class="row"><div class="col"><span style="font-weight:bold">$1.00</span></div></div></div></td>`;
        defaultPaymentDisplay += `</tr>`;
        defaultPaymentDisplay += `</tbody></table>`;
        $('#curr_pay_display').html(defaultPaymentDisplay);
}
/******************************************************
*** END - Display current payment method
******************************************************/

/******************************************************
*** Display payment methods
******************************************************/
function dispPaymentMethods(default_payment_method_id, methods){
    /* Payment methods display */
        var methodsDisplay = `<div class="container pl-md-0"><div class="row pl-md-0 ml-md-0"><div class="col pl-md-0 ml-md-0"><p class="m-0 p-0 text-md-left" style="font-weight:bold;">Other Payment Methods</p></div></div></div>`;
        methodsDisplay += `<table class="table table-sm align-middle table-borderless"><tbody>`;
        methodsDisplay += `<tr><th><a href="#" style="text-decoration:underline;" id="cancel-newPayment-method">Back</a></th></tr>`;
        for (const method in methods) {
            if (Object.hasOwnProperty.call(methods, method)) {
                const element = methods[method];
                if( method == default_payment_method_id ){
                    methodsDisplay += `<tr class="table-active"><th class="align-middle"><input checked`;
                }else{
                    methodsDisplay += `<tr><th class="align-middle"><input`;
                }
                methodsDisplay += ` class="change_pay_method" value="${method}" type="radio" name="current_payment_method"></th><td class="text-left"><div class="container"><div class="row"><div class="col"><span style="font-weight:bold">${element['card_type']}</span> ****${element['last4']}</div></div><div class="row"><div class="col">Exp ${element['exp_month']}/${element['exp_year']}</div></div></div></td></tr>`;
            }
        }
        methodsDisplay += `</tbody></table>`;
        methodsDisplay += `<div class="container">`;
        methodsDisplay += `<a href="#" class="new_src"><div class="row"><div class="col-12 text-left"><p style="font-size:1em">Add New Payment Method</p></div></div></a>`;
        methodsDisplay += `</div>`;
                                        
        $('#curr_pay_display').html(methodsDisplay);
}
/******************************************************
*** END - Display payment methods
******************************************************/

/******************************************************
 *** Store user's stripe token in DB once created
 ******************************************************/
 function stripeTokenHandler(gigID,paymentIntent_id) {
        var sendTok = new XMLHttpRequest();
        sendTok.onreadystatechange = function(){
          if(sendTok.status == 200 && sendTok.readyState == 4){
            var respTxt = sendTok.responseText.trim();
            console.log(respTxt);
            var parse_respTxt = JSON.parse(respTxt);
            console.log(parse_respTxt);
            if(parse_respTxt['payment_status_updated'] == true && parse_respTxt['payment_verified'] == true){
                /* Redirect to ad_details Page */
                    window.location = `https://www.gospelscout.com/publicgigads/ad_details.php?g_id=${gigID}`;
            }else{
                /* Insert error into modal */ 
                    console.log(parse_respTxt['error']);
                    var err_message = '<p class="my-1 text-danger" style="font-size: .8em;">There was an error Charging the payment source - Contact Us</p>';
                    $('#token_err_div').html(err_message);
            }
          }
        }
        sendTok.open('GET',`https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php?verify_payment_status=true&gigid=${gigID}&pi_id=${paymentIntent_id}`);
        sendTok.send();
}
/******************************************************
*** END - Store user's stripe token in DB once created
******************************************************/

