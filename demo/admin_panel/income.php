﻿<?php
session_start();

$abc=$_SESSION['user'];
$abc1=$_SESSION['center'];
 
?>
<?php

@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>work clinic station</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
<meta charset="UTF-8">
    <title>CalendarView — JavaScript Calendar Widget</title>
    <link rel="stylesheet" href="css/calendarview.css">
    <style>
      body {
        font-family: Trebuchet MS;
      }
      div.calendar {
        max-width: 240px;
        margin-left: auto;
        margin-right: auto;
      }
      div.calendar table {
        width: 100%;
      }
      div.dateField {
        width: 140px;
        padding: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        color: #555;
        background-color: white;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
      }
      div#popupDateField:hover {
        background-color: #cde;
        cursor: pointer;
      }
	  
	  h1 {
  font-family: Helvetica;
  font-weight: 100;
}
body {
  color:#333;
}
    </style>
    <script src="js/prototype.js"></script>
    <script src="js/calendarview.js"></script>
    <script>
      function setupCalendars() {
        // Embedded Calendar
        Calendar.setup(
          {
            dateField: 'embeddedDateField',
            parentElement: 'embeddedCalendar'
          }
        )

        // Popup Calendar
        Calendar.setup(
          {
            dateField: 'popupDateField',
            triggerElement: 'popupDateField'
          }
        )
      }

      Event.observe(window, 'load', function() { setupCalendars() })
    </script>
</head>

<body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
                <span class="logo-text">WORK CLINIC STATION</span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
					
					<li class="btn btn-default dropdown-toggle">CENTER : <?php echo $abc1;?></li>
					<li class="btn btn-default dropdown-toggle">USER : <?php echo $abc;?></li>
                    <li class="btn btn-default dropdown-toggle"> <a href="logout.php">Change User</a></li>
               
             
               <!-- <ul class="dropdown-menu">
                    <li><a href="#">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="login.php">Logout</a></li>
                </ul> -->
            </div>
            <!-- user dropdown ends -->

            <!-- theme selector starts -->
           <!-- <div class="btn-group pull-right theme-container animated tada">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-tint"></i><span
                        class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="themes">
                    <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                    <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                    <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                    <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                    <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                    <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                    <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                    <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                    <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                </ul>
            </div> 
            <!-- theme selector ends -->

            <!--<ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="#"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"><i class="glyphicon glyphicon-star"></i> Dropdown <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li>
                    <form class="navbar-search pull-left">
                        <input placeholder="Search" class="search-query form-control col-md-10" name="query"
                               type="text">
                    </form>
                </li>
            </ul>-->

        </div>
    </div>
    <!-- topbar ends -->
<div class="ch-container">
    <div class="row">
        
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                   <ul class="nav nav-pills nav-stacked main-menu">
                        <!-- <li class="nav-header">Main</li> -->
						
                        <li><a class="ajax-link" href="index.php"><img style="padding-right:8px" src="img/EXTERNAL.png"><span>ETERNAL CONSULTATIONS</span></a>
                        </li>
						<li><a class="ajax-link" href="income.php"><img style="padding-right:8px" src="img/INCOME.png"><span>INCOME</span></a>
                        </li>
                        <li><a class="ajax-link" href="quirofanos.php"><img style="padding-right:8px" src="img/QUIROFANOS.png"><span> QUIROFANOS</span></a>
                        </li>
						<li><a class="ajax-link" href="urgencias.php"><img style="padding-right:8px" src="img/URGENCIAS.png"><span>URGENCIAS</span></a>
                        </li>
						<li><a class="ajax-link" href="medical_histry.php"><img style="padding-right:6px;margin-left:-3px;" src="img/MEDICAL.png"><span>MEDICAL HISTORY</span></a>
                        </li>
                        <!-- <li><a class="ajax-link" href="form.php"><i
                                    class="glyphicon glyphicon-edit"></i><span>MEDICAL HISTORY</span></a></li> -->
                        <li><a class="ajax-link" href="#"><img style="padding-right:8px" src="img/TASKS.png"><span>TASKS / NOTICES</span></a>
                        </li>
                        <li><a class="ajax-link" href="accounting.php"><img style="padding-right:8px;margin-left:-6px;" src="img/ACCOUNTING.png"><span> ACCOUNTING</span></a>
                        </li>
                        <li><a class="ajax-link" href="configuration.php"></i><img style="padding-right:8px" src="img/CONFIGURATIONS.png"><span>CONFIGURATIONS</span></a>
                        </li>
					</ul>
                        <!--<li class="nav-header hidden-md">Sample Section</li>
                        <li><a class="ajax-link" href="table.php"><i
                                    class="glyphicon glyphicon-align-justify"></i><span> Tables</span></a></li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Accordion Menu</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Child Menu 1</a></li>
                                <li><a href="#">Child Menu 2</a></li>
                            </ul>
                        </li>
                        <li><a class="ajax-link" href="calendar.php"><i class="glyphicon glyphicon-calendar"></i><span> Calendar</span></a>
                        </li>
                        <li><a class="ajax-link" href="grid.php"><i
                                    class="glyphicon glyphicon-th"></i><span> Grid</span></a></li>
                        <li><a href="tour.php"><i class="glyphicon glyphicon-globe"></i><span> Tour</span></a></li>
                        <li><a class="ajax-link" href="icon.php"><i
                                    class="glyphicon glyphicon-star"></i><span> Icons</span></a></li>
                        <li><a href="error.php"><i class="glyphicon glyphicon-ban-circle"></i><span> Error Page</span></a>
                        </li>
                        <li><a href="login.php"><i class="glyphicon glyphicon-lock"></i><span> Login Page</span></a>
                        </li>
                    </ul>
                    <label id="for-is-ajax" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>-->
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="income.php">INCOME</a>
        </li>
        
    </ul>
</div>


<!--<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="6 new members." class="well top-block" href="#">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Total Members</div>
            <div>507</div>
            <span class="notification">6</span>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="4 new pro members." class="well top-block" href="#">
            <i class="glyphicon glyphicon-star green"></i>

            <div>Pro Members</div>
            <div>228</div>
            <span class="notification green">4</span>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="$34 new sales." class="well top-block" href="#">
            <i class="glyphicon glyphicon-shopping-cart yellow"></i>

            <div>Sales</div>
            <div>$13320</div>
            <span class="notification yellow">$34</span>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="12 new messages." class="well top-block" href="#">
            <i class="glyphicon glyphicon-envelope red"></i>

            <div>Messages</div>
            <div>25</div>
            <span class="notification red">12</span>
        </a>
    </div>
</div>-->

 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2 style="width: 217px;">
					<!-- <li><a href="#" data-toggle="modal" data-target="#myModal3" >PERSIONAL INFORMATION</a> -->
				</h2>
				<h2>
					<li><a href="quirofanos" >TO PRINT</a>
				</h2>

                
            </div>
			<div style="height: 80px;">
					<table class="income-search">
						<tr>
							<td>Plant : </td>
							<td><select name="dropdown" style="padding: 0px 80px 0px 0px;">
								<option value="1A">1A</option>
								<option value="1B">1B</option>
								<option value="1C">2A</option>
								<option value="1D">2B</option>
								</select></td>
						</tr>
					</table>
					<div class="income-modify-button">
					<input type="submit" data-toggle="modal" data-target="#myModal" value="MODIFY">
					<input type="submit" data-toggle="modal" data-target="#myModal1" value="SEE">
					<input type="submit" data-toggle="modal" data-target="#myModal2" value="HIGH">
					</div>
			</div>
			<div class="income-table">
			<table border="1" height="100%" width="100%">
				<tr>
					<td style="height: 155px;"><div style="margin-top: 100px;">01</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">03</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">05</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">07</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">09</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">11</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">13</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">15</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">17</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">19</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">21</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">23</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">25</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">27</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">29</div></td>
				</tr>
				<tr style="height:10px;">
					<td colspan="15" ></td>
				</tr>
				<tr>
					<td style="height: 155px;"><div style="margin-top: 100px;">02</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">04</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">06</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">08</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">10</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">12</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">14</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">16</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">18</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">20</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">22</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">24</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">26</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">28</div></td>
					<td style="height: 155px;"><div style="margin-top: 100px;">30</div></td>
				</tr>
			</table>
				
	  </div>
    </div>
	
	<div id="myModal" class="modal fade">
    <div class="modal-dialog" style="width: 722px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results3" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm3">

						<table>
							<tr>
								<td style="width: 111px;">SELECT ROLE :</td>
								<td><select name="role1" id="role1">
									<option value="select">SELECT</option>

									<?php
									$query=mysql_query("select * from especialitats where activa='1'");
									while($row=mysql_fetch_array($query))
									{
									?>
									<option value="<?php echo $row['especialitat'];?>"><?php echo $row['especialitat'];?></option>
									<?php
									}
									?>
									</select></td>
								</td>
								
								<td>DATE OF ADMISSION :</td>
								<td><input type="text" name="adate"></td>
							</tr>
							<tr>
								<td style="width: 117px;">RESPONSABLE :</td>
								<td><select name="role1" id="role1">
									<option value="select">SELECT</option>

									<?php
									$query1=mysql_query("select * from medical_info");
									while($row1=mysql_fetch_array($query1))
									{
									?>
									<option value="<?php echo $row1['responsable'];?>"><?php echo $row1['responsable'];?></option>
									<?php
									}
									?>
									</select></td>
									
									<td>DIAGNOSIS :</td>
									<td><input type="text"></td>
							</tr>
							<tr>
								<td>PAYMENT :</td>
								<td><input type="radio" name="radio" value="MUTUA">MUTUA </br>
									<input type="radio" name="radio" value="PRIVATE">PRIVATE</td>
									
								<td><select name="role1" id="role1">
									<option value="select">SELECT</option>
									<option value="AGRUPACIO MUTUA">AGRUPACIO MUTUA</option>
									</select></td>
							</tr>
							<tr>
								<td colspan="4" style="text-align: center;"><input type="button" value="RECORD" /></td>
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal1" class="modal fade">
    <div class="modal-dialog" style="width: 1025px;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
					<div id="results1" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
					<div id="results2" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div style="height: 90px;">
			   <table>
				<tr>
					<td>SPECIALITY :</td>
					<td><input type="text"></td>
					<td>ADMISSION DATE :</td>
					<td><input type="text"></td>
					<td><input type="submit" VALUE="HIGH"></td>
				</tr>
				<tr>
					<td>RESPONSIBLE :</td>
					<td><input type="text"></td>
				</tr>
				</table>
			   </div>
			   <div style="border:1px solid black;">
			   <div style="width: 500px;">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">Clinical curs</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;"><b>TO WRITE</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;" ><textarea rows="15" cols="74" name="txt" ></textarea></td>
										</tr>
									</table>
						</div>
			   </div>
			   
			   <div style="width: 250px;height:200px;border: 1px solid black;">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">INFORMS</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;" colspan="2"><b>ADD</b> <b>  HIGH</b></td>
											
										</tr>
										<tr>
											<td style="padding: 0px;"><b>DATE</b></td>
											<td style="padding: 0px;"><b>TITLE</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;">ABCD</td>
											<td style="padding: 0px;">ABCDE</td>
										</tr>
									</table>
						</div>
			   </div>
			   <div style="width: 250px;height: 200px;margin-top: -200px;margin-left: 250px;border: 1px solid black;">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">IMAGENES</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;" colspan="2"><b>ADD</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;"><b>DATE</b></td>
											<td style="padding: 0px;"><b>KIND</b></td>
										</tr>
									</table>
						</div>
			   </div>
			   
			   <div style="float: right;width: 371px;margin-top: -574px;border: 1px solid black;height:150px">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">DIAGNOSIS</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;"><b>ADD</b><b>  MODIFY</b><b>  DELETE</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;"><b>DIAGNOSIS</b></td>
										</tr>
										
									</table>
						</div>
			   </div>
			   
			   <div style="float: right;width: 371px;margin-top: -424px;border: 1px solid black;height:150px">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">PETITIONS</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;" colspan="2"><b>ADD</b><b>  HIGH</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;"><b>PETITIONS</b></td>
											<td style="padding: 0px;"><b>DATE</b></td>
										</tr>
										
									</table>
						</div>
			   </div>
			   <div style="float: right;width: 371px;margin-top: -274px;border: 1px solid black;height:150px">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">RECEIPES</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;" colspan="2"><b>ADD</b><b>  HIGH</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;"><b>TREATMENT</b></td>
											<td style="padding: 0px;"><b>DATE</b></td>
										</tr>
										
									</table>
						</div>
			   </div>
			   
			   <div style="float: right;width: 371px;margin-top: -124px;border: 1px solid black;height:125px">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">PERAMETERS</a></td>
							</tr>
						</table>
						<div style="margin-top: -11px;">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<td style="padding: 0px;" colspan="2"><b>ADD</b><b>  MODIFY</b><b>  DELETE</b><b>  GRAPH</b></td>
										</tr>
										<tr>
											<td style="padding: 0px;"><b>DATA</b></td>
											<td style="padding: 0px;"><b>VALUE1</b></td>
											<td style="padding: 0px;"><b>VALUE2</b></td>

										</tr>
										
									</table>
						</div>
			   </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    </div></div>

						
<div id="myModal2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
					<div id="results1" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
					<div id="results2" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               
					
				<div style="width: 70%;">
				<form method="POST" action="configuration.php">
			
				<table style="width: 100%;">
					<tr>
						<th style="width: 141px;">DISCHARGE DATE :</th>
						<td><input type="text" style="width: 100%;" id="datepicker"></td>
					</tr>
						
					<tr>
						<td colspan="2" style="text-align:center"><input type="button" value="HIGH INFORM" /></td>	
					</tr>
					<tr>
						<td colspan="2" style="text-align:center"><input type="button" value="CONFIRM HIGH" /></td>	
					</tr>
				</table>
				</form>
				</div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    </div>
	
	
<div id="myModal3" class="modal fade">
    <div class="modal-dialog" style="width: 722px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results3" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm3">

						<table>
							<tr>
								<td style="width: 111px;">SURNAME :</td>
								<td><input type="text" style="width: 175px;" ></td>
								<td><input type="text" style="width: 175px;"></td>
								</td>
							</tr>
							<tr>
								<td style="width: 117px;">FIRSTNAME :</td>
								<td><input type="text" style="width: 175px;" ></td>
							</tr>
							
							<tr>
								<td>DNI :</td>
								<td><input type="text" style="width: 175px;" ></td>
								<td colspan="2">BIRTHDATE : <input type="text" style="width: 175px;" ></td>
							</tr>
							
							<tr>
								<td>ADDRESS :</td>
								<td><input type="text" style="width: 175px;" ></td>
							</tr>
							
							<tr>
								<td>POPULATION :</td>
								<td><input type="text" style="width: 175px;" ></td>
							</tr>
							
							<tr>
								<td>POSTAL CODE :</td>
								<td><input type="text" style="width: 175px;"></td>
								<td colspan="2">TELEPHONE : <input type="text" style="width: 175px;"></td>
							</tr>
							
							<tr>
								<td colspan="4" style="text-align: center;"><input type="checkbox" value=-"SMS MOBILE">  SMS MOBILE</td>
							</tr>
							
							<tr>
								<td>PAGO :</td>
								<td><input type="radio" name="radio" value="MUTUA">MUTUA </br>
									<input type="radio" name="radio" value="PRIVATE">PRIVATE</td>
									
								<td><select name="role1" id="role1">
									<option value="select">SELECT</option>
									<option value="AGRUPACIO MUTUA">AGRUPACIO MUTUA</option>
									</select></td>
							</tr>
							
							<tr>
								<td>NOTA :</td>
								<td colspan="3"><textarea rows="5" cols="80"></textarea></td>
							</tr>
							
							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" value="Authorization of personal data registration" /></td>
								
								<td colspan="2" style="text-align: center;"><input type="button" value="RECORD" /></td>
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>
                </div>
                <!-- Ads, you can remove these -->
               
                <!-- Ads end -->

            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="box col-md-4">
        <div class="box-inner homepage-box">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-th"></i> Tabs</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#info">Info</a></li>
                    <li><a href="#custom">Custom</a></li>
                    <li><a href="#messages">Messages</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active" id="info">
                        <h3>Charisma
                            <small>a full featured template</small>
                        </h3>
                        <p>It's a full featured, responsive template for your admin panel. It's optimized for tablets
                            and mobile phones.</p>

                        <p>Check how it looks on different devices:</p>
                        <a href="http://www.responsinator.com/?url=usman.it%2Fthemes%2Fcharisma"
                           target="_blank"><strong>Preview on iPhone size.</strong></a>
                        <br>
                        <a href="http://www.responsinator.com/?url=usman.it%2Fthemes%2Fcharisma"
                           target="_blank"><strong>Preview on iPad size.</strong></a>
                    </div>
                    <div class="tab-pane" id="custom">
                        <h3>Custom
                            <small>small text</small>
                        </h3>
                        <p>Sample paragraph.</p>

                        <p>Your custom text.</p>
                    </div>
                    <div class="tab-pane" id="messages">
                        <h3>Messages
                            <small>small text</small>
                        </h3>
                        <p>Sample paragraph.</p>

                        <p>Your custom text.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!--/span-->

   <!-- <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-user"></i> Member Activity</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="box-content">
                    <ul class="dashboard-list">
                        <li>
                            <a href="#">
                                <img class="dashboard-avatar" alt="Usman"
                                     src="http://www.gravatar.com/avatar/f0ea51fa1e4fae92608d8affee12f67b.png?s=50"></a>
                            <strong>Name:</strong> <a href="#">Usman
                            </a><br>
                            <strong>Since:</strong> 17/05/2014<br>
                            <strong>Status:</strong> <span class="label-success label label-default">Approved</span>
                        </li>
                        <li>
                            <a href="#">
                                <img class="dashboard-avatar" alt="Sheikh Heera"
                                     src="http://www.gravatar.com/avatar/3232415a0380253cfffe19163d04acab.png?s=50"></a>
                            <strong>Name:</strong> <a href="#">Sheikh Heera
                            </a><br>
                            <strong>Since:</strong> 17/05/2014<br>
                            <strong>Status:</strong> <span class="label-warning label label-default">Pending</span>
                        </li>
                        <li>
                            <a href="#">
                                <img class="dashboard-avatar" alt="Abdullah"
                                     src="http://www.gravatar.com/avatar/46056f772bde7c536e2086004e300a04.png?s=50"></a>
                            <strong>Name:</strong> <a href="#">Abdullah
                            </a><br>
                            <strong>Since:</strong> 25/05/2014<br>
                            <strong>Status:</strong> <span class="label-default label label-danger">Banned</span>
                        </li>
                        <li>
                            <a href="#">
                                <img class="dashboard-avatar" alt="Sana Amrin"
                                     src="http://www.gravatar.com/avatar/hash"></a>
                            <strong>Name:</strong> <a href="#">Sana Amrin</a><br>
                            <strong>Since:</strong> 17/05/2014<br>
                            <strong>Status:</strong> <span class="label label-info">Updates</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>-->
    <!--/span-->

    <!-- <div class="box col-md-4">
        <div class="box-inner homepage-box">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list-alt"></i> Keep in touch</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <h3>Stay updated with my projects and blog posts</h3>
                <!-- Begin MailChimp Signup Form 
                <div class="mc_embed_signup">
                    <form action="//halalit.us3.list-manage.com/subscribe/post?u=444b176aa3c39f656c66381f6&amp;id=eeb0c04e84" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div>
                            <label>Please enter your email</label>
                            <input type="email" value="" name="EMAIL" class="email" placeholder="Email address" required>

                            <div class="power_field"><input type="text" name="b_444b176aa3c39f656c66381f6_eeb0c04e84" tabindex="-1" value=""></div>
                            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" class="button"></div>
                        </div>
                    </form>
                </div>

                <!--End mc_embed_signup
                <br/>

                <p>You may like my other open source work, check my profile on <a href="http://github.com/usmanhalalit"
                                                                                  target="_blank">GitHub</a>.</p>

            </div>
        </div>
    </div>
    <!--/span
</div><!--/row-->

<!-- <div class="row">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list"></i> Buttons</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content buttons">
                <p class="btn-group">
                    <button class="btn btn-default">Left</button>
                    <button class="btn btn-default">Middle</button>
                    <button class="btn btn-default">Right</button>
                </p>
                <p>
                    <button class="btn btn-default btn-sm"><i class="glyphicon glyphicon-star"></i> Icon button</button>
                    <button class="btn btn-primary btn-sm">Small button</button>
                    <button class="btn btn-danger btn-sm">Small button</button>
                </p>
                <p>
                    <button class="btn btn-warning btn-sm">Small button</button>
                    <button class="btn btn-success btn-sm">Small button</button>
                    <button class="btn btn-info btn-sm">Small button</button>
                </p>
                <p>
                    <button class="btn btn-inverse btn-default btn-sm">Small button</button>
                    <button class="btn btn-primary btn-round btn-lg">Round button</button>
                    <button class="btn btn-round btn-default btn-lg"><i class="glyphicon glyphicon-ok"></i></button>
                    <button class="btn btn-primary"><i class="glyphicon glyphicon-edit glyphicon-white"></i></button>
                </p>
                <p>
                    <button class="btn btn-default btn-xs">Mini button</button>
                    <button class="btn btn-primary btn-xs">Mini button</button>
                    <button class="btn btn-danger btn-xs">Mini button</button>
                    <button class="btn btn-warning btn-xs">Mini button</button>
                </p>
                <p>
                    <button class="btn btn-info btn-xs">Mini button</button>
                    <button class="btn btn-success btn-xs">Mini button</button>
                    <button class="btn btn-inverse btn-default btn-xs">Mini button</button>
                </p>
            </div>
        </div>
    </div>-->
    <!--/span-->

   <!--  <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list"></i> Buttons</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content  buttons">
                <p>
                    <button class="btn btn-default btn-lg">Large button</button>
                    <button class="btn btn-primary btn-lg">Large button</button>
                </p>
                <p>
                    <button class="btn btn-danger btn-lg">Large button</button>
                    <button class="btn btn-warning btn-lg">Large button</button>
                </p>
                <p>
                    <button class="btn btn-success btn-lg">Large button</button>
                    <button class="btn btn-info btn-lg">Large button</button>
                </p>
                <p>
                    <button class="btn btn-inverse btn-default btn-lg">Large button</button>
                </p>
                <div class="btn-group">
                    <button class="btn btn-default btn-lg">Large Dropdown</button>
                    <button class="btn dropdown-toggle btn-default btn-lg" data-toggle="dropdown"><span
                            class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="glyphicon glyphicon-star"></i> Action</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-tag"></i> Another action</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-download-alt"></i> Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="glyphicon glyphicon-tint"></i> Separated link</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>-->
    <!--/span-->

    <!-- <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list"></i> Weekly Stat</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <ul class="dashboard-list">
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-arrow-up"></i>
                            <span class="green">92</span>
                            New Comments
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-arrow-down"></i>
                            <span class="red">15</span>
                            New Registrations
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-minus"></i>
                            <span class="blue">36</span>
                            New Articles
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-comment"></i>
                            <span class="yellow">45</span>
                            User reviews
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-arrow-up"></i>
                            <span class="green">112</span>
                            New Comments
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-arrow-down"></i>
                            <span class="red">31</span>
                            New Registrations
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-minus"></i>
                            <span class="blue">93</span>
                            New Articles
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-comment"></i>
                            <span class="yellow">254</span>
                            User reviews
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/span
</div><!--/row
    <!-- content ends 
    </div><!--/#content.col-md-0
</div><!--/fluid-row-->

    <!-- Ad, you can remove it -->
    <!-- <div class="row">
        <div class="col-md-9 col-lg-9 col-xs-9 hidden-xs">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Charisma Demo 2 
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-5108790028230107"
                 data-ad-slot="3193373905"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="col-md-2 col-lg-3 col-sm-12 col-xs-12 email-subscription-footer">
            <div class="mc_embed_signup">
                <form action="//halalit.us3.list-manage.com/subscribe/post?u=444b176aa3c39f656c66381f6&amp;id=eeb0c04e84" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div>
                        <label>Keep up with my work</label>
                        <input type="email" value="" name="EMAIL" class="email" placeholder="Email address" required>

                        <div class="power_field"><input type="text" name="b_444b176aa3c39f656c66381f6_eeb0c04e84" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="Subscribe" name="subscribe" class="button"></div>
                    </div>
                </form>
            </div>

            <!--End mc_embed_signup
        </div>

    </div>
    <!-- Ad ends -->

    <!-- <hr>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here settings can be configured...</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="http://usman.it" target="_blank">Muhammad
                Usman</a> 2012 - 2015</p>

        <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a
                href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
    </footer>-->

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
<script>
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
</script>


</body>
</html>
