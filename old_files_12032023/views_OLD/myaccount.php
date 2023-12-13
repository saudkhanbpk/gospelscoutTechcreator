<?php include('../include/header.php'); ?>
<script src="<?php echo URL;?>js/areamanage.js"></script>

<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 p70">
<?php if($objsession->get('gs_msg') != ""){?>
<div class="suc-message">
<?php echo $objsession->get('gs_msg');?>
</div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}

if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'artist'){
	echo "<div class='test'><h3>Welcome to Artist Account</h3></div>"	;
}

if($objsession->get('gs_login_type') != "" && $objsession->get('gs_login_type') == 'church'){
	echo "<div class='test'><h3>Welcome to Church Account</h3></div>"	;
}
?> 
  </div>
</div>