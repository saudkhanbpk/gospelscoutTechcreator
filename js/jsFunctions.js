/* JavaScript Functions */
/* Display thumbnail photo when new img is selected */
	function handleFileSelect(evt) {
		/* FileList object */
			const files = evt.target.files; 
			console.log(files[0].size);
		/* Loop through the FileList and render image files as thumbnails. */
			for (var i = 0, f; f = files[i]; i++) {
				
				/* Only process image files. */
				    if (!f.type.match('image.*')) {
				    	console.log('this is not an image');
				    	break;
				    }
        /* Only process images that are less than 5MB */
            if (f.size > 5000000) {
              $('#sProfileName').val('');
				    	console.log('file_too_big');
              document.getElementById('thumb-error').innerHTML = 'Files No Larger than 5MB Plz';
				    	break;
				    }
				    /*else{
				    	continue; //LOOK UP WHAT CONTINUE DOES TO THE JS
				    }*/

				 /* Instantiate New FileReader object to read file contents into memory */
				 	const reader = new FileReader();

				 /* When file loads into memory, reader's onload event is fired - Capture file info */	
				 	reader.onload = (function(theFile) {

				 		return function(e) {
				 			/* Render Thumbnail */
				 				var span = document.createElement('span'); //Create a <span></span> element

				 				span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); //LOOK UP .JOIN() METHOD

				 				/* Clear the div that displays the thumbnail b4 new thumbnail is shown */
				 					document.getElementById('thumb').innerHTML = '';
                  document.getElementById('thumb-error').innerHTML = '';

								// console.log(theFile);

				 				/* Insert new thumbnail */
				 				document.getElementById('thumb').insertBefore(span, null);
				 		}
				 	})(f);

				 	/* Read in the image file as a data URL. */
	  					reader.readAsDataURL(f);
			}
	}

/* Check zip code and get the corresponding state from the google api */
	class validateZip {
		constructor(userZip, u_State){
			$.support.cors = true;
		    $.ajaxSetup({ cache: false });
		    this.userZip = userZip; 
		    this.userState = u_State; 
		}

		/* 
		 * Method to return the city correlating to the specified zip code 
		 * param - JSON resonse from Google's GEO API 
		 * return - Object with City and State matching the requested zipcode 
		 */
			returnCity(response) {
				var address_components = response.results[0].address_components;
				let city = '';
				let hascity = 0;
				let state = '';
        let stateShortName = '';
				let nbhd = '';
				let hasnbhd = 0;
				let subloc = '';
				let hassub = 0;

				$.each(address_components, function(index, component){
					var types = component.types;
					$.each(types, function(index, type){

						if(type == 'locality') {
							city = component.long_name;
						  	hascity = 1;
						}
						if(type == 'administrative_area_level_1') {
					  		state = component.long_name;
                stateShortName = component.short_name;
						}
						if(type == 'neighborhood') {
					  		nbhd = component.long_name;
					  		hasnbhd = 1; 
						}
						if(type == 'sublocality') {
					  		subloc = component.long_name;
					  		hassub = 1;
						}
					});
				});

				if(hascity == 1){
					city = city; 
				}
				else if(hasnbhd == 1){
					city = nbhd;
				}
				else if(hassub == 1){
					city = subloc;
				}

				const userObj = {
					city: city,
					state: state,
          stateShortName: stateShortName
				}

				return userObj; 
			}

		/*
		 * Get the JSON response from Google's GEO API 
		 * return - JSON Response 
		 */
			get getCityStateOBj(){
				if(this.userZip.length == 5){
				 	var date = new Date();
				 	var jqxhr = $.getJSON( 'https://maps.googleapis.com/maps/api/geocode/json?address=' + this.userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime() );
					return jqxhr;
				}
			}
	}
/**** END - Check zip code and get the corresponding state from the google api ****/


/* Append Loading-spinwheel to the page body */
	function displayLoadingPage(action) {
		//let loading_modal = '<div class="modal" data-keyboard="false" data-backdrop="static" id="loading-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered border-none" role="document">';
		//loading_modal += '<div class="container text-center"><div class="spinner-border text-center text-gs font-weight-bold" style="width:3em;height:3em;" id="payment-spinner" aria-hidden="true" role="status"><span class="sr-only">Loading...</span></div><p style="font-size:1.3em;" class="text-gs ml-0 font-weight-bold">Just One Sec...</p></div></div></div>';//
		
		let loading_modal = '<div class="modal" data-keyboard="false" data-backdrop="static" id="loading-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered border-none" role="document">';
		loading_modal += '<div class="container text-center"><div class="row"><div class="col-6 bg-white p-1 p-md-3 mx-auto"><div class="spinner-border text-center text-gs font-weight-bold" style="width:3em;height:3em;" id="payment-spinner" aria-hidden="true" role="status"><span class="sr-only">Loading...</span></div><p style="font-size:1.3em;" class="text-gs ml-0 font-weight-bold">Just One Sec...</p></div></div></div></div></div>';//

		if(action == 'show'){
			/* Get body element and Append loading modal to the page */
				$('body').append(loading_modal);
			/* Display Modal */
				$('#loading-modal').modal(action);
		}
		else if( action == 'hide' ){
			/* Remove element from page */
				$('#loading-modal').modal(action);
				$('#loading-modal').remove();
		}
	}

	
/* Place loading spinwheel with in Specific element */
	function displayLoadingElement(elementID){
		let load_element = '<div class="container text-center"><div class="row"><div class="col"><div class="container text-center"><div class="spinner-border text-center text-gs font-weight-bold" style="width:3em;height:3em;" id="payment-spinner" aria-hidden="true" role="status"><span class="sr-only">Loading...</span></div><p style="font-size:1.3em;" class="text-gs ml-0 font-weight-bold">Just One Sec...</p></div></div></div></div>';
		$('#'+elementID).html(load_element);
	}
