<?php
/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Check that the user is logged in */
		if($currentUserID == ''){
?>
			<script> 
                window.location.href = 'https://www.gospelscout.com/index.php';
            </script>
<?php
		}
?>

<style>
	.hov_color:hover {
		background-color: rgba(203,163,211,1);
	}
</style>

<!-- Main Page Carousel -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="first-slide" src="<?php echo URL; ?>img/carouselFinal.png" alt="First slide"> <!-- data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw== -->
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Find A Gig Today!!!</h1>
            <p>Start Playing...Start Singing...Start Performing...NOW!!!</p>
          </div>
        </div>
      </div>
</div> <!-- /Main Page Carousel -->

<div class="container mt-4">
	 <div class="container text-center text-gs mb-5">
		<h1 class="font-weight-bold">Find Posted Gigs</h1>
    </div>

    <div class="row">
		<div class="col-5 col-sm-3 col-lg-2 px-0"><a class="btn btn-gs m-2" id="talDropCollapser" data-toggle="collapse" href="#searchCriteria">Filter Search</a></div>
	</div>
</div>

<div class="container mt-3 collapse" id="searchCriteria">
	<form id="searchCriteriaForm" name="getPosts">
		<span class="text-gs font-weight-bold">Location</span>
		<div class="row form-group">
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		       <?php 
		      	$states = $obj->fetchRowAll("states",'country_id = 231'); 
		      ?>
		      <select class="custom-select form-control" name="venueState" id="state">
		      	<option value="">State</option>
		      	<?php 
		      		foreach($states as $state){
		      	?>
		      			<option value="<?php echo $state['name'];?>"><?php echo $state['name']; ?></option>
		      	<?php
		      		}
		      	?>
		      </select>
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		       <input type="text" class="form-control" name="venueCity" placeholder="City">
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="venueZip" placeholder="Zip Code">
		    </div>
		</div>

		<span class="text-gs font-weight-bold">Artist </span>
		<div class="row form-group">
		  	<div class="col-12 col-sm-6 col-lg-4 mt-2">
		  		 <?php 
			      	$a_types = $obj->fetchRowAll("giftmaster",'isActive = 1'); 
			      ?>
		       <select class="custom-select" name="artistType" id="artistType">
		       	<option value="">Type of Artist Required</option>
		       	<option value="groups">Groups</option>
		       	<?php 
			    	foreach($a_types as $singleTal) {
			    		echo '<option value="' . $singleTal['iGiftID'] . '" >' . str_replace("_", "/", $singleTal['sGiftName']) . '</option>'; 
			    	}
			    ?>
		       </select>
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2 d-none" id="groupTypeContainer">
		    	<?php 
			      	$group_types = $obj->fetchRowAll("grouptypemaster",'isActive = 1'); 
			      ?>
		       <select class="custom-select" name="groupType" id="groupType">
		       	<option value="">Type of Group Required</option>
		       	<?php 
			    	foreach($group_types as $sType) {
			    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
			    	}
			    ?>
		       </select>
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
				<input type="text" class="form-control" name="dDOB1" placeholder="Age Minimum">
		    </div>
		  	 <div class="col-12 col-sm-6 col-lg-4 mt-2">
		  	 	<select class="custom-select mb-2" name="sGender">
					<option value="">Gender</option>
					<option value="both" <?php if($getGigDetails['sGender'] == 'both'){echo 'selected';}?>>Both</option>
					<option value="male" <?php if($getGigDetails['sGender'] == 'male'){echo 'selected';}?> >Male</option>
					<option value="female"  <?php if($getGigDetails['sGender'] == 'female'){echo 'selected';}?>  >Female</option>
				</select>
		  	 </div>
		</div>

		<span class="text-gs font-weight-bold">Gig Info </span>
		<div class="row form-group">
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		    	<?php 
			      	$g_types = $obj->fetchRowAll("eventtypes",'isActive = 1'); 
			      ?>
			    <select class="custom-select dropdown" id="eventType" name="gigType" >
			       	<option value="">Gig Type</option>
			       	<?php 
				    	foreach($g_types as $evID => $singleEv) {
				    		echo '<option value="' . str_replace("_", "/", $singleEv['sName']) . '" >' . str_replace("_", "/", $singleEv['sName']) . '</option>'; 
				    	}
				    ?>
			    </select>
			</div>
			<div class="col-12 col-sm-6 col-lg-4 mt-2">
	            <select class="custom-select dropdown" id="month" name="month" >
			       	<option value="">Month</option>
			       	<option value="01">January</option>
			       	<option value="02">February</option>
			       	<option value="03">March</option>
			       	<option value="04">April</option>
			       	<option value="05">May</option>
			       	<option value="06">June</option>
			       	<option value="07">July</option>
			       	<option value="08">August</option>
			       	<option value="09">September</option>
			       	<option value="10">October</option>
			       	<option value="11">November</option>
			       	<option value="12">December</option>
			    </select>
			</div>
			<div class="col-12 col-sm-6 col-lg-4 mt-2">
				<input type="text" class="form-control" name="gigPay" placeholder="Pay Minimum ($0.00)">
		    </div>
		</div>

	  <button type="button" class="btn btn-gs" id="filteredSearch">Search</button>
	</form>
</div><!-- /Artist Criteria Section -->

<hr class="my-4"> <!-- Page Divider -->

<div id="postDisplay"></div><!-- Gig Post Display Div --> 

<!-- Modal to display gigs on small screen -->
	<div class="d-md-none modal" id="gig-list-sm" tabindex="-1" role="dialog" aria-labelledby="gig-list-sm" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h5 class="modal-title text-gs" id="gig-list-sm-title"></h5>
	          <span id="loadlogin"></span> 
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>

		      <div class="modal-body px-4" id="gigList-sm">
		      </div>
		      <!-- Modal Footer -->
		        <div class="modal-footer px-4" style="font-size:13px">
		          <div class="checkbox container p-0" id="postDisplay-sm"> 
		           
		          </div>
		        </div>
		        <!-- /Modal Footer -->
	      </div>
	    </div>
	</div>
<!-- /Modal to display gigs on small screen -->

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>

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

	/**** Function to get the states where the gig posts are created ****/
		function getGigStates(){
			/* XMLHttpRequest the posted Gig to the page when page loads */
				var displayPosts = new XMLHttpRequest(); 
				displayPosts.onreadystatechange = function(){
					if(displayPosts.status == 200 && displayPosts.readyState == 4){
						var resp = displayPosts.responseText.trim();

						if(resp != ''){
							/* Parse the JSON formatted string */
								var parsedPosts = JSON.parse(displayPosts.responseText.trim());
							
							var showState = '<div class="Container mx-auto text-center" style="max-width:1000px">';
							showState += '<h3 class="my-3">Select A State</h3>';
							showState += '<div class="row mx-5 px-md-5 font-weight-bold">';
							$.each(parsedPosts,function(index, value){
								showState += '<div class="px-5 col-12 col-md-6 my-1"><a class="text-decoration-none getCities" state="'+index+'" href="#"><div class="bg-gs text-white p-2 a-prof-shadow rounded">'+index+'</div></a></div>';
							});
							showState += '</div></div>';

							$('#postDisplay').html(showState);
						}
						else{
							var noGigsMess = '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-5"><div class="col p-lg-5"><h2 class="" style="color: rgba(204,204,204,1)">There Are No Posted Gigs!!!</h2></div></div></div>';
							$('#postDisplay').html(noGigsMess);
						}
					}
				}
				displayPosts.open('GET', '<?php echo URL; ?>views/xmlhttprequest/g_postedGigs.php?getPosts=true');
				displayPosts.send(); 
			/* END - XMLHttpRequest the posted Gig to the page when page loads */
		}
	/* END - Function to get the states where the gig posts are created */

	/**** Call getGigStates function when page loads ****/
		getGigStates();
	/* END - Call getGigStates function when page loads */

	/**** Click function to navigate back to the states page ****/
		$("#postDisplay").on("click", '.getStates', function(event){
			event.preventDefault();
			getGigStates();
		});
	/* END - Click funtion to navigate back to the states page */

	/**** Send ajax request to retrieve gig posts from specific states ****/
		$("#postDisplay").on("click", '.getCities', function(event){
			event.preventDefault();
			var state = $(this).attr('state');

			if(state != ''){
				$.ajax({
					url: "<?php echo URL; ?>views/xmlhttprequest/g_postedGigs.php?getPosts=true&state="+state,
					type: "GET",
					statusCode: {
					    404: function() {
					      alert( "page not found" );
					    }
					},
					success: function(result){
						var parsedPosts = JSON.parse(result);

						/* Show cities for available gigs */
							var showState = '<div class="Container mx-auto text-center" style="max-width:1000px">';
							showState += '<h3 class="my-3">Select A City</h3>';
							
							$.each(parsedPosts,function(theState, value0){
								showState += '<div class="row mx-5 px-md-3 font-weight-bold" style="font-size:12px"><nav aria-label="breadcrumb"><ol class="breadcrumb">';
								showState += '<li class="breadcrumb-item"><a class="getStates text-gs" href="#">'+theState+'</a></li><li class="breadcrumb-item active" aria-current="page">Cities</li>';
								showState += '</ol></nav></div>';
								showState += '<div class="row mx-5 px-md-5 font-weight-bold">';
								$.each(value0,function(theCity, value1){
									showState += '<div class="px-5 col-12 col-md-6 my-1"><a class="text-decoration-none getGigs" state="'+theState+'" city="'+theCity+'" href="#"><div class="bg-gs text-white p-2 a-prof-shadow rounded">'+theCity+'</div></a></div>';
								});
								showState += '</div>';
							});
							showState += '</div>';

							$('#postDisplay').html(showState);
					}
				});
			}
		});
	/* END - Send ajax request to retrieve gig posts from specific states */

	/**** Send ajax request to retrieve gig posts from specific cities ****/
		$("#postDisplay").on("click", '.getGigs', function(event){
			event.preventDefault(); 
			var city = $(this).attr('city');
			var state = $(this).attr('state');

			/**** If the city var is not empty send AJax requery to get gigs for that city ****/
				$.ajax({
					url: "<?php echo URL; ?>views/xmlhttprequest/g_postedGigs.php?getPosts=true&state="+state+"&city="+city, 
					type: "GET",
					statusCode: {
					    404: function() {
					      alert( "page not found" );
					    }
					},
					success: function(result){
						var gigInfoParsed = JSON.parse(result.trim()); 
						var showGigs = '<div class="container text-center px-md-5"><h3 class="my-3">Select A Gig</h3>';
								$.each(gigInfoParsed,function(theState, stateLevelArray){
									$.each(stateLevelArray,function(theCity, cityLevelArray){
										showGigs += '<div class="row mx-5 px-md-3 font-weight-bold" style="font-size:12px"><nav aria-label="breadcrumb"><ol class="breadcrumb">';
										showGigs += '<li class="breadcrumb-item"><a class="getStates text-gs" href="#">'+theState+'</a></li><li class="breadcrumb-item" aria-current="page"><a class="getCities text-gs" state="'+theState+'" href="#">'+theCity+'</a></li><li class="breadcrumb-item active" aria-current="page">Gigs</li>';
										showGigs += '</ol></nav></div>';
										showGigs += '<div class="row px-md-5">';
											showGigs += '<div class="col-10 col-md-3 mx-auto mx-md-0" style="background-color: rgba(233,236,239,1);"><div class="container py-2 rounded" style="">';
											$.each(cityLevelArray,function(theMonth, monthLevelArray){
												showGigs += '<a class="text-white text-center getMonthsGigs" state="'+theState+'" city="'+theCity+'" month="'+theMonth+'" href="#"><div class="row px-2 py-2 mb-0 bg-gs rounded"><h5 class="mb-0 mx-auto">'+theMonth+'</h5></div></a>';
												showGigs += '<hr class="my-1">'; /* Page Divider */
											});	
											showGigs += '</div></div>';

											showGigs += '<div class="col-0 col-md-9 d-none d-md-block py-2" style="min-height:300px;background-color: rgba(233,236,239,1);"><div class="container bg-white pt-2 text-center" id="showGigDiv" style="min-height:300px">';
												var j = 1; 
												$.each(cityLevelArray,function(theMonth, monthLevelArray){	
													if(j > 1){
														showGigs += '<div class="showMonthsGigs d-none" month="'+theMonth+'">';
													}
													else{
														showGigs += '<div class="showMonthsGigs" month="'+theMonth+'">';
													}
													showGigs += '<h6 class="text-gs">'+theMonth+' Gigs</h6>';
													showGigs +=	'<div class="row pt-2 text-secondary" style="font-size:12px">';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold text-truncate">Date</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold d-none d-md-block text-truncate">Name</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold d-none d-md-block text-truncate">Type</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold text-truncate">Artist</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold text-truncate">Pay</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold d-none d-md-block text-truncate">Status</div>';
													showGigs += '</div>';
													$.each(monthLevelArray,function(index, gigArray){
														showGigs += '<a href="<?php echo URL;?>views/xmlhttprequest/pubGigBackbone.php?id='+gigArray.gigId+'" target="_blank" style="text-decoration:none;"><div class="row pt-2 text-secondary hov_color" style="font-size:12px">';
															showGigs +=	'<div class="col-4 col-md-2 p-md-2 text-truncate">'+gigArray.gigDate+'</div>';
															showGigs +=	'<div class="col-md-2 p-md-2 d-none d-md-block text-truncate">'+gigArray.gigName+'</div>';
															showGigs +=	'<div class="col-md-2 p-md-2 d-none d-md-block text-truncate">'+gigArray.gigType+'</div>';
															showGigs +=	'<div class="col-4 col-md-2 p-md-2 text-truncate">'+gigArray.sGiftName+'</div>';
															showGigs +=	'<div class="col-4 col-md-2 p-md-2 text-truncate">$'+gigArray.gigPay+'</div>';
															showGigs +=	'<div class="col-md-2 p-md-2 d-none d-md-block text-truncate">'+gigArray.status+'</div>';
														showGigs += '</div></a><hr class="my-0">';
													});
													j = j + 1; 
													showGigs += '</div>';
												});
											showGigs += '</div></div></div>';
									});
								});
						showGigs += '</div>';
						$('#postDisplay').html(showGigs);
					}
				});
			/* END - If the city var is not empty send AJax requery to get gigs for that city */
		});
	/* END - Send ajax request to retrieve gig posts from specific cities */

	/**** Dismiss the gig-list-sm modal when the window is resized ****/
		$(window).resize(function(){
			$('#gig-list-sm').modal('hide');
		});
	/* END - Dismiss the gig-list-sm modal when the window is resized */	

	/* Hide Talent Search Button when Find an Artist button is clicked */
		$(document).ready(function(){
			var t = 0; 
			$('#talDropCollapser').click(function(){
				/* Hide the group type select */
					$('#groupTypeContainer').addClass('d-none');

				/* Show Upper and Lower age boundaries */
					$('#ageDiv').removeClass('d-none');

				/* Reset the form when the user collapses it */
					document.getElementById("searchCriteriaForm").reset();

				/* When the Filter Search button collapses the criteria form, return the listing of all artists to the page */
					if(t == 1){
				   		/**** Call getGigStates function when page loads ****/
							getGigStates();
						/* END - Call getGigStates function when page loads */
						t = t-1; 		
					}
				t = t + 1; 
			});	
		});	
	/* END - Hide Talent Search Button when Find an Artist button is clicked */

	/**** Get the filterred search form ****/
		$('#filteredSearch').click(function(event){
			event.preventDefault();

			/* Send Ajax request */
				$.ajax({
					url: "<?php echo URL; ?>views/xmlhttprequest/g_postedGigs.php",
					method: "POST",
					data: $('#searchCriteriaForm').serialize(),
					statusCode: {
					    404: function() {
					      alert( "page not found" );
					    }
					},
					success: function(result){
						
						var parsedFilteredData = JSON.parse(result.trim());
						console.log(parsedFilteredData);

						if(parsedFilteredData.result == 0){
							var noGigsMess = '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-3"><div class="col p-lg-3"><h2 class="" style="color: rgba(204,204,204,1)">There Are No Posted Gigs!!!</h2></div></div></div>';
							$('#postDisplay').html(noGigsMess);
						}
						else{
							var showGigs = '<div class="container text-center px-md-5"><h3 class="my-3">Select A Gig</h3>';
								showGigs += '<div class="row px-md-5">';

									showGigs += '<div class="col-10 col-md-3 mx-auto mx-md-0" style="background-color: rgba(233,236,239,1);"><div class="container py-2 rounded" style="">';
										$.each(parsedFilteredData, function(theMonth, monthLevelArray){
											showGigs += '<a class="text-white text-center getMonthsGigs" state="'+monthLevelArray.venueState+'" city="'+monthLevelArray.venueCity+'" month="'+theMonth+'" href="#"><div class="row px-2 py-2 mb-0 bg-gs rounded"><h5 class="mb-0 mx-auto">'+theMonth+'</h5></div></a>';
											showGigs += '<hr class="my-1">'; /* Page Divider */
										});
									showGigs += '</div></div>';

									showGigs += '<div class="col-0 col-md-9 d-none d-md-block py-2" style="min-height:300px;background-color: rgba(233,236,239,1);"><div class="container bg-white pt-2 text-center" id="showGigDiv" style="min-height:300px">';
										var j = 1;
										$.each(parsedFilteredData, function(theMonth, monthLevelArray){
											if(j > 1){
												showGigs += '<div class="showMonthsGigs d-none" month="'+theMonth+'">';
											}
											else{
												showGigs += '<div class="showMonthsGigs active" month="'+theMonth+'">';
											}
													showGigs += '<h6 class="text-gs">'+theMonth+' Gigs</h6>';
													showGigs +=	'<div class="row pt-2 text-secondary" style="font-size:12px">';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold text-truncate">Date</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold d-none d-md-block text-truncate">Name</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold d-none d-md-block text-truncate">Type</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold text-truncate">Artist</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold text-truncate">Pay</div>';
														showGigs +=	'<div class="col-4 col-md-2 p-md-2 font-weight-bold d-none d-md-block text-truncate">Status</div>';
													showGigs += '</div>';
													$.each(monthLevelArray,function(index, gigArray){
														showGigs += '<a href="<?php echo URL;?>views/xmlhttprequest/pubGigBackbone.php?id='+gigArray.gigId+'" target="_blank" style="text-decoration:none;"><div class="row pt-2 text-secondary hov_color" style="font-size:12px">';
															showGigs +=	'<div class="col-4 col-md-2 p-md-2 text-truncate">'+gigArray.gigDate+'</div>';
															showGigs +=	'<div class="col-md-2 p-md-2 d-none d-md-block text-truncate">'+gigArray.gigName+'</div>';
															showGigs +=	'<div class="col-md-2 p-md-2 d-none d-md-block text-truncate">'+gigArray.gigType+'</div>';
															showGigs +=	'<div class="col-4 col-md-2 p-md-2 text-truncate">'+gigArray.sGiftName+'</div>';
															showGigs +=	'<div class="col-4 col-md-2 p-md-2 text-truncate">$'+gigArray.gigPay+'</div>';
															showGigs +=	'<div class="col-md-2 p-md-2 d-none d-md-block text-truncate">'+gigArray.status+'</div>';
														showGigs += '</div></a><hr class="my-0">';
													});
													j = j + 1;
												showGigs += '</div>';
										});
									showGigs += '</div></div>';

								showGigs += '</div></div>';
							$('#postDisplay').html(showGigs);
						}	
					}
				});
		});
	/* END - Get the filterred search form */

	/* Show filtered gig search results by the month */
		$('#postDisplay').on("click",'.getMonthsGigs',function(event){
			event.preventDefault();
			var selectedMonth = $(this).attr('month');

			$('.showMonthsGigs').addClass('d-none');
			$.each($('.showMonthsGigs'),function(ind0,val0){
				if(selectedMonth == $(val0).attr('month')){
					$(val0).removeClass('d-none');
				}
			});

			/* Function according to the size of the browser window */
				var w = window.innerWidth; 
				if(w <= 768){
					var showGigs = $('#showGigDiv').html();
					$('#gigList-sm').html(showGigs);
					$('#gig-list-sm').modal();
				}
		});
</script>





