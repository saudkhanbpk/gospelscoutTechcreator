<?php
include('../common/config.php');

	$videName = $_GET['videoName'];

	$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$videName."' AND status = 1";

$loaddata = $obj->fetchRowAll('videosubcribe',$cond);
$totalloaddata = $obj->fetchNumOfRow('videosubcribe',$cond);
	
	if($totalloaddata > 0){
		
			$field = array('sVideoName','iLoginID','status');
			$value = array($videName,$objsession->get('gs_login_id'),0);
	
			$obj->update($field,$value,$cond,'videosubcribe');
			echo '<a class="back" style="margin:-30px  -240px;cursor:pointer;" onclick="check();" id="subVideo">Subscribe</a>';
			
	}else{
		
		$field = array('sVideoName','iLoginID','status');
		$value = array($videName,$objsession->get('gs_login_id'),1);
		
		$obj->insert($field,$value,'videosubcribe');
		echo '<a class="back" style="margin:-30px  -240px;cursor:pointer;" onclick="check();" id="subVideo">Un subscribe</a>';
								
	}
?>
