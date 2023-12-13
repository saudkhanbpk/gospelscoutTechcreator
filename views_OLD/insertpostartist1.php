<?php include('../common/config.php');

	extract($_GET);
	
	$ratingNum = 1;
	$ratingPoints = $_GET['rating'];

	if ( $_GET['youtube'] != '' ) {
		$videoname = $_GET['youtube'];
	} else { 
		$videoname = $_GET['videoname'];
	}
	
	//Insert rating data into the database
	$field = array('sVideoName','iLoginID','iTotalPoint','dCreatedDate',"iUserID");
	$value = array($videoname,$loginid,$ratingPoints,date("Y-m-d"),$userid);
	$obj->insert($field,$value,'videoratting');
	
	$videocountReview = $obj->fetchRowAll("videocomments","sVideoName = '".$videoname."'");
	
	$uservideorate = $obj->averages("videoratting","iTotalPoint","iUserID = ".$userid);
	
	if ( $uservideorate[0] > 0 ) {
		
		$field = array('iTotalUserRate');
		$value = array(round($uservideorate[0]));
		$obj->update($field,$value,'iLoginID = '.$userid,'usermaster');
		
	}
?>
