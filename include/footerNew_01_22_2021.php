<!-- FOOTER -->
	<?php 
	    $year = date_create();
	    $currentYear = $year; 
	    $currentYear = date_format($currentYear, 'Y');
	    date_sub($year,date_interval_create_from_date_string("1 years"));
	    $lastYear = date_format($year, 'Y');
	?>
	
      <footer class="container mt-3">
        <p class="float-right"><a href="#">Back to top</a></p>
        <!--<p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="<?php echo URL;?>views/terms.php">Terms</a></p>-->
        <p>
	        &copy; 2016-<?php echo $currentYear;?> GospelScout LLC 
	        &middot; <a href="<?php echo URL;?>views/privacy">Privacy</a> 
	        &middot; <a href="<?php echo URL;?>views/terms">Terms</a>
	        &middot; <a href="<?php echo URL;?>contactUs">Contact Us</a>
	        &middot; <a href="<?php echo URL;?>views/help">User Guide</a>
      	</p>
      </footer>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
   
    <script>window.jQuery || document.write('<script src="http://wwws.gospelscout.com/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="https://www.gospelscout.com/Composer1/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
   <!-- <script src="https://dev.gospelscout.com/twbs/bootstrap/assets/js/vendor/holder.min.js"></script> -->
   
    <script>
    /* User logout due to deactivation */
      var isActive = '<?php echo $isActive;?>';
      
      if(isActive == '0'){
          /* Trigger deactivation message modal */
            $('#acctDeactivated').modal('show');
      }

      $('#deact-logout').click(function(event){
          event.preventDefault();

          /* Call logOUt function */
            logOut(); 
      });
   </script>