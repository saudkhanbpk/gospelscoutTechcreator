<?php include('../common/config.php');

$objsession->remove("log_email");
$objsession->remove("log_loginid");
redirect(HTTP_SERVER."views/login.php");
