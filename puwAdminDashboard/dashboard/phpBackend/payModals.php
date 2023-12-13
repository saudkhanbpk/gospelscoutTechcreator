<!-- ----------------------------------  Transfer Confirmation Modal  ---------------------------------- -->
   <div class="modal" id="conf_transfer_reversal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
              <div class="col-md-10 mx-auto py-3 text-center">
                <p class="font-weight-bold" id="post_trans_conf_title"></p>
                <table class="mx-auto" style="font-size:1em">
                  <tbody>
                    <tr>
                      <th>Login Id:</th>
                      <td id="rev_iLoginid"></td>
                    </tr>
                    <tr>
                      <th>Artist Name:</th>
                      <td id="rev_name"></td>
                    </tr>
                    <tr>
                      <th>Talent:</th>
                      <td id="rev_talent"></td>
                    </tr>
                    <tr>
                      <th>Amount:</th>
                      <td id="rev_amount"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="checkbox container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-5 py-3 mx-auto text-center" id="post_trans_conf_button">
                   <button id="trans_reversal_button" type="button" class="btn btn-sm btn-gs px-5 transfer_action">Confirm</button>';
                  </div>

                  <div class="col col-md-5 py-3 mx-auto text-center">
                    <button type="button" class="btn btn-sm btn-primary px-5" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>    
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                  <!-- <button type="button" class="btn btn-sm btn-gs" data-dismiss="modal" aria-label="Close">Close</button> -->
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ----------------------------------  /Transfer Confirmation Modal  ---------------------------------- -->


<!-- ----------------------------------  Transfer Success Modal  ---------------------------------- -->
   <div class="modal" id="transfer_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
              <div class="col-md-10 mx-auto py-3 text-center">
                <p class="font-weight-bold">Admin Action</p>
              </div>
            </div>
          </div>
          
            <div class="modal-body text-center p-0" >
              <div class="container py-md-4 m-0"> 
                
                <div class="row">
                  <div class="col col-md-5 py-3 mx-auto text-center" id="trans_succ_mess"></div> 
                </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4 " style="font-size:13px">
                  <button type="button" class="btn btn-sm btn-gs" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
              <!-- /Modal Footer -->
            </div>
              
        </div>
      </div>
    </div>
  </div>

<!-- ----------------------------------  /Transfer Success Confirmation Modal  ---------------------------------- -->

