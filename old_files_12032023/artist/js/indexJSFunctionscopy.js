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

function buildPagination(artist_array){
  var no_of_artists = artist_array.total_no_of_artists;
  var page_no = artist_array.page_no; 

  // Set number of records per page 
    var no_of_records_per_page = 15;
    var offset = (page_no-1) * no_of_records_per_page; 

  // Total number of pages 
    var total_pages = Math.ceil(no_of_artists / no_of_records_per_page); 


  // Build HTML 
    var pagination = '<li class="page-item';

    // previous
      if( page_no == 1 ){
        pagination += ' disabled';
      }else{
        var prev_page_no = parseInt(page_no) - 1; 
      }
      pagination += ' mr-auto"><a class="page-link call_page" href="#by_talent"';
      if(artist_array.search_type == 'SBT'){
        pagination += ' talent="'+artist_array.SBT_talent+'"';
      }
      pagination += ' searchBy="'+artist_array.search_type+'" page_number="'+prev_page_no+'" tabindex="-1" aria-disabled="true"';
      if( page_no > 1){
        pagination += ' style="color:rgba(149,73,173,1);"';
      }  
      pagination += '>Previous</a></li>';
    
    // Page numbers 
      for(var i=1;i<=total_pages;i++){
        pagination += '<li class="page-item"><a href="#by_talent" class="page-link text-gs mx-1';
        if(i==page_no) {
          pagination += ' active';
        }
        pagination += ' call_page" style="border-radius:5px;" href="#"';
        if(artist_array.search_type == 'SBT'){
          pagination += ' talent="'+artist_array.SBT_talent+'"';
        }
        pagination += ' searchBy="'+artist_array.search_type+'" page_number="'+i+'">'+i+'</a></li>';
      }
   
    // Next 
      pagination += '<li class="page-item ml-auto';
      if(page_no == total_pages){
        pagination += ' disabled';
      }

      var next_page_no = parseInt(page_no) + 1; 
      pagination += '"><a class="page-link call_page" href="#by_talent"';
      if(artist_array.search_type == 'SBT'){
        pagination += ' talent="'+artist_array.SBT_talent+'"';
      }
      pagination += ' searchBy="'+artist_array.search_type+'" page_number="'+next_page_no+'" id="next_button"';
      if( total_pages > 1 && page_no != total_pages){
        pagination += ' style="color:rgba(149,73,173,1);"';
      }  
      pagination += '>Next</a> </li>';
   return pagination;
}

function buildVidCarousel(vidArray){
  /* Carousel Wrapper */
    new_owl_div = ' <div id="video-carousel-example" class="carousel slide carousel-fade bg-success m-0" data-ride="carousel">';
          
    /* Slides */
      new_owl_div += '<div class="carousel-inner bg-danger" role="listbox">';
              
      /* Add video links using Loop */
      var isActive;
      for(x in vidArray){
        if( x == 0){
          isActive = 'active';
        }else{
          isActive = '';
        }
         new_owl_div += '<div class="carousel-item '+isActive+' " style="height:auto;max-height:275px"><div class="embed-responsive embed-responsive-16by9 z-depth-1-half">';
        if( vidArray[x].youtubeLink != ''){
            new_owl_div += '<iframe class="embed-responsive-item" src="'+vidArray[x].youtubeLink+'" allowfullscreen></iframe>';
        }else{
          new_owl_div += '<video id="example_video_1"  class="video-js vjs-default-skin embed-responsive-item" controls  ><source src="https://www.gospelscout.com'+vidArray[x].videoPath+'" type="video/mp4"><p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="" target="_blank">supports HTML5 video</a></p></video>';
        }  
        new_owl_div += '</div></div>';
      }
       
      new_owl_div += '</div>';
    /* END - Slides */

    /* Controls */
      new_owl_div += '<a class="carousel-control-prev" href="#video-carousel-example" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>';
      new_owl_div += '<a class="carousel-control-next" href="#video-carousel-example" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>';
    /* END - Controls */
       
    new_owl_div += '</div>';
  /* END - Carousel Wrapper*/

  return new_owl_div ;
}

/* Function to call artists to the page */
  function getartistFunct(selectedTalent,artistType,page_no){
    displayLoadingElement('display_load_wheell');
    // var url = 'https://www.gospelscout.com/artist/phpBackend/connectToDb.php?talent='+selectedTalent+'&type='+artistType+'&page_no='+page_no; 
    var url = 'https://www.gospelscout.com/artist/phpBackend/connectToDb_new.php?talent='+selectedTalent+'&type='+artistType+'&page_no='+page_no; 

    var talentGroup = new XMLHttpRequest(); 
    talentGroup.onload = function(){
      if(talentGroup.status == 200){
        var response = talentGroup.responseText.trim();
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        var new_owl_div = '';
        // console.log(parsedResponse);
        $("#pagination_container").html( buildPagination(parsedResponse) );

          if(parsedResponse.result === 'exists'){
            new_owl_div += build_artists_modals(parsedResponse);
          }else{
            // console.log('no artists');
            new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
          }
          $('#artist_display_container').html(new_owl_div);
      }
    }
    talentGroup.open('GET', url);
    talentGroup.send(); 
  }





