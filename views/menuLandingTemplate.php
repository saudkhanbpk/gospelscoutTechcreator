<?php 
	/* Menu Landing Page Template */
	if($currentUserID == ''){
		echo '<script>window.location = "'. URL .'index.php";</script>';
		exit;
	}
?>

<div class="container bg-white mt-5 mb-3 px-5 py-3" style="max-width:900px;min-height:700px">
	<div class="container my-2">
		<div class="row">
			<div class="col text-center py-4" style="">
				<h3 class="text-gs"><?php echo $page; ?></h3>
			</div>
		</div>
	</div>
	<div class="container py-md-5 px-md-5 mb-3" style="border-bottom: 2px solid rgba(149,73,173,.5);border-top: 2px solid rgba(149,73,173,.5);">
		<div class="row m-auto px-md-5" style="max-width:700px;">
			<?php foreach($menuItems as $item => $pageLink){?>
				<div class="col-10 col-md-4 mx-auto mx-md-0 my-2 my-md-2 py-md-4 px-md-3">
					<a href="<?php echo $pageLink;?>" style="text-decoration: none;" page="<?php echo $item;?>">
						<div class="m-auto m-md-0 p-3 text-center" style="height:150px;max-width:160px;border:1px solid rgba(149,73,173,1);border-radius:10px;background-color: rgb(233,234,237)">
							<h4 class="text-gs"><?php echo $item; ?></h4>
							<!-- <div class="p-2 d-none hover-mess" style="width:130px;height:130px;font-size:12px; border-radius:10px; position:absolute;left:0px">THis is a test</div>-->
						</div>
					</a>
				</div>
				
			<?php } ?>
		</div>
	</div>
</div>
<script>
	/*$('a').hover(function(){
		console.log(this);
		var thisAnchor = $(this); 
		$(thisAnchor+'div.hover-mess').removeClass('d-none'); 
	});*/
</script>

<!--
	Public Gig Post
		When you create a public gig post, you are essentially putting out a job ad for public response.  In addition, artists that meet the qualifications of the 
		gig will automatically be notified about the new post and encouraged to express interest.   


-->