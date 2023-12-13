<?php
	/* Create a connection to the database - try/catch block */

			/* Define Constants 
			define("DB_HOST", "localhost");
			define("DB_NAME", "gospelsc_db651933262");
			define("DB_PORT", "3306"); //default: 3306
			define("DB_USER", "root");
			define("DB_PASS", "root");
			

			$dbHost = 'localhost';
			$dbUsername = 'gospelsc_user';
			$dbPassword = 'Gg@123456';
			$dbName = 'gospelsc_db651933262';
			*/

			define("DB_HOST", "localhost");
			define("DB_NAME", "gospelsc_db651933262");
			define("DB_PORT", "3306"); //default: 3306
			define("DB_USER", "gospelsc_user");
			define("DB_PASS", "Gg@123456");

			try{
				$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";",DB_USER,DB_PASS);
				$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$db->exec("SET NAMES 'UTF8'");

				//echo 'Connected Successfully<br>';
			}catch(Exception $e) {

				echo 'Could not connect to the database';
				echo $e; 
				exit; 
			}


			require_once "../common/session.php";
			$objsession = new Session();

			/*
			echo 'Test before query<br>';
			
			$qStringDel = 'DELETE gigmaster, gigdetails, gigartists, gigrequests, gigmusic, gigclients, gigstatus FROM gigmaster
						   INNER JOIN gigdetails ON gigmaster.gigId = gigdetails.gigId
						   INNER JOIN gigartists ON gigmaster.gigId = gigartists.gigId
						   INNER JOIN gigrequests ON gigmaster.gigId = gigrequests.gigId
						   INNER JOIN gigmusic ON gigmaster.gigId = gigmusic.gigId
						   INNER JOIN gigclients ON gigmaster.gigId = gigclients.gigId
						   INNER join gigstatus ON gigmaster.gigId = gigstatus.gigId
						   WHERE gigmaster.gigId=?';
			
			
			$GIDtrim = '4472756d313436';
			try{

				$delData = $db->prepare($qStringDel);
				$delData->bindParam(1, $GIDtrim);
				$delData->execute(); 
				echo 'test';

				echo 'the gig data was removed';
			} catch(Exception $e) {
				echo 'There was a problem removing old gig data from the database!!!';
				echo $e; 
			}
			echo '<br>Test after query<br>';*/
	/* END - Create a connection to the database - try/catch block */
?>