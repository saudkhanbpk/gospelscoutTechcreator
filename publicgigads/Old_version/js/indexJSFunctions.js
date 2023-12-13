/******************************************************
 *** Store user's stripe token in DB once created
 ******************************************************/
	function stripeTokenHandler(token) {
	    /* Insert the token ID into the form so it gets submitted to the server */
	        var form = document.getElementById('payment-form');
	        var hiddenInput = document.createElement('input');
	        hiddenInput.setAttribute('type', 'hidden');
	        hiddenInput.setAttribute('name', 'stripeToken');
	        hiddenInput.setAttribute('value', token.id);
	        form.appendChild(hiddenInput);

	    /* Submit the form to the get_set_str_tok.php - update current user's customer object with payment src */
	        var newForm = new FormData(form);
	        newForm.append('action','add_src_tok');

	        var sendTok = new XMLHttpRequest();
	        sendTok.onreadystatechange = function(){
	            if(sendTok.status == 200 && sendTok.readyState == 4){

	                /* Display the confirmation modal for the current bid */
	                    var respTxt = sendTok.responseText.trim();
	                    var parse_respTxt = JSON.parse(respTxt);

	                    if(parse_respTxt['src_updated'] == true){
	                        /* Dismiss the "how it works"  modal and show the confirmation modal */
	                           	$('#bidToGig').modal('hide');
	                        	$('#conf_bidToGig').modal('show');
	                    }else{
	                    	/* Insert error into modal */ 
	                    		var err_message = '<p class="my-1 text-danger" style="font-size: .8em;">There was an error adding the payment source - Contact Us</p>';
	                    		$('#token_err_div').html(err_message);
	                    }
	            }
	        }
	        sendTok.open('POST','https://www.stage.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php');
	        sendTok.send(newForm);
	}
/******************************************************
 *** Store user's stripe token in DB once created
 ******************************************************/


/******************************************************
 *** Get userj's stripe customer info using str_cust_id
 ******************************************************/
	function get_str_cust_info(str_cust_id){
		var iLoginID = $('input[name=gigManLoginId]').val();
	    var newForm = new FormData();
	    newForm.append('action', 'check_pay_src');
	    newForm.append('u_action', 'post');
	    newForm.append('retrieve_cust', str_cust_id);
	    newForm.append('iLoginID', iLoginID);

	    var sendCust_info = new XMLHttpRequest();
	    sendCust_info.onreadystatechange = function(){
	        if(sendCust_info.readyState == 4 && sendCust_info.status == 200){
	            var respTxt = sendCust_info.responseText.trim();
	            
	            var parse_respTxt = JSON.parse(respTxt);
	            // console.log(parse_respTxt);

	            if(parse_respTxt['src_present']){
	                /* Set the data-target */
	                    $('#postGig').attr('get-modal','#conf_bidToGig'); 

	                /* Fill in current usage values for customer */
	                    // showCurrentUsage(parse_respTxt['current_usage']);
	            }
	            else{
	                /* Set the data-target */
	                    $('#postGig').attr('get-modal','#bidToGig');
	            }

	            /* Enable the Post Gig button */
	            	$('#postGig').removeProp('disabled');
			$('#postGig').html('Post Gig');
			
	            /* Temporarily store usage value access later */
	                // $('#current-u').attr('current-u',parse_respTxt['current_usage']);
	        }
	    }
	    sendCust_info.open('POST',"https://www.stage.gospelscout.com/views/xmlhttprequest/get_set_str_tok.php");
	    sendCust_info.send(newForm);
	}
/******************************************************
 *** END - Get userj's stripe customer info using str_cust_id
 ******************************************************/