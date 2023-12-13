
function build_artists_modals(parsedResponse){
	var new_owl_div = '';
	$.each(parsedResponse.artist_array, function(index,value){
		new_owl_div += '<div class="row">';
    new_owl_div += '<div class="col-12 m-0 p-0 text-center text-md-left"><p class="m-0 p-0 font-weight-bold" style="font-size:1.5em;">'+index+'</p></div>'
		for( y in value){
			new_owl_div += '<div class="col-lg-4 col-md-4 col-12 col-4 mb-4">';

	/* Modal: Name */
    new_owl_div += '<div class="modal fade" id="modal-'+value[y].TalentID+'-user_'+value[y].iLoginID+'-'+y+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">';

          /* Body */
          new_owl_div += '<div class="modal-body mb-0 p-0"><div class="container">';

              	/* Row 1 */
                new_owl_div += '<div class="row pb-2" style="border-bottom: .5px solid rgba(0,0,0,.1)">';
                  
                new_owl_div += '<div class="col-12 col-md-6 bg-warning p-0">';

                /* Display profile image */
                  new_owl_div += '<img class="z-depth-1" src="https://www.gospelscout.com'+value[y].sProfileName+'"  width="100%" height="150" style="object-fit:cover; object-position:0,0;border-radius:3px 0 0 0;">';
             
                new_owl_div += '</div>';

                new_owl_div += '<div class="col-12 col-md-6 p-0">';
                new_owl_div += '<div class="container">';
                      
                new_owl_div += '<div class="row"><div class="col-12 text-center"><h4 class="my-0 text-gs">'+value[y].sFirstName+'</h4></div></div><hr class="featurette-divider my-1">';

                new_owl_div += '<div class="row"><div class="col-12 text-left mt-1" style="font-size:.8em"><table>';
                new_owl_div += '<tr><th>Talent:</th><td>'+value[y].talent+'</td></tr>';
                new_owl_div += '<tr><th>Ciy:</th><td>'+value[y].sCityName+', '+value[y].statecode+'</td></tr>';
                new_owl_div += '<tr><th>Age:</th><td>'+value[y].dDOB+'</td></tr>';
                new_owl_div += '<tr><th>Email:</th><td>'+value[y].sContactEmailID+'</td></tr>';
                new_owl_div += '<tr><th>Contact:</th><td>'+value[y].sContactNumber+'</td></tr>';
	            new_owl_div += '</table></div></div>';

                new_owl_div += '</div>';
                new_owl_div += '</div>';

                new_owl_div += '</div>';
                /* END - Row 1 */

                /* Row 2 */
                  /* Carousel Wrapper */
                  new_owl_div += '<div class="row p-0" style="min-height:100px; font-size:.8em"><div class="col px-0 pt-2" id="'+value[y].TalentID+'_'+value[y].iLoginID+'"></div></div>';
                  // new_owl_div += '';
                  /* END - Carousel Wrapper*/
                /* END - Row 2 */

            new_owl_div += '</div></div>';
          /* END - Body */

          /* Footer */
          new_owl_div += '<div class="modal-footer justify-content-center"><a type="button" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+value[y].iLoginID+'" class="btn btn-gs btn-rounded btn-md ml-4">View Profile</a><button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button></div>';

        new_owl_div += '</div></div></div>';

        new_owl_div += '<a class="show_artist_deets" art_tal="'+value[y].TalentID+'" art_id="'+value[y].iLoginID+'" modal-targ="modal-'+value[y].TalentID+'-user_'+value[y].iLoginID+'-'+y+'" ><img class="z-depth-1" src="https://www.gospelscout.com'+value[y].sProfileName+'"  width="100%" height="150" style="border-radius:10px;object-fit:cover; object-position:0,0;"></a>';
        new_owl_div += '</div>';
    }
    new_owl_div += '</div>';

    });

	return new_owl_div;
}


function buildVidCarousel(vidArray){
console.log(vidArray);
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
  function getartistFunct(selectedTalent,artistType){
    displayLoadingElement('display_load_wheell');
    var url = 'https://www.gospelscout.com/search4artist/phpBackend/connectToDb.php?talent='+selectedTalent+'&type='+artistType; 

    var talentGroup = new XMLHttpRequest(); 
    talentGroup.onload = function(){
      if(talentGroup.status == 200){
        var response = talentGroup.responseText.trim();
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        var new_owl_div = '';
        // console.log(parsedResponse);

          if(parsedResponse.result === 'exists'){
          new_owl_div += build_artists_modals(parsedResponse);
          }else{
            console.log('no artists');
            new_owl_div += '<div class="row"><div class="col-12 text-center"><p class="text-muted font-weight-bold" style="font-size:1.5em">No Matching Artists</p></div></div>'
          }
          $('#artist_display_container').html(new_owl_div);
      }
    }
    talentGroup.open('GET', url);
    talentGroup.send(); 
  }





