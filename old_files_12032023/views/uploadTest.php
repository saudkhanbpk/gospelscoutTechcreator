<?php 
	/* Upload Test */

	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

?>
<style>
	.thumb {
		width: 150px;
		height: 150px;
		object-fit:cover; 
		object-position:0,0;
	}
</style>
<div class="container mt-5">
	<input type="file" id="files" name="files" multiple/>
	<output id="list"></output>
</div>

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>

<script>
	function handleFileSelect(evt) {
		/* FileList object */
			var files = evt.target.files; 
			// console.log(files);

		/* Loop through the FileList and render image files as thumbnails. */
			for (var i = 0, f; f = files[i]; i++) {
				
				// console.log(f.type);
console.log(f);
				/* Only process image files. */
				    if (!f.type.match('image.*')) {
				    	console.log('this is not an image');
				    	break;
				    }
				    // else{
				    // 	console.log('this is an image');
				    // 	continue; -- LOOK UP WHAT CONTINUE DOES TO THE JS
				    // }

				 /* Instantiate New FileReader object to read file contents into memory */
				 	var reader = new FileReader();

				 /* When file loads into memory, reader's onload event is fired - Capture file info */	
				 	reader.onload = (function(theFile) {

				 		return function(e) {
				 			console.log(e);
				 			/* Render Thumbnail */
				 				var span = document.createElement('span'); //Create a <span></span> element

				 				span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); //LOOK UP .JOIN() METHOD

				 				document.getElementById('list').insertBefore(span, null);
				 		}
				 	})(f);

				 	/* Read in the image file as a data URL. */
      					reader.readAsDataURL(f);
			}
	}
	document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>