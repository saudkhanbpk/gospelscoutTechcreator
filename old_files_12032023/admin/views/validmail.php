<?php include('../common/config.php');?>
<?php
$table= $_GET['table'];
$email = $_GET['str'];
if(isset($_GET['loginID'])){
	$iLoginID = $_GET['loginID'];
}else{
	$iLoginID = 0;	
}

if($table=="loginmaster")
{
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
}
?>