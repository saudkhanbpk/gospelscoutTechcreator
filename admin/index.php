<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/admin/common/config.php';
$ohd_email = $objsession->get("log_email");
if($ohd_email == ""){
	redirect(HTTP_SERVER."views/login.php");
}else{
	redirect(HTTP_SERVER."views/dashboard.php");
}