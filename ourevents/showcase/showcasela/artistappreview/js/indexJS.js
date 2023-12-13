

getArtistSubmissions_xhr = new XMLHttpRequest(); 
getArtistSubmissions_xhr.onload = function(){
    if(getArtistSubmissions_xhr.status == 200){
        var response = getArtistSubmissions_xhr.responseText.trim();//console.log(response);
        var parsedResponse = JSON.parse(response);
        
        if( parsedResponse.err ){
            console.log('error present');
        }else{
            console.log(parsedResponse);

            
                // console.log( parsedResponse.result[x] );
            var artists = parsedResponse.result;
            var table = `<table class="table table-striped px-4" style="font-size:.8em">`;
            table += `<thead><tr><th scope="col">#</th><th scope="col">Name</th><th scope="col">Talent</th><th scope="col">Date Submitted</th><th scope="col">View Artist</th></tr></thead>`;
            table += `<tbody>`;
            for( x in artists){
                console.log(artists[x]);
                table += `<tr><th scope="row">${x}</th><td>${artists[x].name}</td><td>${artists[x].sGiftName}</td><td>${artists[x].dateTime}</td><td><a href="" class="getArtist" id="${artists[x].id}">View</a></td></tr>`;
            }
                table += `</tbody></table>`;

            $('#tableContainer').html(table);
        }
    }
}
getArtistSubmissions_xhr.open('get','https://www.stage.gospelscout.com/ourevents/showcase/showcasela/artistappreview/phpBackend/connectToDb.php?getArtistSubmission=true');
getArtistSubmissions_xhr.send(); 


/* Get Artist Info & call modal */
$('#tableContainer').on('click', '.getArtist', function(e){
    e.preventDefault(); 
    var submissionID = $(this).attr('id');

    // Fetch artist info
        var fetchArtist = new XMLHttpRequest();
        fetchArtist.onload = function(){
            if(fetchArtist.status == 200){
                var response = fetchArtist.responseText.trim(); //console.log(response);
                var parsedResponse = JSON.parse(response);
                
                if( parsedResponse.err == false){
                    // console.log(parsedResponse);
                    var artist = parsedResponse.result;
                    var artistInfo = `<table class="table table-borderless" style="font-size:.8em"><tbody>`;
                    artistInfo += `<tr><th scope="row">Name:</th><td>${artist.name}</td></tr><tr><th scope="row">Talent:</th><td>${artist.sGiftName}</td></tr><tr><th scope="row">Location:</th><td colspan="2">${artist.city}, ${artist.state} ${artist.zipcode}</td></tr>`;
                    artistInfo += `<tr><th scope="row">Date/Time:</th><td colspan="2">${artist.dateTime}</td></tr><tr><th scope="row">Email:</th><td colspan="2">${artist.email}</td></tr><tr><th scope="row">Phone:</th><td colspan="2">${artist.phone}</td></tr>`;
                    artistInfo += `<tr><th scope="row">Social Media:</th><td colspan="2">`;
                    artistInfo += `<table><tr><td><a href="${artist.ig}" target="_blank">Instagram</a></td></tr><tr><td><a href="${artist.fb}" target="_blank">FaceBook</a></td></tr><tr><td><a href="${artist.yt}" target="_blank">YouTube</a></td></tr></table>`;
                    artistInfo += `</td></tr></tbody></table>`;
                    $('#artistInfoContainer').html(artistInfo);
                    $('#viewArtist').modal('show');
                    
                }else{
                    console.log('fetching error');
                }
            }
        }
        fetchArtist.open('get',`https://www.stage.gospelscout.com/ourevents/showcase/showcasela/artistappreview/phpBackend/connectToDb.php?fetchArtist=${submissionID}`);
        fetchArtist.send();
});
     