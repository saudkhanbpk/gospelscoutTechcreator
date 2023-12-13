<?php

@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);



if($_POST['value'] && $_POST['value1'] && $_POST['value2'])
{
$query = mysql_query("
  SELECT * 
  FROM patient_add 
  WHERE surname ='".$_POST['value']."' AND other_surname ='".$_POST['value1']."' AND  first_name ='".$_POST['value2']."'
");

while ($data = mysql_fetch_array($query)) {

  echo '
  							<b>ADDRESS :</b>'.$data["address"].'</br>
							
							<b>POPULATION :</b>'.$data["population"].'</br>
							
							<b>TELEPHONE :</b>'.$data["telephone"].'</br>
							
							<b>DNI :</b>'.$data["dni"].'</br>
							
							<b>MUTUAL :</b>'.$data["payment_type"].'</br>
							
							<b>NOTE :</b>'.$data["note"].'</br>';

echo '<div style="margin-left: 106%;border: 1px solid black;margin-top: -120px;height: 233px;width: 263px;">
	<table id="div">
		<tr>
			<td >'.$data["surname"].', '.$data["first_name"].'</td>
		</tr>
	</table> </div>';
}

}

else if($_POST['value'] && $_POST['value1'])
{

$query = mysql_query("
  SELECT * 
  FROM patient_add 
  WHERE surname ='".$_POST['value']."' AND other_surname ='".$_POST['value1']."'
");

while ($data = mysql_fetch_array($query)) {

  echo '
  							<b>ADDRESS :</b>'.$data["address"].'</br>
							
							<b>POPULATION :</b>'.$data["population"].'</br>
							
							<b>TELEPHONE :</b>'.$data["telephone"].'</br>
							
							<b>DNI :</b>'.$data["dni"].'</br>
							
							<b>MUTUAL :</b>'.$data["payment_type"].'</br>
							
							<b>NOTE :</b>'.$data["note"].'</br>';

echo '<div style="margin-left: 106%;border: 1px solid black;margin-top: -120px;height: 233px;width: 263px;">
	<table id="div">
		<tr>
			<td >'.$data["surname"].', '.$data["first_name"].'</td>
		</tr>
	</table> </div>';
}
}

else if($_POST['value1'] && $_POST['value2'])
{

$query = mysql_query("
  SELECT * 
  FROM patient_add 
  WHERE other_surname ='".$_POST['value1']."' AND first_name ='".$_POST['value2']."'
");

while ($data = mysql_fetch_array($query)) {

  echo '
  							<b>ADDRESS :</b>'.$data["address"].'</br>
							
							<b>POPULATION :</b>'.$data["population"].'</br>
							
							<b>TELEPHONE :</b>'.$data["telephone"].'</br>
							
							<b>DNI :</b>'.$data["dni"].'</br>
							
							<b>MUTUAL :</b>'.$data["payment_type"].'</br>
							
							<b>NOTE :</b>'.$data["note"].'</br>';

echo '<div style="margin-left: 106%;border: 1px solid black;margin-top: -120px;height: 233px;width: 263px;">
	<table id="div">
		<tr>
			<td >'.$data["surname"].', '.$data["first_name"].'</td>
		</tr>
	</table> </div>';
}
}

else if($_POST['value'] && $_POST['value2'])
{

$query = mysql_query("
  SELECT * 
  FROM patient_add 
  WHERE surname ='".$_POST['value']."' AND first_name ='".$_POST['value2']."'
");

while ($data = mysql_fetch_array($query)) {

  echo '
  							<b>ADDRESS :</b>'.$data["address"].'</br>
							
							<b>POPULATION :</b>'.$data["population"].'</br>
							
							<b>TELEPHONE :</b>'.$data["telephone"].'</br>
							
							<b>DNI :</b>'.$data["dni"].'</br>
							
							<b>MUTUAL :</b>'.$data["payment_type"].'</br>
							
							<b>NOTE :</b>'.$data["note"].'</br>';

echo '<div style="margin-left: 106%;border: 1px solid black;margin-top: -120px;height: 233px;width: 263px;">
	<table id="div">
		<tr>
			<td >'.$data["surname"].', '.$data["first_name"].'</td>
		</tr>
	</table> </div>';
}
}

else if($_POST['value'] || $_POST['value1'] || $_POST['value2'])
{

$query = mysql_query("
  SELECT * 
  FROM patient_add 
  WHERE surname ='".$_POST['value']."' OR other_surname ='".$_POST['value1']."' OR first_name ='".$_POST['value2']."'
");

while ($data = mysql_fetch_array($query)) {

  echo '
  							<b>ADDRESS :</b>'.$data["address"].'</br>
							
							<b>POPULATION :</b>'.$data["population"].'</br>
							
							<b>TELEPHONE :</b>'.$data["telephone"].'</br>
							
							<b>DNI :</b>'.$data["dni"].'</br>
							
							<b>MUTUAL :</b>'.$data["payment_type"].'</br>
							
							<b>NOTE :</b>'.$data["note"].'</br>';

echo '<div style="margin-left: 106%;border: 1px solid black;margin-top: -120px;height: 233px;width: 263px;">
	<table id="div">
		<tr>
			<td >'.$data["surname"].', '.$data["first_name"].'</td>
		</tr>
	</table> </div>';
}
}
?>