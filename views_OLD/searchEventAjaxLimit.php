<?phpinclude('../common/config.php');
$eventListLimit = $obj->fetchSearchedEventLimit($_GET);
echo count($eventListLimit); exit;
?>