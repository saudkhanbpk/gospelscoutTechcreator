<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/common/config.php';
$artistList = $obj->fetchSearchedArtist($_GET);

$artistListHtml = getArtistListHtml($artistList);
echo $artistListHtml; 
exit;
?>