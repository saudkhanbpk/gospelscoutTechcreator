<?php 
	
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
			

	/*************************************** Validate Search Criteria ***************************************/
		if(!empty($_POST)){	
			foreach($_POST as $index => $criteria){
				/* Validate Certain input fields from the search form  */
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
					elseif($index == "sFirstName" || $index == "sLastName" || $index == "sCityName") {
						$criteria = trim($criteria);
						$alphaTest = str_replace(" ","",$criteria); 
						if(!ctype_alpha($alphaTest)){
							if($index == "sFirstName" || $index == "sLastName"){
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
					elseif($index == 'dDOB1' || $index == 'dDOB2'){
						if(strlen(intval(trim($criteria))) > 3){
							echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter an Age Between 4 and 120!!!</h5></div>';
							exit;
						}
						else{
							if($index == 'dDOB2'){
								$nAge = intval(trim($criteria)) + 1;
							}
							else{
								$nAge = intval(trim($criteria));
							}
							
							/* Create dates to define the DOB upper and lower boundaries */
								$dateToday = date_create();
					        	date_sub($dateToday,date_interval_create_from_date_string($nAge . " years"));
					        	$dateToday = date_format($dateToday, 'Y-m-d');
				        	/* END - Create dates to define the DOB upper and lower boundaries */

							$newCriteriaArray[$index] = $dateToday; 
						}
					}
					elseif($index == 'rate1' || $index == 'rate2'){
						/* Convert to a float */
							$criteria = floatval(trim($criteria));

						/* Validate user-entered values */
							if($criteria != ''){
								if(is_float($criteria)){ 
									if(trim($criteria) > 9999.99){
										echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please enter a valid number between 1.00 - 9999.99</h5></div>'; 
										exit;
									}
									elseif($criteria != 0){
										$newCriteriaArray[$index] = $criteria;
									}
								}
								else{
									echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please enter a valid number between 1.00 - 9999.99</h5></div>'; 
									exit;
								}
							}
					}
					else{
						$newCriteriaArray[$index] = trim($criteria); 
					}
				}
			}
			if($newCriteriaArray['sGroupType']){
				$userType = 'group';
			}
			else{
				$userType = 'artist';
			}
		}
		elseif(!empty($_GET)){
			$talentGroup = trim($_GET['talent']); 
			$userType = trim($_GET['type']) ;
		}
	/************************************ END - Validate Search Criteria ************************************/
	
	/************** Define Query statement for talent group and all talent group(default) searches **************/
	if($_GET['type'] == 'group'){
		$artistList = "SELECT usermaster.iLoginID, usermaster.sGroupName, usermaster.sProfileName, usermaster.sStateName, usermaster.sCityName, usermaster.rating_number, usermaster.iRateAvg, states.statecode
			       FROM usermaster 
			       INNER JOIN states on usermaster.sStateName = states.id
			       WHERE usermaster.sGroupType = ? AND usermaster.sUserType = 'group' AND usermaster.isActive = 1";
	}
	else{
		$artistList = "SELECT usermaster.iLoginID, usermaster.sFirstName, usermaster.sProfileName, usermaster.sStateName, usermaster.sCityName, usermaster.rating_number, usermaster.iRateAvg, states.statecode
			       FROM talentmaster 
			       INNER JOIN usermaster on talentmaster.iLoginID = usermaster.iLoginID 
			       INNER JOIN states on usermaster.sStateName = states.id
			       WHERE talentmaster.talent = ? AND usermaster.sUserType = 'artist' AND usermaster.isActive = 1";
	}
			 
		
	/*********** END - Define Query statement for talent group and all talent group(default) searches ***********/
	
	if(count($newCriteriaArray) !== 0 && $newCriteriaArray !== null){
	
		/*************************************** Define the Query Statement ***************************************/
			if($userType == 'group'){
				$artistSearchQuery = "SELECT usermaster.iLoginID, usermaster.sGroupName, usermaster.sGroupType, usermaster.sProfileName, usermaster.sStateName, usermaster.sCityName, usermaster.rating_number, usermaster.iRateAvg, states.statecode, grouptypemaster.sTypeName";
			}
			else{
				$artistSearchQuery = "SELECT talentmaster.talent, usermaster.iLoginID, usermaster.sFirstName, usermaster.sProfileName, usermaster.sStateName, usermaster.sCityName, usermaster.rating_number, usermaster.iRateAvg, states.statecode";
			}
			/****************** Determine if the talent index is present ******************/
			$trigger = 0; 
			foreach($newCriteriaArray as $index => $criteria){
				if($index == 'talent'){
					$trigger = 1; 
				}
				elseif($index == 'sGroupType'){
					$trigger = 2; 
					unset($newCriteriaArray['talent']);
				}
			}
			/*************** END - Determine if the talent index is present ***************/

			/* If the talent index is present then query statement will do a relational query on both talentmaster and usermaster */
			/* THIS CONDITIONAL DOES NOT APPEAR TO BE NECESSARY!!!*/

			if($trigger == 2){
				$artistSearchQuery .= " FROM usermaster
							INNER JOIN grouptypemaster on usermaster.sGroupType = grouptypemaster.id
						   	INNER JOIN states on usermaster.sStateName = states.id
						   	WHERE usermaster.isActive = 1 AND usermaster.sUserType = 'group' AND ";
			}
			else{	
				$artistSearchQuery .= " FROM usermaster 
							INNER JOIN talentmaster on usermaster.iLoginID = talentmaster.iLoginID
							INNER JOIN states on usermaster.sStateName = states.id
							WHERE usermaster.isActive = 1 AND usermaster.sUserType = 'artist' AND ";	
			}	
			

			$i = 1; 
			$j = count($newCriteriaArray);
			foreach($newCriteriaArray as $index => $criteria){
				
				if($i == $j){
					if($index == 'talent'){
						$artistSearchQuery .= "talentmaster." . $index . " = :" . $index;					
					}
					elseif($index == 'sAvailability'){
							$artistSearchQuery .= "usermaster." . $index . " = :" . $index;
					}
					elseif($index == "name"){
						$artistSearchQuery .= 'cities.' . $index . ' = :' . $index;
					}
					elseif($index == "dDOB1"){
						$artistSearchQuery .= 'usermaster.dDOB <= :' . $index; 
					}
					elseif($index == "dDOB2"){
						$artistSearchQuery .= 'usermaster.dDOB >= :' . $index; 
					}
					elseif($index == "rate1"){
						$artistSearchQuery .= 'usermaster.playRate >= :' . $index; 
					}
					elseif($index == "rate2"){
						$artistSearchQuery .= 'usermaster.playRate <= :' . $index; 
					}
					else{
						$artistSearchQuery .= "usermaster." . $index . " = :" . $index;					
					}
				}
				else{
					if($index == 'talent'){
						$artistSearchQuery .= "talentmaster." . $index . " = :" . $index . " AND ";					
					}
					elseif($index == 'sAvailability'){
						$artistSearchQuery .= "usermaster." . $index . " = :" . $index . " AND ";
					}
					elseif($index == "name"){
						$artistSearchQuery .= 'cities.' . $index . ' = :' . $index . " AND ";
					}
					elseif($index == "dDOB1"){
						$artistSearchQuery .= 'usermaster.dDOB <= :' . $index . " AND "; 
					}
					elseif($index == "dDOB2"){
						$artistSearchQuery .= 'usermaster.dDOB >= :' . $index . " AND "; 
					}
					elseif($index == "rate1"){
						$artistSearchQuery .= 'usermaster.playRate >= :' . $index . " AND "; 
					}
					elseif($index == "rate2"){
						$artistSearchQuery .= 'usermaster.playRate <= :' . $index . " AND "; 
					}
					else{
						$artistSearchQuery .= "usermaster." . $index . " = :" . $index . " AND ";
					}
				}
				
				//$bindParam[] = ':' . $index . ',' . $criteria; 
				if($index == "dDOB1"){
					$bindParam[] = ':' . $index . ',' . $criteria;
				}
				elseif($index == "dDOB2"){
					$bindParam[] = ':' . $index . ',' . $criteria;
				}
				else{
					$bindParam[] = ':' . $index . ',' . $criteria; 
				}
				$i += 1; 
			}	
			/*var_dump($bindParam);
			echo $artistSearchQuery;
			exit;	*/			  
		/************************************ END - Define the Query Statement ************************************/

		/************************** Query the database based on the search criteria ***************************/
			try{
				$searchResults = $db->prepare($artistSearchQuery);
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
				echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, There Are Currently No Artists Matching this Search Criteria!!!</h5></div>';
			}
		/************************ END - Query the database for based on the search criteria ************************/

		/***************************************** Group Results By Talent *****************************************/
			if($userType == 'group'){
				foreach($output as $value){
					foreach($value as $index => $value1){
						if($index == 'sTypeName'){
							$talentlist[] = $value1;
						}
					}
				}
				$talentlist = array_unique($talentlist);
			 	sort($talentlist);
				
				foreach($talentlist as $tallist){
					foreach($output as $value2){
						if($value2['sTypeName'] == $tallist){
							$artists[$tallist][] = $value2; 
						}
					}
				}
				// var_dump($artists);
			}
			else{
				foreach($output as $value){
					foreach($value as $index => $value1){
						if($index == 'talent'){
							$talentlist[] = $value1;
						}
					}
				}
				$talentlist = array_unique($talentlist);
			 	sort($talentlist);
				
				foreach($talentlist as $tallist){
					foreach($output as $value2){
						if($value2['talent'] == $tallist){
							$artists[$tallist][] = $value2; 
						}
					}
				}
			}
		/************************************** END - Group Results By Talent **************************************/
			
	}
	elseif($talentGroup != '' && $talentGroup != 'all'){
		/**** Query database for all active artists that fall within this talent group ****/
			$results = $db->prepare($artistList); 
			$results->bindParam(1, $talentGroup);
			$results->execute(); 
			$talentGroupList =  $results->fetchAll(PDO::FETCH_ASSOC); 
		/* END - Query database for all active artists that fall within this talent group */
	}
	else{	
		if($userType == 'group'){
			$fetchTalents = $db->query('SELECT grouptypemaster.id, grouptypemaster.sTypeName FROM grouptypemaster');
		}
		else{
			$fetchTalents = $db->query('SELECT giftmaster.sGiftName FROM giftmaster');
		}
		/***************************** Query the giftmaster table *****************************/ 
			$talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);
		/************************** END - Query the giftmaster table **************************/

		/********************** Reduce $talentList from a 2D to 1D array **********************/
		foreach($talentList as $tal) {
			if($userType == 'group'){
				$talentList1D[$tal['sTypeName']] = $tal['id'];
			}
			else{
				$talentList1D[] = $tal['sGiftName'];
			}
		}
		/******************* END - Reduce $talentList from a 2D to 1D array *******************/

		asort($talentList1D);

		/************** Query talentmaster table - Assign Artist's info to a card *************/
			/* Form query statement */
			
			/* Use PDO statement to do relational query for artists under each talent*/			   
			foreach($talentList1D as $index => $talent) {
					$results = $db->prepare($artistList); 
					$results->bindParam(1, $talent);
					$results->execute(); 
					$list =  $results->fetchAll(PDO::FETCH_ASSOC); 
					
					if(!empty($list)) {				    						
						if($userType == 'group'){
							$artists[$index]= $list; 	
						}
						else{
							$artists[$talent]= $list; 	
						}				    						
					}	
			} 
			if(count($artists) == 0){
				echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, There Are Currently No Artists!!!</h5></div>';
				exit;
			} 
		/*********** END - Query talentmaster table - Assign Artist's info to a card **********/
	}		
?>


<?php 
	if($talentGroup != '' && $talentGroup != 'all'){
		if(count($talentGroupList) > 0){
			if($userType == 'group'){
				$fetchGroupName = $db->prepare('SELECT grouptypemaster.sTypeName FROM grouptypemaster WHERE grouptypemaster.id = ?'); 
				$fetchGroupName->bindParam(1,$talentGroup);
				$fetchGroupName->execute();
				$getTypeName = $fetchGroupName->fetch(PDO::FETCH_ASSOC);
				$talentGroup = ucwords($getTypeName['sTypeName']);
			}
?>
			<!-- Only Display artists of a specified talent -->
			<div class="container">
					<h4><?php echo str_replace("_","/",$talentGroup); ?></h4>
					<div class="container px-5">
						<div class="row px-4 px-md-0 px-lg-5">
							<?php foreach($talentGroupList as $groupArtist){?>
								<div class="col col-md-3 px-md-1 px-lg-4 my-2">
							    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
							    	
							    	<!-- link to artist's profile pic -->
								  <img class="card-img-top d-block mb-0" style="object-fit:cover; object-position:0,0;" src="<?php echo $groupArtist['sProfileName'];?>" width="45px" height="110px" alt="Card image cap">
								<!-- /link to artist's profile pic -->
								  
								  <div class="card-body p-0" style="min-height: 90px">
								    <h5 class="card-title p-0 m-0">
								    	<?php 
								    		if($userType == 'artist'){
								    			echo ucwords($groupArtist['sFirstName']);
								    		}
								    		elseif($userType == 'group'){
								    			echo ucwords($groupArtist['sGroupName']);
								    		}
								    	?>
								    </h5>
								    <p class="card-text d-none card-text-size-gs">example Text</p>
								    <ul class="list-unstyled card-text-size-gs">
								    	<li><?php echo str_replace("_","/",$talentGroup);?></li>
								    	<li><?php echo $groupArtist['sCityName'] . ', ' . $groupArtist['statecode'];?></li>
								    	<!--<li><?php echo '$starRating;' ?></li>-->
								    </ul>
										
								  </div>
									  <div class="card-footer p-0 pt-1 text-center">
									    	<a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $groupArtist['iLoginID'];?>" class="btn mb-0 btn-primary btn-sm btn-gs">View Profile</a><!-- link to the artist's profile -->
									  	</div>
									</div> 
								</div>
							<?php }?>
						</div>
					</div>
				</div>
			<!-- END - Only Display artists of a specified talent -->
<?php 
		}
		else{
			echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5 class="">Sorry, there are currently no artists matching this criteria.</h5></div>';
		}
	}
	else{
?>
<!-- Artist Display on Xtra Small Screens -->
<div class="container d-sm-none">
	<!-- Determine # of talent Divider Containers -->
	<?php 
		$a=0;
		foreach($artists as $talContainerTitle => $talContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $talContainerTitle;?>"> 
	  		<h4><?php echo str_replace("_","/",$talContainerTitle);?></h4>
	      	<div id="carouselExampleControls_S<?php echo $a;?>" class="carousel slide p-0" data-ride="" >
			  <div class="carousel-inner pb-0 mb-0 " style="height: 250px; ">				   
			  	<!-- Carousel Slide -->
				  	<!-- Determine # of slides -->
					  	<?php 
					  		$chunkedArray = array_chunk($artists[$talContainerTitle], 1);
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
					    			foreach($chunkedArray[$i] as $artistCard){
					    		?>

					    			<!-- Card Info -->
							    	<div class="card p-2 mb-0" style="width: 175px;margin:auto">
									  <img class="card-img-top d-block" style="object-fit:cover; object-position:0,0;" src="<?php echo $artistCard['sProfileName'];?>" width="100px" height="100px" alt="Card image cap">
									  <div class="card-body p-0 pt-0" style="min-height: 90px">
									    <h5 class="card-title m-0 p-0">
									    	<?php 
									    		if($userType == 'artist'){
									    			echo ucwords($artistCard['sFirstName']);
									    		}
									    		elseif($userType == 'group'){
									    			echo ucwords($artistCard['sGroupName']);
									    		}
									    	?>
									    </h5>
									    <p class="card-text d-none card-text-size-gs">example Text</p>
									    <ul class="list-unstyled card-text-size-gs">
									    	<li><?php echo str_replace("_","/",$talContainerTitle);?></li>
									    	<li><?php echo $artistCard['sCityName'] . ', ' . $artistCard['statecode'];?></li>
									    	<!--<li><?php echo '$starRating;' ?></li>-->
									    </ul>
									  </div>
									  <!-- footer -->
									  <div class="card-footer p-0 pt-1 text-center mt-0">
									    <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artistCard['iLoginID'];?>" class="btn btn-primary btn-sm btn-gs">View Profile</a>
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
		foreach($artists as $talContainerTitle => $talContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $talContainerTitle;?>" style=""> 
	  		<h4><?php echo str_replace("_","/",$talContainerTitle);?></h4>
	      	<div id="carouselExampleControls_M<?php echo $b;?>" class="carousel slide mb-3" data-ride="carousel" style="height:250px" >
			  <div class="carousel-inner pb-0 mb-0 " style="height:250px">				   
			  	<!-- Carousel Slide -->
				  	<!-- Determine # of slides -->
				  	<?php 
				  		$chunkedArray = array_chunk($artists[$talContainerTitle], 3);
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
					    			foreach($chunkedArray[$i] as $artistCard){
					    		?>
					    			<!-- Card Info -->
					    			<div class="col-4  px-2">
								    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
										  <img class="card-img-top d-block" style="object-fit:cover; object-position:0,0;" src="<?php echo $artistCard['sProfileName'];?>" width="45px" height="110px" alt="Card image cap">
										  <div class="card-body p-0" style="min-height: 90px">
										    <h5 class="card-title p-0 m-0">
										    	<?php 
										    		if($userType == 'artist'){
										    			echo ucwords($artistCard['sFirstName']);
										    		}
										    		elseif($userType == 'group'){
										    			echo ucwords($artistCard['sGroupName']);
										    		}
										    	?>
										    </h5>
										    <p class="card-text d-none card-text-size-gs">example Text</p>
										    <ul class="list-unstyled card-text-size-gs">
										    	<li><?php echo str_replace("_","/",$talContainerTitle);?></li>
										    	<li><?php echo $artistCard['sCityName'] . ', ' . $artistCard['statecode'];?></li>
										    	<!--<li><?php echo '$starRating;' ?></li>-->
										    </ul>
										  </div>
										  <!-- footer -->
										  <div class="card-footer p-0 pt-1 text-center mt-1">
										    <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artistCard['iLoginID'];?>" class="btn btn-primary btn-sm btn-gs">View Profile</a>
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
		foreach($artists as $talContainerTitle => $talContainerVal){
	?>
	  	<!-- talent divider -->
	  	<div class="container" id="<?php echo $talContainerTitle;?>"> 
	  		<h4><?php echo str_replace("_","/",$talContainerTitle);?></h4>
	      	<div id="carouselExampleControls_L<?php echo $c;?>" class="carousel slide mb-3" style="background-image: url();height: 250px;" data-ride="" >
			  <div class="carousel-inner pb-0 mb-0 " style="height: 250px; ">
			  	<!-- Carousel Slide -->
			  		<!-- Determine # of slides -->
			  		<?php 
			  			$chunkedArray = array_chunk($artists[$talContainerTitle], 4);
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
					    			foreach($chunkedArray[$i] as $artistCard){
					    		?>
					    			<div class="col-3 px-4">
								    	<div class="card p-1 mb-0 card-shadow" style="height:249px">
								    	<!-- link to artist's profile pic -->
										  <img class="card-img-top d-block mb-0" style="object-fit:cover; object-position:0,0;" src="<?php echo $artistCard['sProfileName'];?>" width="45px" height="110px" alt="Card image cap">
										<!-- /link to artist's profile pic -->
										  <div class="card-body p-0" style="min-height: 90px">
										    <h5 class="card-title p-0 m-0">
										    	<?php 
										    		if($userType == 'artist'){
										    			echo ucwords($artistCard['sFirstName']);
										    		}
										    		elseif($userType == 'group'){
										    			echo ucwords($artistCard['sGroupName']);
										    		}
										    	?>
										    </h5>
										    <p class="card-text d-none card-text-size-gs">example Text</p>
										    <ul class="list-unstyled card-text-size-gs">
										    	<li><?php echo str_replace("_","/",$talContainerTitle);?></li>
										    	<li><?php echo $artistCard['sCityName'] . ', ' . $artistCard['statecode'];?></li>
										    	<!--<li><?php echo '$starRating;' ?></li>-->
										    </ul>
		 									
										  </div>
										  <div class="card-footer p-0 pt-1 text-center">
										    	<a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $artistCard['iLoginID'];?>" class="btn mb-0 btn-primary btn-sm btn-gs">View Profile</a><!-- link to the artist's profile -->
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
<?php 
	}
?>


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