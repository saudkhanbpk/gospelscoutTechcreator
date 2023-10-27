<!-- Modal to confirm the selection of an artist -->
    <div class="modal fade" id="chooseArtist" tabindex="-1" role="dialog" aria-labelledby="chooseArtist" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Artist</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <p id="modalMessage"></p>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs selectArtist" replaceArtist="false" artistID="" manID="" id="selectThisArtist" sel-u-id="" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm the selection of an artist -->

<!-- Modal to confirm the DE-selection of an artist -->
    <div class="modal fade" id="loseArtist" tabindex="-1" role="dialog" aria-labelledby="loseArtist" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">De-Select Artist</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vidTalent">Reason For De-selecting artist</label>
                        <textarea class="form-control mb-2" name="cancelreason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                        <input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
                        <input type="hidden" name="gigDetails_gigStatus" value="cancelled">
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs selectArtist"  artistID="" manID="" id="deselectThisArtist" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm the DE-selection of an artist -->

<!-- Modal to prompt gig manager to deselect artist 1st -->
    <div class="modal fade" id="deselect-artist-1st" tabindex="-1" role="dialog" aria-labelledby="loseArtist" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">De-Select this Artist First</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <p><span class="text-gs font-weight-bold">OOPS!</span>  Looks like this artist is currently selected to play this gig.  You must de-select this artist first before selecting them to fill a different talent.</p>
                        
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to prompt gig manager to deselect artist 1st -->

<!-- Modal introduce the payment modal and collect payment information -->
    <div class="modal fade" id="bidToGig" tabindex="-1" role="dialog" aria-labelledby="bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Bid To Gig</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- style the stripe form -->
                <style>
                    /**
                    * The CSS shown here will not be introduced in the Quickstart guide, but shows
                    * how you can use CSS to style your Element's container
                    */
                    .StripeElement {
                        box-sizing: border-box;

                        height: 40px;
                        color: blue;
                        padding: 10px 12px;
                        display: block;
                        border: 1px solid transparent;
                        border-radius: 4px;
                        background-color: white;

                        box-shadow: 2px 1px 3px 2px #d2d7dd;// e6ebf1
                        -webkit-transition: box-shadow 150ms ease;
                        transition: box-shadow 150ms ease;
                    }

                    .StripeElement--focus {
                        box-shadow: 0 1px 3px 0 #cfd7df;
                    }

                    .StripeElement--invalid {
                        border-color: #fa755a;
                    }

                    .StripeElement--webkit-autofill {
                        background-color: #fefde5 !important;
                    }
                    ul {
                        list-style: none;
                    }
                    li {
                        font-size: 12px;
                    }
                </style>

            <!-- Modal Body -->
                <div class="modal-body mt-0">   
                    <!-- Carousel this div with 2 slides: 1. to introduce the pricing model, 2.  to collect card info for tokenization -->
                    <div id="carouselExampleIndicators" class="carousel mb-0"  data-interval="false" style="max-height:350px" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item bg-white active" style="max-height:325px;overflow:hidden;overflow:scroll">
                                <div class="container">
                                     <div class="row mb-1">
                                        <div class="col text-center">
                                            <h5>How it Works!!!</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <h6>Your first <span class="font-weight-bold text-gs">Month</span> of bidding is on us!!!</h6>
                                            <p class="pl-2" style="font-size:12px"> From the date and time that you create your profile, you will have 30 days of free bidding so go nuts!!!  After that, we'll be watching.</p>
                                            <h6>Only pay for what you use!!!</h6>
                                            <p class="pl-2" style="font-size:12px"> You are never charged for having an account with us.  You only pay for what you use.  We track your usage through out the month and add up your total usage at the end of your billing cycle. Keep in mind, the more your bid, the cheaper it is.  Check out our pricing below.</p>
                                            <h6>The more you bid the cheaper it is!!!</h6>
                                            <ul class="pl-2">
                                                <li>1-5 Bids/month: $3.50/bid</li>
                                                <li>6-10 Bids/month: $2.50/bid</li>
                                                <li>11+ Bids/month: $1.00/bid</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item mt-0 pt-1 bg-white" style="max-height:325px">
                                <div class="container mt-0">
                                    <div class="row mb-1">
                                        <div class="col text-center">
                                             <h5>Payment Info</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size:12px">Enter card info here.  Your card info is securely transmitted and stored using our stripe api interface.  <span class="font-weight-bold">Once you enter your card info the first time you don't have to enter it again.</span></p>
                                        </div>
                                    </div>
                                    <form class="" action="<?php echo URL;?>views/xmlhttprequest/stripeApiTest.php" method="post" id="payment-form">
                                        <div class="form-row">
                                            <div class="container pb-1">
                                                <p class="mb-0">Credit or debit card</p>
                                            </div>
                                            <div class="col d-block" id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display Element errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-gs mt-3">Submit</button>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div> 
                    <div class="container">
                        <div class="row">
                            <div class="col text-center mt-2">
                                <a href="#" class="slide1 text-gs font-weight-bold">Enter Card Info -></a>
                                <a href="#" class="slide2 text-gs font-weight-bold  d-none"><- How it Works</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <script>
                    var car = $('.carousel');

                    $('.slide1').click(function(event){
                        event.preventDefault();
                        $('.slide1').addClass('d-none');
                        $('.slide2').removeClass('d-none');
                        car.carousel('next');
                        car.carousel('pause');  

                    });

                    $('.slide2').click(function(event){
                        event.preventDefault();
                        $('.slide2').addClass('d-none');
                        $('.slide1').removeClass('d-none');
                        car.carousel('prev');
                        car.carousel('pause');  
                    });
                </script>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px">
                    <div class="checkbox container p-0" id="postDisplay-sm"> 
                        <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
                        <img class="" src="<?php echo URL;?>img/stripeLogo.png" height="30px" width="50px">
                    </div>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal introduce the payment modal and collect payment information -->

<!-- Modal to confirm a bid on a gig -->
    <div class="modal fade" id="conf_bidToGig" tabindex="-1" role="dialog" aria-labelledby="conf_bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Confirm Your Bid to Play</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body py-0" style="background-color: rgb(233,234,237);">
                    <div class="container text-center my-0">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                                <img class="rounded-circle my-1" src="<?php echo URL; ?>img/PlayingImg.png" alt="Generic placeholder image" width="150" height="150">
                                <!-- <div class="m-0 p-0" id="replace_usage">
                                    <ul style="list-style:disc">
                                        <li>
                                            <p class="my-1">You currently have <span class="text-gs font-weight-bold" id="bid_num"></span> bid(s) this month!!! This will be bid # <span class="text-gs font-weight-bold" id="new_bid_num"></span>, Priced @ $<span id="bid_price"></span>/bid</p>
                                        </li>
                                        <li class="reduce_price d-none my-1">
                                            <p >Make <span id="bids_left"></span> more bids and drop the price of all of your bids to $<span id="bid_pric_new"></span>/bid</p>
                                        </li>
                                    </ul>
                                </div> -->


                                <!-- <p class="text-gs font-weight-bold mt-3">Click below to confirm!!!</p> -->
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <div class="container">
                        <div class="row text-center">
                            <div class="col col-md-12 mx-auto">
                                <button type="button" class="btn btn-gs artistAction d-inline" id="<?php if($user == 'artistWithdrawn'){echo 're-submitInquiry';}else{echo 'submitInquiry';}?>" data-dismiss="modal" aria-label="Close">Confirm</button>
                                <button type="button" class="btn btn-danger d-inline" data-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm a bid on a gig -->

<!-- Modal to display Test gig warning -->
<div class="modal fade" id="testGigOnly" tabindex="-1" role="dialog" aria-labelledby="testGigOnly" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 
            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">This is Only an Example Gig</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->
            <!-- Modal Body -->
                <div class="modal-body py-0" style="background-color: rgb(233,234,237);">
                    <div class="container text-center my-0">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                                <img class="rounded-circle my-1" src="<?php echo URL; ?>img/PlayingImg.png" alt="Generic placeholder image" width="150" height="150">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-gs" style="font-size:14px;"><p style="font-size:.8em;font-weight:bold">You cannot bid on this gig.</p></div>
                    </div>
                </div>
             <!-- /Modal Body -->
            <!-- Modal Footer -->
                <div class="modal-footer">
                    <div class="container">
                        <div class="row text-center">
                            <div class="col col-md-12 mx-auto">
                                <!-- <button type="button" class="btn btn-gs artistAction d-inline" id="<?php if($user == 'artistWithdrawn'){echo 're-submitInquiry';}else{echo 'submitInquiry';}?>" data-dismiss="modal" aria-label="Close">Confirm</button> -->
                                <button type="button" class="btn btn-gs d-inline" data-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to display Test gig warning -->

<!-- Modal to warn an artist before a withdrawal is carried out -->
    <div class="modal fade" id="withdrawalWarning" tabindex="-1" role="dialog" aria-labelledby="withdrawalWarning" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-danger font-weight-bold" id="exampleModalLongTitle">Warning!!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="formReset()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <p class="mt-2 p-0 font-weight-bold text-danger" style="font-size:12px">You are about to withdraw your inquiry submission to this gig!!! Are you sure you want to continue?</p>
                        </div>
                    </div>
                </div>

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vidTalent">Reason For Submission Withdrawal</label>
                        <textarea class="form-control mb-2" name="withdrawalReason" placeholder="Please Explain..." wrap="" rows="4" aria-label="With textarea"></textarea>
                        <input type="hidden" name="gigId" value="<?php echo $_GET['gigID'];?>">
                        <input type="hidden" name="gigDetails_gigStatus" value="cancelled">
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs artistAction" id="removeInquiry" data-dismiss="modal" aria-label="Close">Confirm</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close" onclick="formReset()">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to warn an artist before a withdrawal is carried out -->

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
                            <th scope="row">Submitted: </th>
                            <td class="submissionDateTime"></td>
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
                    <div class="d-none manAction">
                        <!-- selectArtist -->
                         <button type="button" class="btn btn-sm btn-gs sendID" manID="<?php echo $currentUserID;?>" artistID=""  id="selectArtist" >Select This Artist</button> <!--data-toggle="modal" data-target="#chooseArtist" -->
                    </div>
                    <div class="d-none manAction2">
                        <h4 class="font-weight-bold text-gs">Artist Selected</h4>
                        <button type="button" class="btn btn-sm btn-gs sendID" manID="<?php echo $currentUserID;?>" artistID="" id="deSelectArtist" data-toggle="modal" data-target="#loseArtist">De-Select This Artist</button>
                    </div>
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