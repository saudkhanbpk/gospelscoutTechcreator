<!-- Add/update linked Google calendar -->
  <div class="modal" id="linkNewCal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="linkNewCal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <!-- Modal Title -->
              <div class="modal-header bg-transparent" style="background-image: url(<?php echo URL;?>img/music3.png);background-position: center;background-repeat: no-repeat;background-size: cover; opacity: 100%;min-height:200px">
                    <p class="font-weight-bold text-white position-absolute" style="font-size: 1.5em; left:10px; top:150px">Google Calendar</p>
              </div>
          <!-- /Modal Title -->

              <div class="modal-body">
                  <div class="form-group">
                      <div class="container">
                      	<div class="row">
                           <p class="font-weight-bold my-2">Settings</p>
                      		
                          <div class="col-12 text-left"> 
                            <form style="font-size:.8em;">
                              <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Linked Calendar Id:</label>
                              <div id="cal_id">
                                <!-- <div class="spinner-border spinner-border-sm text-gs" role="status"><span class="sr-only">Loading...</span></div> -->
                                <p class="pl-2" >
                                  <?php $curr_cal_id = $linked_cal_id != '' ? $linked_cal_id.' (<span class="text-muted" style="font-size:.7em;">primary calendar</span>)':'No Linked Calendar'; echo $curr_cal_id;?> 
                                </p>
                              </div>
                              <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Show Google Calendar Events:</label><br>
                              <?php if($show_goog_events === 1){$showE = 'checked';}else{$hideE = 'checked';}?>
                              <input class="ml-2 goggle_event_toggle" <?php if( $no_a_token ){ echo 'disabled ';}else{ echo $showE;}?> type="radio" name="show_googCal_events" value="1"> Yes <br>
                              <input class="ml-2 goggle_event_toggle" <?php if( $no_a_token ){ echo 'disabled ';}else{ echo $hideE;}?> type="radio" name="show_googCal_events" value="0"> No
                            </form>
                          </div>
                      	</div>

                        <hr class="featurette-divider my-2">

                        <div class="row" >
                          <p class="font-weight-bold my-2">Add or Remove Linked Calendar</p>
                          <div class="col-12" id="add_rem_cal">

                            <div class="container p-0">
                              <div class="row p-0">
                                <div class="col-12 col-md-8 ">
                                  <form name="add_del_cal" >
                                    <select class="custom-select dropdown form-control-sm" name="google_action" style="font-size:.8em;">
                                      <option value="">Link/Un-link Google Calendar</option>
                                      <option value="link">Link New Google Calendar</option>
                                      <option <?php if( empty($_SESSION['google_cal_accessToken']) ){echo 'disabled';}?> value="unlink">Un-Link Current Google Calendar</option>
                                    </select>
                                    <div id="err-div"></div>
                                    <button type="button" onclick="redirectFunct(<?php echo $no_a_token_str;?>)" class="btn btn-sm btn-primary mt-2">submit</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-sm btn-primary" id="googCal_settings" type="button" data-dismiss="modal" aria-label="Close" style="font-size:.8em">Okay</button>
              </div>
      </div>
    </div>
  </div>
  <!-- /Add/update linked Google calendar -->

<!-- linked Google warning message -->
  <div class="modal" id="link_warning" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="linkNewCal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <!-- Modal Title -->
              <div class="modal-header"> 
                <p class="font-weight-bold my-0 text-muted" style="font-size: 1em;">Link/Un-Link Google Calendar</p>
              </div>
          <!-- /Modal Title -->

              <div class="modal-body">
                  <div class="form-group">
                      <div class="container">
                        <div class="row">
                          <div class="col-12 text-left" id="link_mess_container"> 
                            <p class="text-center my-2" id="link_warning_message" style="font-size:.8em"></p>
                          </div>
                        </div>

                      </div>
                  </div>
              </div>
              <div class="modal-footer" id="conf_modal">
                  <div id="terms_privacy"></div>
                  <button class="btn btn-sm btn-primary goog_cal_conf" onclick="linkCal(<?php echo $authUrl;?>)" type="button" style="font-size:.8em">Yes</button>
                  <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal" aria-label="Close" style="font-size:.8em">No</button>
              </div>
      </div>
    </div>
  </div>
<!-- /linked Google warning message -->


