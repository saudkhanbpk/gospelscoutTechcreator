
<?php 
  /* Require the Header */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
  /* Create DB connection to Query Database for Artist info */
    // include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

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
    // echo '<script>window.location = "'. URL .'index.php";</script>';
    // exit;
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
            <svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><!-- Generator: Sketch 43.2 (39069) - http://www.bohemiancoding.com/sketch --><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="non_viewable" transform="translate(0.000000, 2.000000)"><path d="M0,6 C0,6 3.58,11 8,11 C12.42,11 16,6 16,6 C16,6 12.42,1 8,1 C3.58,1 0,6 0,6 L0,6 Z M14.01,6 C10.08,10.56 5.97,10.63 1.99,6 C3.3,4.48 4.68,3.49 6.06,3 C5.41,3.55 5,4.35 5,5.25 C5,6.91 6.4,8.25 8.12,8.25 C9.85,8.25 11.25,6.91 11.25,5.25 C11.25,4.37 10.86,3.58 10.24,3.04 C11.49,3.54 12.73,4.51 14.01,6 L14.01,6 Z M6.85,5.25 C6.85,4.58 7.42,4.03 8.12,4.03 C8.83,4.03 9.4,4.58 9.4,5.25 C9.4,5.92 8.83,6.47 8.12,6.47 C7.42,6.47 6.85,5.92 6.85,5.25 L6.85,5.25 Z" id="Shape-Copy-2" fill-opacity="0.3" fill="#000000"></path><path d="M14,0 L2,12" id="Line" stroke="#A9A9A9" stroke-width="2" stroke-linecap="square"></path></g></g></svg>
            <svg width="16px" height="10px" viewBox="0 0 16 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><!-- Generator: Sketch 43.2 (39069) - http://www.bohemiancoding.com/sketch --><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><path d="M0,5 C0,5 3.58,10 8,10 C12.42,10 16,5 16,5 C16,5 12.42,0 8,0 C3.58,0 0,5 0,5 L0,5 Z M14.01,5 C10.08,9.56 5.97,9.63 1.99,5 C3.3,3.48 4.68,2.49 6.06,2 C5.41,2.55 5,3.35 5,4.25 C5,5.91 6.4,7.25 8.12,7.25 C9.85,7.25 11.25,5.91 11.25,4.25 C11.25,3.37 10.86,2.58 10.24,2.04 C11.49,2.54 12.73,3.51 14.01,5 L14.01,5 Z M6.85,4.25 C6.85,3.58 7.42,3.03 8.12,3.03 C8.83,3.03 9.4,3.58 9.4,4.25 C9.4,4.92 8.83,5.47 8.12,5.47 C7.42,5.47 6.85,4.92 6.85,4.25 L6.85,4.25 Z" id="viewable" fill="#000000"></path></g></svg>
          </div>
        </div>
      </div>
  <?php var_dump($currentUserID);?>
      <div class="accordion" id="accordionExample">
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
                    <li class="nav-item">
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
                    </li>
                    <li class="nav-item">
                      <a class="nav-link getArtistGigs" id="bid" href="#">Bids <span class="badge badge-pill badge-primary" id="bidCount">0</span></a>
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
    <script src="<?php echo URL;?>gigmanager/js/indexJSFunctions.js?5"></script>
    <script src="<?php echo URL;?>gigmanager/js/indexJS.js?7"></script>
  </body>
</html>
