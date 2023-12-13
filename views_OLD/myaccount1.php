<?php include('../include/header.php'); ?>
<link href="<?php echo URL;?>css/half-slider.css" rel="stylesheet">
<script>
$(document).ready(function(){
	
	        $('#menu11').show();
	
    $("#menu1").click(function(){
        $('#menu11').show();
		$('#menu22').hide();
		$('#menu33').hide();
    });
	
	    $("#menu2").click(function(){
        $('#menu22').show();
		$('#menu11').hide();
		$('#menu33').hide();
    });
	
	    $("#menu3").click(function(){
        $('#menu33').show();
		$('#menu22').hide();
		$('#menu11').hide();
    });
});
</script>
    
    
  </head>

  <body>
  
  
  
 
  <div id="myCarousel" class="carousel slide container">
      
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url(img/slider1.jpg);"></div>
                <!--<div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>-->
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url(img/slider1.jpg);"></div>
                <!--<div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>-->
            </div>
            <div class="item">
                <!-- Set the third background image using inline CSS below. -->
                <div class="fill" style="background-image:url(img/slider1.jpg);"></div>
               <!-- <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>-->
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </div>
    

  	
  
  
  <div class="bg">
    <div class="container">
   <div class="col-lg-3 col-md-3 col-sm-3 p0">  
  	<div class="profile">
    	<img src="upload/artist/3288Koala.jpg" class="img-responsive center-block">
  	</div>
  </div>
  

<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item collaps">
    <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">Video</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Photos</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#references" role="tab" data-toggle="tab">Bio</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#pdf" role="tab" data-toggle="tab">Book Me</a>
  </li>
  <li class="nav-item collaps">
    <a class="nav-link" href="#subscribe" role="tab" data-toggle="tab">Subscribe</a>
  </li>
</ul>

<!-- Tab panes --> 
<div class="col-lg-3 col-md-3 col-sm-3">
	<div class="white">
    	<h3>Aritist Info</h3>
        <p><b>Current City:</b> Baltimore, MD 21133</p>
        <p><b>Availabillity:</b> Will play For Food</p>
        <p><b>My Talent(s):</b> Drummer, Pianist, trumpet</p>
    </div>
    
    
    <div class="white">
    	<h3 class="text-center">Upcoming Events</h3>
        <div class="events">
            <div class="width25">
                <img src="img/events.jpg" class="img-responsive center-block">
             </div>
             <div class="width83">
                <h5><b>Praying Hands...</b></h5>
                <h5>10/23/2015</h5>
                <h5>4:30pm</h5>
                <input type="button" class="btn btn-primary info" value="Get Info">
             </div>
         </div>
         
         <h4>View Full Event Calendar  <i class="fa fa-calendar"></i></h4>
    </div>
</div>

<div class="col-lg-9 col-md-9 col-sm-9"> 
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="profile">
  
  <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  	<div class="col-lg-12 col-md-12 col-sm-12">
    	<div class="col-lg-3 col-mg-3 col-sm-3">
        	<img src="img/blank.jpg" class="img-responsive center-block">
            <p class="tital">Eye on the Sparrow</p>
            <p class="subtital">3,000 Views</p>
            <p class="subtital">4 days Ago</p>
        </div>
        <div class="col-lg-3 col-mg-3 col-sm-3">
        	<img src="img/blank.jpg" class="img-responsive center-block">
        </div>
    </div>
  </div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="buzz">
  
  <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  
  <div id='cssmenu' class="mt30">
              <ul>
                <li><a id="menu1" class="active">Under 5 mins</a></li>
                <li><a id="menu2">Under 10 mins</a></li>
                <li><a id="menu3">Above 10 mins</a></li>
              </ul>
            </div>
            
            
            <div id="menu11">
  
  	<div class="col-lg-4 col-md-4 col-sm-4 overflow ">
        <iframe width="367" height="262" src="https://www.youtube.com/embed/gwro5LQu5Qw" frameborder="0" allowfullscreen></iframe>
	</div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 overflow ">
    	<iframe width="367" height="262" src="https://www.youtube.com/embed/Mh-h1I-HBG8" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 overflow ">
    <iframe width="367" height="262" src="https://www.youtube.com/embed/k5BEq4Ziw0k" frameborder="0" allowfullscreen></iframe>
    </div>
</div> 
   
  			<div id="menu22" style="display:none">
    <div class="col-lg-4 col-md-4 col-sm-4 overflow pb30">
    	<iframe width="367" height="262" src="https://www.youtube.com/embed/bbiALaUzUhc" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 overflow pb30">
   		<iframe width="367" height="262" src="https://www.youtube.com/embed/KYniUCGPGLs" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 overflow pb30">
    <iframe width="367" height="262" src="https://www.youtube.com/embed/fRsj_PhVQF0" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
  
  			<div id="menu33" style="display:none">
    <div class="col-lg-4 col-md-4 col-sm-4 overflow pb30">
    <iframe width="367" height="262" src="https://www.youtube.com/embed/KYniUCGPGLs" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 overflow pb30">
    	<iframe width="367" height="262" src="https://www.youtube.com/embed/lS_ubz6Sa9c" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 overflow pb30">
    <iframe width="367" height="262" src="https://www.youtube.com/embed/x1fe8-Qli9E" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
  </div>
  
</div>
<div role="tabpanel" class="tab-pane fade" id="references">
  <div class="col-lg-12 col-md-12 col-sm-12 white mg0">
  
  <div class="col-lg-12 col-md-12 col-sm-12 mt50 text">
  	<h2>Grow Your Pinterest Following: 5 Simple Steps for Brands </h2>
    <p>With over 80% of its 30 billion pins coming from re-pins, Pinterest is a great place for marketers who want to produce engagement. These five foundational tips can get you started optimizing your Pinterest profile for the best results<a href="#"><img src="img/arrow.png" class="img-responsive"></a></p>
    <img src="img/sedow.png" class="img-responsive center-block mb30"/>
  </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 text">
  	<h2>Grow Your Pinterest Following: 5 Simple Steps for Brands </h2>
    <p>With over 80% of its 30 billion pins coming from re-pins, Pinterest is a great place for marketers who want to produce engagement. These five foundational tips can get you started optimizing your Pinterest profile for the best results<a href="#"><img src="img/arrow.png" class="img-responsive"></a></p>
    <img src="img/sedow.png" class="img-responsive center-block mb30"/>
  </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 text">
  	<h2>Onward & Upward: Go Behind the Scenes of Priceline's Social Media</h2>
    <p>With over 80% of its 30 billion pins coming from re-pins, Pinterest is a great place for marketers who want to produce engagement. These five foundational tips can get you started optimizing your Pinterest profile for the best results<a href="#"><img src="img/arrow.png" class="img-responsive"></a></p>
    
  </div>
  
  </div>
  
  </div>
  <div role="tabpanel" class="tab-pane fade" id="pdf">
  
  
  </div>
</div>
</div>
  </div>
      </div>
  	
 
 
  	<div class="col-lg-12 col-md-12 col-sm-12 text-xs-center copy">
    	<p>Powered By  Eagletech Solutions © 2015</p>
    </div>

  </body>
</html>
