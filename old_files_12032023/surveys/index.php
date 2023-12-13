<!doctype html>
<html lang="en">
  <head>
    <?php 
      include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo URL;?>img/gospelscout_logo.png">

    <title>GospelScout Survey</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo URL; ?>Composer1/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Custom styles for GospelScout -->
    <link href="<?php echo URL; ?>css/custom.css" rel="stylesheet">



    <!-- Custom styles for this template -->
    <link href="<?php echo URL;?>adminDashboard/signin.css" rel="stylesheet">

    <script src="<?php echo URL; ?>js/jquery-1.11.1.min.js"></script>
  </head>

  <body class="text-center">
    <form class="form-signin" name="form-signin" method="post" action="<?php echo URL;?>surveys/survey_artists.php">
      <!-- <img class="mb-4" src="<?php echo URL;?>img/gsStickerBig1.png" alt="" width="150" height="150"> -->
      <img class="mb-4" src="<?php echo URL;?>img/gospelscout_logo.png" alt="" width="150" height="150">
      <h4 class="text-gs mb-3 font-weight-bold">Please Enter an Email to Start the Survey</h4>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    
      <button class="mt-3 btn btn-lg btn-gs btn-block" id="adminSignin" type="submit">Take Survey</button>
      <span class="text-gs font-weight-bold" style="font-size:14px" id="loadlogin"></span> 
      <?php 
        $year = date_create();
        $currentYear = $year; 
        $currentYear = date_format($currentYear, 'Y');
        date_sub($year,date_interval_create_from_date_string("1 years"));
        $lastYear = date_format($year, 'Y');
      ?>
      <p class="mt-5 mb-3 text-muted">&copy; 2016-<?php echo $currentYear;?></p>
    </form>

    <script>
      /* User Login */
          $('#adminSignin').on('click', function (e) {
            e.preventDefault();
            var email = $('input[type=email]').val();
            var pword = $('input[type=password]').val();

            if(email == ''){
              $('#loadlogin').html("Please enter email");
            }
            else{
              var form = document.forms.namedItem('form-signin');
              var formD = new FormData(form);

              var emailCheck = new XMLHttpRequest(); 
              emailCheck.onreadystatechange = function(){
                if(emailCheck.status == 200 && emailCheck.readyState == 4){
                  /* Parse the json response */
                    respTxt = emailCheck.responseText.trim();
                    var parse_respTxt = JSON.parse(respTxt);

                  /* if repsonse is true "prevent Submit/display error", else "submit" */
                    if(parse_respTxt['exists'] == 'true'){
                      $('#loadlogin').html("We Have Already Received Your Input, Thank You So Much for Your Time!");
                    }
                    else{
                      /* Submit Form */
                        form.submit();
                    }
                }
              }
              emailCheck.open('post','<?php echo URL;?>surveys/emailCheck.php');
              emailCheck.send(formD);
            }

          });
        /* END - User Login */
    </script>
  </body>
</html>
