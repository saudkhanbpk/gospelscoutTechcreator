$('#btn_login').on('click', function (e) {

  if($('#sEmailID').val() == ''){
    $('#loadlogin').html("Please enter email");
  }/*else if($('#sEmailID').val() != '' && !ValidateEmail($('#sEmailID').val())){
    $('#loadlogin').html("Please enter valid email");
  }*/
  else if($('#sPassword').val() == ''){
    $('#loadlogin').html("Please enter password");
  }else{ 
      $('#loadlogin').html('');
      e.preventDefault();
      
      var formData = $('#frmLogin').serialize();
      
      $.ajax({
      type: 'GET',
      url: '<?php echo URL;?>newHomePage/views/checklogin.php?fblogin=login',
      data: formData,
      success: function (data) {
          if(data == 'Please check your email or password'){
            $('#loadlogin').html(data);
          }else if(data == 'artist'){
          window.location = "<?php echo URL;?>newHomePage/views/artistprofile.php";  
          }else if(data == 'church'){
          window.location = "<?php echo URL;?>newHomePage/views/churchprofile.php";  
          }else if(data == 'user'){
          window.location = "<?php echo URL;?>newHomePage/views/useraccount.php";  
          }else if(data == 'deactive'){
          $('#loadlogin').html("Your account is deactivated. Please contact us to activate your account.");
          }
        }
      });       
  }
});

/* Log Out */
$('#logout').click(function(event){
  event.preventDefault(); 
  var logout = new XMLHttpRequest(); 
    logout.onreadystatechange = function(){
      if(logout.status == 200 && logout.readyState == 4)
      location.reload(); 
    }
    logout.open("GET", "logout.php");
    logout.send(); 
});   
/* END - Log Out */