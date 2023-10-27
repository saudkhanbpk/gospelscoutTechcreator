<?php
/*********************************************
OHD - Database Class
Date - 14-March-2016 05:02 
**********************************************/
function pre($data, $flag = 1) {
	echo "<pre>"; print_r($data); 
		echo "</pre>";
	if($flag) {
		exit;	
	}
}

class Database {
	
	private $_hostname = "";
	private $_username = "";
	private $_password = "";
	private $_database = "";
	private $_column = array();
	private $_table = "";

	
	function __construct(){
		
		if(define('HOST',"localhost")){
			$this->_hostname = HOST;	
		}
		if(define('USER','root')){
			$this->_username = USER;	
		}
		if(define('PASSWORD',"root")){
			$this->_password = PASSWORD;
		}
		if(define('DATABASE',"gospelsc_db651933262")){
			 $this->_database = DATABASE;
		}
		
		$connect = @mysql_connect($this->_hostname,$this->_username,$this->_password);
		if(!$connect)
		die('Unable to connect to MySqL Server.');
	}

	
	function getTable(){
		return $this->_table;
	}
	
	function setTable($table){
		if($table != "")$this->_table = $table;
	}

	public function checkCond($table,$iLower,$iUpper,$iCarID,$iDomainID,$mID){
		try{
			
			if($table != ""){
				
				$this->_table = $table;	
			 	$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` WHERE (iCarID = ".$iCarID." AND iDomainID = ".$iDomainID.")";
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				$no = 0;
				if($num > 0){
					while($row = mysql_fetch_array($rs)){
						if($mID > 0){
							if(($iLower >= $row['iLowerLimit'] && $iUpper <= $row['iUpperLimit']) && $row['iMileageID'] != $mID){
								$no += 1;
							}
						}else{
							
							if($iLower >= $row['iLowerLimit'] && $iUpper <= $row['iUpperLimit']){
								$no += 1;
							}

						}
					}
						if($no == 1){
							return 0;	
						}else{
							return 1;	
						}
						
				}else{
					//return false;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchRowAll($table,$cond){
		
		try{
			
			if($table != ""){
				
				$this->_table = $table;	
 	 			$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				$value = array();
				if($num > 0){					
					while($row = mysql_fetch_array($rs)){
						
						$value[] = $row;	
					}
					return $value;
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchAverageTotal($table,$id,$cond){
		
		try{
			
			if($table != ""){
				
				$this->_table = $table;	
 	 $query = "SELECT SUM(".$id.") as average_rating FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				$value = array();
				if($num > 0){					
					return mysql_fetch_array($rs);					
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function averages($table,$id,$cond){
		
		try{
			
			if($table != ""){
				
				$this->_table = $table;	
 	 			$query = "SELECT SUM(".$id.") / count(".$id.") as average_rating FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				$value = array();
				if($num > 0){					
					return mysql_fetch_array($rs);					
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchFieldAll($table,$field,$cond){
		
		try{
			
			if($table != ""){
				
				$this->_table = $table;	
			 	$query = "SELECT `".implode(',',$field)."` FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				if($num > 0){
					$value = array();
					while($row = mysql_fetch_array($rs)){
						
						$value[] = $row;	
					}
					return $value;
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchRowAllLimit($table,$cond,$start = 0,$limit = 0){
		
		try{
			
			if($table != ""){
				
				$where = "";
				$limitcond = "";
				
				if($cond != ""){
					$where = " WHERE ".$cond;
				}
				
				if($limit > 0){
					$limitcond = " LIMIT ".$start.",".$limit;
				}
				
				$this->_table = $table;	
				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."`".$where.$limitcond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				if($num > 0){
					$value = array();
					while($row = mysql_fetch_array($rs)){
						
						$value[] = $row;	
					}
					return $value;
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchNumOfRow($table,$cond){
		
		try{
			if($table != ""){
				
				$where = "";
				
				if($cond != ""){
					$where = " WHERE ".$cond;
				}
				
				$this->_table = $table;		
			
				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."`".$where;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				if($num > 0){
					return $num;
				}else{
					return NULL;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchRow($table,$cond){
		
		try{
			if($table != ""){
				
				$this->_table = $table;		
			
				 $query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				if($num > 0){
					return mysql_fetch_array($rs);
				}else{
					return NULL;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	public function fetchRowwithjoin($table,$table2,$common,$cond){
		
		try{
			if($table != ""){
				
				$this->_table = $table;	
				$where="";
				if($cond != ""){
					$where = " WHERE ".$cond;
				}
				
				if($common == 'iSubCategoryID'){
				
				$query = "SELECT ".$table.".*,".$table2.".iCategoryID as catID,".$table2.".sCategoryName FROM `".$this->_database."`.`".$this->getTable()."` INNER JOIN ".$this->_database.'.'.$table2." ON ".$this->_database.'.'.$table.".iSubCategoryID = ".$this->_database.'.'.$table2.".iCategoryID ".$where;
					
				}else{
				$query = "SELECT ".$table.".*,".$table2.".iProductID as pID,".$table2.".sProductName FROM `".$this->_database."`.`".$this->getTable()."` INNER JOIN ".$this->_database.'.'.$table2." ON ".$this->_database.'.'.$table.".".$common." = ".$this->_database.'.'.$table2.".".$common." ".$where;
				}
				
				$rs = mysql_query($query);
				if(empty($rs))
				{
					echo mysql_error();
				}
				 $num = mysql_num_rows($rs);
				 $value = array();
				if($num > 0){					
					while($row = mysql_fetch_array($rs)){
						
						$value[] = $row;	
					}
					return $value;
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		
		}
	}
	
	public function getBookingData($table,$table1,$table2,$table3,$common,$cond){
		
		try{
			if($table != ""){
				
				$this->_table = $table;	
				$where="";
				if($cond != ""){
					$where = " WHERE ".$cond;
				}


$query = "SELECT `".$this->_database."`.".$table.".* , `".$this->_database."`.".$table1.".sNameTitle ,`".$this->_database."`.".$table1.".sName ,`".$this->_database."`.".$table1.".sSurname ,`".$this->_database."`.".$table1.".sPhoneNumber ,`".$this->_database."`.".$table1.".sAccount, `".$this->_database."`.".$table3.".* FROM `".$this->_database."`.".$table." LEFT JOIN `".$this->_database."`.".$table1." ON `".$this->_database."`.".$table.".iCustomerID = `".$this->_database."`.".$table1.".iCustomerID INNER JOIN `".$this->_database."`.".$table3." ON `".$this->_database."`.".$table.".iCustomerBookID = `".$this->_database."`.".$table3.".iCustomerBookID ".$where;

			$rs = mysql_query($query);
			$num = mysql_num_rows($rs);
				 

				if($num > 0){
					$value = array();
					while($row = mysql_fetch_array($rs)){
						
						$value[] = $row;	
					}
					return  $value;
				}else{
					return $value;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		
		}
	}
	
	public function setData($data){
		$this->_column = $data;
	}
	
	public function getPageData(){
		return $this->_column;
	}
	
	public function pagination($table,$cond,$id,$perpageitem=0){
		$adjacents = 3;
		
		if($table != "")$this->_table = $table;
		
			if(strlen($cond) > 0){
				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
			}else{
				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."`";
			}
			$rs = mysql_query($query);
			
				$searchCond = $_SERVER['QUERY_STRING'];
				$arr = explode('=',$searchCond);

				if(in_array('pages',$arr)){
					 $searchCond = str_replace(substr($searchCond,0,8),"",$searchCond);	
					 if(strlen($searchCond) > 0){
						 $searchCond = '&'.$searchCond;
					 }
				}
			$path = $_SERVER['PHP_SELF'];
			//$file = basename($path,".php");

			$total_pages=mysql_num_rows($rs);
			$targetpage = $file;
			$limit = $perpageitem; 
								
			$page = (isset($_GET['pages'])) ? $_GET['pages'] : 0;
			if($page) 
			$start = ($page - 1) * $limit; 			//first item to display on this page
			else
			$start = 0;	
			$limit;
			$limit1=$limit;
			//$data['users'] = $this->admin_model->fechRowAllOrderBylimit('membermaster',$cond,'iMemberID',$start,$limit1);
			if ($page == 0) $page = 1;					//if no page var is given, default to 1.
			$prev = $page - 1;							//Previous page is page - 1
			$Next = $page + 1;							//Next page is page + 1
			$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;	
			$pagination1 = "";
			if($lastpage > 1)
			{	
			$pagination1 .= "<div class=\"pagination\"> <div class='alignright'><ul class=\"pagination\">";
			
			//Previous button
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination1.= "<li class=\"active\"><span>$counter</a></span>";
					else
						$pagination1.= "<li><a href=\"$targetpage?pages=$counter$searchCond\">$counter</a></li>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{ //close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination1.= "<li class=\"active\"><span>$counter</a></span>";
						else
							$pagination1.= "<li><a href=\"$targetpage?pages=$counter$searchCond\">$counter</a></li>";					
					}
					$pagination1.= "...";
					$pagination1.= "<li><a href=\"$targetpage?pages=$lpm1$searchCond\">$lpm1</a></li>";
					$pagination1.= "<li><a href=\"$targetpage?pages=$lastpage$searchCond\">$lastpage</a></li>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination1.= "<li><a href=\"$targetpage?pages=1$searchCond\">1</a></li>";
					$pagination1.= "<li><a href=\"$targetpage?pages=2$searchCond\">2</a></li>";
					$pagination1.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
					if ($counter == $page)
					$pagination1.= "<li class=\"active\"><span>$counter</a></span>";
					else
					$pagination1.= "<li><a href=\"$targetpage?pages=$counter$searchCond\">$counter</a></li>";					
					}
					$pagination1.= "...";
					$pagination1.= "<li><a href=\"$targetpage?pages=$lpm1$searchCond\">$lpm1</a></li>";
					$pagination1.= "<li><a href=\"$targetpage?pages=$lastpage$searchCond\">$lastpage</a></li>";		
				}

				//close to end; only hide early pages
				else
				{
				$pagination1.= "<a href=\"$targetpage?pages=1$searchCond\">1</a>";
				$pagination1.= "<a href=\"$targetpage?pages=2$searchCond\">2</a>";
				$pagination1.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
				if ($counter == $page)
					$pagination1.= "<li class=\"active\"><span>$counter</a></span>";
				else
					$pagination1.= "<a href=\"$targetpage?pages=$counter$searchCond\">$counter</a>";					
					}
				}
			}
			//Next button
			$pagination1.= "</ul></div></div>\n";		
			}
			
			if(strlen($cond) > 0){
				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond." ORDER BY ".$id." DESC LIMIT $start,$limit1";
			}else{
				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` ORDER BY ".$id." DESC LIMIT $start,$limit1";
			}
			
			$rs = mysql_query($query);
			$value = array();
				while($row = mysql_fetch_array($rs)){
					
					$value[] = $row;	
				}
				$this->setData($value);
				
		return $pagination1;
		

	}
	
	
	function insert($field,$value,$table){
		
		try{
			
			for($i=0;$i<count($value); $i++){
				$value[$i] = addslashes($value[$i]);	
			}
			
			if($table != "")$this->_table = $table;			
			$query = "INSERT INTO `".$this->_database."`.`".$this->getTable()."`(`".implode("`,`",$field)."`) VALUES('".implode("','",$value)."')";
			$rs = mysql_query($query);
			
			if($rs){
				return  mysql_insert_id();	
			}else{
				throw new Exception("Enable to insert data in MySql Server.");	
			}
			
		}catch(Exception $e){
			echo $e->getMessage();	
		}
	}
	
	function update($field,$value,$cond,$table){
		try{
			if($table != "")$this->_table = $table;
			
			$arrCombine = array_combine($field,$value);
			$query = "UPDATE `".$this->_database."`.`".$this->getTable()."` SET ";
			
			foreach($arrCombine as $key=>$val){
				$query .= $key."='".mysql_real_escape_string($val)."',";
			}
			
			$query = rtrim($query,',');
			$query .= " WHERE ".$cond;
			
			$rs = mysql_query($query);
			if($rs){
				return true;	
			}else{
				throw new Exception('Enable to update data in MySql Server.');	
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	function delete($table,$cond){
		
		try{
			if($table != "")$this->_table = $table;
			
			$query = "DELETE FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
			$rs = mysql_query($query);
		
			if($rs){
				return true;
			}else{
				throw new Exception("Enable to delete data in MySql Server.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
		
	}
	
	function deleteALL($table){
		
		try{
			if($table != "")$this->_table = $table;
			
			$query = "DELETE FROM `".$this->_database."`.`".$this->getTable();
			$rs = mysql_query($query);
		
			if($rs){
				return true;
			}else{
				throw new Exception("Enable to delete data in MySql Server.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
		
	}
	
	function checkValidLogin($table,$cond){
		try{
			if($table != "")$this->_table = $table;
			
			$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
			$rs = mysql_query($query);
			$row = mysql_fetch_array($rs);
		
			if(!empty($row)){
				return $row;
			}else{
				throw new Exception("Please check your email id or password");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}	
	}
	
	public function fetchSearchedArtistLimit($postData){

		extract($postData);
		try{
			
			if ($radius != "") {
				$radius = explode('-',$radius);
				$start = $radius[0];
				$end = $radius[1];
								
				$query = "SELECT CONCAT(U.sFirstName, ' ', U.sLastName) as artist_name, U.sUserName, U.iZipcode, 
			U.sUserName, U.sProfileName, U.iLoginID, U.sUserName, U.iGiftID, C.name as cityname, CN.sortname as statename, ROUND( 6371  * acos( cos( radians(23.038964) ) * cos( radians( sLatitude ) ) 
			 			  * cos( radians( sLongitude ) - radians(72.569020) ) + sin( radians(23.038964) ) * sin( radians( sLatitude ) ))) AS distance FROM $this->_database.usermaster U LEFT JOIN $this->_database.cities C ON 
			U.sCityName = C.id LEFT JOIN $this->_database.countries CN ON U.sCountryName = CN.id
			WHERE U.sUserType = 'artist' GROUP BY iLoginID HAVING distance BETWEEN $start AND $end ORDER BY distance ";
				  
			} else {
			
			$query = "SELECT CONCAT(U.sFirstName, ' ', U.sLastName) as artist_name, U.sUserName, U.iZipcode, 
			U.sUserName, U.sProfileName, U.iLoginID, U.sUserName, U.iGiftID, C.name as cityname, CN.sortname as statename, FORMAT((iTotalPoint / rating_number),1) as average_rating 
			FROM $this->_database.usermaster U LEFT JOIN $this->_database.cities C ON 
			U.sCityName = C.id LEFT JOIN $this->_database.countries CN ON U.sCountryName = CN.id
			LEFT JOIN  $this->_database.userratting UR ON U.iLoginID = UR.iUserID
			WHERE U.sUserType = 'artist' AND 1 = 1";
							
				if (isset($state) && $state) { 
					$query .= " AND U.sStateName = $state";
				}
	
				if (isset($city) && $city) { 
					$query .= " AND U.sCityName = $city";
				}
				
				if (isset($zip) && $zip) { 
					$query .= " AND U.iZipcode = $zip";
				}
				
				if (isset($artist_type) && $artist_type != 'all' && $artist_type != "") { 
					$query .= " AND U.iGiftID REGEXP '$artist_type'";
				}
				
				if (isset($gift) && $gift != 'all' && $gift != "") { 
					$query .= " AND U.iGiftID REGEXP '$gift' ";
				}
				
				
				if (isset($avaibility) && $avaibility) { 
					$query .= " AND U.sAvailability = '$avaibility'";
				}
				
				if (isset($artist_name) && $artist_name) { 
					
					$str = explode(" ",$artist_name);
					
					if	(count($str) > 1)	{
						
						$query .= " AND sFirstName LIKE '%".$str[0]."%' OR sLastName LIKE '%".$str[1]."%'";
						
					}	else{
						
						$query .= " AND sFirstName LIKE '%".$str[0]."%' OR sLastName LIKE '%".$str[0]."%'";
						
					}
					
					//$query .= " AND CONCAT(U.sFirstName, ' ', U.sLastName) LIKE '%" . $artist_name . "%'";
				}
				
				if (isset($iViews) && $iViews) { 
					
					$iViews = explode('-',$iViews);
					$start = $iViews[0];
					$end = $iViews[1];
					
					$query .= " AND U.iTotalVideoRate BETWEEN $start AND $end";
				}
				
				if (isset($rateFilter) && $rateFilter ) { 
					
					$rateFilter = round($rateFilter);
					
					$query .= " AND iRateAvg = $rateFilter";
				}
				
				$query .= " GROUP BY iLoginID ";
			}
				
			
			if (isset($page) && $page) {
				$page = ($page + 1) * 20;
				$query .= " limit $page, 20";
			}
			else
			{
				$page = (0 + 1) * 20;				
				$query .= " limit $page, 20";
			}
			//echo $query;
			$rs = mysql_query(trim($query));
			//$num = mysql_num_rows($rs);
			//$totalCount = $num;
			$result = array();
			if ($rs) {
				while ($rows = mysql_fetch_assoc($rs)){
					$result[] = $rows;
				}
			}
			return $result;

		}catch(Exception $e){

			echo $e->getMessage();

		}
	}
	
	public function fetchSearchedArtist($postData){

		extract($postData);
		try{
			
			if ($radius != "") {
				$radius = explode('-',$radius);
				$start = $radius[0];
				$end = $radius[1];
								
				$query = "SELECT CONCAT(U.sFirstName, ' ', U.sLastName) as artist_name, U.sUserName, U.iZipcode, 
			U.sUserName, U.sProfileName, U.iLoginID, U.sUserName, U.iGiftID, C.name as cityname, SN.statecode as statename, U.iTotalUserRate, ROLL.sGroupType,ROLL.sGropName, ROUND( 6371  * acos( cos( radians(23.038964) ) * cos( radians( sLatitude ) ) 
			 			  * cos( radians( sLongitude ) - radians(72.569020) ) + sin( radians(23.038964) ) * sin( radians( sLatitude ) ))) AS distance FROM $this->_database.usermaster U 
			LEFT JOIN $this->_database.cities C ON U.sCityName = C.id LEFT JOIN $this->_database.states SN ON U.sStateName = SN.id
			LEFT JOIN $this->_database.rollmaster ROLL ON U.iLoginID = ROLL.iLoginID 
			WHERE U.sUserType = 'artist' AND U.isActive='1' GROUP BY iLoginID  HAVING distance BETWEEN $start AND $end ORDER BY distance ";
				  
			} else {
			
			//FORMAT((iTotalUserRate / rating_number),1) as average_rating
			
			$query = "SELECT CONCAT(U.sFirstName, ' ', U.sLastName) as artist_name, U.sUserName, U.iZipcode, 
			U.sUserName, U.sProfileName, U.iLoginID, U.sUserName, U.iGiftID, C.name as cityname, SN.statecode as statename, U.iTotalUserRate, ROLL.sGroupType,ROLL.sGropName
			FROM $this->_database.usermaster U LEFT JOIN $this->_database.cities C ON 
			U.sCityName = C.id LEFT JOIN $this->_database.states SN ON U.sStateName = SN.id
			LEFT JOIN  $this->_database.userratting UR ON U.iLoginID = UR.iUserID
			LEFT JOIN  $this->_database.rollmaster ROLL ON U.iLoginID = ROLL.iLoginID
			WHERE U.sUserType = 'artist' AND U.isActive='1' AND 1 = 1";
							
				if (isset($state) && $state) { 
					$query .= " AND U.sStateName = $state";
				}
	
				if (isset($city) && $city) { 
					$query .= " AND U.sCityName = $city";
				}
				
				if (isset($zip) && $zip) { 
					$query .= " AND U.iZipcode = $zip";
				}
				
				if (isset($artist_type) && $artist_type != 'all' && $artist_type != "") { 
					
					if ( $artist_type == 'group') {
						$query .= " AND ROLL.sGroupType = '$artist_type'";
					} else {
						$query .= " AND U.iGiftID REGEXP '$artist_type'";
					}
					
				}
				
				if (isset($gift) && $gift != 'all' && $gift != "") { 
					
					if ( $gift == 'group') {
						$query .= " AND ROLL.sGroupType = '$gift'";
					} else {
						$query .= " AND U.iGiftID REGEXP '$gift' ";
					}
				}
				
				
				if (isset($avaibility) && $avaibility) { 
					$query .= " AND U.sAvailability = '$avaibility'";
				}
				
				if (isset($artist_name) && $artist_name) { 
					
					$str = explode(" ",$artist_name);
					
					if	(count($str) > 1)	{
						
						$query .= " AND sFirstName LIKE '%".$str[0]."%' AND sLastName LIKE '%".$str[1]."%'";
				
						
					}	else{
						
						$query .= " AND sFirstName LIKE '%".$str[0]."%' OR sLastName LIKE '%".$str[0]."%'";
				
						
					}
					
					//$query .= " AND CONCAT(U.sFirstName, ' ', U.sLastName) LIKE '%" . $artist_name . "%'";
				}
				
				if (isset($iViews) && $iViews) { 
					
					$iViews = explode('-',$iViews);
					$start = $iViews[0];
					$end = $iViews[1];
					
					$query .= " AND U.iTotalVideoRate BETWEEN $start AND $end";
				}
				
				if (isset($rateFilter) && $rateFilter ) { 
					
					
					$rateFilter = round($rateFilter);

					
					$query .= " AND U.iRateAvg = $rateFilter";
				}
				
				$query .= " GROUP BY iLoginID ";
			}
					
			
			if (isset($page) && $page) {
				$page = $page * 20;
				$query .= " limit $page, 20";
			}
			else
			{
				$page = 0;				
				$query .= " limit $page, 20";
			}
			//echo $query;
			$rs = mysql_query(trim($query));
			$num = mysql_num_rows($rs);
			$totalCount = $num;
			$result = array();
			if ($rs) {
				while ($rows = mysql_fetch_assoc($rs)){
					$result[] = $rows;
				}
			}
			return $result;

		}catch(Exception $e){

			echo $e->getMessage();

		}
	}
	
	public function fetchSearchedChurchLimit($postData){
		extract($postData);
		try{
			
			if ($radius != "") {
				$radius = explode('-',$radius);
				$start = $radius[0];
				$end = $radius[1];
								
				$query = "SELECT U.sUserName, U.sChurchName, U.sPastorName, U.sAddress, U.sProfileName, U.iZipcode,
				U.iLoginID, CM.sTitle, CM.iHour, CM.iMinute, C.name as cityname, CN.sortname as statename, ROUND( 6371  * acos( cos( radians(23.038964) ) * cos( radians( sLatitude ) ) 
			 			  * cos( radians( sLongitude ) - radians(72.569020) ) + sin( radians(23.038964) ) * sin( radians( sLatitude ) ))) AS distance FROM $this->_database.usermaster U 
				LEFT JOIN  $this->_database.churchtimeing CM ON	U.iLoginID = CM.iLoginID			
				LEFT JOIN $this->_database.cities C ON U.sCityName = C.id 
				LEFT JOIN $this->_database.countries CN ON U.sCountryName = CN.id
				LEFT JOIN  $this->_database.churchministrie CMI 
				ON 	U.iLoginID = CMI.iLoginID WHERE U.sUserType = 'church' AND U.isActive='1' GROUP BY iLoginID HAVING distance BETWEEN $start AND $end ORDER BY distance ";
				  
			} else {
				
			$query = "SELECT U.sUserName, U.sChurchName, U.sPastorName, U.sAddress, U.sProfileName, U.iZipcode,
				U.iLoginID, CM.sTitle, CM.iHour, CM.iMinute, C.name as cityname, CN.sortname as statename 
				FROM $this->_database.usermaster U 
				LEFT JOIN  $this->_database.churchtimeing CM ON	U.iLoginID = CM.iLoginID			
				LEFT JOIN $this->_database.cities C ON U.sCityName = C.id 
				LEFT JOIN $this->_database.countries CN ON U.sCountryName = CN.id
				LEFT JOIN  $this->_database.churchministrie CMI 
				ON 	U.iLoginID = CMI.iLoginID WHERE U.sUserType = 'church' AND U.isActive='1' AND 1 = 1";
			
			
				
				if (isset($state) && $state) { 
					$query .= " AND U.sStateName = $state";
				}
	
				if (isset($city) && $city) { 
					$query .= " AND U.sCityName = $city";
				}
				
				if (isset($zip) && $zip) { 
					$query .= " AND U.iZipcode = $zip";
				}
				
				
				if (!empty($ministries) && $ministries) { 
					$ministries = implode(',',$ministries);
					$query .= " AND FIND_IN_SET(CMI.sMinistrieName,'$ministries')";
				}
				
				if (!empty($amenitis) && $amenitis) { 
					$amenitis = implode(',',$amenitis);
					$query .= " AND FIND_IN_SET(U.sAmenitis,'$amenitis')";
				}
				
				
				if (isset($denomination) && $denomination) { 
					$query .= " AND FIND_IN_SET(U.sDenomination,'$denomination')";
				}
	
				if (isset($churchname) && $churchname) { 
					$query .= " AND U.sChurchName LIKE '%$churchname%'";
				}
				
				if (isset($street_name) && $street_name) { 
					$query .= " AND U.sAddress LIKE '%$street_name%'";
				}
				
				if (isset($pastorname) && $pastorname) { 
					$query .= " AND U.sPastorName LIKE '%$pastorname%'";
				}
				
				if (isset($sTitle) && $sTitle) { 
					$query .= " AND CM.sTitle = '%$sTitle%'";
				}
				
				if (isset($services) && $services) {
					 
					$time = explode(':',$services);
					$minute = substr($time[1], 0, -3);
					$hour = str_pad($time[0], 2, '0', STR_PAD_LEFT);
					
					$query .= " AND (CM.iHour = '$hour' AND CM.iMinute = $minute)";
				}
				
				$query .= " GROUP BY iLoginID ";
			}
					
			
			if (isset($page) && $page) {
				$page = ($page + 1) * 20;
				$query .= " limit $page, 20";
			}
			else
			{
				$page = (0 + 1) * 20;				
				$query .= " limit $page , 20";
			}
			//echo $query;
			$rs = mysql_query(trim($query));
			$result = array();
			if ($rs) {
				while ($rows = mysql_fetch_assoc($rs)){
					$result[] = $rows;
				}
			}
			return $result;

		}catch(Exception $e){

			echo $e->getMessage();

		}
	}
	
	public function fetchSearchedChurch($postData){
		extract($postData);
		try{
			
			if ($radius != "") {
				$radius = explode('-',$radius);
				$start = $radius[0];
				$end = $radius[1];
								
				$query = "SELECT U.sUserName, U.sChurchName, U.sPastorName, U.sAddress, U.sProfileName, U.iZipcode,
				U.iLoginID, CM.sTitle, CM.iHour, CM.iMinute, CM.ampm, C.name as cityname, SN.statecode as statename, ROUND( 6371  * acos( cos( radians(23.038964) ) * cos( radians( sLatitude ) ) 
			 			  * cos( radians( sLongitude ) - radians(72.569020) ) + sin( radians(23.038964) ) * sin( radians( sLatitude ) ))) AS distance FROM $this->_database.usermaster U 
				LEFT JOIN  $this->_database.churchtimeing CM ON	U.iLoginID = CM.iLoginID			
				LEFT JOIN $this->_database.cities C ON U.sCityName = C.id 
				LEFT JOIN $this->_database.states SN ON U.sStateName = SN.id
				LEFT JOIN  $this->_database.churchministrie CMI 
				ON 	U.iLoginID = CMI.iLoginID WHERE U.sUserType = 'church' AND U.isActive='1' GROUP BY U.iLoginID HAVING distance BETWEEN $start AND $end ORDER BY distance ";
				  
			} else {
				
			$query = "SELECT U.sUserName, U.sChurchName, U.sPastorName, U.sAddress, U.sProfileName, U.iZipcode,
				U.iLoginID, CM.sTitle, CM.iHour, CM.iMinute, CM.ampm, C.name as cityname, SN.statecode as statename 
				FROM $this->_database.usermaster U 
				LEFT JOIN  $this->_database.churchtimeing CM ON	U.iLoginID = CM.iLoginID			
				LEFT JOIN $this->_database.cities C ON U.sCityName = C.id 
				LEFT JOIN $this->_database.states SN ON U.sStateName = SN.id
				LEFT JOIN  $this->_database.churchministrie CMI 
				ON 	U.iLoginID = CMI.iLoginID WHERE U.sUserType = 'church' AND U.isActive='1' AND 1 = 1";
				

				if (isset($state) && $state) { 
					$query .= " AND U.sStateName = $state";
				}
	
				if (isset($city) && $city) { 
					$query .= " AND U.sCityName = $city";
				}
				
				if (isset($zip) && $zip) { 
					$query .= " AND U.iZipcode = $zip";
				}
				
				
				if (!empty($ministries) && $ministries) { 
					$ministries = implode(',',$ministries);
					
					$query .= " AND FIND_IN_SET(CMI.sMinistrieName,'$ministries')";
				}
				
				if (!empty($amenitis) && $amenitis) { 
					//$amenitis = implode(',',$amenitis);
					
					$query .= " AND (";
					
					foreach ($amenitis as $key ) {
						$query .= "FIND_IN_SET('$key',U.sAmenitis) AND ";
					}										
					$query = rtrim($query,"AND ");
					
					$query .= ")";
					
				}
				
				
				if (isset($denomination) && $denomination) { 
					$query .= " AND FIND_IN_SET(U.sDenomination,'$denomination')";
				}
	
				if (isset($churchname) && $churchname) { 

					$church_name = explode(" ",$churchname);
					
					if	(count($church_name) > 1)	{
						
						$query .= " AND U.sChurchName LIKE '%".$church_name[0]."%'";
				
						
					}	else{
						
						$query .= " AND U.sChurchName LIKE '%".$church_name[0]."%'";
				
						
					}
					$query .= " AND U.sChurchName LIKE '%$churchname%'";
				}
				
				if (isset($street_name) && $street_name) { 

						$strt_name = explode(" ",$street_name);
					
					if	(count($strt_name) > 1)	{
						
						$query .= " AND U.sAddress LIKE '%".$strt_name[0]."%'";
				
						
					}	else{
						
						$query .= " AND U.sAddress LIKE '%".$strt_name[0]."%'";
				
						
					}
					//$query .= " AND U.sAddress LIKE '%$street_name%'";
				}
				
				if (isset($pastorname) && $pastorname) { 

						$p_name = explode(" ",$pastorname);
					
					if	(count($p_name) > 1)	{
						
						$query .= " AND U.sPastorName LIKE '%".$p_name[0]."%'";
				
						
					}	else{
						
						$query .= " AND U.sPastorName LIKE '%".$p_name[0]."%'";
				
						
					}
					//$query .= " AND U.sPastorName LIKE '%$pastorname%'";
				}
				
				if (isset($sTitle) && $sTitle) { 
					$query .= " AND CM.sTitle = '$sTitle'";
				}
				
				if (isset($services) && $services) {
					
					$time = explode(':',$services);
					$minute = substr($time[1], 0, -3);
					$appm = explode(' ',$time[1]);
					$ampm = strtolower($appm[1]);
					$hour = str_pad($time[0], 1, '0', STR_PAD_LEFT);
					$minute = str_pad($minute, 1, '0', STR_PAD_LEFT);
					
					$query .= " AND (CM.iHour = '$hour' AND CM.iMinute = $minute AND CM.ampm = '$ampm')";
				}
				
				$query .= " GROUP BY U.iLoginID ";
			}
			
			
			if (isset($page) && $page) {
				$page = $page * 20;
				$query .= " limit $page, 20";
			}
			else
			{
				$page = 0;				
				$query .= " limit $page, 20";
			}
			//echo $query;
			$rs = mysql_query(trim($query));
			$result = array();
			if ($rs) {
				while ($rows = mysql_fetch_assoc($rs)){
					$result[] = $rows;
				}
			}
			return $result;

		}catch(Exception $e){

			echo $e->getMessage();

		}
	}
	
	public function fetchSearchedEventLimit($postData){
		extract($postData);
		try{
			
			if ($radius != "") {
				$radius = explode('-',$radius);
				$start = $radius[0];
				$end = $radius[1];
								
				$query = "SELECT E.*, ROUND( 6371  * acos( cos( radians(23.038964) ) * cos( radians( sLatitude ) ) 
			 			  * cos( radians( sLongitude ) - radians(72.569020) ) + sin( radians(23.038964) ) * sin( radians( sLatitude ) ))) AS distance FROM $this->_database.eventmaster E HAVING distance BETWEEN $start AND $end ORDER BY distance ";
				  
			}
			else{
			
				$query = "SELECT E.* FROM $this->_database.eventmaster E WHERE 1 = 1";
				
				if (isset($state) && $state) { 
					$query .= " AND E.state = $state";
				}
	
				if (isset($city) && $city) { 
					$query .= " AND E.city = $city";
				}
				
				if (isset($zip) && $zip) { 
					$query .= " AND E.zipcode = $zip";
				}
						
				if (isset($event_type) && $event_type) { 
					$query .= " AND E.sType = $event_type";
				}
	
				if (isset($month) && $month) { 
					$query .= " AND MONTH(E.doe) = $month";
				}
				
				if (isset($title) && $title) { 
					$query .= " AND E.event_name LIKE '%$title%'";
				}
				
				if (isset($gift) && $gift != 'all' && $gift > 0) { 
					$query .= " AND E.sType = '$gift'";
				}
				
				if (isset($sponsor) && $sponsor) { 
					$query .= " AND eSponsor LIKE '%".$sponsor."%'";
				}
			}
			
			$query .= " AND DATE(E.doe) >= '".date('Y-m-d')."'";
			
			if (isset($page) && $page) {
				$page = ($page + 1) * 20;
				$query .= " limit $page, 20";
			}
			else
			{
				$page = (0 + 1) * 20;				
				$query .= " limit $page, 20";
			}
			//	echo $query;
			$rs = mysql_query(trim($query));
			$result = array();
			if ($rs) {
				while ($rows = mysql_fetch_assoc($rs)){
					$result[] = $rows;
				}
			}
			return $result;

		}catch(Exception $e){

			echo $e->getMessage();

		}
	}
	
	public function fetchSearchedEvent($postData){
		extract($postData);
		try{
			
			if ($radius != "") {
				$radius = explode('-',$radius);
				$start = $radius[0];
				$end = $radius[1];
								
				$query = "SELECT E.*, ROUND( 6371  * acos( cos( radians(23.038964) ) * cos( radians( sLatitude ) ) 
			 			  * cos( radians( sLongitude ) - radians(72.569020) ) + sin( radians(23.038964) ) * sin( radians( sLatitude ) ))) AS distance FROM $this->_database.eventmaster E WHERE DATE(E.doe) >= '".date('Y-m-d')."' HAVING distance BETWEEN $start AND $end ORDER BY distance ";
				  
			}
			else{
			
				$query = "SELECT E.* FROM $this->_database.eventmaster E WHERE 1 = 1";
				
				if (isset($state) && $state) { 
					$query .= " AND E.state = $state";
				}
	
				if (isset($city) && $city) { 
					$query .= " AND E.city = $city";
				}
				
				if (isset($zip) && $zip) { 
					$query .= " AND E.zipcode = $zip";
				}
						
				if (isset($event_type) && $event_type) { 
					$query .= " AND E.sType = $event_type";
				}
	
				if (isset($month) && $month) { 
					$query .= " AND MONTH(E.doe) = $month";
				}
				
				if (isset($title) && $title) { 
					$query .= " AND E.event_name LIKE '%$title%'";
				}
				
				if (isset($gift) && $gift != 'all' && $gift > 0) { 
					$query .= " AND E.sType = '$gift'";
				}
				
				if (isset($sponsor) && $sponsor) { 
					$query .= " AND eSponsor LIKE '%".$sponsor."%'";
				}
				
				if (isset($when) && $when) { 
					$query .= " AND E.doe = '$when'";
				}
			}
			
			$query .= " AND DATE(E.doe) >= '".date('Y-m-d')."'";
			
			if (isset($page) && $page) {
				$page = $page * 20;
				$query .= " limit $page, 20";
			}
			else
			{
				$page = 0;				
				$query .= " limit $page, 20";
			}
			//	echo $query;
			$rs = mysql_query(trim($query));
			$result = array();
			if ($rs) {
				while ($rows = mysql_fetch_assoc($rs)){
					$result[] = $rows;
				}
			}
			return $result;

		}catch(Exception $e){

			echo $e->getMessage();

		}
	}
	
	public function groupValue($table,$id,$cond){
		
		try{
			if($table != ""){
				
				$this->_table = $table;		
			
				$query = "SELECT GROUP_CONCAT($id) as groupvalue FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
				$rs = mysql_query($query);
				$num = mysql_num_rows($rs);
				if($num > 0){
					return mysql_fetch_array($rs);
				}else{
					return NULL;	
				}
			}else{
				throw new Exception("Please fill the table name.");
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}