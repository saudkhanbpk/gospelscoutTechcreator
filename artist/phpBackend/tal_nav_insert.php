
<!-- Talent Categories -->
	<!-- Display on large screens -->
	<div class="container py-0 px-2 m-0 d-none d-md-block" style="max-height:585px; overflow:scroll;">
		<div class="row" id="talent_buttons">
			<div class="col-12 my-1">
				<button talent="all" artistType="artist" type="button" class="btn btn-sm btn-gs rounded talentGroup" style="border-radius:20px; width:100%">All</button>
			</div>
			<?php foreach($talentList1D as $talentList1D_index => $talentList1D_val){?>
				<div class="col-12 my-1">
					<button talent="<?php echo $talentList1D_index;?>" artistType="artist" type="button" class="btn btn-sm btn-gs rounded talentGroup" style="border-radius:20px; width:100%"><?php echo $talentList1D_val;?></button>
				</div>
			<?php }?>
		</div>
	</div>

<!-- Display on small screens -->
	<div class="container p-0 m-0 d-md-none">
		<div class="row">
			<div class="col-12 my-1">
				<!-- Default dropright button -->
					<div class="btn-group dropright">
					  	<button type="button" class="btn btn-primary dropdown-toggle m-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Search by Talent
					  	</button>

					  	<div class="dropdown-menu" aria-labelledby="dropdownMenuButon" style="max-height: 500px;overflow:scroll;">
					  		<a class="dropdown-item talentGroup" artistType="artist" talent="all" href="#' . $singleTal . '">All</a>
							<?php foreach($talentList1D as $talentList1D_index => $talentList1D_val){?>
								<a class="dropdown-item talentGroup" artistType="artist" talent="<?php echo $talentList1D_index;?>" href="#' . $singleTal . '"><?php echo $talentList1D_val;?></a>
							<?php }?>
						</div>
					</div>
				<!-- /Default dropright button -->
			</div>
		</div>
	</div>




