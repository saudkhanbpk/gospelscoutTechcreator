<?php

@$con=mysql_connect('localhost','gospelsc_user1','Cc@123456');
mysql_select_db('gospelsc_db663107335',$con);
?>


<?php
$aa=$_POST["nam"];
$query1=mysql_query("select * from especialitats where especialitat='".$aa."'");
$row1=mysql_fetch_array($query1);

$bb=$row1['id'];

$query =mysql_query("SELECT * FROM  agendas WHERE especialitat ='".$bb."'");
while($row=mysql_fetch_array($query))
{
print "<option value='$row[1]'>".$row[1]."</option>";
}
?>