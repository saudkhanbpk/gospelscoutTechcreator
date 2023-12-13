<?php 
	$page = 's4a';
	
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	/* Query the giftmaster table */
		$fetchTalents = $db->query('SELECT giftmaster.sGiftName,giftmaster.iGiftID FROM giftmaster'); 
		$talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);
		// echo '<pre>';var_dump($talentList);
	/* END -Query the giftmaster table */

	/* Query the talentmaster table */
		// $fetchTalentCounts = $db->query('SELECT count(id), TalentID FROM talentmaster Group BY TalentID'); 
		// $talentListCount = $fetchTalentCounts->fetchAll(PDO::FETCH_ASSOC);
		// echo '<pre>';var_dump($talentListCount);
	/* END -Query the talentmaster table */

	/* Reduce $talentList from a 2D to 1D array */
		foreach($talentList as $tal) {
			$talentList1D[$tal['iGiftID']] = str_replace('_', '/', $tal['sGiftName']);
		}
		// echo '<pre>';var_dump($talentList1D);
	/* END - Reduce $talentList from a 2D to 1D array */
	
	/* Query the grouptypemaster table */
		$fetchGroupTypes = $db->query('SELECT grouptypemaster.id, grouptypemaster.sTypeName FROM grouptypemaster'); 
		$groupTypeList = $fetchGroupTypes->fetchAll(PDO::FETCH_ASSOC);
	/* END - Query the grouptypemaster table */
?>


<head>
    <link type="text/css" rel="stylesheet" href="lightGallery-master/dist/css/lightGallery.css" /> 


 <!-- jQuery version must be >= 1.8.0; -->
    <!--<script src="jquery.min.js"></script> -->

    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script> -->

    <script src="lightGallery-master/dist/js/lightgallery.min.js"></script>

    <!-- lightgallery plugins -->
    <script src="lightGallery-master/modules/lg-thumbnail.min.js"></script>
    <script src="lightGallery-master/modules/lg-fullscreen.min.js"></script>

    <!--  Owl Carousel -->
    	<!-- Owl Stylesheets -->
		    <link rel="stylesheet" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/owlcarousel/assets/owl.carousel.min.css">
		    <link rel="stylesheet" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/owlcarousel/assets/owl.theme.default.min.css">

		<!-- Favicons -->
		    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/ico/apple-touch-icon-144-precomposed.png">
		    <link rel="shortcut icon" href="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/ico/favicon.png">
		    <link rel="shortcut icon" href="favicon.ico">

		<!-- javascript -->
		    <script src="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/vendors/jquery.min.js"></script>
		    <script src="<?php echo URL;?>newHomepage/node_modules/OwlCarousel/docs/assets/owlcarousel/owl.carousel.js"></script>
</head>
<!-- Main Page Carousel -->
<div id="myCarousel" class="carousel slide carousel-fade mb-3" data-ride="carousel">
	<!--
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
    -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <!--<img class="first-slide" src="<?php echo URL; ?>newHomePage/img/BusinessCardCollage2.png" alt="First slide">  data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw== -->
        <img class="first-slide d-none d-md-block" src="<?php echo URL;?>newHomePage/img/BusinessCardCollage2.png" alt="First slide"> 
        <img class="first-slide d-md-none displayImg" src="<?php echo URL;?>newHomePage/img/soloimgs/shari-solo.png" alt="First slide">
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Looking for a talented artist?</h1>
            <p>Post a Gig Ad and start recieving artist submissions immediately!</p>
            <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>newHomePage/publicgigads/" target="_blank" role="button">Post a Gig Ad</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="second-slide d-none d-md-block" src="<?php echo URL;?>newHomePage/img/soloimgs/markees1.png" alt="Second slide" style="object-fit:cover; object-position:0,0;">
        <img class="second-slide d-md-none" src="<?php echo URL;?>newHomePage/img/soloimgs/markees2.png" alt="Second slide" style="object-fit:cover; object-position:0,0;">
        <div class="container">
          <div class="carousel-caption">
             <h1>Holder Text</h1>
            <p>A featured Top-rate Artist</p>
            <p><a class="btn btn-lg btn-gs" href="#" role="button">View My Profile</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="third-slide" src="<?php echo URL; ?>newHomePage/img/1148troyBanner4.png" alt="Third slide">
        <div class="container">
          <div class="carousel-caption text-right">
             <h1>Need a gig?</h1>
            <p>Create a profile and check out the posted gigs!</p>
            <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>newHomePage/views/postedGigs.php" target="_blank" role="button">Posted Gigs</a></p>
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
</div> <!-- /Main Page Carousel -->

<!-- Artist Criteria Section -->
<div class="container mt-0 p-0 " style="width:100%">
	

	 <div class="container text-center text-gs py-2">
		<h1 class="m-0">Find An Artist Today!</h1>
    </div>
	

	<div class="container pt-1" style="border-radius:10px 10px 0 0">
		<div class="row">
			<div class="col-12 col-md-3  p-0 card-shadow" style="border-radius:10px; max-height:560px; ">
				<div class="card text-center m-0 pb-0" style="border-bottom:none;">
				  <div class="card-header">
				    <ul class="nav nav-tabs card-header-tabs" style="font-size:.8em">
				      <li class="nav-item">
                      <a class="nav-link active artist_search_method" id="by_talent" href="#">Search by Talent</a><!-- <span class="badge badge-pill badge-primary" id="talent_count">0</span> -->
                    </li>
                    <li class="nav-item">
                      <a class="nav-link artist_search_method" id="by_filter" href="#">Filter </a><!-- <span class="badge badge-pill badge-primary" id="filtered_count">0</span> -->
                    </li>
				    </ul>
				  </div>
				  	<!-- Display the artist navigation section -->
						<div class="card-body py-0 px-0"  id="nav_display" >
							<div class="nav_method" id="get_by_talent">
					  			<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomePage/search4artist/phpBackend/tal_nav_insert.php'); ?>
					  		</div>
					  		<div class="nav_method d-none" id="get_by_filter">
					  			<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomePage/search4artist/phpBackend/filtered_search_insert.php'); ?>
					  		</div>
					  </div>
					<!-- /Display the artist navigation section -->
				</div>
			</div>
			
			<div class="col-12 col-md-9 mt-3 mt-md-0">
				<div class="container" id="artist_display_container">
					<div class="row mt-5">
						<div class="col-12" id="display_load_wheell"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<hr class="my-4"> <!-- Page Divider -->
<?php 
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomePage/search4artist/phpBackend/indexModals.php');
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); 
?>

<script src="<?php echo URL;?>newHomePage/search4artist/js/indexJS_newFunctions.js"></script>
<script src="<?php echo URL;?>newHomePage/search4artist/js/indexJS_new.js"></script>

</body>
</html>