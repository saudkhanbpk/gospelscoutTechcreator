<!-- Modal to display artists on small screen -->
<div class="d-md-none modal" id="show-artist-sm" tabindex="-1" role="dialog" aria-labelledby="show-artist-sm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
               <a class="artistProfile" href="#" target="_blank" style="text-decoration: none; ">
                    <img class="aProfPic profPic" src="" height="50px" width="50px">
                    <h4 class="d-inline-block text-gs fullName ml-1"></h4>
                </a>
              <span id="loadlogin"></span> 
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body px-4" id="showArtist-sm">
                <table class="table table-borderless" id="showArtDeet" style="font-size:12px">
                    <tbody>
                        <tr>
                            <th scope="row" id="subOrReq">Submitted: </th>
                            <td class="submissionDateTime"></td>
                        </tr>
                        <tr>
                            <th scope="row">Playing Status: </th>
                            <td class="playStatus"></td>
                        </tr>
                        <tr>
                            <th scope="row">Location: </th>
                            <td class="location"></td>
                        </tr>
                        <tr>
                            <th scope="row">Age: </th>
                            <td class="age"></td>
                        </tr>
                        <tr>
                            <th scope="row">Talent(s): </th>
                            <td class="tals">
                                <!-- <table class="table table-borderless showTals">
                                    <tbody class="tals"></tbody>
                                </table> -->
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Email: </th>
                            <td class="email"></td>
                        </tr>
                         <tr>
                            <th scope="row">Phone #: </th>
                            <td class="phone"></td>
                        </tr>
                         <tr>
                            <th scope="row">Comments: </th>
                            <td class="comments"></td>
                        </tr>
                    </tbody>
                </table>

                <?php if($gDate >= $today){?>
                    <div class="infoDisplay" id="sm-screen-modal-display"></div>
                    <!--
                    <div class="manAction">
                         <button type="button" class="btn btn-sm btn-gs sendID" manID="<?php echo $currentUserID;?>" artistID=""  id="selectArtist" >Select This Artist</button>
                    </div>
                    <div class="d-none manAction2">
                        <h4 class="font-weight-bold text-gs">Artist Selected</h4>
                        <button type="button" class="btn btn-sm btn-gs sendID" manID="<?php echo $currentUserID;?>" artistID="" id="deSelectArtist" data-toggle="modal" data-target="#loseArtist">De-Select This Artist</button>
                    </div> -->
                <?php }?>
            </div>

              <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px">
                  <div class="checkbox container p-0" id="postDisplay-sm"> 
                   
                  </div>
                </div>
                <!-- /Modal Footer -->
           </div>
        </div>
    </div>
<!-- /Modal to display artists on small screen -->