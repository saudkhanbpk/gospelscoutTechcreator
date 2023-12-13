<?php
	/* Require the Header */
		// require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/home/include/header.php');

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Check that the user is logged in */
		if($currentUserID == ''){
?>
			<input type="hidden" name="loggedIn" value="false">
			<!--<script> 
                window.location.href = 'https://www.stage.gospelscout.com/index.php';
            </script>-->
<?php
			// echo 'Please Log In!!!';
			// exit; 
		}
?>

<style>
	.hov_color:hover {
		background-color: rgba(203,163,211,1);
	}
</style>

<!--  Add style sheet -->
<link href="<?php echo URL; ?>artist/css/indexCss.css" rel="stylesheet">


<!-- Main Page Carousel -->
<!--<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="first-slide" src="<?php echo URL; ?>img/BusinessCardCollage2.png" alt="First slide"> 
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Find A Gig Today!!!</h1>
            <p>Start Playing...Start Singing...Start Performing...NOW!!!</p>
          </div>
        </div>
      </div>
</div>--> <!-- /Main Page Carousel -->

<div class="container-fluid bg-gs mt-0 py-0 text-center text-white" style="width:100%">
      <div class="row" id="layer2">
        <div class="col-12  py-5" id="layer3">
          
          <div class="container py-3">
            <div class="row">
              <div class="col-12 col-md-10 pt-3  mx-auto">

                <h2 class="text-center">Find A Gig Today!</h2>
                <p style="font-size:.8em;color:rgba(255,255,255,.5)">Start Playing...Start Singing...Start Performing...NOW!</p>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

<div class="container mt-4">
	 <div class="container text-center text-gs mb-5">
		<h1 class="font-weight-bold">Find Posted Gigs</h1>
    </div>

    <div class="row" id="showFSearch">
		<div class="col-5 col-sm-3 col-lg-2 px-0"><a class="btn btn-gs m-2" id="talDropCollapser" data-toggle="collapse" href="#searchCriteria">Filter Search</a></div>
	</div>
</div>

<div class="container mt-3 collapse" id="searchCriteria">
	<form id="searchCriteriaForm" name="getPosts">
		<span class="text-gs font-weight-bold">Location</span>
		<div class="row form-group">
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		       <?php 
		      	$states = $obj->fetchRowAll("states",'country_id = 231', $db); 
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
			      	$a_types = $obj->fetchRowAll("giftmaster",'isActive = 1',$db); 
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
			      	$group_types = $obj->fetchRowAll("grouptypemaster",'isActive = 1',$db); 
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
			      	$g_types = $obj->fetchRowAll("eventtypes",'isActive = 1',$db); 
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
		          <div class="checkbox container p-0" id="postDisplay-sm"> </div>
		        </div>
		        <!-- /Modal Footer -->
	      </div>
	    </div>
	</div>
<!-- /Modal to display gigs on small screen -->

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/postedGigsJSFunctions.js?4"></script> 
<script src="<?php echo URL;?>js/postedGigsJS.js?8"></script> 





