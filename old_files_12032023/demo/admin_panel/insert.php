<?php

/*-------------------------------------------------------+
| Content Management System 
| http://www.phphelptutorials.com/
+--------------------------------------------------------+
| Author: David Carr  Email: dave@daveismyname.co.uk
+--------------------------------------------------------+*/

ob_start();

define('DBHOST','localhost');
define('DBUSER','gospelsc_user1');
define('DBPASS','Cc@123456');
define('DBNAME','gospelsc_db663107335');

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}
?>

<?php

$query=mysql_query("INSERT INTO `actos` (`id`, `agenda`, `cod_facturador`,`Codigo`,`Nombre`,`mutua`,`privat`,`tipo`,`tarifa`,`cma`,`ucias`,`ayudante`,`perayuda`,`autorizacion`,`consentimiento`,`texto`) VALUES



(60,1,'','','TOT',3,0,2,432.03,0,0,0,0,'','',''),
(61,1,'','','COLPORRAFIA',3,0,2,432.03,0,0,0,0,'','',''),
(62,1,'','','BIOPSIA DE PROSTATA TRANSRECTAL ECODIRIGIDA',3,0,2,103.85,0,0,0,0,'','',''),
(63,1,'','','VARICOCELE',3,0,2,243.02,0,0,0,0,'','',''),
(64,1,'','','URETEROSCOPIA',3,0,2,207.71,0,0,0,0,'','',''),
(65,1,'','','URETROTOMIA INTERNA',3,0,2,135.01,0,0,0,0,'','',''),
(66,1,'','','ATH',3,0,2,432.03,0,0,0,0,'','',''),
(67,1,'','','CATETERISMO URETERAL DOBLE-J',3,0,2,135.01,0,0,0,0,'','',''),
(68,1,'','','CIRCUMCISION',3,0,2,135.01,0,0,0,0,'','',''),
(69,1,'','','URETEROSCOPIA',4,0,2,303.77,0,0,0,0,'','',''),
(70,1,'','','CIRCUMCISION',4,0,2,168.77,0,0,0,0,'','','')");






if($query > 0)
	{
		echo "inserted";
	}
else
	{
		echo "not";
	}
?>