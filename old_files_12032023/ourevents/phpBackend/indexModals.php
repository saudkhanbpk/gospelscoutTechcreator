 
<!-- ------------------------------- Wanna perform Modals ------------------------------ -->
 <!-- User-not-loggedIn Modal -->
    <div class="modal" id="userNotLoggedIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Log In/Sign Up</h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <!-- <form name="frmLogin" id="frmLogin" method="post"></form> -->
            <div class="modal-body text-center p-0" >
              <div class="container py-2 mb-3" style="background-color: rgb(233,234,237);">
                <div class="row">
                  <div class="col-md-4 my-2 m-md-0">
                    <h4>Step 1</h4>
                    <img class="rounded-circle my-1" src="<?php echo URL; ?>img/dummy.jpg" alt="Generic placeholder image" width="80" height="80">
                    <p class="font-weight-bold" style="color:black;font-size:1em">LogIn/SignUp</p>
                  </div>
                  <div class="col-md-4 my-2 m-md-0">
                    <h4>Step 2</h4>
                    <img class="rounded-circle my-1" src="<?php echo URL; ?>img/fileImg4.png" alt="Generic placeholder image" width="80" height="80">
                    <p class="font-weight-bold" style="color:black;font-size:1em">Apply</p>
                  </div>
                  <div class="col-md-4 my-2 m-md-0">
                    <h4>Step 3</h4>
                    <img class="rounded-circle my-1" src="<?php echo URL; ?>img/PlayingImg.png" alt="Generic placeholder image" width="80" height="80">
                    <p class="font-weight-bold" style="color:black;font-size:1em">Perform</p>
                  </div>
                </div>
              </div>
              <div class="container py-md-4 m-0" > 
                <div class="row text-center" style="">
                  <div class="col col-md-3 mx-auto">
                    <a id="btn_loginPopupworship" class="btn-sm btn-block bg-gs text-white p-3" data-toggle="modal" data-target="#login-signup" data-dismiss="modal" tabindex="3" style="font-size:1em">Log In</a>
                  </div>
                  <div class="col col-md-3 mx-auto">
                    <a id="btn_signup" href="<?php echo URL;?>signup/artist/" class="btn-sm btn-block bg-gs text-white p-3" tabindex="3" style="font-size:1em">Sign Up</a>
                  </div>
                </div>
              </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /User-not-loggedIn Modal -->

<!-- Requirements-Not-Met Modal -->
  <div class="modal resetOnClose" id="reqsNotMet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">We need just a little more info...</h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

           <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
               <div class="row pl-0">
                <div class="col-md-10 ">
                  <ol style="font-size:.85em">
                    <li>
                      <span class="font-weight-bold"> Add music content for us to check out.</span>

                      <ul>
                        <li><span class="font-weight-bold">option 1:</span> add video content via the video tab on your <a class="text-gs font-weight-bold" href="<?php echo URL;?>views/artistprofile.php" target="_blank">GospelScout profile</a>, then return to this page and click the perform button</li>
                        <li><span class="font-weight-bold">option 2:</span> add links to your music and video content using the form provided below (@ least 1 link is <span class="font-weight-bold">required</span>)</li>
                      </ul>
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          
          <form name="addMusicLinks" id="addMusicLinks" method="post">
            <div class="modal-body px-4 pt-2 border-top">
                <!-- <p style="color:black; font-size: 2em; font-weight:">Apply to perform <span class="text-gs font-weight-bold">@</span> #popUpWorship<span class="text-gs font-weight-bold">LA</span></p> -->
                <div class="container p-0 mb-md-2"> 
                  <div class="row text-center">
                    
                    <!-- Music portfolio links -->
                    <div class="col-md-10 mx-auto ">
                      <h4>Music Portfolio</h4>
                      <h6 class="mb-0">(youtube, soundcloud, spotify, etc.)</h6>
                      <p class="mt-0 font-weight-bold" style="font-size:.7em">@ least one link required <span class="text-danger">*</span></p>
                    </div>
                  </div>
                  <div class="row text-center mb-2">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Portfolio URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" name="usercontentlinksmaster[portfolioUrl1]" placeholder="Link #1 to your music" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Portfolio URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" name="usercontentlinksmaster[portfolioUrl2]" placeholder="Link #2 to your music" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Portfolio URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0 port_links" name="usercontentlinksmaster[portfolioUrl3]" placeholder="Link #3 to your music" value=""/>
                    </div>
                    <div class="col col-md-10 mx-auto text-center" id="port_link_error"></div>
                  </div>

                  <!-- Other Profiles -->
                  <div class="row text-center">
                    <div class="col-md-10 mx-auto ">
                      <h4>Other Profiles</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-2">
                    <div class="col-md-10 mx-auto text-left">
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Website URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="usercontentlinksmaster[website]" placeholder="Link #1 to your music" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Youtube URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="usercontentlinksmaster[youtube]" placeholder="Link #2 to your music" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Instagram URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="usercontentlinksmaster[instagram]" placeholder="Link #3 to your music" value=""/>
                      <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Spotify URL</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="usercontentlinksmaster[spotify]" placeholder="Link #3 to your music" value=""/>
                    </div>
                  </div>

                  <!-- Select a City -->
                  <div class="row text-center">
                    <div class="col-md-10 mx-auto ">
                      <h4>Select a City</h4>
                    </div>
                  </div>
                  <div class="row text-center mb-3">
                    <div class="col-md-5 mx-auto ">
                      <select class="custom-select clearDefault my-0" name="popUpWorshipCity" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                        <option value="">City</option>
                        
                        <?php foreach($puwCities as $puwCity){
                          echo ' <option value=" ' . $puwCity['id'] . '">' . $puwCity['cityName'] . '</option>';
                        }?>

                      </select>
                    </div>
                  </div>


                  <div class="row text-center">
                    <div class="col-5 mx-auto">
                      <button type="submit" id="btn_apply_login" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Apply</button>
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
  <!-- /Requirements-Not-Met Modal -->

  <!-- Apply Button Modal -->
    <div class="modal resetOnClose" id="applyButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                <p style="color:black; font-size: 2em; font-weight:">Apply to perform <span class="text-gs font-weight-bold">@</span> a #popUpWorship event</p> <!-- <span class="text-gs font-weight-bold">LA</span> -->
                  
                  <form name="loggedInApply" id="loggedInApply" method="post">
                    <!-- Select a City -->
                    <div class="row text-center">
                      <div class="col-md-10 mx-auto ">
                        <h4>Select a City</h4>
                      </div>
                    </div>
                    <div class="row text-center mb-3">
                      <div class="col-md-5 mx-auto ">
                        <select class="custom-select clearDefault my-0" name="popUpWorshipCity" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                          <option value="">City</option>

                          <?php foreach($getStates as $puwState){
                            echo ' <option value="' . $puwState['name'] . '">' . $puwState['name'] . '</option>';
                          }?>

                        </select>
                      </div>
                    </div>

                    <div class="row text-center" style="">
                      <div class="col-5 mx-auto">
                        <button id="btn_applyPopupworship" type="submit" class="btn btn-block bg-gs text-white p-2 applyPUW" tabindex="3" style="font-size:13px">Apply</button>
                      </div>
                    </div>
                  </form>

                </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Apply Button Modal -->

  <!-- Handle non-artist profile Modal -->
    <div class="modal" id="nonArtistMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <p style="color:black; font-size: 1em;">Sorry, you <span class="text-gs font-weight-bold">must</span> have an artist account to apply to perform!</p> <!-- <span class="text-gs font-weight-bold">LA</span> -->
                  
                    <div class="row text-center mb-3">
                      <div class="col col-md-3 mx-auto ">
                        <a data-dismiss="modal" class="btn-sm btn-block bg-gs text-white">Got it</a>
                      </div>
                    </div>

                </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Handle non-artist profile Modal -->

  <!-- Request submitted -->
    <div class="modal" id="requestSubmitted" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
              <div class="checkbox container py-md-2 m-0" style="background-color: rgb(233,234,237);"> 
                <p class="text-gs" style="font-size: 1.5em;">Thanks, we have received your request!!!</p> <!-- <span class="text-gs font-weight-bold">LA</span> -->
                <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="40" height="40" data-src="" alt="Generic placeholder image">
              </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Request submitted -->
  
  <!-- Request submitted To Attend Event -->
    <div class="modal" id="requestSubmittedToAttend" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header text-center text-md-left">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <span id="loadlogin"></span> 
            <h5 class="text-gs">Thanks, Request Submitted!!!</h5> <!-- style="font-size: 1.2em;"-->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <!-- <form name="frmLogin" id="frmLogin" method="post"></form> -->
            <div class="modal-body text-center p-0" >
             
              <div class="container" style="background-color: rgb(233,234,237);">
              	<div class="row">
              		<div class="col text-left mt-2" >
              			<h5 style="">Next Steps...</h5><!-- color: rgba(204,204,204,1) -->
              		</div>
              	</div>
              	<div class="row text-center">
              		 <!--<div class="col-md-4 my-2 m-md-0">
	                    <p class="font-weight-bold" style="color:black;font-size:1em">1. Receive Event Location</p>
	                    <p>You will recieve an email, letting you know if you have been selected to attend.  In the event that you are not selected, <span class="text-gs font-weight-bold">DO NOT WORRY!!!</span> We, @ GospelScout, still <span class="text-gs font-weight-bold"><svg class="bi bi-heart-fill" width="1em" height="1em" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 3.314C14.438-1.248 25.534 6.735 10 17-5.534 6.736 5.562-1.248 10 3.314z" clip-rule="evenodd"/></svg> YOU</span>.  It's likely that the event has reached capacity and we urge you to request to attend the next one. </p>
	                  </div>
	                  <div class="col-md-4 my-2 m-md-0">
	                    	<p class="font-weight-bold" style="color:black;font-size:1em">2. Confirm Attendance</p>
	                    	<p>Let us know you are coming, so we can hold your spot.  The selection email will contain a confirmation link.  You will have 48hrs. to confirm or we will have to give your spot away <span class="text-gs font-weight-bold">:-(</span></p>
	                  </div>
	                  
	                  <div class="col-md-4 my-2 m-md-0">
	                    <h4>Step 1</h4>
	                    <img class="rounded-circle my-1" src="<?php echo URL; ?>img/dummy.jpg" alt="Generic placeholder image" width="80" height="80">
	                    <p class="font-weight-bold" style="color:black;font-size:1em">Receive Event Location</p>
	                  </div>
	                  <div class="col-md-4 my-2 m-md-0">
	                    <h4>Step 2</h4>
	                    <img class="rounded-circle my-1" src="<?php echo URL; ?>img/fileImg4.png" alt="Generic placeholder image" width="80" height="80">
	                    <p class="font-weight-bold" style="color:black;font-size:1em">Come Hang Out W/ Us</p>
	                  </div> -->
	                  
	                  <div class="col-md-4 my-2 my-md-0 mx-md-auto">
	                      <h4>Step 1</h4>
	                      <img class="rounded-circle my-1" src="<?php echo URL; ?>img/icons/loation_icon_3.png" alt="Generic placeholder image" width="80" height="80">
	                      <p class="font-weight-bold mb-1" style="color:black;font-size:1em">Receive Event Location</p>
	                      <p class="text-muted my-0" style="font-size:.8em">You wil receive a confirmation email w/ event details, shortly.</p>
	                    </div>
	                    <div class="col-md-4 my-2my-md-0 mx-md-auto">
	                      <h4>Step 2</h4>
	                      <img class="rounded-circle my-1" src="<?php echo URL; ?>img/PlayingImg.png" alt="Generic placeholder image" width="80" height="80">
	                      <p class="font-weight-bold" style="color:black;font-size:1em">Come Hang Out W/ Us</p>
	                    </div>
	                  <!--<div class="col-md-4 my-2 m-md-auto">
	                   	 <p class="font-weight-bold" style="color:black;font-size:1.3em">Receive Event Location</p>
	                   	 <p style="font-size:1em">You will receive the event address via email 48 - 72hrs. prior to the event.</p>
	                  </div> -->
              	</div>
              </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                	<div class="container">
                		<div class="row">
                			<div class="col">
                				<button type="button" class="btn btn-sm btn-gs px-5" data-dismiss="modal">I Got It</button></div>
                			</div>
                		</div>
                	</div>
                
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Request submitted To attend Event -->

  <!-- Request submitted -->
    <div class="modal" id="alreadyApplied" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0" style="background-color: rgb(233,234,237);"> 
                <p class="text-gs" style="font-size: 1.2em;">OOps, You've already applied for this event.  We will let you know if you've been selected shortly.</p> <!-- <span class="text-gs font-weight-bold">LA</span> -->
                <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
                <p class="text-gs" style="font-size: 1.2em;">Feel free to select another event in the mean time!!!</p> <!-- <span class="text-gs font-weight-bold">LA</span> -->
              </div>
              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  <!-- /Request submitted -->

<!-- ------------------------------- /Wanna perform Modals ------------------------------ -->


<!-- --------------------------------- Wanna Host Modal --------------------------------- -->
  <div class="modal resetOnClose" id="wannaHost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                  <p style="font-size:1.3em; color:black;">Tell us about your space.</p>
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
                          <option value="">States</option>
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
                          <input type="text" class="form-control form-control-sm clearDefault mr-2" style="max-width: 150px" name="startTime" placeholder="Start Time" value=""/> 
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-time"></span>
                          </span>
                      </div>
                      <div class="input-group date dateTime-input" id="datetimepicker2">
                          <input type="text" class="form-control form-control-sm clearDefault mr-2" style="max-width: 150px" name="endTime" placeholder="End Time" value=""/> 
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


<!-- ------------------------------- Wanna attend Modals ------------------------------ -->

  <div class="modal" id="wannaAttend" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" style="color: rgba(204,204,204,1)" id="exampleModalLongTitle"><span class="text-gs">Sign Up</span> ... Get Event Location ... Come Hang Out W/ Us</h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

           <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
               <div class="row pl-0">
                <div class="col-md-10 mx-auto text-center">
                  <p class="mb-0" style="font-size:1.3em; color:black;">Attend <span class="text-gs">#</span>popUpWorship</p>
                   
                   <div class="mx-auto mb-2 mt-0 col-md-5 text-center">
                      <img class="featurette-image img-fluid mx-auto" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
                      <!-- <?php echo URL;?>img/gospelscout_logo.png -->
                    </div>
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
          
          <form name="attendEvent" id="attendEvent" method="post">
            <div class="modal-body px-4 pt-0">
                <div class="container p-0 mb-md-2 text-center"> 
                  
                  <div class="row text-center mb-0">
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">First Name <span class="text-danger">*</span></label>
                       <input type="text" class="form-control form-control-sm clearDefault my-0" name="fname" placeholder="First Name" value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="lname" placeholder="Last Name" value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email Address <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="email" placeholder="Email Address" value=""/>
                    </div>
                    <div class="col-md-10 mx-auto text-left">
                       <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Phone Number</label>
                      <input type="text" class="form-control form-control-sm clearDefault my-0" name="phone" placeholder="Phone Number" value=""/>
                    </div>
                  </div>

                  <!-- Hidden Inputs -->
                    <input type="hidden" name="eventID" value="">

                  <div class="row text-center mt-3">
                    <div class="col-5 mx-auto">
                      <button type="submit" id="btn_attendEvent" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Submit</button>
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

<!-- ------------------------------- /Wanna attend Modals ------------------------------ -->

<!-- ------------------------------- Successful Donation Modals ------------------------------ -->
  <div class="modal" id="donation_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
             <div class="row pl-0">
              <div class="col-md-10 mx-auto text-center">
                 <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
                <p style="font-size:1.3em;" class="text-gs font-weight-bold">Thank You For Your Donation!!!</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-10 mx-auto text-left">
                    <p class="text-black" style="font-size: .8em;"><span class="don_name"></span>, we thank you for taking the time to donate.  We understand you work hard for your money and we really appreciate your contribution.  Your donation will go a long way in helping us to continue providing amazing events and supporting your local talent. </p> <!-- <span class="text-gs font-weight-bold">LA</span> --> 
                  </div>
                </div>

                <div class="row">
                  <div class="col col-md-10 mx-auto" style="font-size: .8em;">
                  
                  <table class="text-left">
                    <tr>
                      <th>Donation:</th>
                      <td class="pl-2" id="don_amount"></td>
                    </tr>
                    <tr>
                      <th>View Receipt:</th>
                      <td class="pl-2"><a id="don_receipt" href="" class="text-gs" target="_blank">Veiw Receipt</a></td>
                    </tr>
                    <tr>
                      <th>Receipt emailed to:</th>
                      <td class="pl-2" id="don_email"></td>
                    </tr>
                    <tr>
                      <th>Date:</th>
                      <td class="pl-2" id="don_date"></td>
                    </tr>

                  </table>
                </div>    
              </div>



              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ------------------------------- /Successful Donation Modals ------------------------------ -->

<!-- ------------------------------- failed Donation Modals ------------------------------ -->
  <div class="modal" id="donation_failure" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
             <div class="row pl-0">
              <div class="col-md-10 mx-auto text-center">
                 <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
                <p style="font-size:1.3em;" class="text-gs font-weight-bold">Oh No, Something went wrong!!!</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-10 mx-auto text-left">
                    <p class="text-black" style="font-size: .8em;"><span class="don_name"></span>, please see below for Details. If you continue to have issues, please <a class="text-gs" target="_blank" href="<?php echo URL;?>views/contactUs.php">Contact Us</a>.</p> <!-- <span class="text-gs font-weight-bold">LA</span> --> 
                  </div>
                </div>

                <div class="row">
                  <div class="col col-md-10 mx-auto" style="font-size: .8em;">
                  
                  <table class="text-left">
                    <tr>
                      <th>Charge Status:</th>
                      <td class="pl-2" id="don_chargeStatus"></td>
                    </tr>
                    <tr>
                      <th>Reason:</th>
                      <td class="pl-2"><a id="don_reason"></td>
                    </tr>
                   <!--  <tr>
                      <th>Receipt emailed to:</th>
                      <td class="pl-2" id="don_email"></td>
                    </tr>
                    <tr>
                      <th>Date:</th>
                      <td class="pl-2" id="don_date"></td>
                    </tr> -->

                  </table>
                </div>    
              </div>



              
              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ------------------------------- /failed Donation Modals ------------------------------ -->


<!-- ------------------------------- Volunteer Added Modals ------------------------------ -->
  <div class="modal" id="volunteer_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <span id="loadlogin"></span> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="container pt-2 pb-0 mb-0" style="background-color: rgb(233,234,237);">
             <div class="row pl-0">
              <div class="col-md-10 mx-auto text-center">
                 <img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="<?php echo URL;?>img/gospelscout_logo.png" width="50" height="50" data-src="" alt="Generic placeholder image">
                <p style="font-size:1.3em;" class="text-gs font-weight-bold">Thank You!!!</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-10 mx-auto text-left">
                    <p class="text-gs font-weight-bold vol_mess" style="font-size: 1em;"></p> <!-- <span class="text-gs font-weight-bold">LA</span> <span class="vol_name"></span>--> 
                  </div>
                </div>

                <div class="row">
                  <div class="col col-md-10 mx-auto" style="font-size: .8em;">
                  
                  </div>    
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px"></div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ------------------------------- /Volunteer Added Modals ------------------------------ -->





