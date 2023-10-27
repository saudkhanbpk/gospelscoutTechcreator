/******************************************************
*** get client secret 
******************************************************/
    async function getClientSecret () {
    const response = await fetch("https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php?setup_intent=true");
    const client_sec = await response.json();
    return client_sec;
};
/******************************************************
*** END - get client secret 
******************************************************/

/******************************************************
*** Get user's payment methods
******************************************************/
function fetchDisplayCurrMethod(){
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
            /* Get user's other payment methods */
              if( parsedResponse.payment_methods !== 'none'){
                var payment_methods = parsedResponse.payment_methods;
                var default_payment_method_id = parsedResponse.cust_info.invoice_settings.default_payment_method;	
                /* Create the html to display payment methods - call function */
                  dispCurrPaymentMethods(default_payment_method_id, payment_methods);
              }
          }
          else{
            /* Display the "no payment method found" message and the "add payment src" button */
                var message = `<div class="container text-center">`
                message += `<div class="row"><div class="col"><p class="text-muted" style="font-weight:bold;font-size:1.2em">No Default Payment Method Found</p></div></div>`;
                message += `</div>`;
                $('#displayCurrentPaymentMethods').html(message);
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
        // const data = new URLSearchParams(newForm);

        get_methods_xhr = new XMLHttpRequest();
        get_methods_xhr.onload = function(){
        if(get_methods_xhr.status == 200){
            var response = get_methods_xhr.responseText.trim(); 
            var parsedResponse = JSON.parse(response);
            
            if(parsedResponse.method_count > 0){ 
                var payment_methods = parsedResponse.payment_methods;
                var default_payment_method_id = parsedResponse.cust_info.invoice_settings.default_payment_method;
                dispPaymentMethods(default_payment_method_id, payment_methods);
            }else{
            /* error */
                var error_message = '<div class="container"><div class="row"><div class="col-12 text-center"><p class="text-muted" style="font-weight:bold;font-size:1.5em">No additional payment methods found</p></div></div>';
				        error_message += `<a href="#" class="new_src"><div class="row"><div class="col-12 text-left"><p style="font-size:1em">Add New Payment Method</p></div></div></a></div>`;
                $('#displayAddtlPaymentMethods').html(error_message);
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
        var defaultPaymentDisplay = `<table class="table table-sm align-middle" style="font-size:.8em"><tbody>`;
        defaultPaymentDisplay += `<tr>`;
        defaultPaymentDisplay += `<td class="text-left"><div class="container"><div class="row"><div class="col"><span style="font-weight:bold">${default_payment_method_info['card_type']}</span> ****${default_payment_method_info['last4']}</div></div><div class="row"><div class="col">Exp ${default_payment_method_info['exp_month']}/${default_payment_method_info['exp_year']}</div></div></div></td>`;
        defaultPaymentDisplay += `</tr>`;
        defaultPaymentDisplay += `</tbody></table>`;
        $('#displayCurrentPaymentMethods').html(defaultPaymentDisplay);
}
/******************************************************
*** END - Display current payment method
******************************************************/

/******************************************************
*** Display payment methods
******************************************************/
function dispPaymentMethods(default_payment_method_id, methods){
    /* Payment methods display */
        var methodsDisplay = `<table class="table table-sm align-middle table-borderless" style="font-size:.9em"><tbody>`;
        for (const method in methods) {
            if (Object.hasOwnProperty.call(methods, method)) {
                const element = methods[method];
                if( method == default_payment_method_id ){
                    methodsDisplay += `<tr class="table-active"><th class="align-middle"><input checked`;
                }else{
                    methodsDisplay += `<tr><th class="align-middle"><input`;
                }
                methodsDisplay += ` class="change_pay_method" value="${method}" type="radio" name="current_payment_method"></th><td class="text-left"><div class="container"><div class="row"><div class="col"><span style="font-weight:bold">${element['card_type']}</span> ****${element['last4']}</div></div><div class="row"><div class="col">Exp ${element['exp_month']}/${element['exp_year']}</div></div></div></td><td class="text-danger font-weight-bold"><a id="remove_payment_method" href="#" pm="${method}">Remove</a></td></tr>`;
            }
        }
        methodsDisplay += `</tbody></table>`;
        methodsDisplay += `<div class="container">`;
        methodsDisplay += `<a href="#" class="new_src"><div class="row"><div class="col-12 text-left"><p style="font-size:1em">Add New Payment Method</p></div></div></a>`;
        methodsDisplay += `</div>`;
                                        
        $('#displayAddtlPaymentMethods').html(methodsDisplay);
}
/******************************************************
*** END - Display payment methods
******************************************************/

/******************************************************
*** Remove payment methods
******************************************************/
    function removePayMethod(pm){
        var remove_pm_form = new FormData();
        remove_pm_form.append('action','remove_payment_method');
        remove_pm_form.append('pm',pm);

        var remove_pm_xhr = new XMLHttpRequest();
        remove_pm_xhr.onload = function(){
            if(remove_pm_xhr.status == 200){
                var response = remove_pm_xhr.responseText.trim();
                fetchDisplaymethods();
                fetchDisplayCurrMethod();
            }
        }
        remove_pm_xhr.open('post',"https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php");
        remove_pm_xhr.send(remove_pm_form);
    }
/******************************************************
*** END - Remove payment methods
******************************************************/

/******************************************************
 *** Store user's stripe token in DB once created
 ******************************************************/
 function stripeTokenHandler(token) {
		                
    /* Insert the token ID into the form so it gets submitted to the server */
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token);
        form.appendChild(hiddenInput);

    /* Submit the form to the get_set_str_tok.php - update current user's customer object with payment src */
        var newForm = new FormData(form);
        newForm.append('action','update_def_payment_method');

        var sendTok = new XMLHttpRequest();
        sendTok.onreadystatechange = function(){
            if(sendTok.status == 200 && sendTok.readyState == 4){
				 /* Display the confirmation modal for the current bid */
                   
                /* Replace loading spinner with submit button then disable button */
                (async () => {
                    $('#submitContainer').html('<button class="btn btn-sm btn-gs mt-3" id="submit">Submit</button>');
                })().then( () => {document.getElementById('submit').disabled = true;});
                
                
                /* Display the confirmation modal for the current bid */
                    var respTxt = sendTok.responseText.trim();
                    var parse_respTxt = JSON.parse(respTxt);
                    if(parse_respTxt['src_updated'] == true ){
                        var payment_methods = parse_respTxt.data;
                        var default_payment_method_id = parse_respTxt.cust_info;

                        /* Dismiss the "how it works" modal and show the confirmation modal */
                            (async () => {
                                dispCurrPaymentMethods(default_payment_method_id, payment_methods);
                            })().then( () => {$('#bidToGig').modal('hide');})
                    }else{
                        /* Insert error into modal */ 
                            var err_message = '<p class="my-1 text-danger" style="font-size: .8em;">There was an error adding the payment source - Contact Us</p>';
                            $('#token_err_div').html(err_message);
                    }
            }
        }
        sendTok.open('POST',`https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php`);
        sendTok.send(newForm);
}
/******************************************************
*** END - Store user's stripe token in DB once created
******************************************************/

