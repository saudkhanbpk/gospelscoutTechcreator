<?php 
	
	/************************************* Profile Book Me Tab Content *****************************/

?>

<!-- Book Me Container Header -->
	<?php 
		if($profGuest == 1){
	?>
		<form action="" method="post" enctype="multipart/form-data" id="donation-form" name="newDonation">
			<!-- Donor Address -->
			<h6 class="text-gs  mt-3">Address <span style="font-size:10px;">(tax purposes)</span></h6>
			<div class="row my-2">
				<div class="col">
					<input type="text" class="form-control form-control-sm" name="address" placeholder="Street Address">
				</div>
			</div>
			<div class="row my-2 p-0">
				<div class="col-12 col-md my-md-0 my-2">
					<select class="custom-select m-0 form-control-sm" name="gigdetails_venueState" id="state">
						<option>State</option>
						<?php
							foreach($states as $state){
						?>
				      			<option value="<?php echo $state['id'];?>"><?php echo $state['name']; ?></option>
				      	<?php
				      		}
			      		?>
					</select>
				</div>
				<div class="col-12 col-md my-md-0 my-2">
					<input type="text" class="form-control form-control-sm" name="gigdetails_venueCity" placeholder="city">
				</div>
				<div class="col-12 col-md my-md-0 my-2">
					<input class="form-control form-control-sm" type="text" name="gigdetails_venueZip" placeholder="Zipcode">
				</div>
			</div>
			<!-- /Donor Address -->

			<!-- Donation Type and Amount-->
			<h6 class="text-gs  mt-3">Donation Type and Amount</h6>
			<div class="row my-2 p-0">
				<div class="col-12 col-md-6 my-md-0 my-2">
					<select class="custom-select m-0 form-control-sm" name="gigdetails_gigPrivacy">
						<option>Donation Type</option>
						<option value="donation">Donation</option>
						<option value="offering">Offering</option>
						<option value="tithes">Tithes</option>
						<option value="pastorOffering">Pastor's Love Gift</option>
						<option value="pledge">Pledge</option>
						<option value="other">Other</option>
					</select>
				</div>
			</div>
			<div class="row mt-2 mb-4">
				<div class="col-12 col-md my-md-0 my-2">
					<label for="depAmount">Deposit Amount</label>
					<input class="form-control form-control-sm" id="depAmount" type="text" name="gigartists_deposit" placeholder="$ 0.00">
				</div>
			</div><!-- /Depost Amount and Date -->

			<!-- Prayer Requests for the pastor -->
				<h6 class="text-gs  mt-3">Prayer Requests</h6>
				<textarea class="form-control mb-2" name="gigrequests_message" placeholder="Prayer Request For The Pastor..." wrap="" rows="5" aria-label="With textarea"></textarea>
				<input type="hidden" name="gigrequests_artistUserId" value="<?php echo $userRow['iUserID'];?>">
			<!-- /Prayer Requests for the pastor -->

			<!-- Membership Status -->
				<div class="custom-control custom-checkbox">
				  <input type="radio" class="custom-control-input" id="memberDonation" name="memberStatus" value="1">
				  <label class="custom-control-label" for="memberDonation">Church Member</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="radio" class="custom-control-input" id="visitorDonation" name="memberStatus" value="1">
				  <label class="custom-control-label" for="visitorDonation">Visitor</label>
				</div>
			<!-- /Membership Status -->

			<!-- Create a Random HexaDecimal Gig Id - Using first 4 char of last name and --> 
				<?php
					$gigManagerName = $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];
					$first4 = substr($gigManagerName, 0, 4);
					$gigManLast = $first4;
					$randSuffix = mt_rand(100, 999);
					$str = $gigManLast . $randSuffix; 
					$gigId = bin2hex($str);
				?>
				<input type="hidden" name="gigId" value="<?php echo $gigId; ?>">
			<!-- /Random Gig Id Generator -->

			<!-- Create a TimeStamp when submitted -->
				<?php
					$currentDate = date('Y-m-d');
					echo '<input type="hidden" name="gigmaster_creationDate" value="' . $currentDate . '">';
				?>
			<!-- /Create a TimeStamp when submitted -->

			<!-- Donor's Information -->
				<input type="hidden" name="donorId" value="<?php echo $currentUserID; ?>">
				<input type="hidden" name="donorName" value="<?php echo $donorName; ?>">
				<input type="hidden" name="donorEmail" value="<?php echo $userInfo['sContactEmailID'];?>">
				<input type="hidden" name="donorPhone" value="<?php echo $userInfo['sContactNumber'];?>">
				<input type="hidden" name="gigmaster_creationDate" value="<?php echo $currentDate; ?>">
			<!-- /Donor's Information -->

			<!-- Church's Information -->
				<input type="hidden" name="churchId" value="<?php echo $userRow['iUserID'];?>">
				<input type="hidden" name="churchName" value="<?php echo $userRow['sFirstName'] . ' ' . $userRow['sLastName'];?>">
				<input type="hidden" name="churchEmail" value="<?php echo $userRow['sContactEmailID'];?>">
				<input type="hidden" name="churchPhone" value="<?php echo $userRow['sContactNumber'];?>">
			<!-- /Church's Information -->

			<!-- Identify Source page - Remedy code programmed to handle gigartists inputs from the createGig.php page -->
				<input type="hidden" name="srcPage" value="artistProfile">
			<!-- /Identify Source page - Remedy code programmed to handle gigartists inputs from the createGig.php page -->

			<!-- Create a Random Hexadecimal Gig Confirmation Id -->
				<input type="hidden" name="gigstatus_status" value="active">

			<button type="submit" class="btn btn-gs my-3 form-control-sm" id="sendRequest">Donate</button>
		</form>

	<?php
		}
		elseif($profOwner == 1){

			/* Check and see if the view column in the churchdonationtable is true or false */
			$query = 'SELECT churchdonationmaster.donationId
					  FROM churchdonationmaster 
					  WHERE churchdonationmaster.viewed = 0 AND churchdonationmaster.churchId = ? ';
			try{
				$newGigs = $db->prepare($query);
				$newGigs->bindParam(1, $churchUserID);
				$newGigs->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$newGig = $newGigs->fetchAll(PDO::FETCH_ASSOC);
			$newGigCount = count($newGig);

			echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You have <span class="text-gs">'. $newGigCount .'</span> new donation(s).</h1></div>';

			/* Create Button to view new gig requests if $newGigCount > 0 */
				if($newGigCount > 0){
					echo '<div class="container text-center"><a href="'. URL .'manageBooking/pendingGigs.php" class="btn btn-gs">View Donations</a></div>';
				}
			/* END - Create Button to view new gig requests if $newGigCount > 0 */
		}
		elseif($siteGuest == 1){
?>			
			<!-- Donors Information -->
			<div class="container">
				<form action="" method="post" enctype="multipart/form-data" id="donation-form" name="newDonation">
					<h6 class="text-gs  mt-3">Donor Info</h6>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="donorFirstName" placeholder="First Name">
						</div>
					</div>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="donorLastName" placeholder="Last Name">
						</div>
					</div>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="email" placeholder="Email Address">
						</div>
					</div>

					<!-- Donor Address -->
					<h6 class="text-gs  mt-3">Address <span style="font-size:10px;">(tax purposes)</span></h6>
					<div class="row my-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="donorAddress" placeholder="Street Address">
						</div>
					</div>
					<div class="row my-2 p-0">
						<div class="col-12 col-md my-md-0 my-2">
							<select class="custom-select m-0 form-control-sm" name="donorState" id="state">
								<option>State</option>
								<?php
									foreach($states as $state){
								?>
						      			<option value="<?php echo $state['id'];?>"><?php echo $state['name']; ?></option>
						      	<?php
						      		}
					      		?>
							</select>
						</div>
						<div class="col-12 col-md my-md-0 my-2">
							<input type="text" class="form-control form-control-sm" name="donorCity" placeholder="city">
						</div>
						<div class="col-12 col-md my-md-0 my-2">
							<input class="form-control form-control-sm" type="text" name="donorZipcode" placeholder="Zipcode">
						</div>
					</div>
					<!-- /Donor Address -->

					<!-- Donation Type and Amount-->
					<h6 class="text-gs  mt-3">Donation Type and Amount</h6>
					<div class="row my-2 p-0">
						<div class="col-12 col-md-6 my-md-0 my-2">
							<select class="custom-select m-0 form-control-sm" name="donationType">
								<option>Donation Type</option>
								<option value="donation">Donation</option>
								<option value="offering">Offering</option>
								<option value="tithes">Tithes</option>
								<option value="pastorOffering">Pastor's Love Gift</option>
								<option value="pledge">Pledge</option>
								<option value="other">Other</option>
							</select>
						</div>
					</div>
					<div class="row mt-2 mb-4">
						<div class="col-12 col-md my-md-0 my-2">
							<label for="depAmount">Deposit Amount</label>
							<input class="form-control form-control-sm" id="depAmount" type="text" name="gigartists_deposit" placeholder="$ 0.00">
						</div>
					</div><!-- /Depost Amount and Date -->

					<!-- Prayer Requests for the pastor -->
						<h6 class="text-gs  mt-3">Prayer Requests</h6>
						<textarea class="form-control mb-2" name="gigrequests_message" placeholder="Prayer Request For The Pastor..." wrap="" rows="5" aria-label="With textarea"></textarea>
						<input type="hidden" name="gigrequests_artistUserId" value="<?php echo $userRow['iUserID'];?>">
					<!-- /Prayer Requests for the pastor -->

					<div class="custom-control custom-checkbox">
					  <input type="radio" class="custom-control-input" id="memberDonation" name="memberStatus" value="1">
					  <label class="custom-control-label" for="memberDonation">Church Member</label>
					</div>
					<div class="custom-control custom-checkbox">
					  <input type="radio" class="custom-control-input" id="visitorDonation" name="memberStatus" value="1">
					  <label class="custom-control-label" for="visitorDonation">Visitor</label>
					</div>

					<!-- Create a Random HexaDecimal Gig Id - Using first 4 char of last name and --> 
						<?php
							$donorName = $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];
							$first4 = substr($gigManagerName, 0, 4);
							$gigManLast = $first4;
							$randSuffix = mt_rand(100, 999);
							$str = $gigManLast . $randSuffix; 
							$donationId = bin2hex($str);
						?>
						<input type="hidden" name="gigId" value="<?php echo $donationId; ?>">
					<!-- /Random Gig Id Generator -->

					<!-- Create a TimeStamp when submitted -->
						<?php
							$currentDate = date('Y-m-d');
							echo '<input type="hidden" name="donationDate" value="' . $currentDate . '">';
						?>
					<!-- /Create a TimeStamp when submitted -->

					<!-- Church's Information -->
						<input type="hidden" name="churchId" value="<?php echo $userRow['iUserID'];?>">
						<input type="hidden" name="churchName" value="<?php echo $userRow['sFirstName'] . ' ' . $userRow['sLastName'];?>">
						<input type="hidden" name="churchEmail" value="<?php echo $userRow['sContactEmailID'];?>">
						<input type="hidden" name="churchPhone" value="<?php echo $userRow['sContactNumber'];?>">
					<!-- /Church's Information -->

					<button type="submit" class="btn btn-gs my-3 form-control-sm" id="sendRequest">Donate</button>
				</form>
			</div>
			<!-- /Donor Information -->
<?php
		}
		else{
			echo '<div class="container mt-5 d-none text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Sorry we are have technical difficulties!!!  :-(</h1></div>';
		}
	?>
<!-- /Book Me Container Header -->

			

<script src="<?php echo URL;?>js/jquery-1.11.1.min.js"></script>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
<script>
	/* Send the New donation form to database church Profile page */
		var formExistingGig1 = document.forms.namedItem("book4new");
		formExistingGig1.addEventListener('submit', function(event){
			var userID1 = $('.userID').val();
			var existGigData1 = new FormData(formExistingGig1);
			var existingGig1 = new XMLHttpRequest();
			existGigData1.append('iLoginID', userID1);
			
			existingGig1.onreadystatechange = function(){
				if(existingGig1.readyState == 4 && existingGig1.status == 200){
					console.log(existingGig1.responseText);
				}
			}
			existingGig1.open("POST", "gigReceive.php");
			existingGig1.send(existGigData1); 

			document.getElementById("bookme-form").reset();
			event.preventDefault();
		}, false);
	/* END - Send the New Gig form to database from Artist Profile page */

	/* Send the 'Add new artist to an existing gig' form to database from Artist Profile page */
		var formExistingGig = document.forms.namedItem("book4existing");
		formExistingGig.addEventListener('submit', function(event){
			var userID = $('.userID').val();
			var existGigData = new FormData(formExistingGig);
			var existingGig = new XMLHttpRequest();
			existGigData.append('iLoginID', userID);
			
			existingGig.onreadystatechange = function(){
				if(existingGig.readyState == 4 && existingGig.status == 200){
					console.log(existingGig.responseText);
				}
			}
			existingGig.open("POST", "gigReceive.php");
			existingGig.send(existGigData); 

			document.getElementById("book4existing").reset();
			event.preventDefault();
		}, false);
	/* END - Send the 'Add new artist to an existing gig' form to database from Artist Profile page */
</script>