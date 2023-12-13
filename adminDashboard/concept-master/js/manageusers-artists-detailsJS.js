 /*Define user's id var */
     var userId = $('input[name=userID]').val();

/* Manually show and hide deactivation modals */
    $('#deactivate').on('show.bs.modal', function (e) {
        $('#deactErr').html('');
        $('#vidDeactReason').val('');
    });

    $('#deactArtistButton').click(function(event){
        var deactExplan = document.getElementById('vidDeactReason').value; 

        if(deactExplan){
            $('#deactivate').modal('hide');
            $('#confirmDeactivation').modal('show');
        }
        else{
            $('#deactErr').html('Reason for deactivation required!!!');
        }
    });
/* END - Manually show and hide deactivation modals */

/* Deactivate users account */
    $('#confDeactivate').click(function(event){
        var deactForm = document.forms.namedItem("deactivateAcct");
        console.log(deactForm);
        var deactFormObj = new FormData(deactForm);

        var sendDeact = new XMLHttpRequest();
        sendDeact.onreadystatechange = function(){
            if(sendDeact.status == 200 && sendDeact.readyState == 4){
                var deactReturn = sendDeact.responseText.trim();
                console.log(deactReturn);
                if(deactReturn > 0){
                    location.reload();
                }
            }
        }
        sendDeact.open('POST','https://www.gospelscout.com/adminDashboard/concept-master/adminDeact-acct.php');
        sendDeact.send(deactFormObj);
    });
/* END - Deactivate users account */

/* Activate User's Account */
    $('#confActivate').click(function(event){
        var adminID = $('input[name=AdminId]').val();

        var ActFormObj = new FormData(); 
        ActFormObj.append('activ', '1');
        ActFormObj.append('iLoginID', userId);
        ActFormObj.append('AdminId', adminID);

        var sendAct = new XMLHttpRequest();
        sendAct.onreadystatechange = function(){
            if(sendAct.status == 200 && sendAct.readyState == 4){
                var ActReturn = sendAct.responseText.trim();
                console.log(ActReturn);
                if(ActReturn > 0){
                    location.reload();
                }
            }
        }
        sendAct.open('POST','https://www.gospelscout.com/adminDashboard/concept-master/adminDeact-acct.php');
        sendAct.send(ActFormObj);
    });
/* END - Activate User's Account */

/* Delete User's Account */
    $('#confProfDelete').click(function(event){
        event.preventDefault(); 
        var user_id = $(this).attr('artistID');
        var adminID = $('input[name=AdminId]').val();
        console.log(user_id);

        /* Create new FormData Obj */
            var del_form = new FormData(); 
            del_form.append('del_user',user_id);
            del_form.append('AdminId',adminID);

        /* Create prof_del xhr */
            var prof_del_xhr = new XMLHttpRequest(); 
            prof_del_xhr.onload = function(){
                if(prof_del_xhr.status == 200){
                    console.log(prof_del_xhr.responseText.trim() );
                }
            }
            prof_del_xhr.open('post','https://www.gospelscout.com/adminDashboard/concept-master/adminDeact-acct.php');
            prof_del_xhr.send(del_form); 
    });

/* Create the fetchGigs Function */
    function fetchGigs(selection1, selection2, userId){
        var getGig = new XMLHttpRequest(); 
        getGig.onreadystatechange = function(){
            if(getGig.status == 200 && getGig.readyState == 4){
                if(getGig.responseText.trim() == 'noResults'){
                    $('#gigDiv').html('<div class="container mt-2 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">No Gigs Matching Criteria!!!</h1></div>');
                }
                else{
                    $('#gigDiv').html(getGig.responseText);
                }
            }
        }
       getGig.open('GET', 'https://www.gospelscout.com/adminDashboard/concept-master/adminGet-gig-event.php?sel1='+selection1+'&sel2='+selection2+'&u_ID='+userId);
       getGig.send();
   }
/* END - Create the fetchGigs Function */

/* Call fetchGigs function when page loads */
    var selection1 = $('#manStatus').val();
    var selection2 = $('#occurrance').val();
    var userId = $('input[name=userID]').val();

    fetchGigs(selection1, selection2, userId);
/* END - Call fetchGigs function when page loads */

/* Get selctor values for gig table */
    $('.getGigs').change(function(){
        var selection1 = $('#manStatus').val();
        var selection2 = $('#occurrance').val();
        var userId = $('input[name=userID]').val();

        /* Call fetchGigs function when new option is picked from the artist's gigs select menus */
            fetchGigs(selection1, selection2, userId)
    });
/* END - Get selctor values for gig table */

/* Fetch Video Flags */
    $('.fetchFlags').click(function(event){

        event.preventDefault();
        var userId = $('input[name=userID]').val();
        var vid_ID = $(this).attr('vidID');
        var numbFlags = $(this).attr('numbFlags');

        if(numbFlags > 0){
            var getFlags = new XMLHttpRequest();
            getFlags.onreadystatechange = function(){
                if(getFlags.readyState == 4 && getFlags.status == 200){
                    console.log(getFlags.responseText);
                    $('#displayFlags').html(getFlags.responseText);
                }
            }
            getFlags.open('GET', 'https://www.gospelscout.com/adminDashboard/concept-master/adminGet-vidFlags.php?u_ID='+userId+'&vid_ID='+vid_ID);
            getFlags.send();
        }
    });

/* Delete Artist Profile - archive the loginmaster and usermaster info*/


/*************************** Add Videos ***************************/
    /* When New video modal hidden, reset the form */
        $('#addVideo').on('hidden.bs.modal', function (e) {
            /* Call function to reset video form*/
                resetVidForm();
        })

    /* Validate the New video */
            var new_vid_form = $('#videoAddID');

            new_vid_form.validate({

            /* Error message placement and styling  */
                errorPlacement: function(error, element) {
                   error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                   console.log(error[0]['id']);
                    if(error[0]['id'] == 'videoSource-error'){
                        $('#step2-err').append(error)
                    }
                    else if(error[0]['id'] == 'vidTalent-error'){
                        $('#step1-err').append(error);
                    }
                    else{
                        element.after(error);
                    }
                },

            /* Submit the form */
                submitHandler: function(form) {
                /* Display loading spinwheel */
                    displayLoadingElement('contentContainer');  

                /* Prevent Users from embedding youtube links and uploading video simaltaneously */
                    // $('#vidName').val() != '' || $('#vidDescr').val() != '' || 
                    var vidMethod = '';
                    if($('#youtubeInput').val() != '' && ($('#videoFile').val() != '' || $('#thumbnailFile').val() != '')) {
                        /* print an error to the Modal */ 
                            $('#error-text').html('@ Step 2 - Choose Only One Option to Add Video');
                    }
                    else{
                        if($('#youtubeInput').val() != '' ){ //&& $('#vidTalent').val() != ''
                            
                            /* Check for valid embed url */
                                var valid_url = validateYouTubeUrl( $('#youtubeInput').val() );
                                if(valid_url){
                                    /* Define method type for GET Var*/
                                        vidMethod = 'youtube';
                                }
                                else{
                                    $('#error-text').html('Youtube link is invalid - refer to the "How?" link for instructions');
                                }
                        }
                        else{
                            if($('#vidTalent').val() != ''&& $('#vidName').val() != '' && $('#videoFile').val() != ''){ // && $('#vidDescr').val() != ''
                                /* Define method type for GET Var*/
                                    vidMethod = 'upload';   
                            }
                            else{
                                $('#error-text').html('Please Complete All Upload Fields');
                            }
                        }
                    }
                /* END - Prevent Users from embedding youtube links and uploading video simaltaneously */

                /* Upload new video to the database */
                    if(vidMethod != '') {
                        /* Instiate new form data obj */
                          var new_vid_formD = new FormData(form); 
                          new_vid_formD.append('videoType',vidMethod);
                          if(vidMethod == 'youtube'){
                            new_vid_formD.append('youtubeLink',valid_url);
                          }

                        /* Instiate new form xhr */
                            var new_vid_xhr = new XMLHttpRequest();
                            new_vid_xhr.onreadystatechange = function(){
                                if( new_vid_xhr.status == 200 && new_vid_xhr.readyState == 4 ){
                                    var response = new_vid_xhr.responseText.trim();
                                    //console.log(response);
                                    var parsedResponse = JSON.parse(response);

                                    if(parsedResponse.response){
                                        /* Hide video form modal and Call function to reset video form*/
                                            $('#addVideo').modal('hide');
                                            resetVidForm();

                                        /* Refresh the artist's video section */
                                            getTabData('Vid','artist',artist_id);
                                    }
                                    else{
                                        $('#error-text').html(parsedResponse.err);
                                    }
                                }
                            }

                            /* Calculate and display the file upload progress */
                                var serverUploadProgress = document.querySelector('.serverUpload');
                                new_vid_xhr.upload.addEventListener('progress', function(e){
                                    // console.log('loaded: '+e.loaded+' and Total: '+e.total+'loaded/total: '+(Math.ceil((e.loaded/e.total) * 100) + '%'));
                                    var percentLoaded = Math.ceil((e.loaded/e.total) * 100); 
                                    if (percentLoaded <= 100) {
                                        serverUploadProgress.style.width = percentLoaded + '%';
                                        serverUploadProgress.textContent = percentLoaded + '%';
                                    }
                                }, false);

                            new_vid_xhr.open('post', 'https://www.gospelscout.com/views/fileUpload.php')
                            new_vid_xhr.send(new_vid_formD);
                    }
                    else{
                        console.log('vidMethod is empty');
                    }
                /* END - Upload new video to the database */
                },
            /* END - Submit the form */

                groups: {
                    videoSource: 'youtubeLink videoFile'
                },

            /* Set validation rules for the form */
                rules:{
                  VideoTalentID: {
                    required: true,
                  },
                  youtubeLink: {
                    require_from_group: [1, '.vid_source']
                  },
                  videoFile: {
                    require_from_group: [1, '.vid_source'],
                    accept: "video/*"
                  },
                   thumbnailFile: {
                        required: {
                            depends: function(element){
                                return $('#videoFile').val();
                            }
                        },
                        accept: "image/*"
                    },
                  videoName: {
                        required: {
                            depends: function(element){
                                return $('#videoFile').val();
                            }
                        }
                    },
                },
                messages: {
                  VideoTalentID: {
                    required: 'Select a talent',
                  },
                  videoName: {
                    required: 'Give your video a title',
                  },
                  videoFile:{
                    accept: 'Please upload video files only'
                  },
                  thumbnailFile:{
                    required: 'Select Thumbnail Img',
                    accept: 'Image files only for thumbnails'
                  }
                }
            });
        /* END - Validate the New video */

/*************************** END - Add Videos ***************************/

/* Fetch videos */
    getTabData('Vid','artist',artist_id);
/* END - Fetch videos */

/*************************** Delete Videos ***************************/
    /* Get video data to insert into the video deletion form */
        $('#contentContainer').on('click','.getVidInfo',function(event){
            event.preventDefault(); 

            var v_id = $(this).attr('vidID');
            var v_thumbPath = $(this).attr('thumbPath');
            var v_videoPath = $(this).attr('vidPath');

            $('input[name=id]').val(v_id);
            $('input[name=currentThumbnailPath]').val(v_thumbPath);
            $('input[name=currentVideoPath]').val(v_videoPath);
            $('#err_mess').addClass('d-none');
            $('textarea[name=vidDelReason]').css('box-shadow', 'none'); //0px 0px 5px 0px red

            $('#deleteVid').modal('show');
        });
    /* Reset form when video deletion is canceled */
        function formReset(){
            $('textarea[name=vidDelReason]').val('');
            $('textarea[name=deletionReason]').val('');
        }
    /* Require administrator to give reason for deleting the video */
        $('#remVidButt').click(function(event){
            var vidDelReason = $('textarea[name=vidDelReason]').val();

            if(vidDelReason != ''){
                $('#deleteVid').modal('hide');
                $('#confirmVidDeletion').modal('show');
            }
            else{
                $('#err_mess').removeClass('d-none');
                $('textarea[name=vidDelReason]').css('box-shadow', '0px 0px 5px 0px red')
                $('#err_mess p').html('Please Provide A Reason For Deleting This Video!');
            }
        });

    $('#confVidRemoval').click(function(event){
        event.preventDefault(); 

        var vidDelForm = document.forms.namedItem('deleteVid');
        var vidDelForm1 = new FormData(vidDelForm);
        var sendDelForm = new XMLHttpRequest(); 
        sendDelForm.onreadystatechange = function(){
            if(sendDelForm.readyState == 4 && sendDelForm.status == 200){
                
                var response  = sendDelForm.responseText.trim();
                console.log( response);
                var parsedResponse = JSON.parse(response);

                if(parsedResponse.response){
                    /* Refresh the artist's video section */
                        getTabData('Vid','artist',artist_id);
                }
            }
        }
        sendDelForm.open('post','https://www.gospelscout.com/views/fileUpload.php');
        sendDelForm.send(vidDelForm1);
    });
/************************ END - Delete Videos ***********************/