<?phpinclude('../common/config.php');?>
<?php

extract($_GET);

if($sVideoName != ''){
	
	$video = $obj->fetchRow("videomaster","iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$sVideoName."'");
	if(empty($video)){
		$view = 1;
		
		$field = array("iLoginID","iViews","sVideoName");
		$value = array($objsession->get('gs_login_id'),$view,$sVideoName);		
		$obj->insert($field,$value,"videomaster");
	
	}else{
	
	$view = $video['iViews'] + 1;
	$cond = "iLoginID = ".$objsession->get('gs_login_id')." AND sVideoName = '".$sVideoName."'";
	
	$field = array("iLoginID","iViews","sVideoName");
	$value = array($objsession->get('gs_login_id'),$view,$sVideoName);		
	$obj->update($field,$value,$cond,"videomaster");

	}
		
	
}	
else{
	echo 'Please check your video';
}
?>