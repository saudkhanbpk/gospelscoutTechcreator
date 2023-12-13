/* Add Loading spin wheel when events are being called to the page */
    displayLoadingPage('show');

/* Define the needed vars */   	
	var u_Id = $('input[name=privacy]').val(); 
	var linked_cal = $('input[name=privacy]').attr('linked_cal');
	console.log(linked_cal);

	console.log(`this is the u_id: ${u_Id} and linked_cal: ${linked_cal}`);

/* Google Authorization Re-direction function */
	function redirectFunct(no_a_token){
		/* get action */
			var sel_element = $('select[name=google_action]');
			var action = sel_element.val();

		if( action != ''){
			if( action == 'link'){
				/* Trigger confirmation modal */
					$('#linkNewCal').modal('hide');
					$('#link_warning_message').html('Linking a new calendar will replace any previously linked google calendar.<br> <span class="text-primary font-weight-bold">Are you sure want to do this?</span>');
					$('#terms_privacy').html('<p style="font-size:.4em">By clicking "yes" you agree that you have read and consent to GospelsScout&apos;s <a href="https://www.gospelscout.com/views/terms.php" target="_blank">Terms of Use</a> and <a href="https://www.gospelscout.com/views/privacy.php" target="_blank">Privacy</a> poicies.</p>');
					$('#link_warning').modal('show');

			}else if( action == 'unlink'){
				/* Trigger confirmation modal */
					$('#terms_privacy').html('');
					$('#linkNewCal').modal('hide');
					$('#link_warning_message').html('Un-linking your google calendar will no longer allow gospelscout to detect possible scheduling conflicts nor will allow newly booked gigs to be inserted into your google calendar.<br> <span class="text-primary font-weight-bold">Are you sure want to do this?</span>');
					$('#link_warning').modal('show');
			}
		}
		else{
			/* Display validation error */
				sel_element.focus(); 
				var err_message = '<p class="text-danger mt-1 mb-0 font-weight-bold" style="font-size:.75em;">Please select one</p>';
				$('#err-div').html(err_message);
		}	
	}

/* Handle calendar linking/unlinking */
	function linkCal(authURL){
		/* Show spinwheel */
			displayLoadingElement('link_mess_container');

		/* get action */
			var sel_element = $('select[name=google_action]');
			var action = sel_element.val();

		if( action == 'link'){
			/* re-direct user to google */
				$('#link_warning').modal('hide');
				window.location = authURL;

		}else if( action == 'unlink'){
			/* Remove User's entry in the google table */
				var unlink_obj = new FormData();
				unlink_obj.append('goog_action', action);

				var remCal_xhr = new XMLHttpRequest(); 
				remCal_xhr.onload = function(){
					if(remCal_xhr.status == 200){
						var response = remCal_xhr.responseText.trim(); 
						var parsedResponse = JSON.parse(response);
						console.log(parsedResponse);

						if(parsedResponse.cal_removed){
							console.log('test');
							var success_message = '<p class="mt-1 mb-0 font-weight-bold" style="font-size:.75em;">Your Google Calendar has been Un-linked!</p>'; 
							var success_button = '<button type="button" class="btn btn-sm btn-primary" onclick="page_refresh()" style="font-size:.8em">Okay</button>';
							$('#link_mess_container').html(success_message);
							$('#conf_modal').html(success_button);
						}
					}
				}
				remCal_xhr.open('post', 'https://www.gospelscout.com/calendar/phpBackend/myFeed.php');
				remCal_xhr.send(unlink_obj); 
		}
	};

/* FullCalendar plugin - V4 */
  // document.addEventListener('DOMContentLoaded', function() {
  	
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
       plugins: [ 'dayGrid', 'timeGrid', 'list', 'bootstrap','interaction' ], // an array of strings!
       themeSystem: 'bootstrap',
    	header: {
			left: 'prev',
			center: 'title',
			right: 'next'
		},
		footer: {
			center: 'dayGridMonth,timeGridWeek,timeGridDay,listYear'
			// center: 'listDay,listWeek,listMonth,listYear'
		},
		events: {
			url: `https://www.gospelscout.com/calendar/phpBackend/myFeed.php?u_Id=${u_Id}&linked_cal=${linked_cal}`,
			failure: function(info) {
				console.log(info);
				alert('there was an error while fetching events!');
			},
			 //Need to pass a user id and if a user is logged in and viewing their own calendar, a session id; session id will enable the myfeed.php to return private gigs/events '&status='+status+
		},
		datesRender: function(info){
			console.log(info);
			displayLoadingPage('hide');

		},
		eventClick: function(info) {		//Function opens the event url in a new tab
			info.jsEvent.preventDefault();

			if(info.event.url) {
				window.open(info.event.url);
				return false; 
			}
		},
		nowIndicator: true,
		// progressiveEventRendering: 'true',
		dateClick: function(info) {
			console.log(info);
		    console.log('Date: ' + info.dateStr);
		    console.log('Resource ID: ' + info.allDay);
		  }
    });
    calendar.render();
	console.log(calendar.getEventSources());
  // });

/* reload page */ 
	function page_refresh(){
		location.reload(); 
	}

/* toggle display for google events on gs calendar */
	$('input[name=show_googCal_events]').click(function(event){

		var show_goog_events = $(this).val(); 

		/* update user preference */
			var showGoogEv_xhr = new XMLHttpRequest(); 
			showGoogEv_xhr.onload = function(){
				if(showGoogEv_xhr.status == 200){
					var response = showGoogEv_xhr.responseText.trim(); 
					var parsedResponse = JSON.parse( response );
					console.log(parsedResponse);

					/* add page refresh class */
						if( parsedResponse.show_events_status_updated ){
							$('#googCal_settings').attr('onclick','page_refresh()');
						}
				}
			}
			showGoogEv_xhr.open('get', 'https://www.gospelscout.com/calendar/phpBackend/myFeed.php?show_goog_events='+show_goog_events);
			showGoogEv_xhr.send(); 
		console.log( show_goog_events);

	});

/* on dismissal of modal - remove refresh class */
	$('#linkNewCal').on('hidden.bs.modal', function (e) {
	  $('#googCal_settings').removeAttr('onclick');
	});
