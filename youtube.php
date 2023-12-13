 <?php 
$video_ID = "7lCDEYXw3mM";
$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&key=AIzaSyBSi0Rj3Q74r6WfzLyqeNSOMyan5cmubPM&part=statistics");
$json = json_decode($jsonURL);

$views = $json->{'items'}[0]->{'statistics'}->{'viewCount'};
echo $title = $json->{'items'}[0]->{'statistics'}->{'title'};
echo number_format($views,0,'.',',');
?>