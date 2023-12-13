<?phpinclude('../common/config.php');?>
<?php

extract($_POST);

if($_GET['logID'] > 0){
	
		$cond='iLoginID = '.$_GET['logID'];		
		$eventsubscribe = $obj->fetchRow('eventsubscribe',$cond);
		
		$subscription = $obj->groupValue('subscription','iLoginID','iRollID = '.$_GET['logID']);
		//print_r($subscription);
		$tmpid = $subscription[0];
		if ( $subscription['groupvalue'] != "" ) {
				
			if ( $_GET['selected'] != "" ) {
				
				//$eventID = explode(',',$_GET['selected']);
			
				$field = array("iIDs");
				$value = array($tmpid);	
				
				$obj->update($field,$value,"e_id IN(".$_GET['selected'].")","eventmaster");
			
			} 		

		}
		
		if(count($eventsubscribe) > 0){
						
			$ids = $_GET['selected'];
			
			$field = array("iLoginID","iEventID");
			$value = array($objsession->get('gs_login_id'),$ids);				
			$obj->update($field,$value,$cond,"eventsubscribe");
			echo '<p>This Event Are Subscribe Now.</p>';
		}	
		else{
			
			$ids = $_GET['selected'];
			
			$field = array("iLoginID","iEventID");
			$value = array($objsession->get('gs_login_id'),$ids);				
			$obj->insert($field,$value,"eventsubscribe");
			
			echo '<p>This Event Are Subscribe Now.</p>';
		}
}
?>