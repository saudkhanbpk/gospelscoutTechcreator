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
	        sendTok.open('POST','https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok_new.php');
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
	    sendCust_info.open('POST',"https://www.gospelscout.com/views/xmlhttprequest/get_set_str_tok.php");
	    sendCust_info.send(newForm);
	}
/******************************************************
 *** END - Get userj's stripe customer info using str_cust_id
 ******************************************************/

 /******************************************************
 *** Handle Search criteria form
 ******************************************************/
function submitFormData(page_no, id) {
	$('#navbarDropdown-location').dropdown('hide');
	$('#navbarDropdown-talent').dropdown('hide');
	$('#navbarDropdown-rate').dropdown('hide');
	$('#navbarDropdown-age').dropdown('hide');
	$('#navbarDropdown-name').dropdown('hide');

	var form0 = document.forms.namedItem('form1');
	var form = $(document.forms.namedItem('form2')).serializeArray();
	form = form.concat( $(document.forms.namedItem('form3') ).serializeArray() );
	form = form.concat( $(document.forms.namedItem('form4') ).serializeArray() );
	form = form.concat( $(document.forms.namedItem('form5') ).serializeArray() );

	var combinedForm = new FormData(form0);
	combinedForm.append('talent','FORM');
	combinedForm.append('page_no',page_no);

	for(u in form){
		if( form[u].value !== ''){
			combinedForm.append(form[u].name, form[u].value);
		}
	}
	
	// Create AJAX Request 
		var url = 'https://www.gospelscout.com/artist/phpBackend/connectToDb_new.php'; 
		var sendForm_xhr = new XMLHttpRequest();
		sendForm_xhr.onload = function(){
			if(sendForm_xhr.status == 200){
				var response = sendForm_xhr.responseText.trim();console.log(response);
				var parsedResponse = JSON.parse(response);
				var new_owl_div = '';
				 $("#pagination_container").html( buildPagination(parsedResponse) );
				 if(parsedResponse.result === 'exists'){
				  new_owl_div += build_artists_modals(parsedResponse);
				}else{
					new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
				}
				  $('#artist_display_container').html(new_owl_div);
			}
		}
		sendForm_xhr.open('post',url);
		sendForm_xhr.send(combinedForm);
}
/******************************************************
 *** END - Handle Search criteria form
 ******************************************************/

 /******************************************************
 *** Build artist Modals
 ******************************************************/
 function build_artists_modals(parsedResponse){console.log(parsedResponse);
	  var new_owl_div = '';
	  new_owl_div += '<div class="row">';
		  var value = parsedResponse.artist_array;
	  for( y in value){
			  new_owl_div += '<div class="col-lg-4 col-md-4 col-12  mb-4">';
			  new_owl_div += '<div id="artistThumbs" style="position:relative; background-image: linear-gradient(rgba(0,0,0,.1), rgba(0,0,0,.6)), url(https://www.gospelscout.com'+value[y][0].sProfileName+');">';
			  new_owl_div += '<div class="text-white pl-2" style="position:absolute; bottom:0; min-height:80px; width: 100%;"><h3>'+value[y][0].sFirstName+'</h3><p class="m-0" style="font-size:.8em">'+value[y][0].minPay+'</p><p class="m-0" style="font-size:.8em">'+value[y][0].sCityName+', '+value[y][0].statecode+'</p></div>';
			  new_owl_div += '<a class="addArtist" email="'+value[y][0].sContactEmailID+'" talent="'+value[y][0].talent+'" artistType="'+value[y][0].TalentID+'" iLoginID="'+value[y][0].iLoginID+'" fname="'+value[y][0].sFirstName+'" href="#" style="position: absolute; bottom:5px; right: 30px; font-size:.8em;"><img src="https://www.gospelscout.com/publicgigads/css/person-fill-add.svg"></a>'; 
			  new_owl_div += '<a target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+value[y][0].iLoginID+'" style="position: absolute; bottom:5px; right: 5px; font-size:.8em;"><img src="https://www.gospelscout.com/publicgigads/css/eye-fillIcon.svg"></a>';
			  new_owl_div += '</div>';
	  /* Modal: Name */
	  new_owl_div += '<div class="modal fade" id="modal-'+value[y][0].TalentID+'-user_'+value[y][0].iLoginID+'-'+y+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">';
  
			/* Body */
			new_owl_div += '<div class="modal-body mb-0 p-0"><div class="container">';
  
					/* Row 1 */
				  new_owl_div += '<div class="row pb-2" style="border-bottom: .5px solid rgba(0,0,0,.1)">';
					
				  new_owl_div += '<div class="col-12 col-md-6 p-0">';
  
				  /* Display profile image */
					new_owl_div += '<img class="z-depth-1" src="https://www.gospelscout.com'+value[y][0].sProfileName+'"  width="100%" height="150" style="object-fit:cover; object-position:0,0;border-radius:3px 0 0 0;">';
			   
				  new_owl_div += '</div>';
  
				  new_owl_div += '<div class="col-12 col-md-6 p-0">';
				  new_owl_div += '<div class="container">';
						
				  new_owl_div += '<div class="row"><div class="col-12 text-center"><h4 class="my-0 text-gs">'+value[y][0].sFirstName+'</h4></div></div><hr class="featurette-divider my-1">';
  
				  new_owl_div += '<div class="row"><div class="col-12 text-left mt-1" style="font-size:.8em"><table>';
				  
				  new_owl_div += '<tr><th>Ciy:</th><td>'+value[y][0].sCityName+', '+value[y][0].statecode+'</td></tr>';
				  new_owl_div += '<tr><th>Age:</th><td>'+value[y][0].dDOB+'</td></tr>';
				  new_owl_div += '<tr><th>Email:</th><td>'+value[y][0].sContactEmailID+'</td></tr>';
				  new_owl_div += '<tr><th>Contact:</th><td>'+value[y][0].sContactNumber+'</td></tr>';
				  //  Display artist's talent
					new_owl_div += '<tr><th class="align-top">Talent:</th><td><table>';
					var tal_list = value[y].talent_list;
					for(z in tal_list){
					  new_owl_div += '<tr><td>'+tal_list[z].talent+'</td></tr>'
					}
					new_owl_div += '</table></td></tr>';
  
				  new_owl_div += '</table></div></div>';
  
				  new_owl_div += '</div>';
				  new_owl_div += '</div>';
  
				  new_owl_div += '</div>';
				  /* END - Row 1 */
  
				  /* Row 2 */
            /* Carousel Wrapper */
              new_owl_div += '<div class="row p-0" style="min-height:100px; font-size:.8em"><div class="col px-0 pt-2" id="'+value[y][0].TalentID+'_'+value[y][0].iLoginID+'"></div></div>';
            /* END - Carousel Wrapper*/
				  /* END - Row 2 */
  
			  new_owl_div += '</div></div>';
			/* END - Body */
  
			/* Footer */
			new_owl_div += '<div class="modal-footer justify-content-center"><a type="button" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+value[y][0].iLoginID+'" class="btn btn-gs btn-rounded btn-md ml-4">View Profile</a><button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button></div>';
  
		  new_owl_div += '</div></div></div>';
		  new_owl_div += '</div>';
	  }
	  
	  // });
	  new_owl_div += '</div>';
  
	  return new_owl_div;
  }
 /******************************************************
 *** END - Build artist Modals
 ******************************************************/

  /******************************************************
 *** Build pagination
 ******************************************************/
 function buildPagination(artist_array){
	var no_of_artists = artist_array.total_no_of_artists;console.log(no_of_artists);
	var page_no = artist_array.page_no; 
  
	// Set number of records per page 
	  var no_of_records_per_page = 15;
	  var offset = (page_no-1) * no_of_records_per_page; 
  
	// Total number of pages 
	  var total_pages = Math.ceil(no_of_artists / no_of_records_per_page); 
  
  
	// Build HTML 
	  var pagination = '<li class="page-item';
  
	  // previous
		if( page_no == 1 ){
		  pagination += ' disabled';
		}else{
		  var prev_page_no = parseInt(page_no) - 1; 
		}
		pagination += ' mr-auto"><a class="page-link call_page" href="#by_talent"';
		if(artist_array.search_type == 'SBT'){
		  pagination += ' talent="'+artist_array.SBT_talent+'"';
		}
		pagination += ' searchBy="'+artist_array.search_type+'" page_number="'+prev_page_no+'" tabindex="-1" aria-disabled="true"';
		if( page_no > 1){
		  pagination += ' style="color:rgba(149,73,173,1);"';
		}  
		pagination += '>Previous</a></li>';
	  
	  // Page numbers 
		for(var i=1;i<=total_pages;i++){
		  pagination += '<li class="page-item"><a href="#by_talent" class="page-link text-gs mx-1';
		  if(i==page_no) {
			pagination += ' active';
		  }
		  pagination += ' call_page" style="border-radius:5px;" href="#"';
		  if(artist_array.search_type == 'SBT'){
			pagination += ' talent="'+artist_array.SBT_talent+'"';
		  }
		  pagination += ' searchBy="'+artist_array.search_type+'" page_number="'+i+'">'+i+'</a></li>';
		}
	 
	  // Next 
		pagination += '<li class="page-item ml-auto';
		if(page_no == total_pages){
		  pagination += ' disabled';
		}
  
		var next_page_no = parseInt(page_no) + 1; 
		pagination += '"><a class="page-link call_page" href="#by_talent"';
		if(artist_array.search_type == 'SBT'){
		  pagination += ' talent="'+artist_array.SBT_talent+'"';
		}
		pagination += ' searchBy="'+artist_array.search_type+'" page_number="'+next_page_no+'" id="next_button"';
		if( total_pages > 1 && page_no != total_pages){
		  pagination += ' style="color:rgba(149,73,173,1);"';
		}  
		pagination += '>Next</a> </li>';
	 return pagination;
  }
 /******************************************************
 *** END - Build pagination
 ******************************************************/

 /******************************************************
 *** Handle errors for direct artists requests
 ******************************************************/
  function artReqErrors(parsedResponse, fname, rand_var, artist_requested_talent, artist_requested_fname, artist_requested_uid, artist_requested_type,artist_requested_email){
	if(parsedResponse.inq_error){
		var error_message='';
		if(parsedResponse.gm_error){
		  error_message = `<p>Sorry Gig Managers Cannot Book Themselves</p>`;
		}else{
		  if( parsedResponse.inq_info.gmRequested === "1"){
			error_message = `<p>You have already requested ${parsedResponse.inq_info.sFirstName} to play this gig for the following talent: ${parsedResponse.inq_info.sGiftName}.  To request this artist for the currently selected talent, please first remove the talent that the artist was previously requested for and re-request the artist for the new talent</p>`;
		  }else {
			error_message = `<p>${parsedResponse.inq_info.sFirstName} has already placed a bid to play this gig for the folllowing talent: ${parsedResponse.inq_info.sGiftName}</p>`;
		  }
		}
		error_message += `<button class="btn btn-sm btn-gs" type="button" id="regen_results">Okay</button>`;
		$('#artist_display_container').html(error_message);
	}else{
		// display color key
		  $('#artist-color-key').removeClass('d-none');

		// Add input field containing the requested artist
		  var requested_artist_input = `<input type="hidden" class="art_req" name="talent[artist_requested][${rand_var}][email]" value="${artist_requested_email}"><input type="hidden" class="art_req" name="talent[artist_requested][${rand_var}][talent]" value="${artist_requested_talent}"><input type="hidden" class="art_req" name="talent[artist_requested][${rand_var}][fname]" value="${artist_requested_fname}"><input type="hidden" class="art_req" name="talent[artist_requested][${rand_var}][iLoginID]" value="${artist_requested_uid}"><input type="hidden" name="talent[artist_requested][${rand_var}][artistType]" value="${artist_requested_type}">`;

		// Add Requested artist's name to corresponding talent entry
		  var artist_requested = `${fname}${requested_artist_input}`;
		  $(`#selectArtist_${rand_var}`).html(artist_requested);
		  $('#direct_request').modal('hide');
	}
  }
/******************************************************
 *** END - Handle errors for direct artists requests
 ******************************************************/



