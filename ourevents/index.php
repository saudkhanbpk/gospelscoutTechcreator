<?php 
      require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/home/include/header.php');

     /* PopUpWorship Cities  - pdo function was used from gsfunctions.php page */
        $table = 'puwcitymaster';
        $emptyArray = array();
        $puwCities = pdoQuery($table,'all',$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

      /* Get States */
        $paramArray['country_id']['='] = 231;  
        $getStates = pdoQuery('states','all',$paramArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
?>

 <!-- Dropzone.js file upload plugin -->
    <link href="<?php echo URL; ?>node_modules/dropzone/dist/dropzone.css" rel="stylesheet">
    <script src="<?php echo URL;?>node_modules/dropzone/dist/dropzone.js"></script>

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

      <!--  Add style sheet -->
      <link href="<?php echo URL; ?>artist/css/indexCss.css" rel="stylesheet">
      <link href="<?php echo URL; ?>ourevents/css/indexCss.css?3" rel="stylesheet">

      <div class="container-fluid bg-gs mt-0 py-0 text-center text-white" style="width:100%">
        <div class="row" id="layer2">
          <div class="col-12  py-5" id="layer3">
            
            <div class="container py-3">
              <div class="row">
                <div class="col-12 col-md-10 pt-3  mx-auto">

                  <h2 class="text-center"><span class="text-gs"></span>GospelScout Events</h2>
                  <!--<p style="font-size:.8em;color:rgba(255,255,255,.5)">Immerse yourself in an engaging spiritual environment surrounded by amazing talent and fellow worshipers</p>-->

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    <main role="main">

      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->
 

      <div class="container marketing pt-3 pt-md-5" id="signupSect">
        <div class="container text-center mb-5" style="color:black;">
          <h1 class="text-bold">Get Involved!!!</h1>
        </div>
        <!-- Sign up Section -->
        <div class="row">
          <div class="col-lg-4 mt-md-0"> <!-- rounded-circle -->
            <h2 style="font-weight:bold">Perform</h2>
            <p>Are you an artist looking to develop your skills, get more exposure to your local community, and/or be a part of an awesome and unique worship experience?  Apply to perform!!!</p>
            <p><a class="btn btn-gs" id="perform" href="" role="button">Perform &raquo;</a></p> <!-- <?php echo URL;?>views/artist.php -->
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4 mt-3 mt-md-0">
            <h2 style="font-weight:bold">Host</h2>
            <p>Do you have an awsome unique space that you are willing to share? Apply to be a host and let us use your space to create a transformative and engaging spiritual environment coupled with amazing artistry and talent. </p>
            <p><a class="btn btn-gs" id="host" href="#" role="button">Host &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4 mt-3 mt-md-0">
            <h2 style="font-weight:bold">Attend</h2>
            <p><span class="text-gs">1.</span> Choose a date <span class="text-gs">2.</span> Sign up <span class="text-gs">3.</span> Get event Location <span class="text-gs">4.</span> Come hang out w/ us</p>
            <p><a class="btn btn-gs" id="attend" href="#upcomingDates" role="button">Attend &raquo;</a></p>
          </div><!-- /.col-lg-4 -->

           <div class="col-lg-4 mt-3 mt-md-0">
            <h2 style="font-weight:bold">Volunteer</h2>
            <p>We are always looking for amazing and talented people like yourself to become a part of our family.  Help scout locations, setup/breakdown events, and make new friends.  Get involved today, sign up. </p>
            <p><a class="btn btn-gs" id="vol" href="#vol_donate" role="button">Volunteer &raquo;</a></p>
          </div><!-- /.col-lg-4 -->

           <div class="col-lg-4 mt-3 mt-md-0">
            <h2 style="font-weight:bold">Donate</h2>
            <p>By donating, you help us keep our cost low so that we may continue to support local artists and keep bringing you amazing events.</p>
            <p><a class="btn btn-gs" id="don" href="#vol_donate" role="button">Donate &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider my-5" id="upcomingDates">

 <!-- <div class="spinner-border text-gs" id="payment-spinner" role="status">
                      <span class="sr-only">Loading...</span>
                    </div> -->
       <!--  <button class="btn btn-primary" type="button" disabled>
          <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
          Loading...
        </button> -->

        <div class="row featurette">
          <!-- <div class="col-10 mx-auto mx-md-0 text-center text-md-left"></div> -->
          <div class="col-md-7">
            <h1 style="color: rgba(204,204,204,1)" class="text-center text-md-left">Upcoming Dates</h1>

            <!-- No Events Available -->
              <!-- <div class="d-none" id="eventsFalse"> -->
                <!-- <h2 class="featurette-heading">No Dates At This Time <span class="text-muted">It'll blow your mind.</span></h2> -->
               <!--  <p class="lead">Sorry, there are no scheduled dates <span class="text-gs">@</span> this time...</p>
              </div> -->
            <!-- /No Events Available -->

            <!-- Events Available -->
              <div class="container d-none" id="eventsTrue"></div>
              <!--<div class="container"  id="event-container">
                <div class="row">
                  <div class="col m-2" id="ad-placement" style="min-height:500px;">
                    <a id="btn_findArtists3" target="_blank" href="https://www.eventbrite.com/e/gospelbrunchla-the-best-live-music-brunch-in-la-tickets-594842990397" class="btn btn-lg btn-gs btn-block text-uppercase carousel-btn" type="button">Get Info</a> 
                  </div>
                </div>
              </div>-->
            <!-- /Events Available -->
            
            <!-- 
                **** When this portion of the site becomes much more active, we will implement zip code functionality ****
                
                <div class="col-10 text-center text-md-left">
                  <h1 style="color: rgba(204,204,204,1)">Find Dates Near You</h1>
                  <p class="lead">Enter Your Zip code</p>
                </div>
                
                <div class="container">
                  <div class="row">
                    <div class="col col-md-5">
                       <form name="findEvents" method="post" action="" enctype="multipart/form-data" autocomplete="off">
                        <input type="text" class="form-control form-control-sm my-0" name="eventZip" placeholder="5 digit zip code" value="">
                        <button class="btn-sm btn-block bg-gs text-white mt-2" style="max-width: 100px">Search</button> 
                      </form>
                    </div>
                  </div>
               </div> 
           -->

          </div>
          <div class="d-none d-md-block col-md-5 text-center">
            <img class="featurette-image img-fluid mx-auto" src="<?php echo URL;?>img/gospelscout_logo.png" width="160" height="160" data-src="" alt="Generic placeholder image">
            <!-- <?php echo URL;?>img/gospelscout_logo.png -->
          </div>
        </div>

        <hr class="featurette-divider my-5"  id="vol_donate">

         <div class="row featurette mt-0">
          <!-- <div class="col-10 mx-auto mx-md-0 text-center text-md-left"></div> -->
          <div class="col-md-12">
            <h1 style="color: rgba(204,204,204,1)" class="text-center text-md-right" id="upcomingDates">Volunteer/Donate</h1>

           <div class="container mt-4 text-center text-md-center">
              
              <div class="row">
              	<!-- Volunteer Form -->
	                <div class="col-12 col-md-5 card-shadow py-2">
	                  <h5 class="text-gs">Volunteer</h5>
	                  
	                  <div class="container">
	                    <div class="row">
	                      <div class="col">
	
	                        <form action="#" method="post" name="volunteer_form" id="volunteer-form">
	                          <div class="container p-0 mb-md-2 text-center"> 
	                            <div class="row text-center mb-0">
	                              <div class="col-md-10 mx-auto text-left">
	                                 <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">First Name <span class="text-danger">*</span></label>
	                                 <input type="text" class="form-control form-control-sm clearDefault my-0" name="vol_fname" placeholder="First Name" value=""/>
	                              </div>
	                              <div class="col-md-10 mx-auto text-left">
	                                 <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Last Name <span class="text-danger">*</span></label>
	                                <input type="text" class="form-control form-control-sm clearDefault my-0" name="vol_lname" placeholder="Last Name" value=""/>
	                              </div>
	                              <div class="col-md-10 mx-auto text-left">
	                                 <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email Address <span class="text-danger">*</span></label>
	                                <input type="text" class="form-control form-control-sm clearDefault my-0" name="vol_email" placeholder="Email Address" value=""/>
	                              </div>
	                              <div class="col-md-10 mx-auto text-left">
	                                <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Phone Number <span class="text-danger">*</span></label>
	                                <input type="text" class="form-control form-control-sm clearDefault my-0" name="vol_phone" placeholder="Phone Number" value=""/>
	                              </div>
	                              <div class="col-md-10 mx-auto text-left">
	                                <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">State <span class="text-danger">*</span></label>
	                                 <select class="custom-select clearDefault my-0" name="vol_state1" id="vol_state" style="height: 32px;font-size: 14px;font-color:rgba(0,0,0,.01);">
	                                    <option value="">States</option>
	                                    <?php foreach($getStates as $state){
	                                      echo '<option value="'. $state['id'] .'">'. $state['name'] .'</option>';
	                                    }?>
	                                 </select>
	                              </div>
	                              <div class="col-md-10 mx-auto text-left">
	                                 <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zip Code <span class="text-danger">*</span></label>
	                                <input type="text" class="form-control form-control-sm clearDefault my-0" name="vol_zip" id="vol_zip" placeholder="5 Digit Zip Code" value=""/>
	                              </div>
	                            </div>
				 
	                            <div class="row text-center mt-3">
	                              <div class="col-5 mx-auto">
	                                <button type="submit" id="volunteer_btn" class="btn btn-block bg-gs text-white p-2" tabindex="3" style="font-size:13px">Sign Up</button>
	                              </div>
	                            </div>
	                          </div>
	                        </form>
	
	                      </div>
	                    </div>
	                  </div>
	
	                </div>
		<!-- /Volunteer Form -->
		
                <div class="col-12 col-md-2 mt-2 mt-md-0">
                  <h5 style="color: rgba(204,204,204,1)">-OR-</h5>
                </div>                

                <!-- Donate Forma -->
                  <div class="col-12 col-md-5 card-shadow py-2" >
                    <h5 class="text-gs">Donate</h5>

                    <div class="container" id="donate-form">
                      <div class="row">
                        <div class="col">

                          <form action="" method="post" name="payment_form" id="payment-form">
                            <div class="container p-0 mb-md-2 text-center"> 
                              
                              <div class="" id="display-payment-form">
                                <div class="row text-center mb-0">
                                  <div class="col-md-10 mx-auto text-left">
                                     <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">First Name <span class="text-danger">*</span></label>
                                     <input type="text" class="form-control form-control-sm clearDefault my-0" name="donor_fname" placeholder="First Name" value=""/>
                                  </div>
                                  <div class="col-md-10 mx-auto text-left">
                                     <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm clearDefault my-0" name="donor_lname" placeholder="Last Name" value=""/>
                                  </div>
                                  <div class="col-md-10 mx-auto text-left">
                                     <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm clearDefault my-0" name="donor_email" placeholder="Email Address" value=""/>
                                  </div>
                                  <div class="col-md-10 mx-auto text-left">
                                     <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Phone Number </label>
                                    <input type="text" class="form-control form-control-sm clearDefault my-0" name="donor_phone" placeholder="Phone Number" value=""/>
                                  </div>
                                  <div class="col-md-10 mx-auto text-left">
                                     <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm clearDefault my-0" name="donor_amount" placeholder="$0.00" value=""/>
                                  </div>
                                </div>

                                <div class="row mb-1 text-center mt-3">
                                    <div class="col ">
                                         <h6>Payment Info</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p style="font-size:12px">Enter card info here.  It is securely collected, transmitted, and processed using our stripe api interface.  <span class="font-weight-bold">We do not store any of this information on GospelScout Servers.</span></p>
                                    </div>
                                </div>

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
                              </div>


                              <!-- <div id="load-payment-form"></div> -->

                              <div class="row text-center mt-3">
                                <div class="col-5 mx-auto">
                                  <button type="submit" class="btn btn-block btn-gs text-white p-2" id="donate_btn" tabindex="3" style="font-size:13px" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                  </button>
                                </div>
                              </div>

                              <hr class="featurette-divider my-3">

                              <div class="row p-0" id="postDisplay-sm"> 
                                  <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
                                  <img class="" src="<?php echo URL;?>img/stripeLogo.png" height="30px" width="50px">
                              </div>
                            </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>

                  </div>
                <!-- /Donate Forma -->


              </div>

              
              <!-- <div class="row"> -->
               
              <!-- </div> -->

           </div> 

          </div>
        </div>
        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->

      <!-- Include the Modals page -->
        <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/ourevents/phpBackend/indexModals.php'); ?>


      <!-- FOOTER -->
      <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>

    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
      var user_id = '<?php echo $currentUserID;?>';
      var user_type = '<?php echo $currentUserType;?>';
    </script>
    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>
    <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
    <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
    
    <!--<script src="<?php echo URL;?>node_modules/fine-uploader/fine-uploader/fine-uploader.min.js.map"></script>-->
    <!--<script src="<?php echo URL;?>js/jsFunctions.js?3"></script>-->
    <script src="https://js.stripe.com/v3/"></script>
    <script src="<?php echo URL;?>ourevents/js/indexJS.js?55"></script>
  </body>
</html>

   