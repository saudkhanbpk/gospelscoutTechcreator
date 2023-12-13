<?php 
	
	/************************************* Profile Bio Tab Content *****************************/

	if($artistUserID){
?>
		<div class="container">
			<h6 class="text-gs">Years of Experience</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['iYearOfExp'] != ''){
							echo $userRow['iYearOfExp'];
						}
						else{
							echo 'N/A';
						}
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">Musical Influences</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['sMusicalInstrument'] != ''){
							echo $userRow['sMusicalInstrument'];
						}
						else{
							echo 'N/A';
						}
					
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">Music Genre</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['sKindPlay'] != ''){
							echo $userRow['sKindPlay'];
						}
						else{
							echo 'N/A';
						}
					
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">Relevant Playing Experience</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['sHavePlayed'] != ''){
							echo $userRow['sHavePlayed'];
						}
						else{
							echo 'N/A';
						}
					
					?>
				</p>
				</p>
			</div>
		</div>
<?php 
	} 
	elseif($churchUserID){
		/* Query Database for Church Bio Information */
			/* AMENITIES */
				/* Get current Church Amenities */
					$query = 'SELECT * FROM churchamenitymaster2 WHERE iLoginID = ?';
					try{
						$currentAmenities = $db->prepare($query);
						$currentAmenities->bindParam(1, $churchUserID);
						$currentAmenities->execute(); 
					}
					catch(Exception $e){
						echo $e; 
					}
					$churchAmen = $currentAmenities->fetchAll(PDO::FETCH_ASSOC);
					// echo '<pre>';
					// var_dump($churchAmen);
				/* END - Get current Church Amenities */

				/* Fetch Amenity List */
					// $query1 = 'SELECT * FROM amenitimaster';
					// try{
					// 	$currentAmenities1 = $db->prepare($query1);
					// 	$currentAmenities1->execute(); 
					// }
					// catch(Exception $e){
					// 	echo $e; 
					// }
					// $currentAmenitiesList = $currentAmenities1->fetchAll(PDO::FETCH_ASSOC);
				/* END - Fetch Amenity List */
				
				// foreach($churchAmen as $index => $value){
				// 	foreach($currentAmenitiesList as $listItem){
				// 		if($index == $listItem['iAmityID'] && $value == '1'){
				// 			$amenList[] = $listItem['sAmityName'];
				// 		}
				// 	}
				// }
			/* END - AMENITIES */

			/* MINISTIRES */
				$queryMin = 'SELECT giftmaster1.sGiftName 
							 FROM churchministrymaster2
							 INNER JOIN giftmaster1 on churchministrymaster2.iGiftID = giftmaster1.iGiftID
							 WHERE churchministrymaster2.iLoginID = ?
							 ';

				try{
					$getMinistries = $db->prepare($queryMin);
					$getMinistries->bindParam(1, $churchUserID);
					$getMinistries->execute(); 
				}
				catch(Exception $e){
					echo $e; 
				}
				$minList = $getMinistries->fetchAll(PDO::FETCH_ASSOC);
			/* END - MINISTIRES */
		?>

		<div class="container">
			<h6 class="text-gs">Church Amenities</h6>
			<div class="">
				<p>
					<?php 
						if(count($churchAmen) > 0){
							echo '<ol style="margin:0;" class="pl-4">';
								foreach($churchAmen as $amenItem){
									echo '<li>';
										echo $amenItem['amenityName']; 
									echo '</li>';
								}
							echo '</ol>';
						}
						else{
							echo 'N/A';
						}
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">Church Ministries</h6>
			<div class="">
				<p>
					<?php 
						if(count($minList) > 0){
							echo '<ol style="margin:0;" class="pl-4">';
								foreach($minList as $minItem){
									echo '<li>';
										echo str_replace("_","/",$minItem['sGiftName']); 
									echo '</li>';
								}
							echo '</ol>';
						}
						else{
							echo 'N/A';
						}
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">Mission Statement</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['sMission'] != ''){
							echo $userRow['sMission'];
						}
						else{
							echo 'N/A';
						}
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">When church was founded</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['sYearFounded'] != ''){
							echo $userRow['sYearFounded'];
						}
						else{
							echo 'N/A';
						}
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
		<div class="container">
			<h6 class="text-gs">Founding Pastor</h6>
			<div class="">
				<p>
					<?php 
						if($userRow['sFounderName'] != ''){
							echo $userRow['sFounderName'];
						}
						else{
							echo 'N/A';
						}
					?>
				</p>
			</div>
			<hr class="my-1"> <!-- Page Divider -->
		</div>
<?php
	}
?>