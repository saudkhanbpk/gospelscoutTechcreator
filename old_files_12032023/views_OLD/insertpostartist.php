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
	
	$field = array("iLoginID","sVideoName","sComment","iReview","dCreatedDate");
	$value = array($loginid,$videoname,$comment,$ratingPoints,date("Y-m-d"));		
	$obj->insert($field,$value,"videocomments");
	
	$videocountReview = $obj->fetchRowAll("videocomments","sVideoName = '".$videoname."' ORDER BY iCommentID DESC");
	
	$uservideorate = $obj->averages("videoratting","iTotalPoint","iUserID = ".$userid);
	
	if ( $uservideorate[0] > 0 ) {
		
		$field = array('iTotalUserRate');
		$value = array(round($uservideorate[0]));
		$obj->update($field,$value,'iLoginID = '.$userid,'usermaster');
		
	}
	
	$txt = '';
	if(count($videocountReview) > 0){
		for($vi=0;$vi<count($videocountReview);$vi++){
			$cond = "iLoginID = ".$videocountReview[$vi]['iLoginID'];
			$comentuser = $obj->fetchRow("usermaster",$cond);
			$louser = $obj->fetchRow("loginmaster",$cond);

			if ( $louser['sUserType'] == "artist" ) {
				$type = 'artist';
			}else {
				$type = 'church';
			}
	$txt .= '
	
	<script language="javascript" type="text/javascript">

$(function() {
    $("#rating_star1'.$vi.'").codexworld_rating_widget01({
        starLength: "5",
        initialValue: '.$videocountReview[$vi]['iReview'].',
        callbackFunctionName: "",
        imageDirectory: "../img/",
    });
});

</script>

    <div class="row">
    	<div class="form-group">
    		<div class="col-lg-2 col-mg-2 col-sm-2">                
                <img width="50" height="50" src="'.URL.'upload/'.$type.'/'.$comentuser['sProfileName'].'" />            </div>
        	<div class="col-lg-4 col-mg-4 col-sm-4" style="margin-left: -20px;">';
					if($comentuser['sUserType'] == artist)
							{
				$txt .=	'<a href="artistprofile.php?artist='.$comentuser['iLoginID'].'" >'.ucwords($comentuser['sFirstName'].''.$comentuser['sLastName']).'</a>';
						 }else
							{
				$txt .=	'<a href="churchprofile.php?church='.$comentuser['iLoginID'].'" >'.ucwords($comentuser['sFirstName'].''.$comentuser['sLastName']).'</a>';
							}       
            $txt .=	'<p style="color: rgb(0, 0, 0) ! important; font-weight: normal; word-wrap: break-word; width: 230%;">'.$videocountReview[$vi]['sComment'].'</p>
			<!--<p><input name="rating_star1" value="0" id="rating_star1'.$vi.'" type="hidden" postID="0" /></p>-->
                </div>';
        
		if($videocountReview[$vi]['iLoginID'] == $objsession->get('gs_login_id')){
		
		$txt .= '<div class="col-lg-4 col-mg-4 col-sm-4" style="float: right;">

					<p class="tital1" style="float: right; margin-right: 33px;font-size: 9px;">
		';
			if($videocountReview[$vi]['dCreatedDate'] != "") {
				$endTimeStamp = strtotime(date('Y-m-d'));
				$startTimeStamp = strtotime($videocountReview[$vi]['dCreatedDate']);
				$timeDiff = abs($endTimeStamp - $startTimeStamp);
				$numberDays = $timeDiff/86400;  // 86400 seconds in one day
				$txt .= $numberDays = intval($numberDays);
			}else{
				$txt .= '0';
			}
			$txt .= 'days Ago</p>
									
                <a style="float: right; margin-right: -100px; color: red;" href="'.URL.'views/artistvideodetails.php?video='.$_GET['videoname'].'&youtube='.$_GET['youtube'].'&cat='.$_GET['cat'].'&artist='.$_GET['artist'].'&iCommentID='.$videocountReview[$vi]['iCommentID'].'" onclick="return confirm(Are you sure want to delete?);">X</a>
        </div>';
         } 
    $txt .= '</div>
    </div>';

		}
	}
	echo $txt;
?>
