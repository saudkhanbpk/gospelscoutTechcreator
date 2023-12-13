<?php
	/* FullCalenar Display Page - FullCalendar Jquery Plugin used */

	include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/headerNew.php'); 
	include(realpath($_SERVER['DOCUMENT_ROOT']) .'/calendar/phpBackend/goog_cal_funct.php');

	/* Query the database for the Session login ID to compare the GET var to determine privacy status  */
	
	if(intval($_GET['u_Id']) > 0 && $currentUserID > 0) {

		$userId = intval($_GET['u_Id']);
		$userRow = $obj->fetchRow('usermaster', 'iLoginID = ' . $userId, $db);

		if($currentUserID == $userId){
			$js_hidden_input = '<input type="hidden" name="privacy" status="all" value="' . $userId . '" ';
			$status = 'owner';

			/* Set the auth URL link */
				/* Instantiate new client obj */
					$client = getClient($currentUserID);
				/* Genrate auth URL */
					$authUrl = "'" . generateAuthURL( $client['client'] ) . "'";
				/* Is access empty */
					$no_a_token = empty($client['access_token']);
					// $no_a_token_str = strval(intval($no_a_token));

			/* END - Set the auth URL link */
			 

			/* */
				$show_goog_events = intval( $_SESSION['google_cal_accessToken']['show_events'] );
				$linked_cal_id = $_SESSION['google_cal_accessToken']['calendar_id'];

			/* Check for $_SESSION['google_cal_accessToken'] var */
				if( $no_a_token || $show_goog_events == '0'){ // empty($_SESSION['google_cal_accessToken'])
					// $no_a_token = 'true';
					$js_hidden_input .= 'linked_cal="false">';
				}
				else{
					// $no_a_token = 'false';
					$js_hidden_input .= 'linked_cal="true">';
				}

			echo $js_hidden_input;
		}
		else{
			echo '<input type="hidden" name="privacy" status="pub" value="' . $userId . '" linked_cal="false">';
			$status = 'visitor';
		}	
	}
	else{
		echo '<script>window.location = "'. URL .'artist/";</script>';
		exit;
	}
?>
<head>
    <meta charset='utf-8' />
    <!-- Full calendar plugin CSS -->
	    <link href='<?php echo URL; ?>node_modules/fullcalendar/packages/core/main.css' rel='stylesheet' />
	    <link href='<?php echo URL; ?>node_modules/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
	    <link href='<?php echo URL; ?>node_modules/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
	    <link href='<?php echo URL; ?>node_modules/fullcalendar/packages/list/main.css' rel='stylesheet' />
	    <link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
	    <link href='<?php echo URL; ?>node_modules/fullcalendar/packages/bootstrap/main.css' rel='stylesheet' />
    <!-- /Full calendar plugin CSS -->
  </head>
<style>

	/************ Calendar Styling ***************/
		#calContainer {
			position: relative;
			width: 60%;
			background-color: #fff; 
			margin: 20px auto 20px;
			padding-bottom: 15px;
			box-shadow: -4px 4px 10px 5px rgba(0,0,0,.4);
		}
		#calendar {
			width: 100%;
			margin: 20px auto 5px;
			background-color: #FFF;
			padding: 30px;
			box-sizing: border-box;	
		}
		#colorKey {
			position: relative;
			width: 80%;
			margin: 0 auto 0;
			text-align: center;
		}
		#coloKey li {
			font-size: 10px;
		}
		#calPalletteTitle {
			position: relative;
			width: 100%;
			text-align: center;
			text-align:center;
			margin: 0;
			padding: 0;
			font-size: 17px;
		}
		.palColor {
			width: 10px;
			height: 10px;
			display: inline-block;
			background-color: green; 
		}
		ul {
			list-style: none;
		}
		#colorKey li {
			display: inline-block;
			margin: 0 2px 0 2px;
		}
	/************ END - Calendar Styling ***************/
</style>
<!-- Custom styles for headers on page with white background -->
  	<link href="<?php echo URL;?>home/css/header-adjustment.css" rel="stylesheet">
  	
  <div class="container py-md-5 px-md-5 mt-3 mt-md-5">
	<?php if($status == 'owner'){ ?>
			<div class="container mb-0" style="max-width: 860px;">
				<h5 class="text-capitalize text-gs text-center text-lg-left">Your Calendar</h5>
			</div>

			<div class="container" style="max-width: 860px;">
				<div class="row px-md-0">
					<div class="col">
						<table class="" style="font-size:.8em">
							<tbody>
								<tr>
									<th><a class="text-primary" href="#" class="text-gs" data-toggle="modal" data-target="#linkNewCal">Google Calendar Settings</a></th><!--  onclick="getCalId(<?php echo $userId;?>,<?php echo $no_a_token;?>)"  -->
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
	<?php }
		  else{ ?>
				<div class="container" style="max-width: 860px;">
					<h5 class="text-capitalize text-gs text-center text-lg-left"><?php echo $userRow['sFirstName'];?>'s Calendar</h5>
				</div>
	<?php } ?>

	<div class="row px-0 px-md-5">
		<div class="col px-0 px-md-5">
			<div class="px-2" id="calendar"></div>
			<div id="colorKey">
				<div id="calPalletteTitle">Color Key</div>
				<ul>
					<li>
						<div class="palColor" style="background-color:green"></div>
						<text>: Posted Gigs Accepted</text>
					</li>
					<li>
						<div class="palColor" style="background-color:yellow"></div>
						<text>: Gigs Managed</text>
					</li>
					<li>
						<div class="palColor" style="background-color:rgba(149,73,173,1)"></div>
						<text>: #popUpWorship</text>
					</li>
					<li>
						<div class="palColor" style="background-color:red"></div>
						<text>: Google Calenar</text>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>


<?php 
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/calendar/phpBackend/indexModals.php');
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); 
?>
    <script src='<?php echo URL; ?>node_modules/fullcalendar/packages/core/main.js'></script>
    <script src='<?php echo URL; ?>node_modules/fullcalendar/packages/daygrid/main.js'></script>
    <script src='<?php echo URL; ?>node_modules/fullcalendar/packages/timegrid/main.js'></script>
    <script src='<?php echo URL; ?>node_modules/fullcalendar/packages/list/main.js'></script>
    <script src='<?php echo URL; ?>node_modules/fullcalendar/packages/bootstrap/main.js'></script>
    <script src='<?php echo URL; ?>node_modules/fullcalendar/packages/interaction/main.js'></script>
    <script src='<?php echo URL; ?>calendar/js/indexJS.js?13'></script>

    