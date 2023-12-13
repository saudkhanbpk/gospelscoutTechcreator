
/* New Event JavaScript function page */
    
    function insertHosts(stateHosts){
        var codeInsert = '<ol class="pl-0">';

        for( host in stateHosts){
            codeInsert += '<div class="card my-0"><div class="card-header text-left" id="heading'+stateHosts[host].info.host_id+'"><h2 class="mb-0"><button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapse'+stateHosts[host].info.host_id+'" aria-expanded="true" aria-controls="collapse'+stateHosts[host].info.host_id+'"><li>'+stateHosts[host].info.host_address+' '+stateHosts[host].info.host_sCityName+', '+stateHosts[host].info.statecode+'</li></button></h2></div>';                              
            codeInsert += '<div id="collapse'+stateHosts[host].info.host_id+'" class="collapse py-0" aria-labelledby="heading'+stateHosts[host].info.host_id+'" data-parent="#accordionExample"><div class="card-body py-0 mt-0"><div class="container px-4 my-1 my-md-4 text-center"><div class="row text-center mb-0 loop_container">';
            codeInsert += '<div class="col col-md-10 my-2 mx-auto"><h4 style="background-color: rgb(233,234,237);">Contact Info</h4><table class="table text-left"><tr><th>First Name:</th><td id="host_fname">'+stateHosts[host].info.host_fname+'</td></tr><tr><th>Last Name:</th><td id="host_lname">'+stateHosts[host].info.host_lname+'</td></tr><tr><th>Email:</th><td id="host_email">'+stateHosts[host].info.host_email+'</td></tr><tr><th>Phone #:</th><td id="host_phone">'+stateHosts[host].info.host_phone+'</td></tr></table></div>';
            codeInsert += '<div class="col col-md-10 my-2 mx-auto"><h4 style="background-color: rgb(233,234,237);">Location</h4><table class="table text-left"><tr><th>Address:</th><td id="host_address">'+stateHosts[host].info.host_address+'</td></tr><tr><th>City:</th><td id="host_sCityName">'+stateHosts[host].info.host_sCityName+'</td></tr><tr><th>State:</th><td id="name">'+stateHosts[host].info.name+'</td></tr><tr><th>Zip code:</th><td id="host_zip">'+stateHosts[host].info.host_zip+'</td></tr></table></div>';
            codeInsert += '<div class="col col-md-10 my-2 mx-auto"><h4 style="background-color: rgb(233,234,237);">Addtl Deets</h4><table class="table text-left"><tr><th>Type of Space:</th><td id="buildingType">'+stateHosts[host].info.buildingType+'</td></tr><tr><th>Environment:</th><td id="environment">'+stateHosts[host].info.environment+'</td></tr><tr><th>Capacity:</th><td id="capacity">'+stateHosts[host].info.capacity+'</td></tr><tr><th> H-cap Accessible:</th><td id="hCapAccessible">'+stateHosts[host].info.hCapAccessible+'</td></tr><tr><th>Availability:</th><td><span id="startTime">'+stateHosts[host].info.startTime+'</span> - <span id="endTime">'+stateHosts[host].info.endTime+'</span></td></tr><tr><th class="align-top">Days Available:</th><td class="align-top" id="daysAvail_table"><ol class="pl-0" style="list-style:none;">';
            
            for(day in stateHosts[host].days){
                codeInsert += '<li>'+stateHosts[host].days[day]+'</li>';    
            }
            codeInsert += '</ol></td></tr><tr><th class="align-top">Images:</th><td class="align-top" id="imgs_table"><div class="container"><div class="row">';
            for(img in stateHosts[host].file_paths){
                codeInsert += '<div class="col col-md-3"><a class="imgPath" target="_blank" href="'+ stateHosts[host].file_paths[img] +'"><img class="featurette-image img-fluid mx-auto mb-2 mb-md-0" src="'+ stateHosts[host].file_paths[img] +'" width="300" height="300" data-src="" alt="Generic placeholder image"></a></div>';
            }
            codeInsert += '</div></div></td></tr><tr><th class="align-top">Noise Restrictions:</th><td class="align-top" id="noiseRestrictions">'+stateHosts[host].info.noiseRestrictions+'</td></tr><tr><th class="align-top">Addtl Info:</th><td class="align-top" id="addedInfo">'+stateHosts[host].info.addedInfo+'</td></tr></table></div>';
            codeInsert += '</div><div class="row text-center mb-0"><button class="btn btn-sm btn-gs" id="sel-host-button" hostID="'+stateHosts[host].info.host_id+'">Select Host</button></div></div></div></div></div>';
        }
        codeInsert += '</ol>';

        return codeInsert;
    }

    function insertArtists(stateArtists){

        /* Get all hidden inputs with class eventArtistsList - artist that have been selected */
            var eventArtistList = document.querySelectorAll('input.eventArtistsList');
            // console.log(eventArtistList);

        /* Build Html */
            codeInsert = '<table class="table text-center" style="font-size:.8em;">';
            codeInsert += '<thead><tr><th class="d-none d-md-table-cell">ID</th><th>Name</th><th>Age</th><th>Talent</th><th>Select Artist</th></tr></thead><tbody>';

            for(artist in stateArtists){
                console.log('test'+stateArtists[artist]);
                var theProperClass = 'selectArtist';
                var theInnerHtml = 'Select';
                /* Compare all artist returned in query with artists already selectd for event */
                    if(eventArtistList.length > 0){
                        for(let artCounter=0;artCounter<eventArtistList.length;artCounter++){
                            if(eventArtistList[artCounter].attributes.artistID.value == stateArtists[artist].iLoginID){
                                // console.log(eventArtistList[artCounter].value+'='+stateArtists[artist].iLoginID);
                                var theProperClass = 'de_selectArtist';
                                var theInnerHtml = 'De-Select'; 
                            }
                        }
                    }
               
               codeInsert += '<tr><td class="d-none d-md-table-cell"><a class="text-gs" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+stateArtists[artist].iLoginID+'">'+stateArtists[artist].iLoginID+'</a></td><td><a class="text-gs" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+stateArtists[artist].iLoginID+'">'+stateArtists[artist].sFirstName+'</a></td><td><a class="text-gs" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+stateArtists[artist].iLoginID+'">'+stateArtists[artist].age+'</a></td><td><a class="text-gs" target="_blank" href="https://www.gospelscout.com/views/artistprofile.php?artist='+stateArtists[artist].iLoginID+'">'+stateArtists[artist].talent+'</a></td><td><button style="font-size:.8em" class="btn btn-sm btn-gs '+theProperClass+'" artist_id="'+stateArtists[artist].iLoginID+'" artist_name="'+stateArtists[artist].sFirstName+'" artist_age="'+stateArtists[artist].age+'" artist_tal_id="'+stateArtists[artist].TalentID+'" artist_talent="'+stateArtists[artist].talent+'">'+theInnerHtml+'</button></td></tr>';
            }
            codeInsert += '</tbody></table>';

        /* Return the Html to be returned */
            return codeInsert;
    }



