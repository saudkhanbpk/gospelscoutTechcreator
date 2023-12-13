<?php 

/* Require necessary docs */
	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

/* Get Date/Time */
	$today = date_create();
	$today = date_format($today, 'Y-m-d H:i:s');
	$todayDate = date_format($today, 'Y-m-d');


    $emptyArray = array();

    if($_GET['getArtistSubmission']){
        // Fetch artistshowcase submissions
            $paramArray['id']['>'] = 0;
            $innerjoin = array(
                array('giftmaster','iGiftID','artistshowcasemaster','talent')
            );
            $artistSubmissions = pdoQuery('artistshowcasemaster','all',$paramArray,$emptyArray,$innerjoin,$emptyArray,$emptyArray,$emptyArray,$emptyArray);
            // var_dump($artistSubmissions);

            if( count($artistSubmissions) > 0 ){
                foreach($artistSubmissions as $artistSubmissions_ind => $artistSubmissions_val){
                    $dateTime = date_create($artistSubmissions_val['dateTime']);
                    $dateTime = date_format($dateTime, 'm/d/Y @ h:iA');
                    $artistSubmissions[$artistSubmissions_ind]['dateTime'] = $dateTime;
                }
                $response['err'] = false;
                $response['result'] = $artistSubmissions;
            }else{
                $response['err'] = true; 
            }

        // Send response
            echo json_encode($response);

    }elseif($_GET['fetchArtist']){
        // Fetch artist
            $paramArray['id']['='] = trim($_GET['fetchArtist']);
            $innerjoin = array(
                array('giftmaster','iGiftID','artistshowcasemaster','talent')
            );
            $artistSubmissions = pdoQuery('artistshowcasemaster','all',$paramArray,$emptyArray,$innerjoin,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];

            if( count($artistSubmissions) > 0 ){
                $dateTime = date_create($artistSubmissions['dateTime']);
                $dateTime = date_format($dateTime, 'm/d/Y @ h:iA');
                $artistSubmissions['dateTime'] = $dateTime;
                $artistSubmissions['phone'] = phoneNumbDisplay($artistSubmissions['phone']);
                $response['err'] = false;
                $response['result'] = $artistSubmissions;
            }else{
                $response['err'] = true; 
            }

            echo json_encode($response);
    }



?>