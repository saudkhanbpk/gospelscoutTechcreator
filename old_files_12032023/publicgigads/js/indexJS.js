
/* Check user login*/
	var loggedIn= $('input[name="loggedIn').val(); 
	if(loggedIn === 'false'){
    // $('#showFSearch').addClass('d-none');
    $('#btn_login').attr('viewPostedGigs', true);
		$('#modalTitle').html('Log In To Create a Gig Ad')
		$('#login-signup').attr('data-backdrop', 'static');
		$('#login-signup').modal('toggle');
	}

/********************************
 *** Date and Time Picker plugin JS
 ********************************/
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
        format: "YYYY-MM-DD",
        defaultDate: false,
        minDate: dat,
        //minDate: moment(),
        maxDate: moment().add(1,'year'),
        //useCurrent: true, 
        allowInputToggle: true
       });
      $("#datetimepicker3").datetimepicker({
            format: "hh:mm A",
            stepping: "5",
            useCurrent: false,
            allowInputToggle: true
        }); 
        $("#datetimepicker4").datetimepicker({
            format: "hh:mm A",
            stepping: "5",
            useCurrent: false,
            allowInputToggle: true
        }); 
        $("#datetimepicker5").datetimepicker({
            format: "hh:mm A",
            stepping: "5",
            useCurrent: false,
            allowInputToggle: true
        }); 
    });
/********************************
 *** END - Date and Time Picker plugin JS
 ********************************/

/**************************************************************
 *** Append talent type needed as selected from the select menu
 **************************************************************/
    var groupMaker = 0;
    
    $("#artistType").change(function(){
        var selection = $(this).val();

        if(selection == 'groups'){
          /* Show group types when group is selected */
            $('#groupTypeContainer').removeClass('d-none');

          groupMaker = 1; 
        }
        else{

          /* Append newly selected talents that are needed for gig*/

            /* Generate a unique id to correspond to the talent */
             function rand_ID() {
                var d = new Date();
                var n = d.getTime();
                return n+'_' + Math.random().toString(36).substr(2, 9);
              };
              var rand_var = rand_ID();
              console.log(selection);
            
            if( selection !== ''){
              var selected_text = $('#artistType option:selected').text(); 
              // var talent_row = '<tr><td>'+selected_text+'</td><td>N/A</td><td class="text-center"><input class="mx-auto form-control form-control-sm" style="height:20px; width:80px" type="text" placeholder="$0.00" name="talent[pay_new]['+rand_var+']" value=""></td><td><a href="#" class="text-gs remove_needed_tal">Remove</a><input type="hidden" name="talent[artist]['+rand_var+']" value="'+selection+'"></td></tr>';
              var talent_row = '<tr><td>'+selected_text+'</td><td id="selectArtist_'+rand_var+'">N/A</td><td class="text-center"><input class="mx-auto form-control form-control-sm" style="height:20px; width:80px" type="text" placeholder="$0.00" id="pay_new_'+rand_var+'" name="talent[pay_new]['+rand_var+']" value=""></td><td><button type="button"  rand_var="'+rand_var+'" talent="'+selected_text+'" selection="'+selection+'" class="btn-sm artistSearch"></button></td><td><a href="#" class="text-gs remove_needed_tal">Remove</a><input type="hidden" name="talent[artist]['+rand_var+']" value="'+selection+'"></td></tr>';
              $('#talent_rows').append(talent_row);
            }
            document.getElementById('artistType').selectedIndex = 0; 

          /* Hide the group type select menu when group is not selected */
            $('#groupTypeContainer').addClass('d-none');
            $('#groupType').val('');
        }
    });

    /* show the modal for direct artist search */
      $('#talent_rows').on('click', '.artistSearch', function(e){
        e.preventDefault();
        displayLoadingElement('display_load_wheell');

        /* Find artists based on state, talent, and pay requs */ 
          // get selected state
            var selectedInd = document.getElementById('venueState').options.selectedIndex;
            console.log(selectedInd);
            var getState = document.getElementById('venueState').options;
            
            for(let i in getState){
                console.log(getState[i]);
              if(selectedInd == i && getState[i].getAttribute('id') != null){
                var selectedState = getState[i].getAttribute('id');
                break;
              }
            }

          // get selected talent
            var talentId = $(this).attr('selection');
            var talent = $(this).attr('talent');
            $('#direct_request_title').html(`Find ${talent}`);

          // get pay
            var rand_var = $(this).attr('rand_var');

            if( $(`#pay_new_${rand_var}`).val() && $(`#pay_new_${rand_var}`).val() != ''){
              var pay_new = $(`#pay_new_${rand_var}`).val();
            }
          // insert values into the correct forms 
          
            $('#artistTypeSearch').val(talentId);
            $('#state').val(selectedState);
            $('input[name=rate2]').val(pay_new);  
            $('input[name=rand_var]').val(rand_var);
            
          submitFormData(1);
        
        /* display modal for artist search */
        $('#direct_request').modal('show');
      });

    $('.searchCriteriaForm').on('submit',function(e){
        e.preventDefault(); 
        displayLoadingElement('display_load_wheell');
    
        /* Call submit form data function */
          submitFormData(1);
    });
    
	// Add Requested artist to form
	$('#artist_display_container').on('click','.addArtist', function(e){
		e.preventDefault(); 
		displayLoadingElement('artist_display_container');
		var rand_var = $('input[name=rand_var]').val();
		var artist_requested_uid = $(this).attr('iLoginID');
		var artist_requested_fname = $(this).attr('fname');
		var artist_requested_type= $(this).attr('artistType');
		var artist_requested_talent= $(this).attr('talent');
		var artist_requested_email= $(this).attr('email');

		var fname = `<a class="text-warning" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist=${artist_requested_uid}">${artist_requested_fname}</a>`;
	
		// Check if selected artist exists in the giginqu table
		var check_artInqiry_status_xhr = new XMLHttpRequest(); 
		check_artInqiry_status_xhr.onload = () => {
			if(check_artInqiry_status_xhr.status == 200){
				var response = check_artInqiry_status_xhr.responseText.trim();
				var parsedResponse = JSON.parse(response);
				console.log(parsedResponse);
				artReqErrors(parsedResponse, fname, rand_var, artist_requested_talent, artist_requested_fname, artist_requested_uid, artist_requested_type,artist_requested_email);
			}
		}
		check_artInqiry_status_xhr.open('get', `https://www.gospelscout.com/publicgigads/phpBackend/connectToDb.php?check_artist_status=${artist_requested_uid}&gigid=${$('input[name=gid]').val()}`);
		check_artInqiry_status_xhr.send()          
	});

	/* re-generate artist search results */
        $('#artist_display_container').on('click','#regen_results', () => {
          displayLoadingElement('artist_display_container');
          submitFormData(1);
        });

    /* query db for requested artists */
      var art_req_xhr = new XMLHttpRequest(); 
      art_req_xhr.onload = () => {
        if(art_req_xhr.status == 200){
          var response = art_req_xhr.responseText.trim();
          console.log(response);
          var parsedResponse = JSON.parse(response);
          console.log(parsedResponse.length);
         
          if(parsedResponse.length>0){
            for(let i in parsedResponse){
              if(parsedResponse[i].selected == "0" && parsedResponse[i].inquiry_withdrawn == "0"){
                var fname = `<a class="text-warning" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist=${parsedResponse[i].iLoginID}">${parsedResponse[i].sFirstName}</a>`;
                console.log(parsedResponse[i].tal_tracker_id);
                $(`#selectArtist_${parsedResponse[i].tal_tracker_id}`).html(fname);
              }
            }

            // display color key
              $('#artist-color-key').removeClass('d-none');
          }
        
        }
      }
      art_req_xhr.open('get',  `https://www.gospelscout.com/publicgigads/phpBackend/connectToDb.php?get_req_artists=true&gigid=${$('input[name=gid]').val()}`);
      art_req_xhr.send(); 

    $( '#talent_rows').on('click', '.remove_needed_tal',function(event){
      event.preventDefault();

      /* Define Variables */
        var tal_tracker = $(this).attr('talTracker');
        var tal_id = $(this).attr('talID');
        var sel_art = $(this).attr('selArtist');
        var remove_tal_input = '<input type="hidden" name=remove_talent['+tal_tracker+'] value="'+tal_id+'">';

      /* If sel_art is not empty - trigger warning modal */
        if(sel_art > 0){
          /* trigger warning modal here */
            $('#art_rem_warn').modal('show');
        }

      	/* Append hidden remove-talent-input to the update form */
        $('form[name=gigdetails]').append(remove_tal_input);
		/* Remove the artist row */
		$(this).closest('tr').remove();

	   /* Check for # of artists requested */
          var art_req = $('.art_req');//.lemgth;
          if(art_req.length == 0){
             // display color key
              $('#artist-color-key').addClass('d-none');
          }
          console.log(art_req.length);

    });
/********************************************************************
 *** END - Append talent type needed as selected from the select menu
 ********************************************************************/


/********************************
 *** Submit public post ad
 ********************************/
    var signUpForm = $("#gigdetails");
    signUpForm.validate({

    	/* Error message placement and styling  */
            errorPlacement: function(error, element) {
               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
               
                if(error[0]['id'] == 'DOB-error' || error[0]['id'] == 'emailConf-error'){
	            	element.parent("div").after(error);
	            }
	            else if(error[0]['id'] == 'loginmaster[sUserType]-error'){
	            	$('#accordion').after(error);
	            }
	            else{
	            	element.after(error);
	            }
            },

      	/* Submit the form */
          submitHandler: function(form) {

              /* Show loading spinwheel */
                 displayLoadingPage('show');

              /* vars */
                var state = $('select[name=venueState]').val();
                var zip = $('input[name=venueZip]').val();
                let userCity = new validateZip(zip, state);

            userCity.getCityStateOBj
            .then(userCity.returnCity)
            .then(cityFound => {
              if(cityFound.state == state){
                /* Vars */
                    var talType = $("#artistType").val();
                    if(talType == 'groups'){
                      $('#send_userType').val('group');
                    }
                    else{
                      $('#send_userType').val('artist');
                    }

                /* Instantiate new form data obj */
                  var new_gig_formD = new FormData(form); 
                  new_gig_formD.append('venueCity', cityFound.city);
                  new_gig_formD.append('venueStateShort',cityFound.stateShortName);
                  
                  /* Create id */
                    var gen_gigId = String( uuidv1() ); 
                    var gig_Id = gen_gigId.replace(/-/g,'');
                    var form_action = $('button.getStatus').attr('id');
                    if(form_action == 'postGig'){
                        new_gig_formD.append('gigId',gig_Id);
                        var page_redirect = 'checkout/';
                    }else {
                        var page_redirect = 'publicgigads/ad_details.php';
                    }
                /* Instantiate new form xhr */
                  var new_gig_xhr = new XMLHttpRequest();
                  new_gig_xhr.onload = function(){
                    if( new_gig_xhr.status == 200){
                      /* Show loading spinwheel */
                        displayLoadingPage('hide');
					
                      var response = new_gig_xhr.responseText.trim();console.log(response);
                      var parsedResponse = JSON.parse( response );
                     
                      if(parsedResponse.err_present){
                        /* Display error message */
                          var error_message = '';
                          if( parsedResponse.err_mess == 'invalid_char_type' ){
                            error_message = 'Please enter a valid address';

                          }
                          else if( parsedResponse.err_mess == 'invalid_age' ){
                            error_message = 'Please enter a valid age';

                          }
                          else if( parsedResponse.err_mess == 'invalid_pay_amount' ){
                            error_message = 'Please enter a pay amount between $0.00 - $9,999.99';

                          }
                          else if( parsedResponse.err_mess == 'invalid_zip' ){
                            error_message = 'Please enter a valid 5-digit zip code';

                          }
                          else if( parsedResponse.err_mess == 'all_fields_not_complete' ){
                            error_message = 'Please complete all mark (*) fields';

                          }
                           else{
                            error_message = parsedResponse.err_mess;
                          }

                          $('#zipError').html(error_message);
                      }
                      else if(parsedResponse.ad_posted){
                          /* Clear form to prevent re-submission */
                            document.getElementById('gigdetails').reset(); 
                            $('#talent_rows').html('');

                          var gigID = parsedResponse.ad_posted_gigID; 
                          window.location = `https://www.gospelscout.com/${page_redirect}?g_id=${gigID}`;
                      }
                      else{
                          /* Display unknown error message */
                            $('#zipError').html('Error: Unkown error - <a href="https://www.gospelscout.com/contactUs/" class="text-gs">contact us</a>');
                      }
                      
                    }
                  }
                  new_gig_xhr.open('post', 'https://www.gospelscout.com/publicgigads/phpBackend/connectToDb.php')
                  new_gig_xhr.send(new_gig_formD);

              }
              else{
                /* hide loading spinwheel */
                  displayLoadingPage('hide');
                
                $('.error-message').text('Sorry, there was a State/Zip Code mismatch!!!');
                console.log('there was an error validating your zip code');
              }

            });



        },
      /* END - Submit the form */

      /* Set validation rules for the form */
        rules:{
        //   gigName: {
        //     required: true,
        //   },
        //   gigType: {
        //     required: true,
        //   },
        //   gigDate: {
        //     required: true,
        //   },
        //   artistType: {
        //   	required: true,
        //   },
        //   groupType: {
      	// 		required: {
      	// 			depends: function(element){
      	// 				return $('#artistType').val('groups');
      	// 			}
      	// 		}
      	// 	},
        //   dDOB1: {
        //     required: true,
        //     digits: true
        //   },
        //    sGender: {
        //     required: true,
        //   },
        //   setupTime: {
        //     required: true,
        //   },
        //   startTime: {
        //     required: true,
        //   },
        //   endTime: {
        //     required: true,
        //   },
        //   gigPrivacy: {
        //     required: true,
        //   },
        //   gigPay: {
        //     required: true,
        //   },
        //   venueName: {
        //     required: true,
        //   },
        //   venueAddress: {
        //     required: true,
        //   },
        //   venueEnvironment: {
        //     required: true,
        //   },
        //   venueState: {
        //     required: true,
        //   },
        //   venueZip: {
        //     required: true,
        //     minlength: 5,
        //     maxlength: 5,
        //     digits: true
        //   }
        },
        messages: {
          gigName: {
            required: 'Please Enter a Gig Name',
          },
          gigType: {
            required: 'Please Select a Gig Type',
          },
          artistType: {
          	required: 'Please Select Type of Artist',
          },
          groupType: {
    			 required: 'Please Select Type of Group',
    		  },
		      dDOB1: {
            required: 'Please Enter a Minimum Age',
          },
          sGender: {
            required: 'Please Specify a Gender',
          },
          gigDate: {
            required: 'Please Select a Gig Date',
          },
          setupTime: {
            required: 'Please Specify a Set up Time',
          },
          startTime: {
            required: 'Please Specify a Start Time',
          },
          endTime: {
            required: 'Please Specify a End Time',
          },
          gigPrivacy: {
            required: 'Please Select a Privacy Type',
          },
          gigPay: {
            required: 'Please Enter Payment Amount.  If None, Enter 0.00',
          },
          venueName: {
            required: 'Please Enter a Venue Name',
          },
          venueAddress: {
            required: 'Please Enter a Venue Address',
          },
          venueEnvironment: {
            required: 'Please Select the Venue Environment',
          },
          venueState: {
            required: 'Please Select the Venue State',
          },
          venueZip: {
            required: 'Please enter your 5 digit zip code',
             minlength: 'Please enter your 5-digit zip code',
             maxlength: 'Please enter your 5-digit zip code',
             digits: 'Please enter numeric values only'
          }
        }
    });
/********************************
 *** END - Submit public post ad
 ********************************/


/************************************************
 *** Create stripe form to collect customer info
 ************************************************/
//   "use strict";
//   var stripe = Stripe("pk_live_OGrw56hK2CpvoGTZgIrzQPHk");
//   var elements = stripe.elements();

//   /* Custom styling can be passed to options when creating an Element. */
//       var style = {
//           base: {
//               color: '#32325d',
//               fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
//               fontSmoothing: 'antialiased',
//               fontSize: '16px',
//               '::placeholder': {
//                   color: '#aab7c4'
//               }
//           },
//               invalid: {
//               color: '#fa755a',
//               iconColor: '#fa755a'
//           }
//       };

//   /* Create an instance of the card Element. */
//       var card = elements.create('card', {style: style});

//   /* Add an instance of the card Element into the `card-element` <div>. */
//       card.mount('#card-element');

//   /* Add an event listener to the card element to catch errors */
//       card.addEventListener('change', function(event) {
//           var displayError = document.getElementById('card-errors');

//           if (event.error) {
//               displayError.textContent = event.error.message;
//           } else {
//               displayError.textContent = '';
//           }   
//       });


//   /* Create a token or display an error when the stripe form is submitted. */
//     var form = document.getElementById('payment-form');
//     form.addEventListener('submit', function(event) {
//         event.preventDefault();
// 		console.log('payment form submitted');
//         stripe.createToken(card).then(function(result) {
//             if (result.error) {
//                 /* Inform the customer that there was an error. */
//                     var errorElement = document.getElementById('card-errors');
//                     errorElement.textContent = result.error.message;
//             } else {
//                 /* Send the token to your server. */
//                 console.log('token_handler_called');
//                 stripeTokenHandler(result.token);

//             }
//         });
//     });
/*****************************************************
 *** END - Create stripe form to collect customer info
 *****************************************************/

/**********************************
 *** Trigger the confirm post modal
 **********************************/
    // $('#postGig').click(function(event){
    //   event.preventDefault();
    //   var get_modal = $(this).attr('get-modal');
    //   $(get_modal).modal('show');
    // });
/**********************************
 *** END - Trigger the confirm post modal
 **********************************/

/**********************************
 *** Submit the form for validation
 **********************************/
    // $('.sendPost').click(function(event){
    //   event.preventDefault();
    //   signUpForm.submit();
    // });
/****************************************
 *** END - Submit the form for validation
 ****************************************/


