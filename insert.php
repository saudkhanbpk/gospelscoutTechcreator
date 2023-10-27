<?php

/*-------------------------------------------------------+
| Content Management System 
| http://www.phphelptutorials.com/
+--------------------------------------------------------+
| Author: David Carr  Email: dave@daveismyname.co.uk
+--------------------------------------------------------+*/

ob_start();

define('DBHOST','db651933262.db.1and1.com');
define('DBUSER','dbo651933262');
define('DBPASS','Gg@123456');
define('DBNAME','db651933262');

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}
?>

<?php

$query=mysql_query("INSERT INTO `cities` (`id`, `name`, `state_id`) VALUES

(48315, 'Kowloon', 4121),
(48316, 'Tsimshatsui', 4121),
(48317, 'Hung Hom', 4121),
(48318, 'Sham Shui Po', 4122),
(48319, 'Shek Kip Mei', 4122),
(48320, 'Yau Yat Tsuen', 4122),
(48321, 'Fo Tan', 4123),
(48322, 'Ma On Shan Tsuen', 4123),
(48323, 'Siu Lek Yuen', 4123),
(48324, 'Wong Tai Sin', 4124),
(48325, 'Happy Valley', 4125),
(48326, 'Tin Shui Wai', 4126),
(48327, 'Fanling', 4127),
(48328, 'Mongkok', 4128),
(48329, 'Repulse Bay', 4129),
(48330, 'Aberdeen', 4129),
(48331, 'Tai Tam', 4129),
(48332, 'Chek Chue', 4129),
(48333, 'Tin Wan', 4129)");

if($query > 0)
	{
		echo "inserted";
	}
else
	{
		echo "not";
	}
?>