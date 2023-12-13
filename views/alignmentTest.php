<?php 
	$page = 'aProfile';
	
	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
?>

<div class="container bg-info mt-5">
	<div class="row bg-danger align-items-end">
		<div class="col bg-primary" style="height:300px;"></div>
		<div class="col bg-secondary" style="min-height:700px;"></div>
	</div>
</div>