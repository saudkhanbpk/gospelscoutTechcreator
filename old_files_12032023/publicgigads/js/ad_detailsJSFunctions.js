
/********************************************************
 *** Create funciton to retrieve and display artist info
 ********************************************************/
        // function getArtistInfo(iLoginID,gigId,viewMore){ 
		// 	console.log('this is a test');
        //     /* show loading spinwheel */
        //         displayLoadingElement('colTwo');

        //     /* Get current tal_tracker */
        //         var curr_tal_tracker = $('input[name=curr_tal_tracker]').val(); 
                                
        //     /**** Use XMLHttpRequest to fetch artist info ****/
        //         if(iLoginID > 0 ){
        //             var getArtistDeets = new XMLHttpRequest();
        //             getArtistDeets.onload = function(){
        //                 if(getArtistDeets.status == 200){

                            
        //                     /**** Parse the ResponseText as an xml string ****/
        //                         var response = getArtistDeets.responseText.trim();
        //                         var parsedResponse = JSON.parse(response);
        //                         var inquiryWithdrawn = parsedResponse.inquiries.inquiry_withdrawn;
        //                         if(inquiryWithdrawn){
        //                             var withdrawReason = parsedResponse.inquiries.withdraw_reason;
        //                             var withdrawDatetime = parsedResponse.inquiries.withdraw_dateTime;
        //                         }
        //                         var curr_artist_selected = '';

        //                         /* check if current artist is a selected artist for the gig */
        //                             if(parsedResponse.all_selected_artists !== null){
        //                                 for(sel_artist in parsedResponse.all_selected_artists){
        //                                     if(parsedResponse.all_selected_artists[sel_artist].artist_selected == iLoginID){
        //                                         curr_artist_selected = true; 
        //                                         break;
        //                                     }
        //                                     else{
        //                                         curr_artist_selected = false; 
        //                                     }
        //                                 }
        //                             }

        //                         /* Insert proper modal text based on a currently selected artist */
        //                             if(parsedResponse.selected_artist !== null ){ //parsedResponse.selected_artist.tal_tracker_id == curr_tal_tracker){
        //                                 var modalText = '<a href="https://www.gospelscout.com/views/artistprofile.php?artist='+parsedResponse.selected_artist.artist_selected+'" class="font-weight-bold text-gs" target="_blank">'+parsedResponse.selected_artist.sFirstName+' '+parsedResponse.selected_artist.sLastName+'</a> is currently selected for this position. By clicking confirm, this artist will be replaced  with the newly selected artist.';
        //                                 $('#selectThisArtist').attr('replaceArtist', 'true');
        //                                 $('#selectThisArtist').attr('selArtistId', parsedResponse.selected_artist.artist_selected);
        //                                 $('#modalMessage').html(modalText);
        //                             }
        //                             else{
        //                                 var modalText = 'Once an artist is selected, this gig post will be automatically removed from the posted gigs page and will no longer be publicly viewable.  Please confirm artist selction below.';
        //                                 $('#modalMessage').text(modalText);
        //                             }

        //                             var buildColTwo = '<div class="mb-2"><a class="artistProfile" href="https://www.gospelscout.com/views/artistprofile.php?artist='+parsedResponse.inquiries.iLoginID+'" target="_blank" style="text-decoration: none; "><img class="aProfPic profPic" src="'+parsedResponse.inquiries.sProfileName+'" height="50px" width="50px"> <h3 class="d-inline-block text-gs fullName" id=" fullName">'+parsedResponse.inquiries.sFirstName+' '+parsedResponse.inquiries.sLastName+'</h3></a></div>';
        //                             buildColTwo += '<table class="table table-borderless" id="showArtDeet" style="font-size:12px">';
        //                             buildColTwo += '<tbody><tr><th scope="row">Submitted: </th><td>'+parsedResponse.inquiries.dateTime+'</td></tr><tr><th scope="row">Location: </th><td class="location">'+parsedResponse.inquiries.sCityName+', '+parsedResponse.inquiries.statecode+' '+parsedResponse.inquiries.iZipcode+'</td></tr><tr><th scope="row">Age: </th><td class="age">'+parsedResponse.inquiries.dDOB+'</td></tr>';
        //                             buildColTwo += '<tr><th scope="row">Talent(s): </th><td>';    
        //                             /**** Build Talent table ****/
        //                                 var talNumb = parsedResponse.curr_artist_talents.length;
        //                                 var buildColTwo_tal_table = ''
        //                                 if(talNumb >=1){
        //                                     buildColTwo_tal_table +=  '<ol class="p-0 m-0">';
        //                                     for(var i = 0;i<talNumb;i++){

        //                                         buildColTwo_tal_table +=  '<li>'+parsedResponse.curr_artist_talents[i]+'</li>';
        //                                     }
        //                                     buildColTwo_tal_table +=  '</ol>';
        //                                 }
        //                                 buildColTwo += buildColTwo_tal_table;
        //                             /* END - Build Talent table */
        //                             buildColTwo += '</td></tr><tr><th scope="row">Email: </th><td class="email">'+parsedResponse.inquiries.sContactEmailID+'</td></tr><tr><th scope="row">Phone #: </th><td class="phone">'+parsedResponse.inquiries.sContactNumber+'</td></tr><tr><th scope="row">Comments: </th><td class="comments">'+parsedResponse.inquiries.comments+'</td></tr></tbody></table>';
        //                             if(parsedResponse.inquiries.upcoming){
        //                                 if( inquiryWithdrawn == 1){
        //                                     buildColTwo += '<div class="manAction font-weight-bold"><table class="table table-borderless" id="showArtDeet" style="font-size:12px;">';
        //                                     buildColTwo += '<tbody><tr><th style="font-weight: bold">Playing Status: </th><td>Bid Withdrawn</td></tr>';
        //                                     buildColTwo += '<tr><th>Cancel Reason: </th><td>'+withdrawReason+'</td></tr>';
        //                                     buildColTwo += '<tr><th>Cancel Date/time: </th><td>'+withdrawDatetime+'</td></tr></tbody>';
        //                                     buildColTwo += '</table></div>';
        //                                 }
        //                                 else if(parsedResponse.selected_artist != null && iLoginID === parsedResponse.selected_artist.artist_selected){
        //                                     buildColTwo += '<div class="manAction2"><h4 class="font-weight-bold text-gs">Artist Selected</h4><button type="button" class="btn btn-sm btn-gs sendID"  manID="'+parsedResponse.inquiries.gigManID+'" artistType="'+parsedResponse.inquiries.artistType+'" artistID="'+parsedResponse.inquiries.iLoginID+'" id="deSelectArtist" >De-Select This Artist</button></div>';
        //                                 }
        //                                 else if(curr_artist_selected){
        //                                     buildColTwo += '<div class="manAction"><button type="button" class="btn btn-sm btn-gs" data-toggle="modal" data-target="#deselect-artist-1st">Select This Artist</button></div> ';
        //                                 }
        //                                 else{
        //                                     buildColTwo += '<div class="manAction"><button type="button" class="btn btn-sm btn-gs sendID" manID="'+parsedResponse.inquiries.gigManID+'" artistType="'+parsedResponse.inquiries.artistType+'" artistID="'+parsedResponse.inquiries.iLoginID+'"  id="selectArtist" >Select This Artist</button></div> ';
        //                                 }  
                                        
        //                             }
        //                             buildColTwo += '<div class="text-center text-danger" id="gig_man_err"></div></div>';
        //                     /* END - Parse the ResponseText as an xml string */

                           

        //                     /* append to #infoDisplay div */
        //                         $('#colTwo').html(buildColTwo);

        //                     /* Display modal if screen is less than 768px */
        //                         var w = window.innerWidth; 
        //                         if(viewMore && w <= 768){
        //                             $('.submissionDateTime').html(parsedResponse.inquiries.dateTime);
        //                             $('.fullName').html(parsedResponse.inquiries.sFirstName+' '+parsedResponse.inquiries.sLastName);
        //                             $('.artistProfile').attr('href','https://www.gospelscout.com/views/artistprofile.php?artist='+parsedResponse.inquiries.iLoginID);
        //                             $('.profPic').attr('src',parsedResponse.inquiries.sProfileName);
        //                             $('.location').html(parsedResponse.inquiries.sCityName+', '+parsedResponse.inquiries.statecode+' '+parsedResponse.inquiries.iZipcode);
        //                             $('.age').html(parsedResponse.inquiries.dDOB);
        //                             $('.email').html(parsedResponse.inquiries.sContactEmailID);
        //                             $('.phone').html(parsedResponse.inquiries.sContactNumber);
        //                             $('.comments').html(parsedResponse.inquiries.comments);
        //                             $('#show-artist-sm').modal('show'); 
        //                             $('.tals').html(buildColTwo_tal_table);

        //                         }
        //                 }
        //             }
        //             getArtistDeets.open('get','https://www.gospelscout.com/publicgigads/test/phpBackend/connectToDb_ad_details.php?u_id='+iLoginID+'&g_id='+gigId+'&tal_tracker_id='+curr_tal_tracker);
        //             getArtistDeets.send()
        //         }
        //     /* END - Use XMLHttpRequest to fetch artist info */
        // }
/**************************************************************
 *** END - Create funciton to retrieve and display artist info
 **************************************************************/


/*************************************************
 *** Build Column 1 to dipslay artist inquiry
 *************************************************/
//  function buildColOne(artistInq){

//     var buildColOne = '<div class="col col-md-6" style="font-size: 13px;"><table class="table"><thead><tr><th>Name</th><th>City</th><th>Age</th><th></th></tr></thead><tbody>';
//     for(x in artistInq){
//         buildColOne += '<tr class= "artistRow';
//             if(x == 0){
//                  buildColOne += ' showing';
//             }
//         buildColOne += '"><td>'+artistInq[x].sFirstName+' '+artistInq[x].sLastName+'</td><td>'+artistInq[x].sCityName+', '+artistInq[x].statecode+'</td><td>'+artistInq[x].dDOB+'</td><td><a class="text-gs getArtistDeets" href="#" id="'+x+'" iLoginID="'+artistInq[x].iLoginID+'">view more</a></td></tr>';
//     }
//     buildColOne += '</tbody></table></div>';
//     var buildColTwo = '<div class="col col-md-6 p-2 p-lg-3 d-none d-md-block" id="colTwo" style="border: 1px solid rgba(149,73,173,1);box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);min-height:400px"></div>';
//     getArtistInfo(artistInq[0].iLoginID,artistInq[0].gigId);

//     return buildColOne + buildColTwo;       
//  }
/**************************************************
 *** END - Build Column 1 to dipslay artist inquiry
 **************************************************/


/********************************************************
 *** Create funciton to retrieve and display artist info
 ********************************************************/
 function getArtistInfo(iLoginID,gigId,gmRequested,viewMore, tal_tracker){ 
    
    /* show loading spinwheel */
        displayLoadingElement('colTwo');

    /* Get current tal_tracker */
        // var curr_tal_tracker = $('input[name=curr_tal_tracker]').val(); 
        var curr_tal_tracker = tal_tracker;

        console.log(`iLoginId: ${iLoginID}`, `gigId: ${gigId}`,`gmRequested: ${gmRequested}`,`viewMore: ${viewMore}`,`curr_tal_tracker: ${curr_tal_tracker}`);
                        
    /**** Use XMLHttpRequest to fetch artist info ****/
        if(iLoginID > 0 ){
            var getArtistDeets = new XMLHttpRequest();
            getArtistDeets.onload = function(){
                if(getArtistDeets.status == 200){

                    
                    /**** Parse the ResponseText as an xml string ****/
                        var response = getArtistDeets.responseText.trim();console.log(response);
                        var parsedResponse = JSON.parse(response);
                        // console.log(parsedResponse.inquiries.gigManID);
                        // console.log(gmRequested);
                        var inquiryWithdrawn = parsedResponse.inquiries.inquiry_withdrawn;
                        if(inquiryWithdrawn){
                            var withdrawReason = parsedResponse.inquiries.withdraw_reason;
                            var withdrawDatetime = parsedResponse.inquiries.withdraw_dateTime;
                        }
                        var curr_artist_selected = '';

                        /* check if current artist is a selected artist for the gig */
                            if(parsedResponse.all_selected_artists !== null){
                                for(sel_artist in parsedResponse.all_selected_artists){
                                    if(parsedResponse.all_selected_artists[sel_artist].artist_selected == iLoginID){
                                        curr_artist_selected = true; 
                                        break;
                                    }
                                    else{
                                        curr_artist_selected = false; 
                                    }
                                }
                            }

                        /* Insert proper modal text based on a currently selected artist */
                        console.log(parsedResponse.selected_artis);
                            if(parsedResponse.selected_artist !== null ){ //parsedResponse.selected_artist.tal_tracker_id == curr_tal_tracker){
                                var modalText = '<a href="https://www.gospelscout.com/newHomePage/views/artistprofile.php?artist='+parsedResponse.selected_artist.artist_selected+'" class="font-weight-bold text-gs" target="_blank">'+parsedResponse.selected_artist.sFirstName+' '+parsedResponse.selected_artist.sLastName+'</a> is currently selected for this position. By clicking confirm, this artist will be replaced  with the newly selected artist.';
                                console.log(parsedResponse.selected_artist);
                                $('#selectThisArtist').attr('replaceArtist', 'true');
                                $('#selectThisArtist').attr('selArtistId', parsedResponse.selected_artist.artist_selected);
                                $('#modalMessage').html(modalText);
                            }
                            else{
                                var modalText = 'Once an artist is selected, this gig post will be automatically removed from the posted gigs page and will no longer be publicly viewable.  Please confirm artist selction below.';
                                $('#selectThisArtist').attr('replaceArtist', 'false');
                                $('#selectThisArtist').attr('selArtistId', 0);
                                $('#modalMessage').text(modalText);
                            }

                            var buildColTwo = '<div class="mb-2"><a class="artistProfile" href="https://www.gospelscout.com/newHomePage/views/artistprofile.php?artist='+parsedResponse.inquiries.iLoginID+'" target="_blank" style="text-decoration: none; "><img class="aProfPic profPic" src="'+parsedResponse.inquiries.sProfileName+'" height="50px" width="50px"> <h3 class="d-inline-block text-gs fullName" id=" fullName">'+parsedResponse.inquiries.sFirstName+' '+parsedResponse.inquiries.sLastName+'</h3></a></div>';
                            buildColTwo += '<table class="table table-borderless" id="showArtDeet" style="font-size:12px">';
                            if(gmRequested == 1){
                                buildColTwo += '<tbody><tr><th scope="row">Requested: </th>';
                            }else{
                                buildColTwo += '<tbody><tr><th scope="row">Submitted: </th>';
                            }
                            buildColTwo += '<td>'+parsedResponse.inquiries.dateTime+'</td></tr>';
                            
                            var response_text_color = '';
                            if(parsedResponse.inquiries.artist_response === 'confirmed'){
                                response_text_color = 'text-success';
                            }else if(parsedResponse.inquiries.artist_response === 'pending'){
                                response_text_color = 'text-warning';
                            }else if(parsedResponse.inquiries.artist_response === 'declined'){
                                response_text_color = 'text-danger';
                            }
                            buildColTwo += '<tr><th>Playing Status: </th><td class="'+response_text_color+'">'+parsedResponse.inquiries.artist_response+'</td></tr>';
                            buildColTwo += '<tr><th scope="row">Location: </th><td class="location">'+parsedResponse.inquiries.sCityName+', '+parsedResponse.inquiries.statecode+' '+parsedResponse.inquiries.iZipcode+'</td></tr><tr><th scope="row">Age: </th><td class="age">'+parsedResponse.inquiries.dDOB+'</td></tr>';
                            buildColTwo += '<tr><th scope="row">Talent(s): </th><td>';    
                            /**** Build Talent table ****/
                                var talNumb = parsedResponse.curr_artist_talents.length;
                                var buildColTwo_tal_table = ''
                                if(talNumb >=1){
                                    buildColTwo_tal_table +=  '<ol class="p-0 m-0">';
                                    for(var i = 0;i<talNumb;i++){

                                        buildColTwo_tal_table +=  '<li>'+parsedResponse.curr_artist_talents[i]+'</li>';
                                    }
                                    buildColTwo_tal_table +=  '</ol>';
                                }
                                buildColTwo += buildColTwo_tal_table;
                            /* END - Build Talent table */
                            buildColTwo += '</td></tr><tr><th scope="row">Email: </th><td class="email">'+parsedResponse.inquiries.sContactEmailID+'</td></tr><tr><th scope="row">Phone #: </th><td class="phone">'+parsedResponse.inquiries.sContactNumber+'</td></tr><tr><th scope="row">Comments:</th><td class="comments">'+parsedResponse.inquiries.comments+'</td></tr></tbody></table>';
                            console.log(curr_artist_selected);
                            console.log(gmRequested, parsedResponse);
                            if(parsedResponse.inquiries.upcoming){
                                var actionButt = '';
                                if( inquiryWithdrawn == 1){
                                    actionButt += '<div class="manAction font-weight-bold"><table class="table table-borderless" id="showArtDeet" style="font-size:12px;">';
                                    actionButt += '<tbody><tr><th style="font-weight: 900">Playing Status: </th><td>Bid Withdrawn</td></tr>';
                                    actionButt += '<tr><th>Cancel Reason: </th><td>'+withdrawReason+'</td></tr>';
                                    actionButt += '<tr><th>Cancel Date/time: </th><td>'+withdrawDatetime+'</td></tr></tbody>';
                                    actionButt += '</table></div>';
                                }
                                else if(parsedResponse.selected_artist != null && iLoginID === parsedResponse.selected_artist.artist_selected){
                                    actionButt += '<div class="manAction2"><button type="button" class="btn btn-sm btn-danger sendID"  manID="'+parsedResponse.inquiries.gigManID+'" artistType="'+parsedResponse.inquiries.artistType+'" artistID="'+parsedResponse.inquiries.iLoginID+'" id="deSelectArtist" >Cancel This Artist</button></div>';//<h4 class="font-weight-bold text-gs">Artist Selected</h4>
                                }
                                else if(gmRequested == 1){ console.log(parsedResponse.inquiries.artist_response);
                                    var status = parsedResponse.inquiries.artist_response;
                                    
                                    if(status === 'pending'){
                                        actionButt += '<div class="manAction text-gs">Artist&apos;s Response Pending</div><div class="mt-2"><button type="button" class="btn btn-sm btn-gs" id="canc-art-requ" gigid="'+gigId+'" gigManId="'+parsedResponse.inquiries.gigManID+'" uid="'+parsedResponse.inquiries.iLoginID+'">Cancel Request</button></div>';
                                    }else if(status === 'confirmed'){
                                        if(curr_artist_selected){
                                            actionButt += '<div class="manAction"><button type="button" class="btn btn-sm btn-gs" data-toggle="modal" data-target="#deselect-artist-1st">Select This Artist</button></div> ';
                                        }
                                        else{
                                            actionButt += '<div class="manAction"><button type="button" class="btn btn-sm btn-gs sendID" manID="'+parsedResponse.inquiries.gigManID+'" artistType="'+parsedResponse.inquiries.artistType+'" artistID="'+parsedResponse.inquiries.iLoginID+'"  id="selectArtist" >Select This Artist</button></div> ';
                                        }  
                                    }else if(status === 'declined'){
                                        actionButt += '<div class="manAction text-danger"><p>Artist has declined this gig</p></div>';

                                        if(parsedResponse.inquiries.artist_decl_reason !== null){
                                            var reason = parsedResponse.inquiries.artist_decl_reason;
                                            actionButt += '<table class="m-0 table table-borderless" style="font-size:.8em;background-color:rgba(0,0,0,.08)"><tbody><tr><th>Reason:</th><td> '+reason+'</td></tr></tbody></table>';
                                        }
                                    }
                                }
                                else if(curr_artist_selected){
                                    actionButt += '<div class="manAction"><button type="button" class="btn btn-sm btn-gs" data-toggle="modal" data-target="#deselect-artist-1st">Select This Artist1</button></div> ';
                                }
                                else{
                                    actionButt += '<div class="manAction"><button type="button" class="btn btn-sm btn-gs sendID" manID="'+parsedResponse.inquiries.gigManID+'" artistType="'+parsedResponse.inquiries.artistType+'" artistID="'+parsedResponse.inquiries.iLoginID+'"  id="selectArtist" >Select This Artist2</button></div> ';
                                } 
                                buildColTwo += actionButt; 
                            }
                            buildColTwo += '<div class="text-center text-danger" id="gig_man_err"></div></div>';
                    /* END - Parse the ResponseText as an xml string */

                    /* append to #infoDisplay div */
                        $('#colTwo').html(buildColTwo);

                    /* Display modal if screen is less than 768px */
                        var w = window.innerWidth; 
                        if(viewMore && w <= 768){
                            if(gmRequested == 1){
                                $('#subOrReq').html('Requested');
                            }else{
                                $('#subOrReq').html('Submitted');
                            }
                            $('.submissionDateTime').html(parsedResponse.inquiries.dateTime);
                            $('.playStatus').html(parsedResponse.inquiries.artist_response);
                            $('.fullName').html(parsedResponse.inquiries.sFirstName+' '+parsedResponse.inquiries.sLastName);
                            $('.artistProfile').attr('href','https://www.gospelscout.com/newHomePage/views/artistprofile.php?artist='+parsedResponse.inquiries.iLoginID);
                            $('.profPic').attr('src',parsedResponse.inquiries.sProfileName);
                            $('.location').html(parsedResponse.inquiries.sCityName+', '+parsedResponse.inquiries.statecode+' '+parsedResponse.inquiries.iZipcode);
                            $('.age').html(parsedResponse.inquiries.dDOB);
                            $('.email').html(parsedResponse.inquiries.sContactEmailID);
                            $('.phone').html(parsedResponse.inquiries.sContactNumber);
                            $('.comments').html(parsedResponse.inquiries.comments);
                            $('#sm-screen-modal-display').html(actionButt);
                            $('#show-artist-sm').modal('show'); 
                            $('.tals').html(buildColTwo_tal_table);
                        }
                }
            }
            getArtistDeets.open('get','https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php?u_id='+iLoginID+'&g_id='+gigId+'&tal_tracker_id='+curr_tal_tracker);
            getArtistDeets.send()
        }
    /* END - Use XMLHttpRequest to fetch artist info */
}
/**************************************************************
*** END - Create funciton to retrieve and display artist info
**************************************************************/

/*************************************************
*** Build Column 1 to dipslay artist inquiry
*************************************************/
function buildColOne(artistInq){
console.log(artistInq);
var buildColOne = '<div class="col col-md-6" style="font-size: 13px;"><table class="table"><thead><tr><th>Name</th><th>City</th><th>Age</th><th></th></tr></thead><tbody>';
for(x in artistInq){
buildColOne += '<tr class= "artistRow';
    if(x == 0){
         buildColOne += ' showing';
    }
buildColOne += '"><td>'+artistInq[x].sFirstName+' '+artistInq[x].sLastName+'</td><td>'+artistInq[x].sCityName+', '+artistInq[x].statecode+'</td><td>'+artistInq[x].dDOB+'</td><td><a class="text-gs getArtistDeets" tal_tracker="'+artistInq[x].tal_tracker_id+'" href="#" id="'+x+'" iLoginID="'+artistInq[x].iLoginID+'">view more</a></td></tr>';
}
buildColOne += '</tbody></table></div>';
var buildColTwo = '<div class="col col-md-6 p-2 p-lg-3 d-none d-md-block" id="colTwo" style="border: 1px solid rgba(149,73,173,1);box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);min-height:400px"></div>';
getArtistInfo(artistInq[0].iLoginID,artistInq[0].gigId,artistInq[0].gmRequested,false,artistInq[x].tal_tracker_id);

return buildColOne + buildColTwo;       
}
/**************************************************
*** END - Build Column 1 to dipslay artist inquiry
**************************************************/


/*************************************************
*** Build Column 1 to dipslay playing artist
*************************************************/
function buildColOne1(results){
    var artistInq = results.playingArtists;
    console.log(artistInq); 
    var buildColOne = `<div class="col col-md-6" style="font-size: 13px;"><table class="table"><thead><tr><th>Name</th><th>Talent</th><th>Date Selected</th><th></th></tr></thead><tbody>`;
    for(x in artistInq){
        buildColOne += `<tr class= "artistRow`;
            if(x == 0){
                buildColOne += ` showing`;
            }
        buildColOne += `"><td>${artistInq[x].sFirstName} ${artistInq[x].sLastName}</td><td>${artistInq[x].sGiftName}</td><td>${artistInq[x].dateTimeSelected}</td><td><a class="text-gs getArtistDeets" href="#" id="${x}" iLoginID="${artistInq[x].artist_selected}" tal_tracker="${artistInq[x].tal_tracker_id}">view more</a></td></tr>`;//'+artistInq[x].sCityName+', '+artistInq[x].statecode+`;
    }
    buildColOne += `</tbody></table></div>`;
    var buildColTwo = `<div class="col col-md-6 p-2 p-lg-3 d-none d-md-block" id="colTwo" style="border: 1px solid rgba(149,73,173,1);box-shadow: -1px 2px 10px 0px rgba(0,0,0,1);min-height:400px"></div>`;

    getArtistInfo(artistInq[0].artist_selected,artistInq[0].gigid,2,false,artistInq[0].tal_tracker_id);
    return buildColOne + buildColTwo;       
}
/**************************************************
*** END - Build Column 1 to dipslay playing artist
**************************************************/

/*************************************************
 *** Get Playing artists info
 *************************************************/
function getPlayingArtistInfo(tal_tracker){//iLoginID, gigId
    /* query db for artist info */
        var getArtistInfo = new XMLHttpRequest();
        getArtistInfo.onload = () => {
            if(getArtistInfo.status == 200){
                var response = getArtistInfo.responseText.trim();//console.log(response);
                var parsedResponse = JSON.parse(response);console.log(parsedResponse);

                if(parsedResponse.artist_found == true){
                    var buildColTwo = `<div class="mb-2"><a class="artistProfile" href="https://dev.gospelscout.com/newHomePage/views/artistprofile.php?artist=${parsedResponse.artist_selected}" target="_blank" style="text-decoration: none; "><img class="aProfPic profPic" src="${parsedResponse.sProfileName}" height="50px" width="50px"> <h3 class="d-inline-block text-gs fullName" id=" fullName">${parsedResponse.sFirstName} ${parsedResponse.sLastName}</h3></a></div>`;
                    buildColTwo += `<table class="table table-borderless" id="showArtDeet" style="font-size:12px">`;
                    buildColTwo += `<tr><th>Location:</th><td>${parsedResponse.sCityName}, ${parsedResponse.statecode} ${parsedResponse.iZipcode}</td></tr>`;
                    buildColTwo += `<tr><th>Age:</th><td>${parsedResponse.dDOB}</td></tr>`;
                    buildColTwo += `<tr><th>Email:</th><td>${parsedResponse.sContactEmailID}</td></tr>`;
                    buildColTwo += `<tr><th>Phone #:</th><td>${parsedResponse.sContactNumber}</td></tr>`;
                    buildColTwo += `</table>`;

                    buildColTwo += `<div class="manAction2 bg-success" style="position:absolute; bottom: 5px;"><button type="button" class="btn btn-sm btn-danger sendID"  manID="${parsedResponse.gigManLoginId}" artistType="${parsedResponse.artistType}" artistID="${parsedResponse.artist_selected}" id="deSelectArtist" >Cancel This Artist</button></div>`;
                    /* append to #infoDisplay div */
                        $('#colTwo').html(buildColTwo);
                    
                }else{

                }
            }
        }
        getArtistInfo.open('get',`https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php?get_playing_artists=true&tal_tracker=${tal_tracker}`);
        getArtistInfo.send();
}
/*************************************************
 *** END - Get Playing artists info
 *************************************************/

/*************************************************
 *** Get all artist inquiries
 *************************************************/
 function getAllArtistInquiries(gmRequested){

     /* Show loading spinwheel */
        displayLoadingElement('infoDisplay');

    /* Get all artist inquiries on page load */
        var get_1st_tal_tracker = $('input[name=curr_tal_tracker]').val(); 
        var gigId = $('input[name=gigID]').val();

        if(gmRequested !== 2){
            $('input[name=gmRequested]').val(gmRequested);
            $('#talent-navbar').removeClass('d-none');
        }else{
            $('#talent-navbar').addClass('d-none');
        }
		
        var get_all_inquiries = new XMLHttpRequest(); 
        get_all_inquiries.onload = function(){
            if(get_all_inquiries.status == 200){
                var response = get_all_inquiries.responseText.trim();console.log(response); 
                var parsedResponse = JSON.parse(response);
                console.log(parsedResponse);
                
				if(gmRequested == 2){
                    if(parsedResponse.playingArtists.length > 0 ){
                        $('#infoDisplay').html( buildColOne1(parsedResponse) );
                    }else{
                        $('#infoDisplay').html( '<div class="col-12 text-center mt-5" style="color: rgba(204,204,204,1)"><h4>No Artists Have Been Selected for this Gig</h4></div>');
                    }
                }else{
                    if(parsedResponse.all_inquiries){
                        $('#infoDisplay').html( buildColOne(parsedResponse.all_inquiries) );
                    }
                    else{
                        $('#infoDisplay').html( '<div class="col-12 text-center mt-5" style="color: rgba(204,204,204,1)"><h4>No Artists Have Submitted Inquiries for this Gig</h4></div>');
                    }
                }
            }
        }
        get_all_inquiries.open('get','https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php?get_all_inqu='+gigId+'&gmRequested='+gmRequested+'&tal_track='+get_1st_tal_tracker); //tal_type='+get_1st_tal
        get_all_inquiries.send(); 
    }
 /*************************************************
 *** END - Get all artist inquiries
 *************************************************/





