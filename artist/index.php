<?php 
	$page = 's4a';
	
	// require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/header_1.php");
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php");

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

	/* Query the giftmaster table */
		$fetchTalents = $db->query('SELECT giftmaster.sGiftName,giftmaster.iGiftID FROM giftmaster'); 
		$talentList = $fetchTalents->fetchAll(PDO::FETCH_ASSOC);
	/* END -Query the giftmaster table */

	/* Reduce $talentList from a 2D to 1D array */
		foreach($talentList as $tal) {
			$talentList1D[$tal['iGiftID']] = str_replace('_', '/', $tal['sGiftName']);
		}
	/* END - Reduce $talentList from a 2D to 1D array */
	
	/* Query the grouptypemaster table */
		$fetchGroupTypes = $db->query('SELECT grouptypemaster.id, grouptypemaster.sTypeName FROM grouptypemaster'); 
		$groupTypeList = $fetchGroupTypes->fetchAll(PDO::FETCH_ASSOC);
	/* END - Query the grouptypemaster table */


	 if (isset($_GET['page_no'])) {
          $page_no = $_GET['page_no'];
      } else {
          $page_no = 1;
      }

      // Set number of records per page 
      $no_of_records_per_page = 15;
      $offset = ($page_no-1) * $no_of_records_per_page; 

      // Query DB for number of artists 
      $columnsArray_art_no =  array('usermaster.iLoginID');
      $paramArray_art_no['usermaster.sUserType']['='] = 'artist';
	  $emptyArray = array();
      $artist_no = pdoQuery('usermaster',$columnsArray_art_no,$paramArray_art_no,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
	  

      // Get number of artists and pages  
      $total_rows = count( $artist_no );
      $total_pages = ceil($total_rows / $no_of_records_per_page);
      // var_dump($total_rows);
      // var_dump($total_pages);
      $offset_array = array('offset'=>$offset,"no_of_records"=>$no_of_records_per_page);
?>
<link href="<?php echo URL;?>home/css/new-age.css" rel="stylesheet">
<!--  Add style sheet -->
<link href="<?php echo URL; ?>artist/css/indexCss.css?1" rel="stylesheet">

<!-- Find artists Section -->
<div class="container-fluid bg-gs mt-0 py-0 text-center text-white" style="width:100%">
	<div class="row" id="layer2">
		<div class="col-12  py-5" id="layer3">
			
			<div class="container py-3">
				<div class="row">
					<div class="col-12 col-md-10 pt-3  mx-auto">

						<h1> Find Artists</h1>
						<p style="font-size:.8em;color:rgba(255,255,255,.5)">Select and book talented ameteur, intermediate, or professional top-rated artists.  <span class="d-none  d-md-inline">Search by using one of our predefined selection categories or by using the search filter.</span></p>

						<!-- Search bar/filtered search area -->
						<!--<div class="container">
							<div class="row">
								<div class="col-12 col-md-9 mx-auto">
									<form>
										<div class="input-group mb-3 ">
										  <input type="text" id="searchBar"  oninput="hideIcon(this)" class="form-control pt-1 pl-2" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="button-addon2">
										  <div class="input-group-append" id="filter_container">-->
										   <!--  <button class="btn btn-outline-light" type="button" id="button-addon2">
										    	<img class="img-fluid m-0 p-0" src="<?php echo URL;?>search4artist/css/filter_icon.svg" width="20px" height="20x" data-src="" alt="Generic placeholder image">
										    </button> -->
						<!--				  </div>
										</div>

									</form>
								</div>
							</div>
						</div>-->

					</div>
				</div>
			</div>
			

		</div>
	</div>
</div>

<!-- Artists Category Nav -->
<div class="container bg-white pt-4">
	<div class="row">
		<div class="col-12">

			<div class="card text-center m-0 pb-0" style="border-bottom:none;">
				  <div class="card-header">
				    <ul class="nav nav-tabs card-header-tabs" style="font-size:.8em">
				      <li class="nav-item">
	                      <a class="nav-link active artist_search_method" id="by_talent" href="#">Search by Category</a><!-- <span class="badge badge-pill badge-primary" id="talent_count">0</span> -->
	                   </li>
	                   <li class="nav-item">
	                      <a class="nav-link artist_search_method" id="by_filter" href="#">Search Filter </a><!-- <span class="badge badge-pill badge-primary" id="filtered_count">0</span> -->
	                   </li>
				    </ul>
				  </div>
				  	<!-- Display the artist navigation section -->
						<div class="card-body py-0 px-0"  id="nav_display" >
							<div class="nav_method" id="get_by_talent">
					  			<nav class="navbar navbar-expand navbar-light bg-light" id="nav-category">
									<ul class="navbar-nav mx-auto" style="font-size:.8em;">
								      <li class="nav-item  mx-2"><!-- active -->
								        <a type="btn btn-sm" class="active_categ nav-link px-5 rounded-pill categ_pills searchBy" style="color:rgba(149,73,173,1);"  href="#" searchBy="pop">Popular <span class="sr-only">(current)</span></a>
								      </li>
								     <!-- <li class="nav-item mx-2">
								        <a class="nav-link px-5 rounded-pill categ_pills searchBy" style="color:rgba(149,73,173,1);" type="btn btn-sm" href="#" searchBy="TR">Top Rated</a>
								      </li>
								       <li class="nav-item mx-2">
								        <a class="nav-link px-5 rounded-pill categ_pills searchBy" style="color:rgba(149,73,173,1)" type="btn btn-sm" href="#" searchBy="NT">New Talent</a>
								      </li>-->
								       <li class="nav-item dropdown mx-2">
								        <a class="nav-link dropdown-toggle rounded-pill categ_pills tal_dropdown_pill"  data-reference="parent" style="color:rgba(149,73,173,1)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								          Search By Talent
								        </a>
								        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="z-index:100" id="nav_display">
								        	<?php foreach($talentList1D as $talentList1D_index => $talentList1D_value){ echo '<a class="dropdown-item talentGroup searchBy" searchBy="SBT" talent="'.$talentList1D_index.'" artistType="artist" href="#">'.$talentList1D_value.'</a>'; }?>
								        </div>
								      </li>
								    </ul>
								</nav>
					  		</div>

              				<div class="nav_method d-none" id="get_by_filter">
							  
					  			<nav class="navbar navbar-expand-lg navbar-light bg-light">
									  <ul class="navbar-nav mx-auto" style="font-size:.8em;"> 
                      					<!-- Location Dropdown -->
									      <li class="nav-item dropdown mx-2 my-1 my-md-0">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-location" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Location
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown-location">
										        <form class="searchCriteriaForm" name="form1" >
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Location</p>
																<?php 
																    $paramArray['country_id']['='] = 231;  
																	$states = pdoQuery('states','all',$paramArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
																?>
																    <div class="form-group form-data-grab">
																	    <select class="custom-select form-control my-2" style="border-radius:20px" id="state" name="sStateName">
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

																    <div class="form-group form-data-grab"><input type="text" class="form-control mb-2 mt-1" style="border-radius:20px" name="sCityName" placeholder="City" ></div>

																    <div class="form-group form-data-grab"><input type="text" class="form-control my-2" style="border-radius:20px" name="iZipcode" placeholder="Zip Code"></div>

																    <div class="form-group form-data-grab"><button type="submit" class="btn btn-sm btn-gs px-4 my-2" style="border-radius:20px">Done</button></div>
																
										        			</div>
										        		</div>
										        	</div>
									          </form>
									        </div>
									      </li>
									    <!-- /Location Dropdown -->

									    <!-- Talent Dropdown -->
									       <li class="nav-item dropdown mx-2 my-1 my-md-0">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-talent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Talent
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									        	<form class="searchCriteriaForm" name="form2">
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Talent</p>
										        					<select class="custom-select my-2" style="border-radius:20px" id="artistType" name="TalentID">
																       	<option value="">What Kind of Artist?</option>
																       	<option value="groups">Groups</option>
																       	<?php 
																	    	foreach($talentList1D as $talentList1D_indy => $singleTal) {
																	    		echo '<option value="' . $talentList1D_indy . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
																	    	}
																	    ?>
																    </select>

																    <select class="d-none custom-select my-2" style="border-radius:20px" id="groupType" name="sGroupType">
																       	<option value="">What Type of Group?</option>
																       	<!-- <option value="all">All Groups</option> -->
																       	<?php 
																	    	foreach($groupTypeList as $sType) {
																	    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
																	    	}
																	    ?>
																    </select>

																    <select class="custom-select my-2" style="border-radius:20px" id="availability" name="sAvailability">
																       	<option value="">Availability</option>
																       	<option value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
																        <option value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
																        <option value="Will Play For Food (Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
																        <option value="Will Play For Free">Will Play for Free </option>
															       </select>

																    <button type="submit" class="btn btn-sm btn-gs px-4 my-2" style="border-radius:20px">Done</button>
										        			</div>
										        		</div>
										        	</div>
									          	</form>
									        </div>
									      </li>
									      <!-- /Talent Dropdown -->

									      <!-- Hourly Rate Dropdown -->
									      <li class="nav-item dropdown mx-2 my-1 my-md-0">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-rate" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Hourly Rate
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									        	<form class="searchCriteriaForm" name="form3">
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Hourly Rate</p>
																    <label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;display:block" for="">Min Rate/hr.</label>
															      	<input type="text" class="form-control" style="border-radius:20px" name="rate1" placeholder="0.00">
																	<label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;display:block" for="">Max Rate/hr.</label>
															      	<input type="text" class="form-control" style="border-radius:20px" name="rate2" placeholder="0.00">

																    <button type="submit" class="btn btn-sm btn-gs px-4 my-2" style="border-radius:20px">Done</button>
										        			</div>
										        		</div>
										        	</div>
									          	</form>
									        </div>
									      </li>
									      <!-- /Hourly Rate Dropdown -->

									      <!-- Age Dropdown -->
									      <li class="nav-item dropdown mx-2 my-1 my-md-0">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-age" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Age
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									        	<form class="searchCriteriaForm" name="form4">
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Age</p>

										        					<label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;display:block" for="">Min. Age</label>
																    <input type="text" class="form-control" style="border-radius:20px" name="dDOB1" placeholder="Min Age">
																    <label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;display:block" for="">Max. Age</label>
																	<input type="text" class="form-control" style="border-radius:20px" name="dDOB2" placeholder="Max Age">
																    <button type="submit" class="btn btn-sm btn-gs px-4 my-2" style="border-radius:20px">Done</button>

										        			</div>
										        		</div>
										        	</div>
									          	</form>
									        </div>
									      </li>
									      <!-- /Age Dropdown -->

									      <!-- Artist by name Dropdown -->
									      <li class="nav-item dropdown mx-2 my-1 my-md-0">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-name" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Artist's Name
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									        	<form class="searchCriteriaForm" name="form5">
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Artist's Name</p>

										        					<input type="text" class="form-control my-2" style="border-radius:20px" name="sFirstName" placeholder="First Name">
																	<input type="text" class="form-control my-2" style="border-radius:20px" name="sLastName" placeholder="Last Name">
																    <button type="submit" class="btn btn-sm btn-gs px-4 my-2" style="border-radius:20px">Done</button>

										        			</div>
										        		</div>
										        	</div>
									          	</form>
									        </div>
									      </li>
									      <!-- /Artist by name Dropdown -->	
								    
                    				</ul>
								  </nav>
              			</div>
					  </div>
					<!-- /Display the artist navigation section -->
				</div>
			
		</div>
	</div>

	<div class="row d-none">
		<div class="col-9 mx-auto"><h5>Search Filter</h5></div>
		<div class="col-12"></div>
	</div>

</div>

<!-- Artist Criteria Section -->
<div class="container mt-0 p-0 " style="width:100%">

	 <div class="container text-center text-gs py-2">
		<!-- <h1 class="m-0">Find An Artist Today!</h1> -->
    </div>

    <div class="row">
		<div class="col-12 col-md-9 mt-3 mt-md-0 mx-auto">
			<div class="container" id="artist_display_container">
				<div class="row mt-5">
					<div class="col-12" id="display_load_wheell"></div>
				</div>
			</div>

			<!-- Pagination -->
				<div class="container">
					<div class="row">
						<div class="col-12">
							<nav aria-label="Page navigation example">
							  <ul class="pagination justify-content-center" id="pagination_container">
							    
							  </ul>
							</nav>
						</div>
					</div>
				</div>
			<!-- /Pagination -->
		</div>
	</div>
	
</div>



<hr class="my-4"> <!-- Page Divider -->

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/footer.php");?>

<script src="<?php echo URL;?>artist/js/indexJSFunctions.js?33"></script>
<script src="<?php echo URL;?>artist/js/indexJS.js?16"></script>