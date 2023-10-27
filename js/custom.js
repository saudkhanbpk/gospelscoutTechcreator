

/****************** validate Zip code *************************/
	
	function validateZip(userZip){
		if($('div.active').attr('id') == 'step2'){
		
		/****** execute Javascript to contact google geocoding api ******/
			$.support.cors = true;
			$.ajaxSetup({ cache: false });
			var city = '';
			var hascity = 0;
			var hassub = 0;
			var state = '';
			var nbhd = '';
			var subloc = '';
			var userState = $('#sStateName').val();
			//var userZip = $('#iZipcode').val();

			if(userZip.length == 5){
				var date = new Date();
				$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
								     
					//find the city and state
						var address_components = response.results[0].address_components;
						$.each(address_components, function(index, component){
							var types = component.types;
							$.each(types, function(index, type){
								if(type == 'locality') {
									city = component.long_name;
									hascity = 1;
								}
								if(type == 'administrative_area_level_1') {
									state = component.long_name;
								}
								if(type == 'neighborhood') {
									nbhd = component.long_name;
								}
								if(type == 'sublocality') {
									subloc = component.long_name;
									hassub = 1;
								}
							});
						});
					
						if(state == userState){
							$('#sCityName').val(city);
							$('#apiStateName').val(state);
						}
						else{
							$('#sCityName').val('');
						}
				});
		      	}
		  	/****** END - execute Javascript to contact google geocoding api ******/
		}
		var cityState = array(city,state); 
		return cityState;
	}
/*************** END - validate Zip code **********************/
