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
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Post A Gig Ad</h5>
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
                            <div class="carousel-item bg-white active" style="max-height:125px;overflow:hidden;overflow:scroll">
                                <div class="container">
                                     <div class="row mb-1">
                                        <div class="col text-center">
                                            <h5>How it Works</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <ol>
                                                <li>Create & Publish your gig ad for only $1.00.</li>
                                                <li>We will reach out to artists that meet your post's criteria.</li>
                                                <li>Kick back and wait for talented & qualified artist's inquiries to start rolling in!</li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item mt-0 pt-1 bg-white" style="max-height:225px">
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
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12" id="token_err_div"></div>
                                    </div> 
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
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Submit Gig Ad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                            	<div class="m-0 p-0 text-center" id="replace_usage">
                                    <h4>Post gig for $1.00</h4>
                                     <p class="text-gs font-weight-bold mt-3">Click below to post gig</p>
			                    </div>
		                       
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs sendPost" id="submitInquiry" data-dismiss="modal" aria-label="Close">Post Gig</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm a bid on a gig -->


<!-- Modal to gig manager that removing talent will remove selected artist -->
    <div class="modal fade" id="art_rem_warn" tabindex="-1" role="dialog" aria-labelledby="art_rem_warn" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-warning font-weight-bold" id="exampleModalLongTitle">Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                                <p> Removing this talent when update is clicked, will also remove the selected artist.  Simply, refresh the page if this is not the intended action.</p>
                            </div>
                        </div>
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
<!-- /Modal to gig manager that removeing talent will remove selected artist -->




