<?php
  /* Require necessary docs */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
  /* global vars */ 
    $emptyArray = array();
    
  if($_POST){
    /* Validate then Query for artist that match specified search criteria */
      /*************** Validate Certain input fields from the search form  ***************/
        foreach($_POST as $index => $criteria){
            
            if($criteria !== "" && $criteria !== "undefined"){
              if($index == "iZipcode") {
                if(strlen(intval(trim($criteria))) !== 5) {
                  echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter A Valid Zip Code!!!</h5></div>';
                  exit; 
                } 
                else{
                  $newCriteriaArray[$index] = intval(trim($criteria)); 
                }
              }
              elseif($index == "sFirstName" || $index == "sLastName" || $index == "sCityName") {
                $criteria = trim($criteria);
                $alphaTest = str_replace(" ","",$criteria); 
                if(!ctype_alpha($alphaTest)){
                  if($index == "sFirstName" || $index == "sLastName"){
                    echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter a Valid Name!!!</h5></div>'; 
                    exit;
                  }
                  else{
                    echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter a Valid City!!!</h5></div>'; 
                    exit;
                  }
                }
                else{
                  $newCriteriaArray[$index] = trim($criteria); 
                }
              }
              elseif($index == 'dDOB1' || $index == 'dDOB2'){
                if(strlen(intval(trim($criteria))) > 3){
                  echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please Enter an Age Between 4 and 120!!!</h5></div>';
                  exit;
                }
                else{
                  if($index == 'dDOB2'){ $nAge = intval(trim($criteria)) + 1; }else{ $nAge = intval(trim($criteria)); }
                  
                  /* Create dates to define the DOB upper and lower boundaries */
                    $dateToday = date_create();
                    date_sub($dateToday,date_interval_create_from_date_string($nAge . " years"));
                    $dateToday = date_format($dateToday, 'Y-m-d');
                  /* END - Create dates to define the DOB upper and lower boundaries */

                  $newCriteriaArray[$index] = $dateToday; 
                }
              }
              elseif($index == 'rate1' || $index == 'rate2'){
                /* Convert to a float */
                  $criteria = dollarsToCents( trim($criteria) );

                /* Validate user-entered values */
                  if($criteria != ''){
                      if( $criteria > 999999){
                        echo '<div class="container text-gs pt-2" style="min-height: 200px"><h5>Please enter a valid number between 1.00 - 9999.99</h5></div>'; 
                        exit;
                      }
                      elseif($criteria != 0){
                        $newCriteriaArray[$index] = $criteria;
                      }
                  }
              }
              else{ $newCriteriaArray[$index] = trim($criteria); }
            }
          }
        /*************** END - Validate Certain input fields from the search form  ***************/

        /********************** Generate Targeted search with validated data **********************/
          /* Initiate query statement */
            
            $query_statement = "SELECT usermaster.iLoginID,usermaster.dDOB,usermaster.sContactEmailID,usermaster.sContactNumber, usermaster.sFirstName, usermaster.sLastName, usermaster.sGroupName, usermaster.sProfileName, usermaster.sStateName, usermaster.sCityName, usermaster.rating_number, usermaster.iRateAvg, states.statecode, talentmaster.talent,talentmaster.TalentID
                                FROM usermaster 
                                INNER JOIN states on usermaster.sStateName = states.id
                                INNER JOIN talentmaster on usermaster.iLoginID = talentmaster.iLoginID
                                WHERE usermaster.isActive = 1 AND ";//usermaster.sGroupType = ? AND usermaster.sUserType = 'group' AND usermaster.isActive = 1";

          /* selction Criteria */
            $counter = 0; 
            $counterMax = count($newCriteriaArray);
            foreach($newCriteriaArray as $newCriteriaArray_ind => $newCriteriaArray_val){
              if( $newCriteriaArray_ind == 'rate1' ||  $newCriteriaArray_ind == 'rate2' ||  $newCriteriaArray_ind == 'dDOB1' ||  $newCriteriaArray_ind == 'dDOB2' ){

                if($newCriteriaArray_ind == 'rate1'){ $query_statement .= 'usermaster.minPay >= :' . $newCriteriaArray_ind; }
                elseif($newCriteriaArray_ind == 'rate2'){ $query_statement .= 'usermaster.minPay <= :' . $newCriteriaArray_ind; }
                elseif($newCriteriaArray_ind == 'dDOB1'){ $query_statement .= 'usermaster.dDOB <= :' . $newCriteriaArray_ind; }
                elseif($newCriteriaArray_ind == 'dDOB2'){ $query_statement .= 'usermaster.dDOB >= :' . $newCriteriaArray_ind; }

              }elseif($newCriteriaArray_ind == 'TalentID'){
                $query_statement .= 'talentmaster.'.$newCriteriaArray_ind . ' = :' . $newCriteriaArray_ind;
              }else{
                $query_statement .= 'usermaster.'.$newCriteriaArray_ind . ' = :' . $newCriteriaArray_ind;
              }

              /* Generate bind parameters */
                $bParam[] = ':' . str_replace('.','',$newCriteriaArray_ind) . ',' . $newCriteriaArray_val;

              $counter++;

              if($counter < $counterMax){
                $query_statement .= ' AND ';  
              }
            }

          /* Query the database in a try catch block */
            try{
              $queryDB = $db->prepare($query_statement);
              foreach($bParam as $param){
                $bParam2 = explode(',', $param);
                $queryDB->bindParam($bParam2[0], $bParam2[1]);
              }

              $queryDB->execute();
              $spec_search = $queryDB->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
              return $e; 
            }

          /* Categorize by talent */
            if( count($spec_search) > 0 ){
              $response['result'] = 'exists';

              /* Categorize active artist list by talent */
                foreach($spec_search as $list_index => $list_value){
                  // $talent = str_replace("_", "/", $list_value['talent']);

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
                  $response['artist_array'][$list_value['talent']][] = $list_value;
                }
                ksort($response['artist_array']);

            }else{
              $response['result'] = 'none_exist';
            }
        /******************* END - Generate Targeted search with validated data *******************/

  }elseif($_GET['art_talent']){
    // var_dump($_GET);exit;

    $columnsArray = array('artistvideomaster.*');
    $paramArray['iLoginID']['='] = $_GET['art_id'];
    $paramArray['VideoTalentID']['='] = $_GET['art_talent'];
    $paramArray['removedStatus']['='] = 0;
    $get_artist_videoLinks = pdoQuery('artistvideomaster',$columnsArray,$paramArray,$orderByParam,$innerJoinArray,$leftJoinArray,$paramOrArray,$groupByParam);
    // var_dump($get_artist_videoLinks);exit;
    if( count($get_artist_videoLinks) > 0 ){
      $response['vids_exist'] = true; 
      $response['vid_array'] = $get_artist_videoLinks; 
    }else{
      $response['vids_exist'] = false; 
    }

  }elseif($_GET['get_nav'] == true){
    /* Query the giftmaster table */
      $columnsArray1 = array('giftmaster.sGiftName','giftmaster.iGiftID');
      $get_tal_list = pdoQuery('giftmaster',$columnsArray1);
    /* END -Query the giftmaster table */

    /* Reduce $talentList from a 2D to 1D array */
      foreach($get_tal_list as $tal) {
        $talentList1D[$tal['iGiftID']] = str_replace('_', '/', $tal['sGiftName']);
      }
      $response['talent_list'] = $talentList1D;
      // var_dump($response);exit;
    /* END - Reduce $talentList from a 2D to 1D array */
    
    /* Query the grouptypemaster table */
      $columnsArray2 = array('grouptypemaster.id','grouptypemaster.sTypeName');
      $get_group_type_list = pdoQuery('grouptypemaster',$columnsArray2);
      $response['group_type_list'] = $get_group_type_list;
    /* END - Query the grouptypemaster table */
  }elseif($_GET['talent'] == 'all'){
    /* Query for all artists */
      $columnsArray0 = array('usermaster.iLoginID', 'usermaster.sFirstName', 'usermaster.sProfileName', 'usermaster.sStateName', 'usermaster.sCityName', 'usermaster.rating_number', 'usermaster.iRateAvg', 'states.statecode','usermaster.dDOB','usermaster.sContactEmailID','usermaster.sContactNumber', 'talentmaster.talent','talentmaster.TalentID');
      $paramArray0['usermaster.sUserType']['='] = 'artist';
      $paramArray0['usermaster.isActive']['='] = 1;
      $innerJoinArray0 = array(
        array('talentmaster','iLoginID','usermaster','iLoginID'),
        array('states','id','usermaster','sStateName')
      );
      $list = pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$leftJoinArray0,$paramOrArray0);

      if( count($list) > 0 ){
        $response['result'] = 'exists';

        /* Categorize active artist list by talent */
          foreach($list as $list_index => $list_value){
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
            $response['artist_array'][$list_value['talent']][] = $list_value;
          }
          ksort($response['artist_array']);

      }else{
        $response['result'] = 'none_exist';
      }
  }elseif($_GET['talent'] !== 'all'){
    /* Query for artists that match specified talent */
      $columnsArray0 = array('usermaster.iLoginID', 'usermaster.sFirstName', 'usermaster.sProfileName', 'usermaster.sStateName', 'usermaster.sCityName', 'usermaster.rating_number', 'usermaster.iRateAvg','usermaster.dDOB','usermaster.sContactEmailID','usermaster.sContactNumber', 'states.*');
      
      $paramArray0['usermaster.sUserType']['='] = $_GET['type'];//'artist';
      if( $_GET['type'] == 'group'){
        $paramArray0['usermaster.sGroupType']['='] = $_GET['talent'];
      }else{
        $paramArray0['talentmaster.TalentID']['='] = $_GET['talent'];
        array_push($columnsArray0, 'talentmaster.*');
      }
      $paramArray0['usermaster.isActive']['='] = 1;
      $innerJoinArray0 = array(
        array('states','id','usermaster','sStateName')
      );

      if( $_GET['type'] == 'artist'){
        array_push($innerJoinArray0, array('talentmaster','iLoginID','usermaster','iLoginID'));
      }
      
      // $leftJoinArray0 = array(
      //   array('artistvideomaster','iLoginID','usermaster','iLoginID')
      // );
      // $paramArray0['artistvideomaster.VideoTalentID']['='] = $_GET['talent'];
      // var_dump($innerJoinArray0);

      $list = pdoQuery('usermaster',$columnsArray0,$paramArray0,$orderByParam0,$innerJoinArray0,$leftJoinArray0,$paramOrArray0);
// var_dump($list);exit;
      if( count($list) > 0 ){
        $response['result'] = 'exists';

        /* Categorize artist list by state */
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
            /* categorize array by state */ 
              $response['artist_array'][$list_value['name']][] = $list_value;
          }

          ksort($response['artist_array']);
      }
      else{
        $response['result'] = 'none_exist';
      }

        // var_dump($response['artist_array']);exit;
  }

  echo json_encode($response);

?>