<?php 
	$page = 's4a';
	
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	/* Query the giftmaster table */
	$fetchTalents = $db->query('SELECT giftmaster.sGiftName FROM giftmaster'); 
	$talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);

	/* Reduce $talentList from a 2D to 1D array */
	foreach($talentList as $tal) {
		$talentList1D[] = $tal['sGiftName'];
	}
	
?><!-- /Query Database for Artist info -->

<!-- Main Page Carousel -->
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
        <img class="first-slide" src="<?php echo URL; ?>newHomePage/img/BusinessCardCollage2.png" alt="First slide"> <!-- data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw== -->
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
	<div class="row">
		<div class="col-5 col-sm-3 col-lg-2 px-0"><a class="btn btn-primary m-2" id="talDropCollapser" data-toggle="collapse" href="#searchCriteria">Find an Artist</a></div>
		<div class="col-5 col-sm-3 col-lg-2 px-0" id="talDrop">
			<!--<a class="btn btn-primary m-2" href="#">Sort by Talent</a> -->
			<!-- Default dropright button -->
			<div class="btn-group dropright">
			  <button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Search by Talent
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="max-height: 500px;overflow:scroll;">
			    <a class="dropdown-item active" href="#">ALL</a>
			    <?php 
			    	foreach($talentList1D as $singleTal) {
			    		echo '<a class="dropdown-item" id="' . $singleTal . '" href="#Bassist">' . $singleTal . '</a>';  //' . $singleTal . '
			    	}
			    ?>
			  </div>
			</div><!-- /Default dropright button -->
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
	      //	echo '<pre>';
	      //	var_dump($states);
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
	       <input type="text" class="form-control" name="city" placeholder="City">
	       <!-- <select class="custom-select" id="city">
	       	<option value="">City</option>
	       </select> -->
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <input type="text" class="form-control" name="zip" placeholder="Zip Code">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!-- <input type="text" class="form-control" placeholder="What Kind of Artist?"> -->
	       <select class="custom-select" id="artistType">
	       	<option value="">What Kind of Artist?</option>
	       	<?php 
		    	foreach($talentList1D as $singleTal) {
		    		echo '<option value="' . $singleTal . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
		    	}
		    ?>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!-- <input type="text" class="form-control" placeholder="Availability"> -->
	       <select class="custom-select" id="availability">
		       	<option value="">Availability</option>
		       	<option value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
		        <option value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
		        <option value="Will Play For Food (Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
		        <option value="Will Play For Free">Will Play for Free </option>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	     <!--  <input type="text" class="form-control" placeholder="# of Views"> -->
	       <select class="custom-select" id="numbViews">
	       	<option value=""># of Views</option>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <input type="text" class="form-control" name="rating" placeholder="Star Rating Placeholder">
	    </div>
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

<div id="artistDisplay"></div><!-- Artist Display Div --> 


<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>

<script>
	/* XMLHttpRequest the Artist Content to the page */
	
	var displayArtist = new XMLHttpRequest(); 
	displayArtist.onreadystatechange = function(){
		if(displayArtist.status == 200 && displayArtist.readyState == 4){
			document.getElementById('artistDisplay').innerHTML = displayArtist.responseText; 
		}
	}
	displayArtist.open('GET', 'xmlhttprequest/search4artistContent.php');
	displayArtist.send(); 

	/* Hide Talent Search Button when Find an Artist button is clicked */
	$(document).ready(function(){
		var t = 0; 
		$('#talDropCollapser').click(function(){
			if(t==0){
				$('#talDrop').hide(); 
				t = t+1; 
			}
			else{
				$('#talDrop').show(); 

				/* Reset the form when the user collapses it */
				document.getElementById("searchCriteriaForm").reset();

				/* When the Find an Artist button collapses the criteria form return the listing of all artists to the page */
				var displayArtist1 = new XMLHttpRequest(); 
		   		displayArtist1.onreadystatechange = function(){
		   			if(displayArtist1.status == 200 && displayArtist1.readyState == 4){
		   				document.getElementById('artistDisplay').innerHTML = displayArtist1.responseText; 
		   			}
		   		}
		   		displayArtist1.open('GET', 'xmlhttprequest/search4artistContent.php');
		   		displayArtist1.send(); 

				t = t-1; 
			}			
		});	
	});	


	$("#searchArtist").click(function(event){
		event.preventDefault(); 

		var param1 = $('#state').val();
		var param2 = $('input[name=city]').val(); 
		var param3 = $('input[name=zip]').val(); 
		var param4 = $('#artistType').val();
		var param5 = $('#availability').val(); 
		var param6 = $('input[name=FirstName]').val(); 
		var param7 = $('input[name=LastName]').val(); 
		var param8 = $('#numbViews').val(); 
		var param9 = $('input[name=rating]').val(); 
		

		var formData = new FormData(); 
		formData.append('sStateName', param1); 
		formData.append('name', param2);
		formData.append('iZipcode', param3);
		formData.append('talent', param4);
		formData.append('sAvailability', param5); 
		formData.append('sFirstName', param6);
		formData.append('sLastName', param7);
		formData.append('sNumbViews', param8);
		formData.append('iRateAvg', param9);
		console.log('help');
		var sendSearch = new XMLHttpRequest(); 
		sendSearch.onreadystatechange = function(){
			if(sendSearch.status == 200 && sendSearch.readyState == 4){
				console.log(sendSearch.responseText);
				document.getElementById('artistDisplay').innerHTML = sendSearch.responseText;
			}
		}
		sendSearch.open("POST", "xmlhttprequest/search4artistContent.php");
		sendSearch.send(formData); 
});
</script>
</body>
</html>