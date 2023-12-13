<?php include('../common/config.php');?>
<?php

$sEmailID = $_POST['sEmailID'];

if($sEmailID != '')
{
		$cond = "sEmailID = '$sEmailID'";

		$getemail =$obj->fetchNumOfRow('loginmaster',$cond);

	if($getemail > 0){
		echo 'false';
	}else{
		echo 'true';
	}
}
?>