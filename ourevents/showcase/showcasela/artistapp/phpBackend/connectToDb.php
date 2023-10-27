<?php 

/* Require necessary docs */
	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

/* Get Date/Time */
	$today = date_create();//timezone_open(America/Los_Angeles)
	$today = date_format($today, 'Y-m-d H:i:s');
	$todayDate = date_format($today, 'Y-m-d');

if($_POST){
    // validate user input
    foreach($_POST as $columns => $vals){
        $vals = trim($vals);
        if($vals != ''){
            if( $columns == 'phone'){
                $post[$columns] = removeNonNumChars($vals);
            }
            else{
                if($columns == "venueZip"){
                    if(strlen(intval($vals)) !== 5) {
                        $errorMess = 'invalid_zip';
                        $err += 1;
                        break;
                    } 
                }
                $post[$columns] = $vals;
            }
        }
    }

    if($err > 0){
        /* Return JSON Response */
            $response['err_present'] = true;
            $response['err_mess'] = $errorMess;
            echo json_encode( $response );
    }
    else{
        // insert user submission into artistshowcasemaster table
            $table = 'artistshowcasemaster';
            $post['dateTime'] = $today;
            foreach($post as $post_ind => $posted_val){
                $field[] = $post_ind;
                $value[] = $posted_val;
            }
            $post_succ = pdoInsert($db,$field,$value,$table); // $obj->insert($field,$value,$table);
            
            if( $post_succ!== null || $post_succ!== '' || $post_succ > 0 ){
                $response['err'] = false;
                $response['submitted'] = true;
                $response['artist'] = $post;
            }else{
                $repsonse['err'] = true;
            }

            echo json_encode($response);
    }
}

?>