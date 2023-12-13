<?php 
    /* Include config page */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="<?php echo URL;?>img/gsStickerBig1.png"> -->
    <link rel="icon" href="<?php echo URL;?>img/gospelscout_logo.png">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <!-- <link href="../../../../dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo URL; ?>Composer1/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Custom styles for GospelScout -->
    <link href="<?php echo URL; ?>css/custom.css" rel="stylesheet">



    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <script src="<?php echo URL; ?>js/jquery-1.11.1.min.js"></script>
  </head>

  <body class="text-center">
    <form class="form-signin" name="form-signin" method="post">
      <img class="mb-4" src="<?php echo URL;?>img/gospelscout_logo.png" alt="" width="150" height="150">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="sEmailID" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="sPassword" id="inputPassword" class="form-control" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-gs btn-block" id="adminSignin" type="button">Sign in</button>
      <span id="loadlogin"></span> 
      <?php 
        $year = date_create();
        $currentYear = $year; 
        $currentYear = date_format($currentYear, 'Y');
        date_sub($year,date_interval_create_from_date_string("1 years"));
        $lastYear = date_format($year, 'Y');
      ?>
      <p class="mt-5 mb-3 text-muted">&copy; <?php echo $lastYear;?>-<?php echo $currentYear;?></p>
    </form>
    
    <!--<script src="<?php echo URL;?>js/jsFunctions.js"></script>-->
    <script>
      /* User Login */
          $('#adminSignin').on('click', function (e) {
          	/* show Loading Spinwheel 
          		let action = 'show';
			displayLoadingPage(action);*/
          
            var email = $('input[type=email]').val();
            var pword = $('input[type=password]').val();

            if(email == ''){
              $('#loadlogin').html("Please enter email");
            }/*else if($('#sEmailID').val() != '' && !ValidateEmail($('#sEmailID').val())){
              $('#loadlogin').html("Please enter valid email");
            }*/
            else if(pword == ''){
              $('#loadlogin').html("Please enter password");
            }else{ 
                $('#loadlogin').html('');
                e.preventDefault();
                
                var formInfo = document.forms.namedItem('form-signin');
                
                var credentials = new FormData(formInfo);

                var checkLogin = new XMLHttpRequest(); 
                checkLogin.onreadystatechange = function(){
                  if(checkLogin.status == 200 && checkLogin.readyState == 4){
                  	/* hide Loading Spinwheel 
          			let action = 'show';
				displayLoadingPage(action);*/
                  	
                    var data = checkLogin.responseText.trim();
			console.log(data);
                    if(data == 'Please check your email or password' || data =='Please enter your email and password'){
                      $('#loadlogin').html(data);
                    }else if(data == 'admin'){
                      window.location = "concept-master/index.php"; 
                    }else if(data == 'deactive'){
                      $('#loadlogin').html("Your account is deactivated. Please contact us to activate your account.");
                    }else{
                       $('#loadlogin').html("Please provide administrator credentials");
                    } 
                  }
                }      
                checkLogin.open('POST', '<?php echo URL;?>views/checklogin.php');
                checkLogin.send(credentials); 
            }
          });
        /* END - User Login */
    </script>
  </body>
</html>
