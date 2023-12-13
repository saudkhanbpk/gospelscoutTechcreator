<?php 
	/*  Include pages */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/**** Check if email is in table already ****/
	    $participant_email = trim($_POST['email']);
	    $table = 'artist_surveys';
	    $cond = 'email = "' . $participant_email.'"';
	    $emailExists = $obj->fetchRow($table,$cond);
	/* END - Check if email is in table already */	

	 /* if so, redirect back to survey_artist.php with error message, else proceed with survey  */  
        if(count($emailExists) > 0){  
          	$response = array('exists'=>'true');
        } 
        else{ 
        	$response = array('exists'=>'false');
        }

    /* Return JSON response */
        echo json_encode($response);
?>