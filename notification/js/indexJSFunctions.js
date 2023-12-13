/**** Create function for xml http request ****/
  function useBackbone(getVar,newLocal){
	  console.log(getVar,newLocal);
    /* New XML Http Request */
      var queryBackbone = new XMLHttpRequest(); 
      queryBackbone.onload = function(){
        if(queryBackbone.status == 200){

          var response = queryBackbone.responseText.trim();
          var parsedResponse = JSON.parse(response);
          console.log(parsedResponse);

          if(parsedResponse.notfic_present == true){
          	if( parsedResponse.notifications.type == 'Recent Notifications'){
            	var notification_info = displayNotifications(parsedResponse.notifications);
          	}else if ( parsedResponse.notifications.type == 'Gig Suggestions'){
          		var notification_info = displayGigSuggestions(parsedResponse.notifications);
          	}else if( parsedResponse.notifications.type == 'Gig Submissions'){
          		var notification_info = displayGigSubmissions(parsedResponse.notifications);
          	}else if( parsedResponse.notifications.type == 'Gig Inquiries'){
          		var notification_info = displayGigInquiries(parsedResponse.notifications);
          	}else if( parsedResponse.notifications.type == 'notific_viewed'){
          		/* redirect */
          			window.location = newLocal;
          	}else if(parsedResponse.notifications.type == 'all_notific_viewed'){
          		var notification_info = '<div class="container my-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1);padding: 100px 0 100px 0">No New Notifications!!!</h1></div>';
          	}

            $('#infoDisplay').html(notification_info);
          }else{
            var mess = '<div class="container my-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1);padding: 100px 0 100px 0">No New Notifications!!!</h1></div>';
            $('#infoDisplay').html(mess);
          }
        }
      }
      queryBackbone.open('GET','https://www.stage.gospelscout.com/notification/phpBackend/connectToDb.php?'+getVar);
      queryBackbone.send()
  }
/* END - Create function for xml http request */

function displayNotifications(notific_info){
	console.log(notific_info);
	var notifications = '<h6 class="border-bottom border-gray pb-2 mb-0">'+notific_info.type+'</h6><a class="useBackBone viewAllNotification" href="#" style="font-size:.8em;display:inline-block;" id="clear_all_notific">Clear all notifications</a>';
	for(x in notific_info.data){
		for(y in notific_info.data[x]){
			notifications += '<div class="media text-muted pt-3">';
		    notifications += '<img src="https://www.stage.gospelscout.com/img/gospelscout_logo.png" alt="test" height="40px" width="40px" class="mr-2 rounded">';
		    notifications += '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">';
		    notifications += '<a href=';
			if(notific_info.data[x][y].action !== 'suggestGig'){
				notifications += '"https://www.stage.gospelscout.com/views/artistprofile.php?artist='+notific_info.data[x][y].notifierID+'"';
			}else{
				notifications += '"#"';
			}
			notifications += 'target="_blank" class="d-block">';
			notifications += '<strong class="text-gs text-gray-dark">';
		      if(notific_info.data[x][y].action == 'suggestGig'){
		      		notifications += 'New Gig Suggestion';
		      }
		      else if(notific_info.data[x][y].action == 'updatedGig'){
		        notifications += 'Gig Update';
		        var notific_action = notific_info.data[x][y].notificationDescription
		      }
		      else if(notific_info.data[x][y].action == 'artistSelected'){
		        notifications += 'Gig Booked';
		        var notific_action = notific_info.data[x][y].notificationDescription;
		      }
		      else if(notific_info.data[x][y].action == 'gigInquiry'){
		        notifications += 'New Artist Bid';
		        var notific_action = notific_info.data[x][y].notificationDescription;
		      }
		      else if(notific_info.data[x][y].action == 'artistDeselection'){
		        notifications += 'Gig Canceled';
		        var notific_action = notific_info.data[x][y].notificationDescription;
		      }
			  else if(notific_info.data[x][y].action == 'artistWithdrawal'){
		        notifications += notific_info.data[x][y].sFirstName+' '+notific_info.data[x][y].sLastName;
		        var notific_action = notific_info.data[x][y].notificationDescription;
		      }
			  else if(notific_info.data[x][y].action == 'gigRequest'){
				notifications += 'New Gig Request';
				var notific_action = '<a href="https://www.stage.gospelscout.com/views/artistprofile.php?artist='+notific_info.data[x][y].notifierID+'" target="_blank" class="d-inline text-gs">'+notific_info.data[x][y].sFirstName+' '+notific_info.data[x][y].sLastName+'</a> '+notific_info.data[x][y].notificationDescription;
			  }
			  else if(notific_info.data[x][y].action == 'cancelRequest'){
				notifications += 'Gig Request Cancelled';
				var notific_action = '<a href="https://www.stage.gospelscout.com/views/artistprofile.php?artist='+notific_info.data[x][y].notifierID+'" target="_blank" class="d-inline text-gs">'+notific_info.data[x][y].sFirstName+' '+notific_info.data[x][y].sLastName+'</a> '+notific_info.data[x][y].notificationDescription;
			  }
		    notifications += '</strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)">'+notific_info.data[x][y].postedDate+'</span>';
		    notifications += '</a>';
		    notifications += notific_action;
		    notifications += '<a href="'+notific_info.data[x][y].link+'" class="useBackBone viewNotification" notID="'+notific_info.data[x][y].id+'" link="'+notific_info.data[x][y].link+'" class="text-gs">  View</a>';
		    // https://www.stage.gospelscout.com
        notifications += '</p>';
			notifications += '</div>';
		}
	}
	return notifications;
}
function displayGigSuggestions(notific_info){
	var notifications = '<h6 class="border-bottom border-gray pb-2 mb-0">'+notific_info.type+'</h6>';
	for(x in notific_info.data){
			notifications += '<div class="media text-muted pt-3">';
		    notifications += '<img src="https://www.stage.gospelscout.com/img/gospelscout_logo.png" alt="test" height="40px" width="40px" class="mr-2 rounded">';
		    notifications += '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">';
			notifications += '<strong class="text-gs text-gray-dark">';
			notifications += notific_info.data[x].gigName;
		    notifications += '</strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)">'+notific_info.data[x].postedDate+'</span>';
		    notifications += '<br>New Gig Posted!!! The following gig matches your profile!!!';
		    notifications += '<a href="https://www.stage.gospelscout.com/publicgigads/ad_details.php?g_id='+notific_info.data[x].gigID+'" class="viewSuggestion" notID="'+notific_info.data[x].id+'" link="'+notific_info.data[x].link+'" class="text-gs">  View</a>';
		    notifications += '</p>';
			notifications += '</div>';
	}
	return notifications;
}
function displayGigSubmissions(notific_info){
	var notifications = '<h6 class="border-bottom border-gray pb-2 mb-0">'+notific_info.type+'</h6>';
	for(x in notific_info.data){
			notifications += '<div class="media text-muted pt-3">';
		    notifications += '<img src="https://www.stage.gospelscout.com/img/gospelscout_logo.png" alt="test" height="40px" width="40px" class="mr-2 rounded">';
		    notifications += '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">';
			notifications += '<strong class="text-gs text-gray-dark">';
			notifications += notific_info.data[x].gigName;
		    notifications += '</strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)">'+notific_info.data[x].postedDate+'</span>';
		    notifications += '<br>You have submitted a bid to play the following gig.';
		    notifications += '<a href="https://www.stage.gospelscout.com/publicgigads/ad_details.php?g_id='+notific_info.data[x].gigId+'" class="viewSubmission" notID="'+notific_info.data[x].id+'" link="'+notific_info.data[x].link+'" class="text-gs">  View</a>';
		    notifications += '</p>';
			notifications += '</div>';
	}
	return notifications;
}
function displayGigInquiries(notific_info){
	var notifications = '<h6 class="border-bottom border-gray pb-2 mb-0">'+notific_info.type+'</h6>';
	for(x in notific_info.data){
			notifications += '<div class="media text-muted pt-3">';
		    notifications += '<img src="https://www.stage.gospelscout.com/img/gospelscout_logo.png" alt="test" height="40px" width="40px" class="mr-2 rounded">';
		    notifications += '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">';
		    notifications += '<a href="https://www.stage.gospelscout.com/views/artistprofile.php?artist='+notific_info.data[x].iLoginID+'" target="_blank" class="d-block">'; 
			notifications += '<strong class="text-gs text-gray-dark">';
			notifications += notific_info.data[x].sFirstName + ' ' + notific_info.data[x].sLastName;
		    notifications += '</strong> <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)">'+notific_info.data[x].postedDate+'</span>';
		    notifications += '</a>';
		    notifications += 'Has submitted a bid to play the gig, <b>'+notific_info.data[x].gigName+'</b>.';
		    notifications += '<a href="https://www.stage.gospelscout.com/publicgigads/ad_details.php?g_id='+notific_info.data[x].gigId+'" class="viewInquiry" notID="'+notific_info.data[x].id+'" link="'+notific_info.data[x].link+'" class="text-gs">  View</a>';
		    notifications += '</p>';
			notifications += '</div>';
	}
	return notifications;
}