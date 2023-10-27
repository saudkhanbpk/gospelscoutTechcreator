


<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	 include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
	 // echo URL; 
	?>

    <title>Video.js | HTML5 Video Player</title>
    <!--<link href="http://vjs.zencdn.net/5.19/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/ie8/1.1/videojs-ie8.min.js"></script>
    <script src="http://vjs.zencdn.net/5.19/video.js"></script>-->	

   	<link href="<?php echo URL;?>newHomePage/node_modules/video.js/dist/video-js.css" rel="stylesheet"> 	
	<script src="<?php echo URL;?>newHomePage/node_modules/video.js/dist/ie8/videojs-ie8.min.js"></script>
	<script src="../node_modules/video.js/dist/video.js"></script>	

</head>
<body>

  <video id="example_video_1" class="video-js vjs-default-skin" preload="none" width="640" height="264" poster="" data-setup='{"controls":true}'>
    <!-- <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4"> controls -->
    <source src="1096HighlightClipNoMatter.mp4" type="video/mp4">
    <!-- <source src="http://vjs.zencdn.net/v/oceans.webm" type="video/webm">
    <source src="http://vjs.zencdn.net/v/oceans.ogv" type="video/ogg"> -->
    <track kind="captions" src="../node_modules/video.js/dist/examples/shared/example-captions.vtt" srclang="en" label="English"></track>
    <!-- Tracks need an ending tag thanks to IE9 -->
    <track kind="subtitles" src="../node_modules/video.js/dist/examples/shared/example-captions.vtt" srclang="en" label="English"></track>
    <!-- Tracks need an ending tag thanks to IE9 -->
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="" target="_blank">supports HTML5 video</a></p>
  </video>

</body>

</html>