<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/puwAdminDashboard/dashboard/include/adminNav.php');
?>

        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <?php 
                                    // echo '<pre>';
                                    // var_dump($adminInfo);
                                ?>
                                <h2 class="pageheader-title"><span class="text-gs">#</span>popUpWorship Administrator Dashboard</h2>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">
                        
                        <div class="row">
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- Events  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header"> Upcoming Events (<?php echo $eventCount; //echo '<pre>'; var_dump($allEvents);?>)</h5>
                                    <div class="card-body p-0">
                                        <?php if($eventCount > 0){ //echo '<pre>';var_dump($allEvents);?>
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Id
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Location
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Date
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Time
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Attendance
                                                        </th>
                                                         <th>
                                                            View/Edit
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <?php 
                                                $eventCounter = 0;
                                                foreach($allEvents as $event){
                                                    if($eventCounter <= 5){
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $event['id'];?>
                                                            </td>
                                                            <td class="d-none d-md-table-cell">
                                                                <?php echo truncateStr($event['city'],10).', '.$event['statecode'].' '.$event['zip'];?>
                                                            </td>
                                                            <td class="d-none d-md-table-cell">
                                                                <?php 
                                                                    $formatDate = date_create($event['date']);
                                                                    $formatDate = date_format($formatDate, 'm/d/Y');
                                                                    $formatTime = date_create($event['startTime']);
                                                                    $formatTime = date_format($formatTime, 'h:i a');
                                                                    echo $formatDate;
                                                                ?>
                                                            </td>
                                                            <td class="d-none d-md-table-cell">
                                                                <?php echo truncateStr($formatTime, 15);?>
                                                            </td>
                                                            <td class="d-none d-md-table-cell <?php if($event['attendance'] >= $event['capacity']){echo 'text-danger';}else{echo 'text-success';}?>">
                                                                <?php echo $event['attendance'].'/'.$event['capacity'];?>
                                                            </td>
                                                             <td>
                                                                <a class="getEvent" id="<?php echo $event['id'];?>" href="#" >View Event</a> <!-- data-toggle="modal" data-target="#veiw-edit-event" -->
                                                            </td>
                                                        </tr>
                                                <?php 
                                                        $eventCounter++;
                                                    } 
                                                }?>
                                            </table>
                                        <?php }else{

                                            echo '<span class=" bg-primary text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no events</h3</span>';
                                            // echo '<div class="container><h3>There are currently no hosts</h3></div>';
                                        }?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end Events  -->
                                <!-- ============================================================== -->
                            </div>

                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- Hosts  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header"> Hosts (<?php echo $hostCount;?>)</h5>
                                    <div class="card-body p-0">
                                        <?php if($hostCount > 0){?>
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Location
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Phone
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Email
                                                        </th>
                                                        <th class="d-none d-md-table-cell">
                                                            Approve Location
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <?php foreach($allHosts as $host){?>
                                                    <tr>
                                                        <td>
                                                            <?php echo truncateStr($host['host_fname'],10);?>
                                                        </td>
                                                        <td>
                                                            <?php echo truncateStr($host['host_sCityName'],10).', '.$host['statecode'];?>
                                                        </td>
                                                        <td class="d-none d-md-table-cell">
                                                            <?php echo phoneNumbDisplay($host['host_phone']);?>
                                                        </td>
                                                        <td class="d-none d-md-table-cell">
                                                            <?php echo truncateStr($host['host_email'], 15);?>
                                                        </td>
                                                        <td class="d-none d-md-table-cell">
                                                            <?php 
                                                                if($host['approved']){

                                                                    echo '<span class="icon-circle-sm icon-box-md text-success p-2 ml-4 bg-success-light"><i class="fas fa-check"></i></span>';
                                                                }
                                                                else{
                                                                    echo '<button class=" ml-3 btn-sm bg-gs text-white">view & Approve</button>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                            </table>
                                        <?php }else{

                                            echo '<span class=" bg-primary text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no hosts</h3</span>';
                                            // echo '<div class="container><h3>There are currently no hosts</h3></div>';
                                        }?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end Hosts  -->
                                <!-- ============================================================== -->
                            </div>
                       
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- sales traffice source  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header"> Artists (<?php echo count($allArtists);?>)</h5>
                                    <div class="card-body p-0">
                                        <?php if($artistCount > 0){?>
                                            <ul class="traffic-sales list-group list-group-flush">
                                                <?php foreach($allArtists as $artist){?>
                                                    <li class="traffic-sales-content list-group-item ">
                                                        <a href="<?php echo URL;?>newHomePage/views/artistprofile.php?artist=<?php echo $artist['iLoginID'];?>" target="_blank"><span class="traffic-sales-name"><?php echo truncateStr($artist['sFirstName'].' '.$artist['sLastName'], 12);?></span></a><span class="traffic-sales-amount"><?php echo $artist['sCityName'].', '.$artist['statecode'];?><?php if($artist['approved']){echo '<span class="icon-circle-sm icon-box-md text-success p-2 ml-4 bg-success-light"><i class="fas fa-check"></i></span>'; }else{echo '<button class=" ml-3 btn-sm bg-gs text-white d-none d-md-inline">Approve Artist</button>';}?></span><!--<span class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span>-->
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        <?php }else{
                                            echo '<span class=" bg-primary text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no artists</h3</span>';
                                        }?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- sales traffic country source  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Applicants (<?php echo $applicantCount;?>)</h5>
                                    <div class="card-body p-0">
                                         <?php if($applicantCount > 0){ ?>
                                            <ul class="country-sales list-group list-group-flush">
                                                <?php foreach($allApplicants as $Applicant){
                                                    $applicant = truncateStr($Applicant['fName'],10);
                                                    echo '<li class="country-sales-content list-group-item"><span class="">'.  truncateStr($Applicant['fName'].' '.$Applicant['lName'],15) .'</span><span class="float-right text-dark">Event Id -'. $Applicant['eventID'] .'</span></li>';
                                                        /*<span class="mr-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> </span>*/
                                                }?>
                                            </ul>
                                        <?php }else{
                                            echo '<span class=" bg-primary text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no applicants</h3</span>';
                                        }?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice country source  -->
                            <!-- ============================================================== -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                             Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->

    <!-- puwAdminDashboard/dashboard/index - Modals -->

    <!-- --------------------------------- View/Edit Event Modal --------------------------------- -->
      <div class="modal resetOnClose" id="veiw-edit-event" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              
              <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">We just need a little info...</h5> -->
                <span id="loadlogin"></span> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

               <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
                   <div class="row pl-0">
                    <div class="col-md-10 mx-auto text-center">
                      <p style="font-size:1.3em; color:black;">Event Deets</p>
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
              
              <form name="editEvent" id="editEvent" method="post" enctype="mulitpart/form-data">
                <div class="modal-body px-4 pt-2">
                    <div class="container p-0 mb-md-2 text-center"> 
                      
                        <!-- Date/Time -->
                        <div class="row text-center">
                            <div class="col-md-10 mx-auto ">
                              <h4>Date/Time Info</h4>
                            </div>
                        </div>
                        <div class="row text-center mb-0">
                            <div class="col-md-10 mx-auto text-left">
                               <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Date <span class="text-danger">*</span></label>
                               <!-- <input type="text" class="form-control form-control-sm clearDefault my-0" name="date" placeholder="Event Date" value=""/> -->
                                <div class="input-group date dateTime-input" id="datetimepicker0">
                                  <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="date" placeholder="Event Date" value=""/> 
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                            <div class="col-md-10 mx-auto text-left">
                               <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Set Up Time <span class="text-danger">*</span></label>
                              <!-- <input type="text" class="form-control form-control-sm clearDefault my-0" name="setupTime" placeholder="Set Up Time" value=""/> -->
                              <div class="input-group date dateTime-input" id="datetimepicker1">
                                  <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="setupTime" placeholder="Set Up Time" value=""/> 
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                            <div class="col-md-10 mx-auto text-left">
                               <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Start Time <span class="text-danger">*</span></label>
                              <!-- <input type="text" class="form-control form-control-sm clearDefault my-0" name="startTime" placeholder="Start Time" value=""/> -->
                              <div class="input-group date dateTime-input" id="datetimepicker2">
                                  <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="startTime" placeholder="Start Time" value=""/> 
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                            <div class="col-md-10 mx-auto text-left">
                               <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">End Time <span class="text-danger">*</span></label>
                              <!-- <input type="text" class="form-control form-control-sm clearDefault my-0" name="endTime" placeholder="End Time" value=""/> -->
                              <div class="input-group date dateTime-input" id="datetimepicker3">
                                  <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="endTime" placeholder="End Time" value=""/> 
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                            <div class="col-md-10 mx-auto text-left">
                               <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Exit-By Time <span class="text-danger">*</span></label>
                              <!-- <input type="text" class="form-control form-control-sm clearDefault my-0" name="exitByTime" placeholder="Exit Time" value=""/> -->
                              <div class="input-group date dateTime-input" id="datetimepicker4">
                                  <input type="text" class="form-control form-control-sm clearDefault" style="max-width: 150px" name="exitByTime" placeholder="Exit Time" value=""/> 
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                        </div>

                       <!-- Host info -->
                      <div class="row text-center">
                        <div class="col-md-10 mx-auto ">
                          <h4>Host Info</h4>
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

                      <div class="row text-center mt-3">
                        <!-- Host location -->
                        <div class="col-md-10 mx-auto ">
                          <h4>Location</h4>
                        </div>
                      </div>
                      <div class="row text-center mb-0">
                        <div class="col-md-10 mx-auto text-left">
                          <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Street Address <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" name="host_address" placeholder="123 Example Street" value=""/>
                          <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">State <span class="text-danger">*</span></label>
                          <!-- <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" id="sStateName" name="state" placeholder="State" value=""/> -->
                           <select class="custom-select clearDefault my-0" name="host_state" id="sStateName" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                              <option>States</option>
                              <?php 
                              /* Get States */
                                $stateCond = 'country_id = 231';
                                $getStates = $obj->fetchRowAll('states',$stateCond);

                              foreach($getStates as $state){
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

                    <div class="row text-center mb-2">
                        <div class="col-md-10 mx-auto text-left">
                           <!-- Ateendees -->
                          <div class="row text-center mt-2">
                            <div class="col-md-10 mx-auto ">
                              <h4>Event Attendees</h4>
                            </div>
                          </div>

                          <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Attendees (<span id="attendeeNumb"></span>)</label>
                          <div class="container">
                            <div class="row">
                              <div class="col  col-md-12 pt-2">

                                <!-- Insert Event Attendees -->
                                 <div id="attendeeDisplay" > </div>

                              </div>
                            </div>
                          </div>
                      </div>
                  </div>



                      <div class="row text-center">
                        <div class="col-5 mx-auto">
                          <button type="submit" id="btn_editEvent" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Edit Event</button>
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

    <!-- /puwAdminDashboard/dashboard/index - Modals -->





    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <!-- <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script> -->
    <!-- bootstap bundle js -->
    <!-- <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script> -->
    <!-- slimscroll js -->
    <!-- <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script> -->
    <!-- main js -->
    <!-- <script src="assets/libs/js/main-js.js"></script> -->
    
    <!-- chart chartist js 
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script> -->
    
    <!-- sparkline js 
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script> -->

    <!-- morris js 
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script> -->
    
    <!-- chart c3 js
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>  -->


    <script>window.jQuery || document.write('<script src="https://dev.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script> 

    <script src="<?php echo URL;?>newHomePage/js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>newHomePage/js/additional-methods.js"></script>
    <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
    <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo URL;?>newHomePage/puwAdminDashboard/dashboard/js/indexJS.js"></script>
</body>
 
</html>