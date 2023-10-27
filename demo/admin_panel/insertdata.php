<style>
#maintable1 {border-collapse:collapse;}

    #maintable1 tr:hover {background-color: #FFFFAA;}

    #maintable1 tr.selected td {
        background: none repeat scroll 0 0 #FFCF8B;
        color: #000000;
}
</style>

<?php
@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);
session_start();

if( isset( $_POST['doctor'] ) )
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



//$insertdata=" INSERT INTO user_info VALUES( '$name','$age','$course' ) ";
$query10="insert into doctor_info values('','$doctor','$speciality','$ncdo','$nif','$add','$cip','$population','$phones','$emails')";
$row10 = mysql_query($query10);
if($row10)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['noc'] ) )
{
	
		$noc=$_POST['noc'];
		$nif=$_POST['nif'];
		$responsable=$_POST['responsable'];
		$add=$_POST['add'];
		$cip=$_POST['cip'];
		$population=$_POST['population'];
		$phones=$_POST['phone'];
		
		$abc=$_SESSION['user'];
		$query6=mysql_query("select * from login where user = '$abc'");
		$row6=mysql_fetch_array($query6);

		$login_id=$row6['id'];

		$query5="insert into medical_info values('','$login_id','$noc','$nif','$responsable','$add','$cip','$population','$phones')";
		$row5=mysql_query($query5);
		
		if($row5)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['noc1'] ) )
{
	
		$noc=$_POST['noc1'];
		$nif=$_POST['nif1'];
		$responsable=$_POST['responsable1'];
		$add=$_POST['add1'];
		$cip=$_POST['cip1'];
		$population=$_POST['population1'];
		$phones=$_POST['phone1'];
		
		$abc=$_SESSION['user'];
		$query6=mysql_query("select * from login where user = '$abc'");
		$row6=mysql_fetch_array($query6);

		$login_id=$row6['id'];
		
		$query8=mysql_query("UPDATE medical_info SET noc='$noc',nif='$nif',	responsable	='$responsable',address ='$add',cip='$cip',population='$population',phones='$phones' WHERE login_id = '$login_id'");
		
		if($query8)
	{
        echo "Successfully Updated";
	}
	else
	{
	echo "Not Updated";
	}
}

if( isset( $_POST['role1'] ) )
{
	$role=$_POST['role1'];
	$status=$_POST['speciality2'];


		if($status == 'ACTIVE')
		{
		$query14=mysql_query("UPDATE especialitats SET activa = '1' where especialitat = '$role'");
		}
		else if($status == 'DEACTIVE')
		{
		$query14=mysql_query("UPDATE especialitats SET activa = '0' where especialitat = '$role'");
		}
		
		if($query14)
	{
 echo "Successfully Updated";
	}
	else
	{
	echo "Not Updated";
	}
		
}

if( isset( $_POST['fname'] ) )
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
			
			if($row20)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['dia'] ) )
{
		$diagnosis=$_POST['dia'];

		$query15="insert into diagnosis value('','$diagnosis')";
		$row15=mysql_query($query15);
		
		if($row15)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
		
}

if( isset( $_POST['name'] ) )
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
		
		if($row25)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}		

if( isset( $_POST['ckey'] ) )
{
		$ckey=$_POST['ckey'];
		$nkey=$_POST['nkey'];
		$cnkey=$_POST['cnkey'];

		$abc=$_SESSION['user'];
		$query2=mysql_query("select * from login where password = '$ckey' AND user = '$abc'");
		$row2=mysql_fetch_array($query2);

		if($row2 == 0)
			{
				echo "Please Check Your Current Key";
			}
		else 
			{
				if($nkey == $cnkey)
				{
				$id=$row2['id'];
				$query3=mysql_query("UPDATE login SET password = '$cnkey' where id='$id' AND user = '$abc'");
				
				if($query3 == 1)
					{
				echo "Updated Successfully";
					}
					else
					{
							echo "Not Updated";
					}
				}
				else
				{
				echo "Your New Key Could Not Match";
				}
			}
}

if( isset( $_POST['role'] ) )
{
	$role=$_POST['role'];
	$user=$_POST['user'];
	$key=$_POST['key'];
	$rkey=$_POST['rkey'];

	$query="INSERT INTO login values('','$role','$user','$key','$rkey')";
	$row=mysql_query($query);
	
	if($row)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['mutuas'] ) )
{
		$mutuas=$_POST['mutuas'];
		$process=$_POST['process'];
		$codep=$_POST['codep'];
		$rate=$_POST['rate'];
		
		$query82="insert into procedure_in_consultations value('','$mutuas','$process','$codep','$rate')";
		$row82=mysql_query($query82);
		
		if($row82)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['mutuas1'] ) )
{
		$mutuas1=$_POST['mutuas1'];
		$process1=$_POST['process1'];
		$code1=$_POST['code1'];
		$rate1=$_POST['rate1'];
		
		$query82="insert into surgical_acts value('','$mutuas1','$process1','$code1','$rate1')";
		$row82=mysql_query($query82);
		
		if($row82)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['name1'] ) )
{
		$name1=$_POST['name1'];
		$nif=$_POST['nif'];
		$add=$_POST['add'];
		$irpf=$_POST['irpf'];
		$salary=$_POST['salary'];

		$query31="insert into sales values('','$name1','$add','$nif','irpf','$salary')";
		$row31=mysql_query($query31);
		
		if($row31)
	{
 echo "Successfully Inserted";
	}
	else
	{
	echo "Not Inserted";
	}
}

if( isset( $_POST['inc'] ) )
{
	$concept=$_POST['inc'];

		$query34="insert into income_concept value('','$concept')";
		$row34=mysql_query($query34);
		
		if($row34)
			{
		echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['inc1'] ) )
{

	$concept=$_POST['inc1'];

		$query36="insert into concept_of_expenses value('','$concept')";
		$row36=mysql_query($query36);
		
		if($row36)
			{
		echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
		
}

if( isset( $_POST['speciality3'] ) )
{
		$speciality=$_POST['speciality3'];
		$musicalinfluences=$_POST['musicalinfluences'];

		$query40="insert into invoice_template value('','$speciality','$musicalinfluences')";
		$row40=mysql_query($query40);
		
		if($row40)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
		
}

if( isset( $_POST['treatment'] ) )
{
		$treatment=$_POST['treatment'];
		$posology=$_POST['posology'];
		$units=$_POST['units'];
		$pattern=$_POST['pattern'];

		$query49="insert into recipes value('','$treatment','$posology','$units','$pattern')";
		$row49=mysql_query($query49);
		
		if($row49)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
		
}

if( isset( $_POST['pat'] ) )
{
		$pat=$_POST['pat'];

		$query42="insert into pathology value('','$pat')";
		$row42=mysql_query($query42);
		
		if($row42)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
		
}

if( isset( $_POST['dep'] ) )
{
	$dep=$_POST['dep'];

		$query46="insert into department value('','$dep')";
		$row46=mysql_query($query46);
		
		if($row46)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['parameter'] ) )
{
		$parameter=$_POST['parameter'];
		$fraction=$_POST['fraction'];
		$ratio=$_POST['ratio'];
		$checkbox= $_POST['checkbox'];

		$query58="insert into settings value('','$parameter','$fraction','$ratio','$checkbox')";
		$row58=mysql_query($query58);
		
		if($row58)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['fname1'] ) )
{
		$fname1=$_POST['fname1'];
		$address=$_POST['address'];
		$nif=$_POST['nif'];
		$mshare= $_POST['mshare'];
		$pshare= $_POST['pshare'];
		$retention= $_POST['retention'];

		$query62="insert into help value('','$fname1','$address','$nif','$mshare','$pshare','$retention')";
		$row62=mysql_query($query62);
		
		if($row62)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['clinic'] ) )
{
	$clinic=$_POST['clinic'];

		$query66="insert into clinic value('','$clinic')";
		$row66=mysql_query($query66);
		
		if($row66)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['title'] ) )
{
$title=$_POST['title'];

		$query70="insert into title value('','$title')";
		$row70=mysql_query($query70);
		
		if($row70)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['speciality5'] ) )
{
	$billing=$_POST['speciality5'];
		$terminal=$_POST['terminal'];
		$user=$_POST['user'];
		$key=$_POST['key'];
		$profetional=$_POST['profetional'];
		$speciality=$_POST['speciality'];

		$query75="insert into billing_machines value('','$billing','$terminal','$user','$key','$profetional','$speciality')";
		$row75=mysql_query($query75);
		
		if($row75)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['process2'] ) )
{
		$process2=$_POST['process2'];
		$procedure=$_POST['procedure'];
		$comports=$_POST['comports'];
		$alternatives=$_POST['alternatives'];
		$information=$_POST['information'];

		$query78="insert into concent value('','$process2','$procedure','$comports','$alternatives','$information')";
		$row78=mysql_query($query78);
		
		if($row78)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['fdate'] ) )
{
	$factdate=$_POST['fdate'];
	$cobaldate=$_POST['cdate'];
	$concept=$_POST['concept'];
	$observation=$_POST['observation'];
	$amount=$_POST['amount'];
	$irpf=$_POST['irpf'];
	$net=$_POST['net'];

	$query24="insert into other_income values('','$factdate','$cobaldate','$concept','$observation','$amount','$irpf','$net')";
	$row24=mysql_query($query24);
	
	if($row24)
			{
				echo '<div style="border:1px solid black;height: 300px;width: 100%;overflow-y: scroll;">
				<table border="1" style="width: 100%;" id="maintable1">
					<tr>
						<th>FACT_DATE</th>
						<th>CONCEPT</th>
						<th>AMOUNT</th>
						<th>DATE_COBRO</th>
					</tr>';

					$query4=mysql_query("select * from other_income");
								
								while($row4=mysql_fetch_array($query4))
								{
				echo '<tr>
						<td contenteditable>'.$row4['fdate'].'</td>
						<td contenteditable>'.$row4['concept'].'</td>
						<td contenteditable>'.$row4['amount'].'</td>
						<td contenteditable>'.$row4['cdate'].'</td>
					</tr>';
							}
				echo '</table>
				</div>';
			}
			else
			{
			echo "Not Inserted";
			}
	
}

if( isset( $_POST['date'] ) )
{
	$date=$_POST['date'];
	$concept1=$_POST['concept1'];
	$amount=$_POST['amount'];
	$vat=$_POST['vat'];
	$total=$_POST['total'];

	$query4="insert into expenses values('','$date','$concept1','$amount','$vat','','$total')";
	$row4=mysql_query($query4);
	
	if($row4)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}
if( isset( $_POST['idate'] ) )
{
	$idate=$_POST['idate'];
	$inumber=$_POST['inumber'];
	$irpf=$_POST['irpf'];

	$query18="insert into bills_issued values('','$idate','$inumber','$irpf')";
	$row18=mysql_query($query18);
	
	if($row18)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['dated'] ) )
{
	$dated=$_POST['dated'];
	$expercise=$_POST['expercise'];
	$ammount=$_POST['ammount'];

	$query20="insert into banking_transaction values('','$dated','$expercise','$ammount')";
	$row20=mysql_query($query20);
	
	if($row20)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['fname2'] ) )
{
	$fname=$_POST['fname2'];
	$amount=$_POST['amount'];
	$retention=$_POST['retention'];
	$dpage=$_POST['dpage'];

	$query50="insert into payment_of_salaries values('','$fname','$amount','$retention','$dpage')";
	$row50=mysql_query($query50);
	
	if($row50)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['fname3'] ) )
{
	$fname=$_POST['fname3'];
	$date7=$_POST['date7'];
	$fac=$_POST['fac'];
	$irpf=$_POST['irpf'];
	$amount12=$_POST['amount12'];
	$retention23=$_POST['retention23'];
	$net=$_POST['net'];

	$query9="insert into payment_help values('','$fname','$date7','$fac','$irpf','$amount12','$retention23','$net')";
	$row9=mysql_query($query9);
	
	if($row9)
			{
			echo "Successfully Inserted";
			}
			else
			{
			echo "Not Inserted";
			}
}

if( isset( $_POST['psname'] ) )
{
	$timepicker1= $_POST['timepicker1'];
	$psname = $_POST['psname'];
        $psname1= $_POST['psname1'];
        $pfname = $_POST['pfname'];
	$pdni = $_POST['pdni'];
	$pbdate = $_POST['pbdate'];
	$dropdown4 = $_POST['dropdown4'];
	$pdoa = $_POST['pdoa'];
	$responsable = $_POST['responsable'];
	$pdiagnosis = $_POST['pdiagnosis'];
	$ptriatge = $_POST['ptriatge'];
	$pbox = $_POST['pbox'];
	$vtype = $_POST['vtype'];
	$paddress = $_POST['paddress'];
	$ppopulation = $_POST['ppopulation'];
	$ppostalcode = $_POST['ppostalcode'];
	$ptelephone = $_POST['ptelephone'];
	$psms = $_POST['psms'];
	$pradio = $_POST['pradio'];
	$prole1 = $_POST['prole1'];
	$pnote = $_POST['pnote'];

	$date= date("m/d/Y");

	$query00="insert into patient_add values('','$timepicker1','$date','$psname','$psname1','$pfname','$pdni','$pbdate','$dropdown4','$pdoa','$responsable','$pdiagnosis','$ptriatge','$pbox','$vtype','$paddress','$ppopulation','$ppostalcode','$ptelephone','$psms','$pradio','$prole1','$pnote')";
	$row00=mysql_query($query00);
	
	if($row00)
			{

			echo '<div style="height:434px;border: 1px solid black;overflow-y: scroll;" >
				<table border="1" width="100%" id="maintable1" >
					<tr>
						<th>HOUR</th>
						<th>FIRST NAME</th>
						<th>CHANGE</th>
						<th>CONCEPT</th>
						<th>FORZ</th>
						<th>TELEPHONE</th>
						<th>CONF.</th>
					</tr>';
								

								$querys=mysql_query("select * from patient_add");
								
								while($rows=mysql_fetch_array($querys))
								{
								
				echo '	<tr>
						<td contenteditable>'.$rows['time'].'</td>
						<td contenteditable>'.$rows['first_name'].'</td>
						<td contenteditable>'.$rows['p_catagery'].'</td>
						<td contenteditable>'.$rows['vtype'].'</td>
						<td contenteditable>NO</td>
						<td contenteditable>'.$rows['telephone'].'</td>
						<td contenteditable></td>
					</tr>';


}
			echo	'</table>
				</div>';
			}
			else
			{
			echo "Not Inserted";
			}
}


if( isset( $_POST['psname2'] ) )
{
	$timepicker1= $_POST['timepicker1'];
	$psname2 = $_POST['psname2'];
    $psname1= $_POST['psname1'];
    $pfname = $_POST['pfname'];
	$pdni = $_POST['pdni'];
	$pbdate = $_POST['pbdate'];
	$dropdown4 = $_POST['dropdown4'];
	$pdoa = $_POST['pdoa'];
	$responsable = $_POST['responsable'];
	$pdiagnosis = $_POST['pdiagnosis'];
	$ptriatge = $_POST['ptriatge'];
	$pbox = $_POST['pbox'];
	$vtype = $_POST['vtype'];
	$paddress = $_POST['paddress'];
	$ppopulation = $_POST['ppopulation'];
	$ppostalcode = $_POST['ppostalcode'];
	$ptelephone = $_POST['ptelephone'];
	$psms = $_POST['psms'];
	$pradio = $_POST['pradio'];
	$prole1 = $_POST['prole1'];
	$pnote = $_POST['pnote'];

	$date= date("m/d/Y");

	$query00="insert into patient_add values('','$timepicker1','$date','$psname2','$psname1','$pfname','$pdni','$pbdate','$dropdown4','$pdoa','$responsable','$pdiagnosis','$ptriatge','$pbox','$vtype','$paddress','$ppopulation','$ppostalcode','$ptelephone','$psms','$pradio','$prole1','$pnote')";
	$row00=mysql_query($query00);
	
	if($row00)
			{

			echo '<div class="urgencias-table" id="results1">
				<table border="1" width="100%" id="maintable1">
				<tr>
					<th>LEVEL</th>
					<th>ING TIME</th>
					<th>PATIENT</th>
					<th>DIAGNOSIS</th>
					<th>DOCTOR</th>
				</tr>';
								
								$querys=mysql_query("select * from patient_add");
								
								while($rows=mysql_fetch_array($querys))
								{
								
				echo '	<tr>
					<td>'.$rows['id'].'</td>
					<td>'.$rows['datetime'].'</td>
					<td></td>
					<td>'.$rows['diagnosis'].'</td>
					<td>'.$rows['first_name'].'</td>
				</tr>';


}
			echo	'</table>
				</div>';
			}
			else
			{
			echo "Not Inserted";
			}
}
/* DELETE */

if( isset( $_POST['hidden2'] ) )
{
	$hidden2=$_POST['hidden2'];
			
	$query21= mysql_query("delete from agendas_costcenters where fname ='$hidden2'");
	
	if($query21)
			{
			echo "Successfully Deleted";
			}
			else
			{
			echo "Not Deleted";
			}
}

if( isset( $_POST['hiddenVal01'] ) )
{
	$hiddenVal01=$_POST['hiddenVal01'];
	
	echo $hiddenVal01;
}
?>


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
</script>