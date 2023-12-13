<?php 
		/* Video Display - Database Update Page  */

		/* Create DB connection to Query Database for Artist info */
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
			include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
		
		if(!empty($_GET)){
			if($_GET['likes'] || $_GET['c_likes']){
				if($_GET['likes']){
					/* Like-Button functionality 4 artist videos */
						$field = array('videoLikes');
						$cond = 'id = ' . $_GET['vidID'];
						$table = 'artistvideomaster';
						$likes = $obj->fetchFieldAll($table,$field,$cond);

						$newLikes = $likes[0]['videoLikes'] + 1;
						$value = array($newLikes);
						$obj->update($field,$value,$cond,$table);

						$nlikes = $obj->fetchFieldAll($table,$field,$cond);
						echo $nlikes[0]['videoLikes'];
				}
				elseif($_GET['c_likes']){
					/* Like-Button functionality 4 church videos */
						$field = array('videoLikes');
						$cond = 'id = ' . $_GET['vidID'];
						$table = 'churchvideomaster';
						$likes = $obj->fetchFieldAll($table,$field,$cond);

						$newLikes = $likes[0]['videoLikes'] + 1;
						$value = array($newLikes);
						$obj->update($field,$value,$cond,$table);

						$nlikes = $obj->fetchFieldAll($table,$field,$cond);
						echo $nlikes[0]['videoLikes'];
				}
			}
			elseif($_GET['views'] || $_GET['c_views']){
				if($_GET['views']){
					/* # of artist video Views Display Functionality */
						$field = array('videoViews');
						$cond = 'id = ' . $_GET['vidID'];
						$table = 'artistvideomaster';
						$Views = $obj->fetchFieldAll($table,$field,$cond);

						$newViews = $Views[0]['videoViews'] + 1;
						$value = array($newViews);
						$obj->update($field,$value,$cond,$table);

						$nViews = $obj->fetchFieldAll($table,$field,$cond);
						echo $nViews[0]['videoViews'];
				}
				elseif($_GET['c_views']){
					/* # of church video Views Display Functionality */
						$field = array('videoViews');
						$cond = 'id = ' . $_GET['vidID'];
						$table = 'churchvideomaster';
						$Views = $obj->fetchFieldAll($table,$field,$cond);

						$newViews = $Views[0]['videoViews'] + 1;
						$value = array($newViews);
						$obj->update($field,$value,$cond,$table);

						$nViews = $obj->fetchFieldAll($table,$field,$cond);
						echo $nViews[0]['videoViews'];
				}
			}	
			elseif($_GET['getComments']){

				if($_GET['repliesTo'] || $_GET['c_repliesTo']){

					if($_GET['repliesTo']){
						$vidId = $_GET['vidId'];
						$commentID = $_GET['repliesTo'];
						$commentQuery = 'SELECT videocommentreplies.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName
										 FROM videocommentreplies
										 INNER JOIN usermaster on videocommentreplies.iLoginID = usermaster.iLoginID
										 WHERE videocommentreplies.videoID = ? AND videocommentreplies.iReplyTo = ?
										 ORDER BY videocommentreplies.dateTime ASC'; 

						try{
							$getReplies = $db->prepare($commentQuery);
							$getReplies->bindParam(1, $vidId);
							$getReplies->bindParam(2, $commentID);
							$getReplies->execute(); 

						}
						catch(Exception $e){
							echo $e; 
						}
						$allReplies = $getReplies->fetchAll(PDO::FETCH_ASSOC);

						/* Display user Comment Replies */
							echo '<replies>';
								foreach($allReplies as $eachReply){
?>							
									<reply>
										<iCommentID><?php echo $eachReply['iCommentID'];?></iCommentID>
										<sComment><?php echo $eachReply['sComment'];?></sComment>
										<iReplyTo><?php echo $eachReply['iReplyTo'];?></iReplyTo>
										<iLoginID><?php echo $eachReply['iLoginID'];?></iLoginID>
										<dateTime><?php echo $eachReply['dateTime'];?></dateTime>
										<sProfileName><?php echo $eachReply['sProfileName'];?></sProfileName>
										<sFirstName><?php echo $eachReply['sFirstName'];?></sFirstName>
									</reply>
<?php					
								}	
							echo '</replies>';
						/* END - Display user Comment Replies */
					}
					elseif($_GET['c_repliesTo']){

						$vidId = $_GET['vidId'];
						$commentID = $_GET['c_repliesTo'];
						$commentQuery = 'SELECT churchvideocommentreplies.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName
										 FROM churchvideocommentreplies
										 INNER JOIN usermaster on churchvideocommentreplies.iLoginID = usermaster.iLoginID
										 WHERE churchvideocommentreplies.videoID = ? AND churchvideocommentreplies.iReplyTo = ?
										 ORDER BY churchvideoCommentreplies.dateTime ASC'; 

						try{
							$getReplies = $db->prepare($commentQuery);
							$getReplies->bindParam(1, $vidId);
							$getReplies->bindParam(2, $commentID);
							$getReplies->execute(); 
						}
						catch(Exception $e){
							echo $e; 
						}
						$allReplies = $getReplies->fetchAll(PDO::FETCH_ASSOC);

						/* Display user Comment Replies */
							echo '<replies>';
								foreach($allReplies as $eachReply){
?>							
									<reply>
										<iCommentID><?php echo $eachReply['iCommentID'];?></iCommentID>
										<sComment><?php echo $eachReply['sComment'];?></sComment>
										<iReplyTo><?php echo $eachReply['iReplyTo'];?></iReplyTo>
										<iLoginID><?php echo $eachReply['iLoginID'];?></iLoginID>
										<dateTime><?php echo $eachReply['dateTime'];?></dateTime>
										<sProfileName><?php echo $eachReply['sProfileName'];?></sProfileName>
										<sFirstName><?php echo $eachReply['sFirstName'];?></sFirstName>
									</reply>
<?php					
								}	
							echo '</replies>';
						/* END - Display user Comment Replies */
					}
				}
			}
			elseif($_GET['deleteComment']){
				if($_GET['deleteComment'] == 'artist'){
					/* Remove $_GET['deleteComment'] from $_GET aray */
						unset($_GET['deleteComment']);

					/* Remove the Comment from the DB */
						$cond = 'iCommentID = ' . $_GET['iCommentID'];
						$table = 'videocomments';
						$obj->delete($table,$cond);

					/* Remove Replies to the Comment when a comment is deleted */
						$cond2 = 'iReplyTo = ' . $_GET['iCommentID']; 
						$table2 =  'videocommentreplies';
						$obj->delete($table2,$cond2);

					echo 'deleted';
				}
				elseif($_GET['deleteComment'] == 'church'){
					/* Remove $_GET['deleteComment'] from $_GET aray */
						unset($_GET['deleteComment']);

					/* Remove the Comment from the DB */
						$cond = 'iCommentID = ' . $_GET['iCommentID'];
						$table = 'churchvideocomments';
						$obj->delete($table,$cond);

					/* Remove Replies to the Comment when a comment is deleted */
						$cond2 = 'iReplyTo = ' . $_GET['iCommentID']; 
						$table2 =  'churchvideocommentreplies';
						$obj->delete($table2,$cond2);

					echo 'deleted';
				}
			}
			elseif($_GET['deleteReply']){
				if($_GET['deleteReply'] == 'artist'){
					/* Remove $_GET['deleteComment'] from $_GET aray */
						unset($_GET['deleteReply']);

					$cond = 'iCommentID = ' . $_GET['iCommentID'];
					$table = 'videocommentreplies';
					$obj->delete($table,$cond);
					echo 'deleted';
				}
				elseif($_GET['deleteReply'] == 'church'){
					/* Remove $_GET['deleteComment'] from $_GET aray */
						unset($_GET['deleteReply']);

					$cond = 'iCommentID = ' . $_GET['iCommentID'];
					$table = 'churchvideocommentreplies';
					$obj->delete($table,$cond);
					echo 'deleted';
				}
			}
		}
		elseif(!empty($_POST)){
			/* Create A Time Stamp - Add to the $postArray */
				$today = date_create();
				$today = date_format($today, "Y-m-d H:i:s"); 
				$_POST['dateTime'] =  $today; 
			/* END - Create A Time Stamp */

			if($_POST['comment'] || $_POST['c_comment']){
				/* Remove the 'identifier' element from the array */
					unset($_POST['sProfileName']);
					unset($_POST['sFirstName']);

				/* Add Unique Id to retrieve New Comment */
					$randNumb = rand(1,50000);
					$_POST['unique_id'] = $randNumb;

					if($_POST['comment']){
						/* Remove the 'identifier' element from the array */
							unset($_POST['comment']);

						/* Comment Update & Display Functionality*/
							foreach($_POST as $index => $value) {
								$field[] = $index;
								$values[] = $value;  
							}

						$table = 'videocomments';
						$obj->insert($field,$values,$table);

						/* Define Media Object to append to the comment section when new comment is added */
							$commentQuery = 'SELECT videocomments.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName
											 FROM videocomments
											 INNER JOIN usermaster on videocomments.iLoginID = usermaster.iLoginID
											 WHERE videocomments.videoID = ? AND videocomments.iLoginID = ? AND videocomments.unique_id = ?
											 ORDER BY videocomments.dateTime'; 
							try{
								$getComments = $db->prepare($commentQuery);
								$getComments->bindParam(1, $_POST['videoID']);
								$getComments->bindParam(2, $_POST['iLoginID']);
								$getComments->bindParam(3, $_POST['unique_id']);
								$getComments->execute(); 
							}
							catch(Exception $e){
								echo $e; 
							}
							$allComments = $getComments->fetch(PDO::FETCH_ASSOC);
							echo $allComments['iCommentID'];
					}
					elseif($_POST['c_comment']){
						/* Remove the 'identifier' element from the array */
							unset($_POST['c_comment']);
							
						/* Comment Update & Display Functionality*/
							foreach($_POST as $index => $value) {
								$field[] = $index;
								$values[] = $value;  
							}

						$table = 'churchvideocomments';
						$obj->insert($field,$values,$table);

						/* Define Media Object to append to the comment section when new comment is added */
							$commentQuery = 'SELECT churchvideocomments.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName
											 FROM churchvideocomments
											 INNER JOIN usermaster on churchvideocomments.iLoginID = usermaster.iLoginID
											 WHERE churchvideocomments.videoID = ? AND churchvideocomments.iLoginID = ? AND churchvideocomments.unique_id = ?
											 ORDER BY churchvideoComments.dateTime'; 
							try{
								$getComments = $db->prepare($commentQuery);
								$getComments->bindParam(1, $_POST['videoID']);
								$getComments->bindParam(2, $_POST['iLoginID']);
								$getComments->bindParam(3, $_POST['unique_id']);
								$getComments->execute(); 
							}
							catch(Exception $e){
								echo $e; 
							}
							$allComments = $getComments->fetch(PDO::FETCH_ASSOC);
							echo $allComments['iCommentID'];
					}
			}
			elseif($_POST['replyType']){
				/* Remove the 'identifier' element from the array */
						unset($_POST['sProfileName']);
						unset($_POST['sFirstName']);

				/* Add Unique Id to retrieve New Comment */
					$randNumb = rand(1,50000);
					$_POST['unique_id'] = $randNumb;

				if($_POST['replyType'] == 'artist'){
					/* Remove Marker */
						unset($_POST['replyType']);

					/* Insert new reply into the videocommentsreplies table */ 
						foreach($_POST as $index => $value) {
								$field[] = $index;
								$values[] = $value;  
						}
						$table = 'videocommentreplies';
						$obj->insert($field,$values,$table);
					/* END -Insert new reply into the videocommentsreplies table */ 

					/* Retrieve newly submitted reply from the videocommentsreplies table to be displayed on the videodisplay page */
						$commentQuery = 'SELECT videocommentreplies.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName
										 FROM videocommentreplies
										 INNER JOIN usermaster on videocommentreplies.iLoginID = usermaster.iLoginID
										 WHERE videocommentreplies.videoID = ? AND videocommentreplies.iReplyTo = ? AND videocommentreplies.iLoginID = ? And videocommentreplies.unique_id = ?
										 ORDER BY videocommentreplies.dateTime ASC'; 

						try{
							$getReplies = $db->prepare($commentQuery);
							$getReplies->bindParam(1, $_POST['videoID']);
							$getReplies->bindParam(2, $_POST['iReplyTo']);
							$getReplies->bindParam(3, $_POST['iLoginID']);
							$getReplies->bindParam(4, $_POST['unique_id']);
							$getReplies->execute(); 

						}
						catch(Exception $e){
							echo $e; 
						}
						$reply = $getReplies->fetch(PDO::FETCH_ASSOC);
						echo $reply['iCommentID'];
					/* END - Retrieve newly submitted reply from the videocommentsreplies table to be displayed on the videodisplay page */
				}
				elseif($_POST['replyType'] == 'church'){
					/* Remove Marker */
						unset($_POST['replyType']);

					/* Insert new reply into the churchvideocommentsreplies table */ 
						foreach($_POST as $index => $value) {
								$field[] = $index;
								$values[] = $value;  
						}
						$table = 'churchvideocommentreplies';
						$obj->insert($field,$values,$table);
					/* END -Insert new reply into the churchvideocommentsreplies table */ 

					/* Retrieve newly submitted reply from the churchvideocommentsreplies table to be displayed on the videodisplay page */
						$commentQuery = 'SELECT churchvideocommentreplies.*, usermaster.sProfileName, usermaster.sFirstName, usermaster.sLastName
										 FROM churchvideocommentreplies
										 INNER JOIN usermaster on churchvideocommentreplies.iLoginID = usermaster.iLoginID
										 WHERE churchvideocommentreplies.videoID = ? AND churchvideocommentreplies.iReplyTo = ? AND churchvideocommentreplies.iLoginID = ? And churchvideocommentreplies.unique_id = ?
										 ORDER BY churchvideocommentreplies.dateTime ASC'; 

						try{
							$getReplies = $db->prepare($commentQuery);
							$getReplies->bindParam(1, $_POST['videoID']);
							$getReplies->bindParam(2, $_POST['iReplyTo']);
							$getReplies->bindParam(3, $_POST['iLoginID']);
							$getReplies->bindParam(4, $_POST['unique_id']);
							$getReplies->execute(); 

						}
						catch(Exception $e){
							echo $e; 
						}
						$reply = $getReplies->fetch(PDO::FETCH_ASSOC);
						echo $reply['iCommentID'];
					/* END - Retrieve newly submitted reply from the churchvideocommentsreplies table to be displayed on the videodisplay page */
				}
			}
			elseif($_POST['report']  || $_POST['c_report']){
				if($_POST['report']){
					/* Remove the 'identifie' element from the array */
						unset($_POST['report']);

					/* Report Inappropriate Videos */
						if($_POST['reportReason'] == 'Other:'){
							$_POST['reportReason'] = trim($_POST['otherReasons']);
							unset($_POST['otherReasons']);
						}
						else{
							unset($_POST['otherReasons']);
						}

						foreach($_POST as $index => $value){
							$field[] = $index; 
							$values[] = $value; 
						}
						$table = 'artistvideoreportmaster';
						$obj->insert($field,$values,$table);
				}
				elseif($_POST['c_report']){
					/* Remove the 'identifie' element from the array */
						unset($_POST['c_report']);

					/* Report Inappropriate Videos */
						if($_POST['reportReason'] == 'Other:'){
							$_POST['reportReason'] = trim($_POST['otherReasons']);
							unset($_POST['otherReasons']);
						}
						else{
							unset($_POST['otherReasons']);
						}

						foreach($_POST as $index => $value){
							$field[] = $index; 
							$values[] = $value; 
						}
						$table = 'churchvideoreportmaster';
						$obj->insert($field,$values,$table);
				}
			}	
		}
?>