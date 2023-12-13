<?php include('../common/config.php');


extract($_POST);

$cond = " sUserType != 'user' ";

if ($name != "") {
	$cond .= " AND sUserName LIKE '%".$name."%'";
}

/*
if ($name != "") {
	$cond .= " OR clientname LIKE '%".$name."%'";
}

if ($name != "") {
	$cond .= " OR regono = '".$name."')";
}*/

$loaddata = $obj->fetchRowAll('usermaster',$cond);
$totalloaddata = $obj->fetchNumOfRow('usermaster',$cond);

	if($totalloaddata > 0){
		
		echo "<ul>";
		
		for($v=0;$v<count($loaddata);$v++)
		{
		
		?>
		<li onclick='fill("<?php echo $loaddata[$v]['sUserName'] ?>","<?php echo $loaddata[$v]['iLoginID']; ?>","<?php echo $loaddata[$v]['sUserType']; ?>")'>
			<?php echo $loaddata[$v]['sUserName']; ?></li>
		
		<?php 
		}
		
		echo "</ul>";
	}
?>
