<?php 
	
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');


	/* Query the database using specific user criteria */
	if(!empty($_POST)){
			
		foreach($_POST as $index => $criteria){
			/* Backend validation for text-field inputs */
			if($criteria !== "" && $criteria !== "undefined"){
				if($index == "iZipcode") {
					if(strlen(intval(trim($criteria))) !== 5) {
						echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid Zip Code!!!</h5></div>';
						exit; 
					} 
					else{
						$newCriteriaArray[$index] = intval(trim($criteria)); 
					}
				}
				elseif($index == "sPastorFirstName" || $index == "sPastorLastName" || $index == "name") {
					$criteria = trim($criteria);
					$alphaTest = str_replace(" ","",$criteria); 
					if(!ctype_alpha($alphaTest)){
						if($index == "sPastorFirstName" || $index == "sPastorLastName"){
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter a Valid Name!!!</h5></div>'; 
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
				elseif($index == 'sAddress' || $index == "sChurchName"){
					$criteria = trim($criteria);
					$alphNumTest = str_replace(" ","",$criteria); 
					if(!ctype_alnum($alphNumTest)){
						if($index == "sChurchName"){
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid Church Name!!!</h5></div>';
							exit;
						}
						else{
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid Address!!!</h5></div>';
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
		}

		/* Turn the comma seperated lists of ministries and amenities into arrays */
		foreach($newCriteriaArray as $index => $criteria){
			if($index == 'sMinistryNames' || $index == 'amenityID'){
				if($criteria !== ""){
					$newCriteriaArray[$index] = explode(",", $criteria);
				}
			}
		}
		
		if(!empty($newCriteriaArray['serviceTime'])){
			$newCriteriaArray['serviceTime'] = date_create($newCriteriaArray['serviceTime']);
			$newCriteriaArray['serviceTime'] = date_format($newCriteriaArray['serviceTime'], "H:i:s");
		} 
	}

	if(count($newCriteriaArray) !== 0 && $newCriteriaArray !== null) {	
		
		$churchSearchQuery .= "SELECT usermaster.iLoginID, usermaster.sDenomination,usermaster.sChurchName, usermaster.sPastorFirstName, usermaster.sProfileName,usermaster.sAddress, usermaster.iZipcode, cities.name, states.statecode
							   FROM usermaster	
							   INNER JOIN cities on usermaster.sCityName = cities.id
							   INNER JOIN states on usermaster.sStateName = states.id						   
							   ";

		/* Cycle through the $newCriteriaArray to concatenate the necessary INNER JOINS to the query string */
			$dayTimeCounter = 0;//counter used to prevent multiple INNER JOIN of churchtimeing table

			/* Loop used to add the necessary INNER JOINs to the query statement */
			foreach($newCriteriaArray as $index => $innerJoins) {
				if($index == 'sMinistryNames'){
					$churchSearchQuery .= " INNER JOIN churchministrymaster on usermaster.iLoginID = churchministrymaster.iLoginID ";
				}
				elseif($index == 'amenityID'){
					$churchSearchQuery .= " INNER JOIN churchamenitymaster on  usermaster.iLoginID = churchamenitymaster.iLoginID ";
				}
				elseif($index == 'serviceTime' || $index == 'sTitle'){
					$dayTimeCounter += 1; //counter used to prevent multiple INNER JOIN of churchtimeing table
				}
			}

			/* counter value is used to determine if INNER JOIN of churchtimeing table is needed */
			if($dayTimeCounter > 0){
				$churchSearchQuery .= " INNER JOIN churchtimeing on usermaster.iLoginID = churchtimeing.iLoginID ";
			}

	     	$churchSearchQuery .= " WHERE usermaster.isActive = 1 AND usermaster.sUserType = 'church' AND ";
     	/* /Cycle through the $newCriteriaArray to concatenate the necessary INNER JOINS to the query string */

        /* Cycle through the $newCriteriaArray to define the Bind Parameters */
        $minVal = 1;
		$i = 1; 
		$j = count($newCriteriaArray);
		foreach($newCriteriaArray as $index => $criteria){
			if($i == $j){
				if($index == 'sMinistryNames' ){
					for($d=0;$d<count($criteria);$d++) {
						$criteria[$d] = str_replace(" ","_",$criteria[$d]);
						if($d == count($criteria) - 1){
							$churchSearchQuery .= 'churchministrymaster.' . $criteria[$d] . '= :' . $index . $d;
						}
						else{
							$churchSearchQuery .= 'churchministrymaster.' . $criteria[$d] . '= :' . $index . $d . ' AND ';
						}
					}	 
				}
				elseif($index == 'amenityID') {
					for($f=0;$f<count($criteria);$f++) {
						if($f == count($criteria) - 1){
							$churchSearchQuery .= 'churchamenitymaster.' . $criteria[$f] . '= :' . $index . $f;
						}
						else{
							$churchSearchQuery .= 'churchamenitymaster.' . $criteria[$f]. '= :' . $index . $f . ' AND ';
						}
					}
				}
				elseif($index == 'serviceTime' || $index == 'sTitle') {
					$churchSearchQuery .= 'churchtimeing.' . $index . ' = :' . $index;
				}
				elseif($index == "name"){
					$churchSearchQuery .= 'cities.' . $index . ' = :' . $index;
				}
				else { 
					$churchSearchQuery .= 'usermaster.' . $index . ' = :' . $index;
				}
			}
			else{
				if($index == 'sMinistryNames' ){
					for($d=0;$d<count($criteria);$d++) {
						$churchSearchQuery .= 'churchministrymaster.' . $criteria[$d] . '= :' . $index . $d . ' AND '; 
					} 
				}
				elseif($index == 'amenityID') {
					for($f=0;$f<count($criteria);$f++) {
						$churchSearchQuery .= 'churchamenitymaster.' . $criteria[$f] . '= :' . $index . $f . ' AND ';
					}
				}
				elseif($index == 'serviceTime' || $index == 'sTitle') {
					$churchSearchQuery .= 'churchtimeing.' . $index . '= :' . $index . ' AND ';
				}
				elseif($index == "name"){
					$churchSearchQuery .= 'cities.' . $index . ' = :' . $index . ' AND ';
				}
				else {
					$churchSearchQuery .= 'usermaster.' . $index . '= :' . $index . ' AND ';
				}
			}

			/* Create Bind Parameter Statements */
			if($index == 'sMinistryNames' || $index == 'amenityID'){
				for($e=0;$e<count($criteria);$e++) {
					$bindParam[] = ':' . $index . $e . ',' . $minVal; 
				}
			}
			else{
				$bindParam[] = ':' . $index . ',' . $criteria; 
			}
			$i += 1; 
		}

		try{
			$searchResults = $db->prepare($churchSearchQuery);

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

		if(count($output) == 0) {
			echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, There Are Currently No Churches Matching this Search Criteria!!!</h5></div>';
		}
		foreach($output as $value){
			foreach($value as $index => $value1){
				if($index == 'sDenomination'){
					$dlist[] = $value1;
				}
			}
		}
		$dlist = array_unique($dlist);
	 	sort($dlist);
		
		foreach($dlist as $denlist){
			foreach($output as $value2){
				if($value2['sDenomination'] == $denlist){
					$churches[$denlist][] = $value2; 
				}
			}
		}
	}
	else{
		/* Query the denominationmaster table */
		$fetchDenoms = $db->query('SELECT denominationmaster.name FROM denominationmaster'); 
		$denomList = $fetchDenoms->fetchAll(PDO::FETCH_ASSOC);

		/* Reduce $denomList from a 2D to 1D array */
		foreach($denomList as $denom) {
			$denomList1D[] = $denom['name'];
		}
		sort($denomList1D);

		/* Query denominationmaster table - Assign Artist's info to a card */
		foreach($denomList1D as $denomination){
			/* Form Query Statement */
			$churchQuery = "SELECT usermaster.iLoginID, usermaster.sChurchName, usermaster.sPastorFirstName, usermaster.sPastorLastName, usermaster.sProfileName, usermaster.sAddress, usermaster.sCityName, usermaster.sStateName, usermaster.iZipcode, cities.name, states.statecode
						    FROM usermaster 
						    INNER JOIN cities on usermaster.sCityName = cities.id
						    INNER JOIN states on usermaster.sStateName = states.id 
						    WHERE  usermaster.sUserType = 'church' AND usermaster.isActive = 1 AND usermaster.sDenomination = ?";
			try{
				$churchResults = $db->prepare($churchQuery);
				$churchResults->bindParam(1, $denomination);
				$churchResults->execute(); 
				$churchList = $churchResults->fetchAll(PDO::FETCH_ASSOC); 

				if(!empty($churchList)) {				    						
						$churches[$denomination]= $churchList; 				    						
					}	
			}
			catch(Exception $e){
				echo $e; 
			}
		}
		if(count($churches) == 0){
			echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, There Are Currently No Churches!!!</h5></div>';
			exit;
		} 
	}		
?>
<!-- Artist Display on Xtra Small Screens -->
<div class="container d-sm-none">
	<!-- Determine # of talent Divider Containers -->
	<?php 
		$a=0;
		foreach($churches as $denomContainerTitle => $denomContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $denomContainerTitle;?>"> 
	  		<h4><?php echo str_replace("_","/",$denomContainerTitle);?></h4>
	      	<div id="carouselExampleControls_S<?php echo $a;?>" class="carousel slide p-0" data-ride="" >
			  <div class="carousel-inner pb-0 mb-0 " style="height: 250px; ">				   
			  	<!-- Carousel Slide -->
				  	<!-- Determine # of slides -->
					  	<?php 
					  		$chunkedArray = array_chunk($churches[$denomContainerTitle], 1);
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
					    			foreach($chunkedArray[$i] as $churchCard){
					    		?>
					    			<!-- Card Info -->
							    	<div class="card p-2 mb-0" style="width: 175px;margin:auto">
									  <img class="card-img-top d-block" style="object-fit:cover; object-position:0,0;" src="<?php echo URL;?>upload/church/<?php echo $churchCard['sProfileName'];?>" width="100px" height="100px" alt="Card image cap">
									  <div class="card-body p-0 pt-0" style="min-height: 90px">
									  	<!-- Truncation Code for church names, pastor names, & addresses that are too long!!! -->
											<?php
												$churchNameLength = strlen($churchCard['sChurchName']);
												$pastorNameLength = strlen($churchCard['sPastorFirstName']);
												$addressLength = strlen($churchCard['sAddress']);												
												$cityNameLength = strlen($churchCard['name']);
										  		if($churchNameLength>14) {
										  			$churchCard['sChurchName'] = substr_replace($churchCard['sChurchName'], '...', 11);  
										  		}
										  		if($pastorNameLength > 17) {
										  			$churchCard['sPastorFirstName'] = substr_replace($churchCard['sPastorFirstName'], '...', 14); 
										  		}
										  		if($addressLength > 22) {
										  			$churchCard['sAddress'] = substr_replace($churchCard['sAddress'], '...', 19); 
										  		}
										  		if($cityNameLength > 10) {
										  			$churchCard['name'] = substr_replace($churchCard['name'], '...', 7); 
										  		}
									  		?>
									  	<!-- /Truncation Code for church names, pastor names, & addresses that are too long!!! -->
									    <h5 class="card-title m-0 p-0"><?php echo $churchCard['sChurchName'];?></h5>
									    <p class="card-text d-none card-text-size-gs">example Text</p>
									    <ul class="list-unstyled card-text-size-gs">
									    	<li>Pastor <?php echo $churchCard['sPastorFirstName'];?></li>
									    	<li><?php echo $churchCard['sAddress']; ?></li>
									    	<li><?php echo $churchCard['name'] . ', ' . $churchCard['statecode'];?></li>
									    </ul>
									  </div>
									  <!-- footer -->
									  <div class="card-footer p-0 pt-1 text-center mt-0">
									    <a href="<?php echo URL;?>newHomePage/views/churchprofile.php?church=<?php echo $churchCard['iLoginID'];?>" class="btn btn-primary btn-sm btn-gs">View Profile</a>
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
		foreach($churches as $denomContainerTitle => $denomContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $denomContainerTitle;?>" style=""> 
	  		<h4><?php echo str_replace("_","/",$denomContainerTitle);?></h4>
	      	<div id="carouselExampleControls_M<?php echo $b;?>" class="carousel slide mb-3" data-ride="carousel" style="height:250px" >
			  <div class="carousel-inner pb-0 mb-0 " style="height:250px">				   
			  	<!-- Carousel Slide -->
				  	<!-- Determine # of slides -->
				  	<?php 
				  		$chunkedArray = array_chunk($churches[$denomContainerTitle], 3);
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
					    			foreach($chunkedArray[$i] as $churchCard){
					    		?>
					    			<!-- Card Info -->
					    			<div class="col-4  px-2">
								    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
										  <img class="card-img-top d-block" style="object-fit:cover; object-position:0,0;" src="<?php echo URL;?>upload/church/<?php echo $churchCard['sProfileName'];?>" width="45px" height="110px" alt="Card image cap">
										  <div class="card-body p-0" style="min-height: 90px">
										  	<!-- Truncation Code for church names, pastor names, & addresses that are too long!!! -->
											<?php
												$churchNameLength = strlen($churchCard['sChurchName']);
												$pastorNameLength = strlen($churchCard['sPastorFirstName']);
												$addressLength = strlen($churchCard['sAddress']);												
												$cityNameLength = strlen($churchCard['name']);
										  		if($churchNameLength>10) {
										  			$churchCard['sChurchName'] = substr_replace($churchCard['sChurchName'], '...', 7);  
										  		}
										  		if($pastorNameLength > 14) {
										  			$churchCard['sPastorFirstName'] = substr_replace($churchCard['sPastorFirstName'], '...', 11); 
										  		}
										  		if($addressLength > 21) {
										  			$churchCard['sAddress'] = substr_replace($churchCard['sAddress'], '...', 19); 
										  		}
										  		if($cityNameLength > 8) {
										  			$churchCard['name'] = substr_replace($churchCard['name'], '...', 5); 
										  		}
									  		?>
									  		<!-- /Truncation Code for church names, pastor names, & addresses that are too long!!! -->
										    <h5 class="card-title p-0 m-0"><?php echo $churchCard['sChurchName'];?></h5>
										    <p class="card-text d-none card-text-size-gs">example Text</p>
										    <ul class="list-unstyled card-text-size-gs">
										    	<li>Pastor <?php echo $churchCard['sPastorFirstName'];?></li>
										    	<li><?php echo $churchCard['sAddress']; ?></li>
										    	<li><?php echo $churchCard['name'] . ', ' . $churchCard['statecode'];?></li>
										    </ul>
										  </div>
										  <!-- footer -->
										  <div class="card-footer p-0 pt-1 text-center mt-1">
										    <a href="<?php echo URL;?>newHomePage/views/churchprofile.php?church=<?php echo $churchCard['iLoginID'];?>" class="btn btn-primary btn-sm btn-gs">View Profile</a>
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

<!-- Church Carousel Display on Large Screens -->
<div class="container d-none d-lg-block" style="width:100%">
	<!-- Determine # of Denomination Divider Containers -->
	<?php 
		
		echo $c;
		foreach($churches as $denomContainerTitle => $denomContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $denomContainerTitle;?>"> 
	  		<h4><?php echo ucfirst(str_replace("_","-",$denomContainerTitle));?></h4> 
	      	<div id="carouselExampleControls_L<?php echo $c;?>" class="carousel slide mb-3" style="background-image: url();height: 250px;" data-ride="" >
			  <div class="carousel-inner pb-0 mb-0 " style="height: 250px; ">
			  	<!-- Carousel Slide -->
			  		<!-- Determine # of slides -->
			  		<?php 
			  			$chunkedArray = array_chunk($churches[$denomContainerTitle], 4);
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
					    			foreach($chunkedArray[$i] as $churchCard){
					    		?>
					    			<div class="col-3 px-4">
								    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
								    	<!-- link to artist's profile pic -->
										  <img class="card-img-top d-block mb-0" style="object-fit:cover; object-position:0,0;" src="<?php echo URL;?>upload/church/<?php echo $churchCard['sProfileName'];?>" width="45px" height="110px" alt="Card image cap">
										<!-- /link to artist's profile pic -->
										  <div class="card-body p-0" style="min-height: 90px">

											<!-- Truncation Code for church names, pastor names, & addresses that are too long!!! -->
											<?php
												$churchNameLength = strlen($churchCard['sChurchName']);
												$pastorNameLength = strlen($churchCard['sPastorFirstName']);
												$addressLength = strlen($churchCard['sAddress']);												
												$cityNameLength = strlen($churchCard['name']);
										  		if($churchNameLength>13) {
										  			$churchCard['sChurchName'] = substr_replace($churchCard['sChurchName'], '...', 11);  
										  		}
										  		if($pastorNameLength > 17) {
										  			$churchCard['sPastorFirstName'] = substr_replace($churchCard['sPastorFirstName'], '...', 14); 
										  		}
										  		if($addressLength > 24) {
										  			$churchCard['sAddress'] = substr_replace($churchCard['sAddress'], '...', 22); 
										  		}
										  		if($cityNameLength > 11) {
										  			$churchCard['name'] = substr_replace($churchCard['name'], '...', 7); 
										  		}
									  		?>
									  		<!-- /Truncation Code for church names, pastor names, & addresses that are too long!!! -->

										    <h5 class="card-title p-0 m-0"><?php echo $churchCard['sChurchName'];?></h5> 
										    <p class="card-text d-none card-text-size-gs">example Text</p>
										    <ul class="list-unstyled card-text-size-gs">
										    	<li>Pastor <?php echo $churchCard['sPastorFirstName'];?></li>  <!-- str_replace("_","/",$denomContainerTitle); -->
										    	<li><?php echo $churchCard['sAddress']; ?></li>
										    	<li><?php echo $churchCard['name'] . ', ' . $churchCard['statecode'] . ' ' . $churchCard['iZipcode'];?></li>
										    </ul>
		 									
										  </div>
										  <div class="card-footer p-0 pt-1 text-center">
										    	<a href="<?php echo URL;?>newHomePage/views/churchprofile.php?church=<?php echo $churchCard['iLoginID'];?>" class="btn mb-0 btn-primary btn-sm btn-gs">View Profile</a><!-- link to the artist's profile -->
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