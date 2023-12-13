<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/common/config.php';
$artistListLimit = $obj->fetchSearchedArtistLimit($_GET);
echo count($artistListLimit); 
exit;
?>