<?php 
 /* Require necessary docs */
    	require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
    	require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	// if($_GET){
		/* Define Vars */
			$searchBy =  explode(',', $_GET['talent']);
			$response['page_no'] = $page_no = $_GET['page_no'];
      		$response['search_type'] = $searchBy[0];

		/* Set number of records per page */
	      	$no_of_records_per_page = 15;
	      	$offset = ($page_no-1) * $no_of_records_per_page; 
	      	$offset_array = array('offset'=>$offset,"no_of_records"=>$no_of_records_per_page);

		/* Determine what Subset of artist is being requested */

		      if($searchBy[0] == 'pop'){
		      	require('pop.php');
		      }elseif($searchBy[0] == 'TR'){
		        // Query artists by highest rated - using the the artist's total star ratting ( functionality not available yet )

		        /* Run initial query to get the total number of artists in the subset */

		      }elseif($searchBy[0] == 'NT'){
		        // Query artists that have been most recently added - date that profile was created up to the last 60 days

		        /* Run initial query to get the total number of artists in the subset */

		      }elseif($searchBy[0] == 'SBT'){
		      	require('sbt.php');
		      }elseif($_POST['talent'] == 'FORM'){
		        //  Query artists by search form criteria

		      	// var_dump($_POST);
		        /* Run initial query to get the total number of artists in the subset */
		        foreach($_POST as $index => $criteria){
							$response['page_no'] = $page_no = $_POST['page_no'];
		      		$response['search_type'] = 'form';
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

		          unset($newCriteriaArray['talent']);
		          unset($newCriteriaArray['page_no']);
		          // var_dump($newCriteriaArray);


		        /********************** Generate Targeted search with validated data **********************/
		            /* Initiate query statement */
		            $query_statement = "SELECT usermaster.iLoginID,usermaster.dDOB,usermaster.sContactEmailID,usermaster.sContactNumber, usermaster.sFirstName, usermaster.sLastName, usermaster.sGroupName, usermaster.sProfileName, usermaster.sStateName, usermaster.sCityName, usermaster.rating_number, usermaster.iRateAvg, usermaster.minPay, states.statecode";
		            if( $newCriteriaArray['TalentID'] !== "" && $newCriteriaArray['TalentID'] !== null){
		            		$query_statement .= ", talentmaster.talent,talentmaster.TalentID";
		            }
					$query_statement .= " FROM usermaster 
		                                INNER JOIN states on usermaster.sStateName = states.id ";
		            if( $newCriteriaArray['TalentID'] !== "" && $newCriteriaArray['TalentID'] !== null){
		            	$query_statement .= "INNER JOIN talentmaster on usermaster.iLoginID = talentmaster.iLoginID ";
		            }                    
					$query_statement .= "WHERE usermaster.isActive = 1 AND usermaster.sUserType = 'artist' AND ";//usermaster.sGroupType = ? AND usermaster.sUserType = 'group' AND usermaster.isActive = 1";
					// $paramArray_art_no['usermaster.sUserType']['='] = 'artist';
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

		          /* Query the database in a try catch block - Get total number of artists */
		            function fetchQuery($db,$query_statement, $bParam){
		            	try{
			              $queryDB = $db->prepare($query_statement);
			              foreach($bParam as $param){
			                $bParam2 = explode(',', $param);
			                $queryDB->bindParam($bParam2[0], $bParam2[1]);
			              }

			              	$queryDB->execute();
			              	$spec_search = $queryDB->fetchAll(PDO::FETCH_ASSOC);
			              	return $spec_search;
			            }
			            catch(Exception $e){
			            	return $e; 
			            }
		            }
		            $spec_search = fetchQuery($db,$query_statement, $bParam);

		            /* get # of artists */
		            	$response['total_no_of_artists'] = count($spec_search);

		           	/* Update Query to database and limit to 15 results */
		           		$no_of_records_per_page = 15;
	      				$offset = ($page_no-1) * $no_of_records_per_page;	
		           		$query_statement .= ' LIMIT '. $offset .', '.$no_of_records_per_page;
		           		$spec_search = fetchQuery($db,$query_statement,$bParam);

		          	/* Categorize by talent */
		            if( count($spec_search) > 0 ){
		              $response['result'] = 'exists';

		              /* Categorize active artist list by talent */
		                foreach($spec_search as $list_index => $list_value){
		                  	/* Reformat phone# display */
			                    if( $list_value['sContactNumber'] != ''){
			                      $list_value['sContactNumber'] = phoneNumbDisplay($list_value['sContactNumber']);
			                    }else{
			                      $list_value['sContactNumber'] = 'N/A';
			                    }
		                  	/* Truncate email */
		                    	// $list_value['sContactEmailID'] = truncateStr($list_value['sContactEmailID'], 15);
								$list_value['sContactEmailID'] = $list_value['sContactEmailID'];
		                  	/* Calculate age */
		                    	$list_value['dDOB'] = getAge($list_value['dDOB']);

							/* Convert Cents to Dollars */
								$list_value['minPay'] = CentsToDollars($list_value['minPay']);


		                    /* Queryy DB for artist talent(s) */
				                $columnsArray_artist_talents = array('talentmaster.talent','talentmaster.TalentID');
				                $paramArray_artist_talents['talentmaster.iLoginID']['='] = $list_value['iLoginID'];
				                $artist_talents = pdoQuery('talentmaster',$columnsArray_artist_talents,$paramArray_artist_talents,$orderByParam1,$innerJoinArray1,$leftJoinArray01,$paramOrArray01,$groupByParam1,$offset_array1);
		            		
		            		/* Reformat talent */
				                foreach($artist_talents as $tal_ind => $tal){
				                  $artist_talents[$tal_ind]['talent'] = str_replace('_', '/', $tal['talent']);
				                }
				            $response['artist_array'][ $list_value['iLoginID']][] = $list_value;
 										$response['artist_array'][ $list_value['iLoginID']]['talent_list'] = $artist_talents;			
		                }
		                ksort($response['artist_array']);
		            }else{
		              $response['result'] = 'none_exist';
		            }
		        /******************* END - Generate Targeted search with validated data *******************/

		        
		      }
	// }


	/* Return the JSON Response */	
		echo json_encode($response);
?>