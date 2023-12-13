

/**** Function to get the states where the gig posts are created ****/
	function getGigStates(){
		/* call loading spinwheel */
			displayLoadingElement('postDisplay');
			
		/* XMLHttpRequest the posted Gig to the page when page loads */
			var displayPosts = new XMLHttpRequest(); 
			displayPosts.onload = function(){
				if(displayPosts.status == 200){
					var resp = displayPosts.responseText.trim();

					if(resp != ''){
						if(resp === 'login-needed'){
							var noGigsMess = '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-5"><div class="col p-lg-5"><h2 class="" style="color: rgba(204,204,204,1)">Log In To Access Posted Gigs</h2></div></div></div>';
							$('#postDisplay').html(noGigsMess);
						}
						else{
							/* Parse the JSON formatted string */
								var parsedPosts = JSON.parse(displayPosts.responseText.trim());

							var showState = '<div class="Container mx-auto text-center" style="max-width:1000px">';
							showState += '<h3 class="my-3">Select A State</h3>';
							showState += '<div class="row mx-5 px-md-5 font-weight-bold">';
							$.each(parsedPosts,function(index, value){
								showState += '<div class="px-5 col-12 col-md-6 my-1"><a class="text-decoration-none getCities" state="'+index+'" href="#"><div class="bg-gs text-white p-2 a-prof-shadow rounded">'+index+'</div></a></div>';
							});
							showState += '</div></div>';

							$('#postDisplay').html(showState);
						}
					}
					else{
						var noGigsMess = '<div class="container mt-lg-2 text-center" id="bookme-choice"><div class="row p-lg-5"><div class="col p-lg-5"><h2 class="" style="color: rgba(204,204,204,1)">There Are No Posted Gigs!!!</h2></div></div></div>';
						$('#postDisplay').html(noGigsMess);
					}
				}
			}
			displayPosts.open('GET', 'https://www.stage.gospelscout.com/views/xmlhttprequest/g_postedGigs.php?getPosts=true');
			displayPosts.send(); 
		/* END - XMLHttpRequest the posted Gig to the page when page loads */
	}
/* END - Function to get the states where the gig posts are created */