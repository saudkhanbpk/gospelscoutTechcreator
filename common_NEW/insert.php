<?php
//db details
$dbHost = 'db651933262.db.1and1.com';
$dbUsername = 'dbo651933262';
$dbPassword = 'Gg@123456';
$dbName = 'db651933262';

//Connect and select the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>
<?php
$query=mysql_query("insert into cities(`id`, `name`, `state_id`) values
('7478','Hlybokaje','421')");
echo "insert into cities values
('7478','Hlybokaje','421')";
exit;
if($query > 0)
	{
		echo "inserted";
	}
	else
	{
		echo "not inserted";
	}
?>