<?php
	/* FullCalenar Display Page - FullCalendar Jquery Plugin used */

	include_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/include/headerNew.php'); 

	/* Query the database for the Session login ID to compare the GET var to determine privacy status  */
	
	if(isset($_GET['u_Id']) > 0 && intval($_GET['u_Id']) > 0) {

		$userId = intval($_GET['u_Id']);
		$userRow = $obj->fetchRow('usermaster', 'iLoginID = ' . $userId);
		// echo '<pre>';
		// var_dump($userRow);
		// exit;

		if($objsession->get('gs_login_id') != "" && $objsession->get('gs_login_id') == $userId) {
			echo '<input type="hidden" name="privacy" status="all" value="' . $userId . '">';
			$status = 'owner';
		}
		else{
			echo '<input type="hidden" name="privacy" status="pub" value="' . $userId . '">';
			$status = 'visitor';
		}	
	}
	else{
		// header('Location:'. URL .'views/search4artists.php');
		// echo '<script>window.location = "'. URL .'newHomePage/views/search4artistNew.php";</script>';
		// exit;
	}
?>


 <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL;?>calendar/node_modules/fullcalendar/dist/fullcalendar.css"> 
 <script type="text/javascript" src="<?php echo URL;?>calendar/node_modules/fullcalendar/node_modules/jquery/dist/jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo URL;?>calendar/node_modules/fullcalendar/node_modules/moment/min/moment.min.js"></script>
 <script type="text/javascript" src="<?php echo URL;?>calendar/node_modules/fullcalendar/dist/fullcalendar.js"></script>
 <script>
 	$(document).ready(function(){
 		//Look into the settings for the view object and calendar resizing
 		//Could possibly use this application for setting dates when booking gigs etc
 		/*
 			validRange - if used for booking & etc, will be useful in preventing users from selecting invalid dates
 			timezone - could potentially be useful for events when artists are booked to play in different time zones
			dayRender - could be used when a specific event is happening on a specific day like a deposit being made
			getDate - used when a user clicks on a day in the calendar. user will be taken to the day view 
			locale - used when we are ready to implement multiple languages
			Moment - When get a chance check out the momentJS website
 		*/
 		var u_Id = $('input[name=privacy]').val(); 
 		var status = $('input[name=privacy]').attr('status');
 		// console.log(u_Id+' '+status);

 		$('#calendar').fullCalendar({
 			customButtons: {
	 			myCustomButton: {
	 				text: 'custom!',
	 				click: function() {
	 					alert('clicked the custom Button');
	 				}
	 			}
	 		},
 			header: {
 				left: 'prev',
 				center: 'title',
 				right: 'next'
 			},
 			footer: {
 				center: 'month,agendaWeek,agendaDay,listYear'
 			},
 			buttonIcons: false,
 			fixedWeekCount: false,
 			// weekNumbers: true,
 			eventLimit: true, 
 			views: {
 				month: {
 					eventLimit: 4 //limit the # of events showing in the month view to 4 per day
 								  //the popover eventLimitClick option set by default when the more link is clicked
 				}
 			},
 			buttonText: {
 				list: 'Yr.'
 			},
 			navLinks: true,
 			handleWindowResize: true,
 			nowIndicator: true,
 			/*
 			dayClick: function(date, jsEvent, view) {	
 				alert('Clicked on: '+date.format());
 				alert('Coordinates: '+jsEvent.pageX + ',' + jsEvent.pageY); 
 				alert('Current View: '+view.name);
 				$(this).css('background-color', 'red'); 
 				view.name = 'agendaDay';
 			}
 			*/
 			/* Event Settings */
 			events: 'https://dev.gospelscout.com/calendar/phpBackend/myFeed.php?u_Id='+u_Id+'&status='+status, //Need to pass a user id and if a user is logged in and viewing their own calendar, a session id; session id will enable the myfeed.php to return private gigs/events
 			eventClick: function(event) {		//Function opens the event url in a new tab
 				if(event.url) {
	 				window.open(event.url);
	 				return false; 
	 			}
	 		},
	 		/*
	 		eventMouseover: function(event, jsEvent, view) {
	 			$(this).css('background-color', 'rgba(150,98,215,.5)'); 
	 			$(this).css('border-color', 'rgba(150,98,215,.5)');
	 		},
	 		eventMouseout: function(event, jsevent, view) {
	 			$(this).css('background-color', 'rgba(150,98,215,1)'); //fix this..background does not go back to its original color
	 			$(this).css('border-color', 'rgba(150,98,215,1)');
	 		},
	 		*/ 
	 		selectOverlap: true,
	 		eventColor: 'rgba(150,98,215,1)',
	 		eventTextColor: 'rgba(255,255,255,1)',
 		})
 	});  	
 </script>
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


<div class="container py-md-3 px-md-5 mt-3 mt-md-0">
	<?php if($status == 'owner'){ ?>
			<div class="container mb-0" style="max-width: 860px;">
				<h5 class="text-capitalize text-gs text-center text-lg-left">Your Calendar</h5>
			</div>
	<?php }
		  else{ ?>
				<div class="container" style="max-width: 860px;">
					<h5 class="text-capitalize text-gs text-center text-lg-left"><?php echo $userRow['sFirstName'];?>'s Calendar</h5>
				</div>
	<?php } ?>
	<div class="row px-md-5">
		<div class="col px-md-5">
			<div id="calendar"></div>
			<div id="colorKey">
				<div id="calPalletteTitle">Color Key</div>
				<ul>
					<li>
						<div class="palColor" style="background-color:rgba(150,98,215,1)"></div>
						<text>: Gigs Accepted</text>
					</li>
					<li>
						<div class="palColor" style="background-color:yellow"></div>
						<text>: Gigs Managed</text>
					</li>
					<!-- <li>
						<div class="palColor" style="background-color:green"></div>
						<text>: Event RSVP's</text>
					</li> -->
				</ul>
			</div>
		</div>
	</div>
</div>


<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
