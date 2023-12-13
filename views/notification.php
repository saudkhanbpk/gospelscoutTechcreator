<!doctype html>
<html lang="en">
<?php 
  /* Require the Header */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
  /* Create DB connection to Query Database for Artist info */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

  /*
    1. query the notification master for rows where the notifiedID match the currentUserID and and the viewed status is 0
    2. When suggested gigs is clicked, query the the postedgigsmaster for rows where the criteria matches that consistent with the current user's profile
        query for the following: 
          a. gig pay - minimum pay artist will accept
          b. artist type - artist's talents
          c. age minimum - artist's age
          d. years of experience minimum - artist's years of experience
          e. location(state, city, zip) - artist's location
    3. When Gig Inquiries is click query giginquirymaster for all inquiries to gigs current artist has posted
    4. When Gig Submissions is clicked query gigsubmissionsmaster to retrieve all gigs that current artist has submitted for 
  */

  if($currentUserID != ''){
    /* store userid to fecth from notification backbone */
      echo '<input type="hidden" name="iLoginID" value="' . $currentUserID . '">';

    /* Query the notificationmaster for rows where the notifiedID match the currentUserID and and the viewed status is 0 */ 
    $table1 = 'notificationmaster';
    $cond1 = 'notifiedID = ' . $currentUserID; //= $obj->fetchRowAll($table1, $cond1);
    $getNewNotificationsQuery = 'SELECT usermaster.sFirstName, usermaster.sLastName, usermaster.sUserType, usermaster.sGroupName, usermaster.sChurchName, usermaster.sProfileName, notificationmaster.*,notificationtypemaster.notificationDescription
                                 FROM notificationmaster
                                 INNER JOIN notificationtypemaster on notificationtypemaster.notificationName = notificationmaster.action
                                 INNER JOIN usermaster on usermaster.iLoginID = notificationmaster.notifierID
                                 WHERE notificationmaster.notifiedID = :notifiedID AND notificationmaster.viewed = 0';

    try{
      $getNewNotifications = $db->prepare($getNewNotificationsQuery);
      $getNewNotifications->bindParam(":notifiedID", $currentUserID);
      $getNewNotifications->execute(); 
      $getNewNotificationsResults = $getNewNotifications->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      echo $e; 
    }
  }
  else{
    echo '<script>window.location = "'. URL .'index.php";</script>';
    exit;
  }
  
?>
  <head>
    <style>
      .active,.nav-link:hover {
        background-color: rgba(149,0,173,1);
      }        
    </style>
  </head>
 
  <body class="bg-light">
    <main role="main" class="container">
      <div class="nav-scroller box-shadow mt-5 bg-gs">
        <nav class="nav nav-underline">
          <a class="nav-link active text-white" href="notification.php">Activity <span class=""></span></a>
          <a class="nav-link text-white useBackBone1" id="gigInqu" href="#">Gig Inquiries <span class=""></span></a>
          <?php if($currentUserType == 'artist' || $currentUserType == 'group'){?>
	          <a class="nav-link text-white useBackBone1" id="gigSugg" href="#">Gig Suggestions<span class=""></span></a>
	          <a class="nav-link text-white useBackBone1" id="gigSubm" href="#">Gig Submissions <span class=""></span></a>
	  <? }?>
        </nav>
      </div>

      <div class="my-3 p-3 bg-white rounded box-shadow" id="infoDisplay" style="min-height:400px;">
        <h6 class="border-bottom border-gray pb-2 mb-0">Recent Notifications</h6>
          <?php 
            if($getNewNotificationsResults){
              foreach($getNewNotificationsResults as $newNotification){
          ?>
                <div class="media text-muted pt-3">
                  <img src="<?php echo URL; ?>img/gsStickerBig1.png" alt="test" height="40px" width="40px" class="mr-2 rounded">
                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <a href="<?php echo URL;?>views/artistprofile.php?artist=<?php echo $newNotification['notifierID'];?>" target="_blank" class="d-block">
                      <strong class="text-gs text-gray-dark">
                        <?php 
                          if($newNotification['action'] == 'suggestGig'){
                            echo 'New Gig Suggestion';
                          }
                          elseif($newNotification['sUserType'] == 'group'){
                             echo $newNotification['sGroupName'];
                          }
                          elseif($newNotification['sUserType'] == 'church'){
                             echo $newNotification['sChurchName'];
                          }
                          else{
                            echo $newNotification['sFirstName'] . ' ' . $newNotification['sLastName'];
                          }
                        ?>
                      </strong>  <span class="font-weight-bold" style="font-size: 12px;color:rgba(149,73,173,.7)"><?php ageFuntion($newNotification['dateTime']);?></span>
                    </a>
                    
                    <?php 
                      echo $newNotification['notificationDescription'] . '<a href="' . $newNotification['link'] . '" class="useBackBone viewNotification" notID="' . $newNotification['id'] . '" link="' . $newNotification['link'] . '" class="text-gs"> View</a>';
                    ?>
                  </p>
                </div>
          <?php 
              }
            }
            else{
              echo '<div class="container my-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1);padding: 100px 0 100px 0">No New Notifications!!!</h1></div>';
            }
          ?>
      </div>
    </main>

    <?php 
      /* Include the footer */ 
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
    ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!--
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
    <script src="../../../../assets/js/vendor/holder.min.js"></script>
  -->
    <script src="<?php echo URL;?>js/offcanvas.js"></script>
    <script>
      $('.nav-link').click(function(event){
          $('.nav-link').removeClass('active');
          $(this).addClass('active');

      });

      /**** Create function for xml http request ****/
        function useBackbone(getVar,newLocal){
          
          /* New XML Http Request */
            var queryBackbone = new XMLHttpRequest(); 
            queryBackbone.onreadystatechange = function(){
              if(queryBackbone.readyState == 4 && queryBackbone.status == 200){
                if(queryBackbone.responseText){
                  if(newLocal == 'none'){
                    $('#infoDisplay').html(queryBackbone.responseText);
                  }
                  else{
                    window.location.href = newLocal;
                  }
                }
              }
            }
            queryBackbone.open('GET','<?php echo URL;?>views/xmlhttprequest/notificationBackbone.php?'+getVar);
            queryBackbone.send()
        }
      /* END - Create function for xml http request */

      /**** trigger function to mark notification as viewed and redirect to the appropriate page ****/
        $('.useBackBone').click(function(event){
            event.preventDefault();
            if($(this).hasClass('viewNotification')){
              var notificationID = $(this).attr('notID');
              var newLocal = $(this).attr('href');
              var getVar = 'notificationID='+notificationID+'&viewed=1';
              useBackbone(getVar,newLocal);
            }
            else if($(this).hasClass('viewSuggestion')){

            }
        });
      /* END - trigger function to mark notification as viewed and redirect to the appropriate page */

      /**** Call to the notificationBackbone.php page based on the tab selected ****/
        $('.useBackBone1').click(function(event){
          event.preventDefault();
          var action = $(this).attr('id');
          var iLoginID = $('input[name=iLoginID]').val();
          var getVar = action +'=1&iLoginID='+iLoginID;
          var newLocal = 'none';
          useBackbone(getVar,newLocal)
        });

      /* END - Call to the notificationBackbone.php page based on the tab selected */

    </script>
  </body>
</html>
