<?php 
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	/* Query the database using specific user criteria */
	if(!empty($_POST)){
		foreach($_POST as $index => $criteria){

			/* Validate Certain input fields from the search form  */
				if($criteria !== "" && $criteria !== "undefined"){
					if($index == "zipcode") {
						if(strlen(intval(trim($criteria))) !== 5) {
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid Zip Code!!!</h5></div>';
							exit; 
						} 
						else{
							$newCriteriaArray[$index] = intval(trim($criteria)); 
						}
					}
					elseif($index == "event_name" || $index == "name") {
						$criteria = trim($criteria);
						$alphaTest = str_replace(" ","",$criteria); 
						if(!ctype_alpha($alphaTest)){
							if($index == "event_name"){
								echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter a Valid Event Name!!!</h5></div>'; 
								exit;
							}
							else{
								echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter a Valid City!!!</h5></div>'; 
								exit;
							}
						}
						else{
							$newCriteriaArray[$index] = trim($criteria); 
						}
					}				
					else{
						$newCriteriaArray[$index] = trim($criteria); 
					}
				}
			/* END - Validate Certain input fields from the search form  */
		}
		
		/* Check if the Date fields and Month Fields Match - If not, Display an error message */
		if($newCriteriaArray['doe'] && $newCriteriaArray['eMonth']){
			$M = $newCriteriaArray['eMonth'];
			$D = substr($newCriteriaArray['doe'], 0, 2);
			if($M !== $D){
				echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>The Date Field and Month Field Selected Do Not Match!!!</h5></div>'; 
				exit;
			}
		}
	}

	if(count($newCriteriaArray) !== 0 && $newCriteriaArray !== null){	

		/* ReFormat the doe and toe parameters be they are passed as bind parameters */
			if(!empty($newCriteriaArray['doe'])){
				$newCriteriaArray['doe'] = date_create($newCriteriaArray['doe']);
				$newCriteriaArray['doe'] = date_format($newCriteriaArray['doe'], "Y-m-d");
			}
			
			if(!empty($newCriteriaArray['toe'])){
				$newCriteriaArray['toe'] = date_create($newCriteriaArray['toe']);
				$newCriteriaArray['toe'] = date_format($newCriteriaArray['toe'], "H:i:s");
			}
		/* END - ReFormat the doe and toe parameters be they are passed as bind parameters */
			
		/* Event Search Query statement */	
			$eventSearchQuery = "SELECT eventmaster.*,  cities.name, states.statecode, eventtypes.sName
								  FROM eventmaster
								  INNER JOIN cities on eventmaster.city = cities.id
								  INNER JOIN states on eventmaster.state = states.id
								  INNER JOIN eventtypes on eventmaster.sType = eventtypes.iEventID
								  WHERE eventmaster.isActive = 1 AND ";
		/* END - Event Search Query statement */	

		/* Use a loop to determine the Bind Parameters based on user input */	
			$i = 1; 
			$j = count($newCriteriaArray);							  
			foreach($newCriteriaArray as $index => $criteria){
				if($i == $j){
					if($index == "name"){
						$eventSearchQuery .= 'cities.' . $index . ' = :' . $index;
					}
					else{
						$eventSearchQuery .= 'eventmaster.' . $index . ' = :' . $index; 
					}
				}
				else{
					if($index == "name"){
						$eventSearchQuery .= 'cities.' . $index . ' = :' . $index . ' AND ';
					}
					else{
						$eventSearchQuery .= 'eventmaster.' . $index . ' = :' . $index . ' AND ';
					}
				}
				
				$bindParam[] = ':' . $index . ',' . $criteria; 
				$i += 1; 
			}
		/* END - Use a loop to determine the Bind Parameters based on user input */	
		
		/* Execute the Query statement and return array of results if any are available */
			try{
				$searchResults = $db->prepare($eventSearchQuery);
				foreach($bindParam as $param){
					$newParam = explode(",", $param);
					$searchResults->bindParam($newParam[0], $newParam[1]); 
				} 
				$searchResults->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$output = $searchResults->fetchAll(PDO::FETCH_ASSOC); 
		/* END - Execute the Query statement and return array of results if any are available */
		
		/* Check if there were results returned from the database - If not, display message and exit */
			if(count($output) > 0) {	
				/* Create an array of all the eventtypes that were returned in the search results */
					foreach($output as $value){
						foreach($value as $index => $value1){
							if($index == 'sName'){
								$eventlist[] = $value1;
							}
						}
					}
					$eventlist = array_unique($eventlist);
				 	sort($eventlist);
					
					foreach($eventlist as $evlist){
						foreach($output as $value2){
							if($value2['sName'] == $evlist){
								$events[$evlist][] = $value2; 
							}
						}
					}
				/* END - Create an array of all the eventypes that were returned in the search results */
			}
			else{
				echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, There Are Currently No Events Matching this Search Criteria!!!</h5></div>';
				exit;
			}
		/* END - Check if there were results returned from the database - If not, display message and exit */
	}
	else{
		
		/* Query the giftmaster table */
		$fetchEvents = $db->query('SELECT eventtypes.sName, eventtypes.iEventID FROM eventtypes'); 
		$EventList = $fetchEvents->fetchAll(PDO::FETCH_ASSOC);

		/* Reduce $talentList from a 2D to 1D array */
		foreach($EventList as $Ev) {
			$EventList1D[$Ev['iEventID']] = $Ev['sName'];
		}
		asort($EventList1D);
		
		$eventList = "SELECT eventmaster.*, cities.name, states.statecode, eventtypes.sName  
					  FROM eventmaster
					  INNER JOIN cities on cities.id = eventmaster.city
					  INNER JOIN states on states.id = eventmaster.state 
					  INNER JOIN eventtypes  on  eventtypes.iEventID = eventmaster.sType
					  WHERE eventmaster.isActive = 1 AND eventmaster.sType = ?";
		/* END - Form query statement */

			/* Use PDO statement to do relational query for artists under each talent*/			   
			foreach($EventList1D as $index => $event) {
					$results = $db->prepare($eventList); 
					$results->bindParam(1, $index);
					$results->execute(); 
					$list =  $results->fetchAll(PDO::FETCH_ASSOC); 
					
					if(!empty($list)) {				    						
						$events[$event]= $list; 				    						
					}	
			}
			if(count($events) == 0){
				echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, There Are Currently No Events!!!</h5></div>';
				exit;
			} 
	}		
?>
<!-- Artist Display on Xtra Small Screens -->
<div class="container d-sm-none">
	<!-- Determine # of talent Divider Containers -->
	<?php 
		$a=0;
		foreach($events as $evContainerTitle => $evContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $talContainerTitle;?>"> 
	  		<h4><?php echo str_replace("_","/",$evContainerTitle);?></h4>
	      	<div id="carouselExampleControls_S<?php echo $a;?>" class="carousel slide p-0" data-ride="" >
			  <div class="carousel-inner pb-0 mb-0 " style="height: 250px; ">				   
			  	<!-- Carousel Slide -->
				  	<!-- Determine # of slides -->
					  	<?php 
					  		$chunkedArray = array_chunk($events[$evContainerTitle], 1);
			  				$numbSlides = count($chunkedArray);
			  				
				  			/* For loop to create the necessary # of slides */
				  			for($i=0; $i<$numbSlides;$i++){	 
				  		?>
					    <div class="carousel-item <?php if($i==0){echo 'active';} ?> my-0 p-0 bg-white" style="width:83%; margin: 10px auto; height: 250px" >

					    	<!-- Card Deck -->
					    	<div class="card-deck my-0">						    		
					    		<!-- Card Duplication -->
					    		<?php 
					    			/* For loop to display */
					    			foreach($chunkedArray[$i] as $eventCard){
					    		?>
					    			<!-- Card Info -->
							    	<div class="card p-2 mb-0" style="width: 175px;margin:auto">
									  <img class="card-img-top d-block" style="object-fit:cover; object-position:0,0;" src="<?php echo URL;?>upload/event/multiple/<?php echo $eventCard['sMultiImage'];?>" width="100px" height="100px" alt="Card image cap">
									  <div class="card-body p-0 pt-0" style="min-height: 90px">
									  	<!-- Truncation Code for church names, pastor names, & addresses that are too long!!! -->
											<?php
												$timeDate = $eventCard['doe'] . ', ' . $eventCard['toe'];

												$eventNameLength = strlen($eventCard['event_name']);
												$eSponsorNameLength = strlen($eventCard['eSponsor']);
												$timeDateLength = strlen($timeDate);
												$priceLength = strlen($eventCard['amount_deposite']);												
												$cityNameLength = strlen($eventCard['name']);
										  		if($eventNameLength>13) {
										  			$eventCard['event_name'] = substr_replace($eventCard['event_name'], '...', 11);  
										  		}
										  		if($eSponsorNameLength > 17) {
										  			$eventCard['eSponsor'] = substr_replace($eventCard['eSponsor'], '...', 14); 
										  		}
										  		if($timeDateLength > 17) {
										  			$timeDate = substr_replace($timeDate, '...', 14); 
										  		}
										  		if($priceLength > 24) {
										  			$eventCard['amount_deposite'] = substr_replace($eventCard['amount_deposite'], '...', 19); 
										  		}
										  		if($cityNameLength > 11) {
										  			$eventCard['name'] = substr_replace($eventCard['name'], '...', 7); 
										  		}
									  		?>
									  		<!-- /Truncation Code for church names, pastor names, & addresses that are too long!!! -->
										    <h5 class="card-title p-0 m-0"><?php echo $eventCard['event_name'];?></h5>
										    <ul class="list-unstyled card-text-size-gs">
										    	<!-- <li><?php echo $eventCard['eSponsor']; ?></li> -->
										    	<li><?php echo str_replace("_","/",$timeDate);?></li>
										    	<li class="<?php if($eventCard['amount_deposite'] == 0){echo 'text-gs';}?>"><?php if($eventCard['amount_deposite'] > 0){echo '$' . $eventCard['amount_deposite'];}else{echo 'FREE!!!';} ?></li>
										    	<li><?php echo $eventCard['name'] . ', ' . $eventCard['statecode'];?></li>
										    </ul>

									  </div>
									  <!-- footer -->
									  <div class="card-footer p-0 pt-1 text-center mt-0 bg-none" style="background-color: none">
									    <a href="#" class="btn btn-primary btn-sm btn-gs">View Event</a>
									  </div><!-- /footer -->
									</div><!-- /Card Info -->
								<?php 
									}
								?>
							 </div><!-- /Card Deck --> 
					    </div><!-- /Carousel Slide -->
			    <?php 
			    	}
			    ?>
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleControls_S<?php echo $a;?>" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon bg-gs" aria-hidden="true"></span> 
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleControls_S<?php echo $a;?>" role="button" data-slide="next">
			    <span class="carousel-control-next-icon bg-gs" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div><!-- /talent divider -->
	<?php 
		$a++;
		}
	?>
</div><!-- /Artist Display on Xtra Small Screens -->

<!-- Artist Display on Small & Medium Screens -->
<div class="container d-none d-sm-block d-lg-none">
	<!-- Determine # of talent Divider Containers -->
	<?php 
		$b=0;
		foreach($events as $evContainerTitle => $evContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $talContainerTitle;?>" style=""> 
	  		<h4><?php echo str_replace("_","/",$evContainerTitle);?></h4>
	      	<div id="carouselExampleControls_M<?php echo $b;?>" class="carousel slide mb-3" data-ride="carousel" style="height:250px" >
			  <div class="carousel-inner pb-0 mb-0 " style="height:250px">				   
			  	<!-- Carousel Slide -->
				  	<!-- Determine # of slides -->
				  	<?php 
				  		$chunkedArray = array_chunk($events[$evContainerTitle], 3);
			  			$numbSlides = count($chunkedArray);
			  			
			  			/* For loop to create the necessary # of slides */
			  			for($i=0; $i<$numbSlides;$i++){	 
			  		?>
					    <div class="carousel-item <?php if($i==0){echo 'active';} ?> pt-0 bg-white" style="width:83%; margin: 0 auto;height:250px" >
					    	<!-- Card Row -->
					    	<div class="row px-3 mt-0 mb-0">
					    		<!-- Card Duplication -->
					    		<?php 
					    			/* For loop to display */
					    			foreach($chunkedArray[$i] as $eventCard){
					    		?>
					    			<!-- Card Info -->
					    			<div class="col-4  px-2">
								    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
										  <img class="card-img-top d-block" style="object-fit:cover; object-position:0,0;" src="<?php echo URL;?>upload/event/multiple/<?php echo $eventCard['sMultiImage'];?>" width="45px" height="110px" alt="Card image cap">
										  <div class="card-body p-0" style="min-height: 90px">
										  	<!-- Truncation Code for church names, pastor names, & addresses that are too long!!! -->
											<?php
												$timeDate = $eventCard['doe'] . ', ' . $eventCard['toe'];

												$eventNameLength = strlen($eventCard['event_name']);
												$eSponsorNameLength = strlen($eventCard['eSponsor']);
												$timeDateLength = strlen($timeDate);
												$priceLength = strlen($eventCard['amount_deposite']);												
												$cityNameLength = strlen($eventCard['name']);
										  		if($eventNameLength>13) {
										  			$eventCard['event_name'] = substr_replace($eventCard['event_name'], '...', 7);  
										  		}
										  		if($eSponsorNameLength > 17) {
										  			$eventCard['eSponsor'] = substr_replace($eventCard['eSponsor'], '...', 11); 
										  		}
										  		if($timeDateLength > 17) {
										  			$timeDate = substr_replace($timeDate, '...', 11); 
										  		}
										  		if($priceLength > 24) {
										  			$eventCard['amount_deposite'] = substr_replace($eventCard['amount_deposite'], '...', 19); 
										  		}
										  		if($cityNameLength > 11) {
										  			$eventCard['name'] = substr_replace($eventCard['name'], '...', 5); 
										  		}
									  		?>
									  		<!-- /Truncation Code for church names, pastor names, & addresses that are too long!!! -->
										    <h5 class="card-title p-0 m-0"><?php echo $eventCard['event_name'];?></h5>
										    <ul class="list-unstyled card-text-size-gs">
										    	<li><?php echo $eventCard['eSponsor']; ?></li>
										    	<li><?php echo str_replace("_","/",$timeDate); ?></li>
										    	<li class="<?php if($eventCard['amount_deposite'] == 0){echo 'text-gs';}?>"><?php if($eventCard['amount_deposite'] > 0){echo '$' . $eventCard['amount_deposite'];}else{echo 'FREE!!!';} ?></li>
										    	<li><?php echo $eventCard['name'] . ', ' . $eventCard['statecode'];?></li>
										    </ul>

										  </div>
										  <!-- footer -->
										  <div class="card-footer p-0 pt-1 text-center mt-1">
										    <a href="#" class="btn btn-primary btn-sm btn-gs">View Event</a>
										  </div><!-- /footer -->
										</div> 
									</div><!-- /Card Info -->
								<?php 
									}
								?>
								<!-- /Card Duplication -->
							 </div> <!-- /Card Row -->
					    </div><!-- /Carousel Slide -->
			    <?php 
			    	}
			    ?>
			    
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleControls_M<?php echo $b;?>" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon bg-gs" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleControls_M<?php echo $b;?>" role="button" data-slide="next">
			    <span class="carousel-control-next-icon bg-gs" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div><!-- /talent divider -->
	<?php 
		$b++;
		}
	?>
</div><!-- /Artist Display on Small & Medium Screens -->

<!-- Artist Carousel Display on Large Screens -->
<div class="container d-none d-lg-block" style="width:100%">
	<!-- Determine # of talent Divider Containers -->
	<?php 
		
		echo $c;
		foreach($events as $evContainerTitle => $evContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $evContainerTitle;?>"> 
	  		<h4><?php echo str_replace("_","/",$evContainerTitle);?></h4>
	      	<div id="carouselExampleControls_L<?php echo $c;?>" class="carousel slide mb-3" style="background-image: url();height: 250px;" data-ride="" >
			  <div class="carousel-inner pb-0 mb-0 " style="height: 250px; ">
			  	<!-- Carousel Slide -->
			  		<!-- Determine # of slides -->
			  		<?php 
			  			$chunkedArray = array_chunk($events[$evContainerTitle], 4);
			  			$numbSlides = count($chunkedArray);
			  			
			  			/* For loop to create the necessary # of slides */
			  			for($i=0; $i<$numbSlides;$i++){	 
			  		?>
					    <div class="carousel-item <?php if($i==0){echo 'active';} ?> pt-0 bg-white" style="width:83%; margin: 0 auto;height: 250px; " >
					    	<!-- Card Info -->
					    	<div class="row  px-3 mt-0 mb-0">
					    		<!-- Card Duplication -->
					    		<?php 
					    			/* For loop to display */
					    			foreach($chunkedArray[$i] as $eventCard){
					    		?>
					    			<div class="col-3 px-4">
								    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
								    	<!-- link to artist's profile pic -->
										  <img class="card-img-top d-block mb-0" style="object-fit:cover; object-position:0,0;" src="<?php echo URL;?>upload/event/multiple/<?php echo $eventCard['sMultiImage'];?>" width="45px" height="110px" alt="Card image cap">
										<!-- /link to artist's profile pic -->
										  <div class="card-body p-0" style="min-height: 90px">
										  	<!-- Truncation Code for church names, pastor names, & addresses that are too long!!! -->
											<?php
												$timeDate = $eventCard['doe'] . ', ' . $eventCard['toe'];												
												$eventNameLength = strlen($eventCard['event_name']);
												$eSponsorNameLength = strlen($eventCard['eSponsor']);
												$timeDateLength = strlen($timeDate);
												$priceLength = strlen($eventCard['amount_deposite']);												
												$cityNameLength = strlen($eventCard['name']);
										  		if($eventNameLength>13) {
										  			$eventCard['event_name'] = substr_replace($eventCard['event_name'], '...', 11);  
										  		}
										  		if($eSponsorNameLength > 17) {
										  			$eventCard['eSponsor'] = substr_replace($eventCard['eSponsor'], '...', 14); 
										  		}
										  		if($timeDateLength > 17) {
										  			$timeDate = substr_replace($timeDate, '...', 14); 
										  		}
										  		if($priceLength > 24) {
										  			$eventCard['amount_deposite'] = substr_replace($eventCard['amount_deposite'], '...', 22); 
										  		}
										  		if($cityNameLength > 11) {
										  			$eventCard['name'] = substr_replace($eventCard['name'], '...', 7); 
										  		}
									  		?>
									  		<!-- /Truncation Code for church names, pastor names, & addresses that are too long!!! -->
										    <h5 class="card-title p-0 m-0"><?php echo $eventCard['event_name'];?></h5>
										    <p class="card-text d-none card-text-size-gs">example Text</p>
										    <ul class="list-unstyled card-text-size-gs">
										    	<li><?php echo $eventCard['eSponsor']; ?></li>
										    	<li><?php echo str_replace("_","/",$timeDate); ?></li>
										    	<li class="<?php if($eventCard['amount_deposite'] == 0){echo 'text-gs';}?>"><?php if($eventCard['amount_deposite'] > 0){echo '$' . $eventCard['amount_deposite'];}else{echo 'FREE!!!';} ?></li>
										    	<li><?php echo $eventCard['name'] . ', ' . $eventCard['statecode'];?></li>
										    </ul>
		 									
										  </div>
										  <div class="card-footer p-0 pt-1 text-center">
										    	<a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $eventCard['iLoginID'];?>" class="btn mb-0 btn-primary btn-sm btn-gs">View Event</a><!-- link to the artist's profile -->
										  	</div>
										</div> 
									</div>
								<?php
									}
								?>
								<!-- /Card Duplication -->   	
							 </div> <!-- /Card Row -->
					    </div><!-- /Carousel Slide -->
			    <?php 
			    	}
			    ?>
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleControls_L<?php echo $c;?>" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon bg-gs" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleControls_L<?php echo $c;?>" role="button" data-slide="next">
			    <span class="carousel-control-next-icon bg-gs" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
			 <hr class="my-1">
		</div><!-- /talent divider -->
	<?php 
		$c++;
		}
	?>
</div><!-- /Artist Carousel Display On Large Screens -->



<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="<?php echo URL;?>js/jquery-1.11.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="https://dev.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://dev.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
   <!-- <script src="https://dev.gospelscout.com/twbs/bootstrap/assets/js/vendor/holder.min.js"></script> -->