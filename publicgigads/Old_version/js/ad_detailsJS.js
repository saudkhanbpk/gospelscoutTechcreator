/***********************************************
 *** Retrieve first artist's info automatically
 ***********************************************/
    var iLoginID0 = $('#0').attr('iLoginID');
    var gigId = $('input[name=gigID]').val();
    // var pageLoad = true; 
    // getArtistInfo(iLoginID0,gigId,pageLoad);

    /* Get all artist inquiries */
        getAllArtistInquiries();

/***********************************************
 *** END - Retrieve first artist's info automatically
 ***********************************************/

/****************************************************************
 *** Have to initailize the popover functionality for it to work
 ****************************************************************/
        $('[data-toggl="popover"]').click(function(event){
            event.preventDefault(); 
        });
        $(document).ready(function(){
            $('[data-toggl="popover"]').popover(); 
        });
 /****************************************************************
 *** END - Have to initailize the popover functionality for it to work
 ****************************************************************/

/********************************************************************
 *** Dismiss the gig-list-sm modal when the window is resized
 ********************************************************************/
        $(window).resize(function(){
            $('#show-artist-sm').modal('hide'); 
        });
/********************************************************************
 *** END - Dismiss the gig-list-sm modal when the window is resized
 ********************************************************************/


/********************************************************************
 *** When View More is clicked, retrieve the selected artist's info
 ********************************************************************/
    $('#infoDisplay').on('click', '.getArtistDeets', function(event){
        event.preventDefault();
        // $('#show-artist-sm').modal('show');
        /* highlight the selected artist's row */
            $('.artistRow').removeClass('showing');
            $(this).parents('tr.artistRow').addClass('showing');
        /* Define iLoginID var and call function to fetch and display artist info*/
            var iLoginID = $(this).attr('iLoginID');
            // var pageLoad = false; 
            getArtistInfo(iLoginID,gigId, true);
    });
/********************************************************************
 *** END - When View More is clicked, retrieve the selected artist's info
 ********************************************************************/

/***********************************************
 *** Artists Action  - Submit or Remove Inquiry
 ***********************************************/

    $('#want_to_play').click(function(event){
        if($(this).attr('isTestGig') == 1){
            console.log($(this).attr('isTestGig'));
            $('#testGigOnly').modal('show');
        }else{
            $('#conf_bidToGig').modal('show');
        }
    });

    $('.artistAction').click(function(event){
        var action = $(this).attr('id');

        var inquiryForm = document.forms.namedItem('inquiryForm');
       
        /* Create form data obj*/
            var formObj = new FormData(inquiryForm);
            formObj.append('action',action);
            if( action == 'removeInquiry'){
                var canc_reason = $('textarea[name=withdrawalReason]').val(); 
                formObj.append('inquiry_withdrawn', 1);
                formObj.append('withdraw_reason', canc_reason);
            }

        /* Create New xhr */
            var inquirySubmit = new XMLHttpRequest();
            inquirySubmit.onload = function(){
                if(inquirySubmit.status == 200){
                    var response = inquirySubmit.responseText.trim();
                    console.log(response);
                    var parsedResponse = JSON.parse(response);
                    // console.log(parsedResponse);
                    if(parsedResponse.inquiry_submitted){
                        /* reload page */
                            location.reload();
                    }
                    else if(parsedResponse.err == 'no_artist_type' ){
                        $('#form-err').html('Please Select a Talent');
                    }
                    else{
                        var errMessage = 'There was a problem submitting or withdrawing for this gig!!!';
                    }
                }
            }
            inquirySubmit.open('post','https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php');
            inquirySubmit.send(formObj);
    });

/* Form for users donating */
        const form0 = $('#inquiryForm');

        form0.validate({

            //Error display and placement 
                errorPlacement: function(error, element) {
                    console.log(error[0]['id']);
                    error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                    element.after(error); 
                },

            // Handle form when submission is In-Valid
                invalidHandler: function(event, validator){
                    var numbErrors = validator.numberOfInvalids();
                    if(numbErrors){
                        var message = numbErrors == 1 ? 'You missed 1 field. Please Check Previous Steps.'
                                                  : 'You missed ' + numbErrors + ' fields. Please complete the marked fields.';
                        $('div.error').html(message);
                        $('div.error').show(); 
                    }
                    else{
                        $('div.error').hide();
                    }
                },

            // Handle form when submission is valid 
                submitHandler: function(form){
                    /* Display the loading modal */
                        displayLoadingPage('show');

                    
                    /* artist inquiry form obj */
                        var action = 'submitInquiry';//$('#artistAction1').attr('id');
                        var formObj = new FormData(form);
                        formObj.append('action',action);

                        var submit_inquiry = new XMLHttpRequest();
                        submit_inquiry.onload = function(){
                            var response = submit_inquiry.responseText.trim(); 
                            console.log(response);
                            var parsedResponse = JSON.parse(response);
                            console.log(response);

                            if(parsedResponse.inquiry_submitted){
                                /* reload page */
                                    location.reload();
                            }
                            else{
                                $('#form-err').html('Please Select a Talent');
                            }
                            
                        }
                        submit_inquiry.open('post', 'https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php');
                        submit_inquiry.send(formObj);
                },

            // Set Validation rules 
                rules: {
                    'artistType': {
                        required: true
                    }
                },
                messages:{
                    'artistType': {
                        required: "Select the position you're bidding for"
                    }
                }

        });

/****************************************************
 *** END - Artists Action  - Submit or Remove Inquiry
 ****************************************************/


/****************************************************
 *** Gig manager to Select Artist
 ****************************************************/

 	$('#infoDisplay').on('click','.sendID',function(event){
 		event.preventDefault(); 

 		/* Get U ids */
	 		var man_id = $(this).attr('manID');
	 		var artist_id = $(this).attr('artistID');
            var artistType = $(this).attr('artistType'); 

	 	if( $(this).attr('id') == 'selectArtist' ){
            /* Move U ids to conf modal */
    	 		$('#selectThisArtist').attr('artistID',artist_id);
    	 		$('#selectThisArtist').attr('manID',man_id);
                $('#selectThisArtist').attr('artistType',artistType);
     		
     		/* Show conf modal */
     			$('#chooseArtist').modal('show');
        }
        else if( $(this).attr('id') == 'deSelectArtist' ){

            /* Move U ids to conf modal */
                $('#deselectThisArtist').attr('artistID',artist_id);
                $('#deselectThisArtist').attr('manID',man_id);
                $('#deselectThisArtist').attr('artistType',artistType);

            /* show conf modal */
                $('#loseArtist').modal('show');
        }
 	});

    $('.selectArtist').click(function(event){

        var tal_tracker_id = $('a.nav-link.active').attr('talTrackerId');
        // console.log(tal_tracker_id);

        event.preventDefault(); 
        var gm_id = $(this).attr('manID');
        var artistID = $(this).attr('artistID');
        var artistType = $(this).attr('artistType'); 
        var replaceArtist = $(this).attr('replaceArtist');

        /* Create form */
            var selectArtistForm = new FormData();
            
            if($(this).attr('id') == 'selectThisArtist'){
                if(replaceArtist == 'true'){
                    var transaction = 'replaceArtist';   
                    selectArtistForm.append('curr_selected_artist', $(this).attr('selArtistId')) ;
                }
                else{
                     var transaction = 'selectArtist'; 
                }
            }
            else if($(this).attr('id') == 'deselectThisArtist'){
                var transaction = 'deSelectArtist';
                var cancelreason = $('textarea[name=cancelreason]').val();
                selectArtistForm.append('cancelreason',cancelreason);
            }

            selectArtistForm.append('tal_tracker_id',tal_tracker_id);  
            selectArtistForm.append('transaction',transaction);  
            selectArtistForm.append('action','selectArtist');
            selectArtistForm.append('iLoginID',artistID);
            selectArtistForm.append('gigId',gigId);
            selectArtistForm.append('gm_id',gm_id);
            selectArtistForm.append('artistType',artistType);

        /* Create XMLHttpRequest to send artist selection to the postedgigsmaster */
            var selectArtist = new XMLHttpRequest();
            selectArtist.onload = function(){
                if(selectArtist.status == 200){
                    /* Reset cancel form */
                        formReset();

                	var response = selectArtist.responseText.trim();
                    console.log(response);
                    var parsedResponse = JSON.parse(response);

                    if( parsedResponse.artist_selected_deSelected ){
                        /* Get all artist inquiries */
                            // getAllArtistInquiries();
                            location.reload(); 
                    }
                    else{
                        /* Display error message */
                        $('#gig_man_err').html('<p style="font-size:.75em;font-weight:bold">Error making request - Please try again</p>');
                    }
                }
            }
            selectArtist.open('post','https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php');
            selectArtist.send(selectArtistForm);
    });
/****************************************************
 *** END - Gig manager to Select Artist
 ****************************************************/

/***********************************************
 *** Get categorize inquiries - gig manager 
 ***********************************************/
 $('.getGigTalInqu').click(function(event){
    event.preventDefault();

    /* Show loading spinwheel */
        displayLoadingElement('infoDisplay');

    /* Highlight the current talent view for gig inquiries */
        $('.getGigTalInqu').removeClass('active');
        $(this).addClass('active');

    var artistType = $(this).attr('talGroup');
    var gigId = $(this).attr('gigId');
    
    /* Make curent talent tab's tracker ID accessible */
        var talTrackerId = $(this).attr('talTrackerId');
        $('input[name=curr_tal_tracker]').val(talTrackerId); 

    /* Get all artist inquiries on page load */
        var get_tal_inquiries = new XMLHttpRequest(); 
        get_tal_inquiries.onload = function(){
            if(get_tal_inquiries.status == 200){
                var response = get_tal_inquiries.responseText.trim();
                var parsedResponse = JSON.parse(response);
                if(parsedResponse.all_inquiries){
                    $('#infoDisplay').html( buildColOne(parsedResponse.all_inquiries) );
                }
                 else{
                    $('#infoDisplay').html( '<div class="col-12 text-center mt-5" style="color: rgba(204,204,204,1)"><h4>No Artists Have Submitted Inquiries for this Gig</h4></div>');
                }
            }
        }
        get_tal_inquiries.open('get','https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php?get_all_inqu='+gigId+'&kjkjk&tal_type='+artistType);
        get_tal_inquiries.send();
 })
/***********************************************
 *** END - Get categorize inquiries - gig manager 
 ***********************************************/

/***********************************************
 *** Reset cancel reason when modal is closed
 ***********************************************/
    function formReset(){
         $('textarea[name=cancelreason]').val('');
    }
/**************************************************
 *** END - Reset cancel reason when modal is closed
 **************************************************/

 /***********************************************
 *** Make gig ad publicly viewable
 ***********************************************/
    $('.getStatus').click(function(event){
        event.preventDefault();
        var gig_id = $(this).attr('postID');
        var id = $(this).attr('id');
	
        /* Create form obj */
            var post_stat_form = new FormData();
            post_stat_form.append('post_status',id);
            post_stat_form.append('g_id',gig_id);

        /* update post status in database */
            var post_stat_xhr = new XMLHttpRequest();
            post_stat_xhr.onload = function(){
                if(post_stat_xhr.status == 200){
                    var response = post_stat_xhr.responseText.trim();
                    	console.log(response); 
                    var parsedResponse = JSON.parse(response);

                    if(parsedResponse.response){
                        location.reload(); 
                    }
                    else{
                        var err_mess = '<strong>Fail to Update Gig Status, try again.  If problem persists, <a class="text-gs" href="https://www.gospelscout.com/contactUs/">contact us</a></stong>';
                        $('#upd_err').html(err_mess);
                    }
                }
            }
            post_stat_xhr.open('post','https://www.gospelscout.com/publicgigads/phpBackend/connectToDb_ad_details.php');
            post_stat_xhr.send(post_stat_form);
    });
/**************************************************
 *** END - Make gig ad publicly viewable
 **************************************************/
