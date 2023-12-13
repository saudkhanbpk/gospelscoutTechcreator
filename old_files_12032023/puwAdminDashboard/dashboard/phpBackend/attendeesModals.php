<!-- Cancel Attendee Reason -->
    <div class="modal" id="attendeeCancellationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <h3 class="modal-title text-danger" id="hostDeletedMessage">Reason Cancelling Attendee</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

	        <form name="cancelAttendee" id="cancelAttendee" method="post" enctype="mulitpart/form-data">
	            <div class="modal-body text-left p-0" >
	                <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
	                    <div class="row">
	                    	<div class="col">
		                    		<label class="text-danger mb-1" style="font-size:12px;font-weight:bold" for="">Cancellation Reason</label>
		                      		<textarea class="form-control mb-2" id="attendeeCancellationReason" name="attendeeCancellationReason" placeholder="Please Explain ..." wrap="" rows="5" aria-label="With textarea"></textarea>
		                      		<input type="hidden" name="event" value="">
		                      		<input type="hidden" name="id" value="">
		                      		<input type="hidden" name="status" value="">
		                      	</form>
	                    	</div>
	                    </div>
	                </div>
	          
	                <!-- Modal Footer -->
	                    <div class="modal-footer px-4 " style="font-size:13px">
	                    	<button class="btn btn-sm btn-danger" type="submit">Cancel Attendee</button>
	                    </div>
	                <!-- /Modal Footer -->
	            </div>
	        </form>
              
        </div>
      </div>
    </div>
  <!-- /Cancel Attendee Reason -->

  <!-- Select Attendee -->
    <div class="modal" id="attendeeSelectionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <h3 class="modal-title text-gs" id="hostDeletedMessage">Select Attendee</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

	        <form name="selectAttendee" id="selectAttendee" method="post" enctype="mulitpart/form-data">
	            <div class="modal-body text-center p-0" >
	                <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
	                    <div class="row">
	                    	<div class="col">
		                    		<h4 class="text-gs mb-1">Confirm Attendee Selection</h4>
		                      		<button class="btn btn-sm btn-gs" type="submit">Confirm Selection</button>
		                      		<input type="hidden" name="event" value="">
		                      		<input type="hidden" name="id" value="">
		                      		<input type="hidden" name="status" value="">
		                      	</form>
	                    	</div>
	                    </div>
	                </div>
	          
	                <!-- Modal Footer -->
	                    <div class="modal-footer px-4 " style="font-size:13px">
	                    	
	                    </div>
	                <!-- /Modal Footer -->
	            </div>
	        </form>
              
        </div>
      </div>
    </div>
  <!-- /Select Attendee -->
  
  <!-- Email Selected Attendees -->
    <div class="modal" id="emailSelectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <h3 class="modal-title text-gs" id="hostDeletedMessage">Email <span id="email_type">Selected</span> Attendees</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

	            <div class="modal-body text-center p-0" >
	                <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
	                    <div class="row">
	                    	<div class="col">
	                    		<form name="send_attendee_emails" id="send_attendee_emails" method="post" enctype="mulitpart/form-data">
		                    		<h4 class="text-gs mb-1">Ready to Send Emails?</h4>
		                      		<input type="hidden" name="eventID" value="">
		                      		<input type="hidden" name="email_type" value="">
		                      		<!-- <input type="hidden" name="status" value=""> -->
		                      		<button class="btn btn-sm btn-gs" type="button" id="send_attendee_emails_button">Send Email</button>
		                      		<button class="btn btn-sm btn-gs" data-dismiss="modal" type="button">Cancel</button>
		                      	</form>
	                    	</div>
	                    </div>
	                </div>
	          
	                <!-- Modal Footer -->
	                    <div class="modal-footer px-4 " style="font-size:13px">
	                    	
	                    </div>
	                <!-- /Modal Footer -->
	            </div>
              
        </div>
      </div>
    </div>
  <!-- /Email Selected Attendees -->