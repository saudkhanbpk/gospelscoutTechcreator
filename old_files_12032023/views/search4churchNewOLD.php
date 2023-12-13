<?php 
	$page = 's4c';
	
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Query the denominationmaster table */
	$fetchDenoms = $db->query('SELECT denominationmaster.name FROM denominationmaster'); 
	$denomList = $fetchDenoms->fetchAll(PDO::FETCH_ASSOC);

	/* Reduce $denomList from a 2D to 1D array */
	foreach($denomList as $denom) {
		$denomList1D[] = ucfirst(str_replace("_","-",$denom['name']));
	}
	sort($denomList1D);

	/* Query giftmaster1 table */
	$fetchMinistries = $db->query('SELECT giftmaster1.sGiftName FROM giftmaster1'); 
	$ministryList = $fetchMinistries->fetchAll(PDO::FETCH_ASSOC);

	/* Reduce $denomList from a 2D to 1D array */
	foreach($ministryList as $ministry) {
		$ministryList1D[] = str_replace("_"," ",$ministry['sGiftName']);
	}
	sort($ministryList1D);
	//echo '<pre>';
	//var_dump($ministryList1D);

	/* Query amenitimaster table */
	$fetchAmenities = $db->query('SELECT amenitimaster.iAmityID, amenitimaster.sAmityName FROM amenitimaster'); 
	$amenityList = $fetchAmenities->fetchAll(PDO::FETCH_ASSOC);
	//echo '<pre>';
	//var_dump($amenityList);
	/* Reduce $denomList from a 2D to 1D array */
	foreach($amenityList as $amenity) {
		$amenityList1D[$amenity['iAmityID']] = str_replace("_"," ",$amenity['sAmityName']);
	}
	//var_dump($amenityList1D);

	$amenityList1D2 = $amenityList1D;
	asort($amenityList1D);
	//var_dump($amenityList1D);
	
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
        <img class="first-slide" src="<?php echo URL; ?>img/BusinessCardCollage2.png" alt="First slide"> <!-- data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw== -->
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
        <img class="third-slide" src="<?php echo URL; ?>img/1148troyBanner4.png" alt="Third slide">
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
		<div class="col-5 col-sm-3 col-lg-2 px-0"><a class="btn btn-primary m-2" id="talDropCollapser" data-toggle="collapse" href="#searchCriteria">Find a Church</a></div>
		<div class="col-5 col-sm-3 col-lg-2 px-0" id="talDrop">
			<!--<a class="btn btn-primary m-2" href="#">Sort by Talent</a> -->
			<!-- Default dropright button -->
			<div class="btn-group dropright">
			  <button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Search by Denomination
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="max-height: 500px;overflow:scroll;">
			    <a class="dropdown-item active" href="#">ALL</a>
			    <?php 
			    	foreach($denomList1D as $singleDenom) {
			    		echo '<a class="dropdown-item" id="' . $singleDeom . '" href="#">' . $singleDenom . '</a>';  //' . $singleTal . '
			    	}
			    ?>
			  </div>
			</div><!-- /Default dropright button -->
		</div>
	</div>
</div>

<div class="container mt-3 collapse" id="searchCriteria">
	<!-- Search Criteria Form -->
	<form id="searchCriteriaForm">
	  <div class="row form-group">
	  	 <div class="col-12 col-sm-6 col-lg-3 mt-2">
	    	<input type="text" class="form-control" name="streetAddress" placeholder="Street Address">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-3 mt-2">
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
	    <div class="col-12 col-sm-6 col-lg-3 mt-2">
	      <input type="text" class="form-control" name="city" placeholder="City">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-3 mt-2">
	      	<input type="text" class="form-control" name="zip" placeholder="Zip Code">
	    </div>
	    
	    <div class="col-12 col-sm-6 col-lg-3 mt-2" id="ministryContainer">
	    	<h5>Ministries</h5>
	    	<div class="form-check border card-text-size-gs py-2" style="max-height: 150px;overflow:scroll;" >
	    		<?php 
	    			$i = 0; 
	    			foreach($ministryList1D as $ministry){ 
	    		?>
		    		<div class="ml-3"> <!--  -->
				    	 <input class="form-check-input ministries" name="ministries[]" type="checkbox"  value="<?php echo $ministry;?>" id="ministryCheck<?php echo $i;?>">
						 <label class="form-check-label" for="ministryCheck<?php echo $i;?>">
						    <?php echo $ministry;?>
						 </label>
					</div>
				<?php 
						$i += 1; 
					} 
				?>
	  		</div>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-3 mt-2">
	    	<h5>Amenities</h5>
	    	<div class="form-check border card-text-size-gs py-2" style="max-height: 150px;overflow:scroll;" >
	    		<?php 
	    			$j = 0; 
	    			foreach($amenityList1D as $amenIndex => $amenity){ 
	    		?>
	    		<div class="ml-3">
			    	 <input class="form-check-input amenities" type="checkbox" name="amenities[]" value="<?php echo $amenIndex;?>" id="amenityCheck<?php echo $j;?>">
					 <label class="form-check-label" for="amenityCheck<?php echo $j;?>">
					    <?php echo $amenity;?>
					 </label>
				</div>
				<?php 
						$j += 1; 
					} 
				?>
	  		</div>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-6 mt-2">
	    	<h5>Service Times</h5>
	    	<div class="row">
		    	<div class="col-12 col-sm-6 col-lg-6 mt-2">
			      <!-- <input type="text" class="form-control" placeholder="City">-->
			       <select class="custom-select" id="day">
			       	<option value="">Day</option>
			       	<option value="Sunday">Sunday</option>
			       	<option value="Monday">Monday</option>
			       	<option value="Tuesday">Tuesday</option>
			       	<option value="Wednesday">Wednesday</option>
			       	<option value="Thursday">Thursay</option>
			       	<option value="Friday">Friday</option>
			       	<option value="Saturday">Saturday</option>
			       </select>
			    </div>
			   
			  
			    <div class="col-12 col-sm-6 col-lg-6 mt-2">
			      <!--<input type="text" class="form-control" id="time" value="" name="time" placeholder="Service Time">-->
			       <div class="input-group date dateTime-input" id="datetimepicker1">
	                    <input type="text" class="form-control" name="serviceTime" placeholder="Service Time" value=""/> 
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-time"></span>
	                    </span>
	                </div>
			    </div>
			</div>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-3 mt-2">
	       <select class="custom-select" id="denomination">
	       	<option value="">Denomination</option>
			    <?php 
			    	foreach($denomList1D as $singleDenom) {
			    		//echo '<option value="' . $singleDeom . '">' . $singleDenom . '</option>';  
			    ?>
			    		<option value="<?php echo $singleDenom;?>" ><?php echo $singleDenom;?></option> 
			    <?php
			    	}
			    ?>
	       </select>
	    </div>
	  </div>
	  <h5 class="text-gs">OR</h5>
	  Looking for a Specific Church or Pastor? 
	    <div class="row form-group">
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="ChurchName" placeholder="Church Name">
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="FirstName" placeholder="Pastor's First Name">
		    </div>
		    <div class="col-12 col-sm-6 col-lg-4 mt-2">
		      <input type="text" class="form-control" name="LastName" placeholder="Pastor's Last Name">
		    </div>
		</div>
	  <button type="button" class="btn btn-gs" id="searchChurch">Search</button>
	</form><!-- /Search Criteria Form -->
</div><!-- /Artist Criteria Section -->

<hr class="my-4"> <!-- Page Divider -->


<div id="churchDisplay"></div><!-- Artist Display Div --> 



<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script>
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
	/* XMLHttpRequest the Artist Content to the page */
	var displaychurch = new XMLHttpRequest(); 
	displaychurch.onreadystatechange = function(){
		if(displaychurch.status == 200 && displaychurch.readyState == 4){
			document.getElementById('churchDisplay').innerHTML = displaychurch.responseText; 
		}
	}
	displaychurch.open('GET', 'xmlhttprequest/search4churchContent.php');
	displaychurch.send(); 

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
				var displaychurch1 = new XMLHttpRequest(); 
		   		displaychurch1.onreadystatechange = function(){
		   			if(displaychurch1.status == 200 && displaychurch1.readyState == 4){
		   				document.getElementById('churchDisplay').innerHTML = displaychurch1.responseText; 
		   			}
		   		}
		   		displaychurch1.open('GET', 'xmlhttprequest/search4churchContent.php');
		   		displaychurch1.send(); 

				t = t-1; 
			}			
		});	
	});	


	$("#searchChurch").click(function(event){
		event.preventDefault(); 

		var param1 = $('input[name=streetAddress').val();
		var param2 = $('#state').val();
		var param3 = $('input[name=city]').val(); 
		var param4 = $('input[name=zip]').val(); 
		//var param5 = $('input[name=ministries').val();
		var cbSet1=[]; 
		$('.ministries:checked').each(function(){
		 	cbSet1.push($(this).val());
		});
		var param5 = cbSet1; 
		var cbSet2=[];
		$('.amenities:checked').each(function(){
			cbSet2.push($(this).val());
		});
		var param6 = cbSet2; 
		var param7 = $('#day').val(); 
		var param8 = $('input[name=serviceTime]').val();
		var param9 = $('#denomination').val(); 
		var param10 = $('input[name=ChurchName]').val(); 
		var param11 = $('input[name=FirstName]').val(); 
		var param12 = $('input[name=LastName]').val(); 
		
		
		console.log(cbSet1);
		console.log(cbSet2);

		var formData = new FormData(); 
		formData.append('sAddress', param1);
		formData.append('sStateName', param2); 
		formData.append('name', param3);
		formData.append('iZipcode', param4);
		formData.append('sMinistryNames', param5);
		formData.append('amenityID', param6);
		formData.append('sTitle', param7); 
		formData.append('serviceTime', param8); 
		formData.append('sDenomination', param9);
		formData.append('sChurchName', param10);
		formData.append('sPastorFirstName', param11);
		formData.append('sPastorLastName', param12);
		
		
		
		var sendSearch = new XMLHttpRequest(); 
		sendSearch.onreadystatechange = function(){
			if(sendSearch.status == 200 && sendSearch.readyState == 4){
				document.getElementById('churchDisplay').innerHTML = sendSearch.responseText;
			}
		}
		sendSearch.open("POST", "xmlhttprequest/search4churchContent.php");
		sendSearch.send(formData); 
});
$(function () {
	var dat = $("input[name=todaysDate]").val();
	console.log(dat);
	
    $("#datetimepicker1").datetimepicker({
        format: "LT",
        stepping: "5",
        useCurrent: false,
        allowInputToggle: true
    });			 
});
</script>