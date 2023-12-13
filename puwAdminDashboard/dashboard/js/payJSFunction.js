function buildArtistList(artist_list){
	var buildArtistList  = '';
	buildArtistList += '<div class="container py-0"><div class="row text-left my-0"><div class="col-12 my-0 p-0"><div class="accordion my-0" id="accordionExample0"><div class="card my-0">';
	// console.log(artist_list);
	for(x in artist_list){
		// console.log(artist_list[x]); 
		if(artist_list[x].recent_transactions.length > 0){
			var paid_fill = '#008000';
		}
		else{
			var paid_fill = '#9849A8';
		}
		buildArtistList += '<div class="card-header" id="heading'+x+'" style="background-color:rgba(239,239,246,.5)"><button class="btn btn-link collapsed text-gs clear-err-mess" type="button" data-toggle="collapse" data-target="#collapse'+x+'" aria-expanded="true" aria-controls="collapse'+x+'"><img class="aProfPic " src="'+artist_list[x].sProfileName+'" height="50px" width="50px"><h4 class="d-inline-block ml-2 font-weight-bold">'+artist_list[x].sFirstName+' '+artist_list[x].sLastName+'</h4>  <svg width="9px" height="9px" viewBox="0 0 16 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.7"><polygon id="Shape-Copy-2" fill="'+paid_fill+'" transform="translate(8.000000, 7.000000) rotate(90.000000) translate(-8.000000, -7.000000) " points="1 -1 15 7 1 15"></polygon></g></svg></button></div>';
		/* Accordian Header */
			buildArtistList += '<div id="collapse'+x+'" class="collapse" aria-labelledby="heading'+x+'" data-parent="#accordionExample0"><div class="card-body px-0"><div class="container my-0">';
		/* Column 1 - Row 1*/
			buildArtistList += '<div class="row"><div class="col-12 col-md-6"><table class="table"  style="font-size:.8em"><tr><th>iLoginID:</th><td>'+artist_list[x].iLoginid+'</td></tr><tr><th>Date/Time Selected:</th><td>'+artist_list[x].datetimeselected+'</td></tr><tr><th>Playing Status:</th><td>'+artist_list[x].artiststatus+'</td></tr><tr><th>Email:</th><td>'+artist_list[x].sContactEmailID+'</td></tr><tr><th>Phone:</th><td>'+artist_list[x].sContactNumber+'</td></tr></table></div>';
		/* Column 2 - Row 1*/
			buildArtistList += '<div class="col-12 col-md-6"><table class="table"  style="font-size:.8em"><tr><th>Talent:</th><td>'+artist_list[x].sGiftName+'</td></tr><tr><th>age:</th><td>'+artist_list[x].dDOB+'</td></tr><tr><th>Location:</th><td>'+artist_list[x].sCityName+','+artist_list[x].statecode+' '+artist_list[x].iZipcode+'</td></tr></table></div></div>';

		/* Row 2*/
			buildArtistList += '<div class="row text-left">';

			/* Column 1*/
				buildArtistList += '<div class="col-12 col-md-6"><div class="accordion" id="inner_accordionExample"><div class="card">';
				
				/* inner-Accordian */
					buildArtistList += '<div class="card-header" id="inner_heading'+x+'" style="background-color:rgba(239,239,246,1)"><h2 class="mb-0"><button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#inner_collapse'+x+'" aria-expanded="true" aria-controls="collapseOne">View Recent Transactions <svg width="9px" height="9px" viewBox="0 0 16 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><desc>Created with Sketch.</desc><defs></defs><polygon id="Shape-Copy-2" fill="#9849A8" transform="translate(8.000000, 7.000000) rotate(90.000000) translate(-8.000000, -7.000000) " points="1 -1 15 7 1 15"></polygon></g></svg></button></h2></div>';

				/* Accordian Body */
					buildArtistList += '<div id="inner_collapse'+x+'" class="collapse" aria-labelledby="inner_heading'+x+'" data-parent="#inner_accordionExample"><div class="card-body text-center">';
					if(artist_list[x].recent_transactions.length > 0){
						buildArtistList += '<table class="table" style="font-size:.8em"><thead><tr><th>Action</th><th class="d-none d-md-table-cell">Event Pay</th><th>Amount Paid</th><th>Date</th><th class="d-none d-md-table-cell">Reverse-Payment</th></tr></thead><tbody>';
						for(y in artist_list[x].recent_transactions){
							buildArtistList += '<tr><td>'+artist_list[x].recent_transactions[y].transactionType+'</td><td class="d-none d-md-table-cell">'+artist_list[x].event_pay_display+'</td><td>'+artist_list[x].recent_transactions[y].depositamount+'</td><td>'+artist_list[x].recent_transactions[y].depositDateTime+'</td>';

							if( artist_list[x].recent_transactions[y].transactionType == 'transfer' && artist_list[x].recent_transactions[y].transfer_reversed == '0' && artist_list[x].recent_transactions[y].transfer_paidout == '0'){
								buildArtistList += '<td class="d-none d-md-table-cell"><div class="dropdown"><button class="btn btn-sm p-1 btn-gs dropdown-toggle font-weight-bold" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:.9em">More</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item font-weight-bold trans_reversal" href="#" artist_name="'+artist_list[x].sFirstName+' '+artist_list[x].sLastName+'" artist_talent="'+artist_list[x].sGiftName+'" amount="'+artist_list[x].recent_transactions[y].depositamount+'" action="transfer_reversal" tal_tracker_id="'+artist_list[x].recent_transactions[y].tal_tracker_id+'" iLoginID="'+artist_list[x].iLoginid+'" transfer_id="'+artist_list[x].recent_transactions[y].transaction_id+'" gigid="'+artist_list[x].gigId+'" style="font-size:.8em">Reverse Transfer</a><a class="dropdown-item font-weight-bold trans_reversal" href="#" artist_name="'+artist_list[x].sFirstName+' '+artist_list[x].sLastName+'" artist_talent="'+artist_list[x].sGiftName+'" amount="'+artist_list[x].recent_transactions[y].depositamount+'" action="payout" tal_tracker_id="'+artist_list[x].recent_transactions[y].tal_tracker_id+'" iLoginID="'+artist_list[x].iLoginid+'" transfer_id="'+artist_list[x].recent_transactions[y].transaction_id+'" gigid="'+artist_list[x].gigId+'" style="font-size:.8em">Payout</a></div></div></td>';
							}
							else if( artist_list[x].recent_transactions[y].transfer_reversed == '1' ){
								buildArtistList += '<td class="d-none d-md-table-cell font-weight-bold">Transfer Reversed</td>';
							}
							else if( artist_list[x].recent_transactions[y].transfer_paidout == '1' ){
								buildArtistList += '<td class="d-none d-md-table-cell font-weight-bold">Transfer Paid Out</td>';
							}
							else{
								buildArtistList += '<td class="d-none d-md-table-cell">N/A</td>';
							}

							buildArtistList += '</tr>';
						}
						buildArtistList += '</tbody></table>';
					}
					else{
						buildArtistList += '<h5 class=" my-1" style="color: rgba(204,204,204,1);">No Transactions Available</h5>';
					}
					buildArtistList += '</div></div>';
					buildArtistList += '</div></div></div>';

			/* Column 2 */
				buildArtistList += '<div class="col-12 col-md-6"><label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Enter Amount<span class="colon">*</span></label><input type="text" class="form-control form-control-sm mb-1" name="transfer_amount_'+artist_list[x].tal_tracker_id+'"  placeholder="$0.00"><p class="mt-0 mb-2 text-danger err_mess font-weight-bold" id="err_mess_'+artist_list[x].tal_tracker_id+'" style="font-size:.8em"></p><button class="btn btn-sm btn-gs transfer_action" action="transfer" tal_tracker_id="'+artist_list[x].tal_tracker_id+'" gigid="'+artist_list[x].gigId+'" iLoginID="'+artist_list[x].iLoginid+'" type="button">Transfer Deposit</button></div>';
		
		buildArtistList += '</div>'; /* END - Row 2 */
		buildArtistList += '</div></div></div>';		
	}
	buildArtistList += '</div></div></div></div><hr class="featurette-divider my-3"></div>';
	return buildArtistList; 
}

/*<button type="button" class="btn btn-sm btn-gs p-1 font-weight-bold trans_reversal" artist_name="'+artist_list[x].sFirstName+' '+artist_list[x].sLastName+'" artist_talent="'+artist_list[x].sGiftName+'" amount="'+artist_list[x].recent_transactions[y].depositamount+'" action="transfer_reversal" tal_tracker_id="'+artist_list[x].recent_transactions[y].tal_tracker_id+'" iLoginID="'+artist_list[x].iLoginid+'" transfer_id="'+artist_list[x].recent_transactions[y].transaction_id+'" gigid="'+artist_list[x].gigId+'" style="font-size:.8em">Reverse pay</button>*/



function makeTransfer(thisVar){
	/* close conf modal */
		$('#conf_transfer_reversal').modal('hide');
	/* dipslay loading spin wheel */
		displayLoadingPage('show');
	/* Define vars */
		var transfer_action = thisVar.attr('action');
		var tal_tracker_id = thisVar.attr('tal_tracker_id');
		var iLoginID = thisVar.attr('iLoginID');
		var gigId = thisVar.attr('gigid');
		var transfer_amount = $('input[name=transfer_amount_'+tal_tracker_id+']').val(); 
	
	if(transfer_action == 'transfer' && transfer_amount == ''){
		console.log('error');
		$('#showArtists #err_mess_'+tal_tracker_id).html('Please enter transfer amount');
	}
	else{
		/* Send transfer amount */

			/* new form obj */
				var artist_transfer_form = new FormData(); 
				artist_transfer_form.append('transactionType',transfer_action);
				artist_transfer_form.append('tal_tracker_id',tal_tracker_id);
				artist_transfer_form.append('iLoginid',iLoginID);
				artist_transfer_form.append('depositamount',transfer_amount);
				artist_transfer_form.append('gigId',gigId);

				if(transfer_action == 'transfer_reversal' || transfer_action == 'payout'){
					artist_transfer_form.append('transfer_id',thisVar.attr('transfer_id') );
				}

			/* new xhr request */
			var artist_transfer_xhr = new XMLHttpRequest();
			artist_transfer_xhr.onload = function(){
				if( artist_transfer_xhr.status == 200){

					/* dipslay loading spin wheel */
						displayLoadingPage('hide');

					var response = artist_transfer_xhr.responseText.trim(); 
					console.log( response );
					var parsedResponse = JSON.parse(response);
					console.log( parsedResponse );

					if(parsedResponse.transfer_made){
						/* dipslay success modal */
							var message = '<p class="text-success font-weight-bold">'+transfer_action.toUpperCase()+' SUCCESSFUL</p>'
					}
					else{

						if(parsedResponse.trans_err == "str_acct_false"){
							var message = '<p class="text-danger font-weight-bold">Artist does not have a valid stripe account</p>';
						}
					}

					$('#trans_succ_mess').html(message);
					$('#transfer_success').modal('show');
				}
			}
			artist_transfer_xhr.open('post','https://www.stage.gospelscout.com/puwAdminDashboard/dashboard/phpBackend/connectToDb.php');
			artist_transfer_xhr.send(artist_transfer_form);
	}
}







