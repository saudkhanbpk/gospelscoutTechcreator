<?php
session_start();

$abc=$_SESSION['user'];
$abc1=$_SESSION['center'];
 
?>
<?php

@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);

if(isset($_POST['submit']))
{
	$role=$_POST['role'];
	$user=$_POST['user'];
	$key=$_POST['key'];
	$rkey=$_POST['rkey'];

	$query="INSERT INTO login values('','$role','$user','$key','$rkey')";
	$row=mysql_query($query);
	
	if($row==1)
		{
		echo "<script>alert('Inserted Succesfully');</script>";
		header('Location: configuration.php');
		}
	else
		{
		echo "<script>alert('Please Re-Insert');</script>";
		}
	
	
}



if(isset($_POST['submit1']))
	{
		$ckey=$_POST['ckey'];
		$nkey=$_POST['nkey'];
		$cnkey=$_POST['cnkey'];

		$query2=mysql_query("select * from login where password = '$ckey' AND user = '$abc'");
		$row2=mysql_fetch_array($query2);

		if($row2 == 0)
			{
				echo "<script>alert('Please Check Your Current Key');</script>";
				header('Location: configuration.php');
			}
		else 
			{
				if($nkey == $cnkey)
				{
				$id=$row2['id'];
				$query3=mysql_query("UPDATE login SET password = '$cnkey' where id='$id' AND user = '$abc'");
				
				if($query3 == 1)
					{
				echo "<script>alert('Updated Successfully');</script>";
				header('Location: logout');
					}
					else
					{
							echo "<script>alert('Not Updated');</script>";
							header('Location: configuration.php');
					}
				}
				else
				{
				echo "<script>alert('Your New Key Could Not Match');</script>";
				header('Location: configuration.php');
				}
			}
	}

if(isset($_POST['submit2']))
	{
		$noc=$_POST['noc'];
		$nif=$_POST['nif'];
		$responsable=$_POST['responsable'];
		$add=$_POST['add'];
		$cip=$_POST['cip'];
		$population=$_POST['population'];
		$phones=$_POST['phone'];

		$query6=mysql_query("select * from login where user = '$abc'");
		$row6=mysql_fetch_array($query6);

		$login_id=$row6['id'];

		$query5="insert into medical_info values('','$login_id','$noc','$nif','$responsable','$add','$cip','$population','$phones')";
		$row5=mysql_query($query5);

		if($row5 == 1)
			{
				echo "<script>alert('Record Inserted');</script>";
				header('Location: configuration.php');
			}

		else
			{
				echo "<script>alert('Please Re-Enter Record');</script>";
				header('Location: configuration.php');
			}
		
	}

if(isset($_POST['submit3']))
	{

		$noc=$_POST['noc'];
		$nif=$_POST['nif'];
		$responsable=$_POST['responsable'];
		$add=$_POST['add'];
		$cip=$_POST['cip'];
		$population=$_POST['population'];
		$phones=$_POST['phone'];


				echo "<script>alert('Updated Successfully');</script>";
				header('Location: configuration.php');
	}

if(isset($_POST['submit4']))
	{
		
		$doctor=$_POST['doctor'];
		$speciality=$_POST['speciality1'];
		$ncdo = $_POST['ncdo'];
		$nif=$_POST['d_nif'];
		$add=$_POST['d_add'];
		$cip=$_POST['d_cip'];
		$population=$_POST['d_population'];
		$phones=$_POST['d_phone'];
		$emails=$_POST['d_email'];

		$query10="insert into doctor_info values('','$doctor','$speciality','$ncdo','$nif','$add','$cip','$population','$phones','$emails')";
		$row10=mysql_query($query10);

		if($row10 == 1)
			{
			echo "<script>alert('Added Successfully');</script>";
			header('Location: configuration.php');
			}
		else
			{
			echo "<script>alert('Not Added');</script>";
			header('Location: configuration.php');
			}
}

if(isset($_POST['submit5']))
	{
		$hidden=$_POST['hidden'];
			
		$query12=mysql_query("delete from doctor_info where doctor='$hidden'");
			
		if($query12)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit6']))
	{
		$role=$_POST['role1'];
		$status=$_POST['speciality2'];

		if($status == 'ACTIVE')
		{
		$query14=mysql_query("UPDATE especialitats SET activa = '1' where especialitat = '$role'");
			echo "<script>alert('Successfully Activated');</script>";
			header('Location: configuration.php');
		}
		else if($status == 'DEACTIVE')
		{
		$query14=mysql_query("UPDATE especialitats SET activa = '0' where especialitat = '$role'");
		}
		
		
	}

if(isset($_POST['submit7']))
	{
		$diagnosis=$_POST['dia'];

		$query15="insert into diagnosis value('','$diagnosis')";
		$row15=mysql_query($query15);
		
		if($row15 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit8']))
	{
		$hidden1=$_POST['hidden1'];
			
		$query17=mysql_query("delete from diagnosis where diagnosis ='$hidden1'");
			
		if($query17)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}


if(isset($_POST['submit9']))
		{
			$fname =$_POST['fname'];
			$dropdown3 =$_POST['dropdown3'];
			$dropdown4 =$_POST['dropdown4'];

			$vst =$_POST['vst'];
			$vat =$_POST['vat'];
			$prc =$_POST['prc'];
			$irpf =$_POST['irpf'];
			$sry =$_POST['sry'];

			$query20="insert into agendas_costcenters values('','$fname','$dropdown3','$dropdown4','$vst','$vat','$prc','$irpf','$sry','')";
			$row20=mysql_query($query20);

			if($row20 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
			
		}

if(isset($_POST['submit10']))
	{
		$hidden2=$_POST['hidden2'];
			
		$query21=mysql_query("delete from agendas_costcenters where fname ='$hidden2'");
			
		if($query21)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit11']))
	{
		$name=$_POST['name'];
		$nif=$_POST['nif'];
		$add=$_POST['add'];
		$cip=$_POST['cip'];
		$population=$_POST['population'];
		$telephone=$_POST['telephone'];
		$email=$_POST['email'];
		$irpf=$_POST['irpf'];
		$url=$_POST['url'];
		$bmachine=$_POST['bmachine'];
		$code=$_POST['code'];

		$query26=mysql_query("select * from facturadores_origen where nombre='$bmachine'");
		$row26=mysql_fetch_array($query26);

		$id=$row26['id']; 

		$query25="insert into origen_mutuas values('','','$name','$irpf','$add','$population','$nif','$cip','$telephone','$email','$id','$code','$url')";
		$row25=mysql_query($query25);

		if($row25 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
	}

if(isset($_POST['submit12']))
	{
		$hidden3=$_POST['hidden3'];
			
		$query26=mysql_query("delete from origen_mutuas where mutua ='$hidden3'");
			
		if($query26)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit13']))
	{
		$name1=$_POST['name'];
		$nif=$_POST['nif'];
		$add=$_POST['add'];
		$irpf=$_POST['irpf'];
		$salary=$_POST['salary'];

		$query31="insert into sales values('','$name1','$add','$nif','irpf','$salary')";
		$row31=mysql_query($query31);

		if($row31 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php');
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
	}

if(isset($_POST['submit14']))
	{
		$hidden4=$_POST['hidden4'];
			
		$query32=mysql_query("delete from sales where s_name ='$hidden4'");
			
		if($query32)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit15']))
	{
		$concept=$_POST['inc'];

		$query34="insert into income_concept value('','$concept')";
		$row34=mysql_query($query34);
		
		if($row34 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit16']))
	{
		$hidden5=$_POST['hidden5'];
			
		$query35=mysql_query("delete from income_concept where concept ='$hidden5'");
			
		if($query35)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit17']))
	{
		$concept=$_POST['inc'];

		$query36="insert into concept_of_expenses value('','$concept')";
		$row36=mysql_query($query36);
		
		if($row36 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit18']))
	{
		$hidden6=$_POST['hidden6'];
			
		$query39=mysql_query("delete from concept_of_expenses where concept ='$hidden6'");
			
		if($query39)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit19']))
	{
		$speciality=$_POST['speciality3'];
		$musicalinfluences=$_POST['musicalinfluences'];

		$query40="insert into invoice_template value('','$speciality','$musicalinfluences')";
		$row40=mysql_query($query40);
		
		if($row40 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit20']))
	{
		$pat=$_POST['pat'];

		$query42="insert into pathology value('','$pat')";
		$row42=mysql_query($query42);
		
		if($row42 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit21']))
	{
		$hidden7=$_POST['hidden7'];
			
		$query43=mysql_query("delete from pathology where pathology ='$hidden7'");
			
		if($query43)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit22']))
	{
		$dep=$_POST['dep'];

		$query46="insert into department value('','$dep')";
		$row46=mysql_query($query46);
		
		if($row46 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit23']))
	{
		$hidden8=$_POST['hidden8'];
			
		$query48=mysql_query("delete from department where department ='$hidden8'");
			
		if($query48)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit24']))
	{
		$treatment=$_POST['treatment'];
		$posology=$_POST['posology'];
		$units=$_POST['units'];
		$pattern=$_POST['pattern'];

		$query49="insert into recipes value('','$treatment','$posology','$units','$pattern')";
		$row49=mysql_query($query49);
		
		if($row49 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit25']))
	{
		$hidden9=$_POST['hidden9'];
			
		$query50=mysql_query("delete from recipes where treatment ='$hidden9'");
			
		if($query50)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit26']))
	{
		$proof=$_POST['proof'];

		$query54="insert into proof value('','$proof')";
		$row54=mysql_query($query54);
		
		if($row54 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
}

if(isset($_POST['submit27']))
	{
		$hidden10=$_POST['hidden10'];
			
		$query55=mysql_query("delete from proof where proof ='$hidden10'");
			
		if($query55)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit28']))
	{
		$parameter=$_POST['parameter'];
		$fraction=$_POST['fraction'];
		$ratio=$_POST['ratio'];
		$checkbox= $_POST['checkbox'];

		$query58="insert into settings value('','$parameter','$fraction','$ratio','$checkbox')";
		$row58=mysql_query($query58);
		
		if($row58 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}

if(isset($_POST['submit29']))
	{
		$hidden11=$_POST['hidden11'];
			
		$query60=mysql_query("delete from settings where parameter ='$hidden11'");
			
		if($query60)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit30']))
	{
		$fname=$_POST['fname'];
		$address=$_POST['address'];
		$nif=$_POST['nif'];
		$mshare= $_POST['mshare'];
		$pshare= $_POST['pshare'];
		$retention= $_POST['retention'];

		$query62="insert into help value('','$fname','$address','$nif','$sshare','$pshare','$retention')";
		$row62=mysql_query($query62);
		
		if($row62 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}

if(isset($_POST['submit31']))
	{
		$hidden12=$_POST['hidden12'];
			
		$query63=mysql_query("delete from help where fname ='$hidden12'");
			
		if($query63)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit32']))
	{
		$clinic=$_POST['clinic'];

		$query66="insert into clinic value('','$clinic')";
		$row66=mysql_query($query66);
		
		if($row66 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}

if(isset($_POST['submit33']))
	{
		$hidden13=$_POST['hidden13'];
			
		$query67=mysql_query("delete from clinic where clinic ='$hidden13'");
			
		if($query67)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit34']))
	{
		$title=$_POST['title'];

		$query70="insert into title value('','$title')";
		$row70=mysql_query($query70);
		
		if($row70 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}

if(isset($_POST['submit35']))
	{
		$hidden14=$_POST['hidden14'];
			
		$query72=mysql_query("delete from title where title ='$hidden14'");
			
		if($query72)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}

if(isset($_POST['submit36']))
	{
		$billing=$_POST['speciality5'];
		$terminal=$_POST['terminal'];
		$user=$_POST['user'];
		$key=$_POST['key'];
		$profetional=$_POST['profetional'];
		$speciality=$_POST['speciality'];

		$query75="insert into billing_machines value('','$billing','$terminal','$user','$key','$profetional','$speciality')";
		$row75=mysql_query($query75);
		
		if($row75 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}

if(isset($_POST['submit37']))
	{
		$hidden15=$_POST['hidden15'];
			
		$query77=mysql_query("delete from billing_machines where billing ='$hidden15'");
			
		if($query77)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}


if(isset($_POST['submit38']))
	{
		$process=$_POST['process'];
		$procedure=$_POST['procedure'];
		$comports=$_POST['comports'];
		$alternatives=$_POST['alternatives'];
		$information=$_POST['information'];

		$query78="insert into concent value('','$process','$procedure','$comports','$alternatives','$information')";
		$row78=mysql_query($query78);
		
		if($row78 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}

if(isset($_POST['submit39']))
	{
		$hidden16=$_POST['hidden16'];
			
		$query80=mysql_query("delete from concent where process ='$hidden16'");
			
		if($query80)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}
	
	
if(isset($_POST['submit40']))
	{
		$mutuas=$_POST['mutuas'];
		$process=$_POST['process'];
		$code=$_POST['code'];
		$rate=$_POST['rate'];
	

		$query82="insert into procedure_in_consultations value('','$mutuas','$process','$code','$rate')";
		$row82=mysql_query($query82);
		
		if($row82 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}
	
	if(isset($_POST['submit41']))
	{
		$hidden17=$_POST['hidden17'];
			
		$query84=mysql_query("delete from  procedure_in_consultations where process ='$hidden17'");
			
		if($query84)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}
	
	if(isset($_POST['submit42']))
	{
		$mutuas=$_POST['mutuas'];
		$process=$_POST['process1'];
		$code=$_POST['code1'];
		$rate=$_POST['rate1'];
	

		$query87="insert into surgical_acts value('','$mutuas','$process','$code','$rate')";
		$row87=mysql_query($query87);
		
		if($row87 == 1 )
			{
			echo "<script>alert('Successfully Added');</script>";
			header('Location: configuration.php'); 
			}
		else
			{
				echo "<script>alert('Not Added');</script>";
				header('Location: configuration.php');
			
			}
				
	}
	
	if(isset($_POST['submit43']))
	{
		$hidden18=$_POST['hidden18'];
			
		$query89=mysql_query("delete from  surgical_acts where process ='$hidden18'");
			
		if($query89)
			{
			echo "<script>alert('Successfully Deleted');</script>";
			header('Location: configuration.php');
			}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
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
    
    <title>work clinic station </title>
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




<style>
    #maintable {border-collapse:collapse;}

    #maintable tr:hover {background-color: #FFFFAA;}

    #maintable tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
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

    #maintable5 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable6 {border-collapse:collapse;}

    #maintable6 tr:hover {background-color: #FFFFAA;}

    #maintable6 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable7 {border-collapse:collapse;}

    #maintable7 tr:hover {background-color: #FFFFAA;}

    #maintable7 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable8 {border-collapse:collapse;}

    #maintable8 tr:hover {background-color: #FFFFAA;}

    #maintable8 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable9 {border-collapse:collapse;}

    #maintable9 tr:hover {background-color: #FFFFAA;}

    #maintable9 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable10 {border-collapse:collapse;}

    #maintable10 tr:hover {background-color: #FFFFAA;}

    #maintable10 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable11 {border-collapse:collapse;}

    #maintable11 tr:hover {background-color: #FFFFAA;}

    #maintable11 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable12 {border-collapse:collapse;}

    #maintable12 tr:hover {background-color: #FFFFAA;}

    #maintable12 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable13 {border-collapse:collapse;}

    #maintable13 tr:hover {background-color: #FFFFAA;}

    #maintable13 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable14 {border-collapse:collapse;}

    #maintable14 tr:hover {background-color: #FFFFAA;}

    #maintable14 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable15 {border-collapse:collapse;}

    #maintable15 tr:hover {background-color: #FFFFAA;}

    #maintable15 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable16 {border-collapse:collapse;}

    #maintable16 tr:hover {background-color: #FFFFAA;}

    #maintable16 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable17 {border-collapse:collapse;}

    #maintable17 tr:hover {background-color: #FFFFAA;}

    #maintable17 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}

#maintable18 {border-collapse:collapse;}

    #maintable18 tr:hover {background-color: #FFFFAA;}

    #maintable18 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}


    </style>

    <!-- jQuery -->
<script src="bower_components/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/ckeditor/adapters/jquery.js"></script>
<script>
$('.table').on( 'dblclick', 'tr', function () {
self.Editor.edit( this );
} );
</script>




	
    

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->

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
	  .modal-body {
    max-height: auto !important;
    overflow-y: auto;
}
.modal-dialog { width:960px;}
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
 
<script type="text/javascript">
$(".checkbox").on("change", function() {
    var val = $(this).val();
    var id = this.id;
});
 
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
            <a class="navbar-brand" href="index.php"> <img alt="Charisma Logo" src="img/logo20.png" class="hidden-xs"/>
                <span class="logo-text">WORK CLINIC STATION</span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
					
					<li class="btn btn-default dropdown-toggle">CENTER : <?php echo $abc1;?></li>
					<li class="btn btn-default dropdown-toggle">USER : <?php echo $abc;?></li>
                   <li class="btn btn-default dropdown-toggle"> <a href="logout">Change User</a></li>
               
             
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
            <a href="configuration.php">CONFIGURATION</a>
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
        <div class="box-inner  inner-height">
            <div class="box-header well">
				<h2 style="margin-left: 20px;">
					
				</h2>

                
            </div>
			<div>
					<div >
						<div class="configration-2nd-header">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">GENERAL</a></td>
							</tr>
						</table>
						</div>
						<div class="configration-width">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal" >MEDICAL CENTER INFORMATION</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;" ><a href="#" data-toggle="modal" data-target="#myModal1">SPECIALITIES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;" ><a href="#" data-toggle="modal" data-target="#myModal1111">ADD SPECIALITIES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal2">OPTIONAL</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal3">AGENDAS/COST CENTERS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal4">DIAGNOSTICS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal5">MUTUAS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal6">SMS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal7">CHANGE OF PASSWORD</a></th>
										</tr>
										<tr>
											<th style="text-align: center;font: normal normal bold 12pt Tahoma;"><a href="#" data-toggle="modal" data-target="#myModal8">USER MANAGEMENT</a></th>
										</tr>
									</table>
						</div>


<div id="myModal1111" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results3" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm3">

						<table>
							<tr>
								<td>SELECT ROLE :</td>
								<td><select name="role1" id="role1">
									<option value="select">SELECT</option>

									<?php
									$query13=mysql_query("select * from especialitats");
									while($row13=mysql_fetch_array($query13))
									{
									?>
									<option value="<?php echo $row13['especialitat'];?>"><?php echo $row13['especialitat'];?></option>
									<?php
									}
									?>
									</select></td>
								</td>
							</tr>
							<tr>
								<td>Status :</td>
								<td><select name="speciality2" id="speciality2">
									<option value="select">SELECT</option>
									<option value="ACTIVE">ACTIVE</option>
									<option value="DEACTIVE">DEACTIVE</option></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData3" onclick="SubmitFormData3();" value="INSERT" /></td>
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
						
<div id="myModal" class="modal fade">
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
					<?php
					
					$query6=mysql_query("select * from login where user = '$abc'");
					$row6=mysql_fetch_array($query6);

					$log_id=$row6['id'];

						$query7=mysql_query("select * from medical_info where login_id ='$log_id'");
						$row7=mysql_fetch_array($query7);
					?>
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">NAME OF THE CENTER :</th>
						<td><input type="text" name="noc" style="width: 100%;" id="noc" value="<?php echo $row7['noc'];?>"></td>
					</tr>
					<tr>
						<th style="width: 121px;">NIF :</th>
						<td ><input type="text" name="nif" style="width: 100%;" id="nif" value="<?php echo $row7['nif'];?>"></td>
					</tr>
					<tr>
						<th>RESPONSABLE :</th>
						<td><input type="text" name="responsable" style="width: 100%;" id="responsable" value="<?php echo $row7['responsable'];?>"></td>
					</tr>
					<tr>
						<th>ADDRESS :</th>
						<td><input type="text" name="add" style="width: 100%;" id="add" value="<?php echo $row7['address'];?>"></td>
					</tr>
					<tr>
						<th>CIP :</th>
						<td><input type="text" name="cip" style="width: 100%;" id="cip" value="<?php echo $row7['cip'];?>"></td>
					</tr>
					<tr>
						<th>POPULATION :</th>
						<td><input type="text" name="population" style="width: 100%;" id="population" value="<?php echo $row7['population'];?>"></td>
					</tr>
					<tr>
						<th>PHONES :</th>
						<td><input type="text" name="phone" style="width: 100%;" id="phone" value="<?php echo $row7['phones'];?>"></td>
					</tr>
						
					<tr>
						<?php

						if($row7) 
							{
						?>
						<td colspan="2" style="text-align:center"><input type="button" id="submitFormData1" onclick="SubmitFormData1();" value="UPDATE" /></td>
							<?php
							}
							else
							{
							?>
						<td colspan="2" style="text-align:center"><input type="button" id="submitFormData2" onclick="SubmitFormData2();" value="INSERT" /></td>							
							<?php
							}
							?>
					</tr>
				</table>
				</form>
				</div>
				
				<div style="border:1px solid black;float: right;height: 400px;margin-top: -307px;width: 250px;">
					<table border="1" style="width: 100%;">
					<tr>
						<th>F.MISSION </th>
					</tr>
					<tr>
						<td>m,nb</td>
					</tr>
					</table>
				</div>
				
				
				
				<div style="float: right;margin-top: -328px;margin-right: -94px;"><b>BILLS ISSUED :</b></div>
				
				<div style="float: right;margin-top: 100px;margin-right: -125px;">
				<input type="submit" value="SEE">
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    </div>
	
	<div id="myModal1" class="modal fade">
    <div class="modal-dialog" style="width: 450px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;height: 370px;width: 70%;width:100%;overflow-y: scroll;">
		
				<table border="1" style="width: 100%;">
					<tr>
						<th>SPECIALITIES</th>
						<th>ACTIVE</th>
					</tr>

					<?php
						$status=0;
						$query4=mysql_query("select * from especialitats");
						while($row4=mysql_fetch_array($query4))
						{
							$status=$row4['activa'];
							$id= $row4['id'];
							
					?>
					<tr>
						<td><?php echo $row4['especialitat'];?></td>
						<td><input type="checkbox" name="checkbox" <?php if($status == 1){echo "checked='checked'";}?>></td>
					</tr>
						<?php
						}
						?>
				</table>
				
				</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
	
	<div id="myModal2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					
				<div style="width: 77%;border:1px solid black;height: 500px;">
				<table border="1" style="width: 100%;" id='maintable'>
					<tr >
						<th style="text-align: center;">PEROFESSIONAL </th>
						<th style="text-align: center;">SPECIALITY </th>
						
					</tr>
					<?php
					
					$query11=mysql_query("select * from doctor_info");
					while($row11=mysql_fetch_array($query11))
						{
						
					?>
					
					<tr>
						<td style="text-align: center;" contenteditable><?php echo $row11['doctor'];?></td>
						<td style="text-align: center;" contenteditable><?php echo $row11['speciality'];?></td>
					</tr>
					<?php
					}
					?>
						
				</table>
				</div>

				<div style="width: 200px;float: right;margin-top: -380px;height: 300px;">
				<input type="submit" data-toggle="modal" data-target="#myModal221" value="ADD" style="padding: 35px 45px;">
				 <!-- <input type="submit" data-id="ISBN564541" data-toggle="modal" value="MODIFY" style="padding: 35px;margin-top: 15px;"> -->
				
				<input type="text" name="hidden" style="display:none;" id="hiddenVal01"/>

				<!-- <input type="submit" data-id="ISBN-001122" data-toggle="modal" data-target="#myModal221" value="MODIFY" style="padding: 35px 45px;" class="open-AddBookDialog">-->
				<input type="button" data-toggle="modal" data-target="#myModal221" style="padding: 35px 36px;" id="submitFormData01" onclick="SubmitFormData01();" value="MODIFY" />
				
				<form method="POST">
				<input type="text" name="hidden" style="display:none;" id="hiddenVal" />
				<input type="submit" name="submit5" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 35px;">
				</form>
				</div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    </div>


<div id="myModal221" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
					<div id="results" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
		  <?php
		  
		  /*$html = '<div id="results01"></div>';
		  
		   $query90 = mysql_query("select * from  doctor_info where doctor = '$html'");
		   $row90=mysql_fetch_array($query90);
		   echo $row90['doctor'];
		   value="<?php if($row90) { echo $row90['doctor'];}?>"*/
		   
		   ?>
				<div style="width: 100%;">
				<form method="POST" action="configuration.php" id="myForm">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">DOCTOR :</th>
						<td><input type="text" name="doctor" style="width: 100%;" id="doctor" ></td>
					</tr>
					<tr>
						<th style="width: 121px;">SPECIALITY :</th>
						<td><select name="speciality1" id="speciality1">
							<?php
					
					$query9=mysql_query("select * from especialitats where activa = '1'");
					while($row9=mysql_fetch_array($query9))
						{
					?>
							<option value="<?php echo $row9['especialitat'];?>"><?php echo $row9['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
					</tr>
					<tr>
						<th style="width: 121px;">N'COLEGIADO :</th>
						<td><input type="text" name="ncdo" style="width: 100%;" id="ncdo"></td>
					</tr>
					<tr>
						<th style="width: 121px;">NIF :</th>
						<td ><input type="text" name="d_nif" style="width: 100%;" id="d_nif"></td>
					</tr>
					<tr>
						<th>ADDRESS :</th>
						<td><input type="text" name="d_add" style="width: 100%;" id="d_add"></td>
					</tr>
					<tr>
						<th>CIP :</th>
						<td><input type="text" name="d_cip" style="width: 100%;" id="d_cip"></td>
					</tr>
					<tr>
						<th>POPULATION :</th>
						<td><input type="text" name="d_population" style="width: 100%;" id="d_population"></td>
					</tr>
					<tr>
						<th>TELEPHONES :</th>
						<td><input type="text" name="d_phone" style="width: 100%;" id="d_phone"></td>
					</tr>
					<tr>
						<th>EMAILS :</th>
						<td><input type="text" name="d_email" style="width: 100%;" id="d_email"></td>
					</tr>
						
					<tr>
						
						<td colspan="2" style="text-align:center"><input type="button" id="submitFormData" onclick="SubmitFormData();" value="ADD" /></td>							
							
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					
				<div style="width: 77%;border:1px solid black;height: 500px;">
				<table border="1" style="width: 100%;" id='maintable2'>
					<tr>
						<th style="text-align: center;">FIRST NAME </th>
						<th style="text-align: center;">SPECIALITY </th>
						<th style="text-align: center;">PEROFESSIONAL </th>
						
					</tr>
					
						<?php
						$query21=mysql_query("select * from agendas_costcenters");
						while($row21=mysql_fetch_array($query21))
							{
						?>
					<tr>
						<td style="text-align: center;" contenteditable><?php echo $row21['fname'];?></td>
						<td style="text-align: center;" contenteditable><?php echo $row21['speciality'];?></td>
						<td style="text-align: center;" contenteditable><?php echo $row21['doctor'];?></td>
					</tr>
						<?php
							}
						?>
					
						
				</table>
				</div>
				
				<div style="width: 200px;float: right;margin-top: -380px;height: 300px;">
				<input type="submit" data-toggle="modal" data-target="#myModal31" value="ADD" style="padding: 35px 45px;">

				<input type="submit" value="MODIFY" style="padding: 35px;margin-top: 15px;">

				<form method="POST" action="">
				<input type="text" name="hidden2" style="display:none;" id="hiddenVal2">
				<input type="submit" name="submit10" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 35px;margin-top: 15px;">
				</form>
				</div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    </div>

<div id="myModal31" class="modal fade">
    <div class="modal-dialog" style="width: 750px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			<div id="results4" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;">
				<form method="POST" action="" id="myForm4">
				<table>
						<tr>
							<td>FIRSTNAME :</td>
							<td><input type="text" name="fname" id="fname" style="padding: 0px 119px 0px 0px;"></td>
						</tr>

							
						<tr>
							<td>SPECIALITY : </td>
							<td><select name="dropdown3" id="dropdown3" style="padding: 0px 119px 0px 0px;">
								<option value="select">SELECT</option>
								<?php
								
								$query14=mysql_query("select * from especialitats where activa = 1");
								
								while($row14=mysql_fetch_array($query14))
								{
								?>
								<option value="<?php echo $row14['especialitat'];?>"><?php echo $row14['especialitat'];?></option>
								<?php
								}
								?></select></td>
						</tr>
							
						<tr>
							<td>DOCTOR :</td>
							<td><select name="dropdown4" id="dropdown4" style="padding: 0px 173px 0px 0px;">
								<option value="select">SELECT</option>
								<?php
								
								$query17=mysql_query("select * from doctor_info");
								
								while($row17=mysql_fetch_array($query17))
								{
								?>
								<option value="<?php echo $row17['doctor'];?>"><?php echo $row17['doctor'];?></option>
								<?php
								}
								?></select></td>
						</tr>

						<tr>
							<td>PERCENTAGES :</td>
							<td>
								<table>
									<tr>
										<td>VISITS :</td>
										<td><input type="text" name="vst" id="vst"></td>

										<td>VAT :</td>
										<td><input type="text" name="vat" id="vat"></td>

									</tr>
									<tr>
										<td>PROCEDURE :</td>
										<td><input type="text" name="prc" id="prc"></td>

										<td>IRPF :</td>
										<td><input type="text" name="irpf" id="irpf"></td>

									</tr>
									<tr>
										<td>SURGERY :</td>
										<td><input type="text" name="sry" id="sry"></td>
									</tr>

									<tr>
										<td colspan="2" style="text-align:center;"><input type="checkbox" name="checkbox">  LOCKED AGENDA</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:center;"><input type="button" id="submitFormData4" onclick="SubmitFormData4();" value="RECORD" /></td>
									</tr>
								</table>
							</td>
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
    <div class="modal-dialog" style="width: 538px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality :</td>
							<td><select name="dropdown" onChange="getWard(this.value);">
								<option value="select">SELECT</option>
								<?php
								$query14=mysql_query("select * from especialitats where activa = 1");
								while($row14=mysql_fetch_array($query14))
								{
								?>
								<option value="<?php echo $row14['especialitat'];?>"><?php echo $row14['especialitat'];?></option>
								<?php
								}
								?></select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd1"><option value="">Select</option></select></td>
						</tr>
				</table>
				</div>
				
				<div  style="width: 400px;margin-left: 34px;margin-top: 15px;height: 400px;border: 1px solid black;">
				<table border="1" width="100%" id="maintable1">
						<tr>
							<th style="text-align: center;">DIAGNOSIS</th>
						</tr>

						<?php
							
						$query16=mysql_query("select * from diagnosis");
						while($row16=mysql_fetch_array($query16))
						{

					
						?>
						<tr>
							<td style="text-align: center;" contenteditable><?php echo $row16['diagnosis'];?></td>
						</tr>
						<?php

						}
						?>
				</table>
					
				</div>
				<div style="width: 400px;margin-left: 34px;margin-top: 10px;">
				<input type="submit" name="submit7" data-toggle="modal" data-target="#myModal41" value="ADD" style="margin-left: 30px;padding: 0px 25px;">
				<input type="submit" value="MODIFY" style="margin-left: 20px;padding: 0px 25px;">
				
				<form method="POST" style="margin-top: -23px;">
				<input type="text" name="hidden1" style="display:none;" id="hiddenVal1" />
				<input type="submit" name="submit8" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 253px;padding: 0px 25px;">
				</form>
				</div>
				
				
				
				
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>


<div id="myModal41" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results5" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm5">
						<table>
							<tr>
								<td>DIAGNOSIS :</td>
								<td ><input type="text" name="dia" id="dia"></td>
							</tr>

							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData5" onclick="SubmitFormData5();" value="INSERT" /></td>
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
	
	<div id="myModal5" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-toggle="modal" data-target="#myModals" style="font-size: 17px;">ACTIVE MUTUALS BY AGENDA</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
               
					
				<div style="width: 77%;border:1px solid black;height: 500px;overflow-y: scroll;overflow-x: scroll;">
				<table border="1" style="width: 100%;" id='maintable3'>
					<tr >
						<th style="text-align: center;">CHANGE</th>
						<th style="text-align: center;">GROUP</th>
						<th style="text-align: center;">CODI</th>
						<th style="text-align: center;">NIF</th>
						<th style="text-align: center;">ADDRESS</th>
						<th style="text-align: center;">POPULATION</th>
						<th style="text-align: center;">CIP</th>
						<th style="text-align: center;">TELEPHONE</th>
						<th style="text-align: center;">E-MAIL</th>
						<th style="text-align: center;">IRPF</th>
						
					</tr>

						<?php

						$query22=mysql_query("select * from origen_mutuas");
						while($row22=mysql_fetch_array($query22))
						{
						?>
					<tr>
						<td style="text-align: center;"><?php echo $row22['mutua'];?></td>

							<?php 
							$group=$row22['facturador'];

							$query23=mysql_query("select * from facturadores_origen where id='$group'");
							$row23=mysql_fetch_array($query23);
							?>
						<td style="text-align: center;"><?php echo $row23['nombre'];?></td>
						<td style="text-align: center;"><?php echo $row22['cod_facturador'];?></td>
						<td style="text-align: center;"><?php echo $row22['nif'];?></td>
						<td style="text-align: center;"><?php echo $row22['adre�a'];?></td>
						<td style="text-align: center;"><?php echo $row22['poblacio'];?></td>
						<td style="text-align: center;"><?php echo $row22['cipM'];?></td>
						<td style="text-align: center;"><?php echo $row22['telefonoM'];?></td>
						<td style="text-align: center;"><?php echo $row22['emailM'];?></td>
						<td style="text-align: center;"><?php echo $row22['retencion'];?></td>
					</tr>
					<?php } ?>
						
				</table>
				</div>
				
				<div style="width: 200px;float: right;margin-top: -380px;height: 300px;">
				<input type="submit" data-toggle="modal" data-target="#myModal51" value="ADD" style="padding: 35px 45px;">
				<input type="submit" value="MODIFY" style="padding: 35px;margin-top: 15px;">


				<form method="POST" action="">
				<input type="text" name="hidden3" style="display:none;" id="hiddenVal3">
				<input type="submit" name="submit12" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 35px;margin-top: 15px;">
				</form>
				</div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    </div>
<div id="myModal51" class="modal fade">
    <div class="modal-dialog" style="width: 600px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results6" style="width: 143px;margin-left: 175px;margin-top: -10px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm6">
				<table>
					<tr>
						<td>FIRST :</td>
						<td><input type="text" name="name" id="name" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>NIF :</td>
						<td><input type="text" name="nif" id="nif" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>ADDRESS :</td>
						<td><input type="text" name="add" id="add" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>CIP :</td>
						<td><input type="text" name="cip" id="cip" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>POPULATION :</td>
						<td><input type="text" name="population" id="population" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>TELEPHONE :</td>
						<td><input type="text" name="telephone" id="telephone" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>EMAIL :</td>
						<td><input type="text" name="email" id="email" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>% IRPF :</td>
						<td><input type="text" name="irpf" id="irpf" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>WEB URL :</td>
						<td><input type="text" name="url" id="url" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>BILING MACHINE :</td>
						<td><select name="bmachine" id="bmachine" style="padding: 0px 225px 0px 0;">
							<option value="select">SELECT</option>
							<?php
							$query24=mysql_query('select * from facturadores_origen');
							while($row24=mysql_fetch_array($query24))
							{
							?>
							<option value="<?php echo $row24['nombre'];?>"><?php echo $row24['nombre'];?></option>
							<?php } ?>
							</select></td>
					</tr>
					<tr>
						<td>BILL CODE :</td>
						<td><input type="text" name="code" id="code" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData6" onclick="SubmitFormData6();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

	
	<div id="myModal6" class="modal fade">
    <div class="modal-dialog" style="width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">LIST OF ACTIVE MUTUAS</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;width:63%;height: 125px;">
				
				<input type="radio" style="margin-left: 12px;margin: 20px;" name="gender"  checked> CREDITS FOR ANY AGENDA<br>
				<input type="radio" style="margin-left: 12px;margin: 20px;" name="gender" > CREDITS FOR A SPECIFIC AGENDA<br> 
				</div>
	
				<div style="margin-top: 25px;">
					How Many Credits dp you want to buy? <input type="text">
				</div>
				<div style="margin-top: 15px;">
					<input type="checkbox" >  I AUTHORIZED THE INVOICING OF ACCREDITED CREDITS
				</div>
				<div style="margin-top: 15px;margin-left: 175px;"><input type="submit" style="padding: 7px;" value="TO BUY">
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal7" class="modal fade">
    <div class="modal-dialog" style="width: 385px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results7" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm7">
				<table>
					<tr>
						<td>CURRENT KEY :</td>
						<td><input type="password" name="ckey" id="ckey"></td>
					</tr>
					<tr>
						<td>NEW KEY :</td>
						<td><input type="password" name="nkey" id="nkey"></td>
					</tr>
					<tr>
						<td>CONFIRM NEW KEY :</td>
						<td><input type="password" name="cnkey" id="cnkey"></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData7" onclick="SubmitFormData7();" value="UPDATE" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
	
	<div id="myModals" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">LIST OF ACTIVE MUTUAS</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;width:90%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown">
								<?php

						$query00=mysql_query("select * from especialitats where activa='1'");
						while($row00=mysql_fetch_array($query00))
							{
						?>
							<option value="<?php echo $row00['especialitat'];?>"><?php echo $row00['especialitat'];?></option>
							<?php
							}
							?></select>
							</td>
							<td>Diary : </td>
							<td><select name="dropdown1"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div  style="width: 430px;margin-left: 34px;margin-top: 15px;height: 400px;border: 1px solid black;overflow-y: scroll;overflow-x: scroll;">
				<table border="1" width="600px">
						<tr>
							<th style="text-align: center;">CHANGE</th>
							<th style="text-align: center;">ACTIVE</th>
							<th style="text-align: center;">USUARI_WEB</th>
						</tr>
						
						<?php

						$query001=mysql_query("select * from origen_mutuas");
						while($row001=mysql_fetch_array($query001))
						{
						?>
						<tr>
							<td style="text-align: center;"><?php echo $row001['mutua'];?></td>
							<td style="text-align: center;"><input type="checkbox" checked></td>
							<td style="text-align: center;"></td>
						</tr>
						<?php } ?>
				</table>
					
				</div>
				<div style="width: 135px;margin-top: -235px;float: right;">
				<input type="submit" value="MODIFY" style="margin-left: 20px;padding: 7px 25px;">
				</div>
				
				
				
				
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    </div>



<div id="myModal8" class="modal fade">
    <div class="modal-dialog" style="width: 672px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
					
				<table>
					<tr>
						<td>CURRENT KEY :</td>

						<?php 
							$query1=mysql_query("select * from login where user = '$abc'");
							$row1=mysql_fetch_array($query1);
						
							
						?>
						<td><input type="text" value="<?php echo $row1['role'];?>"></td>
		
						<td colspan="2"  style="text-align: center;width: 300px;"><input type="submit" data-toggle="modal" data-target="#myModal111" value="CREATE USER">
</td>

					
					</tr>
				</table>
				</div> 
				
				<div style="margin: 50px;border: 1px solid black;width: 360px;height: 200px;">
				<table border="1" width="100%">
					<tr >
						<th style="text-align: center;">USER </th>
					</tr>
					
					<tr>
						<td style="text-align: center;"><?php echo $abc;?></td>
					</tr>
				</table>
				</div>
				<div style="float: right;margin-top: -100px;margin-right: 145px;"><input type="submit" onclick="myFunction()" value="CLEAR USER"></div>

				<script>
function myFunction() {
    alert("YOU CAN NOT ELIMINATE YOUR SELF");
}
</script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal111" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results8" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm">

						<table>
							<tr>
								<td>SELECT ROLE :</td>
								<td><select name="role" id="role">
									<option value="SUPERVISOR">SUPERVISOR</option>
									<option value="DOCTOR">DOCTOR</option>
									<option value="ADMINISTRATIVE">ADMINISTRATIVE</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>CENTER :</td>
								<td><input type="text" name="user" id="user"></td>
							</tr>
							<tr>
								<td>USER :</td>
								<td><input type="text" name="key" id="key"></td>
							</tr>
							<tr>
								<td>KEY RESOURCE :</td>
								<td><input type="password" name="rkey" id="rkey"></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData" onclick="SubmitFormData8();" value="INSERT" /></td>
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

						<div class="configraton-rates-header">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">RATES</a></td>
							</tr>
						</table>
						</div>
						<div class="configraton-rates">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal9">VISITS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal10">PROCEDURE IN CONSULTATIONS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal11">SURGICAL ACTS</a></th>
										</tr>
									</table>
						</div>
						
						<div id="myModal9" class="modal fade">
    <div class="modal-dialog" style="width: 723px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-toggle="modal" data-target="#myModals1" style="font-size: 17px;">REFITING VISITS</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;width:73%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" onChange="getWard2(this.value);">
								<?php

						$query28=mysql_query("select * from especialitats where activa='1'");
						while($row28=mysql_fetch_array($query28))
							{
						?>
							<option value="<?php echo $row28['especialitat'];?>"><?php echo $row28['especialitat'];?></option>
							<?php
							}
							?></select>
							</td>
							
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd2"><option value="">SELECT</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="float: right;width: 150px;margin-top: -32px;"><input type="checkbox"> PRIVATE</div>
				
				<div style="margin-top: 20px;overflow-x: scroll;overflow-y: scroll;border: 1px solid black;height: 400px;">
				<table border="1" style="width: 125%;">
						<tr>
							<th>CHANGE</th>
							<th>1st VISIT</th>
							<th>2nd VISIT</th>
							<th>URGENT</th>
						</tr>
						<?php

						$query27=mysql_query('select * from origen_mutuas');
						while($row27=mysql_fetch_array($query27))
							{
						?>
						<tr>
							<td><?php echo $row27['mutua'];?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php
 							}
						?>
				</table>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModals1" class="modal fade">
    <div class="modal-dialog" style="width: 300px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-toggle="modal" data-target="#myModals1" style="font-size: 17px;">REFITING VISITS</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				
				
				<b >SINCE :</b> <input type="text" name="date"> </br></br>
				
				<b >UNTIL :</b> <input type="text" name="date1"> </br></br>
				
				<input type="submit" value="OKAY" style="margin-left: 80px;padding: 12px;">
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal10" class="modal fade">
    <div class="modal-dialog" style="width: 800px !important;">
        <div class="modal-content">
            <div class="modal-header">
					<li><a href="#" data-toggle="modal" style="font-size: 17px;">LISTED BY MUTUAS AND RATES</a>
					<li><a href="#" data-toggle="modal" data-target="#myModals2" style="font-size: 17px;">REFURBISH PROCEDURES</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;width:73%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" onChange="getWard3(this.value);">
								<?php

						$query29=mysql_query("select * from especialitats where activa='1'");
						while($row29=mysql_fetch_array($query29))
							{
						?>
							<option value="<?php echo $row29['especialitat'];?>"><?php echo $row29['especialitat'];?></option>
							<?php
							}
							?></select>
							</td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd3"><option value="">SELECT</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="float: right;width: 250px;margin-top: 5px;margin-right: 204px;">
						MUTUAS : <select name="dropdown" style="width: 180px;" id='brand'>
											<?php

						$query30=mysql_query("select * from procedure_in_consultations");
						while($row30=mysql_fetch_array($query30))
							{
						?>
						<option value="<?php echo $row30['mutuas'];?>"><?php echo $row30['mutuas'];?></option>
							<?php } ?>
								</select>
				</div>
				
				<div style="margin-top: 45px;overflow-x: scroll;overflow-y: scroll;border: 1px solid black;height: 400px;width: 618px;">
				<table border="1" style="width: 125%;" id="maintable17">
						<tr>
							<th>PROCESS</th>
							<th>CODE</th>
							<th>RATE</th>

						</tr>
						<?php

						$query83=mysql_query("select * from  procedure_in_consultations");
						while($row83=mysql_fetch_array($query83))
							{
						?>
		

						<tr>
							<td><?php echo $row83['process'];?></td>
							<td><?php echo $row83['code'];?></td>
							<td><?php echo $row83['rate'];?></td>
						</tr>
						
							<?php } ?>
				</table>
				</div>
				
				<div style="float: right;width: 130px;margin-top: -300px;height: 280px;">
					<input type="submit" data-toggle="modal" data-target="#myModal101"  value="ADD" style="padding: 20px 49px;"></br>
					<input type="submit" value="MODIFY" style="padding: 20px 40px;margin-top: 15px;"></br>
					

					
					<form method="POST" action="">
				<input type="text" name="hidden17" style="display:none;" id="hiddenVal17">
				<input type="submit" name="submit41" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 20px 40px;margin-top: 15px;">
				</form>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal101" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results9" style="width: 143px;margin-left: 175px;color: green;font-weight: bold;"></div>
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="configuration.php" id="myForm9">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">MUTUAS :</th>
						<td colspan="3"><select name="mutuas" id="mutuas" style="width: 100%;">
							<?php

						$query81=mysql_query("select * from origen_mutuas");
						while($row81=mysql_fetch_array($query81))
							{
						?>
						<option value="<?php echo $row81['mutua'];?>"><?php echo $row81['mutua'];?></option>
						
							<?php } ?>
								</select> </td>
					</tr>
					<tr>
						<th style="width: 150px;">PROCESS :</th>
						<td colspan="3"><input type="text" name="process" id="process" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">CODE :</th>
						<td colspan="3"><input type="text" name="codep" id="codep" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">RATE :</th>
						<td colspan="3"><input type="text" name="rate" id="rate" style="width: 100%;" ></td>
					</tr>
						
					<tr>
						
						<td colspan="4" style="text-align:center"><input type="button" id="submitFormData9" onclick="SubmitFormData9();" value="ADD" /></td>							
							
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

<div id="myModals2" class="modal fade">
    <div class="modal-dialog" style="width: 300px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-toggle="modal" data-target="#myModals1" style="font-size: 17px;">REFITING VISITS</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				
				
				<b >SINCE :</b> <input type="text" name="date"> </br></br>
				
				<b >UNTIL :</b> <input type="text" name="date1"> </br></br>
				
				<input type="submit" value="OKAY" style="margin-left: 80px;padding: 12px;">
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal11" class="modal fade">
    <div class="modal-dialog" style="width: 800px !important;">
        <div class="modal-content">
            <div class="modal-header">
					<li><a href="#" data-toggle="modal" style="font-size: 17px;">LISTED BY MUTUAS AND RATES</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<div style="border:1px solid black;width:73%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="dropdown" onChange="getWard4(this.value);">
								<?php

						$query000=mysql_query("select * from especialitats where activa='1'");
						while($row000=mysql_fetch_array($query000))
							{
						?>
							<option value="<?php echo $row000['especialitat'];?>"><?php echo $row000['especialitat'];?></option>
							<?php
							}
							?></select>
							</td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd4"><option value="z"></option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="float: right;width: 250px;margin-top: 5px;margin-right: 204px;">
						MUTUAS : <select name="dropdown" style="width: 180px;"><?php

						$query85=mysql_query("select * from origen_mutuas");
						while($row85=mysql_fetch_array($query85))
							{
						?>
						<option value="<?php echo $row85['mutua'];?>"><?php echo $row85['mutua'];?></option>
						
							<?php } ?></select></div>
				
				<div style="margin-top: 45px;overflow-x: scroll;overflow-y: scroll;border: 1px solid black;height: 400px;width: 618px;">
				<table border="1" style="width: 125%;" id="maintable18">
						<tr>
							<th>PROCESS</th>
							<th>CODE</th>
							<th>RATE</th>
						</tr>
						<?php

						$query88=mysql_query("select * from surgical_acts");
						while($row88=mysql_fetch_array($query88))
							{
							?>
						<tr>
							<td><?php echo $row88['process'];?></td>
							<td><?php echo $row88['code'];?></td>
							<td><?php echo $row88['rate'];?></td>
						</tr>
							<?php } ?>
				</table>
				</div>
				
				<div style="float: right;width: 130px;margin-top: -300px;height: 280px;">
					<input type="submit" data-toggle="modal" data-target="#myModal000" value="ADD" style="padding: 20px 40px;"></br>
					<input type="submit" value="MODIFY" style="padding: 20px 40px;margin-top: 15px;"></br>
					
					
					
					<form method="POST" action="">
				<input type="text" name="hidden18" style="display:none;" id="hiddenVal18">
				<input type="submit" name="submit43" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 20px 40px;margin-top: 15px;">
				</form>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal000" class="modal fade">
    <div class="modal-dialog" style="width: 555px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-target="#myModal" style="font-size: 17px;">TO PRINT</a>
				<div id="results10" style="width: 143px;margin-left: 175px;margin-top: -21px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
           
					
				<div style="width: 100%;">
				<form method="POST" action="" id="myForm10">
					
				<table style="width: 100%;">
					<tr>
						<th style="width: 121px;">MUTUAS :</th>
						<td colspan="3"><select name="mutuas1" id="mutuas1" style="width: 100%;">
							<?php

						$query86=mysql_query("select * from origen_mutuas");
						while($row86=mysql_fetch_array($query86))
							{
						?>
						<option value="<?php echo $row86['mutua'];?>"><?php echo $row86['mutua'];?></option>
						
							<?php } ?>
								</select> </td>
					</tr>
					<tr>
						<th style="width: 150px;">PROCESS :</th>
						<td colspan="3"><input type="text" name="process1" id="process1" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">CODE :</th>
						<td colspan="3"><input type="text" name="code1" id="code1" style="width: 100%;"></td>
					</tr>
					<tr>
						<th style="width: 121px;">RATE :</th>
						<td colspan="3"><input type="text" name="rate1" id="rate1" style="width: 100%;" ></td>
					</tr>
						
					<tr>
						
						<td colspan="4" style="text-align:center"><input type="button" id="submitFormData10" onclick="SubmitFormData10();" value="ADD" /></td>							
							
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

<div id="myModals2" class="modal fade">
    <div class="modal-dialog" style="width: 300px !important;">
        <div class="modal-content">
            <div class="modal-header">
				
					<li><a href="#" data-toggle="modal" data-target="#myModals1" style="font-size: 17px;">REFITING VISITS</a>
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				
				
				<b >SINCE :</b> <input type="text" name="date"> </br></br>
				
				<b >UNTIL :</b> <input type="text" name="date1"> </br></br>
				
				<input type="submit" value="OKAY" style="margin-left: 80px;padding: 12px;">
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
						
						
						<div class="configration-accont">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">ACCOUNTING</a></td>
							</tr>
						</table>
						</div>
						<div class="configration-accont1">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal12">SALES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal13">INCOME CONCEPTS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal141">CONCEPTS OF EXPENSES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal14">INVOICE TEMPLATE</a></th>
										</tr>
									</table>
						</div>
						
<div id="myModal12" class="modal fade">
    <div class="modal-dialog" style="width: 600px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				
				<div style="margin-top: 45px;overflow-x: scroll;overflow-y: scroll;border: 1px solid black;height: 200px;">
				<table border="1" style="width: 125%;" id="maintable4">
						<tr>
							<th>FIRST NAME</th>
							<th>NIF</th>
							<th>SALARY</th>
							<th>RETENTION</th>
						</tr>
						
						<?php
						$query33=mysql_query("select * from sales");
						while($row33=mysql_fetch_array($query33))
							{
						?>
						<tr>
							<td><?php echo $row33['s_name'];?></td>
							<td><?php echo $row33['s_nif'];?></td>
							<td><?php echo $row33['salary'];?></td>
							<td><?php echo $row33['%_irpf'];?></td>
						</tr>
						<?php } ?>
				</table>
				</div>
				
				<div >
					<input type="submit" data-toggle="modal" data-target="#myModal121" value="ADD" style="padding: 20px 40px;margin-left: 82px;">

					<input type="submit" value="MODIFY" style="padding: 20px 40px;margin-top: 15px;">

					<form method="POST" action="" style="width: 136px;float: right;margin-right: 52px;">
					<input type="text" name="hidden4" style="display:none;" id="hiddenVal4">
					<input type="submit" name="submit14" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 20px 40px;margin-top: 15px;">
					</form>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal121" class="modal fade">
    <div class="modal-dialog" style="width: 600px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results11" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm11">
				<table>
					<tr>
						<td>FIRST NAME:</td>
						<td><input type="text" name="name1" id="name1" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>ADDRESS :</td>
						<td><input type="text" name="add" id="add" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>NIF :</td>
						<td><input type="text" name="nif" id="nif" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>% IRPF WITHDRAWAL :</td>
						<td><input type="text" name="irpf" id="irpf" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>SALARY :</td>
						<td><input type="text" name="salary" id="salary" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData11" onclick="SubmitFormData11();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div id="myModal13" class="modal fade">
    <div class="modal-dialog" style="width: 700px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onchange="getWard5(this.value)">
							<?php
					
					$query9=mysql_query("select * from especialitats where activa = '1'");
					while($row9=mysql_fetch_array($query9))
						{
					?>
							<option value="<?php echo $row9['especialitat'];?>"><?php echo $row9['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" style="width: 170px;" id="wrd5"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="margin-top: 25px;border: 1px solid black;height: 200px;width: 500px;margin-left: 78px;height: 400px;">
				<table border="1" width="100%" heigh="100%" id="maintable5">
						<tr>
							<th style="text-align: center;">CONCEPT</th>

						</tr>
						
						<?php

						$query35=mysql_query("select * from income_concept");
						while($row35=mysql_fetch_array($query35))
						{
						?>
						
						<tr>
							<td style="text-align: center;"><?php echo $row35['concept'];?></td>
						</tr>
						<?php
						}
						?>
				</table>
				</div>
				
				<div style="width: 500px;margin-left: 78px;margin-top: 15px;">
					<input type="submit" data-toggle="modal" data-target="#myModal132" value="ADD" style="padding: 2px 40px;margin-left: 60px;">

					<input type="submit" value="MODIFY" style="padding: 2px 40px;margin-left: 5px;">

					<form method="POST" action="" style="width: 142px;float: right;margin-right: 33px;">
					<input type="text" name="hidden5" style="display:none;" id="hiddenVal5">
					<input type="submit" name="submit16" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 2px 40px;margin-left: 5px;">
					</form>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal132" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results12" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm12">

						<table>
							<tr>
								<td>INCOME CONCEPT :</td>
								<td ><input type="text" name="inc" id="inc"></td>
							</tr>

							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData12" onclick="SubmitFormData12();" value="INSERT" />
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal141" class="modal fade">
    <div class="modal-dialog" style="width: 700px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onchange="getWard6(this.value)">
							<?php
					
					$query37=mysql_query("select * from especialitats where activa = '1'");
					while($row37=mysql_fetch_array($query37))
						{
					?>
							<option value="<?php echo $row37['especialitat'];?>"><?php echo $row37['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" style="width: 170px;" id="wrd6"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="margin-top: 25px;border: 1px solid black;height: 200px;width: 500px;margin-left: 78px;height: 400px;">
				<table border="1" width="100%" heigh="100%" id="maintable6">
						<tr>
							<th style="text-align: center;">CONCEPT</th>

						</tr>
						
						<?php

						$query38=mysql_query("select * from concept_of_expenses");
						while($row38=mysql_fetch_array($query38))
						{
						?>
						
						<tr>
							<td style="text-align: center;"><?php echo $row38['concept'];?></td>
						</tr>
						<?php
						}
						?>
				</table>
				</div>
				
				<div style="width: 500px;margin-left: 78px;margin-top: 15px;">
					<input type="submit" data-toggle="modal" data-target="#myModal142" value="ADD" style="padding: 2px 40px;margin-left: 60px;">

					<input type="submit" value="MODIFY" style="padding: 2px 40px;margin-left: 5px;">

					<form method="POST" action="" style="width: 142px;float: right;margin-right: 39px;">
					<input type="text" name="hidden6" style="display:none;" id="hiddenVal6">
					<input type="submit" name="submit18" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="padding: 2px 40px;margin-left: 5px;">
					</form>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal142" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results13" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm13">

						<table>
							<tr>
								<td>CONCEPT :</td>
								<td ><input type="text" name="inc" id="inc1"></td>
							</tr>

							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData13" onclick="SubmitFormData13();" value="INSERT" /></td>
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal14" class="modal fade">
    <div class="modal-dialog" style="width: 700px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results14" style="width: 143px;margin-top: -5px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
				<form method="POST" action="" id="myForm14">
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality3" id="speciality3">
							<?php
					
					$query9=mysql_query("select * from especialitats where activa = '1'");
					while($row9=mysql_fetch_array($query9))
						{
					        ?>
							<option value="<?php echo $row9['especialitat'];?>"><?php echo $row9['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="musicalinfluences" id="musicalinfluences"></textarea>
						<script type="text/javascript">
			CKEDITOR.replace( 'musicalinfluences', {
				fullPage: false,
				allowedContent: true,
		 });
			
</script></td>
						</tr>

					<tr>
						<td colspan="2" style="text-align:center;"><input type="button" id="submitFormData14" onclick="SubmitFormData14();" value="ADD" /> </td>
					</tr>
						
				</table>
				</form>
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
					
	
						<div class="configration-agenda">
						<table style="width: 100%;background-color: #c1d8f0;">
							<tr>
								<td><img src="img/d.png">AGENDA PARAMETERS</a></td>
							</tr>
						</table>
						</div>
						<div class="configration-agenda1">
									<table border="1" style="background-color: white;width:100%">
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal15">SCHEDULE</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal16">LOCKED DATES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal17">RECIPES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal18">PETITIONS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal19">SETTINGS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal20">HELP</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal21">CLINICS</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal22">REPORT TEMPLATE</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal23">BILLING MACHINES</a></th>
										</tr>
										<tr>
											<th style="text-align: center;padding: 0px;"><a href="#" data-toggle="modal" data-target="#myModal24">CONCENT</a></th>
										</tr>
									</table>
						</div>
						
						<div id="myModal15" class="modal fade">
    <div class="modal-dialog" style="width: 550px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality3" onChange="getWard7(this.value)">
							<?php
					
					$query9=mysql_query("select * from especialitats where activa = '1'");
					while($row9=mysql_fetch_array($query9))
						{
					?>
							<option value="<?php echo $row9['especialitat'];?>"><?php echo $row9['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd7"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="float: right;border: 1px solid black;margin-top: 15px;width: 225px;height: 400px;">
					<table border="1" width="100%">
						<tr>
							<th style="text-align: center;">HOUR</th>
						</tr>
						
						<tr>
							<td style="text-align: center;">asd</td>
						</tr>
					</table>
				</div>
				
				<div style="border: 1px solid black;width: 222px;margin-top: 80px;">
				<input type="radio" style="margin: 18px 0px 0px 19px;" name="gender"  checked> MONDAY<br>
				<input type="radio" style="margin: 18px 0px 0px 19px;" name="gender" > TUESDAY<br> 
				<input type="radio" style="margin: 18px 0px 0px 19px;" name="gender" > WEDNESDAY<br>
				<input type="radio" style="margin: 18px 0px 0px 19px;" name="gender" > THURSDAY<br>
				<input type="radio" style="margin: 18px 0px 0px 19px;" name="gender"  > FRIDAY<br>
				<input type="radio" style="margin: 18px 0px 0px 19px;" name="gender" > SATURDAY<br>
				<input type="radio" style="margin: 18px 0px 13px 19px;" name="gender"  > SUNDAY<br> 
				</div>
				
				<div style="margin-top: 10px;margin-left: 40px;width: 123px;">
					<input type="submit" style="padding: 15px;" value="SET INTERVAL">
				</div>
				
				<div style="float: right;margin-top: 15px;margin-right: -110px;">
					<input type="submit" value="DELETE">
				</div>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal17" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard8(this.value)">
							<?php
					
					$query41=mysql_query("select * from especialitats where activa = '1'");
					while($row41=mysql_fetch_array($query41))
						{
					?>
							<option value="<?php echo $row41['especialitat'];?>"><?php echo $row41['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd8"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="margin-top: 15px;">
						
					<b>PATHOLOGY :</b> <select name="speciality4" style="width: 310px;">
								<?php
									
								$query52=mysql_query("select * from pathology");
								while($row52=mysql_fetch_array($query52))
								{
								?>
								<option value="<?php echo $row52['pathology'];?>"><?php echo $row52['pathology'];?></option>

								<?php
								}
								?>
								</select>
					<input type="submit" data-toggle="modal" data-target="#myModal171" value="SET UP" style="padding: 4px 30px;margin-left: 20px;">
					
				</div>
				
				<div style="border: 1px solid black;height: 363px;overflow-x: auto;margin-top:15px">
				<table border="1" width="111%" id="maintable9">
					<tr>
						<th> TREATMENT </th>
						<th> POSOLOGY </th>
						<th> UNITS </th>
						<th> PATTERN </th>
					</tr>
					
					<?php
					$query51=mysql_query("select * from recipes");
					while($row51=mysql_fetch_array($query51))
					{

					?>
					<tr>
						<td><?php echo $row51['treatment'];?></td>
						<td><?php echo $row51['posology'];?></td>
						<td><?php echo $row51['units'];?></td>
						<td><?php echo $row51['pattern'];?></td>
					</tr>
					<?php
					}
					?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal172" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">

				
				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

					
				
				<form method="POST" action="" style="width: 142px;float: right;margin-right: 95px;">
					<input type="text" name="hidden9" style="display:none;" id="hiddenVal9">
					<input type="submit" name="submit25" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
					</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal172" class="modal fade">
    <div class="modal-dialog" style="width: 510px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results15" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm15">
				<table>
					<tr>
						<td>TREATMENT :</td>
						<td><input type="text" name="treatment" id="treatment" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>POSOLOGY :</td>
						<td><input type="text" name="posology" id="posology" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>UNITS :</td>
						<td><input type="text" name="units" id="units" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>PATTERN :</td>
						<td><input type="text" name="pattern" id="pattern" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData15" onclick="SubmitFormData15();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal171" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1">
							<?php
					
					$query41=mysql_query("select * from especialitats where activa = '1'");
					while($row41=mysql_fetch_array($query41))
						{
					?>
							<option value="<?php echo $row41['especialitat'];?>"><?php echo $row41['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="border: 1px solid black;height: 363px;overflow-x: auto;margin-top:15px">
				<table border="1" width="111%" id="maintable7">
					<tr>
						<th> PATHOLOGY </th>
					</tr>
					<?php 
					$query44=mysql_query("select * from pathology");
					while($row44=mysql_fetch_array($query44))
					{
					?>
					<tr>
						<td><?php echo $row44['pathology'];?></td>
					</tr>
					<?php
				
					}
					?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal173" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">

				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

				<form method="POST" action="" style="width: 142px;float: right;margin-right: 95px;">
					<input type="text" name="hidden7" style="display:none;" id="hiddenVal7">
					<input type="submit" name="submit21" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
					</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal173" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
				<div id="results16" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="" id="myForm16">
						<table>
							<tr>
								<td>PATHOLOGY :</td>
								<td ><input type="text" name="pat" id="pat"></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData16" onclick="SubmitFormData16();" value="INSERT" /></td>
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal18" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard10(this.value)">
							<?php
					
					$query45=mysql_query("select * from especialitats where activa = '1'");
					while($row45=mysql_fetch_array($query45))
						{
					?>
							<option value="<?php echo $row45['especialitat'];?>"><?php echo $row45['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd10"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="margin-top: 15px;">
					<b>DEPARTMENT :</b> <select name="speciality4" style="width: 310px;">
								<?php
									
								$query53=mysql_query("select * from department");
								while($row53=mysql_fetch_array($query53))
								{
								?>
								<option value="<?php echo $row53['department'];?>"><?php echo $row53['department'];?></option>

								<?php
								}
								?>
								</select>
					<input type="submit" style="padding: 4px 30px;margin-left: 20px;float: right;margin-top: -33px;" data-toggle="modal" data-target="#myModal181" value="CONFIGURATION" style="padding: 4px 30px;margin-left: 20px;">
				</div>
				
				<div style="border: 1px solid black;height: 363px;overflow-x: auto;margin-top:15px">
				<table border="1" width="111%" id="maintable10">
					<tr>
						<th> PROOF </th>
					</tr>
					<?php
									
								$query56=mysql_query("select * from proof");
								while($row56=mysql_fetch_array($query56))
								{
								?>
						
					<tr>
						<td><?php echo $row56['proof'];?></td>
						
					</tr>
							<?php } ?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal183" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">

				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">


				<form method="POST" action="" style="width: 142px;float: right;margin-right: 95px;">
					<input type="text" name="hidden10" style="display:none;" id="hiddenVal10">
					<input type="submit" name="submit27"  onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
					</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal181" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard11(this.value)">
							<?php
					
					$query41=mysql_query("select * from especialitats where activa = '1'");
					while($row41=mysql_fetch_array($query41))
						{
					?>
							<option value="<?php echo $row41['especialitat'];?>"><?php echo $row41['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd11"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="border: 1px solid black;height: 363px;overflow-x: auto;margin-top:15px">
				<table border="1" width="111%" id="maintable8">
					<tr>
						<th> Department </th>
					</tr>
					<?php 
					$query47=mysql_query("select * from department");
					while($row47=mysql_fetch_array($query47))
					{
					?>
					<tr>
						<td><?php echo $row47['department'];?></td>
					</tr>
					<?php
				
					}
					?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal182" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">

				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

				<form method="POST" action="" style="width: 142px;float: right;margin-right: 95px;">
					<input type="text" name="hidden8" style="display:none;" id="hiddenVal8">
					<input type="submit" name="submit23" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
					</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal182" class="modal fade">
    <div class="modal-dialog" style="width: 380px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results17" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php" id="myForm17">

						<table>
							<tr>
								<td>DEPARTMENT :</td>
								<td ><input type="text" name="dep" id="dep"></td>
							</tr>

							<tr>
								<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData17" onclick="SubmitFormData17();" value="ADD" /></td>
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal183" class="modal fade">
    <div class="modal-dialog" style="width: 354px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

					<form method="POST" action="configuration.php">

						<table>
							<tr>
								<td>PROOF :</td>
								<td ><input type="text" name="proof"></td>
							</tr>

							<tr>
								<td colspan="2" style="text-align: center;"><input type="submit" name="submit26" value="INSERT">
							</tr>

						</table>
						</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal19" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table align="center">
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1">
							<?php
					
					$query57=mysql_query("select * from especialitats where activa = '1'");
					while($row57=mysql_fetch_array($query57))
						{
					?>
							<option value="<?php echo $row57['especialitat'];?>"><?php echo $row57['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							
						</tr>
				</table>
				</div>
				
				<div style="border: 1px solid black;height: 363px;margin-top:15px">
				<table border="1" width="100%" id="maintable11">
					<tr>
						<th> PARAMETERE </th>
						<th> FRACTION </th>
						<th> RATIO </th>
						<th> MULTIPLE </th>
					</tr>
					<?php
					
					$query59=mysql_query("select * from settings");
					while($row59=mysql_fetch_array($query59))
						{
					?>
					<tr>
						<td><?php echo $row59['parameter'];?></td>
						<td><?php echo $row59['fraction'];?></td>
						<td><?php echo $row59['ratio'];?></td>
						<td><?php echo $row59['multiople'];?></td>
						
					</tr>
					<?php } ?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal191" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">
				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

				<form method="POST" action="" style="width: 142px;float: right;margin-right: 95px;">
					<input type="text" name="hidden11" style="display:none;" id="hiddenVal11">
					<input type="submit" name="submit29" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
					</form>
				
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal191" class="modal fade">
    <div class="modal-dialog" style="width: 600px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results18" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">

				 <script type="text/javascript">
    function ShowHideDiv(checkbox) {
        var dvPassport = document.getElementById("frc");
        dvPassport.style.display = checkbox.checked ? "block" : "none";

		var dvPassport1 = document.getElementById("frc1");
        dvPassport1.style.display = checkbox.checked ? "block" : "none";

		var dvPassport2 = document.getElementById("ratio");
        dvPassport2.style.display = checkbox.checked ? "block" : "none";

		var dvPassport3 = document.getElementById("ratio1");
        dvPassport3.style.display = checkbox.checked ? "block" : "none";
    }
</script>
				<form method="POST" action="configuration.php" id="myForm18">
				<table>
					<tr>
						<td colspan="2" style="text-align:center;"><input type="checkbox" name="checkbox" id="checkbox" value="multiple" onclick="ShowHideDiv(this)"> MULTIPLE </td>
					</tr>
					<tr>
						<td>PARAMETER :</td>
						<td><input type="text" name="parameter" id="parameter" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td id="frc" style="display:none;">FRACTION :</td>
						<td><input type="text" name="fraction" style="padding: 0px 177px 0px 0px;display: none;" id="frc1" ></td>
					</tr>
					<tr>
						<td id="ratio" style="display:none;">RATIO :</td>
						<td><input type="text" name="ratio" style="padding: 0px 177px 0px 0px;display: none;" id="ratio1" ></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData18" onclick="SubmitFormData18();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal20" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard12(this.value)">
							<?php
					
					$query61=mysql_query("select * from especialitats where activa = '1'");
					while($row61=mysql_fetch_array($query61))
						{
					?>
							<option value="<?php echo $row61['especialitat'];?>"><?php echo $row61['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd12"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="border: 1px solid black;height: 280px;margin-top:15px">
				<table border="1" width="100%" id="maintable12">
					<tr>
						<th> FIRST NAME </th>
						<th> NIF </th>
						<th> COMP.M </th>
						<th> COMP.P </th>
						<th> RETENTION </th>
					</tr>
					<?php
					
					$query64=mysql_query("select * from help");
					while($row64=mysql_fetch_array($query64))
						{
					?>
					<tr>
						<td><?php echo $row64['fname'];?></td>
						<td><?php echo $row64['nif'];?></td>
						<td><?php echo $row64['compm'];?></td>
						<td><?php echo $row64['compp'];?></td>
						<td><?php echo $row64['retention'];?></td>
						
					</tr>
					<?php } ?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal201" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">

				
				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">


				

				<form method="POST" action="" style="width: 241px;float: right;">
				<input type="text" name="hidden12" style="display:none;" id="hiddenVal12">
				<input type="submit" name="submit31" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
				</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal201" class="modal fade">
    <div class="modal-dialog" style="width: 608px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results19" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm19">
				<table>
					<tr>
						<td>FIRST NAME :</td>
						<td><input type="text" name="fname" id="fname1" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>ADDRESS :</td>
						<td><input type="text" name="address" id="address" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>NIF :</td>
						<td><input type="text" name="nif" id="nif" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>% IN QX SHARES OF MUTUAS :</td>
						<td><input type="text" name="mshare" id="mshare" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>% IN QX PRIVATE SHARES :</td>
						<td><input type="text" name="pshare" id="pshare" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td>RETENTION :</td>
						<td><input type="text" name="retention" id="retention" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData19" onclick="SubmitFormData19();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal21" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard13(this.value)">
							<?php
					
					$query65=mysql_query("select * from especialitats where activa = '1'");
					while($row65=mysql_fetch_array($query65))
						{
					?>
							<option value="<?php echo $row65['especialitat'];?>"><?php echo $row65['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td><select name="dropdown1" id="wrd13"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
			
				<div style="border: 1px solid black;height: 280px;margin-top:15px">
				<table border="1" width="100%" id="maintable13">
					<tr>
						<th> CLINIC </th>
						
					</tr>
					
					<?php
					
					$query68=mysql_query("select * from clinic");
					while($row68=mysql_fetch_array($query68))
						{
					?>
					<tr>
						<td><?php echo $row68['clinic'];?></td>
						
					</tr>
					<?php } ?>
	
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal211" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">
				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

					
				

				<form method="POST" action="" style="width: 241px;float: right;">
				<input type="text" name="hidden13" style="display:none;" id="hiddenVal13">
				<input type="submit" name="submit33" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
				</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal211" class="modal fade">
    <div class="modal-dialog" style="width: 476px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results20" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm20">
				<table>
					<tr>
						<td>CLINIC :</td>
						<td><input type="text" name="clinic" id="clinic" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData20" onclick="SubmitFormData20();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal22" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard14(this.value)">
							<?php
					
					$query69=mysql_query("select * from especialitats where activa = '1'");
					while($row69=mysql_fetch_array($query69))
						{
					?>
							<option value="<?php echo $row69['especialitat'];?>"><?php echo $row69['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd14"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
			
				<div style="border: 1px solid black;height: 280px;margin-top:15px">
				<table border="1" width="100%" id="maintable14">
					<tr>
						<th> TITLE </th>
						
					</tr>
					
						<?php
					
					$query71=mysql_query("select * from title");
					while($row71=mysql_fetch_array($query71))
						{
					?>
					<tr>
						<td><?php echo $row71['title'];?></td>
						
					</tr>
			
					<?php } ?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal222" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">

				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

				
	
				<form method="POST" action="" style="width: 233px;float: right;">
				<input type="text" name="hidden14" style="display:none;" id="hiddenVal14">
				<input type="submit" name="submit35" value="REMOVE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
				</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal222" class="modal fade">
    <div class="modal-dialog" style="width: 476px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results21" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm21">
				<table>
					<tr>
						<td>TITLE :</td>
						<td><input type="text" name="title" id="title" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr >
						<td colspan="2" style="text-align: center;"><input type="button" id="submitFormData21" onclick="SubmitFormData21();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal23" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:100%;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard15(this.value)">
							<?php
					
					$query73=mysql_query("select * from especialitats where activa = '1'");
					while($row73=mysql_fetch_array($query73))
						{
					?>
							<option value="<?php echo $row73['especialitat'];?>"><?php echo $row73['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd15"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
			
				<div style="border: 1px solid black;height: 280px;margin-top:15px;overflow-x: auto;">
				<table border="1" width="111%" id="maintable15">
					<tr>
						<th> BILING MACHINE </th>
						<th> TERMINAL </th>
						<th> USER </th>
						<th> COD.PROF </th>
						<th> COD.SPEC. </th>
						
					</tr>
					<?php
					
					$query76=mysql_query("select * from billing_machines");
					while($row76=mysql_fetch_array($query76))
						{
					?>
					
					<tr>
						<td><?php echo $row76['billing'];?></td>
						<td><?php echo $row76['terminal'];?></td>
						<td><?php echo $row76['user'];?></td>
						<td><?php echo $row76['profetional'];?></td>
						<td><?php echo $row76['speciality'];?></td>
						
					</tr>

					<?php } ?>
				</table>
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal231" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">
				<input type="submit" value="MODIFY" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">

				<form method="POST" action="" style="width: 233px;float: right;">
				<input type="text" name="hidden15" style="display:none;" id="hiddenVal15">
				<input type="submit" name="submit37" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
				</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal231" class="modal fade">
    <div class="modal-dialog" style="width: 522px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results22" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm22">
				<table>
					<tr>
							<td>BILLING : </td>
							<td><select name="speciality5" id="speciality5" style="padding: 0px 226px 0px 0px;">
							<?php
					
					$query74=mysql_query("select * from facturadores_origen");
					while($row74=mysql_fetch_array($query74))
						{
					?>
							<option value="<?php echo $row74['nombre'];?>"><?php echo $row74['nombre'];?></option>
						<?php
						}
						?>
								</select></td>
					<tr>
						<td>TERMINAL :</td>
						<td><input type="text" name="terminal" id="terminal" style="padding: 0px 177px 0px 0px;"></td>
					</tr>

					<tr>
						<td>USER :</td>
						<td><input type="text" name="user" id="user" style="padding: 0px 177px 0px 0px;"></td>
					</tr>

					<tr>
						<td>KEY :</td>
						<td><input type="password" name="key" id="key" style="padding: 0px 177px 0px 0px;"></td>
					</tr>

					<tr>
						<td>PROFETIONAL :</td>
						<td><input type="text" name="profetional" id="profetional" style="padding: 0px 177px 0px 0px;"></td>
					</tr>

					<tr>
						<td>SPECIALITY :</td>
						<td><input type="text" name="speciality" id="speciality" style="padding: 0px 177px 0px 0px;"></td>
					</tr>
					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData22" onclick="SubmitFormData22();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal24" class="modal fade">
    <div class="modal-dialog" style="width: 650px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="width:100%;">
					<b>NEW CONSENT :</b>
				</div>
			
				<div style="border: 1px solid black;height: 280px;margin-top:15px;overflow-x: auto;">
					<table border="1" width="111%" id="maintable16">
					<tr>
						<th> PROCESS NAME </th>
						
					</tr>
					<?php
					
					$query79=mysql_query("select * from concent");
					while($row79=mysql_fetch_array($query79))
						{
					?>
					
					<tr>
						<td><?php echo $row79['process'];?></td>
						
					</tr>

					<?php } ?>
				</table>
				
				</div>
				
				<div >
				<input type="submit" data-toggle="modal" data-target="#myModal241" value="ADD" style="margin-left: 95px;margin-top: 15px;padding: 0px 30px;">
				
				<input type="submit" value="EDIT" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">


				
				<form method="POST" action="" style="width: 250px;float: right;">
				<input type="text" name="hidden16" style="display:none;" id="hiddenVal16">
				<input type="submit" name="submit39" onclick="return confirm('Are you sure you want to delete this item?');" value="DELETE" style="margin-left: 35px;margin-top: 15px;padding: 0px 30px;">
				</form>
				</div>

				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="myModal241" class="modal fade">
    <div class="modal-dialog" style="width: 718px !important;">
        <div class="modal-content">
            <div class="modal-header">
			<div id="results23" style="width: 143px;color: green;font-weight: bold;"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
				<form method="POST" action="configuration.php" id="myForm23">
				<table>
					<tr>
						<td>PROCESS :</td>
						<td><input type="text" name="process" id="process2" style="padding: 0px 177px 0px 0px;"></td>
					</tr>

					<tr>
						<td colspan="2">EXPLANATION OF THE PROCEDURE :</td>
					</tr>
					<tr>
						<td colspan="2"><textarea name="procedure" id="procedure" rows="3" cols="100"></textarea></td>
					</tr>

					<tr>
						<td colspan="2">GENERAL RISKS THAT COMPORTS :</td>
					</tr>
					<tr>
						<td colspan="2"><textarea name="comports" id="comports" rows="3" cols="100"></textarea></td>
					</tr>
					
					<tr>
						<td colspan="2">ALTERNATIVES :</td>
					</tr>
					<tr>
						<td colspan="2"><textarea name="alternatives" id="alternatives" rows="3" cols="100"></textarea></td>
					</tr>

					<tr>
						<td colspan="2">EXPANDING INFORMATION :</td>
					</tr>
					<tr>
						<td colspan="2"><textarea name="information" id="information" rows="3" cols="100"></textarea></td>
					</tr>

					<tr >
						<td colspan="2"  style="text-align: center;"><input type="button" id="submitFormData23" onclick="SubmitFormData23();" value="INSERT" /></td>
					</tr>
				</table>
				</form>
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div id="myModal16" class="modal fade">
    <div class="modal-dialog" style="width: 970px !important;">
        <div class="modal-content">
            <div class="modal-header">
			
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
            </div>
            <div class="modal-body">
			
			<div style="border:1px solid black;width:51%;margin-left: 206px;">
					
				<table>
						<tr>
							<td>Speciality : </td>
							<td><select name="speciality1" onChange="getWard9(this.value)">
							<?php
					
					$query003=mysql_query("select * from especialitats where activa = '1'");
					while($row003=mysql_fetch_array($query003))
						{
					?>
							<option value="<?php echo $row003['especialitat'];?>"><?php echo $row003['especialitat'];?></option>
						<?php
						}
						?>
								</select></td>
							<td>Diary : </td>
							<td><select name="dropdown1" id="wrd9"><option value="dr.aiaz">DR.AIAZ</option></select></td>
						</tr>
				</table>
				</div>
				
				<div style="width: 175px;margin-top: 15px;float: right;height: 390px;border:1px solid black;">
				<table border="1" width="100%">
					<tr>
						<th style="text-align: center;">HOURS EXPECTED</th>
					</tr>
					
					<tr>
						<td style="text-align: center;">sd</td>	
					</tr>
				</table>
				</div>
				
				<div style="float: right;margin-top: 15px;width: 195px;margin-right: 7px;height: 390px;border: 1px solid black;">
				<table border="1" width="100%">
					<tr>
						<th style="text-align: center;">HOURS LOCKED</th>
					</tr>
					
					<tr>
						<td style="text-align: center;">dsfdsfds</td>	
					</tr>
				</table>
				</div>
				<div style="width:215px;height: 180px;margin-top: 15px;margin-left: 300px;"">
  
        <div id="embeddedExample" style="width: 200px;margin-left: 12px;">
          <div id="embeddedCalendar" style="margin-left: auto; margin-right: auto">
          </div>
        </div>
      </div>
				
				<div style="border: 1px solid black;width: 300px;margin-top:10px;height: 390px;margin-top: -180px;">
				<table border="1" width="100%">
					<tr>
						<th style="text-align: center;">DATE</th>
						<th style="text-align: center;">REASON</th>	
					</tr>
					
					<tr>
						<td style="text-align: center;">sd</td>
						<td style="text-align: center;">ghf</td>	
					</tr>
				</table>
					
				</div>
				<div style="width: 115px;height: 55px;margin-top: 15px;margin-left: 85px;"><input type="submit" style="padding: 12px;" value="UNLOCK DATE"></div>
				
				<div style="width: 115px;height: 55px;margin-top: -55px;margin-right: 222px;float: right;"><input type="submit" style="padding: 12px;" value="UNLOCK DATE"></div>

				<div style="width: 115px;height: 55px;margin-top: -55px;margin-right: 40px;float: right;"><input type="submit" style="padding: 12px;" value="UNLOCK DATE"></div>
				
				</div> 
        </div>
        <!-- /.modal-content -->
    </div>
	
    <!-- /.modal-dialog -->
</div>

					</div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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

function getWard7(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd7").html(data);
		}
	});
}

function getWard8(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd8").html(data);
		}
	});
}

function getWard9(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd9").html(data);
		}
	});
}

function getWard10(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd10").html(data);
		}
	});
}

function getWard11(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd11").html(data);
		}
	});
}

function getWard12(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd12").html(data);
		}
	});
}

function getWard13(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd13").html(data);
		}
	});
}

function getWard14(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd14").html(data);
		}
	});
}

function getWard15(val) 
{
	$.ajax
	({
	type:"POST",
	url:"Get_Ward.php",
	data:'nam='+val,
		success: function(data)
		{
		$("#wrd15").html(data);
		}
	});
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<script language="javascript"><!--
//<![CDATA[
$("#maintable tr").click(function(){

    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal").value = value;
		document.getElementById("hiddenVal01").value = value;
    }
});

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
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal5").value = value;
		
    }
});

$("#maintable6 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal6").value = value;
		
    }
});

$("#maintable7 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal7").value = value;
		
    }
});

$("#maintable8 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal8").value = value;
		
    }
});


$("#maintable9 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal9").value = value;
		
    }
});

$("#maintable10 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal10").value = value;
		
    }
});

$("#maintable11 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal11").value = value;
		
    }
});

$("#maintable12 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal12").value = value;
		
    }
});

$("#maintable13 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal13").value = value;
		
    }
});

$("#maintable14 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal14").value = value;
		
    }
});

$("#maintable15 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal15").value = value;
		
    }
});

$("#maintable16 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal16").value = value;
		
    }
});

$("#maintable17 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal17").value = value;
		
    }
});

$("#maintable18 tr").click(function(){
    //alert($(this).hasClass("selected"));
    if ($(this).hasClass("selected")){
        $(this).removeClass("selected");
    }else{
        $(this).addClass("selected").siblings().removeClass("selected");
		var value=$(this).find('td:first').html();
		
		document.getElementById("hiddenVal18").value = value;
		
    }
});
//]]>
--></script>


<script>
$(document).on("click", ".open-AddBookDialog", function () {
     var myBookId = $(this).data('id');
     $(".modal-body #bookId").val( myBookId );
});
</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/submit.js"></script>

<script>
function SubmitFormData() {
    var doctor = $("#doctor").val();
    var speciality1 = $("#speciality1").val();
    var ncdo = $("#ncdo").val();
	var d_nif = $("#d_nif").val();
	var d_add = $("#d_add").val();
	var d_cip = $("#d_cip").val();
	var d_population = $("#d_population").val();
	var d_phone = $("#d_phone").val();
	var d_email = $("#d_email").val();

    $.post("insertdata.php", { doctor: doctor, speciality1: speciality1, ncdo: ncdo, d_nif: d_nif, d_add: d_add, d_cip: d_cip, d_population: d_population, d_phone: d_phone, d_email: d_email },
    function(data) {
	 $('#results').html(data);
	 $('#myForm')[0].reset();
    });
}

function SubmitFormData2() {
   var noc = $("#noc").val();
    var nif = $("#nif").val();
    var responsable = $("#responsable").val();
	var add = $("#add").val();
	var cip = $("#cip").val();
	var population = $("#population").val();
	var phone = $("#phone").val();

    $.post("insertdata.php", { noc: noc, nif: nif, responsable: responsable, add: add, cip: cip, population: population, phone: phone },
    function(data) {
	 $('#results1').html(data);
	 $('#myForm1')[0].reset();
    });
}

function SubmitFormData1() {
    var noc1 = $("#noc").val();
    var nif1 = $("#nif").val();
    var responsable1 = $("#responsable").val();
	var add1 = $("#add").val();
	var cip1 = $("#cip").val();
	var population1 = $("#population").val();
	var phone1 = $("#phone").val();
	
    $.post("insertdata.php", { noc1: noc1, nif1: nif1, responsable1: responsable1, add1: add1, cip1: cip1, population1: population1, phone1: phone1 },
    function(data) {
	 $('#results2').html(data);
	 $('#myForm2')[0].reset();
    });
}

function SubmitFormData3() {
	
    var role1 = $("#role1").val();
    var speciality2 = $("#speciality2").val();
alert(speciality2);
	
    $.post("insertdata.php", { role1: role1, speciality2: speciality2 },
    function(data) {
	 $('#results3').html(data);
	 $('#myForm3')[0].reset();
    });
}

function SubmitFormData4() {
    var fname = $("#fname").val();
    var dropdown3 = $("#dropdown3").val();
    var dropdown4 = $("#dropdown4").val();
	var vst = $("#vst").val();
	var vat = $("#vat").val();
	var prc = $("#prc").val();
	var irpf = $("#irpf").val();
	var sry = $("#sry").val();
	
    $.post("insertdata.php", { fname: fname, dropdown3: dropdown3, dropdown4: dropdown4, vst: vst, vat: vat, prc: prc, irpf: irpf, sry: sry},
    function(data) {
	 $('#results4').html(data);
	 $('#myForm4')[0].reset();
    });
}

function SubmitFormData5() {
    var dia = $("#dia").val();
	
    $.post("insertdata.php", { dia: dia },
    function(data) {
	 $('#results5').html(data);
	 $('#myForm5')[0].reset();
    });
}

function SubmitFormData6() {
    var name = $("#name").val();
    var nif = $("#nif").val();
    var add = $("#add").val();
	var cip = $("#cip").val();
	var population = $("#population").val();
	var telephone = $("#telephone").val();
	var email = $("#email").val();
	var irpf = $("#irpf").val();
	var url = $("#url").val();
	var bmachine = $("#bmachine").val();
	var code = $("#code").val();
	
    $.post("insertdata.php", { name: name, nif: nif, add: add, cip: cip, population: population, telephone: telephone, email: email, irpf: irpf, url: url, bmachine: bmachine, code: code},
    function(data) {
	 $('#results6').html(data);
	 $('#myForm6')[0].reset();
    });
}

function SubmitFormData7() {
    var ckey = $("#ckey").val();
    var nkey = $("#nkey").val();
    var cnkey = $("#cnkey").val();
	
    $.post("insertdata.php", { ckey: ckey, nkey: nkey, cnkey: cnkey },
    function(data) {
	 $('#results7').html(data);
	 $('#myForm7')[0].reset();
    });
}

function SubmitFormData8() {
    var role = $("#role").val();
    var user = $("#user").val();
    var key = $("#key").val();
	var rkey = $("#rkey").val();
	
    $.post("insertdata.php", { role: role, user: user, key: key, rkey: rkey },
    function(data) {
	 $('#results8').html(data);
	 $('#myForm8')[0].reset();
    });
}

function SubmitFormData9() {
	
    var mutuas = $("#mutuas").val();
    var process = $("#process").val();
    var codep = $("#codep").val();
	var rate = $("#rate").val();
	
    $.post("insertdata.php", { mutuas: mutuas, process: process, codep: codep, rate: rate },
    function(data) {
	 $('#results9').html(data);
	 $('#myForm9')[0].reset();
    });
}

function SubmitFormData10() {
	
    var mutuas1 = $("#mutuas1").val();
    var process1 = $("#process1").val();
    var code1 = $("#code1").val();
	var rate1 = $("#rate1").val();

    $.post("insertdata.php", { mutuas1: mutuas1, process1: process1, code1: code1, rate1: rate1 },
    function(data) {
	 $('#results10').html(data);
	 $('#myForm10')[0].reset();
    });
}

function SubmitFormData11() {
	
    var name1 = $("#name1").val();
    var nif = $("#nif").val();
    var add = $("#add").val();
	var irpf = $("#irpf").val();
	var salary = $("#salary").val();

    $.post("insertdata.php", { name1: name1, nif: nif, add: add, irpf: irpf, salary: salary },
    function(data) {
	 $('#results11').html(data);
	 $('#myForm11')[0].reset();
    });
}

function SubmitFormData12() {
	
    var inc = $("#inc").val();

    $.post("insertdata.php", { inc: inc },
    function(data) {
	 $('#results12').html(data);
	 $('#myForm12')[0].reset();
    });
}

function SubmitFormData13() {
	
    var inc1 = $("#inc1").val();

    $.post("insertdata.php", { inc1: inc1 },
    function(data) {
	 $('#results13').html(data);
	 $('#myForm13')[0].reset();
    });
}

function SubmitFormData14() {
	
    var speciality3 = $("#speciality3").val();
	var musicalinfluences = $("#musicalinfluences").val();

    $.post("insertdata.php", { speciality3: speciality3, musicalinfluences: musicalinfluences },
    function(data) {
	 $('#results14').html(data);
	 $('#myForm14')[0].reset();
    });
}

function SubmitFormData15() {
	
    var treatment = $("#treatment").val();
	var posology = $("#posology").val();
	 var units = $("#units").val();
	var pattern = $("#pattern").val();

    $.post("insertdata.php", { treatment: treatment, posology: posology, units: units, pattern: pattern },
    function(data) {
	 $('#results15').html(data);
	 $('#myForm15')[0].reset();
    });
}

function SubmitFormData16() {
	
    var pat = $("#pat").val();

    $.post("insertdata.php", { pat: pat },
    function(data) {
	 $('#results16').html(data);
	 $('#myForm16')[0].reset();
    });
}

function SubmitFormData17() {
	
    var dep = $("#dep").val();

    $.post("insertdata.php", { dep: dep },
    function(data) {
	 $('#results17').html(data);
	 $('#myForm17')[0].reset();
    });
}

function SubmitFormData18() {
	
    var parameter = $("#parameter").val();
	var fraction = $("#frc1").val();
	var ratio = $("#ratio1").val();
	var checkbox = $("#checkbox").val();

    $.post("insertdata.php", { parameter: parameter, fraction: fraction, ratio: ratio, checkbox: checkbox },
    function(data) {
	 $('#results18').html(data);
	 $('#myForm18')[0].reset();
    });
}

function SubmitFormData19() {
	
    var fname1 = $("#fname1").val();
	var address = $("#address").val();
	var nif = $("#nif").val();
	var mshare = $("#mshare").val();
	var pshare = $("#pshare").val();
	var retention = $("#retention").val();


    $.post("insertdata.php", { fname1: fname1, address: address, nif: nif, mshare: mshare, pshare: pshare, retention: retention },
    function(data) {
	 $('#results19').html(data);
	 $('#myForm19')[0].reset();
    });
}

function SubmitFormData20() {
	
    var clinic = $("#clinic").val();

    $.post("insertdata.php", { clinic: clinic },
    function(data) {
	 $('#results20').html(data);
	 $('#myForm20')[0].reset();
    });
}

function SubmitFormData21() {
	
    var title = $("#title").val();

    $.post("insertdata.php", { title: title },
    function(data) {
	 $('#results21').html(data);
	 $('#myForm21')[0].reset();
    });
}

function SubmitFormData22() {
	
    var speciality5 = $("#speciality5").val();
	var terminal = $("#terminal").val();
	var user = $("#user").val();
	var key = $("#key").val();
	var profetional = $("#profetional").val();
	var speciality = $("#speciality").val();

    $.post("insertdata.php", { speciality5: speciality5, terminal: terminal, user: user, key: key, profetional: profetional, speciality: speciality },
    function(data) {
	 $('#results22').html(data);
	 $('#myForm22')[0].reset();
    });
}

function SubmitFormData23() {
	
    var process2 = $("#process2").val();
	var procedure = $("#procedure").val();
	var comports = $("#comports").val();
	var alternatives = $("#alternatives").val();
	var information = $("#information").val();

    $.post("insertdata.php", { process2: process2, procedure: procedure, comports: comports, alternatives: alternatives, information: information },
    function(data) {
	 $('#results23').html(data);
	 $('#myForm23')[0].reset();
    });
}

function SubmitFormData01() {
	
    var hiddenVal01 = $("#hiddenVal01").val();
	
    $.post("insertdata.php", { hiddenVal01: hiddenVal01 },
    function(data) {
		$('#results01').html(data);
		 $('#myForm01')[0].reset();
    });
}
</script>

</body>
</html>

