<?php include('../common/config.php');
$eventList = $obj->fetchSearchedEvent($_GET);
$eventListHtml = getEventListHtml($eventList);
echo $eventListHtml; 
exit;
?>