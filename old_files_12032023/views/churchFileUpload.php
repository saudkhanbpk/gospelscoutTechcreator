<?php 
	/* FILE UPLOAD PAGE */

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	/* Filter out empty $_POST array values */
		foreach($_POST as $index => $value){
			if(!empty($value)){
				$postArray[$index] = $value; 
			}
		}
	/* END - Filter out empty $_POST array values */
	// var_dump($_POST);


	/* Process Uploaded Files */
		foreach($_FILES as $fileType => $indivFile){
			if($indivFile['name'] != ''){
				$_newFiles[$fileType] = $indivFile; 
			}
		}
		// 
		
		if(count($_newFiles) > 0){  
			
			// echo 'test';
			/* Move File from temporary location to permanent directory*/
				function moveFile($FILES, $targetFile) {
					if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
						$uploadStatus = 'file Upload Successful';
					}	
					else {
						$uploadStatus = 'file Upload unSuccessful';
						echo $uploadStatus;
						exit;
					}
				}
			/* END - Move File from temporary location to permanent directory*/

			/* Video Content OR Photo Album Content */
				if($postArray['contentMarker'] == 'video'){ 

					/* PROCESS UPLOADED VIDEO CONTENT */
						$vidDir = '/newHomePage/upload/video/church/church_' . $_POST['iLoginID'] . '/video/'; 
						$thumbDir = '/newHomePage/upload/video/church/church_' . $_POST['iLoginID'] . '/thumbnail/';
						$target_dir = realpath($_SERVER['DOCUMENT_ROOT']) . $vidDir;
						$target_dir_thumb =  realpath($_SERVER['DOCUMENT_ROOT']) .  $thumbDir;

						$randNumb = rand(1,50000);
						// var_dump($_newFiles);
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
										echo 'Please Upload MP4 files Only!!!' . $vidioFileType;
										exit;
									}
									elseif($viddioFileSize != '' && $viddioFileSize > 120000000) {
										echo 'Your File Size Must Be Less Than 120MB';
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
										echo 'There was an upload error: ' . $newIndivFile['error'];
										exit;
									}
									elseif($vidioFileType != '' && $vidioFileType != "jpg") {
										echo 'Please Upload Image files Only!!!' . $vidioFileType;
										exit;
									}
									elseif($viddioFileSize != '' && $viddioFileSize > 1200000) {
										echo 'Your Image File Size Must Be Less Than 1.2MB';
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
						if($uploadThumbStatus =='upload' && $uploadVidStatus == 'upload'){
							if(file_exists($target_dir)) {
								moveFile($newIndivFileVid, $target_file_vid);
							}
							else {
								mkdir($target_dir,0777,true);	
								$uploadStatusVid = moveFile($newIndivFileVid, $target_file_vid);				
							}

							if(file_exists($target_dir_thumb)) {
								moveFile($newIndivFileThumb, $target_file_thumb);
							}
							else {
								mkdir($target_dir_thumb,0777,true);	
								$uploadStatusThumb = moveFile($newIndivFileThumb, $target_file_thumb);						
							}
						}
						
					/* END - PROCESS UPLOADED VIDEO CONTENT */	
				}
				else{

					/* PROCESS PHOTO ALBUM CONTENT */
						$photoDir = '/newHomePage/upload/photogalleries/church/church_' . $_POST['iLoginID'] . '/';
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
								elseif($photoFileType != '' && $photoFileType != "jpg"){
									echo 'Please Upload Img Files Only!!!' . $photoFileType;
									exit;
								}
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
		
			/* Create A Time Stamp - Add to the $postArray */
				$today = date_create();
				$today = date_format($today, "Y-m-d h:i:s"); 
				$postArray['uploadDate'] =  $today; 
			/* END - Create A Time Stamp */
			
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

			/* Remove unwanted elements from the postArray */
				$contentMarker = $postArray['contentMarker'];
				unset($postArray['newAlbumName']);
				unset($postArray['contentMarker']);
			/* END - Remove unwanted elements from the postArray */

			
			/* Process Uploaded File's Database info */
				$i = 1; 
				$j = count($postArray);
				foreach($postArray as $index1 => $value1){
					if($i == $j){
						$insertCol .= $index1;
						$insertVal .= ':'.$index1;
					}
					else{
						$insertCol .= $index1 . ',';
						$insertVal .= ':'.$index1 . ','; 
					}
					$bindParameters[] = ':'.$index1 .','.$value1;
					$i += 1; 
				}

				if($contentMarker == 'video'){
					$query = 'INSERT INTO churchvideomaster (' . $insertCol . ') VALUES (' . $insertVal . ')';
				}
				else{
					$query = 'INSERT INTO gallerymaster (' . $insertCol . ') VALUES (' . $insertVal . ')';
				}
				
				try{
					$addVid = $db->prepare($query);
					foreach($bindParameters as $bParam){
						$bParam = explode(",", $bParam);
						$addVid->bindParam($bParam[0],$bParam[1]);
					}
					$addVid->execute();
					echo 'File Upload Successful';
				}
				catch(Exception $e){
					echo $e; 
				}
			/* END - Process Uploaded File's Database info */
		}
			// $vidioFileType != "png" || $vidioFileType != "jpg" || $vidioFileType != "jpeg"
	/* END - Process Uploaded Files */

	
?>