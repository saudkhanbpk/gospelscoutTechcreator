<?php 
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

?>
<head>
	<!-- Stylesheets -->
   <!--  <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,400italic,300italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/css/docs.theme.min.css"> -->

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/owlcarousel/assets/owl.theme.default.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/ico/favicon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Yeah i know js should not be in header. Its required for demos.-->

    <!-- javascript -->
    <script src="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/vendors/jquery.min.js"></script>
    <script src="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/owlcarousel/owl.carousel.js"></script>

	<style>
		/*html{
			scroll-behavior:smooth;
		}
		body {
			margin: 0;
		}
		.wrapper {
			display: grid;
			grid-template-columns: repeat(3,100%);
		}*/
		/*.overLay {
		  transition: .5s ease;
		  opacity: 0;
		  background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,1)); 
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  width: 100%;
		  height:100%;
		  transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  text-align: left;
		  z-index: 10;
		}*/
		/*.item {
			margin-top: 20px;
			margin-bottom: 20px;
			transition: .5s ease;
		}
		.item:hover {
			margin: 0 20px;
			transform: scale(1.4);
		}*/
		/*.item:hover .overlay {
			opacity: 1;
		}
		.item:hover .overlay .text {
			opacity: 1;
		}
		.text {
		  color: white;
		  padding:10px 0px 0px 5px;
		}

		.p_subtitle{
			margin: 0;
			font-size: 10px;
		}*/
		/*.japper a {//.wrapper 
			position: absolute;
			color: #fff;
			text-decoration: none; 
			font-size: 6em;
			background: rgb(0,0,0);
			width: 80px;
			padding: 20px;
			text-align: center; 
			z-index: 1;
		}
		.japper a:nth-of-type(1){  //.wrapper 
			top:1000;bottom:0;left:-500;
			background: linear-gradient(-90deg, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%);
		}
		.japper a:nth-of-type(2){  //.wrapper 
			top:0;bottom:0;right:0;
			background: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%);
		}*/
	/*	section {
			width: 100%;
			position:relative;
			display: grid;
			grid-template-columns: repeat(7, auto);
			margin: 20px 0;
		}
		section:nth-child(1){
			background: #7be0ac;
		}
		
		section:nth-child(2){
			background: #b686e5;
		}
		section:nth-child(3){
			background: #f183a3;
		}*/

		 .owl-nav .owl-prev {
		    /*width: 15px;*/
		    width: 80px;
		    height: 130px;
		    position: absolute;
		    font-size: 6em;
		    /*top: 0;*/
		    /*margin-left: -20px;*/
		    padding: 20px;
		    /*display: block !important;*/
		    border:0px solid black;
		    background-color: #fff;
		    top:39px;bottom:0;left:-10px;
			/*background: linear-gradient(-90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);*/
		}
		.owl-nav [class*=owl-] {
		   /* color: #fff;
		    font-size: 14px;
		    margin: 5px;
		    padding: 4px 7px;*/
		    /*background: rgb(0, 69, 100);*/
		    /*display: inline-block;
		    cursor: pointer;
		    -webkit-border-radius: 3px;
		    -moz-border-radius: 3px;
		    border-radius: 3px;*/
		}
		.owl-nav .owl-next {
		    /*width: 15px;*/
		    width: 80px;
		    height: 130px;
		    position: absolute;
		    /*top: 40%;*/
		    right: -25px;
		    display: block !important;
		    border:0px solid black;

		    top:39px;bottom:0;right:0;
			background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
		}
		/*.owl-prev i, .owl-next i {transform : scale(1,6); color: #ccc;}*/


	</style>

</head>


<!-- <body> -->
	
	<!-- <div class="japper">
        <a class="new-nav"><</a>
    </div> -->
	<div class="owl-carousel owl-theme mt-5 bg-primary pt-4 japper">
		
	   	<div class="item" style="background:#f183a3;">
			<img src="/newHomePage/upload/artist/266/123663813troyAnthoneyProfilePic1.png" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>

		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>

		<div class="item">
			<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>

		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
	</div>
	<div class="owl-carousel owl-theme mt-5 bg-primary pt-4 japper">
		
	   	<div class="item" style="background:#f183a3;">
			<img src="/newHomePage/upload/artist/266/123663813troyAnthoneyProfilePic1.png" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>

		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>

		<div class="item">
			<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>

		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
		<div class="item">
			<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist" /><!-- -->
		</div>
	</div>
<!-- <script type="text/javascript" src="https://www.youtube.com/iframe_api" id="iframe-demo"></script> -->
	<div class="container">
		<div class="row">
			<div class="col">
				<!-- <div id="testYT"></div> -->
				<iframe id="existing-iframe-example" width="640" height="360" src="https://www.youtube.com/embed/M7lc1UVf-VE?enablejsapi=1&origin=https://dev.gospelscout.com/newHomePage/search4artist/testIndex.php" frameborder="0" style="border: solid 4px #37474F"></iframe>
			</div>
		</div>
	</div>

	<script>
			// displayLoadingElement('testYT');
        	var tag = document.createElement('script');
	      	tag.src = "https://www.youtube.com/iframe_api";
	      	var firstScriptTag = document.getElementsByTagName('script')[0];
	      	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	      	var player;
		  	function onYouTubeIframeAPIReady() {
			    player = new YT.Player('existing-iframe-example', {
			    	 // height: '390',
			      //     width: '640',
			      //     videoId: 'M7lc1UVf-VE',
			        events: {
			          'onReady': onPlayerReady,
			          'onStateChange': onPlayerStateChange
			        }
			    });
				// console.log(player);
		  	}

		  	
		  	function onPlayerReady(event) {
		  		console.log('test on ready');
		  		console.log(event);
			    // document.getElementById('existing-iframe-example').style.borderColor = '#FF6D00';
			}
			// function changeBorderColor(playerStatus) {
			//     var color;
			//     if (playerStatus == -1) {
			//       color = "#37474F"; // unstarted = gray
			//     } else if (playerStatus == 0) {
			//       color = "#FFFF00"; // ended = yellow
			//     } else if (playerStatus == 1) {
			//       color = "#33691E"; // playing = green
			//     } else if (playerStatus == 2) {
			//       color = "#DD2C00"; // paused = red
			//     } else if (playerStatus == 3) {
			//       color = "#AA00FF"; // buffering = purple
			//     } else if (playerStatus == 5) {
			//       color = "#FF6DOO"; // video cued = orange
			//     }
			//     if (color) {
			//       document.getElementById('existing-iframe-example').style.borderColor = color;
			//     }
			// }
			function onPlayerStateChange(event) {
			    console.log(event);
			}
        $(document).ready(function() {


          var owl = $('.owl-carousel');
          owl.owlCarousel({
            margin: 10,
            nav: true,
            navText: ['<span class="text-white" style="font-size:3em;"><</span>','<span class="text-white" style="font-size:3em;">></span>'],
            // navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            // navContainerClass: 'owl-carousel',
            slideTransition: 'linear',
            dots: false,
            // lazyLoad: true,
            animateOut: true,
            loop: true,
            afterMove:function(elem){
            	console.log(elem);
	        //     //reset transform for all item
	        //     $(".owl-item").css({
	        //         transform:"none"
	        //     })
	        //     //add transform for 2nd active slide
	        //     $(".active").eq(1).css({
	        //         transform:"scale(1.9)",
	        //         zIndex:3000,

	        //     })

	        },
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 3
              },
              1000: {
                items: 5
              }
            }
          });

           $(".owl-item").css({
           		// 'margin-left': '100px'
           		// display:"none"
            })

        })
    </script>

</body>