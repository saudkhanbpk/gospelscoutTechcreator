
/* Function to build the attendee table */
	function buildAttendeeTable(attendees){
		var buildEmailSender = '<div class="container">';		
		buildEmailSender += '<div class="row"><div class="col"><h4> Send Email to Attendees</h4></div></div>';
		buildEmailSender += '<div class="row"><div class="col-12 col-md-5 text-left "><label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="group_type">Email Group</label><select class="custom-select clearDefault my-0" name="group_type" id="group_type" eventID="'+attendees[0].eventID+'" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);"><option value="">Select Email Group</option><option class="sendEmail" value="email-selected" eventID="'+attendees[0].eventID+'">Email Selected Attendees</option><option class="sendEmail" value="email-standby" eventID="'+attendees[0].eventID+'">Email Standby Attendees</option><option class="sendEmail" value="email-confirmed" eventID="'+attendees[0].eventID+'">Email Confirmed Attendees</option></select></div></div>';
		buildEmailSender += '<div class="row"><div class="col-12 col-md-5 text-left "><label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="sel_email_type">Email Type<span class="text-danger">*</span></label><select class="custom-select clearDefault my-0" name="sel_email_type" id="sel_email_type" eventID="'+attendees[0].eventID+'" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);"><option value="">Select Email Type Group</option><option value="Attendee-Selected">Attendee-Selected Email</option><option value="Attendee-StandBy">Attendee-Standby Email</option><option value="Event-Location">Location Email</option></select></div></div>'; 
		buildEmailSender += '<div class="row"><div class="col-12 col-md-5 text-left "><button class="btn btn-sm btn-gs mt-2" id="trigger-email-conf" type="button">Send Emails</button></div></div>';//data-target="#emailSelectedModal" data-toggle="modal"
		/*
			** As event get closer, remind selected attendees **
			<option class="sendEmailType" value="event-reminder" eventID="'+attendees[0].eventID+'">Event Reminder Email</option>
		*/
		buildEmailSender += '<div class="row"><div class="col-12 col-md-5 text-left" id="show-err"></div></div>';
		buildEmailSender += '</div>';

		var buildTable = '<div class="container"><div class="row"><div class="col text-md-left"><h4>Attendees Count ('+attendees.length+')</h4></div></div><div class="row"><div class="col">';
		buildTable += '<form name="send_attendee_emails1" action="#" method="post" id="sen_attendee_emails1" enctype="mulitpart/form-data"><table class="table text-center" style="font-size:.8em;">';
        	buildTable += '<thead><tr><th class="border-left border-right" font-weight-regular style="font-size:.8em"> Select All<br><input class="mt-2 sel_attendee_all" id="sel_attendee_all" type="checkbox" name="select_all" value=""></th><th>Event Id</th><th class="d-none d-md-table-cell">Event Date</th><th class="d-none d-md-table-cell">Name</th><th class="d-none d-md-table-cell">Status</th><th class="d-none d-md-table-cell">Apply Date</th><th class="d-none d-md-table-cell">Email Status</th><th class="d-none d-md-table-cell">Action</th></tr></thead>';
		buildTable += '<tbody>';

		for(x in attendees){
			buildTable += '<tr><td class="border-left border-right"><input class="sel_attendee" status="'+attendees[x].status_hidden+'" type="checkbox" name="email_recipient[]" value="'+attendees[x].id+'"> </td><td>'+attendees[x].eventID+'</td><td>'+attendees[x].date+'</td><td>'+attendees[x].fName+'</td><td>'+attendees[x].status+'</td><td>'+attendees[x].applyDate+'</td><td>'+attendees[x].email_sent+'</td>';
			if( attendees[x].status == 'Confirmed' || attendees[x].status == 'Selected to Attend'){
				buildTable += '<td><button class="btn btn-sm font-weight-bold btn-danger adminAction" attendeeStatus="'+attendees[x].orig_status_query+'" eventID="'+attendees[x].eventID+'" attendeeID="'+attendees[x].id+'" action="cancel" style="font-size:.8em">Cancel</button></td>';
			}
			else if( attendees[x].status == 'Stand By'  ){
				buildTable += '<td><button class="btn btn-sm font-weight-bold btn-gs adminAction" attendeeStatus="'+attendees[x].orig_status_query+'" eventID="'+attendees[x].eventID+'" attendeeID="'+attendees[x].id+'" action="select" style="font-size:.8em">Select to Attend</button></td>';
			}
			else{
				buildTable += '<td>N/A</td>';
			}
			buildTable += '</tr>';
		}
		buildTable += '</tbody>';
		buildTable += '</table><input type="hidden" name="eventID" value=""><input type="hidden" name="email_type" value=""></form></div></div></div>';
		return buildEmailSender+buildTable;
	}