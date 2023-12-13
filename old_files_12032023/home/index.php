<?php 
  require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php");
?>

  <header class="masthead" style="background-color:blue">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-lg-7 my-auto">
          <div class="header-content mx-auto">
            <h1 class="mb-5">GospelScout, designed to make booking gigs effortless.</h1>
            <!-- <a href="#demo" class="btn btn-outline btn-xl js-scroll-trigger">View Demo</a> -->
          </div>
        </div>
        <div class="d-none d-md-block col-lg-5 my-auto">
          

        </div>
      </div>
    </div>
    <!--
    <div class="d-none d-xl-block" style="position:absolute;top:300px;right:150px">
      <img src="img/banner_img_4.png" class="img-fluid" alt="" style="height:auto; width:1200px;" >
    </div>
    -->
  </header>

  <section class="features" id="features" style="background-color: rgb(255,255,255);">
    <div class="container">
      <div class="section-heading text-center">
        <h2>Countless Features, Unlimited Potential</h2>
        <p class="text-muted">Check out what you can do on this platform!</p>
        <hr>
      </div>
      <div class="row">
        <div class="d-none d-md-block col-lg-4 my-auto"></div>
        <div class="col-lg-8 my-auto">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-screen-smartphone text-primary"></i>
                  <h3>Find A Gig</h3>
                  <p class="text-muted">Create an Artist profile today!  You will gain direct access and have the ability to perform filtered searches through GospelScout's gig listings. In addition, you will automatically receive notifications for newly-posted gigs that match your profile.</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-camera text-primary"></i>
                  <h3>Find & Book Artists</h3>
                  <p class="text-muted">You can easily find and book artists by performing either a filtered search directly through our artist listings or by creating a user profile and posting a gig ad.  When posting a gig ad, GospelScout does most of the work for you. Simply enter in your requirements and GospelScout will search our database of qualified artists and direct them to your post. </p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-present text-primary"></i>
                  <h3>Grow Your Church</h3>
                  <p class="text-muted">Create your church profile today and position yourself for greater exposure to your local community. Give users more insight on your unique worship experience by adding videos, photos, and other pertinent details.  Collect tithes, offerings, and other donations directly from your profile.</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-lock-open text-primary"></i>
                  <h3>Find a Church</h3>
                  <p class="text-muted">There is a church out there waiting to connect with you. Use our filtered search tool to find the church that suits your spiritual needs and fosters growth within yourself and your relationship with God.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--
    <div class="d-none d-xl-block" style="position:absolute;top:350px;left:250px;">
      <img src="img/banner_img_5.png" class="img-fluid" alt="" style="height:700px;width:auto;"> 
    </div>
    -->
  </section>

  <section class="download text-center" id="signup" style="background: linear-gradient(180deg, #F0F1F6, #FFFFFF);">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mx-auto">
          
          <h2 class="section-heading">Create an Account Today!</h2>
          <div class="container marketing pt-0" id="signupSect">
            <!-- Sign up Section data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==-->
            <div class="row">
              <div class="col-lg-4"> <!-- rounded-circle -->
                <img class="rounded-circle" style="margin:35px 0 35px 0" src="https://www.gospelscout.com/img/music5.gif" alt="Generic placeholder image" width="250" height="93">
                <p class="font-weight-bold" style="font-size:1.8em;">Artists</p>
                <p>Whether you are an artist looking to develop your skills, get more exposure to your local community, or collaborate with other talented artists, GospelScout is the place for you.  Create a profile today.</p>
                <!-- <p><a class="btn btn-gs" href="<?php echo URL;?>newHomePage/views/artist.php" role="button">Create a Profile &raquo;</a></p> -->
                <button type="button" class=" btn btn-sm p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Create a Profile &raquo;</button>
              </div><!-- /.col-lg-4 -->
              <div class="col-lg-4">
                <img class="rounded" src="https://www.gospelscout.com/img/church3.png" alt="Generic placeholder image" width="160" height="160">
                <p class="font-weight-bold" style="font-size:1.8em;">Churches</p>
                <p>
                  Are you a church looking to: <span class="text-gs">1.</span> share God’s love through your unique worship experience <span class="text-gs">2.</span> increase your exposure to the local community and <span class="text-gs">3.</span> grow your congregation? Create your GospelScout profile today and give your local community an inside look at how God is using your ministry!!!
                </p>
                <!-- <p><button class="btn btn-gs" href="<?php echo URL;?>newHomePage/views/index.php" disabled role="button">Create a Profile &raquo;</button></p> --> <!-- church -->
                <button type="button" class=" btn btn-sm p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Create a Profile &raquo;</button>
              </div><!-- /.col-lg-4 -->
              <div class="col-lg-4">
                <img class="rounded" src="https://www.gospelscout.com/img/event7.jpg" alt="Generic placeholder image" width="160" height="160">
                <p class="font-weight-bold" style="font-size:1.8em;">General User</p>
                <p>Are you neither an artist nor church but fall into one of the following categories: <span class="text-gs">1.</span> a fan of live music and/or the performing arts <span class="text-gs">2.</span> interested in booking performing artists <span class="text-gs">3.</span> interested in connecting with your local churches <span class="text-gs">4.</span> interested in staying connected with what is happending in your local gospel community and much more?  Create your GospelScout user profile today and join our fun and amazing community!!!</p>
                <!-- <p><a class="btn btn-gs" href="<?php echo URL;?>newHomePage/views/user.php" role="button">Create a Profile &raquo;</a></p> -->
                <button type="button" class=" btn btn-sm p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Create a Profile &raquo;</button>
              </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
          </div><!-- /.container -->
          
        </div>
      </div>
    </div>
  </section>

  <section class="cta" id="popupworship">
    <div class="cta-content">
      <div class="container" >

        <div class="row">
          <div class="col">
            <h3>#popUpWorship Is Here!</h3>
            <a href="<?php echo URL; ?>newHomePage/popupworship/" class="font-weight-bold">Find Upcoming Events</a>
          </div>
        
          
          <div class="col">
             <div class=" a-prof-shadow bg-danger mr-2  p-0 embed-responsive embed-responsive-16by9" style="max-height:800px max-width:700px;;"> <!--  col-12 col-md-5-->
                <iframe  class="embed-responsive-item" src="https://www.youtube.com/embed/dEvhjPHLXDI?start=100" allow="autoplay; encrypted-media" style="background:transparent;" frameborder="0" allowfullscreen></iframe>
              </div>
          </div>
        </div>

      </div>
    </div>
    <div class="overlay"></div>
  </section>

   <section class="about bg-primary" id="about">
    <div class="container my-0 py-0 bg-danger">
      <div class="row my-0 py-0 bg-primary">
        <div class="col-12 col-md-4 text-center my-0 py-4" style="background-color:rgba(185,125,212,.2);">
          <h2>About Us</h2>
          <p>GospelScout is an idea that was inspired by a culmination of life experiences, including growing up in church and falling in love with the atmosphere creaed by praise and worship.  We believe the impact that this kind of atmosphere can have should not only be limited to the walls of the church.  Our goal is to bring the gospel/christian/inpsiration based genre to a new level by providing a platform that encourages new sound, creativity, artist collaboration, live performance, and much more.  </p>
        </div>
        <div class="col-12 col-md-8 text-center mx-auto bg-white py-4 px-3 px-md-5" style="background-color:rgba(185,125,212,.2);"><!--  style="background-color:rgba(248,173,121,.5);"> -->
          <img class="rounded" src="https://www.gospelscout.com/img/kirk_cover.jpg" alt="Generic placeholder image" width="200" height="225" style="object-fit:cover; object-position:0,0;"><!-- box-shadow: -3px 4px 10px 0px rgba(0,0,0,1); -->
          <h3 class="font-weight-bold mt-2">Kirk Drummond</h3>
          <p>Hey guys, thanks for visiting us!  We understand how valuable your time is and we are honored that you would share it with us.  I am an engineer by education, but a creator & musician by heart.  I love to conceive an idea and then see it come to life.</p>
        </div>
      </div>
    </div>
   <!--  <div style="position:absolute;top:0px;left:250px;">
      <img src="img/banner_img_3.png" class="img-fluid" alt="" style="height:700px;width:auto;"> 
    </div> -->
  </section>

   <section class="about bg-white" id="Contact-Us">
    <div class="container my-0 py-0">
      <div class="row my-0 py-0">
        <div class="col-12 text-center my-0 py-4">
          <h2>Contact Us</h2>
          <p>For any help or concerns please contact us.  We are here to help!</p>
        </div>
      </div>

      <div class="row my-0 py-0 bg-white">
        <div class="col-12 col-lg-6 text-center bg-white py-4 px-3 px-md-5 d-none d-lg-block position-relative">
          <div class="position-absolute" style="top:-120px">
            <img src="https://www.gospelscout.com/img/help_desk.svg" alt="Generic placeholder image" width="100%" height="500" style="object-fit:cover; object-position:0,0;">
        </div>
        </div>
        <div class="col-12 col-lg-6 text-center mx-auto py-4 px-3 px-md-5 align-bottom">
          <form name="contact_form" type="" action="#" method="POST" id="myform" autocomplete="no">
             <input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
             <input type="hidden" name="sUsertype" value="<?php if($currentUserType == 'artist' || $currentUserType == 'group'){echo 'artist';}elseif($currentUserType == 'church'){echo 'church';}elseif($currentUserType == 'user'){echo 'user';}else{echo 'Visitor';}?>">
            <div class="container px-0 text-left">
              <div class="row mx-0 my-2 px-0">
                <div class="col-12 col-md-6 my-1 my-md-0 mx-0 mr-md-0 px-0">
                  <input type="text" class="ml-0 d-inline-block pl-3 name-fields" name="fName" placeholder="First Name" value="<?php if($userInfo){ echo $userInfo['sFirstName'];}?>" style="height:40px;width:98%;font-size:1em;border-radius:44px;border: 1px solid rgba(149,73,173,.33">
                </div>
                <div class="col-12 col-md-6 my-1 my-md-0 mx-0 ml-md-0 px-0">
                  <input type="text" class="ml-0 d-inline-block pl-3 name-fields" name="lName" placeholder="Last Name" value="<?php if($userInfo){ echo $userInfo['sLastName'];}?>" style="height:40px;width:98%;font-size:1em;border-radius:44px;border: 1px solid rgba(149,73,173,.33"> 
                </div>
                <!-- <div class="col-6 mx-1 px-0 bg-secondary"><input type="text" class="mx-0" placeholder="Last Name" style="height:40px;width:100%;font-size:1.5em;border-radius:10px"></div></div></div> -->
              </div>
              <div class="row my-2">
                <div class="col-12"><input class="pl-3" type="text" name="email" placeholder="Email" value="<?php if($userInfo){ echo $currentUserEmail;}?>" style="height:40px;width:100%;font-size:1em;border-radius:44px;border: 1px solid rgba(149,73,173,.33"></div>
              </div>
              <div class="row my-2">
                <div class="col-12">
                  <textarea class="my-2 p-3" placeholder="Messages" name="contact_message" rows="8" style="width:100%;border-radius:24px;border: 1px solid rgba(149,73,173,.33" id="text-area"></textarea>
                </div>
              </div>
              <div class="row my-2">
                <div class="col-12 text-right">
                  <button type="button" id="contact-form-submit" class="mr-0 btn btn-sm p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Submit</button>
                </div>
              </div>

            </div>
          </form>
          <div class="container">
            <div class="row">
              <div class="col-12" id="email-status"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/footer.php");


  // include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); 
?>






