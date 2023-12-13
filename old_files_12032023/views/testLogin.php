<?php 
	/* Login in test */
	
	//$_POST=array('test','stupid','pissed');
	echo '<pre>';
	var_dump($_POST);
	if($_POST){
		echo 'this is a login Test';
	} 
	else{
		echo 'this $_POST still is not working';
	}
?>