    <?php 
      require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/headerNew.php');
    ?>

    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">

            <img class="first-slide d-none d-md-block" src="img/carouselFinal.png" alt="First slide"> 
            <img class="first-slide d-md-none displayImg" src="img/soloimgs/shari-solo13.png" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h2>Search 4 Artists</h2>
                <p>Find, Book, and Colloborate With Amazing Gospel Artists Right In Your Backyard!!!</p>
                <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/search4artistNew.php" role="button">Find An Artist</a></p>
              </div>
            </div>
          </div>
          <!--
          <div class="carousel-item">
            <img class="second-slide d-none d-md-block" src="" alt="Second slide">
            <img class="second-slide d-md-none displayImg" src="img/soloimgs/keys-solo.png" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h2>Search 4 Churches</h2>
                <p>Skip the hassle of church hopping for weeks to even months at a time, trying to find the worship experience right for you.  Visit our Search 4 Church page and easily pin point dozens of churches in your area before stepping out of your front door.</p>
                <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/search4churchNew.php" role="button">Find A Church</a></p>
              </div>
            </div>
          </div>
          -->
          <div class="carousel-item">
             <img class="third-slide d-none d-md-block" src="<?php echo URL;?>img/carouselFinal.png" alt="Third slide">
            <img class="third-slide d-md-none displayImg" src="img/soloimgs/keys-solo.png" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h2>Search 4 Events</h2>
                <p>Find and Participate In Local Gospel Events, Such As Concerts, Plays, Conferences, Charities, Community Outreach, and Much Much More!!!.</p>
                <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/search4eventNew.php" role="button">Find Events</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="fourth-slide d-none d-md-block" src="img/carouselFinal.png" alt="Fourth slide"> 
            <img class="fourth-slide d-md-none displayImg" src="img/soloimgs/guitar-solo2.png" alt="Fourth slide"> 
            <div class="container">
              <div class="carousel-caption text-left">
                <h2><span class="text-gs">#</span>PopUpWorship<span class="text-gs">LA</span> IS HERE</h2>
                <p>Immerse yourself in an engaging spiritual environment surrounded by amazing talent and fellow worshipers</p>
                <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>popupworship" role="button">More Info</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->
      
      <!-- GospelScout Purpose -->
	      <div class="container marketing pt-0">
	        <div class="container text-center text-gs mb-5">
	          <h1>"Choose Unity & Growth Over Competition"</h1>
	        </div>
	        <!-- Sign up Section data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==-->
	        <div class="row my-0">
	          <div class="col-lg-4"> <!-- rounded-circle -->
	            <h2>Looking for a Church?</h2>
	            <p>There is a church out there waiting to connect with you!!!  Find the church that suits your spiritual needs and fosters growth within yourself and your relationship with God!!!</p>
	          </div><!-- /.col-lg-4 -->
	          <div class="col-lg-4">
	            <h2>Are you a church?</h2>
	            <p>
	             The Gospel community is more about unity than competition!!!  Allow more people that connect with your specific worship, teaching, and preaching experience to find you much easier and watch your congregant growth and retention soar.
	            </p>
	          </div><!-- /.col-lg-4 -->
	          <div class="col-lg-4">
	            <h2>Are you an Artist?</h2>
	            <p>
	              Beginner, intermediate, or professional -  All are welcome to an environment that encourages growing in your craft versus competing with the next artist.  There is a gig out there for everyone - create a profile today and find it!!! 
	            </p>
	          </div><!-- /.col-lg-4 -->
	        </div><!-- /.row -->
	
	        <hr class="featurette-divider my-3">
	      </div>            
      <!-- /GospelScout Purpose -->
      
      <!-- site features -->
	      <div class="container marketing pt-0">
	        <div class="container text-center text-gs mb-5">
	          <h1>"How Can We Help?"</h1>
	        </div>
	        <!-- Sign up Section data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==-->
	        <div class="row my-0">
	          <div class="col-lg-4"> <!-- rounded-circle -->
	            <h2>Find A Church</h2>
	            <ul class="text-left" style="font-size:14px">
	              <li class="my-1">Use our targeted search form from the "search 4 church" page</li>
	            </ul>
	
	            <h2>Grow Your Church</h2>
	            <ul class="text-left" style="font-size:14px">
	              <li class="my-1">Create a church profile that displays all your pertinent church details & help those looking for you find you</li>
	              <li class="my-1">Display photo & video of your ministries & give potential visitors some insight as to the awesome worship experience that awaits them</li>
	              <li class="my-1">Collect visitor feedback with our constructive feedback form</li>
	              <li class="my-1">Collect tithes, offering, and/or donations directly from your profile</li>
	              <li class="my-1">Keep your local community up-to-date by posting your events to your public calendar</li>
	            </ul>
	          </div><!-- /.col-lg-4 -->
	          
	          <div class="col-lg-4">
	            <h2>Find An Artist</h2>
	            <ul class="text-left" style="font-size:14px">
	              <li class="my-1">Use our targeted search form from the "search 4 artist" page</li>
	              <li class="my-1">Post public gig-ads that will be accessble to a countless number of qualified artists</li>
	            </ul>
	
	            <h2>Find A Gig</h2>
	            <ul class="text-left" style="font-size:14px">
	              <li class="my-1">Create an artist profile</li>
	              <li class="my-1">Gain access to a countless number of gigs looking for artists just like you through our "Find A Gig" page</li>
	            </ul>
	          </div><!-- /.col-lg-4 -->
	          <div class="col-lg-4">
	            <h2>Find An Event</h2>
	            <ul class="text-left" style="font-size:14px">
	              <li class="my-1">Use our targeted search form from the "search 4 events" page</li>
	            </ul>
	          </div><!-- /.col-lg-4 -->
	        </div><!-- /.row -->
	
	        <hr class="featurette-divider my-3">
	      </div>
      <!-- /site features -->
      
      <div class="container marketing pt-5" id="signupSect">
        <div class="container text-center text-gs mb-5">
          <h1>Create An Account Today!</h1>
        </div>
        <!-- Sign up Section data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==-->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="<?php echo URL; ?>img/music5.gif" alt="Generic placeholder image" width="200" height="160">
            <h2>Artists</h2>
            <p>Whether you are a gospel artist looking to develop your skills, get more exposure to your local community, or collaborate with other talented artists, GospelScout is the place for you.  Create a profile today.</p>
            <p><a class="btn btn-gs" href="<?php echo URL;?>views/artist.php" role="button">Create a Profile &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded" src="<?php echo URL; ?>img/church3.png" alt="Generic placeholder image" width="160" height="160">
            <h2>Churches</h2>
	    <p>
              Are you a church looking to: <span class="text-gs">1.</span> share God’s love through your unique worship experience <span class="text-gs">2.</span> increase your exposure to the local community and <span class="text-gs">3.</span> grow your congregation? Create your GospelScout Church profile today and give your local community an inside look at how God is using your ministry!!!
            </p>
            <p><button class="btn btn-gs" disabled href="<?php echo URL;?>views/church.php" role="button">Create a Profile &raquo;</button></p> <!-- disableAnch-->
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded" src="<?php echo URL; ?>img/event7.jpg" alt="Generic placeholder image" width="160" height="160">
            <h2>General User</h2>
            <p>Are you neither an artist nor church but fall into one of the following categories: <span class="text-gs">1.</span> a fan of live music and/or the performing arts <span class="text-gs">2.</span> interested in booking performing artists <span class="text-gs">3.</span> interested in connecting with your local churches <span class="text-gs">4.</span> interested in staying connected with what is happending in your local gospel community and much more?  Create your GospelScout user profile day and join our fun and amazing community!!!</p>
            <p><a class="btn btn-gs" href="<?php echo URL;?>views/user.php" role="button">Create a Profile &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
	
	<script>
		$('.disableAnch').click(function(event){
			event.preventDefault();
		});
	</script>

        <!-- START THE FEATURETTES -->
<!--
        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It'll blow your mind.</span></h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
          </div>
        </div>
-->
        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
     <!--  <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer> -->
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="https://www.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="http://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="http://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>-->
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
   <!-- <script src="https://www.gospelscout.com/twbs/bootstrap/assets/js/vendor/holder.min.js"></script> -->
  </body>
</html>
