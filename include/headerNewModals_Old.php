<!-- onboarding Link Modal -->
          <div class="modal" id="str_onboard_link" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="acctDeactivated" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <!-- Modal Title -->
                      <div class="modal-header text-center">
                          <h6 class="modal-title text-gs">Set Up Your GS Pay Account </h6>
                    <span id="loadlogin"></span> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                      </div>
                  <!-- /Modal Title -->

                      <div class="modal-body">
                          <div class="form-group">
                            <div class="container text-center">
                            <div class="row">
                              <div class="col-12"><p style="font-size:1em;">Your GS Pay Account has not been set up yet.  Click below to finish set up and start getting paid.</p></div>
                              <div class="col-12"><a type="button" class="btn btn-sm btn-gs" href="" id="go_to_onboard_link">Finish Set Up</a></div>
                            </div>
                          </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                      <div class="container">
                        <div class="row">
                          <div class="col-6 text-left"><img class="featurette-image img-fluid mx-auto" src="<?php echo URL;?>img/powered_by_stripe.png" width="100" height="50" data-src="" alt="Generic placeholder image"></div>
                        </div>
                      </div>
                          
                      </div>
              </div>
            </div>
          </div>
        <!-- /onboarding Link Modal -->

        <!-- Deactive user account Modal -->
          <div class="modal" id="acctDeactivated" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="acctDeactivated" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <!-- Modal Title -->
                      <div class="modal-header">
                          <h6 class="modal-title text-danger" id="exampleModalLongTitle">Account Deactivated</h6>
                      </div>
                  <!-- /Modal Title -->

                  <!-- <form action="" method="POST" name="photoAdd" enctype="multipart/form-data" id="confirmForm"> onclick="submitReset()"-->
                      <div class="modal-body">
                          <div class="form-group">
                              <p class="text-danger">Your Account Has Been Deactivated</p>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" id="deact-logout" class="btn btn-gs" data-dismiss="modal" aria-label="Close">OK</button>
                      </div>
              </div>
            </div>
          </div>
          <!-- /Deactive user account Modal -->
      
        <!-- Login Modal -->
          <div class="modal" id="login-signup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
              <!--
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Log Into Your Account</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                -->
                 <div class="modal-header bg-primary" style="background-image: url(<?php echo URL;?>img/music1.gif);background-position: center;background-repeat: no-repeat;background-size: cover; opacity: 100%;min-height:150px">
                      <p class="font-weight-bold text-white position-absolute" style="font-size: 2em; left:15px; top:100px">Sign in</p>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                      </button>
                </div>
                <form name="frmLogin" id="frmLogin" method="post">
                 <div class="modal-body px-4">
                 <!--
                      <input class="form-control mb-2" type="text" id="sEmailID" name="sEmailID" placeholder="Email Address" >
                      <input class="form-control" type="password" id="sPassword" name="sPassword" placeholder="Password" >
                      -->
                      
                      <input class="form-control mb-2 border-right-0 border-left-0 border-top-0 my-3" type="text" id="sEmailID" name="sEmailID" placeholder="Email Address" style="font-size:1em">
                      <input class="form-control border-right-0 border-left-0 border-top-0 my-3" type="password" id="sPassword" name="sPassword" placeholder="Password" style="font-size:1em">
                  </div>
                  <!-- Modal Footer -->
                    <div class="modal-footer px-4 border-top-0" style="font-size:13px">
                      <div class="checkbox container p-0"> 
                        <div class="row">
                          <div class="col mx-auto">
                            <a id="btn_login" popUpWorship="false" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:1em">Sign In</a>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col text-center">
                            <span class="text-danger" id="loadlogin1"></span>
                          </div>
                        </div>

                        <div class="row pt-2 mt-2" style="font-size:1.2em">
                          <div class="col"><a href="<?php echo URL;?>index.php#signupSect" class="dismissLogin">Create Account</a></div>
                          <div class="col text-right"><a href="" data-toggle="modal" data-target="#passwordRecovery" data-dismiss="modal">Forgot Password?</a></div>
                        </div>
                      </div>
                    </div>
                    <!-- /Modal Footer -->
                </form>
              </div>
            </div>
          </div>
        <!-- /Login Modal -->

        <!-- Password Recovery Modal -->
          <div class="modal" id="passwordRecovery" tabindex="-1" role="dialog" aria-labelledby="passwordRecovery" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header mb-0">
                  <h5 class="modal-title" id="recovModalTitle">Forgot Password?  No Problem!</h5>
                  <span id="loadlogin"></span> 
                  <button type="button" class="close" data-dismiss="modal"  onclick="showProperDiv()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form name="pwordRecov" id="pwordRecovForm" class="mt-0" method="post">
                  <!-- Recovery Div 1 -->
                    <div class="modal-body px-4 py-0" id="recovEmail">
                      <input class="form-control" type="email" name="sEmailID1" placeholder="Enter Your Email" style="width:">
                   

                      <!-- Modal Footer 1 -->
                        <div class="modal-footer px-4" style="font-size:13px">
                          <div class="checkbox container p-0"> 
                            <div class="row">
                              <div class="col">
                                <a id="submitEmail" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Submit</a>
                              </div>
                            </div>

                            <div class="row pt-2">
                              <div class="col"><a class="dismissPword" href="<?php echo URL;?>index.php#signupSect">Create Account</a></div>
                            </div>
                          </div>
                        </div>
                      <!-- /Modal Footer 1 -->
                    </div>
                  <!-- /Recovery Div 1 -->

                  <!-- Recovery Div 2 -->
                    <div class="container text-gs mt-2 mb-0 d-none" id="recovQuestions">
                      <p class="font-weight-bold" style="font-size:13px;">Answer the following security questions & receive your recovery code.</p>
                      <div class="modal-body px-4 py-0">
                          <ol class="mt-0" style="font-size:13px;">
                            <li>
                              <span id="quest0">What was the make and model of your first car?</span>
                              <div class="container">
                                  <input class="form-control mb-2" style="font-size:13px" type="text" id="answ1" name="sQuest0" placeholder="Answer" style="width:">
                                  <input type="hidden" name="answ0" questID="" value="">
                              </div>
                            </li>
                            <li>
                              <span id="quest1">What is your father's middle name?</span>
                              <div class="container">
                                  <input class="form-control mb-2" style="font-size:13px" type="text" id="answ2" name="sQuest1" placeholder="Answer" style="width:">
                                   <input type="hidden" name="answ1" questID="" value="">
                              </div>
                            </li>
                          </ol>
                      </div>
                    

                      <!-- Modal Footer 2 -->
                        <div class="modal-footer px-4" style="font-size:13px">
                          <div class="checkbox container p-0"> 
                            <div class="row">
                              <div class="col">
                                <a id="submitAnswers" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Submit</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- /Modal Footer 2 -->
                    </div>
                  <!-- /Recovery Div 2 -->

                  <!-- Recovery Div 3 -->
                    <div class="container d-none" id="recovCode">
                      <p class="font-weight-bold text-gs" style="font-size:13px;">Check your email for your recovery code.</p>
                      <input class="form-control" type="email" name="recovCode" placeholder="Enter Your Recovery Code" style="width:">
                      <button type="button" class="btn-sm btn-gs my-2">Resend Code</button>

                      <!-- Modal Footer 3 -->
                        <div class="modal-footer px-4" style="font-size:13px">
                          <div class="checkbox container p-0"> 
                            <div class="row">
                              <div class="col">
                                <a id="submitCode" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Submit</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- /Modal Footer 3 -->
                    </div>
                  <!-- /Recovery Div 3 -->

                  <!-- Recovery Div 4 -->
                    <div class="container text-gs mt-2 mb-0 d-none" id="newPwords">
                      <p class="font-weight-bold pl-3" style="font-size:13px;">Enter New Password.</p>
                      <div class="modal-body px-4 py-0">
                        <div class="container">
                            <input class="form-control mb-2" style="font-size:13px" type="password" id="pword" name="sNewPassword" placeholder="New Password">
                        </div>

                        <div class="container">
                            <input class="form-control mb-2" style="font-size:13px" type="password" id="cpword" name="sConfNewPassword" placeholder="Confirm Password">
                        </div>
                      </div>
                    

                      <!-- Modal Footer 4 -->
                        <div class="modal-footer px-4" style="font-size:13px">
                          <div class="checkbox container p-0"> 
                            
                            <div class="row">
                              <div class="col">
                                <a id="submitNewPword" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Save</a>
                              </div>
                            </div>

                          </div>
                        </div>
                      <!-- /Modal Footer 4 -->
                    </div>
                  <!-- /Recovery Div 4 -->

                  <!-- Recovery Div 5 -->
                    <div class="container text-gs mt-2 mb-0 d-none" id="pwordUpdated">
                      <div class="modal-body px-4 py-0">
                        <div class="container">
                           <div class="row mb-3">
                              <div class="col">
                                <a id="newLogin" class="btn btn-block bg-gs text-white p-2" data-dismiss="modal"  onclick="showProperDiv()" data-toggle="modal" data-target="#login-signup" tabindex="3" style="font-size:13px">Login</a>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  <!-- /Recovery Div 5 -->
                </form>

                <!-- Display Error Message -->
                  <div class="container text-center d-none text-danger mb-2" id="errorMessage">
                    <div class="row">
                      <div class="col"  id="errorMessageContent"></div>
                    </div>
                  </div>
                <!-- /Display Error Message -->
              </div>
            </div>
          </div>

      <!-- /Password Recovery Modal -->