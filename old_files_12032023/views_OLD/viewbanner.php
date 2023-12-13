<?php include('../include/header.php'); ?>
<?php
if($objsession->get('gs_login_id') == 0){
	redirect(URL.'');	
}
?>
<div class="container">
    <?php if($objsession->get('gs_msg') != ""){?>
    <div class="suc-message"> <?php echo $objsession->get('gs_msg');?> </div>
    <?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
    <span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
    <?php
$objsession->remove('gs_error_msg');
}
?>
    <div class="carousel-holder">

    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?php if($objsession->get('gs_login_id') > 0){?>
        <a style="float:right;" class="newevent" href="<?php echo URL;?>views/managebanner.php">New Banner</a>
        <?php } ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="all">
                <div class="col-lg-12 col-md-12 col-sm-12 chang m0">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt20">
                        <?php   

$rolemaster = array();

if($objsession->get('gs_login_id') > 0){
	$cond="isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id')." ORDER BY iBannerID DESC"; 	
}

$rolemaster = $obj->fetchRowAll("bannermaster",$cond);
$rolemaster1 = $obj->fetchNumOfRow("bannermaster",$cond);

$i=0;
if($rolemaster1 > 0){
for($i=0;$i<$rolemaster1;$i++){
	
 ?>
                        <div class="col-lg-3 col-mg-3 col-sm-3">
                            <div class="hovereffect"> <img class="" src="<?php echo URL;?>upload/banners/<?php echo $rolemaster[$i]['banner_name'];?>" alt="">
                            </div>
                            <a href="<?php echo URL;?>views/viewbanner.php?iBannerID=<?php echo $rolemaster[$i]['iBannerID'];?>" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i style="margin-top: 10px;" class="fa fa-fw fa-remove"></i> <span style="margin-left: 5px;">Remove</span></a> | <a href="<?php echo URL;?>views/managebanner.php?iBannerID=<?php echo $rolemaster[$i]['iBannerID'];?>" title="Edit" ><i style="margin-top: 10px;" class="fa fa-fw fa-edit"></i> <span style="margin-left: 5px;">Edit</span></a>
                        </div>
                        <?php if($i == 4){?>
                        <div style="clear:both;" class="mb20"></div>
                        <?php } ?>
                        <?php }?>
                        <?php }else{ ?>
                        <div class="col-lg-12 col-mg-12 col-sm-12">
                            <p>There are currently no banner listed.</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_GET['iBannerID'])){
		
	 $iBannerID = $_GET['iBannerID'];
	 $bannermaster = $obj->fetchRow('bannermaster','iBannerID = '.$_GET['iBannerID']);
		
	deleteImage($bannermaster['banner_name'],'upload/banners');
		
		if($obj->delete('bannermaster',"iBannerID = ".$_GET['iBannerID']) == true){
			echo "<script>alert('Banner successfully deleted.');</script>";
			redirect(URL."views/viewbanner.php");
		}
}
?>
<?php include('../include/footer.php'); ?>
