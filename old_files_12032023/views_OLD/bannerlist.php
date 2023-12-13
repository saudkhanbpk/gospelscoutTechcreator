<?php


	if (isset($_GET['artist'])) {
		$abc=$_GET['artist'];
		$cond="isActive = 1 AND iLoginID = '$abc' ORDER BY iBannerID DESC"; 	
	} else if(isset($_GET['church'])){
		$cond="isActive = 1 AND iLoginID = ".$_GET['church']." ORDER BY iBannerID DESC"; 	
	}
	else if($objsession->get('gs_login_id') > 0)
	{
		$cond="isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id')." ORDER BY iBannerID DESC";
	}


$rolemaster = $obj->fetchRowAll("bannermaster",$cond);
$rolemaster1 = $obj->fetchNumOfRow("bannermaster",$cond);
if ( $rolemaster1 > 0 ){		 
?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
  <?php 
  for($i=0;$i<$rolemaster1;$i++){
  ?>
    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i;?>" ></li>
    <?php } ?>
  </ol>
  <div class="carousel-inner">
  <?php 
  for($i=0;$i<$rolemaster1;$i++){
  ?>
    <div class="item <?php if($i == 0){?>active<?php } ?>"> <img class="slide-image" src="<?php echo URL;?>upload/banners/<?php echo $rolemaster[$i]['banner_name'];?>" alt=""> </div>
   <?php }?>
  </div>
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a>
   <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a> 
   </div>
<?php	
}else{
	
?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active"> <img class="slide-image" src="../img/slider01.jpg" alt=""> </div>
    <div class="item"> <img class="slide-image" src="../img/slider2.jpg" alt=""> </div>
    <div class="item"> <img class="slide-image" src="../img/slider3.jpg" alt=""> </div>
  </div>
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a> <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a> </div>
<?php } ?>
