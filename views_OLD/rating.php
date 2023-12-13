<?php
include('../common/config.php');

if(!empty($_POST['ratingPoints'])){
    $postID = $_POST['postID'];
    $ratingNum = 1;
    $ratingPoints = $_POST['ratingPoints'];
	$videoName = $_POST['videoName'];
    
    //Check the rating row with same post ID
	
	$cond = "sVideoName = '".$videoName."' AND iLoginID = ".$objsession->get('gs_login_id');	
	$ratingNum = $obj->fetchNumOfRow('videoratting',$cond);

    //$prevRatingQuery = "SELECT * FROM post_rating WHERE post_id = ".$postID;
    //$prevRatingResult = $db->query($prevRatingQuery);
    if($ratingNum > 0):
	
        $prevRatingRow = $obj->fetchRow('videoratting',$cond);
        $ratingNum = $prevRatingRow['rating_number'] + $ratingNum;
        $ratingPoints = $prevRatingRow['total_points'] + $ratingPoints;
        //Update rating data into the database
		$field = array('iTotalPoint','dModifyDate');
		$value = array($ratingPoints,date("Y-m-d"));
		$obj->update($field,$value,$cond,'videoratting');
		
    else:
        //Insert rating data into the database
		$field = array('sVideoName','iLoginID','iTotalPoint','dCreatedDate');
		$value = array($videoName,$objsession->get('gs_login_id'),$ratingPoints,date("Y-m-d"));
		$obj->insert($field,$value,'videoratting');
		
    endif;
    
   $cond = "sVideoName = '".$_GET['video']."' AND iLoginID = ".$objsession->get('gs_login_id');
   $prevRatingRow = $obj->fetchRow('videoratting',$cond);
   
    
    if(!empty($prevRatingRow)){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    
    //Return json formatted rating data
    echo json_encode($ratingRow);
}
?>