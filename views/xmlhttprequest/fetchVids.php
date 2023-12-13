<?php 
	if($get_U_type['sUserType'] == 'group'){
			/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$artistUserID = $_GET['artistID'];
			$query1 = 'SELECT artistvideomaster.*, usermaster.sGroupName
					  FROM artistvideomaster
					  INNER JOIN usermaster on artistvideomaster.iLoginID = usermaster.iLoginID
					  WHERE artistvideomaster.iLoginID = ? AND artistvideomaster.removedStatus = 0
					';
			try{
				$vidArray = $db->prepare($query1);
				$vidArray->bindParam(1, $artistUserID);
				$vidArray->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}
	elseif($get_U_type['sUserType'] == 'artist'){
		/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$emptyArray = array();
			$columnsArray0 = array('artistvideomaster.*', 'giftmaster.sGiftName', 'usermaster.sFirstName', 'usermaster.sLastName');
			$paramArray0['artistvideomaster.iLoginID']['='] = trim( $_GET['u_id'] );
			$paramArray0['giftmaster.iGiftID']['='] = trim($_GET['tal']);
			$paramArray0['artistvideomaster.removedStatus']['='] = 0;
			$innerJoinArray0 = array(
				array('giftmaster','iGiftID','artistvideomaster','videoTalentID'),
				array('usermaster','iLoginID','artistvideomaster','iLoginID')
			);
			$result = pdoQuery('artistvideomaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}
	elseif($get_U_type['sUserType'] == 'church'){
		/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */
			$churchUserID = $_GET['churchID'];
			$ministry = trim($_GET['tal']);
			$query1 = 'SELECT churchvideomaster.*, giftmaster1.sGiftName, usermaster.sChurchName
					  FROM churchvideomaster
					  INNER JOIN giftmaster1 on churchvideomaster.VideoMinistryID = giftmaster1.iGiftID
					  INNER JOIN usermaster on churchvideomaster.iLoginID = usermaster.iLoginID
					  WHERE churchvideomaster.iLoginID = ?  AND giftmaster1.sGiftName = ? AND churchvideomaster.removedStatus = 0
					';
			try{
				$vidArray = $db->prepare($query1);
				$vidArray->bindParam(1, $churchUserID);
				$vidArray->bindParam(2, $ministry); 
				$vidArray->execute();
			}
			catch(Exception $e){
				echo $e; 
			}
			$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
		/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	}
?>