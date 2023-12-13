<?php 
	$page = 's4a';
	
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	/* Query the giftmaster table */
		$fetchTalents = $db->query('SELECT giftmaster.sGiftName FROM giftmaster'); 
		$talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);
	/* END -Query the giftmaster table */

	/* Reduce $talentList from a 2D to 1D array */
		foreach($talentList as $tal) {
			$talentList1D[] = $tal['sGiftName'];
		}
	/* END - Reduce $talentList from a 2D to 1D array */
	
	/* Query the grouptypemaster table */
		$fetchGroupTypes = $db->query('SELECT grouptypemaster.id, grouptypemaster.sTypeName FROM grouptypemaster'); 
		$groupTypeList = $fetchGroupTypes->fetchAll(PDO::FETCH_ASSOC);
	/* END - Query the grouptypemaster table */
?>


<head>
    <link type="text/css" rel="stylesheet" href="lightGallery-master/dist/css/lightGallery.css" /> 
</head>

 <!-- jQuery version must be >= 1.8.0; -->
    <!--<script src="jquery.min.js"></script> -->

    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>

    <script src="lightGallery-master/dist/js/lightgallery.min.js"></script>

    <!-- lightgallery plugins -->
    <script src="lightGallery-master/modules/lg-thumbnail.min.js"></script>
    <script src="lightGallery-master/modules/lg-fullscreen.min.js"></script>

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
            <h1>Holder Text</h1>
            <p>A featured Top-rate Artist</p>
            <p><a class="btn btn-lg btn-gs" href="#" role="button">View My Profile</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="second-slide" src="" alt="Second slide">
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
             <h1>Holder Text</h1>
            <p>A featured Top-rate Artist</p>
            <p><a class="btn btn-lg btn-gs" href="#" role="button">View My Profile</a></p>
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
			<!-- Default dropright button -->
				<div class="btn-group dropright">
				  <button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Search by Talent
				  </button>

				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButon" style="max-height: 500px;overflow:scroll;">
				    <a class="dropdown-item active talentGroup" artistType="artist" talent="all" href="">ALL</a>

				    <?php 
				    	foreach($talentList1D as $singleTal) {
				    		echo '<a class="dropdown-item talentGroup" artistType="artist" talent="' . $singleTal . '" href="#' . $singleTal . '">' .  str_replace("_","/",$singleTal) . '</a>';  //' . $singleTal . ' #Bassist
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
	<form id="searchCriteriaForm">
	  <div class="row form-group">
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!-- <input type="text" class="form-control" placeholder="State"> -->
	       <?php 
	      	$states = $obj->fetchRowAll("states",'country_id = 231'); 
	      ?>
	      <select class="custom-select form-control" id="state">
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
	      <input type="text" class="form-control" name="zip" placeholder="Zip Code">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	       <select class="custom-select" id="artistType">
	       	<option value="">What Kind of Artist?</option>
	       	<option value="groups">Groups</option>
	       	<?php 
		    	foreach($talentList1D as $singleTal) {
		    		echo '<option value="' . $singleTal . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
		    	}
		    ?>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2 d-none" id="groupTypeContainer">
	       <select class="custom-select" id="groupType">
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
	       <select class="custom-select" id="availability">
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
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Min Rate</label>
			      	<input type="text" class="form-control" name="rate1" placeholder="0.00">
			    </div>
			    <div class="col-12 col-sm-6 col-lg-2 mt-2">
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Max Rate</label>
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
		      <input type="text" class="form-control" name="FirstName" placeholder="First Name">
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="LastName" placeholder="Last Name">
		    </div>
		</div>
	  <button type="button" class="btn btn-gs" id="searchArtist">Search</button>
	</form>
</div><!-- /Artist Criteria Section -->

<hr class="my-4"> <!-- Page Divider -->

<div id="artistDisplay1">
	
	<!-- Loading spinwheel -->
		<!-- <div class="container text-center">
			<div class="row">
				<div class="col">
					<div class="container text-center">
						<div class="spinner-border text-center text-gs font-weight-bold" style="width:3em;height:3em;" id="payment-spinner" aria-hidden="true" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<p style="font-size:1.3em;" class="text-gs ml-0 font-weight-bold">Just One Sec...</p>
					</div>
				</div>
			</div>
		</div> -->
	<!-- /Loading spoinwheel -->
	


	<style>
	html{
		scroll-behavior:smooth;
	}
	body {
		margin: 0;
	}
	.wrapper {
		display: grid;
		grid-template-columns: repeat(3,100%);
	}
	.item {
		padding:0 2px;
		transition: .5s ease;
	}
	.item:hover {
		margin: 0 40px;
		transform: scale(1.2);
	}

	.wrapper a {
		position: absolute;
		color: rgba(149,73,173,.7);
		text-decoration: none; 
		font-size: 6em;
		background: rgb(0,0,0);
		width: 80px;
		/*padding: 20px;*/
		text-align: center; 
		z-index: 1;
	}
	.wrapper a:nth-of-type(1){
		top:0;bottom:0;left:0;
		background: linear-gradient(-90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	}
	.wrapper a:nth-of-type(2){
		top:0;bottom:0;right:0;
		background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	}
	section {
		width: 100%;
		position:relative;
		display: grid;
		grid-template-columns: repeat(7, auto);
		margin: 20px 0;
	}
	section:nth-child(1){
		background: #fff; //#7be0ac;
	}
	
	/*section:nth-child(2){
		background: #b686e5;
	}
	section:nth-child(3){
		background: #f183a3;
	}*/

	.wrapTest{
		overflow: auto;
		/*white-space:nowrap;*/
	}

</style>

	<!-- <div class="container bg-warning px-0 " id="show-artists">
		<div class="row mx-0 mx-md-0 px-0 px-md-0 wrapper wrapTest" style="background-color:black"> -->
			<!-- <div class="col "> -->
			<div class="wrapper">
				<section id="section1">
					<a href="#section3"><</a>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>

					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<a href="#section2">></a>
				</section>
				<section id="section2">
					<a href="#section1"><</a>
					<div class="item">
						<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>

					<div class="item">
						<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<a href="#section3">></a>
				</section>
				<section id="section3">
					<a href="#section2"><</a>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>

					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<a href="#section1">></a>
				</section>
			</div> 
		<!-- </div> 
		<hr class="my-1"> 
		
	</div> -->

<!-- 
	vars to pass to phpBackend 
		pagination_tab 
		talent


	offSet = ( {pagination_tab_number} - 1) * 6; 
	rowCount = 6;
	use 'LIMIT {offset}, {row count}'clause in select query statement


 -->


</div><!-- Artist Display Div --> 

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>

<script src="<?php echo URL;?>newHomePage/search4artist/js/indexJS.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#lightgallery").lightGallery(); 

        $('#aniimated-thumbnials').lightGallery({
		    thumbnail:true,
		    animateThumb: false,
		    showThumbByDefault: false
		}); 
    });
</script>
</body>
</html>