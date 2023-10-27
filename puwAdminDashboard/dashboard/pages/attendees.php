<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/include/adminNav.php');

    /* Get States */
        $stateCond = 'country_id = 231';
        $getStates = $obj->fetchRowAll('states',$stateCond);
?>



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
                             /*echo '<pre>';
                             var_dump($allEvents);*/
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
                            <h5 class="card-header">Get Attendees By Event</h5>
                            <div class="card-body p-0">
                                
	                            <div class="container">
	                            	<form name="getAttendees" id="getAttendees" method="post" enctype="mulitpart/form-data">
	                            		<div class="row">
	                            			<div class="col-md-5 mb-2 mt-1 text-left">
												<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Select an Event <span class="text-danger">*</span></label>
												<select class="custom-select clearDefault my-0" name="event" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
													<option value="">Event</option>

													<?php foreach($allEvents as $puwEvent){
														$dateFormat = date_create($puwEvent['date']);
														$dateFormat = date_format($dateFormat, 'm/d/Y');
														echo ' <option value="' . $puwEvent['id'] . '">' . $puwEvent['state'] .' ~ '. $dateFormat .'<span class="d-none"> ~ '. $puwEvent['musicStyle'] .' ~ Attendece: '.$puwEvent['attendance'].'/'.$puwEvent['capacity'] . '</span></option>';
													}?>
												</select>
						                    </div>
						                    <div class="col-md-6 mb-0 text-left">
						                    	<label class="text-gs mb-0" style="font-size:12px;font-weight:bold" for="">Get Users: <span class="text-danger">*</span></label>
						                    
						                    	<div>
													<label for="attendeeStatus">
											    		<div> <!-- Div helps w/ validation error message placement -->
														    <input type="checkbox" name="attendeeStatus[]" id="allAttendees" value="allAttendees">
														    All
														</div>
													</label>
												</div>
						                    	<div>
								                    <label for="attendeeStatus">
											    		<div> <!-- Div helps w/ validation error message placement -->
														    <input type="checkbox" name="attendeeStatus[]" id="selectedToAttend" value="selectedToAttend">
														    Selected to Attend
														</div>
													</label>
												</div>
												<div>
													<label for="attendeeStatus">
											    		<div> <!-- Div helps w/ validation error message placement -->
														    <input type="checkbox" name="attendeeStatus[]" id="standBy" value="standBy">
														    On Stand By
														</div>
													</label>
												</div>
												<div  id="checkStatus">
													<label for="attendeeStatus">
											    		<div> <!-- Div helps w/ validation error message placement -->
														    <input type="checkbox" name="attendeeStatus[]" id="confirmedAttendance" value="confirmedAttendance">
														    Have Confirmed Attendence
														</div>
													</label>
												</div>
											</div>

											<div class="col-md-8 mb-0 text-left">
												<button type="submit" class="btn btn-sm btn-gs">Get Attendees</button>
											</div>
	                            		</div>
	                            		<hr class="featurette-divider my-3">
	                            	</form>
	                            </div>
	                            
	                            <div class="container">
	                            	<div class="row">
	                            		<div class="col text-center py-3" id="showAttendees"></div>
		                            </div>
		                        </div>
	                        </div>


                           	<div class="card-footer text-center">
                                <a href="#" class="btn-primary-link">View Details</a>
                            </div>     
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end Events  -->
                    <!-- ============================================================== -->
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Include the Modals page -->
    <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/phpBackend/attendeesModals.php'); ?>


 <script>window.jQuery || document.write('<script src="https://www.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script> 

    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>
    <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
    <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo URL;?>js/jsFunctions.js"></script>
    <script src="<?php echo URL;?>puwAdminDashboard/dashboard/js/attendeeJSFunction.js?7"></script>
    <script src="<?php echo URL;?>puwAdminDashboard/dashboard/js/attendeesJS.js?13"></script>
</body>
 
</html>