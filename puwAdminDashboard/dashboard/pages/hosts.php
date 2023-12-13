<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/include/adminNav.php');

    /* Get States */
        $stateCond = 'country_id = 231';
        $getStates = $obj->fetchRowAll('states',$stateCond);
?>

<!-- Dropzone.js file upload plugin -->
    <link href="<?php echo URL; ?>node_modules/dropzone/dist/dropzone.css" rel="stylesheet">
    <script src="<?php echo URL;?>node_modules/dropzone/dist/dropzone.js"></script>

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
                            <div class="container mt-3">
                                <div class="row">
                                    <div class="col text-center">
                                        <h3>Hosts</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-gs" id="addNewHost"> + Add A New Host</button>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="featurette-divider my-3">

                            <div class="card-body p-0">
                                <?php if($hostCount > 0){ //echo '<pre>';var_dump($allEvents);?>
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Id
                                                </th>
                                                 <th class="d-none d-md-table-cell">
                                                    Host Name
                                                </th>
                                                <th class="d-none d-md-table-cell">
                                                    Location
                                                </th>
                                               
                                                <th class="d-none d-md-table-cell">
                                                    Type of Space
                                                </th>
                                                <th class="d-none d-md-table-cell">
                                                    Capacity
                                                </th>
                                                <th class="d-none d-md-table-cell">
                                                    Price
                                                </th>
                                                 <th>
                                                    View/Edit
                                                </th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $eventCounter = 0;
                                        foreach($allHosts as $host){
                                            if($eventCounter <= 5){
                                        ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $host['host_id'];?>
                                                    </td>
                                                     <td class="d-none d-md-table-cell">
                                                        <?php 
                                                            echo $host['host_fname'];
                                                            // $formatDate = date_create($event['date']);
                                                            // $formatDate = date_format($formatDate, 'm/d/Y');
                                                            // $formatTime = date_create($event['startTime']);
                                                            // $formatTime = date_format($formatTime, 'h:i a');
                                                            // echo $formatDate;
                                                        ?>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <?php echo truncateStr($host['host_sCityName'],10).', '.$host['statecode'].' '.$host['host_zip'];?>
                                                    </td>
                                                   
                                                    <td class="d-none d-md-table-cell">
                                                        <?php 
                                                            // echo truncateStr($formatTime, 15);
                                                            echo $host['buildingType'];
                                                        ?>
                                                    </td>
                                                    <td class="d-none d-md-table-cell <?php if($event['attendance'] >= $event['capacity']){echo 'text-danger';}else{echo 'text-success';}?>">
                                                        <?php 
                                                            // echo $event['attendance'].'/'.$event['capacity'];
                                                            echo $host['capacity'];
                                                        ?>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <?php 
                                                            echo '$'.$host['price_per_hr'].'/hr.';
                                                        ?>
                                                    </td>
                                                     <td>
                                                        <a class="getHost" hostID="<?php echo $host['host_id'];?>" id="<?php echo $host['id'];?>" href="#" >View Host</a> <!-- data-toggle="modal" data-target="#viewHostModal" -->
                                                    </td>
                                                </tr>
                                        <?php 
                                                $eventCounter++;
                                            } 
                                        }?>
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
                        <!-- end Events  -->
                        <!-- ============================================================== -->
                    </div>
                </div>
            </div>

		</div>
	</div>
</div>

<!-- Include the Modals page -->
  <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/phpBackend/hostModals.php'); ?>



 <script>window.jQuery || document.write('<script src="https://www.stage.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://www.stage.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://www.stage.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script> 

    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>
    <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
    <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo URL;?>js/jsFunctions.js"></script>
    <script src="<?php echo URL;?>puwAdminDashboard/dashboard/js/hostJS.js"></script>
</body>
 
</html>