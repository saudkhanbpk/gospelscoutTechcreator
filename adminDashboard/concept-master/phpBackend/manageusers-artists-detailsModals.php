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
                            <button type="submit" class="btn btn-danger" id="confProfDelete" artistID="<?php echo $u_ID;?>" data-dismiss="modal" aria-label="Close">Confirm</button>
                            <button type="button" class="btn btn-gs" id="cancConf1" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                        </div>
                </div>
              </div>
            </div>
        <!-- Confirm Deletion -->
    </form>
<!-- /Delete Modal -->



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

<!-- Add Video Modal Window -->
    <style>
      #progress_bar {
        margin: 10px 0;
        padding: 3px;
        border: 1px solid #000;
        font-size: 14px;
        clear: both;
        opacity: 0;
        -moz-transition: opacity 1s linear;
        -o-transition: opacity 1s linear;
        -webkit-transition: opacity 1s linear;
      }
      #progress_bar.loading {
        opacity: 1.0;
      }
      #progress_bar .percent {
        background-color: #99ccff;
        height: auto;
        width: 0;
      }
    </style>
    <div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="addVideoTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- <div class="container p-3 text-center mb-0 d-none" id="error-message"><p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text" style="border-radius:7px"></p></div> -->
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="fileUpload.php" method="POST" name="videoAdd" id="videoAddID" enctype="multipart/form-data">
            <input type="hidden" name="artistType_via_admin" value="artist">
            <input type="hidden" name="artistID_via_admin" value="<?php echo $u_ID;?>">

              <div class="modal-body">
                    
                    <h6 class="text-gs">Step 1</h6>
                    <div class="container">
                        <div class="form-group">
                            <?php if($u_type == 'artist'){?>
                                <select class="custom-select form-control mb-2" id="vidTalent" name="VideoTalentID">
                                    <option value=''>Choose Talent</option>
                                    <?php foreach($getTalentResults as $talent){
                                        echo '<option value="' . $talent['TalentID'] . '">'; 
                                                echo str_replace("_","/",$talent['talent']); 
                                        echo '</option>';
                                    }?>
                                </select>
                            <?php }
                                  elseif($userRow['sUserType'] == 'church'){?>
                                    <select class="custom-select form-control mb-2" id="vidTalent" name="VideoMinistryID">
                                        <option value=''>Choose Ministry</option>
                                        <?php foreach($currentMinistries as $ministry){
                                            echo '<option value="' . $ministry['iGiftID'] . '">'; 
                                                    echo str_replace("_","/",$ministry['sGiftName']); 
                                            echo '</option>';
                                        }?>
                                    </select>
                            <?php }?>
                        </div>
                        <div class="text-center" id="step1-err"></div>
                    </div>
                    <hr class="my-2"> <!-- Page Divider -->

                    <h6 class="text-gs">
                        <?php if($userRow['sUserType'] == 'group'){
                                    echo 'Step 1';
                                }
                                else{
                                    echo 'Step 2';
                                }
                        ?>
                    </h6>
                    <div class="container" id="vid_src_container">
                        <div class="form-group">
                            <label for="youtubeInput">Youtube Link</label><!-- data-trigger="focus"-->
                            <input type="text" name="youtubeLink" class="form-control vid_source" id="youtubeInput" aria-describedby="emailHelp" placeholder="Enter Youtube Link">
                            <small id="emailHelp" class="form-text text-muted">Save Time and Embed a Youtube Video Instead of Uploading.  
                                <a href="#" data-toggle="popover" data-html="true"  title="Embed a YouTube Video" data-content="<ol><li>Go to the Youtube page of the video to be embedded.</li>  
                                    <li>Under the video click share.</li>
                                    <li>Click embed.</li>
                                    <li>From the box that appears, copy the 'src' value.</li>
                                    <li>Paste the code in the input box provided here.</li></ol>">
                                    How?
                                </a>
                            </small>
                        </div>
                        
                        <h6 class="" style="font-weight:bold">OR</h6>
                        <div class="form-group">
                            <label for="vidTalent">Upload Video</label>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <!-- Show Upload Thumbnail Photo -->
                                        <div class="" id="thumb" style="height:100px;width:100px;"></div>
                                    <!-- Show Upload Thumbnail Photo -->
                                </div>
                                <div class="col-6">
                                    <!-- Show Upload Video File Name-->
                                        <div id="show-vid-name" class="border rounded text-center p-1" style="height:100px;width:100px;font-size:.8em"><p class="mt-4 text-muted">No Video File Uploaded</p></div>
                                    <!-- /Show Upload Video File Name-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <!-- Upload Thumbnail Photo -->
                                        <div class="custom-file mb-0">
                                            <input type="file" class="custom-file-input" id="thumbnailFile" name="thumbnailFile">
                                            <label class="custom-file-label" for="thumbnailFile">Thumbnail</label>
                                        </div>
                                        <div id="thumb_err" class="my-0 text-danger font-weight-bold" style="font-size:.8em"></div>
                                    <!-- Upload Thumbnail Photo -->
                                </div>
                                <div class="col">
                                    <!-- Upload Video File -->
                                        <div class="custom-file mb-2">
                                            <input type="file" class="custom-file-input vid_source" id="videoFile" name="videoFile">
                                            <label class="custom-file-label" for="videoFile"> Video</label>
                                            <div id="vid_err" class="my-0 text-danger font-weight-bold" style="font-size:.8em"></div>
                                        </div>
                                    <!-- /Upload Video File -->
                                </div>
                            </div>
                        </div>
                        <div class="text-center" id="step2-err"></div>
                    </div>
                    <hr class="my-2"> <!-- Page Divider -->
                    <h6 class="text-gs">
                        <?php if($userRow['sUserType'] == 'group'){
                                    echo 'Step 2';
                                }
                                else{
                                    echo 'Step 3';
                                }
                        ?>
                    </h6>
                    <div class="container">
                        <div class="form-group">
                            <label for="vidTalent">Add Video Title & Description</label>
                            <input class="form-control mb-2" type="text" id="vidName" name="videoName" placeholder="Video Title" style="width:">
                            <textarea class="form-control mb-2" id="vidDescr" name="videoDescription" placeholder="Video Description" wrap="" rows="7" aria-label="With textarea"></textarea>
                        </div>
                    </div>
                <!-- Progress Bar for uploading Files -->
                    <div class="container">
                        <h6>Upload Status</h6>
                        <div class="progress mt-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated serverUpload " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div> 
                        </div>
                    </div>
                <!-- /Progress Bar for uploading Files -->

                <div class="text-center text-danger font-weight-bold" id="error-text" style="font-size:.8em"></div>
              </div>
                    
              <input type="hidden" name="contentMarker" value="video">
              <div class="modal-footer">
                <button type="submit" class="btn btn-gs" id="addVid">Add Video</button>
              </div>
          </form>
        </div>
      </div>
    </div>
<!-- /Add Video Modal Window -->

<!-- Youtube Embed Instruction Modal  style="max-height:200px;"-->
    <div class="modal fade mt-3" id="embedInstr" tabindex="-1" role="dialog" aria-labelledby="embedInstr" aria-hidden="true">
      <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <!-- Modal Title -->
                <div class="modal-header">
                    <h6 class="modal-title text-gs">Embed A Youtube Video</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

                <div class="modal-body">
                    <div class="form-group" style="font-size: 12px;">
                        <ol>
                            <li>Go to the Youtube page of the video to be embedded.</li>
                            <li>Under the video click share.</li>
                            <li>Click embed.</li>
                            <li>From the box that appears, copy the HTML code.</li>
                            <li>Paste the code in the input box provided here.</li>
                        </ol>
                    </div>
                </div>
        </div>
      </div>
    </div>
<!-- /Youtube Embed Instruction Modal -->
