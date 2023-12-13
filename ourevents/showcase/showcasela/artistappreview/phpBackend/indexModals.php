<!-- ------------------------------- View Artist Modals ------------------------------ -->
<div class="modal" id="viewArtist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <p style="font-size:1.3em;" class="text-gs font-weight-bold">Artist Submission</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-10 mx-auto text-left" id="artistInfoContainer">
                    
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