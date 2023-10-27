<?php 
	$page = 's4e';
	
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');


	/* Query the giftmaster table */
	$fetchEvents = $db->query('SELECT eventtypes.sName,eventtypes.iEventID  FROM eventtypes'); 
	$EventList = $fetchEvents->fetchAll(PDO::FETCH_ASSOC);

	/* Reduce $talentList from a 2D to 1D array */
	foreach($EventList as $Ev) {
		$EventList1D[$Ev['iEventID']] = $Ev['sName'];
	}
	asort($EventList1D);
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
            <p><a class="btn btn-lg btn-gs" href="#" role="button">Event Details</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="second-slide" src="" alt="Second slide">
        <div class="container">
          <div class="carousel-caption">
             <h1>Holder Text</h1>
            <p>A featured Top-rate Artist</p>
            <p><a class="btn btn-lg btn-gs" href="#" role="button">Event Details</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="third-slide" src="<?php echo URL; ?>newHomePage/img/1148troyBanner4.png" alt="Third slide">
        <div class="container">
          <div class="carousel-caption text-right">
             <h1>Holder Text</h1>
            <p>A featured Top-rate Artist</p>
            <p><a class="btn btn-lg btn-gs" href="#" role="button">Event Details</a></p>
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
		<div class="col-5 col-sm-3 col-lg-2 px-0"><a class="btn btn-primary m-2" id="talDropCollapser" data-toggle="collapse" href="#searchCriteria">Find an Event</a></div>
		<div class="col-5 col-sm-3 col-lg-2 px-0" id="talDrop">
			<!--<a class="btn btn-primary m-2" href="#">Sort by Talent</a> -->
			<!-- Default dropright button -->
			<div class="btn-group dropright">
			  <button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Search by Event Type
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="max-height: 500px;overflow:scroll;">
			    <a class="dropdown-item active" href="#">ALL</a>
			    <?php 
			    	foreach($EventList1D as $singleEv) {
			    		echo '<a class="dropdown-item" id="' . $singleEv . '" href="#Bassist">' . $singleEv . '</a>';  //' . $singleTal . '
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
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <input type="text" class="form-control" name="zip" placeholder="Zip Code">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!-- <input type="text" class="form-control" placeholder="What Kind of Artist?"> -->
	       <select class="custom-select" id="eventType">
	       	<option value="">What Kind of Event?</option>
	       	<?php 
		    	foreach($EventList1D as $evID => $singleEv) {
		    		echo '<option value="' . $evID . '" >' . str_replace("_", "/", $singleEv) . '</option>'; 
		    	}
		    ?>
	       </select>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!-- <input type="text" class="form-control" placeholder="Availability"> -->
	       <select class="custom-select" id="eventMonth">
		       	<option value="">Event in Month of:</option>
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
	       <input type="text" class="form-control" name="eventName" placeholder="Name of Event">
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	      <!--<input type="text" class="form-control" id="time" value="" name="time" placeholder="Service Time">-->
	       <div class="input-group date dateTime-input" id="datetimepicker1">
                <input type="text" class="form-control" name="eventDate" placeholder="Event Date" value=""/> 
                <?php 
                	$today = date_create(date());
				    $today = date_format($today, "Y-m-d"); 
                ?>
                <input type="hidden" name="todaysDate" value="<?php echo $today; ?>">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	    </div>
	    <div class="col-12 col-sm-6 col-lg-4 mt-2">
	    	<div class="input-group date dateTime-input" id="datetimepicker2">
                <input type="text" class="form-control" name="eventTime" placeholder="Event Time" value=""/> 
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
	    </div>
	  </div>
	  <button type="button" class="btn btn-gs" id="searchArtist">Search</button>
	</form>
</div><!-- /Artist Criteria Section -->

<hr class="my-4"> <!-- Page Divider -->

<div id="eventDisplay"></div><!-- Artist Display Div --> 


<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
	/* XMLHttpRequest the Artist Content to the page */
	
	var displayEvent = new XMLHttpRequest(); 
	displayEvent.onreadystatechange = function(){
		if(displayEvent.status == 200 && displayEvent.readyState == 4){
			document.getElementById('eventDisplay').innerHTML = displayEvent.responseText; 
		}
	}
	displayEvent.open('GET', 'xmlhttprequest/search4eventContent.php');
	displayEvent.send(); 

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
				var displayEvent1 = new XMLHttpRequest(); 
		   		displayEvent1.onreadystatechange = function(){
		   			if(displayEvent1.status == 200 && displayEvent1.readyState == 4){
		   				document.getElementById('eventDisplay').innerHTML = displayEvent1.responseText; 
		   			}
		   		}
		   		displayEvent1.open('GET', 'xmlhttprequest/search4eventContent.php');
		   		displayEvent1.send(); 

				t = t-1; 
			}			
		});	
	});	


	$("#searchArtist").click(function(event){
		event.preventDefault(); 

		var param1 = $('#state').val();
		var param2 = $('input[name=city]').val(); 
		var param3 = $('input[name=zip]').val(); 
		var param4 = $('#eventType').val();
		var param5 = $('#eventMonth').val(); 
		var param6 = $('input[name=eventName]').val(); 
		var param7 = $('input[name=eventDate]').val(); 
		var param8 = $('input[name=eventTime]').val(); 

		var formData = new FormData(); 
		formData.append('state', param1); 
		formData.append('name', param2);
		formData.append('zipcode', param3);
		formData.append('sType', param4);
		formData.append('eMonth', param5); 
		formData.append('event_name', param6);
		formData.append('doe', param7);
		formData.append('toe', param8);
		
		var sendSearch = new XMLHttpRequest(); 
		sendSearch.onreadystatechange = function(){
			if(sendSearch.status == 200 && sendSearch.readyState == 4){
				document.getElementById('eventDisplay').innerHTML = sendSearch.responseText;
			}
		}
		sendSearch.open("POST", "xmlhttprequest/search4eventContent.php");
		sendSearch.send(formData); 
});
$(function () {
	var dat = $("input[name=todaysDate]").val();
	
    $("#datetimepicker1").datetimepicker({
	 	format: "MM/DD/YYYY",
	 	//defaultDate: "12/13/2017",
	 	minDate: dat,
	 	//minDate: moment(),
	 	maxDate: moment().add(1,'year'),
	 	//useCurrent: true, 
	 	allowInputToggle: true
	 });
    $("#datetimepicker2").datetimepicker({
        format: "LT",
        stepping: "5",
        useCurrent: false,
        allowInputToggle: true
    });		
});
</script>
</body>
</html>