<?php 
  require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php");
?>

  <header class="masthead" style="padding-top:50px;">
    <!--<div class="container h-100 bg-pirimary">
      <div class="row bg-pirimary h-100">
        <div class="col-lg-7 my-auto">
          <div class="header-content mx-auto">
            <h2 class="mb-3">Need reliable musicians for your church services, studio sessions, events, etc.?</h2>
            <a id="btn_findArtists2" href="https://www.gospelscout.com/artist/" class="btn btn-lg btn-gs btn-block text-uppercase" type="button">Find Artists</a> 
          </div>
        </div>
      </div>
    </div>-->
    <!-- <div class="row">
        <div class="col-lg-7 my-auto">
          <button id="btn_findArtists2" class="btn btn-lg btn-gs btn-block text-uppercase" type="button">Find Artists</button> 
        </div>
      </div>-->
    <!--<div class="d-none d-xl-block" style="position:absolute;top:300px;right:150px">
      <img src="https://www.gospelscout.com/img/banner_img_4.png" class="img-fluid" alt="" style="height:auto; width:1000px;" >
    </div>-->
    <!-- New test carousel -->
    <div class="container mx-auto mt-0" id="feature-carousel"> <!-- h-75-->
      <div class="row h-100 py-0">
        <div class="col-lg-12 py-4  mx-auto " id="carousel-container" style="">
          <div class="header-content mx-auto  pt-0 " style="height: 100%">
          <!-- Carousel -->
            <div id="carouselExampleSlidesOnly" class="carousel slide  mt-0" data-ride="carousel" style="height: 100%; width: 100%">
             
              <div class="carousel-inner h-100 text-center">
                <div class="carousel-item h-100 active pl-3 " id="slide1Landing" style="min-height:400px">
                   <h2 class="mb-3 mt-4 carousel-text">Need reliable musicians for your church services, studio sessions, events, etc.?</h2>
                    <a id="btn_findArtists2" href="https://www.gospelscout.com/artist/" class="btn btn-lg btn-block btn-gs text-uppercase carousel-btn"  type="button">Find Artists</a> <!--style="background-color:#9549AD"-->
                </div>
                <div class="carousel-item h-100"  id="slide2Landing" style="min-height:400px">
                  <h2 class="mb-3 mt-4 carousel-text">Tired of depending on Word-of-Mouth to book a gig?</h2>
                  <a id="btn_findGig" href="https://www.gospelscout.com/findgigs" class="btn btn-lg btn-gs btn-block text-uppercase carousel-btn" type="button">Find Gigs</a> 
            
                </div>
                <div class="carousel-item h-100" id="slide3Landing" style="min-height:400px;">
                  <h2 class="mb-3 mt-4 carousel-text">Musician dropped out at the last minute?</h2>
                  <a id="btn_findArtists3" href="https://www.gospelscout.com/publicgigads/" class="btn btn-lg btn-gs btn-block text-uppercase carousel-btn" type="button">Post a Gig Ad</a> 
                </div>
				        <!--<div class="carousel-item h-100 active" id="slide4Landing" style="min-height:400px;">
                  <a id="btn_findArtists3" target="_blank" href="https://www.eventbrite.com/e/poolside-artist-showcase-jam-session-tickets-657881901477" class="btn btn-lg btn-gs btn-block text-uppercase carousel-btn" type="button">Get Info</a>
                </div> -->
              </div>
              <ol class="carousel-indicators" id="landingP-slide-indicators">
                <li data-target="#carouselExampleSlidesOnly" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleSlidesOnly" data-slide-to="1"></li>
               <li data-target="#carouselExampleSlidesOnly" data-slide-to="2"></li>
				<!--<li data-target="#carouselExampleSlidesOnly" data-slide-to="3" class="active"></li>-->
              </ol>
            </div>
          <!-- Carousel END  -->
          </div>
        </div>

        <div class="d-none d-md-block col-lg-6 my-auto"></div>
      </div>
    </div>
    <!-- END - New test carousel -->
    
    <div class="container p-0 " id="signUp2" style=""> <!-- d-none d-lg-block d-xl-block -->
                  <div class="row m-0 p-0">
                    <div class="col-lg-12 col-xl-12 mx-auto p-0">

                      <div class="card card-signin flex-row my-5">
                        <!--<div class="card-img-left d-none d-md-flex"></div>-->
                        <div class="card-body">
                          <h5 class="card-title text-center text-gs">Create a Profile Today!</h5>
                          <form name="frmLogin2" id="frmLogin2" method="post" class="form-signin" action="https://www.gospelscout.com/signup/artist/">
                             <div class="form-label-group">
                              <input type="email" class="form-control" id="inputEmail2" name="sEmailID2" placeholder="Email address" required>
                              <label for="inputEmail2">Email address</label>
                            </div>
                            <div class="form-label-group">
                              <input type="password" class="form-control" id="inputPassword2" name="sPassword2" placeholder="Password" required>
                              <label for="inputPassword2">Password</label>
                            </div>
                             <div class="form-label-group">
                              <input type="password" class="form-control" id="confInputPassword2" name="sConfPassword2" placeholder="Confirm Password" required>
                              <label for="confInputPassword2">Confirm Password</label>
                            </div>
                            <!--<div class="form-label-group">
                              <input type="email" class="form-control" id="inputEmail2" name="sEmailID2" placeholder="Email address" required>
                              <label for="inputEmail">Email address</label>
                            </div>-->
                            
                            <hr>

                            <!--<div class="form-label-group">
                              <input type="password" class="form-control" id="inputPassword2" name="sPassword2" placeholder="Password" required>
                              <label for="inputPassword">Password</label>
                            </div>-->
							             

                            <label class="text-gs">Select a profile type:</label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="profType" id="artistType" value="artist" checked>
                              <label class="form-check-label text-dark" for="artistType">
                                Artist
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="profType" id="gen_userType" value="gen_user">
                              <label class="form-check-label text-dark" for="gen_userType">
                                General User
                              </label>
                    rgba(167, 161, 168, 0.7)
                            <!--<div class="form-label-group">
                              <label for="userType">Profile Type</label>
                              <select class="form-control" id="userType">
                                <option value="artist">Artist</option>
                                <option value="gen_user">General User</option>
                              </select>
                            </div>-->

                            <div class="container ">
                              <div class="row">
                                <div class="col text-center">
                                  <span class="text-danger" id="loadlogin2"></span>
                                </div>
                              </div>
                            </div>

							              <div class="container mt-2">
                              	<div class="row">
                                	<div class="col text-center">
                            	  	<button id="btn_login2" popUpWorship="false"  class="btn btn-lg btn-gs btn-block text-uppercase" type="submit">Sign Up</button>
							              <!--<a class="text-primary d-block text-center small" href="#" id="forgot-password">Forgot Password?</a>-->
									              </div>
								              </div>
							              </div>	
                            <!--<hr class="my-4">
                            <a class="d-block text-center mt-2 small font-weight-bold" href="<?php echo URL;?>index.php#signupSect">Sign Up</a>-->
                            
                            <!--<button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign up with Google</button>
                            <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign up with Facebook</button>-->
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  </header>

  <section class="features" id="features" style="background-color: rgb(255,255,255);">
    <div class="container">
      <div class="section-heading text-center mb-0">
        <h2>Features</h2><!--Countless , Unlimited Potential-->
        <p class="text-muted">Check out what you can do on this platform!</p>
        <hr>
      </div>
      <div class="row">
        <!--<div class="d-none d-md-block col-lg-4 my-auto"></div>-->
        <div class="col-12 my-auto">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <!--<i class="icon-screen-smartphone text-primary"></i>-->
                  <div class="my-0 mx-0 p-0" style="min-height:100px; width:auto; background: no-repeat center url('https://www.gospelscout.com/img/find_gigs2.svg'); background-size: 85px 85px;"></div>
                  <h3>Find A Gig</h3>
                  <!--<p class="text-muted">Create an Artist profile today!  You will gain direct access and have the ability to perform filtered searches through GospelScout's gig listings. In addition, you will automatically receive notifications for newly-posted gigs that match your profile.</p>-->
                  <ul class="text-left">
                    <li><p class="text-muted">Gain direct access to GospelScout's gig listings.</p></li>
                    <li><p class="text-muted">Receive instant notifications for newly-posted gigs that match your profile.</p></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <!--<i class="icon-camera text-primary"></i>-->
                  <div class="my-0 mx-0 p-0" style="min-height:100px; width:auto; background: no-repeat center url('https://www.gospelscout.com/img/find_artist2.svg'); background-size: 85px 85px;"></div>
                  <h3>Find & Book Artists</h3>
                  <!--<p class="text-muted">You can easily find and book artists by performing either a filtered search directly through our artist listings or by creating a user profile and posting a gig ad.  When posting a gig ad, GospelScout does most of the work for you. Simply enter in your requirements and GospelScout will search our database of qualified artists and direct them to your post. </p>-->
                  <ul class="text-left">
                    <li><p class="text-muted">Easily find and book artists</p></li>
                    <li><p class="text-muted">Perform filtered searches</p></li>
                    <li><p class="text-muted">Post gig ads</p></li>
                  </ul>
                </div>
              </div>
            </div>
            <!--<div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <div class="my-0 mx-0 p-0" style="min-height:100px; width:auto; background: no-repeat center url('https://www.gospelscout.com/img/grow_church.svg'); background-size: 85px 85px;"></div>
                  <h3>Grow Your Church</h3>-->
                  <!--<p class="text-muted">Create your church profile today and position yourself for greater exposure to your local community. Give users more insight on your unique worship experience by adding videos, photos, and other pertinent details.  Collect tithes, offerings, and other donations directly from your profile.</p>-->
                  <!--<ul class="text-left ">
                    <li><p class="text-muted">Build a profile and display:</p>
                      <ul>
                        <li><p class="text-muted">Photos</p></li>
                        <li><p class="text-muted">Videos</p></li>
                        <li><p class="text-muted">Location, contact info, business hours, and much more</p></li>
                      </ul>
                    </li>
                    <li><p class="text-muted">Collect tithes, offerings, & donations directly from your profile</p></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">-->
                  <!--<i class="icon-lock-open text-primary"></i>-->
                  <!--<div class="my-0 mx-0 p-0" style="min-height:100px; width:auto; background: no-repeat center url('https://www.gospelscout.com/img/find_church.svg'); background-size: 85px 85px;"></div>
                  <h3>Find a Church</h3>-->
                  <!--<p class="text-muted">There is a church out there waiting to connect with you. Use our filtered search tool to find the church that suits your spiritual needs and fosters growth within yourself and your relationship with God.</p>-->
                  <!--<ul class="text-left">
                    <li><p class="text-muted">Don't want to waste your time?</p>
                      <ul>
                        <li><p class="text-muted">Easily find churches in your local community</p></li>
                        <li><p class="text-muted">Perform filtered searches</p></li>
                        <li><p class="text-muted">View and connect with content in line with your spiritual journey.</p></li>
                      </ul>
                    </li>
                  </ul>

                </div>
              </div>
            </div>-->
          </div>
        </div>
      </div>
    </div>
    <!--<div class="d-none d-xl-block" style="position:absolute;top:350px;left:250px;">
      <img src="https://www.gospelscout.com/img/banner_img_5.png" class="img-fluid" alt="" style="height:700px;width:auto;"> 
    </div>-->
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
                <img class="rounded-circle" style="margin:35px 0 35px 0" src="https://www.gospelscout.com/img/music5.gif" alt="Generic placeholder image" width="200" height="74">
                <p class="font-weight-bold" style="font-size:1.8em;">Artists</p>
                <!--<p>Whether you are an artist looking to develop your skills, get more exposure to your local community, or collaborate with other talented artists, GospelScout is the place for you.  Create a profile today.</p>-->
                <ol class="text-left" >
                  <li><p class="text-muted my-1">Get more exposure to your local community</p></li>
                  <li><p class="text-muted my-1">Find & book more gigs</p></li>
                  <li><p class="text-muted my-1">Collaborate with other talented artists</p></li>
                </ol>
                <a href="<?php echo URL;?>signup/artist/" class="btn btn-sm bg-gs p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Create a Profile &raquo;</a>
              </div><!-- /.col-lg-4 -->
              <div class="col-lg-4">
                <img class="rounded" src="https://www.gospelscout.com/img/church.svg" alt="Generic placeholder image" width="128" height="128">
                <p class="font-weight-bold" style="font-size:1.8em;">Churches</p>
                 <ol class="text-left" >
                  <li><p class="text-muted my-1">Dipslay Church Info, videos, and photos</p></li>
                  <li><p class="text-muted my-1">Collect tithes, offering, and donations directly from your profile</p></li>
                  <li><p class="text-muted my-1">Keep everyone updated with your event calendar and much more</p></li>
                </ol>
                <p class="text-muted" style="font-size:2.5em">Coming Soon!</p>
                <!--<button type="button" class=" btn btn-sm p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Create a Profile &raquo;</button>-->
              </div>
              <div class="col-lg-4">
                <img class="rounded" src="https://www.gospelscout.com/img/dummy.svg" alt="Generic placeholder image" width="128" height="128">
                <p class="font-weight-bold" style="font-size:1.8em;">General User</p>
                <ol class="text-left" >
                  <li><p class="text-muted my-1">Subscribe to your favorite local artists</p></li>
                  <li><p class="text-muted my-1">Stay updated on local gigs</p></li>
                  <li><p class="text-muted my-1">Easily book your favorite artists</p></li>
                </ol>
                <a href="https://www.gospelscout.com/signup/gen_user/" class=" btn btn-sm p-3 text-white font-weight-bold align-middle mb-2 mb-md-0 mt-2 mt-md-0" style="border:none;border-radius:10px;background-image:linear-gradient(0deg,#9549AD,#B876CC)">Create a Profile &raquo;</a>
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
          <div class="col-12 col-lg-5">
            <h3>#popUpWorship Is Here!</h3>
            <a href="<?php echo URL; ?>popupworship/" class="font-weight-bold">Find Upcoming Events</a>
          </div>
        
          
          <div class="col-12 col-lg-7">
             <div class=" a-prof-shadow mr-2  p-0 embed-responsive embed-responsive-16by9" style="max-height:800px max-width:700px;"> <!--  col-12 col-md-5-->
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
          <p>GospelScout is an idea that was inspired by a culmination of life experiences, including growing up in church and falling in love with the atmosphere created by praise and worship.  We believe the impact that this kind of atmosphere can have should not only be limited to the walls of the church.  Our goal is to bring the gospel/christian/inpsiration based genre to a new level by providing a platform that encourages new sound, creativity, artist collaboration, live performance, and much more.  </p>
        </div>
        <div class="col-12 col-md-8 text-center mx-auto bg-white py-4 px-3 px-md-5" style="background-color:rgba(185,125,212,.2);"><!--  style="background-color:rgba(248,173,121,.5);"> -->
          <img class="rounded" src="https://www.gospelscout.com/img/kirk_cover.jpg" alt="Generic placeholder image" width="200" height="225" style="object-fit:cover; object-position:0,0;"><!-- box-shadow: -3px 4px 10px 0px rgba(0,0,0,1); -->
          <h3 class="font-weight-bold mt-2">Kirk Drummond</h3>
          <p>Hey guys, thanks for visiting us!  We understand how valuable your time is and we are honored that you would share it with us.  I am an engineer by education, but a creator & musician at heart.  I love to conceive an idea and then see it come to life.</p>
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






