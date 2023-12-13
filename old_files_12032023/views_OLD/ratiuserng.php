<?php
include('../common/config.php');

if(!empty($_POST['ratingPoints'])){
    $postID = $_POST['postID'];
    $ratingNum = 1;
    $ratingPoints = $_POST['ratingPoints'];
	$iUserID = $_POST['iUserID'];
    
    //Check the rating row with same post ID
	
	$cond = "iUserID = '".$iUserID."' AND iLoginID = ".$objsession->get('gs_login_id');	
	$ratingNum = $obj->fetchNumOfRow('userratting',$cond);

    //$prevRatingQuery = "SELECT * FROM post_rating WHERE post_id = ".$postID;
    //$prevRatingResult = $db->query($prevRatingQuery);
    if($ratingNum > 0):
	
        $prevRatingRow = $obj->fetchRow('userratting',$cond);
        $ratingNum = $prevRatingRow['rating_number'] + $ratingNum;
        $ratingPoints = $prevRatingRow['total_points'] + $ratingPoints;
        //Update rating data into the database
		$field = array('iTotalPoint','dModifyDate');
		$value = array($ratingPoints,date("Y-m-d"));
		$obj->update($field,$value,$cond,'userratting');
		
    else:
        //Insert rating data into the database
		$field = array('iUserID','iLoginID','iTotalPoint','dCreatedDate');
		$value = array($iUserID,$objsession->get('gs_login_id'),$ratingPoints,date("Y-m-d"));
		$obj->insert($field,$value,'userratting');
		
    endif;
    
   $cond = "iUserID = '".$_GET['video']."' AND iLoginID = ".$objsession->get('gs_login_id');
   $prevRatingRow = $obj->fetchRow('userratting',$cond);
   
    
    if(!empty($prevRatingRow)){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    
    //Return json formatted rating data
    echo json_encode($ratingRow);
}
?>