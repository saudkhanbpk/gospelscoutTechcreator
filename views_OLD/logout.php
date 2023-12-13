<?php

include('../common/config.php');

$objsession->remove("gs_login_id");
$objsession->remove("gs_login_type");
redirect(URL.'');
