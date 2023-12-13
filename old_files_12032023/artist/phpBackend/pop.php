<?php 
	// Query artists by popularity - using the total number of views from artist's videos
    // for right now, we will just query all artists 

    /* global vars */ 
      $emptyArray = array();

    /* Run initial query to get the total number of artists in the subset */
      $columnsArray_art_no =  array('usermaster.iLoginID', 'usermaster.sFirstName', 'usermaster.sProfileName', 'usermaster.sStateName', 'usermaster.sCityName', 'usermaster.rating_number', 'usermaster.iRateAvg', 'usermaster.dDOB','usermaster.sContactEmailID','states.statecode', 'usermaster.sContactNumber');
      $paramArray_art_no['usermaster.sUserType']['='] = 'artist';
      $paramArray_art_no['usermaster.isActive']['='] = 1;
      $innerJoinArray0 = array(
        array('states','id','usermaster','sStateName')
      );
      $artist_no = count( pdoQuery('usermaster',array('usermaster.iLoginID'),$paramArray_art_no,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray) ); 
      $response['total_no_of_artists'] = $artist_no;

    /* Re-run query to request only the subset of 15 that are needed */
    	$list = pdoQuery('usermaster',$columnsArray_art_no,$paramArray_art_no,$orderByParam0,$innerJoinArray0,$leftJoinArray0,$paramOrArray0,$groupByParam,$offset_array);

    if( count($list) > 0 ){
        $response['result'] = 'exists';

        /* Categorize artist list by state */
          $p = 0;
          foreach($list as $list_value){
              /* Reformat phone# display */
                if( $list_value['sContactNumber'] != ''){
                  $list_value['sContactNumber'] = phoneNumbDisplay($list_value['sContactNumber']);
                }else{
                  $list_value['sContactNumber'] = 'N/A';
                }
              /* Truncate email */
                $list_value['sContactEmailID'] = truncateStr($list_value['sContactEmailID'], 15);
              /* Calculate age */
                $list_value['dDOB'] = getAge($list_value['dDOB']);
              /* Reformat talent */
                $list_value['talent'] = str_replace('_', '/', $list_value['talent']);

              /* Queryy DB for artist talent(s) */
                $columnsArray_artist_talents = array('talentmaster.talent','talentmaster.TalentID');
                $paramArray_artist_talents['talentmaster.iLoginID']['='] = $list_value['iLoginID'];
                $artist_talents = pdoQuery('talentmaster',$columnsArray_artist_talents,$paramArray_artist_talents,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

              /* Reformat talent */
                foreach($artist_talents as $tal_ind => $tal){
                  $artist_talents[$tal_ind]['talent'] = str_replace('_', '/', $tal['talent']);
                }
              
              $response['artist_array'][$list_value['iLoginID']][] = $list_value;
              $response['artist_array'][$list_value['iLoginID']]['talent_list'] = $artist_talents;
          }

          ksort($response['artist_array']);
    }else{
        $response['result'] = 'none_exist';
    }
?>