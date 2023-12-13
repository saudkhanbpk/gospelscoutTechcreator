<!-- Modal introduce the payment modal and collect payment information -->
    <div class="modal fade" id="bidToGig" tabindex="-1" role="dialog" aria-labelledby="bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Post A Gig Ad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- style the stripe form -->
                <style>
                    /**
                    * The CSS shown here will not be introduced in the Quickstart guide, but shows
                    * how you can use CSS to style your Element's container
                    */
                    .StripeElement {
                        box-sizing: border-box;

                        height: 40px;
                        color: blue;
                        padding: 10px 12px;
                        display: block;
                        border: 1px solid transparent;
                        border-radius: 4px;
                        background-color: white;

                        box-shadow: 2px 1px 3px 2px #d2d7dd;// e6ebf1
                        -webkit-transition: box-shadow 150ms ease;
                        transition: box-shadow 150ms ease;
                    }

                    .StripeElement--focus {
                        box-shadow: 0 1px 3px 0 #cfd7df;
                    }

                    .StripeElement--invalid {
                        border-color: #fa755a;
                    }

                    .StripeElement--webkit-autofill {
                        background-color: #fefde5 !important;
                    }
                    ul {
                        list-style: none;
                    }
                    li {
                        font-size: 12px;
                    }
                </style>

            <!-- Modal Body -->
                <div class="modal-body mt-0">   
                    <!-- Carousel this div with 2 slides: 1. to introduce the pricing model, 2.  to collect card info for tokenization -->
                    <div id="carouselExampleIndicators" class="carousel mb-0"  data-interval="false" style="max-height:350px" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item bg-white active" style="max-height:125px;overflow:hidden;overflow:scroll">
                                <div class="container">
                                     <div class="row mb-1">
                                        <div class="col text-center">
                                            <h5>How it Works</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <ol>
                                                <li>Create & Publish your gig ad for only $1.00.</li>
                                                <li>We will reach out to artists that meet your post's criteria.</li>
                                                <li>Kick back and wait for talented & qualified artist's inquiries to start rolling in!</li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item mt-0 pt-1 bg-white" style="max-height:225px">
                                <div class="container mt-0">
                                    <div class="row mb-1">
                                        <div class="col text-center">
                                             <h5>Payment Info</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size:12px">Enter card info here.  Your card info is securely transmitted and stored using our stripe api interface.  <span class="font-weight-bold">Once you enter your card info the first time you don't have to enter it again.</span></p>
                                        </div>
                                    </div>
                                    <form class="" action="<?php echo URL;?>views/xmlhttprequest/stripeApiTest.php" method="post" id="payment-form">
                                        <div class="form-row">
                                            <div class="container pb-1">
                                                <p class="mb-0">Credit or debit card</p>
                                            </div>
                                            <div class="col d-block" id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display Element errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-gs mt-3">Submit</button>
                                    </form>
                                    
                                </div> 
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12" id="token_err_div"></div>
                                    </div> 
                                </div>  
                            </div>
                        </div>
                    </div> 
                    <div class="container">
                        <div class="row">
                            <div class="col text-center mt-2">
                                <a href="#" class="slide1 text-gs font-weight-bold">Enter Card Info -></a>
                                <a href="#" class="slide2 text-gs font-weight-bold  d-none"><- How it Works</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <script>
                    var car = $('.carousel');

                    $('.slide1').click(function(event){
                        event.preventDefault();
                        $('.slide1').addClass('d-none');
                        $('.slide2').removeClass('d-none');
                        car.carousel('next');
                        car.carousel('pause');  

                    });

                    $('.slide2').click(function(event){
                        event.preventDefault();
                        $('.slide2').addClass('d-none');
                        $('.slide1').removeClass('d-none');
                        car.carousel('prev');
                        car.carousel('pause');  
                    });
                </script>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer px-4" style="font-size:13px">
                    <div class="checkbox container p-0" id="postDisplay-sm"> 
                        <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
                        <img class="" src="<?php echo URL;?>img/stripeLogo.png" height="30px" width="50px">
                    </div>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal introduce the payment modal and collect payment information -->

<!-- Modal to confirm a bid on a gig -->
    <div class="modal fade" id="conf_bidToGig" tabindex="-1" role="dialog" aria-labelledby="conf_bidToGig" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="exampleModalLongTitle">Submit Gig Ad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                            	<div class="m-0 p-0 text-center" id="replace_usage">
                                    <h4>Post gig for $1.00</h4>
                                     <p class="text-gs font-weight-bold mt-3">Click below to post gig</p>
			                    </div>
		                       
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs sendPost" id="submitInquiry" data-dismiss="modal" aria-label="Close">Post Gig</button>
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to confirm a bid on a gig -->


<!-- Modal to gig manager that removing talent will remove selected artist -->
    <div class="modal fade" id="art_rem_warn" tabindex="-1" role="dialog" aria-labelledby="art_rem_warn" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-warning font-weight-bold" id="exampleModalLongTitle">Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                                <p> Removing this talent when update is clicked, will also remove the selected artist.  Simply, refresh the page if this is not the intended action.</p>
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to gig manager that removeing talent will remove selected artist -->

<!-- Modal to directly request an artist -->
    <div class="modal fade" id="direct_request" tabindex="-1" role="dialog" aria-labelledby="direct_request" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <!-- Error Message Display -->
                <div class="container p-3 text-center mb-0 d-none" id="error-message-photo1">
                    <p class="m-0 p-2 card-shadow text-white bg-gs" id="error-text-photo1" style="border-radius:7px"></p>
                </div>
            <!-- /Error Message Display --> 

            <!-- Modal Title -->
                <div class="modal-header">
                    <h5 class="modal-title text-gs font-weight-bold" id="direct_request_title" >Select an Artist</h5><!--id="exampleModalLongTitle"-->
                    <input type="hidden" name="rand_var" value="">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- /Modal Title -->

            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="font-size:14px;">
                                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                    <ul class="navbar-nav mx-auto" style="font-size:.8em;"> 
                                        <!-- Location Dropdown -->
                                        
									      <li class="nav-item dropdown mx-2 my-1">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-location" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Loation
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown-location">
										        <form class="searchCriteriaForm" name="form1" >
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Location</p>
										        					<?php 
																      	$states = $obj->fetchRowAll("states",'country_id = 231', $db); 
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
									       <li class="nav-item dropdown mx-2 my-1">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-talent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Talent
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									        	<form class="searchCriteriaForm" name="form2">
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Talent</p>
										        					<select class="custom-select my-2" style="border-radius:20px" id="artistTypeSearch" name="TalentID">
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

                                           <!-- Min Pay Dropdown -->
									      <li class="nav-item dropdown mx-2 my-1">
									        <a class="nav-link dropdown-toggle rounded-pill categ_pills px-5" style="color:rgba(149,73,173,1)" href="#" id="navbarDropdown-rate" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									          Mininum Pay
									        </a>
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									        	<form class="searchCriteriaForm" name="form3">
										        	<div class="container" style="min-width: 300px">
										        		<div class="row mx-auto">
										        			<div class="col-12">
										        				<p class="my-0 font-weight-bold">Minimum Pay</p>
																    <label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;display:block" for="">Min. Pay</label>
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
									      <li class="nav-item dropdown mx-2 my-1">
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
									      <li class="nav-item dropdown mx-2 my-1">
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
                    </div>
                    
                    <!-- Artist disply Section -->
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
                     <!-- /Artist disply Section -->                                                   
                </div>
             <!-- /Modal Body -->

            <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-gs" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            <!-- /Modal Footer -->
        </div>
      </div>
    </div>
<!-- /Modal to directly request an artist -->









