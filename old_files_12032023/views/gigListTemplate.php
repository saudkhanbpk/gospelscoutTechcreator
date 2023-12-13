<?php 
	/* Gig List Template */

	/* Menu Landing Page Template */
	if($currentUserID == ''){
		echo '<script>window.location = "'. URL .'index.php";</script>';
		exit;
	}

	$today = date_create(date());
	$today = date_format($today, 'Y-m-d H:i:s');
		
	/* Find Upcoming, Past, & Cancelled Gigs */
		foreach($pageArray as $manGig){
			
			if($manGig['gigDetails_gigStatus'] == 'active'){
				unset($manGig['gigDetails_gigStatus']);
				if($manGig['gigDetails_setupTime'] > $today){
					$manGig['gigDetails_setupTime'] = date_create($manGig['gigDetails_setupTime']);
					$manGig['gigDetails_setupTime'] = date_format($manGig['gigDetails_setupTime'], 'm-d-Y');

					$manGig['gigDetails_creationDate'] = date_create($manGig['gigDetails_creationDate']);
					$manGig['gigDetails_creationDate'] = date_format($manGig['gigDetails_creationDate'], 'm-d-Y');
					$upcomingGigs[] = $manGig; 
				}
				elseif($manGig['gigDetails_setupTime'] <= $today){
					$manGig['gigDetails_setupTime'] = date_create($manGig['gigDetails_setupTime']);
					$manGig['gigDetails_setupTime'] = date_format($manGig['gigDetails_setupTime'], 'm-d-Y');

					$manGig['gigDetails_creationDate'] = date_create($manGig['gigDetails_creationDate']);
					$manGig['gigDetails_creationDate'] = date_format($manGig['gigDetails_creationDate'], 'm-d-Y');
					$pastGigs[] = $manGig; 
				}
			}
			elseif($manGig['gigDetails_gigStatus'] == 'cancelled'){
				unset($manGig['gigDetails_gigStatus']);
				$manGig['gigDetails_setupTime'] = date_create($manGig['gigDetails_setupTime']);
				$manGig['gigDetails_setupTime'] = date_format($manGig['gigDetails_setupTime'], 'm-d-Y');

				$manGig['gigDetails_creationDate'] = date_create($manGig['gigDetails_creationDate']);
				$manGig['gigDetails_creationDate'] = date_format($manGig['gigDetails_creationDate'], 'm-d-Y');
				$cancelledGigs[] = $manGig; 
			}
		}
	/* END - Find Upcoming, Past, & Cancelled Gigs */


	/* Function to display the gig tables in each section */
		function listGigs($sectTitle, $collapseID, $table){
			/* Table Header Array */
				$headerArray = array('Gig ID','Name of Gig','Date of Gig','Date Created','Email Artists');

			echo '<div class="row m-auto px-md-2 py-2" style="max-width:700px;border-bottom: 1px solid rgba(149,73,173,.5);"><div class="col text-center text-md-left pl-md-2">';
			echo '<a href="#" data-toggle="collapse" data-target="#' . $collapseID . '" aria-expanded="false" aria-controls="' . $collapseID . '" class="text-gs" style="text-decoration:none;"><h4>' . $sectTitle . ' Gigs</h4></a>';
			echo '<div class="collapse" id="' . $collapseID  . '">';
			if(count($table) > 0){
				echo '<table class="table table-striped text-gs"><thead style="font-size:12px"><tr>';
								
					/* Class to adapt table to small screens */ 
						$smallScreenClass = "d-none d-md-table-cell";

					foreach($headerArray as $header){
						if($header == 'Date Created' || $header == 'Email Artists'){
							echo '<th class="' . $smallScreenClass . '">' . $header . '</th>';
						}
						else{
							echo '<th>' . $header . '</th>';
						}
					}
								
				echo '</tr></thead>';

				echo '<tbody style="font-size:10px;">';
						
						foreach($table as $gig){
							// echo '<pre>';
							// var_dump($gig);
							echo '<tr class="text-truncate">';
					
							foreach($gig as $index => $gigItem){
								if(strlen($gigItem) > 10){
									$gigItem1 = substr_replace($gigItem, '...', 10);
								}
								else{
									$gigItem1 = $gigItem;
								}
						
								if($index == 'dateCreated'){
									echo '<td class=" ' . $smallScreenClass . '"><a class="text-gs" href="gigform.php?gigID=' . $gig['gigId'] . '" style="text-decoration:none">' . $gigItem1 . '</a></td>';
								}
								else{
									echo '<td><a class="text-gs" href="gigform.php?gigID=' . $gig['gigId'] . '" style="text-decoration:none">' . $gigItem1 . '</a></td>';
								}
							}
					
							echo '<td class="d-none d-md-table-cell"><a href=""><img id="emailIcon" src="../img/envelope.png"></a></td></tr>';
						}
				echo '</tbody></table>';
			}
			else{
				echo 'N/A';
			}

			echo '</div></div></div>';
		}
	/* END - Function to display the gig tables in each section */

	$gigClass0 = 'Upcoming';
	$gigClass1 = 'Past';
	$gigClass2 = 'Cancelled';
	$collapseID0 = 'upcomingTable';
	$collapseID1 = 'pastTable';
	$collapseID2 = 'cancelledTable';
 ?>
	
		<div class="container mt-2 mb-1">
			<div class="row">
				<div class="col text-center py-4" style="">
					<h3 class="text-gs"><?php echo $page; ?></h3>
				</div>
			</div>
		</div>
		<div class="container py-md-5 px-md-5 mb-3" style="border-top: 2px solid rgba(149,73,173,.5);">
			<?php
				listGigs($gigClass0, $collapseID0, $upcomingGigs);
				listGigs($gigClass1, $collapseID1, $pastGigs);
				listGigs($gigClass2, $collapseID2, $cancelledGigs);
			?>
		</div>

