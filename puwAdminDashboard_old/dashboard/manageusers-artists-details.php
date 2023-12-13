<?php 
    /* Include Admin top and side navigation */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/adminDashboard/concept-master/include/adminNav.php');

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
                 echo '<script>window.location = "'. URL .'newHomePage/adminDashboard/concept-master/manageusers-artists.php";</script>';
            }
        /* END - If user ID is not valid or is non-existent redirect to the active artist page */

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
        /* END - Query the database for the videos of the current artist */

        /* Organize videos according to the talent they display */
            foreach($result as $eachVid){
                $talentArray[] = $eachVid['sGiftName'];
            }
            $talentArray = array_unique($talentArray);
            
            foreach($talentArray as $eachTalent){
                foreach($result as $eachVid1){
                    if($eachVid1['sGiftName'] == $eachTalent){
                        $talSectArray[$eachTalent][] = $eachVid1; 
                    }
                }
            }
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
                            <?php
                                    // echo '<pre>';
                                    // var_dump($activeCount); 
                                    // var_dump($inActiveCount); 
                                    // var_dump($cancelledGigs); 
                            ?>
                            <h2 class="pageheader-title"><?php echo $artistFound['sFirstName'] . ' ' . $artistFound['sLastName'];?></h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo URL; ?>newHomePage/adminDashboard/concept-master/index.php" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item">
                                            <?php 
                                                if($artistFound['isActive'] == 1){ 
                                                    echo '<a href="' . URL . 'newHomePage/adminDashboard/concept-master/manageusers-artist.php?act=1" class="breadcrumb-link">';
                                                    echo 'Active Artists';
                                                }else{
                                                    echo '<a href="' . URL . 'newHomePage/adminDashboard/concept-master/manageusers-artists.php?act=0" class="breadcrumb-link">';
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
                                        <a class="font-weight-bold text-gs" href="<?php echo URL;?>newHomePage/views/artistprofile.php?artist=<?php echo $u_ID;?>">View Profile</a>
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
                                                <td class='py-3' colspan="2"><a href="<?php echo URL;?>newHomePage/adminDashboard/concept-master/adminedit-user-profile.php?u_type=<?php echo 'artist';?>&id=<?php echo $u_ID;?>" class="p-2 mt-4 text-white bg-gs" style="margin-top:12px;font-size:14px;border-radius:2px">Edit Acct</a></td>
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

                        <!-- Deactivate Modal -->
                            <form name="deactivateAcct" method="POST">
                                <!-- Initiate Deactivation -->
                                    <div class="modal" id="deactivate" tabindex="-1" role="dialog" aria-labelledby="deactivate" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Error Message Display -->
                                                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                                                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                                                </div>
                                            <!-- /Error Message Display --> 

                                            <!-- Modal Title -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Deactivate Artist Account</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <!-- /Modal Title -->

                                            <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="vidTalent">Reason For Deactivation</label>
                                                        <textarea class="form-control mb-2" id="vidDeactReason" name="deactivationReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                                                        <input type="hidden" name="AdminId" value="<?php echo $currentUserID;?>">
                                                        <input type="hidden" name="iLoginID" value="<?php echo $u_ID;?>">
                                                        <!-- <input type="hidden" name="isActive" value="0"> -->
                                                        <p class="text-danger" id="deactErr"></p>
                                                    </div>
                                                </div>
                                             <!-- /Modal Body -->

                                            <!-- Modal Footer data-toggle="modal" data-target="#confirmDeactivation" data-dismiss="modal"-->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-gs" id="deactArtistButton"  aria-label="Close">Deactivate</button>
                                                    <button type="button" class="btn btn-gs" id="cancDeactivation" data-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                            <!-- /Modal Footer -->
                                        </div>
                                      </div>
                                    </div>
                                <!-- /Initiate Deactivation -->

                                <!-- Confirm Deactivation -->
                                    <div class="modal" id="confirmDeactivation" tabindex="-1" role="dialog" aria-labelledby="confirmDeactivation" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Title -->
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLongTitle">Confirm Deactivation</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <!-- /Modal Title -->

                                            <!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <p>Please confirm the deactivation of this artist account.</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-gs" id="confDeactivate" data-dismiss="modal" aria-label="Close">Confirm</button>
                                                    <button type="button" class="btn btn-gs" id="cancConf" data-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                        </div>
                                      </div>
                                    </div>
                                <!-- Confirm Deactivation -->
                            </form>
                        <!-- /Deactivate Modal -->

                        <!-- Activate Modal -->
                            <!-- Confirm Activate Modal -->
                                <div class="modal" id="confirmActivation" tabindex="-1" role="dialog" aria-labelledby="confirmActivation" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Title -->
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLongTitle">Confirm Activation</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <!-- /Modal Title -->

                                            <!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <p>Please confirm the Activation of this artist account.</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-gs" id="confActivate" data-dismiss="modal" aria-label="Close">Confirm</button>
                                                    <button type="button" class="btn btn-gs" id="cancActivate" data-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                        </div>
                                      </div>
                                    </div>
                            <!-- /Confirm Activate Modal -->
                        <!-- /Activate Modal -->

                        <!-- Delete Modal -->
                            <form name="deleteAcct" method="POST">
                                <!-- Initiate Account Deletion -->
                                    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Error Message Display -->
                                                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                                                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                                                </div>
                                            <!-- /Error Message Display --> 

                                            <!-- Modal Title -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Artist Account</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <!-- /Modal Title -->

                                            <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="vidTalent">Reason For Deletion</label>
                                                        <textarea class="form-control mb-2" name="deletionReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                                                        <input type="hidden" name="AdminId" value="">
                                                        <input type="hidden" name="artistID" value="">
                                                        <input type="hidden" name="acctStatus" value="deleted">
                                                    </div>
                                                </div>
                                             <!-- /Modal Body -->

                                            <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" data-toggle="modal" data-target="#confirmDeletion" class="btn btn-gs" id="remArtistButton" data-dismiss="modal" aria-label="Close">Delete</button>
                                                    <button type="button" class="btn btn-gs" id="cancDeletion" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                                                </div>
                                            <!-- /Modal Footer -->
                                        </div>
                                      </div>
                                    </div>
                                <!-- /Initiate Account Deletion -->

                                <!-- Confirm Deletion -->
                                    <div class="modal fade" id="confirmDeletion" tabindex="-1" role="dialog" aria-labelledby="confirmDeletion" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Title -->
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLongTitle">Confirm Deletion</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <!-- /Modal Title -->

                                            <!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <p>Please confirm the deletion of this artist account.</p>
                                                        <h3 class="text-danger font-weight-bold">This action is permanent!!!</h3>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" id="confProfDelete" data-dismiss="modal" aria-label="Close">Confirm</button>
                                                    <button type="button" class="btn btn-gs" id="cancConf" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                                                </div>
                                        </div>
                                      </div>
                                    </div>
                                <!-- Confirm Deletion -->
                            </form>
                        <!-- /Delete Modal -->
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
                                        <?php 
                                            if(count($result) == 0){
                                                echo '<div class="container mt-2 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">This Artist Has Not Added Any Videos Yet!!!</h1></div>';
                                            }
                                            else{
                                                foreach($talSectArray as $TalentName => $vidArrays) { 
                                        ?>
                                                    <!-- Talent Containers -->
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h5><?php echo str_replace('_','/',$TalentName);?></h5>
                                                                </div>
                                                                <div class="col-6 text-right">
                                                                    <a class="anchor-styled" href="<?php echo URL;?>newHomePage/views/viewAllVid.php?tal=<?php echo $TalentName;?>&artistID=<?php echo $u_ID; ?>">View All</a>
                                                                </div>
                                                            </div>
                                                            <!-- Card Rows -->
                                                            <div class="row">
                                                                
                                                                <?php 
                                                                $videoMax = 1;
                                                                $yu = 0; 
                                                                foreach($vidArrays as $eachVidArray){
                                                                        if($videoMax < 6){
                                                                            /* Calculate # of vid flags */
                                                                                // echo '<pre>';
                                                                                // var_dump($eachVidArray);
                                                                                $flagCount = 0;
                                                                                foreach($getFlagsResults as $flag){
                                                                                    if($flag['vidId'] == $eachVidArray['id']){
                                                                                        $flagCount ++;
                                                                                    }
                                                                                }
                                                                            /* END - Calculate # of vid flags */
                                                                 ?> 
                                                                            <!-- Card Content -->
                                                                                <div class="card col-7 p-4 col-md-2 p-md-4 border-light mx-auto mx-md-0">
                                                                                    <a href="<?php echo URL; ?>newHomePage/views/videoDisplay.php?vid_id=<?php echo $eachVidArray['id']; ?>&artistID=<?php echo $u_ID;?>&tal=<?php echo $TalentName; ?>">
                                                                                        <div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; border: 1px solid rgba(0,0,0,.2);">
                                                                                            <?php       
                                                                                                    if($eachVidArray['videoType'] == 'youtube'){ 
                                                                                                        $yLink = $eachVidArray['youtubeLink'];
                                                                                            ?>
                                                                                                        <!-- <div class="embed-responsive embed-responsive-1by1 m-0" id="msg_url<?php echo $yu;?>">
                                                                                                            <iframe  class="embed-responsive-item" src="<?php echo $eachVidArray['youtubeLink']; ?>" frameborder="0" allowfullscreen></iframe> 
                                                                                                        </div> -->
                                                                                                        <img class="card-img-top artist-vid-img" id="msg_url<?php echo $yu;?>" src="" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
                                                                                            
                                                                                                        <script language="javascript" type="text/javascript">
                                                                                                            $(function() {
                                                                                                                var ytl = '<?php echo $yLink;?>';
                                                                                                                var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                                                                                                                yti[1] = yti[1].replace('embed/', '');
                                                                                                                // $("#msg_url<?php echo $yu;?>").html("<p><img src=\"https://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg\" class=\"img-responsive center-block\" /></p>");
                                                                                                                $("#msg_url<?php echo $yu;?>").attr('src',"https://i3.ytimg.com/vi/" + yti[1] + "/hqdefault.jpg");
                                                                                                            });
                                                                                                        </script> 
                                                                                            <?php
                                                                                                        $yu++; 
                                                                                                    }
                                                                                                    else{
                                                                                            ?>
                                                                                                        <img class="card-img-top artist-vid-img" src="<?php if($eachVidArray['videoThumbnailPath'] ==''){echo '../img/gsStickerBig1.png';}else{echo $eachVidArray['videoThumbnailPath'];}?>" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">
                                                                                            <?php } ?>
                                                                                          
                                                                                        </div>
                                                                                    </a>
                                                                                  <div class="card-body pb-0 px-2">
                                                                                    <ul class="list-unstyled card-text-size-gs mb-0 ">
                                                                                        <li class="text-truncate"><span class="d-inline-block"><?php if($eachVidArray['videoType'] == 'youtube'){echo 'Youtube Video';}else{echo $eachVidArray['videoName'];}?></span></li>
                                                                                        <li class="profCards-text-color"><?php echo $eachVidArray['videoViews'];?> Views</li>
                                                                                        <li class="profCards-text-color"><?php echo $eachVidArray['videoLikes'];?> Likes</li>
                                                                                        <li class="profCards-text-color">
                                                                                            <?php
                                                                                                $from = date_create($eachVidArray['uploadDate']);
                                                                                                $to = date_create();
                                                                                                /*
                                                                                                    y - year
                                                                                                    m - month
                                                                                                    d - day 
                                                                                                    h - hour
                                                                                                    i - minute
                                                                                                    s - second
                                                                                                */
                                                                                                $diff = date_diff($from, $to);

                                                                                                /* Display the age of video from years down to seconds */
                                                                                                if($diff->y > 0){
                                                                                                    echo $diff->y . ' Year' . ($diff->y > 1 ? 's' : '') . ' Ago'; 
                                                                                                }
                                                                                                elseif($diff->m > 0){
                                                                                                    echo $diff->m . ' Month' . ($diff->m > 1 ? 's' : '') . ' Ago'; 
                                                                                                }
                                                                                                elseif($diff->d > 0){
                                                                                                    echo $diff->d . ' Day' . ($diff->d > 1 ? 's' : '') . ' Ago'; 
                                                                                                }
                                                                                                elseif($diff->h > 0){
                                                                                                    echo $diff->h . ' Hour' . ($diff->h > 1 ? 's' : '') . ' Ago'; 
                                                                                                }
                                                                                                elseif($diff->i > 0){
                                                                                                    echo $diff->i . ' Min' . ($diff->i > 1 ? 's' : '') . ' Ago'; 
                                                                                                }
                                                                                                elseif($diff->s > 0){
                                                                                                    echo $diff->s . ' Sec' . ($diff->s > 1 ? 's' : '') . ' Ago'; 
                                                                                                }
                                                                                            ?>
                                                                                        </li>
                                                                                    </ul>
                                                                                  </div>
                                                                                  <div>
                                                                                        <a href="#" class="fetchFlags" numbFlags="<?php echo $flagCount;?>" vidID="<?php echo $eachVidArray['id'];?>" <?php if($flagCount > 0){ echo 'data-toggle="modal" data-target="#listFlags"';} ?> >Flags(<span class="<?php if($flagCount > 0){echo 'text-danger';} ?>"><?php echo $flagCount; ?></span>)</a>
                                                                                        <a href="#" style="display:block" class="getVidInfo" style="display:block" vidPath="<?php echo $eachVidArray['videoPath'];?>"  thumbPath="<?php echo $eachVidArray['videoThumbnailPath'];?>" vidID="<?php echo $eachVidArray['id'];?>" data-toggle="modal" data-target="#deleteVid">Delete Video</a>
                                                                                  </div>
                                                                                </div>
                                                                            <!-- /Card Content -->
                                                                <?php   
                                                                            $videoMax += 1; 
                                                                        }
                                                                    }
                                                                ?>
                                                            </div><!-- /Talent Rows -->
                                                            <hr class="my-1"> <!-- Page Divider -->
                                                        </div><!-- /Talent Containers -->
                                        <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Include the Admin Add video page -->
                                <?php 
                                    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomePage/adminDashboard/concept-master/addVideo.php');
                                ?>
                            <!-- /Include the Admin Add video page -->

                            <!-- List FLags Modal -->
                                <div class="modal fade" id="listFlags" tabindex="-1" role="dialog" aria-labelledby="listFlags" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Title -->
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLongTitle">Video Flags</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        <!-- /Modal Title -->

                                        <!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
                                            <div class="modal-body">
                                                <div class="form-group" id="displayFlags">
                                                    
                                                </div>
                                            </div>
                                            <!-- <div class="modal-footer">
                                                <button type="submit" class="btn btn-gs" id="confRemoval" data-dismiss="modal" aria-label="Close">Confirm</button>
                                                <button type="button" class="btn btn-gs" id="cancConf" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                                            </div> -->
                                    </div>
                                  </div>
                                </div>
                            <!-- /List FLags Modal -->

                            <!-- Delete Modal -->
                                <form name="deleteVid" method="POST">
                                    <!-- Initiate Account Deletion -->
                                        <div class="modal fade" id="deleteVid" tabindex="-1" role="dialog" aria-labelledby="deleteVid" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <!-- Error Message Display -->
                                                    <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                                                        <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                                                    </div>
                                                <!-- /Error Message Display --> 

                                                <!-- Modal Title -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Video</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                <!-- /Modal Title -->

                                                <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="vidTalent">Reason For Deletion</label>
                                                            <textarea class="form-control mb-2" name="vidDelReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                                                            <!-- Display error message if admin fails to provide reason for deletion -->
                                                                <div class="container d-none" id="err_mess">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <p class="text-danger mb-0" style="font-size:14px;"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            <input type="hidden" name="action" value="removeVideo">
                                                            <input type="hidden" name="contentMarker" value="video">
                                                            <input type="hidden" name="u_type" value="artist">
                                                            <input type="hidden" name="adminID" value="<?php echo $currentUserID;?>">
                                                            <input type="hidden" name="iLoginID" value="<?php echo $u_ID;?>">
                                                            <input type="hidden" name="id" value="">
                                                            <input type="hidden" name="currentThumbnailPath" value="">
                                                            <input type="hidden" name="currentVideoPath" value="">
                                                        </div>
                                                    </div>
                                                 <!-- /Modal Body -->

                                                <!-- Modal Footer id="exampleModalLongTitle"-->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-gs" id="remVidButt">Delete</button><!-- data-toggle="modal" data-target="#confirmVidDeletion" data-dismiss="modal" aria-label="Close" -->
                                                        <button type="button" class="btn btn-gs" id="cancVidDeletion" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                                                    </div>
                                                <!-- /Modal Footer -->
                                            </div>
                                          </div>
                                        </div>
                                    <!-- /Initiate Account Deletion -->

                                    <!-- Confirm Deletion -->
                                        <div class="modal fade" id="confirmVidDeletion" tabindex="-1" role="dialog" aria-labelledby="confirmVidDeletion" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Title -->
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Confirm Deletion</h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                <!-- /Modal Title -->

                                                <!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <p>Please confirm the deletion of this video.</p>
                                                            <h3 class="text-danger font-weight-bold">This action is permanent!!!</h3>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" id="confVidRemoval" data-dismiss="modal" aria-label="Close">Confirm</button>
                                                        <button type="button" class="btn btn-gs" id="cancVidConf" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                    <!-- Confirm Deletion -->
                                </form>
                            <!-- /Delete Modal -->
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

    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/vendor/custom-js/jquery.multi-select.html"></script>
    <script src="assets/libs/js/main-js.js"></script>

    <script>
        /* Define user's id var */
             var userId = $('input[name=userID]').val();

        /* Manually show and hide deactivation modals */
            $('#deactivate').on('show.bs.modal', function (e) {
                $('#deactErr').html('');
                $('#vidDeactReason').val('');
            });

            $('#deactArtistButton').click(function(event){
                var deactExplan = document.getElementById('vidDeactReason').value; 

                if(deactExplan){
                    $('#deactivate').modal('hide');
                    $('#confirmDeactivation').modal('show');
                }
                else{
                    $('#deactErr').html('Reason for deactivation required!!!');
                }
            });
        /* END - Manually show and hide deactivation modals */
       
        /* Deactivate users account */
            $('#confDeactivate').click(function(event){
                var deactForm = document.forms.namedItem("deactivateAcct");
                var deactFormObj = new FormData(deactForm);

                var sendDeact = new XMLHttpRequest();
                sendDeact.onreadystatechange = function(){
                    if(sendDeact.status == 200 && sendDeact.readyState == 4){
                        var deactReturn = sendDeact.responseText.trim();
                        if(deactReturn > 0){
                            location.reload();
                        }
                    }
                }
                sendDeact.open('POST','/newHomepage/adminDashboard/concept-master/adminDeact-acct.php');
                sendDeact.send(deactFormObj);
            });
        /* END - Deactivate users account */

        /* Activate User's Account */
            $('#confActivate').click(function(event){
                var adminID = $('input[name=AdminId]').val();

                var ActFormObj = new FormData(); 
                ActFormObj.append('activ', '1');
                ActFormObj.append('iLoginID', userId);
                ActFormObj.append('AdminId', adminID);

                var sendAct = new XMLHttpRequest();
                sendAct.onreadystatechange = function(){
                    if(sendAct.status == 200 && sendAct.readyState == 4){
                        var ActReturn = sendAct.responseText.trim();
                        console.log(ActReturn);
                        if(ActReturn > 0){
                            location.reload();
                        }
                    }
                }
                sendAct.open('POST','/newHomepage/adminDashboard/concept-master/adminDeact-acct.php');
                sendAct.send(ActFormObj);
            });
        /* END - Activate User's Account */

        /* Create the fetchGigs Function */
            function fetchGigs(selection1, selection2, userId){
                var getGig = new XMLHttpRequest(); 
                getGig.onreadystatechange = function(){
                    if(getGig.status == 200 && getGig.readyState == 4){
                        if(getGig.responseText.trim() == 'noResults'){
                            $('#gigDiv').html('<div class="container mt-2 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">No Gigs Matching Criteria!!!</h1></div>');
                        }
                        else{
                            $('#gigDiv').html(getGig.responseText);
                        }
                    }
                }
               getGig.open('GET', '/newHomepage/adminDashboard/concept-master/adminGet-gig-event.php?sel1='+selection1+'&sel2='+selection2+'&u_ID='+userId);
               getGig.send();
           }
        /* END - Create the fetchGigs Function */

        /* Call fetchGigs function when page loads */
            var selection1 = $('#manStatus').val();
            var selection2 = $('#occurrance').val();
            var userId = $('input[name=userID]').val();

            fetchGigs(selection1, selection2, userId);
        /* END - Call fetchGigs function when page loads */

        /* Get selctor values for gig table */
            $('.getGigs').change(function(){
                var selection1 = $('#manStatus').val();
                var selection2 = $('#occurrance').val();
                var userId = $('input[name=userID]').val();

                /* Call fetchGigs function when new option is picked from the artist's gigs select menus */
                    fetchGigs(selection1, selection2, userId)
            });
        /* END - Get selctor values for gig table */

        /* Fetch Video Flags */
            $('.fetchFlags').click(function(event){

                event.preventDefault();
                var userId = $('input[name=userID]').val();
                var vid_ID = $(this).attr('vidID');
                var numbFlags = $(this).attr('numbFlags');

                if(numbFlags > 0){
                    var getFlags = new XMLHttpRequest();
                    getFlags.onreadystatechange = function(){
                        if(getFlags.readyState == 4 && getFlags.status == 200){
                            console.log(getFlags.responseText);
                            $('#displayFlags').html(getFlags.responseText);
                        }
                    }
                    getFlags.open('GET', '/newHomepage/adminDashboard/concept-master/adminGet-vidFlags.php?u_ID='+userId+'&vid_ID='+vid_ID);
                    getFlags.send();
                }
            });

        /* Delete Artist Profile - archive the loginmaster and usermaster info*/

        /*************************** Delete Videos ***************************/
            /* Get video data to insert into the video deletion form */
                $('.getVidInfo').click(function(event){
                    var v_id = $(this).attr('vidID');
                    var v_thumbPath = $(this).attr('thumbPath');
                    var v_videoPath = $(this).attr('vidPath');

                    $('input[name=id]').val(v_id);
                    $('input[name=currentThumbnailPath]').val(v_thumbPath);
                    $('input[name=currentVideoPath]').val(v_videoPath);
                    $('#err_mess').addClass('d-none');
                    $('textarea[name=vidDelReason]').css('box-shadow', 'none'); //0px 0px 5px 0px red
                });
            /* Reset form when video deletion is canceled */
                function formReset(){
                    $('textarea[name=vidDelReason]').val('');

                }
            /* Require administrator to give reason for deleting the video */
                $('#remVidButt').click(function(event){

                    var vidDelReason = $('textarea[name=vidDelReason]').val();

                    if(vidDelReason != ''){
                        $('#deleteVid').modal('hide');
                        $('#confirmVidDeletion').modal('show');
                    }
                    else{
                        $('#err_mess').removeClass('d-none');
                        $('textarea[name=vidDelReason]').css('box-shadow', '0px 0px 5px 0px red')
                        $('#err_mess p').html('Please Provide A Reason For Deleting This Video!');
                    }
                });

            $('#confVidRemoval').click(function(event){
                event.preventDefault(); 

                var vidDelForm = document.forms.namedItem('deleteVid');
                var vidDelForm1 = new FormData(vidDelForm);
// console.log(vidDelForm);
                var sendDelForm = new XMLHttpRequest(); 
                sendDelForm.onreadystatechange = function(){
                    if(sendDelForm.readyState == 4 && sendDelForm.status == 200){
                        console.log(sendDelForm.responseText);

                        if(sendDelForm.responseText == '1'){
                            location.reload();
                        }
                    }
                }
                sendDelForm.open('post','<?php echo URL;?>newHomePage/views/fileUpload.php');
                sendDelForm.send(vidDelForm1);

                // console.log(vidDelForm);

            });
        /************************ END - Delete Videos ************************/
    </script>
</body>
 
</html>