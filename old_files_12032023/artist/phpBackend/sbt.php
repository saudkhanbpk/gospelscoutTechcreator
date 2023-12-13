<?php 
  $response['SBT_talent'] = $talent = $searchBy[1];
  /* global vars */ 
    $emptyArray = array();

  /* Run initial query to get the total number of artists in the subset */
    $columnsArray0 = array('usermaster.iLoginID', 'usermaster.sFirstName', 'usermaster.sProfileName', 'usermaster.sStateName', 'usermaster.sCityName', 'usermaster.rating_number', 'usermaster.iRateAvg','usermaster.dDOB','usermaster.sContactEmailID','usermaster.sContactNumber', 'states.*','talentmaster.talent','talentmaster.TalentID');

    $paramArray0['usermaster.sUserType']['='] = $_GET['type'];
    if( $_GET['type'] == 'group'){
      $paramArray0['usermaster.sGroupType']['='] = $talent;
    }else{
      $paramArray0['talentmaster.TalentID']['='] = $talent;
      array_push($columnsArray0, 'talentmaster.*');
    }
    $paramArray0['usermaster.isActive']['='] = 1;
    $innerJoinArray0 = array(
      array('states','id','usermaster','sStateName')
    );
    if( $_GET['type'] == 'artist'){
      array_push($innerJoinArray0, array('talentmaster','iLoginID','usermaster','iLoginID'));
    }
    $total_rows = count(pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$emptyArray,$emptyArray,$emptyArray,$emptyArray));
    $response['total_no_of_artists'] = $total_rows;

    /* Re-run query to request only the subset of 15 that are needed */
      $list = pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$leftJoinArray0,$paramOrArray0,$groupByParam,$offset_array);

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