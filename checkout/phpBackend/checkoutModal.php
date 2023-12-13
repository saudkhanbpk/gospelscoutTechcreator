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
                

            <!-- Modal Body -->
                <div class="modal-body mt-0" style="height:auto; padding-bottom:25px">   <!--style="height: 450px"-->
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
                            <div class="carousel-item mt-0 pt-1" style="max-height:300"><!-- 225px-->
                                <div class="container mt-0">
                                    <div class="row mb-1">
                                        <div class="col text-center">
                                             <h5>Payment Info</h5>
                                        </div>
                                    </div>
									                  <div class="row text-center my-0 py-0">
                                        <div class="col my-0 py-0">
                                            <p class="my-0 py-0" style="font-size:15px; font-weight:bold">$1.00</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="my-0 py-0" style="font-size:12px">Your card info is securely transmitted using our stripe api interface.</p><!--<span class="font-weight-bold">Once you enter your card info the first time you don't have to enter it again.</span>-->
                                        </div>
                                    </div>
                                    <!-- <div class="container bg-warning" > -->
                                        <div class="row" id="show-payment-methods bg-warning"></div>
                                        <div class="row">
                                            <div class="col-12 pb-0" style="font-size:12px;">
                                                <form id="payment-form" style="overflow:scroll"><!-- height:325px background:blue; -->
                                                    <div class="container mb-0 pb-0" style="min-height:250px" >
                                                        <div class="row mb-0  pb-0">
                                                            <div class="col mb-0 pb-0" id="payment-element" style="min-height: 175px"><!-- Mount the Payment Element here --></div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="container my-0" >
                                                    <div class="row my-0">
                                                        <div class="col text-center my-0 py-2" id="submitContainer"><button class="btn btn-sm btn-gs mt-0" id="submit" disabled>Submit</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-danger text-center" id="error-div"></div>
                                    <!-- </div> -->
                                    
                                </div> 
                                
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12" id="token_err_div"></div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                   
                </div>
                
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px">
                    <div class="checkbox container p-0" id="postDisplay-sm"> 
                        <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
                        <img class="" src="<?php echo URL;?>img/stripeLogo.png" height="30px" width="50px">
                    </div>
                     <div class="container">
                        <div class="row">
                            <div class="col text-center mt-2">
                                <a href="#" class="slide1 text-gs font-weight-bold">Enter Card Info -></a>
                                <a href="#" class="slide2 text-gs font-weight-bold  d-none"><- How it Works</a>
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
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal introduce the payment modal and collect payment information -->
