/* Build and display video */
	function displayVideo(obj){
		
		var buildVidDisplay = '	<div class="container my-2 pl-0" id="vidHeader"><div class="row"><div class="col"><h5 class="text-gs">Videos</h5></div>';
		if(obj.o_stat){
			buildVidDisplay += '<div class="col text-right"><a class="p-1 bg-gs text-white"  id="addVideo_button" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">Add New Videos</a></div>';
		}
		buildVidDisplay += '</div></div>';

		if( obj.response !== false ){
			for(x in obj.response){
				buildVidDisplay += '<div class="container px-0">';
				/* Display the talent header */
					buildVidDisplay += '<div class="row"><div class="col-6"><h5>'+x+'</h5></div><div class="col-6 text-right"><a class="anchor-styled" href="https://www.stage.gospelscout.com/views/viewAllVid.php?u_id='+obj.response[x][0]['iLoginID']+'&tal='+obj.response[x][0]['VideoTalentID']+'">View All</a></div></div><div class="row px-0">';
				/* Display the videos for the talent in the current loop */
					var videoMax = 1;
					var yu = 0; 
					for(y in obj.response[x]){
						if(videoMax < 5){
							buildVidDisplay += '<div class="col-12 col-md-3 px-0 px-md-1 my-1 my-md-0"><div class="container"><div class="row"><div class="col-6 col-md-12 p-0"><a href="videoDisplay.php?vid_id='+obj.response[x][y].id+'&u_id='+obj.response[x][y].iLoginID+'&tal='+obj.response[x][y].VideoTalentID+'"><div style="background-color: rgba(216,216,216,1);padding:1px;box-sizing:border-box; "> ';
							if(obj.response[x][y].videoType == 'youtube'){ 
								var yLink = obj.response[x][y].youtubeLink;
								var ytl = yLink;
						        var yti = ytl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
						        yti[1] = yti[1].replace('embed/', '');
								buildVidDisplay += '<img class="card-img-top artist-vid-img" id="msg_url'+yu+'" src="https://i3.ytimg.com/vi/' + yti[1] + '/hqdefault.jpg" height="75px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">';
								yu++; 
							}
							else{
								buildVidDisplay += '<img class="card-img-top artist-vid-img" src="';
								if(obj.response[x][y].videoThumbnailPath ==''){buildVidDisplay +='../img/gsStickerBig1.png';}
								else{buildVidDisplay += obj.response[x][y].videoThumbnailPath;}
								 buildVidDisplay += '" height="75px" alt="Card image cap" style="object-fit:cover; object-position:0,0;">';
							 }					  
							buildVidDisplay += '</div></a></div><div class="col-6 col-md-12 pl-2 pl-md-0"><p class="m-0" style="font-size:.8em;"><strong>';					
							if(obj.response[x][y].videoType == 'youtube'){buildVidDisplay += 'Youtube Video';}
							else{buildVidDisplay += obj.response[x][y].videoName;}
							buildVidDisplay += '</strong></p><p class="m-0 text-muted" style="font-size:.7em;">'+obj.response[x][y].videoViews+' Views ~ '+obj.response[x][y].uploadDate+'</p></div></div></div></div>';
						}
						videoMax += 1;	
					}
					buildVidDisplay += '</div><hr class="my-1"></div>';
			}
		}
		else{
			var err_mess = obj.err_message;
			if(err_mess == 'no_content'){
				buildVidDisplay += '<div class="container mt-5 text-center"><h3 class="" style="color: rgba(204,204,204,1)">No Content Available</h3></div>';
			}
			else if(err_mess == 'u_content_type_err'){
				buildVidDisplay += '<div class="container mt-5 text-center"><h5 class="" style="color: rgba(204,204,204,1)">Sorry, Error Retrieving Data :-/</h5></div>';
			}
			else if(err_mess == 'content_type_err'){
				buildVidDisplay += '<div class="container mt-5 text-center"><h5 class="" style="color: rgba(204,204,204,1)">Sorry, Error Retrieving Data :-/</h5></div>';
			}
		}
		
		return buildVidDisplay;
	}

/* Build and display photos */
	function displayPhotos(obj){
	console.log(obj);
		var buildPhotoDisplay = '<div class="container my-2 pl-0" id="photoHeader"><div class="row my-2"><div class="col-5 col-sm-4 text-truncate"><h6 class="text-gs">Photos</h6></div><div class="col-7 col-sm-8 text-right">';
		if(obj.o_stat){
			buildPhotoDisplay += '<a class="p-2 bg-gs text-white" data-toggle="modal" data-target="#addPhoto" href="#" style="font-size:12px;display:inline-block;border: 1px solid rgba(149,73,173,1); border-radius: 10px">+ Photo</a>';
		}
		buildPhotoDisplay += '</div></div></div>';
		buildPhotoDisplay += '<div class="album py-1 bg-light"><div class="container"><div class=" mt-0">';
		for(x in obj.response){
			buildPhotoDisplay += '<div class="container pl-0"><div class="row my-2"><div class="col-9 col-sm-8 pl-0">';
			buildPhotoDisplay += '<a href="viewAllPhoto.php?albumID='+obj.response[x][0]['iAlbumID']+'&artistID='+ obj.response[x][0]['iLoginID']+'" style="color:rgba(90,90,90,1);"><h6 class="text-truncate">'+ obj.response[x][0]['albumName']+'</h6></a>';
			buildPhotoDisplay += '</div></div></div>';
			buildPhotoDisplay += '<div class="row">';
			var photoMax = 1;
			for(y in obj.response[x]){
				if(photoMax < 5){
					buildPhotoDisplay += '<div class="col-4 p-0 m-md-0 col-md-3 bg-info "style="border:1px solid rgba(216,216,216,1);"><a href=""><img class="card-img-top" style="object-fit:cover; object-position:0,0;" src="'+obj.response[x][y]['sGalleryImages']+'" data-src=""  height="100px" alt="Card image cap"> </a></div>';
					photoMax += 1; 
				}
			}
			buildPhotoDisplay += '</div> ';
	 	}
		buildPhotoDisplay += '</div></div></div>';
		return buildPhotoDisplay;
	}

/* Build and display bio info */
	function displayBio(obj){
		var objVar = obj.response[0];
		var buildBioDisplay = '<div class="container"><div class="row"><div class="col-12"><p class="font-weight-bold my-0" style="font-size:.8em">Years of Experience</p></div><div class="col-12"><p  class="mb-2 ml-2" style="font-size:.8em;">';				 
		if( objVar.iYearOfExp != ''){
			buildBioDisplay += objVar.iYearOfExp;
		}
		else{
			buildBioDisplay += 'N/A';
		}
		buildBioDisplay += '</p></div></div>';

		buildBioDisplay += '<hr class="my-1"><div class="row"><div class="col-12"><p class="font-weight-bold my-0" style="font-size:.8em">Musical Influences</p></div><div class="col-12"><p  class="mb-2 ml-2" style="font-size:.8em;">';
		if( objVar.sMusicalInstrument != ''){
			buildBioDisplay += objVar.sMusicalInstrument;
		}
		else{
			buildBioDisplay += 'N/A';
		}
		buildBioDisplay += '</p></div></div>';

		buildBioDisplay += '<hr class="my-1"><div class="row"><div class="col-12"><p class="font-weight-bold my-0" style="font-size:.8em">Music Genre</p></div><div class="col-12"><p  class="mb-2 ml-2" style="font-size:.8em;">';
		if( objVar.sKindPlay != ''){
			buildBioDisplay += objVar.sKindPlay;
		}
		else{
			buildBioDisplay += 'N/A';
		}
		buildBioDisplay += '</p></div></div>';

		buildBioDisplay += '<hr class="my-1"><div class="row"><div class="col-12"><p class="font-weight-bold my-0" style="font-size:.8em">Relevant Playing Experience</p></div><div class="col-12"><p  class="mb-2 ml-2" style="font-size:.8em;">';
		if( objVar.sHavePlayed != ''){
			buildBioDisplay += objVar.sHavePlayed;
		}
		else{
			buildBioDisplay += 'N/A';
		}
		buildBioDisplay += '</p></div></div><hr class="my-1"></div>';

		return buildBioDisplay;		
	}

/* Build and display Book-me info */
	function displayBookme(){
		
	}

/* Build and display subscribe info */
	function displaySubscribe(obj){
		if(obj.o_stat === true){
			/* Subscribee Settings */
	        	var buildSubscribeDisplay = '<h6 class="text-gs mt-3 mb-2">My Subscribers </h6><h6 style="font-size:15px">You Have <span class="text-danger">'+obj.numb_subscribers+'</span> Subscriber(s)</h6><h6 class="text-gs" style="font-size: 12px">Subscribe Settings</h6>';
	        	buildSubscribeDisplay += '<div class="container pb-4" style="border-bottom: 1px solid rgba(0,0,0,.5)"><h6 class="text-gs" style="font-size: 12px">Notify My Subscribers When:</h6><form name="subscribeeSettings" id="subscribeeSettingsChange" action="" method="post" enctype="multipart/form-data">';
	        	buildSubscribeDisplay += '<div class="subscribeSettings" style="font-size:13px"><div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input subscribeeSettings" name="vidNotification" id="custom-Check1" value="1" ';
				if(obj.subscribee_settings[0].vidNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
	        	buildSubscribeDisplay += '><label class="custom-control-label" for="custom-Check1">New Videos are Uploaded</label></div>';
	  
				buildSubscribeDisplay += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscribeeSettings" name="picNotification" id="custom-Check2" value="1" ';
				if(obj.subscribee_settings[0].picNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
				buildSubscribeDisplay += '><label class="custom-control-label" for="custom-Check2">New Photos are Uploaded</label></div>';
	    
				buildSubscribeDisplay += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscribeeSettings" name="eventNotification" id="custom-Check3" value="1" ';
				if(obj.subscribee_settings[0].eventNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
				buildSubscribeDisplay += '><label class="custom-control-label" for="custom-Check3">New <span class="text-gs">Public</span> Events Are Added to My Calendar</label></div>';
	    
	        	buildSubscribeDisplay += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscribeeSettings" name="gigNotification" id="custom-Check4" value="1" ';
				if(obj.subscribee_settings[0].gigNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
				buildSubscribeDisplay += '><label class="custom-control-label" for="custom-Check4">New <span class="text-gs">Public</span> Gigs Are Added to My calendar</label></div></div>';

				buildSubscribeDisplay += '<input type="hidden"  name="userID" value="'+obj.subscribee_settings.iRollID+'"><button type="submit" id="subscribeeButton" class="settingsChange mt-3 btn-sm">Save Changes</button><div id="chngSaved">';
	        	buildSubscribeDisplay += '</div></form></div>';
	     	/* End - Subscribee Settings */


	     	/* Subscriber Settings */
	     		buildSubscribeDisplay += '<h6 class="text-gs mt-3 mb-2">My Subscriptions </h6><h6 class="text-gs" style="font-size: 12px">Subscription Settings</h6>';
		    	buildSubscribeDisplay += '<div class="container pb-4"><h6 class="text-gs" style="font-size: 12px">Notify Me When:</h6><form name="subscriberSettings" id="subscriberSettingsChange" action="" method="post" enctype="multipart/form-data">';
		    	      	
		      	buildSubscribeDisplay += '<div class="subscribeSettings" style="font-size: 13px"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscriberSettings" name="vidNotification" id="SubscriptionCheck1" value="1" ';
			   	if(obj.subscriber_settings[0].vidNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
			  	buildSubscribeDisplay += '><label class="custom-control-label" for="SubscriptionCheck1">New Videos are Uploaded</label></div>';

				buildSubscribeDisplay += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscriberSettings" name="picNotification" id="SubscriptionCheck2" value="1" ';
				if(obj.subscriber_settings[0].picNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
				buildSubscribeDisplay += '><label class="custom-control-label" for="SubscriptionCheck2">New Photos are Uploaded</label></div>';

				buildSubscribeDisplay += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscriberSettings" name="eventNotification" id="SubscriptionCheck3" value="1"';
				if(obj.subscriber_settings[0].eventNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
				buildSubscribeDisplay += '><label class="custom-control-label" for="SubscriptionCheck3">New Events Are Added to Their Calendar</label></div>';

				buildSubscribeDisplay += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscriberSettings" name="gigNotification" id="SubscriptionCheck4" value="1"';
				if(obj.subscriber_settings.gigNotification == 1){
					buildSubscribeDisplay += 'checked';
				}
				buildSubscribeDisplay += '><label class="custom-control-label" for="SubscriptionCheck4">New Gigs Are Added Their calendar</label></div>';
	            buildSubscribeDisplay += '<input type="hidden" name="userID" value="'+obj.subscribee_settings.iRollID+'">';
		        buildSubscribeDisplay += '</div><button type="button" id="subscriberButton" class="settingsChange mt-3 btn-sm">Save Changes</button>';
		    	buildSubscribeDisplay += '</form><div id="chngSaved1"></div></div>';
		   	/* END - Subscriber Settings */

		   	/* List Subscriptions */
			   	buildSubscribeDisplay += '<h6 class="text-gs" style="font-size: 12px">Subscriptions:</h6>';
		            	if(obj.subscriptions.length > 0){
					buildSubscribeDisplay += '<form name="muteRemoveForm" action="" method="POST" enctype="multipart/form-data" id="muteRemoveForm">';
				        /* Display artists and churched that you are currently subscribed to */
				            buildSubscribeDisplay += '<div class="container"><div class="row" style="font-size: 13px">';
			                    for(x_subscriptions in obj.subscriptions){
			                        buildSubscribeDisplay += '<div class="col-12 col-md-6"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subscCheckbox" name="userSubscriptions['+obj.subscriptions[x_subscriptions].iRollID+']" id="userID_'+obj.subscriptions[x_subscriptions].iRollID+'" value="1">';
			                        buildSubscribeDisplay += '<label class="custom-control-label" for="userID_'+obj.subscriptions[x_subscriptions].iRollID+'"><a href="https://www.stage.gospelscout.com/views/';
		                            
		                            if(obj.subscriptions[x_subscriptions].sType == 'artist' || obj.subscriptions[x_subscriptions].sType == 'group'){
		                            	buildSubscribeDisplay += 'artist';
		                            }
		                            else{
		                            	buildSubscribeDisplay += 'church';
		                            }
	                            
		                            buildSubscribeDisplay += 'profile.php?';
		                            
		                        	if(obj.subscriptions[x_subscriptions].sType == 'artist' || obj.subscriptions[x_subscriptions].sType == 'group'){
		                        		buildSubscribeDisplay += 'artist=';
		                        	}
		                        	else{
		                        		buildSubscribeDisplay += 'church=';
		                        	}
		                            
		                            buildSubscribeDisplay += obj.subscriptions[x_subscriptions].iRollID+'" class="text-gs">'+obj.subscriptions[x_subscriptions].sName+'</a></label>';
		                            buildSubscribeDisplay += '<img class="ml-1 ';  

		                            if(obj.subscriptions[x_subscriptions].muteNotification == 0){
		                            	buildSubscribeDisplay += 'd-none';
		                            }
		                            buildSubscribeDisplay += '" src="../img/muteSymbol.png" height="12px" width="12px" class="img-fluid" alt="Responsive image">';
			                        buildSubscribeDisplay += '</div></div>';
			                    }
			                    buildSubscribeDisplay += '</div></div>';
				        /* END - Display artists and churches that you are currently subscribed to */
	
				        buildSubscribeDisplay += '<input type="hidden" name="table" value="subscription"><input type="hidden" name="iLoginID" value="'+obj.subscribee_settings.iRollID+'">';
	
				        /* Mute notifications for specific artists/churches or unsubscribe to specific artists/churches */
				            	buildSubscribeDisplay += '<div class="container my-3"><div class="row">';
		                    		buildSubscribeDisplay += '<div class="col col-md-3 col-lg-2 mt-1"><button type="button" class="btn btn-gs btn-sm muteRemove-choice" id="muteNot">Mute</button></div>';
		                    		buildSubscribeDisplay += '<div class="col col-md-4 col-lg-3 mt-1"><button type="button" class="btn btn-gs btn-sm muteRemove-choice" id="unMuteNot">Un-Mute</button></div>';
		                    		buildSubscribeDisplay += '<div class="col col-md-4 col-lg-3 mt-1"><button type="button" class="btn btn-gs btn-sm muteRemove-choice" id="unsubscribe">Unsubscribe</button></div>';
		                		buildSubscribeDisplay += '</div></div>';
				        /* Mute notifications for specific artists/churches or unsubscribe to specific artists/churches */
				    	buildSubscribeDisplay += '</form>';
			            }
			            else{
			            	buildSubscribeDisplay += '<div class="container"><div class="row"><div class="col"><p style="color: rgba(204,204,204,1);">You Have No Subscriptions</p></div></div></div>';
			            }
			            
	    	/* END - List Subscriptions */
	    }
	    else if( obj.o_stat === 'prof_visitor' ){
	    	/* determine if user is already subscribed - display corresponding message */
		    	if(obj.subscr_stat){
					var buildSubscribeDisplay = '<div class="container mt-5 text-center" id="bookme-choice"><div class="row"><div class="col"><h4 class="sub_updated" style="color: rgba(204,204,204,1)">You Are Subscribed To This Profile.</h4><p class="my-0 font-weight-bold" style="font-size:.8em;">To Unsubscribe Click The Button Below. </p><button type="button" class="btn btn-gs btn-sm checkexist" style="display:inline-block;" id="subFalse" iLoginID="'+obj.iLoginID+'" iRollID="'+obj.iRollID+'">UnSubscribe</button></div></div></div>';
		    	}
		    	else{
		    		var buildSubscribeDisplay = '<div class="container mt-5 text-center subAdded" id="bookme-choice"><h4 class="sub_updated" style="color: rgba(204,204,204,1)">To Stay Updated on this User&apos;s Latest Info, Please Subscribe!!!</h4><button type="button" class="btn btn-gs btn-sm checkexist" style="display:inline-block" id="subTrue" iLoginID="'+obj.iLoginID+'" iRollID="'+obj.iRollID+'">Subscribe</button></div>';
		    	}
	    }
	    else if( obj.o_stat === 'site_visitor' ){
	    	var buildSubscribeDisplay = '<div class="row mt-5 text-center"><div class="col"><h4 class="" style="color: rgba(204,204,204,1)">Please Login To Subscribe To This Artist!!!</h4></div></div>';
	    }
	    
    	return buildSubscribeDisplay;
	}

/* Call function to display data based on tab selection */
	function getTabData(tab,u_type,u_id){

		/* Get Artist Content  XHR */
			var artist_content_xhr = new XMLHttpRequest(); 
			artist_content_xhr.onload = function(){
				if(artist_content_xhr.status == 200){
					var response = artist_content_xhr.responseText.trim();
					$('#contentContainer').html(response);
					// console.log(response);
					var parsedResponse = JSON.parse(response);
					console.log(parsedResponse);
					//if(parsedResponse.response){
						/* Call function to display the requested content */
							if(tab == 'Vid'){
								insert = displayVideo(parsedResponse);
							}
							else if(tab == 'Photo'){
								insert = displayPhotos(parsedResponse);
							}
							else if(tab == 'Bio'){
								insert = displayBio(parsedResponse);
							}
							else if(tab == 'Bookme'){

							}
							else if(tab == 'Subscribe'){
								insert = displaySubscribe(parsedResponse);
							}
							$('#contentContainer').html(insert);
					/*}
					else{
						var err_mess = parsedResponse.err_message;
						if(err_mess == 'no_content'){
							$('#contentContainer').html('<div class="container mt-5 text-center"><h3 class="" style="color: rgba(204,204,204,1)">No Content Available</h3></div>');
						}
						else if(err_mess == 'u_content_type_err'){
							$('#contentContainer').html('<div class="container mt-5 text-center"><h5 class="" style="color: rgba(204,204,204,1)">Sorry, Error Retrieving Data :-/</h5></div>');
						}
						else if(err_mess == 'content_type_err'){
							$('#contentContainer').html('<div class="container mt-5 text-center"><h5 class="" style="color: rgba(204,204,204,1)">Sorry, Error Retrieving Data :-/</h5></div>');
						}
					}*/
				}
			}
			artist_content_xhr.open('get','https://www.stage.gospelscout.com/views/xmlhttprequest/connectToDb_artistprofile.php?content_type='+tab+'&u_type='+u_type+'&3&u_id='+u_id);
			artist_content_xhr.send(); 
	}

/* Functiont to reset video form */
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

/* Function to display upcoming events */
	function displayUpcEvents(eventArray){
		var displayEvents = ``;
		for(let x of eventArray){
			displayEvents += `<div class="card my-3 a-prof-shadow" font-family:roboto; "><div class="card-body py-2">`;//style="box-shadow: -1px 2px 7px 0px rgba(0,0,0,1);border: .5px solid;
			displayEvents += `<div class="row py-0 my-0"><div class="col-12 py-0 my-0"><p class="py-0 my-0 " >${x.title}</p></div></div>`;
			displayEvents += `<div class="row"><div class="col-12"><p class="py-0 my-0 text-gs" style="font-size: 13px">${x.start_formal}</p></div></div>`;//<p class="py-0 my-0" style="font-size: 1em;color:#666666">Drums</p> color:#666666
			displayEvents += `<div class="row"><div class="col-8  mx-0 px-0"></div><div class="col-4 mx-0 px-0"><a href=${x.url} class="btn-sm btn-primary">Get Info</a></div></div>`;
			displayEvents += `</div></div>`;
		}
		return displayEvents; 
	}





