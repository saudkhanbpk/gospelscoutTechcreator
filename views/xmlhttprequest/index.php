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
      <img class="mb-4" src="<?php echo URL;?>img/Gospelscout_logo.png" alt="" width="200" height="145.98">
      
      <?php 
        $year = date_create();
        $currentYear = $year; 
        $currentYear = date_format($currentYear, 'Y');
        date_sub($year,date_interval_create_from_date_string("1 years"));
        $lastYear = date_format($year, 'Y');
      ?>
      <p class="mt-0 mb-3 text-muted font-weight-bold">&copy; 2016-<?php echo $currentYear;?></p>
    </form>
  </body>
</html>
