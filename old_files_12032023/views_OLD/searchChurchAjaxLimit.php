<?phpinclude('../common/config.php');
$churchListLimit = $obj->fetchSearchedChurchLimit($_GET);
echo count($churchListLimit); 
exit;
?>