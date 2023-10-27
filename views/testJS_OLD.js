/* JavaScript Section-Appends for VideoDisplay Page */

/*********************************************** Video Comment Appends *************************************************/

	function AppendFunct(data){
		var comment = '';
		comment +=	'<div class="row px-3" id="userComm_'+data.iCommentID+'">';
		comment +=		'<div class="media mb-3" style="min-width:98%; max-width:98%;">'
		comment +=	  		'<img class="mr-3" src="/upload/'+data.replyType+'/'+data.sProfileName+'" width="40px" height="40px" alt="image">';
		comment +=	  		'<div class="media-body">';

		comment +=				'<div class="container m-0">';
		comment +=				  	'<div class="row">';
		comment +=				  		'<div class="col-6 p-0">';
		comment += 							'<h6 class="mt-0">'+data.sFirstName;  

											// the comment Age goes here!!!

		comment += 							'</h6>';
		comment +=						'</div>';
		comment +=						'<div class="col-6 text-right" style="font-size:10px;font-weight:bold">';
		comment +=								'<a href="#" class="text-gs removeCommentAppend" id="'+data.iCommentID+'">Remove</a>';
		comment +=						'</div>';
		comment +=					'</div>';
		comment +=				'</div>';		

								/* User Comments Go here */
		comment += 				'<p style="font-size:12px;" class="mb-0">'+data.sComment+'</p>';

								/* Reply to User Comments */
		comment +=				'<div class="container" style="width:90%;">';
		comment +=					'<div class="row">';
		comment +=						'<div class="col-3 col-lg-2 pl-0">';
											/* Reply to user Comment  */
		comment +=								'<a href="#" iReplyTo="'+data.iCommentID+'" class="text-gs showReplyFormAppend" style="font-size:10px;">reply</a>';
											/* END - Reply to user Comment */
		comment +=						'</div>';	
		comment +=					'</div>';
		comment +=					'<div class="row d-none" id="addReply'+data.iCommentID+'">';
		comment +=						'<form method="post" class="" style="width:100%" enctype="multipart" action="" name="'+data.iCommentID+'" id="addReplyForm'+data.iCommentID+'">';
		comment +=							'<textarea class="form-control mb-2" name="sComment" placeholder="add comment..." wrap="" rows="1" style="font-size: 12px;"></textarea>';
		comment +=							'<input type="hidden" name="videoID" value="'+data.videoID+'">';
		comment +=							'<input type="hidden" name="iLoginID" value="'+data.iLoginID+'">';
		comment += 							'<input type="hidden" name="iReplyTo" value="'+data.iCommentID+'">';
		comment +=							'<input type="hidden" name="sProfileName" value="'+data.sProfileName+'">';
		comment +=							'<input type="hidden" name="sFirstName" value="'+data.sFirstName+'">';
		comment += 							'<input type="hidden" name="replyType" value="'+data.replyType+'">';
											/* <input type="hidden" name="iReplyTo" value="<?php echo $allComments['iCommentID'];?>"> */
		comment +=							'<div class="text-right">';
		comment +=								'<button type="button" class="btn btn-sm btn-cancel mr-2 cancelReplyAppend" value="'+data.iCommentID+'" id="cancel'+data.iCommentID+'" style="">Cancel</button>';
		comment +=								'<button type="submit" class="btn btn-gs btn-sm addReplyAppend" value="'+data.iCommentID+'">Reply</button>';
		comment +=							'</div>';
		comment +=						'</form>';
		comment +=					'</div>';
		comment +=				'</div>';
		comment += 				'<div id="commentReplies'+data.iCommentID+'"></div>';				   		
		comment +=	  		'</div>';
		comment +=	  	'</div>';
		comment +=	 '</div>';

		var newComment = $.parseHTML(comment,true); 
		$("#showComments").append(newComment);
	}

	/* Show the hidden Comment Reply form */
		$("#showComments").on("click", '.showReplyFormAppend', function(event){
			event.preventDefault();

			var commId = $(this).attr('iReplyTo');
			// console.log('reply clicked: '+commId);
			$('#addReply'+commId).removeClass('d-none');
		});
	/* END - Show the hidden Comment Reply form */

	/* Cancel/Hide the comment reply form and hide */
		$("#showComments").on("click", '.cancelReplyAppend', function(event){
			event.preventDefault(); 

			var commId = $(this).val();
			document.getElementById('addReplyForm'+commId).reset(); 
			$('#addReply'+commId).addClass('d-none');
		});
	/* END - Cancel/Hide the comment reply form and hide */

	/* Add a reply to a comment */
		// $("#showComments").on("click", '.addReplyAppend', function(event){
		// 	event.preventDefault(); 

		// 	var commID = $(this).val();
					
		// 	var formId = $(this).val();

		// 	var replyForm = document.forms.namedItem(formId);
		// 	var replyData = new FormData(replyForm); 
		// 	var sendReply = new XMLHttpRequest();
		// 	sendReply.onreadystatechange = function(){
		// 		if(sendReply.status == 200 && sendReply.readyState == 4){
		// 			 console.log(sendReply.responseText);
		// 			$("#commentReplies"+commID).append(sendReply.responseText);
		// 		}
		// 	}
		// 	sendReply.open('POST', 'vidDispDBupdate');
		// 	sendReply.send(replyData);
		// 	document.getElementById('addReplyForm'+formId).reset(); 
		// });

		$("#showComments").on("click", '.addReplyAppend', function(event){
		 	event.preventDefault();
			var commID = $(this).val();
			
			var formId = $(this).val();
			var replyForm = document.forms.namedItem(formId);
			var replyData = new FormData(replyForm); 

			var data = {}

			/* For older browsers that don't support all the FormData Methods */
				var x = document.forms.namedItem(formId).length - 2;
				 for(var f=0; f<x; f++){
				 	comKey = replyForm.elements[f].name;
				 	comVal = replyForm.elements[f].value;
				 	// console.log(f+': '+comKey+' = '+comVal);
				 	data[comKey] = comVal;
				 }
			/* END - For older browsers that don't support all the FormData Methods */

			// for (var key of replyData.keys()) {
			// 	   console.log('key: '+key+' = '+replyData.get(key));
			// 	   data[key] = replyData.get(key);
			// }
			function dataObj(response){
				data['iCommentID'] = response; 
				data['usertype'] = $('input[name=replyType]').val();
				return data; 
			}
			
			var sendReply = new XMLHttpRequest();
			sendReply.onreadystatechange = function(){
				if(sendReply.status == 200 && sendReply.readyState == 4){
					// $("#commentReplies"+commID).append(sendReply.responseText);
					
					if(sendReply.responseText){
						// console.log(sendReply.responseText);
						newData = dataObj(sendReply.responseText);
						// console.log(data);
						AppendNewReply(newData);
					}
				}
			}
			sendReply.open('POST', 'vidDispDBupdate');
			sendReply.send(replyData);
			document.getElementById('addReplyForm'+formId).reset(); 
		});
	/* END - Add a reply to a comment */

	/* Remove Comment */
		$("#showComments").on("click", '.removeCommentAppend', function(event){
		 	event.preventDefault();
		 	var comID = $(this).attr('id');
		 	// console.log('comm id = '+comID);

		 	var removeComment = new XMLHttpRequest();
		 	removeComment.onreadystatechange = function(){
		 		if(removeComment.readyState == 4 && removeComment.status == 200){
		 			// console.log(removeComment.responseText);
		 			if(removeComment.responseText == 'deleted'){
		 				$('#userComm_'+comID).hide();
		 			}
		 		}
		 	}
		 	removeComment.open('GET', 'vidDispDBupdate.php?deleteComment='+$('input[name=replyType').val()+'&iCommentID='+comID);
		 	removeComment.send(); 
		 });
	/* END - Remove Comment */

/*********************************************** END - Video Comment Appends *************************************************/

/*********************************************** Video COmment Replies Append *************************************************/

	/* Fetch Existing Video Comment Replies & Append */
   		function AppendReply(data){
   			var j = 0; 
   			document.getElementById('commentReplies'+data[0]['iReplyTo']).innerHTML = '';
   			/* Loop to display each comment */
	   			while(data[j]){
	   				// console.log('from anppend page: '+data[j]['currentUser']);
	   				var reply = '';
				   	reply +=	'<div class="media mt-3" id="userReply_'+data[j]['icommentId']+'">';
				    reply +=  		'<a class="pr-3" href="#"><img src="/upload/artist/'+data[j]['sProfileName']+'" width="40px" height="40px" alt="image"></a>';
				    reply +=  		'<div class="media-body">';

				    reply +=			'<div class="container m-0">';
					reply +=				'<div class="row">';
					reply +=					'<div class="col-6 p-0">';
				    reply +=    					'<h6 class="mt-0">'+data[j]['sFirstName']+'</h6>';
				    reply +=					'</div>';
				    if(data[j]['currentUser'] == data[j]['iLoginID']){
						reply +=					'<div class="col-6 text-right" style="font-size:10px;font-weight:bold">';
						reply +=						'<a href="#" class="text-gs removeReplyAppend" type="'+data[j]['usertype']+'" removeId="'+data[j]['icommentId']+'">Remove</a>';
						reply +=					'</div>';
					}
					reply +=				'</div>';
					reply +=			'</div>';

				    					/* User Replies Go here */
				    reply +=    			'<p style="font-size:12px;">'+data[j]['sComment']+'</p>';	
				    reply +=  		'</div>';
				    reply +=	'</div>';

	   				var commentID = data[j]['iReplyTo']; 
	   				var newReply = $.parseHTML(reply,true); 
					$("#commentReplies"+commentID).append(newReply);
					j++; 
	   			}
	   			
   		}
	/* END - Fetch Existing Video Comment Replies & Append */

	/* Add New Video Comment Replies & Append */
   		function AppendNewReply(data){
   			// console.log(data);
			// console.log('from anppend page: '+data[j]['currentUser']);
			var reply = '';
		   	reply +=	'<div class="media mt-3" id="userReply_'+data.iCommentID+'">';
		    reply +=  		'<a class="pr-3" href="#"><img src="/upload/artist/'+data.sProfileName+'" width="40px" height="40px" alt="image"></a>';
		    reply +=  		'<div class="media-body">';

		    reply +=			'<div class="container m-0">';
			reply +=				'<div class="row">';
			reply +=					'<div class="col-6 p-0">';
		    reply +=    					'<h6 class="mt-0">'+data.sFirstName+'</h6>';
		    reply +=					'</div>';
			reply +=					'<div class="col-6 text-right" style="font-size:10px;font-weight:bold">';
			reply +=						'<a href="#" class="text-gs removeReplyAppend" type="'+data.usertype+'" removeId="'+data.iCommentID+'">Remove</a>';
			reply +=					'</div>';
			reply +=				'</div>';
			reply +=			'</div>';

		    					/* User Replies Go here */
		    reply +=    			'<p style="font-size:12px;">'+data.sComment+'</p>';	
		    reply +=  		'</div>';
		    reply +=	'</div>';

			var commentID = data.iReplyTo; 
			var newReply = $.parseHTML(reply,true); 
			$("#commentReplies"+commentID).append(newReply);
   		}
	/* END - Add New Video Comment Replies & Append */

	/* Remove Reply */
		$("#showComments").on("click", '.removeReplyAppend', function(event){
		 	event.preventDefault();
		 	 var replyID = $(this).attr('removeId');
		 	 var type = $(this).attr('type');
		 	 console.log(type);
		 	 // console.log($(this).attr('id'));
		 	 // console.log('reply id = '+replyID);


		 	var removeReply = new XMLHttpRequest();
		 	removeReply.onreadystatechange = function(){
		 		if(removeReply.readyState == 4 && removeReply.status == 200){
		 			// console.log(removeReply.responseText);
		 			if(removeReply.responseText == 'deleted'){
		 				$('#userReply_'+replyID).hide();
		 			}
		 		}
		 	}
		 	removeReply.open('GET', 'vidDispDBupdate.php?deleteReply='+type+'&iCommentID='+replyID);
		 	removeReply.send(); 
		 });
	/* END - Remove Comment */
/*********************************************** END - Video Comment Repy Appends *************************************************/
