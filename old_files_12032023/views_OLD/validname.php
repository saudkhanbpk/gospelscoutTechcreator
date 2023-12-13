<?phpinclude('../common/config.php');?>
<?php
$table= $_POST['table'];
$sUserName = $_POST['sUserName'];
if(isset($_POST['loginID']) > 0){
	$iLoginID = $_POST['loginID'];
}else{
	$iLoginID = 0;	
}

if($table=="loginmaster"){
	$cond="";
	if($iLoginID > 0){
		$cond .= "sEmailID = '$email' AND iLoginID != ".$iLoginID;
	}else{
		$cond .= "sEmailID = '$email'";
	}
	if(!empty($email))
	{
		$getemail =$obj->fetchRowAll($table,$cond);
	}
	else
	{
		echo "<input type='hidden' name='valid_id' id='valid_id' value='valid' />";
	}
	if(count($getemail)>0)
	{
		echo "<input type='hidden' name='valid_id' id='valid_id' value='' />";
	}
	else
	{
		echo "<input type='hidden' name='valid_id' id='valid_id' value='valid' />";
	}
}else{
	
	$cond="";
	$num = 0;
	
	if($iLoginID > 0){
		$cond .= "sEmailID = '$email' AND iLoginID != ".$iLoginID;
	}else{
		$cond = "sUserName = '$sUserName'";
	}
	
	$num = 0;
	$num = $obj->fetchNumOfRow('usermaster',$cond);
	if($num > 0){
		echo '';
	}else{
		echo 'valid';
	}
	
}	
?>