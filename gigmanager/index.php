<?php 
 /* Require the Header */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
 
  /*
    1. query the notification master for rows where the notifiedID match the currentUserID and and the viewed status is 0
    2. When suggested gigs is clicked, query the the postedgigsmaster for rows where the criteria matches that consistent with the current user's profile
        query for the following: 
          a. gig pay - minimum pay artist will accept
          b. artist type - artist's talents
          c. age minimum - artist's age
          d. years of experience minimum - artist's years of experience
          e. location(state, city, zip) - artist's location
    3. When Gig Inquiries is click query giginquirymaster for all inquiries to gigs current artist has posted
    4. When Gig Submissions is clicked query gigsubmissionsmaster to retrieve all gigs that current artist has submitted for 
  */

  if($currentUserID != ''){
    /* Query the eventsartist table for entries pertaining to the current user */
    $emptyArray = array();
      $today = date_create();
      $columnsArray = array('eventartists.*');
      $paramArray['iLoginid']['='] = $currentUserID;
      $paramArray['artiststatus']['='] = 'pending';
      $$paramArray['eventdate']['>'] = $today;
      $orderByParam = 'eventdate';
      $getPendingGigs = pdoQuery('eventartists',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
      
      foreach($getPendingGigs as $pendingGigIndex => $pendingGigValue){  
        $pendingGigByTable[ $pendingGigValue['eventtable'] ][] = $pendingGigValue;
      }
  }
  else{
    echo '<script>window.location = "'. URL .'index.php";</script>';
    exit;
  }
?>
  <!--<head>-->
    <style>
      .active,.nav-link:hover {
        background-color: rgba(149,0,173,1);
      }        
    </style>
  <!--</head>-->
 
  <!--<body class="bg-light">-->
    <main role="main" class="container" style="margin-top:100px; min-height:600px;">

      <div class="container text-center text-md-left mt-3">
        <div class="row">
          <div class="col">
            <h2 class="text-gs">Gig Manager</h2>
          </div>
        </div>
      </div>
  
      <div class="accordion" id="accordionExample">
        <?php if( $currentUserType == 'artist'){?>
          <div class="card" style="font-size:.8em;">
            <div class="card-header" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="collapse1">
                  View Your Gigs
                </button>
              </h2>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
              <!-- Card header -->
                  <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                      <!--<li class="nav-item">
                        <a class="nav-link active getArtistGigs" id="pending" href="#">Pending <span class="badge badge-pill badge-primary" id="pendingCount">0</span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link getArtistGigs" id="confirmed" href="#">Confirmed <span class="badge badge-pill badge-primary" id="confirmedCount">0</span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link getArtistGigs" id="declined" href="#">Declined <span class="badge badge-pill badge-primary" id="declinedCount">0</span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link getArtistGigs" id="canceled" href="#">Canceled <span class="badge badge-pill badge-primary" id="canceledCount">0</span></a>
                      </li>-->
                      <li class="nav-item">
                        <a class="nav-link getArtistGigs" id="bid" href="#">Bids <span class="badge badge-pill badge-primary" id="bidCount">0</span></a>
                      </li>
					   <li class="nav-item">
                        <a class="nav-link getArtistGigs" id="requested" href="#">Requests <span class="badge badge-pill badge-primary" id="declinedCount">0</span></a>
                      </li>
                    </ul>
                  </div>
                <!-- /Card header -->
                
                  <!-- User's gig content  -->
                    <div class=" container my-3 py-3 px-0 bg-white rounded box-shadow" id="infoDisplay" style="min-height:150px;"></div>
                <!-- /Card Contents -->
              </div>
            </div>
          </div>
        <?php }?>

        <!-- managed gigs -->
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="collapse2">
                Create/Manage Gig Ads
              </button>
            </h2>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <!-- Card to display Upcoming or expired gigs -->
                  <div class="container my-0 px-0" id="infoDisplay1">
                    
                    <div class="row py-2 mx-0 px-0">
                      <div class="col-10 mx-0 px-0">
                        <p class="my-2 mx-0 font-weight-bold" style="width:100%;">Click here to create a new gig ad</p>
                        <a type="button" target="_blank" href="<?php echo URL;?>publicgigads/" class="btn btn-sm btn-gs">Create & Post a new Gig Ad</a>
                      </div>
                    </div>

                    <hr class="featurette-divider mb-3 mt-1">

                    <div class="row my-0 mx-0 px-0">
                      <div class="col-12 mx-0 my-0 px-0">
                        <p class="my-2 font-weight-bold">Current Gig Ads</p>
                        <div class="card text-center mx-0 px-0" style="font-size:.8em;">
                          <!-- Card header -->
                            <div class="card-header">
                              <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                  <a class="nav-link active" id="showUpcoming" href="#">Upcoming <span class="badge badge-pill badge-primary" id="upcCount">0</span></a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="showExpired" href="#">Expired <span class="badge badge-pill badge-primary" id="expiredCount">0</span></a>
                                </li>
                              </ul>
                            </div>
                          <!-- /Card header -->

                          <!-- Card body -->
                            <div class="card-body px-0 mx-0">
                              <div class="container px-0 mx-0">
                                <div class="row px-0 mx-0">
                                  <div class="col px-0 mx-0">
                                    <div class="container mx-0 px-0" id="show_gigAds"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <!-- /Card body -->
                        </div>

                      </div>
                    </div>

                  </div>
                <!-- /Card to display Upcoming or expired gigs -->

            </div>
          </div>
        </div>
        
      </div>

      <!-- Include the Modals page -->
        <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/gigmanager/phpBackend/indexModals.php'); ?>

<!-- ------------------------------------------------------------------------- -->
      
    </main>

    <?php 
      /* Include the footer */ 
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
    ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
  <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
  <script src="<?php echo URL;?>js/jquery.validate.js"></script>
  <script src="<?php echo URL;?>js/additional-methods.js"></script> 

    <script src="<?php echo URL;?>js/offcanvas.js"></script>
    <script src="<?php echo URL;?>gigmanager/js/indexJSFunctions.js?35"></script>
    <script src="<?php echo URL;?>gigmanager/js/indexJS.js?12"></script>
  </body>
</html>
