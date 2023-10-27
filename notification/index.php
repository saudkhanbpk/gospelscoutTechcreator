<?php 
  /* Require the Header */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
  /* Create DB connection to Query Database for Artist info */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

  /* Check that user is logged in */
    if($currentUserID == ''){
      echo '<script>window.location = "'. URL .'index.php";</script>';
      exit;
    }
?>
  <!--<head>-->
    <style>
      .active,.nav-link:hover {
        background-color: rgba(149,0,173,1);
      }        
    </style>
 <!-- </head>-->
 
  <!--<body class="bg-light">-->
    <main role="main" class="container" style="margin-top:100px;">
      <div class="nav-scroller box-shadow mt-5 bg-gs">
        <nav class="nav nav-underline">
          <a class="nav-link active text-white useBackBone1" id="recNot">Activity <span class=""></span></a>
          <?php if($currentUserType == 'artist'){?>
            <a class="nav-link text-white useBackBone1" id="gigSugg" href="#">Gig Suggestions<span class=""></span></a>
            <a class="nav-link text-white useBackBone1" id="gigSubm" href="#">Gig Submissions <span class=""></span></a>
          <?php }?>
          <a class="nav-link text-white useBackBone1" id="gigInqu" href="#">Gig Inquiries <span class=""></span></a>
        </nav>
      </div>

      <!-- Display Notifications -->
        <div class="my-3 p-3 bg-white rounded box-shadow" id="infoDisplay" style="min-height:400px;"></div>
    </main>

    <?php 
      /* Include the footer */ 
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
    ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo URL;?>notification/js/indexJSFunctions.js?13"></script>
    <script src="<?php echo URL;?>notification/js/indexJS.js?5"></script>
  </body>
</html>
