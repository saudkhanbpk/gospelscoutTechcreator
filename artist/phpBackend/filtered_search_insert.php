<!-- Search Form tab -->
		<div class="container bg-white  px-2  text-left" style="max-height:545px; overflow:scroll;">
			<form id="searchCriteriaForm" name="searchCriteriaForm">
			  <div class="row form-group">
			    <div class="col-12 mt-2">
			    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Location</label>
			       <?php 
			      	$states = $obj->fetchRowAll("states",'country_id = 231'); 
			      ?>
			      <select class="custom-select form-control" id="state" name="sStateName">
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
			    <div class="col-12 mt-2">
			       <input type="text" class="form-control" name="sCityName" placeholder="City">
			    </div>
			    <div class="col-12 mt-2">
			      <input type="text" class="form-control" name="iZipcode" placeholder="Zip Code">
			    </div>
			    <div class="col-12 mt-2">
			       <select class="custom-select" id="artistType" name="TalentID">
			       	<option value="">What Kind of Artist?</option>
			       	<option value="groups">Groups</option>
			       	<?php 
				    	foreach($talentList1D as $talentList1D_indy => $singleTal) {
				    		echo '<option value="' . $talentList1D_indy . '" >' . str_replace("_", "/", $singleTal) . '</option>'; 
				    	}
				    ?>
			       </select>
			    </div>
			    <div class="col-12 mt-2 d-none" id="groupTypeContainer">
			       <select class="custom-select" id="groupType" name="sGroupType">
			       	<option value="">What Type of Group?</option>
			       	<?php 
				    	foreach($groupTypeList as $sType) {
				    		echo '<option value="' . $sType['id'] . '" >' . str_replace("_", "/", $sType['sTypeName']) . '</option>'; 
				    	}
				    ?>
			       </select>
			    </div>
			    <div class="col-12 mt-2">
			       <select class="custom-select" id="availability" name="sAvailability">
				       	<option value="">Availability</option>
				       	<option value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
				        <option value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
				        <option value="Will Play For Food (Just Cover my cost to get there and back)">Will Play for Food (Just Cover my cost to get there and back)</option>
				        <option value="Will Play For Free">Will Play for Free </option>
			       </select>
			    </div>
			  </div>

			  	<div id="hourlyRate">
				    <div class="row form-group">
					    <div class="col-12 mt-2">
					    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Min Hourly Rate/hr.</label>
					      	<input type="text" class="form-control" name="rate1" placeholder="0.00">
					    </div>
					    <div class="col-12 mt-2">
					    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold;display:block" for="">Max Hourly Rate/hr.</label>
					      	<input type="text" class="form-control" name="rate2" placeholder="0.00">
					    </div>
					    <div class="col-12 mt-2 pt-md-4">
					    	<label class="text-gs mb-0 bg-warning" style="font-size:10px;font-weight:bold;display:block" for="">(Artist with an unlisted rate will not appear in search results.)</label>
					    </div>
					</div>
					<div class="d-none" id="rateErr"></div>
				</div>
			  	<div id="ageDiv">
				    <div class="row form-group">
					    <div class="col-12 mt-2">
					    	<label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Age</label>
					      	<input type="text" class="form-control" name="dDOB1" placeholder="Min Age">
					    </div>
					    <div class="col-12 mt-2">
					      <input type="text" class="form-control" name="dDOB2" placeholder="Max Age">
					    </div>
					</div>
					<div class="d-none" id="ageErr"></div>
				</div>
			  <h5 class="text-gs">OR</h5>
			  Looking for a Specific Artist? 
			    <div class="row form-group">
				    <div class="col-12 mt-2">
				      <input type="text" class="form-control" name="sFirstName" placeholder="First Name">
				    </div>
				    <div class="col-12 mt-2">
				      <input type="text" class="form-control" name="sLastName" placeholder="Last Name">
				    </div>
				</div>
			</form>
		</div>

		<div class="container border-top">
			<div class="row">
				<div class="col-12 pt-2" >
					<button type="button" class="btn btn-gs" id="searchArtist" style="">Search</button>
				</div>
			</div>
		</div>
	<!-- Search Form tab -->