<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/adminDashboard/concept-master/include/adminNav.php');

        /* Define user id var */
            $u_ID = trim($_GET['u_ID']);
            echo '<input type="hidden" name="userID" value="' . $u_ID . '">';

        /* Find the current Artist */
            foreach($getUser['artist'] as $currentArtist){
                if($currentArtist['iLoginID'] == $u_ID){
                    $artistFound = $currentArtist;
                    $u_type = 'artist';
                    break;
                }
            }

        /* If user ID is not valid or is non-existent redirect to the active artist page */
            if(!($artistFound) ){
                 echo '<script>window.location = "'. URL .'adminDashboard/concept-master/manageusers-artists.php";</script>';
                 exit;
            }
        /* END - If user ID is not valid or is non-existent redirect to the active artist page */

        /* if user profile image is null or empty */
            if($artistFound['sProfileName'] == null || $artistFound['sProfileName'] == ''){
                $artistFound['sProfileName'] = URL . 'img/dummy.jpg';
            }
        /* Query the db for the artist's security questions and answers */
            $secQuestQuery = 'SELECT  pwordrecoveryquestionsmaster.question, pwordrecoverymaster.answer
                              FROM  pwordrecoverymaster
                              INNER JOIN pwordrecoveryquestionsmaster on pwordrecoverymaster.questionID = pwordrecoveryquestionsmaster.id
                              WHERE pwordrecoverymaster.loginID = ?';

            try{
                $secQuest = $db->prepare($secQuestQuery);
                $secQuest->bindParam(1,$_GET['u_ID']);
                $secQuest->execute(); 
                $secQuestResults = $secQuest->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                echo $e;
            }
        /* END - Query the db for the artist's security questions and answers */

        /* Get Artist's Talent(s) */
            $getTalentQuery = 'SELECT talentmaster.talent, talentmaster.TalentID
                               FROM talentmaster
                               WHERE iLoginID = ?';

            try{
                $getTalent = $db->prepare($getTalentQuery);
                $getTalent->bindParam(1, $u_ID);
                $getTalent->execute(); 
                $getTalentResults = $getTalent->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                echo $e; 
            }
        /* END - Get Artist's Talent(s) */

        /* Query the database for the videos of the current artist */
            $query1 = 'SELECT artistvideomaster.*, giftmaster.sGiftName
                      FROM artistvideomaster
                      INNER JOIN giftmaster on artistvideomaster.videoTalentID = giftmaster.iGiftID
                      WHERE artistvideomaster.iLoginID = ? AND artistvideomaster.removedStatus = 0
                    ';
            try{
                $vidArray = $db->prepare($query1);
                $vidArray->bindParam(1, $u_ID);
                $vidArray->execute();
            }
            catch(Exception $e){
                echo $e; 
            }
            $result = $vidArray->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $eachVid0){
                $eachVid0['uploadDate'] = ageFuntion($eachVid0['uploadDate']);
                $tal = str_replace('_','/',$eachVid0['sGiftName']);
                $talSectArray[$tal][] = $eachVid0;
            }

        /* END - Query the database for the videos of the current artist */

        /* Organize videos according to the talent they display */
            // foreach($result as $eachVid){
            //     $talentArray[] = $eachVid['sGiftName'];
            // }
            // $talentArray = array_unique($talentArray);
            
            // foreach($talentArray as $eachTalent){
            //     foreach($result as $eachVid1){
            //         if($eachVid1['sGiftName'] == $eachTalent){
            //             $talSectArray[$eachTalent][] = $eachVid1; 
            //         }
            //     }
            // }
        /* END - Organize videos according to the talent they display */

        /* Query Database for Artist's photos */
            $query = 'SELECT *
                      FROM gallerymaster
                      WHERE iLoginID = ?
                      ';
            try{
                $photos = $db->prepare($query);
                $photos->bindParam(1, $u_ID);
                $photos->execute(); 
            }
            catch(Exception $e){
                echo $e; 
            }
            $photoResults = $photos->fetchAll(PDO::FETCH_ASSOC);
        /* END - Query Database for Artist's photos */

        /* Organize photos according to the album name they display */
            foreach($photoResults as $eachPhoto){
                $albumArray[$eachPhoto['iAlbumID']] = $eachPhoto['albumName'];
            }
            foreach($albumArray as $IDindex => $eachAlbum){
                foreach($photoResults as $eachPhoto1){
                    if($eachPhoto1['iAlbumID'] == $IDindex){
                        $albumSectArray[$IDindex][] = $eachPhoto1; 
                    }
                }
            }
        /* END - Organize photos according to the album name they display */

        /* Query Database for Artist's video flags */
            $getFlagsQuery = 'SELECT artistvideoreportmaster.*, usermaster.sFirstName, usermaster.sLastName 
                              From artistvideoreportmaster 
                              INNER JOIN usermaster on usermaster.iLoginID = artistvideoreportmaster.reporterId
                              WHERE artistvideoreportmaster.artistId = ?';

            try{
                $getFlags = $db->prepare($getFlagsQuery);
                $getFlags->bindParam(1, $u_ID);
                $getFlags->execute(); 
                $getFlagsResults = $getFlags->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                echo 'Problem retrieving artist video flags: ' . $e; 
            }

            $numbOfFlags = count($getFlagsResults);
        /* END - Query Database for Artist's video flags */
?>
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title"><?php echo $artistFound['sFirstName'] . ' ' . $artistFound['sLastName'];?></h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo URL; ?>adminDashboard/concept-master/index.php" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item">
                                            <?php 
                                                if($artistFound['isActive'] == 1){ 
                                                    echo '<a href="' . URL . 'adminDashboard/concept-master/manageusers-artists.php?act=1" class="breadcrumb-link">';
                                                    echo 'Active Artists';
                                                }else{
                                                    echo '<a href="' . URL . 'adminDashboard/concept-master/manageusers-artists.php?act=0" class="breadcrumb-link">';
                                                    echo 'Inactive Artists';
                                                }
                                                echo '</a>';
                                            ?>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page"><?php echo $artistFound['sFirstName'] . ' ' . $artistFound['sLastName'];?> </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
               
                <!-- ============================================================== -->
                <!-- Artist's General Info -->
                <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                            <div class="card ">
                                <h5 class="card-header">Artist Info</h5>
                                <!-- Artist's profile pic -->
                                    <div class="container text-center text-md-left pl-md-4 mt-2">
                                        <img class="aProfPic" src="<?php echo $artistFound['sProfileName'];?>" height="100px" width="100px">
                                    </div>
                                    <div class="container text-center text-md-left pl-md-4 mt-2">
                                        <a class="font-weight-bold text-gs" href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $u_ID;?>">View Profile</a>
                                    </div>
                                <!-- /Artist's profile pic -->
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col col-md-6">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">First Name:</th>
                                                            <td><?php echo $artistFound['sFirstName'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Last Name: </th>
                                                            <td><?php echo $artistFound['sLastName'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <?php 
                                                                $dob = date_create($artistFound['dDOB']);
                                                                $dob = date_format($dob, "m-d-Y"); 
                                                            ?>
                                                            <th scope="row">DOB: </th>
                                                            <td><?php echo $dob;?></td>
                                                        </tr>
                                                        <tr>
                                                            <?php 
                                                                $from = new DateTime($artistFound['dDOB']);
                                                                $to   = new DateTime('today');
                                                            ?>
                                                            <th scope="row">Age: </th>
                                                            <td><?php echo $from->diff($to)->y; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Gender: </th>
                                                            <td><?php echo $artistFound['sGender'];?></td>
                                                        </tr>
                                                         <tr>
                                                            <?php 
                                                                $jDate = date_create($artistFound['joinDate']);
                                                                $jDate = date_format($jDate, "m-d-Y @ H:i:s"); 
                                                            ?>
                                                            <th scope="row">Join Date: </th>
                                                            <td><?php echo $jDate;?></td>
                                                        </tr>
                                                         
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col col-md-6">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Phone #: </th>
                                                            <td>
                                                                <?php 
                                                                    if($artistFound['sContactNumber'] != '') {
                                                                        /* The substr_replace() method is used to insert '-' into the phone numbers to make them more */
                                                                            $artistContact = $artistFound['sContactNumber'];
                                                                            $artistContact1 = substr_replace($artistContact, '-', 3, 0);
                                                                            $artistContact2 = substr_replace($artistContact1, '-', 7, 0);
                                                                            echo $artistContact2;
                                                                    }
                                                                    else{
                                                                        echo 'N/A';
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Contact Email: </th>
                                                            <td><?php echo $artistFound['sContactEmailID'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <?php 
                                                                $today = date_create($artistFound['dDOB']);
                                                                $dob = date_format($today, "m-d-Y"); 
                                                            ?>
                                                            <th scope="row">City: </th>
                                                            <td><?php echo $artistFound['sCityName'];?></td>
                                                        </tr>
                                                         <tr>
                                                            <th scope="row">State: </th>
                                                            <td><?php echo $artistFound['name'];?></td>
                                                        </tr>
                                                         <tr>
                                                            <th scope="row">Zip Code: </th>
                                                            <td><?php echo $artistFound['iZipcode']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- ============================================================== -->
                <!-- END Artist's General Info -->
                <!-- ============================================================== -->
                        
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- User's login info -->
                    <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Login Info</h5>
                                <div class="card-body table-responsive">
                                    <table class="table"> 
                                        <tbody>
                                            <tr>
                                                <th scope="row">Login Email:</th>
                                                <td><?php echo $artistFound['sEmailID'];?></td>
                                                <td></td>
                                            </tr> 
                                             <tr>
                                                <th scope="row">Security Question 1:</th>
                                                <td class="max-w"><?php echo $secQuestResults[0]['question'];?></td>
                                                <th>Answer1: </th>
                                                <td class=""><?php echo $secQuestResults[0]['answer'];?></td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">Security Question 2:</th>
                                                <td class="max-w"><?php echo $secQuestResults[1]['question'];?></td>
                                                <th>Answer 2: </th>
                                                <td class=""><?php echo $secQuestResults[1]['answer'];?></td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- ============================================================== -->
                    <!-- END User's login info -->
                    <!-- ============================================================== -->
             
                    <!-- ============================================================== -->
                    <!-- Display Artist's Talents -->
                    <!-- ============================================================== -->
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Artist's Talent(s)</h5>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Talent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i = 1; 
                                                foreach($getTalentResults as $cTalent){
                                            ?>
                                                    <tr>
                                                        <th scope="row" style="width:10px;" ><?php echo $i;?></th>
                                                        <td><?php echo str_replace('_', '/',$cTalent['talent']);?></td>
                                                    </tr>
                                            <?php 
                                                    $i++; 
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- ============================================================== -->
                    <!-- end Display Artist's Talents -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- Manage Account Status -->
                    <!-- ============================================================== -->
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Manage Account Status</h5>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Account Status:</th>
                                                <td>
                                                    <?php 
                                                        if($artistFound['isActive'] == 1){ 
                                                            echo 'Active';
                                                        }
                                                        else{
                                                            echo 'Deactivated';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Edit Account:</th>
                                                <td class='py-3' colspan="2"><a href="<?php echo URL;?>adminDashboard/concept-master/adminedit-user-profile.php?u_type=<?php echo 'artist';?>&id=<?php echo $u_ID;?>" class="p-2 mt-4 text-white bg-gs" style="margin-top:12px;font-size:14px;border-radius:2px">Edit Acct</a></td>
                                            </tr>
                                            <tr>
                                                <?php if($artistFound['isActive'] == 1){ ?>
                                                    <th scope="row">Deactivate Account:</th>
                                                    <td><button type="button" class="btn btn-sm btn-gs" data-toggle="modal" data-target="#deactivate">Deactivate Acct</button></td>
                                                <?php }else{?>
                                                    <th scope="row">Activate Account:</th>
                                                    <td><button type="button" class="btn btn-sm btn-gs" data-toggle="modal" data-target="#confirmActivation">Activate Acct</button></td>
                                                <?php }?>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delete Account:</th>
                                                <td colspan="2"><button type="button" class=" btn btn-sm btn-danger" data-toggle="modal" data-target="#delete">Delete Acct</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- ============================================================== -->
                    <!-- end Manage Account Status -->
                    <!-- ============================================================== -->
                </div>
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- Artist's Videos -->
                        <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                <div class="card">
                                    <h5 class="card-header">Aritst's Videos</h5>
                                    <div class="container my-2">
                                        <div class="row">
                                             <div class="col">
                                                <a class="p-1 bg-gs text-white" data-toggle="modal" data-target="#addVideo" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Add New Videos</a>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="card-body" style="max-height: 350px;overflow:scroll;">
                                        <div class="container" id="contentContainer"></div>
                                    </div>
                                </div>
                            </div>

                        <!-- ============================================================== -->
                        <!-- end Artist's Videos -->
                        <!-- ============================================================== -->
                    </div>
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- Artist's Photos -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Aritst's Photos</h5>
                                <div class="card-body" style="max-height: 350px;overflow:scroll;">
                                    <div class="table-responsive ">
                                        <div class="album py-1 bg-light">
                                            <div class="container">
                                                <div class=" mt-0">
                                                    <!-- Display Photos sectioned by photo Album -->
                                                        <?php 
                                                            if(count($photoResults) > 0) {
                                                                foreach($albumSectArray as $index => $photos){ 
                                                        ?>
                                                                    <div class="container pl-0">
                                                                        <div class="row my-2">
                                                                            <div class="col-9 col-sm-8 pl-0">
                                                                                <a href="viewAllPhoto.php?albumID=<?php echo $photos[0]['iAlbumID'];?>&artistID=<?php echo $photos[0]['iLoginID'];?>" style="color:rgba(90,90,90,1);"><h6 class="text-truncate"><?php echo $photos[0]['albumName'];?></h6></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- /Row Div -->
                                                                    <div class="row">
                                                                        <?php 
                                                                            $photoMax = 1;
                                                                            foreach($photos as $indivPhoto){
                                                                                if($photoMax < 7){
                                                                                    /* Display Elapsed Time from date of upload */
                                                                                        $from = date_create($indivPhoto['uploadDate']);
                                                                                        $to = date_create();
                                                                                        $diff = date_diff($from, $to);
                                                                                    /* END - Display Elapsed Time from date of upload */
                                                                            ?>
                                                                                    <div class="col-2 p-0 m-md-0 col-md-2 bg-info "style="border:1px solid rgba(216,216,216,1);">
                                                                                        <a href="">
                                                                                            <img class="card-img-top" style="object-fit:cover; object-position:0,0;" src="<?php echo $indivPhoto['sGalleryImages'];?>" data-src=""  height="100px" alt="Card image cap"> 
                                                                                        </a>
                                                                                    </div>
                                                                            <?php
                                                                                  $photoMax += 1; 
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div> <!-- /Row Div -->    
                                                        <?php       $counter++; 
                                                                }
                                                            }
                                                            else{
                                                        ?>
                                                                <div class="container mt-2 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">No Photos Have Been Added Yet!!!</h1></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    <!-- END - Display Photos sectioned by photo Album -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end Artist's Photos -->
                        <!-- ============================================================== -->
                    </div>

                    <div class="row">
                         <!-- ============================================================== -->
                        <!-- Artist's Gigs -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div>
                                    <h5 class="card-header col col-md-2" style="display: inline-block;">Artist's Gigs</h5>
                                    <div class="col col-sm-4 col-lg-2 col-xlg-2 mb-1 mb-md-0" style="display: inline-block;">
                                        <select class="custom-select getGigs" id="manStatus">
                                            <option value="man" selected>Managed</option>
                                            <option value="con">Confirmed</option>
                                            <option value="pen">Pending</option>
                                        </select>
                                    </div>
                                    <div class=" col col-sm-4 col-lg-2 col-xlg-2" style="display: inline-block;">
                                         <select class="custom-select getGigs" id="occurrance">
                                            <option value="upc" selected>Upcoming</option>
                                            <option value="pas">Past</option>
                                            <option value="can">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="card-body" style="max-height: 350px;overflow:scroll;" id="gigDiv"></div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end Artist's Gigs -->
                        <!-- ============================================================== -->
                    </div>
                    <div class="row">
                         <!-- ============================================================== -->
                        <!-- Artist's Events -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Artist's Events</h5>
                                <div class="card-body">
                                    <div class="container mt-2 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Coming Soon!!!</h1></div>
                                    <!-- <table class="table table-striped text-left">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">First</th>
                                                <th scope="col">Last</th>
                                                <th scope="col">Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                        </tbody>
                                    </table> -->
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end Artist's Events -->
                        <!-- ============================================================== -->
                    </div>
               
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
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
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->


    <!-- Include the Admin Add video page -->
        <?php 
            // include(realpath($_SERVER['DOCUMENT_ROOT']) . '/adminDashboard/concept-master/addVideo.php');
            include(realpath($_SERVER['DOCUMENT_ROOT']) . '/adminDashboard/concept-master/phpBackend/manageusers-artists-detailsModals.php');
        ?>
    <!-- /Include the Admin Add video page -->

    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/vendor/custom-js/jquery.multi-select.html"></script>
    <script src="assets/libs/js/main-js.js"></script>

    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>

    <script src="<?php echo URL;?>adminDashboard/concept-master/js/manageusers-artists-detailsJSFunctions.js?4"></script> 
    <script>
        var artist_id = <?php echo $_GET['u_ID'];?>
    </script>
    <script src="<?php echo URL;?>adminDashboard/concept-master/js/manageusers-artists-detailsJS.js?3"></script>

</body>
 
</html>