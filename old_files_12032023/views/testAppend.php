<?php 
	/* Video Display Page */

		$page = 'aProfile';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');


	/* Query Database for artist Video info based on the talent passed in $_GET['tal'] */

		$artistUserID = '258'; // $_GET['artistID'];
		$talent = 'Drummers'; //$_GET['tal'];
		$query1 = 'SELECT artistvideomaster.*, giftmaster.sGiftName, usermaster.sFirstName, usermaster.sLastName
				  FROM artistvideomaster
				  INNER JOIN giftmaster on artistvideomaster.videoTalentID = giftmaster.iGiftID
				  INNER JOIN usermaster on artistvideomaster.iLoginID = usermaster.iLoginID
				  WHERE artistvideomaster.iLoginID = ?  AND giftmaster.sGiftName = ?
				';
		try{
			$vidArray = $db->prepare($query1);
			$vidArray->bindParam(1, $artistUserID);
			$vidArray->bindParam(2, $talent); 
			$vidArray->execute();
		}
		catch(Exception $e){
			echo $e; 
		}
		$result = $vidArray->fetchAll(PDO::FETCH_ASSOC);
	/* END - Query Database for artist Video info based on the talent passed in $_GET['tal'] */
	// echo '<pre>';
	// var_dump($result);
?>

<input type="hidden" name="named" value="<?php echo $result[0]['sFirstName'];?>">
<input type="hidden" name="talent" value="<?php echo $result[0]['sGiftName'];?>">
<div class="container mt-5" id="testAppend">
	<p><?php echo $result[0]['sGiftName'];?></p>
	<!-- Append Here -->
</div>


<?php 
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); 
 	// include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomePage/views/testJS.php'); 
 	// require('testJS.js');
?>
<script type="text/javascript" src="<?php echo URL;?>newHomePage/views/testJS.js"></script>
<script>
	data = {

		'name': $('input[name=named]').val(),
		'talent': $('input[name=talent]').val()
	}
	console.log(data.name);

	var codeing = AppendFunct(data);
	// console.log(codeing);
	// document.getElementById('testAppend').innerHTML = codeing;
	$('#testAppend').append(codeing); 
</script>
