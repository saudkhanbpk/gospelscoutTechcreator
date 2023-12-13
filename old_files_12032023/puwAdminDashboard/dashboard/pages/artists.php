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
                                        <h3>PopUpWorship Artists</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-gs" id="addNewHost">Search By State</button>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="featurette-divider my-3">

                            <div class="card-body p-0">
                                <?php if($artistCount > 0){?>
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>
                                                    LoginID
                                                </th>
                                                 <th class="d-none d-md-table-cell">
                                                    Artist Name
                                                </th>
                                                 <th class="d-none d-md-table-cell">
                                                    Age
                                                </th>
                                                <th class="d-none d-md-table-cell">
                                                    Location
                                                </th>
                                                <th class="d-none d-md-table-cell">
                                                    Experience
                                                </th>
                                                 <th>
                                                    Approve Artist
                                                </th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        // $artistCounter = 0;
                                        foreach($allArtists2 as $artist){
                                            // if($artistCounter <= 5){
                                        ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artist['iLoginID']?>" target="_blank"><?php echo $artist['iLoginID'];?></a>
                                                    </td>
                                                     <td class="d-none d-md-table-cell">
                                                        <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artist['iLoginID']?>" target="_blank"><?php echo $artist['sFirstName'];?></a>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artist['iLoginID']?>" target="_blank"><?php echo getAge( $artist['dDOB'] );?></a>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artist['iLoginID']?>" target="_blank"><?php echo truncateStr($artist['sCityName'],10).', '.$artist['statecode'].' '.$artist['iZipcode'];?></a>
                                                    </td>

                                                    <td class="d-none d-md-table-cell">
                                                        <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artist['iLoginID']?>" target="_blank"><?php echo $artist['iYearOfExp'] . ' yr(s).';?></a>
                                                    </td>
                                                     <td id="<?php echo $artist['iLoginID'];?>">
                                                        <?php if($artist['approved'] ){?>
                                                                Approved
                                                        <?php }else{?>
                                                            <a class="btn btn-sm btn-gs approveArtist" artistID="<?php echo $artist['iLoginID'];?>" href="#" >Approve</a> <!-- data-toggle="modal" data-target="#viewHostModal" -->
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                        <?php 
                                                // $artistCounter++;
                                            // } 
                                        }?>
                                    </table>
                                <?php }else{
                                    echo '<span class=" bg-primary text-center"> <h3 class=" my-5" style="color: rgba(204,204,204,1);">There are currently no artists</h3</span>';
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



 <script>window.jQuery || document.write('<script src="https://www.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script> 

    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>
    <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
    <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo URL;?>js/jsFunctions.js"></script>
    <script src="<?php echo URL;?>puwAdminDashboard/dashboard/js/artistsJS.js"></script>
</body>
 
</html>