    <?php 
      require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/headerNew.php');

      /* PopUpWorship Cities  - pdo function was used from gsfunctions.php page */
        $table = 'puwcitymaster';
        $puwCities = pdoQuery($table,'all');

      /* Get States */
        $stateCond = 'country_id = 231';
        $getStates = $obj->fetchRowAll('states',$stateCond);
    ?>
    
    <!-- Dropzone.js file upload plugin -->
    <link href="<?php echo URL; ?>/node_modules/dropzone/dist/dropzone.css" rel="stylesheet">
    <script src="<?php echo URL;?>/node_modules/dropzone/dist/dropzone.js"></script>


    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!--
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
      -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="../img/BusinessCardCollage2.png" alt="First slide"> <!-- data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw== -->
            <div class="container">
              <div class="carousel-caption text-left">
                <h1 class="text-left">#PopUpWorhsip<span class="text-gs">LA</span> IS HERE!!!</h1>
                <p>Immerse yourself in an engaging spiritual environment surrounded by amazing talent and fellow worshipers</p>
                <!--<p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/search4artistNew.php" role="button">Find An Artist</a></p> -->
              </div>
            </div>
          </div>
        </div>
        <!-- 
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
        -->

      </div>

      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->
 

      <div class="container marketing pt-0" id="signupSect">
        <div class="container text-center mb-5" style="color:black;">
          <h1 class="text-bold">Get Involved!!!</h1>
        </div>
        <!-- Sign up Section -->
        <div class="row">
          <div class="col-lg-4"> <!-- rounded-circle -->
            <h2>Wanna Perform?</h2>
            <p>Are you an artist looking to develop your skills, get more exposure to your local community, and/or be a part of an awesome and unique worship experience?  Apply to perform!!!</p>
            <p><a class="btn btn-gs" id="perform" href="" role="button">Perform &raquo;</a></p> <!-- <?php echo URL;?>views/artist.php -->
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <h2>Wanna Host?</h2>
            <p>Do you have an awsome unique space that you are willing to share? Apply to be a host and let us use your space to create a transformative and engaging spiritual environment coupled with amazing artistry and talent. </p>
            <p><a class="btn btn-gs" id="host" href="#" role="button">Host &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <h2>Wanna Attend?</h2>
            <p><span class="text-gs">1.</span> Choose a date <span class="text-gs">2.</span> Apply for tickets <span class="text-gs">3.</span> Get selected to attend <span class="text-gs">4.</span> Confirm Attendence</p>
            <p><a class="btn btn-gs" id="attend" href="#upcomingDates" role="button">Attend &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <!-- <div class="col-10 mx-auto mx-md-0 text-center text-md-left"></div> -->
          <div class="col-md-7">
            <h1 style="color: rgba(204,204,204,1)" class="text-left" id="upcomingDates">Upcoming Dates</h1>

            <!-- No Events Available -->
              <!-- <div class="d-none" id="eventsFalse"> -->
                <!-- <h2 class="featurette-heading">No Dates At This Time <span class="text-muted">It'll blow your mind.</span></h2> -->
               <!--  <p class="lead">Sorry, there are no scheduled dates <span class="text-gs">@</span> this time...</p>
              </div> -->
            <!-- /No Events Available -->

            <!-- Events Available -->
              <div class="container d-none" id="eventsTrue"></div>
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

        <hr class="featurette-divider">
        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->

      <!-- Include the Modals page -->
        <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/popupworship/phpBackend/indexModals.php'); ?>


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
    <script src="<?php echo URL;?>js/jsFunctions.js"></script>
    <script src="<?php echo URL;?>popupworship/js/indexJS.js"></script>

  </body>
</html>
