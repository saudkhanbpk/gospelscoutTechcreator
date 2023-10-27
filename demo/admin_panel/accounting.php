<?php
session_start();

$abc=$_SESSION['user'];
$abc1=$_SESSION['center'];
 
?>
<?php

@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);

if(isset($_POST['submit1']))
{
	$factdate=$_POST['fdate'];
	$cobaldate=$_POST['cdate'];
	$concept=$_POST['concept'];
	$observation=$_POST['observation'];
	$amount=$_POST['amount'];
	$irpf=$_POST['irpf'];
	$net=$_POST['net'];

	$query2="insert into other_income values('','$factdate','$cobaldate','$concept','$observation','$amount','$irpf','$net')";
	$row2=mysql_query($query2);

	if($row2 == 1)
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: accounting.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: accounting.php');
			
			}
}

if(isset($_POST['submit2']))
	{
		$hidden1=$_POST['hidden1'];
			
		$query3=mysql_query("delete from other_income where fdate ='$hidden1'");
			
		if($query3)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: accounting.php');
			}
	}

if(isset($_POST['submit3']))
{
	$date=$_POST['date'];
	$concept=$_POST['concept1'];
	$amount=$_POST['amount'];
	$vat=$_POST['vat'];
	$total=$_POST['total'];

	$query4="insert into expenses values('','$date','$concept','$amount','$vat','','$total')";
	$row4=mysql_query($query4);

	if($row4 == 1)
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: accounting.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: accounting.php');
			
			}
}

if(isset($_POST['submit10']))
	{
		$hidden2=$_POST['hidden2'];
			
		$query13=mysql_query("delete from expenses where date ='$hidden2'");
			
		if($query13)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: accounting.php');
			}
	}

if(isset($_POST['submit4']))
{
	$fname=$_POST['fname'];
	$amount=$_POST['amount'];
	$retention=$_POST['retention'];
	$dpage=$_POST['dpage'];

	$query5="insert into payment_of_salaries values('','$fname','$amount','$retention','$dpage')";
	$row5=mysql_query($query5);

	if($row5 == 1)
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: accounting.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: accounting.php');
			
			}
}

if(isset($_POST['submit11']))
	{
		$hidden3=$_POST['hidden3'];
			
		$query14=mysql_query("delete from payment_of_salaries where amount ='$hidden3'");
			
		if($query14)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: accounting.php');
			}
	}

if(isset($_POST['submit5']))
{
	$fname=$_POST['fname'];
	$date=$_POST['date'];
	$fac=$_POST['fac'];
	$irpf=$_POST['irpf'];
	$amount=$_POST['amount'];
	$retention=$_POST['retention'];
	$net=$_POST['net'];

	$query9="insert into payment_help values('','$fname','$date','$fac','$irpf','$amount','$retention','$net')";
	$row9=mysql_query($query9);

	if($row9 == 1)
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: accounting.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: accounting.php');
			
			}
}

if(isset($_POST['submit12']))
	{
		$hidden4=$_POST['hidden4'];
			
		$query15=mysql_query("delete from payment_help where date ='$hidden4'");
			
		if($query15)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: accounting.php');
			}
	}
	
if(isset($_POST['submit13']))
{
	$idate=$_POST['idate'];
	$inumber=$_POST['inumber'];
	$irpf=$_POST['irpf'];

	$query18="insert into bills_issued values('','$idate','$inumber','$irpf')";
	$row18=mysql_query($query18);

	if($row18 == 1)
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: accounting.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: accounting.php');
			
			}
}

if(isset($_POST['submit15']))
	{
		$hidden5=$_POST['hidden5'];
			
		$query22=mysql_query("delete from bills_issued where idate ='$hidden5'");
			
		if($query22)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: accounting.php');
			}
	}

if(isset($_POST['submit16']))
{
	$date=$_POST['date'];
	$expercise=$_POST['expercise'];
	$ammount=$_POST['ammount'];

	$query20="insert into banking_transaction values('','$date','$expercise','$ammount')";
	$row20=mysql_query($query20);

	if($row20 == 1)
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: accounting.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: accounting.php');
			
			}
}

if(isset($_POST['submit17']))
	{
		$hidden6=$_POST['hidden6'];
			
		$query23=mysql_query("delete from banking_transaction where date ='$hidden6'");
			
		if($query23)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: accounting.php');
			}
	}

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

<style>
h1 {
  font-family: Helvetica;
  font-weight: 100;
}
body {
  color:#333;
}

#maintable1 {border-collapse:collapse;}

    #maintable1 tr:hover {background-color: #FFFFAA;}

    #maintable1 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable2 {border-collapse:collapse;}

    #maintable2 tr:hover {background-color: #FFFFAA;}

    #maintable2 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable3 {border-collapse:collapse;}

    #maintable3 tr:hover {background-color: #FFFFAA;}

    #maintable3 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable4 {border-collapse:collapse;}

    #maintable4 tr:hover {background-color: #FFFFAA;}

    #maintable4 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable5 {border-collapse:collapse;}

    #maintable5 tr:hover {background-color: #FFFFAA;}

    #maintable5 tr.selected th {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable6 {border-collapse:collapse;}

    #maintable6 tr:hover {background-color: #FFFFAA;}

    #maintable6 tr.selected th {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}
</style>



	<script>
function sum() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;
            }
        }

function sum1() {
            var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt22').value;
            var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);


            if (!isNaN(result)) {
                document.getElementById('txt33').value = result;
            }
        }
		
function sum2() {
            var txtFirstNumberValue = document.getElementById('txt12').value;
            var txtSecondNumberValue = document.getElementById('txt23').value;
            var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);


            if (!isNaN(result)) {
                document.getElementById('txt34').value = result;
            }
        }
</script>
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
    <title>CalendarView â€” JavaScript Calendar Widget</title>
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
	  .modal-body {
    max-height: auto !important;
    overflow-y: auto;
}
.modal-dialog { width:960px !important;}
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
                        <li><a class="ajax-link" href="index.php"><img style="padding-right:8px" src="img/EXTERNAL.png"><span>EXTERNAL CONSULTATIONS</span></a>
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
            <a href="accounting.php">ACCOUNTING</a>
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

 <div class="row clinic-account">
    <div class="box col-md-12">
        <div class="box-inner" style="width: 100%;float: left;">
            <div class="box-header well">
				<h2 style="margin-left: 20px;">
				</h2>

                
            </div>
			<div>
			
					<table  height="300px" align="center">
						<tr >
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal" >OTHER INCOME</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal1"  >EXPENSES</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal2" >LIST OF ACTIVITY</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal3">BILLS TO MUTUAS</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal4">PRIVATE BILLS</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal5">PAYMENT OF SALARIES</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal6">PAYMENT HELP</a></th>
						</tr>
						<tr>
							<th style="text-align: center;"><a href="#" data-toggle="modal" data-target="#myModal7">FISCAL SUMMARY</a></th>
						</tr>
					</table>
			</div>
			
			<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					<div style="height: 69px;">
					<table align="center">
						<tr>
							<td>Speciality :</td>
							<td><select name="dropdown" id="dropdown" onChange="getWard(this.value)">
								<?php
								
								$query1=mysql_query("select * from especialitats where activa = 1");
								
								while($row1=mysql_fetch_array($query1))
								{
								?>
								<option value="<?php echo $row1['especialitat'];?>"><?php echo $row1['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
					</table>
					</div>
					
				<div style="border:1px solid black;height: 300px;width: 70%;" id="results24">
				<table border="1" style="width: 100%;" id="maintable1">
					<tr>
						<th>FACT_DATE</th>
						<th>CONCEPT</th>
						<th>AMOUNT</th>
						<th>DATE_COBRO</th>
					</tr>

					<?php
								
								$query4=mysql_query("select * from other_income");
								
								while($row4=mysql_fetch_array($query4))
								{
								?>
					
					<tr>
						<td contenteditable><?php echo $row4['fdate'];?></td>
						<td contenteditable><?php echo $row4['concept'];?></td>
						<td contenteditable><?php echo $row4['amount'];?></td>
						<td contenteditable><?php echo $row4['cdate'];?></td>
					</tr>
					<?php
					}
					?>
				</table>
				</div>
				<div style="margin-top: 45px;">
					<input type="submit" data-toggle="modal" data-target="#myModal01" style="padding: 6px;margin-left: 80px;float:left"  value="ADD">


					<input type="submit" style="padding: 6px;margin-left: 80px;float:left"  value="MODIFY">
					
					

					<form method="POST" style="margin-top: -38px;width: 153px;margin-left: 290px;">
				<input type="text" name="hidden1" style="display:none;" id="hiddenVal1" />
				<input type="submit" name="submit2" onclick="return confirm('Are you sure you want to delete this item?');" style="padding: 6px;margin-left: 80px;"  value="DELETE">
					</form>
				</div>
				<div style="float: right;height: 144px;margin-top: -240px;margin-right: 70px;">
					<input type="submit" style="padding: 15px;"  value="ATTACH DOCUMENT">
					</br>
					<input type="submit" style="padding: 15px;margin: 30px 0px;"  value="DELETE DOCUMENT">
				</div>
				
				<div>
				
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>

<div id="myModal01" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;" id="results24">
				<form method="POST" action="accounting.php" id="myForm24">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">FACT DATE :</th>
						<td><input type="text" name="fdate"  style="width: 100%;" id="datepicker"></td>

						<th style="width: 129px;">COBAL DATE :</th>
						<td><input type="text" name="cdate" style="width: 100%;" id="datepicker1"></td>
					</tr>
					<tr>
						<th style="width: 121px;">CONCEPT :</th>
						<td colspan="3"><select name="concept" id="concept" style="width: 100%;">
							<?php
					
					$query2=mysql_query("select * from income_concept");
					while($row2=mysql_fetch_array($query2))
						{
					?>
							<option value="<?php echo $row2['concept'];?>"><?php echo $row2['concept'];?></option>
						<?php
						}
						?>
								</select></td>
					</tr>
					<tr>
						<th style="width: 150px;">OBSERVATIONS :</th>
						<td colspan="3"><input type="text"  name="observation" id="observation" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">AMOUNT :</th>
						<td colspan="3"><input type="text" name="amount" style="width: 100%;" id="txt1"></td>
					</tr>
					<tr>
						<th style="width: 121px;">IRPF :</th>
						<td colspan="3"><input type="text" name="irpf" style="width: 100%;" id="txt2" onkeyup="sum();" ></td>
					</tr>
					<tr>
						<th>NET :</th>
						<td colspan="3"><input type="text" name="net" style="width: 100%;" id="txt3"></td>
					</tr>
						
					<tr>
						
						<td colspan="4" style="text-align:center"><input type="button" id="submitFormData24" onclick="SubmitFormData24();" value="ADD" /></td>							
							
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
	
	
	<div id="myModal1" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					<div style="height: 69px;">
					<table align="center">
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" id="dropdown" onChange="getWard1(this.value)">
								<?php
								
								$query3=mysql_query("select * from especialitats where activa = 1");
								
								while($row3=mysql_fetch_array($query3))
								{
								?>
								<option value="<?php echo $row3['especialitat'];?>"><?php echo $row3['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary :</td>
							<td><select name="dropdown1" id="wrd1"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
					</table>
					</div>
					
				<div style="border:1px solid black;height: 300px;width: 70%;">
				<table border="1" style="width: 100%;" id="maintable2">
					<tr>
						<th>DATE</th>
						<th>CONCEPT</th>
						<th>AMOUNT</th>
						<th>VAT</th>
						<th>DOC</th>
					</tr>

					<?php
								
								$query5=mysql_query("select * from expenses");
								
								while($row5=mysql_fetch_array($query5))
								{
								?>
					<tr>
						<td contenteditable><?php echo $row5['date'];?></td>
						<td contenteditable><?php echo $row5['concept'];?></td>
						<td contenteditable><?php echo $row5['amount'];?></td>
						<td contenteditable><?php echo $row5['vat'];?></td>
						<td contenteditable><?php echo $row5['total'];?></td>
					</tr>
					<?php } ?>
				</table>
				</div>
				<div style="margin-top: 45px;">
					<input type="submit" data-toggle="modal" data-target="#myModal11" style="padding: 6px;margin-left: 80px;float:left"  value="ADD">


					<input type="submit" style="padding: 6px;margin-left: 80px;float:left"  value="MODIFY">


					
					
				<form method="POST" style="margin-top: -38px;width: 153px;margin-left: 290px;">
				<input type="text" name="hidden2" style="display:none" id="hiddenVal2" />
				<input type="submit" name="submit10" onclick="return confirm('Are you sure you want to delete this item?');" style="padding: 6px;margin-left: 80px;"  value="DELETE">
					</form>
				</div>
				<div style="float: right;height: 144px;margin-top: -240px;margin-right: 70px;">
					<input type="submit" style="padding: 15px;"  value="ATTACH DOCUMENT">
					</br>
					<input type="submit" style="padding: 15px;margin: 30px 0px;"  value="DELETE DOCUMENT">
				</div>
				
				
				
				<div>
				
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>

<div id="myModal11" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			<div id="results25" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="accounting.php" id="myForm25">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">DATE :</th>
						<td><input type="text" name="date" style="width: 100%;" id="datepicker2"></td>
					</tr>
					<tr>
						<th style="width: 121px;">CONCEPT :</th>
						<td colspan="2"><select name="concept1" id="concept1" style="width: 100%;">
			
							<option value="CANON BAYES">CANON BAYES</option>
							<option value="PREMSA OSONA">PREMSA OSONA</option>
							<option value="PRENSA RIPOLLES">PRENSA RIPOLLES</option>
								</select></td>
					</tr>
					<tr>
						<th style="width: 121px;">AMOUNT :</th>
						<td colspan="2"><input type="text" name="amount" style="width: 100%;" id="txt11"></td>
					</tr>
					<tr>
						<th style="width: 121px;">% VAT :</th>
						<td><input type="text" name="vat" style="width: 100%;" id="txt22" onkeyup="sum1();" ></td>
						<td><input type="checkbox" name="irpf">  IRPF</td>
					</tr>
					<tr>
						<th>TOTAL :</th>
						<td colspan="2"><input type="text" name="total" style="width: 100%;" id="txt33"></td>
					</tr>
						
					<tr>
						
						<td colspan="3" style="text-align:center"><input type="button" id="submitFormData25" onclick="SubmitFormData25();" value="ADD" /></td>							
							
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
	
	
	<div id="myModal2" class="modal fade">
    <div style="width: 1080px !important;margin-left: 145px;margin-top:30px;" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
				<div style="border: 1px solid black;height: 450px;width: 365px;">
					<table border="1" width="100%">
						<tr>
							<th>CHANGE</th>
							<th>AMOUNT</th>
						</tr>
						<tr>
							<td>ABC</td>
							<td>ABCD</td>
						</tr>
					</table>
				</div>
				<div style="width: 365px;margin-left: 168PX;margin-top: 15px;">
					<b>TOTAL :</b> <input type="text">
				</div>
				
				<div style="float: right;width: 660px;margin-top: -489px;height: 100px;">
					<table>
					<tr>
					<td><b>INITIAL DATE :</b></td><td><input type="text" id='datepicker3' name="idate"></br></td>
					</tr>
					<tr>
					<td><b>FINAL DATE :</b> </td><td><input type="text" id='datepicker4' name="idate"></td>
					<td><input type="checkbox" value="PRIVATE"> <b>PRIVATE</b> </td>
					<td><input type="submit" value="FILTER"></td>
					</tr>
					</table>
					
					<script type="text/javascript">
            $(function () {
               $('datepicker').datepicker()
			});			   
				</script>
				</div>
				
				<div style="float: right;width: 660px;margin-top: -400px;border: 1px solid black;height: 358px;">
					<table border="1" width="100%">
						<tr>
							<th>CONCEPT</th>
							<th>N</th>
							<th>AMOUNT</th>
						</tr>
						<tr>
							<td>ABC</td>
							<td>ABCD</td>
							<td>ABCD</td>
						</tr>
					</table>
				</div>
				<div style="float: right;width: 410px;margin-top: -26px;">
					<input type="submit" value="SEE EVOLUTION">
				</div>
				
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>
	
	
	<div id="myModal3" class="modal fade">
    <div style="width: 1080px !important;margin-left: 145px;margin-top:30px;" class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
				<div>
					<table width="100%">
						<tr>
							<td><table width="100%">
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" id="dropdown" onChange="getWard2(this.value)">
								<option value="select">SELECT</option>
								<?php
								
								$query16=mysql_query("select * from especialitats where activa = 1");
								
								while($row16=mysql_fetch_array($query16))
								{
								?>
								<option value="<?php echo $row16['especialitat'];?>"><?php echo $row16['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd2"><option value="dr.aiaz">DR.AIAZ</option></select></td>
							
							<td><input type="submit" value="SEE SUMMARY TABLE" style="padding: 3px 60px;"></td>
						</tr>
						<tr>
							<td>MUTUAL : </td>
							<td><select name="dropdown">
							
								<?php
								$query17=mysql_query("select * from origen_mutuas");
								while($row17=mysql_fetch_array($query17))
								{
								?>
								<option value="<?php echo $row17['mutua'];?>"><?php echo $row17['mutua'];?></option>
								<?php } ?>
								</select></td>
							<td colspan="2">INITIAL DATE : <input type="text" id="datepicker0"></br></br> FINAL DATE : <input type="text" id="datepicker01"></td>
							<td>DIFFERENCE INVOICE / ACTIVITY : <input type="text"></br></br> DIFFERENCE INVOICE / ACTIVITY : <input type="text"> </br></br> DIFFERENCE INVOICE / ACTIVITY : <input type="text"> </td>
							
						</tr>
					</table></td>
						</tr>
					</table>
				</div>
				<b>ACTIVITY PERFOMED</b>
				<div style="border: 1px solid black;height: 380px;width: 250px;overflow-x: scroll;">
					<table border="1" style="width: 600px;">
						<tr>
							<th>MONTH</th>
							<th>TOTAL</th>
							<th>NET</th>
							<th>VISIT.</th>
							<th>PROC.</th>
							<th>CIRUR.</th>
						</tr>
					</table>
				</div>
				<div style="width: 135px;float: left;margin-top: -400px;margin-left: 260px;"><b>BILLS ISSUED</b></div>
				<div style="float: left;width: 425px;margin-top: -380px;border: 1px solid black;margin-left: 260px;overflow-x: scroll;height:290px;">
					<table border="1" style="width: 600px;" id="maintable5">
						<tr>
							<th>DATE</th>
							<th>N.FAC</th>
							<th>COUNTING DATE</th>
							<th>NET</th>
						</tr>
						
						<?php
						$query19=mysql_query("select * from bills_issued");
						while($row19=mysql_fetch_array($query19))
						{
						?>
						<tr>
							<th><?php echo $row19['idate'];?></th>
							<th><?php echo $row19['inumber'];?></th>
							<th></th>
							<th><?php echo $row19['irpf'];?></th>
						</tr>
						<?php } ?>
					</table>
				</div>
				
				<div style="width: 425px;float: left;margin-left: 260px;margin-top: -82px;">
				<input type="submit" style="padding: 7px;margin-left: 25px;" data-toggle="modal" data-target="#myModal31" value="NEW&#13;&#10;BILL">
					<input type="submit" style="padding: 7px;" value="EDIT&#13;&#10;INVOICE">
					
					<form method="POST" action="" style="width: 70px;float: right;">
				<input type="text" name="hidden5" style="display:none;" id="hiddenVal5" />
				<input type="submit" name="submit15" style="padding: 7px;" value="CANCEL&#13;&#10;BILL">
					</form>
				

					
					
				<input type="submit" style="padding: 7px;" value="PRINT&#13;&#10;INVOICE">
				<input type="submit" style="padding: 7px;" value="CHECK ON THE&#13;&#10;COBRADA"><input type="submit" style="padding: 7px;margin-left: 105px;" value="ATTACH&#13;&#10;DOCUMENT"><input type="submit" style="padding: 7px;" value="DELETE&#13;&#10;DOCUMENT">
				</div>
				
				<div style="float: right;width: 340px;margin-top: -380px;border:1px solid black;height: 290px;overflow-x: scroll;">
					<table border="1" style="width: 600px;" id="maintable6">
						<tr>
							<th>DATE</th>
							<th>AMMOUNT</th>
							<th>FAC#</th>
							<th>EXPERCISI</th>
						</tr>
						<?php
						$query21=mysql_query("select * from banking_transaction");
						while($row21=mysql_fetch_array($query21))
						{
						?>
						<tr>
							<th><?php echo $row21['date'];?></th>
							<th><?php echo $row21['amount'];?></th>
							<th></th>
							<th><?php echo $row21['excercise'];?></th>
						</tr>
						<?php } ?>
						
					</table>
				</div>
				
				<div style="width: 330px;float: right;margin-right: -19px;margin-top: -82px;">
				<input type="submit" style="padding: 16px;margin-left: 15px;" data-toggle="modal" data-target="#myModal32" value="ADD">
				<input type="submit" style="padding: 16px;margin-left: 15px;" value="MODIFY">
				<form method="POST" action="" style="width: 100px;float: right;margin-right: 45px;">
				<input type="text" name="hidden6" style="display:none;" id="hiddenVal6">
				<input type="submit" name="submit17" onclick="return confirm('Are you sure you want to delete this item?');" style="padding: 16px;margin-left: 15px;" value="DELETE">
				</form>
				<input type="submit" style="padding: 12px;margin-left: 98px;" value="PRINT&#13;&#10;INVOICE">
				</div>
				<div style="width: 154px;float: left;margin-top: -444px;margin-left: 700px;"><b>BANKING TRANSACTION</b></div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>
	
	<div id="myModal31" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			<div id="results26" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="accounting.php" id="myForm26">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">INVOICE DATE :</th>
						<td><input type="text" name="idate" id="datepicker10" style="width: 100%;" ></td>
					</tr>
					<tr>
						<th style="width: 121px;">INVOICE NUMBER :</th>
						<td colspan="2"><input type="text" name="inumber" id="inumber" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">IRPF :</th>
						<td><input type="text" name="irpf" id="irpf" style="width: 100%;"></td>
					</tr>	
					<tr>
						<td colspan="3" style="text-align:center"><input type="button" id="submitFormData26" onclick="SubmitFormData26();" value="RECORD" /></td>
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

<div id="myModal32" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			<div id="results27" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="accounting.php" id="myForm27">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">DATE :</th>
						<td><input type="text" name="date" id="datepicker11" style="width: 100%;" ></td>
					</tr>
					<tr>
						<th style="width: 121px;">EXPERCISE :</th>
						<td><input type="text" name="expercise" id="expercise" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">AMMOUNT :</th>
						<td colspan="2"><input type="text"  name="ammount" id="ammount" style="width: 100%;"></td>
					</tr>
					<tr>
						
						<td colspan="3" style="text-align:center"><input type="button" id="submitFormData27" onclick="SubmitFormData27();" value="INSERT" /></td>							
							
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
	
				<div id="myModal4" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					<div style="height: 69px;">
					<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" id="dropdown" onChange="getWard3(this.value)">
								<?php
								
								$query24=mysql_query("select * from especialitats where activa = 1");
								
								while($row24=mysql_fetch_array($query24))
								{
								?>
								<option value="<?php echo $row24['especialitat'];?>"><?php echo $row24['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd3"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
						
						<tr>
							<td>INITIAL DATE : </td>
							<td><input type="text" id="datepicker5"></td>
							<td>FINAL DATE: </td>
							<td><input type="text" id="datepicker6"></td>
						</tr>
					</table>
					</div>
					
				<div style="border:1px solid black;height: 300px;width: 70%;margin-top: 23px;width:100%;">
				<table border="1" style="width: 100%;">
					<tr>
						<th>DATE</th>
						<th>FIRST NAME</th>
						<th>CONCEPT</th>
						<th>IMPORT</th>
					</tr>
					<tr>
						<td>asds</td>
						<td>asds</td>
						<td>asds</td>
						<td>asds</td>
						
					</tr>
				</table>
				</div>
				<div>
					<input type="submit" style="padding: 24px;margin-left: 43%;margin-top: 15px;"  value="AMOUNT">
				</div>
				
				
				
				<div>
				
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>
	
	
	<div id="myModal5" class="modal fade">
    <div class="modal-dialog" style="width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					<div style="height: 55px;">
					<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" id="dropdown" onChange="getWard4(this.value)">
								<?php
								
								$query7=mysql_query("select * from especialitats where activa = 1");
								
								while($row7=mysql_fetch_array($query7))
								{
								?>
								<option value="<?php echo $row7['especialitat'];?>"><?php echo $row7['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd4"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
					</table>
					</div>
				
				<div><b>SALES</b></div>
				<div style="border:1px solid black;height: 300px;width: 70%;width:100%;overflow-x: scroll;">
						<table>
						<tr>
						
						<th>FIRST NAME :</th>
						<td><select name="dropdown1" style="width: 240%;">
							<?php 
					$query6=mysql_query("select * from  payment_of_salaries");
					while($row6=mysql_fetch_array($query6))
					{
					?><option value="<?php echo $row6['firstname'];?>"><?php echo $row6['firstname'];?></option>
					<?php } ?></select></td>
						</tr>
						</table>
					
				<table border="1" style="width: 100%;" id="maintable3">
					<tr>
						<th>AMOUNT</th>
						<th>RETENTION</th>
						<th>DATE>PAG</th>
					</tr>
					<?php 
					$query7=mysql_query("select * from  payment_of_salaries");
					while($row7=mysql_fetch_array($query7))
					{
					?>
						
					<tr>
						<td contenteditable><?php echo $row7['amount'];?></td>
						<td contenteditable><?php echo $row7['retention'];?></td>
						<td contenteditable><?php echo $row7['dpage'];?></td>	
					</tr>
					<?php } ?>
				</table>
				</div>
				<div>
					<input type="submit" data-toggle="modal" data-target="#myModal51" style="padding: 24px;margin-left: 42px;"  value="ADD">
					<input type="submit" style="padding: 24px;margin-left: 40px;margin-top: 15px;"  value="MODIFY">
					
					
					
					
					<form method="POST" style="margin-top: -74px;width: 153px;margin-left: 278px;">
				<input type="text" name="hidden3" style="display:none;" id="hiddenVal3" />
				<input type="submit" name="submit11" onclick="return confirm('Are you sure you want to delete this item?');" style="padding: 24px;margin-left: 30px;"  value="DELETE">
					</form>
				</div>
				
				<div>
				
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>

<div id="myModal51" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			<div id="results28" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="accounting.php" id="myForm28">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 123px;">FIRST NAME :</th>
						<td><input type="text" name="fname" id="fname2" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">AMOUNT :</th>
						<td><input type="text" name="amount" id="amount" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">RETENTION :</th>
						<td><input type="text" name="retention" id="retention" style="width: 100%;" ></td>
					</tr>
					<tr>
						<th>DAGE PAGE :</th>
						<td><input type="text" name="dpage" id="dpage" style="width: 100%;"></td>
					</tr>
					<tr>
						
						<td colspan="2" style="text-align:center"><input type="button" id="submitFormData28" onclick="SubmitFormData28();" value="RECORD" /></td>							
							
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
	
	
	<div id="myModal6" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					<div style="height: 69px;">
					<table align="center">
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" id="dropdown" onChange="getWard5(this.value)">
								<?php
								
								$query8=mysql_query("select * from especialitats where activa = 1");
								
								while($row8=mysql_fetch_array($query8))
								{
								?>
								<option value="<?php echo $row8['especialitat'];?>"><?php echo $row8['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd5"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
						
						<tr colspan="2">
							<td >FIRST NAME : </td>
							<td><select name="dropdown1">
							<?php 
					
					$query11=mysql_query("select * from payment_help");
					while($row11=mysql_fetch_array($query11))
					{
					?><option value="<?php echo $row11['first_name'];?>" style="width: 170px;"><?php echo $row11['first_name'];?></option>
					<?php } ?></select></td>
						</tr>
					</table>
					</div>
					
				<div style="border:1px solid black;height: 300px;width: 70%;margin-top: 23px;width:83%;overflow-x: scroll;">
				<table border="1" style="width: 100%;" id="maintable4">
					<tr>
						<th>DATE</th>
						<th>#FAC</th>
						<th>IRPF</th>
						<th>AMOUNT</th>
						<th>RETENTION</th>
						<th>NET</th>
					</tr>
					
					<?php 
					
					$query10=mysql_query("select * from payment_help");
					while($row10=mysql_fetch_array($query10))
					{
					?>
					<tr>
						<td><?php echo $row10['date'];?></td>
						<td><?php echo $row10['fac'];?></td>
						<td><?php echo $row10['irpf'];?></td>
						<td><?php echo $row10['amount'];?></td>
						<td><?php echo $row10['retention'];?></td>
						<td><?php echo $row10['net'];?></td>
					</tr>
					<?php } ?>
				</table>
				</div>
				<div style="float: right;width: 155px;margin-top: -300px;">
					<input type="submit" data-toggle="modal" data-target="#myModal61" value="ADD" style="padding:10px;"></br>
					<input type="submit"  value="MODIFY" style="padding:10px;margin-top:40px;"></br>
					
				<form method="POST" action="">
				<input type="text" name="hidden4" style="display:none;" id="hiddenVal4" />
				<input type="submit" name="submit12" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding:10px;margin-top:40px;">
				</form>
					
					
					
					<input type="submit"  value="TO PRINT" style="padding:10px;margin-top:37px;">
				</div>
				
				
				
				<div>
				
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>
	
	<div id="myModal61" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			<div id="results29" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="accounting.php" id="myForm29">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 123px;">FIRST NAME :</th>
						<td><input type="text" name="fname" id="fname3" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 123px;">DATE :</th>
						<td><input type="text" name="date" style="width: 100%;" id="datepicker7"></td>
					</tr>
					<tr>
						<th style="width: 121px;">#FAC :</th>
						<td><input type="text" name="fac" id="fac" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">IRPF :</th>
						<td><input type="text" name="irpf" id="irpf1" style="width: 100%;" ></td>
					</tr>
					<tr>
						<th>AMOUNT :</th>
						<td><input type="text" name="amount" style="width: 100%;" id="txt12"></td>
					</tr>
					<tr>
						<th>RETENTION :</th>
						<td><input type="text" name="retention" style="width: 100%;" id="txt23" onkeyup="sum2();"></td>
					</tr>
					<tr>
						<th>NET :</th>
						<td><input type="text" name="net" style="width: 100%;" id="txt34"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center"><input type="button" id="submitFormData29" onclick="SubmitFormData29();" value="INSERT" /></td>	
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
	
	
	<div id="myModal7" class="modal fade">
    <div class="modal-dialog" style="width: 550px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
						<b style="margin-left: 90px;">GROUPED BY : </b><select style="width: 180px;" name="dropdown"></select>
					<div style="height: 55px;">
					<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" id="dropdown" onChange="getWard6(this.value)">
								<?php
								
								$query12=mysql_query("select * from especialitats where activa = 1");
								
								while($row12=mysql_fetch_array($query12))
								{
								?>
								<option value="<?php echo $row12['especialitat'];?>"><?php echo $row12['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd6"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
					</table>
					</div>
				
				<div style="width: 333px;height: 170px;margin-left: 100px;">
					<b>INITIAL DATE:</b><input type="text" id="datepicker8"><br/><br/>
					
					<b>FINAL DATE:</b><input type="text" id="datepicker9"><br/><br/>
					
					<input type="submit" style="padding: 10px;margin-left: 115px;" value="TO PRINT">
				</div>
				
				
				
				<div>
				
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
                    <button type="button" class="close" data-dismiss="modal">Ã—</button>
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
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script>
function getWard(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd").html(data);
		}
	});
}

function getWard1(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd1").html(data);
		}
	});
}

function getWard2(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd2").html(data);
		}
	});
}

function getWard3(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd3").html(data);
		}
	});
}

function getWard4(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd4").html(data);
		}
	});
}

function getWard5(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd5").html(data);
		}
	});
}

function getWard6(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd6").html(data);
		}
	});
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script language="javascript"><!--
//<![CDATA[
$("#maintable1 tr").click(function(){

    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal1").value = value;
		
    }
});

$("#maintable2 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal2").value = value;
		
    }
});

$("#maintable3 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal3").value = value;
		
    }
});

$("#maintable4 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal4").value = value;
		
    }
});

$("#maintable5 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('th:first').html();
		
		document.getElementById("hiddenVal5").value = value;
		
    }
});

$("#maintable6 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('th:first').html();
		
		document.getElementById("hiddenVal6").value = value;
		
    }
});
//]]>
-->
</script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
<script>
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker0" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker01" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker1" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker2" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker3" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker4" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker5" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker6" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker7" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker8" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker9" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);

$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker10" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);

$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $( "#datepicker11" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);

</script>

<script src="js/submit.js"></script>

<script>
function SubmitFormData24() {
    var fdate = $("#datepicker").val();
    var cdate = $("#datepicker1").val();
    var concept = $("#concept").val();
	var observation = $("#observation").val();
	var amount = $("#txt1").val();
	var irpf = $("#txt2").val();
	var net = $("#txt3").val(); 


    $.post("insertdata.php", { fdate: fdate, cdate: cdate, concept: concept, observation: observation, amount: amount, irpf: irpf, net: net },
    function(data) {
	 $('#results24').html(data);
	 $('#myForm24')[0].reset();
    });
}

function SubmitFormData25() {
	
    var date = $("#datepicker2").val();
    var concept1 = $("#concept1").val();
	var amount = $("#txt11").val();
	var vat = $("#txt22").val();
	var total = $("#txt33").val();

    $.post("insertdata.php", { date: date, concept1: concept1, amount: amount, vat: vat, total: total },
    function(data) {
	 $('#results25').html(data);
	 $('#myForm25')[0].reset();
    });
}

function SubmitFormData26() {
	
    var idate = $("#datepicker10").val();
    var inumber = $("#inumber").val();
	var irpf = $("#irpf").val();

    $.post("insertdata.php", { idate: idate, inumber: inumber, irpf: irpf },
    function(data) {
	 $('#results26').html(data);
	 $('#myForm26')[0].reset();
    });
}

function SubmitFormData27() {
	
    var dated = $("#datepicker11").val();
    var expercise = $("#expercise").val();
	var ammount = $("#ammount").val();

    $.post("insertdata.php", { dated: dated, expercise: expercise, ammount: ammount },
    function(data) {
	 $('#results27').html(data);
	 $('#myForm27')[0].reset();
    });
}

function SubmitFormData28() {
	
    var fname2 = $("#fname2").val();
    var amount = $("#amount").val();
	var retention = $("#retention").val();
	var dpage = $("#dpage").val();

    $.post("insertdata.php", { fname2: fname2, amount: amount, retention: retention, dpage: dpage },
    function(data) {
	 $('#results28').html(data);
	 $('#myForm28')[0].reset();
    });
}

function SubmitFormData29() {
	
    var fname3 = $("#fname3").val();
    var date7 = $("#datepicker7").val();
	var fac = $("#fac").val();
	var irpf = $("#irpf1").val();
	var amount12 = $("#txt12").val();
	var retention23 = $("#txt23").val();
	var net = $("#txt34").val();


    $.post("insertdata.php", { fname3: fname3, date7: date7, fac: fac, irpf: irpf, amount12: amount12, retention23: retention23, net: net },
    function(data) {
	 $('#results29').html(data);
	 $('#myForm29')[0].reset();
    });
}
</script>
</body>
</html>
