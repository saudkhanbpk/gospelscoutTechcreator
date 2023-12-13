<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/common/config.php';?>
<?php

extract($_GET);

if($_GET['fblogin'] == 'login'){
	$cond='sEmailID = "'.$sEmailID.'" AND sPassword = "'.md5($sPassword).'"';
	$loginrow = $obj->fetchRow('loginmaster',$cond);
	if(count($loginrow) > 0){
		
		$cond='iLoginID = '.$loginrow['iLoginID'];
		$userRow = $obj->fetchRow('usermaster',$cond);
		
		$objsession->set('gs_user_name',$userRow['sFirstName']);	
		
		if($loginrow['sUserType'] == 'church')	{
			
			$objsession->set('gs_login_id',$loginrow['iLoginID']);	
			$objsession->set('gs_login_email',$loginrow['sEmailID']);	
			$objsession->set('gs_login_type',$loginrow['sUserType']);
			
			if ( $loginrow['isActive'] == 1 ) {
				echo 'church';	
			} else {
				echo "deactive";
                                $objsession->remove("gs_login_id");
                                $objsession->remove("gs_login_type");
			}
			
		}
		
		if($loginrow['sUserType'] == 'artist')	{
			
			$objsession->set('gs_login_id',$loginrow['iLoginID']);	
			$objsession->set('gs_login_email',$loginrow['sEmailID']);	
			$objsession->set('gs_login_type',$loginrow['sUserType']);
			
			if ( $loginrow['isActive'] == 1 ) {
				echo 'artist';
			} else {
				echo "deactive";
                                $objsession->remove("gs_login_id");
                                $objsession->remove("gs_login_type");
			}	
			
		}
		
		if($loginrow['sUserType'] == 'user')	{
			
			$objsession->set('gs_login_id',$loginrow['iLoginID']);
			$objsession->set('gs_user_email',$loginrow['sEmailID']);
			$objsession->set('gs_login_type',$loginrow['sUserType']);	
			
			if ( $loginrow['isActive'] == 1 ) {
				echo 'user';
			} else {
				echo "deactive";
                                $objsession->remove("gs_login_id");
                                $objsession->remove("gs_login_type");
			}
			
		}
		
		
	}	
	else{
		echo 'Please check your email or password';
	}
}
?>