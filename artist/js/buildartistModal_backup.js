function build_artists_modals(parsedResponse){
	var new_owl_div = '';
	new_owl_div += '<div class="row">';
  // $.each(parsedResponse.artist_array, function(index,value){
    // new_owl_div += '<div class="col-12 m-0 p-0 text-center text-md-left"><p class="m-0 p-0 font-weight-bold" style="font-size:1.5em;">'+index+'</p></div>'
		var value = parsedResponse.artist_array;
    for( y in value){
			new_owl_div += '<div class="col-lg-4 col-md-4 col-6  mb-4">';

	/* Modal: Name */
    new_owl_div += '<div class="modal fade" id="modal-'+value[y][0].TalentID+'-user_'+value[y][0].iLoginID+'-'+y+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">';

          /* Body */
          new_owl_div += '<div class="modal-body mb-0 p-0"><div class="container">';

              	/* Row 1 */
                new_owl_div += '<div class="row pb-2" style="border-bottom: .5px solid rgba(0,0,0,.1)">';
                  
                new_owl_div += '<div class="col-12 col-md-6 p-0">';

                /* Display profile image */
                    new_owl_div += '<img class="z-depth-1" src=';
                    if(value[y][0].sProfileName == null || value[y][0].sProfileName == ''){
                        new_owl_div += '"https://www.gospelscout.com/img/dummy.jpg"';
                    }else{
                        new_owl_div += '"https://www.gospelscout.com'+value[y][0].sProfileName+'"';
                    }
                    new_owl_div += 'width="100%" height="150" style="object-fit:cover; object-position:0,0;border-radius:3px 0 0 0;">';
             
                new_owl_div += '</div>';

                new_owl_div += '<div class="col-12 col-md-6 p-0">';
                new_owl_div += '<div class="container">';
                      
                new_owl_div += '<div class="row"><div class="col-12 text-center"><h4 class="my-0 text-gs">'+value[y][0].sFirstName+'</h4></div></div><hr class="featurette-divider my-1">';

                new_owl_div += '<div class="row"><div class="col-12 text-left mt-1" style="font-size:.8em"><table>';
                
                new_owl_div += '<tr><th>City:</th><td>'+value[y][0].sCityName+', '+value[y][0].statecode+'</td></tr>';
                new_owl_div += '<tr><th>Age:</th><td>'+value[y][0].dDOB+'</td></tr>';
                new_owl_div += '<tr><th>Email:</th><td>'+value[y][0].sContactEmailID+'</td></tr>';
                new_owl_div += '<tr><th>Contact:</th><td>'+value[y][0].sContactNumber+'</td></tr>';
                //  Display artist's talent
                  new_owl_div += '<tr><th class="align-top">Talent:</th><td><table>';
				  var tal_list = value[y].talent_list;
                  for(z in tal_list){
                    new_owl_div += '<tr><td>'+tal_list[z].talent+'</td></tr>'
                  }
                  new_owl_div += '</table></td></tr>';
                  // new_owl_div += '<tr><th>Talent:</th><td>'+value[y].talent+'</td></tr>';

	            new_owl_div += '</table></div></div>';

                new_owl_div += '</div>';
                new_owl_div += '</div>';

                new_owl_div += '</div>';
                /* END - Row 1 */

                /* Row 2 */
                  /* Video Carousel Wrapper */
                //   new_owl_div += '<div class="row p-0" style="min-height:100px; font-size:.8em"><div class="col px-0 pt-2" id="'+value[y][0].TalentID+'_'+value[y][0].iLoginID+'"></div></div>';
                  // new_owl_div += '';
                  /* END - Carousel Wrapper*/
                /* END - Row 2 */

            new_owl_div += '</div></div>';
          /* END - Body */

          /* Footer */
          new_owl_div += '<div class="modal-footer justify-content-center"><a type="button" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+value[y][0].iLoginID+'" class="btn btn-gs btn-rounded btn-md ml-4">View Profile</a><button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button></div>';

        new_owl_div += '</div></div></div>';

        new_owl_div += '<a class="show_artist_deets" art_tal="'+value[y][0].TalentID+'" art_id="'+value[y][0].iLoginID+'" modal-targ="modal-'+value[y][0].TalentID+'-user_'+value[y][0].iLoginID+'-'+y+'" >';
		new_owl_div += '<img class="z-depth-1 artist-images" src=';
		if(value[y][0].sProfileName == null || value[y][0].sProfileName == ''){
			new_owl_div += '"https://www.gospelscout.com/img/dummy.jpg" ';
		}else{
			new_owl_div += '"https://www.gospelscout.com'+value[y][0].sProfileName+'" ';
		}
		new_owl_div += 'style="border-radius:0px;object-fit:cover; object-position:0,0;"></a>';
        new_owl_div += '</div>';
    } 
    // });
    new_owl_div += '</div>';
	return new_owl_div;
}
