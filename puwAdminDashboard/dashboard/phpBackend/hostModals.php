<!-- --------------------------------- Wanna Host Modal --------------------------------- -->
  <div class="modal resetOnClose" id="addHostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                  <p style="font-size:1.3em; color:black;">Enter Host Info Below.</p>
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
          
          <form name="addHost" id="addHost" method="post" enctype="mulitpart/form-data">
            <div class="modal-body px-4 pt-2">
                <div class="container p-0 mb-md-2 text-center"> 
                  
                   <!-- Contact info -->
                  <div class="row text-center">
                    <div class="col-md-10 mx-auto ">
                      <h4>Contact Info</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">First Name <span class="text-danger">*</span></label>
                       <input type="text" class="form-control form-control-sm clearDefault my-0" name="host_fname" placeholder="First Name" value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="host_lname" placeholder="Last Name" value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email Address <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="host_email" placeholder="Email Address" value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Phone Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="host_phone" placeholder="Phone Number" value=""/>
                    </div>
                  </div>

                  <!-- Host location -->
                  <div class="row text-center mt-3">
                    <div class="col-md-10 mx-auto ">
                      <h4>Location</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Price (/hr.) <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="price_per_hr" placeholder="$0.00" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Street Address <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" name="host_address" placeholder="123 Example Street" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">State <span class="text-danger">*</span></label>
                      <!-- <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" id="sStateName" name="state" placeholder="State" value=""/> -->
                       <select class="custom-select clearDefault my-0" name="host_state" id="sStateName" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                          <option>States</option>
                          <?php foreach($getStates as $state){
                            echo '<option value="'. $state['id'] .'">'. $state['name'] .'</option>';
                          }?>
                       </select>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zip Code <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" id="iZipcode" name="host_zip" placeholder="5 digit zip code" value=""/>
                    </div>
                    <div class="col col-md-10 mx-auto text-center" id="port_link_error"></div>
                  </div>

                  <!-- Addt'l Details -->
                  <div class="row text-center mt-2">
                    <div class="col-md-10 mx-auto ">
                      <h4>Addt'l Deets</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-2">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Building Type <span class="text-danger">*</span></label>
                      <select class="custom-select clearDefault my-0" name="buildingType" id="buildingType" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                        <option value="">Building Type</option>
                        <option value="residential">Residential Single Family Home</option>
                        <option value="apartment">Apartment/Condo</option>
                        <option value="office">Office Space</option>
                        <option value="retail">Retail Space</option>
                        <option value="library">Library</option>
                        <option value="school">School</option>
                        <option value="other">Other (please explain in the "Additional Info" section below - required)</option>
                      </select>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Indoor/Outdoor <span class="text-danger">*</span></label>
                      <select class="custom-select clearDefault my-0" name="environment" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                        <option value="">Indoor/Outdoor</option>
                        <option value="indoor">Indoor</option>
                        <option value="outdoor">Outdoor</option>
                      </select>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Maximum Capacity <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="capacity" placeholder="max # of occupants" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Handicap Accessibility <span class="text-danger">*</span></label>
                      <select class="custom-select clearDefault my-0" name="hCapAccessible" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                        <option value="">Handicap Accessible</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                      </select>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">B/t what times is space available <span class="text-danger">*</span></label>
                        <div class="input-group date dateTime-input" id="datetimepicker1">
                          <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="startTime" placeholder="Start Time" value=""/> 
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-time"></span>
                          </span>
                      </div>
                      <div class="input-group date dateTime-input" id="datetimepicker2">
                          <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="endTime" placeholder="End Time" value=""/> 
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-time"></span>
                          </span>
                      </div>

                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Days space is available <span class="text-danger">*</span></label>
                      <div class="container">
                        <div class="row">
                          <div class="col  col-md-5 pt-2" style="background-color: rgb(233,234,237);">
                             <div class="form-group form-check" style="font-size: 12px;max-width: 400px">
                                <input type="checkbox" name="days[]" value="allDays" class="form-check-input" id="allDays">
                                <label class="form-check-label" for="allDays">All</label><br>
                                <?php 
                                  $weekdays = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

                                  foreach($weekdays as $day){
                                ?>
                                    <input type="checkbox" name="days[]" value="<?php echo $day;?>" class="form-check-input" id="<?php echo $day;?>">
                                    <label class="form-check-label" for="<?php echo $day;?>"><?php echo $day;?></label><br>
                                <?php }?>

                              </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  
                  <div class="row tex-center">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Upload Images of your space (8 max.)</label>
                      <!-- Dropzone code -->

                        <!-- Dropzone Css  -->
                          <style>
                            /*body {
                                background: rgb(243, 244, 245);
                                height: 100%;
                                color: rgb(100, 108, 127);
                                line-height: 1.4rem;
                                font-family: Roboto, "Open Sans", sans-serif;
                                font-size: 20px;
                                font-weight: 300;
                                text-rendering: optimizeLegibility;
                            }*/

                            h1 { text-align: center; }

                            .dropzone1 {
                                background: white;
                                border-radius: 5px;
                                border: 2px dashed rgba(149,73,173,1);
                                border-image: none;
                                max-width: 800px;
                                margin-left: auto;
                                margin-right: auto;
                            }
                          </style> 
                        <!-- /Dropzone Css  -->

                        <DIV class="py-3">
                          <div class=" dropzone1 dropzone-previews" id="demo-upload" >
                            <DIV class="dz-message needsclick">    
                              Drop files here or click to upload.
                            </DIV>
                          </div>
                        </DIV>

                        <DIV id="preview-template" style="display: none;">
                          <DIV class="dz-preview dz-file-preview">

                            <DIV class="dz-image">
                              <IMG data-dz-thumbnail="">
                            </DIV>

                            <DIV class="dz-details">
                              <DIV class="dz-size">
                                <SPAN data-dz-size=""></SPAN>
                              </DIV>
                              <DIV class="dz-filename">
                                <SPAN data-dz-name=""></SPAN>
                              </DIV>
                            </DIV>
                            <!-- Progress Bar display -->
                              <!-- <DIV class="dz-progress">
                                <SPAN class="dz-upload" data-dz-uploadprogress=""></SPAN>
                              </DIV> -->

                            <!-- Error Message display -->  
                              <DIV class="dz-error-message">
                                <SPAN data-dz-errormessage=""></SPAN>
                              </DIV> 

                            <!-- Check Mark confirmation when file is selected -->
                              <div class="dz-success-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                  <title>Check</title>
                                  <desc>Created with Sketch.</desc>
                                  <defs></defs>
                                  <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                      <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                  </g>
                                </svg>
                              </div>

                            <button type="button" data-dz-remove class="mt-1 btn-gs btn-sm">cancel</button>

                           </DIV>
                        </DIV>
                      <!-- Dropzone code -->
                    </div>
                  </div>

                  <div class="row tex-center">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Noise Restrictions</label>
                      <textarea class="form-control mb-2" id="noiseRestrictions" name="noiseRestrictions" placeholder="Please Explain ..." wrap="" rows="5" aria-label="With textarea"></textarea>

                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Additional Info</label>
                      <textarea class="form-control mb-2" id="addedInfo" name="addedInfo" placeholder="Any Additional Info You Would Like To Share ..." wrap="" rows="5" aria-label="With textarea"></textarea>
                    </div>
                  </div>


                  <div class="row text-center">
                    <div class="col-5 mx-auto">
                      <button type="submit" id="btn_addHost" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Apply</button>
                    </div>
                  </div>
                </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
          </form>
              
        </div>
      </div>
    </div>
<!-- ----------------------------------  /Wanna Host Modal  ---------------------------------- -->

<!-- Request submitted -->
    <div class="modal" id="requestSubmitted" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <!-- <form name="frmLogin" id="frmLogin" method="post"></form> -->
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
                <p class="text-gs" style="font-size: 1.5em;">Host added!!!</p> <!-- <span class="text-gs font-weight-bold">LA</span> -->
                <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
              </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Request submitted -->

  <!-- View Host Modal -->
    <div class="modal" id="viewHostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
            <div class="modal-body text-center p-0" >
                <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
                    <!-- <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="40" height="40" data-src="" alt="Generic placeholder image"> -->
                    <h3 class="modal-title" id="exampleModalLongTitle">Host - <span class="text-gs" id="hostID_modal"></span></h3>
                </div>

                <div class="container px-4 my-1 my-md-4 text-center"> 
                  
                    <style>
                        #viewHostModal th{
                            padding:0;
                            width:100px;
                        }
                    </style>
                    <div class="row text-center mb-2 loop_container" >
                        <div class="col col-md-10 my-4 mx-auto">
                            <h4 style="background-color: rgb(233,234,237);">Contact Info</h4>
                            <table class="table text-left">
                                <tr>
                                    <th>First Name:</th>
                                    <td id="host_fname">Kirk</td>
                                </tr>
                                <tr>
                                    <th>Last Name:</th>
                                    <td id="host_lname">Drummond</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td id="host_email"><?php echo truncateStr('kirkddrummond@yahoo.com',15);?></td>
                                </tr>
                                <tr>
                                    <th>Phone #:</th>
                                    <td id="host_phone"><?php echo phoneNumbDisplay('4439859457');?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col col-md-10 my-4 mx-auto">
                            <h4 style="background-color: rgb(233,234,237);">Location</h4>
                            <table class="table text-left">
                                <tr>
                                    <th>Address:</th>
                                    <td id="host_address"><?php echo truncateStr('184 West Mission Avenue',20);?></td>
                                </tr>
                                 <tr>
                                    <th>City:</th>
                                    <td id="host_sCityName"></td>
                                </tr>
                                 <tr>
                                    <th>State:</th>
                                    <td id="name"></td>
                                </tr>
                                 <tr>
                                    <th>Zip code:</th>
                                    <td id="host_zip"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col col-md-10 my-4 mx-auto">
                            <h4 style="background-color: rgb(233,234,237);">Addt'l Deets</h4>
                            <table class="table text-left">
                                <tr>
                                    <th>Price/hr.:</th>
                                    <td id="price_per_hr"></td>
                                </tr>
                                <tr>
                                    <th>Type of Space:</th>
                                    <td id="buildingType"></td>
                                </tr>
                                <tr>
                                    <th>Environment:</th>
                                    <td id="environment"><?php echo truncateStr('kirkddrummond@yahoo.com',15);?></td>
                                </tr>
                                <tr>
                                    <th>Capacity:</th>
                                    <td id="capacity"></td>
                                </tr>
                                <tr>
                                    <th> H-cap Accessible:</th>
                                    <td id="hCapAccessible"></td>
                                </tr>
                                <tr>
                                    <th>Availability:</th>
                                    <td>
                                        <span id="startTime"></span> - <span id="endTime"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-top">Days Available:</th>
                                    <td class="align-top" id="daysAvail_table"></td>
                                </tr>
                                <tr>
                                    <th class="align-top">Images:</th>
                                    <td class="align-top" id="imgs_table"></td>
                                </tr>
                                <tr>
                                    <th class="align-top">Noise Restrictions:</th>
                                    <td class="align-top" id="noiseRestrictions"></td>
                                </tr>
                                <tr>
                                    <th class="align-top">Addt'l Info:</th>
                                    <td class="align-top" id="addedInfo"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                    <button class="btn btn-sm btn-danger" id="deleteHost" type="button">Delete Host</button>
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /View Host Modal -->

<!-- Remove Host confirmation  -->
    <div class="modal" id="confirmHostDeletion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLongTitle">Confirm Deletion</h5>
                <span id="loadlogin"></span> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
            <div class="modal-body text-center p-0" >
                <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
                    <button class="btn btn-sm btn-danger" id="confirmDeleteHost" hostID="" >Confirm</button>
                    <button class="btn btn-sm btn-gs" data-dismiss="modal">Cancel</button>
                </div>
          
                <!-- Modal Footer -->
                    <div class="modal-footer px-4 " style="font-size:13px"></div>
                <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Remove Host confirmation -->

  <!-- Remove Host confirmation  -->
    <div class="modal" id="hostDeleted" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <span id="loadlogin"></span> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
            <div class="modal-body text-center p-0" >
                <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
                    <h3 class="modal-title text-danger" id="hostDeletedMessage"> Host Deleted!</h3>
                </div>
          
                <!-- Modal Footer -->
                    <div class="modal-footer px-4 " style="font-size:13px"></div>
                <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Remove Host confirmation -->