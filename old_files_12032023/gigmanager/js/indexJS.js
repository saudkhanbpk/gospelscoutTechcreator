 /* Gigmanager index page JS */

/********************************
 *** Get Artist's gigs
 ********************************/

 	$('.getArtistGigs').click(function(event){
 		event.preventDefault(); 

 		/* Show loading spinwheel */
 			displayLoadingElement('infoDisplay');

 		/* Call function to fetch user's gigs */
	        var gig_status = $(this).attr('id');
	 		    fetchGigs(gig_status);
 	});

/********************************
 *** END - Get Artist's gigs
 ********************************/
$('#collapse1').click(function(event){
	/* Make first tab active */
		$('.nav-link').removeClass('active');
		$('#pending').addClass('active');

});

$('#collapse2').click(function(event){
	/* Make first tab active */
	$('.nav-link').removeClass('active');
	$('#showUpcoming').addClass('active');
});
 
/*************************************
 *** Show selected gig's details
 *************************************/
//  $('#infoDisplay').on('click','.viewEventDeets',function(event){
//  	event.preventDefault(); 
//  	var eventTable = $(this).attr('eventTable');
//  	var rowEntryID = $(this).attr('rowEntryID');

 	// /* fetch the selected gig's details */
 	// 	var gigDeets_xhr = new XMLHttpRequest();
 	// 	gigDeets_xhr.onload = function(){
 	// 		if(gigDeets_xhr.status == 200){

 	// 			var response = gigDeets_xhr.responseText.trim();
	// 			 console.log( response );
 	// 			var parsedResponse = JSON.parse(response);
 	// 			console.log(parsedResponse);

 	// 			if(parsedResponse.gig_found){
 	// 				/* Display correct button text and event id */
 	// 					$('#gig_details_gigID').html(parsedResponse.gig_info[0].id);
	// 					if( parsedResponse.gig_info[0].event_expired ){
	// 						/* Show event as expired */
	// 							var button_display = '<h3 class="text-muted">Event Expired</h3>';
	// 					}
					// 	else if( (parsedResponse.gig_info[0].artiststatus == 'pending' && parsedResponse.gig_info[0].requestorstatus == 'requestmade') ){ //|| (parsedResponse.gig_info[0].id == && parsedResponse.gig_info[0].id == )
					// 		/* Show the confirm and decliine buttons */
					// 			var button_display = '<button class="btn btn-sm btn-gs send_artist_response" id="confirmed" gig_id="'+parsedResponse.gig_info[0].id+'" u_id="'+parsedResponse.gig_info[0].iLoginid+'">Confirm</button><button class="btn btn-sm btn-danger send_artist_response" id="declined" gig_id="'+parsedResponse.gig_info[0].id+'" u_id="'+parsedResponse.gig_info[0].iLoginid+'">Decline</button>';
					// 	}
					// 	else if( (parsedResponse.gig_info[0].artiststatus == 'confirmed' && parsedResponse.gig_info[0].requestorstatus == 'requestmade') ){
					// 		/* Show the cancel button */
					// 			var button_display = '<button class="btn btn-sm btn-danger send_artist_response" id="canceled" gig_id="'+parsedResponse.gig_info[0].id+'" u_id="'+parsedResponse.gig_info[0].iLoginid+'">Cancel Gig</button>';
					// 	}
					// 	else{
					// 		var button_display = '';
					// 	}
						
 					// /* Loop through object for values */		
 					// 	for(x in parsedResponse.gig_info[0]){
 					// 		if( parsedResponse.gig_info[0][x] ){ //$('#'+x).html(  ) != ''
 					// 			$('#'+x).html( parsedResponse.gig_info[0][x] );	
 					// 		}
 					// 		else{ $('#'+x).html( 'N/A' ); }
 					// 	}
//  				}
//  				else{
//  					/* Display Error message */
//  						$('#event_deet_body').html('<div class="mx-auto text-center"><p>There was a problem retrieveing event info...try again later!</p><p>If problem persists, <a href="#" class="text-gs">contact us<a/></p></div>')
//  						var button_display = '<button class="btn btn-sm btn-gs" data-dismiss="modal">Close</button>';

//  					/* Show Details Modal  */
//  						$('#gigDetailsModal').modal('show');
//  				}

// 				/* Show Details Modal  */
// 					$('#art_action_buttons').html(button_display);
// 					$('#gigDetailsModal').modal('show');
 				
//  			}
//  		}
//  		gigDeets_xhr.open('get','https://www.gospelscout.com/gigmanager/phpBackend/connectToDb.php?eventTable='+eventTable+'&rowEntryID='+rowEntryID);
//  		gigDeets_xhr.send();
//  });
/*************************************
 *** END - Show selected gig's details
 ************************************/

/*************************************
 *** Send Artist Response
 *************************************/
 	/* Prompt user for Response - confirmation */
		$('#art_action_buttons').on('click','.send_artist_response',function(){
		 	/* Insert artist response in message div & button attr */
		 		var artist_response = $(this).attr('id');
		 		var gig_id = $(this).attr('gig_id');
		 		var u_id = $(this).attr('u_id');

		 		var  conf_message = '';
		 		if( artist_response == 'confirmed' ){
		 			conf_message = 'You are about to <span class="font-weight-bold text-gs">accept</span> this gig.';
		 			conf_title = '<span class="text-gs">Confirm Action</span';
		 		}
		 		else if( artist_response == 'declined' ){
		 			conf_message = 'You are about to <span class="font-weight-bold text-danger">decline</span> this gig.';
		 			conf_title = '<span class="text-danger">Confirm Action</span';
		 		}
		 		else if( artist_response == 'canceled' ){
		 			conf_message = 'You are about to <span class="font-weight-bold text-danger">cancel</span> this gig.';
		 			conf_title = '<span class="text-danger">Confirm Action</span';
		 		}
		 		$('#conf_title').html(conf_title);
		 		$('#conf_message').html(conf_message);
		 		$('#send_art_response').attr('artistResponse',artist_response);
		 		$('#send_art_response').attr('gig_id',gig_id);
		 		$('#send_art_response').attr('u_id',u_id);

		 	/* Display correct modal */
			 	$('#gigDetailsModal').modal('hide');
			 	$('#confirm_artist_response').modal('show');
		});

	/* User confirms and sends Response */
		$('#send_art_response').click(function(event){
			/* Send Artist response to db */
				var art_response = $(this).attr('artistResponse');
				var gig_id = $(this).attr('gig_id');
				var u_id = $(this).attr('u_id');

				var art_response_form = new FormData();
				art_response_form.append('artiststatus',art_response);
				art_response_form.append('gig_id',gig_id);
				art_response_form.append('u_id',u_id);

				var art_response_xhr = new XMLHttpRequest();
				art_response_xhr.onload = function(){
					if( art_response_xhr.status == 200 ){
						var response = art_response_xhr.responseText.trim(); 
						console.log(response);
						var parsedResponse = JSON.parse(response);

						if( parsedResponse.response_sent ){
							$('#response_conf_message').html('<span class="text-success">You have successfully '+art_response+' this gig.</span>');
							$('#confirm_artist_response').modal('hide');
							$('#conf_to_response').modal('show');
							
							/* Make first tab active */
								$('.nav-link').removeClass('active');
								$('#pending').addClass('active');
							
							/* Re-fetch the artists gigs */
								fetchGigs('pending');
						}
						else{
							$('#response_conf_message').html('<span class="text-danger">There was an error responding to this gig.  Try again.</span>');
							$('#confirm_artist_response').modal('hide');
							$('#conf_to_response').modal('show');
						}
					}
				}
				art_response_xhr.open('post','https://www.gospelscout.com/gigmanager/phpBackend/connectToDb.php');
				art_response_xhr.send(art_response_form);

		});
/*************************************
 *** END - Send Artist Response
 *************************************/

/*************************************
 *** Fetch user's gig ads
 *************************************/
 	$('#collapseOne').on('show.bs.collapse', function () {
	  fetchGigs('bid');
	})
	$('#collapseTwo').on('show.bs.collapse', function () {
	  fetchGigAds('Upcoming');
	});
/*************************************
 *** END - Fetch user's gig ads
 ************************************/

/*************************************
 *** Show expired or upcoming gig ads
 *************************************/
 $('#showUpcoming').click(function(event){
 	event.preventDefault();

 	/* fetch upcoming gigs */
 	 fetchGigAds('Upcoming');

 });
 $('#showExpired').click(function(event){
 	event.preventDefault();

 	/* Fetch expired gigs */
 		 fetchGigAds('Expired');
 });

 /*************************************
 *** END - Show expired or upcoming gig ads
 *************************************/


/* Manage the create/manage gig navigation */
        $('.create_man_Gigs').click(function(event){

          event.preventDefault(); 
          var action = $(this).attr('id');
          
                         
          if(action == 'gig_ads'){
            
            var button_var = '<a class="nav-link text-white active" id="create_gigs" href="#">Manage Gig Ads<span class=""></span></a>';
            button_var += ' <a class="nav-link text-white" id="manage_gigs" href="#">Manage Private Gigs<span class=""></span></a>';
            $('#nav_sub_menu1').html(button_var);
          }
          else{
            // var button_var ='<div class="row"><div class="col-10 my-2 mx-auto mx-md-0 col-md-3 text-left"><a class="btn btn-gs" target="_blank" href="<?php echo URL;?>publicgigads/" style="width:100%">Create Gig Ads</a></div><div class="col-10 my-2 mx-auto mx-md-0 col-md-3"><button class="btn btn-gs" style="width:100%">Create Private Gigs</button></div></div>';
            // $('#infoDisplay1').html(button_var);
          }
        });

      $('.nav-link').click(function(event){
          $('.nav-link').removeClass('active');
          $(this).addClass('active');

      });

      /**** Create function for xml http request ****/
        function useBackbone(getVar,newLocal){
          
          /* New XML Http Request */
            var queryBackbone = new XMLHttpRequest(); 
            queryBackbone.onreadystatechange = function(){
              if(queryBackbone.readyState == 4 && queryBackbone.status == 200){
                if(queryBackbone.responseText){
                  if(newLocal == 'none'){
                    $('#infoDisplay').html(queryBackbone.responseText);
                  }
                  else{
                    window.location.href = newLocal;
                  }
                }
              }
            }
            queryBackbone.open('GET','https://www.gospelscout.com/views/xmlhttprequest/notificationBackbone.php?'+getVar);
            queryBackbone.send()
        }
      /* END - Create function for xml http request */

      /**** trigger function to mark notification as viewed and redirect to the appropriate page ****/
        $('.useBackBone').click(function(event){
            event.preventDefault();
            if($(this).hasClass('viewNotification')){
              var notificationID = $(this).attr('notID');
              var newLocal = $(this).attr('href');
              var getVar = 'notificationID='+notificationID+'&viewed=1';
              useBackbone(getVar,newLocal);
            }
            else if($(this).hasClass('viewSuggestion')){

            }
        });
      /* END - trigger function to mark notification as viewed and redirect to the appropriate page */

      /**** Call to the notificationBackbone.php page based on the tab selected ****/
        $('.useBackBone1').click(function(event){
          event.preventDefault();
          var action = $(this).attr('id');
          var iLoginID = $('input[name=iLoginID]').val();
          var getVar = action +'=1&iLoginID='+iLoginID;
          var newLocal = 'none';
          useBackbone(getVar,newLocal)
        });

      /* END - Call to the notificationBackbone.php page based on the tab selected */
