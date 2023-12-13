


/* Approve Artists */
	$('.approveArtist').click(function(event){
		event.preventDefault();
		var artistID = $(this).attr('artistID');

		/* new form data obj */
			var artID = new FormData(); 
			artID.append('approve_artist_id',artistID);

		/* Send approval to DB */
			var approveArtist_xhr = new XMLHttpRequest();
			approveArtist_xhr.onload = function(){
				if(approveArtist_xhr.status == 200){
					console.log( approveArtist_xhr.responseText.trim() );
					var parsedResponse = JSON.parse( approveArtist_xhr.responseText.trim() );

					if(parsedResponse.approved){
						console.log('artist approved ');
						$('#'+artistID).html('Approved');
					}
					else{
						console.log('approval error ');
					}
				}
			}
			approveArtist_xhr.open('post','https://www.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
			approveArtist_xhr.send(artID); 

		/* END - Send approval to DB */
	});

/* END - Approve Artists */