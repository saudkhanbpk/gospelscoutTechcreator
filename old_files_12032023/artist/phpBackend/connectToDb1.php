<?php 
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Query Database for Artist info */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

	var_dump($_GET);

	$offset = strval( ( intval( trim($_GET['tab']) ) - 1) * 6 ); 
	var_dump($offset);

	$query = 'SELECT talentmaster.talent, talentmaster.TalentID, usermaster.sFirstName, usermaster.sCityName, usermaster.sProfileName
			  FROM giftmaster
			  INNER JOIN talentmaster on talentmaster.TalentID = giftmaster.iGiftID
			  INNER JOIN usermaster on usermaster.iLoginID = talentmaster.iLoginID
			  INNER JOIN states on states.id = usermaster.sStateName
			  WHERE giftmaster.iGiftID = 23 AND giftmaster.isActive = 1';
			  
	$query .= ' LIMIT ' . $offset  . ',6';


	try{

		$get_artists = $db->prepare($query);
		$get_artists->execute(); 

		$queryDBResults = $get_artists->fetchAll(PDO::FETCH_ASSOC);

		// var_dump($queryDBResults);

		foreach($queryDBResults as $queryDBResults_val){

			$tal_categ[$queryDBResults_val['talent']][] = $queryDBResults_val;
		}
		
		ksort($tal_categ); 

		var_dump( $tal_categ );



	}
	catch(Exception $e){

		$response['error'] = $e; 
	}


?>