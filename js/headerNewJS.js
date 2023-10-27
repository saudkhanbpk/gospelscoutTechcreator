/* Disable the Menu Buttons */
	 // document.getElementsByClassName('dis').disabled = true;
      $('.dis').click(function(event){
        event.preventDefault();
      });

/* Dismiss Login Modal */
	$('.dismissLogin').click(function(event){
		$('#login-signup').modal('hide');
	});
/* END - Dismiss Login Modal */

/* User Login */
  $('#btn_login').on('click', function (e) {
    if($('#inputEmail').val() == ''){
      $('#loadlogin1').html("Please enter email");
    }
    else if($('#inputPassword').val() == ''){
      $('#loadlogin1').html("Please enter password");
    }else{ 
        $('#loadlogin1').html('');
        e.preventDefault();
        // displayLoadingPage('show');

        var email = $('input[name=sEmailID]').val();
        var formInfo = document.forms.namedItem('frmLogin');
        var credentials = new FormData(formInfo);

		$(function () {
			var checkLogin = new XMLHttpRequest(); 
			checkLogin.onload = function(){
			if(checkLogin.status == 200){
				var data = checkLogin.responseText.trim();
				if(data == 'Please check your email or password' || data =='Please enter your email and password'){
				$('#loadlogin1').html(data);
				}
				else if(e.currentTarget.attributes.popupworship.nodeValue == 'true'){
				location.reload(); 
				}
				else if(e.currentTarget.attributes.viewCal.nodeValue == 'true'){
				  	var cal_u_Id = e.currentTarget.attributes.viewCalId.nodeValue;
                	window.location = `https://www.gospelscout.com/calendar/?u_Id=${cal_u_Id}`;
              	}
				else if(e.currentTarget.attributes.viewPostedGigs.nodeValue == 'true'){
					console.log('test');
					location.reload();
				}
				else if(data == 'artist'){
					window.location = "https://www.gospelscout.com/views/artistprofile.php";  
				}else if(data == 'church'){
					window.location = "https://www.gospelscout.com/views/churchprofile.php";  
				}else if(data == 'user'){
				window.location = "https://www.gospelscout.com/artist";
				}else if(data == 'deactive'){
				$('#loadlogin1').html("Your account is deactivated. Please contact us to activate your account.");
				}
			}else{
				$('#loadlogin1').html('status not 200');
				displayLoadingPage('hide');
			}
			}      
			checkLogin.open('POST', 'https://www.gospelscout.com/views/checklogin.php');
			checkLogin.send(credentials); 
		});
    }
  });
/* END - User Login */


/* User Signup Prelim Form */
  $('input[name=profType]').on('click',function(e){
    var prof_type = $(this).val();
    console.log( $(this).val() );//

    if(prof_type == 'artist'){
      $('form[name=frmLogin2]').attr('action','https://www.gospelscout.com/signup/artist/');
    }else{
      $('form[name=frmLogin2]').attr('action','https://www.gospelscout.com/signup/gen_user/');
    }

  });
  $('#btn_login2').on('click', function (e) {
	
  e.preventDefault();
    if($('#inputEmail2').val() == ''){
      $('#loadlogin2').html("Please enter email");
    }
    else if($('#inputPassword2').val() == ''){
      $('#loadlogin2').html("Please enter password");
    }
    else if($('#confInputPassword2').val() == ''){
      $('#loadlogin2').html("Please confirm password");
    }else if( $('#inputPassword2').val() !== $('#confInputPassword2').val() ){
      $('#loadlogin2').html("Passwords must match");
    }else{ 
        $('#loadlogin2').html('');
        document.getElementById("frmLogin2").submit();

        var email = $('input[name=sEmailID]').val();
        var formInfo = document.forms.namedItem('frmLogin2');
        var credentials = new FormData(formInfo);
    }
  });
/* END - User Signup Prelim Form */


/* Log Out */
  function logOut(){
    var logout = new XMLHttpRequest(); 
    logout.onreadystatechange = function(){
      if(logout.status == 200 && logout.readyState == 4)
      location.reload(); 
    }
    logout.open("GET", "https://www.gospelscout.com/views/logout.php");
    logout.send(); 
  }

  /* user-triggered logout */
    $('#logout').click(function(event){
      event.preventDefault(); 
      logOut();
    });   
/* END - Log Out */

/* Check for user's connect account Id - fetch dashboard URL */
	$('#goTo_str_dashboard').click(function(event){
		event.preventDefault(); 

	  	/* show the loading modal */
		    let action = 'show';
		    // displayLoadingPage(action);

		var user_id = $(this).attr('uID');
		var getDashForm = new FormData(); 
		getDashForm.append('dash_iLoginID',user_id);

		var getDash_xhr = new XMLHttpRequest();
	  	getDash_xhr.onload = function(){
		    if(getDash_xhr.status == 200){
		    	/* show the loading modal */
			        let action = 'hide';
			        // displayLoadingPage(action);
				var response = getDash_xhr.responseText.trim();
				console.log(response);
		      	var parsedResponse = JSON.parse( response ); 
		      	
		      	if( !(parsedResponse.error) ){
		        	window.open(parsedResponse.url, '_blank');
		      	}
		      	else{
		        	console.log(parsedResponse.error);
		        	if(parsedResponse.error == 'no_str_id'){
		          		/* Display Modal with Onboarding link */
		            		$('#str_onboard_link').modal('show');
		            		$('#go_to_onboard_link').attr('href',parsedResponse.onboard_link);
		        	}
		      	}
		    }
		}
	 	getDash_xhr.open('post','https://www.gospelscout.com/include/get_str_dash.php');
	  	getDash_xhr.send(getDashForm); 

	});

/* Password recovery Modal */
	$('.dismissPword').click(function(event){
		$('#passwordRecovery').modal('hide');  
	});

/* Function to show/hide the password and question divs */
	function showProperDiv(){
		/* Show the email input div */
		  	$("#recovEmail").removeClass('d-none');


		/* Hide all other recovery modal divs */
		  	$("#recovQuestions").addClass('d-none');
		  	$('#recovCode').addClass('d-none');
		  	$('#newPwords').addClass('d-none');
		  	$('#pwordUpdated').addClass('d-none');


		/* Form reset */
			document.getElementById('pwordRecovForm').reset();

		/* hide and reset error div */
		  	$('#errorMessageContent').html('');
		  	$('#errorMessage').addClass('d-none');
	}
$('#forgot-password').on('click',function(e){
	e.preventDefault();
	$('#login-signup').modal('hide');
	$('#passwordRecovery').modal('show');
});
/* Recovery page var */
	var recoveryPage = "https://www.gospelscout.com/views/pwordRecovery.php";

	/* functions */
		function showErrorMessage(message){
			$('#errorMessageContent').html(message);
			$('#errorMessage').removeClass('d-none');
			errorCount = errorCount + 1;
		}

	var i=0;
	var errorCount = 0; 

	/* Query the loginmaster for the loginID corresponding to the user's email */
		$("#submitEmail").click(function(event){
			event.preventDefault();

			/* Define form Var */
				var userEmail = $('input[name=sEmailID1]').val(); 

			if(userEmail == ''){
				document.getElementById('errorMessageContent').innerHTML = 'Please enter your email address';
				$('#errorMessage').removeClass('d-none');
				errorCount = errorCount + 1;
			}
			else{
				/* Display loading-page spinshweel */
					let action = 'show';
					displayLoadingPage(action);
					$('#passwordRecovery').modal('hide');

				/* Crate new form data */
			  		var emailSubmit = new FormData(); 
			  		emailSubmit.append('sEmailID',userEmail);

				/* Create new XMLHttpRequest */
					var submitEmail = new XMLHttpRequest();
					submitEmail.onload = function(){
						if(submitEmail.status == 200){

							/* Display loading-page spinshweel */
								let action = 'hide';
								displayLoadingPage(action);
								$('#passwordRecovery').modal('show');

					    	var result = submitEmail.responseText.trim(); 

					  		/* Evaluate results */
							    if(result == 'No Results'){
							    	/* display error */
							        	var errorMess = 'Sorry, there are no accounts with this email.';
							        	showErrorMessage(errorMess);
							    }
							    else if(result == 'noQuestions'){
							    	/* display error */
							        	var errorMess = 'You do not have any security questions. Please <a class="text-primary" href="">contact us!!</a>';
							        	showErrorMessage(errorMess);
							    }
							    else{
							    	/* Check for error message */
							        	if(errorCount > 0){
							          		$('#errorMessage').addClass('d-none');
							          			errorCount = 0;
							        	}

							      	/* Hide the email input */
							        	$("#recovEmail").addClass('d-none');

							      	/* parse xml tags in the text response and display questions in modal */
							        	/* Define Variables from returned xml values */  
											var parser = new DOMParser();
											var xmlDoc = parser.parseFromString(result,"text/xml");
											var quest0 = xmlDoc.getElementsByTagName('question0')[0].childNodes[0].nodeValue;
											var questID0 = xmlDoc.getElementsByTagName('questID0')[0].childNodes[0].nodeValue;
											var quest1 = xmlDoc.getElementsByTagName('question1')[0].childNodes[0].nodeValue;
											var questID1 = xmlDoc.getElementsByTagName('questID1')[0].childNodes[0].nodeValue;
							        	/* END - Define Variables from returned xml values */

										/* Display the current user's security questions */
											document.getElementById('quest0').innerHTML = quest0;
											document.getElementById('quest1').innerHTML = quest1;
										/* END - Display the current user's security questions */

								        /* Display the question id's in a hidden input */
								          	$('input[name=answ0]').attr("questID", questID0);
								          	$('input[name=answ1]').attr("questID", questID1);
							      	/* END - parse xml tags in the text response and display questions in modal */

							      	$("#recovQuestions").removeClass('d-none');

							     	i = i + 1;
							    }
					  	}
					}
					submitEmail.open('POST',recoveryPage);
					submitEmail.send(emailSubmit);
			}
		});

        /* Send user's answers back to the server for comparison */ 
        $("#submitAnswers").click(function(event){
           event.preventDefault();

          /* Define form Var */
            var userAnswer0 = $('input[name=sQuest0]').val(); 
            var questID0 = $('input[name=answ0]').attr('questID');
            var userAnswer1 = $('input[name=sQuest1]').val(); 
            var questID1 = $('input[name=answ1]').attr('questID');
            var userEmail = $('input[name=sEmailID1]').val();

          /* Crate new form data */
            var answerSubmit = new FormData(); 
            answerSubmit.append('sEmailID',userEmail);
            answerSubmit.append('sQuest0',userAnswer0);
            answerSubmit.append('sQuest1',userAnswer1);
            answerSubmit.append('questID0',questID0);
            answerSubmit.append('questID1',questID1);

           if(userAnswer0 !== '' && userAnswer1!== ''){
           		/* Display loading-page spinshweel */
					let action = 'show';
					displayLoadingPage(action);
					$('#passwordRecovery').modal('hide');

	          /* Create new XMLHttpRequest */
	            var submitAnswer = new XMLHttpRequest();
	            submitAnswer.onload = function(){
	              if(submitAnswer.status == 200){
	              	/* Display loading-page spinshweel */
						let action = 'hide';
						displayLoadingPage(action);
						$('#passwordRecovery').modal('show');

	                var answerResult = submitAnswer.responseText.trim();
	                if(answerResult == 'asnwerMismatch'){
	                  /* Display error message */
	                    var errorMess = 'One or more of your security questions was answered incorrectly!!!';
	                    showErrorMessage(errorMess);
	                }
	                else if(answerResult == 'asnwerMatch'){

	                  $("#recovQuestions").addClass('d-none');
	                  $('#recovCode').removeClass('d-none');

	                /* Reload load page after 10 minutes */
	                  setTimeout(function(){ window.location.href = 'https://www.gospelscout.com';},600000);
	                  var errorMess = '<span class="text-gs">Recovery code will expire in 10 minutes!!!<span>';
	                  showErrorMessage(errorMess);
	                /* END - Reload load page after 10 minutes */
	                }
	              }
	            }
	            submitAnswer.open('POST',recoveryPage);
	            submitAnswer.send(answerSubmit);
	        }
	        else{
	        	/* hide loading-page spinshweel */
					let action = 'hide';
					displayLoadingPage(action);
					$('#passwordRecovery').modal('show');

	        	/* Display error message */
                    var errorMess = 'Please answer both security questions!!!';
                    showErrorMessage(errorMess);
	        }
        });

        $("#submitCode").click(function(event){
            event.preventDefault();

            /* Create vars for new form */
              var recoveryCode = $('input[name=recovCode]').val(); 
              var userEmail = $('input[name=sEmailID1]').val();

            /* Create new form object */
              var validateCode = new FormData(); 
              validateCode.append('sEmailID',userEmail);
              validateCode.append('recovCode',recoveryCode);

            
            if(recoveryCode !== ''){
            	/* Display loading-page spinshweel */
					let action = 'show';
					displayLoadingPage(action);
					$('#passwordRecovery').modal('hide');

	            /* Create new XMLHttpRequest */
		            var valCodeRequest  = new XMLHttpRequest(); 
		            valCodeRequest.onload = function(){
		                if(valCodeRequest.status == 200){
		                	/* Display loading-page spinshweel */
								let action = 'hide';
								displayLoadingPage(action);
								$('#passwordRecovery').modal('show');

		                  	var validationResult = valCodeRequest.responseText.trim(); 
		                  	if(validationResult == 'codeValid'){
		                      	/* Check for error message */
		                        	if(errorCount > 0){
		                          		$('#errorMessage').addClass('d-none');
		                          		errorCount = 0;
		                        	}

		                      	/* Show the New Password and Confirm Password Div */
		                        	$('#recovCode').addClass('d-none');
		                        	$('#newPwords').removeClass('d-none');
		                  	}
		                  	else if(validationResult == 'codeInvalid'){
		                    	/* Display error message */
		                      		var errorMess = 'Oops!!! You entered the wrong code!!!';
		                      			showErrorMessage(errorMess);
		                  	}
		                }
		            }
		            valCodeRequest.open('POST',recoveryPage);
		            valCodeRequest.send(validateCode);
	        }
	        else{
	        	/* Display error message */
                	var errorMess = 'Oops!!! You have not entered a code!!!';
                  	showErrorMessage(errorMess);
	        }

            /* END - Query the recovcodemaster table for the recovCode */
        });        

        $("#submitNewPword").click(function(event){
            event.preventDefault();

            /* Create vars for new form */
              var pword = $('input[name=sNewPassword]').val(); 
              var cpword = $('input[name=sConfNewPassword]').val(); 
              var userEmail = $('input[name=sEmailID1]').val();

          if(pword == '' || cpword == ''){
            /* Display error message */
              var errorMess = 'Please Enter New Password!!!';
              showErrorMessage(errorMess);
          }
          else if(pword !== cpword){
            /* Display error message */
              var errorMess = 'Passwords Do Not Match!!!';
              showErrorMessage(errorMess);
          }
          else{
            /* Check for error message */
              if(errorCount > 0){
                $('#errorMessage').addClass('d-none');
                errorCount = 0;
              }

            /* Create new form object */
              var savePword = new FormData(); 
              savePword.append('sEmailID',userEmail);
              savePword.append('sPassword',pword);

            /* Create new XMLHttpRequest */
              var savePwordRequest  = new XMLHttpRequest(); 
              savePwordRequest.onreadystatechange = function(){
                if(savePwordRequest.readyState == 4 && savePwordRequest.status == 200){
                  console.log(savePwordRequest.responseText);
                  var validationResult = savePwordRequest.responseText.trim(); 
                  if(validationResult == 'passwordUpdated'){
                    /* Check for error message */
                      if(errorCount > 0){
                        $('#errorMessage').addClass('d-none');
                        errorCount = 0;
                      }

                    /* Show the New Password and Confirm Password Div */
                      $('#recovModalTitle').html('<span class="text-success">Password has been updated!!!</span>');
                      $('#newPwords').addClass('d-none');
                      $('#pwordUpdated').removeClass('d-none');
                  }
                  else if(validationResult == 'samePass'){
                    /* Display error message */
                      var errorMess = 'Oops!!! You recently used this password!!!';
                      showErrorMessage(errorMess);
                  }
                }
              }
              savePwordRequest.open('POST',recoveryPage);
              savePwordRequest.send(savePword);
          }
        }); 
        $("#newLogin").click(function(event){
          $('#recovModalTitle').html('Forgot Password?  No Problem!');
        });

		$(".accept").click(function(){
			$(".cookie").hide();

			  //update session
				var acceptCookieXHR = new XMLHttpRequest(); 
				acceptCookieXHR.onload = () => {
					if(acceptCookieXHR.status === 200){
						var response = acceptCookieXHR.responseText.trim(); 
						var parsedResponse = JSON.parse(response);
						console.log(parsedResponse.cookiesAccepted);
						if(parsedResponse.cookiesAccepted === true){
							$('#cookie').addClass('d-none');
							console.log(parsedResponse);
						}
					}
				}
				acceptCookieXHR.open('get', 'https://www.gospelscout.com/views/checklogin.php?acceptCookie=true');
				acceptCookieXHR.send(); 
		});

		// check if visitor accepted cookie policy
			var cookieXHR = new XMLHttpRequest(); 
			cookieXHR.onload = () => {
				if(cookieXHR.status === 200){
					var response = cookieXHR.responseText.trim(); 
					var parsedResponse = JSON.parse(response);
					console.log(parsedResponse.cookiesAccepted);
					if(parsedResponse.cookiesAccepted === false){
						$('#cookie').removeClass('d-none');
						console.log(parsedResponse);
					}
				}
			}
			cookieXHR.open('get', 'https://www.gospelscout.com/views/checklogin.php?cookieCheck=true');
			cookieXHR.send(); 