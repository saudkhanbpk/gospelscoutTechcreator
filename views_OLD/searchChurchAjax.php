<?php include('../common/config.php');
$churchList = $obj->fetchSearchedChurch($_GET);
$churchListHtml = getChurchListHtml($churchList);
echo $churchListHtml; 
exit;
?>