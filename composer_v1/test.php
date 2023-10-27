<?php


echo 'test';

?>






<script src="https://dev.gospelscout.com/newHomePage/js/jquery-1.11.1.min.js"></script>

<script>
	// alert('testing this');

	var test_xhr = new XMLHttpRequest(); 
	test_xhr.onload = function(){
		if( test_xhr.status == 200 ){

			console.log( test_xhr.responseText.trim() );
		}
	}
	test_xhr.open('get','google_calendar_function.php?test=1');
	test_xhr.send();

</script>