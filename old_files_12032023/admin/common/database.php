<?php
/*********************************************
Corrtrade - Database Class
Date - 04-April-2016 05:10 
**********************************************/

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
		if(define('USER','gospelsc_user')){
			$this->_username = USER;	
		}
		if(define('PASSWORD',"Gg@123456")){
			$this->_password = PASSWORD;
		}
		if(define('DATABASE','gospelsc_db651933262')){
			$this->_database = DATABASE;
		}
		
		$connect = @mysql_connect($this->_hostname,$this->_username,$this->_password);
		if(!$connect)
		die('Enable to connect in MySqL Server.');
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

				$query = "SELECT * FROM `".$this->_database."`.`".$this->getTable()."` INNER JOIN ".$table2." ON ".$table.".".$common." = ".$table2.".".$common." ".$where;
				$rs = mysql_query($query);
				if(empty($rs))
				{
					echo mysql_error();
				}
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
	
	function getConcateValue($table,$id,$cond){

		try{
			
			if($table != "")$this->_table = $table;
			
			if	($cond == "") {
				$cond = "1 = 1";
			}				
			
			$query = "SELECT GROUP_CONCAT(".$id.") as ROLL FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
			$rs = mysql_query($query);

			if($rs){
				
				return mysql_fetch_assoc($rs);
				
			}else{

				throw new Exception("Check your pass parameter");

			}
			
		}catch(Exception $e){

			echo $e->getMessage();

		}	
	}
	
	function getTotalNetWeight($table,$id,$cond){

		try{
			
			if($table != "")$this->_table = $table;
			
			if	($cond == "") {
				$cond = "1 = 1";
			}				
			
			$query = "SELECT SUM(".$id.") as TOTAL FROM `".$this->_database."`.`".$this->getTable()."` WHERE ".$cond;
			$rs = mysql_query($query);

			if($rs){
				
				return mysql_fetch_assoc($rs);
				
			}else{

				throw new Exception("Please check your email id or password");

			}
			
		}catch(Exception $e){

			echo $e->getMessage();

		}	
	}
}
