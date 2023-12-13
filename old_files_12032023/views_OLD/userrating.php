<?php
include('../common/config.php');

if(!empty($_GET['ratingPoints'])){
    $postID = $_GET['postID'];
    $ratingNum = 1;
    $ratingPoints = $_GET['ratingPoints'];
	$iUserID = $_GET['iUserID'];
    
    //Check the rating row with same post ID
	
	$cond = "iUserID = '".$iUserID."' AND iLoginID = ".$objsession->get('gs_login_id');	
	$ratingNum = $obj->fetchNumOfRow('userratting',$cond);

    //$prevRatingQuery = "SELECT * FROM post_rating WHERE post_id = ".$postID;
    //$prevRatingResult = $db->query($prevRatingQuery);
	
	$UR = $obj->fetchRow('usermaster','iLoginID = '. $iUserID);
		
    if($ratingNum > 0):
	
        $prevRatingRow = $obj->fetchRow('userratting',$cond);
       // $ratingNum = $prevRatingRow['rating_number'] + $ratingNum;
        $ratingPoints = $prevRatingRow['iTotalPoint'] + $ratingPoints;
        //Update rating data into the database
		$field = array('iTotalPoint','dModifyDate');
		$value = array($ratingPoints,date("Y-m-d"));
		$obj->update($field,$value,$cond,'userratting');
		
    else:
        //Insert rating data into the database
		$field = array('iUserID','iLoginID','iTotalPoint','dCreatedDate');
		$value = array($iUserID,$objsession->get('gs_login_id'),$ratingPoints,date("Y-m-d"));
		$obj->insert($field,$value,'userratting');
						
		if ( $UR['rating_number'] > 0) {
			
			$rate = $UR['rating_number'] + 1;
		} else {
			
			$rate = 1;
		}
		
		$field1 = array('rating_number');
		$value1 = array($rate);
		$obj->update($field1,$value1,'iLoginID = '.$iUserID,'usermaster');
		
    endif;
    
   $cond = "iUserID = '".$iUserID."'";
   $prevRatingRow = $obj->fetchRow('userratting',$cond);
      
	  $UR = $obj->fetchRow('usermaster','iLoginID = '. $iUserID);
	 $totalRate = $obj->fetchAverageTotal('userratting','iTotalPoint',"iUserID = ".$iUserID);
	 
	 
	 $cond = "iUserID = ".$iUserID;	
	$ratingNum = $obj->fetchNumOfRow('userratting',$cond);
	
	  if($totalRate['average_rating'] > 0){
	
	  	$iRateAvg = $totalRate['average_rating'] / $ratingNum;
	  }else{
		  $iRateAvg = 1;
	  }
		$field1 = array('iRateAvg','iTotalUserRate');
		$value1 = array($iRateAvg,$totalRate['average_rating']);
		$obj->update($field1,$value1,'iLoginID = '.$iUserID,'usermaster');
		
    if(!empty($prevRatingRow)){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    
    //Return json formatted rating data
    echo json_encode($ratingRow);
}
?>