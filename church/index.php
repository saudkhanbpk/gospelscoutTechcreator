<?php 
  /* Require the Header */
    //require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/header.php");
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
  /* Create DB connection to Query Database for Artist info */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
?>

<!-- Custom styles for headers on page with white background -->
  	<link href="<?php echo URL;?>home/css/header-adjustment.css" rel="stylesheet">
  
  <body class="text-center">

    <div class="container d-flex h-100 pt-3 px-3 mt-5 mx-auto flex-column">
     

      <main role="main" class="inner cover mt-5 pt-5" style="min-height:400px">
        <h1 class="cover-heading">Search 4 Churches.</h1>
        <p class="lead text-gs" style="font-weight: bold;">Coming Soon!!!</p>
        <p class="lead">
          <!-- <a href="#" class="btn btn-lg btn-secondary">Learn more</a> -->
        </p>
      </main>

     
    </div>

	<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
