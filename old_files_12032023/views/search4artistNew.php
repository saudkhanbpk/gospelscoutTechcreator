<?php 
	$page = 's4a';
	
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

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
        <!-- <img class="first-slide" src="<?php echo URL; ?>img/BusinessCardCollage2.png" alt="First slide">  data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw== -->
        <img class="first-slide d-none d-md-block" src="<?php echo URL;?>img/carouselFinal.png" alt="First slide"> 
        <img class="first-slide d-md-none displayImg" src="<?php echo URL;?>img/soloimgs/shari-solo13.png" alt="First slide">
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Shari Demby</h1>
            <p>A Featured Artist</p>
            <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/artistprofile.php?artist=267" role="button">View My Profile</a></p>
          </div>
        </div>
      </div>
      
      <div class="carousel-item">
        <!-- <img class="second-slide" src="<?php echo URL; ?>img/1148troyBanner4.png" alt="Second slide">-->
        <img class="second-slide d-none d-md-block" src="<?php echo URL;?>img/1148troyBanner4.png" alt="Second slide"> 
        <img class="second-slide d-md-none displayImg" src="<?php echo URL;?>img/soloimgs/troy-solo.png" alt="Second slide">
        <div class="container">
          <div class="carousel-caption text-left">
             <h1>Troy Anthoney</h1>
            <p>A Featured Artist</p>
            <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/artistprofile.php?artist=317" role="button">View My Profile</a></p>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <!--<img class="third-slide" src="<?php echo URL; ?>img/banner.png" alt="Third slide">-->
        <img class="third-slide d-none d-md-block" src="<?php echo URL;?>img/banner.png" alt="Third slide"> 
        <img class="third-slide d-md-none displayImg" src="<?php echo URL;?>img/soloimgs/mandela-solo.png" alt="Third slide">
        <div class="container">
          <div class="carousel-caption text-left">
             <h1>Mandela Simmons</h1>
            <p>A Featured Artist</p>
            <p><a class="btn btn-lg btn-gs" href="<?php echo URL;?>views/artistprofile.php?artist=257" role="button">View My Profile</a></p>
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
	       	<!--<option value="all">All Groups</option>-->
	       	<?php 
		    	foreach($groupTypeList as $sType) {
		    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
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
	    <!-- <div class="col-12 col-sm-6 col-lg-4 mt-2">
	       <select class="custom-select" id="numbViews">
	       	<option value=""># of Views</option>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <input type="text" class="form-control" name="rating" placeholder="Star Rating Placeholder">
	    </div>-->
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
		    	<label class="text-gs mb-1" style="font-size:10px;font-weight:bold;display:block" for="">(Artist with an unlisted rate will not appear in search results.)</label>
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

<div id="artistDisplay">

	<!-- Loading spinwheel -->
		<!--
		<div class="container text-center">
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
		</div>
		-->
	<!-- /Loading spoinwheel -->
	
</div><!-- Artist Display Div --> 

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>

<!--<script src="<?php echo URL;?>js/jsFunctions.js?6"></script>-->
<script>
	/* Show and Hide grouptype and upper and lower age boundaries */
		var groupMaker = 0;
		$("#artistType").change(function(){
		    var selection = $(this).val();
	
		    if(selection == 'groups'){
		    	/* Show group types when group is selected */
		    		$('#groupTypeContainer').removeClass('d-none');

		    	/* Hide age inputs when group is selected */	
		    		$('#ageDiv').addClass('d-none');

		    	groupMaker = 1; 
		    }
		    else{
		    	/* Hide the group type select menu when group is not selected */
			    	$('#groupTypeContainer').addClass('d-none');
			    	$('#groupType').val('');
			    		
		    	/* Show the age inputs when an artist talent is selected as opposed to group */
			    	$('#ageDiv').removeClass('d-none');
			    	if(groupMaker == 1){
				    	$('input[name=dDOB1], input[name=dDOB2]').val('');
				    	groupMaker = 0;
			    	}

		    }
		});
	/* END - Show and Hide grouptype and upper and lower age boundaries */
		
	/* XMLHttpRequest the Artist Content to the page */
		displayLoadingElement('artistDisplay');
		var displayArtist = new XMLHttpRequest(); 
		displayArtist.onreadystatechange = function(){
			if(displayArtist.status == 200 && displayArtist.readyState == 4){
				document.getElementById('artistDisplay').innerHTML = displayArtist.responseText; 
			}
		}
		displayArtist.open('GET', 'https://www.gospelscout.com/views/xmlhttprequest/search4artistContent?type=artist');
		displayArtist.send(); 
	/* END - XMLHttpRequest the Artist Content to the page */
	
	/* Return artist results for selected talent from the talent dropdown menu */
	       	$('.talentGroup').click(function(event){
			event.preventDefault(); 
			displayLoadingElement('artistDisplay');
			
			var selectedTalent = $(this).attr('talent'); 
			var artistType = $(this).attr('artistType');
			var url = 'https://www.gospelscout.com/views/xmlhttprequest/search4artistContent.php?talent='+selectedTalent+'&type='+artistType; 


			var talentGroup = new XMLHttpRequest(); 
			talentGroup.onreadystatechange = function(){
				if(talentGroup.status == 200 && talentGroup.readyState == 4){
					document.getElementById('artistDisplay').innerHTML = talentGroup.responseText; 
				}
			}
			talentGroup.open('GET', url);
			talentGroup.send(); 
		});
	/* END - Return artist results for selected talent from the talent dropdown menu */

	/* Hide Talent Search Button when Find an Artist button is clicked */
		$(document).ready(function(){
			var t = 0; 
			$('#talDropCollapser').click(function(){
				
				if(t==0){
					$('.talDrop').hide(); 
					t = t+1; 
				}
				else{
					/* Show loading spinwheel */
						displayLoadingElement('artistDisplay');	
						
					$('.talDrop').show(); 
					
					/* Hide the group type select */
					$('#groupTypeContainer').addClass('d-none');
	
					/* Reset the form when the user collapses it */
					document.getElementById("searchCriteriaForm").reset();
	
					/* When the Find an Artist button collapses the criteria form return the listing of all artists to the page */
					var displayArtist1 = new XMLHttpRequest(); 
			   		displayArtist1.onreadystatechange = function(){
			   			if(displayArtist1.status == 200 && displayArtist1.readyState == 4){
			   				document.getElementById('artistDisplay').innerHTML = displayArtist1.responseText; 
			   			}
			   		}
			   		displayArtist1.open('GET', 'https://www.gospelscout.com/views/xmlhttprequest/search4artistContent');
			   		displayArtist1.send(); 
	
					t = t-1; 
				}			
			});	
		});	
	/* END - Hide Talent Search Button when Find an Artist button is clicked */

	/* Send artist search criteria */
		$("#searchArtist").click(function(event){
			event.preventDefault(); 
			displayLoadingElement('artistDisplay');
			
			var param1 = $('#state').val();
			var param2 = $('input[name=sCityName]').val(); 
			var param3 = $('input[name=zip]').val(); 
			var param4 = $('#artistType').val();
			var param5 = $('#availability').val(); 
			var param6 = $('input[name=FirstName]').val(); 
			var param7 = $('input[name=LastName]').val(); 
			var param8 = $('#numbViews').val(); 
			var param9 = $('input[name=rating]').val(); 
			var param10 = $('#groupType').val();
			var param11 = $('input[name=dDOB1]').val();
			var param12 = $('input[name=dDOB2]').val();
			var param13 = $('input[name=rate1]').val();
			var param14 = $('input[name=rate2]').val();
			
			var formData = new FormData(); 
			formData.append('sStateName', param1); 
			formData.append('sCityName', param2);
			formData.append('iZipcode', param3);
			formData.append('talent', param4);
			formData.append('sAvailability', param5); 
			formData.append('sFirstName', param6);
			formData.append('sLastName', param7);
			formData.append('sNumbViews', param8);
			formData.append('iRateAvg', param9);
			formData.append('sGroupType', param10);
			if(param11 != ''){
				if(param11 >= 4){
					formData.append('dDOB1', param11);
				}
				else{
					var param11Err = 1; 
				}
			}
			if(param12 != ''){
				if(param12 <= 120){
					formData.append('dDOB2', param12);
				}
				else{
					var param12Err = 1; 	
				}
			}
			if(param13 != ''){
				formData.append('rate1', param13);
			}
			if(param14 != ''){
				if(param11 <= 9999.99){
					formData.append('rate2', param14);
				}
				else{
					var param41Err = 1; 
				}
			}
	
			var sendSearch = new XMLHttpRequest(); 
			sendSearch.onreadystatechange = function(){
				if(sendSearch.status == 200 && sendSearch.readyState == 4){
					document.getElementById('artistDisplay').innerHTML = sendSearch.responseText;
				}
			}
			sendSearch.open("POST", "https://www.gospelscout.com/views/xmlhttprequest/search4artistContent");
			if(param11Err || param12Err){
				console.log('age error');
				$('#ageErr').removeClass('d-none');
				$('#ageErr').html('<p class="text-danger" style="font-size:12px;">Please enter an age between 4 and 120!!!</p>');
			}
			else{
				$('#ageErr').addClass('d-none');
				sendSearch.send(formData); 
			}
		});
	/* END - Send artist search criteria */
</script>
</body>
</html>