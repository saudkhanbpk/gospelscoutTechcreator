/* Function to build the attendee table */
	function buildAttendeeTable(attendees){

		var buildEmailSender = '<div class="container">';
		buildEmailSender += '<div class="row"><div class="col"><h4> Send Email to Attendees</h4></div></div>';
		buildEmailSender += '<div class="row"><div class="col"><button eventID="'+attendees[0].eventID+'" type="button" class=" my-2 mx-1 btn btn-sm btn-primary sendEmail" id="email-selected">Send Email to Selected Attendees</button><button eventID="'+attendees[0].eventID+'" type="button" class=" my-2 mx-1 btn btn-sm btn-gs sendEmail" id="email-standby">Send Email to Standby Attendees</button><button eventID="'+attendees[0].eventID+'" type="button" class=" my-2 mx-1 btn btn-sm btn-success sendEmail" id="email-puwLocation">Send location Email to Attendees</button></div></div>';
		buildEmailSender += '</div>';


		var buildTable = '<div class="container"><div class="row"><div class="col text-md-left"><h5>Count ('+attendees.length+')</h5></div></div><div class="row"><div class="col"><table class="table text-center">';
        	buildTable += '<thead><tr><th>Event Id</th><th class="d-none d-md-table-cell">Event Date</th><th class="d-none d-md-table-cell">Name</th><th class="d-none d-md-table-cell">Status</th><th class="d-none d-md-table-cell">Apply Date</th><th class="d-none d-md-table-cell">Action</th></tr></thead>';
		buildTable += '<tbody>';

		for(x in attendees){

			buildTable += '<tr><td>'+attendees[x].eventID+'</td><td>'+attendees[x].date+'</td><td>'+attendees[x].fName+'</td><td>'+attendees[x].status+'</td><td>'+attendees[x].applyDate+'</td>';

			if( attendees[x].status == 'Confirmed' || attendees[x].status == 'Selected to Attend'){
				buildTable += '<td><button class="btn btn-sm btn-danger adminAction" attendeeStatus="'+attendees[x].orig_status_query+'" eventID="'+attendees[x].eventID+'" attendeeID="'+attendees[x].id+'" action="cancel">Cancel</button></td>';
			}
			else if( attendees[x].status == 'Stand By'  ){
				buildTable += '<td><button class="btn btn-sm btn-gs adminAction" attendeeStatus="'+attendees[x].orig_status_query+'" eventID="'+attendees[x].eventID+'" attendeeID="'+attendees[x].id+'" action="select">Select to Attend</button></td>';
			}
			else{
				buildTable += '<td>N/A</td>';
			}
			
			buildTable += '</tr>';
		}

		buildTable += '</tbody>';
		buildTable += '</table></div></div></div>';

		return buildEmailSender+buildTable;
	}