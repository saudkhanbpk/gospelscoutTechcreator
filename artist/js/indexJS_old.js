/* Nav link functionality */
	$('.artist_search_method').click(function(event){
		event.preventDefault(); 
		
		/* higlight active tab */
			$('.artist_search_method').removeClass('active');
			$(this).addClass('active');
		/* define action var */	
			var action = $(this).attr('id');
		/* Hide all search sections */
			$('.nav_method').addClass('d-none');
		/* Clear the search form data */
			document.forms.namedItem('searchCriteriaForm').reset(); 
		/* Show appropriate search section */
			if(action == 'by_talent'){
				$('#get_'+action).removeClass('d-none');

				/* Call all artists to page */
					getartistFunct('all','artist');
			}else if(action == 'by_filter'){
				$('#get_'+action).removeClass('d-none');
			}
	});

/* Show and Hide grouptype and upper and lower age boundaries */
	var groupMaker = 0;
	$("#artistType").change(function(){
	    var selection = $(this).val();

	    if(selection == 'groups'){
	    	/* Show group types when group is selected */
	    		$('#groupTypeContainer').removeClass('d-none');

	    	/* Hide age inputs when group is selected */	
	    		$('#ageDiv').addClass('d-none');

	    	groupMaker = 1; 
	    }
	    else{
	    	/* Hide the group type select menu when group is not selected */
		    	$('#groupTypeContainer').addClass('d-none');
		    	$('#groupType').val('');
		    		
	    	/* Show the age inputs when an artist talent is selected as opposed to group */
		    	$('#ageDiv').removeClass('d-none');
		    	if(groupMaker == 1){
			    	$('input[name=dDOB1], input[name=dDOB2]').val('');
			    	groupMaker = 0;
		    	}

	    }
	});
/* END - Show and Hide grouptype and upper and lower age boundaries */

/* Call all artist to page when loaded */
	getartistFunct('all','artist');

/* Return artist results for selected talent from the talent dropdown menu */
	$('#nav_display').on('click','.talentGroup',function(event){
		event.preventDefault(); 
		var selectedTalent = $(this).attr('talent'); 
		var artistType = $(this).attr('artistType');
		var talentName = $(this).text(); 

		getartistFunct(selectedTalent,artistType);
	});

/* Display artists modals */
	var mytimeout;
	var modal_target;
	$('#artist_display_container').on('click','.show_artist_deets', function(event){/*mouseenter*/
		event.preventDefault;
		var modal_target = $(this).attr('modal-targ');
		var art_tal = $(this).attr('art_tal');
		var art_id = $(this).attr('art_id');

		console.log(art_tal);
		console.log(art_id);
		var url = 'https://www.gospelscout.com/search4artist/phpBackend/connectToDb.php?art_talent='+art_tal+'&art_id='+art_id; 

		 // mytimeout = setTimeout(function(){ 
		 	console.log(modal_target);
		 	
		 	displayLoadingElement(art_tal+'_'+art_id);
			
			$('#'+modal_target).modal('show');

			/* Query db for artist videos corresponding to specified talent */
				var get_art_tal_xhr = new XMLHttpRequest();
				get_art_tal_xhr.onload = function(){
					if(get_art_tal_xhr.status == 200){
						var response  = get_art_tal_xhr.responseText.trim();
						var parsedResponse = JSON.parse(response);
						console.log(parsedResponse);
						if(parsedResponse.vids_exist == true){
							$('#'+art_tal+'_'+art_id).html( buildVidCarousel(parsedResponse.vid_array) );
						}else{
							var no_vid_message = '<div class="text-center"><p class="text-muted mt-3 font-weight-bold" style="font-size:1.5em">No Artist Videos</p></div>';
							$('#'+art_tal+'_'+art_id).html( no_vid_message );
						}
					}
				}
				get_art_tal_xhr.open('GET',url);
				get_art_tal_xhr.send();

		 // }, 1000);
	});
	$('#artist_display_container').on('mouseout','.show_artist_deets', function(event){
		event.preventDefault;
		clearTimeout(mytimeout);
	});

/* END - Return artist results for selected talent from the talent dropdown menu */

	

	/* Return Results for the Specified search criteria */
		$("#searchArtist").click(function(event){
			event.preventDefault(); 

			var criteria_form = document.forms.namedItem('searchCriteriaForm');
			console.log(criteria_form);

			var param11 = $('input[name=dDOB1]').val();
			var param12 = $('input[name=dDOB2]').val();
			var param13 = $('input[name=rate1]').val();
			var param14 = $('input[name=rate2]').val();
			
			var formData = new FormData(criteria_form); 
			
			if(param11 != ''){
				if(param11 >= 4){
					formData.append('dDOB1', param11);
				}
				else{
					var param11Err = 1; 
				}
			}
			if(param12 != ''){
				if(param12 <= 120){
					formData.append('dDOB2', param12);
				}
				else{
					var param12Err = 1; 	
				}
			}
			if(param13 != ''){
				formData.append('rate1', param13);
			}
			if(param14 != ''){

				if(param14 <= 9999.99){
					formData.append('rate2', param14);
				}
				else{
					var param41Err = 1; 
				}
			}
			var sendSearch = new XMLHttpRequest(); 
			sendSearch.onload = function(){
				if(sendSearch.status == 200){
					var response = sendSearch.responseText.trim(); 
					
					var parsedResponse = JSON.parse(response);
					console.log(parsedResponse);
					var new_owl_div = '';

					// if(parsedResponse.result === 'exists'){
			  // 			$.each(parsedResponse.artist_array, function(index,value){
					//   		new_owl_div += '
					// <div class="row">
					// 	<div class="col-12">
					// 		<p class="my-0">'+index+'</p>
					// 	</div>
					// 	<div class="owl-carousel owl-theme mt-0 mb-3 pt-0 py-0  japper">
					// 		<div class="item">
					// 			<a class="show_artisst_details" href="https://www.gospelscout.com/views/artistprofile.php?artist='+val.iLoginID+'">
					// 				<img src="https://www.gospelscout.com'+val.sProfileName+'" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist"/>
					// 			</a>
					// 		</div>
					// 	</div>
					// </div>

					//   		$.each(value, function(ind, val){
					// 			new_owl_div += '
					//   		});
					//   		new_owl_div += '
					//   	});
			  // 		}else{
			  // 			console.log('no artists');
			  // 			new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
			  // 		}

			  		if(parsedResponse.result === 'exists'){
						new_owl_div += build_artists_modals(parsedResponse);
			  		}else{
			  			console.log('no artists');
			  			new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
			  		}
				  	
				  	$('#artist_display_container').html(new_owl_div);
				  	
				 //  	$('#test_owl_container').html(new_owl_div);
				 //  	var owl = $('.owl-carousel').owlCarousel({
		   //       		nav: true,
		   //          	navText: ['<span class="text-white" style="font-size:3em;"><</span>','<span class="text-white" style="font-size:3em;">></span>'],
					//     slideTransition: 'linear',
		   //          	dots: false,
		   //          	fallbackEasing: 'swing',
		   //          	lazyLoad: true,
		   //          	slideBy: 3,
		   //          	transitionStyle: 'fade',
					//     responsive: {
			  //             0: {
			  //               items: 1
			  //             },
			  //             600: {
			  //               items: 3
			  //             },
			  //             1000: {
			  //               items: 5
			  //             }
			  //           }
					// });
				}
			}
			sendSearch.open("POST", 'https://www.gospelscout.com/search4artist/phpBackend/connectToDb.php');

			if(param11Err || param12Err){
				console.log('age error');
				$('#ageErr').html('<p class="text-danger" style="font-size:12px;">Please enter an age between 4 and 120</p>');
				$('#ageErr').removeClass('d-none');
			
			}else if( param41Err ){
				$('#rateErr').html('<p class="text-danger" style="font-size:12px;">Please enter an amount less than $9999.99</p>');
				$('#rateErr').removeClass('d-none');
			}else{
				$('#ageErr').addClass('d-none');
				sendSearch.send(formData); 
			}
		});
/* END - Return Results for the Specified search criteria */

/* Pagination */
	$('#show-artists').on('click','.page-item',function(event){
		event.preventDefault(); 

		var row = $(this).attr('row');
		var current_active_tab = $('#ul_row_'+row+' li.active').attr('tab');
		var talent = $('#ul_row_'+row).attr('tal');
		var active_page = $('#ul_row_'+row+' li.active').attr('page');
		var selected_tab = $(this).attr('tab');
		
		

		/* Adjust pagination navigation */
			if( selected_tab == 'prev' ){
				if( current_active_tab > 1){
					var new_tab = parseInt(current_active_tab) - 1; 
					var new_page = parseInt(active_page) - 1; 

					$('#'+row+'-'+current_active_tab).removeClass('active');
					$('#'+row+'-'+new_tab).addClass('active');
				}
			}
			else if( selected_tab == 'next' ){
				var new_page = parseInt(active_page) + 1;

				if( current_active_tab < 3 ){
					var new_tab = parseInt(current_active_tab) + 1; 

					$('#'+row+'-'+current_active_tab).removeClass('active');
					$('#'+row+'-'+new_tab).addClass('active');
				}
				else{
					var new_tab = parseInt(current_active_tab) - 2; 

					$('#'+row+'-'+current_active_tab).removeClass('active');
					$('#'+row+'-'+new_tab).addClass('active');
				}
			}
			else{
				var new_tab = selected_tab;
				var new_page = $(this).attr('page');
				$('#'+row+'-'+current_active_tab).removeClass('active');
				$('#'+row+'-'+new_tab).addClass('active');
			}

		/* Fetch new set of artists */
			var get_artists_xhr = new XMLHttpRequest(); 
			get_artists_xhr.onload = function(){
				if( get_artists_xhr.status == 200 ){
					var response = get_artists_xhr.responseText.trim();
					console.log(response);
				}
			}
			get_artists_xhr.open('get','https://www.gospelscout.com/search4artist/phpBackend/connectToDb1.php?tab='+new_page+'&tal='+talent);
			get_artists_xhr.send(); 


		// console.log(row);
		// console.log(current_active_tab);
		// console.log(active_page);
		// console.log(new_page);

	});









