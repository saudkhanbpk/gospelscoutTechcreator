<?php include('../common/config.php');?>
<?php

extract($_POST);

if($_GET['type'] == 'state'){
	
	if($_GET['iCountriID'] != "" || $_GET['iCountriID'] > 0){
		
		$cond='country_id = '.$_GET['iCountriID'];
		$states = $obj->fetchRowAll('states',$cond);
		$cn = "<option value=''>Select State</option>";
		
		for($s=0;$s<count($states);$s++){
			$cn .= "<option value=".$states[$s]['id'].">".$states[$s]['name']."</option>";
		}
		echo $cn;
	}
	else{
		echo 'Please select country';
	}
}

if($_GET['type'] == 'city'){
	
	if($_GET['iStateID'] != "" || $_GET['iStateID'] > 0){
		
		$cond='state_id = '.$_GET['iStateID'];
		$cities = $obj->fetchRowAll('cities',$cond);
		$st = "<option dataValue='' value=''>Select City</option>";
		for($s=0;$s<count($cities);$s++){
			$st .= '<option dataValue="'.$cities[$s]['name'].'" value="'.$cities[$s]['id'].'">'.$cities[$s]['name']."</option>";
		}
		echo $st;
	}
	else{
		echo 'Please select state';
	}
}

?>