<!doctype html>
<html lang="en">
  <head>
    <?php 
      include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
      include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
   	?>

   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo URL;?>img/gsStickerBig1.png">

    <title>GospelScout Survey</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo URL; ?>Composer1/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Custom styles for GospelScout -->
    <link href="<?php echo URL; ?>css/custom.css" rel="stylesheet">

    <!-- <link href="../css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo URL; ?>glyphicon.css" rel="stylesheet">
    <link href="<?php echo URL;?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"> 

    <!-- JS library -->
    <script src="<?php echo URL; ?>js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>

    <style>
      body {
        background-color: #f5f5f5;
      }
    </style>
  </head>

  <body class="text-center">
    <div class="container mt-5 p-3">
      <div class="row">
        <div class="col-12">
          <img class="mb-2" src="<?php echo URL;?>img/gsStickerBig1.png" alt="" width="100" height="100">
        </div>
        <div class="col-12 text-gs"><h3>Artist Survey</h3></div>
      </div>