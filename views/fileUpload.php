<?php 
	/* FILE UPLOAD PAGE */

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	// var_dump($_POST);
	/* Define current user's loginid */
		if( $_POST['artistID_via_admin'] > 0 ){
			$_POST['iLoginID'] = $_POST['artistID_via_admin'];
			$_POST['u_type'] = $_POST['artistType_via_admin'];

			unset($_POST['artistID_via_admin']);
			unset($_POST['artistType_via_admin']);
		}
		else{
			$_POST['iLoginID'] = $currentUserID;
			$_POST['u_type'] = $currentUserType;
		}
		
		/*$_POST['iLoginID'] = $currentUserID;
		$_POST['u_type'] = $currentUserType;*/

	/* Filter out empty $_POST array values */
		foreach($_POST as $index => $value){
			if(!empty($value)){
				$postArray[$index] = trim($value); 

				if($index == 'videoName'){
					/* Remove all non alpha-numeric characters */
						$postArray['videoName'] = preg_replace("/[^A-Za-z0-9 ]/", '', $postArray['videoName']);
					/* END - Filter out empty $_POST array values */
				}
			}
		}

	/* Create A Time Stamp - Add to the $postArray */
		$today = date_create();
		$today = date_format($today, "Y-m-d H:i:s"); 
		$postArray['uploadDate'] =  $today; 
	/* END - Create A Time Stamp */
		
	/* Process Uploaded Files */
		foreach($_FILES as $fileType => $indivFile){
			if($indivFile['name'] != ''){
				$_newFiles[$fileType] = $indivFile; 
			}
		}

// var_dump($currentUserID);
// var_dump($postArray);
// var_dump($_newFiles);
// exit;
		if(count($_newFiles) > 0){  

			/* Move File from temporary location to permanent directory*/
				// function moveFile($FILES, $targetFile) {
				// 	if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
				// 		$uploadStatus = 'File Upload Successful';
				// 	}	
				// 	else {
				// 		$uploadStatus = 'File Upload unSuccessful';
				// 		echo $uploadStatus;
				// 		exit;
				// 	}
				// }
			/* END - Move File from temporary location to permanent directory*/
			
			/* Video Content OR Photo Album Content */

				if($postArray['contentMarker'] == 'video'){ 
					
					
					/* PROCESS UPLOADED VIDEO CONTENT */
						/**** Create correct directory corresponding to church vs artist ****/
							if($postArray['u_type'] == 'artist' || $postArray['u_type'] == 'group'){
								$vidDir = '/upload/video/artist/artist_' . $_POST['iLoginID'] . '/video/'; 
								$thumbDir = '/upload/video/artist/artist_' . $_POST['iLoginID'] . '/thumbnail/';
							}
							elseif($postArray['u_type'] == 'church'){
								$vidDir = '/upload/video/church/church_' . $_POST['iLoginID'] . '/video/'; 
								$thumbDir = '/upload/video/church/church_' . $_POST['iLoginID'] . '/thumbnail/';
							}
						/* END - Create correct directory corresponding to church vs artist */

						$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $vidDir;
						$target_dir_thumb =  realpath($_SERVER['DOCUMENT_ROOT']) .  $thumbDir;

						$randNumb = rand(1,50000);
						foreach($_newFiles as $newFileType => $newIndivFile) {
							if($newFileType == "videoFile"){
								$target_file = $target_dir . basename($newIndivFile['name']); 
								$vidioFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								$viddioFileSize = $newIndivFile['size'];

								if(count($newIndivFile) > 0){
									if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
										echo 'There was an upload error: ' . $newIndivFile['error'];
										exit;
									}
									elseif($vidioFileType != '' && $vidioFileType != "mp4"){
										// echo 'Please Upload MP4 files Only!!!' . $vidioFileType;
										$response['err'] = 'vid_file_type_err:'; 
										/* Return JSON Response */
											echo json_encode($response);
											exit;
									}
									elseif($viddioFileSize != '' && $viddioFileSize > 120000000) {
										// echo 'Your File Size Must Be Less Than 120MB';
										$response['err'] = 'vid_file_size_err:'; 
										/* Return JSON Response */
											echo json_encode($response);
											exit;
									}
									else {
										$target_file_vid = $target_dir . $randNumb . str_replace(' ', '', $postArray['videoName']) . '.' . $vidioFileType;
										
										$newIndivFileVid = $newIndivFile; 
										$uploadVidStatus = 'upload';

										/* Add Video File Path to the post array */
											$postArray['videoPath'] = $vidDir . basename($target_file_vid);
									}
								} 
							}
							else{
								$target_file = $target_dir_thumb . basename($newIndivFile['name']); 
								$vidioFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								$viddioFileSize = $newIndivFile['size'];
								
								if(count($newIndivFile) > 0){
									if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
										// echo 'There was an upload error: ' . $newIndivFile['error'];
										$response['err'] = 'thumbnail_file_upload_err:'. $newIndivFile['error']; 
										/* Return JSON Response */
											echo json_encode($response);
											exit;
									}
									// elseif($vidioFileType != '' && $vidioFileType != "jpg") {
									// 	echo 'Please Upload Image files Only!!!' . $vidioFileType;
									// 	exit;
									// }
									elseif($viddioFileSize != '' && $viddioFileSize > 1200000) {
										// echo 'Your Image File Size Must Be Less Than 1.2MB';
										$response['err'] = 'thumbnail_size_err'; 
										/* Return JSON Response */
											echo json_encode($response);
											exit;
									}
									else {
										$target_file_thumb = $target_dir_thumb . $randNumb. str_replace(" ","",$postArray['videoName']) . '.' . $vidioFileType; 
										$uploadThumbStatus = 'upload';
										$newIndivFileThumb = $newIndivFile;
										$postArray['videoThumbnailPath'] = $thumbDir . basename($target_file_thumb);
									}
								}
							}
						}

						if($uploadVidStatus == 'upload'){ 
							// var_dump($postArray);
							if(file_exists($target_dir)) {
								moveFile($newIndivFileVid, $target_file_vid);
							}
							else {
								mkdir($target_dir,0777,true);	
								$uploadStatusVid = moveFile($newIndivFileVid, $target_file_vid);				
							}

							if($uploadThumbStatus == 'upload'){
								if(file_exists($target_dir_thumb)) {
									moveFile($newIndivFileThumb, $target_file_thumb);
								}
								else {
									mkdir($target_dir_thumb,0777,true);	
									$uploadStatusThumb = moveFile($newIndivFileThumb, $target_file_thumb);						
								}
							}
						}
						elseif($postArray['action'] == 'saveChanges' && $uploadThumbStatus =='upload'){
							/* Delete video's current thumbnail photo from the server if a new photo has been uploaded */
								$fileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $postArray['currentThumbnailPath'];
								if(file_exists($fileRemoved)){
									$fileDeleted = unlink($fileRemoved);
									// var_dump($fileDeleted);
								}
							
							/* Add the new file to the proper directory */
								if(file_exists($target_dir_thumb)) {
									moveFile($newIndivFileThumb, $target_file_thumb);
								}
								else {
									mkdir($target_dir_thumb,0777,true);	
									$uploadStatusThumb = moveFile($newIndivFileThumb, $target_file_thumb);						
								}

							/* Add a trigger to the $postArray array */
								// $postArray['update'] = 1; 
						}
					/* END - PROCESS UPLOADED VIDEO CONTENT */	
				}
				else{
					/* PROCESS PHOTO ALBUM CONTENT */
					// var_dump($postArray);
					// var_dump($_newFiles);
					// exit;
						/* Create correct directory corresponding to church vs artist */
							if($postArray['u_type'] == 'artist' || $postArray['u_type'] == 'group'){
								$photoDir = '/upload/photogalleries/artist/artist_' . $_POST['iLoginID'] . '/';
							}
							elseif($postArray['u_type'] == 'church'){
								$photoDir = '/upload/photogalleries/church/church' . $_POST['iLoginID'] . '/';
							}

						$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $photoDir;
						$randNumb = rand(1,50000);
						foreach($_newFiles as $newFileType => $newIndivFile) {
							$target_file = $target_dir . basename($newIndivFile['name']); 
							$photoFileType = pathinfo($target_file,PATHINFO_EXTENSION);
							$photoFileSize = $newIndivFile['size'];

							if(count($newIndivFile) > 0){
								if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
									echo 'There was an upload error: ' . $newIndivFile['error'];
									exit;
								}
								// elseif($photoFileType != '' && $photoFileType != "jpg"){
								// 	echo 'Please Upload Img Files Only!!!' . $photoFileType;
								// 	exit;
								// }
								elseif($photoFileSize != '' && $photoFileSize > 12000000) {
									echo 'Your File Size Must Be Less Than 12MB';
									exit;
								}
								else {

									$target_file = $target_dir . $randNumb . str_replace(' ', '', $postArray['contentMarker']) . '.' . $photoFileType;
									
									if(file_exists($target_dir)) {
										moveFile($newIndivFile, $target_file);
									}
									else {
										mkdir($target_dir,0777,true);					
										moveFile($newIndivFile, $target_file);
									}

									/* Add Video File Path to the post array */
										$postArray['sGalleryImages'] = $photoDir . basename($target_file);
								}
							} 						
						}
					/* END - PROCESS PHOTO ALBUM CONTENT */
				}
			/* END -  Video Content OR Photo Album Content */
			
			/* If a New Album is being Created */
				if($postArray['contentMarker'] == 'photo'){
					if($postArray['newAlbumName'] != ''){
						$query = 'INSERT INTO albummaster (iLoginID, sAlbumName, isActive, uniqueID) VALUES (:iLoginID, :sAlbumName, :isActive, :uniqueID)';
						$isActive = 1; 
						$uniqueID = rand(1,50000);

						try{
							$newAlbum = $db->prepare($query);
							$newAlbum->bindParam(':iLoginID', $postArray['iLoginID']);
							$newAlbum->bindParam(':sAlbumName', $postArray['newAlbumName']);
							$newAlbum->bindParam(':isActive', $isActive);
							$newAlbum->bindParam(':uniqueID', $uniqueID);
							$newAlbum->execute(); 
						}
						catch(Exception $e){
							echo $e; 
						}

						$query2 = 'SELECT albummaster.iAlbumID 
								   FROM albummaster 
								   WHERE iLoginID = ? AND sAlbumName = ? AND uniqueID = ?';

						try{
							$getAlbumId = $db->prepare($query2);
							$getAlbumId->bindParam(1,$postArray['iLoginID']);
							$getAlbumId->bindParam(2,$postArray['newAlbumName']);
							$getAlbumId->bindParam(3,$uniqueID);
							$getAlbumId->execute(); 
						}
						catch(Exception $e){
							echo $e; 
						}
						$results = $getAlbumId->fetchAll(PDO::FETCH_ASSOC);
						$postArray['iAlbumID'] = $results[0]['iAlbumID'];
						$postArray['albumName'] = $postArray['newAlbumName'];
					}
					else{
						$query2 = 'SELECT albummaster.sAlbumName
								   FROM albummaster 
								   WHERE iAlbumID = ?';

						try{
							$getAlbumName = $db->prepare($query2);
							$getAlbumName->bindParam(1,$postArray['iAlbumID']);
							$getAlbumName->execute(); 
						}
						catch(Exception $e){
							echo $e; 
						}
						$results = $getAlbumName->fetchAll(PDO::FETCH_ASSOC);
						
						$postArray['albumName'] = $results[0]['sAlbumName'];
					}
				}
			/* END - If a New Album is being Created */
		}
	/* END - Process Uploaded Files */

		/* Remove unwanted elements from the postArray */
		// var_dump($postArray);
		// exit;
			$contentMarker = $postArray['contentMarker'];
			$action = $postArray['action'];
			$u_type = $postArray['u_type'];
			unset($postArray['newAlbumName']);
			unset($postArray['contentMarker']);
			unset($postArray['action']);
			unset($postArray['u_type']);

			/* Video Edit and Removal */
			if($action == 'saveChanges' || $action == 'removeVideo'){
				// var_dump($_POST);
				// exit;
				/* Remove Video's Files */
					if($action == 'removeVideo'){
						/* Delete video's current thumbnail photo from the server */
							$fileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $postArray['currentThumbnailPath'];
							if(file_exists($fileRemoved)){
								$fileDeleted = unlink($fileRemoved);
								// var_dump($fileDeleted);
								if( $fileDeleted ){
									$response['vid_thumb_del'] = true; 
								}
								else{
									$response['vid_thumb_del'] = false; 
								}
							}

						/* Delete current video from the server */
							$vidFileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $postArray['currentVideoPath'];
							if(file_exists($vidFileRemoved)){
								$vidFileDeleted = unlink($vidFileRemoved);
								// var_dump($vidFileDeleted);

								if($vidFileDeleted){
									unset($postArray['currentVideoPath']);
									$response['vid_file_del'] = true; 
								}
								else{
									$response['vid_file_del'] = false; 
									// echo "There was trouble deleting this video file!!!";
								}
							}
					}
				/* END - Remove Video's Files */

				/**** define vars according to if user is artist or church ****/
					if($u_type == 'artist' || $u_type == 'group' ){
						$table = 'artistvideomaster';
						$table1 = 'videocomments';
						$table2 = 'videocommentreplies';
					}
					elseif($u_type == 'church'){
						$table = 'churchvideomaster';
						$table1 = 'churchvideocomments';
						$table2 = 'churchvideocommentreplies';
					}

					$userID = $postArray['iLoginID'];
					$vidID = $postArray['id'];
					$cond = 'id = "' . $vidID . '"';//  AND iLoginID = "' . $userID . '"';
					$cond1 = 'videoID = ' . $vidID;
					unset($postArray['action']);
					unset($postArray['iLoginID']);
					unset($postArray['id']);
					unset($postArray['uploadDate']);
					unset($postArray['currentThumbnailPath']);
				/* END - define vars according to if user is artist or church */
			}
			
			/* Photo Edit and Removal */
			if($action == 'saveCaptionEdit' || $action == 'removePhoto' || $action == 'removeAlbum'){
				
				/* Remove Photo File */
					if($action == 'removePhoto'){

						/* Delete current photo from the server */
							$photoFileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $postArray['sGalleryImages'];
							if(file_exists($photoFileRemoved)){
								$photoFileDeleted = unlink($photoFileRemoved);
								// var_dump($vidFileDeleted);

								if($photoFileDeleted){
									unset($postArray['sGalleryImages']); 
								}
								else{
									$response['file_removed'] = false; 
									// echo "There was trouble deleting this image file!!!";
								}
							}

					}
					elseif($action == 'removeAlbum'){
						$getPhotQuery = 'SELECT gallerymaster. sGalleryImages
						    	   	 FROM gallerymaster
						    	   	 WHERE gallerymaster. iAlbumID = ?';
						
						try{
							$getPhotPaths = $db->prepare($getPhotQuery);
							$getPhotPaths->bindParam(1, $postArray['iAlbumID']);
							$getPhotPaths->execute(); 
						}
						catch(Exception $e){
							echo $e;
						}
						$photoPaths = $getPhotPaths->fetchAll(PDO::FETCH_ASSOC); 
						//var_dump($photoPaths);
						
						foreach($photoPaths as $indivPath){
							/* Delete current photo from the server */
								$photoFileRemoved = realpath($_SERVER['DOCUMENT_ROOT']) . $indivPath['sGalleryImages']; 
								//var_dump($photoFileRemoved);
								if(file_exists($photoFileRemoved)){
									$photoFileDeleted = unlink($photoFileRemoved);
									//var_dump($vidFileDeleted);
									
									if($photoFileDeleted){
										unset($postArray['sGalleryImages']);
									}
									else{
										echo "There was trouble deleting this image file!!!";
									}
								}
						}
	 
						/*
							1. query gallerymaster table for all photo paths with postArray['iAlbumID']
							2. Create foreach loop with the resulting array
							3. extract the sGalleryImages (img paths)
							4. use the img paths to remove the img files from the server
							5. Below delete entry from the gallerymaster table
						*/
					}
				/* END - Remove Photo Files */
				
				//$action = $postArray['action']; 
				$photoID = $postArray['iGalleryID'];
				$postArray['editDate'] = $postArray['uploadDate'];
				$table="gallerymaster";
				if($action != 'removeAlbum'){
					$cond = "igalleryID = " . $photoID;
				}
				else{
					$cond = 'iAlbumID = ' . $postArray['iAlbumID'];
					$table2 = 'albummaster';
				}
				//unset($postArray['action']);
				unset($postArray['sGalleryImages']);
				unset($postArray['iGalleryID']);
				unset($postArray['uploadDate']);
			}
			
			/* Edit album title/remove whole album */
			if($action == 'saveAlbumTitle'){
				$table = 'albummaster';
				$cond = 'iAlbumID = ' . $postArray['iAlbumID']; 
				
				unset($postArray['uploadDate']);
				unset($postArray['iAlbumID']);
			}
		/* END - Remove unwanted elements from the postArray */
		
		/* Process $_POST array Database info */
			$i = 1; 
			$j = count($postArray);
			
			foreach($postArray as $index1 => $value1){
				if($value1 != ''){
					if($i == $j){
						$insertCol .= $index1;
						$insertVal .= ':'.$index1;
					}
					else{
						$insertCol .= $index1 . ',';
						$insertVal .= ':'.$index1 . ','; 
					}
				}
				$bindParameters[] = ':'.$index1 .','.str_replace(',','&#44;',$value1);
				$i += 1; 
			}
	
			if($contentMarker == 'video'){
				if($action == 'saveChanges'){
					/* UPDATE artistvideomaster TABLE */
						$k = 1; 
						$L = count($postArray);

						foreach($postArray as $index2 => $value2){
							$updateArray[$index2] = $value2;
						}
						$wasUpdated = updateTable($db, $updateArray, $cond, $table);

						if($wasUpdated){
							$response['response'] = true; 
						}
						else{
							$response['response'] = false; 
							$response['err'] = 'vid_edit_update_err'; 
						}

					/* Return JSON Response */
						echo json_encode($response);
						exit;
				}
				elseif($action == 'removeVideo'){
					/* If admin deleted this video update the table row otherwise delete table row */
						if($postArray['adminID'] > 0){
							$postArray['delDate'] = $today;
							$postArray['removedStatus'] = 1;
							unset($postArray['videoName']);
							unset($postArray['videoDescription']);
							unset($postArray['currentVideoPath']);
							
							foreach($postArray as $adminDelIndex => $adminDel){
								$array_admnDel[$adminDelIndex] =  $adminDel;
							}
							$wasDeleted = updateTable($db, $array_admnDel, $cond, 'artistvideomaster');
						}
						else{
							$wasDeleted = $obj->delete($table,$cond,$db);
						}

						if($wasDeleted){
							$commentsDeleted = $obj->delete('videocomments',$cond1,$db);
							$repliesDeleted = $obj->delete('videocommentreplies',$cond1,$db);

							if($repliesDeleted && $commentsDeleted){
								$response['response'] = true; 
							}
							else{
								$response['response'] = false; 
								$response['err'] = 'comm_reply_del_fail'; 
							}
						}
						else{
							$response['response'] = false; 
							$response['err'] = 'vidTable_del_fail'; 
						}

					/* Return JSON Response */
						echo json_encode($response);
						exit;
				}
				else{
					if($u_type == 'artist' || $u_type == 'group'){
						$query = 'INSERT INTO artistvideomaster (' . $insertCol . ') VALUES (' . $insertVal . ')';
					}
					elseif($u_type == 'church'){
						$query = 'INSERT INTO churchvideomaster (' . $insertCol . ') VALUES (' . $insertVal . ')';
					}
				}

				
			}
			elseif($action == 'saveCaptionEdit'|| $action == 'removePhoto' || $action == 'saveAlbumTitle' || $action == 'removeAlbum'){
			
				if($action == 'saveCaptionEdit'){
					foreach($postArray as $index2 => $value2){
						$field[] = $index2;
						$valueArray[] = $value2;
					}
					$wasUpdated = $obj->update($field,$valueArray,$cond,$table);
					// var_dump($wasUpdated);
					// echo $wasUpdated;
					// exit;

					if($wasUpdated){
						$response['response'] = true; 
					}
					else{
						$response['response'] = false; 
						$response['err'] = 'caption_not_update'; 
					}
					
				}
				elseif($action == 'removePhoto'){
					$wasDeleted = $obj ->delete($table,$cond);
					// echo $wasDeleted; 
					if($wasDeleted){
						$response['response'] = true; 
					}
					else{
						$response['response'] = false; 
						$response['err'] = 'photo_not_removed'; 
					}

				}
				elseif($action == 'saveAlbumTitle'){
					foreach($postArray as $index2 => $value2){
						$field[] = $index2;
						$valueArray[] = $value2;
					}
					
					$wasUpdated = $obj->update($field,$valueArray,$cond,$table);
					// echo $wasUpdated;
					if($wasUpdated){
						$response['response'] = true; 
					}
					else{
						$response['response'] = false; 
						$response['err'] = 'alb_title_not_update'; 
					}
				 	// exit;
				}
				elseif($action == 'removeAlbum'){
					//echo $photoFileRemoved; 
					//echo $table; 
					//echo $cond; 
					$wasDeleted = $obj ->delete($table,$cond);
					$wasDeleted1 = $obj ->delete($table2,$cond);
					if($wasDeleted == 1 && $wasDeleted1 == 1){
						$response['response'] = true; 
						// echo 1; 
					}
					else{
						$response['response'] = false; 
						$response['err'] = 'alb_deletion_error';
					}
					//echo $wasDeleted; 
				}

				/* Return JSON Response */
						echo json_encode($response);
					exit;
			}
			else{
				$query = 'INSERT INTO gallerymaster (' . $insertCol . ') VALUES (' . $insertVal . ')';

				/* Define Response var */
					$response['new_photo']['iLoginID'] = $postArray['iLoginID'];
					$response['new_photo']['album_id'] = $postArray['iAlbumID'];
			}
			// var_dump($bindParameters);
			// exit;
			try{
				$addVid = $db->prepare($query);
				foreach($bindParameters as $bParam){
					$bParam = explode(",", $bParam);
					$addVid->bindParam($bParam[0],$bParam[1]);
				}
				$addVid_result = $addVid->execute();
				// var_dump($addVid_result);

				if($addVid_result){
					$response['response'] = true; 
				}
				else{
					$response['response'] = false; 
				}

				// echo 'File Upload Successful';
			}
			catch(Exception $e){
				$response['response'] = false; 
				$response['err'] = $e; 
				// echo $e; 
			}
		/* END - Process $_POST array Database info */
		
		/* Return JSON Response */
			echo json_encode($response);

?>