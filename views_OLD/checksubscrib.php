<?php include('../common/config.php');?>
<?php

extract($_POST);

if($_GET['logID'] > 0){
	
	if($_GET['type'] == 'sub'){
		
		if ( isset($_GET['artist']) ) {
			$ids = $_GET['artist'];
		}
		
		if ( isset($_GET['church']) ) {
			$ids = $_GET['church'];
		}
		
		$cond='iLoginID = '.$_GET['logID']." AND iRollID = ".$ids." AND isActive = 1";
		$sub = $obj->fetchRow('subscription',$cond);
		
		if(count($sub) > 0){
			echo "<p>You have already subscribed to this artist.</p>";
		}	
		else{
			
			$row = $obj->fetchRow("usermaster","iLoginID = ".$ids);
			
			if ( $row['sUserType'] == 'artist' ) {
				$name = $row['sFirstName'].' '.$row['sLastName'];
			} else {
				
				$name = $row['sChurchName'];
			}
			
			$field = array("iLoginID","iRollID","sEmailID","sName","isActive","sType");
			$value = array($objsession->get('gs_login_id'),$ids,$subscriberemail,$name,1,$row['sUserType']);				
			$obj->insert($field,$value,"subscription");
			
			echo '<p>Thank you for subscription !!!</p>';
		}
	
	}else if($_GET['type'] == 'unsub'){
		$iSubID = explode(',',$_GET['selected']);
		if(count($iSubID) > 0){
			
			$field = array('isActive');
			$value = array(0);
			
			foreach($iSubID as $key){
					
					$obj->update($field,$value,"iSubID = ".$key,"subscription");
			}
			
			$subscriblist = $obj->fetchRowAll("subscription","iLoginID = ".$objsession->get('gs_login_id')." AND isActive = 1");
			?>
			 <?php
		if(count($subscriblist) > 0){
			for($sub=0;$sub<count($subscriblist);$sub++){
		?>
        <span id="iSubID-error" class="error"><p>User unsubscribe successfully</p></span>
        <div class="clear"></div>
        
        <div class="col-lg-6 col-md-6 ocl-sm-6">
     	<input type="checkbox" name="iSubID" id="iSubID" value="<?php echo $subscriblist[$sub]['iSubID'];?>">&nbsp;&nbsp;
 		<i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $subscriblist[$sub]['sName'];?>   
        </div>
       <?php }} 
	   
			
		}
	}
}
?>