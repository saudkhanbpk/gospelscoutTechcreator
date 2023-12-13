<?php 
	/* Public post template */

	/* Seperate results by status: Pending or Confirmed */
		foreach ($upcomingPublicPosts as $val) {
			if($val['status'] == 'Pending'){
				$posts['pending'][0] = $val;
			}
			elseif($val['status'] == 'booked'){
				/* Get the selected artist's name and add to the $posts['booked'] array */
					$table1 = 'usermaster';
					$artistCol = array('sFirstName', 'sLastName');
					$artistCond['iLoginID']['='] = $val['selectedArtist'];
					$selArtist = pdoQuery($table1,$artistCol,$artistCond);
					
				$posts['booked'][1] = $val;
				$posts['booked'][1]['selectedArt'] = $selArtist[0]['sFirstName'] .  ' ' . $selArtist[0]['sLastName'];
			}
		}
?>

<div class="container bg-white mt-5 mb-3 px-2 py-3" style="max-width:900px;min-height:700px">
	<div class="container mt-2 mb-1">
		<div class="row">
			<div class="col text-center py-4" style="">
				<h3 class="text-gs"><?php echo $page; ?></h3>
			</div>
		</div>
	</div>
	<div class="container py-md-5 px-md-5 mb-3" style="border-top: 2px solid rgba(149,73,173,.5);">
		<div class="row m-auto px-md-2 py-2" style="max-width:700px;border-bottom: 1px solid rgba(149,73,173,.5);">
			<div class="col text-center text-md-left pl-md-2">
				<a href="#" data-toggle="collapse" data-target="#pendingG" aria-expanded="false" aria-controls="" class="text-gs" style="text-decoration:none;"><h4>Pending Gig Posts</h4></a>
				<div class="collapse" id="pendingG">
					<?php if(count($posts['pending']) > 0){?>
					<table class="table table-striped text-gs">
						<thead style="font-size:12px">
							<tr>
								<th>Gig Name</th>
								<th>Gig Date</th>
								<th>Status</th>
							</tr>
							<?php 
								foreach($posts['pending'] as $pendPosts){
									$g_date = date_create($pendPosts['gigDate']);
									$g_date = date_format($g_date, 'm-d-Y');
									echo '<tr>';
										echo '<td><a class="text-gs" href="' . URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $pendPosts['gigId'] . '">' . $pendPosts['gigName'] . '</a></td>';		
										echo '<td><a class="text-gs" href="' . URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $pendPosts['gigId'] . '">' . $g_date . '</a></td>';		
										echo '<td><a class="text-gs" href="' . URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $pendPosts['gigId'] . '">' . $pendPosts['status'] . '</a></td>';		
									echo '</tr>';
								}
							?>
						</thead>
					</table>
					<?php }else{
                            echo '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-3"><div class="col p-lg-3"><h2 class="" style="color: rgba(204,204,204,1)">No Pending Gig Posts!!!</h2></div></div></div>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="row m-auto px-md-2 py-2" style="max-width:700px;border-bottom: 1px solid rgba(149,73,173,.5);">
			<div class="col text-center text-md-left pl-md-2">
				<a href="#" data-toggle="collapse" data-target="#bookedG" aria-expanded="false" aria-controls="" class="text-gs" style="text-decoration:none;"><h4>Booked Gig Posts</h4></a>
				<div class="collapse" id="bookedG">
					<?php if(count($posts['booked']) > 0){?>
					<table class="table table-striped text-gs">
						<thead style="font-size:12px">
							<tr>
								<th>Gig Name</th>
								<th>Gig Date</th>
								<th>Status</th>
								<th>Selected Artist</th>
							</tr>
							<?php 
								foreach($posts['booked'] as $pendPosts){
									$g_date = date_create($pendPosts['gigDate']);
									$g_date = date_format($g_date, 'm-d-Y');
									$sel_artist = truncateStr($pendPosts['selectedArt'], 10); 
									echo '<tr>';
										echo '<td><a class="text-gs" href="' . URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $pendPosts['gigId'] . '">' . $pendPosts['gigName'] . '</a></td>';		
										echo '<td><a class="text-gs" href="' . URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $pendPosts['gigId'] . '">' . $g_date . '</a></td>';		
										echo '<td><a class="text-gs" href="' . URL . 'views/xmlhttprequest/pubGigBackbone.php?id=' . $pendPosts['gigId'] . '">' . $pendPosts['status'] . '</a></td>';		
										echo '<td><a class="text-gs" href="' . URL . 'views/artistProfile.php?artist=' . $pendPosts['selectedArtist'] . '" target="_blank">' . $sel_artist . '</a></td>';		
									echo '</tr>';
								}
							?>
						</thead>
					</table>
					<?php }else{
                            echo '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-3"><div class="col p-lg-3"><h2 class="" style="color: rgba(204,204,204,1)">No Booked Gig Posts!!!</h2></div></div></div>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>