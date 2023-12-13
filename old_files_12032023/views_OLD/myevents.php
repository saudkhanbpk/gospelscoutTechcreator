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
        <div class="col-md-12 borderbuttom"> <img src="../img/slider2.jpg" class="img-responsive"> </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?php if($objsession->get('gs_login_id') > 0){?>
        <a style="float:right;" class="newevent" href="<?php echo URL;?>views/event.php">Add New Event</a>
        <?php } ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="all">
                <div class="col-lg-12 col-md-12 col-sm-12 chang m0">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt20">
                        <?php   

$rolemaster = array();

if($objsession->get('gs_login_id') > 0){
	$cond="isActive = 1 AND iLoginID = ".$objsession->get('gs_login_id')." ORDER BY doe DESC"; 	
}else{
	$cond="isActive in (1,0) and doe >= NOW() ORDER BY doe ASC"; 	
}

$rolemaster = $obj->fetchRowAll("eventmaster",$cond);
$rolemaster1 = $obj->fetchNumOfRow("eventmaster",$cond);

$i=0;
if($rolemaster1 > 0){
for($i=0;$i<$rolemaster1;$i++){
	
 ?>
                        <?php  $siddhant=(explode(",",$rolemaster[$i]['sMultiImage']));?>
                        <div class="col-lg-3 col-mg-3 col-sm-3">
                            <div class="hovereffect"> <img class="img-responsive" src="<?php echo URL;?>upload/event/multiple/<?php echo $siddhant[0];?>" alt="">
                                <div class="overlay">
                                    <h2><?php echo substr($rolemaster[$i]['event_name'],0,20);?></h2>
                                    
                                    <div class="eventdate"><?php echo date('m-d-Y',strtotime($rolemaster[$i]['doe']));?></div>
                                    <p><?php echo substr($rolemaster[$i]['sDesc'],0,20);?></p>
                                    <div class="eventmore"> <a href="<?php echo URL;?>views/eventdetail.php?event=<?php echo $rolemaster[$i]['e_id'];?>">MORE INFO</a> </div>
                                </div>
                            </div>
                            <a href="<?php echo URL;?>views/myevents.php?eventID=<?php echo $rolemaster[$i]['e_id'];?>" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i style="margin-top: 10px;" class="fa fa-fw fa-remove"></i> <span style="margin-left: 5px;">Remove</span></a> | <a href="<?php echo URL;?>views/event.php?eventID=<?php echo $rolemaster[$i]['e_id'];?>" title="Edit" ><i style="margin-top: 10px;" class="fa fa-fw fa-edit"></i> <span style="margin-left: 5px;">Edit</span></a>
                        </div>
                        <?php if($i == 4){?>
                        <div style="clear:both;" class="mb20"></div>
                        <?php } ?>
                        <?php }?>
                        <?php }else{ ?>
                        <div class="col-lg-12 col-mg-12 col-sm-12">
                            <p>There are currently no events listed.</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_GET['eventID'])){
		
		$listofimage = (explode(",",$rolemaster[$i]['sMultiImage']));
		
		foreach($listofimage as $img){
			deleteImage($img,'upload/event/multiple');
		}
		
		if($obj->delete('eventmaster',"e_id = ".$_GET['eventID']) == true){
			echo "<script>alert('Event successfully deleted.');</script>";
			redirect(URL."views/myevents.php");
		}
}
?>
<?php include('../include/footer.php'); ?>
