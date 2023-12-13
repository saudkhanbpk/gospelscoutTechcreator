 
function displayGigInfo(gigsobj){
	console.log('inside dispaly:', gigsobj.gigs);
  var codeInsert = '<div class="row"><div class="col text-center text-md-left"><h5 class="border-bottom border-gray pb-2 mb-0">'+gigsobj.status+' Gigs</h5></div></div>';
  codeInsert += '<div class="row"><div class="col"><table class="table text-center"  style="font-size:.8em">';
  codeInsert += '<thead><tr><th class="d-none d-md-table-cell">Event ID</th><th class="d-none d-md-table-cell">Event Type</th><th>Event Date</th><th>Bid As</th><th class="d-none d-md-table-cell">Request Made</th><th>View Details</th></tr></thead><tbody>';
  for(x in gigsobj.gigs){
    codeInsert += '<tr><td class="d-none d-md-table-cell">'+gigsobj.gigs[x].gigId+'</td><td class="d-none d-md-table-cell">'+gigsobj.gigs[x].gigType+'</td><td>'+gigsobj.gigs[x].eventdate+'</td><td>'+gigsobj.gigs[x].sGiftName+'</td><td class="d-none d-md-table-cell">'+gigsobj.gigs[x].age_of_post+'</td><td><a href="https://www.stage.gospelscout.com/publicgigads/ad_details.php?g_id='+gigsobj.gigs[x].gigId+'" target="_blank" class="text-gs viewEventDeets" id="show_gig_deets" eventTable="'+gigsobj.gigs[x].eventtable+'" rowEntryID="'+gigsobj.gigs[x].id+'">View</a></td></tr>';
  }
  codeInsert += '</tbody></table></div></div>';
  return codeInsert;
}

/* Funciton to display Gig Ad Info */
  function displayGigAdInfo(gigsobj, status){
    /* Display the upc or expired gig ad count */
      if(gigsobj.gigs.Upcoming){
        $('#upcCount').html(gigsobj.gigs.Upcoming.length);
      }else{
        $('#upcCount').html(0);
      }
      if(gigsobj.gigs.Expired){
        $('#expiredCount').html(gigsobj.gigs.Expired.length);
      }else{
        $('#expiredCount').html(0);
      }

    /* Build the Gig Ad Table */ 
      	var codeInsert = '<div class="row mx-0"><div class="col text-center text-md-left mx-0"><h5 class="border-bottom border-gray pb-2 mb-0">'+status+' Dates</h5></div></div>';
      	codeInsert += '<div class="row"><div class="col">';
		if( gigsobj.gigs[status]){
			codeInsert += '<table class="table text-center"  style="font-size:.8em">';
			codeInsert += '<thead><tr><th class="d-none d-md-table-cell">Event ID</th><th class="d-none d-md-table-cell">Event Name</th><th>Event Type</th><th>Event Date</th><th class="d-none d-md-table-cell">Viewable</th><th>View Details</th></tr></thead><tbody>';
				for(x in gigsobj.gigs[status]){
				if(gigsobj.gigs[status][x].isPostedStatus === '1' && status == 'Upcoming'){
					var viewable = '<svg width="16px" height="10px" viewBox="0 0 16 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><!-- Generator: Sketch 43.2 (39069) - http://www.bohemiancoding.com/sketch --><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><path d="M0,5 C0,5 3.58,10 8,10 C12.42,10 16,5 16,5 C16,5 12.42,0 8,0 C3.58,0 0,5 0,5 L0,5 Z M14.01,5 C10.08,9.56 5.97,9.63 1.99,5 C3.3,3.48 4.68,2.49 6.06,2 C5.41,2.55 5,3.35 5,4.25 C5,5.91 6.4,7.25 8.12,7.25 C9.85,7.25 11.25,5.91 11.25,4.25 C11.25,3.37 10.86,2.58 10.24,2.04 C11.49,2.54 12.73,3.51 14.01,5 L14.01,5 Z M6.85,4.25 C6.85,3.58 7.42,3.03 8.12,3.03 C8.83,3.03 9.4,3.58 9.4,4.25 C9.4,4.92 8.83,5.47 8.12,5.47 C7.42,5.47 6.85,4.92 6.85,4.25 L6.85,4.25 Z" id="viewable" fill="#000000"></path></g></svg>';
				}
				else if(gigsobj.gigs[status][x].isPostedStatus === '0' || status == 'expired'){
					var viewable ='<svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><!-- Generator: Sketch 43.2 (39069) - http://www.bohemiancoding.com/sketch --><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="non_viewable" transform="translate(0.000000, 2.000000)"><path d="M0,6 C0,6 3.58,11 8,11 C12.42,11 16,6 16,6 C16,6 12.42,1 8,1 C3.58,1 0,6 0,6 L0,6 Z M14.01,6 C10.08,10.56 5.97,10.63 1.99,6 C3.3,4.48 4.68,3.49 6.06,3 C5.41,3.55 5,4.35 5,5.25 C5,6.91 6.4,8.25 8.12,8.25 C9.85,8.25 11.25,6.91 11.25,5.25 C11.25,4.37 10.86,3.58 10.24,3.04 C11.49,3.54 12.73,4.51 14.01,6 L14.01,6 Z M6.85,5.25 C6.85,4.58 7.42,4.03 8.12,4.03 C8.83,4.03 9.4,4.58 9.4,5.25 C9.4,5.92 8.83,6.47 8.12,6.47 C7.42,6.47 6.85,5.92 6.85,5.25 L6.85,5.25 Z" id="Shape-Copy-2" fill-opacity="0.3" fill="#000000"></path><path d="M14,0 L2,12" id="Line" stroke="#A9A9A9" stroke-width="2" stroke-linecap="square"></path></g></g></svg>';
				}
				codeInsert += '<tr><td class="d-none d-md-table-cell">'+gigsobj.gigs[status][x].gigId_display+'</td><td class="d-none d-md-table-cell">'+gigsobj.gigs[status][x].gigName+'</td><td>'+gigsobj.gigs[status][x].gigType+'</td><td>'+gigsobj.gigs[status][x].gigDate+'</td><td>'+viewable+'</td><td><a href="https://www.stage.gospelscout.com/publicgigads/ad_details.php?g_id='+gigsobj.gigs[status][x].gigId+'" target="_blank" class="text-gs">View</a></td></tr>'; //eventTable="'+gigsobj.gigs[x].eventtable+'"
				}
			codeInsert += '</tbody></table>';
		}else{
			codeInsert += '<div class="container my-0 text-center" id="bookme-choice"><h1 class="pt-3" style="color: rgba(204,204,204,1);">No '+status+' Gigs!!!</h1></div>';
		}
		codeInsert += '</div></div>';
    return codeInsert;
  }


/* fetch users Gigs */
  function fetchGigs(gig_status){
      /* Instantiate new XHR to fetch gigs */
        var getGigs_xhr = new XMLHttpRequest();
        getGigs_xhr.onload = function(){
          if(getGigs_xhr.status == 200){
            var response = getGigs_xhr.responseText.trim();
			console.log(response);
            var parsedResponse = JSON.parse( response );
			console.log(parsedResponse);

			for(x in parsedResponse.status_counts){
				$('#'+x+'Count').html(parsedResponse.status_counts[x]);
			}
            if(parsedResponse.gigsResult){
              /* Call function to display gig results */
                $('#infoDisplay').html( displayGigInfo(parsedResponse) );
            }
            else{
               /*If there are no gig results, return default message */
                $('#infoDisplay').html('<div class="container my-0 text-center" id="bookme-choice"><h1 class="pt-3" style="color: rgba(204,204,204,1);">No Gigs '+parsedResponse.status+'</h1></div>');
            }
          }
        }
        getGigs_xhr.open('get','https://www.stage.gospelscout.com/gigmanager/phpBackend/connectToDb.php?gig_status='+gig_status+'&1'); //+'&iLoginID='+u_id
        getGigs_xhr.send(); 
  }

/* Fetch user's gig ads */
  function fetchGigAds(status){
	  displayLoadingElement('show_gigAds');

    /* Grab user's gig ads */
      var eventTable = 'postedgigsmaster'; 
      var get_gigAds_xhr = new XMLHttpRequest(); 
      get_gigAds_xhr.onload = function(){
        if(get_gigAds_xhr.status == 200){

          var response = get_gigAds_xhr.responseText.trim(); console.log(response);
          var parsedResponse = JSON.parse(response);
          
          if(parsedResponse.gigs){
            /* Call function to build the gigAds html table */
              var generate_table = displayGigAdInfo(parsedResponse, status);
              $('#show_gigAds').html(generate_table);
          }else if(parsedResponse.gigs == false){
			  $('#show_gigAds').html(`<div class="container my-0 text-center" id="bookme-choice"><h1 class="pt-3" style="color: rgba(204,204,204,1);">No ${status} gigs</h1></div>`);
		  }
          else{
            /*If there are no gig results, return default message */
                $('#show_gigAds').html('<div class="container my-0 text-center" id="bookme-choice"><h1 class="pt-3" style="color: rgba(204,204,204,1);">There was an error fetching your gigs :-/</h1></div>');
            }
        }
      }
      get_gigAds_xhr.open('get','https://www.stage.gospelscout.com/gigmanager/phpBackend/connectToDb.php?eventTable='+eventTable+'&gigAds=true');
      get_gigAds_xhr.send(); 
  }
        