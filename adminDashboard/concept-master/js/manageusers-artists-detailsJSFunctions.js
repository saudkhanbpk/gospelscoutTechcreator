/* Function to reset video form */
	function resetVidForm(){
		/* Reset the Video form */
			document.getElementById('videoAddID').reset(); 
		/* Reset the Video thumbnail */
			document.getElementById('thumb').innerHTML = '';
		/* Reset the Video progress bar */
			var curr_file_name = '<p class="text-muted mt-4">No Video File Uploaded</p>';
			 document.getElementById('show-vid-name').innerHTML = curr_file_name;
	}

/* Function to validate the youtube embed URL */
	function validateYouTubeUrl(url){
        if (url != undefined || url != '') {
            // var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                 /* Return a valid embed string */
                 	// $('#ytplayerSide').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
                 	url = 'https://www.youtube.com/embed/' + match[2]
            }
            else {
            	 url = false;
            }
        }
        else{
        	url = false;
        }
        return url; 
	}

/* Build and display video */
    function displayVideo(obj){
        if(obj.response == false){
            var buildVidDisplay = ' <div class="container mt-2 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">No Videos Have Been Added Yet!!!</h1></div>';
        }else {
            var buildVidDisplay = ' <div class="container my-2 pl-0" id="vidHeader"><div class="row"><div class="col"><h5 class="text-gs">Videos</h5></div>';
            
            if(obj.o_stat){
                buildVidDisplay += '<div class="col text-right"><a class="p-1 bg-gs text-white"  id="addVideo_button" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Add New Videos</a></div>';
            }
            buildVidDisplay += '</div></div>';

            for(x in obj.response){
                buildVidDisplay += '<div class="container px-0">';
                /* Display the talent header */
                    buildVidDisplay += '<div class="row"><div class="col-6"><h5>'+x+'</h5></div><div class="col-6 text-right"><a class="anchor-styled" href="https://www.gospelscout.com/views/viewAllVid.php?u_id='+obj.response[x][0]['iLoginID']+'&tal='+obj.response[x][0]['VideoTalentID']+'">View All</a></div></div><div class="row px-0">';
                /* Display the videos for the talent in the current loop */
                    var videoMax = 1;
                    var yu = 0; 
                    for(y in obj.response[x]){
                        //if(videoMax < 5){
                            buildVidDisplay += '<div class="col-12 col-md-2 px-0 px-md-1 my-1 my-md-0"><div class="container"><div class="row"><div class="col-6 col-md-12 p-0"><a href="https://www.gospelscout.com/views/videoDisplay.php?vid_id='+obj.response[x][y].id+'&u_id='+obj.response[x][y].iLoginID+'&tal='+obj.response[x][y].VideoTalentID+'"><div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; "> ';
                            if(obj.response[x][y].videoType == 'youtube'){ 
                                var yLink = obj.response[x][y].youtubeLink;
                                var ytl = yLink;
                                var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                                yti[1] = yti[1].replace('embed/', '');
                                buildVidDisplay += '<img class="card-img-top artist-vid-img" id="msg_url'+yu+'" src="https://i3.ytimg.com/vi/' + yti[1] + '/hqdefault.jpg" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">';
                                yu++; 
                            }
                            else{
                                buildVidDisplay += '<img class="card-img-top artist-vid-img" src="';
                                if(obj.response[x][y].videoThumbnailPath ==''){buildVidDisplay +='https://www.gospelscout.com/img/gospelscout_logo.png';}
                                else{buildVidDisplay += obj.response[x][y].videoThumbnailPath;}
                                buildVidDisplay += '" height="100px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">';
                            }                    
                            buildVidDisplay += '</div></a></div><div class="col-6 col-md-12 pl-2 pl-md-0"><p class="m-0" style="font-size:.8em;"><strong>';                 
                            if(obj.response[x][y].videoType == 'youtube'){buildVidDisplay += 'Youtube Video';}
                            else{buildVidDisplay += obj.response[x][y].videoName;}
                            buildVidDisplay += '</strong></p><p class="m-0 text-muted" style="font-size:.7em;">'+obj.response[x][y].videoViews+' Views ~ '+obj.response[x][y].uploadDate+'</p><a class="getVidInfo text-danger" style="font-size:.8em" vidID="'+obj.response[x][y].id+'" thumbPath="'+obj.response[x][y].videoThumbnailPath+'" vidPath="'+obj.response[x][y].videoPath+'" href="#">Remove Video</a></div></div></div></div>';
                        }
                        //videoMax += 1;  
                    //}
                    buildVidDisplay += '</div><hr class="my-1"></div>';
            }
        }
        return buildVidDisplay;
    }

/* Call function to display data based on tab selection */
    function getTabData(tab,u_type,u_id){
        /* Get Artist Content  XHR */
            var artist_content_xhr = new XMLHttpRequest(); 
            artist_content_xhr.onload = function(){
                if(artist_content_xhr.status == 200){
                    var response = artist_content_xhr.responseText.trim();
                    var parsedResponse = JSON.parse(response);
                    var insert = '';
                    // console.log(tab,parsedResponse);

                    /* Call function to display the requested content */
                        if(tab == 'Vid'){
                            insert = displayVideo(parsedResponse);
                        }
                        else if(tab == 'Photo'){
                            insert = displayPhotos(parsedResponse);
                        }
                        $('#contentContainer').html(insert);
                }
            }
            artist_content_xhr.open('get','https://www.gospelscout.com/views/xmlhttprequest/connectToDb_artistprofile.php?content_type='+tab+'&u_type='+u_type+'&u_id='+u_id);
            artist_content_xhr.send(); 
    }




