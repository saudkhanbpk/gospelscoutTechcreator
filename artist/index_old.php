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

	/* Reduce $talentList from a 2D to 1D array */
		foreach($talentList as $tal) {
			$talentList1D[$tal['iGiftID']] = $tal['sGiftName'];
		}
		// var_dump($talentList1D);
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


		<style>
			.owl-nav .owl-prev {
			    width: 15px;
			    width: 80px;
			    height: 130px;
			    position: absolute;
			    font-size: 6em;
			    /*top: 0;*/
			    margin-left: -20px;
			    padding: 20px;
			    display: block !important;
			    border:0px solid black;
			    background-color: #fff;
			    top:15px;bottom:0;left:-25px;
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
			    width: 80px;
			    height: 130px;
			    position: absolute;
			    /*right: -25px;*/
			    display: block !important;
			    border:0px solid black;

			    top:15px;bottom:0;right:-25px;
				background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
			}

			/*.owl-nav .owl-next:hover{
				display: none;
			}*/
			.owl-carousel:hover .owl-buttons {
			  display: block;
			  background: transparent;
			}

			#owl-demo .item{
			/*  background: #a1def8;
			  padding: 30px 0px;
			  display: block;
			  margin: 5px;
			  margin: 0px 40px;
			  color: #FFF;
			  -webkit-border-radius: 3px;
			  -moz-border-radius: 3px;
			  border-radius: 3px;
			  text-align: center;*/
			}

			.owl-item {
				/*text-align: center;*/
				/*margin-left:5px;
				margin-bottom: 0px;*/
				/*box-sizing: border-box;*/
			}
			.owl-theme .owl-controls .owl-next span {
			  /*background: transparent;
			  color: #869791;
			  font-size: 40px;
			  line-height: 300px;
			  margin: 0;
			  padding: 0 60px;
			  position: absolute;
			  top: 0;*/
			}
			.owl-theme .owl-controls button {
				background: transparent;
			}
			.owl-item {
				padding:0 2px;
				transition: .5s ease;
			}
			.owl-item:hover {
				margin: 0 40px;
				transform: scale(1.3);
				z-index: 3000;
			}
			.owl-stage-outer {
				/*background: red;*/
				margin: 0;
				padding: 0;
			}
			.owl-stage {
				/*width: auto;*/
				transition: .5s ease;
				padding: 20px 0;
				/*z-index: 6000;*/
				/*background: yellow;*/
			}
			/*.owl-stage:hover {
				width: 1500px;
			}*/
			.owl-theme .owl-nav .disabled {
			 	opacity: 0;
			}
		</style>
    <!--  /Owl Carousel -->
</head>
<!-- Main Page Carousel -->
<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
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
<div class="container">
	<!-- <div class="row">
          <div class="col-lg-4 mx-auto text-center"> 
            <img class="rounded-circle" src="<?php echo URL; ?>newHomePage/img/music5.gif" alt="Generic placeholder image" width="200" height="160">
        </div>
    </div> -->

	 <div class="container text-center text-gs mb-5">
		<h1>Find An Artist Today!</h1>
    </div>
	<div class="row">
		<div class="col-5 col-sm-3 col-lg-2 px-0"><a class="btn btn-primary m-2" id="talDropCollapser" data-toggle="collapse" href="#searchCriteria">Find an Artist</a></div>
		<div class="col-5 col-sm-3 col-lg-2 px-0 talDrop">
			<?php //echo '<pre>'; var_dump($talentList1D);?>
			<!-- Default dropright button -->
				<div class="btn-group dropright">
				  <button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Search by Talent
				  </button>

				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButon" style="max-height: 500px;overflow:scroll;">
				    <a class="dropdown-item active talentGroup" artistType="artist" talent="all" href="">ALL</a>

				    <?php 
				    	foreach($talentList1D as $talentList1D_index => $singleTal) {
				    		echo '<a class="dropdown-item talentGroup" artistType="artist" talent="' . $talentList1D_index . '" href="#' . $singleTal . '">' .  str_replace("_","/",$singleTal) . '</a>';  //' . $singleTal . ' #Bassist
				    	}
				    ?>
				  </div>
				</div>
			<!-- /Default dropright button -->
		</div>
		<div class="col-5 col-sm-3 col-lg-2 px-0 talDrop">
			<!-- Default dropright button -->
				<div class="btn-group dropright">
				  <button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Groups
				  </button>

				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButon" style="max-height: 500px;overflow:scroll;">
				    <a class="dropdown-item active talentGroup" artistType="group" talent="all" href="">ALL</a>

				    <?php 
				    	foreach($groupTypeList as $singleType) {
				    		echo '<a class="dropdown-item talentGroup" artistType="group" talent="' . $singleType['id'] . '" href="#' . $singleTal . '">' .  str_replace("_","/",$singleType['sTypeName']) . '</a>';  //' . $singleTal . ' #Bassist
				    	}
				    ?>
				  </div>
				</div>
			<!-- /Default dropright button -->
		</div>
	</div>
</div>

<div class="container mt-3 collapse" id="searchCriteria">
	<form id="searchCriteriaForm" name="searchCriteriaForm">
	  <div class="row form-group">
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!-- <input type="text" class="form-control" placeholder="State"> -->
	       <?php 
	      	$states = $obj->fetchRowAll("states",'country_id = 231'); 
	      ?>
	      <select class="custom-select form-control" id="state" name="sStateName">
	      	<option value="">State</option>
	      	<?php 
	      		foreach($states as $state){
	      	?>
	      			<option value="<?php echo $state['id'];?>"><?php echo $state['name']; ?></option>
	      	<?php
	      		}
	      	?>
	      </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	       <input type="text" class="form-control" name="sCityName" placeholder="City">
	       <!-- <select class="custom-select" id="city">
	       	<option value="">City</option>
	       </select> -->
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <input type="text" class="form-control" name="iZipcode" placeholder="Zip Code">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	       <select class="custom-select" id="artistType" name="TalentID">
	       	<option value="">What Kind of Artist?</option>
	       	<option value="groups">Groups</option>
	       	<?php 
		    	foreach($talentList1D as $talentList1D_indy => $singleTal) {
		    		echo '<option value="' . $talentList1D_indy . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
		    	}
		    ?>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2 d-none" id="groupTypeContainer">
	       <select class="custom-select" id="groupType" name="sGroupType">
	       	<option value="">What Type of Group?</option>
	       	<!-- <option value="all">All Groups</option> -->
	       	<?php 
		    	foreach($groupTypeList as $sType) {
		    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
		    	}
		    ?>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	       <select class="custom-select" id="availability" name="sAvailability">
		       	<option value="">Availability</option>
		       	<option value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
		        <option value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
		        <option value="Will Play For Food (Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
		        <option value="Will Play For Free">Will Play for Free </option>
	       </select>
	    </div>

	    <!-- <div class="col-12 col-sm-6 col-lg-4 mt-2">
	       <select class="custom-select" id="numbViews">
	       	<option value=""># of Views</option>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <input type="text" class="form-control" name="rating" placeholder="Star Rating Placeholder">
	    </div> -->
	  </div>
	  	<div id="hourlyRate">
	  		Hourly Rate: 
		    <div class="row form-group">
			    <div class="col-12 col-sm-6 col-lg-2 mt-2">
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Min Rate/hr.</label>
			      	<input type="text" class="form-control" name="rate1" placeholder="0.00">
			    </div>
			    <div class="col-12 col-sm-6 col-lg-2 mt-2">
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Max Rate/hr.</label>
			      	<input type="text" class="form-control" name="rate2" placeholder="0.00">
			    </div>
			    <div class="col-12 col-sm-6 col-lg-2 mt-2 pt-md-4">
			    	<label class="text-gs mb-0 bg-warning" style="font-size:10px;font-weight:bold;display:block" for="">(Artist with an unlisted rate will not appear in search results.)</label>
			    </div>
			</div>
			<div class="d-none" id="rateErr"></div>
		</div>
	  	<div id="ageDiv">
	  		Age: 
		    <div class="row form-group">
			    <div class="col-12 col-sm-6 col-lg-2 mt-2">
			    	<!-- <label>Age:</label> -->
			      	<input type="text" class="form-control" name="dDOB1" placeholder="Min Age">
			    </div>
			    <div class="col-12 col-sm-6 col-lg-2 mt-2">
			      <input type="text" class="form-control" name="dDOB2" placeholder="Max Age">
			    </div>
			</div>
			<div class="d-none" id="ageErr"></div>
		</div>
	  <h5 class="text-gs">OR</h5>
	  Looking for a Specific Artist? 
	    <div class="row form-group">
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="sFirstName" placeholder="First Name">
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="sLastName" placeholder="Last Name">
		    </div>
		</div>
	  <button type="button" class="btn btn-gs" id="searchArtist">Search</button>
	</form>
</div><!-- /Artist Criteria Section -->

<hr class="my-4"> <!-- Page Divider -->


<div class="container" id="test_owl_container" style="width:100%"></div>
	

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>

<script src="<?php echo URL;?>newHomePage/search4artist/js/indexJS.js"></script>

</body>
</html>