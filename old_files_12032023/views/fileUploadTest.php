<?php /* UPload Test*/ 
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
		echo '<pre>';
		var_dump($_POST);
	var_dump($_FILES);

	/* Process Uploaded Files */
		foreach($_FILES as $fileType => $indivFile){
			if($indivFile['name'] != ''){
				$_newFiles[$fileType] = $indivFile; 
			}
		}
		var_dump($_newFiles);

 
		if(count($_newFiles) > 0){  
			$target_dir =  '/Applications/MAMP/htdocs/newHomePage/upload/video/artist/artist_' . $_POST['iLoginID'] . '/'; 
			echo $target_dir;
			/* Move File from temporary location to permanent directory*/
				function moveMP4($FILES, $targetFile) {
					if(move_uploaded_file($FILES['tmp_name'], $targetFile)){
						$uploadStatus = 'file Upload Successful';
					}	
					else {
						$uploadStatus = 'file Upload unSuccessful';
					}
					echo $uploadStatus;
				}
			/* END - Move File from temporary location to permanent directory*/


			foreach($_newFiles as $newFileType => $newIndivFile) {
				$target_file = $target_dir. basename($newIndivFile['name']); 
				$vidioFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$viddioFileSize = $newIndivFile['size'];

				if(count($newIndivFile) > 0){
					if(!empty($newIndivFile['error']) && $newIndivFile['error'] != 4){
						echo 'There was an upload error: ' . $newIndivFile['error'];
					}
					elseif($vidioFileType != '' && $vidioFileType != "mp4"){
						echo 'Please Upload MP4 files Only!!!' . $vidioFileType;
					}
					/*
					elseif($viddioFileSize != '' && $viddioFileSize > 12000000) {
						echo 'Your File Size Must Be Less Than 12MB';
					}*/
					else {
						$target_file = $target_dir . $newFileType . '.mp4';
						$_POST[$songIndex] = substr($target_file, 25); 

						if(file_exists($target_dir)) {
							moveMP4($newIndivFile, $target_file);
						}
						else {
							mkdir($target_dir);							
							moveMP4($newIndivFile, $target_file);
						}
					}
				}
			}	
		}

	/* END - Process Uploaded Files */

?>
<div class="container mt-5">
	<a href="fileUploadTest.php">Refresh page</a>
	<form id="myForm" action="fileUploadTest.php" method="POST" enctype="multipart/form-data">
			<input id="dbi-file-text" type="text" name="dbi_import_text">
			<input id="dbi-file-upload" type="file" name="dbi_import_file" accept="">
			<button id="dbi-file-upload-submit" class="button button-primary" type="submit" value="Upload">UPLOAD</button>

	</form>
</div>
<script>
	$('#dbi-file-upload-submit').click(function(e){
		e.preventDefault(); 
		var filetest = document.getElementById('dbi-file-upload').files[0];
		console.log(filetest);
		console.log(filetest.type);
		document.getElementById('myForm').submit();
		
		

	});
</script>

<!--
<script>
	(function( $ ) {

	    var reader = {};
	    var file = {};
	    var slice_size = 1000 * 1024;

	    function start_upload( event ) {
	        event.preventDefault();

	        reader = new FileReader();
	        file = document.querySelector( '#dbi-file-upload' ).files[0];

	        upload_file( 0 );
	    }
	    $( '#dbi-file-upload-submit' ).on( 'click', start_upload );

	    /* Upload Function */
	    	function upload_file( start ) {
			    var next_slice = start + slice_size + 1;
			    var blob = file.slice( start, next_slice );

			    reader.onloadend = function( event ) {
			        if ( event.target.readyState !== FileReader.DONE ) {
			            return;
			        }

			        $.ajax( {
			            url: 'testLanding.php',
			            type: 'POST',
			            dataType: 'json',
			            cache: false,
			            data: {
			                action: 'dbi_upload_file',
			                file_data: event.target.result,
			                file: file.name,
			                file_type: file.type,
			                nonce: dbi_vars.upload_file_nonce
			            },
			            error: function( jqXHR, textStatus, errorThrown ) {
			                console.log( jqXHR, textStatus, errorThrown );
			            },
			            success: function( data ) {
			                var size_done = start + slice_size;
			                var percent_done = Math.floor( ( size_done / file.size ) * 100 );

			                if ( next_slice < file.size ) {
			                    // Update upload progress
			                    $( '#dbi-upload-progress' ).html( 'Uploading File - ' + percent_done + '%' );

			                    // More to upload, call function recursively
			                    upload_file( next_slice );
			                } else {
			                    // Update upload progress
			                    $( '#dbi-upload-progress' ).html( 'Upload Complete!' );
			                }
			            }
			        } );
			    };

			    reader.readAsDataURL( blob );
			}
	    /* END - Upload Function */


	})( jQuery );
</script>
-->