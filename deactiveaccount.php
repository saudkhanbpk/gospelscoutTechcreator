<?php include('../common/config.php');

if( $objsession->get('gs_login_id') > 0 ){

		$field = array('isActive');
		$value = array(0);
		

		if($obj->update($field, $value, "iLoginID = ".$objsession->get('gs_login_id'),'usermaster') == true){
			
			$obj->update($field, $value, "iLoginID = ".$objsession->get('gs_login_id'),'loginmaster');
			
			$objsession->set("gs_login_id",0);
			$objsession->set("gs_login_type",'');
			
				
			redirect(URL);
		}
}

?>
