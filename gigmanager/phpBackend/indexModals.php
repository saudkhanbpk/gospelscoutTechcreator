<!-- ------------------------------- Show Gig Details Modal ------------------------------ -->
  <div class="modal" id="gigDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
             <div class="row pl-0">
              <div class="col-md-10 mx-auto text-center">
                <!-- <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image"> -->
                <p style="font-size:1.0em;" class="text-gs font-weight-bold">Event-ID: <span id="gig_details_gigID"></span></p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" style="font-size:.8em">
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row" id="event_deet_body">
                  <div class="col-10 col-md-5 mx-auto text-left">
                    <table class="table">
                      <tbody>
                        <tr>
                          <!-- <th>Event Type</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Event Type:</label>
                            <p class="my-0 text-muted" id="gigType">#popUpWorshipLA</p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Event Date</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Event Date:</label>
                            <p class="my-0 text-muted" id="eventdate"></p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Set Up Time</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Set Up Time:</label>
                            <p class="my-0 text-muted" id="setupTime"></p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Start Time</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Start Time:</label>
                            <p class="my-0 text-muted" id="startTime"></p>
                          </td>
                        </tr>
                         <tr>
                          <!-- <th>End Time</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">End Time:</label>
                            <p class="my-0 text-muted" id="endTime"></p>
                          </td>
                        </tr>
                         <tr>
                          <!-- <th>End Time</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Location:</label>
                            <p class="my-0 text-muted" id="address"></p>
                            <p class="my-0 text-muted"><span id="city"></span>, <span id="state"></span> <span id="zip"></span></p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="col-10 col-md-5 mx-auto text-left">
                    <table class="table">
                      <tbody>
                        <tr>
                          <!-- <th>Talent</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Talent:</label>
                            <p class="my-0 text-muted" id="sGiftName"></p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Status</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Your Playing Status:</label>
                            <p class="my-0 text-gs font-weight-bold" id="artiststatus"></p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Request Made</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Request Made:</label>
                            <p class="my-0 text-muted" id="age_of_post"></p>
                          </td>
                        </tr>
                        <!--
                        <tr>
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Event Pay:</label>
                            <p class="my-0 text-muted" id="event_pay">N/A</p>
                          </td>
                        </tr>
                        -->
                        <tr>
                          <!-- <th>Request Made</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Deposit Amount:</label>
                            <p class="my-0 text-muted" id="depositamount">N/A</p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Request Made</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Deposit Status:</label>
                            <p class="my-0 text-muted" id="depositstatus">N/A</p>
                          </td>
                        </tr>
                        <tr>
                          <!-- <th>Request Made</th> -->
                          <td>
                            <label class="font-weight-bold my-0" style="font-size:.8em">Deposit Date:</label>
                            <p class="my-0 text-muted" id="depositdate">N/A</p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>


                </div>

                <div class="row">
                  <div class="col col-md-10 mx-auto" style="font-size: .8em;">
                    <p class="font-weight-bold">For addtional inquiries or questions, please contact us @ <span class="text-gs">administrator@gospelscout.com</span></p>
                  </div>    
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px" id='art_action_buttons'></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ------------------------------- /Show Gig Details Modals ------------------------------ -->


<!-- ------------------------------- Gig Confirmation Modal ------------------------------ -->
  <div class="modal" id="confirm_artist_response" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
             <div class="row pl-0">
              <div class="col-md-10 mx-auto text-center">
                <p style="font-size:1.0em;" class="text-gs font-weight-bold" id="conf_title"></p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" style="font-size:.8em">
              <div class="checkbox container py-md-0 m-0"> 
                
                <div class="row" id="event_deet_body">
                  <div class="col-10 col-md-5 mx-auto my-2 text-center px-0">
                    <p class="my-0" id="conf_message"></p>  
                    <p class="my-0 font-weight-bold">Confirm this action below </p>
                  </div>
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                    <button class="btn btn-sm btn-gs" id="send_art_response" artistResponse="" type="button">Confirm</button><button class="btn btn-sm btn-primary" type="button" data-dismiss="modal">cancel</button>
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ------------------------------- /Gig Confirmation Modals ------------------------------ -->


<!-- ------------------------------- Show Gig Details Modal ------------------------------ -->
  <div class="modal" id="conf_to_response" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
             <div class="row pl-0">
              <div class="col-md-10 mx-auto text-center">
                <p style="font-size:1.0em;" class="text-gs font-weight-bold">Confirmation</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body font-weight-bold text-center p-0" style="font-size:.9em">
              <div class="checkbox container py-md-0 m-0"> 
                
                <div class="row" id="event_deet_body">
                  <div class="col-10 col-md-5 mx-auto my-2 text-center px-0">
                    <p class="my-0" id="response_conf_message"></p>  
                  </div>
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                    <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal">Close</button>
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ------------------------------- /Show Gig Details Modals ------------------------------ -->
