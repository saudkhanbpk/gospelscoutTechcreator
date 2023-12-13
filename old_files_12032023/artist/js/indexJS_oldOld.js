
/* Nav link functionality */
	$('.nav-link').click(function(event){
		event.preventDefault(); 
		$('.nav-link').removeClass('active');
		$(this).addClass('active');
	});

	function getAllArtists(){
        $.ajax({
			url: "phpBackend/connectToDb.php?talent=all",
			dataType: 'json',
			success: function(data) {

			  	var new_owl_div = '';
			  	if(data.result === 'none_exist'){
			  		console.log('no artists');
				}else{

					// /* Create list of talents */
					// 	console.log(data.artist_array);
					// 	var tal_buttons = '';
					// 	var artist_count = 0;
					// 	for(talent in data.artist_array){
					// 		artist_count += data.artist_array[talent].length;
					// 		tal_buttons += '<div class="col-12 my-1"><button talent="'+data.artist_array[talent].TalentID+'" type="button" class="btn btn-sm btn-gs rounded talentGroup" style="border-radius:20px; width:100%">'+talent+'</button></div>';
					// 		// onclick=get_tal_artist('+data.artist_array[talent].TalentID+')
					// 	}
					// 	$('#talent_count').html(artist_count);
					// 	$('#talent_buttons').html(tal_buttons);

					// 	/* call function to retrieve artists for specified talent */






					
				  	$.each(data.artist_array, function(index,value){
				  		new_owl_div += '<div class="row"><div class="col-12"><p class="my-0">'+index+'</p></div><div class="owl-carousel owl-theme mt-0 mb-3 pt-0 py-0  japper">';
				  		$.each(value, function(ind, val){
							new_owl_div += '<div class="item"><a class="show_artisst_details" href=" https://dev.gospelscout.com/newHomepage/views/artistprofile.php?artist='+val.iLoginID+'"><img src="https://dev.gospelscout.com'+val.sProfileName+'" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist"/></a></div>';
				  		});
				  		// owl.trigger('add.owl.carousel',[jQuery('<img class="mx-1" src="'+value.img+'" style="object-fit:cover; object-position:0,0; " width="100%" height="130">')]/*<div class="bg-success my-0 p-0"></div>*/);
				  		new_owl_div += '</div></div>';
				  	});
				}
			  	
			  	$('#test_owl_container').html(new_owl_div);
			  	var owl = $('.owl-carousel').owlCarousel({
	         		nav: true,
	            	navText: ['<span class="text-white" style="font-size:3em;"><</span>','<span class="text-white" style="font-size:3em;">></span>'],
				    slideTransition: 'linear',
	            	dots: false,
	            	fallbackEasing: 'swing',
	            	lazyLoad: true,
	            	slideBy: 3,
	            	transitionStyle: 'fade',
				    responsive: {
		              0: {
		                items: 1
		              },
		              600: {
		                items: 3
		              },
		              1000: {
		                items: 5
		              }
		            }
				});

		  	// owl.trigger('refresh.owl.carousel');
		  	}
	  	})
	}

	/* Query all artists to the page on page load */
		getAllArtists();

   $('#test_owl_container').on('mouseenter','.owl-stage',function(event){
   		// event.preventDefault(); 
   		// var current_width = parseInt($(this).css({})[0].style.width) + 100;
   		// $(this).css({
   		// 	'width': current_width 
   		// })

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

	/* Return artist results for selected talent from the talent dropdown menu */
		$('.talentGroup').click(function(event){
			event.preventDefault(); 
			displayLoadingElement('artistDisplay');

			var selectedTalent = $(this).attr('talent'); 
			var artistType = $(this).attr('artistType');
			var talentName = $(this).text(); 

			var url = 'https://dev.gospelscout.com/newHomePage/search4artist/phpBackend/connectToDb.php?talent='+selectedTalent+'&type='+artistType; 

			var talentGroup = new XMLHttpRequest(); 
			talentGroup.onload = function(){
				if(talentGroup.status == 200){
					var response = talentGroup.responseText.trim();
					console.log(response);
					var parsedResponse = JSON.parse(response);
					
					// document.getElementById('artistDisplay').innerHTML = talentGroup.responseText; 
					var new_owl_div = '';
					if(talentName != 'ALL'){
			  			new_owl_div += '<div class="row mb-2"><div class="col-12 m-0 p-0 text-center text-md-left"><p class="m-0 p-0 font-weight-bold" style="font-size:1.5em;">'+talentName+'</p></div></div>'
			  		}

			  		if(parsedResponse.result === 'exists'){
			  			$.each(parsedResponse.artist_array, function(index,value){
					  		new_owl_div += '<div class="row"><div class="col-12"><p class="my-0">'+index+'</p></div><div class="owl-carousel owl-theme mt-0 mb-3 pt-0 py-0  japper">';
					  		$.each(value, function(ind, val){
								new_owl_div += '<div class="item"><a class="show_artisst_details" href="https://dev.gospelscout.com/newHomepage/views/artistprofile.php?artist='+val.iLoginID+'"><img src="https://dev.gospelscout.com'+val.sProfileName+'" style="object-fit:cover; object-position:0,0;" width="100%" height="130px"  alt="artist"/></a></div>';
					  		});
					  		new_owl_div += '</div></div>';
					  	});
			  		}else{
			  			console.log('no artists');
			  			new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
			  		}
				  	
				  	$('#test_owl_container').html(new_owl_div);
				  	var owl = $('.owl-carousel').owlCarousel({
		         		nav: true,
		            	navText: ['<span class="text-white" style="font-size:3em;"><</span>','<span class="text-white" style="font-size:3em;">></span>'],
					    slideTransition: 'linear',
		            	dots: false,
		            	fallbackEasing: 'swing',
		            	lazyLoad: true,
		            	slideBy: 3,
		            	transitionStyle: 'fade',
					    responsive: {
			              0: {
			                items: 1
			              },
			              600: {
			                items: 3
			              },
			              1000: {
			                items: 5
			              }
			            }
					});
				}
			}
			talentGroup.open('GET', url);
			talentGroup.send(); 
		});
	/* END - Return artist results for selected talent from the talent dropdown menu */

	/* Hide Talent Search Button when Find an Artist button is clicked */
		$(document).ready(function(){
			var t = 0; 
			$('#talDropCollapser').click(function(){
				if(t==0){
					$('.talDrop').hide(); 
					t = t+1; 
				}
				else{
					$('.talDrop').show(); 

					/* Hide the group type select */
						$('#groupTypeContainer').addClass('d-none');

					/* Show Upper and Lower age boundaries */
						$('#ageDiv').removeClass('d-none');

					/* Reset the form when the user collapses it */
					document.getElementById("searchCriteriaForm").reset();

					/* When the Find an Artist button collapses the criteria form, return the listing of all artists to the page */
						getAllArtists();
					
					t = t-1; 
				}			
			});	
		});	


	/* Return Results for the Specified search criteria */
		$("#searchArtist").click(function(event){
			event.preventDefault(); 

			var criteria_form = document.forms.namedItem('searchCriteriaForm');
			console.log(criteria_form);



			// var param1 = $('#state').val();
			// var param2 = $('input[name=sCityName]').val(); 
			// var param3 = $('input[name=zip]').val(); 
			// var param4 = $('#artistType').val();
			// var param5 = $('#availability').val(); 
			// var param6 = $('input[name=FirstName]').val(); 
			// var param7 = $('input[name=LastName]').val(); 
			// var param8 = $('#numbViews').val(); 
			// var param9 = $('input[name=rating]').val(); 
			// var param10 = $('#groupType').val();
			var param11 = $('input[name=dDOB1]').val();
			var param12 = $('input[name=dDOB2]').val();
			var param13 = $('input[name=rate1]').val();
			var param14 = $('input[name=rate2]').val();
			

			var formData = new FormData(criteria_form); 
			// formData.append('sStateName', param1); 
			// formData.append('sCityName', param2);
			// formData.append('iZipcode', param3);
			// formData.append('talent', param4);
			// formData.append('sAvailability', param5); 
			// formData.append('sFirstName', param6);
			// formData.append('sLastName', param7);
			// formData.append('sNumbViews', param8);
			// formData.append('iRateAvg', param9);
			// formData.append('sGroupType', param10);
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
					console.log(response);
					var parsedResponse = JSON.parse(response);
					console.log(parsedResponse);
					var new_owl_div = '';
					// document.getElementById('artistDisplay').innerHTML = sendSearch.responseText;

					if(parsedResponse.result === 'exists'){
			  			$.each(parsedResponse.artist_array, function(index,value){
					  		new_owl_div += '<div class="row"><div class="col-12"><p class="my-0">'+index+'</p></div><div class="owl-carousel owl-theme mt-0 mb-3 pt-0 py-0  japper">';
					  		$.each(value, function(ind, val){
								new_owl_div += '<div class="item"><a class="show_artisst_details" href="https://dev.gospelscout.com/newHomepage/views/artistprofile.php?artist='+val.iLoginID+'"><img src="https://dev.gospelscout.com'+val.sProfileName+'" style="object-fit:cover; object-position:0,0;" width="100%" height="130"  alt="artist"/</a></div>';
					  		});
					  		new_owl_div += '</div></div>';
					  	});
			  		}else{
			  			console.log('no artists');
			  			new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
			  		}
				  	
				  	$('#test_owl_container').html(new_owl_div);
				  	var owl = $('.owl-carousel').owlCarousel({
		         		nav: true,
		            	navText: ['<span class="text-white" style="font-size:3em;"><</span>','<span class="text-white" style="font-size:3em;">></span>'],
					    slideTransition: 'linear',
		            	dots: false,
		            	fallbackEasing: 'swing',
		            	lazyLoad: true,
		            	slideBy: 3,
		            	transitionStyle: 'fade',
					    responsive: {
			              0: {
			                items: 1
			              },
			              600: {
			                items: 3
			              },
			              1000: {
			                items: 5
			              }
			            }
					});
				}
			}
			sendSearch.open("POST", 'https://dev.gospelscout.com/newHomePage/search4artist/phpBackend/connectToDb.php');

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





/************************** New Search for Artist JS Functionality **************************/

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
			get_artists_xhr.open('get','https://dev.gospelscout.com/newHomePage/search4artist/phpBackend/connectToDb1.php?tab='+new_page+'&tal='+talent);
			get_artists_xhr.send(); 


		// console.log(row);
		// console.log(current_active_tab);
		// console.log(active_page);
		// console.log(new_page);

	});









