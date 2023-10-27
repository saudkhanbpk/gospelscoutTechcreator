<!--<section class="cookie d-none" id="cookie">
   <div class="txt">
      <p class="">
         By using Gospelscout.com,<br>
         you agree to our <a href="https://www.gospelscout.com/privacy/#cookies" target="_blank">Cookie Policy.</a>
      </p>
   </div>
   <div>
      <a class="sm-btn accept bg-gs" id="accept-btn">Accept</a>
   </div>
</section>-->

<!-- <div class="fixed-bottom"> -->
<section class="contact bg-contact mt-5 " id="contact" style="position:relative;">
    
    <div class="container text-white font-weight-bold" ><!-- style="z-index:1000" -->
    
      <div class="row text-md-left">
        <div class="col col-md-6">
          <div class="container ">
            <div class="row mb-md-3">
              <div class="col">
                <img id="company-logo" src="https://www.gospelscout.com/img/logo_bright_2.png" style="height:40px;width:40px" class="img-fluid" alt="">
                <span class="ml-2 font-weight-bold">GospelScout</span>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <p class="text-content" >Designed to make booking gigs effortless.</p>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <p class="my-0"><img id="company-logo" src="https://www.gospelscout.com/img/phone_icon.svg" style="height:15px;width:15px" class="img-fluid" alt=""><span class="text-content">   805 283 7269</span></p>
                <p class="my-0"><img id="company-logo" src="https://www.gospelscout.com/img/send_email2.svg" style="height:15px;width:15px" class="img-fluid" alt=""><span class="text-content">   Administrator@gospelscout.com</span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-3 mt-3 mt-md-0">
          <div class="container ">
            <div class="row mb-md-3">
              <div class="col">
                <span class="ml-2 font-weight-bold">Navigation</span>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="<?php echo URL;?>artist/" class="text-content">Artists</a>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="<?php echo URL;?>church/" class="text-content">Churches</a>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="<?php echo URL;?>event/" class="text-content">Events</a>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="<?php echo URL;?>ourevents/" class="text-content">Our Events</a>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="<?php echo URL;?>#Contact-Us" class="text-content">Contact Us</a>
              </div>
            </div>
            <?php if($currentUserID == "" ){?>
              <div class="row my-md-2">
                <div class="col">
                  <a data-toggle="modal" data-target="#login-signup" class="text-content">Login/Signup</a>
                </div>
              </div>
            <?php }?>
          </div>
        </div>
        <div class="col-12 col-md-3 mt-3 mt-md-0">
          <div class="container ">
            
            <div class="row mb-md-3">
              <div class="col">
                <span class="ml-2 font-weight-bold">Social Media</span>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="https://www.facebook.com/gospelscout" target="_blank" class="text-content"><img id="company-logo" src="https://www.gospelscout.com/img/facebook_icon.svg" style="height:25px;width:25px" class="img-fluid" alt=""> <span class="ml-1">Facebook</span></a>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="https://www.instagram.com/gospelscout/" target="_blank" class="text-content"><img id="company-logo" src="https://www.gospelscout.com/img/insta_icon.svg" style="height:25px;width:25px" class="img-fluid" alt=""> <span class="ml-1">Instagram</span></a>
              </div>
            </div>
            <div class="row my-md-2">
              <div class="col">
                <a href="https://twitter.com/GospelScout" target="_blank" class="text-content"><img id="company-logo" src="https://www.gospelscout.com/img/twitter_icon.svg" style="height:25px;width:25px" class="img-fluid" alt=""> <span class="ml-1">Twitter</span></a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  </section>


<footer><!--  style="position:absolute;" -->
    <div class="overlay"></div>
    <div class="container">
      <?php 
        $year = date_create();
        $currentYear = $year; 
        $currentYear = date_format($currentYear, 'Y');
        date_sub($year,date_interval_create_from_date_string("1 years"));
        $lastYear = date_format($year, 'Y');
      ?>
      <p>&copy; 2016-<?php echo $currentYear;?>. All Rights Reserved.</p>
      <ul class="list-inline">
        <li class="list-inline-item">
          <a target="_blank" href="<?php echo URL;?>privacy/" style="position:relative;z-index:100;">Privacy</a>
        </li>
        <li class="list-inline-item">
          <a target="_blank" href="<?php echo URL;?>terms/" style="position:relative;z-index:100;">Terms</a>
        </li>
        <li class="list-inline-item">
          <a href="#">FAQ</a>
        </li>
      </ul>
    </div>
  </footer>
<!-- </div> -->

  <?php require(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/headerNewModals.php');?>
  

  <!-- Bootstrap core JavaScript -->
  <script>window.jQuery || document.write('<script src="https://www.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <!--<script src="<?php echo URL;?>home/vendor/jquery/jquery.min.js"></script> -->
  <!--<script src="https://dev.gospelscout.com/newHomePage/composer/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script> -->
  <!--<script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>-->
  
  <script src="<?php echo URL;?>home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="<?php echo URL;?>home/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
   <script src="<?php echo URL;?>home/js/new-age.js?8"></script>

  <!-- Custom JS functions and header JS -->
  <script src="<?php echo URL;?>js/jsFunctions.js?87"></script>
  <script src="<?php echo URL;?>js/headerNewJS.js?27"></script>

   <script>
    /* User logout due to deactivation */
      var isActive = '<?php echo $isActive;?>';
      if(isActive == '0'){
          /* Trigger deactivation message modal */
            $('#acctDeactivated').modal('show');
      }

      $('#deact-logout').click(function(event){
          event.preventDefault();

          /* Call logOUt function */
            logOut(); 
      });
   </script>

</body>

</html>
