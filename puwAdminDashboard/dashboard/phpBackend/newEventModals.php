<!-- --------------------------------- New Event Modal --------------------------------- -->
  <div class="modal resetOnClose" data-keyboard="false" data-backdrop="static" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">We just need a little info...</h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

           <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
               <div class="row pl-0">
                <div class="col-md-10 mx-auto text-center">
                  <p style="font-size:1.3em; color:black;" id="newEvAtction"></p>
                </div>
              </div>
            </div>

            <!-- Error Div -->
              <div class="container mt-2">
                <div class="row">
                  <div class="col-12 text-center">
                    <p class="text-danger font-weight-bold error-message" style="font-size:.8em"></p>
                  </div>
                </div>
              </div>
            <!-- /Error Div -->            
          
          <form name="addEvent" id="addEvent" method="post" enctype="mulitpart/form-data">
            <div class="modal-body px-4 pt-2">
                <div class="container p-0 mb-md-2 text-center"> 
                  
                   <!-- Contact info -->
                  <div class="row text-center">
                    <div class="col-md-10 mx-auto ">
                      <h4>General Info</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto mb-2 text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Select a State <span class="text-danger">*</span></label>
                      <select class="custom-select clearDefault my-0" name="popUpWorshipState" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                        <option value="">State</option>
                        
                        <?php foreach($getStates as $puwState){
                          echo ' <option value="' . $puwState['name'] . '">' . $puwState['name'] . '</option>';
                        }?>

                      </select>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Music Style <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" name="musicStyle" placeholder="e.g. Acoustic, Choir, Spoken Word, etc.." value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                      <input type="hidden" name="todaysDate" value="<?php echo $today; ?>">
                       <label class="text-gs mb-1 mt-1" style="font-size:12px;font-weight:bold" for="">Event Date <span class="text-danger">*</span></label>
                       <div class="input-group date dateTime-input mb-2 mt-0" id="datetimepicker0">
                       	  <input type="text" class="form-control form-control-sm clearDefault mt-0 mr-2" style="max-width: 150px" name="date" placeholder="Event Date" value=""/> 
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Set Up Time <span class="text-danger">*</span></label>
                      <div class="input-group date dateTime-input" id="datetimepicker1">
                        <input type="text" class="form-control form-control-sm clearDefault mr-2" style="max-width: 150px" id="setupTime" name="setupTime" placeholder="Set Up Time" value=""/> 
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Start Time <span class="text-danger">*</span></label>
                      <div class="input-group date dateTime-input" id="datetimepicker2">
                        <input type="text" class="form-control form-control-sm clearDefault mr-2" style="max-width: 150px" name="startTime" placeholder="Start Time" value=""/> 
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">End Time <span class="text-danger">*</span></label>
                      <div class="input-group date dateTime-input" id="datetimepicker3">
                        <input type="text" class="form-control form-control-sm clearDefault mr-2" style="max-width: 150px" name="endTime" placeholder="End Time" value=""/> 
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Exit-By Time <span class="text-danger">*</span></label>
                      <div class="input-group date dateTime-input" id="datetimepicker4">
                        <input type="text" class="form-control form-control-sm clearDefault mr-2" style="max-width: 150px" name="exitByTime" placeholder="Exit-By Time" value=""/> 
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                  </div>

                  <!-- Host Info -->
                  <div class="row text-center mt-3">
                    <div class="col-md-10 mx-auto ">
                      <h4>Select A Host</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto text-left">
                     
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Click to select a host <span class="text-danger">*</span></label>
                      <div><button class="btn btn-sm btn-gs" type="button" id="selectHostButton">Select a Host</button></div>
                      <div class="container mt-2">
                        <div class="row">
                           <!-- <span class="text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no hosts selected</h3></span> -->
                          <div class="col accordion" id="show_host"></div>
                          <input type="hidden" name="hostID" value="">
                          <input type="hidden" name="address" value="">
                          <input type="hidden" name="city" value="">
                          <input type="hidden" name="state" value="">
                          <input type="hidden" name="zip" value="">
                        </div>
                      </div>
                    </div>
                    <div class="col col-md-10 mx-auto text-center text-danger" id="port_link_error"></div>
                  </div>


                  <!-- Artists Info -->
                  <div class="row text-center mt-3">
                    <div class="col-md-10 mx-auto ">
                      <h4>Select Artists</h4>
                    </div>
                  </div>
                  <?php 
                  // echo '<pre>';
                  // var_dump($talentList);
                ?>
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto mb-2 text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Select Type of Artist <span class="text-danger">*</span></label>
                      <select class="custom-select clearDefault my-0" name="talent" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                        <option value="">Talent</option>
                        
                         <?php 
                          foreach($talentList as $singleTal) {
                            echo '<option value="' . $singleTal['iGiftID'] . '"><a class="dropdown-item talentGroup" artistType="artist" talent="' . $singleTal['iGiftID'] . '" href="#' . $singleTal['sGiftName'] . '">' .  str_replace("_","/",$singleTal['sGiftName']) . '</a></option>';  //' . $singleTal . ' #Bassist
                          }
                        ?>

                      </select>
                    </div>
                  </div>
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Click to select an artist <span class="text-danger">*</span></label>
                      <div><button class="btn btn-sm btn-gs" type="button" id="selectArtistButton">Select an Artist</button></div>
                      <div class="container mt-2">
                        <div class="row">
                          <div class="col" id="show_artist">
                            <span class=" text-center" id="no_current_artists"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no artists selected</h3></span>
                            <table class="table text-center d-none" id="show_artist_table" style="font-size:.8em">
                              <thead>
                                <tr>
                                  <th class="d-none d-md-table-cell">ID</th>
                                  <th>Name</th>
                                  <th>Age</th>
                                  <th>Talent</th>
                                  <th>Pay</th>
                                  <th>De-Select Artist</th>
                                </tr>
                              </thead>
                              <tbody id="append_artist_info"></tbody>
                            </table>
                          </div>
                          <!-- <input type="hidden" name="hostID" value=""> -->
                        </div>
                      </div>
                    </div>
                    <div class="col col-md-10 mx-auto text-center text-danger" id="no_state_error"></div>
                  </div>



                </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px">
                  
                  <div class="container">
                    <div class="row text-center">
                      <div class="col-5 mx-auto">
                        <input type="hidden" name="formAction" value="addNewEvent">
                        <!-- <button type="submit" id="btn_addEvent" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Create Event</button> -->
                        <div id="insertButton"></div>
                        <button class="btn btn-sm" type="button" data-dismiss="modal">cancel</button>
                      </div>
                    </div>
                  </div>

                </div>
              <!-- /Modal Footer -->
            </div>
          </form>
              
        </div>
      </div>
    </div>
<!-- ----------------------------------  /New Event Modal  ---------------------------------- -->


<!-- ----------------------------------  show-state-based-hosts Modal  ---------------------------------- -->
  <div class="modal" id="show-state-based-hosts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
          <span id="loadlogin"></span> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-2 m-0" style="background-color: rgb(233,234,237);"> 
                  <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="30" height="30" data-src="" alt="Generic placeholder image">
                  <p class="text-gs" style="font-size: 1.5em;">Select a Host</p>
              </div>
              
              <!-- Show state-based hosts Modal -->
                  <div class="container mt-3">
                      <div class="row">
                          <div class="col">
                              <h4 class="my-0"><span id="host_state"></span> Hosts</h4>
                              <style>
                                      #viewHostModal th{
                                          padding:0;
                                          width:100px;
                                      }
                                      .loop_container table{
                                          font-size: .8em;
                                      }
                                  </style>
                              <div class="accordion" id="accordionExample"></div>
                          </div>
                      </div>
                  </div>
              <!-- /Show state-based hosts Modal -->

            <!-- Modal Footer -->
              <div class="modal-footer px-4 " style="font-size:13px">
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <button type="button" class="btn btn-gs" data-dismiss="modal">Done</button>
                    </div>
                  </div>
                </div>
              </div>
            <!-- /Modal Footer -->
          </div>
            
      </div>
    </div>
  </div>

<!-- ----------------------------------  /show-state-based-hosts Modal  ---------------------------------- -->

<!-- ----------------------------------  show-state-based-artists Modal  ---------------------------------- -->
  <div class="modal" id="show-state-based-artists" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
          <span id="loadlogin"></span> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-2 m-0" style="background-color: rgb(233,234,237);"> 
                  <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="30" height="30" data-src="" alt="Generic placeholder image">
                  <p class="text-gs" style="font-size: 1.5em;">Select Artists</p>
              </div>
              
              <!-- Show state-based hosts Modal -->
                  <div class="container mt-3">
                      <div class="row">
                          <div class="col">
                              <h4 class="my-0">California Artists</h4>
                              <div id="show_puw_artists"></div>
                          </div>
                      </div>
                  </div>
              <!-- /Show state-based hosts Modal -->

            <!-- Modal Footer -->
              <div class="modal-footer px-4 " style="font-size:13px">
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <button type="button" class="btn btn-gs" data-dismiss="modal">Done</button>
                    </div>
                  </div>
                </div>
              </div>
            <!-- /Modal Footer -->
          </div>
            
      </div>
    </div>
  </div>

<!-- ----------------------------------  /show-state-based-artists Modal  ---------------------------------- -->

<!-- ----------------------------------  New Event Created Modal  ---------------------------------- -->
   <div class="modal" id="event_created_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
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
              <div class="col-md-10 mx-auto py-3 text-center">
                 <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-10 py-3 mx-auto text-center">
                   <p style="font-size:1.3em;" id="succ_message" class="text-gs font-weight-bold"></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col col-md-10 mx-auto" style="font-size: .8em;">
                  
                  </div>    
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                  <button type="button" class="btn btn-sm btn-gs" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ----------------------------------  /New Event Created Modal  ---------------------------------- -->

<!-- ----------------------------------  Event Cancellation Confirmation Modal  ---------------------------------- -->
   <div class="modal" id="cancEventConf" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
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
              <div class="col-md-10 mx-auto py-3 text-center">
                 <p class="text-danger font-weight-bold">Are You Sure You Want To Cancel This Event?</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-5 py-3 mx-auto text-center">
                   <button id="cancelEventButton" type="button" class="btn btn-sm btn-danger px-5">Yes</button>
                  </div>

                  <div class="col col-md-5 py-3 mx-auto text-center">
                    <button type="button" class="btn btn-sm btn-gs px-5" data-dismiss="modal" aria-label="Close">No</button>
                  </div>    
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                  <button type="button" class="btn btn-sm btn-gs" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ----------------------------------  /Event Cancellation Confirmation Modal  ---------------------------------- -->


