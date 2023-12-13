<?php
ob_start();

include('../common/config.php');
echo $_POST['lid'];
echo $_POST["id"];
echo $_POST["rating"];


if(!empty($_POST["rating"]) && !empty($_POST["id"])) {

 			$field = array("e_id","iLoginID","rating");
			$value = array($_POST["id"],$_POST['lid'],$_POST["rating"]);		
			$obj->insert($field,$value,"manage_rating"); 
			
			
			
}
?>