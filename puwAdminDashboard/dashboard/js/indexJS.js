


/********************
*** Date/Time Picker
********************/
 $(function () {
    var dat = $("input[name=todaysDate]").val();

    $("#datetimepicker0").datetimepicker({
        format: "YYYY-MM-DD",
        defaultDate: false,
        maxDate: dat,
        //minDate: moment(),
        // maxDate: moment().subtract(10,'year'),
        //useCurrent: true, 
        allowInputToggle: true
    });

    $("#datetimepicker1").datetimepicker({
        format: "LT",
        stepping: "5",
        useCurrent: false,
        allowInputToggle: true
     });

    $("#datetimepicker2").datetimepicker({
        format: "LT",
        stepping: "5",
        useCurrent: false,
        allowInputToggle: true
    });

    $("#datetimepicker3").datetimepicker({
        format: "LT",
        stepping: "5",
        useCurrent: false,
        allowInputToggle: true
    });

    $("#datetimepicker4").datetimepicker({
        format: "LT",
        stepping: "5",
        useCurrent: false,
        allowInputToggle: true
    });
});

/*************************
*** END - Date/Time Picker
*************************/

/********************
*** Veiw Event Action
********************/
    $('.getEvent').click(function(e){
        /* prevent default */
            e.preventDefault(); 

        /* Get Event ID */
            let eventID = $(this).attr('id');

        /* Query Database for event info */

            var xhr = new XMLHttpRequest(); 
            xhr.onload = function(){
                if(xhr.status == 200 && xhr.readyState == 4){
                    console.log(xhr.responseText);

                    /* Get Event Form */    
                        let eventForm = $('form[name=editEvent]').serializeArray();

                    /* Parse Json Response */    
                        let parsedEvents = JSON.parse(xhr.responseText);
                        let eventDeets = parsedEvents[0];
                        let eventAttendees = parsedEvents[1];
                        let eventArtists = parsedEvents[2];

                        console.log(eventArtists.length);

                    /* Insert values for event returned */
                        for(let i in parsedEvents[0]){

                            for( let j=0; j<eventForm.length; j++){
                                if(i == eventForm[j].name){
                                    console.log(i);
                                    $('input[name='+i+']').val( parsedEvents[0][i] );
                                    $('select[name='+i+']').val( parsedEvents[0][i] );
                                    $('textarea[name='+i+']').val( parsedEvents[0][i] ) ;
                                }
                            }

                            let hostDeets = $('.eventHost');
                            for(let k=0;k<hostDeets.length; k++){
                                if( i == hostDeets[k].id ){
                                    hostDeets[k].innerHTML = parsedEvents[0][i];
                                }
                                
                            }
                        }

                    /* Insert event artists into modal table */
                        let tableVar = '';
                        if(eventArtists.length > 0){

                            tableVar += '<table class="table text-center" style="font-size: 12px;"><thead> <tr> <th>Name</th> <th class="d-none d-md-table-cell">Email</th> <th class="d-none d-md-table-cell">Phone</th> <th class="d-none d-md-table-cell">Status</th> <th>cancel</th> </tr> </thead>';
                            for( let h=0; h<eventArtists.length; h++){
                                if(eventArtists[h].sContactNumber == 0){
                                    eventArtists[h].sContactNumber = 'N/A';
                                }
                                tableVar += '<tr> <td>'+eventArtists[h].sFirstName+'</td> <td class="d-none d-md-table-cell">'+eventArtists[h].sContactEmailID+'</td> <td class="d-none d-md-table-cell">'+eventArtists[h].sContactNumber+'</td> <td class="d-none d-md-table-cell">confirmed</td> <td><a href="#">cancel</a></td> </tr>'
                            }
                            tableVar += '</table>';
                            
                            $('#artistNumb').html(eventArtists.length);
                        }
                        else{
                            tableVar = '<div class="text-center"style="font-size:1.5em;color:rgba(0,0,0,.2)">No Artists Booked</div>';
                            $('#artistNumb').html(0);   
                        }

                        $('#artistDisplay').html(tableVar);

                        /* hide 'addPuwArtist button if max # of artist booked */
                            if(eventArtists.length == 3){
                                $('#addPuwArtist').addClass('d-none');
                            }

                    /* Show the view/edit event modal */
                        $('#veiw-edit-event').modal('show');
                    
                }
            }
            xhr.open('get','phpBackend/connectToDb.php?eventID='+eventID);
            xhr.send(); 
    });
/********************
*** END - Veiw Event Action
********************/
