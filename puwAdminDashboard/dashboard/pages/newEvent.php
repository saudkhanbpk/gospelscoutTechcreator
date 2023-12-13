<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/include/adminNav.php');

    /* Get States */
        $stateCond = 'country_id = 231';
        // $getStates = $obj->fetchRowAll('states',$stateCond);
        $paramArray0['country_id']['='] = '231';
        $getStates = pdoQuery('states','all',$paramArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

    /* PopUpWorship Cities  - pdo function was used from gsfunctions.php page */
        $table = 'puwcitymaster';
        // $puwCities = pdoQuery($table,'all');
        $puwCities = pdoQuery($table,'all',$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

    /* Query the giftmaster table */
        $fetchTalents = $db->query('SELECT giftmaster.sGiftName, giftmaster.iGiftID FROM giftmaster'); 
        // $talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);
    /* END -Query the giftmaster table */

    /* Reduce $talentList from a 2D to 1D array */
        // foreach($talentList as $tal) {
        //     $talentList1D[] = $tal['sGiftName'];
        // }
    /* END - Reduce $talentList from a 2D to 1D array */
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
                                        <h3><span class="text-gs">#</span>popUpWorship Events</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-gs" id="addNewEvent"> + Add A New Event</button>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="featurette-divider my-3">

                            <div class="card-body p-0">
                                <?php if($eventCount > 0){ ?>
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
                                                        <a class="getEvent" id="<?php echo $event['gigId'];?>" href="#" >View Event</a> <!-- data-toggle="modal" data-target="#veiw-edit-event" -->
                                                    </td>
                                                </tr>
                                        <?php 
                                                $eventCounter++;
                                            } 
                                        }?>
                                    </table>
                                <?php }else{
                                    echo '<span class=" bg-primary text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no events</h3</span>';
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
    <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/puwAdminDashboard/dashboard/phpBackend/newEventModals.php'); ?>


 <script>window.jQuery || document.write('<script src="https://www.stage.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://www.stage.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://www.stage.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script> 

    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>
    <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
    <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo URL;?>js/jsFunctions.js"></script>
    <script src="<?php echo URL;?>node_modules/uuid/dist/umd/uuidv1.min.js"></script>
    <script src="<?php echo URL;?>puwAdminDashboard/dashboard/js/newEventJSFunction.js?1"></script>
    <script src="<?php echo URL;?>puwAdminDashboard/dashboard/js/newEventJS.js?51"></script>
</body>

 
</html>