<?php include('../include/header.php');?>
<?php
$cond = "sPageName = 'Help' AND isActive = 1";
$aboutus = $obj->fetchRow('cmsmaster',$cond);
?>
<section style="padding-top:50px;">
  <div class="container ">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12 big-title text-center">
        <h3>Help</h3>
        <hr>
       <?php
	   if(!empty($aboutus)){
			echo $aboutus['sDiscription'];   
		}else{
	   ?>
        <p> Page is Under Construction </p>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php include('../include/footer.php');?>