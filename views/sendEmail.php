<?php 
	/* Send Email */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/Composer1/vendor/autoload.php');
		use Postmark\PostmarkClient; 
		use Postmark\PostmarkAdminClient; 
		use Postmark\Models\PostmarkException;

	/* If $_POST['gigManID'] == $_POST['artistID'] Receiver is the Gig Manager */
		if($_POST['gigManID'] == $_POST['artistID']){
			$_POST['receiverTalent'] = 'N/A';
			$_POST['artistName'] = 'Gig Manager';
			echo 'test';
		}

	/* Use Post Mark API to send emails */
		$trueSender = $_POST['trueSenderEmail']; 
		$trueSenderName = $_POST['trueSenderName'];
		$trueSenderTalent = $_POST['trueSenderTalent'];
		$trueSenderGigStatus = $_POST['trueSenderGigStatus'];
		// $receiver = $_POST['artistEmail'];
		$receiver = 'kirkddrummond@yahoo.com';
		$receiverName = $_POST['artistName'];
		$emailSubject = $_POST['emailSubject'];
		$emailContent = trim($_POST['gigArtists_gigManCancelReason']);
		$gigId = $_POST['gigId'];
		$gigName = $_POST['gigName'];
		$receiverTalent = $_POST['receiverTalent'];
		
		generalComms($trueSender, $trueSenderName, $trueSenderTalent, $trueSenderGigStatus, $receiver, $receiverName, $emailSubject, $emailContent, $gigId, $gigName, $receiverTalent);		
?>